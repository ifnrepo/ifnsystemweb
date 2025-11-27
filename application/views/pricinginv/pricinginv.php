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
              <a href="#" class="btn btn-sm btn-warning" style="height: 40px;min-width:45px;" id="butref"><i class="fa fa-refresh"></i></a>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="thpricing" name="th" style="width: 75px;" value="<?= $this->session->userdata('thpricing') ?>">
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
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2">
                  <h4 class="mb-1 font-kecil">Dept</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="deptpricing" name="deptpricing">
                        <option value="all">Semua</option>
                        <?php
                        // Mendapatkan nilai 'deptsekarang', jikla null nilai default jadi it
                        $selek = $this->session->userdata('cutoffinv') ?? 'IT';
                        foreach($depe->result_array() as $dpt){ ?>
                          <option value="<?= $dpt['dept_id'] ?>"><?= $dpt['departemen'] ?></option>
                        <?php } ?>
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-2">
                  <h4 class="mb-1 font-kecil">Tgl Cut Off</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="tglcutoff" name="tglcutoff">
                        <option value="all">-- Pilih Tgl Cut Off --</option>
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1 font-kecil"><span style="color: #F5F8FC">.</span></h4>
                  <span class="font-kecil">
                    <a href="#" class="btn btn-sm btn-primary" style="height: 38px;min-width:45px;" id="butgo">Go</a>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1"></h4>
                </div>
                <div class="col-2">
                  <h4 class="mb-1">
                    <?php if($disab!=''){ ?>
                    <!-- <small class="text-pink text-center">Tekan <b>GO</b> untuk mengaktifkan Tombol Tambah Data dan Load Data</small> -->
                    <?php } ?>
                  </h4>
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
                  <a href="#tabs-home-1" class="nav-link active bg-cyan-lt btn-flat font-13 font-bold" data-bs-toggle="tab">Inventory</a>
                </li>
                <li class="nav-item">
                  <a href="#tabs-profile-1" class="nav-link bg-teal-lt btn-flat font-13 font-bold" data-bs-toggle="tab">BOM Inventory</a>
                </li>
                <li class="nav-item ms-auto">
                  <a href="#tabs-settings-1" class="nav-link" title="Settings" data-bs-toggle="tab"><!-- Download SVG icon from http://tabler-icons.io/i/settings -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>
                  </a>
                </li>
              </ul>
            </div>
            <div class="card-body mt-0 p-1">
              <div class="tab-content p-1 m-1">
                <div class="tab-pane p-0 active show m-1" id="tabs-home-1">
                  <h4 class="mb-1">Inventory</h4>
                  <hr class="m-0">
                  <div class="mt-2">
                    <table id="tabelnya" class="table nowrap order-column mt-1" style="width: 100% !important;">
                      <thead>
                        <tr>
                          <!-- <th>Tgl</th> -->
                          <th>SKU/Spesifikasi</th>
                          <th>Nomor IB<br>Insno</th>
                          <th>Satuan</th>
                          <th>BC</th>
                          <th>Nobale</th>
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
                  <h4>Profile tab</h4>
                  <div>Fringilla egestas nunc quis tellus diam rhoncus ultricies tristique enim at diam, sem nunc amet, pellentesque id egestas velit sed</div>
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