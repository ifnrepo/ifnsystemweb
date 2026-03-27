<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- <style>
    .laser-area {
        height: 320px;
        width: 100%;
        border: solid gray 1px;
        /* padding:10px 10px;  */
        position: relative;
        overflow: hidden;
    }
</style> -->

<div class="page-header d-print-none m-2">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-0">
                    <?= $title ?>
                </h2>
                <div class="page-pretitle">
                  <?= $header['nomor'] ?>
                </div>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'sublok/inputdata/'.$header['id'] ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- <div class="infohalaman">Dalam Pembuatan</div> -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mb-1" id="pilihkamera">
                                    <label class="col-md-4 control-label" style="text-align: left;" for="inputDefault">Camera</label>
                                    <div class="col-md-8">
                                        <select class="form-control form-control-sm" id="camera-select"></select>
                                    </div>
                                </div>
                                <hr class="m-1">
                                <a href="<?= base_url() ?>" id="kebase" class="hilang">Te2s</a>
                                <div class="form-group text-center mb-1">
                                    <input id="image-url" type="text" class="form-control hilang" placeholder="Image url">
                                    <button title="Decode Image" class="btn btn-default btn-sm hilang" id="decode-img" type="button" data-toggle="tooltip">Grab</button>
                                    <button title="Image shoot" class="btn btn-info btn-sm disabled hilang" id="grab-img" type="button" data-toggle="tooltip">Grab</button>
                                    <button title="Play" class="btn btn-success btn-sm" id="play" type="button" data-toggle="tooltip">Activate Camera</button>
                                    <button title="Pause" class="btn btn-warning btn-sm hilang" id="pause" type="button" data-toggle="tooltip">pause</button>
                                    <button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip">Stop Camera</button>
                                    <button title="Manual Input" class="btn btn-info btn-sm" id="manual" type="button">Manual Mode</button>
                                    <button title="Scanner Input" class="btn btn-warning btn-sm" id="scanner" type="button">Scan Mode</button>
                                </div>
                                <hr class="m-1">
                                <div class="well hilang" style="width: 100%;">
                                    <label id="zoom-value" width="100">Zoom: 1</label>
                                    <input id="zoom" onchange="Page.changeZoom();" type="range" min="10" max="30" value="0">
                                    <label id="brightness-value" width="100">Brightness: 0</label>
                                    <input id="brightness" onchange="Page.changeBrightness();" type="range" min="0" max="128" value="0">
                                    <label id="contrast-value" width="100">Contrast: 0</label>
                                    <input id="contrast" onchange="Page.changeContrast();" type="range" min="0" max="64" value="0">
                                    <label id="threshold-value" width="100">Threshold: 0</label>
                                    <input id="threshold" onchange="Page.changeThreshold();" type="range" min="0" max="512" value="0">
                                    <label id="sharpness-value" width="100">Sharpness: off</label>
                                    <input id="sharpness" onchange="Page.changeSharpness();" type="checkbox">
                                    <label id="grayscale-value" width="100">grayscale: off</label>
                                    <input id="grayscale" onchange="Page.changeGrayscale();" type="checkbox">
                                    <br>
                                    <label id="flipVertical-value" width="100">Flip Vertical: off</label>
                                    <input id="flipVertical" onchange="Page.changeVertical();" type="checkbox">
                                    <label id="flipHorizontal-value" width="100">Flip Horizontal: off</label>
                                    <input id="flipHorizontal" onchange="Page.changeHorizontal();" type="checkbox">
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="laser-area">
                                    <!-- <div class="laser-area" style="display: inline-block; background-color :red; padding:0;"> -->
                                    <canvas id="webcodecam-canvas" style="position:absolute; height:100%; width:100%;"></canvas>
                                    <div class="scanner-laser laser-rightBottom" style="opacity: 0.5;"></div>
                                    <div class="scanner-laser laser-rightTop" style="opacity: 0.5;"></div>
                                    <div class="scanner-laser laser-leftBottom" style="opacity: 0.5;"></div>
                                    <div class="scanner-laser laser-leftTop" style="opacity: 0.5;"></div>
                                    <!-- </div> -->
                                </div>
                                <div class="input-manual mt-2 hilang">
                                    <h4>Input Form</h4>
                                    <hr class="m-1">
                                    <div class="mb-1 mt-3 row">
                                        <label class="col-3 col-form-label">Insno</label>
                                        <div class="col">
                                            <input type="text" id="inputinsno" class="form-control form-sm btn-square" aria-describedby="emailHelp" placeholder="Nomor Instruksi">
                                        </div>
                                    </div>
                                    <div class="mb-1 row">
                                        <label class="col-3 col-form-label">Lot</label>
                                        <div class="col">
                                            <input type="text" id="inputlot" class="form-control form-sm btn-square" aria-describedby="emailHelp" placeholder="Nomor Lot">
                                        </div>
                                    </div>
                                    <div class="mb-3 row">
                                        <label class="col-3 col-form-label">Jalur</label>
                                        <div class="col">
                                            <input type="text" id="inputjalur" class="form-control form-sm btn-square" aria-describedby="emailHelp" placeholder="Nomor Jalur">
                                        </div>
                                    </div>
                                    <hr class="m-1">
                                    <div class="btn-list justify-content-between">
                                        <a href="#" class="btn btn-link link-secondary" id="bersihkan-input-manual">
                                            Reset
                                        </a>
                                        <a href="#" class="btn btn-square btn-primary" id="simpan-input-manual">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M10 14a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                                            <span class="font-kecil">Simpan Data</span>
                                        </a>
                                    </div>
                                </div>
                                <div class="input-scanner mt-2 hilang">
                                    <h4>Scanner Form</h4>
                                    <hr class="m-1">
                                    <div class="mb-2 mt-2 row">
                                        <label class="col-3 col-form-label">Code</label>
                                        <div class="col">
                                            <input type="text" id="inputscanner" class="form-control form-sm btn-square" aria-describedby="emailHelp" placeholder="Nomor Instruksi">
                                        </div>
                                    </div>
                                    <hr class="m-1">
                                    <div class="btn-list justify-content-between">
                                        <a href="#" class="btn btn-link link-secondary" id="bersihkan-input-scanner">
                                            Reset
                                        </a>
                                        <a href="#" class="btn btn-square btn-primary" id="simpan-input-scanner">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M10 14a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                                            <span class="font-kecil">Simpan Data</span>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="thumbnail" id="result" style="text-align: center;">
                                    <div class="well hilang" style="overflow: hidden;">
                                        <img width="320" height="240" id="scanned-img" src="">
                                    </div>
                                    <div class="caption">
                                        <h4>Scanned result</h4>
                                        <p id="scanned-QR"></p>
                                    </div>
                                    <hr class="m-0">
                                    <div class="mt-2">
                                        <div class="text-left font-kecil">Data Collection</div>
                                        <input type="text" id="contoh" name="contoh" class="hilang">
                                        <input type="text" id="idreal" name="idreal" class="hilang" value="<?= $header['id'] ?>">
                                        <input type="text" id="insnonya" name="insnonya" class="hilang">
                                        <input type="text" id="lotnya" name="lotnya" class="hilang">
                                        <input type="text" id="jalurnya" name="jalurnya" class="hilang">
                                        <a href="<?= base_url().'sublok/pilih' ?>" class="btn btn-sm btn-warning hilang" id="pilihpoadadua" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Pilih PO yang dimaksud">Pilih</a>
                                        <div>
                                            <table id="pbtabel" class="table nowrap order-column table-hover table-bordered mb-1" style="width: 100% !important;">
                                                <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>SKU</th>
                                                    <th>Lot no</th>
                                                    <th>Qty</th>
                                                    <th>Act</th>
                                                </tr>
                                                </thead>
                                                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                                    <tr>
                                                        <td>Nomor</td>
                                                        <td class="line-12">PO#item<br><span class="font-kecil text-cyan">Instruksi Nomor</span></td>  
                                                        <td>lot-jalur</td>
                                                        <td>Qty</td>
                                                        <td>
                                                            <a href="#" class="btn btn-sm">Hapus</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <hr class="m-1">
                                            <div class="btn-list justify-content-between mt-1">
                                                <a href="#" class="btn btn-link link-secondary" id="bersihkan-input" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Yakin akan menghapus semua data yang sudah di input">
                                                    Reset
                                                </a>
                                                <a href="#" data-href="<?= base_url().'sublok/simpantempkeasli/'.$header['id'] ?>" class="btn btn-square btn-primary" id="simpan-input" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Yakin akan menyimpan data">
                                                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M10 14a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                                                    <span class="font-kecil">Simpan Transaksi</span>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>