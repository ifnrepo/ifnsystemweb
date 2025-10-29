<?php
class Ib_model extends CI_Model
{
    public function getdata($kode, $bc)
    {
        if ($kode == 'FG') {
            $arrkondisi = [
                'id_perusahaan' => IDPERUSAHAAN,
                'kode_dok' => 'T',
                'dept_tuju' => $kode,
                // 'month(tgl)' => $this->session->userdata('bl'),
                // 'year(tgl)' => $this->session->userdata('th'),
            ];
            // (PERHATIAN ) Selain kondisi ini, Ada kondisi lain di bawah .. hati-hati #kodeib1
        } else {
            $arrkondisi = [
                'id_perusahaan' => IDPERUSAHAAN,
                'kode_dok' => 'IB',
                'dept_tuju' => $kode,
                // 'month(tgl)' => $this->session->userdata('bl'),
                // 'year(tgl)' => $this->session->userdata('th')
            ];
        }
        $this->db->select('tb_header.*,supplier.nama_supplier as namasupplier');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->where($arrkondisi);
        // Lanjutan #kodeib1
        if ($kode == 'FG') {
            $this->db->where_in('left(nomor_dok,3)', ['IFN', 'DLN', 'MDL']);
        }

        if ($bc != 'Y') {
            $this->db->where("tb_header.jns_bc", (int)$bc);
        } else {
            $this->db->where_in("tb_header.jns_bc", [23, 262, 40]);
        }

        $this->db->where('MONTH(tb_header.tgl)', $this->session->userdata('bl'), FALSE);
        $this->db->where('YEAR(tb_header.tgl)', $this->session->userdata('th'), FALSE);

        $this->db->order_by('tgl', 'desc');
        $this->db->order_by('nomor_dok', 'desc');
        $hasil = $this->db->get('tb_header');
        return $hasil->result_array();
    }

    public function getjumlahdata($kode, $bc)
    {
        if ($kode == 'FG') {
            $arrkondisi = [
                'id_perusahaan' => IDPERUSAHAAN,
                'kode_dok' => 'T',
                'dept_tuju' => $kode,
                // 'month(tgl)' => $this->session->userdata('bl'),
                // 'year(tgl)' => $this->session->userdata('th'),
            ];
            // (PERHATIAN ) Selain kondisi ini, Ada kondisi lain di bawah .. hati-hati #kodeib1
        } else {
            $arrkondisi = [
                'id_perusahaan' => IDPERUSAHAAN,
                'kode_dok' => 'IB',
                'dept_tuju' => $kode,
                // 'month(tgl)' => $this->session->userdata('bl'),
                // 'year(tgl)' => $this->session->userdata('th')
            ];
        }


        $this->db->select('tb_header.*,supplier.nama_supplier as namasupplier, tb_kontrak.nomor as nomorkontrak,sum(jumlah_barang) over() as jumlahitemnya');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->join('tb_kontrak', 'tb_kontrak.id = tb_header.id_kontrak', 'left');
        $this->db->where($arrkondisi);
        // Lanjutan #kodeib1
        if ($kode == 'FG') {
            $this->db->where_in('left(nomor_dok,3)', ['IFN', 'DLN', 'MDL']);
        }

        if ($bc != 'Y') {
            $this->db->where("tb_header.jns_bc", (int)$bc);
        } else {
            $this->db->where_in("tb_header.jns_bc", [23, 262, 40]);
        }

        $this->db->where('MONTH(tb_header.tgl)', $this->session->userdata('bl'), FALSE);
        $this->db->where('YEAR(tb_header.tgl)', $this->session->userdata('th'), FALSE);

        $this->db->order_by('tgl', 'desc');
        $this->db->order_by('nomor_dok', 'desc');
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }
    public function getBc()
    {
        $this->db->select("ref_dok_bc.*");
        $this->db->from('ref_dok_bc');
        $this->db->where('masuk', 1);
        return $this->db->get()->result_array();
    }
    public function getdatabyid($kode)
    {
        $this->db->select('tb_header.*,supplier.nama_supplier as namasupplier,supplier.alamat,supplier.kontak,supplier.npwp,supplier.nik,supplier.jns_pkp,supplier.nama_di_ceisa as namaceisa,supplier.alamat_di_ceisa as alamatceisa,supplier.kode_negara as kodenegara,ref_mt_uang.mt_uang,ref_jns_angkutan.angkutan as angkutlewat,ref_negara.kode_negara');
        $this->db->select('tb_kontrak.nomor as nomorkontrak,tb_kontrak.tgl as tglkontrak,tb_kontrak.tgl_kep,tb_kontrak.nomor_kep,tb_kontrak.id as idkontrak');
        $this->db->select("(select uraian_pelabuhan from ref_pelabuhan where ref_pelabuhan.kode_pelabuhan = tb_header.pelabuhan_muat) as pelmuat");
        $this->db->select("(select uraian_pelabuhan from ref_pelabuhan where ref_pelabuhan.kode_pelabuhan = tb_header.pelabuhan_bongkar) as pelbongkar");
        $this->db->join('dept', 'dept.dept_id=tb_header.dept_id', 'left');
        $this->db->join('supplier', 'supplier.id=tb_header.id_pemasok', 'left');
        $this->db->join('ref_mt_uang', 'ref_mt_uang.id=tb_header.mtuang', 'left');
        $this->db->join('ref_jns_angkutan', 'ref_jns_angkutan.id=tb_header.jns_angkutan', 'left');
        $this->db->join('ref_negara', 'ref_negara.id=tb_header.bendera_angkutan', 'left');
        $this->db->join('tb_kontrak', 'tb_kontrak.id=tb_header.id_kontrak', 'left');
        $query = $this->db->get_where('tb_header', ['tb_header.id' => $kode]);
        return $query->row_array();
    }
    public function getdatadetailbyid($id)
    {
        $this->db->select('tb_detail.*,barang.kode');
        $this->db->from('tb_detail');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('tb_po', 'trim(tb_po.po)=trim(tb_detail.po) and trim(tb_po.item) = trim(tb_detail.item) and tb_po.dis = tb_detail.dis', 'left');
        $this->db->where('tb_detail.id', $id);
        return $this->db->get();
    }
    public function getdatadetailbyidbcasal($kondisi)
    {
        $this->db->select('tb_detail.*,barang.kode');
        $this->db->select('sum(kgs) as kgsx,sum(pcs) as pcsx');
        $this->db->from('tb_detail');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->where($kondisi);
        $this->db->group_by('po,item,dis,id_barang,insno,nobontr');
        return $this->db->get();
    }
    public function getdatadetailib($data, $mode = 0)
    {
        $this->db->select("a.*,b.namasatuan,g.spek,b.kodesatuan,b.kodebc as satbc,c.kode,c.nama_barang,c.nohs,c.kode as brg_id,e.keterangan as keter,d.pcs as pcsmintaa,d.kgs as kgsmintaa,f.nama_kategori,f.kategori_id,'56081100' as hsx");
        $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
        $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
        if ($mode == 1) {
            $this->db->select("sum(a.kgs) as kgsx,sum(a.pcs) as pcsx,a.exbc_cif as xcif,a.exbc_ndpbm as xndpbm");
        }
        $this->db->from('tb_detail a');
        $this->db->join('satuan b', 'b.id = a.id_satuan', 'left');
        $this->db->join('barang c', 'c.id = a.id_barang', 'left');
        $this->db->join('tb_detail d', 'a.id = d.id_ib', 'left');
        $this->db->join('tb_detail e', 'd.id = e.id_bbl', 'left');
        $this->db->join('kategori f', 'f.kategori_id = c.id_kategori', 'left');
        $this->db->join('tb_po g', 'g.po = a.po AND g.item = a.item AND g.dis = a.dis', 'left');
        if ($mode == 0) {
            $this->db->where('a.id_header', $data);
            $this->db->order_by('a.seri_barang');
        } else {
            $this->db->where('a.id_akb', $data);
            $this->db->group_by('a.po,a.item,a.dis,a.id_barang,a.insno,a.nobontr');
            $this->db->order_by('a.po,a.item,a.dis,c.kode,a.insno');
        }
        return $this->db->get()->result_array();
    }
    public function getdatabynomorbc($kode)
    {
        $this->db->select('tb_header.*,sum(bm_rupiah) as bmrupiah,sum(ppn_rupiah) as ppnrupiah,sum(pph_rupiah) as pphrupiah');
        $this->db->from('tb_header');
        $this->db->join('tb_bombc', 'tb_bombc.id_header = tb_header.id', 'left');
        $this->db->where('trim(tb_header.nomor_bc)', $kode);
        return $this->db->get()->row_array();
        // return $this->db->get_where('tb_header',['trim(nomor_bc)' => $kode])->row_array();
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
        $hasil = $this->db->query("SELECT MAX(substr(nomor_dok,14,3)) AS maxkode FROM tb_header 
        WHERE kode_dok = 'IB' AND MONTH(tgl)='" . $bl . "' AND YEAR(tgl)='" . $th . "' AND dept_tuju = '" . $this->session->userdata('curdept') . "' AND LEFT(nomor_dok,3) = 'SU-' ")->row_array();
        return $hasil;
    }
    public function getnomorproforma($bl, $th)
    {
        $hasil = $this->db->query("SELECT MAX(substr(nomor_dok,10,3)) AS maxkode FROM tb_header 
        WHERE kode_dok = 'IB' AND dept_tuju = '" . $this->session->userdata('depttuju') . "' AND nomor_dok like '%PROFORMA%' ")->row_array();
        return $hasil;
    }
    public function tambahdataib()
    {
        $this->db->trans_start();
        $date = $this->session->userdata('th') . '-' . $this->session->userdata('bl') . '-' . date('d');
        $nomordok = nomorproforma();
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
        // $this->db->where('d.dept_id',$this->session->userdata('depttuju'));
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
    public function getbcmasuk()
    {
        $this->db->where('masuk', 1);
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
            'kgs' => 0.00,
            'kosong' => 0,
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
                $cekarr['xpcs']++;
            } else {
                $cekarr['totalharga'] += $isidata['pcs'] * $isidata['harga'];
            }
            if ($isidata['pcs'] == 0 && $isidata['kgs'] == 0) {
                $cekerr['kosong']++;
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
        return $this->db->order_by('uraian_negara')->get('ref_negara');
    }
    public function refpelabuhan()
    {
        return $this->db->order_by('kode_pelabuhan')->get('ref_pelabuhan');
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
        $this->db->update('tb_header', ['send_ceisa' => 1]);
    }
    public function updatebc11($data)
    {
        $caribendera = $this->db->get_where('ref_negara', ['kode_negara' => $data['bendera_angkutan']])->row_array();
        $data['bendera_angkutan'] = $caribendera['id'];
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_header', $data);
        return $hasil;
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
    public function tambahkontainer($data)
    {
        return $this->db->insert('tb_kontainer', $data);
    }
    public function getdatakontainer($id)
    {
        $this->db->select('tb_kontainer.*,ref_ukuran_kontainer.uraian_kontainer as ukurkontainer,ref_jenis_kontainer.uraian_jenis_kontainer as jeniskontainer');
        $this->db->join('ref_ukuran_kontainer', 'ref_ukuran_kontainer.ukuran_kontainer = tb_kontainer.ukuran_kontainer', 'left');
        $this->db->join('ref_jenis_kontainer', 'ref_jenis_kontainer.jenis_kontainer = tb_kontainer.jenis_kontainer', 'left');
        $this->db->where('tb_kontainer.id_header', $id);
        return $this->db->get('tb_kontainer');
    }
    public function hapuskontainer($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('tb_kontainer');
    }
    public function getdataentitas($id)
    {
        $this->db->select('tb_entitas.*,ref_negara.uraian_negara as negara,ref_negara.kode_negara as kodenegara');
        $this->db->join('ref_negara', 'ref_negara.id = tb_entitas.kode_negara', 'left');
        $this->db->where('tb_entitas.id_header', $id);
        $this->db->order_by('tb_entitas.kode_entitas');
        return $this->db->get('tb_entitas');
    }
    public function tambahentitas($data)
    {
        return $this->db->insert('tb_entitas', $data);
    }
    public function hapusenti($id)
    {
        $this->db->where('id', $id);
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
    public function isilampiran23($id)
    {
        $cekdata = $this->db->get_where('lampiran', ['id_header' => $id]);
        $hasil = 1;
        if ($cekdata->num_rows() == 0) {
            $this->db->trans_start();
            for ($i = 0; $i <= 3; $i++) {
                $kodelampiran = $i == 0 ? '380' : '705';
                $kodelampiran = $i == 0 ? '380' : '705';
                switch ($i) {
                    case 0:
                        $kodelampiran = '380';
                        break;
                    case 1:
                        $kodelampiran = '705';
                        break;
                    case 2:
                        $kodelampiran = '217';
                        break;
                    case 3:
                        $kodelampiran = '860';
                        break;
                    default:
                        # code...
                        break;
                }
                $data = [
                    'id_header' => $id,
                    'kode_dokumen' => $kodelampiran
                ];
                $this->db->insert('lampiran', $data);
            }
            $hasil = $this->db->trans_complete();
        }
        return $hasil;
    }
    public function hapusaju($id, $mode = 0)
    {
        $this->db->trans_start();

        if ($mode == 1) {
            $this->db->select("*");
            $this->db->from('tb_detail');
            $this->db->where('id_akb', $id);
            $this->db->group_by('po,item,dis,id_barang,insno,nobontr');
            $hasil = $this->db->get();
            foreach ($hasil->result_array() as $has) {
                $iddet = explode(',', $has['arr_seri_exbc']);
                $idjumdet = explode(',', $has['in_pcs_exbc']);

                $ke = 0;
                foreach ($iddet as $iddet) {
                    $ke++;
                    $this->db->where('id', $iddet);
                    $this->db->update('tb_detail', ['in_exbc' => 'in_exbc - ' . $idjumdet[$ke - 1]]);
                }
            }

            $this->db->where('id_akb', $id);
            $this->db->update('tb_detail', ['id_akb' => NULL, 'id_seri_exbc' => NULL, 'arr_seri_exbc' => NULL, 'exbc_cif' => NULL, 'exbc_ndpbm' => NULL]);
            $this->helpermodel->isilog($this->db->last_query());
        } else {
            $this->db->where('id_header', $id);
            $this->db->delete('tb_detail');
        }
        $this->db->where('id', $id);
        $this->db->delete('tb_header');
        $this->helpermodel->isilog($this->db->last_query());
        return $this->db->trans_complete();
    }
    public function getdatabcasal($data)
    {
        $this->db->select("a.*,b.namasatuan,g.spek,b.kodesatuan,b.kodebc as satbc,c.kode,c.nama_barang,c.nohs,c.kode as brg_id,c.kode,e.keterangan as keter,d.pcs as pcsmintaa,d.kgs as kgsmintaa,f.nama_kategori,f.kategori_id,h.exnomor_bc,'56081100' as hsx,");
        $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
        $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
        $this->db->select("sum(a.kgs) as kgsx,sum(a.pcs) as pcsx");
        $this->db->from('tb_detail a');
        $this->db->join('satuan b', 'b.id = a.id_satuan', 'left');
        $this->db->join('barang c', 'c.id = a.id_barang', 'left');
        $this->db->join('tb_detail d', 'a.id = d.id_ib', 'left');
        $this->db->join('tb_detail e', 'd.id = e.id_bbl', 'left');
        $this->db->join('kategori f', 'f.kategori_id = c.id_kategori', 'left');
        $this->db->join('tb_po g', 'g.po = a.po AND g.item = a.item AND g.dis = a.dis', 'left');
        $this->db->join('tb_header h', 'h.id=a.id_akb', 'left');
        $this->db->where('a.id_akb', $data);
        $this->db->group_by('a.po,a.item,a.dis,a.id_barang,a.insno,a.nobontr');
        $this->db->order_by('a.po,a.item,a.dis,c.kode,a.insno');
        $hasil1 = $this->db->get();
        return $hasil1;
    }
    public function getdatabcasaluntukedit($data, $qu = 0, $kondisi = [])
    {
        $arraybarcek = ['40394', '39991'];
        $this->db->select("a.*,b.namasatuan,g.spek,b.kodesatuan,b.kodebc as satbc,c.kode,c.nama_barang,c.nohs,c.kode as brg_id,c.kode,e.keterangan as keter,d.pcs as pcsmintaa,d.kgs as kgsmintaa,f.nama_kategori,f.kategori_id,h.exnomor_bc,'56081100' as hsx,");
        $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
        $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
        $this->db->select('tb_bombc.cif');
        if ($qu = 0) {
            $this->db->select("sum(a.kgs) as kgsx,sum(a.pcs) as pcsx");
        }
        $this->db->from('tb_detail a');
        $this->db->join('satuan b', 'b.id = a.id_satuan', 'left');
        $this->db->join('barang c', 'c.id = a.id_barang', 'left');
        $this->db->join('tb_detail d', 'a.id = d.id_ib', 'left');
        $this->db->join('tb_detail e', 'd.id = e.id_bbl', 'left');
        $this->db->join('kategori f', 'f.kategori_id = c.id_kategori', 'left');
        $this->db->join('tb_po g', 'g.po = a.po AND g.item = a.item AND g.dis = a.dis', 'left');
        $this->db->join('tb_header h', 'h.id=a.id_akb', 'left');
        $this->db->join('tb_bombc', 'tb_bombc.id_header=a.id_akb and tb_bombc.seri_barang = a.seri_urut_akb', 'left');
        $this->db->where('a.id_akb', $data);
        $this->db->where($kondisi);
        $this->db->where('if(a.id_barang = 40394 OR a.id_barang = 39981,(a.pcs-a.in_exbc) > 0,(a.kgs-a.in_exbc) > 0)');
        if ($qu = 0) {
            $this->db->group_by('a.po,a.item,a.dis,a.id_barang,a.insno,a.nobontr');
            $this->db->order_by('a.po,a.item,a.dis,c.kode,a.insno');
        } else {
            $this->db->order_by('a.seri_urut_akb,a.urut_akb');
        }
        $hasil1 = $this->db->get();
        return $hasil1;
    }
    public function simpanbcasal($id)
    {
        $this->db->trans_start();
        $data = $this->getdatabcasal($id);
        foreach ($data->result_array() as $data) {
            $kondisi = [
                'id_barang' => $data['id_barang'],
                'trim(po)' => trim($data['po']),
                'trim(item)' => trim($data['item']),
                'dis' => $data['dis'],
                'trim(insno)' => trim($data['insno']),
                'trim(nobontr)' => trim($data['nobontr'])
            ];
            $kondisi2 = [
                'id_akb' => $id,
                'trim(po)' => trim($data['po']),
                'trim(item)' => trim($data['item']),
                'dis' => $data['dis'],
                'id_barang' => $data['id_barang'],
                'trim(insno)' => trim($data['insno']),
                'trim(nobontr)' => trim($data['nobontr'])
            ];
            $datdetail = getbcasal($data['exnomor_bc'], $kondisi)->row_array();

            $this->db->where($kondisi2);
            $this->db->update('tb_detail', ['id_seri_exbc' => $datdetail['id'], 'arr_seri_exbc' => trim($datdetail['id']) . ',']);

            $cekcifbcasal = $this->getdatadetailbcasal($data['id']); // Menggunakan Function getdatadetailbcasal
            $jumlahcif = 0;
            $jumlahkgs = 0;
            $ndpbm = 0;
            foreach ($cekcifbcasal['bom'] as $cekcif) {
                $jumlahcif += $cekcif->cif; //$cekcif->bm_rupiah+$cekcif->pph_rupiah+$cekcif->ppn_rupiah;
                $jumlahkgs += $cekcif->kgs;
                $ndpbm = $cekcif->ndpbm;
            }
            $xjmlkgs = $jumlahkgs == 0 ? 1 : $jumlahkgs;
            $datakgsx = $data['kgsx'] == 0 ? 1 : $data['kgsx'];
            $ndpbm = $ndpbm == 0 ? 1 : $ndpbm;
            $pembagicif = $jumlahkgs / $datakgsx;
            $xcif = $jumlahcif / round($pembagicif, 2);
            $this->db->where($kondisi2);
            $this->db->update('tb_detail', ['exbc_cif' => $xcif, 'exbc_ndpbm' => $ndpbm]);

            $this->db->where('id', $id);
            $this->db->update('tb_header', ['kurs_usd' => $ndpbm]);
        }
        $this->helpermodel->isilog('SIMPAN BC Asal (DEFAULT) seri barang nomor dok : ' . $data['id']);
        return $this->db->trans_complete();
    }
    public function getbombcasal($id)
    {
        $this->db->select('tb_detail.*,tb_bombc.seri_barang,tb_bombc.id_barang,barang.kode,barang.nama_barang,tb_bombc.cif,tb_bombc.ndpbm,tb_bombc.bm,tb_bombc.ppn,tb_bombc.pph');
        $this->db->from('tb_detail');
        $this->db->join('tb_bombc', 'tb_bombc.id_header = tb_detail.id_akb', 'left');
        $this->db->join('barang', 'barang.id = tb_bombc.id_barang', 'left');
        $this->db->where('tb_detail.id', $id);
        $this->db->where('tb_bombc.seri_barang = tb_detail.seri_urut_akb');
        return $this->db->get();
    }
    public function getdatadetailbcasal($id)
    {
        $arrhasil = [];
        $this->db->select('tb_detail.*,barang.nama_barang,barang.kode');
        $this->db->from('tb_detail');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->where('tb_detail.id', $id);
        $hasil = $this->db->get()->row_array();
        if (isset($hasil['arr_seri_exbc'])) {
            $kondisi = [
                'id_akb' => $hasil['id_akb'],
                'trim(po)' => trim($hasil['po']),
                'trim(item)' => trim($hasil['item']),
                'dis' => $hasil['dis'],
                'id_barang' => $hasil['id_barang'],
                'trim(insno)' => trim($hasil['insno']),
                'trim(nobontr)' => trim($hasil['nobontr']),
            ];
            $this->db->select('po,item,dis,id_barang,insno,nobontr,seri_urut_akb,kgs,SUM(round(kgs,2)) OVER() AS sumkgs,SUM(round(pcs,2)) OVER() AS sumpcs,barang.kode');
            $this->db->from('tb_detail');
            $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
            $this->db->where($kondisi);

            $xhasil = $this->db->get();
            $arrhasil['detail'] = $xhasil->result();
            $arrhasix = [];

            $arrseriexbc = explode(',', $hasil['arr_seri_exbc']);
            $p = 0;
            foreach ($arrseriexbc as $arrseri) :
                // $hasil2 = $this->db->get_where('tb_detail',['id'=>$hasil['id_seri_exbc']])->row_array();            
                if (!empty($arrseri)) :
                    $hasil2 = $this->db->get_where('tb_detail', ['id' => $arrseriexbc[$p]])->row_array();

                    $kondisi2 = [
                        'id_akb' => $hasil2['id_akb'],
                        'trim(po)' => trim($hasil2['po']),
                        'trim(item)' => trim($hasil2['item']),
                        'dis' => $hasil2['dis'],
                        'tb_detail.id_barang' => $hasil2['id_barang'],
                        'trim(insno)' => trim($hasil2['insno']),
                        'trim(tb_detail.nobontr)' => trim($hasil2['nobontr']),
                    ];
                    $this->db->select('tb_detail.*');
                    $this->db->select('tb_bombc.kgs,SUM(round(tb_bombc.kgs,2)) OVER() AS sumkgs,tb_bombc.seri_barang ,tb_bombc.id_barang,tb_bombc.cif,SUM(tb_bombc.cif) OVER() AS sumcif,tb_bombc.ndpbm,tb_bombc.nobontr');
                    $this->db->select('barang.kode,barang.nama_barang,tb_bombc.bm,tb_bombc.ppn,tb_bombc.pph,tb_bombc.bm_rupiah,tb_bombc.ppn_rupiah,tb_bombc.pph_rupiah');
                    $this->db->select('tb_header.nomor_bc');
                    $this->db->from('tb_detail');
                    $this->db->join('tb_bombc', 'tb_bombc.id_header = tb_detail.id_akb AND tb_bombc.seri_barang = tb_detail.seri_urut_akb', 'left');
                    $this->db->join('barang', 'barang.id = tb_bombc.id_barang', 'left');
                    $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
                    $this->db->where($kondisi2);
                    $this->db->where('tb_detail.id', $arrseriexbc[$p]);

                    $xhasil2 = $this->db->get()->row_array();

                    array_push($arrhasix, $xhasil2);
                    $p++;
                endif;
            endforeach;
        }
        $arrhasil['bom'] = $arrhasix;
        return $arrhasil;
    }
    public function getdatabahanbakuasal($id)
    {
        $this->db->select('tb_detail.*,tb_header.nomor_bc,tb_header.nomor_aju,tb_header.tgl_aju,tb_header.tgl_bc,barang.nama_barang');
        $this->db->from('tb_detail');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_akb', 'left');
        $this->db->where('tb_detail.id', $id);
        return $this->db->get()->row_array();
    }
    public function updatebcasal($id, $kondisi, $nilai, $cife, $ndpbm, $jmll)
    {
        $this->db->trans_start();
        $ke = 0;
        foreach ($nilai as $nil) {
            $ke++;
            $this->db->where('id', $nil);
            $this->db->update('tb_detail', ['in_exbc' => $jmll[$ke - 1]]);
        }
        $this->db->where($kondisi);
        $this->db->update('tb_detail', ['arr_seri_exbc' => implode(",", $nilai), 'exbc_cif' => $cife, 'id_seri_exbc' => $id, 'exbc_ndpbm' => $ndpbm, 'in_pcs_exbc' => implode(",", $jmll)]);
        $this->db->trans_complete();
        $arraymasuk = ['cif' => $cife, 'ndpbm' => $ndpbm];
        return $arraymasuk;
    }
    public function updatekgsbcasal($arrayid, $arrayjml)
    {
        $this->db->trans_start();
        $ke = 0;
        foreach ($arrayid as $nil) {
            $ke++;
            $this->db->where('id', $nil);
            $this->db->update('tb_detail', ['kgs' => $arrayjml[$ke - 1]]);
        }
        return $this->db->trans_complete();
    }
    public function resetbcasal($idheader, $id)
    {
        $this->db->trans_start();
        $hasil = $this->db->get_where('tb_detail', ['id' => $id])->row_array();
        $kondisi = [
            'id_akb' => $idheader,
            'trim(po)' => trim($hasil['po']),
            'trim(item)' => trim($hasil['item']),
            'trim(insno)' => trim($hasil['insno']),
            'dis' => $hasil['dis'],
            'id_barang' => $hasil['id_barang']
        ];
        $this->db->where($kondisi);
        $hasil2 = $this->db->get('tb_detail');
        foreach ($hasil2->result_array() as $has) {
            $arraydetasal = explode(',', $has['arr_seri_exbc']);
            $arrayindetasal = explode(',', $has['in_pcs_exbc']);
            $ke = 0;
            foreach ($arraydetasal as $ardet) {
                $ke++;
                $this->db->where('id', $ardet);
                $this->db->update('tb_detail', ['in_exbc' => 'in_exbc - ' . $arrayindetasal[$ke]]);
            }
        }
        $this->db->where($kondisi);
        $this->db->update('tb_detail', ['arr_seri_exbc' => NULL, 'exbc_cif' => NULL, 'id_seri_exbc' => NULL, 'exbc_ndpbm' => NULL, 'in_pcs_exbc' => NULL]);
        return $this->db->trans_complete();
    }
    public function getdatakontrakbyid($id)
    {
        return $this->db->get_where('tb_kontrak', ['id' => $id])->row_array();
    }
    public function autolampiran($id)
    {
        $this->db->trans_start();
        $header = $this->ibmodel->getdatabyid($id);
        $dataexbc = $this->ibmodel->getdatabynomorbc($header['exnomor_bc']);
        $datakontrak = $this->getdatakontrakbyid($dataexbc['id_kontrak']);
        for ($x = 1; $x <= 4; $x++) {
            switch ($x) {
                case 1:
                    $kode = '203';
                    $nomordok = $datakontrak['nomor_kep'];
                    $tgldok = $datakontrak['tgl_kep'];
                    break;
                case 2:
                    $kode = '315';
                    $nomordok = $datakontrak['nomor'];
                    $tgldok = $datakontrak['tgl'];
                    break;
                case 3:
                    $kode = '261';
                    $nomordok = $dataexbc['nomor_bc'];
                    $tgldok = $dataexbc['tgl_bc'];
                    break;
                case 4:
                    $kode = '999';
                    $nomordok = substr($datakontrak['nomor'], 0, 3);
                    $tgldok = $header['tgl'];
                    break;
            }
            $this->db->insert('lampiran', ['id_header' => $id, 'kode_dokumen' => $kode, 'nomor_dokumen' => $nomordok, 'tgl_dokumen' => $tgldok]);
        }
        return $this->db->trans_complete();
    }
    public function simpankehargamaterial($id)
    {
        $this->db->trans_start();
        $header = $this->getdatabyid($id);
        $this->db->where('id_header', $id);
        $hasil = $this->db->get('tb_detail');
        foreach ($hasil->result_array() as $hasil) {
            $datacekrekod = [
                'id_barang' => $hasil['id_barang'],
                'nobontr' => $header['nomor_dok']
            ];
            $cekrekod = $this->db->get_where('tb_hargamaterial', $datacekrekod);
            if ($cekrekod->num_rows() == 0) {
                $datasimpan = [
                    'id_barang' => $hasil['id_barang'],
                    'nobontr' => $header['nomor_dok'],
                    'price' => $hasil['harga'],
                    'qty' => $hasil['pcs'],
                    'weight' => $hasil['kgs'],
                    'id_satuan' => $hasil['id_satuan'],
                    'id_supplier' => $header['id_pemasok'],
                    'mt_uang' => "IDR",
                    'jns_bc' => $header['jns_bc'],
                    'nomor_bc' => $header['nomor_bc'],
                    'tgl_bc' => $header['tgl_bc'],
                    'tgl' => $header['tgl'],
                    'seri_barang' => $hasil['seri_barang'],
                    'nomor_aju' => $this->getdatanomoraju($id),
                    'tgl_aju' => $header['tgl_aju'],
                    // 'kode_negara' => "ID"
                ];
                $this->db->insert('tb_hargamaterial', $datasimpan);
            }
        }
        return $this->db->trans_complete();
    }
    public function getdatakgsbcasal($arrkonds)
    {
        $this->db->select('tb_detail.*,barang.kode');
        $this->db->from('tb_detail');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->where($arrkonds);
        return $this->db->get();
    }
    public function hapuskontrak($id)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $this->db->update('tb_header', ['id_kontrak' => NULL]);

        return $this->db->trans_complete();
        $this->helpermodel->isilog($this->db->last_query());
    }

    public function UpdateData_gambar($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tb_header', $data);
    }
    public function UpdateData_gambarkedua($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('tb_header', $data);
    }
}
