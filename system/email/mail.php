<?php
//http://phpmailer.worxware.com/?pg=methods
class StmMailer {
	private $yMailer 				= NULL;
	private $recipient 				= NULL;
	private $emailFileName 			= NULL;
	private $tags					= NULL;
	private $tagsvalue  			= NULL;
	public $fromEmail				= NULL;
	public $fromName				= NULL;
	public $disclaimer				= NULL;
	public $cc						= NULL;
	public $bcc						= NULL;

	function __construct() {
		$this->yMailer =  StmFactory::getPhpMailer();
	}
	
	private function setBCC($bcc) {
		if($bcc ==''){
			//stratumMessageAndExit('BCC can not be blank.');
		}
		$this->bcc =trim($bcc);
	}

	private function setCC($cc) {
		if($cc ==''){
			//stratumMessageAndExit('CC can not be blank.');
		}
		$this->cc =trim($cc);
	}

	private function setRecipient($recipient) {
		$recipient = trim($recipient);
		if($recipient ==''){
			throw new CustomException('Recipient can not be blank.');
		}
		
		if(filter_var($email, FILTER_VALIDATE_EMAIL)) { 
			throw new CustomException('Recipient is not valid.');
		}
		$this->recipient = $recipient;
	}
	
	private function setEmailFileName($emailFileName) {
		$this->emailFileName = $emailFileName;
	}
	
	private function getEmailFileContent() {
		$emailFile = 'emails/'.$this->emailFileName.'.txt';
		if(!file_exists($emailFile)) {
			throw new CustomException('File do not exists');
		}
		return file_get_contents($emailFile);
	}
	
	private function setTags($aTags) {
		if(!is_array($aTags)) {
			throw new CustomException('Not in array format.');
		}
		$this->tags = $aTags;
	}
	
	private function setTagsValue($aTagsValue) {
		if(!is_array($aTagsValue)) {
			throw new CustomException('Not in array format.');
		}
		$this->tagsvalue = $aTagsValue;
	}
	private function getSubject() {
		$subject = findTextBetweenTag($this->getEmailFileContent() , '<SUBJECT>','</SUBJECT>');
		return str_replace($this->tags, $this->tagsvalue, $subject);	
	}
	
	private function getBody() {
		$messageBody = findTextBetweenTag($this->getEmailFileContent() , '<BODY>','</BODY>');
		return str_replace($this->tags, $this->tagsvalue, $messageBody).' '. $this->getDisclaimer();
	}
	
	private function getDisclaimer() {
		if($this->disclaimer == '') {
			$this->disclaimer =  "<br/><br/>Disclaimer: ".StmConfig::$mailDisclaimer;
		}
		return $this->disclaimer;
	}
	
	private function getFrom() {
		return array($this->fromEmail, $this->fromName);
	}
	
	private function debugMail() {
		echo '<div style="background: #FBE6F2; border: 1px solid #D893A1; color: #333; margin: 10px 0 5px 0; padding: 10px;">';
		echo '<b>SUBJECT:</b> '.$this->getSubject().'<br/>';
		echo '<b>TO:</b>  ';
		if (is_array($this->recipient )) {
			foreach($this->recipient  as $email) {
				echo $email.', ';
			}
		} else {
			echo $this->recipient ;
		}
		echo '<br/>';
		echo '<b>MAIL FROM:</b> '.$this->fromEmail.'<br/>';
		echo '<b>FROM NAME:</b> '.$this->fromName.'<br/>';
		echo '<b>EMAIL TEXT:</b> '.$this-> getBody();
		echo '</div>';
	}
	private function send() {
		$mailer = StmFactory::getPhpMailer();# Invoke JMail Class
		# Add a recipient -- this can be a single address (string) or an array of addresses
		$mailer->addAddress($this->recipient);
		if(strlen($this->bcc) > 0){$mailer->addBCC($this->bcc);}
        if(strlen($this->cc) > 0) {$mailer->addCC($this->cc); }
        $mailer->addReplyTo(StmConfig::$addReplyToEmail , StmConfig::$addReplyToName);
        $mailer->isHTML(true);
		$mailer->Subject = $this->getSubject();
		$mailer->Body = $this-> getBody();
		# Set sender array so that my name will show up neatly in your inbox
		$from = $this->getFrom();
        $mailer->From = $from[0];
	    $mailer->FromName = $from[1];
		//$mailer->setSender($this->getFrom());
		# If you would like to send as HTML, include this line; otherwise, leave it out
		# Send once you have set all of your options
		if(!$mailer->send()){
		  StmFactory::getApplication()->setMessage($mailer->ErrorInfo, 'error');
		}
			$mailer->ClearAddresses();
			$mailer->ClearBCCs();
			$mailer->ClearCCs();
	}

	private function sendSmtp() {
		$mailer = StmFactory::getPhpMailer();# Invoke JMail Class
		$mailer->isSMTP();
		$mailer->SMTPDebug = StmConfig::$smtpDebug;
		$mailer->Port = StmConfig::$smtpPort;
		$mailer->Host = StmConfig::$smtpHost;
		$mailer->SMTPAuth= StmConfig::$smtpSMTPAuth;
		$mailer->Username = StmConfig::$smtpUsername;
		$mailer->Password = StmConfig::$smtpPassword;
		$mailer->SMTPSecure = StmConfig::$smtpSMTPSecure;
		# Add a recipient -- this can be a single address (string) or an array of addresses
		$mailer->addAddress($this->recipient);
		if(strlen($this->bcc) > 0){$mailer->addBCC($this->bcc);}
        if(strlen($this->cc) > 0) {$mailer->addCC($this->cc); }
        $mailer->addReplyTo(StmConfig::$addReplyToEmail , StmConfig::$addReplyToName);
        $mailer->isHTML(true);
		$mailer->Subject = $this->getSubject();
		$mailer->Body = $this-> getBody();
		# Set sender array so that my name will show up neatly in your inbox
		$from = $this->getFrom();
        $mailer->From = $from[0];
	    $mailer->FromName = $from[1];
		//$mailer->setSender($this->getFrom());
		# If you would like to send as HTML, include this line; otherwise, leave it out
		# Send once you have set all of your options
		if(!$mailer->send()){
		  stratumMessageAndExit($mailer->ErrorInfo);
		}
			$mailer->ClearAddresses();
			$mailer->ClearBCCs();
			$mailer->ClearCCs();
	}

	//This is default php mail function.
	public  function sendMail($recipient, $emailFileName, $aTags, $aTagsValue, $debug = 'NO', $bcc='', $cc='') {
		$this->setRecipient($recipient);
		$this->setBCC($bcc);
		$this->setCC($cc);
		$this->setEmailFileName($emailFileName) ;
		$this->setTags($aTags);
		$this->setTagsValue($aTagsValue);
		$this->getSubject();
		$this->fromName = StmConfig::$mailFromName;
		$this->fromEmail = StmConfig::$mailFromEmail;
		if(trim($debug) == 'YES') {
			$this->debugMail() ;
		} else {
			if(StmConfig::$smtpMail=='0') {
				$this->sendSmtp();
			} else {
				$this->send();
			}
		}
	}

}
?>