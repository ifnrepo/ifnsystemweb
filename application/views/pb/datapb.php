<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          PB (Permintaan Barang) # <?= $data['nomor_dok']; ?>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url().'pb'; ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
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
            <a href="<?= base_url().'pb/tambahdata'; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Transaksi" class="btn btn-primary btn-sm" id="adddatapb"><i class="fa fa-plus"></i><span class="ml-1">Tambah Barang</span></a>
          </div>
          <div class="card card-active" style="clear:both;" >
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2 ">
                  <h4 class="mb-0 font-kecil">Tgl</h4>
                  <span class="font-bold" style="font-size:15px;">
                    <?= tglmysql($data['tgl']); ?>
                    <a href="#">
                        <i class="fa fa-edit"></i>
                    </a>
                  </span>
                </div>
                <div class="col-4">
                  <h4 class="mb-0 font-kecil">Catatan</h4>
                  <span class="font-bold" style="font-size:15px;">
                    <?= $data['keterangan']; ?>
                    <a href="#">
                        <i class="fa fa-edit"></i>
                    </a>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1"></h4>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-5 mt-2">
            <div class="row font-kecil mb-0">
              <label class="col-2 col-form-label font-kecil required">Specific</label>
              <div class="col input-group mb-1">
                <input type="text" class="form-control font-kecil" placeholder="Spec Barang">
                <button class="btn font-kecil bg-success text-white" type="button">Cari!</button>
              </div>
            </div>
            <div class="row font-kecil mb-1">
              <label class="col-2 col-form-label">PO</label>
              <div class="col">
                <input type="email" class="form-control font-kecil" aria-describedby="emailHelp" placeholder="P/o">
              </div>
            </div>
            <div class="row font-kecil mb-1">
              <label class="col-2 col-form-label">Item</label>
              <div class="col-4">
                <input type="email" class="form-control font-kecil" aria-describedby="emailHelp" placeholder="Item">
              </div>
              <label class="col-2 col-form-label text-right">Dis</label>
              <div class="col-4">
                <input type="email" class="form-control font-kecil" aria-describedby="emailHelp" placeholder="Dis">
              </div>
            </div>
            <div class="row font-kecil mb-1">
              <label class="col-2 col-form-label">Satuan</label>
              <div class="col">
                <input type="email" class="form-control font-kecil" aria-describedby="emailHelp" placeholder="Satuan">
              </div>
            </div>
            <div class="row font-kecil mb-1">
              <label class="col-2 col-form-label">Pcs</label>
              <div class="col">
                <input type="email" class="form-control font-kecil text-right" aria-describedby="emailHelp" placeholder="Pcs">
              </div>
            </div>
            <div class="row font-kecil mb-1">
              <label class="col-2 col-form-label">Kgs</label>
              <div class="col">
                <input type="email" class="form-control font-kecil text-right" aria-describedby="emailHelp" placeholder="Kgs">
              </div>
            </div>
          </div>
          <div class="col-sm-7">
            <div id="table-default" class="table-responsive">
              <table class="table datatable6" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>No</th>
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Satuan</th>
                    <th>Qty</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >

                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        