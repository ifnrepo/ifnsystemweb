<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <div>ADJ (Adjustment Barang) <br><span class="title-dok"><?= $data['nomor_dok']; ?><?php if($data['pb_sv']==1){ echo " (SERVICE)"; } ?></span></div>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'adj'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
        <input type="hidden" id="errorparam" value="<?= $this->session->flashdata('errorparam'); ?>">
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-1">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="sisipkan">
          <div class="mb-1">
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2 ">
                  <h4 class="mb-0 font-kecil">Tgl</h4>
                  <input type="text" id="tgldok" class="hilang" value="<?= tglmysql($data['tgl']); ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <?= tglmysql($data['tgl']); ?>
                    <a href="<?= base_url() . 'adj/edittgl'; ?>" title="Edit tanggal" id="tglpb" name="tglpb" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                      <i class="fa fa-edit"></i>
                    </a>
                  </span>
                </div>
                <div class="col-4">
                  <h4 class="mb-0 font-kecil">Catatan</h4>
                  <input type="text" id="catat" class="hilang" value="<?= $data['keterangan']; ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <?= $data['keterangan']; ?>
                    <a href="<?= base_url() . 'adj/edittgl'; ?>" title="Edit Catatan" id="catatan" name="catatan" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                      <i class="fa fa-edit"></i>
                    </a>
                    <input type="hidden" id="ketbon" value="<?= $data['keterangan']; ?>">
                  </span>
                </div>
                <div class="col-3">
                  <?php if(in_array($data['dept_id'],daftardeptsubkon())){ ?>
                  <h4 class="mb-0 font-kecil">Nomor BC</h4>
                  <span class="font-bold" style="font-size:15px;">
                    <input type="text" id="nomorbcnya" value="<?= $data['nomor_bc']; ?>" readonly>
                    <a href="<?= base_url() . 'adj/edittgl'; ?>" title="Edit Nomor BC" id="nomorbc" name="nomorbc" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                      <i class="fa fa-edit"></i>
                    </a>
                  </span>
                </div>
                <?php } ?>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 mt-2">
            <form method="post" action="<?= base_url() . 'adj/simpandetailbarang'; ?>" name="formbarangpb" id="formbarangpb">
              <input type="text" id="id" name="id" value="" class="hilang">
              <!-- <div class="row font-kecil mb-0">
                <div class="col-2 col-form-label">Inline Radios</div>
                  <div class="col input-group">
                    <label class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="radios-inline"  checked>
                      <span class="form-check-label">Option 1</span>
                    </label>
                    <label class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="radios-inline" >
                      <span class="form-check-label">Option 2</span>
                    </label>
                    <label class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="radios-inline"  disabled>
                      <span class="form-check-label">Option 3</span>
                    </label>
                  </div>
                </div>
              </div> -->
              <div class="row font-kecil mb-0">
                <label class="col-2 col-form-label font-kecil">Mode</label>
                <div class="col mb-1 pt-2">
                    <label class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" value="0" name="radios-inline" checked>
                      <span class="form-check-label">Spek Barang</span>
                    </label>
                    <label class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" value="1" name="radios-inline">
                      <span class="form-check-label">ID</span>
                    </label>
                    <label class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" value="2" name="radios-inline">
                      <span class="form-check-label">PO</span>
                    </label>
                </div>
              </div>
              <div class="row font-kecil mb-0">
                <label class="col-2 col-form-label font-kecil required">Specific</label>
                <div class="col input-group mb-1">
                  <input type="text" id="id_header" name="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <input type="text" id="id_barang" name="id_barang" class="hilang">
                  <input type="text" id="po" name="po" class="hilang">
                  <input type="text" id="item" name="item" class="hilang">
                  <input type="text" id="dis" name="dis" class="hilang">
                  <input type="text" class="form-control font-kecil" id="nama_barang" name="nama_barang" placeholder="Spec Barang">
                  <button href="<?= base_url() . 'adj/addspecbarang'; ?>" id="caribarang" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-title="Add Transaksi" class="btn font-kecil bg-success text-white" type="button">Cari!</button>
                </div>
              </div>
              <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Satuan</label>
                <div class="col">
                  <select name="id_satuan" id="id_satuan" class="form-control font-kecil form-select">
                    <option value="">Pilih Satuan</option>
                    <?php foreach ($satuan as $sat) { ?>
                      <option value="<?= $sat['id']; ?>"><?= $sat['namasatuan']; ?></option>
                    <?php } ?>
                  </select>
                </div>
              </div>
              <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Qty</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil text-right" id="pcs" name="pcs" autocomplete="off" aria-describedby="emailHelp" placeholder="Qty">
                </div>
              </div>
              <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Kgs</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil text-right" id="kgs" name="kgs" autocomplete="off" aria-describedby="emailHelp" placeholder="Kgs">
                </div>
              </div>
              <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Nomor IB</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" style="text-transform: uppercase;" id="nobontr" name="nobontr" autocomplete="off" aria-describedby="emailHelp" placeholder="Nomor IB">
                </div>
              </div>
              <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Ins No</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" style="text-transform: uppercase;" id="insno" name="insno" autocomplete="off" aria-describedby="emailHelp" placeholder="Ins No">
                </div>
              </div>
              <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Ket</label>
                <div class="col">
                  <textarea class="form-control font-kecil" id="keterangan" name="keterangan"></textarea>
                </div>
              </div>
            </form>
            <div class="row">
              <div class="col-6">
                <a href="#" class="btn btn-sm btn-primary" style="width:100%" id="simpandetailbarang">Simpan Barang</a>
              </div>
              <div class="col-6">
                <a href="#" class="btn btn-sm btn-danger" style="width:100%" id="resetdetailbarang">Reset Detail</a>
              </div>
            </div>
          </div>
          <div class="col-sm-8">
            <div id="table-default" class="table-responsive">
              <table class="table datatable6 table-hover" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <!-- <th>No</th> -->
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Satuan</th>
                    <th>Qty</th>
                    <th>Kgs</th>
                    <th>Ket</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <hr class="m-1">
        <div class="form-tombol mt-1 text-right">
          <div>
          <span id="jmpcs"></span>
                    </div>
          <input type="text" id="jmlrek" class="hilang">
          <a href="#" class="btn btn-sm btn-primary" id="simpanadj" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini" data-href="<?= base_url() . 'adj/simpanadj/' . $data['id']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</a>
          <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
        </div>
      </div>
    </div>
  </div>
</div>