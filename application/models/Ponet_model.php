<?php
class Ponet_model extends CI_Model
{
    public function getdata($idpo=''){
        $this->db->select('tb_po.*,customer.nama_customer,tb_klppo.engklp,tb_klppo.hs,nettype.name_nettype,kategori.nama_kategori');
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
}
