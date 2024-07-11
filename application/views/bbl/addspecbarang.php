<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12">
            <div class="mb-1 row">
                <!-- <label class="col-3 col-form-label required font-kecil">Keyword</label> -->
                <div class="col-3">
                    <!-- <select class="form-control btn-flat form-select font-kecil bg-success text-white font-bold" id="deptselect">
                        <option value="">All Dept</option>
                    </select> -->
                    <input type="text" class="form-control btn-flat bg-danger font-bold text-center text-white" id="deptselect" value="">
                </div>
                <div class="col input-group">
                    <input type="text" class="form-control font-kecil inputangka" name="keyw" id="keyw" placeholder="Cari Nama Barang..">
                    <a href="#" class="btn font-kecil bg-success text-white" id="getbarang">Get!</a>
                </div>
            </div>
            <div class="hr m-1"></div>
            <div id="table-default" class="table-responsive mb-1">
                <table class="table datatable6" id="cobasisip">
                    <thead style="background-color: blue !important">
                        <tr>
                            <th>No Dok</th>
                            <th>Nama Barang</th>
                            <!-- <th>Keterangan</th> -->
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
        // $('#modal-scroll').on('shown.bs.modal', function() {
        //     // $('#textareaID').focus();
        //     $("#keyw").focus();
        // })
        // $("#keyw").val($("#nomor_dok").val());
        // if ($("#keyw").val() != '') {
        //     $("#getbarang").click();
        // }
        $("#getbarang").click();
        $("#deptselect").val($("#xdeptselect").val());
    });
    $("#deptselect").change(function(){
        $("#getbarang").click();
    })
    $("#keyw").on('keyup', function(e) {
        if (e.key === 'Enter' || e.keyCode === 13) {
            $("#getbarang").click();
        }
    });

    $("#getbarang").click(function() {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: '<?= base_url('bbl/getspecbarang') ?>',
            data: {
                data: $("#keyw").val(),
                header: $("#id_header").val(),
                dept: $("#xdeptselect").val()
            },
            success: function(data) {
                console.log(data); // Log data yang diterima
                if (data.datagroup) {
                    $("#body-table").html(data.datagroup).show();
                    // $("#deptselect").html(data.dataselect).show();
                } else {
                    pesan('Tidak ada data yang ditemukan','info');
                    $("#body-table").html('').hide();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    });
</script>