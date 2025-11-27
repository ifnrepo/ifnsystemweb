<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Invmesin extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('invmesin_model', 'invmesinmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('barangmodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'other';
        $data['data'] = $this->invmesinmodel->getdata()->result_array();
        $data['lokasi'] = $this->invmesinmodel->getdatalokasi();
        if($this->session->userdata('tglawalmesin')==null){
            $data['tglawal'] = tglmysql(date('Y-m-01'));
            $data['tglakhir'] = tglmysql(lastday(date('Y') . '-' . date('m') . '-01'));
        }else{
            $data['tglawal'] = tglmysql($this->session->userdata('tglawalmesin'));
            $data['tglakhir'] = tglmysql($this->session->userdata('tglakhirmesin'));
        }
        $data['data'] = $this->invmesinmodel->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'invmesin';
        $this->load->view('layouts/header', $header);
        $this->load->view('invmesin/invmesin',$data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->unset_userdata('tglawalmesin');
        $this->session->unset_userdata('tglakhirmesin');
        $url = base_url() . 'invmesin';
        redirect($url);
    }
    public function getdata(){
        $monthawal = date('m',strtotime(tglmysql($_POST['tga'])));
        $tahunawal = date('Y',strtotime(tglmysql($_POST['tga'])));
        $jaditahun = '01-'.$monthawal.'-'.$tahunawal;
        $this->session->set_userdata('tglawalmesin', tglmysql($jaditahun));
        $this->session->set_userdata('tglakhirmesin', tglmysql($_POST['tgk']));
        $this->session->set_userdata('lokasimesin', $_POST['msn']);
        echo 1;
    }
    public function getdetail($id)
    {
        $data['header'] = $this->invmesinmodel->getdatabyid($id)->row_array();
        $data['detail'] = $this->invmesinmodel->getdatadetail($id);
        $this->load->view('invmesin/viewdetail', $data);
    }

    public function toexcel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "MUTASI MESIN/ASSET"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        $sheet->setCellValue('A2', "Periode : ".$this->session->userdata('tglawalmesin')." s/d ".$this->session->userdata('tglakhirmesin')); 

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A3', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B3', "KODE"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C3', "NAMA MESIN/SPAREPART"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D3', "UNIT");
        $sheet->setCellValue('E3', "LOKASI");
        $sheet->setCellValue('F3', "SAW");
        $sheet->setCellValue('G3', "IN");
        $sheet->setCellValue('H3', "OUT");
        $sheet->setCellValue('I3', "ADJ");
        $sheet->setCellValue('J3', "SALDO");
        $sheet->setCellValue('K3', "OPNAME");
        $sheet->setCellValue('L3', "KETERANGAN");
        // Panggil model Get Data   

        $bl = $this->input->get('blperiode');
        $th = $this->input->get('thperiode');
        $lokasi = $this->input->get('lokasimesin');
        if (!is_numeric($bl) || $bl < 1 || $bl > 12) {
            $bl = null;
        }
        if (!is_numeric($th) || $th < 2020 || $th > date('Y')) {
            $th = null;
        }
        $master = $this->invmesinmodel->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 4;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($master->result_array() as $data) {
            // $oth = cekoth($data['pb'], $data['bbl'], $data['adj']);
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['kode_fix']);
            $sheet->setCellValue('C' . $numrow, $data['nama_barang']);
            $sheet->setCellValue('D' . $numrow, 'UNIT');
            $sheet->setCellValue('E' . $numrow, $data['lokasi']);
            $sheet->setCellValue('F' . $numrow, $data['xsaldomesin']);
            $sheet->setCellValue('G' . $numrow, $data['xinmesin']);
            $sheet->setCellValue('H' . $numrow, $data['xoutmesin']);
            $sheet->setCellValue('I' . $numrow, 0);
            $sheet->setCellValue('J' . $numrow, $data['xsaldomesin'] + $data['xinmesin'] - $data['xoutmesin']);
            $sheet->setCellValue('K' . $numrow, 0);
            $sheet->setCellValue('L' . $numrow, '');
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Asset");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="BarangModal.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA MESIN/ASSET');
    }
    public function pdf()
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
        $pdf->Cell(30, 18, 'DATA ASET MESIN');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(23, 8, 'KODE', 1, 0, 'C');
        $pdf->Cell(110, 8, 'NAMA MESIN', 1, 0, 'C');
        $pdf->Cell(15, 8, 'UNIT', 1, 0, 'C');
        $pdf->Cell(15, 8, 'SAW', 1, 0, 'C');
        $pdf->Cell(15, 8, 'IN', 1, 0, 'C');
        $pdf->Cell(15, 8, 'OUT', 1, 0, 'C');
        $pdf->Cell(15, 8, 'ADJ', 1, 0, 'C');
        $pdf->Cell(25, 8, 'SALDO', 1, 0, 'C');
        $pdf->Cell(25, 8, 'KETERANGAN', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $bl = $this->input->get('blperiode');
        $th = $this->input->get('thperiode');
        $lokasi = $this->input->get('lokasimesin');
        if (!is_numeric($bl) || $bl < 1 || $bl > 12) {
            $bl = null;
        }
        if (!is_numeric($th) || $th < 2020 || $th > date('Y')) {
            $th = null;
        }
        $master = $this->invmesinmodel->getdata_export($bl, $th, $lokasi);
        $no = 1;
        foreach ($master as $det) {
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(23, 6, $det['kode_fix'], 1);
            $pdf->Cell(110, 6, $det['nama_barang'], 1);
            $pdf->Cell(15, 6, $det['kodesatuan'], 1);
            $pdf->Cell(15, 6, $det['sawi'], 1);
            $pdf->Cell(15, 6, $det['ini'], 1);
            $pdf->Cell(15, 6, $det['outi'], 1);
            $pdf->Cell(15, 6, $det['adji'], 1);
            $pdf->Cell(25, 6, $det['sawi'] + $det['ini'] - $det['outi'], 1);

            $pdf->Cell(25, 6, 'Sesuai', 1);


            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Departemen.pdf');
        $this->helpermodel->isilog('Download PDF DATA DEPARTEMEN');
    }
}
