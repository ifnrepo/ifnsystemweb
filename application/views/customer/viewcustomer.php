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
                                                    <a href="#tabs-home-1" class="nav-link active" data-bs-toggle="tab">Views Customer</a>
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
                                                                    <input type="text" class="form-control font-kecil" name="kode_customer" id="kode_customer" value="<?= $data['kode_customer']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Nama </label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="nama_customer" id="nama_customer" value="<?= $data['nama_customer']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Exdo</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="exdo" id="exdo" value="<?= $data['exdo']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Port</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="port" id="port" value="<?= $data['port']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Country</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="country" id="country" value="<?= $data['country']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Alamat</label>
                                                                <div class="col">
                                                                    <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="3" placeholder="Alamat" value="<?= $data['alamat'] ?>"></textarea>
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
                                                                <label class="col-3 col-form-label required">Kab_Kota</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="kab_kota" id="kab_kota" value=" <?= $data['kab_kota']; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Provinsi</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="propinsi" id="propinsi" value=" <?= $data['propinsi']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Kode Pos</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="kodepos" id="kodepos" value=" <?= $data['kodepos']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Npwp</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="npwp" id="npwp" value=" <?= $data['npwp']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Telp</label>
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
                                                                <label class="col-3 col-form-label required">Ket</label>
                                                                <div class="col">
                                                                    <textarea class="form-control font-kecil" name="keterangan" id="keterangan" value=" <?= $data['keterangan']; ?>" readonly> </textarea>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">BuyCode</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="buycode" id="buycode" placeholder="BuyCode" value="<?= $data['buycode']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">InsCode</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="inscode" id="inscode" placeholder="Inscode" value="<?= $data['inscode']; ?>" readonly>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">JCode1</label>
                                                                <div class="col">
                                                                    <select class="form-select font-kecil" name="jcode1" id="jcode1" disabled>
                                                                        <option selected value="1" <?php if ($data['jcode1'] == '1') {
                                                                                                        echo "selected";
                                                                                                    }; ?>>1</option>
                                                                        <option value="2" <?php if ($data['jcode1'] == 2) {
                                                                                                echo "selected";
                                                                                            }; ?>>2</option>
                                                                        <option value="3" <?php if ($data['jcode1'] == 3) {
                                                                                                echo "selected";
                                                                                            }; ?>>3</option>
                                                                        <option value="4" <?php if ($data['jcode1'] == 4) {
                                                                                                echo "selected";
                                                                                            }; ?>>4</option>
                                                                        <option value="5" <?php if ($data['jcode1'] == 5) {
                                                                                                echo "selected";
                                                                                            }; ?>>5</option>
                                                                        <option value="6" <?php if ($data['jcode1'] == 6) {
                                                                                                echo "selected";
                                                                                            }; ?>>6</option>
                                                                        <option value="7" <?php if ($data['jcode1'] == 7) {
                                                                                                echo "selected";
                                                                                            }; ?>>7</option>
                                                                        <option value="8" <?php if ($data['jcode1'] == 8) {
                                                                                                echo "selected";
                                                                                            }; ?>>8</option>
                                                                        <option value="9" <?php if ($data['jcode1'] == 9) {
                                                                                                echo "selected";
                                                                                            }; ?>>9</option>

                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">JCode2</label>
                                                                <div class="col">
                                                                    <select class="form-select font-kecil" name="jcode2" id="jcode2" disabled>
                                                                        <option selected value="1" <?php if ($data['jcode2'] == 1) {
                                                                                                        echo "selected";
                                                                                                    }; ?>>1</option>
                                                                        <option value="2" <?php if ($data['jcode2'] == 2) {
                                                                                                echo "selected";
                                                                                            }; ?>>2</option>
                                                                        <option value="3" <?php if ($data['jcode2'] == 3) {
                                                                                                echo "selected";
                                                                                            }; ?>>3</option>
                                                                        <option value="4" <?php if ($data['jcode2'] == 4) {
                                                                                                echo "selected";
                                                                                            }; ?>>4</option>
                                                                        <option value="5" <?php if ($data['jcode2'] == 5) {
                                                                                                echo "selected";
                                                                                            }; ?>>5</option>
                                                                        <option value="6" <?php if ($data['jcode2'] == 6) {
                                                                                                echo "selected";
                                                                                            }; ?>>6</option>
                                                                        <option value="7" <?php if ($data['jcode2'] == 7) {
                                                                                                echo "selected";
                                                                                            }; ?>>7</option>
                                                                        <option value="8" <?php if ($data['jcode2'] == 8) {
                                                                                                echo "selected";
                                                                                            }; ?>>8</option>
                                                                        <option value="9" <?php if ($data['jcode2'] == 9) {
                                                                                                echo "selected";
                                                                                            }; ?>>9</option>

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Benua</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="benua" id="benua" placeholder="Benua" value="<?= $data['benua']; ?>" readonly>
                                                                </div>
                                                            </div>

                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">Region</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="region" id="region" placeholder="Region" value="<?= $data['region']; ?>" readonly>
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

                                                            <div class="mb-1 row">
                                                                <label class="col-3 col-form-label required">CustId</label>
                                                                <div class="col">
                                                                    <input type="text" class="form-control font-kecil" name="cust_id" id="cust_id" placeholder="CustId" value="<?= $data['cust_id']; ?> " readonly>
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