<?php
class Customer_model extends CI_Model
{
    public function getdata()
    {
        $this->db->select('customer.*, ref_negara.kode_negara');
        $this->db->from('customer');
        $this->db->join('ref_negara', 'ref_negara.kode_negara = customer.kode_negara', 'left');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function getdatabyid($id)
    {
        $this->db->select('customer.*, ref_negara.kode_negara');
        $this->db->from('customer');
        $this->db->join('ref_negara', 'ref_negara.kode_negara = customer.kode_negara', 'left');
        $this->db->where('customer.id', $id);
        return $this->db->get()->row_array();
    }
    public function simpancustomer($data)
    {
        // $query = $this->db->insert('customer', $data);
        // return $query;
        return $this->db->insert('customer', $data);
    }
    public function updatecustomer($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('customer', $data);
        return $query;
    }
    public function hapuscustomer($id)
    {
        $query = $this->db->query("Delete from customer where id =" . $id);
        return $query;
    }
    public function getdatabyname($nama)
    {
        $this->db->like('nama_customer', $nama);
        return $this->db->get('customer');
    }
}
