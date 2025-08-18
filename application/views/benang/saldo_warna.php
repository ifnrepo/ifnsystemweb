<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <br>
                <!-- <h2> <?= $judul; ?></h2> -->
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'benang'; ?>" class="btn btn-warning btn-sm"><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>


</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">

                <div class="row">
                    <div class="col-md-6">
                        Jenis : <?= $title; ?> <br>
                        Nomor Dokumen : <?= $header['nomor_dok']; ?> <br>
                    </div>
                    <div class="col-md-6">
                        Satuan : <?= $header['kodesatuan']; ?> <br>
                        Lokasi Rak : <?= $header['lokasi_rak']; ?>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-3">
                        <label class="font-kecil font-bold text-azure text-primary" st>Bulan</label>
                        <input type="hidden" name="id_header" id="id_header" value="<?= $id_header; ?>">
                        <input type="hidden" name="warna_benang" id="warna_benang" value="<?= $warna_benang; ?>">
                        <select name="filter_bulan" id="filter_bulan" class="form-select font-kecil mt-0">
                            <?php
                            $nama_bulan = [
                                '01' => 'Januari',
                                '02' => 'Februari',
                                '03' => 'Maret',
                                '04' => 'April',
                                '05' => 'Mei',
                                '06' => 'Juni',
                                '07' => 'Juli',
                                '08' => 'Agustus',
                                '09' => 'September',
                                '10' => 'Oktober',
                                '11' => 'November',
                                '12' => 'Desember'
                            ];
                            $bulan_sekarang = date('m');

                            foreach ($nama_bulan as $val => $label) {
                                $selected = ($val == $bulan_sekarang) ? 'selected' : '';
                                echo "<option value='$val' $selected>$label</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="font-kecil font-bold text-azure text-primary">Tahun</label>
                        <select name="filter_tahun" id="filter_tahun" class="form-select font-kecil mt-0">
                            <?php
                            $tahun_sekarang = date('Y');
                            $mulai_tahun = 2025;
                            $akhir_tahun = $tahun_sekarang + 3; // sampai 3 tahun ke depan

                            for ($tahun = $mulai_tahun; $tahun <= $akhir_tahun; $tahun++) {
                                $selected = ($tahun == $tahun_sekarang) ? 'selected' : '';
                                echo "<option value='$tahun' $selected>$tahun</option>";
                            }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="row font-kecil">
                    <div class="col-md-12">
                        <div id=" table-default" class="table-responsive">
                            <table id="tabel-saldo" class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Warna Benang</th>
                                        <th>Spek Benang</th>
                                        <th>Saldo Akhir</th>
                                        <th>Periode</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= base_url(); ?>assets/js/vendor/jquery.min.js"></script>
<script>
    function loadData() {
        $.ajax({
            url: "<?= base_url('benang/filter_saldo') ?>",
            type: "POST",
            data: {
                id_header: $('#id_header').val(),
                warna_benang: $('#warna_benang').val(),
                bulan: $('#filter_bulan').val(),
                tahun: $('#filter_tahun').val()
            },
            success: function(html) {
                $('#tabel-saldo tbody').html(html);
            }
        });
    }

    loadData();

    $('#id_header, #warna_benang, #filter_bulan, #filter_tahun').change(function() {
        loadData();
    });
</script>



<!-- <script>
    $(document).ready(function() {
        var table = $('#saldo').DataTable({
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: {
                url: "<?= base_url('benang/filter_saldo') ?>",
                type: "POST",
                data: function(d) {
                    d.id_header = $('#id_header').val();
                    d.warna_benang = $('#warna_benang').val();
                    d.bulan = $('#filter_bulan').val();
                    d.tahun = $('#filter_tahun').val();
                }
            },
            columns: [{
                    data: 'no'
                },
                {
                    data: 'namabarang'
                },
                {
                    data: 'total'
                }

            ],

        });

        $('#id_header, #warna_benang, #filter_bulan, #filter_tahun').change(function() {
            table.ajax.reload();
        });

    });
</script> -->

<!-- <script>
    $(document).ready(function() {
        var table = $('#myTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "<?= site_url('benang/getDataAjax'); ?>",
                type: "POST",
                data: function(d) {
                    d.id_header = $('#id_header').val();
                    d.warna_benang = $('#warna_benang').val();
                    d.bulan = $('#filter_bulan').val();
                    d.tahun = $('#filter_tahun').val();
                }
            },
            columns: [{
                    data: 'nama_barang'
                },
                {
                    data: 'kgs_akhir'
                },

            ]
        });

        // Reload table saat filter berubah
        $('#id_header, #warna_benang, #filter_bulan, #filter_tahun').change(function() {
            table.ajax.reload();
        });
    });
</script> -->