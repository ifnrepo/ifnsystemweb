<?php
class Benangmodel extends CI_Model
{

    public function cekfield($id, $kolom, $nilai)
    {
        $this->db->where('id', $id);
        $this->db->where($kolom, $nilai);
        $hasil = $this->db->get('tb_header');
        return $hasil;
    }
    public function validasipb($data)
    {
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        return $query;
    }

    public function getdata_filter($data)
    {
        $this->db->select('tb_header.*,user.name,(select count(*) from tb_detail where id_header = tb_header.id) as jmlrex');
        $this->db->join('user', 'user.id=tb_header.user_ok', 'left');
        $this->db->where('kode_dok', 'BP');
        $this->db->where('dept_id', $data['dept_id']);
        $this->db->where('dept_tuju', $data['dept_tuju']);
        if ($data['level'] == 2) {
            $this->db->where('data_ok', 1);
            $this->db->where('ok_valid', 0);
        }
        $this->db->where('month(tgl)', $this->session->userdata('bl'));
        $this->db->where('year(tgl)', $this->session->userdata('th'));
        return $this->db->get('tb_header')->result_array();
    }
    public function hapusdetailpb($id)
    {
        $this->db->trans_start();
        $cek = $this->db->get_where('tb_detail', ['id' => $id])->row_array();
        $this->db->where('id_detail', $id);
        $hasil = $this->db->delete('tb_detmaterial');
        $this->db->where('id', $id);
        $this->db->delete('tb_detailgen');
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

    public function tambah_header($data)
    {
        $this->db->insert('tb_header', $data);
        $id = $this->db->insert_id();
        return $this->db->get_where('tb_header', ['id' => $id])->row_array();
    }


    public function getdataid_header($id)
    {
        $this->db->select('tb_header.*,dept.departemen');
        $this->db->join('dept', 'dept.dept_id=tb_header.dept_id', 'left');
        $this->db->where('tb_header.id', $id);
        return $this->db->get('tb_header')->row_array();
    }

    public function getdatabyid($id)
    {
        $this->db->select('tb_header.*,dept.departemen');
        $this->db->join('dept', 'dept.dept_id=tb_header.dept_id', 'left');
        $this->db->where('tb_header.id', $id);
        return $this->db->get('tb_header')->row_array();
    }

    public function getdatadetailpb($id)
    {
        $this->db->select("tb_detail.*,satuan.namasatuan,satuan.kodesatuan,barang.kode,barang.nama_barang,barang.kode as brg_id,CONCAT(TRIM(po),'#',TRIM(item),IF(dis > 0,' dis ',''),if(dis > 0,dis,'')) AS sku");
        $this->db->from('tb_detail');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->where('id_header', $id);
        return $this->db->get()->result_array();
    }

    public function getSaldo_Terkini($id)
    {
        $id_header = is_array($id) ? $id['id'] : $id;

        $tgl = $this->db->get_where('tb_header', ['id' => $id_header])->row_array();
        $tanggal = $tgl['tgl'];
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = $bulan . $tahun;


        $this->db->select('
            tb_detail.id_header, 
            stokdept.kgs_akhir,
            stokdept.id_barang, 
            stokdept.periode, 
            barang.nama_barang
        ');
        $this->db->from('tb_detail');
        $this->db->join('stokdept', 'stokdept.id_barang = tb_detail.id_barang', 'left');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'barang.id = stokdept.id_barang', 'left');
        $this->db->where('stokdept.periode', $periode);
        $this->db->where('tb_header.id', $id_header);
        $cek_saldo_sekarang = $this->db->get()->result_array();


        if (empty($cek_saldo_sekarang)) {
            $periode_sebelumnya = date('mY', strtotime("-1 month", strtotime($tanggal)));

            $this->db->select('
                tb_detail.id_header, 
                stokdept.kgs_akhir,
                stokdept.id_barang, 
                stokdept.periode, 
                barang.nama_barang
            ');
            $this->db->from('tb_detail');
            $this->db->join('stokdept', 'stokdept.id_barang = tb_detail.id_barang', 'left');
            $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
            $this->db->join('barang', 'barang.id = stokdept.id_barang', 'left');
            $this->db->where('stokdept.periode', $periode_sebelumnya);
            $this->db->where('tb_header.id', $id_header);
            $cek_saldo_sekarang = $this->db->get()->row_array();
        }

        return $cek_saldo_sekarang;
    }



    public function simpanpb($data)
    {
        $jmlrec = $this->db->query("Select count(id) as jml from tb_detail where id_header = " . $data['id'])->row_array();
        $data['jumlah_barang'] = $jmlrec['jml'];
        $this->db->where('id', $data['id']);
        $query = $this->db->update('tb_header', $data);
        $this->helpermodel->isilog($this->db->last_query());


        $this->db->delete('tb_detailgen', ['id_header' => $data['id']]);

        //Isi data ke detailge
        $datadet = $this->db->get_where('tb_detail', ['id_header' => $data['id']]);
        foreach ($datadet->result_array() as $keydet) {
            $keydet['id_detail'] = $keydet['id'];
            unset($keydet['id']);
            $this->db->insert('tb_detailgen', $keydet);
        }

        return $query;
    }

    public function hapusdata($id)
    {
        $this->db->trans_start();
        $this->db->where('id_header', $id);
        $this->db->delete('catatan_po');
        $this->db->where('id_header', $id);
        $this->db->delete('tb_detmaterial');
        $this->db->where('id_header', $id);
        $this->db->delete('tb_detailgen');
        $this->db->where('id_header', $id);
        $this->db->delete('tb_detail');
        $this->db->where('id', $id);
        $this->db->delete('tb_header');
        $this->helpermodel->isilog($this->db->last_query());
        $hasil = $this->db->trans_complete();
        return $hasil;
    }



    public function tambahdataout($kode)
    {
        $this->db->where('id', $kode['id']);
        return $this->db->update('tb_header', ['ok_valid' => 1]);
    }

    public function getdataid_in($id)
    {
        return $this->db->get_where('tb_detail', ['id' => $id])->row_array();
    }

    public function updatedata_in($data)
    {
        $this->db->where('id', $data['id']);
        return $this->db->update('tb_detail', $data);
    }

    public function Kgs_keluar($tanggal, $kgs, $id_barang, $dept_id)
    {
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = $bulan . $tahun;

        $periode_sebelumnya = date('mY', strtotime("-1 month", strtotime($tanggal)));


        $this->db->select('kgs_akhir');
        $this->db->from('stokdept');
        $this->db->where('periode', $periode_sebelumnya);
        $this->db->where('id_barang', $id_barang);
        $this->db->where('dept_id', $dept_id);
        $cek_saldo = $this->db->get()->row_array();

        $saldo_awal_kgs = $cek_saldo ? $cek_saldo['kgs_akhir'] : 0;


        $this->db->select('id, kgs_masuk, kgs_keluar');
        $this->db->from('stokdept');
        $this->db->where('periode', $periode);
        $this->db->where('id_barang', $id_barang);
        $saldo = $this->db->get()->row_array();

        if ($saldo) {

            $new_kgs_keluar = $saldo['kgs_keluar'] + $kgs;
            $new_kgs_akhir = $saldo_awal_kgs + $saldo['kgs_masuk'] - $new_kgs_keluar;

            $this->db->set('kgs_keluar', $new_kgs_keluar);
            $this->db->set('kgs_awal', $saldo_awal_kgs);
            $this->db->set('kgs_akhir', $new_kgs_akhir);
            $this->db->where('id', $saldo['id']);
            return $this->db->update('stokdept');
        } else {
            $new_kgs_akhir = $saldo_awal_kgs - $kgs;
            $data = [
                'kgs_awal' => $saldo_awal_kgs,
                'kgs_masuk' => 0,
                'kgs_keluar' => $kgs,
                'kgs_akhir' => $new_kgs_akhir,
                'periode' => $periode,
                'id_barang' => $id_barang,
                'dept_id' => $dept_id
            ];
            return  $this->db->insert('stokdept', $data);
        }
    }




    // public function getUkuranLike($inputan)
    // {
    //     $this->db->group_start();
    //     $this->db->like('nama_barang', $inputan);
    //     $this->db->group_end();
    //     $query = $this->db->get('barang');
    //     return $query->result_array();
    // }
    public function getUkuranLike($inputan)
    {
        $this->db->group_start();
        $this->db->like('ukuran_benang', $inputan);
        $this->db->or_like('warna_benang', $inputan);
        $this->db->group_end();
        $this->db->where('barang_id !=', 0);
        $query = $this->db->get('benang');
        return $query->result_array();
    }
    public function getWarnaLike($warna)
    {
        $this->db->group_start();
        $this->db->like('warna_benang', $warna);
        $this->db->group_end();
        $this->db->where('barang_id !=', 0);
        $this->db->group_by('warna_benang');
        $query = $this->db->get('benang');
        return $query->result_array();
    }



    public function simpan_spek()
    {
        $data = $_POST;
        unset($data['filter_benang']);
        unset($data['filter_warna']);


        $data['id_barang'] = $data['barang_id'];
        $data['warna_benang'] = $data['warna_benang'];

        unset($data['barang_id']);


        return $this->db->insert('tb_detail', $data);
    }

    public function simpanDetail($id)
    {
        $keterangan =  $this->input->post('keterangan');
        $speck_json = $this->input->post('speck_benang');
        $specks = json_decode($speck_json, true);

        if (!empty($specks)) {
            $data_insert = [];
            foreach ($specks as $s) {
                $data_insert[] = [
                    'id_header' => $id,
                    'id_satuan'   => 22,
                    'id_barang' => isset($s['barang_id']) ? $s['barang_id'] : null,
                    'keterangan' => $keterangan,
                ];
            }
            $this->db->insert_batch('tb_detail', $data_insert);
        }
    }



    public function getdataByid_all($id)
    {
        $this->db->select('
            tb_detail.id, 
            tb_detail.id_header, 
            tb_detail.id_barang, 
            tb_detail.id_satuan,
            tb_detail.warna_benang, 
            tb_detail.keterangan, 
            tb_header.lokasi_rak,
            tb_header.nomor_dok,
            barang.nama_barang,
            satuan.kodesatuan
        ');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->group_by('tb_detail.warna_benang');
        $this->db->where('tb_detail.id_header', $id);
        return $this->db->get()->result_array();
    }


    public function GetDetailWarna($warna)
    {
        $this->db->select('
        tb_detail.id, 
        tb_detail.id_header, 
        tb_detail.id_barang, 
        tb_detail.id_satuan,
        tb_detail.warna_benang, 
        tb_detail.keterangan, 
        barang.nama_barang,
        satuan.kodesatuan
    ');
        $this->db->from('tb_detail');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->where('tb_detail.warna_benang', $warna);
        return $this->db->get()->result_array();
    }
    public function GetNomorDok($warna)
    {
        $this->db->select('
            tb_detail.id,
            tb_detail.id_header,
            tb_detail.warna_benang,
            tb_header.nomor_dok
        ');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->where('tb_detail.warna_benang', $warna);
        return $this->db->get()->row_array();
    }


    public function GetSaldo_masuk($id)
    {
        $this->db->select("*, DATE_FORMAT(tanggal, '%m%Y') AS bulan_tahun");
        $this->db->from('benang_in_mutasi');
        $this->db->where('tb_detail_id', $id);
        $this->db->group_by("DATE_FORMAT(tanggal, '%m%Y')");
        $this->db->order_by('bulan_tahun', 'DESC');
        return $this->db->get()->result_array();
    }

    public function GetSaldo_keluar($id)
    {
        $this->db->select("*, DATE_FORMAT(tanggal, '%m%Y') AS bulan_tahun");
        $this->db->from('benang_out_mutasi');
        $this->db->group_by("DATE_FORMAT(tanggal, '%m%Y')");
        $this->db->order_by('bulan_tahun', 'DESC');
        $this->db->where('tb_detail_id', $id);
        return $this->db->get()->result_array();
    }

    public function GetViewsaldo($bulan_tahun, $tb_detail_id)
    {
        return $this->db
            ->where("DATE_FORMAT(tanggal, '%m%Y') =", $bulan_tahun)
            ->where('tb_detail_id', $tb_detail_id)
            ->order_by('tanggal', 'DESC')
            ->get('benang_in_mutasi')
            ->result_array();
    }
    public function GetViewsaldo_keluar($bulan_tahun, $tb_detail_id)
    {
        return $this->db
            ->where("DATE_FORMAT(tanggal, '%m%Y') =", $bulan_tahun)
            ->where('tb_detail_id', $tb_detail_id)
            ->order_by('tanggal', 'DESC')
            ->get('benang_out_mutasi')
            ->result_array();
    }

    public function GetHeaderView($tb_detail_id)
    {
        $this->db->select('
            tb_detail.id,
            tb_detail.id_header,
            tb_detail.id_barang,
            tb_detail.id_satuan,
            tb_header.lokasi_rak,
            tb_header.nomor_dok,
            barang.nama_barang,
            satuan.kodesatuan
        ');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->where('tb_detail.id', $tb_detail_id);
        return $this->db->get()->row_array();
    }

    public function GetHeader_Saldo($id)
    {
        $this->db->select('
            tb_detail.id,
            tb_detail.id_header,
            tb_detail.id_barang,
            tb_detail.id_satuan,
            tb_header.lokasi_rak,
            tb_header.nomor_dok,
            barang.nama_barang,
            satuan.kodesatuan
        ');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->where('tb_detail.id', $id);
        return $this->db->get()->row_array();
    }


    public function GetHeaderView_saldo($id_header)
    {
        $this->db->select('
            tb_detail.id_header,
            tb_detail.id_barang,
            tb_detail.id_satuan,
            tb_header.id,
            tb_header.lokasi_rak,
            tb_header.nomor_dok,
            barang.nama_barang,
            satuan.kodesatuan
        ');
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('satuan', 'satuan.id = tb_detail.id_satuan', 'left');
        $this->db->where('tb_header.id', $id_header);
        return $this->db->get()->row_array();
    }



    public function hapus_spek($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('benang');
    }
    public function hapus_histori_salmas($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('benang_in_mutasi');
    }
    public function hapus_histori_salkel($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('benang_out_mutasi');
    }





    public function InSaldo($tanggal, $jumlah, $id_barang)
    {
        // Ambil bulan dan tahun dari tanggal input
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = $bulan . $tahun;

        // Ambil saldo akhir dari periode sebelumnya
        $periode_sebelumnya = date('mY', strtotime("-1 month", strtotime($tanggal)));
        $this->db->select('kgs_akhir');
        $this->db->from('stokdept');
        $this->db->where('periode', $periode_sebelumnya);
        $this->db->where('id_barang', $id_barang);
        $cek_saldo = $this->db->get()->row_array();

        $saldo_awal_kgs = $cek_saldo ? $cek_saldo['kgs_akhir'] : 0;

        // Cek apakah data periode yang diinput sudah ada
        $this->db->select('id, kgs_masuk, kgs_keluar');
        $this->db->from('stokdept');
        $this->db->where('periode', $periode);
        $this->db->where('id_barang', $id_barang);
        $saldo = $this->db->get()->row_array();

        if ($saldo) {
            $new_kgs_masuk = $saldo['kgs_masuk'] + $jumlah;
            $new_kgs_akhir = $saldo_awal_kgs + $new_kgs_masuk - $saldo['kgs_keluar'];

            $this->db->set('kgs_masuk', $new_kgs_masuk);
            $this->db->set('kgs_awal', $saldo_awal_kgs);
            $this->db->set('kgs_akhir', $new_kgs_akhir);
            $this->db->where('id', $saldo['id']);
            $this->db->update('stokdept');

            $last_kgs_akhir = $new_kgs_akhir;
        } else {
            $new_kgs_akhir = $saldo_awal_kgs + $jumlah;

            $data = [
                'kgs_awal' => $saldo_awal_kgs,
                'kgs_masuk' => $jumlah,
                'kgs_keluar' => 0,
                'kgs_akhir' => $new_kgs_akhir,
                'periode' => $periode,
                'id_barang' => $id_barang,
                'dept_id' => 'FN'
            ];
            $this->db->insert('stokdept', $data);

            $last_kgs_akhir = $new_kgs_akhir;
        }

        // Update semua periode setelah periode input secara berantai
        $this->db->select('id, kgs_masuk, kgs_keluar, periode');
        $this->db->from('stokdept');
        $this->db->where('periode >', $periode);
        $this->db->where('id_barang', $id_barang);
        $this->db->order_by('periode', 'ASC');
        $next_saldos = $this->db->get()->result_array();

        foreach ($next_saldos as $next) {
            $new_kgs_awal = $last_kgs_akhir;
            $new_kgs_akhir = $new_kgs_awal + $next['kgs_masuk'] - $next['kgs_keluar'];

            $this->db->set('kgs_awal', $new_kgs_awal);
            $this->db->set('kgs_akhir', $new_kgs_akhir);
            $this->db->where('id', $next['id']);
            $this->db->update('stokdept');

            $last_kgs_akhir = $new_kgs_akhir;
        }
    }
    public function OutSaldo($tanggal, $jumlah, $id_barang)
    {
        $bulan = date('m', strtotime($tanggal));
        $tahun = date('Y', strtotime($tanggal));
        $periode = $bulan . $tahun;

        $periode_sebelumnya = date('mY', strtotime("-1 month", strtotime($tanggal)));


        $this->db->select('kgs_akhir');
        $this->db->from('stokdept');
        $this->db->where('periode', $periode_sebelumnya);
        $this->db->where('id_barang', $id_barang);
        $cek_saldo = $this->db->get()->row_array();

        $saldo_awal_kgs = $cek_saldo ? $cek_saldo['kgs_akhir'] : 0;

        // Cek apakah data sudah ada untuk periode ini
        $this->db->select('id, kgs_masuk, kgs_keluar');
        $this->db->from('stokdept');
        $this->db->where('periode', $periode);
        $this->db->where('id_barang', $id_barang);
        $saldo = $this->db->get()->row_array();

        if ($saldo) {
            $new_kgs_keluar = $saldo['kgs_keluar'] + $jumlah;
            $new_kgs_akhir = $saldo_awal_kgs + $saldo['kgs_masuk'] - $new_kgs_keluar;

            $this->db->set('kgs_keluar', $new_kgs_keluar);
            $this->db->set('kgs_awal', $saldo_awal_kgs);
            $this->db->set('kgs_akhir', $new_kgs_akhir);
            $this->db->where('id', $saldo['id']);
            $this->db->update('stokdept');

            $last_kgs_akhir = $new_kgs_akhir;
        } else {
            $new_kgs_akhir = $saldo_awal_kgs - $jumlah;

            $data = [
                'kgs_awal' => $saldo_awal_kgs,
                'kgs_masuk' => 0,
                'kgs_keluar' => $jumlah,
                'kgs_akhir' => $new_kgs_akhir,
                'periode' => $periode,
                'id_barang' => $id_barang,
                'dept_id' => 'FN'
            ];
            $this->db->insert('stokdept', $data);

            $last_kgs_akhir = $new_kgs_akhir;
        }

        // Update semua periode setelah periode input secara berantai
        $this->db->select('id, kgs_masuk, kgs_keluar, periode');
        $this->db->from('stokdept');
        $this->db->where('periode >', $periode);
        $this->db->where('id_barang', $id_barang);
        $this->db->order_by('periode', 'ASC');
        $next_saldos = $this->db->get()->result_array();

        foreach ($next_saldos as $next) {
            $new_kgs_awal = $last_kgs_akhir;
            $new_kgs_akhir = $new_kgs_awal + $next['kgs_masuk'] - $next['kgs_keluar'];

            $this->db->set('kgs_awal', $new_kgs_awal);
            $this->db->set('kgs_akhir', $new_kgs_akhir);
            $this->db->where('id', $next['id']);
            $this->db->update('stokdept');

            $last_kgs_akhir = $new_kgs_akhir;
        }
    }




    public function hapusSaldo_masuk($tanggal, $jumlah, $id_barang)
    {
        $tahun = date('Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));

        $periode = $bulan . $tahun;

        $this->db->select('id, kgs_masuk, kgs_akhir');
        $this->db->from('stokdept');
        $this->db->where('periode', $periode);
        $this->db->where('id_barang', $id_barang);
        $saldo = $this->db->get()->row_array();
        if ($saldo) {
            $new_kgs_in = $saldo['kgs_masuk'] - $jumlah;
            $new_kgs_akhir = $saldo['kgs_akhir'] - $jumlah;

            $this->db->set('kgs_masuk', $new_kgs_in);
            $this->db->set('kgs_akhir', $new_kgs_akhir);
            $this->db->where('id', $saldo['id']);
            $this->db->update('stokdept');
        }


        $this->db->select('id, kgs_awal, kgs_akhir');
        $this->db->from('stokdept');
        $this->db->where('periode >', $periode);
        $this->db->where('id_barang', $id_barang);
        $next_saldos = $this->db->get()->result_array();

        if (!empty($next_saldos)) {
            foreach ($next_saldos as $next_saldo) {
                $new_kgs_awal = $next_saldo['kgs_awal'] - $jumlah;
                $new_kgs_akhir = $next_saldo['kgs_akhir'] - $jumlah;

                $this->db->set('kgs_awal', $new_kgs_awal);
                $this->db->set('kgs_akhir', $new_kgs_akhir);
                $this->db->where('id', $next_saldo['id']);
                $this->db->update('stokdept');
            }
        }

        return true;
    }

    public function hapusSaldo_keluar($tanggal, $jumlah, $id_barang)
    {
        $tahun = date('Y', strtotime($tanggal));
        $bulan = date('m', strtotime($tanggal));
        $periode = $bulan . $tahun;
        $this->db->select('id, kgs_keluar, kgs_akhir');
        $this->db->from('stokdept');
        $this->db->where('periode', $periode);
        $this->db->where('id_barang', $id_barang);
        $saldo = $this->db->get()->row_array();

        if ($saldo) {
            $new_kgs_keluar = $saldo['kgs_keluar'] - $jumlah;
            $new_kgs_akhir = $saldo['kgs_akhir'] + $jumlah;

            $this->db->set('kgs_keluar', $new_kgs_keluar);
            $this->db->set('kgs_akhir', $new_kgs_akhir);
            $this->db->where('id', $saldo['id']);
            $this->db->update('stokdept');
        }

        // Ambil semua periode setelah periode yang diubah
        $this->db->select('id, kgs_awal, kgs_akhir');
        $this->db->from('stokdept');
        $this->db->where('periode >', $periode);
        $this->db->where('id_barang', $id_barang);
        $next_saldos = $this->db->get()->result_array();

        if (!empty($next_saldos)) {
            foreach ($next_saldos as $next_saldo) {
                $new_kgs_awal = $next_saldo['kgs_awal'] + $jumlah;
                $new_kgs_akhir = $next_saldo['kgs_akhir'] + $jumlah;

                $this->db->set('kgs_awal', $new_kgs_awal);
                $this->db->set('kgs_akhir', $new_kgs_akhir);
                $this->db->where('id', $next_saldo['id']);
                $this->db->update('stokdept');
            }
        }

        return true;
    }

    public function logbook($bulan_tahun, $id_barang)
    {
        $this->db->select('kgs_awal');
        $this->db->where('periode', $bulan_tahun);
        $this->db->where('id_barang', $id_barang);

        $row = $this->db->get('stokdept')->row_array();
        $kgs_awal = isset($row['kgs_awal']) ? (float) $row['kgs_awal'] : 0;

        // Ambil semua transaksi MASUK 
        $this->db->select("benang_in_mutasi.tanggal AS tanggal,'MASUK' AS jenis, 
                            COALESCE(benang_in_mutasi.jumlah, 0) AS jumlah, 
                            benang_in_mutasi.keterangan AS keterangan");
        $this->db->from('benang_in_mutasi');
        $this->db->where("DATE_FORMAT(tanggal, '%m%Y') =", $bulan_tahun);
        $this->db->where('id_barang', $id_barang);
        $query1 = $this->db->get_compiled_select();

        // Ambil semua transaksi KELUAR 
        $this->db->select("benang_out_mutasi.tanggal AS tanggal,'KELUAR' AS jenis, 
                            COALESCE(benang_out_mutasi.jumlah, 0) AS jumlah, 
                            benang_out_mutasi.keterangan AS keterangan");
        $this->db->from('benang_out_mutasi');
        $this->db->where("DATE_FORMAT(tanggal, '%m%Y') =", $bulan_tahun);
        $this->db->where('id_barang', $id_barang);
        $query2 = $this->db->get_compiled_select();


        $query = "($query1) UNION ALL ($query2) ORDER BY tanggal ASC";
        $transaksi = $this->db->query($query)->result();


        $saldo = $kgs_awal;

        if (!empty($transaksi)) {
            foreach ($transaksi as &$row) {
                $row->saldo_sebelumnya = $saldo;
                $row->jumlah = (float) $row->jumlah;

                // Update saldo berdasarkan jenis transaksi
                if ($row->jenis == 'MASUK') {
                    $saldo += $row->jumlah;
                } else {
                    $saldo -= $row->jumlah;
                }

                // Simpan saldo akhir setelah transaksi ini
                $row->saldo_akhir = $saldo;
            }
        }

        return $transaksi;
    }

    public function get_SaldoAll($id_header, $warna_benang)
    {
        $this->db->select('
            tb_detail.warna_benang, 
            tb_detail.id_header, 
            stokdept.kgs_akhir,
            stokdept.id_barang, 
            stokdept.periode, 
            barang.nama_barang
        ');
        $this->db->from('tb_detail');
        $this->db->join('stokdept', 'stokdept.id_barang = tb_detail.id_barang', 'left');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'barang.id = stokdept.id_barang', 'left');
        $this->db->where('tb_header.id', $id_header);
        $this->db->where('tb_detail.warna_benang', $warna_benang);
        return $this->db->get()->result_array();
    }

    // public function getBulan()
    // {
    //     $this->db->select("
    //         SUBSTRING(periode, 1, 2) AS bulan,
    //         CASE SUBSTRING(periode, 1, 2)
    //             WHEN '01' THEN 'Januari'
    //             WHEN '02' THEN 'Februari'
    //             WHEN '03' THEN 'Maret'
    //             WHEN '04' THEN 'April'
    //             WHEN '05' THEN 'Mei'
    //             WHEN '06' THEN 'Juni'
    //             WHEN '07' THEN 'Juli'
    //             WHEN '08' THEN 'Agustus'
    //             WHEN '09' THEN 'September'
    //             WHEN '10' THEN 'Oktober'
    //             WHEN '11' THEN 'November'
    //             WHEN '12' THEN 'Desember'
    //         END AS nama_bulan
    //     ");
    //     $this->db->from('stokdept');
    //     $this->db->group_by('SUBSTRING(periode, 1, 2)');
    //     $this->db->order_by('bulan', 'ASC');
    //     return $this->db->get()->result_array();
    // }

    public function getRak()
    {
        $this->db->select('lokasi AS nama_rak');
        $this->db->from('benang');
        $this->db->group_by('nama_rak');
        $this->db->order_by('nama_rak', 'ASC');
        return $this->db->get()->result_array();
    }

    public function getBulan()
    {
        $this->db->select('MONTH(tgl) as bulan, MONTHNAME(tgl) as nama_bulan');
        $this->db->from('tb_header');
        $this->db->group_by('MONTH(tgl)');
        $this->db->order_by('bulan', 'ASC');
        return $this->db->get()->result_array();
    }
    public function getTahun()
    {
        $this->db->select('YEAR(tgl) as tahun');
        $this->db->from('tb_header');
        $this->db->group_by('YEAR(tgl)');
        $this->db->order_by('tahun', 'DESC');
        return $this->db->get()->result_array();
    }


    public function getDataFiltered($id_header, $warna_benang, $bulan, $tahun)
    {
        $this->db->select('
        tb_detail.warna_benang, 
        tb_detail.id_header, 
        stokdept.kgs_akhir,
        stokdept.id_barang, 
        stokdept.periode, 
        barang.nama_barang
    ');
        $this->db->from('tb_detail');
        $this->db->join('stokdept', 'stokdept.id_barang = tb_detail.id_barang', 'left');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('barang', 'barang.id = stokdept.id_barang', 'left');

        if (!empty($id_header)) {
            $this->db->where('tb_header.id', $id_header);
        }
        if (!empty($warna_benang)) {
            $this->db->where('tb_detail.warna_benang', $warna_benang);
        }
        if (!empty($bulan)) {
            $this->db->where('SUBSTRING(stokdept.periode, 1, 2) =', $bulan);
        }
        if (!empty($tahun)) {
            $this->db->where('SUBSTRING(stokdept.periode, 3, 4) =', $tahun);
        }

        return $this->db->get()->result_array();
    }

    public function getBenangLike($inputan)
    {
        $this->db->group_start();
        $this->db->like('ukuran_benang', $inputan);
        $this->db->or_like('warna_benang', $inputan);
        $this->db->group_end();

        $this->db->where('barang_id !=', 0);

        $query = $this->db->get('benang');
        return $query->result_array();
    }






    // public function getBenangLike($inputan)
    // {
    //     $this->db->group_start();
    //     $this->db->like('ukuran_benang', $inputan);
    //     $this->db->or_like('warna_benang', $inputan);
    //     $this->db->group_end();

    //     $this->db->where('barang_id !=', 0);

    //     $query = $this->db->get('benang')->result();

    //     $result = [];
    //     foreach ($query as $row) {
    //         $ukuran = trim($row->ukuran_benang);
    //         $warna  = trim($row->warna_benang);
    //         $barang_id = $row->barang_id;

    //         $result[] = [
    //             "barang_id" => $barang_id,
    //             "value" => $ukuran . " (" . $warna . ")"
    //         ];
    //     }

    //     return $result;
    // }
}
