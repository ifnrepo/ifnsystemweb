<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <?php if (isset($repbeac) && $repbeac == 1) { ?>
            IT Inventory <?= $this->session->userdata('currdept'); ?> - <?= datadepartemen($this->session->userdata('currdept'), 'departemen'); ?>
          <?php } else { ?>
            Inventory Barang <?= $this->session->userdata('currdept'); ?>
          <?php } ?>
          <input type="hidden" id="bukavalid" value="<?= datauser($this->session->userdata('id'), 'cekbatalstok'); ?>">
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url(); ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
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
              <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white" id="ifndln" name="ifndln" style="width: 15% !important">
                <option value="X">All</option>
                <option value="dln" <?php if ($ifndln == 'dln') {
                                      echo "selected";
                                    } ?>>DLN</option>
                <option value="ifn" <?php if ($ifndln == 'ifn') {
                                      echo "selected";
                                    } ?>>IFN</option>
              </select>

              <?php $disabel = isset($repbeac) && $repbeac == 1 ? 'disabled' : ''; ?>
              <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white" id="currdept" name="currdept" <?= $disabel; ?>>
                <?php
                // Mendapatkan nilai 'deptsekarang', jika null nilai default jadi it
                $selek = $this->session->userdata('currdept') ?? 'IT';
                foreach ($hakdep as $hak) :
                  $selected = ($selek == $hak['dept_id']) ? "selected" : "";
                ?>
                  <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?= $selected ?>>
                    <?= $hak['departemen']; ?>
                  </option>
                <?php endforeach; ?>
              </select>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-1" id="tglawal" name="tglawal" style="width: 95px;" value="<?= $tglawal ?>">
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2 hilang" id="tglakhir" name="tglakhir" style="width: 95px;" value="<?= $tglakhir ?>">
              <a href="#" class="btn btn-success btn-sm font-bold" id="updateinv"><i class="fa fa-refresh"></i><span class="ml-1 font-kecil">UPDATE</span></a>
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
              <a href="<?= base_url('inv/cetakpdf'); ?>" target="_blank" class="btn btn-danger btn-sm font-bold" id="topdf"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export PDF</span></a>
              <a href="<?= base_url() . 'inv/toexcel'; ?>" class="btn btn-success btn-sm font-bold mr-1" id="toexcel"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export Excel</span></a>
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3">
                  <h4 class="mb-1 font-kecil">Kategori Barang</h4>
                  <span class="font-kecil">
                    <div class="font-kecil" style="margin-bottom: 2px !important;">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="katbar" name="katbar">
                        <option value="X">Semua Kategori</option>
                        <?php if ($kat != null) : foreach ($kat->result_array() as $kate) {
                            $pakai = $kate['id_kategori'] != null ? $kate['id_kategori'] : $kate['name_kategori'];
                            $selek = $this->session->userdata('filterkat') == $pakai ? 'selected' : '';
                        ?>
                            <option value="<?= $pakai; ?>" <?= $selek; ?>><?= $kate['name_kategori']; ?></option>
                        <?php }
                        endif ?>
                      </select>
                    </div>
                  </span>
                  <?php $deptampil = ['GM', 'SP']; ?>
                  <select class="form-control form-select font-kecil font-bold bg-cyan-lt <?php if (!in_array($this->session->userdata('currdept'), $deptampil)) {
                                                                                            echo "hilang";
                                                                                          } ?>" id="nomorbcnya" style="height: 25px !important; padding-top:2px;color: black !important;">
                    <option value="X">Pilih BC</option>
                    <?php if ($kat != null) : foreach ($katbece->result_array() as $bece) { ?>
                        <?php
                        $isi = $bece['nomor_bc'] != null ? 'BC. ' . trim($bece['jns_bc']) . '- ' . $bece['nomor_bc'] . '(' . $bece['tgl_bc'] . ')' : 'Semua';
                        $selek = $this->session->userdata('nomorbcnya') == $bece['nomor_bc'] ? 'selected' : '';
                        ?>
                        <option value="<?= $bece['nomor_bc']; ?>" <?= $selek; ?>><?= $isi; ?></option>
                    <?php }
                    endif; ?>
                  </select>       
                </div>
                <div class="col-3 ">
                  <label class="form-check mt-1 mb-1 bg-teal-lt <?php if ($this->session->userdata('viewharga') != 1) {
                                                                  echo "hilang";
                                                                } ?>">
                    <input class="form-check-input" type="checkbox" id="viewharga" <?php if ($this->session->userdata('invharga') == 1) {
                                                                                      echo "checked";
                                                                                    } ?>>
                    <span class="form-check-label font-bold">Tampilkan Harga</span>
                  </label>
                  <label class="form-check mt-1 mb-3 bg-red-lt">
                    <input class="form-check-input" type="checkbox" id="viewinv" <?php if ($this->session->userdata('viewinv') == 1) {
                                                                                    echo "checked";
                                                                                  } ?>>
                    <span class="form-check-label font-bold">Tampilkan Barang No Inv</span>
                  </label>
                  <?php $deptampil = ['GM']; ?>
                  <select class="form-control form-select font-kecil font-bold bg-yellow-lt <?php if (!in_array($this->session->userdata('currdept'), $deptampil)) {
                                                                                            echo "hilang";
                                                                                          } ?>" id="kontrakbcnya" style="height: 25px !important; padding-top:2px;color: black !important;">
                    <option value="X">Semua - Kontrak BC</option>
                    <?php if ($kat != null && isset($kontbece)) : foreach ($kontbece->result_array() as $bece) { ?>
                        <?php
                        $isi = trim($bece['nomor_kont']) != '' ? $bece['nomor_kont'] . '(' . $bece['tgl_kont'] . ')' : 'Semua';
                        $value = trim($bece['nomor_kont']) != '' ? $bece['nomor_kont'] : 'X';
                        $selek = $this->session->userdata('kontrakbcnya') == $bece['nomor_kont'] ? 'selected' : '';
                        if($value != 'X'):
                        ?>
                        <option value="<?= $value; ?>" <?= $selek; ?>><?= $isi; ?></option>
                    <?php endif; }
                    endif; ?>
                  </select>
                </div>
                <div class="col-3 font-kecil">
                  <input type="text" id="paramload" class="hilang" value="">
                  <div class="text-blue font-bold mt-2 ">Jumlah Rec : <span id="jumlahrekod" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold">Jumlah Pcs : <span id="jumlahpcs" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold">Jumlah Kgs : <span id="jumlahkgs" style="font-weight: normal;">Loading ..</span></div>
                </div>
                <div class="col-3">
                  <div class="">
                    <label class="form-check form-check-inline mb-1">
                      <input class="form-check-input" type="radio" name="radios-inline" value="Cari Barang" <?php if ($kategoricari == 'Cari Barang') {
                                                                                                              echo "checked";
                                                                                                            } ?>>
                      <span class="form-check-label font-kecil">Barang</span>
                    </label>
                    <label class="form-check form-check-inline mb-1">
                      <input class="form-check-input" type="radio" name="radios-inline" value="Cari SKU" <?php if ($kategoricari == 'Cari SKU') {
                                                                                                            echo "checked";
                                                                                                          } ?>>
                      <span class="form-check-label font-kecil">SKU</span>
                    </label>
                  </div>
                  <div class="input-group mb-0">
                    <?php $textcari = $this->session->userdata('katcari') != null ? $this->session->userdata('katcari') : ''; ?>
                    <input type="text" class="form-control form-sm font-kecil" placeholder="Cari…" value="<?= $textcari; ?>" id="textcari" style="text-transform: uppercase; height: 38px;">
                    <button class="btn text-center font-kecil" type="button" id="buttoncari" style="height: 38px;">
                      Cari
                    </button>
                  </div>
                </div>
                <div class="col-2">
                  <h4 class="mb-1"></h4>
                </div>
              </div>
              <!-- <div class="hr m-1"></div> -->
            </div>
          </div>
        </div>
        <div class="mt-1">
          <table id="tabel" class="table order-column table-hover datatable6" style="width: 100% !important;">
            <thead>
              <tr>
                <!-- <th>Tgl</th> -->
                <th>Spesifikasi</th>
                <th>SKU</th>
                <th>Nomor IB</th>
                <th>Insno</th>
                <th>Satuan</th>
                <th>BC</th>
                <!-- <th>Output</th> -->
                <?php if ($this->session->userdata('currdept') == 'GF') : ?>
                  <th>Nobale</th>
                <?php endif; ?>
                <th>Qty</th>
                <th>Kgs</th>
                <?php if ($this->session->userdata('invharga') == 1) : ?>
                  <th>Harga</th>
                  <th>Total</th>
                <?php endif; ?>
                <th>Opname</th>
                <th>Verified</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php $hasilsak = 0;
              $cntbrg = 0;
              $jmpcs = 0;
              $jmkgs = 0;
              $grandtotal = 0;
              if ($data != null) : $brg = '';
                $sak = 0;
                $sakkg = 0;
                foreach ($data->result_array() as $det) {
                  $saldo = $det['pcs'];
                  $in = $det['pcsin'];
                  $out = $det['pcsout'];
                  $saldokg = $det['kgs'];
                  $inkg = $det['kgsin'];
                  $outkg = $det['kgsout'];
                  // if ($brg != $det['id_barang']) {
                  $brg = $det['id_barang'];
                  $sak = $saldo + $in - $out;
                  $sakkg = $saldokg + $inkg - $outkg;
                  // } else {
                  //   $sak += $saldo + $in - $out;
                  //   $sakkg = $saldokg + $inkg - $outkg;
                  // }
                  $bg = $sak >= 0 ? 'text-teal-green' : 'text-danger';
                  $hasilsak += $det['pcs'];
                  $cntbrg += 1;
                  $jmkgs += $sakkg;
                  $jmpcs += $sak;
                  $isi = 'OME-' . trim(encrypto($det['po'])) . '-' . trim(encrypto($det['item'])) . '-' . trim($det['dis']) . '-' . trim($det['id_barang']) . '-' . trim(encrypto($det['nobontr'])) . '-' . trim(encrypto($det['insno'])) . '-' . trim(encrypto($det['nobale'])) . '-';
                  // $isi = 'XXX';
                  $insno = $this->session->userdata('currdept') == 'GS' ? $det['insno'] : $det['insno'];
                  $nobontr = $this->session->userdata('currdept') == 'GS' ? $det['nobontr'] : $det['nobontr'];
                  // $spekbarang = trim($det['po']) != '' ? $det['spek'] : substr($det['nama_barang'], 0, 75);
                  $spekbarang = trim($det['po']) != '' ? spekpo($det['po'],$det['item'],$det['dis']) : substr($det['nama_barang'], 0, 75);
                  $pilihtampil = $sak == 0 ? $sakkg : $sak;
                  $totalharga = $pilihtampil * $det['harga'];
                  $grandtotal += $totalharga;
                  $cx = '';
                  if ($this->session->userdata('currdept') == 'GM' || $this->session->userdata('currdept') == 'GS') {
                    if ($det['kodesatuan'] == 'KGS') {
                      if ((float) $det['totkgs'] < (float) $det['safety_stock']) {
                        $cx = 'text-red';
                      }
                    } else {
                      if ((float) $det['totpcs'] < (float) $det['safety_stock']) {
                        $cx = 'text-red';
                      }
                    }
                  }
              ?>
                  <tr class="<?= $bg; ?><?= $cx; ?>">
                    <td style="border-bottom: red;"><a href="<?= base_url() . 'inv/viewdetail/' . $isi ?>" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' title='View Detail' id="namabarang" rel="<?= $det['id_barang']; ?>" rel2="<?= $det['nama_barang']; ?>" rel3="<?= $isi; ?>" style="text-decoration: none;" class="<?= $cx; ?>"><?= $spekbarang; ?></a></td>
                    <td style="border-bottom: red;"><?= viewsku(id: $det['kode'], po: $det['po'], no: $det['item'], dis: $det['dis']) ?></td>
                    <td style="border-bottom: red;"><?= $nobontr; ?></td>
                    <td style="border-bottom: red;"><?= $insno; ?></td>
                    <td style="border-bottom: red;"><?= $det['kodesatuan']; ?></td>
                    <td style="border-bottom: red;"><?= $det['nomor_bc']; ?></td>
                    <?php if ($this->session->userdata('currdept') == 'GF') : ?>
                      <td style="border-bottom: red;"><?= $det['nobale']; ?></td>
                    <?php endif; ?>
                    <!-- <td style="border-bottom: red;"></td> -->
                    <td style="border-bottom: red;" class="text-right"><?= rupiah($sak, 2); ?></td>
                    <td style="border-bottom: red;" class="text-right"><?= rupiah($sakkg, 4); ?></td>
                    <?php if ($this->session->userdata('invharga') == 1) : ?>
                      <td style="border-bottom: red;" class="text-right"><?= rupiah($det['harga'], 2); ?></td>
                      <td style="border-bottom: red;" class="text-right"><?= rupiah($totalharga, 2); ?></td>
                    <?php endif; ?>
                    <td style="border-bottom: red;" class="text-right"></td>
                    <td style="border-bottom: red;" class="text-center line-12" id="row<?= $det['idu'] ?>">
                      <?php if ($det['user_verif'] == 0) { ?>
                        <a href="<?= base_url() . 'inv/confirmverifikasidata/' . $det['idu']; ?>" class="btn btn-success btn-sm font-bold" data-bs-toggle="modal" data-bs-target="#veriftask" data-tombol="Ya" data-message="Akan memverifikasi data <br> <?= $det['nama_barang'] ?>" style="padding: 2px 3px !important" id="verifrek<?= $det['idu']; ?>" rel="<?= $det['idu']; ?>" title="<?= $det['idu']; ?>"><span>Verify</span></a>
                        <?php } else {
                        if (datauser($this->session->userdata('id'), 'cekbatalstok') == 1) {  ?>
                          <a href="<?= base_url() . 'inv/batalverifikasidata/' . $det['idu']; ?>" data-bs-toggle="modal" data-bs-target="#canceltask" data-tombol="Ya" data-message="Akan membatalkan verifikasi data <br> <?= $det['nama_barang'] ?>" style="padding: 2px 3px !important" id="verifrek<?= $det['idu']; ?>" rel="<?= $det['idu']; ?>" title="<?= $det['idu']; ?>">
                            verified : <?= substr(datauser($det['user_verif'], 'username'), 0, 9); ?><br>
                            <span class="font-10"><?= $det['tgl_verif']; ?></span>
                          </a>
                        <?php } else {  ?>
                          verified : <?= substr(datauser($det['user_verif'], 'username'), 0, 9); ?><br>
                          <span class="font-10"><?= $det['tgl_verif']; ?></span>
                      <?php }
                      } ?>
                    </td>
                  </tr>
              <?php }
              endif; ?>
            </tbody>
          </table>
        </div>
        <input type="text" id="jumlahrek" class="hilang" value="<?= $cntbrg; ?>">
        <input type="text" id="jumlahpc" class="hilang" value="<?= $jmpcs; ?>">
        <input type="text" id="jumlahkg" class="hilang" value="<?= $jmkgs; ?>">
        <div class="card card-active hilang" style="clear:both;">
          <div class="card-body p-2 font-kecil">
            <div class="row">
              <div class="col-3">
                <h4 class="mb-0 font-kecil font-bold">Jumlah Rec</h4>
                <span class="font-kecil">
                  <?= rupiah($cntbrg, 0); ?>
                </span>
              </div>
              <div class="col-3 ">
                <h4 class="mb-0 font-kecil font-bold">Pcs</h4>
                <span class="font-kecil">
                  <?= rupiah($jmpcs, 2); ?>
                </span>
              </div>
              <div class="col-3">
                <h4 class="mb-0 font-kecil font-bold">Kgs</h4>
                <span class="font-kecil">
                  <?= rupiah($jmkgs, 2); ?>
                </span>
              </div>
              <div class="col-3" style="line-height: 5px !important;">
                <?php if ($this->session->userdata('invharga')) : ?>
                  <h4 class="mb-0 font-kecil font-bold">Grand Total</h4>
                  <span class="font-kecil text-green font-bold">
                    Rp. <?= rupiah($grandtotal, 2); ?>
                  </span>
                <?php endif; ?>
              </div>
              <div class="col-2">
                <h4 class="mb-1"></h4>
              </div>
            </div>
            <!-- <div class="hr m-1"></div> -->
          </div>
        </div>
      </div>
    </div>
  </div>
</div>