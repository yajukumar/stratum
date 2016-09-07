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
 
StmFactory::getApplication()->setDocumentTitle('Forgot Password');
	$model = $this->getModel();
	$question = $model->getUserQuestionByUserId($uid);
?>
<form class="login-form" autocomplete="off" name="forgotPass" method="post" action="?view=forgot_pass&action=sendPassword">
	<div class="logo">
		<img alt="Logo Silicon Valley Memory Clinic Inc" src="application/templates/memoryclinic/img/logo-img.png">
	</div>
	<!--HEADER-->
    <div class="header">
    <!--TITLE--><h1>Security Questions</h1><!--END TITLE-->
    <!--DESCRIPTION--><span>Please Answer below questions!</span><!--END DESCRIPTION-->
    </div>
    <!--END HEADER-->
	
	<!--CONTENT-->
    <div class="content">
	<div class="questions"><b>Q1.</b> <?php echo $question[0]->question;?></div>
	<!--PASSWORD--><span><input name="u_ans[]" type="text" class="input u_ans" placeholder="Answer1" data-validation="required" data-validation-error-msg="Please answer first question!" /><!--END PASSWORD--></span>
	<div class="questions"><b>Q2.</b> <?php echo $question[1]->question;?></div>
	<!--PASSWORD--><span><input name="u_ans[]" type="text" class="input u_ans" placeholder="Answer2" data-validation="required" data-validation-error-msg="Please answer second question!" /><!--END PASSWORD--></span>	
 
    </div>
    <!--END CONTENT-->
    
    <!--FOOTER-->
    <div class="footer">
    <!--LOGIN BUTTON--><input type="submit" name="submit" value="Submit" class="button" /><!--END LOGIN BUTTON-->
  
	
    </div>
    <!--END FOOTER-->
<?php echo getFormToken(); ?>
<input type="hidden" name="user_q[]" value="<?php echo $question[0]->id; ?>">
<input type="hidden" name="user_q[]" value="<?php echo $question[1]->id; ?>">
<input type="hidden" name="user_id" value="<?php echo $uid; ?>">
</form>
