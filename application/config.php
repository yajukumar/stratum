<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 * Configuration for framework.
 * 
 * This php framework developed by Cware.
 * Blog:http://stratumframework.blogspot.in/
 * Facebook: https://www.facebook.com/pages/Stratum/1374415309549296
 * Twitter: https://twitter.com/StratumFramwork
 * 
 * LICENSE: Read license.txt
 * 
 * @package STRATUM
 * @author STRATUM <stratum.framework@gmail.com>
 * @copyright 2014-2015
 * @license Read license.txt
 * @version 1.14
 * @since File available since Release 1.14
 */
 
 abstract class StmConfig {
    public static $environment 	= 1;		// 1=development, 0= production, 2= offline
    public static $host 		= 'localhost';
    public static $debug    	= 0; 		// 1=yes, 0=no
    public static $livepath     = "http://localhost/yajukumar/stratum-framework/version-2/development/";       //Site url
	public static $siteName 	= 'Stratum';
	public static $addSiteName 	= 1;//Add site name in title 1=yes, 0= no
	public static $copyright 	= 'Copyright 2015@ Stratum';//This will add in site footer
//============================Logging
	public static $log_file 	= 'logs/logs.txt';
//============================Database Setting
	public static $dbUser 		= 'root';
    public static $pass 		= '';
    public static $dbName 		= 'stratum_v2';
    public static $dbSuffix 	= 'stm_';
//============================Email Setting
	public static $addReplyToName = 'Stratum';
	public static $addReplyToEmail = 'stratum.framework@gmail.com';
	public static $mailFromEmail = 'stratum.framework@gmail.com';
	public static $mailFromName = 'Stratum';
	public static $mailDisclaimer = 'This is an automated email sent from Stratum. Please do not reply to it.';//This append in emails
	public static $phpMailFunction = '1';//By default enable. 1=Off, 0=On
//Smpt Setting. If $smtpMail is on then $phpMailFunction should be off.
	public static $smtpMail			= '0';//By default off. 1=Off, 0=On
	public static $smtpPort			= '465';
	public static $smtpHost			= 'smtp.gmail.com';
	public static $smtpSMTPAuth		= 'true';
	public static $smtpUsername		= 'yajuvendra@computerware.in';
	public static $smtpPassword		= 'yajukumar';
	public static $smtpSMTPSecure	= 'ssl';
	public static $smtpDebug = 2; // debugging: 1 = errors and messages, 2 = messages only
//============================User Registration	Setting
	public static $userRegistration = '0';//By default enable. 1=Off, 0=On
	public static $userActivation = '0';//By default enable. 1=Off, 0=On
	public static $randomPassword = '0';//By default enable. 1=Off, 0=On
//============================Cache Setting
	public static $caching 		= '0'; 		// 0 = no cache , 1 = server side cache, 2 = client side (browser) cache, 3 = both side cache
	public static $cache_time 	= '60'; 	// time in seconds
	public static $cache_root	= "tmp"; 	// path to the local folder, YOU NEED WRITE PERMISSIONS (chmod 666 or 777) to saving cache file
//=============================================================
 }