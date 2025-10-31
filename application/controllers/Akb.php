<?php
defined('BASEPATH') or exit('No direct script access allowed');

require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Akb extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('akb_model', 'akbmodel');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('supplier_model', 'suppliermodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('mtuangmodel');
        $this->load->model('Ib_model', 'ibmodel');
        $this->load->model('Inv_model', 'invmodel');
        $this->load->model('kontrak_model', 'kontrakmodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'transaksi';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->getdeptkirim();
        $data['dephak'] = $this->deptmodel->getdata();
        $data['depbbl'] = $this->deptmodel->getdata_dept_bbl(1);
        $data['databc'] = $this->akbmodel->getBc();

        $kode = $this->session->userdata('deptdari');
        $bc = $this->session->userdata('jbc');

        // var_dump($bc);
        // die();


        $data['data'] = $this->akbmodel->getdata($kode, $bc);
        $data['jumlahrek'] = $this->akbmodel->getjumlahdata($kode, $bc);
        $data['datatoken'] = $this->akbmodel->gettokenbc()->row_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'akb';
        $this->load->view('layouts/header', $header);
        $this->load->view('akb/akb', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->set_userdata('bl', (int)date('m'));
        $this->session->set_userdata('th', date('Y'));
        $this->session->unset_userdata('deptdari');
        $url = base_url() . 'akb';
        redirect($url);
    }
    public function ubahperiode()
    {
        $this->session->set_userdata('bl', $_POST['bl']);
        $this->session->set_userdata('th', $_POST['th']);
        echo 1;
    }
    public function getdataakb()
    {
        $this->session->set_userdata('deptdari', $_POST['dept']);
        $this->session->set_userdata('jbc', $_POST['bc']);
        echo 1;
    }
    public function tambahdataib()
    {
        if ($this->session->userdata('depttuju') != null) {
            $kode = $this->ibmodel->tambahdataib();
            if ($kode) {
                $url = base_url() . 'ib/dataib/' . $kode;
                redirect($url);
            }
        } else {
            $this->session->set_flashdata('errorsimpan', 1);
            $url = base_url() . 'ib';
            redirect($url);
        }
    }
    public function cekbc()
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->ibmodel->getdatacekbc();
        $data['mtuang'] = $this->mtuangmodel->getdata();
        $data['jnsbc'] = $this->ibmodel->getdokbcmasuk();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ib';
        $this->load->view('layouts/header', $header);
        $this->load->view('ib/datacekbc', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function hapusib($id)
    {
        $query = $this->akbmodel->hapusib($id);
        if ($query) {
            $url = base_url() . 'akb';
            redirect($url);
        }
    }

    public function viewdetail($id, $mode = 0)
    {
        $data['mode'] = $mode;
        $data['header'] = $this->akbmodel->getdatabyid($id, $mode);
        $data['detail'] = $this->akbmodel->getdatadetailib($id, $mode, $data['header']['urutakb']);
        $data['lampiran'] = $this->akbmodel->getdatalampiran($id);
        $this->load->view('akb/viewdetailakb', $data);
    }

    public function dataib($kode)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->ibmodel->getdatabyid($kode);
        $data['mtuang'] = $this->mtuangmodel->getdata();
        $data['jnsbc'] = $this->ibmodel->getdokbcmasuk();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ib';
        $this->load->view('layouts/header', $header);
        $this->load->view('ib/dataib', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function updatebykolom($kolom)
    {
        $data = [
            'id' => $_POST['id'],
            $kolom => $_POST['isinya']
        ];
        $hasil = $this->ibmodel->updatebykolom($data);
        echo $hasil;
    }
    public function updatekolom($kolom)
    {
        $data = [
            'id_header' => $_POST['id'],
            $kolom => $_POST['isinya']
        ];
        $hasil = $this->ibmodel->updatekolom($_POST['tbl'], $data, 'id');
        echo $hasil;
    }
    public function updateib()
    {
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            // 'keterangan' => $_POST['ket'],
            'id' => $_POST['id']
        ];
        $simpan = $this->ibmodel->updateib($data);
        echo $simpan;
    }
    public function getbarangib($sup = '')
    {
        if ($sup == '') {
            $data['datadetail'] = $this->ibmodel->getbarangibl();
            $this->load->view('ib/getbarangibl', $data);
        } else {
            $data['header'] = $this->suppliermodel->getdatabyid($sup);
            $data['datadetail'] = $this->ibmodel->getbarangib($sup);
            $this->load->view('ib/getbarangib', $data);
        }
    }
    public function editsupplier()
    {
        $this->load->view('ib/editsupplier');
    }
    public function edittgl()
    {
        $this->load->view('ib/edit_tgl');
    }
    public function adddetailib()
    {
        $id = $_POST['id'];
        $brg = $_POST['brg'];
        $data = [
            'id' => $id,
            'data' => $brg
        ];
        $simpan = $this->ibmodel->adddetailib($data);
        echo $simpan;
    }
    public function getdatadetailib()
    {
        $hasil = '';
        $id = $_POST['id_header'];
        $query = $this->ibmodel->getdatadetailib($id);
        $header = $this->ibmodel->getdatabyid($id);
        $totalharga = 0;
        $no = 0;
        foreach ($query as $que) {
            $no++;
            $tampil = $que['pcs'] == 0 ? $que['kgs'] : $que['pcs'];
            $tampil2 = $que['pcsmintaa'] == 0 ? $que['kgsmintaa'] : $que['pcsmintaa'];
            $hasil .= "<tr>";
            $hasil .= "<td>" . $no . "</td>";
            $hasil .= "<td>" . $que['nama_barang'] . "</td>";
            $hasil .= "<td>" . $que['brg_id'] . "</td>";
            $hasil .= "<td>" . $que['namasatuan'] . "</td>";
            $hasil .= "<td>" . rupiah($tampil2, 0) . "</td>";
            $hasil .= "<td>" . rupiah($tampil, 0) . "</td>";
            if ($header['jn_ib'] == 1) {
                $hasil .= "<td>" . rupiah($que['harga'], 2) . "</td>";
            }
            $hasil .= "<td>";
            $hasil .= "<a href=" . base_url() . 'ib/editdetailib/' . $que['id'] . " class='btn btn-sm btn-primary mr-1' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Ubah data Detail'>Ubah</a>";
            $hasil .= "<a href='#' data-href=" . base_url() . 'ib/hapusdetailib/' . $que['id'] . '/' . $que['id_header'] . " class='btn btn-sm btn-danger' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-message='Akan menghapus data ini ' data-bs-target='#modal-danger' data-title='Ubah data Detail'>Hapus</a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
            $totalharga += $que['harga'] * $tampil;
        }
        $cocok = array('datagroup' => $hasil, 'totalharga' => $totalharga, 'jmlrek' => $no);
        echo json_encode($cocok);
    }
    public function hapusdetailib($id, $detid)
    {
        $hasil = $this->ibmodel->hapusdetailib($id);
        if ($hasil) {
            $url = base_url() . 'ib/dataib/' . $detid;
            redirect($url);
        }
    }
    public function editdetailib($id)
    {
        $data['data'] = $this->ibmodel->getdetailibbyid($id);
        $data['header'] = $this->ibmodel->getdatabyid($id);
        $this->load->view('ib/editdetailib', $data);
    }
    public function updatepcskgs()
    {
        $kondisi = [
            'id' => $_POST['id'],
            'pcs' => $_POST['pcs'],
            'kgs' => $_POST['kgs'],
            'harga' => $_POST['hrg'],
        ];
        $hasil = $this->ibmodel->updatepcskgs($kondisi);
        echo $hasil;
    }
    public function simpanib($id)
    {
        $cekdetail = $this->ibmodel->cekdetail($id);
        if ($cekdetail['xharga'] == 0 && $cekdetail['xkgs'] == 0) {
            $data = [
                'user_ok' => $this->session->userdata('id'),
                'data_ok' => 1,
                'tgl_ok' => date('Y-m-d H:i:s'),
                'id' => $id,
                'totalharga' => $cekdetail['totalharga'],
                'total' => 'totalharga - diskon',
                'jumlah' => '((totalharga-diskon)+ppn)-pph',
                'bruto' => $cekdetail['kgs']
            ];
            $query = $this->ibmodel->simpanib($data);
            if ($query) {
                $url = base_url() . 'ib';
                redirect($url);
            }
        } else {
            $this->session->set_flashdata('errorsimpan', 4);
            $url = base_url() . 'ib/dataib/' . $id;
            redirect($url);
        }
    }
    public function editib($id)
    {
        $cek = $this->ibmodel->cekfield($id, 'ok_tuju', 0)->num_rows();
        if ($cek == 1) {
            $data = [
                'data_ok' => 0,
                'user_ok' => null,
                'tgl_ok' => null,
                'id' => $id
            ];
            $hasil = $this->ibmodel->editib($data);
            if ($hasil) {
                $url = base_url() . 'ib';
                redirect($url);
            } else {
                $this->session->set_flashdata('errorsimpan', 3);
                $url = base_url() . 'ib';
                redirect($url);
            }
        } else {
            $this->session->set_flashdata('errorsimpan', 2);
            $url = base_url() . 'ib';
            redirect($url);
        }
    }
    public function cekhargabarang()
    {
        $id  = $_POST['id'];
        $hasil = $this->ibmodel->cekhargabarang($id);
        echo $hasil;
    }
    public function getnamasubkon($kode = 0)
    {
        $data['datasubkon'] = daftardeptsubkon();
        $this->load->view('akb/getnamasubkon', $data);
    }
    public function getbongaichu($id, $kode = 0)
    {
        // $data['databongaichu'] = $this->akbmodel->getbongaichu($id);
        $data['idheader'] = $id;
        $this->load->view('akb/getbongaichu', $data);
    }
    public function getdokumenakb()
    {
        $id = $_POST['id'];
        $asal = $_POST['asal'];
        $hasil = $this->akbmodel->getbongaichu($id, $asal);
        $html = '';
        if ($hasil->num_rows() > 0) {
            $no = 0;
            foreach ($hasil->result_array() as $hasil) {
                $no++;
                $html .= "<tr>";
                $html .= "<td>" . $no . "</td>";
                $html .= "<td class='text-blue font-bold'>" . $hasil['nomor_dok'] . "</td>";
                $html .= "<td>" . $hasil['tgl'] . "</td>";
                $html .= "<td>" . $hasil['ket'] . "</td>";
                $html .= "<td class='text-right'>" . rupiah($hasil['pcs'], 0) . "</td>";
                $html .= "<td class='text-right'>" . rupiah($hasil['kgs'], 2) . "</td>";
                $html .= "<td class='text-center'>";
                $html .= "<label class='form-check m-0'>";
                $html .= "<input class='form-check-input' name='cekpilihbarang' id='cekbok" . $no . "' rel='" . $hasil['id'] . "' type='checkbox' title='" . $hasil['id'] . "' >";
                $html .= "<span class='form-check-label'></span></label>";
                $html .= "</td>";
                $html .= "</tr>";
            }
        } else {
            $html .= '<tr>';
            $html .= "<td colspan='7' class='text-center'>Data yang dicari tidak ditemukan !</td>";
            $html .= '</tr>';
        }
        $cocok = array('datagroup' => $html, 'id' => $id);
        echo json_encode($cocok);
    }
    public function tambahajusubkon()
    {
        $kodesubkon = $_POST['id'];
        $hasil = $this->akbmodel->tambahajusubkon($kodesubkon);
        echo $hasil;
    }
    public function tambahbongaichu()
    {
        $arrgo = [
            'id' => $_POST['id'],
            'data' => $_POST['out']
        ];
        $kode = $this->akbmodel->tambahbongaichu($arrgo);
        echo $kode;
    }
    public function hapusaju($id, $mode = 0)
    {
        $hasil = $this->akbmodel->hapusaju($id, $mode);
        if ($hasil) {
            $url = base_url() . 'akb';
            redirect($url);
        }
    }
    public function viewbc($id)
    {
        $data['header'] = $this->ibmodel->getdatadetailib($id);
        $data['datheader'] = $id;
        $this->load->view('ib/viewbc', $data);
    }
    public function simpandatabc()
    {
        $data = $_POST['mode'];
        $head = $_POST['head'];
        $hasil = $this->ibmodel->simpandatabc($data, $head);
        echo $hasil;
    }
    public function isidokbc($id, $mode = 0)
    {
        $header['header'] = 'transaksi';
        $data['mode'] = $mode;
        $data['datheader'] = $this->akbmodel->getdatabyid($id);
        $data['header'] = $this->akbmodel->getdatadetailib($id, $mode, $data['datheader']['urutakb']);
        $data['bckeluar'] = $this->akbmodel->getbckeluar();
        $data['jnsangkutan'] = $this->akbmodel->getjnsangkutan();
        $data['refkemas'] = $this->akbmodel->refkemas();
        $data['refmtuang'] = $this->akbmodel->refmtuang();
        $data['refincoterm'] = $this->akbmodel->refincoterm();
        $data['refbendera'] = $this->akbmodel->refbendera();
        $data['refpelabuhan'] = $this->ibmodel->refpelabuhan();
        $data['datatoken'] = $this->akbmodel->gettokenbc()->row_array();
        if ($mode == 1) {
            $data['detbombc'] = $this->akbmodel->getdetbom($id);
            // $data['detbombc'] = [];
        } else {
            $data['detbombc'] = $this->akbmodel->getdetbom($id);
        }
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ibx';
        $this->load->view('layouts/header', $header);
        $this->load->view('akb/isidokbc', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function simpandatanobc()
    {
        $hasil = $this->ibmodel->simpandatanobc();
        echo $hasil;
    }
    public function ceisa40excel($id)
    {
        $spreadsheet = new Spreadsheet();
        $array = [
            'HEADER',
            'ENTITAS',
            'DOKUMEN',
            'PENGANGKUT', 'KEMASAN', 'KONTAINER', 'BARANG', 'BARANGTARIF', 'BARANGDOKUMEN', 'BARANGENTITAS', 'BARANGSPEKKHUSUS', 'BARANGVD',
            'BAHANBAKU', 'BAHANBAKUTARIF', 'BAHANBAKUDOKUMEN', 'PUNGUTAN', 'JAMINAN', 'BANKDEVISA', 'VERSI'
        ];

        $no = 0;
        for ($i = 0; $i < count($array); $i++) {
            $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $array[$i]);
            $spreadsheet->addSheet($myWorkSheet);
            $no++;
        }
        for ($z = 0; $z < count($array); $z++) {
            $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    
            $sheet = $spreadsheet->getSheetByName($array[$z]);
            // 65
            $arrayheader = [
                'NOMOR AJU', 'KODE DOKUMEN', 'KODE KANTOR', 'KODE KANTOR BONGKAR', 'KODE KANTOR PERIKSA', 'KODE KANTOR TUJUAN',
                'KODE KANTOR EKSPOR', 'KODE JENIS IMPOR', 'KODE JENIS EKSPOR', 'KODE JENIS TPB', 'KODE JENIS PLB', 'KODE JENIS PROSEDUR',
                'KODE TUJUAN PEMASUKAN', 'KODE TUJUAN PENGIRIMAN', 'KODE TUJUAN TPB', 'KODE CARA DAGANG', 'KODE CARA BAYAR', 'KODE CARA BAYAR LAINNYA',
                'KODE GUDANG ASAL', 'KODE GUDANG TUJUAN', 'KODE JENIS KIRIM', 'KODE JENIS PENGIRIMAN', 'KODE KATEGORI EKSPOR', 'KODE KATEGORI MASUK FTZ',
                'KODE KATEGORI KELUAR FTZ', 'KODE KATEGORI BARANG FTZ', 'KODE LOKASI', 'KODE LOKASI BAYAR', 'LOKASI ASAL', 'LOKASI TUJUAN', 'KODE DAERAH ASAL',
                'KODE GUDANG ASAL', 'KODE GUDANG TUJUAN', 'KODE NEGARA TUJUAN', 'KODE TUTUP PU', 'NOMOR BC11', 'TANGGAL BC11', 'NOMOR POS', 'NOMOR SUB POS',
                'KODE PELABUHAN BONGKAR', 'KODE PELABUHAN MUAT', 'KODE PELABUHAN MUAT AKHIR', 'KODE PELABUHAN TRANSIT', 'KODE PELABUHAN TUJUAN', 'KODE PELABUHAN EKSPOR',
                'KODE TPS', 'TANGGAL BERANGKAT', 'TANGGAL EKSPOR', 'TANGGAL MASUK', 'TANGGAL MUAT', 'TANGGAL TIBA', 'TANGGAL PERIKSA', 'TEMPAT STUFFING',
                'TANGGAL STUFFING', 'KODE TANDA PENGAMAN', 'JUMLAH TANDA PENGAMAN', 'FLAG CURAH', 'FLAG SDA', 'FLAG VD', 'FLAG AP BK', 'FLAG MIGAS', 'KODE ASURANSI',
                'ASURANSI', 'NILAI BARANG', 'NILAI INCOTERM', 'NILAI MAKLON', 'ASURANSI', 'FREIGHT', 'FOB', 'BIAYA TAMBAHAN', 'BIAYA PENGURANG', 'VD', 'CIF', 'HARGA_PENYERAHAN',
                'NDPBM', 'TOTAL DANA SAWIT', 'DASAR PENGENAAN PAJAK', 'NILAI JASA', 'UANG MUKA', 'BRUTO', 'NETTO', 'VOLUME', 'KOTA PERNYATAAN', 'TANGGAL PERNYATAAN',
                'NAMA PERNYATAAN', 'JABATAN PERNYATAAN', 'KODE VALUTA', 'KODE INCOTERM', 'KODE JASA KENA PAJAK', 'NOMOR BUKTI BAYAR', 'TANGGAL BUKTI BAYAR', 'KODE JENIS NILAI',
                'KODE KANTOR MUAT', 'NOMOR DAFTAR', 'TANGGAL DAFTAR', 'KODE ASAL BARANG FTZ', 'KODE TUJUAN PENGELUARAN', 'PPN PAJAK', 'PPNBM PAJAK',
                'TARIF PPN PAJAK', 'TARIF PPNBM PAJAK', 'BARANG TIDAK BERWUJUD', 'KODE JENIS PENGELUARAN'
            ];
            $arrayentitas = [
                'NOMOR AJU', 'SERI', 'KODE ENTITAS', 'KODE JENIS IDENTITAS', 'NOMOR IDENTITAS', 'NAMA ENTITAS', 'ALAMAT ENTITAS', 'NIB ENTITAS', 'KODE JENIS API',
                'KODE STATUS', 'NOMOR UIN ENTITAS', 'TANGGAL UIN ENTITAS', 'KODE NEGARA', 'NIPER ENTITAS'
            ];
            $arraydokumen = [
                'NOMOR AJU', 'SERI', 'KODE DOKUMEN', 'NOMOR DOKUMEN', 'TANGGAL DOKUMEN', 'KODE FASILITAS', 'KODE UIN'
            ];
            $arraypengangkut = [
                'NOMOR AJU', 'SERI', 'KODE CARA ANGKUT', 'NAMA PENGANGKUT', 'NOMOR PENGANGKUT', 'KODE NEGARA', 'CALL SIGN', 'FLAG ANGKUT PLB'
            ];
            $arraykemasan = [
                'NOMOR AJU', 'SERI', 'KODE KEMASAN', 'JUMLAH KEMASAN', 'MERK'
            ];
            $arraykontainer = [
                'NOMOR AJU', 'SERI', 'NOMOR KONTAINER', 'KODE UKURAN KONTAINER', 'KODE JENIS KONTAINER', 'KODE TIPE KONTAINER'
            ];
            $arraybarang = [
                'NOMOR AJU', 'SERI BARANG', 'HS', 'KODE BARANG', 'URAIAN', 'MEREK', 'TIPE', 'UKURAN', 'SPESIFIKASI LAIN', 'KODE SATUAN', 'JUMLAH SATUAN',
                'KODE KEMASAN', 'JUMLAH KEMASAN', 'KODE DOKUMEN ASAL', 'KODE KANTOR ASAL', 'NOMOR DAFTAR ASAL', 'TANGGAL DAFTAR ASAL', 'NOMOR AJU ASAL',
                'SERI BARANG ASAL', 'NETTO', 'BRUTO', 'VOLUME', 'SALDO AWAL', 'SALDO AKHIR', 'JUMLAH REALISASI', 'CIF', 'CIF RUPIAH', 'NDPBM', 'FOB', 'ASURANSI',
                'FREIGHT', 'NILAI TAMBAH', 'DISKON', 'HARGA PENYERAHAN', 'HARGA PEROLEHAN', 'HARGA SATUAN', 'HARGA EKSPOR', 'HARGA PATOKAN', 'NILAI BARANG', 'NILAI JASA',
                'NILAI DANA SAWIT', 'NILAi DEVISA', 'PERSENTASE IMPOR', 'KODE ASAL BARANG', 'KODE DAERAH ASAL', 'KODE GUNA BARANG', 'KODE JENIS NILAI',
                'JATUH TEMPO ROYALTI', 'KODE KATEGORI BARANG', 'KODE KONDISI BARANG', 'KODE NEGARA ASAL', 'KODE PERHITUNGAN', 'PERNYATAAN LARTAS',
                'FLAG 4 TAHUN', 'SERI IZIN', 'TAHUN PEMBUATAN', 'KAPASITAS SILINDER', 'KODE BKC', 'KODE KOMODITI BKC', 'KODE SUB KOMODITI BKC', 'FLAG TIS',
                'ISI PER KEMASAN', 'JUMLAH DILEKATKAN', 'JUMLAH PITA CUKAI', 'HJE CUKAI', 'TARIF CUKAI'
            ];
            $arraybarangtarif = [
                'NOMOR AJU', 'SERI BARANG', 'KODE PUNGUTAN', 'KODE TARIF', 'TARIF', 'KODE FASILITAS', 'TARIF FASILITAS', 'NILAI BAYAR', 'NILAI FASILITAS',
                'NILAI SUDAH DILUNASI', 'KODE SATUAN', 'JUMLAH SATUAN', 'FLAG BMT SEMENTARA', 'KODE KOMODITI CUKAI', 'KODE SUB KOMODITI CUKAI', 'FLAG TIS',
                'FLAG PELEKATAN', 'KODE KEMASAN', 'JUMLAH KEMASAN'
            ];
            $arraybarangdokumen = [
                'NOMOR AJU', 'SERI BARANG', 'SERI DOKUMEN', 'SERI IZIN'
            ];
            $arraybarangentitas = [
                'NOMOR AJU', 'SERI BARANG', 'SERI DOKUMEN'
            ];
            $arraybarangspekkhusus = [
                'NOMOR AJU', 'SERI BARANG', 'KODE', 'URAIAN'
            ];
            $arraybarangvd = [
                'NOMOR AJU', 'SERI BARANG', 'KODE VD', 'NILAI BARANG', 'BIAYA TAMBAHAN', 'BIAYA PENGURANG', 'JATUH TEMPO'
            ];
            $arraybahanbaku = [
                'NOMOR AJU', 'SERI BARANG', 'SERI BAHAN BAKU', 'KODE ASAL BAHAN BAKU', 'HS', 'KODE BARANG', 'URAIAN', 'MEREK', 'TIPE', 'UKURAN', 'SPESIFIKASI LAIN',
                'KODE SATUAN', 'JUMLAH SATUAN', 'KODE KEMASAN', 'JUMLAH KEMASAN', 'KODE DOKUMEN ASAL', 'KODE KANTOR ASAL', 'NOMOR DAFTAR ASAL', 'TANGGAL DAFTAR ASAl',
                'NOMOR AJU ASAL', 'SERI BARANG ASAL', 'NETTO', 'BRUTO', 'VOLUME', 'CIF', 'CIF RUPIAH', 'NDPBM', 'HARGA PENYERAHAN', 'HARGA PEROLEHAN', 'NILAI JASA', 'SERI IZIN',
                'VALUTA', 'KODE BKC', 'KODE KOMODITI BKC', 'KODE SUB KOMODITI BKC', 'FLAG TIS', 'ISI PER KEMASAN', 'JUMLAH DILEKATKAN', 'JUMLAH PITA CUKAI', 'HJE CUKAI', 'TARIF CUKAI'
            ];
            $arraybahanbakutarif = [
                'NOMOR AJU', 'SERI BARANG', 'SERI BAHAN BAKU', 'KODE ASAL BAHAN BAKU', 'KODE PUNGUTAN', 'KODE TARIF', 'TARIF', 'KODE FASILITAS', 'TARIF FASILITAS',
                'NILAI BAYAR', 'NILAI FASILITAS', 'NILAI SUDAH DILUNASI', 'KODE SATUAN', 'JUMLAH SATUAN', 'FLAG BMT SEMENTARA', 'KODE KOMODITI CUKAI', 'KODE SUB KOMODITI CUKAI',
                'FLAG TIS', 'FLAG PELEKATAN', 'KODE KEMASAN', 'KODE SUB KOMODITI CUKAI', 'FLAG TIS', 'FLAG PELEKATAN', 'KODE KEMASAN', 'JUMLAH KEMASAN'
            ];
            $arraybahanbakudokumen = [
                'NOMOR AJU', 'SERI BARANG', 'SERI BAHAN BAKU', 'KODE_ASAL_BAHAN_BAKU', 'SERI DOKUMEN', 'SERI IZIN'
            ];
            $arraypungutan = [
                'NOMOR AJU', 'KODE FASILITAS TARIF', 'KODE JENIS PUNGUTAN', 'NILAI PUNGUTAN', 'NPWP BILLING'
            ];
            $arrayjaminan = [
                'NOMOR AJU', 'KODE KANTOR', 'KODE JAMINAN', 'NOMOR JAMINAN', 'TANGGAL JAMINAN', 'NILAI JAMINAN', 'PENJAMIN', 'TANGGAL JATUH TEMPO', 'NOMOR BPJ', 'TANGGAL BPJ'
            ];
            $arraybankdevisa = [
                'NOMOR AJU', 'SERI', 'KODE', 'NAMA'
            ];
            $arrayversi = [
                'VERSI'
            ];
            $kode = 'array' . strtolower($array[$z]);
            // print_r($$kode);
            for ($i = 0; $i < count($$kode); $i++) {
                if ((65 + $i) > 142) {
                    $chr = chr(67) . chr(65 + ($i - 78));
                } else if ((65 + $i) > 116) {
                    $chr = chr(66) . chr(65 + ($i - 52));
                } else if ((65 + $i) > 90) {
                    $chr = chr(65) . chr(65 + ($i - 26));
                } else {
                    $chr = chr(65 + $i);
                }
                $sheet->setCellValue($chr . '1', $$kode[$i]);
            }
        }
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);
        //Proses pengisian excel dari database
        $data = $this->ibmodel->getdatabyid($id);
        $noaju = isikurangnol($data['jns_bc']) . '010017' . str_replace('-', '', $data['tgl_aju']) . $data['nomor_aju'];
        $sheet = $spreadsheet->getSheetByName('HEADER');
        $sheet->setCellValue('A2', $noaju);
        $sheet->setCellValue('B2', '40');
        $sheet->setCellValue('C2', '050500');
        $sheet->setCellValue('J2', '1');
        $sheet->setCellValue('N2', '1');
        $sheet->setCellValue('BV2', $data['totalharga']);  // Nilai PAB
        $sheet->setCellValue('CB2', $data['bruto']);  // Bruto
        $sheet->setCellValue('CC2', $data['netto']);  // Netto
        $sheet->setCellValue('CD2', '0');
        $sheet->setCellValue('CE2', 'BANDUNG');
        $sheet->setCellValue('CF2', $data['tgl_aju']);
        $sheet->setCellValue('CG2', 'MIRA AMALIA WULAN');
        $sheet->setCellValue('CH2', 'MANAGER KEU. & AKT');

        $sheet = $spreadsheet->getSheetByName('ENTITAS');
        $sheet->setCellValue('A2', $noaju);
        $sheet->setCellValue('B2', '3');
        $sheet->setCellValue('C2', '3');
        $sheet->setCellValue('D2', '5');
        $sheet->setCellValue('E2', '010017176057000');
        $sheet->setCellValue('F2', 'INDONEPTUNE NET MANUFACTURING');
        $sheet->setCellValue('G2', 'JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01, DESA CANGKUANG 004/001 CANGKUANG, RANCAEKEK, BANDUNG, JAWA BARAT');
        $sheet->setCellValue('H2', "9120011042693");
        $sheet->setCellValue('K2', '1555/KM.4/2017');
        $sheet->setCellValue('L2', '2017-07-10');

        $sheet->setCellValue('A3', $noaju);
        $sheet->setCellValue('B3', '7');
        $sheet->setCellValue('C3', '7');
        $sheet->setCellValue('D3', '5');
        $sheet->setCellValue('E3', '010017176057000');
        $sheet->setCellValue('F3', 'INDONEPTUNE NET MANUFACTURING');
        $sheet->setCellValue('G3', 'JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01, DESA CANGKUANG 004/001 CANGKUANG, RANCAEKEK, BANDUNG, JAWA BARAT');
        $sheet->setCellValue('J2', "LAINNYA");
        $sheet->setCellValue('K3', '1555/KM.4/2017');
        $sheet->setCellValue('L3', '2017-07-10');

        $sheet->setCellValue('A4', $noaju);
        $sheet->setCellValue('B4', '9');
        $sheet->setCellValue('C4', '9');
        $sheet->setCellValue('D4', '5');
        $sheet->setCellValue('E4', $data['npwp']);
        $sheet->setCellValue('F4', $data['namasupplier']);
        $sheet->setCellValue('G4', $data['alamat']);
        $sheet->setCellValue('I4', "02");
        $sheet->setCellValue('J4', 'LAINNYA');

        $sheet = $spreadsheet->getSheetByName('DOKUMEN');
        $dokmen = $this->ibmodel->getdatadokumen($id);
        $no = 1;
        foreach ($dokmen->result_array() as $doku) {
            $sheet->setCellValue('A2', $noaju);
            $sheet->setCellValue('B2', $no++);
            $sheet->setCellValue('C2', $doku['kode_dokumen']);
            $sheet->setCellValue('D2', $doku['nomor_dokumen']);
            $sheet->setCellValue('E2', $doku['tgl_dokumen']);
        }

        $sheet = $spreadsheet->getSheetByName('PENGANGKUT');
        $sheet->setCellValue('A2', $noaju);
        $sheet->setCellValue('C2', $data['jns_angkutan']);
        $sheet->setCellValue('D2', $data['angkutan']);
        $sheet->setCellValue('E2', $data['no_kendaraan']);

        $sheet = $spreadsheet->getSheetByName('KEMASAN');
        $sheet->setCellValue('A2', $noaju);
        $sheet->setCellValue('B2', '1');
        $sheet->setCellValue('C2', $data['kd_kemasan']);
        $sheet->setCellValue('D2', $data['jml_kemasan']);

        $sheet = $spreadsheet->getSheetByName('BARANG');
        $datadet = $this->ibmodel->getdatadetailib($id);
        $no = 1;
        foreach ($datadet as $detx) {
            $no++;
            $jumlah = $detx['kodesatuan'] == 'KGS' ? $detx['kgs'] : $detx['pcs'];
            $sheet->setCellValue('A' . $no, $noaju);
            $sheet->setCellValue('B' . $no, $detx['seri_barang']);
            $sheet->setCellValue('C' . $no, $detx['nohs']);
            $sheet->setCellValue('D' . $no, $detx['brg_id']);
            $sheet->setCellValue('E' . $no, $detx['nama_barang']);
            $sheet->setCellValue('J' . $no, $detx['satbc']);
            $sheet->setCellValue('K' . $no, $jumlah);
            $sheet->setCellValue('L' . $no, $data['kd_kemasan']);
            $sheet->setCellValue('M' . $no, '0');
            $sheet->setCellValue('T' . $no, $detx['kgs']);
            $sheet->setCellValue('AH' . $no, $detx['harga']);
        }

        $sheet = $spreadsheet->getSheetByName('BARANGTARIF');
        $no = 1;
        $sumppn = 0;
        foreach ($datadet as $detx) {
            $no++;
            $jumlah = $detx['kodesatuan'] == 'KGS' ? $detx['kgs'] : $detx['pcs'];
            $sheet->setCellValue('A' . $no, $noaju);
            $sheet->setCellValue('B' . $no, $detx['seri_barang']);
            $sheet->setCellValue('C' . $no, 'PPN');
            $sheet->setCellValue('D' . $no, '1');
            $sheet->setCellValue('E' . $no, 11);
            $sheet->setCellValue('F' . $no, '3');
            $sheet->setCellValue('G' . $no, 100);
            $sheet->setCellValue('I' . $no, round($detx['harga'] * 0.11, 0));
            $sheet->setCellValue('J' . $no, '0');
            $sheet->setCellValue('K' . $no, substr($detx['kodesatuan'], 0, 2));
            $sheet->setCellValue('L' . $no, $jumlah);
            $sumppn += round($detx['harga'] * 0.11, 0);
        }

        $sheet = $spreadsheet->getSheetByName('PUNGUTAN');
        $sheet->setCellValue('A2', $noaju);
        $sheet->setCellValue('B2', '3');
        $sheet->setCellValue('C2', 'PPN');
        $sheet->setCellValue('D2', $sumppn);

        $sheet = $spreadsheet->getSheetByName('VERSI');
        $sheet->setCellValue('A2', '1.1');

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Ceisa 40.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
    }
    public function hosttohost($id)
    {
        $this->session->unset_userdata('datatokenbeacukai');
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            // "Authorization: Bearer ".$logged_user_token
        );
        $data = [
            'username' => 'siaga1', //'indoneptune',
            'password' => 'Ifn123456' //'Bandung#14',
        ];

        curl_setopt(
            $curl,
            CURLOPT_HTTPHEADER,
            $headers
            // array(
            //     "Authorization: $token",
            // )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/nle-oauth/v1/user/login');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $databalik = json_decode($result, true);
        // print_r($databalik);
        if ($databalik['status'] == 'success') {
            $data = [
                'token' => $databalik['item']['access_token'],
                'refresh_token' => $databalik['item']['refresh_token']
            ];
            $this->akbmodel->isitokenbc($data);
            $this->session->set_userdata('datatokenbeacukai', $databalik['item']['access_token']);
            $this->helpermodel->isilog('Refresh Token CEISA 40');
            $this->getkurs();
            if ($id = 99) {
                $url = base_url() . 'akb';
            } else {
                $url = base_url() . 'akb/isidokbc/' . $id;
            }
            redirect($url);
        } else {
            // $url = base_url().'ib/kosong';
            // redirect($url);
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', $databalik['message'] . '[EXCEPTION]' . $databalik['Exception']);
            if ($id = '') {
                $url = base_url() . 'ib';
            } else {
                $url = base_url() . 'ib/isidokbc/' . $id;
            }
            redirect($url);
        }
    }
    public function getkurs()
    {
        $token = $this->akbmodel->gettoken();
        $kode = ['usd', 'jpy', 'eur'];
        for ($x = 0; $x < count($kode); $x++) {
            $kodex = $kode[$x];
            $curl = curl_init();
            // $token = $consID;
            $headers = array(
                "Content-Type: application/json",
                "Authorization: Bearer " . $token,
            );

            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/openapi/kurs/' . $kodex);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
            $result = curl_exec($curl);
            curl_close($curl);

            $databalik = json_decode($result, true);
            // print_r($databalik['data'][0]['nilaiKurs']);
            if ($databalik['status'] == 'true') {
                $this->akbmodel->isikursbc($databalik['data'][0]['nilaiKurs'], $kodex);
                $this->helpermodel->isilog('Isi KURS BC CEISA 40');
            }
        }
    }
    public function getresponhost($id)
    {
        $dataaju = $this->akbmodel->getdatanomoraju($id);
        $token = $this->akbmodel->gettoken();
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $token,
        );
        $data = [
            $dataaju
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/openapi/status/' . $dataaju);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $databalik = json_decode($result, true);
        // print_r($databalik);
        if ($databalik['status'] == 'Success') {
            if ($databalik['dataStatus'][0]['nomorDaftar'] != '') {
                $data = [
                    'id' => $id,
                    'nomor_bc' => $databalik['dataStatus'][0]['nomorDaftar'],
                    'tgl_bc' => tglmysql($databalik['dataStatus'][0]['tanggalDaftar']),
                    'nomor_sppb' => $databalik['dataRespon'][0]['nomorRespon'],
                    'tgl_sppb' => $databalik['dataRespon'][0]['tanggalRespon']
                ];
                $hasil = $this->akbmodel->simpanresponbc($data);
                if ($hasil) {
                    $this->helpermodel->isilog("Berhasil GET RESPON AJU " . $dataaju . " (" . $databalik['dataStatus'][0]['nomorDaftar'] . ")");
                    $this->session->set_flashdata('errorsimpan', 2);
                    $this->session->set_flashdata('pesanerror', 'Respon sudah berhasil di Tarik');
                }
            } else {
                $this->session->set_flashdata('errorsimpan', 1);
                $this->session->set_flashdata('pesanerror', 'Nomor Pendaftaran Masih kosong, ' . $databalik['dataStatus'][0]['keterangan']);
            }
            $url = base_url() . 'akb/isidokbc/' . $id;
            redirect($url);
        } else {
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', $databalik['message'] . '[EXCEPTION]' . $databalik['Exception']);
            // $url = base_url().'ib/isidokbc/'.$id;
            $url = base_url() . 'akb/isidokbc/' . $id;
            redirect($url);
        }
    }
    public function getresponpdf($id, $mode = 0)
    {
        $dataaju = $this->akbmodel->getdatanomoraju($id);
        $token = $this->akbmodel->gettoken();
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $token,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/openapi/status/' . $dataaju);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $databalik = json_decode($result, true);
        // print_r($databalik);
        if ($databalik['status'] == 'Success') {
            if ($databalik['dataStatus'][0]['nomorDaftar'] != '' && $databalik['dataRespon'][0]['pdf'] != null) {
                $this->tampilkanpdf($databalik['dataRespon'][0]['pdf'], $id, $mode);
            } else {
                $this->session->set_flashdata('errorsimpan', 1);
                $this->session->set_flashdata('pesanerror', 'PDF Belum ada');
            }
            $url = $mode = 0 ? base_url() . 'akb/isidokbc/' . $id : base_url() . 'akb';
            redirect($url);
        } else {
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', $databalik['message'] . '[EXCEPTION]' . $databalik['Exception']);
            // $url = base_url().'ib/isidokbc/'.$id;
            $url = $mode = 0 ? base_url() . 'akb/isidokbc/' . $id : base_url() . 'akb';
            redirect($url);
        }
    }
    public function tampilkanpdf($data, $id, $mode)
    {
        $token = $this->ibmodel->gettoken();
        $dataaju = $this->ibmodel->getdatanomoraju($id);
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $token,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, "https://apis-gw.beacukai.go.id/openapi/download-respon?path=" . $data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        // print_r($data);  
        $pisah = explode('/', $data);
        $filename = $data;
        $databalik = $result;
        $lokfile = $dataaju;
        header('Cache-Control: public');
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="' . $lokfile . '.pdf"');
        header('Content-Length: ' . strlen($databalik));
        echo $databalik;
        if ($mode = 0) {
            $url = base_url() . 'ib/isidokbc/' . $id;
        } else {
            $url = base_url() . 'ib';
        }
        redirect($url);
    }
    public function addlampiran($id)
    {
        $data['datheader'] = $this->ibmodel->getdatabyid($id);
        $data['lampiran'] = $this->ibmodel->getjenisdokumen();
        $this->load->view('ib/addlampiran', $data);
    }
    public function tambahlampiran()
    {
        $data = [
            'id_header' => $_POST['id'],
            'kode_dokumen' => $_POST['kode'],
            'nomor_dokumen' => $_POST['nomor'],
            'tgl_dokumen' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket']
        ];
        $hasil = $this->ibmodel->tambahlampiran($data);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $html = '';
            $query = $this->ibmodel->getdatalampiran($_POST['id']);
            $no = 1;
            foreach ($query->result_array() as $que) {
                $html .= '<tr>';
                $html .= '<td>' . $no++ . '</td>';
                $html .= '<td>' . $que['kode_dokumen'] . '</td>';
                $html .= '<td>' . $que['nama_dokumen'] . '</td>';
                $html .= '<td>' . $que['nomor_dokumen'] . '</td>';
                $html .= '<td>' . $que['tgl_dokumen'] . '</td>';
                $html .= '<td>' . $que['keterangan'] . '</td>';
                $html .= '<td>';
                $html .= '<a href="' . base_url() . 'ib/hapuslampiran/' . $que['id'] . '/' . $que['id_header'] . '" style="padding: 2px 3px !important;" class="btn btn-sm btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus IB" data-title="Isi Data AJU + Nomor BC">Hapus</a>';
                $html .= '<a href="' . base_url() . 'ib/editlampiran/' . $que['id'] . '/' . $que['id_header'] . '" style="padding: 2px 3px !important;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Edit IB" data-title="Edit Data AJU + Nomor BC">Edit</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $cocok = array('datagroup' => $html);
            echo json_encode($cocok);
        }
    }
    public function getdatalampiran($id)
    {
        $html = '';
        $sendceisa = $_POST['cek'];
        $query = $this->ibmodel->getdatalampiran($id);
        $no = 1;
        foreach ($query->result_array() as $que) {
            $html .= '<tr>';
            $html .= '<td>' . $no++ . '</td>';
            $html .= '<td>' . $que['kode_dokumen'] . '</td>';
            $html .= '<td>' . $que['nama_dokumen'] . '</td>';
            $html .= '<td>' . $que['nomor_dokumen'] . '</td>';
            $html .= '<td>' . $que['tgl_dokumen'] . '</td>';
            $html .= '<td>' . $que['keterangan'] . '</td>';
            $html .= '<td>';
            if ($sendceisa == 0) {
                $html .= '<a href="' . base_url() . 'ib/hapuslampiran/' . $que['idx'] . '/' . $que['id_header'] . '" style="padding: 2px 3px !important;" class="btn btn-sm btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus IB" data-title="Hapus Lampiran">Hapus</a>';
                $html .= '<a href="' . base_url() . 'ib/editlampiran/' . $que['id'] . '/' . $que['id_header'] . '" style="padding: 2px 3px !important;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Edit IB" data-title="Edit Data Lampiran">Edit</a>';
            }
            $html .= '</td>';
            $html .= '</tr>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function editlampiran($id, $ide)
    {
        $data['datlampiran'] = $this->ibmodel->getdatalampiranbyid($id)->row_array();
        $data['lampiran'] = $this->ibmodel->getjenisdokumen();
        $this->load->view('ib/editlampiran', $data);
    }
    public function updatelampiran()
    {
        $data = [
            'id' => $_POST['id'],
            'kode_dokumen' => $_POST['kode'],
            'nomor_dokumen' => $_POST['nomor'],
            'tgl_dokumen' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket']
        ];
        $hasil = $this->ibmodel->updatelampiran($data);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $html = '';
            $query = $this->ibmodel->getdatalampiran($_POST['head']);
            $no = 1;
            foreach ($query->result_array() as $que) {
                $html .= '<tr>';
                $html .= '<td>' . $no++ . '</td>';
                $html .= '<td>' . $que['kode_dokumen'] . '</td>';
                $html .= '<td>' . $que['nama_dokumen'] . '</td>';
                $html .= '<td>' . $que['nomor_dokumen'] . '</td>';
                $html .= '<td>' . $que['tgl_dokumen'] . '</td>';
                $html .= '<td>' . $que['keterangan'] . '</td>';
                $html .= '<td>';
                $html .= '<a href="' . base_url() . 'ib/hapuslampiran/' . $que['id'] . '/' . $que['id_header'] . '" style="padding: 2px 3px !important;" class="btn btn-sm btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus IB" data-title="Isi Data AJU + Nomor BC">Hapus</a>';
                $html .= '<a href="' . base_url() . 'ib/editlampiran/' . $que['id'] . '/' . $que['id_header'] . '" style="padding: 2px 3px !important;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Edit IB" data-title="Edit Data AJU + Nomor BC">Edit</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $cocok = array('datagroup' => $html);
            echo json_encode($cocok);
        }
    }
    public function hapuslampiran($id, $ide)
    {
        $data = [
            'id' => $id,
            'header' => $ide
        ];
        $this->load->view('ib/hapuslampiran', $data);
    }
    public function hapuslamp()
    {
        $data = $_POST['id'];
        $header = $_POST['head'];
        $hasil = $this->ibmodel->hapuslampiran($data);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $html = '';
            $query = $this->ibmodel->getdatalampiran($header);
            $no = 1;
            foreach ($query->result_array() as $que) {
                $html .= '<tr>';
                $html .= '<td>' . $no++ . '</td>';
                $html .= '<td>' . $que['kode_dokumen'] . '</td>';
                $html .= '<td>' . $que['nama_dokumen'] . '</td>';
                $html .= '<td>' . $que['nomor_dokumen'] . '</td>';
                $html .= '<td>' . $que['tgl_dokumen'] . '</td>';
                $html .= '<td>' . $que['keterangan'] . '</td>';
                $html .= '<td>';
                $html .= '<a href="' . base_url() . 'ib/hapuslampiran/' . $que['idx'] . '/' . $que['id_header'] . '" style="padding: 2px 3px !important;" class="btn btn-sm btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus Lampiran" class="btn btn-sm btn-primary">Hapus</a>';
                $html .= '<a href="' . base_url() . 'ib/editlampiran/' . $que['id'] . '/' . $que['id_header'] . '" style="padding: 2px 3px !important;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Edit IB" data-title="Edit Data Lampiran">Edit</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $cocok = array('datagroup' => $html);
            echo json_encode($cocok);
        }
    }
    function kirimdatakeceisa30($id)
    {
        $data = $this->akbmodel->getdatabyid($id);
        $datakon = $this->akbmodel->getdatakontainer($id);
        $noaju = isikurangnol($data['jns_bc']) . '010017' . str_replace('-', '', $data['tgl_aju']) . $data['nomor_aju'];
        $kurs = $data['mtuang'] == 2 ? $data['kurs_usd'] : $data['kurs_yen'];
        $arrayheader = [
            "asalData" => "S",
            "kodeDokumen" => $data['jns_bc'],
            "asuransi" => (float) $data['asuransi'],
            "bruto" => (float) $data['bruto'],
            "flagCurah" => "2",
            "flagMigas" => "2",
            "fob" => (float) $data['nilai_pab'],
            "freight" => (float) $data['freight'],
            "jabatanTtd" => strtoupper($data['jabat_tg_jawab']),
            "jumlahKontainer" => $datakon->num_rows(),
            "kodeAsuransi" => "DN",
            "kodeCaraBayar" => "4",
            "kodeCaraDagang" => "15",
            "kodeJenisEkspor" => "1",
            "kodeKantor" => "040300",
            "kodeKantorEkspor" => "040300",
            "kodeKantorMuat" => "040300",
            "kodeKantorPeriksa" => "050500",
            "kodeKategoriEkspor" => "41",
            "kodeLokasi" => "6",
            "kodeNegaraTujuan" => $data['negaracustomer'],
            "kodePelBongkar" => trim($data['pelabuhan_bongkar']),
            "kodePelEkspor" => trim($data['pelabuhan_muat']),
            "kodePelMuat" => trim($data['pelabuhan_muat']),
            "kodePelTujuan" => trim($data['pelabuhan_bongkar']),
            "kodeValuta" => $data['mt_uang'],
            "kotaTtd" => "BANDUNG",
            "namaTtd" => strtoupper($data['tg_jawab']),
            "ndpbm" => (float) $kurs,
            "netto" => (float) $data['netto'],
            "nilaiMaklon" => 0,
            "nomorAju" => $noaju,
            "tanggalEkspor" => $data['tgl_aju'],
            "tanggalPeriksa" => $data['tgl_aju'],
            "tanggalTtd" => $data['tgl_aju'],
            "kodeIncoterm" => $data['kode_incoterm'],
            "flagBarkir" => "T",
            "kodeJenisPengangkutan" => "1"
            // "kesiapanBarang" => [],
            // "bankDevisa" => []
        ];
        $arrayentitas = [];
        for ($ke = 1; $ke <= 4; $ke++) {
            $alamatifn = "JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01,\r\nDESA CANGKUANG 004/001 CANGKUANG,\r\nRANCAEKEK, BANDUNG, JAWA BARAT";
            $serient = $ke == 1 ? "2" : (($ke == 2) ? "8" : (($ke == 3) ? "6" : "13"));
            $kodeentitas = $ke == 1 ? "2" : (($ke == 2) ? "7" : (($ke == 3) ? "8" : "6"));
            $kodejnent = $ke == 1 ? "6" : (($ke == 4) ? "" : (($ke == 2) ? "6" : ""));
            $status = "";
            if ($ke > 2) {
                if ($ke == 3) {
                    $nomoridentitas = "";
                    $namaidentitas = $data['namacustomer'];
                    $alamat = strtoupper($data['alamat']);
                    $negara = $data['negaracustomer'];
                } else {
                    if ($data['dirsell'] == 1) {
                        $nomoridentitas = "";
                        $namaidentitas = $data['namacustomer'];
                        $alamat = strtoupper($data['alamat']);
                        $negara = $data['negaracustomer'];
                    } else {
                        $nomoridentitas = "";
                        $namaidentitas = "MOMOI FISHING NET MFG CO.,LTD";
                        $alamat = "10TH FL.KOBE ASAHI BLDG 59 NANIWA MACHI CHUO KU KOBE 6500035";
                        $negara = "JP";
                    }
                }
            } else {
                $nomoridentitas = $ke == 1 ? "0010017176057000000000" : "0010017176057000000000";
                $namaidentitas = $ke == 1 ? "INDONEPTUNE NET MANUFACTURING" : "INDONEPTUNE NET MANUFACTURING";
                $alamat = $ke == 1 ? $alamatifn : $alamatifn;
                $negara = '';
                $status = "5";
            }
            $nibidentitas = $ke == 1 ? "9120011042693" : (($ke == 2) ? "9120011042693" : "");
            $arrayke = [
                "seriEntitas" => (int) $serient,
                "kodeEntitas" => $kodeentitas,
                "kodeJenisIdentitas" => $kodejnent,
                "nomorIdentitas" => trim(str_replace('-', '', str_replace('.', '', $nomoridentitas))),
                "alamatEntitas" => $alamat,
                "namaEntitas" => trim($namaidentitas),
                "nibEntitas" => $nibidentitas,
                "kodeNegara" => $negara,
                "kodeStatus" => $status
            ];
            array_push($arrayentitas, $arrayke);
        }
        $arraydokumen = [];
        $dokmen = $this->akbmodel->getdatadokumen($id);
        $no = 1;
        foreach ($dokmen->result_array() as $doku) {
            $arrayke = [
                "kodeDokumen" => $doku['kode_dokumen'],
                "nomorDokumen" => $doku['nomor_dokumen'],
                "seriDokumen" => $no++,
                "tanggalDokumen" => $doku['tgl_dokumen']
            ];
            array_push($arraydokumen, $arrayke);
        }
        $carangkut = $data['jns_angkutan'];
        switch ($carangkut) {
            case 2:
                $carangkut = "3";
                break;
            case 3:
                $carangkut = "4";
                break;
            case 4:
                $carangkut = "9";
                break;
        }
        $arrangkut = [];
        $arrayangkutan = [
            "namaPengangkut" => trim($data['angkutan']),
            "nomorPengangkut" => $data['no_kendaraan'],
            "seriPengangkut" => 1,
            "kodeCaraAngkut" => $carangkut,
            "kodeBendera" => $data['kode_negara']
        ];
        array_push($arrangkut, $arrayangkutan);
        $datakont = $this->akbmodel->getdatakontainer($id);
        $arraykonta = [];
        $ke = 0;
        foreach ($datakont->result_array() as $kont) {
            $ke++;
            $arrkont = [
                'kodeTipeKontainer' => "1",
                'kodeUkuranKontainer' => $kont['ukuran_kontainer'],
                'nomorKontainer' => $kont['nomor_kontainer'],
                'kodeJenisKontainer' => $kont['jenis_kontainer'],
                'seriKontainer' => $ke
            ];
            array_push($arraykonta, $arrkont);
        }
        // array_push($arraykonta,$arraykontainer);
        $arrkemas = [];
        $arraykemasan = [
            "jumlahKemasan" => (int) $data['jml_kemasan'],
            "kodeJenisKemasan" => $data['kd_kemasan'],
            "merkKemasan" => "-",
            "seriKemasan" => 1
        ];
        array_push($arrkemas, $arraykemasan);
        $arraybarang = [];
        $datadet = $this->akbmodel->getdatadetailib($id);
        $no = 0;
        $jumlahfasilitas = 0;
        foreach ($datadet as $detx) {
            $no++;
            $jumlah = $detx['kodesatuan'] == 'KGS' ? $detx['kgs'] : $detx['pcs'];
            $arrayke = [
                "seriBarang" => $no,
                "asuransi" => 0,
                "cif" => 0,
                "cifRupiah" => 0,
                "fob" => (float) round($detx['harga'], 2),
                "hargaEkspor" => 0,
                "hargaPatokan" => 0,
                "hargaPerolehan" => 0,
                "hargaSatuan" => (float) round($detx['harga_satuan'], 2),
                "jumlahKemasan" => (float) $detx['jml_kemasan'],
                "jumlahSatuan" => (float) $jumlah,
                "kodeBarang" => trim($detx['po']) . '#' . trim($detx['item']),
                "kodeDaerahAsal" => "3204",
                "kodeJenisKemasan" => $detx['kdkem'],
                "kodeNegaraAsal" => "ID",
                "kodeSatuanBarang" => $detx['satbc'],
                "merk" => "MOMOI",
                "ndpbm" => (float) $kurs,
                "netto" => (float) $detx['kgs'],
                "posTarif" =>  substr($detx['nohs'], 0, 8),
                "spesifikasiLain" => "1",
                "tipe" => "-",
                "ukuran" => "-",
                "uraian" => $detx['engklp'],
                "volume" => 0,
                "nilaiDanaSawit" => 0,
                "kodeJenisEkspor" => "1"
            ];
            $arraytarif = [];
            $barangtarif = [
                // "seriBarang" => $no,
                // "jumlahSatuan" => (int) $jumlah,
                // "kodeFasilitasTarif" => "3",
                // "kodeSatuanBarang" => $detx['kodesatuan'],
                // "nilaiBayar" => 0,
                // "nilaiFasilitas" => round(($detx['harga']*$jumlah)*0.11,0),
                // "nilaiSudahDilunasi" => 0,
                // "tarif" => 11,
                // "tarifFasilitas" => 100,
                // "kodeJenisPungutan" => "PPN",
                // "kodeJenisTarif" => "1"
            ];
            $arraypemilik = [];
            $arrpemilik = [
                'seriEntitas' => 8
            ];
            $jumlahfasilitas += ($detx['harga'] * $jumlah) * 0.11;
            array_push($arraypemilik, $arrpemilik);
            $arrayke['barangTarif'] = $arraytarif;
            $arrayke['barangPemilik'] = $arraypemilik;
            array_push($arraybarang, $arrayke);
        }
        $arraypungutan = [];
        $pungutanarray = [
            "kodeFasilitasTarif" => "3",
            "kodeJenisPungutan" => "PPN",
            "nilaiPungutan" => round($jumlahfasilitas, 0)
        ];
        array_push($arraypungutan, $pungutanarray);
        $arrayBank = [];
        $bankarray = [
            "kodeBank" => "213",
            "seriBank" => 1
        ];
        array_push($arrayBank, $bankarray);
        $datakon = $this->akbmodel->getdatakontainer($id);
        if ($datakon->num_rows() > 0) {
            $konn = $datakon->row_array();
            $carastuffing = $konn['jenis_kontainer'];
        } else {
            $carastuffing = "7";
        }
        $arrsiapbar = [];
        $arraysiapbarang = [
            "kodeJenisBarang" => "2",
            "kodeJenisGudang" => "2",
            "namaPic" => "MR. AWAN KURNIAWAN",
            "alamat" => "JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01,\r\nDESA CANGKUANG 004/001 CANGKUANG,\r\nRANCAEKEK, BANDUNG, JAWA BARAT",
            "nomorTelpPic" => "022-7798042",
            "lokasiSiapPeriksa" => "PT. INDONEPTUNE NET MANUFACTURING",
            "tanggalPkb" => $data['tgl_aju'],
            "waktuSiapPeriksa" => (new \DateTime('Asia/Jakarta'))->format(DATE_ATOM),
            "kodeCaraStuffing" => $carastuffing
        ];
        array_push($arrsiapbar, $arraysiapbarang);

        $arrayheader['entitas'] = $arrayentitas;
        $arrayheader['dokumen'] = $arraydokumen;
        $arrayheader['pengangkut'] = $arrangkut;
        $arrayheader['kontainer'] = $arraykonta;
        $arrayheader['kemasan'] = $arrkemas;
        $arrayheader['barang'] = $arraybarang;
        $arrayheader['bankDevisa'] = $arrayBank;
        $arrayheader['kesiapanBarang'] = $arrsiapbar;
        // $arrayheader['pungutan'] = $arraypungutan;
        // echo '<pre>'.json_encode($arrayheader)."</pre>";
        $this->kirim30($arrayheader, $id);
    }
    function kirimdatakeceisa23($id)
    {
        $data = $this->ibmodel->getdatabyid($id);
        $noaju = isikurangnol($data['jns_bc']) . '010017' . str_replace('-', '', $data['tgl_aju']) . $data['nomor_aju'];
        $arrayheader = [
            "asalData" => "S",
            "asuransi" => 0,
            "bruto" => (float) $data['bruto'],
            "cif" => 0,
            "fob" => 0,
            "freight" => 0,
            "hargaPenyerahan" => (float) $data['totalharga'],
            "jabatanTtd" => strtoupper($data['jabat_tg_jawab']),
            "jumlahKontainer" => 0,
            "kodeAsuransi" => "LN",
            "kodeDokumen" => $data['jns_bc'],
            "kodeIncoterm" => "CIF",
            "kodeKantor" => "050500",
            "kodeKantorBongkar" => "040300",
            "kodePelBongkar" => $data['pelabuhan_bongkar'],
            "kodePelMuat"  => $data['pelabuhan_muat'],
            "kodePelTransit" => "",
            "kodeTps" => "NCT1",
            "kodeTujuanTpb" => "1",
            "kodeTutupPu" => "11",
            "kodeValuta" => $data['mt_uang'],
            "kotaTtd" => "BANDUNG",
            "namaTtd" => strtoupper($data['tg_jawab']),
            "ndpbm" => (float) $data['kurs_usd'],
            "netto" => (float) $data['netto'],
            "nik" => "",
            "nilaiBarang" => (float) $data['nilai_pab'],
            "nomorAju" => $noaju,
            "nomorBc11" => $data['bc11'],
            "posBc11" => $data['nomor_posbc11'],
            "seri" => 1,
            "subposBc11" => $data['nomor_posbc11'],
            "tanggalBc11" => $data['tgl_bc11'],
            "tanggalTiba" => $data['tgl'],
            "tanggalTtd" => $data['tgl_aju'],
            "biayaTambahan" => 0,
            "biayaPengurang" => 0,
            "kodeKenaPajak" => "1"
        ];
        $ke = 1;
        $arrayentitas = [];
        for ($ke = 1; $ke <= 3; $ke++) {
            $alamatifn = "JL RAYA BANDUNG-GARUT KM. 25, CANGKUANG, RANCAEKEK, KAB. BANDUNG, JAWA BARAT, 40394";
            $kodeentitas = $ke == 1 ? "3" : (($ke == 2) ? "5" : "7");
            if ($ke == 3) {
                $nomoridentitas = $data['jns_pkp'] == 1 ? $data['nik'] . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', $data['nik'])))))) : '0' . $data['npwp'] . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', $data['npwp'])))) + 1));
            } else {
                $nomoridentitas = $ke == 1 ? "0010017176057000000000" : (($ke == 2) ? "0010017176057000000000" : '0' . $data['npwp'] . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', $data['npwp'])))) + 1)));
            }
            $namaidentitas = $ke == 1 ? "INDONEPTUNE NET MANUFACTURING" : (($ke == 2) ? "INDONEPTUNE NET MANUFACTURING" : $data['namasupplier']);
            $alamat = $ke == 1 ? $alamatifn : (($ke == 2) ? $alamatifn : $data['alamat']);
            $nibidentitas = $ke == 1 ? "9120011042693" : "";
            $kodejeniden = $ke == 3 ? "4" : "5";
            $arrayke = [
                "seriEntitas" => $ke,
                "alamatEntitas" => $alamat,
                "kodeEntitas" => $kodeentitas,
                "kodeJenisIdentitas" => $kodejeniden,
                "namaEntitas" => trim($namaidentitas),
                "nibEntitas" => $nibidentitas,
                "nomorIdentitas" => trim(str_replace('-', '', str_replace('.', '', $nomoridentitas))),
                "kodeNegara" => "ID",
                "kodeStatus" => "5"
            ];
            if ($ke == 2) {
                $arrayke["kodeJenisApi"] = "2";
            }
            if ($ke == 1) {
                $arrayke["nomorIjinEntitas"] = "1555/KM.4/2017";
                $arrayke["tanggalIjinEntitas"] = "2017-07-10";
            }
            array_push($arrayentitas, $arrayke);
        }
        $arraydokumen = [];
        $dokmen = $this->ibmodel->getdatadokumen($id);
        $no = 1;
        foreach ($dokmen->result_array() as $doku) {
            $arrayke = [
                "kodeDokumen" => $doku['kode_dokumen'],
                "nomorDokumen" => $doku['nomor_dokumen'],
                "seriDokumen" => $no++,
                "tanggalDokumen" => $doku['tgl_dokumen']
            ];
            array_push($arraydokumen, $arrayke);
        }
        $arrangkut = [];
        $arrayangkutan = [
            "namaPengangkut" => $data['angkutan'],
            "nomorPengangkut" => $data['no_kendaraan'],
            "seriPengangkut" => 1,
            "kodeBendera" => $data['kode_negara'],
            "kodeCaraAngkut" => $data['jns_angkutan']
        ];
        array_push($arrangkut, $arrayangkutan);
        $arrkemas = [];
        $arraykemasan = [
            "jumlahKemasan" => (int) $data['jml_kemasan'],
            "kodeJenisKemasan" => $data['kd_kemasan'],
            "merkKemasan" => "-",
            "seriKemasan" => 1
        ];
        array_push($arrkemas, $arraykemasan);
        $arraybarang = [];
        $datadet = $this->ibmodel->getdatadetailib($id);
        $no = 0;
        $jumlahfasilitas = 0;
        foreach ($datadet as $detx) {
            $no++;
            $jumlah = $detx['kodesatuan'] == 'KGS' ? $detx['kgs'] : $detx['pcs'];
            $arrayke = [
                "seriBarang" => $no,
                "asuransi" => 0,
                "cif" => (float) $detx['harga'] * $jumlah,
                "diskon" => 0,
                "fob" => 0,
                "freight" => 0,
                "hargaEkspor" => 0,
                "hargaSatuan" => (float) $detx['harga'],
                "bruto" => 0,
                "hargaPenyerahan" => (float) $detx['harga'] * $jumlah,
                "jumlahSatuan" => (int) $jumlah,
                "kodeBarang" => $detx['brg_id'],
                "kodeDokumen" => "40",
                "kodeJenisKemasan" => $data['kd_kemasan'],
                "isiPerKemasan" => 0,
                "kodeSatuanBarang" => $detx['satbc'],
                "kodeKategoriBarang" => "11",
                "kodeNegaraAsal" => $data['kodenegara'],
                "kodePerhitungan" => "1",
                "merk" => "-",
                "netto" => (float) $detx['kgs'],
                "nilaiBarang" => 0,
                "nilaiTambah" => 0,
                "posTarif" => trim($detx['nohs']), //Nomor HS
                "spesifikasiLain" => "",
                "tipe" => "-",
                "ukuran" => "",
                "uraian" => "",
                "ndpbm" => (float) $data['kurs_usd'],
                "cifRupiah" => (float) $data['kurs_usd'] * $jumlah,
                "hargaPerolehan" => (float) $detx['harga'] * $jumlah,
                "kodeAsalBahanBaku" => "0",
                "volume" => 0,
                "jumlahKemasan" => (int) $data['jml_kemasan'],
                "uraian" => trim($detx['nama_barang']),
            ];
            $arraytarif = [];
            $barangtarif = [
                "seriBarang" => $no,
                "jumlahSatuan" => (int) $jumlah,
                "kodeFasilitasTarif" => "3",
                "kodeSatuanBarang" => $detx['kodesatuan'],
                "nilaiBayar" => 0,
                "nilaiFasilitas" => round(($detx['harga'] * $jumlah) * 0.11, 0),
                "nilaiSudahDilunasi" => 0,
                "tarif" => 11,
                "tarifFasilitas" => 100,
                "kodeJenisPungutan" => "BM",
                "kodeJenisTarif" => "1"
            ];
            $jumlahfasilitas += ($detx['harga'] * $jumlah) * 0.11;
            $arraybarangdokumen = [];
            array_push($arraytarif, $barangtarif);
            $arrayke['barangTarif'] = $arraytarif;
            $arrayke['barangDokumen'] = $arraybarangdokumen;
            array_push($arraybarang, $arrayke);
        }
        $arraypungutan = [];
        $pungutanarray = [
            "kodeFasilitasTarif" => "3",
            "kodeJenisPungutan" => "PPN",
            "nilaiPungutan" => round($jumlahfasilitas, 0)
        ];
        array_push($arraypungutan, $pungutanarray);

        $arrayheader['entitas'] = $arrayentitas;
        $arrayheader['dokumen'] = $arraydokumen;
        $arrayheader['pengangkut'] = $arrangkut;
        $arrayheader['kemasan'] = $arrkemas;
        $arrayheader['barang'] = $arraybarang;
        $arrayheader['pungutan'] = $arraypungutan;
        // echo '<pre>'.json_encode($arrayheader)."</pre>";
        $this->kirim40($arrayheader, $id);
    }
    function kirimdatakeceisa261($id)
    {
        $data = $this->akbmodel->getdatabyid($id);
        $datakon = $this->akbmodel->getdatakontainer($id);
        $noaju = isikurangnol($data['jns_bc']) . '010017' . str_replace('-', '', $data['tgl_aju']) . $data['nomor_aju'];
        $kurs = $data['kurs_usd']; //$data['mtuang']==2 ? $data['kurs_usd'] : ($data['mtuang']==3 ? $data['kurs_yen'] : $data['kurs_idr']);
        $arrayheader = [
            "asalData" => "S",
            "kodeDokumen" => $data['jns_bc'],
            "asuransi" => (float) $data['asuransi'],
            "bruto" => (float) $data['netto'],
            "cif" => (float) round($data['nilai_pab'] / $kurs, 2),
            "biayaTambahan" => 0,
            "biayaPengurang" => 0,
            "disclaimer" => "1",
            "freight" => (float) $data['freight'],
            "hargaPenyerahan" => 0,
            "jabatanTtd" => strtoupper($data['jabat_tg_jawab']),
            "jumlahKontainer" => 0,
            "kodeKantor" => "050500",
            "kodeTujuanPengiriman" => $data['dept_tuju'] == 'SU' ? "1" : "2",
            "kodeValuta" => "USD", //$data['mt_uang'],
            "kotaTtd" => "BANDUNG",
            "namaTtd" => strtoupper($data['tg_jawab']),
            "ndpbm" => (float) $kurs,
            "netto" => (float) $data['netto'],
            "nik" => "",
            "nilaiBarang" => 0,
            "nomorAju" => $noaju,
            "seri" => 0,
            "tanggalAju" => $data['tgl_aju'],
            "tanggalTtd" => $data['tgl_aju'],
            "tempatStuffing" => "",
            "tglAkhirBerlaku" => "",
            "tglAwalBerlaku" => "",
            "totalDanaSawit" => 0,
            "uangMuka" => 0,
            "vd" => 0
        ];
        $arrayentitas = [];
        for ($ke = 1; $ke <= 3; $ke++) {
            $alamatifn = "JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01,\r\nDESA CANGKUANG 004/001 CANGKUANG,\r\nRANCAEKEK, BANDUNG, JAWA BARAT";
            $serient = $ke == 1 ? "3" : (($ke == 2) ? "7" : (($ke == 3) ? "8" : "13"));
            $kodeentitas = $ke == 1 ? "3" : (($ke == 2) ? "7" : (($ke == 3) ? "8" : "6"));
            $kodejnent = "6"; //$ke==1 ? "6" : (($ke==4) ? "" : (($ke==2) ? "6" : ""));
            $status = $ke == 2 ? "10" : "";
            $nibidentitas = $ke == 1 ? "9120011042693" : (($ke == 2) ? "" : "");
            if($data['jns_bc']==261 && $data['dept_tuju']=='SU' && $ke==3){
                // datasupplier($data['id_rekanan'],'npwp')
                $nomoridentitas = $ke == 1 ? "0010017176057000000000" : (($ke == 2) ? "0010017176057000000000" : '0' . datasupplier($data['id_rekanan'],'npwp') . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', datasupplier($data['id_rekanan'],'npwp'))))) + 1)));
                $alamat = $ke == 1 ? $alamatifn : (($ke == 2) ? $alamatifn : datasupplier($data['id_rekanan'],'alamat'));
                $namaidentitas = $ke == 1 ? "INDONEPTUNE NET MANUFACTURING" : (($ke == 2) ? "INDONEPTUNE NET MANUFACTURING" : datasupplier($data['id_rekanan'],'nama_supplier'));
            }else{
                $nomoridentitas = $ke == 1 ? "0010017176057000000000" : (($ke == 2) ? "0010017176057000000000" : '0' . $data['npwpsubkon'] . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', $data['npwpsubkon'])))) + 1)));
                $alamat = $ke == 1 ? $alamatifn : (($ke == 2) ? $alamatifn : datasupplier($data['id_rekanan'],'alamat'));
                $namaidentitas = $ke == 1 ? "INDONEPTUNE NET MANUFACTURING" : (($ke == 2) ? "INDONEPTUNE NET MANUFACTURING" : $data['namasubkon']);
            }
            $kodejenisapi = $ke == 2 ? "02" : "";
            $arrayke = [
                "seriEntitas" => (int) $serient,
                "kodeEntitas" => $kodeentitas,
                "kodeJenisIdentitas" => $kodejnent,
                "nomorIdentitas" => trim(str_replace('-', '', str_replace('.', '', $nomoridentitas))),
                "alamatEntitas" => $alamat,
                "namaEntitas" => trim($namaidentitas),
                "nibEntitas" => $nibidentitas,
                "kodeNegara" => "ID",
                "kodeStatus" => $status,
                "kodeJenisApi" => "02"
            ];
            if ($ke == 3) {
                $arrayke["nomorIjinEntitas"] = $data['noijin'];
                $arrayke["tanggalIjinEntitas"] =  $data['tglijin'];
            }
            if ($ke == 1) {
                $arrayke["nomorIjinEntitas"] = "1555/KM.4/2017";
                $arrayke["tanggalIjinEntitas"] = "2017-07-10";
            }
            array_push($arrayentitas, $arrayke);
        }
        $arraydokumen = [];
        $dokmen = $this->akbmodel->getdatadokumen($id);
        $no = 1;
        foreach ($dokmen->result_array() as $doku) {
            $arrayke = [
                "kodeDokumen" => $doku['kode_dokumen'],
                "nomorDokumen" => $doku['nomor_dokumen'],
                "seriDokumen" => $no++,
                "tanggalDokumen" => $doku['tgl_dokumen']
            ];
            array_push($arraydokumen, $arrayke);
        }
        $carangkut = $data['jns_angkutan'];
        switch ($carangkut) {
            case 2:
                $carangkut = "3";
                break;
            case 3:
                $carangkut = "4";
                break;
            case 4:
                $carangkut = "9";
                break;
        }
        $arrangkut = [];
        $arrayangkutan = [
            "idPengangkut" => "",
            "namaPengangkut" => trim($data['angkutan']),
            "nomorPengangkut" => $data['no_kendaraan'],
            "seriPengangkut" => 1,
            "kodeCaraAngkut" => $carangkut,
            // "kodeBendera" => $data['kode_negara']
        ];
        array_push($arrangkut, $arrayangkutan);
        $arrkemas = [];
        $arraykemasan = [
            "jumlahKemasan" => (int) $data['jml_kemasan'],
            "kodeJenisKemasan" => $data['kd_kemasan'],
            "merkKemasan" => "-",
            "seriKemasan" => 1
        ];
        array_push($arrkemas, $arraykemasan);
        $arraybarang = [];
        $datadet = $this->akbmodel->excellampiran261($id, $data['urutakb']);
        $no = 0;
        $jumlahfasilitas = 0;
        $pungutanbm = 0;
        $pungutanppn = 0;
        $pungutanpph = 0;
        foreach ($datadet->result_array() as $detx) {
            $no++;
            $jumlah = $detx['kodebc'] == 'KGM' ? $detx['kgs'] : $detx['pcs'];
            if ($jumlah == 0 && $detx['kodebc'] != 'KGM') {
                $jumlah = $detx['kgs'];
            } else {
                if ($jumlah == 0) {
                    $jumlah = $detx['kgs'];
                }
            }
            // $jumlah=0;
            $cif = getjumlahcifbom($id, $no)->row_array();
            $bahanbaku = $this->akbmodel->detailexcellampiran261($id, $no);
            $cifnya = 0;
            $cifrupiah = 0;
            $isiheader = $this->akbmodel->getdatabyid($id);
            $kurssekarang = getkurssekarang($isiheader['tgl_aju'])->row_array();
            foreach ($bahanbaku->result_array() as $det) {
                $asalbar = $det['jns_bc'] == 23 ? 1 : 2;
                $kursusd = $kurssekarang['usd'];
                $ndpbm = $det['mt_uang'] == '' || $det['mt_uang'] == 'IDR' ? 0 : $kurssekarang['usd'];
                $pembagi = $det['weight'] == 0 ? 1 : $det['weight'];
                switch ($det['mt_uang']) {
                    case 'JPY':
                        $jpy = $det['cif'] * $kurssekarang[strtolower($det['mt_uang'])];
                        $cif = $jpy / $kursusd;
                        break;
                    default:
                        $cif = $det['cif'];
                        break;
                }
                $cifnya += round(($cif / $pembagi) * $det['kgs'], 2);
                $cifrupiah += (($cif / $pembagi) * $ndpbm) * round($det['kgs'], 2);
                // $cifrupiah += round((($cif/$pembagi)*$det['kgs']),2)*$ndpbm;
            }
            $uraian = trim($detx['po']) != '' ? spekpo($detx['po'], $detx['item'], $detx['dis']) : namaspekbarang($detx['id_barang']);
            $hs = trim($detx['po']) == '' ? substr($detx['nohs'], 0, 8) : substr($detx['hsx'], 0, 8);
            $kodebc = str_contains($detx['nomor_dok'], 'NET/') ? 'KGM' : $detx['kodebc'];
            if (str_contains($data['nomor_inv'], 'NET/') || str_contains($data['nomor_inv'], 'RSC/') || str_contains($data['nomor_inv'], 'RSP/')) {
                $kodebc = 'KGM';
            } else {
                if (str_contains($detx['nomor_dok'], 'NET/')) {
                    $kodebc = 'KGM';
                } else {
                    if (str_contains($detx['nomor_dok'], 'RSC/')) {
                        $kodebc = 'KGM';
                    } else {
                        if (str_contains($detx['nomor_dok'], 'RSP/')) {
                            $kodebc = 'KGM';
                        }
                    }
                }
            }
            $arraykebarang = [
                "seriBarang" => $no,
                "cif" => (float) round($cifnya, 2),
                "cifRupiah" => round($cifrupiah, 2),
                "hargaEkspor" => 0,
                "hargaPenyerahan" => 0,
                "hargaPerolehan" => 0,
                "isiPerKemasan" => 0,
                "jumlahSatuan" => (float) $jumlah,
                "jumlahKemasan" => (float) $detx['jml_kemasan'],
                "kodeBarang" => formatsku($detx['po'], $detx['item'], $detx['dis'], $detx['id_barang']),
                "kodeAsalBarang" => "4",
                "kodeJenisKemasan" => $data['kd_kemasan'],
                "kodeNegaraAsal" => "ID",
                "kodeSatuanBarang" => $kodebc,
                "merk" => "-",
                "ndpbm" => (float) $kurs,
                "netto" => (float) round($detx['kgs'], 2),
                "spesifikasiLain" => "-",
                "tipe" => "-",
                "ukuran" => "-",
                "uraian" => $uraian,
                "volume" => 0,
                "nilaiDanaSawit" => 0,
                "kodeJenisEkspor" => "",
                "nilaiJasa" => 0,
                "posTarif" => $hs,
                "nilaiBarang" => 0,
                "kodeAsalBahanBaku" => "",
                "kodeDokumen" => "",
                "uangMuka" => 0
            ];
            $arr_bahanbaku = [];
            $nob = 0;
            foreach ($bahanbaku->result_array() as $databahanbaku) {
                $nob++;
                $asalbar = $databahanbaku['jns_bc'] == 23 ? "0" : "1";
                $kursusd = $kurssekarang['usd'];
                $ndpbm = $databahanbaku['mt_uang'] == '' || $databahanbaku['mt_uang'] == 'IDR' ? 0 : $kurssekarang['usd'];
                $pembagi = $databahanbaku['weight'] == 0 ? 1 : $databahanbaku['weight'];
                switch ($databahanbaku['mt_uang']) {
                    case 'JPY':
                        $jpy = $databahanbaku['cif'] * $kurssekarang[strtolower($det['mt_uang'])];
                        $cif = $jpy / $kursusd;
                        break;
                    default:
                        $cif = $databahanbaku['cif'];
                        break;
                }
                $cifnya = round(($cif / $pembagi) * $databahanbaku['kgs'], 2);
                // $cifrupiah = round((($cif/$pembagi)*$databahanbaku['kgs']),2)*$ndpbm;
                // $cifrupiah =(($cif/$pembagi)*$ndpbm)*round($databahanbaku['kgs'],2);
                $cifrupiah = $cifnya * $ndpbm;
                $barangbahanbaku = [
                    "seriBarang" => $no,
                    "seriBahanBaku" => $nob,
                    "kodeAsalBahanBaku" => $asalbar,
                    "posTarif" => substr($databahanbaku['nohs'], 0, 8),
                    "kodeBarang" => $databahanbaku['kode'],
                    "uraianBarang" => $databahanbaku['nama_barang'],
                    "merkBarang" => "-",
                    "tipeBarang" => "-",
                    "ukuranBarang" => "-",
                    "spesifikasiLainBarang" => "-",
                    "kodeSatuanBarang" => $databahanbaku['kodebc'],
                    "jumlahSatuan" => (float) round($databahanbaku['kgs'], 2),
                    "kodeDokAsal" => $databahanbaku['jns_bc'],
                    "kodeKantor" => "050500",
                    "kodeDokumen" => $databahanbaku['jns_bc'], // EX
                    "nomorDaftarDokAsal" => $databahanbaku['nomor_bc'],
                    "tanggalDaftarDokAsal" => $databahanbaku['tgl_bc'],
                    "ndpbm" => (float) $kurs,
                    "nomorDokumen" => trim($databahanbaku['nomor_aju']), //No AJU ASAL
                    "seriBarangDokAsal" => (int) $databahanbaku['seri_barang'], //SERI BARANG
                    "netto" => (float) $databahanbaku['kgs'],
                    "cif" => round($cifnya, 2),
                    "cifRupiah" => round($cifrupiah, 2),
                    "hargaPenyerahan" => 0,
                    "hargaPerolehan" => 0,
                    "isiPerKemasan" => "",
                    "flagTis" => "",
                    "nilaiJasa" => 0,
                    "seriIjin" => 0
                ];
                $arraybahanbakutarif = [];
                $tarifbm = 0;
                for ($ke = 1; $ke <= 3; $ke++) {
                    $kodepungut = $databahanbaku['jns_bc'] == '40' ? 'PPNLOKAL' : ($ke == 1 ? 'BM' : ($ke == 2 ? 'PPN' : 'PPH'));
                    $tarif = 0;
                    switch ($kodepungut) {
                        case 'PPNLOKAL':
                            $tarif = 11;
                            $ke = 4;
                            $jmltarif = 0;
                            break;
                        case 'BM':
                            if ($databahanbaku['bm'] > 0) {
                                $tarif = $databahanbaku['bm'];
                                $pungutanbm += $cifrupiah * ($tarif / 100);
                                $tarifbm = $pungutanbm;
                                $jmltarif = $cifrupiah * ($tarif / 100);
                            }
                            break;
                        case 'PPN':
                            if ($databahanbaku['ppn'] > 0) {
                                $tarif = $databahanbaku['ppn'];
                                $pungutanppn += ($tarifbm + $cifrupiah) * ($tarif / 100);
                                $jmltarif = ($tarifbm + $cifrupiah) * ($tarif / 100);
                            }
                            break;
                        case 'PPH':
                            if ($databahanbaku['pph'] > 0) {
                                $tarif = $databahanbaku['pph'];
                                $pungutanpph += ($tarifbm + $cifrupiah) * ($tarif / 100);
                                $jmltarif = ($tarifbm + $cifrupiah) * ($tarif / 100);
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                    $bahanbakutarif = [
                        "seriBarang" => $no,
                        "seriBahanBaku" => $nob,
                        "kodeAsalBahanBaku" => $asalbar,
                        "kodeJenisPungutan" => $kodepungut,
                        "kodeFasilitasTarif" => "8",
                        "kodeJenisTarif" => "1",
                        "tarif" => (float) $tarif,
                        "tarifFasilitas" => 100,
                        "nilaiBayar" => 0,
                        "nilaiFasilitas" => round($jmltarif, 2),
                        "kodeSatuanBarang" => $databahanbaku['kodebc'],
                        "nilaiSudahDilunasi" => 0,
                        "jumlahSatuan" => (float) round($databahanbaku['kgs'], 2),
                        "jumlahKemasan" => 0
                    ];
                    array_push($arraybahanbakutarif, $bahanbakutarif);
                }
                $barangbahanbaku['bahanBakuTarif'] = $arraybahanbakutarif;
                array_push($arr_bahanbaku, $barangbahanbaku);
            }
            $arraykebarang['bahanBaku'] = $arr_bahanbaku;
            array_push($arraybarang, $arraykebarang);
        }
        $arraypungutan = [];
        for ($ke = 1; $ke <= 3; $ke++) {
            $jenispungut = $ke == 1 ? 'BM' : ($ke == 2 ? 'PPN' : 'PPH');
            $jmlpungut = $ke == 1 ? $pungutanbm : ($ke == 2 ? $pungutanppn : $pungutanpph);
            $pungutan = [
                "idPungutan" => "",
                "kodeFasilitasTarif" => "8",
                "kodeJenisPungutan" => $jenispungut,
                "nilaiPungutan" => round((float) $jmlpungut, 2),
            ];
            array_push($arraypungutan, $pungutan);
        }
        $datakontrak = $this->akbmodel->getdatakontrak($data['id_kontrak'])->row_array();
        $arrayjaminan = [];
        $jaminan = [
            "idJaminan" => "",
            "kodeJenisJaminan" => "3",
            "nomorJaminan" => $datakontrak['nomor_ssb'],
            "tanggalJaminan" => $datakontrak['tgl_ssb'],
            "nilaiJaminan" => (float) $datakontrak['jml_ssb'],
            "penjamin" => $datakontrak['penjamin'] == NULL ? "" : $datakontrak['penjamin'],
            "tanggalJatuhTempo" => $datakontrak['tgl_akhir'],
            "nomorBpj" => $datakontrak['nomor_bpj'],
            "tanggalBpj" => $datakontrak['tgl_bpj']
        ];
        array_push($arrayjaminan, $jaminan);
        $jumlahfasilitas += ($detx['harga'] * $jumlah) * 0.11;
        // $arrayke['bahanbaku'] = $arr_bahanbaku;
        // array_push($arraybarang,$arrayke);
        // }

        $arrayheader['entitas'] = $arrayentitas;
        $arrayheader['dokumen'] = $arraydokumen;
        $arrayheader['pengangkut'] = $arrangkut;
        $arrayheader['kemasan'] = $arrkemas;
        $arrayheader['barang'] = $arraybarang;
        $arrayheader['pungutan'] = $arraypungutan;
        $arrayheader['jaminan'] = $arrayjaminan;
        // echo '<pre>'.json_encode($arrayheader)."</pre>";
        $this->kirim261($arrayheader, $id);
    }
    function kirimdatakeceisa25($id)
    {
        $data = $this->akbmodel->getdatabyid($id);
        $datakon = $this->akbmodel->getdatakontainer($id);
        $noaju = isikurangnol($data['jns_bc']) . '010017' . str_replace('-', '', $data['tgl_aju']) . $data['nomor_aju'];
        $kurs = $data['kurs_usd']; //$data['mtuang']==2 ? $data['kurs_usd'] : ($data['mtuang']==3 ? $data['kurs_yen'] : $data['kurs_idr']);
        $kurssekarang = getkurssekarang($data['tgl_aju'])->row_array();
        $arrayheader = [
            "asalData" => "S",
            "bruto" => (float) $data['bruto'],
            "cif" => (float) $data['cif'],
            "disclaimer" => "1",
            "hargaPenyerahan" => (float) $data['nilai_serah'],
            "idPengguna" => "",
            "jabatanTtd" => strtoupper($data['jabat_tg_jawab']),
            "jumlahKontainer" => $datakon->num_rows(),
            "kodeCaraBayar" => "1",
            "kodeDokumen" => $data['jns_bc'],
            "kodeJenisTpb" => "1",
            "kodeKantor" => "050500",
            "kodeLokasiBayar" => "1",
            "kodeTujuanPengiriman" => "5",
            "kodeValuta" => "USD", //$data['mt_uang'],
            "kotaTtd" => "BANDUNG",
            "namaTtd" => strtoupper($data['tg_jawab']),
            "ndpbm" => (float) $kurs,
            "netto" => (float) $data['netto'],
            "nomorAju" => $noaju,
            "seri" => 0,
            "tanggalAju" => $data['tgl_aju'],
            "tanggalTtd" => $data['tgl_aju'],
            "volume" => 0
        ];

        $arrayentitas = [];
        for ($ke = 1; $ke <= 3; $ke++) {
            $alamatifn = "JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01,\r\nDESA CANGKUANG 004/001 CANGKUANG,\r\nRANCAEKEK, BANDUNG, JAWA BARAT";
            $serient = $ke == 1 ? "3" : (($ke == 2) ? "7" : (($ke == 3) ? "8" : "13"));
            $kodeentitas = $ke == 1 ? "3" : (($ke == 2) ? "7" : (($ke == 3) ? "8" : "6"));
            $kodejnent = "6";
            if (datacustomer($data['id_buyer'], 'jns_pkp') != 1 && $ke == 3 && trim(datacustomer($data['id_buyer'], 'nik')) != '') {
                $nomiden = datacustomer($data['id_buyer'], 'nik');
                $kodejnent = "3";
            } else {
                $nomiden = datacustomer($data['id_buyer'], 'npwp');
            }
            $status = $ke == 2 ? "10" : "";
            $nibidentitas = $ke == 1 ? "9120011042693" : (($ke == 2) ? "" : "");
            $nomoridentitas = $ke == 1 ? "0010017176057000000000" : (($ke == 2) ? "0010017176057000000000" : $nomiden);
            $alamat = $ke == 1 ? $alamatifn : (($ke == 2) ? $alamatifn : datacustomer($data['id_buyer'], 'alamat'));
            $namaidentitas = $ke == 1 ? "INDONEPTUNE NET MANUFACTURING" : (($ke == 2) ? "INDONEPTUNE NET MANUFACTURING" : datacustomer($data['id_buyer'], 'nama_customer'));
            $kodejenisapi = $ke == 2 ? "02" : "";
            $arrayke = [
                "alamatEntitas" => $alamat,
                "kodeEntitas" => $kodeentitas,
                "kodeJenisIdentitas" => $kodejnent,
                "kodeJenisApi" => "02",
                "kodeNegara" => "ID",
                "kodeStatus" => $status,
                "namaEntitas" => trim($namaidentitas),
                "nomorIdentitas" => trim(str_replace('-', '', str_replace('.', '', $nomoridentitas))),
                "nibEntitas" => $nibidentitas,
                "seriEntitas" => (int) $serient,
                "niperEntitas" => ""
            ];
            if ($ke == 3) {
                $arrayke["nomorIjinEntitas"] = $data['noijin'];
                $arrayke["tanggalIjinEntitas"] =  $data['tglijin'];
            }
            if ($ke == 1) {
                $arrayke["nomorIjinEntitas"] = "1555/KM.4/2017";
                $arrayke["tanggalIjinEntitas"] = "2017-07-10";
            }
            array_push($arrayentitas, $arrayke);
        }
        $arraydokumen = [];
        $dokmen = $this->akbmodel->getdatadokumen($id);
        $no = 1;
        foreach ($dokmen->result_array() as $doku) {
            $arrayke = [
                "idDokumen" => "",
                "kodeDokumen" => $doku['kode_dokumen'],
                "nomorDokumen" => $doku['nomor_dokumen'],
                "seriDokumen" => (int) $no++,
                "tanggalDokumen" => $doku['tgl_dokumen']
            ];
            array_push($arraydokumen, $arrayke);
        }
        $carangkut = $data['jns_angkutan'];
        switch ($carangkut) {
            case 2:
                $carangkut = "3";
                break;
            case 3:
                $carangkut = "4";
                break;
            case 4:
                $carangkut = "9";
                break;
        }
        $arrangkut = [];
        $arrayangkutan = [
            "idPengangkut" => "",
            "namaPengangkut" => trim($data['angkutan']),
            "nomorPengangkut" => $data['no_kendaraan'],
            "seriPengangkut" => 1,
            "kodeCaraAngkut" => $carangkut,
            // "kodeBendera" => $data['kode_negara']
        ];
        array_push($arrangkut, $arrayangkutan);
        $arrkemas = [];
        $arraykemasan = [
            "jumlahKemasan" => (int) $data['jml_kemasan'],
            "kodeJenisKemasan" => $data['kd_kemasan'],
            "merkKemasan" => "-",
            "seriKemasan" => 1
        ];
        array_push($arrkemas, $arraykemasan);
        $arraybarang = [];
        $datadet = $this->akbmodel->getbarangdetail($id);
        $no = 0;
        $jumlahfasilitas = 0;
        $pungutanbm = 0;
        $pungutanppn = 0;
        $pungutanppnlokal = 0;
        $pungutanpph = 0;
        foreach ($datadet->result_array() as $detx) {
            $no++;
            $jumlah = $detx['kodebc'] == 'KGM' ? $detx['kgs'] : $detx['pcs'];
            if ($jumlah == 0 && $detx['kodebc'] != 'KGM') {
                $jumlah = $detx['kgs'];
            } else {
                if ($jumlah == 0) {
                    $jumlah = $detx['kgs'];
                }
            }

            $uraian = trim($detx['po']) != '' ? spekdom($detx['po'], $detx['item'], $detx['dis']) : namaspekbarang($detx['id_barang']);
            // $hs = trim($detx['po']) == '' ? substr($detx['nohs'], 0, 8) : substr($detx['hsx'], 0, 8);
            // $kodebc = str_contains($detx['nomor_dok'], 'NET/') ? 'KGM' : $detx['kodebc'];
            $kodebarang = trim($detx['po']) != '' ? viewsku($detx['po'], $detx['item'], $detx['dis']) : $detx['kode'];
            $arraykebarang = [
                "cif" => (float) round($detx['cifnya'], 2),
                "cifRupiah" => round($detx['cifnya'] * $detx['ndpbm'], 2),
                "diskon" => 0,
                "fob" => 0,
                "freight" => 0,
                "hargaEkspor" => 0,
                "hargaPenyerahan" => (float) round($detx['harga'] - $detx['sp_disc'] - $detx['cash_disc'], 2),
                "hargaPerolehan" => 0,
                "isiPerKemasan" => 0,
                "jumlahKemasan" => (float) $detx['pcs'],
                "jumlahSatuan" => (float) $detx['kgs'],
                "kodeBarang" => $kodebarang,
                "kodeDokAsal" => "",
                "kodeGunaBarang" => "3",
                "kodeJenisKemasan" => "BL",
                "kodeKategoriBarang" => "1",
                "kodeKondisiBarang" =>  "1",
                "kodePerhitungan" => "0",
                "kodeSatuanBarang" => $detx['kodebc'],
                "merk" => "-",
                "ndpbm" => (float) $detx['ndpbm'],
                "netto" => (float) round($detx['kgs'], 2),
                "nilaiBarang" => 0,
                "posTarif" => trim($detx['po']) != '' ? trim($detx['hs']) : trim($detx['nohs']),
                "seriBarang" => (int) $detx['seri_barang'],
                "spesifikasiLain" => "-",
                "tipe" => "-",
                "ukuran" => "-",
                "uraian" => htmlspecialchars_decode($uraian),
                "barangDokumen" => [],
                "barangTarif" => []
            ];
            $arr_bahanbaku = [];
            $nob = 0;
            $bahanbaku = $this->akbmodel->getdetailbahanbaku($detx['id_header'], $detx['seri_barang']);
            foreach ($bahanbaku->result_array() as $bahanbaku) {
                $nob++;
                $asalbar = $bahanbaku['jns_bc'] == 23 ? "0" : "1";
                $kursusd = $kurssekarang['usd'];
                $ndpbm = $bahanbaku['ndpbm'];
                $cifrupiah = $bahanbaku['hamat_cif'] * $ndpbm;
                $hrgserah = $bahanbaku['jns_bc'] == 23 ? (float) $bahanbaku['hamat_cif'] : (float) $bahanbaku['hargaperolehan'];
                $barangbahanbaku = [
                    "cif" => (float) round($bahanbaku['cif'], 2),
                    "cifRupiah" => (float) round($bahanbaku['cif'] * $bahanbaku['ndpbm'], 2),
                    "hargaPenyerahan" => $hrgserah,
                    "hargaPerolehan" => $hrgserah,
                    "jumlahSatuan" => (float) $bahanbaku['kgs'],
                    "kodeAsalBahanBaku" => $asalbar,
                    "kodeBarang" => $bahanbaku['kode'],
                    "kodeDokAsal" => $bahanbaku['jns_bc'],
                    "kodeKantor" => "050500",
                    "kodeSatuanBarang" => $bahanbaku['kodebc'],
                    "merkBarang" => "-",
                    "ndpbm" => 0,
                    "nomorAjuDokAsal" => str_replace('-', '', $bahanbaku['nomor_aju']),
                    "nomorDaftarDokAsal" => $bahanbaku['nomor_bc'],
                    "posTarif" => substr($bahanbaku['nohs'], 0, 8),
                    "seriBahanBaku" => $nob,
                    "seriBarang" => $no,
                    "seriBarangDokAsal" => (int) $bahanbaku['hamat_seri'],
                    "seriIjin" => 0,
                    "spesifikasiLainBarang" => "-",
                    "tanggalDaftarDokAsal" => $bahanbaku['tgl_bc'],
                    "tipeBarang" => "-",
                    "ukuranBarang" => "-",
                    "uraianBarang" => $bahanbaku['nama_barang'],
                ];
                $arraybahanbakutarif = [];
                $tarifbm = 0;
                for ($ke = 1; $ke <= 3; $ke++) {
                    $kodepungut = $bahanbaku['jns_bc'] == '40' ? 'PPNLOKAL' : ($ke == 1 ? 'BM' : ($ke == 2 ? 'PPN' : 'PPH'));
                    $tarif = 0;
                    $ada = 0;
                    switch ($kodepungut) {
                        case 'PPNLOKAL':
                            $tarif = 11;
                            $ke = 4;
                            $pungutanppnlokal += $bahanbaku['ppn_rupiah'];
                            $jmltarif = $bahanbaku['ppn_rupiah'];
                            $ada = 1;
                            break;
                        case 'BM':
                            if ($bahanbaku['bm'] > 0) {
                                $tarif = 5; //$bahanbaku['bm'];
                                $pungutanbm += $bahanbaku['bm_rupiah'];
                                $tarifbm = $bahanbaku['bm_rupiah'];
                                $jmltarif = $bahanbaku['bm_rupiah'];
                                $ada = 1;
                            }
                            break;
                        case 'PPN':
                            if ($bahanbaku['ppn'] > 0) {
                                $tarif = $bahanbaku['ppn'];
                                $pungutanppn += $bahanbaku['ppn_rupiah'];
                                $jmltarif = $bahanbaku['ppn_rupiah'];
                                $ada = 1;
                            }
                            break;
                        case 'PPH':
                            if ($bahanbaku['pph'] > 0) {
                                $tarif = $bahanbaku['pph'];
                                $pungutanpph += $bahanbaku['pph_rupiah'];
                                $jmltarif = $bahanbaku['pph_rupiah'];
                                $ada = 1;
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                    if ($ada == 1) {
                        $bahanbakutarif = [
                            "kodeJenisTarif" => "1",
                            "jumlahSatuan" => (float) round($bahanbaku['kgs'], 2),
                            "kodeFasilitasTarif" => "1",
                            "kodeJenisPungutan" => $kodepungut,
                            "nilaiBayar" => (float) $jmltarif,
                            "nilaiFasilitas" => 0,
                            "nilaiSudahDilunasi" => 1,
                            "seriBahanBaku" => $nob,
                            "tarif" => (float) $tarif,
                            "tarifFasilitas" => 100,
                        ];
                        array_push($arraybahanbakutarif, $bahanbakutarif);
                    }
                }
                $barangbahanbaku['bahanBakuTarif'] = $arraybahanbakutarif;
                array_push($arr_bahanbaku, $barangbahanbaku);
            }
            $arraykebarang['bahanBaku'] = $arr_bahanbaku;
            array_push($arraybarang, $arraykebarang);
        }
        $arraypungutan = [];
        for ($ke = 1; $ke <= 4; $ke++) {
            switch ($ke) {
                case 1:
                    $jenispungut = 'BM';
                    $jmlpungut = $pungutanbm;
                    break;
                case 2:
                    $jenispungut = 'PPN';
                    $jmlpungut = $pungutanppn;
                    break;
                case 3:
                    $jenispungut = 'PPH';
                    $jmlpungut = $pungutanpph;
                    break;
                case 4:
                    $jenispungut = 'PPNLOKAL';
                    $jmlpungut = $pungutanppnlokal;
                    break;
                default:
                    # code...
                    break;
            }
            $pungutan = [
                "idPungutan" => "",
                "kodeFasilitasTarif" => "1",
                "kodeJenisPungutan" => $jenispungut,
                "nilaiPungutan" => round((float) $jmlpungut, 2),
            ];
            array_push($arraypungutan, $pungutan);
        }
        // $datakontrak = $this->akbmodel->getdatakontrak($data['id_kontrak'])->row_array();
        // $arrayjaminan = [];
        // $jaminan = [
        //     "idJaminan" => "",
        //     "kodeJenisJaminan" => "3",
        //     "nomorJaminan" => $datakontrak['nomor_ssb'],
        //     "tanggalJaminan" => $datakontrak['tgl_ssb'],
        //     "nilaiJaminan" => (float) $datakontrak['jml_ssb'],
        //     "penjamin" => $datakontrak['penjamin'] == NULL ? "" : $datakontrak['penjamin'],
        //     "tanggalJatuhTempo" => $datakontrak['tgl_akhir'],
        //     "nomorBpj" => $datakontrak['nomor_bpj'],
        //     "tanggalBpj" => $datakontrak['tgl_bpj']
        // ];
        // array_push($arrayjaminan, $jaminan);
        // $jumlahfasilitas += ($detx['harga'] * $jumlah) * 0.11;
        // $arrayke['bahanbaku'] = $arr_bahanbaku;
        // array_push($arraybarang,$arrayke);
        // }
        $arraykontainer = [];
        $arrayheader['entitas'] = $arrayentitas;
        $arrayheader['dokumen'] = $arraydokumen;
        $arrayheader['pengangkut'] = $arrangkut;
        $arrayheader['kemasan'] = $arrkemas;
        $arrayheader['barang'] = $arraybarang;
        $arrayheader['pungutan'] = $arraypungutan;
        $arrayheader['kontainer'] = $arraykontainer;
        // $arrayheader['jaminan'] = $arrayjaminan;
        // echo '<pre>'.json_encode($arrayheader)."</pre>";
        $this->kirim30($arrayheader, $id);
    }
    function kirimdatakeceisa41($id)
    {
        $data = $this->akbmodel->getdatabyid($id);
        $datakon = $this->akbmodel->getdatakontainer($id);
        $noaju = isikurangnol($data['jns_bc']) . '010017' . str_replace('-', '', $data['tgl_aju']) . $data['nomor_aju'];
        $kurs = $data['kurs_usd']; //$data['mtuang']==2 ? $data['kurs_usd'] : ($data['mtuang']==3 ? $data['kurs_yen'] : $data['kurs_idr']);
        $kurssekarang = getkurssekarang($data['tgl_aju'])->row_array();
        $arrayheader = [
            "asalData" => "S",
            "asuransi" => 0,
            "biayaTambahan" => 0,
            "biayaPengurang" => 0,
            "bruto" => (float) $data['bruto'],
            "cif" => (float) $data['cif'],
            "disclaimer" => "1",
            "freight" => 0,
            "hargaPenyerahan" => (float) $data['nilai_serah'],
            "jabatanTtd" => strtoupper($data['jabat_tg_jawab']),
            "jumlahKontainer" => $datakon->num_rows(),
            "kodeDokumen" => $data['jns_bc'],
            "kodeJenisTpb" => "1",
            "kodeKantor" => "050500",
            "kodeLokasiBayar" => "1",
            "kodePembayar" => "3",
            "kodeTujuanPengiriman" => "5",
            "kotaTtd" => "BANDUNG",
            "namaTtd" => strtoupper($data['tg_jawab']),
            "netto" => (float) $data['netto'],
            "nilaiBarang" => 0,
            "nomorAju" => $noaju,
            "seri" => 0,
            "tanggalAju" => $data['tgl_aju'],
            "tanggalTtd" => $data['tgl_aju'],
            "userPortal" => "",
            "volume" => 0
        ];

        $arrayentitas = [];
        for ($ke = 1; $ke <= 3; $ke++) {
            // $alamatifn = "JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01,\r\nDESA CANGKUANG 004/001 CANGKUANG,\r\nRANCAEKEK, BANDUNG, JAWA BARAT";
            $alamatifn = "JL RAYA BANDUNG-GARUT KM. 25 RT.000 \r\nRW.000, CANGKUANG, RANCAEKEK, KABUPATEN BANDUNG, JAWA BARAT";
            $serient = $ke == 1 ? "3" : (($ke == 2) ? "7" : (($ke == 3) ? "8" : "13"));
            $kodeentitas = $ke == 1 ? "3" : (($ke == 2) ? "7" : (($ke == 3) ? "8" : "6"));
            $kodejnent = "6";
            if ($data['jns_bc'] == 41 && $data['bc_makloon'] == 1 && $ke == 3) {
                $nomiden = '0' . trim(datadepartemen($data['dept_tuju'], 'npwp')) . str_repeat('0', 21 - strlen(trim(datadepartemen($data['dept_tuju'], 'npwp')))); //0018909523444000
                $kodejnent = "6";
            } else {
                if (datacustomer($data['id_buyer'], 'jns_pkp') != 1 && $ke == 3 && trim(datacustomer($data['id_buyer'], 'nik')) != '') {
                    $nomiden = datacustomer($data['id_buyer'], 'nik');
                    $kodejnent = "3";
                } else {
                    $nomiden = datacustomer($data['id_buyer'], 'npwp');
                }
            }
            $status = $ke == 3 ? "10" : "5";
            $nibidentitas = $ke == 1 ? "9120011042693" : (($ke == 2) ? "" : "");
            $nomoridentitas = $ke == 1 ? "0010017176057000000000" : (($ke == 2) ? "0010017176057000000000" : trim($nomiden));
            if ($data['jns_bc'] == 41 && $data['bc_makloon'] == 1) {
                $alamat = $ke == 1 ? $alamatifn : (($ke == 2) ? $alamatifn : datadepartemen($data['dept_tuju'], 'alamat_subkon'));
                $namaidentitas = $ke == 1 ? "INDONEPTUNE NET MANUFACTURING" : (($ke == 2) ? "INDONEPTUNE NET MANUFACTURING" : datadepartemen($data['dept_tuju'], 'nama_subkon'));
            } else {
                $alamat = $ke == 1 ? $alamatifn : (($ke == 2) ? $alamatifn : datacustomer($data['id_buyer'], 'alamat'));
                $namaidentitas = $ke == 1 ? "INDONEPTUNE NET MANUFACTURING" : (($ke == 2) ? "INDONEPTUNE NET MANUFACTURING" : datacustomer($data['id_buyer'], 'nama_customer'));
            }
            $kodejenisapi = $ke == 2 ? "02" : "";
            $arrayke = [
                "alamatEntitas" => $alamat,
                "kodeEntitas" => $kodeentitas,
                "kodeJenisIdentitas" => $kodejnent,
                "kodeJenisApi" => "02",
                "kodeNegara" => "ID",
                "kodeStatus" => $status,
                "namaEntitas" => trim($namaidentitas),
                "nomorIdentitas" => trim(str_replace('-', '', str_replace('.', '', $nomoridentitas))),
                "nibEntitas" => $nibidentitas,
                "seriEntitas" => (int) $serient,
                "niperEntitas" => ""
            ];
            if ($ke == 1 || $ke == 2) {
                $arrayke["nomorIjinEntitas"] = "1555/KM.4/2017";
                $arrayke["tanggalIjinEntitas"] = "2017-07-10";
            }
            array_push($arrayentitas, $arrayke);
        }
        $arraydokumen = [];
        $dokmen = $this->akbmodel->getdatadokumen($id);
        $no = 1;
        foreach ($dokmen->result_array() as $doku) {
            $arrayke = [
                "kodeDokumen" => $doku['kode_dokumen'],
                "nomorDokumen" => $doku['nomor_dokumen'],
                "seriDokumen" => $no++,
                "tanggalDokumen" => $doku['tgl_dokumen']
            ];
            array_push($arraydokumen, $arrayke);
        }
        $carangkut = $data['jns_angkutan'];
        switch ($carangkut) {
            case 2:
                $carangkut = "3";
                break;
            case 3:
                $carangkut = "4";
                break;
            case 4:
                $carangkut = "9";
                break;
        }
        $arrangkut = [];
        $arrayangkutan = [
            "idPengangkut" => 1,
            "namaPengangkut" => trim($data['angkutan']),
            "nomorPengangkut" => $data['no_kendaraan'],
            "seriPengangkut" => "1",
            "kodeCaraAngkut" => $carangkut,
            // "kodeBendera" => $data['kode_negara']
        ];
        array_push($arrangkut, $arrayangkutan);
        $arrkemas = [];
        $arraykemasan = [
            "jumlahKemasan" => (int) $data['jml_kemasan'],
            "kodeJenisKemasan" => $data['kd_kemasan'],
            "merkKemasan" => "-",
            "seriKemasan" => 1
        ];
        array_push($arrkemas, $arraykemasan);
        $arraybarang = [];
        $datadet = $this->akbmodel->getbarangdetail($id);
        $no = 0;
        $jumlahfasilitas = 0;
        $pungutanbm = 0;
        $pungutanppn = 0;
        $pungutanppnlokal = 0;
        $pungutanpph = 0;
        foreach ($datadet->result_array() as $detx) {
            $no++;
            $jumlah = $detx['kodebc'] == 'KGM' ? $detx['kgs'] : $detx['pcs'];
            if ($jumlah == 0 && $detx['kodebc'] != 'KGM') {
                $jumlah = $detx['kgs'];
            } else {
                if ($jumlah == 0) {
                    $jumlah = $detx['kgs'];
                }
            }

            $uraian = trim($detx['po']) != '' ? spekpo($detx['po'], $detx['item'], $detx['dis']) : namaspekbarang($detx['id_barang']);
            // $hs = trim($detx['po']) == '' ? substr($detx['nohs'], 0, 8) : substr($detx['hsx'], 0, 8);
            // $kodebc = str_contains($detx['nomor_dok'], 'NET/') ? 'KGM' : $detx['kodebc'];
            $kodebarang = trim($detx['po']) != '' ? viewsku($detx['po'], $detx['item'], $detx['dis']) : $detx['kode'];
            $arraykebarang = [
                "cif" => (float) round($detx['cifnya'], 2),
                "cifRupiah" => round($detx['cifnya'] * $detx['ndpbm'], 2),
                "hargaEkspor" => 0,
                "hargaPenyerahan" => (float) round($detx['harga'], 2),
                "hargaPerolehan" => 0,
                "isiPerKemasan" => 0,
                "jumlahKemasan" => (float) $detx['qty'],
                "jumlahSatuan" => (float) $detx['pcs'],
                "kodeAsalBahanBaku" => "1",
                "kodeBarang" => $kodebarang,
                "kodeDokumen" => "",
                "kodeJenisKemasan" => "BL",
                "kodeSatuanBarang" => $detx['kodebc'],
                "merk" => "-",
                "ndpbm" => (float) $detx['ndpbm'],
                "netto" => (float) round($detx['kgs'], 2),
                "nilaiBarang" => 0,
                "posTarif" => trim($detx['nohs']),
                "seriBarang" => (int) $detx['seri_barang'],
                "spesifikasiLain" => "-",
                "tipe" => "-",
                "ukuran" => "-",
                "uraian" => htmlspecialchars_decode($uraian),
                "volume" => 0
            ];
            $arr_bahanbaku = [];
            $nob = 0;
            $bahanbaku = $this->akbmodel->getdetailbahanbaku($detx['id_header'], $detx['seri_barang']);
            foreach ($bahanbaku->result_array() as $bahanbaku) {
                $nob++;
                $asalbar = $bahanbaku['jns_bc'] == 23 ? "0" : "1";
                $kursusd = $kurssekarang['usd'];
                $ndpbm = $bahanbaku['ndpbm'];
                $cifrupiah = $bahanbaku['hamat_cif'] * $ndpbm;
                $hrgserah = $bahanbaku['jns_bc'] == 23 ? (float) $bahanbaku['hamat_cif'] : (float) $bahanbaku['hargaperolehan'];
                $barangbahanbaku = [
                    "cif" => 0,
                    "cifRupiah" => 0,
                    "hargaPenyerahan" => 0,
                    "hargaPerolehan" => 0,
                    "jumlahSatuan" => (float) $bahanbaku['kgs'],
                    "kodeSatuanBarang" => $bahanbaku['kodebc'],
                    "kodeAsalBahanBaku" => $asalbar,
                    "kodeBarang" => $bahanbaku['kode'],
                    "kodeDokAsal" => trim($bahanbaku['jns_bc']),
                    "kodeDokumen" => trim($bahanbaku['jns_bc']),
                    "kodeKantor" => "050500",
                    "ndpbm" => 0,
                    "netto" => (float) $detx['kgs'],
                    "nilaiJasa" => 0,
                    "nomorAjuDokAsal" => str_replace('-', '', $bahanbaku['nomor_aju']),
                    "nomorDaftarDokAsal" => $bahanbaku['nomor_bc'],
                    "posTarif" => substr($bahanbaku['nohs'], 0, 8),
                    "seriBahanBaku" => $nob,
                    "seriBarang" => $no,
                    "seriBarangDokAsal" => (int) $bahanbaku['hamat_seri'],
                    "seriIjin" => 0,
                    "tanggalDaftarDokAsal" => $bahanbaku['tgl_bc'],
                    "tipeBarang" => "-",
                    "ukuranBarang" => "-",
                    "uraianBarang" => $bahanbaku['nama_barang'],
                ];
                $arraybahanbakutarif = [];
                $tarifbm = 0;
                for ($ke = 1; $ke <= 3; $ke++) {
                    $kodepungut = $bahanbaku['jns_bc'] == '40' ? 'PPNLOKAL' : ($ke == 1 ? 'BM' : ($ke == 2 ? 'PPN' : 'PPH'));
                    $tarif = 0;
                    $ada = 0;
                    switch ($kodepungut) {
                        case 'PPNLOKAL':
                            $tarif = 11;
                            $ke = 4;
                            $pungutanppnlokal += $bahanbaku['ppn_rupiah'];
                            $jmltarif = $bahanbaku['ppn_rupiah'];
                            $ada = 1;
                            break;
                        case 'BM':
                            if ($bahanbaku['bm'] > 0) {
                                $tarif = $bahanbaku['bm'];
                                $pungutanbm += $bahanbaku['bm_rupiah'];
                                $tarifbm = $bahanbaku['bm_rupiah'];
                                $jmltarif = $bahanbaku['bm_rupiah'];
                                $ada = 1;
                            }
                            break;
                        case 'PPN':
                            if ($bahanbaku['ppn'] > 0) {
                                $tarif = $bahanbaku['ppn'];
                                $pungutanppn += $bahanbaku['ppn_rupiah'];
                                $jmltarif = $bahanbaku['ppn_rupiah'];
                                $ada = 1;
                            }
                            break;
                        case 'PPH':
                            if ($bahanbaku['pph'] > 0) {
                                $tarif = $bahanbaku['pph'];
                                $pungutanpph += $bahanbaku['pph_rupiah'];
                                $jmltarif = $bahanbaku['pph_rupiah'];
                                $ada = 1;
                            }
                            break;
                        default:
                            # code...
                            break;
                    }
                    if ($ada == 1) {
                        $bahanbakutarif = [
                            "kodeJenisTarif" => "1",
                            "jumlahSatuan" => (float) round($bahanbaku['kgs'], 2),
                            "kodeFasilitasTarif" => "1",
                            "kodeJenisPungutan" => $kodepungut,
                            "nilaiBayar" => (float) $jmltarif,
                            "nilaiFasilitas" => 0,
                            "nilaiSudahDilunasi" => 0,
                            "seriBahanBaku" => $nob,
                            "tarif" => (float) $tarif,
                            "tarifFasilitas" => 100,
                        ];
                        array_push($arraybahanbakutarif, $bahanbakutarif);
                    }
                }
                $barangbahanbaku['bahanBakuTarif'] = $arraybahanbakutarif;
                array_push($arr_bahanbaku, $barangbahanbaku);
            }
            $arraykebarang['bahanBaku'] = $arr_bahanbaku;
            array_push($arraybarang, $arraykebarang);
        }
        $arraypungutan = [];
        for ($ke = 1; $ke <= 4; $ke++) {
            switch ($ke) {
                case 1:
                    $jenispungut = 'BM';
                    $jmlpungut = $pungutanbm;
                    break;
                case 2:
                    $jenispungut = 'PPN';
                    $jmlpungut = $pungutanppn;
                    break;
                case 3:
                    $jenispungut = 'PPH';
                    $jmlpungut = $pungutanpph;
                    break;
                case 4:
                    $jenispungut = 'PPNLOKAL';
                    $jmlpungut = $pungutanppnlokal;
                    break;
                default:
                    # code...
                    break;
            }
            $pungutan = [
                "idPungutan" => "",
                "kodeFasilitasTarif" => "1",
                "kodeJenisPungutan" => $jenispungut,
                "nilaiPungutan" => round((float) $jmlpungut, 2),
            ];
            array_push($arraypungutan, $pungutan);
        }
        // $datakontrak = $this->akbmodel->getdatakontrak($data['id_kontrak'])->row_array();
        // $arrayjaminan = [];
        // $jaminan = [
        //     "idJaminan" => "",
        //     "kodeJenisJaminan" => "3",
        //     "nomorJaminan" => $datakontrak['nomor_ssb'],
        //     "tanggalJaminan" => $datakontrak['tgl_ssb'],
        //     "nilaiJaminan" => (float) $datakontrak['jml_ssb'],
        //     "penjamin" => $datakontrak['penjamin'] == NULL ? "" : $datakontrak['penjamin'],
        //     "tanggalJatuhTempo" => $datakontrak['tgl_akhir'],
        //     "nomorBpj" => $datakontrak['nomor_bpj'],
        //     "tanggalBpj" => $datakontrak['tgl_bpj']
        // ];
        // array_push($arrayjaminan, $jaminan);
        // $jumlahfasilitas += ($detx['harga'] * $jumlah) * 0.11;
        // $arrayke['bahanbaku'] = $arr_bahanbaku;
        // array_push($arraybarang,$arrayke);
        // }
        $arraykontainer = [];
        $arrayheader['entitas'] = $arrayentitas;
        $arrayheader['dokumen'] = $arraydokumen;
        $arrayheader['pengangkut'] = $arrangkut;
        $arrayheader['kemasan'] = $arrkemas;
        $arrayheader['barang'] = $arraybarang;
        $arrayheader['pungutan'] = $arraypungutan;
        $arrayheader['kontainer'] = $arraykontainer;
        // $arrayheader['jaminan'] = $arrayjaminan;
        // echo '<pre>'.json_encode($arrayheader)."</pre>";
        $this->kirim30($arrayheader, $id);
    }
    public function kirim30($data, $id)
    {
        $token = $this->akbmodel->gettoken();
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $token,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/openapi/document');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $databalik = json_decode($result, true);
        // print_r($databalik);
        if ($databalik['status'] == 'OK') {
            $this->helpermodel->isilog("Kirim dokumen CEISA 40 BERHASIL" . $data['nomorAju']);
            $this->session->set_flashdata('errorsimpan', 2);
            $this->session->set_flashdata('pesanerror', $databalik['message']);
            $this->akbmodel->updatesendceisa($id);
            $url = base_url() . 'akb/isidokbc/' . $id;
            redirect($url);
        } else {
            // print_r($databalik);
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', $databalik['message'][0] . '[EXCEPTION]' . $databalik['exception']);
            $url = base_url() . 'akb/isidokbc/' . $id;
            redirect($url);
        }
    }
    public function kirim261dummy($data, $id)
    {
        $this->db->trans_start();

        $this->db->select("tb_detail.*");
        $this->db->from('tb_detail');
        $this->db->where('id_akb', $id);
        $this->db->group_by('id_header');
        $hasil = $this->db->get();

        // foreach ($hasil->row_array() as $val) {
        //     $this->db->where('id',$val['id_header']);
        //     $this->db->update('ok_tuju',1);
        // }

        $this->db->where('id', $id);
        $this->db->update('tb_header', ['send_ceisa' => 1]);

        $this->db->trans_complete();
    }
    public function kirim261($data, $id)
    {
        $token = $this->akbmodel->gettoken();
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer " . $token,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/openapi/document');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $databalik = json_decode($result, true);
        // print_r($databalik);
        if ($databalik['status'] == 'OK') {
            $this->helpermodel->isilog("Kirim dokumen CEISA 40 - 261 BERHASIL" . $data['nomorAju']);
            $this->session->set_flashdata('errorsimpan', 2);
            $this->session->set_flashdata('pesanerror', $databalik['message']);
            $this->akbmodel->updatesendceisa($id);
            $url = base_url() . 'akb/isidokbc/' . $id . '/1';
            redirect($url);
        } else {
            // print_r($databalik);
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', $databalik['message'][0] . '[EXCEPTION]' . $databalik['exception']);
            $url = base_url() . 'akb/isidokbc/' . $id . '/1';
            redirect($url);
        }
    }

    public function getnomoraju()
    {
        $jns = $_POST['jns'];
        $hasil = $this->ibmodel->getnomoraju($jns);
        echo json_encode($hasil);
    }
    public function getdoklampiran()
    {
        $id = $_POST['id'];
        $bc = $_POST['bc'];
        $query = $this->ibmodel->getdatadokumen($id);
        $arrdok = [];
        foreach ($query->result_array() as $que) {
            array_push($arrdok, $que['kode_dokumen']);
        }
        $hasil = 1;
        if ($bc == 40) {
            if (count($arrdok) > 0) {
                $hasil = 1;
            } else {
                $hasil = 'Lengkapi Lampiran Dokumen';
            }
        }
        if ($bc == 23) {
            if (count($arrdok) > 0) {
                if (in_array('380', $arrdok) && (in_array('740', $arrdok) || in_array('705', $arrdok))) {
                    $hasil = 1;
                } else {
                    $hasil = 'Dokumen Invoice, BL/AWB Belum di input';
                }
            } else {
                $hasil = 'Lengkapi Lampiran Dokumen';
            }
        }
        echo $hasil;
    }
    public function tambahkelampiran($id, $mode)
    {
        $inv =  $this->akbmodel->exceljaminan261($id);
        foreach ($inv->result_array() as $lampiran) {
            // if($lampiran['jns_bc']=='23'):
            $data = [
                'kode_dokumen' => $lampiran['jns_bc'],
                'nomor_dokumen' => $lampiran['nomor_bc'],
                'tgl_dokumen' => $lampiran['tgl_bc'],
                'id_header' => $id
            ];
            $this->db->insert('lampiran', $data);
            // endif;
        }
        $url = base_url() . 'akb/isidokbc/' . $id . '/1';
        redirect($url);
    }
    //End IB Controller

    function cetakqr2($isi, $id)
    {
        $tempdir = "temp/";
        $namafile = $id;
        $codeContents = $isi;
        QRcode::png($codeContents, $tempdir . $namafile . '.png', QR_ECLEVEL_L, 4, 1);
        return $tempdir . $namafile;
    }
    public function cetakbon($id)
    {
        $pdf = new PDF('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        // $pdf->setMargins(5,5,5);
        $pdf->AddFont('Lato', '', 'Lato-Regular.php');
        $pdf->AddFont('Latob', '', 'Lato-Bold.php');
        // $pdf->SetFillColor(7,178,251);
        $pdf->SetFont('Latob', '', 12);
        // $isi = $this->jualmodel->getrekap();
        $pdf->SetFillColor(205, 205, 205);
        $pdf->AddPage();
        $pdf->Image(base_url() . 'assets/image/ifnLogo.png', 14, 10, 22);
        $pdf->Cell(30, 18, '', 1);
        $pdf->SetFont('Latob', '', 18);
        $pdf->Cell(120, 18, 'BON PERPINDAHAN', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->Cell(14, 6, 'No Dok', 'T');
        $pdf->Cell(2, 6, ':', 'T');
        $pdf->Cell(24, 6, 'FM-GD-05', 'TR');
        $pdf->ln(6);
        $pdf->Cell(150, 6, '', 0);
        $pdf->Cell(14, 6, 'Revisi', 'T');
        $pdf->Cell(2, 6, ':', 'T');
        $pdf->Cell(24, 6, '1', 'TR');
        $pdf->ln(6);
        $pdf->Cell(150, 6, '', 0);
        $pdf->Cell(14, 6, 'Tanggal', 'TB');
        $pdf->Cell(2, 6, ':', 'TB');
        $pdf->Cell(24, 6, '11-04-2007', 'TRB');
        $pdf->ln(6);
        $pdf->Cell(190, 1, '', 1, 0, '', 1);
        $pdf->ln(1);
        $header = $this->out_model->getdatabyid($id);
        $isi = 'Nobon ' . $header['nomor_dok'] . "\r\n" . 'Dikeluarkan Oleh : ' . datauser($header['user_ok'], 'name') . '@' . "\r\n" . tglmysql2($header['tgl_ok']);
        $isi .= "\r\n" . 'Diterima Oleh : ' . datauser($header['user_tuju'], 'name') . '@' . "\r\n" . tglmysql2($header['tgl_tuju']);
        $qr = $this->cetakqr2($isi, $header['id']);
        $pdf->Image($qr . ".png", 177, 30, 18);
        $pdf->SetFont('Lato', '', 10);
        $pdf->Cell(18, 5, 'Nomor', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['nomor_dok'], 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(82, 5, 'Diperiksa & Disetujui Oleh', 'RB', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Dept', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['departemen'], 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(82, 5, substr(datauser($header['user_tuju'], 'name'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(28, 5, '', 'R', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Tanggal', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, tglmysql($header['tgl']), 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(82, 5, substr(datauser($header['user_tuju'], 'jabatan'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(80, 5, '', 'LBR', 0);
        $pdf->Cell(82, 5, '', 'BR', 0);
        $pdf->Cell(28, 5, '', 'BR', 1);
        $pdf->Cell(190, 1, '', 1, 1, '', 1);
        $pdf->Cell(6, 8, 'No', 'LRB', 0, 'C');
        $pdf->SetFont('Lato', '', 8);
        $pdf->Cell(17, 4, 'Nomor PO/', 'LR', 0, 'C');
        $pdf->Cell(7, 4, 'No', 'LR', 0, 'C');
        $pdf->Cell(7, 4, 'No', 'LR', 0, 'C');
        $pdf->Cell(80, 8, 'Spesifikasi Barang', 'LRB', 0, 'C');
        $pdf->Cell(8, 4, 'No.', 'LR', 0, 'C');
        $pdf->Cell(16, 4, 'Pcs/', 'LR', 0, 'C');
        $pdf->Cell(16, 4, 'Total', 'LR', 0, 'C');
        $pdf->Cell(33, 8, 'Keterangan', 'LRB', 0, 'C');
        $pdf->ln(4);
        $pdf->Cell(6, 4, '', 0);
        $pdf->Cell(17, 4, 'No Instruksi', 'RB', 0, 'C');
        $pdf->Cell(7, 4, 'Lot', 'RB', 0, 'C');
        $pdf->Cell(7, 4, 'Mc', 'B', 0, 'C');
        $pdf->Cell(80, 4, '', 0);
        $pdf->Cell(8, 4, 'Bale', 'RB', 0, 'C');
        $pdf->Cell(16, 4, 'Pack', 'RB', 0, 'C');
        $pdf->Cell(16, 4, 'Kgs', 'RB', 1, 'C');
        $detail = $this->out_model->getdatadetailout($id);
        $no = 1;
        foreach ($detail as $det) {
            $jumlah = $det['pcs'] == null ? $det['kgs'] : $det['pcs'];
            $pdf->Cell(6, 6, $no++, 'LRB', 0);
            $pdf->Cell(17, 6, '', 'LRB', 0);
            $pdf->Cell(7, 6, '', 'LRB', 0);
            $pdf->Cell(7, 6, '', 'LRB', 0);
            $pdf->Cell(80, 6, $det['nama_barang'], 'LBR', 0);
            $pdf->Cell(8, 6, '', 'LRB', 0);
            $pdf->Cell(16, 6, rupiah($det['pcs'], 0), 'LRB', 0, 'R');
            $pdf->Cell(16, 6, rupiah($det['kgs'], 0), 'LBR', 0, 'R');
            $pdf->Cell(33, 6, $det['keterangan'], 'LBR', 1, 'R');
        }
        $pdf->ln(2);
        $pdf->SetFont('Lato', '', 8);
        $pdf->Cell(15, 5, 'Catatan : ', 0);
        $pdf->Cell(19, 5, 'Dokumen ini sudah ditanda tangani secara digital', 0);
        $pdf->Output('I', 'FM-GD-05.pdf');
    }
    public function uploaddok($id)
    {
        $data['data'] = $this->akbmodel->getdatabyid($id);
        $data['actiondok'] = base_url() . 'akb/simpandokumen';
        $this->load->view('ib/uploaddok', $data);
    }
    public function simpandokumen()
    {
        $this->akbmodel->updatedok();
    }
    public function caripelabuhan()
    {
        $datacari = $_GET['search'];
        $hasil = $this->ibmodel->getpelabuhanbykode($datacari);

        if ($hasil) {
            $dataar = [];
            foreach ($hasil->result_array() as $key) {
                $data['id'] = $key['kode_pelabuhan'];
                $data['text'] = $key['kode_pelabuhan'] . ' - ' . $key['uraian_pelabuhan'];
                array_push($dataar, $data);
            }
        }
        echo json_encode($dataar);
    }
    public function xhitungbom($id, $mode = 0)
    {
        $hasil = $this->akbmodel->hitungbom($id, $mode);
        $this->session->set_flashdata('databom', $hasil);
        if ($mode = 0) {
            $url = base_url() . 'akb/isidokbc/' . $id;
        } else {
            $url = base_url() . 'akb/isidokbc/' . $id . '/1';
        }
        redirect($url);
    }
    public function simpanbom($id, $mode = 0)
    {
        $hasil = $this->akbmodel->hitungbom($id, $mode);
        $simpan = $this->akbmodel->simpanbom($hasil, $id);
        if ($simpan) {
            if ($mode = 0) {
                $url = base_url() . 'akb/isidokbc/' . $id;
            } else {
                $url = base_url() . 'akb/isidokbc/' . $id . '/1';
            }
            redirect($url);
        }
    }
    public function simpanbomjf($id, $mode = 0)
    {
        $data['datheader'] = $this->akbmodel->getdatabyid($id);
        $hasil = $this->akbmodel->hitungbomjf($id, $mode, $data['datheader']['urutakb']);
        $simpan = $this->akbmodel->simpanbom($hasil['ok'], $id);
        if ($simpan) {
            if ($mode == 0) {
                $url = base_url() . 'akb/isidokbc/' . $id;
            } else {
                $url = base_url() . 'akb/isidokbc/' . $id . '/1';
            }
            redirect($url);
        }
    }
    public function hitungbom($id, $mode = 0)
    {
        $hasil['hasil'] = $this->akbmodel->hitungbom($id, $mode);
        $hasil['idheader'] = $id;
        $this->load->view('akb/viewhitungbom', $hasil);
    }
    public function hitungbomjf($id, $mode = 0)
    {
        $datheader = $this->akbmodel->getdatabyid($id);
        $hasil['hasil'] = $this->akbmodel->hitungbomjf($id, $mode, $datheader['urutakb']);
        $hasil['idheader'] = $id;
        $hasil['mode'] = $mode;
        $this->load->view('akb/viewhitungbom', $hasil);
    }
    public function editbombc($id)
    {
        $hasil['detail'] = $this->akbmodel->getdetbombyid($id)->row_array();
        $this->load->view('akb/editbombc', $hasil);
    }
    public function simpandetailbombc()
    {
        $data = [
            'id' => $_POST['id'],
            'nobontr' => trim(strtoupper($_POST['nobontr'])),
            'id_barang' => $_POST['idbarang'],
            'id_header' => $_POST['idheader'],
            'bm' => $_POST['bm'] == 'true' ? 5 : 0,
            'ppn' => $_POST['ppn'] == 'true' ? 11 : 0,
            'pph' => $_POST['pph'] == 'true' ? 2.5 : 0,
        ];
        $hasil = $this->akbmodel->simpandetailbombc($data);
        echo $hasil;
    }
    public function addkontrak($id, $dept)
    {
        $data['idheader'] = $id;
        $data['kode'] = 0;
        $kondisi = [
            'dept_id' => $dept,
            'status' => 1,
            'jnsbc' => 261,
            'thkontrak' => '',
            'datkecuali' => 1,
            'nomor_ssb != ' => '',
            'penjamin != ' => ''
        ];
        $data['kontrak'] = $this->kontrakmodel->getdatakontrak261($kondisi);
        $this->load->view('akb/addkontrak', $data);
    }
    public function simpanaddkontrak()
    {
        $kode = $_POST['kode'];
        // if($kode==1){
        //     $data = [
        //         'id' => $_POST['id'],
        //         'exid_kontrak' => $_POST['kontrak']
        //     ];
        // }else{
            $data = [
                'id' => $_POST['id'],
                'id_kontrak' => $_POST['kontrak']
            ];
        // }
        return $this->akbmodel->simpanaddkontrak($data);
    }
    public function hapuskontrak($id)
    {
        $hasil = $this->akbmodel->hapuskontrak($id);
        if ($hasil) {
            $url = base_url() . 'akb/isidokbc/' . $id . '/1';
            redirect($url);
        }
    }
    public function autolampiran($id,$jnsbc,$mode=0){
        $hasil = $this->akbmodel->autolampiran($id,$jnsbc);
        if ($hasil) {
            $tmb = $mode==1 ? '/1' : '';
            $url = base_url() . 'akb/isidokbc/' . $id.$tmb;
            redirect($url);
        }
    }
    public function masukkelampiran()
    {
        $data = [
            'id_header' => $_POST['id'],
            'kode_dokumen' => $_POST['field'],
            'tgl_dokumen' => tglmysql($_POST['tgl']),
            'nomor_dokumen' => $_POST['nilai']
        ];
        $hasil = $this->akbmodel->masukkelampiran($data);
        echo $hasil;
    }
    public function isiurutakb($id, $mode = 0)
    {
        $data['datheader'] = $this->akbmodel->getdatabyid($id);
        $hasil = $this->akbmodel->getdatadetailib($id, $mode, $data['datheader']['urutakb']);
        $no = 0;
        foreach ($hasil as $hasil) {
            $no++;
            $kondisi = [
                'id_akb' => $id,
                'trim(po)' => trim($hasil['po']),
                'trim(item)' => trim($hasil['item']),
                'dis' => $hasil['dis'],
                'id_barang' => $hasil['id_barang'],
                'trim(insno)' => trim($hasil['insno']),
                'trim(nobontr)' => trim($hasil['nobontr'])
            ];
            $this->akbmodel->isiurutakb($hasil['id'], $no, $data['datheader']['urutakb'], $kondisi);
        }
        $url = base_url() . 'akb/isidokbc/' . $id . '/1';
        redirect($url);
    }
    public function isidatacifbombc($id)
    {
        $hasil = $this->akbmodel->isidatacifbombc($id);
        if ($hasil) {
            $url = base_url() . 'akb/isidokbc/' . $id . '/1';
            redirect($url);
        }
    }
    public function uploadijin($id, $mode = 0)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    
        $sheet->setTitle("BARANG DIKIRIM");

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A1', "SERI BARANG DIKIRIM"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B1', "DOKUMEN ASAL"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C1', "KODE KANTOR DOKUMEN ASAL"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D1', "NOMOR AJU DOKUMEN ASAL");
        $sheet->setCellValue('E1', "NOMOR DAFTAR");
        $sheet->setCellValue('F1', "TANGGAL DAFTAR");
        $sheet->setCellValue('G1', "SERI BARANG DOKUMEN ASAL");
        $sheet->setCellValue('H1', "HS");
        $sheet->setCellValue('I1', "MEREK");
        $sheet->setCellValue('J1', "TIPE");
        $sheet->setCellValue('K1', "SPESIFIKASI LAIN");
        $sheet->setCellValue('L1', "URAIAN");
        $sheet->setCellValue('M1', "KODE BARANG");
        $sheet->setCellValue('N1', "ASAL BARANG");
        $sheet->setCellValue('O1', "NEGARA ASAL");
        $sheet->setCellValue('P1', "JUMLAH SATUAN");
        $sheet->setCellValue('Q1', "JENIS SATUAN");
        $sheet->setCellValue('R1', "NETTO");
        $sheet->setCellValue('S1', "NDPBM");
        $sheet->setCellValue('T1', "VALUTA");
        $sheet->setCellValue('U1', "CIF ");
        $sheet->setCellValue('V1', "CIF RUPIAH");
        $sheet->setCellValue('W1', "HARGA PENYERAHAN");
        $sheet->setCellValue('X1', "ISI PER KEMASAN");
        $sheet->setCellValue('Y1', "JUMLAH DILEKATKAN");
        $sheet->setCellValue('Z1', "JUMLAH PITA CUKAI");
        $sheet->setCellValue('AA1', "HJE CUKAI");
        $sheet->setCellValue('AB1', "TARIF CUKAI");
        $sheet->setCellValue('AC1', "TOTAL NILAI TARIF BARANG");
        $sheet->setCellValue('AD1', "KETERANGAN");
        $sheet->setCellValue('AE1', "JUMLAH_KEMASAN");
        $isiheader = $this->akbmodel->getdatabyid($id);
        $kurssekarang = getkurssekarang($isiheader['tgl_aju'])->row_array();
        $inv = $this->akbmodel->excellampiran261($id, $isiheader['urutakb']);
        $no = 0;
        $numrow = 2;
        foreach ($inv->result_array() as $datbarangkirim) {
            $no++;
            $hs = trim($datbarangkirim['po']) != '' ? substr($datbarangkirim['hsx'], 0, 8) : substr($datbarangkirim['nohs'], 0, 8);
            $sku = trim($datbarangkirim['po']) == '' ? $datbarangkirim['kode'] : viewsku($datbarangkirim['po'], $datbarangkirim['item'], $datbarangkirim['dis'], $datbarangkirim['id_barang']);
            $spekbarang = trim($datbarangkirim['po']) == '' ? namaspekbarang($datbarangkirim['id_barang']) : spekpo($datbarangkirim['po'], $datbarangkirim['item'], $datbarangkirim['dis']);

            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('C' . $numrow, '050500');
            $sheet->setCellValue('H' . $numrow, $hs);
            $sheet->setCellValue('I' . $numrow, '-');
            $sheet->setCellValue('J' . $numrow, '-');
            $sheet->setCellValue('K' . $numrow, '-');
            $sheet->setCellValue('L' . $numrow, htmlspecialchars_decode($spekbarang));
            $sheet->setCellValue('M' . $numrow, $sku);
            $sheet->setCellValue('Q' . $numrow, 'KGM');
            $inv2 = $this->akbmodel->detailexcellampiran261($id, $no);
            $nodet = 0;
            foreach ($inv2->result_array() as $det) {
                $asalbar = $det['jns_bc'] == 23 ? 1 : 2;
                $kursusd = $kurssekarang['usd'];
                $ndpbm = $det['mt_uang'] == '' || $det['mt_uang'] == 'IDR' ? 0 : $kurssekarang['usd'];
                $pembagi = $det['weight'] == 0 ? 1 : $det['weight'];
                switch ($det['mt_uang']) {
                    case 'JPY':
                        $jpy = $det['cif'] * $kurssekarang[strtolower($det['mt_uang'])];
                        $cif = $jpy / $kursusd;
                        break;
                    default:
                        $cif = $det['cif'];
                        break;
                }
                if (count($det) > 0) {
                    $nodet++;
                    $sheet->setCellValue('B' . $numrow, $det['jns_bc']);
                    $sheet->setCellValue('D' . $numrow, $det['nomor_aju']);
                    $sheet->setCellValue('E' . $numrow, $det['nomor_bc']);
                    $sheet->setCellValue('F' . $numrow, date('d-m-Y', strtotime($det['tgl_bc'])));
                    $sheet->setCellValue('G' . $numrow, $det['serbar']);
                    $sheet->setCellValue('N' . $numrow, $asalbar);
                    $sheet->setCellValue('O' . $numrow, $det['kode_negara']);
                    $sheet->setCellValue('P' . $numrow, round($det['kgs'], 2));
                    $sheet->setCellValue('R' . $numrow, round($det['kgs'], 2));
                    $sheet->setCellValue('S' . $numrow, $kursusd);
                    $sheet->setCellValue('T' . $numrow, 'USD');
                    $sheet->setCellValue('U' . $numrow, round(($cif / $pembagi) * $det['kgs'], 2));
                    $sheet->setCellValue('V' . $numrow, round((($cif / $pembagi) * $det['kgs']), 2) * $ndpbm);
                    $sheet->setCellValue('AE' . $numrow, 1);
                    if ($nodet > 1) {
                        $sheet->setCellValue('A' . $numrow, $no);
                        $sheet->setCellValue('C' . $numrow, '050500');
                        $sheet->setCellValue('H' . $numrow, $hs);
                        $sheet->setCellValue('I' . $numrow, '-');
                        $sheet->setCellValue('J' . $numrow, '-');
                        $sheet->setCellValue('K' . $numrow, '-');
                        $sheet->setCellValue('L' . $numrow, htmlspecialchars_decode($spekbarang));
                        $sheet->setCellValue('M' . $numrow, $sku);
                        $sheet->setCellValue('P' . $numrow, $det['kgs']);
                        $sheet->setCellValue('Q' . $numrow, 'KGM');
                    }
                    $numrow++;
                } else {
                    $numrow++;
                }
            }
            // $numrow++;
        }


        $newSheet2 = $spreadsheet->createSheet(1);
        $newSheet2->setTitle('BARANG DIKIRIM TARIF');
        $sheet = $spreadsheet->setActiveSheetIndex(1);

        $sheet->setCellValue('A1', "SERI BARANG DIKIRIM"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B1', "KODE PUNGUTAN"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C1', "KODE TARIF"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D1', "TARIF");
        $sheet->setCellValue('E1', "KODE FASILITAS");
        $sheet->setCellValue('F1', "TARIF FASILITAS");
        $sheet->setCellValue('G1', "NILAI BAYAR");
        $sheet->setCellValue('H1', "NILAI FASILITAS");
        $sheet->setCellValue('I1', "NILAI SUDAH DILUNASI");
        $sheet->setCellValue('J1', "KODE KEMASAN");
        $sheet->setCellValue('K1', "JUMLAH KEMASAN  ");
        $sheet->setCellValue('L1', "KODE KOMODITI CUKAI");
        $sheet->setCellValue('M1', "KODE SUB KOMODITI CUKAI");
        $sheet->setCellValue('N1', "FLAG TIS");
        $sheet->setCellValue('O1', "FLAG PELEKATAN");

        $kurssekarang = getkurssekarang($isiheader['tgl_aju'])->row_array();
        $inv = $this->akbmodel->excellampiran261($id, $isiheader['urutakb']);
        $no = 0;
        $numrow = 2;
        foreach ($inv->result_array() as $datbarangkirim) {
            $no++;
            $inv2 = $this->akbmodel->detailexcellampiran261($id, $no);
            $pajak = ['BM', 'PPN', 'PPH'];
            $kdfas = [3, 6, 6];
            foreach ($inv2->result_array() as $det) {
                $pembagi = $det['weight'] == 0 ? 1 : $det['weight'];
                // $dpp = ($det['cif']/$pembagi)*$kurssekarang[strtolower($det['mt_uang'])];
                // $fld = $det['mt_uang']=='' ? 'IDR' : $det['mt_uang'];
                $ndpbm = $det['mt_uang'] == '' || $det['mt_uang'] == 'IDR' ? 0 : $kurssekarang['usd'];
                $fld = $det['mt_uang'] == '' ? 'IDR' : $det['mt_uang'];
                // $dpp = $det['kgs']*(round(($det['cif']/$pembagi),2)*$kurssekarang[strtolower($fld)]);
                switch ($det['mt_uang']) {
                    case 'JPY':
                        $jpy = $det['cif'] * $kurssekarang[strtolower($det['mt_uang'])];
                        $cif = $jpy / $kursusd;
                        break;
                    default:
                        $cif = $det['cif'];
                        break;
                }
                // $dpp = $det['kgs']*(($det['cif']/$pembagi)*$kurssekarang[strtolower($fld)]);
                $dpp = (round(($cif / $pembagi) * $det['kgs'], 2)) * $ndpbm;
                // $dpp = $det['kgs']*(($det['cif']/$pembagi)*$kurssekarang[strtolower($fld)]);
                for ($x = 0; $x < 3; $x++) {
                    $tambahdpp = 0;
                    if ($pajak[$x] != 'BM' && $det[strtolower($pajak[$x])] > 0) {
                        $tambahdpp = $dpp * ($det['bm'] / 100);
                    }
                    $sheet->setCellValue('A' . $numrow, $no);
                    $sheet->setCellValue('B' . $numrow, $pajak[$x]);
                    $sheet->setCellValue('C' . $numrow, 1);
                    $sheet->setCellValue('D' . $numrow, $det[strtolower($pajak[$x])]);
                    $sheet->setCellValue('E' . $numrow, $kdfas[$x]);
                    $sheet->setCellValue('F' . $numrow, 100);
                    $sheet->setCellValue('H' . $numrow, round(($tambahdpp + $dpp) * ($det[strtolower($pajak[$x])] / 100)));
                    $numrow++;
                }
            }
        }


        $newSheet3 = $spreadsheet->createSheet(2);
        $newSheet3->setTitle('BAHAN BAKU DIKIRIM');
        $sheet = $spreadsheet->setActiveSheetIndex(2);

        $sheet->setCellValue('A1', "SERI BAHAN BAKU DIKIRIM"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B1', "SERI BARANG DIKIRIM"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C1', "DOKUMEN ASAL"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D1', "KODE KANTOR DOKUMEN ASAL");
        $sheet->setCellValue('E1', "NOMOR AJU DOKUMEN ASAL");
        $sheet->setCellValue('F1', "NOMOR DAFTAR");
        $sheet->setCellValue('G1', "TANGGAL DAFTAR");
        $sheet->setCellValue('H1', "SERI BARANG DOKUMEN ASAL");
        $sheet->setCellValue('I1', "HS");
        $sheet->setCellValue('J1', "MEREK");
        $sheet->setCellValue('K1', "TIPE");
        $sheet->setCellValue('L1', "SPESIFIKASI LAIN");
        $sheet->setCellValue('M1', "URAIAN");
        $sheet->setCellValue('N1', "KODE BARANG");
        $sheet->setCellValue('O1', "ASAL BARANG");
        $sheet->setCellValue('P1', "NEGARA ASAL");
        $sheet->setCellValue('Q1', "JUMLAH SATUAN");
        $sheet->setCellValue('R1', "JENIS SATUAN");
        $sheet->setCellValue('S1', "NETTO");
        $sheet->setCellValue('T1', "NDPBM");
        $sheet->setCellValue('U1', "VALUTA ");
        $sheet->setCellValue('V1', "CIF");
        $sheet->setCellValue('W1', "CIF RUPIAH");
        $sheet->setCellValue('X1', "HARGA PENYERAHAN");
        $sheet->setCellValue('Y1', "ISI PER KEMASAN");
        $sheet->setCellValue('Z1', "JUMLAH DILEKATKAN");
        $sheet->setCellValue('AA1', "JUMLAH PITA CUKAI");
        $sheet->setCellValue('AB1', "HJE CUKAI");
        $sheet->setCellValue('AC1', "TARIF CUKAI");
        $sheet->setCellValue('AD1', "TOTAL NILAI TARIF BARANG");
        $sheet->setCellValue('AE1', "KETERANGAN");
        $sheet->setCellValue('AF1', "JUMLAH_KEMASAN");
        $sheet->setCellValue('AG1', "FLAG BARANG LOKAL");

        $kurssekarang = getkurssekarang($isiheader['tgl_aju'])->row_array();
        $inv = $this->akbmodel->excellampiran261($id, $isiheader['urutakb']);
        $no = 0;
        $nop = 0;
        $numrow = 2;
        foreach ($inv->result_array() as $datbarangkirim) {
            $no++;
            $nop++;
            $hs = trim($datbarangkirim['po']) != '' ? substr($datbarangkirim['hsx'], 0, 8) : substr($datbarangkirim['nohs'], 0, 8);
            $sku = trim($datbarangkirim['po']) == '' ? $datbarangkirim['kode'] : viewsku($datbarangkirim['po'], $datbarangkirim['item'], $datbarangkirim['dis'], $datbarangkirim['id_barang']);
            if (str_contains($datbarangkirim['nomor_inv'], 'NET/') || str_contains($datbarangkirim['nomor_inv'], 'RSC/') || str_contains($datbarangkirim['nomor_inv'], 'RSP/')) {
                $sat = 'KGM';
            } else {
                $sat = $datbarangkirim['kodebc'];
            }

            $sheet->setCellValue('A' . $numrow, $nop);
            $sheet->setCellValue('B' . $numrow, $no);
            $sheet->setCellValue('D' . $numrow, '050500');
            $sheet->setCellValue('J' . $numrow, '-');
            $sheet->setCellValue('K' . $numrow, '-');
            $sheet->setCellValue('L' . $numrow, '-');
            $sheet->setCellValue('R' . $numrow, $sat);
            // $sheet->setCellValue('AF'.$numrow, 1);
            // $sheet->setCellValue('AG'.$numrow, 'N');
            $inv2 = $this->akbmodel->detailexcellampiran261($id, $no);
            $nodet = 0;
            foreach ($inv2->result_array() as $det) {
                $asalbar = $det['jns_bc'] == 23 ? 1 : 2;
                $kursusd = $kurssekarang['usd'];
                $ndpbm = $det['mt_uang'] == '' || $det['mt_uang'] == 'IDR' ? 0 : $kurssekarang['usd'];
                $pembagi = $det['weight'] == 0 ? 1 : $det['weight'];
                $spekbarang = namaspekbarang($det['id_barang']);
                switch ($det['mt_uang']) {
                    case 'JPY':
                        $jpy = $det['cif'] * $kurssekarang[strtolower($det['mt_uang'])];
                        $cif = $jpy / $kursusd;
                        break;
                    default:
                        $cif = $det['cif'];
                        break;
                }
                if (count($det) > 0) {
                    $nodet++;
                    $sheet->setCellValue('C' . $numrow, $det['jns_bc']);
                    $sheet->setCellValue('E' . $numrow, $det['nomor_aju']);
                    $sheet->setCellValue('F' . $numrow, $det['nomor_bc']);
                    $sheet->setCellValue('G' . $numrow, date('d-m-Y', strtotime($det['tgl_bc'])));
                    $sheet->setCellValue('H' . $numrow, $det['serbar']);
                    $sheet->setCellValue('I' . $numrow, $det['nohs']);
                    $sheet->setCellValue('M' . $numrow, $spekbarang);
                    $sheet->setCellValue('N' . $numrow, $det['kode']);
                    $sheet->setCellValue('O' . $numrow, $asalbar);
                    $sheet->setCellValue('P' . $numrow, $det['kode_negara']);
                    $sheet->setCellValue('Q' . $numrow, round($det['kgs'], 2));
                    $sheet->setCellValue('R' . $numrow, 'KGM');
                    $sheet->setCellValue('S' . $numrow, round($det['kgs'], 2));
                    $sheet->setCellValue('T' . $numrow, $kursusd);
                    $sheet->setCellValue('U' . $numrow, 'USD');
                    $sheet->setCellValue('V' . $numrow, round(($cif / $pembagi) * $det['kgs'], 2));
                    $sheet->setCellValue('W' . $numrow, (round(($cif / $pembagi) * $det['kgs'], 2)) * $ndpbm);
                    $sheet->setCellValue('AF' . $numrow, 1);
                    $sheet->setCellValue('AG' . $numrow, 'N');
                    if ($nodet > 1) {
                        $nop++;
                        $sheet->setCellValue('A' . $numrow, $nop);
                        $sheet->setCellValue('B' . $numrow, $no);
                        $sheet->setCellValue('D' . $numrow, '050500');
                    }
                    $numrow++;
                } else {
                    $numrow++;
                }
            }
            // $numrow++;
        }

        $newSheet4 = $spreadsheet->createSheet(3);
        $newSheet4->setTitle('BAHAN BAKU DIKIRIM TARIF');
        $sheet = $spreadsheet->setActiveSheetIndex(3);

        $sheet->setCellValue('A1', "SERI BAHAN BAKU DIKIRIM"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B1', "SERI BARANG DIKIRIM"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C1', "KODE PUNGUTAN"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D1', "KODE TARIF");
        $sheet->setCellValue('E1', "TARIF");
        $sheet->setCellValue('F1', "KODE FASILITAS");
        $sheet->setCellValue('G1', "TARIF FASILITAS");
        $sheet->setCellValue('H1', "NILAI BAYAR");
        $sheet->setCellValue('I1', "NILAI FASILITAS");
        $sheet->setCellValue('J1', "NILAI SUDAH DILUNASI");
        $sheet->setCellValue('K1', "KODE KEMASAN");
        $sheet->setCellValue('L1', "JUMLAH KEMASAN");
        $sheet->setCellValue('M1', "KODE KOMODITI CUKAI");
        $sheet->setCellValue('N1', "KODE SUB KOMODITI CUKAI");
        $sheet->setCellValue('O1', "FLAG TIS");
        $sheet->setCellValue('P1', "FLAG PELEKATAN");

        $kurssekarang = getkurssekarang($isiheader['tgl_aju'])->row_array();
        $inv = $this->akbmodel->excellampiran261($id, $isiheader['urutakb']);
        $no = 0;
        $nop = 0;
        $numrow = 2;
        foreach ($inv->result_array() as $datbarangkirim) {
            $no++;
            $nop++;
            $inv2 = $this->akbmodel->detailexcellampiran261($id, $no);
            $pajak = ['BM', 'PPN', 'PPH'];
            $kdfas = [3, 6, 6];
            $nodet = 0;
            foreach ($inv2->result_array() as $det) {
                $nodet++;
                $pembagi = $det['weight'] == 0 ? 1 : $det['weight'];
                // $dpp = ($det['cif']/$pembagi)*$kurssekarang[strtolower($det['mt_uang'])];
                $ndpbm = $det['mt_uang'] == '' || $det['mt_uang'] == 'IDR' ? 0 : $kurssekarang['usd'];
                $fld = $det['mt_uang'] == '' ? 'IDR' : $det['mt_uang'];
                // $dpp = $det['kgs']*(round(($det['cif']/$pembagi),2)*$kurssekarang[strtolower($fld)]);
                switch ($det['mt_uang']) {
                    case 'JPY':
                        $jpy = $det['cif'] * $kurssekarang[strtolower($det['mt_uang'])];
                        $cif = $jpy / $kursusd;
                        break;
                    default:
                        $cif = $det['cif'];
                        break;
                }
                // $dpp = $det['kgs']*(($det['cif']/$pembagi)*$kurssekarang[strtolower($fld)]);
                $dpp = (round(($cif / $pembagi) * $det['kgs'], 2)) * $ndpbm;
                if ($nodet > 1) {
                    $nop++;
                }
                for ($x = 0; $x < 3; $x++) {
                    $tambahdpp = 0;
                    if ($pajak[$x] != 'BM' && $det[strtolower($pajak[$x])] > 0) {
                        $tambahdpp = $dpp * ($det['bm'] / 100);
                    }
                    $sheet->setCellValue('A' . $numrow, $nop);
                    $sheet->setCellValue('B' . $numrow, $no);
                    $sheet->setCellValue('C' . $numrow, $pajak[$x]);
                    $sheet->setCellValue('D' . $numrow, 1);
                    $sheet->setCellValue('E' . $numrow, $det[strtolower($pajak[$x])]);
                    $sheet->setCellValue('F' . $numrow, $kdfas[$x]);
                    $sheet->setCellValue('G' . $numrow, 100);
                    $sheet->setCellValue('I' . $numrow, round(($tambahdpp + $dpp) * ($det[strtolower($pajak[$x])] / 100)));
                    $numrow++;
                }
            }
        }

        $newSheet5 = $spreadsheet->createSheet(4);
        $newSheet5->setTitle('BARANG MASUK');
        $sheet = $spreadsheet->setActiveSheetIndex(4);

        $sheet->setCellValue('A1', "SERI BARANG MASUK"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B1', "HS"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C1', "MEREK"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D1', "TIPE");
        $sheet->setCellValue('E1', "SPESIFIKASI LAIN");
        $sheet->setCellValue('F1', "URAIAN");
        $sheet->setCellValue('G1', "KODE BARANG");
        $sheet->setCellValue('H1', "JUMLAH SATUAN");
        $sheet->setCellValue('I1', "JENIS SATUAN");
        $sheet->setCellValue('J1', "NETTO");
        $sheet->setCellValue('K1', "VOLUME");
        $sheet->setCellValue('L1', "KETERANGAN");

        $inv = $this->akbmodel->excellampiran261($id, $isiheader['urutakb']);
        $no = 1;
        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 2;
        // Set baris pertama untuk isi tabel adalah baris ke 3   
        $jumlahpcs = 0;
        $jumlahkgs = 0;
        foreach ($inv->result_array() as $data) {
            $sku = trim($data['po']) == '' ? $data['kode'] : viewsku($data['po'], $data['item'], $data['dis'], $data['id_barang']);
            $spekbarang = trim($data['po']) == '' ? namaspekbarang($data['id_barang']) : spekpo($data['po'], $data['item'], $data['dis']);
            $hs = trim($data['po']) != '' ? substr($data['hsx'], 0, 8) : substr($data['nohs'], 0, 8);
            $pcs = trim($data['kodebc']) == 'KGM' ? $data['kgs'] : $data['pcs'];
            $jumlahkgs += $data['kgs'];
            if (trim($data['kodebc']) != 'KGM') {
                $jumlahpcs += $data['pcs'];
            }
            if (str_contains($datbarangkirim['nomor_inv'], 'NET/') || str_contains($datbarangkirim['nomor_inv'], 'RSC/') || str_contains($datbarangkirim['nomor_inv'], 'RSP/')) {
                $sat = 'KGM';
            } else {
                $sat = $data['kodebc'];
            }
            $numawal = $numrow;
            $numakhir = $numrow - 1;
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $hs);
            $sheet->setCellValue('F' . $numrow, htmlspecialchars_decode($spekbarang));
            $sheet->setCellValue('H' . $numrow, $pcs);
            $sheet->setCellValue('I' . $numrow, $sat);
            $sheet->setCellValue('J' . $numrow, round($data['kgs'], 2));

            $numrow++;
            $no++;
        }

        $newSheet6 = $spreadsheet->createSheet(5);
        $newSheet6->setTitle('BARANG SISA');
        $sheet = $spreadsheet->setActiveSheetIndex(5);

        $sheet->setCellValue('A1', "SERI BARANG SISA"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B1', "HS"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C1', "MEREK"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D1', "TIPE");
        $sheet->setCellValue('E1', "SPESIFIKASI LAIN");
        $sheet->setCellValue('F1', "URAIAN");
        $sheet->setCellValue('G1', "KODE BARANG");
        $sheet->setCellValue('H1', "JUMLAH SATUAN");
        $sheet->setCellValue('I1', "JENIS SATUAN");
        $sheet->setCellValue('J1', "NETTO");
        $sheet->setCellValue('K1', "VOLUME");
        $sheet->setCellValue('L1', "KETERANGAN");

        $newSheet7 = $spreadsheet->createSheet(6);
        $newSheet7->setTitle('BARANG TAMBAHAN');
        $sheet = $spreadsheet->setActiveSheetIndex(6);

        $sheet->setCellValue('A1', "SERI BARANG TAMBAHAN"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B1', "HS"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C1', "MEREK"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D1', "TIPE");
        $sheet->setCellValue('E1', "SPESIFIKASI LAIN");
        $sheet->setCellValue('F1', "URAIAN");
        $sheet->setCellValue('G1', "KODE BARANG");
        $sheet->setCellValue('H1', "JUMLAH SATUAN");
        $sheet->setCellValue('I1', "JENIS SATUAN");
        $sheet->setCellValue('J1', "NETTO");
        $sheet->setCellValue('K1', "VOLUME");
        $sheet->setCellValue('L1', "HARGA PENYERAHAN");
        $sheet->setCellValue('M1', "KETERANGAN");

        $newSheet8 = $spreadsheet->createSheet(7);
        $newSheet8->setTitle('KONVERSI');
        $sheet = $spreadsheet->setActiveSheetIndex(7);

        $sheet->setCellValue('A1', "SERI BARANG MASUK"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B1', "JUMLAH BARANG MASUK"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C1', "SERI BAHAN BAKU DIKIRIM"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D1', "JUMLAH BAHAN BAKU DIKIRIM");
        $sheet->setCellValue('E1', "CONSMP");

        $inv = $this->akbmodel->excellampiran261($id, $isiheader['urutakb']);
        $no = 1;
        $nop = 0;
        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 2;
        // Set baris pertama untuk isi tabel adalah baris ke 3   
        $jumlahpcs = 0;
        $jumlahkgs = 0;
        foreach ($inv->result_array() as $data) {
            $sku = trim($data['po']) == '' ? $data['kode'] : viewsku($data['po'], $data['item'], $data['dis'], $data['id_barang']);
            $spekbarang = trim($data['po']) == '' ? namaspekbarang($data['id_barang']) : spekpo($data['po'], $data['item'], $data['dis']);
            $hs = trim($data['po']) != '' ? substr($data['hsx'], 0, 8) : substr($data['nohs'], 0, 8);
            $pcs = trim($data['kodebc']) == 'KGM' ? $data['kgs'] : $data['pcs'];
            $jumlahkgs += $data['kgs'];
            if (trim($data['kodebc']) != 'KGM') {
                $jumlahpcs += $data['pcs'];
            }
            $numawal = $numrow;
            $numakhir = $numrow - 1;
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, round($data['kgs'], 2));
            $inv2 = $this->akbmodel->detailexcellampiran261($id, $no);
            $nodet = 0;
            foreach ($inv2->result_array() as $det) {
                $nodet++;
                $kiloan = $data['kgs'] == 0 ? 1 : $data['kgs'];
                if ($nodet > 1) {
                    $sheet->setCellValue('A' . $numrow, $no);
                    $sheet->setCellValue('B' . $numrow, round($data['kgs'], 2));
                }
                if (count($det) > 0) {
                    $nop++;
                    $sheet->setCellValue('C' . $numrow, $nop);
                    $sheet->setCellValue('D' . $numrow, round($det['kgs'], 2));
                    $sheet->setCellValue('E' . $numrow, round($det['kgs'] / $kiloan, 2));
                    $numrow++;
                } else {
                    $numrow++;
                }
            }
            $no++;
        }


        $sheet = $spreadsheet->setActiveSheetIndex(0);

        // $inv = $this->akbmodel->exceljaminan261($id);

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Dokumen Perijinan AJU "' . $id . '".xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel Rekap NOMOR IB' . $this->session->userdata('currdept'));

        $spreadsheet->disconnectWorksheet();
        unset($spreadsheet);
    }
    public function rekapnobontr($id, $mode = 0)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "REKAP DATA NOMOR IB "); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE BARANG / SKU"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "SPESIFIKASI"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "NOBONTR");
        $sheet->setCellValue('E2', "JENIS BC");
        $sheet->setCellValue('F2', "NOMOR BC");
        $sheet->setCellValue('G2', "TGL BC");
        $sheet->setCellValue('H2', "MATA UANG");
        $sheet->setCellValue('I2', "CIF");

        $sheet->getColumnDimension('A')->setWidth(1.06, 'cm');
        $sheet->getColumnDimension('B')->setWidth(3.78, 'cm');
        $sheet->getColumnDimension('C')->setWidth(9.42, 'cm');
        $sheet->getColumnDimension('D')->setWidth(4.05, 'cm');
        $sheet->getColumnDimension('E')->setWidth(1.67, 'cm');
        $sheet->getColumnDimension('F')->setWidth(2.14, 'cm');
        $sheet->getColumnDimension('G')->setWidth(2.06, 'cm');
        $sheet->getColumnDimension('H')->setWidth(2.38, 'cm');
        $sheet->getColumnDimension('I')->setWidth(2, 'cm');
        $isiheader = $this->akbmodel->getdatabyid($id);
        $inv = $this->akbmodel->exceljaminan261($id, $isiheader['urutakb']);
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;
        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($inv->result_array() as $data) {
            $sku = $data['kode'];
            $spekbarang = namaspekbarang($data['id_barang']);
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $sku);
            $sheet->setCellValue('C' . $numrow, htmlspecialchars_decode($spekbarang));
            $sheet->setCellValue('D' . $numrow, $data['nobontr']);
            $sheet->setCellValue('E' . $numrow, $data['jns_bc']);
            $sheet->setCellValue('F' . $numrow, $data['nomor_bc']);
            $sheet->setCellValue('G' . $numrow, $data['tgl_bc']);
            $sheet->setCellValue('H' . $numrow, $data['mt_uang']);
            $sheet->setCellValue('I' . $numrow, $data['cif']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("DATA");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Rekap NOMOR IB.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel Rekap NOMOR IB' . $this->session->userdata('currdept'));
    }
    public function excellampiran261($id, $mode = 0)
    {
        $spreadsheet = new Spreadsheet();
        // $dir = "assets/docs/templatekontrakdankonversi.xlsx";

        try {
            // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dir);
            $styleArray = [
                'borders' => [
                    'bottom' => ['borderStyle' => 'thin', 'color' => ['argb' => '000000000']],
                    'top' => ['borderStyle' => 'thin', 'color' => ['argb' => '00000000']],
                    'right' => ['borderStyle' => 'thin', 'color' => ['argb' => '00000000']],
                    'left' => ['borderStyle' => 'thin', 'color' => ['argb' => '00000000']],
                ],
            ];

            $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(11);

            $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    
            $sheet->setTitle('Lampiran Bahan Baku');
            $sheet->setCellValue('A1', "BAHAN BAKU SUBKON"); // Set kolom A1 dengan tulisan "DATA SISWA"    
            $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('A1')->getFont()->setSize(14);

            // Buat header tabel nya pada baris ke 3    
            $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"  
            $sheet->getStyle('A3')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('A3')->applyFromArray($styleArray);
            $sheet->getColumnDimension('A')->setWidth(0.71, 'cm');
            $sheet->setCellValue('B3', "URAIAN BARANG"); // Set kolom B3 dengan tulisan "KODE"    
            $sheet->getStyle('B3')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('B3')->applyFromArray($styleArray);
            $sheet->getColumnDimension('B')->setWidth(12.45, 'cm');
            $sheet->setCellValue('C3', "HS CODE");
            $sheet->getStyle('C3')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('C3')->applyFromArray($styleArray);
            $sheet->getColumnDimension('C')->setWidth(1.77, 'cm');
            $sheet->setCellValue('D3', "KODE Brg"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
            $sheet->getStyle('D3')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('D3')->applyFromArray($styleArray);
            $sheet->getColumnDimension('D')->setWidth(2.19, 'cm');
            $sheet->setCellValue('E3', "JUMLAH");
            $sheet->getStyle('E3')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('E3')->applyFromArray($styleArray);
            $sheet->getColumnDimension('E')->setWidth(1.43, 'cm');
            $sheet->setCellValue('F3', "SATUAN");
            $sheet->getStyle('F3')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('F3')->applyFromArray($styleArray);
            $sheet->getColumnDimension('F')->setWidth(1.40, 'cm');
            $sheet->setCellValue('G3', "BERAT (Kgm)");
            $sheet->getStyle('G3')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('G3')->applyFromArray($styleArray);
            $sheet->getColumnDimension('G')->setWidth(2.30, 'cm');
            $sheet->setCellValue('H3', "KETERANGAN");
            $sheet->getStyle('H3')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('H3')->applyFromArray($styleArray);
            $sheet->getColumnDimension('H')->setWidth(5.09, 'cm');

            $sheet->getStyle('A3')->getFont()->setSize(13);
            $sheet->getStyle('B3')->getFont()->setSize(13);
            $sheet->getStyle('C3')->getFont()->setSize(13);
            $sheet->getStyle('D3')->getFont()->setSize(13);
            $sheet->getStyle('E3')->getFont()->setSize(13);
            $sheet->getStyle('F3')->getFont()->setSize(13);
            $sheet->getStyle('G3')->getFont()->setSize(13);
            $sheet->getStyle('H3')->getFont()->setSize(13);
            $header = $this->akbmodel->getdatabyid($id);
            // $cekhead = $header->row_array();
            $inv = $this->akbmodel->excellampiran261($id, $header['urutakb']);
            // echo "<pre>";
            // print_r($header);
            // echo "</pre>";
            // die();

            $no = 1;

            // Untuk penomoran tabel, di awal set dengan 1    
            $numrow = 4;
            $sheet = $spreadsheet->setActiveSheetIndex(0);
            // Set baris pertama untuk isi tabel adalah baris ke 3   
            $jumlahpcs = 0;
            $jumlahkgs = 0;
            foreach ($inv->result_array() as $data) {
                $sku = trim($data['po']) == '' ? $data['kode'] : viewsku($data['po'], $data['item'], $data['dis'], $data['id_barang']);
                $spekbarang = trim($data['po']) == '' ? namaspekbarang($data['id_barang']) : spekpo($data['po'], $data['item'], $data['dis']);
                $hs = trim($data['po']) != '' ? substr($data['hsx'], 0, 8) : substr($data['nohs'], 0, 8);
                $pcs = trim($data['kodebc']) == 'KGM' ? $data['kgs'] : $data['pcs'];
                $jumlahkgs += round($data['kgs'], 2);
                if (trim($data['kodebc']) != 'KGM') {
                    $jumlahpcs += $data['pcs'];
                }
                $numawal = $numrow;
                $numakhir = $numrow - 1;
                if (str_contains($header['nomor_inv'], 'NET/') || str_contains($header['nomor_inv'], 'RSC/') || str_contains($header['nomor_inv'], 'RSP/')) {
                    $sat = 'KGM';
                } else {
                    $sat = $data['kodebc'];
                }
                // Lakukan looping pada variabel      
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, htmlspecialchars_decode($spekbarang));
                $sheet->setCellValue('C' . $numrow, $hs);
                $sheet->setCellValue('D' . $numrow, $sku);
                $sheet->setCellValue('E' . $numrow, $pcs);
                $sheet->setCellValue('F' . $numrow, $sat);
                // $sheet->setCellValue('G' . $numrow, $data['kgs']);
                $inv2 = $this->akbmodel->detailexcellampiran261($id, $no);
                $jmlrekinv2 = $inv2->num_rows();
                $nor = 0;
                $jmlkgsdet = 0;
                foreach ($inv2->result_array() as $data2) {
                    $nor++;
                    $jmlkgsdet += round($data2['kgs'], 2);
                    $tambahnya = 0;
                    if (round($data2['kgs'], 2) > 0) {
                        if ($nor == $jmlrekinv2) {
                            $tambahnya = round($data['kgs'], 2) - $jmlkgsdet;
                        }
                        $sheet->setCellValue('G' . $numrow, round($data2['kgs'] + $tambahnya, 2));
                        $sheet->setCellValue('H' . $numrow, 'BC.' . $data2['jns_bc'] . ' ' . trim($data2['nomor_bc']) . ' ' . $data2['tgl_bc']);
                        $sheet->getStyle('G' . $numrow)->applyFromArray($styleArray);
                        $sheet->getStyle('H' . $numrow)->applyFromArray($styleArray);
                        $numakhir++;
                        $numrow++;
                    } else {
                        $numrow++;
                    }
                }
                $no++;
                $sheet->getStyle('A' . $numawal . ':A' . $numakhir)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $numawal . ':B' . $numakhir)->applyFromArray($styleArray);
                $sheet->getStyle('C' . $numawal . ':C' . $numakhir)->applyFromArray($styleArray);
                $sheet->getStyle('D' . $numawal . ':D' . $numakhir)->applyFromArray($styleArray);
                $sheet->getStyle('E' . $numawal . ':E' . $numakhir)->applyFromArray($styleArray);
                $sheet->getStyle('F' . $numawal . ':F' . $numakhir)->applyFromArray($styleArray);
            }
            $sheet->setCellValue('D' . $numrow, 'TOTAL');
            $sheet->getStyle('D' . $numrow)->getFont()->setBold(true);
            $sheet->getStyle('A' . $numrow . ':D' . $numrow)->applyFromArray($styleArray);
            $sheet->setCellValue('E' . $numrow, $jumlahpcs);
            $sheet->getStyle('E' . $numrow)->getFont()->setBold(true);
            $sheet->getStyle('E' . $numrow)->applyFromArray($styleArray);
            $sheet->setCellValue('G' . $numrow, round($jumlahkgs, 2));
            $sheet->getStyle('G' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('G' . $numrow)->getFont()->setBold(true);
            $sheet->getStyle('F' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('H' . $numrow)->applyFromArray($styleArray);



            $newSheet2 = $spreadsheet->createSheet(1); // Index 1 for the second position (0-based)
            $newSheet2->setTitle('Konversi Pemakaian Bahan Baku');
            $sheet = $spreadsheet->setActiveSheetIndex(1);
            $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
            // Buat header tabel nya pada baris ke 3    
            $sheet->setCellValue('A1', "LEMBAR KONVERSI PEMAKAIAN BAHAN BAKU"); // Set kolom A3 dengan tulisan "NO"  
            // $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('A1')->getFont()->setSize(18);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->mergeCells('A1:O1');
            $sheet->setCellValue('A2', "NOMOR KONTRAK"); // Set kolom B3 dengan tulisan "KODE"    
            $sheet->getStyle('A2')->getFont()->setSize(18);
            // $sheet->getStyle('A2')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('A2')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->mergeCells('A2:O2');
            $sheet->setCellValue('A4', "DATA PENGUSAHA TPB");
            $sheet->getStyle('A4')->getFont()->setSize(14);
            $sheet->setCellValue('A5', "A. NPWP");
            $sheet->getStyle('A5')->getFont()->setSize(14);
            $sheet->setCellValue('A6', "B. NAMA TPB");
            $sheet->getStyle('A6')->getFont()->setSize(14);
            $sheet->setCellValue('A7', "C. NOMOR SURAT IJIN TPB");
            $sheet->getStyle('A7')->getFont()->setSize(14);
            $sheet->setCellValue('C5', ":");
            $sheet->getStyle('C5')->getFont()->setSize(14);
            $sheet->setCellValue('C6', ":");
            $sheet->getStyle('C6')->getFont()->setSize(14);
            $sheet->setCellValue('C7', ":");
            $sheet->getStyle('C7')->getFont()->setSize(14);
            $sheet->setCellValue('D5', "01.001.717.6-057.000");
            $sheet->getStyle('D5')->getFont()->setSize(14);
            $sheet->setCellValue('D6', "PT. INDONEPTUNE NET MANUFACTURING");
            $sheet->getStyle('D6')->getFont()->setSize(14);
            $sheet->setCellValue('D7', "1555/KM.04/2017, 10 JULY 2017");
            $sheet->getStyle('D7')->getFont()->setSize(14);
            $sheet->setCellValue('H4', "DATA PENERIMA SUBKONTRAK");
            $sheet->getStyle('H4')->getFont()->setSize(14);
            $sheet->setCellValue('H5', "A. NPWP");
            $sheet->getStyle('H5')->getFont()->setSize(14);
            $sheet->setCellValue('H6', "B. NAMA PERUSAHAAN");
            $sheet->getStyle('H6')->getFont()->setSize(14);
            $sheet->setCellValue('H7', "C. ALAMAT");
            $sheet->getStyle('H7')->getFont()->setSize(14);
            $sheet->setCellValue('I5', ":");
            $sheet->getStyle('I5')->getFont()->setSize(14);
            $sheet->setCellValue('I6', ":");
            $sheet->getStyle('I6')->getFont()->setSize(14);
            $sheet->setCellValue('I7', ":");
            $sheet->getStyle('I7')->getFont()->setSize(14);
            $sheet->setCellValue('J5', $header['npwpsubkon']);
            $sheet->getStyle('J5')->getFont()->setSize(14);
            $sheet->setCellValue('J6', $header['namasubkon']);
            $sheet->getStyle('J6')->getFont()->setSize(14);
            $sheet->setCellValue('J7', $header['alamatsubkon']);
            $sheet->getStyle('J7')->getFont()->setSize(14);

            $sheet->mergeCells('A10:F10');
            $sheet->getStyle('A10:F10')->applyFromArray($styleArray);
            $sheet->setCellValue('A10', "DATA BAHAN JADI");
            $sheet->getStyle('A10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->mergeCells('G10:L10');
            $sheet->getStyle('G10:L10')->applyFromArray($styleArray);
            $sheet->setCellValue('G10', "KONVERSI");
            $sheet->getStyle('G10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->mergeCells('M10:N10');
            $sheet->getStyle('M10:N10')->applyFromArray($styleArray);
            $sheet->setCellValue('M10', "BAHAN TERKANDUNG");
            $sheet->getStyle('M10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->mergeCells('O10:O11');
            $sheet->getStyle('O10:O11')->applyFromArray($styleArray);
            $sheet->setCellValue('O10', "KETERANGAN \r\nDOKUMEN \r\nDAN NO URUT");
            $sheet->getStyle('O10')->getAlignment()->setWrapText(true);
            $sheet->getStyle('O10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('O10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

            $sheet->setCellValue('A11', "NOMOR KONVERSI");
            $sheet->getStyle('A11')->applyFromArray($styleArray);
            $sheet->getStyle('A11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->mergeCells('B11:D11');
            $sheet->getStyle('B11:D11')->applyFromArray($styleArray);
            $sheet->setCellValue('B11', "KODE BARANG \r\nHS \r\nURAIAN BARANG");
            $sheet->getStyle('B11')->getAlignment()->setWrapText(true);
            $sheet->getStyle('B11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('E11', "JML");
            $sheet->getStyle('E11')->applyFromArray($styleArray);
            $sheet->getStyle('E11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->setCellValue('F11', "SAT");
            $sheet->getStyle('F11')->applyFromArray($styleArray);
            $sheet->getStyle('F11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->setCellValue('G11', "NO");
            $sheet->getStyle('G11')->applyFromArray($styleArray);
            $sheet->getStyle('G11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->mergeCells('H11:J11');
            $sheet->getStyle('H11:J11')->applyFromArray($styleArray);
            $sheet->setCellValue('H11', "DETAIL BAHAN BAKU YANG DIGUNAKAN \r\nHS \r\nURAIAN BARANG");
            $sheet->getStyle('H11')->getAlignment()->setWrapText(true);
            $sheet->getStyle('H11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('H11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_LEFT);
            $sheet->setCellValue('K11', "JML");
            $sheet->getStyle('K11')->applyFromArray($styleArray);
            $sheet->getStyle('K11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->setCellValue('L11', "SAT");
            $sheet->getStyle('L11')->applyFromArray($styleArray);
            $sheet->getStyle('L11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('L11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->setCellValue('M11', "TERKANDUNG \r\n %");
            $sheet->getStyle('M11')->applyFromArray($styleArray);
            $sheet->getStyle('M11')->getAlignment()->setWrapText(true);
            $sheet->getStyle('M11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('M11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->setCellValue('N11', "WASTE/SCRAP \r\n %");
            $sheet->getStyle('N11')->applyFromArray($styleArray);
            $sheet->getStyle('N11')->getAlignment()->setWrapText(true);
            $sheet->getStyle('N11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('N11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);

            $sheet->getColumnDimension('A')->setWidth(4.38, 'cm');
            $sheet->getColumnDimension('B')->setWidth(2.08, 'cm');
            $sheet->getColumnDimension('C')->setWidth(0.30, 'cm');
            $sheet->getColumnDimension('D')->setWidth(13.08, 'cm');
            $sheet->getColumnDimension('E')->setWidth(2.27, 'cm');
            $sheet->getColumnDimension('F')->setWidth(1.47, 'cm');
            $sheet->getColumnDimension('G')->setWidth(1.13, 'cm');
            $sheet->getColumnDimension('H')->setWidth(6.31, 'cm');
            $sheet->getColumnDimension('I')->setWidth(0.30, 'cm');
            $sheet->getColumnDimension('J')->setWidth(7.45, 'cm');
            $sheet->getColumnDimension('K')->setWidth(1.93, 'cm');
            $sheet->getColumnDimension('L')->setWidth(1.36, 'cm');
            $sheet->getColumnDimension('M')->setWidth(3.67, 'cm');
            $sheet->getColumnDimension('N')->setWidth(3.67, 'cm');
            $sheet->getColumnDimension('O')->setWidth(3.70, 'cm');
            $sheet->getRowDimension('11')->setRowHeight(1.93, 'cm');

            $inv = $this->akbmodel->excellampiran261($id, $header['urutakb']);
            $numrow = 12;
            $no = 1;
            $nok = 1;
            foreach ($inv->result_array() as $data) {
                $sku = trim($data['po']) == '' ? $data['kode'] : viewsku($data['po'], $data['item'], $data['dis'], $data['id_barang']);
                $spekbarang = trim($data['po']) == '' ? namaspekbarang($data['id_barang']) : spekpo($data['po'], $data['item'], $data['dis']);
                $hs = trim($data['po']) != '' ? substr($data['hsx'], 0, 8) : substr($data['nohs'], 0, 8);
                // Lakukan looping pada variabel      
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->setCellValue('B' . $numrow, $sku);
                $sheet->setCellValue('E' . $numrow, round($data['kgs'], 2));
                $sheet->setCellValue('F' . $numrow, 'KGM');
                // $sheet->setCellValue('E' . $numrow, $data['pcs']);
                // $sheet->setCellValue('F' . $numrow, $data['kodebc']);
                // $sheet->setCellValue('G' . $numrow, $data['kgs']);
                $nok = $numrow;
                $nol = 1;
                $numrow++;
                $sheet->setCellValue('B' . $numrow, ' ' . $hs);
                $numrow++;
                $sheet->setCellValue('B' . $numrow, htmlspecialchars_decode($spekbarang));
                $numrow++;
                $numawal = $nok;
                $numakhir = $numrow - 1;
                // $sheet->setCellValue('H' . $nok, "XXXX");
                $inv2 = $this->akbmodel->detailexcellampiran261($id, $no);
                $jmlrekinv2 = $inv2->num_rows();
                $nor = 0;
                $jmlkgsdet = 0;
                foreach ($inv2->result_array() as $data2) {
                    $kiloan = $data['kgs'] == 0 ? 1 : $data['kgs'];
                    $nor++;
                    $jmlkgsdet += round($data2['kgs'], 2);
                    $tambahnya = 0;
                    if (count($data2) > 0 && round($data2['kgs'], 2) > 0) {
                        if ($nor == $jmlrekinv2) {
                            $tambahnya = round($data['kgs'], 2) - $jmlkgsdet;
                        }
                        $sheet->setCellValue('G' . $nok, $nol);
                        $sheet->setCellValue('H' . $nok, $data2['kode']);
                        $sheet->setCellValue('K' . $nok, round($data2['kgs'] + $tambahnya, 2));
                        $sheet->setCellValue('L' . $nok, 'KGM');
                        $sheet->setCellValue('M' . $nok, round(($data2['kgs'] / $kiloan) * 100, 2));
                        $sheet->setCellValue('N' . $nok, 0);
                        $sheet->setCellValue('O' . $nok, 'BC.' . $data2['jns_bc']);
                        $nok++;
                        $sheet->setCellValue('H' . $nok, $data2['nohs']);
                        $sheet->setCellValue('O' . $nok, trim($data2['nomor_bc']) . ' ' . $data2['tgl_bc']);
                        $nok++;
                        $sheet->setCellValue('H' . $nok, $data2['nama_barang']);
                        $sheet->setCellValue('O' . $nok, ' No.' . $data2['serbar']);
                        $sheet->getStyle('G' . $numawal . ':G' . $nok)->applyFromArray($styleArray);
                        $sheet->getStyle('H' . $numawal . ':J' . $nok)->applyFromArray($styleArray);
                        $sheet->getStyle('K' . $numawal . ':K' . $nok)->applyFromArray($styleArray);
                        $sheet->getStyle('L' . $numawal . ':L' . $nok)->applyFromArray($styleArray);
                        $sheet->getStyle('M' . $numawal . ':M' . $nok)->applyFromArray($styleArray);
                        $sheet->getStyle('N' . $numawal . ':N' . $nok)->applyFromArray($styleArray);
                        $sheet->getStyle('O' . $numawal . ':O' . $nok)->applyFromArray($styleArray);
                        $nok++;
                        $nol++;
                    }
                }
                $numrow = $nok;
                $sheet->getStyle('E' . $numawal . ':E' . $nok - 1)->applyFromArray($styleArray);
                $sheet->getStyle('F' . $numawal . ':F' . $nok - 1)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $numawal . ':D' . $nok - 1)->applyFromArray($styleArray);
                $sheet->getStyle('A' . $numawal . ':A' . $nok - 1)->applyFromArray($styleArray);
                // $numrow++;
                $no++;
                // Tambah 1 setiap kali looping      
            }
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            die('Error loading file: ' . $e->getMessage());
        }

        $newSheet3 = $spreadsheet->createSheet(2);
        $newSheet3->setTitle('Lampiran BARANG JADI');
        $sheet = $spreadsheet->setActiveSheetIndex(2);

        $sheet->setCellValue('A1', "BARANG HASIL SUBKONTRAK"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    
        $sheet->getStyle('A1')->getFont()->setSize(14);

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"  
        $sheet->getStyle('A3')->getFont()->setBold(true); // Set bold kolom A1    
        $sheet->getStyle('A3')->applyFromArray($styleArray);
        $sheet->getColumnDimension('A')->setWidth(0.71, 'cm');
        $sheet->setCellValue('B3', "URAIAN BARANG"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->getStyle('B3')->getFont()->setBold(true); // Set bold kolom A1    
        $sheet->getStyle('B3')->applyFromArray($styleArray);
        $sheet->getColumnDimension('B')->setWidth(12.45, 'cm');
        $sheet->setCellValue('C3', "HS CODE");
        $sheet->getStyle('C3')->getFont()->setBold(true); // Set bold kolom A1    
        $sheet->getStyle('C3')->applyFromArray($styleArray);
        $sheet->getColumnDimension('C')->setWidth(1.77, 'cm');
        $sheet->setCellValue('D3', "KODE Brg"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->getStyle('D3')->getFont()->setBold(true); // Set bold kolom A1    
        $sheet->getStyle('D3')->applyFromArray($styleArray);
        $sheet->getColumnDimension('D')->setWidth(2.19, 'cm');
        $sheet->setCellValue('E3', "JUMLAH");
        $sheet->getStyle('E3')->getFont()->setBold(true); // Set bold kolom A1    
        $sheet->getStyle('E3')->applyFromArray($styleArray);
        $sheet->getColumnDimension('E')->setWidth(1.43, 'cm');
        $sheet->setCellValue('F3', "SATUAN");
        $sheet->getStyle('F3')->getFont()->setBold(true); // Set bold kolom A1    
        $sheet->getStyle('F3')->applyFromArray($styleArray);
        $sheet->getColumnDimension('F')->setWidth(1.40, 'cm');
        $sheet->setCellValue('G3', "BERAT (Kgm)");
        $sheet->getStyle('G3')->getFont()->setBold(true); // Set bold kolom A1    
        $sheet->getStyle('G3')->applyFromArray($styleArray);
        $sheet->getColumnDimension('G')->setWidth(2.30, 'cm');
        $sheet->setCellValue('H3', "KETERANGAN");
        $sheet->getStyle('H3')->getFont()->setBold(true); // Set bold kolom A1    
        $sheet->getStyle('H3')->applyFromArray($styleArray);
        $sheet->getColumnDimension('H')->setWidth(5.09, 'cm');

        $sheet->getStyle('A3')->getFont()->setSize(13);
        $sheet->getStyle('B3')->getFont()->setSize(13);
        $sheet->getStyle('C3')->getFont()->setSize(13);
        $sheet->getStyle('D3')->getFont()->setSize(13);
        $sheet->getStyle('E3')->getFont()->setSize(13);
        $sheet->getStyle('F3')->getFont()->setSize(13);
        $sheet->getStyle('G3')->getFont()->setSize(13);
        $sheet->getStyle('H3')->getFont()->setSize(13);
        $inv = $this->akbmodel->excellampiran261($id, $header['urutakb']);
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 4;
        // Set baris pertama untuk isi tabel adalah baris ke 3   
        $jumlahpcs = 0;
        $jumlahkgs = 0;
        foreach ($inv->result_array() as $data) {
            $sku = trim($data['po']) == '' ? $data['kode'] : viewsku($data['po'], $data['item'], $data['dis'], $data['id_barang']);
            $spekbarang = trim($data['po']) == '' ? namaspekbarang($data['id_barang']) : spekpo($data['po'], $data['item'], $data['dis']);
            $hs = trim($data['po']) != '' ? substr($data['hsx'], 0, 8) : substr($data['nohs'], 0, 8);
            $pcs = trim($data['kodebc']) == 'KGM' ? $data['kgs'] : $data['pcs'];
            $jumlahkgs += round($data['kgs'], 2);
            if (trim($data['kodebc']) != 'KGM') {
                $jumlahpcs += $data['pcs'];
            }
            $numawal = $numrow;
            $numakhir = $numrow - 1;
            if (str_contains($header['nomor_inv'], 'NET/') || str_contains($header['nomor_inv'], 'RSC/') || str_contains($header['nomor_inv'], 'RSP/')) {
                $sat = 'KGM';
            } else {
                $sat = $data['kodebc'];
            }
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, htmlspecialchars_decode($spekbarang));
            $sheet->setCellValue('C' . $numrow, $hs);
            $sheet->setCellValue('D' . $numrow, $sku);
            $sheet->setCellValue('E' . $numrow, $pcs);
            $sheet->setCellValue('F' . $numrow, $sat);
            $sheet->setCellValue('G' . $numrow, round($data['kgs'], 2));

            $sheet->getStyle('A' . $numrow . ':A' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('B' . $numrow . ':B' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('C' . $numrow . ':C' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('D' . $numrow . ':D' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('E' . $numrow . ':E' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('F' . $numrow . ':F' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('G' . $numrow . ':G' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('H' . $numrow . ':H' . $numrow)->applyFromArray($styleArray);
            $numrow++;
            $no++;
        }
        $sheet->setCellValue('D' . $numrow, 'TOTAL');
        $sheet->getStyle('D' . $numrow)->getFont()->setBold(true);
        $sheet->getStyle('A' . $numrow . ':D' . $numrow)->applyFromArray($styleArray);
        $sheet->setCellValue('E' . $numrow, $jumlahpcs);
        $sheet->getStyle('E' . $numrow)->getFont()->setBold(true);
        $sheet->getStyle('E' . $numrow)->applyFromArray($styleArray);
        $sheet->setCellValue('G' . $numrow, round($jumlahkgs, 2));
        $sheet->getStyle('G' . $numrow)->applyFromArray($styleArray);
        $sheet->getStyle('G' . $numrow)->getFont()->setBold(true);
        $sheet->getStyle('F' . $numrow)->applyFromArray($styleArray);
        $sheet->getStyle('H' . $numrow)->applyFromArray($styleArray);

        $sheet = $spreadsheet->setActiveSheetIndex(0);
        // // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        // $sheet->setTitle("Lampiran Permohonan dan Kontrak");

        // Proses file excel    
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Permohonan dan Konversi "' . $id . '".xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel Lampiran Kontrak dan Konversi' . $this->session->userdata('currdept'));

        $spreadsheet->disconnectWorksheet();
        unset($spreadsheet);
    }
    public function exceljaminan261($id, $mode = 0)
    {
        $spreadsheet = new Spreadsheet();
        // $dir = "assets/docs/templatekontrakdankonversi.xlsx";
        $header = $this->akbmodel->getdatabyid($id);

        try {
            // $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dir);

            $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    
            $sheet->setTitle('Perhitungan Jaminan ' . $id);

            $styleArray = [
                'borders' => [
                    'bottom' => ['borderStyle' => 'thin', 'color' => ['argb' => '000000000']],
                    'top' => ['borderStyle' => 'thin', 'color' => ['argb' => '00000000']],
                    'right' => ['borderStyle' => 'thin', 'color' => ['argb' => '00000000']],
                    'left' => ['borderStyle' => 'thin', 'color' => ['argb' => '00000000']],
                ],
            ];

            $spreadsheet->getDefaultStyle()->getFont()->setName('Times New Roman');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(12);
            $spreadsheet->getDefaultStyle()->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            // Buat header tabel nya pada baris ke 3    
            $sheet->setCellValue('A1', "LEMBAR PERHITUNGAN JAMINAN DALAM RANGKA PENGELUARAN BARANG DARI TPB KE TLDPP"); // Set kolom A3 dengan tulisan "NO"  
            // $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    
            $sheet->getStyle('A1')->getFont()->setSize(17);
            $sheet->getStyle('A1')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->mergeCells('A1:R1');
            $sheet->setCellValue('A3', "DATA PENGUSAHA TPB");
            $sheet->getStyle('A3')->getFont()->setSize(14);
            $sheet->setCellValue('A4', "A. NPWP");
            $sheet->getStyle('A4')->getFont()->setSize(14);
            $sheet->setCellValue('A5', "B. NAMA TPB");
            $sheet->getStyle('A5')->getFont()->setSize(14);
            $sheet->setCellValue('A6', "C. NOMOR SURAT IJIN TPB");
            $sheet->getStyle('A6')->getFont()->setSize(14);
            $sheet->setCellValue('C4', ":");
            $sheet->getStyle('C4')->getFont()->setSize(14);
            $sheet->setCellValue('C5', ":");
            $sheet->getStyle('C5')->getFont()->setSize(14);
            $sheet->setCellValue('C6', ":");
            $sheet->getStyle('C6')->getFont()->setSize(14);
            $sheet->setCellValue('D4', "01.001.717.6-057.000");
            $sheet->getStyle('D4')->getFont()->setSize(14);
            $sheet->setCellValue('D5', "PT. INDONEPTUNE NET MANUFACTURING");
            $sheet->getStyle('D5')->getFont()->setSize(14);
            $sheet->setCellValue('D6', "1555/KM.04/2017, 10 JULY 2017");
            $sheet->getStyle('D6')->getFont()->setSize(14);
            $sheet->setCellValue('L3', "DATA PENERIMA SUBKONTRAK");
            $sheet->getStyle('L3')->getFont()->setSize(14);
            $sheet->setCellValue('L4', "A. NPWP");
            $sheet->getStyle('L4')->getFont()->setSize(14);
            $sheet->setCellValue('L5', "B. NAMA PERUSAHAAN");
            $sheet->getStyle('L5')->getFont()->setSize(14);
            $sheet->setCellValue('L6', "C. ALAMAT");
            $sheet->getStyle('L6')->getFont()->setSize(14);
            $sheet->setCellValue('N4', ":");
            $sheet->getStyle('N4')->getFont()->setSize(14);
            $sheet->setCellValue('N5', ":");
            $sheet->getStyle('N5')->getFont()->setSize(14);
            $sheet->setCellValue('N6', ":");
            $sheet->getStyle('N6')->getFont()->setSize(14);
            $sheet->setCellValue('O4', $header['npwpsubkon']);
            $sheet->getStyle('O4')->getFont()->setSize(14);
            $sheet->setCellValue('O5', $header['namasubkon']);
            $sheet->getStyle('O5')->getFont()->setSize(14);
            $sheet->setCellValue('O6', $header['alamatsubkon']);
            $sheet->getStyle('O6')->getFont()->setSize(14);

            $sheet->mergeCells('A9:J9');
            $sheet->setCellValue('A9', "DATA BAHAN BAKU");
            $sheet->getStyle('A9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A9:J9')->applyFromArray($styleArray);
            $sheet->mergeCells('K9:R9');
            $sheet->setCellValue('K9', "PERHITUNGAN JAMINAN");
            $sheet->getStyle('K9')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K9:R9')->applyFromArray($styleArray);
            $sheet->mergeCells('A10:A11');
            $sheet->setCellValue('A10', "NO");
            $sheet->getStyle('A10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('A10:A11')->applyFromArray($styleArray);
            $sheet->mergeCells('B10:D11');
            $sheet->setCellValue('B10', "KODE BARANG \r\nHS \r\nURAIAN BARANG");
            $sheet->getStyle('B10')->getAlignment()->setWrapText(true);
            $sheet->getStyle('B10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('B10:D11')->applyFromArray($styleArray);
            $sheet->mergeCells('E10:E11');
            $sheet->setCellValue('E10', "JML");
            $sheet->getStyle('E10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('E10:E11')->applyFromArray($styleArray);
            $sheet->mergeCells('F10:F11');
            $sheet->setCellValue('F10', "SAT");
            $sheet->getStyle('F10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('F10:F11')->applyFromArray($styleArray);
            $sheet->mergeCells('G10:J10');
            $sheet->setCellValue('G10', "DOKUMEN ASAL");
            $sheet->getStyle('G10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('G10:J10')->applyFromArray($styleArray);
            $sheet->setCellValue('G11', "JENIS \r\nDOK");
            $sheet->getStyle('G11')->getAlignment()->setWrapText(true);
            $sheet->getStyle('G11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('G11')->applyFromArray($styleArray);
            $sheet->setCellValue('H11', "NO");
            $sheet->getStyle('H11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('H11')->applyFromArray($styleArray);
            $sheet->setCellValue('I11', "TANGGAL");
            $sheet->getStyle('I11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('I11')->applyFromArray($styleArray);
            $sheet->setCellValue('J11', "POS");
            $sheet->getStyle('J11')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J11')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('J11')->applyFromArray($styleArray);
            $sheet->mergeCells('K10:K11');
            $sheet->setCellValue('K10', "BM");
            $sheet->getStyle('K10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('K10:K11')->applyFromArray($styleArray);
            $sheet->mergeCells('L10:L11');
            $sheet->setCellValue('L10', "BMT");
            $sheet->getStyle('L10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('L10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('L10:L11')->applyFromArray($styleArray);
            $sheet->mergeCells('M10:M11');
            $sheet->setCellValue('M10', "CUKAI");
            $sheet->getStyle('M10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('M10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('M10:M11')->applyFromArray($styleArray);
            $sheet->mergeCells('N10:O11');
            $sheet->setCellValue('N10', "PPN");
            $sheet->getStyle('N10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('N10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('N10:O11')->applyFromArray($styleArray);
            $sheet->mergeCells('P10:P11');
            $sheet->setCellValue('P10', "PPNBM");
            $sheet->getStyle('P10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('P10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('P10:P11')->applyFromArray($styleArray);
            $sheet->mergeCells('Q10:Q11');
            $sheet->setCellValue('Q10', "PPH");
            $sheet->getStyle('Q10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('Q10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('Q10:Q11')->applyFromArray($styleArray);
            $sheet->mergeCells('R10:R11');
            $sheet->setCellValue('R10', "TOTAL");
            $sheet->getStyle('R10')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('R10')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER);
            $sheet->getStyle('R10:R11')->applyFromArray($styleArray);

            $sheet->setCellValue('A12', "1");
            $sheet->getStyle('A12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A12')->applyFromArray($styleArray);
            $sheet->mergeCells('B12:D12');
            $sheet->setCellValue('B12', "2");
            $sheet->getStyle('B12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('B12:D12')->applyFromArray($styleArray);
            $sheet->setCellValue('E12', "3");
            $sheet->getStyle('E12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('E12')->applyFromArray($styleArray);
            $sheet->setCellValue('F12', "4");
            $sheet->getStyle('F12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('F12')->applyFromArray($styleArray);
            $sheet->setCellValue('G12', "5");
            $sheet->getStyle('G12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('G12')->applyFromArray($styleArray);
            $sheet->setCellValue('H12', "6");
            $sheet->getStyle('H12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('H12')->applyFromArray($styleArray);
            $sheet->setCellValue('I12', "7");
            $sheet->getStyle('I12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('I12')->applyFromArray($styleArray);
            $sheet->setCellValue('J12', "8");
            $sheet->getStyle('J12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('J12')->applyFromArray($styleArray);
            $sheet->setCellValue('K12', "9");
            $sheet->getStyle('K12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('K12')->applyFromArray($styleArray);
            $sheet->setCellValue('L12', "10");
            $sheet->getStyle('L12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('L12')->applyFromArray($styleArray);
            $sheet->setCellValue('M12', "11");
            $sheet->getStyle('M12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('M12')->applyFromArray($styleArray);
            $sheet->mergeCells('N12:O12');
            $sheet->setCellValue('N12', "12");
            $sheet->getStyle('N12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('N12:O12')->applyFromArray($styleArray);
            $sheet->setCellValue('P12', "13");
            $sheet->getStyle('P12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('P12')->applyFromArray($styleArray);
            $sheet->setCellValue('Q12', "14");
            $sheet->getStyle('Q12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('Q12')->applyFromArray($styleArray);
            $sheet->setCellValue('R12', "15");
            $sheet->getStyle('R12')->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('R12')->applyFromArray($styleArray);

            $sheet->getColumnDimension('A')->setWidth(1.78, 'cm');
            $sheet->getColumnDimension('B')->setWidth(4.5, 'cm');
            $sheet->getColumnDimension('C')->setWidth(0.34, 'cm');
            $sheet->getColumnDimension('D')->setWidth(8.62, 'cm');
            $sheet->getColumnDimension('E')->setWidth(1.66, 'cm');
            $sheet->getColumnDimension('F')->setWidth(1.66, 'cm');
            $sheet->getColumnDimension('G')->setWidth(1.66, 'cm');
            $sheet->getColumnDimension('H')->setWidth(2.46, 'cm');
            $sheet->getColumnDimension('I')->setWidth(2.49, 'cm');
            $sheet->getColumnDimension('J')->setWidth(1.66, 'cm');
            $sheet->getColumnDimension('K')->setWidth(3.55, 'cm');
            $sheet->getColumnDimension('L')->setWidth(3.55, 'cm');
            $sheet->getColumnDimension('M')->setWidth(3.55, 'cm');
            $sheet->getColumnDimension('N')->setWidth(0.41, 'cm');
            $sheet->getColumnDimension('O')->setWidth(3.14, 'cm');
            $sheet->getColumnDimension('P')->setWidth(3.55, 'cm');
            $sheet->getColumnDimension('Q')->setWidth(3.55, 'cm');
            $sheet->getColumnDimension('R')->setWidth(3.55, 'cm');
            $sheet->getRowDimension('8')->setRowHeight(0.15, 'cm');
            $isiheader = $this->akbmodel->getdatabyid($id);
            $kurssekarang = getkurssekarang($isiheader['tgl_aju'])->row_array();
            $inv = $this->akbmodel->exceljaminan261($id);
            $numrow = 13;
            $no = 1;
            $nok = 1;
            $sumbm = 0;
            $sumppn = 0;
            $sumpph = 0;
            foreach ($inv->result_array() as $data) {
                $sku = $data['kode'];
                $spekbarang = namaspekbarang($data['id_barang']);

                $hs = substr($data['nohs'], 0, 8);
                // $pembagi = $data['hamat_weight']==0 ? 1 : $data['hamat_weight'];
                // switch ($data['mt_uang']) {
                //     case 'IDR':
                //         $hargaperkilo = round($data['hamat_harga']/$pembagi,2);
                //         break;
                //     case 'USD':
                //         $hargaperkilo = ($data['cif']/$pembagi)*$kurssekarang['usd'];
                //         break;
                //         break;
                //     case 'JPY':
                //         $hargaperkilo = ($data['cif']/$pembagi)*$kurssekarang['jpy'];
                //         break;

                //     default:
                //         # code...
                //         break;
                // }
                $hargaperkilo = 0;
                $kursusd = $kurssekarang['usd'];
                $ndpbm = $data['mt_uang'] == '' || $data['mt_uang'] == 'IDR' ? 0 : $kurssekarang['usd'];
                $pembagi = $data['hamat_weight'] == 0 ? 1 : $data['hamat_weight'];
                switch ($data['mt_uang']) {
                    case 'JPY':
                        $jpy = $data['cif'] * $kurssekarang[strtolower($data['mt_uang'])];
                        $cif = $jpy / $kursusd;
                        break;
                    default:
                        $cif = $data['cif'];
                        break;
                }
                $jmmm = (($cif / $pembagi) * $ndpbm) * $data['kgs'];
                $hargaperkilo = round(($cif / $pembagi) * $data['kgs'], 2) * $ndpbm;
                $adabm = $data['bm'] > 0 ? $jmmm * ($data['bm'] / 100) : 0;
                if ($data['jns_bc'] == 23) {
                    $jmbm = round($hargaperkilo * ($data['bm'] / 100), 0);
                    $jmppn = round(($adabm + $hargaperkilo) * ($data['ppn'] / 100), 0);
                    $jmpph = round(($adabm + $hargaperkilo) * ($data['pph'] / 100), 0);
                } else {
                    $jmbm = 0;
                    $jmppn = 0;
                    $jmpph = 0;
                }
                $totaljamin = $jmbm + $jmppn + $jmpph;
                $sumbm += $jmbm;
                $sumppn += $jmppn;
                $sumpph += $jmpph;
                // Lakukan looping pada variabel      
                $numasal = $numrow;
                $sheet->setCellValue('A' . $numrow, $no);
                $sheet->getStyle('A' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
                $sheet->setCellValue('B' . $numrow, $sku);
                $sheet->setCellValue('E' . $numrow, round($data['kgs'], 2));
                $sheet->setCellValue('F' . $numrow, 'KGM');
                $sheet->setCellValue('G' . $numrow, $data['jns_bc']);
                $sheet->setCellValue('H' . $numrow, $data['nomor_bc']);
                $sheet->setCellValue('I' . $numrow, $data['tgl_bc']);
                $sheet->setCellValue('K' . $numrow, round($jmbm, 2));
                $sheet->setCellValue('L' . $numrow, $data['bmt']);
                $sheet->setCellValue('M' . $numrow, $data['cukai']);
                $sheet->setCellValue('N' . $numrow, round($jmppn, 2));
                $sheet->mergeCells('N' . $numrow . ':O' . $numrow);
                $sheet->setCellValue('P' . $numrow, $data['ppnbm']);
                $sheet->setCellValue('Q' . $numrow, round($jmpph, 2));
                $sheet->setCellValue('R' . $numrow, round($totaljamin, 2));
                // $sheet->setCellValue('G' . $numrow, $data['kgs']);
                $nok = $numrow;
                $nol = 1;
                $numrow++;
                $sheet->setCellValue('B' . $numrow, ' ' . $data['nohs']);
                $numrow++;
                $sheet->setCellValue('B' . $numrow, $spekbarang);
                $sheet->getStyle('A' . $numasal . ':A' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('B' . $numasal . ':D' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('E' . $numasal . ':E' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('F' . $numasal . ':F' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('G' . $numasal . ':G' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('H' . $numasal . ':H' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('I' . $numasal . ':I' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('J' . $numasal . ':J' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('K' . $numasal . ':K' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('L' . $numasal . ':L' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('M' . $numasal . ':M' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('N' . $numasal . ':O' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('P' . $numasal . ':P' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('Q' . $numasal . ':Q' . $numrow)->applyFromArray($styleArray);
                $sheet->getStyle('R' . $numasal . ':R' . $numrow)->applyFromArray($styleArray);
                $numrow++;
                // $sheet->setCellValue('H' . $nok, "XXXX");
                $no++;
                // Tambah 1 setiap kali looping      
            }
            $sheet->mergeCells('A' . $numrow . ':J' . $numrow);
            $sheet->setCellValue('A' . $numrow, "TOTAL");
            $sheet->getStyle('A' . $numrow)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
            $sheet->getStyle('A' . $numrow . ':J' . $numrow)->applyFromArray($styleArray);
            $sheet->setCellValue('K' . $numrow, round($sumbm, 2));
            $sheet->getStyle('K' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('L' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('M' . $numrow)->applyFromArray($styleArray);
            $sheet->getStyle('P' . $numrow)->applyFromArray($styleArray);
            $sheet->mergeCells('N' . $numrow . ':O' . $numrow);
            $sheet->setCellValue('N' . $numrow, round($sumppn, 2));
            $sheet->getStyle('N' . $numrow . ':O' . $numrow)->applyFromArray($styleArray);
            $sheet->setCellValue('Q' . $numrow, round($sumpph, 2));
            $sheet->getStyle('Q' . $numrow)->applyFromArray($styleArray);
            $sheet->setCellValue('R' . $numrow, round($sumbm + $sumppn + $sumpph, 2));
            $sheet->getStyle('R' . $numrow)->applyFromArray($styleArray);
        } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
            die('Error loading file: ' . $e->getMessage());
        }

        $sheet = $spreadsheet->setActiveSheetIndex(0);
        // // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        // $sheet->setTitle("Lampiran Permohonan dan Kontrak");

        // Proses file excel    
        ob_end_clean();
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Perhitungan Jaminan "' . $id . '".xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel Perhitungan Jaminan' . $this->session->userdata('currdept'));

        $spreadsheet->disconnectWorksheet();
        unset($spreadsheet);
    }
    public function buatbonexcel($id, $mode = 0)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA TIDAK ADA DI BOM MATERIAL "); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE BARANG / SKU"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "INSNO");
        $sheet->setCellValue('D2', "SPESIFIKASI"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('E2', "NOBONTR");
        $sheet->setCellValue('G2', "BON GAICHU");
        $sheet->setCellValue('H2', "PCS");
        $sheet->setCellValue('I2', "KGS");
        $isiheader = $this->akbmodel->getdatabyid($id);
        $inv = $this->akbmodel->getdatadetailib($id, 1, $isiheader['urutakb']);
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;
        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($inv as $data) {
            $sku = viewsku($data['po'], $data['item'], $data['dis'], $data['id_barang']);
            $spekbarang = trim($data['po']) == '' ? namaspekbarang($data['id_barang']) : spekpo($data['po'], $data['item'], $data['dis']);
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $sku);
            $sheet->setCellValue('C' . $numrow, $data['insno']);
            $sheet->setCellValue('D' . $numrow, $spekbarang);
            $sheet->setCellValue('E' . $numrow, $data['nobontr']);
            $sheet->setCellValue('F' . $numrow, '');
            $sheet->setCellValue('G' . $numrow, $data['dokgaichu']);
            $sheet->setCellValue('H' . $numrow, $data['pcs']);
            $sheet->setCellValue('I' . $numrow, $data['kgs']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }

        // $newSheet2 = $spreadsheet->createSheet(1); // Index 1 for the second position (0-based)
        // $newSheet2->setTitle('Inserted Sheet');

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle(" DATA");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Detail "' . $id . '".xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel BOM INVENTORY' . $this->session->userdata('currdept'));
    }
    public function toexcel($id, $mode = 0)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA TIDAK ADA DI BOM MATERIAL "); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE BARANG / SKU"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "INSNO");
        $sheet->setCellValue('D2', "SPESIFIKASI"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('E2', "NOBONTR");
        $sheet->setCellValue('F2', "KETERANGAN");

        $inv = $this->akbmodel->hitungbomjf($id, $mode);
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;
        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($inv['ng'] as $data) {
            $sku = viewsku($data['po'], $data['item'], $data['dis'], $data['id_barang']);
            $spekbarang = trim($data['po']) == '' ? namaspekbarang($data['id_barang']) : spekpo($data['po'], $data['item'], $data['dis']);
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $sku);
            $sheet->setCellValue('C' . $numrow, $data['insno']);
            $sheet->setCellValue('D' . $numrow, $spekbarang);
            $sheet->setCellValue('E' . $numrow, $data['nobontr']);
            $sheet->setCellValue('F' . $numrow, '');
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }

        // $newSheet2 = $spreadsheet->createSheet(1); // Index 1 for the second position (0-based)
        // $newSheet2->setTitle('Inserted Sheet');

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle(" DATA");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data INV.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel BOM INVENTORY' . $this->session->userdata('currdept'));
    }
    public function simpanbomkeexcel($id, $mode = 0)
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA BOM MATERIAL "); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "SERI"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('C2', "KODE BARANG / SKU"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('D2', "SPESIFIKASI"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('E2', "NOBONTR");
        $sheet->setCellValue('F2', "PCS");
        $sheet->setCellValue('G2', "KGS");

        $inv = $this->akbmodel->hitungbomjf($id, $mode);
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;
        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($inv['ok'] as $data) {
            $sku = viewsku($data['po'], $data['item'], $data['dis'], $data['id_barang']);
            $spekbarang = trim($data['po']) == '' ? namaspekbarang($data['id_barang']) : spekpo($data['po'], $data['item'], $data['dis']);
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['noe']);
            $sheet->setCellValue('C' . $numrow, $sku);
            $sheet->setCellValue('D' . $numrow, $spekbarang);
            $sheet->setCellValue('E' . $numrow, $data['nobontr']);
            $sheet->setCellValue('F' . $numrow, $data['pcs_asli']);
            $sheet->setCellValue('G' . $numrow, $data['kgs_asli']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }

        // $newSheet2 = $spreadsheet->createSheet(1); // Index 1 for the second position (0-based)
        // $newSheet2->setTitle('Inserted Sheet');

        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle(" DATA");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data INV.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel BOM INVENTORY' . $this->session->userdata('currdept'));
    }

    public function upload($id)
    {
        $data['id'] = $id;
        $this->load->view('akb/upload', $data);
    }
    public function edit_file($id)
    {
        $data['id'] = $id;
        $data['detail'] = $this->akbmodel->getdatabyid($id);
        $this->load->view('akb/edit_file', $data);
    }

    public function simpan_upload($id)
    {
        $config['upload_path'] = './assets/image/akb/';
        $config['allowed_types'] = 'jpg|png|jpeg|gif|mp4|pdf|doc|docx|xls|xlsx|zip';
        $config['max_size'] = 20240; // 20 MB
        $this->load->library('upload', $config);
        $files = $_FILES['file_upload'];


        $file_names = [];
        $file_types = [];
        $file_paths = [];


        $is_file_uploaded = false;
        for ($i = 0; $i < count($files['name']); $i++) {
            if (!empty($files['name'][$i])) {
                $is_file_uploaded = true;
                $_FILES['file_upload']['name'] = $files['name'][$i];
                $_FILES['file_upload']['type'] = $files['type'][$i];
                $_FILES['file_upload']['tmp_name'] = $files['tmp_name'][$i];
                $_FILES['file_upload']['error'] = $files['error'][$i];
                $_FILES['file_upload']['size'] = $files['size'][$i];


                $this->upload->initialize($config);

                if ($this->upload->do_upload('file_upload')) {
                    $upload_data = $this->upload->data();
                    $file_names[] = $upload_data['file_name'];
                    $file_types[] = $upload_data['file_type'];
                    $file_paths[] = 'assets/image/akb/' . $upload_data['file_name'];
                } else {

                    $error = $this->upload->display_errors();
                    $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error . '</div>');
                    redirect('akb/isidokbc/' . $id . '/' . '1');
                    return;
                }
            }
        }


        $data = [
            // 'id' => $this->input->post('id'),
            'file' => $is_file_uploaded ? json_encode($file_names) : null,
            'file_type' => $is_file_uploaded ? json_encode($file_types) : null,
            'path_file' => $is_file_uploaded ? json_encode($file_paths) : null,
        ];

        $query = $this->akbmodel->UpdateData_gambar($id, $data);
        if ($query) {
            $this->session->set_flashdata('message', '
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                 File Berhasil Di Upload!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        }

        redirect('akb/isidokbc/' . $id . '/' . '1');
    }

    public function edit_upload($id)
    {
        $config['upload_path'] = './assets/image/akb/';
        $config['allowed_types'] = 'jpg|png|jpeg|gif|mp4|pdf|doc|docx|xls|xlsx|zip';
        $config['max_size'] = 20240; // 20 MB
        $this->load->library('upload', $config);

        $detail = $this->akbmodel->getdatabyid($id);
        $old_files = !empty($detail['file']) ? json_decode($detail['file'], true) : [];
        $old_file_paths = !empty($detail['path_file']) ? json_decode($detail['path_file'], true) : [];
        $old_file_types = !empty($detail['file_type']) ? json_decode($detail['file_type'], true) : [];

        $hapus_file = $this->input->post('hapus_file') ?? [];

        $filtered_old_files = [];
        $filtered_file_paths = [];
        $filtered_file_types = [];

        foreach ($old_files as $i => $filename) {
            if (!in_array($filename, $hapus_file)) {
                $filtered_old_files[] = $filename;
                if (isset($old_file_paths[$i])) $filtered_file_paths[] = $old_file_paths[$i];
                if (isset($old_file_types[$i])) $filtered_file_types[] = $old_file_types[$i];
            }
        }

        foreach ($hapus_file as $file) {
            $path = 'assets/image/akb/' . $file;
            if (file_exists($path)) {
                unlink($path);
            }
        }

        $rename_files = $this->input->post('rename_file');
        $nama_file_asli = $this->input->post('nama_file_asli');

        if ($rename_files && $nama_file_asli) {
            foreach ($rename_files as $i => $rename) {
                $old_name = $nama_file_asli[$i];
                if (!empty($rename) && in_array($old_name, $filtered_old_files)) {
                    $old_path = 'assets/image/akb/' . $old_name;

                    $ext = pathinfo($old_name, PATHINFO_EXTENSION);
                    $rename_clean = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($rename, PATHINFO_FILENAME));
                    $new_name = $rename_clean . '.' . $ext;
                    $new_path = 'assets/image/akb/' . $new_name;

                    if (file_exists($old_path)) {
                        rename($old_path, $new_path);

                        $key = array_search($old_name, $filtered_old_files);
                        if ($key !== false) {
                            $filtered_old_files[$key] = $new_name;
                            $filtered_file_paths[$key] = $new_path;
                        }
                    }
                }
            }
        }

        $files = $_FILES['file_upload'];
        $new_files = [];
        $new_file_paths = [];
        $new_file_types = [];

        if (!empty($files['name'][0])) {
            for ($i = 0; $i < count($files['name']); $i++) {
                if (!empty($files['name'][$i])) {
                    $_FILES['file_upload_temp']['name'] = $files['name'][$i];
                    $_FILES['file_upload_temp']['type'] = $files['type'][$i];
                    $_FILES['file_upload_temp']['tmp_name'] = $files['tmp_name'][$i];
                    $_FILES['file_upload_temp']['error'] = $files['error'][$i];
                    $_FILES['file_upload_temp']['size'] = $files['size'][$i];

                    $this->upload->initialize($config);

                    if ($this->upload->do_upload('file_upload_temp')) {
                        $upload_data = $this->upload->data();
                        $new_files[] = $upload_data['file_name'];
                        $new_file_paths[] = $config['upload_path'] . $upload_data['file_name'];
                        $new_file_types[] = $upload_data['file_type'];
                    } else {
                        $error = $this->upload->display_errors();
                        $this->session->set_flashdata('message', '<div class="alert alert-danger">' . $error . '</div>');
                        redirect('akb/isidokbc/' . $id . '/' . '1');
                        return;
                    }
                }
            }
        }

        $all_files = array_merge($filtered_old_files, $new_files);
        $all_file_paths = array_merge($filtered_file_paths, $new_file_paths);
        $all_file_types = array_merge($filtered_file_types, $new_file_types);

        $data = [
            'file' => !empty($all_files) ? json_encode(array_values($all_files)) : null,
            'file_type' => !empty($all_file_types) ? json_encode(array_values($all_file_types)) : null,
            'path_file' => !empty($all_file_paths) ? json_encode(array_values($all_file_paths)) : null,

        ];

        $query = $this->akbmodel->UpdateData_gambarkedua($id, $data);

        if ($query) {
            $this->session->set_flashdata('message', '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
           File Berhasil Diupdate!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }

        redirect('akb/isidokbc/' . $id . '/' . '1');
    }

    public function tambahbarangversiceisa($id){
        $data['header'] = $this->akbmodel->getdatabyid($id);
        $data['bahan'] = $this->akbmodel->getdatadetailib($id);
        $data['idheader'] = $id;
        $this->load->view('akb/addbahanbaku', $data);
    }

    public function caribahanbaku()
    {
        $kode = $_POST['kode'];
        $hasil = $this->akbmodel->getbarangmaterial($kode);
        $html = '';
        $no = 0;
        foreach ($hasil->result_array() as $bahan) {
            $no++;
            $html .= '<tr>';
            $html .= '<td>'.$no.'</td>';
            $html .= '<td>'.$bahan['kode'].'</td>';
            $html .= '<td>'.$bahan['nama_barang'].'</td>';
            $html .= '<td class="line-12">'.$bahan['nobontr'].'<br><span class="font-11 text-pink">'.$bahan['nomor_bc'].' tgl.'.$bahan['tgl_bc'].'</span></td>';
            $html .= '<td class="text-right">'.rupiah($bahan['kgs']-$bahan['in_exbc'],2).'</td>';
            $html .= '<td>';
            $html .= '<a href="#" class="btn btn-sm btn-success" id="tombolpilih" rel="' . $bahan['id_barang'] . '" rel2="' . $bahan['nobontr'] . '" rel3 ="' . $bahan['nama_barang'] . '">Pilih</a>';
            $html .= '</td>';
            $html .= '</tr>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function simpanbahanbaku()
    {
        $data = [
            'id_header' => $_POST['id'],
            'id_barang' => $_POST['idbarang'],
            'nobontr' => $_POST['bontr'],
            'kgs' => toAngka($_POST['kgs']),
            'seri_barang' => $_POST['seri']
        ];
        $hasil = $this->akbmodel->simpanbahanbaku($data);
        echo $hasil;
    }
    public function hapusbombc($id, $idh)
    {
        $hasil = $this->akbmodel->hapusbombc($id);
        if ($hasil) {
            $url = base_url('akb/isidokbc/' . $idh);
            redirect($url);
        }
    }
}
