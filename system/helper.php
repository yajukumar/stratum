<?php
/* 
 * @category   Helper
 * @package    STRATUM
 * @author     Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/

class StmHelper{
	private $helper      = array();
    
	public function helper($helperName){
	   $helperObject = '';
       $helperClassName = ucfirst($helperName).'Helper';
	   require_once(  'application/helpers/'.$helperName.'.php'  );
       //Check if hepler array have objects, if not then initiate object and store
       if(count($this->helper) == 0) {
            $this->helper[] = new $helperClassName;
       }

       //Check object stored or not
       if(count($this->helper) > 0) {
            foreach($this->helper as $help) {
                if ($help instanceof  $helperClassName) {
                    $helperObject = $help;
                }
            }
       }
       //Finallay we get object and return to caller.
       if(!is_object($helperObject)) {
            $helperObject = new $helperClassName;
			$this->helper[] = $helperObject;
       }
       return $helperObject;
	}

}
?>