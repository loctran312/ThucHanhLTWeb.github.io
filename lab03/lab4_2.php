<?php
    $tong = 0;
    $i = 1;
    while($tong<=1000){
        $tong += $i;
        $i = $i + 1;
    }
    echo $i . " la n nho nhat de tong 1 + 2 + ... + n > 1000";
    echo "xai while";
?>