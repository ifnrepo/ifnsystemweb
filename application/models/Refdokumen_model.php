<?php
class Refdokumen_model extends CI_Model
{
    public function getdata()
    {
        return $this->db->get('ref_dokumen')->result_array();
    }
    public function getdatabyid($kode)
    {
        return $this->db->get_where('ref_dokumen', ['kode' => $kode])->row_array();
    }

    public function simpanrefdok($data)
    {
        return $this->db->insert('ref_dokumen', $data);
    }
    public function updaterefdok($data)
    {
        $this->db->where('kode', $data['kode']);
        return $this->db->update('ref_dokumen', $data);
    }
    public function hapusrefdok($kode)
    {
        $this->db->where('kode', $kode);
        return $this->db->delete('ref_dokumen');
    }
}
