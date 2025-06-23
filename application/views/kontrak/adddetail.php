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
                    <input type="text" class="form-control font-kecil inputangka text-right" name="pcs" id="pcs" placeholder="Qty">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kgs</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka text-right" name="kgs" id="kgs" placeholder="Kgs">
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
		($("#pcs").val() == "" || $("#pcs").val() == "0") &&
		($("#kgs").val() == "" || $("#kgs").val() == "0")
        ) {
            pesan("Pcs / Kgs Kosong", "info");
            return false;
        }
    })
</script>