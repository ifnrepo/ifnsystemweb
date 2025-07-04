<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <?php $hasil = $this->session->userdata('modetask')=='' ? 'Tekan Get untuk Load Data !' : 'Validasi '.strtoupper($this->session->userdata('modetask')) ?>
          <div>Pending Task [<?= $this->session->userdata('ttd'); ?>] <br><span class="title-dok"><?= $hasil; ?></span></div>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-header pb-1">
        <label class="col-2 col-form-label font-bold">Pending Task</label>
        <div class="col">
          <div class="input-group">
            <select class="form-select bg-success font-bold" id="taskmode">
              <?php if(count($this->session->userdata('hak_ttd_pb')) > 0): ?>
              <option value="pb" <?php if ($this->session->userdata('modetask') == 'pb') {
                                    echo 'selected';
                                  } ?>>Validasi PB (Permintaan Barang)</option>
              <?php endif; ?>
              <?php if(count(arrdep(datauser($this->session->userdata('id'),'bbl_ceksgm'))) > 0 || count(arrdep(datauser($this->session->userdata('id'),'bbl_cekmng'))) > 0 || datauser($this->session->userdata('id'),'cekbbl')==1 || datauser($this->session->userdata('id'),'cekpc')==1  || datauser($this->session->userdata('id'),'cekpp')==1 || datauser($this->session->userdata('id'),'cekut')==1): ?>
              <option value="bbl" <?php if ($this->session->userdata('modetask') == 'bbl') {
                                    echo 'selected';
                                  } ?>>Validasi BBL (Bon Permintaan Pembelian)</option>
              <?php endif; ?>
              <?php if($this->session->userdata('cekpo') == 1): ?>
              <option value="po" <?php if ($this->session->userdata('modetask') == 'po') {
                                    echo 'selected';
                                  } ?>>Validasi PO (Purchase Order)</option>
              <?php endif; ?>
              <?php if($this->session->userdata('cekadj') == 1): ?>
              <option value="adj" <?php if ($this->session->userdata('modetask') == 'adj') {
                                    echo 'selected';
                                  } ?>>Validasi ADJ (Adjustment)</option>
              <?php endif; ?>
              <?php if(datauser($this->session->userdata('id'),'cekpakaibc') == 1): ?>
              <option value="cekbc" <?php if ($this->session->userdata('modetask') == 'cekbc') {
                                    echo 'selected';
                                  } ?>>Konfirmasi Dokumen BC</option>
              <?php endif; ?>
            </select >
            <select class="form-select bg-cyan-lt font-bold ml-1 hilang">
              <option value="">XXXX</option>
            </select>
            <button class="btn font-kecil font-bold btn-flat" id="gettask" type="button">Get !</button>
          </div>
        </div>
      </div>
      <div class="card-body pt-1">
        <table id="tabel" class="table nowrap order-column table-hover datatable8" style="width: 100% !important;">
          <?php if ($this->session->userdata('modetask') == 'cekbc'){ ?>
            <thead>
              <tr>
                <th>Tgl</th>
                <th>Nomor IB</th>
                <th>Dibuat Oleh</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php $no=1; foreach ($data->result_array() as $dat) { ?>
                    <tr>
                      <td class="text-left"><?= $no++; ?></td>
                      <td style="line-height: 11px"><a href='<?= base_url().'ib/viewbc/'.$dat['id'] ?>' data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Cek Beacukai"  class='font-bold'><?= $dat['nomor_dok']; ?><br><span style='font-size: 10px;'><?= $dat['tgl']; ?></span></a></td>
                      <td style="line-height: 11px"><?= datauser($dat['user_ok'],'name'); ?><br><span style='font-size: 10px;'><?= $dat['tgl_ok']; ?></span></td>
                      <td class="text-center">
                        <a href="<?= base_url().'ib/viewbc/'.$dat['id'] ?>" class="btn btn-sm btn-teal" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Cek Beacukai" style="padding: 2px 3px !important">Cek Beacukai</a>
                      </td>
                    </tr>
                  <?php } ?>
            </tbody>
          <?php }else{ ?>
            <thead>
              <tr>
                <th>Tgl</th>
                <th>Nomor Bon Pembelian</th>
                <th>P</th>
                <th>Sv</th>
                <th>Dept</th>
                <th>Keterangan</th>
                <th>Dibuat Oleh</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php foreach ($data->result_array() as $datpb) {
                if($this->session->userdata('modetask') == 'adj'){
                  $viewdetail = base_url() . 'adj/viewdetailadj/' . $datpb['id'].'/1';
                  $btnok = base_url() . 'task/validasiadj/' . $datpb['id'];
                  // $btnno = base_url() . 'task/canceladj/' . $datpb['id'];
                  $btnno = base_url() . 'task/canceltask/' . $datpb['id'];
                }else {
                  if ($this->session->userdata('modetask') == 'pb') {
                    $viewdetail = base_url() . 'pb/viewdetailpb/' . $datpb['id'].'/1';
                    $btnok = base_url() . 'task/validasipb/' . $datpb['id'];
                    // $btnno = base_url() . 'task/cancelpb/' . $datpb['id'];
                    $btnno = base_url().'task/canceltask/'.$datpb['id'];
                  } else {
                    $ttdke = $datpb['data_ok']+$datpb['ok_pp']+$datpb['ok_valid']+$datpb['ok_tuju']+$datpb['ok_pc']+1;
                    if($this->session->userdata('modetask')=='po'){
                      $viewdetail = base_url() . 'po/viewdetail/' . $datpb['id'].'/1';
                      $btnok = base_url() . 'task/validasipo/' . $datpb['id'] . '/3';
                      // $btnno = base_url() . 'task/cancelpo/' . $datpb['id'] . '/3';
                      $btnno = base_url() . 'task/canceltask/' . $datpb['id'] . '/3';
                    }else{
                      $viewdetail = base_url() . 'bbl/viewdetail_bbl/' . $datpb['id'] . '/' . $this->session->userdata('ttd').'/1';
                      $btnok = base_url() . 'task/validasibbl/' . $datpb['id'] . '/' . $ttdke;
                      // $btnno = base_url() . 'task/cancelbbl/' . $datpb['id'] . '/' . $ttdke;
                      $btnno = base_url() . 'task/canceltask/' . $datpb['id'] . '/' . $ttdke;
                    }
                    $btnedit = base_url() . 'task/editbbl/' . $datpb['id'] . '/' . $this->session->userdata('ttd');
                    $btneditapprover = base_url() . 'task/editapprovebbl/' . $datpb['id'] . '/' . $this->session->userdata('ttd');
                  }
                }
              ?>
                <tr>
                  <td><?= tglmysql($datpb['tgl']); ?></td>
                  <td><a href="<?= $viewdetail ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View detail"><?= $datpb['nomor_dok']; ?></a></td>
                  <td class="font-bold font-kecil"><?php if ($datpb['bbl_pp'] == 1) {
                                                      echo "<span class='text-success'>P</span>";
                                                    } ?><?php if ($datpb['bbl_pp'] == 2) {
                                                      echo "<span class='text-success'>UT</span>";
                                                    } ?></td>
                  <td class="font-bold font-kecil"><?php if ($datpb['pb_sv'] == 1 || $datpb['bbl_sv'] == 1) {
                                                      echo "<span class='text-danger'>Sv</span>";
                                                    } ?></td>
                  <td class="font-bold font-kecil"><?= $datpb['dept_bbl']; ?></td>
                  <td><?= $datpb['keterangan']; ?></td>
                  <td style="line-height: 13px;"><?= datauser($datpb['user_ok'], 'name'); ?><br><span style="font-size: 10px;"><?= $datpb['tgl_ok'] ?></span></td>
                  <td class="text-center">
                    <?php if ($this->session->userdata('modetask') == 'bbl' && $datpb['ok_pp']==1) { ?>
                      <a href="#" style="padding: 5px !important" data-bs-target="#modal-info" data-message="Anda yakin akan edit bon <br><?= $datpb['nomor_dok']; ?> ?" data-href="<?= $btnedit ?>" data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-primary">Edit Qty</a>
                    <?php } else if ($this->session->userdata('modetask') == 'bbl' && count(arrdep(datauser($this->session->userdata('id'),'bbl_cekmng'))) > 0 && $datpb['ok_pp']==1) { ?>
                      <a href="#" style="padding: 5px !important" data-bs-target="#modal-info" data-message="Anda yakin akan edit Approver bon <br><?= $datpb['nomor_dok']; ?> ?" data-href="<?= $btneditapprover ?>" data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-primary">Edit</a>
                    <?php } $hilang = datauser($this->session->userdata('id'),'cekpc')==1 ? "hilang" : ""; ?>
                    <a href="#" style="padding: 5px !important" data-bs-target="#modal-info" data-message="Anda yakin akan validasi bon <br><?= $datpb['nomor_dok']; ?>" data-href="<?= $btnok ?>" data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-info">Approve</a>
                    <a href="<?= $btnno; ?>" style="padding: 5px !important" data-bs-target="#canceltask" data-message="Anda yakin akan membatalkan bon <br><?= $datpb['nomor_dok']; ?>" data-href="<?= $btnno ?>" data-tombol="Ya" data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-danger <?= $hilang; ?>">Cancel</a>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          <?php } ?>
        </table>
      </div>
    </div>
  </div>
</div>