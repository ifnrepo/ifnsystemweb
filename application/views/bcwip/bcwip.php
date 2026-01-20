<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          IT Inventory WIP - WORK IN PROCESS
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
              <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white hilang" id="pcskgsbcwip" name="pcskgsbcwip" title="Jumlah yang ditambpilkan" style="width: 15% !important">
                <option value="kgs" <?php if($this->session->userdata('pcskgsbcwip')=='kgs'){ echo "selected"; } ?>>KGS</option>
                <option value="pcs" <?php if($this->session->userdata('pcskgsbcwip')=='pcs'){ echo "selected"; } ?>>PCS</option>
              </select>
              <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white" title="Departemen" id="currdept" name="currdept">
                <option value="X">Semua</option>
                <?php
                // Mendapatkan nilai 'deptsekarang', jika null nilai default jadi it
                $selek = $this->session->userdata('currdeptbcwip') ?? 'IT';
                foreach ($hakdep as $hak) :
                  $selected = ($selek == $hak['dept_id']) ? "selected" : "";
                ?>
                  <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?= $selected ?>>
                    <?= $hak['dept_id'].' - '.$hak['departemen']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-1 tglpilih" id="tglawal" name="tglawal" style="width: 95px;" value="<?= $tglawal ?>">
              <span class="mt-2 text-blue"> ~ </span>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2 tglpilih" id="tglakhir" name="tglakhir" style="width: 95px;" value="<?= $tglakhir ?>">
              <a href="#" class="btn btn-success btn-sm font-bold" id="updatebcwip"><i class="fa fa-refresh"></i><span class="ml-1">UPDATE</span></a>
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
              <!-- <a href="#" class="btn btn-danger btn-sm font-bold" id="topdf"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export PDF</span></a> -->
              <a href="<?= base_url().'bcwip/toexcel'; ?>" class="btn btn-success btn-sm font-bold mr-1" id="toexcel"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export Excel</span></a>
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3">
                  <div class="row" id="div-exdo">
                    <label class="col-3 col-form-label font-kecil font-bold">IFN/DLN</label>
                    <div class="col mb-1">
                      <select name="kepemilikan" id="kepemilikan" style="height: 32px;" class="form-control form-select form-sm font-kecil py-1">
                        <option value="">All</option>
                        <option value="0" <?php if($this->session->userdata('kepemilikanbcwip')=='0'){ echo "selected"; } ?>>IFN</option>
                        <option value="1" <?php if($this->session->userdata('kepemilikanbcwip')=='1'){ echo "selected"; } ?>>DLN</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">KATEGORI</label>
                    <div class="col">
                      <select name="katbarang" id="katbarang" class="form-control form-select form-sm font-kecil">
                        <option value="all">Semua</option>
                        <?php foreach($kategori->result_array() as $kateg): ?>
                        <?php $selek = $kateg['id_kategori']==$this->session->userdata('katebarbcwip') ? 'selected' : ''; ?>
                          <option value="<?= $kateg['kategori_id'] ?>" <?= $selek ?>><?= $kateg['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                  <label class="form-check mt-1 mb-1 bg-danger-lt" id="cekaneh">
                    <input class="form-check-input" type="checkbox" id="dataneh">
                    <span class="form-check-label font-bold">View Data Tidak Sesuai</span>
                  </label>
                </div>
                <div class="col-6 font-kecil">
                  <input type="text" id="paramload" class="hilang" value="<?= $this->session->userdata('currdept'); ?>">
                  <div class="text-blue font-bold mt-2 ">Jumlah Rec : <span id="jumlahrekod" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold">Jumlah Pcs : <span id="jumlahpcs" style="font-weight: normal;"><?= $this->session->userdata('jumlahpc'); ?></span></div>
                  <div class="text-blue font-bold">Jumlah Kgs : <span id="jumlahkgs" style="font-weight: normal;">Loading ..</span></div>
                  <div id="rekapopname" class="hilang">
                  <hr class="m-1">
                  <h5 class="m-0">Rekap Opname</h5>
                  <div class="text-secondary font-bold">Jumlah Pcs : <span id="jumlahpcsopname" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-secondary font-bold">Jumlah Kgs : <span id="jumlahkgsopname" style="font-weight: normal;">Loading ..</span></div>
                  </div>
                </div>
                <div class="col-3">
                  <div class="mb-0">
                    <label class="font-bold">
                      Cari Barang / SKU :
                    </label>
                  </div>
                  <div class="">
                    <div class="" >
                    <textarea class="form form-control p-2 m-0 font-kecil" id='textcari' style="text-transform: uppercase;"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                      <button type="button" id="buttoncari" class="btn btn-sm btn-success btn-flat w-100 mt-1">Cari</button>
                      <button type="button" id="buttonreset" class="btn btn-sm btn-danger btn-flat w-25 mt-1">Reset</button>
                    </div>
                  </div>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div>
          <?php $cektglopname = $getopname['tgl']=='' ? '' : tglmysql($getopname['tgl']); ?>
          <input type="text" name="tglopname" id="tglopname" value="<?= $cektglopname ?>" class="hilang">
          <table id="tabelnya" class="table order-column table-hover table-bordered mt-2" style="width: 100% !important; border-collapse: collapse;">
            <thead>
              <tr class="text-left">
                <th class="text-center">No</th>
                <th class="text-center">Dept</th>
                <th class="text-left">Sku / Spesifikasi</th>
                <th class="text-left">Satuan</th>
                <th class="text-left">S. Awal</th>
                <th class="text-left">Pemasukan</th>
                <th class="text-left">Pengeluaran</th>
                <th class="text-left">Adjustment</th>
                <th class="text-left">S. Akhir</th>
                <th class="text-left line-11" id="headopname">Opname<br>xx-xx-xxxx</th>
                <th class="text-left">Ket</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
            
            </tbody>
          </table>
        </div>
        <div id="jumlahrek" class="hilang"><?= $no ?></div>
        <div id="jumlahpc" class="hilang"><?= $jmlpcs ?></div>
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
                  <?= rupiah($jmpcs, 2); ?>
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