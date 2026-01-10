<div class="container-xl font-kecil">
    <div class="mb-1 row">
        <label class="col-3 col-form-label required font-kecil">Nomor BBL</label>
        <div class="col input-group">
            <input type="text" class="form-control font-kecil inputangka text-uppercase" name="keyw" id="keyw" placeholder="Cari.." >
            <a href="#" class="btn font-kecil bg-success text-white" id="getbarang">Get!</a>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <div id="table-default" class="table-responsive mb-1">
                <table class="table datatable6" id="cobasisip">
                    <thead style="background-color: blue !important">
                        <tr>
                            <th>Bon BBL</th>
                            <th>Bon PB</th>
                            <th>Nama Barang</th>
                            <th>Noted</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                        <tr>
                            <td colspan="5" class="text-center">-- Cari Nomor BBL --</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil">
    <a href="#" class="btn btn-sm btn-primary" id="simpanbarang">Simpan Barang</a>
</div>
<script>
    $(document).ready(function(){
        // alert('Cek');
        // $("#getbarang").click();
    });
    $("#keyw").on('keyup',function(e){
        if(e.key == 'Enter' || e.keycode === 13){
            $("#getbarang").click();
        }
    })
    $("#getbarang").click(function(){
        $("#getbarang").html("<i class='fa fa-circle-o-notch fa-spin mr-2'></i> Loading")
         $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'po/getdetailbarangpo',
            data: {
                // mode: $("#cari_by").val(),
                data: $("#keyw").val(),
            },
            success: function(data){
                $("#body-table").html(data.datagroup).show();
                $("#getbarang").html("Get!")
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    });
    $("#simpanbarang").click(function(){
        var text = [];
        for (let i = 1; i < 1000; i++) {
            if($("#cekbok"+i).is(":checked")){
                text.push($("#cekbok"+i).attr('rel'));
            }
        }
        if(text.length > 0){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url + "po/adddetailpo",
                data: {
                    id: $("#id_header").val(),
                    brg: text
                },
                success: function(data) {
                    // alert('berhasil');
                    window.location.href = base_url + "po/datapo/" + $("#id_header").val();
                    // $("#butbatal").click();
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            })
        }else{
            pesan('Tidak ada data yang dipilih','info');
            window.location.reload();
        }
    })
</script>