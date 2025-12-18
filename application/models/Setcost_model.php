<?php
class Setcost_model extends CI_Model
{

    public function getdata()
    {
        $this->db->select('ref_jobcostdep.*,kategori.nama_kategori,dept.departemen');
        $this->db->from('ref_jobcostdep');
        $this->db->join('kategori','kategori.kategori_id = ref_jobcostdep.id_kategori','left');
        $this->db->join('dept','dept.dept_id = ref_jobcostdep.dept_id','left');
        $this->db->where('ref_jobcostdep.dept_id',$this->session->userdata('currdeptcost'));
        if($this->session->userdata('currkategcost')!=''){
            $this->db->where('ref_jobcostdep.id_kategori',$this->session->userdata('currkategcost'));
        }
        $this->db->order_by('dept_id');
        $this->db->order_by('kategori.nama_kategori');
        return $this->db->get();
    }
    public function getdatadept(){
        $this->db->where('katedept_id <= ',3);
        $this->db->order_by('departemen');
        return $this->db->get('dept');
    }
    public function getdatakateg(){
        $this->db->where('jns < ',3);
        // $this->db->order_by('departemen');
        $this->db->order_by('nama_kategori');
        return $this->db->get('kategori');
    }
    public function getdatasublok(){
        // $this->db->where('katedept_id <= ',3);
        // $this->db->order_by('departemen');
        return $this->db->get('tb_sublok');
    }
    public function getdatabyid($id)
    {
        $this->db->select('ref_jobcostdep.*,kategori.nama_kategori,dept.departemen');
        $this->db->from('ref_jobcostdep');
        $this->db->join('kategori','kategori.kategori_id = ref_jobcostdep.id_kategori','left');
        $this->db->join('dept','dept.dept_id = ref_jobcostdep.dept_id','left');
        $this->db->where('ref_jobcostdep.id', $id);
        $query = $this->db->get();
        return $query->row_array();
    }
    public function simpandata($data)
    {
        $cekdata = $this->db->get_where('ref_jobcostdep',['dept_id' => $data['dept_id'],'id_kategori' => $data['id_kategori'],'sublok' => $data['sublok'],'asal' => $data['asal']]);
        if(count($cekdata->result()) > 0){
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', 'Data yang anda masukan sudah ada dalam tabel, [Proses simpan BATAL]');
            return 1;
        }else{
            return $this->db->insert('ref_jobcostdep', $data);
        }
    }
    public function updatedata($data)
    {
        $cekdata = $this->db->get_where('ref_jobcostdep',['dept_id' => $data['dept_id'],'id_kategori' => $data['id_kategori'],'sublok' => $data['sublok'],'asal' => $data['asal'],'id !=' => $data['id']]);
        if(count($cekdata->result()) > 0){
            $this->session->set_flashdata('errorsimpan', 1);
            $this->session->set_flashdata('pesanerror', 'Data yang anda masukan sudah ada dalam tabel, [Proses update BATAL]');
            return 1;
        }else{
            $this->db->where('id', $data['id']);
            $query = $this->db->update('ref_jobcostdep', $data);
            return $query;
        }
    }
    public function hapusdata($id)
    {
        $query = $this->db->query("Delete from ref_jobcostdep where id =" . $id);
        return $query;
    }
}
