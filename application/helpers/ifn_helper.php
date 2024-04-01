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
function cekceklisdep($kata,$dept){
    $hasil = '';
    for($x=1;$x<=50;$x++){
        if(substr($kata,($x*2)-2,2)==$dept){
            $hasil = 'checked';
            $x=51;
        }
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
function cekoth($key1,$key2,$key3){
    $hasil = '';
    if($key1=='1'){
        $hasil .= 'PB; ';
    }
    if($key2=='1'){
        $hasil .= 'BBL; ';
    }
    if($key3=='1'){
        $hasil .= 'ADJ; ';
    }
    return $hasil;
}
function arrdep($dep){
    $arrdep = [];
    if(strlen($dep)>0){
        for($x=1;$x<=strlen($dep)/2;$x++){
            array_push($arrdep,substr($dep,($x*2)-2,2));
        }
    }
    return $arrdep;
}
function tglmysql($tgl){
    $pisah = explode("-",$tgl);
    return $pisah[2]."-".$pisah[1]."-".$pisah[0];
}
function nomorpb($tgl,$asal,$tuju){
    $bl = date('m',strtotime($tgl));
    $th = date('y',strtotime($tgl));
    $thp = date('Y',strtotime($tgl));
    $CI = &get_instance();
    $kode = $CI->pb_model->getnomorpb($bl,$thp,$asal,$tuju);
    $urut = (int) $kode['maxkode'];
    $urut++;
    return $asal."-".$tuju."/BP/".$bl.$th."/".sprintf("%03s",$urut);
}