<?php
class Statusmodel extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('tb_status')->result_array();
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('tb_status', ['id' => $id])->row_array();
    }
    public function simpan($data)
    {
        return $this->db->insert('tb_status', $data);
    }
    public function updatedata($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('tb_status', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_status');
    }
}
