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
 * @author STRATUM <stratum.framework@gmail.com>
 * @copyright 2014-2015
 * @license Read license.txt
 * @version 1.14
 * @since File available since Release 1.14
 */
 stmImport('system.libraries.document.document');
 class StmTemplate extends StmDocument{
	protected $head		= NULL;
	public	  $endline	= "\n";
	public	  $linetab	= "\t";
	private	$currentView = NULL;
	
    public function getTemplate() {
        $oDb = StmFactory::getDbo();
		//check if view has any assigned template.
		$getViews = $this->getQueryString();
		if(count($getViews) === 0) {
			$defaultview = StmViewUtil::getDefaultView();
			$getViews['view'] = $defaultview[0]->view;
		}
		$this->currentView 	= $getViews['view'];
		$view				= $this->currentView;
		$oDb->mysqlQuery( "select TA.template_id AS TEMPLATE_ID from #_view AS V 
							JOIN #_template_assingment TA ON TA.view_id = V.id
							WHERE V.view ='$view' " );
		$templaterow = $oDb->mysqlFetchObject( );
		$where = "AND defaults='1'";
		if(count($templaterow) > 0 ){
			$templateid = $templaterow->TEMPLATE_ID;
			if($templateid > 0) {
				$where = " AND id='".$templateid."'";
			}
		}
        $oDb->mysqlQuery( "select * from #_template WHERE owner='site'  $where " );
        $row = $oDb->mysqlFetchObject( );
		try{
			if($row) {
				$template = $row->name;
			} else {
				throw new CustomException("Template not found.<br/><b>STRATUM Help:</b><br/>1. Check your 'applicaiton/template', is your template there?<br/>2. Check your '".StmConfig::$dbSuffix."template' database table, your template entry is there?");
			}
		}catch(CustomException $e ){
            echo $e->getError();
        }
        return $template;
    }
	
	public function templatePath() {
        return $this->getSiteUrl().'application/templates/'.$this->getTemplate().'/';
    }
	
	protected function templateHead() {
		//Include favicon
		try{
			if(!file_exists(TEMPLATE_ROOT_PATH.'/'.$this->getTemplate().'/favicon.ico')) {
				throw new CustomException("Favicon not found.<br/><b>STRATUM Help:</b><br/>1. Check under 'applicaiton/template/".$this->getTemplate()."/', is favicon.ico file exists? If that file not exists that directory, please put that file.'");
			}
		}catch(CustomException $e ){
            echo $e->getError();
        }
        $this->favicon = $this->endline.'<link rel="shortcut icon" href="'.TEMPLATE_ROOT_PATH.'/'.$this->getTemplate().'/favicon.ico" />';
		//include framework js and css
		$frameworkjs = 'system/javascript/';
		$frameworkgui = 'system/gui/';
		$getframework_js = scandir($frameworkjs);
		foreach($getframework_js as $fjs) {
			if($this->getExtension( $fjs ) === 'js'){
				$this->js .= $this->endline.'<script type="text/javascript" src="'.StmConfig::$livepath.'system/javascript/'.$fjs.'"></script>';
			}
		}
		
		$getframework_gui = scandir($frameworkgui);
		foreach($getframework_gui as $fgui) {
			if($this->getExtension( $fgui ) === 'css'){
				$this->style .= $this->endline.'<link rel="stylesheet" type="text/css" href="'.StmConfig::$livepath.'system/gui/'.$fgui.'">';
			}
		}
		
		//Include template js and css
		$get_style	= 'application/templates/'.$this->getTemplate().'/style/';
		$get_js 	= 'application/templates/'.$this->getTemplate().'/javascript/';
		
		$get_style = scandir($get_style);
		foreach($get_style as $styles) {
			if($this->getExtension( $styles ) === 'css'){
				$this->style .= $this->endline.'<link rel="stylesheet" type="text/css" href="'.StmConfig::$livepath.'application/templates/'.$this->getTemplate().'/style/'.$styles.'">';
			}		
		}
		
		$get_js = scandir($get_js);
		foreach($get_js as $javascripts) {
			if($this->getExtension( $javascripts ) === 'js'){
				$this->js .= $this->endline.'<script type="text/javascript" src="'.StmConfig::$livepath.'application/templates/'.$this->getTemplate().'/javascript/'.$javascripts.'"></script>';
			}
		}
	}
	
	protected function includeContentMVC() {
		$this->getApplicationlibrary();
		$getViews = $this->getQueryString();
		ob_start();
		//Import parent model
		stmImport('system.model');
		//import user model. First check in application's model,
		//If this model not found in application's model then search in core model
		if(isFileExists('application.models.'.$this->currentView)) {
			stmImport('application.models.'.$this->currentView);
		} else {
			stmImport('core.models.'.$this->currentView);
		}
		//check model class exists
		isClassExists('Model'.ucfirst($this->currentView));
		
		//import parent controller
		stmImport('system.controller');
		//import user controller. If this controller is not found in application's controllers
		//then search in core controllers.
		if(isFileExists('application.controllers.'.$this->currentView)) {
			stmImport('application.controllers.'.$this->currentView);
		} else {
			stmImport('core.controllers.'.$this->currentView);
		}
		//check controller class exists
		isClassExists('Controller'.ucfirst($this->currentView));
		//select veiw 
		if(strlen($getViews['action']) === 0) {
			//Give model object to controller
			$controller = new StmController;
			$model_	 = 'Model'.ucfirst($this->currentView);
			$controller->model = new $model_;
			$controller->view($this->currentView);
		} else {
			//user controller
			$usercontroller	 = 'Controller'.ucfirst($this->currentView);
			$usercontroller_ = new $usercontroller;
			$model_	 = 'Model'.ucfirst($this->currentView);
			$usercontroller_->model = new $model_;
			$usercontroller_->$getViews['action']();
		}
		$content = ob_get_contents();
		ob_end_clean();
		return $content;
	}
	
	protected function includeGizmo($gizmoPosition) {
		$view = $this->currentView;
		$oDb = StmFactory::getDbo();
			$oDb->mysqlQuery( "SELECT GIZMO.gizmo_name, GIZMO.id AS GID from #_gizmo_position AS GPOS
								JOIN #_gizmo_position_map AS GPOSMAP ON GPOSMAP.position_id = GPOS.id
								JOIN #_gizmos GIZMO ON GIZMO.id = GPOSMAP.gizmo_id
								JOIN #_view_gizmo_map  VGM ON  VGM.gizmo_id = GIZMO.id
								JOIN #_view  V on V.id = VGM.view_id
								WHERE GPOS.position_name='$gizmoPosition' and V.view = '$view' " );
	        $row = $oDb->mysqlFetchObjectList( );
			if(count($row) > 0) {
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
				foreach($row as $gizmoRow){
					if($this->checkGizmoAuthorization($gizmoRow->GID)) {

						try{
							if(!method_exists($appGizmo, $gizmoRow->gizmo_name)) {
								throw new CustomException("Gizmo do not exists.");
							}

						}catch(CustomException $e ){
							echo $e->getError();
						}
						$appGizmo->view = $gizmoRow->gizmo_name;
						$callGizmo = $gizmoRow->gizmo_name;
						echo $appGizmo->$callGizmo();
					
					}
				}
				$content = ob_get_contents();
				ob_end_clean();
				return $content;
			}
	}

	private function getApplicationlibrary() {
		if(is_dir('application/libraries/')) {
			$includeLibrary = 'application/libraries/';
			$getLibrary = scandir($includeLibrary);
			sort($getLibrary);
			if(count($getLibrary) > 0) {
				foreach($getLibrary as $libraryfile) {
					if($libraryfile !== 'index.html') {
						$libraryfile = explode('.', $libraryfile);
						$libraryfile = $libraryfile[0];
						if(strlen($libraryfile) > 4) {
							stmImport('application.libraries.'.$libraryfile);
						}						
					}
				}
			}
		}
	}
	
	private function checkGizmoAuthorization($gizmoId) {
		$oDb = StmFactory::getDbo();
		$oDb->mysqlQuery( "SELECT * FROM  #_gizmo_usergroup_map WHERE gizmo_Id='$gizmoId'" );
		$grow = $oDb->mysqlFetchObjectList( );
		if(count($grow) < 1) {
			return true;
		} else {
			$user = StmFactory::getUser()->userGroup();
			$userGroupId = $user->user_group_id;
			$oDb->mysqlQuery( "SELECT * FROM  #_gizmo_usergroup_map WHERE gizmo_Id='$gizmoId' AND user_group_id='$userGroupId' " );
			$grown = $oDb->mysqlFetchObjectList( );
			if(count($grown) > 0 ) {
				return true;
			}
		}
	}
 }