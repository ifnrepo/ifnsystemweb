<?php
class Ib_model extends CI_Model
{
    public function getdata($kode)
    {
        $arrkondisi = [
            'id_perusahaan' => IDPERUSAHAAN,
            'kode_dok' => 'IB',
            'dept_tuju' => $kode,
            'month(tgl)' => $this->session->userdata('bl'),
            'year(tgl)' => $this->session->userdata('th')
        ];
        $this->db->select('tb_header.*,supplier.nama_supplier as namasupplier');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->where($arrkondisi);
        $this->db->order_by('tgl','desc');
        $this->db->order_by('nomor_dok','desc');
        $hasil = $this->db->get('tb_header');
        return $hasil->result_array();
    }
    public function getdatabyid($kode)
    {
        $this->db->select('tb_header.*,supplier.nama_supplier as namasupplier,supplier.alamat,supplier.kontak,supplier.npwp,supplier.nik,supplier.jns_pkp,supplier.nama_di_ceisa as namaceisa,supplier.alamat_di_ceisa as alamatceisa,supplier.kode_negara as kodenegara,ref_mt_uang.mt_uang,ref_jns_angkutan.angkutan as angkutlewat,ref_negara.kode_negara');
        $this->db->select("(select uraian_pelabuhan from ref_pelabuhan where ref_pelabuhan.kode_pelabuhan = tb_header.pelabuhan_muat) as pelmuat");
        $this->db->select("(select uraian_pelabuhan from ref_pelabuhan where ref_pelabuhan.kode_pelabuhan = tb_header.pelabuhan_bongkar) as pelbongkar");
        $this->db->join('dept', 'dept.dept_id=tb_header.dept_id', 'left');
        $this->db->join('supplier', 'supplier.id=tb_header.id_pemasok', 'left');
        $this->db->join('ref_mt_uang', 'ref_mt_uang.id=tb_header.mtuang', 'left');
        $this->db->join('ref_jns_angkutan', 'ref_jns_angkutan.id=tb_header.jns_angkutan', 'left');
        $this->db->join('ref_negara', 'ref_negara.id=tb_header.bendera_angkutan', 'left');
        $query = $this->db->get_where('tb_header', ['tb_header.id' => $kode]);
        return $query->row_array();
    }
    public function getdatadetailib($data)
    {
        $this->db->select("a.*,b.namasatuan,g.spek,b.kodesatuan,b.kodebc as satbc,c.kode,c.nama_barang,c.nohs,c.kode as brg_id,e.keterangan as keter,d.pcs as pcsmintaa,d.kgs as kgsmintaa,f.nama_kategori,f.kategori_id");
        $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
        $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
        $this->db->from('tb_detail a');
        $this->db->join('satuan b', 'b.id = a.id_satuan', 'left');
        $this->db->join('barang c', 'c.id = a.id_barang', 'left');
        $this->db->join('tb_detail d', 'a.id = d.id_ib', 'left');
        $this->db->join('tb_detail e', 'd.id = e.id_bbl', 'left');
        $this->db->join('kategori f', 'f.kategori_id = c.id_kategori', 'left');
        $this->db->join('tb_po g', 'g.po = a.po AND g.item = a.item AND g.dis = a.dis', 'left');
        $this->db->where('a.id_header', $data);
        return $this->db->get()->result_array();
    }
    public function getdepttuju($kode)
    {
        $xkode = [];
        $hasil = [];
        $query = $this->db->get_where('dept', ['dept_id' => $kode])->row_array();
        if ($query) {
            for ($x = 0; $x <= strlen($query['pengeluaran']) / 2; $x++) {
                if (substr($query['pengeluaran'], ($x * 2) - 2, 2) != $kode) {
                    array_push($xkode, substr($query['pengeluaran'], ($x * 2) - 2, 2));
                }
            }
            $this->db->where_in('dept_id', $xkode);
            $this->db->order_by('departemen', 'asc');
            $hasil = $this->db->get('dept');
        }
        return $hasil;
    }
    public function getbon($kode)
    {
        $this->db->where($kode);
        $query = $this->db->get('tb_header');
        return $query->result_array();
    }
    public function getnomorib($bl, $th)
    {
        $hasil = $this->db->query("SELECT MAX(SUBSTR(nomor_dok,14,3)) AS maxkode FROM tb_header 
        WHERE kode_dok = 'IB' AND MONTH(tgl)='" . $bl . "' AND YEAR(tgl)='" . $th . "' AND dept_tuju = '" . $this->session->userdata('depttuju') . "' ")->row_array();
        return $hasil;
    }
    public function tambahdataib()
    {
        $this->db->trans_start();
        $date = $this->session->userdata('th') . '-' . $this->session->userdata('bl') . '-' . date('d');
        $nomordok = nomorib();
        $tambah = [
            'id_perusahaan' => IDPERUSAHAAN,
            'kode_dok' => 'IB',
            'dept_id' => 'SU',
            'dept_tuju' => $this->session->userdata('depttuju'),
            'nomor_dok' => $nomordok,
            'tgl' => $date
        ];
        $this->db->insert('tb_header', $tambah);
        $hasil = $this->db->insert_id();
        $this->helpermodel->isilog($this->db->last_query());
        $this->db->trans_complete();
        return $hasil;
    }
    public function hapusib($id)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $query = $this->db->get('tb_header')->row_array();
        if ($query) {
            $this->db->where('id_header', $id);
            $cekdetail = $this->db->get('tb_detail')->result_array();
            foreach ($cekdetail as $cekdata) {
                $this->db->where('id_ib', $cekdata['id']);
                $this->db->update('tb_detail', ['id_ib' => 0]);
            }
            $this->db->where('id_header', $id);
            $this->db->delete('tb_detmaterial');
            $this->db->where('id_header', $id);
            $this->db->delete('tb_detail');
        }
        $this->db->where('id', $id);
        $this->db->delete('tb_header');
        $this->helpermodel->isilog($this->db->last_query());
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function updatebykolom($data)
    {
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_header', $data);
        return $hasil;
    }
    public function updatekolom($tabel, $data, $kolom)
    {
        $this->db->where($kolom, $data['id_header']);
        unset($data['id_header']);
        $hasil = $this->db->update($tabel, $data);
        return $hasil;
    }
    public function getbarangib($sup=''){
        $this->db->select('tb_detail.*,tb_detail.id as iddetbbl,a.nomor_dok as nodok,b.nama_barang,d.dept_id,e.kodesatuan');
        $this->db->select('(select sum(pcs) from tb_detail z where z.po_id = tb_detail.id) as pcssudahterima');
        $this->db->select('(select sum(kgs) from tb_detail z where z.po_id = tb_detail.id) as kgssudahterima');
        $this->db->from('tb_detail');
        $this->db->join('tb_header a','a.id = tb_detail.id_header','left');
        $this->db->join('barang b','b.id = tb_detail.id_barang','left');
        $this->db->join('tb_detail c','c.id_po = tb_detail.id','left'); 
        $this->db->join('tb_header d','d.id = c.id_header','left'); 
        $this->db->join('satuan e','e.id = b.id_satuan','left');
        $this->db->where('a.id_perusahaan',IDPERUSAHAAN);
        $this->db->where('a.data_ok',1);
        $this->db->where('a.ok_valid',1);
        $this->db->where('a.ok_tuju',0);
        $this->db->where('a.ok_pp',0);
        $this->db->where('a.ok_pc',0);
        $this->db->where('a.kode_dok','PO');
        // $this->db->where('tb_detail.id_ib',0);
        $this->db->where('tb_detail.id_po',0);
        $this->db->where('a.id_pemasok',$sup);
        $this->db->where('d.dept_id',$this->session->userdata('depttuju'));
        return $this->db->get();
    }
    public function getbarangibl()
    {
        $this->db->select('*,tb_detail.id as iddetbbl');
        $this->db->from('tb_detail');
        $this->db->join('tb_header a','a.id = tb_detail.id_header','left');
        $this->db->join('barang b','b.id = tb_detail.id_barang','left');
        $this->db->where('a.id_perusahaan',IDPERUSAHAAN);
        $this->db->where('a.data_ok',1);
        $this->db->where('a.ok_valid',1);
        $this->db->where('a.ok_tuju',1);
        $this->db->where('a.ok_pp',1);
        $this->db->where('a.ok_pc',1);
        $this->db->where('a.kode_dok','BBL');
        $this->db->where('id_ib',0);
        $this->db->where('id_po',0);
        $this->db->where('a.dept_id',$this->session->userdata('depttuju'));
        return $this->db->get();
    }

    public function adddetailib($data)
    {
        $jumlah = count($data['data']);
        $id = $data['id'];
        $this->db->trans_start();
        for ($x = 0; $x < $jumlah; $x++) {
            $arrdat = $data['data'];
            $detail = $this->db->where('id', $arrdat[$x])->get('tb_detail')->row_array();
            $header = $this->db->where('id',$detail['id_header'])->get('tb_header')->row_array();
            $headerx = $this->db->where('id',$id)->get('tb_header')->row_array();
            $isi = [
                'id_header' => $id,
                'seri_barang' => $x,
                'id_barang' => $detail['id_barang'],
                'id_satuan' => $detail['id_satuan'],
                'kgs' => $detail['kgs'],
                'pcs' => $detail['pcs'],
                'harga' => $detail['harga'],
                'nobontr' => $headerx['nomor_dok'],
                'po_id' => $arrdat[$x]
            ];
            $this->db->insert('tb_detail', $isi);
            $idsimpan = $this->db->insert_id();
            $this->db->where('id', $arrdat[$x])->update('tb_detail', ['id_ib' => $idsimpan]);
            $this->helpermodel->isilog($this->db->last_query());
            $itembarang = $this->db->where('id_header', $id)->get('tb_detail')->num_rows();
            $this->db->where('id', $id)->update('tb_header', ['jumlah_barang' => $itembarang]);
        }
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function hapusdetailib($id)
    {
        $detail = $this->db->where('id_ib', $id)->get('tb_detail')->row_array();
        $xdetail = $this->db->where('id', $id)->get('tb_detail')->row_array();
        $this->db->trans_start();
        $this->db->where('id', $detail['id']);
        $this->db->update('tb_detail', ['id_ib' => 0]);
        $this->db->where('id', $id);
        $this->db->delete('tb_detail');
        $this->helpermodel->isilog($this->db->last_query());
        $itembarang = $this->db->where('id_header', $xdetail['id_header'])->get('tb_detail')->num_rows();
        $this->db->where('id', $xdetail['id_header'])->update('tb_header', ['jumlah_barang' => $itembarang]);
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function getdetailibbyid($data)
    {
        $this->db->select("a.*,b.namasatuan,b.kodesatuan,c.kode,c.nama_barang,c.kode as brg_id,d.jn_ib");
        $this->db->from('tb_detail a');
        $this->db->join('satuan b', 'b.id = a.id_satuan', 'left');
        $this->db->join('barang c', 'c.id = a.id_barang', 'left');
        $this->db->join('tb_header d', 'd.id = a.id_header', 'left');
        $this->db->where('a.id', $data);
        return $this->db->get()->row_array();
    }
    public function getdokbcmasuk(){
        $this->db->where('masuk',1);
        $hasil = $this->db->get('ref_dok_bc');
        return $hasil;
    }
    public function cekhargabarang($id){
        $this->db->where('id_header',$id);
        $this->db->where('harga',0);
        return $this->db->get('tb_detail')->num_rows();
    }
    public function getdatacekbc(){
        $kondisi = [
            'data_ok' => 1,
            'ok_tuju' => 0,
            'kode_dok' => 'IB'
        ];
        $this->db->where($kondisi);
        return $this->db->get('tb_header');
    }
    public function simpandatabc($data,$head){
        if($data==1){
           $kondisi = [
                'ok_tuju' => 1,
                'user_tuju' => $this->session->userdata('id'),
                'tgl_tuju' => date('Y-m-d H:i:s'),
            ];
            $this->db->where('id',$head);
            return $this->db->update('tb_header',$kondisi);
        }else{
            $kondisi = [
                'ok_tuju' => 1,
                'tanpa_bc' => 1,
                'user_tuju' => $this->session->userdata('id'),
                'tgl_tuju' => date('Y-m-d H:i:s'),
            ];
            $this->db->where('id',$head);
            return $this->db->update('tb_header',$kondisi);
        }
    }
    public function updateib($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        $this->helpermodel->isilog($this->db->last_query());
        return $query;
    }
    public function getbcmasuk(){
        $this->db->where('masuk',1);
        return $this->db->get('ref_dok_bc');
    }
    public function simpandatanobc(){
        $data = [
            'id' => $_POST['id'],
            'jns_bc' => $_POST['jns'],
            'nomor_aju' => $_POST['aju'],
            'tgl_aju' => tglmysql($_POST['tglaju']),
            'nomor_bc' => $_POST['bc'],
            'tgl_bc' => tglmysql($_POST['tglbc']),
            'ok_tuju' => 1,
            'user_tuju' => $this->session->userdata('id'),
            'tgl_tuju' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_header',$data);
        $this->helpermodel->isilog($this->db->last_query());
        return $hasil;
    }
    public function getjnsangkutan(){
       return $this->db->order_by('id')->get('ref_jns_angkutan');
    }
    public function refkemas(){
       return $this->db->order_by('kdkem')->get('ref_kemas');
    }
    public function updatepcskgs($data){
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_detail',$data);
        return $hasil;
    }
    public function cekdetail($id){
        $cekarr = [
            'xharga' => 0,
            'xkgs' => 0,
            'xpcs' => 0,
            'totalharga' => 0,
            'kgs' => 0.00
        ];
        $qry = $this->db->where('id_header',$id)->get('tb_detail');
        foreach ($qry->result_array() as $isidata) {
            if($isidata['harga']==0){
                $cekarr['xharga']++;
            }
            if($isidata['kgs']==0){
                $cekarr['xkgs']++;
            }else{
                $cekarr['kgs'] += $isidata['kgs'];
            }
            if($isidata['pcs']==0){
                $cekarr['totalharga'] += $isidata['kgs']*$isidata['harga'];
            }else{
                $cekarr['totalharga'] += $isidata['pcs']*$isidata['harga'];
            }
        }
        // $this->db->select("*,sum(if(harga=0,1,0)) AS xharga,sum(if(pcs=0,kgs,pcs)*harga) AS totalharga");
        // $this->db->from('tb_detail');
        // $this->db->where('id_header',$id);
        // return $this->db->get()->row_array();
        return $cekarr;
    }
    public function simpanib($data)
    {
        $jumlahrek = $this->db->get_where('tb_detail', ['id_header' => $data['id']])->num_rows();
        $data['jumlah_barang'] = $jumlahrek;
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }
    public function cekfield($id,$kolom,$nilai){
        $this->db->where('id',$id);
        $this->db->where($kolom,$nilai);
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }
    public function editib($data){
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_header',$data);
        return $hasil;
    }
    public function refmtuang(){
        return $this->db->order_by('id')->get('ref_mt_uang');
    }
    public function getjenisdokumen(){
        return $this->db->order_by('kode')->get('ref_jns_dokumen');
    }
    public function refbendera(){
        return $this->db->order_by('uraian_negara')->get('ref_negara');
    }
    public function refpelabuhan(){
        return $this->db->order_by('kode_pelabuhan')->get('ref_pelabuhan');
    }
    public function getpelabuhanbykode($kode){
        $this->db->like('kode_pelabuhan',$kode);
        $this->db->or_like('uraian_pelabuhan',$kode);
        return $this->db->get('ref_pelabuhan');
    }
    public function getdatalampiran($id){
        $this->db->select('lampiran.*,lampiran.id as idx,ref_jns_dokumen.nama_dokumen');
        $this->db->from('lampiran');
        $this->db->join('ref_jns_dokumen','ref_jns_dokumen.kode = lampiran.kode_dokumen','left');
        $this->db->where('id_header',$id);
        return $this->db->get();
    }
    public function getdatalampiranbyid($id){
        $this->db->select('lampiran.*,lampiran.id as idx,ref_jns_dokumen.nama_dokumen');
        $this->db->from('lampiran');
        $this->db->join('ref_jns_dokumen','ref_jns_dokumen.kode = lampiran.kode_dokumen','left');
        $this->db->where('lampiran.id',$id);
        return $this->db->get();
    }
    public function tambahlampiran($data){
        return $this->db->insert('lampiran',$data);
    }
    public function updatelampiran($data){
        $this->db->where('id',$data['id']);
        return $this->db->update('lampiran',$data);
    }
    public function hapuslampiran($id){
        $this->db->where('id',$id);
        return $this->db->delete('lampiran');
    }
    public function getdatadokumen($id){
        return $this->db->get_where('lampiran',['id_header'=>$id]);
    }
    public function getdatanomoraju($id){
        $detail = $this->db->get_where('tb_header',['id'=>$id])->row_array();
        $kodeaju = str_repeat('0',6-strlen(trim($detail['jns_bc']))).trim($detail['jns_bc']);
        return $kodeaju.'010017'.str_replace('-','',$detail['tgl_aju']).$detail['nomor_aju'];
    }
    public function isitokenbc($data){
        $this->db->where('id',1);
        $this->db->update('token_bc',$data);
    }
    public function gettokenbc(){
        return $this->db->get('token_bc');
    }
    public function getnomoraju($jns){
        $hass = $this->db->get_where('tb_ajuceisa',['jns_bc' => $jns])->row_array();
        $this->helpermodel->isilog("Isi Nomor Aju Otomatis dengan Nomor ".$hass['nomor_aju']);
        $urut = (int) $hass['nomor_aju'];
        $urut++;
        $isi = sprintf("%06s", $urut);
        $this->db->where('jns_bc',$jns);
        $this->db->update('tb_ajuceisa',['nomor_aju' => $isi]);
        return $hass['nomor_aju'];
    }
    public function updatesendceisa($id){
        $this->db->where('id',$id);
        $this->db->update('tb_header',['send_ceisa' => 1]);
    }
    public function updatebc11($data){
        $caribendera = $this->db->get_where('ref_negara',['kode_negara' => $data['bendera_angkutan']])->row_array();
        $data['bendera_angkutan'] = $caribendera['id'];
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_header',$data);
        return $hasil;
    }
    public function simpanresponbc($data){
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_header',$data);
        return $hasil;
    }
    public function gettoken(){
        $query = $this->db->get_where('token_bc',['id'=>1])->row_array();
        return $query['token'];
    }
    public function tambahkontainer($data){
        return $this->db->insert('tb_kontainer',$data);
    }
    public function getdatakontainer($id){
        $this->db->select('tb_kontainer.*,ref_ukuran_kontainer.uraian_kontainer as ukurkontainer,ref_jenis_kontainer.uraian_jenis_kontainer as jeniskontainer');
        $this->db->join('ref_ukuran_kontainer','ref_ukuran_kontainer.ukuran_kontainer = tb_kontainer.ukuran_kontainer','left');
        $this->db->join('ref_jenis_kontainer','ref_jenis_kontainer.jenis_kontainer = tb_kontainer.jenis_kontainer','left');
        $this->db->where('tb_kontainer.id_header',$id);
        return $this->db->get('tb_kontainer');
    }
    public function hapuskontainer($id){
        $this->db->where('id',$id);
        return $this->db->delete('tb_kontainer');
    }
    public function getdataentitas($id){
        $this->db->select('tb_entitas.*,ref_negara.uraian_negara as negara,ref_negara.kode_negara as kodenegara');
        $this->db->join('ref_negara','ref_negara.id = tb_entitas.kode_negara','left');
        $this->db->where('tb_entitas.id_header',$id);
        $this->db->order_by('tb_entitas.kode_entitas');
        return $this->db->get('tb_entitas');
    }
    public function tambahentitas($data){
        return $this->db->insert('tb_entitas',$data);
    }
    public function hapusenti($id){
        $this->db->where('id',$id);
        return $this->db->delete('tb_entitas');
    }
    //End IB Models
    public function updatepo($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }







    public function updatedetail($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_detail', $data);
        return $query;
    }
    public function updatesupplier($data)
    {
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_header', ['id_pemasok' => $data['id_supplier']]);
        return $hasil;
    }


    public function updatehargadetail($data)
    {
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_detail', $data);
        return $hasil;
    }
    public function simpanpo($data)
    {
        $jumlahrek = $this->db->get_where('tb_detail', ['id_header' => $data['id']])->num_rows();
        $data['jumlah_barang'] = $jumlahrek;
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }
    public function editpo($data)
    {
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_header', $data);
        return $hasil;
    }
    public function resetdetail($id)
    {
        $this->db->trans_start();
        $que1 = $this->db->get_where('tb_detail', ['id_header' => $id])->result_array();
        foreach ($que1 as $data1) {
            $cek = $this->db->get_where('tb_detail', ['id' => $data1['id_minta']])->row_array();
            $data = [
                'pcs' => $cek['pcs'],
                'kgs' => $cek['kgs'],
                'tempbbl' => null
            ];
            $this->db->where('id', $data1['id']);
            $this->db->update('tb_detail', $data);
        }
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function simpanheaderout($id)
    {
        $iniquery = false;
        $this->db->trans_begin();
        $datadetail = $this->db->get_where('tb_detail', ['id_header' => $id])->result_array();
        $no = 0;
        foreach ($datadetail as $datdet) {
            if ($this->session->userdata('deptsekarang') == 'GM') {
                if ($datdet['nobontr'] == '') {
                    $iniquery = true;
                    $this->session->set_flashdata('errornya', 'Nobontr Kosong');
                    break;
                }
            }
            $no++;
            $kondisi = [
                'id_barang' => $datdet['id_barang'],
                'periode' => kodebulan($this->session->userdata('bl')) . $this->session->userdata('th'),
                'dept_id' => $this->session->userdata('deptsekarang')
            ];
            $this->db->select('stokdept.*,sum(stokdept.pcs_akhir) as xpcs_akhir,sum(stokdept.kgs_akhir) as xkgs_akhir');
            $this->db->from('stokdept');
            $this->db->where($kondisi);
            $cekdata = $this->db->get();
            // $cekdata = $this->db->get_where('stokdept',$kondisi);
            $jmll = $cekdata->num_rows();
            $deta = $cekdata->row_array();
            if ($datdet['pcs'] > 0 || $datdet['kgs'] > 0) {
                if ((($deta['xpcs_akhir'] >= $datdet['pcs']) || ($deta['xkgs_akhir'] >= $datdet['kgs'])) && $jmll > 0) {
                    $pcsnya = $datdet['pcs'] > 0 ? $datdet['pcs'] : $datdet['kgs'];
                    $pcsasli = $datdet['pcs'];
                    $kgsasli = $datdet['kgs'];
                    $loopke = 0;
                    do {
                        $loopke += 1;
                        $where = "id_barang = " . $datdet['id_barang'] . " AND periode = '" . kodebulan($this->session->userdata('bl')) . $this->session->userdata('th') . "' AND 
                        (pcs_akhir > 0 OR kgs_akhir > 0)";
                        $this->db->where($where);
                        $arrstokdept = $this->db->order_by('tgl,urut')->get('stokdept')->row_array();
                        $nobontr = $this->session->userdata('currdept') == 'GS' ? $arrstokdept['nobontr'] : $datdet['nobontr'];
                        $stokid = $arrstokdept['id'];
                        if (($pcsasli > $arrstokdept['pcs_akhir']) || ($kgsasli > $arrstokdept['kgs_akhir'])) {
                            $kurangpcs = $arrstokdept['pcs_akhir'];
                            $kurangkgs = $arrstokdept['kgs_akhir'];
                        } else {
                            $kurangpcs = $pcsasli;
                            $kurangkgs = $kgsasli;
                        }
                        // update kgs_akhir di tabel stokdept
                        $this->db->set('pcs_keluar', 'pcs_keluar + ' . $kurangpcs, FALSE);
                        $this->db->set('kgs_keluar', 'kgs_keluar + ' . $kurangkgs, FALSE);
                        $this->db->set('pcs_akhir', 'pcs_akhir-' . $kurangpcs, FALSE);
                        $this->db->set('kgs_akhir', 'kgs_akhir-' . $kurangkgs, FALSE);
                        $this->db->where('id', $stokid);
                        $this->db->update('stokdept');

                        $pcsasli -= $kurangpcs;
                        $kgsasli -= $kurangkgs;

                        if ($loopke > 1) {
                            // insert ke tabel detail apabila stokdept menguragi 2 rekord
                            unset($datdet['id']);
                            $this->db->insert('tb_detail', $datdet);
                            $idinsert = $this->db->insert_id();
                            $this->db->set('id_stokdept', $stokid);
                            $this->db->set('nobontr', $nobontr);
                            $this->db->set('pcs', $kurangpcs);
                            $this->db->set('kgs', $kurangkgs);
                            $this->db->where('id', $idinsert);
                            $this->db->update('tb_detail');
                        } else {
                            // update id_stokdept di tabel detail 
                            $this->db->set('id_stokdept', $stokid);
                            $this->db->set('nobontr', $nobontr);
                            $this->db->set('pcs', $kurangpcs);
                            $this->db->set('kgs', $kurangkgs);
                            $this->db->where('id', $datdet['id']);
                            $this->db->update('tb_detail');
                        }
                        $pcskurangi = $datdet['pcs'] > 0 ? $kurangpcs : $kurangkgs;
                        $pcsnya -= $pcskurangi;
                    } while ($pcsnya > 0);
                } else {
                    $iniquery = true;
                    $this->session->set_flashdata('errornya', $no);
                    break;
                }
                // if($deta['pcs_akhir'] >= $datdet['pcs'] && $deta['pcs_akhir'] > 0 && $jmll > 0){
                //     $this->db->set('pcs_keluar','pcs_keluar + '.$datdet['pcs'],FALSE);
                //     $this->db->set('kgs_keluar','kgs_keluar + '.$datdet['kgs'],FALSE);
                //     $this->db->set('pcs_akhir','(pcs_akhir-pcs_masuk)-(pcs_keluar + '.$datdet['pcs'].')',FALSE);
                //     $this->db->set('kgs_akhir','(kgs_akhir-kgs_masuk)-(kgs_keluar + '.$datdet['kgs'].')',FALSE);
                //     $this->db->where($kondisi);
                //     $this->db->update('stokdept');
                // }else{
                //     $iniquery = true;
                //     $this->session->set_flashdata('errornya',$no);
                //     break;
                // }
            }
        }
        // Cek data temp yang akan dibuat BBL
        $datacekbbl = $this->db->get_where('tb_detail', ['id_header' => $id, 'tempbbl' => 1]);
        if ($datacekbbl->num_rows() > 0) {
            $this->db->select('id_perusahaan,kode_dok,dept_id,dept_tuju,nomor_dok,tgl,data_ok,ok_tuju,ok_valid,tgl_ok,tgl_tuju,user_ok,user_tuju');
            $this->db->from('tb_header');
            $this->db->where('id_keluar', $id);
            $isiheader = $this->db->get();
            $hasilheader = $this->db->insert_batch('tb_header', $isiheader->result_array());
            $idheader = $this->db->insert_id();
            $xisiheader = $isiheader->row_array();
            $this->db->where('id', $idheader);
            $this->db->update('tb_header', ['nomor_dok' => $xisiheader['nomor_dok'] . '-A']);
            foreach ($datacekbbl->result_array() as $bbl) {
                $isidetail = $this->db->get_where('tb_detail', ['id' => $bbl['id_minta']])->row_array();
                $bbl['id'] = null;
                $this->db->insert('tb_detail', $bbl);
                $iddetail = $this->db->insert_id();
                $this->db->set('id_header', $idheader);
                $this->db->set('pcs', $isidetail['pcs'] . '- pcs', FALSE);
                $this->db->set('kgs', $isidetail['kgs'] . '- kgs', FALSE);
                $this->db->where('id', $iddetail);
                $this->db->update('tb_detail');
            }
        }
        //Hapus data detail awal yang pcs nya 0 dan masuk ke A
        $this->db->where('id_header', $id);
        $this->db->where('pcs', 0);
        $this->db->where('kgs', 0);
        $this->db->delete('tb_detail');

        if ($this->db->trans_status() === FALSE || $iniquery) {
            $this->db->trans_rollback();
        } else {
            $jumlah = $this->db->get_where('tb_detail', ['id_header' => $id])->num_rows();
            $data = [
                'data_ok' => 1,
                'user_ok' => $this->session->userdata('id'),
                'tgl_ok' => date('Y-m-d H:i:s'),
                'jumlah_barang' => $jumlah
            ];
            $this->db->where('id', $id);
            $this->db->update('tb_header', $data);
            $this->db->trans_commit();
        }
        return !$iniquery;
    }
    public function getdatagm($idbarang)
    {
        $kondisi = [
            'periode' => kodebulan($this->session->userdata('bl')) . $this->session->userdata('th'),
            'dept_id' => 'GM',
            'id_barang' => $idbarang
        ];
        $kondisi2 = [
            'pcs_akhir > ' => 0,
            'kgs_akhir > ' => 0
        ];
        $this->db->select('stokdept.*,barang.nama_barang,barang.kode', FALSE);
        $this->db->from('stokdept');
        $this->db->join('barang', 'barang.id = stokdept.id_barang', 'left');
        $this->db->where($kondisi);
        $this->db->group_start();
        $this->db->or_where($kondisi2);
        $this->db->group_end();
        $hasil = $this->db->get();
        return $hasil;
    }
    public function editnobontr($data)
    {
        $update = [
            'id_stokdept' => $data['idstok'],
            'nobontr' => $data['nobontr']
        ];
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_detail', $update);
        return $hasil;
    }
    public function updatedok()
	{
		$data = $_POST;
		$temp = $this->getdatabyid($data['id_header']);
		$fotodulu = FCPATH . 'assets/file/dok/' . $temp['filepdf']; //base_url().$gambar.'.png';
		$id = $data['id_header'];
		$data['filepdf'] = $this->uploaddok();
		if ($data['filepdf'] != NULL) {
			if ($data['filepdf'] == 'kosong') {
				$data['filepdf'] = NULL;
			}
			if (file_exists($fotodulu)) {
				unlink($fotodulu);
			}
			unset($data['logo']);
			$query = $this->db->query("update tb_header set filepdf = '" . $data['filepdf'] . "' where id = '" . $id . "' ");
			if ($query) {
				$this->session->set_flashdata('pesanerror', 'Dokumen Berhasil Diupload');
			    $this->session->set_flashdata('errorsimpan', 1);
			}
		} else {
			// $this->session->set_flashdata('pesanerror', 'Error Upload Foto Profile ' . $temp['id'] . ' ');
			$this->session->set_flashdata('errorsimpan', 1);
		}
		$url = base_url() . 'ib/isidokbc/' . $id;
		redirect($url);
	}
    public function uploaddok()
	{
		$this->load->library('upload');
		$this->uploadConfig = array(
			'upload_path' => LOK_UPLOAD_DOK_BC,
			'allowed_types' => 'pdf',
			// 'max_size' => max_upload() * 1024,
		);
		// Adakah berkas yang disertakan?
		$adaBerkas = $_FILES['dok']['name'];
		if (empty($adaBerkas)) {
			return 'kosong';
		}
		$uploadData = NULL;
		$this->upload->initialize($this->uploadConfig);
		if ($this->upload->do_upload('dok')) {
			$uploadData = $this->upload->data();
			$namaFileUnik = strtolower($uploadData['file_name']);
			$fileRenamed = rename(
				$this->uploadConfig['upload_path'] . $uploadData['file_name'],
				$this->uploadConfig['upload_path'] . $namaFileUnik
			);
			$uploadData['file_name'] = $fileRenamed ? $namaFileUnik : $uploadData['file_name'];
		} else {
			$_SESSION['success'] = -1;
			$ext = pathinfo($adaBerkas, PATHINFO_EXTENSION);
			$ukuran = $_FILES['file']['size'] / 1000000;
			$tidakupload = $this->upload->display_errors(NULL, NULL);
			$this->session->set_flashdata('pesanerror', $tidakupload . ' ' . $ext . ' ukuran ' . round($ukuran, 2) . ' MB');
		}
		return (!empty($uploadData)) ? $uploadData['file_name'] : NULL;
	}
    public function isilampiran23($id){
        $cekdata = $this->db->get_where('lampiran',['id_header' => $id]);
        $hasil = 1;
        if($cekdata->num_rows() == 0){
            $this->db->trans_start();
            for ($i=0; $i <= 1; $i++) { 
                $kodelampiran = $i==0 ? '380' : '705';
                $data = [
                    'id_header' => $id,
                    'kode_dokumen' => $kodelampiran
                ];
                $this->db->insert('lampiran',$data);
            }
            $hasil = $this->db->trans_complete();
        }
        return $hasil;
    }
}
