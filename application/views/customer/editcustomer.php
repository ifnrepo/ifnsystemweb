<div class="row font-kecil">
    <div class="col-6">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Kode</label>
            <div class="col">
                <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
                <input type="text" class="form-control font-kecil" name="kode_customer" id="kode_customer" value="<?= $data['kode_customer']; ?>" placeholder="Kode Customer">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Customer</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="nama_customer" id="nama_customer" value="<?= $data['nama_customer']; ?>" placeholder="Nama Customer">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Exdo</label>
            <div class="col">
                <select class="form-select font-kecil" name="exdo" id="exdo" disabled>
                    <option value="export" <?php if ($data['exdo'] == 'export') {
                                                echo "selected";
                                            }; ?>>Export</option>
                    <option value="domestik" <?php if ($data['exdo'] == 'domestik') {
                                                    echo "selected";
                                                }; ?>>Domestik</option>
                </select>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Port</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="port" id="port" value="<?= $data['port']; ?>" placeholder="Port">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Country</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="country" id="country" value="<?= $data['country']; ?>" placeholder="Country">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Alamat</label>
            <div class="col">
                <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="3" placeholder="Alamat"><?= $data['alamat'] ?></textarea>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Desa</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="desa" id="desa" value="<?= $data['desa']; ?>" placeholder="Desa">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Kecamatan</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="kecamatan" id="kecamatan" value="<?= $data['kecamatan']; ?>" placeholder="Kecamatan">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Kab/Kota</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="kab_kota" id="kab_kota" value="<?= $data['kab_kota']; ?>" placeholder="Kab/Kota">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Provinsi</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="propinsi" id="propinsi" value="<?= $data['propinsi']; ?>" placeholder="propinsi">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Kode Pos</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="kodepos" id="kodepos" value="<?= $data['kodepos']; ?>" placeholder="kodepos">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Npwp</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="npwp" id="npwp" value="<?= $data['npwp']; ?>" placeholder="NPWP">
            </div>
        </div>
    </div>
    <div class="col-6">

        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Telp</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="telp" id="telp" value="<?= $data['telp']; ?>" placeholder="Telp">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Email</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="email" id="email" value="<?= $data['email']; ?>" placeholder="Email">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Kontak</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="kontak" id="kontak" value="<?= $data['kontak']; ?>" placeholder="Kontak">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Keterangan</label>
            <div class="col">
                <textarea class="form-control font-kecil" name="keterangan" id="keterangan" cols="30" rows="3" placeholder="Keterangan"><?= $data['keterangan'] ?></textarea>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">BuyCode</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="buycode" id="buycode" placeholder="BuyCode" <?= $data['buycode']; ?>>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">InsCode</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="inscode" id="inscode" placeholder="Inscode" <?= $data['inscode']; ?>>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">JCode1</label>
            <div class="col">
                <select class="form-select font-kecil" name="jcode1" id="jcode1">
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
                <select class="form-select font-kecil" name="jcode2" id="jcode2">
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
                <input type="text" class="form-control font-kecil" name="benua" id="benua" placeholder="Benua" <?= $data['benua']; ?>>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Region</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="region" id="region" placeholder="Region" <?= $data['region']; ?>>
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-3 col-form-label required">CustId</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="cust_id" id="cust_id" placeholder="CustId" <?= $data['cust_id']; ?>>
            </div>
        </div>
    </div>
</div>


<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatecustomer">Update</button>
</div>
<script>
    $("#updatecustomer").click(function() {
        if ($("#kode_customer").val() == '') {
            pesan('Kode harus di isi !', 'error');
            return;
        }
        if ($("#nama_customer").val() == '') {
            pesan('Nama Customer harus di isi !', 'error');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'customer/updatecustomer',
            data: {
                kode_customer: $("#kode_customer").val(),
                nama_customer: $("#nama_customer").val(),
                exdo: $("#exdo").val(),
                port: $("#port").val(),
                country: $("#country").val(),
                alamat: $("#alamat").val(),
                desa: $("#desa").val(),
                kecamatan: $("#kecamatan").val(),
                kab_kota: $("#kab_kota").val(),
                propinsi: $("#propinsi").val(),
                kodepos: $("#kodepos").val(),
                npwp: $("#npwp").val(),
                telp: $("#telp").val(),
                email: $("#email").val(),
                kontak: $("#kontak").val(),
                keterangan: $("#keterangan").val(),
                buycode: $("#buycode").val(),
                inscode: $("#inscode").val(),
                jcode1: $("#jcode1").val(),
                jcode2: $("#jcode2").val(),
                benua: $("#benua").val(),
                region: $("#region").val(),
                cust_id: $("#cust_id").val(),
                id: $("#id").val()
            },
            success: function(data) {
                window.location.reload();

            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>