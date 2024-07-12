<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Pending Task <?= $this->session->userdata('ttd'); ?>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
        <div class="card-header">
          <label class="col-2 col-form-label font-bold">Pending Task</label>
          <div class="col">
            <div class="input-group">
            <select class="form-select bg-success font-bold" id="taskmode">
              <option value="pb" <?php if($this->session->userdata('modetask')=='pb'){echo 'selected'; } ?>>PB (Permintaan Barang)</option>
              <option value="bbl" <?php if($this->session->userdata('modetask')=='bbl'){echo 'selected'; } ?>>BBL (Bon Permintaan Pembelian)</option>
            </select>
            <button class="btn font-kecil font-bold btn-flat" id="gettask" type="button">Get !</button>
            </div>
          </div>
        </div>
        <div class="card-body">
            <table id="tabel" class="table nowrap order-column table-hover datatable7" style="width: 100% !important;">
                <thead>
                  <tr>
                    <th>Tgl</th>
                    <th>Nomor Bon Pembelian</th>
                    <th>P</th>
                    <th>Dept</th>
                    <th>Keterangan</th>
                    <th>Dibuat Oleh</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                  <?php foreach ($data->result_array() as $datpb) { ?>
                    <tr>
                      <td><?= tglmysql($datpb['tgl']); ?></td>
                      <td><a href="<?=  base_url() . 'pb/viewdetailpb/' . $datpb['id'] ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View detail"><?= $datpb['nomor_dok']; ?></a></td>
                      <td class="font-bold font-kecil"><?php if($datpb['bbl_pp']==1){ echo "P";} ?></td>
                      <td class="font-bold font-kecil"><?= $datpb['dept_bbl']; ?></td>
                      <td><?= $datpb['keterangan']; ?></td>
                      <td style="line-height: 13px;"><?= datauser($datpb['user_ok'],'name'); ?><br><span style="font-size: 10px;"><?= $datpb['tgl_ok'] ?></span></td>
                      <td class="text-center">
                        <a href="#" style="padding: 5px !important" data-bs-target="#modal-pilihan" 
                        data-message="Anda yakin akan validasi bon <br><?= $datpb['nomor_dok']; ?> ?" 
                        data-href="<?= base_url().'task/validasipb/'.$datpb['id']; ?>"
                        data-hrefno="<?= base_url().'task/cancelpb/'.$datpb['id']; ?>"
                        data-tabdef="tabs-bbl"
                        data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-info">Validasi</a>
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
        