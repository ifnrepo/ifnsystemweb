<div class="container-xl"> 
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
                    <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                <?php foreach ($detail as $val) { ?>
                    <tr>
                        <td class="line-12"><?= $val['nama_barang'].'<br><span class="font-kecil text-teal">'.$val['insno'].' '.$val['nobontr'].'</span>'; ?></td>
                        <td><?= $val['brg_id']; ?></td>
                        <td><?= $val['namasatuan']; ?></td>
                        <td><?= rupiah($val['pcs'],0); ?></td>
                        <td><?= rupiah($val['kgs'],2); ?></td>
                        <td><?= $val['keterangan']; ?></td>
                    </tr>
                <?php } ?>
                </tbody>
            </table>
            <div class="font-bold font-italic" style="text-align: right;">Jumlah Item Barang : <?= $header['jumlah_barang']; ?></div>
        </div>
    </div>
    <hr class="m-1">
    <div class="row mb-1">
        <div class="col-4 text-primary font-bold">
            <span>KETERANGAN :</span>
            <h4 class="mb-1"><?= $header['keterangan']; ?></h4>
        </div>
        <div class="col-4"></div>
        <?php $bgr = $header['ketcancel']==null ? "text-primary" : "text-danger"; ?>
        <?php $vld = $header['ok_valid']==0 ? "hilang" : ""; ?>
        <div class="col-4 <?= $bgr.' '.$vld; ?> font-bold ">
            <?php $cek = $header['ketcancel']==null ? "Disetujui Oleh" : "Dicancel Oleh"; ?>
            <span><?= $cek; ?></span>
            <h4 class="mb-1"><?= datauser($header['user_valid'],'name').' ('.$header['tgl_valid'].')'."<br>".$header['ketcancel'] ?></h4>
        </div>
    </div>
    <hr class="m-1">
</div>
<script>
    $(document).ready(function(){
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