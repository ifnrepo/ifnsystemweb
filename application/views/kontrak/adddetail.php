<div class="container-xl font-kecil">
    <input type="text" class="hilang" name="id_kontrak" id="id_kontrak" value="<?= $idkontrak; ?>">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori</label>
                <div class="col">
                    <select class="form-control form-select font-kecil" id="kode_kategori" name="kode_kategori">
                        <option value="">-- Pilih Kategori --</option>
                        <option value="04">BAHAN BAKU</option>
                        <option value="05">ALAT BANTU KERJA</option>
                        <option value="06">ALAT BANTU ANGKUT</option>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Uraian</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="uraian" id="uraian" placeholder="Uraian">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Hs Code</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="hscode" id="hscode" placeholder="HS Code">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Pcs</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka text-right" name="pcskontrak" id="pcskontrak" placeholder="Qty">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kgs</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka text-right" name="kgskontrak" id="kgskontrak" placeholder="Kgs">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm" id="butbatal" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-success btn-sm text-black" id="buatpb">Simpan Transaksi</button>
</div>
<script>
    $(document).ready(function(){

    })
    $(".inputangka").on("change click keyup input paste", function (event) {
        $(this).val(function (index, value) {
            return value
                .replace(/(?!\.)\D/g, "")
                .replace(/(?<=\..*)\./g, "")
                .replace(/(?<=\.\d\d\d\d).*/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
    $("#buatpb").click(function() {
       if($("#kode_kategori").val() == ""){
        pesan('Pilih kode kategori','info');
        return false;
       }
       if($("#uraian").val() == ""){
        pesan('Isi Uraian','info');
        return false;
       }
       if($("#hscode").val() == ""){
        pesan('Isi Hs Code','info');
        return false;
       }
       if (
		($("#pcskontrak").val() == "" || $("#pcskontrak").val() == "0" || $("#pcskontrak").val().trim() == "-") &&
		($("#kgskontrak").val() == "" || $("#kgskontrak").val() == "0" || $("#kgskontrak").val().trim() == "-")
        ) {
            pesan("Pcs / Kgs Kosong", "info");
            return false;
        }
        // document.formdetailkontrak.submit();
        $.ajax({
            // dataType: "json",
            type: "POST",
            url: base_url + "kontrak/simpandetailkontrak",
            data: {
                id_kontrak: $("#id_kontrak").val(),
                kode_kategori: $("#kode_kategori").val(),
                kategori: $("#kode_kategori option:selected").text(),
                hscode: $("#hscode").val(),
                uraian: $("#uraian").val(),
                pcs: $("#pcskontrak").val(),
                kgs: $("#kgskontrak").val(),
            },
            success: function (data) {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
</script>