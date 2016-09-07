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
 * @since File available since Release 1.14
 */
//Add error handling
//Check site safe
stmImport('system.security.sitesafe');
stmImport('system.error.error');
stmImport('system.error.error_handle');
//Add document
stmImport('system.libraries.document.document');
//Add Database
stmImport('system.database.database');
//Create factory methods
stmImport('system.factory');
//Add Session methods
stmImport('system.session.session');
//Create Session handler methods
stmImport('system.session.sessionhandler');
//Initiate Session Handler
StmFactory::getSession();
//Check security
stmImport('system.security.security');
//Add Cache
stmImport('system.cache.cache');
//Add Upload file system
stmImport('system.filesystem.filesystem');
//Add PHP Mail system
stmImport('system.email.PHPMailerAutoload');
stmImport('system.email.mail');
//Add Orm
stmImport('system.orm');
//Add view Util
stmImport('system.libraries.viewUtil');
//Add template 
stmImport('system.libraries.document.template');
//Add Application
stmImport('system.application');
//Add form
stmImport('system.libraries.form');
//Add User
stmImport('system.user.user');
//Add Menu
stmImport('system.menu.menu');
//Add Helper
stmImport('system.helper');
//Add Access
stmImport('system.access');
//Initilize system
stmImport('system.init');
