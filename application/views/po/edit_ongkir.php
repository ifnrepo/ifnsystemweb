<div class="container-xl font-kecil">
    <input type="text" id="id_headerx" class="hilang">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label">Keterangan Additional</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="xketongkir_jasa" id="xketongkir_jasa" placeholder="Keterangan Additional" value="">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label">Jumlah</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka text-right" name="xongkir_jasa" id="xongkir_jasa" placeholder="Jumlah Additional" value="">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm btn-flat" id="butbatal" data-bs-dismiss="modal">Batal</button>
    <button type="button" class="btn btn-danger btn-sm btn-flat text-white" id="kosongkan">Kosongkan Additional</button>
    <button type="button" class="btn btn-success btn-sm btn-flat text-black" id="simpanadditional">Simpan</button>
</div>
<script>
    $(document).ready(function() {
        $(".inputangka").on("change click keyup input paste", function (event) {
            $(this).val(function (index, value) {
                return value
                    .replace(/(?!\.)\D/g, "")
                    .replace(/(?<=\..*)\./g, "")
                    .replace(/(?<=\.\d\d\d\d\d\d\d).*/g, "")
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            });
        });
        $("#xketongkir_jasa").val($("#ketongkir_jasa").text());
        $("#xongkir_jasa").val($("#ongkir_jasa").val());
        $("#id_headerx").val($("#id_header").val());
    })
    $("#kosongkan").click(function(){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "po/updateadditional",
            data: {
                id: $("#id_headerx").val(),
                addi: '',
                jumaddi: 0
            },
            success: function(data) {
                // alert('berhasil');
                window.location.href = base_url + "po/datapo/" + $("#id_header").val();
                $("#butbatal").click();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
    $("#simpanadditional").click(function() {
        var ketaddi = $("#xketongkir_jasa").val();
        if(ketaddi.trim() == ''){
            pesan('Keterangan Additional harus di isi','info');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "po/updateadditional",
            data: {
                id: $("#id_headerx").val(),
                addi: $("#xketongkir_jasa").val(),
                jumaddi: $("#xongkir_jasa").val()
            },
            success: function(data) {
                // alert('berhasil');
                window.location.href = base_url + "po/datapo/" + $("#id_header").val();
                $("#butbatal").click();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>