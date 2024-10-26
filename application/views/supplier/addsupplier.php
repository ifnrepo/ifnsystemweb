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
                <label class="col-3 col-form-label required">Supplier</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="nama_supplier" id="nama_supplier" placeholder="Nama supplier">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Alamat</label>
                <div class="col">
                    <textarea class="form-control font-kecil" name="alamat" id="alamat" rows="3"></textarea>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Desa</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="desa" id="desa" placeholder="desa">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kecamatan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kecamatan" id="kecamatan" placeholder="Kecamatan">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">kab_kota</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kab_kota" id="kab_kota" placeholder="Kab/Kota">
                </div>
            </div>
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

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Npwp</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="npwp" id="npwp" placeholder="Npwp">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Telp</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="telp" id="telp" placeholder="Telp">
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
                <label class="col-3 col-form-label required">Kontak</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kontak" id="kontak" placeholder="Kontak">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jabatan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="jabatan" id="jabatan" placeholder="jabatan">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Keterangan</label>
                <div class="col">
                    <textarea class="form-control font-kecil" name="keterangan" rows="3" id="keterangan"></textarea>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jenis Suplier</label>
                <div class="col">
                    <select class="form-select" name="jns_supplier" id="jns_supplier" aria-label="Default select example">
                        <option value="-" selected>-</option>
                        <option value="TOKO">TOKO</option>
                        <option value="RM SAKIT/DOKTER">RM SAKIT/DOKTER</option>
                        <option value="SUBKON/KANTIN">SUBKON/KANTIN</option>
                        <option value="ANGKUTAN">ANGKUTAN</option>
                        <option value="PLN">PLN</option>
                        <option value="LAIN-LAIN">LAIN-LAIN</option>
                        <option value="PERORANGAN">PERORANGAN</option>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Bank</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="namabank" id="namabank" placeholder="Nama Bank">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Atas Nama</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="atas_nama" id="atas_nama" placeholder="Atas Nama">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">No Rek</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="norek" id="norek" placeholder="No Rekening">
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0">Aktif</label>
                <div class="col">
                    <label class="form-check form-check-single form-switch">
                        <input class="form-check-input" id="aktif" name="aktif" type="checkbox">
                    </label>
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
        var aktif = $("#aktif").prop('aktif') ? 1 : 0;
        if ($("#kode").val() == '') {
            pesan('Kode harus di isi !', 'error');
            return;
        }
        if ($("#nama_supplier").val() == '') {
            pesan('Nama Supplier harus di isi !', 'error');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'supplier/simpansupplier',
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
                jns_supplier: $("#jns_supplier").val(),
                namabank: $("#namabank").val(),
                atas_nama: $("#atas_nama").val(),
                norek: $("#norek").val(),
                aktif: aktif
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