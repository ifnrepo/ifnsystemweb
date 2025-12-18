<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Jobcostdiv extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('jobcostdiv_model','jobcostmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['data'] = $this->jobcostmodel->getdata();

        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('jobcostdiv/jobcostdiv', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function tambahdata()
    {
        $this->load->view('jobcostdiv/addjobcost');
    }

    public function simpandata()
    {
        $data = [
            'tahun' => $_POST['tahun'],
            'aktif' => $_POST['aktif'],
            'sp' => $_POST['sp'],
            'nt' => $_POST['nt'],
            'rr' => $_POST['rr'],
            'sn' => $_POST['sn'],
            'h1' => $_POST['h1'],
            'ko' => $_POST['ko'],
            'h2' => $_POST['h2'],
            'pa' => $_POST['pa'],
            'sh' => $_POST['sh'],
        ];
        $hasil = $this->jobcostmodel->simpandata($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editdata($id)
    {

        $data['data'] = $this->jobcostmodel->getdatabyid($id);
        $this->load->view('jobcostdiv/editjobcost', $data);
    }
    public function updatedata()
    {
        $data = [
            'id' => $_POST['id'],
            'tahun' => $_POST['tahun'],
            'aktif' => $_POST['aktif'],
            'sp' => $_POST['sp'],
            'nt' => $_POST['nt'],
            'rr' => $_POST['rr'],
            'sn' => $_POST['sn'],
            'h1' => $_POST['h1'],
            'ko' => $_POST['ko'],
            'h2' => $_POST['h2'],
            'pa' => $_POST['pa'],
            'sh' => $_POST['sh'],
        ];
        $hasil = $this->jobcostmodel->updatedata($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }

    public function hapusdata($id)
    {
        $hasil = $this->jobcostmodel->hapusdata($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url() . 'jobcostdiv';
            redirect($url);
        }
    }

    public function viewsupplier($id)
    {
        $data['data'] = $this->jobcostmodel->getdatabyid($id);
        $data['negara'] = $this->db->get('ref_negara')->result_array();
        $this->load->view('supplier/viewsupplier', $data);
    }

    public function cetakexcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA COST JOB DIVISION"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "TAHUN"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "AKTIF"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "SPINNING");
        $sheet->setCellValue('E2', "RINGROPE");
        $sheet->setCellValue('F2', "NETTING");
        $sheet->setCellValue('G2', "SENSHOKU");
        $sheet->setCellValue('H2', "HOSHU 1");
        $sheet->setCellValue('I2', "KOATSU");
        $sheet->setCellValue('J2', "HOSHU 2");
        $sheet->setCellValue('K2', "PACKING");
        $sheet->setCellValue('L2', "SHITATE");
        // Panggil model Get Data   
        $supplier = $this->jobcostmodel->getdata();
        $no = 1;
        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;
        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($supplier->result_array() as $data) {
            $aktif = $data['aktif']==1 ? 'YA' : 'TIDAK';
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['tahun']);
            $sheet->setCellValue('C' . $numrow, $aktif);
            $sheet->setCellValue('D' . $numrow, $data['sp']);
            $sheet->setCellValue('E' . $numrow, $data['rr']);
            $sheet->setCellValue('F' . $numrow, $data['nt']);
            $sheet->setCellValue('G' . $numrow, $data['sn']);
            $sheet->setCellValue('H' . $numrow, $data['h1']);
            $sheet->setCellValue('I' . $numrow, $data['ko']);
            $sheet->setCellValue('J' . $numrow, $data['h2']);
            $sheet->setCellValue('K' . $numrow, $data['pa']);
            $sheet->setCellValue('L' . $numrow, $data['sh']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle(" DATA SUPPLIER");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Job Cost Division.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA JOB COST DIVISION');
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
        $pdf->Cell(30, 18, 'DATA SUPPLIER');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(8, 8, 'No', 1, 0, 'C');
        $pdf->Cell(15, 8, 'Kode', 1, 0, 'C');
        $pdf->Cell(65, 8, 'Nama Supplier', 1, 0, 'C');
        // $pdf->Cell(35, 8, 'Desa', 1, 0, 'C');
        // $pdf->Cell(140, 8, 'Kecamatan', 1, 0, 'C');
        // $pdf->Cell(140, 8, 'Kab/Kota', 1, 0, 'C');
        // $pdf->Cell(140, 8, 'Provinsi', 1, 0, 'C');
        // $pdf->Cell(140, 8, 'Kode Pos', 1, 0, 'C');
        // $pdf->Cell(35, 8, 'Npwp', 1, 0, 'C');
        $pdf->Cell(43, 8, 'Telp', 1, 0, 'C');
        // $pdf->Cell(53, 8, 'Email', 1, 0, 'C');
        $pdf->Cell(125, 8, 'Alamat', 1, 0, 'C');
        // $pdf->Cell(40, 8, 'Kontak', 1, 0, 'C');
        // $pdf->Cell(40, 8, 'Jabatan', 1, 0, 'C');
        // $pdf->Cell(140, 8, 'Keterangan', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(8);
        $detail = $this->supplier_model->getdata();
        $no = 1;
        foreach ($detail as $det) {
            $pdf->Cell(8, 6, $no++, 1, 0, 'C');
            $pdf->Cell(15, 6, $det['kode'], 1);
            $pdf->Cell(65, 6, $det['nama_supplier'], 1);
            // $pdf->Cell(35, 6, $det['desa'], 1);
            // $pdf->Cell(140, 6, $det['kecamatan'], 1);
            // $pdf->Cell(140, 6, $det['kab_kota'], 1);
            // $pdf->Cell(140, 6, $det['propinsi'], 1);
            // $pdf->Cell(140, 6, $det['kodepos'], 1);
            // $pdf->Cell(35, 6, $det['npwp'], 1);
            $pdf->Cell(43, 6, $det['telp'], 1);
            // $pdf->Cell(53, 6, $det['email'], 1);
            $pdf->Cell(125, 6, $det['alamat'], 1);
            // $pdf->Cell(40, 6, $det['kontak'], 1);
            // $pdf->Cell(40, 6, $det['jabatan'], 1);
            // $pdf->Cell(40, 6, $det['keterangan'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Supplier.pdf');
        $this->helpermodel->isilog('Download PDF DATA SUPPLIER');
    }
}
