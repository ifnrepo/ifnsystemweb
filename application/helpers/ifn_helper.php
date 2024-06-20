<?php
define('LOK_UPLOAD_USER', "./assets/image/personil/");
define('IDPERUSAHAAN', 'IFN');

function visibpass($kata)
{
    $hasil = '*****';
    if (strlen($kata) <= 5) {
        $hasil = str_repeat('*', strlen($kata) - 1) . substr($kata, strlen($kata) - 1, 1);
    } else {
        $hasil = substr($kata, 0, 1) . str_repeat('*', strlen($kata) - 3) . substr($kata, strlen($kata) - 2, 2);
    }
    return $hasil;
}
function cekceklis($kata, $nomor)
{
    $hasil = '';
    if (substr($kata, ($nomor * 2) - 2, 1) == 1) {
        $hasil = 'checked';
    }
    return $hasil;
}
function cekceklisdep($kata, $dept)
{
    $hasil = '';
    for ($x = 1; $x <= 50; $x++) {
        if (substr($kata, ($x * 2) - 2, 2) == $dept) {
            $hasil = 'checked';
            $x = 51;
        }
    }
    return $hasil;
}
function cekmenuheader($kata)
{
    $hasil = '';
    $pos = strpos($kata, '1');
    if ($pos === false) {
        $hasil = 'hilang';
    }
    return $hasil;
}
function cekmenudetail($kata, $nomor)
{
    $hasil = '';
    if (substr($kata, ($nomor * 2) - 2, 1) != 1) {
        $hasil = 'hilang';
    }
    return $hasil;
}
function cekoth($key1, $key2, $key3)
{
    $hasil = '';
    if ($key1 == '1') {
        $hasil .= 'PB; ';
    }
    if ($key2 == '1') {
        $hasil .= 'BBL; ';
    }
    if ($key3 == '1') {
        $hasil .= 'ADJ; ';
    }
    return $hasil;
}
function arrdep($dep)
{
    $arrdep = [];
    if (strlen($dep) > 0) {
        for ($x = 1; $x <= strlen($dep) / 2; $x++) {
            array_push($arrdep, substr($dep, ($x * 2) - 2, 2));
        }
    }
    return $arrdep;
}
function nomorpb($tgl, $asal, $tuju)
{
    $bl = date('m', strtotime($tgl));
    $th = date('y', strtotime($tgl));
    $thp = date('Y', strtotime($tgl));
    $CI = &get_instance();
    $kode = $CI->pb_model->getnomorpb($bl, $thp, $asal, $tuju);
    $urut = (int) $kode['maxkode'];
    $urut++;
    return $asal . "-" . $tuju . "/BP/" . $bl . $th . "/" . sprintf("%03s", $urut);
}
function nomorbbl($tgl, $asal, $tuju)
{
    $bl = date('m', strtotime($tgl));
    $th = date('y', strtotime($tgl));
    $thp = date('Y', strtotime($tgl));
    $CI = &get_instance();
    $kode = $CI->bbl_model->getnomorbbl($bl, $thp, $asal, $tuju);
    $urut = (int) $kode['maxkode'];
    $urut++;
    return $asal . "-" . $tuju . "/BBL/" . $bl . $th . "/" . sprintf("%03s", $urut);
}
function nomorout($tgl, $asal, $tuju)
{
    $bl = date('m', strtotime($tgl));
    $th = date('y', strtotime($tgl));
    $thp = date('Y', strtotime($tgl));
    $CI = &get_instance();
    $kode = $CI->out_model->getnomorout($bl, $thp, $asal, $tuju);
    $urut = (int) $kode['maxkode'];
    $urut++;
    return $asal . "-" . $tuju . "/T/" . $bl . $th . "/" . sprintf("%03s", $urut);
}
function tglmysql($tgl)
{
    if ($tgl == '') {
        $rubah = '';
    } else {
        $x = explode('-', $tgl);
        $rubah = $x[2] . '-' . $x[1] . '-' . $x[0];
    }
    if ($rubah == '00-00-0000' || $rubah == '0000-00-00') {
        $rubah = '';
    }
    return $rubah;
}
function tglmysql2($tgljam)
{
    $a = $tgljam;
    if ($a == null) {
        $hasil = '';
    } else {
        $exp = explode('-', $a);
        $exp2 = explode(' ', $exp[2]);
        $hasil = $exp2[0] . '-' . $exp[1] . '-' . $exp[0] . ' ' . $exp2[1];
    }
    return $hasil;
}
function lastdate($bl, $th)
{
    $tgl = $th . "-" . $bl . "-01";
    $a_date = $tgl;
    return date("Y-m-t", strtotime($a_date));
}
function rupiah($nomor, $dec)
{
    if ($nomor == '0' || $nomor == '-6.821210263297E-13' || $nomor == '' || $nomor == NULL || is_null($nomor)) {
        $hasil = '-  ';
    } else {
        if ($nomor >= 0) {
            $hasil = number_format($nomor, $dec, '.', ',');
        } else {
            if ($nomor != '0.00') {
                $nomor = $nomor * -1;
                $hasil = number_format($nomor, $dec, '.', ',');
                $hasil = '(' . $hasil . ')';
            } else {
                $hasil = '-  ';
            }
        }
    }
    return $hasil;
}
function tgl_indo($tanggal, $kode = 0)
{
    $namahari = '';
    $tanggal = is_null($tanggal) ? '0000-00-00' : $tanggal;
    if ($kode == 1) {
        $hari = date("D", strtotime($tanggal));
        switch ($hari) {
            case 'Mon':
                $namahari = 'Senin';
                break;
            case 'Tue':
                $namahari = 'Selasa';
                break;
            case 'Wed':
                $namahari = 'Rabu';
                break;
            case 'Thu':
                $namahari = 'Kamis';
                break;
            case 'Fri':
                $namahari = 'Jum\'at';
                break;
            case 'Sat':
                $namahari = 'Sabtu';
                break;
            case 'Sun':
                $namahari = 'Minggu';
                break;
            default:
                $namahari = 'Error';
                break;
        }
    }
    if ($tanggal != '0000-00-00') {
        $bulan = array(
            1 =>   'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun',
            'Jul',
            'Agt',
            'Sep',
            'Okt',
            'Nop',
            'Des'
        );
        $pecahkan = explode('-', $tanggal);
        if ($kode == 0) {
            return $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
        } else {
            return $namahari . ', ' . $pecahkan[2] . ' ' . $bulan[(int)$pecahkan[1]] . ' ' . $pecahkan[0];
        }
    } else {
        return '';
    }
}
function namabulan($id)
{
    $bulan = array(
        1 =>   'Januari',
        'Februari',
        'Maret',
        'April',
        'Mei',
        'Juni',
        'Juli',
        'Agustus',
        'September',
        'Oktober',
        'November',
        'Desember'
    );
    if ($id == null) {
        return '';
    }
    return $bulan[(int)$id];
}
function namabulanpendek($id)
{
    $bulan = array(
        1 =>   'Jan',
        'Feb',
        'Mar',
        'Apr',
        'Mei',
        'Jun',
        'Jul',
        'Agt',
        'Sep',
        'Okt',
        'Nov',
        'Des'
    );
    return $bulan[(int)$id];
}
function datauser($kode, $kolom)
{
    if ($kode != '') {
        $CI = &get_instance();
        $kode = $CI->usermodel->getdatabyid($kode)->row_array();
        return $kode[$kolom];
    }
}
function kodebulan($bl)
{
    $hasil = $bl;
    if ((int)$bl <= 9) {
        $hasil = '0' . (int)$bl;
    }
    return $hasil;
}
function firstday($tgl)
{
    return date('Y-m-01', strtotime($tgl));
}
function lastday($tgl)
{
    return date('Y-m-t', strtotime($tgl));
}

function viewsku($po='',$no='',$dis='',$id=''){
    $hasil = '';
    if(trim($po)==''){
        $hasil = $id;
    }else{
        $xdis = $dis==0 ? '' : ' dis '.$dis;
        $xid = $id=='' ? '' : ' brg '.$id;
        $hasil = $po.' # '.$no.$xdis;
    }
    return $hasil;
}
