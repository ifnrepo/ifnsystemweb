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
        return $this->db->get();
    }


    public function hapus($personil_id)
    {
        $query = $this->db->query("Delete from personil where personil_id =" . $personil_id);
        return $query;
    }


    // public function simpandata()
    // {
    //     $data = $_POST;
    //     $data['status_aktif'] = $this->input->post('status_aktif') ? 1 : 0;
    //     $hasil = $this->db->insert('personil', $data);
    //     return $hasil;
    // }
    public function simpandata()
    {
        $data = $_POST;
        $data['status_aktif'] = $this->input->post('status_aktif') ? 1 : 0;
        $filefoto = $this->uploadLogo_awal();

        if ($filefoto) {
            $data['filefoto'] = $filefoto;
        }

        $hasil = $this->db->insert('personil', $data);
        return $hasil;
    }

    public function uploadLogo_awal()
    {
        $this->load->library('upload');
        $this->uploadConfig = array(
            'upload_path' => FCPATH . 'assets/image/dokper/',
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size' => max_upload() * 1024,
        );

        // Pastikan nama yang digunakan adalah filefoto, sesuai dengan nama di form
        $adaBerkas = $_FILES['filefoto']['name'];
        if (empty($adaBerkas)) {
            return 'kosong';
        }

        $uploadData = NULL;
        $this->upload->initialize($this->uploadConfig);
        if ($this->upload->do_upload('filefoto')) { // Ganti juga di sini
            $uploadData = $this->upload->data();
            $namaFileUnik = strtolower($uploadData['file_name']);
            $fileRenamed = rename(
                $this->uploadConfig['upload_path'] . $uploadData['file_name'],
                $this->uploadConfig['upload_path'] . $namaFileUnik
            );
            $uploadData['file_name'] = $fileRenamed ? $namaFileUnik : $uploadData['file_name'];
        } else {
            $_SESSION['success'] = -1;
            $ext = pathinfo($adaBerkas, PATHINFO_EXTENSION);
            $ukuran = $_FILES['filefoto']['size'] / 1000000;
            $tidakupload = $this->upload->display_errors(NULL, NULL);
            $this->session->set_flashdata('msg', $tidakupload . ' ' . $ext . ' ukuran ' . round($ukuran, 2) . ' MB');
        }

        return (!empty($uploadData)) ? $uploadData['file_name'] : NULL;
    }




    public function updatedata()
    {
        $data = $_POST;
        $data['status_aktif'] = $this->input->post('status_aktif') ? 1 : 0;
        $this->db->where('personil_id', $data['personil_id']);
        $hasil = $this->db->update('personil', $data);
        return $hasil;
    }


    public function updatefoto_baru()
    {
        $data = $_POST;
        $temp = $this->Personilmodel->getdatabyid($data['personil_id'])->row_array();
        $fotodulu = FCPATH . 'assets/image/dokper/' . $temp['filefoto'];
        $personil_id = $data['personil_id'];
        $data['filefoto'] = $this->uploadLogo();

        if ($data['filefoto'] != NULL) {
            if ($data['filefoto'] == 'kosong') {
                $data['filefoto'] = NULL;
            } else {
                if (file_exists($fotodulu)) {
                    unlink($fotodulu);
                }
            }
            $query = $this->db->query("UPDATE personil SET filefoto = '" . $data['filefoto'] . "' WHERE personil_id = '" . $personil_id . "' ");
            if ($query) {
                $this->session->set_userdata('foto', $data['filefoto']);
                $this->session->set_flashdata('simpanfoto', 'berhasil');
            }
        } else {
            $this->session->set_flashdata('ketlain', 'Error Upload Foto');
        }

        redirect(base_url() . 'personil/edit/' . $data['personil_id']);
    }


    public function uploadLogo()
    {

        $this->load->library('upload');
        $this->uploadConfig = array(
            'upload_path' => FCPATH . 'assets/image/dokper/',
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size' => max_upload() * 1024,
        );
        // Adakah berkas yang disertakan?
        $adaBerkas = $_FILES['file']['name'];
        if (empty($adaBerkas)) {
            return 'kosong';
        }
        $uploadData = NULL;
        $this->upload->initialize($this->uploadConfig);
        if ($this->upload->do_upload('file')) {
            $uploadData = $this->upload->data();
            $namaFileUnik = strtolower($uploadData['file_name']);
            $fileRenamed = rename(
                $this->uploadConfig['upload_path'] . $uploadData['file_name'],
                $this->uploadConfig['upload_path'] . $namaFileUnik
            );
            $uploadData['file_name'] = $fileRenamed ? $namaFileUnik : $uploadData['file_name'];
        } else {
            $_SESSION['success'] = -1;
            $ext = pathinfo($adaBerkas, PATHINFO_EXTENSION);
            $ukuran = $_FILES['file']['size'] / 1000000;
            $tidakupload = $this->upload->display_errors(NULL, NULL);
            $this->session->set_flashdata('msg', $tidakupload . ' ' . $ext . ' ukuran ' . round($ukuran, 2) . ' MB');
        }
        return (!empty($uploadData)) ? $uploadData['file_name'] : NULL;
    }

    public function getFilter()
    {
        $this->db->distinct();
        $this->db->select('dept.departemen, dept.urut');
        $this->db->from('dept');
        $this->db->join('personil', 'personil.bagian_id = dept.urut', 'left');
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function getdataByFilter($filter)
    {
        $this->db->select('personil.*, dept.departemen, grup.nama_grup, jabatan.nama_jabatan, tb_agama.nama_agama, tb_status.nama_status, tb_pendidikan.tingkat_pendidikan');
        $this->db->from('personil');
        $this->db->join('dept', 'dept.urut = personil.bagian_id', 'left');
        $this->db->join('jabatan', 'jabatan.id = personil.jabatan_id', 'left');
        $this->db->join('grup', 'grup.id = personil.grup_id', 'left');
        $this->db->join('tb_agama', 'tb_agama.id = personil.id_agama', 'left');
        $this->db->join('tb_status', 'tb_status.id = personil.id_status', 'left');
        $this->db->join('tb_pendidikan', 'tb_pendidikan.id = personil.id_pendidikan', 'left');

        $this->db->where('personil.bagian_id', $filter);

        return $this->db->get()->result_array();
    }
}
