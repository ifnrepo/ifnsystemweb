<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<style>
  .card {
    border-radius: 8px;
    border: 1px solid #ddd;
  }

  .card-header {
    background-color: #007bff;
  }

  .form-control {
    border-radius: 7px;

  }

  .nav-tabs .nav-link.active {
    background-color: #007bff;
    color: #fff;
    border: 0;
  }

  .nav-tabs .nav-link {
    color: #007bff;
    font-size: 18px;
  }
</style>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Tambah Data Personil
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'personil' ?>" class="btn btn-warning btn-sm text-black"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<!-- <div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body font-kecil">
        <form action="<?= $action; ?>" id="formtambahpersonil" name="formtambahpersonil" method="POST">
          <div class=" row">
            <div class="col-sm-6">
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">No Sidik Jari</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="sidikjari_personil" id="sidikjari_personil" placeholder="Sidik Jari Personil">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Foto Pegawai</label>
                <div class=" col">
                  <input type="file" class="form-control font-kecil" name="foto_personil" id="foto_personil">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="nama_personil" id="nama_personil" placeholder="Nama Personil">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nip</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="nip" id="nip" placeholder="nip" style="text-transform:uppercase">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Bagian</label>
                <div class="col">
                  <select name="bagian_id" id="bagian_id" class="form-control">
                    <option value="Select Menu">Departemen</option>
                    <?php foreach ($dept as $dep) : ?>
                      <option value="<?= $dep['urut']; ?>"><?= $dep['departemen']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Pendidikan</label>
                <div class="col">
                  <select name="id_pendidikan" id="id_pendidikan" class="form-control">
                    <option value="Select Menu">Pendidikan</option>
                    <?php foreach ($pendidikan as $key) : ?>
                      <option value="<?= $key['id']; ?>"><?= $key['tingkat_pendidikan']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Agama</label>
                <div class="col">
                  <select name="id_agama" id="id_agama" class="form-control">
                    <option value="Select Menu">Agama</option>
                    <?php foreach ($agama as $key) : ?>
                      <option value="<?= $key['id']; ?>"><?= $key['nama_agama']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jenis Kelamin</label>
                <div class="col">
                  <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" aria-label="Default select example">
                    <option selected>Jenis Kelamin </option>
                    <option value="laki-laki">Laki-Laki</option>
                    <option value="perempuan">Perempuan</option>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Ket</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="keterangan" id="keterangan" placeholder="Ket">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Status Aktif</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="status_aktif" id="status_aktif" placeholder="Status Aktif">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Status</label>
                <div class="col">
                  <select name="id_status" id="id_status" class="form-control">
                    <option value="Select Menu">Status Personil</option>
                    <?php foreach ($status as $key) : ?>
                      <option value="<?= $key['id']; ?>"><?= $key['nama_status']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Telp</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="tlp" id="tlp" placeholder="Telephone/Wa">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Tanggal Masuk</label>
                <div class="col">
                  <input type="date" class="form-control font-kecil" name="tgl_masuk" id="tgl_masuk" placeholder="Tanggal Masuk">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Tempat Lahir</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Tanggal Lahir</label>
                <div class="col">
                  <input type="date" class="form-control font-kecil" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">RT</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="rt" id="rt" placeholder="RT">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">RW</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="rw" id="rw" placeholder="RW">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Desa</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="desa" id="desa" placeholder="Desa">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kab</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="kabupaten" id="kabupaten" placeholder="Kabupaten">
                </div>
              </div>
              <div class="hr mt-2 mb-1"></div>
              <div class="card-body pt-2">
                <div class="row">
                  <div class="col"><a href="./tambahdata" class="btn btn-danger btn-sm w-100">
                      <i class="fa fa-refresh mr-1"></i>
                      Reset
                    </a></div>

                  <div class="col"><a class="btn btn-primary btn-sm w-100 text-white" id="tambahpersonil">
                      <i class="fa fa-save mr-1"></i>
                      Simpan
                    </a></div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jamsostek</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="no_jamsostek" id="no_jamsostek" placeholder="Jamsostek">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Bpjs</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="no_bpjs" id="no_bpjs" placeholder="BPJS">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Ktp</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="no_ktp" id="no_ktp" placeholder="KTP">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Npwp</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="no_npwp" id="no_npwp" placeholder="BPJS">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">E-fin</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="no_efin" id="no_efin" placeholder="E-FIN">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Email</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">No Rekening</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="norekening_bank" id="norekening_bank" placeholder="No Rekening">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Atas Nama</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="atas_nama" id="atas_nama" placeholder="Atas Nama">
                </div>
              </div>

              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Bank</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="namabank" id="namabank" placeholder="Nama Bank">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Cabang</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="cabang" id="cabang" placeholder="Cabang">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jabatan</label>
                <div class="col">
                  <select name="jabatan_id" id="jabatan_id" class="form-control">
                    <option value="Select Menu">Jabatan</option>
                    <?php foreach ($jabatan as $jab) : ?>
                      <option value="<?= $jab['id']; ?>"><?= $jab['nama_jabatan']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Status Karyawan</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="status_karyawan" id="status_karyawan" placeholder="Status Karyawan">
                </div>
              </div>

              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jam Kerja</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="jamkerja_normal" id="jamkerja_normal" placeholder="Jam Kerja Normal">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Sub Pekerjaan</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="subpekerjaan" id="subpekerjaan" placeholder="Sub Pekerjaan">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Grup</label>
                <div class="col">
                  <select name="grup_id" id="grup_id" class="form-control">
                    <option value="Select Menu">Grup</option>
                    <?php foreach ($grups as $grup) : ?>
                      <option value="<?= $grup['id']; ?>"><?= $grup['nama_grup']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Penilai Kerja</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="penilai_kerja" id="penilai_kerja" placeholder="Penilai Kerja">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jabatan Penilai Kerja</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="jabatan_penilai" id="jabatan_penilai" placeholder="Jabatan Penilai">
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div> -->
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body font-kecil">
        <form method="POST" action="<?= $action; ?>" id="formtambahpersonil" name="formtambahpersonil">
          <div class="col-sm-12">
            <h4>Master Personil</h4>
            <div class="row row-cards">
              <div class="col">
                <div class="card">
                  <div class="card-header">
                    <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                      <li class="nav-item">
                        <a href="#tabs-personil-1" class="nav-link active" data-bs-toggle="tab">Data Pekerja</a>
                      </li>
                      <li class="nav-item">
                        <a href="#tabs-home-1" class="nav-link" data-bs-toggle="tab">Data Umum</a>
                      </li>
                      <li class="nav-item">
                        <a href="#tabs-jamsostek-1" class="nav-link" data-bs-toggle="tab">Bank Account</a>
                      </li>
                    </ul>
                  </div>
                  <div class="card-body">
                    <div class="tab-content">
                      <div class="tab-pane active show" id="tabs-personil-1">
                        <div class="row">
                          <div class="col-6">
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">No Sidik Jari</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="sidikjari_personil" id="sidikjari_personil" placeholder="Sidik Jari">
                              </div>
                            </div>
                            <div class=" mb-1 row">
                              <label class="col-3 col-form-label required">Nama</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="nama_personil" id="name_personil" placeholder="Nama Personil">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Nip</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="nip" id="nip" placeholder="Nomor Induk Pegawai">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Departemen</label>
                              <div class="col">
                                <select name="bagian_id" id="bagian_id" class="form-control">
                                  <option value="Select Menu">Departemen</option>
                                  <?php foreach ($dept as $dep) : ?>
                                    <option value="<?= $dep['urut']; ?>"><?= $dep['departemen']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="row mt-2">
                              <label class="col-3 col-form-label pt-0">Status Aktif</label>
                              <div class="col">
                                <label class="form-check form-check-single form-switch">
                                  <input class="form-check-input" id="status_aktif" name="status_aktif" type="checkbox">
                                </label>
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Tanggal Masuk</label>
                              <div class="col">
                                <input type="date" class="form-control font-kecil" name="tgl_masuk" id="tgl_masuk" placeholder="Tanggal Masuk">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Email</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email">
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Jabatan</label>
                              <div class="col">
                                <select name="jabatan_id" id="jabatan_id" class="form-control">
                                  <option value="">Jabatan</option>
                                  <?php foreach ($jabatan as $jab) : ?>
                                    <option value="<?= $jab['id']; ?>"><?= $jab['nama_jabatan']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Status Karyawan</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="status_karyawan" id="status_karyawan" placeholder="Status Karyawan">
                              </div>
                            </div>

                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Jam Kerja</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="jamkerja_normal" id="jamkerja_normal" placeholder="Jam Kerja Normal">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Sub Pekerjaan</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="subpekerjaan" id="subpekerjaan" placeholder="Sub Pekerjaan">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Grup</label>
                              <div class="col">
                                <select name="grup_id" id="grup_id" class="form-control">
                                  <option value="">Grup</option>
                                  <?php foreach ($grups as $grup) : ?>
                                    <option value="<?= $grup['id']; ?>"><?= $grup['nama_grup']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Penilai Kerja</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="penilai_kerja" id="penilai_kerja" placeholder="Penilai Kerja">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Jabatan Penilai Kerja</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="jabatan_penilai" id="jabatan_penilai" placeholder="Jabatan Penilai">
                              </div>
                            </div>
                          </div>
                          <div class="hr mt-2 mb-1"></div>
                          <div class="card-body pt-2">
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane " id="tabs-home-1">
                        <div class="row">
                          <div class="col-6">
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Tempat Lahir</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Tanggal Lahir</label>
                              <div class="col">
                                <input type="date" class="form-control font-kecil" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">RT</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="rt" id="rt" placeholder="RT">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">RW</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="rw" id="rw" placeholder="RW">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Desa</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="desa" id="desa" placeholder="Desa">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Kab</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="kabupaten" id="kabupaten" placeholder="Kabupaten">
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Pendidikan</label>
                              <div class="col">
                                <select name="id_pendidikan" id="id_pendidikan" class="form-control">
                                  <option value="">Pendidikan</option>
                                  <?php foreach ($pendidikan as $key) : ?>
                                    <option value="<?= $key['id']; ?>"><?= $key['tingkat_pendidikan']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Status</label>
                              <div class="col">
                                <select name="id_status" id="id_status" class="form-control">
                                  <option value="">Status</option>
                                  <?php foreach ($status as $key) : ?>
                                    <option value="<?= $key['id']; ?>"><?= $key['nama_status']; ?></option>
                                  <?php endforeach; ?>
                                </select>
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Telp</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="tlp" id="tlp">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Agama</label>
                              <div class="col">
                                <div class="col">
                                  <select name="id_agama" id="id_agama" class="form-control">
                                    <option value="">Agama</option>
                                    <?php foreach ($agama as $key) : ?>
                                      <option value="<?= $key['id']; ?>"><?= $key['nama_agama']; ?></option>
                                    <?php endforeach; ?>
                                  </select>
                                </div>
                              </div>
                            </div>

                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Jenis Kelamin</label>
                              <div class="col">
                                <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" aria-label="Default select example">
                                  <option value="laki-laki">Laki-Laki</option>
                                  <option value="perempuan">Perempuan</option>
                                </select>
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Ket</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="keterangan" id="keterangan" placeholder="Ket">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="tab-pane" id="tabs-jamsostek-1">
                        <div class="row">
                          <div class="col-6">
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Jamsos</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="no_jamsostek" id="tempat_lahir" placeholder="Jamsostek">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Bpjs</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="no_bpjs" id="no_bpjs" placeholder="BPJS">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Ktp</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="no_ktp" id="no_ktp" placeholder="KTP">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Npwp</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="no_npwp" id="no_npwp" placeholder="NPWP">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">E-fin</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="no_efin" id="no_efin" placeholder="E-FIN">
                              </div>
                            </div>
                          </div>
                          <div class="col-6">
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">No Rekening</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="norekening_bank" id="norekening_bank" placeholder="No Rekening">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Atas Nama</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="atas_nama" id="atas_nama" placeholder="Atas Nama">
                              </div>
                            </div>

                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Nama Bank</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="namabank" id="namabank" placeholder="Nama Bank">
                              </div>
                            </div>
                            <div class="mb-1 row">
                              <label class="col-3 col-form-label required">Cabang</label>
                              <div class="col">
                                <input type="text" class="form-control font-kecil" name="cabang" id="cabang" placeholder="Cabang">
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <div class="col-mt-3">
                <div class="row" style="margin-right: 50px;">
                  <div class="col-sm-8"></div>
                  <div class="col"><a href="./tambahdata" class="btn btn-danger btn-sm w-100">
                      <i class="fa fa-refresh mr-1"></i>
                      Reset
                    </a></div>
                  <div class="col"><a class="btn btn-primary btn-sm w-100 text-white" id="tambahpersonil">
                      <i class="fa fa-save mr-1"></i>
                      Simpan
                    </a></div>
                </div>
              </div>
            </div>
          </div>
        </form>

      </div>
    </div>
  </div>