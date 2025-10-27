<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12">
            <input type="text" class="hilang" name="idheader" id="idheader" value="<?= $idheader; ?>">
            <div class="mb-1 row">
                <label class="col-3 col-form-label">Spek Barang</label>
                <div class="col">
                    <select class="form-select form-sm btn-flat font-kecil" id="seribarangheader">
                        <option value="">Pilih Barang</option>
                        <?php foreach($bahan as $bhn){ ?>
                            <option value="<?= $bhn['seri_barang'] ?>"><?= $bhn['seri_barang'].'. '.$bhn['nama_barang'] ?></option>
                        <?php } ?>
                    </select>
                </div>
            </div>
            <hr class="m-0"> 
            <div class="mb-1 mt-1 row">
                <label class="col-3 col-form-label">Cari Barang</label>
                <div class="col">
                    <div class="input-group mb-2">
                        <input type="text" class="form-control form-sm btn-flat font-kecil bg-primary-lt" id="inputcari" placeholder="Cari Barang …">
                        <a href="#" class="btn btn-sm btn-primary" id="tombolcari">Cari !</a>
                    </div>
                </div>
            </div>
            <div class="col-12 mb-1 mt-1">
                <table class="table w-100 mb-1">
                    <thead style="background-color: blue !important">
                        <tr>
                            <th>No</th>
                            <th>SKU</th>
                            <th>Nama Barang</th>
                            <th>Nomor IB</th>
                            <th>Pilih</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
                        <tr>
                            <td colspan="5" class="text-center">Cari Nama Barang dahulu</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <hr class="small m-0">
            <div class="card mt-1 btn-flat">
                <div class="card-body p-2">
                    <label for="" class="font-bold text-primary mb-1" style="text-decoration: underline;">Data Bahan Baku Dipilih</label>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label text-right">Nama Barang</label>
                        <div class="col">
                            <input type="text" name="idbarang" class="hilang" id="idbarang">
                            <input type="email" class="form-control form-sm btn-flat font-kecil" id="namabarang" aria-describedby="emailHelp" placeholder="Nama Barang">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label text-right">Nomor IB</label>
                        <div class="col">
                            <input type="email" class="form-control form-sm btn-flat font-kecil" id="nobontr" aria-describedby="emailHelp" placeholder="Nomor Penerimaan">
                        </div>
                    </div>
                    <div class="mb-1 row hilang">
                        <label class="col-3 col-form-label text-right">Pcs</label>
                        <div class="col">
                            <input type="email" class="form-control form-sm btn-flat font-kecil" id="jmpcs" aria-describedby="emailHelp" placeholder="Pcs">
                        </div>
                    </div>
                    <div class="mb-1 row">
                        <label class="col-3 col-form-label text-right">Kgs</label>
                        <div class="col">
                            <input type="email" class="form-control form-sm btn-flat font-kecil" id="jmkgs" aria-describedby="emailHelp" placeholder="Kgs">
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-2 px-4 mb-2">
                <a href="#" class="btn btn-sm btn-primary btn-flat" id="simpanbahanbaku">Simpan Bahan Baku</a>
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
        if(inpcari.trim()!=''){
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url+'akb/caribahanbaku',
                data: { 
                    kode : inpcari
                },
                success: function(data){
                    if(data.datagroup.length > 0){
                        $("#body-table").html(data.datagroup).show();
                    }else{
                        $("#body-table").html('<td colspan="5" class="text-center text-teal">Pencarian barang tidak ditemukan</td>').show();
                    }
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            })
        }else{
            pesan('Isi kriteria pencarian barang','info');
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
            pesan('Barang harus di isi terlebih dahulu','error');
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