<?php
/* 
 * @category   Session
 * @package    STRATUM
 * @author     Mukesh Singh
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/

class StmSession extends Session
{
  private $alive = true;
  private $dbc = NULL;
 
  function __construct()
  {
    session_set_save_handler(
      array(&$this, 'open'),
      array(&$this, 'close'),
      array(&$this, 'read'),
      array(&$this, 'write'),
      array(&$this, 'destroy'),
      array(&$this, 'clean'));
 
    session_start();
  }
 
  function __destruct()
  {
    if($this->alive)
    {
      session_write_close();
      $this->alive = false;
    }
  }
 
  function delete()
  {
    if(ini_get('session.use_cookies'))
    {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
        $params['path'], $params['domain'],
        $params['secure'], $params['httponly']
      );
    }
 
    session_destroy();
 
    $this->alive = false;
  }
 
  private function open() {    
    $this->dbc = StmFactory::getDbo() OR die('Could not connect to database.');
    return true;
  }
 
  private function close() {
    return ;//$this->dbc->close();
  }
 
  private function read($sid) {
    $oDb = StmFactory::getDbo();
    $query = "SELECT data FROM #_sessions WHERE id = '".$oDb->realEscapeString($sid)."' LIMIT 1 ";
    $r = $oDb->mysqlQuery($query);
 
    if(count($r) == 1)
    {
      $fields = $oDb->mysqlFetchAssoc();
 
      return $fields['data'];
    }
    else
    {
      return '';
    }
  }
 
  private function write($sid, $data) {
    $oDb = StmFactory::getDbo();
    $query = "REPLACE INTO `#_sessions` (`id`, `data`) VALUES ('".$this->dbc->realEscapeString($sid)."', '".$this->dbc->realEscapeString($data)."')";
    $oDb->mysqlQuery($query);
    return $oDb->mysqlAffectedRows();
  }
 
  private function destroy($sid)
  {
    $q = "DELETE FROM `#_sessions` WHERE `id` = '".$this->dbc->realEscapeString($sid)."'"; 
    $this->dbc->mysqlQuery($q);
 
    $_SESSION = array();
 
    return $this->dbc->mysqlAffectedRows();
  }
 
  public function clean($expire)
  {
    $oDb = StmFactory::getDbo();
    $q = "DELETE FROM `#_sessions` WHERE DATE_ADD(`last_accessed`, INTERVAL ".(int) $expire." SECOND) < NOW()"; 
    $oDb->mysqlQuery($q);
   }
}
?>