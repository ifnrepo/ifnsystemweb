<?php
class Mtuangmodel extends CI_Model
{
    public function getdata(){
        $hasil = $this->db->get('ref_mt_uang');
        return $hasil;
    }
}
