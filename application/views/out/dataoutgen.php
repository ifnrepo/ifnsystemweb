<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <?php $spek = trim($detail['po'])=='' ? namaspekbarang($detail['id_barang']) : spekpo($detail['po'],$detail['item'],$detail['dis']);  ?>
          <div>Edit Data Detail # <?= $data['nomor_dok'] ?><br><span class="title-dok text-secondary"><?= $spek ?></span></div>
          <input type="text" class="hilang" id="nomor_dok" value="<?= $data['nomor_dok']; ?>">
        </h2>
      </div>
      <input id="errornya" class="hilang" value="<?= $this->session->flashdata('errornya'); ?>">
      <div class="col-md-6" style="text-align: right;">
        <?php if ($mode == 'tambah') : ?>
          <a href="<?= base_url() . 'out/dataout/'.$data['id']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="sisipkan">
          <?php if($this->session->flashdata('errornya')!=''): ?>
            <div class="alert alert-important alert-danger alert-dismissible bg-danger-lt mb-1" role="alert">
              <div class="d-flex"> 
                <div class="font-kecil">
                  <span class="text-black font-bold">INFORMATION</span><br>
                  <?= $this->session->flashdata('errornya'); ?>
                </div>
              </div>
              <a class="btn-close text-black font-bold" data-bs-dismiss="alert" aria-label="close"></a>
            </div>
            <?php endif; ?>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-6">
                  <input type="text" id="tgldok" class="hilang" value="<?= tglmysql($data['tgl']); ?>">
                  <input type="text" id="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <input type="text" id="id_detail" class="hilang" value="<?= $detail['id']; ?>">
                  <input type="text" id="jmlkgstot" class="hilang" value="<?= round($detail['kgs'],2); ?>">
                  <h4 class="mb-0 font-kecil" style="color: #808080">SKU</h4>
                  <input type="text" id="catat" class="hilang" value="<?= $data['keterangan']; ?>">
                  <span class="font-bold">
                    <?php $sku = trim($detail['po'])=='' ? namaspekbarang($detail['id_barang'],'kode') : viewsku($detail['po'],$detail['item'],$detail['dis']); ?>
                    <?= $sku; ?>
                  </span>
                  <h4 class="mb-0 font-kecil" style="color: #808080">Insno / Nobontr</h4>
                  <span class="font-bold mt-0 ln-11">
                    <?php 
                      $insno = trim($detail['insno'])!='' ? 'Insno : '.$detail['insno'] : '-'; 
                      $insno .= trim($detail['nobontr'])!='' ? 'Nobontr : '.$detail['nobontr'] : '-'; 
                    ?>
                    <?= $insno; ?>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-0 font-kecil" style="color: #808080">Berat</h4>
                  <span class="font-bold">
                    <?= rupiah($detail['kgs'],2); ?>
                  </span>
                </div>
                <div class="col-3">
                  <div class="text-right"><h4><?= $this->session->userdata('deptsekarang'); ?> to <?= $this->session->userdata('tujusekarang'); ?></h4></div>
                  <div style="position:absolute;bottom:0px;right:10px;">
                  <a href="<?= base_url().'out/addbarangoutgentemp'; ?>" class="btn btn-sm btn-primary p-0" data-bs-toggle="modal" data-bs-target="#modal-largescroll2" data-title="Tambah Detail Barang"><i class="fa fa-plus mr-1"></i> Tambah Barang</a>
                  </div>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-12 mt-1">
            <div id="table-default" class="table-responsive">
              <table class="table table-hover display cell-border datatable6 " style="width: 100% !important; border-collapse: collapse;">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>No</th>
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Insno/Nobontr</th>
                    <th>Exnet</th>
                    <th>Nobale</th>
                    <th>Pcs</th>
                    <th>Kgs</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" class="font-kecil">
                  <?php $no=1; $totkgs=0; foreach($detailgen->result_array() as $detgen): ?>
                  <?php 
                    $spekgen = trim($detgen['po'])=='' ? namaspekbarang($detgen['id_barang']) : spekpo($detgen['po'],$detgen['item'],$detgen['dis']); 
                    $skugen = trim($detgen['po'])=='' ? namaspekbarang($detgen['id_barang'],'kode') : viewsku($detgen['po'],$detgen['item'],$detgen['dis']); 
                    $exnet = $detgen['exnet']==0 ? '' : '<span class="text-green font-bold">Y</span>';
                    $totkgs += $detgen['kgs'];
                  ?>
                    <tr class="font-kecil">
                      <td><?= $no++ ?></td>
                      <td><?= $spekgen ?></td>
                      <td><?= $skugen ?></td>
                      <td class="line-11 font-kecil"><?= $detgen['insno'].'<br>'.$detgen['nobontr'] ?></td>
                      <td class="text-center"><?= $exnet ?></td>
                      <td><?= $detgen['nobale'] ?></td>
                      <td class="text-right"><?= rupiah($detgen['pcs'],0) ?></td>
                      <td class="text-right"><?= rupiah($detgen['kgs'],2) ?></td>
                      <td class="text-center">
                        <a href="<?= base_url().'out/editgentemp/'.$detgen['idx'] ?>" class='btn btn-sm btn-primary m-0' style='padding: 2px 5px !important;' data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Edit Data Detail'>Edit</a>
                        <a href='#' data-href="<?= base_url().'out/hapusdatadetailgentemp/'.$detgen['idx'] ?>" data-message='Akan menghapus data barang <br><?= $spek ?>' class='btn btn-sm btn-danger' style='padding: 2px 5px !important;' data-bs-toggle='modal' data-bs-target='#modal-danger' data-title='Ubah data Detail'>Hapus</a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>
            </div>
            <div id="jmltotdet" class="text-end text-primary">
                Total : <?= $totkgs ?>
            </div>
          </div>
        </div>
        <hr class="m-1">
        <div class="form-tombol mt-1 text-right">
          <input type="text" id="jmlkgs" class="hilang" value="<?= $totkgs ?>">
          <a href="#" data-href="<?= base_url().'out/editdetailgenout/'.$detgen['id_detail'].'/'.$detgen['id_header']; ?>" class="btn btn-sm btn-outline-danger p-0" data-message='Akan mereset data ke default' data-bs-toggle='modal' data-bs-target='#modal-info' data-title='Ubah data Detail' title="Reset Detail Barang"><i class="fa fa-times mr-1"></i> Reset</a>
          <a href="#" data-href="<?= base_url().'out/simpandetailgenbarang/'.$detgen['id_detail'].'/'.$detgen['id_header']; ?>" class="btn btn-sm btn-primary p-0" data-message='Akan menyimpan data' data-bs-toggle='modal' data-bs-target='#modal-info' data-title='Ubah data Detail'><i class="fa fa-save mr-1"></i> Simpan Detail Barang</a>
        </div>
      </div>
    </div>
  </div>
</div>