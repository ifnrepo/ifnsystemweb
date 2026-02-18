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


        $this->db->select('tb_balenumber.*, tb_packfin.nw, tb_packfin.pcs, tb_packfin.meas , tb_po.spek');
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

        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
        }




        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.nobale', $search);
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
            $row['spek'] = "
                      
                        <span>{$row['spek']}</span>";

            $row['pcs']   =  number_format((float)$row['pcs'], 0);
            $row['item'] = $row['item'];
            $row['nobale'] = $row['nobale'];
            $row['berat'] = number_format((float)$row['nw'], 2);
            $row['meas'] = $row['meas'];
            $cek_masuk = $row['masuk'];

            if (empty($cek_masuk)) {
                $row['masuk'] = '
                <a href="' . base_url('rfid_out/verifikasi/' . $row['id']) . '" style="text-decoration:none; display:block; color:black;">
                    <div class="p-2 rounded" style="background:#f8d7da; border-left:4px solid #dc3545; font-size:12px;">
                        <strong><i class="fa fa-spinner fa-spin"></i> Waiting..</strong><br>
                    </div>
                </a>
                ';
            } else {
                if ($this->session->userdata('cekbatalstok') == '1') {
                    $row['masuk'] = '
                    <a href="' . base_url('rfid_out/verifikasi_batal/' . $row['id']) . '" style="text-decoration:none; display:block; color:black;">
                        <div class="p-2 rounded" style="background:#fff3cd; border-left:4px solid #ffc107; font-size:10px;">
                            <strong "><i class="fa fa-check-circle"></i>Verified ' . ucwords(strtolower($row['user_ok'])) . '</b></strong><br>
                            <span style ="font-size:8px;">' . format_tanggal_indonesia_waktu($row['waktu_ok']) . '</span>
                        </div> 
                    </a>';
                } else {
                    $row['masuk'] = '
                    <div class="p-2 rounded" style="background:#fff3cd; border-left:4px solid #ffc107; font-size:10px;">
                        <strong "><i class="fa fa-check-circle"></i>Verified ' . ucwords(strtolower($row['user_ok'])) . '</b></strong><br>
                        <span style ="font-size:8px;">' . format_tanggal_indonesia_waktu($row['waktu_ok']) . '</span>
                    </div>
                   
                ';
                }
            }

            $cek_selesai = $row['selesai'];

            if ($cek_masuk == 1) {
                if ($cek_selesai == 0) {
                    $row['selesai'] = ' 
                    <a href="' . base_url('rfid_out/verifikasi_selesai/' . $row['id']) . '" style="text-decoration:none; display:block; color:black;">
                        <div class="p-2 rounded" style="background:#fff3cd; border-left:4px solid #ffc107; font-size:12px;">
                            <strong><i class="fa fa-spinner fa-spin"></i> Waiting..</strong><br>
                        </div>
                     </a>
                   ';
                } else {
                    if ($this->session->userdata('cekbatalstok') == '1') {
                        $row['selesai'] = '
                        <a href="' . base_url('rfid_out/verifikasi_selesaiopen/' . $row['id']) . '" style="text-decoration:none; display:block; color:black;">
                            <div class="p-2 rounded" style="background:#d4edda; border-left:4px solid #28a745; font-size:12px;">
                                <strong><i class="fa fa-check-circle"></i> Complete</strong><br>
                            </div>
                        </a>
                    ';
                    } else {
                        $row['selesai'] = '
                        <div class="p-2 rounded" style="background:#d4edda; border-left:4px solid #28a745; font-size:12px;">
                            <strong><i class="fa fa-check-circle"></i> Complete</strong><br>
                        </div>
                         ';
                    }
                }
            } else {

                $row['selesai'] = '-';
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
        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
        }


        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.nobale', $search);
            $this->db->or_like('tb_balenumber.po', $search);
            $this->db->group_end();
        }

        $recordsFiltered = $this->db->count_all_results();



        $this->db->from('tb_balenumber');
        $recordsTotal = $this->db->count_all_results();

        // sum nw

        $this->db->select('SUM(tb_packfin.nw) as total_nw');
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

        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.nobale', $search);
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

        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
        }

        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.nobale', $search);
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
        if ($filter_selesai != 'all') {
            $this->db->where('tb_balenumber.selesai', $filter_selesai);
        }


        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('tb_balenumber.nobale', $search);
            $this->db->or_like('tb_balenumber.po', $search);
            $this->db->group_end();
        }

        $total_meas = $this->db->get()->row()->total_meas;
        $total_meas = $total_meas ? $total_meas : 0;



        echo json_encode([
            'draw'            => intval($draw),
            'recordsTotal'    => $recordsTotal,
            'recordsFiltered' =>  $recordsFiltered,
            'total_nw'        =>  number_format((float)$total_nw, 2),
            'total_pcs' => number_format((float)$total_pcs, 0, '', ''),
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
    public function verifikasi_batal($id)
    {
        $update = $this->Rfid_outmodel->verifikasi_batal($id);
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
    public function verifikasi_selesaiopen($id)
    {
        $update = $this->Rfid_outmodel->verifikasi_selesaiopen($id);
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
        $filter_exdo = $this->session->userdata('filter_exdo') ?? 'all';
        $filter_cekmasuk = $this->session->userdata('filter_cekmasuk') ?? 'all';
        $filter_selesai = $this->session->userdata('filter_selesai') ?? 'all';

        $data = $this->Rfid_outmodel->getdata_ex($filter_pl, $filter_exdo, $filter_cekmasuk, $filter_selesai);

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle("RFID OUT");

        $sheet->setCellValue('A1', 'LIST NUMBER of BALE');
        $sheet->mergeCells('A1:I1');

        $sheet->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->getStyle('A1')->getAlignment()->setHorizontal('center');


        $sheet->setCellValue('B3', 'Filter PLNO :');
        $sheet->setCellValue('C3', ($filter_pl == 'all') ? 'ALL' : $filter_pl);


        $rowStart = 5;

        $sheet->setCellValue('B' . $rowStart, 'No');
        $sheet->setCellValue('C' . $rowStart, 'PLNO');
        $sheet->setCellValue('D' . $rowStart, 'PO');
        $sheet->setCellValue('E' . $rowStart, 'SPEK');
        $sheet->setCellValue('F' . $rowStart, 'PCS');
        $sheet->setCellValue('G' . $rowStart, 'ITEM');
        $sheet->setCellValue('H' . $rowStart, 'BALE');
        $sheet->setCellValue('I' . $rowStart, 'BERAT');
        $sheet->setCellValue('J' . $rowStart, 'MEAS');


        $sheet->getStyle("B{$rowStart}:J{$rowStart}")->getFont()->setBold(true);
        $sheet->getStyle("B{$rowStart}:J{$rowStart}")->getAlignment()->setHorizontal('center');

        $no = 1;
        $rowExcel = $rowStart + 1;

        foreach ($data as $row) {
            $sheet->setCellValue('B' . $rowExcel, $no++);
            $sheet->setCellValue('C' . $rowExcel, $row['plno']);
            $sheet->setCellValue('D' . $rowExcel, $row['po']);
            $sheet->setCellValue('E' . $rowExcel, $row['spek']);
            $sheet->setCellValue('F' . $rowExcel, (int)$row['pcs']);
            $sheet->setCellValue('G' . $rowExcel, $row['item']);
            $sheet->setCellValue('H' . $rowExcel, $row['nobale']);
            $sheet->setCellValue('I' . $rowExcel, (float)$row['nw']);
            $sheet->setCellValue('J' . $rowExcel, $row['meas']);

            $rowExcel++;
        }


        foreach (range('B', 'J') as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }


        $lastRow = $rowExcel - 1;
        $sheet->getStyle("B{$rowStart}:J{$lastRow}")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);


        $sheet->getStyle("H" . ($rowStart + 1) . ":H{$lastRow}")
            ->getNumberFormat()
            ->setFormatCode('#,##0.00');


        $filename = "rfid_out_" . date('Ymd_His') . ".xlsx";

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment;filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }



    public function pdf()
    {
        $filter_pl = $this->session->userdata('filter_pl') ?? 'all';
        $filter_exdo = $this->session->userdata('filter_exdo') ?? 'all';
        $filter_cekmasuk = $this->session->userdata('filter_cekmasuk') ?? 'all';
        $filter_selesai = $this->session->userdata('filter_selesai') ?? 'all';
        $data = $this->Rfid_outmodel->getdata_ex($filter_pl, $filter_exdo, $filter_cekmasuk, $filter_selesai);


        $pdf = new PDF_CONTAINER('L', 'mm', 'A4');
        $pdf->filter_pl = $filter_pl;

        $pdf->SetAutoPageBreak(true, 15);
        $pdf->AddPage();


        $pdf->SetFont('Arial', '', 9);
        $no = 1;
        foreach ($data as $row) {
            $pdf->Cell(12, 7, $no++, 1, 0, 'C');
            $pdf->Cell(35, 7, $row['plno'], 1, 0, 'L');
            $pdf->Cell(35, 7, $row['po'], 1, 0, 'L');
            $pdf->Cell(80, 7, $row['spek'], 1, 0, 'L');
            $pdf->Cell(15, 7, number_format((float)$row['pcs'], 0), 1, 0, 'C');
            $pdf->Cell(15, 7, $row['item'], 1, 0, 'C');
            $pdf->Cell(25, 7, $row['nobale'], 1, 0, 'C');
            $pdf->Cell(25, 7, number_format((float)$row['nw'], 2), 1, 0, 'R');
            $pdf->Cell(33, 7, $row['meas'], 1, 1, 'C');
        }

        $filename = "LIST NUMBER of BALE" . ".pdf";
        $pdf->Output('I', $filename);
    }
}
