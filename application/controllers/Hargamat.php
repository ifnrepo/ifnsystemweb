<?php
defined('BASEPATH') or exit('No direct script access allowed');


use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Hargamat extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('taskmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('pb_model');
        $this->load->model('bbl_model');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('adj_model', 'adjmodel');
        $this->load->model('helper_model', 'helpermodel');
        $this->load->model('hargamat_model', 'hargamatmodel');

        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'other';
        // $data['data'] = $this->hargamatmodel->getdata();
        $data['kategori'] = $this->hargamatmodel->getdatakategori();
        $data['bc_option'] = $this->hargamatmodel->getdata_bc();
        $data['artikel'] = $this->hargamatmodel->getdataartikel();
        $data['tahune'] = $this->hargamatmodel->getdatatahun();
        // $data['databbl'] = $this->taskmodel->getdatabbl();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'hargamat';
        $this->load->view('layouts/header', $header);
        $this->load->view('hargamat/hargamat', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->unset_userdata('bl');
        $this->session->userdata('th', date('Y'));
        $url = base_url() . 'hargamat';
        redirect($url);
    }
    public function getbarang()
    {
        $data['data'] = $this->hargamatmodel->getbarang();
        $this->load->view('hargamat/getbarang', $data);
    }
    public function simpanbarang()
    {
        $arrgo = [
            'data' => $_POST['out']
        ];
        $kode = $this->hargamatmodel->simpanbarang($arrgo);
        echo $kode;
    }
    public function addkondisi()
    {
        if ($_POST['kate'] != 'all') {
            $this->session->set_flashdata('katehargamat', $_POST['kate']);
        }
        if ($_POST['arti'] != 'all') {
            $this->session->set_flashdata('artihargamat', $_POST['arti']);
        }
        if ($_POST['bc'] != 'all') {
            $this->session->set_flashdata('bchargamat', $_POST['bc']);
        }
        echo 1;
    }
    public function edithamat($id)
    {
        $data['data'] = $this->hargamatmodel->getdatabyid($id)->row_array();
        $data['dokbc'] = $this->hargamatmodel->getdokbc();
        $data['refbendera'] = $this->hargamatmodel->refbendera();
        $data['refmtuang'] = $this->hargamatmodel->refmtuang();
        $this->load->view('hargamat/edithamat', $data);
    }
    public function updatehamat()
    {
        $query = $this->hargamatmodel->updatehamat();
        if ($query) {
            $url = base_url() . 'hargamat';
            redirect($url);
        }
    }
    public function get_data_hargamat()
    {
        ob_start(); // buffer output
        header('Content-Type: application/json');

        $filter_kategori = $this->input->post('filter_kategori');
        $filter_inv = $this->input->post('filter_inv');
        $filter_bc = $this->input->post('filter_bc');
        $list = $this->hargamatmodel->get_datatables($filter_kategori, $filter_inv, $filter_bc);
        $data = array();
        $no = $_POST['start'];
        $total = 0;
        $kgs = 0;
        $pcs = 0;
        foreach ($list as $field) {
            $tampil = $field->weight == 0 ? $field->qty : $field->weight;
            $barang = $field->id_barang == 0 ? $field->remark . ' (ID not found)' : $field->nama_barang;
            $nobc = '';
            if (trim($field->nomor_bc) !=  '') {
                $nobc = 'BC ' . trim($field->jns_bc) . '-' . $field->nomor_bc;
            }
            $no++;
            $row = array();
            $row[] = $barang;
            $row[] = tglmysql($field->tgl);
            $row[] = $field->nobontr;
            $row[] = $field->nomor_inv;
            // $row[] = $nobc;
            $row[] = rupiah($field->qty, 0);
            $row[] = rupiah($field->weight, 2);
            $row[] = rupiah($field->price, 2);
            $row[] = rupiah($tampil * $field->price, 2);
            // $row[] = $field->nama_supplier;
            // $row[] = $field->mt_uang;
            // $row[] = rupiah($field->oth_amount, 2);
            // $row[] = rupiah($field->kurs, 2);
            // $buton = "<a href=" . base_url() . 'hargamat/edithamat/' . $field->idx . " class='btn btn-sm btn-info' style='padding: 2px 5px !important;' data-bs-target='#modal-large' data-bs-toggle='modal' data-title='Edit HAMAT' title='EDIT " . trim($field->nama_barang) . "'><i class='fa fa-pencil mr-1'></i> Edit</a>";
            // $buton .= "<a href=" . base_url() . 'hargamat/viewdok/' . $field->idx . " class='btn btn-sm btn-danger ml-1' style='padding: 5px !important;' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View DOKUMEN'><i class='fa fa-file-pdf-o'></i></a>";
            // $row[] = $buton;
            // $data[] = $row;
            $buton = '
                <a href="#"
                class="btn btn-sm btn-info edit"
                style="padding: 2px 5px !important;"
                title="Edit Data"
                data-id="' . $field->idx . '">
                <i class="fa fa-pencil mr-1"></i>  Edit</i>
                </a>

                <a href="' . base_url('hargamat/viewdok/' . $field->idx) . '"
                class="btn btn-sm btn-danger ml-1"
                style="padding: 5px !important;"
                data-bs-toggle="offcanvas"
                data-bs-target="#canvasdet"
                data-title="View DOKUMEN">
                <i class="fa fa-file-pdf-o"></i>
                </a>
            ';

            $row[] = $buton;
            $data[] = $row;

            $total += $tampil * $field->price;
            $pcs += $field->qty;
            $kgs += $field->weight;
        }
        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->hargamatmodel->count_all(),
            "recordsFiltered" => $this->hargamatmodel->count_filtered($filter_kategori, $filter_inv, $filter_bc),
            "jumlahTotal" => $total,
            "jumlahPcs" => $pcs,
            "jumlahKgs" => $kgs,
            "data" => $data,
        );
        $this->session->set_userdata('jmlrek', $this->hargamatmodel->hitungrec($filter_kategori, $filter_inv, $filter_bc));
        // $isinya = $this->session->userdata('jmlrek');
        echo "<script type='text/javascript'>
                isirekod = '<?= base_url() ?>';
            </script>";
        $this->kedepan();
        ob_clean();
        echo json_encode($output);
        ob_end_flush();
        error_log("Finished fetching data");
    }
    function kedepan()
    {
        return 0;
    }
    public function viewdok($id)
    {
        $data['data'] = $this->hargamatmodel->getdatabyid($id)->row_array();
        $this->load->view('hargamat/viewdok', $data);
    }
    public function ubahperiode()
    {
        $this->session->set_userdata('bl', $_POST['bl']);
        $this->session->set_userdata('th', $_POST['th']);
        echo 1;
    }
    //End Controller
    public function mode()
    {
        $this->session->set_userdata('modetask', $_POST['id']);
        echo 1;
    }
    public function validasipb($id)
    {
        $cek = $this->pb_model->cekfield($id, 'data_ok', 1)->num_rows();
        if ($cek == 1) {
            $data = [
                'ok_valid' => 1,
                'tgl_valid' => date('Y-m-d H:i:s'),
                'user_valid' => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->pb_model->validasipb($data);
            $this->helpermodel->isilog($this->db->last_query());
        } else {
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function cancelpb()
    {
        $data = [
            'id' => $_POST['id'],
            'ketcancel' => $_POST['ketcancel'],
            'ok_valid' => 2,
            'user_valid' => $this->session->userdata('id'),
            'tgl_valid' => date('Y-m-d H:i:s')
        ];
        $simpan = $this->pb_model->simpancancelpb($data);
        $this->helpermodel->isilog($this->db->last_query());
        // if ($simpan) {
        //     // $this->session->set_flashdata('tabdef',$tab);
        //     $url = base_url() . 'task';
        //     redirect($url);
        // }
        echo $simpan;
    }
    public function validasibbl($id, $kolom)
    {
        $arraykolom = ['data_ok', 'ok_pp', 'ok_valid', 'ok_tuju', 'ok_pc'];
        $arraytgl = ['tgl_ok', 'tgl_pp', 'tgl_valid', 'tgl_tuju', 'tgl_pc'];
        $arrayuser = ['user_ok', 'user_pp', 'user_valid', 'user_tuju', 'user_pc'];
        $cek = $this->taskmodel->cekfield($id, $arraykolom[$kolom - 1], 0)->num_rows();
        if ($cek == 1) {
            $data = [
                $arraykolom[$kolom - 1] => 1,
                $arraytgl[$kolom - 1] => date('Y-m-d H:i:s'),
                $arrayuser[$kolom - 1] => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasibbl($data);
            $this->helpermodel->isilog($this->db->last_query());
        } else {
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function cancelbbl()
    {
        $id = $_POST['id'];
        $kolom = $_POST['ke'];
        $ketcancel = $_POST['ketcancel'];
        $arraykolom = ['data_ok', 'ok_pp', 'ok_valid', 'ok_tuju', 'ok_pc'];
        $arraytgl = ['tgl_ok', 'tgl_pp', 'tgl_valid', 'tgl_tuju', 'tgl_pc'];
        $arrayuser = ['user_ok', 'user_pp', 'user_valid', 'user_tuju', 'user_pc'];
        $cek = $this->taskmodel->cekfield($id, $arraykolom[$kolom - 1], 0)->num_rows();
        if ($cek == 1) {
            $data = [
                $arraykolom[$kolom - 1] => 2,
                $arraytgl[$kolom - 1] => date('Y-m-d H:i:s'),
                $arrayuser[$kolom - 1] => $this->session->userdata('id'),
                'ketcancel' => $_POST['ketcancel'],
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasibbl($data);
            $this->helpermodel->isilog($this->db->last_query());
        } else {
            $simpan = 1;
        }
        // if ($simpan) {
        //     $url = base_url() . 'task';
        //     redirect($url);
        // }
        echo $simpan;
    }
    public function validasipo($id, $kolom)
    {
        $arraykolom = ['data_ok', 'ok_pp', 'ok_valid', 'ok_tuju', 'ok_pc'];
        $arraytgl = ['tgl_ok', 'tgl_pp', 'tgl_valid', 'tgl_tuju', 'tgl_pc'];
        $arrayuser = ['user_ok', 'user_pp', 'user_valid', 'user_tuju', 'user_pc'];
        $cek = $this->taskmodel->cekfield($id, $arraykolom[$kolom - 1], 0)->num_rows();
        if ($cek == 1) {
            $data = [
                $arraykolom[$kolom - 1] => 1,
                $arraytgl[$kolom - 1] => date('Y-m-d H:i:s'),
                $arrayuser[$kolom - 1] => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasipo($data);
            $this->helpermodel->isilog($this->db->last_query());
        } else {
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function cancelpo()
    {
        $id = $_POST['id'];
        $kolom = $_POST['ke'];
        $ketcancel = $_POST['ketcancel'];
        $arraykolom = ['data_ok', 'ok_pp', 'ok_valid', 'ok_tuju', 'ok_pc'];
        $arraytgl = ['tgl_ok', 'tgl_pp', 'tgl_valid', 'tgl_tuju', 'tgl_pc'];
        $arrayuser = ['user_ok', 'user_pp', 'user_valid', 'user_tuju', 'user_pc'];
        $cek = $this->taskmodel->cekfield($id, $arraykolom[$kolom - 1], 0)->num_rows();
        if ($cek == 1) {
            $data = [
                $arraykolom[$kolom - 1] => 2,
                $arraytgl[$kolom - 1] => date('Y-m-d H:i:s'),
                $arrayuser[$kolom - 1] => $this->session->userdata('id'),
                'id' => $id,
                'ketcancel' => $ketcancel,
            ];
            $simpan = $this->taskmodel->validasipo($data);
            $this->helpermodel->isilog($this->db->last_query());
        } else {
            $simpan = 1;
        }
        // if ($simpan) {
        //     $url = base_url() . 'task';
        //     redirect($url);
        // }
        echo $simpan;
    }
    public function editbbl($id)
    {
        $header['header'] = 'pendingtask';
        // $data['data'] = $this->taskmodel->getdata($this->session->userdata('modetask'));
        $data['header'] = $this->bbl_model->getdatabyid($id);
        $data['detail'] = $this->bbl_model->getdatadetail_bbl($id);
        $data['departemen'] = $this->deptmodel->getdata_dept_pb();
        $footer['fungsi'] = 'pendingtask';
        $this->load->view('layouts/header', $header);
        $this->load->view('task/editbbl', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function editapprovebbl($id, $kolom)
    {
        $cek = $this->taskmodel->cekfield($id, 'ok_tuju', 0)->num_rows();
        if ($cek == 1) {
            $data = [
                'ok_valid' => 0,
                'tgl_valid' => date('Y-m-d H:i:s'),
                'user_valid' => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasibbl($data);
            $this->helpermodel->isilog($this->db->last_query());
        } else {
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function validasiadj($id)
    {
        $cek = $this->taskmodel->cekfield($id, 'data_ok', 1)->num_rows();
        if ($cek == 1) {
            $data = [
                'ok_valid' => 1,
                'tgl_valid' => date('Y-m-d H:i:s'),
                'user_valid' => $this->session->userdata('id'),
                'id' => $id
            ];
            $simpan = $this->taskmodel->validasiadj($data);
            $this->helpermodel->isilog($this->db->last_query());
        } else {
            $simpan = 1;
        }
        if ($simpan) {
            $url = base_url() . 'task';
            redirect($url);
        }
    }
    public function canceladj()
    {
        $data = [
            'id' => $_POST['id'],
            'ketcancel' => $_POST['ketcancel'],
            'ok_valid' => 2,
            'user_valid' => $this->session->userdata('id'),
            'tgl_valid' => date('Y-m-d H:i:s')
        ];
        $simpan = $this->taskmodel->simpancanceladj($data);
        $this->helpermodel->isilog($this->db->last_query());
        // if ($simpan) {
        //     $this->session->set_flashdata('tabdef',$tab);
        //     $url = base_url() . 'task';
        //     redirect($url);
        // }
        echo $simpan;
    }
    public function canceltask($id = 0, $ke = 0)
    {
        $data['ke'] = $ke;
        $data['data'] = $this->taskmodel->getdatabyid($id);
        $this->load->view('task/canceltask', $data);
    }

    public function excel2()
    {
        $dir = 'assets\docs\templatelapkontrakdankonversi.xlsx';
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($dir);

        $worksheet = $spreadsheet->getActiveSheet();

        $worksheet->getCell('A1')->setValue('John');
        $worksheet->getCell('A2')->setValue('Smith');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        // $writer->save('write.xlsx');

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Harga Material.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA HARGA MATERIAL');
    }

    public function excel()
    {
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', "DATA HARGA MATERIAL");
        $sheet->getStyle('A1')->getFont()->setBold(true);

        $sheet->setCellValue('A2', "NO");
        $sheet->setCellValue('B2', "ARTICLE");
        $sheet->setCellValue('C2', "TANGGAL");
        $sheet->setCellValue('D2', "NOMOR IB");
        $sheet->setCellValue('E2', "QTY");
        $sheet->setCellValue('F2', "WEIGHT");
        $sheet->setCellValue('G2', "PRICE");
        $sheet->setCellValue('H2', "TOTAL");
        $sheet->setCellValue('J2', "CUR");
        $sheet->setCellValue('K2', "AMOUNT");
        $sheet->setCellValue('L2', "KURS (IDR)");

        $filter_kategori = $this->input->get('filter');
        $filter_inv = $this->input->get('filterinv');
        $harga = $this->hargamatmodel->getdata_export($filter_kategori, $filter_inv);

        $no = 1;
        $numrow = 3;

        foreach ($harga as $data) {
            $tampil = $data['weight'] == 0 ? $data['qty'] : $data['weight'];
            $barang = $data['id_barang'] == 0 ? $data['remark'] . '(ID not found)' : $data['nama_barang'];
            $sheet->setCellValue('A' . $numrow, $no);
            $sheet->setCellValue('B' . $numrow, $barang);
            $sheet->setCellValue('C' . $numrow, tglmysql($data['tgl']));
            $sheet->setCellValue('D' . $numrow, $data['nobontr']);
            $sheet->setCellValue('E' . $numrow, rupiah($data['qty'], 0));
            $sheet->setCellValue('F' . $numrow, rupiah($data['weight'], 2));
            $sheet->setCellValue('G' . $numrow, rupiah($data['price'], 2));
            $sheet->setCellValue('H' . $numrow, rupiah($tampil * $data['price'], 2));
            $sheet->setCellValue('J' . $numrow, $data['mt_uang']);
            $sheet->setCellValue('K' . $numrow, rupiah($data['oth_amount'], 2));
            $sheet->setCellValue('L' . $numrow, rupiah($data['kurs'], 2));
            $no++;
            $numrow++;
        }

        $sheet->getDefaultRowDimension()->setRowHeight(-1);
        $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
        $sheet->setTitle(" DATA HARGA MATERIAL");

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Data Harga Material.xlsx"');
        header('Cache-Control: max-age=0');
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        $this->helpermodel->isilog('Download Excel DATA HARGA MATERIAL');
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
        $pdf->Cell(30, 18, 'DATA HARGA MATERIAL');
        $pdf->ln(12);
        $pdf->SetFont('Latob', '', 10);
        $pdf->Cell(10, 8, 'No', 1, 0, 'C');
        $pdf->Cell(103, 8, 'Article ', 1, 0, 'C');
        // $pdf->Cell(22, 8, 'Tanggal', 1, 0, 'C');
        $pdf->Cell(35, 8, 'Nomor Ib', 1, 0, 'C');
        $pdf->Cell(18, 8, 'Qty', 1, 0, 'C');
        // $pdf->Cell(23, 8, 'Weight', 1, 0, 'C');
        $pdf->Cell(23, 8, 'Price', 1, 0, 'C');
        $pdf->Cell(27, 8, 'Total', 1, 0, 'C');
        $pdf->Cell(15, 8, 'Cur', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Amount', 1, 0, 'C');
        $pdf->Cell(25, 8, 'Kurs', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->ln(8);
        $filter_kategori = $this->input->get('filter');
        $filter_inv = $this->input->get('filterinv');

        $harga = $this->hargamatmodel->getdata_export($filter_kategori, $filter_inv);
        $no = 1;
        foreach ($harga as $det) {
            $tampil = $det['weight'] == 0 ? $det['qty'] : $det['weight'];
            $barang = $det['id_barang'] == 0 ? $det['remark'] . '(ID not found)' : $det['nama_barang'];
            $pdf->Cell(10, 6, $no++, 1, 0, 'C');
            $pdf->Cell(103, 6, $barang, 1);
            // $pdf->Cell(22, 6, tglmysql($det['tgl']));
            $pdf->Cell(35, 6, $det['nobontr'], 1);
            $pdf->Cell(18, 6, rupiah($det['qty'], 0), 1);
            // $pdf->Cell(23, 6, rupiah($det['weight'], 0), 1);
            $pdf->Cell(23, 6, rupiah($det['price'], 0), 1);
            $pdf->Cell(27, 6, rupiah($tampil * $det['price'], 2), 1);
            $pdf->Cell(15, 6, $det['mt_uang'], 1);
            $pdf->Cell(25, 6, rupiah($det['oth_amount'], 2), 1);
            $pdf->Cell(25, 6, rupiah($det['kurs'], 2), 1);
            $pdf->ln(6);
        }
        $pdf->SetFont('Lato', '', 8);
        $pdf->ln(10);
        $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
        $pdf->Output('I', 'Data Harga Material.pdf');
        $this->helpermodel->isilog('Download PDF DATA HARGA MATERIAL');
    }
}
