<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
  @media print {

    td,
    ol,
    li {
      font-size: 22px !important;

    }
  }
</style>

<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-2 align-items-center">
      <div class="col">
        <h2 class="page-title">
          Cetak PURCHASE ORDER
        </h2>
      </div>
      <!-- Page title actions -->
      <div class="col-auto ms-auto d-print-none">
        <a href="<?= base_url() . 'po' ?>" type="button" class="btn btn-danger btn-sm">
          <i class="fa fa-arrow-left mr-1"></i>
          Kembali
        </a>
        <button type="button" class="btn btn-primary btn-sm" onclick="javascript:window.print();">
          <i class="fa fa-print mr-1"></i>
          Print
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Page body -->
<div class="page-body mt-3">
  <div class="container-xl">
    <div class="card card-lg">
      <div class="card-body">
        <div class="row mt-7" style="color : black ;">
          <div class="col-6 mt-8" style="font-size: 22px !important; line-height: 22px !important; ">
            <p class=" h2 mb-1">Bandung, <?= tgl_indo($header['tgl']); ?></p>
            <address>
              Kepada Yth,<br>
              <b><?= $header['namasupplier']; ?></b><br>
              <?= $header['alamat']; ?><br>
              <?= 'Attn . ' . $header['kontak']; ?>
            </address>
          </div>
          <div class="col-6 text-end mt-8">
            <p class="h2 line-12" style="border: 1px solid black; padding: 10px 20px; text-align: center; line-height: 1.5; display: inline-block; font-size: 20px;">
              (FM-PC-06/Rev.1/02-05-2008)<br>
              <span style="font-size: 11px;">Tanggal cetak : <?= date('d M Y'); ?> jam <?= date('H:i:s'); ?></span>
            </p>
          </div>
          <div class="col-12 my-0 text-center" style="line-height: 2px !important;">
            <h1 style="display: inline-block; border-bottom: 2px solid black; margin: 0;  font-size: 35px !important; ">
              ORDER PEMBELIAN
            </h1><br>
            <p class="mt-2" style="font-size: 20px !important;"><?= 'No. ' . $header['nomor_dok']; ?></p>
          </div>
          <div class="mt" style="font-size: 22px !important; ">
            Dengan Hormat,<br>
            <?= $header['header_po'];  ?>
            <br><br>
          </div>
          <table class="table table-transparent table-responsive">
            <thead>
              <tr>
                <th class="text-center" style="width: 1% ; font-size: 18px ; ">No</th>
                <th style="font-size:18px; ">Nama Barang</th>
                <th class="text-center" style="width: 1% ; font-size: 18px ; ">Jumlah</th>
                <th class="text-center" style="width: 1% ; font-size: 18px ; ">Sat</th>
                <th class="text-end" style="width: 3% ; font-size: 18px ;">Harga</th>
                <th class="text-end" style="width: 1% ; font-size: 18px ; ">Total</th>
              </tr>
            </thead>
            <?php $no = 1;
            foreach ($detail as $datdet) {
              $tampil = $datdet['pcs'] != 0 ? $datdet['pcs'] : $datdet['kgs']; ?>
              <tr>
                <td class="text-center p-1" style="font-size: 16px !important;"><?= $no++; ?></td>
                <td class="p-1">
                  <p class="strong mb-1" style="font-size: 16px !important;"><?= $datdet['nama_barang']; ?></p>
                </td>
                <td class="text-center p-1" style="font-size: 16px !important;">
                  <?= $tampil ?>
                </td>
                <td class="text-end p-1" style="font-size: 16px !important;"><?= $datdet['kodesatuan']; ?></td>
                <td class="text-end p-1" style="font-size: 16px !important;"><?= rupiah($datdet['harga'], 2); ?></td>
                <td class="text-end p-1" style="font-size: 16px !important;"><?= rupiah($datdet['harga'] * $tampil, 2); ?></td>
              </tr>
            <?php } ?>
            <?php for ($x = 0; $x <= (10 - $no); $x++) { ?>
              <tr>
                <td class="text-center p-1" style="font-size: 16px !important;">&nbsp;<?= $x + $no; ?></td>
                <td class="p-1" style="font-size: 16px !important;">
                  <p class="strong mb-1">&nbsp;</p>
                </td>
                <td class="text-center p-1" style="font-size: 16px !important;">&nbsp;</td>
                <td class="text-end p-1" style="font-size: 16px !important;">&nbsp;</td>
                <td class="text-end p-1" style="font-size: 16px !important;">&nbsp;</td>
                <td class="text-end p-1" style="font-size: 16px !important;">&nbsp;</td>
              </tr>
            <?php } ?>
            <tr>
              <td class="p-1" colspan="3" rowspan="6" style="font-size: 16px !important;">
                Terbilang : <strong><?= terbilang(($header['totalharga'] - $header['diskon']) + $header['ppn'] - $header['pph']); ?></strong>
                <br>
                <br>
                <br>
                <br>
                Tanggal rencana Datang barang : <?= tgl_indo($header['tgl_dtb']); ?>
              </td>
              <td class="strong text-end p-1" colspan="2" style="font-size: 16px !important;">Subtotal</td>
              <td class="text-end p-1" style="font-size: 16px !important;"><?= rupiah($header['totalharga'], 2); ?></td>
            </tr>
            <tr>
              <td class="strong text-end p-1"  colspan="2" style="font-size: 16px !important;">Diskon</td>
              <td class="text-end p-1"><?= rupiah($header['diskon'], 2); ?></td>
            </tr>
            <tr>
              <td class="strong text-end p-1" colspan="2" style="font-size: 16px !important;">PPN(<?= rupiah($header['cekppn'], 0); ?>%)</td>
              <td class="text-end p-1" style="font-size: 14px !important;"><?= rupiah($header['ppn'], 2); ?></td>
            </tr>
            <tr>
              <td class="strong text-end p-1" colspan="2" style="font-size: 16px !important;">PPH</td>
              <td class="text-end p-1" style="font-size: 16px !important;"><?= rupiah($header['pph'], 2); ?></td>
            </tr>
            <?php if($header['ongkir_jasa'] > 0): ?>
              <tr>
                <td class="strong text-end p-1" colspan="2" style="font-size: 16px !important;"><?= $header['ketongkir_jasa'] ?></td>
                <td class="text-end p-1" style="font-size: 16px !important;"><?= rupiah($header['ongkir_jasa'], 2); ?></td>
              </tr>
            <?php endif; ?>
            <tr>
              <td class="font-weight-bold text-uppercase text-end p-1" colspan="2" style="font-size: 16px !important;">Total</td>
              <td class="font-weight-bold text-end p-1" style="font-size: 16px !important;"><?= rupiah(($header['totalharga'] - $header['diskon']) + $header['ongkir_jasa'] + $header['ppn'] - $header['pph'], 2); ?></td>
            </tr>
            <tr>
              <td colspan="8" class="p-1">Catatan :</td>
            </tr>
            <tr>
              <td colspan="8" class="p-1">
                <ol style="font-size: 22px !important; line-height : 22px !important;">
                  <?php for ($x = 1; $x <= 6; $x++) { ?>
                    <li><?= $header['catatan' . $x]; ?></li>
                  <?php } ?>
                </ol>
              </td>
            </tr>
          </table>
        </div>
        <p style="font-size: 20px !important; color : black ;">Kami ucapkan terima kasih atas perhatian dan kerjasamanya, <br>
          Hormat Kami,</p>
      </div>
    </div>
  </div>
</div>