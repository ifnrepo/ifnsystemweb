<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Bcmasuk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('dept_model');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->model('bcmasukmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'other';
        $data['dept'] = $this->dept_model->getdata();
        if ($this->session->userdata('tglawal') == null) {
            $data['tglawal'] = tglmysql(date('Y-m-d'));
            $data['tglakhir'] = tglmysql(lastday($this->session->userdata('th') . '-' . $this->session->userdata('bl') . '-01'));
            $data['jns'] = null;
            $data['data'] = null;
        }else{
            $data['tglawal'] = $this->session->userdata('tglawal');
            $data['tglakhir'] = $this->session->userdata('tglakhir');
            $data['jns'] = $this->session->userdata('jnsbc');
            $data['data'] = $this->bcmasukmodel->getdata();
        }
        $footer['fungsi'] = 'bcmasuk';
        $this->load->view('layouts/header', $header);
        $this->load->view('bcmasuk/bcmasuk', $data);
        $this->load->view('layouts/footer',$footer);
    }

    public function clear(){
       $this->session->unset_userdata('tglawal');
        $this->session->unset_userdata('tglakhir');
        $this->session->unset_userdata('jnsbc'); 
        $url = base_url('bcmasuk');
        redirect($url);
    }

    public function getdata()
    {
        $this->session->set_userdata('tglawal',$_POST['tga']);
        $this->session->set_userdata('tglakhir',$_POST['tgk']);
        $this->session->set_userdata('jnsbc',$_POST['jns']);
        echo 1;
    }
    public function viewdetail($id){
        $data['riwayat'] = riwayatbcmasuk($id);
        $this->load->view('bcmasuk/viewdetail',$data);
    }

    public function simpandept()
    {
        $data = [
            'dept_id' => strtoupper($_POST['dept_id']),
            'departemen' => strtoupper($_POST['departemen']),
            'katedept_id' => strtoupper($_POST['kat']),
            'pb' => $_POST['pb'],
            'bbl' => $_POST['bbl'],
            'adj' => $_POST['adj']
        ];
        $hasil = $this->dept_model->simpandept($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    // public function editdept($dept_id)
    // {
    //     $data['data'] = $this->dept_model->getdatabyid($dept_id);
    //     $data['katedept'] = $this->dept_model->getdatakatedept();
    //     $this->load->view('dept/edit_dept', $data);
    // }

    public function edit_new($dept_id)
    {
        $header['header'] = 'master';
        $data['action'] = base_url() . 'dept/updatedata';
        $data['data'] = $this->dept_model->getdatabyid($dept_id);
        $data['departemen'] = $this->dept_model->getdata();
        $data['katedept'] = $this->dept_model->getdatakatedept();
        $footer['fungsi'] = 'dept';

        $this->load->view('layouts/header', $header);
        $this->load->view('dept/edit_new', $data);
        $this->load->view('layouts/footer', $footer);
    }
    // public function updatedept()
    // {
    //     $data = [
    //         'dept_id' => strtoupper($_POST['dept_id']),
    //         'departemen' => strtoupper($_POST['departemen']),
    //         'katedept_id' => strtoupper($_POST['kat']),
    //         'pb' => $_POST['pb'],
    //         'bbl' => $_POST['bbl'],
    //         'adj' => $_POST['adj']
    //     ];
    //     $hasil = $this->dept_model->updatedept($data);
    //     echo $hasil;
    // }

    public function updatedata()
    {
        $query = $this->dept_model->updatedata();
        $this->helpermodel->isilog($this->db->last_query());
        if ($query) {
            $url = base_url('dept');
            redirect($url);
        }
    }
    public function hapusdept($dept_id)
    {
        $hasil = $this->dept_model->hapusdept($dept_id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('dept');
            redirect($url);
        }
    }

    public function view($dept_id)
    {
        $data['dept'] = $this->dept_model->getdatabyid($dept_id);
        $this->load->view('dept/view', $data);
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA DEPARTEMEN"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE "); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "NAMA DEPARTEMEN"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "KATEGORI");
        $sheet->setCellValue('E2', "OTH");
        // Panggil model Get Data   
        $dept = $this->dept_model->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($dept as $data) {
            $oth = cekoth($data['pb'], $data['bbl'], $data['adj']);
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['dept_id']);
            $sheet->setCellValue('C' . $numrow, $data['departemen']);
            $sheet->setCellValue('D' . $numrow, strtoupper($data['nama']));
            $sheet->setCellValue('E' . $numrow, $oth);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Departemen");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Departemen.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA DEPARTEMEN');
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
        $pdf->Cell(30, 18, 'DATA DEPARTEMEN');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(20, 8, 'KODE', 1, 0, 'C');
        $pdf->Cell(55, 8, 'NAMA DEPARTEMEN', 1, 0, 'C');
        $pdf->Cell(55, 8, 'KATEGORI', 1, 0, 'C');
        $pdf->Cell(55, 8, 'OTHER', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $detail = $this->dept_model->getdata();
        $no = 1;
        foreach ($detail as $det) {
            $oth = cekoth($det['pb'], $det['bbl'], $det['adj']);
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(20, 6, $det['dept_id'], 1);
            $pdf->Cell(55, 6, $det['departemen'], 1);
            $pdf->Cell(55, 6, strtoupper($det['nama']), 1);
            $pdf->Cell(55, 6, $oth, 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Departemen.pdf');
        $this->helpermodel->isilog('Download PDF DATA DEPARTEMEN');
    }
}
