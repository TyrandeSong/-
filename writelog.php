<?php
//记录日志的方法。
class help{

	public function writelog($log, $name = 'undefined'){
		$dir 	  = './log/'.date('Y-m-d',time());
		$filename = $dir.'/'.$name.'.log';
		
		var_dump(__CLASS__);

		if(!file_exists($filename)){
			mkdir ($dir,0777,true);
		}
		$logs = date('Y-m-d H:i:s',time()).'  '.$log.PHP_EOL;
		try {
	    	file_put_contents($filename,$logs,FILE_APPEND);
	    } catch (Exception $e) {
	    	writeLog($e->getMessage(),__CLASS__);
	    }
	}

} 
date_default_timezone_set("Asia/Shanghai");
(new help())->writelog('测试','test');