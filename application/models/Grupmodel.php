<?php
class Grupmodel extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('grup')->result_array();
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('grup', ['id' => $id])->row_array();
    }
    public function simpan($data)
    {
        return $this->db->insert('grup', $data);
    }
    public function updatedata($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('grup', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('grup');
    }
}
