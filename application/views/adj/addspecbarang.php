<div class="container-xl"> 
    <div class="row font-kecil">
        <div class="col-12">
            <div class="mb-1 row">
                <label class="col-3 col-form-label required font-kecil">Cari Berdasarkan</label>
                <div class="col"> 
                    <select class="form-select font-kecil" id="cari_by" name="cari_by">
                        <option value="0">Specific</option>
                        <option value="1">ID</option>
                        <option value="2">PO</option>
                    </select>
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required font-kecil">Keyword</label>
                <div class="col input-group">
                    <input type="text" class="form-control font-kecil inputangka" name="keyw" id="keyw" placeholder="Cari.." >
                    <a href="#" class="btn font-kecil bg-success text-white" id="getbarang">Get!</a>
                </div>
            </div>
            <div class="hr m-1"></div>
            <div id="table-default" class="table-responsive mb-1">
              <table class="table datatable6" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Satuan</th>
                    <th>Pilih</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
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
    <!-- <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button> -->
    <!-- <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal" id="keluarform">Keluar</button> -->
</div>
<script>
    $(document).ready(function(){
        var pilih = $('input[name = "radios-inline"]:checked').val();
        $("#cari_by").val(pilih);
        $("#keyw").focus();
        $("#keyw").val($("#nama_barang").val());
        if($("#keyw").val() != ''){
            $("#getbarang").click();
        }
    })
    $("#keyw").on('keyup',function(e){
        if(e.key == 'Enter' || e.keycode === 13){
            $("#getbarang").click();
        }
    })
    $("#getbarang").click(function(){
        if($("#keyw").val() == ''){
            pesan('Isi dahulu keyword pencarian barang','info');
            return;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'adj/getspecbarang',
            data: {
                mode: $("#cari_by").val(),
                data: $("#keyw").val(),
            },
            success: function(data){
                $("#body-table").html(data.datagroup).show();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
    $(document).on('click','.pilihbarang',function(){
        var pilih = $("#cari_by").val();
        if(pilih < 2){
            var x = $(this).attr('rel1');
            var y = $(this).attr('rel2');
            var z = $(this).attr('rel3');
            $("#nama_barang").val(x);
            $("#id_barang").val(y);
            $("#id_satuan").val(z)
            $("#pcs").focus();
        }else{
            var x = $(this).attr('rel2');
            $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'adj/getdatapo',
            data: {
                data: x,
            },
            success: function(data){
                // alert(data['sku']);
                $("#nama_barang").val(data['sku']);
                $("#po").val(data['po']);
                $("#item").val(data['item'])
                $("#dis").val(data['dis'])
                $("#id_satuan").val('21')
                $("#pcs").focus();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
        }
        $("#modal-scroll").modal('hide');
    })
    // $("#simpanbarang").click(function(){
        // if($("#id_barang_bom").val() == ''){
        //     pesan('Nama Barang harus di isi !','error');
        //     return;
        // }
        // if($("#persen").val() == '' || $("#persen").val()==0){
        //     pesan('Persem harus di isi !','error');
        //     return;
        // }
        // $.ajax({
        //     dataType: "json",
        //     type: "POST",
        //     url: base_url+'barang/simpanbombarang',
        //     data: {
        //         id_barang: $("#id_barang").val(),
        //         id_bbom: $("#id_barang_bom").val(),
        //         psn: toAngka($("#persen").val())
        //     },
        //     success: function(data){
        //         window.location.reload();
        //     },
        //     error: function (xhr, ajaxOptions, thrownError) {
        //         console.log(xhr.status);
        //         console.log(thrownError);
        //     }
        // })
    // })
</script>