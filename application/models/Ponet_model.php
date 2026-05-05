<?php
class Ponet_model extends CI_Model
{
    public function getdata($idpo=''){
        $this->db->select('tb_po.*,customer.port,customer.nama_customer,tb_klppo.engklp,tb_klppo.hs,nettype.name_nettype,kategori.nama_kategori');
        $this->db->from('tb_po');
        $this->db->join('customer','customer.id = tb_po.id_buyer','left');
        $this->db->join('tb_klppo','tb_klppo.id = tb_po.klppo','left');
        $this->db->join('nettype','nettype.id = tb_po.id_nettype','left');
        $this->db->join('kategori','kategori.kategori_id = tb_po.id_kategori','left');
        if($idpo!=''){
            $this->db->where('tb_po.id',$idpo);
        }
        $this->db->order_by('tb_po.id desc');
        $this->db->limit(1);
        return $this->db->get()->row_array();
    }
    public function getmaxminidpo(){
        $this->db->select('max(tb_po.id) as maxid,min(tb_po.id) as minid');
        $this->db->from('tb_po');
        return $this->db->get()->row_array();
    }
    public function getfutoito($id){
        return $this->db->get_where('tb_futoito',['id_po' => $id]);
    }
    public function getsidemark($id){
        return $this->db->get_where('tb_sidemark',['id_po' => $id]);
    }
    public function getshipmark($id){
        return $this->db->get_where('tb_shipmark',['id_po' => $id]);
    }
    public function simpannotes($data){
        $id = $data['id'];
        unset($data['id']);
        $this->db->where('id',$id);
        return $this->db->update('tb_po',$data);
    }
    public function prevrec($id){
        $this->db->select('tb_po.id as idpo');
        $this->db->from('tb_po');
        $this->db->where('tb_po.id < ',$id);
        $this->db->order_by('tb_po.id desc');
        $this->db->limit(1);
        return $this->db->get()->row_array();
    }
    public function nextrec($id){
        $this->db->select('tb_po.id as idpo');
        $this->db->from('tb_po');
        $this->db->where('tb_po.id > ',$id);
        $this->db->order_by('tb_po.id');
        $this->db->limit(1);
        return $this->db->get()->row_array();
    }
    public function currentrec($id){
        $this->db->select('tb_po.id as idpo');
        $this->db->from('tb_po');
        $this->db->where('tb_po.id',$id);
        $this->db->order_by('tb_po.id desc');
        $this->db->limit(1);
        return $this->db->get()->row_array();
    }
    public function caridatapo($data){
        $this->db->select('tb_po.*,customer.nama_customer');
        $this->db->from('tb_po');
        $this->db->join('customer','customer.id = tb_po.id_buyer','left');
        $this->db->like('trim(po)',$data['po']);
        if($data['item']!=''){
            $this->db->like('trim(item)',$data['item']);
        }
        $this->db->order_by("po,item");
        return $this->db->get();
    }
    public function cariData($po, $buy, $checked=null)
    {
        $this->db->select('tb_po.id as id_po, tb_po.po_id, tb_po.po, tb_po.item, tb_po.dis, tb_po.id_buyer, 
        tb_po.lim, tb_po.outstand, tb_po.st_piece, tb_po.weight, customer.nama_customer, nettype.name_nettype');
        $this->db->from('tb_po');
        $this->db->join('customer', 'customer.id = tb_po.id_buyer', 'left');
        $this->db->join('nettype', 'nettype.id = tb_po.id_nettype', 'left');
        $this->db->order_by('tb_po.lim', 'DESC');

        if ($buy == '0') {
            $this->db->like('tb_po.po', $po);
        } elseif ($buy == '1') {
            $this->db->like('customer.nama_customer', $po);
        } elseif ($buy == '2') {
            $this->db->where('tb_po.stat_po', 2);
            $this->db->like('tb_po.ord', $po);
        }

        if ($checked=="1") {
            $this->db->where('tb_po.stat_po =', 1);
            $this->db->where('tb_po.outstand >', 0);
            $this->db->where('YEAR(tb_po.lim) >=', date('Y'));
        }

        $result = $this->db->get()->result_array();

        if ($result) {
            return $result;
        } else {
            echo '<script>alert("Mohon Maaf Data PO/BUYER Tidak Tersedia !");</script>';
            return null;
        }
    }

    public function GetDataByid($id)
    {
        $this->db->select('tb_po.*, customer.nama_customer, nettype.name_nettype');
        $this->db->from('tb_po');
        $this->db->join('customer', 'customer.id = tb_po.id_buyer', 'left');
        $this->db->join('nettype', 'nettype.id = tb_po.id_nettype', 'left');
        $this->db->where('tb_po.id', $id);
        return $this->db->get()->row_array();
    }


    public function GetDataByPo_id($po)
    {
        $this->db->select('tb_po.*, tb_netinstr.po_id, tb_netinstr.po, tb_netinstr.insno, tb_netinstr.date,tb_netinstr.dateplan,
        tb_netinstr.limitx, tb_netinstr.machno, tb_netinstr.specificx, tb_netinstr.ways, tb_netinstr.color, tb_netinstr.jenis');
        $this->db->from('tb_po');
        $this->db->join('tb_netinstr', 'tb_netinstr.po_id = tb_po.po_id', 'left');
        $this->db->where('tb_netinstr.po_id', $po);
        return $this->db->get()->row_array();
    }

    public function loadnetting($id){
        $datpo = $this->db->get_where('tb_po',['id' => $id])->row_array();
        $this->db->select('*,SUM(tb_detail.pcs) AS pcstotal,SUM(tb_detail.kgs) AS kgstotal,"'.$datpo['piece'].'" as jmlpiece');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_id','NT');
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_detail.po',$datpo['po']);
        $this->db->where('tb_detail.item',$datpo['item']);
        $this->db->where('tb_detail.dis',$datpo['dis']);
        $this->db->group_by('tb_detail.insno');
        $this->db->order_by('tb_detail.insno');
        return $this->db->get();
    }
    public function loadsenshoku($id){
        $datpo = $this->db->get_where('tb_po',['id' => $id])->row_array();
        $this->db->select('*,SUM(tb_detail.pcs) AS pcstotal,SUM(tb_detail.kgs) AS kgstotal,"'.$datpo['piece'].'" as jmlpiece');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_id','FN');
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('substring(nomor_dok,9,2)','SN');
        $this->db->where('tb_detail.po',$datpo['po']);
        $this->db->where('tb_detail.item',$datpo['item']);
        $this->db->where('tb_detail.dis',$datpo['dis']);
        $this->db->group_by('tb_detail.insno');
        $this->db->order_by('tb_detail.insno');
        return $this->db->get();
    }
    public function loadgaichu($id){
        $datpo = $this->db->get_where('tb_po',['id' => $id])->row_array();
        $this->db->select('*,SUM(tb_detail.pcs) AS pcstotal,SUM(tb_detail.kgs) AS kgstotal,"'.$datpo['piece'].'" as jmlpiece');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_id','FG');
        $this->db->where('tb_header.dept_tuju','FN');
        $this->db->where('tb_header.ketprc !=','HS ,');
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_detail.po',$datpo['po']);
        $this->db->where('tb_detail.item',$datpo['item']);
        $this->db->where('tb_detail.dis',$datpo['dis']);
        $this->db->group_by('tb_detail.insno');
        $this->db->order_by('tb_detail.insno');
        return $this->db->get();
    }
    public function loadfinishing($id){
        $datpo = $this->db->get_where('tb_po',['id' => $id])->row_array();
        $this->db->select('*,SUM(tb_detail.pcs) AS pcstotal,SUM(tb_detail.kgs) AS kgstotal,cast(tb_detail.nobale as signed) as xnobale,"'.$datpo['piece'].'" as jmlpiece');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where('tb_header.dept_id','FN');
        $this->db->where('tb_header.dept_tuju','GF'); 
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_detail.po',$datpo['po']);
        $this->db->where('tb_detail.item',$datpo['item']);
        $this->db->where('tb_detail.dis',$datpo['dis']);
        $this->db->group_by('tb_detail.nobale');
        $this->db->order_by('cast(tb_detail.nobale as signed)');
        return $this->db->get();
    }
    public function loadfinishedgoods($id){
        $datpo = $this->db->get_where('tb_po',['id' => $id])->row_array();
        $this->db->select('*,SUM(tb_detailgen.pcs) OVER() AS pcstotal,SUM(tb_detailgen.kgs) OVER() AS kgstotal,cast(tb_detailgen.nobale as signed) as xnobale,"'.$datpo['piece'].'" as jmlpiece');
        $this->db->from('tb_detailgen');
        $this->db->join('tb_header','tb_header.id = tb_detailgen.id_header','left');
        $this->db->where('tb_header.dept_id','GF');
        $this->db->where('tb_header.dept_tuju','CU'); 
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_detailgen.po',$datpo['po']);
        $this->db->where('tb_detailgen.item',$datpo['item']);
        $this->db->where('tb_detailgen.dis',$datpo['dis']);
        $this->db->where('tb_detailgen.stok',0);
        $this->db->group_by('tb_detailgen.nobale');
        $this->db->order_by('cast(tb_detailgen.nobale as signed)');
        return $this->db->get();
    }
    public function loadship($id){
        $datpo = $this->db->get_where('tb_po',['id' => $id])->row_array();
        $this->db->select('*,SUM(tb_detailgen.pcs) AS pcstotal,SUM(tb_detailgen.kgs) AS kgstotal,"'.$datpo['piece'].'" as jmlpiece');
        $this->db->from('tb_detailgen');
        $this->db->join('tb_header','tb_header.id = tb_detailgen.id_header','left');
        $this->db->join('ref_pelabuhan','ref_pelabuhan.kode_pelabuhan = tb_header.pelabuhan_bongkar','left');
        $this->db->join('customer','customer.id = tb_header.id_buyer','left');
        $this->db->join('ref_negara','ref_negara.kode_negara = customer.kode_negara','left');
        $this->db->where('tb_header.dept_id','GF');
        $this->db->where('tb_header.dept_tuju','CU'); 
        $this->db->where('tb_header.data_ok',1);
        $this->db->where('tb_header.ok_valid',1);
        $this->db->where('tb_detailgen.po',$datpo['po']);
        $this->db->where('tb_detailgen.item',$datpo['item']);
        $this->db->where('tb_detailgen.dis',$datpo['dis']);
        $this->db->where('tb_detailgen.stok',0);
        $this->db->group_by('tb_header.nomor_dok');
        $this->db->order_by('tb_header.tgl');
        return $this->db->get();
    }
    public function updatedok(){
        $data = $_POST;
        $temp = $this->getdatabyid($data['idpo']);
        $id = $data['idpo'];
        $this->db->query("update tb_po set ppic_notes = '" . $data['ppic_notes'] . "' where id  = '" . $id . "' ");
        $hapus_file = $this->input->post('item1') ?? 0;
        if($hapus_file){
            $filelama = json_decode($temp['file_name']);
            foreach($filelama as $fl => $flama){
                $fotodulu = FCPATH . 'assets/file/dokpo/' . $flama; //base_url().$gambar.'.png';
                if (file_exists($fotodulu)) {
                    unlink($fotodulu);
                }
            }
            $query = $this->db->query("update tb_po set file_name = '' where id = '" . $id . "' ");
        }else{
            $data['filepdf'] = $this->uploaddok();
            if (count($data['filepdf']) > 0) {
                if ($data['filepdf'] == 'kosong') {
                    $data['filepdf'] = NULL;
                }
                unset($data['logo']);
                if (count($data['filepdf']) > 0) {
                    if(trim($temp['file_name'])!=''){
                        $filelama = json_decode($temp['file_name']);
                        foreach($filelama as $fl => $flama){
                            if(in_array($flama,(array) $data['filepdf'])){
                                $fotodulu = FCPATH . 'assets/file/dokpo/' . $flama; //base_url().$gambar.'.png';
                                if (file_exists($fotodulu)) {
                                    unlink($fotodulu);
                                }
                            }else{
                                 array_push($data['filepdf'],$flama);
                            }
                        }
                    }
                    $query = $this->db->query("update tb_po set file_name = '" . json_encode($data['filepdf']) . "' where id = '" . $id . "' ");
                    if ($query) {
                        $this->session->set_flashdata('pesanerror', 'Data Berhasil Diupdate');
                        $this->session->set_flashdata('errorsimpan', 1);
                    }
                }
            } else {
                // $this->session->set_flashdata('pesanerror', 'Error Upload Foto Profile ' . $temp['id'] . ' ');
                $this->session->set_flashdata('errorsimpan', 1);
            }
        }
        $url = base_url() . 'ponet/view/' . $id;
        redirect($url);
    }
    public function uploaddok(){
        $this->load->library('upload');
        $this->uploadConfig = array(
            'upload_path' => LOK_UPLOAD_DOK_PO,
            'allowed_types' => 'jpg|png|jpeg|gif|mp4|pdf|doc|docx|xls|xlsx|zip',
            'max_size' => 20240
        );
        $file_names = [];
        // Adakah berkas yang disertakan?
        // $adaBerkas = $_FILES['dok']['name'];
        $adaBerkas = $_FILES['dok_file'];
        if (empty($adaBerkas)) {
            return NULL;
        }
        for ($i = 0; $i < count($adaBerkas['name']); $i++) {
            if (!empty($adaBerkas['name'][$i])) {
                $uploadData = [];

                $_FILES['dok_file']['name'] = $adaBerkas['name'][$i];
                $_FILES['dok_file']['type'] = $adaBerkas['type'][$i];
                $_FILES['dok_file']['tmp_name'] = $adaBerkas['tmp_name'][$i];
                $_FILES['dok_file']['error'] = $adaBerkas['error'][$i];
                $_FILES['dok_file']['size'] = $adaBerkas['size'][$i];

                $this->upload->initialize($this->uploadConfig);
                if ($this->upload->do_upload('dok_file')) {
                    $uploadData = $this->upload->data();
                    $namaFileUnik = strtolower($uploadData['file_name']);
                    $file_names[] = $uploadData['file_name'];
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
            }
        }
        return (count($file_names) > 0) ? $file_names : [];
    }
}
