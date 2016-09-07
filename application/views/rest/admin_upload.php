<?php
StmFactory::getSession()->set('breadcrumbs', array('Home' => '#', 'Admin' => '#','Upload report' => ''));

?>
<?php echo StmFactory::getApplication()->getMessage(); ?>
<div class="header">
            <h3 class='title'>Upload Report</h3>
        </div>
<div class="content">

    <h3 class="upload_title"><?php echo ($evaluation['middle_name']!="" ? $evaluation['first_name']." ".$evaluation['middle_name']." ".$evaluation['last_name'] : $evaluation['first_name']." ".$evaluation['last_name'] ); ?></h3>
    <h5>Dated - <?php echo date("d M,y",strtotime($evaluation['submitted_on'])); ?></h5>
    <form action="?view=admin&action=upload" method="POST" enctype="multipart/form-data">
        <div class=" upload-form">

            <h3 class="sub-title">Upload PDF Document</h3>
        <?php if($evaluation['report_name'] != NULL) :               ?>
                <a href="media/reports/<?php echo $evaluation['report_name']; ?>" target="_BLANK"><?php echo $evaluation['report_name'] ; ?></a>
        <?php endif;?>
            <input type="file" class="" name="report"/>
        </div>
        <input type="hidden" name="uid" value="<?php echo $evaluation['user_id']; ?>" />
        <input type="hidden" name="eid" value="<?php echo $evaluation['id']; ?>" />
        <button type="submit" class="btn btn-primary btn-large upload">Save</button>
        <a href="?view=admin&action=evaluations" class="btn btn-warning btn-large " style="margin-top:29px;">Back</a>
    </form>
</div>