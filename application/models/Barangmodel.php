<?php
class Barangmodel extends CI_Model
{
    var $column_search = array('nama_barang', 'barang.kode', 'nama_kategori');
    var $column_order = array(null, 'nama_barang', 'barang.kode', 'nama_kategori');
    var $order = array('nama_barang' => 'asc');
    var $table = 'barang';
    public function getdatajson()
    {
        $query = $this->db->query("Select barang.*,satuan.namasatuan,kategori.nama_kategori,
        (select count(*) from bom_barang where id_barang = barang.id) as jmbom
        from barang
        left join kategori on kategori.kategori_id = barang.id_kategori
        left join satuan on satuan.id = barang.id_satuan");
        return $query;
    }
    public function getdata($filter_kategori, $filter_inv, $filter_act)
    {
        $this->db->select('barang.*,barang.kode as kodex,satuan.namasatuan,satuan.kodesatuan,kategori.nama_kategori,(select count(*) from bom_barang where id_barang = barang.id) as jmbom', FALSE);
        $this->db->from($this->table);
        $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');

        if ($filter_kategori && $filter_kategori != 'all') {
            $this->db->where('kategori.id', $filter_kategori);
        }
        if ($filter_inv && $filter_inv != 'all') {
            $isi = $filter_inv == 'x' ? 0 : 1;
            $this->db->where('barang.noinv', $isi);
        }
        if ($filter_act && $filter_act != 'all') {
            $isi = $filter_act == 'x' ? 0 : 1;
            $this->db->where('barang.act', $isi);
        }
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function getdatabarangbaru(){
        $query = "SELECT barang.*,kategori.nama_kategori,satuan.kodesatuan,(select count(*) from bom_barang where id_barang = barang.id) as jmbom 
        FROM barang 
        LEFT JOIN kategori ON kategori.kategori_id = barang.id_kategori 
        LEFT JOIN satuan ON satuan.id = barang.id_satuan";
        // $cari = array('barang.kode','nama_barang','nama_kategori');
        $cari = array('nama_barang');
        $where = null;
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
            'data'=>$data
        );
        return json_encode($callback); // Convert array $callback ke json
    }


    public function get_datatables($filter_kategori, $filter_inv, $filter_act)
    {
        $this->getdata($filter_kategori, $filter_inv, $filter_act);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    public function count_filtered($filter_kategori, $filter_inv, $filter_act)
    {
        $this->getdata($filter_kategori, $filter_inv, $filter_act);
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->db->from('barang');
        return $this->db->count_all_results();
    }

    public function getdatabyid($id)
    {
        $this->db->select('barang.*, (SELECT SUM(persen) FROM bom_barang WHERE id_barang = barang.id) AS persenbom');
        $this->db->from('barang');
        $this->db->where('id', $id);
        return $this->db->get();
    }


    public function simpanbarang($data)
    {
        $query = $this->db->insert('barang', $data);
        return $query;
    }
    public function updatebarang($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('barang', $data);
        $this->helpermodel->isilog($this->db->last_query());

        $this->db->select('barang.*,kategori.nama_kategori,satuan.namasatuan,satuan.kodesatuan');
        $this->db->from('barang');
        $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $this->db->where('barang.id', $data['id']);
        $query2 = $this->db->get();
        return $query2;
    }
    public function hapusbarang($id)
    {
        $querye = $this->db->query("Delete from bom_barang where id_barang =" . $id);
        $query = $this->db->query("Delete from barang where id =" . $id);
        return $query;
    }
    public function getdatabom($id)
    {
        $query = $this->db->query("Select bom_barang.*,barang.nama_barang, barang.kode
        from bom_barang
        left join barang on barang.id = bom_barang.id_barang_bom
        where bom_barang.id_barang = " . $id);
        return $query;
    }
    public function getdatabombyid($id)
    {
        $query = $this->db->query("Select * from bom_barang where id = " . $id);
        return $query;
    }
    public function simpanbombarang($data)
    {
        $query = $this->db->insert('bom_barang', $data);
        return $query;
    }
    public function updatebombarang($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('bom_barang', $data);
        return $query;
    }
    public function hapusbombarang($id)
    {
        $query = $this->db->query("Delete from bom_barang where id =" . $id);
        return $query;
    }
    public function updatestock($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('barang', ['safety_stock' => $data['safety_stock']]);
        $this->helpermodel->isilog($this->db->last_query());

        $this->db->select('barang.*,kategori.nama_kategori,satuan.namasatuan');
        $this->db->from('barang');
        $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');
        $this->db->where('barang.id', $data['id']);
        $query2 = $this->db->get();
        return $query2;
    }

    public function getFilter()
    {
        $this->db->distinct();
        $this->db->select('kategori.nama_kategori, kategori.id');
        $this->db->from('kategori');
        $this->db->join('barang', 'barang.id_kategori = kategori.id', 'left');
        $query = $this->db->get()->result_array();

        return $query;
    }

    public function getdata_export($filter_kategori, $filter_inv, $filter_act)
    {
        $this->db->select('barang.*,satuan.namasatuan,satuan.kodesatuan,kategori.nama_kategori,(select count(*) from bom_barang where id_barang = barang.id) as jmbom', FALSE);
        $this->db->from($this->table);
        $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
        $this->db->join('satuan', 'satuan.id = barang.id_satuan', 'left');

        if ($filter_kategori && $filter_kategori != 'all') {
            $this->db->where('kategori.id', $filter_kategori);
        }
        if ($filter_inv && $filter_inv != 'all') {
            $isi = $filter_inv == 'x' ? 0 : 1;
            $this->db->where('barang.noinv', $isi);
        }
        if ($filter_act && $filter_act != 'all') {
            $isi = $filter_act == 'x' ? 0 : 1;
            $this->db->where('barang.act', $isi);
        }
        $query = $this->db->get();
        return $query->result_array();
    }


    public function updatefoto_baru()
    {
        $data = $_POST;
        $temp = $this->barangmodel->getdatabyid($data['id'])->row_array(); // Memanggil barangmodel
        $fotodulu = FCPATH . 'assets/image/dokbar/' . $temp['filefoto'];
        $id = $data['id'];
        $data['filefoto'] = $this->uploadLogo(); // Memanggil method uploadLogo()

        if ($data['filefoto'] != NULL) {
            if ($data['filefoto'] == 'kosong') {
                $data['filefoto'] = NULL;
            } else {
                if (file_exists($fotodulu)) {
                    unlink($fotodulu); // Hapus file lama jika ada
                }
            }
            $query = $this->db->query("UPDATE barang SET filefoto = '" . $data['filefoto'] . "' WHERE id = '" . $id . "' ");
            if ($query) {
                $this->session->set_userdata('foto', $data['filefoto']);
                $this->session->set_flashdata('simpanfoto', 'berhasil');
            }
        } else {
            $this->session->set_flashdata('ketlain', 'Error Upload Foto');
        }

        redirect(base_url() . 'barang/editdata/' . $data['id']);
    }


    public function uploadLogo()
    {

        $this->load->library('upload');
        $this->uploadConfig = array(
            'upload_path' => FCPATH . 'assets/image/dokbar/',
            'allowed_types' => 'gif|jpg|jpeg|png',
            'max_size' => max_upload() * 1024,
        );
        // Adakah berkas yang disertakan?
        $adaBerkas = $_FILES['file']['name'];
        if (empty($adaBerkas)) {
            return 'kosong';
        }
        $uploadData = NULL;
        $this->upload->initialize($this->uploadConfig);
        if ($this->upload->do_upload('file')) {
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
            $this->session->set_flashdata('msg', $tidakupload . ' ' . $ext . ' ukuran ' . round($ukuran, 2) . ' MB');
        }
        return (!empty($uploadData)) ? $uploadData['file_name'] : NULL;
    }
}
