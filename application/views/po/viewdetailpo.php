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
                <?php $kensel = $header['ok_valid']==2 ? 'text-danger' : 'text-primary'; ?>
                <div class="row mb-1">
                    <div class="col-4 <?= $kensel; ?> font-bold">
                        <span>Nomor</span>
                        <h4 class="mb-1"><?= $header['nomor_dok']; ?></h4>
                        <hr class="m-0">
                        <div class="font-kecil p-1 bg-teal-lt">
                            Supplier <br>
                            <div style="font-weight: normal;">
                                <?= $header['id_pemasok'].' - '.$header['namasupplier']; ?><br>
                                <?= $header['alamat']; ?><br>
                                Attn. <?= $header['kontak']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 <?= $kensel; ?> font-bold">
                        <span>Tanggal</span>
                        <h4 class="mb-1"><?= tglmysql($header['tgl']); ?></h4>
                        <hr class="m-0">
                        <div class="font-kecil p-1 bg-red-lt">
                            Informasi <br>
                            <div style="font-weight: normal;">
                                Tgl rencana datang : <?= $header['tgl_dtb']; ?><br>
                                Jenis Bayar : <?= $header['jenis_pembayaran']; ?><br>
                                <?= $header['mt_uang'].' - '.$header['detterm']; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 <?= $kensel; ?> font-bold">
                    <span>Dibuat Oleh</span>
                    <h4 class="mb-1"><?= datauser($header['user_ok'],'name').' ('.$header['tgl_ok'].')' ?></h4>
                    </div>
                </div>
                <hr class='m-1'>
                <div class="card card-lg">
                    <div class="card-body p-2">
                        <div class="font-kecil mb-1">
                            <?= $header['header_po']; ?>
                        </div>
                        <table class="table datatable6 table-hover" id="cobasisip">
                            <thead style="background-color: blue !important">
                                <tr>
                                <!-- <th>No</th> -->
                                <th>Specific</th>
                                <th>SKU</th>
                                <th>Satuan</th>
                                <th>Qty</th>
                                <th>Kgs</th>
                                <th>Harga</th>
                                <th>Total</th>
                                <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
                            <?php foreach ($detail as $val) { $tampil = $val['pcs']==0 ? $val['kgs'] : $val['pcs']; ?>
                                <tr>
                                    <td><?= $val['nama_barang']; ?></td>
                                    <td><?= $val['brg_id']; ?></td>
                                    <td><?= $val['namasatuan']; ?></td>
                                    <td><?= rupiah($val['pcs'],0); ?></td>
                                    <td><?= rupiah($val['kgs'],2); ?></td>
                                    <td><?= rupiah($val['harga'],2); ?></td>
                                    <td><?= rupiah($val['harga']*$tampil,2); ?></td>
                                    <td><?= $val['keter']; ?></td>
                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                        <div class="font-bold font-italic" style="text-align: right;">Jumlah Item Barang : <?= $header['jumlah_barang']; ?></div>
                    </div>
                </div>
                <hr class="m-1">
                <div class="row">
                    <div class="col-sm-6">
                        Catatan :
                        <ul>
                            <li> <?= $header['catatan1']; ?></li>
                            <li> <?= $header['catatan2']; ?></li>
                            <li> <?= $header['catatan3']; ?></li>
                        </ul>
                    </div>
                    <div class="col-sm-3 text-right">
                        Harga Total :<br>
                        Diskon :<br>
                        Total :<br>
                        PPN <?= rupiah($header['cekppn'],0).'%'; ?>:<br>
                        PPh :<br>
                        Jumlah :
                    </div>
                    <div class="col-sm-3 text-right">
                        <strong><?= rupiah($header['totalharga'],2); ?></strong><br>
                        <strong><?= rupiah($header['diskon'],2); ?></strong><br>
                        <strong><?= rupiah($header['totalharga']-$header['diskon'],2); ?></strong><br>
                        <strong><?= rupiah($header['ppn'],2); ?></strong><br>
                        <strong><?= rupiah($header['pph'],2); ?></strong><br>
                        <strong><?= rupiah(($header['totalharga']-$header['diskon'])+$header['ppn']-$header['pph'],2); ?></strong>
                    </div>
                </div>
                <hr class="m-1">
                <div class="row mb-1">
                    <div class="col-4 <?= $kensel; ?> font-bold">
                        <span>KETERANGAN :</span>
                        <h4 class="mb-1"><?= $header['keterangan'].'-'.$header['ketcancel']; ?></h4>
                    </div>
                    <div class="col-4"></div>
                    <?php $bgr = $header['ketcancel']==null ? "text-primary" : "text-danger"; ?>
                    <?php $vld = $header['ok_valid']==0 ? "hilang" : ""; ?>
                    <div class="col-4 <?= $kensel.' '.$vld; ?> font-bold ">
                        <?php $cek = $header['ok_valid']!=2 ? "Disetujui Oleh" : "Dicancel Oleh"; ?>
                        <span><?= $cek; ?></span>
                        <h4 class="mb-1"><?= datauser($header['user_valid'],'name').' ('.$header['tgl_valid'].')'."<br>".$header['ketcancel'] ?></h4>
                    </div>
                </div>
                <hr class="m-1">
            </div>
            <div class="tab-pane fade p-4 text-blue" id="tabs-profile-8">
                <?php if(count($riwayat) > 0):  ?>
                    <ul>
                        <?php foreach ($riwayat as $riw) { ?>
                            <?php if(is_array($riw)){ ?>
                                <hr class="m-1">
                                <div class="p-2" style="border:1px solid #FBEBEB !important;">
                                <u>DETAIL BBL</u>
                                <ol>
                                    <?php foreach ($riw as $raw) { ?>
                                        <?php if(is_array($raw)){ ?>
                                            <ul>
                                                <?php foreach ($raw as $ruw) { ?>
                                                    <li style="font-size: 12px;"><?= $ruw; ?></li>
                                                <?php } ?>
                                            </ul>
                                        <?php }else{ ?>
                                            <li class='text-pink'><?= $raw; ?></li>
                                        <?php } ?>
                                    <?php } ?>
                                </ol>
                                </div>
                            <?php }else{ ?>
                                <li><?= $riw; ?></li>
                            <?php } ?>
                        <?php } ?>
                    </ul>
                <?php endif; ?>
                <hr class="m-1">
            </div>
        </div>
    </div>
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