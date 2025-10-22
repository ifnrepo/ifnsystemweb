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
        $this->db->select("tb_kontrak.*,dept.departemen,sum(round(tb_detail.kgs,2)) AS total_kgs,tb_header.nomor_bc");
        // $this->db->select("(SELECT SUM(round(det.kgs,2)) AS tot_kgs 
        //                     FROM tb_detail det 
        //                     LEFT JOIN tb_header head ON head.id = det.id_akb 
        //                     WHERE det.id_akb = head.id AND head.exnomor_bc = tb_header.nomor_bc AND head.send_ceisa = 1 AND trim(head.exnomor_bc) != '' AND trim(tb_header.nomor_bc) != '') as tot_kgs_masuk");
        $this->db->from('tb_kontrak');
        $this->db->join('tb_header', 'tb_header.id_kontrak = tb_kontrak.id', 'left');
        $this->db->join('tb_detail', 'tb_detail.id_akb = tb_header.id', 'left');
        $this->db->join('dept', 'dept.dept_id = tb_kontrak.dept_id', 'left');

        if (!empty($kode['dept_id'])) {
            $this->db->where('tb_kontrak.dept_id', $kode['dept_id']);
        }

        $this->db->where('tb_kontrak.jns_bc', $kode['jnsbc']);

        if ($kode['status'] == 1) {
            $this->db->where("tgl_akhir >= '" . date('Y-m-d') . "'");
        } else if ($kode['status'] == 2) {
            $this->db->where("tgl_akhir < '" . date('Y-m-d') . "'");
        }

        if (!empty($kode['thkontrak'])) {
            $this->db->where("YEAR(tgl_awal)", $kode['thkontrak']);
        }

        if (isset($kode['datkecuali'])) {
            $datkont = $this->db->query("SELECT id_kontrak FROM tb_header WHERE id_kontrak IS NOT NULL")->result_array();
        }

        $this->db->group_by('tb_kontrak.id');
        $this->db->order_by('nomor DESC,tgl_akhir');

        return $this->db->get();
    }
    public function getjumlahbcmasuk($nomorbc)
    {
        $this->db->select('SUM(round(det.kgs,2)) AS tot_kgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
        $this->db->where('tb_header.exnomor_bc', $nomorbc);
        $this->db->where('tb_detail.id_akb = tb_header.id AND tb_header.send_ceisa = 1 and trim(tb_header.exnomor_bc) != "" ');
        return $this->db->get()->row_array();
    }
    public function getdatakontrak261($kode)
    {
        $this->db->select('tb_kontrak.*,0 as saldo,0 as xnetto');
        $this->db->from('tb_kontrak');
        $this->db->join('dept', 'dept.dept_id = tb_kontrak.dept_id');
        if ($kode['dept_id'] != "") {
            $this->db->where('tb_kontrak.dept_id', $kode['dept_id']);
        }
        $this->db->where('jns_bc', $kode['jnsbc']);
        if ($kode['status'] == 1) {
            $this->db->where("tgl_akhir >= '" . date('Y-m-d') . "'");
        } else if ($kode['status'] == 2) {
            $this->db->where("tgl_akhir < '" . date('Y-m-d') . "'");
        }
        if ($kode['thkontrak'] != '') {
            $this->db->where("year(tgl_awal)", $kode['thkontrak']);
        }
        if (isset($kode['datkecuali'])) {
            $datkont = $this->db->query("Select id_kontrak from tb_header where id_kontrak is not null")->result_array();
        }
        $this->db->where('nomor_bpj != "" ');
        $this->db->where('tgl_bpj is not null ');
        $this->db->order_by('tgl_akhir');
        return $this->db->get();
    }
    public function getdatakontrak40($kode)
    {
        $header = $this->db->get_where('tb_header',['id' => $kode['idheader']])->row_array();
        $this->db->select('tb_kontrak.*,tb_header.netto');
        $this->db->select('SUM(round(tb_detail.kgs,2)) as kgsx,IFNULL(tb_kontrak.kgs-IFNULL(SUM(round(tb_detail.kgs,2)),0),0) as saldo');
        $this->db->select((float)$header['netto']." as xnetto");
        $this->db->from('tb_kontrak');
        $this->db->join('dept', 'dept.dept_id = tb_kontrak.dept_id');
        $this->db->join('tb_header','tb_header.id_kontrak = tb_kontrak.id','left');
        $this->db->join('tb_detail','tb_detail.id_header = tb_header.id','left');
        if ($kode['dept_id'] != "") {
            $this->db->where('tb_kontrak.dept_id', $kode['dept_id']);
        }
        $this->db->where('tb_kontrak.jns_bc', $kode['jnsbc']);
        if ($kode['status'] == 1) {
            $this->db->where("tgl_akhir >= '" . date('Y-m-d') . "'");
        } else if ($kode['status'] == 2) {
            $this->db->where("tgl_akhir < '" . date('Y-m-d') . "'");
        }
        if ($kode['thkontrak'] != '') {
            $this->db->where("year(tgl_awal)", $kode['thkontrak']);
        }
        // $this->db->where("tb_kontrak.kgs-SUM(round(tb_detail.kgs,2)) >= ",$header['netto']);
        $this->db->group_by('tb_kontrak.id');
        $this->db->order_by('tgl_akhir');
        return $this->db->get();
    }
    public function getdatapcskgskontrak($kode)
    {
        $this->db->select('count(*) as jmlrek,sum(pcs) as pcs,sum(kgs) as kgs');
        $this->db->from('tb_kontrak');
        $this->db->join('dept', 'dept.dept_id = tb_kontrak.dept_id');
        if ($kode['dept_id'] != "") {
            $this->db->where('tb_kontrak.dept_id', $kode['dept_id']);
        }
        $this->db->where('jns_bc', $kode['jnsbc']);
        if ($kode['status'] == 1) {
            $this->db->where("tgl_akhir >= '" . date('Y-m-d') . "'");
        } else if ($kode['status'] == 2) {
            $this->db->where("tgl_akhir < '" . date('Y-m-d') . "'");
        }
        $this->db->order_by('tgl_akhir');
        return $this->db->get();
    }

    public function adddata()
    {
        $arrinput = [
            'tgl' => date('Y-m-d'),
            'tgl_awal' => date('Y-m-d'),
            'tgl_akhir' => date('Y-m-d', strtotime("+60 day")),
            'dept_id' => $this->session->userdata('deptkontrak'),
            'jns_bc' => $this->session->userdata('jnsbckontrak'),
            'nomor' => nomorkontrak()
        ];
        $this->db->insert('tb_kontrak', $arrinput);
        $hasil = $this->db->insert_id();
        $this->helpermodel->isilog($this->db->last_query());
        $this->session->set_userdata('sesikontrak', $hasil);

        $this->db->select("*");
        $this->db->from('tb_kontrak');
        $this->db->join('dept', 'dept.dept_id = tb_kontrak.dept_id', 'left');
        $this->db->where('tb_kontrak.id', $hasil);
        return $this->db->get();

        // return $this->db->get_where('tb_kontrak',['id' => $hasil]);
    }

    public function getDetail_nomor($id, $kode)
    {
        $this->db->from('tb_kontrak');
        $this->db->where('id', $id);
        // $this->db->where('dept_id', $kode['dept_id']);
        // $this->db->where('jns_bc', $kode['jnsbc']);
        return $this->db->get()->row_array();
    }

    public function getdata($id)
    {
        $this->db->select("tb_kontrak.*, dept.nama_subkon, dept.alamat_subkon, dept.npwp,tb_header.nomor_bc,tb_header.tgl_aju,tb_header.id as idheader");
        $this->db->from('tb_kontrak');
        $this->db->join('dept', 'dept.dept_id = tb_kontrak.dept_id', 'left');
        $this->db->join('tb_header', 'tb_header.id_kontrak = tb_kontrak.id', 'left');
        $this->db->where('tb_kontrak.id', $id);
        return $this->db->get();
    }

    public function getHeader_kontrak($sesi)
    {
        $this->db->select("tb_kontrak.*, dept.departemen");
        $this->db->from('tb_kontrak');
        $this->db->join('dept', 'dept.dept_id = tb_kontrak.dept_id', 'left');
        $this->db->where('tb_kontrak.id', $sesi);
        return $this->db->get()->row_array();
    }

    public function get_Ttd($sesi)
    {
        $this->db->select("tb_kontrak.*, tb_header.tg_jawab, tb_header.jabat_tg_jawab");
        $this->db->from('tb_kontrak');
        $this->db->join('tb_header', 'tb_header.id_kontrak = tb_kontrak.id', 'left');
        $this->db->where('tb_kontrak.id', $sesi);
        return $this->db->get()->row_array();
    }

    public function getDetail_kontrak($sesi)
    {
        $this->db->select("tb_detail.*,tb_header.*, barang.nama_barang, satuan.kodesatuan,barang.kode");
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->where('tb_header.id_kontrak', $sesi);
        $this->db->where('tb_header.send_ceisa', 1);
        $this->db->order_by('tb_detail.seri_urut_akb');
        return $this->db->get()->result_array();
    }
    public function getDetail_kontrak_ex($sesi)
    {
        $this->db->select("tb_detail.*,tb_header.*, barang.nama_barang, satuan.kodebc,barang.kode");
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->where('tb_header.id_kontrak', $sesi);
        $this->db->where('tb_header.send_ceisa', 1);
        $this->db->order_by('tb_detail.seri_urut_akb');
        return $this->db->get()->result_array();
    }

    public function getdatapengembalian($id)
    {
        $header = $this->db->get_where('tb_header', ['id_kontrak' => $id])->row_array();
        $this->db->select('tb_detail.*,sum(round(tb_detail.kgs,2)) as kgs,sum(round(tb_detail.pcs,2)) as pcs,tb_header.tgl,tb_header.nomor_dok,tb_header.nomor_bc,tb_header.tgl_bc,tb_header.jns_bc,barang.kode,satuan.kodesatuan');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->where('tb_header.exnomor_bc', $header['nomor_bc']);
        $this->db->where('tb_header.send_ceisa', 1);
        $this->db->where('tb_header.nomor_bc != ""');
        $this->db->group_by('tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang,tb_detail.insno');
        return $this->db->get();
    }
    public function getdatapengembalian_ex($id)
    {
        $header = $this->db->get_where('tb_header', ['id_kontrak' => $id])->row_array();
        $this->db->select('tb_detail.*,sum(round(tb_detail.kgs,2)) as kgs,sum(round(tb_detail.pcs,2)) as pcs,tb_header.tgl,tb_header.nomor_dok,tb_header.nomor_bc,tb_header.tgl_bc,tb_header.jns_bc,barang.kode,satuan.kodebc');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->where('tb_header.exnomor_bc', $header['nomor_bc']);
        $this->db->where('tb_header.send_ceisa', 1);
        $this->db->where('tb_header.nomor_bc != ""');
        $this->db->group_by('tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang,tb_detail.insno');
        return $this->db->get();
    }

    public function getdatabyid($id)
    {
        return $this->db->get_where('tb_kontrak', ['id' => $id]);
    }
    public function hapuskontrak($id)
    {
        $this->db->trans_start();
        $this->db->where('id_kontrak', $id);
        $this->db->delete('tb_kontrak_detail');

        $this->db->where('id', $id);
        $this->db->delete('tb_kontrak');

        return $this->db->trans_complete();
        $this->helpermodel->isilog($this->db->last_query());
    }
    public function simpankontrak($data)
    {
        unset($data['mode']);
        $data['pcs'] = toangka($data['pcs']);
        $data['kgs'] = toangka($data['kgs']);
        $data['bea_masuk'] = toangka($data['bea_masuk']);
        $data['ppn'] = toangka($data['ppn']);
        $data['pph'] = toangka($data['pph']);
        $data['jml_ssb'] = toangka($data['jml_ssb']);
        $data['tgl'] = tglmysql($data['tgl']);
        $data['tgl_awal'] = tglmysql($data['tgl_awal']);
        $data['tgl_akhir'] = tglmysql($data['tgl_akhir']);
        $data['tgl_expired'] = tglmysql($data['tgl_expired']);
        $data['tgl_ssb'] = tglmysql($data['tgl_ssb']);
        $data['tgl_bpj'] = tglmysql($data['tgl_bpj']);
        $data['tgl_kep'] = tglmysql($data['tgl_kep']);
        $data['tgl_surat'] = tglmysql($data['tgl_surat']);
        $data['tgl_dok_lain'] = tglmysql($data['tgl_dok_lain']);
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_kontrak', $data);
        $this->helpermodel->isilog($this->db->last_query());
        return $hasil;
    }
    public function loaddetailkontrak($id)
    {
        $this->db->where('id_kontrak', $id);
        return $this->db->get('tb_kontrak_detail');
    }
    public function simpandetailkontrak($data)
    {
        $hasil = $this->db->insert('tb_kontrak_detail', $data);
        $this->helpermodel->isilog($this->db->last_query());
        return $hasil;
    }
    public function hapusdetailkontrak($id)
    {
        $this->db->where('id', $id);
        $hasil = $this->db->delete('tb_kontrak_detail');
        $this->helpermodel->isilog($this->db->last_query());
        return $hasil;
    }
    public function gettransaksikontrak($id)
    {
        $header = $this->db->get_where('tb_header', ['id_kontrak' => $id])->row_array();
        $urutakb = $header['urutakb'];

        //Cek data Pengiriman
        if ($urutakb == 1) {
            $this->db->select("'0' as kirter,tb_detail.*,sum(round(tb_detail.pcs,2)) as pcsx,sum(round(tb_detail.kgs,2)) as kgsx,barang.kode");
            $this->db->from('tb_detail');
            $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
            $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
            $this->db->where('tb_header.id', $header['id']);
            $this->db->where('tb_header.send_ceisa', 1);

            $this->db->group_by('tb_header.ketprc,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.insno,barang.kode');
            // $this->db->order_by('tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.insno,barang.kode');
        } else {
            $this->db->select("'0' as kirter,tb_detail.*,tb_detail.pcs as pcsx,tb_detail.kgs as kgsx,barang.kode");
            $this->db->from('tb_detail');
            $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
            $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
            $this->db->where('tb_header.id', $header['id']);
            $this->db->where('tb_header.send_ceisa', 1);

            // $this->db->order_by('tb_detail.urut_akb,seri_barang');
        }
        $datakirim = $this->db->get_compiled_select();

        //Cek data Penerimaan
        $header2 = $this->db->get_where('tb_header', ['exnomor_bc' => $header['nomor_bc']]);
        if ($header2->num_rows() > 0) {
            $xheader2 = $header2->row_array();
        } else {
            $xheader2['id'] = '@#$#%$';
        }
        $this->db->select("'1' as kirter,tb_detail.*,sum(round(tb_detail.pcs,2)) as pcsx,sum(round(tb_detail.kgs,2)) as kgsx,barang.kode");
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->where('tb_header.exnomor_bc', $header['nomor_bc']);
        $this->db->where('tb_header.send_ceisa', 1);

        $this->db->group_by('tb_header.ketprc,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.insno,barang.kode');

        $dataterima = $this->db->get_compiled_select();

        if ($urutakb == 1) {
            $select = "Select *,sum(round(kgs_masuk,2)) as kgs_masuk,sum(round(kgs_keluar,2)) as kgs_keluar from (";
            $order = 'po,item,dis,insno,kode';
            $grup = 'group by po,item,dis,insno,kode';
            $grup = '';
        } else {
            $select = "Select * from (";
            $order = 'urut_akb,seri_barang';
            $grup = '';
        }

        // $finalsql = $select.$datakirim." union all ".$dataterima.") pt ".$grup." order by ".$order;
        $finalsql = "Select * from (" . $datakirim . " UNION ALL " . $dataterima . ")pt order by po,item,dis,kode,kirter";

        return $this->db->query($finalsql);
    }

    public function simpankedatabase($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update($data['tabel'], [$data['kolom'] => $data['isi']]);
    }
    public function getdatajaminan($id)
    {
        $this->db->select('Sum(tb_bombc.cif*tb_bombc.ndpbm) as cifrupiah,ndpbm,tb_header.nomor_bc,tb_header.tgl_bc');
        $this->db->from('tb_bombc');
        $this->db->join('tb_header', 'tb_header.id = tb_bombc.id_header', 'left');
        $this->db->where('id_header', $id);
        return $this->db->get();
    }
    public function getdatajaminkiriman($nobc)
    {
        $this->db->select('id');
        $this->db->from('tb_header');
        $this->db->where('exnomor_bc', $nobc);
        $has_id = $this->db->get();

        $array_in = [];
        foreach ($has_id->result_array() as $has) {
            array_push($array_in, $has['id']);
        }

        // print_r($array_in);

        $this->db->select('tb_detail.id_akb,sum(pcs) AS pcs,sum(kgs) AS kgs,exbc_ndpbm,tb_header.nomor_bc,tb_header.tgl_bc');
        $this->db->select('(SELECT sum(det.exbc_cif) OVER() FROM tb_detail det WHERE det.id_akb = tb_detail.id_akb GROUP BY id_seri_exbc LIMIT 1) as cifnya');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
        if (count($array_in) > 0) {
            $this->db->where_in('id_akb', implode(',', $array_in), false);
            $this->db->where('tb_header.send_ceisa', 1);
        } else {
            $this->db->where_in('id_akb', '');
        }
        $this->db->group_by('id_akb');
        return $this->db->get();
    }
    //End KONTRAK MODEL

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
}
