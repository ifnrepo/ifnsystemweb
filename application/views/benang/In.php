<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Benang Out
                </h2>
                <?= $this->session->flashdata('message'); ?>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url('benang'); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>
</div>
<div class="container-xl p-0">
    <div class="card-header font-kecil">
        <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
            <li class="nav-item">
                <a href="#tabs-home-8" class="nav-link bg-teal-lt active btn-flat" data-bs-toggle="tab">View Dokumen</a>
            </li>
        </ul>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade active show p-2" id="tabs-home-8">
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
                        <div class="row">
                            <div class="col-md-4">
                                <table class="table datatable6 table-hover" id="cobasisip">
                                    <thead style="background-color: blue !important">
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Barang</th>
                                            <th>Saldo Tersedia</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                        <?php $no = 0;
                                        foreach ($saldo_terkini as $key) {
                                            $no++;
                                        ?>
                                            <tr>
                                                <td><?= $no; ?></td>
                                                <td><?= $key['nama_barang']; ?></td>
                                                <td><?= rupiah($key['kgs_akhir'], 2); ?></td>
                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-8">
                                <table class="table datatable6 table-hover" id="cobasisip">
                                    <thead style="background-color: blue !important">
                                        <tr>
                                            <!-- <th>No</th> -->
                                            <th>Specific</th>
                                            <th>SKU</th>
                                            <th>Satuan</th>
                                            <th>Kgs</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                        <?php $no = 0;
                                        foreach ($detail as $val) {
                                            $no++;
                                            $kode = formatsku($val['po'], $val['item'], $val['dis'], $val['id_barang']);
                                            $spek = $val['po'] == '' ? $val['nama_barang'] : spekpo($val['po'], $val['item'], $val['dis']);
                                        ?>
                                            <tr>
                                                <td class="line-12"><?= $no . '. ' . $spek . '<br><span class="font-kecil text-teal">' . $val['insno'] . ' ' . $val['nobontr'] . '</span>'; ?></td>
                                                <td><?= $kode; ?></td>
                                                <td><?= $val['namasatuan']; ?></td>
                                                <td><?= rupiah($val['kgs'], 2); ?></td>
                                                <td><?= $val['keterangan']; ?></td>
                                                <td>
                                                    <?php if ((float)$val['kgs'] == 0) : ?>
                                                        <a href="<?= base_url('benang/edit_in/' . $val['id'] . '/' . $header['dept_id'] . '/' . $header['tgl']); ?>" class="btn btn-sm btn-primary btn-icon text-white" id="editgrup" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Benang Terpakai" rel="<?= $val['id']; ?>" title="Edit data">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    <?php endif; ?>
                                                </td>

                                            </tr>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="font-bold font-italic" style="text-align: left;">Jumlah Item Barang : <?= $header['jumlah_barang']; ?></div>
                                    </div>
                                    <div class="col-md-6">
                                        <button class="btn btn-warning" id="btn-simpan">Simpan</button>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>


            </div>

        </div>
        <hr class="m-1">
    </div>
</div>
<script src="<?= base_url(); ?>assets/js/vendor/jquery.min.js"></script>
<script>
    $(document).ready(function() {

        // $('#btn-simpan').click(function() {
        //     let id_header = "<?= $header['id']; ?>";
        //     let arrData = [];

        //     $('#body-table tr').each(function() {
        //         let id_detail = $(this).find('a#editgrup').attr('rel');
        //         arrData.push(id_detail);
        //     });

        //     $.ajax({
        //         url: "<?= base_url('benang/simpanData_Out'); ?>",
        //         type: "POST",
        //         data: {
        //             id: id_header,
        //             data: arrData
        //         },
        //         dataType: "json",
        //         success: function(res) {
        //             if (res.status == true) {
        //                 window.location.href = "<?= base_url('benang'); ?>";
        //             } else {
        //                 alert("Gagal menyimpan data.");
        //             }
        //         }

        //     });
        // });

        $('#btn-simpan').click(function(e) {
            e.preventDefault(); // cegah submit langsung

            let adaKosong = false;
            $('#body-table tr').each(function() {
                let kgs = parseFloat($(this).find('td[data-kgs]').data('kgs')) || 0;
                if (kgs === 0) {
                    adaKosong = true;
                }
            });

            if (adaKosong) {
                alert("Masih ada data dengan KGS = 0. Silakan edit dulu sebelum simpan.");
                return; // jangan lanjut ajax
            }

            let id_header = "<?= $header['id']; ?>";

            $.ajax({
                url: "<?= base_url('benang/simpanData_Out'); ?>",
                type: "POST",
                data: {
                    id: id_header,

                },
                dataType: "json",
                success: function(res) {
                    if (res.status == true) {
                        window.location.href = "<?= base_url('benang'); ?>";
                    } else {
                        alert("Gagal menyimpan data.");
                    }
                }
            });
        });



    })
</script>