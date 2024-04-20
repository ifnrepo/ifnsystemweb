<?php 
class Out_model extends CI_Model{
    public function getdata($kode){
        $arrkondisi = [
            'id_perusahaan'=>IDPERUSAHAAN,
            'dept_id' => $kode['dept_id'],
            'dept_tuju' => $kode['dept_tuju'],
            'kode_dok' => 'T',
            'month(tgl)' => $this->session->userdata('bl'),
            'year(tgl)' => $this->session->userdata('th')
        ];
        $this->db->select('tb_header.*');
        $this->db->select('(select b.nomor_dok from tb_header b where b.id_keluar = tb_header.id) as nodok');
        $this->db->where($arrkondisi);
        $hasil = $this->db->get('tb_header');
        return $hasil->result_array();
    }
    public function getdatabyid($kode){
        $this->db->join('dept','dept.dept_id=tb_header.dept_id','left');
        $query = $this->db->get_where('tb_header',['id'=>$kode]);
        return $query->row_array();
    }
    public function getdepttuju($kode){
        $xkode = [];
        $hasil = [];
        $query = $this->db->get_where('dept',['dept_id'=>$kode])->row_array();
        if($query){
            for($x=0;$x<=strlen($query['pengeluaran'])/2;$x++){
                array_push($xkode,substr($query['pengeluaran'],($x*2)-2,2));
            }
            $this->db->where_in('dept_id',$xkode);
            $this->db->order_by('departemen','asc');
            $hasil = $this->db->get('dept');
        }
        return $hasil;
    }
    public function getbon($kode){
        $this->db->where($kode);
        $query = $this->db->get('tb_header');
        return $query->result_array();
    }
    public function getnomorout($bl,$th,$asal,$tuju){
        $hasil = $this->db->query("SELECT MAX(SUBSTR(nomor_dok,14,3)) AS maxkode FROM tb_header 
        WHERE kode_dok = 'T' AND MONTH(tgl)='".$bl."' AND YEAR(tgl)='".$th."' AND dept_id = '".$asal."' AND dept_tuju = '".$tuju."' ")->row_array();
        return $hasil;
    }
    public function tambahdataout($kode){
        $this->db->trans_start();
        $date = $this->session->userdata('th').'-'.$this->session->userdata('bl').'-'.date('d');
        $nomordok = nomorout($date,$this->session->userdata('deptsekarang'),$this->session->userdata('tujusekarang'));
        $tambah = [
            'id_perusahaan' => IDPERUSAHAAN,
            'kode_dok' => 'T',
            'dept_id' => $this->session->userdata('deptsekarang'),
            'dept_tuju' => $this->session->userdata('tujusekarang'),
            'nomor_dok' => $nomordok,
            'tgl' => $date
        ];
        $this->db->insert('tb_header',$tambah);
        $dataheader = $this->db->get_where('tb_header',['nomor_dok'=>$nomordok])->row_array();
        $query = $this->db->get_where('tb_detail',['id_header'=>$kode])->result_array();
        foreach($query as $que){
            $que['id_minta'] = $que['id']; 
            unset($que['id']);
            $que['id_header'] = $dataheader['id'];
            $this->db->insert('tb_detail',$que);
        }
        $this->db->where('id',$kode);
        $this->db->update('tb_header',['id_keluar' => $dataheader['id']]);
        $this->db->trans_complete();
        return $dataheader['id'];
    }
    public function getdatadetailout($data){
        $this->db->select("a.*,b.namasatuan,b.kodesatuan,c.kode,c.nama_barang,c.kode as brg_id");
        $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
        $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
        $this->db->from('tb_detail a');
        $this->db->join('satuan b','b.id = a.id_satuan','left');
        $this->db->join('barang c','c.id = a.id_barang','left');
        $this->db->where('a.id_header',$data);
        return $this->db->get()->result_array();
    }
    public function getdatadetailoutbyid($data){
        $this->db->select("a.*,b.namasatuan,b.kodesatuan,c.kode,c.nama_barang,c.kode as brg_id");
        $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
        $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
        $this->db->from('tb_detail a');
        $this->db->join('satuan b','b.id = a.id_satuan','left');
        $this->db->join('barang c','c.id = a.id_barang','left');
        $this->db->where('a.id',$data);
        return $this->db->get()->row_array();
    }
    public function updateout($data){
        $this->db->where('id',$data['id']);
        $query = $this->db->update('tb_header',$data);
        return $query;
    }
    public function updatedetail($data){
        $this->db->where('id',$data['id']);
        $query = $this->db->update('tb_detail',$data);
        return $query;
    }
    public function simpanout($data){
        $jumlahrek = $this->db->get_where('tb_detail',['id_header'=>$data['id']])->num_rows();
        $data['jumlah_barang'] = $jumlahrek;
        $this->db->where('id',$data['id']);
        $query = $this->db->update('tb_header',$data);
        return $query;
    }
    public function hapusdataout($id){
        $this->db->trans_start();
        $this->db->where('id',$id);
        $query = $this->db->get('tb_header')->row_array();
        if($query){
            $this->db->where('id_header',$id);
            $this->db->delete('tb_detmaterial');
            $this->db->where('id_header',$id);
            $this->db->delete('tb_detail');
        }
        $this->db->where('id_keluar',$id);
        $this->db->update('tb_header',['id_keluar' => null]);
        
        $this->db->where('id',$id);
        $this->db->delete('tb_header');
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function resetdetail($id){
        $this->db->trans_start();
        $que1 = $this->db->get_where('tb_detail',['id_header'=>$id])->result_array();
        foreach($que1 as $data1){
            $cek = $this->db->get_where('tb_detail',['id'=>$data1['id_minta']])->row_array();
            $data = [
                'pcs' => $cek['pcs'],
                'kgs' => $cek['kgs']
            ];
            $this->db->where('id',$data1['id']);
            $this->db->update('tb_detail',$data);
        }
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function simpanheaderout($id){
        $iniquery = false;
        $this->db->trans_begin();
        $datadetail = $this->db->get_where('tb_detail',['id_header'=>$id])->result_array();
        foreach ($datadetail as $datdet) {
            $data = [
                'pcs_keluar' => $datdet['pcs'],
                'kgs_keluar' => $datdet['kgs']
            ];
            $kondisi = [
                'id_barang' => $datdet['id_barang'],
                'periode' => $this->session->userdata('bl').$this->session->userdata('th'),
                'dept_id' => $this->session->userdata('deptsekarang')
            ];
            $cekdata = $this->db->get_where('stokdept',$kondisi);
            $jmll = $cekdata->num_rows();
            $deta = $cekdata->row_array();
            if($deta['pcs_akhir'] >= $datdet['pcs'] && $deta['pcs_akhir']!=null && $jmll > 0){
                $this->db->where($kondisi);
                $this->db->update('stokdept',$data);
            }else{
                break;
                $iniquery = true;
            }
        }
        $jumlah = $this->db->get_where('tb_detail',['id_header'=>$id])->num_rows();
        $data = [
            'data_ok' => 1,
            'user_ok' => $this->session->userdata('id'),
            'tgl_ok' => date('Y-m-d H:i:s'),
            'jumlah_barang' => $jumlah
        ];
        // if ($this->db->trans_status() === FALSE || $iniquery==true){
            $this->db->trans_rollback();
        // }else{
        //     $this->db->where('id',$id);
        //     $this->db->update('tb_header',$data);
        //     $this->db->trans_commit();
        // }
        return $this->db->trans_status();
    }
}