<?php
class Bcmasukmodel extends CI_Model
{
    public function getdata(){
        $tglawal = $this->session->userdata('tglawal');
        $tglakhir = $this->session->userdata('tglakhir');
        $jnsbc = $this->session->userdata('jnsbc');

        $this->db->select('tb_header.*,supplier.*,sum(tb_detail.pcs) as pcs,sum(tb_detail.kgs) as kgs,tb_header.id as idx');
        $this->db->join('supplier','supplier.id = tb_header.id_pemasok','left');
        $this->db->join('tb_detail','tb_detail.id_header = tb_header.id','left');
        $this->db->where("tgl_bc between '".tglmysql($tglawal)."' AND '".tglmysql($tglakhir)."' ");
        $this->db->where('trim(nomor_bc) !=','');
        if($jnsbc!='Y'){
            $this->db->where("jns_bc",$jnsbc);
        }
        $this->db->where('data_ok',1);
        $this->db->where('ok_tuju',1);
        $this->db->where('ok_valid',1);
        $this->db->group_by('nomor_bc');
        return $this->db->get('tb_header');
    }
}
