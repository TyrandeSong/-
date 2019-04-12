<?php
$arr = [6,8,4,1,9,3,7,2,5];

function swap($arr, $i, $j){
	$temp = $arr[$i];
	$arr[$i] = $arr[$j];
	$arr[$j] = $temp;
	return $arr;
}

function Bubble_Sort($arr){
	$len = count($arr);
	for($i = 0; $i < $len - 1; $i++){
		$flag = 0;
		for($j = 0; $j < $len - $i -1; $j ++){
			if($arr[$j] > $arr[$j+1]){
				$flag = 1;
				$arr = swap($arr, $j, $j+1);
			}
			continue;
		}
		if(!$flag){
			break;
		}
	}
	return $arr;
}
// Bubble_Sort($arr);


function Selection_Sort($arr){
	$len = count($arr);
	$minIndex = 0;
	for($i = 0; $i < $len - 1; $i++){
		$minIndex = $i;
		for($j = $i + 1; $j < $len; $j++){
			if($arr[$minIndex] > $arr[$j]){
				$minIndex = $j;
			}
		}
		if($minIndex === $i){
			continue;
		}
		$arr = swap($arr, $i, $minIndex);
		// print_r($arr);
	}
	return $arr;
}
// print_r(Selection_Sort($arr));


function Insertion_Sort($arr){
	$len = count($arr);
	for($i = 1; $i < $len; $i++){
		$current = $arr[$i];       //指针值
		$pointer = $i;             //当前指针位置
		for($j = $i; $j > 0; $j--){
			if($current < $arr[$j-1]){
			    $arr = swap($arr, $pointer, $j-1);  //交换指针与前一结点的值
			    $pointer = $j-1;					  //指针前移

			}else{
				break 1;
			}
		}
		// print_r($arr);
	}
	return $arr;
}
 // print_r(Insertion_Sort($arr));


function Insertion_Sort2($arr) {
  $len = count($arr);
  for ($i = 1; $i < $len; $i++) {
    $current = $arr[$i];
    $pointer = $i;
    while($pointer >0 && $current < $arr[$pointer - 1]) { // 每次向前比较
      $arr[$pointer] = $arr[$pointer - 1]; // 前一项大于指针项，则向前移动一项
      $pointer -= 1;
      // print_r($arr);
    }
    $arr[$pointer] = $current; // 指针项还原成当前项
    // var_dump($arr);
  }
  return $arr;
}

// print_r(Insertion_Sort2($arr));