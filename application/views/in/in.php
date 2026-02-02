<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          IN (Bon Perpindahan)
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url(); ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
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
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="th" name="th" style="width: 75px;" value="<?= $this->session->userdata('thin') ?>">
              <select class="form-control form-sm font-kecil font-bold mr-1" id="bl" name="bl" style="width: 100px;" <?= $levnow; ?>>
                <?php for($x=1;$x<=12;$x++): ?>
                    <option value="<?= $x; ?>" <?php if($this->session->userdata('blin')==$x) echo "selected"; ?>><?= namabulan($x); ?></option>
                <?php endfor; ?>
              </select>
              <div class="font-kecil font-bold mr-2 align-middle" style="padding-top: 11px;">Periode</div>
            </div>
            
            <input type="text" class="hilang" value="<?= $this->session->userdata('curdeptin'); ?>">
            <input type="text" class="hilang" value="<?= $this->session->userdata('todeptin'); ?>">
          </div>
          <div class="card card-active" style="clear:both;" >
            <div class="card-body p-2">
              <div class="row">
                <div class="col-2">
                  <h4 class="mb-1 font-kecil">Dept </h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-control form-sm font-kecil font-bold" id="dept_kirim"  name="dept_kirim">
                        <?php 
                          //$arrjanganada = ['IT','PP','AK','MK','PG','BC','UT','RD','PC','EI']; 
                          $arrjanganada = [];
                        ?>
                        <?php $disab=''; if($this->session->userdata('curdeptin')=='' || $this->session->userdata('curdeptin')==null || $this->session->userdata('todeptin')=='' || $this->session->userdata('todeptin')==null){ $disab = 'disabled';} ?>
                        <?php foreach ($hakdep as $hak): if(!in_array($hak['dept_id'],$arrjanganada)): $selek = $this->session->userdata('curdeptin')== null ? '' : $this->session->userdata('curdeptin'); ?>
                          <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?php if($selek==$hak['dept_id']) echo "selected"; ?>><?= $hak['departemen']; ?></option>
                        <?php endif; endforeach; ?>
                      </select>
                    </div>
                </span>
                </div>
                <div class="col-2 ">
                  <h4 class="mb-1 font-kecil">Dari Dept</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-control form-sm font-kecil font-bold" id="dept_tuju" name="dept_tuju">
                       
                      </select>
                    </div>
                  </span>
                </div>
                <div class="col-3">
                  <h4 class="mb-1 font-kecil" style="color: #FFFF">.</h4>
                  <span class="font-kecil">
                    <a href="#" class="btn btn-sm btn-primary" style="height: 38px;min-width:45px;" id="butgo">Go</a>
                  </span>
                </div>
                <div class="col-3" style="font-size: 13px;">
                  <div class="text-blue font-bold mt-2 ">Jumlah Rec : <span id="jumlahrekode">0</span>/<span id="jumlahrekod">0</span></div>
                  <div class="text-blue font-bold">Jumlah Pcs : <span id="jumlahpcs">0</span></div>
                  <div class="text-blue font-bold">Jumlah Kgs : <span id="jumlahkgs">0.00</span></div>
                </div>
                <div class="col-2">
                  <h4 class="mb-1"></h4>
                    <?php if($disab!=''){ ?>
                      <small class="text-pink text-center">Tekan <b>GO</b> untuk Load Data</small>
                    <?php } ?>
                </div>
              </div>
              <div class="hr m-1"></div>
              <div class="row mt-0">
                <div class="col-2">
                  <h5 class="m-0">Filter</h5>
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" style="height: 30px; padding-top: 4.5px;" id="filterbon" name="filterbon">
                        <option value="0" <?php if($this->session->userdata('filterbon')==0) { echo "selected"; } ?>>Semua Bon</option>
                        <option value="1" <?php if($this->session->userdata('filterbon')==1) { echo "selected"; } ?>>Bon Belum Konfirmasi</option>
                      </select>
                    </div>
                </div>
                <div class="col-2"></div>
                <div class="col-8"></div>
              </div>
            </div>
          </div>
        </div>
        <div id="table-default" class="mt-2">
          <table class="table nowrap order-column datatable" style="width: 100% !important;" id="cobasisip">
            <thead>
              <tr>
                <th>Tgl</th>
                <th>Nomor</th>
                <th>Jumlah Item</th>
                <th>Dibuat Oleh</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
            <?php $katedept = datadepartemen($this->session->userdata('curdeptin'),'katedept_id'); 
              $norek=0;$jmlpcs=0;$jmlkgs=0;$noreke=0;
              foreach ($data->result_array() as $que) {
              $jmlrek = $que['jumlah_barang'] != null ? $que['jumlah_barang'].' Item' : '';
              $insubkn = '';
              if($katedept==3){
                  $insubkn = '/1';
              }
              $kete = $que['ok_valid']==0 ? 'Menunggu konfirmasi Dept '.$this->session->userdata('curdeptin') : 'DiKonfirmasi : '.datauser($que['user_valid'],'name').'<br><span style="font-size: 11px;">@'.tglmysql2($que['tgl_valid']."</span>");
              $bisakonfirmasi = 1;
              if($que['dept_id']=='SU' || $que['dept_id']=='CU'){
                if($que['tanpa_bc']==0){
                  $bisakonfirmasi = $que['nomor_bc']!='';
                }
              }
              if($que['ok_valid']==1){
                  $cekpcskgs = $this->inmodel->cekpcskgs($que['id'])->row_array();
                  $jmlpcs += $cekpcskgs['pcs'];
                  $jmlkgs += $cekpcskgs['kgs'];
                  $noreke++;
              }
              ?>
                <tr>
                  <td><?= tglmysql($que['tgl']) ?></td>
                  <?php if($que['data_ok']==1){  ?>
                    <td class="font-bold"><a href="<?= base_url().'in/viewdetailin/'.$que['id'].$insubkn ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail"><?= $que['nomor_dok'].'<br><span class="font-kecil">'.$que['nodok']."</span>" ?></a></td>
                  <?php }else{ ?>
                    <td class="font-bold"><?= $que['nomor_dok'].'<br><span class="text-purple" style="font-size: 10px !important">'.$que['nodok']."</span>" ?></td>
                  <?php } ?>
                  <td><?= $jmlrek; ?></td>
                  <td style="line-height: 12px"><?= datauser($que['user_ok'],'name'); ?><br><span style='font-size: 11px;' class='text-secondary'><?= tglmysql2($que['tgl_ok']) ?></span></td>
                  <td class="font-kecil line-12"><?= $kete; ?></td>
                  <td>
                    <?php if($que['ok_valid']==0 && $bisakonfirmasi){ ?>
                      <a href="#" data-href="<?= base_url().'in/cekkonfirmasi/'.$que['id'].$insubkn ?>" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Konfirmasi Penerimaan Barang,<br> data tidak dapat dirubah kembali" class="btn btn-sm btn-success <?= cekclosebook() ?>" style="padding: 3px 5px !important;" title="Konfirmasi Data"><i class="fa fa-check mr-1"></i> Konfirmasi</a>
                    <?php }else if($que['ok_valid']==1){ ?>
                      <a href="<?= base_url().'in/cetakbon/'.$que['id'] ?>" target="_blank" class="btn btn-sm btn-danger" title="Cetak Data"><i class="fa fa-file-pdf-o"></i></a>
                    <?php } ?>
                  </td>
                </tr>
              <?php
              $norek++;
            } ?>
            </tbody>
          </table>
        </div>
        <div class="card card-active mt-2 hilang" style="clear:both;">
          <div class="card-body p-2 font-kecil">
            <div class="row">
              <div class="col-3">
                <div class="font-bold">Jumlah Rec : </div>
                <div id="jumlahrekod">XX</div>
              </div>
              <div class="col-3">
                <div class="font-bold">Pcs : </div>
                <div id="jumlahpcs">XX</div>
              </div>
              <div class="col-3">
                <div class="font-bold">Kgs : </div>
                <div id="jumlahkgs">XX</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
        