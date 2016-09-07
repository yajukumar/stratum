<?php
defined( 'STRATUM' )or die('Forbidden');
/**
 * Error handling for framework.
 * 
 * This php framework developed by Cware.
 *  * Blog:http://stratumframework.blogspot.in/
 * Facebook: https://www.facebook.com/pages/Stratum/1374415309549296
 * Twitter: https://twitter.com/StratumFramwork
 * 
 * LICENSE: Read license.txt
 * 
 * @package STRATUM
 * @author Mohneesh Bhargava <mohneesh@computerware.in><http://computerware.in>
 * @copyright 2014-2015
 * @license Read license.txt
 * @version 1.14
 * @since File available since Release 1.14
 */

 
class StmCache {
	
	private $root				= ""; 		// path to the local folder, YOU NEED WRITE PERMISSIONS (chmod 666 or 777)
	private $server_cache_time	= 300; 		// how long will be cached a file on server in seconds
	private $client_cache_time	= 150; 		// how long will be cached a file on browser in seconds
	private $cache_type			= 1; 		// 0 = no cache , 1 = server side cache, 2 = client side (browser) cache, 3 = both side cache
	private $attached_value		= ""; 		// COOKIE or SESSION values 
	private $page;							// Server URI like $_SERVER['REQUEST_URI']
	public $file_name; 						// the cache file name on server
	public $full_file_name; 				// full file path and name on local server
	public $need_update			= false; 	// if true then means the content will be saved locally in the path (full_file_name)
	public $file_extension		= "html"; 	// usefull to check the cache content faster


	public function initiateCache($root="",$cache_type=-1, $attached_value="") {

		if ($root!=""){
			$this->setRoot($root);
		}
		if ($attached_value!=""){	
			$this->attachValue($attached_value);
		}
		if ($cache_type!=-1){
			$this->setCacheType($cache_type);
		}
	}

	// will start caching process
	function startCache(){ 					
		if ($this->cache_type==1){
			$this->setServerSideCache();
			$this->setClientCacheTime(0);
		}
		else if ($this->cache_type==2){
			$this->setClientSideCache();
			$this->setServerCacheTime(0);
		}
		else if ($this->cache_type==3){
			$this->setClientSideCache();
			$this->setServerSideCache();
		}
		else {
			$this->setCacheTime(0);
			$this->setClientSideCache(); 
		}
	}
	//will set root folder (without last "/"
	function setRoot($root) { 			
		$this->root = $root;
	}
	
	//will set cacheType: 0 = no cache , 1 = server side cache, 2 = client side (browser) cache, 3 = both side cache
	function setCacheType($cache_type) { 
		$this->cache_type = $cache_type;
	}
	
	//will set cacheType: 0 = no cache , 1 = server side cache, 2 = client side (browser) cache, 3 = both side cache
	function setFileExtension($file_extension) { 
		$this->file_extension = $file_extension;
	}

	// will set client cache time (in seconds)
	function setClientCacheTime($time) { 
		$this->client_cache_time = $time;
	}
	
	// will set server cache time (in seconds)
	function setServerCacheTime($time) { 
		$this->server_cache_time = $time;
	}
	
	// will set both client and server cache time (in seconds)
	function setCacheTime($time) { 
		$this->setClientCacheTime($time);
		$this->setServerCacheTime($time);	
	}
	
	// will attach value related to the cache file , example : USER session or USER cookie, or a test value
	function attachValue($value) { 
		$this->attached_value = $value;
	}
	
	//will prepare system for file caching (server side)
	function startFileCache() { 
		$this->need_update = true;
		ob_start();
	}
	
	//will set headers for client side caching
	function setClientSideCache() { 
		
		if  ($this->client_cache_time>0) {
			$time_format = gmdate("D, d M Y H:i:s", time() + $this->client_cache_time) . " GMT";
			header("Expires: ".$time_format);
			header("Pragma: cache");
			header("Cache-Control: max-age=".$this->client_cache_time);
		}
		else {
			header('Cache-Control: no-cache');
			header('Pragma: no-cache');
		}

	}
	
	// is checking if the file is already there and not expired (in the interval of  "server_cache_time" seconds you set
	function setServerSideCache() { 				

		if ($this->server_cache_time<=0) {
			return;
		}
		$this->page			= $_SERVER['REQUEST_URI'];
		$sanitize		 	= preg_replace("/[^a-zA-Z0-9]+/", "",$_SERVER['PHP_SELF']);
		$this->file_name	= $sanitize."-".substr(md5($this->page),10,16); 			//will generate a file name, you can put any rule you want here

		if (strlen($this->attached_value)>0) { 
			$this->file_name.= "-".$this->attached_value; 
		}
		if (strlen($this->file_extension)>0) { 
			$this->file_name.= ".".$this->file_extension; 
		}

		$this->full_file_name	= $this->root."/".$this->file_name;

		if (file_exists($this->full_file_name)) {
			$file_time	= filemtime($this->full_file_name);
			$now_time	= time(false);
			
			if (($file_time-$now_time)>=$this->server_cache_time) {  
				$this->startFileCache(); 
			} // if the cache file is expired then will be replaced with a more recent one
			else {
				@readfile($this->full_file_name);
				die(""); // if the cache file is not expired then will only diplay the content and the script will stop
			}
		} 
		else {
			$this->startCacheNow(); // if the cache file is not created will simply create a new one
		}

	}

	function callback($buffer) {
		return $buffer.$this->saveFile($buffer);
	}	
	
	// this will save the cache file  , can be used fopen or any method for writting, even query in a database
	function saveFile($content) { 

		if ($file = @fopen($this->full_file_name, "wb")){
			@fwrite($file, $content);
			@fclose($file);
		} 	 
		return "";
	}

	function startCacheNow() {
		$this->need_update	= true;
		ob_start(array(&$this, 'callback'));
	}


	
} // StmCache Class ends here....

?>