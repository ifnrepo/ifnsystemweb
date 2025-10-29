<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<div class="page-body">
  <div class="container-xl">
    <div class="row row-deck row-cards">
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Php Info ON <span class="subheader"><?= ENVIRONMENT; ?> MODE</span></div>
              <div class="ms-auto lh-1">
                <!-- <div class="dropdown">
                  <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item active" href="#">Last 7 days</a>
                    <a class="dropdown-item" href="#">Last 30 days</a>
                    <a class="dropdown-item" href="#">Last 3 months</a>
                  </div>
                </div> -->
              </div>
            </div>
            <div class="h1 mb-3"><?= phpversion() ?></div>
            <div class="d-flex mb-2">
              <!-- <div>Conversion rate</div> -->
              <div class="ms-auto">
                <!-- <span class="text-green d-inline-flex align-items-center lh-1"> -->
                  - <!-- Download SVG icon from http://tabler-icons.io/i/trending-up -->
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg> -->
                <!-- </span> -->
              </div>
            </div>
            <div class="progress progress-sm">
              <div class="progress-bar bg-primary" style="width: 80%" role="progressbar" aria-valuenow="80" aria-valuemin="0" aria-valuemax="100" aria-label="80% Complete">
                <span class="visually-hidden">80% Complete</span>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">Produksi <?= date('m').' - '.date('Y'); ?></div>
              <div class="ms-auto lh-1">
                <!-- <div class="dropdown">
                  <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item active" href="#">Last 7 days</a>
                    <a class="dropdown-item" href="#">Last 30 days</a>
                    <a class="dropdown-item" href="#">Last 3 months</a>
                  </div>
                </div> -->
              </div>
            </div>
            <div class="d-flex align-items-baseline">
              <div class="h1 mb-0 me-2"><?= rupiah($dataproduksi['data_prod_bulan_ini'],0); ?> Kgs</div>
              <div class="me-auto">
                <?php 
                  $produksibulanlalu = $dataproduksi['data_prod_bulan_lalu']==0 ? 1 : $dataproduksi['data_prod_bulan_lalu'];
                  $persenproduksi = (($dataproduksi['data_prod_bulan_ini']-$dataproduksi['data_prod_bulan_lalu'])/$produksibulanlalu)*100;
                  $naikturun = $persenproduksi < 0 ? 'text-red' : 'text-green';
                 ?>
                <span class="<?= $naikturun; ?> d-inline-flex align-items-center lh-1">
                  <?= rupiah(abs($persenproduksi),0); ?>% <!-- Download SVG icon from http://tabler-icons.io/i/trending-up -->
                  <?php if($persenproduksi < 0){ ?>
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trending-down"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7l6 6l4 -4l8 8" /><path d="M21 10l0 7l-7 0" /></svg>
                  <?php }else{ ?>
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                  <?php } ?>
                </span>
              </div>
            </div>
          </div>
          <div id="chart-revenue-bg" class="chart-sm"></div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body">
            <div class="d-flex align-items-center">
              <div class="subheader">LOGIN / MONTH </div>
              <div class="ms-auto lh-1">
                <!-- <div class="dropdown">
                  <a class="dropdown-toggle text-secondary" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Last 7 days</a>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item active" href="#">Last 7 days</a>
                    <a class="dropdown-item" href="#">Last 30 days</a>
                    <a class="dropdown-item" href="#">Last 3 months</a>
                  </div>
                </div> -->
                <?php
                  $jumlperson = 0; 
                  foreach($personlogin->result_array() as $pers){ 
                    $jumlperson += $pers['personlog'];
                  }
                ?>
              </div>
            </div>
            <div class="d-flex align-items-baseline">
              <div class="h1 mb-3 me-2"><?= rupiah($jumlperson,0) ?></div>
              <div class="me-auto line-12">
                <span class="text-secondary d-inline-flex align-items-center lh-1 font-11">
                  USER<!-- Download SVG icon from http://tabler-icons.io/i/minus -->
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon ms-1" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /></svg> -->
                </span>
              </div>
            </div>
            <div id="chart-new-clients" class="chart-sm"></div>
          </div>
        </div>
      </div>
      <div class="col-sm-6 col-lg-3">
        <div class="card">
          <div class="card-body pb-1">
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <div class="subheader text-teal line-12">Kurs USD - KMK</div>
              </div>
              <div class="text-right">
                <div class="subheader text-teal line-12">Kurs JPY - KMK</div>
              </div>
            </div>
            <div class="d-flex justify-content-between align-items-baseline">
              <div>
                <?php if(isset($kurshariini['usd'])){ ?>
                  <div class="h3 mb-3 me-2">IDR <?= rupiah($kurshariini['usd'],2) ?></div>
                <?php }else{ ?>
                  <div class="h3 mb-3 me-2">NOT FOUND</div>
                <?php } ?>
              </div>
              <div class="text-right">
                <?php if(isset($kurshariini['usd'])){ ?>
                  <div class="h3 mb-3">IDR <?= rupiah($kurshariini['jpy'],2) ?></div>
                <?php }else{ ?>
                  <div class="h3 mb-3 me-2">NOT FOUND</div>
                <?php } ?>
              </div>
            </div>
            <div id="chart-active-users" class="chart-sm"></div>
            <div class="m-0 subheader"><i><?= tgl_indo(date('Y-m-d'),1) ?></i></div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="row row-cards">
          <div class="col-sm-12">
            <div class="card card-sm bg-primary text-primary-fg">
              <div class="card-stamp">
                <div class="card-stamp-icon bg-white text-primary">
                  <!-- Download SVG icon from http://tabler-icons.io/i/star -->
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" /></svg> -->
                  <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-background"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 8l4 -4" /><path d="M14 4l-10 10" /><path d="M4 20l16 -16" /><path d="M20 10l-10 10" /><path d="M20 16l-4 4" /></svg> -->
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-description"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M9 17h6" /><path d="M9 13h6" /></svg>
                </div>
              </div>
              <div class="card-body">
                <?php 
                    $date = date('Y-m-d');
                  	$new_date_timestamp = $this->session->userdata('tglmonbcawal');
                  	$new_date_timestamp2 = $this->session->userdata('tglmonbcakhir');
                    $xdate = date('Y-m-d', $new_date_timestamp);
                    $ydate = date('Y-m-d', $new_date_timestamp2);
                    $bc23=0;$bc40=0;$bc25=0;$bc30=0;$bc41=0;$bc261=0;$bc262=0;$bc40m=0;$bc41m=0;
                    foreach($bc2bulan->result_array() as $bcdok){
                      $indek = trim($bcdok['jns_bc']).$bcdok['bc_makloon'];
                      switch ($indek) {
                        case '230':
                            $bc23 += $bcdok['jmlbc'];
                          break;
                        case '400':
                            $bc40 += $bcdok['jmlbc'];
                          break;
                        case '250':
                            $bc25 += $bcdok['jmlbc'];
                          break;
                        case '300':
                            $bc30 += $bcdok['jmlbc'];
                          break;
                        case '410':
                            $bc41 += $bcdok['jmlbc'];
                          break;
                        case '2610':
                            $bc261 += $bcdok['jmlbc'];
                          break;
                        case '2620':
                            $bc262 += $bcdok['jmlbc'];
                          break;
                        case '411':
                            $bc41m += $bcdok['jmlbc'];
                          break;
                        case '401':
                            $bc40m += $bcdok['jmlbc'];
                          break;
                        default:
                          # code...
                          break;
                      }
                    }
                 ?>
                <div class="d-flex justify-content-between">
                  <div class="subheader mb-2 text-white">Jumlah Dokumen BC</div>
                  <div class="row mb-1">
                    <label class="subheader col-3 col-form-label text-white p-1"></label>
                    <div class="col">
                      <input type="email" class="form-control form-sm font-kecil btn-flat p-1 tglpilih" id="tglmonbcawal" aria-describedby="emailHelp" placeholder="Tgl awal" value="<?= tglmysql($xdate) ?>">
                    </div>
                    s/d
                    <div class="col">
                      <input type="email" class="form-control form-sm font-kecil btn-flat p-1 tglpilih" id="tglmonbcakhir" aria-describedby="emailHelp" placeholder="Enter email" value="<?= tglmysql($ydate) ?>">
                    </div>
                    <div class="col text-center">
                      <a href="#" class="btn btn-sm btn-success btn-flat" style="height: 28px !important;" id="settglmonitoring">Go</a>
                      <a href="<?= base_url().'main/resettglmonitoring' ?>" class="btn btn-sm btn-danger btn-flat" style="height: 28px !important;" id="resettglmonitoring">Reset</a>
                    </div>
                  </div>
                </div>
                <hr class="m-1">
                <!-- <div id="chart-dokbc" class="chart-sm" style="height: 1000px;"></div> -->
                <div class="row">
                  <div class="col-sm-3">
                    <div class="col-sm-12">
                      <div class="card">
                        <div class="card-stamp">
                          <div class="card-stamp-icon bg-yellow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-down-dashed"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5v.5m0 3v1.5m0 3v6" /><path d="M16 15l-4 4" /><path d="M8 15l4 4" /></svg>
                          </div>
                        </div>
                        <div class="card-body">
                          <!-- <h3 class="card-title">BC MASUK 23-40-40 Makloon</h3> -->
                          <div class="card-title text-black font-bold">Dokumen BC 23 & 40 </div>
                          <p class="text-secondary">
                            <div class="font-kecil">
                              <span class="badge bg-pink ms-auto"></span> BC 23 : <?= $bc23.' Dok' ?>
                            </div>
                            <div class="font-kecil">
                              <span class="badge bg-info ms-auto"></span> BC 40 : <?= $bc40.' Dok' ?>
                            </div>
                            <div class="font-kecil">
                              <span class="badge ms-auto"></span>
                            </div>
                          </p>
                          <div id="chart-dokbcmasuk" class="chart-sm"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="col-sm-12">
                      <div class="card">
                        <div class="card-stamp">
                          <div class="card-stamp-icon bg-yellow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-narrow-up-dashed"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5v6m0 3v1.5m0 3v.5" /><path d="M16 9l-4 -4" /><path d="M8 9l4 -4" /></svg>
                          </div>
                        </div>
                        <div class="card-body">
                          <!-- <h3 class="card-title">BC MASUK 23-40-40 Makloon</h3> -->
                          <div class="card-title text-black font-bold">Dok BC 25,30 & 41 </div>
                          <p class="text-secondary mt-0">
                            <div class="font-kecil">
                              <span class="badge bg-green ms-auto"></span> BC 25 : <?= $bc25.' Dok' ?>
                            </div>
                            <div class="font-kecil">
                              <span class="badge bg-info ms-auto"></span> BC 30 : <?= $bc30.' Dok' ?>
                            </div>
                            <div class="font-kecil">
                              <span class="badge bg-orange ms-auto"></span> BC 41 : <?= $bc41.' Dok' ?>
                            </div>
                          </p>
                          <div id="chart-dokbckeluar" class="chart-sm"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="col-sm-12">
                      <div class="card">
                        <div class="card-stamp">
                          <div class="card-stamp-icon bg-yellow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-double-ne-sw"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 14l11 -11" /><path d="M10 3h4v4" /><path d="M10 17v4h4" /><path d="M21 10l-11 11" /></svg>
                          </div>
                        </div>  
                        <div class="card-body">
                          <!-- <h3 class="card-title">BC MASUK 23-40-40 Makloon</h3> -->
                          <div class="card-title text-black font-bold">Dok BC 261 & 262 </div>
                          <p class="text-secondary mt-0">
                            <div class="font-kecil">
                              <span class="badge bg-orange ms-auto"></span> BC 261 :  <?= $bc261.' Dok' ?>
                            </div>
                            <div class="font-kecil">
                              <span class="badge bg-info ms-auto"></span> BC 262 : <?= $bc262.' Dok' ?>
                            </div>
                            <div class="font-kecil">
                              <span class="badge ms-auto"></span>
                            </div>
                          </p>
                          <div id="chart-dokbcsubkon" class="chart-sm"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-sm-3">
                    <div class="col-sm-12">
                      <div class="card">
                        <div class="card-stamp">
                          <div class="card-stamp-icon bg-yellow">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrows-double-ne-sw"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 14l11 -11" /><path d="M10 3h4v4" /><path d="M10 17v4h4" /><path d="M21 10l-11 11" /></svg>
                          </div>
                        </div>
                        <div class="card-body">
                          <!-- <h3 class="card-title">BC MASUK 23-40-40 Makloon</h3> -->
                          <div class="card-title text-black font-bold">Makloon BC 40 & 41 </div>
                          <p class="text-secondary mt-0">
                            <div class="font-kecil">
                              <span class="badge bg-purple ms-auto"></span> BC 40 : <?= $bc40m.' Dok' ?>
                            </div>
                            <div class="font-kecil">
                              <span class="badge bg-info ms-auto"></span> BC 41 : <?= $bc41m.' Dok' ?>
                            </div>
                            <div class="font-kecil">
                              <span class="badge ms-auto"></span>
                            </div>
                          </p>
                          <div id="chart-dokbcmakloon" class="chart-sm"></div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12">
        <div class="row row-cards">
          <!-- <div class="col-md-6 col-lg-3">
            <div class="card">
              <div class="card-stamp">
                <div class="card-stamp-icon bg-yellow">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 5a2 2 0 1 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" /><path d="M9 17v1a3 3 0 0 0 6 0v-1" /></svg>
                </div>
              </div>
              <div class="card-body">
                <h3 class="card-title">Card with icon bg</h3>
                <p class="text-secondary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto at consectetur culpa ducimus eum fuga fugiat, ipsa iusto, modi nostrum recusandae reiciendis saepe.</p>
              </div>
            </div>
          </div> -->
          <div class="col-sm-6 col-lg-3">
            <div class="card card-sm card-primary">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <span class="bg-primary text-white avatar">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M16.7 8a3 3 0 0 0 -2.7 -2h-4a3 3 0 0 0 0 6h4a3 3 0 0 1 0 6h-4a3 3 0 0 1 -2.7 -2" /><path d="M12 3v3m0 12v3" /></svg>
                    </span>
                  </div>
                  <div class="col">
                    <div class="font-weight-medium">
                      132 Sales
                    </div>
                    <div class="text-secondary">
                      12 waiting payments
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <span class="bg-green text-white avatar">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 19m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M17 17h-11v-14h-2" /><path d="M6 5l14 1l-1 7h-13" /></svg>
                    </span>
                  </div>
                  <div class="col">
                    <div class="font-weight-medium">
                      78 Orders
                    </div>
                    <div class="text-secondary">
                      32 shipped
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <span class="bg-twitter text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-twitter -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M22 4.01c-1 .49 -1.98 .689 -3 .99c-1.121 -1.265 -2.783 -1.335 -4.38 -.737s-2.643 2.06 -2.62 3.737v1c-3.245 .083 -6.135 -1.395 -8 -4c0 0 -4.182 7.433 4 11c-1.872 1.247 -3.739 2.088 -6 2c3.308 1.803 6.913 2.423 10.034 1.517c3.58 -1.04 6.522 -3.723 7.651 -7.742a13.84 13.84 0 0 0 .497 -3.753c0 -.249 1.51 -2.772 1.818 -4.013z" /></svg>
                    </span>
                  </div>
                  <div class="col">
                    <div class="font-weight-medium">
                      623 Shares
                    </div>
                    <div class="text-secondary">
                      16 today
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-lg-3">
            <div class="card card-sm">
              <div class="card-body">
                <div class="row align-items-center">
                  <div class="col-auto">
                    <span class="bg-facebook text-white avatar"><!-- Download SVG icon from http://tabler-icons.io/i/brand-facebook -->
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 10v4h3v7h4v-7h3l1 -4h-4v-2a1 1 0 0 1 1 -1h3v-4h-3a5 5 0 0 0 -5 5v2h-3" /></svg>
                    </span>
                  </div>
                  <div class="col">
                    <div class="font-weight-medium">
                      132 Likes
                    </div>
                    <div class="text-secondary">
                      21 today
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">Traffic summary</h3>
            <div id="chart-mentions" class="chart-lg"></div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card">
          <div class="card-body">
            <h3 class="card-title">Locations</h3>
            <div class="ratio ratio-21x9">
              <div>
                <div id="map-world" class="w-100 h-100"></div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- <div class="col-lg-6">
        <div class="row row-cards">
          <div class="col-12">
            <div class="card">
              <div class="card-body">
                <p class="mb-3">Using Storage <strong>6854.45 MB </strong>of 8 GB</p>
                <div class="progress progress-separated mb-3">
                  <div class="progress-bar bg-primary" role="progressbar" style="width: 44%" aria-label="Regular"></div>
                  <div class="progress-bar bg-info" role="progressbar" style="width: 19%" aria-label="System"></div>
                  <div class="progress-bar bg-success" role="progressbar" style="width: 9%" aria-label="Shared"></div>
                </div>
                <div class="row">
                  <div class="col-auto d-flex align-items-center pe-2">
                    <span class="legend me-2 bg-primary"></span>
                    <span>Regular</span>
                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">915MB</span>
                  </div>
                  <div class="col-auto d-flex align-items-center px-2">
                    <span class="legend me-2 bg-info"></span>
                    <span>System</span>
                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">415MB</span>
                  </div>
                  <div class="col-auto d-flex align-items-center px-2">
                    <span class="legend me-2 bg-success"></span>
                    <span>Shared</span>
                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">201MB</span>
                  </div>
                  <div class="col-auto d-flex align-items-center ps-2">
                    <span class="legend me-2"></span>
                    <span>Free</span>
                    <span class="d-none d-md-inline d-lg-none d-xxl-inline ms-2 text-secondary">612MB</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-12">
            <div class="card" style="height: 28rem">
              <div class="card-body card-body-scrollable card-body-scrollable-shadow">
                <div class="divide-y">
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar">JL</span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Jeffie Lewzey</strong> commented on your <strong>"I'm not a witch."</strong> post.
                        </div>
                        <div class="text-secondary">yesterday</div>
                      </div>
                      <div class="col-auto align-self-center">
                        <div class="badge bg-primary"></div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/002m.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          It's <strong>Mallory Hulme</strong>'s birthday. Wish him well!
                        </div>
                        <div class="text-secondary">2 days ago</div>
                      </div>
                      <div class="col-auto align-self-center">
                        <div class="badge bg-primary"></div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/003m.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Dunn Slane</strong> posted <strong>"Well, what do you want?"</strong>.
                        </div>
                        <div class="text-secondary">today</div>
                      </div>
                      <div class="col-auto align-self-center">
                        <div class="badge bg-primary"></div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/000f.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Emmy Levet</strong> created a new project <strong>Morning alarm clock</strong>.
                        </div>
                        <div class="text-secondary">4 days ago</div>
                      </div>
                      <div class="col-auto align-self-center">
                        <div class="badge bg-primary"></div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/001f.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Maryjo Lebarree</strong> liked your photo.
                        </div>
                        <div class="text-secondary">2 days ago</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar">EP</span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Egan Poetz</strong> registered new client as <strong>Trilia</strong>.
                        </div>
                        <div class="text-secondary">yesterday</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/002f.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Kellie Skingley</strong> closed a new deal on project <strong>Pen Pineapple Apple Pen</strong>.
                        </div>
                        <div class="text-secondary">2 days ago</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/003f.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Christabel Charlwood</strong> created a new project for <strong>Wikibox</strong>.
                        </div>
                        <div class="text-secondary">4 days ago</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar">HS</span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Haskel Shelper</strong> change status of <strong>Tabler Icons</strong> from <strong>open</strong> to <strong>closed</strong>.
                        </div>
                        <div class="text-secondary">today</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/006m.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Lorry Mion</strong> liked <strong>Tabler UI Kit</strong>.
                        </div>
                        <div class="text-secondary">yesterday</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/004f.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Leesa Beaty</strong> posted new video.
                        </div>
                        <div class="text-secondary">2 days ago</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/007m.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Perren Keemar</strong> and 3 others followed you.
                        </div>
                        <div class="text-secondary">2 days ago</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar">SA</span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Sunny Airey</strong> upload 3 new photos to category <strong>Inspirations</strong>.
                        </div>
                        <div class="text-secondary">2 days ago</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/009m.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Geoffry Flaunders</strong> made a <strong>$10</strong> donation.
                        </div>
                        <div class="text-secondary">2 days ago</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/010m.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Thatcher Keel</strong> created a profile.
                        </div>
                        <div class="text-secondary">3 days ago</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/005f.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Dyann Escala</strong> hosted the event <strong>Tabler UI Birthday</strong>.
                        </div>
                        <div class="text-secondary">4 days ago</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar" style="background-image: url(./static/avatars/006f.jpg)"></span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Avivah Mugleston</strong> mentioned you on <strong>Best of 2020</strong>.
                        </div>
                        <div class="text-secondary">2 days ago</div>
                      </div>
                    </div>
                  </div>
                  <div>
                    <div class="row">
                      <div class="col-auto">
                        <span class="avatar">AA</span>
                      </div>
                      <div class="col">
                        <div class="text-truncate">
                          <strong>Arlie Armstead</strong> sent a Review Request to <strong>Amanda Blake</strong>.
                        </div>
                        <div class="text-secondary">2 days ago</div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- <div class="col-lg-6">
        <div class="card">
          <div class="card-header border-0">
            <div class="card-title">Development activity</div>
          </div>
          <div class="position-relative">
            <div class="position-absolute top-0 left-0 px-3 mt-1 w-75">
              <div class="row g-2">
                <div class="col-auto">
                  <div class="chart-sparkline chart-sparkline-square" id="sparkline-activity"></div>
                </div>
                <div class="col">
                  <div>Today's Earning: $4,262.40</div>
                  <div class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-inline text-green" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 17l6 -6l4 4l8 -8" /><path d="M14 7l7 0l0 7" /></svg>
                    +5% more than yesterday</div>
                </div>
              </div>
            </div>
            <div id="chart-development-activity"></div>
          </div>
          <div class="card-table table-responsive">
            <table class="table table-vcenter">
              <thead>
                <tr>
                  <th>User</th>
                  <th>Commit</th>
                  <th>Date</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td class="w-1">
                    <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                  </td>
                  <td class="td-truncate">
                    <div class="text-truncate">
                      Fix dart Sass compatibility (#29755)
                    </div>
                  </td>
                  <td class="text-nowrap text-secondary">28 Nov 2019</td>
                </tr>
                <tr>
                  <td class="w-1">
                    <span class="avatar avatar-sm">JL</span>
                  </td>
                  <td class="td-truncate">
                    <div class="text-truncate">
                      Change deprecated html tags to text decoration classes (#29604)
                    </div>
                  </td>
                  <td class="text-nowrap text-secondary">27 Nov 2019</td>
                </tr>
                <tr>
                  <td class="w-1">
                    <span class="avatar avatar-sm" style="background-image: url(./static/avatars/002m.jpg)"></span>
                  </td>
                  <td class="td-truncate">
                    <div class="text-truncate">
                      justify-content:between ⇒ justify-content:space-between (#29734)
                    </div>
                  </td>
                  <td class="text-nowrap text-secondary">26 Nov 2019</td>
                </tr>
                <tr>
                  <td class="w-1">
                    <span class="avatar avatar-sm" style="background-image: url(./static/avatars/003m.jpg)"></span>
                  </td>
                  <td class="td-truncate">
                    <div class="text-truncate">
                      Update change-version.js (#29736)
                    </div>
                  </td>
                  <td class="text-nowrap text-secondary">26 Nov 2019</td>
                </tr>
                <tr>
                  <td class="w-1">
                    <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000f.jpg)"></span>
                  </td>
                  <td class="td-truncate">
                    <div class="text-truncate">
                      Regenerate package-lock.json (#29730)
                    </div>
                  </td>
                  <td class="text-nowrap text-secondary">25 Nov 2019</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div> -->
      <!-- <div class="col-12">
        <div class="card card-md">
          <div class="card-stamp card-stamp-lg">
            <div class="card-stamp-icon bg-primary">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 11a7 7 0 0 1 14 0v7a1.78 1.78 0 0 1 -3.1 1.4a1.65 1.65 0 0 0 -2.6 0a1.65 1.65 0 0 1 -2.6 0a1.65 1.65 0 0 0 -2.6 0a1.78 1.78 0 0 1 -3.1 -1.4v-7" /><path d="M10 10l.01 0" /><path d="M14 10l.01 0" /><path d="M10 14a3.5 3.5 0 0 0 4 0" /></svg>
            </div>
          </div>
          <div class="card-body">
            <div class="row align-items-center">
              <div class="col-10">
                <h3 class="h1">Tabler Icons</h3>
                <div class="markdown text-secondary">
                  All icons come from the Tabler Icons set and are MIT-licensed. Visit
                  <a href="https://tabler-icons.io" target="_blank" rel="noopener">tabler-icons.io</a>,
                  download any of the 4637 icons in SVG, PNG or&nbsp;React and use them in your favourite design tools.
                </div>
                <div class="mt-3">
                  <a href="https://tabler-icons.io" class="btn btn-primary" target="_blank" rel="noopener">Download icons</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div> -->
      <!-- <div class="col-md-12 col-lg-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Most Visited Pages</h3>
          </div>
          <div class="card-table table-responsive">
            <table class="table table-vcenter">
              <thead>
                <tr>
                  <th>Page name</th>
                  <th>Visitors</th>
                  <th>Unique</th>
                  <th colspan="2">Bounce rate</th>
                </tr>
              </thead>
              <tr>
                <td>
                  /
                  <a href="#" class="ms-1" aria-label="Open website">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                  </a>
                </td>
                <td class="text-secondary">4,896</td>
                <td class="text-secondary">3,654</td>
                <td class="text-secondary">82.54%</td>
                <td class="text-end w-1">
                  <div class="chart-sparkline chart-sparkline-sm" id="sparkline-bounce-rate-1"></div>
                </td>
              </tr>
              <tr>
                <td>
                  /form-elements.html
                  <a href="#" class="ms-1" aria-label="Open website">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                  </a>
                </td>
                <td class="text-secondary">3,652</td>
                <td class="text-secondary">3,215</td>
                <td class="text-secondary">76.29%</td>
                <td class="text-end w-1">
                  <div class="chart-sparkline chart-sparkline-sm" id="sparkline-bounce-rate-2"></div>
                </td>
              </tr>
              <tr>
                <td>
                  /index.html
                  <a href="#" class="ms-1" aria-label="Open website">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                  </a>
                </td>
                <td class="text-secondary">3,256</td>
                <td class="text-secondary">2,865</td>
                <td class="text-secondary">72.65%</td>
                <td class="text-end w-1">
                  <div class="chart-sparkline chart-sparkline-sm" id="sparkline-bounce-rate-3"></div>
                </td>
              </tr>
              <tr>
                <td>
                  /icons.html
                  <a href="#" class="ms-1" aria-label="Open website">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                  </a>
                </td>
                <td class="text-secondary">986</td>
                <td class="text-secondary">865</td>
                <td class="text-secondary">44.89%</td>
                <td class="text-end w-1">
                  <div class="chart-sparkline chart-sparkline-sm" id="sparkline-bounce-rate-4"></div>
                </td>
              </tr>
              <tr>
                <td>
                  /docs/
                  <a href="#" class="ms-1" aria-label="Open website">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                  </a>
                </td>
                <td class="text-secondary">912</td>
                <td class="text-secondary">822</td>
                <td class="text-secondary">41.12%</td>
                <td class="text-end w-1">
                  <div class="chart-sparkline chart-sparkline-sm" id="sparkline-bounce-rate-5"></div>
                </td>
              </tr>
              <tr>
                <td>
                  /accordion.html
                  <a href="#" class="ms-1" aria-label="Open website">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 15l6 -6" /><path d="M11 6l.463 -.536a5 5 0 0 1 7.071 7.072l-.534 .464" /><path d="M13 18l-.397 .534a5.068 5.068 0 0 1 -7.127 0a4.972 4.972 0 0 1 0 -7.071l.524 -.463" /></svg>
                  </a>
                </td>
                <td class="text-secondary">855</td>
                <td class="text-secondary">798</td>
                <td class="text-secondary">32.65%</td>
                <td class="text-end w-1">
                  <div class="chart-sparkline chart-sparkline-sm" id="sparkline-bounce-rate-6"></div>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div> -->
      <!-- <div class="col-md-6 col-lg-4">
        <a href="https://github.com/sponsors/codecalm" class="card card-sponsor" target="_blank" rel="noopener" style="background-image: url(./static/sponsor-banner-homepage.svg)" aria-label="Sponsor Tabler!">
          <div class="card-body"></div>
        </a>
      </div> -->
      <!-- <div class="col-md-6 col-lg-4">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Social Media Traffic</h3>
          </div>
          <table class="table card-table table-vcenter">
            <thead>
              <tr>
                <th>Network</th>
                <th colspan="2">Visitors</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Instagram</td>
                <td>3,550</td>
                <td class="w-50">
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-primary" style="width: 71.0%"></div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Twitter</td>
                <td>1,798</td>
                <td class="w-50">
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-primary" style="width: 35.96%"></div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Facebook</td>
                <td>1,245</td>
                <td class="w-50">
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-primary" style="width: 24.9%"></div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>TikTok</td>
                <td>986</td>
                <td class="w-50">
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-primary" style="width: 19.72%"></div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Pinterest</td>
                <td>854</td>
                <td class="w-50">
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-primary" style="width: 17.08%"></div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>VK</td>
                <td>650</td>
                <td class="w-50">
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-primary" style="width: 13.0%"></div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>Pinterest</td>
                <td>420</td>
                <td class="w-50">
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-primary" style="width: 8.4%"></div>
                  </div>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div> -->
      <!-- <div class="col-md-12 col-lg-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Tasks</h3>
          </div>
          <div class="table-responsive">
            <table class="table card-table table-vcenter">
              <tr>
                <td class="w-1 pe-0">
                  <input type="checkbox" class="form-check-input m-0 align-middle" aria-label="Select task" checked >
                </td>
                <td class="w-100">
                  <a href="#" class="text-reset">Extend the data model.</a>
                </td>
                <td class="text-nowrap text-secondary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                  August 04, 2021
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    2/7
                  </a>
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg>
                    3</a>
                </td>
                <td>
                  <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
                </td>
              </tr>
              <tr>
                <td class="w-1 pe-0">
                  <input type="checkbox" class="form-check-input m-0 align-middle" aria-label="Select task" >
                </td>
                <td class="w-100">
                  <a href="#" class="text-reset">Verify the event flow.</a>
                </td>
                <td class="text-nowrap text-secondary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                  January 03, 2019
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    3/10
                  </a>
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg>
                    6</a>
                </td>
                <td>
                  <span class="avatar avatar-sm">JL</span>
                </td>
              </tr>
              <tr>
                <td class="w-1 pe-0">
                  <input type="checkbox" class="form-check-input m-0 align-middle" aria-label="Select task" >
                </td>
                <td class="w-100">
                  <a href="#" class="text-reset">Database backup and maintenance</a>
                </td>
                <td class="text-nowrap text-secondary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                  December 28, 2018
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    0/6
                  </a>
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg>
                    1</a>
                </td>
                <td>
                  <span class="avatar avatar-sm" style="background-image: url(./static/avatars/002m.jpg)"></span>
                </td>
              </tr>
              <tr>
                <td class="w-1 pe-0">
                  <input type="checkbox" class="form-check-input m-0 align-middle" aria-label="Select task" checked >
                </td>
                <td class="w-100">
                  <a href="#" class="text-reset">Identify the implementation team.</a>
                </td>
                <td class="text-nowrap text-secondary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                  November 07, 2020
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    6/10
                  </a>
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg>
                    12</a>
                </td>
                <td>
                  <span class="avatar avatar-sm" style="background-image: url(./static/avatars/003m.jpg)"></span>
                </td>
              </tr>
              <tr>
                <td class="w-1 pe-0">
                  <input type="checkbox" class="form-check-input m-0 align-middle" aria-label="Select task" >
                </td>
                <td class="w-100">
                  <a href="#" class="text-reset">Define users and workflow</a>
                </td>
                <td class="text-nowrap text-secondary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                  November 23, 2021
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    3/7
                  </a>
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg>
                    5</a>
                </td>
                <td>
                  <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000f.jpg)"></span>
                </td>
              </tr>
              <tr>
                <td class="w-1 pe-0">
                  <input type="checkbox" class="form-check-input m-0 align-middle" aria-label="Select task" checked >
                </td>
                <td class="w-100">
                  <a href="#" class="text-reset">Check Pull Requests</a>
                </td>
                <td class="text-nowrap text-secondary">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12z" /><path d="M16 3v4" /><path d="M8 3v4" /><path d="M4 11h16" /><path d="M11 15h1" /><path d="M12 15v3" /></svg>
                  January 14, 2021
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                    2/9
                  </a>
                </td>
                <td class="text-nowrap">
                  <a href="#" class="text-secondary">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M8 9h8" /><path d="M8 13h6" /><path d="M18 4a3 3 0 0 1 3 3v8a3 3 0 0 1 -3 3h-5l-5 3v-3h-2a3 3 0 0 1 -3 -3v-8a3 3 0 0 1 3 -3h12z" /></svg>
                    3</a>
                </td>
                <td>
                  <span class="avatar avatar-sm" style="background-image: url(./static/avatars/001f.jpg)"></span>
                </td>
              </tr>
            </table>
          </div>
        </div>
      </div> -->
      <!-- <div class="col-12">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title">Invoices</h3>
          </div>
          <div class="card-body border-bottom py-3">
            <div class="d-flex">
              <div class="text-secondary">
                Show
                <div class="mx-2 d-inline-block">
                  <input type="text" class="form-control form-control-sm" value="8" size="3" aria-label="Invoices count">
                </div>
                entries
              </div>
              <div class="ms-auto text-secondary">
                Search:
                <div class="ms-2 d-inline-block">
                  <input type="text" class="form-control form-control-sm" aria-label="Search invoice">
                </div>
              </div>
            </div>
          </div>
          <div class="table-responsive">
            <table class="table card-table table-vcenter text-nowrap datatable">
              <thead>
                <tr>
                  <th class="w-1"><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices"></th>
                  <th class="w-1">No. 
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-sm icon-thick" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 15l6 -6l6 6" /></svg>
                  </th>
                  <th>Invoice Subject</th>
                  <th>Client</th>
                  <th>VAT No.</th>
                  <th>Created</th>
                  <th>Status</th>
                  <th>Price</th>
                  <th></th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                  <td><span class="text-secondary">001401</span></td>
                  <td><a href="invoice.html" class="text-reset" tabindex="-1">Design Works</a></td>
                  <td>
                    <span class="flag flag-xs flag-country-us me-2"></span>
                    Carlson Limited
                  </td>
                  <td>
                    87956621
                  </td>
                  <td>
                    15 Dec 2017
                  </td>
                  <td>
                    <span class="badge bg-success me-1"></span> Paid
                  </td>
                  <td>$887</td>
                  <td class="text-end">
                    <span class="dropdown">
                      <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                          Action
                        </a>
                        <a class="dropdown-item" href="#">
                          Another action
                        </a>
                      </div>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                  <td><span class="text-secondary">001402</span></td>
                  <td><a href="invoice.html" class="text-reset" tabindex="-1">UX Wireframes</a></td>
                  <td>
                    <span class="flag flag-xs flag-country-gb me-2"></span>
                    Adobe
                  </td>
                  <td>
                    87956421
                  </td>
                  <td>
                    12 Apr 2017
                  </td>
                  <td>
                    <span class="badge bg-warning me-1"></span> Pending
                  </td>
                  <td>$1200</td>
                  <td class="text-end">
                    <span class="dropdown">
                      <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                          Action
                        </a>
                        <a class="dropdown-item" href="#">
                          Another action
                        </a>
                      </div>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                  <td><span class="text-secondary">001403</span></td>
                  <td><a href="invoice.html" class="text-reset" tabindex="-1">New Dashboard</a></td>
                  <td>
                    <span class="flag flag-xs flag-country-de me-2"></span>
                    Bluewolf
                  </td>
                  <td>
                    87952621
                  </td>
                  <td>
                    23 Oct 2017
                  </td>
                  <td>
                    <span class="badge bg-warning me-1"></span> Pending
                  </td>
                  <td>$534</td>
                  <td class="text-end">
                    <span class="dropdown">
                      <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                          Action
                        </a>
                        <a class="dropdown-item" href="#">
                          Another action
                        </a>
                      </div>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                  <td><span class="text-secondary">001404</span></td>
                  <td><a href="invoice.html" class="text-reset" tabindex="-1">Landing Page</a></td>
                  <td>
                    <span class="flag flag-xs flag-country-br me-2"></span>
                    Salesforce
                  </td>
                  <td>
                    87953421
                  </td>
                  <td>
                    2 Sep 2017
                  </td>
                  <td>
                    <span class="badge bg-secondary me-1"></span> Due in 2 Weeks
                  </td>
                  <td>$1500</td>
                  <td class="text-end">
                    <span class="dropdown">
                      <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                          Action
                        </a>
                        <a class="dropdown-item" href="#">
                          Another action
                        </a>
                      </div>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                  <td><span class="text-secondary">001405</span></td>
                  <td><a href="invoice.html" class="text-reset" tabindex="-1">Marketing Templates</a></td>
                  <td>
                    <span class="flag flag-xs flag-country-pl me-2"></span>
                    Printic
                  </td>
                  <td>
                    87956621
                  </td>
                  <td>
                    29 Jan 2018
                  </td>
                  <td>
                    <span class="badge bg-danger me-1"></span> Paid Today
                  </td>
                  <td>$648</td>
                  <td class="text-end">
                    <span class="dropdown">
                      <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                          Action
                        </a>
                        <a class="dropdown-item" href="#">
                          Another action
                        </a>
                      </div>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                  <td><span class="text-secondary">001406</span></td>
                  <td><a href="invoice.html" class="text-reset" tabindex="-1">Sales Presentation</a></td>
                  <td>
                    <span class="flag flag-xs flag-country-br me-2"></span>
                    Tabdaq
                  </td>
                  <td>
                    87956621
                  </td>
                  <td>
                    4 Feb 2018
                  </td>
                  <td>
                    <span class="badge bg-secondary me-1"></span> Due in 3 Weeks
                  </td>
                  <td>$300</td>
                  <td class="text-end">
                    <span class="dropdown">
                      <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                          Action
                        </a>
                        <a class="dropdown-item" href="#">
                          Another action
                        </a>
                      </div>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                  <td><span class="text-secondary">001407</span></td>
                  <td><a href="invoice.html" class="text-reset" tabindex="-1">Logo & Print</a></td>
                  <td>
                    <span class="flag flag-xs flag-country-us me-2"></span>
                    Apple
                  </td>
                  <td>
                    87956621
                  </td>
                  <td>
                    22 Mar 2018
                  </td>
                  <td>
                    <span class="badge bg-success me-1"></span> Paid Today
                  </td>
                  <td>$2500</td>
                  <td class="text-end">
                    <span class="dropdown">
                      <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                          Action
                        </a>
                        <a class="dropdown-item" href="#">
                          Another action
                        </a>
                      </div>
                    </span>
                  </td>
                </tr>
                <tr>
                  <td><input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select invoice"></td>
                  <td><span class="text-secondary">001408</span></td>
                  <td><a href="invoice.html" class="text-reset" tabindex="-1">Icons</a></td>
                  <td>
                    <span class="flag flag-xs flag-country-pl me-2"></span>
                    Tookapic
                  </td>
                  <td>
                    87956621
                  </td>
                  <td>
                    13 May 2018
                  </td>
                  <td>
                    <span class="badge bg-success me-1"></span> Paid Today
                  </td>
                  <td>$940</td>
                  <td class="text-end">
                    <span class="dropdown">
                      <button class="btn dropdown-toggle align-text-top" data-bs-boundary="viewport" data-bs-toggle="dropdown">Actions</button>
                      <div class="dropdown-menu dropdown-menu-end">
                        <a class="dropdown-item" href="#">
                          Action
                        </a>
                        <a class="dropdown-item" href="#">
                          Another action
                        </a>
                      </div>
                    </span>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          <div class="card-footer d-flex align-items-center">
            <p class="m-0 text-secondary">Showing <span>1</span> to <span>8</span> of <span>16</span> entries</p>
            <ul class="pagination m-0 ms-auto">
              <li class="page-item disabled">
                <a class="page-link" href="#" tabindex="-1" aria-disabled="true">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M15 6l-6 6l6 6" /></svg>
                  prev
                </a>
              </li>
              <li class="page-item"><a class="page-link" href="#">1</a></li>
              <li class="page-item active"><a class="page-link" href="#">2</a></li>
              <li class="page-item"><a class="page-link" href="#">3</a></li>
              <li class="page-item"><a class="page-link" href="#">4</a></li>
              <li class="page-item"><a class="page-link" href="#">5</a></li>
              <li class="page-item">
                <a class="page-link" href="#">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 6l6 6l-6 6" /></svg>
                </a>
              </li>
            </ul>
          </div>
        </div>
      </div> -->
    </div>
  </div>
</div>
        