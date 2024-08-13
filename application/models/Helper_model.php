<?php
class Helper_model extends CI_Model
{
    public function cekkolom($id,$kolom,$nilai,$tabel){
        $this->db->where('id',$id);
        $this->db->where($kolom,$nilai);
        $hasil = $this->db->get($tabel);
        return $hasil;
    }
    public function getterms($kode){
        $this->db->where('lokal',$kode);
        $hasil = $this->db->get('term_payment');
        return $hasil;
    }
    public function getdatasublok(){
        $dp = $this->session->userdata('deptsekarang');
        switch ($dp) {
            case 'FG':
                $this->db->where('kode',1);
                break;
            default:
                # code...
                break;
        }
        $hasil = $this->db->get('tb_sublok');
        return $hasil;
    }
    public function riwayatdok($id){
        $this->db->where('id',$id);
        $cek = $this->db->get('tb_header')->row_array();
        $hasil = [];
        if($cek['data_ok']==1){
            $kata = 'Dokumen dibuat oleh '.datauser($cek['user_ok'],'name').' on '.tglmysql2($cek['tgl_ok']);
            array_push($hasil,$kata);
        }
        if($cek['ok_valid']==1){
            $kata = 'Dokumen disetujui oleh '.datauser($cek['user_valid'],'name').' on '.tglmysql2($cek['tgl_valid']);
            array_push($hasil,$kata);
        }
        // Cek detail barang 
        $this->db->where('id_header',$id);
        $detail = $this->db->get('tb_detail');
        foreach($detail->result_array() as $det){
            
        }
        return $hasil;
    }
    public function dataproduksi(){
        $array1 = [];
        $array2 = [];
        $this->db->select('tgl,jan');
        $this->db->where('tahun',date('Y'));
        $cek = $this->db->get('monitoringprd')->result_array();
        foreach ($cek as $kec) {
            array_push($array1,$kec['tgl']);
            array_push($array2,$kec['jan']);
        }
        return array('data_tgl' => $array1, 'data_isi' => $array2);
    }
}