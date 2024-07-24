<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
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
        <a href="<?= base_url().'po' ?>" type="button" class="btn btn-danger btn-sm">
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
<div class="page-body" style="font-size: 12pt;">
  <div class="container-xl">
    <div class="card card-lg">
      <div class="card-body">
        <div class="row">
          <div class="col-6 mt-8">
            <p class="h3 mb-1">Bandung, <?= tgl_indo($header['tgl']); ?></p>
            <address>
              Kepada Yth,<br>
              <b><?= $header['namasupplier']; ?></b><br>
              <?= $header['alamat']; ?><br>
              <?= 'Attn . '.$header['kontak']; ?>
            </address>
          </div>
          <div class="col-6 text-end mt-8">
            <p class="h3 line-12">(FM-PC-06/Rev.1/02-05-2008)<br><span style="font-size: 11px">Tanggal cetak : <?= date('d M Y'); ?> jam <?= date('H:i:s'); ?></span></p>
            <address>
              <!-- Street Address<br>
              State, City<br>
              Region, Postal Code<br>
              ctr@example.com -->
            </address>
          </div>
          <div class="col-12 my-4 text-center font-bold" style="line-height: 14px !important; font-size: 24px;">
            ORDER PEMBELIAN<br><h2><?= 'No. '.$header['nomor_dok']; ?></h2>
          </div>
          <div class="mt-1">
            Dengan Hormat,<br>
            <?= $header['header_po']; ?> 
            <br><br>
          </div>
        </div>
        <table class="table table-transparent table-responsive">
          <thead>
            <tr>
              <th class="text-center" style="width: 1%"></th>
              <th>Nama Barang</th>
              <th class="text-center" style="width: 1%">Jumlah</th>
              <th class="text-center" style="width: 1%">Sat</th>
              <th class="text-end" style="width: 3%">Harga</th>
              <th class="text-end" style="width: 1%">Total</th>
            </tr>
          </thead>
          <!-- <tr>
            <td class="text-center">1</td>
            <td>
              <p class="strong mb-1">Logo Creation</p>
              <div class="text-secondary">Logo and business cards design</div>
            </td>
            <td class="text-center">
              1
            </td>
            <td class="text-end">$1.800,00</td>
            <td class="text-end">$1.800,00</td>
          </tr>
          <tr>
            <td class="text-center">2</td>
            <td>
              <p class="strong mb-1">Online Store Design &amp; Development</p>
              <div class="text-secondary">Design/Development for all popular modern browsers</div>
            </td>
            <td class="text-center">
              1
            </td>
            <td class="text-end">$20.000,00</td>
            <td class="text-end">$20.000,00</td>
          </tr>
          <tr>
            <td class="text-center">3</td>
            <td>
              <p class="strong mb-1">App Design</p>
              <div class="text-secondary">Promotional mobile application</div>
            </td>
            <td class="text-center">
              1
            </td>
            <td class="text-end">$3.200,00</td>
            <td class="text-end">$3.200,00</td>
          </tr> -->
          <?php $no=1; foreach ($detail as $datdet) { $tampil = $datdet['pcs']!=0 ? $datdet['pcs'] : $datdet['kgs']; ?>
            <tr>
              <td class="text-center p-1"><?= $no++; ?></td>
              <td class="p-1">
                <p class="strong mb-1"><?= $datdet['nama_barang']; ?></p>
                <!-- <div class="text-secondary">Promotional mobile application</div> -->
              </td>
              <td class="text-center p-1">
                <?= $tampil ?>
              </td>
              <td class="text-end p-1"><?= $datdet['kodesatuan']; ?></td>
              <td class="text-end p-1"><?= rupiah($datdet['harga'],2); ?></td>
              <td class="text-end p-1"><?= rupiah($datdet['harga']*$tampil,2); ?></td>
            </tr>
          <?php } ?>
          <?php for($x=0;$x<=(10-$no);$x++){ ?>
            <tr>
              <td class="text-center p-1"><?= $x+$no; ?></td>
              <td class="p-1">
                <p class="strong mb-1"></p>
                <!-- <div class="text-secondary">Promotional mobile application</div> -->
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
              Terbilang : <strong><?= terbilang(($header['totalharga']-$header['diskon'])+$header['ppn']-$header['pph']); ?></strong>
              <br>
              <br>
              <br>
              <br>
              Tanggal rencana Datang barang : <?= tgl_indo($header['tgl_dtb']); ?>
            </td>
            <td class="strong text-end p-1">Subtotal</td>
            <td class="text-end p-1"><?= rupiah($header['totalharga'],2); ?></td>
          </tr>
          <tr>
            <td class="strong text-end p-1">Diskon</td>
            <td class="text-end p-1"><?= rupiah($header['diskon'],2); ?></td>
          </tr>
          <tr>
            <td class="strong text-end p-1">PPN(11%)</td>
            <td class="text-end p-1"><?= rupiah($header['ppn'],2); ?></td>
          </tr>
          <tr>
            <td class="strong text-end p-1">PPH</td>
            <td class="text-end p-1"><?= rupiah($header['pph'],2); ?></td>
          </tr>
          <tr>
            <td class="font-weight-bold text-uppercase text-end">Total</td>
            <td class="font-weight-bold text-end"><?= rupiah(($header['totalharga']-$header['diskon'])+$header['ppn']-$header['pph'],2); ?></td>
          </tr>
          <tr>
            <td colspan="8" class="p-1">Catatan :</td>
          </tr>
          <tr>
            <td colspan="8" class="p-1">
              <ul>
                <li>Pesanan dikirim ke PT. Indoneptune Net Manufacturing, Jl. Raya Bandung-Garut Km.25 Rancaekek</li>
                <?php for($x=1;$x<=3;$x++){ ?>
                <?php if($x==2){ ?>
                  <li>Setiap Supplier wajib mentaati aturan K3LH dari PT. Indoneptune Net Manufacturing</li>
                <?php }else{ $y = $x>2 ? $x-1 : $x; ?>
                  <li><?= $header['catatan'.$y]; ?></li>
                <?php }} ?>
              </ul>
            </td>
          </tr>
        </table>
        <p class="text-secondary text-center mt-5">Thank you very much for doing business with us. We look forward to working with
          you again!</p>
      </div>
    </div>
  </div>
</div>