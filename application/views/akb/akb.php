<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          AKB (AJU Keluar Barang)
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url(); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <input type="text" id="errorsimpan" class="hilang" value="<?= $this->session->flashdata('errorsimpan'); ?>">
        <input type="text" id="pesanerror" class="hilang" value="<?= $this->session->flashdata('pesanerror'); ?>">
        <div id="sisipkan" class="sticky-top bg-white">
          <div class="row mb-1 d-flex align-items-between">
            <div class="col-sm-6 mb-1">
              <?php $disab=''; if($this->session->userdata('deptdari')=='' || $this->session->userdata('deptdari')==null){ $disab = 'disabled';} ?>
              <?php $cekpakaibc = datauser($this->session->userdata('id'),'cekpakaibc')==1 ? '' : 'hilang'; ?>
              <a href="<?= base_url() . 'akb/cekbc'; ?>" class="btn btn-cyan btn-sm hilang <?= cekclosebook(); ?><?= $disab; ?><?= $cekpakaibc; ?>" id="adddataib"><i class="fa fa-h-square"></i><span class="ml-1">Cek BC</span></a>
              <a href="<?= base_url() . 'akb/hosttohost/99'; ?>" class="btn btn-yellow btn-sm text-black <?= cekclosebook(); ?><?= $disab; ?>" id="addtoken"><i class="fa fa-cloud"></i><span class="ml-1">H2H Token</span></a>
              <?php $date = date("Y-m-d H:i:s",strtotime("+2 hours",strtotime($datatoken['update_at']))); ?>
              <span class="font-kecil text-teal" id="timetoexpired"><?= $date ?></span>
              <input type="hidden" id="updateon" value="<?= $date; ?>">
            </div>
            <div class="col-sm-6 mb-0 d-flex flex-row-reverse" style="text-align: right;">
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="th" name="th" style="width: 75px;" value="<?= $this->session->userdata('th') ?>">
              <select class="form-select form-control form-sm font-kecil font-bold mr-1" id="bl" name="bl" style="width: 100px;" <?= $levnow; ?>>
                <?php for ($x = 1; $x <= 12; $x++) : ?>
                  <option value="<?= $x; ?>" <?php if ($this->session->userdata('bl') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                <?php endfor; ?>
              </select> 
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2">
                  <h4 class="mb-1 font-kecil">Dept Pengirim</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="dept_id" name="dept_id">
                        <?php foreach ($hakdep->result_array() as $dep) {?>
                          <option value="<?= $dep['dept_id']; ?>" <?php if($this->session->userdata('deptdari')==$dep['dept_id']){ echo "selected"; } ?>><?= $dep['departemen']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-3">
                 <h4 class="mb-1 font-kecil">.</h4>
                  <span class="font-kecil">
                    <a href="#" class="btn btn-sm btn-primary" style="height: 38px;min-width:45px;" id="butgo">Go</a>
                  </span>
                </div>
                <div class="col-5">
                  <span class="mb-1 font-kecil text-primary font-bold">Jumlah Record : <?= $jumlahrek->num_rows(); ?></span><br>
                  <?php $jmlrek = $jumlahrek->row_array(); $jumlahpce = 0; if(isset($jmlrek['jumlahitemnya'])){ $jumlahpce = $jmlrek['jumlahitemnya']; } ?>
                  <span class="mb-1 font-kecil text-primary font-bold">Jumlah Detail : <?= rupiah($jumlahpce,0).' Item' ?></span>
                </div>
                <div class="col-2">
                  <h4 class="mb-1">
                    <?php if($disab!=''){ ?>
                    <small class="text-pink text-center">Tekan <u><b>GO</b></u> untuk mengaktifkan Tombol Tambah Data dan Load Data</small>
                    <?php }else{ if($this->session->userdata('deptdari')=='FG'){ ?>
                      <div style="position:absolute;bottom:0px;right:10px;">
                        <a data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Pilih SUBKON" href="<?= base_url() . 'akb/getnamasubkon' ?>" class="btn btn-sm btn-primary">Tambah Data Pengajuan</a>
                      </div>
                    <?php } } ?>
                  </h4>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div class="mt-1">
          <table id="pbtabel" class="table nowrap order-column" style="width: 100% !important;">
            <thead>
              <tr>
                <th>Tgl</th>
                <th>Nomor</th>
                <th>Customer</th>
                <th>Jumlah Item</th>
                <th>Diajukan Oleh</th>
                <th>BC</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php foreach ($data as $datdet) {
                $jmlrek = $datdet['jumlah_barang'] != null ? $datdet['jumlah_barang'] . ' Item' : '0 Item';
                $tmb = '';
                if($this->session->userdata('deptdari')=='FG'){
                  $namasup = datadepartemen($datdet['dept_tuju'],'nama_subkon');
                  $tmb = '/1';
                }else{
                  $namasup = $datdet['namacustomer'] != null ? $datdet['namacustomer']  : 'Not Set'; 
                }
                $nomorbc = $datdet['tanpa_bc']== 1 ? 'Tanpa BC' : 'XX';
                $isibc = $nomorbc=='XX' ? 'AJU. '.$datdet['nomor_aju'].'<br>BC. '.$datdet['nomor_bc'] : $nomorbc;
                ?>
                <tr>
                  <td><?= tglmysql($datdet['tgl']); ?></td>
                  <td class='font-bold'><a href="<?= base_url().'akb/viewdetail/'.$datdet['id'].$tmb; ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View detail OUT (AJU Keluar Barang)"><?= $datdet['nomor_dok'] ?></a></td>
                  <td><?= $namasup ?></td>
                  <td><?= $jmlrek ?></td>
                  <td class="line-12"><?= datauser($datdet['user_ok'], 'name') ?> <br><span style='font-size: 11px;'><?= tglmysql2($datdet['tgl_ok']) ?></span></td>
                  <?php if($datdet['tanpa_bc']==0){ ?>
                    <td style="font-size: 17px" class="text-info"><?= $datdet['jns_bc']; ?></td>
                      <?php if($datdet['send_ceisa']==1){ ?>
                        <td class="line-12"><a href="<?= base_url().'akb/isidokbc/'.$datdet['id']; ?>"><?= $isibc; ?></a><br><span class="text-teal" style='font-size: 11px;'><?= $datdet['keterangan']; ?></span></td>
                        <?php }else{ ?>
                          <td class="line-12"><?= $isibc; ?><br><span class="text-teal" style='font-size: 11px;'><?= $datdet['keterangan']; ?></span></td>
                      <?php } ?>
                    <?php }else{ ?>
                      <td style="font-size: 17px" class="text-info">-</td>
                      <td class="line-12" style='font-size: 11px;'><?= $nomorbc; ?><br><span class="text-teal" style='font-size: 11px;'><?= $datdet['keterangan']; ?></span></td>
                  <?php } ?>
                  <td class="text-right line-12"><span style="color: white;">.</span>
                    <?php if ($datdet['data_ok'] == 0) { ?>
                      <a href="<?= base_url() . 'akb/dataib/' . $datdet['id'] ?>" class='btn btn-sm btn-primary <?= cekclosebook(); ?>' style='padding: 3px 5px !important;' title='Lanjutkan Transaksi'>Lanjutkan Transaksi</a>
                      <a href="#" data-href="<?= base_url() . 'akb/hapusib/' . $datdet['id'] ?>" class='btn btn-sm btn-danger' data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Hapus IB <br><?= $datdet['nomor_dok']; ?>" style='padding: 3px 5px !important;' title='Hapus data Transaksi'>Hapus</a>
                    <?php } else if ($datdet['data_ok'] == 1 && $datdet['ok_valid']==0 && $datdet['ok_tuju']==0 && $datdet['tanpa_bc']==0) { ?>
                      Sedang Dicek Oleh BC /<a href="#" class="text-danger" data-href="<?= base_url() . 'ib/editib/' . $datdet['id'] ?>" style='padding: 3px 8px !important;' data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Edit IB <br><?= $datdet['nomor_dok']; ?>" title='Edit Data'>Edit</a>
                    <?php }else if ($datdet['data_ok'] == 1 && $datdet['ok_valid']==0 && $datdet['ok_tuju']==1 && $datdet['tanpa_bc']==0 && $datdet['nomor_bc']=='') { 
                      $sudahkirim = $datdet['send_ceisa']==0 ? 'btn-danger' : 'btn-info';
                      $textsudahkirim = $datdet['send_ceisa']==0 ? 'Isi Dok BC' : 'Tunggu Respon';
                       ?>
                      <a href="<?= base_url().'akb/isidokbc/'.$datdet['id'].$tmb ?>" class='btn btn-sm btn-danger hilang' data-bs-toggle="modal" data-bs-target="#modal-full" data-message="Hapus IB" data-title="Isi Data AJU + Nomor BC" style='padding: 3px 5px !important;' title='Isi Dokumen BC'>Isi Dok BC</a>
                      <a href="<?= base_url().'akb/isidokbc/'.$datdet['id'].$tmb ?>" class='btn btn-sm <?= $sudahkirim; ?>' data-title="Isi Data AJU + Nomor BC" style='padding: 3px 5px !important;' title='Isi Dokumen BC'>Isi Dok BC</a>
                      <a data-bs-toggle="modal" data-bs-target="#modal-largescroll" href="<?= base_url().'akb/getbongaichu/'.$datdet['id'].$tmb ?>" class='btn btn-sm btn-success <?php if($tmb!='/1'){ echo "hilang";} ?>' data-title="Add Bon Gaichu" style='padding: 3px 5px !important;' title='Isi Dokumen BC'>GET BON GAICHU</a>
                      <a href="#" data-href="<?= base_url() . 'akb/hapusaju/' . $datdet['id'] ?>" class='btn btn-sm btn-danger <?php if($tmb!='/1'){ echo "hilang";} ?>' data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Hapus AJU <br><?= $datdet['nomor_dok']; ?>" title='Hapus data Transaksi'><i class="fa fa-trash"></i></a>
                    <?php }else if ($datdet['data_ok'] == 1 && $datdet['ok_valid']==0 && $datdet['ok_tuju']==1 && ($datdet['tanpa_bc']==1 || $datdet['nomor_bc']!='')) { $inoleh = $datdet['dept_tuju']=='CU' ? 'Marketing' : 'Departemen'; ?>
                      <span class="text-teal">DOKUMEN SELESAI <br>Tunggu Verifikasi <b>Out</b> <?= $inoleh; ?></span>
                    <?php }else{ $katakata = $datdet['ok_valid']==2 ? 'Dicancel : ' : 'Diverifikasi :'; ?>
                      <?= $katakata.datauser($datdet['user_valid'], 'name') ?><br>
                      <span style='font-size: 11px;'><?= ' on '.tglmysql2($datdet['tgl_valid']) ?></span>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>