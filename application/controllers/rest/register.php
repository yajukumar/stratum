<?php
/* 
 * @category   User Management
 * @package    STRATUM
 * @author     Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/
class ControllerRegister extends StmController{
	
	public function register() {
			try {
				$post = $_POST;
				$post['password'] = rand(111111, 999999);
				$post['confirm_password'] = $post['password'];
				$post['user_group_id'] = '2';
				$post['username'] = $post['re_email'];
				if(validateFormToken($post['token'])){
					$userid = StmFactory::getUser()->addUser($post);
				}else{
					throw new CustomException("Invalid Token Value.");
				}
			} catch(CustomException $e ){
					echo $e->getError();
		 	}
		 	StmFactory::getApplication()->redirect('view=home');
	}
	
	public function checkDublicate() {
		$user = StmFactory::getUser()->isUserExist($_POST['thisemail']);
		if($user->users > 0 ) {
			echo '1';
		} else {
			echo '0';
		}
	}
	
}

?>