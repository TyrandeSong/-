<?php
error_reporting(0);
function countcows($years) {
    $cows[] = 0;
    if($years < 4) return 1;
    for($i=4; $i <= $years; $i++) {
        for($j=0, $k=count($cows); $j<$k; $j++) {
            $age = $i - $cows[$j];
            if($age >= 4 && $age < 15) 
                $cows[] = $i;
            else if($age == 20) 
                unset($cows[$j]);
        }
    }
    return count($cows);
}
var_dump(countcows(13));