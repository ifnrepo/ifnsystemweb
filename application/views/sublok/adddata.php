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

<div class="page-header d-print-none">
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

            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">

        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-sm-12">
                        <!-- <div class="infohalaman">Dalam Pembuatan</div> -->
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group mb-1">
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
                                    <button title="Play" class="btn btn-success btn-sm" id="play" type="button" data-toggle="tooltip">Activate Scanner</button>
                                    <button title="Pause" class="btn btn-warning btn-sm hilang" id="pause" type="button" data-toggle="tooltip">pause</button>
                                    <button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip">Stop Scanner</button>
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
                                        <input type="text" id="contoh" name="contoh">
                                        <div>
                                            <table id="pbtabel" class="table nowrap order-column table-hover table-bordered" style="width: 100% !important;">
                                                <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>SKU</th>
                                                    <th>Lot no</th>
                                                    <th>Qty</th>
                                                    <!-- <th>Kgs</th> -->
                                                </tr>
                                                </thead>
                                                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                                    <tr>
                                                        <td>1</td>
                                                        <td class="line-12">FU-0174#2<br><span class="font-kecil text-cyan">FU 1041</span></td>  
                                                        <td>01-01</td>
                                                        <td>1</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr class="small">
                        <div style="text-align: center;">
                            <a href="<?= base_url().'sublok/inputdata/'.$header['id'] ?>" class="btn btn-sm btn-success btn-flat"><i class="fa fa-arrow-left mr-1"></i> Kembali</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>