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
            <div class="col-sm-7 d-flex">
              <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white" id="ifndln" name="ifndln" style="width: 15% !important">
                <option value="all">All</option>
                <option value="1" <?php if ($ifndln == '1') {
                                      echo "selected";
                                    } ?>>DLN</option>
                <option value="0" <?php if ($ifndln == '0') {
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
              <input type="text" class="form-control form-sm font-kecil font-bold mr-1 text-blue" id="tglawal" name="tglawal" style="width: 95px;" value="<?= $tglawal ?>">
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2 tglpilih" id="tglakhir" name="tglakhir" style="width: 95px;" value="<?= $tglakhir ?>">
              <a href="#" class="btn btn-success btn-sm font-bold" id="updateinv"><i class="fa fa-refresh"></i><span class="ml-1 font-kecil">UPDATE</span></a>
            </div>
            <div class="col-sm-5 d-flex flex-row-reverse" style="text-align: right;">
              <!-- <a href="<?= base_url('inv/cetakpdf'); ?>" target="_blank" class="btn btn-danger btn-sm font-bold" id="topdf"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export PDF</span></a> -->
              <a href="<?= base_url() . 'inv/toexcel'; ?>" class="btn btn-success btn-sm font-bold mr-1" id="toexcel"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export Excel</span></a>
              <a href="#" data-href="<?= base_url().'inv/simpandatainv'; ?>" class="btn btn-info btn-sm btn-flat mr-1 disabled" id="simpaninv" data-bs-toggle='modal' data-bs-target='#modal-info' data-tombol='Ya' data-message='Akan menyimpan data ke Pricing Inventory'><i class="fa fa-save"></i><span class="ml-2 line-11 font-11">Save Pricing <br>Inventory</span></a>
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3">
                  <div class="row <?php if($this->session->userdata('currdept')!='GF'){ echo "hilang"; } ?>" id="div-exdo">
                    <label class="col-3 col-form-label font-kecil font-bold required" style="height: 28px !important; padding-top:2px;color: black !important;">EXDO</label>
                    <div class="col mb-1">
                      <select name="exdonya" id="exdonya" class="form-control form-select form-sm font-kecil" style="height: 28px !important; padding-top:2px;color: black !important;">
                        <option value="all">All</option>
                        <option value="EXPORT" <?php if($this->session->userdata('exdonya')=='EXPORT'){ echo "selected"; } ?>>EXPORT</option>
                        <option value="DOMESTIC" <?php if($this->session->userdata('exdonya')=='DOMESTIC'){ echo "selected"; } ?>>DOMESTIC</option>
                      </select>
                      <!-- <input type="email" class="form-control form-sm font-kecil" aria-describedby="emailHelp" placeholder="Enter email"> -->
                      <!-- <small class="form-hint">We'll never share your email with anyone else.</small> -->
                    </div>
                  </div>
                  <div class="row <?php if($this->session->userdata('currdept')!='GF'){ echo "hilang"; } ?>" id="div-exdo">
                    <label class="col-3 col-form-label font-kecil font-bold required" style="height: 28px !important; padding-top:2px;color: black !important;">Buyer</label>
                    <div class="col mb-1">
                      <select name="idbuyer" id="idbuyer" class="form-control form-select form-sm font-kecil" style="height: 28px !important; padding-top:2px;color: black !important;">
                        <option value="all">All</option>
                        <?php foreach($buyer->result_array() as $buy): $danger = $buy['id_buyer']==0 ? "text-danger font-bold" : ""; $port = strtoupper($buy['exdo'])=='EXPORT' ? ' - '.$buy['port'] : ''; ?>
                          <option value="<?= $buy['id_buyer'] ?>" class="<?= $danger ?>"><?= $buy['nama'].$port ?></option>
                        <?php endforeach;  ?>
                      </select>
                      <!-- <input type="email" class="form-control form-sm font-kecil" aria-describedby="emailHelp" placeholder="Enter email"> -->
                      <!-- <small class="form-hint">We'll never share your email with anyone else.</small> -->
                    </div>
                  </div>
                  <div class="row <?php if($this->session->userdata('currdept')!='GP'){ echo "hilang"; } ?>" id="div-exnet">
                    <label class="col-3 col-form-label font-kecil font-bold required" style="height: 28px !important; padding-top:2px;color: black !important;">Exnet</label>
                    <div class="col mb-1">
                      <select name="idexnet" id="idexnet" class="form-control form-select form-sm font-kecil" style="height: 28px !important; padding-top:2px;color: black !important;">
                        <option value="all">All</option>
                        <option value="1">Ya</option>
                        <option value="0">Tidak</option>
                      </select>
                      <!-- <input type="email" class="form-control form-sm font-kecil" aria-describedby="emailHelp" placeholder="Enter email"> -->
                      <!-- <small class="form-hint">We'll never share your email with anyone else.</small> -->
                    </div>
                  </div>
                  <div class="row <?php if($this->session->userdata('currdept')!='GF'){ echo "hilang"; } ?>" id="div-exdo">
                    <label class="col-3 col-form-label font-kecil font-bold required" style="height: 28px !important; padding-top:2px;color: black !important;">Stok GD</label>
                    <div class="col mb-1">
                      <select name="idstok" id="idstok" class="form-control form-select form-sm font-kecil" style="height: 28px !important; padding-top:2px;color: black !important;">
                        <option value="all">All</option>
                        <option value="0">Non Grade</option>
                        <option value="1">Grade A</option>
                        <option value="2">Grade B</option>
                      </select>
                      <!-- <input type="email" class="form-control form-sm font-kecil" aria-describedby="emailHelp" placeholder="Enter email"> -->
                      <!-- <small class="form-hint">We'll never share your email with anyone else.</small> -->
                    </div>
                  </div>
                  <hr class="my-0 mx-1">
                  <h4 class="mb-1 font-kecil">Kategori Barang</h4>
                  <span class="font-kecil">
                    <div class="font-kecil" style="margin-bottom: 2px !important;">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="katbar" name="katbar">
                        <option value="all">Semua Kategori</option>
                        <?php if ($kat != null) : foreach ($kat->result_array() as $kate) {
                            $pakai = $kate['id_kategori'] != null ? $kate['id_kategori'] : $kate['nama_kategori'];
                            $selek = $this->session->userdata('filterkat') == $pakai ? 'selected' : '';
                        ?>
                            <option value="<?= $pakai; ?>" <?= $selek; ?>><?= $kate['nama_kategori']; ?></option>
                        <?php }
                        endif ?>
                      </select>
                    </div>
                    <label class="form-check mt-1 mb-1 bg-danger-lt hilang">
                      <input class="form-check-input" type="checkbox" id="dataneh">
                      <span class="form-check-label font-bold">View Data Aneh</span>
                    </label>
                  <select class="form-control form-select font-kecil font-bold bg-cyan-lt hilang" id="nomorbcnya" style="height: 25px !important; padding-top:2px;color: black !important;">
                    <option value="X">Pilih BC</option>
                  </select>   
                  <!-- Start      -->
                  
                  <label class="form-check mt-1 mb-3 bg-red-lt hilang">
                    <input class="form-check-input" type="checkbox" id="viewinv">
                    <span class="form-check-label font-bold">Tampilkan Barang No Inv</span>
                  </label>
                  <select class="form-control form-select font-kecil font-bold bg-yellow-lt hilang" id="kontrakbcnya" style="height: 25px !important; padding-top:2px;color: black !important;">
                    <option value="X">Semua - Kontrak BC</option>
                  </select>
                   <!-- End  -->
                    <hr class="small m-1">
                    <input type="text" id="paramload" class="hilang" value="">
                    <div class="text-black font-bold">Jumlah Rec : <span id="jumlahrekod" style="font-weight: normal;">Loading ..</span></div>
                </div>
                <div class="col-6 ">
                  <label class="bg-red-lt my-0 py-1 px-2 font-bold w-100"><span class="text-black">Rekap Data</span></label>
                  <table class="table table-bordered m-0">
                    <thead class="bg-primary-lt">
                      <tr>
                        <th class="text-center text-black">Unit</th>
                        <th class="text-center text-black">S.Awal</th>
                        <th class="text-center text-black">Pemasukan</th>
                        <th class="text-center text-black">Pengeluaran</th>
                        <th class="text-center text-black">Adjustment</th>
                        <th class="text-center text-black">S.Akhir</th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      <tr class="p-0">
                        <td class="font-bold">PCS</td>
                        <td class="text-right" id="sawalpcs">Loading..</td>
                        <td class="text-right" id="inpcs">Loading..</td>
                        <td class="text-right" id="outpcs">Loading..</td>
                        <td class="text-right" id="adjpcs">Loading..</td>
                        <td class="text-right" id="jumlahpcs">Loading..</td>
                      </tr>
                      <tr>
                        <td class="font-bold">KGS</td>
                        <td class="text-right" id="sawalkgs">Loading..</td>
                        <td class="text-right" id="inkgs">Loading..</td>
                        <td class="text-right" id="outkgs">Loading..</td>
                        <td class="text-right" id="adjkgs">Loading..</td>
                        <td class="text-right" id="jumlahkgs">Loading..</td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <div class="col-3">
                  <div class="mb-0">
                    <label class="font-bold">
                      Cari Barang / SKU :
                    </label>
                  </div>
                  <div class="">
                    <div class="" >
                    <textarea class="form form-control p-2 m-0 font-kecil" id='textcari' style="text-transform: uppercase;"></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                      <button type="button" id="buttoncari" class="btn btn-sm btn-success btn-flat w-100 mt-1">Cari</button>
                      <button type="button" id="buttonreset" class="btn btn-sm btn-danger btn-flat w-25 mt-1">Reset</button>
                    </div>
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
        <div>
          <table id="tabelnya" class="table table-hover table-bordered cell-border" style="width: 100% !important; border-collapse: collapse;"> <!-- table order-column table-hover table-bordered cell-border -->
            <thead>
              <tr>
                <!-- <th>Tgl</th> -->
                <th>SKU/Spesifikasi</th>
                <th>Nomor IB<br>Insno</th>
                <th>Satuan</th>
                <th>BC</th>
                <th>Nobale</th>
                <th>Stok GD</th>
                <th>Exnet</th>
                <th>Qty</th>
                <th>Kgs</th>
                <th>Opname</th>
                <th>Verified</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important; width: 100% !important;">
            
            </tbody>
          </table>
        </div>
        <input type="text" id="jumlahrek" class="hilang" value="0">
        <input type="text" id="jumlahpc" class="hilang" value="0">
        <input type="text" id="jumlahkg" class="hilang" value="0">
        <div class="card card-active hilang" style="clear:both;">
          <div class="card-body p-2 font-kecil">
            <div class="row">
              <div class="col-3">
                <h4 class="mb-0 font-kecil font-bold">Jumlah Rec</h4>
                <span class="font-kecil">
                  <?= rupiah(0, 0); ?>
                </span>
              </div>
              <div class="col-3 ">
                <h4 class="mb-0 font-kecil font-bold">Pcs</h4>
                <span class="font-kecil">
                  <?= rupiah(0, 2); ?>
                </span>
              </div>
              <div class="col-3">
                <h4 class="mb-0 font-kecil font-bold">Kgs</h4>
                <span class="font-kecil">
                  <?= rupiah(0, 2); ?>
                </span>
              </div>
              <div class="col-3" style="line-height: 5px !important;">
                <?php if ($this->session->userdata('invharga')) : ?>
                  <h4 class="mb-0 font-kecil font-bold">Grand Total</h4>
                  <span class="font-kecil text-green font-bold">
                    Rp. <?= rupiah(0, 2); ?>
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