<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          OUT (Bon Perpindahan)
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url(); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="sisipkan" class="sticky-top bg-white">
          <div class="row mb-1 d-flex align-items-between">
            <div class="col-sm-6 mb-1">
              <div class="<?php IF(cekclosebook($this->session->userdata('blout'),$this->session->userdata('thout'))=='disabled'){ echo "hilang"; } ?>">
                <?php $disab=''; if($this->session->userdata('deptsekarang')=='' || $this->session->userdata('deptsekarang')==null || $this->session->userdata('tujusekarang')=='' || $this->session->userdata('tujusekarang')==null){ $disab = 'disabled';} ?>
                <a href="<?= base_url() . 'out/adddata/0'; ?>" class="btn btn-info btn-sm <?= cekclosebook(); ?> hilang <?= $disab; ?>" id="adddataout"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
                <div id="tujuanbon" class="hilang"> <?= $this->session->userdata('deptsekarang').' ke '.$this->session->userdata('tujusekarang'); ?></div>
                <div class="dropdown hilang " id="buttonpilih2">
                    <button class="btn btn-primary btn-sm dropdown-toggle <?= cekclosebook(); ?>" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span>
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item font-kecil text-primary font-bold" data-title="Add Data" href="<?= base_url() . 'out/adddata/1'; ?>" title="Dari BON Permintaan">Dari BON Permintaan</a>
                    <a class="dropdown-item font-kecil font-bold disabled" data-title="Add Data" href="<?= base_url() . 'out/adddata/0'; ?>" title="Tanpa BON Permintaan">Tanpa BON Permintaan</a>
                    </div>
                </div>
                <input type="hidden" id="errorparam" value="<?= $this->session->flashdata('errorparam'); ?>">
              </div>
              <div class="<?php IF(cekclosebook($this->session->userdata('blout'),$this->session->userdata('thout'))!='disabled'){ echo "hilang"; } ?>">
                <!-- <svg xmlns="http://www.w3.org/2000/svg" class="icon alert-icon text-primary" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" /><path d="M12 9h.01" /><path d="M11 12h1v4h1" /></svg> -->
                <div class="line-11 text-danger m-0 font-kecil">
                  <span class="font-bold">Periode Bulan ini sudah Di Close Book Inventory</span><br>
                  <span class="text-primary">Diclose Oleh : <?= cekclosebook($this->session->userdata('blout'),$this->session->userdata('thout'),'nama') ?></span>
                </div>
              </div>
            </div>
            <div class="col-sm-6 mb-0 d-flex flex-row-reverse" style="text-align: right;">
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="th" name="th" style="width: 75px;" value="<?= $this->session->userdata('thout') ?>">
              <select class="form-select form-control form-sm font-kecil font-bold mr-1" id="bl" name="bl" style="width: 100px;" <?= $levnow; ?>>
                <?php for ($x = 1; $x <= 12; $x++) : ?>
                  <option value="<?= $x; ?>" <?php if ($this->session->userdata('blout') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
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
                      <select class="form-select form-control form-sm font-kecil font-bold" id="dept_kirim" name="dept_kirim">
                        <?php $arrjanganada = ['IT', 'PP', 'AK', 'MK', 'PG', 'BC', 'UT', 'RD', 'PC', 'EI']; ?>
                        <?php foreach ($hakdep as $hak) : if (!in_array($hak['dept_id'], $arrjanganada)) : $selek = $this->session->userdata('deptsekarang') == null ? '' : $this->session->userdata('deptsekarang'); ?>
                            <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?php if ($selek == $hak['dept_id']) echo "selected"; ?>><?= $hak['departemen']; ?></option>
                        <?php endif;
                        endforeach; ?>
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-2 ">
                  <h4 class="mb-1 font-kecil">Dept Tujuan</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="dept_tuju" name="dept_tuju">

                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1 font-kecil" style="color: #FFFFFF">.</h4>
                  <span class="font-kecil">
                    <a href="#" class="btn btn-sm btn-primary" style="height: 38px;min-width:45px;" id="butgo">Go</a>
                  </span>
                </div>
                <div class="col-3" style="font-size: 13px;">
                  <div class="text-blue font-bold mt-2 ">Jumlah Rec : <?= rupiah($jumlahpcskgs['jmrek'],0).'/'.rupiah($jmlrekod['jmlrek'],0); ?></div>
                  <div class="text-blue font-bold">Jumlah Pcs : <?= rupiah($jumlahpcskgs['pcs'],0); ?></div>
                  <div class="text-blue font-bold">Jumlah Kgs : <?= rupiah($jumlahpcskgs['kgs'],2); ?></div>
                </div>
                <div class="col-2">
                  <h4 class="mb-1">
                    <?php if($disab!=''){ ?>
                    <small class="text-pink text-center">Tekan <b>GO</b> untuk mengaktifkan Tombol Tambah Data dan Load Data</small>
                    <?php } ?>
                  </h4>
                </div>
              </div>
              <div class="hr m-1"></div>
              <div class="row mt-0">
                <div class="col-2">
                  <h5 class="m-0">Filter</h5>
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" style="height: 30px; padding-top: 4.5px;" id="filterbon" name="filterbon">
                        <option value="0" <?php if($this->session->userdata('filterbon')==0) { echo "selected"; } ?>>Semua Bon</option>
                        <option value="1" <?php if($this->session->userdata('filterbon')==1) { echo "selected"; } ?>>Bon Belum Validasi</option>
                      </select>
                    </div>
                </div>
                <div class="col-2" id="div-filter2">
                  <h5 class="m-0" style="color: #FFFFFF">.</h5>
                    <div class="font-kecil ">
                      <select class="form-select form-control form-sm font-kecil font-bold text-primary" style="height: 30px; padding-top: 4.5px;" id="filterbon2" name="filterbon2">
                        <?php foreach (getkettujuanout($this->session->userdata('deptsekarang')."-".$this->session->userdata('tujusekarang'))->result_array() as $ketuju) { ?>
                          <option value="0" <?php if($this->session->userdata('filterbon2')==$ketuju['value']) { echo "selected"; } ?>><?= $ketuju['value']; ?></option>
                        <?php } ?>
                      </select>
                    </div>
                </div>
                <div class="col-8"></div>
              </div>
            </div>
          </div>
        </div>
        <div class="mt-2">
          <table id="pbtabel" class="table nowrap order-column datatable" style="width: 100% !important;">
            <thead>
              <tr>
                <th>Tgl</th>
                <th>Nomor</th>
                <th>Jumlah Item</th>
                <th>Dibuat Oleh</th>
                <th>Keterangan</th>
                <th class="text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php foreach ($data as $datdet) {
                $jmlrek = $datdet['jumlah_barang'] != null ? $datdet['jumlah_barang'] . ' Item' : '0 Item'; 
                $inoleh = $datdet['dept_tuju']=='CU' ? ' Marketing' : ' '.datadepartemen($datdet['dept_tuju'],'departemen'); 
                $deptsubkon = daftardeptsubkon(); 
                $notdetail = $datdet['taksama']==1 ? 'text-teal' : '';
                $ceknombc = in_array($datdet['dept_id'],daftardeptsubkon()) ? '<br><span style="font-size:11px" class="text-pink">Ex BC. '.getnomorbcbykontrak($datdet['keterangan'],$datdet['dept_id'],$datdet['dept_tuju']).'</span>' : '';
                ?>
                <tr>
                  <td><?= tglmysql($datdet['tgl']); ?></td>
                  <?php if ($datdet['data_ok'] == 1) { ?>
                    <td class='font-bold line-12'><a href='<?= base_url() . 'out/viewdetailout/' . $datdet['id'] ?>' class="<?= $notdetail ?>" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail'><?= $datdet['nomor_dok'] ?><br><span class="text-purple" style="font-size: 10px !important; font-weight: normal"><?= getpros($datdet['ketprc']) ?></span></a></td>
                  <?php } else { ?>
                    <td class='font-bold line-12'><a href='<?= base_url() . 'out/viewdetailout/' . $datdet['id'] ?>' class="<?= $notdetail ?>" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail'><?= $datdet['nomor_dok'] ?><br><span class="text-purple" style="font-size: 10px !important; font-weight: normal"><?= getpros($datdet['ketprc']) ?></span></a>
                  </td>
                  <?php } ?>
                  <td class="line-12"><?= $jmlrek; ?><br><span class="badge badge-outline text-pink"><?= rupiah($datdet['jumlahpcs'],0); ?> Pcs, <?= rupiah($datdet['netto'],2); ?> Kgs</span></td>
                  <td class="line-12"><?= datauser($datdet['user_ok'], 'name') ?> <br><span style='font-size: 11px;'><?= tglmysql2($datdet['tgl_ok']) ?></span></td>
                  <td class="line-12"><?= $datdet['keterangan'].$ceknombc; ?></td>
                  <td class="text-end line-12"><span style="color: white;">.</span>
                    <?php if ($datdet['data_ok'] == 0) { ?>
                      <a href="<?= base_url() . 'out/dataout/' . $datdet['id'] ?>" class='btn btn-sm btn-primary <?= cekclosebook($this->session->userdata('blout'),$this->session->userdata('thout')) ?>' style='padding: 3px 5px !important;' title='Lanjutkan Transaksi'><i class='fa fa-edit mr-1'></i> Lanjutkan Transaksi</a>
                      <a href="#" data-bs-toggle="modal" data-bs-target="#modal-danger" data-message="Akan menghapus data ini <br> <?= $datdet['nomor_dok']; ?>" data-href="<?= base_url() . 'out/hapusdataout/' . $datdet['id']; ?>" class='btn btn-sm btn-danger <?= cekclosebook(); ?>' style='padding: 3px 5px !important;' title='Hapus Transaksi'><i class='fa fa-trash-o mr-1'></i> Hapus</a>
                      <a href="#" class="btn btn-outline" style='padding: 3px 5px !important;' data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-ellipsis-v "></i>
                      </a>
                      <div class="dropdown-menu">
                        <a class="dropdown-item" href="<?= base_url().'out/setdetailtidaksama/'.$datdet['id'].'/1' ?>">
                          Set detail # detailgen
                        </a>
                        <a class="dropdown-item" href="<?= base_url().'out/setdetailtidaksama/'.$datdet['id'].'/0' ?>">
                          Set detail = detailgen
                        </a>
                      </div>
                    <?php } else if ($datdet['data_ok'] == 1 && $datdet['ok_tuju']==1 && $datdet['ok_valid']==1) { ?>
                      <a href="<?= base_url() . 'out/cetakbon/' . $datdet['id'] ?>" target='_blank' class='btn btn-sm btn-danger' title='Cetak Data'><i class='fa fa-file-pdf-o'></i></a>
                    <?php }else { if($datdet['dept_tuju']=='CU' || $datdet['dept_tuju']=='DL'){  ?>
                      <?php if($datdet['nomor_bc']==''){  ?>
                        <span class="text-teal font-kecil">Tunggu Persetujuan Keluar Barang </span>
                        <?php }else{ ?>
                        <span class="text-teal font-kecil line-12"><a data-href='#' title="Klik untuk menyetujui" data-bs-toggle="modal" data-bs-target="#modal-large" data-message="Validasi OUT <br><?= $datdet['nomor_dok']; ?>" data-title="Konfirmasi Pengeluaran" href="<?= base_url() . 'out/validasimarketing2/' . $datdet['id'] ?>">Barang Sudah Setuju Keluar</a><br><span class="text-black"><?= $datdet['nomor_sppb']; ?></span></span>
                      <?php } ?>
                    <?php }else{ ?>
                      <?php if(in_array($datdet['dept_tuju'],daftardeptsubkon())){ ?>
                        <?php if($datdet['data_ok']==1 && $datdet['ok_tuju']==0){ ?>
                          <span class="text-red font-kecil line-12">Menunggu Pembuatan<br>Dokumen Pengeluaran BC</span>
                        <?php }else{ ?>
                          <span class="text-teal font-kecil line-12">Tunggu Verifikasi <b>IN</b> <?= $inoleh; ?></span>
                        <?php } ?>
                      <?php }else{  ?>
                        <span class="text-teal font-kecil line-12">Tunggu Verifikasi <b>IN</b> <?= $inoleh; ?></span>
                    <?php }}} ?>
                  </td>
                </tr>
              <?php } ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>