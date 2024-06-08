<div class="container-xl">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Barang</label>
                <div class="col">
                    <input type="text" name="id" id="id" class="hilang" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" name="id_barang" id="id_barang" value="<?= $data['id_barang']; ?>" readonly>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Satuan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="id_satuan" id="id_satuan" value="<?= $data['id_satuan']; ?>" readonly>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Pcs</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="pcs" id="pcs" value="<?= $data['pcs']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Ket</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="keterangan" id="keterangan" value="<?= $data['keterangan']; ?>">
                </div>
            </div>

        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatedata">Update</button>
</div>
<script>
    $("#updatedata").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'bbl/update',
            data: {
                id_barang: $("#id_barang").val(),
                id_satuan: $("#id_satuan").val(),
                pcs: $("#pcs").val(),
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