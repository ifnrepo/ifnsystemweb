<?php
class Personilmodel extends CI_Model
{
    public function getdata()
    {
        $this->db->select('personil.*, dept.departemen, grup.nama_grup, jabatan.nama_jabatan, tb_agama.nama_agama, tb_status.nama_status, tb_pendidikan.tingkat_pendidikan');

        $this->db->from('personil');
        $this->db->join('dept', 'dept.urut = personil.bagian_id', 'left');
        $this->db->join('jabatan', 'jabatan.id = personil.jabatan_id', 'left');
        $this->db->join('grup', 'grup.id = personil.grup_id', 'left');
        $this->db->join('tb_agama', 'tb_agama.id = personil.id_agama', 'left');
        $this->db->join('tb_status', 'tb_status.id = personil.id_status', 'left');
        $this->db->join('tb_pendidikan', 'tb_pendidikan.id = personil.id_pendidikan', 'left');

        return $this->db->get()->result_array();
    }

    public function getdatabyid($personil_id)
    {
        $this->db->select('personil.*, dept.departemen, grup.nama_grup, jabatan.nama_jabatan, tb_agama.nama_agama, tb_status.nama_status, tb_pendidikan.tingkat_pendidikan');

        $this->db->from('personil');
        $this->db->join('dept', 'dept.urut = personil.bagian_id', 'left');
        $this->db->join('jabatan', 'jabatan.id = personil.jabatan_id', 'left');
        $this->db->join('grup', 'grup.id = personil.grup_id', 'left');
        $this->db->join('tb_agama', 'tb_agama.id = personil.id_agama', 'left');
        $this->db->join('tb_status', 'tb_status.id = personil.id_status', 'left');
        $this->db->join('tb_pendidikan', 'tb_pendidikan.id = personil.id_pendidikan', 'left');
        $this->db->where('personil.personil_id', $personil_id);
        return $this->db->get()->row_array();
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
    // public function simpandata($data)
    // {
    //     // Simpan data ke tabel 'personil'
    //     $hasil = $this->db->insert('personil', $data);
    //     return $hasil;
    // }

    public function updatedata()
    {
        $data = $_POST;
        $this->db->where('personil_id', $data['personil_id']);
        $hasil = $this->db->update('personil', $data);
        return $hasil;
    }
}
