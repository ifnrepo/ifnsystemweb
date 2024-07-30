<?php
class Helper_model extends CI_Model
{
    public function cekkolom($id,$kolom,$nilai,$tabel){
        $this->db->where('id',$id);
        $this->db->where($kolom,$nilai);
        $hasil = $this->db->get($tabel);
        return $hasil;
    }
}