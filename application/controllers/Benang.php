<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Benang extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('Benangmodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('helper_model', 'helpermodel');


        $this->load->library('Pdf');
        // $this->load->library('Codeqr');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }

    public function index()
    {
        $header['header'] = 'master';
        $data['benang'] = $this->Benangmodel->getdata();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/index', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function tambahdata()
    {
        $this->load->view('benang/add');
    }

    public function simpandata()
    {
        $query = $this->Benangmodel->simpan();
        if ($query) {
            $this->session->set_flashdata('message', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Event Berhasil Di Tambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        $this->helpermodel->isilog($this->db->last_query());
        redirect('benang');
    }

    public function tambah_spek($id)
    {
        $data['id_header'] = $id;
        $data['satuan'] =  $this->db->get('satuan')->result_array();
        $this->load->view('benang/add_spek', $data);
    }
    public function spek_ukuran()
    {
        $inputan = $this->input->get('term');
        $result = $this->Benangmodel->getUkuranLike($inputan);
        echo json_encode($result);
    }
    public function spek_warna()
    {
        $warna = $this->input->get('warna');
        $result = $this->Benangmodel->getWarnaLike($warna);
        echo json_encode($result);
    }
    public function simpandata_spek()
    {
        $query = $this->Benangmodel->simpan_spek();
        if ($query) {
            $this->session->set_flashdata('message', '
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    Event Berhasil Di Tambahkan!
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            ');
        }
        $this->helpermodel->isilog($this->db->last_query());
        redirect('benang');
    }
    public function get_detail($id)
    {
        $detail = $this->Benangmodel->getdataByid_all($id);
        echo json_encode($detail);
    }

    public function get_detail_warna($warna)
    {
        $detail = $this->Benangmodel->GetDetailWarna($warna);
        echo json_encode($detail);
    }

    public function detail_warna($warna)
    {
        $header['header'] = 'master';
        $data['warna'] = $warna;
        $data['detail_warna'] = $this->Benangmodel->GetDetailWarna($warna);
        $data['nomordok'] = $this->Benangmodel->GetNomorDok($warna);
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/detail_warna', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function saldo_masuk($id, $id_barang,)
    {
        $header['header'] = 'master';
        $data['judul'] = 'PERIODE SALDO MASUK';
        $data['tb_detail_id'] = $id;
        $data['id_barang'] = $id_barang;
        $data['header'] = $this->Benangmodel->GetHeader_Saldo($id);
        $data['masuk'] = $this->Benangmodel->GetSaldo_masuk($id) ?? [];

        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/saldo_masuk', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function saldo_keluar($id, $id_barang,)
    {
        $header['header'] = 'master';
        $data['judul'] = 'PERIODE SALDO KELUAR';
        $data['header'] = $this->Benangmodel->GetHeader_Saldo($id);
        $data['tb_detail_id'] = $id;
        $data['id_barang'] = $id_barang;
        $data['keluar'] = $this->Benangmodel->GetSaldo_keluar($id) ?? [];

        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/saldo_keluar', $data);
        $this->load->view('layouts/footer', $footer);
    }

    public function view_saldo_masuk($bulan_tahun, $tb_detail_id, $id_barang)
    {
        $data['title'] = 'Saldo Masuk';
        $data['periode'] = $bulan_tahun;
        $data['tb_detail_id'] = $tb_detail_id;
        $data['id_barang'] = $id_barang;
        $data['saldo_masuk'] = $this->Benangmodel->GetViewsaldo($bulan_tahun, $tb_detail_id);
        $data['header'] = $this->Benangmodel->GetHeaderView($tb_detail_id);
        $this->load->view('benang/view_saldo_masuk', $data);
    }
    public function logbook($bulan_tahun, $tb_detail_id, $id_barang)
    {
        $data['title'] = 'View Data Logbook Saldo IN & OUT';
        $data['periode'] = $bulan_tahun;
        $data['id_barang'] = $id_barang;
        $data['saldo'] = $this->Benangmodel->Logbook($bulan_tahun, $id_barang);
        $data['header'] = $this->Benangmodel->GetHeaderView($tb_detail_id);
        $data['bulan_tahun'] = $bulan_tahun;
        $this->load->view('benang/logbook', $data);
    }

    public function view_saldo_keluar($bulan_tahun, $tb_detail_id, $id_barang)
    {
        $data['title'] = 'Saldo Keluar';
        $data['periode'] = $bulan_tahun;
        $data['tb_detail_id'] = $tb_detail_id;
        $data['id_barang'] = $id_barang;
        $data['saldo_keluar'] = $this->Benangmodel->GetViewsaldo_keluar($bulan_tahun, $tb_detail_id);
        $data['header'] = $this->Benangmodel->GetHeaderView($tb_detail_id);
        $this->load->view('benang/view_saldo_keluar', $data);
    }

    public function tambahsaldo($tb_detail_id, $id_barang)
    {
        $data['tb_detail_id'] = $tb_detail_id;
        $data['id_barang'] = $id_barang;
        $data['tgl_sekarang'] = date('Y-m-d');
        $data['jam_sekarang'] = date('H:i:s');
        $this->load->view('benang/add_saldo', $data);
    }
    public function tambahsaldo_keluar($tb_detail_id, $id_barang)
    {
        $data['tb_detail_id'] = $tb_detail_id;
        $data['id_barang'] = $id_barang;
        $data['tgl_sekarang'] = date('Y-m-d');
        $data['jam_sekarang'] = date('H:i:s');
        $this->load->view('benang/add_saldo_keluar', $data);
    }

    public function simpansaldo($tb_detail_id, $id_barang)
    {
        $tanggal = $this->input->post('tanggal');
        $jam = $this->input->post('jam');
        $tb_detail_id = $this->input->post('tb_detail_id');
        $id_barang = (int) $this->input->post('id_barang');
        $jumlah = (int) $this->input->post('jumlah');
        $keterangan = $this->input->post('keterangan');

        $data = [
            'tanggal' => $tanggal,
            'jam' => $jam,
            'tb_detail_id' => $tb_detail_id,
            'id_barang' => $id_barang,
            'jumlah' => $jumlah,
            'keterangan' => $keterangan
        ];

        $hasil = $this->db->insert('benang_in_mutasi', $data);

        if ($hasil) {
            $this->Benangmodel->InSaldo($tanggal, $jumlah, $id_barang);
            $url = base_url('benang/saldo_masuk/' . $tb_detail_id . '/' . $id_barang);
            redirect($url);
        }
    }
    // public function simpansaldo_keluar($tb_detail_id, $id_barang)
    // {
    //     $tanggal = $this->input->post('tanggal');
    //     $jam = $this->input->post('jam');
    //     $tb_detail_id = $this->input->post('tb_detail_id');
    //     $id_barang = (int) $this->input->post('id_barang');
    //     $jumlah = (int) $this->input->post('jumlah');
    //     $keterangan = $this->input->post('keterangan');

    //     $bulan = date('m', strtotime($tanggal));
    //     $tahun = date('Y', strtotime($tanggal));
    //     $periode = $bulan . $tahun;
    //     $this->db->select('kgs_akhir');
    //     $this->db->from('stokdept');
    //     $this->db->where('periode', $periode);
    //     $this->db->where('id_barang', $id_barang);
    //     $cek_saldo_sekarang = $this->db->get()->row_array();

    //     if ($cek_saldo_sekarang['kgs_akhir'] <= $jumlah) {
    //         $this->session->set_flashdata('message', '
    //         <div class="alert alert-warning alert-dismissible fade show" role="alert">
    //             Saldo Tersedia Tidak Cukup !
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>');
    //         $url = base_url('benang/saldo_keluar/' . $tb_detail_id . '/' . $id_barang);
    //         redirect($url);
    //     }

    //     $periode_sebelumnya = date('mY', strtotime("-1 month", strtotime($tanggal)));
    //     $this->db->select('kgs_akhir');
    //     $this->db->from('stokdept');
    //     $this->db->where('periode', $periode_sebelumnya);
    //     $this->db->where('id_barang', $id_barang);
    //     $cek_saldo_sekarang = $this->db->get()->row_array();

    //     if ($cek_saldo_sekarang['kgs_akhir'] <= $jumlah) {
    //         $this->session->set_flashdata('message', '
    //         <div class="alert alert-warning alert-dismissible fade show" role="alert">
    //             Saldo Tersedia Tidak Cukup !
    //             <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    //         </div>');
    //         $url = base_url('benang/saldo_keluar/' . $tb_detail_id . '/' . $id_barang);
    //         redirect($url);
    //     }

    //     $data = [
    //         'tanggal' => $tanggal,
    //         'jam' => $jam,
    //         'tb_detail_id' => $tb_detail_id,
    //         'id_barang' => $id_barang,
    //         'jumlah' => $jumlah,
    //         'keterangan' => $keterangan
    //     ];

    //     $hasil = $this->db->insert('benang_out_mutasi', $data);

    //     if ($hasil) {
    //         $this->Benangmodel->OutSaldo($tanggal, $jumlah, $id_barang);
    //         $url = base_url('benang/saldo_keluar/' . $tb_detail_id . '/' . $id_barang);
    //         redirect($url);
    //     }
    // }

    public function simpansaldo_keluar($tb_detail_id, $id_barang)
    {
        $tanggal = $this->input->post('tanggal');
        $jam = $this->input->post('jam');
        $tb_detail_id = $this->input->post('tb_detail_id');
        $id_barang = (int) $this->input->post('id_barang');
        $jumlah = (int) $this->input->post('jumlah');
        $keterangan = $this->input->post('keterangan');

        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = $bulan . $tahun;

        // Saldo bulan sekarang
        $this->db->select('kgs_akhir');
        $this->db->from('stokdept');
        $this->db->where('periode', $periode);
        $this->db->where('id_barang', $id_barang);
        $cek_saldo_sekarang = $this->db->get()->row_array();

        // Kalau bulan ini belum ada saldo, cek saldo akhir bulan sebelumnya
        if (empty($cek_saldo_sekarang)) {
            $periode_sebelumnya = date('mY', strtotime("-1 month", strtotime($tanggal)));
            $this->db->select('kgs_akhir');
            $this->db->from('stokdept');
            $this->db->where('periode', $periode_sebelumnya);
            $this->db->where('id_barang', $id_barang);
            $cek_saldo_sekarang = $this->db->get()->row_array();
        }

        // Kalau setelah dicek tetap tidak ada saldo, berarti stok kosong
        if (empty($cek_saldo_sekarang) || $cek_saldo_sekarang['kgs_akhir'] < $jumlah) {
            $this->session->set_flashdata('message', '
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            Saldo Tersedia Tidak Cukup !
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>');
            redirect(base_url('benang/saldo_keluar/' . $tb_detail_id . '/' . $id_barang));
            return;
        }

        // Simpan data
        $data = [
            'tanggal' => $tanggal,
            'jam' => $jam,
            'tb_detail_id' => $tb_detail_id,
            'id_barang' => $id_barang,
            'jumlah' => $jumlah,
            'keterangan' => $keterangan
        ];

        $hasil = $this->db->insert('benang_out_mutasi', $data);

        if ($hasil) {
            $this->Benangmodel->OutSaldo($tanggal, $jumlah, $id_barang);
        }

        redirect(base_url('benang/saldo_keluar/' . $tb_detail_id . '/' . $id_barang));
    }


    public function hapus_saldo_masuk($id, $tanggal, $jumlah, $tb_detail_id, $id_barang)
    {
        $hasil = $this->Benangmodel->hapus_histori_salmas($id);
        if ($hasil) {
            $this->Benangmodel->hapusSaldo_masuk($tanggal, $jumlah, $id_barang);
            redirect('benang/saldo_masuk/' . $tb_detail_id . '/' . $id_barang);
        }
    }

    public function hapus_saldo_keluar($id, $tanggal, $jumlah, $tb_detail_id, $id_barang)
    {
        $hasil = $this->Benangmodel->hapus_histori_salkel($id);
        if ($hasil) {
            $this->Benangmodel->hapusSaldo_keluar($tanggal, $jumlah, $id_barang);
            redirect('benang/saldo_keluar/' . $tb_detail_id . '/' . $id_barang);
        }
    }

    public function hapus_spek($id)
    {
        $hasil = $this->Benangmodel->hapus_spek($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('benang');
            redirect($url);
        }
    }
    public function hapus($id)
    {
        $hasil = $this->Benangmodel->hapus($id);
        if ($hasil) {
            $this->helpermodel->isilog($this->db->last_query());
            $url = base_url('benang');
            redirect($url);
        }
    }

    public function saldo_detail($id_header, $warna_benang)
    {
        $header['header'] = 'master';
        $data['title'] = 'Stok Benang Per Bulan';
        $data['header'] = $this->Benangmodel->GetHeaderView_saldo($id_header);
        $data['id_header'] = $id_header;
        $data['warna_benang'] = $warna_benang;
        $data['bln_sekarang'] = date('m');
        $data['thn_sekarang'] = date('Y');
        $data['bulan_options'] = $this->Benangmodel->getBulan();
        $data['tahun_options'] = $this->Benangmodel->getTahun();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $this->load->view('layouts/header', $header);
        $this->load->view('benang/saldo_warna', $data);
        $this->load->view('layouts/footer', $footer);
    }


    public function filter_saldo()
    {
        $id_header     = $this->input->post('id_header');
        $warna_benang  = $this->input->post('warna_benang');
        $bulan         = $this->input->post('bulan');
        $tahun         = $this->input->post('tahun');

        $this->db->select('
        tb_detail.warna_benang, 
        tb_detail.id_header, 
        stokdept.kgs_akhir,
        stokdept.id_barang, 
        stokdept.periode, 
        barang.nama_barang
    ');
        $this->db->from('tb_detail');
        $this->db->join('stokdept', 'stokdept.id_barang = tb_detail.id_barang', 'left');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'barang.id = stokdept.id_barang', 'left');

        if (!empty($id_header)) {
            $this->db->where('tb_header.id', $id_header);
        }
        if (!empty($warna_benang)) {
            $this->db->where('tb_detail.warna_benang', $warna_benang);
        }
        if (!empty($bulan)) {
            $this->db->where("LEFT(stokdept.periode, 2) =", $bulan, FALSE);
        }
        if (!empty($tahun)) {
            $this->db->where("RIGHT(stokdept.periode, 4) =", $tahun, FALSE);
        }


        $this->db->order_by('tb_detail.warna_benang', 'ASC');
        $data = $this->db->get()->result_array();


        $html = '';
        $no = 1;
        $total = 0;

        if (!empty($data)) {
            foreach ($data as $row) {
                $total += $row['kgs_akhir'];
                $html .= '<tr>';
                $html .= '<td>' . $no++ . '</td>';
                $html .= '<td>' . $row['warna_benang'] . '</td>';
                $html .= '<td>' . $row['nama_barang'] . '</td>';
                $html .= '<td>' . number_format($row['kgs_akhir'], 2) . '</td>';
                $html .= '<td>' . format_bulan_tahun($row['periode']) . '</td>';
                $html .= '</tr>';
            }


            $html .= '<tr style="background-color: #f0f0f0; font-weight: bold;">';
            $html .= "<td colspan='3' class='text-center'>Total</td>";
            $html .= "<td>" . number_format($total, 2) . "</td>";
            $html .= "<td></td>";
            $html .= '</tr>';
        } else {
            $html .= '<tr><td colspan="5" class="text-center">Tidak ada data</td></tr>';
        }


        echo $html;
    }




    // public function excel()
    // {
    //     $spreadsheet = new Spreadsheet();
    //     $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    

    //     $sheet->setCellValue('A1', "DATA AGAMA"); // Set kolom A1 dengan tulisan "DATA SISWA"    
    //     $sheet->getStyle('A1')->getFont()->setBold(true); // Set bold kolom A1    

    //     // Buat header tabel nya pada baris ke 3    
    //     $sheet->setCellValue('A2', "NO"); // Set kolom A3 dengan tulisan "NO"    
    //     $sheet->setCellValue('B2', "NAMA AGAMA"); // Set kolom B3 dengan tulisan "KODE"    
    //     // Panggil model Get Data   
    //     $agama = $this->Agamamodel->getdata();
    //     $no = 1;

    //     // Untuk penomoran tabel, di awal set dengan 1    
    //     $numrow = 3;

    //     // Set baris pertama untuk isi tabel adalah baris ke 3    
    //     foreach ($agama as $data) {
    //         // Lakukan looping pada variabel      
    //         $sheet->setCellValue('A' . $numrow, $no);
    //         $sheet->setCellValue('B' . $numrow, $data['nama_agama']);
    //         $no++;
    //         // Tambah 1 setiap kali looping      
    //         $numrow++; // Tambah 1 setiap kali looping    
    //     }


    //     // Set height semua kolom menjadi auto (mengikuti height isi dari kolommnya, jadi otomatis)    
    //     $sheet->getDefaultRowDimension()->setRowHeight(-1);
    //     // Set orientasi kertas jadi LANDSCAPE    
    //     $sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_LANDSCAPE);
    //     // Set judul file excel nya    
    //     $sheet->setTitle("Data Agama");

    //     // Proses file excel    
    //     header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    //     header('Content-Disposition: attachment; filename="Data Agama.xlsx"'); // Set nama file excel nya    
    //     header('Cache-Control: max-age=0');
    //     $writer = new Xlsx($spreadsheet);
    //     $writer->save('php://output');
    //     $this->helpermodel->isilog('Download Excel DATA AGAMA ');
    // }
    // public function cetakpdf()
    // {
    //     $pdf = new PDF('P', 'mm', 'A4');
    //     $pdf->AliasNbPages();
    //     // $pdf->setMargins(5,5,5);
    //     $pdf->AddFont('Lato', '', 'Lato-Regular.php');
    //     $pdf->AddFont('Latob', '', 'Lato-Bold.php');
    //     $pdf->SetFillColor(7, 178, 251);
    //     $pdf->SetFont('Latob', '', 12);
    //     // $isi = $this->jualmodel->getrekap();
    //     $pdf->SetFillColor(205, 205, 205);
    //     $pdf->AddPage();
    //     $pdf->Image(base_url() . 'assets/image/logodepanK.png', 0, 5, 55);
    //     $pdf->Cell(30, 18, 'DATA AGAMA');
    //     $pdf->ln(12);
    //     $pdf->SetFont('Latob', '', 10);
    //     $pdf->Cell(15, 8, 'No', 1, 0, 'C');
    //     $pdf->Cell(105, 8, 'Nama Agama', 1, 0, 'C');

    //     $pdf->SetFont('Lato', '', 10);
    //     $pdf->ln(8);
    //     $detail = $this->Agamamodel->getdata();
    //     $no = 1;
    //     foreach ($detail as $det) {
    //         $pdf->Cell(15, 6, $no++, 1, 0, 'C');
    //         $pdf->Cell(105, 6, $det['nama_agama'], 1);

    //         $pdf->ln(6);
    //     }
    //     $pdf->SetFont('Lato', '', 8);
    //     $pdf->ln(10);
    //     $pdf->Cell(190, 6, 'Tgl Cetak : ' . date('d-m-Y H:i:s') . ' oleh ' . datauser($this->session->userdata('id'), 'name'), 0, 0, 'R');
    //     $pdf->Output('I', 'Data Agama.pdf');
    //     $this->helpermodel->isilog('Download PDF DATA AGAMA');
    // }
}
