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
                    <input type="text" class="form-control font-kecil" aria-label="Text input" placeholder="Nama Barang" value="<?= $data['pcs']; ?>" readonly>
                </div>
            </div>
            <div class="row mt-1">
                <label class="col-3 col-form-label">Satuan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" aria-label="Text input" placeholder="Nama Barang" value="<?= $data['namasatuan']; ?>" readonly>
                </div>
            </div>
            <div class="row mt-1">
                <label class="col-3 col-form-label">Harga / Satuan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka" id="harga" placeholder="Harga" value="<?php if($data['harga']!=0) { echo rupiah($data['harga'],2); } ?>" autocomplete="off">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil mt-1">
    <a href="#" class="btn btn-sm btn-primary" id="simpanharga">Simpan</a>
    <a href="#" class="btn btn-sm" id="batal" data-bs-dismiss="modal">Batal / Keluar</a>
</div>
<script>
    $(document).ready(function(){
        $("#harga").focus();
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
    $("#simpanharga").click(function(){
        if($("#harga").val()==''){
            pesan('Harga barang satuan mohon diisi','info');
            return false;
        }
        $.ajax({
		// dataType: "json",
		type: "POST",
		url: base_url + "po/updatehargadetail",
		data: {
			id: $("#iddetail").val(),
            harga: toAngka($("#harga").val())
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