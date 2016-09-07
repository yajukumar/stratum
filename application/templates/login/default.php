<?php
//echo '<pre>' ;
//print_r($this->getTemplate());
/**
 * This Template developed by Cware.
 * Blog:http://stratumframework.blogspot.in/
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
 * @since File available since Release 1.14
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta http-equiv="content-type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge" />
<title></title>
<stm head />
</head>

	<stm top />
	<stmmessage>
	<stm view />
	<div style="clear:both"></div>
	<stm bottom />

<script src="<?php echo TEMPLATE_ROOT_PATH;?>/<?php echo $this->getTemplate();?>/javascript/form/jquery.form-validator.min.js" type="text/javascript"></script>
<!-- Form Validation Script Start -->
<script>
$(document).ready(function(){
	$.validate({
		validateOnBlur : true, // disable validation when input looses focus
		errorMessagePosition : 'bottom' // Instead of 'element' which is default
	});
});	
</script>
</body>
</html>