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
              <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white" id="currdept"  name="currdept">
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
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2 hilang" id="tglakhir" name="tglakhir" style="width: 95px;" value="<?= $tglakhir ?>">
              <a href="#" class="btn btn-success btn-sm font-bold" id="updateinv"><i class="fa fa-refresh"></i><span class="ml-1">Update</span></a>
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">

            </div>
          </div>
          <div class="card card-active" style="clear:both;" >
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3">
                  <h4 class="mb-1 font-kecil">Kategori Barang</h4>
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-control form-sm font-kecil font-bold" id="katbar"  name="katbar">
                      </select>
                    </div>
                  </span> 
                </div>
                <div class="col-3 ">
                  <!-- <label class="form-check mt-1">
                    <input class="form-check-input" type="checkbox" id="gbg">
                    <span class="form-check-label font-bold">Gabung</span>
                  </label>
                  <label class="form-check mb-0">
                    <input class="form-check-input" type="checkbox">
                    <span class="form-check-label font-bold" id="spcbarang">Minus</span>
                  </label> -->
                </div>
                <div class="col-3">
                  <!-- <h4 class="mb-3 font-kecil">Spesifikasi Barang</h4>
                  <span class="font-kecil">
                    <label class="form-check mb-0">
                      <input class="form-check-input" type="checkbox">
                      <span class="form-check-label font-bold">-</span>
                    </label>
                  </span> -->
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
          <table id="tabel" class="table nowrap order-column datatable7" style="width: 100% !important;">
            <thead>
              <tr>
                <!-- <th>Tgl</th> -->
                <th>Spesifikasi</th>
                <th>SKU</th>
                <th>Nomor IB</th>
                <th>Insno</th>
                <th>Satuan</th>
                <th>Kategori</th>
                <!-- <th>Output</th> -->
                <th>Qty</th>
                <th>Kgs</th>
                <!-- <th>Ket</th> -->
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;" >
              <?php  $hasilsak=0;  if($data!=null): $brg=''; $sak=0;$sakkg=0; foreach ($data->result_array() as $det) {
                $saldo = $det['pcs'];
                $in = $det['pcsin'];
                $out = $det['pcsout'];
                $saldokg = $det['kgs'];
                $inkg = $det['kgsin'];
                $outkg = $det['kgsout'];
                if($brg != $det['id_barang']){
                  $brg = $det['id_barang'];
                  $sak = $saldo+$in-$out;
                  $sakkg = $saldokg+$inkg-$outkg;
                }else{
                  $sak += $saldo+$in-$out;
                  $sakkg = $saldokg+$inkg-$outkg;
                }
                $bg = $sak >= 0 ? 'text-teal-green' : 'text-danger';
                $hasilsak += $det['pcs'];
              ?>
                <tr class="<?= $bg; ?>">
                  <td style="border-bottom: red;"><a href='<?= base_url().'inv/viewdetail/'; ?>' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' title='View Detail' id="namabarang" rel="<?= $det['id_barang']; ?>" rel2="<?= $det['nama_barang']; ?>" style="text-decoration: none;" class="text-teal-green"><?= substr($det['nama_barang'],0,75); ?></a></td>
                  <td style="border-bottom: red;"><?= viewsku(id: $det['kode'],po: $det['po'],no: $det['item'],dis: $det['dis']) ?></td>
                  <td style="border-bottom: red;"><?= $det['nobontr']; ?></td>
                  <td style="border-bottom: red;"><?= $det['insno']; ?></td>
                  <td style="border-bottom: red;"><?= $det['kodesatuan']; ?></td>
                  <td style="border-bottom: red; font-size: 9px;"><?= $det['nama_kategori']; ?></td>
                  <td style="border-bottom: red;" class="text-right"><?= rupiah($sak,0); ?></td>
                  <td style="border-bottom: red;" class="text-right"><?= rupiah($sakkg,2); ?></td>
                </tr>
              <?php } endif; ?>
            </tbody>
          </table>
          <?= $hasilsak; ?>
        </div>
      </div>
    </div>
  </div>
</div>
        