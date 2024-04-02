<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Edit User Manajemen
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'userapps' ?>" class="btn btn-warning btn-sm text-black"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body font-kecil">
        <form method="POST" action="<?= $action; ?>" id="formtambahuser" name="formtambahuser">
          <div class="row">
            <div class="col-sm-6">
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil hilang" name="id" id="id" placeholder="Nama" value="<?= $user['id']; ?>">
                  <input type="text" class="form-control font-kecil" name="name" id="name" placeholder="Nama" value="<?= $user['name']; ?>">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Bagian</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="bagian" id="bagian" placeholder="Bagian" value="<?= $user['bagian']; ?>" style="text-transform:uppercase">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Departemen </label>
                <div class="col">
                <select name="id_dept" id="id_dept" class="form-control">
                    <option value="">Departemen</option>
                    <?php foreach ($dept as $dep) : ?>
                        <?php if ($dep['dept_id'] == $user['id_dept']) : ?>
                        <option value="<?= $dep['dept_id']; ?>" selected><?= $dep['departemen']; ?></option>
                        <?php else : ?>
                        <option value="<?= $dep['dept_id']; ?>"><?= $dep['departemen']; ?></option>
                        <?php endif; ?>
                    <?php endforeach; ?>
                 </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">jabatan</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="jabatan" id="jabatan" placeholder="jabatan" value="<?= $user['jabatan']; ?>">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Level User </label>
                <div class="col">
                  <select name="id_level_user" id="id_level_user" class="form-control">
                    <option value="Select Menu">Level User</option>
                    <?php foreach ($level as $a) : ?>
                      <option value="<?= $a['id']; ?>" <?= ($user['id_level_user'] == $a['id']) ? 'selected' : ''; ?>>
                        <?= $a['level']; ?>
                      </option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Email</label>
                <div class="col">
                  <input type="email" class="form-control font-kecil" name="email" id="email" placeholder="Enter email" value="<?= $user['email']; ?>">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Username</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="username" id="username" placeholder="Username" value="<?= $user['username']; ?>">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Password</label>
                <div class="col">
                  <input type="password" class="form-control font-kecil" name="password" id="password" placeholder="Password" value="<?= decrypto($user['password']); ?>">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row">
                      <span class="col">Aktif</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <?php $stsaktif = $user['aktif'] == 1 ? 'checked' : ''; ?>
                          <input class="form-check-input" name="aktif" id="aktif" type="checkbox" <?= $stsaktif; ?>>
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="hr mt-2 mb-1"></div>
              <div class="card-body pt-2">
                <div class="row">
                  <div class="col"><a href="<?= base_url() . 'userapps/editdata/' . $user['id']; ?>" class="btn btn-danger btn-sm w-100">
                      <i class="fa fa-refresh mr-1"></i>
                      Reset
                    </a></div>
                  <div class="col"><a class="btn btn-primary btn-sm w-100 text-white" id="edituser">
                      <i class="fa fa-save mr-1"></i>
                      Update
                    </a></div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <h4>Akses Modul</h4>
              <div class="row row-cards">
                <div class="col">
                  <div class="card">
                    <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                        <li class="nav-item">
                          <a href="#tabs-home-1" class="nav-link active" data-bs-toggle="tab">Master Data</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-transaksi-1" class="nav-link" data-bs-toggle="tab">Transaksi</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-profile-1" class="nav-link" data-bs-toggle="tab">User Manajemen</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-departemen-1" class="nav-link" data-bs-toggle="tab">Hak Departemen</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="tab-pane active show" id="tabs-home-1">
                          <div class="row">
                            <div class="col-6">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master1" name="master1" type="checkbox" <?= cekceklis($user['master'], 1); ?>>
                                <span class="form-check-label">Satuan</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master2" name="master2" type="checkbox" <?= cekceklis($user['master'], 2); ?>>
                                <span class="form-check-label">Kategori Barang</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master3" name="master3" type="checkbox" <?= cekceklis($user['master'], 3); ?>>
                                <span class="form-check-label">Barang</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master4" name="master4" type="checkbox" <?= cekceklis($user['master'], 4); ?>>
                                <span class="form-check-label">Supplier</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master5" name="master5" type="checkbox" <?= cekceklis($user['master'], 5); ?>>
                                <span class="form-check-label">Customer</span>
                              </label>
                            </div>
                            <div class="col-6">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master6" name="master6" type="checkbox" <?= cekceklis($user['master'], 6); ?>>
                                <span class="form-check-label">Nettype</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master7" name="master7" type="checkbox" <?= cekceklis($user['master'], 7); ?>>
                                <span class="form-check-label">Departemen</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master8" name="master8" type="checkbox" <?= cekceklis($user['master'], 8); ?>>
                                <span class="form-check-label">Referensi Dokumen</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master9" name="master9" type="checkbox" <?= cekceklis($user['master'], 9); ?>>
                                <span class="form-check-label">Kategori Departemen</span>
                              </label>
                              <!-- xx -->
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane " id="tabs-transaksi-1">
                          <div class="row">
                            <div class="col">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi1" name="transaksi1" type="checkbox" <?= cekceklis($user['transaksi'], 1); ?>>
                                <span class="form-check-label">PB (BON PERMINTAAN BARANG)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi2" name="transaksi2" type="checkbox" <?= cekceklis($user['transaksi'], 2); ?>>
                                <span class="form-check-label">BBL (BON PEMBELIAN BARANG)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi3" name="transaksi3" type="checkbox" <?= cekceklis($user['transaksi'], 3); ?>>
                                <span class="form-check-label">ADJ (BON ADJUSTMEN)</span>
                              </label>
                              <!-- xx -->
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane" id="tabs-profile-1">
                          <div class="row">
                            <!-- <label class="col-3 col-form-label pt-0">Checkboxes</label> -->
                            <div class="col">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="manajemen1" name="manajemen1" type="checkbox" <?= cekceklis($user['manajemen'], 1); ?>>
                                <span class="form-check-label">User Manajemen</span>
                              </label>
                            </div>
                          </div>
                        </div>
                        <div class="tab-pane" id="tabs-departemen-1">
                          <div class="row">
                            <div class="col-6">
                              <?php $no = 0;
                              $jml = $jmldept;
                              foreach ($daftardept as $dept) : $no++; ?>
                                <label class="form-check mb-1">
                                  <input class="form-check-input" id="<?= $dept['dept_id']; ?>" name="<?= $dept['dept_id']; ?>" type="checkbox" <?= cekceklisdep($user['hakdepartemen'], $dept['dept_id']); ?>>
                                  <span class="form-check-label"><?= $dept['departemen']; ?></span>
                                </label>
                              <?php endforeach; ?>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>