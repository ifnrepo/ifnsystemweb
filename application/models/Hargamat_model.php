<?php
class Hargamat_model extends CI_Model
{
    var $column_search = array('nama_barang', 'nama_supplier', 'remark', 'nomor_bc', 'nobontr');
    var $column_order = array(null, 'nama_barang', 'nama_supplier', 'remark', 'tgl');
    var $order = array('tgl' => 'asc');
    // var $table = 'barang';
    public function getdata($filter_kategori, $filter_inv,  $filter_bc)
    {
        $this->db->select('*,tb_hargamaterial.id as idx,barang.kode as kodebarang');
        $this->db->from('tb_hargamaterial');
        $this->db->join('barang', 'barang.id = tb_hargamaterial.id_barang', 'left');
        $this->db->join('ref_dok_bc', 'ref_dok_bc.jns_bc = tb_hargamaterial.jns_bc', 'left');
        $this->db->join('supplier', 'supplier.id = tb_hargamaterial.id_supplier', 'left');
        $this->db->join('satuan', 'satuan.id = tb_hargamaterial.id_satuan', 'left');
        // $this->db->join('ref_negara', 'ref_negara.kode_negara = tb_hargamaterial.kode_negara', 'left');
        if ($filter_kategori && $filter_kategori != 'all') {
            if ($filter_kategori != 'kosong') {
                $this->db->where('barang.id_kategori', $filter_kategori);
            } else {
                $this->db->where('barang.id_kategori is null');
            }
        }
        if ($filter_inv && $filter_inv != 'all') {
            $this->db->where('barang.id', $filter_inv);
        }
        if ($filter_bc && $filter_bc != 'all') {
            $this->db->where('tb_hargamaterial.jns_bc', $filter_bc);
        }

        if ($this->session->userdata('bl') != '') {
            $this->db->where('month(tgl)', $this->session->userdata('bl'));
        }
        if ($this->session->userdata('th') != '') {
            $this->db->where('year(tgl)', $this->session->userdata('th'));
        }
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }
        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } elseif (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
        // return $this->db->get();
    }
    public function getdatabyid($id)
    {
        $this->db->select('*,tb_hargamaterial.id as idx,barang.kode,ref_negara.uraian_negara');
        $this->db->from('tb_hargamaterial');
        $this->db->join('barang', 'barang.id = tb_hargamaterial.id_barang', 'left');
        $this->db->join('supplier', 'supplier.id = tb_hargamaterial.id_supplier', 'left');
        $this->db->join('satuan', 'satuan.id = tb_hargamaterial.id_satuan', 'left');
        $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
        $this->db->join('ref_negara', 'ref_negara.kode_negara = tb_hargamaterial.kode_negara', 'left');
        $this->db->where('tb_hargamaterial.id', $id);
        return $this->db->get();
    }
    public function getdatakategori()
    {
        $this->db->select('*');
        $this->db->from('tb_hargamaterial');
        $this->db->join('barang', 'barang.id = tb_hargamaterial.id_barang', 'left');
        $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
        $this->db->where('kategori.kategori_id is not null');
        $this->db->group_by('kategori.kategori_id');
        $this->db->order_by('kategori.nama_kategori', 'ASC');
        return $this->db->get();
    }
    public function getdata_bc()
    {
        $this->db->select('*, ref_dok_bc.ket_bc');
        $this->db->from('tb_hargamaterial');
        $this->db->join('ref_dok_bc', 'ref_dok_bc.jns_bc = tb_hargamaterial.jns_bc', 'left');
        $this->db->group_by('ref_dok_bc.jns_bc');
        $this->db->order_by('ref_dok_bc.jns_bc', 'ASC');
        return $this->db->get();
    }
    public function getdataartikel()
    {
        $this->db->select('*');
        $this->db->from('tb_hargamaterial');
        $this->db->join('barang', 'barang.id = tb_hargamaterial.id_barang', 'left');
        $this->db->group_by('tb_hargamaterial.id_barang');
        $this->db->order_by('barang.nama_barang', 'ASC');
        return $this->db->get();
    }

    public function getdatatahun()
    {
        $this->db->select('year(tgl) as thun');
        $this->db->from('tb_hargamaterial');
        $this->db->where('year(tgl) is not null');
        $this->db->group_by('year(tgl)');
        $this->db->order_by('year(tgl)', 'DESC');
        return $this->db->get();
    }

    public function getbarang()
    {

        $this->db->select("*,tb_detail.id as idx");
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
        $this->db->where(['tb_header.kode_dok' => 'IB', 'tb_header.data_ok' => 1, 'tb_header.ok_valid' => 1, 'id_hamat' => 0]);
        // $this->db->where_not_in('tb_detail.id',array_column($strkondisi, 'id_detail'));
        return $this->db->get();
    }

    // public function getLikeBarang($inputan)
    // {

    //     $this->db->select("*,tb_detail.id as idx, barang.nama_barang");
    //     $this->db->from('tb_detail');
    //     $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
    //     $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
    //     $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
    //     $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
    //     $this->db->where(['tb_header.kode_dok' => 'IB', 'tb_header.data_ok' => 1, 'tb_header.ok_valid' => 1, 'id_hamat' => 0]);

    //     // $this->db->group_start();
    //     $this->db->like('barang.nama_barang', $inputan);
    //     $this->db->group_by('tb_detail.id_barang');
    //     // $this->db->group_end();

    //     return $this->db->get()->result_array();
    // }

    public function getLikeBarang($inputan)
    {

        $this->db->select("tb_detail.* ,barang.id as id_barang, barang.nama_barang, tb_header.nomor_dok, tb_header.tgl,
        tb_header.jns_bc, tb_header.tgl_bc, tb_header.nomor_bc, ref_mt_uang.mt_uang ,
        supplier.id as ids,
        supplier.nama_supplier as nama_supplier,
        kategori.nama_kategori as nama_kategori");
        $this->db->from('tb_detail');
        $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
        $this->db->join('ref_mt_uang', 'ref_mt_uang.id = tb_header.mtuang', 'left');
        $this->db->join('supplier', 'supplier.id = tb_header.id_pemasok', 'left');
        $this->db->join('barang', 'barang.id = tb_detail.id_barang', 'left');
        $this->db->join('kategori', 'kategori.kategori_id = barang.id_kategori', 'left');
        $this->db->where([
            'tb_header.kode_dok' => 'IB',
            'tb_header.data_ok'  => 1,
            'tb_header.ok_valid' => 1,
            'id_hamat'           => 0
        ]);
        $this->db->like('barang.nama_barang', $inputan);
        $this->db->group_by('tb_detail.id_barang');

        return $this->db->get()->result_array();
    }

    public function getLikeMAsBar($inputan)
    {
        $this->db->group_start();
        $this->db->like('nama_barang', $inputan);
        $this->db->or_like('nama_alias', $inputan);
        $this->db->group_end();
        $query = $this->db->get('barang');
        return $query->result_array();
    }
    public function getLikeMAsSat($inputan)
    {

        $this->db->like('kodesatuan', $inputan);

        $query = $this->db->get('satuan');
        return $query->result_array();
    }
    public function getLikeMAsSup($inputan)
    {

        $this->db->like('nama_supplier', $inputan);

        $query = $this->db->get('supplier');
        return $query->result_array();
    }


    public function simpanbarang($kode)
    {
        $jumlah = count($kode['data']);
        for ($x = 0; $x < $jumlah; $x++) {
            $arrdat = $kode['data'];
            $this->db->select("tb_detail.*,tb_header.*,c.mt_uang as mtua");
            $this->db->from('tb_detail');
            $this->db->join('tb_header', 'tb_header.id = tb_detail.id_header', 'left');
            $this->db->join('tb_detail b', 'b.id_ib = tb_detail.id', 'left');
            $this->db->join('tb_header c', 'c.id = b.id_header', 'left');
            $this->db->where('tb_detail.id', $arrdat[$x]);
            $databarang = $this->db->get()->row_array();
            if ($databarang['mtua'] == 'IDR') {
                $othamount = $databarang['harga'];
            } else {
                $othamount = 0;
            }
            $datafield = [
                'id_barang' => $databarang['id_barang'],
                'nobontr' => $databarang['nomor_dok'],
                'price' => $databarang['harga'],
                'id_supplier' => $databarang['id_pemasok'],
                'jns_bc' => $databarang['jns_bc'],
                'tgl_bc' => $databarang['tgl_bc'],
                'nomor_bc' => $databarang['nomor_bc'],
                'qty' => $databarang['pcs'],
                'weight' => $databarang['kgs'],
                'id_satuan' => $databarang['id_satuan'],
                'tgl' => $databarang['tgl'],
                'mt_uang' => $databarang['mtua'],
                'id_detail' => $arrdat[$x],
                'oth_amount' => $othamount
            ];
            $this->db->insert('tb_hargamaterial', $datafield);
            $idnya = $this->db->insert_id();
            $this->helpermodel->isilog($this->db->last_query());

            // isi id Data Detail 
            $this->db->where('id', $arrdat[$x]);
            $this->db->update('tb_detail', ['id_hamat' => $idnya]);
        }
        return true;
    }
    // public function SimpanData()
    // {
    //     $data = $_POST;


    //     $data['kurs'] = toAngka($data['kurs']);
    //     $data['qty'] = toAngka($data['qty']);
    //     $data['weight'] = toAngka($data['weight']);
    //     $data['price'] = toAngka($data['price']);
    //     $data['cif'] = toAngka($data['cif']);
    //     $data['bm'] = toAngka($data['bm']);
    //     $data['ppn'] = toAngka($data['ppn']);
    //     $data['pph'] = toAngka($data['pph']);
    //     $data['oth_amount'] = toAngka($data['oth_amount']);
    //     // $data['tgl_bc'] = tglmysql($data['tgl_bc']);
    //     $data['tgl_aju'] = tglmysql($data['tgl_aju']);
    //     $data['co'] = isset($data['co']) ? 1 : 0;
    //     $fotodulu = FCPATH . 'assets/image/dokhamat/' . $data['dok_lama']; //base_url().$gambar.'.png';
    //     if ($data['dok_lama'] != $data['namedok']) {
    //         $data['filedok'] = $this->uploaddok();
    //         if ($data['filedok'] == 'kosong') {
    //             $data['filedok'] = NULL;
    //         }
    //         if ($data['filedok'] != NULL) {
    //             if (file_exists($fotodulu)) {
    //                 unlink($fotodulu);
    //             }
    //             unset($data['namedok']);
    //             unset($data['dok_lama']);
    //             unset($data['dok']);
    //         } else {
    //             if ($data['namedok'] != '') {
    //                 $this->session->set_flashdata('ketlain', 'Error Upload Foto Profile ' . $data['noinduk'] . ' ');
    //             }
    //         }
    //     }
    //     unset($data['namedok']);
    //     unset($data['dok_lama']);
    //     unset($data['dok']);
    //     unset($data['nama_barang']);
    //     unset($data['nama_kategori']);
    //     unset($data['nama_supplier']);



    //     $query = $this->db->insert('tb_hargamaterial', $data);
    //     $this->helpermodel->isilog($this->db->last_query());
    //     return $query;
    // }
    public function SimpanData()
    {
        $data = $_POST;


        $data['kurs'] = toAngka($data['kurs']);
        $data['qty'] = toAngka($data['qty']);
        $data['weight'] = toAngka($data['weight']);
        $data['price'] = toAngka($data['price']);
        $data['cif'] = toAngka($data['cif']);
        $data['bm'] = toAngka($data['bm']);
        $data['ppn'] = toAngka($data['ppn']);
        $data['pph'] = toAngka($data['pph']);
        $data['oth_amount'] = toAngka($data['oth_amount']);
        $data['harga_akt'] = toAngka($data['harga_akt']);
        $data['tgl'] = tglmysql($data['tgl']);
        $data['tgl_bc'] = tglmysql($data['tgl_bc']);
        $data['tgl_aju'] = tglmysql($data['tgl_aju']);
        $data['co'] = isset($data['co']) ? 1 : 0;
        $fotodulu = FCPATH . 'assets/image/dokhamat/' . $data['dok_lama']; //base_url().$gambar.'.png';
        if ($data['dok_lama'] != $data['namedok']) {
            $data['filedok'] = $this->uploaddok();
            if ($data['filedok'] == 'kosong') {
                $data['filedok'] = NULL;
            }
            if ($data['filedok'] != NULL) {
                if (file_exists($fotodulu)) {
                    unlink($fotodulu);
                }
                unset($data['namedok']);
                unset($data['dok_lama']);
                unset($data['dok']);
            } else {
                if ($data['namedok'] != '') {
                    $this->session->set_flashdata('ketlain', 'Error Upload Foto Profile ' . $data['noinduk'] . ' ');
                }
            }
        }
        unset($data['namedok']);
        unset($data['dok_lama']);
        unset($data['dok']);
        unset($data['nama_barang']);
        unset($data['nama_satuan']);
        unset($data['nama_supplier']);

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';
        // exit;


        $query = $this->db->insert('tb_hargamaterial', $data);
        $this->helpermodel->isilog($this->db->last_query());
        return $query;
    }
    public function updatehamat()
    {
        $data = $_POST;
        $nobontr = $data['nobontr'];
        $mt_uang = $data['mt_uang'];
        $kode_negara = $data['kode_negara'];
        $jns_bc = $data['jns_bc'];
        $nomor_bc = $data['nomor_bc'];
        // $tgl_bc = $data['tgl_bc'];
        $nomor_aju = $data['nomor_aju'];
        // $tgl_aju = $data['tgl_aju'];
        // $filedok = $data['filedok'];



        // var_dump($nobontr);
        // var_dump($nomor_aju);
        // die();

        $data['kurs'] = toAngka($data['kurs']);
        $data['qty'] = toAngka($data['qty']);
        $data['weight'] = toAngka($data['weight']);
        $data['price'] = toAngka($data['price']);
        $data['cif'] = toAngka($data['cif']);
        $data['bm'] = toAngka($data['bm']);
        $data['ppn'] = toAngka($data['ppn']);
        $data['pph'] = toAngka($data['pph']);
        $data['oth_amount'] = toAngka($data['oth_amount']);
        $data['harga_akt'] = toAngka($data['harga_akt']);
        $data['tgl_bc'] = tglmysql($data['tgl_bc']);
        $data['tgl_aju'] = tglmysql($data['tgl_aju']);
        $data['co'] = isset($data['co']) ? 1 : 0;
        $fotodulu = FCPATH . 'assets/image/dokhamat/' . $data['dok_lama']; //base_url().$gambar.'.png';
        if ($data['dok_lama'] != $data['namedok']) {
            $data['filedok'] = $this->uploaddok();
            if ($data['filedok'] == 'kosong') {
                $data['filedok'] = NULL;
            }
            if ($data['filedok'] != NULL) {
                if (file_exists($fotodulu)) {
                    unlink($fotodulu);
                }
                unset($data['namedok']);
                unset($data['dok_lama']);
                unset($data['dok']);
            } else {
                if ($data['namedok'] != '') {
                    $this->session->set_flashdata('ketlain', 'Error Upload Foto Profile ' . $data['noinduk'] . ' ');
                }
            }
        }
        unset($data['namedok']);
        unset($data['dok_lama']);
        unset($data['dok']);


        $this->db->trans_start();


        $this->db->where('id', $data['id']);
        $this->db->update('tb_hargamaterial', $data);

        $updateFields = [
            'mt_uang'     => $mt_uang,
            'kode_negara' => $kode_negara,
            'jns_bc'      => $jns_bc,
            'nomor_bc'    => $nomor_bc,
            'tgl_bc'      => $data['tgl_bc'],
            'nomor_aju'   => $nomor_aju,
            'tgl_aju'     => $data['tgl_aju'],
        ];

        if (!empty($data['filedok'])) {
            $updateFields['filedok'] = $data['filedok'];
        }
        // elseif (isset($data['remove_dok']) && $data['remove_dok'] == 1) {
        //     $updateFields['filedok'] = NULL;
        // }

        $this->db->where('nobontr', $nobontr);
        $this->db->update('tb_hargamaterial', $updateFields);

        $this->helpermodel->isilog($this->db->last_query());
        $this->db->trans_complete();

        return $this->db->trans_status();
    }
    public function get_datatables($filter_kategori, $filter_inv, $filter_bc)
    {
        $this->getdata($filter_kategori, $filter_inv, $filter_bc);
        // $this->getdata();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }
    public function count_filtered($filter_kategori, $filter_inv, $filter_bc)
    {
        $this->getdata($filter_kategori, $filter_inv, $filter_bc);
        // $this->getdata();
        $query = $this->db->get();
        return $query->num_rows();
    }
    public function count_all()
    {
        $this->db->from('tb_hargamaterial');
        return $this->db->count_all_results();
    }
    public function hitungrec($filter_kategori, $filter_inv, $filter_bc)
    {
        $this->getdata($filter_kategori, $filter_inv, $filter_bc);
        $query = $this->db->get();
        return $query->num_rows();
    }

    public function getdokbc()
    {
        $this->db->where('masuk', 1);
        return $this->db->get('ref_dok_bc');
    }
    public function refbendera()
    {
        return $this->db->order_by('kode_negara')->get('ref_negara');
    }
    public function refmtuang()
    {
        return $this->db->get('ref_mt_uang');
    }
    public function getdata_export($filter_kategori, $filter_inv)
    {
        $this->db->select('*,tb_hargamaterial.id as idx,barang.kode as kodebarang');
        $this->db->from('tb_hargamaterial');
        $this->db->join('barang', 'barang.id = tb_hargamaterial.id_barang', 'left');
        $this->db->join('supplier', 'supplier.id = tb_hargamaterial.id_supplier', 'left');
        $this->db->join('satuan', 'satuan.id = tb_hargamaterial.id_satuan', 'left');
        if ($filter_kategori && $filter_kategori != 'all') {
            if ($filter_kategori != 'kosong') {
                $this->db->where('barang.id_kategori', $filter_kategori);
            } else {
                $this->db->where('barang.id_kategori is null');
            }
        }
        if ($filter_inv && $filter_inv != 'all') {
            $this->db->where('barang.id', $filter_inv);
        }

        $query = $this->db->get();
        return $query->result_array();
    }
    public function uploaddok()
    {
        $this->load->library('upload');
        $this->uploadConfig = array(
            'upload_path' => LOK_UPLOAD_DOKHAMAT,
            'allowed_types' => 'pdf|PDF',
            'max_size' => max_upload() * 10240,
        );
        // Adakah berkas yang disertakan?
        $adaBerkas = $_FILES['dok']['name'];
        if (empty($adaBerkas)) {
            return 'kosong';
        }
        $uploadData = NULL;
        $this->upload->initialize($this->uploadConfig);
        if ($this->upload->do_upload('dok')) {
            $uploadData = $this->upload->data();
            $namaFileUnik = strtolower($uploadData['file_name']);
            $fileRenamed = rename(
                $this->uploadConfig['upload_path'] . $uploadData['file_name'],
                $this->uploadConfig['upload_path'] . $namaFileUnik
            );
            $uploadData['file_name'] = $fileRenamed ? $namaFileUnik : $uploadData['file_name'];
        } else {
            $_SESSION['success'] = -1;
            $ext = pathinfo($adaBerkas, PATHINFO_EXTENSION);
            $ukuran = $_FILES['dok']['size'] / 1000000;
            $tidakupload = $this->upload->display_errors(NULL, NULL);
            $this->session->set_flashdata('msg', $tidakupload . ' ' . $ext . ' ukuran ' . round($ukuran, 2) . ' MB');
        }
        return (!empty($uploadData)) ? strtolower(nospasi($uploadData['file_name'])) : NULL;
    }

    public function hapus($id)
    {

        $data = $this->db->select('*')
            ->from('tb_hargamaterial')
            ->where('id', $id)
            ->get()
            ->row_array();

        if (!$data) {
            return false;
        }
        $cek = $this->db->select('*')
            ->from('tb_bombc')
            ->where('id_barang', $data['id_barang'])
            ->where('nobontr', $data['nobontr'])
            ->get()
            ->row_array();

        if ($cek) {
            return 'digunakan';
        }


        $this->db->where('id', $id);
        return $this->db->delete('tb_hargamaterial');
    }
}
