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
    public function getdatapcskgs($kode){
        $arrkondisi = [
            'id_perusahaan'=>IDPERUSAHAAN,
            'dept_id' => $kode['dept_id'],
            'dept_tuju' => $kode['dept_tuju'],
            'kode_dok' => 'T',
            'month(tgl)' => $this->session->userdata('bl'),
            'year(tgl)' => $this->session->userdata('th')
        ];
        $this->db->select('sum(tb_detail.pcs) as pcs, sum(tb_detail.kgs) as kgs');
        $this->db->from('tb_detail');
        $this->db->join('tb_header','tb_header.id = tb_detail.id_header','left');
        $this->db->where($arrkondisi);
        $this->db->where('tb_header.data_ok',1);
        // $this->db->where('tb_header.ok_valid',1);
        $hasil = $this->db->get();
        return $hasil->row_array();
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
                // if(substr($query['pengeluaran'],($x*2)-2,2) != $kode){
                    array_push($xkode,substr($query['pengeluaran'],($x*2)-2,2));
                // }
            }
            $this->db->where_in('dept_id',$xkode);
            $this->db->order_by('departemen','asc');
            $hasil = $this->db->get('dept');
        }
        return $hasil;
    }
    public function getbon(){
        $kondisi = [
            'b.dept_id' => $this->session->userdata('tujusekarang'),
            'b.dept_tuju' => $this->session->userdata('deptsekarang'),
            'b.kode_dok' => 'PB',
            'a.id_out' => 0,
            'b.data_ok' => 1,
            'b.ok_valid' => 1,
            'b.ok_tuju' => 0,
            'month(b.tgl) <=' => $this->session->userdata('bl'),
            'year(b.tgl) <=' => $this->session->userdata('th')
        ];
        $this->db->select('*,a.keterangan as keteranganx,a.id as idx');
        $this->db->from('tb_detail a');
        $this->db->join('tb_header b','b.id = a.id_header','left');
        $this->db->join('barang c','c.id = a.id_barang','left');
        $this->db->where($kondisi);
        $this->db->order_by('b.tgl','DESC');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function getnomorout($bl,$th,$asal,$tuju){
        if($asal=='DL' && $tuju=='GM'){
            $hasil = $this->db->query("SELECT MAX(SUBSTR(nomor_dok,17,3)) AS maxkode FROM tb_header 
            WHERE kode_dok = 'T' AND MONTH(tgl)='".$bl."' AND YEAR(tgl)='".$th."' AND dept_id = '".$asal."' AND dept_tuju = '".$tuju."' ")->row_array();
        }else{
            $hasil = $this->db->query("SELECT MAX(SUBSTR(nomor_dok,14,3)) AS maxkode FROM tb_header 
            WHERE kode_dok = 'T' AND MONTH(tgl)='".$bl."' AND YEAR(tgl)='".$th."' AND dept_id = '".$asal."' AND dept_tuju = '".$tuju."' ")->row_array();
        }
        return $hasil;
    }
    public function adddata($jn){
        $this->db->trans_start();
        $date = $this->session->userdata('th').'-'.$this->session->userdata('bl').'-'.date('d');
        $nomordok = nomorout($date,$this->session->userdata('deptsekarang'),$this->session->userdata('tujusekarang'));
        $tambah = [
            'id_perusahaan' => IDPERUSAHAAN,
            'kode_dok' => 'T',
            'dept_id' => $this->session->userdata('deptsekarang'),
            'dept_tuju' => $this->session->userdata('tujusekarang'),
            'nomor_dok' => $nomordok,
            'tgl' => $date,
            'jn_bbl' => $jn
        ];
        $this->db->insert('tb_header',$tambah);
        $idheader = $this->db->insert_id();
        $this->helpermodel->isilog($this->db->last_query());
        $this->db->trans_complete();
        return $idheader;
    }
    public function tambahdataout($kode){
        $this->db->trans_start();
        $dataheader = $this->db->get_where('tb_header',['id'=>$kode['id']])->row_array();
        $jumlah = count($kode['data']);
        for($x=0;$x<$jumlah;$x++){
            $arrdat = $kode['data'];
            $que = $this->db->get_where('tb_detail',['id'=>$arrdat[$x]])->row_array();
            $que['id_minta'] = $que['id']; 
            unset($que['id']);
            $que['id_header'] = $dataheader['id'];
            $this->db->insert('tb_detail',$que);
            $idnya = $this->db->insert_id();
            $this->helpermodel->isilog($this->db->last_query());
            $que['id_detail'] = $idnya;
            $this->db->insert('tb_detailgen',$que);

            $this->db->where('id',$arrdat[$x]);
            $this->db->update('tb_detail',['id_out'=>$idnya]);
        }
        $this->db->where('id',$kode['id']);
        $this->db->update('tb_header',['jumlah_barang'=>$jumlah]);
        $this->db->trans_complete();
        return $dataheader['id'];
    }
    public function getdatadetail($data){
        $this->db->select("a.*,b.namasatuan,b.kodesatuan,c.kode,c.nama_barang,c.kode as brg_id,e.nomor_dok as nodok");
        $this->db->from('tb_detailgen a');
        $this->db->join('satuan b','b.id = a.id_satuan','left');
        $this->db->join('barang c','c.id = a.id_barang','left');
        $this->db->join('tb_detail d','a.id = d.id_out','left');
        $this->db->join('tb_header e','e.id = d.id_header','left');
        $this->db->where('a.id_header',$data);
        return $this->db->get()->result_array();    
    }
    public function getdatadetailout($data){
        // $ini = $this->session->flashdata('barangerror')=='' ? "''" : $this->session->flashdata('barangerror');
        $ini = 7184;
        $this->db->select("a.*,b.namasatuan,b.kodesatuan,c.kode,c.nama_barang,c.kode as brg_id,e.nomor_dok as nodok");
        $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
        $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
        $this->db->select($ini.' as baer');
        $this->db->from('tb_detail a');
        $this->db->join('satuan b','b.id = a.id_satuan','left');
        $this->db->join('barang c','c.id = a.id_barang','left');
        $this->db->join('tb_detail d','a.id = d.id_out','left');
        $this->db->join('tb_header e','e.id = d.id_header','left');
        $this->db->where('a.id_header'.$this->session->flashdata('barangerror'),$data);
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
        $this->db->where('id_detail',$data['id']);
        $this->db->update('tb_detailgen',$data);
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
            $detail = $this->db->get('tb_detail');
            foreach ($detail->result_array() as $det) {
                $this->db->where('id_out',$det['id']);
                $this->db->update('tb_detail',['id_out'=>0]);
            }
            $this->db->where('id_header',$id);
            $this->db->delete('tb_detmaterial');
            $this->db->where('id_header',$id);
            $this->db->delete('tb_detail');
        }
        $this->db->where('id_keluar',$id);
        $this->db->update('tb_header',['id_keluar' => 0]);
        
        $this->db->where('id',$id);
        $this->db->delete('tb_header');
        $this->helpermodel->isilog($this->db->last_query());
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function resetdetail($id){
        $this->db->trans_start();
        $this->db->where('id',$id);
        $query = $this->db->get('tb_header')->row_array();
        if($query){
            $this->db->where('id_header',$id);
            $detail = $this->db->get('tb_detail');
            foreach ($detail->result_array() as $det) {
                $this->db->where('id_out',$det['id']);
                $this->db->update('tb_detail',['id_out'=>0]);
            }
            $this->db->where('id_header',$id);
            $this->db->delete('tb_detmaterial');
            $this->db->where('id_header',$id);
            $this->db->delete('tb_detail');
            $this->db->where('id_header',$id);
            $this->db->delete('tb_detailgen');
        }
        $this->db->where('id_keluar',$id);
        $this->db->update('tb_header',['id_keluar' => 0]);
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function hapusdetailout($id){
        $this->db->trans_start();
            $this->db->where('id_out',$id);
            $this->db->update('tb_detail',['id_out'=>0]);

            $this->db->where('id_detail',$id);
            $this->db->delete('tb_detmaterial');
            $this->db->where('id_detail',$id);
            $this->db->delete('tb_detailgen');
            $this->db->where('id',$id);
            $this->db->delete('tb_detail');
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function simpanheaderout($id){
        $this->session->unset_userdata('barangerror');
        $iniquery = false;
        $this->db->trans_begin();
        $datadetail = $this->db->get_where('tb_detailgen',['id_header'=>$id]);
        $no=0;
        if($datadetail->num_rows() > 0){
            foreach ($datadetail->result_array() as $datdet) {
                if($this->session->userdata('deptsekarang')=='GM'){
                    if($datdet['nobontr']==''){
                        $iniquery = true;
                        $this->session->set_flashdata('errornya','Nobontr Kosong');
                        break;
                    }
                }
                $no++;
                if($this->session->userdata('deptsekarang')=='GS'){
                    $kondisi = [
                        'po' => $datdet['po'],
                        'item' => $datdet['item'],
                        'dis' => $datdet['dis'],
                        'id_barang' => $datdet['id_barang'],
                        'dept_id' => $this->session->userdata('deptsekarang'),
                        'dl' => $datdet['dln'],
                        'periode' => kodebulan($this->session->userdata('bl')).$this->session->userdata('th'),
                    ];
                }else{
                    $kondisi = [
                        'po' => $datdet['po'],
                        'item' => $datdet['item'],
                        'dis' => $datdet['dis'],
                        'id_barang' => $datdet['id_barang'],
                        'dept_id' => $this->session->userdata('deptsekarang'),
                        'insno' => $datdet['insno'],
                        'nobontr' => $datdet['nobontr'],
                        'dl' => $datdet['dln'],
                        'nobale' => $datdet['nobale'],
                        'stok' => $datdet['stok'],
                        'periode' => kodebulan($this->session->userdata('bl')).$this->session->userdata('th'),
                    ];
                }
                $this->db->select('stokdept.*,sum(stokdept.pcs_akhir) as xpcs_akhir,sum(stokdept.kgs_akhir) as xkgs_akhir,barang.nama_barang');
                $this->db->from('stokdept');
                $this->db->join('barang','barang.id = stokdept.id_barang','left');
                $this->db->where($kondisi);
                $cekdata = $this->db->get();
                // $cekdata = $this->db->get_where('stokdept',$kondisi);
                $jmll = $cekdata->num_rows();
                $deta = $cekdata->row_array();
                // echo $deta['xpcs_akhir'];
                // echo $datdet['pcs'];
                if($datdet['pcs'] > 0 || $datdet['kgs'] > 0){
                    if((($deta['xpcs_akhir'] >= $datdet['pcs']) && ($deta['xkgs_akhir'] >= $datdet['kgs'])) && $jmll > 0){
                        $pcsnya = $datdet['pcs'] > 0 ? $datdet['pcs'] : $datdet['kgs'];
                        $pcsasli = $datdet['pcs']==NULL ? 0 : $datdet['pcs'];
                        $kgsasli = $datdet['kgs']==NULL ? 0 : $datdet['kgs'];
                        $loopke = 0;
                        do {
                            $loopke += 1;
                            $this->db->where($kondisi);
                            $this->db->group_start();
                            $this->db->where('pcs_akhir > ',0);
                            $this->db->or_where('kgs_akhir > ',0);
                            $this->db->group_end();
                            $arrstokdept = $this->db->order_by('tgl,urut')->get('stokdept')->row_array();
                            if($this->session->userdata('deptsekarang')=='GS'){
                                $nobontr = $arrstokdept['nobontr'];
                            }else{
                                $nobontr = $datdet['nobontr'];
                            }
                            // echo print_r($datdet);
                            $stokid=$arrstokdept['id'];
                            if(($pcsasli > $arrstokdept['pcs_akhir']) || ($kgsasli > $arrstokdept['kgs_akhir'])){
                                $kurangpcs = $arrstokdept['pcs_akhir'];
                                $kurangkgs = $arrstokdept['kgs_akhir'];
                            }else{
                                $kurangpcs = $pcsasli;
                                $kurangkgs = $kgsasli;
                            }
                            // update kgs_akhir di tabel stokdept
                            $this->db->set('pcs_keluar','pcs_keluar + '.$kurangpcs,FALSE);
                            $this->db->set('kgs_keluar','kgs_keluar + '.$kurangkgs,FALSE);
                            $this->db->set('pcs_akhir','pcs_akhir-'.$kurangpcs,FALSE);
                            $this->db->set('kgs_akhir','kgs_akhir-'.$kurangkgs,FALSE);
                            $this->db->where('id',$stokid);
                            $this->db->update('stokdept');

                            $pcsasli -= $kurangpcs;
                            $kgsasli -= $kurangkgs;
                            
                            if($loopke > 1){
                                // insert ke tabel detail apabila stokdept menguragi 2 rekord
                                unset($datdet['id']);
                                unset($datdet['id_detail']);
                                $this->db->insert('tb_detail',$datdet);
                                $idinsert = $this->db->insert_id();
                                $this->db->insert('tb_detailgen',$datdet);
                                $idinsertx = $this->db->insert_id();

                                $this->db->set('id_stokdept',$stokid);
                                $this->db->set('nobontr',$nobontr);
                                $this->db->set('pcs',$kurangpcs);
                                $this->db->set('kgs',$kurangkgs);
                                $this->db->set('harga',$deta['harga']);
                                $this->db->where('id',$idinsert);
                                $this->db->update('tb_detail');

                                $this->db->set('id_stokdept',$stokid);
                                $this->db->set('nobontr',$nobontr);
                                $this->db->set('pcs',$kurangpcs);
                                $this->db->set('kgs',$kurangkgs);
                                $this->db->set('harga',$deta['harga']);
                                $this->db->where('id',$idinsertx);
                                $this->db->update('tb_detailgen');
                            }else{
                                // update id_stokdept di tabel detail 
                                $this->db->set('id_stokdept',$stokid);
                                $this->db->set('nobontr',$nobontr);
                                $this->db->set('pcs',$kurangpcs);
                                $this->db->set('kgs',$kurangkgs);
                                $this->db->set('harga',$deta['harga']);
                                $this->db->where('id',$datdet['id']);
                                $this->db->update('tb_detailgen');

                                $this->db->set('id_stokdept',$stokid);
                                $this->db->set('nobontr',$nobontr);
                                $this->db->set('pcs',$kurangpcs);
                                $this->db->set('kgs',$kurangkgs);
                                $this->db->set('harga',$deta['harga']);
                                $this->db->where('id',$datdet['id_detail']);
                                $this->db->update('tb_detail');
                            }
                            $pcskurangi = $datdet['pcs'] > 0 ? $kurangpcs : $kurangkgs;
                            $pcsnya -= $pcskurangi;
                        } while ($pcsnya > 0);
                    }else{
                        $iniquery = true;
                        $hasilnya = $this->db->get_where('barang',['id'=>$datdet['id_barang']])->row_array();
                        $this->session->set_flashdata('errornya',$hasilnya['nama_barang']. '('.$hasilnya['kode'].')');
                        $this->session->set_userdata('barangerror',$datdet['id_barang']);
                        break;
                    }
                }
            }
        }else{
            $iniquery = true;
            $this->session->set_flashdata('errornya','Data detail atau detailgen kosong, HUBUNGI PROGRAMMER !');
        }
        // Cek data temp yang akan dibuat BBL
        $datacekbbl = $this->db->get_where('tb_detail',['id_header'=>$id,'tempbbl'=>1]);
        if($datacekbbl->num_rows() > 0){
            $ceknomordok = '';
            foreach ($datacekbbl->result_array() as $bbl) {
                $this->db->select('id_perusahaan,kode_dok,dept_id,dept_tuju,nomor_dok,tgl,data_ok,ok_tuju,ok_valid,tgl_ok,tgl_tuju,user_ok,user_tuju');
                $this->db->from('tb_header');
                $this->db->join('tb_detail','tb_detail.id_header = tb_header.id','left');
                $this->db->where('tb_detail.id',$bbl['id_minta']);  
                $isiheader = $this->db->get();
                $xisiheader = $isiheader->row_array();
                if($ceknomordok != $xisiheader['nomor_dok']){
                    $hasilheader = $this->db->insert_batch('tb_header',$isiheader->result_array());
                    $idheader = $this->db->insert_id();
                    $this->db->where('id',$idheader);
                    $this->db->update('tb_header',['nomor_dok' => $xisiheader['nomor_dok'].'-A']);
                    $ceknomordok = $xisiheader['nomor_dok'];
                }else{
                    $idheader = $xisiheader['id'];
                }

                $isidetail = $this->db->get_where('tb_detail',['id' => $bbl['id_minta']])->row_array();
                $bbl['id'] = null;
                $this->db->insert('tb_detail',$bbl);
                $iddetail = $this->db->insert_id();
                $bbl['id_detail'] = $iddetail;
                $this->db->insert('tb_detailgen',$bbl);
                $iddetail2 = $this->db->insert_id();

                $this->db->set('id_header',$idheader);
                $this->db->set('pcs',$isidetail['pcs'].'- pcs',FALSE);
                $this->db->set('kgs',$isidetail['kgs'].'- kgs',FALSE);
                $this->db->where('id',$iddetail);
                $this->db->update('tb_detail');

                $this->db->set('id_header',$idheader);
                $this->db->set('pcs',$isidetail['pcs'].'- pcs',FALSE);
                $this->db->set('kgs',$isidetail['kgs'].'- kgs',FALSE);
                $this->db->where('id',$iddetail2);
                $this->db->update('tb_detailgen');
            }
        }
        //Hapus data detail awal yang pcs nya 0 dan masuk ke A
        $this->db->where('id_header',$id);
        $this->db->where('pcs',0);
        $this->db->where('kgs',0);
        $this->db->delete('tb_detail');

        if ($this->db->trans_status() === FALSE || $iniquery){
            $this->db->trans_rollback();
        }else{
            $jumlah = $this->db->get_where('tb_detail',['id_header'=>$id])->num_rows();
            $data = [
                'data_ok' => 1,
                'user_ok' => $this->session->userdata('id'),
                'tgl_ok' => date('Y-m-d H:i:s'),
                'jumlah_barang' => $jumlah
            ];
            $this->db->where('id',$id);
            $this->db->update('tb_header',$data);
            $this->helpermodel->isilog($this->db->last_query());
            $this->db->trans_commit();
        }
        return !$iniquery;
    }
    public function getdatagm($idbarang){
        $kondisi = [
            'periode' => kodebulan($this->session->userdata('bl')).$this->session->userdata('th'),
            'dept_id' => 'GM',
            'id_barang' => $idbarang
        ];
        $kondisi2 = [
            'pcs_akhir > ' => 0,
            'kgs_akhir > ' => 0 
        ];
        $this->db->select('stokdept.*,barang.nama_barang,barang.kode',FALSE);
        $this->db->from('stokdept');
        $this->db->join('barang','barang.id = stokdept.id_barang','left');
        $this->db->where($kondisi);
        $this->db->group_start();
        $this->db->or_where($kondisi2);
        $this->db->group_end();
        $hasil = $this->db->get();
        return $hasil;
    }
    public function getdatabarang($id){
        $this->db->where('id',$id);
        return $this->db->get('barang');
    }
    public function editnobontr($data){
        $update = [
            'id_stokdept' => $data['idstok'],
            'nobontr' => $data['nobontr']
        ];
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_detail',$update);
        $this->helpermodel->isilog($this->db->last_query());
        return $hasil;
    }
    public function simpandetailbarang()
    {
        $data = $_POST;
        unset($data['nama_barang']);
        $hasil =  $this->db->insert('tb_detail', $data);
        $idnya = $this->db->insert_id();
        $this->helpermodel->isilog($this->db->last_query());
        $data['id_detail'] = $idnya;
        $hasil =  $this->db->insert('tb_detailgen', $data);
        $idnya = $this->db->get_where('tb_detail', array('id_barang' => $data['id_barang'], 'id_header' => $data['id_header']))->row_array();
        // Isi data detmaterial
        $cek = $this->db->get_where('bom_barang', array('id_barang' => $data['id_barang']));
        if ($cek->num_rows() > 0) {
            foreach ($cek->result_array() as $kec) {
                $xdata = [
                    'id_header' => $data['id_header'],
                    'id_detail' => $idnya['id'],
                    'id_barang' => $kec['id_barang_bom'],
                    'persen' => $kec['persen'],
                    'kgs' => ($kec['persen'] / 100) * $data['kgs']
                ];
                $this->db->insert('tb_detmaterial', $xdata);
                $this->helpermodel->isilog($this->db->last_query());
            }
        }
        if ($hasil) {
            $this->db->where('id', $data['id_header']);
            $que = $this->db->get('tb_header')->row_array();
        }
        return $que;
    }
}