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

                <div class="row">
                    <div class="col-sm-3">
                        <div class="bg-blue-lt p-1">
                            <?php
                            $path = 'assets/image/dokper/';
                            $foto = (empty(trim($personil['filefoto'])) || !file_exists(FCPATH . $path . $personil['filefoto']))
                                ? $path . 'image.jpg'
                                : $path . $personil['filefoto'];
                            $foto_url = base_url($foto) . '?t=' . time();
                            ?>
                            <img src="<?= $foto_url; ?>" alt="Foto" style="width: auto;" id="gbimage">
                        </div>
                        <div class="text-center">
                            <form name="formFoto" id="formFoto" action="<?= $actionfoto; ?>" method="post" enctype="multipart/form-data">
                                <input type="hidden" name="personil_id" id="personil_id" value="<?= $personil['personil_id']; ?>">
                                <hr class="m-1">
                                <div>
                                    <div class="input-group">
                                        <input type="hidden" class="form-control group-control" id="file_path" name="file_path">
                                        <input type="file" class="hilang" accept="image/*" id="file" name="file" onchange="loadFile(event)">
                                        <input type="hidden" name="old_logo" value="<?= $personil['filefoto'] ?>">
                                    </div>
                                </div>
                                <button type="button" class="btn btn-sm btn-info btn-flat" id="file_browser"><i class="fa fa-search mr-1"></i> Get Foto</button>
                                <button type="submit" class="btn btn-sm btn-danger btn-flat disabled" id="okesubmit"><i class="fa fa-check mr-1"></i> Update Foto</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-sm-9">
                        <h4>Edit Data</h4>
                        <div class="row row-cards">
                            <div class="col">
                                <form name="formkolom" id="formkolom" action="<?= $actionkolom; ?>" method="post">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                                                <li class="nav-item">
                                                    <a href="#tabs-personil-1" class="nav-link active" data-bs-toggle="tab">Data Pekerja</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a href="#tabs-home-1" class="nav-link " data-bs-toggle="tab">Data Umum</a>
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
                                                                    <input type="text" class="form-control font-kecil hilang" name="personil_id" id="personil_id" value="<?= $personil['personil_id']; ?>">
                                                                    <input type="text" class="form-control font-kecil" name="sidikjari_personil" id="sidikjari_personil" value="<?= $personil['sidikjari_personil']; ?>">
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
                                                            <div class="row mt-2">
                                                                <label class="col-3 col-form-label pt-0">Status Aktif</label>
                                                                <div class="col">
                                                                    <label class="form-check form-check-single form-switch">
                                                                        <input class="form-check-input" id="status_aktif" name="status_aktif" type="checkbox" <?php if ($personil['status_aktif'] == 1) echo 'checked'; ?>>
                                                                    </label>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Tanggal Masuk</label>
                                                                <div class="col">
                                                                    <input type="date" class="form-control font-kecil" name="tgl_masuk" id="tgl_masuk" placeholder="Tanggal Masuk" value="<?= $personil['tgl_masuk']; ?>">
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Email</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email" value="<?= $personil['email']; ?>">
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

                                                <div class="tab-pane " id="tabs-home-1">
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
                                                        </div>
                                                        <div class="col-6">
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
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-beetwen p-3">
                                        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">.</button>
                                        <span class="text-red" style="font-size: 12px !important;" id="keteranganerr"></span>
                                        <a class="btn btn-sm btn-primary" style="color: white;" id="simpandata">Simpan Perubahan </a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- <input type="file" class="hilang" accept="image/*" id="file" name="file" onchange="loadFile(event)">
<script>
    $("#simpandata").click(function() {
        document.formkolom.submit();
    });

    var loadFile = function(event) {
        var output = document.getElementById("gbimage");
        var isifile = event.target.files[0];

        if (!isifile) {
            output.src = "<?= base_url($path . 'image.jpg'); ?>";
            $("#okesubmit").addClass("disabled");
        } else {
            output.src = URL.createObjectURL(isifile);
            output.onload = function() {
                URL.revokeObjectURL(output.src);
            };
            $("#okesubmit").removeClass("disabled");
        }
    };
</script> -->