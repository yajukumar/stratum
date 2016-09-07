<?php
/* 
 * @category   Session
 * @package    STRATUM
 * @author     Mukesh Singh
 * @copyright  2014-2015
 * @license    Read license.txt
 * @version    Release: 1.13
 * @since File available since Release 1.13 
*/
	class Session
	{
		/*
		* set a session variable
		*/
		function set($var,$val)
		{
			$_SESSION[$var] = $val;
		}
		/*
		* delete a session variable
		*/
		function remove($var)
		{
			unset($_SESSION[$var]);
		}
		/*
		* get value of a session variable
		*/
		function get($var)
		{
			if(isset($_SESSION[$var]))
			{
				return $_SESSION[$var];
			}
			else
			{
				return false;
			}
		}
		/*
		* delete all session variables
		*/
		function deleteSessionData()
		{
			session_unset();
		}
	}
?>