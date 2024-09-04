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
      <div class="row m-1">
        <div class="col-md-3">
          <label class="mb-0 font-kecil font-bold text-azure">Kategori Barang</label>
          <select name="filter" id="filter" class="form-select font-kecil mt-0">
            <option value="all">Semua Kategori</option>
            <?php foreach ($kategori_options as $option) : ?>
              <option value="<?= $option['id']; ?>"><?= $option['nama_kategori']; ?></option>
            <?php endforeach; ?>
          </select>
        </div>
        <div class="col-md-3" style="border-left: 1px solid !important;">
          <label class="mb-0 font-kecil font-bold text-azure">Barang Inv</label>
          <select name="filterinv" id="filterinv" class="form-select font-kecil mt-0">
            <option value="all">Semua</option>
            <option value="x">Barang INV</option>
            <option value="y">Barang NO INV</option>
          </select>
        </div>
        <div class="col-md-2" style="border-left: 1px solid !important;">
          <label class="mb-0 font-kecil font-bold text-azure">Aktif</label>
          <select name="filteract" id="filteract" class="form-select font-kecil mt-0">
            <option value="all">Semua</option>
            <option value="y">Aktif</option>
            <option value="x">Tidak Aktif</option>
          </select>
        </div>
      </div>
      <hr class="p-1 m-1">
      <div class="card-body pt-1">
        <div id="table-default" class="table-responsive font-kecil">
          <input type="hidden" id="currentrow">
          <table class="table" id="tabelnya">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>DLN</th>
                <th>No INV</th>
                <th>Act</th>
                <th class="text-red">Safety</th>
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