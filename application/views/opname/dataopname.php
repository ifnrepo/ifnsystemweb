<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6 line-12">
                <h2 class="page-title p-2">
                    Rekap Data Stok Opname
                </h2>
                <small class="pl-2">Periode <?= tglmysql($this->session->userdata('periodeopname')) ?></small>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="text-align: right;">
                <a href="<?= base_url() . 'opname'; ?>" style="height: 38px;" class="btn btn-primary btn-sm ml-1"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali </span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="row mb-1 d-flex align-items-between">
                    <div class="col-sm-6 d-flex">
                        <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white hilang" id="pcskgsbcwip" name="pcskgsbcwip" title="Jumlah yang ditambpilkan" style="width: 15% !important">
                            <option value="kgs" <?php if ($this->session->userdata('pcskgsbcwip') == 'kgs') {
                                                    echo "selected";
                                                } ?>>KGS</option>
                            <option value="pcs" <?php if ($this->session->userdata('pcskgsbcwip') == 'pcs') {
                                                    echo "selected";
                                                } ?>>PCS</option>
                        </select>
                        <?php var_dump($this->session->userdata('hakstokopname')); ?>
                        <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white" title="Departemen" id="currdeptopname" name="currdeptopname">
                            <?php
                            $dep = $this->session->userdata('hakstokopname');
                            $akses_so = str_split($dep, 2);
                            ?>

                            <option value="">Semua</option>

                            <?php foreach ($datadept->result_array() as $dep) : ?>
                                <?php if (in_array($dep['dept_id'], $akses_so)) : ?>
                                    <option value="<?= $dep['dept_id'] ?>" <?= ($this->session->userdata('currdeptopname') == $dep['dept_id']) ? 'selected' : ''; ?>>
                                        <?= $dep['departemen'] ?>
                                    </option>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </select>




                        <a href="#" class="btn btn-success btn-sm font-bold <?php if ($this->session->userdata('periodeopname') == '') {
                                                                                echo "disabled";
                                                                            } ?>" id="updateopname"><i class="fa fa-refresh"></i><span class="ml-1">UPDATE</span></a>
                    </div>
                    <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
                        <a href="<?= base_url() . 'opname/tambahopname'; ?>" class="btn btn-primary btn-sm font-bold mr-1 <?php if ($this->session->userdata('currdeptopname') == '') {
                                                                                                                                echo "disabled";
                                                                                                                            } ?>" id="toexcel"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
                    </div>
                </div>
                <div class="card card-active mb-2">
                    <div class="card-body p-2 font-kecil">
                        <div class="row">
                            <div class="col-3 ">
                                <div class="row" id="div-exdo">
                                    <label class="col-3 col-form-label font-kecil font-bold">IFN/DLN</label>
                                    <div class="col mb-1">
                                        <select name="kepemilikan" id="kepemilikan" style="height: 32px;" class="form-control form-select form-sm font-kecil py-1">
                                            <option value="all">All</option>
                                            <option value="0" <?php if ($this->session->userdata('kepemilikanopname') == '0') {
                                                                    echo "selected";
                                                                } ?>>IFN</option>
                                            <option value="1" <?php if ($this->session->userdata('kepemilikanopname') == '1') {
                                                                    echo "selected";
                                                                } ?>>DLN</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="row" id="div-exdo">
                                    <label class="col-3 col-form-label font-kecil font-bold">Exdo</label>
                                    <div class="col mb-1">
                                        <select name="exdo" id="exdo" style="height: 32px;" class="form-control form-select form-sm font-kecil py-1">
                                            <option value="all">All</option>
                                            <option value="EXPORT" <?php if ($this->session->userdata('exdobcgf') == 'EXPORT') {
                                                                        echo "selected";
                                                                    } ?>>Export</option>
                                            <option value="DOMESTIC" <?php if ($this->session->userdata('exdobcgf') == 'DOMESTIC') {
                                                                            echo "selected";
                                                                        } ?>>Domestic</option>
                                        </select>
                                    </div>
                                </div>
                                <!-- <label class="form-check mt-1 mb-1 bg-danger-lt" id="cekaneh">
                                    <input class="form-check-input" type="checkbox" id="dataneh">
                                    <span class="form-check-label font-bold">View Data Tidak Sesuai</span>
                                </label> -->
                            </div>
                            <div class="col-6">
                                <!-- <div class="text-blue font-bold mt-2 ">Jumlah Dok : <span id="jumlahrekod" style="font-weight: normal;">Loading ..</span></div> -->
                                <div class="text-blue font-bold">Jumlah Bale : <span id="jumlahpcs" style="font-weight: normal;">Loading ..</span></div>
                                <div class="text-blue font-bold">Jumlah Kgs : <span id="jumlahkgs" style="font-weight: normal;">Loading ..</span></div>
                                <div class="font-kecil">
                                    <?php if ($this->session->userdata('periodeopname') == '') { ?>
                                        <span class="text-pink">Pilih periode Stok Taking dahulu (Halaman dashboard)</span>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="mb-0">
                                    <label class="font-bold">
                                        Cari Barang / SKU :
                                    </label>
                                </div>
                                <div class="">
                                    <div class="">
                                        <textarea class="form form-control p-2 m-0 font-kecil" id='textcari' style="text-transform: uppercase;"></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" id="buttoncari" class="btn btn-sm btn-success btn-flat w-100 mt-1">Cari</button>
                                        <button type="button" id="buttonreset" class="btn btn-sm btn-danger btn-flat w-25 mt-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <table id="tabelnya" class="table order-column table-hover table-bordered mt-2" style="width: 100% !important; border-collapse: collapse;">
                    <thead>
                        <tr class="text-left">
                            <th class="text-center">No</th>
                            <th class="text-center">Dept</th>
                            <th class="text-left">Sku / Spesifikasi</th>
                            <th class="text-center">Grd</th>
                            <th>Sat</th>
                            <th>Insno</th>
                            <th>Nobontr</th>
                            <th>Nobale</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Kgs</th>
                            <th>Ket</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>