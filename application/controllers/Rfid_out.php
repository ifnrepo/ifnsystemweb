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
        $data['filter_exdo'] = $this->session->userdata('filter_exdo') ?? 'all';
        $data['filter_cekmasuk'] = $this->session->userdata('filter_cekmasuk') ?? 'all';
        $data['filter_selesai'] = $this->session->userdata('filter_selesai') ?? 'all';
        $this->load->view('layouts/header', $header);
        $this->load->view('rfid_out/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function filter_data()
    {
        $filter_pl = $this->input->post('filter');
        $filter_exdo = $this->input->post('filter_exdo');
        $filter_cekmasuk = $this->input->post('filter_cekmasuk');
        $filter_selesai = $this->input->post('filter_selesai');

        $this->session->set_userdata('filter_pl', $filter_pl);
        $this->session->set_userdata('filter_exdo', $filter_exdo);
        $this->session->set_userdata('filter_cekmasuk', $filter_cekmasuk);
        $this->session->set_userdata('filter_selesai', $filter_selesai);

        $limit  = $this->input->post('length');
        $start  = $this->input->post('start');
        $draw   = $this->input->post('draw');
        $search = $this->input->post('search')['value'];


        $this->db->select('tb_balenumber.*, tb_packfin.gw as nw , tb_packfin.pcs, tb_packfin.meas , tb_po.spek');
        $this->db->from('tb_balenumber');

        $this->db->join(
            'tb_packfin',
            'tb_packfin.po = tb_balenumber.po 
         AND tb_packfin.item = tb_balenumber.item
         AND tb_packfin.nobale = tb_balenumber.nobale',
            'left'
        );

        $this->db->join(
            'tb_po',
            'tb_po.po = tb_balenumber.po AND tb_po.item = tb_balenumber.item',
            'left'
        );



        if ($filter_pl !== 'all' && !empty($filter_pl)) {
            $this->db->where('tb_balenumber.plno', $filter_pl);
        }
        if ($filter_exdo !== 'all' && !empty($filter_exdo)) {
            $this->db->where('tb_balenumber.exdo', $filter_exdo);
        }
        if ($filter_cekmasuk !== 'all' && !empty($filter_cekmasuk)) {
            $this->db->where('tb_balenumber.masuk', $filter_cekmasuk);
        }
        // if ($filter_selesai !== 'all' && $filter_selesai !== null && $filter_selesai !== '') {
        //     $this->db->where('tb_balenumber.selesai', $filter_selesai);
        // }
        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
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
            $row['spek'] = "<span style='color:red; font-size:10px;'>{$row['exdo']}</span>
                        <br>
                        <span>{$row['spek']}</span>";

            $row['pcs']   =  number_format((float)$row['pcs'], 2);
            $row['item'] = $row['item'];
            $row['nobale'] = $row['nobale'];
            $row['berat'] = number_format((float)$row['nw'], 2);
            $row['meas'] = $row['meas'];
            $cek_masuk = $row['masuk'];

            if (empty($cek_masuk)) {
                $row['masuk'] = '
                <div class="p-2 rounded" style="background:#f8d7da; border-left:4px solid #dc3545; font-size:12px;">
                    <strong><i class="fa fa-spinner fa-spin"></i> Verify..</strong><br>
                </div>
            ';
            } else {
                $row['masuk'] = '
                <div class="p-2 rounded" style="background:#fff3cd; border-left:4px solid #ffc107; font-size:10px;">
                    <strong "><i class="fa fa-check-circle"></i>Noted ' . ucwords(strtolower($row['user_ok'])) . '</b></strong><br>
                    <span style ="font-size:8px;">' . format_tanggal_indonesia_waktu($row['waktu_ok']) . '</span>
                </div>
            ';
            }

            $cek_selesai = $row['selesai'];

            if ($cek_masuk == 1) {
                if ($cek_selesai == 0) {
                    $row['selesai'] = '
                <div class="p-2 rounded" style="background:#fff3cd; border-left:4px solid #ffc107; font-size:12px;">
                    <strong><i class="fa fa-spinner fa-spin"></i> Waiting..</strong><br>
                </div>
            ';
                } else {
                    $row['selesai'] = '
                <div class="p-2 rounded" style="background:#d4edda; border-left:4px solid #28a745; font-size:12px;">
                    <strong><i class="fa fa-check-circle"></i> Complite</strong><br>
                </div>
            ';
                }
            } else {

                $row['selesai'] = '-';
            }

            $row['aksi'] = '';
            if (empty($cek_masuk)) {
                $row['aksi'] = '
                <a class="btn btn-sm btn-yellow btn-icon text-dark"
                href="' . base_url('rfid_out/verifikasi/' . $row['id']) . '">
                <i class="fa fa-check"></i>
                 </a>
            ';
            }


            if ($cek_masuk == 1  && $cek_selesai == 0) {
                $row['aksi'] = '
                <a class="btn btn-sm btn-success btn-icon text-dark"
                href="' . base_url('rfid_out/verifikasi_selesai/' . $row['id']) . '">
                <i class="fa fa-check"></i>  <i class="fa fa-check"></i>
                 </a>
            ';
            }
        }


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

        if ($filter_exdo !== 'all' && !empty($filter_exdo)) {
            $this->db->where('tb_balenumber.exdo', $filter_exdo);
        }
        if ($filter_cekmasuk !== 'all' && !empty($filter_cekmasuk)) {
            $this->db->where('tb_balenumber.masuk', $filter_cekmasuk);
        }
        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
        }


        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.plno', $search);
            $this->db->or_like('tb_balenumber.po', $search);
            $this->db->group_end();
        }

        $recordsFiltered = $this->db->count_all_results();



        $this->db->from('tb_balenumber');
        $recordsTotal = $this->db->count_all_results();

        // sum nw

        $this->db->select('SUM(tb_packfin.gw) as total_nw');
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

        if ($filter_exdo !== 'all' && !empty($filter_exdo)) {
            $this->db->where('tb_balenumber.exdo', $filter_exdo);
        }
        if ($filter_cekmasuk !== 'all' && !empty($filter_cekmasuk)) {
            $this->db->where('tb_balenumber.masuk', $filter_cekmasuk);
        }

        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.plno', $search);
            $this->db->or_like('tb_balenumber.po', $search);
            $this->db->group_end();
        }

        $total_nw = $this->db->get()->row()->total_nw;
        $total_nw = $total_nw ? $total_nw : 0;

        // SUM PCS
        $this->db->select('SUM(tb_packfin.pcs) as total_pcs');
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

        if ($filter_exdo !== 'all' && !empty($filter_exdo)) {
            $this->db->where('tb_balenumber.exdo', $filter_exdo);
        }
        if ($filter_cekmasuk !== 'all' && !empty($filter_cekmasuk)) {
            $this->db->where('tb_balenumber.masuk', $filter_cekmasuk);
        }

        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.plno', $search);
            $this->db->or_like('tb_balenumber.po', $search);
            $this->db->group_end();
        }

        $total_pcs = $this->db->get()->row()->total_pcs;
        $total_pcs = $total_pcs ? $total_pcs : 0;

        // SUM MEAS
        $this->db->select('SUM(tb_packfin.meas) as total_meas');
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

        if ($filter_exdo !== 'all' && !empty($filter_exdo)) {
            $this->db->where('tb_balenumber.exdo', $filter_exdo);
        }
        if ($filter_cekmasuk !== 'all' && !empty($filter_cekmasuk)) {
            $this->db->where('tb_balenumber.masuk', $filter_cekmasuk);
        }
        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
        }


        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.plno', $search);
            $this->db->or_like('tb_balenumber.po', $search);
            $this->db->group_end();
        }

        $total_meas = $this->db->get()->row()->total_meas;
        $total_meas = $total_meas ? $total_meas : 0;



        echo json_encode([
            'draw'            => intval($draw),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' => $recordsFiltered,
            'total_nw'        =>  number_format((float)$total_nw, 2),
            'total_pcs'        =>  number_format((float)$total_pcs, 2),
            'total_meas'        =>  $total_meas,
            'data'            => $data
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
    public function verifikasi_selesai($id)
    {
        $update = $this->Rfid_outmodel->verifikasi_selesai($id);
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
