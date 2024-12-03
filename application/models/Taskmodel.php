<?php
class Taskmodel extends CI_Model
{
    public function getdatabaru($mode){
        $lvluser = datauser($this->session->userdata('id'),'id_level_user');
        $hakttdpb = arrdep(datauser($this->session->userdata('id'),'hakdepartemen'));
        $this->db->where('id_perusahaan', IDPERUSAHAAN);
        $this->db->where('kode_dok', $mode);
        if($mode == 'adj'){
            $this->db->where('data_ok', 1);
            $this->db->where('ok_valid', 0); 
        }
        if($mode == 'po'){
            $this->db->where('data_ok', 1);
            $this->db->where('ok_valid', 0);
        }
        if($mode == 'pb'){
            if($lvluser >= 2){
                $this->db->where('data_ok', 1);
                $this->db->where('ok_valid', 0);
                if(count($hakttdpb) > 0){
                    $this->db->where_in('dept_id', $hakttdpb);
                }else{
                    $this->db->where('data_ok', 99);
                }
            }else{
                $this->db->where('data_ok', 99);
            }
        }
        if($mode == 'bbl'){
            $cekbl = datauser($this->session->userdata('id'),'cekbbl');
            $cekpp = datauser($this->session->userdata('id'),'cekpp');
            $cekut = datauser($this->session->userdata('id'),'cekut');
            $cekpc = datauser($this->session->userdata('id'),'cekpc');
            $cekmng = arrdep(datauser($this->session->userdata('id'),'bbl_cekmng'));
            $ceksgm = arrdep(datauser($this->session->userdata('id'),'bbl_ceksgm'));
            //Untuk Validasi Kepala Departemen
            if($cekbl==1){
                $this->db->where('data_ok', 0);
                $this->db->where('ok_valid', 0);
                $this->db->where('ok_tuju', 0);
                $this->db->where('ok_pc', 0);
                $this->db->where('ok_bb', 1);
                $this->db->where_in('dept_id',$hakttdpb);
            }else 
            //Untuk Validasi Manager PPIC dan UTL
            if($cekut==1 || $cekpp==1){
                $this->db->where('data_ok', 1);
                if($cekpp==1){
                    $this->db->group_start();
                        $this->db->where('ok_pp',0);
                        $this->db->or_group_start();
                            $this->db->where('ok_pp',0);
                            $this->db->where('bbl_pp',1);
                        $this->db->group_end();
                    $this->db->group_end();
                }else{
                    if($cekut==1){
                        $this->db->group_start();
                            $this->db->where('ok_pp',0);
                            $this->db->or_group_start();
                                $this->db->where('ok_pp',0);
                                $this->db->where('bbl_pp',2);
                            $this->db->group_end();
                        $this->db->group_end();
                    }else{
                        $this->db->where('ok_pp',1);
                        $this->db->where_in('dept_bbl', arrdep($this->session->userdata('hakdepartemen')));
                    }
                }
                $this->db->where('ok_valid', 0);
                $this->db->where('ok_tuju', 0);
                $this->db->where('ok_pc', 0);
            }else 
            if(count($cekmng) > 0){
                $this->db->where('data_ok', 1);
                $this->db->where('ok_valid', 0);
                $this->db->where('ok_tuju', 0);
                $this->db->where('ok_pc', 0);
                $this->db->where('ok_bb', 1);
                $this->db->where('ok_pp', 1);
                $this->db->where_in('dept_bbl',$cekmng);
            }else 
            if(count($ceksgm) > 0){
                $this->db->where('data_ok', 1);
                $this->db->where('ok_valid', 1);
                $this->db->where('ok_tuju', 0);
                $this->db->where('ok_pc', 0);
                $this->db->where('ok_bb', 1);
                $this->db->where_in('dept_bbl',$ceksgm);
            }else 
            //Untuk Validasi Manager Purchasing
            if($cekpc==1){
                $this->db->where('data_ok', 1);
                $this->db->where('ok_pp', 1);
                $this->db->where('ok_valid', 1);
                $this->db->where('ok_tuju', 1);
                $this->db->where('ok_pc', 0);
            }
        }
        $this->db->order_by('tgl','DESC');
        $query = $this->db->get('tb_header');
        $this->session->set_flashdata('cekquery',$this->db->get_compiled_select('tb_header',FALSE));
        return $query;
    }
    public function getdata($mode)
    {
        $this->db->where('id_perusahaan', IDPERUSAHAAN);
        $this->db->where('kode_dok', $mode);
        if ($mode == 'adj') {
                $this->db->where('data_ok', 1);
                $this->db->where('ok_valid', 0);
        } else if ($mode == 'pb') {
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
            $masuk = $this->session->userdata('ttd'); 
            $ttdppic = 0;
            $ttdutl = 0;
            if(datauser($this->session->userdata('id'),'cekpp')==1){
                $ttdppic = 1;
                // $masuk = 1;
                // echo $ttdppic;
            }
            if(datauser($this->session->userdata('id'),'cekut')==1){
                $ttdutl = 1;
                // $masuk = 1;
                // echo $ttdppic;
            }
            if(datauser($this->session->userdata('id'),'cekpc')==1){
                $masuk = 4;
            }
            if(datauser($this->session->userdata('id'),'cekbbl')==1){
                $masuk = 5;
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
                case 2: // Masuk
                    $this->db->where('data_ok', 1);
                    if($ttdppic==1){
                        $this->db->group_start();
                            $this->db->where('ok_pp',1);
                            $this->db->or_group_start();
                                $this->db->where('ok_pp',0);
                                $this->db->where('bbl_pp',1);
                            $this->db->group_end();
                        $this->db->group_end();
                    }else{
                        if($ttdutl==1){
                            $this->db->group_start();
                                $this->db->where('ok_pp',0);
                                $this->db->or_group_start();
                                    $this->db->where('ok_pp',0);
                                    $this->db->where('bbl_pp',2);
                                $this->db->group_end();
                            $this->db->group_end();
                        }else{
                            $this->db->where('ok_pp',1);
                            $this->db->where_in('dept_bbl', arrdep($this->session->userdata('hakdepartemen')));
                        }
                    }
                    $this->db->where('ok_valid', 0);
                    $this->db->where('ok_tuju', 0);
                    $this->db->where('ok_pc', 0);
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
                case 4: // Masuk
                    $this->db->where('data_ok', 1);
                    $this->db->where('ok_pp', 1);
                    $this->db->where('ok_valid', 1);
                    $this->db->where('ok_tuju', 1);
                    $this->db->where('ok_pc', 0);
                    // $this->db->where('bbl_pp',1);
                    // $this->db->where_in('dept_bbl', arrdep($this->session->userdata('hakdepartemen')));
                    break;
                case 5: //Masuk
                    $this->db->where('data_ok', 0);
                    // $this->db->where('ok_pp', 1);
                    $this->db->where('ok_valid', 0);
                    $this->db->where('ok_tuju', 0);
                    $this->db->where('ok_pc', 0);
                    // $this->db->where('bbl_pp', 1);
                    $this->db->where('ok_bb', 1);
                    $this->db->where_in('dept_id',arrdep($this->session->userdata('hakdepartemen')));
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
        $this->db->order_by('tgl','DESC');
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
    public function validasipo($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }
        public function validasiadj($data)
    {
        $this->db->trans_start();
        $detail = $this->db->get_where('tb_detail',['id_header'=>$data['id']]);
        foreach ($detail->result_array() as $dtl) {
            // Cek Stok Barang untuk departemen ini
            $header = $this->db->get_where('tb_header',['id'=>$data['id']])->row_array();
            $this->db->where('dept_id',$header['dept_id']);
            $this->db->where('periode',date('m').date('Y'));
            $this->db->where('id_barang',$dtl['id_barang']);
            $this->db->where('po',$dtl['po']);
            $this->db->where('item',$dtl['item']);
            $this->db->where('dis',$dtl['dis']);
            $this->db->where('insno',$dtl['insno']);
            $this->db->where('nobontr',$dtl['nobontr']);
            $this->db->where('dl',$dtl['dl']);
            $this->db->where('nobale',$dtl['nobale']);
            $hasil = $this->db->get('stokdept');
            if($hasil->num_rows() > 0){
                $stokdept = $hasil->row_array();
                // update kgs_akhir di tabel stokdept
                $this->db->set('pcs_adj','pcs_adj + '.$dtl['pcs'],FALSE);
                $this->db->set('kgs_adj','kgs_adj + '.$dtl['kgs'],FALSE);
                $this->db->set('pcs_akhir','pcs_akhir +'.$dtl['pcs'],FALSE);
                $this->db->set('kgs_akhir','kgs_akhir +'.$dtl['kgss'],FALSE);
                $this->db->where('id',$stokdept['id']);
                $this->db->update('stokdept');
            }else{
                $opto = [
                    'dept_id' => $header['dept_id'],
                    'periode' => date('m').date('Y'),
                    'nobontr' => $dtl['nobontr'],
                    'po' => $dtl['po'],
                    'item' => $dtl['item'],
                    'dis' => $dtl['dis'],
                    'insno' => $dtl['insno'],
                    'id_barang' => $dtl['id_barang'],
                    'dl' => $dtl['dl'],
                    'nobale' => $dtl['nobale'],
                    'stok' => $dtl['stok'],
                    'pcs_adj' => $dtl['pcs'],
                    'kgs_adj' => $dtl['kgs'],
                    'pcs_akhir' => $dtl['pcs'],
                    'kgs_akhir' => $dtl['kgs']
                ];
                $this->db->insert('stokdept',$opto);
            }
        }
        $this->db->where('id', $data['id']);
        $this->db->update('tb_header', $data);
        $query = $this->db->trans_complete();
        return $query;
    }
    public function simpancanceladj($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('tb_header', $data);
    }
    public function getdatabyid($id){
        $this->db->where('id',$id);
        return $this->db->get('tb_header')->row_array();
    }
}
