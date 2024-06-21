<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Master Data Barang
        </h2>
        <div class="col-md-4">
          <select name="filter" id="filter" class="form-select">
            <option value="all">Semua Kategori</option>
            <?php foreach ($kategori_options as $option) : ?>
              <option value="<?= $option['nama_kategori']; ?>"><?= $option['nama_kategori']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'barang/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Barang"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="table-default" class="table-responsive">
          <table class="table" id="tabelnya">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>DLN</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" style="font-size: 13px !important;">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>