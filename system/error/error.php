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
 //set error reporting
switch(StmConfig::$environment) {
    case 1:
        ini_set('error_reporting', E_ALL & ~ E_NOTICE & ~ E_WARNING );
        ini_set('log_errors',TRUE);
        ini_set('html_errors',TRUE);
        ini_set('error_log',StmConfig::$log_file);
        ini_set('display_errors',TRUE);
        break;
    case 0:
        ini_set('error_reporting', E_ERROR | E_WARNING);
    	ini_set('log_errors',TRUE);
        ini_set('html_errors',FALSE);
        ini_set('error_log',StmConfig::$log_file);
        ini_set('display_errors',FALSE);
    	break;
    default:
        break;
}