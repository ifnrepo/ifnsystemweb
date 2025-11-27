<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          IT Inventory - BARANG MODAL (MESIN / SPAREPART)
          <input type="hidden" id="bukavalid" value="<?= datauser($this->session->userdata('id'),'cekbatalstok'); ?>">
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url(); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div class="sticky-top bg-white mb-2">
          <div class="row mb-1 d-flex align-items-between">
            <div class="col-sm-6 d-flex">
              <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white" title="Departemen" id="getmodemesin" name="getmodemesin">
                <option value="0">MESIN</option>
                <option value="1">SPAREPART</option>
              </select>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-1 tglpilih" id="tglawal" name="tglawal" style="width: 95px;" value="<?= $tglawal ?>">
              <span class="mt-2 text-blue"> ~ </span>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2 tglpilih" id="tglakhir" name="tglakhir" style="width: 95px;" value="<?= $tglakhir ?>">
              <a href="#" class="btn btn-success btn-sm font-bold" id="updatemesin"><i class="fa fa-refresh"></i><span class="ml-1">UPDATE</span></a>
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
              <!-- <a href="#" class="btn btn-danger btn-sm font-bold" id="topdf"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export PDF</span></a> -->
              <a href="<?= base_url().'invmesin/toexcel'; ?>" class="btn btn-success btn-sm font-bold mr-1" id="toexcel"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export Excel</span></a>
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3">
                  <div class="row" id="div-exdo">
                    <label class="col-3 col-form-label font-kecil font-bold">Lokasi</label>
                    <div class="col mb-1">
                      <select name="lokasimesin" id="lokasimesin" style="height: 32px;" class="form-control form-select form-sm font-kecil py-1">
                        <option value="all">All</option>
                        <?php foreach($lokasi->result_array() as $lokasi): ?>
                        <option value="<?= $lokasi['lokasi'] ?>" <?php if($this->session->userdata('lokasimesin')==$lokasi['lokasi']){ echo "selected"; } ?>><?= $lokasi['lokasi'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-3 ">
                </div>
                <input type="text" id="paramload" class="hilang" value="<?= $this->session->userdata('currdept'); ?>">
                <div class="col-3 font-kecil">
                  <div class="text-blue font-bold mt-2 hilang">Jumlah Rec : <span id="jumlahrekod" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold">Jumlah Unit : <span id="jumlahpcs" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold hilang">Jumlah Kgs : <span id="jumlahkgs" style="font-weight: normal;">Loading ..</span></div>
                </div>
                <div class="col-3">

                </div>
                <div class="col-2">
                  <h4 class="mb-1"></h4>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div>
          <table id="tabelnya" class="table order-column table-hover mt-1 datatable11" style="width: 100% !important;">
            <thead>
              <tr>
                <th>No</th>
                <th>SKU/Spesifikasi</th>
                <th>Satuan</th>
                <th>S. Awal</th>
                <th>Pemasukan</th>
                <th>Pengeluaran</th>
                <th>Adjustment</th>
                <th>S. Akhir</th>
                <th>Opname</th>
                <th>Ket</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
            <?php 
              $no=0; $saldoakhir=0; foreach($data->result_array() as $data): $no++; 
              $sku = $data['kode_fix'];
              $spekbarang = namaspekbarang($data['id_barang']);
              $sat = 'UNIT';
              $saldo = $data['xsaldomesin']+$data['xinmesin']-$data['xoutmesin'];
              $saldoakhir += $saldo;
            ?>
            <tr>
              <td><?= $no ?></td>
              <td class="line-11"><span class="text-pink font-11"><?= $sku ?><a href="#"></span><br><?= $spekbarang  ?></a></td>
              <td><?= $sat ?></td>
              <td class="text-right"><?= rupiah($data['xsaldomesin'],1) ?></td>
              <td class="text-right"><?= rupiah($data['xinmesin'],1) ?></td>
              <td class="text-right"><?= rupiah($data['xoutmesin'],1) ?></td>
              <td class="text-right"><?= rupiah(0,0); ?></td>
              <td class="text-right"><?= rupiah($saldo,1); ?></td>
              <td class="text-right"><?= rupiah(0,0); ?></td>
              <td class="text-right"><?= rupiah(0,0); ?></td>
            </tr>
            <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <div id="jumlahrek" class="hilang"><?= $no ?></div>
        <div id="jumlahpc" class="hilang"><?= $saldoakhir ?></div>
        <div id="jumlahkg" class="hilang"><?= $jmlkgs ?></div>
        <div class="card card-active hilang" style="clear:both;">
          <div class="card-body p-2 font-kecil">
            <div class="row">
              <div class="col-3">
                <h4 class="mb-0 font-kecil font-bold">Jumlah Rec</h4>
                <span class="font-kecil">
                  <?= rupiah($cntbrg, 0); ?>
                </span>
              </div>
              <div class="col-3 ">
                <h4 class="mb-0 font-kecil font-bold">Pcs</h4>
                <span class="font-kecil">
                  <?= rupiah($saldoakhir, 2); ?>
                </span>
              </div>
              <div class="col-3">
                <h4 class="mb-0 font-kecil font-bold">Kgs</h4>
                <span class="font-kecil">
                  <?= rupiah($jmkgs, 2); ?>
                </span>
              </div>
              <div class="col-3" style="line-height: 5px !important;">
                <?php if($this->session->userdata('invharga')): ?>
                <h4 class="mb-0 font-kecil font-bold">Grand Total</h4>
                <span class="font-kecil text-green font-bold">
                  Rp. <?= rupiah($grandtotal, 2); ?>
                </span>
                <?php endif; ?>
              </div>
              <div class="col-2">
                <h4 class="mb-1"></h4>
              </div>
            </div>
            <!-- <div class="hr m-1"></div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>