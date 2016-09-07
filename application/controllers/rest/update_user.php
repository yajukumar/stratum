<?php
/* 
 * @category   Controller
 * @package    STRATUM
 * @author     Mukesh Singh
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/
class ControllerUpdate_user extends StmController{
	/*
	* Ger Form to edit user
	*/
	public function Userform(){
		$modelAdd = $this->getModelInstance('add_user');
		$this->view('update_user', array('modelAdd'=>$modelAdd));
	}
	/*
	* Update user data
	* This function is used through Ajax
	*/
	public function save(){
		try {
			$post = array();
			parse_str($_POST['ajaxpost'], $post);
			
			foreach($dataString as $data){
				$dataArray = explode('=',$data);
				$post[$dataArray['0']]=$dataArray['1'];
			}
			if(validateFormToken($post['token'])){
				$userid = StmFactory::getUser()->addUser($post);
				$userdetail = StmFactory::getUser()->userProfileDetail($userid);
				echo "<a class='users' href='javascript:void(0)' id='". $userid ."' onclick='openModalBox(".$userid.")'>". ucwords($userdetail['first_name'])."</a>#".StmFactory::getApplication()->getMessage()."#". $userdetail['email']; exit;
			}
			else{
				throw new CustomException("Invalid Token Value.");
			}
		} catch(CustomException $e ){
				echo $e->getError();
		 }
	}
	/*
	* Delete an User
	*/
	public function delete_user(){
		try {
			if(validateFormToken($_POST['token'])){
				$userid = StmFactory::getUser()->deleteUser($_POST['userid']);
				echo '<div class="modal-header"><h3>Delete User</h3></div>';
				echo StmFactory::getApplication()->getMessage(); exit;
			}
			else{
				throw new CustomException("Invalid Token Value.");
			}
		} catch(CustomException $e ){
				echo $e->getError();
		 }
	}
}

?>