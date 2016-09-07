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
class ModelAdd_user extends StmModel{
	/*
	* Return List of Clinic Locations
	*/
	public function locationList(){
		$oDb = StmFactory::getDbo();
		$query = "SELECT * FROM #_clinic_location WHERE block = 0 order by title";
		$oDb->mysqlQuery($query);
		$locationList = $oDb->mysqlFetchObjectList();
		return $locationList;
	}

}

?>