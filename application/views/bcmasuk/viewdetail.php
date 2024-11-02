<div class="container-xl">
    <!-- <div class="card"> -->
        <!-- <div class="card-header"> -->
            <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                <li class="nav-item">
                <a href="#tabs-home-8" class="nav-link active text-blue font-bold" data-bs-toggle="tab">Riwayat Dokumen</a>
                </li>
                <li class="nav-item">
                <a href="#tabs-profile-8" class="nav-link text-blue font-bold" data-bs-toggle="tab">Detail Dokumen</a>
                </li>
                <li class="nav-item">
                <a href="#tabs-activity-8" class="nav-link text-blue" data-bs-toggle="tab"></a>
                </li>
            </ul>
        <!-- </div> -->
        <!-- <div class="card-body"> -->
            <div class="tab-content p-4">
                <div class="tab-pane fade active show" id="tabs-home-8">
                    <!-- <div>Cursus turpis vestibulum, dui in pharetra vulputate id sed non turpis ultricies fringilla at sed facilisis lacus pellentesque purus nibh</div> -->
                    <ul class="steps steps-vertical font-kecil">
                        <?php $no=0; foreach ($riwayat as $riw) { ?>
                            <li class="step-item">
                                <!-- <div class="h4 m-0"></div> -->
                                <div class="text-secondary"><?= $riw; ?></div>
                            </li>
                        <?php $no++; } ?>
                      <!-- <li class="step-item">
                        <div class="h4 m-0">Dibuat Oleh</div>
                        <div class="text-secondary">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Accusamus culpa cum expedita ipsam laborum nam ratione reprehenderit sed sint tenetur!</div>
                      </li>
                      <li class="step-item">
                        <div class="h4 m-0">Disetujui Oleh</div>
                        <div class="text-secondary">Lorem ipsum dolor sit amet.</div>
                      </li>
                      <li class="step-item active">
                        <div class="h4 m-0">Out for delivery</div>
                        <div class="text-secondary">Lorem ipsum dolor sit amet.</div>
                      </li>
                      <li class="step-item">
                        <div class="h4 m-0">Finalized</div>
                        <div class="text-secondary">Lorem ipsum dolor sit amet.</div>
                      </li> -->
                    </ul>
                </div>
                <div class="tab-pane fade" id="tabs-profile-8">
                    <div>Sedang dibuat</div>
                </div>
                <div class="tab-pane fade" id="tabs-activity-8">
                    <h4>Activity tab</h4>
                    <div>Donec ac vitae diam amet vel leo egestas consequat rhoncus in luctus amet, facilisi sit mauris accumsan nibh habitant senectus</div>
                </div>
            </div>
        <!-- <div> -->
    <!-- </div> -->
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
            $("#cekkolape").removeClass('hilang');
            $("#dokfile").addClass('hilang');
        }else{
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