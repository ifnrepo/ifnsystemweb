<div class="container-xl">
    <div class="row">
        <div class="col-6">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode Customer</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kode_customer" id="kode_customer" placeholder="Kode Customer">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Customer</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="nama_customer" id="nama_customer" placeholder="Nama Customer">
                </div>
            </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Exdo</label>
            <div class="col">
                <select class="form-select" name="exdo" id="exdo">
                    <option value="export">Export</option>
                    <option value="domestik">Domestik</option>
                </select>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Alamat</label>
            <div class="col">
                <textarea class="form-control" name="alamat" id="alamat" cols="30" rows="3" placeholder="Alamat"></textarea>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Alamat</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="alamat" id="alamat" placeholder="Alamat">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Desa</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="desa" id="desa" placeholder="Desa">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kecamatan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kecamatan" id="kecamatan" placeholder="Kecamatan">
                </div>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Kab/Kota</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="kab_kota" id="kab_kota" placeholder="Kab/Kota">
            </div>
        </div>
        <div class="col-6">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Provinsi</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="propinsi" id="propinsi" placeholder="propinsi">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode Pos</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kodepos" id="kodepos" placeholder="kodepos">
                </div>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Npwp</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" name="npwp" id="npwp" placeholder="NPWP">
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Telp</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="telp" id="telp" placeholder="Telp">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Email</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kontak</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kontak" id="kontak" placeholder="Kontak">
                </div>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label required">Keterangan</label>
            <div class="col">
                <textarea class="form-control" name="keterangan" id="keterangan" cols="30" rows="3" placeholder="Keterangan"></textarea>
            </div>
        </div>
    </div>
</div>


<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpancustomer">Simpan</button>
</div>
<script>
    $("#simpancustomer").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'customer/simpancustomer',
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
                keterangan: $("#keterangan").val()
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