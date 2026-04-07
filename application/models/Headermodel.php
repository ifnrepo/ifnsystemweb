<?php
class Headermodel extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('page_header')->result_array();
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('page_header', ['id' => $id])->row_array();
    }
    public function simpan($data)
    {
        return $this->db->insert('page_header', $data);
    }
    public function updatedata($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('page_header', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('page_header');
    }
}
