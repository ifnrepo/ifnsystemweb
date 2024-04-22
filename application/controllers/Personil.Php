<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Personil extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('Personilmodel');
        $this->load->library('upload');
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['personil'] = $this->Personilmodel->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('personil/index', $data);
        $this->load->view('layouts/footer');
    }


    public function tambahdata()

    {
        $header['header'] = 'master';
        $data['action'] = base_url() . 'personil/simpandata';
        $footer['fungsi'] = 'personil';
        $this->load->view('layouts/header', $header);
        $this->load->view('personil/add', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function simpandata()
    {

        $query = $this->Personilmodel->simpandata();
        if ($query) {
            $url = base_url('personil');
            redirect($url);
        }
    }

    public function edit($personil_id)
    {
        $header['header'] = 'master';
        $data['action'] = base_url() . 'personil/updatedata';
        $data['personil'] = $this->Personilmodel->getdatabyid($personil_id);
        $footer['fungsi'] = 'personil';
        $this->load->view('layouts/header', $header);
        $this->load->view('personil/edit', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function update_foto($personil_id)
    {

        if (empty($_FILES['foto_personil']['name'])) {
            echo "Mohon pilih file foto terlebih dahulu.";
            return;
        }

        $data['foto_personil'] = '';
        $foto_personil = $_FILES['foto_personil']['name'];

        // Konfigurasi 
        $config['upload_path']   = FCPATH . '/assets/image/personil';
        $config['allowed_types'] = 'gif|jpg|png|jpeg';
        $config['file_name']            = uniqid();
        $config['overwrite']            = true;
        $config['max_size']             = 1024;
        $config['max_width']            = 1080;
        $config['max_height']           = 1080;

        $this->load->library('upload', $config);

        // Melakukan upload file
        if (!$this->upload->do_upload('foto_personil')) {
            echo "gagal";
            $error = $this->upload->display_errors();
            echo $error;
        } else {
            $foto_personil = $this->upload->data('file_name');
            $data['foto_personil'] = $foto_personil;


            $this->db->where('personil_id', $personil_id);
            $this->db->update('personil', $data);

            redirect('personil/edit/' . $personil_id);
        }
    }



    public function delete_foto($personil_id)
    {
        $personil = $this->db->where('personil_id', $personil_id)->get('personil')->row();
        $foto_personil = $personil->foto_personil;

        // Hapus file foto 
        $foto_path = FCPATH . '/assets/image/personil/' . $foto_personil;
        if (file_exists($foto_path)) {
            unlink($foto_path);
        }
        $this->db->where('personil_id', $personil_id)->update('personil', array('foto_personil' => NULL));
        redirect('personil/edit/' . $personil_id);
    }


    public function updatedata()
    {
        $query = $this->Personilmodel->updatedata();
        if ($query) {
            $url = base_url('personil');
            redirect($url);
        }
    }
    public function hapusdata($personil_id)
    {
        $hasil = $this->Personilmodel->hapus($personil_id);
        if ($hasil) {
            $url = base_url('personil');
            redirect($url);
        }
    }

    public function view($personil_id)
    {
        $data['personil'] = $this->Personilmodel->getdatabyid($personil_id);
        $this->load->view('personil/view', $data);
    }
}
