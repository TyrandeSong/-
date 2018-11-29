<?php
	error_reporting(0);
		//判断PHP运行模式
	//echo php_sapi_name();die;
	/*$dir = str_replace("\\","/",__DIR__);
	chmod($dir, 0777);*/
	$link = mysqli_connect('192.168.203.203:3388','bazi','ARJapEu6cvTKSS5B','bazi_cmp');  //八字测试库
	$nums = 1000;
	$all  = array();
	$year = array();
	mysqli_query($link, 'BEGIN'); 
	for($i = 0; $i < 100; $i++){
		$data = array();
		$tbl = "bazi_cmp.cmp_u".$i;
		//echo $tbl.PHP_EOL;
		$sql = "select cid,uid,rname,note,createtime,pid,tags from $tbl;";
		$query = mysqli_query($link,$sql);

		while(($arr=mysqli_fetch_assoc($query))!=false)
		{
			$contents  = "";
			$years    = "";
			$notes    = "";
			$imgs     = "";
			//对比记录content
			$tbl_con = "bazi_cmpudata.cmpudata_u".$i;
			$sql_con = "select udid,rdid,cid,uid,rname,addtime,mingju,igender,birthsolar,birthlunar,isleap,birthtime,yearTianGan,yearDiZhi,monthTianGan,monthDiZhi,dayTianGan,dayDiZhi,hourTianGan,hourDiZhi from $tbl_con where cid = {$arr['cid']};";
			$query2 = mysqli_query($link,$sql_con);
			if($query2){
				while(($arr2=mysqli_fetch_assoc($query2))!=false){
					$content[] = $arr2;
				}
				if($content){
					$contents = json_encode($content);
				}
				unset($content);
			}

			//对比记录流年事迹
			$tbl_y = "bazi_cmpNote.cmp_year".$i;
			$sql_y = "select yid as id,year,content as note,createtime as addtime from $tbl_y where cid = {$arr['cid']};";
			$query3= mysqli_query($link,$sql_y);
			if($query3){
				while(($arr3=mysqli_fetch_assoc($query3))!=false){
					$year[] = $arr3;
				}
				if($year){
					$years = json_encode($year);
				}
				unset($year);
			}
			

			//对比记录图片
			$tbl_pic = "bazi_cmpNote.cmp_pic".$i;
			$sql_pic = "select pic from $tbl_pic where cid = {$arr['cid']};";
			//echo $sql_n;
			$query5 = mysqli_query($link,$sql_pic);
			if($query5){
				while(($arr5=mysqli_fetch_assoc($query5))!=false){
					$pic[] = $arr5;
				}
				if($pic){
					$pic = array_column($pic, "pic");
					$imgs = json_encode($pic);
				}
				unset($pic);
			}


			$tbl_n = "bazi_cmpNote.cmp_note".$i;
			$sql_n = "select pid as cid,content,createtime,creator as rname,ftype,audioInfo,uid from $tbl_n where cid = {$arr['cid']};";
			//echo $sql_n;
			$query4 = mysqli_query($link,$sql_n);
			if($query4){
				while(($arr4=mysqli_fetch_assoc($query4))!=false){
					$note[] = $arr4;
				}
				if($note){
					$notes = json_encode($note);
				}
				unset($note);
			}


			$arr['content'] = empty($contents)? "" : $contents;
			$arr['liunian'] = empty($years)? "" : $years;
			$arr['comment'] = empty($notes)? "" : $notes;
			$arr['img'] = empty($imgs)? "" : $imgs;
			$data[] = $arr;
		}
		//print_r($data);
		$size = count($data);
		if($size>0){
			//由于一张表中数据量过大，分批插入
			fun($link,$data,0,$i,$nums);		
		}
	}
	mysqli_query($link, 'COMMIT'); 
	echo "success";





function fun($link,array $arr,$index = 0,$i,$nums){
	$count = count($arr);
	$dir = str_replace("\\","/",__DIR__);
	$new = array_slice($arr,$index,$nums,true);
	$values = "";
	foreach ($new as $key => $a) {
		foreach($a as $k => $v){
			$a[$k]=addslashes($v);
		}
	
		if(empty($values)){
			$values = "values('{$a['cid']}',{$a['uid']},'{$a['rname']}','{$a['content']}','{$a['note']}','{$a['createtime']}','{$a['pid']}','{$a['tags']}','{$a['liunian']}','{$a['comment']}','{$a['img']}')";
		}else{
			$values.=",('{$a['cid']}',{$a['uid']},'{$a['rname']}','{$a['content']}','{$a['note']}','{$a['createtime']}','{$a['pid']}','{$a['tags']}','{$a['liunian']}','{$a['comment']}','{$a['img']}')";
		}
	}
	$tblAdd = "bazi_cmprecord.cmprecord_u".$i;
	$add = "replace into ".$tblAdd."(cid,uid,rname,content,note,createtime,pid,tags,liunian,comment,img) ".$values.";";
	//echo $add.PHP_EOL;
	$ret = mysqli_query($link,$add);
	//echo $add;
	var_dump($ret);
	$log = $add.PHP_EOL;
	file_put_contents($dir."/mycmp.log",$log,FILE_APPEND);
	$index += $nums;
	if($index < $count){
		fun($link,$arr,$index,$i,$nums);
	}
}
