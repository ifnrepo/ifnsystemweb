<?php
class Ket_prosesmodel extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('ref_proses')->result_array();
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('ref_proses', ['id' => $id])->row_array();
    }
    public function simpan($data)
    {
        return $this->db->insert('ref_proses', $data);
    }
    public function updatedata($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('ref_proses', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('ref_proses');
    }
}
