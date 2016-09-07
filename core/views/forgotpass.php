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
<h3 class='title'>Forgot Password</h3>
<form class="form-3" autocomplete="off" name="forgotPass" method="post" action="?view=register&action=sendPassword">
<br/>
    <!--END HEADER-->
	<!--CONTENT-->
    <p class="clearfix">
                <label for="login">Email</label>
               <input name="email:required" type="text" class="input username" placeholder="Email"  data-validation="email" data-validation-error-msg="Email!"/><!--END USERNAME--><span ></span>
            </p>
    <p class="clearfix">
	   <input type="submit" name="submit" value="Submit">
    </p>
    <!--END FOOTER-->
<?php echo getFormToken(); ?>
</form>


