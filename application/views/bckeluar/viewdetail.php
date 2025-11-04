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
            <a href="#tabs-detail-8" class="nav-link bg-red-lt btn-flat" data-bs-toggle="tab">Detail Dokumen</a>
        </li>
        <li class="nav-item">
            <a href="#tabs-home-8" class="nav-link font-bold bg-warning-lt btn-flat" data-bs-toggle="tab">Riwayat Dokumen</a>
        </li>
        <li class="nav-item">
            <a href="#tabs-poto-8" class="nav-link bg-grey-lt btn-flat font-bold" data-bs-toggle="tab">Lampiran Foto & Video</a>
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
            </ul>
        </div>
        <div class="tab-pane fade active show p-0" id="tabs-profile-8">
            <input type="text" class="hilang" value="<?= $iddet; ?>" id="iddet">
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
                                <textarea class="form-control font-kecil font-bold btn-flat"><?= trim($detail['alamat']); ?><?php if ($detail['port'] != '') {
                                                                                                                                echo ' ' . $detail['port'];
                                                                                                                            } ?></textarea>
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
                                        <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= rupiah($detail['volume'], 4); ?>" placeholder="Enter Nama Pengirim">
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
                            <div class="col-5">
                                <div class="row font-kecil">
                                    <label class="col-3 col-form-label font-bold">Nilai Penyerahan</label>
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
                            <div class="col-3">
                                <div class="row font-kecil">
                                    <label class="col-3 col-form-label font-bold">NDPBM</label>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-12 mr-1">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" aria-describedby="emailHelp" value="<?= rupiah($detail['kurs_usd'], 2); ?>" placeholder="Enter Nama Pengirim">
                                            </div>
                                            <div class="col-12 mt-1">
                                                <?php
                                                $dx = 0;
                                                $dy = 0;
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
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" aria-describedby="emailHelp" value="<?= rupiah($dy, 4); ?>" placeholder="Enter Kurs Penyerahan">
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
                                                    <?php $nilaiidr = $detail['nilai_pab'] * $dx; ?>
                                                    <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" placeholder="Nilai IDR" value="<?= rupiah($nilaiidr, 2); ?>" style="padding-left: 45px !important;">
                                                </div>
                                            </div>
                                            <div class="col-12 mt-1">
                                                <div class="input-icon">
                                                    <span class="input-icon-addon" style="border-right: 2px solid gray;">
                                                        <div class="text-black font-kecil" role="status">Usd</div>
                                                    </span>
                                                    <?php $kursusd = $detail['kurs_usd']==0 ? 1 : $detail['kurs_usd']; $nilaiusd = ($detail['nilai_pab'] * $dx) / $kursusd; ?>
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
                        <div class="row mt-1">
                            <div class="col-5">
                                <div class="row mb-0 font-kecil">
                                    <label class="col-3 col-form-label font-bold">Nilai CIF</label>
                                    <div class="col">
                                        <div class="row">
                                            <div class="col-9 mr-1">
                                                <input type="text" class="form-control font-kecil btn-sm btn-flat text-right" aria-describedby="emailHelp" value="<?= rupiah($detail['cif'], 2); ?>" placeholder="Enter Nilai CIF">
                                            </div>
                                            <div class="col-9 mt-1">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-3">

                            </div>
                            <div class="col-4">

                            </div>
                        </div>
                    </div>
                    <hr class="m-1">
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
                    <div>
                        <div class="row">
                            <div class="col-4">
                                <div class="row mb-0 font-kecil">
                                    <label class="col-5 col-form-label font-bold">No Segel</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['nomor_segel']; ?>" placeholder="Nomor Segel">
                                    </div>
                                </div>
                                <div class="row mb-0 font-kecil">
                                    <label class="col-5 col-form-label font-bold">Tanggal Segel</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= tglmysql($detail['tgl_segel']) ?>" placeholder="Tanggal Segel">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row mb-0 font-kecil">
                                    <label class="col-5 col-form-label font-bold">No Kontainer</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['nomor_kontainer']; ?>" placeholder="Nomor Kontainer">
                                    </div>
                                </div>
                                <div class="row mb-0 font-kecil">
                                    <label class="col-5 col-form-label font-bold">Ukuran Kontainer</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['ukuran_kontainer'] ?>" placeholder="Ukuran Kontainer">
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="row mb-0 font-kecil">
                                    <label class="col-5 col-form-label font-bold">No Pengangkutan</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['nomor_pengangkutan'] ?>" placeholder="Pengangkutan">
                                    </div>
                                </div>
                                <div class="row mb-0 font-kecil">
                                    <label class="col-5 col-form-label font-bold">No Seal</label>
                                    <div class="col">
                                        <input type="text" class="form-control font-kecil btn-sm btn-flat" aria-describedby="emailHelp" value="<?= $detail['nomor_seal'] ?>" placeholder="Nomor Seal">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="tab-pane fade p-2" id="tabs-detail-8">
            <div class="card">
                <div class="col-md-3">
                </div>
                <!-- <hr class="p-1 m-1"> -->
                <div class="card-body pt-1 pb-1" style="overflow: auto;">
                    <?php if (!empty(trim($detail['filepdf']))) { ?>
                        <iframe src="<?= LOK_UPLOAD_DOK_BC . trim($detail['filepdf']); ?>" style="width:100%;height:700px;" alt="Tidak ditemukan"></iframe>
                    <?php } else { ?>
                        <div style="width:100%;height:700px;" class="text-center font-bold m-0">
                            <h3>BELUM ADA DOKUMEN</h3>
                        </div>
                        <?= LOK_UPLOAD_DOK_BC . trim($detail['filepdf']); ?>
                    <?php } ?>
                    <!-- <object data="test.pdf" type="application/pdf" width="100%" height="700">
                            alt : <a href="test.pdf">test.pdf</a>
                        </object> -->
                </div>
            </div>
        </div>
        <div class="tab-pane fade" id="tabs-header-8">
            <!-- <div> -->
            <div class="card">
                <div class="card-body p-1">
                    <h4 class="font-bold">Detail Barang</h4>
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
                    <table id="tabel" class="table order-column table-hover mt-1 hilang" style="width: 100% !important;">
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
                        <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="tab-pane fade p-2" id="tabs-poto-8">
            <div class="row">
                <div class="col-md-7">
                    <div class="mt-2 font-bold d-flex justify-content-between">Lampiran Foto & Video Aju Keluar Barang <br>

                    </div>
                </div>
                <!-- <div class="col-md-5">
                        <?php if (empty($datheader['file'])) : ?>
                            <a href="<?= base_url('akb/upload/') . $datheader['id']; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Upload File">
                                <i class="fa fa-plus"></i>
                                <span class="ml-1">Upload</span>
                            </a>
                        <?php else : ?>
                            <a href="<?= base_url('akb/edit_file/') . $datheader['id']; ?>" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Upload File"><i class="fa fa-gear"></i><span class="ml-1">Setting</span></a>
                        <?php endif; ?>
                    </div> -->
            </div>

            <div class="col-md-8 mb-4">
                <div class="text-muted fw-semibold mb-2"></div>

                <?php
                $path_files = json_decode($detail['path_file'], true);
                $file_names = json_decode($detail['file'], true);


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
    <!-- <div> -->
    <!-- </div> -->
</div>
<hr class="m-1">
</div>
<script>
    $(document).ready(function() {
        $("#tabel").addClass('hilang');
        $(document).on('shown.bs.tab', 'a[data-bs-toggle="tab"]', function(e) {
            var anchor = $(e.target).attr('href');
            if (anchor == '#tabs-header-8' && $("#tabel").hasClass('hilang')) {
                $("#syncloader").removeClass('hilang');
                $("#tabel").addClass('hilang');
                setTimeout(() => {
                    var det = $("#iddet").val();
                    getdatadetail(det);
                }, 500);
            }
        })
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

    function getdatadetail(det) {
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url + 'bckeluar/loaddatadetail',
            data: {
                id: det,
            },
            success: function(data) {
                $("#syncloader").addClass('hilang');
                $("#tabel").removeClass('hilang');
                $("#body-table").html(data.datagroup).show();
            },
            error: function(xhr, ajaxOptions, thrownError) {
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