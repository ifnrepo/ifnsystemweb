<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <div class="page-pretitle pl-2">
                    Entry Data Periode <?= $this->session->userdata('periodeopname') ?>
                </div>
                <h2 class="page-title px-2">
                    Data Stok Taking
                </h2>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="text-align: right;">
                <a href="<?= base_url() . 'opname/entrydata'; ?>" style="height: 38px;" class="btn btn-primary btn-sm ml-1"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali </span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body p-2">
                <div class="card card-active mb-2">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-4">
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Departemen</label>
                                    <div class="col mb-1">
                                        <input type="text" name="id" id="id" value="<?= $header['id'] ?>" class="hilang">
                                        <input type="text" name="deptid" id="deptid" value="<?= $header['dept_id'] ?>" class="hilang">
                                       <input type="text" name="namadept" id="namadept" class="form-control btn-flat font-bold font-kecil" value="<?= $header['departemen'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Sub Lokasi</label>
                                    <div class="col mb-1">
                                        <input type="text" name="namadept" id="namadept" class="form-control btn-flat font-bold font-kecil" value="<?= $header['nama_lokasi'].' ( '.$header['kode_lokasi'].' )' ?>">
                                    </div>
                                </div>
                                <table class="table table-bordered m-0 table-hover">
                                    <thead class="bg-primary-lt">
                                        <!-- <tr>
                                            <th class="text-center text-black">Departemen</th>
                                        </tr> -->
                                    </thead>
                                    <tbody class="table-tbody">
                                        <tr>
                                            <?php $pcs = $header['pcs']==0 ? '0' : rupiah($header['pcs'],2); $kgs = $header['kgs']==0 ? '0' : rupiah($header['kgs'],2); ?>
                                            <td class="font-kecil"><?= $pcs ?> Pcs</td>
                                            <td class="font-kecil"><?= $kgs ?> Kgs</td>
                                        </tr>
                                        <tr>
                                            <td class="font-kecil" colspan="2"><?= rupiah($header['item'],0) ?> Item</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-5"></div>
                            <div class="col-3">
                                <span class="font-kecil text-pink <?php if($this->session->userdata('periodeopname')!=''){ echo "hilang"; } ?>">Periode Stok Opname belum dipilih !</span>
                                <input type="text" name="periode" id="periode" class="hilang" value="<?= $this->session->userdata('periodeopname') ?>">
                                <textarea name="carisublok" id="carisublok" class="form-control"></textarea>
                                <a href="#" class="btn btn-sm btn-success form-control mt-1" id="caridataentry">Cari</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr class="m-1">
                <div class="row">
                    <div class="col-4">
                        <div class="card card-active">
                            <div class="card-body p-2">
                                <h4 class="mb-2">Form Input Stok</h4>
                                <hr class="m-1">
                                <div class="d-flex justify-content-between m-2">
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" value="cariidbarang" name="radios-filter"  <?php if($this->session->userdata('sel-cari')=='barang'){ echo "checked"; } ?>>
                                        <span class="form-check-label font-kecil font-bold">ID Barang</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" value="caripo" name="radios-filter" <?php if($this->session->userdata('sel-cari')=='insnopo'){ echo "checked"; } ?>>
                                        <span class="form-check-label font-kecil font-bold">PO / Insno</span>
                                    </label>
                                    <label class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" value="carispek" name="radios-filter">
                                        <span class="form-check-label font-kecil font-bold">Spek Barang</span>
                                    </label>
                                </div>
                                <div class="input-group">
                                    <input type="text" class="form-control font-kecil btn-flat text-uppercase" id="keywordinputstok" placeholder="Search for…">
                                    <button class="btn btn-blue btn-flat font-kecil" type="button" id="cariinputstok">Cari !</button>
                                    <button href="#" class="hilang" id="caribarangdouble" data-bs-target="#modal-large" data-bs-toggle="modal" data-title="Pilih Barang">caribarang</button>
                                </div>
                                <div>
                                    <hr class="m-1">
                                    <div class="row">
                                        <label class="col-3 col-form-label font-kecil font-bold">SKU</label>
                                        <div class="col mb-1">
                                            <input type="text" class="hilang" name="idbarang" id="idbarang">
                                            <input type="text" class="hilang" name="po" id="po">
                                            <input type="text" class="hilang" name="item" id="item">
                                            <input type="text" class="hilang" name="dis" id="dis">
                                            <input type="text" class="hilang" name="dln" id="dln">
                                            <input type="text" name="sku" id="sku" class="form-control btn-flat font-bold font-kecil" value="" readonly>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-3 col-form-label font-kecil font-bold">Spek Barang</label>
                                        <div class="col mb-1">
                                            <!-- <input type="text" name="spek" id="spek" class="form-control btn-flat font-bold font-kecil" value=""> -->
                                            <textarea name="spek" id="spek" class="form-control btn-flat font-kecil"></textarea>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-3 col-form-label font-kecil font-bold">Color</label>
                                        <div class="col mb-1">
                                            <input type="text" name="color" id="color" class="form-control btn-flat font-kecil" value="" disabled>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-3 col-form-label font-kecil font-bold">Insno</label>
                                        <div class="col mb-1">
                                            <input type="text" name="insno" id="insno" class="form-control btn-flat font-kecil" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-3 col-form-label font-kecil font-bold">Nomor IB</label>
                                        <div class="col mb-1">
                                            <input type="text" name="nobontr" id="nobontr" class="form-control btn-flat font-kecil" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-3 col-form-label font-kecil font-bold">Stok/Grade</label>
                                        <div class="col mb-1">
                                            <select name="stok" id="stok" class="form-control form-select btn-flat font-kecil">
                                                <option value="0">Non Grade</option>
                                                <option value="1">Grade A</option>
                                                <option value="2">Grade B</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row <?php if($header['dept_id']!='GF'){ echo "hilang"; } ?>">
                                        <label class="col-3 col-form-label font-kecil font-bold">No Bale</label>
                                        <div class="col mb-1">
                                            <input type="text" name="nobale" id="nobale" class="form-control btn-flat font-kecil" value="">
                                        </div>
                                    </div>
                                    <div class="row <?php if($header['dept_id']!='GP'){ echo "hilang"; } ?>">
                                        <label class="col-3 col-form-label font-kecil font-bold">Eks Netting</label>
                                        <div class="col mb-1">
                                            <select name="exnet" id="exnet" class="form-control form-select btn-flat font-kecil">
                                                <option value="0">Tidak</option>
                                                <option value="1">Ya</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-3 col-form-label font-kecil font-bold">Satuan</label>
                                        <div class="col mb-1">
                                            <select name="satuan" id="satuan" class="form-control form-select btn-flat font-kecil">
                                                <option value="X">Pilih Satuan</option>
                                                <option value="KGS">KGS</option>
                                                <option value="PCS">PCS</option>
                                                <option value="SET">SET</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-3 col-form-label font-kecil font-bold">Pcs</label>
                                        <div class="col mb-1">
                                            <input type="text" name="pcs" id="pcs" class="form-control btn-flat font-bold font-kecil inputangka text-right" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-3 col-form-label font-kecil font-bold">Kgs</label>
                                        <div class="col mb-1">
                                            <input type="text" name="kgs" id="kgs" class="form-control btn-flat font-bold font-kecil inputangka text-right" value="">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <label class="col-3 col-form-label font-kecil font-bold">Keterangan</label>
                                        <div class="col mb-1">
                                            <input type="text" name="ket" id="ket" class="form-control btn-flat font-bold font-kecil" value="">
                                        </div>
                                    </div>
                                    <hr class="m-1">
                                    <div class="d-flex justify-content-between">
                                        <a href="#" class="btn btn-sm btn-ghost-danger btn-flat" id="resetinputstok">Reset</a>
                                        <a href="#" class="btn btn-sm btn-success btn-flat" id="simpaninputstok">Simpan</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-8">
                        <table class="table table-bordered m-0 table-hover">
                            <thead class="bg-primary-lt">
                                <tr>
                                    <th class="text-black">Urut</th>
                                    <th class="text-black">Spek Barang</th>
                                    <th class="text-black">Sat</th>
                                    <th class="text-black">Qty</th>
                                    <th class="text-black">Kgs</th>
                                    <th class="text-black">Ket</th>
                                    <th class="text-black">No<br>Bale</th>
                                    <th class="text-black">Aksi</th>
                                    <?php if($header['status'] > 0): ?>
                                    <th class="text-black">Cek</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                <?php if($data->num_rows() > 0): ?>
                                    <?php foreach($data->result_array() as $dt): ?>
                                    <?php 
                                        $sku = trim($dt['po'])=='' ? namaspekbarang($dt['id_barang'],'kode') : viewsku($dt['po'],$dt['item'],$dt['dis']);
                                        $spek = trim($dt['po'])=='' ? '<span class="text-cyan font-11"> SKU. '.$sku.'</span></br>'.namaspekbarang($dt['id_barang']) : '<span class="text-cyan font-11"> SKU. '.$sku.'</span></br>'.spekpo($dt['po'],$dt['item'],$dt['dis']);
                                        $nobontr = trim($dt['nobontr'])=='' ? '' : '<br><span class="text-pink font-11"> IB. '.$dt['nobontr'].'</span>';
                                        $insno = trim($dt['insno'])=='' ? '' : '<br><span class="text-pink font-11"> INSNO. '.$dt['insno'].'</span>';
                                    ?>
                                        <tr>
                                            <td class="font-kecil"><?= $dt['urut'] ?></td>
                                            <td class="font-kecil line-11"><?= $spek.$insno.$nobontr ?></td>
                                            <td class="font-kecil"><?= $dt['satuan'] ?></td>
                                            <td class="font-kecil text-right"><?= rupiah($dt['pcs'],0) ?></td>
                                            <td class="font-kecil text-right"><?= rupiah($dt['kgs'],2) ?></td>
                                            <td class="font-kecil"><?= $dt['ket'] ?></td>
                                            <td class="font-kecil"><?= $dt['nobale'] ?></td>
                                            <td class="font-kecil text-center">
                                                <a href="#" class="btn btn-sm btn-flat btn-info" style="padding: 2px 6px !important;">Edit</a>
                                                <a href="#" data-href="<?= base_url().'opname/hapusentristok/'.$dt['id'] ?>" data-bs-target="#modal-danger" data-bs-toggle="modal" data-message="Akan menghapus data ini" class="btn btn-sm btn-flat btn-danger" style="padding: 2px 6px !important;">Hapus</a>
                                            </td>
                                            <?php if($header['status'] > 0): ?>
                                                <td class="font-kecil">Cek</td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">-- Data Kosong --</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>