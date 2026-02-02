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
      <?= $this->session->flashdata('message'); ?>
      <?php if ($this->session->flashdata('success')) : ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?= $this->session->flashdata('success'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

      <?php if ($this->session->flashdata('error')) : ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?= $this->session->flashdata('error'); ?>
          <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
      <?php endif; ?>

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
          <label class="mb-0 font-kecil font-bold text-azure">Jenis Bc</label>
          <select name="filter_bc" id="filter_bc" class="form-select font-kecil mt-0">
            <option value="all">Semua Bc</option>
            <?php foreach ($bc_option->result_array() as $bc) {
              if (empty($bc['jns_bc'])) continue;

              $selek = $this->session->flashdata('bchargamat') == $bc['jns_bc'] ? 'selected' : '';
            ?>
              <option value="<?= $bc['jns_bc']; ?>" <?= $selek; ?>><?= $bc['ket_bc']; ?></option>
            <?php } ?>
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
            <div class="col-7">
              <select name="blperiode" id="blperiode" class="form-select font-kecil mt-0">
                <option value="">Semua</option>
                <?php for ($x = 1; $x <= 12; $x++) : ?>
                  <option value="<?= $x; ?>" <?php if ($this->session->userdata('blhargamat') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                <?php endfor; ?>
              </select>
            </div>
            <div class="col-5">
              <?php $thperiode = $this->session->userdata('thhargamat') != '' ? $this->session->userdata('thhargamat') : date('Y'); ?>
              <select name="thperiode" id="thperiode" class="form-select font-kecil mt-0">
                <option value="">Semua</option>
                <?php foreach ($tahune->result_array() as $thn) { ?>
                  <option value="<?= $thn['thun']; ?>" <?php if ($this->session->userdata('thhargamat') == $thn['thun']) echo "selected"; ?>><?= $thn['thun']; ?></option>
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
          <!-- <a href="<?= base_url() . 'hargamat/getbarang'; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Get data IB" class="btn btn-success btn-sm" style="position: absolute; bottom:5px; right:5px;"><i class="fa fa-plus"></i><span class="ml-1">Get Barang</span></a> -->
          <!-- <a id="tambahdata" class="btn btn-primary text-white" style="position: absolute; bottom:5px; right:5px;" data-title="Get data IB" role="button">
            <i class="fa fa-plus"></i><span class="ml-1">Get Barang</span>
          </a> -->
          <a href="#" id="tambahdata" style="position: absolute; bottom:5px; right:5px;" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-large-tambah">
            <i class="fa fa-plus"></i><span class="ml-1"> Get Barang </a>


        </div>
      </div>
      <!-- </div> -->
      <hr class="m-1">
      <div class="card-body pt-1">
        <!-- <a href="#" class='btn btn-sm btn-info' style='padding: 2px 5px !important;' id="xmodal" data-bs-target='#modal-large-loading' data-bs-toggle='modal' data-title='Edit HAMAT' title='EDIT'><i class='fa fa-pencil mr-1'></i> Edit</a> -->
        <div id="table-default" class="table-responsive font-kecil">
          <table id="tabelnya" class="table nowrap order-column table-hover" style="width: 100% !important;">
            <thead>
              <tr>
                <th>Article</th>
                <th>Sat</th>
                <th>Tgl</th>
                <th>Nomor IB</th>
                <th>Invoice</th>
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

<div class="offcanvas offcanvas-start" tabindex="-1" id="modal-tambahdata" aria-labelledby=" offcanvasExampleLabel" style="width: 55%;">
  <div class="offcanvas-header bg-info" style="height: 20px;">
    <h5 class="offcanvas-title" id="offcanvasExampleLabel">Tambah Data Hamat</h5>
    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
  </div>
  <div class="offcanvas-body">
    <div id="loadform-tambah"></div>
  </div>
</div>
<div class="modal modal-blur fade" id="modal-large-tambah" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Tambah Data Hamat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-1">
        <div id="loadform-tambah-data"></div>
      </div>
    </div>
  </div>
</div>


<div class="modal modal-blur fade" id="modal-large-hamat" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header bg-info">
        <h5 class="modal-title">Edit Hamat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body fetched-data p-1">
        <div id="loadform-edit"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal modal-blur fade" id="modal-hapus" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
    <div class="modal-content">
      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      <div class="modal-status bg-danger"></div>
      <div class="modal-body text-center py-4">
        <svg class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
          <path stroke="none" d="M0 0h24v24H0z" fill="none" />
          <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
          <path d="M12 9v4" />
          <path d="M12 17h.01" />
        </svg>
        <h3>Anda Yakin,</h3>
        <div class="text-secondary" id="message">Data Ini Akan Di Hapus ?</div>
      </div>
      <div class="modal-footer">
        <div class="w-100">
          <div class="row">
            <div class="col"><a id="btn-okk" href="#" class="btn btn-danger w-100">
                Ya
              </a></div>
            <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                Tidak
              </a></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<script src="<?= base_url(); ?>assets/js/vendor/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/jquery/jquery-ui.min.js"></script>
<script>
  $(function() {

    $("#tambahdata").click(function() {
      $("#modal-large-tambah").modal("show");
      $("#loadform-tambah-data").load("<?= base_url('hargamat/tambahdata'); ?>");
    });

    // $(document).on("click", "#tambahdata", function() {
    //   var ModalTambah = new bootstrap.Modal(document.getElementById("modal-large-tambah"));
    //   ModalTambah.show();

    //   $("#loadform-tambah-data").load("<?= base_url(); ?>hargamat/tambahdata");
    // });

    // $(document).on("click", "#tambahdata", function() {
    //   var OffcanvasTambah = new bootstrap.Offcanvas(document.getElementById("modal-tambahdata"));
    //   OffcanvasTambah.show();

    //   $("#loadform-tambah").load("<?= base_url(); ?>hargamat/tambahdata");
    // });


    $(document).on('click', '.edit', function() {
      var data = $(this).data("id");
      console.log("Id Hamat:", data);

      if (data) {
        var Modalhamat = new bootstrap.Modal(document.getElementById('modal-large-hamat'));
        Modalhamat.show();

        $("#loadform-edit").load("<?= base_url(); ?>hargamat/edithamat/" + encodeURIComponent(data));
      } else {
        alert("Data tidak valid!");
      }
    });

    $(document).on('click', '.hapus', function() {
      var url = $(this).data("url");
      $("#btn-okk").attr("href", url);
      $("#modal-hapus").modal("show");
    });

  });
</script>