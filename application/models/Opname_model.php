<?php
class Opname_model extends CI_Model
{
    public function getdata($limit=0, $start=0)
    {
        $periode = $this->session->userdata('periodeopname');

        $this->db->select('stokopname_detail.*,barang.kode,tb_po.spek,barang.nama_barang,barang.imdo,IFNULL(satuan.kodesatuan,"PCS") as kodesatuan');
        // $this->db->select('sum(pcs) as sumpcs,sum(kgs) as sumkgs');
        $this->db->select("IF(TRIM(stokopname_detail.po)!='',CONCAT(TRIM(stokopname_detail.po),'#',TRIM(stokopname_detail.item),IF(stokopname_detail.dis > 0,CONCAT(' dis ',stokopname_detail.dis),'')),'') AS skupo");
        $this->db->select("tb_lokasi.nama_lokasi,tb_lokasi.kode_lokasi");
        $this->db->select("IF(TRIM(stokopname_detail.po)='',barang.imdo,IF(tb_po.exdo='EXPORT',1,0)) AS expdom");
        $this->db->from('stokopname_detail');
        $this->db->join('tb_po', 'tb_po.ind_po = CONCAT(stokopname_detail.po,stokopname_detail.item,stokopname_detail.dis)', 'left');
        $this->db->join('barang','barang.id = stokopname_detail.id_barang','left');
        $this->db->join('satuan','satuan.id = barang.id','left');
        $this->db->join('stokopname','stokopname.id = stokopname_detail.id_stokopname','left');
        $this->db->join('tb_lokasi','tb_lokasi.kode_lokasi = stokopname.kode_lokasi','left');
        $this->db->where('stokopname_detail.tgl',$periode);
        if($this->session->userdata('currdeptopname')!==''){
            $this->db->where('stokopname_detail.dept_id',$this->session->userdata('currdeptopname'));
        }
        if($this->session->userdata('kepemilikanopname')!='' && $this->session->userdata('kepemilikanopname')!='all'){
            $this->db->where('stokopname_detail.dln',$this->session->userdata('kepemilikanopname'));
        }
        if($this->session->userdata('exdo')!='' && $this->session->userdata('exdo')!='all'){
            $this->db->where('IF(TRIM(stokopname_detail.po)="",barang.imdo,IF(tb_po.exdo="EXPORT",1,0)) = '.$this->session->userdata('exdo'));
        }
        if($this->session->userdata('cari-rekapopname')!=''){
            $this->db->group_start();
                $this->db->like("IF(TRIM(stokopname_detail.po)!='',CONCAT(TRIM(stokopname_detail.po),'#',TRIM(stokopname_detail.item),IF(stokopname_detail.dis > 0,CONCAT(' dis ',stokopname_detail.dis),'')),'') ",$this->session->userdata('cari-rekapopname'));
                $this->db->or_like("barang.kode",$this->session->userdata('cari-rekapopname'));
                $this->db->or_like("stokopname_detail.insno",$this->session->userdata('cari-rekapopname'));
                $this->db->or_like("barang.nama_barang",$this->session->userdata('cari-rekapopname'));
            $this->db->group_end();
        }
        // $this->db->group_by('po,item,dis,id_barang,insno,nobontr,stok,exnet,nobale');

        $query = $this->db->get_compiled_select();

        $kolom = "Select *,sum(pcs) over() as totalpcs,sum(kgs) over() as totalkgs from (".$query.") r1 limit ".$start.",".$limit;
        $hasil = $this->db->query($kolom);
        return $hasil;
    }
    public function countdata(){
        $periode = $this->session->userdata('periodeopname');

        $this->db->select('stokopname_detail.*,barang.kode,tb_po.spek,barang.nama_barang,barang.imdo,IFNULL(satuan.kodesatuan,"PCS") as kodesatuan');
        // $this->db->select('sum(pcs) as sumpcs,sum(kgs) as sumkgs');
        $this->db->select("IF(TRIM(stokopname_detail.po)!='',CONCAT(TRIM(stokopname_detail.po),'#',TRIM(stokopname_detail.item),IF(stokopname_detail.dis > 0,CONCAT(' dis ',stokopname_detail.dis),'')),'') AS skupo");
        $this->db->from('stokopname_detail');
        $this->db->join('tb_po', 'tb_po.ind_po = CONCAT(stokopname_detail.po,stokopname_detail.item,stokopname_detail.dis)', 'left');
        $this->db->join('barang','barang.id = stokopname_detail.id_barang','left');
        $this->db->join('satuan','satuan.id = barang.id','left');
        $this->db->where('stokopname_detail.tgl',$periode);
        if($this->session->userdata('currdeptopname')!==''){
            $this->db->where('stokopname_detail.dept_id',$this->session->userdata('currdeptopname'));
        }
        if($this->session->userdata('kepemilikanopname')!='' && $this->session->userdata('kepemilikanopname')!='all'){
            $this->db->where('stokopname_detail.dln',$this->session->userdata('kepemilikanopname'));
        }
        if($this->session->userdata('exdo')!='' && $this->session->userdata('exdo')!='all'){
            $this->db->where('IF(TRIM(stokopname_detail.po)="",barang.imdo,IF(tb_po.exdo="EXPORT",1,0)) = '.$this->session->userdata('exdo'));
        }
        if($this->session->userdata('cari-rekapopname')!=''){
            $this->db->group_start();
                $this->db->like("IF(TRIM(stokopname_detail.po)!='',CONCAT(TRIM(stokopname_detail.po),'#',TRIM(stokopname_detail.item),IF(stokopname_detail.dis > 0,CONCAT(' dis ',stokopname_detail.dis),'')),'') ",$this->session->userdata('cari-rekapopname'));
                $this->db->or_like("barang.kode",$this->session->userdata('cari-rekapopname'));
                $this->db->or_like("stokopname_detail.insno",$this->session->userdata('cari-rekapopname'));
                $this->db->or_like("barang.nama_barang",$this->session->userdata('cari-rekapopname'));
            $this->db->group_end();
        }
        // $this->db->group_by('po,item,dis,id_barang,insno,nobontr,stok,exnet,nobale');

        $query = $this->db->get_compiled_select();

        $kolom = "Select *,sum(pcs) over() as totalpcs,sum(kgs) over() as totalkgs from (".$query.") r1";
        $hasil = $this->db->query($kolom);
        return $hasil->num_rows();
    }
    public function getdatabaru($filtkat,$mode=0){
        $query = $this->getdata($mode);
        // $cari = array('barang.kode','nama_barang','nama_kategori');
        $cari = array('po','insno','nobontr','spek','nobale','id_barang','nama_barang','kode','skupo');
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
    public function jmldept()
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');

        return $this->db->get()->num_rows();
    }
    public function getdataperiode()
    {
        return $this->db->get('tb_periode_stokopname');
    }
    public function getdatapersentase(){
        $this->db->select('dept.dept_id,dept.departemen,stokopname_config.persen_verif,stokopname_config.persen_rilis');
        $this->db->from('dept');
        $this->db->join('stokopname_config','stokopname_config.dept_id = dept.dept_id','left');
        $this->db->where('dept.stokopname','1');
        $this->db->order_by('dept.departemen');
        return $this->db->get();
    }
    public function getdetailperiode(){
        $periode = $this->session->userdata('periodeopname');
        return $this->db->get_where('tb_periode_stokopname',['tgl' => $periode])->row_array();
    }
    public function simpanperiode($data)
    {
        return $this->db->insert('tb_periode_stokopname',$data);
    }
    public function hapusperiode($id)
    {
        $this->db->where('id',$id);
        return $this->db->delete('tb_periode_stokopname');
    }
    public function updateperiode($data)
    {
        $this->db->where('id',$data['id']);
        return $this->db->update('tb_periode_stokopname',$data);
    }
    public function updatepersenstok($data){
        $cekdata = $this->db->get_where('stokopname_config',['dept_id' => $data['dept']])->num_rows();
        $dept = $data['dept'];
        if($cekdata > 0){
            $id = $data['dept'];
            unset($data['dept']);

            $data['persen_verif'] = $data['verif'];
            $data['persen_rilis'] = $data['rilis'];
            unset($data['verif']);
            unset($data['rilis']);
            $this->db->where('dept_id',$id);
            $hasil = $this->db->update('stokopname_config',$data);
        }else{
            // Add Data 
            $data['dept_id'] = $data['dept'];
            $data['persen_verif'] = $data['verif'];
            $data['persen_rilis'] = $data['rilis'];
            unset($data['dept']);
            unset($data['verif']);
            unset($data['rilis']);
            $hasil = $this->db->insert('stokopname_config',$data);
        }
        if($hasil){
            return $this->db->get_where('stokopname_config',['dept_id' => $dept]);
        }
    }
    public function updatestokopname($data)
    {
        $this->db->where('id',$data['id']);
        return $this->db->update('stokopname_detail',$data);
    }
    public function hapusrekapopname($id)
    {
        $this->db->where('id',$id);
        return $this->db->delete('stokopname_detail');
    }
    public function getlokasi(){
        $periode = $this->session->userdata('periodeopname');
        $this->db->select('tb_lokasi.*');
        $this->db->from('tb_lokasi');
        $this->db->join('stokopname','stokopname.kode_lokasi = tb_lokasi.kode_lokasi','left');
        $this->db->where('tb_lokasi.dept_id',$this->session->userdata('deptstok'));
        $this->db->where('tb_lokasi.kode_lokasi not in (SELECT kode_lokasi FROM stokopname WHERE stokopname.periode = "'.$periode    .'" GROUP BY 1)');
        return $this->db->get();
    }
    public function getdatastok(){
        $dpt = $this->session->userdata('hakstokopname');
        $akses_so = str_split($dpt, 2);
        $this->db->select('stokopname.*,tb_lokasi.nama_lokasi');
        $this->db->from('stokopname');
        $this->db->join('tb_lokasi','tb_lokasi.kode_lokasi = stokopname.kode_lokasi','left');
        $this->db->where('stokopname.periode',$this->session->userdata('periodeopname'));
        if($this->session->userdata('deptstok')!=''){
            $this->db->where('stokopname.dept_id',$this->session->userdata('deptstok'));
        }
        if($this->session->userdata('statusstok')!=''){
            $this->db->where('stokopname.status',$this->session->userdata('statusstok'));
        }
        $this->db->where_in('stokopname.dept_id',$akses_so);
        if($this->session->userdata('cari-sublok')!=''){
            $isi = $this->session->userdata('cari-sublok');
            if(str_contains(trim($isi)," ")){
                $pisah = explode(" ",trim($isi));
                $hasil = '';
                foreach($pisah as $ps){
                    $hasil .= $ps.'%';
                }
                $kata = substr($hasil,0,strlen($hasil)-1);
            }else{
                $kata = trim($isi);
            }
            $this->db->group_start();
            $this->db->like('stokopname.kode_lokasi',$isi,'both',FALSE);
            $this->db->or_like('tb_lokasi.nama_lokasi',$isi,'both',FALSE);
            $this->db->group_end();
        }
        return $this->db->get();
    }
    public function getdatastokbyid($id){
        $this->db->select('stokopname.*,tb_lokasi.nama_lokasi,dept.departemen,stokopname_config.persen_verif,stokopname_config.persen_rilis');
        $this->db->from('stokopname');
        $this->db->join('tb_lokasi','tb_lokasi.kode_lokasi = stokopname.kode_lokasi','left');
        $this->db->join('dept','dept.dept_id = stokopname.dept_id','left');
        $this->db->join('stokopname_config','stokopname_config.dept_id = stokopname.dept_id','left');
        $this->db->where('stokopname.id',$id);
        return $this->db->get()->row_array();
    }
    public function getdatadetailstok($id,$limit=0,$start=0){
        $this->db->select('stokopname.*,tb_lokasi.nama_lokasi');
        $this->db->from('stokopname');
        $this->db->join('tb_lokasi','tb_lokasi.kode_lokasi = stokopname.kode_lokasi','left');
        $this->db->where('stokopname.id',$id);
        $cekdata = $this->db->get()->row_array();

        if(strtoupper(trim($cekdata['nama_lokasi']))=='ON MACHINE'){
            $this->db->select('stokopname_onmachine.*,barang.nama_barang,barang.kode');
            $this->db->select("IF(TRIM(stokopname_onmachine.po)!='',CONCAT(TRIM(stokopname_onmachine.po),'#',TRIM(stokopname_onmachine.item),IF(stokopname_onmachine.dis > 0,CONCAT(' dis ',stokopname_onmachine.dis),'')),'') AS skupo");
            $this->db->from('stokopname_onmachine');
            $this->db->join('barang','barang.id = stokopname_onmachine.brg_id','left');
            $this->db->where('id_stokopname',$id);
            $this->db->order_by('machno');
        }else{
            $this->db->select('stokopname_detail.*,barang.nama_barang,barang.kode');
            $this->db->select("IF(TRIM(stokopname_detail.po)!='',CONCAT(TRIM(stokopname_detail.po),'#',TRIM(stokopname_detail.item),IF(stokopname_detail.dis > 0,CONCAT(' dis ',stokopname_detail.dis),'')),'') AS skupo");
            $this->db->from('stokopname_detail');
            $this->db->join('barang','barang.id = stokopname_detail.id_barang','left');
            $this->db->where('id_stokopname',$id);
            $this->db->order_by('urut');
        }
        if($this->session->userdata('cari-entri')!=''){
            $isi = $this->session->userdata('cari-entri');
            if(str_contains(trim($isi)," ")){
                $pisah = explode(" ",trim($isi));
                $hasil = '';
                foreach($pisah as $ps){
                    $hasil .= $ps.'%';
                }
                $kata = substr($hasil,0,strlen($hasil)-1);
            }else{
                $kata = trim($isi);
            }
            $this->db->group_start();
            if(strtoupper(trim($cekdata['nama_lokasi']))=='ON MACHINE'){
                // $this->db->like('stokopname_onmachine.po',$isi,'both',FALSE);
                // $this->db->or_like('stokopname_onmachine.insno',$isi,'both',FALSE);
                // $this->db->or_like('barang.nama_barang',$isi,'both',FALSE);
                // $this->db->or_like('barang.kode',$isi,'both',FALSE);
                $this->db->where('stokopname_onmachine.machno',$isi);
            }else{
                $this->db->like('stokopname_detail.po',$isi,'both',FALSE);
                $this->db->or_like('stokopname_detail.insno',$isi,'both',FALSE);
                $this->db->or_like('barang.nama_barang',$isi,'both',FALSE);
                $this->db->or_like('barang.kode',$isi,'both',FALSE);
            }
            $this->db->group_end();
        }
        $this->db->limit($limit, $start);
        return $this->db->get();
    }
    public function countdatadetailstok($id){
        $this->db->select('stokopname_detail.*,barang.nama_barang');
        $this->db->from('stokopname_detail');
        $this->db->join('barang','barang.id = stokopname_detail.id_barang','left');
        $this->db->where('id_stokopname',$id);
        return $this->db->get()->num_rows();
    }
    public function simpanstok($data){
        return $this->db->insert('stokopname',$data);
    }
    public function hapusstok($data){
        $this->db->trans_start();
        $this->db->where('id_stokopname',$data);
        $this->db->delete('stokopname_detail');

        $this->db->where('id',$data);
        $this->db->delete('stokopname');

        return $this->db->trans_complete();
    }
    public function getkodelokasi($dept){
        $this->db->select('MAX(SUBSTR(kode_lokasi,3,3)) as maxkode');
        $this->db->from('tb_lokasi');
        $this->db->where('dept_id',$dept);
        $kode = $this->db->get()->row_array();

        $urut = (int) $kode['maxkode'];
        $urut++;
        return $dept . sprintf("%03s", $urut);
    }
    public function getdatasublok(){
        $this->db->select('tb_lokasi.*,dept.departemen,stokopname.dept_id as pakai');
        $this->db->from('tb_lokasi');
        $this->db->join('dept','dept.dept_id = tb_lokasi.dept_id','left');
        $this->db->join('stokopname','stokopname.kode_lokasi = tb_lokasi.kode_lokasi','left');
        $this->db->where('tb_lokasi.dept_id',$this->session->userdata('deptsublok'));
        $this->db->order_by('kode_lokasi');
        return $this->db->get();
    }
    public function getdatasublokbyid($id){
        return $this->db->get_where('tb_lokasi',['id' => $id])->row_array();    
    }
    public function simpansublok($data){
        return $this->db->insert('tb_lokasi',$data);
    }
    public function updatesublok($data){
        $id = $data['id'];
        unset($data['id']);
        $this->db->where('id',$id);
        return $this->db->update('tb_lokasi',$data);
    }
    public function hapussublok($data){
        $this->db->trans_start();

        $this->db->where('id',$data);
        $this->db->delete('tb_lokasi');

        return $this->db->trans_complete();
    }
    public function cariinsnopo($dept,$keyw){
        $this->db->select('stokdept.*,tb_po.spek,barang.nama_barang,barang.kode,tb_po.color');
        $this->db->select("IF(TRIM(stokdept.po)!='',CONCAT(TRIM(stokdept.po),'#',TRIM(stokdept.item),IF(stokdept.dis > 0,CONCAT(' dis ',stokdept.dis),'')),'') AS skupo");
        $this->db->from('stokdept');
        $this->db->join('tb_po','tb_po.ind_po = concat(stokdept.po,stokdept.item,stokdept.dis)','left');
        $this->db->join('barang','barang.id = stokdept.id_barang','left');
        $this->db->where('stokdept.periode',cekperiodedaritgl($this->session->userdata('periodeopname')));
        $this->db->where('stokdept.dept_id',$dept);
        $this->db->group_start();
        $this->db->like('stokdept.po',$keyw);
        $this->db->or_like('stokdept.insno',$keyw);
        $this->db->group_end();
        return $this->db->get();
    }
    public function cariinsnomesin($dept,$keyw){
        $keyw = str_replace("-"," ",$keyw);
        $kata = '';
        $pisah = explode(" ",$keyw);
        foreach($pisah as $ps){
            $kata .= $ps.'%';
        }
        $keu = substr($kata,0,strlen($kata)-1);
        $this->db->select('tb_netinstr.*,tb_po.spek,"" as nama_barang,"" as kode,tb_po.dln,tb_po.color,0 as exnet,0 as stok,"" as nobontr,"" as nobale,0 as id_barang');
        $this->db->select("IF(TRIM(tb_netinstr.po)!='',CONCAT(TRIM(tb_netinstr.po),'#',TRIM(tb_netinstr.item),IF(tb_netinstr.dis > 0,CONCAT(' dis ',tb_netinstr.dis),'')),'') AS skupo");
        $this->db->from('tb_netinstr');
        $this->db->join('tb_po','tb_po.ind_po = concat(tb_netinstr.po,tb_netinstr.item,tb_netinstr.dis)','left');
        $this->db->group_start();
        $this->db->like('tb_netinstr.po',$keu,'both',FALSE);
        $this->db->or_like('tb_netinstr.insno',$keu,'both',FALSE);
        $this->db->group_end();
        $this->db->order_by('tb_netinstr.po,tb_netinstr.item,tb_netinstr.dis,tb_netinstr.insno');
        return $this->db->get();
    }
    public function cariidbarang($dept,$keyw){
        $this->db->select('stokdept.*,barang.kode,barang.nama_barang,barang.dln');
        $this->db->from('stokdept');
        $this->db->join('barang','barang.id = stokdept.id_barang','left');
        $this->db->where('stokdept.periode',cekperiodedaritgl($this->session->userdata('periodeopname')));
        $this->db->where('stokdept.dept_id',$dept);
        $this->db->like('barang.kode',$keyw);
        return $this->db->get();
    }
    public function carispekbarang($dept,$keyw){
        $keyw = str_replace("-"," ",$keyw);
        $kata = '';
        $pisah = explode(" ",$keyw);
        foreach($pisah as $ps){
            $kata .= $ps.'%';
        }
        $keu = substr($kata,0,strlen($kata)-1);
        $this->db->select('stokdept.*,barang.kode,barang.nama_barang,barang.dln');
        $this->db->from('stokdept');
        $this->db->join('barang','barang.id = stokdept.id_barang','left');
        $this->db->where('stokdept.periode',cekperiodedaritgl($this->session->userdata('periodeopname')));
        $this->db->where('stokdept.dept_id',$dept);
        $this->db->like('barang.nama_barang',$keu,'both',FALSE);
        return $this->db->get();
    }
    public function carinomorbale($dept,$keyw){
        $keyw = str_replace("-"," ",$keyw);
        $kata = '';
        $pisah = explode(" ",$keyw);
        foreach($pisah as $ps){
            $kata .= $ps.'%';
        }
        $keu = substr($kata,0,strlen($kata)-1);
        $this->db->select('stokdept.*,barang.kode,barang.nama_barang,barang.dln');
        $this->db->from('stokdept');
        $this->db->join('barang','barang.id = stokdept.id_barang','left');
        $this->db->where('stokdept.periode',cekperiodedaritgl($this->session->userdata('periodeopname')));
        $this->db->where('stokdept.dept_id',$dept);
        $this->db->like('stokdept.nobale',$keu,'both',FALSE);
        return $this->db->get();
    }
    public function simpanentristok($data){
        $this->db->trans_start();
        $this->db->select('max(urut) as maxkode');
        $this->db->from('stokopname_detail');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $geturut = $this->db->get()->row_array();

        $urut = (int) $geturut['maxkode'];
        $urut++;
        $data['urut'] = $urut;
        $data['user_add'] = $this->session->userdata('id');
        $data['kgs'] = round($data['kgs'],2);
        $this->db->insert('stokopname_detail',$data);

        $this->db->select('SUM(pcs) as pcs,SUM(kgs) as kgs,count(*) as item');
        $this->db->from('stokopname_detail');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $hasil = $this->db->get()->row_array();

        $header = [
            'pcs' => $hasil['pcs'],
            'kgs' => $hasil['kgs'],
            'item' => $hasil['item'],
            'tgl_edit' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',$header);
        return $this->db->trans_complete();
    }
    public function updateentristok($data){
        $this->db->trans_start();
        $id = $data['id'];
        unset($data['id']);
        $xdata = $this->db->get_where('stokopname_detail',['id' => $id])->row_array();
        
        $this->db->where('id',$id);
        $this->db->update('stokopname_detail',$data);

        $this->db->select('SUM(pcs) as pcs,SUM(kgs) as kgs,count(*) as item');
        $this->db->from('stokopname_detail');
        $this->db->where('id_stokopname',$xdata['id_stokopname']);
        $hasil = $this->db->get()->row_array();

        $header = [
            'pcs' => $hasil['pcs'],
            'kgs' => $hasil['kgs'],
            'item' => $hasil['item'],
            'tgl_edit' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id',$xdata['id_stokopname']);
        $this->db->update('stokopname',$header);
        return $this->db->trans_complete();
    }
    public function hapusentristok($id){
        $this->db->trans_start();
        $data = $this->db->get_where('stokopname_detail',['id' => $id])->row_array();

        $this->db->where('id',$id);
        $this->db->delete('stokopname_detail');

        $this->db->select('SUM(pcs) as pcs,SUM(kgs) as kgs,count(*) as item');
        $this->db->from('stokopname_detail');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $hasil = $this->db->get()->row_array();

        $header = [
            'pcs' => $hasil['pcs'],
            'kgs' => $hasil['kgs'],
            'item' => $hasil['item'],
            'tgl_edit' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',$header);
        return $this->db->trans_complete();
    }
    public function getdataentristokbyid($id){
        $this->db->select('stokopname_detail.*,barang.nama_barang,barang.kode,tb_po.spek,round(stokopname_detail.pcs,2) as pcsc,round(stokopname_detail.kgs,2) as kgsc');
        $this->db->select("IF(TRIM(stokopname_detail.po)!='',CONCAT(TRIM(stokopname_detail.po),'#',TRIM(stokopname_detail.item),IF(stokopname_detail.dis > 0,CONCAT(' dis ',stokopname_detail.dis),'')),'') AS skupo");
        $this->db->from('stokopname_detail');
        $this->db->join('barang','barang.id = stokopname_detail.id_barang','left');
        $this->db->join('tb_po','tb_po.ind_po = concat(stokopname_detail.po,stokopname_detail.item,stokopname_detail.dis)','left');
        $this->db->where('stokopname_detail.id',$id);
        return $this->db->get()->row_array();
    }
    public function caribarang($dept,$id){
        $this->db->select('stokdept.*,barang.nama_barang,barang.kode');
        $this->db->from('stokdept');
        $this->db->join('barang','barang.id = stokdept.id_barang','left');
        $this->db->where('stokdept.periode',cekperiodedaritgl($this->session->userdata('periodeopname')));
        $this->db->where('stokdept.dept_id',$dept);
        $this->db->like('barang.kode',$id);
        $this->db->order_by('barang.kode');
        return $this->db->get();
    }
    public function caripo($dept,$id){
        $this->db->select('stokdept.*,barang.nama_barang,barang.kode');
        $this->db->from('stokdept');
        $this->db->join('barang','barang.id = stokdept.id_barang','left');
        $this->db->where('stokdept.periode',cekperiodedaritgl($this->session->userdata('periodeopname')));
        $this->db->where('stokdept.dept_id',$dept);
        $this->db->group_start();
        $this->db->like('stokdept.po',$id);
        $this->db->or_like('stokdept.insno',$id);
        $this->db->group_end();
        $this->db->order_by('stokdept.po,stokdept.item,stokdept.insno,stokdept.nobale');
        return $this->db->get();
    }
    public function cariberatpo($sat,$data){
        $hasil = $this->db->get_where('tb_po',['ind_po' => $data])->row_array();
        return $hasil['jala']+$hasil['mimi'];
    }

    public function selesaiinput($id){
        $this->db->where('id',$id);
        return $this->db->update('stokopname',['status' => 1,'user_selesai' => $this->session->userdata('id'),'tgl_selesai' => date('Y-m-d H:i:s')]);
    }
    public function batalinput($id){
        $this->db->where('id',$id);
        return $this->db->update('stokopname',['status' => 0,'user_selesai' => 0,'tgl_selesai' => NULL]);
    }
    public function selesaiverifikasi($id){
        $this->db->where('id',$id);
        return $this->db->update('stokopname',['status' => 2,'user_verif' => $this->session->userdata('id'),'tgl_verif' => date('Y-m-d H:i:s')]);
    }
    public function batalverifikasi($id){
        $this->db->where('id',$id);
        return $this->db->update('stokopname',['status' => 1,'user_verif' => 0,'tgl_verif' => NULL]);
    }
    public function selesairilis($id){
        $this->db->where('id',$id);
        return $this->db->update('stokopname',['status' => 3,'user_rilis' => $this->session->userdata('id'),'tgl_rilis' => date('Y-m-d H:i:s')]);
    }
    public function batalrilis($id){
        $this->db->where('id',$id);
        return $this->db->update('stokopname',['status' => 2,'user_rilis' => 0,'tgl_rilis' => NULL]);
    }
    public function verifentristok($id){
        $this->db->where('id',$id);
        $this->db->update('stokopname_detail',['user_verif' => $this->session->userdata('id'),'tgl_verif' => date('Y-m-d H:i:s')]);

        $data = $this->db->get_where('stokopname_detail',['id' => $id])->row_array();

        $this->db->select('count(*) as jml');
        $this->db->from('stokopname_detail');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $this->db->where('user_verif !=',0);
        $jumlah = $this->db->get()->row_array();

        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',['item_verif' => $jumlah['jml']]);

        return $data;
    }
    public function verifentrimesin($id){
        $this->db->where('id',$id);
        $this->db->update('stokopname_onmachine',['user_verif' => $this->session->userdata('id'),'tgl_verif' => date('Y-m-d H:i:s')]);

        $data = $this->db->get_where('stokopname_onmachine',['id' => $id])->row_array();

        $this->db->select('count(*) as jml');
        $this->db->from('stokopname_onmachine');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $this->db->where('user_verif !=',0);
        $jumlah = $this->db->get()->row_array();

        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',['item_verif' => $jumlah['jml']]);

        return $data;
    }
    public function rilisentristok($id){
        $this->db->where('id',$id);
        $this->db->update('stokopname_detail',['user_rilis' => $this->session->userdata('id'),'tgl_rilis' => date('Y-m-d H:i:s')]);

        $data = $this->db->get_where('stokopname_detail',['id' => $id])->row_array();

        $this->db->select('count(*) as jml');
        $this->db->from('stokopname_detail');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $this->db->where('user_rilis !=',0);
        $jumlah = $this->db->get()->row_array();

        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',['item_rilis' => $jumlah['jml']]);

        return $data;
    }
    public function rilisentrimesin($id){
        $this->db->where('id',$id);
        $this->db->update('stokopname_onmachine',['user_rilis' => $this->session->userdata('id'),'tgl_rilis' => date('Y-m-d H:i:s')]);

        $data = $this->db->get_where('stokopname_onmachine',['id' => $id])->row_array();

        $this->db->select('count(*) as jml');
        $this->db->from('stokopname_onmachine');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $this->db->where('user_rilis !=',0);
        $jumlah = $this->db->get()->row_array();

        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',['item_rilis' => $jumlah['jml']]);

        return $data;
    }
    public function batalkanverifstok($id){
        $this->db->where('id',$id);
        $this->db->update('stokopname_detail',['user_verif' => 0,'tgl_verif' => date('Y-m-d H:i:s')]);

        $data = $this->db->get_where('stokopname_detail',['id' => $id])->row_array();

        $this->db->select('count(*) as jml');
        $this->db->from('stokopname_detail');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $this->db->where('user_verif !=',0);
        $jumlah = $this->db->get()->row_array();

        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',['item_verif' => $jumlah['jml']]);

        return $data;
    }
    public function batalkanrilisstok($id){
        $this->db->where('id',$id);
        $this->db->update('stokopname_detail',['user_rilis' => 0,'tgl_rilis' => date('Y-m-d H:i:s')]);

        $data = $this->db->get_where('stokopname_detail',['id' => $id])->row_array();

        $this->db->select('count(*) as jml');
        $this->db->from('stokopname_detail');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $this->db->where('user_rilis !=',0);
        $jumlah = $this->db->get()->row_array();

        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',['item_rilis' => $jumlah['jml']]);

        return $data;
    }
    public function batalkanrilismesin($id){
        $this->db->where('id',$id);
        $this->db->update('stokopname_onmachine',['user_rilis' => 0,'tgl_rilis' => date('Y-m-d H:i:s')]);

        $data = $this->db->get_where('stokopname_onmachine',['id' => $id])->row_array();

        $this->db->select('count(*) as jml');
        $this->db->from('stokopname_onmachine');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $this->db->where('user_rilis !=',0);
        $jumlah = $this->db->get()->row_array();

        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',['item_rilis' => $jumlah['jml']]);

        return $data;
    }
    public function getrekapsublok(){
        $this->db->select('status,COUNT(*) AS jml');
        $this->db->select('(SELECT COUNT(*) FROM tb_lokasi) AS jmsub');
        $this->db->from('stokopname');
        $this->db->where('periode',$this->session->userdata('periodeopname'));
        if($this->session->userdata('deptstok')!=''){
            $this->db->where('dept_id',$this->session->userdata('deptstok'));
        }
        $this->db->group_by('status');
        $data = $this->db->get();
        if($this->session->userdata('deptstok')!=''){
            $jmlsublok = $this->db->get_where('tb_lokasi',['dept_id' => $this->session->userdata('deptstok')])->num_rows();
        }else{
            $jmlsublok = $this->db->get('tb_lokasi')->num_rows();
        }

        $hasil = [];
        foreach($data->result_array() as $dt){
            $hasil[$dt['status']] = $dt['jml'];
        }
        $hasil['jmlsublok'] = $jmlsublok;
        return $hasil;

    }
    public function getmesinnetting($id=''){
        if($id==''){
            return $this->db->order_by('mach_no')->get('tb_msn_netting');
        }else{
            $this->db->select('stokopname.id');
            $this->db->from('stokopname');
            $this->db->join('tb_lokasi','tb_lokasi.kode_lokasi = stokopname.kode_lokasi','left');
            $this->db->where('periode',$this->session->userdata('periodeopname'));
            $this->db->where('trim(nama_lokasi)','ON MACHINE');
            $datastok = $this->db->get();
            $isi = array();
            foreach($datastok->result_array() as $dt){
                array_push($isi,$dt['id']);
            }

            $this->db->select('stokopname_onmachine.machno');
            $this->db->where_in('id_stokopname',$isi);
            $datamss = $this->db->get('stokopname_onmachine');
            $mss = array();
            foreach($datamss->result_array() as $ds){
                array_push($mss,$ds['machno']);
            }

            $this->db->where_not_in('mach_no',$mss);
            return $this->db->order_by('mach_no')->get('tb_msn_netting');
        }
    }
    public function getdatabobin(){
        return $this->db->order_by('kodebob')->get('tb_bobbin');
    }
    public function simpandataonmachine($data){
        $this->db->trans_start();
        //get Arroza 
        $arroza = $this->db->get_where('tb_msn_netting',['mach_no' => $data['machno']])->row_array();
        $data['aroz'] = $arroza['arroza'];
        $data['user_add'] = $this->session->userdata('id');
        $data['tgl_add'] = date('Y-m-d H:i:s');

        $this->db->insert('stokopname_onmachine',$data);

        $this->db->select('COUNT(*) as jml');
        $this->db->from('stokopname_onmachine');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $jmlitem = $this->db->get()->row_array();

        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',['item' => $jmlitem['jml']]);

        return $this->db->trans_complete();
    }
    public function updatedataonmachine($data){
        $this->db->trans_start();
        //get Arroza 
        $arroza = $this->db->get_where('tb_msn_netting',['mach_no' => $data['machno']])->row_array();
        $data['aroz'] = $arroza['arroza'];
        $data['user_add'] = $this->session->userdata('id');
        $data['tgl_add'] = date('Y-m-d H:i:s');

        $idx = $data['id'];
        $ids = $data['idstok'];
        unset($data['id']);
        unset($data['idstok']);
        $this->db->where('id',$idx);
        $this->db->update('stokopname_onmachine',$data);

        $this->db->select('COUNT(*) as jml');
        $this->db->from('stokopname_onmachine');
        $this->db->where('id_stokopname',$ids);
        $jmlitem = $this->db->get()->row_array();

        $this->db->where('id',$ids);
        $this->db->update('stokopname',['item' => $jmlitem['jml'],'tgl_edit' => date('Y-m-d H:i:s')]);

        return $this->db->trans_complete();
    }
    public function hapusentrionmesin($id){
        $this->db->trans_start();
        $data = $this->db->get_where('stokopname_onmachine',['id' => $id])->row_array();

        $this->db->where('id',$id);
        $this->db->delete('stokopname_onmachine');

        $this->db->select('count(*) as item');
        $this->db->from('stokopname_onmachine');
        $this->db->where('id_stokopname',$data['id_stokopname']);
        $hasil = $this->db->get()->row_array();

        $header = [
            'item' => $hasil['item'],
            'tgl_edit' => date('Y-m-d H:i:s')
        ];
        $this->db->where('id',$data['id_stokopname']);
        $this->db->update('stokopname',$header);
        return $this->db->trans_complete();
    }
    public function getdataonmesinbyid($id){
        $this->db->select('stokopname_onmachine.*,tb_msn_netting.mach_no,tb_po.spek,tb_po.color');
        $this->db->from('stokopname_onmachine');
        $this->db->join('tb_msn_netting','tb_msn_netting.mach_no = stokopname_onmachine.machno','left');
        $this->db->join('tb_po','tb_po.ind_po = concat(stokopname_onmachine.po,stokopname_onmachine.item,stokopname_onmachine.dis)','left');
        $this->db->where('stokopname_onmachine.id',$id);
        return $this->db->get()->row_array();
    }

    // End Func
    public function getdatadept()
    {
        $this->db->order_by('departemen');
        return $this->db->get_where('dept',['katedept_id <= ' => 3 ]);
    }
    public function getdatabyid($id)
    {
        return $this->db->get_where('stokopname_detail', ['id' => $id])->row_array();
    }
    
    public function gethakdept($arrdep)
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        $this->db->where_in('dept.dept_id', $arrdep);
        $this->db->order_by('departemen', 'ASC');
        return $this->db->get()->result_array();
    }
    public function gethakdept_bbl($arrdep)
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        $this->db->where('bbl', '1');
        $this->db->where_in('dept.dept_id', $arrdep);
        $this->db->order_by('departemen', 'ASC');
        return $this->db->get()->result_array();
    }
    public function gethakdeptout($arrdep)
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        $this->db->where_in('dept.dept_id', $arrdep);
        $this->db->where('dept.katedept_id !=', 4);
        $this->db->order_by('departemen', 'ASC');
        return $this->db->get()->result_array();
    }
    public function getdeptwip(){
        $dtp = ['SP','NT','RR','GP','FG','FN','AR','AN','NU','AM']; 
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        $this->db->where_in('dept.dept_id', $dtp);
        $this->db->order_by('departemen', 'ASC');
        return $this->db->get()->result_array();
    }

    public function simpandept($data)
    {
        return $this->db->insert('dept', $data);
    }
    // public function updatedept($data)
    // {
    //     $this->db->where('dept_id', $data['dept_id']);
    //     return $this->db->update('dept', $data);
    // }

    public function updatedata()
    {
        $data = $_POST;
        $data['pb'] = isset($data['pb']) ? '1' : '0';
        $data['bbl'] = isset($data['bbl']) ? '1' : '0';
        $data['adj'] = isset($data['adj']) ? '1' : '0';
        $data['amb'] = isset($data['amb']) ? '1' : '0';
        $data['akb'] = isset($data['akb']) ? '1' : '0';

        $pengeluaran = '';
        $penerimaan = '';

        $datdept = $this->dept_model->getdata();

        foreach ($datdept as $dept) {
            if (isset($data['pengeluaran' . $dept['dept_id']])) {
                $pengeluaran .= $dept['dept_id'];
                unset($data['pengeluaran' . $dept['dept_id']]);
            }
            if (isset($data['penerimaan' . $dept['dept_id']])) {
                $penerimaan .= $dept['dept_id'];
                unset($data['penerimaan' . $dept['dept_id']]);
            }
            if (isset($data['permintaan' . $dept['dept_id']])) {
                $permintaan .= $dept['dept_id'];
                unset($data['permintaan' . $dept['dept_id']]);
            }
        }

        $data['pengeluaran'] = $pengeluaran;
        $data['penerimaan'] = $penerimaan;
        // $data['permintaan'] = $permintaan;

        $this->db->where('dept_id', $data['dept_id']);
        $hasil = $this->db->update('dept', $data);

        if ($data['dept_id'] == $this->session->userdata('dept_id')) {
            $cek = $this->getdatabyid($data['dept_id'])->row_array();
            $this->session->set_userdata('pengeluaran', $cek['pengeluaran']);
            $this->session->set_userdata('penerimaan', $cek['penerimaan']);
            $this->session->set_userdata('permintaan', $cek['permintaan']);
        }

        return $hasil;
    }


    public function hapusdept($dept_id)
    {
        $this->db->where('dept_id', $dept_id);
        return $this->db->delete('dept');
    }
    public function gethakdept_pb($arrdep)
    {
        $this->db->select('dept.*, kategori_departemen.nama');
        $this->db->from('dept');
        $this->db->join('kategori_departemen', 'kategori_departemen.id = dept.katedept_id', 'left');
        $this->db->where_in('dept.dept_id', $arrdep);
        $this->db->where('dept.pb','1');
        $this->db->order_by('departemen', 'ASC');
        return $this->db->get()->result_array();
    }
    public function getdata_dept_bbl($mode=0)
    {
        if($mode==1){
            $this->db->select('dept_id');
        }else{
            $this->db->select('*');
        }
        $this->db->from('dept');
        $this->db->where('bbl', '1');
        return $this->db->order_by('departemen','ASC')->get()->result_array();
    }
    public function getdata_dept_pb()
    {
        $this->db->select('*');
        $this->db->from('dept');
        $this->db->where('pb', '1');
        return $this->db->order_by('departemen','ASC')->get()->result_array();
    }
    public function getdata_dept_adj($dept='')
    {
        $this->db->select('*');
        $this->db->from('dept');
        $this->db->where('adj', '1');
        if($dept != ''){
            $this->db->where_in('dept_id',$dept);
        }
        return $this->db->order_by('departemen','ASC')->get()->result_array();
    }
    public function getdeptkirim(){
        return $this->db->get_where('dept',['akb'=>1]);
    }
    public function getdeptmasuk(){
        return $this->db->get_where('dept',['amb'=>1]);
    }
    public function getdashboard(){
        $periode = $this->session->userdata('periodeopname')=='' ? '1977-12-12' : $this->session->userdata('periodeopname');
        $this->db->select('dept.*');
        $this->db->select('(select count(*) from tb_lokasi where dept_id = dept.dept_id) as jml');
        $this->db->select('(select count(*) from stokopname where dept_id = dept.dept_id and periode = "'.$periode.'") as jmlinput');
        $this->db->select('(select count(*) from stokopname where dept_id = dept.dept_id and periode = "'.$periode.'" and status >= 1) as jmlselesai');
        $this->db->select('(select count(*) from stokopname where dept_id = dept.dept_id and periode = "'.$periode.'" and status > 1) as jmlverifikasi');
        $this->db->select('(SELECT COUNT(*) FROM stokopname_detail LEFT JOIN stokopname ON stokopname.id = stokopname_detail.id_stokopname where stokopname.dept_id = dept.dept_id and periode = "'.$periode.'") AS jmlrek');
        $this->db->select('(SELECT SUM(stokopname_detail.kgs) FROM stokopname_detail LEFT JOIN stokopname ON stokopname.id = stokopname_detail.id_stokopname where stokopname.dept_id = dept.dept_id and periode = "'.$periode.'") AS jmlkgs');
        $this->db->select('(SELECT COUNT(*) FROM stokopname_detail LEFT JOIN stokopname ON stokopname.id = stokopname_detail.id_stokopname where stokopname.dept_id = dept.dept_id and periode = "'.$periode.'" AND stokopname.status > 1) AS jmlverif');
        $this->db->select('(SELECT SUM(stokopname_detail.kgs) FROM stokopname_detail LEFT JOIN stokopname ON stokopname.id = stokopname_detail.id_stokopname where stokopname.dept_id = dept.dept_id and periode = "'.$periode.'" AND stokopname.status > 1) AS jmlverifkgs');
        $this->db->select('(SELECT COUNT(*) FROM stokopname_detail LEFT JOIN stokopname ON stokopname.id = stokopname_detail.id_stokopname where stokopname.dept_id = dept.dept_id and periode = "'.$periode.'" AND stokopname.status > 2) AS jmlrilis');
        $this->db->select('(SELECT SUM(stokopname_detail.kgs) FROM stokopname_detail LEFT JOIN stokopname ON stokopname.id = stokopname_detail.id_stokopname where stokopname.dept_id = dept.dept_id and periode = "'.$periode.'" AND stokopname.status > 2) AS jmlriliskgs');
        $this->db->from('dept');
        $this->db->where('dept.stokopname','1');
        $this->db->order_by('dept.departemen');
        return $this->db->get();
    }
}
