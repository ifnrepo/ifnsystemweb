<?php
class Lockinvmodel extends CI_Model
{
    public function getdata()
    {
        $this->db->select('tb_lockinv.*, user.name');
        $this->db->from('tb_lockinv');
        $this->db->join('user', 'user.id = tb_lockinv.dibuat_oleh', 'left');

        return $this->db->get()->result_array();
    }
    public function tambah($data){
        $hasil = $this->db->insert('tb_lockinv',$data);
        return $hasil;
    }   
    public function hapus($id){
        $this->db->where('id',$id);
        $query = $this->db->delete('tb_lockinv');
        return $query;
    }
    public function getdatabyid($personil_id)
    {
        $this->db->select('personil.*, dept.departemen, grup.nama_grup, jabatan.nama_jabatan');
        $this->db->from('personil');
        $this->db->join('dept', 'dept.urut = personil.bagian_id', 'left');
        $this->db->join('jabatan', 'jabatan.id = personil.jabatan_id', 'left');
        $this->db->join('grup', 'grup.id = personil.grup_id', 'left');
        $this->db->where('personil.personil_id', $personil_id);
        return $this->db->get()->row_array();
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
