<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 *@author Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>  
 */

//load mysql driver
if( file_exists( BASE_PATH.DS.'system'.DS.'database'.DS.'mysqlDriver.php' ) ){
	require_once( BASE_PATH.DS.'system'.DS.'database'.DS.'mysqlDriver.php' );
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
class MysqlQuery extends MysqlDriver{

	protected $oMysqlCon      =   NULL;//Mysql connection Id
	protected $mysqlQuery     =   NULL;//Current mysql query
	protected $mysqlQueryResourceId = NULL;//Mysql query resource id after query execution.
	protected $logQuery       = NULL;

	/**
     * @author Yajuvendra
     * Get all database parameter.
     */
	function __construct(){

	}

	private function addSuffix() {
		$this->mysqlQuery = str_replace ('#_', StmConfig::$dbSuffix, $this->mysqlQuery );
	}

	/**
     * @author Yajuvendra
     * Recive a mysql query statement and pass to execute funtion.
     * @param a mysql Query statement.
     */
	public function mysqlQuery( $mysqlQuery ){
		if( !$this->oMysqlCon ){
			$this->mysqlDboCon();
		}
		$this->mysqlQuery    = $mysqlQuery;
		$this->addSuffix();
		unset( $mysqlQuery );
		return $this->mysqlExecuteQuery( );
	}

	/**
     * @author Yajuvendra
     * Execute mysql query statement.
     */
	private function mysqlExecuteQuery( ){
		$this->logQuery[]   =   $this->mysqlQuery;
		if( !function_exists('mysqli_query') ){
			throw new DatabaseException( 'Unable to execute mysql query' );
		}
		try{
			if( !( $this->mysqlQueryResourceId = @mysqli_query( $this->oMysqlCon, $this->mysqlQuery ))){
				// throw new DatabaseException( 'Unable to execute mysql query'
				// .' [ Query is: '.$this->mysqlQuery.']'.$this->mysqlErrorMessage() );
				throw new DatabaseException( 'Unable to execute mysql query.<br/>Query: <i>'.$this->mysqlQuery.'</i>');
			}
		}catch ( DatabaseException $e ){
			die($e->getError());
		}

		return $this->mysqlQueryResourceId;
	}


	/**
	 * @author Yajuvendra
	 * Log mysql query statement.
	 */
	private function mysqlLogQuery( ){
		return $this->logQuery;
	}


	/**
     * @author Yajuvendra
     * Return number of query executed in current script.
     */
	public function mysqlTotalQuery(){
		return count( $this->logQuery );
	}


	/**
     * @author Yajuvendra
     * Log mysql query statement.
     */
	public function mysqlLastQuery( ){
		$lastQuery  =   $this->mysqlTotalQuery();
		return $this->logQuery[$lastQuery-1];
	}

	public function mysqlLastInsertedId() {
		return mysql_insert_id();
	}


}//End of MysqlQuery class