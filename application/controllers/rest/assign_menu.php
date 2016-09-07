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

class ControllerAssign_menu extends StmController{
	
	/*
	* Save assigned menu link
	*/
	public function save(){
		try {
			if(validateFormToken($_POST['token'])){
				$this->getModel()->assignMenu($_POST);
				StmFactory::getApplication()->redirect('view=assign_menu');
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