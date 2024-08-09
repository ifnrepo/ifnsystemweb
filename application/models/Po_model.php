<?php
class Po_model extends CI_Model
{
    public function getdata($kode)
    {
        $arrx = ['DO','IM'];
        $xjno = in_array($kode['jnpo'],$arrx) ? $kode['jnpo'].'/BL' : 'DO/'.$kode['jnpo'];
        unset($kode['jnpo']);
        $arrkondisi = [
            'id_perusahaan' => IDPERUSAHAAN,
            'SUBSTR(nomor_dok,4,5)' => $xjno,
            'kode_dok' => 'PO',
            'month(tgl)' => $this->session->userdata('bl'),
            'year(tgl)' => $this->session->userdata('th')
        ];
        $this->db->select('tb_header.*,supplier.nama_supplier as namasupplier');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->where($arrkondisi);
        $hasil = $this->db->get('tb_header');
        return $hasil->result_array();
    }
    public function getdatabyid($kode)
    {
        $this->db->select('tb_header.*,supplier.nama_supplier as namasupplier,supplier.alamat,supplier.kontak,catatan_po.header_po,catatan_po.catatan1,catatan_po.catatan2,catatan_po.catatan3');
        $this->db->join('dept', 'dept.dept_id=tb_header.dept_id', 'left');
        $this->db->join('supplier', 'supplier.id=tb_header.id_pemasok', 'left');
        $this->db->join('catatan_po', 'catatan_po.id_header=tb_header.id', 'left');
        $query = $this->db->get_where('tb_header', ['tb_header.id' => $kode]);
        return $query->row_array();
    }
    public function getdepttuju($kode)
    {
        $xkode = [];
        $hasil = [];
        $query = $this->db->get_where('dept', ['dept_id' => $kode])->row_array();
        if ($query) {
            for ($x = 0; $x <= strlen($query['pengeluaran']) / 2; $x++) {
                if (substr($query['pengeluaran'], ($x * 2) - 2, 2) != $kode) {
                    array_push($xkode, substr($query['pengeluaran'], ($x * 2) - 2, 2));
                }
            }
            $this->db->where_in('dept_id', $xkode);
            $this->db->order_by('departemen', 'asc');
            $hasil = $this->db->get('dept');
        }
        return $hasil;
    }
    public function getbon($kode)
    {
        $this->db->where($kode);
        $query = $this->db->get('tb_header');
        return $query->result_array();
    }
    public function getnomorpo($bl, $th, $jnpo)
    {
        $hasil = $this->db->query("SELECT MAX(SUBSTR(nomor_dok,15,3)) AS maxkode FROM tb_header 
        WHERE kode_dok = 'PO' AND MONTH(tgl)='" . $bl . "' AND YEAR(tgl)='" . $th . "' AND SUBSTR(nomor_dok,4,6) = '" . $jnpo . "' ")->row_array();
        return $hasil;
    }
    public function tambahdatapo()
    {
        $this->db->trans_start();
        $date = $this->session->userdata('th') . '-' . $this->session->userdata('bl') . '-' . date('d');
        $nomordok = nomorpo();
        $tambah = [
            'id_perusahaan' => IDPERUSAHAAN,
            'kode_dok' => 'PO',
            'dept_id' => 'PC',
            'dept_tuju' => 'SU',
            'nomor_dok' => $nomordok,
            'tgl' => $date
        ];
        $this->db->insert('tb_header', $tambah);
        $hasil = $this->db->insert_id();
        $catatan = [
         'id_header' => $hasil,
         'header_po' => 'Berdasarkan surat penawaran dari [namasupplier] tanggal [tgl], maka kami memesan barang-barang sebagai berikut :'
        ];
        $this->db->insert('catatan_po', $catatan);
        $this->db->trans_complete();
        return $hasil;
    }
    public function getdatadetailpo($data)
    {
        $this->db->select("a.*,b.namasatuan,b.kodesatuan,c.kode,c.nama_barang,c.kode as brg_id,d.keterangan as keter");
        $this->db->select("(select pcs from tb_detail b where b.id = a.id_minta) as pcsminta");
        $this->db->select("(select kgs from tb_detail b where b.id = a.id_minta) as kgsminta");
        $this->db->from('tb_detail a');
        $this->db->join('satuan b', 'b.id = a.id_satuan', 'left');
        $this->db->join('barang c', 'c.id = a.id_barang', 'left');
        $this->db->join('tb_detail d', 'a.id = d.id_po', 'left');
        // $this->db->join('tb_detail e', 'd.id = e.id_bbl', 'left');
        $this->db->where('a.id_header', $data);
        return $this->db->get()->result_array();
    }
    public function getdetailpobyid($data)
    {
        $this->db->select("a.*,b.namasatuan,b.kodesatuan,c.kode,c.nama_barang,c.kode as brg_id");
        $this->db->from('tb_detail a');
        $this->db->join('satuan b', 'b.id = a.id_satuan', 'left');
        $this->db->join('barang c', 'c.id = a.id_barang', 'left');
        $this->db->where('a.id', $data);
        return $this->db->get()->row_array();
    }
    public function updatepo($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }
    public function getbarangpo(){
        $this->db->select('*,tb_detail.id as iddetbbl');
        $this->db->from('tb_detail');
        $this->db->join('tb_header a','a.id = tb_detail.id_header','left');
        $this->db->join('barang b','b.id = tb_detail.id_barang','left');
        $this->db->where('a.id_perusahaan',IDPERUSAHAAN);
        $this->db->where('a.data_ok',1);
        $this->db->where('a.ok_valid',1);
        $this->db->where('a.ok_tuju',1);
        $this->db->where('a.ok_pp',1);
        $this->db->where('a.ok_pc',1);
        $this->db->where('a.kode_dok','BBL');
        $this->db->where('id_po',0);
        return $this->db->get();
    }

    public function adddetailpo($data){
        $jumlah = count($data['data']);
        $id = $data['id'];
        $this->db->trans_start();
        for($x=0;$x<$jumlah;$x++){
            $arrdat = $data['data'];
            $detail = $this->db->where('id',$arrdat[$x])->get('tb_detail')->row_array();
            $isi = [
                'id_header' => $id,
                'seri_barang' => $x,
                'id_barang' => $detail['id_barang'],
                'id_satuan' => $detail['id_satuan'],
                'kgs' => $detail['kgs'],
                'pcs' => $detail['pcs']
            ];
            $this->db->insert('tb_detail',$isi);
            $idsimpan = $this->db->insert_id();
            $this->db->where('id',$arrdat[$x])->update('tb_detail',['id_po'=>$idsimpan]);
            $itembarang = $this->db->where('id_header',$id)->get('tb_detail')->num_rows();
            $this->db->where('id',$id)->update('tb_header',['jumlah_barang'=>$itembarang]);
        }
        $hasil = $this->db->trans_complete();
        return $hasil;
    }

    public function hapusdetailpo($id){
        $detail = $this->db->where('id_po',$id)->get('tb_detail')->row_array();
        $xdetail = $this->db->where('id',$id)->get('tb_detail')->row_array();
        $this->db->trans_start();
        $this->db->where('id',$detail['id']);
        $this->db->update('tb_detail',['id_po'=>0]);
        $this->db->where('id',$id);
        $this->db->delete('tb_detail');
        $itembarang = $this->db->where('id_header',$xdetail['id_header'])->get('tb_detail')->num_rows();
        $this->db->where('id',$xdetail['id_header'])->update('tb_header',['jumlah_barang'=>$itembarang]);
        $hasil = $this->db->trans_complete();
        return $hasil;
    }


    public function updatedetail($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_detail', $data);
        return $query;
    }
    public function updatesupplier($data){
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_header',['id_pemasok' => $data['id_supplier']]);
        if($data['id_supplier']!='NULL'){
            $this->db->where('id',$data['id_supplier']);
            $sup = $this->db->get('supplier')->row_array();

            $kata = 'Berdasarkan surat penawaran dari '.trim($sup['nama_supplier']).' tanggal , maka kami memesan barang-barang sebagai berikut :';
            $this->db->set('header_po',$kata);
            $this->db->where('id_header',$data['id']);
            $this->db->update('catatan_po');
        }
        return $hasil;
    }
    public function updatebykolom($data){
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_header',$data);
        return $hasil;
    }
    public function updatekolom($tabel,$data,$kolom){
        $this->db->where($kolom,$data['id_header']);
        $hasil = $this->db->update($tabel,$data);
        return $hasil;
    }
    public function updatehargadetail($data){
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_detail',$data);
        return $hasil;
    }
    public function cekdetail($id){
        $this->db->select("*,sum(if(harga=0,1,0)) AS xharga,sum(if(pcs=0,kgs,pcs)*harga) AS totalharga");
        $this->db->from('tb_detail');
        $this->db->where('id_header',$id);
        return $this->db->get()->row_array();
    }
    public function simpanpo($data)
    {
        $jumlahrek = $this->db->get_where('tb_detail', ['id_header' => $data['id']])->num_rows();
        $data['jumlah_barang'] = $jumlahrek;
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }
    public function hapuspo($id)
    {
        $this->db->trans_start();
        $this->db->where('id', $id);
        $query = $this->db->get('tb_header')->row_array();
        if($query){
            $this->db->where('id_header',$id);
            $cekdetail = $this->db->get('tb_detail')->result_array();
            foreach ($cekdetail as $cekdata) {
                $this->db->where('id_po',$cekdata['id']);
                $this->db->update('tb_detail', ['id_po' => 0]);
            }
            $this->db->where('id_header', $id);
            $this->db->delete('tb_detmaterial');
            $this->db->where('id_header', $id);
            $this->db->delete('tb_detail');
            $this->db->where('id_header', $id);
            $this->db->delete('catatan_po');
        }
        $this->db->where('id', $id);
        $this->db->delete('tb_header');
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function editpo($data){
        $this->db->where('id',$data['id']);
        $hasil = $this->db->update('tb_header',$data);
        return $hasil;
    }
    public function cekfield($id,$kolom,$nilai){
        $this->db->where('id',$id);
        $this->db->where($kolom,$nilai);
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }
    public function resetdetail($id)
    {
        $this->db->trans_start();
        $que1 = $this->db->get_where('tb_detail', ['id_header' => $id])->result_array();
        foreach ($que1 as $data1) {
            $cek = $this->db->get_where('tb_detail', ['id' => $data1['id_minta']])->row_array();
            $data = [
                'pcs' => $cek['pcs'],
                'kgs' => $cek['kgs'],
                'tempbbl' => null
            ];
            $this->db->where('id', $data1['id']);
            $this->db->update('tb_detail', $data);
        }
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function simpanheaderout($id)
    {
        $iniquery = false;
        $this->db->trans_begin();
        $datadetail = $this->db->get_where('tb_detail', ['id_header' => $id])->result_array();
        $no = 0;
        foreach ($datadetail as $datdet) {
            if ($this->session->userdata('deptsekarang') == 'GM') {
                if ($datdet['nobontr'] == '') {
                    $iniquery = true;
                    $this->session->set_flashdata('errornya', 'Nobontr Kosong');
                    break;
                }
            }
            $no++;
            $kondisi = [
                'id_barang' => $datdet['id_barang'],
                'periode' => kodebulan($this->session->userdata('bl')) . $this->session->userdata('th'),
                'dept_id' => $this->session->userdata('deptsekarang')
            ];
            $this->db->select('stokdept.*,sum(stokdept.pcs_akhir) as xpcs_akhir,sum(stokdept.kgs_akhir) as xkgs_akhir');
            $this->db->from('stokdept');
            $this->db->where($kondisi);
            $cekdata = $this->db->get();
            // $cekdata = $this->db->get_where('stokdept',$kondisi);
            $jmll = $cekdata->num_rows();
            $deta = $cekdata->row_array();
            if ($datdet['pcs'] > 0 || $datdet['kgs'] > 0) {
                if ((($deta['xpcs_akhir'] >= $datdet['pcs']) || ($deta['xkgs_akhir'] >= $datdet['kgs'])) && $jmll > 0) {
                    $pcsnya = $datdet['pcs'] > 0 ? $datdet['pcs'] : $datdet['kgs'];
                    $pcsasli = $datdet['pcs'];
                    $kgsasli = $datdet['kgs'];
                    $loopke = 0;
                    do {
                        $loopke += 1;
                        $where = "id_barang = " . $datdet['id_barang'] . " AND periode = '" . kodebulan($this->session->userdata('bl')) . $this->session->userdata('th') . "' AND 
                        (pcs_akhir > 0 OR kgs_akhir > 0)";
                        $this->db->where($where);
                        $arrstokdept = $this->db->order_by('tgl,urut')->get('stokdept')->row_array();
                        $nobontr = $this->session->userdata('currdept') == 'GS' ? $arrstokdept['nobontr'] : $datdet['nobontr'];
                        $stokid = $arrstokdept['id'];
                        if (($pcsasli > $arrstokdept['pcs_akhir']) || ($kgsasli > $arrstokdept['kgs_akhir'])) {
                            $kurangpcs = $arrstokdept['pcs_akhir'];
                            $kurangkgs = $arrstokdept['kgs_akhir'];
                        } else {
                            $kurangpcs = $pcsasli;
                            $kurangkgs = $kgsasli;
                        }
                        // update kgs_akhir di tabel stokdept
                        $this->db->set('pcs_keluar', 'pcs_keluar + ' . $kurangpcs, FALSE);
                        $this->db->set('kgs_keluar', 'kgs_keluar + ' . $kurangkgs, FALSE);
                        $this->db->set('pcs_akhir', 'pcs_akhir-' . $kurangpcs, FALSE);
                        $this->db->set('kgs_akhir', 'kgs_akhir-' . $kurangkgs, FALSE);
                        $this->db->where('id', $stokid);
                        $this->db->update('stokdept');

                        $pcsasli -= $kurangpcs;
                        $kgsasli -= $kurangkgs;

                        if ($loopke > 1) {
                            // insert ke tabel detail apabila stokdept menguragi 2 rekord
                            unset($datdet['id']);
                            $this->db->insert('tb_detail', $datdet);
                            $idinsert = $this->db->insert_id();
                            $this->db->set('id_stokdept', $stokid);
                            $this->db->set('nobontr', $nobontr);
                            $this->db->set('pcs', $kurangpcs);
                            $this->db->set('kgs', $kurangkgs);
                            $this->db->where('id', $idinsert);
                            $this->db->update('tb_detail');
                        } else {
                            // update id_stokdept di tabel detail 
                            $this->db->set('id_stokdept', $stokid);
                            $this->db->set('nobontr', $nobontr);
                            $this->db->set('pcs', $kurangpcs);
                            $this->db->set('kgs', $kurangkgs);
                            $this->db->where('id', $datdet['id']);
                            $this->db->update('tb_detail');
                        }
                        $pcskurangi = $datdet['pcs'] > 0 ? $kurangpcs : $kurangkgs;
                        $pcsnya -= $pcskurangi;
                    } while ($pcsnya > 0);
                } else {
                    $iniquery = true;
                    $this->session->set_flashdata('errornya', $no);
                    break;
                }
                // if($deta['pcs_akhir'] >= $datdet['pcs'] && $deta['pcs_akhir'] > 0 && $jmll > 0){
                //     $this->db->set('pcs_keluar','pcs_keluar + '.$datdet['pcs'],FALSE);
                //     $this->db->set('kgs_keluar','kgs_keluar + '.$datdet['kgs'],FALSE);
                //     $this->db->set('pcs_akhir','(pcs_akhir-pcs_masuk)-(pcs_keluar + '.$datdet['pcs'].')',FALSE);
                //     $this->db->set('kgs_akhir','(kgs_akhir-kgs_masuk)-(kgs_keluar + '.$datdet['kgs'].')',FALSE);
                //     $this->db->where($kondisi);
                //     $this->db->update('stokdept');
                // }else{
                //     $iniquery = true;
                //     $this->session->set_flashdata('errornya',$no);
                //     break;
                // }
            }
        }
        // Cek data temp yang akan dibuat BBL
        $datacekbbl = $this->db->get_where('tb_detail', ['id_header' => $id, 'tempbbl' => 1]);
        if ($datacekbbl->num_rows() > 0) {
            $this->db->select('id_perusahaan,kode_dok,dept_id,dept_tuju,nomor_dok,tgl,data_ok,ok_tuju,ok_valid,tgl_ok,tgl_tuju,user_ok,user_tuju');
            $this->db->from('tb_header');
            $this->db->where('id_keluar', $id);
            $isiheader = $this->db->get();
            $hasilheader = $this->db->insert_batch('tb_header', $isiheader->result_array());
            $idheader = $this->db->insert_id();
            $xisiheader = $isiheader->row_array();
            $this->db->where('id', $idheader);
            $this->db->update('tb_header', ['nomor_dok' => $xisiheader['nomor_dok'] . '-A']);
            foreach ($datacekbbl->result_array() as $bbl) {
                $isidetail = $this->db->get_where('tb_detail', ['id' => $bbl['id_minta']])->row_array();
                $bbl['id'] = null;
                $this->db->insert('tb_detail', $bbl);
                $iddetail = $this->db->insert_id();
                $this->db->set('id_header', $idheader);
                $this->db->set('pcs', $isidetail['pcs'] . '- pcs', FALSE);
                $this->db->set('kgs', $isidetail['kgs'] . '- kgs', FALSE);
                $this->db->where('id', $iddetail);
                $this->db->update('tb_detail');
            }
        }
        //Hapus data detail awal yang pcs nya 0 dan masuk ke A
        $this->db->where('id_header', $id);
        $this->db->where('pcs', 0);
        $this->db->where('kgs', 0);
        $this->db->delete('tb_detail');

        if ($this->db->trans_status() === FALSE || $iniquery) {
            $this->db->trans_rollback();
        } else {
            $jumlah = $this->db->get_where('tb_detail', ['id_header' => $id])->num_rows();
            $data = [
                'data_ok' => 1,
                'user_ok' => $this->session->userdata('id'),
                'tgl_ok' => date('Y-m-d H:i:s'),
                'jumlah_barang' => $jumlah
            ];
            $this->db->where('id', $id);
            $this->db->update('tb_header', $data);
            $this->db->trans_commit();
        }
        return !$iniquery;
    }
    public function getdatagm($idbarang)
    {
        $kondisi = [
            'periode' => kodebulan($this->session->userdata('bl')) . $this->session->userdata('th'),
            'dept_id' => 'GM',
            'id_barang' => $idbarang
        ];
        $kondisi2 = [
            'pcs_akhir > ' => 0,
            'kgs_akhir > ' => 0
        ];
        $this->db->select('stokdept.*,barang.nama_barang,barang.kode', FALSE);
        $this->db->from('stokdept');
        $this->db->join('barang', 'barang.id = stokdept.id_barang', 'left');
        $this->db->where($kondisi);
        $this->db->group_start();
        $this->db->or_where($kondisi2);
        $this->db->group_end();
        $hasil = $this->db->get();
        return $hasil;
    }
    public function editnobontr($data)
    {
        $update = [
            'id_stokdept' => $data['idstok'],
            'nobontr' => $data['nobontr']
        ];
        $this->db->where('id', $data['id']);
        $hasil = $this->db->update('tb_detail', $update);
        return $hasil;
    }
}
