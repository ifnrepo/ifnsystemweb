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
                <div class="card card-active mb-2" style="margin: 10px;">
                    <div class="row">
                        <div class="col-lg-3" style="margin-left: 10px;">
                            <label class="font-kecil font-bold text-azure text-primary">Pilih PLNO</label>
                            <select name="filter" id="filter" class="form-select font-kecil mt-0">
                                <option value="all" <?= $filter_pl == 'all' ? 'selected' : '' ?>>Semua</option>
                                <?php foreach ($plno as $no) : ?>
                                    <option value="<?= $no['plno']; ?>" <?= $filter_pl == $no['plno'] ? 'selected' : ''  ?>>
                                        <?= $no['plno']; ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="col-lg-5">

                        </div>
                        <div class="col-lg-3 mt-4 text-right">

                            <a href="<?= base_url() . 'rfid_out/excel'; ?>" class="btn btn-success btn-sm"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export To Excel</span></a>
                            <a href="<?= base_url() . 'rfid_out/pdf'; ?>" target="_blank" class="btn btn-danger btn-sm"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export To PDF</span></a>

                            <span class="text-primary">Total Record: <span style="text-decoration:underline;" class="text-danger" id="totalFiltered"></span></span>
                        </div>
                    </div>


                </div>
                <div class="table-responsive">
                    <table id="container-table" class="table">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Plno</th>
                                <th>Input List</th>
                                <!-- <th>Item</th>
                                <th>No Bale</th> -->
                                <!-- <th>Masuk</th> -->
                                <th>Status</th>
                                <!-- <th>Id Pack</th> -->
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
<script src="<?= base_url(); ?>assets/js/vendor/jquery.min.js"></script>
<script src="<?= base_url(); ?>/assets/js/jquery/jquery-ui.min.js"></script>

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
                // {
                //     data: 'item'
                // },
                // {
                //     data: 'nobale'
                // },
                // {
                //     data: 'masuk'
                // },
                {
                    data: 'selesai'
                },
                // {
                //     data: 'idpack'
                // },
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