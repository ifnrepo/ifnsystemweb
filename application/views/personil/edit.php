<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Edit Data Personil
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'personil' ?>" class="btn btn-warning btn-sm text-black"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body font-kecil">
                <form method="POST" action="<?= $action; ?>" id="formtambahpersonil" name="formtambahpersonil">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">No Sidik Jari</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil hilang" name="personil_id" id="personil_id" value="<?= $personil['personil_id']; ?>">
                                    <input type="text" class="form-control font-kecil" name="sidikjari_personil" id="sidikjari_personil" value="<?= $personil['sidikjari_personil']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Foto Pegawai</label>

                                <div class="mb-1 row">
                                    <div class="col" style="text-align: center;">
                                        <div style="float: left; margin-right: 10px;">
                                            <img src="<?= base_url('assets/image/personil/' . $personil['foto_personil']); ?>" alt="Foto Personil" width="100">
                                        </div>
                                        <input type="hidden" name="foto_personil" id="foto_personil" value="<?= $personil['foto_personil']; ?>">
                                        <input type="file" class="form-control" name="foto_personil" id="foto_personil">
                                    </div>
                                </div>
                            </div>

                            <div class=" mb-1 row">
                                <label class="col-3 col-form-label required">Nama</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="nama_personil" id="name_personil" placeholder="Nama Personil" value="<?= $personil['nama_personil']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Nip</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="nip" id="nip" placeholder="nip" value="<?= $personil['nip']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Bagian</label>
                                <div class="col">
                                    <select name="bagian_id" id="bagian_id" class="form-control">
                                        <option value="">Departemen</option>
                                        <?php foreach ($dept as $dep) : ?>
                                            <?php if ($dep['urut'] == $personil['bagian_id']) : ?>
                                                <option value="<?= $dep['urut']; ?>" selected><?= $dep['departemen']; ?></option>
                                            <?php else : ?>
                                                <option value="<?= $dep['urut']; ?>"><?= $dep['departemen']; ?></option>
                                            <?php endif; ?>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Status Aktif</label>
                                <div class="col">
                                    <input type="text" class="form-control font-kecil" name="status_aktif" id="status_aktif" value="<?= $personil['status_aktif']; ?>">
                                </div>
                            </div>
                            <div class="mb-1 row">
                                <label class="col-3 col-form-label required">Tanggal Masuk</label>
                                <div class="col">
                                    <input type="date" class="form-control font-kecil" name="tgl_masuk" id="tgl_masuk" placeholder="Tanggal Masuk" value="<?= $personil['tgl_masuk']; ?>">
                                </div>
                            </div>

                            <div class="hr mt-2 mb-1"></div>
                            <div class="card-body pt-2">
                                <div class="row">
                                    <div class="col"><a href="<?= base_url('personil/edit/') . $personil['personil_id']; ?>" class="btn btn-danger btn-sm w-100">
                                            <i class="fa fa-refresh mr-1"></i>
                                            Reset
                                        </a></div>
                                    <div class="col"><a class="btn btn-primary btn-sm w-100 text-white" id="editpersonil">
                                            <i class="fa fa-save mr-1"></i>
                                            Simpan
                                        </a></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <h4>Edit Data</h4>
                            <div class="row row-cards">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                                                <li class="nav-item">
                                                    <a href="#tabs-home-1" class="nav-link active" data-bs-toggle="tab">Identitas</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tabs-jamsostek-1" class="nav-link" data-bs-toggle="tab">Jamsostek</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tabs-rekening-1" class="nav-link" data-bs-toggle="tab">Rekening</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tabs-penilaian-1" class="nav-link" data-bs-toggle="tab">Penilaian</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active show" id="tabs-home-1">
                                                    <div class="row">
                                                        <div class="col-6">
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Tempat Lahir</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?= $personil['tempat_lahir']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Tanggal Lahir</label>
                                                                <div class="col">
                                                                    <input type="date" class="form-control font-kecil" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir" value="<?= $personil['tgl_lahir']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">RT</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="rt" id="rt" placeholder="RT" value="<?= $personil['rt']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">RW</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="rw" id="rw" placeholder="RW" value="<?= $personil['rw']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Desa</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="desa" id="desa" placeholder="Desa" value="<?= $personil['desa']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kab</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="kabupaten" id="kabupaten" placeholder="Kabupaten" value="<?= $personil['kabupaten']; ?>">
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
                                                                            <?php if ($key['id'] == $personil['id_pendidikan']) : ?>
                                                                                <option value="<?= $key['id']; ?>" selected><?= $key['tingkat_pendidikan']; ?></option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $key['id']; ?>"><?= $key['tingkat_pendidikan']; ?></option>
                                                                            <?php endif; ?>
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
                                                                            <?php if ($key['id'] == $personil['id_status']) : ?>
                                                                                <option value="<?= $key['id']; ?>" selected><?= $key['nama_status']; ?></option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $key['id']; ?>"><?= $key['nama_status']; ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Telp</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="tlp" id="tlp" value="<?= $personil['tlp']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Agama</label>
                                                                <div class="col">
                                                                    <div class="col">
                                                                        <select name="id_agama" id="id_agama" class="form-control">
                                                                            <option value="">Agama</option>
                                                                            <?php foreach ($agama as $key) : ?>
                                                                                <?php if ($key['id'] == $personil['id_agama']) : ?>
                                                                                    <option value="<?= $key['id']; ?>" selected><?= $key['nama_agama']; ?></option>
                                                                                <?php else : ?>
                                                                                    <option value="<?= $key['id']; ?>"><?= $key['nama_agama']; ?></option>
                                                                                <?php endif; ?>
                                                                            <?php endforeach; ?>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Jenis Kelamin</label>
                                                                <div class="col">
                                                                    <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" aria-label="Default select example">
                                                                        <option value="laki-laki" <?= ($personil['jenis_kelamin'] == 'laki-laki') ? 'selected' : ''; ?>>Laki-Laki</option>
                                                                        <option value="perempuan" <?= ($personil['jenis_kelamin'] == 'perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Ket</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="keterangan" id="keterangan" placeholder="Ket" value="<?= $personil['keterangan']; ?>">
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
                                                                    <input type="text" class="form-control font-kecil" name="no_jamsostek" id="tempat_lahir" placeholder="Jamsostek" value="<?= $personil['no_jamsostek']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Bpjs</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="no_bpjs" id="no_bpjs" placeholder="BPJS" value="<?= $personil['no_bpjs']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Ktp</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="no_ktp" id="no_ktp" placeholder="KTP" value="<?= $personil['no_ktp']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Npwp</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="no_npwp" id="no_npwp" placeholder="NPWP" value="<?= $personil['no_npwp']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">E-fin</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="no_efin" id="no_efin" placeholder="E-FIN" value="<?= $personil['no_efin']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Email</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email" value="<?= $personil['email']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="tabs-rekening-1">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">No Rekening</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="norekening_bank" id="norekening_bank" placeholder="No Rekening" value="<?= $personil['norekening_bank']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Atas Nama</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="atas_nama" id="atas_nama" placeholder="Atas Nama" value="<?= $personil['atas_nama']; ?>">
                                                                </div>
                                                            </div>

                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Nama Bank</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="namabank" id="namabank" placeholder="Nama Bank" value="<?= $personil['namabank']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Cabang</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="cabang" id="cabang" placeholder="Cabang" value="<?= $personil['cabang']; ?>">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="tab-pane" id="tabs-penilaian-1">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Jabatan</label>
                                                                <div class="col">
                                                                    <select name="jabatan_id" id="jabatan_id" class="form-control">
                                                                        <option value="">Jabatan</option>
                                                                        <?php foreach ($jabatan as $jab) : ?>
                                                                            <?php if ($jab['id'] == $personil['jabatan_id']) : ?>
                                                                                <option value="<?= $jab['id']; ?>" selected><?= $jab['nama_jabatan']; ?></option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $jab['id']; ?>"><?= $jab['nama_jabatan']; ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Status Karyawan</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="status_karyawan" id="status_karyawan" placeholder="Status Karyawan" value="<?= $personil['status_karyawan']; ?>">
                                                                </div>
                                                            </div>

                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Jam Kerja</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="jamkerja_normal" id="jamkerja_normal" placeholder="Jam Kerja Normal" value="<?= $personil['jamkerja_normal']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Sub Pekerjaan</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="subpekerjaan" id="subpekerjaan" placeholder="Sub Pekerjaan" value="<?= $personil['subpekerjaan']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Grup</label>
                                                                <div class="col">
                                                                    <select name="grup_id" id="grup_id" class="form-control">
                                                                        <option value="">Grup</option>
                                                                        <?php foreach ($grups as $grup) : ?>
                                                                            <?php if ($grup['id'] == $personil['grup_id']) : ?>
                                                                                <option value="<?= $grup['id']; ?>" selected><?= $grup['nama_grup']; ?></option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $grup['id']; ?>"><?= $grup['nama_grup']; ?></option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Penilai Kerja</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="penilai_kerja" id="penilai_kerja" placeholder="Penilai Kerja" value="<?= $personil['penilai_kerja']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Jabatan Penilai Kerja</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="jabatan_penilai" id="jabatan_penilai" placeholder="Jabatan Penilai" value="<?= $personil['jabatan_penilai']; ?>">
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
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>