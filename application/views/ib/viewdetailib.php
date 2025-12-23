<div class="container-xl">
    <div class="card-header font-kecil">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
            <li class="nav-item">
                <a href="#tabs-home-8" class="nav-link bg-teal-lt active btn-flat" data-bs-toggle="tab">Dokumen</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-profile-8" class="nav-link bg-red-lt btn-flat" data-bs-toggle="tab">Dokumen SPPB</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-profilex-8" class="nav-link bg-cyan-lt btn-flat" data-bs-toggle="tab">Formulir BC</a>
            </li>
            <li class="nav-item">
                <a href="#tabs-riwayat-8" class="nav-link bg-yellow-lt btn-flat" data-bs-toggle="tab"><span class="text-black">Riwayat Dokumen</span></a>
            </li>
            <li class="nav-item">
                <a href="#tabs-foto-8" class="nav-link bg-grey-lt btn-flat font-bold" data-bs-toggle="tab">Lampiran Foto & Video</a>
            </li>
        </ul>
    </div>
    <?php $tanpabc = $header['tanpa_bc'] == 1 ? 'hilang' : ''; ?>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade p-2" id="tabs-profilex-8">
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
            <div class="tab-pane fade active show p-2" id="tabs-home-8">
                <div class="row mb-1 no-gutters">
                    <div class="col-4 text-primary font-bold">
                        <span>Nomor</span>
                        <h4 class="mb-1"><?= $header['nomor_dok']; ?></h4>
                        <hr class="m-0">
                        <div class="font-kecil p-1">
                            <?php if ($mode == 0) { ?>
                                Supplier : <br>
                                <div style="font-weight: normal !important;">
                                    <?= $header['id_pemasok'] . ' - ' . $header['namasupplier']; ?><br>
                                    <?= $header['alamat']; ?><br>
                                    Attn. <?= $header['kontak']; ?>
                                </div>
                            <?php } else { ?>
                                Subkontrak : <br>
                                <div style="font-weight: normal !important;">
                                    <?= $header['dept_id'] . ' - ' . datadepartemen($header['dept_id'], 'nama_subkon'); ?><br>
                                    <?= datadepartemen($header['dept_id'], 'alamat_subkon'); ?><br>
                                    Attn. <?= datadepartemen($header['dept_id'], 'pic'); ?>
                                </div>
                            <?php } ?>
                        </div>
                        <hr class="m-1 <?= $tanpabc; ?>">
                        <div class="font-kecil text-primary p-1 <?= $tanpabc; ?>">
                            <span class="text-black">Informasi BC</span> <br>
                            <div style="font-weight: normal !important;">
                                <?php
                                $notglaju =  '';
                                $notglaju .= $header['nomor_aju'];
                                $notglaju .= $header['tgl_aju'] == null ? "" : ' (' . $header['tgl_aju'] . ')';
                                $noaju = $header['jns_bc'] == '' ? '' : generatekodebc($header['jns_bc'], $header['tgl_aju'], $header['nomor_aju']);
                                $notglbc =  '';
                                $notglbc .= $header['nomor_bc'];
                                $notglbc .= $header['tgl_bc'] == null ? "" : ' (' . $header['tgl_bc'] . ')';
                                ?>
                                Jenis BC : <?= $header['jns_bc']; ?><br>
                                Nomor Aju : <?= $notglaju ?><br>
                                <span class='font-bold'><?= $noaju ?></span><br>
                                No BC : <?= $notglbc; ?>
                            </div>
                        </div>
                    </div>
                    <div class="col text-primary font-bold">
                        <span>Tanggal</span>
                        <h4 class="mb-1"><?= tglmysql($header['tgl']); ?></h4>
                        <hr class="m-0">
                        <div class="font-kecil bg-green-lt p-1 <?= $tanpabc; ?>">
                            <span class="text-black">Dokumen Pelengkap Pabean :</span><br>
                            <div style="font-weight: normal !important;">
                                <?php
                                $notgljalan =  '';
                                $notgljalan .= $header['nomor_sj'];
                                $notgljalan .= $header['tgl_sj'] == null ? "" : ' (' . $header['tgl_sj'] . ')';
                                ?>
                                Surat Jalan No. <span class="text-black"><?= $notgljalan; ?></span><br>
                                <?php
                                $notgljalan =  '';
                                $notgljalan .= $header['nomor_po'];
                                $notgljalan .= $header['tgl_po'] == null ? "" : ' (' . $header['tgl_po'] . ')';
                                ?>
                                PO No. <span class="text-black"><?= $notgljalan; ?></span><br>
                                <?php
                                $notgljalan =  '';
                                $notgljalan .= $header['nomor_inv'];
                                $notgljalan .= $header['tgl_inv'] == null ? "" : ' (' . $header['tgl_inv'] . ')';
                                ?>
                                No INV. <span class="text-black"><?= $notgljalan; ?></span><br>
                                <?php
                                $notgljalan =  '';
                                $notgljalan .= $header['nomor_pl'];
                                $notgljalan .= $header['tgl_pl'] == null ? "" : ' (' . $header['tgl_pl'] . ')';
                                ?>
                                Packing List. <span class="text-black"><?= $notgljalan; ?></span><br>
                                <br>
                                <br>
                                <br>
                                <br>
                                <br>
                                No Faktur Pajak. <?= $header['no_faktur_pajak']; ?><br>
                            </div>
                        </div>
                    </div>
                    <div class="col-4 text-primary font-bold">
                        <span>Dibuat Oleh</span>
                        <h4 class="mb-1"><?= datauser($header['user_ok'], 'name') . ' (' . $header['tgl_ok'] . ')' ?></h4>
                        <hr class="m-0">
                        <div class="font-kecil bg-green-lt p-1 <?= $tanpabc; ?>">
                            <span class="text-black">Sarana Angkut :</span><br>
                            <div style="font-weight: normal !important;">
                                Angkutan <span class="text-black"><?= $header['angkutlewat'] . ' (' . $header['angkutan'] . ')'; ?></span><br>
                                No Plat. <span class="text-black"><?= $header['no_kendaraan']; ?></span><br><br>
                                <span class="text-black font-bold">Kemasan dan Volume :</span><br>
                                Jumlah. <span class="text-black"><?= $header['jml_kemasan'] . ' ' . $header['kd_kemasan']; ?></span><br>
                                Keterangan. <span class="text-black"><?= $header['ket_kemasan']; ?></span><br>
                                <span class="text-black font-bold">Kgs / Volume</span><br>
                                Volume <span class="text-black"></span><br>
                                Bruto <span class="text-black"><?= rupiah($header['bruto'], 2); ?></span><br>
                                Netto <span class="text-black"><?= rupiah($header['netto'], 2); ?></span><br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 font-kecil bg-warning-lt p-1 <?= $tanpabc; ?>">
                        <div class="text-black font-bold bg-primary-lt p-1 text-center"><span class="text-black">Nilai Penyerahan / Devisa</span></div>
                        <div class="row">
                            <div class="col-6">
                                <span class="text-black">Nilai Pabean / CIF - <span class="font-bold"><?= $header['mt_uang'] . ' ' . rupiah($header['nilai_pab'], 2); ?></span></span>
                            </div>
                            <div class="col-6">
                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-black">NDPBM</span><br>
                                        USD : <span class="text-black font-bold"><?= rupiah($header['kurs_usd'], 2); ?></span><br>
                                        <?php $ndpbm2 = $header['mtuang'] == 3 ? $header['kurs_yen'] : 1;  ?>
                                        <?= $header['mt_uang'] ?> : <span class="text-black font-bold"><?= rupiah($ndpbm2, 2); ?></span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-black">Nilai Devisa</span><br>
                                        USD : <span class="text-black font-bold"><?= rupiah($header['devisa_usd'], 2); ?></span><br>
                                        IDR : <span class="text-black font-bold"><?= rupiah($header['devisa_idr'], 2); ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="text-black font-bold bg-primary-lt p-1 mt-2 text-center"><span class="text-black">Penanggung Jawab</span></div>
                        <div class="row text-center">
                            <span class="px-3 text-black font-bold"><?= $header['tg_jawab'] . ' - ' . $header['jabat_tg_jawab']; ?></span>
                        </div>

                    </div>
                </div>
                <hr class='m-1'>
                <div class="font-kecil font-bold bg-primary-lt p-1">DETAIL BARANG</div>
                <div class="card card-lg">
                    <div class="card-body p-2 font-kecil">
                        <table class="table datatable6 table-hover" id="cobasisip">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <!-- <th>No</th> -->
                                    <th>Specific</th>
                                    <th>SKU</th>
                                    <th>Satuan</th>
                                    <th>Qty</th>
                                    <th>Kgs</th>
                                    <th>Hrg/Satuan</th>
                                    <th>Total</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                <?php $jmlpcs = 0;
                                $jmlkgs = 0;
                                $Jmltotal = 0;
                                foreach ($detail as $val) {
                                    $jumlah = $val['kodesatuan'] == 'KGS' ? $val['kgs'] : $val['pcs'];
                                    $jmlpcs += $val['pcs'];
                                    $jmlkgs += $val['kgs'];
                                    $Jmltotal += $val['harga'] * $jumlah;
                                    $spekbarang = trim($val['po']) == '' ? namaspekbarang($val['id_barang']) : spekpo($val['po'], $val['item'], $val['dis']);
                                    $sku = trim($val['po']) == '' ? $val['brg_id'] : viewsku($val['po'], $val['item'], $val['dis']);
                                ?>
                                    <tr>
                                        <td><?= $spekbarang; ?></td>
                                        <td><?= $sku; ?></td>
                                        <td><?= $val['namasatuan']; ?></td>
                                        <td><?= rupiah($val['pcs'], 0); ?></td>
                                        <td><?= rupiah($val['kgs'], 2); ?></td>
                                        <td><?= rupiah($val['harga'], 2); ?></td>
                                        <td><?= rupiah($val['harga'] * $jumlah, 2); ?></td>
                                        <td><?= $val['keter']; ?></td>
                                    </tr>
                                <?php } ?>
                                <tr class="bg-success-lt">
                                    <td colspan="3" class="text-center font-bold text-black">TOTAL</td>
                                    <td class="text-black font-bold"><?= rupiah($jmlpcs, 0); ?></td>
                                    <td class="text-black font-bold"><?= rupiah($jmlkgs, 2); ?></td>
                                    <td></td>
                                    <td class="text-black font-bold"><?= rupiah($Jmltotal, 2); ?></td>
                                    <td></td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="font-bold font-italic" style="text-align: right;">Jumlah Item Barang : <?= $header['jumlah_barang']; ?></div>
                    </div>
                </div>
                <hr class="m-1 <?= $tanpabc; ?>">
                <div class="font-kecil font-bold bg-warning-lt p-1 <?= $tanpabc; ?>"><span class="text-black">LAMPIRAN DOKUMEN</span></div>
                <div class="card card-lg <?= $tanpabc; ?>">
                    <div class="card-body p-2">
                        <table class="table datatable6 table-hover" id="cobasisip">
                            <thead style="background-color: blue !important">
                                <tr>
                                    <!-- <th>No</th> -->
                                    <th>Kode</th>
                                    <th>Nama Dokumen</th>
                                    <th>No Dokumen</th>
                                    <th>Tanggal</th>
                                    <th>Keterangan</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                <?php foreach ($lampiran->result_array() as $lam) { ?>
                                    <tr>
                                        <td><?= $lam['kode_dokumen']; ?></td>
                                        <td><?= $lam['nama_dokumen']; ?></td>
                                        <td><?= $lam['nomor_dokumen']; ?></td>
                                        <td><?= $lam['tgl_dokumen']; ?></td>
                                        <td><?= $lam['keterangan']; ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <hr class="m-1">
                <div class="row mb-1">
                    <div class="col-4 text-primary font-bold">
                        <span>KETERANGAN :</span>
                        <h4 class="mb-1"><?= $header['keterangan']; ?></h4>
                    </div>
                    <div class="col-4"></div>
                    <?php $bgr = $header['ketcancel'] == null ? "text-primary" : "text-danger"; ?>
                    <?php $vld = $header['ok_valid'] == 0 ? "hilang" : ""; ?>
                    <div class="col-4 <?= $bgr . ' ' . $vld; ?> font-bold ">
                        <?php $cek = $header['ketcancel'] == null ? "Diverifikasi Oleh" : "Dicancel Oleh"; ?>
                        <span><?= $cek; ?></span>
                        <h4 class="mb-1"><?= datauser($header['user_valid'], 'name') . ' (' . $header['tgl_valid'] . ')' . "<br>" . $header['ketcancel'] ?></h4>
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
            <div class="tab-pane fade p-2 bg-grey-lt" id="tabs-foto-8">
                <div class="row">
                    <div class="col-md-7">
                        <div class="mt-2 font-bold d-flex justify-content-between">Lampiran Foto & Video Aju Masuk Barang <br>

                        </div>
                    </div>
                    <!-- <div class="col-md-5">
                        <?php if (empty($datheader['file'])) : ?>
                            <a href="<?= base_url('ib/upload/') . $header['id']; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Upload File">
                                <i class="fa fa-plus"></i>
                                <span class="ml-1">Upload</span>
                            </a>
                        <?php else : ?>
                            <a href="<?= base_url('ib/edit_file/') . $header['id']; ?>" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Upload File"><i class="fa fa-gear"></i><span class="ml-1">Setting</span></a>
                        <?php endif; ?>
                    </div> -->
                </div>
                <div class="col-md-8 mb-4">
                    <div class="text-muted fw-semibold mb-2"></div>

                    <?php
                    $path_files = json_decode($header['path_file'], true);
                    $file_names = json_decode($header['file'], true);


                    if (!empty($path_files)) {
                    ?>

                        <div id="mediaCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="30000">

                            <div class="carousel-indicators">
                                <?php foreach ($path_files as $index => $path) { ?>
                                    <button type="button" data-bs-target="#mediaCarousel" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo ($index == 0) ? 'active' : ''; ?>" aria-current="<?php echo ($index == 0) ? 'true' : 'false'; ?>" aria-label="Slide <?php echo $index + 1; ?>">
                                    </button>
                                <?php } ?>
                            </div>

                            <div class="carousel-inner rounded shadow-sm">
                                <?php foreach ($path_files as $index => $path) {
                                    $filename = isset($file_names[$index]) ? $file_names[$index] : basename($path);
                                    $is_image = preg_match('/\.(jpe?g|png|gif|webp)$/i', $path);
                                    $is_video = preg_match('/\.(mp4|webm|ogg)$/i', $path);
                                ?>
                                    <div class="carousel-item <?php echo ($index == 0) ? 'active' : ''; ?>">

                                        <?php
                                        if ($is_image) { ?>
                                            <a href="<?php echo base_url($path); ?>" target="_blank" title="Lihat: <?php echo htmlspecialchars($filename); ?>">
                                                <img src="<?php echo base_url($path); ?>" class="d-block w-100" alt="<?php echo htmlspecialchars($filename); ?>" style="max-height: 400px; object-fit: contain; background-color: #f8f9fa;">
                                            </a>
                                        <?php } else if ($is_video) { ?>
                                            <video class="d-block w-100" controls autoplay muted playsinline style="max-height: 400px; background-color: #000;">
                                                <source src="<?php echo base_url($path); ?>" type="video/<?php echo pathinfo($path, PATHINFO_EXTENSION); ?>">
                                                Browser Anda tidak mendukung tag video.
                                            </video>
                                        <?php } else { ?>
                                            <a href="<?php echo base_url($path); ?>" target="_blank" title="Lihat: <?php echo htmlspecialchars($filename); ?>">
                                                <div class="d-flex align-items-center justify-content-center w-100 bg-light text-secondary" style="height: 300px;">
                                                    <span class="fs-4">📎 File: <?php echo htmlspecialchars($filename); ?> (Klik untuk lihat)</span>
                                                </div>
                                            </a>
                                        <?php } ?>

                                        <div class="carousel-caption d-none d-md-block text-start bg-dark bg-opacity-75 p-2 rounded">
                                            <p class="mb-0 text-white" style="font-size: 0.9em;">
                                                <?php echo htmlspecialchars($filename); ?>
                                            </p>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>

                            <?php if (count($path_files) > 1) { ?>
                                <button class="carousel-control-prev" type="button" data-bs-target="#mediaCarousel" data-bs-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next" type="button" data-bs-target="#mediaCarousel" data-bs-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                            <?php } ?>
                        </div>

                    <?php
                    } else {
                        echo '<span style="color: gray;">Tidak ada file foto/video yang dilampirkan.</span>';
                    }
                    ?>
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
        // alert('ONYONYO')
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