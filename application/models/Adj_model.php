<?php
class Adj_model extends CI_Model
{
    public function cekfield($id,$kolom,$nilai){
        $this->db->where('id',$id);
        $this->db->where($kolom,$nilai);
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }

    public function getdatabyid($id)
    {
        $this->db->select('tb_header.*,dept.departemen');
        $this->db->join('dept', 'dept.dept_id=tb_header.dept_id', 'left');
        $this->db->where('tb_header.id', $id);
        return $this->db->get('tb_header')->row_array();
    }
    public function tambahadj($data)
    {
        $kode = $data['nomor_dok'];
        $query = $this->db->insert('tb_header', $data);
        $kodex = $this->db->insert_id();
        $this->helpermodel->isilog($this->db->last_query());
        return $kodex;
    }
    public function getnomoradj($bl, $th, $asal)
    {
        $hasil = $this->db->query("SELECT MAX(SUBSTR(nomor_dok,11,3)) AS maxkode FROM tb_header 
        WHERE kode_dok = 'ADJ' AND MONTH(tgl)='" . $bl . "' AND YEAR(tgl)='" . $th . "' AND dept_id = '" . $asal . "' ")->row_array();
        return $hasil;
    }
    public function getdataadj()
    {
        $this->db->select('tb_header.*,user.name,(select count(*) from tb_detail where id_header = tb_header.id) as jmlrex');
        $this->db->join('user', 'user.id=tb_header.user_ok', 'left');
        $this->db->where('kode_dok','ADJ');
        $this->db->where('dept_id',$this->session->userdata('currdept'));
        $this->db->where('month(tgl)', $this->session->userdata('bl'));
        $this->db->where('year(tgl)', $this->session->userdata('th'));
        return $this->db->get('tb_header')->result_array();
    }
    public function hapusdataadj($id)
    {
        $this->db->trans_start();
        $this->db->where('id_header', $id);
        $this->db->delete('tb_detmaterial');
        $this->db->where('id_header', $id);
        $this->db->delete('tb_detail');
        $this->db->where('id', $id);
        $this->db->delete('tb_header');
        $this->helpermodel->isilog($this->db->last_query());
        $hasil = $this->db->trans_complete();
        return $hasil;
    }
    public function getspecbarang($mode, $spec)
    {
        if ($mode == 0) {
            $this->db->select('*,barang.id as idx');
            $this->db->join('satuan','satuan.id = barang.id_satuan','left');
            $this->db->like('nama_barang', $spec);
            $this->db->order_by('nama_barang', 'ASC');
            $query = $this->db->get_where('barang', array('act' => 1))->result_array();
        } else {
            $this->db->select('*,barang.id as idx');
            $this->db->join('satuan','satuan.id = barang.id_satuan','left');
            $this->db->like('kode', $spec);
            $this->db->order_by('kode', 'ASC');
            $query = $this->db->get_where('barang', array('act' => 1))->result_array();
        }
        return $query;
    }
    public function simpandetailbarang()
    {
        $data = $_POST;
        unset($data['nama_barang']);
        $hasil =  $this->db->insert('tb_detail', $data);
        $this->helpermodel->isilog($this->db->last_query());
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
            }
        }
        if ($hasil) {
            $this->db->where('id', $data['id_header']);
            $que = $this->db->get('tb_header')->row_array();
        }
        return $que;
    }
    public function getdatadetailadj($data)
    {
        $this->db->select("tb_detail.*,satuan.namasatuan,satuan.kodesatuan,barang.kode,barang.nama_barang,barang.kode as brg_id");
        $this->db->from('tb_detail');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->where('id_header', $data);
        return $this->db->get()->result_array();
    }
    public function getdatadetailadjbyid($data)
    {
        $this->db->select("tb_detail.*,satuan.namasatuan,barang.kode,barang.nama_barang,satuan.id as id_satuan");
        $this->db->from('tb_detail');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->where('tb_detail.id', $data);
        return $this->db->get()->result();
    }
    public function updatedetailbarang()
    {
        $data = $_POST;
        unset($data['nama_barang']);
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_detail', $data);
        $this->helpermodel->isilog($this->db->last_query());

        $idnya = $this->db->get_where('tb_detail', array('id_barang' => $data['id_barang'], 'id_header' => $data['id_header']))->row_array();
        $this->db->where('id_header', $data['id_header']);
        $this->db->delete('tb_detmaterial');
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
            }
        }
        if ($query) {
            $this->db->where('id', $data['id_header']);
            $que = $this->db->get('tb_header')->row_array();
        }
        return $que;
    }
    public function hapusdetailadj($id)
    {
        $this->db->trans_start();
        $cek = $this->db->get_where('tb_detail', ['id' => $id])->row_array();
        $this->db->where('id_detail', $id);
        $hasil = $this->db->delete('tb_detmaterial');
        $this->db->where('id', $id);
        $this->db->delete('tb_detail');
        $this->helpermodel->isilog($this->db->last_query());
        $hasil = $this->db->trans_complete();
        if ($hasil) {
            $this->db->where('id', $cek['id_header']);
            $que = $this->db->get('tb_header')->row_array();
        }
        return $que;
    }
    public function simpanadj($data)
    {
        $jmlrec = $this->db->query("Select count(id) as jml from tb_detail where id_header = " . $data['id'])->row_array();
        $data['jumlah_barang'] = $jmlrec['jml'];
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        $this->helpermodel->isilog($this->db->last_query());
        return $query;
    }
    //End Adj Model
    public function depttujupb($kode)
    {
        $hasil = '';
        $depo = '';
        if ($kode == 'GW') {
            $depo = 'GS,';
        } else {
            $depo = 'GM,GP,GF,GW,GS,';
            if ($kode == 'RR' || $kode == 'FG') {
                $depo .= 'FN,';
            }
        }
        $cek = $this->db->get_where('dept', ['dept_id' => $kode])->row_array();
        for ($i = 1; $i <= strlen($cek['penerimaan']) / 2; $i++) {
            $kodex = substr($cek['penerimaan'], ($i * 2) - 2, 2);
            $pos = strpos($depo, $kodex);
            if ($pos !== false) {
                $this->db->where('dept_id', $kodex);
                $gudang = $this->db->get('dept')->row_array();
                if ($gudang) {
                    $selek = $this->session->userdata('tujusekarang') == $gudang['dept_id'] ? 'selected' : '';
                    $hasil .= "<option value='" . $gudang['dept_id'] . "' rel='" . $gudang['departemen'] . "' " . $selek . ">" . $gudang['departemen'] . "</option>";
                }
            }
        }
        return $hasil;
    }

    public function updatepb($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }







    
   


}
