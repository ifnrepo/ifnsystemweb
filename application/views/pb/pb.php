<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          PB (Permintaan Barang)
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url(); ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="sisipkan" class="sticky-top bg-white">
          <div class="row mb-1 d-flex align-items-between">
            <div class="col-sm-6">
              <a href="<?= base_url().'pb/tambahdata'; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Transaksi" class="btn btn-primary btn-sm" id="adddatapb"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
              <?php $selek = $this->session->userdata('levelsekarang')== null ? $this->session->userdata('level_user') : $this->session->userdata('levelsekarang'); ?>
              <select class="form-control form-sm font-kecil font-bold bg-primary text-white" id="level" name="level" style="width: 150px;" <?= $levnow; ?>>
                <option value="1" <?php if($selek==1){echo "selected"; } ?>>User Maker</option>
                <option value="2" <?php if($levnow!='disabled' && $selek>=2){ echo "selected"; } ?>>User Approver</option>
              </select>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="th" name="th" style="width: 75px;" value="<?= $this->session->userdata('th') ?>">
              <select class="form-control form-sm font-kecil font-bold mr-1" id="bl" name="bl" style="width: 100px;" <?= $levnow; ?>>
                <?php for($x=1;$x<=12;$x++): ?>
                    <option value="<?= $x; ?>" <?php if($this->session->userdata('bl')==$x) echo "selected"; ?>><?= namabulan($x); ?></option>
                <?php endfor; ?>
              </select>
            </div>
          </div>
          <div class="card card-active" style="clear:both;" >
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2">
                  <h4 class="mb-1 font-kecil">Dept Asal</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-control form-sm font-kecil font-bold" id="dept_kirim"  name="dept_kirim">
                        <?php foreach ($hakdep as $hak): $selek = $this->session->userdata('deptsekarang')== null ? 'IT' : $this->session->userdata('deptsekarang'); ?>
                          <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?php if($selek==$hak['dept_id']) echo "selected"; ?>><?= $hak['departemen']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                </span>
                </div>
                <div class="col-2 ">
                  <h4 class="mb-1 font-kecil">Dept Tujuan</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-control form-sm font-kecil font-bold" id="dept_tuju" name="dept_tuju">
                       
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
                  <h4 class="mb-1"></h4>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
          
        </div>
        <div id="table-default" class="table-responsive">
          <table class="table datatable6" id="cobasisip">
            <thead>
              <tr>
                <th>Tgl</th>
                <th>Nomor</th>
                <th>Jumlah Item</th>
                <th>Dibuat Oleh</th>
                <th>Disetujui Oleh</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
        