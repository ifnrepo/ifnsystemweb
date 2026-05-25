<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
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
<div class="page-body mt-0">
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
                        <a href="<?= base_url() . 'opname/toexcel'; ?>" class="btn btn-success btn-sm font-bold mr-1 <?php if ($this->session->userdata('currdeptopname') == '') {
                                                                                                                                echo "disabled";
                                                                                                                            } ?>" id="toexcel">
                                                                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-type-xls"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M5 12v-7a2 2 0 0 1 2 -2h7l5 5v4" /><path d="M4 15l4 6" /><path d="M4 21l4 -6" /><path d="M17 20.25c0 .414 .336 .75 .75 .75h1.25a1 1 0 0 0 1 -1v-1a1 1 0 0 0 -1 -1h-1a1 1 0 0 1 -1 -1v-1a1 1 0 0 1 1 -1h1.25a.75 .75 0 0 1 .75 .75" /><path d="M11 15v6h3" /></svg><span class="ml-1">Excel</span></a>
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
                                            <option value="1" <?php if ($this->session->userdata('exdo') == '1') {
                                                                        echo "selected";
                                                                    } ?>>Export</option>
                                            <option value="0" <?php if ($this->session->userdata('exdo') == '0') {
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
                                <div class="text-blue font-bold">Jumlah Bale : <span id="jumlahpcs" style="font-weight: normal;">0</span></div>
                                <div class="text-blue font-bold">Jumlah Kgs : <span id="jumlahkgs" style="font-weight: normal;">0</span></div>
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
                                        <textarea class="form form-control p-2 m-0 font-kecil" id='textcarirekapopname' style="text-transform: uppercase;" placeholder="Cari PO, Insno, Kode Barang.."><?= $this->session->userdata('cari-rekapopname') ?></textarea>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <button type="button" id="buttoncarirekapopname" class="btn btn-sm btn-success btn-flat w-100 mt-1">Cari</button>
                                        <button type="button" id="buttonresetrekapopname" class="btn btn-sm btn-danger btn-flat w-25 mt-1">Reset</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mb-1" id="div-page">
                    <div class="col-md-3 col-12">
                        <div class="row">
                        <label class="col-3 col-form-label font-kecil">Per Page</label>
                        <div class="col mb-1">
                            <select name="rekapopname-perpage" id="rekapopname-perpage" style="height: 32px;" class="form-control form-select form-sm font-kecil py-1 w-50">
                                <option value="10" <?php if($this->session->userdata('perpage-rekapopname')==10){ echo "selected"; } ?>>10</option>
                                <option value="25" <?php if($this->session->userdata('perpage-rekapopname')==25){ echo "selected"; } ?>>25</option>
                                <option value="50" <?php if($this->session->userdata('perpage-rekapopname')==50){ echo "selected"; } ?>>50</option>
                                <option value="100" <?php if($this->session->userdata('perpage-rekapopname')==100){ echo "selected"; } ?>>100</option>
                            </select>
                        </div>
                        </div>
                    </div>
                </div>
                <table id="tabelnyau" class="table order-column table-hover table-bordered mt-1" style="width: 100% !important; border-collapse: collapse;">
                    <thead>
                        <tr class="text-left">
                            <th class="text-center">No</th>
                            <th class="text-center">Dept</th>
                            <th class="text-left line-11"><span class="text-blue">Sku</span><br>Spesifikasi</th>
                            <th class="text-center">Grd</th>
                            <th>Sat</th>
                            <th class="line-11">Nobontr<br><span class="text-pink">Insno</span></th>
                            <th>Sublok</th>
                            <th>Nobale</th>
                            <th>Exnet</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Kgs</th>
                            <th>Ket</th>
                        </tr>
                    </thead>
                    <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                        <?php $jmlpcs=0; $jmlkgs=0; $no= (int) $this->uri->segment(3) + 1; foreach($data->result_array() as $dt): ?>
                        <?php 
                            $spek = trim($dt['po'])=='' ? $dt['nama_barang'] : $dt['spek'];
                            $sku = trim($dt['po'])=='' ? $dt['kode'] : $dt['skupo'];
                            $grade = $dt['stok']==1 ? 'Grd A' : ($dt['stok']==2 ? 'Grd B' : '');
                            $exnet = $dt['exnet']==1 ? 'Y' : '';
                            $jmlpcs = $dt['totalpcs'];
                            $jmlkgs = $dt['totalkgs'];
                        ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td class="font-kecil"><?= $dt['dept_id'] ?></td> 
                                <td class="font-kecil line-11"><span class="text-blue"><?= $sku ?></span><br><a title="View Detail"><?= $spek ?></a></td>
                                <td class="font-kecil"><?= $grade ?></td> 
                                <td class="font-kecil"><?= $dt['kodesatuan'] ?></td> 
                                <td class="font-kecil line-11"><?= $dt['nobontr'] ?><br><span class="text-pink"><?= $dt['insno'] ?></span></td>
                                <td class="font-kecil"><?= $dt['kode_lokasi'].'-'.$dt['nama_lokasi'] ?></td> 
                                <td class="font-kecil"><?= $dt['nobale'] ?></td> 
                                <td class="font-kecil text-center"><?= $exnet ?></td> 
                                <td class="font-kecil text-right"><?= rupiah($dt['pcs'],0) ?></td> 
                                <td class="font-kecil text-right"><?= rupiah($dt['kgs'],2) ?></td> 
                                <td class="font-kecil text-right">
                                    <a href="<?= base_url().'opname/editrekapopname/'.$dt['id'] ?>" class="btn btn-sm btn-success" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Edit Data Stok Opname" style="padding:0 3px !important">Edit</a>
                                    <a href="#" data-href="<?= base_url().'opname/hapusrekapopname/'.$dt['id'] ?>" class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data '+spec+' ('+sku.trim()+')" style="padding:0 3px !important">Hapus</a>
                                </td> 
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="d-flex justify-content-between mt-1">
                    <div class="mt-1">
                        Jumlah Record <?= rupiah($jumlahrek,0) ?>
                        <input type="text" class="hilang" id="jmlpcs" name="jmlpcs" value="<?= rupiah($jmlpcs,0) ?>">
                        <input type="text" class="hilang" id="jmlkgs" name="jmlkgs" value="<?= rupiah($jmlkgs,2) ?>">
                    </div>
                    <div>
                        <?= $links; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>