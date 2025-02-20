<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body font-kecil">
                <form>
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="row row-cards">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-header">
                                            <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                                                <li class="nav-item">
                                                    <a href="#tabs-home-1" class="nav-link active" data-bs-toggle="tab">Views Supplier</a>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="card-body">
                                            <div class="tab-content">
                                                <div class="tab-pane active show" id="tabs-home-1">
                                                    <div class="row">

                                                        <div class="col-6">
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kode</label>
                                                                <div class="col">
                                                                    <input type="hidden" id="id" name="id" value="<?= $data['id']; ?>">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode" value="<?= $data['kode']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Supplier</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="nama_supplier" id="nama_supplier" placeholder="Nama supplier" value="<?= $data['nama_supplier']; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Alamat</label>
                                                                <div class="col">
                                                                    <textarea style="background-color: floralwhite;" class="form-control font-kecil" name="alamat" id="alamat" rows="3" readonly><?= $data['alamat']; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Desa</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="desa" id="desa" placeholder="desa" value="<?= $data['desa']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kecamatan</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="kecamatan" id="kecamatan" placeholder="Kecamatan" value="<?= $data['kecamatan']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kab_Kota</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="kab_kota" id="kab_kota" placeholder="Kab/Kota" value="<?= $data['kab_kota']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Provinsi</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="propinsi" id="propinsi" placeholder="Provinsi" value="<?= $data['propinsi']; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kode Pos</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="kodepos" id="kodepos" placeholder="Kodepos" value="<?= $data['kodepos']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Npwp</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="npwp" id="npwp" placeholder="Npwp" value="<?= $data['npwp']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Telp</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="telp" id="telp" placeholder="Telp" value="<?= $data['telp']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-6">


                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Email</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email" value="<?= $data['email']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kontak</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="kontak" id="kontak" placeholder="Kontak" value="<?= $data['kontak']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Jabatan</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="jabatan" id="jabatan" placeholder="jabatan" value="<?= $data['jabatan']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Keterangan</label>
                                                                <div class="col">
                                                                    <textarea style="background-color: floralwhite;" class="form-control font-kecil" name="keterangan" rows="3" id="keterangan" value="<?= $data['keterangan']; ?>" readonly> </textarea>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Jenis Suplier</label>
                                                                <div class="col">
                                                                    <select class="form-select" name="jns_supplier" id="jns_supplier" aria-label="Default select example" style="background-color: floralwhite;" disabled>
                                                                        <option value="-" selected>-</option>
                                                                        <option value="TOKO" <?= ($data['jns_supplier'] == 'TOKO') ? 'selected' : ''; ?>>TOKO</option>
                                                                        <option value="RM SAKIT/DOKTER" <?= ($data['jns_supplier'] == 'RM SAKIT/DOKTER') ? 'selected' : ''; ?>>RM SAKIT/DOKTER</option>
                                                                        <option value="SUBKON/KANTIN" <?= ($data['jns_supplier'] == 'SUBKON/KANTIN') ? 'selected' : ''; ?>>SUBKON/KANTIN</option>
                                                                        <option value="ANGKUTAN" <?= ($data['jns_supplier'] == 'ANGKUTAN') ? 'selected' : ''; ?>>ANGKUTAN</option>
                                                                        <option value="PLN" <?= ($data['jns_supplier'] == 'PLN') ?  'selected' : ''; ?>>PLN</option>
                                                                        <option value="LAIN-LAIN" <?= ($data['jns_supplier'] == 'LAIN-LAIN') ? 'selected' : ''; ?>>LAIN-LAIN</option>
                                                                        <option value="PERORANGAN" <?= ($data['jns_supplier'] == 'PERORANGAN') ? 'selected' : ''; ?>>PERORANGAN</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Nama Bank</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="namabank" id="namabank" value="<?= $data['namabank']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Atas Nama</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="atas_nama" id="atas_nama" value="<?= $data['atas_nama']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">No Rek</label>
                                                                <div class="col">
                                                                    <input style="background-color: floralwhite;" type="text" class="form-control font-kecil" name="norek" id="norek" value="<?= $data['norek']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kode Negara</label>
                                                                <div class="col">
                                                                    <select name="kode_negara" id="kode_negara" class="form-control" disabled>
                                                                        <option value=""></option>
                                                                        <?php foreach ($negara as $key) : ?>
                                                                            <?php if ($key['kode_negara'] == $data['kode_negara']) : ?>
                                                                                <option value="<?= $key['kode_negara']; ?>" selected><?= $key['kode_negara']; ?> (<?= $key['uraian_negara']; ?>)</option>
                                                                            <?php else : ?>
                                                                                <option value="<?= $key['kode_negara']; ?>"><?= $key['kode_negara']; ?> (<?= $key['uraian_negara']; ?>)</option>
                                                                            <?php endif; ?>
                                                                        <?php endforeach; ?>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="row mt-2">
                                                                <label class="col-3 col-form-label pt-0">Aktif</label>
                                                                <div class="col">
                                                                    <label class="form-check form-check-single form-switch">
                                                                        <input class="form-check-input" id="aktif" name="aktif" type="checkbox" <?php if ($data['aktif'] == 1) echo 'checked'; ?> readonly>
                                                                    </label>
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