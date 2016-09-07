<?php
StmFactory::getSession()->set('breadcrumbs', array('Home' => '#', 'Admin' => '#','Evaluations' => ''));

?>
<div class="header">
            <h3 class='title'>Evaluations</h3>
        </div>
<div class="content">
    <div class="evaluation_container">
        <table class="evaluation_table">
            <thead>
                <tr>
                    <!-- <th >#</th> -->
                    <th style="width:150px">Customer</th>
                    <th style="">Download spreadsheet</th>
                    <th style="">Submission date</th>
                    <th>Upload report</th>
                    <!-- <th>Upload Date</th> -->
                    <th>Functions</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($evaluations as $key => $evaluation) :?>
                <tr>
                    <!-- <td><?php //echo $key +1;?></td> -->
                    <td ><?php echo $evaluation['first_name']." ".$evaluation['last_name']; ?></td>
                    
                    <td><a style="color:#333" href="download.php?q=<?php echo urlencode('media/evaluations/'.'EE-'.$evaluation['user_id'].'-'.$evaluation['id'].'.xlsx'); ?>"><button data-id='<?php echo $evaluation["id"] ?>' class='download_disable'>Download</button></a>
                    </td>
                    
                    <td><?php echo date('d M,y',strtotime($evaluation['submitted_on'])) ; ?></td>
                    <td>
                        <form action="?view=admin&action=upload" method="POST" >
                        <button data-id='<?php echo $evaluation["id"] ?>' class='upload_button' data-status="<?php echo $evaluation['report_name'] != NULL ? '1' :'0' ; ?>">Upload</button><input type="hidden" name="uid" value="<?php echo $evaluation['user_id']; ?>"><input type="hidden" name="eid" value="<?php echo $evaluation['id']; ?>">
                        </form>
                        <?php if($evaluation['report_name'] != NULL) :               ?>
                                <p><a class="absolute" href="download.php?q=<?php echo urlencode('media/reports/'.$evaluation['report_name']); ?>">Download</a></p>
                                <p class="date"><?php echo date('d M,y',strtotime($evaluation['updated_on'])) ; ?></p>
                        <?php endif;?>
                    </td>
                     <?php //if($evaluation['report_name'] != NULL) :               ?>
                    <!-- <td><?php //echo date('d-m-y',strtotime($evaluation['updated_on'])) ; ?></td>
                <?php //else :?>
                    <td> - </td>
                <?php //endif; ?> -->

                    <td><p class="archive" data-eid="<?php echo $evaluation['id'] ;?>" ><label><i class="  glyphicon glyphicon-briefcase " title="Archive"></i> Archive</label></p>
                    <p class="remove" data-eid="<?php echo $evaluation['id'] ;?>"><label><i class=" remove glyphicon glyphicon-remove" title="Remove"></i> Remove</label></p>
                    </td>
                </tr>
            <?php endforeach;?>
               
            </tbody>
        </table>
    </div>
</div>


<script>
    $(document).ready(function(){


        $(".archive").click(function(){
          
            if($('.upload_button[data-id='+$(this).data('eid')+']').data('status') == 0 )
            {
                alert('You need to upload the report. ');
            }
            else
            {
          
                $.ajax({
                  type: "POST",
                  url: "?view=admin&action=archiveevaluation",
                  data: {'eid': $(this).data('eid')},
                  success: function(res)
                  {
                    location.reload();
                  }
                  
                });
              
            }
        })


        $(".remove").click(function(){

            if(confirm("Do you want to remove this evaluation?") )
            {

               $.ajax({
                  type: "POST",
                  url: "?view=admin&action=deleteevaluation",
                  data: {'eid': $(this).data('eid')},
                  success: function(res)
                  {
                    location.reload();
                  }
                  
                });
            }
        
            })
        
    })
</script>
