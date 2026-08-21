<?php
    defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Selamat datang Di Penyangkalan !
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <!-- <a href="#" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Data Supplier"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a> -->
            </div>
        </div>
    </div>
</div>
<div class="page-body mt-2">
    <div class="container-xl">
        <?php 
            $str = $this->session->userdata('hakdepartemen'); 
            $sampai = strlen($str)/2;
        ?>
        <?php $depe = ['SP']; ?>
        <div class="row">
            <?php for($x=1;$x<=$sampai;$x++): $dept = substr($str,($x*2)-2,2); if(in_array($dept,$depe)): ?>
            <div class="col-md-3 col-sm-4 mt-2">
                <!-- <a href="#" class="kolomproduksi"> -->
                    <div class="card kolomproduksi" style="border-color: #a2daf8 !important;">
                        <div class="card-body p-1">
                            <div class="">
                                <div class="text-center px-2 w-100" style="font-size: 2.5rem;">
                                    <div>
                                        <?= datadepartemen($dept,'departemen') ?>
                                    </div>
                                </div>
                                <!-- <div id="kolomkondisix" class="kolomkondisi text-right ml-auto" style="width:50px; background-color: #f97aa2;display:flex;align-items:center;justify-content: end;">
                                    <i class="fa fa-arrow-right fa-3x text-secondary"></i>
                                </div> -->
                                <hr class="m-0">
                                <div class="row pb-2">
                                    <div class="col-3 text-center">
                                        <div style="font-size: 1.25rem;" class="line-11 mb-1">
                                            <i class="fa fa-cog text-blue mt-1"></i><br>
                                            <span class="font-kecil mb-1 text-muted">Machine</span>
                                        </div>
                                        <hr class="m-0">
                                        <div class="line-11 mt-1">
                                            <span style="font-weight: 600;">100</span><br>
                                            <span class="font-10">Running</span>
                                        </div>
                                    </div>
                                    <div class="col-3 text-center">
                                        <div style="font-size: 1.25rem;" class="line-11 mb-1">
                                            <i class="fa fa-server text-azure mt-1"></i><br>
                                            <span class="font-kecil mb-1 text-muted">In</span>
                                        </div>
                                        <hr class="m-0">
                                        <div class="line-11 mt-1">
                                            <span style="font-weight: 600;">97</span><br>
                                            <span class="font-10">XX</span>
                                        </div>
                                    </div>
                                    <div class="col-3 text-center">
                                        <div style="font-size: 1.25rem;" class="line-11 mb-1">
                                            <i class="fa fa-truck fa-flip-horizontal text-yellow mt-1"></i><br>
                                            <span class="font-kecil mb-1 text-muted">Out</span>
                                        </div>
                                        <hr class="m-0">
                                        <div class="line-11 mt-1">
                                        <span style="font-weight: 600;">99</span><br>
                                        <span class="font-10">XX</span>
                                        </div>
                                    </div>
                                    <div class="col-3 text-center">
                                        <div style="font-size: 1.25rem;" class="line-11 mb-1">
                                            <i class="fa fa-bar-chart-o text-green mt-1"></i><br>
                                            <span class="font-kecil mb-1 text-muted">Efectivity</span>
                                        </div>
                                        <hr class="m-0">
                                        <div class="line-11 mt-1">
                                            <span style="font-weight: 600;">102 %</span><br>
                                            <span class="font-10">XX</span>
                                        </div>
                                    </div>
                                </div>
                                <hr class="m-0">
                                <div class="text-right p-1">
                                    <a href="#" class="btn btn-sm btn-flat btn-success">Masuk ke Modul</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <!-- </a> -->
            </div>
            <?php endif; endfor; ?>
        </div>
        <!-- <div class="card">
            <div class="card-body">
                
            </div>
        </div> -->
    </div>
</div>