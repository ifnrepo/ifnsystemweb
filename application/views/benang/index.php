<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Inventory Benang
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'benang/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Rak"><i class="fa fa-plus"></i><span class="ml-1">Tambah Rak</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="row font-kecil">
                    <!-- <div class="col-md-3" style="overflow-y: auto; height:400px ;"> -->
                    <div class="col-md-3" style="overflow-y: auto; height:400px ;">
                        <div id="table-default" class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th>Rak</th>
                                        <th>No Dok</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody" style="font-size: 13px !important;">
                                    <?php $no = 0;
                                    foreach ($benang as $key) : $no++; ?>
                                        <tr>
                                            <!-- <td><?= $no; ?></td> -->
                                            <td><?= $key['lokasi_rak']; ?></td>
                                            <td>
                                                <a href="javascript:void(0)" class="detail-link" data-id="<?= $key['id']; ?>" style="text-decoration: underline;">
                                                    <?= $key['nomor_dok']; ?>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <a class="btn btn-outline-primary dropdown-toggle font-kecil" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="bi bi-pencil-square"></i>
                                                    </a>
                                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                                                        <li>
                                                            <a href="<?= base_url('benang/tambah_spek/' . $key['id']); ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple">
                                                                <i class="fa fa-plus"></i> <span class="ml-1">Tambah Spek Benang</span>
                                                            </a>
                                                        </li>
                                                        <!-- <li>
                                                            <a class="btn btn-sm btn-danger btn-icon text-white" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'benang/hapus/' . $key['id']; ?>" title="Hapus data">
                                                                <i class="fa fa-trash-o"></i> Hapus Data
                                                            </a>
                                                        </li> -->
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-4" style="overflow-y: auto; height:400px ;">
                        <div id="table-default" class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th style="text-align: left;">Rak</th>
                                        <th style="text-align: left;">Warna Benang</th>
                                        <th style="text-align: left;">Satuan</th>
                                    </tr>
                                </thead>
                                <tbody id="detail-tbody">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="col-md-5" style="overflow-y: auto; height:400px ;">
                        <div id="table-default" class="table-responsive">
                            <table class="table table-vcenter card-table">
                                <thead>
                                    <tr>
                                        <th style="text-align: left;">No</th>
                                        <th style="text-align: left;">Spek Benang</th>
                                        <th style="text-align: left;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="detail_warna-tbody">

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
    $(document).ready(function() {

        var firstEvent = $('.detail-link').first();
        if (firstEvent.length) {
            var firstId = firstEvent.data('id');
            loadDetail(firstId);
        }

        $(document).on('click', '.detail-link', function() {
            var id = $(this).data('id');
            loadDetail(id);
        });

        // function loadDetail(id) {
        //     $('#detail_warna-tbody').html('');

        //     $.ajax({
        //         url: '<?= base_url("benang/get_detail/"); ?>' + id,
        //         method: 'GET',
        //         dataType: 'json',
        //         success: function(data) {
        //             var html = '';
        //             if (data.length > 0) {
        //                 let no = 1;
        //                 const detail_saldo = "<?= base_url('benang/saldo_detail/') ?>";
        //                 data.forEach(function(item) {
        //                     html += `
        //             <tr>
        //                 <td style="text-align: left;">${item.lokasi_rak}</td>
        //                 <td class="view-detail-warna" data-warna="${item.warna_benang}" style="text-decoration: underline; cursor: pointer; color:red ;">
        //                     ${item.warna_benang}
        //                     </td>
        //                 <td style="text-align: left;">${item.kodesatuan}</td>
        //                 <td>
        //                     <a href="${detail_saldo}${item.id_header}/${item.warna_benang}" class="btn btn-sm btn-info">Saldo</a>
        //                 </td>
        //             </tr>
        //         `;
        //                 });
        //             } else {
        //                 html = '<tr><td colspan="5" class="text-center text-muted">Data tidak ditemukan</td></tr>';
        //             }
        //             $('#detail-tbody').html(html);
        //         },
        //         error: function(xhr, status, error) {
        //             console.error('Gagal load detail:', error);
        //             alert('Gagal mengambil data detail. Silakan coba lagi.');
        //         }
        //     });
        // }
        function loadDetail(id) {
            $('#detail_warna-tbody').html('');

            $.ajax({
                url: '<?= base_url("benang/get_detail/"); ?>' + id,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    var html = '';
                    if (data.length > 0) {
                        let no = 1;
                        const detail_saldo = "<?= base_url('benang/saldo_detail/') ?>";

                        data.forEach(function(item, index) {
                            html += `
                        <tr>
                            <td style="text-align: left;">${item.lokasi_rak}</td>
                            <td class="view-detail-warna" data-warna="${item.warna_benang}" style="text-decoration: underline; cursor: pointer; color:red;">
                                ${item.warna_benang}
                            </td>
                            <td style="text-align: left;">${item.kodesatuan}</td>
                            <td>
                                <a href="${detail_saldo}${item.id_header}/${item.warna_benang}" class="btn btn-sm btn-info">Saldo</a>
                            </td>
                        </tr>
                    `;
                            if (index === 0) {
                                loadDetailWarna(item.warna_benang);
                            }
                        });

                    } else {
                        html = '<tr><td colspan="5" class="text-center text-muted">Data tidak ditemukan</td></tr>';
                    }
                    $('#detail-tbody').html(html);
                },
                error: function(xhr, status, error) {
                    console.error('Gagal load detail:', error);
                    alert('Gagal mengambil data detail. Silakan coba lagi.');
                }
            });
        }



        $(document).on('click', '.view-detail-warna', function() {
            const warna = $(this).data('warna');
            loadDetailWarna(warna);
        });

        function loadDetailWarna(warna) {

            $('#detail_warna-tbody').html('<tr><td colspan="3" class="text-center text-muted">Loading...</td></tr>');

            $.ajax({
                url: '<?= base_url("benang/get_detail_warna/"); ?>' + warna,
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    let html = '';
                    const saldo_masuk = "<?= base_url('benang/saldo_masuk/') ?>";
                    const saldo_keluar = "<?= base_url('benang/saldo_keluar/') ?>";
                    const hapus_spek = "<?= base_url('benang/hapus_spek/') ?>";
                    if (data.length > 0) {
                        let no = 1;
                        data.forEach(function(item) {
                            html += `
                    <tr>
                        <td>${no++}</td>
                        <td>${item.nama_barang}</td>
                        <td>
                        <a href="${saldo_masuk}${item.id}/${item.id_barang}" class="btn btn-sm btn-success">In</a>
                        <a href="${saldo_keluar}${item.id}/${item.id_barang}" class="btn btn-sm btn-warning">Out</a>
                        <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusnettype" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="${hapus_spek}${item.id}" title="Hapus data">
                            Hapus
                        </a>
                        </td>
                    </tr>
                `;
                        });
                    } else {
                        html = '<tr><td colspan="3" class="text-center text-muted">Tidak ada data spek</td></tr>';
                    }
                    $('#detail_warna-tbody').html(html);
                },
                error: function(xhr, status, error) {
                    console.error('Gagal load spek:', error);
                    alert('Gagal mengambil data spek.');
                }
            });
        }


    });
</script>