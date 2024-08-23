<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Log Activity
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <!-- <a href="<?= base_url() . 'barang/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Barang"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a> -->
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">  
      <div class="row px-2">
        <div class="col-md-4 d-flex bg-red-lt">
          <div class="mb-1 font-kecil mr-1 mt-1">
            <label class="form-label font-kecil mb-1 font-bold">Tgl Awal</label>
            <div>
              <input type="email" class="form-control font-kecil" id="tglawal" value="<?= tglmysql($this->session->userdata('tglawallog')); ?>" aria-describedby="emailHelp" placeholder="Tgl Awal">
            </div>
          </div>
          <div class="mb-1 font-kecil mr-1 mt-1">
            <label class="form-label font-kecil mb-1 font-bold">Tgl Akhir</label>
            <div>
              <input type="email" class="form-control font-kecil" id="tglakhir" value="<?= tglmysql($this->session->userdata('tglakhirlog')); ?>" aria-describedby="emailHelp" placeholder="Tgl Akhir">
            </div>
          </div>
          <!-- <div class="mb-1 font-kecil mr-1 mt-1">
            <label class="form-label font-kecil mb-1 text-white">.</label>
            <div>
              <a href="" class="btn btn-sm btn-primary mt-1" id="butgo">Go</a>
            </div>
          </div> -->
        </div>
        <div class="col-md-4 bg-teal-lt">
          <div class="row">
            <div class="col-8 mb-1 font-kecil">
              <label class="form-label font-kecil mb-1 font-bold mt-1">User</label>
              <div>
                <select class="form-control form-select font-kecil" id="userlog">
                  <option value="">Semua User</option>
                  <?php foreach ($datauser->result_array() as $dete) { $sele = $this->session->userdata('userlogact')==$dete['iduserlog'] ? 'selected' : ''; ?>
                    <option value="<?= $dete['iduserlog']; ?>" <?= $sele; ?>><?= strtoupper($dete['userlog']); ?></option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="col-3 mb-1 font-kecil">
              <label class="form-label font-kecil mb-1 text-white mt-1">.</label>
              <div>
                <a href="" class="btn btn-sm btn-primary mt-1" id="butgo">Go</a>
              </div>
            </div>
          </div>
        </div>
        <div class="col-md-4">
        
        </div>
      </div>
      <hr class="p-1 m-1">
      <div class="card-body pt-1">
        <div id="table-default" class="table-responsive font-kecil">
          <table class="table datatablex">
            <thead>
              <tr>
                <th>Datetime Log</th>
                <th>Activity Log</th>
                <th>User Log</th>
                <th>Device Log</th>
              </tr>
            </thead>
            <tbody class="table-tbody" style="font-size: 13px !important;">
              <?php foreach ($data->result_array() as $det) { ?>
                <tr>
                  <td><?= tglmysql2($det['datetimelog']); ?></td>
                  <td><?= $det['activitylog']; ?></td>
                  <td><?= $det['userlog']; ?></td>
                  <td><?= getdevice($det['devicelog']); ?></td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>