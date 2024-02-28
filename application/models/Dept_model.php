<?php
class Dept_model extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('dept')->result_array();
    }
    public function getdatabyid($dept_id)
    {
        return $this->db->get_where('dept', ['dept_id' => $dept_id])->row_array();
    }

    public function simpandept($data)
    {
        return $this->db->insert('dept', $data);
    }
    public function updatedept($data)
    {
        $this->db->where('dept_id', $data['dept_id']);
        return $this->db->update('dept', $data);
    }
    public function hapusdept($dept_id)
    {
        $this->db->where('dept_id', $dept_id);
        return $this->db->delete('dept');
    }
}
