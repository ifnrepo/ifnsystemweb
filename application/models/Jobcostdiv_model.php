<?php
class Jobcostdiv_model extends CI_Model
{

    public function getdata()
    {
        $this->db->order_by('tahun');
        return $this->db->get('ref_jobcost');
    }
    public function getdatabyid($id)
    {
        $this->db->where('id', $id);
        $query = $this->db->get('ref_jobcost');
        return $query->row_array();
    }
    public function simpandata($data)
    {
        return $this->db->insert('ref_jobcost', $data);
    }
    public function updatedata($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('ref_jobcost', $data);
        return $query;
    }
    public function hapusdata($id)
    {
        $query = $this->db->query("Delete from ref_jobcost where id =" . $id);
        return $query;
    }
}
