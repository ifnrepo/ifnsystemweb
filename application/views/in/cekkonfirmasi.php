<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Konfirmasi Input Barang <?= $this->session->userdata('bl').$this->session->userdata('th'); ?>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url().'in/clear'; ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
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
                <div class="col-3">
                 <span>Nomor Dokumen : <strong class="font-bold"><?= $header['nomor_dok']; ?></strong></span><br>
                 <span>Tgl Dokumen : <strong class="font-bold"><?= tgl_indo($header['tgl']); ?></strong></span>
                </div>
                <div class="col-4">
                 <span>Nama Supplier : <strong class="font-bold"><?= $header['nama_supplier']; ?></strong></span><br>
                 <span>Alamat : <strong class="font-bold"><?= $header['alamat']; ?></strong></span><br>
                 <span>Kontak : <strong class="font-bold"><?= $header['kontak']; ?></strong></span>
                </div>
                <div class="col-5">
                  <span>Nomor SJ/Tgl : <strong class="font-bold"><?= $header['nomor_sj'].'/'.tglmysql($header['tgl_sj']); ?></strong></span><br>
                  <span>Nomor AJU/Tgl : <a href="#"><strong class="font-bold"><?= $header['nomor_aju'].'/'.tglmysql($header['tgl_aju']); ?></strong></a></span><br>
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
            <?php $no=1; $noverif=0; foreach ($detail as $datdet) { $noverif += $datdet['verif_oleh']==null ? 0 : 1; ?>
              <tr>
                <td><?= $no++; ?></td>
                <td><?=$datdet['nama_barang'] ?></td>
                <td><?=$datdet['kode'] ?></td>
                <td><?=$datdet['namasatuan'] ?></td>
                <td><?=rupiah($datdet['pcs'],0) ?></td>
                <td><?=rupiah($datdet['kgs'],2) ?></td>
                <td class="text-center">
                  <div id="<?= $datdet['id']; ?>">
                    <?php if($datdet['verif_oleh']==null){ ?>
                      <a href="#" class="btn btn-sm btn-success" id="verifikasirekord" rel="<?= $datdet['id']; ?>" style="padding: 3px 5px !important">Verifikasi</a>
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
            <input type="text" id="jmlrek" value="<?= $no-1; ?>" class="hilang">
            <input type="text" id="jmlverif" value="<?= $noverif; ?>" class="hilang">
            <button class="btn btn-sm btn-primary" id="xsimpanin" ><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
            <button class="btn btn-sm btn-primary hilang" id="carisimpanin" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data <br><?= $header['nomor_dok']; ?>" data-href="<?= base_url() . 'in/simpanin/'.$header['xid']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
            <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" data-tombol="Ya" data-message="Akan mereset data penerimaan ini" data-href="<?= base_url() . 'in/resetin/'.$header['xid']; ?>"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        