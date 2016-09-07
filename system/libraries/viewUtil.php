<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 * This php framework developed by Stratum.
 * Blog:http://stratumframework.blogspot.in/
 * Facebook: https://www.facebook.com/pages/Stratum/1374415309549296
 * Twitter: https://twitter.com/StratumFramwork
 * 
 * LICENSE: Read license.txt
 * 
 * @package STRATUM
 * @author STRATUM <stratum.framework@gmail.com><http://stratumframework.blogspot.in>
 * @copyright 2014-2015
 * @license Read license.txt
 * @version 13.5
 * @since File availabel since Release 13.5
 */

abstract class StmViewUtil{

	public static function getAllView() {
		$oDb = StmFactory::getDbo();
		$oDb->mysqlQuery('SELECT id, view  FROM #_view');
		$allview = $oDb->mysqlFetchObjectList();
		$getViews = array();
		foreach($allview as $views) {
			$getViews[$views->id] = $views->view;
		}
		return $getViews;
	}

	public static function getViewId() {
		$oDb = StmFactory::getDbo();
		if(strlen($_GET['view'])=='0') {
			$getDefaultView = self::getDefaultView();
			return $getDefaultView[0]->id;
		}
		$oDb->mysqlQuery('SELECT id, view  FROM #_view');
		$allview = $oDb->mysqlFetchObjectList();
		$getViews = array();
		foreach($allview as $views) {
			$getViews[$views->id] = $views->view;
		}
		if(in_array($_GET['view'],$getViews)) {
			return array_search($_GET['view'], $getViews);
		}	
	}

	public static function getPublicView($viewId) {
		if($viewId > 0) {
			$oDb = StmFactory::getDbo();
			$oDb->mysqlQuery("SELECT *  FROM #_access WHERE view_id='$viewId' ");
			$publicView = $oDb->mysqlFetchObjectList();
			return (count($publicView) > 0 )?  false : true;
		}
	}

	public static function getViewById($viewId) {
		if($viewId > 0) {
			$oDb = StmFactory::getDbo();
			$oDb->mysqlQuery("SELECT *  FROM #_access WHERE view_id='$viewId' ");
			return $oDb->mysqlFetchObjectList();
		}
	}

	public static function getDefaultView() {
		$oDb = StmFactory::getDbo();
		$oDb->mysqlQuery("SELECT id, view  FROM #_view WHERE home='0' ");
		$getDefaultView = $oDb->mysqlFetchObjectList();
		try{
			if(count($getDefaultView) > 1) {
				throw new CustomException("Two default view were found, that is not correct. You should declare only one default view.<br/><b>STRATUM Help:</b><br/>1. Check 'home' field in '".StmConfig::$dbSuffix."view' database table, we think more than one row has '0' value.");
			}
		}catch(CustomException $e ){
            echo $e->getError();
        }
		return $getDefaultView;
	}

	public static function getDashboardView() {
		$oDb = StmFactory::getDbo();
		$oDb->mysqlQuery("SELECT id, view  FROM #_view WHERE dashboard='0' ");
		$getDefaultView = $oDb->mysqlFetchObjectList();
		try{
			if(count($getDefaultView) > 1) {
				throw new CustomException("Two default view were found, that is not correct. You should declare only one default view.<br/><b>STRATUM Help:</b><br/>1. Check 'home' field in '".StmConfig::$dbSuffix."view' database table, we think more than one row has '0' value.");
			}
		}catch(CustomException $e ){
            echo $e->getError();
        }
		return $getDefaultView;
	}
}