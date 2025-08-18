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
                                    <th>TANGGAL</th>
                                    <th>KETERANGAN</th>
                                    <th>JENIS</th>
                                    <th>JUMLAH</th>
                                    <th>SALDO SEBELUMNYA</th>
                                    <th>SALDO AKHIR</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 0;
                                foreach ($saldo as $row) : $no++; ?>
                                    <tr>
                                        <td style="color: <?= ($row->jenis == 'KELUAR') ? 'red' : 'black'; ?>;">
                                            <?= format_tanggal_indonesia($row->tanggal)  ?: '-' ?>
                                        </td>
                                        <td style="color: <?= ($row->jenis == 'KELUAR') ? 'red' : 'black'; ?>;">
                                            <?= $row->keterangan ?: '-' ?>
                                        </td>
                                        <td style="color: <?= ($row->jenis == 'KELUAR') ? 'red' : 'black'; ?>;">
                                            <?= $row->jenis; ?>
                                        </td>
                                        <td style="color: <?= ($row->jenis == 'KELUAR') ? 'red' : 'black'; ?>;">
                                            <?= $row->jumlah ? number_format($row->jumlah, 2, '.', '.') : '-' ?>
                                        </td>

                                        <td style="color: <?= ($row->jenis == 'KELUAR') ? 'red' : 'black'; ?>;">
                                            <?= $row->saldo_sebelumnya ? number_format($row->saldo_sebelumnya, 2, '.', '.') : '-' ?>
                                        </td>
                                        <td style="color: <?= ($row->jenis == 'KELUAR') ? 'red' : 'black'; ?>;">
                                            <?= $row->saldo_akhir ? number_format($row->saldo_akhir, 2, '.', '.') : '-' ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
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