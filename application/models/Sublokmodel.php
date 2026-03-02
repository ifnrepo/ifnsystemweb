<?php
class Sublokmodel extends CI_Model
{

    public function getdata(){
        $this->db->select('tb_inputsublokasi.*,tb_lokasi.dept_id');
        $this->db->from('tb_inputsublokasi');
        $this->db->join('tb_lokasi','tb_lokasi.id = tb_inputsublokasi.id_lokasi','left');
        if($this->session->userdata('sublokasi')!=''){
            $this->db->where('id_lokasi',$this->session->userdata('sublokasi'));
        }
        $this->db->where('tb_lokasi.dept_id',$this->session->userdata('deptsublok'));
        $this->db->where('year(tgl)',$this->session->userdata('thsublok'));
        $this->db->where('month(tgl)',$this->session->userdata('blsublok'));
        return $this->db->get();
    }
    public function getdatabyid($id){
        $this->db->select('tb_inputsublokasi.*,tb_lokasi.kode_lokasi,tb_lokasi.nama_lokasi,dept.departemen');
        $this->db->from('tb_inputsublokasi');
        $this->db->join('tb_lokasi','tb_lokasi.id = tb_inputsublokasi.id_lokasi','left');
        $this->db->join('dept','dept.dept_id = tb_lokasi.dept_id','left');
        $this->db->where('tb_inputsublokasi.id',$id);
        return $this->db->get()->row_array();
    }
    public function getdatadetail($id){
        $this->db->select('tb_inputsublokasi_detail.*');
        $this->db->from('tb_inputsublokasi_detail');
        $this->db->join('tb_inputsublokasi','tb_inputsublokasi.id = tb_inputsublokasi_detail.id_inputsublokasi','left');
        $this->db->where('tb_inputsublokasi_detail.id_inputsublokasi',$id);
        return $this->db->get();
    }
    public function getdeplokasi(){
        $this->db->select('tb_lokasi.*,dept.departemen');
        $this->db->from('tb_lokasi');
        $this->db->join('dept','dept.dept_id = tb_lokasi.dept_id','left');
        $this->db->order_by('dept_id');
        $this->db->group_by('dept_id');
        return $this->db->get();
    }
    public function getlokasi(){
        $did = $this->session->userdata('deptsublok')=='' ? '' : $this->session->userdata('deptsublok');
        return $this->db->get_where('tb_lokasi',['dept_id' => $did]);
    }
    public function getdatasublok(){
        // $this->db->where('katedept_id <= ',3);
        // $this->db->order_by('departemen');
        return $this->db->get('tb_sublok');
    }
    public function adddata($id){
        $nomor = '';
        $datalokasi = $this->db->get_where('tb_lokasi',['id' => $id])->row_array();

        $this->db->select('max(trim(right(tb_inputsublokasi.nomor,3))) as jml');
        $this->db->from('tb_inputsublokasi');
        $this->db->where('Year(tgl)',$this->session->userdata('thsublok'));
        $this->db->where('month(tgl)',$this->session->userdata('blsublok'));
        $this->db->where('id_lokasi',$id);
        $datamax = $this->db->get();
        if($datamax->num_rows() > 0){
            $hasildatamax = $datamax->row_array();
            $int = isset($hasildatamax['jml']) ? (int) $hasildatamax['jml'] : 0;
            $int++;
            $nomor = $datalokasi['kode_lokasi']."-".tambahnol($this->session->userdata('blsublok'),1) . $this->session->userdata('thsublok') . "-" . sprintf("%04s", $int);
        }else{
            $nomor = $datalokasi['kode_lokasi']."-".tambahnol($this->session->userdata('blsublok'),1) . $this->session->userdata('thsublok') . "-0001";
        }

        $datainput = [
            'tgl' => date('Y-m-d'),
            'nomor' => $nomor,
            'id_lokasi' => $id,
            'dibuat_oleh' => $this->session->userdata('id'),
            'tgl_buat' => date('Y-m-d H:i:s')
        ];

        $this->db->insert('tb_inputsublokasi',$datainput);
        $idnya = $this->db->insert_id();
        return $idnya;
    }
    public function hapusdata($id){
        $this->db->trans_start();
        $this->db->where('id_inputsublokasi',$id);
        $this->db->delete('tb_inputsublokasi_detail');

        $this->db->where('id',$id);
        $this->db->delete('tb_inputsublokasi');
        return $this->db->trans_complete();
    }
    public function cekmasukdata($insno){
        return $this->db->get_where('tb_netinstr',['insno' => $insno ]);
    }
    //End data sublok
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
}
