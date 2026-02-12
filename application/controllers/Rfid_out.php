<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Rfid_out extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('Rfid_outmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');


        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $data['title'] = 'Container IN';
        $header['header'] = 'rfid';
        $data['plno'] = $this->Rfid_outmodel->getdata_pl();
        // $footer['fungsi'] = 'container';
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $data['filter_pl'] = $this->session->userdata('filter_pl') ?? 'all';
        $this->load->view('layouts/header', $header);
        $this->load->view('rfid_out/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function filter_data()
    {
        $filter_pl = $this->input->post('filter');

        $this->session->set_userdata('filter_pl', $filter_pl);

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $draw = $this->input->post('draw');
        $search = $this->input->post('search')['value'];

        $this->db->select('tb_balenumber.*, tb_packfin.nw');
        $this->db->from('tb_balenumber');
        $this->db->join(
            'tb_packfin',
            'tb_packfin.po = tb_balenumber.po 
             AND tb_packfin.item = tb_balenumber.item
             AND tb_packfin.nobale = tb_balenumber.nobale',
            'left'
        );


        if ($filter_pl !== 'all' && !empty($filter_pl)) {
            $this->db->where('tb_balenumber.plno', $filter_pl);
        }


        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.plno', $search);
            $this->db->or_like('tb_balenumber.po', $search);
            $this->db->group_end();
        }

        $this->db->order_by('tb_balenumber.id', 'ASC');
        $this->db->limit($limit, $start);
        $data = $this->db->get()->result_array();

        $no = $start + 1;
        foreach ($data as &$row) {
            $row['no'] = $no++;
            $row['plno'] = $row['plno'];
            $row['po'] = $row['po'];
            $row['item'] = $row['item'];
            $row['nobale'] = $row['nobale'];
            $row['berat'] = $row['nw'];
            $selesai = $row['selesai'];
            $status = '';

            if ($selesai == 0) {
                $status = '<div class="p-2 rounded" style="background:#fff3cd; border-left:4px solid #ffc107; font-size:12px;">
                <strong><i class="fa fa-spinner fa-spin"></i> Waiting..</strong><br>
              </div>';
            } else {
                $status = '<div class="p-2 rounded" style="background:#d4edda; border-left:4px solid #28a745; font-size:12px;">
                <strong><i class="fa fa-check-circle"></i> Selesai</strong><br>
                <span>Dicek Oleh: <b>' . ucwords(strtolower($row['user_ok'])) . '</b></span><br>
                <span>Pada Tgl: ' . format_tanggal_indonesia_waktu($row['waktu_ok']) . '</span>
              </div>';
            }

            $row['selesai'] = $status;

            $row['aksi'] = '';

            if ($selesai == 0) {
                $row['aksi'] =  '
                <a class="btn btn-sm btn-info btn-icon text-dark verifikasi"
                    data-id="' . $row['id'] . '"
                    data-url="' . base_url() . 'rfid_out/verifikasi/' . $row['id'] . '" href="#">
                    <i class="fa fa-check"></i>
                </a>';
            }
        }

        $this->db->select('tb_balenumber.*, tb_packfin.nw');
        $this->db->from('tb_balenumber');
        $this->db->join(
            'tb_packfin',
            'tb_packfin.po = tb_balenumber.po 
             AND tb_packfin.item = tb_balenumber.item
             AND tb_packfin.nobale = tb_balenumber.nobale',
            'left'
        );


        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.plno', $search);
            $this->db->or_like('tb_balenumber.po', $search);
            $this->db->group_end();
        }

        $recordsFiltered = $this->db->count_all_results();


        $this->db->from('tb_balenumber');
        $recordsTotal = $this->db->count_all_results();


        echo json_encode([
            'draw' => intval($draw),
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'data' => $data
        ]);
    }

    public function verifikasi($id)
    {
        $update = $this->Rfid_outmodel->verifikasi_data($id);
        if ($update) {
            $this->session->set_flashdata('success', 'Data berhasil diverifikasi!');
        } else {
            $this->session->set_flashdata('error', 'Gagal melakukan verifikasi data.');
        }
        redirect('rfid_out');
    }


    public function excel()
    {
        $filter_pl = $this->session->userdata('filter_pl') ?? 'all';
        $data = $this->Rfid_outmodel->getdata_ex($filter_pl);

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('RFID OUT');


        $sheet->setCellValue('A1', 'DATA RFID OUT');
        $sheet->mergeCells('A1:D1');

        $sheet->setCellValue('A2', 'Filter PLNO:');
        $sheet->setCellValue('B2', ($filter_pl == 'all') ? 'ALL' : $filter_pl);
        $sheet->mergeCells('B2:D2');


        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(14);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');


        $sheet->getStyle('A2')->getFont()->setBold(true);

        $headerRow = 4;

        $sheet->setCellValue('A' . $headerRow, 'No');
        $sheet->setCellValue('B' . $headerRow, 'PLNO');
        $sheet->setCellValue('C' . $headerRow, 'PO');
        $sheet->setCellValue('D' . $headerRow, 'ITEM');
        $sheet->setCellValue('E' . $headerRow, 'NO BALE');
        $sheet->setCellValue('F' . $headerRow, 'BERAT');
        $sheet->setCellValue('G' . $headerRow, 'STATUS');

        $sheet->getStyle("A{$headerRow}:G{$headerRow}")->getFont()->setBold(true);
        $sheet->getStyle("A{$headerRow}:G{$headerRow}")->getAlignment()->setHorizontal('center');


        $rowExcel = $headerRow + 1;
        $no = 1;

        foreach ($data as $row) {

            $status = ($row['selesai'] == 1) ? 'OK' : 'NG';
            $inputList = $row['po'] . '/' . $row['item'] . ' Bale ' . $row['nobale'];

            $sheet->setCellValue('A' . $rowExcel, $no++);
            $sheet->setCellValue('B' . $rowExcel, $row['plno']);
            $sheet->setCellValue('C' . $rowExcel, $row['po']);
            $sheet->setCellValue('D' . $rowExcel, $row['item']);
            $sheet->setCellValue('E' . $rowExcel, $row['nobale']);
            $sheet->setCellValue('F' . $rowExcel, $row['nw']);
            $sheet->setCellValue('G' . $rowExcel, $status);

            $rowExcel++;
        }


        foreach (range('A', 'G') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }


        $lastRow = $rowExcel - 1;
        $sheet->getStyle("A{$headerRow}:G{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


        $filename = "rfid_out_" . date('Ymd_His') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$filename\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }


    public function pdf()
    {
        $filter_pl = $this->session->userdata('filter_pl') ?? 'all';
        $data = $this->Rfid_outmodel->getdata_ex($filter_pl);

        $pdf = new FPDF('L', 'mm', 'A4');
        $pdf->AddPage();


        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'DATA RFID OUT', 0, 1, 'C');


        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(30, 7, 'Filter PLNO :', 0, 0, 'L');
        $pdf->Cell(0, 7, ($filter_pl == 'all') ? 'ALL' : $filter_pl, 0, 1, 'L');

        $pdf->Ln(3);


        $pdf->SetFont('Arial', 'B', 10);

        $pdf->Cell(12, 8, 'No', 1, 0, 'C');
        $pdf->Cell(35, 8, 'PLNO', 1, 0, 'C');
        $pdf->Cell(35, 8, 'PO', 1, 0, 'C');
        $pdf->Cell(35, 8, 'ITEM', 1, 0, 'C');
        $pdf->Cell(35, 8, 'NO BALE', 1, 0, 'C');
        $pdf->Cell(35, 8, 'BERAT', 1, 0, 'C');
        $pdf->Cell(55, 8, 'STATUS', 1, 1, 'C');


        $pdf->SetFont('Arial', '', 9);

        $no = 1;
        foreach ($data as $row) {

            $status = ($row['selesai'] == 1) ? 'OK' : 'NG';
            $inputList = $row['po'] . '/' . $row['item'] . ' Bale ' . $row['nobale'];

            $pdf->Cell(12, 7, $no++, 1, 0, 'C');
            $pdf->Cell(35, 7, $row['plno'], 1, 0, 'L');
            $pdf->Cell(35, 7, $row['po'], 1, 0, 'L');
            $pdf->Cell(35, 7, $row['item'], 1, 0, 'L');
            $pdf->Cell(35, 7, $row['nobale'], 1, 0, 'L');
            $pdf->Cell(35, 7, $row['nw'], 1, 0, 'L');
            $pdf->Cell(55, 7, $status, 1, 1, 'C');
        }


        $filename = "rfid_out_" . date('Ymd_His') . ".pdf";
        $pdf->Output('I', $filename);
    }
}
