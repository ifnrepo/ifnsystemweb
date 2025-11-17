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
              <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white" id="pcskgsbcwip" name="pcskgsbcwip" title="Jumlah yang ditambpilkan" style="width: 15% !important">
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
                        <option value="">Semua</option>
                        <?php foreach($kategori->result_array() as $kateg): ?>
                        <?php $selek = $kateg['id_kategori']==$this->session->userdata('katebarbcwip') ? 'selected' : ''; ?>
                          <option value="<?= $kateg['kategori_id'] ?>" <?= $selek ?>><?= $kateg['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-3 ">
                </div>
                <input type="text" id="paramload" class="hilang" value="<?= $this->session->userdata('currdept'); ?>">
                <div class="col-3 font-kecil">
                  <div class="text-blue font-bold mt-2 ">Jumlah Rec : <span id="jumlahrekod" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold">Jumlah Pcs : <span id="jumlahpcs" style="font-weight: normal;"><?= $this->session->userdata('jumlahpc'); ?></span></div>
                  <div class="text-blue font-bold">Jumlah Kgs : <span id="jumlahkgs" style="font-weight: normal;">Loading ..</span></div>
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
              $jmlpcs=0;$jmlkgs=0;
              $no=0; 
              if($data != null): foreach($data->result_array() as $data): $no++; 
              $pcs = $data['saldopcs'] + $data['inpcs'] - $data['outpcs'] + $data['adjpcs'];
              $kgs = $data['saldokgs'] + $data['inkgs'] - $data['outkgs'] + $data['adjkgs']; 
              $sku = trim($data['po'])=='' ? namaspekbarang($data['id_barang'],'kode')  : viewsku($data['po'],$data['item'],$data['dis']);
              $spekbarang = trim($data['po'])=='' ? namaspekbarang($data['id_barang'])  : spekpo($data['po'],$data['item'],$data['dis']);
              $sat = trim($data['po'])=='' ? $data['kodesatuan']  : 'KGS';
              $kondisi = 'OME-'.$data['id_barang'].'-'.encrypto(trim($data['po'])).'-'.encrypto(trim($data['item'])).'-'.$data['dis'].'-'.$data['dept_id'];
              $jmlpcs += $pcs;
              $jmlkgs += $kgs;
              $adjpcsplus = 0;$adjpcsmin =0;
              $adjkgsplus = 0;$adjkgsmin =0;
              // if($data['kodeinv']=='3'){
                if($data['adjpcs'] > 0){
                  $adjpcsplus = $data['adjpcs'];
                }else{
                  $adjpcsmin = $data['adjpcs']*-1;
                }
                if($data['adjkgs'] > 0){
                  $adjkgsplus = $data['adjkgs'];
                }else{
                  $adjkgsmin = $data['adjkgs']*-1;
                }
              // }
              if($this->session->userdata('pcskgsbcwip')=='kgs'){
                $saldo = $data['saldokgs'];
                $in = $data['inkgs']+$adjkgsplus;
                $out = $data['outkgs']+$adjkgsmin;
                $akhir = $kgs;
              }else{
                $saldo = $data['saldopcs'];
                $in = $data['inpcs']+$adjpcsplus;
                $out = $data['outpcs']+$adjpcsmin;
                $akhir = $pcs;
              }
            ?>
              <tr>
                <td><?= $no ?></td>
                <td class="line-12"><span class="text-pink font-11"><?= $sku.' ('.$data['dept_id'].')' ?></span><br><a href="<?= base_url().'bcwip/getdatabyid/'.$kondisi ?>" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' title='View Detail'><?= $spekbarang ?></a></td>
                <td><?= $sat ?></td>
                <td class="text-right"><?= rupiah($saldo,2) ?></td>
                <td class="text-right"><?= rupiah($in,2) ?></td>
                <td class="text-right"><?= rupiah($out,2) ?></td>
                <td  class="text-right"><?= rupiah(0,2) ?></td>
                <td  class="text-right"><?= rupiah($akhir,2) ?></td>
                <td  class="text-right"><?= rupiah(0,2) ?></td>
                <td></td>
              </tr>
            <?php endforeach; endif; ?>
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