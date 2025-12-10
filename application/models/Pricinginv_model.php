<?php
class Pricinginv_model extends CI_Model
{
    public function cekfield($id,$kolom,$nilai){
        $this->db->where('id',$id);
        $this->db->where($kolom,$nilai);
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }
    public function getdeptperiode(){
        $tglawal = '01-'.$this->session->userdata('blpricing').'-'.$this->session->userdata('thpricing');
        $periode = cekperiodedaritgl($tglawal);

        $this->db->select('stokinv.dept_id,dept.departemen');
        $this->db->from('stokinv');
        $this->db->join('dept','dept.dept_id = stokinv.dept_id','left');
        $this->db->where('periode',$periode);
        $this->db->group_by('1');
        return $this->db->get();
    }
    public function gettglcutoff($dept){
        $tglawal = '01-'.$this->session->userdata('blpricing').'-'.$this->session->userdata('thpricing');
        $periode = cekperiodedaritgl($tglawal);

        $this->db->select('tgl');
        $this->db->from('stokinv');
        $this->db->where('periode',$periode);
        $this->db->where('dept_id',$dept);
        $this->db->group_by('1');
        return $this->db->get();
    }
    public function getdata(){
        $tglawal = '01-'.$this->session->userdata('blpricing').'-'.$this->session->userdata('thpricing');
        $periode = cekperiodedaritgl($tglawal);
        $tgl = $this->session->userdata('tglpricinginv');

        $this->db->select("stokinv.*,barang.nama_barang,tb_po.spek,barang.kode,barang.id_kategori as yidkategori,tb_po.id_kategori as xidkategori,IFNULL(barang.id_satuan,22) as id_satuan,barang.dln as xdln,tb_po.dln as ydln,CONCAT(trim(stokinv.po),'#',trim(stokinv.item),stokinv.dis) as sku");
        $this->db->from('stokinv');
        $this->db->join('barang','barang.id = stokinv.id_barang','left');
        $this->db->join('tb_po','tb_po.ind_po = concat(stokinv.po,stokinv.item,stokinv.dis)','left');
        $this->db->where('stokinv.tgl',$tgl);
        if($this->session->userdata('deptpricinginv')!=''){
            $this->db->where('dept_id',$this->session->userdata('deptpricinginv'));
        }
        // $this->db->order_by('stokinv.dept_id','stokinv.urut');
        $query1 = $this->db->get_compiled_select();

        $kolom = "Select *,sum(pcs_akhir) over() as totalpcs,sum(kgs_akhir) over() as totalkgs from (Select r1.*,LEFT(CONCAT(IFNULL(ydln,''),IFNULL(xdln,'')),1) AS mdln,LEFT(CONCAT(IFNULL(yidkategori,''),IFNULL(xidkategori,'')),4) AS id_kategori,kategori.nama_kategori,satuan.kodesatuan from (".$query1.") r1 ";
        $kolom .= "LEFT JOIN kategori on kategori.kategori_id = LEFT(CONCAT(IFNULL(yidkategori,''),IFNULL(xidkategori,'')),4) ";
        $kolom .= "LEFT JOIN satuan on satuan.id = id_satuan ";
        if($this->session->userdata('milik')!=''){
            $kolom .= "where LEFT(CONCAT(IFNULL(ydln,''),IFNULL(xdln,'')),1) = '".$this->session->userdata('milik')."'";
        }
        $kolom .= ") r2";
        return $kolom;
    }
    public function getdatainv($filtkat){
        $query = $this->getdata();
        // $cari = array('barang.kode','nama_barang','nama_kategori');
        $cari = array('po','nobontr','insno','spek','nama_barang','kode','sku');
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
                $setWhere[] = $key."='".$value."'";
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
            'data'=>$data,
            'totalkgs' => 100
        );
        return json_encode($callback); // Convert array $callback ke json
    }
    public function getdatadet(){
        $tglawal = '01-'.$this->session->userdata('blpricing').'-'.$this->session->userdata('thpricing');
        $periode = cekperiodedaritgl($tglawal);
        $tgl = $this->session->userdata('tglpricinginv');

        $this->db->select("stokinv_detail.*,stokinv.dept_id,stokinv.tgl,stokinv.po,stokinv.item,stokinv.dis,barang.kode,barang.nama_barang,stokinv.periode");
        $this->db->select("stokinv.po as xpo,stokinv.nobontr as xnobontr,stokinv.insno as xinsno,headbarang.nama_barang as xnama_barang,tb_po.spek as xspek,headbarang.kode as xkode,CONCAT(trim(stokinv.po),'#',trim(stokinv.item),stokinv.dis) as sku");
        $this->db->select("(SELECT harga_akt FROM tb_hargamaterial WHERE tb_hargamaterial.id_barang = stokinv_detail.id_barang AND tb_hargamaterial.nobontr = stokinv_detail.nobontr AND (stokinv_detail.nomor_bc != '' OR stokinv_detail.nomor_bc is not null) LIMIT 1) AS harga_akt");
        $this->db->select("barang.id_kategori as xid_kategori,tb_po.id_kategori as yid_kategori");
        $this->db->select("LEFT(CONCAT(IFNULL(headbarang.dln,''),IFNULL(tb_po.dln,'')),1) as mdln");
        $this->db->from('stokinv_detail');
        $this->db->join('barang','barang.id = stokinv_detail.id_barang','left');
        $this->db->join('stokinv','stokinv ON stokinv.id = stokinv_detail.id_stok ','left');
        $this->db->join('barang headbarang','headbarang.id = stokinv.id_barang','left');
        $this->db->join('tb_po','tb_po.ind_po = concat(stokinv.po,stokinv.item,stokinv.dis)','left');
        $this->db->where('stokinv.tgl',$tgl);
        if($this->session->userdata('deptpricinginv')!=''){
            $this->db->where('stokinv.dept_id',$this->session->userdata('deptpricinginv'));
        }
        $this->db->order_by('stokinv.dept_id','stokinv.urut');
        $query1 = $this->db->get_compiled_select();

        $kolom = "Select *,SUM(kgs) OVER() as totalkgsdet,SUM(harga_akt*kgs) OVER() AS tothargadet from (Select *,LEFT(CONCAT(IFNULL(yid_kategori,''),IFNULL(xid_kategori,'')),4) AS id_kategori from (".$query1.") r1 ";
        // $kolom .= "LEFT JOIN kategori on kategori.kategori_id = CONCAT(IFNULL(yidkategori,''),IFNULL(xidkategori,'')) ";
        // $kolom .= "LEFT JOIN satuan on satuan.id = id_satuan";
        if($this->session->userdata('milik')!=''){
            $kolom .= "where mdln = '".$this->session->userdata('milik')."'";
        }
        $kolom .= " ) r2";
        return $kolom;
    }
    public function getdatainvdet($filtkat){
        $query = $this->getdatadet();
        // $cari = array('barang.kode','nama_barang','nama_kategori');
        $cari = array('xpo','xnobontr','xinsno','xnama_barang','xkode','sku');
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
                $setWhere[] = $key."='".$value."'";
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
            'data'=>$data,
            'totalkgs' => 100
        );
        return json_encode($callback); // Convert array $callback ke json
    }
    public function simpancutoff($data){
        $cek = $this->db->get_where('tb_req_inventory',['tgl' => $data['tgl']]);
        if($cek->num_rows() > 0){
            $isi = $cek->row_array();
            $this->session->set_flashdata('errorsimpan',1);
            $this->session->set_flashdata('pesanerror',"Data sudah ada,  tidak bisa dibuat Ulang\r\nDibuat oleh ".datauser($isi['user_add'],'name')." pada ".$isi['tgl_add']);
            return 1;
        }else{
            return $this->db->insert('tb_req_inventory',$data);
        }
    }
    public function getdepe(){
        return $this->db->get_where('dept',['katedept_id < ' => 4]);
    }
    public function getdeptoncutoff($depe,$tgl){
        if($tgl==''){
            $tgl = '1970-01-01';
        }
        $cek = $this->db->get_where('stokinv',['dept_id' => $depe,'tgl'=>$tgl]);
        if($cek->num_rows() > 0){
            return '';
        }else{
            return 'disabled';
        }
    }
    public function gettglreq(){
        return $this->db->get_where('tb_req_inventory',['month(tgl)' => $this->session->userdata('blpricing'),'year(tgl)' => $this->session->userdata('thpricing')]);
    }
    public function breakdowninv(){
        $this->db->trans_start();
        $query = $this->db->query($this->getdata());
        foreach($query->result_array() as $que){
            // if($que['id_barang']==119){
            $this->db->where('id_stok',$que['id']);
            $this->db->delete('stokinv_detail');

            $databom = getdatabomcost($que);
            if(count($databom) > 0){
                foreach($databom as $dbom){
                    $this->db->insert('stokinv_detail',$dbom);
                }
            }else{
                $dbom = [
                    'id_stok' => $que['id'],
                    'urut' => $que['urut'],
                    'id_barang' => $que['id_barang'],
                    'kgs' => 0,
                ];

                $this->db->insert('stokinv_detail',$dbom);
            }
            // }
        }       
        return $this->db->trans_complete();
    }
    public function usersaveinv(){
        $tgl = '';
        $dept = '';
        $ret = '';
        if($this->session->userdata('tglpricinginv')!=''){
            $tgl = $this->session->userdata('tglpricinginv');
        }
        if($this->session->userdata('deptpricinginv')!=''){
            $dept = $this->session->userdata('deptpricinginv');
        }
        if($tgl=='' || $dept==''){
            $ret = '';
        }else{
            $hasil = $this->db->get_where('stokinv',['tgl' => $tgl,'dept_id' => $dept]);
            if($hasil->num_rows() > 0){
                $xhasil = $hasil->row_array();
                $ret = datauser($xhasil['user_verif'],'name').' Tgl. '.tglmysql2($xhasil['tgl_verif']);
            }
        }
        return $ret;
    }
    public function userlockinv(){
        $tgl = '';
        $dept = '';
        $ret = '';
        if($this->session->userdata('tglpricinginv')!=''){
            $tgl = $this->session->userdata('tglpricinginv');
        }

        if($tgl==''){
            $ret = '';
        }else{
            $hasil = $this->db->get_where('stokinv',['tgl' => $tgl]);
            if($hasil->num_rows() > 0){
                $xhasil = $hasil->row_array();
                if($xhasil['kunci']==0){
                    $ret = $xhasil['user_lock'] > 0 ? 'Dibuka oleh : '.datauser($xhasil['user_lock'],'name').' Tgl. '.tglmysql2($xhasil['tgl_lock']) : '';
                }else{
                     $ret = $xhasil['user_lock'] > 0 ? 'Dikunci oleh : '.datauser($xhasil['user_lock'],'name').' Tgl. '.tglmysql2($xhasil['tgl_lock']) : 'User Not Found';
                }
            }
        }
        return $ret;
    }
    public function lockinv(){
        $this->db->where('tgl',$this->session->userdata('tglpricinginv'));
        return $this->db->update('stokinv',['kunci' => 1,'user_lock' => $this->session->userdata('id'),'tgl_lock' => date('Y-m-d H:i:s')]);
    }
    public function unlockinv(){
        $this->db->where('tgl',$this->session->userdata('tglpricinginv'));
        return $this->db->update('stokinv',['kunci' => 0,'user_lock' => $this->session->userdata('id'),'tgl_lock' => date('Y-m-d H:i:s')]);
    }
    public function tglkunci(){
        $hasil = 0;
        $data = $this->db->get_where('stokinv',['tgl' => $this->session->userdata('tglpricinginv'),'kunci' => 1],1);
        if($data->num_rows() > 0){
            $hasil = 1;
        }
        return $hasil;
    }
    public function getdatkategori(){
        $kolom = "Select id_kategori,nama_kategori from (".$this->getdata().") r3 group by 1,2 order by 2";
        return $this->db->query($kolom);
    }

    // End Pricing
    public function getdatabyid($id)
    {
        $this->db->select('tb_header.*,dept.departemen');
        $this->db->join('dept', 'dept.dept_id=tb_header.dept_id', 'left');
        $this->db->where('tb_header.id', $id);
        return $this->db->get('tb_header')->row_array();
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
        if($this->session->userdata('tujusekarang')=='GS' || $this->session->userdata('tujusekarang')=='GM'){
            $datadet = $this->db->get_where('tb_detail',['id_header'=>$data['id']]);
            foreach ($datadet->result_array() as $keydet) {
                $keydet['id_detail'] = $keydet['id'];
                unset($keydet['id']);
                $this->db->insert('tb_detailgen',$keydet);
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
            $pek = explode(' ',$spec);
            $spekjadi= '';
            if(count($pek)>0){
                for($x=0;$x<count($pek);$x++){
                    $spekjadi .= $pek[$x].'%';
                }
            }else{
                $spekjadi = $spec.'%';
            }
            $queryx = $this->db->query("Select * from barang where nama_barang like '%".substr($spekjadi,0,strlen($spekjadi)-1)."%' and act=1 order by nama_barang ");
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
