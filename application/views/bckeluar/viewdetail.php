<div class="container-xl">
    <!-- <div class="card"> -->
        <!-- <div class="card-header"> -->
            <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                <li class="nav-item">
                <a href="#tabs-profile-8" class="nav-link active text-blue font-bold" data-bs-toggle="tab">Detail Dokumen</a>
                </li>
                <li class="nav-item">
                <a href="#tabs-home-8" class="nav-link text-blue font-bold" data-bs-toggle="tab">Riwayat Dokumen</a>
                </li>
                <li class="nav-item">
                <a href="#tabs-activity-8" class="nav-link text-blue" data-bs-toggle="tab"></a>
                </li>
            </ul>
        <!-- </div> -->
        <!-- <div class="card-body"> -->
            <div class="tab-content p-4">
                <div class="tab-pane fade" id="tabs-home-8">
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
                <div class="tab-pane fade active show p-0" id="tabs-profile-8">
                    <input type="text" class="hilang" value="<?= $iddet; ?>" id="iddet">
                    <div class="card">
                        <div class="card-body p-1">
                            <div class="p-1 m-0">
                               <h4 class="font-bold m-1">Informasi</h4> 
                               <div class="row mb-1 font-kecil">
                                    <div class="col-6">
                                        <div class="mb-0">
                                            <label class="form-label font-kecil mb-0 font-bold">Nomor AJU</label>
                                            <div class="m-0">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <input type="email" class="form-control font-kecil btn-flat" aria-describedby="emailHelp" value="<?= generatekodebc($detail['jns_bc'],$detail['tgl_aju'],$detail['nomor_aju']); ?>" placeholder="Enter email">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="email" class="form-control font-kecil btn-flat" aria-describedby="emailHelp" value="<?= $detail['tgl_aju']; ?>" placeholder="Enter email">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-0">
                                            <label class="form-label font-kecil mb-0 font-bold">Nomor BC</label>
                                            <div class="m-0">
                                                <div class="row">
                                                    <div class="col-8">
                                                        <input type="email" class="form-control font-kecil btn-flat" value="<?= $detail['nomor_bc']; ?>" aria-describedby="emailHelp" placeholder="Nomor BC / NOPEN">
                                                    </div>
                                                    <div class="col-4">
                                                        <input type="email" class="form-control font-kecil btn-flat" value="<?= $detail['tgl_bc']; ?>" aria-describedby="emailHelp" placeholder="Tgl BC / NOPEN">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-1">
                            <div class="bg-cyan-lt p-2">
                                <h4 class="font-bold m-1">Identitas Penerima Barang</h4>
                                <div class="row mb-1 font-kecil">
                                    <label class="col-3 col-form-labels font-bold">Nama</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil btn-flat" value="<?= $detail['nama_customer']; ?>" aria-describedby="emailHelp" placeholder="Enter Nama Pengirim">
                                    </div>
                                </div>
                                <div class="row mb-1 font-kecil">
                                    <label class="col-3 col-form-label font-bold">Alamat</label>
                                    <div class="col">
                                        <textarea class="form-control font-kecil font-bold btn-flat"><?= trim($detail['alamat']); ?><?php if($detail['port']!=''){ echo ' '.$detail['port'];} ?></textarea>
                                    </div>
                                </div>
                                <div class="row mb-1 font-kecil">
                                    <label class="col-3 col-form-label font-bold">NPWP</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil btn-flat" value="<?= $detail['npwp'] ?>" aria-describedby="emailHelp" placeholder="Enter Npwp Pengirim">
                                    </div>
                                </div>
                            </div>
                            <div>
                               <div class="row mt-1">
                                    <div class="col-6">
                                        <div class="row font-kecil">
                                            <label class="col-3 col-form-label font-bold">Jenis Angkutan</label>
                                            <div class="col">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['xangkutan']; ?>" placeholder="Enter jenis angkutan">
                                            </div>
                                        </div>
                                        <div class="row mb-1 font-kecil">
                                            <label class="col-3 col-form-label font-bold">Sarana Angkut</label>
                                            <div class="col">
                                                <input type="text" class="form-control font-kecil mb-1 btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['angkutan']; ?>" placeholder="Enter Angkutan">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['no_kendaraan']; ?>" placeholder="Enter No Polis">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="row mb-0 font-kecil">
                                            <label class="col-3 col-form-label font-bold">Volume</label>
                                            <div class="col">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= rupiah($detail['volume'],2); ?>" placeholder="Enter Nama Pengirim">
                                            </div>
                                        </div>
                                        <div class="row mb-0 font-kecil">
                                            <label class="col-3 col-form-label font-bold">Bruto (kgs)</label>
                                            <div class="col">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= rupiah($detail['bruto'],2); ?>" placeholder="Enter Nama Pengirim">
                                            </div>
                                        </div>
                                        <div class="row mb-0 font-kecil">
                                            <label class="col-3 col-form-label font-bold">Netto (kgs)</label>
                                            <div class="col">
                                                <input type="text" class="form-control font-kecil mb-1 btn-sm btn-flat" aria-describedby="emailHelp" value="<?= rupiah($detail['netto'],2); ?>" placeholder="Enter Nama Pengirim">
                                            </div>
                                        </div>
                                    </div>
                               </div> 
                            </div>
                            <hr class="m-1">
                            <div>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="row font-kecil">
                                            <label class="col-3 col-form-label font-bold">Nilai Penyerahan</label>
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-5 mr-1">
                                                        <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['xmt_uang']; ?>" placeholder="Mt Uang">
                                                    </div>
                                                    <div class="col-9 mt-1">
                                                        <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" aria-describedby="emailHelp" value="<?= rupiah($detail['nilai_pab'],2); ?>" placeholder="Enter Nilai PAB">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3">
                                        <div class="row font-kecil">
                                            <label class="col-3 col-form-label font-bold">NDPBM</label>
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-12 mr-1">
                                                        <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" aria-describedby="emailHelp" value="<?= rupiah($detail['kurs_usd'],2); ?>" placeholder="Enter Nama Pengirim">
                                                    </div>
                                                    <div class="col-12 mt-1">
                                                        <?php  
                                                            $dx = 0;
                                                            $dy =0;
                                                            switch ($detail['xmt_uang']) {
                                                                case 'IDR':
                                                                    $dx = 1;
                                                                    $dy = 1;
                                                                    break;
                                                                case 'USD':
                                                                    $dx = $detail['kurs_usd'];
                                                                    $dy = 0;
                                                                    break;
                                                                case 'JPY':
                                                                    $dx = $detail['kurs_yen'];
                                                                    $dy = $detail['kurs_yen'];
                                                                    break;
                                                            }
                                                        ?>
                                                        <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" aria-describedby="emailHelp" value="<?= rupiah($dy,4); ?>" placeholder="Enter Kurs Penyerahan">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="row font-kecil">
                                            <label class="col-3 col-form-label font-bold">Nilai Devisa</label>
                                            <div class="col">
                                                <div class="row">
                                                    <div class="col-12 mr-1">
                                                        <div class="input-icon">
                                                            <span class="input-icon-addon" style="border-right: 2px solid gray;">
                                                                <div class="text-black font-kecil" role="status">Idr</div>
                                                            </span>
                                                            <?php $nilaiidr = $detail['nilai_pab']*$dx; ?>
                                                            <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" placeholder="Nilai IDR" value="<?= rupiah($nilaiidr,2); ?>"  style="padding-left: 45px !important;">
                                                        </div>
                                                    </div>
                                                    <div class="col-12 mt-1">
                                                        <div class="input-icon">
                                                            <span class="input-icon-addon" style="border-right: 2px solid gray;">
                                                                <div class="text-black font-kecil" role="status">Usd</div>
                                                            </span>
                                                            <?php $nilaiusd = ($detail['nilai_pab']*$dx)/$detail['kurs_usd']; ?>
                                                            <input type="text" value="<?= rupiah($nilaiusd,2); ?>" class="form-control font-kecil btn-sm btn-flat text-right" placeholder="Loading…" style="padding-left: 45px !important;">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <hr class="m-1">
                            <div>
                                <div class="row">
                                    <div class="col-5">
                                        <div class="row font-kecil">
                                            <label class="col-3 col-form-label font-bold">Data Kemasan</label>
                                            <div class="col">
                                                <div class="col-9 mt-1">
                                                    <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= rupiah($detail['jml_kemasan'],0).' '.$detail['kemasan'] ?>" placeholder="Kode Kemasan">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-3"></div>
                                    <div class="col-4"></div>
                                </div>
                            </div>
                            <hr class="m-1">
                            <div>
                                <h4 class="font-bold m-1" >Detail Barang</h4>
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
                                <table id="tabel" class="table order-column table-hover datatable7 mt-1 hilang" style="width: 100% !important;">
                                    <thead>
                                        <tr class="text-left">
                                            <!-- <th>Tgl</th> -->
                                            <th class="text-center">No</th>
                                            <th class="text-left">Spek</th>
                                            <th class="text-left">SKU</th>
                                            <th class="text-left">Sat</th>
                                            <th class="text-left">Jumlah</th>
                                            <th class="text-left">Berat</th>
                                            <th class="text-left">HS</th>
                                            <th class="text-left">Nilai</th>
                                            <th class="text-left">Subtotal</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                      
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    
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
        $("#tabel").addClass('hilang');
        $("#syncloader").removeClass('hilang');
        setTimeout(() => {
            var det = $("#iddet").val();
            getdatadetail(det);
        }, 500);
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
    function getdatadetail(det){
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'bckeluar/loaddatadetail',
            data: {
                id: det,
            },
            success: function(data){
                $("#syncloader").addClass('hilang');
                $("#tabel").removeClass('hilang');
                $("#body-table").html(data.datagroup).show();
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