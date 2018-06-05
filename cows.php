<?php
//一头牛4岁时开始生牛，每年生一头，15岁绝育，二十岁死亡，n年后牛的总数。
function getCows1($years){
	$cows = array();
	$cows[] = 0;    //$cows[i] 指第i头牛的出生时间
	if( $years < 4){
		return 1;     
	}else{
		for($i = 4; $i <= $years; $i++){
			$k = count($cows);
			for($j = 0; $j < $k; $j++){
				if(!isset($cows[$j])){
					continue;
				}
				$age = $i - $cows[$j];     //$cows[$j]这头牛的年龄
				if($age >= 4 && $age<15){
					$cows[] = $i;
				}elseif ($age == 20) {
					unset($cows[$j]);
				}
			}
		}
		//print_r($cows);
		return count($cows);
	}
}

var_dump(getCows1(47));


function getCows2($years) {
    static $cows_num = 1;
    for($i=1; $i<=$years; $i++) {                                 
        if($i >= 4 && $i < 15) {								
            $cows_num ++;
            echo $years."++++++1......g(".($years-$i).")\n";														
            getCows2($years - $i);									
        }
        if($i == 20){
        	$cows_num --;
        }	
        //echo $cows_num."\n";							
    }																   
    return $cows_num;												
}																		
																
var_dump(getCows2(16));