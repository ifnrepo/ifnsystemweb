<?php
class bcmaterialmodel extends CI_Model
{
    public function getdatalama()
    {
        $tglawal = $this->session->userdata('tglawalbcmaterial');
        $tglakhir = $this->session->userdata('tglakhirbcmaterial');
        $periode = cekperiodedaritgl($tglawal);

        // Query untuk CekSaldobarang
        $this->db->select("0 as kodeinv,stokdept.po,stokdept.item,stokdept.dis,stokdept.id_barang");
        $this->db->select('sum(pcs_awal) as saldopcs,sum(kgs_awal) as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('stokdept');
        $this->db->where('dept_id','GM');
        $this->db->where('periode',$periode);
        $this->db->group_by('po,item,dis,id_barang');
        $query1 = $this->db->get_compiled_select();

        // Query untuk barang masuk 
        $this->db->select("1 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('sum(pcs) as inpcs,sum(kgs) as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_tuju','GM');
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',$tglawal);
        $this->db->where('tb_header.tgl <=',$tglakhir);
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        $this->db->where('tb_header.ok_valid',1);
        $this->db->group_by('po,item,dis,id_barang');
        $query2 = $this->db->get_compiled_select();

        // Query untuk barang keluar
        $this->db->select("2 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('sum(pcs) as outpcs,sum(kgs) as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_id','GM');
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',$tglawal);
        $this->db->where('tb_header.tgl <=',$tglakhir);
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        // $this->db->where('tb_header.ok_valid',0);
        $this->db->group_by('po,item,dis,id_barang');
        $query3 = $this->db->get_compiled_select();

        $kolom = "Select satuan.kodesatuan,barang.nama_barang,barang.kode,po,item,dis,id_barang,barang.imdo,sum(saldopcs) as saldopcs,sum(saldokgs) as saldokgs,sum(inpcs) as inpcs,sum(inkgs) as inkgs,sum(outpcs) as outpcs,sum(outkgs) as outkgs from (".$query1." union all ".$query2." union all ".$query3.") r1";
        $kolom .= " left join barang on barang.id = id_barang";
        $kolom .= " left join satuan on barang.id_satuan = satuan.id ";
        $kolom .= " left join kategori on barang.id_kategori = kategori.kategori_id ";
        if($this->session->userdata('kepemilikan') != '' && $this->session->userdata('katebar') != ''){
            $kolom .= " where kategori.jns <= 2 AND ";
            $kolom .= " barang.dln = ".$this->session->userdata('kepemilikan')." and barang.id_kategori = ".$this->session->userdata('katebar');
        }
        if($this->session->userdata('kepemilikan') != '' && $this->session->userdata('katebar') == ''){
            $kolom .= " where kategori.jns <= 2 AND ";
            $kolom .= " barang.dln = ".$this->session->userdata('kepemilikan');
        }
        if($this->session->userdata('kepemilikan') == '' && $this->session->userdata('katebar') != ''){
            $kolom .= " where kategori.jns <= 2 AND ";
            $kolom .= " barang.id_kategori = ".$this->session->userdata('katebar');
        }
        $kolom .= " group by po,item,dis,id_barang";
        $kolom .= " order by barang.nama_barang";
        $hasil = $this->db->query($kolom);

        return $hasil;
    }
    public function getdata($mode=0){ // jika 0 mode Inventory, jika 1 Mode IT Inventory
        if($this->session->userdata('tglawalbcmaterial')==null){
            $tglawal = '01-01-1970';
            $tglakhir = '01-01-1970';
            $dept = '$%';
            $ifndln = 'all';
        }else{
            $tglawal = $this->session->userdata('tglawalbcmaterial');
            $tglakhir = $this->session->userdata('tglakhirbcmaterial');
            $dept = $this->session->userdata('currdept');
            $ifndln = 'all';
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
        $this->db->where('dept_id','GM');
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
        $this->db->where('dept_tuju','GM');
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
        $this->db->where('dept_id','GM');
        $this->db->where('month(tb_header.tgl)',$bl);
        $this->db->where('year(tb_header.tgl)',$th);
        $this->db->where('tb_header.tgl <= ',tglmysql($tglakhir));
        $this->db->where('tb_header.kode_dok','T');
        $this->db->where('tb_header.data_ok',1);
        // $this->db->where('tb_header.ok_valid',1);
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
        $this->db->where('dept_id','GM');
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

        $kolom = " Select *,sum(saldokgs+inkgs-outkgs+adjkgs) over() as totalkgs,sum(saldopcs+inpcs-outpcs+adjpcs) over() as totalpcs,sum(saldopcs) over() as sawalpcs,sum(saldokgs) over() as sawalkgs,sum(inpcs) over() as totalinpcs,sum(outpcs) over() as totaloutpcs,sum(inkgs) over() as totalinkgs,sum(outkgs) over() as totaloutkgs,sum(adjpcs) over() as totaladjpcs,sum(adjkgs) over() as totaladjkgs from (Select kategori.jns,kodeinv,nobale,po,item,dis,id_barang,xdln,left(concat(ifnull(id_kategori_po,''),ifnull(barang.id_kategori,'')),4) as id_kategori,trim(xnomor_bc) as nomor_bc,insno,nobontr,barang.kode,idu,stok,exnet,sum(saldopcs) as saldopcs,sum(saldokgs) as saldokgs,sum(inpcs) as inpcs,sum(inkgs) as inkgs,sum(outpcs) as outpcs,sum(outkgs) as outkgs,sum(adjpcs) as adjpcs,sum(adjkgs) as adjkgs,(sum(saldopcs)+sum(inpcs)-sum(outpcs)+sum(adjpcs)) as sumpcs,(sum(saldokgs)+sum(inkgs)-sum(outkgs)+sum(adjkgs)) as sumkgs,satuan.kodesatuan,barang.nama_barang,barang.imdo,spek,exdo,id_buyer,";
        $kolom .= "(select kgs from stokopname_hasil where trim(po)=trim(r1.po) and trim(item)=trim(r1.item) and dis=r1.dis and id_barang = r1.id_barang and dept_id = 'GM' and tgl='".tglmysql($tglakhir)."') as kgs_taking,";
        $kolom .= "(select pcs from stokopname_hasil where trim(po)=trim(r1.po) and trim(item)=trim(r1.item) and dis=r1.dis and id_barang = r1.id_barang and dept_id = 'GM' and tgl='".tglmysql($tglakhir)."') as pcs_taking ";
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
        // $kolom .= " group by po,item,dis,id_barang,insno,nobontr,nobale,nomor_bc,stok,exnet order by po,item,dis,id_barang,insno,nobontr,nobale,nomor_bc,stok,exnet) r2";
        $kolom .= " group by po,item,dis,id_barang order by po,item,dis,id_barang) r2";
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
                    $setWhere[] = '(sumkgs != ifnull(kgs_taking,0) OR sumpcs != ifnull(pcs_taking,0))';
                }else{
                    $setWhere[] = $key."='".$value."'";
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


    public function getdatabyid($id)
    {
        $tglawal = $this->session->userdata('tglawalbcmaterial');
        $tglakhir = $this->session->userdata('tglakhirbcmaterial');
        $periode = cekperiodedaritgl($tglawal);

        // Query untuk CekSaldobarang
        $this->db->select("'".tglmysql($tglawal). "' as tgl,0 as kodeinv,stokdept.po,stokdept.item,stokdept.dis,stokdept.id_barang,'SALDO' as nomor_dok");
        $this->db->select('sum(pcs_awal) as saldopcs,sum(kgs_awal) as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('stokdept');
        $this->db->where('dept_id','GM');
        $this->db->where('periode',$periode);
        $this->db->where('id_barang',$id);
        $this->db->group_by('po,item,dis,id_barang');
        $query1 = $this->db->get_compiled_select();

        // Query untuk barang masuk 
        $this->db->select("tb_header.tgl,1 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang,tb_header.nomor_dok");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('pcs as inpcs,kgs as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_tuju','GM');
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',tglmysql($tglawal));
        $this->db->where('tb_header.tgl <=',tglmysql($tglakhir));
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        $this->db->where('tb_header.ok_valid',1);
        $this->db->where('tb_detail.id_barang',$id);
        // $this->db->group_by('po,item,dis,id_barang');
        $query2 = $this->db->get_compiled_select();

        // Query untuk barang keluar
        $this->db->select("tb_header.tgl,2 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang,tb_header.nomor_dok");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('pcs as outpcs,kgs as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_id','GM');
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',tglmysql($tglawal));
        $this->db->where('tb_header.tgl <=',tglmysql($tglakhir));
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        // $this->db->where('tb_header.ok_valid',0);
        $this->db->where('tb_detail.id_barang',$id);
        // $this->db->group_by('po,item,dis,id_barang');
        $this->db->order_by('tgl');
        $query3 = $this->db->get_compiled_select();

        $kolom = "Select * from (".$query1." union all ".$query2." union all ".$query3.") r1";
        $kolom .= " left join barang on barang.id = id_barang";
        $kolom .= " left join satuan on barang.id_satuan = satuan.id ";
        $kolom .= " order by tgl,kodeinv";
        $hasil = $this->db->query($kolom);

        return $hasil;
    }

    public function getopname(){
        if($this->session->userdata('tglawalbcmaterial')==null){
            $tglakhir = '01-01-1970';
        }else{
            $tglakhir = $this->session->userdata('tglakhirbcmaterial');
        }
        $cek = $this->db->get_where('stokopname_hasil',['tgl' => tglmysql($tglakhir),'dept_id' => "GM"],1)->num_rows();
        if($cek > 0){
            return $this->db->get_where('stokopname_hasil',['tgl' => tglmysql($tglakhir),'dept_id' => "GM"],1)->row_array();
        }else{
            return ['tgl' => ''];
        }
    }

    public function getdatakategori()
    {
        if ($this->session->userdata('tglawalbcmaterial') == null) {
            $tglawal = date('01-m-Y');
            $tglakhir = tglmysql(lastday($this->session->userdata('thbcmaterial') . '-' . $this->session->userdata('blbcmaterial') . '-01'));
            $periode = cekperiodedaritgl(tglmysql($tglawal));
        }else{
            $tglawal = $this->session->userdata('tglawalbcmaterial');
            $tglakhir = $this->session->userdata('tglakhirbcmaterial');
            $periode = cekperiodedaritgl($tglawal);
        }

        // Query untuk CekSaldobarang
        $this->db->select("0 as kodeinv,stokdept.po,stokdept.item,stokdept.dis,stokdept.id_barang");
        $this->db->select('sum(pcs_awal) as saldopcs,sum(kgs_awal) as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('stokdept');
        $this->db->where('dept_id','GM');
        $this->db->where('periode',$periode);
        $this->db->group_by('po,item,dis,id_barang');
        $query1 = $this->db->get_compiled_select();

        // Query untuk barang masuk 
        $this->db->select("1 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('sum(pcs) as inpcs,sum(kgs) as inkgs');
        $this->db->select('0 as outpcs,0 as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_tuju','GM');
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',tglmysql($tglawal));
        $this->db->where('tb_header.tgl <=',tglmysql($tglakhir));
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        $this->db->where('tb_header.ok_valid',1);
        $this->db->group_by('po,item,dis,id_barang');
        $query2 = $this->db->get_compiled_select();

        // Query untuk barang keluar
        $this->db->select("2 as kodeinv,tb_detail.po,tb_detail.item,tb_detail.dis,tb_detail.id_barang");
        $this->db->select('0 as saldopcs,0 as saldokgs');
        $this->db->select('0 as inpcs,0 as inkgs');
        $this->db->select('sum(pcs) as outpcs,sum(kgs) as outkgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_id','GM');
        $this->db->where('tb_header.kode_dok !=','BBL');
        $this->db->where('tb_header.tgl >=',tglmysql($tglawal));
        $this->db->where('tb_header.tgl <=',tglmysql($tglakhir));
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_tuju',1);
        // $this->db->where('tb_header.ok_valid',0);
        $this->db->group_by('po,item,dis,id_barang');
        $query3 = $this->db->get_compiled_select();

        $kolom = "Select *,id_barang,barang.id_kategori,kategori.nama_kategori from (".$query1." union all ".$query2." union all ".$query3.") r1";
        $kolom .= " left join barang on barang.id = id_barang";
        $kolom .= " left join satuan on barang.id_satuan = satuan.id ";
        $kolom .= " left join kategori on kategori.kategori_id = barang.id_kategori ";
        $kolom .= " where kategori.jns <= 2 ";
        $kolom .= " group by kategori.nama_kategori";
        $kolom .= " order by barang.nama_barang";
        $hasil = $this->db->query($kolom);

        return $hasil;
    }


    public function getdetailbyid($id)
    {
        $header = $this->db->get_where('tb_header', ['id' => $id])->row_array();

        $this->db->select('tb_detail.*,satuan.kodesatuan,barang.nama_barang,barang.kode,tb_po.spek,tb_klppo.engklp');
        $this->db->from('tb_detail');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('tb_po', 'tb_po.po = tb_detail.po AND tb_po.item = tb_detail.item AND tb_po.dis = tb_detail.dis', 'left');
        $this->db->join('tb_klppo', 'tb_klppo.id = tb_po.klppo', 'left');

        if ($header && $header['jns_bc'] == '261') {
            $this->db->where('tb_detail.id_akb', $id);
        } else {
            $this->db->where('tb_detail.id_header', $id);
        }

        return $this->db->get();
    }


    public function getdata_export()
    {
        $tglawal = $this->session->userdata('tglawalbcmaterial');
        $tglakhir = $this->session->userdata('tglakhirbcmaterial');
        $jnsbc = $this->session->userdata('jnsbc');

        $this->db->select('tb_detail.*, tb_header.*, barang.nama_barang, barang.nama_alias, barang.kode, satuan.kodesatuan, supplier.nama_supplier, customer.nama_customer, ref_mt_uang.mt_uang as xmtuang, dept.departemen');
        if ($jnsbc == '261') {
            $this->db->join('tb_detail', 'tb_detail.id_akb = tb_header.id', 'left');
            $this->db->join('dept', 'dept.dept_id = tb_header.dept_tuju', 'left');
        } elseif ($jnsbc == 'Y') {
            $this->db->join('tb_detail', '(tb_detail.id_header = tb_header.id OR tb_detail.id_akb = tb_header.id)', 'left');
            $this->db->join('dept', 'dept.dept_id = tb_header.dept_tuju', 'left');
        } else {
            $this->db->join('tb_detail', 'tb_detail.id_header = tb_header.id', 'left');
            $this->db->join('dept', 'dept.dept_id = tb_header.dept_tuju', 'left');
        }
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->join('customer', 'customer.id = tb_header.id_buyer', 'left');
        $this->db->join('ref_mt_uang', 'ref_mt_uang.id = tb_header.mtuang', 'left');
        $this->db->where("tb_header.tgl_bc between '" . tglmysql($tglawal) . "' AND '" . tglmysql($tglakhir) . "' ");
        $this->db->where('trim(tb_header.nomor_bc) !=', '');



        if ($this->session->userdata('jnsbc') != 'Y') {
            $this->db->where("tb_header.jns_bc", $jnsbc);
        } else {
            $this->db->where_in("tb_header.jns_bc", [25, 30, 261, 41]);
        }

        $this->db->where('tb_header.data_ok', 1);
        $this->db->where('tb_header.ok_tuju', 1);
        // $this->db->where('tb_header.ok_valid', 1);

        return $this->db->get('tb_header');
    }
}
