<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <h2 class="page-title p-2">
                    Close Book Inventory
                </h2>
            </div>
            <div class="col-md-6" style="text-align: right;">
                <a href="<?= base_url() . 'lockinv/tambahdata'; ?>" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Close Book Inventory"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">

        <div class="card">
            <div class="card-body">
                <div id="table-default" class="table-responsive">
                    <table class="table datatable">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Periode</th>
                                <th>Dibuat Oleh </th>
                                <th>Dibuat Pada</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="table-tbody" style="font-size: 13px !important;">
                            <?php $no = 0;
                            foreach ($lock as $key) : $no++; 
                            $daribulan = namabulan(substr($key['periode'],0,2)).' '.substr($key['periode'],2,4);
                            $kebulan = substr($key['periode'],0,2)=='12' ? namabulan('01') : namabulan((int) substr($key['periode'],0,2)+1);
                            $ketahun = substr($key['periode'],0,2)=='12' ? (int) substr($key['periode'],2,4)+1 : substr($key['periode'],2,4);
                            ?>
                                <tr>
                                    <td><?= $no; ?></td>
                                    <td class="font-bold"><?= namabulan(substr($key['periode'],0,2)).' '.substr($key['periode'],2,4); ?></td>
                                    <td><?= $key['name']; ?></td>
                                    <td><?= tglmysql2($key['dibuat_pada']); ?></td>
                                    <td>
                                        <a class="btn btn-sm btn-danger btn-icon text-white font-kecil" style="padding: 3px 5px !important;" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini" data-href="<?= base_url() . 'lockinv/hapusdata/' . $key['id']; ?>" title="Hapus data">
                                            <i class="fa fa-trash-o mr-1"></i> Hapus Data
                                        </a>
                                        <a href="#" class="btn btn-sm btn-success btn-icon text-white font-kecil" style="padding: 3px 5px !important;" id="hapususer" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan memindahkan Saldo bulan <?= $daribulan; ?> ke Bulan <?= $kebulan.' '.$ketahun; ?>" data-href="<?= base_url() . 'lockinv/saktosaw/' . $key['id']; ?>" title="Hapus data">
                                            <i class="fa fa-arrow-right mr-1"></i> Sak to Saw
                                        </a>
                                        <?php if($key['dibuat_pada'] != $key['diupdate_pada']){ ?>
                                            <span class="text-purple font-kecil">Update On. <?= tglmysql2($key['diupdate_pada']); ?></span>
                                        <?php }else{ ?>
                                            <span class="text-purple font-kecil">Data Belum Submit ke Saldo Awal <?= $kebulan.' '.$ketahun; ?></span>
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