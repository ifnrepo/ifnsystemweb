<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          DOK BC KELUAR
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
            <div class="col-sm-5 d-flex">
              <select class="form-control form-sm font-kecil font-bold mr-1 bg-teal text-white form-select" id="jns_bc" name="jns_bc">
                <!-- <option value="X">Pilih</option> -->
                <option value="Y" <?php if ($this->session->userdata('jnsbc') == 'Y') {
                                    echo "selected";
                                  } ?>>All</option>
                <option value="25" <?php if ($this->session->userdata('jnsbc') == '25') {
                                      echo "selected";
                                    } ?>>BC 2.5</option>
                <option value="261" <?php if ($this->session->userdata('jnsbc') == '261') {
                                      echo "selected";
                                    } ?>>BC 2.6.1</option>
                <option value="30" <?php if ($this->session->userdata('jnsbc') == '30') {
                                      echo "selected";
                                    } ?>>BC 3.0</option>
                <option value="41" <?php if ($this->session->userdata('jnsbc') == '41') {
                                      echo "selected";
                                    } ?>>BC 4.1</option>
              </select>
              <input type="text" class="form-control form-sm font-kecil font-bold mr-1 tglpilih" title="Tanggal Awal" id="tglawal" name="tglawal" style="width: 95px;" value="<?= $tglawal; ?>">
              <span class="mt-2 text-blue"> ~ </span>
              <input type="text" class="form-control form-sm font-kecil font-bold ml-1 mr-2 tglpilih" title="Tanggal Akhir" id="tglakhir" name="tglakhir" style="width: 95px;" value="<?= $tglakhir; ?>">
              <a href="#" class="btn btn-success btn-sm font-bold" id="updatebckeluar"><i class="fa fa-refresh"></i><span class="ml-1">UPDATE</span></a>
            </div>
            <div class="col-sm-7 d-flex flex-row-reverse" style="text-align: right;">
              <a href="<?= base_url('bckeluar/cetakpdf'); ?>" target="_blank" class="btn btn-danger btn-sm font-bold" id="topdf"><i class="fa fa-file-excel-o"></i><span class="ml-1">Export PDF</span></a>
              <a href="<?= base_url() . 'bckeluar/excel'; ?>" class="btn btn-success btn-sm font-bold mr-1" id="toexcel"><i class="fa fa-file-pdf-o"></i><span class="ml-1">Export Excel</span></a>
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-3">
                  <div class="text-blue font-bold mt-2 ">Jumlah Dok : <span id="jumlahrekod" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold">Jumlah Qty : <span id="jumlahpcs" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold">Jumlah Kgs : <span id="jumlahkgs" style="font-weight: normal;">Loading ..</span></div>
                </div>
                <div class="col-3 ">
                  <div class="text-blue font-bold mt-2 ">Jumlah IDR : <span id="jumlahidr" style="font-weight: normal;">Loading ..</span></div>
                  <div class="text-blue font-bold">Jumlah USD : <span id="jumlahusd" style="font-weight: normal;">Loading ..</span></div>
                </div>
                <div class="col-3 font-kecil">

                </div>
                <div class="col-3">
                  <div class="">
                    <label class="form-check form-check-inline mb-1">
                      <input class="form-check-input" type="radio" name="radios-inline" value="Cari Barang" checked>
                      <span class="form-check-label font-kecil">No Pendaftaran</span>
                    </label>
                  </div>
                  <div class="input-group mb-0">
                    <?php $textcari = $this->session->userdata('nopen') != null ? $this->session->userdata('nopen') : ''; ?>
                    <input type="text" class="form-control form-sm font-kecil" placeholder="Cari Nomor Pendaftaran …" value="<?= $textcari; ?>" id="textcari" style="text-transform: uppercase; height: 38px;">
                    <button class="btn text-center font-kecil" type="button" id="buttoncaribckeluar" style="height: 38px;">
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
        <div>
          <table id="tabel" class="table order-column table-hover datatable7 mt-1" style="width: 100% !important;">
            <thead>
              <tr class="text-left">
                <!-- <th>Tgl</th> -->
                <th class="text-center">Dok</th>
                <th class="text-left">No Pendaftaran / Tgl</th>
                <th class="text-left">No Dokumen/ Tgl</th>
                <th class="text-left">Customer</th>
                <th class="text-left">Info</th>
                <th class="text-left">Nomor/Tgl Respon</th>
                <th class="text-left">Nilai IDR</th>
                <th class="text-left">Nilai USD</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php $cntbrg = 0;
              $jmpcs = 0;
              $jmkgs = 0;
              $jmidr = 0;
              $jmusd = 0;
              $no = 0;
              if ($data != null) : foreach ($data->result_array() as $detail) {


                  $kurs_data = getkurssekarang($detail['tgl_aju'])->row();
                  $kurs_usd = (empty($detail['kurs_usd']) || $detail['kurs_usd'] == 0)
                    ? (($kurs_data && isset($kurs_data->usd)) ? $kurs_data->usd : 0)
                    : $detail['kurs_usd'];

                  $kurs_yen = (empty($detail['kurs_yen']) || $detail['kurs_yen'] == 0)
                    ? (($kurs_data && isset($kurs_data->jpy)) ? $kurs_data->jpy : 0)
                    : $detail['kurs_yen'];


                  $pengali = $detail['mtuang'] == 2 ? $kurs_usd : ($detail['mtuang'] == 3 ? $kurs_yen : 1);
                  $kondisi_idr = ($detail['jns_bc'] == 25 || $detail['jns_bc'] == 41)
                    ? $pengali * $detail['nilai_serah']
                    : $pengali * $detail['nilai_pab'];


                  $nilai = ($detail['jns_bc'] == 25 || $detail['jns_bc'] == 41)
                    ? $detail['nilai_serah']
                    : $detail['nilai_pab'];

                  $xpengali = $detail['mtuang'] == 2
                    ? $nilai
                    : ($detail['mtuang'] == 3
                      ? ($nilai * $kurs_yen) / $kurs_usd
                      : 1);

                  $kondisi_usd = ($detail['jns_bc'] == 25 || $detail['jns_bc'] == 41)
                    ? $detail['nilai_serah'] / $kurs_usd
                    : $detail['nilai_pab'] / $kurs_usd;

                  // $kondisi_usd = $xpengali;
              ?>
                  <!-- <?php
                        echo "kurs_usd: {$detail['kurs_usd']}<br>";
                        echo "nilai_serah: {$detail['nilai_serah']}<br>";
                        echo "hasil hitung: " . ($detail['kurs_usd'] * $detail['nilai_serah']);
                        ?> -->


                  <tr>
                    <td class="text-center align-middle"><?= 'BC. ' . $detail['jns_bc']; ?></td>
                    <td class="text-left font-bold font-roboto" style="line-height: 14px;"><a href="<?= base_url() . 'bckeluar/viewdetail/' . $detail['idx']; ?>" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='Nomor AJU <?= generatekodebc($detail['jns_bc'], $detail['tgl_aju'], $detail['nomor_aju']); ?>' title='Detail dokumen'><?= $detail['nomor_bc']; ?><br><?= $detail['tgl_bc']; ?></a></td>
                    <td class="text-left" style="line-height: 12px;"><?= $detail['nomor_sj']; ?><br><?= $detail['tgl_sj']; ?></td>
                    <td class="text-left line-12">
                      <?php
                      if (!empty($detail['nama_customer'])) {
                        echo ucwords(strtolower(trim($detail['nama_customer'])));
                        if (!empty($detail['port'])) {
                          echo ' - ' . ucwords(strtolower($detail['port']));
                        }
                      } else {
                        echo ucwords(strtolower(trim($detail['departemen'])));
                      }
                      ?>
                    </td>

                    <td class="text-left" style="line-height: 14px;"><?= $detail['jml_kemasan'] . ' ' . $detail['kemasan']; ?><br><span class="badge badge-outline text-pink"><?= rupiah($detail['netto'], 2) . ' Kgs'; ?></span></td>
                    <td class="text-left line-12"><?= $detail['nomor_sppb']; ?><br><?= $detail['tgl_sppb']; ?></td>
                    <td class="text-right font-kecil"><?= rupiah($kondisi_idr, 2); ?></td>
                    <td class="text-right font-kecil"><?= rupiah($kondisi_usd, 2); ?></td>
                    <!-- <td class="text-right font-kecil"><?= rupiah($detail['nilai_pab'] * $pengali, 2); ?></td>
                    <td class="text-right font-kecil"><?= rupiah($detail['nilai_pab'] * $xpengali, 2); ?></td> -->
                  </tr>
              <?php $cntbrg++;
                  $jmpcs += $detail['pcs'];
                  $jmkgs += $detail['kgs'];
                  $jmidr += $detail['nilai_pab'] * $pengali;
                  $jmusd += $xpengali;
                }
              endif; ?>
            </tbody>
          </table>
        </div>
        <div id="jumlahrek" class="hilang"><?= $cntbrg; ?></div>
        <div id="jumlahpc" class="hilang"><?= $jmpcs; ?></div>
        <div id="jumlahkg" class="hilang"><?= $jmkgs; ?></div>
        <div id="jumlahid" class="hilang"><?= $jmidr; ?></div>
        <div id="jumlahus" class="hilang"><?= $jmusd; ?></div>
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