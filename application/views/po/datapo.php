<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          PO (Purchase Order) # <?= $data['nomor_dok']; ?>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'po'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
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
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2 ">
                  <h4 class="mb-0 font-kecil">Tgl</h4>
                  <input type="text" id="tgldok" class="hilang" value="<?= tglmysql($data['tgl']); ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <a href="<?= base_url() . 'po/editsupplier'; ?>" title="Edit tanggal" id="tglpo" name="tglpo" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan"><?= tglmysql($data['tgl']); ?></a>
                  </span>
                </div>
                <div class="col-4">
                  <h4 class="mb-0 font-kecil">SUPPLIER</h4>
                  <div class="input-group">
                    <?php $tekstitle = $data['id_pemasok'] == null ? 'Cari ' : 'Ganti '; ?>
                    <?php $tekstitle2 = $data['id_pemasok'] == null || $data['id_pemasok'] == 0 ? 'Cari ' : $data['id_pemasok']; ?>
                    <a href="<?= base_url() . 'po/editsupplier'; ?>" class="btn text-primary font-bold" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Cari Supplier" title="<?= $tekstitle; ?> Supplier"><?= $tekstitle2; ?></a>
                    <input type="text" class="form-control" aria-label="Text input with dropdown button" placeholder="Nama Supplier" value="<?= $data['namasupplier']; ?>">
                  </div>
                  <div class="mt-1">
                    <textarea class="form-control form-sm" placeholder="Alamat"><?= $data['alamat']; ?></textarea>
                  </div>
                  <div class="mt-1">
                    <input type="text" class="form-control" aria-label="Text input with dropdown" placeholder="Kontak" value="<?= $data['kontak']; ?>">
                  </div>
                </div>
                <div class="col-3">

                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 mt-2">
            <form method="post" action="<?= base_url() . 'pb/simpandetailbarang'; ?>" name="formbarangpb" id="formbarangpb">
              <input type="text" id="id" name="id" value="" class="hilang">
              <div class="row font-kecil mb-0">
                <label class="col-2 col-form-label font-kecil required">Specific</label>
                <div class="col input-group mb-1">
                  <input type="text" id="id_header" name="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <input type="text" id="id_barang" name="id_barang" class="hilang">
                  <input type="text" class="form-control font-kecil" id="nama_barang" name="nama_barang" placeholder="Spec Barang">
                  <a href="<?= base_url() . 'pb/addspecbarang'; ?>" id="caribarang" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-title="Add Transaksi" class="btn font-kecil bg-success text-white" type="button">Cari!</a>
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
                  <input type="text" class="form-control font-kecil text-right" id="pcs" name="pcs" aria-describedby="emailHelp" placeholder="Qty">
                </div>
              </div>
              <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Kgs</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil text-right" id="kgs" name="kgs" aria-describedby="emailHelp" placeholder="Kgs">
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
          <input type="text" id="jmlrek" class="hilang">
          <a href="#" class="btn btn-sm btn-primary" id="simpanpb" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini" data-href="<?= base_url() . 'pb/simpanpb/' . $data['id']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</a>
          <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
        </div>
      </div>
    </div>
  </div>
</div>