<?php
StmFactory::getSession()->set('breadcrumbs', array('Home' => ''));
StmFactory::getApplication()->setDocumentTitle('My Profile');
$userid = StmFactory::getSession()->get('userid');
$model = $this->getModel();
?>
