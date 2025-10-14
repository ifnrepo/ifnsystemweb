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
                      <option value="<?= $jbt['nama_jabatan']; ?>"><?= $jbt['nojab'] . ' # ' . $jbt['nama_jabatan']; ?></option>
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
                <label class="col-3 col-form-label required">Telp/Wa</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="telp" id="telp" placeholder="Telp/Wa">
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
              <div class="row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="User Aktif/Tidak">
                      <span class="col font-bold">User Aktif</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="aktif" id="aktif" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="Hak View Harga terakhir Pembelian">
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
              <div class="row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="Hak Validasi Adjustment">
                      <span class="col font-bold">Validator ADJ</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekadj" id="cekadj" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="Validasi PO">
                      <span class="col font-bold">Validator Purchase Order (PO)</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekpo" id="cekpo" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="Verifikasi BON BBL">
                      <span class="col font-bold">GM Purchasing</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekpc" id="cekpc" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="Hak Membatalkan Verifikasi Stock di Modul Inventory">
                      <span class="col font-bold">Batalkan Verifikasi Stock</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekbatalstok" id="cekbatalstok" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="Menentukan Dokumen Masuk/Keluar Harus Memakai Dokumen BC Atau Tidak">
                      <span class="col font-bold">Konfirmasi Hanggar</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekpakaibc" id="cekpakaibc" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="Kunci dan Edit Data Project RND">
                      <span class="col font-bold">Close/Open Project RD</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekrd" id="cekrd" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-1 row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="Kunci dan Edit Data Project Downtime">
                      <span class="col font-bold">Close/Open Downtime Mesin</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekdowntime" id="cekdowntime" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-1 row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="Master Data Project Environmental">
                      <span class="col font-bold">Master Environmental</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="cekenv" id="cekenv" type="checkbox">
                        </label>
                      </span>
                    </label>
                  </div>
                </div>
              </div>
              <div class="mb-1 row bg-primary-lt">
                <label class="col-3 col-form-label"></label>
                <div class="col mt-2">
                  <div class="col-11">
                    <label class="row" title="Verifikasi Environmental">
                      <span class="col font-bold">Hak Verifikasi Environmental</span>
                      <span class="col-auto">
                        <label class="form-check form-check-single form-switch">
                          <input class="form-check-input" name="hakveri_env" id="hakveri_env" type="checkbox">
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
                      <ul class="nav nav-tabs card-header-tabs" id="headerhakuser" data-bs-toggle="tabs">
                        <li class="nav-item">
                          <a href="#tabs-hakprogram-1" class="nav-link active text-blue mb-1" data-bs-toggle="tab">Hak Program</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-departemen-1" class="nav-link  text-blue " data-bs-toggle="tab">Hak Departemen</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-home-1" class="nav-link text-blue" data-bs-toggle="tab">Master Data</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-transaksi-1" class="nav-link text-blue" data-bs-toggle="tab">Transaksi</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-other-1" class="nav-link text-blue" data-bs-toggle="tab">Report</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-rfid-1" class="nav-link text-blue" data-bs-toggle="tab">RFID</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-profile-1" class="nav-link text-blue" data-bs-toggle="tab">User Manajemen</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-setting-1" class="nav-link text-blue" data-bs-toggle="tab">Setting</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-ceklispb" class="nav-link text-blue" data-bs-toggle="tab">Validasi PB</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-ceklisbbl" class="nav-link text-blue mb-1" data-bs-toggle="tab">Validasi BBL</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-hakdowntime-1" class="nav-link text-blue mb-1" data-bs-toggle="tab">Hak Downtime</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="tab-pane active show" id="tabs-hakprogram-1">
                          <div class="row">
                            <div class="col-6">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakprogram1" name="hakprogram1" type="checkbox">
                                <span class="form-check-label">Ifn System Web</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakprogram2" name="hakprogram2" type="checkbox">
                                <span class="form-check-label">Surat Hrd</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakprogram3" name="hakprogram3" type="checkbox">
                                <span class="form-check-label">Environmental</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakprogram4" name="hakprogram4" type="checkbox">
                                <span class="form-check-label">Laboratorium</span>
                              </label>
                              <label class="row" title="Hak View Event" id="cekeventrahasia">
                                <span class="col-auto">
                                  <label class="form-check form-check-single form-switch">
                                    <input class="form-check-input" name="hakeventrahasia" id="hakeventrahasia" type="checkbox">
                                  </label>
                                </span>
                                <span class="col font-bold ml-4">View Rahasia</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakprogram5" name="hakprogram5" type="checkbox">
                                <span class="form-check-label">Downtime Mesin</span>
                              </label>

                            </div>
                          </div>
                        </div>

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
                            </div>
                            <div class="col-6">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master12" name="master12" type="checkbox">
                                <span class="form-check-label">Data Grup</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master14" name="master14" type="checkbox">
                                <span class="form-check-label">Harga cost division</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master15" name="master15" type="checkbox">
                                <span class="form-check-label">Setting cost division</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master16" name="master16" type="checkbox">
                                <span class="form-check-label">Proses Borongan</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master17" name="master17" type="checkbox">
                                <span class="form-check-label">Data Mesin</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master18" name="master18" type="checkbox">
                                <span class="form-check-label">Data Agama Personil</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master19" name="master19" type="checkbox">
                                <span class="form-check-label">Data Pendidikan Personil</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master20" name="master20" type="checkbox">
                                <span class="form-check-label">Data Status Personil</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master21" name="master21" type="checkbox">
                                <span class="form-check-label">Kelompok PO</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master22" name="master22" type="checkbox">
                                <span class="form-check-label">Data Ket Proses</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master23" name="master23" type="checkbox">
                                <span class="form-check-label">Data Rekanan</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master24" name="master24" type="checkbox">
                                <span class="form-check-label">Bill Of Material</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="master25" name="master25" type="checkbox">
                                <span class="form-check-label">Bill Of Material Cost</span>
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
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi4" name="transaksi4" type="checkbox">
                                <span class="form-check-label">OUT (BON PENGELUARAN BARANG)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi5" name="transaksi5" type="checkbox">
                                <span class="form-check-label">ADJ (BON ADJUSTMEN)</span>
                              </label>
                            </div>
                            <div class="col-6">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi6" name="transaksi6" type="checkbox">
                                <span class="form-check-label">PO (PURCHASE ORDER)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi7" name="transaksi7" type="checkbox">
                                <span class="form-check-label">AMB (AJU MASUK BARANG)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi8" name="transaksi8" type="checkbox">
                                <span class="form-check-label">AKB (AJU KELUAR BARANG)</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi9" name="transaksi9" type="checkbox">
                                <span class="form-check-label">Kontrak</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="transaksi10" name="transaksi10" type="checkbox">
                                <span class="form-check-label">BENANG (INVENTORY)</span>
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
                                <input class="form-check-input" id="other8" name="other8" type="checkbox">
                                <span class="form-check-label">Harga Material</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other9" name="other9" type="checkbox">
                                <span class="form-check-label">Pricing Inventory</span>
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
                                <input class="form-check-input" id="other10" name="other10" type="checkbox">
                                <span class="form-check-label">Material</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other11" name="other11" type="checkbox">
                                <span class="form-check-label">WIP</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other12" name="other12" type="checkbox">
                                <span class="form-check-label">Finished Goods</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other3" name="other3" type="checkbox">
                                <span class="form-check-label">Barang Modal</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other13" name="other13" type="checkbox">
                                <span class="form-check-label">Scrap / Waste</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other14" name="other14" type="checkbox">
                                <span class="form-check-label">Sparepart</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other7" name="other7" type="checkbox">
                                <span class="form-check-label">Akses CCTV</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="other6" name="other6" type="checkbox">
                                <span class="form-check-label">Log Activity</span>
                              </label>


                            </div>
                            <div class="col-6">
                              <!-- xx -->
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane" id="tabs-rfid-1">
                          <div class="row">
                            <!-- <label class="col-3 col-form-label pt-0">Checkboxes</label> -->
                            <div class="col">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="rfid1" name="rfid1" type="checkbox">
                                <span class="form-check-label">Finishing OUT</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="rfid2" name="rfid2" type="checkbox">
                                <span class="form-check-label">Finished Goods IN</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="rfid3" name="rfid3" type="checkbox">
                                <span class="form-check-label">Container IN</span>
                              </label>
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

                        <div class="tab-pane" id="tabs-setting-1">
                          <div class="row">
                            <!-- <label class="col-3 col-form-label pt-0">Checkboxes</label> -->
                            <div class="col">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="setting1" name="setting1" type="checkbox">
                                <span class="form-check-label">Footer</span>
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
                                  <input class="form-check-input" id="<?= 'X' . $dept['dept_id']; ?>" name="<?= 'X' . $dept['dept_id']; ?>" type="checkbox">
                                  <span class="form-check-label"><?= $dept['departemen']; ?></span>
                                </label>
                              <?php endforeach; ?>
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane" id="tabs-ceklisbbl">
                          <div class="row">
                            <div class="col">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="cekbbl" name="cekbbl" type="checkbox">
                                <span class="form-check-label font-bold">VALIDASI BBL (Kepala Departemen/Pembuat) - Maker 01</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="cekpp" name="cekpp" type="checkbox">
                                <span class="form-check-label font-bold">VALIDASI BBL Produksi (Manager PPIC/Mengetahui) - Maker 02</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="cekut" name="cekut" type="checkbox">
                                <span class="form-check-label font-bold">VALIDASI BBL Sparepart Mesin (Manager UTILITY/Mengetahui) - Maker 02</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="cekmng" name="cekmng" type="checkbox">
                                <span class="form-check-label font-bold">VALIDASI BBL (Manager Departemen/Menyetujui) - Approver</span>
                              </label>
                              <div class="p-2 hilang mb-1" id="inicekmng" style="border: 1px dotted gray;">
                                <div class="row">
                                  <div class="col-4">
                                    <?php $no = 0;
                                    $nox = 0;
                                    $jml = $jmldept;
                                    foreach ($daftardept as $dept) : $no++;
                                      $nox++; ?>
                                      <?php if ($no % 13 == 0) {
                                        $no++; ?>
                                  </div>
                                  <div class="col-4">
                                  <?php } ?>
                                  <label class="form-check mb-1">
                                    <input class="form-check-input" id="cekmng<?= $dept['dept_id']; ?>" name="cekmng<?= $dept['dept_id']; ?>" type="checkbox">
                                    <span class="form-check-label"><?= substr($dept['departemen'], 0, 20); ?></span>
                                  </label>
                                <?php endforeach; ?>
                                  </div>
                                </div>
                              </div>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="ceksgm" name="ceksgm" type="checkbox">
                                <span class="form-check-label font-bold mb-2">VALIDASI BBL (Manager Departemen/Menerima) - Releaser</span>
                              </label>
                              <div class="p-2 hilang mb-1" id="iniceksgm" style="border: 1px dotted gray;">
                                <div class="row">
                                  <div class="col-4">
                                    <?php $no = 0;
                                    $nox = 0;
                                    $jml = $jmldept;
                                    foreach ($daftardept as $dept) : $no++;
                                      $nox++; ?>
                                      <?php if ($no % 13 == 0) {
                                        $no++; ?>
                                  </div>
                                  <div class="col-4">
                                  <?php } ?>
                                  <label class="form-check mb-1">
                                    <input class="form-check-input" id="ceksgm<?= $dept['dept_id']; ?>" name="ceksgm<?= $dept['dept_id']; ?>" type="checkbox">
                                    <span class="form-check-label"><?= substr($dept['departemen'], 0, 20); ?></span>
                                  </label>
                                <?php endforeach; ?>
                                  </div>
                                </div>
                              </div>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="cekpc" name="cekpc" type="checkbox">
                                <span class="form-check-label font-bold">VALIDASI BBL (Manager Purchasing/Menyetujui) - Executor</span>
                            </div>
                            </label>
                          </div>
                        </div>

                        <div class="tab-pane" id="tabs-hakdowntime-1">
                          <div class="row">
                            <!-- <label class="col-3 col-form-label pt-0">Checkboxes</label> -->
                            <div class="col">
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakdowntime1" name="hakdowntime1" type="checkbox">
                                <span class="form-check-label">Finishing</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakdowntime2" name="hakdowntime2" type="checkbox">
                                <span class="form-check-label">Netting</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakdowntime3" name="hakdowntime3" type="checkbox">
                                <span class="form-check-label">Ringrope</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakdowntime4" name="hakdowntime4" type="checkbox">
                                <span class="form-check-label">Spinning</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakdowntime5" name="hakdowntime5" type="checkbox">
                                <span class="form-check-label">Utility</span>
                              </label>
                              <label class="form-check mb-1">
                                <input class="form-check-input" id="hakdowntime6" name="hakdowntime6" type="checkbox">
                                <span class="form-check-label">Gudang</span>
                              </label>
                            </div>
                          </div>
                        </div>
                        <!-- <div class="row">
                            <div class="col-6">
                              <label class="form-check">
                                <input class="form-check-input" type="radio" name="ttd" value="0">
                                <span class="form-check-label">NO TTD</span>
                              </label>
                              <label class="form-check">
                                <input class="form-check-input" type="radio" name="ttd" value="1">
                                <span class="form-check-label">MANAGER PPIC (Mengetahui)</span>
                              </label>
                              <label class="form-check">
                                <input class="form-check-input" type="radio" name="ttd" value="2">
                                <span class="form-check-label">MANAGER PRODUKSI / NON (APPROVER)</span>
                              </label>
                              <label class="form-check">
                                <input class="form-check-input" type="radio" name="ttd" value="3">
                                <span class="form-check-label">GM PRODUKSI / NON (RELEASER)</span>
                              </label> -->
                        <!-- <label class="form-check">
                                <input class="form-check-input" type="radio" 
          name="ttd" value="4">
                                <span class="form-check-label">MANAGER PURCHASING</span>
                              </label> -->
                        <!-- </div> -->
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