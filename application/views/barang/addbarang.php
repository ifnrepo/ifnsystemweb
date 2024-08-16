<div class="container-xl"> 
    <div class="row font-kecil">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kode" id="kode" placeholder="Kode" value="<?= $kode; ?>">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Barang</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="nama_barang" id="nama_barang" placeholder="Nama Barang">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori</label>
                <div class="col"> 
                    <select class="form-select font-kecil" id="id_kategori" name="id_kategori">
                        <option value="">--Pilih Kategori--</option>
                        <?php foreach ($itemkategori as $kategori) { ?>
                            <option value="<?= $kategori['kategori_id']; ?>"><?= '['.$kategori['kategori_id'].'] '.$kategori['nama_kategori']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Satuan</label>
                <div class="col">
                    <select class="form-select font-kecil" id="id_satuan" name="id_satuan">
                        <option value="">--Pilih Satuan--</option>
                        <?php foreach ($itemsatuan->result_array() as $satuan) { ?>
                            <option value="<?= $satuan['id']; ?>"><?= '['.$satuan['kodesatuan'].'] '.$satuan['namasatuan']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="dln" name="dln" type="checkbox">
                        <span class="form-check-label">DLN</span>
                    </label>
                </div>
            </div>
            <div class="row mt-2">
                <label class="col-3 col-form-label pt-0"></label>
                <div class="col">
                    <label class="form-check">
                        <input class="form-check-input" id="noinv" name="noinv" type="checkbox">
                        <span class="form-check-label">No INV</span>
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
    <button type="button" class="btn btn-primary" id="simpanbarang" >Simpan</button>
</div>
<script>
    $(document).ready(function(){
        $("#nama_barang").focus();
    })
    $("#simpanbarang").click(function(){
        var x = $("#dln").prop('checked') ? 1 : 0;
        var y = $("#noinv").prop('checked') ? 1 : 0;
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
            url: base_url+'barang/simpanbarang',
            data: {
                kode: $("#kode").val(),
                nama: $("#nama_barang").val(),
                sat: $("#id_satuan").val(),
                kat: $("#id_kategori").val(),
                noinv: y,
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