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
                <h2 class="page-title p-2">
                    <?= $title ?>
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <!-- <a href="<?= base_url() . 'agama/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-simple" data-title="Add Data Agama"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a> -->
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
                                <div class="form-group" id="formtgldari">
                                    <label class="col-md-4 control-label" style="text-align: left;" for="inputDefault">Camera</label>
                                    <div class="col-md-8">
                                        <select class="form-control form-control-sm" id="camera-select"></select>
                                    </div>
                                </div>
                                <a href="<?= base_url() ?>" id="kebase" class="hilang">Te2s</a>
                                <div class="form-group hilang">
                                    <input id="image-url" type="text" class="form-control" placeholder="Image url">
                                    <button title="Decode Image" class="btn btn-default btn-sm" id="decode-img" type="button" data-toggle="tooltip">Grab</button>
                                    <button title="Image shoot" class="btn btn-info btn-sm disabled" id="grab-img" type="button" data-toggle="tooltip">Grab</button>
                                    <button title="Play" class="btn btn-success btn-sm" id="play" type="button" data-toggle="tooltip">Play</button>
                                    <button title="Pause" class="btn btn-warning btn-sm" id="pause" type="button" data-toggle="tooltip">pause</button>
                                    <button title="Stop streams" class="btn btn-danger btn-sm" id="stop" type="button" data-toggle="tooltip">Stop</button>
                                </div>
                                <div class="well" style="width: 100%;">
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
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12">
                        <hr class="small">
                        <div style="text-align: center;">
                            <a href="<?= base_url() ?>" class="btn btn-sm btn-success btn-flat"><i class="fa fa-arrow-left"></i> Kembali</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>