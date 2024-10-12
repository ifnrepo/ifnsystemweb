<?php 
class mastermsn_model extends CI_Model{
    public function getdata(){
        $this->db->select('*,tb_mesin.id as idx');
        $this->db->from('tb_mesin');
        $this->db->join('barang','barang.id=tb_mesin.id_barang','left');
        if($this->session->userdata('lokasimesin')!=''){
            $this->db->where('lokasi',$this->session->userdata('lokasimesin'));
        }
        if($this->session->userdata('disposalmesin')!=0){
            $this->db->where('ok_disp',$this->session->userdata('disposalmesin'));
        }
        $query = $this->db->order_by('kode')->get();
        return $query;
    }
    public function getdatalokasi(){
        $this->db->select('lokasi');
        $this->db->from('tb_mesin');
        $query = $this->db->group_by('lokasi')->order_by('lokasi')->get();
        return $query;
    }
    public function getdatabyid($id){
        $this->db->select('*,tb_mesin.id as idx');
        $this->db->from('tb_mesin');
        $this->db->join('barang','barang.id=tb_mesin.id_barang','left');
        $this->db->where('tb_mesin.kode_fix',$id);
        $query = $this->db->order_by('kode')->get();
        return $query;
    }
    public function getdataby($id){
        $this->db->select('*,tb_mesin.id as idx');
        $this->db->from('tb_mesin');
        $this->db->join('barang','barang.id=tb_mesin.id_barang','left');
        $this->db->where('tb_mesin.id',$id);
        $query = $this->db->order_by('kode')->get();
        return $query;
    }
    public function updatefoto()
	{
		$data = $_POST;
		$temp = $this->getdataby($data['id'])->row_array();
		$fotodulu = FCPATH . 'assets/image/dokmesin/foto/' . $temp['filefoto']; //base_url().$gambar.'.png';
		$id = $data['id'];
		$data['filefoto'] = $this->uploadLogo();
		if ($data['filefoto'] != NULL) {
			if ($data['filefoto'] == 'kosong') {
				$data['filefoto'] = NULL;
			}
			if (file_exists($fotodulu)) {
				unlink($fotodulu);
			}
			unset($data['logo']);
			$query = $this->db->query("update tb_mesin set filefoto = '" . $data['filefoto'] . "' where id = '" . $id . "' ");
			if ($query) {
				$this->session->set_userdata('foto', $data['foto']);
				$this->session->set_flashdata('simpanfoto', 'berhasil');
			}
		} else {
			$this->session->set_flashdata('ketlain', 'Error Upload Foto Profile ' . $temp['noinduk'] . ' ');
		}
		$url = base_url() . 'mastermsn/editmesin/'.$data['id'];
		redirect($url);
	}
    public function uploadLogo()
	{
		$this->load->library('upload');
		$this->uploadConfig = array(
			'upload_path' => LOK_UPLOAD_MESIN,
			'allowed_types' => 'gif|jpg|jpeg|png',
			'max_size' => max_upload() * 1024,
		);
		// Adakah berkas yang disertakan?
		$adaBerkas = $_FILES['file']['name'];
		if (empty($adaBerkas)) {
			return 'kosong';
		}
		$uploadData = NULL;
		$this->upload->initialize($this->uploadConfig);
		if ($this->upload->do_upload('file')) {
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
			$ukuran = $_FILES['file']['size'] / 1000000;
			$tidakupload = $this->upload->display_errors(NULL, NULL);
			$this->session->set_flashdata('msg', $tidakupload . ' ' . $ext . ' ukuran ' . round($ukuran, 2) . ' MB');
		}
		return (!empty($uploadData)) ? $uploadData['file_name'] : NULL;
	}
    public function simpansatuan($data){
        $query = $this->db->insert('satuan',$data);
        return $query;
    }
    public function updatesatuan($data){
        $this->db->where('id',$data['id']);
        $query = $this->db->update('satuan',$data);
        return $query;
    }
    public function hapussatuan($id){
        $this->db->where('id',$id);
        $query = $this->db->delete('satuan');
        return $query;
    }
}