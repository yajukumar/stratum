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

class StmOrm{
	private $tableName = NULL;
	private $query = NULL;
	private $oDb = NULL;
	private $where = array();

	public function get($tableName) {
		$this->where = array();
		$this->tableName = $tableName;
		$this->query = "SELECT * FROM #_".$this->tableName." ";
		$this->oDb = StmFactory::getDbo();
		return $this;
	}

	public function delete() {
		$this->oDb->mysqlQuery($this->query);
		return true;
	}

	public function desc($columnname) {
		$this->query = $this->query. ' ORDER BY '. $columnname. ' DESC ';
		return $this;
	}

	public function asc($columnname) {
		$this->query = $this->query. ' ORDER BY '. $columnname. ' ASC ';
		return $this;
	}

	public function where($fieldName, $operator, $value, $and_or='') {
		$this->where[] = $and_or.' '.$fieldName.' '.$operator."'".$value."'";
		$where = (count($this->where)==1)? ' WHERE ' : '';
		$this->query = $this->query.' '.$where.' '.$and_or.' '.$fieldName.' '.$operator."'".$value."'";
		return $this;
	}

	public function first() {
		$this->oDb->mysqlQuery($this->query);
		return $this->oDb->mysqlFetchObject();
	}

	public function all() {
		$this->oDb->mysqlQuery($this->query);
		return $this->oDb->mysqlFetchObjectList();
	}

	public function findByPK($primeryKey) {
		$oDb = StmFactory::getDbo();
		$query = "SELECT * FROM #_".$this->tableName." WHERE ".$this->getPrimeryKey().'='."'".$primeryKey."'";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchObjectList();
	}

	private function getPrimeryKey() {
		$oDb = StmFactory::getDbo();
		$oDb->mysqlQuery("SHOW KEYS FROM ".StmConfig::$dbSuffix.$this->tableName." WHERE Key_name = 'PRIMARY'");
		$data = $oDb->mysqlFetchObject();
		return $data->Column_name;
	}
}
?>