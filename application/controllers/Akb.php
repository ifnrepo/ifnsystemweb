<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
// use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class Akb extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        if ($this->session->userdata('getinifn') != true) {
            $url = base_url('Auth');
            redirect($url);
        }
        $this->load->model('pb_model');
        $this->load->model('akb_model', 'akbmodel');
        $this->load->model('barangmodel');
        $this->load->model('dept_model', 'deptmodel');
        $this->load->model('satuanmodel');
        $this->load->model('supplier_model', 'suppliermodel');
        $this->load->model('userappsmodel', 'usermodel');
        $this->load->model('mtuangmodel');
        $this->load->model('helper_model','helpermodel');
        $this->load->model('Ib_model','ibmodel');

        $this->load->library('Pdf');
        include_once APPPATH . '/third_party/phpqrcode/qrlib.php';
    }
    public function index()
    {
        $header['header'] = 'transaksi';
        $data['level'] = $this->usermodel->getdatalevel();
        $data['hakdep'] = $this->deptmodel->getdeptkirim();
        $data['dephak'] = $this->deptmodel->getdata();
        $data['depbbl'] = $this->deptmodel->getdata_dept_bbl(1);
        $kode = $this->session->userdata('deptdari');
        $data['data'] = $this->akbmodel->getdata($kode);
        $data['datatoken'] = $this->akbmodel->gettokenbc()->row_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'akb';
        $this->load->view('layouts/header', $header);
        $this->load->view('akb/akb', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function clear()
    {
        $this->session->set_userdata('bl', (int)date('m'));
        $this->session->set_userdata('th', date('Y'));
        $this->session->unset_userdata('deptdari');
        $url = base_url() . 'akb';
        redirect($url);
    }
    public function ubahperiode()
    {
        $this->session->set_userdata('bl', $_POST['bl']);
        $this->session->set_userdata('th', $_POST['th']);
        echo 1;
    }
    public function getdataakb()
    {
        $this->session->set_userdata('deptdari', $_POST['dept']);
        echo 1;
    }
    public function tambahdataib()
    {
        if($this->session->userdata('depttuju')!=null){
            $kode = $this->ibmodel->tambahdataib();
            if ($kode) {
                $url = base_url() . 'ib/dataib/' . $kode;
                redirect($url);
            }
        }else{
            $this->session->set_flashdata('errorsimpan',1);
            $url = base_url() . 'ib';
            redirect($url);
        }
    }
    public function cekbc()
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->ibmodel->getdatacekbc();
        $data['mtuang'] = $this->mtuangmodel->getdata();
        $data['jnsbc'] = $this->ibmodel->getdokbcmasuk();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ib';
        $this->load->view('layouts/header', $header);
        $this->load->view('ib/datacekbc', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function hapusib($id)
    {
        $query = $this->akbmodel->hapusib($id);
        if ($query) {
            $url = base_url() . 'akb';
            redirect($url);
        }
    }

    public function viewdetail($id,$mode=0)
    {
        $data['header'] = $this->akbmodel->getdatabyid($id,$mode);
        $data['detail'] = $this->akbmodel->getdatadetailib($id,$mode);
        $data['lampiran'] = $this->akbmodel->getdatalampiran($id);
        $this->load->view('akb/viewdetailakb', $data);
    }
    public function dataib($kode)
    {
        $header['header'] = 'transaksi';
        $data['data'] = $this->ibmodel->getdatabyid($kode);
        $data['mtuang'] = $this->mtuangmodel->getdata();
        $data['jnsbc'] = $this->ibmodel->getdokbcmasuk();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ib';
        $this->load->view('layouts/header', $header);
        $this->load->view('ib/dataib', $data);
        $this->load->view('layouts/footer', $footer);
    }
    public function updatebykolom($kolom){
        $data = [
            'id' => $_POST['id'],
            $kolom => $_POST['isinya']
        ];
        $hasil = $this->ibmodel->updatebykolom($data);
        echo $hasil;
    }
    public function updatekolom($kolom){
        $data = [
            'id_header' => $_POST['id'],
            $kolom => $_POST['isinya']
        ];
        $hasil = $this->ibmodel->updatekolom($_POST['tbl'],$data,'id');
        echo $hasil;
    }
    public function updateib(){
        $data = [
            'tgl' => tglmysql($_POST['tgl']),
            // 'keterangan' => $_POST['ket'],
            'id' => $_POST['id']
        ];
        $simpan = $this->ibmodel->updateib($data);
        echo $simpan;
    }
    public function getbarangib($sup='')
    {
        if($sup==''){
            $data['datadetail'] = $this->ibmodel->getbarangibl();
            $this->load->view('ib/getbarangibl',$data);
        }else{
            $data['header'] = $this->suppliermodel->getdatabyid($sup);
            $data['datadetail'] = $this->ibmodel->getbarangib($sup);
            $this->load->view('ib/getbarangib',$data);
        }
    }
        public function editsupplier()
    {
        $this->load->view('ib/editsupplier');
    }
    public function edittgl()
    {
        $this->load->view('ib/edit_tgl');
    }
    public function adddetailib(){
        $id = $_POST['id'];
        $brg = $_POST['brg'];
        $data = [
            'id' => $id,
            'data' => $brg
        ];
        $simpan = $this->ibmodel->adddetailib($data);
        echo $simpan;
    }
    public function getdatadetailib()
    {
        $hasil = '';
        $id = $_POST['id_header'];
        $query = $this->ibmodel->getdatadetailib($id);
        $header = $this->ibmodel->getdatabyid($id);
        $totalharga = 0;
        $no = 0;
        foreach ($query as $que) {
            $no++;
            $tampil = $que['pcs']==0 ? $que['kgs'] : $que['pcs'];
            $tampil2 = $que['pcsmintaa']==0 ? $que['kgsmintaa'] : $que['pcsmintaa'];
            $hasil .= "<tr>";
            $hasil .= "<td>" . $no . "</td>";
            $hasil .= "<td>" . $que['nama_barang'] . "</td>";
            $hasil .= "<td>" . $que['brg_id'] . "</td>";
            $hasil .= "<td>" . $que['namasatuan'] . "</td>";
            $hasil .= "<td>" . rupiah($tampil2, 0) . "</td>";
            $hasil .= "<td>" . rupiah($tampil, 0) . "</td>";
            if($header['jn_ib']==1){
            $hasil .= "<td>" . rupiah($que['harga'],2) . "</td>";
            }
            $hasil .= "<td>";
            $hasil .= "<a href=" . base_url() . 'ib/editdetailib/' . $que['id'] . " class='btn btn-sm btn-primary mr-1' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Ubah data Detail'>Ubah</a>";
            $hasil .= "<a href='#' data-href=" . base_url() . 'ib/hapusdetailib/' . $que['id'] .'/'.$que['id_header']. " class='btn btn-sm btn-danger' style='padding: 3px 5px !important;' data-bs-toggle='modal' data-message='Akan menghapus data ini ' data-bs-target='#modal-danger' data-title='Ubah data Detail'>Hapus</a>";
            $hasil .= "</td>";
            $hasil .= "</tr>";
            $totalharga += $que['harga']*$tampil;
        }
        $cocok = array('datagroup' => $hasil,'totalharga' => $totalharga,'jmlrek'=>$no);
        echo json_encode($cocok);
    }
    public function hapusdetailib($id,$detid){
        $hasil = $this->ibmodel->hapusdetailib($id);
        if($hasil){
            $url = base_url().'ib/dataib/'.$detid;
            redirect($url);
        }
    }
    public function editdetailib($id){
        $data['data'] = $this->ibmodel->getdetailibbyid($id);
        $data['header'] = $this->ibmodel->getdatabyid($id);
        $this->load->view('ib/editdetailib',$data);
    }
    public function updatepcskgs()
    {
        $kondisi = [
            'id' => $_POST['id'],
            'pcs' => $_POST['pcs'],
            'kgs' => $_POST['kgs'],
            'harga' => $_POST['hrg'],
        ];
        $hasil = $this->ibmodel->updatepcskgs($kondisi);
        echo $hasil;
    }
    public function simpanib($id)
    {
        $cekdetail = $this->ibmodel->cekdetail($id);
        if($cekdetail['xharga']==0 && $cekdetail['xkgs']==0){
            $data = [
                'user_ok' => $this->session->userdata('id'),
                'data_ok' => 1,
                'tgl_ok' => date('Y-m-d H:i:s'),
                'id' => $id,
                'totalharga' => $cekdetail['totalharga'],
                'total' => 'totalharga - diskon',
                'jumlah' => '((totalharga-diskon)+ppn)-pph',
                'bruto' => $cekdetail['kgs']
            ];
            $query = $this->ibmodel->simpanib($data);
            if ($query) {
                $url = base_url() . 'ib';
                redirect($url);
            }
        }else{
            $this->session->set_flashdata('errorsimpan',4);
            $url = base_url() . 'ib/dataib/'.$id;
            redirect($url);
        }
    }
    public function editib($id){
        $cek = $this->ibmodel->cekfield($id,'ok_tuju',0)->num_rows();
        if($cek==1){
            $data = [
                'data_ok' => 0,
                'user_ok' => null,
                'tgl_ok' => null,
                'id' => $id
            ];
            $hasil = $this->ibmodel->editib($data);
            if($hasil){
                $url = base_url().'ib';
                redirect($url);
            }else{
                $this->session->set_flashdata('errorsimpan',3);
                $url = base_url().'ib';
                redirect($url);
            }
        }else{
            $this->session->set_flashdata('errorsimpan',2);
            $url = base_url().'ib';
            redirect($url);
        }
    }
    public function cekhargabarang(){
        $id  = $_POST['id'];
        $hasil = $this->ibmodel->cekhargabarang($id);
        echo $hasil;
    }
    public function viewbc($id){
        $data['header'] = $this->ibmodel->getdatadetailib($id);
        $data['datheader'] = $id;
        $this->load->view('ib/viewbc',$data);
    }
    public function simpandatabc(){
        $data = $_POST['mode'];
        $head = $_POST['head'];
        $hasil = $this->ibmodel->simpandatabc($data,$head);
        echo $hasil;
    }
    public function isidokbc($id,$mode=0){
        $header['header'] = 'transaksi';
        $data['header'] = $this->akbmodel->getdatadetailib($id,$mode);
        $data['datheader'] = $this->akbmodel->getdatabyid($id);
        $data['bckeluar'] = $this->akbmodel->getbckeluar();
        $data['jnsangkutan'] = $this->akbmodel->getjnsangkutan();
        $data['refkemas'] = $this->akbmodel->refkemas();
        $data['refmtuang'] = $this->akbmodel->refmtuang();
        $data['refincoterm'] = $this->akbmodel->refincoterm();
        $data['refbendera'] = $this->akbmodel->refbendera();
        // $data['refpelabuhan'] = $this->ibmodel->refpelabuhan();
        $data['datatoken'] = $this->akbmodel->gettokenbc()->row_array();
        $footer['data'] = $this->helpermodel->getdatafooter()->row_array();
        $footer['fungsi'] = 'ibx';
        $this->load->view('layouts/header', $header);
        $this->load->view('akb/isidokbc',$data);
        $this->load->view('layouts/footer', $footer);
    }
    public function simpandatanobc(){
        $hasil = $this->ibmodel->simpandatanobc();
        echo $hasil;
    }
    public function ceisa40excel($id){
        $spreadsheet = new Spreadsheet();    
        $array = [
            'HEADER',
            'ENTITAS',
            'DOKUMEN',
            'PENGANGKUT','KEMASAN','KONTAINER','BARANG','BARANGTARIF','BARANGDOKUMEN','BARANGENTITAS','BARANGSPEKKHUSUS','BARANGVD',
            'BAHANBAKU','BAHANBAKUTARIF','BAHANBAKUDOKUMEN','PUNGUTAN','JAMINAN','BANKDEVISA','VERSI'
        ];
        
        $no=0;
        for($i=0;$i<count($array);$i++){
            $myWorkSheet = new \PhpOffice\PhpSpreadsheet\Worksheet\Worksheet($spreadsheet, $array[$i]); 
            $spreadsheet->addSheet($myWorkSheet);
            $no++;
        }
        for($z=0;$z<count($array);$z++){
            $sheet = $spreadsheet->getActiveSheet();    // Buat sebuah variabel untuk menampung pengaturan style dari header tabel    
            $sheet = $spreadsheet->getSheetByName($array[$z]);
            // 65
            $arrayheader = [
                'NOMOR AJU','KODE DOKUMEN','KODE KANTOR','KODE KANTOR BONGKAR','KODE KANTOR PERIKSA','KODE KANTOR TUJUAN',
                'KODE KANTOR EKSPOR','KODE JENIS IMPOR','KODE JENIS EKSPOR','KODE JENIS TPB','KODE JENIS PLB','KODE JENIS PROSEDUR',
                'KODE TUJUAN PEMASUKAN','KODE TUJUAN PENGIRIMAN','KODE TUJUAN TPB','KODE CARA DAGANG','KODE CARA BAYAR','KODE CARA BAYAR LAINNYA',
                'KODE GUDANG ASAL','KODE GUDANG TUJUAN','KODE JENIS KIRIM','KODE JENIS PENGIRIMAN','KODE KATEGORI EKSPOR','KODE KATEGORI MASUK FTZ',
                'KODE KATEGORI KELUAR FTZ','KODE KATEGORI BARANG FTZ','KODE LOKASI','KODE LOKASI BAYAR','LOKASI ASAL','LOKASI TUJUAN','KODE DAERAH ASAL',
                'KODE GUDANG ASAL','KODE GUDANG TUJUAN','KODE NEGARA TUJUAN','KODE TUTUP PU','NOMOR BC11','TANGGAL BC11','NOMOR POS','NOMOR SUB POS',
                'KODE PELABUHAN BONGKAR','KODE PELABUHAN MUAT','KODE PELABUHAN MUAT AKHIR','KODE PELABUHAN TRANSIT','KODE PELABUHAN TUJUAN','KODE PELABUHAN EKSPOR',
                'KODE TPS','TANGGAL BERANGKAT','TANGGAL EKSPOR','TANGGAL MASUK','TANGGAL MUAT','TANGGAL TIBA','TANGGAL PERIKSA','TEMPAT STUFFING',
                'TANGGAL STUFFING','KODE TANDA PENGAMAN','JUMLAH TANDA PENGAMAN','FLAG CURAH','FLAG SDA','FLAG VD','FLAG AP BK','FLAG MIGAS','KODE ASURANSI',
                'ASURANSI','NILAI BARANG','NILAI INCOTERM','NILAI MAKLON','ASURANSI','FREIGHT','FOB','BIAYA TAMBAHAN','BIAYA PENGURANG','VD','CIF','HARGA_PENYERAHAN',
                'NDPBM','TOTAL DANA SAWIT','DASAR PENGENAAN PAJAK','NILAI JASA','UANG MUKA','BRUTO','NETTO','VOLUME','KOTA PERNYATAAN','TANGGAL PERNYATAAN',
                'NAMA PERNYATAAN','JABATAN PERNYATAAN','KODE VALUTA','KODE INCOTERM','KODE JASA KENA PAJAK','NOMOR BUKTI BAYAR','TANGGAL BUKTI BAYAR','KODE JENIS NILAI',
                'KODE KANTOR MUAT','NOMOR DAFTAR','TANGGAL DAFTAR','KODE ASAL BARANG FTZ','KODE TUJUAN PENGELUARAN','PPN PAJAK','PPNBM PAJAK',
                'TARIF PPN PAJAK','TARIF PPNBM PAJAK','BARANG TIDAK BERWUJUD','KODE JENIS PENGELUARAN'
            ];
            $arrayentitas = [
                'NOMOR AJU','SERI','KODE ENTITAS','KODE JENIS IDENTITAS','NOMOR IDENTITAS','NAMA ENTITAS','ALAMAT ENTITAS','NIB ENTITAS','KODE JENIS API',
                'KODE STATUS','NOMOR UIN ENTITAS','TANGGAL UIN ENTITAS','KODE NEGARA','NIPER ENTITAS'
            ];
            $arraydokumen = [
                'NOMOR AJU','SERI','KODE DOKUMEN','NOMOR DOKUMEN','TANGGAL DOKUMEN','KODE FASILITAS','KODE UIN'
            ];
            $arraypengangkut = [
                'NOMOR AJU','SERI','KODE CARA ANGKUT','NAMA PENGANGKUT','NOMOR PENGANGKUT','KODE NEGARA','CALL SIGN','FLAG ANGKUT PLB'
            ];
            $arraykemasan = [
                'NOMOR AJU','SERI','KODE KEMASAN','JUMLAH KEMASAN','MERK'
            ];
            $arraykontainer = [
                'NOMOR AJU','SERI','NOMOR KONTAINER','KODE UKURAN KONTAINER','KODE JENIS KONTAINER','KODE TIPE KONTAINER'
            ];
            $arraybarang = [
                'NOMOR AJU','SERI BARANG','HS','KODE BARANG','URAIAN','MEREK','TIPE','UKURAN','SPESIFIKASI LAIN','KODE SATUAN','JUMLAH SATUAN',
                'KODE KEMASAN','JUMLAH KEMASAN','KODE DOKUMEN ASAL','KODE KANTOR ASAL','NOMOR DAFTAR ASAL','TANGGAL DAFTAR ASAL','NOMOR AJU ASAL',
                'SERI BARANG ASAL','NETTO','BRUTO','VOLUME','SALDO AWAL','SALDO AKHIR','JUMLAH REALISASI','CIF','CIF RUPIAH','NDPBM','FOB','ASURANSI',
                'FREIGHT','NILAI TAMBAH','DISKON','HARGA PENYERAHAN','HARGA PEROLEHAN','HARGA SATUAN','HARGA EKSPOR','HARGA PATOKAN','NILAI BARANG','NILAI JASA',
                'NILAI DANA SAWIT','NILAi DEVISA','PERSENTASE IMPOR','KODE ASAL BARANG','KODE DAERAH ASAL','KODE GUNA BARANG','KODE JENIS NILAI',
                'JATUH TEMPO ROYALTI','KODE KATEGORI BARANG','KODE KONDISI BARANG','KODE NEGARA ASAL','KODE PERHITUNGAN','PERNYATAAN LARTAS',
                'FLAG 4 TAHUN','SERI IZIN','TAHUN PEMBUATAN','KAPASITAS SILINDER','KODE BKC','KODE KOMODITI BKC','KODE SUB KOMODITI BKC','FLAG TIS',
                'ISI PER KEMASAN','JUMLAH DILEKATKAN','JUMLAH PITA CUKAI','HJE CUKAI','TARIF CUKAI'
            ];
            $arraybarangtarif = [
                'NOMOR AJU','SERI BARANG','KODE PUNGUTAN','KODE TARIF','TARIF','KODE FASILITAS','TARIF FASILITAS','NILAI BAYAR','NILAI FASILITAS',
                'NILAI SUDAH DILUNASI','KODE SATUAN','JUMLAH SATUAN','FLAG BMT SEMENTARA','KODE KOMODITI CUKAI','KODE SUB KOMODITI CUKAI','FLAG TIS',
                'FLAG PELEKATAN','KODE KEMASAN','JUMLAH KEMASAN'
            ];
            $arraybarangdokumen = [
                'NOMOR AJU','SERI BARANG','SERI DOKUMEN','SERI IZIN'  
            ];
            $arraybarangentitas = [
                'NOMOR AJU','SERI BARANG','SERI DOKUMEN'
            ];
            $arraybarangspekkhusus = [
                'NOMOR AJU','SERI BARANG','KODE','URAIAN'
            ];
            $arraybarangvd = [
                'NOMOR AJU','SERI BARANG','KODE VD','NILAI BARANG','BIAYA TAMBAHAN','BIAYA PENGURANG','JATUH TEMPO'
            ];
            $arraybahanbaku = [
                'NOMOR AJU','SERI BARANG','SERI BAHAN BAKU','KODE ASAL BAHAN BAKU','HS','KODE BARANG','URAIAN','MEREK','TIPE','UKURAN','SPESIFIKASI LAIN',
                'KODE SATUAN','JUMLAH SATUAN','KODE KEMASAN','JUMLAH KEMASAN','KODE DOKUMEN ASAL','KODE KANTOR ASAL','NOMOR DAFTAR ASAL','TANGGAL DAFTAR ASAl',
                'NOMOR AJU ASAL','SERI BARANG ASAL','NETTO','BRUTO','VOLUME','CIF','CIF RUPIAH','NDPBM','HARGA PENYERAHAN','HARGA PEROLEHAN','NILAI JASA','SERI IZIN',
                'VALUTA','KODE BKC','KODE KOMODITI BKC','KODE SUB KOMODITI BKC','FLAG TIS','ISI PER KEMASAN','JUMLAH DILEKATKAN','JUMLAH PITA CUKAI','HJE CUKAI','TARIF CUKAI'
            ];
            $arraybahanbakutarif = [
                'NOMOR AJU','SERI BARANG','SERI BAHAN BAKU','KODE ASAL BAHAN BAKU','KODE PUNGUTAN','KODE TARIF','TARIF','KODE FASILITAS','TARIF FASILITAS',
                'NILAI BAYAR','NILAI FASILITAS','NILAI SUDAH DILUNASI','KODE SATUAN','JUMLAH SATUAN','FLAG BMT SEMENTARA','KODE KOMODITI CUKAI','KODE SUB KOMODITI CUKAI',
                'FLAG TIS','FLAG PELEKATAN','KODE KEMASAN','KODE SUB KOMODITI CUKAI','FLAG TIS','FLAG PELEKATAN','KODE KEMASAN','JUMLAH KEMASAN'
            ];
            $arraybahanbakudokumen = [
                'NOMOR AJU','SERI BARANG','SERI BAHAN BAKU','KODE_ASAL_BAHAN_BAKU','SERI DOKUMEN','SERI IZIN'
            ];
            $arraypungutan = [
                'NOMOR AJU','KODE FASILITAS TARIF','KODE JENIS PUNGUTAN','NILAI PUNGUTAN','NPWP BILLING'
            ];
            $arrayjaminan = [
                'NOMOR AJU','KODE KANTOR','KODE JAMINAN','NOMOR JAMINAN','TANGGAL JAMINAN','NILAI JAMINAN','PENJAMIN','TANGGAL JATUH TEMPO','NOMOR BPJ','TANGGAL BPJ'
            ];
            $arraybankdevisa = [
                'NOMOR AJU','SERI','KODE','NAMA'
            ];
            $arrayversi = [
                'VERSI'
            ];
            $kode = 'array'.strtolower($array[$z]);
            // print_r($$kode);
            for($i=0;$i<count($$kode);$i++){
                if((65+$i) > 142){
                    $chr = chr(67).chr(65+($i-78));
                }else if((65+$i) > 116){
                    $chr = chr(66).chr(65+($i-52));
                }else if((65+$i) > 90){
                    $chr = chr(65).chr(65+($i-26));
                }else{
                    $chr = chr(65+$i);
                }
                $sheet->setCellValue($chr.'1', $$kode[$i]);
            }
        }  
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);
        //Proses pengisian excel dari database
        $data = $this->ibmodel->getdatabyid($id);
        $noaju = isikurangnol($data['jns_bc']).'010017'.str_replace('-','',$data['tgl_aju']).$data['nomor_aju'];
        $sheet = $spreadsheet->getSheetByName('HEADER');
        $sheet->setCellValue('A2', $noaju); 
        $sheet->setCellValue('B2', '40'); 
        $sheet->setCellValue('C2', '050500'); 
        $sheet->setCellValue('J2', '1'); 
        $sheet->setCellValue('N2', '1'); 
        $sheet->setCellValue('BV2', $data['totalharga']);  // Nilai PAB
        $sheet->setCellValue('CB2', $data['bruto']);  // Bruto
        $sheet->setCellValue('CC2', $data['netto']);  // Netto
        $sheet->setCellValue('CD2', '0');
        $sheet->setCellValue('CE2', 'BANDUNG');
        $sheet->setCellValue('CF2', $data['tgl_aju']);
        $sheet->setCellValue('CG2', 'MIRA AMALIA WULAN');
        $sheet->setCellValue('CH2', 'MANAGER KEU. & AKT');

        $sheet = $spreadsheet->getSheetByName('ENTITAS');
        $sheet->setCellValue('A2', $noaju); 
        $sheet->setCellValue('B2', '3'); 
        $sheet->setCellValue('C2', '3'); 
        $sheet->setCellValue('D2', '5'); 
        $sheet->setCellValue('E2', '010017176057000'); 
        $sheet->setCellValue('F2', 'INDONEPTUNE NET MANUFACTURING');
        $sheet->setCellValue('G2', 'JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01, DESA CANGKUANG 004/001 CANGKUANG, RANCAEKEK, BANDUNG, JAWA BARAT'); 
        $sheet->setCellValue('H2', "9120011042693");
        $sheet->setCellValue('K2', '1555/KM.4/2017');
        $sheet->setCellValue('L2', '2017-07-10');

        $sheet->setCellValue('A3', $noaju); 
        $sheet->setCellValue('B3', '7'); 
        $sheet->setCellValue('C3', '7'); 
        $sheet->setCellValue('D3', '5'); 
        $sheet->setCellValue('E3', '010017176057000'); 
        $sheet->setCellValue('F3', 'INDONEPTUNE NET MANUFACTURING');
        $sheet->setCellValue('G3', 'JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01, DESA CANGKUANG 004/001 CANGKUANG, RANCAEKEK, BANDUNG, JAWA BARAT'); 
        $sheet->setCellValue('J2', "LAINNYA");
        $sheet->setCellValue('K3', '1555/KM.4/2017');
        $sheet->setCellValue('L3', '2017-07-10');

        $sheet->setCellValue('A4', $noaju); 
        $sheet->setCellValue('B4', '9'); 
        $sheet->setCellValue('C4', '9'); 
        $sheet->setCellValue('D4', '5'); 
        $sheet->setCellValue('E4', $data['npwp']); 
        $sheet->setCellValue('F4', $data['namasupplier']);
        $sheet->setCellValue('G4', $data['alamat']); 
        $sheet->setCellValue('I4', "02");
        $sheet->setCellValue('J4', 'LAINNYA');

        $sheet = $spreadsheet->getSheetByName('DOKUMEN');
        $dokmen = $this->ibmodel->getdatadokumen($id);
        $no = 1;
        foreach ($dokmen->result_array() as $doku) {
            $sheet->setCellValue('A2', $noaju); 
            $sheet->setCellValue('B2', $no++);
            $sheet->setCellValue('C2', $doku['kode_dokumen']);
            $sheet->setCellValue('D2', $doku['nomor_dokumen']);
            $sheet->setCellValue('E2', $doku['tgl_dokumen']);
        }

        $sheet = $spreadsheet->getSheetByName('PENGANGKUT');
        $sheet->setCellValue('A2', $noaju); 
        $sheet->setCellValue('C2', $data['jns_angkutan']); 
        $sheet->setCellValue('D2', $data['angkutan']); 
        $sheet->setCellValue('E2', $data['no_kendaraan']); 

        $sheet = $spreadsheet->getSheetByName('KEMASAN');
        $sheet->setCellValue('A2', $noaju); 
        $sheet->setCellValue('B2', '1'); 
        $sheet->setCellValue('C2', $data['kd_kemasan']); 
        $sheet->setCellValue('D2', $data['jml_kemasan']);
        
        $sheet = $spreadsheet->getSheetByName('BARANG');
        $datadet = $this->ibmodel->getdatadetailib($id);
        $no = 1;
        foreach ($datadet as $detx) {
            $no++;
            $jumlah = $detx['kodesatuan']=='KGS' ? $detx['kgs'] : $detx['pcs'];
            $sheet->setCellValue('A'.$no, $noaju); 
            $sheet->setCellValue('B'.$no, $detx['seri_barang']); 
            $sheet->setCellValue('C'.$no, $detx['nohs']); 
            $sheet->setCellValue('D'.$no, $detx['brg_id']); 
            $sheet->setCellValue('E'.$no, $detx['nama_barang']); 
            $sheet->setCellValue('J'.$no, $detx['satbc']); 
            $sheet->setCellValue('K'.$no, $jumlah); 
            $sheet->setCellValue('L'.$no, $data['kd_kemasan']); 
            $sheet->setCellValue('M'.$no, '0'); 
            $sheet->setCellValue('T'.$no, $detx['kgs']); 
            $sheet->setCellValue('AH'.$no, $detx['harga']); 
        }

        $sheet = $spreadsheet->getSheetByName('BARANGTARIF');
        $no = 1;
        $sumppn = 0;
        foreach ($datadet as $detx) {
            $no++;
            $jumlah = $detx['kodesatuan']=='KGS' ? $detx['kgs'] : $detx['pcs'];
            $sheet->setCellValue('A'.$no, $noaju); 
            $sheet->setCellValue('B'.$no, $detx['seri_barang']); 
            $sheet->setCellValue('C'.$no, 'PPN'); 
            $sheet->setCellValue('D'.$no, '1'); 
            $sheet->setCellValue('E'.$no, 11); 
            $sheet->setCellValue('F'.$no, '3'); 
            $sheet->setCellValue('G'.$no, 100); 
            $sheet->setCellValue('I'.$no, round($detx['harga']*0.11,0)); 
            $sheet->setCellValue('J'.$no, '0'); 
            $sheet->setCellValue('K'.$no, substr($detx['kodesatuan'],0,2)); 
            $sheet->setCellValue('L'.$no, $jumlah); 
            $sumppn += round($detx['harga']*0.11,0);
        }

        $sheet = $spreadsheet->getSheetByName('PUNGUTAN');
        $sheet->setCellValue('A2', $noaju); 
        $sheet->setCellValue('B2', '3'); 
        $sheet->setCellValue('C2', 'PPN'); 
        $sheet->setCellValue('D2', $sumppn); 

        $sheet = $spreadsheet->getSheetByName('VERSI');
        $sheet->setCellValue('A2', '1.1'); 

        // Proses file excel    
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');    
        header('Content-Disposition: attachment; filename="Data Ceisa 40.xlsx"'); // Set nama file excel nya    
        header('Cache-Control: max-age=0');    
        $writer = new Xlsx($spreadsheet);    
        $writer->save('php://output');
    }
    public function hosttohost($id){
        $this->session->unset_userdata('datatokenbeacukai');
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            // "Authorization: Bearer ".$logged_user_token
        );
        $data = [
            'username' => 'siaga1', //'indoneptune',
            'password' => 'Ifn123456' //'Bandung#14',
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER,$headers
            // array(
            //     "Authorization: $token",
            // )
        );
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/nle-oauth/v1/user/login');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $databalik = json_decode($result,true);
        // print_r($databalik);
        if($databalik['status']=='success'){
            $data = [
                'token' => $databalik['item']['access_token'],
                'refresh_token' => $databalik['item']['refresh_token']
            ];
            $this->akbmodel->isitokenbc($data);
            $this->session->set_userdata('datatokenbeacukai',$databalik['item']['access_token']);
            $this->helpermodel->isilog('Refresh Token CEISA 40');
            if($id=99){
                $url = base_url().'akb';
            }else{
                $url = base_url().'akb/isidokbc/'.$id;
            }
            redirect($url);
        }else{
            // $url = base_url().'ib/kosong';
            // redirect($url);
            $this->session->set_flashdata('errorsimpan',1);
            $this->session->set_flashdata('pesanerror',$databalik['message'].'[EXCEPTION]'.$databalik['Exception']);
            if($id=''){
                $url = base_url().'ib';
            }else{
                $url = base_url().'ib/isidokbc/'.$id;
            }
            redirect($url);
        }
    }
    public function getresponhost($id){
        $dataaju = $this->akbmodel->getdatanomoraju($id);
        $token = $this->akbmodel->gettoken();
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$token,
        );
        $data = [
            $dataaju
        ];

        curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/openapi/status/'.$dataaju);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $databalik = json_decode($result,true);
        // print_r($databalik);
        if($databalik['status']=='Success'){
            if($databalik['dataStatus'][0]['nomorDaftar']!=''){
                $data = [
                    'id' => $id,
                    'nomor_bc' => $databalik['dataStatus'][0]['nomorDaftar'],
                    'tgl_bc' => tglmysql($databalik['dataStatus'][0]['tanggalDaftar']),
                    'nomor_sppb' => $databalik['dataRespon'][0]['nomorRespon'],
                    'tgl_sppb' => $databalik['dataRespon'][0]['tanggalRespon']
                ];
                $hasil = $this->akbmodel->simpanresponbc($data);
                if($hasil){
                    $this->helpermodel->isilog("Berhasil GET RESPON AJU ".$dataaju." (".$databalik['dataStatus'][0]['nomorDaftar'].")");
                    $this->session->set_flashdata('errorsimpan',2);
                    $this->session->set_flashdata('pesanerror','Respon sudah berhasil di Tarik');
                }
            }else{
                $this->session->set_flashdata('errorsimpan',1);
                $this->session->set_flashdata('pesanerror','Nomor Pendaftaran Masih kosong, '.$databalik['dataStatus'][0]['keterangan']);
            }
            $url = base_url().'akb/isidokbc/'.$id;
            redirect($url);
        }else{
            $this->session->set_flashdata('errorsimpan',1);
            $this->session->set_flashdata('pesanerror',$databalik['message'].'[EXCEPTION]'.$databalik['Exception']);
            // $url = base_url().'ib/isidokbc/'.$id;
            $url = base_url().'akb/isidokbc/'.$id;
            redirect($url);
        }
    }
    public function getresponpdf($id,$mode=0){
        $dataaju = $this->akbmodel->getdatanomoraju($id);
        $token = $this->akbmodel->gettoken();
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$token,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/openapi/status/'.$dataaju);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $databalik = json_decode($result,true);
        // print_r($databalik);
        if($databalik['status']=='Success'){
            if($databalik['dataStatus'][0]['nomorDaftar']!='' && $databalik['dataRespon'][0]['pdf']!=null){
                $this->tampilkanpdf($databalik['dataRespon'][0]['pdf'],$id,$mode);
            }else{
                $this->session->set_flashdata('errorsimpan',1);
                $this->session->set_flashdata('pesanerror','PDF Belum ada');
            }
            $url = $mode = 0 ? base_url().'akb/isidokbc/'.$id : base_url().'akb';
            redirect($url);
        }else{
            $this->session->set_flashdata('errorsimpan',1);
            $this->session->set_flashdata('pesanerror',$databalik['message'].'[EXCEPTION]'.$databalik['Exception']);
            // $url = base_url().'ib/isidokbc/'.$id;
            $url = $mode = 0 ? base_url().'akb/isidokbc/'.$id : base_url().'akb';
            redirect($url);
        }
    }
    public function tampilkanpdf($data,$id,$mode){
        $token = $this->ibmodel->gettoken();
        $dataaju = $this->ibmodel->getdatanomoraju($id);
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$token,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, "https://apis-gw.beacukai.go.id/openapi/download-respon?path=".$data);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);
        
        // print_r($data);  
        $pisah = explode('/',$data);
        $filename = $data;
        $databalik = $result;
        $lokfile = $dataaju;
        header('Cache-Control: public'); 
        header('Content-type: application/pdf');
        header('Content-Disposition: attachment; filename="'.$lokfile.'"');
        header('Content-Length: '.strlen($databalik));
        echo $databalik;
        if($mode=0){
            $url = base_url().'ib/isidokbc/'.$id;
        }else{
            $url = base_url().'ib';
        }
        redirect($url);
    }
    public function addlampiran($id){
        $data['datheader'] = $this->ibmodel->getdatabyid($id);
        $data['lampiran'] = $this->ibmodel->getjenisdokumen();
        $this->load->view('ib/addlampiran',$data);
    }
    public function tambahlampiran(){
        $data = [
            'id_header' => $_POST['id'],
            'kode_dokumen' => $_POST['kode'],
            'nomor_dokumen' => $_POST['nomor'],
            'tgl_dokumen' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket']
        ];
        $hasil = $this->ibmodel->tambahlampiran($data);
        if($hasil){
            $this->helpermodel->isilog($this->db->last_query());
            $html = '';
            $query = $this->ibmodel->getdatalampiran($_POST['id']);
            $no = 1;
            foreach ($query->result_array() as $que) {
                $html .= '<tr>';
                $html .= '<td>'.$no++.'</td>';
                $html .= '<td>'.$que['kode_dokumen'].'</td>';
                $html .= '<td>'.$que['nama_dokumen'].'</td>';
                $html .= '<td>'.$que['nomor_dokumen'].'</td>';
                $html .= '<td>'.$que['tgl_dokumen'].'</td>';
                $html .= '<td>'.$que['keterangan'].'</td>';
                $html .= '<td>';
                $html .= '<a href="'.base_url().'ib/hapuslampiran/'.$que['id'].'/'.$que['id_header'].'" style="padding: 2px 3px !important;" class="btn btn-sm btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus IB" data-title="Isi Data AJU + Nomor BC">Hapus</a>';
                $html .= '<a href="'.base_url().'ib/editlampiran/'.$que['id'].'/'.$que['id_header'].'" style="padding: 2px 3px !important;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Edit IB" data-title="Edit Data AJU + Nomor BC">Edit</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $cocok = array('datagroup' => $html);
            echo json_encode($cocok);
        }
    }
    public function getdatalampiran($id){
        $html = '';
        $sendceisa = $_POST['cek'];
        $query = $this->ibmodel->getdatalampiran($id);
        $no = 1;
        foreach ($query->result_array() as $que) {
            $html .= '<tr>';
            $html .= '<td>'.$no++.'</td>';
            $html .= '<td>'.$que['kode_dokumen'].'</td>';
            $html .= '<td>'.$que['nama_dokumen'].'</td>';
            $html .= '<td>'.$que['nomor_dokumen'].'</td>';
            $html .= '<td>'.$que['tgl_dokumen'].'</td>';
            $html .= '<td>'.$que['keterangan'].'</td>';
            $html .= '<td>';
            if($sendceisa == 0){
                $html .= '<a href="'.base_url().'ib/hapuslampiran/'.$que['idx'].'/'.$que['id_header'].'" style="padding: 2px 3px !important;" class="btn btn-sm btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus IB" data-title="Hapus Lampiran">Hapus</a>';
                $html .= '<a href="'.base_url().'ib/editlampiran/'.$que['id'].'/'.$que['id_header'].'" style="padding: 2px 3px !important;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Edit IB" data-title="Edit Data Lampiran">Edit</a>';
            }
            $html .= '</td>';
            $html .= '</tr>';
        }
        $cocok = array('datagroup' => $html);
        echo json_encode($cocok);
    }
    public function editlampiran($id,$ide){
        $data['datlampiran'] = $this->ibmodel->getdatalampiranbyid($id)->row_array();
        $data['lampiran'] = $this->ibmodel->getjenisdokumen();
        $this->load->view('ib/editlampiran',$data);
    }
    public function updatelampiran(){
        $data = [
            'id' => $_POST['id'],
            'kode_dokumen' => $_POST['kode'],
            'nomor_dokumen' => $_POST['nomor'],
            'tgl_dokumen' => tglmysql($_POST['tgl']),
            'keterangan' => $_POST['ket']
        ];
        $hasil = $this->ibmodel->updatelampiran($data);
        if($hasil){
            $this->helpermodel->isilog($this->db->last_query());
            $html = '';
            $query = $this->ibmodel->getdatalampiran($_POST['head']);
            $no = 1;
            foreach ($query->result_array() as $que) {
                $html .= '<tr>';
                $html .= '<td>'.$no++.'</td>';
                $html .= '<td>'.$que['kode_dokumen'].'</td>';
                $html .= '<td>'.$que['nama_dokumen'].'</td>';
                $html .= '<td>'.$que['nomor_dokumen'].'</td>';
                $html .= '<td>'.$que['tgl_dokumen'].'</td>';
                $html .= '<td>'.$que['keterangan'].'</td>';
                $html .= '<td>';
                $html .= '<a href="'.base_url().'ib/hapuslampiran/'.$que['id'].'/'.$que['id_header'].'" style="padding: 2px 3px !important;" class="btn btn-sm btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus IB" data-title="Isi Data AJU + Nomor BC">Hapus</a>';
                $html .= '<a href="'.base_url().'ib/editlampiran/'.$que['id'].'/'.$que['id_header'].'" style="padding: 2px 3px !important;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Edit IB" data-title="Edit Data AJU + Nomor BC">Edit</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $cocok = array('datagroup' => $html);
            echo json_encode($cocok);
        }
    }
    public function hapuslampiran($id,$ide){
        $data = [
            'id' => $id,
            'header' => $ide
        ];
        $this->load->view('ib/hapuslampiran',$data);
    }
    public function hapuslamp(){
        $data = $_POST['id'];
        $header = $_POST['head'];
        $hasil = $this->ibmodel->hapuslampiran($data);
        if($hasil){
            $this->helpermodel->isilog($this->db->last_query());
            $html = '';
            $query = $this->ibmodel->getdatalampiran($header);
            $no = 1;
            foreach ($query->result_array() as $que) {
                $html .= '<tr>';
                $html .= '<td>'.$no++.'</td>';
                $html .= '<td>'.$que['kode_dokumen'].'</td>';
                $html .= '<td>'.$que['nama_dokumen'].'</td>';
                $html .= '<td>'.$que['nomor_dokumen'].'</td>';
                $html .= '<td>'.$que['tgl_dokumen'].'</td>';
                $html .= '<td>'.$que['keterangan'].'</td>';
                $html .= '<td>';
                $html .= '<a href="'.base_url().'ib/hapuslampiran/'.$que['idx'].'/'.$que['id_header'].'" style="padding: 2px 3px !important;" class="btn btn-sm btn-danger mr-1" data-bs-toggle="modal" data-bs-target="#canceltask" data-message="Hapus Lampiran" class="btn btn-sm btn-primary">Hapus</a>';
                $html .= '<a href="'.base_url().'ib/editlampiran/'.$que['id'].'/'.$que['id_header'].'" style="padding: 2px 3px !important;" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Edit IB" data-title="Edit Data Lampiran">Edit</a>';
                $html .= '</td>';
                $html .= '</tr>';
            }
            $cocok = array('datagroup' => $html);
            echo json_encode($cocok);
        }
    }
    function kirimdatakeceisa30($id){
        $data = $this->akbmodel->getdatabyid($id);
        $datakon = $this->akbmodel->getdatakontainer($id);
        $noaju = isikurangnol($data['jns_bc']).'010017'.str_replace('-','',$data['tgl_aju']).$data['nomor_aju'];
        $kurs = $data['mtuang']==2 ? $data['kurs_usd'] : $data['kurs_yen'];
        $arrayheader = [
            "asalData" => "S",
            "kodeDokumen" => $data['jns_bc'],
            "asuransi" => (float) $data['asuransi'],
            "bruto" => (float) $data['bruto'],
            "flagCurah" => "2",
            "flagMigas" => "2",
            "fob" => (float) $data['nilai_pab'],
            "freight" => (float) $data['freight'],
            "jabatanTtd" => strtoupper($data['jabat_tg_jawab']),
            "jumlahKontainer" => $datakon->num_rows(),
            "kodeAsuransi" => "DN",
            "kodeCaraBayar" => "4",
            "kodeCaraDagang" => "15",
            "kodeJenisEkspor" => "1",
            "kodeKantor" => "040300",
            "kodeKantorEkspor" => "040300",
            "kodeKantorMuat" => "040300",
            "kodeKantorPeriksa" => "050500",
            "kodeKategoriEkspor" => "41",
            "kodeLokasi" => "6",
            "kodeNegaraTujuan" => $data['negaracustomer'],
            "kodePelBongkar" => trim($data['pelabuhan_bongkar']),
            "kodePelEkspor" => trim($data['pelabuhan_muat']),
            "kodePelMuat" => trim($data['pelabuhan_muat']),
            "kodePelTujuan" => trim($data['pelabuhan_bongkar']),
            "kodeValuta" => $data['mt_uang'],
            "kotaTtd" => "BANDUNG",
            "namaTtd" => strtoupper($data['tg_jawab']),
            "ndpbm" => (float) $kurs,
            "netto" => (float) $data['netto'],
            "nilaiMaklon" => 0,
            "nomorAju" => $noaju,
            "tanggalEkspor" => $data['tgl_aju'],
            "tanggalPeriksa" => $data['tgl_aju'],
            "tanggalTtd" => $data['tgl_aju'],
            "kodeIncoterm" => $data['kode_incoterm'],
            "flagBarkir" => "T",
            "kodeJenisPengangkutan" => "1"
            // "kesiapanBarang" => [],
            // "bankDevisa" => []
        ];
        $arrayentitas = [];
        for($ke=1;$ke<=4;$ke++){
            $alamatifn = "JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01,\r\nDESA CANGKUANG 004/001 CANGKUANG,\r\nRANCAEKEK, BANDUNG, JAWA BARAT";
            $serient = $ke==1 ? "2" : (($ke==2) ? "8" : (($ke==3) ? "6" : "13"));
            $kodeentitas = $ke==1 ? "2" : (($ke==2) ? "7" : (($ke==3) ? "8" : "6"));
            $kodejnent = $ke==1 ? "6" : (($ke==4) ? "" : (($ke==2) ? "6" : ""));
            $status = "";
            if($ke > 2){
                if ($ke == 3){
                    $nomoridentitas = "";
                    $namaidentitas = $data['namacustomer'];
                    $alamat = strtoupper($data['alamat']);
                    $negara = $data['negaracustomer'];
                }else{
                    if($data['dirsell']==1){
                        $nomoridentitas = "";
                        $namaidentitas = $data['namacustomer'];
                        $alamat = strtoupper($data['alamat']);
                        $negara = $data['negaracustomer'];
                    }else{
                        $nomoridentitas = "";
                        $namaidentitas = "MOMOI FISHING NET MFG CO.,LTD";
                        $alamat = "10TH FL.KOBE ASAHI BLDG 59 NANIWA MACHI CHUO KU KOBE 6500035";
                        $negara = "JP";
                    }
                }
            }else{
                $nomoridentitas = $ke==1 ? "0010017176057000000000" : "0010017176057000000000";
                $namaidentitas = $ke==1 ? "INDONEPTUNE NET MANUFACTURING" : "INDONEPTUNE NET MANUFACTURING";
                $alamat = $ke==1 ? $alamatifn : $alamatifn ;
                $negara = '';
                $status = "5";
            }
            $nibidentitas = $ke==1 ? "9120011042693" : (($ke==2) ? "9120011042693" : "");
            $arrayke = [
                "seriEntitas" => (int) $serient,
                "kodeEntitas" => $kodeentitas,
                "kodeJenisIdentitas" => $kodejnent,
                "nomorIdentitas" => trim(str_replace('-','',str_replace('.','',$nomoridentitas))),
                "alamatEntitas" => $alamat,
                "namaEntitas" => trim($namaidentitas),
                "nibEntitas" => $nibidentitas,
                "kodeNegara" => $negara,
                "kodeStatus" => $status
            ];
            array_push($arrayentitas,$arrayke);
        }
        $arraydokumen = [];
        $dokmen = $this->akbmodel->getdatadokumen($id);
        $no = 1;
        foreach ($dokmen->result_array() as $doku) {
            $arrayke = [
                "kodeDokumen" => $doku['kode_dokumen'],
                "nomorDokumen" => $doku['nomor_dokumen'],
                "seriDokumen" => $no++,
                "tanggalDokumen" => $doku['tgl_dokumen']
            ];
            array_push($arraydokumen,$arrayke);
        }
        $carangkut = $data['jns_angkutan'];
        switch ($carangkut) {
            case 2:
                $carangkut = "3";
                break;
            case 3:
                $carangkut = "4";
                break;
            case 4:
                $carangkut = "9";
                break;
        }
        $arrangkut = [];
        $arrayangkutan = [
            "namaPengangkut" => trim($data['angkutan']),
            "nomorPengangkut" => $data['no_kendaraan'],
            "seriPengangkut" => 1,
            "kodeCaraAngkut" => $carangkut,
            "kodeBendera" => $data['kode_negara']
        ];
        array_push($arrangkut,$arrayangkutan);
        $datakont = $this->akbmodel->getdatakontainer($id);
        $arraykonta = [];
        $ke = 0;
        foreach ($datakont->result_array() as $kont) { $ke++;
            $arrkont = [
                'kodeTipeKontainer' => "1",
                'kodeUkuranKontainer' => $kont['ukuran_kontainer'],
                'nomorKontainer' => $kont['nomor_kontainer'],
                'kodeJenisKontainer' => $kont['jenis_kontainer'],
                'seriKontainer' => $ke
            ];
            array_push($arraykonta,$arrkont);
        }
        // array_push($arraykonta,$arraykontainer);
        $arrkemas = [];
        $arraykemasan = [
            "jumlahKemasan" => (int) $data['jml_kemasan'],
            "kodeJenisKemasan" => $data['kd_kemasan'],
            "merkKemasan" => "-",
            "seriKemasan" => 1
        ];
        array_push($arrkemas,$arraykemasan);
        $arraybarang = [];
        $datadet = $this->akbmodel->getdatadetailib($id);
        $no = 0;
        $jumlahfasilitas = 0;
        foreach ($datadet as $detx) {
            $no++;
            $jumlah = $detx['kodesatuan']=='KGS' ? $detx['kgs'] : $detx['pcs'];
            $arrayke = [
                "seriBarang" => $no,
                "asuransi" => 0,
                "cif" => 0,
                "cifRupiah" => 0,
                "fob" => (float) round($detx['harga'],2),
                "hargaEkspor" => 0,
                "hargaPatokan" => 0,
                "hargaPerolehan" => 0,
                "hargaSatuan" => (float) round($detx['harga_satuan'],2),
                "jumlahKemasan" => (float) $detx['jml_kemasan'],
                "jumlahSatuan" => (float) $jumlah,
                "kodeBarang" => trim($detx['po']).'#'.trim($detx['item']),
                "kodeDaerahAsal" => "3204",
                "kodeJenisKemasan" => $detx['kdkem'],
                "kodeNegaraAsal" => "ID",
                "kodeSatuanBarang" => $detx['satbc'],
                "merk" => "MOMOI",
                "ndpbm" => (float) $kurs,
                "netto" => (float) $detx['kgs'],
                "posTarif" =>  substr($detx['nohs'],0,8),
                "spesifikasiLain" => "1",
                "tipe" => "-",
                "ukuran" => "-",
                "uraian" => $detx['engklp'],
                "volume" => 0,
                "nilaiDanaSawit" => 0,
                "kodeJenisEkspor" => "1"
            ];
            $arraytarif = [];
            $barangtarif = [
                // "seriBarang" => $no,
                // "jumlahSatuan" => (int) $jumlah,
                // "kodeFasilitasTarif" => "3",
                // "kodeSatuanBarang" => $detx['kodesatuan'],
                // "nilaiBayar" => 0,
                // "nilaiFasilitas" => round(($detx['harga']*$jumlah)*0.11,0),
                // "nilaiSudahDilunasi" => 0,
                // "tarif" => 11,
                // "tarifFasilitas" => 100,
                // "kodeJenisPungutan" => "PPN",
                // "kodeJenisTarif" => "1"
            ];
            $arraypemilik = [];
            $arrpemilik = [
                'seriEntitas' => 8
            ];
            $jumlahfasilitas += ($detx['harga']*$jumlah)*0.11;
            array_push($arraypemilik,$arrpemilik);
            $arrayke['barangTarif'] = $arraytarif;
            $arrayke['barangPemilik'] = $arraypemilik;
            array_push($arraybarang,$arrayke);
        }
        $arraypungutan = [];
        $pungutanarray = [
            "kodeFasilitasTarif" => "3",
            "kodeJenisPungutan" => "PPN",
            "nilaiPungutan" => round($jumlahfasilitas,0)
        ];
        array_push($arraypungutan,$pungutanarray);
        $arrayBank = [];
        $bankarray = [
            "kodeBank" => "213",
            "seriBank" => 1
        ];
        array_push($arrayBank,$bankarray);
        $datakon = $this->akbmodel->getdatakontainer($id);
        if($datakon->num_rows() > 0){
            $konn = $datakon->row_array();
            $carastuffing = $konn['jenis_kontainer'];
        }else{
            $carastuffing = "7";
        }
        $arrsiapbar = [];
        $arraysiapbarang = [
            "kodeJenisBarang" => "2",
            "kodeJenisGudang" => "2",
            "namaPic" => "MR. AWAN KURNIAWAN",
            "alamat" => "JL. RAYA BANDUNG GARUT KM 25 RT 04 RW 01,\r\nDESA CANGKUANG 004/001 CANGKUANG,\r\nRANCAEKEK, BANDUNG, JAWA BARAT",
            "nomorTelpPic" => "022-7798042",
            "lokasiSiapPeriksa" => "PT. INDONEPTUNE NET MANUFACTURING",
            "tanggalPkb" => $data['tgl_aju'],
            "waktuSiapPeriksa" => (new \DateTime('Asia/Jakarta'))->format(DATE_ATOM),
            "kodeCaraStuffing" => $carastuffing
        ];
        array_push($arrsiapbar,$arraysiapbarang);

        $arrayheader['entitas'] = $arrayentitas;
        $arrayheader['dokumen'] = $arraydokumen;
        $arrayheader['pengangkut'] = $arrangkut;
        $arrayheader['kontainer'] = $arraykonta;
        $arrayheader['kemasan'] = $arrkemas;
        $arrayheader['barang'] = $arraybarang;
        $arrayheader['bankDevisa'] = $arrayBank;
        $arrayheader['kesiapanBarang'] = $arrsiapbar;
        // $arrayheader['pungutan'] = $arraypungutan;
        // echo '<pre>'.json_encode($arrayheader)."</pre>";
        $this->kirim30($arrayheader,$id);
    }
    function kirimdatakeceisa23($id){
        $data = $this->ibmodel->getdatabyid($id);
        $noaju = isikurangnol($data['jns_bc']).'010017'.str_replace('-','',$data['tgl_aju']).$data['nomor_aju'];
        $arrayheader = [
            "asalData" => "S",
            "asuransi" => 0,
            "bruto" => (float) $data['bruto'],
            "cif" => 0,
            "fob" => 0,
            "freight" => 0,
            "hargaPenyerahan" => (float) $data['totalharga'],
            "jabatanTtd" => strtoupper($data['jabat_tg_jawab']),
            "jumlahKontainer" => 0,
            "kodeAsuransi" => "LN",
            "kodeDokumen" => $data['jns_bc'],
            "kodeIncoterm" => "CIF",
            "kodeKantor" => "050500",
            "kodeKantorBongkar" => "040300",
            "kodePelBongkar" => $data['pelabuhan_bongkar'],
            "kodePelMuat"  => $data['pelabuhan_muat'],
            "kodePelTransit" => "",
            "kodeTps" => "NCT1",
            "kodeTujuanTpb" => "1",
            "kodeTutupPu" => "11",
            "kodeValuta" => $data['mt_uang'],
            "kotaTtd" => "BANDUNG",
            "namaTtd" => strtoupper($data['tg_jawab']),
            "ndpbm" => (float) $data['kurs_usd'],
            "netto" => (float) $data['netto'],
            "nik" => "",
            "nilaiBarang" => (float) $data['nilai_pab'],
            "nomorAju" => $noaju,
            "nomorBc11" => $data['bc11'],
            "posBc11" => $data['nomor_posbc11'],
            "seri" => 1,
            "subposBc11" => $data['nomor_posbc11'],
            "tanggalBc11" => $data['tgl_bc11'],
            "tanggalTiba" => $data['tgl'],
            "tanggalTtd" => $data['tgl_aju'],
            "biayaTambahan" => 0,
            "biayaPengurang" => 0,
            "kodeKenaPajak" => "1"
        ];
        $ke=1;
        $arrayentitas = [];
        for($ke=1;$ke<=3;$ke++){
            $alamatifn = "JL RAYA BANDUNG-GARUT KM. 25, CANGKUANG, RANCAEKEK, KAB. BANDUNG, JAWA BARAT, 40394";
            $kodeentitas = $ke==1 ? "3" : (($ke==2) ? "5" : "7");
            if($ke == 3){
                $nomoridentitas = $data['jns_pkp']==1 ? $data['nik'].str_repeat('0',22-(strlen(trim(str_replace('-','',str_replace('.','',$data['nik'])))))) : '0'.$data['npwp'].str_repeat('0',22-(strlen(trim(str_replace('-','',str_replace('.','',$data['npwp']))))+1));
            }else{
                $nomoridentitas = $ke==1 ? "0010017176057000000000" : (($ke==2) ? "0010017176057000000000" : '0'.$data['npwp'].str_repeat('0',22-(strlen(trim(str_replace('-','',str_replace('.','',$data['npwp']))))+1)));
            }
            $namaidentitas = $ke==1 ? "INDONEPTUNE NET MANUFACTURING" : (($ke==2) ? "INDONEPTUNE NET MANUFACTURING" : $data['namasupplier']);
            $alamat = $ke==1 ? $alamatifn : (($ke==2) ? $alamatifn : $data['alamat']);
            $nibidentitas = $ke==1 ? "9120011042693" : "";
            $kodejeniden = $ke==3 ? "4" : "5";
            $arrayke = [
                "seriEntitas" => $ke,
                "alamatEntitas" => $alamat,
                "kodeEntitas" => $kodeentitas,
                "kodeJenisIdentitas" => $kodejeniden,
                "namaEntitas" => trim($namaidentitas),
                "nibEntitas" => $nibidentitas,
                "nomorIdentitas" => trim(str_replace('-','',str_replace('.','',$nomoridentitas))),
                "kodeNegara" => "ID",
                "kodeStatus" => "5"
            ];
            if($ke==2){
                $arrayke["kodeJenisApi"] = "2";
            }
            if($ke == 1){
                $arrayke["nomorIjinEntitas"] = "1555/KM.4/2017";
                $arrayke["tanggalIjinEntitas"] = "2017-07-10";
            }
            array_push($arrayentitas,$arrayke);
        }
        $arraydokumen = [];
        $dokmen = $this->ibmodel->getdatadokumen($id);
        $no = 1;
        foreach ($dokmen->result_array() as $doku) {
            $arrayke = [
                "kodeDokumen" => $doku['kode_dokumen'],
                "nomorDokumen" => $doku['nomor_dokumen'],
                "seriDokumen" => $no++,
                "tanggalDokumen" => $doku['tgl_dokumen']
            ];
            array_push($arraydokumen,$arrayke);
        }
        $arrangkut = [];
        $arrayangkutan = [
            "namaPengangkut" => $data['angkutan'],
            "nomorPengangkut" => $data['no_kendaraan'],
            "seriPengangkut" => 1,
            "kodeBendera" => $data['kode_negara'],
            "kodeCaraAngkut" => $data['jns_angkutan']
        ];
        array_push($arrangkut,$arrayangkutan);
        $arrkemas = [];
        $arraykemasan = [
            "jumlahKemasan" => (int) $data['jml_kemasan'],
            "kodeJenisKemasan" => $data['kd_kemasan'],
            "merkKemasan" => "-",
            "seriKemasan" => 1
        ];
        array_push($arrkemas,$arraykemasan);
        $arraybarang = [];
        $datadet = $this->ibmodel->getdatadetailib($id);
        $no = 0;
        $jumlahfasilitas = 0;
        foreach ($datadet as $detx) {
            $no++;
            $jumlah = $detx['kodesatuan']=='KGS' ? $detx['kgs'] : $detx['pcs'];
            $arrayke = [
                "seriBarang" => $no,
                "asuransi" => 0,
                "cif" => (float) $detx['harga']*$jumlah,
                "diskon" => 0,
                "fob" => 0,
                "freight" => 0,
                "hargaEkspor" => 0,
                "hargaSatuan" => (float) $detx['harga'],
                "bruto" => 0,
                "hargaPenyerahan" => (float) $detx['harga']*$jumlah,
                "jumlahSatuan" => (int) $jumlah,
                "kodeBarang" => $detx['brg_id'],
                "kodeDokumen" => "40",
                "kodeJenisKemasan" => $data['kd_kemasan'],
                "isiPerKemasan" => 0,
                "kodeSatuanBarang" => $detx['satbc'],
                "kodeKategoriBarang" => "11",
                "kodeNegaraAsal" => $data['kodenegara'],
                "kodePerhitungan" => "1",
                "merk" => "-",
                "netto" => (float) $detx['kgs'],
                "nilaiBarang" => 0,
                "nilaiTambah" => 0,
                "posTarif" => trim($detx['nohs']), //Nomor HS
                "spesifikasiLain" => "",
                "tipe" => "-",
                "ukuran" => "",
                "uraian" => "",
                "ndpbm" => (float) $data['kurs_usd'],
                "cifRupiah" => (float) $data['kurs_usd']*$jumlah,
                "hargaPerolehan" => (float) $detx['harga']*$jumlah,
                "kodeAsalBahanBaku" => "0",
                "volume" => 0,
                "jumlahKemasan" => (int) $data['jml_kemasan'],
                "uraian" => trim($detx['nama_barang']),
            ];
            $arraytarif = [];
            $barangtarif = [
                "seriBarang" => $no,
                "jumlahSatuan" => (int) $jumlah,
                "kodeFasilitasTarif" => "3",
                "kodeSatuanBarang" => $detx['kodesatuan'],
                "nilaiBayar" => 0,
                "nilaiFasilitas" => round(($detx['harga']*$jumlah)*0.11,0),
                "nilaiSudahDilunasi" => 0,
                "tarif" => 11,
                "tarifFasilitas" => 100,
                "kodeJenisPungutan" => "BM",
                "kodeJenisTarif" => "1"
            ];
            $jumlahfasilitas += ($detx['harga']*$jumlah)*0.11;
            $arraybarangdokumen = [];
            array_push($arraytarif,$barangtarif);
            $arrayke['barangTarif'] = $arraytarif;
            $arrayke['barangDokumen'] = $arraybarangdokumen;
            array_push($arraybarang,$arrayke);
        }
        $arraypungutan = [];
        $pungutanarray = [
            "kodeFasilitasTarif" => "3",
            "kodeJenisPungutan" => "PPN",
            "nilaiPungutan" => round($jumlahfasilitas,0)
        ];
        array_push($arraypungutan,$pungutanarray);

        $arrayheader['entitas'] = $arrayentitas;
        $arrayheader['dokumen'] = $arraydokumen;
        $arrayheader['pengangkut'] = $arrangkut;
        $arrayheader['kemasan'] = $arrkemas;
        $arrayheader['barang'] = $arraybarang;
        $arrayheader['pungutan'] = $arraypungutan;
        // echo '<pre>'.json_encode($arrayheader)."</pre>";
        $this->kirim40($arrayheader,$id);
    }
    public function kirim30($data,$id){
        $token = $this->akbmodel->gettoken();
        $curl = curl_init();
        // $token = $consID;
        $headers = array(
            "Content-Type: application/json",
            "Authorization: Bearer ".$token,
        );

        curl_setopt($curl, CURLOPT_HTTPHEADER,$headers);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_URL, 'https://apis-gw.beacukai.go.id/openapi/document');
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $result = curl_exec($curl);
        curl_close($curl);

        $databalik = json_decode($result,true);
        // print_r($databalik);
        if($databalik['status']=='OK'){
            $this->helpermodel->isilog("Kirim dokumen CEISA 40 BERHASIL".$data['nomorAju']);
            $this->session->set_flashdata('errorsimpan',2);
            $this->session->set_flashdata('pesanerror',$databalik['message']);
            $this->akbmodel->updatesendceisa($id);
            $url = base_url().'akb/isidokbc/'.$id;
            redirect($url);
        }else{
            // print_r($databalik);
            $this->session->set_flashdata('errorsimpan',1);
            $this->session->set_flashdata('pesanerror',$databalik['message'][0].'[EXCEPTION]'.$databalik['exception']);
            $url = base_url().'akb/isidokbc/'.$id;
            redirect($url);
        }
    }

    public function getnomoraju(){
        $jns = $_POST['jns'];
        $hasil = $this->ibmodel->getnomoraju($jns);
        echo json_encode($hasil);
    }
    public function getdoklampiran(){
        $id = $_POST['id'];
        $bc = $_POST['bc'];
        $query = $this->ibmodel->getdatadokumen($id);
        $arrdok = [];
        foreach($query->result_array() as $que){
            array_push($arrdok,$que['kode_dokumen']);
        }
        $hasil = 1;
        if($bc == 40){
            if(count($arrdok) > 0){
                $hasil = 1;
            }else{
                $hasil = 'Lengkapi Lampiran Dokumen';
            }
        }
        if($bc == 23){
            if(count($arrdok) > 0){
                if(in_array('380',$arrdok) && (in_array('740',$arrdok) || in_array('705',$arrdok))){
                    $hasil = 1;
                }else{
                    $hasil = 'Dokumen Invoice, BL/AWB Belum di input';
                }
            }else{
                $hasil = 'Lengkapi Lampiran Dokumen';
            }
        }
        echo $hasil;
    }
    //End IB Controller
  
    function cetakqr2($isi, $id)
    {
        $tempdir = "temp/";
        $namafile = $id;
        $codeContents = $isi;
        QRcode::png($codeContents, $tempdir . $namafile . '.png', QR_ECLEVEL_L, 4, 1);
        return $tempdir . $namafile;
    }
    public function cetakbon($id)
    {
        $pdf = new PDF('P', 'mm', 'A4');
        $pdf->AliasNbPages();
        // $pdf->setMargins(5,5,5);
        $pdf->AddFont('Lato', '', 'Lato-Regular.php');
        $pdf->AddFont('Latob', '', 'Lato-Bold.php');
        // $pdf->SetFillColor(7,178,251);
        $pdf->SetFont('Latob', '', 12);
        // $isi = $this->jualmodel->getrekap();
        $pdf->SetFillColor(205, 205, 205);
        $pdf->AddPage();
        $pdf->Image(base_url() . 'assets/image/ifnLogo.png', 14, 10, 22);
        $pdf->Cell(30, 18, '', 1);
        $pdf->SetFont('Latob', '', 18);
        $pdf->Cell(120, 18, 'BON PERPINDAHAN', 1, 0, 'C');
        $pdf->SetFont('Lato', '', 10);
        $pdf->Cell(14, 6, 'No Dok', 'T');
        $pdf->Cell(2, 6, ':', 'T');
        $pdf->Cell(24, 6, 'FM-GD-05', 'TR');
        $pdf->ln(6);
        $pdf->Cell(150, 6, '', 0);
        $pdf->Cell(14, 6, 'Revisi', 'T');
        $pdf->Cell(2, 6, ':', 'T');
        $pdf->Cell(24, 6, '1', 'TR');
        $pdf->ln(6);
        $pdf->Cell(150, 6, '', 0);
        $pdf->Cell(14, 6, 'Tanggal', 'TB');
        $pdf->Cell(2, 6, ':', 'TB');
        $pdf->Cell(24, 6, '11-04-2007', 'TRB');
        $pdf->ln(6);
        $pdf->Cell(190, 1, '', 1, 0, '', 1);
        $pdf->ln(1);
        $header = $this->out_model->getdatabyid($id);
        $isi = 'Nobon ' . $header['nomor_dok'] . "\r\n" . 'Dikeluarkan Oleh : ' . datauser($header['user_ok'], 'name') . '@' . "\r\n" . tglmysql2($header['tgl_ok']);
        $isi .= "\r\n" . 'Diterima Oleh : ' . datauser($header['user_tuju'], 'name') . '@' . "\r\n" . tglmysql2($header['tgl_tuju']);
        $qr = $this->cetakqr2($isi, $header['id']);
        $pdf->Image($qr . ".png", 177, 30, 18);
        $pdf->SetFont('Lato', '', 10);
        $pdf->Cell(18, 5, 'Nomor', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['nomor_dok'], 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(82, 5, 'Diperiksa & Disetujui Oleh', 'RB', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Dept', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, $header['departemen'], 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(82, 5, substr(datauser($header['user_tuju'], 'name'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(28, 5, '', 'R', 0);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(18, 5, 'Tanggal', 'L', 0);
        $pdf->Cell(2, 5, ':', 0, 0);
        $pdf->Cell(60, 5, tglmysql($header['tgl']), 'R', 0);
        $pdf->SetFont('Latob', '', 9);
        $pdf->Cell(82, 5, substr(datauser($header['user_tuju'], 'jabatan'), 0, 20), 'R', 0);
        $pdf->SetFont('Lato', '', 9);
        $pdf->Cell(28, 5, '', 'R', 1);
        $pdf->Cell(80, 5, '', 'LBR', 0);
        $pdf->Cell(82, 5, '', 'BR', 0);
        $pdf->Cell(28, 5, '', 'BR', 1);
        $pdf->Cell(190, 1, '', 1, 1, '', 1);
        $pdf->Cell(6, 8, 'No', 'LRB', 0, 'C');
        $pdf->SetFont('Lato', '', 8);
        $pdf->Cell(17, 4, 'Nomor PO/', 'LR', 0, 'C');
        $pdf->Cell(7, 4, 'No', 'LR', 0, 'C');
        $pdf->Cell(7, 4, 'No', 'LR', 0, 'C');
        $pdf->Cell(80, 8, 'Spesifikasi Barang', 'LRB', 0, 'C');
        $pdf->Cell(8, 4, 'No.', 'LR', 0, 'C');
        $pdf->Cell(16, 4, 'Pcs/', 'LR', 0, 'C');
        $pdf->Cell(16, 4, 'Total', 'LR', 0, 'C');
        $pdf->Cell(33, 8, 'Keterangan', 'LRB', 0, 'C');
        $pdf->ln(4);
        $pdf->Cell(6, 4, '', 0);
        $pdf->Cell(17, 4, 'No Instruksi', 'RB', 0, 'C');
        $pdf->Cell(7, 4, 'Lot', 'RB', 0, 'C');
        $pdf->Cell(7, 4, 'Mc', 'B', 0, 'C');
        $pdf->Cell(80, 4, '', 0);
        $pdf->Cell(8, 4, 'Bale', 'RB', 0, 'C');
        $pdf->Cell(16, 4, 'Pack', 'RB', 0, 'C');
        $pdf->Cell(16, 4, 'Kgs', 'RB', 1, 'C');
        $detail = $this->out_model->getdatadetailout($id);
        $no = 1;
        foreach ($detail as $det) {
            $jumlah = $det['pcs'] == null ? $det['kgs'] : $det['pcs'];
            $pdf->Cell(6, 6, $no++, 'LRB', 0);
            $pdf->Cell(17, 6, '', 'LRB', 0);
            $pdf->Cell(7, 6, '', 'LRB', 0);
            $pdf->Cell(7, 6, '', 'LRB', 0);
            $pdf->Cell(80, 6, $det['nama_barang'], 'LBR', 0);
            $pdf->Cell(8, 6, '', 'LRB', 0);
            $pdf->Cell(16, 6, rupiah($det['pcs'], 0), 'LRB', 0, 'R');
            $pdf->Cell(16, 6, rupiah($det['kgs'], 0), 'LBR', 0, 'R');
            $pdf->Cell(33, 6, $det['keterangan'], 'LBR', 1, 'R');
        }
        $pdf->ln(2);
        $pdf->SetFont('Lato', '', 8);
        $pdf->Cell(15, 5, 'Catatan : ', 0);
        $pdf->Cell(19, 5, 'Dokumen ini sudah ditanda tangani secara digital', 0);
        $pdf->Output('I', 'FM-GD-05.pdf');
    }
    public function uploaddok($id){
        $data['data'] = $this->akbmodel->getdatabyid($id);
        $data['actiondok'] = base_url().'ib/simpandokumen';
        $this->load->view('ib/uploaddok',$data);
    }
    public function simpandokumen(){
        $this->ibmodel->updatedok();
    }
    public function caripelabuhan(){
        $datacari = $_GET['search'];
        $hasil = $this->ibmodel->getpelabuhanbykode($datacari);

        if($hasil){
            $dataar = [];
            foreach ($hasil->result_array() as $key) {
                $data['id'] = $key['kode_pelabuhan'];
                $data['text'] = $key['kode_pelabuhan'].' - '.$key['uraian_pelabuhan'];
                array_push($dataar,$data);
            }
        }
        echo json_encode($dataar);
    }
}
