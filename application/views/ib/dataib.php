<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <div>IB (Penerimaan Barang) <br><span class="title-dok"><?= $data['nomor_dok']; ?></span></div>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">

        <a href="<?= base_url() . 'ib'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
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
                  <h4 class="mb-0 font-kecil font-bold">Tanggal Terima</h4>
                  <input type="text" id="tgldok" class="hilang" value="<?= tglmysql($data['tgl']); ?>">
                  <input type="text" id="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <input type="text" id="errorsimpan" class="hilang" value="<?= $this->session->flashdata('errorsimpan'); ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <a href="<?= base_url() . 'po/edittgl'; ?>" title="Edit tanggal" id="tglpo" name="tglpo" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan"><?= tglmysql($data['tgl']); ?></a>
                  </span>
                  <h4 class="mb-0 font-kecil mt-1 font-bold"></h4>
                  <div class="input-icon">
                    <select class="form-control form-select font-kecil font-bold" id="jn_ib">
                      <option value="0" <?php if ($data['jn_ib'] == 0) {
                                          echo "selected";
                                        } ?>>INVENTORY</option>
                      <option value="1" <?php if ($data['jn_ib'] == 1) {
                                          echo "selected";
                                        } ?>>CASH</option>
                    </select>
                  </div>
                  <div style="position:absolute;bottom:0px;left:10px;">
                    <div class="dropdown <?php if ($data['jn_ib'] == 0) {
                                            echo "hilang";
                                          } ?>">
                      <button class="btn btn-success btn-sm dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ml-1">Get Barang</span>
                      </button>
                      <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item font-kecil font-bold" data-bs-toggle="modal" data-bs-target="#modal-largescroll" data-title="Add Data" href="<?= base_url() . 'ib/getbarangib/' . $data['id_pemasok']; ?>" title="BBL Dari BON Permintaan">Dari PO</a>
                        <a class="dropdown-item font-kecil font-bold" data-bs-toggle="modal" data-bs-target="#modal-largescroll" data-title="Add Data" href="<?= base_url() . 'ib/getbarangib/'; ?>" title="BBL Tanpa BON Permintaan">Dari BBL</a>
                      </div>
                    </div>
                    <?php $ada = $data['jn_ib'] == 0 ? '/' . $data['id_pemasok'] : ''; ?>
                    <button href="<?= base_url() . 'ib/getbarangib' . $ada; ?>" data-bs-toggle="modal" data-bs-target="#modal-largescroll" data-title="Get data PO" id="getbarang" class="btn btn-sm btn-success hilang">Get</button>
                    <a href="#" id="cekbarang" class="btn btn-sm btn-success <?php if ($data['jn_ib'] == 1) {
                                                                                echo "hilang";
                                                                              } ?>">Get Barang</a>
                  </div>
                </div>
                <div class="col-4">
                  <h4 class="mb-0 font-kecil font-bold">SUPPLIER</h4>
                  <div class="input-group">
                    <?php $tekstitle = $data['id_pemasok'] == null ? 'Cari ' : 'Ganti '; ?>
                    <?php $tekstitle2 = $data['id_pemasok'] == null || $data['id_pemasok'] == 0 ? 'Cari ' : $data['id_pemasok']; ?>
                    <a href="<?= base_url() . 'ib/editsupplier'; ?>" class="btn font-bold bg-success" id="pilihsup" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Cari Supplier" title="<?= $tekstitle; ?> Supplier"><?= $tekstitle2; ?></a>
                    <input type="text" class="form-control font-kecil" aria-label="Text input with dropdown button" placeholder="Nama Supplier" value="<?= $data['namasupplier']; ?>">
                    <input type="hidden" id="id_pemasok" value="<?= $data['id_pemasok']; ?>">
                  </div>
                  <div class="mt-1">
                    <textarea class="form-control form-sm font-kecil" placeholder="Alamat"><?= $data['alamat']; ?></textarea>
                  </div>
                  <div class="mt-1">
                    <div class="input-icon">
                       <input type="text" class="form-control font-kecil" aria-label="Text input with dropdown" placeholder="Kontak" value="<?= $data['kontak']; ?>">
                  </div>

                  </div>
                </div>
                <div class="col-3">
                  <div class="row mt-1">
                    <label class="col-4 col-form-label font-bold">Nomor SJ</label>
                    <div class="col">
                      <input type="text" class="form-control font-kecil" id="nomor_sj" aria-label="Text input with dropdown" placeholder="Nomor SJ" value="<?= $data['nomor_sj']; ?>">
                    </div>
                  </div>
                  <div class="row mt-1">
                    <label class="col-4 col-form-label font-bold">Tgl SJ</label>
                    <div class="col">
                      <input type="text" class="form-control font-kecil inputtgl" id="tgl_sj" aria-label="Text input with dropdown" placeholder="Tgl SJ" value="<?= tglmysql($data['tgl_sj']); ?>">
                    </div>
                  </div>
                  <div class="row mt-1">
                    <label class="col-4 col-form-label font-bold">No Mobil</label>
                    <div class="col">
                      <input type="text" class="form-control font-kecil" id="no_kendaraan" aria-label="Text input with dropdown" placeholder="No Mobil" value="<?= $data['no_kendaraan']; ?>">
                    </div>
                  </div>
                  <div class="row mt-1">
                    <label class="col-4 col-form-label font-bold">No F. Pajak</label>
                    <div class="col">
                      <input type="text" class="form-control font-kecil" id="no_faktur_pajak" aria-label="Text input with dropdown" placeholder="No F. Pajak" value="<?= $data['no_faktur_pajak']; ?>">
                    </div>
                  </div>
                  <div class="row mt-1 text-center p-2">
                    <div id="generatenobc" class="col col-form-label font-bold bg-red-lt">BC No. 000000-000000-00000000-000000</div>
                  </div>
                </div>
                <div class="col-3 bg-cyan-lt p-2">
                  <div class="row mt-1">
                    <label class="col-4 col-form-label font-bold">Jenis BC</label>
                    <!-- <h4 class="mb-0 font-kecil font-bold">Nomor BC</h4> -->
                    <div class="col">
                      <select class="form-control form-select font-kecil font-bold" id="jns_bc">
                      <option value="">-- Pilih --</option>
                      <?php foreach ($jnsbc->result_array() as $bc) { ?>
                      <option value="<?= $bc['jns_bc']; ?>" <?php if($bc['jns_bc']==$data['jns_bc']){ echo "selected"; }; ?>><?= $bc['ket_bc']; ?></option>
                      <?php } ?>
                      </select>
                    </div>
                  </div>
                  <div class="row mt-1">
                    <label class="col-4 col-form-label font-bold">Tgl AJU</label>
                    <div class="col">
                      <input type="text" class="form-control font-kecil inputtgl" id="tgl_aju" aria-label="Text input with dropdown" placeholder="Tgl AJU" value="<?= tglmysql($data['tgl_aju']); ?>">
                    </div>
                  </div>
                  <div class="row mt-1">
                    <label class="col-4 col-form-label font-bold">Nomor AJU</label>
                    <!-- <h4 class="mb-0 font-kecil font-bold">Nomor AJU</h4> -->
                    <div class="col">
                      <input type="text" class="form-control font-kecil" id="nomor_aju" aria-label="Text input with dropdown" placeholder="Nomor AJU" value="<?= $data['nomor_aju']; ?>">
                    </div>
                  </div>
                  <div class="row mt-1">
                    <label class="col-4 col-form-label font-bold">Tgl BC</label>
                    <div class="col">
                      <input type="text" class="form-control font-kecil inputtgl" id="tgl_bc" aria-label="Text input with dropdown" placeholder="Tgl BC" value="<?= tglmysql($data['tgl_bc']); ?>">
                    </div>
                  </div>
                  <div class="row mt-1">
                    <label class="col-4 col-form-label font-bold">Nomor BC</label>
                    <!-- <h4 class="mb-0 font-kecil font-bold">Nomor BC</h4> -->
                    <div class="col">
                      <input type="text" class="form-control font-kecil" id="nomor_bc" aria-label="Text input with dropdown" autocomplete="off" placeholder="Nomor BC" value="<?= $data['nomor_bc']; ?>">
                    </div>
                  </div>
                </div>
              </div>
              <div class="hr m-1"></div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12">
            <div id="table-default" class="table-responsive mt-1">
              <table class="table datatable6 table-hover" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>No</th>
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Satuan</th>
                    <th>Qty PO</th>
                    <th>Qty Terima</th>
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
          <button class="btn btn-sm btn-primary" id="xsimpanib" ><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
          <button class="btn btn-sm btn-primary hilang" id="carisimpanib" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini" data-href="<?= base_url() . 'ib/simpanib/' . $data['id']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>

          <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
        </div>
      </div>
    </div>
  </div>
</div>