<?php
	
	/*$db = array(
			'host' 	   => 'localhost',
			'username' => 'root', 
			'password' => 'song',
			'dbname'   => 'project'
	);*/

	$db = array(
			'host' 	   => '192.168.200.171:3388',
			'username' => 'chiyan', 
			'password' => '123456',
			'dbname'   => 'dev_pb', 	 
	);

	$conn = mysqli_connect($db['host'],$db['username'],$db['password'],$db['dbname']) or die ("数据连接错误:".mysqli_connect_error());
     
     //var_dump($conn);die;  
    $sql = "select cname,username from pb_user where id = 2786;";   
    $res = mysqli_query($conn,$sql);
    if($res){
    	while ($row = mysqli_fetch_assoc($res)) {
    		$rows[] = $row;
    	}
    }
    print_r($rows);

	/*// mysqli_select_db($conn,'project');     
	mysqli_query($conn,"set names 'UTF-8'"); //使用UTF-8中文编码;     
	//开始一个事务     
	mysqli_query($conn,"BEGIN"); //或者mysql_query("START TRANSACTION"); 
	//$sql3 = "select * from stu_info;";     
	$sql = "INSERT INTO `stu_info` (`name`, `sex`, `age`) VALUES ('武松', '1', '30')";     
	$sql2 = "INSERT INTO `stu_info` (`name`, `sex`, `age`) VALUES ('燕青', '1', '25')";//这条我故意写错     
	//$res2 = mysqli_query($conn,$sql3);
	$res = mysqli_query($conn,$sql);     
	$res1 = mysqli_query($conn,$sql2);
	//var_dump($res2);      
	if($res && $res1){     
	mysqli_query($conn,"COMMIT");     
	echo '提交成功。';     
	}else{     
	mysqli_query($conn,"ROLLBACK");     
	echo '数据回滚。';     
	}     
	mysqli_query($conn,"END");  */

