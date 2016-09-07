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
 
 stmImport('system.url.url');
 class StmDocument extends StmUrl{
    protected $style	= NULL;
	protected $js 		= NULL;
	public $documentTitle = NULL;
	public $message = NULL;
	protected $favicon = NULL;
	
    private function test() {
        echo 'test';
    }
	
	public function getExtension( $filename ) {
		$extension = pathinfo($filename);
		return $extension[extension];
	}
	
	protected function addMeta() {
		
	}
	
	public function addStyle($filepath) {
		$this->style .=$this->endline.'<link rel="stylesheet" type="text/css" href="'.$filepath.'">';
	}
	
	public function addJavascript($filepath) {
		$this->js .=$this->endline.'<link type="text/javascript" src="'.$filepath.'"></script>';
	}
	
	public function setDocumentTitle($title) {
		 $this->documentTitle = (StmConfig::$addSiteName===1) ? StmConfig::$siteName.'::'.$title : $title;
	}
	
	protected function getQueryString() {
		return $_GET;
	}
	

 }