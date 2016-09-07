<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 * Error handling for framework.
 * 
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
 
abstract class StmExceptions {
    private $message    = NULL;
    private $filename   = NULL;
    private $levels     = array(
                                E_ERROR				=>	'Error',
                                E_WARNING			=>	'Warning',
                                E_PARSE				=>	'Parsing Error',
                                E_NOTICE			=>	'Notice',
                                E_CORE_ERROR		=>	'Core Error',
                                E_CORE_WARNING		=>	'Core Warning',
                                E_COMPILE_ERROR		=>	'Compile Error',
                                E_COMPILE_WARNING	=>	'Compile Warning',
                                E_USER_ERROR		=>	'User Error',
                                E_USER_WARNING		=>	'User Warning',
                                E_USER_NOTICE		=>	'User Notice',
                                E_STRICT			=>	'Runtime Notice'
                                );
}
 
class CustomException extends Exception{
    //available Method
    public function getError(){
        //$errMsg = 'Error msg: '.$this->getMessage().'<br/>Error on file: '.$this->getFile().'<br/>Error on line: '.$this->getLine().'<br/>Error code: '.$this->getTraceAsString();
        //return '<div style=color:red;>'.$errMsg.'</div>';
        if(StmConfig::$environment === 1) {
        $errMsg = '<h2>Stratum Error Reporting</h2><hr style="color:#804040;" />';
		$errMsg .= '<b>Error Message:</b> '.$this->getMessage().'<hr style="color:#804040;" />';
        } else {
            $errMsg = 'Site is on line.';
        }
        return '<div style=color:red;>'.$errMsg.'</div>';
    }
}
 
 
?>