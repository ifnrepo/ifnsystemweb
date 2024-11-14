<?php
class Rekanan_model extends CI_Model
{
    public function getdata()
    {
        $query = $this->db->get('tb_rekanan')->result_array();
        // $query = $this->db->query("Select * from satuan");
        return $query;
    }
    public function getdatabyid($id)
    {
        // $query = $this->db->query("Select * from kategori where id =" . $id);
        // return $query;
        return $this->db->get_where('tb_rekanan', ['id' => $id])->row_array();
    }
    public function simpan($data)
    {
        // $query = $this->db->insert('customer', $data);
        // return $query;
        return $this->db->insert('tb_rekanan', $data);
    }
    public function update($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_rekanan', $data);
        return $query;
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_rekanan');
    }
}
