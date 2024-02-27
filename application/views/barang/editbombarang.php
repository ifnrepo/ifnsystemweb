<div class="container-xl"> 
    <div class="row font-kecil">
        <div class="col-12">
            <input type="hidden" value="<?= $detail['id']; ?>" name="id" id="id">
            <input type="hidden" value="<?= $detail['id_barang'] ?>" name="id_barang" id="id_barang">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Barang</label>
                <div class="col"> 
                    <select class="form-select font-kecil" id="id_barang_bom" name="id_barang_bom">
                        <option value="">--Pilih Barang--</option>
                        <?php foreach ($barang->result_array() as $barang) { $selek = $detail['id_barang_bom']==$barang['id'] ? 'selected' : ''; ?>
                            <option value="<?= $barang['id']; ?>" <?= $selek; ?>><?= $barang['nama_barang']; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka" name="persen" id="persen" placeholder="%" value="<?= $detail['persen']; ?>" >
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
        // document.addEventListener("DOMContentLoaded", function () {
        new TomSelect("#id_barang_bom",{
            create: false,
            sortField: {
                field: "text",
                direction: "asc"
            },
            allowEmptyOption: true
        });
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
        if($("#id_barang_bom").val() == ''){
            pesan('Nama Barang harus di isi !','error');
            return;
        }
        if($("#persen").val() == '' || $("#persen").val()==0){
            pesan('Persem harus di isi !','error');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'barang/updatebombarang',
            data: {
                id_barang: $("#id_barang").val(),
                id_bbom: $("#id_barang_bom").val(),
                psn: toAngka($("#persen").val()),
                id: $("#id").val()
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