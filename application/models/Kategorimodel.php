<?php
class Kategorimodel extends CI_Model
{
    public function getdata()
    {
        $query = $this->db->get('kategori')->result_array();
        // $query = $this->db->query("Select * from satuan");
        return $query;
    }
    public function getdatabyid($id)
    {
        // $query = $this->db->query("Select * from kategori where id =" . $id);
        // return $query;
        return $this->db->get_where('kategori', ['id' => $id])->row_array();
    }
    public function simpankategori($data)
    {
        // $query = $this->db->insert('kategori', $data);
        // return $query;
        $this->db->insert('kategori', $data);
    }
    public function updatekategori($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('kategori', $data);
        return $query;
    }
    public function hapuskategori($id)
    {
        $query = $this->db->query("Delete from kategori where id =" . $id);
        return $query;
    }
}
