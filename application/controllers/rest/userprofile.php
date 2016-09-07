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
class ControllerUserprofile extends StmController{
	/*
	* Save Staff(User) Profile of current logged in user
	*/
	public function save() {
		try {
			if(validateFormToken($_POST['token'])){
					StmFactory::getUser()->saveprofile($_POST);
					StmFactory::getApplication()->redirect('view=userprofile');
				}
			else{
				throw new CustomException("Invalid Token Value.");
			}
		} catch(CustomException $e ){
				echo $e->getError();
		 }
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