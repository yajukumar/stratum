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
 * @since File available since Release 1.14
 */
 
class StmUrl {
    public function getSiteUrl() {
        // Determine if the request was over SSL (HTTPS).
        if (isset($_SERVER['HTTPS']) && !empty($_SERVER['HTTPS']) && (strtolower($_SERVER['HTTPS']) != 'off')){
            $https = 's://';
        }else{
            $https = '://';
        }
        
        // determine if we are running on apache or IIS.  If PHP_SELF and REQUEST_URI
        if (!empty($_SERVER['PHP_SELF']) && !empty($_SERVER['REQUEST_URI'])){
            // To build the entire URI we need to prepend the protocol, and the http host
            // to the URI string.
            $siteUrl = 'http' . $https . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        } else {
            $siteUrl = 'http' . $https . $_SERVER['HTTP_HOST'] . $_SERVER['SCRIPT_NAME'];
            // If the query string exists append it to the URI string
            if (isset($_SERVER['QUERY_STRING']) && !empty($_SERVER['QUERY_STRING'])){
            $siteUrl .= '?' . $_SERVER['QUERY_STRING'];
        }
        
        }
        return $siteUrl;
    }
}
?>