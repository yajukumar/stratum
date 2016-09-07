<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 * This php framework developed by Cware.
 *  * Blog:http://stratumframework.blogspot.in/
 * Facebook: https://www.facebook.com/pages/Stratum/1374415309549296
 * Twitter: https://twitter.com/StratumFramwork
 * 
 * LICENSE: Read license.txt
 * 
 * @package STRATUM
 * @author Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright 2014-2015
 * @license Read license.txt
 * @version 1.14
 * @since File availabel since Release 1.14
 */
 
function stmImport($file_path) {
	$get_file_path = explode('.',$file_path);
	try{
        if(count($get_file_path) < 1) {
    		throw new Exception("File path not correct.");
    	} else {
    		 $make_file_path = implode(DS, $get_file_path);
    		if( file_exists( BASE_PATH.DS.$make_file_path.'.php' ) ){
    		    require_once( BASE_PATH.DS.$make_file_path.'.php' );
    		} else {
    			throw new Exception("Failed to import.");
    		}
    	}
     }catch(Exception  $e ){
            echo $e->getMessage().' '.$file_path.'<br/>';exit;
     }
}

function isFileExists($file_path) {
	$get_file_path = explode('.',$file_path);
    if(count($get_file_path) < 1) {
		throw new Exception("File path not correct.");
	} else {
		 $make_file_path = implode(DS, $get_file_path);
		if( file_exists( BASE_PATH.DS.$make_file_path.'.php' ) ){
			return true;
		} else {
			return false;
		}
	}
}

function isClassExists($className) {
    try{
    	if (!class_exists($className)) {
    		throw new CustomException("Class '".$className."'does not exists");
    	}
    }catch(CustomException $e ){
            echo $e->getError();
    }
}

function isDirectoryExists($directoryName) {
    try{
        if(is_dir($directoryName)) {
            return true;
        }
    }catch(CustomException $e ){
            echo $e->getError();
    }
}

function getForbidden() {
	header('HTTP/1.0 403 Forbidden');
	require_once 'application/templates/page_403.html';
    exit();
}
/*
* Generate Form Token
*/
function getFormToken($new = true) {//Pending for review
	// Write the generated token to the session variable to check it against the hidden field when the form is sent
	if($new === true || !StmFactory::getSession()->get('_token')){
		// generate a token from an unique value
		$token = md5(uniqid(microtime(), true));
		StmFactory::getSession()->set('_token', $token);
	} else { $token = StmFactory::getSession()->get('_token'); }

	return "<input type='hidden' name='token' id='token' value='". $token ."' />";
}
/*
* Validate Token
*/
function validateFormToken($token) {//Pending for review
    // check if a session is started and a token is transmitted, if not return an error
	if(!StmFactory::getSession()->get('_token')) { 
		return false;
    }
	
	// check if the form is sent with token in it
	if(!isset($token)) {
		return false;
    }
	
	// compare the tokens against each other if they are still the same
	if (StmFactory::getSession()->get('_token') !== $token) {
		return false;
    }
	
	return true;
}

function findTextBetweenTag($string, $start, $end){//Pending for review
        $pos = stripos($string, $start);
        $str = substr($string, $pos);
        $str_two = substr($str, strlen($start));
        $second_pos = stripos($str_two, $end);
        $str_three = substr($str_two, 0, $second_pos);
        $unit = trim($str_three); // remove whitespaces
        return $unit;
}

// Clear String, Remove special characters from a string
function clearString($string){//Pending for review
	$string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
	return $string;
}

// Validate for digits only
function validateInt($number){//Pending for review
	return preg_match("/[0-9]{1,}$/", $number);
}

// Validate Email
function validateEmail($email){//Pending for review
	if (!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/",$email)){
		return false;
	} else { return true; }
}

function getMysqlDate($date){//Pending for review
if($date){
	$myDateTime = DateTime::createFromFormat('m-d-Y', $date);
	return $myDateTime->format('Y-m-d');
	}
}

function getSiteDate($date){//Pending for review
	if($date != ''){
		$myDateTime = DateTime::createFromFormat('Y-m-d', $date);
		return $myDateTime->format('m-d-Y');
	}
}



/*Encrypt and Decrypt a string with salt key
* Params:	$action = 'encrypt' or 'decrypt'
*			$string = string to encrypt or decrypt
*/
function encrypt_decrypt($action, $string){//Pending for review
   $output = '';

   if( $action == 'encrypt' ){
		$string = STMSALT.$string;
		$output = base64_encode($string);
   }
   else if( $action == 'decrypt' ){
       $output = base64_decode($string);
	   $output = str_replace(STMSALT, '', $output);
   }
   return $output;
}

function stratumMessageAndExit($message){//Approved
	if(StmConfig::$environment === 1) {
	    $msg = '<h2>Stratum Reporting</h2><hr style="color:#804040;" />';
		$msg .= '<b>Sratum Says:</b> '.$message.'<hr style="color:#804040;" />';
	    echo  '<div style=color:red;>'.$msg.'</div>';
	}
    exit;
}
//============ Stratum Gloabal class approved ===

final class StratumGlobal {

	private $notAllowedInGet = array('select', 'from', 'union');
	private function setGetGlobal() {
		
		$queryStringFromUrl = array();
		$queryString = $_SERVER['QUERY_STRING'];
		if(strlen($queryString) > 0) {
			$queryString = explode('&', $queryString);
		}
		if(count($queryString) > 0) {
			foreach($queryString as $qString) {
				$q = explode('=', $qString);
				$q[0] = preg_replace('/[^A-Za-z0-9\-]/', '', $q[0]); // Removes special chars.
				$q[1] = preg_replace('/[^A-Za-z0-9\-]/', '', $q[1]); // Removes special chars.
				//print_r(array_intersect($this->notAllowedInGet));
				if(array_intersect(explode('2020',$q[0]), $this->notAllowedInGet)) { stratumMessageAndExit('Please check your url');}
				if(array_intersect(explode('2020',$q[1]), $this->notAllowedInGet)) { stratumMessageAndExit('Please check your url');}
				$queryStringFromUrl[$q[0]] = $q[1];
			}
		}
		$_SERVER['QUERY_STRING'] = '';
		$_GET = '';
		return $queryStringFromUrl;
	}

	public function getGet() {
		return $this->setGetGlobal();
	}

	private function setPostGlobal() {
		$stmPost = array();
		$post = $_POST;
		foreach ($post as $k => $v) {                  
			  if(!is_array($post[$k]) ) {       //checks for a checkbox array & so if present do not escape it to protect data from being corrupted.
				  if (ini_get('magic_quotes_gpc')) {      
						$v = stripslashes($v); 
					}               
					$v = preg_replace('/<.*>/', "", "$v");           //replaces html chars
					$stmPost[$k]= mysql_real_escape_string(trim($v));
					if(in_array($k, $this->notAllowedInGet)) { stratumMessageAndExit('Please check your url');}
					if(in_array($v, $this->notAllowedInGet)) { stratumMessageAndExit('Please check your url');}
				}
		 }
		 return $stmPost;
	}

	public function getPost() {
		return $this->setPostGlobal();
	}
}




/*
* Return View List
*/
function viewList(){//Pending for review
	$oDb = StmFactory::getDbo();
	$query = "SELECT * FROM #_view ORDER BY view";
	$oDb->mysqlQuery($query);
	return $oDb->mysqlFetchObjectList();
}
/*
* Return User Groups of selected view
*/
function viewUserGroups($viewid){//Pending for review
	$oDb = StmFactory::getDbo();
	$query = "SELECT user_group_id FROM #_access WHERE view_id = '". $viewid ."'";
	$oDb->mysqlQuery($query);
	$selectedGroups = array();
	foreach($oDb->mysqlFetchObjectList() as $group){
		$selectedGroups[]=$group->user_group_id;
	}
	return $selectedGroups;
}

/*
* Return Menu List
*/
function menuList(){//Pending for review
	$oDb = StmFactory::getDbo();
	$query = "SELECT * FROM #_menu_item ORDER BY title";
	$oDb->mysqlQuery($query);
	return $oDb->mysqlFetchObjectList();
}
/*
* Return User Groups of selected view
*/
function menuUserGroups($menuid){//Pending for review
	$oDb = StmFactory::getDbo();
	$query = "SELECT user_group_id FROM #_menu_access WHERE menu_item_id = '". $menuid ."'";
	$oDb->mysqlQuery($query);
	$selectedGroups = array();
	foreach($oDb->mysqlFetchObjectList() as $group){
		$selectedGroups[]=$group->user_group_id;
	}
	return $selectedGroups;
}

/*
* Return Gizmo List
*/
function gizmoList(){//Pending for review
	$oDb = StmFactory::getDbo();
	$query = "SELECT * FROM #_gizmos ORDER BY gizmo_name";
	$oDb->mysqlQuery($query);
	return $oDb->mysqlFetchObjectList();
}
/*
* Return User Groups of selected view
*/
function assignedGizmos($viewid){//Pending for review
	$oDb = StmFactory::getDbo();
	$query = "SELECT gizmo_id FROM #_view_gizmo_map WHERE view_id = '". $viewid ."'";
	$oDb->mysqlQuery($query);
	$assignedGizmos = array();
	foreach($oDb->mysqlFetchObjectList() as $gizmo){
		$assignedGizmos[]=$gizmo->gizmo_id;
	}
	return $assignedGizmos;
}