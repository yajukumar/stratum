<?php
StmFactory::getSession()->set('breadcrumbs', array('Home' => '#', 'Evaluations' => '#','My Evaluations' => ''));

?>
<div class="header">
            <h3 class='title'>My Evaluations</h3>
        </div>
<div class="content">
    <div class="evaluation_container">
        <table class="evaluation_table">
            <thead>
                <tr>
                    
                    
                    <th>Submission date</th>
                    <th>Download spreadsheet</th>
                    <th>Download Report</th>
                    <th>Upload Date</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($evaluations as $key => $evaluation) :?>
                <tr>
                     
                    <td><?php echo $evaluation['status']==0 ? 'Pending' : date('d M,y',strtotime($evaluation['submitted_on'])) ; ?></td>
                    <td>

                    <?php if($evaluation['status']==0 ) : ?>

                        <button data-id='<?php echo $evaluation["id"] ?>' class='download disable'>Download</button>
                    <?php else : ?>
                              
                        <a style="color:#333" href="download.php?q=<?php echo urlencode('media/evaluations/'.'EE-'.$evaluation['user_id'].'-'.$evaluation['id'].'.xlsx'); ?>" ><button data-id='<?php echo $evaluation["id"] ?>' class='download '>Download</button></a>
                                    
                 <?php   endif; ?>
                    </td>
                    <td>
                    <?php if($evaluation['report_status']==0 ) : ?>
                        <button data-id='<?php echo $evaluation["id"] ?>' class='download disable'>Download</button>
                    <?php else : ?>
                        <a style="color:#333" href="download.php?q=<?php echo urlencode('media/reports/'.$evaluation['report_name']); ?>"><button data-id='<?php echo $evaluation["id"] ?>' class='download '>Download</button></a>
                    <?php endif; ?>
                    </td>

                    <td><?php echo $evaluation['report_status']==0 ? 'Pending' : date('d M,y',strtotime($evaluation['updated_on'])) ; ?></td>
                </tr>
            <?php endforeach;?>
               
            </tbody>
        </table>
    </div>
</div>