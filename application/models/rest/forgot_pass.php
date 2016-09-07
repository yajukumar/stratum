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
 * @author Mohneesh Bhargava <mohneesh@computerware.in>
 * @copyright 2014-2015
 * @license Read license.txt
 * @version 1.14
 * @since File available since Release 1.14
 */
 
/* 
 * @category   Model
 * @package    STRATUM
 * @author     Mohneesh Bhargava
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since 	   Class available since Release 2.14 
*/ 
class ModelForgot_pass extends StmModel{
	/*
	* Return Id if username is valid
	* Pass username in an array parameter
	*/
	public function authUsername($data)
	{
		$oDb 	= StmFactory::getDbo();
		$uid 	= trim($data['userid']);
		
		if($uid !=''){
			$query = "SELECT id FROM #_users
						WHERE username = '". $uid ."' 
						AND block = '0' ";
			$oDb->mysqlQuery($query);
			return $oDb->mysqlFetchObject()->id;
		}
	}
	/*
	* Check if security answers are correct or not
	* Pass user questions and answers in an array
	*/
	public function authUserAnswers($data)
	{
		$oDb 	= StmFactory::getDbo();
		//$user	= StmFactory::getUser();
		$answer	= $data['u_ans'];
		$question	= $data['user_q'];
	//check for answer .....
		foreach($answer as $key=>$ans){
			$query = "SELECT id FROM #_user_security_answers
						WHERE user_id = '". $data['user_id'] ."' 
						AND question_id = $question[$key] AND answer = '$ans' ";
			$oDb->mysqlQuery($query);
			if(sizeof($oDb->mysqlFetchObjectList()) < 1){
				return false;
			}
		}
		return true;
	}
	
	public function updatePassword($data)
	{
		$oDb 	= StmFactory::getDbo();
		$user	= StmFactory::getUser();
		$uid 	= $data['user_id'];
		$uDetail = $user->userdetail($uid);	
		
		$fName = ucwords($uDetail['first_name']);
		$MName = ucwords($uDetail['middle_name'])." ";
		$lName = ucwords($uDetail['last_name']);
		$email = $uDetail['email'];
	//** updating password in user table *//
		$user_password  = substr(str_shuffle($email).str_shuffle($fName),0,8);
		$password = STMSALT.$user_password;
		$password = md5($password);
		$userData['password'] = $password;
		$userData['id'] = $uid;
		
		$userid = $oDb->store('users','id',$userData);
		if($userid > 0 && $userid != ''){	
			// send mail to user
			$mail = StmFactory::getMailer();
			$recipient = $email;
			$emailFileName = 'forgot_pass';
			$aTags = array('{{FNAME}}','{{MNAME}}','{{LNAME}}','{{Password}}');
			$aTagsValue = array($fName, $MName,$lName, $user_password);
			$mail->sendMail($recipient, $emailFileName, $aTags, $aTagsValue, 'NO');
			return true;
		}
	}
}
?>