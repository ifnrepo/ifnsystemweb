<?php
class Customer_model extends CI_Model
{
    public function getdata()
    {
        $query = $this->db->get('customer')->result_array();
        // $query = $this->db->query("Select * from satuan");
        return $query;
    }
    public function getdatabyid($id)
    {
        // $query = $this->db->query("Select * from kategori where id =" . $id);
        // return $query;
        return $this->db->get_where('customer', ['id' => $id])->row_array();
    }
    public function simpancustomer($data)
    {
        // $query = $this->db->insert('customer', $data);
        // return $query;
        $this->db->insert('customer', $data);
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
}
