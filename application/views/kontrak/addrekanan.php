<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12">
            <input type="text" class="hilang" name="idheader" id="idheader" value="">
            <div class="mb-1 mt-1 row">
                <label class="col-3 col-form-label">Cari Nama Rekanan</label>
                <div class="col">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control form-sm btn-flat font-kecil bg-primary-lt" id="inputcari" placeholder="Cari Nama Rekanan">
                        <a href="#" class="btn btn-sm btn-primary" id="tombolcari">Cari !</a>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-1 mt-1">
                <table class="table w-100 mb-1">
                    <thead style="background-color: blue !important">
                        <tr>
                            <th>No</th>
                            <th>Nama Rekanan</th>
                            <th>Kode</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
                        <tr>
                            <td colspan="4" class="text-center">Cari Nama Rekanan dahulu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr class="small m-0">
            <div class="text-center mt-2 px-4 mb-2">
                <a href="#" class="btn btn-sm btn-primary btn-flat" id="simpanbahanbaku">Tambah Data Kontrak</a>
                <a href="#" class="btn btn-sm btn-danger btn-flat" data-bs-dismiss="modal">Batal/Keluar</a>
            </div>
        </div>
    </div>
</div>


<script>
    $(document).ready(function() {

    });
    $(document).on('click','#tombolcari',function(){
        var inpcari = $("#inputcari").val();
        if(inpcari.replaceAll(' ','').length > 2){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url+'kontrak/carisupplier',
                data: { 
                    kode : inpcari
                },
                success: function(data){
                    if(data.datagroup.length > 0){
                        $("#body-table").html(data.datagroup).show();
                    }else{
                        $("#body-table").html('<td colspan="4" class="text-center text-teal">- Rekanan tidak ditemukan -</td>').show();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }           
            });
        }else{
            pesan('Minimal 3 Huruf untuk pencarian','info');
        }
    });
    $(document).on('click','#tombolpilih',function(){
        var x = $(this).attr('rel');
        var y = $(this).attr('rel2');
        var z = $(this).attr('rel3');

        $("#idbarang").val(x);
        $("#nobontr").val(y);
        $("#namabarang").val(z);

        $("#body-table").html('<td colspan="5" class="text-center text-teal">Siap Simpan</td>').show();

    })
    $("#simpanbahanbaku").click(function(){
        var barang = $("#seribarangheader").val();
        if(barang.trim() == ""){
            pesan('Spek Barang harus di Pilih terlebih dahulu','error');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'akb/simpanbahanbaku',
            data: {
                id: $("#idheader").val(),
                idbarang : $("#idbarang").val(),
                seri : $("#seribarangheader").val(),
                bontr : $("#nobontr").val(), 
                pcs : $("#jmpcs").val(), 
                kgs : $("#jmkgs").val(), 
            },
            success: function(data){
                $('#modal-large-loading').modal('hide');
                pesan('Barang berhasil disimpan, refresh halaman untuk melihat hasil','success');
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
  
</script>