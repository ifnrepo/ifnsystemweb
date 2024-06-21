<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12">

            <div class="mb-1 row">
                <label class="col-3 col-form-label required font-kecil">Keyword</label>
                <div class="col input-group">
                    <input type="text" class="form-control font-kecil inputangka" name="keyw" id="keyw" placeholder="Cari..">

                    <a href="#" class="btn font-kecil bg-success text-white" id="getbarang">Get!</a>
                </div>
            </div>
            <div class="hr m-1"></div>
            <div id="table-default" class="table-responsive mb-1">
                <table class="table datatable6" id="cobasisip">
                    <thead style="background-color: blue !important">
                        <tr>
                            <th>id</th>
                            <th>No Dok</th>
                            <th>Departemen</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                        <tr>
                            <td colspan="4" class="text-center">No Data / Cari dahulu data</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer">
</div>


<script>
    $(document).ready(function() {
        $("#keyw").focus();
        $("#keyw").val($("#nomor_dok").val());
        if ($("#keyw").val() != '') {
            $("#getbarang").click();
        }

        $("#keyw").on('keyup', function(e) {
            if (e.key === 'Enter' || e.keyCode === 13) {
                $("#getbarang").click();
            }
        });

        $("#getbarang").click(function() {
            if ($("#keyw").val() == '') {
                alert('Isi dahulu keyword pencarian barang');
                return;
            }
            $.ajax({
                dataType: "json",
                type: "POST",
                url: '<?= base_url('bbl/getspecbarang') ?>',
                data: {
                    data: $("#keyw").val()
                },
                success: function(data) {
                    console.log(data); // Log data yang diterima
                    if (data.datagroup) {
                        $("#body-table").html(data.datagroup).show();
                    } else {
                        alert('Tidak ada data yang ditemukan');
                        $("#body-table").html('').hide();
                    }
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            });
        });

    });
</script>