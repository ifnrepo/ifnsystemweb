<div class="page-body">
    <div class="container-xl d-flex flex-column justify-content-center">
        <div class="empty">
            <div class="mb-6"><img src="<?= base_url() . "assets/image/logodepanK.png" ?>" width="350" height="50" alt="">
            </div>
            <p class="empty-title mb-3">Halaman tidak ditemukan</p>
            <p class="empty-subtitle text-secondary" style="line-height:10px">
            <!-- Try adjusting your search or filter to find what you're looking for. -->
             <?= base_url(uri_string()); ?>
             <p class="text-secondary" style="font-size: 14px">----------</p>
            </p>
            <div class="empty-action">
            <a href="<?= base_url(); ?>" class="btn btn-primary">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg> -->
                Kembali ke Home
            </a>
            </div>
        </div>
    </div>
</div>