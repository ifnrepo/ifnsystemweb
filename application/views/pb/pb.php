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
        <div id="sisipkan" class="hilang">
          <div class="mb-1">
            <a href="#" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Data BOM" class="btn btn-primary btn-sm" ><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            <a href="#" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEnd" data-title="Add Data BOM" class="btn btn-success btn-sm" ><i class="fa fa-file-o"></i><span class="ml-1">Browse Data</span></a>
          </div>
          <div class="card card-active" style="clear:both;" >
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3">
                  <h4 class="mb-1 font-kecil">Dept Asal</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-sm font-kecil font-bold">
                        <option>Option 1</option>
                      </select>
                    </div>
                </span>
                </div>
                <div class="col-3 ">
                  <h4 class="mb-1 font-kecil">Dept Tujuan</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-sm font-kecil font-bold">
                        <option>Option 1</option>
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1 font-kecil">Total Persen BOM</h4>
                  <span class="font-kecil"></span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1"></h4>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <div id="table-default" class="table-responsive">
          <table class="table datatabledengandiv" id="cobasisip">
            <thead>
              <tr>
                <th>Tgl</th>
                <th>Nomor</th>
                <th>Dibuat Oleh</th>
                <th>Disetujui Oleh</th>
              </tr>
            </thead>
            <tbody class="table-tbody" style="font-size: 13px !important;" >

            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
        