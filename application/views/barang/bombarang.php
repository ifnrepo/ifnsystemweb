<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Bill Of Material Barang
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url().'barang'; ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="sisipkan" class="hilang">
          <div class="mb-1">
            <a href="<?= base_url().'barang/addbombarang/'.$detail['id'] ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Data BOM" class="btn btn-primary btn-sm" ><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
          </div>
          <div class="card card-active" style="clear:both;" >
            <div class="card-body p-2">
              <div class="row">
                <div class="col-3">
                  <h4 class="mb-1">Nama Barang</h4>
                  <span class="font-kecil"><?= $detail['nama_barang']; ?></span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1">Kode Barang</h4>
                  <span class="font-kecil"><?= $detail['kode']; ?></span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1">Total Persen BOM</h4>
                  <span class="font-kecil"><?= $detail['persenbom']; ?></span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1"></h4>
                </div>
              </div>
            </div>
          </div>
          
        </div>
        <div id="table-default" class="table-responsive">
          <table class="table datatabledengandiv" id="cobasisip">
            <thead>
              <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Persen</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" style="font-size: 13px !important;" >
              <?php $no=0; foreach ($data->result_array() as $key): $no++; ?>
                <tr>
                  <td><?= $no; ?></td>
                  <td><?= $key['kode']; ?></td>
                  <td><?= $key['nama_barang']; ?></td>
                  <td><?= $key['persen']; ?></td>
                  <td>
                    <a href="<?= base_url().'barang/editbombarang/'.$key['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="editsatuan" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Data BOM" rel="<?= $key['id']; ?>" title="Edit data">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusbarang" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url().'barang/hapusbombarang/'.$key['id'].'/'.$detail['id']; ?>" title="Hapus data">
                      <i class="fa fa-trash-o"></i>
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
        