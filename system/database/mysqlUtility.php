<?php
defined( 'STRATUM' )or die('Forbidden');
if( file_exists( BASE_PATH.DS.'system'.DS.'database'.DS.'mysqlResult.php' ) ){
	require_once( BASE_PATH.DS.'system'.DS.'database'.DS.'mysqlResult.php' );
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
class mysqlUtility extends MysqlResult {
	public function realEscapeString($str) {	
		return mysql_real_escape_string($str);
	}
}