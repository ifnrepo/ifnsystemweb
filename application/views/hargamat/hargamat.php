<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <div>Harga Material</div>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <!-- <div class="card-header pb-1"> -->
        <div class="row m-1">
          <div class="col-md-2">
            <label class="mb-0 font-kecil font-bold text-azure">Kategori</label>
            <select name="filter" id="filter" class="form-select font-kecil mt-0">
              <option value="all">Semua Kategori</option>
            </select>
          </div>
          <div class="col-md-3" style="border-left: 1px solid !important;">
            <label class="mb-0 font-kecil font-bold text-azure">Articles</label>
            <select name="filterinv" id="filterinv" class="form-select font-kecil mt-0">
              <option value="all">Semua</option>
              <option value="x">Barang INV</option>
              <option value="y">Barang NO INV</option>
            </select>
          </div>
          <div class="col-md-7 bg-cyan-lt">
            <a href="<?= base_url().'hargamat/getbarang'; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Get data IB" class="btn btn-success btn-sm" style="position: absolute; bottom:5px; right:5px;"><i class="fa fa-plus"></i><span class="ml-1">Get Barang</span></a>
          </div>
        </div>
      <!-- </div> -->
       <hr class="m-1">
      <div class="card-body pt-1">
        <table id="tabel" class="table nowrap order-column table-hover datatable7" style="width: 100% !important;">
          <thead>
            <tr>
              <th>Article</th>
              <th>Tgl</th>
              <th>Nomor IB</th>
              <th>Unit</th>
              <th>Weight</th>
              <th>Price (Rp)</th>
              <th>Total</th>
              <th>Supplier</th>
              <th>Cur</th>
              <th>Amount</th>
              <th>Kurs (Idr)</th>
              <th>Edit</th>
            </tr>
          </thead>
          <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
            <?php foreach ($data->result_array() as $key ) { ?>
              <tr>
                <td><?= $key['nama_barang']; ?></td>
                <td><?= $key['tgl']; ?></td>
                <td><?= $key['nobontr']; ?></td>
                <td><?= $key['id_satuan']; ?></td>
                <td><?= $key['weight']; ?></td>
                <td><?= rupiah($key['price'],2); ?></td>
                <td><?= $key['id_satuan']; ?></td>
                <td><?= $key['id_satuan']; ?></td>
                <td><?= $key['id_satuan']; ?></td>
                <td><?= $key['id_satuan']; ?></td>
                <td><?= $key['id_satuan']; ?></td>
                <td class="text-center">
                  <a href="#">Edit</a>
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