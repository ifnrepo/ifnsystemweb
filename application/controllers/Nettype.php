<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Nettype extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('nettype_model');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['nettype'] = $this->nettype_model->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('nettype/index', $data);
        $this->load->view('layouts/footer',$footer);
    }

    public function tambahdata()
    {
        $data['kategori'] = $this->nettype_model->getdata_kategori();
        $this->load->view('nettype/addnettype', $data);
    }

    public function simpannettype()
    {
        $data = [
            'name_nettype' => $_POST['name_nettype'],
            'id_kategori' => $_POST['id_kategori'],
            'grup' => $_POST['grup'],
            'kode_grup' => $_POST['kode_grup'],
            'nommsq' => $_POST['nommsq'],
            'nopack' => $_POST['nopack'],
            'xmin' => $_POST['xmin'],
            'isimmsq' => $_POST['isimmsq'],

        ];
        $hasil = $this->nettype_model->simpannettype($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editnettype($id)
    {
        $data['data'] = $this->nettype_model->getdatabyid($id);
        $data['kategori'] = $this->nettype_model->getdata_kategori();
        $this->load->view('nettype/editnettype', $data);
    }
    public function updatenettype()
    {
        $data = [
            'id' => $_POST['id'],
            'name_nettype' => $_POST['name_nettype'],
            'id_kategori' => $_POST['id_kategori'],
            'grup' => $_POST['grup'],
            'kode_grup' => $_POST['kode_grup'],
            'nommsq' => $_POST['nommsq'],
            'nopack' => $_POST['nopack'],
            'xmin' => $_POST['xmin'],
            'isimmsq' => $_POST['isimmsq'],

        ];
        $hasil = $this->nettype_model->updatenettype($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function hapusnettype($id)
    {
        $hasil = $this->nettype_model->hapusnettype($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('nettype');
            redirect($url);
        }
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA NETTYPE"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "NET TYPE"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "KATEGORI"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      

        // Panggil model Get Data   
        $nettype = $this->nettype_model->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($nettype as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['name_nettype']);
            $sheet->setCellValue('C' . $numrow, $data['id_kategori']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Net Type");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Net Type.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA NET TYPE');
    }
    public function cetakpdf()
    {
        $pdf = new PDF('P', 'mm', 'A4');
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
        $pdf->Cell(30, 18, 'DATA NET TYPE');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(15, 8, 'No', 1, 0, 'C');
        $pdf->Cell(55, 8, 'Net Tyepe', 1, 0, 'C');
        $pdf->Cell(120, 8, 'Kategori', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $detail = $this->nettype_model->getdata();
        $no = 1;
        foreach ($detail as $det) {
            $pdf->Cell(15, 6, $no++, 1, 0, 'C');
            $pdf->Cell(55, 6, $det['name_nettype'], 1);
            $pdf->Cell(120, 6, $det['nama_kategori'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Net Type.pdf');
        $this->helpermodel->isilog('Download PDF DATA NET TYPE');
    }
}
