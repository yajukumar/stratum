<?php
include dirname(__FILE__).'/../../application/migrations/Migration.php';
//php system/cli/index.php  migrate:HdfcFintechDeviceId
   $option = explode(':', $argv[1]);
   //echo 'Controller='.$option[0];
  // echo "\n";
  // echo 'Method='.$option[1];
  // echo "\n";
  if($option[0]=='migrate'){
      if(strlen($option[1]) > 1){
         include dirname(__FILE__).'/../../application/migrations/'.$option[1].'.php';
         $compact_params = array('test'=>'Test value');
         $migration = new $option[1];
         call_user_func_array(array($migration, 'up'), $compact_params);
      }
  }
?>