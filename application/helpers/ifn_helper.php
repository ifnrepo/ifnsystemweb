<?php
function visibpass($kata){
    $hasil = '*****';
    if(strlen($kata)<=5){
        $hasil = str_repeat('*',strlen($kata)-1).substr($kata,strlen($kata)-1,1);
    }else{
        $hasil = substr($kata,0,1).str_repeat('*',strlen($kata)-3).substr($kata,strlen($kata)-2,2);
    }
    return $hasil;
}
function cekceklis($kata,$nomor){
    $hasil = '';
    if(substr($kata,($nomor*2)-2,1)==1){
        $hasil = 'checked';
    }
    return $hasil;
}
function cekmenuheader($kata){
    $hasil = '';
    $pos = strpos($kata,'1');
    if($pos === false){
        $hasil = 'hilang';
    }
    return $hasil;
}
function cekmenudetail($kata,$nomor){
    $hasil = '';
    if(substr($kata,($nomor*2)-2,1)!=1){
        $hasil = 'hilang';
    }
    return $hasil;
}