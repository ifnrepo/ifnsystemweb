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
      <div class="card card-active mb-2">
        <div class="card-body p-1 text-right">
          <?= $this->session->flashdata('ketlain'); ?>
          <?= $this->session->flashdata('msg'); ?>
          <a href="<?= base_url('hargamat/excel') . '?filter=' . $this->input->get('filter') . '&filterinv=' . $this->input->get('filterinv'); ?>" class="btn btn-success btn-sm btn-export-excel">
            <i class="fa fa-file-excel-o"></i><span class="ml-1">Export to Excel</span>
          </a>
          <a href="<?= base_url('hargamat/pdf') . '?filter=' . $this->input->get('filter') . '&filterinv=' . $this->input->get('filterinv'); ?>" target="_blank" class="btn btn-danger btn-sm btn-export-pdf">
            <i class="fa fa-file-excel-o"></i><span class="ml-1">Export to PDF</span>
          </a>
        </div>
      </div>
      <!-- <div class="card-header pb-1"> -->
      <div class="row m-1">
        <div class="col-md-2">
          <label class="mb-0 font-kecil font-bold text-azure">Kategori</label>
          <select name="filter" id="filter" class="form-select font-kecil mt-0">
            <option value="all">Semua Kategori</option>
            <?php foreach ($kategori->result_array() as $kate) {
              $selek = $this->session->flashdata('katehargamat') == $kate['kategori_id'] ? 'selected' : ''; ?>
              <option value="<?= $kate['kategori_id']; ?>" <?= $selek; ?>><?= $kate['nama_kategori']; ?></option>
            <?php } ?>
            <option value="kosong" class="text-danger">KOSONG</option>
          </select>
        </div>
        <div class="col-md-3" style="border-left: 1px solid !important;">
          <label class="mb-0 font-kecil font-bold text-azure">Articles</label>
          <select name="filterinv" id="filterinv" class="form-select font-kecil mt-0">
            <option value="all">Semua</option>
            <?php foreach ($artikel->result_array() as $artik) {
              $selek = $this->session->flashdata('artihargamat') == $artik['id_barang'] ? 'selected' : ''; ?>
              <option value="<?= $artik['id_barang']; ?>" <?= $selek; ?>><?= $artik['nama_barang']; ?></option>
            <?php } ?>
          </select>
          <label class="mb-0 font-kecil font-bold text-azure">Periode</label>
          <div class="row">
            <div class="col-8">
               <select name="blperiode" id="blperiode" class="form-select font-kecil mt-0">
                <option value="">Semua</option>
                <?php for ($x = 1; $x <= 12; $x++) : ?>
                  <option value="<?= $x; ?>" <?php if ($this->session->userdata('bl') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="col-4">
              <?php $thperiode = $this->session->userdata('th')!='' ? $this->session->userdata('th') : date('Y'); ?>
              <select name="thperiode" id="thperiode" class="form-select font-kecil mt-0">
                <option value="">Semua</option>
                <?php foreach ($tahune->result_array() as $thn ) { ?>
                  <option value="<?= $thn['thun']; ?>" <?php if ($this->session->userdata('th') == $thn['thun']) echo "selected"; ?>><?= $thn['thun']; ?></option>
                <?php } ?>
              </select>
            </div>
          </div>
         
        </div>
        <div class="col-md-7 bg-cyan-lt">
          <div style="line-height: 10px !important">
            <label class="font-kecil font-bold mt-1">Unit : <span id="reko3" style="font-size: 14px !important"></span></label><br>
            <label class="font-kecil font-bold">Weight : <span id="reko2" style="font-size: 14px !important"></span></label><br>
            <label class="font-kecil font-bold">Rp : <span id="reko4" style="font-size: 14px !important"></span></label><br>
          </div>
          <label class="font-kecil font-bold">Jumlah Record : <span id="reko1" style="font-size: 14px !important"></span></label><br>
          <a href="<?= base_url() . 'hargamat/getbarang'; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Get data IB" class="btn btn-success btn-sm" style="position: absolute; bottom:5px; right:5px;"><i class="fa fa-plus"></i><span class="ml-1">Get Barang</span></a>
        </div>
      </div>
      <!-- </div> -->
      <hr class="m-1">
      <div class="card-body pt-1">
        <div id="table-default" class="table-responsive font-kecil">
          <table id="tabelnya" class="table nowrap order-column table-hover" style="width: 100% !important;">
            <thead>
              <tr>
                <th>Article</th>
                <th>Tgl</th>
                <th>Nomor IB</th>
                <!-- <th class="text-left">Info BC</th> -->
                <th>Qty</th>
                <th>Weight</th>
                <th>Price (IDR)</th>
                <th>Total</th>
                <!-- <th>Supplier</th> -->
                <!-- <th>Cur</th> -->
                <!-- <th>Amount</th> -->
                <!-- <th>Kurs (Idr)</th> -->
                <th>Edit</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
</div>