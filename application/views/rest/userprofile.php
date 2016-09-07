<?php
 //Factory::getApplication()->patientInEditMode();
StmFactory::getSession()->set('breadcrumbs', array('Home' => '#', 'Change Password' => ''));
if(StmFactory::getSession()->get('userid')){
StmFactory::getApplication()->setDocumentTitle('My Profile');
    $modelother = $this->getModelInstance('register');
	$userIndustry = $modelother->getIndustry();
    $userOwnerShip = $modelother->getOwnerShip();
$userid = StmFactory::getSession()->get('userid');
$userdetail = StmFactory::getUser()->userProfileDetail($userid);
?>
<!--WRAPPER-->
	<!--SLIDE-IN ICONS-->
    <!--END SLIDE-IN ICONS-->
<!--LOGIN FORM-->
<!-- <stmmessage> -->
<form  autocomplete="off" id="UserProfileForm" name="UserProfileForm" method="post" action="?view=userprofile&action=save"  onSubmit="return checkDublicateEmail()">
    	<!--HEADER-->
        
        <div class="header">
            <h3 class='title'>My Profile</h3>
        </div>
        <div style="clear:both"></div>
        <!--END HEADER-->
    	<!--CONTENT-->
        <div class="contentregister" >
            <table width="100%" style="border-spacing:9px;border-collapse: separate;padding-right:30px;">
            	<tr>
                    <td><lable class="registerlable">Email id</lable></td>
                    <td><div id="reademail"><?php echo $userdetail['email']; ?>&nbsp;<a href="javascript:void(0);" onclick="enablethis('reademail','email')" >edit</a></div>
                    	<input name="email" onblur="checkDublicateEmail()" id="email"  type="hidden" data-validation="change-username" class="input username " placeholder="Enter valid email id. Your password will be sent here" /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Title</lable></td>
                    <td><p>
                        <select class="input username " name="title" id="title" data-validation="titlerequire"  >
                        <option value="a">--Select Title--</option>
                        <option value="ms" <?php  if($userdetail['title']=='ms'){echo 'selected';} ?> >&nbsp;&nbsp;Ms.</option>
                        <option value="mr" <?php  if($userdetail['title']=='mr'){echo 'selected';} ?> >&nbsp;&nbsp;Mr.</option>
                        <option value="dr" <?php  if($userdetail['title']=='dr'){echo 'selected';} ?> >&nbsp;&nbsp;Dr.</option>
                        </select></p>
                    </td>
                </tr>
                <tr>
                    <td><lable class="registerlable">First Name</lable></td>
                    <td><input name="first_name" type="text" class="input username " placeholder="First Name"  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['first_name']; ?>" /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Middle name</lable></td>
                    <td><input name="middle_name" type="text" class="input username " placeholder="Middle name"  value="<?php echo $userdetail['middle_name']; ?>" /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Last name</lable></td>
                    <td><input name="last_name" type="text" class="input username " placeholder="Last name"  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['last_name']; ?>" /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Designation</lable></td>
                    <td><input name="designation" type="text" class="input username " placeholder="Designation"  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['designation']; ?>" /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Division/ department</lable></td>
                    <td><input name="department" type="text" class="input username " placeholder="Division/ department"  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['department']; ?>" /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Company name</lable></td>
                    <td><input name="company" type="text" class="input username " placeholder="Company name"  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['company']; ?>" /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Address line 1</lable></td>
                    <td><input name="address_one" type="text" class="input username " placeholder="Address line 1"  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['address_one']; ?>" /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Address line 2</lable></td>
                    <td><input name="address_two" type="text" class="input username " placeholder="Address line 2"  value="<?php echo $userdetail['address_two']; ?>" /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">City</lable></td>
                    <td>
                        <table wdith="100%">
                            <tr>
                                <td width="42%"><input name="city" type="text" style="width: 100%" class="input username " placeholder="City"  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['city']; ?>" /></td>
                                <td  width="22%%"><lable class="registerlable">State</lable></td>
                                <td><input name="state" type="text" style="width: 100%"  class="input username " placeholder="State"  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['state']; ?>" /></td>
                        </table>
                        </td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Pin code</lable></td>
					<td ><input name="zip" type="text" style="width: 100%" class="input username " placeholder="Pin code"  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['zip']; ?>" /></td>

                    
                </tr>

                 <tr>
                    <td><lable class="registerlable">Phone no.</lable></td>
                    <td><input name="phone" type="text" class="input username " placeholder="Phone no."  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['phone']; ?>" /></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Fax no.</lable></td>
                    <td><input name="fax" type="text" class="input username " placeholder="Fax no."  data-validation-error-msg=" " value="<?php echo $userdetail['fax']; ?>" /></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Mobile no.</lable></td>
                    <td><input name="mobile" type="text" class="input username " placeholder="Mobile no."  data-validation="required" data-validation-error-msg=" " value="<?php echo $userdetail['mobile']; ?>" /></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Ownership pattern of &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;company</lable></td>
                    <td>
                        <select class="input username " name="ownership" id="ownership" data-validation="ownerrequire" onchange='showHideOtherOwnerShip(this)' >
                        <option value="0">--Select--</option>
                        <?php
                        foreach($userOwnerShip as $ownerShip) {
                        	$selected = ($userdetail['ownership']==$ownerShip->id) ?  'selected' : ''; 
                            echo "<option " .$selected . " value='".$ownerShip->id."'>&nbsp;&nbsp;".$ownerShip->ownership_name."</option>" ;
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr id="otherownership" style="display:<?php echo (strlen($userdetail['other_ownership']) > 1) ? 'table-row' : 'none'; ?>;">
                    <td>&nbsp;</td>
                    <td><input name="other_ownership" id="other_ownership" type="text" class="input username " placeholder="Other"   data-validation="ownerrequireother" value="<?php echo $userdetail['other_ownership'];?>" /></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Industry</lable></td>
                    <td>
                        <select class="input username " name="industry" id="industry" data-validation="industryrequire" onchange='showHideOtherIndustry(this)' >
                        <option value="0">--Select--</option>
                        <?php
                            foreach($userIndustry as $industry) {
                            	$selected = ($userdetail['industry']==$industry->id) ?  'selected' : ''; 
                                echo "<option ".$selected." value='".$industry->id."'>&nbsp;&nbsp;".$industry->industry_name."</option>" ;
                            }
                        ?>
                       </select>
                    </td>
                </tr>
                <tr id="otherindustry" style="display:<?php echo (strlen($userdetail['other_industry']) > 1) ? 'table-row' : 'none'; ?>;">
                    <td>&nbsp;</td>
                    <td><input name="other_industry" id="other_industry" type="text" class="input username " value="<?php echo $userdetail['other_industry'];?>" placeholder="Other"  data-validation="industryrequireother"/></td>
                </tr>
                <tr><td colspan="2" align="center" id="changepassword"><label>Leave blank if you dont want to change the password.</label></td></tr>
				<tr>
				    <td><lable class="registerlable">Password</lable></td>
				    <td><input name="password" id="password" type="password" class="input username " placeholder="PASSWORD"  /></td>
				</tr>
				 <tr>
				    <td><lable class="registerlable">Retype Password</lable></td>
				    <td><input name="confirm_password" type="password" class="input username " id="confirm_password" data-validation="re-type" placeholder="CONFIRM PASSWORD"  /></td>
				</tr>


            </table>    
    	 <span class="help-block form-error"> </span>
         </div>
        <!--FOOTER-->
        <div class="footer" style="top: 1000px;">
        <!--LOGIN BUTTON--><input type="submit" name="submit" value="Save" class="button1" /><!--END LOGIN BUTTON-->
    </div>
    <!--END FOOTER-->
<?php echo getFormToken(); ?>
    	<input type="hidden" name="modified_date" value="<?php echo date('Y-m-d H:i:s'); ?>"; />
	<input type="hidden" name="id" value="<?php echo $userdetail['id']; ?>"; />
    <input type="hidden" name="dublicatemail" id="dublicatemail" />
</form>
<!--END LOGIN FORM-->
<div id="errorContainer">
    <p>Please correct the following errors and try again:</p>
    <ul />
</div>
<?php
}
else
{
	StmFactory::getApplication()->redirect('view=home');
}
?>
<script>
function checkDublicateEmail() {
      $.formUtils.addValidator({
      name : 'change-username',
validatorFunction : function(value, $el, config, language, $form) {
        if($('#email').val() != '') {
            if($('#email').val() != '') {
                var regex = /^([a-zA-Z0-9_.])+\@(([a-zA-Z0-9])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(!regex.test($('#email').val())) {
				
                    return false;
                }
				
            }
            $.ajax({type:"POST",url:"raw.php?view=userprofile&action=checkDublicate",data:{thisemail:$('#email').val()},success:function(result){
                if(result==1) {
                  $('#email').addClass(" error");
                  $('#email').removeClass("valid");
                  $('#email').css('border-color','red');
                  $('#email').parent().removeClass('has-success');
                  $('#email').parent().addClass('has-error');
                  $('#email').parent().find("span.help-block").remove();
                  $('#email').parent().append("<span class='help-block form-error'>Email already Exists.</span>");
                  return false;
                } else { 
                  $('#dublicatemail').val(result);
                }
            }});
        }
        return true;
      },
      errorMessage : '',
      errorMessageKey: ''
    });
}

	$(document).ready(function (){
		
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
	  errorMessage : 'Password do not match.',
	  errorMessageKey: 'Password do not match.'
});
});

$(document).ready(function (){
    $.formUtils.addValidator({
      name : 'titlerequire',
      validatorFunction : function(value, $el, config, language, $form) {
        if($('#title').val() == 'a') {
                return false;
        }
        return true;
      },
      errorMessage : '',
      errorMessageKey: ''
    });
});



$(document).ready(function (){
    $.formUtils.addValidator({
      name : 'ownerrequire',
      validatorFunction : function(value, $el, config, language, $form) {
        if($('#ownership').val() == '0') {
                return false;
        }
        return true;
      },
      errorMessage : '',
      errorMessageKey: ''
    });
});
$(document).ready(function (){
    $.formUtils.addValidator({
      name : 'ownerrequireother',
      validatorFunction : function(value, $el, config, language, $form) {
        if($('#ownership').val() == '5') {
            if($('#other_ownership').val() == '') {
                return false;
            }
        }
        return true;
      },
      errorMessage : '',
      errorMessageKey: ''
    });
});
function showHideOtherOwnerShip(thisobj) {
if (thisobj.value==5) { document.getElementById('otherownership').style.display='table-row';} else {document.getElementById('otherownership').style.display='none';document.getElementById('other_ownership').value='';};
}



$(document).ready(function (){
    $.formUtils.addValidator({
      name : 'industryrequire',
      validatorFunction : function(value, $el, config, language, $form) {
        if($('#industry').val() == '0') {
            // alert()
                return false;
        }
        return true;
      },
      errorMessage : '',
      errorMessageKey: ''
    });
});
$(document).ready(function (){
    $.formUtils.addValidator({
      name : 'industryrequireother',
      validatorFunction : function(value, $el, config, language, $form) {
        if($('#industry').val() == '12') {
            if($('#other_industry').val() == '') {
                return false;
            }
        }
        return true;
      },
      errorMessage : '',
      errorMessageKey: ''
    });
});
function showHideOtherIndustry(thisobj) {
if (thisobj.value==12) { document.getElementById('otherindustry').style.display='table-row';} else {document.getElementById('otherindustry').style.display='none';document.getElementById('other_industry').value='';};
}

function enablethis($readonly, $editonly) {
	document.getElementById($readonly).style.display="none"	;
	document.getElementById($editonly).type='text';
}
</script>

