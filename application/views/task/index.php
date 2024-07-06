<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Pending Task
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
        <div class="card-header">
          <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
            <li class="nav-item">
              <a href="#tabs-pb" class="nav-link <?php if($this->session->flashdata('tabdef')==''){ echo "active"; } ?>" data-bs-toggle="tab">PB (Permintaan Barang)</a>
            </li>
            <li class="nav-item disabled">
              <a href="#tabs-bbl" class="nav-link <?php if($this->session->flashdata('tabdef')=='bbl'){ echo "active"; } ?>" data-bs-toggle="tab">BBL (Bon Pembelian Barang)</a>
            </li>
          </ul>
        </div>
        <div class="card-body">
          <div class="tab-content">
            <div class="tab-pane active show" id="tabs-pb">
              <table id="tabel" class="table nowrap order-column table-hover datatable7" style="width: 100% !important;">
                <thead>
                  <tr>
                    <th>Tgl</th>
                    <th>Nomor Bon Permintaan</th>
                    <th>Keterangan</th>
                    <th>Dibuat Oleh</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                  <?php foreach ($datapb->result_array() as $datpb) { ?>
                    <tr>
                      <td><?= tglmysql($datpb['tgl']); ?></td>
                      <td><?= $datpb['nomor_dok']; ?></td>
                      <td><?= $datpb['keterangan']; ?></td>
                      <td style="line-height: 13px;"><?= datauser($datpb['user_ok'],'name'); ?><br><span style="font-size: 10px;"><?= $datpb['tgl_ok'] ?></span></td>
                      <td class="text-center">
                        <a href="#" style="padding: 5px !important" data-bs-target="#modal-pilihan" 
                        data-message="Anda yakin akan validasi bon <br><?= $datpb['nomor_dok']; ?> ?" 
                        data-href="<?= base_url().'task/validasipb/'.$datpb['id']; ?>"
                        data-hrefno="<?= base_url().'task/cancelpb/'.$datpb['id']; ?>"
                        data-tabdef="tabs-pb"
                        data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-info">Validasi</a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
                </table>
            </div>
            <div class="tab-pane active show" id="tabs-bbl">
              <table id="tabel" class="table nowrap order-column table-hover datatable7" style="width: 100% !important;">
                <thead>
                  <tr>
                    <th>Tgl</th>
                    <th>Nomor Bon Pembelian</th>
                    <th>Keterangan</th>
                    <th>Dibuat Oleh</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                  <?php foreach ($datapb->result_array() as $datpb) { ?>
                    <tr>
                      <td><?= tglmysql($datpb['tgl']); ?></td>
                      <td><?= $datpb['nomor_dok']; ?></td>
                      <td><?= $datpb['keterangan']; ?></td>
                      <td style="line-height: 13px;"><?= datauser($datpb['user_ok'],'name'); ?><br><span style="font-size: 10px;"><?= $datpb['tgl_ok'] ?></span></td>
                      <td class="text-center">
                        <a href="#" style="padding: 5px !important" data-bs-target="#modal-pilihan" 
                        data-message="Anda yakin akan validasi bon <br><?= $datpb['nomor_dok']; ?> ?" 
                        data-href="<?= base_url().'task/validasipb/'.$datpb['id'].'/bbl'; ?>"
                        data-hrefno="<?= base_url().'task/cancelpb/'.$datpb['id'].'/bbl'; ?>"
                        data-tabdef="tabs-bbl"
                        data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-info">Validasi</a>
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
  </div>
</div>
        