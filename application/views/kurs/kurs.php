<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <div>Kurs</div>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-5">
            <div class="card btn-flat">
              <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs nav-fill" data-bs-toggle="tabs">
                  <li class="nav-item">
                    <a href="#tabs-home-5" id="kolombi" class="nav-link font-bold text-teal active" data-bs-toggle="tab">Kurs BI</a>
                  </li>
                  <li class="nav-item">
                    <a href="#tabs-profile-5" id="kolomkmk" class="nav-link font-bold text-cyan" data-bs-toggle="tab">Kurs KMK</a>
                  </li>
                </ul>
              </div>
              <div class="card-body">
                <div class="tab-content">
                  <div class="tab-pane active show" id="tabs-home-5">
                    <div>
                      <span class="font-bold font-13">Kurs BI Rate</span>
                      <span style="float: right;"><a href="<?= base_url() . 'kurs/addkursbi'; ?>" class="btn btn-sm btn-success py-0 px-1 btn-flat" title="Add Entitas" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Hapus IB" data-title="Isi Data Kurs BI"><i class="fa fa-plus mr-1"></i> Tambah Data</a></span>
                    </div>
                    <hr class="mt-3 mb-0">
                    <table id="tabelrate" class="table table-hover table-bordered cell-border" style="width: 100% !important; border-collapse: collapse;"> <!-- table order-column table-hover table-bordered cell-border -->
                      <thead>
                        <tr>
                          <th>Periode</th>
                          <th>USD</th>
                          <th>JPY</th>
                          <th>EUR</th>
                          <th>Act</th>
                        </tr>
                      </thead>
                      <tbody class="table-tbody" id="body-table" style="font-size: 13px !important; width: 100% !important;">
                      
                      </tbody>
                    </table>
                  </div>
                  <div class="tab-pane" id="tabs-profile-5">
                    <div>
                      <span class="font-bold font-13">Kurs KMK</span>
                    </div>
                    <hr class="mt-3 mb-0">
                    <table id="tabelkmk" class="table table-hover table-bordered cell-border" style="width: 100% !important; border-collapse: collapse;"> <!-- table order-column table-hover table-bordered cell-border -->
                      <thead>
                        <tr>
                          <th>Periode</th>
                          <th>USD</th>
                          <th>JPY</th>
                          <th>EUR</th>
                        </tr>
                      </thead>
                      <tbody class="table-tbody" id="body-table" style="font-size: 13px !important; width: 100% !important;">
                      
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-7 bg-primary-lt">
            <div class="text-right p-2">
              <div class="row font-kecil mb-0">
                <label class="col-6 col-form-label text-black">KURS</label>
                <div class="col mb-0">
                  <select class="form-select font-kecil" id="select-kurs">
                    <option value="usd">USD</option>
                    <option value="jpy">JPY</option>
                    <option value="eur">EUR</option>
                  </select>
                </div>
              </div>
            </div>
            <div class="card mt-0">
              <div class="card-body">
                <div class="card-title text-black font-bold">BI Rate</div>
                <div id="chart-kurs" style="height: 225px;"></div>
              </div>
            </div>
            <div class="card mt-2">
              <div class="card-body">
                <div class="card-title text-black font-bold">KMK</div>
                <div id="chart-kurskmk" style="height: 225px;"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>