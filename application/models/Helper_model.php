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
}