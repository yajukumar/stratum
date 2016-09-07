<?php
StmFactory::getApplication()->setDocumentTitle('Register');
$defaultview = StmViewUtil::getDefaultView();
if(!StmFactory::getSession()->get('userid')) {
?>
<h1>Register</h1>
<form   autocomplete="on" name="loginForm" class="form-3" method="post" action="?view=register&action=register" >
    <div class="registionblock">
        <div class="contentregister" >
            <table width="100%" style="border-spacing:9px;border-collapse: separate;padding-right:30px;">
                <tr>
                    <td><lable class="registerlable">First name</lable></td>
                    <td><input name="first_name:required" type="text" class="input username " placeholder="First name"  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Last name</lable></td>
                    <td><input name="last_name:required" type="text" class="input username " placeholder="Last name"  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Email id</lable></td>
                    <td><input name="email:required" id="email" type="text" class="input username "  placeholder="Enter valid email id."  data-validation="email" data-validation-error-msg=" "/></td>
                </tr>
                <tr>
                    <td><lable class="registerlable">Username</lable></td>
                    <td><input name="username:required" type="text" class="input username " placeholder="First name"  data-validation="required" data-validation-error-msg=" "/></td>
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
</div>
    <!--END FOOTER-->
<?php
echo getFormToken(); ?>
</form>
<?php
} else {
    StmFactory::getApplication()->redirect('view='.$defaultview[0]->view);
}
?>