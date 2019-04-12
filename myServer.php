<?php
/**
  * Socket 服务端
  */
//设置无限请求超时时间

set_time_limit(0);

$ip   = '127.0.0.1';
$port = 8088;

//创建socket
if(($sock = socket_create(AF_INET,SOCK_STREAM,SOL_TCP)) < 0){
	echo "socket_create() defeat is:".socket_strerror($sock)."\n";
	exit();
}

//把socket绑定在指定的IP地址和端口上
if(($ret = socket_bind($sock,$ip,$prot)) < 0){
	echo "socket_bind() defeat is:".socket_strerror($ret)."\n";
	exit();
}

//监听由指定socket的所有连接
if(($ret = socket_listen($sock,4)) < 0){
	echo "scoket_listen() defeat is:".socket_strerror($ret)."\n";
	exit();
}

$count = 0;

do{
	//接收一个Socket连接
	if(($msgsock = socket_accept($sock)) < 0){
		echo "socket_accept() failed reason:".socket_strerror($msgsock)."\n";
		break;
	} else{
		//发送到客户端
		$msg = "请问有什么需要帮助的吗？";
		socket_write($msgsock, $msg, strlen($mdg));
		echo "测试成功";
		//获取客户端的输入
		$buf = socket_read($msgsock, 2048);
		$talkbuf = "接收到的消息:$buf\n";
		echo $talkbuf;

		if(++$count >= 5){
			break;
		}
	}

	//关闭socket
	socket_close($msgsock);
}while(true);