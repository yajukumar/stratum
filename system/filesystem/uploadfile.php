<?php 
defined( 'STRATUM' )or die('Forbidden');
/**
 * File upload handling for framework.
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
class StmUpload extends FileSystem { 

    var $temp_file_name; 
    var $file_name; 
    var $upload_dir; 
    var $upload_log_dir;   
    var $max_file_size; 
    var $banned_array; 
    var $ext_array; 

	function __construct() {
		$logfile = StmConfig::$log_file;     // get path from config
		$this->upload_log_dir = $logfile;    // log file path set
	}
	
//************ Validate file extensions *************************	
	function validateExtension() { 
 
		$file_name = trim($this->file_name); 
		$extension = strtolower(strrchr($file_name,".")); 
		$ext_array = $this->ext_array; 
		$ext_count = count($ext_array); 

 
		if (!$file_name) { 
			return false; 
		} 
		else { 
			if (!$ext_array) { 
				return true; 
			} 
			else { 
				foreach ($ext_array as $value) { 
					$first_char = substr($value,0,1); 
					if ($first_char <> ".") { 
						$extensions[] = ".".strtolower($value); 
					} 
					else { 
						$extensions[] = strtolower($value); 
					} 
				} 

				foreach ($extensions as $value) { 
					if ($value == $extension) { 
						$valid_extension = "TRUE"; 
					}                 
				} 

				if ($valid_extension) { 
					return true; 
				} 
				else { 
					return false; 
				} 
			} 
		} 
	} 
	
//************ Validate file size *************************	
	function validateSize() { 
		$temp_file_name = trim($this->temp_file_name); 
		$max_file_size 	= trim($this->max_file_size); 

		if ($temp_file_name) { 
			$size = filesize($temp_file_name); 
				if ($size > $max_file_size) { 
					return false;                                                         
				} else { 
					return true; 
				} 
		} 
		else { 
			return false; 
		}     
	}
	
//************ Check file existence *************************	
	function existingFile() { 
		$file_name 	= trim($this->file_name); 
		$upload_dir = $this->getUploadDirectory(); 

		if ($upload_dir == "ERROR") { 
			return true; 
		} 
		else { 
			$file = $upload_dir . $file_name; 
			if (file_exists($file)) { 
				return true; 
			} 
			else { 
				return false; 
			} 
		}     
	}

//************ Getting file size *************************	
	function getFileSize() { 

		$temp_file_name = trim($this->temp_file_name); 
		$kb = 1024; 
		$mb = 1024 * $kb; 
		$gb = 1024 * $mb; 
		$tb = 1024 * $gb; 
 
        if ($temp_file_name) { 
            $size = filesize($temp_file_name); 
            if ($size < $kb) { 
                $file_size = "$size Bytes"; 
            } 
            elseif ($size < $mb) { 
                $final = round($size/$kb,2); 
                $file_size = "$final KB"; 
            } 
            elseif ($size < $gb) { 
                $final = round($size/$mb,2); 
                $file_size = "$final MB"; 
            } 
            elseif($size < $tb) { 
                $final = round($size/$gb,2); 
                $file_size = "$final GB"; 
            } 
			else { 
                $final = round($size/$tb,2); 
                $file_size = "$final TB"; 
            } 
        } 
		else { 
            $file_size = "ERROR: NO FILE PASSED TO getFileSize()"; 
        } 
        return $file_size; 
	} 
	
//************ Getting maximum file size limit *************************	
	function getMaxSize() { 
		$max_file_size = trim($this->max_file_size); 
		$kb = 1024; 
		$mb = 1024 * $kb; 
		$gb = 1024 * $mb; 
		$tb = 1024 * $gb; 

		if ($max_file_size) { 
			if ($max_file_size < $kb) { 
				$max_file_size = "$max_file_size Bytes"; 
			} 
			elseif ($max_file_size < $mb) { 
				$final = round($max_file_size/$kb,2); 
				$max_file_size = "$final KB"; 
			} 
			elseif ($max_file_size < $gb) { 
				$final = round($max_file_size/$mb,2); 
				$max_file_size = "$final MB"; 
			} 
			elseif($max_file_size < $tb) { 
				$final = round($max_file_size/$gb,2); 
					$max_file_size = "$final GB"; 
			} 
			else { 
				$final = round($max_file_size/$tb,2); 
				$max_file_size = "$final TB"; 
			} 
		} 
		else { 
			$max_file_size = "ERROR: NO SIZE PARAMETER PASSED TO  getMaxSize()";
		} 
		return $max_file_size; 
	} 
	
//************ Validate User  *************************	
	function validateUser() { 
		$banned_array 	= $this->banned_array; 
		$ip 			= trim($_SERVER['REMOTE_ADDR']); 
		$cpu 			= gethostbyaddr($ip); 
		$count 			= count($banned_array); 

		if ($count < 1) { 
			return true; 
		} 
		else { 
			foreach($banned_array as $key => $value) { 
				if ($value == $ip ."-". $cpu) { 
					return false; 
				} 
				else { 
					return true; 
				} 
			} 
		} 
	}
	
	
//************ Getting file upload directory *************************	
	function getUploadDirectory() { 
		$upload_dir = trim($this->upload_dir); 

		if ($upload_dir) { 
			$ud_len = strlen($upload_dir); 
			$last_slash = substr($upload_dir,$ud_len-1,1); 
				if ($last_slash <> "/") { 
					$upload_dir = $upload_dir."/"; 
				} 
				else { 
						$upload_dir = $upload_dir; 
				} 

			$handle = @opendir($upload_dir); 
				if ($handle) { 
					$upload_dir = $upload_dir; 
					closedir($handle); 
				} 
				else { 
					$upload_dir = "ERROR"; 
				} 
		} 
		else { 
			$upload_dir = "ERROR"; 
		} 
		return $upload_dir; 
	}
		
		
//************ Getting upload log file directory *************************		
	function getUploadLogDirectory() { 
		$upload_log_dir = trim($this->upload_log_dir); 
		if ($upload_log_dir) { 
			$ud_len 	= strlen($upload_log_dir); 
			$last_slash = substr($upload_log_dir,$ud_len-1,1); 
				if ($last_slash <> "/") { 
					$upload_log_dir = $upload_log_dir."/"; 
				} 
				else { 
					$upload_log_dir = $upload_log_dir; 
				} 
				$handle = @opendir($upload_log_dir); 
					if ($handle) { 
						$upload_log_dir = $upload_log_dir; 
						closedir($handle); 
					} 
					else { 
						$upload_log_dir = "ERROR"; 
					} 
		} 
		else { 
			$upload_log_dir = "ERROR"; 
		} 
		return $upload_log_dir; 
	} 	
	
	
//************ Upload file without validation *************************	
	function uploadFileNoValidation() { 
		$temp_file_name = trim($this->temp_file_name); 
		$file_name 		= trim(strtolower($this->file_name)); 
		$upload_dir 	= $this->getUploadDirectory(); 
		$upload_log_dir = $this->getUploadLogDirectory(); 
		$file_size 		= $this->getFileSize(); 
		$ip 			= trim($_SERVER['REMOTE_ADDR']); 
		$cpu 			= gethostbyaddr($ip); 
		$m 				= date("m"); 
		$d 				= date("d"); 
		$y 				= date("Y"); 
		$date 			= date("m/d/Y"); 
		$time 			= date("h:i:s A"); 

		if (($upload_dir == "ERROR") OR ($upload_log_dir == "ERROR")) { 
			return false; 
		} 
		else { 
			if (is_uploaded_file($temp_file_name)) { 
				if (move_uploaded_file($temp_file_name,$upload_dir . $file_name)) { 
					$log = $upload_log_dir.$y."_".$m."_".$d.".txt"; 
					$fp = fopen($log,"a+"); 
					fwrite($fp,"$ip-$cpu | $file_name | $file_size | $date | $time"); 
					fclose($fp); 
					return true; 
				} 
				else { 
					return false;     
				} 
			} 
			else { 
				return false; 
			} 
		} 
	}

	
//************ Upload file with validation *************************	
	function uploadFileWithValidation() { 
		$temp_file_name = trim($this->temp_file_name); 
		$file_name 		= trim(strtolower($this->file_name)); 
		$upload_dir 	= $this->getUploadDirectory(); 
		$upload_log_dir = $this->getUploadLogDirectory(); 
		$file_size 		= $this->getFileSize(); 
		$ip 			= trim($_SERVER['REMOTE_ADDR']); 
		$cpu 			= gethostbyaddr($ip); 
		$m 				= date("m"); 
		$d 				= date("d"); 
		$y 				= date("Y"); 
		$date 			= date("m/d/Y"); 
		$time 			= date("h:i:s A"); 
		$existing_file 	= $this->existingFile();  		  	// Check file exist or not
		$valid_user 	= $this->validateUser();       		// Check user banned or not 
		$valid_size 	= $this->validateSize();        	// Check file size allowed or not
		$valid_ext 		= $this->validateExtension();    	// Check file ext. valid or not 

		if (($upload_dir == "ERROR") OR ($upload_log_dir == "ERROR")) { 
			return false; 
		} 
		elseif ((((!$valid_user) OR (!$valid_size) OR (!$valid_ext) OR ($existing_file)))) { 
			return false; 
		} 
		else { 
			if (is_uploaded_file($temp_file_name)) { 
				if (move_uploaded_file($temp_file_name,$upload_dir . $file_name)) { 
					$log = $upload_log_dir.$y."_".$m."_".$d.".txt"; 
					$fp = fopen($log,"a+"); 
					fwrite($fp,"$ip-$cpu | $file_name | $file_size | $date | $time"); 
					fclose($fp); 
					return true; 
				} 
				else { 
					return false; 
				} 
			} 
			else { 
				return false; 
			} 
		} 
	} 
	
	
	
}	// ---   class ends here.......
?>