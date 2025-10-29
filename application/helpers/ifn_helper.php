<?php
define('LOK_UPLOAD_USER', "./assets/image/personil/");
define('LOK_FOTO_MESIN', base_url() . "assets/image/dokmesin/foto/");
define('LOK_DOK_MESIN', base_url() . "assets/image/dokmesin/dok/");
define('IDPERUSAHAAN', 'IFN');
define('deptbbl', 'GMGSITPG');
define('LOK_UPLOAD_DOKHAMAT', "./assets/image/dokhamat/");
define('LOK_UPLOAD_MESIN', "./assets/image/dokmesin/foto/");
define('LOK_UPLOAD_DOK', "./assets/image/dokmesin/dok/");
define('LOK_UPLOAD_DOK_BC', "./assets/file/dok/");
define('kodeunik', 'concat(tb_header.data_ok,tb_header.ok_valid,tb_header.ok_tuju,tb_header.ok_pp,tb_header.ok_pc) as kodeunik');
define('LOK_UPLOAD_PDFRESPON', "./assets/file/");

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
    if (strlen(trim($dep)) > 0) {
        for ($x = 1; $x <= strlen($dep) / 2; $x++) {
            array_push($arrdep, substr($dep, ($x * 2) - 2, 2));
        }
    }
    return $arrdep;
}
function nomorpb($tgl, $asal, $tuju, $jn)
{
    $bl = date('m', strtotime($tgl));
    $th = date('y', strtotime($tgl));
    $thp = date('Y', strtotime($tgl));
    $jne = $jn == 0 ? 'BP' : 'PS';
    $CI = &get_instance();
    $kode = $CI->pb_model->getnomorpb($bl, $thp, $asal, $tuju);
    $urut = (int) $kode['maxkode'];
    $urut++;
    return $asal . "-" . $tuju . "/" . $jne . "/" . $bl . $th . "/" . sprintf("%03s", $urut);
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
    return $asal . "-" . $tuju . "/BB/" . $bl . $th . "/" . sprintf("%03s", $urut);
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
    $hasil = 'ERROR';
    if ($asal == 'DL' && $tuju == 'GM') {
        $hasil = "DLN-IFN/SJ/" . $bl . $th . "/" . sprintf("%03s", $urut);
    } else {
        $hasil = $asal . "-" . $tuju . "/T/" . $bl . $th . "/" . sprintf("%03s", $urut);
    }
    return $hasil;
}
function nomorpo()
{
    $CI = &get_instance();
    $tgl = $CI->session->userdata('th') . '-' . kodebulan($CI->session->userdata('bl')) . '-01';
    $bl = date('m', strtotime($tgl));
    $th = date('Y', strtotime($tgl));
    $thp = date('y', strtotime($tgl));
    if ($CI->session->userdata('jn_po') == 'DO' || $CI->session->userdata('jn_po') == 'IM') {
        $jnpo =  $CI->session->userdata('jn_po') . '/BL/';
    } else {
        $jnpo =  'DO/' . $CI->session->userdata('jn_po') . '/';
    }
    $kode = $CI->pomodel->getnomorpo($bl, $th, $jnpo);
    $urut = (int) $kode['maxkode'];
    $urut++;
    return "PO/" . $jnpo . $bl . $thp . "/" . sprintf("%03s", $urut);
}
function nomorib()
{
    $CI = &get_instance();
    $tgl = $CI->session->userdata('th') . '-' . kodebulan($CI->session->userdata('bl')) . '-01';
    $bl = date('m', strtotime($tgl));
    $th = date('Y', strtotime($tgl));
    $thp = date('y', strtotime($tgl));
    $deptr = $CI->session->userdata('curdept');
    $kode = $CI->ibmodel->getnomorib($bl, $th);
    $urut = (int) $kode['maxkode'];
    $urut++;
    return "SU-" . $deptr . '/P/' . $bl . $thp . "/" . sprintf("%03s", $urut);
}
function nomorproforma()
{
    $CI = &get_instance();
    $tgl = $CI->session->userdata('th') . '-' . kodebulan($CI->session->userdata('bl')) . '-01';
    $bl = date('m', strtotime($tgl));
    $th = date('Y', strtotime($tgl));
    $thp = date('y', strtotime($tgl));
    $deptr = $CI->session->userdata('depttuju');
    $kode = $CI->ibmodel->getnomorproforma($bl, $th);
    $urut = (int) $kode['maxkode'];
    $urut++;
    return "PROFORMA-" . $urut;
}
function nomoradj($tgl, $asal)
{
    $bl = date('m', strtotime($tgl));
    $th = date('y', strtotime($tgl));
    $thp = date('Y', strtotime($tgl));
    $CI = &get_instance();
    $kode = $CI->adjmodel->getnomoradj($bl, $thp, $asal);
    $urut = (int) $kode['maxkode'];
    $urut++;
    return $asal . "/A/" . $bl . $th . "/" . sprintf("%03s", $urut);
}
function getnomoraju($kodex)
{
    $CI = &get_instance();
    $kode = $CI->helpermodel->getnomoraju($kodex)->row_array();
    $urut = (int) $kode['maxkode'];
    $urut++;
    return $kodex . '-' . date('Ymd') . "-" . sprintf("%03s", $urut);
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
    $kore = '';
    if ($kode == '' || $kode == 0) {
        $kore = '';
    } else {
        $CI = &get_instance();
        $kodex = $CI->usermodel->getdatabyid($kode)->row_array();
        $kore = $kodex[$kolom];
    }
    return $kore;
}
function datadepartemen($kode, $kolom)
{
    $kore = '';
    if ($kode == '' || $kode == 0) {
        $kore = '';
    } else {
        $CI = &get_instance();
        $kodex = $CI->helpermodel->getdatadepartemen($kode)->row_array();
        $kore = $kodex[$kolom];
    }
    return $kore;
}
function datasupplier($kode, $kolom)
{
    $kore = '';
    if ($kode == '' || $kode == 0) {
        $kore = '';
    } else {
        $CI = &get_instance();
        $kodex = $CI->helpermodel->getdatasupplier($kode)->row_array();
        $kore = $kodex[$kolom];
    }
    return $kore;
}
function datacustomer($kode, $kolom)
{
    $kore = '';
    if ($kode == '' || $kode == 0) {
        $kore = '';
    } else {
        $CI = &get_instance();
        $kodex = $CI->helpermodel->getdatacustomer($kode)->row_array();
        $kore = $kodex[$kolom];
    }
    return $kore;
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

function viewsku($po = '', $no = '', $dis = '', $id = '')
{
    $hasil = '';
    if (trim($po) == '') {
        $hasil = $id;
    } else {
        $xdis = $dis == 0 ? '' : ' dis ' . $dis;
        $xid = $id == '' ? '' : ' brg ' . $id;
        $hasil = trim($po) . ' # ' . trim($no) . ' ' . $xdis;
    }
    return trim($hasil);
}

function viewspek($po = '', $no = '', $dis = 0)
{
    $CI = &get_instance();
    $hasil = $CI->invmodel->getspekjala($po . $no . $dis);
    return $hasil;
}

function tungguvalid($kode)
{
    $hasil = '';
    switch ($kode) {
        case '10000':
            $hasil = 'Validasi Manager Departemen';
            break;
        case '10100':
            $hasil = 'Validasi Manager Departemen';
            break;
        case '11000':
            $hasil = 'Validasi Manager PPIC';
            break;
        case '11100':
            $hasil = 'Validasi General Manager';
            break;
        case '11110':
            $hasil = 'Validasi Manager Purchasing';
            break;
        default:
            $hasil = 'Validasi Kepala Departemen';
            break;
    }
    return $hasil;
}
function terbilang($x)
{
    $angka = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];

    if ($x < 12)
        return " " . $angka[$x];
    elseif ($x < 20)
        return terbilang($x - 10) . " Belas";
    elseif ($x < 100)
        return terbilang($x / 10) . " Puluh" . terbilang($x % 10);
    elseif ($x < 200)
        return "Seratus" . terbilang($x - 100);
    elseif ($x < 1000)
        return terbilang($x / 100) . " Ratus" . terbilang($x % 100);
    elseif ($x < 2000)
        return "Seribu" . terbilang($x - 1000);
    elseif ($x < 1000000)
        return terbilang($x / 1000) . " Ribu" . terbilang($x % 1000);
    elseif ($x < 1000000000)
        return terbilang($x / 1000000) . " Juta" . terbilang($x % 1000000);
}

function gethrg($idb, $nobo)
{
    $CI = &get_instance();
    $hasil = $CI->bbl_model->gethrg($idb, $nobo);
    return $hasil;
}
function generatekodebc($jnsbc, $tglbc, $nobc)
{
    $datenow = "2024-01-01";
    $kode = '000000-010017-00000000-000000';
    if ($tglbc >= $datenow) {
        if (trim($jnsbc) != '') {
            $kode1 = str_repeat('0', 6 - strlen(trim($jnsbc))) . trim($jnsbc);
        } else {
            $kode1 = '000000';
        }
        if ($tglbc != null) {
            $kode2 = str_replace('-', '', $tglbc);
        } else {
            $kode2 = '00000000';
        }
        if (trim($nobc) != '') {
            $kode3 = str_repeat('0', 6 - strlen(trim(substr($nobc, 0, 6)))) . trim(substr($nobc, 0, 6));
        } else {
            $kode3 = '000000';
        }
        // $kode3 = '';
        $kode = $kode1 . '-010017-' . $kode2 . '-' . $kode3;
    } else {
        if ($tglbc != null) {
            $kode2 = str_replace('-', '', $tglbc);
        } else {
            $kode2 = '00000000';
        }
        if (trim($nobc) != '') {
            $kode3 = str_repeat('0', 6 - strlen(trim(substr($nobc, 0, 6)))) . trim(substr($nobc, 0, 6));
        } else {
            $kode3 = '000000';
        }
        $kode = '050500-000307-' . $kode2 . '-' . $kode3;
    }
    return $kode;
    // return  6 - strlen(trim($nobc));
}
function riwayatdok($id)
{
    $CI = &get_instance();
    $hasil = $CI->helpermodel->riwayatdok($id);
    return $hasil;
}
function riwayatbbl($id)
{
    $CI = &get_instance();
    $hasil = $CI->helpermodel->riwayatbbl($id);
    return $hasil;
}
function riwayatpo($id)
{
    $CI = &get_instance();
    $hasil = $CI->helpermodel->riwayatpo($id);
    return $hasil;
}
function riwayatbcmasuk($id)
{
    $CI = &get_instance();
    $hasil = $CI->helpermodel->riwayatbcmasuk($id);
    return $hasil;
}
function riwayatbckeluar($id)
{
    $CI = &get_instance();
    $hasil = $CI->helpermodel->riwayatbckeluar($id);
    return $hasil;
}
function get_client_ip()
{
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if (getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if (getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if (getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if (getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if (getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
function getdevice($str)
{
    $tart = substr($str, 0, strpos($str, ' '));
    $device = 'DESKTOP';
    if (strpos($str, 'Lin')) {
        $device = 'ANDROID';
    } else if (strpos($str, 'Mac')) {
        $device = 'APPLE MACINTOSH';
    }
    return $tart . ' on ' . $device;
}
function cekclosebook()
{
    $isi = '';
    $CI = &get_instance();
    $periode = kodebulan($CI->session->userdata('bl')) . $CI->session->userdata('th');
    $hasil = $CI->helpermodel->cekclosebook($periode);
    if ($hasil != 0) {
        $isi = 'disabled';
    }
    return $isi;
}

function limit_date($date)
{
    $cektgl = DateTime::createFromFormat('Y-m-d', $date);
    if (!$cektgl) {
        return $date;
    }
    $hari = (int)$cektgl->format('d');
    $bulan = strtoupper($cektgl->format('M'));
    $tahun = $cektgl->format('Y');

    if ($hari >= 1 && $hari <= 10) {
        $kodena = 'EAR';
    } elseif ($hari >= 11 && $hari <= 20) {
        $kodena = 'MID';
    } else {
        $kodena = 'END';
    }

    return "$kodena $bulan $tahun";
}
function toAngka($rp)
{
    return str_replace(',', '', $rp);
}
function cekdetout($header)
{
    $isi = '';
    $CI = &get_instance();
    // $periode = kodebulan($CI->session->userdata('bl')) . $CI->session->userdata('th');
    $hasil = $CI->helpermodel->cekdetout($header);
    if ($hasil != 0) {
        $isi = '<span  class="badge badge-outline text-green">OPEN</span>';
    } else {
        $isi = '<span  class="badge badge-outline text-red">CLOSED</span>';
    }
    return $isi;
}
function isikurangnol($data)
{
    $len = strlen(trim($data));
    return str_repeat('0', 6 - $len) . trim($data);
}
function max_upload()
{
    $max_filesize = (int) (ini_get('upload_max_filesize'));
    $max_post     = (int) (ini_get('post_max_size'));
    $memory_limit = (int) (ini_get('memory_limit'));
    return min($max_filesize, $max_post, $memory_limit);
}
function nospasi($str)
{
    $strc = str_replace(' ', '', $str);
    return $strc;
}
function toutf($string)
{
    return html_entity_decode(preg_replace("/U\+([0-9A-F]{4})/", "&#x\\1;", $string), ENT_NOQUOTES, 'UTF-8');
}
function hitungwaktu($dateformat)
{
    $date1 = $dateformat;
    $date2 = date('Y-m-d H:i:s');
    $diff = abs(strtotime($date2) - strtotime($date1));
    $years   = floor($diff / (365 * 60 * 60 * 24));
    $months  = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
    $days    = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24));
    $hours   = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24) / (60 * 60));
    $minuts  = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60) / 60);
    $seconds = floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24 - $days * 60 * 60 * 24 - $hours * 60 * 60 - $minuts * 60));
    // printf("%d years, %d months, %d days, %d hours, %d minutes\n, %d seconds\n", $years, $months, $days, $hours, $minuts, $seconds);
    $array = ["tahun" => $years, "bulan" => $months, "hari" => $days, "jam" => $hours, "menit" => $minuts, "detik" => $seconds];
    return $array;
}
function hitunghari($tgl1, $tgl2)
{
    $tanggal_1 = date_create($tgl1);
    $tanggal_2 = date_create($tgl2);
    $selisih  = date_diff($tanggal_1, $tanggal_2);

    echo $selisih->days;
    // hasil 10722 Hari
}
function tambahnol($data)
{
    $nilai = (int) $data;
    $hasil = $nilai;
    if ($nilai <= 9) {
        $hasil = '0' . $nilai;
    }
    return $hasil;
}
function formatsku($po, $item, $dis, $brg)
{
    $isi = '';
    if (trim($po) == '') {
        $CI = &get_instance();
        $hasil = $CI->barangmodel->getdatabyid($brg)->row_array();
        $isi = $hasil['kode'];
    } else {
        $dise = $dis > 0 ? ' (dis) ' . $dis : '';
        $isi = trim($po) . '#' . trim($item) . $dise;
    }
    return $isi;
}
function namaspekbarang($brg)
{
    $x = "";
    if ($brg > 0) {
        $CI = &get_instance();
        $hasil = $CI->barangmodel->getdatabyid($brg)->row_array();
        $x = $hasil['nama_barang'];
    }
    return $x;
}
function cekperiodedaritgl($tgl)
{
    $unt = strtotime($tgl);
    return date('m', $unt) . date('Y', $unt);
}
function spekpo($po, $item, $dis)
{
    $CI = &get_instance();
    return $CI->helpermodel->spekpo($po, $item, $dis);
}
function spekdom($po, $item, $dis)
{
    $CI = &get_instance();
    return $CI->helpermodel->spekdom($po, $item, $dis);
}
function getpros($kode)
{
    $CI = &get_instance();
    return $CI->helpermodel->getpros($kode);
}
function nomorkontrak()
{
    // $xkode = trim($kode);
    $CI = &get_instance();
    $getkode = $CI->helpermodel->nomorkontrak();
    $xhasil = (int) $getkode['maks'] + 1;
    $hasil = $xhasil < 10 ? '00' . $xhasil : ($xhasil < 100 ? '0' . $xhasil : $xhasil);
    return $hasil . '/INM-KB/' . romawi(date('m')) . '/' . date('y');
}
function romawi($number)
{
    $map = [
        'M' => 1000,
        'CM' => 900,
        'D' => 500,
        'CD' => 400,
        'C' => 100,
        'XC' => 90,
        'L' => 50,
        'XL' => 40,
        'X' => 10,
        'IX' => 9,
        'V' => 5,
        'IV' => 4,
        'I' => 1
    ];
    $result = '';
    foreach ($map as $roman => $integer) {
        while ($number >= $integer) {
            $result .= $roman;
            $number -= $integer;
        }
    }
    return $result;
}
function formatnpwp($kata)
{
    $panjang = strlen($kata);
    $hasil = '';
    if ($panjang >= 15) {
        for ($x = 1; $x <= 6; $x++) {
            switch ($x) {
                case 1:
                    $hasil = substr($kata, 0, 2) . ".";
                    break;
                case 2:
                    $hasil .= substr($kata, 2, 3) . ".";
                    break;
                case 3:
                    $hasil .= substr($kata, 5, 3) . ".";
                    break;
                case 4:
                    $hasil .= substr($kata, 8, 1) . "-";
                    break;
                case 5:
                    $hasil .= substr($kata, 9, 3) . ".";
                    break;
                case 6:
                    $hasil .= substr($kata, 12, 3);
                    break;
                default:
                    # code...
                    break;
            }
        }
    }
    return $hasil;
}
function getstokbarangsaatini($data, $dept)
{
    // $xkode = trim($kode);
    $CI = &get_instance();
    $getkode = $CI->helpermodel->stoksaatini($data, $dept);
    return $getkode;
}
function daftardeptsubkon()
{
    // $xkode = trim($kode);
    $CI = &get_instance();
    $getkode = $CI->helpermodel->deptsubkon();
    return $getkode;
}

function nomor_dokumen($dept_id, $dept_tuju, $tb_header, $db, $tgl_input)
{
    $bulan = date('m', strtotime($tgl_input));
    $tahun = date('y', strtotime($tgl_input));
    $kode_bulan_tahun = $bulan . $tahun;

    $prefix_nomor = $dept_id . '-' . $dept_tuju . '/BP/' . $kode_bulan_tahun;


    $db->from($tb_header);
    $db->where('dept_id', $dept_id);
    $db->like('nomor_dok', $prefix_nomor, 'after');
    $jumlah = $db->count_all_results();

    $next_number = str_pad($jumlah + 1, 3, '0', STR_PAD_LEFT);

    return $prefix_nomor . '/' . $next_number;
}



function format_tanggal_indonesia($tanggal)
{
    $hari_indonesia = [
        'Sunday' => 'Minggu',
        'Monday' => 'Senin',
        'Tuesday' => 'Selasa',
        'Wednesday' => 'Rabu',
        'Thursday' => 'Kamis',
        'Friday' => 'Jumat',
        'Saturday' => 'Sabtu'
    ];

    $bulan_indonesia = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    ];

    $date = new DateTime($tanggal);
    $hari = $hari_indonesia[$date->format('l')];
    $tanggal = $date->format('d');
    $bulan = $bulan_indonesia[$date->format('F')];
    $tahun = $date->format('Y');

    return "$hari, $tanggal $bulan $tahun";
}
function tanggal_indonesia($tanggal)
{
    $bulan_indonesia = [
        'January' => 'Januari',
        'February' => 'Februari',
        'March' => 'Maret',
        'April' => 'April',
        'May' => 'Mei',
        'June' => 'Juni',
        'July' => 'Juli',
        'August' => 'Agustus',
        'September' => 'September',
        'October' => 'Oktober',
        'November' => 'November',
        'December' => 'Desember'
    ];

    $date = new DateTime($tanggal);
    $tanggal = $date->format('d');
    $bulan = $bulan_indonesia[$date->format('F')];
    $tahun = $date->format('Y');

    return "$tanggal $bulan $tahun";
}



function format_bulan_tahun($mY)
{
    $bulan = [
        '01' => 'Januari',
        '02' => 'Februari',
        '03' => 'Maret',
        '04' => 'April',
        '05' => 'Mei',
        '06' => 'Juni',
        '07' => 'Juli',
        '08' => 'Agustus',
        '09' => 'September',
        '10' => 'Oktober',
        '11' => 'November',
        '12' => 'Desember'
    ];

    $bulan_angka = substr($mY, 0, 2);
    $tahun = substr($mY, 2, 4);

    return $bulan[$bulan_angka] . ' ' . $tahun;
}

function showbom($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $pcs)
{
    $CI = &get_instance();
    $getkode = $CI->helpermodel->showbom($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $pcs);
    return $getkode;
}
function showbomjf($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $pcs, $mode)
{
    $CI = &get_instance();
    if ($mode == 1) {
        $getkode = $CI->helpermodel->showbomjf($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $pcs);
    } else {
        $getkode = $CI->helpermodel->showbomjfdom($po, $item, $dis, $idbarang, $insno, $nobontr, $kgs, $noe, $pcs);
    }
    return $getkode;
}
function getarrayindex(string $value, array $array, string $key)
{
    $searched_value = array_search($value, array_column($array, $key));
    return $searched_value;
}
function bulatkan($jml, $nilai)
{
    $pembulatan = ceil($jml / $nilai);
    return $pembulatan * $nilai;
}
// function bulatkan($jml, $nilai)
// {
//     $pembulatan = round($jml / $nilai);
//     return $pembulatan * $nilai;
// }
function ceknomorbc($data, $idbarang)
{
    $CI = &get_instance();
    $getkode = $CI->helpermodel->ceknomorbc($data, $idbarang);
    return $getkode;
}
function getjumlahcifbom($id, $no)
{
    $CI = &get_instance();
    $getkode = $CI->helpermodel->getjumlahcifbom($id, $no);
    return $getkode;
}
function getdokumenbcbynomordaftar($nodaf, $mode = 0)
{
    $CI = &get_instance();
    $getkode = $CI->helpermodel->getdokumenbcbynomordaftar($nodaf, $mode);
    return $getkode;
}
function getkettujuanout($kode)
{
    // $xkode = trim($kode);
    $CI = &get_instance();
    $getkode = $CI->helpermodel->getkettujuanout($kode);
    return $getkode;
}
function getquerytujuanout($kode, $val, $ke = 0)
{
    $CI = &get_instance();
    $getkode = $CI->helpermodel->getquerytujuanout($kode, $val, $ke);
    return $getkode;
}
function getkurssekarang($date = '')
{
    $CI = &get_instance();
    $getkode = $CI->helpermodel->getkurssekarang($date);
    return $getkode;
}

function getcurrentperiode()
{
    $bulan = date('m');
    // if($bulan <= 9){
    //     $bulan = '0'.$bulan;
    // }
    return $bulan . date('Y');
}
function getbcasal($exbc, $data)
{
    $CI = &get_instance();
    $get = $CI->helpermodel->getdetailbcasal($exbc, $data);
    return $get;
}
function getjumlahbcmasuk($nobc)
{
    $CI = &get_instance();
    $get = $CI->helpermodel->getjumlahbcmasuk($nobc);
    return $get;
}
function jumlahhari($date1, $date2)
{
    $dt1 = new DateTime($date1);
    $dt2 = new DateTime($date2);
    $hasil = 0;
    if ($dt1 > $dt2) {
        $hasil = 9999;
    } else {
        $interval = $dt1->diff($dt2);
        $daysDifference = $interval->days;
        $hasil = $daysDifference;
    }
    return $hasil;
}
