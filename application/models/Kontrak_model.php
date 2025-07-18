<?php
class Kontrak_model extends CI_Model
{
    public function cekfield($id, $kolom, $nilai)
    {
        $this->db->where('id', $id);
        $this->db->where($kolom, $nilai);
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }

    public function getdatakontrak($kode)
    {
        $this->db->select('*');
        $this->db->from('tb_kontrak');
        $this->db->join('dept','dept.dept_id = tb_kontrak.dept_id');
        if($kode['dept_id']!=""){
            $this->db->where('tb_kontrak.dept_id', $kode['dept_id']);
        }
        $this->db->where('jns_bc', $kode['jnsbc']);
        if($kode['status']==1){
            $this->db->where("tgl_akhir >= '" . date('Y-m-d')."'");
        }else if($kode['status']==2){
            $this->db->where("tgl_akhir < '" . date('Y-m-d')."'");
        }
        if($kode['thkontrak']!=''){
            $this->db->where("year(tgl_awal)",$kode['thkontrak']);
        }
        $this->db->order_by('tgl_akhir');
        return $this->db->get();
    }
    public function getdatapcskgskontrak($kode)
    {
        $this->db->select('count(*) as jmlrek,sum(pcs) as pcs,sum(kgs) as kgs');
        $this->db->from('tb_kontrak');
        $this->db->join('dept','dept.dept_id = tb_kontrak.dept_id');
        if($kode['dept_id']!=""){
            $this->db->where('tb_kontrak.dept_id', $kode['dept_id']);
        }
        $this->db->where('jns_bc', $kode['jnsbc']);
        if($kode['status']==1){
            $this->db->where("tgl_akhir >= '" . date('Y-m-d')."'");
        }else if($kode['status']==2){
            $this->db->where("tgl_akhir < '" . date('Y-m-d')."'");
        }
        $this->db->order_by('tgl_akhir');
        return $this->db->get();
    }

    public function adddata(){
        $arrinput = [
            'tgl_awal' => date('Y-m-d'),
            'tgl_akhir' => date('Y-m-d', strtotime("+60 day")),
            'dept_id' => $this->session->userdata('deptkontrak'),
            'jns_bc' => $this->session->userdata('jnsbckontrak'),
            'nomor' => nomorkontrak()
        ];
        $this->db->insert('tb_kontrak',$arrinput);
        $hasil = $this->db->insert_id();
        $this->helpermodel->isilog($this->db->last_query());
        $this->session->set_userdata('sesikontrak',$hasil);

        $this->db->select("*");
        $this->db->from('tb_kontrak');
        $this->db->join('dept','dept.dept_id = tb_kontrak.dept_id','left');
        $this->db->where('tb_kontrak.id',$hasil);
        return $this->db->get();

        // return $this->db->get_where('tb_kontrak',['id' => $hasil]);
    }

    public function getDetail_nomor($id, $kode)
    {
        $this->db->from('tb_kontrak');
        $this->db->where('id', $id);
        // $this->db->where('dept_id', $kode['dept_id']);
        $this->db->where('jns_bc', $kode['jnsbc']);
        return $this->db->get()->row_array();
    }

    public function getdata($id)
    {
        $this->db->select("*");
        $this->db->from('tb_kontrak');
        $this->db->join('dept','dept.dept_id = tb_kontrak.dept_id','left');
        $this->db->where('tb_kontrak.id',$id);
        return $this->db->get();
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('tb_kontrak',['id' => $id]);
    }
    public function hapuskontrak($id){
        $this->db->trans_start();
        $this->db->where('id_kontrak',$id);
        $this->db->delete('tb_kontrak_detail');

        $this->db->where('id',$id);
        $this->db->delete('tb_kontrak');

        return $this->db->trans_complete();
        $this->helpermodel->isilog($this->db->last_query());
    }
    public function simpankontrak($data){
        unset($data['mode']);
        $data['pcs'] = toangka($data['pcs']);
        $data['kgs'] = toangka($data['kgs']);
        $data['bea_masuk'] = toangka($data['bea_masuk']);
        $data['ppn'] = toangka($data['ppn']);
        $data['pph'] = toangka($data['pph']);
        $data['jml_ssb'] = toangka($data['jml_ssb']);
        $data['tgl_awal'] = tglmysql($data['tgl_awal']);
        $data['tgl_akhir'] = tglmysql($data['tgl_akhir']);
        $data['tgl_expired'] = tglmysql($data['tgl_expired']);
        $data['tgl_ssb'] = tglmysql($data['tgl_ssb']);
        $data['tgl_bpj'] = tglmysql($data['tgl_bpj']);
        $data['tgl_kep'] = tglmysql($data['tgl_kep']);
        $data['tgl_surat'] = tglmysql($data['tgl_surat']);
        $data['tgl_dok_lain'] = tglmysql($data['tgl_dok_lain']);
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_kontrak',$data);
        $this->helpermodel->isilog($this->db->last_query());
        return $hasil;
    }
    public function loaddetailkontrak($id){
        $this->db->where('id_kontrak',$id);
        return $this->db->get('tb_kontrak_detail');
    }
    public function simpandetailkontrak($data){
        $hasil = $this->db->insert('tb_kontrak_detail',$data);
        $this->helpermodel->isilog($this->db->last_query());
        return $hasil;
    }
    public function hapusdetailkontrak($id){
        $this->db->where('id',$id);
        $hasil = $this->db->delete('tb_kontrak_detail');
        $this->helpermodel->isilog($this->db->last_query());
        return $hasil;
    }
    public function simpankedatabase($data){
        $this->db->where('id',$data['id']);
        return $this->db->update($data['tabel'],[$data['kolom']=>$data['isi']]);
    }
    public function depttujupb($kode)
    {
        $hasil = '';
        $depo = '';
        if ($kode == 'GW') {
            $depo = 'GS,';
        } else {
            $depo = 'GM,GP,GF,GW,GS,';
            if ($kode == 'RR' || $kode == 'FG') {
                $depo .= 'FN,';
            }
        }
        $cek = $this->db->get_where('dept', ['dept_id' => $kode])->row_array();
        for ($i = 1; $i <= strlen($cek['penerimaan']) / 2; $i++) {
            $kodex = substr($cek['penerimaan'], ($i * 2) - 2, 2);
            $pos = strpos($depo, $kodex);
            if ($pos !== false) {
                $this->db->where('dept_id', $kodex);
                $gudang = $this->db->get('dept')->row_array();
                if ($gudang) {
                    $selek = $this->session->userdata('tujusekarang') == $gudang['dept_id'] ? 'selected' : '';
                    $hasil .= "<option value='" . $gudang['dept_id'] . "' rel='" . $gudang['departemen'] . "' " . $selek . ">" . $gudang['departemen'] . "</option>";
                }
            }
        }
        return $hasil;
    }
    public function tambahpb($data)
    {
        $kode = $data['nomor_dok'];
        $query = $this->db->insert('tb_header', $data);
        $this->helpermodel->isilog($this->db->last_query());
        if ($query) {
            $this->db->where('nomor_dok', $kode);
            $kodex = $this->db->get('tb_header')->row_array();
        }
        return $kodex;
    }
    public function updatepb($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        $this->helpermodel->isilog($this->db->last_query());
        return $query;
    }
    public function simpanpb($data)
    {
        $jmlrec = $this->db->query("Select count(id) as jml from tb_detail where id_header = " . $data['id'])->row_array();
        $data['jumlah_barang'] = $jmlrec['jml'];
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        $this->helpermodel->isilog($this->db->last_query());

        //Isi data ke detailgen 
        if ($this->session->userdata('tujusekarang') == 'GS' || $this->session->userdata('tujusekarang') == 'GM') {
            $datadet = $this->db->get_where('tb_detail', ['id_header' => $data['id']]);
            foreach ($datadet->result_array() as $keydet) {
                $keydet['id_detail'] = $keydet['id'];
                unset($keydet['id']);
                $this->db->insert('tb_detailgen', $keydet);
            }
        }
        return $query;
    }
    public function validasipb($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }
    public function getnomorpb($bl, $th, $asal, $tuju)
    {
        $hasil = $this->db->query("SELECT MAX(SUBSTR(trim(nomor_dok),-3)) AS maxkode FROM tb_header 
        WHERE kode_dok = 'PB' AND MONTH(tgl)='" . $bl . "' AND YEAR(tgl)='" . $th . "' AND dept_id = '" . $asal . "' AND dept_tuju = '" . $tuju . "' ")->row_array();
        return $hasil;
    }
    public function getdatapb($data)
    {
        $this->db->select('tb_header.*,user.name,(select count(*) from tb_detail where id_header = tb_header.id) as jmlrex');
        $this->db->join('user', 'user.id=tb_header.user_ok', 'left');
        $this->db->where('kode_dok', 'PB');
        $this->db->where('dept_id', $data['dept_id']);
        $this->db->where('dept_tuju', $data['dept_tuju']);
        if ($data['level'] == 2) {
            $this->db->where('data_ok', 1);
            $this->db->where('ok_valid', 0);
        }
        $this->db->where('month(tgl)', $this->session->userdata('bl'));
        $this->db->where('year(tgl)', $this->session->userdata('th'));
        return $this->db->get('tb_header')->result_array();
    }
    public function getdatadetailpb($data)
    {
        $this->db->select("tb_detail.*,satuan.namasatuan,satuan.kodesatuan,barang.kode,barang.nama_barang,barang.kode as brg_id,CONCAT(TRIM(po),'#',TRIM(item),IF(dis > 0,' dis ',''),if(dis > 0,dis,'')) AS sku");
        $this->db->from('tb_detail');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->where('id_header', $data);
        return $this->db->get()->result_array();
    }
    public function getdatadetailpbbyid($data)
    {
        $this->db->select("tb_detail.*,satuan.namasatuan,barang.kode,barang.nama_barang,satuan.id as id_satuan");
        $this->db->from('tb_detail');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->where('tb_detail.id', $data);
        return $this->db->get()->result();
    }
    public function getspecbarang($mode, $spec)
    {
        if ($mode == 0) {
            $pek = explode(' ', $spec);
            $spekjadi = '';
            if (count($pek) > 0) {
                for ($x = 0; $x < count($pek); $x++) {
                    $spekjadi .= $pek[$x] . '%';
                }
            } else {
                $spekjadi = $spec . '%';
            }
            $queryx = $this->db->query("Select * from barang where nama_barang like '%" . substr($spekjadi, 0, strlen($spekjadi) - 1) . "%' and act=1 order by nama_barang ");
            // $this->db->like('nama_barange', substr($spekjadi,0,strlen($spekjadi)-1));
            // $this->db->order_by('nama_barang', 'ASC');
            // $query = $this->db->get_where('barang', array('act' => 1))->result_array();
            $query = $queryx->result_array();
        } else {
            $this->db->like('kode', $spec);
            $this->db->order_by('kode', 'ASC');
            $query = $this->db->get_where('barang', array('act' => 1))->result_array();
        }
        return $query;
    }
    public function hapusdata($id)
    {
        $this->db->trans_start();
        $this->db->where('id_header', $id);
        $this->db->delete('catatan_po');
        $this->db->where('id_header', $id);
        $this->db->delete('tb_detmaterial');
        $this->db->where('id_header', $id);
        $this->db->delete('tb_detailgen');
        $this->db->where('id_header', $id);
        $this->db->delete('tb_detail');
        $this->db->where('id', $id);
        $this->db->delete('tb_header');
        $this->helpermodel->isilog($this->db->last_query());
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function simpandetailbarang()
    {
        $data = $_POST;
        unset($data['nama_barang']);
        $hasil =  $this->db->insert('tb_detail', $data);
        $this->helpermodel->isilog($this->db->last_query());
        $idnya = $this->db->get_where('tb_detail', array('id_barang' => $data['id_barang'], 'id_header' => $data['id_header']))->row_array();
        // Isi data detmaterial
        $cek = $this->db->get_where('bom_barang', array('id_barang' => $data['id_barang']));
        if ($cek->num_rows() > 0) {
            foreach ($cek->result_array() as $kec) {
                $xdata = [
                    'id_header' => $data['id_header'],
                    'id_detail' => $idnya['id'],
                    'id_barang' => $kec['id_barang_bom'],
                    'persen' => $kec['persen'],
                    'kgs' => ($kec['persen'] / 100) * $data['kgs']
                ];
                $this->db->insert('tb_detmaterial', $xdata);
                $this->helpermodel->isilog($this->db->last_query());
            }
        }
        if ($hasil) {
            $this->db->where('id', $data['id_header']);
            $que = $this->db->get('tb_header')->row_array();
        }
        return $que;
    }
    public function updatedetailbarang()
    {
        $data = $_POST;
        unset($data['nama_barang']);
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_detail', $data);
        $this->helpermodel->isilog($this->db->last_query());

        $idnya = $this->db->get_where('tb_detail', array('id_barang' => $data['id_barang'], 'id_header' => $data['id_header']))->row_array();
        $this->db->where('id_header', $data['id_header']);
        $this->db->delete('tb_detmaterial');
        $this->helpermodel->isilog($this->db->last_query());
        // Isi data detmaterial
        $cek = $this->db->get_where('bom_barang', array('id_barang' => $data['id_barang']));
        if ($cek->num_rows() > 0) {
            foreach ($cek->result_array() as $kec) {
                $xdata = [
                    'id_header' => $data['id_header'],
                    'id_detail' => $idnya['id'],
                    'id_barang' => $kec['id_barang_bom'],
                    'persen' => $kec['persen'],
                    'kgs' => ($kec['persen'] / 100) * $data['kgs']
                ];
                $this->db->insert('tb_detmaterial', $xdata);
                $this->helpermodel->isilog($this->db->last_query());
            }
        }
        if ($query) {
            $this->db->where('id', $data['id_header']);
            $que = $this->db->get('tb_header')->row_array();
        }
        return $que;
    }
    public function hapusdetailpb($id)
    {
        $this->db->trans_start();
        $cek = $this->db->get_where('tb_detail', ['id' => $id])->row_array();
        $this->db->where('id_detail', $id);
        $hasil = $this->db->delete('tb_detmaterial');
        $this->db->where('id', $id);
        $this->db->delete('tb_detailgen');
        $this->db->where('id', $id);
        $this->db->delete('tb_detail');
        $this->helpermodel->isilog($this->db->last_query());
        $hasil = $this->db->trans_complete();
        if ($hasil) {
            $this->db->where('id', $cek['id_header']);
            $que = $this->db->get('tb_header')->row_array();
        }
        return $que;
    }
    public function simpancancelpb($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('tb_header', $data);
        $this->helpermodel->isilog($this->db->last_query());
    }
}
