<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                   Tambah data Stok Taking
                </h2>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="text-align: right;">
                <a href="<?= base_url() . 'opname/dataopname'; ?>" style="height: 38px;" class="btn btn-primary btn-sm ml-1"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali </span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="row mb-1 d-flex align-items-between">
                    
                </div>
                <div class="card card-active mb-2">
                    <div class="card-body p-5 font-kecil">
                        
                    </div>
                </div>
                <table id="tabel" class="table order-column table-hover table-bordered mt-2" style="width: 100% !important; border-collapse: collapse;">
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