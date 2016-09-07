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
 
 if($_GET['view']) {
	$oDb = StmFactory::getDbo();
	$oDb->mysqlQuery('SELECT view  FROM #_view');
	$allview = $oDb->mysqlFetchObjectList();
	$getViews = array();
	foreach($allview as $views) {
		$getViews[] = $views->view;
	}
	if(!in_array($_GET['view'],$getViews)) {
		stratumMessageAndExit('Please check your url. This view does not exists.');
	}
}