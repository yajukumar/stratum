<?php
if(StmFactory::getSession()->get('userid') && stmFactory::getUser()->isAdmin())
{
$userid = StmFactory::getSession()->get('userid');
$userdetail = StmFactory::getUser()->userProfileDetail($_POST["ajaxpost"]);
?>
<div class="header">
            <h3 class='title'>My Profile</h3>
        </div>
<div class='modal-header'><button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button><h3>Update User</h3></div><div class='modal-body'>
<form autocomplete="off" id="UserForm" name="UserForm" method="post">
	<h4>User Information _________________________________________________________</h4>
	<div class="form-inline">
		<div class="form-group">
			<label style="width: 220px;">First Name<span class="mandatory">*</span>:</label>
			<label>
				<input style="width: 220px;" class="form-control" type="text" name="first_name" id="firstname" placeholder="First name" data-validation="required" data-validation-error-msg="You did not enter first name" value="<?php echo $userdetail['first_name']; ?>"/>
			</label>
		</div>
		<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
			<label style="width: 220px;">Middle Name:</label>
			<label>
				<input style="width: 220px;" class="form-control" type="text" name="middle_name" id="middlename" placeholder="Middle name" value="<?php echo $userdetail['middle_name']; ?>"/>
			</label>
		</div>
		<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
		<label style="width: 220px;">Last Name<span class="mandatory">*</span>:</label>
			<label>			
				<input style="width: 220px;" class="form-control" type="text" name="last_name" id="lastname" placeholder="Last name"  data-validation="required" data-validation-error-msg="You did not enter last name" value="<?php echo $userdetail['last_name']; ?>" />
			<label>
		</div>
		<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
		<label style="width: 220px;">Email<span class="mandatory">*</span>:</label>
			<label>			
				<input style="width: 220px;" class="form-control" type="text" name="email" id="email" placeholder="Email" data-validation="required email" data-validation-error-msg="You did not enter a valid email id" value="<?php echo $userdetail['email']; ?>"/>
			<label>
		</div>
		<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
			<label style="width: 220px;">User Branch:</label>
			<?php StmFactory::getHelper()->helper('html')->locationList($modelAdd, $userdetail['location_id']); ?>
		</div>
		<!--Clear--><div class="clearfix"></div><!--Clear-->
<h4>Login Information _________________________________________________________</h4>		
		<div class="form-group">
			<label style="width: 220px;">UserID<span class="mandatory">*</span>:</label>
			<label><?php echo $userdetail['username']; ?></label>	
		</div>
<!--Clear--><div class="clearfix"></div><!--Clear-->		
		<div class="form-group">
			<label style="width: 220px;">Password:</label>
			<label>
				<input style="width: 200px;" class="form-control" type="password" name="password" id="password" placeholder="Password" data-validation="required" data-validation-error-msg="You did not enter password" />
			</label>	
		</div>		
<!--Clear--><div class="clearfix"></div><!--Clear-->		
		<div class="form-group">
			<label style="width: 220px;">Retype Password:</label>
			<label>
				<input style="width: 200px;" class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="Confirm password" data-validation="required" data-validation-error-msg="You did not enter confirm password"/>
			</label>	
		</div>
<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
			<label style="width: 220px;">User Type<span class="mandatory">*</span>:</label>
			<label><?php $usergroup = StmFactory::getUser()->userGroup($_POST["ajaxpost"]); echo $usergroup->group_name; ?></label>
		</div>
<!--Clear--><div class="clearfix"></div><!--Clear-->
		<div class="form-group">
			<label style="width:220px"></label>
			<label>
				<input class="btn btn-primary" type="button" name="button" id="save" value="Save" />
			</label>
			<label>
				<button type='button' data-dismiss='modal' class='btn'>Close</button>
			</label>	
		</div>		
<!--Clear--><div class="clearfix"></div><!--Clear-->
	</div>
	<input type="hidden" name="id" id="id" value="<?php echo $_POST["ajaxpost"]; ?>" />
	<input type="hidden" name="modified_date" value="<?php echo date('Y-m-d H:i:s'); ?>"; />
	<?php echo getFormToken(false); ?>
</form>
<!--</div><div class='modal-footer'></div>-->
<?php
}
else
{
	echo "<h1 class='debug_note'>You are not authorised to view this location.</h1>";
}
?>
<script>
$('#save').on('click', function(){
	
	// validate form before submit
	if($.trim($('#firstname').val()) == ''){
		if($('form[name="UserForm"] .alert-danger').length > 0){
			$('.alert-danger').append("<br /> * Please Enter First Name");
		} else { $('#UserForm').prepend("<div class='form-error alert alert-danger'><strong>Form submission failed!</strong><br /> * Please Enter First Name</div>"); }
		return false;
	}
	if($.trim($('#lastname').val()) == ''){
		if($('form[name="UserForm"] .alert-danger').length > 0){
			$('.alert-danger').append("<br /> * Please Enter Last Name");
		} else { $('#UserForm').prepend("<div class='form-error alert alert-danger'><strong>Form submission failed!</strong><br /> * Please Enter Last Name</div>"); }
		return false;
	}
	if($.trim($('#email').val()) == ''){
		if($('form[name="UserForm"] .alert-danger').length > 0){
			$('.alert-danger').append("<br /> * Please Enter Email");
		} else { $('#UserForm').prepend("<div class='form-error alert alert-danger'><strong>Form submission failed!</strong><br /> * Please Enter Email</div>"); }
		return false;
	}
	if($.trim($('#password').val()) != '') {
		if($.trim($('#password').val()) != $.trim($('#confirm_password').val())){
			if($('form[name="UserForm"] .alert-danger').length > 0){
				$('.alert-danger').append("<br /> * Passwords do not match");
			} else { $('#UserForm').prepend("<div class='form-error alert alert-danger'><strong>Form submission failed!</strong><br /> * Passwords do not match</div>"); }
			return false;
		}
	}
	
	var data = $("#UserForm").serialize();
	var id = $('#id').val();
	//alert(data);
	// create the backdrop and wait for next modal to be triggered
		$('.modal-body').modalmanager('loading');

		setTimeout(function(){

			$('.modal-body').load('raw.php?view=update_user&action=save', { "ajaxpost":  data  }, function(result){
							var detail = result.split('#');
				$('.modal-body').html(detail[1]);
				if($.trim($(detail[0]).html()) != ''){
					$('#row'+id+' td:eq(1)').html(detail[0]);
					$('#row'+id+' td:eq(3)').html(detail[2]);
				}
			});
			
			setTimeout(function(){ $('div#ajax-modal').hide("slow",function(){ $('#ajax-modal').modal('hide'); }); }, 2000);
			
		}, 1000); 
	});
</script>