<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <div>OUT (Perpindahan Barang) # <?= $data['nomor_dok'] ?><br>
          <span class="title-dok">Tgl. <?= tglmysql($data['tgl']); ?> - BC ASAL (<?= getnomorbcbykontrak($data['keterangan'],$data['dept_id'],$data['dept_tuju']) ?>)</span></div>
          <input type="text" class="hilang" id="nomor_dok" value="<?= $data['nomor_dok']; ?>">
        </h2>
      </div>
      <input id="errornya" class="hilang" value="<?= $this->session->flashdata('errornya'); ?>">
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'out/dataout/'.$data['id']; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div class="row">
          <div class="col-5 p-1" style="min-height: 150px; border: 1px solid #eaeaea; border-radius:4px;">
            <div class="formpencarian p-3">
              <div class="separator font-kecil mb-1 text-secondary">Isi Kategori Pencarian</div>
              <div class="mb-1 row">
                  <input type="text" class="hilang" name="idhead" id="idhead" value="<?= $data['id'] ?>">
                  <label class="col-3 col-form-label font-kecil">PO</label>
                  <div class="col">
                      <input type="text" class="form-control font-kecil btn-flat text-uppercase" id="po" name="po" value="" aria-describedby="emailHelp" placeholder="PO">
                  </div>
              </div>
              <div class="mb-1 row">
                  <label class="col-3 col-form-label font-kecil">Item</label>
                  <div class="col">
                      <input type="text" class="form-control font-kecil btn-flat" id="item" name="item" value="" aria-describedby="emailHelp" placeholder="Item">
                  </div>
              </div>
              <div class="mb-1 row">
                  <label class="col-3 col-form-label font-kecil">Dis</label>
                  <div class="col">
                      <input type="text" class="form-control font-kecil btn-flat" id="dis" name="dis" value="" aria-describedby="emailHelp" placeholder="Dis">
                  </div>
              </div>
              <div class="separator font-kecil my-1 text-secondary">Atau</div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label font-kecil">ID Barang</label>
                <div class="col">
                  <input type="text" name="idbarang" id="idbarang" class="hilang">
                  <input type="text" class="form-control font-kecil btn-flat" id="id_barang" name="id_barang" value="" aria-describedby="emailHelp" placeholder="ID Barang">
                </div>
              </div>
              <div class="separator font-kecil my-1 text-secondary">Atau</div>
              <div class="mb-1 row">
                  <label class="col-3 col-form-label font-kecil">Spesifikasi</label>
                  <div class="col">
                      <input type="text" class="form-control font-kecil btn-flat" id="spek" name="spek" value="" aria-describedby="emailHelp" placeholder="Spesifikasi Barang" readonly>
                  </div>
              </div>
              <div>
                <a href="#" class="btn form-control btn-sm btn-flat btn-success" id="pencarianitembarang">Cari</a>
                <a href="<?= base_url().'out/cekdatabarangdobel/XXX/XXX' ?>" class="btn form-control btn-sm btn-flat btn-info hilang" data-bs-toggle='modal' data-bs-target='#modal-large' data-title='Pilih Data' id="pencarianitembarangdobel">Cari</a>
              </div>
            </div>
            <div class="hasilpencarian p-3 hilang" id="hasilpencarian">
              <div class="mb-1 row">
                  <label class="col-3 col-form-label font-kecil">SKU</label>
                  <div class="col">
                      <input type="text" class="form-control font-kecil btn-flat" id="sku" name="sku" value="" aria-describedby="emailHelp" placeholder="SKU Barang" readonly>
                  </div>
              </div>
              <div class="mb-1 row">
                  <label class="col-3 col-form-label font-kecil">Spesifikasi Barang</label>
                  <div class="col">
                      <textarea name="speknya" id="speknya" class="form-control font-kecil btn-flat" rows="3" readonly></textarea>
                  </div>
              </div>
              <div class="mb-1 row">
                  <label class="col-3 col-form-label font-kecil">No Instruksi</label>
                  <div class="col">
                      <input type="text" class="form-control font-kecil btn-flat text-uppercase" id="insno" name="insno" value="" aria-describedby="emailHelp" placeholder="Nomor Instruksi">
                      <select name="insno-sel" id="insno-sel" class="form-control font-kecil btn-flat text-uppercase">

                      </select>
                  </div>
              </div>
              <div class="mb-1 row">
                  <label class="col-3 col-form-label font-kecil">Nomor IB</label>
                  <div class="col">
                      <input type="text" class="form-control font-kecil btn-flat text-uppercase" id="nobontr" name="nobontr" value="" aria-describedby="emailHelp" placeholder="Nomor IB">
                  </div>
              </div>
              <div class="mb-1 row">
                  <label class="col-3 col-form-label font-kecil">Pcs</label>
                  <div class="col">
                      <input type="text" class="form-control font-kecil btn-flat text-right inputangka" id="pcsout" name="pcsout" value="" aria-describedby="emailHelp" placeholder="Jumlah Barang">
                  </div>
              </div>
              <div class="mb-1 row">
                  <label class="col-3 col-form-label font-kecil">Kgs</label>
                  <div class="col">
                      <input type="text" id="jalamimi" class="hilang">
                      <input type="text" class="form-control font-kecil btn-flat text-right inputangka" id="kgsout" name="kgsout" value="" aria-describedby="emailHelp" placeholder="Berat Barang">
                  </div>
              </div>
              <hr class="m-1">
              <div class="d-flex justify-content-between">
                <a href="#" class="btn form-sm btn-sm btn-flat" id="batalkanitembarang">Batal/Reset</a>
                <a href="#" class="btn form-sm btn-sm btn-flat btn-success" style="width: 50%" id="simpanitembarang">Simpan Barang</a>
              </div>
            </div>
          </div>
          <div class="col-7">
            <table class="table table-bordered m-0 mt-1 mb-1 table-hover">
                <thead class="bg-primary-lt">
                    <tr>
                        <th class="text-center text-black">Spesifikasi</th>
                        <th class="text-center text-black">SKU</th>
                        <th class="text-center text-black">Pcs</th>
                        <th class="text-center text-black">Kgs</th>
                        <th class="text-center text-black">Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="tabeltempbarang">
                  <?php if($detail->num_rows() > 0): $jmpcs=0;$jmkgs=0; foreach($detail->result_array() as $dt): $spek = trim($dt['po'])!='' ? spekpo($dt['po'],$dt['item'],$dt['dis']) : namaspekbarang($dt['id_barang']); ?>
                  <?php $ins = trim($dt['insno'])=='' ? '' : ' Ins. '.trim($dt['insno']); $ib = trim($dt['nobontr'])=='' ? '' : ' IB. '.trim($dt['nobontr']);  ?>
                    <tr class="font-kecil">
                      <td class="line-11"><?= $spek ?><br><span class="text-pink"><?= $ins.$ib ?></span></td>
                      <td><?= formatsku($dt['po'],$dt['item'],$dt['dis'],$dt['id_barang']) ?></td>
                      <td class="text-right"><?= rupiah($dt['pcs'],0) ?></td>
                      <td class="text-right"><?= rupiah($dt['kgs'],2) ?></td>
                      <td class="text-center">
                        <a href="#" class="btn btn-sm btn-info btn-flat m-0 mr-1" style="padding: 0px 2px !important;"><i class="fa fa-pencil mr-1"></i>Edit</a>
                        <a href="#" data-href="<?= base_url().'out/hapusbarangtemp/'.$dt['id'].'/'.$data['id'] ?>" class="btn btn-sm btn-danger btn-flat m-0" style="padding: 0px 2px !important;" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini"><i class="fa fa-trash-o mr-1"></i>Hapus</a>
                      </td>
                    </tr>
                  <?php $jmpcs += $dt['pcs']; $jmkgs += $dt['kgs']; endforeach; ?>
                    <tr class="font-kecil bg-primary-lt">
                      <td colspan="2" class="text-right font-bold text-black">TOTAL</td>
                      <td class="text-right font-bold text-black"><?= rupiah($jmpcs,0) ?></td>
                      <td class="text-right font-bold text-black"><?= rupiah($jmkgs,2) ?></td>
                      <td></td>
                    </tr>
                  <?php else: ?>
                    <tr class="font-kecil">
                      <td colspan="5" class="text-center">-- Data Kosong --</td>
                    </tr>
                  <?php endif; ?>
                </tbody>
            </table>
            <div class="d-flex justify-content-between">
              <a href="#" data-href="<?= base_url().'out/resetbarangtemp/'.$data['id'] ?>" class="btn btn-sm btn-link link-secondary" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan mengosongkan data <?= $data['nomor_dok'] ?>" data-tombol="Ya">Reset Data</a>
              <a href="#" data-href="<?= base_url().'out/addbarangtemp/'.$data['id'] ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Simpan transaksi <?= $data['nomor_dok'] ?>" class="btn btn-sm btn-flat btn-primary" id="simpantransaksitemp"><i class="fa fa-save mr-1"></i>Simpan Transaksi</a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>