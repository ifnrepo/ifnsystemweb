<?php
class inv_model extends CI_Model
{
    public function getdata()
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            $dpt = $this->session->userdata('currdept');
            $kat = $this->session->userdata('filterkat');
            $xkat = '';
            if ($kat != '' || $kat != null) {
                $xkat = ' AND id_kategori = ' . $kat;
            }
            $xcari = '';
            $xcari2 = '';
            $xcari3 = '';
            if ($this->session->userdata('katcari') != null) {
                if ($this->session->userdata('kategoricari') == 'Cari Barang') {
                    $xcari = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari2 = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari3 = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                } else {
                    $xcari = " AND if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari2 = " AND if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari3 = " AND if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                }
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,spek,nama_kategori,kode,nobontr,insno,harga,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,idd,idu FROM (";
            $tambah2 = ") pt GROUP BY po,item,dis,id_barang,nobontr,insno";
            $tambah2 .= $dpt == 'GS' ? '' : ",nobontr,insno";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno,stokdept.nobontr,stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,kategori.nama_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome,if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) AS idd,tb_po.spek,stokdept.id as idu
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        WHERE periode = '" . $period . "' AND dept_id = '" . $dpt . "'" . $xkat . $xcari . "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,
                                        tb_detail.item,tb_detail.dis, tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,kategori.nama_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detail.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detail.kgs AS kgsout, satuan.kodesatuan,
                                        3 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1 " . $xkat . $xcari2 . "
                                        UNION ALL 
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,kategori.nama_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'IB' AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xkat . $xcari3 . "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,kategori.nama_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,3 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xkat . $xcari3 . "
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }
    public function getdatadetail($array)
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            $dpt = $this->session->userdata('currdept');
            if ($dpt != 'GS') {
                $tambah1 = "and stokdept.nobontr = '" . $array['nobontr'] . "' and stokdept.insno = '" . $array['insno'] . "'";
                $tambah2 = "and tb_detail.nobontr = '" . $array['nobontr'] . "' and tb_detail.insno = '" . $array['insno'] . "'";
            } else {
                $tambah1 = '';
                $tambah2 = '';
            }
            $kolompcs = "IF(tb_detail.pcs < 0,0,tb_detail.pcs) AS pcsin,IF(tb_detail.pcs < 0,abs(tb_detail.pcs),0) AS pcsout";
            $kolomkgs = "IF(tb_detail.kgs < 0,0,tb_detail.kgs) AS kgsin,IF(tb_detail.kgs < 0,abs(tb_detail.kgs),0) AS kgsout";
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $hasil = $this->db->query("SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno,stokdept.nobontr,stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,kategori.nama_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome,if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) AS idd,tb_po.spek
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        WHERE periode = '" . $period . "' AND dept_id = '" . $dpt . "' 
                                        and stokdept.id_barang = " . $array['id_barang'] . " and stokdept.po = '" . $array['po'] . "' and stokdept.item = '" . $array['item'] . "' and stokdept.dis = " . $array['dis'] . "
                                        " . $tambah1 . "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,
                                        tb_detail.item,tb_detail.dis, tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,kategori.nama_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detail.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detail.kgs AS kgsout, satuan.kodesatuan,3 AS nome,'' as idd,tb_po.spek
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah2 . "
                                        UNION ALL 
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,kategori.nama_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome,'' as idd,tb_po.spek
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'IB' AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah2 . "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,kategori.nama_kategori,0 as pcs,
                                        ".$kolompcs.",
                                        0 as kgs,
                                        ".$kolomkgs.",
                                        satuan.kodesatuan,3 AS nome,'' as idd,tb_po.spek
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah2 . "
                                        ORDER BY nome,tgl");
            return $hasil;
        }
    }
    public function getdatakategori()
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            $dpt = $this->session->userdata('currdept');
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,id_kategori,nama_kategori,kode,nobontr,insno,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout FROM (";
            $tambah2 = ") pt GROUP BY id_kategori,nama_kategori";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno,stokdept.nobontr,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,barang.id_kategori,kategori.nama_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome 
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        WHERE periode = '" . $period . "' AND dept_id = '" . $dpt . "'
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,
                                        tb_detail.item,tb_detail.dis, tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,barang.id_kategori,kategori.nama_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detail.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detail.kgs AS kgsout, satuan.kodesatuan,3 AS nome
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'OUT' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 
                                        UNION ALL 
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,barang.id_kategori,kategori.nama_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'IB' AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.data_ok = 1 
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }
    public function getspekjala($data)
    {
        $hasil = $this->db->query("Select * from tb_po where concat(po,item,dis) = '" . $data . "' ")->row_array();
        return $hasil['spek'];
    }
}
