<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Tambah User Manajemen
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
            <div class="col-sm-5">
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="name" id="name" placeholder="Nama">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Bagian</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="bagian" id="bagian" placeholder="Bagian" style="text-transform:uppercase">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Departemen</label>
                <div class="col">
                  <select name="id_dept" id="id_dept" class="form-control form-select">
                    <option value="Select Menu">Departemen</option>
                    <?php foreach ($dept as $dep) : ?>
                      <option value="<?= $dep['dept_id']; ?>"><?= $dep['departemen']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jabatan</label>
                <div class="col">
                  <!-- <input type="text" class="form-control font-kecil" name="jabatan" id="jabatan" placeholder="jabatan"> -->
                  <select name="jabatan" id="jabatan" class="form-control form-select">
                    <option value="">Jabatan</option>
                    <?php foreach ($jabat as $jbt) : ?>
                      <option value="<?= $jbt['nama_jabatan']; ?>"><?= $jbt['nama_jabatan']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Level User</label>
                <div class="col">
                  <select name="id_level_user" id="id_level_user" class="form-control form-select">
                    <option value="Select Menu">Level User</option>
                    <?php foreach ($level as $a) : ?>
                      <option value="<?= $a['id']; ?>"><?= $a['level']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Email</label>
                <div class="col">
                  <input type="email" class="form-control font-kecil" name="email" id="email" placeholder="Enter email">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Username</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="username" id="username" placeholder="Username">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Password</label>
                <div class="col">
                  <input type="password" class="form-control font-kecil" name="password" id="password" placeholder="Password">
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
                          <input class="form-check-input" name="aktif" id="aktif" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-1 row bg-teal-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row">
                      <span class="col font-bold">View Harga</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="view_harga" id="view_harga" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row">
                      <span class="col">Validator ADJ</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekadj" id="cekadj" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-1 row bg-teal-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row">
                      <span class="col">Validator Purchase Order</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekpo" id="cekpo" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row">
                      <span class="col">GM Purchasing</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekpc" id="cekpc" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-1 row bg-teal-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row">
                      <span class="col">Validasi BBL Produksi</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekpp" id="cekpp" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row">
                      <span class="col">Validasi BBL Sparepart Mesin</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekut" id="cekut" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-1 row bg-teal-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row">
                      <span class="col">Batalkan Verifikasi Stock</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekbatalstok" id="cekbatalstok" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="hr mt-2 mb-1"></div>
              <div class="card-body pt-2">
                <div class="row">
                  <div class="col"><a href="./tambahdata" class="btn btn-danger btn-sm w-100">
                      <i class="fa fa-refresh mr-1"></i>
                      Reset
                    </a></div>
                  <div class="col"><a class="btn btn-primary btn-sm w-100 text-white" id="tambahuser">
                      <i class="fa fa-save mr-1"></i>
                      Simpan
                    </a></div>
                </div>
              </div>
            </div>
            <div class="col-sm-7">
              <h4>Akses Modul</h4>
              <div class="row row-cards">
                <div class="col">
                  <div class="card">
                    <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                        <li class="nav-item">
                          <a href="#tabs-departemen-1" class="nav-link active" data-bs-toggle="tab">Hak Departemen</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-home-1" class="nav-link" data-bs-toggle="tab">Master Data</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-transaksi-1" class="nav-link" data-bs-toggle="tab">Transaksi</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-other-1" class="nav-link" data-bs-toggle="tab">Report</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-profile-1" class="nav-link" data-bs-toggle="tab">User Manajemen</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-ceklispb" class="nav-link" data-bs-toggle="tab">Validasi PB</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-ceklisbbl" class="nav-link" data-bs-toggle="tab">Validasi BBL</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="tab-pane" id="tabs-home-1">
                          <div class="row">
                            <div class="col-6">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master1" name="master1" type="checkbox">
                                <span class="form-check-label">Satuan</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master2" name="master2" type="checkbox">
                                <span class="form-check-label">Kategori Barang</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master3" name="master3" type="checkbox">
                                <span class="form-check-label">Barang</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master13" name="master13" type="checkbox">
                                <span class="form-check-label text-cyan">Input Safety Stok</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master4" name="master4" type="checkbox">
                                <span class="form-check-label">Supplier</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master5" name="master5" type="checkbox">
                                <span class="form-check-label">Customer</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master6" name="master6" type="checkbox">
                                <span class="form-check-label">Nettype</span>
                              </label>
                            </div>
                            <div class="col-6">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master7" name="master7" type="checkbox">
                                <span class="form-check-label">Departemen</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master8" name="master8" type="checkbox">
                                <span class="form-check-label">Referensi Dokumen</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master9" name="master9" type="checkbox">
                                <span class="form-check-label">Kategori Departemen</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master10" name="master10" type="checkbox">
                                <span class="form-check-label">Personil</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master11" name="master11" type="checkbox">
                                <span class="form-check-label">Data Jabatan</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master12" name="master12" type="checkbox">
                                <span class="form-check-label">Data Grup</span>
                              </label>
                              <!-- xx -->
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane " id="tabs-transaksi-1">
                          <div class="row">
                            <div class="col-6">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi1" name="transaksi1" type="checkbox">
                                <span class="form-check-label">PB (BON PERMINTAAN BARANG)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi2" name="transaksi2" type="checkbox">
                                <span class="form-check-label">BBL (BON PEMBELIAN BARANG)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi3" name="transaksi3" type="checkbox">
                                <span class="form-check-label">IN (BON PENERIMAAN BARANG)</span>
                              </label>
                            </div>
                            <div class="col-6">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi4" name="transaksi4" type="checkbox">
                                <span class="form-check-label">OUT (BON PENGELUARAN BARANG)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi5" name="transaksi5" type="checkbox">
                                <span class="form-check-label">ADJ (BON ADJUSTMEN)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi6" name="transaksi6" type="checkbox">
                                <span class="form-check-label">PO (PURCHASE ORDER)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi7" name="transaksi7" type="checkbox">
                                <span class="form-check-label">IB (PENERIMAAN BARANG)</span>
                              </label>
                              <!-- xx -->
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane " id="tabs-other-1">
                          <div class="row">
                            <div class="col-6">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other1" name="other1" type="checkbox">
                                <span class="form-check-label">Ponet</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other2" name="other2" type="checkbox">
                                <span class="form-check-label">Inventory</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other3" name="other3" type="checkbox">
                                <span class="form-check-label">Inventory Mesin</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other4" name="other4" type="checkbox">
                                <span class="form-check-label">BC Masuk</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other5" name="other5" type="checkbox">
                                <span class="form-check-label">BC Keluar</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other7" name="other7" type="checkbox">
                                <span class="form-check-label">Akses CCTV</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other6" name="other6" type="checkbox">
                                <span class="form-check-label">Log Activity</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other8" name="other8" type="checkbox">
                                <span class="form-check-label">Harga Material</span>
                              </label>
                            </div>
                            <div class="col-6">
                              <!-- xx -->
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane" id="tabs-profile-1">
                          <div class="row">
                            <!-- <label class="col-3 col-form-label pt-0">Checkboxes</label> -->
                            <div class="col">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="manajemen1" name="manajemen1" type="checkbox">
                                <span class="form-check-label">User Manajemen</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="manajemen2" name="manajemen2" type="checkbox">
                                <span class="form-check-label">Close Book inventory</span>
                              </label>
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane active show" id="tabs-departemen-1">
                          <div class="row">
                            <div class="col-6">
                              <?php $no = 0;
                              $jml = $jmldept;
                              foreach ($daftardept as $dept) : $no++; ?>
                                <label class="form-check mb-1">
                                  <input class="form-check-input" id="<?= $dept['dept_id']; ?>" name="<?= $dept['dept_id']; ?>" type="checkbox">
                                  <span class="form-check-label"><?= $dept['departemen']; ?></span>
                                </label>
                              <?php endforeach; ?>
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane" id="tabs-ceklispb">
                          <div class="row">
                            <div class="col-6">
                              <?php $no = 0;
                              $jml = $jmldept;
                              foreach ($deptpb as $dept) : $no++; ?>
                                <label class="form-check mb-1">
                                  <input class="form-check-input" id="<?= 'X'.$dept['dept_id']; ?>" name="<?= 'X'.$dept['dept_id']; ?>" type="checkbox">
                                  <span class="form-check-label"><?= $dept['departemen']; ?></span>
                                </label>
                              <?php endforeach; ?>
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane" id="tabs-ceklisbbl">
                          <div class="row">
                            <div class="col-6">
                             <label class="form-check">
                                <input class="form-check-input" type="radio" 
          name="ttd" value="0" >
                                <span class="form-check-label">NO TTD</span>
                              </label>
                              <label class="form-check">
                                <input class="form-check-input" type="radio" 
          name="ttd" value="1" >
                                <span class="form-check-label">MANAGER PPIC (Mengetahui)</span>
                              </label>
                              <label class="form-check">
                                <input class="form-check-input" type="radio" 
          name="ttd" value="2" >
                                <span class="form-check-label">MANAGER PRODUKSI / NON (APPROVER)</span>
                              </label>
                              <label class="form-check">
                                <input class="form-check-input" type="radio" 
          name="ttd" value="3" >
                                <span class="form-check-label">GM PRODUKSI / NON (RELEASER)</span>
                              </label>
                              <!-- <label class="form-check">
                                <input class="form-check-input" type="radio" 
          name="ttd" value="4">
                                <span class="form-check-label">MANAGER PURCHASING</span>
                              </label> -->
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