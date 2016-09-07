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
class ModelAssign_view extends StmModel{
	
	/*
	* Assign View to User Groups
	*/
	function assignView($data){
		$oDb = StmFactory::getDbo();
		
		// save usergroup map
		$query = "DELETE FROM #_access WHERE view_id = '". $data['view_id'] ."' ";
		$oDb->mysqlQuery($query);
		
		foreach($data['selectedGroups'] as $selectedGroup){
			$saveData = array();
			$saveData['view_id'] = $data['view_id'];
			$saveData['user_group_id'] = $selectedGroup;
			$viewUpdated = $oDb->store('access','id',$saveData);
		}
		
		// save gizmo map
		$query = "DELETE FROM #_view_gizmo_map WHERE view_id = '". $data['view_id'] ."' ";
		$oDb->mysqlQuery($query);
		
		foreach($data['selectedGizmos'] as $selectedGizmo){
			$saveGizmoData = array();
			$saveGizmoData['view_id'] = $data['view_id'];
			$saveGizmoData['gizmo_id'] = $selectedGizmo;
			$viewUpdated = $oDb->store('view_gizmo_map','id',$saveGizmoData);
		}
		
		StmFactory::getApplication()->setMessage('User Groups and Gizmos Assigned Successfully.');
		return true;
	}

}

?>