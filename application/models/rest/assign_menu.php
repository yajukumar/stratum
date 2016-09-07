<?php
/* 
 * @category   Model
 * @package    STRATUM
 * @author     Mukesh
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since 	   Class available since Release 2.14 
*/ 
class ModelAssign_menu extends StmModel{
	
	/*
	* Assign Menu to User Groups
	*/
	function assignMenu($data){
		print_r($data);
		$oDb = StmFactory::getDbo();
		$query = "DELETE FROM #_menu_access WHERE menu_item_id = '". $data['menu_item_id'] ."' ";
		$oDb->mysqlQuery($query);
		foreach($data['selectedGroups'] as $selectedGroup){
			$saveData = array();
			$saveData['menu_item_id'] = $data['menu_item_id'];
			$saveData['user_group_id'] = $selectedGroup;
			$menuUpdated = $oDb->store('menu_access','id',$saveData);
		}
		StmFactory::getApplication()->setMessage('User Group Assigned Successfully.');
		return true;
	}

}

?>