<div class="container-xl my-3">
    <div class="card">
        <div class="card-body p-2">
            <div class="d-flex justify-content-between">
                <span class="">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-text-check"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M11.537 21h-4.537c-1.105 0 -2 -.895 -2 -2v-14c0 -1.105 .895 -2 2 -2h7l5 5v5.536" /><path d="M9 9l1 0" /><path d="M9 13l6 0" /><path d="M9 17h2.541" /><path d="M15 19l2 2l4 -4" /></svg>
                    Anda Memiliki <span class="text-danger"><?= $datadokumenexp->num_rows() ?> Dokumen BC </span>yang hampir expired masa berlakunya !
                </span>
                <span><a href="<?= base_url().'main/viewnotifbc' ?>">Lihat</a></span>
            </div>
        </div>
    </div>
    <div class="font-11 text-secondary m-0 p-0 text-right">Info : Anda juga bisa melihat notifikasi di kanan atas layar (Tombol Notif).</div>
    <hr class="m-1">
    <div class="d-flex justify-content-between">
        <span class="text-white">-</span>
        <span>
            <button type="button" class="btn btn-sm btn-danger me-auto" data-bs-dismiss="modal">Keluar</button>
        </span>
    </div>
</div>