<?php
$arr = [9,20,18,3,40,16,19];


function arraySort(array $arr){
	$len = count($arr);
	for($i = 0; $i < $len-1; $i++){
		for($j = $i+1; $j < $len; $j++){
			if($arr[$j] > $arr[$i]){
				$temp  = $arr[$j];
    			$arr[$j] = $arr[$i];
    			$arr[$i] = $temp;
			}
		}
		//print_r($arr);
	}
	return $arr;
}


$a = "sd";
print_r(arraySort($arr));