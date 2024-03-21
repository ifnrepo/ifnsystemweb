<div class="container-xl"> 
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="hidden" name="id" id="id" value="<?= $data['id']; ?>">
                    <input type="text" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode" value="<?= $data['kode']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Barang</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="nama_barang" id="nama_barang" placeholder="Nama Barang" value="<?= $data['nama_barang']; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori</label>
                <div class="col"> 
                    <select class="form-select font-kecil" id="id_kategori" name="id_kategori">
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
                    <select class="form-select font-kecil" id="id_satuan" name="id_satuan">
                        <option value="">--Pilih Satuan--</option>
                        <?php foreach ($itemsatuan->result_array() as $satuan) { $selek = $satuan['id']==$data['id_satuan'] ? 'selected' : ''; ?>
                            <option value="<?= $satuan['id']; ?>" <?= $selek; ?>><?= '['.$satuan['kodesatuan'].'] '.$satuan['namasatuan']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="dln" name="dln" type="checkbox" <?php if($data['dln']==1){ echo 'checked'; } ?>>
                        <span class="form-check-label">DLN</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="updatebarang" >Simpan</button>
</div>
<script>
    $(document).ready(function(){
        $("#nama_barang").focus();
    })
    $("#updatebarang").click(function(){
        var x = $("#dln").prop('checked') ? 1 : 0;
        if($("#kode").val() == ''){
            pesan('Kode harus di isi !','error');
            return;
        }
        if($("#nama_barang").val() == ''){
            pesan('Nama Barang harus di isi !','error');
            return;
        }
        if($("#id_satuan").val() == ''){
            pesan('Satuan harus di isi !','error');
            return;
        }
        if($("#id_kategori").val() == ''){
            pesan('Kategori harus di isi !','error');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'barang/updatebarang',
            data: {
                kode: $("#kode").val(),
                nama: $("#nama_barang").val(),
                sat: $("#id_satuan").val(),
                kat: $("#id_kategori").val(),
                id: $("#id").val(),
                dln: x
            },
            success: function(data){
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>