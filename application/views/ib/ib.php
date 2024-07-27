<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          IB (Penerimaan Barang)
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
        <input type="text" id="errorsimpan" class="hilang" value="<?= $this->session->flashdata('errorsimpan'); ?>">
        <div id="sisipkan" class="sticky-top bg-white">
          <div class="row mb-1 d-flex align-items-between">
            <div class="col-sm-6 mb-1">
              <a href="<?= base_url() . 'ib/tambahdataib'; ?>" class="btn btn-primary btn-sm" id="adddataib"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            </div>
            <div class="col-sm-6 mb-0 d-flex flex-row-reverse" style="text-align: right;">
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="th" name="th" style="width: 75px;" value="<?= $this->session->userdata('th') ?>">
              <select class="form-select form-control form-sm font-kecil font-bold mr-1" id="bl" name="bl" style="width: 100px;" <?= $levnow; ?>>
                <?php for ($x = 1; $x <= 12; $x++) : ?>
                  <option value="<?= $x; ?>" <?php if ($this->session->userdata('bl') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                <?php endfor; ?>
              </select>
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2">
                  <h4 class="mb-1 font-kecil">Dept Penerima</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="dept_tuju" name="dept_tuju">
                        <?php foreach ($hakdep as $dep) { if($dep['bbl']==1):?>
                          <option value="<?= $dep['dept_id']; ?>" <?php if($this->session->userdata('depttuju')==$dep['dept_id']){ echo "selected"; } ?>><?= $dep['departemen']; ?></option>
                        <?php endif; } ?>
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1 font-kecil">.</h4>
                  <span class="font-kecil">
                    <a href="#" class="btn btn-sm btn-primary" style="height: 38px;min-width:45px;" id="butgo">Go</a>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1"></h4>
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
          <table id="pbtabel" class="table nowrap order-column" style="width: 100% !important;">
            <thead>
              <tr>
                <th>Tgl</th>
                <th>Nomor</th>
                <th>Supplier</th>
                <th>Jumlah Item</th>
                <th>Dibuat Oleh</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php foreach ($data as $datdet) {
                $jmlrek = $datdet['jumlah_barang'] != null ? $datdet['jumlah_barang'] . ' Item' : '0 Item';
                $namasup = $datdet['namasupplier'] != null ? $datdet['namasupplier']  : 'Not Set'; ?>
                <tr>
                  <td><?= tglmysql($datdet['tgl']); ?></td>
                  <td class='font-bold'><a href="<?= base_url().'ib/viewdetail/'.$datdet['id']; ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View detail IB (Penerimaan Barang)"><?= $datdet['nomor_dok'] ?></a></td>
                  <td><?= $namasup ?></td>
                  <td><?= $jmlrek ?></td>
                  <td class="line-12"><?= datauser($datdet['user_ok'], 'name') ?> <br><span style='font-size: 11px;'><?= tglmysql2($datdet['tgl_ok']) ?></span></td>
                  <td><?= $datdet['keterangan']; ?></td>
                  <td class="text-right line-12"><span style="color: white;">.</span>
                    <?php if ($datdet['data_ok'] == 0) { ?>
                      <a href="<?= base_url() . 'ib/dataib/' . $datdet['id'] ?>" class='btn btn-sm btn-primary' style='padding: 3px 5px !important;' title='Lanjutkan Transaksi'>Lanjutkan Transaksi</a>
                      <a href="#" data-href="<?= base_url() . 'ib/hapusib/' . $datdet['id'] ?>" class='btn btn-sm btn-danger' data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Hapus IB <br><?= $datdet['nomor_dok']; ?>" style='padding: 3px 5px !important;' title='Hapus data Transaksi'>Hapus</a>
                    <?php } else if ($datdet['data_ok'] == 1 && $datdet['ok_valid']==0) { ?>
                      <a href="#" data-href="<?= base_url() . 'po/editpo/' . $datdet['id'] ?>" class='btn btn-sm btn-danger' style='padding: 3px 5px !important;' data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Edit PO <br><?= $datdet['nomor_dok']; ?>" title='Edit Data'><i class='fa fa-refresh mr-1'></i> Edit PO</a>
                      <a href="<?= base_url().'po/invoice/'.$datdet['id']; ?>" class='btn btn-sm btn-success' style='padding: 3px 5px !important;' title='Cetak Data'><i class='fa fa-print mr-1'></i> Cetak PO</a>
                    <?php }else{ $katakata = $datdet['ok_valid']==2 ? 'Dicancel : ' : 'Disetujui :'; ?>
                      <?= $katakata.datauser($datdet['user_valid'], 'name') ?><br>
                      <span style='font-size: 11px;'><?= ' on '.tglmysql2($datdet['tgl_ok']) ?></span>
                    <?php } ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>