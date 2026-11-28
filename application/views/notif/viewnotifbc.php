<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Dokumen BC Expired
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">

      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div class="sticky-top bg-white mb-2">
          <div class="row mb-1 d-flex align-items-between">
            <div class="col-sm-6">
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
                <div class="ex mt-1" style="margin-right: 5px;">
                    <a href="<?= base_url() . 'kontrak/excel_kontrak_expired'; ?>" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export To Excel</span></a>
                </div>
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row g-1">
                <div class="col-3">
                  <h4 class="mb-1 font-kecil">Nama Rekanan</h4>
                  <div class="input-group">
                    <select class="form-select form-control form-sm font-kecil font-bold" id="deptkontrak" name="deptkontrak">
                        <option value="">Semua Rekanan</option>
                        <?php foreach($deprekanan as $rekan): ?>
                            <option value="<?= $rekan['id_supplier'] ?>" <?php if($this->session->userdata('deptnotif')==$rekan['id_supplier']) { echo "selected"; } ?>><?= $rekan['nama_supplier'] ?></option>
                        <?php endforeach; ?>
                    </select>
                    <a href="#" class="btn btn-sm btn-primary ml-1" style="height: 38px;min-width:45px;" id="butgoview">Go</a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div>
          <table id="pbtabel" class="table order-column mt-1 table-hover table-bordered" style="width: 100% !important;">
            <thead>
              <tr>
                <th>#</th>
                <th>Nomor</th>
                <th>BC</th>
                <th>Proses</th>
                <th class="line-11">Tgl<br>Berakhir</th>
                <th>Pcs</th>
                <th>Kgs</th>
                <th>Realisasi</th>
                <th>Pengembalian</th>
                <th>Saldo</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                <?php $no=1; foreach($monitoringjaminan->result_array() as $mon): ?>
                <?php $warnahuruf = (getrealisasikontrak($mon['id'])-getpengembalianbc($mon['id'])) < 0 ? 'text-red' : '';  ?>
                    <tr class="font-kecil">
                        <td class="text-center"><?= $no++; ?></td>
                        <td class="line-11"><span class="text-primary"><?= $mon['nomor'] ?></span><br><?= $mon['nama_supplier'] ?></td>
                        <td class="text-center"><?= $mon['jns_bc'] ?></td>
                        <td><?= $mon['proses'] ?></td>
                        <td><?= tglmysql($mon['tgl_akhir']) ?></td>
                        <td class="text-end"><?= rupiah($mon['pcs'],0) ?></td>
                        <td class="text-end"><?= rupiah($mon['kgs'],2) ?></td>
                        <td class="text-end"><?= rupiah(getrealisasikontrak($mon['id']),2) ?></td>
                        <td class="text-end"><?= rupiah(getpengembalianbc($mon['id']),2) ?></td>
                        <td class="text-end"><a href="<?= base_url() . 'kontrak/viewdetail/' . $mon['id'] ?>" class="<?= $warnahuruf ?>" title="View detail" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail Realisasi dan Pengembalian"><?= rupiah(getrealisasikontrak($mon['id'])-getpengembalianbc($mon['id']),2) ?></a></td>
                        <td class="text-center text-nowrap">
                            <a href="<?= base_url('kontrak/view/') . $mon['id']; ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail Kontrak" title="View Detail Kontrak" style="padding: 3px 5px !important;" class="btn btn-sm btn-success btn-icon p-0">View</a>
                            <?php if(datauser($this->session->userdata('id'),'tutup_kontrak')==1){ ?>
                                <a href="<?= base_url() . 'kontrak/tutupkontrakorperpanjang/' . $mon['id'] ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Tutup Kontrak" style="padding: 3px 5px !important;" class="btn btn-sm btn-danger btn-icon p-0">Tutup</a>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>