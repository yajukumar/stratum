<?php
/* 
 * @category   User Management
 * @package    STRATUM
 * @author     Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/
class ControllerRegister extends StmController{
	
	public function register() {
		$post = $_POST;
		$oDb = StmFactory::getDbo();
		$this->beforeSave($post, $defaultview);
		//Random password 
		if(StmConfig::$randomPassword == '0') {
			$pass = StmFactory::getUser()->generatePassword();
			$post['password'] = $pass[1];
			$post['confirm_password'] = $post['password'];
		}
		$post = StmFactory::getForm()->validatePostData($post, 'registration');
		StmFactory::getForm()->checkPostError('view='.$this->currentView());
		if($this->checkExistsUser($post) > 0) {
			StmFactory::getApplication()->setMessage('User Already exists', 'error');
			StmFactory::getApplication()->redirect('view='.$this->currentView());
		}
		//Finally Store User
		$post['created_date'] = date('Y-m-d');
		$post['user_group_id'] = 1;
		$post['block'] = (StmConfig::$userActivation == '0') ? 1 : 0;
		$post['security_token'] = (StmConfig::$userActivation == '0') ? StmFactory::getUser()->generateUserToken() : '';
		$userid = $oDb->store('users','id',$post);
		if($userid < 1) {
			StmFactory::getApplication()->setMessage('Registration not complete. Please try again.', 'error');
			StmFactory::getApplication()->redirect('view='.$this->currentView());
		}
		$this->afterSave($post, $pass);
		if(StmConfig::$userActivation == '0') {
			StmFactory::getApplication()->setMessage('Registration successful. Please check your email and follow the instructions.');
		} else {
			StmFactory::getApplication()->setMessage('Registration successful. You can login');
		}
		$defaultview = StmViewUtil::getDefaultView();
		StmFactory::getApplication()->redirect('view='.$defaultview[0]->view);
		//print_r($post);print_r(StmFactory::getForm()->postError);
		exit;
	}

	private function beforeSave($post) {
		if(StmConfig::$userRegistration == '1') {//Check if registration is allowed by Config
			StmFactory::getApplication()->setMessage('This site do not allow registration.', 'error');
			StmFactory::getApplication()->redirect('view='.$this->currentView());
			exit;
		}
		//Validate form token
		if(!validateFormToken($post['token'])){
			StmFactory::getApplication()->setMessage('Form token is not valid. Please, submit this form again.', 'error');
			StmFactory::getApplication()->redirect('view='.$this->currentView());
			exit;
		}
	}

	private function afterSave($post, $pass) {
		if(StmConfig::$userActivation == '0') {//Send Activation email
			$activationLink = StmConfig::$livepath.'?view=register&action=activation'; 
			$aTags = array('{{FNAME}}','{{LNAME}}','{{ACTIVATION_LINK}}', '{{TOKEN}}', '{{USERNAME}}','{{PASSWORD}}');
			$aTagsValue = array(ucfirst($post['first_name']),  $post['last_name'], $activationLink, $post['security_token'], $post['username'], $pass[0]);
			StmFactory::getMailer()->sendMail($post['email'], 'user_activation', $aTags, $aTagsValue, 'NO');
		}
	}

	private function checkExistsUser($post) {
		$user = StmFactory::getUser()->isUserExist($post['username']);
		return $user->users;
	}

	public function activation() {
		$this->view('activation', array('test'=>$test) );
	}

	public function activate() {
		$defaultview = StmViewUtil::getDefaultView();
		$post = $_POST;
		$post = StmFactory::getForm()->validatePostData($post, 'useractivation');
		StmFactory::getForm()->checkPostError('view='.$this->currentView());
		$user = StmFactory::getUser()->getUserToken($post['security_token']);
		if(count($user) < 1) {
			StmFactory::getApplication()->setMessage('Unable to find Token', 'error');
			StmFactory::getApplication()->redirect('view='.$this->currentView());
		}
		StmFactory::getUser()->getUserActivate($post['security_token']);
		//Send email to user about your login is activated
		$aTags = array('{{FNAME}}','{{LNAME}}','{{SITE_URL}}');
		$aTagsValue = array(ucfirst($user[0]->first_name),  $user[0]->last_name, StmConfig::$livepath);
		StmFactory::getMailer()->sendMail($user[0]->email, 'add_new_user', $aTags, $aTagsValue, 'NO');

		//Send email to Admin about this user's login is activated
		$aTags = array('{{FNAME}}','{{LNAME}}','{{EMAILID}}', '{{USERNAME}}');
		$aTagsValue = array(ucfirst(ucfirst($user[0]->first_name)),  $user[0]->last_name, $user[0]->email, $user[0]->username);
		StmFactory::getMailer()->sendMail(StmConfig::$mailFromEmail, 'add_new_user_admin', $aTags, $aTagsValue, 'NO');
		StmFactory::getApplication()->setMessage('Registration successful. You can login');
		StmFactory::getApplication()->redirect('view='.$defaultview[0]->view);
	}

	public function login() {
		$getDashboardView = StmViewUtil::getDashboardView();
		$post = $_POST;
		$post = StmFactory::getForm()->validatePostData($post, 'login');
		StmFactory::getForm()->checkPostError('view=login');
		StmFactory::getUser()->login($post['password'], $post['username'], 'login');
		StmFactory::getApplication()->redirect('view='.$getDashboardView[0]->view);
	}

	public function logout() {
		$defaultview = StmViewUtil::getDefaultView();
		StmFactory::getUser()->logout();
		StmFactory::getApplication()->setMessage('You have been logged out successfully!');
		StmFactory::getApplication()->redirect('view='.$defaultview[0]->view);
	}

	public function forgetPass() {
		$this->view('forgotpass', array('test'=>$test) );
	}

	public function sendPassword() {
		$post = $_POST;
		$post = StmFactory::getForm()->validatePostData($post, 'forgetpass');
		StmFactory::getForm()->checkPostError('view=register&action=forgetPass');
		$pass = StmFactory::getUser()->generatePassword();
		$userData  = StmFactory::getUser()->where('email','=',$post['email']);
		//Send email to User with new password.
		$aTags = array('{{FNAME}}','{{LNAME}}','{{EMAILID}}', '{{USERNAME}}');
		$aTagsValue = array(ucfirst(ucfirst($user[0]->first_name)),  $user[0]->last_name, $user[0]->email, $user[0]->username);
		StmFactory::getMailer()->sendMail(StmConfig::$mailFromEmail, 'add_new_user_admin', $aTags, $aTagsValue, 'NO');
		StmFactory::getApplication()->setMessage('Registration successful. You can login');
		StmFactory::getApplication()->redirect('view='.$defaultview[0]->view);
	}
}

?>