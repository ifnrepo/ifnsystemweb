<?php
class Taskmodel extends CI_Model
{
    public function getdatabaru($mode){
        $lvluser = datauser($this->session->userdata('id'),'id_level_user');
        $hakttdpb = arrdep(datauser($this->session->userdata('id'),'hakdepartemen'));
        $hakcekpb = arrdep(datauser($this->session->userdata('id'),'cekpb'));
        $this->db->where('id_perusahaan', IDPERUSAHAAN);
        if($mode != 'cekbc'){
            $this->db->where('kode_dok', $mode);
        }else{
            $this->db->group_start();
            $this->db->where('kode_dok', 'IB');
                $this->db->or_group_start();
                    $this->db->where('kode_dok', 'T');
                    $this->db->where('dept_tuju', 'CU');
                $this->db->group_end();
            $this->db->group_end();
            $this->db->where('data_ok',1);
            $this->db->where('ok_tuju',0);
        }
        if($mode == 'adj'){
            $this->db->where('data_ok', 1);
            $this->db->where('ok_valid', 0);
            $this->db->where_in('dept_id', $hakttdpb);
        }
        if($mode == 'po'){
            $this->db->where('data_ok', 1);
            $this->db->where('ok_valid', 0);
        }
        if($mode == 'pb'){
            if($lvluser >= 2){
                $this->db->where('data_ok', 1);
                $this->db->where('ok_valid', 0);
                if(count($hakcekpb) > 0){
                    $this->db->where_in('dept_id', $hakcekpb);
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
                        if(count($cekmng)>0){
                            $this->db->or_where('ok_pp',1);
                        }
                        $this->db->or_group_start();
                            $this->db->where('ok_pp',0);
                            $this->db->where('bbl_pp',1);
                        $this->db->group_end();
                    $this->db->group_end();
                    if(count($cekmng)>0){
                        $this->db->group_start();
                        $this->db->where_in('dept_bbl',$cekmng);
                        $this->db->or_where('ok_pp',0);
                        $this->db->group_end();
                    }
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
    public function getuntukvalidasi(){
        $query = 0;
        $lvluser = datauser($this->session->userdata('id'),'id_level_user');
        $hakttdpb = arrdep(datauser($this->session->userdata('id'),'hakdepartemen'));
        $hakcekpb = arrdep(datauser($this->session->userdata('id'),'cekpb'));
        for($ini=0;$ini<=4;$ini++){
            switch ($ini) {
                case 0:
                    $mode = 'pb';
                    break;
                case 1:
                    $mode = 'po';
                    break;
                case 2:
                    $mode = 'adj';
                    break;
                case 3:
                    $mode = 'cekbc';
                    break;
                case 4:
                    $mode = 'bbl';
                    break;
                
                default:
                    # code...
                    break;
            }
            //Cek Validasi PB
            if($mode=='pb'){
                $this->db->where('id_perusahaan', IDPERUSAHAAN);
                if($lvluser >= 2){
                    $this->db->where('kode_dok','pb');
                    $this->db->where('data_ok', 1);
                    $this->db->where('ok_valid', 0);
                    if(count($hakcekpb) > 0){
                        $this->db->where_in('dept_id', $hakcekpb);
                    }else{
                        $this->db->where('data_ok', 99);
                    }
                }else{
                    $this->db->where('data_ok', 99);
                }
                $query += $this->db->get('tb_header')->num_rows();
            }
            //Cek Validasi PO
            if($mode=='po' && datauser($this->session->userdata('id'),'cekpo')==1){
                $this->db->where('kode_dok','PO');
                $this->db->where('id_perusahaan', IDPERUSAHAAN);
                $this->db->where('data_ok', 1);
                $this->db->where('ok_valid', 0);
                $query += $this->db->get('tb_header')->num_rows();
            }
            //Cek Validasi ADJ
            if($mode == 'adj' && datauser($this->session->userdata('id'),'cekadj')==1){
                $this->db->where('kode_dok','ADJ');
                $this->db->where('data_ok', 1);
                $this->db->where('ok_valid', 0);
                $this->db->where_in('dept_id', $hakttdpb);
                $query += $this->db->get('tb_header')->num_rows();
            }
            //Cek Validasi Oleh BC
            if($mode=='cekbc' && datauser($this->session->userdata('id'),'cekpakaibc')==1){
                // $this->db->where('kode_dok', 'IB');
                $this->db->group_start();
                    $this->db->where('kode_dok', 'IB');
                    $this->db->or_group_start();
                        $this->db->where('kode_dok', 'T');
                        $this->db->where('dept_tuju', 'CU');
                    $this->db->group_end();
                $this->db->group_end();
                $this->db->where('data_ok',1);
                $this->db->where('ok_tuju',0);
                $query += $this->db->get('tb_header')->num_rows();
            }
            if($mode == 'bbl'){ 
                $cekbl = datauser($this->session->userdata('id'),'cekbbl');
                $cekpp = datauser($this->session->userdata('id'),'cekpp');
                $cekut = datauser($this->session->userdata('id'),'cekut');
                $cekpc = datauser($this->session->userdata('id'),'cekpc');
                $cekmng = arrdep(datauser($this->session->userdata('id'),'bbl_cekmng'));
                $ceksgm = arrdep(datauser($this->session->userdata('id'),'bbl_ceksgm'));
                if($cekbl==1 || $cekpp==1 || $cekut==1 || $cekpc==1 || count($cekmng) > 0 || count($ceksgm) > 0 ){
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
                                if(count($cekmng)>0){
                                    $this->db->or_where('ok_pp',1);
                                }
                                $this->db->or_group_start();
                                    $this->db->where('ok_pp',0);
                                    $this->db->where('bbl_pp',1);
                                $this->db->group_end();
                            $this->db->group_end();
                            if(count($cekmng)>0){
                                // $this->db->where_in('dept_bbl',$cekmng);
                                $this->db->group_start();
                                $this->db->where_in('dept_bbl',$cekmng);
                                $this->db->or_where('ok_pp',0);
                                $this->db->group_end();
                            }
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
                    $query += $this->db->get('tb_header')->num_rows();
                }
            }
        }
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
        $header = $this->db->get_where('tb_header',['id'=>$data['id']])->row_array();
        $detail = $this->db->get_where('tb_detail',['id_header'=>$data['id']]);
        $periode = cekperiodedaritgl($header['tgl']);
        foreach ($detail->result_array() as $datdet) {
            $kondisi = [
                'dept_id' => $header['dept_id'],
                'periode' => $periode,
                'po' => $datdet['po'],
                'item' => $datdet['item'],
                'dis' => $datdet['dis'],
                'id_barang' => $datdet['id_barang'],
                'trim(insno)' => trim($datdet['insno']),
                'trim(nobontr)' => trim($datdet['nobontr']),
                'dln' => $datdet['dln'],
                'trim(nobale)' => trim($datdet['nobale']),
                // 'exnet' => $datdet['exnet'],
            ];
            $cekdetail = $this->db->get_where('stokdept',$kondisi);
            if($cekdetail->num_rows() > 0){
                $datadetail = $cekdetail->row_array();
                $this->db->set('pcs_adj','pcs_adj +'.$datdet['pcs'],false);
                $this->db->set('kgs_adj','kgs_adj +'.$datdet['kgs'],false);
                $this->db->set('pcs_akhir','pcs_awal + pcs_masuk + pcs_adj +'.$datdet['pcs'],false);
                $this->db->set('kgs_akhir','kgs_awal + kgs_masuk + kgs_adj +'.$datdet['kgs'],false);
                $this->db->where('id',$datadetail['id']);
                $this->db->update('stokdept');
                $this->helpermodel->isilog($this->db->last_query());
            }else{
                $isi = [
                    'dept_id' => $header['dept_id'],
                    'periode' => $periode,
                    'po' => $datdet['po'],
                    'item' => $datdet['item'],
                    'dis' => $datdet['dis'],
                    'id_barang' => $datdet['id_barang'],
                    'insno' => $datdet['insno'],
                    'nobontr' => $datdet['nobontr'],
                    'dln' => $datdet['dln'],
                    'pcs_adj' => $datdet['pcs'],
                    'pcs_akhir' => $datdet['pcs'],
                    'kgs_adj' => $datdet['kgs'],
                    'kgs_akhir' => $datdet['kgs'],
                    'nobale' => trim($datdet['nobale']),
                    'exnet' => $datdet['exnet'],
                ];
                $this->db->insert('stokdept',$isi);
                $cekid = $this->db->insert_id();
                $this->helpermodel->isilog($this->db->last_query());
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
