<?php
	$arr = array(
		0 => array('as'=>'111','bs'=>222),
		1 => array('bs'=>'211','bs'=>222),
		2 => array('cs'=>'311','bs'=>222),
		3 => array('ds'=>'411','bs'=>222),
		4 => array('es'=>'511','bs'=>222),
		5 => array('fs'=>'611','bs'=>222),
		6 => array('gs'=>'711','bs'=>222),
		7 => array('hs'=>'811','bs'=>222),
		8 => array('is'=>'911','bs'=>222),
		9 => array('js'=>'a11','bs'=>222),
		10 => array('ks'=>'b11','bs'=>222),
		11 => array('ls'=>'c11','bs'=>222),
		12 => array('ms'=>'d11','bs'=>222)
	);
	//print_r($arr);

	function fun(array $arr,$index = 0){
		$count = count($arr);
		if($index < $count){
			$new = array_slice($arr,$index,3,true);
			$index += 3;
			print_r($new);
			fun($arr,$index);
		}
		
	}
fun($arr,0);