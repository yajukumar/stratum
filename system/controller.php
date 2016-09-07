<?php
/* 
 * Blog:http://stratumframework.blogspot.in/
 * Facebook: https://www.facebook.com/pages/Stratum/1374415309549296
 * Twitter: https://twitter.com/StratumFramwork
 *
 * @category   Controller
 * @package    STRATUM
 * @author     Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/

 class StmController{
	public $model = NULL;
	public $modelInstances = array();
//abstract Method
	//abstract protected function save();

	final public function getModel(){
		if (! $this->model instanceof  StmModel)	{
            $this->model  = new StmModel;
		} 
		return $this->model ;
	}
	
	final public function view($view, $optional) {
		foreach($optional as $key=>$argument) {
			$$key = $argument;
		}
		/** Old code
		if(isFileExists('application.views.'.$view)) {
			stmImport('application.views.'.$view);
		} else {
			stmImport('core.views.'.$view);
		}
		*/
		if(isFileExists('application.views.'.$view)) {
			require_once BASE_PATH.DS.'application'.DS.'views'.DS.$view.'.php' ;
		} else {
			require_once BASE_PATH.DS.'core'.DS.'views'.DS.$view.'.php' ;
		}
	}
	
	final public function getModelInstance($modelName){
	   $modelObject = '';
       $modelClassName = 'Model'.ucfirst($modelName);
       if(isFileExists('application.models.'.$modelName)) {
			require_once BASE_PATH.DS.'application'.DS.'models'.DS.$modelName.'.php';
		} else {
			require_once BASE_PATH.DS.'core'.DS.'models'.DS.$modelName.'.php';
		}
       //Check if hepler array have objects, if not then initiate object and store
       if(count($this->modelInstances) == 0) {
            $this->modelInstances[] = new $modelClassName;
       }

       //Check object stored or not
       if(count($this->modelInstances) > 0) {
            foreach($this->modelInstances as $oModel) {
                if ($oModel instanceof  $modelClassName) {
                    $modelObject = $oModel;
                }
            }
       }
       //Finallay we get object and return to caller.
       if(!is_object($modelObject)) {
            $modelObject = new $modelClassName;
			$this->modelInstances[] = $modelObject;
       }
       return $modelObject;
	}

	final protected function currentView() {
		return $_GET['view'];
	}

	final protected function currentAction() {
		return $_GET['action'];
	}


}
?>