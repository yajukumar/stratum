<?php
define( 'STRATUM', 1 );
/**
 * Very first file to start STRATUM
 * 
 * This php framework developed by Cware.
 * Blog:http://stratumframework.blogspot.in/
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
 * @since File available since Release 1.14
 */
if (version_compare(PHP_VERSION, '5.3.1', '<')){
	die('Your host needs to use PHP 5.3.1 or higher to run this version of STRATUM!');
}
define('BASE_PATH', __DIR__);
define('DS', DIRECTORY_SEPARATOR);
if( file_exists( BASE_PATH.DS.'system'.DS.'utility.php' ) ){
    require_once( BASE_PATH.DS.'system'.DS.'utility.php' );
}
//Load all define variable
stmImport('system.define');
ob_start();
//Load configuration
if( file_exists( CONFIG_PATH) ){
    require_once( CONFIG_PATH );
}
ob_end_clean();
//Initiate STRATUM bootstrap. This include core API of STRATUM
stmImport('system.bootstrap');



//Test end
StmFactory::getApplication()->loadTemplate();
echo StmFactory::getApplication()->dispatchRawTemplate();


//Load debug
if(StmConfig::$debug === 1) {
    if( file_exists( DEBUG_PATH) ){
        require_once( DEBUG_PATH );
    }
}

//print_r(StmFactory::getCache());
//$arr = array('','name'=>'default', 'owner'=>1);
//StmFactory::getDbo()->store('template', 'id', $arr);
