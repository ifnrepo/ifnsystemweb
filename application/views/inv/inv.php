<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Inventory Barang
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url(); ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
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
            <div class="col-sm-6 d-flex">
              <select class="form-control form-sm font-kecil font-bold mr-1" id="currdept"  name="currdept">
                  <?php 
                  // Mendapatkan nilai 'deptsekarang', jikla null nilai default jadi it
                  $selek = $this->session->userdata('currdept') ?? 'IT'; 
                  foreach ($hakdep as $hak): 
                      $selected = ($selek == $hak['dept_id']) ? "selected" : ""; 
                  ?>
                      <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?= $selected ?>>
                          <?= $hak['departemen']; ?>
                      </option>
                  <?php endforeach; ?>
              </select>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-1" id="tglawal" name="tglawal" style="width: 95px;" value="<?= $tglawal ?>">
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="tglakhir" name="tglakhir" style="width: 95px;" value="<?= $tglakhir ?>">
              <a href="#" class="btn btn-success btn-sm font-bold" id="updateinv"><i class="fa fa-refresh"></i><span class="ml-1">Update</span></a>
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">

            </div>
          </div>
          <div class="card card-active hilang" style="clear:both;" >
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2">
                  <h4 class="mb-1 font-kecil">Dept Asal</h4>
                  <!-- <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-control form-sm font-kecil font-bold" id="dept_kirim"  name="dept_kirim">
                        <?php foreach ($hakdep as $hak): $selek = $this->session->userdata('deptsekarang')== null ? '' : $this->session->userdata('deptsekarang'); ?>
                          <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?php if($selek==$hak['dept_id']) echo "selected"; ?>><?= $hak['departemen']; ?></option>
                        <?php endforeach; ?>
                      </select>
                    </div>
                </span> -->

                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-control form-sm font-kecil font-bold" id="dept_kirim"  name="dept_kirim">
                          <?php 
                          // Mendapatkan nilai 'deptsekarang', jikla null nilai default jadi it
                          $selek = $this->session->userdata('deptsekarang') ?? 'IT'; 
                          foreach ($hakdep as $hak): 
                              $selected = ($selek == $hak['dept_id']) ? "selected" : ""; 
                          ?>
                              <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?= $selected ?>>
                                  <?= $hak['departemen']; ?>
                              </option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                </span> 
                </div>
                <div class="col-2 ">
                  <h4 class="mb-1 font-kecil">Dept Tujuan</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-control form-sm font-kecil font-bold" id="dept_tuju" name="dept_tuju">
                       
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
                  <h4 class="mb-1"></h4>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
          
        </div>
        <div>
          <table id="pbtabel" class="table nowrap order-column" style="width: 100% !important;">
            <thead>
              <tr>
                <th>Tgl</th>
                <th>Spesifikasi</th>
                <th>SKU</th>
                <th>Satuan</th>
                <th>Awal</th>
                <th>Input</th>
                <th>Output</th>
                <th>Saldo</th>
                <th>Ket</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
              <?php if($data!=null): $brg=''; $sak=0; foreach ($data->result_array() as $det) { 
                $saldo = substr($det['mode'],0,1)=='S' ? $det['pcs'] : 0; 
                $out = substr($det['mode'],0,1)=='O' ? $det['pcs'] : 0; 
                $in = substr($det['mode'],0,1)=='I' ? $det['pcs'] : 0; 
                if($brg != $det['id_barang']){
                  $brg = $det['id_barang'];
                  $sak = $saldo+$in-$out;
                }else{
                  $sak += $saldo+$in-$out;
                }
                $bgred = substr($det['mode'],0,1)=='S' ? 'text-red' : ''; 
              ?>
                <tr>
                  <td><?= substr(tglmysql($det['tgl']),0,2); ?></td>
                  <td><?= $det['nama_barang']; ?></td>
                  <td><?= $det['id_barang']; ?></td>
                  <td><?= $det['kodesatuan']; ?></td>
                  <td><?= rupiah($saldo,0); ?></td>
                  <td><?= rupiah($in,0); ?></td>
                  <td><?= rupiah($out,0); ?></td>
                  <td><?= rupiah($sak,0); ?></td>
                  <td><?= $det['nomor_dok']; ?></td>
                </tr>
              <?php } endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>
        