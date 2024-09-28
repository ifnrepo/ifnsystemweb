<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Customer extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }

        $this->load->model('customer_model');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['customer'] = $this->customer_model->getdata();
        $this->load->view('layouts/header', $header);
        $this->load->view('customer/index', $data);
        $this->load->view('layouts/footer');
    }

    public function tambahdata()
    {
        $this->load->view('customer/addcustomer');
    }

    public function simpancustomer()
    {
        $data = [
            'kode_customer' => $_POST['kode_customer'],
            'nama_customer' => $_POST['nama_customer'],
            'exdo' => $_POST['exdo'],
            'port' => $_POST['port'],
            'country' => $_POST['country'],
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
            'keterangan' => $_POST['keterangan']
        ];
        $hasil = $this->customer_model->simpancustomer($data);
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }

    public function editcustomer($id)
    {

        $header['header'] = 'master';
        $data['data'] = $this->customer_model->getdatabyid($id);
        // $this->load->view('layouts/header', $header);
        $this->load->view('customer/editcustomer', $data);
        // $this->load->view('layouts/footer');
    }
    public function updatecustomer()
    {
        $data = [
            'id' => $_POST['id'],
            'kode_customer' => $_POST['kode_customer'],
            'nama_customer' => $_POST['nama_customer'],
            'exdo' => $_POST['exdo'],
            'port' => $_POST['port'],
            'country' => $_POST['country'],
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
            'keterangan' => $_POST['keterangan']
        ];
        $hasil = $this->customer_model->updatecustomer($data);
        // if ($hasil) {
        //     $this->session->set_flashdata('pesan', ' <div class="alert alert-success" role="alert"> Data  berhasil diperbarui.');
        // } else {
        //     $this->session->set_flashdata('pesan', ' <div class="alert alert-danger" role="alert"> Gagal memperbarui data ');
        // }
        //redirect('customer');
        $this->helpermodel->isilog($this->db->last_query());
        echo $hasil;
    }

    public function hapuscustomer($id)
    {
        $hasil = $this->customer_model->hapuscustomer($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url() . 'customer';
            redirect($url);
        }
    }

    public function viewcustomer($id)
    {
        $data['data'] = $this->customer_model->getdatabyid($id);
        $this->load->view('customer/viewcustomer', $data);
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA CUSTOMER"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE "); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "CUSTOMER"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "EXDO");
        $sheet->setCellValue('E2', "PORT");
        $sheet->setCellValue('F2', "COUNTRY");
        $sheet->setCellValue('G2', "ALAMAT");
        $sheet->setCellValue('H2', "DESA");
        $sheet->setCellValue('I2', "KECAMATAN");
        $sheet->setCellValue('J2', "KAB/KOTA");
        $sheet->setCellValue('K2', "PROVINSI");
        $sheet->setCellValue('L2', "KODE POS");
        $sheet->setCellValue('M2', "NPWP");
        $sheet->setCellValue('N2', "TELP");
        $sheet->setCellValue('O2', "EMAIL");
        $sheet->setCellValue('P2', "KONTAK");
        $sheet->setCellValue('Q2', "KETERANGAN");
        // Panggil model Get Data   
        $customer = $this->customer_model->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($customer as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['kode_customer']);
            $sheet->setCellValue('C' . $numrow, $data['nama_customer']);
            $sheet->setCellValue('D' . $numrow, $data['exdo']);
            $sheet->setCellValue('E' . $numrow, $data['port']);
            $sheet->setCellValue('F' . $numrow, $data['country']);
            $sheet->setCellValue('G' . $numrow, $data['alamat']);
            $sheet->setCellValue('H' . $numrow, $data['desa']);
            $sheet->setCellValue('I' . $numrow, $data['kecamatan']);
            $sheet->setCellValue('J' . $numrow, $data['kab_kota']);
            $sheet->setCellValue('K' . $numrow, $data['propinsi']);
            $sheet->setCellValue('L' . $numrow, $data['kodepos']);
            $sheet->setCellValue('M' . $numrow, $data['npwp']);
            $sheet->setCellValue('N' . $numrow, $data['telp']);
            $sheet->setCellValue('O' . $numrow, $data['email']);
            $sheet->setCellValue('P' . $numrow, $data['kontak']);
            $sheet->setCellValue('Q' . $numrow, $data['keterangan']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle(" DATA CUSTOMER");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Customer.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA CUSTOMER');
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
        $pdf->Cell(30, 18, 'DATA CUSTOMER');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(8, 8, 'No', 1, 0, 'C');
        $pdf->Cell(15, 8, 'Kode', 1, 0, 'C');
        $pdf->Cell(43, 8, 'Nama Customer', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Country', 1, 0, 'C');
        $pdf->Cell(33, 8, 'Telp', 1, 0, 'C');
        $pdf->Cell(20, 8, 'Exdo', 1, 0, 'C');
        $pdf->Cell(30, 8, 'Npwp', 1, 0, 'C');
        $pdf->Cell(33, 8, 'Telp', 1, 0, 'C');
        $pdf->Cell(57, 8, 'Alamat', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(8);
        $detail = $this->customer_model->getdata();
        $no = 1;
        foreach ($detail as $det) {
            $pdf->Cell(8, 6, $no++, 1, 0, 'C');
            $pdf->Cell(15, 6, $det['kode_customer'], 1);
            $pdf->Cell(43, 6, $det['nama_customer'], 1);
            $pdf->Cell(35, 6, $det['country'], 1);
            $pdf->Cell(33, 6, $det['telp'], 1);
            $pdf->Cell(20, 6, $det['exdo'], 1);
            $pdf->Cell(30, 6, $det['npwp'], 1);
            $pdf->Cell(33, 6, $det['telp'], 1);
            $pdf->Cell(57, 6, $det['alamat'], 1);;
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Customer.pdf');
        $this->helpermodel->isilog('Download PDF DATA CUSTOMER');
    }
}
