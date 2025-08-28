<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Benang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('Benangmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->model('kategorimodel');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');




        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'transaksi';
        $data['benang'] = $this->Benangmodel->getdata();
        $data['rak'] = $this->Benangmodel->getRak();
        $kode = [
            'dept_id' => $this->session->userdata('deptsekarang') == null ? '' : $this->session->userdata('deptsekarang'),
            'dept_tuju' => $this->session->userdata('tujusekarang') == null ? '' : $this->session->userdata('tujusekarang'),
            'level' => $this->session->userdata('levelsekarang') == null ? '' : $this->session->userdata('levelsekarang'),
        ];
        $data['dept_tuju'] = $this->session->userdata('tujusekarang') == null ? '' : $this->session->userdata('tujusekarang');
        $data['data'] = $this->Benangmodel->getdata_filter($kode);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function getdatabenang()
    {
        $this->session->set_userdata('deptsekarang', $_POST['dept_id']);
        $this->session->set_userdata('tujusekarang', $_POST['dept_tuju']);
        $this->session->set_userdata('levelsekarang', $_POST['levelsekarang']);


        $url = base_url('benang');
        redirect($url);
    }
    public function ubahperiode()
    {
        $this->session->set_userdata('bl', $_POST['bl']);
        $this->session->set_userdata('th', $_POST['th']);
        echo 1;
    }
    public function tambahdata_header()
    {
        $data['dept_id'] = 'FN';
        $data['dept_tuju'] = $this->session->userdata('tujusekarang') == null ? '' : $this->session->userdata('tujusekarang');
        $this->load->view('benang/add', $data);
    }
    public function simpandata()
    {
        $tgl_input = date('Y-m-d');
        $data = [
            'dept_id' => $_POST['dept_id'],
            'dept_tuju' => $_POST['dept_tuju'],
            'tgl' => tglmysql($_POST['tgl']),
            'kode_dok' => 'BP',
            'id_perusahaan' => IDPERUSAHAAN,
            'nomor_dok' => nomor_dokumen($_POST['dept_id'], $_POST['dept_tuju'], 'tb_header', $this->db,  $tgl_input),
        ];

        $simpan = $this->Benangmodel->tambah_header($data);


        redirect('benang/datapermintaan/' . $simpan['id']);
    }

    public function editdata($id)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->Benangmodel->getdatabyid($id);
        $data['sublok'] = $this->helpermodel->getdatasublok()->result_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/mutasi', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function viewdetailpb($id)
    {
        $data['header'] = $this->Benangmodel->getdatabyid($id);
        $data['detail'] = $this->Benangmodel->getdatadetailpb($id);

        $this->load->view('benang/viewdetailpb', $data);
    }

    public function getdatadetailpb()
    {
        $kode = $_POST['id_header'];
        $data = $this->Benangmodel->getdatadetailpb($kode);
        $hasil = '';
        $no = 1;
        $jml = count($data);
        foreach ($data as $dt) {
            $hasil .= "<tr>";
            $hasil .= "<td>" . $dt['nama_barang'] . "</td>";
            $hasil .= "<td>" . $dt['kode'] . "</td>";
            $hasil .= "<td>" . $dt['namasatuan'] . "</td>";
            $hasil .= "<td class='text-center'>";
            // $hasil .= "<a href='#' id='editdetailpb' rel='" . $dt['id'] . "' class='btn btn-sm btn-primary mr-1' title='Edit data'><i class='fa fa-edit'></i></a>";
            $hasil .= "<a href='" . base_url() . 'benang/hapusdetailpb/' . $dt['id'] . "' class='btn btn-sm btn-danger' title='Hapus data'><i class='fa fa-trash-o'></i></a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
        }
        $cocok = array('datagroup' => $hasil, 'jmlrek' => $jml);
        echo json_encode($cocok);
    }
    public function editokpb($id)
    {
        $cek = $this->Benangmodel->cekfield($id, 'ok_valid', 0)->num_rows();
        if ($cek == 1) {
            $data = [
                'data_ok' => 0,
                'ok_valid' => 0,
                'tgl_ok' => null,
                'user_ok' => null,
                'id' => $id
            ];
            $simpan = $this->Benangmodel->validasipb($data);
        } else {
            $this->session->set_flashdata('pesanerror', 'Bon permintaan sudah divalidasi !');
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'benang';
            redirect($url);
        }
    }


    public function hapusdata($id)
    {
        $hasil = $this->Benangmodel->hapusdata($id);
        if ($hasil) {
            $url = base_url() . 'benang';
            redirect($url);
        }
    }

    public function simpanpb($id)
    {
        $data = [
            'data_ok' => 1,
            'tgl_ok' => date('Y-m-d H:i:s'),
            'user_ok' => $this->session->userdata('id'),
            'id' => $id
        ];
        $simpan = $this->Benangmodel->simpanpb($data);
        if ($simpan) {
            $url = base_url() . 'benang';
            redirect($url);
        }
    }

    public function hapusdetailpb($id)
    {
        $hasil = $this->Benangmodel->hapusdetailpb($id);
        if ($hasil) {
            $kode = $hasil['id'];
            $url = base_url() . 'benang/datapermintaan/' . $kode;
            redirect($url);
        }
    }


    public function datapermintaan($id)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->Benangmodel->getdataid_header($id);
        $data['satuan'] = $this->db->get('satuan')->result_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/mutasi', $data);
        $this->load->view('layouts/footer', $footer);
    }

    // END PERMINTAAN BENANG

    public function In($id)
    {
        $header['header'] = 'transaksi';

        $data['header'] = $this->Benangmodel->getdatabyid($id);
        $data['detail'] = $this->Benangmodel->getdatadetailpb($id);
        $data['saldo_terkini'] = $this->Benangmodel->getSaldo_Terkini($id);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();

        $this->load->view('layouts/header', $header);
        $this->load->view('benang/in', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function edit_in($id, $dept_id, $tgl)
    {
        $data['data'] = $this->Benangmodel->getdataid_in($id);
        $data['dept_id'] = $dept_id;
        $data['tgl'] = $tgl;
        $this->load->view('benang/edit_in', $data);
    }

    public function update_in()
    {
        $id = $this->input->post('id');
        $kgs = $this->input->post('kgs');
        $id_barang = $this->input->post('id_barang');
        $id_header = $this->input->post('id_header');
        $dept_id = $this->input->post('dept_id');
        $tanggal = $this->input->post('tgl');


        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = $bulan . $tahun;


        $this->db->select('kgs_akhir');
        $this->db->from('stokdept');
        $this->db->where('dept_id', $dept_id);
        $this->db->where('periode', $periode);
        $this->db->where('id_barang', $id_barang);
        $cek_saldo_sekarang = $this->db->get()->row_array();


        if (empty($cek_saldo_sekarang)) {
            $periode_sebelumnya = date('mY', strtotime("-1 month", strtotime($tanggal)));
            $this->db->select('kgs_akhir');
            $this->db->from('stokdept');
            $this->db->where('periode', $periode_sebelumnya);
            $this->db->where('id_barang', $id_barang);
            $cek_saldo_sekarang = $this->db->get()->row_array();
        }


        if (empty($cek_saldo_sekarang) || $cek_saldo_sekarang['kgs_akhir'] < $kgs) {
            $this->session->set_flashdata('message', '
                  <div class="alert alert-danger alert-dismissible" role="alert">
                      <div class="alert-icon">
                        <svg
                          xmlns="http://www.w3.org/2000/svg"
                          width="24"
                          height="24"
                          viewBox="0 0 24 24"
                          fill="none"
                          stroke="currentColor"
                          stroke-width="2"
                          stroke-linecap="round"
                          stroke-linejoin="round"
                          class="icon alert-icon icon-2"
                        >
                          <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
                          <path d="M12 8v4" />
                          <path d="M12 16h.01" />
                        </svg>
                      </div>
                      <div>
                        <h4 class="alert-heading">Tidak Bisa Transaksi Perhatikan Beberapa Hal:</h4>
                        <div class="alert-description">
                          <ul class="alert-list">
                            <li>Pastikan Saldo Ada</li>
                            <li>Pastikan Berat Transaksi Tidak Melebihi Berat Saldo Yang Tersedia </li>
                          </ul>
                        </div>
                      </div>
                      <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                    </div>
             ');
            redirect(base_url('benang/in/' . $id_header));
            return;
        }

        $data = [
            'id' => $id,
            'kgs' => $kgs,
        ];
        $hasil = $this->Benangmodel->updatedata_in($data);
        $this->helpermodel->isilog($this->db->last_query());

        if ($hasil) {
            $this->Benangmodel->Kgs_keluar($tanggal, $kgs, $id_barang, $dept_id);
        }

        redirect(base_url('benang/in/' . $id_header));
    }

    public function simpanData_Out()
    {
        $kode['id']   = $this->input->post('id');
        $id_header = $this->Benangmodel->tambahdataout($kode);

        if ($id_header) {
            echo json_encode(['status' => true, 'id' => $id_header]);
        } else {
            echo json_encode(['status' => false]);
        }
    }


    // MASTER BENANG

    public function master()
    {
        $header['header'] = 'transaksi';
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/master');
        $this->load->view('layouts/footer', $footer);
    }
    public function tambahdata_master()
    {
        $data['itemsatuan'] = $this->satuanmodel->getdata();
        $data['itemkategori'] = $this->kategorimodel->getdata();
        $data['kode'] = time();
        $this->load->view('benang/addmaster', $data);
    }

    public function simpan_master()
    {
        $kode        = $this->input->post('kode');
        $nama_barang = $this->input->post('nama_barang');
        $nama_alias  = $this->input->post('nama_alias');
        $id_satuan   = $this->input->post('id_satuan');
        $id_kategori = $this->input->post('id_kategori');
        $lokasi      = $this->input->post('lokasi_rak');
        $warna       = $this->input->post('warna');
        $this->db->trans_start();

        $this->db->insert('barang', [
            'kode'        => $kode,
            'nama_barang' => $nama_barang,
            'nama_alias'  => $nama_alias,
            'id_satuan'   => $id_satuan,
            'id_kategori' => $id_kategori,
            'act'         => 1,
        ]);

        $id_barang = $this->db->insert_id();

        $this->db->insert('master_benang', [
            'id_barang'  => $id_barang,
            'lokasi_rak' => $lokasi,
            'warna'      => $warna
        ]);

        $this->db->trans_complete();



        if ($this->db->trans_status() === FALSE) {
            $this->session->set_flashdata('error', 'Data gagal disimpan');
            redirect('benang/master');
        } else {
            $this->session->set_flashdata('success', 'Data berhasil disimpan');
            redirect('benang/master');
        }
    }


    public function filter_rak()
    {
        $rak     = $this->input->post('rak');
        $limit   = $this->input->post('length');
        $start   = $this->input->post('start');
        $draw    = $this->input->post('draw');
        $search  = $this->input->post('search')['value'];

        $this->session->set_userdata('filter_rak', $rak);


        $this->db->select('benang.*, barang.nama_barang');
        $this->db->from('benang');
        $this->db->join('barang', 'barang.id = benang.barang_id', 'left');
        $this->db->where('barang_id !=', 0);

        if ($rak !== 'all' && !empty($rak)) {
            $this->db->where('benang.lokasi', $rak);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('barang.nama_barang', $search);
            $this->db->group_end();
        }


        $count_query = clone $this->db;
        $recordsFiltered = $count_query->count_all_results();


        $this->db->order_by('benang.id', 'ASC');
        $this->db->limit($limit, $start);
        $data = $this->db->get()->result_array();


        $no = $start + 1;
        foreach ($data as &$row) {
            $row['no'] = $no++;
            $row['lokasi'] = $row['lokasi'];
            $row['spesifikasi'] = $row['nama_barang'];
            $row['aksi'] = '<a class="btn btn-sm btn-success btn-icon text-white" 
                     href="' . base_url('benang/transaksi_in/' . $row['id']) . '"
                     title="Transaksi Data">
                     Transaksi In
                 </a>
                 <a class="btn btn-sm btn-warning btn-icon text-white" 
                     href="' . base_url('benang/transaksi_out/' . $row['id']) . '"
                     title="Transaksi Data">
                     Transaksi Out
                 </a>
                 <a class="btn btn-sm btn-danger btn-icon text-white"
                     id="hapusnettype"
                     data-bs-toggle="modal"
                     data-bs-target="#modal-danger"
                     data-message="Akan menghapus data ini"
                     data-href="' . base_url('benang/hapus_spek/' . $row['id']) . '"
                     title="Hapus data">
                     <i class="fa fa-trash-o"></i>
                 </a>';
        }


        $this->db->from('benang');
        $this->db->where('barang_id !=', 0);
        $recordsTotal = $this->db->count_all_results();

        echo json_encode([
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }
    public function tambah_spek($id)
    {
        $data['id_header'] = $id;
        $data['satuan'] =  $this->db->get('satuan')->result_array();
        $this->load->view('benang/add_spek', $data);
    }
    public function spek_ukuran()
    {
        $inputan = $this->input->get('term');
        $result = $this->Benangmodel->getUkuranLike($inputan);
        echo json_encode($result);
    }
    public function spek_warna()
    {
        $warna = $this->input->get('warna');
        $result = $this->Benangmodel->getWarnaLike($warna);
        echo json_encode($result);
    }
    public function simpandata_spek()
    {
        $query = $this->Benangmodel->simpan_spek();
        if ($query) {
            $this->session->set_flashdata('message', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Event Berhasil Di Tambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        $this->helpermodel->isilog($this->db->last_query());
        redirect('benang');
    }
    public function simpandetail($id)
    {
        $query = $this->Benangmodel->simpandetail($id);
        if ($query) {
            $this->session->set_flashdata('message', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Event Berhasil Di Tambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        $this->helpermodel->isilog($this->db->last_query());
        redirect('benang/datapermintaan/' . $id);
    }
    public function get_detail($id)
    {
        $detail = $this->Benangmodel->getdataByid_all($id);
        echo json_encode($detail);
    }

    public function get_detail_warna($warna)
    {
        $detail = $this->Benangmodel->GetDetailWarna($warna);
        echo json_encode($detail);
    }

    public function detail_warna($warna)
    {
        $header['header'] = 'master';
        $data['warna'] = $warna;
        $data['detail_warna'] = $this->Benangmodel->GetDetailWarna($warna);
        $data['nomordok'] = $this->Benangmodel->GetNomorDok($warna);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/detail_warna', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function saldo_masuk($id, $id_barang,)
    {
        $header['header'] = 'master';
        $data['judul'] = 'PERIODE SALDO MASUK';
        $data['tb_detail_id'] = $id;
        $data['id_barang'] = $id_barang;
        $data['header'] = $this->Benangmodel->GetHeader_Saldo($id);
        $data['masuk'] = $this->Benangmodel->GetSaldo_masuk($id) ?? [];

        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/saldo_masuk', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function saldo_keluar($id, $id_barang,)
    {
        $header['header'] = 'master';
        $data['judul'] = 'PERIODE SALDO KELUAR';
        $data['header'] = $this->Benangmodel->GetHeader_Saldo($id);
        $data['tb_detail_id'] = $id;
        $data['id_barang'] = $id_barang;
        $data['keluar'] = $this->Benangmodel->GetSaldo_keluar($id) ?? [];

        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/saldo_keluar', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function view_saldo_masuk($bulan_tahun, $tb_detail_id, $id_barang)
    {
        $data['title'] = 'Saldo Masuk';
        $data['periode'] = $bulan_tahun;
        $data['tb_detail_id'] = $tb_detail_id;
        $data['id_barang'] = $id_barang;
        $data['saldo_masuk'] = $this->Benangmodel->GetViewsaldo($bulan_tahun, $tb_detail_id);
        $data['header'] = $this->Benangmodel->GetHeaderView($tb_detail_id);
        $this->load->view('benang/view_saldo_masuk', $data);
    }
    public function logbook($bulan_tahun, $tb_detail_id, $id_barang)
    {
        $data['title'] = 'View Data Logbook Saldo IN & OUT';
        $data['periode'] = $bulan_tahun;
        $data['id_barang'] = $id_barang;
        $data['saldo'] = $this->Benangmodel->Logbook($bulan_tahun, $id_barang);
        $data['header'] = $this->Benangmodel->GetHeaderView($tb_detail_id);
        $data['bulan_tahun'] = $bulan_tahun;
        $this->load->view('benang/logbook', $data);
    }

    public function view_saldo_keluar($bulan_tahun, $tb_detail_id, $id_barang)
    {
        $data['title'] = 'Saldo Keluar';
        $data['periode'] = $bulan_tahun;
        $data['tb_detail_id'] = $tb_detail_id;
        $data['id_barang'] = $id_barang;
        $data['saldo_keluar'] = $this->Benangmodel->GetViewsaldo_keluar($bulan_tahun, $tb_detail_id);
        $data['header'] = $this->Benangmodel->GetHeaderView($tb_detail_id);
        $this->load->view('benang/view_saldo_keluar', $data);
    }

    public function tambahsaldo($tb_detail_id, $id_barang)
    {
        $data['tb_detail_id'] = $tb_detail_id;
        $data['id_barang'] = $id_barang;
        $data['tgl_sekarang'] = date('Y-m-d');
        $data['jam_sekarang'] = date('H:i:s');
        $this->load->view('benang/add_saldo', $data);
    }
    public function tambahsaldo_keluar($tb_detail_id, $id_barang)
    {
        $data['tb_detail_id'] = $tb_detail_id;
        $data['id_barang'] = $id_barang;
        $data['tgl_sekarang'] = date('Y-m-d');
        $data['jam_sekarang'] = date('H:i:s');
        $this->load->view('benang/add_saldo_keluar', $data);
    }

    public function simpansaldo($tb_detail_id, $id_barang)
    {
        $tanggal = $this->input->post('tanggal');
        $jam = $this->input->post('jam');
        $tb_detail_id = $this->input->post('tb_detail_id');
        $id_barang = (int) $this->input->post('id_barang');
        $jumlah = (int) $this->input->post('jumlah');
        $keterangan = $this->input->post('keterangan');

        $data = [
            'tanggal' => $tanggal,
            'jam' => $jam,
            'tb_detail_id' => $tb_detail_id,
            'id_barang' => $id_barang,
            'jumlah' => $jumlah,
            'keterangan' => $keterangan
        ];

        $hasil = $this->db->insert('benang_in_mutasi', $data);

        if ($hasil) {
            $this->Benangmodel->InSaldo($tanggal, $jumlah, $id_barang);
            $url = base_url('benang/saldo_masuk/' . $tb_detail_id . '/' . $id_barang);
            redirect($url);
        }
    }


    public function simpansaldo_keluar($tb_detail_id, $id_barang)
    {
        $tanggal = $this->input->post('tanggal');
        $jam = $this->input->post('jam');
        $tb_detail_id = $this->input->post('tb_detail_id');
        $id_barang = (int) $this->input->post('id_barang');
        $jumlah = (int) $this->input->post('jumlah');
        $keterangan = $this->input->post('keterangan');

        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = $bulan . $tahun;

        // Saldo bulan sekarang
        $this->db->select('kgs_akhir');
        $this->db->from('stokdept');
        $this->db->where('periode', $periode);
        $this->db->where('id_barang', $id_barang);
        $cek_saldo_sekarang = $this->db->get()->row_array();

        // Kalau bulan ini belum ada saldo, cek saldo akhir bulan sebelumnya
        if (empty($cek_saldo_sekarang)) {
            $periode_sebelumnya = date('mY', strtotime("-1 month", strtotime($tanggal)));
            $this->db->select('kgs_akhir');
            $this->db->from('stokdept');
            $this->db->where('periode', $periode_sebelumnya);
            $this->db->where('id_barang', $id_barang);
            $cek_saldo_sekarang = $this->db->get()->row_array();
        }

        // Kalau setelah dicek tetap tidak ada saldo, berarti stok kosong
        if (empty($cek_saldo_sekarang) || $cek_saldo_sekarang['kgs_akhir'] < $jumlah) {
            $this->session->set_flashdata('message', '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Saldo Tersedia Tidak Cukup !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
            redirect(base_url('benang/saldo_keluar/' . $tb_detail_id . '/' . $id_barang));
            return;
        }

        // Simpan data
        $data = [
            'tanggal' => $tanggal,
            'jam' => $jam,
            'tb_detail_id' => $tb_detail_id,
            'id_barang' => $id_barang,
            'jumlah' => $jumlah,
            'keterangan' => $keterangan
        ];

        $hasil = $this->db->insert('benang_out_mutasi', $data);

        if ($hasil) {
            $this->Benangmodel->OutSaldo($tanggal, $jumlah, $id_barang);
        }

        redirect(base_url('benang/saldo_keluar/' . $tb_detail_id . '/' . $id_barang));
    }


    public function hapus_saldo_masuk($id, $tanggal, $jumlah, $tb_detail_id, $id_barang)
    {
        $hasil = $this->Benangmodel->hapus_histori_salmas($id);
        if ($hasil) {
            $this->Benangmodel->hapusSaldo_masuk($tanggal, $jumlah, $id_barang);
            redirect('benang/saldo_masuk/' . $tb_detail_id . '/' . $id_barang);
        }
    }

    public function hapus_saldo_keluar($id, $tanggal, $jumlah, $tb_detail_id, $id_barang)
    {
        $hasil = $this->Benangmodel->hapus_histori_salkel($id);
        if ($hasil) {
            $this->Benangmodel->hapusSaldo_keluar($tanggal, $jumlah, $id_barang);
            redirect('benang/saldo_keluar/' . $tb_detail_id . '/' . $id_barang);
        }
    }

    public function hapus_spek($id)
    {
        $hasil = $this->Benangmodel->hapus_spek($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('benang');
            redirect($url);
        }
    }
    public function hapus($id)
    {
        $hasil = $this->Benangmodel->hapus($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('benang');
            redirect($url);
        }
    }

    public function saldo_detail($id_header, $warna_benang)
    {
        $header['header'] = 'master';
        $data['title'] = 'Stok Benang Per Bulan';
        $data['header'] = $this->Benangmodel->GetHeaderView_saldo($id_header);
        $data['id_header'] = $id_header;
        $data['warna_benang'] = $warna_benang;
        $data['bln_sekarang'] = date('m');
        $data['thn_sekarang'] = date('Y');
        $data['bulan_options'] = $this->Benangmodel->getBulan();
        $data['tahun_options'] = $this->Benangmodel->getTahun();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/saldo_warna', $data);
        $this->load->view('layouts/footer', $footer);
    }


    public function filter_saldo()
    {
        $id_header     = $this->input->post('id_header');
        $warna_benang  = $this->input->post('warna_benang');
        $bulan         = $this->input->post('bulan');
        $tahun         = $this->input->post('tahun');

        $this->db->select('
        tb_detail.warna_benang, 
        tb_detail.id_header, 
        stokdept.kgs_akhir,
        stokdept.id_barang, 
        stokdept.periode, 
        barang.nama_barang
    ');
        $this->db->from('tb_detail');
        $this->db->join('stokdept', 'stokdept.id_barang = tb_detail.id_barang', 'left');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'barang.id = stokdept.id_barang', 'left');

        if (!empty($id_header)) {
            $this->db->where('tb_header.id', $id_header);
        }
        if (!empty($warna_benang)) {
            $this->db->where('tb_detail.warna_benang', $warna_benang);
        }
        if (!empty($bulan)) {
            $this->db->where("LEFT(stokdept.periode, 2) =", $bulan, FALSE);
        }
        if (!empty($tahun)) {
            $this->db->where("RIGHT(stokdept.periode, 4) =", $tahun, FALSE);
        }


        $this->db->order_by('tb_detail.warna_benang', 'ASC');
        $data = $this->db->get()->result_array();


        $html = '';
        $no = 1;
        $total = 0;

        if (!empty($data)) {
            foreach ($data as $row) {
                $total += $row['kgs_akhir'];
                $html .= '<tr>';
                $html .= '<td>' . $no++ . '</td>';
                $html .= '<td>' . $row['warna_benang'] . '</td>';
                $html .= '<td>' . $row['nama_barang'] . '</td>';
                $html .= '<td>' . number_format($row['kgs_akhir'], 2) . '</td>';
                $html .= '<td>' . format_bulan_tahun($row['periode']) . '</td>';
                $html .= '</tr>';
            }


            $html .= '<tr style="background-color: #f0f0f0; font-weight: bold;">';
            $html .= "<td colspan='3' class='text-center'>Total</td>";
            $html .= "<td>" . number_format($total, 2) . "</td>";
            $html .= "<td></td>";
            $html .= '</tr>';
        } else {
            $html .= '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>';
        }


        echo $html;
    }

    public function speck()
    {
        $inputan = $this->input->get('term');
        $result = $this->Benangmodel->getBenangLike($inputan);
        echo json_encode($result);
    }
}
