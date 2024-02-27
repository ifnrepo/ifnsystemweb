<?php
class Supplier_model extends CI_Model
{
    public function getdata()
    {
        $query = $this->db->get('supplier')->result_array();
        // $query = $this->db->query("Select * from satuan");
        return $query;
    }
    public function getdatabyid($id)
    {
        // $query = $this->db->query("Select * from kategori where id =" . $id);
        // return $query;
        return $this->db->get_where('supplier', ['id' => $id])->row_array();
    }
    public function simpansupplier($data)
    {
        // $query = $this->db->insert('kategori', $data);
        // return $query;
        return $this->db->insert('supplier', $data);
    }
    public function updatesupplier($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('supplier', $data);
        return $query;
    }
    public function hapussupplier($id)
    {
        $query = $this->db->query("Delete from supplier where id =" . $id);
        return $query;
    }
}
