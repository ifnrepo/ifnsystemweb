<?php
class Dept_model extends CI_Model
{
    public function getdata()
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        
        return $this->db->get()->result_array();
    }
    public function jmldept(){
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        
        return $this->db->get()->num_rows();
    }
    public function getdatakatedept(){
        return $this->db->get('kategori_departemen')->result_array();
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
