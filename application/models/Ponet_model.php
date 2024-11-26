<?php
class Ponet_model extends CI_Model
{
    public function cariData($po, $buy, $checked=null)
    {
        $this->db->select('tb_po.id as id_po, tb_po.po_id, tb_po.po, tb_po.item, tb_po.dis, tb_po.id_buyer, 
        tb_po.lim, tb_po.outstand, tb_po.st_piece, tb_po.weight, customer.nama_customer, nettype.name_nettype');
        $this->db->from('tb_po');
        $this->db->join('customer', 'customer.id = tb_po.id_buyer', 'left');
        $this->db->join('nettype', 'nettype.id = tb_po.id_nettype', 'left');
        $this->db->order_by('tb_po.lim', 'DESC');

        if ($buy == '0') {
            $this->db->like('tb_po.po', $po);
        } elseif ($buy == '1') {
            $this->db->like('customer.nama_customer', $po);
        } elseif ($buy == '2') {
            $this->db->where('tb_po.stat_po', 2);
            $this->db->like('tb_po.ord', $po);
        }

        if ($checked=="1") {
            $this->db->where('tb_po.stat_po =', 1);
            $this->db->where('tb_po.outstand >', 0);
            $this->db->where('YEAR(tb_po.lim) >=', date('Y'));
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


    public function GetDataByPo_id($po)
    {
        $this->db->select('tb_po.*, tb_netinstr.po_id, tb_netinstr.po, tb_netinstr.insno, tb_netinstr.date,tb_netinstr.dateplan,
        tb_netinstr.limitx, tb_netinstr.machno, tb_netinstr.specificx, tb_netinstr.ways, tb_netinstr.color, tb_netinstr.jenis');
        $this->db->from('tb_po');
        $this->db->join('tb_netinstr', 'tb_netinstr.po_id = tb_po.po_id', 'left');
        $this->db->where('tb_netinstr.po_id', $po);
        return $this->db->get()->row_array();
    }
}
