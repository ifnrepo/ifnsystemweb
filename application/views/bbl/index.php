<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    BBL (Bon Pembelian Barang)
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url(); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="sticky-top bg-white">
                    <div class="row mb-1 d-flex align-items-between">
                        <div class="col-sm-6">
                            <a href="<?= base_url() . 'bbl/tambahdata'; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Transaksi" class="btn btn-primary btn-sm" id="adddatapb"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
                        </div>
                        <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
                            <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="th" name="th" style="width: 75px;" value="<?= $this->session->userdata('th') ?>">
                            <select class="form-control form-sm font-kecil font-bold mr-1" id="bl" name="bl" style="width: 100px;" <?= $levnow; ?>>
                                <?php for ($x = 1; $x <= 12; $x++) : ?>
                                    <option value="<?= $x; ?>" <?php if ($this->session->userdata('bl') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="card card-active" style="clear:both;">
                        <div class="card-body p-2 font-kecil">
                            <div class="row">
                                <div class="col-2">
                                    <h4 class="mb-1 font-kecil">Dept Asal</h4>
                                    <span class="font-kecil">
                                        <div class="font-kecil">
                                            <select class="form-control form-sm font-kecil font-bold" id="dept_kirim" name="dept_kirim">
                                                <?php
                                                $selek = $this->session->userdata('deptsekarang') ?? 'IT';
                                                foreach ($hakdep as $hak) :
                                                    $selected = ($selek == $hak['dept_id']) ? "selected" : "";
                                                ?>
                                                    <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?= $selected ?>>
                                                        <?= $hak['departemen']; ?>
                                                    </option>
                                                <?php endforeach; ?>

                                            </select>
                                        </div>
                                    </span>
                                </div>
                                <div class="col-2 ">
                                    <h4 class="mb-1 font-kecil">Dept Tujuan</h4>
                                    <span class="font-kecil">
                                        <div class="font-kecil">
                                            <select class="form-control form-sm font-kecil font-bold" id="dept_tuju" name="dept_tuju">
                                                <option value="PC" rel="PURCHASING" selected>PURCHASING</option>
                                            </select>
                                        </div>
                                    </span>
                                </div>
                                <div class="col-3">
                                    <h4 class="mb-1 font-kecil">.</h4>
                                    <span class="font-kecil">
                                        <a href="#" class="btn btn-sm btn-primary" style="height: 38px;min-width:45px;" id="butgo">Go</a>
                                    </span>
                                </div>
                                <div class="col-3">
                                    <h4 class="mb-1"></h4>
                                </div>
                                <div class="col-2">
                                    <h4 class="mb-1"></h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div>
                    <table id="pbtabel" class="table nowrap order-column" style="width: 100% !important;">
                        <thead>
                            <tr>
                                <th>Tgl</th>
                                <th>Nomor</th>
                                <th>Jumlah Item</th>
                                <th>Dibuat Oleh</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                            <?php
                            foreach ($data as $datdet) :
                                $jmlrec = $datdet['jmlrex'] == null ? '' : $datdet['jmlrex'] . ' Item ';

                            ?>
                                <tr>
                                    <td><?= tglmysql($datdet['tgl']); ?></td>
                                    <td><a href='<?= base_url() . 'bbl/viewdetail_bbl/' . $datdet['id'] ?>' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' title='View Detail'> <?= $datdet['nomor_dok'] ?></a></td>
                                    <td><?= $jmlrec; ?></td>
                                    <td style="line-height: 14px;"><?= substr(datauser($datdet['user_ok'], 'name'), 0, 35) . "<br><span style='font-size: 10px;'>" . tglmysql2($datdet['tgl_ok']) . "</span>" ?></td>
                                    <td><?= $datdet['keterangan'] ?></td>
                                    <td>
                                        <a href="<?= base_url() . 'bbl/editdetail_bbl/' . $datdet['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white" id="Edit detail Bbl" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title="Edit detail Bbl" rel="<?= $datdet['id']; ?>" title="Edit data">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusnettype" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'bbl/hapus_detail/' . $datdet['id']; ?>" title="Hapus data">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>