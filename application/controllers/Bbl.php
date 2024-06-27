<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bbl extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('bbl_model');
        $this->load->model('pb_model');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel', 'usermodel');

        $this->load->library('Pdf');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'transaksi';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdept_bbl($this->session->userdata('arrdep'));
        $data['dept_bbl'] = $this->deptmodel->getdata_dept_bbl();
        $kode = [
            'dept_id' => $this->session->userdata('deptsekarang') == null ? '' : $this->session->userdata('deptsekarang'),
            'dept_tuju' => $this->session->userdata('tujusekarang') == null ? '' : $this->session->userdata('tujusekarang'),
        ];
        $data['data'] = $this->bbl_model->getdatabbl($kode);
        $footer['fungsi'] = 'bbl';
        $this->load->view('layouts/header', $header);
        $this->load->view('bbl/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function tambahdata()
    {
        $this->load->view('bbl/add_bbl');
    }

    public function tambahbbl()
    {
        $data = [
            'dept_id' => $_POST['dept_id'],
            'dept_tuju' => $_POST['dept_tuju'],
            'tgl' => tglmysql($_POST['tgl']),
            'kode_dok' => 'BBL',
            'id_perusahaan' => IDPERUSAHAAN,
            'nomor_dok' => nomorbbl(tglmysql($_POST['tgl']), $_POST['dept_id'], $_POST['dept_tuju'])
        ];
        $simpan = $this->bbl_model->tambah_bbl($data);
        $this->session->set_userdata('selected_dept', $_POST['dept_id']);
        echo $simpan['id'];
    }

    public function databbl($id)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->bbl_model->getdatabyid($id);
        $this->session->set_userdata('data_databbl', $data['data']);
        $data['satuan'] = $this->satuanmodel->getdata()->result_array();
        $data['barang'] = $this->db->get('barang')->result_array();
        $data['detail'] = $this->bbl_model->getdatadetail_bbl($id);
        $footer['fungsi'] = 'bbl';
        $this->load->view('layouts/header', $header);
        $this->load->view('bbl/databbl', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function edittgl()
    {
        $this->load->view('bbl/edit_tgl');
    }

    public function addspecbarang()
    {
        $data['hakdep'] = $this->deptmodel->gethakdept_bbl($this->session->userdata('arrdep'));
        $this->load->view('bbl/addspecbarang', $data);
    }



    public function getspecbarang()
    {
        $data['data'] = $this->session->userdata('data_databbl');
        $nomor_dok = $this->input->post('data');
        $dept_id = $this->input->post('dept_id') ?: $this->session->userdata('selected_dept');
        $html = '';
        $query = $this->bbl_model->getspecbarang($nomor_dok, $dept_id);

        $grouping_data = [];
        foreach ($query as $item) {
            $id_header = $item['id_header'];
            if (!isset($grouping_data[$id_header])) {
                $grouping_data[$id_header] = $item;
            }
        }
        foreach ($grouping_data as $item) {
            $html .= "<tr>";
            $html .= "<td>{$item['id_header']}</td>";
            $html .= "<td>{$item['nomor_dok']}</td>";
            $html .= "<td>{$item['keterangan']}</td>";
            $html .= "<td>{$item['jumlah_barang']} item</td>";
            $html .= "<td>";
            $html .= '<form action="' . base_url('bbl/pilih_barang') . '" method="post">';
            $html .= '<input type="hidden" name="id_header" value="' . $item['id_header'] . '">';
            $html .= '<input type="hidden" name="id_header_session" value="' . (isset($data['data']['id']) ? $data['data']['id'] : '') . '">';
            $html .= '<button type="submit" class="btn btn-sm btn-success">Pilih</button>';
            $html .= '</form>';
            $html .= "</td>";
            $html .= "</tr>";
        }

        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }



    public function pilih_barang()
    {
        $id_header = $this->input->post('id_header');
        $id_header_session = $this->input->post('id_header_session');
        $data_barang = $this->bbl_model->getdata_byid($id_header);
        $url = base_url() . 'bbl/databbl/';

        if ($data_barang) {
            foreach ($data_barang as &$item) {
                $item['id_header'] = $id_header_session;
                unset($item['id']);
            }

            $insert_data = $this->bbl_model->simpandetailbarang($data_barang);

            if ($insert_data) {
                foreach ($insert_data as $item) {
                    $this->bbl_model->update_id_bbl($id_header, $item['id']);
                }
                redirect($url . $id_header_session);
            } else {
                $this->session->set_flashdata('message', 'Gagal menyimpan data');
                redirect($url . $id_header);
            }
        } else {
            $this->session->set_flashdata('message', 'Data sudah jadi BBL');
            redirect($url . $id_header);
        }
    }


    public function edit($id)
    {
        $data['data'] = $this->bbl_model->get_detail($id);

        $data['detail'] = $this->bbl_model->getdatadetail_bbl($id);
        $this->load->view('bbl/edit_detail', $data);
    }
    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'id_barang' => $_POST['id_barang'],
            'id_satuan' => $_POST['id_satuan'],
            'pcs' => $_POST['pcs'],
            'keterangan' => $_POST['keterangan']
        ];
        $hasil = $this->bbl_model->updatedata($data);
        echo $hasil;
    }

    public function hapus($id)
    {
        $hasil = $this->bbl_model->hapus($id);
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'bbl/databbl/' . $kode;
            redirect($url);
        }
    }

    public function simpanbbl($id)
    {
        $data = [
            'data_ok' => 1,
            'tgl_ok' => date('Y-m-d H:i:s'),
            'user_ok' => $this->session->userdata('id'),
            'id' => $id
        ];

        $simpan = $this->bbl_model->simpanbbl($data);

        if ($simpan) {
            $url = base_url() . 'bbl';
            redirect($url);
        }
    }

    public function viewdetail_bbl($id)
    {
        $data['header'] = $this->bbl_model->getdatabyid($id);
        $data['detail'] = $this->bbl_model->getdatadetail_bbl($id);
        $this->load->view('bbl/viewdetail_bbl', $data);
    }
    public function editdetail_bbl($id)
    {
        $data['header'] = $this->bbl_model->getdatabyid($id);
        $data['detail'] = $this->bbl_model->getdatadetail_bbl($id);
        $this->load->view('bbl/editdetail_bbl', $data);
    }

    public function editone_detail($id)
    {
        $data['data'] = $this->bbl_model->get_detail($id);
        $data['satuan'] = $this->satuanmodel->getdata()->result_array();
        $data['barang'] = $this->db->get('barang')->result_array();
        $data['detail'] = $this->bbl_model->getdatadetail_bbl($id);
        $this->load->view('bbl/editone_detail', $data);
    }

    public function update_detail()
    {
        $data = [
            'id' => $_POST['id'],
            'pcs' => $_POST['pcs'],
            'kgs' => $_POST['kgs'],
            'keterangan' => $_POST['keterangan']
        ];
        $hasil = $this->bbl_model->updatedata_detail($data);
        echo $hasil;
    }

    public function hapusone_detail($id)
    {
        $hasil = $this->bbl_model->hapusone_detail($id);
        if ($hasil) {
            $url = base_url('bbl');
            redirect($url);
        }
    }

    public function hapus_detail($id)
    {
        $hasil = $this->bbl_model->hapus_data($id);
        if ($hasil) {
            $url = base_url('bbl');
            redirect($url);
        }
    }
}
