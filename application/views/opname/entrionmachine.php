<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
    <div class="container-xl">
        <div class="row g-0 d-flex align-items-between">
            <div class="col-md-6">
                <div class="page-pretitle pl-2">
                    Entry Data Periode <span class><?= tglmysql($detailperiode['tgl']) ?></span>
                </div>
                <h2 class="page-title px-2">
                    Data Stok Taking (On Machine)
                </h2>
            </div>
            <div class="col-md-6 d-flex justify-content-end" style="text-align: right;">
                <a href="<?= base_url() . 'opname/entrydata'; ?>" style="height: 38px;" class="btn btn-primary btn-sm ml-1"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali </span></a>
            </div>
        </div>
    </div>
</div>
<div class="page-body mt-0">
    <div class="container-xl">
        <div class="card">
            <div class="card-body p-2">
                <div class="card card-active mb-2">
                    <div class="card-body p-2">
                        <div class="row">
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Departemen</label>
                                    <div class="col mb-1">
                                        <input type="text" name="id" id="id" value="<?= $header['id'] ?>" class="hilang">
                                        <input type="text" name="deptid" id="deptid" value="<?= $header['dept_id'] ?>" class="hilang">
                                       <input type="text" name="namadept" id="namadept" class="form-control btn-flat font-bold font-kecil" value="<?= $header['departemen'] ?>">
                                    </div>
                                </div>
                                <div class="row">
                                    <label class="col-3 col-form-label font-kecil font-bold">Sub Lokasi</label>
                                    <div class="col mb-1">
                                        <input type="text" name="namadept" id="namadept" class="form-control btn-flat font-bold font-kecil" value="<?= $header['nama_lokasi'].' ( '.$header['kode_lokasi'].' )' ?>">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-5 mb-1">
                                <table class="table table-bordered m-0">
                                    <thead class="bg-primary-lt">
                                        <tr>
                                            <th class="bg-orange-lt text-center text-black" colspan="3"><span class="text-black">Rekap Dokumen</span></th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-tbody">
                                        <?php $pembagi = $header['item']==0 ? 1 : $header['item']; ?>
                                        <?php $persenverif = $header['persen_verif']; ?>
                                        <?php $persenrilis = $header['persen_rilis']; ?>
                                        <tr>
                                            <?php $pcs = $header['pcs']==0 ? '0' : rupiah($header['pcs'],2); $kgs = $header['kgs']==0 ? '0' : rupiah($header['kgs'],2); ?>
                                            <td class="font-kecil"><?= $pcs ?> Pcs</td>
                                            <td class="font-kecil">Status Dok : -</td>
                                            <td class="font-kecil">Verifikasi 1 : <span class="text-cyan font-bold"><?= rupiah($header['item_verif'],0) ?> Item</span> (<?= (round($header['item_verif']/$pembagi,2)*100).'% / '.$persenverif.'%'  ?>)</td>
                                        </tr>
                                        <tr>
                                            <td class="font-kecil"><?= $kgs ?> Kgs</td>
                                            <td class="font-kecil">Input : <span class="text-cyan font-bold"><?= rupiah($header['item'],0) ?> Item</span></td>
                                            <td class="font-kecil">Verifikasi 2 : <span class="text-cyan font-bold"><?= rupiah($header['item_rilis'],0) ?> Item</span> (<?= (round($header['item_rilis']/$pembagi,2)*100).'% / '.$persenrilis.'%'  ?>)</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-12 col-md-3">
                                <span class="font-kecil text-pink <?php if($this->session->userdata('periodeopname')!=''){ echo "hilang"; } ?>">Periode Stok Opname belum dipilih !</span>
                                <input type="text" name="periode" id="periode" class="hilang" value="<?= $this->session->userdata('periodeopname') ?>">
                                <textarea name="carientri" id="carientri" class="form-control font-kecil" placeholder="Cari nomor Mesin.."><?= $this->session->userdata('cari-entri') ?></textarea>
                                <div class="d-flex">
                                <a href="#" class="btn btn-sm btn-success form-control mt-1" id="caridataentry">Cari</a>
                                <a href="#" class="btn btn-sm btn-danger form-control mt-1 w-25" id="resetdataentry">Cari</a>
                                </div>
                            </div>
                        </div>
                        <hr class="m-1">
                        <div class="text-right">
                            <?php $disableverifikasi = $header['persen_verif'] > (round($header['item_verif']/$pembagi,2)*100) ? 'disabled' : ''; ?>
                            <?php $disablerilis = $header['persen_rilis'] > (round($header['item_rilis']/$pembagi,2)*100) ? 'disabled' : ''; ?>
                            <?php if($header['status']==0 && ($this->session->userdata('rolestokopname')==2 || $this->session->userdata('rolestokopname')==99)): ?>
                                <a href="<?= base_url().'opname/tambahdataonmachine/'.$this->uri->segment(3).'/'.$header['id'] ?>" class="btn btn-sm btn-primary btn-flat mt-1" data-message="Akan menyelesaikan input stok opname ini, Data tidak bisa diedit kembali">Tambah Data on Machine</a>
                                <a href="#" data-href="<?= base_url().'opname/selesaiinput/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$header['id'] ?>" class="btn btn-sm btn-warning btn-flat mt-1" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyelesaikan input stok opname ini, Data tidak bisa diedit kembali"><span class="text-black">Input Data Selesai</span></a>
                            <?php elseif($header['status']==1): ?>
                                <?php if($this->session->userdata('rolestokopname')==2 || $this->session->userdata('rolestokopname')==99): ?>
                                    <a href="#" data-href="<?= base_url().'opname/batalinput/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$header['id'] ?>" class="btn btn-sm btn-danger btn-flat mt-1" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan merubah kembali status Stok agar bisa kembali di Edit"><span class="">Kembali Edit Data</span></a>
                                <?php endif; ?>
                                <?php if($this->session->userdata('rolestokopname')==3 || $this->session->userdata('rolestokopname')==99): ?>
                                    <a href="#" data-href="<?= base_url().'opname/selesaiverifikasi1/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$header['id'] ?>" class="btn btn-sm btn-info btn-flat mt-1 <?= $disableverifikasi ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyelesaikan Verifikasi stok opname ini, Data tidak bisa diedit kembali"><span class="">Selesai Verifikasi Data</span></a>
                                <?php endif; ?>
                            <?php elseif($header['status']==2 && ($this->session->userdata('rolestokopname')==4 || $this->session->userdata('rolestokopname')==99)): ?>
                                <?php if($this->session->userdata('rolestokopname')==99): ?>
                                    <a href="#" data-href="<?= base_url().'opname/batalverifikasi1/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$header['id'] ?>" class="btn btn-sm btn-danger btn-flat mt-1" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan merubah kembali status menjadi Selesai Input"><span class="">Kembali Verifikasi Data</span></a>
                                <?php endif; ?>
                                <a href="#" data-href="<?= base_url().'opname/selesairilis/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$header['id'] ?>" class="btn btn-sm btn-info btn-flat mt-1 <?= $disablerilis ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyelesaikan Verifikasi stok opname ini, Data tidak bisa diedit kembali"><span class="">Selesai Verifikasi KAP</span></a>
                            <?php elseif($this->session->userdata('rolestokopname')==99): ?>
                                <a href="#" data-href="<?= base_url().'opname/batalrilis/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$header['id'] ?>" class="btn btn-sm btn-danger btn-flat mt-1" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan merubah kembali status menjadi Selesai Input"><span class="">Kembali Verifikasi KAP</span></a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>  
                <hr class="m-1">
                <div class="row">
                    <div class="col-12 overflow-auto">
                        <table class="table table-bordered m-0 table-hover">
                            <thead class="bg-primary-lt">
                                <tr>
                                    <th class="text-black line-11">Nomor<br>Mesin</th>
                                    <th class="text-black">Spek Barang</th>
                                    <th class="text-black line-11">Berat<br>Bunsen<br>Kosong</th>
                                    <th class="text-black line-11">Jumlah<br>Bunsen<br>di Box</th>
                                    <th class="text-black line-11">Berat<br>Box<br>Bunsen</th>
                                    <th class="text-black line-11">Jml<br>Bunsen<br>di Mesin</th>
                                    <th class="text-black line-11">Berat<br>Bunsen<br>di Mesin</th>
                                    <th class="text-black line-11">Jenis<br>Bobbin</th>
                                    <th class="text-black line-11">Berat<br>Bobbin<br>Kosong</th>
                                    <th class="text-black line-11">Berat<br>Bobbin<br>Isi</th>
                                    <th class="text-black line-11">Jumlah<br>Bobbin<br>di Mesin</th>
                                    <th class="text-black line-11">Lot<br>di Mesin</th>
                                    <?php if($header['status'] == 0): ?>
                                        <th class="text-black">Aksi</th>
                                    <?php endif; ?>
                                    <?php if($header['status'] > 0): ?>
                                        <th class="text-black">Cek</th>
                                    <?php endif; ?>
                                </tr>
                            </thead>
                            <tbody class="table-tbody">
                                <?php if($data->num_rows() > 0): ?>
                                    <?php foreach($data->result_array() as $dt): ?>
                                    <?php 
                                        $sku = trim($dt['po'])=='' ? namaspekbarang($dt['brg_id'],'kode') : viewsku($dt['po'],$dt['item'],$dt['dis']);
                                        $spek = trim($dt['po'])=='' ? '<span class="text-cyan font-11"> SKU. '.$sku.'</span></br>'.namaspekbarang($dt['id_barang']) : '<span class="text-cyan font-11"> SKU. '.$sku.'</span></br>'.spekpo($dt['po'],$dt['item'],$dt['dis']);
                                        // $nobontr = trim($dt['nobontr'])=='' ? '' : '<br><span class="text-pink font-11"> IB. '.$dt['nobontr'].'</span>';
                                        $insno = trim($dt['insno'])=='' ? '' : '<br><span class="text-pink font-11"> INSNO. '.$dt['insno'].'</span>';
                                        // $grd = $dt['stok']==1 ? 'A' : ($dt['stok']==2 ? 'B' : '');
                                    ?>
                                        <tr>
                                            <td class="font-kecil"><?= $dt['machno'] ?></td>
                                            <td class="font-kecil line-11"><?= $spek.$insno ?></td>
                                            <td class="font-kecil text-right"><?= rupiah($dt['bunko'],2) ?></td>
                                            <td class="font-kecil text-right"><?= rupiah($dt['bunjmlbox'],0) ?></td>
                                            <td class="font-kecil text-right"><?= rupiah($dt['bunbrtbox'],3) ?></td>
                                            <td class="font-kecil text-right"><?= rupiah($dt['bunjmlmsn'],0) ?></td>
                                            <td class="font-kecil text-right"><?= rupiah($dt['bunbrtmsn'],3) ?></td>
                                            <td class="font-kecil"><?= $dt['jnsbob'] ?></td>
                                            <td class="font-kecil text-right"><?= rupiah($dt['bobko'],2) ?></td>
                                            <td class="font-kecil text-right"><?= rupiah($dt['bobisi'],3) ?></td>
                                            <td class="font-kecil text-right"><?= rupiah($dt['bobjmlmsn'],0) ?></td>
                                            <td class="font-kecil line-11"><?= 'Lot '.$dt['lot_dari'].'~'.$dt['lot_sampai'].'<br>Rpm '.rupiah($dt['rpm'],0) ?></td>
                                            <?php if($header['status'] == 0): ?>
                                            <td class="font-kecil text-center">
                                                <a href="<?= base_url().'opname/editentrionmesin/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$dt['id'] ?>" id="editentristok" rel="<?= $dt['id'] ?>" rel2="<?= $this->uri->segment(3) ?>" rel3="<?= $this->uri->segment(4) ?>" class="btn btn-sm btn-flat btn-info" style="padding: 2px 6px !important;">Edit</a>
                                                <a href="#" data-href="<?= base_url().'opname/hapusentrionmesin/'.$this->uri->segment(3).'/'.$this->uri->segment(4).'/'.$dt['id'] ?>" data-bs-target="#modal-danger" data-bs-toggle="modal" data-message="Akan menghapus data ini" class="btn btn-sm btn-flat btn-danger" style="padding: 2px 6px !important;">Hapus</a>
                                            </td>
                                            <?php endif; ?>
                                            <?php if($header['status'] > 0): ?>
                                                <td class="font-kecil text-center" id="kolomverif<?= $dt['id'] ?>">
                                                    <?php if($header['status']==1 && ($this->session->userdata('rolestokopname')==3 || $this->session->userdata('rolestokopname')==99)): ?> <!-- Status Selesai -->
                                                        <?php if($dt['user_verif']!=0): ?>
                                                            <div class="font-kecil line-11 text-blue"><a href="#" data-href="<?= base_url().'opname/batalkanverifstok/'.$this->uri->segment(3).'/'.$dt['id'] ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Batalkan Verifikasi">Verified<br><?= strtoupper(datauser($dt['user_verif'],'username')) ?> <span class="font-10"><?= tglmysql2($dt['tgl_verif']) ?></span></a></div>
                                                        <?php else: ?>
                                                            <a href="#" id="verifentrimesin" rel="<?= $dt['id'] ?>" rel2="<?= $this->uri->segment(3) ?>" rel3="<?= $this->uri->segment(4) ?>" class="btn btn-sm btn-flat btn-info" style="padding: 2px 6px !important;">Verify</a>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php if($dt['user_verif']!=0 && $this->session->userdata('rolestokopname')!=4): ?>
                                                            <div class="font-kecil line-11 text-blue"><a href="#">Verified<br><?= strtoupper(datauser($dt['user_verif'],'username')) ?> <span class="font-10"><?= tglmysql2($dt['tgl_verif']) ?></span></div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                    <?php if($header['status']==2 && ($this->session->userdata('rolestokopname')==4 || $this->session->userdata('rolestokopname')==99)): ?> <!-- Status Verifikasi 1 -->
                                                        <?php if($dt['user_rilis']!=0): ?>
                                                            <div class="font-kecil line-11 text-blue"><a href="#" data-href="<?= base_url().'opname/batalkanrilismesin/'.$this->uri->segment(3).'/'.$dt['id'] ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Batalkan Verifikasi">Verified KAP<br><?= strtoupper(datauser($dt['user_rilis'],'username')) ?> <span class="font-10"><?= tglmysql2($dt['tgl_rilis']) ?></span></a></div>
                                                        <?php else: ?>
                                                            <a href="#" id="rilisentrimesin" rel="<?= $dt['id'] ?>" rel2="<?= $this->uri->segment(3) ?>" rel3="<?= $this->uri->segment(4) ?>" class="btn btn-sm btn-flat btn-info" style="padding: 2px 6px !important;">Verify</a>
                                                        <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php if($dt['user_rilis']!=0): ?>
                                                            <hr class="m-1">
                                                            <div class="font-kecil line-11"><a href="#" class="text-info">Verified KAP<br><?= strtoupper(datauser($dt['user_rilis'],'username')) ?> <span class="font-10"><?= tglmysql2($dt['tgl_rilis']) ?></span></div>
                                                        <?php endif; ?>
                                                    <?php endif; ?>
                                                </td>
                                            <?php endif; ?>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="13" class="text-center">-- Data Kosong --</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <div class="d-flex justify-content-between mt-1">
                            <div class="mt-1">
                                Jumlah Record <?= rupiah($jumlahrek,0) ?>
                            </div>
                            <div>
                                <?= $links; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>