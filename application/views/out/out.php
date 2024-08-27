<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          OUT (Bon Perpindahan)
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
        <div id="sisipkan" class="sticky-top bg-white">
          <div class="row mb-1 d-flex align-items-between">
            <div class="col-sm-6 mb-1">
              <a href="<?= base_url() . 'out/adddata'; ?>" class="btn btn-primary btn-sm <?= cekclosebook(); ?>" id="adddataout"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
              <input type="hidden" id="errorparam" value="<?= $this->session->flashdata('errorparam'); ?>">
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
                  <h4 class="mb-1 font-kecil">Dept Asal</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="dept_kirim" name="dept_kirim">
                        <?php $arrjanganada = ['IT', 'PP', 'AK', 'MK', 'PG', 'BC', 'UT', 'RD', 'PC', 'EI']; ?>
                        <?php foreach ($hakdep as $hak) : if (!in_array($hak['dept_id'], $arrjanganada)) : $selek = $this->session->userdata('deptsekarang') == null ? '' : $this->session->userdata('deptsekarang'); ?>
                            <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?php if ($selek == $hak['dept_id']) echo "selected"; ?>><?= $hak['departemen']; ?></option>
                        <?php endif;
                        endforeach; ?>
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-2 ">
                  <h4 class="mb-1 font-kecil">Dept Tujuan</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="dept_tuju" name="dept_tuju">

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
                <th>Jumlah Item</th>
                <th>Dibuat Oleh</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php foreach ($data as $datdet) {
                $jmlrek = $datdet['jumlah_barang'] != null ? $datdet['jumlah_barang'] . ' Item' : '0 Item'; ?>
                <tr>
                  <td><?= tglmysql($datdet['tgl']); ?></td>
                  <?php if ($datdet['data_ok'] == 1) { ?>
                    <td class='font-bold'><a href='<?= base_url() . 'out/viewdetailout/' . $datdet['id'] ?>' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail'><?= $datdet['nomor_dok'] ?><br><span class="font-kecil"><?= $datdet['nodok'] ?></span></a></td>
                  <?php } else { ?>
                    <td class='font-bold'><a href='<?= base_url() . 'out/viewdetailout/' . $datdet['id'] ?>' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail'><?= $datdet['nomor_dok'] ?><br><span class="text-purple" style="font-size: 10px !important"><?= $datdet['nodok'] ?></span></a></td>
                  <?php } ?>
                  <td><?= $jmlrek; ?></td>
                  <td><?= datauser($datdet['user_ok'], 'name') ?> <br><span style='font-size: 11px;'><?= tglmysql2($datdet['tgl_ok']) ?></span></td>
                  <td><?= $datdet['keterangan']; ?></td>
                  <td class="text-center"><span style="color: white;">.</span>
                    <?php if ($datdet['data_ok'] == 0) { ?>
                      <a href="<?= base_url() . 'out/dataout/' . $datdet['id'] ?>" class='btn btn-sm btn-primary <?= cekclosebook(); ?>' style='padding: 3px 5px !important;' title='Lanjutkan Transaksi'><i class='fa fa-edit mr-1'></i> Lanjutkan Transaksi</a>
                      <a href="#" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini <br> <?= $datdet['nomor_dok']; ?>" data-href="<?= base_url() . 'out/hapusdataout/' . $datdet['id']; ?>" class='btn btn-sm btn-danger <?= cekclosebook(); ?>' style='padding: 3px 5px !important;' title='Hapus Transaksi'><i class='fa fa-trash-o mr-1'></i> Hapus</a>
                    <?php } else if ($datdet['data_ok'] == 1) { ?>
                      <a href="<?= base_url() . 'out/cetakbon/' . $datdet['id'] ?>" target='_blank' class='btn btn-sm btn-danger' title='Cetak Data'><i class='fa fa-file-pdf-o'></i></a>
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