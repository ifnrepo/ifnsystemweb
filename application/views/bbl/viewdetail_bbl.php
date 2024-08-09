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
                        <?php if($this->session->userdata('viewharga')==1): ?>
                            <th>Harga terakhir</th>
                            <th>Total</th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                    <?php foreach ($detail->result_array() as $val) { $tampil = $val['pcs']!=0 ? $val['pcs'] : $val['kgs']; ?>
                        <tr>
                            <td class="line-12"><?= $val['nama_barang']; ?><br><span style="font-size: 10px" class="text-primary"><?= $val['id_pb']; ?></span></td>
                            <td><?= $val['brg_id']; ?></td>
                            <td><?= $val['namasatuan']; ?></td>
                            <td><?= rupiah($val['pcs'], 0); ?></td>
                            <td><?= rupiah($val['kgs'], 2); ?></td>
                            <?php if($this->session->userdata('viewharga')==1): ?>
                                <td class="text-danger"><?= rupiah(gethrg($val['id_barang'], $val['nobontr']),2); ?></td>
                                <td class="text-danger"><?= rupiah(gethrg($val['id_barang'], $val['nobontr'])*$tampil,2); ?></td>
                            <?php endif; ?>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="font-bold font-italic" style="text-align: right;">Jumlah Item Barang : <?= $header['jumlah_barang']; ?></div>
        </div>
    </div>
    <hr class="m-1">
    <div class="row mb-1">
        <div class="col-3">
            <div class="<?php if($header['ok_pp']==1 && $header['bbl_pp']==0){ echo "hilang"; } ?>">
            <span>Mengetahui :</span>
            <h4 class="mb-1"><?= datauser($header['user_pp'], 'name') . ' ' . $header['tgl_pp'] . "<br>" . $header['ketcancel'] ?></h4>
            </div>
        </div>
        <div class="col-3 <?php if($header['ok_valid']==2){ echo "text-danger"; } ?>">
            <div class="<?php if($header['ok_valid']==0){ echo "hilang"; } ?>">
            <span><?php if($header['ok_valid']==2){ echo "Dicancel :"; }else{echo "Diperiksa :"; } ?></span>
            <h4 class="mb-1"><?= datauser($header['user_valid'], 'name') . ' ' . $header['tgl_valid'] . "<br>" . $header['ketcancel'] ?></h4>
            </div>
        </div>
        <div class="col-3 <?php if($header['ok_tuju']==2){ echo "text-danger"; } ?>">
            <div class="<?php if($header['ok_tuju']==0){ echo "hilang"; } ?>">
            <span><?php if($header['ok_tuju']==2){ echo "Dicancel :"; }else{echo "Disetujui :"; } ?></span>
            <h4 class="mb-1"><?= datauser($header['user_tuju'], 'name') . ' ' . $header['tgl_tuju'] . "<br>" . $header['ketcancel'] ?></h4>
            </div>
        </div>
        <div class="col-3 <?php if($header['ok_pc']==2){ echo "text-danger"; } ?>">
            <div class="<?php if($header['ok_pc']==0){ echo "hilang"; } ?>">
            <span><?php if($header['ok_pc']==2){ echo "Dicancel :"; }else{echo "Diterima :"; } ?></span>
            <h4 class="mb-1"><?= datauser($header['user_pc'], 'name') . ' ' . $header['tgl_pc'] . "<br>" . $header['ketcancel'] ?></h4>
            </div>
        </div>
    </div>
    <hr class="m-1">
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