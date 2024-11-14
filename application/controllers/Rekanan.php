<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Rekanan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('Rekanan_model');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['rekanan'] = $this->Rekanan_model->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('rekanan/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function tambahdata()
    {
        $this->load->view('rekanan/add');
    }

    public function simpan()
    {
        $data = [
            'kode' => $_POST['kode'],
            'inisial' => $_POST['inisial'],
            'nama_rekanan' => $_POST['nama_rekanan'],
            'alamat_rekanan' => $_POST['alamat_rekanan'],
            'kodepos' => $_POST['kodepos'],
            'telp' => $_POST['telp'],
            'fax' => $_POST['fax'],
            'email' => $_POST['email'],
            'npwp' => $_POST['npwp'],
            'bank' => $_POST['bank'],
            'rek_bank' => $_POST['rek_bank'],
            'an_bank' => $_POST['an_bank'],
            'kontak' => $_POST['kontak'],
            'jabatan' => $_POST['jabatan'],
            'noktp' => $_POST['noktp'],
        ];
        $hasil = $this->Rekanan_model->simpan($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function edit($id)
    {

        $header['header'] = 'master';
        $data['data'] = $this->Rekanan_model->getdatabyid($id);
        // $this->load->view('layouts/header', $header);
        $this->load->view('rekanan/edit', $data);
        // $this->load->view('layouts/footer');
    }
    public function update()
    {
        $data = [
            'id' => $_POST['id'],
            'kode' => $_POST['kode'],
            'inisial' => $_POST['inisial'],
            'nama_rekanan' => $_POST['nama_rekanan'],
            'alamat_rekanan' => $_POST['alamat_rekanan'],
            'kodepos' => $_POST['kodepos'],
            'telp' => $_POST['telp'],
            'fax' => $_POST['fax'],
            'email' => $_POST['email'],
            'npwp' => $_POST['npwp'],
            'bank' => $_POST['bank'],
            'rek_bank' => $_POST['rek_bank'],
            'an_bank' => $_POST['an_bank'],
            'kontak' => $_POST['kontak'],
            'jabatan' => $_POST['jabatan'],
            'noktp' => $_POST['noktp'],
        ];
        $hasil = $this->Rekanan_model->update($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }

    public function hapus($id)
    {
        $hasil = $this->Rekanan_model->hapus($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url() . 'rekanan';
            redirect($url);
        }
    }

    public function view($id)
    {
        $data['data'] = $this->Rekanan_model->getdatabyid($id);
        $this->load->view('rekanan/view', $data);
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA REKANAN"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "INISIAL"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "NAMA REKANAN"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "ALAMAT");
        // Panggil model Get Data   
        $supplier = $this->Rekanan_model->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($supplier as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['inisial']);
            $sheet->setCellValue('C' . $numrow, $data['nama_rekanan']);
            $sheet->setCellValue('D' . $numrow, $data['alamat_rekanan']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle(" DATA REKANAN");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Rekanan.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA REKANAN');
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
        $pdf->Image(base_url() . 'assets/image/logodepanK.png', 155, 5, 55);
        $pdf->Cell(30, 18, 'DATA REKANAN');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(8, 8, 'No', 1, 0, 'C');
        $pdf->Cell(15, 8, 'Inisial', 1, 0, 'C');
        $pdf->Cell(65, 8, 'Nama Rekanan', 1, 0, 'C');
        $pdf->Cell(135, 8, 'Alamat', 1, 0, 'C');

        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(8);
        $detail = $this->Rekanan_model->getdata();
        $no = 1;
        foreach ($detail as $det) {
            $pdf->Cell(8, 6, $no++, 1, 0, 'C');
            $pdf->Cell(15, 6, $det['inisial'], 1);
            $pdf->Cell(65, 6, $det['nama_rekanan'], 1);
            $pdf->Cell(135, 6, $det['alamat_rekanan'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Rekanan.pdf');
        $this->helpermodel->isilog('Download PDF DATA REKANAN');
    }
}
