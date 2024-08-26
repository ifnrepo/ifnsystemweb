<?php
class Ponet_model extends CI_Model
{
    public function cariData($po)
    {
        $this->db->select('tb_po.*, customer.nama_customer');
        $this->db->from('tb_po');
        $this->db->join('customer', 'customer.id = tb_po.id_buyer', 'left');
        $this->db->like('tb_po.po', $po);
        $this->db->or_like('customer.nama_customer', $po);
        $result = $this->db->get()->result_array();

        if ($result) {
            return $result;
        } else {
            echo '<script>alert("Mohon Maaf Data PO/BUYER Tidak Tersedia !");</script>';
            return null;
        }
    }

    public function GetDataByid($id)
    {
        $this->db->select('tb_po.*, customer.nama_customer');
        $this->db->from('tb_po');
        $this->db->join('customer', 'customer.id = tb_po.id_buyer', 'left');
        $this->db->where('tb_po.id', $id);
        return $this->db->get()->row_array();
    }
}
