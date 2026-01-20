<?php
class Opname_model extends CI_Model
{
    public function getdata()
    {
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
            $this->db->where('dept_id',$this->session->userdata('currdeptopname'));
        }
        // $this->db->group_by('po,item,dis,id_barang,insno,nobontr,stok,exnet,nobale');

        $query = $this->db->get_compiled_select();

        $kolom = "Select *,sum(pcs) over() as totalpcs,sum(kgs) over() as totalkgs from (".$query.") r1";
        // $hasil = $this->db->query($kolom);
        return $kolom;
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
}
