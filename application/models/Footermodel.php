<?php
class Footermodel extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('page_footer')->result_array();
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('page_footer', ['id' => $id])->row_array();
    }
    public function simpan($data)
    {
        return $this->db->insert('page_footer', $data);
    }
    public function updatedata($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('page_footer', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('page_footer');
    }
}
