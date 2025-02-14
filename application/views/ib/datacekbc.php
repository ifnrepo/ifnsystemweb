<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <div>Konfirmasi Hanggar</div>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">

        <a href="<?= base_url() . 'ib'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="sisipkan">
          <div class="mb-1">
          </div>
          <!-- <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="hr m-1"></div>
            </div>
          </div> -->
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div id="table-default" class="table-responsive mt-1">
              <table class="table datatable6 table-hover" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th class="text-left">No</th>
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
              </table>
            </div>
          </div>
        </div>
        <hr class="m-1">
        <div class="form-tombol mt-1 text-right">

        </div>
      </div>
    </div>
  </div>
</div>