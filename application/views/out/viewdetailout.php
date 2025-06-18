<div class="container-xl"> 
    <div class="card-header font-kecil">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
            <li class="nav-item">
            <a href="#tabs-home-8" class="nav-link bg-teal-lt active btn-flat" data-bs-toggle="tab">View Dokumen</a>
            </li>
            <li class="nav-item">
            <a href="#tabs-profile-8" class="nav-link bg-red-lt btn-flat" data-bs-toggle="tab">Riwayat Dokumen</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade active show p-2" id="tabs-home-8">
                <div class="row mb-1">
                    <div class="col-4 text-primary font-bold">
                    <span>Nomor</span>
                    <h4 class="mb-1"><?= $header['nomor_dok']; ?></h4>
                    </div>
                    <div class="col-4 text-primary font-bold">
                    <span>Tanggal</span>
                    <h4 class="mb-1"><?= tglmysql($header['tgl']); ?></h4>
                    </div>
                    <div class="col-4 text-primary font-bold">
                    <span>Dibuat Oleh</span>
                    <h4 class="mb-1"><?= datauser($header['user_ok'],'name').' ('.$header['tgl_ok'].')' ?></h4>
                    </div>
                </div>
                <hr class='m-1'>
                <div class="card card-lg">
                    <input type="text" name="iddet" id="iddet" value="<?= $header['id']; ?>" class="hilang">
                    <div class="card-body p-2">
                        <div class="container container-slim py-4" id="syncloader">
                            <div class="text-center">
                                <div class="mb-3">
                                </div>
                                <div class="text-secondary mb-3">Fetching data, Please wait..</div>
                                <div class="progress progress-sm">
                                <div class="progress-bar progress-bar-indeterminate"></div>
                                </div>
                            </div>
                        </div>
                        <table class="table datatable6 table-hover hilang" id="cobasisip">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <!-- <th>No</th> -->
                                    <th>Specific</th>
                                    <th>SKU</th>
                                    <th>Satuan</th>
                                    <th class="text-center">No Bale</th>
                                    <th class="text-center">Exnet</th>
                                    <th>Qty</th>
                                    <th>Kgs</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >

                            </tbody>
                        </table>
                        <div class="font-bold font-italic" style="text-align: right;">Jumlah Item Barang : <?= $header['jumlah_barang']; ?></div>
                        <a href="#teskolap" data-toggle="collapse" aria-expanded="false" class="link text-orange <?php if($header['data_ok']==0){ echo "hilang"; } ?>">View Detail BOM</a>
                        <div class="collapse" id="teskolap">
                            <div class="container container-slim py-4" id="syncloader2">
                                <div class="text-center">
                                    <div class="mb-3">
                                    </div>
                                    <div class="text-secondary mb-3">Fetching data, Please wait..</div>
                                    <div class="progress progress-sm">
                                    <div class="progress-bar progress-bar-indeterminate"></div>
                                    </div>
                                </div>
                            </div>
                            <table class="table datatable6 table-hover" id="cobasisip2">
                            <thead style="background-color: blue !important">
                                <tr>
                                <!-- <th>No</th> -->
                                <th>Specific</th>
                                <th>SKU</th>
                                <th>Satuan</th>
                                <th>Qty</th>
                                <th>Kgs</th>
                                <th>Keterangan</th>
                                <th>XXX</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table2" style="font-size: 13px !important;" >
                          
                            </tbody>
                        </table>
                        </div>
                    </div>
                </div>
                <hr class="m-1">
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function(){
        // $("#body-table").removeClass('hilang');
        // $("#loaderisi").addClass('hilang');
        // $("#keyw").focus();
        // $("#keyw").val($("#nama_barang").val());
        // if($("#keyw").val() != ''){
        //     $("#getbarang").click();
        // }
        $("#cobasisip").addClass('hilang');
        $("#syncloader").removeClass('hilang');
        $("#cobasisip2").addClass('hilang');
        $("#syncloader2").removeClass('hilang');
        setTimeout(() => {
            var iddet = $("#iddet").val();
            getdatadetail(iddet);
        }, 500);
        setTimeout(() => {
            var iddet = $("#iddet").val();
            getdatadetail2(iddet);
        }, 1000);
    })
    function getdatadetail(iddet){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'out/loaddetailout',
            data: {
                id: iddet,
            },
            success: function(data){
                $("#syncloader").addClass('hilang');
                $("#cobasisip").removeClass('hilang');
                $("#body-table").html(data.datagroup).show();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })      
    }
    function getdatadetail2(iddet){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'out/loaddetailout2',
            data: {
                id: iddet,
            },
            success: function(data){
                $("#syncloader2").addClass('hilang');
                $("#cobasisip2").removeClass('hilang');
                $("#body-table2").html(data.datagroup).show();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })      
    }
    // $("#keyw").on('keyup',function(e){
    //     if(e.key == 'Enter' || e.keycode === 13){
    //         $("#getbarang").click();
    //     }
    // })
    // $("#getbarang").click(function(){
    //     if($("#keyw").val() == ''){
    //         pesan('Isi dahulu keyword pencarian barang','info');
    //         return;
    //     }
    //     $.ajax({
    //         dataType: "json",
    //         type: "POST",
    //         url: base_url+'pb/getspecbarang',
    //         data: {
    //             mode: $("#cari_by").val(),
    //             data: $("#keyw").val(),
    //         },
    //         success: function(data){
    //             $("#body-table").html(data.datagroup).show();
    //         },
    //         error: function (xhr, ajaxOptions, thrownError) {
    //             console.log(xhr.status);
    //             console.log(thrownError);
    //         }
    //     })
    // })
    // $(document).on('click','.pilihbarang',function(){
    //     var x = $(this).attr('rel1');
    //     var y = $(this).attr('rel2');
    //     var z = $(this).attr('rel3');
    //     $("#nama_barang").val(x);
    //     $("#id_barang").val(y);
    //     $("#id_satuan").val(z)
    //     $("#modal-scroll").modal('hide');
    // })
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