<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<style>
  @media print {

    td,
    ol,
    li {
      font-size: 18px !important;

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
          Print Invoice
        </button>
      </div>
    </div>
  </div>
</div>
<!-- Page body -->
<div class="page-body mt-1" style="font-size: 18px; ">
  <div class="container-xl">
    <div class="card card-lg">
      <div class="card-body">
        <div class="row">
          <div class=" col-6 mt-8" style="font-size: 20px;">
            <p class="h2 mb-1">Bandung, <?= tgl_indo($header['tgl']); ?></p>
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
          <div class="col-12 my-0 text-center" style="line-height: 14px !important; font-size: 28px; color:black ;">
            <h2 style="display: inline-block; border-bottom: 2px solid black; margin: 0; font-size : 30px; color :black ;">
              ORDER PEMBELIAN
            </h2><br>
            <p class="mt-2"><?= 'No. ' . $header['nomor_dok']; ?></p>
          </div>
          <div class="mt" style="font-size: 20px;">
            Dengan Hormat,<br>
            <?= $header['header_po'];  ?>
            <br><br>
          </div>
          <table class="table table-transparent table-responsive">
            <thead>
              <tr>
                <th class="text-center" style="width: 1% ; font-size: 18px ; color :black ;">No</th>
                <th style="font-size:18px; color :black ;">Nama Barang</th>
                <th class="text-center" style="width: 1% ; font-size: 18px ; color :black ;">Jumlah</th>
                <th class="text-center" style="width: 1% ; font-size: 18px ; color :black ;">Sat</th>
                <th class="text-end" style="width: 3% ; font-size: 18px ; color :black ;">Harga</th>
                <th class="text-end" style="width: 1% ; font-size: 18px ; color :black ;">Total</th>
              </tr>
            </thead>
            <?php $no = 1;
            foreach ($detail as $datdet) {
              $tampil = $datdet['pcs'] != 0 ? $datdet['pcs'] : $datdet['kgs']; ?>
              <tr>
                <td class="text-center p-1"><?= $no++; ?></td>
                <td class="p-1">
                  <p class="strong mb-1"><?= $datdet['nama_barang']; ?></p>
                </td>
                <td class="text-center p-1">
                  <?= $tampil ?>
                </td>
                <td class="text-end p-1"><?= $datdet['kodesatuan']; ?></td>
                <td class="text-end p-1"><?= rupiah($datdet['harga'], 2); ?></td>
                <td class="text-end p-1"><?= rupiah($datdet['harga'] * $tampil, 2); ?></td>
              </tr>
            <?php } ?>
            <?php for ($x = 0; $x <= (12 - $no); $x++) { ?>
              <tr>
                <td class="text-center p-1"><?= $x + $no; ?></td>
                <td class="p-1">
                  <p class="strong mb-1"></p>
                </td>
                <td class="text-center p-1">

                </td>
                <td class="text-end p-1"></td>
                <td class="text-end p-1"></td>
                <td class="text-end p-1"></td>
              </tr>
            <?php } ?>
            <tr>
              <td class="p-1" colspan="4" rowspan="5">
                Terbilang : <strong><?= terbilang(($header['totalharga'] - $header['diskon']) + $header['ppn'] - $header['pph']); ?></strong>
                <br>
                <br>
                <br>
                <br>
                Tanggal rencana Datang barang : <?= tgl_indo($header['tgl_dtb']); ?>
              </td>
              <td class="strong text-end p-1">Subtotal</td>
              <td class="text-end p-1"><?= rupiah($header['totalharga'], 2); ?></td>
            </tr>
            <tr>
              <td class="strong text-end p-1">Diskon</td>
              <td class="text-end p-1"><?= rupiah($header['diskon'], 2); ?></td>
            </tr>
            <tr>
              <td class="strong text-end p-1">PPN(<?= rupiah($header['cekppn'], 0); ?>%)</td>
              <td class="text-end p-1"><?= rupiah($header['ppn'], 2); ?></td>
            </tr>
            <tr>
              <td class="strong text-end p-1">PPH</td>
              <td class="text-end p-1"><?= rupiah($header['pph'], 2); ?></td>
            </tr>
            <tr>
              <td class="font-weight-bold text-uppercase text-end p-1">Total</td>
              <td class="font-weight-bold text-end p-1"><?= rupiah(($header['totalharga'] - $header['diskon']) + $header['ppn'] - $header['pph'], 2); ?></td>
            </tr>
            <tr>
              <td colspan="8" class="p-1">Catatan :</td>
            </tr>
            <tr>
              <td colspan="8" class="p-1" style="font-size: 18px;">
                <ol>
                  <li>Pesanan dikirim ke PT. Indoneptune Net Manufacturing, Jl. Raya Bandung-Garut Km.25 Rancaekek</li>
                  <li>Pembayaran 1 (satu) bulan setelah barang di terima</li>
                  <?php for ($x = 1; $x <= 3; $x++) { ?>
                    <?php if ($x == 2) { ?>
                      <li>Setiap Supplier wajib mentaati aturan K3LH dari PT. Indoneptune Net Manufacturing</li>
                      <li>Our Reff BBL (PG-PC/BB/0824/024) Kalender 2025</li>
                      <li>Ket=tatakan harian medium (TH 9908+sablon 2 warna)</li>
                      <?php } else {
                      $y = $x > 2 ? $x - 1 : $x;
                      if ($header['catatan' . $y] != '') : ?>
                        <li><?= $header['catatan' . $y]; ?></li>
                    <?php endif;
                    } ?>
                  <?php } ?>
                </ol>
              </td>
            </tr>
          </table>
        </div>
        <p>Kami ucapkan terima kasih atas perhatian dan kerjasamanya, <br>
          Hormat Kami,</p>
      </div>
    </div>
  </div>
</div>