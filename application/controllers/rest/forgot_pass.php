<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 * This php framework developed by Cware.
 *  * Blog:http://stratumframework.blogspot.in/
 * Facebook: https://www.facebook.com/pages/Stratum/1374415309549296
 * Twitter: https://twitter.com/StratumFramwork
 * 
 * LICENSE: Read license.txt
 * 
 * @package STRATUM
 * @author Mohneesh Bhargava <mohneesh@computerware.in>
 * @copyright 2014-2015
 * @license Read license.txt
 * @version 1.14
 * @since File available since Release 1.14
 */
 
 
class ControllerForgot_pass extends StmController{
	/*
	* Check if user exists
	*/
	public function checkUserId() {
		$model = $this->getModel();
		if($model->authUsername($_POST) > 0){
			$uid = $model->authUsername($_POST);
			$this->view('forgot_pass_update', array('uid'=>$uid));
		}
		else{
			StmFactory::getApplication()->setMessage('No matching record found !', 'error' );
			$this->view('forgot_pass');
		}
	}
	/*
	* Send Mail to user with new random password
	*/
	public function sendPassword() {
		$model 		= $this->getModel();
		$post = array();
		if($model->authUsername($_POST) > 0){
			$uid = $model->authUsername($_POST);
			$data['user_id'] = $uid;
			$model->updatePassword($data);
			StmFactory::getApplication()->setMessage('Your password has been sent successfully. Please check your registered email.' );
			StmFactory::getApplication()->redirect('view=home');
		}else{
			StmFactory::getApplication()->setMessage('No matching record found !', 'error' );
			$this->view('forgot_pass');
		}
	}
	
}
?>