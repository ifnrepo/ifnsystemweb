<div class="row">
    <div class="col-6">
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Kode Customer</label>
            <div class="col">
                <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>" >
                <input type="text" class="form-control font-kecil" name="kode_customer" id="kode_customer" value="<?= $data['kode_customer']; ?>" placeholder="Kode Customer">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Nama Customer</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="nama_customer" id="nama_customer" value="<?= $data['nama_customer']; ?>" placeholder="Nama Customer">
            </div>
        </div>

        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Exdo</label>
            <div class="col">
                <select class="form-select font-kecil" name="exdo" id="exdo">
                    <option value="export" <?php if($data['exdo']=='export'){ echo "selected"; }; ?> >Export</option>
                    <option value="domestik" <?php if($data['exdo']=='domestik'){ echo "selected"; }; ?>>Domestik</option>
                </select>
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
    </div>
    <div class="col-6">
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
    </div>
</div>


<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatecustomer">Simpan</button>
</div>
<script>
    $("#updatecustomer").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'customer/updatecustomer',
            data: {
                kode_customer: $("#kode_customer").val(),
                nama_customer: $("#nama_customer").val(),
                exdo: $("#exdo").val(),
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