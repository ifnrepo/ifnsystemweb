<?php
class Nettype_model extends CI_Model
{
    public function getdata()
    {
        $this->db->select('nettype.*, kategori.nama_kategori');
        $this->db->from('nettype');
        $this->db->join('kategori', 'kategori.kategori_id = nettype.id_kategori', 'left');
        
        return $this->db->get()->result_array();

    }

    public function getdata_kategori(){
        return $this->db->get('kategori')->result_array();
    }
    public function getdatabyid($id)
    {
        // $query = $this->db->query("Select * from kategori where id =" . $id);
        // return $query;
        return $this->db->get_where('nettype', ['id' => $id])->row_array();
    }
    public function simpannettype($data)
    {
        // $query = $this->db->insert('kategori', $data);
        // return $query;
        return $this->db->insert('nettype', $data);
    }
    public function updatenettype($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('nettype', $data);
    }
    public function hapusnettype($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('nettype');
        // $query = $this->db->query("Delete from kategori where id =" . $id);
        // return $query;
    }
}
