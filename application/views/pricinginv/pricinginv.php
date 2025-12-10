<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Pricing Process Material (Inventory)
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
              <?php $disab=''; if($this->session->userdata('deptsekarang')=='' || $this->session->userdata('deptsekarang')==null || $this->session->userdata('tujusekarang')=='' || $this->session->userdata('tujusekarang')==null){ $disab = 'disabled';} ?>
              <input type="hidden" id="errorparam" value="<?= $this->session->flashdata('errorparam'); ?>">
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
              <?php $distombollock = $this->session->userdata('tglpricinginv')!='' ? '' : 'hilang '; ?>
              <?php $diskuncitgl = $tglkunci==1 ? 'hilang' : ''; ?>
              <?php $diskuncitgl2 = $tglkunci==0 ? 'hilang' : ''; ?>
              <a href="#" data-href="<?= base_url().'pricinginv/unlockinv' ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-title="Unlock INV" data-message="Akan Membuka data Inventory" class="btn btn-sm btn-primary <?= $distombollock ?><?= $diskuncitgl2 ?>" title="<?= $userlockinv ?>" style="height: 40px; min-width: 40px;" id="butunlock"><i class="fa fa-lock fa-2x"></i></a>
              <a href="#" data-href="<?= base_url().'pricinginv/lockinv' ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-title="Lock INV" data-message="Akan mengunci data Inventory" class="btn btn-sm btn-success <?= $distombollock ?><?= $diskuncitgl ?>" title="<?= $userlockinv ?>" style="height: 40px; min-width: 40px;" id="butlock"><i class="fa fa-unlock fa-2x"></i></a>
              <a href="<?= base_url().'pricinginv/addcutoff' ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Tambah data Cut Off" data-tombol="Ya" class="btn btn-sm btn-primary mr-1" style="height: 40px;min-width:45px;" id="butcutoff"><i class="fa fa-plus mr-1"></i> Tambah Cut Off</a>
              <a href="#" class="btn btn-sm btn-warning mr-1" style="height: 40px;min-width:45px;" id="butref"><i class="fa fa-refresh"></i></a>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-1" id="thpricing" name="th" style="width: 75px;" value="<?= $this->session->userdata('thpricing') ?>">
              <select class="form-control form-sm font-kecil font-bold mr-1 form-select" id="blpricing" name="bl" style="width: 120px;">
                <?php for ($x = 1; $x <= 12; $x++) : ?>
                  <option value="<?= $x; ?>" <?php if ($this->session->userdata('blpricing') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                  <?php endfor; ?>
                </select>
                <label for="" class="my-2 mr-3 font-bold font-kecil">Periode : </label>
                <?php 
                $tglawal = '01-'.$this->session->userdata('blpricing').'-'.$this->session->userdata('thpricing');
                $periode = cekperiodedaritgl($tglawal) ?> 
                <input type="text" class="hilang" name="periode" id="periode" value="<?= $periode ?>">
                <input type="text" class="hilang" id="blperiode" name="blperiode" value="<?= $this->session->userdata('blpricing') ?>">
                <input type="text" class="hilang" id="thperiode" name="thperiode" value="<?= $this->session->userdata('thpricing') ?>">
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-5">
                  <div class="row">
                    <div class="col-12">
                      <div class="d-flex">
                        <span class="px-1">
                          <label class="form-label font-kecil">Tgl Cut Off</label>
                          <div>
                            <select class="form-select form-control form-sm font-kecil font-bold" id="tglcutoff" name="tglcutoff">
                              <option value="">-- Pilih Tgl Cut Off --</option>
                              <?php foreach($tglreq->result_array() as $dpu){ $selek = $this->session->userdata('tglpricinginv')==$dpu['tgl'] ? 'selected' : ''; ?>
                                <option value="<?= $dpu['tgl'] ?>" title="Dibuat oleh :<?= datauser($dpu['user_add'],'name') ?>, Pada <?= $dpu['tgl_add'] ?>" <?= $selek ?>><?= tglmysql($dpu['tgl']) ?></option>
                              <?php } ?> ?>
                            </select>
                            <input type="text" name="tglcut" id="tglcut" class="hilang" value="<?= $this->session->userdata('tglpricinginv') ?>">
                          </div>
                        </span>
                        <span class="px-1">
                          <label class="form-label font-kecil">Dept</label>
                          <div>
                            <select class="form-select form-control form-sm font-kecil font-bold" id="deptpricing" name="deptpricing">
                              <option value="">Semua</option>
                              <?php foreach($depe->result_array() as $depe){ $aktiv = cekdeptinv($depe['dept_id'],$this->session->userdata('tglpricinginv')) ? '' : 'disabled'; ?>
                              <?php $selek = $this->session->userdata('deptpricinginv')==$depe['dept_id'] ? 'selected' : ''; ?>
                                  <option value="<?= $depe['dept_id'] ?>" title="" <?= $aktiv.' '.$selek ?>><?= $depe['departemen'] ?></option>
                              <?php } ?>
                            </select>
                            <input type="text" name="deptcut" id="deptcut" class="hilang" value="<?= $this->session->userdata('deptpricinginv') ?>">
                          </div>
                        </span>
                        <span class="px-1">
                          <label class="form-label font-kecil"><span style="color: #F5F8FC">.</span></label>
                          <div class="font-kecil">
                            <a href="#" class="btn btn-sm btn-primary" style="height: 38px;min-width:45px;" id="butgo">Go</a>
                          </div>
                        </span>
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="d-flex">
                        <span class="px-1 mt-1">
                          <label class="form-label font-kecil mb-0">Kepemilikan</label>
                          <div>
                            <select class="form-select form-control form-sm font-kecil font-bold mt-1" id="filterdln" name="filterdln">
                              <option value="">Semua</option>
                              <option value="1" <?php if($this->session->userdata('milik')==1 && $this->session->userdata('milik')!=''){ echo "selected"; } ?>>DLN</option>
                              <option value="0" <?php if($this->session->userdata('milik')==0 && $this->session->userdata('milik')!=''){ echo "selected"; } ?>>IFN</option>
                            </select>
                          </div>
                        </span>
                      </div>
                    </div>
                  </div>
                  <div class="p-1 font-kecil">
                    <?php if($this->session->userdata('deptpricinginv')!=''){ ?>
                      <span class="text-cyan font-bold">Diupload Oleh : </span><span><?= $usersaveinv ?></span><br>
                    <?php } ?>
                    <?php if($diskuncitgl=='hilang'){ ?>
                    <span class="text-danger"><?= $userlockinv ?></span>
                    <?php } ?>
                  </div>
                </div>
                <div class="col-4">
                  <!-- <label class="bg-red-lt my-0 py-1 px-2 font-bold w-100"><span class="text-black">Rekap Data</span></label> -->
                  <table class="table table-bordered m-0">
                    <thead class="bg-primary-lt">
                      <tr>
                        <th class="text-center text-black">Unit</th>
                        <th class="text-center text-black">Inventory</th>
                        <th class="text-center text-black">BOM Inventory</th>
                        <th class="text-center text-black">Selisih Jumlah</th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      <tr class="p-0">
                        <td class="font-bold">Rekord</td>
                        <td class="text-right" id="jumlahrek">Loading..</td>
                        <td class="text-right" id="jumlahrekdet">Loading..</td>
                        <td class="text-right">-</td>
                      </tr>
                      <tr>
                        <td class="font-bold">PCS</td>
                        <td class="text-right" id="jumlahpcs">Loading..</td>
                        <td class="text-right" id="jumlahpcsdet">Loading..</td>
                        <td class="text-right">-</td>
                      </tr>
                      <tr>
                        <td class="font-bold">KGS</td>
                        <td class="text-right" id="jumlahkgs">Loading..</td>
                        <td class="text-right" id="jumlahkgsdet">Loading..</td>
                        <td class="text-right font-bold" id="selisihkgs"></td>
                      </tr>
                      <tr>
                        <td class="font-bold" colspan="2">Pricing (Rp)</td>
                        <td class="text-right font-bold" colspan="2" id="totalhargadet">Loading..</td>
                      </tr>
                    </tbody>
                  </table>
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
        <div class="mt-2">
          <div class="card btn-flat">
            <div class="card-header font-kecil">
              <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs" style="background-color: #F6F8F8"> <!-- #F6F8FB -->
                <li class="nav-item">
                  <a href="#tabs-home-1" class="nav-link active bg-cyan btn-flat font-13 font-bold text-black" data-bs-toggle="tab">Inventory</a>
                </li>
                <li class="nav-item">
                  <a href="#tabs-profile-1" class="nav-link bg-orange btn-flat font-13 font-bold text-black" data-bs-toggle="tab">BOM Inventory</a>
                </li>
                <li class="nav-item hilang">
                  <a href="#tabs-settings-1" class="nav-link" title="Settings" data-bs-toggle="tab">BOM Inventory Job</a>
                </li>
              </ul>
            </div>
            <div class="card-body mt-0 p-1">
              <div class="tab-content p-1 m-1">
                <div class="tab-pane p-0 active show m-1" id="tabs-home-1">
                  <div class="row d-flex align-item-between mb-1">
                    <div class="col-6 mx-auto">
                      <h4 class="mb-1">Inventory</h4>
                    </div>
                    <div class="col-6 text-right d-flex justify-content-end">
                      <div class="font-bold font-kecil m-0 d-inline">
                         <select class="form-select form-control form-sm font-kecil font-bold ml-auto btn-flat" id="filterctgr" name="filterctgr" style="max-width: 200px;" title="Filter Kategori">
                          <option value="">Semua</option>
                          <?php foreach($datkategori->result_array() as $datkategori){ ?>
                            <option value="<?= $datkategori['id_kategori'] ?>"><?= $datkategori['nama_kategori'] ?></option>
                          <?php } ?>
                        </select>
                      </div>
                    </div>
                  </div>
                  <hr class="m-0">
                  <div class="mt-2">
                    <table id="tabelnya" class="table order-column mt-1 table-hover table-bordered cell-border" style="width: 100% !important; border-collapse: collapse;">
                      <thead>
                        <tr>
                          <th>Dept</th>
                          <th>SKU/Spesifikasi</th>
                          <th>Nomor IB<br>Insno</th>
                          <th>Nobale</th>
                          <th>Satuan</th>
                          <th>BC</th>
                          <th>Stok GD</th>
                          <th>Exnet</th>
                          <th>Qty</th>
                          <th>Kgs</th>
                          <th>Verified</th>
                        </tr>
                      </thead>
                      <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                     
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="tabs-profile-1">
                  <div class="row d-flex align-item-between mb-1">
                    <div class="col-6 mx-auto">
                      <h4>BOM Inventory</h4>
                    </div>
                    <div class="col-6 text-right">
                      <a href="<?= base_url().'pricinginv/breakdownbom' ?>" data-bs-toggle="modal" data-bs-target="#veriftask" data-message="Break down Data ke Bill Of Material" data-title="Breakdown BOM" class="btn btn-sm btn-primary <?= $diskuncitgl ?>" id="buthitungbom"><i class="fa fa-calculator mr-1"></i> Hitung BOM</a>
                    </div>
                  </div>
                  <hr class="m-0">
                  <div class="mt-2">
                    <table id="tabeldetailnya" class="table order-column mt-1 table-hover table-bordered cell-border" style="width: 100% !important; border-collapse: collapse;">
                      <thead>
                        <tr>
                          <th>Dept</th>
                          <th>SKU/Spesifikasi</th>
                          <th>Nobontr</th>
                          <th>Kgs</th>
                          <th>BC No / Tgl</th>
                          <th>Harga (Kgs)</th>
                          <th>Total</th>
                          <th>Verified</th>
                        </tr>
                      </thead>
                      <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                     
                      </tbody>
                    </table>
                  </div>
                </div>
                <div class="tab-pane" id="tabs-settings-1">
                  <h4>Settings tab</h4>
                  <div>Donec ac vitae diam amet vel leo egestas consequat rhoncus in luctus amet, facilisi sit mauris accumsan nibh habitant senectus</div>
                </div>
              </div>
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</div>