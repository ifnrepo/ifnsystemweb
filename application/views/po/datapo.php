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
                  <h4 class="mb-0 font-kecil font-bold">Tanggal PO</h4>
                  <input type="text" id="tgldok" class="hilang" value="<?= tglmysql($data['tgl']); ?>">
                  <input type="text" id="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <input type="text" id="errorsimpan" class="hilang" value="<?= $this->session->flashdata('errorsimpan'); ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <a href="<?= base_url() . 'po/edittgl'; ?>" title="Edit tanggal" id="tglpo" name="tglpo" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan"><?= tglmysql($data['tgl']); ?></a>
                  </span>
                  <h4 class="mb-0 font-kecil mt-1 font-bold">Tgl Rencana Datang</h4>
                  <div class="input-icon">
                    <input type="text" id="tgldt" class="form-control input-sm font-kecil" value="<?= tglmysql($data['tgl_dtb']); ?>">
                    <span class="input-icon-addon" id="loadertgldt">

                    </span>
                  </div>
                </div>
                <div class="col-4">
                  <h4 class="mb-0 font-kecil font-bold">SUPPLIER</h4>
                  <div class="input-group">
                    <?php $tekstitle = $data['id_pemasok'] == null ? 'Cari ' : 'Ganti '; ?>
                    <?php $tekstitle2 = $data['id_pemasok'] == null || $data['id_pemasok'] == 0 ? 'Cari ' : $data['id_pemasok']; ?>
                    <a href="<?= base_url() . 'po/editsupplier'; ?>" class="btn font-bold bg-success" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Cari Supplier" title="<?= $tekstitle; ?> Supplier"><?= $tekstitle2; ?></a>
                    <input type="text" class="form-control font-kecil" aria-label="Text input with dropdown button" placeholder="Nama Supplier" value="<?= $data['namasupplier']; ?>">
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
                <div class="col-3">
                  <h4 class="mb-0 font-kecil font-bold">Jenis Pembayaran</h4>
                  <div class="input-group">
                    <select class="form-control form-select font-kecil font-bold text-primary" id="jn_pembayaran">
                      <option value=""></option>
                      <option value="CASH" <?php if($data['jenis_pembayaran']=='CASH'){ echo "Selected"; } ?>>CASH</option>
                      <option value="KREDIT" <?php if($data['jenis_pembayaran']=='KREDIT'){ echo "Selected"; } ?>>KREDIT</option>
                      <option value="ADVANCE" <?php if($data['jenis_pembayaran']=='ADVANCE'){ echo "Selected"; } ?>>ADVANCE</option>
                      <option value="SAMPLE" <?php if($data['jenis_pembayaran']=='SAMPLE'){ echo "Selected"; } ?>>SAMPLE</option>
                    </select>
                    <input type="text" class="form-control font-kecil" id="tgldtbt" aria-label="Text input with dropdown button" placeholder="Tgl.." value="<?= tglmysql($data['tgl_rencana_bayar']); ?>" disabled>
                  </div>
                  <div class="row mt-1">
                    <label class="col-6 col-form-label font-bold">Mata Uang</label>
                    <div class="col">
                      <select class="form-control form-select font-kecil font-bold text-primary" id="mt_uang">
                        <option value=""></option>
                        <?php foreach ($mtuang->result_array() as $uang) { ?>
                        <option value="<?= $uang['mt_uang']; ?>" <?php if($data['mt_uang']== $uang['mt_uang']){ echo "Selected"; } ?>><?= $uang['mt_uang']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </div>
                  <h4 class="mb-0 font-kecil font-bold">Terms Of Payment</h4>
                  <div class="input-group">
                    <select class="form-control form-select font-kecil font-bold text-primary" id="term_payment">
                      <option value=""></option>
                      <?php foreach ($termspay->result_array() as $terms) { ?>
                        <option value="<?= $terms['id']; ?>" <?php if($data['id_term_payment']== $terms['id']){ echo "Selected"; } ?>><?= $terms['detail']; ?></option>
                      <?php } ?>
                    </select>
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
            <div class="p-2">
            <textarea class="form-control form-sm font-kecil btn-flat" id="header_po" style="font-size: 14px;"><?= $data['header_po']; ?></textarea>
            </div>
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
        <div class="row">
          <div class="col-8">
            <p class="mb-1">Catatan :</p>
            <input type="text" class="form-control" id="catatan1" aria-label="Text input with dropdown button" placeholder="Catatan 1" value="<?= $data['catatan1']; ?>">
            <input type="text" class="form-control mt-1" id="catatan2" aria-label="Text input with dropdown button" placeholder="Catatan 2" value="<?= $data['catatan2']; ?>">
            <input type="text" class="form-control mt-1" id="catatan3" aria-label="Text input with dropdown button" placeholder="Catatan 2" value="<?= $data['catatan3']; ?>">
          </div>
          <!-- <div class="col-4"></div> -->
          <div class="col-4">
            <div class="row mt-1">
              <label class="col-3 col-form-label">Jumlah</label>
              <div class="col">
                <input type="text" class="form-control font-bold text-right" id="totalharga" aria-label="Text input with dropdown button" placeholder="Jumlah" value="" readonly>
              </div>
            </div>
            <div class="row mt-1">
              <label class="col-3 col-form-label">Diskon</label>
              <div class="col">
                <input type="text" class="form-control inputangka text-right" id="diskon" placeholder="Diskon" value="<?= rupiah($data['diskon'],2); ?>" >
              </div>
            </div>
            <div class="row mt-1">
              <label class="col-3 col-form-label">DPP</label>
              <div class="col">
                <input type="text" class="form-control font-bold text-right" id="total" aria-label="Text input with dropdown button" placeholder="DPP" value="" readonly>
              </div>
            </div>
            <div class="row mt-1">
              <label class="col-3 col-form-label">% PPN</label>
              <div class="col">
                <input type="text" class="form-control inputangka text-right" id="cekppn" aria-label="Text input with dropdown button" placeholder="Persentase PPN" value="<?= rupiah($data['cekppn'],2); ?>">
              </div>
            </div>
            <div class="row mt-1">
              <label class="col-3 col-form-label">Nilai PPN</label>
              <div class="col">
                <input type="text" class="form-control font-bold text-right" id="hargappn" aria-label="Text input with dropdown button" placeholder="Total PPN" value="<?= rupiah($data['ppn'],2); ?>" readonly>
              </div>
            </div>
            <div class="row mt-1">
              <label class="col-3 col-form-label">PPH</label>
              <div class="col">
                <input type="text" class="form-control inputangka text-right" id="pph" aria-label="Text input with dropdown button" placeholder="Total PPH" value="<?= rupiah($data['pph'],2); ?>">
              </div>
            </div>
            <div class="row mt-1">
              <label class="col-3 col-form-label">TOTAL</label>
              <div class="col">
                <input type="text" class="form-control font-bold text-right" id="jumlah" aria-label="Text input with dropdown button" placeholder="Total" value="" readonly>
              </div>
            </div>
          </div>
        </div>
        <hr class="m-1">
        <div class="form-tombol mt-1 text-right">
          <input type="text" id="jmlrek" class="hilang">
          <button class="btn btn-sm btn-primary" id="xsimpanpo" ><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
          <button class="btn btn-sm btn-primary hilang" id="carisimpanpo" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini" data-href="<?= base_url() . 'po/simpanpo/' . $data['id']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
          <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
        </div>
      </div>
    </div>
  </div>
</div>