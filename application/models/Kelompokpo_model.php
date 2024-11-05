<?php
class Kelompokpo_model extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('tb_klppo')->result_array();
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('tb_klppo', ['id' => $id])->row_array();
    }
    public function simpan($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->get('tb_klppo');

        if ($query->num_rows() > 0) {
            return 'ID sudah ada';
        } else {
            return $this->db->insert('tb_klppo', $data);
        }
    }

    // public function simpan($data)
    // {
    //     return $this->db->insert('tb_klppo', $data);
    // }
    public function updatedata($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('tb_klppo', $data);
    }
    public function hapus($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_klppo');
    }
}
