<?php 
class In_model extends CI_Model{
    public function getdata($kode){
        $arrkondisi = [
            'id_perusahaan'=>IDPERUSAHAAN,
            'dept_tuju' => $kode['dept_id'],
            'dept_id' => $kode['dept_tuju'],
            // 'kode_dok' => 'T',
            'month(tgl)' => $this->session->userdata('bl'),
            'year(tgl)' => $this->session->userdata('th'),
            'data_ok' => 1,
            'ok_tuju' => 1
            // 'ok_valid' => 0,
        ];
        $kondisi = " (kode_dok='T' OR (kode_dok = 'IB' AND (nomor_bc != '' OR tanpa_bc = 1)))";
        $kondisisubkon = " kode_dok='T' AND (nomor_bc != '' OR tanpa_bc = 1)";
        $this->db->select('tb_header.*');
        $this->db->select('(select b.nomor_dok from tb_header b where b.id_keluar = tb_header.id) as nodok');
        $this->db->where($arrkondisi);
        $this->db->where('left(nomor_dok,3) !=','IFN');
        if($kode['katedept']==3){
            $this->db->where($kondisisubkon);
        }else{
            $this->db->where($kondisi);
        }
        $this->db->order_by('tgl');
        $this->db->order_by('nomor_dok');
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }
    public function getdatabyid($kode){
        $this->db->select('*,tb_header.id as xid,b.nama_subkon as namasubkon,b.alamat_subkon as alamatsubkon');
        $this->db->from('tb_header');
        $this->db->join('dept a','a.dept_id=tb_header.dept_id','left');
        $this->db->join('dept b','b.dept_id=tb_header.dept_tuju','left');
        $this->db->join('supplier c','c.id=tb_header.id_pemasok','left');
        $this->db->where('tb_header.id',$kode);
        $query = $this->db->get()->row_array();
        return $query;
    }
    public function getdatadetail($data,$mode=0){
        $this->db->select("a.*,b.namasatuan,b.kodesatuan,c.kode,c.nama_barang,c.kode as brg_id,d.spek");
        $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
        $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
        $this->db->from('tb_detail a');
        $this->db->join('satuan b','b.id = a.id_satuan','left');
        $this->db->join('barang c','c.id = a.id_barang','left');
        $this->db->join('tb_po d','d.po = a.po and d.item = a.item and d.dis = a.dis','left');
        if($mode==0){
            $this->db->where('a.id_header',$data);
        }else{
            $this->db->where('a.id_akb',$data);
        }
        return $this->db->get()->result_array();
    }
    public function resetin($id){
        $this->db->trans_start();
        $this->db->where('id_header',$id);
        $this->db->update('tb_detail',['verif_oleh'=>null,'verif_tgl'=>null]);
        $this->helpermodel->isilog($this->db->last_query());
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function verifikasirekord($id){
        $cek = $this->helpermodel->cekkolom($id,'verif_oleh',null,'tb_detail')->row_array();
        if($cek==0){
            $this->session->set_flashdata('errorsimpan',1);
            return false;
        }else{
            $datu = [
                'verif_oleh' => $this->session->userdata('id'),
                'verif_tgl' => date('Y-m-d H:i:s')
            ];
            $this->db->where('id',$id);
            $this->db->update('tb_detail',$datu);
            // $this->helpermodel->isilog($this->db->last_query());

            $this->db->select('tb_detail.*,user.name');
            $this->db->join('user','tb_detail.verif_oleh=user.id','left');
            $query = $this->db->get_where('tb_detail',['tb_detail.id'=>$id]);
            return $query->result();
        }
    }
    public function simpanin($id,$mode=0,$ibnya=''){
        $this->db->trans_start();
        $cek = $this->helpermodel->cekkolom($id,'ok_valid',0,'tb_header')->num_rows();
        $dataheader = $this->db->get_where('tb_header',['id' => $id])->row_array();
        $arraynobontr = ['SP','GM'];
        if($cek==1){
            $this->db->select('tb_detail.*,tb_header.dept_tuju,tb_header.tgl,tb_header.dept_id');
            $this->db->join('tb_header','tb_detail.id_header=tb_header.id','left');
            if($mode==0){
                $this->db->where('id_header',$id);
            }else{
                $this->db->where('id_akb',$id);
            }
            $detail = $this->db->get('tb_detail')->result_array();
            foreach($detail as $det){
                $kondisistok = [
                    // 'tgl' => $det['tgl'],
                    'dept_id' => $det['dept_tuju'],
                    'periode' => tambahnol($this->session->userdata('bl')).$this->session->userdata('th'),
                    'trim(nobontr)' => trim($det['nobontr']),
                    'trim(insno)' => trim($det['insno']),
                    'id_barang' => $det['id_barang'],
                    'trim(po)' => trim($det['po']),
                    'trim(item)' => trim($det['item']),
                    'dis' => $det['dis'],
                    'dln' => $det['dln'],
                    'trim(nobale)' => ($det['dept_id']=='FN' && $det['dept_tuju']=='GF') ? trim($datdet['nobale']) : '',
                    'nomor_bc' => in_array($det['dept_tuju'],daftardeptsubkon()) ? trim($dataheader['nomor_bc']) : '',
                    // 'trim(nobale)' => trim($det['nobale']),
                    // 'harga' => $det['harga'],
                    'stok' => $det['stok'],
                    // 'exnet' => $det['exnet']
                ];
                $this->db->where($kondisistok);
                $adaisi = $this->db->get('stokdept');
                if($adaisi->num_rows()==0){
                    $kondisi = [
                    'tgl' => $det['tgl'],
                    'dept_id' => $det['dept_tuju'],
                    'periode' => tambahnol($this->session->userdata('bl')).$this->session->userdata('th'),
                    'nobontr' => $det['nobontr'],
                    'insno' => $det['insno'],
                    'id_barang' => $det['id_barang'],
                    'po' => $det['po'],
                    'item' => $det['item'],
                    'dis' => $det['dis'],
                    'dln' => $det['dln'],
                    'nobale' => $det['dept_tuju']=='GF' ? trim($det['nobale']) : '',
                    'nomor_bc' => in_array($det['dept_tuju'],daftardeptsubkon()) ? trim($dataheader['nomor_bc']) : '',
                    'tgl_bc' => in_array($det['dept_tuju'],daftardeptsubkon()) ? trim($dataheader['tgl_bc']) : '',
                    // 'harga' => $det['harga'],
                    // 'exnet' => $det['exnet'],
                    'pcs_masuk' => $det['pcs'],
                    'pcs_akhir' => $det['pcs'],
                    'kgs_masuk' => $det['kgs'],
                    'kgs_akhir' => $det['kgs'],
                    ];
                    $this->db->insert('stokdept',$kondisi);
                    $cekid = $this->db->insert_id();
                    $this->helpermodel->isilog($this->db->last_query());
                }else{
                    $detil = $adaisi->row_array();
                    $this->db->set('pcs_masuk','pcs_masuk +'.$det['pcs'],false);
                    $this->db->set('kgs_masuk','kgs_masuk +'.$det['kgs'],false);
                    $this->db->where('id',$detil['id']);
                    $this->db->update('stokdept');

                    // $this->db->set('pcs_akhir','pcs_awal + pcs_masuk + pcs_adj +'.$det['pcs'],false);
                    // $this->db->set('kgs_akhir','kgs_awal + kgs_masuk + kgs_adj +'.$det['kgs'],false);
                    $this->db->set('pcs_akhir','(pcs_awal + pcs_masuk + pcs_adj - pcs_keluar)',false);
                    $this->db->set('kgs_akhir','(kgs_awal + kgs_masuk + kgs_adj - kgs_keluar)',false);
                    $this->db->where('id',$detil['id']);
                    $this->db->update('stokdept');
                    $this->helpermodel->isilog($this->db->last_query());
                }
                $this->helpermodel->cekstokdeptraw($det['dept_tuju'],$det['nobontr'],$det['id_barang'],$det['kgs'],$det['pcs'],0);
            }
            $dataubah = [
                'ok_valid' => 1,
                'user_valid' => $this->session->userdata('id'),
                'tgl_valid' => date('Y-m-d H:i:s'),
                'nomor_dok' => $ibnya=='' ? $dataheader['nomor_dok'] : $ibnya
            ];
            $this->db->where('id',$id);
            $this->db->update('tb_header',$dataubah);
            $this->helpermodel->isilog($this->db->last_query());
        }
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function cekpcskgs($id){
        $this->db->select("Sum(pcs) as pcs,sum(kgs) as kgs");
        $this->db->from('tb_detail');
        $this->db->where('id_header',$id);
        return $this->db->get();
    }
    // END In Model
    public function konfirmasi($data){
        $this->db->where('id',$data['id']);
        $query = $this->db->update('tb_header',$data);
        $this->helpermodel->isilog($this->db->last_query());
        return $query;
    }

    public function getdepttuju($kode){
        $xkode = [];
        $hasil = [];
        $query = $this->db->get_where('dept',['dept_id'=>$kode])->row_array();
        if($query){
            // for($x=0;$x<=strlen($query['pengeluaran'])/2;$x++){
            //     array_push($xkode,substr($query['pengeluaran'],($x*2)-2,2));
            // }
            $this->db->where_in('dept_id',arrdep($query['penerimaan']));
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
        $this->helpermodel->isilog($this->db->last_query());
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
        $this->helpermodel->isilog($this->db->last_query());
        $this->db->trans_complete();
        return $dataheader['id'];
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
        $this->helpermodel->isilog($this->db->last_query());
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
        $this->helpermodel->isilog($this->db->last_query());
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
        $jumlah = $this->db->get_where('tb_detail',['id_header'=>$id])->num_rows();
        $data = [
            'data_ok' => 1,
            'user_ok' => $this->session->userdata('id'),
            'tgl_ok' => date('Y-m-d H:i:s'),
            'jumlah_barang' => $jumlah
        ];
        $this->db->where('id',$id);
        $hasil = $this->db->update('tb_header',$data);
        $this->helpermodel->isilog($this->db->last_query());
        return $hasil;
    }
}