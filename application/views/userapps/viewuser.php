<div class="container-xl"> 
    <div class="row">
        <div class="col-6">
            <div class="card card-active">
                <div class="card-body p-4 text-center">
                <span class="avatar avatar-xl mb-3 rounded" style="background-image: url(./static/avatars/000m.jpg)"></span>
                <h3 class="m-0 mb-1"><a href="#"><?= $user['name']; ?></a></h3>
                <div class="text-secondary"><?= $user['bagian'].' - '.$user['jabatan']; ?></div>
                <div class="mt-3">
                    <?php if($user['aktif']==1){ ?>
                        <span class="badge bg-blue-lt">Aktif</span>
                    <?php }else{ ?>
                        <span class="badge bg-red-lt">Tidak Aktif</span>
                    <?php } ?>
                </div>
                </div>
                <div class="d-flex">
                <!-- <a href="#" class="card-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 7a2 2 0 0 1 2 -2h14a2 2 0 0 1 2 2v10a2 2 0 0 1 -2 2h-14a2 2 0 0 1 -2 -2v-10z" /><path d="M3 7l9 6l9 -6" /></svg>
                    Email</a>
                <a href="#" class="card-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon me-2 text-muted" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 4h4l2 5l-2.5 1.5a11 11 0 0 0 5 5l1.5 -2.5l5 2v4a2 2 0 0 1 -2 2a16 16 0 0 1 -15 -15a2 2 0 0 1 2 -2" /></svg>
                    Call</a> -->
                </div>
            </div>
        </div>
        <div class="col-6">
            <div class="row">
                <div class="col-md-6">
                    <h5>Master Data</h5>
                    <div class="mb-1 font-kecil">
                        <label class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" <?= cekceklis($user['master'],1); ?>>
                            <span class="form-check-label">Satuan</span>
                        </label>
                    </div>
                    <div class="mb-1 font-kecil">
                        <label class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" <?= cekceklis($user['master'],2); ?>>
                            <span class="form-check-label">Kategori Barang</span>
                        </label>
                    </div>
                    <div class="mb-1 font-kecil">
                        <label class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" <?= cekceklis($user['master'],3); ?>>
                            <span class="form-check-label">Barang</span>
                        </label>
                    </div>
                    <div class="mb-1 font-kecil">
                        <label class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" <?= cekceklis($user['master'],4); ?>>
                            <span class="form-check-label">Supplier</span>
                        </label>
                    </div>
                    <div class="mb-1 font-kecil">
                        <label class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" <?= cekceklis($user['master'],5); ?>>
                            <span class="form-check-label">Customer</span>
                        </label>
                    </div>
                </div>
                <div class="col-md-6">
                    <h5>Manajemen User</h5>
                    <div class="mb-1 font-kecil">
                        <label class="form-check mb-1">
                            <input class="form-check-input" type="checkbox" <?= cekceklis($user['manajemen'],1); ?>>
                            <span class="form-check-label">Manajemen User</span>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>