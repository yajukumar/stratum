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
 
 
class StmMenu {

	function __construct() {
	  
	}
 
	function getAdminMenu() {
		$oDb = StmFactory::getDbo();
		$query = "SELECT * FROM #_menu ";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchAssoc();
	}

	function getAdminMenuItem($menuid=0) {
		$oDb = StmFactory::getDbo();
		if($menuid >0){
			$query = "SELECT * FROM #_menu_item WHERE menu_id = '". $menuid ."'";
		}
		else{
			$query = "SELECT * FROM #_menu_item ";
		}
		$oDb->mysqlQuery($query);
		$parentItem = $oDb->mysqlFetchObjectList();
		return $this->createChildMenu($parentItem, $parentId=0);
	}

	
	function getSiteMenu() {
		$oDb = StmFactory::getDbo();
		$query = "SELECT * FROM #_menu WHERE block = '0'";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchAssoc();
	}
	
	function getSiteMenuItem($menuid=0, $orderby='') {
		$oDb = StmFactory::getDbo();
		
		if($orderby!=''){
			$ordering = "ORDER BY ".$orderby."";
		}
		else{
			$ordering = "ORDER BY title";
		}
		
		if($menuid >0){
			$query = "SELECT * FROM #_menu_item WHERE block = '0' AND menu_id = '". $menuid ."' ".$ordering."";
		}
		else{
			$query = "SELECT * FROM #_menu_item block = '0' ".$ordering."";
		}
		$oDb->mysqlQuery($query);
		$parentItem = $oDb->mysqlFetchObjectList();
		return $this->createChildMenu($parentItem, $parentId=0);
	}
	
	function createChildMenu($arr, $parentId=0) {
		$allMenu = Array();
		foreach($arr as $cMenu)
		{
			if($cMenu->parent_id == $parentId)
			{
				$cMenu->child = isset($cMenu->child) ? $cMenu->child : $this->createChildMenu($arr, $cMenu->id);
				$allMenu[] = $cMenu;
			}
		}
		return $allMenu;
	}
	
	public function getParentMenu($childMenuName) {
		$oDb 	= StmFactory::getDbo();
		$query =	"	SELECT PARENT.id ".
						"	FROM `mcs_menu_item` as CHILD  JOIN  `mcs_menu_item` as PARENT ON PARENT.id=CHILD.parent_id ".
						"	WHERE CHILD.alias='".$childMenuName."' AND  CHILD.block = '0' " ;
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchObjectList();
	}
	
	/*
	* geting the menu by parent id
	*/
	function getSiteMenuItemByParentId($pId=0, $orderby='') {
		$oDb = StmFactory::getDbo();
		if($orderby!=''){
			$ordering = "ORDER BY ".$orderby."";
		}
		else{
			$ordering = "ORDER BY title";
		}
		$query = "SELECT * FROM #_menu_item WHERE block = '0' AND parent_id = '". $pId ."' ".$ordering." ";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchObjectList();
	}
/**
 * Check UserGroup has previlage to access this menu item
 * @param int $menuItemId Menu item id
 * @param int $userGroupId User Group id
 * @author Yajuvendra
 */
	public function getMenuLevelAccess($userGroupId, $menuItemId) {
		$oDb 	= StmFactory::getDbo();
		$oDb->mysqlQuery(" SELECT *  FROM #_menu_access WHERE user_group_id='$userGroupId' AND menu_item_id='$menuItemId' ");
		return $oDb->mysqlFetchObjectList();
	}

	public function getLeftMenuLevelAccess($userGroupId, $menuItemId) {
		$oDb 	= StmFactory::getDbo();
		$oDb->mysqlQuery(" SELECT *  FROM #_menu_access WHERE user_group_id='$userGroupId' AND menu_item_id='$menuItemId' ");
		if(count($oDb->mysqlFetchObjectList())) {
			$patientSelection = Factory::getApplication()->patientInEditMode();
			if($patientSelection) {
				return array('yes');
			}
		}
		return array();
	}
  
}
?>