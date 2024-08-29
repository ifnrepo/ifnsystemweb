<?php
class Ponet_model extends CI_Model
{
    public function cariData($po, $buy, $limit = 100)
    {
        $this->db->select('tb_po.id as po_id, tb_po.po, tb_po.item, tb_po.dis, tb_po.id_buyer, tb_po.lim, tb_po.outstand, customer.nama_customer, nettype.name_nettype');
        $this->db->from('tb_po');
        $this->db->join('customer', 'customer.id = tb_po.id_buyer', 'left');
        $this->db->join('nettype', 'nettype.id = tb_po.id_nettype', 'left');
        $this->db->order_by('tb_po.lim', 'DESC');
        $this->db->limit($limit);
        if ($buy == '1') {
            $this->db->like('tb_po.po', $po);
        } elseif ($buy == '2') {
            $this->db->like('customer.nama_customer', $po);
        }
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
        $this->db->select('tb_po.*, customer.nama_customer, nettype.name_nettype');
        $this->db->from('tb_po');
        $this->db->join('customer', 'customer.id = tb_po.id_buyer', 'left');
        $this->db->join('nettype', 'nettype.id = tb_po.id_nettype', 'left');
        $this->db->where('tb_po.id', $id);
        return $this->db->get()->row_array();
    }
}
