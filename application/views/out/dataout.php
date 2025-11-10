<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <div>OUT (Perpindahan Barang) # <?= $data['nomor_dok'] ?><br><span class="title-dok"><?php if($data['jn_bbl']==1){echo "dengan Bon Permintaan";}else{echo "tanpa Bon Permintaan";} ?></span></div>
          <input type="text" class="hilang" id="nomor_dok" value="<?= $data['nomor_dok']; ?>">
        </h2>
      </div>
      <input id="errornya" class="hilang" value="<?= $this->session->flashdata('errornya'); ?>">
      <div class="col-md-6" style="text-align: right;">
        <?php if ($mode == 'tambah') : ?>
          <a href="<?= base_url() . 'out'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="sisipkan">
          <?php if($this->session->flashdata('errornya')!=''): ?>
            <div class="alert alert-important alert-danger alert-dismissible bg-danger-lt mb-1" role="alert">
              <div class="d-flex"> 
                <div class="font-kecil">
                  <span class="text-black font-bold">INFORMATION</span><br>
                  <?= $this->session->flashdata('errornya'); ?>
                </div>
              </div>
              <a class="btn-close text-black font-bold" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            <?php endif; ?>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3">
                  <h4 class="mb-0 font-kecil">Tgl</h4>
                  <input type="text" id="tgldok" class="hilang" value="<?= tglmysql($data['tgl']); ?>">
                  <input type="text" id="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <a href="<?= base_url() . 'out/edit_tgl'; ?>" title="Edit Tgl" id="tglpb" name="tglpb" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                      <?= tglmysql($data['tgl']); ?>
                      <!-- <i class="fa fa-edit"></i> -->
                    </a>
                  </span>
                  <h4 class="mb-0 font-kecil">Catatan</h4>
                  <input type="text" id="catat" class="hilang" value="<?= $data['keterangan']; ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <?php if(in_array($data['dept_id'],daftardeptsubkon())){ ?>
                      <?= $data['keterangan']; ?> - BC ASAL <?= getnomorbcbykontrak($data['keterangan']) ?>
                    <?php }else{ ?>
                      <?= $data['keterangan']; ?>
                    <?php } ?>
                    <a href="<?= base_url() . 'out/edit_tgl'; ?>" title="Edit tanggal" id="catatan" name="catatan" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                      <i class="fa fa-edit"></i>
                    </a>
                  </span>
                </div>
                <div class="col-4">
                  <?php if($this->session->userdata('deptsekarang')=='GF' && $this->session->userdata('tujusekarang')=='CU'): ?>
                  <div class="">
                    <h4 class="mb-0 font-kecil font-bold">CUSTOMER</h4>
                    <div class="input-group">
                      <?php $tekstitle = $data['id_buyer'] == null ? 'Cari ' : 'Ganti '; ?>
                      <?php $tekstitle2 = $data['id_buyer'] == null || $data['id_buyer'] == 0 ? 'Cari ' : $data['id_buyer']; ?>
                      <a href="<?= base_url() . 'out/editcustomer'; ?>" class="btn font-bold bg-success" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Cari Customer" title="<?= $tekstitle; ?> Supplier"><?= $tekstitle2; ?></a>
                      <input type="text" class="form-control font-kecil" aria-label="Text input with dropdown button" placeholder="Nama Customer" value="<?= $data['nama_customer']; ?>">
                    </div>
                    <div class="mt-1">
                      <textarea class="form-control form-sm font-kecil" placeholder="Alamat"><?= $data['alamat']; ?></textarea>
                    </div>
                    <div class="mt-0" style="margin-top: 1px !important;">
                      <div class="input-icon">
                        <input type="text" class="form-control font-kecil" aria-label="Text input with dropdown" placeholder="Kontak" value="<?= $data['kontak']; ?>">
                        <span class="input-icon-addon" id="loadertgldtbt">

                        </span>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
                <div class="col-5">
                  <div class="text-right"><h4><?= $this->session->userdata('deptsekarang'); ?> to <?= $this->session->userdata('tujusekarang'); ?></h4></div>
                  <div style="position:absolute;bottom:0px;right:10px;">
                    <?php if($data['jn_bbl']==1){ ?>
                      <a data-bs-toggle="modal" data-bs-target="#modal-largescroll" data-title="Add Data" href="<?= base_url() . 'out/tambahdata/1' ?>" class="btn btn-sm btn-success">Get Barang</a>
                    <?php }else{ ?>
                      <a href="<?= base_url().'out/addbarangout'; ?>" class="btn btn-sm btn-success p-0" data-bs-toggle="modal" data-bs-target="#modal-largescroll2" data-title="Add Detail Barang">Input Barang</a>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-<?php if($data['jn_bbl']==1){ echo "12";}else{ echo "12";} ?> mt-1">
            <div id="table-default" class="table-responsive">
              <table class="table table-hover datatable6 text-nowrap" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <!-- <th>No</th> -->
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Satuan</th>
                    <?php if($data['jn_bbl']==1): ?>
                    <th>Qty MINTA</th>
                    <th>Kgs MINTA</th>
                    <?php endif; ?>
                    <th>Qty</th>
                    <th>Kgs</th>
                    <?php if($this->session->userdata('deptsekarang')=='GM'){ ?>
                    <th>Nobontr</th>
                    <?php } ?>
                    <?php if($this->session->userdata('deptsekarang')=='GP' || $this->session->userdata('deptsekarang')=='RR'){ ?>
                    <th>Insno</th>
                    <?php } ?>
                    <?php if($this->session->userdata('deptsekarang')=='GS'){ ?>
                    <th>SBL</th>
                    <?php } ?>
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
          <a href="#" class="btn btn-sm btn-primary" id="xsimpanout"><i class="fa fa-save mr-1"></i> Simpan Transaksi</a>
          <button href="#" class="btn btn-sm btn-primary hilang" id="simpanout" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini" data-href="<?= base_url() . 'out/simpanheaderout/' . $data['id']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
          <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" data-tombol="Ya" data-message="Akan Reset data ini" data-href="<?= base_url() . 'out/resetdetail/' . $data['id']; ?>"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
          <a class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="Rekap B.O.M OUT" href="<?= base_url() . 'out/viewrekapbom/' . $data['id']; ?>" id="viewrekap">View Rekap BOM</a>
        </div>
      </div>
    </div>
  </div>
</div>