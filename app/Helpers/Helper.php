<?php

function periode($date1,$date2){
    if($date1>$date2){
        $per1=$date2;
        $per2=$date1;
    } else {
        $per1=$date1;
        $per2=$date2;
    }

    $dper1= date("d", strtotime($per1));
    $Mper1= date("M", strtotime($per1));
    $Yper1= date("Y", strtotime($per1));
    $dMYper1= date("d M Y", strtotime($per1));
    $dMper1= date("d M", strtotime($per1));
    $dper2= date("d", strtotime($per2));
    $Mper2= date("M", strtotime($per2));
    $Yper2= date("Y", strtotime($per2));
    $dMYper2= date("d M Y", strtotime($per2));
    if ($Yper1!=$Yper2){
        return $dMYper1."-".$dMYper2;
    } else {
        if($Mper1!=$Mper2){
            return $dMper1."-".$dMYper2;
        } else {
            if($dper1!=$dper2){
                return $dper1."-".$dMYper2;
            } else {
                return $dMYper2;
            }
        }
    }
}

function pipeline($number){
    $milyar=1000000000;
    $juta=1000000;
    $num=0;
    
    if($number>$milyar){
        $num=$number/$milyar;

        return number_format($num,2)." M";
    }else{
        $num=$number/$juta;

        return number_format($num,2)." Jt";
    }
}