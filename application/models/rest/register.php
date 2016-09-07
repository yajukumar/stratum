<?php
/* 
 * @category   Model
 * @package    STRATUM
 * @author     Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since 	   Class available since Release 2.14 
*/ 
class ModelRegister extends StmModel{

	public function getIndustry($id=0) {
		$oDb 	= StmFactory::getDbo();
		if($id>0) {

		}
		$oDb->mysqlQuery("SELECT * FROM #_user_industry "." ORDER BY ordering ");
		return $oDb->mysqlFetchObjectList();
	}

	public function getOwnerShip($id=0) {
		$oDb 	= StmFactory::getDbo();
		if($id>0) {

		}
		$oDb->mysqlQuery("SELECT * FROM #_user_ownership "." ORDER BY ordering ");
		return $oDb->mysqlFetchObjectList();
	}
}

?>