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
                <label class="col-3 col-form-label required">Kab_Kota</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kab_kota" id="kab_kota" placeholder="Kab/Kota" value="<?= $data['kab_kota']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Provinsi</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="propinsi" id="propinsi" placeholder="Provinsi" value="<?= $data['propinsi']; ?>">
                </div>
            </div>

            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode Pos</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kodepos" id="kodepos" placeholder="Kode Pos" value="<?= $data['kodepos']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Npwp</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil  bg-warning-lt font-hitam" name="npwp" id="npwp" placeholder="Npwp" value="<?= $data['npwp']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">NIK</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil bg-warning-lt font-hitam" title="Nomor Induk Kependudukan" name="nik" id="nik" placeholder="NIK" value="<?= $data['nik']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Telp</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="telp" id="telp" placeholder="Telp" value="<?= $data['telp']; ?>">
                </div>
            </div>
        </div>
        <div class="col-6">


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
                    <textarea class="form-control font-kecil" name="keterangan" rows="3" id="keterangan" value="<?= $data['keterangan']; ?>"> </textarea>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jenis Suplier</label>
                <div class="col">
                    <select class="form-select" name="jns_supplier" id="jns_supplier" aria-label="Default select example">
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
                    <input type="text" class="form-control font-kecil" name="namabank" id="namabank" value="<?= $data['namabank']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Atas Nama</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="atas_nama" id="atas_nama" value="<?= $data['atas_nama']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">No Rek</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="norek" id="norek" value="<?= $data['norek']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Jenis PKP</label>
                <div class="col">
                    <select class="form-select" name="jns_pkp" id="jns_pkp" aria-label="Default select example">
                        <option value="0" selected>-</option>
                        <option value="1" <?= ($data['jns_pkp'] == 1) ? 'selected' : ''; ?>>PERSEORANGAN</option>
                        <option value="2" <?= ($data['jns_pkp'] == 2) ? 'selected' : ''; ?>>PKP</option>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode Negara</label>
                <div class="col">
                    <select name="kode_negara" id="kode_negara" class="form-select">
                        <option value=""></option>
                        <?php foreach ($negara as $key) : ?>
                            <?php if ($key['kode_negara'] == $data['kode_negara']) : ?>
                                <option value="<?= $key['kode_negara']; ?>" selected><?= $key['uraian_negara']; ?></option>
                            <?php else : ?>
                                <option value="<?= $key['kode_negara']; ?>"><?= $key['uraian_negara']; ?></option>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0">Aktif</label>
                <div class="col">
                    <label class="form-check form-check-single form-switch">
                        <input class="form-check-input" id="aktif" name="aktif" type="checkbox" <?php if ($data['aktif'] == 1) echo 'checked'; ?>>
                    </label>
                </div>
            </div>
        </div>
        <div class="card mb-2">
            <div class="card-body font-kecil p-1">
                <div class="bg-primary-lt p-1 font-bold text-black">Data di CEISA/BC</div>
                <div class="mb-1 mt-1 row">
                    <label class="col-3 col-form-label">Nama</label>
                    <div class="col">
                        <input type="text" class="form-control font-kecil btn-flat" name="nama_di_ceisa" id="nama_di_ceisa" value="<?= $data['nama_di_ceisa']; ?>" placeholder="Nama">
                    </div>
                </div>
                <div class="mb-1 row">
                    <label class="col-3 col-form-label">Alamat</label>
                    <div class="col">
                        <textarea class="form-control font-kecil btn-flat" name="alamat_di_ceisa" id="alamat_di_ceisa" placeholder="Alamat"><?= $data['alamat_di_ceisa']; ?></textarea>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto font-kecil btn-flat" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary font-kecil btn-flat" id="updatesupplier">Update</button>
</div>
<script>
    $("#updatesupplier").click(function() {
        var aktif = $("#aktif").prop('checked') ? 1 : 0;
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
                jns_supplier: $("#jns_supplier").val(),
                namabank: $("#namabank").val(),
                atas_nama: $("#atas_nama").val(),
                norek: $("#norek").val(),
                nik: $("#nik").val(),
                jns_pkp: $("#jns_pkp").val(),
                kode_negara: $("#kode_negara").val(),
                namaceisa: $("#nama_di_ceisa").val(),
                alamatceisa: $("#alamat_di_ceisa").val(),
                aktif: aktif,
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