<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <div>PO (Purchase Order) <br><span class="title-dok"><?= $data['nomor_dok']; ?></span></div>
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
                  <h4 class="mb-0 font-kecil">Tanggal PO</h4>
                  <input type="text" id="tgldok" class="hilang" value="<?= tglmysql($data['tgl']); ?>">
                  <input type="text" id="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <a href="<?= base_url() . 'po/edittgl'; ?>" title="Edit tanggal" id="tglpo" name="tglpo" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan"><?= tglmysql($data['tgl']); ?></a>
                  </span>
                  <h4 class="mb-0 font-kecil mt-1">Tgl Rencana Datang</h4>
                  <div class="input-icon">
                    <input type="text" id="tgldt" class="form-control input-sm font-kecil" value="<?= tglmysql($data['tgl_dtb']); ?>">
                    <span class="input-icon-addon" id="loadertgldt">

                    </span>
                  </div>
                </div>
                <div class="col-4">
                  <h4 class="mb-0 font-kecil">SUPPLIER</h4>
                  <div class="input-group">
                    <?php $tekstitle = $data['id_pemasok'] == null ? 'Cari ' : 'Ganti '; ?>
                    <?php $tekstitle2 = $data['id_pemasok'] == null || $data['id_pemasok'] == 0 ? 'Cari ' : $data['id_pemasok']; ?>
                    <a href="<?= base_url() . 'po/editsupplier'; ?>" class="btn text-primary font-bold" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Cari Supplier" title="<?= $tekstitle; ?> Supplier"><?= $tekstitle2; ?></a>
                    <input type="text" class="form-control font-kecil" aria-label="Text input with dropdown button" placeholder="Nama Supplier" value="<?= $data['namasupplier']; ?>">
                  </div>
                  <div class="mt-1">
                    <textarea class="form-control form-sm font-kecil" placeholder="Alamat"><?= $data['alamat']; ?></textarea>
                  </div>
                  <div class="mt-1">
                    <input type="text" class="form-control font-kecil" aria-label="Text input with dropdown" placeholder="Kontak" value="<?= $data['kontak']; ?>">
                  </div>
                </div>
                <div class="col-3">
                  <h4 class="mb-0 font-kecil">Jenis Pembayaran</h4>
                  <div class="input-group">
                    <select class="form-control form-select font-kecil font-bold text-primary">
                      <option></option>
                      <option>CASH</option>
                      <option>KREDIT</option>
                      <option>ADVANCE</option>
                      <option>SAMPLE</option>
                    </select>
                    <input type="text" class="form-control font-kecil" aria-label="Text input with dropdown button" placeholder="Tgl.." value="" disabled>
                  </div>
                </div>
                <div class="col-3">
                  <div style="position:absolute;bottom:0px;right:10px;">
                    <a href="<?= base_url() . 'po/getbarangpo'; ?>" data-bs-toggle="modal" data-bs-target="#modal-largescroll" data-title="Get data Pembelian Barang" class="btn btn-sm btn-success">Get Bon Pembelian</a>
                  </div>
                </div>
              </div>
              <div class="hr m-1"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div id="table-default" class="table-responsive">
              <table class="table datatable6 table-hover" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>No</th>
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Qty</th>
                    <th>Satuan</th>
                    <th>Harga</th>
                    <th>Total</th>
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