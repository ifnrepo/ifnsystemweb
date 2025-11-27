<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Konfirmasi Input Barang
          (<?= $this->session->userdata('curdept'); ?> - <?= $this->session->userdata('todept'); ?>)
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url().'in'; ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="sisipkan" class="sticky-top bg-white">
          <div class="row mb-1 d-flex align-items-between">
            <input type="text" id="id_header" value="<?= $header['xid']; ?>" class="hilang">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6">
            </div>
          </div>
          <div class="card card-active" style="clear:both;" >
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3 bg-cyan-lt">
                 <span>Nomor Dokumen : <strong class="font-bold"><?= $header['nomor_dok']; ?></strong></span><br>
                 <span>Tgl Dokumen : <strong class="font-bold"><?= tgl_indo($header['tgl']); ?></strong></span><br>
                 <?php 
                    if(in_array($header['dept_tuju'],daftardeptsubkon()) && $header['dept_id']=='FG'){ 
                      $suratjalan = $header['nomor_sjmasuk'].' Tgl '.tglmysql($header['tgl_sjmasuk']);
                  ?>
                  <span class="text-pink">Nomor BC : <strong class="font-bold"><?= $header['nomor_bcmasuk']; ?></strong></span><br>
                  <span class="text-pink">Tgl BC : <strong class="font-bold"><?= tgl_indo($header['tgl_bcmasuk']); ?></strong></span>
                 <?php }else{ 
                    $suratjalan = $header['nomor_sj'].'/'.tglmysql($header['tgl_sj']);
                  } ?>
                </div>
                <div class="col-4">
                  <?php if($mode==0){ ?>
                  <span>Nama Supplier : <strong class="font-bold"><?= $header['nama_supplier']; ?></strong></span><br>
                  <span>Alamat : <strong class="font-bold"><?= $header['alamat']; ?></strong></span><br>
                  <span>Kontak : <strong class="font-bold"><?= $header['kontak']; ?></strong></span>
                 <?php }else{ ?>
                  <span>Nama Rekanan : <strong class="font-bold"><?= $header['namasubkon']; ?></strong></span><br>
                  <span>Alamat : <strong class="font-bold"><?= $header['alamatsubkon']; ?></strong></span><br>
                 <?php } ?>
                </div>
                <div class="col-5 <?php if($header['tanpa_bc']==1){ echo "hilang"; } ?>">
                  <span>Nomor SJ/Tgl : <strong class="font-bold"><?= $suratjalan ?></strong></span><br>
                  <span>Nomor AJU/Tgl : <strong class="font-bold"><?= $header['nomor_aju'].'/'.tglmysql($header['tgl_aju']); ?></strong></span><br>
                  <span>Di Input : <strong class="font-bold"><?= datauser($header['user_ok'],'name').' on '.tglmysql2($header['tgl_ok']); ?></strong></span><br>
                </div>
                <div class="col-2">
                  <h4 class="mb-1"></h4>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
          
        </div>
        <div id="table-default" class="table-responsive">
          <table class="table datatable6" id="cobasisip">
            <thead>
              <tr>
                <th>No</th>
                <th>Nama Barang</th>
                <th>SKU</th>
                <th>Satuan</th>
                <th>Pcs</th>
                <th>Kgs</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
            <?php $no=1; $noverif=0; foreach ($detail as $datdet) { $noverif += $datdet['verif_oleh']==null ? 0 : 1; 
              $namabar = trim($datdet['po'])=='' ? $datdet['nama_barang'] : $datdet['spek']; 
              $dis = $datdet['dis']==0 ? '' : ' dis '.$datdet['dis'];
              $sku = trim($datdet['po'])=='' ? $datdet['kode'] : $datdet['po'].'#'.$datdet['item'].$dis;
              $satuan = $datdet['id_satuan']==0 ? 'PCS' : $datdet['namasatuan'];
              ?>
              <tr>
                <td><?= $no++; ?></td>
                <td class="line-11"><?= $namabar.'<br><span class="text-pink font-11">'.$datdet['insno'].'</span>' ?></td>
                <td><?= $sku; ?></td>
                <td><?= $satuan; ?></td>
                <td><?=rupiah($datdet['pcs'],0) ?></td>
                <td><?=rupiah($datdet['kgs'],2) ?></td>
                <td class="text-center">
                  <div id="<?= $datdet['id']; ?>">
                    <?php if($datdet['verif_oleh']==null){ ?>
                      <a class="btn btn-sm btn-success" id="verifikasirekord" rel="<?= $datdet['id']; ?>" style="padding: 3px 5px !important">Verifikasi</a>
                    <?php }else{ ?>
                      <div class='text-primary line-12' style='font-size: 11px !important;'>Verifikasi :<?= substr(datauser($datdet['verif_oleh'],'name'),0,15); ?><br><?= $datdet['verif_tgl']; ?></div>
                    <?php } ?>
                    <!-- <a href="#" class="btn btn-sm btn-info" style="padding: 3px 5px !important">Edit</a> -->
                  </div>
                </td>
              </tr>
            <?php } ?>
            </tbody>
          </table>
        </div>
        <hr class="m-1">
        <div class="form-tombol mt-1">
          <span style="float: left;" class="font-bold text-primary" id="infoverif">Verifikasi : <?= $noverif; ?>/<?= $no-1; ?></span>
          <div class="text-right">
            <?php $xmode = $mode==0 ? '' : '/1'; ?>
            <input type="text" id="jmlrek" value="<?= $no-1; ?>" class="hilang">
            <input type="text" id="jmlverif" value="<?= $noverif; ?>" class="hilang">
            <button class="btn btn-sm btn-primary" id="xsimpanin" ><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
            <?php if($this->session->userdata('curdept')=='GM' && $this->session->userdata('todept')=='SU'){ ?>
              <button class="btn btn-sm btn-primary hilang" id="carisimpanin" data-title="Update Nomor Bon Penerimaan" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Akan menyimpan data <br><?= $header['nomor_dok']; ?>" href="<?= base_url() . 'in/konfirmasinobon/'.$header['xid'].$xmode; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
            <?php }else{ ?>
              <button class="btn btn-sm btn-primary hilang" id="carisimpanin" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data <br><?= $header['nomor_dok']; ?>" data-href="<?= base_url() . 'in/simpanin/'.$header['xid'].$xmode; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
            <?php } ?>
            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" data-tombol="Ya" data-message="Akan mereset data penerimaan ini" data-href="<?= base_url() . 'in/resetin/'.$header['xid']; ?>"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        