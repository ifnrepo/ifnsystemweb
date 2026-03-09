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
    public function tambahketemp($data){
        $caripo = $this->db->get_where('tb_po',['ind_po' => $data['ind']]);
        if($caripo->num_rows() > 0){
            $hasilcaripo = $caripo->row_array();
            $isi = [
                'id_inputsublokasi' => $data['id'],
                'po' => $hasilcaripo['po'],
                'item' => $hasilcaripo['item'],
                'dis' => $hasilcaripo['dis'],
                'lot' => $data['lot'],
                'jalur' => $data['jalur'],
                'insno' => $data['insno'],
                'pcs' => 1,
                'kgs' => $hasilcaripo['jala']+$hasilcaripo['mimi']
            ];
            return $this->db->insert('tb_inputsublokasi_detail_temp',$isi);
        }
    }
    public function getdatatemp($id){
        $this->db->where('id_inputsublokasi',$id);
        return $this->db->get('tb_inputsublokasi_detail_temp');
    }
    public function hapusdettemp($id){
        $data = $this->db->get_where('tb_inputsublokasi_detail_temp',['id' => $id])->row_array();

        $this->db->where('id',$id);
        $this->db->delete('tb_inputsublokasi_detail_temp');

        return $data['id_inputsublokasi'];
    }
    public function simpantempkeasli($id){
        $this->db->trans_start();
        $data = $this->db->get_where('tb_inputsublokasi_detail_temp',['id_inputsublokasi' => $id]);
        foreach($data->result_array() as $dt){
            unset($dt['id']);
            $this->db->insert('tb_inputsublokasi_detail',$dt);
        }
        $this->db->where('id_inputsublokasi',$id);
        $this->db->delete('tb_inputsublokasi_detail_temp');

        $this->db->select("sum(pcs) over() as xpcs,sum(kgs) over() as xkgs");
        $this->db->from('tb_inputsublokasi_detail');
        $this->db->where('id_inputsublokasi',$id);
        $hasil = $this->db->get()->row_array();

        $this->db->where('id',$id);
        $this->db->update('tb_inputsublokasi',['pcs' => $hasil['xpcs'],'kgs' => $hasil['xkgs']]);

        return $this->db->trans_complete();
    }
    public function hapusinputdata($id,$head){
        $this->db->where('id',$id);
        $this->db->delete('tb_inputsublokasi_detail');
        
        $this->db->select("sum(pcs) over() as xpcs,sum(kgs) over() as xkgs");
        $this->db->from('tb_inputsublokasi_detail');
        $this->db->where('id_inputsublokasi',$head);
        $hasil = $this->db->get()->row_array();

        $this->db->where('id',$head);
        return $this->db->update('tb_inputsublokasi',['pcs' => $hasil['xpcs'],'kgs' => $hasil['xkgs']]);

    }
    public function simpandata($id){
        $this->db->where('id',$id);
        return $this->db->update('tb_inputsublokasi',['disimpan_oleh' => $this->session->userdata('id'),'tgl_simpan' => date('Y-m-d H:i:s')]);
    }
}