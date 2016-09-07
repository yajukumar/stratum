<?php
defined( 'STRATUM' )or die('Forbidden');
$defaultview = StmViewUtil::getDefaultView();
StmFactory::getApplication()->setDocumentTitle('Home');
if(!StmFactory::getSession()->get('userid')) {
	?>
	<h1>Welcome to STRATUM</h1>
	<?php
	echo StmFactory::getApplication()->getGizmo('login');
}
else {
	StmFactory::getApplication()->redirect('view='.$defaultview[0]->view);
}

?>