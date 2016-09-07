<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 * This php framework developed by Stratum.
 * Blog:http://stratumframework.blogspot.in/
 * Facebook: https://www.facebook.com/pages/Stratum/1374415309549296
 * Twitter: https://twitter.com/StratumFramwork
 * 
 * LICENSE: Read license.txt
 * 
 * @package STRATUM
 * @author STRATUM <stratum.framework@gmail.com><http://stratumframework.blogspot.in>
 * @copyright 2014-2015
 * @license Read license.txt
 * @version 13.5
 * @since File availabel since Release 13.5
 */

class StmForm{
	public $postError = array();
	public function validatePostData($post, $formFileName) {
		$formData = parse_ini_file('application/langs/'.$formFileName.'_form.ini');
		$aPostData = array();
		if(is_array($post)) {
			foreach($post as $key=>$postData) {
				$explodekey = explode(':', $key);
				if(strtolower($explodekey[1])=='required') {
					$cleandata = trim($postData);
					if(strlen($cleandata) < 1) {
						$this->postError[] = $formData[$explodekey[0]];
					} else {
						$aPostData[$explodekey[0]] = trim($postData);
					}
				} else {
					$aPostData[$key] = trim($postData);
				}
			}
		}
		return $aPostData;
	}

	public function checkPostError($redirectUrl) {
		if(count(($this->postError)) > 0) {
			StmFactory::getApplication()->setMessage(implode('<br/>',$this->postError), 'error');
			StmFactory::getApplication()->redirect($redirectUrl);
			exit;
		}
	}
}