<div class="container-xl">
    <div class="row mb-1">
        <div class="col-4 text-primary font-bold">
            <span>Nomor</span>
            <h4 class="mb-1"><?= $header['nomor_dok']; ?></h4>
        </div>
        <div class="col-4 text-primary font-bold">
            <span>Tanggal</span>
            <h4 class="mb-1"><?= tglmysql($header['tgl']); ?></h4>
        </div>
        <div class="col-4 text-primary font-bold">
            <span>Dibuat Oleh</span>
            <h4 class="mb-1"><?= datauser($header['user_ok'], 'name') . ' (' . $header['tgl_ok'] . ')' ?></h4>
        </div>
    </div>
    <hr class='m-1'>
    <div class="card card-lg">
        <div class="card-body p-2">
            <table class="table datatable6 table-hover" id="cobasisip">
                <thead style="background-color: blue !important">
                    <tr>
                        <th>Specific</th>
                        <th>SKU</th>
                        <th>Satuan</th>
                        <th>Qty</th>
                        <th>Kgs</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                    <?php foreach ($detail as $val) { ?>
                        <tr>
                            <td><?= $val['nama_barang']; ?></td>
                            <td><?= $val['brg_id']; ?></td>
                            <td><?= $val['namasatuan']; ?></td>
                            <td><?= rupiah($val['pcs'], 0); ?></td>
                            <td><?= rupiah($val['kgs'], 2); ?></td>
                            <td>
                                <a href="<?= base_url() . 'bbl/editone_detail/' . $val['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="Edit detail Bbl" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Edit detail Bbl" rel="<?= $val['id']; ?>" title="Edit data">
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusnettype" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'bbl/hapusone_detail/' . $val['id']; ?>" title="Hapus data">
                                    <i class="fa fa-trash-o"></i>
                                </a>
                            </td>

                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="font-bold font-italic" style="text-align: right;">Jumlah Item Barang : <?= $header['jumlah_barang']; ?></div>
        </div>
    </div>
    <hr class="m-1">
    <div class="row mb-1">
        <div class="col-4 text-primary font-bold">
        </div>
        <div class="col-4 text-primary font-bold">

        </div>
        <?php $bgr = $header['ketcancel'] == null ? "text-primary" : "text-danger"; ?>
    </div>
    <hr class="m-1">
</div>