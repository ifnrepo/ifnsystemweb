<div class="container-xl">
    <!-- <div class="card"> -->
    <!-- <div class="card-header"> -->
    <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
        <li class="nav-item">
            <a href="#tabs-profile-8" class="nav-link active font-bold bg-primary-lt btn-flat" data-bs-toggle="tab">Header</a>
        </li>
        <li class="nav-item">
            <a href="#tabs-header-8" class="nav-link font-bold bg-success-lt btn-flat" data-bs-toggle="tab">Detail Barang</a>
        </li>
        <li class="nav-item">
            <a href="#tabs-home-8" class="nav-link font-bold bg-warning-lt btn-flat" data-bs-toggle="tab">Riwayat Dokumen</a>
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
            <h4 class="font-bold m-1">Riwayat Dokumen</h4>
            <hr class="m-0">
            </hr>
            <ul class="steps steps-vertical font-kecil">
                <?php $no = 0;
                foreach ($riwayat as $riw) { ?>
                    <li class="step-item">
                        <!-- <div class="h4 m-0"></div> -->
                        <div class="text-secondary"><?= $riw; ?></div>
                    </li>
                <?php $no++;
                } ?>
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
            <div class="card">
                <div class="card-body p-1">
                    <span style="position: absolute; right:15px; top: 10px; font-size: 25px;" class="font-bold">BC. <?= $detail['jns_bc']; ?></span>
                    <div class="p-1 m-0">
                        <h4 class="font-bold m-1">Informasi</h4>
                        <div class="row mb-1 font-kecil">
                            <div class="col-6">
                                <div class="mb-0">
                                    <label class="form-label font-kecil mb-0 font-bold">Nomor AJU</label>
                                    <div class="m-0">
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="email" class="form-control font-kecil btn-flat" aria-describedby="emailHelp" value="<?= generatekodebc($detail['jns_bc'], $detail['tgl_aju'], $detail['nomor_aju']); ?>" placeholder="Enter email">
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
                        <?php $hilangex = $detail['exnomor_bc'] == '' ? 'hilang' : ''; ?>
                        <div class="row mb-0 font-kecil <?= $hilangex; ?>">
                            <div class="col-6">
                                <div class="mb-0 bg-red-lt p-1">
                                    <label class="form-label font-kecil mb-0 font-bold text-black">Ex BC Nomor</label>
                                    <div class="m-0">
                                        <div class="row">
                                            <div class="col-8">
                                                <input type="email" class="form-control font-kecil btn-fla bg-yellow font-bold" aria-describedby="emailHelp" value="<?= $detail['exnomor_bc']; ?>" placeholder="Enter email">
                                            </div>
                                            <div class="col-4">
                                                <input type="email" class="form-control font-kecil btn-flat bg-yellow font-bold" aria-describedby="emailHelp" value="<?= $detail['extgl_bc']; ?>" placeholder="Enter email">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">

                            </div>
                        </div>
                    </div>
                    <hr class="m-1">
                    <div class="bg-cyan-lt p-2">
                        <h4 class="font-bold m-1">Identitas Pengirim Barang</h4>
                        <div class="row mb-1 font-kecil">
                            <label class="col-3 col-form-labels font-bold">Nama</label>
                            <div class="col">
                                <?php $supp = $detail['nama_supplier'] == '' ? $detail['nama_rekanan'] : $detail['nama_supplier']; ?>
                                <input type="text" class="form-control font-kecil btn-flat" value="<?= $supp; ?>" aria-describedby="emailHelp" placeholder="Enter Nama Pengirim">
                            </div>
                        </div>
                        <div class="row mb-1 font-kecil">
                            <label class="col-3 col-form-label font-bold">Alamat</label>
                            <div class="col">
                                <?php $suppalamat = $detail['nama_supplier'] == '' ? $detail['alamat_rekanan'] : $detail['alamat']; ?>
                                <textarea class="form-control font-kecil font-bold btn-flat"><?= $suppalamat; ?></textarea>
                            </div>
                        </div>
                        <div class="row mb-1 font-kecil">
                            <label class="col-3 col-form-label font-bold">NPWP</label>
                            <div class="col">
                                <?php $suppnpwp = $detail['nama_supplier'] == '' ? $detail['npwp_rekanan'] : $detail['npwp']; ?>
                                <input type="text" class="form-control font-kecil btn-flat" value="<?= $suppnpwp ?>" aria-describedby="emailHelp" placeholder="Enter Npwp Pengirim">
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
                                        <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= rupiah(0, 2); ?>" placeholder="Enter Nama Pengirim">
                                    </div>
                                </div>
                                <div class="row mb-0 font-kecil">
                                    <label class="col-3 col-form-label font-bold">Bruto (kgs)</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= rupiah($detail['bruto'], 2); ?>" placeholder="Enter Nama Pengirim">
                                    </div>
                                </div>
                                <div class="row mb-0 font-kecil">
                                    <label class="col-3 col-form-label font-bold">Netto (kgs)</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil mb-1 btn-sm btn-flat" aria-describedby="emailHelp" value="<?= rupiah($detail['netto'], 2); ?>" placeholder="Enter Nama Pengirim">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="m-1">
                    <div>
                        <div class="row">
                            <div class="col-4">
                                <div class="row font-kecil">
                                    <label class="col-3 col-form-label font-bold">CIF</label>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-5 mr-1">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['xmt_uang']; ?>" placeholder="Mt Uang">
                                            </div>
                                            <div class="col-9 mt-1">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" aria-describedby="emailHelp" value="<?= rupiah($detail['nilai_pab'], 2); ?>" placeholder="Enter Nilai PAB">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row font-kecil">
                                    <label class="col-3 col-form-label font-bold">NDPBM</label>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-12 mr-1">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" aria-describedby="emailHelp" value="<?= rupiah($detail['kurs_usd'], 2); ?>" placeholder="Enter Nama Pengirim">
                                            </div>
                                            <div class="col-12 mt-1">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" aria-describedby="emailHelp" value="<?= rupiah($detail['kurs_idr'], 2); ?>" placeholder="Enter Nama Pengirim">
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
                                                    <?php $nilaiidr = $detail['xmt_uang'] != 'IDR' ? $detail['nilai_pab'] * $detail['kurs_usd'] : $detail['nilai_pab']; ?>
                                                    <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" placeholder="Nilai IDR" value="<?= rupiah($nilaiidr, 2); ?>" style="padding-left: 45px !important;">
                                                </div>
                                            </div>
                                            <div class="col-12 mt-1">
                                                <div class="input-icon">
                                                    <span class="input-icon-addon" style="border-right: 2px solid gray;">
                                                        <div class="text-black font-kecil" role="status">Usd</div>
                                                    </span>
                                                    <?php $nilaiusd = $detail['xmt_uang'] == 'IDR' ? $detail['nilai_pab'] / $detail['kurs_usd'] : $detail['nilai_pab']; ?>
                                                    <input type="text" value="<?= rupiah($nilaiusd, 2); ?>" class="form-control font-kecil btn-sm btn-flat text-right" placeholder="Loading…" style="padding-left: 45px !important;">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="row">
                            <div class="col-6">
                                <div class="row font-kecil">
                                    <label class="col-3 col-form-label font-bold">Data Kemasan</label>
                                    <div class="col">
                                        <div class="col-9 mt-1">
                                            <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= rupiah($detail['jml_kemasan'], 0) . ' ' . $detail['kemasan'] ?>" placeholder="Kode Kemasan">
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 bg-red-lt">
                                <div class="row font-kecil">
                                    <label class="col-3 col-form-label font-bold text-black">No Kontrak</label>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-7 mt-1">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['nomor_kont'] ?>" placeholder="Nomor Kontrak">
                                            </div>
                                            <div class="col-5 mt-1">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= tglmysql($detail['tgl_kont']) ?>" placeholder="Tgl Kontrak">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="m-1">
                </div>
            </div>
        </div>
        <div class="tab-pane fade p-0" id="tabs-header-8">
            <div class="card">
                <div class="card-body p-1">
                    <div>
                        <h4 class="font-bold m-1">Detail Barang</h4>
                        <div class="container container-slim py-4" id="syncloader">
                            <div class="text-center">
                                <div class="mb-0">
                                    <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?= base_url() . 'assets/image/logosystem3.png'; ?>" height="30" alt=""></a>
                                </div>
                                <div class="text-secondary mb-3">Fetching data, Please wait..</div>
                                <div class="progress progress-sm">
                                    <div class="progress-bar progress-bar-indeterminate"></div>
                                </div>
                            </div>
                        </div>
                        <table id="tabel" class="table order-column table-hover datatable7 mt-1 hilang" style="width: 100% !important;">
                            <thead class="sticky-top">
                                <tr class="text-left">
                                    <!-- <th>Tgl</th> -->
                                    <th class="text-center bg-blue-lt">No</th>
                                    <th class="text-left bg-blue-lt">Spek</th>
                                    <th class="text-left bg-blue-lt">SKU</th>
                                    <th class="text-left bg-blue-lt">Sat</th>
                                    <th class="text-left bg-blue-lt">Jumlah</th>
                                    <th class="text-left bg-blue-lt">Berat</th>
                                    <th class="text-left bg-blue-lt">HS</th>
                                    <th class="text-left bg-blue-lt">Nilai (<?= $detail['xmt_uang']; ?>)</th>
                                    <th class="text-left bg-blue-lt">Subtotal (<?= $detail['xmt_uang']; ?>)</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                <?php $no = 1;
                                $jmpcs = 0;
                                $jmkgs = 0;
                                $jmnilai = 0;
                                foreach ($databarang->result_array() as $datadet) {
                                    $pengali = $datadet['kodesatuan'] == 'KGS' ? $datadet['kgs'] : $datadet['pcs'];
                                    $spek = $datadet['nm_alias'] == '' ? $datadet['nama_barang'] : $datadet['nm_alias'];

                                    $spekbarang = trim($datadet['po']) == '' ? namaspekbarang($datadet['id_barang']) : spekpo($datadet['po'], $datadet['item'], $datadet['dis']);


                                    $sku = viewsku($datadet['po'], $datadet['item'], $datadet['dis'], $datadet['kode']);
                                    $jmpcs += $datadet['pcs'];
                                    $jmkgs += $datadet['kgs'];
                                    $jmnilai += $datadet['harga'] * $pengali;
                                ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $spekbarang; ?></td>
                                        <td><?= $sku; ?></td>
                                        <td><?= $datadet['kodesatuan']; ?></td>
                                        <td class="text-right"><?= rupiah($datadet['pcs'], 0); ?></td>
                                        <td class="text-right"><?= rupiah($datadet['kgs'], 2); ?></td>
                                        <td><?= $datadet['nohs']; ?></td>
                                        <td class="text-right"><?= rupiah($datadet['harga'], 4); ?></td>
                                        <td class="text-right"><?= rupiah($datadet['harga'] * $pengali, 2); ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class='bg-teal-lt'>
                                    <td colspan='4' class='font-bold text-right text-black'>TOTAL</td>
                                    <td class='font-bold text-right text-black'><?= rupiah($jmpcs, 0); ?></td>
                                    <td class='font-bold text-right text-black'><?= rupiah($jmkgs, 2); ?></td>
                                    <td></td>
                                    <td></td>
                                    <td class='font-bold text-right text-black'><?= rupiah($jmnilai, 2); ?></td>
                                </tr>
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
        // $("#keyw").focus();
        // $("#keyw").val($("#nama_barang").val());
        // if($("#keyw").val() != ''){
        //     $("#getbarang").click();
        // }
        $(document).on('shown.bs.tab', 'a[data-bs-toggle="tab"]', function(e) {
            var anchor = $(e.target).attr('href');
            if (anchor == '#tabs-header-8' && $("#tabel").hasClass('hilang')) {
                setTimeout(() => {
                    $("#syncloader").addClass('hilang');
                    $("#tabel").removeClass('hilang');
                }, 500);
            }
        });
    })
    $("#viewdokhamat").click(function() {
        if ($("#cekkolape").hasClass('hilang')) {
            $("#cekkolape").removeClass('hilang');
            $("#dokfile").addClass('hilang');
        } else {
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