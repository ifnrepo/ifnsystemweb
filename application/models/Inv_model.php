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
            $bcnya = $this->session->userdata('nomorbcnya');
            $kontbcnya = $this->session->userdata('kontrakbcnya');
            $kat = $this->session->userdata('filterkat');
            $xkat = '';
            $inv = $this->session->userdata('viewinv');
            $xinv = '';
            $xbcnya = '';
            if($kat != 'X'){
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat.'" OR name_nettype = "'.$kat.'") ';
                }
            }
            if ($inv == 0) {
                $xinv = ' AND barang.noinv = 0 ';
            }
            if($bcnya != 'X' && ($this->session->userdata('currdept')=='GM' || $this->session->userdata('currdept')=='SP')){
                if ($bcnya != '') {
                    $xbcnya = ' AND tb_hargamaterial.nomor_bc =  "'.$bcnya.'" ';
                }
            }
            if($kontbcnya != 'X' && $this->session->userdata('currdept')=='GM'){
                if ($kontbcnya != '') {
                    $xbcnya .= ' AND nomor_kont =  "'.$kontbcnya.'" ';
                }
            }
            $xcari = '';
            $xcari2 = '';
            $xcari3 = '';
            $field = ',stokdept.nomor_bc as nomor_bc';
            $field2 = ',"" as nomor_bc';
            $nobalefiel = '';
            $ifndln = ''; $ifndln2 = '';$ifndln3 = '';
            if(trim($this->session->userdata('ifndln'))!='X'){
                $opsidlnin = $this->session->userdata('ifndln')=='dln' ? 1 : 0;
                $ifndln = ' AND stokdept.dln='.$opsidlnin;
                $ifndln2 = ' AND tb_detailgen.dln='.$opsidlnin;
                $ifndln3 = ' AND tb_detail.dln='.$opsidlnin; 
            }
            $join='';$join1='';$join2='';
            if ($this->session->userdata('katcari') != null) {
                if ($this->session->userdata('kategoricari') == 'Cari Barang') {
                    $xcari = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari2 = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari3 = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                } else {
                    $xcari = " AND if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari2 = " AND if(tb_detailgen.po!='',concat(tb_detailgen.po,tb_detailgen.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari3 = " AND if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                }
            }
            if ($dpt == 'GS') {
                $noeb1 = " '' as Nobontr";
                $noeb2 = " '' as Nobontr";
                $noeb3 = " '' as Nobontr";
            } else {
                $noeb1 = "stokdept.nobontr";
                $noeb2 = "tb_detailgen.nobontr";
                $noeb3 = "tb_detail.nobontr";
            }
            if($dpt == 'GM' || $dpt == 'SP'){
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $field2 = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if($dpt == 'GF'){
                $nobalefiel = ',nobale';
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,spek,name_kategori,kode,nobontr,insno,harga,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,idu,user_verif,tgl_verif,
                        SUM(SUM(kgs)+SUM(kgsin)-SUM(kgsout)) OVER (PARTITION BY id_barang) AS totkgs,SUM(SUM(pcs)+SUM(pcsin)-SUM(pcsout)) OVER (PARTITION BY id_barang) AS totpcs,safety_stock,nobale,nomor_bc,id_bom,nomor_kont
                        FROM (";
            $tambah2 = ") pt GROUP BY po,item,dis,id_barang,nobontr,insno,nama_barang,spek".$nobalefiel." ORDER BY nama_barang";
            $tambah2 .= $dpt == 'GS' ? '' : ",spek desc,nobontr,insno";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno," . $noeb1 . ",stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,stokdept.id_bom,1 AS nome,tb_po.spek,stokdept.id as idu,stokdept.user_verif,stokdept.tgl_verif,barang.safety_stock,stokdept.nobale,stokdept.nomor_kont".$field."
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join."
                                        WHERE kgs_awal+pcs_awal > 0 AND periode = '" . $period . "' AND dept_id = '" . $dpt . "'" . $xinv . $xkat . $xcari . $xbcnya.$ifndln. "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno," . $noeb2 . ",tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout, satuan.kodesatuan,
                                        0 as id_bom,3 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detailgen.nobale,tb_header.nomor_kont".$field2."
                                        FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detailgen.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join1."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 " . $xinv . $xkat . $xcari2 .$xbcnya.$ifndln2.  "
                                        UNION ALL   
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,0 as id_bom,2 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale,tb_header.nomor_kont".$field2."
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 .$xbcnya.$ifndln3.  "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,0 as id_bom,3 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale,tb_header.nomor_kont".$field2."
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya.$ifndln3. "
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
            $field = ',"" as nomor_bc';
            $join='';$join1='';$join2='';
            $nobalefiel = '';
            $nobalefiel2 = '';
            $nobalefiel3 = '';
            if ($dpt != 'GS') {
                $tambah1 = "and stokdept.nobontr = '" . $array['nobontr'] . "' and stokdept.insno = '" . $array['insno'] . "'";
                $tambah2 = "and tb_detailgen.nobontr = '" . $array['nobontr'] . "' and tb_detailgen.insno = '" . $array['insno'] . "'";
                $tambah3 = "and tb_detail.nobontr = '" . $array['nobontr'] . "' and tb_detail.insno = '" . $array['insno'] . "'";
            } else {
                $tambah1 = '';
                $tambah2 = '';
                $tambah3 = '';
            }
            if($dpt == 'GM'){
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if($dpt == 'GF'){
                $nobalefiel = " and stokdept.nobale = '" . $array['nobale'] . "'";
                $nobalefiel2 = " and tb_detailgen.nobale = '" . $array['nobale'] . "'";
                $nobalefiel3 = " and tb_detail.nobale = '" . $array['nobale'] . "'";
            }
            $kolompcs = "IF(tb_detail.pcs < 0,0,tb_detail.pcs) AS pcsin,IF(tb_detail.pcs < 0,abs(tb_detail.pcs),0) AS pcsout";
            $kolomkgs = "IF(tb_detail.kgs < 0,0,tb_detail.kgs) AS kgsin,IF(tb_detail.kgs < 0,abs(tb_detail.kgs),0) AS kgsout";
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $hasil = $this->db->query("SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno,stokdept.nobontr,stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,0 as pcsadj,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,0 as kgsadj,
                                        satuan.kodesatuan,stokdept.id_bom,1 AS nome,if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) AS idd,tb_po.spek,stokdept.nobale,barang.safety_stock".$field."
                                        ,stokdept.nomor_bc as xbc ,stokdept.tgl_bc as xtgl_bc FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype".$join."
                                        WHERE periode = '" . $period . "' AND dept_id = '" . $dpt . "' 
                                        and stokdept.id_barang = " . $array['id_barang'] . " and stokdept.po = '" . $array['po'] . "' and stokdept.item = '" . $array['item'] . "' and stokdept.dis = " . $array['dis'] . "
                                        " . $tambah1 .$nobalefiel. "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno,tb_detailgen.nobontr,tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as pcsadj,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout,0 as kgsout, satuan.kodesatuan,0 as id_bom,3 AS nome,'' as idd,tb_po.spek,tb_detailgen.nobale,barang.safety_stock".$field."
                                        ,'' as xbc,'0000-00-00' as xtgl_bc FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detailgen.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype".$join1."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 
                                        AND tb_detailgen.id_barang = " . $array['id_barang'] . " and tb_detailgen.po = '" . $array['po'] . "' and tb_detailgen.item = '" . $array['item'] . "' and tb_detailgen.dis = " . $array['dis'] . "
                                        " . $tambah2 .$nobalefiel2. "
                                        UNION ALL 
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as pcsadj,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,0 as kgsadj,satuan.kodesatuan,0 as id_bom,2 AS nome,'' as idd,tb_po.spek,tb_detail.nobale,barang.safety_stock".$field."
                                        ,'' as xbc,'0000-00-00' as xtgl_bc FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah3 .$nobalefiel3. "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,
                                        0 as pcsin,0 as pcsout,tb_detail.pcs as pcsadj,
                                        0 as kgs,
                                        0 as kgsin,0 as kgsout,tb_detail.kgs as kgsadj,
                                        satuan.kodesatuan,0 as id_bom,3 AS nome,'' as idd,tb_po.spek,tb_detail.nobale,barang.safety_stock".$field."
                                        ,'' as xbc,'0000-00-00' as xtgl_bc FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah3 .$nobalefiel3. "
                                        ORDER BY po,item,dis,nobontr,nome,tgl");
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
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,id_kategori,name_kategori,kode,nobontr,insno,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout FROM (";
            $tambah2 = ") pt GROUP BY id_kategori,name_kategori";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno,stokdept.nobontr,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome 
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        WHERE periode = '" . $period . "' AND dept_id = '" . $dpt . "'
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,
                                        tb_detail.item,tb_detail.dis, tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detail.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detail.kgs AS kgsout, satuan.kodesatuan,3 AS nome
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'OUT' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 
                                        UNION ALL 
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'IB' AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.data_ok = 1 
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }
    public function getdatabc()
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            $dpt = $this->session->userdata('currdept');
            $kat = $this->session->userdata('filterkat');
            $xkat = '';
            if($kat != 'X'){
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat.'") ';
                }
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,id_kategori,name_kategori,kode,nobontr,insno,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,nomor_bc,tgl_bc,jns_bc FROM (";
            $tambah2 = ") pt GROUP BY nomor_bc ORDER BY jns_bc,nomor_bc,tgl_bc";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno,stokdept.nobontr,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc,tb_hargamaterial.jns_bc
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        LEFT JOIN tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ''
                                        WHERE periode = '" . $period . "' AND dept_id = '" . $dpt . "' ".$xkat."
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,
                                        tb_detail.item,tb_detail.dis, tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detail.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detail.kgs AS kgsout, satuan.kodesatuan,3 AS nome,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc,tb_hargamaterial.jns_bc
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        LEFT JOIN tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ''
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'OUT' AND tb_header.dept_id='" . $dpt . "' ".$xkat." AND tb_header.data_ok = 1 
                                        UNION ALL 
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc,tb_hargamaterial.jns_bc
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        LEFT JOIN tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ''
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'IB' AND tb_header.dept_tuju='" . $dpt ."' ".$xkat." AND tb_header.data_ok = 1 
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }
    public function getdatakontbc()
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            $dpt = $this->session->userdata('currdept');
            $kat = $this->session->userdata('filterkat');
            $xkat = '';
            if($kat != 'X'){
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat.'") ';
                }
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,id_kategori,name_kategori,kode,nobontr,insno,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,nomor_bc,tgl_bc,jns_bc,nomor_kont,tgl_kont FROM (";
            $tambah2 = ") pt GROUP BY nomor_kont ORDER BY nomor_kont,tgl_kont";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno,stokdept.nobontr,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc,tb_hargamaterial.jns_bc,stokdept.nomor_kont,stokdept.tgl_kont
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        LEFT JOIN tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ''
                                        WHERE periode = '" . $period . "' AND dept_id = '" . $dpt . "' ".$xkat."
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,
                                        tb_detail.item,tb_detail.dis, tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detail.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detail.kgs AS kgsout, satuan.kodesatuan,3 AS nome,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc,tb_hargamaterial.jns_bc,tb_header.nomor_kont,tb_header.tgl_kont
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        LEFT JOIN tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ''
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'OUT' AND tb_header.dept_id='" . $dpt . "' ".$xkat." AND tb_header.data_ok = 1 
                                        UNION ALL 
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc,tb_hargamaterial.jns_bc,tb_header.nomor_kont,tb_header.tgl_kont
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        LEFT JOIN tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ''
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'IB' AND tb_header.dept_tuju='" . $dpt ."' ".$xkat." AND tb_header.data_ok = 1 
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }
    public function getspekjala($data)
    {
        $hasil = $this->db->query("Select * from tb_po where concat(po,item,dis) = '" . $data . "' ")->row_array();
        return $hasil['spek'];
    }
    public function verifikasidata($id)
    {
        $kondisi = [
            'user_verif' => $this->session->userdata('id'),
            'tgl_verif' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id', $id);
        $simpan = $this->db->update('stokdept', $kondisi);
        if ($simpan) {
            $kode = $this->getdatasaldo($id);
            $arraye = [substr(datauser($this->session->userdata('id'), 'username'), 0, 9), date('Y-m-d H:i:s'), $kode['idu'], $kode['nama_barang']];
        }
        return $arraye;
    }
    public function cancelverifikasidata($id)
    {
        $kondisi = [
            'user_verif' => 0,
            'tgl_verif' => null
        ];
        $this->db->where('id', $id);
        $simpan = $this->db->update('stokdept', $kondisi);
        if ($simpan) {
            $kode = $this->getdatasaldo($id);
            $arraye = [$kode['idu'], $kode['nama_barang']];
        }
        return $arraye;
    }
    public function getdatasaldo($id)
    {
        $this->db->select('*,stokdept.id as idu');
        $this->db->from('stokdept');
        $this->db->join('barang', 'barang.id = stokdept.id_barang', 'left');
        $this->db->where('stokdept.id', $id);
        return $this->db->get()->row_array();
    }
    public function getdatadok($kondisi)
    {
        return $this->db->get_where('tb_hargamaterial', $kondisi);
    }
    public function getdatawip(){
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            if($this->session->userdata('currdept')=='X'){
                $dpt = 'X';
                $dpx = "dept_id in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
                $dpy = "dept_tuju in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
            }else{
                $dpt = $this->session->userdata('currdept');
                $dpx = 'dept_id = "'.$this->session->userdata('currdept').'" ';
                $dpy = 'dept_tuju = "'.$this->session->userdata('currdept').'" ';
            }
            // $dpt = ['SP','NT','RR','GP','FG','FN','AR','AN','NU','AM']; //$this->session->userdata('currdept');
            $bcnya = $this->session->userdata('nomorbcnya');
            $kat = $this->session->userdata('filterkat');
            $xkat = '';
            $inv = $this->session->userdata('viewinv');
            $xinv = '';
            $xbcnya = '';
            if($kat != 'X'){
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat.'" OR name_nettype = "'.$kat.'") ';
                }
            }
            if ($inv == 0) {
                $xinv = ' AND barang.noinv = 0 ';
            }
            if($bcnya != 'X' && ($this->session->userdata('currdept')=='GM' || $this->session->userdata('currdept')=='SP')){
                if ($bcnya != '') {
                    $xbcnya = ' AND tb_hargamaterial.nomor_bc =  "'.$bcnya.'" ';
                }
            }
            $xcari = '';
            $xcari2 = '';
            $xcari3 = '';
            $field = ',"" as nomor_bc';
            $nobalefiel = '';
            $ifndln = ''; $ifndln2 = '';$ifndln3 = '';
            if(trim($this->session->userdata('ifndln'))!='X'){
                $opsidlnin = $this->session->userdata('ifndln')=='dln' ? 1 : 0;
                $ifndln = ' AND stokdept.dln='.$opsidlnin;
                $ifndln2 = ' AND tb_detailgen.dln='.$opsidlnin;
                $ifndln3 = ' AND tb_detail.dln='.$opsidlnin; 
            }
            $join='';$join1='';$join2='';
            if ($this->session->userdata('katcari') != null) {
                if ($this->session->userdata('kategoricari') == 'Cari Barang') {
                    $xcari = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari2 = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari3 = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                } else {
                    $xcari = " AND if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari2 = " AND if(tb_detailgen.po!='',concat(tb_detailgen.po,tb_detailgen.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari3 = " AND if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                }
            }
            if ($dpt == 'GS') {
                $noeb1 = " '' as Nobontr";
                $noeb2 = " '' as Nobontr";
                $noeb3 = " '' as Nobontr";
            } else {
                $noeb1 = "stokdept.nobontr";
                $noeb2 = "tb_detailgen.nobontr";
                $noeb3 = "tb_detail.nobontr";
            }
            if($dpt == 'GM' || $dpt == 'SP'){
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if($dpt == 'GF'){
                $nobalefiel = ',nobale';
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT dept_idx,tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,spek,name_kategori,kode,nobontr,insno,harga,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,idd,idu,user_verif,tgl_verif,
                        SUM(SUM(kgs)+SUM(kgsin)-SUM(kgsout)) OVER (PARTITION BY id_barang) AS totkgs,SUM(SUM(pcs)+SUM(pcsin)-SUM(pcsout)) OVER (PARTITION BY id_barang) AS totpcs,safety_stock,nobale
                        FROM (";
            $tambah2 = ") pt GROUP BY dept_idx,po,item,dis,id_barang,nobontr,insno".$nobalefiel." ORDER BY nama_barang";
            $tambah2 .= $dpt == 'GS' ? '' : ",idd,nobontr,insno";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno," . $noeb1 . ",stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome,if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) AS idd,tb_po.spek,stokdept.id as idu,stokdept.user_verif,stokdept.tgl_verif,barang.safety_stock,stokdept.nobale".$field."
                                        ,stokdept.dept_id as dept_idx FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join."
                                        WHERE kgs_awal+pcs_awal > 0 AND periode = '" . $period . "' AND " . $dpx . $xinv . $xkat . $xcari . $xbcnya.$ifndln. "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno," . $noeb2 . ",tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout, satuan.kodesatuan,
                                        3 AS nome,if(tb_detailgen.po!='',concat(tb_detailgen.po,tb_detailgen.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detailgen.nobale".$field."
                                        ,tb_header.dept_id as dept_idx FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detailgen.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join1."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 " . $xinv . $xkat . $xcari2 .$xbcnya.$ifndln2.  "
                                        UNION ALL   
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale".$field."
                                        ,tb_header.dept_tuju as dept_idx FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header." . $dpy . " AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 .$xbcnya.  "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,3 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale".$field."
                                        ,tb_header.dept_id as dept_idx FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya.$ifndln3. "
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }
    public function getdatakategoriwip()
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            // $dpt = $this->session->userdata('currdept');
            if($this->session->userdata('currdept')=='X'){
                $dpt = 'X';
                $dpx = "dept_id in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
                $dpy = "dept_tuju in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
            }else{
                $dpt = $this->session->userdata('currdept');
                $dpx = 'dept_id = "'.$this->session->userdata('currdept').'" ';
                $dpy = 'dept_tuju = "'.$this->session->userdata('currdept').'" ';
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,id_kategori,name_kategori,kode,nobontr,insno,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout FROM (";
            $tambah2 = ") pt GROUP BY id_kategori,name_kategori";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno,stokdept.nobontr,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome 
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        WHERE periode = '" . $period . "' AND " . $dpx . "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,
                                        tb_detail.item,tb_detail.dis, tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detail.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detail.kgs AS kgsout, satuan.kodesatuan,3 AS nome
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'OUT' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 
                                        UNION ALL 
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,barang.id_kategori,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'IB' AND tb_header." . $dpy . " AND tb_header.data_ok = 1 
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }
    public function getdatadetailwip($array)
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            // $dpt = $this->session->userdata('currdept');
            if($this->session->userdata('currdept')=='X'){
                $dpt = 'X';
                $dpx = "dept_id in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
                $dpy = "dept_tuju in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
            }else{
                $dpt = $this->session->userdata('currdept');
                $dpx = 'dept_id = "'.$this->session->userdata('currdept').'" ';
                $dpy = 'dept_tuju = "'.$this->session->userdata('currdept').'" ';
            }
            $field = ',"" as nomor_bc';
            $join='';$join1='';$join2='';
            $nobalefiel = '';
            $nobalefiel2 = '';
            $nobalefiel3 = '';
            if ($dpt != 'GS') {
                $tambah1 = "and stokdept.nobontr = '" . $array['nobontr'] . "' and stokdept.insno = '" . $array['insno'] . "'";
                $tambah2 = "and tb_detailgen.nobontr = '" . $array['nobontr'] . "' and tb_detailgen.insno = '" . $array['insno'] . "'";
                $tambah3 = "and tb_detail.nobontr = '" . $array['nobontr'] . "' and tb_detail.insno = '" . $array['insno'] . "'";
            } else {
                $tambah1 = '';
                $tambah2 = '';
                $tambah3 = '';
            }
            if($dpt == 'GM'){
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if($dpt == 'GF'){
                $nobalefiel = " and stokdept.nobale = '" . $array['nobale'] . "'";
                $nobalefiel2 = " and tb_detailgen.nobale = '" . $array['nobale'] . "'";
                $nobalefiel3 = " and tb_detail.nobale = '" . $array['nobale'] . "'";
            }
            $kolompcs = "IF(tb_detail.pcs < 0,0,tb_detail.pcs) AS pcsin,IF(tb_detail.pcs < 0,abs(tb_detail.pcs),0) AS pcsout";
            $kolomkgs = "IF(tb_detail.kgs < 0,0,tb_detail.kgs) AS kgsin,IF(tb_detail.kgs < 0,abs(tb_detail.kgs),0) AS kgsout";
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $hasil = $this->db->query("SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno,stokdept.nobontr,stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,0 as pcsadj,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,0 as kgsadj,
                                        satuan.kodesatuan,stokdept.id_bom,1 AS nome,if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) AS idd,tb_po.spek,stokdept.nobale".$field."
                                        ,stokdept.nomor_bc as xbc ,stokdept.tgl_bc as xtgl_bc FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype".$join."
                                        WHERE periode = '" . $period . "' AND " . $dpx . "
                                        and stokdept.id_barang = " . $array['id_barang'] . " and stokdept.po = '" . $array['po'] . "' and stokdept.item = '" . $array['item'] . "' and stokdept.dis = " . $array['dis'] . "
                                        " . $tambah1 .$nobalefiel. "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno,tb_detailgen.nobontr,tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as pcsadj,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout,0 as kgsout, satuan.kodesatuan,0 as id_bom,3 AS nome,'' as idd,tb_po.spek,tb_detailgen.nobale".$field."
                                        ,'' as xbc,'0000-00-00' as xtgl_bc FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detailgen.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype".$join1."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 
                                        AND tb_detailgen.id_barang = " . $array['id_barang'] . " and tb_detailgen.po = '" . $array['po'] . "' and tb_detailgen.item = '" . $array['item'] . "' and tb_detailgen.dis = " . $array['dis'] . "
                                        " . $tambah2 .$nobalefiel2. "
                                        UNION ALL 
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as pcsadj,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,0 as kgsadj,satuan.kodesatuan,0 as id_bom,2 AS nome,'' as idd,tb_po.spek,tb_detail.nobale".$field."
                                        ,'' as xbc,'0000-00-00' as xtgl_bc FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header." . $dpy . " AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah3 .$nobalefiel3. "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,
                                        0 as pcsin,0 as pcsout,tb_detail.pcs as pcsadj,
                                        0 as kgs,
                                        0 as kgsin,0 as kgsout,tb_detail.kgs as kgsadj,
                                        satuan.kodesatuan,0 as id_bom,3 AS nome,'' as idd,tb_po.spek,tb_detail.nobale".$field."
                                        ,'' as xbc,'0000-00-00' as xtgl_bc FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah3 .$nobalefiel3. "
                                        ORDER BY po,item,dis,nobontr,nome,tgl");
            return $hasil;
        }
    }
    public function getdatadetailbom($id){
        $this->db->select('det_bommaterial.*,barang.nama_barang,satuan.namasatuan,barang.kode,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc,tb_hargamaterial.jns_bc');
        $this->db->join('barang','barang.id = det_bommaterial.id_barang','left');
        $this->db->join('satuan','satuan.id = barang.id_satuan','left');
        $this->db->join('tb_hargamaterial','tb_hargamaterial.id_barang = det_bommaterial.id_barang AND tb_hargamaterial.nobontr = det_bommaterial.nobontr','left');
        $this->db->where('id_bommaterial',$id);
        return $this->db->get('det_bommaterial');
    }
    public function getdatawipbaru($filter_kategori,$filt_ifndln)
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            if($this->session->userdata('currdept')=='X'){
                $dpt = 'X';
                $dpx = "dept_id in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
                $dpy = "dept_tuju in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
            }else{
                $dpt = $this->session->userdata('currdept');
                $dpx = 'dept_id = "'.$this->session->userdata('currdept').'" ';
                $dpy = 'dept_tuju = "'.$this->session->userdata('currdept').'" ';
            }
            // $dpt = ['SP','NT','RR','GP','FG','FN','AR','AN','NU','AM']; //$this->session->userdata('currdept');
            $bcnya = $this->session->userdata('nomorbcnya');
            $kat = $filter_kategori=='X' ? 'X' :$this->session->userdata('filterkat');
            $xkat = '';
            $inv = $this->session->userdata('viewinv');
            $xinv = '';
            $xbcnya = '';
            if($kat != 'X'){
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat.'" OR name_nettype = "'.$kat.'") ';
                }
            }
            if ($inv == 0) {
                $xinv = ' AND barang.noinv = 0 ';
            }
            if($bcnya != 'X' && ($this->session->userdata('currdept')=='GM' || $this->session->userdata('currdept')=='SP')){
                if ($bcnya != '') {
                    $xbcnya = ' AND tb_hargamaterial.nomor_bc =  "'.$bcnya.'" ';
                }
            }
            $ifndln = ''; $ifndln2 = '';$ifndln3 = '';
            if(trim($this->session->userdata('ifndln'))!='X'){
                $opsidlnin = $this->session->userdata('ifndln')=='dln' ? 1 : 0;
                $ifndln = ' AND stokdept.dln='.$opsidlnin;
                $ifndln2 = ' AND tb_detailgen.dln='.$opsidlnin;
                $ifndln3 = ' AND tb_detail.dln='.$opsidlnin; 
            }
            $xcari = '';
            $xcari2 = '';
            $xcari3 = '';
            $field = ',"" as nomor_bc';
            $nobalefiel = '';
            $join='';$join1='';$join2='';
            if ($this->session->userdata('katcari') != null) {
                if ($this->session->userdata('kategoricari') == 'Cari Barang') {
                    $xcari = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari2 = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari3 = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                } else {
                    $xcari = " AND if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari2 = " AND if(tb_detailgen.po!='',concat(tb_detailgen.po,tb_detailgen.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari3 = " AND if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                }
            }
            if ($dpt == 'GS') {
                $noeb1 = " '' as Nobontr";
                $noeb2 = " '' as Nobontr";
                $noeb3 = " '' as Nobontr";
            } else {
                $noeb1 = "stokdept.nobontr";
                $noeb2 = "tb_detailgen.nobontr";
                $noeb3 = "tb_detail.nobontr";
            }
            if($dpt == 'GM' || $dpt == 'SP'){
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if($dpt == 'GF'){
                $nobalefiel = ',nobale';
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT dept_idx,tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,spek,name_kategori,kode,nobontr,insno,harga,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,idd,idu,user_verif,tgl_verif,
                        SUM(SUM(kgs)+SUM(kgsin)-SUM(kgsout)) OVER (PARTITION BY id_barang) AS totkgs,SUM(SUM(pcs)+SUM(pcsin)-SUM(pcsout)) OVER (PARTITION BY id_barang) AS totpcs,safety_stock,nobale
                        FROM (";
            $tambah2 = ") pt GROUP BY dept_idx,po,item,dis,id_barang,nobontr,insno".$nobalefiel." ORDER BY nama_barang";
            $tambah2 .= $dpt == 'GS' ? '' : ",idd,nobontr,insno";
            // if ($_POST['length'] != -1){
            //     $tambah3 = ' limit '.$_POST['start'].','.$_POST['length'];
            // }else{
                $tambah3 = '';
            // }
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno," . $noeb1 . ",stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome,if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) AS idd,tb_po.spek,stokdept.id as idu,stokdept.user_verif,stokdept.tgl_verif,barang.safety_stock,stokdept.nobale".$field."
                                        ,stokdept.dept_id as dept_idx FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join."
                                        WHERE kgs_awal+pcs_awal > 0 AND periode = '" . $period . "' AND " . $dpx . $xinv . $xkat . $xcari . $xbcnya.$ifndln. "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno," . $noeb2 . ",tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout, satuan.kodesatuan,
                                        3 AS nome,if(tb_detailgen.po!='',concat(tb_detailgen.po,tb_detailgen.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detailgen.nobale".$field."
                                        ,tb_header.dept_id as dept_idx FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detailgen.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join1."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 " . $xinv . $xkat . $xcari2 .$xbcnya.$ifndln2.  "
                                        UNION ALL   
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale".$field."
                                        ,tb_header.dept_tuju as dept_idx FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header." . $dpy . " AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 .$xbcnya.$ifndln3.  "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,3 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale".$field."
                                        ,tb_header.dept_id as dept_idx FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya.$ifndln3. "
                                        ORDER BY nama_barang,tgl,nome" . $tambah2.$tambah3);
            return $hasil;
        }
    }
    public function get_datatableswip($filter_kategori,$filt_ifndln)
    {
        $query = $this->getdatawipbaru($filter_kategori,$filt_ifndln);
        return $query->result();
    }
    public function count_filteredwip($filter_kategori,$filt_ifndln)
    {
        $query = $this->getdatawipbaru($filter_kategori,$filt_ifndln);
        $jmlfilt =  $query->num_rows();
        return $jmlfilt;
    }
    public function count_allwip()
    {
        $query = $this->getdatawipbaru('X','X');
        $jml = $query->num_rows();
        return $jml;
    }
    public function getkgspcswip($filter_kategori,$filt_ifndln){
        $pcs=0;$kgs=0;
        $query = $this->getdatawipbaru($filter_kategori,$filt_ifndln);
        $no = 0;
        foreach ($query->result_array() as $quer){
            $no++;
            $pcs += $quer['pcs']+$quer['pcsin']-$quer['pcsout'];
            $kgs += $quer['kgs']+$quer['kgsin']-$quer['kgsout'];
        }
        return array('rekod'=>$no,'pecees'=>$pcs,'kagees'=>$kgs);
    }

    public function getdatagf()
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            $dpt = $this->session->userdata('currdept');
            $bcnya = $this->session->userdata('nomorbcnya');
            $kat = $this->session->userdata('filterkat');
            $xkat = '';
            $inv = $this->session->userdata('viewinv');
            $xinv = '';
            $xbcnya = '';
            if($kat != 'X'){
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat.'" OR name_nettype = "'.$kat.'") ';
                }
            }
            if ($inv == 0) {
                $xinv = ' AND barang.noinv = 0 ';
            }
            if($bcnya != 'X' && ($this->session->userdata('currdept')=='GM' || $this->session->userdata('currdept')=='SP')){
                if ($bcnya != '') {
                    $xbcnya = ' AND tb_hargamaterial.nomor_bc =  "'.$bcnya.'" ';
                }
            }
            $ifndln = ''; $ifndln2 = '';$ifndln3 = '';
            if(trim($this->session->userdata('ifndln'))!='X'){
                $opsidlnin = $this->session->userdata('ifndln')=='dln' ? 1 : 0;
                $ifndln = ' AND stokdept.dln='.$opsidlnin;
                $ifndln2 = ' AND tb_detailgen.dln='.$opsidlnin;
                $ifndln3 = ' AND tb_detail.dln='.$opsidlnin; 
            }
            $xcari = '';
            $xcari2 = '';
            $xcari3 = '';
            $field = ',stokdept.nomor_bc as nomor_bc';
            $field2 = ',"" as nomor_bc';
            $nobalefiel = '';
            $join='';$join1='';$join2='';
            if ($this->session->userdata('katcari') != null) {
                if ($this->session->userdata('kategoricari') == 'Cari Barang') {
                    $xcari = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari2 = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari3 = " AND barang.nama_barang LIKE '%" . $this->session->userdata('katcari') . "%'";
                } else {
                    $xcari = " AND if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari2 = " AND if(tb_detailgen.po!='',concat(tb_detailgen.po,tb_detailgen.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                    $xcari3 = " AND if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) LIKE '%" . $this->session->userdata('katcari') . "%'";
                }
            }
            if ($dpt == 'GS') {
                $noeb1 = " '' as Nobontr";
                $noeb2 = " '' as Nobontr";
                $noeb3 = " '' as Nobontr";
            } else {
                $noeb1 = "stokdept.nobontr";
                $noeb2 = "tb_detailgen.nobontr";
                $noeb3 = "tb_detail.nobontr";
            }
            if($dpt == 'GM' || $dpt == 'SP'){
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $field2 = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if($dpt == 'GF'){
                $nobalefiel = ',nobale';
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,spek,name_kategori,kode,nobontr,insno,harga,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,idu,user_verif,tgl_verif,
                        SUM(SUM(kgs)+SUM(kgsin)-SUM(kgsout)) OVER (PARTITION BY id_barang) AS totkgs,SUM(SUM(pcs)+SUM(pcsin)-SUM(pcsout)) OVER (PARTITION BY id_barang) AS totpcs,safety_stock,nobale,nomor_bc,id_bom
                        FROM (";
            $tambah2 = ") pt GROUP BY po,item,dis,id_barang,nobontr,insno,nama_barang,spek".$nobalefiel." ORDER BY nama_barang";
            $tambah2 .= $dpt == 'GS' ? '' : ",spek desc,nobontr,insno";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno," . $noeb1 . ",stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,stokdept.id_bom,1 AS nome,tb_po.spek,stokdept.id as idu,stokdept.user_verif,stokdept.tgl_verif,barang.safety_stock,stokdept.nobale".$field."
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join."
                                        WHERE kgs_awal+pcs_awal > 0 AND periode = '" . $period . "' AND dept_id = '" . $dpt . "'" . $xinv . $xkat . $xcari . $xbcnya.$ifndln. "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno," . $noeb2 . ",tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout, satuan.kodesatuan,
                                        0 as id_bom,3 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detailgen.nobale".$field2."
                                        FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detailgen.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join1."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 " . $xinv . $xkat . $xcari2 .$xbcnya.$ifndln2.  "
                                        UNION ALL   
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,0 as id_bom,2 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale".$field2."
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 .$xbcnya.$ifndln3.  "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,0 as id_bom,3 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale".$field2."
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype ".$join2."
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya.$ifndln3. "
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }
    public function get_datatablesgf($filter_kategori,$filt_ifndln)
    {
        $query = $this->getdatagf($filter_kategori,$filt_ifndln);
        return $query->result();
    }
    public function count_filteredgf($filter_kategori,$filt_ifndln)
    {
        $query = $this->getdatagf($filter_kategori,$filt_ifndln);
        $jmlfilt =  $query->num_rows();
        return $jmlfilt;
    }
    public function count_allgf()
    {
        $query = $this->getdatagf('X');
        $jml = $query->num_rows();
        return $jml;
    }
    public function getkgspcsgf($filter_kategori,$filt_ifndln){
        $pcs=0;$kgs=0;
        $query = $this->getdatagf($filter_kategori,$filt_ifndln);
        $no = 0;
        foreach ($query->result_array() as $quer){
            $no++;
            $pcs += $quer['pcs']+$quer['pcsin']-$quer['pcsout'];
            $kgs += $quer['kgs']+$quer['kgsin']-$quer['kgsout'];
        }
        return array('rekod'=>$no,'pecees'=>$pcs,'kagees'=>$kgs);
    }
}
