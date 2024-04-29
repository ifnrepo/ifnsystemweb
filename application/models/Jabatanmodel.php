<?php
class Jabatanmodel extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('jabatan')->result_array();
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('jabatan', ['id' => $id])->row_array();
    }
    public function simpan($data)
    {
        return $this->db->insert('jabatan', $data);
    }
    public function updatedata($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('jabatan', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('jabatan');
    }
}
