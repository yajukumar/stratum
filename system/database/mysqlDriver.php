<?php
defined( 'STRATUM' )or die('Forbidden');
//It is good to add exception class and function

/**
 *@author Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>  
 */

if( file_exists( BASE_PATH.DS.'system'.DS.'database'.DS.'error_handle.php' ) ){
	require_once( BASE_PATH.DS.'system'.DS.'database'.DS.'error_handle.php' );
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
class MysqlDriver{

	protected $sHost          =   NULL;//Database Host
	protected $sUser          =   NULL;//Database username
	protected $sPass          =   NULL;//Database password
	protected $sDbName        =   NULL;//Database name

	/**
     * @author Yajuvendra
     * Get all database parameter.
     */
	function __construct(){
		/**
        $this->sHost    =   'localhost';
        $this->sUser    =   'root';
        $this->sPass    =   '';
        $this->sDbName  =   'test';
        */
	}

	/**
	 * @author Yajuvendra
	 * Establise mysql connection and store in this class property
	 */
	public function mysqlDboCon(){
		try{
			if( function_exists('mysqli_connect') ){
				if( !($this->oMysqlCon   = @ mysqli_connect( $this->sHost, $this->sUser, $this->sPass ) ) ){
					throw new DatabaseException( 'Mysql connection not establised.');
				}
			}
		}catch ( DatabaseException $e ){
			die($e->getError());
		}

		return $this->oMysqlCon;
	}

	/**
     * @author Yajuvendra
     * Select database from current mysql connection
     */
	public function mysqlDbSelect(){
		try{
			if( !$this->oMysqlCon ){
				$this->mysqlDboCon();
			}
			if( !function_exists('mysqli_select_db') ){
				throw new DatabaseException( 'Database not selected.' );
			}
			if( !($mysqlDatabase = @mysqli_select_db($this->oMysqlCon, $this->sDbName))){
				throw new DatabaseException( 'Database not selected.' );
			}
		}catch ( DatabaseException $e ){
			die($e->getError());
		}
		return $mysqlDatabase;
	}

	/**
     * Method is protected, do not permit to use out of class.
     * @author Yajuvendra
     */
	protected function mysqlFreeResult(){
		if (is_resource($this->mysqlQueryResourceId)){
			mysql_free_result($this->mysqlQueryResourceId);
			$this->mysqlQueryResourceId = FALSE;
		}
	}

	/**
     * Method is protected, do not permit to use out of class.
     * @author Yajuvendra
     * Check whether mysql connection alive or not.
     */
	protected function mysqlConnected(){
		if (is_resource($this->oMysqlCon)) {
			return mysql_ping($this->oMysqlCon);
		}
		return FALSE;
	}

	/**
     * @author Yajuvendra
     */
	public function mysqlErrorNumber(){
		return mysql_errno($this->oMysqlCon);
	}

	/**
     * @author Yajuvendra
     */
	public function mysqlErrorMessage(){
		return mysql_error($this->oMysqlCon);
	}



	/**
     * @author Yajuvendra
     * Close all resources and free memory.
     */
	public function __destruct(){
		if (is_resource($this->oMysqlCon)) {
			mysql_close($this->oMysqlCon);
		}
	}
	
}//End of deriver class