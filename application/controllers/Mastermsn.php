<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Mastermsn extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('mastermsn_model', 'mastermsnmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'master';
        $data['data'] = $this->mastermsnmodel->getdata();
        $data['lokasi'] = $this->mastermsnmodel->getdatalokasi();
        $footer['fungsi'] = 'datamesin';
        $this->load->view('layouts/header', $header);
        $this->load->view('mastermsn/mastermsn', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->unset_userdata('lokasimesin');
        $this->session->unset_userdata('disposalmesin');
        $url = base_url() . 'mastermsn';
        redirect($url);
    }
    public function ubahlokasi()
    {
        $id = $_POST['lok'];
        $cek = $_POST['ceko'];
        if ($id == '') {
            $this->session->unset_userdata('lokasimesin');
        } else {
            $this->session->set_userdata('lokasimesin', $id);
        }
        if ($cek == 0) {
            $this->session->unset_userdata('disposalmesin');
        } else {
            $this->session->set_userdata('disposalmesin', $cek);
        }
        echo 1;
    }
    public function editmesin($id)
    {
        $header['header'] = 'master';
        $data['data'] = $this->mastermsnmodel->getdataby($id)->row_array();
        $data['actionfoto'] = base_url() . 'mastermsn/updatefoto';
        $data['actionkolom'] = base_url() . 'mastermsn/updatemsn/' . $id;
        $data['actiondok'] = base_url() . 'mastermsn/updatedok';
        $footer['fungsi'] = 'datamesin';
        $this->load->view('layouts/header', $header);
        $this->load->view('mastermsn/editmsn', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function updatemsn($id)
    {
        $this->mastermsnmodel->updatemsn();
        $url = base_url() . 'mastermsn/editmesin/' . $id;
        redirect($url);
    }
    public function updatefoto()
    {
        $this->mastermsnmodel->updatefoto();
    }
    public function updatedok()
    {
        $this->mastermsnmodel->updatedok();
    }
    public function viewdok($id)
    {
        $data['data'] = $this->mastermsnmodel->getdataby($id)->row_array();
        $this->load->view('mastermsn/viewdok', $data);
    }
    public function tambahdata()
    {
        $this->load->view('satuan/addsatuan');
    }
    public function simpansatuan()
    {
        $data = [
            'kodesatuan' => $_POST['kode'],
            'namasatuan' => $_POST['nama']
        ];
        $hasil = $this->satuanmodel->simpansatuan($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editsatuan($id)
    {
        $data['data'] = $this->satuanmodel->getdatabyid($id)->row_array();
        $this->load->view('satuan/editsatuan', $data);
    }
    public function updatesatuan()
    {
        $data = [
            'id' => $_POST['id'],
            'kodesatuan' => $_POST['kode'],
            'namasatuan' => $_POST['nama']
        ];
        $hasil = $this->satuanmodel->updatesatuan($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapussatuan($id)
    {
        $hasil = $this->satuanmodel->hapussatuan($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url() . 'satuan';
            redirect($url);
        }
    }
    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA MASTER MESIN"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "KODE ASSET"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "LOKASI"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('E2', "SPEK MESIN"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('F2', "HARGA"); // Set kolom C3 dengan tulisan "NAMA SATUAN"            
        $sheet->setCellValue('G2', "TGL MASUK"); // Set kolom C3 dengan tulisan "NAMA SATUAN"   

        $lokasi = $this->input->get('lokasi');
        $cekdisposal = $this->input->get('cekdisposal');
        $master = $this->mastermsnmodel->getdata_export($lokasi, $cekdisposal);
        $no = 1;
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($master as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['kode']);
            $sheet->setCellValue('C' . $numrow, $data['kode_fix']);
            $sheet->setCellValue('D' . $numrow, $data['lokasi']);
            $sheet->setCellValue('E' . $numrow, $data['nama_barang']);
            $sheet->setCellValue('F' . $numrow, rupiah(($data['harga'] * $data['kurs']) + $data['landing'], 2));
            $sheet->setCellValue('G' . $numrow, $data['tglmasuk']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Master Mesin");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Mater Mesin.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA MASTER MESIN');
    }
    public function cetakpdf()
    {
        $pdf = new PDF('L', 'mm', 'A4');
        $pdf->AliasNbPages();
        // $pdf->setMargins(5,5,5);
        $pdf->AddFont('Lato', '', 'Lato-Regular.php');
        $pdf->AddFont('Latob', '', 'Lato-Bold.php');
        $pdf->SetFillColor(7, 178, 251);
        $pdf->SetFont('Latob', '', 12);
        // $isi = $this->jualmodel->getrekap();
        $pdf->SetFillColor(205, 205, 205);
        $pdf->AddPage();
        $pdf->Image(base_url() . 'assets/image/logodepanK.png', 0, 5, 55);
        $pdf->Cell(30, 18, 'DATA MASTER MESIN');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(15, 8, 'No', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Kode', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Kode Asset', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Lokasi', 1, 0, 'C');
        $pdf->Cell(110, 8, 'Spek Mesin', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Harga', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Tanggal Masuk', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $lokasi = $this->input->get('lokasi');
        $cekdisposal = $this->input->get('cekdisposal');
        $master = $this->mastermsnmodel->getdata_export($lokasi, $cekdisposal);
        $no = 1;
        foreach ($master as $det) {
            $pdf->Cell(15, 6, $no++, 1, 0, 'C');
            $pdf->Cell(30, 6, $det['kode'], 1);
            $pdf->Cell(30, 6, $det['kode_fix'], 1);
            $pdf->Cell(30, 6, $det['lokasi'], 1);
            $pdf->Cell(110, 6, $det['nama_barang'], 1);
            $pdf->Cell(30, 6, rupiah(($det['harga'] * $det['kurs']) + $det['landing'], 2), 1);
            $pdf->Cell(30, 6, $det['tglmasuk'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Master Mesin.pdf');
        $this->helpermodel->isilog('Download PDF DATA MASTER MESIN');
    }
}
