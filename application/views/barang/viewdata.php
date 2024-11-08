<div class="page-body">
    <div class="container-xl">
        <div class="card-body ">
            <div class="col-md-8 mb-3" style="margin-left: 110px;">
                <div class="ribbon ribbon-top bg-blue"><!-- Download SVG icon from http://tabler-icons.io/i/star -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 17.75l-6.172 3.245l1.179 -6.873l-5 -4.867l6.9 -1l3.086 -6.253l3.086 6.253l6.9 1l-5 4.867l1.179 6.873z" />
                    </svg>
                    <!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="currentColor" class="icon icon-tabler icons-tabler-filled icon-tabler-star">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M8.243 7.34l-6.38 .925l-.113 .023a1 1 0 0 0 -.44 1.684l4.622 4.499l-1.09 6.355l-.013 .11a1 1 0 0 0 1.464 .944l5.706 -3l5.693 3l.1 .046a1 1 0 0 0 1.352 -1.1l-1.091 -6.355l4.624 -4.5l.078 -.085a1 1 0 0 0 -.633 -1.62l-6.38 -.926l-2.852 -5.78a1 1 0 0 0 -1.794 0l-2.853 5.78z" />
                    </svg> -->
                </div>
                <div class="card" style="border: 1px solid grey ; margin-top :50 px ;">
                    <?php
                    $path = 'assets/image/dokbar/';
                    $foto = (empty(trim($data['filefoto'])) || !file_exists(FCPATH . $path . $data['filefoto']))
                        ? $path . 'image.jpg'
                        : $path . $data['filefoto'];
                    $foto_url = base_url($foto) . '?t=' . time();
                    ?>
                    <div class="card-body d-flex align-items-center">
                        <img src="<?= $foto_url; ?>" alt="Foto" style="width: 180px;  object-fit: cover; margin-right: 15px; border-radius: 5px;">
                        <div>
                            <p><strong>Kode:</strong> <?= $data['kode']; ?></p>
                            <p><strong>Nama :</strong> <?= $data['nama_barang']; ?></p>
                            <p><strong>Ukuran:</strong> <?= $data['ukuran']; ?></p>
                            <p><strong>Tipe:</strong> <?= $data['tipe']; ?></p>
                            <p><strong>Merek:</strong> <?= $data['merek']; ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>