<?php
defined('BASEPATH') or exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Logact extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('logactmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model','helpermodel');


        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'other';
        $data['data'] = null;
        $data['datauser'] = $this->logactmodel->getdatauser();
        if ($this->session->userdata('tglawallog') != null && $this->session->userdata('tglakhirlog') != null) {
            $data['data'] = $this->logactmodel->getdata();
        }
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'logact';
        $this->load->view('layouts/header', $header);
        $this->load->view('logact/logact', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->unset_userdata('tglawallog');
        $this->session->unset_userdata('tglakhirlog');
        $this->session->unset_userdata('userlogact');
        $url = base_url() . 'logact';
        redirect($url);
    }
    public function updatetgl()
    {
        $tgaw = $_POST['tgaw'];
        $tgak = $_POST['tgak'];
        $userlog = $_POST['usr'];
        $this->session->set_userdata('tglawallog', tglmysql($tgaw));
        $this->session->set_userdata('tglakhirlog', tglmysql($tgak));
        $this->session->set_userdata('userlogact', $userlog);
        $url = base_url() . 'logact';
        redirect($url);
    }
    //End Controller 
    public function tambahdata()
    {
        $data['itemsatuan'] = $this->satuanmodel->getdata();
        $data['itemkategori'] = $this->kategorimodel->getdata();
        $data['kode'] = time();
        $this->load->view('barang/addbarang', $data);
    }
    public function simpanbarang()
    {
        $data = [
            'kode' => $_POST['kode'],
            'nama_barang' => $_POST['nama'],
            'id_satuan' => $_POST['sat'],
            'id_kategori' => $_POST['kat'],
            'dln' => $_POST['dln'],
            'noinv' => $_POST['noinv']
        ];
        $hasil = $this->barangmodel->simpanbarang($data);
        echo $hasil;
    }
    public function editbarang($id)
    {
        $data['data'] = $this->barangmodel->getdatabyid($id)->row_array();
        $data['itemsatuan'] = $this->satuanmodel->getdata();
        $data['itemkategori'] = $this->kategorimodel->getdata();
        $this->load->view('barang/editbarang', $data);
    }
    public function updatebarang()
    {
        $data = [
            'id' => $_POST['id'],
            'kode' => $_POST['kode'],
            'nama_barang' => $_POST['nama'],
            'id_satuan' => $_POST['sat'],
            'id_kategori' => $_POST['kat'],
            'dln' => $_POST['dln'],
            'noinv' => $_POST['noinv']
        ];
        $hasil = $this->barangmodel->updatebarang($data);
        echo $hasil;
    }
    public function hapusbarang($id)
    {
        $hasil = $this->barangmodel->hapusbarang($id);
        if ($hasil) {
            $url = base_url() . 'barang';
            redirect($url);
        }
    }
    public function bombarang($id)
    {
        $header['header'] = 'master';
        $data['detail'] = $this->barangmodel->getdatabyid($id)->row_array();
        $data['data'] = $this->barangmodel->getdatabom($id);
        $footer['fungsi'] = 'barang';
        $this->load->view('layouts/header', $header);
        $this->load->view('barang/bombarang', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function addbombarang($id)
    {
        $data['barang'] = $this->barangmodel->getdatajson();
        $data['id_barang'] = $id;
        $this->load->view('barang/addbombarang', $data);
    }
    public function simpanbombarang()
    {
        $data = [
            'id_barang' => $_POST['id_barang'],
            'id_barang_bom' => $_POST['id_bbom'],
            'persen' => $_POST['psn']
        ];
        $hasil = $this->barangmodel->simpanbombarang($data);
        echo $hasil;
    }
    public function editbombarang($id)
    {
        $data['barang'] = $this->barangmodel->getdata();
        $data['detail'] = $this->barangmodel->getdatabombyid($id)->row_array();
        $this->load->view('barang/editbombarang', $data);
    }
    public function updatebombarang()
    {
        $data = [
            'id_barang' => $_POST['id_barang'],
            'id_barang_bom' => $_POST['id_bbom'],
            'persen' => $_POST['psn'],
            'id' => $_POST['id']
        ];
        $hasil = $this->barangmodel->updatebombarang($data);
        echo $hasil;
    }
    public function hapusbombarang($id, $idb)
    {
        $hasil = $this->barangmodel->hapusbombarang($id);
        if ($hasil) {
            $url = base_url() . 'barang/bombarang/' . $idb;
            redirect($url);
        }
    }
    // public function get_data_barang()
    // {
    //     $list = $this->barangmodel->get_datatables();
    //     $data = array();
    //     $no = $_POST['start'];
    //     foreach ($list as $field) {
    //         $no++;
    //         $row = array();
    //         $row[] = $no;
    //         $row[] = $field->kode;
    //         $row[] = $field->nama_barang;
    //         $row[] = $field->nama_kategori;
    //         $row[] = $field->namasatuan;
    //         if ($field->dln == 1) {
    //             $row[] = '<i class="fa fa-check text-success"></i>';
    //         } else {
    //             $row[] = '-';
    //         }
    //         $jmbon = $field->jmbom > 0 ? "<span class='badge bg-pink text-blue-fg badge-notification badge-pill'>" . $field->jmbom . "</span>" : "";
    //         $buton = "<a href=" . base_url() . 'barang/editbarang/' . $field->id . " class='btn btn-sm btn-primary btn-icon text-white mr-1' rel=" . $field->id . " title='Edit data' id='editsatuan' data-bs-toggle='modal' data-bs-target='#modal-simple' data-title='Edit Data Satuan'><i class='fa fa-edit'></i></a>";
    //         $buton .= "<a class='btn btn-sm btn-danger btn-icon text-white mr-1' id='hapusbarang' data-bs-toggle='modal' data-bs-target='#modal-danger' data-message='Akan menghapus data ini' title='Hapus data' data-href=" . base_url() . 'barang/hapusbarang/' . $field->id . "><i class='fa fa-trash-o'></i></a>";
    //         $buton .= "<a href=" . base_url() . 'barang/bombarang/' . $field->id . " class='btn btn-sm btn-cyan btn-icon text-white position-relative' style='padding: 3px 8px !important;' title='Add Bill Of Material'>BOM" . $jmbon . "</a>";
    //         $row[] = $buton;

    //         $data[] = $row;
    //     }
    //     $output = array(
    //         "draw" => $_POST['draw'],
    //         "recordsTotal" => $this->barangmodel->count_all(),
    //         "recordsFiltered" => $this->barangmodel->count_filtered(),
    //         "data" => $data,
    //     );
    //     echo json_encode($output);
    // }

    public function get_data_barang()
    {
        ob_start(); // buffer output
        header('Content-Type: application/json');

        $filter_kategori = $this->input->post('filter_kategori');
        $list = $this->barangmodel->get_datatables($filter_kategori);
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $field->kode;
            $row[] = $field->nama_barang;
            $row[] = $field->nama_kategori;
            $row[] = $field->namasatuan;
            if ($field->dln == 1) {
                $row[] = '<i class="fa fa-check text-success"></i>';
            } else {
                $row[] = '-';
            }
            if ($field->noinv == 1) {
                $row[] = '<i class="fa fa-check text-success"></i>';
            } else {
                $row[] = '-';
            }
            $jmbon = $field->jmbom > 0 ? "<span class='badge bg-pink text-blue-fg badge-notification badge-pill'>" . $field->jmbom . "</span>" : "";
            $buton = "<a href=" . base_url() . 'barang/editbarang/' . $field->id . " class='btn btn-sm btn-primary btn-icon text-white mr-1' rel=" . $field->id . " title='Edit data' id='editsatuan' data-bs-toggle='modal' data-bs-target='#modal-simple' data-title='Edit Data Satuan'><i class='fa fa-edit'></i></a>";
            $buton .= "<a class='btn btn-sm btn-danger btn-icon text-white mr-1' id='hapusbarang' data-bs-toggle='modal' data-bs-target='#modal-danger' data-message='Akan menghapus data ini' title='Hapus data' data-href=" . base_url() . 'barang/hapusbarang/' . $field->id . "><i class='fa fa-trash-o'></i></a>";
            $buton .= "<a href=" . base_url() . 'barang/bombarang/' . $field->id . " class='btn btn-sm btn-cyan btn-icon text-white position-relative' style='padding: 3px 8px !important;' title='Add Bill Of Material'>BOM" . $jmbon . "</a>";
            $row[] = $buton;

            $data[] = $row;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->barangmodel->count_all(),
            "recordsFiltered" => $this->barangmodel->count_filtered($filter_kategori),
            "data" => $data,
        );

        ob_clean();
        echo json_encode($output);
        ob_end_flush();
        error_log("Finished fetching data");
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

        $sheet->setCellValue('A1', "DATA LOG ACTIVITY"); // Set kolom A1 dengan tulisan "DATA SISWA"    
        $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

        // Buat header tabel nya pada baris ke 3    
        $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
        $sheet->setCellValue('B2', "DATETIME LOG"); // Set kolom B3 dengan tulisan "KODE"    
        $sheet->setCellValue('C2', "ACTIVITY LOG"); // Set kolom C3 dengan tulisan "NAMA SATUAN"      
        $sheet->setCellValue('D2', "MODUL");
        $sheet->setCellValue('E2', "USER LOG");
        $sheet->setCellValue('F2', "DEVICE LOG");
        // Panggil model Get Data   

        $tglawal = $this->input->get('tglawal');
        $tglakhir = $this->input->get('tglakhir');
        $userlog = $this->input->get('userlog');

        $log = $this->logactmodel->getFilteredData($tglawal, $tglakhir, $userlog);
        $no = 1;

        // Untuk penomoran tabel, di awal set dengan 1    
        $numrow = 3;

        // Set baris pertama untuk isi tabel adalah baris ke 3    
        foreach ($log as $data) {
            // Lakukan looping pada variabel      
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, tglmysql2($data['datetimelog']));
            $sheet->setCellValue('C' . $numrow, $data['activitylog']);
            $sheet->setCellValue('E' . $numrow, $data['modul']);
            $sheet->setCellValue('F' . $numrow, $data['userlog']);
            $sheet->setCellValue('G' . $numrow, getdevice($data['devicelog']));

            $no++;
            // Tambah 1 setiap kali looping      
            $numrow++; // Tambah 1 setiap kali looping    
        }


        // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        // Set orientasi kertas jadi LANDSCAPE    
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        // Set judul file excel nya    
        $sheet->setTitle("Data Log Activity");

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Log Activity.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA LOG ACTIVITY');
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
        $pdf->Image(base_url() . 'assets/image/logodepanK.png', 0, 5, 55);
        $pdf->Cell(30, 18, 'DATA LOG ACTIVITY');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 12);
        $pdf->Cell(120, 8, 'Activity Log', 1, 0, 'C');
        $pdf->Cell(40, 8, 'Date Log', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Modul', 1, 0, 'C');
        $pdf->Cell(40, 8, 'User Log', 1, 0, 'C');
        $pdf->Cell(48, 8, 'Device Log', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);

        $tglawal = $this->input->get('tglawal');
        $tglakhir = $this->input->get('tglakhir');
        $userlog = $this->input->get('userlog');

        $log = $this->logactmodel->getFilteredData($tglawal, $tglakhir, $userlog);
        foreach ($log as $det) {
            $x = $pdf->GetX();
            $y = $pdf->GetY();
            $pdf->MultiCell(120, 6, $det['activitylog'], 1);
            $height = $pdf->GetY() - $y;
            $pdf->SetXY($x + 120, $y);
            $pdf->Cell(40, $height, tglmysql($det['datetimelog']), 1);
            $pdf->Cell(25, $height, $det['modul'], 1);
            $pdf->Cell(40, $height, $det['userlog'], 1);
            $pdf->Cell(48, $height, getdevice($det['devicelog']), 1);
            $pdf->Ln($height);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Output('I', 'Data Log Activity.pdf');
        $this->helpermodel->isilog('Download PDF DATA LOG ACTIFITY');
    }
}
