<?php
class Pendidikanmodel extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('tb_pendidikan')->result_array();
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('tb_pendidikan', ['id' => $id])->row_array();
    }
    public function simpan($data)
    {
        return $this->db->insert('tb_pendidikan', $data);
    }
    public function updatedata($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('tb_pendidikan', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_pendidikan');
    }
}
