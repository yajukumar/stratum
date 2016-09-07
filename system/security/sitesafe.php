<?php
defined( 'STRATUM' )or die('Forbidden');
/**
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
 * @since File availabel since Release 1.14
 */
$stratumGlobal = new StratumGlobal;
//=== Stratum don't like index.php in url.
 if (strstr($_SERVER['REQUEST_URI'],'index.php')){
    header('HTTP/1.0 404 Not Found');
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
	//echo '<img src="media/forbidden.jpg />';
    exit();
}
//Stratum like to get blank GLOBAL VARIABLE like $_GET AND $_POST.
$_GET = $stratumGlobal->getGet();// Use this variable instead of $_GET
$_POST = $stratumGlobal->getPost();//Use this variable instead of $_POST

if(count($_GET) > 3) {
	getForbidden() ;
}
	 
if(count($_GET) < 4 && count($_GET) > 0 ) {
	$allow = array('view', 'action','param');
	foreach($_GET as  $key=>$query) {
		if(!in_array($key, $allow)) {
			getForbidden() ;
		}
	}
 }
 /**
 print_r($_SERVER['REQUEST_URI']);
 exit;
if (strstr($_SERVER['REQUEST_URI'],'index.php')){
    header('HTTP/1.0 404 Not Found');
    echo "<h1>404 Not Found</h1>";
    echo "The page that you have requested could not be found.";
    exit();
}
*/