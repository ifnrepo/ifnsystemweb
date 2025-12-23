<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Bcwaste extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('satuanmodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('inv_model', 'invmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'other';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->gethakdeptout($this->session->userdata('arrdep'));
        $data['dephak'] = $this->deptmodel->getdata();
        $data['levnow'] = $this->session->userdata['level_user'] == 1 ? 'disabled' : '';
        $this->session->set_userdata('currdept','GW');
        $data['repbeac'] = 1;
        if($this->session->userdata('viewinv')==null){
            $this->session->set_userdata('viewinv',1);
        }
        if ($this->session->userdata('tglawal') == null) {
            $data['tglawal'] = tglmysql(date('Y-m-d'));
            $data['tglakhir'] = tglmysql(lastday($this->session->userdata('th') . '-' . $this->session->userdata('bl') . '-01'));
            $data['data'] = null;
            $data['kat'] = null;
            $data['katbece'] = null;
            $data['gbg'] = '';
            $data['ifndln'] = null;
            $data['kategoricari'] = 'Cari Barang';
        } else {
            $data['tglawal'] = $this->session->userdata('tglawal');
            $data['tglakhir'] = $this->session->userdata('tglakhir');
            $data['data'] = $this->invmodel->getdata();
            $data['kat'] = $this->invmodel->getdatakategori();
            $data['katbece'] = $this->invmodel->getdatabc();
            $data['ifndln'] = $this->session->userdata('ifndln');
            $data['gbg'] = $this->session->userdata('gbg') == 1 ? 'checked' : '';
            $data['kategoricari'] = $this->session->userdata('kategoricari');
        }
        $data['buyer'] = $this->invmodel->getbuyer();
        $data['currdept'] = "$%";
        $data['ifndln'] = 'X';
        $data['req_inv'] = 0;
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'inv';
        $this->load->view('layouts/header', $header);
        $this->load->view('inv/inv', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function tambahdata()
    {
        $this->load->view('satuan/addsatuan');
    }
    public function simpansatuan()
    {
        $data = [
            'kodesatuan' => $_POST['kode'],
            'kodebc' => $_POST['bc'],
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
            'kodebc' => $_POST['bc'],
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

        $sheet->setCellValue('A1', "DATA SATUAN"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "KODE"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "KODE BC"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "NAMA SATUAN");
        // Panggil model Get Data   
        $satuan = $this->satuanmodel->getdata();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($satuan->result_array() as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $data['kodesatuan']);
            $sheet->setCellValue('C' . $numrow, $data['kodebc']);
            $sheet->setCellValue('E' . $numrow, $data['namasatuan']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Satuan");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Satuan.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA SATUAN');
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
        $pdf->Cell(30, 18, 'DATA SATUAN');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(15, 8, 'No', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Kode Satuan', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Kode Bc', 1, 0, 'C');
        $pdf->Cell(100, 8, 'Nama Satuan', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $detail = $this->satuanmodel->getdata();
        $no = 1;
        foreach ($detail->result_array() as $det) {
            $pdf->Cell(15, 6, $no++, 1, 0, 'C');
            $pdf->Cell(35, 6, $det['kodesatuan'], 1);
            $pdf->Cell(35, 6, $det['kodebc'], 1);
            $pdf->Cell(100, 6, $det['namasatuan'], 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Satuan.pdf');
        $this->helpermodel->isilog('Download PDF DATA SATUAN');
    }
}
