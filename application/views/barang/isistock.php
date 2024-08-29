<div class="container-xl"> 
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode" value="<?= $data['kode']; ?>" disabled>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Barang</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="nama_barang" id="nama_barang" placeholder="Nama Barang" value="<?= $data['nama_barang']; ?>" disabled>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori</label>
                <div class="col"> 
                    <select class="form-select font-kecil" id="id_kategori" name="id_kategori" disabled>
                        <option value="">--Pilih Kategori--</option>
                        <?php foreach ($itemkategori as $kategori) { $selek = $kategori['kategori_id']==$data['id_kategori'] ? 'selected' : ''; ?>
                            <option value="<?= $kategori['kategori_id']; ?>" <?= $selek; ?>><?= '['.$kategori['kategori_id'].'] '.$kategori['nama_kategori']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Satuan</label>
                <div class="col">
                    <select class="form-select font-kecil" id="id_satuan" name="id_satuan" disabled>
                        <option value="">--Pilih Satuan--</option>
                        <?php foreach ($itemsatuan->result_array() as $satuan) { $selek = $satuan['id']==$data['id_satuan'] ? 'selected' : ''; ?>
                            <option value="<?= $satuan['id']; ?>" <?= $selek; ?>><?= '['.$satuan['kodesatuan'].'] '.$satuan['namasatuan']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row mt-0">
                <div class="col-3"></div>
                <div class="col">
                    <div class="row">
                        <div class="col-6">
                            <label class="col-3 col-form-label pt-0"></label>
                            <div class="col">
                                <label class="form-check">
                                    <input class="form-check-input" id="dln" name="dln" type="checkbox" <?php if($data['dln']==1){ echo 'checked'; } ?> disabled>
                                    <span class="form-check-label">DLN</span>
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <label class="col-3 col-form-label pt-0"></label>
                            <div class="col">
                                <label class="form-check">
                                    <input class="form-check-input" id="noinv" name="noinv" type="checkbox" <?php if($data['noinv']==1){ echo 'checked'; } ?>>
                                    <span class="form-check-label">No INV</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Safety</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka text-right" name="safety_stock" id="safety_stock" placeholder="Safety Stock" value="<?= rupiah($data['safety_stock'],2); ?>" >
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" id="tutupmodal" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatebarang" >Simpan</button>
</div>
<script>
    $(document).ready(function(){
        $("#safety_stock").focus();
        $(".inputangka").on("change click keyup input paste", function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/(?!\.)\D/g, "")
                    .replace(/(?<=\..*)\./g, "")
                    .replace(/(?<=\.\d\d).*/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
    })
    $("#updatebarang").click(function(){
        alert(toAngka($("#safety_stock").val()));
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'barang/updatestock',
            data: {
                id: $("#id").val(),
                safety: toAngka($("#safety_stock").val())
            },
            success: function(data){
                // window.location.reload();
                $("#tutupmodal").click();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>