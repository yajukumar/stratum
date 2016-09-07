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
abstract class StmFactory{

    private static $oDb         = NULL;
    private static $oCache  	= NULL;
    private static $template    = NULL;
    private static $application = NULL;
	private static $session		= NULL;
	private static $user		= NULL;
    private static $request     = NULL;
    private static $mailer      = NULL;
    private static $stmMail     = NULL;
    private static $helper      = NULL;
    private static $form      	= NULL;
    private static $orm			= NULL;

    public static function getDbo() {
		if (! self::$oDb  instanceof  Database) {
            $db = new Database;
            $db->mysqlDboCon();
            $db->mysqlDbSelect();
			self::$oDb = $db;
		} 
		return self::$oDb;
	}
	
	public static function getCache() {
		if (! self::$oCache  instanceof  StmCache) {
            $cache = new StmCache;
			self::$oCache = $cache;
		} 
		return self::$oCache;
	}
    public static function getTemplate() {
		if (! self::$template  instanceof  StmTemplate) {
            self::$template = new StmTemplate;
		} 
		return self::$template;
	}
    
    public static function getApplication() {
		if (! self::$application instanceof StmApplication) {
            self::$application = new StmApplication;
		} 
		return self::$application;
	}

	public static function getSession() {
		if (! self::$session instanceof StmSession) {
            self::$session = new StmSession;
		} 
		return self::$session;
	}
	
	public static function getUser() {
		if (! self::$user instanceof StmUser) {
            self::$user = new StmUser;
		} 
		return self::$user;
	}
  
    public static function getPhpMailer() {
		if (! self::$mailer instanceof PHPMailer) {
            self::$mailer = new PHPMailer;
		} 
		return self::$mailer;
	}
    
    public static function getMailer() {
		if (! self::$stmMail instanceof StmMailer) {
            self::$stmMail = new StmMailer;
		} 
		return self::$stmMail;
	}
    
    public static function getHelper() {
		if (! self::$helper instanceof StmHelper) {
            self::$helper = new StmHelper;
		} 
		return self::$helper;
	}

	public static function getForm() {
		if (! self::$form instanceof StmForm) {
            self::$form = new StmForm;
		} 
		return self::$form;
	}

	public static function getOrm() {
		if (! self::$orm instanceof StmOrm) {
            self::$orm = new StmOrm;
		} 
		return self::$orm;
	}
     
}