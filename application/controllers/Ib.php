<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Ib extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('ib_model', 'ibmodel');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('supplier_model', 'suppliermodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('mtuangmodel');
        $this->load->model('helper_model','helpermodel');
        $this->load->model('kontrak_model','kontrakmodel');

        $this->load->library('Pdf');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'transaksi';
        $data['level'] = $this->usermodel->getdatalevel();
        // $data['hakdep'] = $this->deptmodel->gethakdept($this->session->userdata('arrdep'));
        $data['hakdep'] = $this->deptmodel->getdeptmasuk();
        $data['dephak'] = $this->deptmodel->getdata();
        $data['depbbl'] = $this->deptmodel->getdata_dept_bbl(1);
        $kode = $this->session->userdata('depttuju');
        $data['data'] = $this->ibmodel->getdata($kode);
        $data['datatoken'] = $this->ibmodel->gettokenbc()->row_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ib';
        $this->load->view('layouts/header', $header);
        $this->load->view('ib/ib', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->set_userdata('bl', (int)date('m'));
        $this->session->set_userdata('th', date('Y'));
        $this->session->set_userdata('depttuju', '');
        $url = base_url() . 'ib';
        redirect($url);
    }
    public function ubahperiode()
    {
        $this->session->set_userdata('bl', $_POST['bl']);
        $this->session->set_userdata('th', $_POST['th']);
        echo 1;
    }
    public function getdataib()
    {
        $this->session->set_userdata('depttuju', $_POST['dept']);
        echo 1;
    }
    public function tambahdataib($stat = 0)
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
        $query = $this->ibmodel->hapusib($id);
        if ($query) {
            $url = base_url() . 'ib';
            redirect($url);
        }
    }

    public function viewdetail($id, $mode = 0)
    {
        $data['header'] = $this->ibmodel->getdatabyid($id);
        $data['detail'] = $this->ibmodel->getdatadetailib($id, $mode);
        $data['lampiran'] = $this->ibmodel->getdatalampiran($id);
        $data['mode'] = $mode;
        $this->load->view('ib/viewdetailib', $data);
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
        if ($cekdetail['xharga'] == 0 && $cekdetail['kosong'] == 0) {
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
        $data['header'] = $this->ibmodel->getdatadetailib($id, $mode);
        $data['datheader'] = $this->ibmodel->getdatabyid($id);
        $data['bcmasuk'] = $this->ibmodel->getbcmasuk();
        $data['jnsangkutan'] = $this->ibmodel->getjnsangkutan();
        $data['refkemas'] = $this->ibmodel->refkemas();
        $data['refmtuang'] = $this->ibmodel->refmtuang();
        $data['refbendera'] = $this->ibmodel->refbendera();
        // $data['refpelabuhan'] = $this->ibmodel->refpelabuhan();
        $data['datatoken'] = $this->ibmodel->gettokenbc()->row_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $data['mode'] = $mode;
        $footer['fungsi'] = 'ibx';
        $this->load->view('layouts/header', $header);
        $this->load->view('ib/isidokbc', $data);
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
            $this->ibmodel->isitokenbc($data);
            $this->session->set_userdata('datatokenbeacukai', $databalik['item']['access_token']);
            $this->helpermodel->isilog('Refresh Token CEISA 40');
            if ($id = 99) {
                $url = base_url() . 'ib';
            } else {
                $url = base_url() . 'ib/isidokbc/' . $id;
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
    public function getresponhost($id)
    {
        $dataaju = $this->ibmodel->getdatanomoraju($id);
        $headerib = $this->ibmodel->getdatabyid($id);
        $token = $this->ibmodel->gettoken();
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
                $hasil = $this->ibmodel->simpanresponbc($data);
                if ($hasil) {
                    $this->helpermodel->isilog("Berhasil GET RESPON AJU " . $dataaju . " (" . $databalik['dataStatus'][0]['nomorDaftar'] . ")");
                    $this->session->set_flashdata('errorsimpan', 2);
                    $this->session->set_flashdata('pesanerror', 'Respon sudah berhasil di Tarik');
                }
                if($headerib['jns_bc']=='40'){
                    $simpankehargamaterial = $this->ibmodel->simpankehargamaterial($id);
                }
            } else {
                $this->session->set_flashdata('errorsimpan', 1);
                $this->session->set_flashdata('pesanerror', 'Nomor Pendaftaran Masih kosong, ' . $databalik['dataStatus'][0]['keterangan']);
            }
            $url = base_url() . 'ib/isidokbc/' . $id;
            redirect($url);
        } else {
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', $databalik['message'] . '[EXCEPTION]' . $databalik['Exception']);
            // $url = base_url().'ib/isidokbc/'.$id;
            $url = base_url() . 'ib/isidokbc/' . $id;
            redirect($url);
        }
    }
    public function getresponpdf($id, $mode = 0)
    {
        $dataaju = $this->ibmodel->getdatanomoraju($id);
        $token = $this->ibmodel->gettoken();
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
            $url = $mode = 0 ? base_url() . 'ib/isidokbc/' . $id : base_url() . 'ib';
            redirect($url);
        } else {
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', $databalik['message'] . '[EXCEPTION]' . $databalik['Exception']);
            // $url = base_url().'ib/isidokbc/'.$id;
            $url = $mode = 0 ? base_url() . 'ib/isidokbc/' . $id : base_url() . 'ib';
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
        header('Content-Disposition: attachment; filename="' . $lokfile . '"');
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
    public function addkontainer($id)
    {
        $data['datheader'] = $this->ibmodel->getdatabyid($id);
        $data['lampiran'] = $this->ibmodel->getjenisdokumen();
        $this->load->view('ib/addkontainer', $data);
    }
    public function tambahkontainer()
    {
        $data = [
            'id_header' => $_POST['id'],
            'nomor_kontainer' => $_POST['nomor'],
            'ukuran_kontainer' => $_POST['ukuran'],
            'jenis_kontainer' => $_POST['jenis'],
            'tipe_kontainer' => 1
        ];
        $header = $_POST['id'];
        $hasil = $this->ibmodel->tambahkontainer($data);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $html = '';
            $query = $this->ibmodel->getdatakontainer($header);
            foreach ($query->result_array() as $que) {
                $html .= '<tr>';
                $html .= '<td>' . $que['jeniskontainer'] . '</td>';
                $html .= '<td>' . $que['nomor_kontainer'] . '</td>';
                $html .= '<td>' . $que['ukurkontainer'] . '</td>';
                $html .= '<td class="text-center">';
                $html .= '<a href="' . base_url() . 'ib/hapuskontainer/' . $que['id'] . '/' . $que['id_header'] . '" class="btn btn-danger py-0 px-1 btn-flat" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus Kontainer"><i class="fa fa-minus"></i></a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $cocok = array('datagroup' => $html);
            echo json_encode($cocok);
        }
    }
    public function getdatakontainer($id)
    {
        $html = '';
        $query = $this->ibmodel->getdatakontainer($id);
        $jumlahrek = $query->num_rows();
        if ($jumlahrek > 0) {
            foreach ($query->result_array() as $que) {
                $html .= '<tr>';
                $html .= '<td>' . $que['jeniskontainer'] . '</td>';
                $html .= '<td>' . $que['nomor_kontainer'] . '</td>';
                $html .= '<td>' . $que['ukurkontainer'] . '</td>';
                $html .= '<td class="text-center">';
                $html .= '<a href="' . base_url() . 'ib/hapuskontainer/' . $que['id'] . '/' . $que['id_header'] . '" class="btn btn-danger py-0 px-1 btn-flat" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus Kontainer"><i class="fa fa-minus"></i></a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr>';
            $html .= '<td colspan="4" class="text-center p-1">- Data tidak Ada -</td>';
            $html .= '</tr>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function hapuskontainer($id, $ide)
    {
        $data = [
            'id' => $id,
            'header' => $ide
        ];
        $this->load->view('ib/hapuskontainer', $data);
    }
    public function hapuskont()
    {
        $data = $_POST['id'];
        $header = $_POST['head'];
        $hasil = $this->ibmodel->hapuskontainer($data);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $html = '';
            $query = $this->ibmodel->getdatakontainer($header);
            $no = 1;
            $jumlahrek = $query->num_rows();
            if ($jumlahrek > 0) {
                foreach ($query->result_array() as $que) {
                    $html .= '<tr>';
                    $html .= '<td>' . $que['jeniskontainer'] . '</td>';
                    $html .= '<td>' . $que['nomor_kontainer'] . '</td>';
                    $html .= '<td>' . $que['ukurkontainer'] . '</td>';
                    $html .= '<td class="text-center">';
                    $html .= '<a href="' . base_url() . 'ib/hapuskontainer/' . $que['id'] . '/' . $que['id_header'] . '" class="btn btn-danger py-0 px-1 btn-flat" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus Kontainer"><i class="fa fa-minus"></i></a>';
                    $html .= '</td>';
                    $html .= '</tr>';
                }
            } else {
                $html .= '<tr>';
                $html .= '<td colspan="4" class="text-center p-1">- Data tidak Ada -</td>';
                $html .= '</tr>';
            }
            $cocok = array('datagroup' => $html);
            echo json_encode($cocok);
        }
    }
    public function getdataentitas($id)
    {
        $html = '';
        $query = $this->ibmodel->getdataentitas($id);
        $jumlahrek = $query->num_rows();
        if ($jumlahrek > 0) {
            foreach ($query->result_array() as $que) {
                $kodentitas = $que['kode_entitas'] == 7 ? 'PEMILIK' : ($que['kode_entitas'] == 5 ? 'PEMASOK' : '');
                $html .= '<tr>';
                $html .= '<td class="font-bold">' . $kodentitas . '</td>';
                $html .= '<td>' . $que['no_identitas'] . '</td>';
                $html .= '<td>' . $que['nama'] . '</td>';
                $html .= '<td>' . $que['alamat'] . '</td>';
                $html .= '<td>' . $que['negara'] . '</td>';
                $html .= '<td class="text-center">';
                $html .= '<a href="' . base_url() . 'ib/hapusentitas/' . $que['id'] . '/' . $que['id_header'] . '" class="btn btn-danger py-0 px-1 btn-flat" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus Kontainer"><i class="fa fa-minus"></i></a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
        } else {
            $html .= '<tr>';
            $html .= '<td colspan="6" class="text-center p-1">- Data tidak Ada -</td>';
            $html .= '</tr>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function addentitas($id)
    {
        // $data['datheader'] = $this->ibmodel->getdatabyid($id);
        $data['datheader'] = $id;
        $data['negara'] = $this->ibmodel->refbendera();
        $this->load->view('ib/addentitas', $data);
    }
    public function tambahentitas()
    {
        $data = [
            'id_header' => $_POST['id'],
            'kode_entitas' => $_POST['kode'],
            'no_identitas' => $_POST['no'],
            'nama' => $_POST['nama'],
            'alamat' => $_POST['alamat'],
            'kode_negara' => $_POST['negara'],
        ];
        $header = $_POST['id'];
        $hasil = $this->ibmodel->tambahentitas($data);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $html = '';
            $query = $this->ibmodel->getdataentitas($header);
            foreach ($query->result_array() as $que) {
                $kodentitas = $que['kode_entitas'] == 7 ? 'PEMILIK' : ($que['kode_entitas'] == 5 ? 'PEMASOK' : '');
                $html .= '<tr>';
                $html .= '<td>' . $kodentitas . '</td>';
                $html .= '<td>' . $que['no_identitas'] . '</td>';
                $html .= '<td>' . $que['nama'] . '</td>';
                $html .= '<td>' . $que['alamat'] . '</td>';
                $html .= '<td>' . $que['negara'] . '</td>';
                $html .= '<td class="text-center">';
                $html .= '<a href="' . base_url() . 'ib/hapusentitas/' . $que['id'] . '/' . $que['id_header'] . '" class="btn btn-danger py-0 px-1 btn-flat" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus Kontainer"><i class="fa fa-minus"></i></a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $cocok = array('datagroup' => $html);
            echo json_encode($cocok);
        }
    }
    public function hapusentitas($id, $ide)
    {
        $data = [
            'id' => $id,
            'header' => $ide
        ];
        $this->load->view('ib/hapusentitas', $data);
    }
    public function hapusenti()
    {
        $data = $_POST['id'];
        $header = $_POST['head'];
        $hasil = $this->ibmodel->hapusenti($data);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $html = '';
            $query = $this->ibmodel->getdataentitas($header);
            $no = 1;
            $jumlahrek = $query->num_rows();
            if ($jumlahrek > 0) {
                foreach ($query->result_array() as $que) {
                    $kodentitas = $que['kode_entitas'] == 7 ? 'PEMILIK' : ($que['kode_entitas'] == 5 ? 'PEMASOK' : '');
                    $html .= '<tr>';
                    $html .= '<td>' . $kodentitas . '</td>';
                    $html .= '<td>' . $que['no_identitas'] . '</td>';
                    $html .= '<td>' . $que['nama'] . '</td>';
                    $html .= '<td>' . $que['alamat'] . '</td>';
                    $html .= '<td>' . $que['negara'] . '</td>';
                    $html .= '<td class="text-center">';
                    $html .= '<a href="' . base_url() . 'ib/hapusentitas/' . $que['id'] . '/' . $que['id_header'] . '" class="btn btn-danger py-0 px-1 btn-flat" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus Kontainer"><i class="fa fa-minus"></i></a>';
                    $html .= '</td>';
                    $html .= '</tr>';
                }
            } else {
                $html .= '<tr>';
                $html .= '<td colspan="6" class="text-center p-1">- Data tidak Ada -</td>';
                $html .= '</tr>';
            }
            $cocok = array('datagroup' => $html);
            echo json_encode($cocok);
        }
    }
    function kirimdatakeceisa40($id)
    {
        $data = $this->ibmodel->getdatabyid($id);
        $noaju = isikurangnol($data['jns_bc']) . '010017' . str_replace('-', '', $data['tgl_aju']) . $data['nomor_aju'];
        $isMakloon = $data['bc_makloon']==1;
        $arrayheader = [
            "asalData" => "S",
            "asuransi" => 0,
            "bruto" => (float) $data['bruto'],
            "cif" => 0,
            "kodeJenisTpb" => "1",
            "freight" => 0,
            "hargaPenyerahan" => (float) $data['totalharga'],
            "idPengguna" => "",
            "jabatanTtd" => strtoupper($data['jabat_tg_jawab']),
            "jumlahKontainer" => 0,
            "kodeDokumen" => $data['jns_bc'],
            "kodeKantor" => "050500",
            "kodeTujuanPengiriman" => $isMakloon ? "5" : "1",
            "kotaTtd" => "BANDUNG",
            "namaTtd" => strtoupper($data['tg_jawab']),
            "netto" => (float) $data['netto'],
            "nik" => "",
            "nomorAju" => $noaju,
            "seri" => 1,
            "tanggalAju" => $data['tgl_aju'],
            "tanggalTtd" => $data['tgl_aju'],
            "volume" => 0,
            "biayaTambahan" => 0,
            "biayaPengurang" => 0,
            "vd" => 0,
            "uangMuka" => 0,
            "nilaiJasa" => 0,
        ];
        $arrayentitas = [];
        for ($ke = 1; $ke <= 3; $ke++) {
            $alamatifn = "JL RAYA BANDUNG-GARUT KM. 25, CANGKUANG, RANCAEKEK, KAB. BANDUNG, JAWA BARAT, 40394";
            $kodeentitas = $ke == 1 ? "3" : (($ke == 2) ? "7" : "9");
            if($ke == 2 && $isMakloon){
                $nomoridentitas = $data['jns_pkp'] == 1 ? $data['nik'] . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', $data['nik'])))))) : '0' . $data['npwp'] . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', $data['npwp'])))) + 1));
                $namaidentitas = $data['jns_pkp'] == 1 ? $data['namaceisa'] : $data['namasupplier'];
                $alamat = $data['jns_pkp'] == 1 ? $data['alamatceisa'] : strtoupper($data['alamat']);
            }else{
                if ($ke == 3) {
                    $nomoridentitas = $data['jns_pkp'] == 1 ? $data['nik'] . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', $data['nik'])))))) : '0' . $data['npwp'] . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', $data['npwp'])))) + 1));
                    $namaidentitas = $data['jns_pkp'] == 1 ? $data['namaceisa'] : $data['namasupplier'];
                    $alamat = $data['jns_pkp'] == 1 ? $data['alamatceisa'] : strtoupper($data['alamat']);
                } else {
                    $nomoridentitas = $ke == 1 ? "0010017176057000000000" : (($ke == 2) ? "0010017176057000000000" : '0' . $data['npwp'] . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', $data['npwp'])))) + 1)));
                    $namaidentitas = $ke == 1 ? "INDONEPTUNE NET MANUFACTURING" : (($ke == 2) ? "INDONEPTUNE NET MANUFACTURING" : $data['namasupplier']);
                    $alamat = $ke == 1 ? $alamatifn : (($ke == 2) ? $alamatifn : $data['alamat']);
                }
            }
            $nibidentitas = $ke == 1 ? "9120011042693" : "";
            $arrayke = [
                "seriEntitas" => $ke,
                "alamatEntitas" => $alamat,
                "kodeEntitas" => $kodeentitas,
                "kodeJenisIdentitas" => "6",
                "namaEntitas" => trim($namaidentitas),
                "nibEntitas" => $nibidentitas,
                "nomorIdentitas" => trim(str_replace('-', '', str_replace('.', '', $nomoridentitas))),
            ];
            if ($ke > 1) {
                $arrayke["kodeJenisApi"] = "2";
            }
            if ($ke < 3) {
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
        $datadet = $this->ibmodel->getdatadetailib($id, 0);
        $no = 0;
        $jumlahfasilitas = 0;
        foreach ($datadet as $detx) {
            $no++;
            $jumlah = $detx['kodesatuan'] == 'KGS' ? $detx['kgs'] : $detx['pcs'];
            $arrayke = [
                "seriBarang" => $no,
                "asuransi" => 0,
                "bruto" => 0,
                "hargaPenyerahan" => round((float) $detx['harga'] * $jumlah, 2),
                "jumlahSatuan" => (int) $jumlah,
                "kodeBarang" => $detx['brg_id'],
                "kodeDokumen" => "40",
                "kodeJenisKemasan" => $data['kd_kemasan'],
                "kodeSatuanBarang" => $detx['satbc'],
                "merk" => "-",
                "netto" => (float) $detx['kgs'],
                "nilaiBarang" => 0,
                "posTarif" => trim($detx['nohs']), //Nomor HS
                "spesifikasiLain" => "",
                "tipe" => "-",
                "ukuran" => "",
                "uraian" => "",
                "volume" => 0,
                "jumlahKemasan" => (int) $data['jml_kemasan'],
                "uraian" => trim($detx['nama_barang'])
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
                "kodeJenisPungutan" => "PPN",
                "kodeJenisTarif" => "1"
            ];
            $jumlahfasilitas += ($detx['harga'] * $jumlah) * 0.11;
            array_push($arraytarif, $barangtarif);
            $arrayke['barangTarif'] = $arraytarif;
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
            "subposBc11" => $data['nomor_subposbc11'],
            "tanggalBc11" => $data['tgl_bc11'],
            "tanggalTiba" => $data['tgl'],
            "tanggalTtd" => $data['tgl_aju'],
            "biayaTambahan" => 0,
            "biayaPengurang" => 0,
            "kodeKenaPajak" => "1"
        ];
        $dataentitas = $this->ibmodel->getdataentitas($id);
        $ke = 1;
        $arrayentitas = [];
        for ($ke = 1; $ke <= 1; $ke++) {
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
            $kodejeniden = $ke == 3 ? "4" : "6";
            $arrayke = [
                "seriEntitas" => $ke,
                "alamatEntitas" => $alamat,
                "kodeEntitas" => $kodeentitas,
                "kodeJenisIdentitas" => $kodejeniden,
                "namaEntitas" => trim($namaidentitas),
                "nibEntitas" => $nibidentitas,
                "nomorIdentitas" => trim(str_replace('-', '', str_replace('.', '', $nomoridentitas))),
                "kodeNegara" => "ID",
                // "kodeStatus" => "5"
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
        //add kode Entitas 
        $ke = 1;
        foreach ($dataentitas->result_array() as $dataenti) {
            $ke++;
            $kodejeniden = $dataenti['kode_entitas'] == 7 ? "6" : "";
            $arrayke = [
                "seriEntitas" => $ke,
                "alamatEntitas" => $dataenti['alamat'],
                "kodeEntitas" => $dataenti['kode_entitas'],
                "kodeJenisIdentitas" => $kodejeniden,
                "namaEntitas" => trim($dataenti['nama']),
                "nibEntitas" => "",
                "nomorIdentitas" => trim(str_replace('-', '', str_replace('.', '', $dataenti['no_identitas']))),
                "kodeNegara" => $dataenti['kodenegara'] == null ? "" : $dataenti['kodenegara'],
                "kodeStatus" => $kodejeniden
            ];
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
        $datakont = $this->ibmodel->getdatakontainer($id);
        $arraykontainer = [];
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
            array_push($arraykontainer, $arrkont);
        }
        $arraybarang = [];
        $datadet = $this->ibmodel->getdatadetailib($id);
        $no = 0;
        $jumlahfasilitas = 0;
        foreach ($datadet as $detx) {
            $no++;
            $jumlah = $detx['kodesatuan'] == 'KGS' ? $detx['kgs'] : $detx['pcs'];
            $cifrupiah = (float) $data['kurs_usd'] * ($detx['harga'] * $jumlah);
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
                "kodeNegaraAsal" => "TH", //$data['kodenegara'],
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
                "cifRupiah" => $cifrupiah,
                "hargaPerolehan" => (float) $detx['harga'] * $jumlah,
                "kodeAsalBahanBaku" => "0",
                "volume" => 0,
                "jumlahKemasan" => (int) $data['jml_kemasan'],
                "uraian" => trim($detx['nama_barang']),
            ];
            $arraytarif = [];
            for ($ik = 1; $ik <= 3; $ik++) {
                $kodeJenisPungutan = $ik == 1 ? "BM" : ($ik == 2 ? "PPH" : "PPN");
                $kodeFasilitasTarif = $ik == 1 ? "3" : ($ik == 2 ? "6" : "6");
                $tarif = $ik == 1 ? 5 : ($ik == 2 ? 2.5 : 11);
                $nilaiFasilitas = round($cifrupiah * ($tarif / 100), 2);
                $arraytarifx = [];
                $barangtarif = [
                    "seriBarang" => $no,
                    "kodeJenisTarif" => "1",
                    "kodeFasilitasTarif" => $kodeFasilitasTarif,
                    "kodeJenisPungutan" => $kodeJenisPungutan,
                    "tarifFasilitas" => 100,
                    "nilaiBayar" => 0,
                    "tarif" => $tarif,
                    "nilaiFasilitas" => $nilaiFasilitas,
                    "jumlahSatuan" => (float) $jumlah,
                    "kodeSatuanBarang" => $detx['satbc'],
                    "nilaiSudahDilunasi" => 0
                ];
                array_push($arraytarif, $barangtarif);
            }
            $jumlahfasilitas += ($detx['harga'] * $jumlah) * 0.11;
            // array_push($arraytarif,$barangtarif);
            $arrayke['barangTarif'] = $arraytarif;
            $arraybarangdokumen = [];
            $arrayke['barangDokumen'] = $arraybarangdokumen;
            array_push($arraybarang, $arrayke);
        }
        $arraypungutan = [];
        $pungutanarray = [
            "kodeFasilitasTarif" => "3",
            "kodeJenisPungutan" => "PPN",
            "nilaiPungutan" => round($jumlahfasilitas, 0)
        ];
        // array_push($arraypungutan,$pungutanarray);

        $arrayheader['entitas'] = $arrayentitas;
        $arrayheader['dokumen'] = $arraydokumen;
        $arrayheader['pengangkut'] = $arrangkut;
        $arrayheader['kemasan'] = $arrkemas;
        $arrayheader['kontainer'] = $arraykontainer;
        $arrayheader['barang'] = $arraybarang;
        $arrayheader['pungutan'] = $arraypungutan;
        // echo '<pre>'.json_encode($arrayheader)."</pre>";
        $this->kirim40($arrayheader, $id);
    }
    function kirimdatakeceisa262($id)
    {
        $data = $this->ibmodel->getdatabyid($id);
        $dataexbc = $this->ibmodel->getdatabynomorbc($data['exnomor_bc']);
        $kurs = getkurssekarang($dataexbc['tgl_aju'])->row_array();
        $noaju = isikurangnol($data['jns_bc']) . '010017' . str_replace('-', '', $data['tgl_aju']) . $data['nomor_aju'];
        $arrayheader = [
            "asalData" => "S",
            "asuransi" => 0,
            "biayaTambahan" => 0,
            "biayaPengurang" => 0,
            "bruto" => (float) $data['bruto'],
            "cif" => 0, //harus di isi
            "disclaimer" => 0,
            "freight" => 0,
            "hargaPenyerahan" => (float) $data['totalharga'],
            "jabatanTtd" => strtoupper($data['jabat_tg_jawab']),
            "kodeDokumen" => $data['jns_bc'],
            "kodeKantor" => "050500",
            "kodeTujuanPemasukan" =>  $data['dept_id'] == 'SU' ? "1" : "2",
            "kodeValuta" => "USD",
            "kotaTtd" => "BANDUNG",
            "namaTtd" => strtoupper($data['tg_jawab']),
            "ndpbm" => (float) $kurs['usd'],
            "netto" => (float) $data['netto'],
            "nik" => "",
            "nilaiBarang" => (float) $data['nilai_pab'],
            "nomorAju" => $noaju,
            "tanggalAju" => $data['tgl_aju'],
            "seri" => 1,
            "disclaimer" => "0",
            "tanggalTtd" => $dataexbc['tgl_aju'],
            "uangMuka" => 0,
            "vd" => 0
        ];
        $ke = 1;
        $arrayentitas = [];
        for ($ke = 1; $ke <= 3; $ke++) {
            $alamatifn = "JL RAYA BANDUNG-GARUT KM. 25, CANGKUANG, RANCAEKEK, KAB. BANDUNG, JAWA BARAT, 40394";
            $kodeentitas = $ke == 1 ? "3" : (($ke == 2) ? "7" : "9");
            if ($ke == 3) {
                $nomoridentitas = '0' . trim(datadepartemen($data['dept_id'], 'npwp')) . str_repeat('0', 22 - (strlen(trim(str_replace('-', '', str_replace('.', '', trim(datadepartemen($data['dept_id'], 'npwp')))))) + 1));
            } else {
                $nomoridentitas = "0010017176057000000000";
            }

            $namaidentitas = $ke == 1 ? "PT. INDONEPTUNE NET MANUFACTURING" : (($ke == 2) ? "PT. INDONEPTUNE NET MANUFACTURING" : datadepartemen($data['dept_id'], 'nama_subkon'));
            $alamat = $ke == 1 ? $alamatifn : (($ke == 2) ? $alamatifn : datadepartemen($data['dept_id'], 'alamat_subkon'));
            $nibidentitas = $ke == 1 ? "9120011042693" : "";
            $kodejeniden = "6";
            $kodestatus = $ke == 3 ? "10" : "5";
            $arrayke = [
                "seriEntitas" => $ke,
                "alamatEntitas" => $alamat,
                "kodeEntitas" => $kodeentitas,
                "kodeJenisIdentitas" => $kodejeniden,
                "namaEntitas" => trim($namaidentitas),
                "nibEntitas" => $nibidentitas,
                "nomorIdentitas" => trim(str_replace('-', '', str_replace('.', '', $nomoridentitas))),
                // "kodeNegara" => "ID",
                "kodeStatus" => $kodestatus
            ];
            if ($ke == 3) {
                $arrayke["kodeJenisApi"] = "2";
            } else {
                $arrayke["kodeJenisApi"] = "";
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
            "idPengangkut" => "1",
            "namaPengangkut" => $data['angkutan'],
            "nomorPengangkut" => $data['no_kendaraan'],
            "seriPengangkut" => 1,
            "kodeBendera" => $data['kode_negara'],
            "kodeCaraAngkut" => "3", //$data['jns_angkutan']
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
        $datakont = $this->ibmodel->getdatakontainer($id);
        $arraykontainer = [];
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
            array_push($arraykontainer, $arrkont);
        }
        $arraybarang = [];
        $datadet = $this->ibmodel->getdatadetailib($id, 1);
        $no = 0;
        $jumlahfasilitas = 0;
        $jumcife = 0;
        foreach ($datadet as $detx) {
            $no++;
            // $jumlah = (trim($detx['po'])=='' && $detx['id_barang'] != 0) ? $detx['kgsx'] : $detx['pcsx'];
            $jumlah = $detx['pcsx'];
            $cifrupiah = (float) $data['kurs_usd'] * ($detx['harga'] * $jumlah);
            // $satuan = (trim($detx['po'])=='' && $detx['id_barang'] != 0) ? 'KGM' : $detx['satbc'];
            $satuan = $detx['satbc'];
            if (str_contains($data['nomor_dok'], '/NET')) {
                $satuan = 'KGM';
                $jumlah = $detx['kgsx'];
            }
            $jumcife += (float) $detx['xcif'];
            $arrayke = [
                "seriBarang" => $no,
                "asuransi" => 0,
                "cif" => (float) $detx['xcif'],
                "diskon" => 0,
                "fob" => 0,
                "freight" => 0,
                "hargaEkspor" => 0,
                "hargaSatuan" => 0,
                "bruto" => 0,
                "hargaPenyerahan" => 0,
                "jumlahSatuan" => (float) $jumlah,
                "kodeAsalBarang" => "1",
                "kodeBarang" => trim($detx['po']) == '' ? $detx['kode'] : viewsku($detx['po'], $detx['item'], $detx['dis']),
                "kodeDokumen" => "",
                "kodeJenisKemasan" => $data['kd_kemasan'],
                "isiPerKemasan" => 0,
                "kodeSatuanBarang" => $satuan,
                "kodeKategoriBarang" => "11",
                "kodeNegaraAsal" => "ID", //$data['kodenegara'],
                "kodePerhitungan" => "1",
                "merk" => "-",
                "netto" => (float) $detx['kgsx'],
                "nilaiBarang" => 0,
                "nilaiJasa" => 0,
                "nilaiTambah" => 0,
                "posTarif" => trim($detx['nohs']) == '' ? trim($detx['hsx']) : trim($detx['nohs']), //Nomor HS
                "spesifikasiLain" => "",
                "tipe" => "-",
                "uangMuka" => 0,
                "ukuran" => "",
                "uraian" => "",
                "ndpbm" => (float) $data['kurs_usd'],
                "cifRupiah" => $cifrupiah,
                "hargaPerolehan" => (float) $detx['harga'] * $jumlah,
                "kodeAsalBahanBaku" => "0",
                "volume" => 0,
                "jumlahKemasan" => 1,
                "uraian" => trim($detx['po']) == '' ? trim($detx['nama_barang']) : htmlspecialchars(spekpo($detx['po'], $detx['item'], $detx['dis'])),
            ];
            $arraybahanbaku = [];
            $pisahbahanbaku = explode(',', $detx['arr_seri_exbc']);
            $databahbak = $this->ibmodel->getdatabahanbakuasal($pisahbahanbaku[0]);
            $arraybah = [
                'cif' => (float) $detx['xcif'],
                "cifRupiah" => 0,
                "hargaPenyerahan" => 0,
                "hargaPerolehan" => 0,
                "jumlahSatuan" => (float) $jumlah,
                "kodeSatuanBarang" => $satuan,
                "kodeAsalBahanBaku" => "1",
                "kodeBarang" => trim($detx['po']) == '' ? $detx['kode'] : viewsku($detx['po'], $detx['item'], $detx['dis']),
                "kodeDokAsal" => "261",
                "kodeDokumen" => "262",
                "kodeKantor" => "050500",
                "merkBarang" => "",
                "ndpbm" => (float) $data['kurs_usd'],
                "netto" => (float) $detx['kgsx'],
                "nilaiJasa" => 0,
                "nomorAjuDokAsal" => '000261010017' . str_replace('-', '', $databahbak['tgl_aju']) . $databahbak['nomor_aju'],
                "nomorDaftarDokAsal" => $databahbak['nomor_bc'],
                "posTarif" => trim($detx['nohs']) == '' ? trim($detx['hsx']) : trim($detx['nohs']),
                "seriBahanBaku" => $no,
                "seriBarang" => $no,
                "seriBarangDokAsal" => (int) $databahbak['seri_urut_akb'],
                "seriIjin" => 0,
                "spesifikasiLainBarang" => "",
                "tanggalDaftarDokAsal" => $databahbak['tgl_bc'],
                "tipeBarang" => "",
                "ukuranBarang" => "",
                "uraianBarang" => trim($databahbak['po']) == '' ? trim($databahbak['nama_barang']) : htmlspecialchars(spekpo($databahbak['po'], $databahbak['item'], $databahbak['dis']))
            ];
            $arraytarif = [];
            $arraybah['bahanBakuTarif'] = $arraytarif;
            array_push($arraybahanbaku, $arraybah);
            $arrayke['bahanBaku'] = $arraybahanbaku;
            // for($ik=1;$ik<=3;$ik++){
            //     $kodeJenisPungutan = $ik==1 ? "BM" : ($ik==2 ? "PPH" : "PPN");
            //     $kodeFasilitasTarif = $ik==1 ? "3" : ($ik==2 ? "6" : "6");
            //     $tarif = $ik==1 ? 5 : ($ik==2 ? 2.5 : 11);
            //     $nilaiFasilitas = round($cifrupiah*($tarif/100),2);
            //     $arraytarifx = [];
            //     $barangtarif = [
            //         "seriBarang" => $no,
            //         "kodeJenisTarif" => "1",
            //         "kodeFasilitasTarif" => $kodeFasilitasTarif,
            //         "kodeJenisPungutan" => $kodeJenisPungutan,
            //         "tarifFasilitas" => 100,
            //         "nilaiBayar" => 0,
            //         "tarif" => $tarif,
            //         "nilaiFasilitas" => $nilaiFasilitas,
            //         "jumlahSatuan" => (float) $jumlah,
            //         "kodeSatuanBarang" => $detx['satbc'],
            //         "nilaiSudahDilunasi" => 0
            //     ];
            //     array_push($arraytarif,$barangtarif);
            // }
            // $jumlahfasilitas += ($detx['harga']*$jumlah)*0.11;
            // array_push($arraytarif,$barangtarif);
            // $arrayke['barangTarif'] = $arraytarif;
            // $arraybarangdokumen = [];
            // $arrayke['barangDokumen'] = $arraybarangdokumen;
            array_push($arraybarang, $arrayke);
        }
        $arraypungutan = [];

        // $pungutanarray = [
        //     "kodeFasilitasTarif" => "3",
        //     "kodeJenisPungutan" => "PPN",
        //     "nilaiPungutan" => round($jumlahfasilitas,0)
        // ];
        // array_push($arraypungutan,$pungutanarray);
        $datajamin = $this->ibmodel->getdatakontrakbyid($dataexbc['id_kontrak']);
        $datakursasal = $dataexbc['devisa_usd'] == 0 ? 1 : $dataexbc['devisa_usd'];
        $jaminanbm = ($dataexbc['bmrupiah'] / $datakursasal) * $jumcife;
        $jaminanppn = ($dataexbc['ppnrupiah'] / $datakursasal) * $jumcife;
        $jaminanpph = ($dataexbc['pphrupiah'] / $datakursasal) * $jumcife;
        $arrayjaminan = [];
        $jaminanarray = [
            "idJaminan" => "",
            "kodeJenisJaminan" => "3",
            "nilaiJaminan" => (float) round($jaminanbm + $jaminanppn + $jaminanpph, 2),
            "nomorBpj" => $datajamin['nomor_bpj'],
            "nomorJaminan" => $datajamin['nomor_ssb'],
            "penjamin" => $datajamin['penjamin'],
            "tanggalBpj" => $datajamin['tgl_bpj'],
            "tanggalJaminan" => $datajamin['tgl_ssb'],
            "tanggalJatuhTempo" => $datajamin['tgl_akhir']
        ];
        array_push($arrayjaminan, $jaminanarray);

        $arrayheader['entitas'] = $arrayentitas;
        $arrayheader['dokumen'] = $arraydokumen;
        $arrayheader['pengangkut'] = $arrangkut;
        $arrayheader['kemasan'] = $arrkemas;
        $arrayheader['kontainer'] = $arraykontainer;
        $arrayheader['barang'] = $arraybarang;
        $arrayheader['jaminan'] = $arrayjaminan;
        $arrayheader['pungutan'] = $arraypungutan;
        // echo '<pre>'.json_encode($arrayheader)."</pre>";
        $this->kirim40($arrayheader, $id, 1);
    }
    public function kirim40($data, $id, $mode = 0)
    {
        $token = $this->ibmodel->gettoken();
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
        $tmb = $mode == 1 ? '/1' : '';
        if ($databalik['status'] == 'OK') {
            $this->helpermodel->isilog("Kirim dokumen CEISA 40 BERHASIL" . $data['nomorAju']);
            $this->session->set_flashdata('errorsimpan', 2);
            $this->session->set_flashdata('pesanerror', $databalik['message']);
            $this->ibmodel->updatesendceisa($id);
            $url = base_url() . 'ib/isidokbc/' . $id . $tmb;
            redirect($url);
        } else {
            // echo '<script>alert("'.$databalik['status'].'");</script>';
            // $url = base_url().'ib/kosong';
            print_r($databalik);
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', $databalik['message'][0] . '[EXCEPTION]' . var_dump($databalik['Exception']));
            // $this->session->set_flashdata('pesanerror',print_r($databalik));
            $url = base_url() . 'ib/isidokbc/' . $id . $tmb;
            redirect($url);
        }
    }
    public function getdatablawb($nomorbl, $tglbl, $id)
    {
        $token = $this->ibmodel->gettoken();
        // $token = 'XXX';
        $namaimpor = urlencode('INDONEPTUNE NET MANUFACTURING');
        $kodekantor = urlencode('040300');
        $tglurl = urlencode($tglbl);
        $blurl = urlencode($nomorbl);
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
        curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/openapi/manifes-bc11?noHostBl=' . $blurl . '&tglHostBl=' . $tglurl . '&kodeKantor=' . $kodekantor . '&nama=' . $namaimpor);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $databalik = json_decode($result, true);
        // print_r($databalik);
        if ($databalik['respon'] == '' && array_key_exists('respon', $databalik)) {
            $isidata = [
                'id' => $id,
                'bc11' => $databalik['noBc11'],
                'tgl_bc11' => tglmysql($databalik['tglBc11']),
                'pelabuhan_bongkar' => $databalik['pelBongkar'],
                'pelabuhan_muat' => $databalik['pelAsal'],
                'nomor_posbc11' => substr($databalik['noPos'], 0, 4),
                'nomor_subposbc11' => substr($databalik['noPos'], 4, 8),
                'jns_angkutan' => $databalik['caraPengangkutan'],
                'angkutan' => $databalik['namaSaranaPengangkut'],
                'no_kendaraan' => $databalik['noVoyage'],
                'bendera_angkutan' => $databalik['bendera']
            ];
            $this->ibmodel->updatebc11($isidata);
            $url = base_url() . 'ib/isidokbc/' . $id;
            redirect($url);
        } else {
            print_r($databalik);
            $this->session->set_flashdata('errorsimpan', 1);
            if (array_key_exists('respon', $databalik)) {
                $this->session->set_flashdata('pesanerror', $databalik['respon'] . '[EXCEPTION]');
            } else {
                $this->session->set_flashdata('pesanerror', '[EXCEPTION]' . $databalik['Exception']);
            }
            $url = base_url() . 'ib/isidokbc/' . $id;
            redirect($url);
        }
        // if($databalik['status']=='OK'){
        //     $this->helpermodel->isilog("Kirim dokumen CEISA 40 BERHASIL".$data['nomorAju']);
        //     $this->session->set_flashdata('errorsimpan',2);
        //     $this->session->set_flashdata('pesanerror',$databalik['message']);
        //     $this->ibmodel->updatesendceisa($id);
        //     $url = base_url().'ib/isidokbc/'.$id;
        //     redirect($url);
        // }else{
        //     // echo '<script>alert("'.$databalik['status'].'");</script>';
        //     // $url = base_url().'ib/kosong';
        //     print_r($databalik);
        //     $this->session->set_flashdata('errorsimpan',1);
        //     $this->session->set_flashdata('pesanerror',$databalik['message'].'[EXCEPTION]'.var_dump($databalik['Exception']));
        //     // $this->session->set_flashdata('pesanerror',print_r($databalik));
        //     $url = base_url().'ib/isidokbc/'.$id;
        //     redirect($url);
        // }
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
    public function hapusaju($id,$mode=0)
    {
        $hasil = $this->ibmodel->hapusaju($id,$mode);
        if ($hasil) {
            $url = base_url() . 'ib';
            redirect($url);
        }
    }
    public function addkontrak($id, $dept){
        $data['idheader'] = $id;
        $kode = 0;
        $kondisi = [
            // 'dept_id' => 'DL',
            'status' => 1,
            'jnsbc' => 40,
            'thkontrak' => '',
            'datkecuali' => 1,
            'nomorbpj != ' => '',
            'nomor_ssb != ' => '',
            'penjamin != ' => '',
            'idheader' => $id
        ];
        $data['kontrak'] = $this->kontrakmodel->getdatakontrak40($kondisi);
        $this->load->view('akb/addkontrak', $data);
    }
    public function addkontrak40($id,$dept){
        $data['idheader'] = $id;
        $data['kode'] = 1;
        $kondisi = [
            // 'dept_id' => 'DL',
            'status' => 1,
            'jnsbc' => 40,
            'thkontrak' => '',
            'datkecuali' => 1,
            'nomorbpj != ' => '',
            'nomor_ssb != ' => '',
            'penjamin != ' => '',
            'idheader' => $id,
        ];
        $data['kontrak'] = $this->kontrakmodel->getdatakontrak40($kondisi);
        $this->load->view('akb/addkontrak', $data);
    }
    public function hapuskontrak($id)
    {
        $hasil = $this->ibmodel->hapuskontrak($id);
        if ($hasil) {
            $url = base_url() . 'ib/isidokbc/' . $id;
            redirect($url);
        }
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
        $data['data'] = $this->ibmodel->getdatabyid($id);
        $data['actiondok'] = base_url() . 'ib/simpandokumen';
        $this->load->view('ib/uploaddok', $data);
    }
    public function simpandokumen()
    {
        $this->ibmodel->updatedok();
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
    public function isilampiran23()
    {
        $id = $_POST['id'];
        $cek = $this->ibmodel->isilampiran23($id);
        echo $cek;
    }
    public function getbcasal($id, $mode = 0)
    {
        $data['idheader'] = $id;
        $data['data'] = $this->ibmodel->getdatabcasal($id);
        $this->load->view('ib/addbcasal', $data);
    }
    public function simpanbcasal($id, $mode = 0)
    {
        $data['idheader'] = $id;
        $cek = $this->ibmodel->simpanbcasal($id);
        if ($cek) {
            $url = base_url() . 'ib/isidokbc/' . $id . '/1';
            redirect($url);
        }
    }
    public function viewbcasal($id)
    {
        $data['idheader'] = $id;
        $detail = $this->ibmodel->getdatadetailbcasal($id);
        $data['detail'] = (array) $detail['detail'][0];
        $data['databcasal'] = (array) $detail['bom'];
        $this->load->view('ib/viewbcasal', $data);
    }
    public function editbcasal($id, $iddetail)
    {
        $data['idheader'] = $id;
        $header = $this->ibmodel->getdatabyid($id);
        $detail = $this->ibmodel->getdatadetailbyid($iddetail)->row_array();
        if (trim($detail['po']) == '' && $detail['id_barang'] != 0 && trim($detail['insno']) == '') {
            $arrkond = [
                'trim(a.po)' => trim($detail['po']),
                'trim(a.item)' => trim($detail['item']),
                'a.dis' => $detail['dis'],
                'a.id_barang' => $detail['id_barang'],
            ];
            $arrkond2 = [
                'id_akb' => $id,
                'trim(po)' => trim($detail['po']),
                'trim(item)' => trim($detail['item']),
                'dis' => $detail['dis'],
                'id_barang' => $detail['id_barang'],
            ];
        } else {
            $arrkond = [
                'trim(a.po)' => trim($detail['po']),
                'trim(a.item)' => trim($detail['item']),
                'a.dis' => $detail['dis'],
                'a.id_barang' => $detail['id_barang'],
                'trim(a.insno)' => trim($detail['insno']),
            ];
            $arrkond2 = [
                'id_akb' => $id,
                'trim(po)' => trim($detail['po']),
                'trim(item)' => trim($detail['item']),
                'dis' => $detail['dis'],
                'id_barang' => $detail['id_barang'],
                'trim(insno)' => trim($detail['insno']),
            ];
        }

        $arrayid = explode(',', $detail['arr_seri_exbc']);
        $detail2 = $this->ibmodel->getdatadetailbyidbcasal($arrkond2)->row_array();
        $cekheader = $this->ibmodel->getdatabynomorbc($header['exnomor_bc']);
        $urutakb = $cekheader['urutakb'] == 1 ? 0 : 1;
        $data['header'] = $detail2;
        $data['detail'] = $this->ibmodel->getdatabcasaluntukedit($cekheader['id'], $urutakb, $arrkond);
        $data['arrayid'] = $arrayid;
        $this->load->view('ib/editbcasal', $data);
    }
    public function editkgsbcasal($id, $iddetail)
    {
        $data['idheader'] = $id;
        $data['iddetail'] = $iddetail;
        $header = $this->ibmodel->getdatabyid($id);
        $detail = $this->ibmodel->getdatadetailbyid($iddetail)->row_array();
        if (trim($detail['po']) == '' && $detail['id_barang'] != 0 && trim($detail['insno']) == '') {
            $arrkond = [
                'trim(a.po)' => trim($detail['po']),
                'trim(a.item)' => trim($detail['item']),
                'a.dis' => $detail['dis'],
                'a.id_barang' => $detail['id_barang'],
            ];
            $arrkond2 = [
                'id_akb' => $id,
                'trim(po)' => trim($detail['po']),
                'trim(item)' => trim($detail['item']),
                'dis' => $detail['dis'],
                'id_barang' => $detail['id_barang'],
            ];
        } else {
            $arrkond = [
                'trim(a.po)' => trim($detail['po']),
                'trim(a.item)' => trim($detail['item']),
                'a.dis' => $detail['dis'],
                'a.id_barang' => $detail['id_barang'],
                'trim(a.insno)' => trim($detail['insno']),
            ];
            $arrkond2 = [
                'id_akb' => $id,
                'trim(po)' => trim($detail['po']),
                'trim(item)' => trim($detail['item']),
                'dis' => $detail['dis'],
                'id_barang' => $detail['id_barang'],
                'trim(insno)' => trim($detail['insno']),
            ];
        }
        $hasil = $this->ibmodel->getdatakgsbcasal($arrkond2);
        // return $hasil;
        $data['arrayhasil'] = $hasil;
        $this->load->view('ib/editkgsbcasal', $data);
    }
    public function simpaneditbcasal()
    {
        $id = $_POST['id'];
        $xdetail = $_POST['iddetail'];
        $bcasal = $_POST['bcasal'];
        $cife = $_POST['cifbaru'];
        $jmlkembali = $_POST['jmlkembali'];

        $detail = $this->ibmodel->getdatadetailbyid($xdetail)->row_array();
        $exseribc = $bcasal[0];

        //cari ndpbm bcasalnya 
        $header = $this->ibmodel->getdatabyid($id);
        $headerasal = $this->ibmodel->getdatabynomorbc($header['exnomor_bc']);
        $kursasal = getkurssekarang($headerasal['tgl_aju'])->row_array();

        $arrkond = [
            'id_akb' => $id,
            'trim(po)' => trim($detail['po']),
            'trim(item)' => trim($detail['item']),
            'trim(insno)' => trim($detail['insno']),
            'dis' => $detail['dis'],
            'id_barang' => $detail['id_barang']
        ];

        $cek = $this->ibmodel->updatebcasal($exseribc, $arrkond, $bcasal, $cife, $kursasal['usd'], $jmlkembali);
        if ($cek) {
            echo json_encode($cek);
        }
    }
    public function simpaneditkgsbcasal()
    {
        $arrayid = $_POST['idasal'];
        $kgsbaru = $_POST['jmlbaru'];

        $cek = $this->ibmodel->updatekgsbcasal($arrayid, $kgsbaru);
        echo $cek;
    }
    public function resetbcasal($header, $id)
    {
        $cek = $this->ibmodel->resetbcasal($header, $id);
        if ($cek) {
            $url = base_url() . 'ib/isidokbc/' . $header . '/1';
            redirect($url);
        }
    }
    public function autolampiran($id)
    {
        $cek = $this->ibmodel->autolampiran($id);
        if ($cek) {
            $url = base_url() . 'ib/isidokbc/' . $id . '/1';
            redirect($url);
        }
    }
    public function simpankehargamaterial($id, $tmb)
    {
        $hasil = $this->ibmodel->simpankehargamaterial($id);
        if ($hasil) {
            $url = base_url() . 'ib/isidokbc/' . $id . '/1';
            redirect($url);
        }
    }

    public function upload($id)
    {
        $data['id'] = $id;
        $this->load->view('ib/upload', $data);
    }
    public function edit_file($id)
    {
        $data['id'] = $id;
        $data['detail'] = $this->ibmodel->getdatabyid($id);
        $this->load->view('ib/edit_file', $data);
    }


    public function simpan_upload($id)
    {
        $config['upload_path'] = './assets/image/amb/';
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
                    redirect('ib/isidokbc/' . $id);
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

        $query = $this->ibmodel->UpdateData_gambar($id, $data);
        if ($query) {
            $this->session->set_flashdata('message', '
            <div class="alert alert-info alert-dismissible fade show" role="alert">
                File Berhasil Di Upload!
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>');
        }

        redirect('ib/isidokbc/' . $id);
    }

    public function edit_upload($id)
    {
        $config['upload_path'] = './assets/image/amb/';
        $config['allowed_types'] = 'jpg|png|jpeg|gif|mp4|pdf|doc|docx|xls|xlsx|zip';
        $config['max_size'] = 20240; // 20 MB
        $this->load->library('upload', $config);


        $detail = $this->ibmodel->getdatabyid($id);
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
            $path = 'assets/image/amb/' . $file;
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
                    $old_path = 'assets/image/amb/' . $old_name;

                    $ext = pathinfo($old_name, PATHINFO_EXTENSION);
                    $rename_clean = preg_replace('/[^a-zA-Z0-9_-]/', '_', pathinfo($rename, PATHINFO_FILENAME));
                    $new_name = $rename_clean . '.' . $ext;
                    $new_path = 'assets/image/amb/' . $new_name;

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
                        redirect('ib/isidokbc/' . $id);
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

        $query = $this->ibmodel->UpdateData_gambarkedua($id, $data);

        if ($query) {
            $this->session->set_flashdata('message', '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
           File Berhasil Diupdate!
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
        }

        redirect('ib/isidokbc/' . $id);
    }
}
