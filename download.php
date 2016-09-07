<?php 
/**
 * Blog:http://stratumframework.blogspot.in/
 * Facebook: https://www.facebook.com/pages/Stratum/1374415309549296
 * Twitter: https://twitter.com/StratumFramwork
 */
if(isset($_GET['q']))
{
	$file = urldecode($_GET['q']);
	header("Content-Type: application/force-download");
	header( "Content-Disposition: attachment; filename=".basename($file));
	header( "Content-Description: File Transfer");
	@readfile($file);
	
}

?>