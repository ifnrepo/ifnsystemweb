<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<div class="page-body">
    <div class="container-xl">
        <div class="row">
            <div class="col-md-6">
                Jenis : <?= $title; ?> <br>
                Periode Saldo : <?= format_bulan_tahun($periode); ?> <br>
                Nomor Dokumen : <?= $header['nomor_dok']; ?> <br>
            </div>
            <div class="col-md-6">
                Spek Barang : <?= $header['nama_barang']; ?> <br>
                Satuan : <?= $header['kodesatuan']; ?> <br>
                Lokasi Rak : <?= $header['lokasi_rak']; ?>
            </div>
        </div>
        <div class="card-body m-3">
            <div class="row font-kecil">
                <div class="col-md-12">
                    <div id="table-default" class="table-responsive">
                        <table class="table table-vcenter card-table">
                            <thead>
                                <tr>
                                    <th style="text-align: center;">No</th>
                                    <th style="text-align: center;">Tanggal</th>
                                    <th style="text-align: center;">Jam</th>
                                    <th style="text-align: center;">Jamlah Berat</th>
                                    <th style="text-align: center;">Keterangan</th>
                                    <th style="text-align: center;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="table-tbody" style="font-size: 13px !important;">
                                <?php $no = 0;
                                $total = 0;
                                foreach ($saldo_masuk as $key) : $no++;
                                    $total += $key['jumlah'];
                                ?>
                                    <tr>
                                        <td style="text-align: center;"><?= $no; ?></td>
                                        <td style="text-align: center;"><?= format_tanggal_indonesia($key['tanggal']); ?></td>
                                        <td style="text-align: center;"><?= $key['jam']; ?></td>
                                        <td style="text-align: center;"><?= $key['jumlah']; ?></td>
                                        <td style="text-align: center;"><?= $key['keterangan']; ?></td>
                                        <td style="text-align: center;">
                                            <!-- <a href="<?= base_url() . 'agama/edit/' . $key['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="editgrup" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Edit Data Agama" rel="<?= $key['id']; ?>" title="Edit data">
                                                <i class="fa fa-edit"></i>
                                            </a> -->
                                            <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusnettype" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'benang/hapus_saldo_masuk/' . $key['id'] . '/' . $key['tanggal'] . '/' . $key['jumlah'] . '/' . $tb_detail_id . '/' . $id_barang; ?>" title="Hapus data">
                                                <i class="fa fa-trash-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                <tr>
                                    <td colspan="3" style="text-align: center; color:red;">Total Saldo Masuk </td>
                                    <td style="text-align : center ;"><?= number_format($total, 2, '.', ','); ?></td>

                                </tr>
                            </tbody>
                        </table>
                        <br>
                        <h3><span>Pemeriksa : Bapak Atang</span></h3>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>