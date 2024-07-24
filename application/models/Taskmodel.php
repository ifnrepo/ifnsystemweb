<?php
class Taskmodel extends CI_Model
{
    public function getdata($mode)
    {
        $this->db->where('id_perusahaan', IDPERUSAHAAN);
        $this->db->where('kode_dok', $mode);
        if ($mode == 'pb') {
            if ($this->session->userdata('level_user') >= 2) {
                $this->db->where('data_ok', 1);
                $this->db->where('ok_valid', 0);
                if(count($this->session->userdata('hak_ttd_pb')) > 0){
                    $this->db->where_in('dept_id', $this->session->userdata('hak_ttd_pb'));
                }else{
                    $this->db->where('data_ok',99);
                }
            } else {
                $this->db->where('data_ok', 99);
            }
        } else if ($mode == 'bbl') {
            // $this->db->where('data_ok',3);
            $ttdppic = 0;
            $masuk = $this->session->userdata('ttd'); 
            if(strtoupper($this->session->userdata('jabatan'))=='MANAGER' && in_array('PP',$this->session->userdata('arrdep'))){
                $ttdppic = 1;
                // $masuk = 1;
            }
            switch ($masuk) {
                case 1:
                    $this->db->where('data_ok', 1);
                    $this->db->where('ok_pp', 0);
                    $this->db->where('ok_valid', 0);
                    $this->db->where('ok_tuju', 0);
                    $this->db->where('ok_pc', 0);
                    $this->db->where('bbl_pp', 1);
                    // $this->db->where_in('dept_bbl',arrdep($this->session->userdata('hakdepartemen')));
                    break;
                case 2:
                    $this->db->where('data_ok', 1);
                    if($ttdppic==0){
                        $this->db->where('ok_pp', 1);
                    }else{
                        $this->db->where('ok_pp !=', 2);
                    }
                    $this->db->where('ok_valid', 0);
                    $this->db->where('ok_tuju', 0);
                    $this->db->where('ok_pc', 0);
                    // $this->db->where('bbl_pp',1);
                    $this->db->where_in('dept_bbl', arrdep($this->session->userdata('hakdepartemen')));
                    break;
                case 3:
                    $this->db->where('data_ok', 1);
                    $this->db->where('ok_pp', 1);
                    $this->db->where('ok_valid', 1);
                    $this->db->where('ok_tuju', 0);
                    $this->db->where('ok_pc', 0);
                    // $this->db->where('bbl_pp',1);
                    $this->db->where_in('dept_bbl', arrdep($this->session->userdata('hakdepartemen')));
                    break;
                case 4:
                    $this->db->where('data_ok', 1);
                    $this->db->where('ok_pp', 1);
                    $this->db->where('ok_valid', 1);
                    $this->db->where('ok_tuju', 1);
                    $this->db->where('ok_pc', 0);
                    // $this->db->where('bbl_pp',1);
                    $this->db->where_in('dept_bbl', arrdep($this->session->userdata('hakdepartemen')));
                    break;
                default:
                    $this->db->where('data_ok', 99);
                    break;
            }
        } else if($mode == 'po') {
            $this->db->where('data_ok', 1);
            $this->db->where('ok_valid', 0);
        }else { 
            $this->db->where('data_ok', 99);
        }
        $query = $this->db->get('tb_header');
        return $query;
    }
    public function cekfield($id, $kolom, $nilai)
    {
        $this->db->where('id', $id);
        $this->db->where($kolom, $nilai);
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
