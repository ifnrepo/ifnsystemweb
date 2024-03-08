<?php
class Kategori_dept_model extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('kategori_departemen')->result_array();
    }
    public function getdatabyid($id)
    {
        return $this->db->get_where('kategori_departemen', ['id' => $id])->row_array();
    }

    public function simpan_kategdept($data)
    {
        return $this->db->insert('kategori_departemen', $data);
    }
    public function update_kategdept($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('kategori_departemen', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('kategori_departemen');
    }
}
