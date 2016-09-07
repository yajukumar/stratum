<?php
StmFactory::getSession()->set('breadcrumbs', array('Home' => '#', 'Admin' => '#','Archived Evaluations' => ''));

?>
<div class="header">
            <h3 class='title'>Archived Evaluations</h3>
        </div>
<div class="content">
    <div class="evaluation_container">
        <table class="evaluation_table">
            <thead>
                <tr>
                    <!-- <th >#</th> -->
                    <th style="width:155px">Customer</th>
                    <th>Download spreadsheet</th>
                    <th>Submission date</th>
                    <th>Download Report</th>
                    <th>Upload Date</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($evaluations as $key => $evaluation) :?>
                <tr>
                    <!-- <td><?php echo $key +1;?></td> -->
                    <td ><?php echo $evaluation['first_name']." ".$evaluation['last_name']; ?></td>
                     
                    <td><a style="color:#333" href="download.php?q=<?php echo urlencode('media/evaluations/'.'EE-'.$evaluation['user_id'].'-'.$evaluation['id'].'.xlsx'); ?>"><button data-id='<?php echo $evaluation["id"] ?>' class='download'>Download</button></a></td>
                    
                    <td><?php echo date('d M,y',strtotime($evaluation['submitted_on'])) ; ?></td>
                    
                    <td><a  style="color:#333" href="download.php?q=<?php echo urlencode('media/reports/'.$evaluation['report_name']); ?>"><button data-id='<?php echo $evaluation["id"] ?>' class='download'>Download</button></a></td></td>
                    <td><?php echo date('d M,y',strtotime($evaluation['updated_on'])) ; ?></td>
                </tr>
            <?php endforeach;?>
               
            </tbody>
        </table>
    </div>
</div>