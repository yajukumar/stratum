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
class ControllerUsergroup extends StmController{
	/*
	* Save User Group
	*/
	public function save() {
		StmFactory::getUser()->savegroupprofile($_POST);
		StmFactory::getApplication()->redirect('view=lgoin');
	}
}

?>