<?php
/* 
 * @category   User Management 
 * @package    STRATUM
 * @author     Mukesh Singh 
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/
class StmUser extends StmOrm {
	public $tableName = 'users';
	function __construct() {
	}
	
	public function generatePassword() {
		$realPassword = rand(111111, 999999);
		$password = STMSALT.$realPassword;
		return array($realPassword, md5($password));
	}

	public function generateUserToken() {
		$token = STMSALT.rand(222211, 999999);
		return md5($token);
	}

	public function getUserToken($user_token) {
		$oDb = StmFactory::getDbo();
		$query = "SELECT * FROM #_users WHERE security_token='".$user_token."' ";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchObjectList();
	}

	public function getUserActivate($user_token) {
		$oDb = StmFactory::getDbo();
		$query = "UPDATE #_users SET block='0', security_token='' WHERE security_token='".$user_token."' ";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchObjectList();
	}
	/*
	* Return Query for User Data
	* $fields is set of coulmn name (eg. name,phone...), by default it returns all column (*) in query.
	*/
	function createQuery($fields = "*", $table = "users", $fulldetail = "0")
	{
		if($fulldetail == "1")
		{
			//$fields = $table;
			return $this->joinQuery();
		}
		else
		{
			return "SELECT ".$fields." FROM #_". $table ." as ".$table;
		}
	}
	/*
	* Return Query for Left and Right Join
	*/
	function joinQuery()
	{
		// Fetch Columns
			$fields = "users.* ";
		return "SELECT ". $fields ." FROM #_users as users  left join #_user_group as groups on users.user_group_id = groups.id ";
	}
	
	function queryConditions($where)
	{
		return " WHERE ".$where;
	}
	/*
	* Return User Table Data
	*/
	function userdetail($id){
		$oDb = StmFactory::getDbo();
		$query = $this->createQuery();
		$where = $this->queryConditions("users.id = '". $id ."'");
		$fullQuery = $query.$where;
		$oDb->mysqlQuery($fullQuery);
		return $oDb->mysqlFetchAssoc();
	}
	/*
	* Return User Profile Full Data
	*/
	function userProfileDetail($id){
		$oDb = StmFactory::getDbo();
		$query = $this->createQuery("","","1");
		$where = $this->queryConditions("users.id = '". $id ."'");
		$fullQuery = $query.$where;
		$oDb->mysqlQuery($fullQuery);
		return $oDb->mysqlFetchAssoc();
	}
	  
	/*
	*  Save User Profile
	*/
	public function saveprofile($data){
		
		if (trim($data['email']) == '') {
			unset($data['email']);
		}
		$data['first_name'] = clearString($data['first_name']); // Removes special chars.
		$data['middle_name'] = clearString($data['middle_name']); // Removes special chars.
		$data['last_name'] = clearString($data['last_name']); // Removes special chars.
		$data['zip'] = clearString($data['zip']); // Removes special chars.
		$data['home_phone'] = clearString($data['home_phone']); // Removes special chars.
		$data['mobile_phone'] = clearString($data['mobile_phone']); // Removes special chars.
		
		if (trim($data['first_name']) == '') {
			StmFactory::getApplication()->setMessage('Invalid First Name', 'error');
			return false;
		}
		if (trim($data['last_name']) == '') {
			StmFactory::getApplication()->setMessage('Invalid Last Name', 'error');
			return false;
		}
		
		// Validate Email
		if (trim($data['email']) != '') {
		if (!validateEmail($data['email'])) {
			StmFactory::getApplication()->setMessage('Invalid Email', 'error');
			return false;
		}
	}
		if (trim($data['email']) != '') {
			$existuser = $this->isUserExist(trim($data['email']));
			if($existuser->users > 0) {
				StmFactory::getApplication()->setMessage('Email exists', 'error');
				return false;
			} else {
				$data['email'] = trim($data['email']);
				$data['username'] = trim($data['email']);
			}
		}


		// Check if password and confirm password do not match
		if(trim($data['password']) != trim($data['confirm_password']))
		{
			StmFactory::getApplication()->setMessage('Password and Confirm Password do not match.', 'error');
			return false;
		}
		
		$oDb = StmFactory::getDbo();
		if($data['id'] != '' && $data['id'] > 0 && trim($data['password']) != '')
		{
			$password = STMSALT.$data['password'];
			$password = md5($password);
			$data['password'] = $password;
		}
		else
		{
			unset($data['password']);
		}
		$data['user_id'] = $oDb->store('users','id',$data);
		
		StmFactory::getApplication()->setMessage('Profile Saved Successfully.');
		return true;
	}
	

	/*
	* Check User Login (Approved by Stratum)
	*/
	public function login($password, $username, $failedpage){
		$oDb = StmFactory::getDbo();
		$password = STMSALT.$password;
		$password = md5($password);
 		$query = "SELECT id,block,security_token FROM #_users WHERE username = '". $username."' AND password = '". $password ."'";
		$oDb->mysqlQuery($query);
		$userdetail = $oDb->mysqlFetchObjectList();
		if(count($userdetail) > 0){
			if($userdetail->block ==1 && $userdetail->security_token!='') {
				StmFactory::getApplication()->setMessage('Your account has been Blocked. Please contact the administrator.', 'error');
				StmFactory::getApplication()->redirect('view='.$failedpage);
			}
		} else{
			StmFactory::getApplication()->setMessage('Wrong username/password combination<br/> <a href="?view=forgot_pass">Lost your password ?</a>', 'error');
			StmFactory::getApplication()->redirect('view='.$failedpage);
		}
		StmFactory::getSession()->set('userid',$userdetail[0]->id);
		return $userdetail;
	}
	/*
	* Save Logged-in User
	*/
	function current_users($userid){
		$oDb = StmFactory::getDbo();
		$query = "INSERT INTO #_current_users SET user_id = '". $userid ."'";
		$oDb->mysqlQuery($query);
	}
	
	/*
	* Logout Current User - Delete current session
	*/
	public function logout($userid = null){
		StmFactory::getSession()->deleteSessionData();
	}
	
	/*
	* Save User Group
	*/
	public function savegroupprofile($data){
		$oDb = StmFactory::getDbo();
		$oDb->store('user_group','id',$data);
		return true;
	}
	
	/*
	* Return User Group List
	*/
	function userGroupList($level = 0){
		$oDb = StmFactory::getDbo();
		$query = "SELECT * FROM #_user_group where level > '". $level ."' order by level";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchObjectList();
	}
	/*
	* Return User Group of Current Logged in USer
	*/
	function userGroup($userid = null){
		if($userid == null){
			$userid = StmFactory::getSession()->get('userid');
		}
		$oDb = StmFactory::getDbo();
		$query = "SELECT users.user_group_id, user_group.group_name FROM #_users as users left join #_user_group as user_group on user_group.id = users.user_group_id where users.id = '". $userid ."'";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchObject();
	}
	/*
	* Check if Current Loggen-in User is Admin or Not
	*/
	function isAdmin(){
		$user_group_id = $this->userGroup();
		if($user_group_id->user_group_id == '1') { return true; } else { return false; }
	}
	
	/*
	* Check if User Already Exists
	*/
	function isUserExist($username){
		$oDb = StmFactory::getDbo();
		$query = "SELECT count(id) as users FROM #_users where username='". $username ."'";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchObject();
	}
	/*
	* limit in user list
	*/
	function limit($page = 1,$limit = 10)
	{
		if(isset($_POST['page']) && $_POST['page'] > 1){
			$page = $_POST['page'];
		}
		$page = ($page - 1) * $limit;
		return " limit ".$page.", ".$limit;
	}
	/*
	* Return order by field name in query
	*/
	function order($orderby = 'id', $order = 'ASC')
	{
		return " order by ".$orderby." ".$order;
	}
	/*
	* Return User List
	*/
	function userList($userGroup = 0){
		$oDb = StmFactory::getDbo();
		$query = $this->createQuery("","",1);
		$where = $this->queryConditions("groups.level > 0");
		if(StmFactory::getSession()->get('userid')){
			$where.= " AND users.id <> '". StmFactory::getSession()->get('userid') ."'";
		}
		if($userGroup > 0 ){ $where.= " AND users.user_group_id = '". $userGroup ."'"; }
		$limit = $this->limit();
		if(isset($_POST['sortby']) && $_POST['sortby'] != ''){
			$orderby = $_POST['sortby'];
		} else{
			$orderby = 'first_name';
		}
		if(isset($_POST['sortorder']) && $_POST['sortorder'] != ''){
			$sortorder = $_POST['sortorder'];
		} else{
			$sortorder = 'ASC';
		}
		$order = $this->order($orderby, $sortorder);
		$fullQuery = $query.$where.$order.$limit;
		$oDb->mysqlQuery($fullQuery);
		return $oDb->mysqlFetchObjectList();
	}
	/*
	* Return User List
	*/
	function totalLinks($limit = 10){
		$oDb = StmFactory::getDbo();
		$query = $this->createQuery("","",1);
		$where = $this->queryConditions("groups.level > 0");
		$totalLinksQuery = $query.$where;
		$oDb->mysqlQuery($totalLinksQuery);
		$count_rows = count($oDb->mysqlFetchObjectList());
		$total_links = $count_rows%$limit;
		if($total_links > 0)
			{
				$total_links = intval($count_rows/$limit) + 1;
			}
		else
			{
				$total_links = intval($count_rows/$limit);
			}
		return $total_links;
	}
	/*
	* Return Pagination Links
	*/
	function pagination(){
		$total_links = $this->totalLinks();
		if(isset($_POST['page'])){
			$page = $_POST['page'];
		} else {
			$page = 1;
		}
		if($total_links > 1){
			echo "<ul class='pagination'>";
				echo "<li><a href='#' onclick=\"document.getElementById('page').value = 1; document.getElementById('listForm').submit();\">&laquo;</a></li>";
				for($i = 1; $i<=$total_links; $i++)
				{
					if($page == $i){
						$className = 'active';
					} else{
						$className = '';
					}
					echo "<li class='".$className."'><a href='#' onclick=\"document.getElementById('page').value = ".$i."; document.getElementById('listForm').submit();\">".$i."</a></li>";
				}
				$lastLink = $total_links;
				echo "<li><a href='#' onclick=\"document.getElementById('page').value = ".$lastLink."; document.getElementById('listForm').submit();\">&raquo;</a></li>";
			echo "</ul>";
		}
	}
	
	/*
	* Return Salutaion List
	*/
	function salutationList(){
		$oDb = StmFactory::getDbo();
		$query = "SELECT * FROM #_salutations ORDER BY id";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchObjectList();
	}
	
	/*
	* Return Patient User Group id
	*/
	function patientUserGroupId(){
		$oDb = StmFactory::getDbo();
		$query = "SELECT id FROM #_user_group WHERE level = '0' ";
		$oDb->mysqlQuery($query);
		return $oDb->mysqlFetchObject()->id;
	}
	/*
	* Delete User
	*/
	function deleteUser($userid){
		$oDb = StmFactory::getDbo();
		// Delete from Security Answers Table
		$query = "DELETE FROM #_user_security_answers WHERE user_id = '". $userid ."' ";
		$oDb->mysqlQuery($query);
		// Delete from Staff Table
		$query = "DELETE FROM #_staff WHERE user_id = '". $userid ."' ";
		$oDb->mysqlQuery($query);
		// Delete from User Location Table
		$query = "DELETE FROM #_user_location WHERE user_id = '". $userid ."' ";
		$oDb->mysqlQuery($query);
		// Delete from Users Table
		$query = "DELETE FROM #_users WHERE id = '". $userid ."' ";
		$oDb->mysqlQuery($query);
		StmFactory::getApplication()->setMessage('User Deleted Successfully.');
		return true;
	}
	
	/*
	* Check if security questions has been filled or not
	*/
	function checkProfileStatus($userid = null){
		if($userid == null){
			$userid = StmFactory::getSession()->get('userid');
		}
		$oDb = StmFactory::getDbo();
		$query = "SELECT COUNT(id) as answers FROM #_user_security_answers WHERE user_id = '". $userid ."'";
		$oDb->mysqlQuery($query);
		if($oDb->mysqlFetchObject()->answers == '3') { return true; } else { return false; }
	}
  
}
?>