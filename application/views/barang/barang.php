<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Master Data Barang
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url().'barang/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Barang"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="table-default" class="table-responsive">
          <table class="table datatable">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>DLN</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" style="font-size: 13px !important;" >
              <?php $no=0; foreach ($data->result_array() as $key): $no++; ?>
                <tr>
                  <td><?= $no; ?></td>
                  <td><?= $key['kode']; ?></td>
                  <td><?= $key['nama_barang']; ?></td>
                  <td><?= $key['nama_kategori']; ?></td>
                  <td><?= $key['namasatuan']; ?></td>
                  <td class="text-success"><?php if($key['dln']==1){ echo '<i class="fa fa-check"></i>'; } ?></td>
                  <td>
                    <a href="<?= base_url().'barang/editbarang/'.$key['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="editsatuan" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Edit Data Satuan" rel="<?= $key['id']; ?>" title="Edit data">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusbarang" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url().'barang/hapusbarang/'.$key['id']; ?>" title="Hapus data">
                      <i class="fa fa-trash-o"></i>
                    </a>
                    <a href="<?= base_url().'barang/bombarang/'.$key['id']; ?>" class="btn btn-sm btn-cyan btn-icon text-white position-relative" style="padding: 3px 8px !important;" title="Add Bill Of Material">
                      BOM
                      <?php if($key['jmbom'] > 0){ ?>
                        <span class="badge bg-pink text-blue-fg badge-notification badge-pill">!</span>
                      <?php } ?>
                    </a>
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
        