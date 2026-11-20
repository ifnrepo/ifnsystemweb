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
                    <div class="col-12">
                        <div class="card btn-flat">
                            <div class="card-body p-2">
                                <h3 class="mb-1">Machine Info</h3>
                                <hr class="m-0">
                                <div class="row">
                                    <input type="text" class="hilang" id="nomormesin" name="nomormesin" value="<?= $this->uri->segment(4) ?>">
                                    <input type="text" class="hilang" id="kodeponet" name="kodeponet" value="<?= $this->uri->segment(3) ?>">
                                    <input type="text" class="hilang" id="minid" name="minid" value="<?= $maxrek['minid'] ?>">
                                    <input type="text" class="hilang" id="maxid" name="maxid" value="<?= $maxrek['maxid'] ?>">
                                    <?php $lokasi = isset($data['lokasi']) ? substr($data['lokasi'],0,3) : '';  ?>
                                    <div class="col-1 text-center">
                                        <div class="bg-red-lt mb-1 mt-1"><?= $lokasi ?></div>
                                        <input type="text" id="captnomormesingrap" class="form-control text-center font-bold" style="font-size: 17px;" value="<?= $this->uri->segment(4) ?>">
                                    </div>
                                    <div class="col-4">
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
                                    <div class="col-3 text-center">
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
                                        <img src="<?= $inifoto ?>" alt="TES" style="width:181px;object-fit: cover;" class="mt-2">
                                    </div>
                                    <div class="col-4 d-flex ms-auto flex-column" style="margin-top: auto;">
                                        <div class="text-center pt-2">
                                            <button class="btn btn-sm btn-primary" id="firstrecgrap">First</button>
                                            <button class="btn btn-sm btn-primary" id="prevrecgrap">Prev</button>
                                            <button class="btn btn-sm btn-primary" id="nextrecgrap">Next</button>
                                            <button class="btn btn-sm btn-primary" id="lastrecgrap">Last</button>
                                            <a href="<?= base_url().'ponet/caripo' ?>" class="btn btn-sm btn-teal text-white disabled" id="caridatapo" data-bs-toggle="modal" data-bs-target="#modal-large-loading" data-title="Cari Data PO">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-search"><path stroke="none" d="M0 0h24v24H0z" fill="none" /><path d="M3 10a7 7 0 1 0 14 0a7 7 0 1 0 -14 0" /><path d="M21 21l-6 -6" /></svg>
                                                Cari Data
                                            </a>
                                        </div>
                                        <div class="bg-red mt-1">
                                            <a href="<?= base_url().'ponet/netplan/'.$plan ?>" class="btn btn-sm btn-yellow w-100 text-black"><i class="fa fa-list-alt mr-2" aria-hidden="true"></i>List Plan</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
                                        <th class="text-center text-nowrap">Plan</th>
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
                                    <?php if($master->num_rows() > 0): ?>
                                        <?php $nox=1; foreach($master->result_array() as $mst): $nox++; ?>
                                        <?php $statpo = $mst['stat_po']!=1 ? 'text-pink' : ''; ?>
                                        <?php $statdesc = trim($mst['descx'])=='' ? '' : (trim($mst['descx'])=='FINISHED' ? '<span class="badge bg-blue text-blue-fg">'.$mst['descx'].'</span>' : '<span class="badge bg-orange text-black">'.$mst['descx'].'</span>') ?>
                                        <?php $statdescn = trim($mst['descn'])=='' ? '' : (trim($mst['descn'])=='FINISHED' ? '<span class="badge bg-blue text-blue-fg">'.$mst['descn'].'</span>' : '<span class="badge bg-orange text-black">'.$mst['descn'].'</span>') ?>
                                        <?php $wrngrap = $mst['stat_po']!=1 ? 'background-color: #f322e5;' : (trim($mst['descx'])=='' ? 'background-color: #F76707;' : 'background-color: #2bb43f;'); ?>
                                        <?php $wrnproc = trim($mst['descx'])=='' ? 'background-color: #F76707;' : 'background-color: #2bb43f;'; ?>
                                            <tr style="<?= $nox%2==0 ? 'background-color: #f1f1f1;' : '' ?>">
                                                <td class="font-kecil <?= $statpo ?>"><?= $mst['dateplan'] ?></td>
                                                <td class="font-kecil text-nowrap"><?= viewsku($mst['po'],$mst['item'],$mst['dis']) ?></td>
                                                <td class="font-kecil text-nowrap"><?= $mst['insno'] ?></td>
                                                <td class="font-kecil"><?= $statdesc ?></td>
                                                <td class="font-kecil"><?= $statdescn ?></td>   
                                                <?php $persen1 = ceil(date('d', strtotime($mst['dateplan']))/7.75)*1; ?>
                                                <?php $bulan = date('m', strtotime($mst['dateplan']))*4; ?>
                                                <?php $tglakhir = date('Y-m-d', strtotime($mst['dateplan'].'+ '.$mst['day'].' days')) ?>
                                                <?php $persen2 = ceil(date('d', strtotime($tglakhir))/7.75)*1; ?>
                                                <?php $bulan2 = date('m', strtotime($tglakhir))*4; ?>
                                                <?php $awal = ($persen1+$bulan)-4;  ?>
                                                <?php $akhir = ($persen2+$bulan2)-4;  ?>
                                                <td class="text-center font-kecil" title="Day Plan NT"><?= $mst['day'] ?></td>
                                                <?php $m=0; $r=0; for ($y=1; $y <= 48 ; $y++) { if($y%4==1) { $m++; $r=$y+1; }  ?>
                                                    <?php $borderl = $y%4!=0 ? "border: none;" : "border-left: none;border-right-color: gray-750;";  ?>
                                                    <td class="text-center" title="Mg Ke <?= $y%4==0 ? 4 : $y%4 ?>&#10;<?= namabulanpendek($m).' '.$this->session->userdata('thgrap') ?>" style="<?= $borderl ?>padding:0 !important;min-width: 22px;">
                                                        <?php $tngh = ($awal < $y && $y < $akhir) ? '1' : '0'; ?>
                                                        <?php $blk = ($persen1 == $persen2) ? 'border-radius: 5px;' : 'border-radius: 5px 0 0 5px;'; ?>
                                                        <?php if($awal == $y): ?>
                                                                <div class="mt-2 w-100 font-kecil text-white" style="<?= $wrngrap ?> height: 17px !important; border-right-color: red; <?= $blk ?>"></div>
                                                        <?php endif; ?>
                                                        <?php if($awal < $y && $y < $akhir): ?>
                                                                <div class="mt-2 w-100 font-kecil text-white" style="<?= $wrngrap ?> height: 17px !important; border-right-color: red;"></div>
                                                        <?php endif; ?>
                                                        <?php if($akhir == $y && $awal != $y): ?>
                                                                <div class="mt-2 w-100 font-kecil text-white" style="<?= $wrngrap ?> height: 17px !important; border-right-color: red;border-radius: 0 5px 5px 0;"></div>
                                                        <?php endif; ?>
                                                    </td>
                                                <?php } ?>
                                            </tr>
                                        <?php endforeach; ?>
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