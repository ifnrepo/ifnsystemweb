<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Bckeluar extends CI_Controller
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
        $this->load->model('bckeluarmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'other';
        $data['dept'] = $this->dept_model->getdata();
        if ($this->session->userdata('tglawal') == null) {
            $data['tglawal'] = tglmysql(date('Y-m-01'));
            $data['tglakhir'] = tglmysql(lastday(date('Y') . '-' . date('m') . '-01'));
            $data['jns'] = null;
            $data['data'] = null;
        }else{
            $data['tglawal'] = $this->session->userdata('tglawal');
            $data['tglakhir'] = $this->session->userdata('tglakhir');
            $data['jns'] = $this->session->userdata('jnsbc');
            $data['data'] = $this->bckeluarmodel->getdata();
        }
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'bckeluar';
        $this->load->view('layouts/header', $header);
        $this->load->view('bckeluar/bckeluar', $data);
        $this->load->view('layouts/footer',$footer);
    }

    public function clear(){
       $this->session->unset_userdata('tglawal');
        $this->session->unset_userdata('tglakhir');
        $this->session->unset_userdata('jnsbc'); 
        $this->session->unset_userdata('filterkat');
        $url = base_url('bckeluar');
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
        $data['riwayat'] = riwayatbckeluar($id);
        $data['detail'] = $this->bckeluarmodel->getdatabyid($id)->row_array();
        // $data['databarang'] = $this->bckeluarmodel->getdetailbyid($id);
        $data['iddet'] = $id;
        $this->load->view('bckeluar/viewdetail',$data);
    }
    public function loaddatadetail(){
        $id = $_POST['id'];
        $data = $this->bckeluarmodel->getdetailbyid($id);
        $html = "";
        $no=1;
         foreach ($data->result_array() as $datadet) {
            $sku =($datadet['po']=='') ?$datadet['brg_id'] : ($datadet['po'].'#'.$datadet['item'].' '.($datadet['dis']==0 ? '' : ' dis '.$datadet['dis']));
            $pengali = $datadet['kodesatuan']=='KGS' ? $datadet['kgs'] : $datadet['pcs'];
            if($this->session->userdata('jnsbc')=='30'){
                $spek = $datadet['po']=='' ? $datadet['nama_barang'] : (($datadet['engklp']=='') ? $datadet['spek'] : $datadet['engklp']);
            }else{
                $spek = $datadet['po']=='' ? $datadet['nama_barang'] : $datadet['spek'];
            }
            $html .= "<tr>";
            $html .= "<td>".$no++."</td>";
            $html .= "<td>".$spek."</td>";
            $html .= "<td>".$sku."</td>";
            $html .= "<td>".$datadet['kodesatuan']."</td>";
            $html .= "<td class='text-right'>".rupiah($datadet['pcs'],0)."</td>";
            $html .= "<td class='text-right'>".rupiah($datadet['kgs'],2)."</td>";
            $html .= "<td>".$datadet['nohs']."</td>";
            $html .= "<td class='text-right'>".rupiah($datadet['harga'],4)."</td>";
            $html .= "<td class='text-right'>".rupiah($datadet['harga']*$pengali,2)."</td>";
            $html .= "</tr>";
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function excel(){
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "BC MASUK ".$this->session->userdata('jnsbc')); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "JNS DOK"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "TGL DOK"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "NOMOR DOK"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "NO TERIMA");
        $sheet->setCellValue('E2', "TGL TERIMA");
        $sheet->setCellValue('F2', "PEMASOK/PENGIRIM");
        $sheet->setCellValue('G2', "KODE BARANG");
        $sheet->setCellValue('H2', "SPEK BARANG");
        $sheet->setCellValue('I2', "URAIAN BARANG");
        $sheet->setCellValue('J2', "SAT");
        $sheet->setCellValue('K2', "QTY");
        $sheet->setCellValue('L2', "NILAI IDR");
        $sheet->setCellValue('M2', "NILAI USD");
        $sheet->setCellValue('N2', "KGS (BRUTO)");
        $sheet->setCellValue('O2', "KGS (NETTO)");
        // Panggil model Get Data   
        $bcmasuk = $this->bcmasukmodel->getdataexcel();
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($bcmasuk->result_array() as $data) {
            $nilaiqty = $data['kodesatuan']=='KGS' ? $data['kgs'] : $data['pcs'];
            $nilaiidr = $data['xmtuang']!='USD' ? $data['harga']*$nilaiqty : ($data['harga']*$nilaiqty)*$data['kurs_usd'];
            $nilaiusd = $data['xmtuang']=='USD' ? $data['harga']*$nilaiqty : ($data['harga']*$nilaiqty)*$data['kurs_usd'];
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $data['jns_bc']);
            $sheet->setCellValue('B' . $numrow, $data['tgl_bc']);
            $sheet->setCellValue('C' . $numrow, $data['nomor_bc']);
            $sheet->setCellValue('D' . $numrow, $data['tgl']);
            $sheet->setCellValue('E' . $numrow, $data['nomor_dok']);
            $sheet->setCellValue('F' . $numrow, $data['nama_supplier']);
            $sheet->setCellValue('G' . $numrow, $data['kode']);
            $sheet->setCellValue('H' . $numrow, $data['nama_barang']);
            $sheet->setCellValue('I' . $numrow, $data['nama_alias']);
            $sheet->setCellValue('J' . $numrow, $data['kodesatuan']);
            $sheet->setCellValue('K' . $numrow, $nilaiqty);
            $sheet->setCellValue('L' . $numrow, $nilaiidr);
            $sheet->setCellValue('M' . $numrow, $nilaiusd);
            $sheet->setCellValue('N' . $numrow, $data['bruto']);
            $sheet->setCellValue('O' . $numrow, $data['kgs']);
            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data BC Masuk");
        $jns = $this->session->userdata('jnsbc')=='Y' ? 'ALL' : $this->session->userdata('jnsbc');
        $title = 'BC '.$jns.' '.$this->session->userdata('tglawal').' sd '.$this->session->userdata('tglakhir');

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="'.$title.'.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA DEPARTEMEN');
    }
    //End Controller
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