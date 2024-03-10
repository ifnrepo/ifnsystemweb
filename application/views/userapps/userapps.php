<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          User Manajemen
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'userapps/tambahdata'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
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
                <th>Nama</th>
                <th>Username</th>
                <th>Password</th>
                <th>Level User</th>
                <th>Input On</th>
                <th>Active</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" style="font-size: 13px !important;">
              <?php foreach ($data as $key) : ?>
                <tr>
                  <td><?= $key['name']; ?></td>
                  <td><?= $key['username']; ?></td>
                  <td><?= visibpass(decrypto($key['password'])); ?></td>
                  <td><?= $key['level']; ?></td>
                  <td><?= $key['inputon']; ?></td>
                  <td><span class="badge <?= ($key['aktif'] == 1) ? 'bg-green' : 'bg-red'; ?> ms-auto"></span></td>
                  <td>
                    <a href="<?= base_url() . 'userapps/editdata/' . $key['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="edituser" rel="<?= $key['id']; ?>" title="Edit data">
                      <i class="fa fa-edit"></i>
                    </a>
                    <a class="btn btn-sm btn-danger btn-icon text-white" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'userapps/hapusdata/' . $key['id']; ?>" title="Hapus data">
                      <i class="fa fa-trash-o"></i>
                    </a>
                    <a href="<?= base_url() . 'userapps/viewuser/' . $key['id']; ?>" class="btn btn-sm btn-teal btn-icon" id="edituser" rel="<?= $key['id']; ?>" title="View data" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="View User">
                      <i class="fa fa-eye"></i>
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