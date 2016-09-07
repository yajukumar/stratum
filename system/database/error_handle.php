<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 * @Yaju
 * Custom error handling.
 */
	function customError( $error_level, $error_message, $error_file, $error_line, $error_context ){
		echo '['.$error_level.']'.$error_message.'; '.$error_file.'; '.$error_line;
	}
/* 
 * @category   Database
 * @package    STRATUM
 * @author     Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/

class DatabaseException extends Exception{
	//available Method
	public function getError(){
		if(StmConfig::$environment === 1) {
			$errorcode = explode('#',$this->getTraceAsString());
			$customerror = '<h2>Stratum Error Reporting</h2><hr style="color:#804040;" />';
			$errMsg = $customerror.'<b>Error msg:</b> '.$this->getMessage().'<hr style="color:#804040;" /><b>Error on file:</b> '
					.$this->getFile().'<hr style="color:#804040;" /><b>Error on line:</b> '.$this->getLine()
					.'<hr style="color:#804040;" /><b>Error Trace:</b> '.implode('<br/>', $errorcode).'<hr style="color:#804040;" />';
		} else {
			$errMsg =  'Site is on line.';
		}
		return '<div style=color:#CF2020;font-size:15px;>'.$errMsg.'</div>';
	}
}