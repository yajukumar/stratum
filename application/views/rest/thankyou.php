<?php  
$userid = StmFactory::getSession()->get('userid');
$user = StmFactory::getUser()->userdetail($userid);

	StmFactory::getSession()->set('breadcrumbs',array('Home'=>'#','Evaluations'=>'#','Thank You'=>''));
?>



<div class="content">

	<div class="thank-you" style="color:#555">
		<h3>Thank you <?php echo ucfirst($user['first_name']); ?>.</h3>
		<h4>Your evaluation has been submitted.</h4>
	</div>

</div>