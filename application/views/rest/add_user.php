<?php
if(StmFactory::getSession()->get('userid') && stmFactory::getUser()->isAdmin())
{
$userid = StmFactory::getSession()->get('userid');
$userdetail = StmFactory::getUser()->userProfileDetail($_POST["sData"][0]);
?>
<form autocomplete="off" id="UserProfileForm" name="UserProfileForm" method="post" action="?view=add_user&action=save">

<h3>Add New User</h3>
	<h4>User Information _________________________________________________________</h4>
	<div class="form-inline">
		<div class="form-group">
			<label style="width: 220px;">First Name<span class="mandatory">*</span>:</label>
			<label>
				<input style="width: 220px;" class="form-control" type="text" name="first_name" id="firstname" placeholder="FIRST NAME" data-validation="required" data-validation-error-msg="You did not enter first name" value="<?php echo $userdetail['first_name']; ?>"/>
			</label>
		</div>
		<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
			<label style="width: 220px;">Middle Name:</label>
			<label>
				<input style="width: 220px;" class="form-control" type="text" name="middle_name" id="middlename" placeholder="MIDDLE NAME" value="<?php echo $userdetail['middle_name']; ?>"/>
			</label>
		</div>
		<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
		<label style="width: 220px;">Last Name<span class="mandatory">*</span>:</label>
			<label>			
				<input style="width: 220px;" class="form-control" type="text" name="last_name" id="lastname" placeholder="LAST NAME"  data-validation="required" data-validation-error-msg="You did not enter last name" value="<?php echo $userdetail['last_name']; ?>" />
			<label>
		</div>
		<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
		<label style="width: 220px;">Email<span class="mandatory">*</span>:</label>
			<label>			
				<input style="width: 220px;" class="form-control" type="text" name="email" id="email" placeholder="EMAIL" data-validation="required email" data-validation-error-msg="You did not enter a valid email id" value="<?php echo $userdetail['email']; ?>"/>
			<label>
		</div>
		<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
			<label style="width: 220px;">User Branch:</label>
			<?php StmFactory::getHelper()->helper('html')->locationList($this->getModel('add_user')); ?>
		</div>
		<!--Clear--><div class="clearfix"></div><!--Clear-->
<h4>Login Information _________________________________________________________</h4>		
		<div class="form-group">
			<label style="width: 220px;">UserID<span class="mandatory">*</span>:</label>
			<label>
				<input style="width: 200px;" class="form-control" type="text" name="username" id="username" placeholder="USERID" value="<?php echo $userdetail['username']; ?>" data-validation="required" data-validation-error-msg="You did not enter Userid" />
				<i class='glyphicon glyphicon-question-sign' onclick="checkUserAvailability(document.getElementById('username').value)" rel="tooltip" style="color: #255983; cursor: pointer; font-size: 14px;" title="Click Here to Check Username Availability" data-toggle="tooltip" data-placement="right"></i>
			</label>	
		</div>
<!--Clear--><div class="clearfix"></div><!--Clear-->		
		<div class="form-group">
			<label style="width: 220px;">Password<span class="mandatory">*</span>:</label>
			<label>
				<input style="width: 200px;" class="form-control" type="password" name="password" id="password" maxlength="50" placeholder="PASSWORD" data-validation="required" data-validation-error-msg="You did not enter password" />
			</label>	
		</div>		
<!--Clear--><div class="clearfix"></div><!--Clear-->		
		<div class="form-group">
			<label style="width: 220px;">Retype Password:</label>
			<label>
				<input style="width: 200px;" class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="CONFIRM PASSWORD" data-validation="re-type" data-validation-error-msg="Passwords do not match" maxlength="50" />
			</label>	
		</div>
<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
			<label style="width: 220px;">User Type<span class="mandatory">*</span>:</label>
			<?php echo StmFactory::getApplication()->getGizmo('userGroupList'); ?>
		</div>
<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
			<label style="width:220px"></label>
			<label>
				<input class="btn btn-primary" type="submit" name="button" id="button" value="Save" />
			</label>	
		</div>		
<!--Clear--><div class="clearfix"></div><!--Clear-->
	</div>
	<input type="hidden" name="created_date" value="<?php echo date('Y-m-d H:i:s'); ?>"; />
	<input type="hidden" name="modified_date" value="<?php echo date('Y-m-d H:i:s'); ?>"; />
	<?php echo getFormToken(); ?>
</form>
<?php
}
else
{
	echo "<h1 class='debug_note'>You are not authorised to view this location.</h1>";
}
?>
<script>
	$.formUtils.addValidator({
	  name : 're-type',
	  validatorFunction : function(value, $el, config, language, $form) {
	  	if($('#password').val() != '') {
	  		if($('#password').val() != $('#confirm_password').val()){
	  			return false;
	  		}
	  	}
	  	return true;
	  },
	  errorMessage : 'Passwords do not match.',
	  errorMessageKey: 'Passwords do not match.'
});
</script>
<div id="ajax-modal" class="modal fade" tabindex="-1" style="display: none;" data-width="760" ></div>
<script id="ajax" type="text/javascript">
$(function(){
    $.fn.modal.defaults.spinner = $.fn.modalmanager.defaults.spinner = 
      '<div class="loading-spinner" style="width: 200px; margin-left: -100px;">' +
        '<div class="progress progress-striped active">' +
          '<div class="progress-bar" style="width: 100%;"></div>' +
        '</div>' +
      '</div>';
    $.fn.modalmanager.defaults.resize = true;
});
	
	var $modal = $('#ajax-modal');
	
	function checkUserAvailability(username){
		if($.trim(username) == '') { alert('Please Enter Username.'); return false; }
		// create the backdrop and wait for next modal to be triggered
		$('body').modalmanager('loading');

		setTimeout(function(){
				$modal.load('raw.php?view=add_user&action=checkUserAvailability', { "username":  username  }, function(result){
				$modal.modal();
				$modal.html(result);
			});
		}, 1000);
	}
</script>