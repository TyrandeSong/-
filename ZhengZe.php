<?php

// $str = "This book is */very/* difficult to find.";
// $new = "*/very/*";
/*$reg = "/" . preg_quote($new, '/') . "/";
echo $reg.PHP_EOL;
echo preg_replace($reg,"<i>".$new."</i>",$str); */

$a="A";
//$b= "B";
$b =&$a;
// echo $a;//这里输出:ABC
// echo $b;//这里输出:ABC
$a="da";
$b="EFG";
echo $a;//这里$a的值变为EFG 所以输出EFG
echo $b;//这里输出EFG