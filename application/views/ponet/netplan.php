<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="page-header d-print-none m-2">
    <div class="container-xl d-flex justify-content-between">
        <h2 class="page-title p-2">
            NET PLANNING
        </h2>
        <div class="col-md-6" style="text-align: right;">
            <a href="<?= base_url().'ponet/view/'.$this->uri->segment(3) ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-3">
                        <div class="card btn-flat" style="min-height: 450px;">
                            <div class="card-body p-2">
                                <h3 class="mb-1">Machine Info</h3>
                                <hr class="m-0">
                                <div class="row">
                                    <input type="text" class="hilang" id="nomormesin" name="nomormesin" value="<?= $this->uri->segment(4) ?>">
                                    <input type="text" class="hilang" id="kodeponet" name="kodeponet" value="<?= $this->uri->segment(3) ?>">
                                    <input type="text" class="hilang" id="minid" name="minid" value="<?= $maxrek['minid'] ?>">
                                    <input type="text" class="hilang" id="maxid" name="maxid" value="<?= $maxrek['maxid'] ?>">
                                    <?php $lokasi = isset($data['lokasi']) ? substr($data['lokasi'],0,3) : '';  ?>
                                    <div class="col-3 text-center"><div class="bg-red-lt mb-1 mt-1"><?= $lokasi ?></div><h1 class="mb-1"><?= $this->uri->segment(4) ?></h1></div>
                                    <div class="col-9">
                                        <table class="table table-bordered m-0 mt-1 mb-1">
                                            <thead class="bg-primary-lt">
                                                <!-- <tr>
                                                    <th class="text-center text-black" colspan="2"></th>
                                                </tr> -->
                                            </thead>
                                            <tbody class="table-tbody">
                                                <tr>
                                                    <td class="font-kecil">Spek</td>
                                                    <?php $machname = isset($data['mach_name']) ? $data['mach_name'] : '';  ?>
                                                    <td class="font-kecil"><?= $machname ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="font-kecil">Kode </td>
                                                    <?php $kodefix = isset($data['kode_fix']) ? $data['kode_fix'] : '';  ?>
                                                    <td class="font-kecil"><?= $kodefix ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="font-kecil">Model </td>
                                                    <?php $model = isset($data['model']) ? $data['model'] : '';  ?>
                                                    <td class="font-kecil"><?= $model ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="font-kecil">Seri </td>
                                                    <?php $serial = isset($data['serial']) ? $data['serial'] : '';  ?>
                                                    <td class="font-kecil"><?= $serial ?></td>
                                                </tr>
                                                <tr>
                                                    <td class="font-kecil">Tgl IN </td>
                                                    <?php $tgmasuk = isset($data['tglmasuk']) ? tgl_indo($data['tglmasuk']) : '';  ?>
                                                    <td class="font-kecil"><?= $tgmasuk ?></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <hr class="m-1">
                                <div class="row">
                                    <div class="col-12">
                                        <?php 
                                            $filefoto = isset($data['filefoto']) ? $data['filefoto'] : '';  
                                            $foto = FCPATH.'assets/image/dokmesin/foto/'.trim($filefoto); 
                                            $inifoto = base_url().'assets/image/dokmesin/foto/005f.jpg';
                                            if(trim($filefoto) !=''){
                                                if(file_exists($foto)){
                                                    $inifoto = base_url().'assets/image/dokmesin/foto/'.trim($filefoto);
                                                }
                                            }
                                                
                                        ?>
                                        <img src="<?= $inifoto ?>" alt="TES">
                                    </div>
                                </div>
                                <div class="text-center mt-1">
                                    <div class="text-center pt-2" style="border-top: 0.5px solid #eaeaea;">
                                        <button class="btn btn-sm btn-primary" id="firstrec">First</button>
                                        <button class="btn btn-sm btn-primary" id="prevrec">Prev</button>
                                        <button class="btn btn-sm btn-primary" id="nextrec">Next</button>
                                        <button class="btn btn-sm btn-primary" id="lastrec">Last</button>
                                        <a href="<?= base_url().'ponet/caripo' ?>" class="btn btn-sm btn-teal text-white disabled" id="caridatapo" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="Cari Data PO">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                            Cari Data
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-9">
                        <h3 class="mb-1">List Instruksi</h3>
                        <hr class="m-0">
                        <div class="overflow-auto">
                            <table id="tabelnya" class="table order-column table-hover table-bordered mt-2" style="width: 100% !important; border-collapse: collapse;">
                                <thead>
                                    <tr class="text-left">
                                        <th class="text-center">Urut</th>
                                        <th class="text-center">Tgl Plan</th>
                                        <th class="">SKU</th>
                                        <th class="text-center">Instruksi</th>
                                        <!-- <th class="text-left">Spesifikasi</th> -->
                                        <th class="">Tgl Net</th>
                                        <th class="">Knot</th>
                                        <th class="">Prd</th>
                                        <th class="">Pcs</th>
                                        <th class="">Stat Net</th>
                                        <th class="">Stat PPIC</th>
                                        <th class="">Remark</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                    <tr>
                                        <td colspan="12" class="text-center">Fetching Data</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>