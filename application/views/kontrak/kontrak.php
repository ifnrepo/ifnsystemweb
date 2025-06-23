<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Kontrak
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url(); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div class="sticky-top bg-white">
          <div class="row mb-1 d-flex align-items-between">
            <div class="col-sm-6">
              <?php $disab = '';
              if ($this->session->userdata('deptkontrak') == '' || $this->session->userdata('deptkontrak') == null || $this->session->userdata('jnsbckontrak') == '' || $this->session->userdata('jnsbckontrak') == null) {
                $disab = 'disabled';
              } ?>
              <a href="<?= base_url(); ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Transaksi" class="btn btn-primary btn-sm <?= $disab; ?>" id="adddatapb"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
              <input type="hidden" id="errorparam" value="<?= $this->session->flashdata('errorparam'); ?>">
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="th" name="th" style="width: 75px;" value="<?= $this->session->userdata('th') ?>">
              <select class="form-control form-sm font-kecil font-bold mr-1 hilang" id="bl" name="bl" style="width: 100px;">
                <?php for ($x = 1; $x <= 12; $x++) : ?>
                  <option value="<?= $x; ?>" <?php if ($this->session->userdata('bl') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                <?php endfor; ?>
              </select>
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2">
                  <h4 class="mb-1 font-kecil">Nama Rekanan</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="deptkontrak" name="deptkontrak">
                        <?php foreach ($deprekanan as $deptrekanan) {
                          $selek = $this->session->userdata('deptkontrak') == $deptrekanan['dept_id'] ? 'selected' : ''; ?>
                          <option value="<?= $deptrekanan['dept_id']; ?>" <?= $selek; ?>><?= $deptrekanan['departemen']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-2 ">
                  <h4 class="mb-1 font-kecil">Jenis Dokumen</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="jns_bc" name="jns_bc">
                        <option value="261" <?php if ($this->session->userdata('jnsbckontrak') == "261") {
                                              echo "selected";
                                            } ?>>BC 2.6.1</option>
                        <option value="40" <?php if ($this->session->userdata('jnsbckontrak') == "40") {
                                              echo "selected";
                                            } ?>>BC 4.0</option>
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1 font-kecil">.</h4>
                  <span class="font-kecil">
                    <a href="#" class="btn btn-sm btn-primary" style="height: 38px;min-width:45px;" id="butgo">Go</a>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1"></h4>
                </div>
                <div class="col-2">
                  <h4 class="mb-1">
                    <?php if ($disab != '') { ?>
                      <small class="text-pink text-center">Tekan <b>GO</b> untuk Load Data</small>
                    <?php } ?>
                  </h4>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>

        </div>
        <div>
          <table id="pbtabel" class="table nowrap order-column mt-1" style="width: 100% !important;">
            <thead>
              <tr>
                <th>Nomor</th>
                <th>Proses</th>
                <th>Nomor<br>AJU</th>
                <th>Tgl<br>Berlaku</th>
                <th>Tgl<br>Berakhir</th>
                <th>Pcs</th>
                <th>Kgs</th>
                <th>No/Tgl<br>SSB</th>
                <th>No/Tgl<br>Bpj</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php
              foreach ($data->result_array() as $datdet) :
              ?>
                <tr>
                  <td><?= $datdet['nomor']; ?></td>
                  <td><?= $datdet['proses']; ?></td>
                  <td><?= $datdet['nomor_aju']; ?></td>
                  <td><?= tglmysql($datdet['tgl_awal']); ?></td>
                  <td><?= tglmysql($datdet['tgl_akhir']); ?></td>
                  <td class="text-right"><?= rupiah($datdet['pcs'], 2); ?></td>
                  <td class="text-right"><?= rupiah($datdet['kgs'], 2); ?></td>
                  <td class="line-12"><span class="font-kecil"><?= tglmysql($datdet['tgl_ssb']); ?></span><br><?= $datdet['nomor_ssb']; ?></td>
                  <td class="line-12"><span class="font-kecil"><?= tglmysql($datdet['tgl_bpj']); ?></span><br><?= $datdet['nomor_bpj']; ?></td>
                  <td>
                    <!-- <td class='font-bold'><a href="<?= base_url() . 'akb/viewdetail/' . $datdet['id']; ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View detail OUT (AJU Keluar Barang)"><?= $datdet['nomor_dok'] ?></a></td> -->
                    <a href="<?= base_url('kontrak/view/') . $datdet['id']; ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail Kontrak" class="onprogress btn btn-sm btn-success btn-icon p-0">View</a>
                    <a href="#" class="onprogress btn btn-sm btn-primary btn-icon p-0">Edit</a>
                    <a href="#" class="onprogress btn btn-sm btn-danger btn-icon p-0">Delete</a>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>