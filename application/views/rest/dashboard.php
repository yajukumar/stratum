<?php
StmFactory::getSession()->set('breadcrumbs', array('Home' => ''));
StmFactory::getApplication()->setDocumentTitle('My Profile');
$userid = StmFactory::getSession()->get('userid');
$model = $this->getModel();
?>
<div class="content">
	<br/>
	<br/>
	<br/>
	<!-- <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur dignissim congue gravida. Donec dignissim, elit non suscipit congue, massa turpis semper sapien, eu ultrices libero orci quis purus. Sed nisl dolor, sodales vel volutpat commodo, lobortis ut augue. </p> -->
	<br/>
<?php if(count($model->getEvaluation($userid))> 0) { ?>
       &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?view=questionnaire&action=edit"><input class="btn btn-primary" type="submit" name="button" id="button" value="Continue Pending Evaluation"></a>
<?php } else { ?>
	&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="?view=questionnaire&action=form"><input class="btn btn-primary" type="submit" name="button" id="button" value="Begin New Evaluation"></a>
<?php } ?>
	 <br/>
	<br/>
	<br/>
	<br/>
</div>
