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

 class StmApplication extends StmTemplate{
 	
 	private $contents 	= NULL;
	private $aGizmoName = array();
	
 	public function loadTemplate() {
        // Get the file content
        if( file_exists( BASE_PATH.DS.'application'.DS.'templates'.DS.$this->getTemplate().DS.'default.php' ) ){
            ob_start();
            require BASE_PATH.DS.'application'.DS.'templates'.DS.$this->getTemplate().DS.'default.php';
            $this->contents = ob_get_contents();
            ob_end_clean();
        }
		$this->getTemplateGizmos();
		$this->templateHead();
    }
	
	public function dispatchTemplate() {
		$this->contents = $this->setTemplateBody();
		$this->contents = $this->renderGizmo();
		$this->contents = $this->setTemplateHead();
		$this->contents = $this->setDocTitle();
		$this->contents = $this->displayMessage();
		return  $this->contents;
	}
	
	public function dispatchRawTemplate() {
		return  $this->includeContentMVC(); 
	}
	
	private function displayMessage() {
		$message = $this->getMessage();
		$this->contents = str_replace('<stmmessage>', $message , $this->contents);
		return $this->contents;
		
	}
	
	private function setDocTitle() {
		try{
			if(strlen( $this->documentTitle) =='') {
				throw new CustomException("Page Title not found.<br/><b>STRATUM Help:</b><br/>1. Check 'applicaiton/views/".$_GET['view'].".php'. Write this function StmFactory::getApplication()->setDocumentTitle('TITLE'); on the top of that file and pass title as function parameter.");
			}
		}catch(CustomException $e ){
            echo $e->getError();
        }
		$source=$this->contents;
		$startPoint	=	'<title>';
		$endPoint	=	'</title>';
		$newText=$this->documentTitle;
		$this->contents = preg_replace('#('.preg_quote($startPoint).')(.*)('.preg_quote($endPoint).')#si', '$1'.$newText.'$3', $source);
		return $this->contents;		
	}
	
	private function setTemplateHead() {
		foreach($this->aGizmoName as $key=>$gizmoName){
			if(trim(strtolower($gizmoName)) === 'head') {
				$headTag = trim($this->getStmTag($gizmoName));//<stm head />
				$head = $this->favicon.$this->style.$this->js;
				$this->contents = str_replace("$headTag", $head , $this->contents);
				unset($this->aGizmoName[$key]);
			}
		}
		return $this->contents;
	}
	
	private function renderGizmo() {
		foreach($this->aGizmoName as $key=>$gizmoName){
			if(trim(strtolower($gizmoName)) !== 'view' && trim(strtolower($gizmoName)) !== 'head') {
				$bodyTag = trim($this->getStmTag($gizmoName));//<stm body />
				
				$this->contents = str_replace("$bodyTag", $this->includeGizmo($gizmoName) , $this->contents);
				unset($this->aGizmoName[$key]);
			}
		}
		return $this->contents;
	}
	
	private function setTemplateBody() {
		foreach($this->aGizmoName as $key=>$gizmoName){
			if(trim(strtolower($gizmoName)) === 'view') {
				$bodyTag = trim($this->getStmTag($gizmoName));//<stm body />
				$this->contents = str_replace("$bodyTag", $this->includeContentMVC() , $this->contents);
				unset($this->aGizmoName[$key]);
			}
		}
		return $this->contents;
	}
	
	private function getTemplateGizmos() {
		preg_match_all('<stm .+ \/>i', $this->contents, $match);
		$getpos = '';
		foreach($match[0] as $s ){
			$getpos =  explode(' ',rtrim($s,'\/'));
			$this->aGizmoName[] = $getpos[1];
		}
	}
	
	private function getStmTag($gizmoName) {
		return  '<stm '.$gizmoName.' />';
	}
	
	public function getGizmo($gizmoName) {
		ob_start();
		//Import framework gizmo 
		stmImport('system.gizmo');
		//Check framework gizmo class
		isClassExists('StmGizmo');
		//Import core gizmo 
		stmImport('core.gizmos.gizmos');
		//Check core gizmo class
		isClassExists('CoreGizmo');
		//Import application gizmo 
		stmImport('application.gizmos.gizmos');
		//Check application gizmo class
		isClassExists('AppGizmo');
		if(! $appGizmo instanceof  StmTemplate) {
			$appGizmo = new AppGizmo;
		}
		try{
			if(!method_exists($appGizmo, $gizmoName)) {
				throw new CustomException("Gizmo do not exists.");
			}
		}catch(CustomException $e ){
			echo $e->getError();
		}
		$appGizmo->view = $gizmoName;
		$callGizmo = $gizmoName;
		$appGizmo->$callGizmo();
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	public function redirect($url) {
		$url = StmConfig::$livepath.'?'.$url;
		header("Location: $url");
		exit;
	}
	
	public function setMessage($msg, $msgType='success') {
		if($msgType==='success') {
			 $msg = '<div class="alert alert-success">'.$msg.'</div>';
		}
		if($msgType==='error') {
			 $msg = '<div class="alert alert-danger">'.$msg.'</div>';
		}
		StmFactory::getSession()->set('msg', $msg);
	}
	
	public function getMessage() {
		$getMsg = StmFactory::getSession()->get('msg');
		StmFactory::getSession()->set('msg', '');
		return $getMsg;
	}
 	
 }