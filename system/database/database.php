<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 * Create database class and extend with database lib.
 * You can add more function in this Database class for your use. 
 * But can not do any changes in MysqlResult class other database lib class.
 * This php databse framework developed by Yajukumar.
 * 
 * LICENSE: Read license.txt
 * 
 * @package STRATUM
 * @author Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright 2013-2015
 * @license Read license.txt
 * @version 1.13
 * @since File availabel since Release 1.13 
 */
//Getting database lib. 
if( file_exists( BASE_PATH.DS.'system'.DS.'database'.DS.'mysqlUtility.php' ) ){
	require_once( BASE_PATH.DS.'system'.DS.'database'.DS.'mysqlUtility.php' );
}
/* 
 * @category   Database
 * @package    STRATUM
 * @author     Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/

class Database extends mysqlUtility{

	function __construct(){
		$this->sHost    =   StmConfig::$host;
		$this->sUser    =   StmConfig::$dbUser;
		$this->sPass    =   StmConfig::$pass;
		$this->sDbName  =   StmConfig::$dbName;
	}
	//Add extra function for your use.
}

//Calling database class and methods
try{
	if( ! @class_exists( Database ) ){
		throw new DatabaseException('MysqlDatabase, this class do not exists.');
	}
}catch ( DatabaseException $e ){
	echo $e->getError();
}
