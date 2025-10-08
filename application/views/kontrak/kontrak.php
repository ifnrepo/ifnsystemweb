<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Kontrak Makloon
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">

      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div class="sticky-top bg-white mb-2">
          <div class="row mb-1 d-flex align-items-between">
            <div class="col-sm-6">
              <?php
              $disab = '';
              if ($this->session->userdata('jnsbckontrak') == '' || $this->session->userdata('jnsbckontrak') == null) {
                $disab = 'disabled';
              }
              $disabe = '';
              if ($this->session->userdata('deptkontrak') == '' || $this->session->userdata('deptkontrak') == null) {
                $disabe = 'disabled';
              }
              ?>
              <a href="<?= base_url() . 'kontrak/adddata'; ?>" class="btn btn-primary btn-sm <?= $disabe; ?>" id="adddatakontrak"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
              <input type="hidden" id="errorparam" value="<?= $this->session->flashdata('errorparam'); ?>">
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
              <select class="form-control form-sm form-select font-kecil font-bold mr-1" id="th" name="th" style="width: 100px;">
                <option value="">Semua Tahun</option>
                <?php $yr = date('Y') - 5;
                $yd = date('Y');
                for ($x = $yr; $x <= $yd; $x++) : ?>
                  <option value="<?= $x; ?>" <?php if ($this->session->userdata('thkontrak') == $x) echo "selected"; ?>><?= $x; ?></option>
                <?php endfor; ?>
              </select>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2 hilang" id="the" name="the" style="width: 75px;" value="<?= $this->session->userdata('th') ?>">
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
                        <option value="">Semua Rekanan</option>
                        <?php foreach ($deprekanan as $deptrekanan) {
                          $selek = $this->session->userdata('deptkontrak') == $deptrekanan['dept_id'] ? 'selected' : ''; ?>
                          <option value="<?= $deptrekanan['dept_id']; ?>" <?= $selek; ?>><?= $deptrekanan['departemen']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-2">
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
                <div class="col-2">
                  <h4 class="mb-1 font-kecil">Status Dokumen</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="statuskontrak" name="statuskontrak">
                        <option value="3" <?php if ($this->session->userdata('statuskontrak') == "3") {
                                            echo "selected";
                                          } ?>>Semua</option>
                        <option value="1" <?php if ($this->session->userdata('statuskontrak') == "1") {
                                            echo "selected";
                                          } ?>>Masih Aktif</option>
                        <option value="2" <?php if ($this->session->userdata('statuskontrak') == "2") {
                                            echo "selected";
                                          } ?>>Sudah Berakhir</option>
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
                <div class="col-2">
                  <h4 class="mb-1">
                    <?php if ($disab != '') { ?>
                      <small class="text-pink text-center">Tekan <b>GO</b> untuk Load Data</small>
                    <?php } else { ?>
                      <div class="text-blue font-kecil" style="line-height: 10px;">
                        <label style="width: 70px;">Jumlah Rec</label><label style="width: 8px;">:</label><label><?= rupiah($jmlpcskgs['jmlrek'], 0); ?></label><br>
                        <label style="width: 70px;">Jumlah Pcs</label><label style="width: 8px;">:</label><label><?= rupiah($jmlpcskgs['pcs'], 0); ?></label><br>
                        <label style="width: 70px;">Jumlah Kgs</label><label style="width: 8px;">:</label><label><?= rupiah($jmlpcskgs['kgs'], 2); ?></label>
                      </div>
                    <?php } ?>
                  </h4>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>

        </div>
        <div>
          <table id="pbtabel" class="table nowrap order-column datatable mt-1" style="width: 100% !important;">
            <thead>
              <tr>
                <th>Nomor</th>
                <th>Proses</th>
                <!-- <th class="text-start">Nomor<br>AJU</th> -->
                <th>Tgl<br>Berlaku</th>
                <th>Tgl<br>Berakhir</th>
                <th>Pcs</th>
                <th>Kgs</th>
                <th>Realisasi</th>
                <th>Pengembalian</th>
                <th>Saldo</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php
              foreach ($data->result_array() as $datdet) : 
              $bold = ($datdet['kgs'] < $datdet['total_kgs']) ? 'font-bold' : '';
              $warnahuruf = ($datdet['kgs'] < $datdet['total_kgs']) ? 'text-pink' : 'text-primary';
              $saldo = $datdet['total_kgs'] - $datdet['tot_kgs_masuk'];
              ?>
                <tr>
                  <td class="line-12"><?= $datdet['nomor']; ?><br><span class="text-pink" style="font-size: 11px"><?= $datdet['departemen']; ?></span></td>
                  <td><?= $datdet['proses']; ?></td>
                  <td><?= tglmysql($datdet['tgl_awal']); ?></td>
                  <td><?= tglmysql($datdet['tgl_akhir']); ?></td>
                  <td class="text-right"><?= rupiah($datdet['pcs'], 2); ?></td>
                  <td class="text-right"><?= rupiah($datdet['kgs'], 2); ?></td>
                  <td class="text-right <?= $warnahuruf ?> <?= $bold ?>"><a href="<?= base_url().'kontrak/viewdetail/'.$datdet['id'] ?>" class="<?= $warnahuruf ?>" title="View detail" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail Realisasi dan Pengembalian"><?= rupiah($datdet['total_kgs'],2); ?></a></td>
                  <td class="text-right"><?= rupiah($datdet['tot_kgs_masuk'],2) ?></td>
                  <td class="text-right"><?= rupiah($saldo,2) ?></td>
                  <td>
                    <a href="<?= base_url('kontrak/view/') . $datdet['id']; ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail Kontrak" style="padding: 3px 5px !important;" class="btn btn-sm btn-success btn-icon p-0">View</a>
                    <a href="<?= base_url() . 'kontrak/editdata/' . $datdet['id']; ?>" class="onprogress btn btn-sm btn-primary btn-icon p-0" style="padding: 3px 5px !important;">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger btn-icon p-0" data-href="<?= base_url() . 'kontrak/hapuskontrak/' . $datdet['id'] ?>" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Hapus Kontrak <br><?= $datdet['nomor']; ?>" style="padding: 3px 5px !important;">Delete</a>
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