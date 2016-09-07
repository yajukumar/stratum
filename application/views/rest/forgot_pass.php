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
 * @author Yajuvendra <yajukumar@gmail.com><http://yajukumar.wordpress.com>
 * @copyright 2014-2015
 * @license Read license.txt
 * @version 1.14
 * @since File available since Release 2.14
 */
StmFactory::getApplication()->setDocumentTitle('Forgot Password');
?>

<form class="leftlogin" autocomplete="off" name="forgotPass" method="post" action="?view=forgot_pass&action=sendPassword">
<br/>
	<div class="header">
            <h3 class='title'>Forgot Password</h3>
        </div>
    <!--END HEADER-->
	<!--CONTENT-->
    
    <div class="content">Username/Email
	<!--USERNAME--><input name="userid" type="text" class="input username" placeholder="Username/Email"  data-validation="email" data-validation-error-msg="Please enter Username/Email!"/><!--END USERNAME--><span ></span>  
    <br/><br/><br/>
    <!--LOGIN BUTTON--><input type="submit" name="submit" value="Submit" class="button" /><!--END LOGIN BUTTON-->
    <br/><br/>
  <br/><br/>
    </div>
    <!--END FOOTER-->
<?php echo getFormToken(); ?>
</form>


