<?php
class Helper_model extends CI_Model
{
    public function cekkolom($id, $kolom, $nilai, $tabel)
    {
        $this->db->where('id', $id);
        $this->db->where($kolom, $nilai);
        $hasil = $this->db->get($tabel);
        return $hasil;
    }
    public function getterms($kode)
    {
        $this->db->where('lokal', $kode);
        $hasil = $this->db->get('term_payment');
        return $hasil;
    }
    public function getdatasublok()
    {
        $dp = $this->session->userdata('deptsekarang');
        switch ($dp) {
            case 'FG':
                $this->db->where('kode', 1);
                break;
            default:
                # code...
                break;
        }
        $hasil = $this->db->get('tb_sublok');
        return $hasil;
    }
    public function riwayatdok($id)
    {
        $this->db->where('id', $id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
        if ($cek['data_ok'] == 1) {
            $kata = 'Dokumen DIBUAT oleh ' . datauser($cek['user_ok'], 'name') . ' on ' . tglmysql2($cek['tgl_ok']);
            array_push($hasil, $kata);
        }
        if ($cek['ok_valid'] == 1) {
            $kata = 'Dokumen DISETUJUI oleh ' . datauser($cek['user_valid'], 'name') . ' on ' . tglmysql2($cek['tgl_valid']);
            array_push($hasil, $kata);
        }
        // Cek detail barang 
        $this->db->where('id_header', $id);
        $detail = $this->db->get('tb_detail');
        $hasil2 = [];
        foreach ($detail->result_array() as $det) {
            $barang = $this->db->get_where('barang', ['id' => $det['id_barang']])->row_array();
            if(trim($det['po'])==""){
                $kata = $barang['nama_barang'];
            }else{
                $kata = spekpo($det['po'],$det['item'],$det['dis']);
            }
            array_push($hasil2, $kata);
            $hasil3 = [];
            $kepalanya = 0;
            for ($ke = 0; $ke <= 3; $ke++) {
                // 0 : cek data BBL
                // 1 : cek data PO
                // 2 : cek data IB
                // 3 : cek data OUT
                switch ($ke) {
                    case 0:
                        $fid = 'id_bbl';
                        $fod = 'id_po';
                        $fed = 'BBL No. ';
                        break;
                    case 1:
                        $fid = 'id_po';
                        $fod = 'id_ib';
                        $fed = 'PO No. ';
                        break;
                    case 2:
                        $fid = 'id_ib';
                        $fod = 'id_out';
                        $fed = 'IB No. ';
                        break;
                    case 3:
                        $fid = 'id_out';
                        $fod = 'id';
                        $fed = 'OUT No. ';
                        break;
                }
                if ($kepalanya == 1) {
                    $cekisi = $this->db->get_where('tb_detail', ['id' => $idisinya]);
                    if ($cekisi->num_rows() > 0) {
                        $rekisi = $cekisi->row_array();
                        $det[$fid] = $rekisi['id'];
                    } else {
                        $det[$fid] = 0;
                    }
                }
                $selesai = $ke == 3 ? ' (SELESAI)' : '';
                if ($det[$fid] != 0) {
                    $isifield = $det[$fid];
                    $this->db->select('tb_header.*,tb_detail.id_bbl,tb_detail.id_po,tb_detail.id_ib,tb_detail.id_out,tb_detail.id_minta');
                    $this->db->from('tb_header');
                    $this->db->join('tb_detail', 'tb_detail.id_header = tb_header.id', 'left');
                    $this->db->where('tb_detail.id', $isifield);
                    $isinya = $this->db->get()->row_array();
                    $kepalanya = 1;
                    $idisinya = $isinya[$fod];
                    array_push($hasil3, $fed . $isinya['nomor_dok'] . ' ; ' . tglmysql($isinya['tgl']) . $selesai);
                } else {
                    $kepalanya = 0;
                    // array_push($hasil3,$fed.'-');
                }
            }
            array_push($hasil2, $hasil3);
        }
        array_push($hasil, $hasil2);
        return $hasil;
    }
    public function riwayatbbl($id)
    {
        $this->db->where('id', $id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
        if ($cek['ok_bb'] == 1) {
            $data_ok = 'Dokumen diinput Oleh : ' . datauser($cek['user_bb'], 'name') . ' on ' . $cek['tgl_bb'];
            array_push($hasil, $data_ok);
        } else {
            $data_ok = 'Dokumen belum selesai di input !';
            array_push($hasil, $data_ok);
        }
        if ($cek['data_ok'] == 1) {
            $ok_bb = 'Dokumen dibuat oleh : ' . datauser($cek['user_ok'], 'name') . ' on ' . $cek['tgl_ok'];
            array_push($hasil, $ok_bb);
        } else {
            if ($cek['ok_bb'] == 1) {
                $ok_bb = 'Menunggu Approve kepala departemen ' . $cek['dept_id'];
                array_push($hasil, $ok_bb);
            }
        }
        if ($cek['ok_pp'] == 1) {
            $ok_bb = 'Dokumen diapprove oleh : ' . datauser($cek['user_pp'], 'name') . ' on ' . $cek['tgl_pp'];
            array_push($hasil, $ok_bb);
        } else {
            if ($cek['ok_bb'] == 1 && $cek['ok_pp']==0) {
                $ok_bb = 'Menunggu Approve Manager PP ';
                array_push($hasil, $ok_bb);
            }
        }
        if ($cek['ok_valid'] == 1) {
            $ok_valid = 'Dokumen divalidasi oleh : ' . datauser($cek['user_valid'], 'name') . ' on ' . $cek['tgl_valid'];
            array_push($hasil, $ok_valid);
        } else {
            if ($cek['data_ok'] == 1 && $cek['ok_pp']==1) {
                $ok_bb = 'Menunggu Validasi Manager ' . $cek['dept_bbl'];
                array_push($hasil, $ok_bb);
            }
        }
        if ($cek['ok_tuju'] == 1) {
            $ok_valid = 'Dokumen disetujui oleh : ' . datauser($cek['user_tuju'], 'name') . ' on ' . $cek['tgl_tuju'];
            array_push($hasil, $ok_valid);
        } else {
            if ($cek['ok_valid'] == 1) {
                $ok_bb = 'Menunggu Validasi GM ' . $cek['dept_id'];
                array_push($hasil, $ok_bb);
            }
        }
        if ($cek['ok_pc'] == 1) {
            $ok_valid = 'Dokumen Disetujui oleh : ' . datauser($cek['user_pc'], 'name') . ' on ' . $cek['tgl_pc'];
            array_push($hasil, $ok_valid);

            $this->db->select('tb_detail.*,barang.nama_barang');
            $this->db->from('tb_detail');
            $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
            $this->db->where('tb_detail.id_header', $id);
            $cek = $this->db->get();
            if ($cek->num_rows() > 0) {
                $hasil2 = [];
                foreach ($cek->result_array() as $det) {
                    array_push($hasil2, $det['nama_barang']);
                    $hasil3 = [];
                    $kepalanya = 0;
                    for ($ke = 0; $ke <= 3; $ke++) {
                        // 0 : cek data BBL
                        // 1 : cek data PO
                        // 2 : cek data IB
                        // 3 : cek data OUT
                        switch ($ke) {
                            case 0:
                                $fid = 'id_bbl';
                                $fod = 'id_po';
                                $fed = 'BBL No. ';
                                break;
                            case 1:
                                $fid = 'id_po';
                                $fod = 'id_ib';
                                $fed = 'PO No. ';
                                break;
                            case 2:
                                $fid = 'id_ib';
                                $fod = 'id_out';
                                $fed = 'IB No. ';
                                break;
                            case 3:
                                $fid = 'id_out';
                                $fod = 'id';
                                $fed = 'OUT No. ';
                                break;
                        }
                        if ($kepalanya == 1) {
                            $cekisi = $this->db->get_where('tb_detail', ['id' => $idisinya]);
                            if ($cekisi->num_rows() > 0) {
                                $rekisi = $cekisi->row_array();
                                $det[$fid] = $rekisi['id'];
                            } else {
                                $det[$fid] = 0;
                            }
                        }
                        $selesai = $ke == 3 ? ' (SELESAI)' : '';
                        if ($det[$fid] != 0) {
                            $isifield = $det[$fid];
                            $this->db->select('tb_header.*,tb_detail.id_bbl,tb_detail.id_po,tb_detail.id_ib,tb_detail.id_out,tb_detail.id_minta');
                            $this->db->from('tb_header');
                            $this->db->join('tb_detail', 'tb_detail.id_header = tb_header.id', 'left');
                            $this->db->where('tb_detail.id', $isifield);
                            $isinya = $this->db->get()->row_array();
                            $kepalanya = 1;
                            $idisinya = $isinya[$fod];
                            array_push($hasil3, $fed . $isinya['nomor_dok'] . ' ; ' . tglmysql($isinya['tgl']) . $selesai);
                        } else {
                            $kepalanya = 0;
                            // array_push($hasil3,$fed.'-');
                        }
                    }
                    array_push($hasil2, $hasil3);
                }
                array_push($hasil, $hasil2);
            }
        } else {
            if ($cek['ok_tuju'] == 1) {
                $ok_bb = 'Menunggu Validasi GM Purchasing';
                array_push($hasil, $ok_bb);
            }
        }
        return $hasil;
    }
    public function riwayatpo($id)
    {
        $this->db->where('id', $id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
        if ($cek['data_ok'] == 1) {
            $ok = 'Dokumen dibuat oleh : ' . datauser($cek['user_ok'], 'name') . ' on ' . $cek['tgl_ok'];
            array_push($hasil, $ok);
        } else {
            array_push($hasil, 'Dokumen sedang dibuat');
        }
        if ($cek['ok_valid'] == 1) {
            $valid = 'Dokumen sudah disetujui ' . datauser($cek['user_valid'], 'name') . ' on ' . $cek['tgl_valid'];
            array_push($hasil, $valid);
        } else {
            if ($cek['data_ok'] == 1) {
                $valid = 'Dokumen menunggu persetujuan';
                array_push($hasil, $valid);
            }
        }
        return $hasil;
    }
    public function riwayatbcmasuk($id){
        $this->db->where('id', $id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
         if ($cek['data_ok'] == 1) {
            $ok = 'Dokumen dibuat oleh : ' . datauser($cek['user_ok'], 'name') . ' on ' . $cek['tgl_ok'];
            array_push($hasil,$ok);
        } else {
            array_push($hasil, 'Dokumen sedang dibuat');
        }
         if ($cek['ok_tuju'] == 1) {
            $valid = 'Dokumen sudah diverifikasi ' . datauser($cek['user_tuju'], 'name') . ' on ' . $cek['tgl_tuju'];
            array_push($hasil, $valid);
        } else {
            if ($cek['data_ok'] == 1) {
                $valid = 'Dokumen menunggu verifikasi BC';
                array_push($hasil, $valid);
            }
        }
        if ($cek['ok_valid'] == 1) {
            $valid = 'Dokumen sudah divalidasi ' . datauser($cek['user_valid'], 'name') . ' on ' . $cek['tgl_valid'];
            array_push($hasil, $valid);
        } else {
            if ($cek['data_ok'] == 1) {
                $valid = 'Dokumen menunggu Validasi';
                array_push($hasil, $valid);
            }
        }
        return $hasil;
    }
    public function riwayatbckeluar($id){
        $this->db->where('id', $id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
         if ($cek['data_ok'] == 1) {
            $ok = 'Dokumen dibuat oleh : ' . datauser($cek['user_ok'], 'name') . ' on ' . $cek['tgl_ok'];
            array_push($hasil,$ok);
            // array_push($hasil, '1' => $ok);
            // $hasil['dibuat'] = $cek['tgl'];
            // $hasil['tgldibuat'] = $ok;
        } else {
            array_push($hasil, 'Dokumen sedang dibuat');
        }
         if ($cek['ok_tuju'] == 1) {
            $valid = 'Dokumen sudah diverifikasi ' . datauser($cek['user_tuju'], 'name') . ' on ' . $cek['tgl_tuju'];
            array_push($hasil, $valid);
        } else {
            if ($cek['data_ok'] == 1) {
                $valid = 'Dokumen menunggu verifikasi BC';
                array_push($hasil, $valid);
            }
        }
        if ($cek['ok_valid'] == 1) {
            $valid = 'Dokumen sudah divalidasi ' . datauser($cek['user_valid'], 'name') . ' on ' . $cek['tgl_valid'];
            array_push($hasil, $valid);
        } else {
            if ($cek['data_ok'] == 1) {
                $valid = 'Dokumen menunggu Validasi';
                array_push($hasil, $valid);
            }
        }
        return $hasil;
    }
    public function dataproduksi()
    {
        $bulan = 'janfebmaraprmeijunjulagtsepoktnopdes';
        $fieldd = substr($bulan, ((int)date('m') * 3) - 3, 3);
        $fielde = substr($bulan, (((int)date('m') - 1) * 3) - 3, 3);
        $array1 = [];
        $array2 = [];
        $this->db->select("SUM(jan) AS jan,SUM(feb) AS feb,SUM(mar) AS mar,SUM(apr) AS apr,SUM(mei) AS mei,SUM(jun) AS jun,SUM(jul) AS jul,SUM(agt) AS agt,SUM(sep) AS sep,SUM(okt) AS okt,SUM(nop) AS nop,SUM(des) AS des");
        $this->db->where('tahun', date('Y'));
        $cek = $this->db->get('monitoringprd')->row_array();
        for ($x = 0; $x < 12; $x++) {
            $field = substr($bulan, (($x + 1) * 3) - 3, 3);
            $cik = $x + 1;
            $cok = $field;
            array_push($array1, strtoupper($field) . ' - ' . date('Y'));
            array_push($array2, $cek[$field]);
        }
        // foreach ($cek as $kec) {
        //     array_push($array1,$kec['tgl']);
        //     array_push($array2,$kec[$field]);
        // }
        return array('data_tgl' => $array1, 'data_isi' => $array2, 'data_prod_bulan_ini' => $cek[$fieldd], 'data_prod_bulan_lalu' => $cek[$fielde]);
    }

    public function isilog($isilog)
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        $dapatkan_ip = get_client_ip();

        if ($this->isLocalIP($dapatkan_ip)) {
            $ip = 'Local IP';
        } else {
            $ip = 'Public IP';
        }

        $data = [
            'activitylog' => str_replace('`', '', $isilog),
            'userlog' => datauser($this->session->userdata('id'), 'name'),
            'iduserlog' => $this->session->userdata('id'),
            'devicelog' => $dapatkan_ip . ' (' . $ip . ') on ' . $useragent,
            'modul' => strtoupper($this->uri->segment(1))
        ];

        $this->db->insert('tb_logactivity', $data);
    }


    private function isLocalIP($ip)
    {
        return preg_match('/^10\..*/', $ip) ||
            preg_match('/^192\.168\..*/', $ip) ||
            preg_match('/^172\.(1[6-9]|2[0-9]|3[0-1])\..*/', $ip);
    }

    public function cekclosebook($periode)
    {
        $this->db->where('periode', $periode);
        $hasil = $this->db->get('tb_lockinv')->num_rows();
        return $hasil;
    }
    public function cekdetout($header)
    {
        $this->db->where('id_out', 0);
        $this->db->where('id_header', $header);
        $hasil = $this->db->get('tb_detail')->num_rows();
        return $hasil;
    }
    public function getbctoken(){
        $this->db->where('id',1);
        $hasil =  $this->db->get('token_bc')->row_array();
        return $hasil['token'];
    }
    public function getdatadepartemen($kode){
        return $this->db->get_where('dept',['dept_id'=>$kode]);
    }
    public function getdatafooter(){
        return $this->db->get('page_footer');
    }
    public function cekstokdeptraw($dept,$nobontr,$idbarang,$kgs,$pcs,$jns=0){
        $allowdept = ['SP','GM']; //Departemen Sementara yang diperbolehkan
        if(in_array($dept,$allowdept)){
            $kondisi = [
                'dept_id' => $dept,
                'nobontr' => $nobontr,
                'id_barang' => $idbarang,
            ];
            $this->db->where($kondisi);
            $adaisi = $this->db->get('stokdeptraw');
            if($adaisi->num_rows()==0){
                if($jns==0){
                    $kondisiinput = [
                        'dept_id' => $dept,
                        'nobontr' => $nobontr,
                        'id_barang' => $idbarang,
                        'kgs' => $kgs,
                        'pcs' => $pcs
                    ];
                    $this->db->insert('stokdeptraw',$kondisiinput);
                }
            }else{
                if($jns==0){
                    $this->db->set('pcs','pcs +'.$pcs,false);
                    $this->db->set('kgs','kgs +'.$kgs,false);
                }else{
                    $this->db->set('pcs','pcs -'.$pcs,false);
                    $this->db->set('kgs','kgs -'.$kgs,false);
                }
                $this->db->where('dept_id',$dept);
                $this->db->where('nobontr',$nobontr);
                $this->db->where('id_barang',$idbarang);
                $this->db->update('stokdeptraw');
            }
        }
    }
    public function spekpo($po,$item,$dis){
        $nilai = '';
        $data = [
            'po' => trim($po),
            'trim(item)' => trim($item),
            'dis' => $dis
        ];
        $hasil  = $this->db->get_where('tb_po',$data);
        if($hasil->num_rows() == 0){
            $nilai = '';
        }else{
            $hasilnya = $hasil->row_array();
            $nilai = $hasilnya['spek'];
        }
        return $nilai;
    }
    public function getpros($kode){
        if(trim($kode)==''){
            $hasil = '';
        }else{
            $arrhasil = '';
            $pisah = explode(',',$kode);
            $jumlaharr = count($pisah);
            for($x=1;$x<=$jumlaharr;$x++){
                $query = $this->db->get_where('tb_proses',['kode' => $pisah[$x-1]]);
                if($query->num_rows() > 0){
                    $xhasil = $query->row_array();
                    $spasi = $x > 1 ? ' ' : '';
                    $arrhasil .= $spasi.trim($xhasil['ket']);
                }
            }
            $hasil = ucwords(strtolower($arrhasil));
        }
        return $hasil;
    }
    public function getkontrakrekanan(){
        $data = $this->db->get_where('apps_config',['key' => 'tuju_kontrak'])->row_array();
        $arrrekan = [];
        $kali = strlen(trim($data['value']))/2;
        for($ke=0;$ke<$kali;$ke++){
            $hasil_dept = substr($data['value'],(($ke+1)*2)-2,2);
            $dept = $this->db->get_where('dept',['dept_id'=>$hasil_dept])->row_array();
            $arr = [
                'dept_id' => $dept['dept_id'],
                'departemen' => $dept['departemen'],
            ];
            array_push($arrrekan,$arr);
        }
        return $arrrekan;
    }
    public function nomorkontrak(){
        $tahun = date('y');
        $this->db->select('MAX(LEFT(nomor,3)) AS maks');
        $this->db->from('tb_kontrak');
        $this->db->where('RIGHT(TRIM(nomor),2)',$tahun);
        $this->db->where('LEFT(nomor,3) != ','000');
        $this->db->where('jns_bc',$this->session->userdata('jnsbckontrak'));
        return $this->db->get()->row_array();
    }
}
