<?php

function createUdid($prefix = ''){
	$prefix.= mt_rand(1,9999999);
	var_dump($prefix);
    //crc32:以整数值返回字符串的 32 位循环冗余校验码多项式。
    //如果未使用 %u 格式符，结果可能会显示为不正确的数字或者负数
    $num = sprintf('%-010u',crc32( uniqid( $prefix, true)));
	$num = floor($num / 10);
	$uid = date('y').sprintf('%03s',date('z')).$num.mt_rand(0,9) + 0;
	//科学计数转为正常显示
    if(false !== stripos($uid, "e")){
        $a = explode("e",strtolower($uid));
        $uid = bcmul($a[0], bcpow(10, $a[1]));
    }
    return strval($uid);
}
$uid = 10823;
var_dump(createUdid($uid));	

/*$prefix = 10823;
$prefix.=mt_rand(1,9999999);
var_dump($prefix);
var_dump(uniqid( $prefix, true));*/

/*class A {
    private $C=1; // This will become '\0A\0A'
}

class B extends A {
    private $C=2; // This will become '\0B\0A'
    public $CC=3; // This will become 'AA'
}

var_dump( (array)new B());*/