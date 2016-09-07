<?php
/* 
 * @category   User Management
 * @package    STRATUM
 * @author     Mukesh Singh
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/
class ControllerAdd_user extends StmController{
	
	/*
	* Add / Edit Staff(user)
	*/
	public function save(){
		try {
			if(validateFormToken($_POST['token'])){
				StmFactory::getUser()->addUser($_POST);
				StmFactory::getApplication()->redirect('view=add_user');
			}
			else{
				throw new CustomException("Invalid Token Value.");
			}
		} catch(CustomException $e ){
				echo $e->getError();
		}
	}
	
	/*
	* Check for availibility of username
	*/
	public function checkUserAvailability(){
		$post = cleanPost($_POST);
		if(StmFactory::getUser()->isUserExist($post['username'])->users > 0){ echo "<br/><div class='alert alert-danger'>Username Already Exists, Please Choose Another Username.</div>"; } else{ echo "<br/><div class='alert alert-success'>Username is Available.</div>"; }
	}
}

?>