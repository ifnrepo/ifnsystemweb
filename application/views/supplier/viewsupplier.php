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
                                                        <div class="col-sm-6">
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kode </label>
                                                                <div class="col">
                                                                    <input type="hidden" class="form-control font-kecil hilang" name="id" id="id" value="<?= $data['id']; ?>">
                                                                    <input type="text" class="form-control font-kecil" name="kode_customer" id="kode_customer" value="<?= $data['kode']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Nama </label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="nama_customer" id="nama_customer" value="<?= $data['nama_supplier']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Alamat</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="alamat" id="alamat" value="<?= $data['alamat']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Desa</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="desa" id="desa" value="<?= $data['desa']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kec</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="kecamatan" id="kecamatan" value=" <?= $data['kecamatan']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">kab_kota</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="kab_kota" id="kab_kota" value=" <?= $data['kab_kota']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">provinsi</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="propinsi" id="propinsi" value=" <?= $data['propinsi']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">kodepos</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="kodepos" id="kodepos" value=" <?= $data['kodepos']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Npwp</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="npwp" id="npwp" value=" <?= $data['npwp']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">telp</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="telp" id="telp" value=" <?= $data['telp']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Email</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="email" id="email" value=" <?= $data['email']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kontak</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="kontak" id="kontak" value=" <?= $data['kontak']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Jabatan</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="kontak" id="kontak" value=" <?= $data['jabatan']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Ket</label>
                                                                <div class="col">
                                                                    <input type="text area" class="form-control font-kecil" name="keterangan" id="keterangan" value=" <?= $data['keterangan']; ?>" readonly>
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