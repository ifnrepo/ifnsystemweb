<div class="modal-body pt-1 pb-1 mb-1">
    <div class="card card-active">
        <div class="card-body p-2">
            <h4 class="mb-2">Form Input Stok</h4>
            <div id="form-cari">
                <hr class="m-1">
                <div class="d-flex justify-content m-2">
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="cariidbarang" name="radios-filter"  <?php if($this->session->userdata('sel-cari')=='barang'){ echo "checked"; } ?>>
                        <span class="form-check-label font-kecil font-bold">ID Barang</span>
                    </label>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="caripo" name="radios-filter" <?php if($this->session->userdata('sel-cari')=='insnopo'){ echo "checked"; } ?>>
                        <span class="form-check-label font-kecil font-bold">PO</span>
                    </label>
                    <label class="form-check form-check-inline">
                        <input class="form-check-input" type="radio" value="carispek" name="radios-filter" <?php if($this->session->userdata('sel-cari')=='spekbar'){ echo "checked"; } ?>>
                        <span class="form-check-label font-kecil font-bold">Spek Barang</span>
                    </label>
                </div>
                <div class="input-group">
                    <input type="text" class="form-control font-kecil btn-flat text-uppercase" id="keywordinputstok" placeholder="Search for…">
                    <button class="btn btn-blue btn-flat font-kecil" type="button" id="cariinputreg">Cari !</button>
                </div>
            </div>
            <div id="tabelpilih" class="hilang">
                <table class="table table-bordered table-hover m-0 mt-1">
                    <thead class="bg-primary-lt">
                        <tr>
                            <th class="text-black">SKU</th>
                            <th class="text-black">Spek Barang</th>
                            <th class="text-black">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="tabel-body">
                    </tbody>
                </table>
            </div>
            <div id="form-hasilcari" class="hilang">
                <hr class="m-1">
                <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">SKU</label>
                    <div class="col mb-1">
                        <input type="text" class="hilang" name="idbarang" id="idbarang">
                        <input type="text" class="hilang" name="po" id="po">
                        <input type="text" class="hilang" name="item" id="item">
                        <input type="text" class="hilang" name="dis" id="dis">
                        <input type="text" class="hilang" name="dln" id="dln">
                        <input type="text" class="hilang" name="identristok" id="identristok">
                        <input type="text" name="sku" id="sku" class="form-control btn-flat font-bold font-kecil" value="" readonly>
                    </div>
                </div>
                <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">Spek Barang</label>
                    <div class="col mb-1">
                        <!-- <input type="text" name="spek" id="spek" class="form-control btn-flat font-bold font-kecil" value=""> -->
                        <textarea name="spek" id="spek" class="form-control btn-flat font-kecil"></textarea>
                    </div>
                </div>
                <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">Insno</label>
                    <div class="col mb-1">
                        <input type="text" name="insno" id="insno" class="form-control btn-flat font-kecil" value="">
                    </div>
                </div>
                <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">Nomor IB</label>
                    <div class="col mb-1">
                        <input type="text" name="nobontr" id="nobontr" class="form-control btn-flat font-kecil" value="">
                    </div>
                </div>
                <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">Stok/Grade</label>
                    <div class="col mb-1">
                        <select name="stok" id="stok" class="form-control form-select btn-flat font-kecil">
                            <option value="0">Non Grade</option>
                            <option value="1">Grade A</option>
                            <option value="2">Grade B</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">No Bale</label>
                    <div class="col mb-1">
                        <input type="text" name="nobale" id="nobale" class="form-control btn-flat font-kecil" value="">
                    </div>
                </div>
                <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">Eks Netting</label>
                    <div class="col mb-1">
                        <select name="exnet" id="exnet" class="form-control form-select btn-flat font-kecil">
                            <option value="0">Tidak</option>
                            <option value="1">Ya</option>
                        </select>
                    </div>
                </div>
                <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">Nomor BC</label>
                    <div class="col mb-1">
                        <input type="text" name="nomor_bc" id="nomor_bc" class="form-control btn-flat font-bold font-kecil" value="">
                    </div>
                </div>
                <div class="row">
                    <label class="col-3 col-form-label font-kecil font-bold">Keterangan</label>
                    <div class="col mb-1">
                        <input type="text" name="ket" id="ket" class="form-control btn-flat font-bold font-kecil" value="">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal-footer py-0">
    <div class="w-100" id="tombolfootkeluar">
        <div class="row">
            <div class="col text-end">
                <a id="simpanbarang" href="#" class="btn btn-sm btn-primary">
                    Simpan
                </a>
                <a id="oke-batal" href="#" class="btn btn-sm btn-danger" data-bs-dismiss="modal">
                    Batal/Keluar
                </a>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        // $("#keywordinputstok").focus();
        // $(document).getdataById('keywordinputstok').focus();
        setTimeout(() => {
            $("#keywordinputstok").focus();
        }, 500);
    })
    $("#cariinputreg").click(function(){
        var selectradio = $('input[name="radios-filter"]:checked').val();
        var isikeyword = $("#keywordinputstok").val(); 
        $("#cariinputreg").html('<span class="font-kecil"><i class="fa fa-circle-o-notch fa-spin mr-1"></i> Loading !</span>');
        $("#carinputreg").attr('disabled',true);
        var lentext = selectradio=='carinobale' ? 0 : 3;
        if(isikeyword.length > 3){
            if(selectradio=='cariidbarang'){
                // Berdasarkan ID Barang
                $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: base_url + "opname/cariidbarangreg",
                    data: {
                        keyw: isikeyword,
                        dept: $("#currdeptreg").val()
                    },
                    success: function (data) {
                        $("#cariinputreg").html('Cari !');
                        $("#carinputstok").removeClass('disabled');
                        var jumlah = data.jumlah;
                        if(jumlah==0){
                            pesan('Data ID Barang tidak ada pada Saldo Inventory, pastikan penulisan Benar !','error');
                            return false;
                        }else if(jumlah==1){
                            $("#form-hasilcari").removeClass('hilang');
                            $("#form-cari").addClass('hilang');
                            $("#idbarang").val(data.hasil[0]['id']);
                            $("#po").val('');
                            $("#item").val('');
                            $("#dis").val(0);
                            $("#sku").val(data.hasil[0]['kode']);
                            $("#spek").val(data.hasil[0]['nama_barang']);
                            $("#insno").val('');
                            $("#nobontr").val('');
                            $("#dln").val(data.hasil[0]['dln']);
                            $("#keywordinputstok").val('');
                            $("#sku").focus();
                        }else{
                            // alert('Data ada 2 atau lebih');
                            caridouble('caribarang',isikeyword);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }else if(selectradio=='caripo'){
                // Berdasarkan PO atau Instruksi
                $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: base_url + "opname/cariinsnoporeg",
                    data: {
                        keyw: isikeyword,
                        dept: $("#currdeptreg").val()
                    },
                    success: function (data) {
                        $("#cariinputreg").html('Cari !');
                        $("#carinputstok").removeClass('disabled');
                        var jumlah = data.jumlah;
                        if(jumlah==0){
                            pesan('Data PO tidak ada pada Saldo Inventory, pastikan penulisan Benar !','error');
                            return false;
                        }else if(jumlah==1){
                            $("#form-hasilcari").removeClass('hilang');
                            $("#form-cari").addClass('hilang');
                            $("#idbarang").val('0');
                            $("#po").val(data.hasil[0]['po']);
                            $("#item").val(data.hasil[0]['item']);
                            $("#dis").val(data.hasil[0]['dis']);
                            $("#dln").val(data.hasil[0]['dln']);
                            $("#sku").val(data.hasil[0]['skupo']);
                            $("#spek").val(data.hasil[0]['spek']);
                            $("#keywordinputstok").val('');
                            $("#sku").focus();
                        }else{
                            // alert('Data ada 2 atau lebih');
                            // $("#caribarangdouble").attr('rel',data.hasil[0].id_barang);
                            // $("#caribarangdouble").attr('rel2',selectradio);
                            // $("#caribarangdouble").attr('href',base_url+'opname/cari/cariinsnopo/'+$("#deptid").val()+'/'+isikeyword.trim());
                            // $("#caribarangdouble").click();
                            caridouble('caripo',isikeyword);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }else if(selectradio=='carispek'){
                // Berdasarkan Spek Barang
                $.ajax({
                    dataType: "json",
                    type: "POST",
                    url: base_url + "opname/carispekbarangreg",
                    data: {
                        keyw: isikeyword,
                        dept: $("#currdeptreg").val()
                    },
                    success: function (data) {
                        $("#cariinputreg").html('Cari !');
                        $("#carinputstok").removeClass('disabled');
                        var jumlah = data.jumlah;
                        if(jumlah==0){
                            pesan('Data Spek Barang tidak ada pada Saldo Inventory, pastikan penulisan Benar !','error');
                            return false;
                        }else if(jumlah==1){
                            $("#form-hasilcari").removeClass('hilang');
                            $("#form-cari").addClass('hilang');
                            $("#idbarang").val(data.hasil[0]['id']);
                            $("#po").val('');
                            $("#item").val('');
                            $("#dis").val('0');
                            $("#dln").val(data.hasil[0]['dln']);
                            $("#sku").val(data.hasil[0]['kode']);
                            $("#spek").val(data.hasil[0]['nama_barang']);
                            $("#keywordinputstok").val('');
                            $("#sku").focus();
                        }else{
                            // alert('Data ada 2 atau lebih');
                            // $("#caribarangdouble").attr('rel',data.hasil[0].id_barang);
                            // $("#caribarangdouble").attr('rel2',selectradio);
                            // var newStr = isikeyword.replace(" ", "-"); 
                            // $("#caribarangdouble").attr('href',base_url+'opname/cari/carispekbarang/'+$("#deptid").val()+'/'+newStr);
                            // $("#caribarangdouble").click();
                            caridouble('carispek',isikeyword);
                        }
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        console.log(xhr.status);
                        console.log(thrownError);
                    },
                });
            }
        }else{
            $("#cariinputreg").html('Cari !');
            pesan('Keyword pencarian harus lebih dari 3 Huruf','info');
        }
    })
    function caridouble(kod,kata){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "opname/carireg/"+kod,
            data: {
                keyw: kata,
                dept: $("#currdeptreg").val(),
            },
            success: function (data) {
                $("#cariinputreg").html('Cari !');
                $("#carinputreg").removeClass('disabled');
                $("#tabelpilih").removeClass('hilang');
                $("#tabel-body").html(data.hasil).show();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    }
    $('#keywordinputstok').on('keydown', function(e) {
        if (e.key === "Enter") {
            $("#cariinputreg").click();
        }
    });
    $(document).on('click','#pilihbarang',function(){
        var rel1 = $(this).attr('rel1');
        var rel2 = $(this).attr('rel2');
        var rel3 = $(this).attr('rel3');
        var rel4 = $(this).attr('rel4');
        var rel5 = $(this).attr('rel5');
        var rel6 = $(this).attr('rel6');
        var rel7 = $(this).attr('rel7');

        $("#form-cari").addClass('hilang');
        $("#form-hasilcari").removeClass('hilang');

        $("#idbarang").val(rel1);
        $("#po").val(rel4);
        $("#item").val(rel5);
        $("#dis").val(rel6);
        $("#sku").val(rel3);
        $("#spek").val(rel2);
        $("#dln").val(rel7);
        $("#tabelpilih").addClass('hilang');
    })
    $("#simpanbarang").click(function(){
        if($("#idbarang").val()=='' && $("#po").val()==''){
            pesan('Isi data Barang dulu','error');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + "opname/simpanbarangkestokdariopname",
            data: {
                dept: $("#currdeptreg").val(),
                idb: $("#idbarang").val(),
                po: $("#po").val(),
                item: $("#item").val(),
                dis: $("#dis").val(),
                dln: $("#dln").val(),
                insno: $("#insno").val(),
                nobontr: $("#nobontr").val(),
                nobale: $("#nobale").val(),
                stok: $("#stok").val(),
                exnet: $("#exnet").val(),
            },
            success: function (data) {
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            },
        });
    })
</script>