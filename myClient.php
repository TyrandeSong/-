<?php 
header("Content_Type:text/html;charset = utf-8");

error_reporting(E_ALL);

set_time_limit(0);

echo "TCP/TP Connection\n";

$ip   = '127.0.0.1';
$port = 8088;

//创建socket 
if(($socket = socket_create(AF_INET,SOCK_STREAM,SOL_TCP)) < 0){
	echo "socket_create() failed reason:".socket_strerror($socket)."\n";
	exit();
}

echo "试图连接 $ip 端口 $port ...\n";
//var_dump(socket_connect($socket,$ip,$port));
if(($result = socket_connect($socket,$ip,$port)) < 0){
	echo 123456;
	echo "socket_connect() failed reason:".socket_strerror($result)."\n";
	exit();
}

echo "连接OK\n";

$in  = "hellow HHHH\r\n";
$out = "";

//写数据到socket缓存
if($result = socket_write($socket,$in,strlen($in)) < 0){
	echo "socket_write() failed reason:".socket_strerror($result)."\n";
	exit();
}

echo "发送信息到服务器成功！发送内容：$in\n";

//读取指定长度的数据

while($out = socket_read($socket, 2048)){
	echo "接收服务器返回数据成功！内容为：$out\n";
}

echo "关闭SOCKET...\n";
socket_close($socket);
echo "关闭OK\n";