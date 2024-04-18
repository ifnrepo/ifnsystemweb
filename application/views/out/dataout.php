<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          OUT (Perpindahan Barang) # <?= $data['nomor_dok']; ?>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <?php if($mode=='tambah'): ?>
        <a href="<?= base_url().'out/hapusdataout/'.$data['id']; ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
        <?php endif; ?>
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
          <div class="card card-active" style="clear:both;" >
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2 ">
                  <h4 class="mb-0 font-kecil">Tgl</h4>
                  <input type="text" id="tgldok" class="hilang" value="<?= tglmysql($data['tgl']); ?>">
                  <input type="text" id="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <?= tglmysql($data['tgl']); ?>
                    <a href="<?= base_url().'out/edit_tgl'; ?>" title="Edit Tgl" id="tglpb" name="tglpb" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                        <i class="fa fa-edit"></i>
                    </a>
                  </span>
                </div>
                <div class="col-4">
                  <h4 class="mb-0 font-kecil">Catatan</h4>
                  <input type="text" id="catat" class="hilang" value="<?= $data['keterangan']; ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <?= $data['keterangan']; ?>
                    <a href="<?= base_url().'out/edit_tgl'; ?>" title="Edit tanggal" id="catatan" name="catatan" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                        <i class="fa fa-edit"></i>
                    </a>
                  </span>
                </div>
                <div class="col-3">
                  
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div id="table-default" class="table-responsive">
              <table class="table datatable6 table-hover" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <!-- <th>No</th> -->
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Satuan</th>
                    <th>Qty MINTA</th>
                    <th>Kgs MINTA</th>
                    <th>Qty REAL</th>
                    <th>Kgs REAL</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <hr class="m-1">
        <div class="form-tombol mt-1 text-right">   
          <input type="text" id="jmlrek" class="hilang">
          <a href="#" class="btn btn-sm btn-primary" id="simpanout" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini" data-href="<?= base_url().'out/simpanheaderout/'.$data['id']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</a>
          <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" data-tombol="Ya" data-message="Akan Reset data ini" data-href="<?= base_url().'out/resetdetail/'.$data['id']; ?>"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
        </div>
      </div>
    </div>
  </div>
</div>
        