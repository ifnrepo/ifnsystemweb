<!DOCTYPE html>
<html lang="en">

<head>
  <title>Shine - FREE Bootstrap 5 Resume/CV Template For Developers</title>

  <!-- Meta -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Profolio Bootstrap 5 Template">
  <meta name="author" content="Xiaoying Riley at 3rd Wave Media">
  <link rel="shortcut icon" href="favicon.ico">

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">

  <!-- Bootstrpa Icons -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">

  <!-- FontAwesome JS -->
  <script defer src="assets/fontawesome/js/all.js"></script>

  <!-- Theme CSS -->
  <link id="theme-style" rel="stylesheet" href="assets/css/shine.css">

</head>


<body class="light-mode">

  <div class="container-fluid">

    <div class="main-content-wrapper">
      <div class="container-fluid">
        <div class="top-bar text-center position-relative">
          <div class="top-bar-inner">
          </div>
        </div>

        <div class="resume-wrapper mx-auto rounded-2">
          <div class="resume-header px-4 px-lg-5">
            <div class="resume-profile-holder text-center">
              <img class="resume-profile-pic rounded-circle" src="<?= LOK_UPLOAD_USER . $personil['filefoto']; ?>" alt="" style="max-width: 180px; max-height: 180px;">
              <h2 class="resume-name text-uppercase"><?= $personil['nama_personil']; ?></h2>
              <div class="resume-role-title text-uppercase">Sidik Jari : <?= $personil['sidikjari_personil']; ?></div>
              <div class="resume-role-title text-uppercase">NIP : <?= $personil['nip']; ?></div>
              <div class="resume-role-title text-uppercase">Bagian : <?= $personil['departemen']; ?></div>
              <div class="resume-role-title text-uppercase">Grup : <?= $personil['nama_grup']; ?></div>
              <br>
              <i class="resume-contact-icon bi bi-telephone-inbound me-2"></i><?= $personil['tlp']; ?></li>
              <!-- <div class="resume-contact mt-4">
                <ul class="resume-contact-list list-unstyled list-inline mb-0 justify-content-between">
                  <li class="list-inline-item me-md-3 me-lg-5"><i class="resume-contact-icon bi bi-telephone-inbound me-2"></i><?= $personil['tlp']; ?></li>
                </ul>
              </div> -->
            </div>
          </div>

          <div class="resume-body p-4 p-lg-5">
            <div class="row">
              <section class="resume-summary-section resume-section">
                <h3 class="resume-section-heading text-uppercase py-2 py-lg-3 py-2 py-lg-3"><i class="resume-section-heading-icon bi bi-person me-2"></i>Identitas</h3>
                <div class="resume-summary-desc">
                  <div class="row">
                    <div class="col-6">
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
                    <div class="col-6">
                      <div class="mb-1 row">
                        <label class="col-3 col-form-label required">Pen</label>
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
                          <select name="id_status" id="id_status" class="form-control" readonly>
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
                          <select name="id_agama" id="id_agama" class="form-control" readonly>
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
                          <input type="text" class="form-control font-kecil" name="keterangan" id="keterangan" placeholder="Ket" value="<?= $personil['keterangan']; ?>" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <hr>
              <section class="resume-summary-section resume-section">
                <h3 class="resume-section-heading text-uppercase py-2 py-lg-3 py-2 py-lg-3"><i class="resume-section-heading-icon bi bi-person me-2"></i>Jamsostek</h3>
                <div class="resume-summary-desc">
                  <div class="row">
                    <div class="col-6">
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
                    </div>
                    <div class="col-6">
                      <div class="mb-1 row">
                        <label class="col-3 col-form-label required">Npwp</label>
                        <div class="col">
                          <input type="text" class="form-control font-kecil" name="no_npwp" id="no_npwp" placeholder="NPWP" value="<?= $personil['no_npwp']; ?>" readonly>
                        </div>
                      </div>
                      <div class="mb-1 row">
                        <label class="col-3 col-form-label required">E-fin</label>
                        <div class="col">
                          <input type="text" class="form-control font-kecil" name="no_e-fin" id="no_e-fin" placeholder="E-FIN" value="<?= $personil['no_efin']; ?>" readonly>
                        </div>
                      </div>
                      <div class="mb-1 row">
                        <label class="col-3 col-form-label required">Email</label>
                        <div class="col">
                          <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email" value="<?= $personil['email']; ?>" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
              <hr>
              <section class="resume-summary-section resume-section">
                <h3 class="resume-section-heading text-uppercase py-2 py-lg-3 py-2 py-lg-3"><i class="resume-section-heading-icon bi bi-person me-2"></i>Rekening</h3>
                <div class="resume-summary-desc">
                  <div class="row">
                    <div class="col-12">
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
              </section>
              <hr>
              <section class="resume-summary-section resume-section">
                <h3 class="resume-section-heading text-uppercase py-2 py-lg-3 py-2 py-lg-3"><i class="resume-section-heading-icon bi bi-person me-2"></i>Penilaian</h3>
                <div class="resume-summary-desc">
                  <div class="row">
                    <div class="col-12">
                      <div class="mb-1 row">
                        <label class="col-3 col-form-label required">Jabatan</label>
                        <div class="col">
                          <input type="text" class="form-control font-kecil" name="jabatan" id="jabatan" placeholder="jabatan" value="<?= $personil['nama_jabatan']; ?>" readonly>
                        </div>
                      </div>
                      <div class="mb-1 row">
                        <label class="col-3 col-form-label required">Status Karyawan</label>
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
                        <label class="col-3 col-form-label required">Sub Pekerjaan</label>
                        <div class="col">
                          <input type="text" class="form-control font-kecil" name="subpekerjaan" id="subpekerjaan" placeholder="Sub Pekerjaan" value="<?= $personil['subpekerjaan']; ?>" readonly>
                        </div>
                      </div>
                      <div class="mb-1 row">
                        <label class="col-3 col-form-label required">Penilai Kerja</label>
                        <div class="col">
                          <input type="text" class="form-control font-kecil" name="penilai_kerja" id="penilai_kerja" placeholder="Penilai Kerja" value="<?= $personil['penilai_kerja']; ?>" readonly>
                        </div>
                      </div>
                      <div class="mb-1 row">
                        <label class="col-3 col-form-label required">Jabatan Penilai Kerja</label>
                        <div class="col">
                          <input type="text" class="form-control font-kecil" name="jabatan_penilai" id="jabatan_penilai" placeholder="Jabatan Penilai" value="<?= $personil['jabatan_penilai']; ?>" readonly>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </section>
            </div>
          </div>
        </div>
      </div>
    </div>


  </div><!--//row-->

  </div><!--//container-->

  <footer class="footer text-center py-4">
    <!--/* This template is free as long as you keep the footer attribution link. If you'd like to use the template without the attribution link, you can buy the commercial license via our website: themes.3rdwavemedia.com Thank you for your support. :) */-->
    <small class="copyright">It Indoneptune<a class="theme-link" target="_blank">Xiaoying Riley</a> for developers</small>
  </footer>

</body>