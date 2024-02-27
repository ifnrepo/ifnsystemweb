<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-6">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="hidden" id="id" name="id" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode" value="<?= $data['kode']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Supplier</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="nama_supplier" id="nama_supplier" placeholder="Nama supplier" value="<?= $data['nama_supplier']; ?>">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Alamat</label>
                <div class="col">
                    <textarea class="form-control font-kecil" name="alamat" id="alamat" rows="3"><?= $data['alamat']; ?></textarea>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Desa</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="desa" id="desa" placeholder="desa" value="<?= $data['desa']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kecamatan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kecamatan" id="kecamatan" placeholder="Kecamatan" value="<?= $data['kecamatan']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">kab_kota</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kab_kota" id="kab_kota" placeholder="Kab/Kota" value="<?= $data['kab_kota']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Provinsi</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="propinsi" id="propinsi" placeholder="propinsi" value="<?= $data['propinsi']; ?>">
                </div>
            </div>
        </div>
        <div class="col-6">

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode Pos</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kodepos" id="kodepos" placeholder="kodepos" value="<?= $data['kodepos']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Npwp</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="npwp" id="npwp" placeholder="Npwp" value="<?= $data['npwp']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Telp</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="telp" id="telp" placeholder="Telp" value="<?= $data['telp']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Email</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email" value="<?= $data['email']; ?>"> 
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kontak</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kontak" id="kontak" placeholder="Kontak" value="<?= $data['kontak']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jabatan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="jabatan" id="jabatan" placeholder="jabatan" value="<?= $data['jabatan']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Keterangan</label>
                <div class="col">
                    <textarea class="form-control font-kecil" name="keterangan" rows="3" id="keterangan"><?= $data['keterangan']; ?></textarea>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatesupplier">Update</button>
</div>
<script>
    $("#updatesupplier").click(function() {
        if($("#kode").val() == ''){
            pesan('Kode harus di isi !','error');
            return;
            }
        if($("#nama_supplier").val() == ''){
            pesan('Nama Supplier harus di isi !','error');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'supplier/updatesupplier',
            data: {
                kode: $("#kode").val(),
                nama_supplier: $("#nama_supplier").val(),
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
                jabatan: $("#jabatan").val(),
                keterangan: $("#keterangan").val(),
                id:$("#id").val()
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