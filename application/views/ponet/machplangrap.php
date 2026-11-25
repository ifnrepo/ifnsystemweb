<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<div class="page-header d-print-none m-2">
    <div class="container-xl d-flex justify-content-between">
        <h2 class="page-title p-2">
            MACH PLANNING
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
                    <div class="col-12 mb-1">
                        <div class="row mb-1">
                            <div class="col-4 mb-1"></div>
                            <div class="col-6 mb-1"></div>
                            <div class="col-2 font-kecil mb-1">
                                <div class="ms-auto">
                                    <div class="mb-1 font-kecil">
                                        <!-- <label class="form-label">Input group</label> -->
                                        <div class="input-group my-1 font-kecil">
                                            <input type="text" class="form-control font-kecil font-bold" id="texttahungrap" placeholder="Tahun" value="<?= $this->session->userdata('thgrap') ?>">
                                            <button class="btn btn-success font-kecil" id="btnapplygrap" type="button">Apply !</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="m-0">
                    </div>
                    <div class="col-12 mt-2 oveflow-auto">
                        <!-- <h3 class="mb-1">List Instruksi</h3>
                        <hr class="m-0"> -->
                        <div class="overflow-auto">
                            <table id="tabelnya" class="table order-column table-hover table-bordered mt-2">
                                <thead class="sticky-top">
                                    <tr class="sticky-top text-left">
                                        <th class="text-center text-nowrap">Mach No</th>
                                        <th class="text-center text-nowrap">SKU</th>
                                        <th class="text-center text-nowrap">Ins</th>
                                        <th class="text-center text-nowrap">Stat PP</th>
                                        <th class="text-center text-nowrap">Stat NT</th>
                                        <th class="text-center text-nowrap">#</th>
                                        <th class="text-center" colspan="4" id="tbheadjan"><?= $this->session->userdata('thgrap') ?>-01</th>
                                        <th class="text-center" colspan="4" id="tbheadfeb"><?= $this->session->userdata('thgrap') ?>-02</th>
                                        <th class="text-center" colspan="4" id="tbheadmar"><?= $this->session->userdata('thgrap') ?>-03</th>
                                        <th class="text-center" colspan="4" id="tbheadjapr"><?= $this->session->userdata('thgrap') ?>-04</th>
                                        <th class="text-center" colspan="4" id="tbheadmei"><?= $this->session->userdata('thgrap') ?>-05</th>
                                        <th class="text-center" colspan="4" id="tbheadjun"><?= $this->session->userdata('thgrap') ?>-06</th>
                                        <th class="text-center" colspan="4" id="tbheadjul"><?= $this->session->userdata('thgrap') ?>-07</th>
                                        <th class="text-center" colspan="4" id="tbheadagt"><?= $this->session->userdata('thgrap') ?>-08</th>
                                        <th class="text-center" colspan="4" id="tbheadsep"><?= $this->session->userdata('thgrap') ?>-09</th>
                                        <th class="text-center" colspan="4" id="tbheadokt"><?= $this->session->userdata('thgrap') ?>-10</th>
                                        <th class="text-center" colspan="4" id="tbheadnop"><?= $this->session->userdata('thgrap') ?>-11</th>
                                        <th class="text-center" colspan="4" id="tbheaddes"><?= $this->session->userdata('thgrap') ?>-12</th>
                                    </tr>
                                </thead>
                                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                                    <?php if($datamesin->num_rows() > 0): ?>
                                       
                                    <?php else: ?>
                                        <tr>
                                            <td colspan="54" class="text-center">Fetching Data</td>
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
</div>