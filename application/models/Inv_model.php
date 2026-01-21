<?php
class inv_model extends CI_Model
{
    public function Xgetdata()
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
            if ($kat != 'X') {
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat . '" OR name_nettype = "' . $kat . '") ';
                }
            }
            if ($inv == 0) {
                $xinv = ' AND barang.noinv = 0 ';
            }
            if ($bcnya != 'X' && ($this->session->userdata('currdept') == 'GM' || $this->session->userdata('currdept') == 'SP')) {
                if ($bcnya != '') {
                    $xbcnya = ' AND tb_hargamaterial.nomor_bc =  "' . $bcnya . '" ';
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
            $ifndln = '';
            $ifndln2 = '';
            $ifndln3 = '';
            if (trim($this->session->userdata('ifndln')) != 'X') {
                $opsidlnin = $this->session->userdata('ifndln') == 'dln' ? 1 : 0;
                $ifndln = ' AND stokdept.dln=' . $opsidlnin;
                $ifndln2 = ' AND tb_detailgen.dln=' . $opsidlnin;
                $ifndln3 = ' AND tb_detail.dln=' . $opsidlnin;
            }
            $join = '';
            $join1 = '';
            $join2 = '';
            $kueriexdo = '';
            $kuerinomorbc = '';
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
            if ($dpt == 'GM' || $dpt == 'SP') {
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $field2 = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if ($dpt == 'GF') {
                $nobalefiel = ',nobale';
                $exdo = $this->session->userdata('exdonya');
                $kueriexdo = " and tb_po.exdo = '".$exdo."' ";
            }
            if(in_array($dpt,daftardeptsubkon())){
                $kuerinomorbc1 = " stokdept.nomor_bc as nombc ";
                $kuerinomorbc2 = " tb_header.exnomor_bc as nombc ";
                $kuerinomorbc3 = " tb_header.nomor_bc as nombc ";
            }else{
                $kuerinomorbc1 = " '' as nombc ";
                $kuerinomorbc2 = " '' as nombc ";
                $kuerinomorbc3 = " '' as nombc ";
            }
            $deptsubkon = 'tb_detail.id_header'; //datadepartemen($dpt,'katedept_id')==3 ? 'tb_detail.id_akb ': 'tb_detail.id_header' ;
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,spek,name_kategori,kode,nobontr,insno,harga,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,idu,user_verif,tgl_verif,nombc,
                        SUM(SUM(kgs)+SUM(kgsin)-SUM(kgsout)) OVER (PARTITION BY id_barang) AS totkgs,SUM(SUM(pcs)+SUM(pcsin)-SUM(pcsout)) OVER (PARTITION BY id_barang) AS totpcs,safety_stock,nobale,nomor_bc,id_bom,nomor_kont,exnet
                        FROM (";
            $tambah2 = ") pt GROUP BY po,item,dis,id_barang,nobontr,insno,exnet" . $nobalefiel . ",nombc,nobale ORDER BY nama_barang";
            $tambah2 .= $dpt == 'GS' ? '' : ",spek desc,nobontr,insno";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno," . $noeb1 . ",stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,stokdept.id_bom,1 AS nome,tb_po.spek,stokdept.id as idu,stokdept.user_verif,stokdept.tgl_verif,barang.safety_stock,stokdept.nobale,stokdept.nomor_kont".$field.",stokdept.exnet,".$kuerinomorbc1."
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join . "
                                        WHERE (kgs_awal+pcs_awal > 0 OR kgs_masuk+pcs_masuk > 0) AND periode = '" . $period . "' AND dept_id = '" . $dpt . "'" . $xinv . $xkat . $xcari . $xbcnya . $ifndln . $kueriexdo. "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno," . $noeb2 . ",tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout, satuan.kodesatuan,
                                        0 as id_bom,3 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detailgen.nobale,tb_header.nomor_kont".$field2.",tb_detailgen.exnet,".$kuerinomorbc2."
                                        FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON concat(trim(tb_po.po),TRIM(tb_po.item),tb_po.dis) = concat(trim(tb_detailgen.po),TRIM(tb_detailgen.item),tb_detailgen.dis)
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join1 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 " . $xinv . $xkat . $xcari2 . $xbcnya . $ifndln2 . $kueriexdo.  "
                                        UNION ALL   
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,0 as id_bom,2 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale,tb_header.nomor_kont".$field2.",tb_detail.exnet,".$kuerinomorbc3."
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = ".$deptsubkon."
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON concat(trim(tb_po.po),TRIM(tb_po.item),tb_po.dis) = concat(trim(tb_detail.po),TRIM(tb_detail.item),tb_detail.dis)
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.dept_id != 'GS' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya . $ifndln3 . $kueriexdo . "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,0 as id_bom,3 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale,tb_header.nomor_kont".$field2.",tb_detail.exnet,".$kuerinomorbc3."
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON concat(trim(tb_po.po),TRIM(tb_po.item),tb_po.dis) = concat(trim(tb_detail.po),TRIM(tb_detail.item),tb_detail.dis)
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya . $ifndln3 . $kueriexdo . "
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }

    public function getdata($mode=0){ // jika 0 mode Inventory, jika 1 Mode IT Inventory
        if($this->session->userdata('tglawal')==null){
            $tglawal = '01-01-1970';
            $tglakhir = '01-01-1970';
            $dept = '$%';
            $ifndln = 'all';
        }else{
            $tglawal = $this->session->userdata('tglawal');
            $tglakhir = $this->session->userdata('tglakhir');
            $dept = $this->session->userdata('currdept');
            $ifndln = $this->session->userdata('ifndln');
        }
        $periode = cekperiodedaritgl($tglawal);
        $bl = date('m', strtotime($tglawal));
        $th = date('Y', strtotime($tglawal));
        $ada = in_array($dept,daftardeptsubkon());

        // Query untuk CekSaldobarang
        $this->db->select("0 as kodeinv,stokdept.po,stokdept.item,stokdept.dis,stokdept.id_barang,stokdept.dln as xdln,barang.id_kategori,stokdept.insno,stokdept.nobontr,barang.kode,stokdept.id as idu");
        $this->db->select('sum(pcs_awal) as saldopcs,sum(kgs_awal) as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->select('0 as adjpcs,0 as adjkgs');
        $this->db->select('tb_po.spek as spek,tb_po.exdo,tb_po.id_buyer');
        $this->db->select('barang.nama_barang as nama_barang');
        $this->db->select('stokdept.stok,stokdept.exnet');
        $this->db->select('tb_po.id_kategori as id_kategori_po');
        $this->db->select('SUM(sum(pcs_awal)) over() as totalpcssaldo,SUM(sum(kgs_awal)) over() as totalkgssaldo');
        $this->db->select('0 as totalpcsin,0 as totalkgsin');
        $this->db->select('0 as totalpcsout,0 as totalkgsout');
        $this->db->select('0 as totalpcsadj,0 as totalkgsadj');
        $this->db->select('stokdept.user_verif,stokdept.tgl_verif');
        $this->db->select('user.username as username_verif');
        if($dept=='GF' || $dept=='GW'){
            $this->db->select('stokdept.nobale');
        }else{
            $this->db->select('"" as nobale');
        }
        if($ada){
            $this->db->select('trim(stokdept.nomor_bc) as xnomor_bc');
        }else{
            $this->db->select('"" as xnomor_bc');
        }
        $this->db->from('stokdept');
        $this->db->join('barang','barang.id = stokdept.id_barang','left');
        $this->db->join('tb_po','tb_po.ind_po = CONCAT(stokdept.po,stokdept.item,stokdept.dis)','left');
        $this->db->join('user','user.id = stokdept.user_verif','left');
        $this->db->where('dept_id',$dept);
        $this->db->where('periode',$periode);
        // $this->db->where('stokdept.po','KI-6391');
        // $this->db->where('stokdept.nobale','58');
        $this->db->group_by('po,item,dis,id_barang,insno,nobontr,stokdept.nobale,xnomor_bc,stok,exnet');
        $query1 = $this->db->get_compiled_select();

        // Query untuk In Barang
        $this->db->select("1 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang,tb_detail.dln as xdln,barang.id_kategori,tb_detail.insno,tb_detail.nobontr,barang.kode,0 as idu");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('sum(pcs) as inpcs,sum(kgs) as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->select('0 as adjpcs,0 as adjkgs');
        $this->db->select('tb_po.spek as spek,tb_po.exdo,tb_po.id_buyer');
        $this->db->select('barang.nama_barang as nama_barang');
        $this->db->select('tb_detail.stok,tb_detail.exnet');
        $this->db->select('tb_po.id_kategori as id_kategori_po');
        $this->db->select('0 as totalpcssaldo, 0 as totalkgssaldo');
        $this->db->select('SUM(sum(pcs)) over() as totalpcsin,SUM(sum(kgs)) over() as totalkgsin');
        $this->db->select('0 as totalpcsout,0 as totalkgsout');
        $this->db->select('0 as totalpcsadj,0 as totalkgsadj');
        $this->db->select('0 as user_verif,"" as tgl_verif');
        $this->db->select('"" as username_verif');
        if($dept=='GF' || $dept=='GW'){
            $this->db->select('tb_detail.nobale');
        }else{
            $this->db->select('"" as nobale');
        }
        if($ada){
            // $this->db->select('tb_header.nomor_bc as xnomor_bc');
            $this->db->select('(SELECT trim(nomor_bc) FROM tb_header tbhead where id = tb_detail.id_akb ) as xnomor_bc');
        }else{
            $this->db->select('"" as xnomor_bc');
        }
        $this->db->from('tb_detail');
        $this->db->join('barang','barang.id = tb_detail.id_barang','left');
        // $this->db->join('tb_po','tb_po.po = tb_detail.po AND tb_po.item = tb_detail.item','left');
        $this->db->join('tb_po','tb_po.ind_po = CONCAT(tb_detail.po,tb_detail.item,tb_detail.dis)','left');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('dept_tuju',$dept);
        $this->db->where('month(tb_header.tgl)',$bl);
        $this->db->where('year(tb_header.tgl)',$th);
        $this->db->where('tb_header.tgl <= ',tglmysql($tglakhir));
        $this->db->group_start();
        $this->db->where('tb_header.kode_dok','IB');
        $this->db->or_where('tb_header.kode_dok','T');
        $this->db->group_end();
        $this->db->where('tb_header.ok_valid',1);
        // $this->db->where('tb_detail.po','KI-6391');
        // $this->db->where('tb_detail.nobale','58');
        $this->db->group_by('po,item,dis,id_barang,insno,nobontr,nobale,xnomor_bc,stok,exnet');
        $query2 = $this->db->get_compiled_select();

        // Query untuk Out Barang
        $this->db->select("2 as kodeinv,tb_detailgen.po,tb_detailgen.item,tb_detailgen.dis,tb_detailgen.id_barang,tb_detailgen.dln as xdln,barang.id_kategori,tb_detailgen.insno,tb_detailgen.nobontr,barang.kode,0 as idu");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('sum(tb_detailgen.pcs) as outpcs,sum(tb_detailgen.kgs) as outkgs');
        $this->db->select('0 as adjpcs,0 as adjkgs');
        $this->db->select('tb_po.spek as spek,tb_po.exdo,tb_po.id_buyer');
        $this->db->select('barang.nama_barang as nama_barang');
        $this->db->select('tb_detailgen.stok,tb_detailgen.exnet');
        $this->db->select('tb_po.id_kategori as id_kategori_po');
        $this->db->select('0 as totalpcssaldo,0 as totalkgssaldo');
        $this->db->select('0 as totalpcsin,0 as totalkgsin');
        $this->db->select('SUM(sum(tb_detailgen.pcs)) over() as totalpcsout,SUM(sum(tb_detailgen.kgs)) over() as totalkgsout');
        $this->db->select('0 as totalpcsadj,0 as totalkgsadj');
        $this->db->select('0 as user_verif,"" as tgl_verif');
        $this->db->select('"" as username_verif');
        if($dept=='GF' || $dept=='GW'){
            $this->db->select('tb_detailgen.nobale');
        }else{
            $this->db->select('"" as nobale');
        }
        if($ada){
            // $this->db->select('tb_header.nomor_bc as nomor_bc');
            $this->db->select('(SELECT trim(nomor_bc) FROM tb_header tbhead where jns_bc = "261" AND TRIM(tbhead.keterangan) = trim(tb_header.keterangan) AND tbhead.dept_id = tb_header.dept_tuju AND tbhead.dept_tuju = tb_header.dept_id ) as xnomor_bc');
        }else{
            $this->db->select('"" as xnomor_bc');
        }
        $this->db->from('tb_detailgen');
        $this->db->join('barang','barang.id = tb_detailgen.id_barang','left');
        // $this->db->join('tb_po','tb_po.po = tb_detailgen.po AND tb_po.item = tb_detailgen.item','left');
        $this->db->join('tb_po','tb_po.ind_po = CONCAT(tb_detailgen.po,tb_detailgen.item,tb_detailgen.dis)','left');
        $this->db->join('tb_header','tb_header.id = tb_detailgen.id_header','left');
        $this->db->join('tb_detail','tb_detail.id = tb_detailgen.id_detail','left');
        $this->db->where('dept_id',$dept);
        $this->db->where('month(tb_header.tgl)',$bl);
        $this->db->where('year(tb_header.tgl)',$th);
        $this->db->where('tb_header.tgl <= ',tglmysql($tglakhir));
        $this->db->where('tb_header.kode_dok','T');
        $this->db->where('tb_header.data_ok',1);
        // $this->db->where('tb_detailgen.po','KI-6391');
        // $this->db->where('tb_detailgen.nobale','58');
        $this->db->group_by('po,item,dis,id_barang,insno,nobontr,nobale,xnomor_bc,stok,exnet');
        $query3 = $this->db->get_compiled_select();

        // Query untuk ADJ Barang
        $this->db->select("3 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang,tb_detail.dln as xdln,barang.id_kategori,tb_detail.insno,tb_detail.nobontr,barang.kode,0 as idu");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->select('sum(pcs) as adjpcs,sum(kgs) as adjkgs');
        $this->db->select('tb_po.spek as spek,tb_po.exdo,tb_po.id_buyer');
        $this->db->select('barang.nama_barang as nama_barang');
        $this->db->select('tb_detail.stok,tb_detail.exnet');
        $this->db->select('tb_po.id_kategori as id_kategori_po');
        $this->db->select('0 as totalpcssaldo,0 as totalkgssaldo');
        $this->db->select('0 as totalpcsin,0 as totalkgsin');
        $this->db->select('0 as totalpcsout,0 as totalkgsout');
        $this->db->select('SUM(sum(pcs)) over() as totalpcsadj,SUM(sum(kgs)) over() as totalkgsadj');
        $this->db->select('0 as user_verif,"" as tgl_verif');
        $this->db->select('"" as username_verif');
        if($dept=='GF' || $dept=='GW'){
            $this->db->select('tb_detail.nobale');
        }else{
            $this->db->select('"" as nobale');
        }
        if($ada){
            $this->db->select('trim(tb_header.nomor_bc) as xnomor_bc');
        }else{
            $this->db->select('"" as xnomor_bc');
        }
        $this->db->from('tb_detail');
        $this->db->join('barang','barang.id = tb_detail.id_barang','left');
        // $this->db->join('tb_po','tb_po.po = tb_detail.po AND tb_po.item = tb_detail.item','left');
        $this->db->join('tb_po','tb_po.ind_po = CONCAT(tb_detail.po,tb_detail.item,tb_detail.dis)','left');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('dept_id',$dept);
        $this->db->where('month(tb_header.tgl)',$bl);
        $this->db->where('year(tb_header.tgl)',$th);
        $this->db->where('tb_header.tgl <= ',tglmysql($tglakhir));
        $this->db->where('tb_header.kode_dok','ADJ');
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_valid',1);
        // $this->db->where('tb_detail.po','KI-6391');
        // $this->db->where('tb_detail.nobale','58');
        $this->db->group_by('po,item,dis,id_barang,insno,nobontr,nobale,xnomor_bc,stok,exnet');
        $query4 = $this->db->get_compiled_select();

        $kolom = " Select *,sum(saldokgs+inkgs-outkgs+adjkgs) over() as totalkgs,sum(saldopcs+inpcs-outpcs+adjpcs) over() as totalpcs,sum(saldopcs) over() as sawalpcs,sum(saldokgs) over() as sawalkgs,sum(inpcs) over() as totalinpcs,sum(outpcs) over() as totaloutpcs,sum(inkgs) over() as totalinkgs,sum(outkgs) over() as totaloutkgs,sum(adjpcs) over() as totaladjpcs,sum(adjkgs) over() as totaladjkgs,sum(pcs_taking) over() as totalsopcs,sum(kgs_taking) over() as totalsokgs from (Select kategori.jns,kodeinv,nobale,po,item,dis,id_barang,xdln,left(concat(ifnull(id_kategori_po,''),ifnull(barang.id_kategori,'')),4) as id_kategori,trim(xnomor_bc) as nomor_bc,insno,nobontr,barang.kode,idu,stok,exnet,sum(saldopcs) as saldopcs,sum(saldokgs) as saldokgs,sum(inpcs) as inpcs,sum(inkgs) as inkgs,sum(outpcs) as outpcs,sum(outkgs) as outkgs,sum(adjpcs) as adjpcs,sum(adjkgs) as adjkgs,(sum(saldopcs)+sum(inpcs)-sum(outpcs)+sum(adjpcs)) as sumpcs,(sum(saldokgs)+sum(inkgs)-sum(outkgs)+sum(adjkgs)) as sumkgs,satuan.kodesatuan,barang.nama_barang,spek,exdo,id_buyer,user_verif,tgl_verif,username_verif,";
        $kolom .= "(select sum(kgs) from stokopname_detail where trim(po)=trim(r1.po) and trim(item)=trim(r1.item) and dis=r1.dis and id_barang = r1.id_barang and trim(insno)=trim(r1.insno) and trim(nobontr)=trim(r1.nobontr) and trim(nobale)=trim(r1.nobale) and stok=r1.stok and exnet=r1.exnet and dept_id = '".$dept."' and tgl='".tglmysql($tglakhir)."') as kgs_taking,";
        $kolom .= "(select sum(pcs) from stokopname_detail where trim(po)=trim(r1.po) and trim(item)=trim(r1.item) and dis=r1.dis and id_barang = r1.id_barang and trim(insno)=trim(r1.insno) and trim(nobontr)=trim(r1.nobontr) and trim(nobale)=trim(r1.nobale) and stok=r1.stok and exnet=r1.exnet and dept_id = '".$dept."' and tgl='".tglmysql($tglakhir)."') as pcs_taking ";
        $kolom .= "from (".$query1." union all ".$query2." union all ".$query3." union all ".$query4.") r1";
        $kolom .= " left join barang on barang.id = id_barang";
        $kolom .= " left join satuan on barang.id_satuan = satuan.id";
        $kolom .= " left join kategori on kategori.kategori_id = left(concat(ifnull(id_kategori_po,''),ifnull(barang.id_kategori,'')),4)";
        if($this->session->userdata('currdept') != 'GS'){
        $kolom .= " where (jns <= 2 )";
        }
        if($ifndln!='all'){
            $kolom .= " AND xdln = ".$ifndln;
        }
        $kolom .= " group by po,item,dis,id_barang,insno,nobontr,nobale,nomor_bc,stok,exnet) r2";
        $hasil = $this->db->query($kolom);

        return $kolom;
    }

    public function getdatabaru($filtkat,$mode=0){
        $query = $this->getdata($mode);
        // $cari = array('barang.kode','nama_barang','nama_kategori');
        $cari = array('po','insno','nobontr','spek','nobale','id_barang','nama_barang','kode');
        $where = $filtkat;
        $isWhere = null;
        // Ambil data yang di ketik user pada textbox pencarian
        $search = htmlspecialchars($_POST['search']['value']);
        // Ambil data limit per page
        $limit = preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['length']}");
        // Ambil data start
        $start =preg_replace("/[^a-zA-Z0-9.]/", '', "{$_POST['start']}"); 

        if($where != null)
        {
            $setWhere = array();
            foreach ($where as $key => $value)
            {
                if($key=='minus'){
                    $setWhere[] = '(sumkgs < 0 OR sumpcs < 0)';
                }else{
                    if($key=='opminus'){
                        $setWhere[] = '(sumkgs != ifnull(kgs_taking,0) OR sumpcs != ifnull(pcs_taking,0))';
                    }else{
                        $setWhere[] = $key."='".$value."'";
                    }
                }
            }
            $fwhere = implode(' AND ', $setWhere);

            if(!empty($iswhere))
            {
                $sql = $this->db->query($query." WHERE  $iswhere AND ".$fwhere);
            }else{
                $sql = $this->db->query($query." WHERE ".$fwhere);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%".$search."%' OR ", $cari)." LIKE '%".$search."%'";
            
            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column']; 

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir']; 
            $order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;

            if(!empty($iswhere))
            {
                $sql_data = $this->db->query($query." WHERE $iswhere AND ".$fwhere." AND (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
            }else{
                $sql_data = $this->db->query($query." WHERE ".$fwhere." AND (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
            }
            if(isset($search))
            {
                if(!empty($iswhere))
                {
                    $sql_cari =  $this->db->query($query." WHERE $iswhere AND ".$fwhere." AND (".$cari.")");
                }else{
                    $sql_cari =  $this->db->query($query." WHERE ".$fwhere." AND (".$cari.")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            }else{
                if(!empty($iswhere))
                {
                    $sql_filter = $this->db->query($query." WHERE $iswhere AND ".$fwhere);
                }else{
                    $sql_filter = $this->db->query($query." WHERE ".$fwhere);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();

        }else{
            if(!empty($iswhere))
            {
                $sql = $this->db->query($query." WHERE  $iswhere ");
            }else{
                $sql = $this->db->query($query);
            }
            $sql_count = $sql->num_rows();

            $cari = implode(" LIKE '%".$search."%' OR ", $cari)." LIKE '%".$search."%'";
            
            // Untuk mengambil nama field yg menjadi acuan untuk sorting
            $order_field = $_POST['order'][0]['column']; 

            // Untuk menentukan order by "ASC" atau "DESC"
            $order_ascdesc = $_POST['order'][0]['dir']; 
            $order = " ORDER BY ".$_POST['columns'][$order_field]['data']." ".$order_ascdesc;

            if(!empty($iswhere))
            {                
                $sql_data = $this->db->query($query." WHERE $iswhere AND (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
            }else{
                $sql_data = $this->db->query($query." WHERE (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start);
            }

            if(isset($search))
            {
                if(!empty($iswhere))
                {     
                    $sql_cari =  $this->db->query($query." WHERE $iswhere AND (".$cari.")");
                }else{
                    $sql_cari =  $this->db->query($query." WHERE (".$cari.")");
                }
                $sql_filter_count = $sql_cari->num_rows();
            }else{
                if(!empty($iswhere))
                {
                    $sql_filter = $this->db->query($query." WHERE $iswhere");
                }else{
                    $sql_filter = $this->db->query($query);
                }
                $sql_filter_count = $sql_filter->num_rows();
            }
            $data = $sql_data->result_array();
        }
        $callback = array(    
            'draw' => $_POST['draw'], // Ini dari datatablenya    
            'recordsTotal' => $sql_count,    
            'recordsFiltered'=>$sql_filter_count,    
            'data'=>$data
        );
        // return $query." WHERE (".$cari.")".$order." LIMIT ".$limit." OFFSET ".$start;
        return json_encode($callback); // Convert array $callback ke json
    }

    public function getdatadetailbaru($array){
        if($this->session->userdata('tglawal')==null){
            $tglawal = '01-01-1970';
            $tglakhir = '01-01-1970';
            $dept = '$%';
        }else{
            $tglawal = $this->session->userdata('tglawal');
            $tglakhir = $this->session->userdata('tglakhir');
            $dept = $this->session->userdata('currdept');
        }
        $periode = cekperiodedaritgl($tglawal);
        $bl = date('m', strtotime($tglawal));
        $th = date('Y', strtotime($tglawal));
        $ada = in_array($dept,daftardeptsubkon());

        // Query untuk CekSaldobarang
        $this->db->select("'SALDO' as mode,'".tglmysql($this->session->userdata('tglawal'))."' as tgl,stokdept.po,stokdept.item,stokdept.dis,stokdept.id_barang,stokdept.dln as xdln,barang.id_kategori,stokdept.insno,stokdept.nobontr,barang.kode,stokdept.id as idu");
        $this->db->select("kategori.nama_kategori,barang.safety_stock,'SALDO AWAL' as nomor_dok,satuan.kodesatuan");
        $this->db->select('sum(pcs_awal) as saldopcs,sum(kgs_awal) as saldokgs,tb_hargamaterial.jns_bc,tb_hargamaterial.tgl_bc');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->select('0 as adjpcs,0 as adjkgs');
        $this->db->select('tb_po.spek as spek');
        $this->db->select('barang.nama_barang as nama_barang');
        if($dept=='GF' || $dept=='GW'){
            $this->db->select('stokdept.nobale');
        }else{
            $this->db->select('"" as nobale');
        }
        if($ada){
            // $this->db->select('stokdept.nomor_bc as nomor_bc');
            $this->db->select('trim(stokdept.nomor_bc) as nomor_bc');
        }else{
            $this->db->select('"" as nomor_bc');
        }
        $this->db->from('stokdept');
        $this->db->join('barang','barang.id = stokdept.id_barang','left');
        $this->db->join('tb_po','tb_po.ind_po = concat(stokdept.po,stokdept.item,stokdept.dis)','left');
        $this->db->join('kategori','barang.id_kategori = kategori.kategori_id','left');
        $this->db->join('satuan','barang.id_satuan = satuan.id','left');
        $this->db->join('tb_hargamaterial','stokdept.id_barang = tb_hargamaterial.id_barang AND stokdept.nobontr = tb_hargamaterial.nobontr  AND trim(tb_hargamaterial.nobontr) != "" ','left');
        $this->db->where('dept_id',$dept);
        $this->db->where('periode',$periode);
        $this->db->where('trim(stokdept.po)',trim($array['po']));
        $this->db->where('trim(stokdept.item)',trim($array['item']));
        $this->db->where('trim(stokdept.dis)',$array['dis']);
        $this->db->where('trim(stokdept.insno)',trim($array['insno']));
        $this->db->where('trim(stokdept.nobontr)',trim($array['nobontr']));
        if($dept=='GF' || $dept=='GW'){
            $this->db->where('trim(stokdept.nobale)',trim($array['nobale']));
        }else{
            $this->db->where('trim(stokdept.id_barang)',$array['id_barang']);
        }
        if($ada){
            $this->db->where('trim(stokdept.nomor_bc)',trim($array['nomor_bc']));
        }
        $this->db->group_by('po,item,dis,id_barang,insno,nobontr,nobale,nomor_bc');
        $query1 = $this->db->get_compiled_select();

        // Query untuk In Barang
        $this->db->select("'IN' as mode,tb_header.tgl,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang,tb_detail.dln as xdln,barang.id_kategori,tb_detail.insno,tb_detail.nobontr,barang.kode,0 as idu");
        $this->db->select("kategori.nama_kategori,barang.safety_stock,tb_header.nomor_dok,satuan.kodesatuan");
        $this->db->select('0 as saldopcs,0 as saldokgs,tb_hargamaterial.jns_bc,tb_hargamaterial.tgl_bc');
        $this->db->select('sum(pcs) as inpcs,sum(kgs) as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->select('0 as adjpcs,0 as adjkgs');
        $this->db->select('tb_po.spek as spek');
        $this->db->select('barang.nama_barang as nama_barang');
        if($dept=='GF' || $dept=='GW'){
            $this->db->select('tb_detail.nobale');
        }else{
            $this->db->select('"" as nobale');
        }
        if($ada){
            // $this->db->select('tb_header.nomor_bc as nomor_bc');
            $this->db->select('(SELECT trim(nomor_bc) FROM tb_header tbhead where id = tb_detail.id_akb) as nomor_bc');
        }else{
            $this->db->select('"" as nomor_bc');
        }
        $this->db->from('tb_detail');
        $this->db->join('barang','barang.id = tb_detail.id_barang','left');
        $this->db->join('tb_po','tb_po.ind_po = concat(tb_detail.po,tb_detail.item,tb_detail.dis)','left');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->join('kategori','barang.id_kategori = kategori.kategori_id','left');
        $this->db->join('satuan','barang.id_satuan = satuan.id','left');
        $this->db->join('tb_hargamaterial','tb_detail.id_barang = tb_hargamaterial.id_barang AND tb_detail.nobontr = tb_hargamaterial.nobontr AND trim(tb_hargamaterial.nobontr) != "" ','left');
        $this->db->where('dept_tuju',$dept);
        $this->db->where('month(tb_header.tgl)',$bl);
        $this->db->where('year(tb_header.tgl)',$th);
        $this->db->where('tb_header.tgl <= ',tglmysql($tglakhir));
        $this->db->group_start();
        $this->db->where('tb_header.kode_dok','IB');
        $this->db->or_where('tb_header.kode_dok','T');
        $this->db->group_end();
        $this->db->where('tb_header.ok_valid',1);
        $this->db->where('trim(tb_detail.po)',trim($array['po']));
        $this->db->where('trim(tb_detail.item)',trim($array['item']));
        $this->db->where('trim(tb_detail.dis)',$array['dis']);
        $this->db->where('trim(tb_detail.insno)',trim($array['insno']));
        $this->db->where('trim(tb_detail.nobontr)',trim($array['nobontr']));
        if($dept=='GF' || $dept=='GW'){
            $this->db->where('trim(tb_detail.nobale)',trim($array['nobale']));
        }else{
            $this->db->where('trim(tb_detail.id_barang)',$array['id_barang']);
        }
        if($ada){
            $this->db->where('(SELECT trim(nomor_bc) FROM tb_header tbhead where id = tb_detail.id_akb) = ',trim($array['nomor_bc']));
        }
        $this->db->group_by('po,item,dis,id_barang,insno,nobontr,nobale,nomor_bc,nomor_dok');
        $query2 = $this->db->get_compiled_select();

        // Query untuk Out Barang
        $this->db->select("'OUT' as mode,tb_header.tgl,tb_detailgen.po,tb_detailgen.item,tb_detailgen.dis,tb_detailgen.id_barang,tb_detailgen.dln as xdln,barang.id_kategori,tb_detailgen.insno,tb_detailgen.nobontr,barang.kode,0 as idu");
        $this->db->select("kategori.nama_kategori,barang.safety_stock,tb_header.nomor_dok,satuan.kodesatuan");
        $this->db->select('0 as saldopcs,0 as saldokgs,tb_hargamaterial.jns_bc,tb_hargamaterial.tgl_bc');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('sum(pcs) as outpcs,sum(kgs) as outkgs');
        $this->db->select('0 as adjpcs,0 as adjkgs');
        $this->db->select('tb_po.spek as spek');
        $this->db->select('barang.nama_barang as nama_barang');
        if($dept=='GF' || $dept=='GW'){
            $this->db->select('tb_detailgen.nobale');
        }else{
            $this->db->select('"" as nobale');
        }
        if($ada){
            // $this->db->select('tb_header.nomor_bc as nomor_bc');
            $this->db->select('(SELECT trim(nomor_bc) FROM tb_header tbhead where jns_bc = "261" AND TRIM(tbhead.keterangan) = trim(tb_header.keterangan) AND tbhead.dept_id = tb_header.dept_tuju AND tbhead.dept_tuju = tb_header.dept_id ) as nomor_bc');
        }else{
            $this->db->select('"" as nomor_bc');
        }
        $this->db->from('tb_detailgen');
        $this->db->join('barang','barang.id = tb_detailgen.id_barang','left');
        $this->db->join('tb_po','tb_po.ind_po = concat(tb_detailgen.po,tb_detailgen.item,tb_detailgen.dis)','left');
        $this->db->join('tb_header','tb_header.id = tb_detailgen.id_header','left');
        $this->db->join('kategori','barang.id_kategori = kategori.kategori_id','left');
        $this->db->join('satuan','barang.id_satuan = satuan.id','left');
        $this->db->join('tb_hargamaterial','tb_detailgen.id_barang = tb_hargamaterial.id_barang AND tb_detailgen.nobontr = tb_hargamaterial.nobontr AND trim(tb_hargamaterial.nobontr) != "" ','left');
        $this->db->where('dept_id',$dept);
        $this->db->where('month(tb_header.tgl)',$bl);
        $this->db->where('year(tb_header.tgl)',$th);
        $this->db->where('tb_header.tgl <= ',tglmysql($tglakhir));
        $this->db->where('tb_header.kode_dok','T');
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('trim(tb_detailgen.po)',trim($array['po']));
        $this->db->where('trim(tb_detailgen.item)',trim($array['item']));
        $this->db->where('trim(tb_detailgen.dis)',$array['dis']);
        $this->db->where('trim(tb_detailgen.insno)',trim($array['insno']));
        $this->db->where('trim(tb_detailgen.nobontr)',trim($array['nobontr']));
        if($dept=='GF' || $dept=='GW'){
            $this->db->where('trim(tb_detailgen.nobale)',trim($array['nobale']));
        }else{
            $this->db->where('trim(tb_detailgen.id_barang)',$array['id_barang']);
        }
        if($ada){
            $this->db->where('(SELECT trim(nomor_bc) FROM tb_header tbhead where jns_bc = "261" AND TRIM(tbhead.keterangan) = trim(tb_header.keterangan) AND tbhead.dept_id = tb_header.dept_tuju AND tbhead.dept_tuju = tb_header.dept_id ) =',trim($array['nomor_bc']));
        }
        $this->db->group_by('po,item,dis,id_barang,insno,nobontr,nobale,nomor_bc,nomor_dok');
        $query3 = $this->db->get_compiled_select();

        // Query untuk ADJ Barang
        $this->db->select("'ADJ' as mode,tb_header.tgl,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang,tb_detail.dln as xdln,barang.id_kategori,tb_detail.insno,tb_detail.nobontr,barang.kode,0 as idu");
        $this->db->select("kategori.nama_kategori,barang.safety_stock,tb_header.nomor_dok,satuan.kodesatuan");
        $this->db->select('0 as saldopcs,0 as saldokgs,tb_hargamaterial.jns_bc,tb_hargamaterial.tgl_bc');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->select('sum(pcs) as adjpcs,sum(kgs) as adjkgs');
        $this->db->select('tb_po.spek as spek');
        $this->db->select('barang.nama_barang as nama_barang');
        if($dept=='GF' || $dept=='GW'){
            $this->db->select('tb_detail.nobale');
        }else{
            $this->db->select('"" as nobale');
        }
        if($ada){
            $this->db->select('tb_header.nomor_bc as nomor_bc');
        }else{
            $this->db->select('" " as nomor_bc');
        }
        $this->db->from('tb_detail');
        $this->db->join('barang','barang.id = tb_detail.id_barang','left');
        $this->db->join('tb_po','tb_po.ind_po = concat(tb_detail.po,tb_detail.item,tb_detail.dis)','left');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->join('kategori','barang.id_kategori = kategori.kategori_id','left');
        $this->db->join('satuan','barang.id_satuan = satuan.id','left');
        $this->db->join('tb_hargamaterial','tb_detail.id_barang = tb_hargamaterial.id_barang AND tb_detail.nobontr = tb_hargamaterial.nobontr AND trim(tb_hargamaterial.nobontr) != "" ','left');
        $this->db->where('dept_id',$dept);
        $this->db->where('month(tb_header.tgl)',$bl);
        $this->db->where('year(tb_header.tgl)',$th);
        $this->db->where('tb_header.tgl <= ',tglmysql($tglakhir));
        $this->db->where('tb_header.kode_dok','ADJ');
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_valid',1);
        $this->db->where('trim(tb_detail.po)',trim($array['po']));
        $this->db->where('trim(tb_detail.item)',trim($array['item']));
        $this->db->where('trim(tb_detail.dis)',$array['dis']);
        $this->db->where('trim(tb_detail.insno)',trim($array['insno']));
        $this->db->where('trim(tb_detail.nobontr)',trim($array['nobontr']));
        if($dept=='GF' || $dept=='GW'){
            $this->db->where('trim(tb_detail.nobale)',trim($array['nobale']));
        }else{
            $this->db->where('trim(tb_detail.id_barang)',$array['id_barang']);
        }
        if($ada){
            $this->db->where('trim(tb_header.nomor_bc)',trim($array['nomor_bc']));
        }
        $this->db->group_by('po,item,dis,id_barang,insno,nobontr,nobale,nomor_bc,nomor_dok');
        $query4 = $this->db->get_compiled_select();

        $kolom = "Select * from (".$query1." union all ".$query2." union all ".$query3." union all ".$query4.") r1";
        // $kolom .= " left join barang on barang.id = id_barang";
        // $kolom .= " left join satuan on barang.id_satuan = satuan.id";
        // $kolom .= " group by po,item,dis,id_barang,insno,nobontr,nobale,nomor_bc) r2";
        // $kolom .= " LEFT JOIN tb_po ON CONCAT(tb_po.po,tb_po.item,tb_po.dis) = concat(xpo,xitem,xdis)";
        $kolom .= " order by tgl";
        $hasil = $this->db->query($kolom);

        return $hasil;
    }
    public function getbuyer(){
        $hasil = $this->db->query("Select id_buyer,if(id_buyer=0,' NOT SET',customer.nama_customer) as nama,customer.exdo,customer.port from (".$this->getdata().") r3 left join customer on customer.id = id_buyer group by id_buyer order by 2 ");
        return $hasil;
    }
    public function toexcel(){
        return $hasil = $this->db->query($this->getdata());
    }
    public function simpandatainv(){
        $cekdata = $this->db->get_where('stokinv',['dept_id' => $this->session->userdata('currdept'),'tgl' => tglmysql($this->session->userdata('tglakhir')),'kunci' => 1]);
        if(count($cekdata->result_array()) > 0){
            $datacek = $cekdata->row_array();
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', "Data sudah dikunci, tidak bisa simpan ulang  \r\n(terakhir Update oleh ".datauser($datacek['user_verif'],'name').", pada ".$datacek['tgl_verif'].") \r\nDilock Oleh ".datauser($datacek['user_lock'],'name').", pada ".$datacek['tgl_lock'].")");
            $hasil = 1;
        }else{
            $cekdatfin = $this->db->get_where('tb_datfin',['tgl' => tglmysql($this->session->userdata('tglakhir'))]);
            if(count($cekdatfin->result_array()) <= 0 && $this->session->userdata('currdept')=='FN'){
                $datacek = $cekdatfin->row_array();
                $this->session->set_flashdata('errorsimpan', 1);
                $this->session->set_flashdata('pesanerror', "[ERROR] Data Sublok FN periode tgl ".$this->session->userdata('tglakhir')." belum ada, Upload data pada IFN-SYSTEM");
                $hasil = 1;
            }else{ 
                if($this->session->userdata('tglawal')==null){
                    $tglawal = '01-01-1970';
                }else{
                    $tglawal = $this->session->userdata('tglawal');
                }
                $periode = cekperiodedaritgl($tglawal);
                $this->db->trans_start();
                // Hapus dulu data
                $this->db->where('dept_id',$this->session->userdata('currdept'));
                $this->db->where('tgl',tglmysql($this->session->userdata('tglakhir')));
                $this->db->where('periode',$periode);
                $this->db->delete('stokinv');
                // Insert data ke tabel
                $data = $this->getdata();
                $query = $this->db->query($data);
                if(count($query->result_array()) > 0){
                    $tglnya = date('Y-m-d H:i:s');
                    $no=0;
                    foreach($query->result_array() as $det){
                        if(($det['sumpcs']+$det['sumkgs']) != 0){
                            $no++;
                            // Apabila departemen Finishing 
                            if($this->session->userdata('currdept')=='FN' && trim($det['po'])!=''){
                                $kgsnya = $det['saldokgs']+$det['inkgs']-$det['outkgs']+$det['adjkgs'];
                                $pcsnya = $det['saldopcs']+$det['inpcs']-$det['outpcs']+$det['adjpcs'];
                                $kondisidatfin = [
                                    'trim(po)' => trim($det['po']),
                                    'trim(item)' => trim($det['item']),
                                    'dis' => $det['dis'],
                                    'trim(insno)' => trim($det['insno']),
                                    'tgl' => tglmysql($this->session->userdata('tglakhir'))
                                ];
                                $datafin = $this->db->get_where('tb_datfin',$kondisidatfin);
                                if(count($datafin->result_array()) > 0){
                                    $datafinrow = $datafin->row_array();
                                    $ke = 0;
                                    $loop = 1;
                                    while ($kgsnya > 0) {
                                        $ke++;
                                        $sbl = '';
                                        switch ($ke) {
                                            case 1:
                                                if($datafinrow['kgs_packing'] > 0){
                                                    if($kgsnya > $datafinrow['kgs_packing']){
                                                        $sbl = 'PA';
                                                        $kgsnya -= $datafinrow['kgs_packing'];
                                                        $pcsnya -= round($datafinrow['kgs_packing']/$datafinrow['kgs_po'],2);
                                                        $jadikgs = $datafinrow['kgs_packing'];
                                                        $jadipcs = round($datafinrow['kgs_packing']/$datafinrow['kgs_po'],2);
                                                    }else{
                                                        $sbl = 'PA';
                                                        $jadikgs = $kgsnya;
                                                        $jadipcs = $pcsnya;
                                                        $kgsnya = 0;
                                                    }
                                                }
                                                break;
                                            case 2:
                                                if($datafinrow['kgs_hoshu2'] > 0){
                                                    if($kgsnya > $datafinrow['kgs_hoshu2']){
                                                        $sbl = 'H2';
                                                        $kgsnya -= $datafinrow['kgs_hoshu2'];
                                                        $pcsnya -= round($datafinrow['kgs_hoshu2']/$datafinrow['kgs_po'],2);
                                                        $jadikgs = $datafinrow['kgs_hoshu2'];
                                                        $jadipcs = round($datafinrow['kgs_hoshu2']/$datafinrow['kgs_po'],2);
                                                    }else{
                                                        $sbl = 'H2';
                                                        $jadikgs = $kgsnya;
                                                        $jadipcs = $pcsnya;
                                                        $kgsnya = 0;
                                                    }
                                                }
                                                break;
                                            case 3:
                                                if($datafinrow['kgs_koatsu'] > 0){
                                                    if($kgsnya > $datafinrow['kgs_koatsu']){
                                                        $sbl = 'KO';
                                                        $kgsnya -= $datafinrow['kgs_koatsu'];
                                                        $pcsnya -= round($datafinrow['kgs_koatsu']/$datafinrow['kgs_po'],2);
                                                        $jadikgs = $datafinrow['kgs_koatsu'];
                                                        $jadipcs = round($datafinrow['kgs_koatsu']/$datafinrow['kgs_po'],2);
                                                    }else{
                                                        $sbl = 'KO';
                                                        $jadikgs = $kgsnya;
                                                        $jadipcs = $pcsnya;
                                                        $kgsnya = 0;
                                                    }
                                                }
                                                break;
                                            case 4:
                                                if($datafinrow['kgs_hoshu1'] > 0){
                                                    if($kgsnya > $datafinrow['kgs_hoshu1'] && $datafinrow['kgs_hoshu1'] > 0){
                                                        $sbl = 'H1';
                                                        $kgsnya -= $datafinrow['kgs_hoshu1'];
                                                        $pcsnya -= round($datafinrow['kgs_hoshu1']/$datafinrow['kgs_po'],2);
                                                        $jadikgs = $datafinrow['kgs_hoshu1'];
                                                        $jadipcs = round($datafinrow['kgs_hoshu1']/$datafinrow['kgs_po'],2);
                                                    }else{
                                                        $sbl = 'H1';
                                                        $jadikgs = $kgsnya;
                                                        $jadipcs = $pcsnya;
                                                        $kgsnya = 0;
                                                    }
                                                }
                                                break;
                                            default:
                                                $sbl = 'SN';
                                                $jadikgs = $kgsnya;
                                                $jadipcs = $pcsnya;
                                                $kgsnya = 0;
                                                break;
                                        }
                                        $loop = $sbl != '' ? 1 : 0;
                                        $data = [
                                            'urut' => $no,
                                            'dept_id' => $this->session->userdata('currdept'),
                                            'tgl' => tglmysql($this->session->userdata('tglakhir')),
                                            'periode' => $periode,
                                            'po' => $det['po'],
                                            'item' => $det['item'], 
                                            'dis' => $det['dis'],
                                            'id_barang' => $det['id_barang'],
                                            'insno' => $det['insno'],
                                            'nobontr' => $det['nobontr'],
                                            'dln' => $det['xdln'],
                                            'nobale' => $det['nobale'],
                                            'nomor_bc' => $det['nomor_bc'],
                                            'exnet' => $det['exnet'],
                                            // 'kgs_awal' => $det['saldokgs'],
                                            // 'pcs_masuk' => $det['inpcs'],
                                            // 'kgs_masuk' => $det['inkgs'],
                                            // 'pcs_keluar' => $det['outpcs'],
                                            // 'kgs_keluar' => $det['outkgs'],
                                            // 'pcs_adj' => $det['adjpcs'],
                                            // 'kgs_adj' => $det['adjkgs'],
                                            // 'pcs_awal' => $jadipcs,
                                            'kgs_awal' => $jadikgs,
                                            // 'pcs_akhir' => $jadipcs,
                                            'kgs_akhir' => $jadikgs,
                                            'sublok' => $sbl,
                                            'user_verif' => $this->session->userdata('id'),
                                            'tgl_verif' => $tglnya
                                        ];
                                        if($loop){
                                            $this->db->insert('stokinv',$data);
                                            if($kgsnya > 0){
                                                $no++;
                                            }
                                        }
                                    }
                                }else{
                                    $data = [
                                        'urut' => $no,
                                        'dept_id' => $this->session->userdata('currdept'),
                                        'tgl' => tglmysql($this->session->userdata('tglakhir')),
                                        'periode' => $periode,
                                        'po' => $det['po'],
                                        'item' => $det['item'], 
                                        'dis' => $det['dis'],
                                        'id_barang' => $det['id_barang'],
                                        'insno' => $det['insno'],
                                        'nobontr' => $det['nobontr'],
                                        'dln' => $det['xdln'],
                                        'nobale' => $det['nobale'],
                                        'nomor_bc' => $det['nomor_bc'],
                                        'exnet' => $det['exnet'],
                                        'pcs_awal' => $det['saldopcs'],
                                        'kgs_awal' => $det['saldokgs'],
                                        'pcs_masuk' => $det['inpcs'],
                                        'kgs_masuk' => $det['inkgs'],
                                        'pcs_keluar' => $det['outpcs'],
                                        'kgs_keluar' => $det['outkgs'],
                                        'pcs_adj' => $det['adjpcs'],
                                        'kgs_adj' => $det['adjkgs'],
                                        // 'pcs_akhir' => $det['saldopcs']+$det['inpcs']-$det['outpcs']+$det['adjpcs'],
                                        'kgs_akhir' => $det['saldokgs']+$det['inkgs']-$det['outkgs']+$det['adjkgs'],
                                        'user_verif' => $this->session->userdata('id'),
                                        'tgl_verif' => $tglnya
                                    ];
                                    $this->db->insert('stokinv',$data);
                                }
                            }else{
                                // Selain departemen Finishing
                                $harga = 0;
                                $prddate = NULL;
                                if($det['id_kategori']=='8189' || $det['id_kategori']=='6319'){
                                    $cekhamat = $this->db->get_where('tb_hargamaterial',['id_barang' => $det['id_barang'],'nobontr' => $det['nobontr']]);
                                    if($cekhamat->num_rows() > 0){
                                        $datahamat = $cekhamat->row_array();
                                        $harga = $datahamat['harga_akt'];
                                    }
                                }
                                //Pengecekan prod date
                                // Pengecekan pertama ke tabel stokinv
                                $cekprd = $this->db->order_by('prod_date','DESC')->get_where('stokinv',['trim(po)' => trim($det['po']),'trim(item)' => trim($det['item']),'dis' => $det['dis'],'id_barang' => $det['id_barang'],'trim(insno)' => trim($det['insno']),'trim(nobontr)' => trim($det['nobontr'])]);
                                if($cekprd->num_rows() > 0){
                                    $prdcek = $cekprd->row_array();
                                    $prddate = $prdcek['prod_date'];
                                }
                                // Pengecekan kedua ke tabel tb_hargamaterial
                                if($prddate == NULL){
                                    $cekkehamat = $this->db->get_where('tb_hargamaterial',['id_barang' => $det['id_barang'],'trim(nobontr)' => trim($det['nobontr'])]);
                                    if($cekkehamat->num_rows() > 0){
                                        $prdcekk = $cekkehamat->row_array();
                                        $prddate = $prdcekk['tgl'];
                                    }
                                }
                                $data = [
                                    'urut' => $no,
                                    'dept_id' => $this->session->userdata('currdept'),
                                    'tgl' => tglmysql($this->session->userdata('tglakhir')),
                                    'periode' => $periode,
                                    'po' => $det['po'],
                                    'item' => $det['item'], 
                                    'dis' => $det['dis'],
                                    'id_barang' => $det['id_barang'],
                                    'insno' => $det['insno'],
                                    'nobontr' => $det['nobontr'],
                                    'dln' => $det['xdln'],
                                    'nobale' => $det['nobale'],
                                    'nomor_bc' => $det['nomor_bc'],
                                    'exnet' => $det['exnet'],
                                    'pcs_awal' => $det['saldopcs'],
                                    'kgs_awal' => $det['saldokgs'],
                                    'pcs_masuk' => $det['inpcs'],
                                    'kgs_masuk' => $det['inkgs'],
                                    'pcs_keluar' => $det['outpcs'],
                                    'kgs_keluar' => $det['outkgs'],
                                    'pcs_adj' => $det['adjpcs'],
                                    'kgs_adj' => $det['adjkgs'],
                                    'pcs_akhir' => $det['saldopcs']+$det['inpcs']-$det['outpcs']+$det['adjpcs'],
                                    'kgs_akhir' => $det['saldokgs']+$det['inkgs']-$det['outkgs']+$det['adjkgs'],
                                    'user_verif' => $this->session->userdata('id'),
                                    'tgl_verif' => $tglnya,
                                    'harga' => $harga,
                                    'prod_date' => $prddate
                                ];
                                $this->db->insert('stokinv',$data);
                            }
                        }
                    }
                }
                $hasil = $this->db->trans_complete();
            }
        }
        return $hasil;
    }
    public function savesaw(){
        if($this->session->userdata('tglakhir')==null){
            $tglawal = '01-01-1970';
        }else{
            $tglawal = $this->session->userdata('tglakhir');
        }
        $periode = cekperiodedaritgl($tglawal);
        $this->db->trans_start();
        //Cek data ada atau belum 
        $cekexistdata = $this->db->get_where('stokdept',['periode' => cekperiodedaritgl($tglawal,1),'dept_id' => $this->session->userdata('currdept')]);
        if($cekexistdata->num_rows() > 0) {
            $this->session->set_flashdata('errorsimpan',1);
            $this->session->set_flashdata('pesanerror','Data stok dept periode '.cekperiodedaritgl($tglawal,1).' sudah ada. Hubungi IT');
            return 1;
        }else{
            $data = $this->getdata();
            $query = $this->db->query($data);
            if(count($query->result_array()) > 0){
                // foreach($query->result_array() as $det){
                $det = $query->row_array();
                // var_dump($det);
                    if(($det['sumpcs']+$det['sumkgs']) != 0){
                        $isidata = [
                            'tgl' => date('Y-m-d'),
                            'dept_id' => $this->session->userdata('currdept'),
                            'periode' => cekperiodedaritgl($tglawal,1),
                            'nobontr' => $det['nobontr'],
                            'insno' => $det['insno'],
                            'id_barang' => $det['id_barang'],
                            'po' => $det['po'],
                            'item' => $det['item'],
                            'dis' => $det['dis'],
                            'exnet' => $det['exnet'],
                            'stok' => $det['stok'],
                            'dln' => $det['xdln'],
                            'nobale' => $det['nobale'],
                            'harga' => 0,
                            'kgs_awal' => $det['sumkgs'],
                            'pcs_awal' => $det['sumpcs'],
                            'kgs_masuk' => 0,
                            'pcs_masuk' => 0,
                            'kgs_keluar' => 0,
                            'pcs_keluar' => 0,
                            'kgs_adj' => 0,
                            'pcs_adj' => 0,
                            'kgs_akhir' => $det['sumkgs'],
                            'pcs_akhir' => $det['sumpcs'],
                            'nomor_bc' => $det['nomor_bc'],
                            // 'tgl_bc' => $det['tgl_bc'],
                        ];
                        $this->db->insert('stokdept',$isidata);
                    }
                // }
            }
            return $this->db->trans_complete();
            // return $det;
        }
    }
    public function getexport_data()
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
            if ($kat != 'X') {
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat . '" OR name_nettype = "' . $kat . '") ';
                }
            }
            if ($inv == 0) {
                $xinv = ' AND barang.noinv = 0 ';
            }
            if ($bcnya != 'X' && ($this->session->userdata('currdept') == 'GM' || $this->session->userdata('currdept') == 'SP')) {
                if ($bcnya != '') {
                    $xbcnya = ' AND tb_hargamaterial.nomor_bc =  "' . $bcnya . '" ';
                }
            }
            $xcari = '';
            $xcari2 = '';
            $xcari3 = '';
            $field = ',stokdept.nomor_bc as nomor_bc';
            $field2 = ',"" as nomor_bc';
            $nobalefiel = '';
            $ifndln = '';
            $ifndln2 = '';
            $ifndln3 = '';
            if (trim($this->session->userdata('ifndln')) != 'X') {
                $opsidlnin = $this->session->userdata('ifndln') == 'dln' ? 1 : 0;
                $ifndln = ' AND stokdept.dln=' . $opsidlnin;
                $ifndln2 = ' AND tb_detailgen.dln=' . $opsidlnin;
                $ifndln3 = ' AND tb_detail.dln=' . $opsidlnin;
            }
            $join = '';
            $join1 = '';
            $join2 = '';
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
            if ($dpt == 'GM' || $dpt == 'SP') {
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $field2 = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if ($dpt == 'GF') {
                $nobalefiel = ',nobale';
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,spek,name_kategori,kode,nobontr,insno,harga,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,idu,user_verif,tgl_verif,
                        SUM(SUM(kgs)+SUM(kgsin)-SUM(kgsout)) OVER (PARTITION BY id_barang) AS totkgs,SUM(SUM(pcs)+SUM(pcsin)-SUM(pcsout)) OVER (PARTITION BY id_barang) AS totpcs,safety_stock,nobale,nomor_bc,id_bom
                        FROM (";
            $tambah2 = ") pt GROUP BY po,item,dis,id_barang,nobontr,insno" . $nobalefiel . " ORDER BY nama_barang";
            $tambah2 .= $dpt == 'GS' ? '' : ",spek desc,nobontr,insno";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno," . $noeb1 . ",stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,stokdept.id_bom,1 AS nome,tb_po.spek,stokdept.id as idu,stokdept.user_verif,stokdept.tgl_verif,barang.safety_stock,stokdept.nobale" . $field . "
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join . "
                                        WHERE kgs_awal+pcs_awal > 0 AND periode = '" . $period . "' AND dept_id = '" . $dpt . "'" . $xinv . $xkat . $xcari . $xbcnya . $ifndln . "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno," . $noeb2 . ",tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout, satuan.kodesatuan,
                                        0 as id_bom,3 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detailgen.nobale" . $field2 . "
                                        FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detailgen.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join1 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 " . $xinv . $xkat . $xcari2 . $xbcnya . $ifndln2 .  "
                                        UNION ALL   
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,0 as id_bom,2 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale" . $field2 . "
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya . $ifndln3 .  "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,0 as id_bom,3 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale" . $field2 . "
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya . $ifndln3 . "
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }
    public function getdatadetail($array,$mode=0)
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            $dpt = $this->session->userdata('currdept');
            // $deptsubkon = datadepartemen($dpt,'katedept_id')==3 ? 'tb_detail.id_akb' : 'tb_detail.id_header';
            $deptsubkon = 'tb_detail.id_header';
            $field = ',"" as nomor_bc';
            $join = '';
            $join1 = '';
            $join2 = '';
            $nobalefiel = '';
            $nobalefiel2 = '';
            $nobalefiel3 = '';
            if ($dpt != 'GS') {
                if(in_array($dpt,daftardeptsubkon())){
                $tambah1 = "and stokdept.nobontr = '" . $array['nobontr'] . "' and stokdept.insno = '" . $array['insno'] . "' and stokdept.nomor_bc = '" . $array['nomor_bc'] . "'";
                $tambah2 = "and tb_detailgen.nobontr = '" . $array['nobontr'] . "' and tb_detailgen.insno = '" . $array['insno'] . "' and tb_header.exnomor_bc = '" . $array['nomor_bc'] . "'";
                $tambah3 = "and tb_detail.nobontr = '" . $array['nobontr'] . "' and tb_detail.insno = '" . $array['insno'] . "' and tb_header.nomor_bc = '" . $array['nomor_bc'] . "'";
                }else{
                    $tambah1 = "and stokdept.nobontr = '" . $array['nobontr'] . "' and stokdept.insno = '" . $array['insno'] . "' ";
                    $tambah2 = "and tb_detailgen.nobontr = '" . $array['nobontr'] . "' and tb_detailgen.insno = '" . $array['insno'] . "' ";
                    $tambah3 = "and tb_detail.nobontr = '" . $array['nobontr'] . "' and tb_detail.insno = '" . $array['insno'] . "' ";
                }
            } else {
                $tambah1 = '';
                $tambah2 = '';
                $tambah3 = '';
            }
            if ($dpt == 'GM') {
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if ($dpt == 'GF') {
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
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype" . $join . "
                                        WHERE periode = '" . $period . "' AND dept_id = '" . $dpt . "' 
                                        and stokdept.id_barang = " . $array['id_barang'] . " and stokdept.po = '" . $array['po'] . "' and stokdept.item = '" . $array['item'] . "' and stokdept.dis = " . $array['dis'] . "
                                        " . $tambah1 . $nobalefiel . "
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
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype" . $join1 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 
                                        AND tb_detailgen.id_barang = " . $array['id_barang'] . " and tb_detailgen.po = '" . $array['po'] . "' and tb_detailgen.item = '" . $array['item'] . "' and tb_detailgen.dis = " . $array['dis'] . "
                                        " . $tambah2 . $nobalefiel2 . "
                                        UNION ALL 
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno,tb_detail.nobontr,tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as pcsadj,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,0 as kgsadj,satuan.kodesatuan,0 as id_bom,2 AS nome,'' as idd,tb_po.spek,tb_detail.nobale,barang.safety_stock".$field."
                                        ,'' as xbc,'0000-00-00' as xtgl_bc FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = ".$deptsubkon."
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype" . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah3 . $nobalefiel3 . "
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
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype" . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah3 . $nobalefiel3 . "
                                        ORDER BY po,item,dis,nobontr,nome,tgl");
            return $hasil;
        }
    }
    public function getdatakategori(){
       $get = $this->getdata();

       $query = "Select id_kategori,kategori.nama_kategori from (".$get.") r3 left join kategori on id_kategori = kategori.kategori_id group by id_kategori order by nama_kategori";
       return $this->db->query($query);
    }
    public function getdatanomorbc(){
        if(in_array($this->session->userdata('currdept'),daftardeptsubkon())){
            $get = $this->getdata();

            $query = "Select nomor_bc from (".$get.") r3 group by nomor_bc order by nomor_bc";
            return $this->db->query($query);
        }else{
            return [];
        }
    }
    public function getreqinv(){
        $tgl = $this->session->userdata('tglakhir');
        return $this->db->get_where('tb_req_inventory',['tgl' => tglmysql($tgl)])->num_rows();
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
            if ($kat != 'X') {
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat . '") ';
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
                                        WHERE periode = '" . $period . "' AND dept_id = '" . $dpt . "' " . $xkat . "
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
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'OUT' AND tb_header.dept_id='" . $dpt . "' " . $xkat . " AND tb_header.data_ok = 1 
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
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'IB' AND tb_header.dept_tuju='" . $dpt . "' " . $xkat . " AND tb_header.data_ok = 1 
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
    public function getdatawip()
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            if ($this->session->userdata('currdept') == 'X') {
                $dpt = 'X';
                $dpx = "dept_id in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
                $dpy = "dept_tuju in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
            } else {
                $dpt = $this->session->userdata('currdept');
                $dpx = 'dept_id = "' . $this->session->userdata('currdept') . '" ';
                $dpy = 'dept_tuju = "' . $this->session->userdata('currdept') . '" ';
            }
            // $dpt = ['SP','NT','RR','GP','FG','FN','AR','AN','NU','AM']; //$this->session->userdata('currdept');
            $bcnya = $this->session->userdata('nomorbcnya');
            $kat = $this->session->userdata('filterkat');
            $xkat = '';
            $inv = $this->session->userdata('viewinv');
            $xinv = '';
            $xbcnya = '';
            if ($kat != 'X') {
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat . '" OR name_nettype = "' . $kat . '") ';
                }
            }
            if ($inv == 0) {
                $xinv = ' AND barang.noinv = 0 ';
            }
            if ($bcnya != 'X' && ($this->session->userdata('currdept') == 'GM' || $this->session->userdata('currdept') == 'SP')) {
                if ($bcnya != '') {
                    $xbcnya = ' AND tb_hargamaterial.nomor_bc =  "' . $bcnya . '" ';
                }
            }
            $xcari = '';
            $xcari2 = '';
            $xcari3 = '';
            $field = ',"" as nomor_bc';
            $nobalefiel = '';
            $ifndln = '';
            $ifndln2 = '';
            $ifndln3 = '';
            if (trim($this->session->userdata('ifndln')) != 'X') {
                $opsidlnin = $this->session->userdata('ifndln') == 'dln' ? 1 : 0;
                $ifndln = ' AND stokdept.dln=' . $opsidlnin;
                $ifndln2 = ' AND tb_detailgen.dln=' . $opsidlnin;
                $ifndln3 = ' AND tb_detail.dln=' . $opsidlnin;
            }
            $join = '';
            $join1 = '';
            $join2 = '';
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
            if ($dpt == 'GM' || $dpt == 'SP') {
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if ($dpt == 'GF') {
                $nobalefiel = ',nobale';
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT dept_idx,tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,spek,name_kategori,kode,nobontr,insno,harga,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,idd,idu,user_verif,tgl_verif,
                        SUM(SUM(kgs)+SUM(kgsin)-SUM(kgsout)) OVER (PARTITION BY id_barang) AS totkgs,SUM(SUM(pcs)+SUM(pcsin)-SUM(pcsout)) OVER (PARTITION BY id_barang) AS totpcs,safety_stock,nobale
                        FROM (";
            $tambah2 = ") pt GROUP BY dept_idx,po,item,dis,id_barang,nobontr,insno" . $nobalefiel . " ORDER BY nama_barang";
            $tambah2 .= $dpt == 'GS' ? '' : ",idd,nobontr,insno";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno," . $noeb1 . ",stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome,if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) AS idd,tb_po.spek,stokdept.id as idu,stokdept.user_verif,stokdept.tgl_verif,barang.safety_stock,stokdept.nobale" . $field . "
                                        ,stokdept.dept_id as dept_idx FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join . "
                                        WHERE kgs_awal+pcs_awal > 0 AND periode = '" . $period . "' AND " . $dpx . $xinv . $xkat . $xcari . $xbcnya . $ifndln . "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno," . $noeb2 . ",tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout, satuan.kodesatuan,
                                        3 AS nome,if(tb_detailgen.po!='',concat(tb_detailgen.po,tb_detailgen.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detailgen.nobale" . $field . "
                                        ,tb_header.dept_id as dept_idx FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detailgen.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join1 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 " . $xinv . $xkat . $xcari2 . $xbcnya . $ifndln2 .  "
                                        UNION ALL   
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale" . $field . "
                                        ,tb_header.dept_tuju as dept_idx FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header." . $dpy . " AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya .  "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,3 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale" . $field . "
                                        ,tb_header.dept_id as dept_idx FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya . $ifndln3 . "
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
            if ($this->session->userdata('currdept') == 'X') {
                $dpt = 'X';
                $dpx = "dept_id in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
                $dpy = "dept_tuju in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
            } else {
                $dpt = $this->session->userdata('currdept');
                $dpx = 'dept_id = "' . $this->session->userdata('currdept') . '" ';
                $dpy = 'dept_tuju = "' . $this->session->userdata('currdept') . '" ';
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
            if ($this->session->userdata('currdept') == 'X') {
                $dpt = 'X';
                $dpx = "dept_id in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
                $dpy = "dept_tuju in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
            } else {
                $dpt = $this->session->userdata('currdept');
                $dpx = 'dept_id = "' . $this->session->userdata('currdept') . '" ';
                $dpy = 'dept_tuju = "' . $this->session->userdata('currdept') . '" ';
            }
            $field = ',"" as nomor_bc';
            $join = '';
            $join1 = '';
            $join2 = '';
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
            if ($dpt == 'GM') {
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if ($dpt == 'GF') {
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
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype" . $join . "
                                        WHERE periode = '" . $period . "' AND " . $dpx . "
                                        and stokdept.id_barang = " . $array['id_barang'] . " and stokdept.po = '" . $array['po'] . "' and stokdept.item = '" . $array['item'] . "' and stokdept.dis = " . $array['dis'] . "
                                        " . $tambah1 . $nobalefiel . "
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
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype" . $join1 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 
                                        AND tb_detailgen.id_barang = " . $array['id_barang'] . " and tb_detailgen.po = '" . $array['po'] . "' and tb_detailgen.item = '" . $array['item'] . "' and tb_detailgen.dis = " . $array['dis'] . "
                                        " . $tambah2 . $nobalefiel2 . "
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
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype" . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header." . $dpy . " AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah3 . $nobalefiel3 . "
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
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype" . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 
                                        AND tb_header.ok_valid = 1 and tb_detail.id_barang = " . $array['id_barang'] . " and tb_detail.po = '" . $array['po'] . "' and tb_detail.item = '" . $array['item'] . "' and tb_detail.dis = " . $array['dis'] . "
                                        " . $tambah3 . $nobalefiel3 . "
                                        ORDER BY po,item,dis,nobontr,nome,tgl");
            return $hasil;
        }
    }
    public function getdatadetailbom($data)
    {
        
        $this->db->select('ref_bom_detail_cost.*,barang.nama_barang,barang.kode,satuan.kodesatuan,barang.imdo');
        $this->db->select('tb_hargamaterial.jns_bc as xjns_bc,tb_hargamaterial.nomor_bc as xnomor_bc,tb_hargamaterial.tgl_bc as xtgl_bc');
        $this->db->from('ref_bom_detail_cost');
        $this->db->join('ref_bom_cost','ref_bom_cost.id = ref_bom_detail_cost.id_bom','left');
        $this->db->join('barang','barang.id = ref_bom_detail_cost.id_barang','left');
        $this->db->join('satuan','satuan.id = barang.id_satuan','left');
        $this->db->join('tb_hargamaterial','tb_hargamaterial.id_barang = ref_bom_detail_cost.id_barang and trim(tb_hargamaterial.nobontr) = trim(ref_bom_detail_cost.nobontr)','left');
        $this->db->where('trim(ref_bom_cost.po)',trim($data['po']));
        $this->db->where('trim(ref_bom_cost.item)',trim($data['item']));
        $this->db->where('ref_bom_cost.dis',$data['dis']);
        $this->db->where('trim(ref_bom_cost.nobale)',trim($data['nobale']));
        $this->db->where('ref_bom_cost.id_barang',$data['id_barang']);
        if($this->session->userdata('currdept')!= 'GF'){
            $this->db->where('trim(ref_bom_cost.insno)',trim($data['insno']));
            $this->db->where('trim(ref_bom_cost.nobontr)',trim($data['nobontr']));
        }
        return $this->db->get();
    }
    public function getdatawipbaru($filter_kategori, $filt_ifndln)
    {
        if ($this->session->userdata('tglawal') != null) {
            $tglx = firstday($this->session->userdata('tglawal'));
            $tglawal = tglmysql($this->session->userdata('tglawal'));
            $tglakhir = tglmysql($this->session->userdata('tglakhir'));
            if ($this->session->userdata('currdept') == 'X') {
                $dpt = 'X';
                $dpx = "dept_id in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
                $dpy = "dept_tuju in ('SP','NT','RR','GP','FG','FN','AR','AN','NU','AM')";
            } else {
                $dpt = $this->session->userdata('currdept');
                $dpx = 'dept_id = "' . $this->session->userdata('currdept') . '" ';
                $dpy = 'dept_tuju = "' . $this->session->userdata('currdept') . '" ';
            }
            // $dpt = ['SP','NT','RR','GP','FG','FN','AR','AN','NU','AM']; //$this->session->userdata('currdept');
            $bcnya = $this->session->userdata('nomorbcnya');
            $kat = $filter_kategori == 'X' ? 'X' : $this->session->userdata('filterkat');
            $xkat = '';
            $inv = $this->session->userdata('viewinv');
            $xinv = '';
            $xbcnya = '';
            if ($kat != 'X') {
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat . '" OR name_nettype = "' . $kat . '") ';
                }
            }
            if ($inv == 0) {
                $xinv = ' AND barang.noinv = 0 ';
            }
            if ($bcnya != 'X' && ($this->session->userdata('currdept') == 'GM' || $this->session->userdata('currdept') == 'SP')) {
                if ($bcnya != '') {
                    $xbcnya = ' AND tb_hargamaterial.nomor_bc =  "' . $bcnya . '" ';
                }
            }
            $ifndln = '';
            $ifndln2 = '';
            $ifndln3 = '';
            if (trim($this->session->userdata('ifndln')) != 'X') {
                $opsidlnin = $this->session->userdata('ifndln') == 'dln' ? 1 : 0;
                $ifndln = ' AND stokdept.dln=' . $opsidlnin;
                $ifndln2 = ' AND tb_detailgen.dln=' . $opsidlnin;
                $ifndln3 = ' AND tb_detail.dln=' . $opsidlnin;
            }
            $xcari = '';
            $xcari2 = '';
            $xcari3 = '';
            $field = ',"" as nomor_bc';
            $nobalefiel = '';
            $join = '';
            $join1 = '';
            $join2 = '';
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
            if ($dpt == 'GM' || $dpt == 'SP') {
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if ($dpt == 'GF') {
                $nobalefiel = ',nobale';
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT dept_idx,tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,spek,name_kategori,kode,nobontr,insno,harga,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,idd,idu,user_verif,tgl_verif,
                        SUM(SUM(kgs)+SUM(kgsin)-SUM(kgsout)) OVER (PARTITION BY id_barang) AS totkgs,SUM(SUM(pcs)+SUM(pcsin)-SUM(pcsout)) OVER (PARTITION BY id_barang) AS totpcs,safety_stock,nobale
                        FROM (";
            $tambah2 = ") pt GROUP BY dept_idx,po,item,dis,id_barang,nobontr,insno" . $nobalefiel . " ORDER BY nama_barang";
            $tambah2 .= $dpt == 'GS' ? '' : ",idd,nobontr,insno";
            // if ($_POST['length'] != -1){
            //     $tambah3 = ' limit '.$_POST['start'].','.$_POST['length'];
            // }else{
            $tambah3 = '';
            // }
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno," . $noeb1 . ",stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,1 AS nome,if(stokdept.po!='',concat(stokdept.po,stokdept.item),barang.kode) AS idd,tb_po.spek,stokdept.id as idu,stokdept.user_verif,stokdept.tgl_verif,barang.safety_stock,stokdept.nobale" . $field . "
                                        ,stokdept.dept_id as dept_idx FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join . "
                                        WHERE kgs_awal+pcs_awal > 0 AND periode = '" . $period . "' AND " . $dpx . $xinv . $xkat . $xcari . $xbcnya . $ifndln . "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno," . $noeb2 . ",tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout, satuan.kodesatuan,
                                        3 AS nome,if(tb_detailgen.po!='',concat(tb_detailgen.po,tb_detailgen.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detailgen.nobale" . $field . "
                                        ,tb_header.dept_id as dept_idx FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detailgen.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join1 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 " . $xinv . $xkat . $xcari2 . $xbcnya . $ifndln2 .  "
                                        UNION ALL   
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,2 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale" . $field . "
                                        ,tb_header.dept_tuju as dept_idx FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header." . $dpy . " AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya . $ifndln3 .  "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,3 AS nome,if(tb_detail.po!='',concat(tb_detail.po,tb_detail.item),barang.kode) AS idd,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale" . $field . "
                                        ,tb_header.dept_id as dept_idx FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header." . $dpx . " AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya . $ifndln3 . "
                                        ORDER BY nama_barang,tgl,nome" . $tambah2 . $tambah3);
            return $hasil;
        }
    }
    public function getopname(){
        if($this->session->userdata('tglawal')==null){
            $tglakhir = '01-01-1970';
        }else{
            $tglakhir = $this->session->userdata('tglakhir');
        }
        $cek = $this->db->get_where('stokopname_detail',['tgl' => tglmysql($tglakhir)],1)->num_rows();
        if($cek > 0){
            return $this->db->get_where('stokopname_detail',['tgl' => tglmysql($tglakhir)],1)->row_array();
        }else{
            return ['tgl' => ''];
        }
    }
    public function get_datatableswip($filter_kategori, $filt_ifndln)
    {
        $query = $this->getdatawipbaru($filter_kategori, $filt_ifndln);
        return $query->result();
    }
    public function count_filteredwip($filter_kategori, $filt_ifndln)
    {
        $query = $this->getdatawipbaru($filter_kategori, $filt_ifndln);
        $jmlfilt =  $query->num_rows();
        return $jmlfilt;
    }
    public function count_allwip()
    {
        $query = $this->getdatawipbaru('X', 'X');
        $jml = $query->num_rows();
        return $jml;
    }
    public function getkgspcswip($filter_kategori, $filt_ifndln)
    {
        $pcs = 0;
        $kgs = 0;
        $query = $this->getdatawipbaru($filter_kategori, $filt_ifndln);
        $no = 0;
        foreach ($query->result_array() as $quer) {
            $no++;
            $pcs += $quer['pcs'] + $quer['pcsin'] - $quer['pcsout'];
            $kgs += $quer['kgs'] + $quer['kgsin'] - $quer['kgsout'];
        }
        return array('rekod' => $no, 'pecees' => $pcs, 'kagees' => $kgs);
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
            if ($kat != 'X') {
                if ($kat != '' || $kat != null) {
                    $xkat = ' AND (barang.id_kategori = "' . $kat . '" OR name_nettype = "' . $kat . '") ';
                }
            }
            if ($inv == 0) {
                $xinv = ' AND barang.noinv = 0 ';
            }
            if ($bcnya != 'X' && ($this->session->userdata('currdept') == 'GM' || $this->session->userdata('currdept') == 'SP')) {
                if ($bcnya != '') {
                    $xbcnya = ' AND tb_hargamaterial.nomor_bc =  "' . $bcnya . '" ';
                }
            }
            $ifndln = '';
            $ifndln2 = '';
            $ifndln3 = '';
            if (trim($this->session->userdata('ifndln')) != 'X') {
                $opsidlnin = $this->session->userdata('ifndln') == 'dln' ? 1 : 0;
                $ifndln = ' AND stokdept.dln=' . $opsidlnin;
                $ifndln2 = ' AND tb_detailgen.dln=' . $opsidlnin;
                $ifndln3 = ' AND tb_detail.dln=' . $opsidlnin;
            }
            $xcari = '';
            $xcari2 = '';
            $xcari3 = '';
            $field = ',stokdept.nomor_bc as nomor_bc';
            $field2 = ',"" as nomor_bc';
            $nobalefiel = '';
            $join = '';
            $join1 = '';
            $join2 = '';
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
            if ($dpt == 'GM' || $dpt == 'SP') {
                $field = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $field2 = ',tb_hargamaterial.jns_bc,tb_hargamaterial.nomor_bc,tb_hargamaterial.tgl_bc';
                $join = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = stokdept.id_barang AND tb_hargamaterial.nobontr = stokdept.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join1 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detailgen.id_barang AND tb_hargamaterial.nobontr = tb_detailgen.nobontr AND tb_hargamaterial.nomor_bc != ""';
                $join2 = ' LEFT JOIN (SELECT DISTINCT jns_bc,nomor_bc,tgl_bc,id_barang,nobontr FROM tb_hargamaterial) as tb_hargamaterial ON tb_hargamaterial.id_barang = tb_detail.id_barang AND tb_hargamaterial.nobontr = tb_detail.nobontr AND tb_hargamaterial.nomor_bc != ""';
            }
            if ($dpt == 'GF') {
                $nobalefiel = ',nobale';
            }
            $period = substr($tglx, 5, 2) . substr($tglx, 0, 4);
            $tambah1 = "SELECT tgl,null as nomor_dok,mode,po,item,dis,id_barang,nama_barang,spek,name_kategori,kode,nobontr,insno,harga,kodesatuan,SUM(pcs) AS pcs,SUM(kgs) AS kgs,SUM(pcsin) AS pcsin,
                        SUM(kgsin) AS kgsin,SUM(pcsout) AS pcsout,SUM(kgsout) AS kgsout,idu,user_verif,tgl_verif,
                        SUM(SUM(kgs)+SUM(kgsin)-SUM(kgsout)) OVER (PARTITION BY id_barang) AS totkgs,SUM(SUM(pcs)+SUM(pcsin)-SUM(pcsout)) OVER (PARTITION BY id_barang) AS totpcs,safety_stock,nobale,nomor_bc,id_bom
                        FROM (";
            $tambah2 = ") pt GROUP BY po,item,dis,id_barang,nobontr,insno,nama_barang,spek" . $nobalefiel . " ORDER BY nama_barang";
            $tambah2 .= $dpt == 'GS' ? '' : ",spek desc,nobontr,insno";
            $hasil = $this->db->query($tambah1 . "SELECT 'SALDO' AS mode,'SA' AS kode_dok,stokdept.id,NULL AS id_header,stokdept.id_barang,stokdept.po,stokdept.item,
                                        stokdept.dis, stokdept.insno," . $noeb1 . ",stokdept.harga,'SALDO' AS nomor_dok,'" . $tglx . "' AS tgl,
                                        barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,stokdept.pcs_awal AS pcs,0 AS pcsin,0 AS pcsout,stokdept.kgs_awal AS kgs,0 AS kgsin,0 AS kgsout,
                                        satuan.kodesatuan,stokdept.id_bom,1 AS nome,tb_po.spek,stokdept.id as idu,stokdept.user_verif,stokdept.tgl_verif,barang.safety_stock,stokdept.nobale" . $field . "
                                        FROM stokdept 
                                        LEFT JOIN barang ON barang.id = stokdept.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = stokdept.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join . "
                                        WHERE kgs_awal+pcs_awal > 0 AND periode = '" . $period . "' AND dept_id = '" . $dpt . "'" . $xinv . $xkat . $xcari . $xbcnya . $ifndln . "
                                        UNION ALL 
                                        SELECT IF(tb_header.kode_dok='T','OUT','-') AS mode,tb_header.kode_dok,null,tb_detailgen.id,tb_detailgen.id_barang,tb_detailgen.po,
                                        tb_detailgen.item,tb_detailgen.dis, tb_detailgen.insno," . $noeb2 . ",tb_detailgen.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,
                                        0 AS pcs,0 AS pcsin,tb_detailgen.pcs AS pcsout,0 as kgs,0 as kgsin,tb_detailgen.kgs AS kgsout, satuan.kodesatuan,
                                        0 as id_bom,3 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detailgen.nobale" . $field2 . "
                                        FROM tb_detailgen 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detailgen.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detailgen.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detailgen.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join1 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'T' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 " . $xinv . $xkat . $xcari2 . $xbcnya . $ifndln2 .  "
                                        UNION ALL   
                                        SELECT 'IB' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,0 as id_bom,2 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale" . $field2 . "
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND (tb_header.kode_dok = 'IB' OR tb_header.kode_dok = 'T') AND tb_header.dept_tuju='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya . $ifndln3 .  "
                                        UNION ALL 
                                        SELECT 'ADJ' AS mode,tb_header.kode_dok,null,tb_detail.id,tb_detail.id_barang,tb_detail.po,tb_detail.item,tb_detail.dis, 
                                        tb_detail.insno," . $noeb3 . ",tb_detail.harga,tb_header.nomor_dok,tb_header.tgl,barang.nama_barang,barang.kode,if(kategori.nama_kategori!='',kategori.nama_kategori,nettype.name_nettype) AS name_kategori,0 as pcs,tb_detail.pcs AS pcsin,
                                        0 AS pcsout,0 as kgs,tb_detail.kgs AS kgsin,0 AS kgsout,satuan.kodesatuan,0 as id_bom,3 AS nome,tb_po.spek,0 as idu,0 as user_verif,'0000-00-00' as tgl_verif,barang.safety_stock,tb_detail.nobale" . $field2 . "
                                        FROM tb_detail 
                                        LEFT JOIN tb_header ON tb_header.id = tb_detail.id_header 
                                        LEFT JOIN barang ON barang.id = tb_detail.id_barang 
                                        LEFT JOIN satuan ON satuan.id = barang.id_satuan 
                                        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori
                                        LEFT JOIN tb_po ON tb_po.id = tb_detail.id_po
                                        LEFT JOIN nettype ON nettype.id = tb_po.id_nettype " . $join2 . "
                                        WHERE tb_header.tgl <= '" . $tglawal . "' and month(tb_header.tgl)=" . substr($tglx, 5, 2) . " And year(tb_header.tgl)=" . substr($tglx, 0, 4) . " AND tb_header.kode_dok = 'ADJ' AND tb_header.dept_id='" . $dpt . "' AND tb_header.data_ok = 1 AND tb_header.ok_valid = 1" . $xinv . $xkat . $xcari3 . $xbcnya . $ifndln3 . "
                                        ORDER BY nama_barang,tgl,nome" . $tambah2);
            return $hasil;
        }
    }
    public function get_datatablesgf($filter_kategori, $filt_ifndln)
    {
        $query = $this->getdatagf($filter_kategori, $filt_ifndln);
        return $query->result();
    }
    public function count_filteredgf($filter_kategori, $filt_ifndln)
    {
        $query = $this->getdatagf($filter_kategori, $filt_ifndln);
        $jmlfilt =  $query->num_rows();
        return $jmlfilt;
    }
    public function count_allgf()
    {
        $query = $this->getdatagf('X');
        $jml = $query->num_rows();
        return $jml;
    }
    public function getkgspcsgf($filter_kategori, $filt_ifndln)
    {
        $pcs = 0;
        $kgs = 0;
        $query = $this->getdatagf($filter_kategori, $filt_ifndln);
        $no = 0;
        foreach ($query->result_array() as $quer) {
            $no++;
            $pcs += $quer['pcs'] + $quer['pcsin'] - $quer['pcsout'];
            $kgs += $quer['kgs'] + $quer['kgsin'] - $quer['kgsout'];
        }
        return array('rekod' => $no, 'pecees' => $pcs, 'kagees' => $kgs);
    }
    public function getdatareport(){
        $draw = $_POST['draw'];
        $start = $_POST['start'];
        $length = $_POST['length'];
        $searchValue = $_POST['search']['value'];
        $orderColumn = $_POST['order'][0]['column'];
        $orderDir = $_POST['order'][0]['dir'];
        $columns = $_POST['columns'];

        // Build the SQL query
        $sql = "SELECT * FROM stokdept where periode = '072025' ";
        $where = [];

        // Apply search filter if provided
        if (!empty($searchValue)) {
            $where[] = "id_barang LIKE '%{$searchValue}%' OR id_barang LIKE '%{$searchValue}%'";
        }

        // Add WHERE clauses if any
        if (!empty($where)) {
            $sql .= " WHERE " . implode(" AND ", $where);
        }

        // Get total records (before filtering)
        $totalRecordsQuery = $this->db->query("SELECT COUNT(*) as jmlrek FROM stokdept where periode = '072025' ")->row_array();
        $totalRecords = $totalRecordsQuery['jmlrek'];

        // Get filtered records count
        $filteredRecordsQuery = $this->db->query(str_replace("SELECT * ", "SELECT COUNT(*) as jmlrek ", $sql))->row_array();
        $filteredRecords = $filteredRecordsQuery['jmlrek'];

        // Apply ordering
        $orderColumnName = $columns[$orderColumn]['data'];
        // $sql .= " ORDER BY {$orderColumnName} {$orderDir}";
        // $sql .= " ORDER BY 1 {$orderDir}";

        // Apply pagination
        // $sql .= " LIMIT {$start}, {$length}";

        // Execute the query
        $result = $this->db->query($sql);

        $data = [];
        // while ($row = $result->fetch_assoc()) {
        //     $data[] = array_values($row); // Convert associative array to indexed array for DataTables
        // }
        foreach ($result->result_array() as $row) {
             $data[] = array_values($row);
        }

        // Prepare the response in JSON format
        $response = [
            "draw" => intval($draw),
            "recordsTotal" => intval($totalRecords),
            "recordsFiltered" => intval($filteredRecords),
            "data" => $data
        ];

        return $response;
    }
}
