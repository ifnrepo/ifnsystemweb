<div class="container-xl">
    <div class="card-header font-kecil">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
            <li class="nav-item">
                <a href="#tabs-home-8" class="nav-link bg-teal-lt active btn-flat" data-bs-toggle="tab">View Dokumen</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-profile-8" class="nav-link bg-red-lt btn-flat" data-bs-toggle="tab">Detail Dokumen</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-riwayat-8" class="nav-link bg-blue-lt btn-flat" data-bs-toggle="tab">Riwayat Dokumen</a>
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
                        <h4 class="mb-1"><?= datauser($header['user_ok'], 'name') . ' (' . $header['tgl_ok'] . ')' ?></h4>
                    </div>
                </div>
                <hr class='m-1'>
                <div class="card card-lg">
                    <div class="card-body p-2">
                        <table class="table datatable6 table-hover" id="cobasisip">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <!-- <th>No</th> -->
                                    <th>Specific</th>
                                    <th>SKU</th>
                                    <th>Satuan</th>
                                    <th>Qty</th>
                                    <th>Kgs</th>
                                    <th>Verifikasi</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                <?php foreach ($detail as $val) { ?>
                                    <tr>
                                        <td><?= $val['nama_barang']; ?></td>
                                        <td><?= $val['brg_id']; ?></td>
                                        <td><?= $val['namasatuan']; ?></td>
                                        <td><?= rupiah($val['pcs'], 0); ?></td>
                                        <td><?= rupiah($val['kgs'], 2); ?></td>
                                        <td>
                                            <?php if ($val['verif_oleh'] != null) : ?>
                                                <i class="fa fa-check text-primary"></i>
                                                <?= substr(datauser($val['verif_oleh'], 'name'), 0, 15); ?>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        <div class="row">
                            <div class="col-sm-6 font-bold bg-warning p-1">
                                Dikonfirmasi oleh :<br> <?= datauser($header['user_valid'], 'name'); ?><br><?= $header['tgl_valid']; ?>
                            </div>
                            <div class="col-sm-6">
                                <div class="font-bold font-italic" style="text-align: right;">Jumlah Item Barang : <?= $header['jumlah_barang']; ?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="m-1">
            </div>
            <div class="tab-pane fade p-2" id="tabs-profile-8">
                <div class="card">
                    <div class="col-md-3">
                    </div>
                    <!-- <hr class="p-1 m-1"> -->
                    <div class="card-body pt-1 pb-1" style="overflow: auto;">
                        <?php if (!empty(trim($header['filepdf']))) { ?>
                            <iframe src="<?= LOK_UPLOAD_DOK_BC . trim($header['filepdf']); ?>" style="width:100%;height:700px;" alt="Tidak ditemukan"></iframe>
                        <?php } else { ?>
                            <div style="width:100%;height:700px;" class="text-center font-bold m-0">
                                <h3>BELUM ADA DOKUMEN</h3>
                            </div>
                            <?= LOK_UPLOAD_DOK_BC . trim($header['filepdf']); ?>
                        <?php } ?>
                        <!-- <object data="test.pdf" type="application/pdf" width="100%" height="700">
                            alt : <a href="test.pdf">test.pdf</a>
                        </object> -->
                    </div>
                </div>
            </div>
            <div class="tab-pane fade p-2" id="tabs-riwayat-8">
                <div style="width:100%;height:700px;" class="text-center font-bold m-0">
                    <h3>NOT FOUND</h3>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        // $("#keyw").focus();
        // $("#keyw").val($("#nama_barang").val());
        // if($("#keyw").val() != ''){
        //     $("#getbarang").click();
        // }
    })
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