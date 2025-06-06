<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-6">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Inisial</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="inisial" id="inisial" placeholder="Inisial">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Rekanan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="nama_rekanan" id="nama_rekanan" placeholder="Nama Rekanan">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Alamat Rekanan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="alamat_rekanan" id="alamat_rekanan" placeholder="Alamat Rekanan">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode Pos</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kodepos" id="kodepos" placeholder="Kode Pos">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Telp</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="telp" id="telp" placeholder="Telp">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Fax</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="fax" id="fax" placeholder="Fax">
                </div>
            </div>


        </div>
        <div class="col-6">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Email</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Npwp</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="npwp" id="npwp" placeholder="Npwp">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Bank</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="bank" id="bank" placeholder="Bank">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Rek BANK</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="rek_bank" id="rek_bank" placeholder="Rek BANK">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Atas Nama BANK</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="an_bank" id="an_bank" placeholder="Atas Nama BANK">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kontak</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kontak" id="kontak" placeholder="Kontak">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jabatan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="jabatan" id="jabatan" placeholder="Jabatan">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">No KTP</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="noktp" id="noktp" placeholder="No KTP">
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpansupplier">Simpan</button>
</div>
<script>
    $("#simpansupplier").click(function() {
        if ($("#kode").val() == '') {
            pesan('Kode harus di isi !', 'error');
            return;
        }
        if ($("#nama_rekanan").val() == '') {
            pesan('Nama Rekanan harus di isi !', 'error');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'rekanan/simpan',
            data: {
                kode: $("#kode").val(),
                inisial: $("#inisial").val(),
                nama_rekanan: $("#nama_rekanan").val(),
                alamat_rekanan: $("#alamat_rekanan").val(),
                kodepos: $("#kodepos").val(),
                telp: $("#telp").val(),
                fax: $("#fax").val(),
                email: $("#email").val(),
                npwp: $("#npwp").val(),
                bank: $("#bank").val(),
                rek_bank: $("#rek_bank").val(),
                an_bank: $("#an_bank").val(),
                kontak: $("#kontak").val(),
                jabatan: $("#jabatan").val(),
                noktp: $("#noktp").val(),
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