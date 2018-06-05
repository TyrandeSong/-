<?php
//在长度为n的数组中，每一个数字都不超过n-1,z找到其中重复的一个数字
function swap( &$arr , $i, $j ){
	$c       = $arr[$i];
	$arr[$i] = $arr[$j];
	$arr[$j] = $c;
}

$arr = [ 2, 1, 8, 5, 4, 9, 7, 4, 3, 6];
$arr1 = [3,0,1,2,4,2];
/*function searchNum(){ 
	global $arr;
	$count = count($arr);
	for($i = 0; $i < $count; $i++){
		echo $i."........\n";
		if($i == $arr[$i]){
			continue;
		}else {
			if($arr[$i] != $arr[$arr[$i]]){
				//echo $i."---\n";
				swap( $arr,$i, $arr[$i] );
				return searchNum();
			}else{
				return $arr[$i]; 
			}
		}
	}	
}*/

function searchNum( $arr, $i = 0 ){
	global $new;   //最终数据交换得到的数组
	$new = $arr;    
	if($i == $arr[$i]){
		$i++;
		return searchNum( $arr, $i );
	}else {
		if($arr[$i] != $arr[$arr[$i]]){
			swap( $arr,$i, $arr[$i] );
		    return searchNum( $arr, $i );
		}else{		
			return $arr[$i]; 
		}
	}
}

$num = searchNum($arr);
var_dump($num);
print_r($new);
	 
		