<?php
/* 
 * @category   Gizmo
 * @package    STRATUM
 * @author     Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/

class StmGizmo{

	public $view = NULL;
	public $model = NULL;
	
	public function getModel($modelName){
		$className = 'Model'.ucfirst($modelName);
		if(!class_exists($className)){
			stmImport('application.models.'.$modelName);
		}
		
		if (! $this->model instanceof  $className)	{
            $this->model  = new $className;
		} 
		return $this->model ;
	}
	
	public function view($optional) {
		foreach($optional as $key=>$argument) {
			$$key = $argument;
		}
		if( file_exists('application/gizmos/'.$this->view.'.php' ) ){
			include( 'application/gizmos/'.$this->view.'.php' );
		} else {
			if( file_exists('core/gizmos/'.$this->view.'.php' ) ){
				include( 'core/gizmos/'.$this->view.'.php' );
			}
		}
	}
}
?>