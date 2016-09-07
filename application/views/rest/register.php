<?php
StmFactory::getApplication()->setDocumentTitle('Register');
if(!StmFactory::getSession()->get('userid'))
{
    $userIndustry = $this->model->getIndustry();
    $userOwnerShip = $this->model->getOwnerShip();
?>
<!--WRAPPER-->
	<!--SLIDE-IN ICONS-->
    <!--END SLIDE-IN ICONS-->
<!--LOGIN FORM-->
<!-- <stmmessage> -->
<form   autocomplete="on" name="loginForm" method="post" action="?view=register&action=register" >
    <div class="registionblock">
    	<!--HEADER-->
        
        <div class="header">
            <h3 class='title'>Register</h3>
        </div>
        <div style="clear:both"></div>
        <!--END HEADER-->
    	<!--CONTENT-->
        <div class="contentregister" >
            <table width="100%" style="border-spacing:9px;border-collapse: separate;padding-right:30px;">
                <tr>
                    <td><lable class="registerlable">Title</lable></td>
                    <td>
                        <select class="input username " name="title" id="title" data-validation="titlerequire" >
                        <option value="a">--Select--</option>
                        <option value="ms">&nbsp;&nbsp;Ms.</option>
                        <option value="mr">&nbsp;&nbsp;Mr.</option>
                        <option value="dr">&nbsp;&nbsp;Dr.</option>
                        </select><span class="help-block form-error"> </span>
                    </td>
                </tr>
                <tr>
                    <td><lable class="registerlable">First name</lable></td>
                    <td><input name="first_name" type="text" class="input username " placeholder="First name"  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Middle name</lable></td>
                    <td><input name="middle_name" type="text" class="input username " placeholder="Middle name"  /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Last name</lable></td>
                    <td><input name="last_name" type="text" class="input username " placeholder="Last name"  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Designation</lable></td>
                    <td><input name="designation" type="text" class="input username " placeholder="Designation"  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Division/ department</lable></td>
                    <td><input name="department" type="text" class="input username " placeholder="Division/ department"  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Company name</lable></td>
                    <td><input name="company" type="text" class="input username " placeholder="Company name"  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Address line 1</lable></td>
                    <td><input name="address_one" type="text" class="input username " placeholder="Address line 1"  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Address line 2</lable></td>
                    <td><input name="address_two" type="text" class="input username " placeholder="Address line 2"  /></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">City</lable></td>
                    <td>
                        <table wdith="100%">
                            <tr>
                                <td width="42%"><input name="city" type="text" style="width: 100%" class="input username " placeholder="City"  data-validation="required" data-validation-error-msg=" "/></td>
                                <td  width="22%%"><lable class="registerlable">State</lable></td>
                                <td><input name="state" type="text" style="width: 100%"  class="input username " placeholder="State"  data-validation="required" data-validation-error-msg=" "/></td>
                        </table>
                        </td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Pin code</lable></td>
					<td ><input name="zip" type="text" style="width: 100%" class="input username " placeholder="Pin code"  data-validation="required" data-validation-error-msg=" "/></td>

                    
                </tr>
                <tr>
                    <td><lable class="registerlable">Email id</lable></td>
                    <td><input name="email" id="email" type="text" class="input username " onblur="checkDublicateEmail()" placeholder="Enter valid email id. Your password will be sent here"  data-validation="email" data-validation-error-msg=" "/></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Retype email id</lable></td>
                    <td><input name="re_email"  id="re_email" type="text" class="input username " placeholder="Retype email id"  data-validation="re-type" /><span class="help-block form-error"> </span></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Phone no.</lable></td>
                    <td><input name="phone" type="text" class="input username " placeholder="Phone no."  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Fax no.</lable></td>
                    <td><input name="fax" type="text" class="input username " placeholder="Fax no."   data-validation-error-msg=" "/></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Mobile no.</lable></td>
                    <td><input name="mobile" id="mobile" type="text" class="input username " placeholder="Mobile no."  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Retype mobile no.</lable></td>
                    <td><input name="re_mobile" id="re_mobile" type="text" class="input username " placeholder="Retype mobile no."  data-validation="re-type-mobile" /><span class="help-block form-error"> </span></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Ownership pattern of &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;company</lable></td>
                    <td>
                        <select class="input username " name="ownership" id="ownership" data-validation="ownerrequire" onchange='showHideOtherOwnerShip(this)'  >
                        <option value="0">--Select--</option>
                        <?php
                        foreach($userOwnerShip as $ownerShip) {
                            if($ownerShip->id==5) {
                                echo "<option value='".$ownerShip->id."'>&nbsp;&nbsp;".$ownerShip->ownership_name."</option>" ;
                            } else {
                                echo "<option  value='".$ownerShip->id."'>&nbsp;&nbsp;".$ownerShip->ownership_name."</option>" ;
                            }
                            
                        }
                        ?>
                        </select>
                    </td>
                </tr>
                <tr id="otherownership" style="display:none;">
                    <td>&nbsp;</td>
                    <td><input name="other_ownership" id="other_ownership" type="text" class="input username " placeholder="Other"   data-validation="ownerrequireother" /></td>
                </tr>
                 <tr>
                    <td><lable class="registerlable">Industry</lable></td>
                    <td>
                        <select class="input username " name="industry" id="industry" data-validation="industryrequire" onchange='showHideOtherIndustry(this)'>
                        <option value="0">--Select--</option>
                        <?php
                            foreach($userIndustry as $industry) {
                                if($industry->id==12) {
                                    echo "<option  value='".$industry->id."'>&nbsp;&nbsp;".$industry->industry_name."</option>" ;
                                } else {
                                    echo "<option  value='".$industry->id."'>&nbsp;&nbsp;".$industry->industry_name."</option>" ;
                                }
                            }
                        ?>
                       </select>
                    </td>
                </tr>
                 <tr id="otherindustry" style="display:none;">
                    <td>&nbsp;</td>
                    <td><input name="other_industry" id="other_industry" type="text" class="input username " placeholder="Other"  data-validation="industryrequireother"/></td>
                </tr>
            </table>    
    	 <span class="help-block form-error"> </span>
         </div>
        <!--FOOTER-->
        <div class="footer" style="top: 1000px;">
        <!--LOGIN BUTTON--><input type="submit" name="submit" value="Register" class="button1" /><!--END LOGIN BUTTON-->
                <div id="bottomerrormsg" style="display:none;color:red">
          <p style="padding-left:40px;">Please fill all required fields</p>
      </div>
    </div>
    <!--END FOOTER-->
<?php echo getFormToken(); ?>
    <input type="hidden" name="created_date" value="<?php echo date('Y-m-d H:i:s'); ?>"; />
    <input type="hidden" name="modified_date" value="<?php echo date('Y-m-d H:i:s'); ?>"; />
     <input type="hidden" name="dublicatemail" id="dublicatemail" value="" data-validation="required" data-validation-error-msg=" "/>
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
	StmFactory::getApplication()->redirect('view=userprofile');
}
?>
<script>
function checkDublicateEmail() {
     checkdupblicat();
}

function checkdupblicat() {
  $.formUtils.addValidator({
      name : 'email',
      validatorFunction : function(value, $el, config, language, $form) {
        if($('#email').val() != '') {
            var regex = /^([a-zA-Z0-9_.])+\@(([a-zA-Z0-9])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(!regex.test($('#email').val())) {
                    return false;
                }
            $.ajax({type:"POST",url:"raw.php?view=register&action=checkDublicate",data:{thisemail:$('#email').val()},success:function(result){
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
        if($('#email').val() == '') {
          return false;
        }

        return true;
      },
      errorMessage : 'Email already Exists.',
      errorMessageKey: 'Email already Exists.'
    });
}



/*$(document).ready(function (){
    $.formUtils.addValidator({
      name : 'email',
      validatorFunction : function(value, $el, config, language, $form) {
            if($('#email').val() != '') {
                var regex = /^([a-zA-Z0-9_.])+\@(([a-zA-Z0-9])+\.)+([a-zA-Z0-9]{2,4})+$/;
                if(!regex.test($('#email').val())) {
                    return false;
                }
            }
        return true;
      },
      errorMessage : 'Email do not match.',
      errorMessageKey: 'Email do not match.'
    });
});*/

$(document).ready(function (){
    $.formUtils.addValidator({
      name : 're-type',
      validatorFunction : function(value, $el, config, language, $form) {
        if($('#email').val() != '') {
            if($('#email').val() != $('#re_email').val()){
                return false;
            }
        }
        return true;
      },
      errorMessage : 'Email do not match.',
      errorMessageKey: 'Email do not match.'
    });
});
//Mobile validation
$(document).ready(function (){
    $.formUtils.addValidator({
      name : 're-type-mobile',
      validatorFunction : function(value, $el, config, language, $form) {
        if($('#mobile').val() != '') {
            if($('#mobile').val() != $('#re_mobile').val()){
                return false;
            }
        }
        return true;
      },
      errorMessage : 'Mobile no. do not match.',
      errorMessageKey: 'Mobile no. do not match.'
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
            if($('#other_ownership').val().trim() == '') {
                return false;
            }
        }
        return true;
      },
      errorMessage : '',
      errorMessageKey: ''
    });
});

$(document).ready(function (){
    $.formUtils.addValidator({
      name : 'industryrequire',
      validatorFunction : function(value, $el, config, language, $form) {
        if($('#industry').val() == '0') {
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
            if($('#other_industry').val().trim() == '') {
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
if (thisobj.value==12) { document.getElementById('otherindustry').style.display='table-row';} else {document.getElementById('otherindustry').style.display='none';};
}

function showHideOtherOwnerShip(thisobj) {
if (thisobj.value==5) { document.getElementById('otherownership').style.display='table-row';} else {document.getElementById('otherownership').style.display='none';};
}

</script>
