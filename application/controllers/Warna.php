<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Warna extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('warnamodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('barangmodel');
        $this->load->model('helper_model', 'helpermodel');

        $this->load->library('Pdf');
        $this->load->library('pagination');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'master';
        
        $config['base_url'] = base_url().'warna/index'; // The URL to your controller method
        $config['total_rows'] = $this->warnamodel->countdata(); // Total records in your table
        $config['per_page'] = $this->session->userdata('perpage-warna')=='' ? 15 : $this->session->userdata('perpage-warna'); // Records per page
        $config['uri_segment'] = 3; // Which URL segment contains the page number
        $config['attributes'] = array('class' => 'page-link');
        
        $this->pagination->initialize($config);
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $data['jumlahrek'] = $this->warnamodel->countdata();
        $data['links'] = $this->pagination->create_links();
        
        $data['data'] = $this->warnamodel->getdata($config['per_page'],$page);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'warna';
        $this->load->view('layouts/header', $header);
        $this->load->view('warna/warna', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear(){
        $this->session->unset_userdata('perpage-warna');
        $this->session->unset_userdata('pencarian-warna');
        $url = base_url().'warna';
        redirect($url);
    }
    public function addsession(){
        $perpage = $_POST['perpage'];
        $cari = $_POST['cari'];
        $this->session->set_userdata('perpage-warna',$perpage);
        $this->session->set_userdata('pencarian-warna',$cari);
        echo 1;
    }
    public function getcolor(){
        $id = $_POST['id'];
        $base = $this->warnamodel->getbasecolor($id);
        $qry = $this->warnamodel->getcolor($id);
        $html = '';
        if($qry->num_rows() > 0){
            foreach($qry->result_array() as $dtl):
                $aktif = $dtl['aktif']==1 ? '<i class="fa fa-check"></i>' : '';
                $minus = $dtl['plusmin']<0 ? 'text-danger' : '';
                $plusmin = $dtl['plusmin']==0 ? '' : rupiah2($dtl['plusmin'],0).'%';
                $html .= '<tr>';
                $html .= '<td class="font-kecil '.$minus.'">'.$plusmin.'</td>';
                $html .= '<td class="font-kecil">'.$dtl['color'].'</td>';
                $html .= '<td class="font-kecil" style="background-color: '.$dtl['rgb_warna'].'; width:5% !important;">'.$dtl['rgb_warna'].'</td>';
                $html .= '<td class="font-kecil text-green text-center">'.$aktif.'</td>';
                $html .= '</tr>';
            endforeach;
        }else{
            $html .= '<tr><td colspan="4" class="text-center">-- Data Belum ada --</td></tr>';
        }

        $dye = $this->warnamodel->getdyestuff($base['basecolor']);
        $html2 = '';
        if($dye->num_rows() > 0){
            $xno=0;
            foreach($dye->result_array() as $ds): $xno++;
                $html2 .= '<tr>';
                $html2 .= '<td class="font-kecil">'.$xno.'</td>';
                $html2 .= '<td class="font-kecil">'.namaspekbarang($ds['id_barang']).'</td>';
                $html2 .= '<td class="font-kecil text-right">'.rupiah($ds['persen'],5).'</td>';
                $html2 .= '</tr>';
            endforeach;
        }else{
            $html2 .= '<tr><td colspan="3" class="text-center">-- Data Belum ada --</td></tr>';
        }

        $cocok = array('datagroup' => $html,'warna' => $base['basecolor'],'obat' => $html2);
        echo json_encode($cocok);
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
