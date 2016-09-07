<?php
StmFactory::getApplication()->setDocumentTitle('Register');
$defaultview = StmViewUtil::getDefaultView();
if(!StmFactory::getSession()->get('userid')) {
?>
<h1>Activation</h1>
<form   autocomplete="on" name="activationForm" class="form-3" method="post" action="?view=register&action=activate" >
    <div class="registionblock">
        <div class="contentregister" >
            <table width="100%" style="border-spacing:9px;border-collapse: separate;padding-right:30px;">
                <tr>
                    <td><lable class="registerlable">Token</lable></td>
                    <td><input name="security_token:required" type="text" class="input username " placeholder="Token"  data-validation="required" data-validation-error-msg=" "/></td>
                </tr>
                
            </table>    
    	 <span class="help-block form-error"> </span>
         </div>
        <!--FOOTER-->
        <div class="footer" style="top: 1000px;">
        <!--LOGIN BUTTON--><input type="submit" style="float: left;margin-left: 100px;" name="submit" value="Submit" class="button1" /><!--END LOGIN BUTTON-->
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