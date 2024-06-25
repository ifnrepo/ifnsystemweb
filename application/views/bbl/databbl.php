<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          BBl (BON PEMBELIAN BARANG) # <?= $data['nomor_dok']; ?>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'bbl'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
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
                    <?= tglmysql($data['tgl']); ?>
                    <a href="<?= base_url() . 'bbl/edittgl'; ?>" title="Edit tanggal" id="tglbbl" name="tglbbl" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                      <i class="fa fa-edit"></i>
                    </a>
                  </span>
                </div>
                <div class="col-4">
                  <h4 class="mb-0 font-kecil">Catatan</h4>
                  <input type="text" id="catat" class="hilang" value="<?= $data['keterangan']; ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <?= $data['keterangan']; ?>
                    <a href="<?= base_url() . 'bbl/edittgl'; ?>" title="Edit Catatan" id="catatan" name="catatan" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                      <i class="fa fa-edit"></i>
                    </a>
                  </span>
                </div>
                <div class="col-3">

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 mt-2">

            <form method="post" action="<?= base_url() . 'bbl/simpandetailbarang'; ?>" name="formbbl" id="formbbl">
              <input type="text" id="id" name="id" value="" class="hilang">
              <div class="row font-kecil mb-0">
                <label class="col-2 col-form-label font-kecil required">Dok</label>
                <div class="col input-group mb-1">
                  <input type="text" id="id_header" name="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <input type="text" class="form-control font-kecil" id="nomor_dok" name="nomor_dok" placeholder="Nomor Dokumen">
                  <a href="<?= base_url() . 'bbl/addspecbarang'; ?>" id="caribarang" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-title="Add Transaksi" class="btn font-kecil bg-success text-white" type="button">Cari!</a>
                </div>
              </div>
            </form>

          </div>
          <div class="col-sm-8">
            <div id="table-default" class="table-responsive">
              <table class="table datatable6 table-hover" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>No</th>
                    <th class="text-center">Nama Barang</th>
                    <th class="text-center">Satuan</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                  <?php $no = 0;
                  foreach ($detail as $key) : $no++; ?>
                    <tr>
                      <td><?= $no; ?></td>
                      <td class="text-center"><?= $key['nama_barang']; ?></td>
                      <td class="text-center"><?= $key['namasatuan']; ?></td>
                      <td>
                        <a href="<?= base_url() . 'bbl/edit/' . $key['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="Edit detail Bbl" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Edit detail Bbl" rel="<?= $key['id']; ?>" title="Edit data">
                          <i class="fa fa-edit"></i>
                        </a>
                        <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusnettype" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'bbl/hapus/' . $key['id']; ?>" title="Hapus data">
                          <i class="fa fa-trash-o"></i>
                        </a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <hr class="m-1">
        <div class="form-tombol mt-1 text-right">
          <input type="text" id="jmlrek" class="hilang">
          <a href="#" class="btn btn-sm btn-primary" id="simpanbbl" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini" data-href="<?= base_url() . 'bbl/simpanbbl/' . $data['id']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</a>
          <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
        </div>
      </div>
    </div>
  </div>
</div>