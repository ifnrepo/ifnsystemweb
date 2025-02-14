<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Supplier extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('supplier_model');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['supplier'] = $this->supplier_model->getdata();

        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('supplier/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function tambahdata()
    {
        $data['negara'] = $this->db->get('ref_negara')->result_array();
        $this->load->view('supplier/addsupplier',$data);
    }

    public function simpansupplier()
    {
        $data = [
            'kode' => $_POST['kode'],
            'nama_supplier' => $_POST['nama_supplier'],
            'alamat' => $_POST['alamat'],
            'desa' => $_POST['desa'],
            'kecamatan' => $_POST['kecamatan'],
            'kab_kota' => $_POST['kab_kota'],
            'propinsi' => $_POST['propinsi'],
            'kodepos' => $_POST['kodepos'],
            'npwp' => $_POST['npwp'],
            'telp' => $_POST['telp'],
            'email' => $_POST['email'],
            'kontak' => $_POST['kontak'],
            'jabatan' => $_POST['jabatan'],
            'keterangan' => $_POST['keterangan'],
            'jns_supplier' => $_POST['jns_supplier'],
            'namabank' => strtoupper($_POST['namabank']),
            'atas_nama' => $_POST['atas_nama'],
            'norek' => $_POST['norek'],
            'aktif' => $_POST['aktif'],
            'nik' => $_POST['nik'],
            'jns_pkp' => $_POST['jns_pkp'],
            'kode_negara' => $_POST['kode_negara'],
            'nama_di_ceisa' => $_POST['namaceisa'],
            'alamat_di_ceisa' => $_POST['alamatceisa'],
        ];
        $hasil = $this->supplier_model->simpansupplier($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }
    public function editsupplier($id)
    {

        $header['header'] = 'master';
        $data['negara'] = $this->db->get('ref_negara')->result_array();
        $data['data'] = $this->supplier_model->getdatabyid($id);
        // $this->load->view('layouts/header', $header);
        $this->load->view('supplier/editsupplier', $data);
        // $this->load->view('layouts/footer');
    }
    public function updatesupplier()
    {
        $data = [
            'id' => $_POST['id'],
            'kode' => $_POST['kode'],
            'nama_supplier' => $_POST['nama_supplier'],
            'alamat' => $_POST['alamat'],
            'desa' => $_POST['desa'],
            'kecamatan' => $_POST['kecamatan'],
            'kab_kota' => $_POST['kab_kota'],
            'propinsi' => $_POST['propinsi'],
            'kodepos' => $_POST['kodepos'],
            'npwp' => $_POST['npwp'],
            'telp' => $_POST['telp'],
            'email' => $_POST['email'],
            'kontak' => $_POST['kontak'],
            'jabatan' => $_POST['jabatan'],
            'keterangan' => $_POST['keterangan'],
            'jns_supplier' => $_POST['jns_supplier'],
            'namabank' => strtoupper($_POST['namabank']),
            'atas_nama' => $_POST['atas_nama'],
            'norek' => $_POST['norek'],
            'aktif' => $_POST['aktif'],
            'nik' => $_POST['nik'],
            'jns_pkp' => $_POST['jns_pkp'],
            'kode_negara' => $_POST['kode_negara'],
            'nama_di_ceisa' => $_POST['namaceisa'],
            'alamat_di_ceisa' => $_POST['alamatceisa'],
        ];
        $hasil = $this->supplier_model->updatesupplier($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }

    public function hapussupplier($id)
    {
        $hasil = $this->supplier_model->hapussupplier($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url() . 'supplier';
            redirect($url);
        }
    }

    public function viewsupplier($id)
    {
        $data['data'] = $this->supplier_model->getdatabyid($id);
        $data['negara'] = $this->db->get('ref_negara')->result_array();
        $this->load->view('supplier/viewsupplier', $data);
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA SUPPLIER"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "NAMA SUPPLIER"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "ALAMAT");
        $sheet->setCellValue('E2', "DESA");
        $sheet->setCellValue('F2', "KECAMATAN");
        $sheet->setCellValue('G2', "KAB/KOTA");
        $sheet->setCellValue('H2', "PROVINSI");
        $sheet->setCellValue('I2', "KODE POS");
        $sheet->setCellValue('J2', "NPWP");
        $sheet->setCellValue('K2', "TELP");
        $sheet->setCellValue('L2', "EMAIL");
        $sheet->setCellValue('M2', "KONTAK");
        $sheet->setCellValue('N2', "JABATAN");
        $sheet->setCellValue('O2', "KETERANGAN");
        // Panggil model Get Data   
        $supplier = $this->supplier_model->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($supplier as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['kode']);
            $sheet->setCellValue('C' . $numrow, $data['nama_supplier']);
            $sheet->setCellValue('D' . $numrow, $data['alamat']);
            $sheet->setCellValue('E' . $numrow, $data['desa']);
            $sheet->setCellValue('F' . $numrow, $data['kecamatan']);
            $sheet->setCellValue('G' . $numrow, $data['kab_kota']);
            $sheet->setCellValue('H' . $numrow, $data['propinsi']);
            $sheet->setCellValue('I' . $numrow, $data['kodepos']);
            $sheet->setCellValue('J' . $numrow, $data['npwp']);
            $sheet->setCellValue('K' . $numrow, $data['telp']);
            $sheet->setCellValue('L' . $numrow, $data['email']);
            $sheet->setCellValue('M' . $numrow, $data['kontak']);
            $sheet->setCellValue('N' . $numrow, $data['jabatan']);
            $sheet->setCellValue('O' . $numrow, $data['keterangan']);
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
        header('Content-Disposition: attachment; filename="Data Supplier.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA SUPPLIER');
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
