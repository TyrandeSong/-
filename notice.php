<?php  

class notice{
    
    /**
	 * Author   : Weizheng
	 * Date     : 2017-12-08 14:41:58 
	 * Describe : fsocket消息通知
	 * param    : uid  int 当前用户 Uid
	 * 			  jur  int 通知类型  1 所有用户 2 我的好友 3 指定id
	 * 			  tuid int 当 jur=3 时  tuid为要推送给的用户的uid
	 * 			  msg  arr 要推送给用户的消息
	 */
    public static function fsocknotice($uid,$jur=1,$tuid,array $msg){
         ignore_user_abort(true);
         set_time_limit(0);
         fn::WriteLog('Fsocket接收的内容'.json_encode(array($uid,$jur,$tuid,$msg)),__CLASS__);
         if (empty($uid) || empty($jur)) {
         	return false;
         }
         if($jur == 3 && empty($tuid)){
         	return false;
         }
		 $column          = array('uid' => $uid,'jur' => $jur,'tuid' => urlencode(serialize($tuid)), 'msg' => urlencode(serialize($msg)));
		 $param           = http_build_query($column);
		 $url             = 'http://'.$_SERVER['HTTP_HOST'].'/api/gateway.php?act=doSumThing&mod=inotice&'.$param;
		 $host            = parse_url($url,PHP_URL_HOST);
		 $port            = parse_url($url,PHP_URL_PORT);
		 $port            = $port ? $port : 80;
		 $scheme          = parse_url($url,PHP_URL_SCHEME);
		 $path            = parse_url($url,PHP_URL_PATH);
		 $query           = parse_url($url,PHP_URL_QUERY);
		 if($query) $path .= '?'.$query;
         if($scheme == 'https') {
           	$host = 'ssl://'.$host;
         }
         $fp = fsockopen($host,$port,$error_code,$error_msg,3);
         if(!$fp) {
           	 file_put_contents('fsocket.log', json_encode(array('error_code' => $error_code,'error_msg' => $error_msg)));
         }else {
             stream_set_blocking($fp,true);//开启了手册上说的非阻塞模式
             stream_set_timeout($fp,1);//设置超时
             $header = "GET $path HTTP/1.1\r\n";
             $header.="Host: $host\r\n";
             $header.="Connection: close\r\n\r\n";//长连接关闭
             fwrite($fp, $header);
             usleep(1000); // 这一句也是关键，如果没有这延时，可能在nginx服务器上就无法执行成功
             fclose($fp);
             return array('error_code' => 0);
         }
         fclose($fp); 
    }

    public static function WriteLog($log,$name='undefined'){
    	ignore_user_abort(true);
    	set_time_limit(0);
		$file = './log/'.date('Y-m-d',time());
		$filename = $file.'/'.$name.'.log';
        $dir = iconv("UTF-8", "GBK",$file);
        if (!file_exists($file)){
            mkdir ($dir,0777,true);
        }
		$logs     = date('Y-m-d H:i:s',time()).'  '.$log.PHP_EOL;
    	try {
    		file_put_contents($filename,$logs,FILE_APPEND);
    	} catch (Exception $e) {
    		self::WriteLog($e->getMessage(),__CLASS__);
    	}
    }

}