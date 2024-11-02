<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Mutasi Mesin/Asset
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'dept/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Departemen"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="card card-active mb-2">
                    <div class="card-body p-1 text-right">
                        <div class="row d-flex align-items-between">
                            <div class="col-3">
                                <div class="row mb-1">
                                    <label class="col-3 col-form-label font-kecil font-bold">Periode</label>
                                    <div class="col font-kecil">
                                        <div class="row">
                                            <div class="col-7">
                                                <select name="blperiode" id="blperiode" class="form-control form-select font-kecil">
                                                    <option value="">Semua</option>
                                                    <?php for ($x = 1; $x <= 12; $x++) : ?>
                                                        <option value="<?= $x; ?>" <?php if ($this->session->userdata('bl') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </div>
                                            <div class="col-5">
                                                <select name="thperiode" id="thperiode" class="form-control form-select font-kecil">
                                                    <?php for ($x = 2020; $x <= date('Y'); $x++) {
                                                        $selek = $x == $this->session->userdata('th') ? 'selected' : ''; ?>
                                                        <option value="<?= $x; ?>" <?= $selek; ?>><?= $x; ?></option>
                                                    <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row mb-0">
                                    <label class="col-3 col-form-label font-kecil font-bold">Lokasi</label>
                                    <div class="col font-kecil">
                                        <select name="lokasimesin" id="lokasimesin" class="form-control form-select font-kecil">
                                            <option value="">SEMUA LOKASI</option>
                                            <?php foreach ($lokasi->result_array() as $loka) {
                                                $selek = $loka['lokasi'] == $this->session->userdata('lokasimesin') ? 'selected' : ''; ?>
                                                <option value="<?= $loka['lokasi']; ?>" <?= $selek; ?>><?= $loka['lokasi']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                                <!-- <div class="row text-left">
                                <div class="col">
                                <label class="form-check">
                                <input class="form-check-input" type="checkbox"  checked>
                                <span class="form-check-label">Checked checkbox input</span>
                                </label>  
                                </div>
                            </div> -->
                            </div>
                            <div class="col-3 text-start">
                                <span class="text-blue font-kecil font-bold" id="jmlsawe">Saw :</span><br>
                                <span class="text-blue font-kecil font-bold" id="jmline">In :</span><br>
                                <span class="text-blue font-kecil font-bold" id="jmloute">Out :</span><br>
                                <span class="text-blue font-kecil font-bold" id="jmladje">Adj :</span><br>
                                <span class="text-blue font-kecil font-bold" id="jmlsaldo">Saldo :</span>
                            </div>
                            <div class="col-6">
                                <a href="<?= base_url() . 'invmesin/excel?blperiode=' . $this->session->userdata('blperiode') . '&thperiode=' . $this->session->userdata('thperiode') . '&lokasimesin=' . $this->session->userdata('lokasimesin'); ?>" class="btn btn-success btn-sm">
                                    <i class="fa fa-file-excel-o"></i><span class="ml-1">Export To Excel</span>
                                </a>
                                <a href="<?= base_url() . 'invmesin/pdf?blperiode=' . $this->session->userdata('blperiode') . '&thperiode=' . $this->session->userdata('thperiode') . '&lokasimesin=' . $this->session->userdata('lokasimesin'); ?>" target="_blank" class="btn btn-danger btn-sm">
                                    <i class="fa fa-file-pdf-o"></i><span class="ml-1">Export To PDF</span>
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body">
                        <table class="table datatable9 table-hover" id="cobasisip">
                            <thead class="table-bordered">
                                <tr class="text-center">
                                    <th class="text-center" rowspan="2">No</th>
                                    <th class="text-center" rowspan="2">Kode Brg</th>
                                    <th class="text-center" rowspan="2">Nama Barang</th>
                                    <th class="text-center" rowspan="2">Unit</th>
                                    <th colspan="4" class="text-center">Transaksi</th>
                                    <th class="text-center" rowspan="2">Sak</th>
                                    <th class="text-center" rowspan="2">Opname</th>
                                    <th class="text-center" rowspan="2">Remark</th>
                                </tr>
                                <tr class="text-center table-bordered">
                                    <th class="text-center">Saw</th>
                                    <th class="text-center">In</th>
                                    <th class="text-center">Out</th>
                                    <th class="text-center">ADJ</th>
                                </tr>
                                <!-- <tr>
                            <th>No</th>
                            <th>Kode Brg</th>
                            <th>Nama Barang</th>
                            <th>Unit</th>
                            <th>Saw</th>
                            <th>In</th>
                            <th>Out</th>
                            <th>Adj</th>
                            <th>Sak</th>
                            <th>Opname</th>
                            <th>Remark</th>
                        </tr> -->
                            </thead>
                            <tbody class="table-tbody" style="font-size: 13px !important;">
                                <?php $no = 1;
                                $saw = 0;
                                $in = 0;
                                $out = 0;
                                $adj = 0;
                                foreach ($data as $msn) { ?>
                                    <?php
                                    if ($msn['ok_stok'] == 1) {
                                    }
                                    $saw += $msn['sawi'];
                                    $in += $msn['ini'];
                                    $out += $msn['outi'];
                                    $adj += $msn['adji'];
                                    ?>
                                    <tr>
                                        <td><?= $no++; ?></td>
                                        <td><?= $msn['kode_fix'] ?></td>
                                        <td><a href="<?= base_url() . 'invmesin/getdetail/' . $msn['id']; ?>" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' style="color: #182433;"><?= $msn['nama_barang'] ?></a></td>
                                        <td><?= $msn['kodesatuan'] ?></td>
                                        <td><?= rupiah($msn['sawi'], 0) ?></td>
                                        <td><?= rupiah($msn['ini'], 0) ?></td>
                                        <td><?= rupiah($msn['outi'], 0) ?></td>
                                        <td><?= rupiah($msn['adji'], 0) ?></td>
                                        <td><?= rupiah($msn['sawi'] + $msn['ini'] - $msn['outi'], 0); ?></td>
                                        <td><?= rupiah(0, 0); ?></td>
                                        <td><?= 'Sesuai' ?></td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card card-active hilang">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-2 text-center">SAW : <span class="font-bold" id="jmlsaw"><?= $saw; ?></span></div>
                            <div class="col-2">IN : <span class="font-bold" id="jmlin"><?= $in ?></span></div>
                            <div class="col-2">OUT : <span class="font-bold" id="jmlout"><?= $out; ?></span></div>
                            <div class="col-2">ADJ : <span class="font-bold" id="jmladj"><?= $adj; ?></span></div>
                            <div class="col-4">SALDO : <span class="font-bold"><?= rupiah($saw + $in - $out - $adj, 0); ?></span></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>