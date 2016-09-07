<?php
StmFactory::getApplication()->setDocumentTitle('Login');
if(!StmFactory::getSession()->get('userid')) {
	echo StmFactory::getApplication()->getGizmo('login');
}
else {
	StmFactory::getApplication()->redirect('view=dashboard');
}

?>