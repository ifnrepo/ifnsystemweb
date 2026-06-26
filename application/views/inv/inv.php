<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          <?php if (isset($repbeac) && $repbeac == 1) { ?>
            IT Inventory <?= $this->session->userdata('currdept'); ?> - <?= datadepartemen($this->session->userdata('currdept'), 'departemen'); ?>
          <?php } else { ?>
            Inventory Barang <?= $this->session->userdata('currdept'); ?> - <?= datadepartemen($this->session->userdata('currdept'), 'departemen'); ?>
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
<div class="page-body mt-0">
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
              <select class="form-control form-sm font-kecil mr-1 bg-primary text-white hilang" id="exdo" name="exdo" style="width: 22% !important">
                <option value="all">All</option>
                <option value="EXPORT" <?php if($this->session->userdata('dataexdo')=='EXPORT'){ echo "selected"; } ?>>Export</option>
                <option value="DOMESTIC" <?php if($this->session->userdata('dataexdo')=='DOMESTIC'){ echo "selected"; } ?>>Domestic</option>
              </select>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-1 text-blue" id="tglawal" name="tglawal" style="width: 95px;" value="<?= $tglawal ?>">
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2 tglpilih" id="tglakhir" name="tglakhir" style="width: 95px;" value="<?= $tglakhir ?>">
              <a href="#" class="btn btn-success btn-sm font-bold" id="updateinv"><i class="fa fa-refresh"></i><span class="ml-1 font-kecil">UPDATE</span></a>
            </div>
            <div class="col-sm-5 d-flex flex-row-reverse" style="text-align: right;">
              <!-- <a href="<?= base_url('inv/cetakpdf'); ?>" target="_blank" class="btn btn-danger btn-sm font-bold" id="topdf"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export PDF</span></a> -->
              <?php $aktiv = (int) $req_inv > 0 ? '' : 'disabled'; ?>
              <?php 
                $aktivsavesaw = 'disabled';
                if($ifndln != 'all'){
                  $aktivsavesaw = 'disabled';
                }else if($tglakhir != lastdate2($tglakhir)){
                  $aktivsavesaw = 'disabled';
                }else{
                  $aktivsavesaw = '';
                }
              ?>
              <a href="#" data-href="<?= base_url().'inv/cekstokdept'; ?>" class="btn btn-warning btn-sm btn-flat mr-1" id="cekstokdept" data-bs-toggle='modal' data-bs-target='#modal-info' data-tombol='Ya' data-message='Refresh data Stok Departemen berdasarkan Inventory'><span class="line-11 font-11 text-black">Refresh<br>Stok Dept</span></a>
              <a href="<?= base_url() . 'inv/toexcel'; ?>" class="btn btn-success btn-sm font-bold mr-1" id="toexcel"><i class="fa fa-file-pdf-o"></i><span class="ml-1 line-11 font-11">Export<br>Excel</span></a>
              <a href="#" data-href="<?= base_url().'inv/savesaw'; ?>" class="btn btn-cyan btn-sm btn-flat mr-1 <?= $aktivsavesaw ?> <?php if($this->session->userdata('sess_ceksaw')==0){ echo "hilang"; } ?>" id="simpansaw" data-bs-toggle='modal' data-bs-target='#modal-info' data-tombol='Ya' data-message='Akan menyimpan data SAK to SAW <br> data tidak bisa dirubah'><i class="fa fa-save"></i><span class="ml-2 line-11 font-11">Save to<br>SAW</span></a>
              <a href="#" data-href="<?= base_url().'inv/simpandatainv'; ?>" class="btn btn-info btn-sm btn-flat mr-1 <?= $aktiv ?>" id="simpaninv" data-bs-toggle='modal' data-bs-target='#modal-info' data-tombol='Ya' data-message='Akan menyimpan data ke Pricing Inventory'><i class="fa fa-save"></i><span class="ml-2 line-11 font-11">Save Pricing <br>Inventory</span></a>
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3">
                  <div class="row <?php if($this->session->userdata('currdept')!='GF'){ echo "hilang"; } ?>" id="div-exdo">
                    <label class="col-3 col-form-label font-kecil font-bold required" style="height: 28px !important; padding-top:2px;color: black !important;">Buyer</label>
                    <div class="col mb-1">
                      <select name="idbuyer" id="idbuyer" class="form-control form-select form-sm font-kecil" style="height: 28px !important; padding-top:2px;color: black !important;">
                        <option value="all">All</option>
                        <?php foreach($buyer->result_array() as $buy): $danger = $buy['id_buyer']==0 ? "text-danger font-bold" : ""; $port = strtoupper($buy['exdo'])=='EXPORT' ? ' - '.$buy['port'] : ''; ?>
                          <option value="<?= $buy['id_buyer'] ?>" class="<?= $danger ?>" <?php if($this->session->userdata('idbuyer')==$buy['id_buyer']){ echo "selected"; } ?>><?= $buy['nama'].$port ?></option>
                        <?php endforeach;  ?>
                      </select>
                    </div>
                  </div>
                  <div class="row <?php if($this->session->userdata('currdept')!='GP'){ echo "hilang"; } ?>" id="div-exnet">
                    <label class="col-3 col-form-label font-kecil font-bold required" style="height: 28px !important; padding-top:2px;color: black !important;">Exnet</label>
                    <div class="col mb-1">
                      <select name="idexnet" id="idexnet" class="form-control form-select form-sm font-kecil" style="height: 28px !important; padding-top:2px;color: black !important;">
                        <option value="all">All</option>
                        <option value="1" <?php if($this->session->userdata('idexnet')=='1'){ echo "selected"; } ?>>Ya</option>
                        <option value="0" <?php if($this->session->userdata('idexnet')=='0'){ echo "selected"; } ?>>Tidak</option>
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
                        <option value="0" <?php if($this->session->userdata('idstok')=='0'){ echo "selected"; } ?>>Non Grade</option>
                        <option value="1" <?php if($this->session->userdata('idstok')=='1'){ echo "selected"; } ?>>Grade A</option>
                        <option value="2" <?php if($this->session->userdata('idstok')=='2'){ echo "selected"; } ?>>Grade B</option>
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
                        <option value="">Semua Kategori</option>
                        <?php if ($kat != null) : foreach ($kat->result_array() as $kate) {
                            $pakai = $kate['id_kategori'] != null ? $kate['id_kategori'] : $kate['nama_kategori'];
                            $selek = $this->session->userdata('filterkat') == $pakai ? 'selected' : '';
                        ?>
                            <option value="<?= $pakai; ?>" <?= $selek; ?>><?= $kate['nama_kategori']; ?></option>
                        <?php }
                        endif ?>
                      </select>
                    </div>
                    <label class="form-check mt-1 mb-1 bg-danger-lt">
                      <input class="form-check-input" type="checkbox" id="dataneh" <?php if($this->session->userdata('dataneh')=='1'){ echo "checked"; } ?>>
                      <span class="form-check-label font-bold">View Data Aneh</span>
                    </label>
                    <label class="form-check mt-1 mb-1 bg-danger-lt" id="cekaneh">
                      <input class="form-check-input" type="checkbox" id="opaneh" <?php if($this->session->userdata('opaneh')=='1'){ echo "checked"; } ?>>
                      <span class="form-check-label font-bold">S-O tidak sesuai</span>
                    </label>
                  <select class="form-control form-select font-kecil font-bold bg-cyan-lt hilang" id="nomorbcnya" style="height: 25px !important; padding-top:2px;color: black !important;">
                    <option value="X">Pilih BC</option>
                  </select>   
                  <!-- Start      -->
                  <label class="form-check mt-1 mb-3 bg-red-lt hilang">
                    <input class="form-check-input" type="checkbox" id="viewinv">
                    <span class="form-check-label font-bold">Tampilkan Barang No Inv</span>
                  </label>
                  <select class="form-control form-select font-kecil font-bold bg-yellow-lt <?php if(!in_array($this->session->userdata('currdept'),daftardeptsubkon())){echo "hilang"; } ?>" id="filtnomorbc" style="height: 25px !important; padding-top:2px;color: black !important;">
                    <option value="all">Semua - Nomor BC</option>
                    <?php if(!empty($nombc)){foreach($nombc->result_array() as $nobc): ?>
                      <option value="<?= $nobc['nomor_bc'] ?>" <?php if($this->session->userdata('nombc') == $nobc['nomor_bc']){ echo  'selected'; } ?>><?= $nobc['nomor_bc'] ?></option>
                    <?php endforeach;} ?>
                  </select>
                   <!-- End  -->
                    <hr class="small m-1">
                    <input type="text" id="paramload" class="hilang" value="">
                    <div class="text-black font-bold">Jumlah Rec : <span id="jumlahrekod" style="font-weight: normal;"><?= rupiah($jumlahrek,0) ?></span></div>
                </div>
                <div class="col-6 ">
                  <label class="bg-red-lt my-0 py-1 px-2 font-bold w-100"><span class="text-black">Rekap Data</span></label>
                  <table class="table table-bordered m-0">
                    <thead class="bg-primary-lt">
                      <tr>
                        <th class="text-center text-black">Unit</th>
                        <th class="text-center text-black">S.Awal</th>
                        <th class="text-center text-black">IN</th>
                        <th class="text-center text-black">OUT</th>
                        <th class="text-center text-black">ADJ</th>
                        <th class="text-center text-black">S.Akhir</th>
                        <th class="text-center text-black">SO</th>
                      </tr>
                    </thead>
                    <tbody class="table-tbody">
                      <tr class="p-0">
                        <td class="font-bold">PCS</td>
                        <td class="text-right" id="awalpcs">Loading..</td>
                        <td class="text-right" id="inpcs">Loading..</td>
                        <td class="text-right" id="outpcs">Loading..</td>
                        <td class="text-right" id="adjpcs">Loading..</td>
                        <td class="text-right" id="jumlahpcs">Loading..</td>
                        <td class="text-right text-cyan" id="sopcs">Loading..</td>
                      </tr>
                      <tr>
                        <td class="font-bold">KGS</td>
                        <td class="text-right" id="awalkgs">Loading..</td>
                        <td class="text-right" id="inkgs">Loading..</td>
                        <td class="text-right" id="outkgs">Loading..</td>
                        <td class="text-right" id="adjkgs">Loading..</td>
                        <td class="text-right" id="jumlahkgs">Loading..</td>
                        <td class="text-right text-cyan" id="sokgs">Loading..</td>
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
                    <textarea class="form form-control p-2 m-0 font-kecil" id='textcari' style="text-transform: uppercase;"><?= $this->session->userdata('cari-spek'); ?></textarea>
                    </div>
                    <div class="d-flex justify-content-between">
                      <button type="button" id="buttoncariinv" class="btn btn-sm btn-success btn-flat w-100 mt-1">Cari</button>
                      <button type="button" id="buttonresetinv" class="btn btn-sm btn-danger btn-flat w-25 mt-1">Reset</button>
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
          <?php $cektglopname = $getopname['tgl']=='' ? '' : tglmysql($getopname['tgl']); ?>
          <input type="text" name="tglopname" id="tglopname" value="<?= $cektglopname ?>" class="hilang">
          <div class="my-1 row">
            <div class="col-sm-1">
              <div class="row font-kecil">
                <!-- <label class="col-6 col-form-label text-center">Record Per Page</label> -->
                <div class="col">
                  <select class="form-select font-kecil btn-flat" id="perpageinv">
                    <option value="15" <?php if($this->session->userdata('perpage-rekapinv')==15){ echo "selected"; } ?>>15</option>
                    <option value="25" <?php if($this->session->userdata('perpage-rekapinv')==25){ echo "selected"; } ?>>25</option>
                    <option value="50" <?php if($this->session->userdata('perpage-rekapinv')==50){ echo "selected"; } ?>>50</option>
                    <option value="75" <?php if($this->session->userdata('perpage-rekapinv')==75){ echo "selected"; } ?>>75</option>
                    <option value="100" <?php if($this->session->userdata('perpage-rekapinv')==100){ echo "selected"; } ?>>100</option>
                  </select>
                </div>
              </div>
            </div>
          </div>
          <table id="tabelnya" class="table table-hover table-bordered cell-border mt-1" style="width: 100% !important; border-collapse: collapse;"> <!-- table order-column table-hover table-bordered cell-border -->
            <thead>
              <tr>
                <!-- <th>Tgl</th> -->
                <th>SKU/Spesifikasi</th>
                <th class="line-11">Nomor IB<br>Insno</th>
                <th>Nobale</th>
                <th>Satuan</th>
                <th>BC</th>
                <th>Stok GD</th>
                <th>Exnet</th>
                <th>Qty</th>
                <th>Kgs</th>
                <th id="headopname" class="line-11">Opname<br>31-12-2025</th>
                <th>Stat</th>
                <th>Verified</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important; width: 100% !important;">
                <?php $no=0; foreach($data->result_array() as $dt): $no++; ?>
                <?php 
                  $sku = trim($dt['po'])=='' ? $dt['kode'] : viewsku($dt['po'],$dt['item'],$dt['dis']);
                  $spek = trim($dt['po'])=='' ? $dt['nama_barang'] : $dt['spek'];
                  $ide = "OME-".rawurlencode(gantislash2(trim($dt['po']))).'-'.rawurlencode(gantislash2(trim($dt['item']))).'-'.$dt['dis'].'-'.$dt['id_barang'].'-'.rawurlencode(gantislash2(trim($dt['nobontr']))).'-'.rawurlencode(gantislash2(trim($dt['insno']))).'-'.rawurlencode(gantislash2(trim($dt['nobale']))).'-'.rawurlencode(trim($dt['nomor_bc'])).'-'.rawurlencode($dt['stok']).'-'.$dt['exnet'];
                 ?>
                  <tr>
                    <td class="line-11"><span class="text-pink font-11"><?= $sku ?></span><br><a href="<?= base_url().'inv/viewdetail/'.$ide ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View Detail" title="View Detail"><?= $spek ?></a></td>
                    <td class="line-11 font-11"><span><?= $dt['nobontr'] ?></span><br><span><?= $dt['insno'] ?></span></td>
                    <td class="text-center"><?= $dt['nobale'] ?></td>
                    <td class="text-center"><?= $dt['kodesatuan'] ?></td>
                    <td><span class="font-kecil"><?= $dt['nomor_bc'] ?></span></td>
                    <?php $stok = $dt['stok']==1 ? 'A' : ($dt['stok']==2 ? 'B' : ''); ?>
                    <td class="text-center"><?= $stok ?></td>
                    <?php $exnet = $dt['exnet']==1 ? '<span class="text-teal">Y</span>' : ""; ?>
                    <td class="text-center"><?= $exnet ?></td>
                    <td class="text-right"><?= rupiah($dt['sumpcs'],0) ?></td>
                    <td class="text-right"><?= rupiah($dt['sumkgs'],2) ?></td>
                    <td class="text-right line-11"><span class="text-pink font-11"><?= rupiah($dt['pcs_taking'],0) ?></span><br><span><?= rupiah($dt['kgs_taking'],2) ?></span></td>
                    <?php 
                        if( $cektglopname!=''){
                          $xpcs = $dt['sumpcs']-$dt['pcs_taking'];
                          $xkgs = $dt['sumkgs']-$dt['kgs_taking'];
                          if($xpcs != 0 && $xkgs != 0){
                            $hasil = '<span class="text-red">TIDAK<br>SESUAI</span>';
                          }elseif($xpcs == 0 && $xkgs != 0){
                            $hasil = '<span class="text-pink">SELISIH<br>BERAT</span>';
                          }elseif($xpcs != 0 && $xkgs == 0){
                            $hasil = '<span class="text-pink">SELISIH<br>QTY</span>';
                          }else{
                            $hasil = '<span class="text-green">SESUAI</span>';
                          }
                        }else{
                          $hasil = '...';
                        }
                     ?>
                    <td class="text-center font-kecil line-11"><?= $hasil ?></td>
                    <?php 
                      if($dt['user_verif']==0){
                        $btn = '<a href="'.base_url().'inv/confirmverifikasidata/'.$dt['idu'].'" class="btn btn-success btn-sm font-bold" data-bs-toggle="modal" data-bs-target="#veriftask" data-tombol="Ya" data-message="Akan memverifikasi data" title="Verifikasi Saldo" style="padding: 2px 3px !important">Verify</a>';
                      }else{
                        $btn = '<a href="#" data-bs-toggle="modal" data-bs-target="#canceltask" data-tombol="Ya" data-message="Akan membatalkan verifikasi data" style="padding: 2px 3px !important" id="verifrek"'.$dt['idu'].'" rel="'.$dt['idu'].'" title="'.$dt['idu'].'">Verified :'.datauser($dt['user_verif'],'username').'<br><span class="font-10">'.$dt['tgl_verif'].'</span></a>';
                      }
                    ?>
                    <td class="text-center line-11" id="row<?= $dt['idu'] ?>"><?= $btn ?></td>
                  </tr>
                <?php endforeach; ?>
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
        <input type="text" class="hilang" id="sawalpcs" value="<?= isset($dt['sawalpcs']) ? rupiah($dt['sawalpcs'],0) : 0; ?>" >
        <input type="text" class="hilang" id="sawalkgs" value="<?= isset($dt['sawalkgs']) ? rupiah($dt['sawalkgs'],2) : 0; ?>" >
        <input type="text" class="hilang" id="totalinpcs" value="<?= isset($dt['totalinpcs']) ? rupiah($dt['totalinpcs'],0) : 0; ?>" >
        <input type="text" class="hilang" id="totalinkgs" value="<?= isset($dt['totalinkgs']) ? rupiah($dt['totalinkgs'],2) : 0; ?>" >
        <input type="text" class="hilang" id="totaloutpcs" value="<?= isset($dt['totaloutpcs']) ? rupiah($dt['totaloutpcs'],0) : 0; ?>" >
        <input type="text" class="hilang" id="totaloutkgs" value="<?= isset($dt['totaloutkgs']) ? rupiah($dt['totaloutkgs'],2) : 0; ?>" >
        <input type="text" class="hilang" id="totaladjpcs" value="<?= isset($dt['totaladjpcs']) ? rupiah($dt['totaladjpcs'],0) : 0; ?>" >
        <input type="text" class="hilang" id="totaladjkgs" value="<?= isset($dt['totaladjkgs']) ? rupiah($dt['totaladjkgs'],2) : 0; ?>" >
        <input type="text" class="hilang" id="totalsopcs" value="<?= isset($dt['totalsopcs']) ? rupiah($dt['totalsopcs'],0) : 0; ?>" >
        <input type="text" class="hilang" id="totalsokgs" value="<?= isset($dt['totalsokgs']) ? rupiah($dt['totalsokgs'],2) : 0; ?>" >
        <input type="text" class="hilang" id="totalpcs" value="<?= isset($dt['totalpcs']) ? rupiah($dt['totalpcs'],0) : 0; ?>" >
        <input type="text" class="hilang" id="totalkgs" value="<?= isset($dt['totalkgs']) ? rupiah($dt['totalkgs'],2) : 0; ?>" >
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