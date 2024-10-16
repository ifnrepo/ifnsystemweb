<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Mesin/Asset
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'satuan/tambahdata'; ?>" class="btn btn-primary btn-sm disabled" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Satuan"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div class="card card-active mb-2">
          <div class="card-body p-1 text-right">
            <div class="row d-flex align-items-between">
              <div class="col-3">
                <div class="row mb-0">
                  <label class="col-3 col-form-label font-kecil">Lokasi</label>
                  <div class="col font-kecil">
                    <select class="form-control form-select font-kecil font-bold" name="lokasi" id="lokasi">
                      <option value="">Semua Lokasi</option>
                      <?php foreach ($lokasi->result_array() as $lok) {
                        $selek = $this->session->userdata('lokasimesin') == $lok['lokasi'] ? 'selected' : ''; ?>
                        <option value="<?= $lok['lokasi']; ?>" <?= $selek; ?>><?= $lok['lokasi']; ?></option>
                      <?php } ?>
                    </select>
                  </div>
                </div>
                <div class="row mt-0">
                  <label class="col-3 col-form-label font-kecil"></label>
                  <div class="col font-kecil text-left m-1 bg-red-lt">
                    <label class="form-check pt-1">
                      <?php $ceked = $this->session->userdata('disposalmesin') == 1 ? 'checked' : ''; ?>
                      <input class="form-check-input" type="checkbox" id="cekdisposal" name="cekdisposal" <?= $ceked; ?>>
                      <span class="form-check-label">Cek Disposal</span>
                    </label>
                  </div>
                </div>
                <!-- <div class="row text-left">
                    <div class="col">
                    <label class="form-check">
                      <input class="form-check-input" type="checkbox"  checked>
                      <span class="form-check-label">Checked checkbox input</span>
                    </label>  
                    </div>
                  </div> -->
              </div>
              <div class="col-9">
                <a href="<?= base_url() . 'mastermsn/excel?lokasi=' . $this->session->userdata('lokasimesin') . '&cekdisposal=' . $this->session->userdata('disposalmesin'); ?>" class="btn btn-success btn-sm">
                  <i class="fa fa-file-excel-o"></i><span class="ml-1">Export To Excel</span>
                </a>
                <a href="<?= base_url() . 'mastermsn/cetakpdf?lokasi=' . $this->session->userdata('lokasimesin') . '&cekdisposal=' . $this->session->userdata('disposalmesin'); ?>" target="_blank" class="btn btn-danger btn-sm">
                  <i class="fa fa-file-pdf-o"></i><span class="ml-1">Export To PDF</span>
                </a>

              </div>
            </div>
          </div>
        </div>
        <div id="table-default" class="table-responsive">
          <table class="table datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Kode Asset</th>
                <th>Lokasi</th>
                <th>Spek Mesin</th>
                <th>Harga</th>
                <th>Asset</th>
                <th>Tgl Masuk</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" style="font-size: 13px !important;">
              <?php $no = 0;
              foreach ($data->result_array() as $res) {
                $no++;
                $red = $res['ok_disp'] == 1 ? 'text-red' : ''; ?>
                <tr class="<?= $red; ?>">
                  <td><?= $no; ?></td>
                  <td><?= $res['kode']; ?></td>
                  <td><?= $res['kode_fix']; ?></td>
                  <td><?= $res['lokasi']; ?></td>
                  <td><?= $res['nama_barang']; ?></td>
                  <td><?= rupiah(($res['harga'] * $res['kurs']) + $res['landing'], 2); ?></td>
                  <td class="text-center">
                    <?php if ($res['is_asset'] == 1) { ?>
                      <i class="fa fa-check text-success"></i>
                    <?php } ?>
                  </td>
                  <td><?= tglmysql($res['tglmasuk']); ?></td>
                  <td>
                    <div class="btn-group" role="group">
                      <label for="btn-radio-dropdown-dropdown" class="btn btn-sm btn-success btn-flat dropdown-toggle text-black" style="padding: 0px 5px !important" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Aksi
                      </label>
                      <div class="dropdown-menu" style="min-width: 20px !important;">
                        <label class="dropdown-item py-1">
                          <a href="<?= base_url() . 'mastermsn/editmesin/' . $res['idx']; ?>" class="btn btn-sm btn-primary btn-icon text-white w-100" rel="<?= $res['id']; ?>" title="Edit data">
                            <i class="fa fa-edit pr-1"></i> Edit
                          </a>
                        </label>
                        <!-- <label class="dropdown-item py-1">
                                  <a class="btn btn-sm btn-danger btn-icon text-white w-100" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'mastermsn/disposal/' . $res['id']; ?>" title="Hapus data">
                                      <i class="fa fa-trash-o pr-1"></i> Disposal
                                  </a>
                              </label> -->
                        <label class="dropdown-item py-1">
                          <a href="<?= base_url() . 'viewmsn/mesinno/' . encrypto($res['kode_fix']); ?>" class="btn btn-sm btn-teal btn-icon w-100" id="edituser" rel="<?= $res['id']; ?>" title="View data">
                            <i class="fa fa-eye pr-1"></i> View
                          </a>
                        </label>
                      </div>
                    </div>
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