<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->
    <style>
        .jumbotron {
            padding: 2rem 1rem;
            background-color: white;
        }

        .data-pekerja {
            padding: 2rem 1rem;
            background-color: aliceblue;
        }

        .data-umum {
            padding: 2rem 1rem;
            background-color: aliceblue;
        }

        .data-bank {
            padding: 2rem 1rem;
            background-color: aliceblue;
        }
    </style>
    <title>View Personil</title>
</head>

<body>
    <!-- <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="#">Personil</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="#data-pekerja">Data Pekerja</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#data-umum">Data Umum</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#data-bank">Bank Account</a>
                    </li>

                </ul>
            </div>
        </div>
    </nav> -->

    <!-- jumbotron -->
    <section class="jumbotron text-center">

        <div class="col-md-6 col-lg-12">
            <div class="card-tabs">
                <div class="tab-content">
                    <div id="tab-bottom-1" class="card tab-pane active show">
                        <div class="card-body ">
                            <div class="col-md-8 mb-3" style="margin-left: 110px;">
                                <div class="ribbon ribbon-top bg-yellow"><!-- Download SVG icon from http://tabler-icons.io/i/star -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                        <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                                    </svg>
                                </div>
                                <div class="card" style="border: 1px solid grey ; margin-top :50 px ;">
                                    <?php
                                    $path = 'assets/image/dokper/';
                                    $foto = (empty(trim($personil['filefoto'])) || !file_exists(FCPATH . $path . $personil['filefoto']))
                                        ? $path . 'image.jpg'
                                        : $path . $personil['filefoto'];
                                    $foto_url = base_url($foto) . '?t=' . time();
                                    ?>
                                    <div class="card-body d-flex align-items-center">
                                        <img src="<?= $foto_url; ?>" alt="Foto" style="width: 100px;  object-fit: cover; margin-right: 15px; border-radius: 5px;">
                                        <div>
                                            <p><strong>Nama:</strong> <?= $personil['nama_personil']; ?></p>
                                            <p><strong>NIP:</strong> <?= $personil['nip']; ?></p>
                                            <p><strong>Bagian:</strong> <?= $personil['departemen']; ?></p>
                                            <p><strong>Jabatan:</strong> <?= $personil['nama_jabatan']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Content of card #2 -->
                    <div id="tab-bottom-2" class="card tab-pane">
                        <div class="card-body">
                            <div class="card-title">Data Pekerja</div>
                            <div class="row" style="font-size: 12px;">
                                <div class="col">
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">No Sidik Jari</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil hilang" name="personil_id" id="personil_id" value="<?= $personil['personil_id']; ?>">
                                            <input type="text" class="form-control font-kecil" name="sidikjari_personil" id="sidikjari_personil" value="<?= $personil['sidikjari_personil']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class=" mb-1 row">
                                        <label class="col-3 col-form-label required">Nama</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="nama_personil" id="name_personil" placeholder="Nama Personil" value="<?= $personil['nama_personil']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Nip</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="nip" id="nip" placeholder="nip" value="<?= $personil['nip']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Bagian</label>
                                        <div class="col">
                                            <select name="bagian_id" id="bagian_id" class="form-control" disabled>
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
                                            <input type="text" class="form-control font-kecil" name="status_aktif" id="status_aktif" value="<?= $personil['status_aktif']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Tanggal Masuk</label>
                                        <div class="col">
                                            <input type="date" class="form-control font-kecil" name="tgl_masuk" id="tgl_masuk" placeholder="Tanggal Masuk" value="<?= $personil['tgl_masuk']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Email</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email" value="<?= $personil['email']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Jabatan</label>
                                        <div class="col">
                                            <select name="jabatan_id" id="jabatan_id" class="form-control" disabled>
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
                                        <label class="col-3 col-form-label required">Status</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="status_karyawan" id="status_karyawan" placeholder="Status Karyawan" value="<?= $personil['status_karyawan']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Jam Kerja</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="jamkerja_normal" id="jamkerja_normal" placeholder="Jam Kerja Normal" value="<?= $personil['jamkerja_normal']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Sub</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="subpekerjaan" id="subpekerjaan" placeholder="Sub Pekerjaan" value="<?= $personil['subpekerjaan']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Grup</label>
                                        <div class="col">
                                            <select name="grup_id" id="grup_id" class="form-control" disabled>
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
                                        <label class="col-3 col-form-label required">Penilai</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="penilai_kerja" id="penilai_kerja" placeholder="Penilai Kerja" value="<?= $personil['penilai_kerja']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Jab Penilai</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="jabatan_penilai" id="jabatan_penilai" placeholder="Jabatan Penilai" value="<?= $personil['jabatan_penilai']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content of card #3 -->
                    <div id="tab-bottom-3" class="card tab-pane">
                        <div class="card-body">
                            <div class="card-title">Data Umum</div>
                            <div class="row" style="font-size: 12px;">
                                <div class="col">
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Tempat Lahir</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="tempat_lahir" id="tempat_lahir" placeholder="Tempat Lahir" value="<?= $personil['tempat_lahir']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Tanggal Lahir</label>
                                        <div class="col">
                                            <input type="date" class="form-control font-kecil" name="tgl_lahir" id="tgl_lahir" placeholder="Tanggal Lahir" value="<?= $personil['tgl_lahir']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">RT</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="rt" id="rt" placeholder="RT" value="<?= $personil['rt']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">RW</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="rw" id="rw" placeholder="RW" value="<?= $personil['rw']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Desa</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="desa" id="desa" placeholder="Desa" value="<?= $personil['desa']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Kab</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="kabupaten" id="kabupaten" placeholder="Kabupaten" value="<?= $personil['kabupaten']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Pendidikan</label>
                                        <div class="col">
                                            <select name="id_pendidikan" id="id_pendidikan" class="form-control" disabled>
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
                                            <select name="id_status" id="id_status" class="form-control" disabled>
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
                                            <input type="text" class="form-control font-kecil" name="tlp" id="tlp" value="<?= $personil['tlp']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Agama</label>
                                        <div class="col">
                                            <div class="col">
                                                <select name="id_agama" id="id_agama" class="form-control" disabled>
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
                                            <select class="form-select" name="jenis_kelamin" id="jenis_kelamin" aria-label="Default select example" disabled>
                                                <option value="laki-laki" <?= ($personil['jenis_kelamin'] == 'laki-laki') ? 'selected' : ''; ?>>Laki-Laki</option>
                                                <option value="perempuan" <?= ($personil['jenis_kelamin'] == 'perempuan') ? 'selected' : ''; ?>>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Ket</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="keterangan" id="keterangan" placeholder="Ket" value="<?= $personil['keterangan']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Content of card #4 -->
                    <div id="tab-bottom-4" class="card tab-pane">
                        <div class="card-body">
                            <div class="card-title">Bank Account</div>
                            <div class="row" style="font-size: 12px;">
                                <div class="col">
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Jamsos</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="no_jamsostek" id="tempat_lahir" placeholder="Jamsostek" value="<?= $personil['no_jamsostek']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Bpjs</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="no_bpjs" id="no_bpjs" placeholder="BPJS" value="<?= $personil['no_bpjs']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Ktp</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="no_ktp" id="no_ktp" placeholder="KTP" value="<?= $personil['no_ktp']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Npwp</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="no_npwp" id="no_npwp" placeholder="NPWP" value="<?= $personil['no_npwp']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">E-fin</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="no_efin" id="no_efin" placeholder="E-FIN" value="<?= $personil['no_efin']; ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">No Rekening</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="norekening_bank" id="norekening_bank" placeholder="No Rekening" value="<?= $personil['norekening_bank']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Atas Nama</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="atas_nama" id="atas_nama" placeholder="Atas Nama" value="<?= $personil['atas_nama']; ?>" readonly>
                                        </div>
                                    </div>

                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Nama Bank</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="namabank" id="namabank" placeholder="Nama Bank" value="<?= $personil['namabank']; ?>" readonly>
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label required">Cabang</label>
                                        <div class="col">
                                            <input type="text" class="form-control font-kecil" name="cabang" id="cabang" placeholder="Cabang" value="<?= $personil['cabang']; ?>" readonly>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Cards navigation -->
                <ul class="nav nav-tabs nav-tabs-bottom">
                    <li class="nav-item"><a href="#tab-bottom-1" class="nav-link active" data-bs-toggle="tab">Card</a></li>
                    <li class="nav-item"><a href="#tab-bottom-2" class="nav-link" data-bs-toggle="tab">Data Pekerja</a></li>
                    <li class="nav-item"><a href="#tab-bottom-3" class="nav-link" data-bs-toggle="tab">Data Umum</a></li>
                    <li class="nav-item"><a href="#tab-bottom-4" class="nav-link" data-bs-toggle="tab">Bank Account</a></li>
                </ul>
            </div>
        </div>
    </section>
    <!-- jumbotron -->
    <!-- identitas -->
    <!-- <section class="data-pekerja" id="data-pekerja">

        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <h2>Data Pekerja</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
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
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label required">Email</label>
                        <div class="col">
                            <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email" value="<?= $personil['email']; ?>">
                        </div>
                    </div>
                </div>
                <div class="col">
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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#0099ff" fill-opacity="1" d="M0,160L0,288L1440,288L1440,320L0,320L0,320Z"></path>
        </svg>
    </section>
    <section class="data-umum" id="data-umum">
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <h2>Data Umum</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
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
                <div class="col">
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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#0099ff" fill-opacity="1" d="M0,160L0,288L1440,288L1440,320L0,320L0,320Z"></path>
        </svg>
    </section>
    <section class="data-bank" id="data-bank">
        <div class="container">
            <div class="row text-center">
                <div class="col">
                    <h2>Bank Account</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
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
                <div class="col">
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
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#0099ff" fill-opacity="1" d="M0,160L0,288L1440,288L1440,320L0,320L0,320Z"></path>
        </svg>
    </section> -->

    <!-- identitas -->


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>

</html>