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
                <div class="card card-active mb-2">
                    <div class="row align-items-end g-2" style="margin: 10px;">

                        <div class="col-12 col-md-4 col-lg-3">
                            <label class="font-kecil font-bold text-azure text-primary">Pilih PLNO</label>
                            <select name="filter" id="filter" class="form-select font-kecil">
                                <option value="all" <?= $filter_pl == 'all' ? 'selected' : '' ?>>Semua</option>
                                <?php foreach ($plno as $no) : ?>
                                    <option value="<?= $no['plno']; ?>" <?= $filter_pl == $no['plno'] ? 'selected' : ''  ?>>
                                        <?= $no['plno']; ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>


                        <div class="col-12 col-md-4 col-lg-5"></div>


                        <div class="col-12 col-md-4 col-lg-4 text-md-end">
                            <div class="d-flex flex-wrap gap-2 justify-content-md-end">
                                <a href="<?= base_url() . 'rfid_out/excel'; ?>" class="btn btn-success btn-sm">
                                    <i class="fa fa-file-excel-o"></i>
                                    <span class="ms-1">Export To Excel</span>
                                </a>

                                <a href="<?= base_url() . 'rfid_out/pdf'; ?>" target="_blank" class="btn btn-danger btn-sm">
                                    <i class="fa fa-file-pdf-o"></i>
                                    <span class="ms-1">Export To PDF</span>
                                </a>
                            </div>

                            <div class="mt-2">
                                <span class="text-primary">
                                    Total Record:
                                    <span style="text-decoration:underline;" class="text-danger" id="totalFiltered"></span>
                                </span>
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
                                <th>Item</th>
                                <th>No Bale</th>
                                <th>Berat</th>
                                <th>Status</th>
                                <th>Aksi</th>
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
                    data: 'selesai'
                },
                {
                    data: 'aksi'
                },
            ],
            columnDefs: [{
                targets: 1,
                render: function(data, type, row) {
                    return data;
                }
            }]
        });
        table.on('xhr.dt', function(e, settings, json) {
            $('#totalFiltered').text(json.recordsFiltered);
        });

        $('#filter').change(function() {
            table.ajax.reload();
        });
    });
</script>