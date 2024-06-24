<div class="container-xl font-kecil">
    <div class="row">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label">Nama Supplier</label>
                <div class="col">
                    <div class="col input-group mb-0">
                        <input type="text" class="form-control font-kecil" id="carinamasuppliere" name="carinamasuppliere" placeholder="Nama Supplier">
                        <a href="#" id="carinamasupplier" class=" btn font-kecil bg-success text-white" type="button">Cari!</a>
                    </div>
                </div>
            </div>
            <hr class="small p-0 m-1">
            <div class="mb-1 row">
                <div id="table-default" class="table-responsive mb-1">
                    <table class="table datatable6" id="cobasisip">
                        <thead style="background-color: blue !important">
                            <tr>
                                <th>Nama Supplier</th>
                                <th>Alamat</th>
                                <th>Pilih</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                            <tr>
                                <td colspan="3" class="text-center">No Data / Cari dahulu data</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <button type="button" class="btn me-auto btn-sm btn-flat" id="kosongkansupplier">Kosongkan Supplier</button>
    <button type="button" class="btn btn-sm btn-flat text-black" data-bs-dismiss="modal" id="butbatal">Batal</button>
</div>
<script>
    $(document).ready(function() {
        $("#carinamasuppliere").focus();
    })
    $("#carinamasupplier").click(function() {
        if ($("#carinamasuppliere").val() == '') {
            pesan('Isi dahulu keyword pencarian barang', 'info');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'po/getsupplierbyname',
            data: {
                data: $("#carinamasuppliere").val(),
            },
            success: function(data) {
                $("#body-table").html(data.datagroup).show();
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
    $(document).on('click', "#pilihsupplier", function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "po/updatesupplier",
            data: {
                id: $("#id_header").val(),
                rel: $(this).attr('rel'),
                // ket: $("#catatan").val()
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
    $("#kosongkansupplier").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "po/updatesupplier",
            data: {
                id: $("#id_header").val(),
                rel: 'NULL',
                // ket: $("#catatan").val()
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