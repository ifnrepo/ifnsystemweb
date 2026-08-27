<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Master Data Warna
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'satuan/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Satuan"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-6">
            <h1>Base Color</h1>
            <div class="row font-kecil d-flex justify-content-between">
              <!-- <label class="col-6 col-form-label text-center">Record Per Page</label> -->
              <div class="col-sm-2">
                <select class="form-select font-kecil btn-flat" id="perpagewarna">
                  <option value="15" <?php if($this->session->userdata('perpage-warna')==15){ echo "selected"; } ?>>15</option>
                  <option value="25" <?php if($this->session->userdata('perpage-warna')==25){ echo "selected"; } ?>>25</option>
                  <option value="50" <?php if($this->session->userdata('perpage-warna')==50){ echo "selected"; } ?>>50</option>
                  <option value="75" <?php if($this->session->userdata('perpage-warna')==75){ echo "selected"; } ?>>75</option>
                  <option value="100" <?php if($this->session->userdata('perpage-warna')==100){ echo "selected"; } ?>>100</option>
                </select>
              </div>
              <div class="col-sm-4"></div>
              <div class="col-sm-6 text-right">
                <div class="input-group mb-2">
                  <input type="text" class="form-control font-kecil btn-flat" id="pencarianwarna" placeholder="Cari Warna…" value="<?= $this->session->userdata('pencarian-warna') ?>">
                  <button class="btn font-kecil btn-success btn-flat" id="btncari" type="button">Cari</button>
                </div>
              </div>
            </div>
            <table id="tabelnya" class="table table-hover table-bordered cell-border mt-1" style="width: 100% !important; border-collapse: collapse;"> 
              <thead>
                <tr>
                  <th class="bg-primary-lt">No</th>
                  <th class="bg-primary-lt">Base Color</th>
                  <th class="bg-primary-lt">Genc</th>
                  <th class="bg-primary-lt" style="width: 5% !important;">Exmpl</th>
                  <th class="bg-primary-lt" style="">Aksi</th>
                </tr>
              </thead>
              <tbody class="table-tbody" id="body-table" style="width: 100% !important;">
                <?php $adarek=0; if($jumlahrek!=0){ $adarek=1; $idrek=0; ?>
                <?php $no = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0; foreach($data->result_array() as $dt): $idrek = $idrek==0 ? $dt['id'] : $idrek; $no++; $gencha = $dt['spincol']==1 ? 'Y':''; ?>
                  <tr class="font-kecil" id="trwarna" rel="<?= $dt['id'] ?>">
                    <td><?= $no ?></td>
                    <td><?= $dt['basecolor'] ?></td>
                    <td class="text-center text-green font-bold"><?= $gencha ?></td>
                    <td style="background-color: <?= $dt['rgb_warna'] ?>" class="font-kecil"><?= $dt['rgb_warna'] ?></td>
                    <td class="text-center"></td>
                  </tr>
                <?php endforeach; ?>
                <?php }else{ ?>
                  <tr class="font-kecil">
                    <td colspan="5" class="text-center">-- Data Warna tidak Ada --</td>
                  </tr>
                <?php } ?>
              </tbody>
            </table>
            <div class="d-flex justify-content-between mt-1">
                  <div class="mt-1 font-kecil">
                      Jumlah Record <?= rupiah($jumlahrek,0) ?>
                  </div>
                  <div class="font-kecil">
                      <?= $links; ?>
                  </div>
                  <div id="cekrek" class="hilang"><?= $idrek ?></div>
              </div>
            <!-- </div> -->
          </div>
          <div class="col-6">
            <div class="card">
              <div class="card-body">
                <div id="datawarna"><h1>Color</h1></div>
                <h4 class="bg-green-lt p-1 mt-1 mb-1"><span class="text-black">Data Color</span></h4>
                <div class="text-right">
                  <a href="#" class="btn-success px-2 font-kecil"><i class="fa fa-plus"></i> Tambah</a>
                </div>
                <table id="tabelnya" class="table table-hover table-bordered cell-border mt-1" style="width: 100% !important; border-collapse: collapse;"> 
                  <thead>
                    <tr>
                      <th class="bg-yellow-lt"><span class="text-black">Plus/Minus (%)</span></th>
                      <th class="bg-yellow-lt"><span class="text-black">Color</span></th>
                      <th class="bg-yellow-lt"><span class="text-black">Exmpl</span></th>
                      <th class="bg-yellow-lt" style=""><span class="text-black">Active</span></th>
                    </tr>
                  </thead>
                  <tbody class="table-tbody" id="body-table-warna" style="width: 100% !important;">
                  </tbody>
                </table>
                <hr class="mb-0">
                <h4 class="bg-danger-lt p-1 mt-1 mb-1"><span class="text-black">Data Komposisi Dyestuff</span></h4>
                <table id="tabelnya" class="table table-hover table-bordered cell-border mt-0" style="width: 100% !important; border-collapse: collapse;"> 
                  <thead>
                    <tr>
                      <th class="bg-yellow-lt"><span class="text-black">No</span></th>
                      <th class="bg-yellow-lt"><span class="text-black">Dye Stuff</span></th>
                      <th class="bg-yellow-lt text-center"><span class="text-black">%</span></th>
                    </tr>
                  </thead>
                  <tbody class="table-tbody" id="body-table-dyestuff" style="width: 100% !important;">
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>