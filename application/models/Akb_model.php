<?php
class Akb_model extends CI_Model
{
    public function getdata($kode)
    {
        if ($kode == 'FG') {
            $deptsubkon = daftardeptsubkon();
            $arrkondisi = [
                'id_perusahaan' => IDPERUSAHAAN,
                'kode_dok' => 'T',
                'tb_header.dept_id' => $kode,
                // 'dept_tuju' => 'AR',
                'month(tb_header.tgl)' => $this->session->userdata('bl'),
                'year(tb_header.tgl)' => $this->session->userdata('th'),
                'left(nomor_dok,3)' => 'IFN'
            ];
        } else {
            $arrkondisi = [
                'id_perusahaan' => IDPERUSAHAAN,
                'kode_dok' => 'T',
                'tb_header.dept_id' => $kode,
                'dept_tuju' => 'CU',
                'month(tb_header.tgl)' => $this->session->userdata('bl'),
                'year(tb_header.tgl)' => $this->session->userdata('th'),
                'tanpa_bc' => 0,
                'ok_tuju' => 1
            ];
        }
        $this->db->select('tb_header.*,customer.nama_customer as namacustomer,tb_kontrak.nomor as nomorkontrak');
        $this->db->join('customer', 'customer.id = tb_header.id_buyer', 'left');
        $this->db->join('tb_kontrak', 'tb_kontrak.id = tb_header.id_kontrak', 'left');
        $this->db->where($arrkondisi);
        $this->db->order_by('tb_header.id','desc');
        $this->db->order_by('tb_header.tgl', 'desc');
        $this->db->order_by('nomor_dok', 'desc');
        $hasil = $this->db->get('tb_header');
        return $hasil->result_array();
    }
    public function getjumlahdata($kode)
    {
        if ($kode == 'FG') {
            $deptsubkon = daftardeptsubkon();
            $arrkondisi = [
                'id_perusahaan' => IDPERUSAHAAN,
                'kode_dok' => 'T',
                'tb_header.dept_id' => $kode,
                // 'dept_tuju' => 'AR',
                'month(tb_header.tgl)' => $this->session->userdata('bl'),
                'year(tb_header.tgl)' => $this->session->userdata('th'),
                'left(nomor_dok,3)' => 'IFN'
            ];
        } else {
            $arrkondisi = [
                'id_perusahaan' => IDPERUSAHAAN,
                'kode_dok' => 'T',
                'tb_header.dept_id' => $kode,
                'dept_tuju' => 'CU',
                'month(tb_header.tgl)' => $this->session->userdata('bl'),
                'year(tb_header.tgl)' => $this->session->userdata('th'),
                'tanpa_bc' => 0,
                'ok_tuju' => 1
            ];
        }
        $this->db->select('tb_header.*,customer.nama_customer as namacustomer,tb_kontrak.nomor as nomorkontrak,sum(jumlah_barang) over() as jumlahitemnya');
        $this->db->join('customer', 'customer.id = tb_header.id_buyer', 'left');
        $this->db->join('tb_kontrak', 'tb_kontrak.id = tb_header.id_kontrak', 'left');
        $this->db->where($arrkondisi);
        $this->db->order_by('tgl', 'desc');
        $this->db->order_by('nomor_dok', 'desc');
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }
    public function getdatabyid($kode, $mode = 0)
    {
        $this->db->select('tb_header.*,customer.nama_customer as namacustomer,customer.alamat,customer.kontak,customer.npwp,customer.kode_negara as negaracustomer,customer.pembeli as dirsell,ref_mt_uang.mt_uang,ref_jns_angkutan.angkutan as angkutlewat,ref_negara.kode_negara,tb_kontrak.nomor as nomorkontrak');
        $this->db->select('tb_kontrak.id as idkontrak,tb_kontrak.tgl as tglkontrak,tb_kontrak.tgl_kep,tb_kontrak.nomor_kep');
        $this->db->select('depte.nama_subkon as namasubkon,depte.alamat_subkon as alamatsubkon,depte.npwp as npwpsubkon,depte.noijin,depte.tglijin');
        $this->db->select("(select uraian_pelabuhan from ref_pelabuhan where ref_pelabuhan.kode_pelabuhan = tb_header.pelabuhan_muat) as pelmuat");
        $this->db->select("(select uraian_pelabuhan from ref_pelabuhan where ref_pelabuhan.kode_pelabuhan = tb_header.pelabuhan_bongkar) as pelbongkar");
        $this->db->join('dept', 'dept.dept_id=tb_header.dept_id', 'left');
        $this->db->join('customer', 'customer.id=tb_header.id_buyer', 'left');
        $this->db->join('ref_mt_uang', 'ref_mt_uang.id=tb_header.mtuang', 'left');
        $this->db->join('ref_jns_angkutan', 'ref_jns_angkutan.id=tb_header.jns_angkutan', 'left');
        $this->db->join('ref_negara', 'ref_negara.id=tb_header.bendera_angkutan', 'left');
        $this->db->join('tb_kontrak', 'tb_kontrak.id = tb_header.id_kontrak', 'left');
        $this->db->join('dept depte', 'depte.dept_id = tb_header.dept_tuju', 'left');
        $query = $this->db->get_where('tb_header', ['tb_header.id' => $kode]);
        return $query->row_array();
    }
    public function getdatadetailib($data, $mode = 0, $qu = 0)
    {
        if ($qu == 0) {
            $this->db->select("a.*,b.namasatuan,g.spek,b.kodesatuan,b.kodebc as satbc,c.kode,c.nama_barang,c.nohs as hsx,c.kode as brg_id,e.keterangan as keter,d.pcs as pcsmintaa,d.kgs as kgsmintaa,f.nama_kategori,f.kategori_id,g.klppo,h.engklp,h.hs as nohs,i.kdkem,j.nomor_dok as dokgaichu");
            $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
            $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
            $this->db->from('tb_detail a');
            $this->db->join('satuan b', 'b.id = a.id_satuan', 'left');
            $this->db->join('barang c', 'c.id = a.id_barang', 'left');
            $this->db->join('tb_detail d', 'a.id = d.id_ib', 'left');
            $this->db->join('tb_detail e', 'd.id = e.id_bbl', 'left');
            $this->db->join('kategori f', 'f.kategori_id = c.id_kategori', 'left');
            $this->db->join('tb_po g', 'g.po = a.po AND g.item = a.item AND g.dis = a.dis', 'left');
            $this->db->join('tb_klppo h', 'h.id = g.klppo', 'left');
            $this->db->join('ref_kemas i', 'i.id = a.kd_kemasan', 'left');
            $this->db->join('tb_header j', 'j.id = a.id_header', 'left');
            if ($mode == 0) {
                $this->db->where('a.id_header', $data);
                $this->db->order_by('id_header,seri_barang');
            } else {
                $this->db->where('a.id_akb', $data);
                $this->db->order_by('a.urut_akb,seri_barang');
            }
        } else {
            $this->db->select("a.*,round(sum(a.pcs),2) as pcs,round(sum(a.kgs),2) as kgs,b.namasatuan,g.spek,b.kodesatuan,b.kodebc as satbc,c.kode,c.nama_barang,c.nohs as hsx,c.kode as brg_id,e.keterangan as keter,d.pcs as pcsmintaa,d.kgs as kgsmintaa,f.nama_kategori,f.kategori_id,g.klppo,h.engklp,h.hs as nohs,i.kdkem,j.nomor_dok as dokgaichu");
            $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
            $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
            $this->db->from('tb_detail a');
            $this->db->join('satuan b', 'b.id = a.id_satuan', 'left');
            $this->db->join('barang c', 'c.id = a.id_barang', 'left');
            $this->db->join('tb_detail d', 'a.id = d.id_ib', 'left');
            $this->db->join('tb_detail e', 'd.id = e.id_bbl', 'left');
            $this->db->join('kategori f', 'f.kategori_id = c.id_kategori', 'left');
            $this->db->join('tb_po g', 'g.po = a.po AND g.item = a.item AND g.dis = a.dis', 'left');
            $this->db->join('tb_klppo h', 'h.id = g.klppo', 'left');
            $this->db->join('ref_kemas i', 'i.id = a.kd_kemasan', 'left');
            $this->db->join('tb_header j', 'j.id = a.id_header', 'left');
            if ($mode == 0) {
                $this->db->where('a.id_header', $data);
                $this->db->order_by('id_header,seri_barang');
            } else {
                $this->db->where('a.id_akb', $data);
                $this->db->group_by('j.ketprc,a.po,a.item,a.dis,a.insno,c.kode');
                $this->db->order_by('a.po,a.item,a.dis,a.insno,c.kode');
            }
        }

        return $this->db->get()->result_array();
    }
    public function getdatakontainer($id)
    {
        $this->db->where('id_header', $id);
        return $this->db->get('tb_kontainer');
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
    public function getbarangib($sup = '')
    {
        $this->db->select('tb_detail.*,tb_detail.id as iddetbbl,a.nomor_dok as nodok,b.nama_barang,d.dept_id,e.kodesatuan');
        $this->db->select('(select sum(pcs) from tb_detail z where z.po_id = tb_detail.id) as pcssudahterima');
        $this->db->select('(select sum(kgs) from tb_detail z where z.po_id = tb_detail.id) as kgssudahterima');
        $this->db->from('tb_detail');
        $this->db->join('tb_header a', 'a.id = tb_detail.id_header', 'left');
        $this->db->join('barang b', 'b.id = tb_detail.id_barang', 'left');
        $this->db->join('tb_detail c', 'c.id_po = tb_detail.id', 'left');
        $this->db->join('tb_header d', 'd.id = c.id_header', 'left');
        $this->db->join('satuan e', 'e.id = b.id_satuan', 'left');
        $this->db->where('a.id_perusahaan', IDPERUSAHAAN);
        $this->db->where('a.data_ok', 1);
        $this->db->where('a.ok_valid', 1);
        $this->db->where('a.ok_tuju', 0);
        $this->db->where('a.ok_pp', 0);
        $this->db->where('a.ok_pc', 0);
        $this->db->where('a.kode_dok', 'PO');
        // $this->db->where('tb_detail.id_ib',0);
        $this->db->where('tb_detail.id_po', 0);
        $this->db->where('a.id_pemasok', $sup);
        $this->db->where('d.dept_id', $this->session->userdata('depttuju'));
        return $this->db->get();
    }
    public function getbarangibl()
    {
        $this->db->select('*,tb_detail.id as iddetbbl');
        $this->db->from('tb_detail');
        $this->db->join('tb_header a', 'a.id = tb_detail.id_header', 'left');
        $this->db->join('barang b', 'b.id = tb_detail.id_barang', 'left');
        $this->db->where('a.id_perusahaan', IDPERUSAHAAN);
        $this->db->where('a.data_ok', 1);
        $this->db->where('a.ok_valid', 1);
        $this->db->where('a.ok_tuju', 1);
        $this->db->where('a.ok_pp', 1);
        $this->db->where('a.ok_pc', 1);
        $this->db->where('a.kode_dok', 'BBL');
        $this->db->where('id_ib', 0);
        $this->db->where('id_po', 0);
        $this->db->where('a.dept_id', $this->session->userdata('depttuju'));
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
            $header = $this->db->where('id', $detail['id_header'])->get('tb_header')->row_array();
            $headerx = $this->db->where('id', $id)->get('tb_header')->row_array();
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
    public function getdokbcmasuk()
    {
        $this->db->where('masuk', 1);
        $hasil = $this->db->get('ref_dok_bc');
        return $hasil;
    }
    public function cekhargabarang($id)
    {
        $this->db->where('id_header', $id);
        $this->db->where('harga', 0);
        return $this->db->get('tb_detail')->num_rows();
    }
    public function getdatacekbc()
    {
        $kondisi = [
            'data_ok' => 1,
            'ok_tuju' => 0,
            'kode_dok' => 'IB'
        ];
        $this->db->where($kondisi);
        return $this->db->get('tb_header');
    }
    public function simpandatabc($data, $head)
    {
        if ($data == 1) {
            $kondisi = [
                'ok_tuju' => 1,
                'user_tuju' => $this->session->userdata('id'),
                'tgl_tuju' => date('Y-m-d H:i:s'),
            ];
            $this->db->where('id', $head);
            return $this->db->update('tb_header', $kondisi);
        } else {
            $kondisi = [
                'ok_tuju' => 1,
                'tanpa_bc' => 1,
                'user_tuju' => $this->session->userdata('id'),
                'tgl_tuju' => date('Y-m-d H:i:s'),
            ];
            $this->db->where('id', $head);
            return $this->db->update('tb_header', $kondisi);
        }
    }
    public function updateib($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        $this->helpermodel->isilog($this->db->last_query());
        return $query;
    }
    public function getbckeluar()
    {
        $this->db->where('masuk', 0);
        return $this->db->get('ref_dok_bc');
    }
    public function simpandatanobc()
    {
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
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_header', $data);
        $this->helpermodel->isilog($this->db->last_query());
        return $hasil;
    }
    public function getjnsangkutan()
    {
        return $this->db->order_by('id')->get('ref_jns_angkutan');
    }
    public function refkemas()
    {
        return $this->db->order_by('kdkem')->get('ref_kemas');
    }
    public function updatepcskgs($data)
    {
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_detail', $data);
        return $hasil;
    }
    public function cekdetail($id)
    {
        $cekarr = [
            'xharga' => 0,
            'xkgs' => 0,
            'xpcs' => 0,
            'totalharga' => 0,
            'kgs' => 0.00
        ];
        $qry = $this->db->where('id_header', $id)->get('tb_detail');
        foreach ($qry->result_array() as $isidata) {
            if ($isidata['harga'] == 0) {
                $cekarr['xharga']++;
            }
            if ($isidata['kgs'] == 0) {
                $cekarr['xkgs']++;
            } else {
                $cekarr['kgs'] += $isidata['kgs'];
            }
            if ($isidata['pcs'] == 0) {
                $cekarr['totalharga'] += $isidata['kgs'] * $isidata['harga'];
            } else {
                $cekarr['totalharga'] += $isidata['pcs'] * $isidata['harga'];
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
    public function cekfield($id, $kolom, $nilai)
    {
        $this->db->where('id', $id);
        $this->db->where($kolom, $nilai);
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }
    public function editib($data)
    {
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_header', $data);
        return $hasil;
    }
    public function refmtuang()
    {
        return $this->db->order_by('id')->get('ref_mt_uang');
    }
    public function getjenisdokumen()
    {
        return $this->db->order_by('kode')->get('ref_jns_dokumen');
    }
    public function refbendera()
    {
        return $this->db->order_by('kode_negara')->get('ref_negara');
    }
    public function refpelabuhan()
    {
        return $this->db->order_by('kode_pelabuhan')->get('ref_pelabuhan');
    }
    public function refincoterm()
    {
        return $this->db->order_by('kode_incoterm')->get('ref_incoterm');
    }
    public function getpelabuhanbykode($kode)
    {
        $this->db->like('kode_pelabuhan', $kode);
        $this->db->or_like('uraian_pelabuhan', $kode);
        return $this->db->get('ref_pelabuhan');
    }
    public function getdatalampiran($id)
    {
        $this->db->select('lampiran.*,lampiran.id as idx,ref_jns_dokumen.nama_dokumen');
        $this->db->from('lampiran');
        $this->db->join('ref_jns_dokumen', 'ref_jns_dokumen.kode = lampiran.kode_dokumen', 'left');
        $this->db->where('id_header', $id);
        return $this->db->get();
    }
    public function getdatalampiranbyid($id)
    {
        $this->db->select('lampiran.*,lampiran.id as idx,ref_jns_dokumen.nama_dokumen');
        $this->db->from('lampiran');
        $this->db->join('ref_jns_dokumen', 'ref_jns_dokumen.kode = lampiran.kode_dokumen', 'left');
        $this->db->where('lampiran.id', $id);
        return $this->db->get();
    }
    public function tambahlampiran($data)
    {
        return $this->db->insert('lampiran', $data);
    }
    public function updatelampiran($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('lampiran', $data);
    }
    public function hapuslampiran($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('lampiran');
    }
    public function getdatadokumen($id)
    {
        return $this->db->get_where('lampiran', ['id_header' => $id]);
    }
    public function getdatanomoraju($id)
    {
        $detail = $this->db->get_where('tb_header', ['id' => $id])->row_array();
        $kodeaju = str_repeat('0', 6 - strlen(trim($detail['jns_bc']))) . trim($detail['jns_bc']);
        return $kodeaju . '010017' . str_replace('-', '', $detail['tgl_aju']) . $detail['nomor_aju'];
    }
    public function isitokenbc($data)
    {
        $this->db->where('id', 1);
        $this->db->update('token_bc', $data);
    }
    public function gettokenbc()
    {
        return $this->db->get('token_bc');
    }
    public function isikursbc($nilai, $valuta)
    {
        $cekkurs = $this->db->get_where('tb_kurs', ['tgl' => date('Y-m-d')]);
        if ($cekkurs->num_rows() > 0) {
            $hasil = $cekkurs->row_array();
            $idhasil = $hasil['id'];
            $this->db->where('id', $idhasil);
            $this->db->update('tb_kurs', [$valuta => $nilai]);
        } else {
            $data = [
                'tgl' => date('Y-m-d'),
                $valuta => $nilai
            ];
            $this->db->insert('tb_kurs', $data);
        }
    }
    public function getnomoraju($jns)
    {
        $hass = $this->db->get_where('tb_ajuceisa', ['jns_bc' => $jns])->row_array();
        $this->helpermodel->isilog("Isi Nomor Aju Otomatis dengan Nomor " . $hass['nomor_aju']);
        $urut = (int) $hass['nomor_aju'];
        $urut++;
        $isi = sprintf("%06s", $urut);
        $this->db->where('jns_bc', $jns);
        $this->db->update('tb_ajuceisa', ['nomor_aju' => $isi]);
        return $hass['nomor_aju'];
    }
    public function updatesendceisa($id)
    {
        $this->db->where('id', $id);
        $this->db->update('tb_header', ['send_ceisa' => 1, 'user_tuju' => $this->session->userdata('id'), 'tgl_tuju' => date("Y-m-d H:i:s")]);
    }
    public function simpanresponbc($data)
    {
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_header', $data);
        return $hasil;
    }
    public function gettoken()
    {
        $query = $this->db->get_where('token_bc', ['id' => 1])->row_array();
        return $query['token'];
    }
    public function cekkursnow()
    {
        $query = $this->db->get_where('tb_kurs', ['tgl' => date('Y-m-d')]);
        return $query;
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
        $url = base_url() . 'akb/isidokbc/' . $id;
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
    public function getdetbom($id)
    {
        $subquery = $this->db->select('*,concat(trim(nobontr),id_barang) as nobar')
            ->from('tb_hargamaterial')
            ->group_by('id_barang,nobontr')
            ->get_compiled_select();
        $this->db->select('tb_bombc.*,barang.nama_barang,barang.kode,barang.nohs,tb_header.nomor_bc,tb_header.jns_bc,satuan.kodesatuan,supplier.kode_negara,tb_header.mtuang');
        $this->db->select('tb_header.netto,tb_header.bruto,tb_header.kurs_yen,tb_header.kurs_usd,tb_header.totalharga,tbhargamat.nomor_bc as hamat_nomorbc,tbhargamat.jns_bc as hamat_jnsbc');
        $this->db->select('tbhargamat.price as hamat_harga,tbhargamat.weight as hamat_weight,tbhargamat.qty as hamat_qty,tbhargamat.kurs  as hamat_kurs,tbhargamat.cif,tbhargamat.mt_uang,tbhargamat.kode_negara as negarahamat,barang.nohs as hsbarang');
        $this->db->from('tb_bombc');
        $this->db->join('barang', 'barang.id = tb_bombc.id_barang', 'left');
        $this->db->join('tb_header', 'tb_header.nomor_dok = tb_bombc.nobontr', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->join('ref_negara', 'ref_negara.kode_negara = supplier.kode_negara', 'left');
        $this->db->join("($subquery) as tbhargamat", 'tbhargamat.nobar = concat(trim(tb_bombc.nobontr),tb_bombc.id_barang)', 'left');
        $this->db->where('id_header', $id);
        // $this->db->order_by('id_barang','nobontr ASC');
        $this->db->group_by('tb_bombc.id');
        $this->db->order_by('tb_bombc.seri_barang', 'id_barang', 'nobontr ASC');
        return $this->db->get();
    }
    public function getdetbombyid($id)
    {
        $subquery = $this->db->select('*,concat(trim(nobontr),id_barang) as nobar')
            ->from('tb_hargamaterial')
            ->group_by('id_barang,nobontr')
            ->get_compiled_select();
        $this->db->select('tb_bombc.*,barang.nama_barang,barang.kode,barang.nohs,tb_header.nomor_bc,tb_header.jns_bc,satuan.kodesatuan,supplier.kode_negara,tb_header.mtuang');
        $this->db->select('tb_header.netto,tb_header.bruto,tb_header.kurs_yen,tb_header.kurs_usd,tb_header.totalharga,tbhargamat.nomor_bc as hamat_nomorbc,tbhargamat.jns_bc as hamat_jnsbc');
        $this->db->select('tbhargamat.price as hamat_harga,tbhargamat.weight as hamat_weight,tbhargamat.qty as hamat_qty');
        $this->db->from('tb_bombc');
        $this->db->join('barang', 'barang.id = tb_bombc.id_barang', 'left');
        $this->db->join('tb_header', 'tb_header.nomor_dok = tb_bombc.nobontr', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->join('ref_negara', 'ref_negara.kode_negara = supplier.kode_negara', 'left');
        $this->db->join("($subquery) as tbhargamat", 'tbhargamat.nobar = concat(trim(tb_bombc.nobontr),tb_bombc.id_barang)', 'left');
        $this->db->where('tb_bombc.id', $id);
        return $this->db->get();
    }
    public function hitungbom($id, $mode)
    {
        if ($mode == 1) {
            $this->db->select("*");
            $this->db->from('tb_detail');
            $this->db->where('id_akb', $id);
            // $this->db->limit(1,0);
            $this->db->order_by('id_header,seri_barang');
        } else {
            $this->db->select("*");
            $this->db->from('tb_detail');
            $this->db->where('id_header', $id);
        }
        $hasil = $this->db->get();
        $arrhasil = [];
        $no = 1;
        foreach ($hasil->result_array() as $hsl) {
            $arrbom = showbom($hsl['po'], $hsl['item'], $hsl['dis'], $hsl['id_barang'], $hsl['insno'], $hsl['nobontr'], $hsl['kgs'], $no++, $hsl['pcs']);
            foreach ($arrbom as $hasilshowbom) {
                array_push($arrhasil, $hasilshowbom);
            }
        }
        return $arrhasil;
    }
    public function hitungbomjf($id,$mode,$qu=0){
        if($mode==1){
            if($qu==1){
                $this->db->select("tb_detail.*,round(sum(tb_detail.pcs),2) as pcs,round(sum(tb_detail.kgs),2) as kgs,tb_header.nomor_dok,tb_header.ketprc,barang.kode");
                $this->db->from('tb_detail');
                $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
                $this->db->join('barang','barang.id = tb_detail.id_barang','left');
                $this->db->where('id_akb',$id);
                // $this->db->limit(1,0);
                $this->db->group_by('tb_header.ketprc,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.insno,barang.kode');
                $this->db->order_by('po,item,dis,insno,barang.kode');
            }else{
                $this->db->select("tb_detail.*,tb_header.nomor_dok,tb_header.ketprc,barang.kode");
                $this->db->from('tb_detail');
                $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
                $this->db->join('barang','barang.id = tb_detail.id_barang','left');
                $this->db->where('id_akb',$id);
                // $this->db->limit(1,0);
                $this->db->order_by('tb_detail.urut_akb,seri_barang');
            }
        }else{
            $this->db->select("*,'' as ketprc,barang.kode");
            $this->db->from('tb_detail');
            $this->db->join('barang','barang.id = tb_detail.id_barang','left');
            $this->db->where('id_header', $id);
        }
        $hasil = $this->db->get();
        $arrhasil = [];
        $arrnotbom = [];
        $no = 1;
        foreach ($hasil->result_array() as $hsl) {
            if($mode==1){
                $kondisi = [
                    'id_akb' => $id,
                    'tb_header.ketprc' => $hsl['ketprc'],
                    'tb_detail.po' => $hsl['po'],
                    'tb_detail.item' => $hsl['item'],
                    'tb_detail.dis' => $hsl['dis'],
                    'tb_detail.insno' => $hsl['insno'],
                    'barang.kode' => $hsl['kode']
                ];
            }else{
                $kondisi = [
                    'id_header' => $id,
                    'tb_header.ketprc' => $hsl['ketprc'],
                    'tb_detail.po' => $hsl['po'],
                    'tb_detail.item' => $hsl['item'],
                    'tb_detail.dis' => $hsl['dis'],
                    'tb_detail.insno' => $hsl['insno'],
                    'barang.kode' => $hsl['kode']
                ];
            }
            $this->db->select("tb_detail.id");
            $this->db->from('tb_detail');
            $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
            $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
            $this->db->where($kondisi);
            $dataex = $this->db->get();
            $xhasil = [];
            foreach ($dataex->result_array() as $x) {
                array_push($xhasil, $x['id']);
            }

            $this->db->set('seri_urut_akb', $no);
            $this->db->where_in('id', $xhasil);
            $this->db->update('tb_detail');

            $arrbom = showbomjf($hsl['po'], $hsl['item'], $hsl['dis'], $hsl['id_barang'], $hsl['insno'], $hsl['nobontr'], round($hsl['kgs'], 2), $no++, $hsl['pcs'],$mode);
            if (count($arrbom) > 0) {
                foreach ($arrbom as $hasilshowbom) {
                    array_push($arrhasil, $hasilshowbom);
                }
            } else {
                // $arraynot = ['1338','40396']; // KARUNG 110 X 130 STRIP ORANGE, ADHESIVE TAPE 12.0MMX100MTR GREEN (NASHUA)
                $arraynot = ['XE@#$#'];
                if (in_array($hsl['id_barang'], $arraynot)) {
                    $dataxspin = [];
                    // $hasilshowbom = [
                    $dataxspin['po'] = $hsl['po'];
                    $dataxspin['item'] = $hsl['item'];
                    $dataxspin['dis'] = $hsl['dis'];
                    $dataxspin['id_barang'] = $hsl['id_barang'];
                    $dataxspin['insno'] = $hsl['insno'];
                    $dataxspin['nobontr'] = $hsl['nobontr'];
                    $dataxspin['pcs_asli'] = $hsl['pcs'];
                    $dataxspin['kgs_asli'] = $hsl['kgs'];
                    $dataxspin['noe'] = $no;
                    // ];
                    array_push($arrhasil, $dataxspin);
                } else {
                    $data = [
                        'po' => $hsl['po'],
                        'item' => $hsl['item'],
                        'dis' => $hsl['dis'],
                        'seri_barang' => $no - 1,
                        'id_barang' => $hsl['id_barang'],
                        'insno' => $hsl['insno'],
                        'nobontr' => $hsl['nobontr'],
                    ];
                    array_push($arrnotbom, $data);
                }
            }
        }
        $arrhasil2 = array('ok' => $arrhasil, 'ng' => $arrnotbom);
        return $arrhasil2;
    }
    public function excellampiran261($id, $qu = 0)
    {
        if ($qu == 0) {
            $this->db->select("tb_detail.*,tb_header.nomor_dok,satuan.kodebc,barang.kode,barang.nohs,'56081100' as hsx");
            $this->db->from('tb_detail');
            $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
            $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
            $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
            $this->db->join('tb_po g', 'g.po = tb_detail.po AND g.item = tb_detail.item AND g.dis = tb_detail.dis', 'left');
            $this->db->where('id_akb', $id);
            // $this->db->limit(1,0);
            $this->db->order_by('urut_akb,seri_barang');
        } else {
            $this->db->select("tb_detail.*,round(sum(pcs),2) as pcs,round(sum(kgs),2) as kgs,tb_header.nomor_dok,satuan.kodebc,barang.kode,barang.nohs,'56081100' as hsx");
            $this->db->from('tb_detail');
            $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
            $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
            $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
            $this->db->join('tb_po g', 'g.po = tb_detail.po AND g.item = tb_detail.item AND g.dis = tb_detail.dis', 'left');
            $this->db->where('id_akb', $id);
            // $this->db->limit(1,0);
            $this->db->group_by('tb_header.ketprc,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.insno,barang.kode');
            $this->db->order_by('tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.insno,barang.kode');
            // $this->db->order_by('urut_akb,seri_barang');
        }
        return $this->db->get();
    }
    public function detailexcellampiran261($id, $no)
    {
        $subquery = $this->db->select('*,concat(trim(nobontr),id_barang) as nobar')
            ->from('tb_hargamaterial')
            ->group_by('id_barang,nobontr')
            ->get_compiled_select();
        $this->db->select("tb_bombc.*,tbhargamat.jns_bc,tbhargamat.nomor_bc,tbhargamat.seri_barang as serbar,tbhargamat.tgl_bc,barang.nohs");
        $this->db->select("barang.kode,barang.nama_barang,satuan.kodebc,tbhargamat.nomor_aju,tbhargamat.tgl_aju,tbhargamat.kode_negara,tbhargamat.mt_uang,tbhargamat.cif,tbhargamat.weight");
        $this->db->from('tb_bombc');
        $this->db->join("($subquery) as tbhargamat", 'tbhargamat.nobar = concat(trim(tb_bombc.nobontr),tb_bombc.id_barang)', 'left');
        $this->db->join('barang', 'barang.id = tb_bombc.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $this->db->where('tb_bombc.id_header', $id);
        $this->db->where('tb_bombc.seri_barang', $no);
        // $this->db->limit(1,0);
        // $this->db->order_by('id_header,seri_barang');
        $this->db->group_by('tb_bombc.id');
        return $this->db->get();
    }
    public function exceljaminan261($id)
    {
        $subquery = $this->db->select('*,concat(trim(nobontr),id_barang) as nobar')
            ->from('tb_hargamaterial')
            ->group_by('id_barang,nobontr')
            ->get_compiled_select();
        $this->db->select("tb_bombc.id,tb_bombc.id_barang,tb_bombc.nobontr,SUM(round(tb_bombc.kgs,2)) AS kgs,tbhargamat.nomor_bc,tbhargamat.tgl_bc,tbhargamat.jns_bc,barang.nohs,barang.kode,barang.nama_barang,satuan.kodebc");
        $this->db->select("tb_bombc.bm,tb_bombc.bmt,tb_bombc.cukai,tb_bombc.ppn,tb_bombc.ppnbm,tb_bombc.pph,tbhargamat.cif,tbhargamat.mt_uang,tbhargamat.price as hamat_harga,tbhargamat.weight as hamat_weight,tbhargamat.seri_barang");
        $this->db->from('tb_bombc');
        $this->db->join("($subquery) as tbhargamat", 'tbhargamat.nobar = concat(trim(tb_bombc.nobontr),tb_bombc.id_barang)', 'left');
        $this->db->join('barang', 'barang.id = tb_bombc.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $this->db->where('tb_bombc.id_header', $id);
        $this->db->group_by('tb_bombc.id_barang,tb_bombc.nobontr');
        $this->db->order_by('nama_barang,id_barang,nobontr');
        return $this->db->get();
    }
    public function simpanbom($data,$id){
        $header = $this->db->get_where('tb_header',['id'=>$id])->row_array();
        $det = $this->db->get_where('tb_bombc',['id_header'=>$id])->num_rows();
        if($det > 0){
            $this->db->where('id_header',$id);
            $this->db->delete('tb_bombc');
        }
        if($header['dept_tuju']=='SU'){
            $detail = $this->db->get_where('tb_detail',['id_akb' => $id]);
            $no=0;
            foreach($detail->result_array() as $detail){
                $no++;
                $datasimpan = [
                    'id_header' => $id,
                    'id_barang' => $detail['id_barang'],
                    'seri_barang' => $no,
                    'nobontr' => $detail['nobontr'],
                    'kgs' => round($detail['kgs'], 2),
                    'pcs' => round($detail['kgs'], )
                ];
                $hasil = $this->db->insert('tb_bombc', $datasimpan);
            }
        }else{
            foreach ($data as $hasilshowbom) {
                if (((float) $hasilshowbom['kgs_asli'] + (float) $hasilshowbom['pcs_asli']) > 0.000009) {
                    $hasilshowbom['id_header'] = $id;
                    $datasimpan = [
                        'id_header' => $id,
                        'id_barang' => $hasilshowbom['id_barang'],
                        'seri_barang' => $hasilshowbom['noe'],
                        'nobontr' => $hasilshowbom['nobontr'],
                        'kgs' => round($hasilshowbom['kgs_asli'], 2),
                        'pcs' => $hasilshowbom['pcs_asli']
                    ];
                    $cekjenisbc = ceknomorbc($hasilshowbom['nobontr'],$hasilshowbom['id_barang']);
                    if(isset($cekjenisbc['id'])){
                        $kurssekarang = getkurssekarang($header['tgl_aju'])->row_array();
                        $kursusd = $kurssekarang['usd']==null ? 1 : $kurssekarang['usd'];
                        $ndpbm = $cekjenisbc['mt_uang']=='' || $cekjenisbc['mt_uang']=='IDR' ? 0 : $kurssekarang['usd'];
                        $pembagi = $cekjenisbc['weight']==0 ? 1 : round($cekjenisbc['weight'],2);
                        switch ($cekjenisbc['mt_uang']) {
                            case 'JPY':
                                $jpy = $cekjenisbc['cif']*$kurssekarang[strtolower($cekjenisbc['mt_uang'])];
                                $cif = $jpy/$kursusd;
                                break;
                            default:
                                $cif = $cekjenisbc['cif'];
                                break;
                        }
                        $jmmm = (($cif/$pembagi)*$ndpbm)*$hasilshowbom['kgs_asli'];
                        $hargaperkilo = round(($cif/$pembagi)*$hasilshowbom['kgs'],2)*$ndpbm;
                        $xcif = round(($cif/$pembagi)*$hasilshowbom['kgs'],2);
                        $nilaibm = $cekjenisbc['bm'] > 0 ? ($xcif*$kursusd)*($cekjenisbc['bm']/100) : 0;
                        $datasimpan['cif'] = $xcif;
                        $datasimpan['ndpbm'] = $kursusd;
                        $datasimpan['jns_bc'] = $cekjenisbc['jns_bc'];
                        if($cekjenisbc['jns_bc']=='23'){
                            // if($cekjenisbc['co']==0){
                            $datasimpan['bm'] = $cekjenisbc['bm'];
                            // }
                            $datasimpan['ppn'] = 11;
                            $datasimpan['pph'] = 2.5;
                            $datasimpan['bm_rupiah'] = round($nilaibm,0);
                            $datasimpan['ppn_rupiah'] = round(($nilaibm+($xcif*$kursusd))*0.11,0); 
                            $datasimpan['pph_rupiah'] = round(($nilaibm+($xcif*$kursusd))*0.025,0); 
                        }
                    }
                    $hasil = $this->db->insert('tb_bombc', $datasimpan);
                }
            }
        }
        return $hasil;
    }
    
    public function simpandetailbombc($data){
        $header = $this->db->get_where('tb_header',['id'=>$data['id_header']])->row_array();
        $det = $this->db->get_where('tb_bombc',['id'=>$data['id']])->row_array();
        $cekjenisbc = ceknomorbc($data['nobontr'],$data['id_barang']);
        if(isset($cekjenisbc['id'])){
            $kurssekarang = getkurssekarang($header['tgl_aju'])->row_array();
            $kursusd = $kurssekarang['usd']==null ? 1 : $kurssekarang['usd'];
            $ndpbm = $cekjenisbc['mt_uang']=='' || $cekjenisbc['mt_uang']=='IDR' ? 0 : $kurssekarang['usd'];
            $pembagi = $cekjenisbc['weight']==0 ? 1 : round($cekjenisbc['weight'],2);
            switch ($cekjenisbc['mt_uang']) {
                case 'JPY':
                    $jpy = $cekjenisbc['cif']*$kurssekarang[strtolower($cekjenisbc['mt_uang'])];
                    $cif = $jpy/$kursusd;
                    break;
                default:
                    $cif = $cekjenisbc['cif'];
                    break;
            }
            $jmmm = (($cif/$pembagi)*$ndpbm)*$det['kgs'];
            $hargaperkilo = round(($cif/$pembagi)*$det['kgs'],2)*$ndpbm;
            $xcif = round(($cif/$pembagi)*$det['kgs'],2);
            $nilaibm = $cekjenisbc['bm'] > 0 ? ($xcif*$kursusd)*($cekjenisbc['bm']/100) : 0;
            $data['cif'] = $xcif;
            $data['ndpbm'] = $kursusd;
            $data['jns_bc'] = $cekjenisbc['jns_bc'];
            if($cekjenisbc['jns_bc']=='23'){
                // if($cekjenisbc['co']==0){
                $data['bm'] = $cekjenisbc['bm'];
                // }
                $data['ppn'] = 11;
                $data['pph'] = 2.5;
                $data['bm_rupiah'] = round($nilaibm,0);
                $data['ppn_rupiah'] = round(($nilaibm+($xcif*$kursusd))*0.11,0); 
                $data['pph_rupiah'] = round(($nilaibm+($xcif*$kursusd))*0.025,0); 
            }
        }
        unset($data['id_barang']);
        unset($data['id_header']);
        $this->db->where('id',$data['id']);
        return $this->db->update('tb_bombc',$data);
    }
    public function isidatacifbombc($id){
        $this->db->trans_start();
        $header = $this->db->get_where('tb_header',['id'=>$id])->row_array();
        $det = $this->db->get_where('tb_bombc',['id_header'=>$id]);
        foreach($det->result_array() as $deta){
            $data['bm']=0;$data['ppn']=0;$data['pph']=0;
            $data['bm_rupiah']=0;$data['ppn_rupiah']=0;$data['pph_rupiah']=0;
            $cekjenisbc = ceknomorbc($deta['nobontr'],$deta['id_barang']);
            if(isset($cekjenisbc['id'])){
                $kurssekarang = getkurssekarang($header['tgl_aju'])->row_array();
                $kursusd = $kurssekarang['usd']==null ? 1 : $kurssekarang['usd'];
                $ndpbm = $cekjenisbc['mt_uang']=='' || $cekjenisbc['mt_uang']=='IDR' ? 0 : $kurssekarang['usd'];
                $pembagi = $cekjenisbc['weight']==0 ? 1 : round($cekjenisbc['weight'],2);
                switch ($cekjenisbc['mt_uang']) {
                    case 'JPY':
                        $jpy = $cekjenisbc['cif']*$kurssekarang[strtolower($cekjenisbc['mt_uang'])];
                        $cif = $jpy/$kursusd;
                        break;
                    default:
                        $cif = $cekjenisbc['cif'];
                        break;
                }
                $jmmm = (($cif/$pembagi)*$ndpbm)*$deta['kgs'];
                $hargaperkilo = round(($cif/$pembagi)*$deta['kgs'],2)*$ndpbm;
                $xcif = round(($cif/$pembagi)*$deta['kgs'],2);
                $nilaibm = $cekjenisbc['bm'] > 0 ? ($xcif*$kursusd)*($cekjenisbc['bm']/100) : 0;
                $data['cif'] = $xcif;
                $data['ndpbm'] = $kursusd;
                $data['jns_bc'] = $cekjenisbc['jns_bc'];
                if($cekjenisbc['jns_bc']=='23'){
                    // if($cekjenisbc['co']==0){
                    $data['bm'] = $cekjenisbc['bm'];
                    // }
                    $data['ppn'] = 11;
                    $data['pph'] = 2.5;
                    $data['bm_rupiah'] = round($nilaibm,0);
                    $data['ppn_rupiah'] = round(($nilaibm+($xcif*$kursusd))*0.11,0); 
                    $data['pph_rupiah'] = round(($nilaibm+($xcif*$kursusd))*0.025,0); 
                }
            }
            unset($data['id_barang']);
            unset($data['id_header']);
            unset($data['nobontr']);
            $this->db->where('id',$deta['id']);
            $this->db->update('tb_bombc',$data);
        }
        return $this->db->trans_complete();
    }
    public function simpanaddkontrak($data){
        $this->db->where('id',$data['id']);
        return $this->db->update('tb_header',$data);
    }
    public function hapuskontrak($id)
    {
        $this->db->where('id', $id);
        return $this->db->update('tb_header', ['id_kontrak' => 0]);
    }
    public function getdatakontrak($id)
    {
        $this->db->where('id', $id);
        return $this->db->get('tb_kontrak');
    }
    public function tambahajusubkon($kode)
    {
        $arrkondisi = [
            'id_perusahaan' => IDPERUSAHAAN,
            'kode_dok' => 'T',
            'dept_id' => $this->session->userdata('deptdari'),
            'dept_tuju' => $kode,
            'nomor_dok' => 'IFN-' . getnomoraju($kode),
            'jns_bc' => '261',
            'tgl' => date('Y-m-d'),
            'data_ok' => 1,
            'tgl_ok' => date('Y-m-d H:i:s'),
            'user_ok' => $this->session->userdata('id'),
            'ok_tuju' => 1,
            'tgl_tuju' => date('Y-m-d H:i:s'),
            'user_tuju' => $this->session->userdata('id'),
        ];
        return $this->db->insert('tb_header', $arrkondisi);
    }
    public function getbongaichu($id,$asal)
    {
        if($asal=='FG'){
            $dari = $this->db->get_where('tb_header', ['id' => $id])->row_array();
            $this->db->select('tb_header.nomor_dok,tb_header.id,tb_header.tgl,tb_header.ketprc,ref_proses.ket,sum(tb_detail.kgs) as kgs, sum(tb_detail.pcs) as pcs');
            $this->db->from('tb_detail');
            $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
            $this->db->join('ref_proses', 'ref_proses.kode = LEFT(tb_header.ketprc,3)', 'left');
            $this->db->where('tb_detail.id_akb', NULL);
            $this->db->where('tb_header.dept_id', $dari['dept_id']);
            $this->db->where('tb_header.dept_tuju', $dari['dept_tuju']);
            $this->db->where('tb_header.data_ok', 1);
            $this->db->group_by('tb_detail.id_header');
        }else{
            $this->db->select('tb_header.*,tb_header.keterangan as ket,sum(tb_detail.kgs) as kgs, sum(tb_detail.pcs) as pcs');
            $this->db->from('tb_detail');
            $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
            $this->db->where('tb_detail.id_akb', NULL);
            $this->db->where('tb_header.kode_dok','PO');
            $this->db->where('tb_header.data_ok',1);
            // $this->db->where('tb_header.ok_tuju',1);
            $this->db->where('tb_header.ok_valid',1);
            $this->db->like('tb_header.nomor_dok','SV/');
            $this->db->group_by('tb_detail.id_header');
        }
        return $this->db->get();
    }
    public function tambahbongaichu($kode)
    {
        $this->db->trans_start();
        $dataheader = $this->db->get_where('tb_header', ['id' => $kode['id']])->row_array();
        $jumlah = count($kode['data']);
        $idrekanan = NULL;
        for ($x = 0; $x < $jumlah; $x++) {
            $arrdat = $kode['data'];
            $que = $this->db->get_where('tb_header', ['id' => $arrdat[$x]])->row_array();

            if($que['dept_tuju']=='SU'){
                $idrekanan = $que['id_pemasok'];
            }
            $this->db->where('id_header', $arrdat[$x]);
            $this->db->update('tb_detail', ['id_akb' => $kode['id']]);
            $this->helpermodel->isilog($this->db->last_query());
        }
        if ($jumlah > 0) {
            $this->db->select('Count(*) as jumrek');
            $this->db->from('tb_detail');
            $this->db->where('id_akb', $dataheader['id']);
            $hasil = $this->db->get()->row_array();

            $this->db->where('id', $dataheader['id']);
            $this->db->update('tb_header', ['jumlah_barang' => $hasil['jumrek'],'id_rekanan' => $idrekanan]);
        }
        $this->db->trans_complete();
        return $dataheader['id'];
    }
    public function hapusaju($id,$mode)
    {
        $this->db->trans_start();
        if($mode==0){
            $this->db->where('id_header', $id);
            $this->db->delete('tb_detail');
        }else{
            $this->db->where('id_akb', $id);
            $this->db->update('tb_detail', ['id_akb' => NULL]);
            $this->helpermodel->isilog($this->db->last_query());
        }

        $this->db->where('id', $id);
        $this->db->delete('tb_header');
        $this->helpermodel->isilog($this->db->last_query());
        return $this->db->trans_complete();
    }
    public function masukkelampiran($data)
    {
        return $this->db->insert('lampiran', $data);
    }
    public function isiurutakb($id,$no,$qu=0,$array=[]){
        if($qu==0){
            $this->db->where('id',$id);
        }else{
            $this->db->where($array);
        }
        return $this->db->update('tb_detail',['seri_urut_akb'=>$no]);
    }
}
