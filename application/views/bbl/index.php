<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    BBL (Bon Pembelian Barang)
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url(); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
                <input type="hidden" id="errorparam" value="<?= $this->session->flashdata('errorparam'); ?>">
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="sticky-top bg-white">
                    <div class="row mb-1 d-flex align-items-between">
                        <div class="col-sm-6">
                            <!-- <a href="<?= base_url() . 'bbl/tambahdata'; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Transaksi" class="btn btn-primary btn-sm" id="adddatapb"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a> -->
                              <?php $disab=''; if($this->session->userdata('deptsekarang')=='' || $this->session->userdata('deptsekarang')==null){ $disab = 'disabled';} ?>
                            <div class="dropdown">
                                <button class="btn btn-primary btn-sm dropdown-toggle <?= $disab; ?>" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span>
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item font-kecil font-bold" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Data" href="<?= base_url() . 'bbl/tambahdata/0'; ?>" title="BBL Dari BON Permintaan">Dari BON Permintaan</a>
                                <a class="dropdown-item font-kecil font-bold" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Data" href="<?= base_url() . 'bbl/tambahdata/1'; ?>" title="BBL Tanpa BON Permintaan">Tanpa BON Permintaan</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
                            <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="th" name="th" style="width: 75px;" value="<?= $this->session->userdata('th') ?>">
                            <select class="form-control form-sm font-kecil font-bold mr-1" id="bl" name="bl" style="width: 100px;" <?= $levnow; ?>>
                                <?php for ($x = 1; $x <= 12; $x++) : ?>
                                    <option value="<?= $x; ?>" <?php if ($this->session->userdata('bl') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                                <?php endfor; ?>
                            </select>
                        </div>
                    </div>
                    <div class="card card-active" style="clear:both;">
                        <div class="card-body p-2 font-kecil">
                            <div class="row">
                                <div class="col-2">
                                    <h4 class="mb-1 font-kecil">Dept Asal</h4>
                                    <span class="font-kecil">
                                        <div class="font-kecil">
                                            <select class="form-control form-sm font-kecil font-bold" id="dept_kirim" name="dept_kirim">
                                                <?php
                                                $selek = $this->session->userdata('deptsekarang')==null ? $this->session->userdata('dept_user') : $this->session->userdata('deptsekarang');
                                                foreach ($hakdep as $hak) :
                                                    $selected = ($selek == $hak['dept_id']) ? "selected" : "";
                                                    $arrdepbbl = arrdep(deptbbl);
                                                    if(in_array($hak['dept_id'],$arrdepbbl)):
                                                ?>
                                                    <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?= $selected ?>>
                                                        <?= $hak['departemen']; ?>
                                                    </option>
                                                <?php endif; endforeach; ?>

                                            </select>
                                        </div>
                                    </span>
                                </div>
                                <div class="col-2 ">
                                    <h4 class="mb-1 font-kecil">Dept Tujuan</h4>
                                    <span class="font-kecil">
                                        <div class="font-kecil">
                                            <select class="form-control form-sm font-kecil font-bold" id="dept_tuju" name="dept_tuju" disabled>
                                                <option value="PC" rel="PURCHASING" selected>PURCHASING</option>
                                            </select>
                                        </div>
                                    </span>
                                </div>
                                <div class="col-3">
                                    <h4 class="mb-1 font-kecil">.</h4>
                                    <span class="font-kecil">
                                        <a href="#" class="btn btn-sm btn-primary" style="height: 38px;min-width:45px;" id="butgo">Go</a>
                                    </span>
                                </div>
                                <div class="col-3">
                                    <h4 class="mb-1"></h4>
                                </div>
                                <div class="col-2">
                                    <h4 class="mb-1">
                                        <?php if($disab!=''){ ?>
                                            <small class="text-pink text-center">Tekan <b>GO</b> untuk mengaktifkan Tombol Tambah Data dan Load Data</small>
                                        <?php } ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <div>
                    <table id="pbtabel" class="table nowrap order-column" style="width: 100% !important;">
                        <thead>
                            <tr>
                                <th>Tgl</th>
                                <th>Nomor</th>
                                <th>Jumlah Item</th>
                                <th>P</th> 
                                <th>Sv</th> 
                                <th>Dept</th> 
                                <th>Dibuat Oleh</th>
                                <th>Keterangan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                            <?php
                            foreach ($data as $datdet) :
                                $jmlrec = $datdet['jmlrex'] == null ? '' : $datdet['jmlrex'] . ' Item ';
                                $jnbbl = $datdet['jn_bbl']==0 ? '' : 'text-danger';
                            ?>
                                <tr>
                                    <td class="<?= $jnbbl; ?>"><?= tglmysql($datdet['tgl']); ?></td>
                                    <td><a href='<?= base_url() . 'bbl/viewdetail_bbl/' . $datdet['id'] ?>' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' title='View Detail'><?= $datdet['nomor_dok'] ?></a></td>
                                    <td><?= $jmlrec; ?></td>
                                    <td class="font-bold text-success"><?php if($datdet['bbl_pp']==1){ echo "P"; }  ?> <?php if($datdet['bbl_pp']==2){ echo "Ut"; }  ?></td>
                                    <td class="font-bold text-danger"><?php if($datdet['bbl_sv']==1){ echo "Sv"; }  ?></td>
                                    <td class="font-bold font-kecil"><?= $datdet['dept_bbl']  ?></td>
                                    <?php if($datdet['data_ok']==1){ ?>
                                    <td style="line-height: 14px;"><?= substr(datauser($datdet['user_ok'], 'name'), 0, 35) . "<br><span style='font-size: 10px;'>" . tglmysql2($datdet['tgl_ok']) . "</span>" ?></td>
                                    <?php }else{ ?>
                                    <td></td>
                                    <?php } ?>
                                    <td><?= $datdet['keterangan'] ?></td>
                                    <td>
                                        <?php if($datdet['ok_bb']==1 && $datdet['data_ok']==0 && $datdet['ok_valid']==0 && $this->session->userdata('level_user') > 1){ ?>
                                        Tunggu Validasi Kep Dept
                                        <a href="#" data-href="<?= base_url() . 'bbl/editbbl/' . $datdet['id']; ?>" class="btn btn-sm btn-info btn-icon btn-flat mr-1" style="padding: 5px !important" id="Edit detail Bbl" data-message="Akan edit data ini" data-bs-toggle='modal' data-bs-target='#modal-info' data-title="Edit detail Bbl" rel="<?= $datdet['id']; ?>" title="Edit data">
                                            <i class="fa fa-refresh mr-1"></i> Edit
                                        </a>
                                        
                                        <?php }else if($datdet['ok_bb']==0 && $datdet['data_ok']==0 && $datdet['ok_valid']==0){ ?>
                                        <a href="<?= base_url() . 'bbl/editdetail_bbl/' . $datdet['id']; ?>" class="btn btn-sm btn-primary btn-icon text-white">
                                            <i class="fa fa-edit"></i>
                                        </a>
                                        <a class="btn btn-sm btn-danger btn-icon text-white" id="hapusnettype" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'bbl/hapus_detail/' . $datdet['id']; ?>" title="Hapus data">
                                            <i class="fa fa-trash-o"></i>
                                        </a>
                                        <?php }else{ 
                                            if($datdet['ok_pp']==0){
                                                if($datdet['bbl_pp']==1){
                                                    $tungguvalid = 'Tunggu Validasi Manager PP';
                                                }else{
                                                    $tungguvalid = 'Tunggu Validasi Manager UT';
                                                }
                                            }else{
                                                if($datdet['ok_valid']==0){
                                                    $tungguvalid = 'Tunggu Validasi Manager '.$datdet['dept_bbl'];
                                                }else{
                                                    if($datdet['ok_tuju']==0){
                                                        $tungguvalid = 'Tunggu Validasi GM '.$datdet['dept_bbl'];
                                                    }else{
                                                        if($datdet['ok_tuju']==0){
                                                            $tungguvalid = 'Tunggu Validasi GM Purchasing';
                                                        }else{
                                                            $tungguvalid = 'Proses PO';
                                                        }
                                                    }
                                                }
                                            }
                                            ?>
                                            <?= $tungguvalid; ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>