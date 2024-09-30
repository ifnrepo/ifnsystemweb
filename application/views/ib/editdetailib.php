<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="row">
                <label class="col-3 col-form-label">Nama Barang</label>
                <div class="col">
                    <input type="hidden" id="iddetail" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" aria-label="Text input" placeholder="Nama Barang" value="<?= $data['nama_barang']; ?>" readonly>
                </div>
            </div>
            <div class="row mt-1">
                <label class="col-3 col-form-label">SKU</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" aria-label="Text input" placeholder="Nama Barang" value="<?= $data['brg_id']; ?>" readonly>
                </div>
            </div>
            <div class="row mt-1">
                <label class="col-3 col-form-label">Qty</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka" id="pcs" aria-label="Text input" placeholder="Jumlah Barang" value="<?= rupiah($data['pcs'],0); ?>">
                    <input type="hidden" class="form-control font-kecil inputangka" id="xpcs" aria-label="Text input" placeholder="Jumlah Barang" value="<?= rupiah($data['pcs'],0); ?>">
                </div>
            </div>
            <div class="row mt-1">
                <label class="col-3 col-form-label">Kgs</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka" id="kgs" aria-label="Text input" placeholder="Kgs Barang" value="<?= rupiah($data['kgs'],2); ?>">
                </div>
            </div>
            <div class="row mt-1">
                <label class="col-3 col-form-label">Satuan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" aria-label="Text input" placeholder="Satuan Barang" value="<?= $data['namasatuan']; ?>" readonly>
                </div>
            </div>
            <?php $hilang = $data['jn_ib']==0 ? 'hilang' : ''; ?>
            <div class="row mt-1 <?= $hilang; ?>">
                <label class="col-3 col-form-label">Harga Satuan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka text-right" id="harga" aria-label="Text input" placeholder="Harga Barang" value="<?= rupiah($data['harga'],2); ?>">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil mt-1">
    <button href="#" class="btn btn-sm btn-primary" id="simpanedit">Simpan</button>
    <a href="#" class="btn btn-sm" id="batal" data-bs-dismiss="modal">Batal / Keluar</a>
</div>
<script>
    $(document).ready(function(){
    })
    $(".inputangka").on("change click keyup input paste", function (event) {
        $(this).val(function (index, value) {
            return value
                .replace(/(?!\.)\D/g, "")
                .replace(/(?<=\..*)\./g, "")
                .replace(/(?<=\.\d\d).*/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
    $("#simpanedit").click(function(){
        // alert('ADA');
        if(($("#pcs").val()=='' || $("#pcs").val() =='0') && ($("#kgs").val()=='' || $("#kgs").val() =='0')){
            pesan('Qty/Berat barang satuan mohon diisi','info');
            return false;
        }
        $.ajax({
            // dataType: "json",
            type: "POST",
            url: base_url + "ib/updatepcskgs",
            data: {
                id: $("#iddetail").val(),
                pcs : toAngka($("#pcs").val()),
                kgs : toAngka($("#kgs").val()),
                hrg : toAngka($("#harga").val()),
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