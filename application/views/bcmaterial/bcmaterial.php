<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          IT Inventory - BAHAN BAKU
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
        <div class="sticky-top bg-white">
          <div class="row mb-1 d-flex align-items-between">
            <div class="col-sm-5 d-flex">
              <span class="mt-2 font-bold mr-5">Periode</span>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-1 tglpilih" title="Tanggal Awal" id="tglawal" name="tglawal" style="width: 95px;" value="<?= $tglawal; ?>">
              <span class="mt-2 text-blue"> ~ </span>
              <input type="text" class="form-control form-sm font-kecil font-bold ml-1 mr-2 tglpilih" title="Tanggal Akhir" id="tglakhir" name="tglakhir" style="width: 95px;" value="<?= $tglakhir; ?>">
              <a href="#" class="btn btn-success btn-sm font-bold" id="updatebcmaterial"><i class="fa fa-refresh"></i><span class="ml-1">UPDATE</span></a>
            </div>
            <div class="col-sm-7 d-flex flex-row-reverse" style="text-align: right;">
              <a href="<?= base_url('bcmaterial/cetakpdf'); ?>" target="_blank" class="btn btn-danger btn-sm font-bold" id="topdf"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export PDF</span></a>
              <a href="<?= base_url() . 'bcmaterial/toexcel'; ?>" class="btn btn-success btn-sm font-bold mr-1" id="toexcel"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export Excel</span></a>
            </div>
          </div>
          <div class="card card-active mb-1" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3 ">
                  <div class="row" id="div-exdo">
                    <label class="col-3 col-form-label font-kecil font-bold">IFN/DLN</label>
                    <div class="col mb-1">
                      <select name="kepemilikan" id="kepemilikan" style="height: 32px;" class="form-control form-select form-sm font-kecil py-1">
                        <option value="">All</option>
                        <option value="0" <?php if($this->session->userdata('kepemilikan')=='0'){ echo "selected"; } ?>>IFN</option>
                        <option value="1" <?php if($this->session->userdata('kepemilikan')=='1'){ echo "selected"; } ?>>DLN</option>
                      </select>
                    </div>
                  </div>
                  <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">KATEGORI</label>
                    <div class="col">
                      <select name="katbarang" id="katbarang" class="form-control form-select form-sm font-kecil">
                        <option value="">Semua</option>
                        <?php foreach($kategori->result_array() as $xkate): ?>
                          <option value="<?= $xkate['id_kategori'] ?>" <?php if($this->session->userdata('katebar')==$xkate['id_kategori']){ echo "selected"; } ?>><?= $xkate['nama_kategori'] ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                  </div>
                </div>
                <div class="col-3 font-kecil">
                  <!-- <div class="text-blue font-bold mt-2">Jumlah IDR : <span id="jumlahidr" style="font-weight: normal;">Loading ..</span></div> -->
                  <!-- <div class="text-blue font-bold">Jumlah USD : <span id="jumlahusd" style="font-weight: normal;">Loading ..</span></div> -->
                </div>
                <div class="col-3 ml-2">
                  <div class="text-blue font-bold mt-2 ">Jumlah Dok : <span id="jumlahrekod" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold">Jumlah Qty : <span id="jumlahpcs" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold">Jumlah Kgs : <span id="jumlahkgs" style="font-weight: normal;">Loading ..</span></div>
                </div>
                
                <div class="col-3">
                  <!-- <div class="">
                    <label class="form-check form-check-inline mb-1">
                      <input class="form-check-input" type="radio" name="radios-inline" value="Cari Barang" checked>
                      <span class="form-check-label font-kecil">No Pendaftaran</span>
                    </label>
                  </div>
                  <div class="input-group mb-0">
                    <?php $textcari = $this->session->userdata('nopen') != null ? $this->session->userdata('nopen') : ''; ?>
                    <input type="text" class="form-control form-sm font-kecil" placeholder="Cari Nomor Pendaftaran …" value="<?= $textcari; ?>" id="textcari" style="text-transform: uppercase; height: 38px;">
                    <button class="btn text-center font-kecil" type="button" id="buttoncaribcmasuk" style="height: 38px;">
                      Cari
                    </button>
                  </div> -->
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
          <table id="tabel" class="table order-column table-hover datatable11 mt-2" style="width: 100% !important;">
            <thead>
              <tr class="text-left">
                <th class="text-center">No</th>
                <th class="text-left">Sku / Nama Barang</th>
                <th class="text-left">Satuan</th>
                <th class="text-left">Saldo Awal</th>
                <th class="text-left">Pemasukan</th>
                <th class="text-left">Pengeluaran</th>
                <th class="text-left">Saldo Akhir</th>
                <th class="text-left">Ket</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
            <?php $no=0; $jmkg = 0;$jmpc = 0; if($data != null): foreach($data->result_array() as $data): ?>
            <?php 
                  $saldo = $data['saldokgs'] > 0 ? $data['saldokgs'] : $data['saldopcs']; 
                  $in = $data['saldokgs'] > 0 ? $data['inkgs'] : $data['inpcs']; 
                  $out = $data['saldokgs'] > 0 ? $data['outkgs'] : $data['outpcs']; 
                  $sat = $data['saldokgs'] > 0 ? 'KGS' : $data['kodesatuan']; 
                  $no++;
                  if($sat == 'KGS'){
                    $jmkg += ($data['saldokgs']+$data['inkgs'])-$data['outkgs'];
                  }else{
                    $jmpc += $data['saldopcs']+$data['inpcs']-$data['outpcs'];
                  }
                  
            ?>
              <tr>
                <td><?= $no ?></td>
                <td class="line-12"><span class="text-pink font-11"><?= $data['kode'] ?></span><br><a href="<?= base_url().'bcmaterial/getdatabyid/'.$data['id_barang'] ?>" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' title='View Detail'><?= $data['nama_barang'] ?></a></td>
                <td class="text-teal-green"><?= $sat ?></td>
                <td class="text-right text-teal-green"><?= rupiah($saldo,2) ?></td>
                <td class="text-right text-teal-green"><?= rupiah($in,2) ?></td>
                <td class="text-right text-teal-green"><?= rupiah($out,2) ?></td>
                <td class="text-right text-teal-green"><?= rupiah($saldo+$in-$out,2) ?></td>
                <td></td>
              </tr>
            <?php endforeach; endif; ?>
            </tbody>
          </table>
        </div>
        <span id="jumlahrek" class="hilang"><?= $no ?></span>
        <span id="jumlahpc" class="hilang"><?= $jmpc ?></span>
        <span id="jumlahkg" class="hilang"><?= $jmkg ?></span>
      </div>
    </div>
  </div>
</div>