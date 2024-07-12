<?php 
class Taskmodel extends CI_Model{
    public function getdata($mode){
        $this->db->where('id_perusahaan',IDPERUSAHAAN);
        $this->db->where('kode_dok',$mode);
        if($mode=='pb'){
            $this->db->where('data_ok',1);
            $this->db->where('ok_valid',0);
            $this->db->where_in('dept_id',arrdep($this->session->userdata('hakdepartemen')));
        }else if($mode=='bbl'){
            // $this->db->where('data_ok',3);
            switch ($this->session->userdata('ttd')) {
                case 1:
                    $this->db->where('data_ok',1);
                    $this->db->where('ok_pp',0);
                    $this->db->where('ok_valid',0);
                    $this->db->where('ok_tuju',0);
                    $this->db->where('ok_pc',0);
                    $this->db->where('bbl_pp',1);
                    // $this->db->where_in('dept_bbl',arrdep($this->session->userdata('hakdepartemen')));
                    break;
                case 2:
                    $this->db->where('data_ok',1);
                    $this->db->where('ok_pp',1);
                    $this->db->where('ok_valid',0);
                    $this->db->where('ok_tuju',0);
                    $this->db->where('ok_pc',0);
                    // $this->db->where('bbl_pp',1);
                    $this->db->where_in('dept_bbl',arrdep($this->session->userdata('hakdepartemen')));
                    break;
                case 3:
                    $this->db->where('data_ok',1);
                    $this->db->where('ok_pp',1);
                    $this->db->where('ok_valid',1);
                    $this->db->where('ok_tuju',0);
                    $this->db->where('ok_pc',0);
                    // $this->db->where('bbl_pp',1);
                    $this->db->where_in('dept_bbl',arrdep($this->session->userdata('hakdepartemen')));
                    break;
                case 4:
                    $this->db->where('data_ok',1);
                    $this->db->where('ok_pp',1);
                    $this->db->where('ok_valid',1);
                    $this->db->where('ok_tuju',1);
                    $this->db->where('ok_pc',0);
                    // $this->db->where('bbl_pp',1);
                    $this->db->where_in('dept_bbl',arrdep($this->session->userdata('hakdepartemen')));
                    break;
                default:
                    $this->db->where('data_ok',3);
                    break;
            }
        }else{
            $this->db->where('data_ok',3);
        }
        $query = $this->db->get('tb_header');
        return $query;
    }
    public function cekfield($id,$kolom,$nilai){
        $this->db->where('id',$id);
        $this->db->where($kolom,$nilai);
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }
    public function validasibbl($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }
}