<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <div>OUT (Perpindahan Barang) # <?= $data['nomor_dok'] ?><br><span class="title-dok"><?php if($data['jn_bbl']==1){echo "dengan Bon Permintaan";}else{echo "tanpa Bon Permintaan";} ?></span></div>
          <input type="text" class="hilang" id="nomor_dok" value="<?= $data['nomor_dok']; ?>">
        </h2>
      </div>
      <input id="errornya" class="hilang" value="<?= $this->session->flashdata('errornya'); ?>">
      <div class="col-md-6" style="text-align: right;">
        <?php if ($mode == 'tambah') : ?>
          <a href="<?= base_url() . 'out'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
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
                <div class="col-3">
                  <h4 class="mb-0 font-kecil">Tgl</h4>
                  <input type="text" id="tgldok" class="hilang" value="<?= tglmysql($data['tgl']); ?>">
                  <input type="text" id="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <a href="<?= base_url() . 'out/edit_tgl'; ?>" title="Edit Tgl" id="tglpb" name="tglpb" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                      <?= tglmysql($data['tgl']); ?>
                      <!-- <i class="fa fa-edit"></i> -->
                    </a>
                  </span>
                  <h4 class="mb-0 font-kecil">Catatan</h4>
                  <input type="text" id="catat" class="hilang" value="<?= $data['keterangan']; ?>">
                  <span class="font-bold" style="font-size:15px;">
                    <?php if(in_array($data['dept_id'],daftardeptsubkon())){ ?>
                      <?= $data['keterangan']; ?> - BC ASAL <?= getnomorbcbykontrak($data['keterangan'],$data['dept_id'],$data['dept_tuju']) ?>
                    <?php }else{ ?>
                      <?= $data['keterangan']; ?>
                    <?php } ?>
                    <a href="<?= base_url() . 'out/edit_tgl'; ?>" title="Edit tanggal" id="catatan" name="catatan" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Tgl / Catatan">
                      <i class="fa fa-edit"></i>
                    </a>
                  </span>
                </div>
                <div class="col-4">
                  <?php if($this->session->userdata('deptsekarang')=='GF' && $this->session->userdata('tujusekarang')=='CU'): ?>
                  <div class="">
                    <h4 class="mb-0 font-kecil font-bold">CUSTOMER</h4>
                    <div class="input-group">
                      <?php $tekstitle = $data['id_buyer'] == null ? 'Cari ' : 'Ganti '; ?>
                      <?php $tekstitle2 = $data['id_buyer'] == null || $data['id_buyer'] == 0 ? 'Cari ' : $data['id_buyer']; ?>
                      <a href="<?= base_url() . 'out/editcustomer'; ?>" class="btn font-bold bg-success" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Cari Customer" title="<?= $tekstitle; ?> Supplier"><?= $tekstitle2; ?></a>
                      <input type="text" class="form-control font-kecil" aria-label="Text input with dropdown button" placeholder="Nama Customer" value="<?= $data['nama_customer']; ?>">
                    </div>
                    <div class="mt-1">
                      <textarea class="form-control form-sm font-kecil" placeholder="Alamat"><?= $data['alamat']; ?></textarea>
                    </div>
                    <div class="mt-0" style="margin-top: 1px !important;">
                      <div class="input-icon">
                        <input type="text" class="form-control font-kecil" aria-label="Text input with dropdown" placeholder="Kontak" value="<?= $data['kontak']; ?>">
                        <span class="input-icon-addon" id="loadertgldtbt">

                        </span>
                      </div>
                    </div>
                  </div>
                  <?php endif; ?>
                </div>
                <div class="col-5">
                  <div class="text-right"><h4><?= $this->session->userdata('deptsekarang'); ?> to <?= $this->session->userdata('tujusekarang'); ?></h4></div>
                  <div style="position:absolute;bottom:0px;right:10px;">
                    <?php if($data['jn_bbl']==1){ ?>
                      <a data-bs-toggle="modal" data-bs-target="#modal-largescroll" data-title="Add Data" href="<?= base_url() . 'out/tambahdata/1' ?>" class="btn btn-sm btn-success">Get Barang</a>
                    <?php }else{ ?>
                      <a href="<?= base_url().'out/addbarangout'; ?>" class="btn btn-sm btn-success p-0" data-bs-toggle="modal" data-bs-target="#modal-largescroll2" data-title="Add Detail Barang">Input Barang</a>
                    <?php } ?>
                  </div>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-<?php if($data['jn_bbl']==1){ echo "12";}else{ echo "12";} ?> mt-1">
            <div id="table-default" >
              <table class="table table-hover text-nowrap table-bordered" style="width: 100% !important;" id="cobasisip">
                <thead>
                  <tr>
                    <!-- <th>No</th> -->
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Nobale</th>
                    <th>Stok</th>
                    <?php if($data['jn_bbl']==1): ?>
                    <th>Qty<br>MINTA</th>
                    <th>Kgs<br>MINTA</th>
                    <?php endif; ?>
                    <th>Qty</th>
                    <th>Kgs</th>
                    <?php if($this->session->userdata('deptsekarang')=='GM'){ ?>
                    <th>Nobontr</th>
                    <?php } ?>
                    <?php if($this->session->userdata('deptsekarang')=='GP' || $this->session->userdata('deptsekarang')=='RR'){ ?>
                    <th>Insno</th>
                    <?php } ?>
                    <?php if($this->session->userdata('deptsekarang')=='GS'){ ?>
                    <th>SBL</th>
                    <?php } ?>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                  <?php $jumlah=0; $jumtotdet=0; if($detail->num_rows() > 0): $deptinsno = ['GP','RR']; ?>
                    <?php 
                      foreach($detail->result_array() as $que): 
                        $tandakurang = trim($this->session->userdata('serierror'))==trim($que['seri_barang']) ? 'text-danger' : '';
                        $dis = $que['dis']==0 ? '' : ' dis '.$que['dis'];
                        $sku =trim($que['po'])=='' ? $que['kode'] : formatsku($que['po'],$que['item'],$que['dis'],$que['id_barang']);
                        $modecari = trim($que['po'])=='' ? 0 : 1; // Jika 0 pencarian ID Barang, jika 1 pencarian PO
                        $kodecari = trim($que['po'])=='' ? $que['id_barang'] : trim($que['po']).'_'.trim($que['item']).'_'.$que['dis'];
                        $nmbarang = trim($que['po'])==''? $que['nama_barang'] : spekpo($que['po'],$que['item'],$que['dis']);
                        $nobale = trim($que['nobale'])=='' ? '' : ' Bale Nomor : '.$que['nobale']; 
                        $infoinsno = "<br><span class='text-teal font-kecil'>".$que['insno']."</span>";
                        $jumtotdet += $que['kgs'];
                        $stk = $que['stok']==0 ? '' : ($que['stok']==1 ? 'Grade A' : 'Grade B');
                    ?>
                    <tr>
                      <td style="line-height: 12px !important; vertical-align: middle;" >
                        <a class="<?= $tandakurang ?>" href="<?= base_url().'out/getdatadetail/'.$que['id_header']."/".$que['id'] ?>" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="Data Detail Barang : <?= $nmbarang ?>" >
                          <?= $que['seri_barang'].'. '.$nmbarang.$infoinsno ?>
                        </a>
                      </td>
                      <td class="font-kecil"><?= $sku ?></td>
                      <td id="<?= $que['id'] ?>"><?= trim($que['nobale']) ?></td>
                      <td class="text-center font-bold"><?= $stk ?></td>
                      <?php if($data['jn_bbl']==1): ?>
                        <td class='text-right'><?= rupiah($que['pcsminta'],0) ?></td>
                        <td class='text-right'><?= rupiah($que['kgsminta'],2) ?></td>
                      <?php endif; ?>
                      <td class='text-primary text-right'><?= rupiah($que['pcs'],0) ?></td>
                      <td class='text-primary text-right'><?= rupiah($que['kgs'],2) ?></td>
                      <?php if($this->session->userdata('deptsekarang')=='GM' && $que['nobontr']!=''): ?>
                        <td class='text-primary'><?= $que['nobontr'] ?></td>
                      <?php else: if($this->session->userdata('deptsekarang')=='GM' && $que['nobontr']==''){ ?>
                        <td class="text-primary"><a class="text-info" href="<?= base_url().'out/addnobontr/'.$que['id'].'/'.$que['id_barang'] ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Pilih Data Nobontr">Pilih Nobontr</a></td>
                      <?php } endif; ?>
                      <?php if(in_array($this->session->userdata('deptsekarang'),$deptinsno) && trim($que['insno'])!=''): ?>
                        <td class="text-primary font-kecil"><?= $que['insno'] ?></td>
                      <?php else: if(in_array($this->session->userdata('deptsekarang'),$deptinsno) && trim($que['insno'])==''){ ?>
                        <td class="text-primary"><a class="text-danger" href="<?= base_url().'out/addinsno/'.$que['id'].'/'.$modecari.'/'.$kodecari ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Pilih Data insno">Pilih Insno</a></td>
                      <?php } endif; ?>
                      <?php if($this->session->userdata('deptsekarang')=='GS'): ?>
                        <td class="text-primary font-bold"><?= $que['sublok'] ?></td>
                      <?php endif; ?>
                      <td class="text-center">
                        <a href="<?= base_url().'out/editdetailout/'.$que['id'] ?>" class="btn btn-sm btn-primary" style="padding: 3px 5px !important;" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Ubah data Detail">Ubah Qty</a>
                        <a href="#" data-href="<?= base_url().'out/hapusdetailout/'.$que['id'].'/'.$que['id_header'] ?>" data-message="Akan menghapus data barang <?= $que['nama_barang'] ?>" class="btn btn-sm btn-danger" style="padding: 3px 5px !important;" data-bs-toggle="modal" data-bs-target="#modal-danger" data-title="Ubah data Detail">Hapus</a>
                        <a href="<?= base_url().'out/editdetailgenout/'.$que['id'].'/'.$que['id_header'] ?>" class="btn btn-sm btn-success" style="padding: 3px 5px !important;" title="Ubah data Detailgen">Edit Detail</a>
                      </td>
                    </tr>
                    <?php $jumlah++; endforeach; ?>
                  <?php endif; ?>    
                </tbody>
              </table>
            </div>
            <div class="text-end text-primary" id="jumtotdet">
              Total Kgs : <?= rupiah($jumtotdet,2) ?>
            </div>
          </div>
        </div>
        <hr class="m-1">
        <div class="form-tombol mt-1 text-right">
          <input type="text" id="jmlrek" value="<?= $jumlah ?>" class="hilang">
          <a href="#" class="btn btn-sm btn-primary" id="xsimpanout"><i class="fa fa-save mr-1"></i> Simpan Transaksi</a>
          <button href="#" class="btn btn-sm btn-primary hilang" id="simpanout" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini" data-href="<?= base_url() . 'out/simpanheaderout/' . $data['id']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
          <a href="#" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" data-tombol="Ya" data-message="Akan Reset data ini" data-href="<?= base_url() . 'out/resetdetail/' . $data['id']; ?>"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
          <a class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="Rekap B.O.M OUT" href="<?= base_url() . 'out/viewrekapbom/' . $data['id']; ?>" id="viewrekap">View Rekap BOM</a>
        </div>
      </div>
    </div>
  </div>
</div>