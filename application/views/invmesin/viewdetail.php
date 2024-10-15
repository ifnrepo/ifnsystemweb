<div class="container-xl">
    <div class="row mb-1">
        <div class="col-3 font-bold">
            <span class="text-primary">Inventory per Tanggal</span>
            <h4 class="mb-1 text-teal-green"></h4>
        </div>
        <div class="col-7 text-primary font-bold">
            <span>SKU/Spesifikasi Barang</span>
            <?php $spekbarang = $header['nama_barang'] == null ? $header['spek_akt'] : $header['nama_barang']; ?>
            <?php $hilangtombol = $this->session->userdata('viewharga')==1 ? '' : 'hilang'; ?>
            <?php $nobc = trim($header['nomor_bc'])!='' ? 'BC.'.trim($header['jns_bc']).'-'.$header['nomor_bc'].'('.tglmysql($header['tgl_bc']).')<a href="#" id="viewdokhamat" class="btn btn-sm btn-danger ml-2 '.$hilangtombol.'" title="View Dokumen" style="padding: 2px !important;"><i class="fa fa-file-pdf-o"></i></a>' : ''; ?>
            <h4 class="mb-0 text-teal-green"><?= $header['kode_fix'] . " # " . $spekbarang; ?></h4>
            <hr class="m-0">
            <span class="font-12 text-red mt-1">KATEGORI : <?= $header['nama_kategori']; ?></span><a href="#" id="viewdokhamat" class="btn btn-sm btn-danger ml-2 mt-1 <?= $hilangtombol ?>" title="View Dokumen" style="padding: 2px !important;"><i class="fa fa-file-pdf-o mr-1"></i> Dok</a><br>
        </div>
    </div>
    <hr class='m-1'>
    <div class="card card-lg" id="cekkolape">
        <div class="card-body p-2">
            <table class="table datatable6 table-hover table-bordered" id="cobasisip">
                <thead style="background-color: blue !important">
                    <tr class="text-center">
                        <th>Tanggal</th>
                        <th>Nomor IB</th>
                        <th>Awal</th>
                        <th>In</th>
                        <th>Out</th>
                        <th>ADJ</th>
                        <th>Saldo</th>
                        <th>Keterangan</th>
                    </tr>
                    <!-- <tr>
                        <th>Pcs</th>
                        <th>Kgs</th>
                        <th>Pcs</th>
                        <th>Kgs</th>
                        <th>Pcs</th>
                        <th>Kgs</th>
                        <th>Pcs</th>
                        <th>Kgs</th>
                        <th>Pcs</th>
                        <th>Kgs</th>
                    </tr> -->
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                    <?php $saldoawal = 0;
                    $saldoawalkgs = 0;
                    $saldo = 0;
                    $saldokgs = 0;
                    $sak = 0;
                    foreach ($detail->result_array() as $det) { $saldo = $det['mesinsaw']+$det['mesinin']-$det['mesinout']-$det['mesinadj']; $sak += $saldo; ?>
                        <tr>
                            <td><?= tglmysql($det['tgl']); ?></td>
                            <td><?= $det['asal']; ?></td>
                            <td><?= rupiah($det['mesinsaw'],0); ?></td>
                            <td><?= rupiah($det['mesinin'],0); ?></td>
                            <td><?= rupiah($det['mesinout'],0); ?></td>
                            <td><?= rupiah($det['mesinadj'],0); ?></td>
                            <td><?= rupiah($sak,0) ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card hilang" id="dokfile">
      <div class="card-body pt-1 pb-1" style="overflow: auto;">
        <?php if(!empty(trim($header['filepdf']))){ ?>
            <iframe src="<?= LOK_DOK_MESIN.$header['filepdf']; ?>" style="width:100%;height:700px;" alt="Tidak ditemukan"></iframe>
        <?php }else{ ?>
            <div class="text-center font-bold m-0"><h3>BELUM ADA DOKUMEN</h3></div>
        <?php } ?>
      </div>
    </div>
    <hr class="m-1">
    <div class="row mb-1">
        <div class="col-4 text-primary font-bold">
        </div>
        <div class="col-4 text-primary font-bold">

        </div>
        <div class="col-4 font-bold">
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
    $("#viewdokhamat").click(function(){
        if($("#cekkolape").hasClass('hilang')){
            // $(this).text('XXX');
            $("#cekkolape").removeClass('hilang');
            $("#dokfile").addClass('hilang');
        }else{
            // $(this).text('YYY');
            $("#cekkolape").addClass('hilang');
            $("#dokfile").removeClass('hilang');
        }
    });
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