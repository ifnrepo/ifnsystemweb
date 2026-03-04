<style>
    .hover-lift {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .hover-lift:hover {
        transform: translateY(-5px);
        box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
    }

    .form-select-sm {
        cursor: pointer;
    }

    .card-body h3 {
        letter-spacing: -1px;
    }
</style>



<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    <?= $title; ?>
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <!-- <a href="<?= base_url() . 'agama/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Agama"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a> -->
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">

        <div class="card">
            <div class="card-body">
                <div class="card border-0 shadow-sm mb-4">
                    <!-- <div class="card-body">
                        <div class="row">
                            <div class="col-lg-2">
                                <label class="font-kecil font-bold text-azure text-primary" st>Bulan</label>
                                <select name="filter_bulan" id="filter_bulan" class="form-select font-kecil mt-0">
                                    <option value="all" <?= $filter_bulan == 'all' ? 'selected' : '' ?>>Semua Bulan</option>
                                    <?php foreach ($bulan_options as $bl) : ?>
                                        <?php if (!empty($bl['bulan']) && !empty($bl['nama_bulan'])) : ?>
                                            <option value="<?= $bl['bulan']; ?>" <?= ($filter_bulan == $bl['bulan'] || ($filter_bulan == 'all' && $bln_sekarang == $bl['bulan'])) ? 'selected' : '' ?>>
                                                <?= $bl['nama_bulan']; ?>
                                            </option>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="font-kecil font-bold text-azure text-primary">Tahun</label>
                                <select name="filter_tahun" id="filter_tahun" class="form-select font-kecil mt-0">
                                    <option value="all" <?= $filter_tahun == 'all' ? 'selected' : '' ?>>Semua Tahun</option>
                                    <?php foreach ($tahun_options as $th) : ?>
                                        <option value="<?= $th['tahun']; ?>" <?= ($filter_tahun == $th['tahun'] || ($filter_tahun == 'all' && $thn_sekarang == $th['tahun'])) ? 'selected' : '' ?>>
                                            <?= $th['tahun']; ?></option>
                                    <?php endforeach; ?>
                                </select>

                            </div>

                        </div>
                        <div class="text-right">
                            <a href="<?= base_url('rfid_out') ?>" class="btn btn-primary btn-sm">
                                <i class="fa fa-refresh"></i>
                                <span class="ms-1">Refresh</span>
                            </a>
                        </div>
                        <div class="row align-items-end g-3">
                            <div class="col-12 col-sm-6 col-md-2">
                                <label class="form-label fw-bold text-primary small">Pilih PLNO</label>
                                <select name="filter" id="filter" class="form-select form-select-sm">
                                    <option value="all" <?= $filter_pl == 'all' ? 'selected' : '' ?>>Semua</option>
                                    <?php foreach ($plno as $no) : ?>
                                        <option value="<?= $no['plno']; ?>" <?= $filter_pl == $no['plno'] ? 'selected' : '' ?>>
                                            <?= $no['plno']; ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-12 col-sm-6 col-md-2">
                                <label class="form-label fw-bold text-primary small">Pilih Exdo</label>
                                <select name="filter_exdo" id="filter_exdo" class="form-select form-select-sm">
                                    <option value="all" <?= $filter_exdo == 'all' ? 'selected' : '' ?>>Semua</option>
                                    <option value="EXPORT" <?= $filter_exdo == 'EXPORT' ? 'selected' : '' ?>>EXPORT</option>
                                    <option value="DOMESTIC" <?= $filter_exdo == 'DOMESTIC' ? 'selected' : '' ?>>DOMESTIC</option>
                                </select>
                            </div>



                            <div class="col-12 col-sm-6 col-md-2">
                                <label class="form-label fw-bold text-primary small">Cek Masuk</label>
                                <select name="filter_cekmasuk" id="filter_cekmasuk" class="form-select form-select-sm">
                                    <option value="all" <?= $filter_cekmasuk == 'all' ? 'selected' : '' ?>>Semua</option>
                                    <option value="0" <?= $filter_cekmasuk == 0 ? 'selected' : '' ?>>Waiting</option>
                                    <option value="1" <?= $filter_cekmasuk == 1 ? 'selected' : '' ?>>Verified</option>
                                </select>
                            </div>

                            <div class="col-12 col-sm-6 col-md-2">
                                <label class="form-label fw-bold text-primary small">Cek Selesai</label>
                                <select name="filter_selesai" id="filter_selesai" class="form-select form-select-sm">
                                    <option value="all" <?= $filter_selesai == 'all' ? 'selected' : '' ?>>Semua</option>
                                    <option value="0" <?= $filter_selesai == 0 ? 'selected' : '' ?>>Waiting</option>
                                    <option value="1" <?= $filter_selesai == 1 ? 'selected' : '' ?>>Complete</option>
                                </select>
                            </div>

                            <div class="col-12 col-md-4">
                                <div class="d-flex justify-content-md-end gap-2">

                                    <a href="<?= base_url() . 'rfid_out/excel'; ?>" class="btn btn-success btn-sm">
                                        <i class="fa fa-file-excel-o"></i>
                                        <span class="ms-1">Export To Excel</span>
                                    </a>

                                    <a href="<?= base_url() . 'rfid_out/pdf'; ?>" target="_blank" class="btn btn-danger btn-sm">
                                        <i class="fa fa-file-pdf-o"></i>
                                        <span class="ms-1">Export To PDF</span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <hr class="opacity-50 mb-4">

                        <div class="row g-3 mb-4">
                            <div class="col-6 col-md-3">
                                <div class="p-3 border-start border-primary border-4 bg-light rounded shadow-sm">

                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <small class="text-muted d-block mb-1">Total Record</small>
                                            <h5 class="fw-bold text-primary mb-0" id="totalFiltered">0</h5>
                                        </div>
                                        <div class="text-end" style="font-size: 10px;">
                                            <p class="fw-bold text-warning mb-0">
                                                Verified : <span id="total_cekmasuk"></span>
                                            </p>
                                            <p class="fw-bold text-success mb-0">
                                                Complete : <span id="total_cekselesai"></span>
                                            </p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 border-start border-success border-4 bg-light rounded shadow-sm">
                                    <small class="text-muted d-block mb-1">Total Pcs</small>
                                    <h5 class="fw-bold text-success mb-0" id="total_pcs">0</h5>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 border-start border-info border-4 bg-light rounded shadow-sm">
                                    <small class="text-muted d-block mb-1">Total Berat</small>
                                    <h5 class="fw-bold text-info mb-0" id="total_nw">0</h5>
                                </div>
                            </div>
                            <div class="col-6 col-md-3">
                                <div class="p-3 border-start border-warning border-4 bg-light rounded shadow-sm">
                                    <small class="text-muted d-block mb-1">Total Meas</small>
                                    <h5 class="fw-bold text-warning mb-0" id="total_meas">0</h5>
                                </div>
                            </div>
                        </div>
                    </div> -->

                    <div class="card-body bg-white rounded-3 shadow-sm">
                        <div class="row g-3 mb-4">
                            <div class="col-lg-4">
                                <div class="p-3 border rounded-3 bg-light">
                                    <div class="row g-2">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fa fa-calendar me-2"></i>
                                            <span class="fw-bold text-muted small uppercase">Periode Container IN</span>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold text-primary small">Bulan</label>
                                            <select name="filter_bulan" id="filter_bulan" class="form-select form-select-sm border-0 shadow-sm">
                                                <option value="all" <?= $filter_bulan == 'all' ? 'selected' : '' ?>>Semua Bulan</option>
                                                <?php foreach ($bulan_options as $bl) : ?>
                                                    <?php if (!empty($bl['bulan']) && !empty($bl['nama_bulan'])) : ?>
                                                        <option value="<?= $bl['bulan']; ?>" <?= ($filter_bulan == $bl['bulan'] || ($filter_bulan == 'all' && $bln_sekarang == $bl['bulan'])) ? 'selected' : '' ?>>
                                                            <?= $bl['nama_bulan']; ?>
                                                        </option>
                                                    <?php endif; ?>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label fw-bold text-primary small">Tahun</label>
                                            <select name="filter_tahun" id="filter_tahun" class="form-select form-select-sm border-0 shadow-sm">
                                                <option value="all" <?= $filter_tahun == 'all' ? 'selected' : '' ?>>Semua Tahun</option>
                                                <?php foreach ($tahun_options as $th) : ?>
                                                    <option value="<?= $th['tahun']; ?>" <?= ($filter_tahun == $th['tahun'] || ($filter_tahun == 'all' && $thn_sekarang == $th['tahun'])) ? 'selected' : '' ?>>
                                                        <?= $th['tahun']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                            <!-- <input type="number" class="form-control font-kecil mt-0" name="filter_tahun" id="filter_tahun" value="<?= $filter_tahun == 'all' ? $thn_sekarang : $filter_tahun; ?>"> -->

                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-8">
                                <div class="p-3 border rounded-3 bg-light h-100 shadow-sm">
                                    <div class="row g-2 mb-3">
                                        <div class="d-flex align-items-center mb-2">
                                            <i class="fa fa-barcode text-black me-2"></i>
                                            <span class="fw-bold text-muted small uppercase">Filter Bale Number</span>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label fw-bold text-primary small">Pilih PLNO</label>
                                            <select name="filter" id="filter" class="form-select form-select-sm border-0 shadow-sm">
                                                <option value="all" <?= $filter_pl == 'all' ? 'selected' : '' ?>>Semua</option>
                                                <?php foreach ($plno as $no) : ?>
                                                    <option value="<?= $no['plno']; ?>" <?= $filter_pl == $no['plno'] ? 'selected' : '' ?>>
                                                        <?= $no['plno']; ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label fw-bold text-primary small mb-1">Exdo</label>
                                            <select name="filter_exdo" id="filter_exdo" class="form-select form-select-sm border-0 shadow-sm">
                                                <option value="all" <?= $filter_exdo == 'all' ? 'selected' : '' ?>>Semua</option>
                                                <option value="EXPORT" <?= $filter_exdo == 'EXPORT' ? 'selected' : '' ?>>EXPORT</option>
                                                <option value="DOMESTIC" <?= $filter_exdo == 'DOMESTIC' ? 'selected' : '' ?>>DOMESTIC</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label fw-bold text-primary small mb-1">Cek Masuk</label>
                                            <select name="filter_cekmasuk" id="filter_cekmasuk" class="form-select form-select-sm border-0 shadow-sm">
                                                <option value="all" <?= $filter_cekmasuk == 'all' ? 'selected' : '' ?>>Semua</option>
                                                <option value="0" <?= $filter_cekmasuk == 0 ? 'selected' : '' ?>>Waiting</option>
                                                <option value="1" <?= $filter_cekmasuk == 1 ? 'selected' : '' ?>>Verified</option>
                                            </select>
                                        </div>
                                        <div class="col-3">
                                            <label class="form-label fw-bold text-primary small mb-1">Cek Selesai</label>
                                            <select name="filter_selesai" id="filter_selesai" class="form-select form-select-sm border-0 shadow-sm">
                                                <option value="all" <?= $filter_selesai == 'all' ? 'selected' : '' ?>>Semua</option>
                                                <option value="0" <?= $filter_selesai == 0 ? 'selected' : '' ?>>Waiting</option>
                                                <option value="1" <?= $filter_selesai == 1 ? 'selected' : '' ?>>Complete</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="d-flex flex-column flex-md-row justify-content-md-end gap-2 mt-3">
                                        <a href="<?= base_url('rfid_out') ?>" class="btn btn-primary btn-sm px-3 rounded-2 shadow-sm">
                                            <i class="fa fa-refresh me-1"></i> Refresh
                                        </a>
                                        <a href="<?= base_url() . 'rfid_out/excel'; ?>" class="btn btn-success btn-sm px-3 rounded-2 shadow-sm">
                                            <i class="fa fa-file-excel-o me-1"></i> Excel
                                        </a>
                                        <a href="<?= base_url() . 'rfid_out/pdf'; ?>" target="_blank" class="btn btn-danger btn-sm px-3 rounded-2 shadow-sm">
                                            <i class="fa fa-file-pdf-o me-1"></i> PDF
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-md-3">
                                <div class="card border-0 border-bottom border-primary border-4 shadow-sm h-10 hover-lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-bold fw-bold mb-0">Total Record</h6>
                                            <div class="bg-primary bg-opacity-10 p-2 rounded">
                                                <i class="fa fa-list text-white"></i>
                                            </div>
                                        </div>
                                        <div class="d-flex align-items-end justify-content-between">
                                            <h3 class="fw-bold mb-0 text-dark" id="totalFiltered">0</h3>
                                            <div class="text-end small">
                                                <span class="d-block text-warning fw-bold">Verified: <span id="total_cekmasuk">0</span></span>
                                                <span class="d-block text-success fw-bold">Complete: <span id="total_cekselesai">0</span></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card border-0 border-bottom border-success border-4 shadow-sm h-100 hover-lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-bold fw-bold mb-0">Total Pcs</h6>
                                            <div class="bg-success bg-opacity-10 p-2 rounded">
                                                <i class="fa fa fa-tags text-white "></i>
                                            </div>
                                        </div>
                                        <h3 class="fw-bold mb-0 text-dark" id="total_pcs">0</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card border-0 border-bottom border-info border-4 shadow-sm h-100 hover-lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-bold fw-bold mb-0">Total Berat</h6>
                                            <div class="bg-info bg-opacity-10 p-2 rounded">
                                                <i class="fa fa-balance-scale text-white"></i>
                                            </div>
                                        </div>
                                        <h3 class="fw-bold mb-0 text-dark" id="total_nw">0</h3>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="card border-0 border-bottom border-warning border-4 shadow-sm h-100 hover-lift">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h6 class="text-bold fw-bold mb-0">Total Meas</h6>
                                            <div class="bg-warning bg-opacity-10 p-2 rounded">
                                                <i class="fa fa-truck text-white"></i>
                                            </div>
                                        </div>
                                        <h3 class="fw-bold mb-0 text-dark" id="total_meas">0</h3>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="table-responsive">
                    <table id="container-table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Plno</th>
                                <th>PO</th>
                                <!-- <th>Exdo</th> -->
                                <th>Spek</th>
                                <th>Pcs</th>
                                <th>Item</th>
                                <th>No Bale</th>
                                <th>Berat</th>
                                <th>Meas</th>
                                <th>Cek Masuk</th>
                                <th>Cek Selesai</th>
                                <!-- <th>Aksi</th> -->
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="confirmModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title">Konfirmasi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin menyetujui data ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <button type="button" class="btn btn-success" id="confirmApprove">Ya, Setuju</button>
            </div>
        </div>
    </div>
</div>

<div class="modal modal-blur fade" id="modal-verifikasi" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            <div class="modal-status bg-primary"></div>
            <div class="modal-body text-center py-4">
                <svg class="icon mb-2 text-primary icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
                    <path d="M12 9v4" />
                    <path d="M12 17h.01" />
                </svg>
                <h3>Haii,</h3>
                <div class="text-secondary" id="message">Anda Menyetujui Data Ini ?</div>
            </div>
            <div class="modal-footer">
                <div class="w-100">
                    <div class="row">
                        <div class="col"><a id="btn-okverifikasi" href="#" class="btn btn-primary w-100">
                                Ya
                            </a></div>
                        <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                                Tidak
                            </a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>assets/js/vendor/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/jquery/jquery-ui.min.js"></script>

<script>
    $(function() {

        // $(document).on('click', '.verifikasi', function() {
        //     var url = $(this).data("url");
        //     $("#confirmApprove").attr("href", url);
        //     $("confirmModal").modal("show");
        // });

        $(document).on('click', '.verifikasi', function() {
            var url = $(this).data("url");
            $("#btn-okverifikasi").attr("href", url);
            $("#modal-verifikasi").modal("show");
        });

    });
</script>
<script>
    $(document).ready(function() {

        var table = $('#container-table').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "<?= base_url('rfid_out/filter_data') ?>",
                type: "POST",
                data: function(d) {

                    d.filter = $('#filter').val();
                    d.filter_exdo = $('#filter_exdo').val();
                    d.filter_cekmasuk = $('#filter_cekmasuk').val();
                    d.filter_selesai = $('#filter_selesai').val();
                    d.filter_bulan = $('#filter_bulan').val();
                    d.filter_tahun = $('#filter_tahun').val();

                }
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'plno'
                },
                {
                    data: 'po'
                },
                // {
                //     data: 'exdo'
                // },
                {
                    data: 'spek'
                },
                {
                    data: 'pcs'
                },
                {
                    data: 'item'
                },
                {
                    data: 'nobale'
                },
                {
                    data: 'berat'
                },
                {
                    data: 'meas'
                },
                {
                    data: 'masuk'
                },
                {
                    data: 'selesai'
                },
                // {
                //     data: 'aksi'
                // },
            ],

        });
        table.on('xhr.dt', function(e, settings, json) {
            $('#totalFiltered').text(json.recordsFiltered);
            $('#total_cekmasuk').text(json.total_cekmasuk);
            $('#total_cekselesai').text(json.total_cekselesai);
            $("#total_nw").text(json.total_nw);
            $("#total_pcs").text(json.total_pcs);
            $("#total_meas").text(json.total_meas);
        });

        $('#filter_bulan, #filter_tahun').change(function() {
            location.reload();
        });

        $('#filter, #filter_exdo, #filter_cekmasuk, #filter_selesai, #filter_bulan, #filter_tahun').change(function() {
            table.ajax.reload();
        });
    });
</script>