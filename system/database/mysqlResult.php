<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 *@author Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>  
 */
//Load mysql query class
if( file_exists( BASE_PATH.DS.'system'.DS.'database'.DS.'mysqlQuery.php' ) ){
	require_once( BASE_PATH.DS.'system'.DS.'database'.DS.'mysqlQuery.php' );
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
class MysqlResult extends MysqlQuery{
	
	function __construct(){

	}
//Starts: Fetch Object    
	/**
     * @author Yajuvendra
     * Return a row from mysql query result 
     */    
	public function mysqlFetchObject( ){
		return mysql_fetch_object( $this->mysqlQueryResourceId );
	}
	
	/**
     * @author Yajuvendra
     * Return one row as object from mysql result.
     */
	public function mysqlFetchOneObject( ){
		if( $row = $this->mysqlFetchObject() ){
			$this->mysqlFreeResult();
			return $row;
		}
	}

	/**
     * @author Yajuvendra
     * Return an array of object. Each row is object of mysql query result.
     */
	public function mysqlFetchObjectList( ){
		$objectList = array();
		while( $row = $this->mysqlFetchObject() ){
				$objectList[] = $row;
			}
		$this->mysqlFreeResult();
		return $objectList;
	}
	
//End: Fetch Object    
//Starts: Fetch Associative array    
	/**
     * @author Yajuvendra
     * Return an array of associatative array.
     */
	public function mysqlFetchAssoc(){
		return mysql_fetch_assoc( $this->mysqlQueryResourceId );
	}

	/**
     * @author Yajuvendra
     * Return an array of associatative array.
     */
	public function mysqlFetchOneAssoc(){
		if( $row    =   $this->mysqlFetchAssoc() ){
			$this->mysqlFreeResult();
			return $row;
		}
	}

	/**
     * @author Yajuvendra
     * Return an array of associatative array.
     */
	public function mysqlFetchAssocList( ){
		$assocList = array();
		while( $row = $this->mysqlFetchAssoc() ){
				$assocList[] = $row;
			}
		$this->mysqlFreeResult();
		return $assocList;
	}
//Ends: Fetch Associative array    

//Starts: Fetch Array 
	/**
     * @author Yajuvendra
     */
	public function mysqlFetchArray(){
		return mysql_fetch_row( $this->mysqlQueryResourceId );
	} 

	/**
     * @author Yajuvendra
     */
	public function mysqlFetchOneArray(){
		if( $row    =   $this->mysqlFetchArray() ){
			$this->mysqlFreeResult();
			return $row;
		}
	} 

	/**
	 * @author Yajuvendra
	 */
	public function mysqlFetchArrayList(){
		$arrayList = array();
		while( $row = $this->mysqlFetchArray() ){
				$arrayList[] = $row;
			}
		$this->mysqlFreeResult();
		return $arrayList;
	}
//Ends: Fetch Array    

//Starts: Fetch row
//Ends: Fetch row
	/**
     * @author Yajuvendra
     */
	public function mysqlFetchRow(){
	   return  mysql_fetch_row($result);
	}

	public function mysqlAffectedRows() {
		return mysql_affected_rows();
	}
	/**
	 * @author Yajuvendra
	 */
	/**
     * This function insert and update dabase table row and return mysql object. Don't change this function definition, any change can effect com_an_user and com_collab
     * 
     * @param Database table name, primary key, and postdata
     * 
     * @author Yajuvendra
     * @access internal
     * @return Mysql object
     * @since  4/5/2013 1:19:41 
     * @version 1.0
     */
	
	public  function store($tableName, $primaryKey, $aData){
		$tableName = $this->getTableName($tableName);
		$loadData = $this->bindData($tableName, $primaryKey, $aData);
		try {
			// Insert the object into the user profile table.
			if($loadData->$primaryKey > 0) {
				$result = $this->updateObject($tableName, $loadData, $primaryKey);
				$id = $aData[$primaryKey];
			} else {
				$id = $this->insertObject($tableName, $loadData); 
			}
		} catch (Exception $e) {
			// catch any errors.
		}
		return $id;
	} 

	/**
	 * Don't change this function definition.
	 */
	public function getTableName($tableName) {
		return StmConfig::$dbSuffix.''.$tableName;
	}


	/**
	 * This function bind post and db table field and return std class object. 
	 * Don't change this function definition, 
	 * any change can effect com_an_user and com_collab
     * 
     * @param Database table name, primary key, and postdata
     * 
     * @author Yajuvendra
     * @access internal
     * @return std class object
     * @since  4/5/2013 1:19:41 
     * @version 1.0
     */

	public  function bindData($tableName, $primaryKey, $aData) {
		$loadData = array();
		$result = mysql_query("SHOW COLUMNS FROM $tableName");
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}
		if(isset($loadData[$primaryKey])) {
			$loadData[$primaryKey] = ($aData[$primaryKey] !='') ? $aData[$primaryKey] : '';	
		}
		if (mysql_num_rows($result) > 0) {
			while ($row = mysql_fetch_object($result)) {
				if(isset($aData[$row->Field]) ) {
					$fieldData = ($aData[$row->Field] !='') ? $aData[$row->Field] : '';
					if(isset($fieldData)) {
						$loadData[$row->Field] = $fieldData ;
					}
				}
			}
		}
		$loadData = (object) $loadData;
		return $loadData;
	}


	/**
	 * Inserts a row into a table.
	 */
	private function insertObject($table, &$object, $key = null) {
		$fields = array();
		$values = array();

		// Iterate over the object variables to build the query fields and values.
		foreach (get_object_vars($object) as $k => $v){
			// Only process non-null scalars.
			if (is_array($v) or is_object($v) or $v === null) {
				continue;
			}
			// Ignore any internal fields.
			if ($k[0] == '_'){
				continue;
			}
			// Prepare and sanitize the fields and values for the database query.
			$fields[] = $k;
			$values[] = $this->quote($v);
		}
		// Create the base insert statement.
	 	$query = 'INSERT INTO '.$table.' ('.implode(',', $fields).') values '.'('.implode(',', $values).')';
		// Set the query and execute the insert.
		$this->mysqlQuery($query);
		// Update the primary key if it exists.
		$id = $this->mysqlLastInsertedId();
		return $id;
	}

	/**
	 * Update a row into a table.
	 */
	private function updateObject($table, &$object, $key, $nulls = false){
		$fields = array();
		$where = array();
		if (is_string($key)){
			$key = array($key);
		}
		if (is_object($key)){
			$key = (array) $key;
		}
		// Create the base update statement.
		$statement = 'UPDATE ' . $this->quoteName($table) . ' SET %s WHERE %s';
		// Iterate over the object variables to build the query fields/value pairs.
		foreach (get_object_vars($object) as $k => $v){
			// Only process scalars that are not internal fields.
			if (is_array($v) or is_object($v) or $k[0] == '_'){
				continue;
			}
			// Set the primary key to the WHERE clause instead of a field to update.
			if (in_array($k, $key)){
				$where[] = $this->quoteName($k) . '=' . $this->quote($v);
				continue;
			}
			// Prepare and sanitize the fields and values for the database query.
			if ($v === null){
				// If the value is null and we want to update nulls then set it.
				if ($nulls){
					$val = 'NULL';
				}
				// If the value is null and we do not want to update nulls then ignore this field.
				else{
					continue;
				}
			}
			// The field is not null so we prep it for update.
			else{
				$val = $this->quote($v);
			}
			// Add the field to be updated.
			$fields[] = $this->quoteName($k) . '=' . $val;
		}
		// We don't have any fields to update.
		if (empty($fields)){
			return TRUE;
		}
		// Set the query and execute the update.
		return $this->mysqlQuery(sprintf($statement, 
				implode(",", $fields), implode(' AND ', $where)));
	}

	private function quote($text){
			//return '\'' .$text . '\'';
			return '\'' .addslashes($text) . '\'';
	}

	public function quoteName($name, $as = null) {
		if (is_string($name)) {
			$quotedName = $this->quoteNameStr(explode('.', $name));
			$quotedAs = '';
			if (!is_null($as)) {
				settype($as, 'array');
				$quotedAs .= ' AS ' . $this->quoteNameStr($as);
			}
			return $quotedName . $quotedAs;
		} else {
			$fin = array();
			if (is_null($as)) {
				foreach ($name as $str) {
					$fin[] = $this->quoteName($str);
				}
			} elseif (is_array($name) && (count($name) == count($as))) {
				$count = count($name);
				for ($i = 0; $i < $count; $i++) {
					$fin[] = $this->quoteName($name[$i], $as[$i]);
				}
			}
			return $fin;
		}
	}

	public function quoteNameStr($strArr) {
		$parts = array();
		$q = $this->nameQuote;

		foreach ($strArr as $part)
		{
			if (is_null($part))
			{
				continue;
			}

			if (strlen($q) == 1)
			{
				$parts[] = $q . $part . $q;
			}
			else
			{
				$parts[] = $q{0} . $part . $q{1};
			}
		}

		return implode('.', $parts);
	}

}//End of MysqlResult class