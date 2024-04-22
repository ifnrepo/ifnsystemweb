<?php
class Personilmodel extends CI_Model
{
    public function getdata()
    {
        $query = $this->db->get('personil')->result_array();
        // $query = $this->db->query("Select * from satuan");  

        return $query;
    }
    public function getdatabyid($personil_id)
    {

        return $this->db->get_where('personil', ['personil_id' => $personil_id])->row_array();
    }

    public function hapus($personil_id)
    {
        $query = $this->db->query("Delete from personil where personil_id =" . $personil_id);
        return $query;
    }

    public function simpandata()
    {
        $data = $_POST;
        $hasil = $this->db->insert('personil', $data);
        return $hasil;
    }
    public function updatedata()
    {
        $data = $_POST;
        $this->db->where('personil_id', $data['personil_id']);
        $hasil = $this->db->update('personil', $data);
        return $hasil;
    }
}
