<?php
	error_reporting(0);
		//判断PHP运行模式
	//echo php_sapi_name();die;
/*	$dir = str_replace("\\","/",__DIR__);
	chmod($dir, 0777);*/
	$link = mysqli_connect('192.168.203.203:3388','bazi','ARJapEu6cvTKSS5B','bazi_udata');  //八字测试库
	$nums = 1000;
	$all  = array();
	$year = array();
	mysqli_query($link, 'BEGIN'); 
	for($i = 0; $i < 100; $i++){
		$data = array();
		$tbl = "bazi_udata.udatas_u".$i;
		//echo $tbl.PHP_EOL;
		$sql = "select udid,uid,relation,specialty,mingju,rname,igender,birthsolar,birthlunar,isleap,birthtime,umobile,upicture,yearTianGan,yearDiZhi,monthTianGan,monthDiZhi,dayTianGan,dayDiZhi,hourTianGan,hourDiZhi,country,province,city,did,spicture,mpicture,srecord,usign,tags,permission,createtime,lid,rmark,mtime,catid,cpicture,isshare,readcount,p_count,sharetime,smallPic,mPHeadPic,source,del from $tbl;";
		$query = mysqli_query($link,$sql);

		while(($arr=mysqli_fetch_assoc($query))!=false)
		{
			$data[] = $arr;
		}
		$size = count($data);
		if($size>0){
			//由于一张表中数据量过大，分批插入
			fun($link,$data,0,$i,$nums);		
		}
	}
	mysqli_query($link, 'COMMIT'); 
	echo "success";


	/**
	 *$arr  一张表的所有记录数组
	 *$index 起始索引
	 *$i     指定的分表
	 *$nums  一次性插入条数
	 */
	function fun($link,array $arr,$index = 0,$i,$nums){
		$count = count($arr);
		$dir = str_replace("\\","/",__DIR__);
		$new = array_slice($arr,$index,$nums,true);
		$values = "";
		foreach ($new as $key => $a) {
			$liunian = "";
			$cmp = "";
			$img = "";
			$a['createtime'] = empty($a['createtime']) ? 'null' : $a['createtime'];
			$a['lid']      = empty($a['lid']) ? 'null' : $a['lid'];
			$a['mtime']      = empty($a['mtime']) ? 'null' : $a['mtime'];
			$a['sharetime']  = empty($a['sharetime']) ? 'null' : $a['sharetime'];
			$sql_ln = "select id,note,addtime,tid,`year`,img,isMain,luckYear from bazi_udnotes.udnotes_u$i where udid = '{$a['udid']}' and img is null;";
			$query2 = mysqli_query($link,$sql_ln);
			if($query2){
				while(($arr2=mysqli_fetch_assoc($query2))!=false){
					$year[] = $arr2;
				}
				if($year){
					$liunian = json_encode($year);
					//echo $liunian;die;
				}
				unset($year);
			}


			$sql_img = "select img from bazi_udnotes.udnotes_u$i where udid = '{$a['udid']}' and img is not null;";
			$query4 = mysqli_query($link,$sql_img);
			if($query2){
				while(($arr4=mysqli_fetch_assoc($query4))!=false){
					$img = $arr4;
				}
				unset($arr4);
			}
			
			//查找八字所对应的评论
			if(strlen($a['udid'])>=12){
         	   $s = ((int)substr($a['udid'], 6))%100;
        	}  else {
            	$s = (int)$a['udid']%100;
        	}
        	$tbl_cmp = "bazi_baziComment.baziComment_".($s%100);
        	$uca = "bazi.uaccount";
        	//echo $tbl_cmp.PHP_EOL;
			$sql_cmp = "select  a.cid,a.uid,a.ftype,a.content,a.createtime,a.audioInfo,b.rname from $tbl_cmp as a LEFT JOIN $uca as b  on a.uid = b.uid where a.subjectid = {$a['udid']};";
			//echo $sql_cmp.PHP_EOL;
			$query3 = mysqli_query($link,$sql_cmp);
			//var_dump($query3);
			if($query3){
				while(($arr3=mysqli_fetch_assoc($query3))!=false){
					$note[] = $arr3;
				}
				if($note){
					$cmp = json_encode($note);
				}
				unset($note);
			}
			
			$a['liunian'] = empty($liunian) ? " " : $liunian;
			$a['bazicmp'] = empty($cmp) ? " " : $cmp;
			$a['img']     = empty($img) ? " " : $img['img'];
			foreach($a as $k => $v){
				$a[$k]=addslashes($v);
			}
			$data[$i][]=$a;
			//$log = $a['udid']."---".$img."---".PHP_EOL;
			//var_dump($log);
			//file_put_contents($dir."/my.log",$log,FILE_APPEND);
			if(empty($values)){
				$values = "values('{$a['udid']}',{$a['uid']},{$a['relation']},{$a['specialty']},{$a['mingju']},'{$a['rname']}',{$a['igender']},'{$a['birthsolar']}','{$a['birthlunar']}',{$a['isleap']},'{$a['birthtime']}','{$a['umobile']}','{$a['upicture']}',{$a['yearTianGan']},{$a['yearDiZhi']},{$a['monthTianGan']},{$a['monthDiZhi']},{$a['dayTianGan']},{$a['dayDiZhi']},{$a['hourTianGan']},{$a['hourDiZhi']},'{$a['country']}','{$a['province']}','{$a['city']}','{$a['did']}','{$a['spicture']}','{$a['mpicture']}',{$a['srecord']},'{$a['usign']}','{$a['tags']}',{$a['permission']},{$a['createtime']},{$a['lid']},'{$a['rmark']}',{$a['mtime']},{$a['catid']},'{$a['cpicture']}',{$a['isshare']},{$a['readcount']},{$a['p_count']},{$a['sharetime']},'{$a['smallPic']}','{$a['mPHeadPic']}',{$a['source']},{$a['del']},'{$a['liunian']}','{$a['bazicmp']}','{$a['img']}')";
			}else{
				$values.=",('{$a['udid']}',{$a['uid']},{$a['relation']},{$a['specialty']},{$a['mingju']},'{$a['rname']}',{$a['igender']},'{$a['birthsolar']}','{$a['birthlunar']}',{$a['isleap']},'{$a['birthtime']}','{$a['umobile']}','{$a['upicture']}',{$a['yearTianGan']},{$a['yearDiZhi']},{$a['monthTianGan']},{$a['monthDiZhi']},{$a['dayTianGan']},{$a['dayDiZhi']},{$a['hourTianGan']},{$a['hourDiZhi']},'{$a['country']}','{$a['province']}','{$a['city']}','{$a['did']}','{$a['spicture']}','{$a['mpicture']}',{$a['srecord']},'{$a['usign']}','{$a['tags']}',{$a['permission']},{$a['createtime']},{$a['lid']},'{$a['rmark']}',{$a['mtime']},{$a['catid']},'{$a['cpicture']}',{$a['isshare']},{$a['readcount']},{$a['p_count']},{$a['sharetime']},'{$a['smallPic']}','{$a['mPHeadPic']}',{$a['source']},{$a['del']},'{$a['liunian']}','{$a['bazicmp']}','{$a['img']}')";
			}
		}
		$tblAdd = "bazi_records.udatas_u".$i;
		$add = "replace into ".$tblAdd."(udid,uid,relation,specialty,mingju,rname,igender,birthsolar,birthlunar,isleap,birthtime,umobile,upicture,yearTianGan,yearDiZhi,monthTianGan,monthDiZhi,dayTianGan,dayDiZhi,hourTianGan,hourDiZhi,country,province,city,did,spicture,mpicture,srecord,usign,tags,permission,createtime,lid,rmark,mtime,catid,cpicture,isshare,readcount,p_count,sharetime,smallPic,mPHeadPic,source,del,liunian,comment,img) ".$values.";";
		//echo $add.PHP_EOL;
		$ret = mysqli_query($link,$add);
		//echo $add;
		var_dump($ret);
		$log = $add.PHP_EOL;
		file_put_contents($dir."/my.log",$log,FILE_APPEND);
		$index += $nums;
		if($index < $count){
			fun($link,$arr,$index,$i,$nums);
		}
	}

	/*
	//八字正式库连接
	$link = mysqli_connect('rm-uf6ecb26spk469jw1.mysql.rds.aliyuncs.com','bazi_usr','ojaeacyNw8Hujqigbi','bazi_udata'); 
	$sql = "select * from bazi_udata.udatas_u9 limit 0,10";
	*/
	

?>