<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Edit Mesin 
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'mastermsn'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-header font-bold text-primary">
        <?= $data['nama_barang']; ?><br>
        <?= $this->session->set_flashdata('ketlain'); ?>
        <?= $this->session->set_flashdata('msg'); ?>
      </div>
      <div class="card-body font-kecil">
        <div class="row">
          <div class="col-4">
            <div class="bg-blue-lt p-1">
              <?php $foto = trim($data['filefoto'])=='' ? LOK_FOTO_MESIN.'/NoImageYet.jpg' : LOK_FOTO_MESIN.$data['filefoto'];  ?>
              <img src="<?= $foto ?>" alt="<?= $foto ?>" style="width: auto;" id="gbimage">
            </div>
            <div class="text-center">
              <form name="formFoto" id="formFoto" action="<?= $actionfoto; ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="id" value="<?= $data['idx']; ?>">
                <hr class="m-1">
                <div>
                  <div class="input-group">
                        <input type="hidden" class="form-control group-control" id="file_path" name="file_path">
                        <input type="file" class="hilang" accept="image/*"  id="file" name="file" onchange="loadFile(event)">
                        <input type="hidden" name="old_logo" value="<?= $data['filefoto'] ?>">
                        </div>
                </div>
                <button type="button" class="btn btn-sm btn-info btn-flat" id="file_browser"><i class="fa fa-search mr-1"></i> Get Foto</button>
                <button type="submit" class="btn btn-sm btn-danger btn-flat disabled" id="okesubmit"><i class="fa fa-check mr-1"></i> Update Foto</button>
              </form>
            </div>
            <hr class="m-2">
            <div class="mt-2">
              <div style="font-size: 15px;" class="font-bold">DOKUMEN</div>
              <form name="formdok" id="formdok" action="<?= $actiondok; ?>" method="post" enctype="multipart/form-data">
                  <input type="hidden" name="id_mesin" id="id_mesin" value="<?= $data['idx']; ?>">
                  <input type="file" class="hidden hilang" accept=".pdf" id="dok" name="dok">
                  <input type="text" class="form-control font-kecil hilang" id="dok_lama" name="dok_lama" value="<?= $data['filepdf']; ?>"  placeholder="Dok Lama" readonly>
                  <div class="input-group mb-2">
                    <input type="text" class="form-control font-kecil" value="<?= $data['filepdf']; ?>" name="namedok" id="namedok" placeholder="Dokumen Terkait" readonly>
                    <button class="btn font-kecil btn-info" id="btnget" type="button">Get File</button>
                    <button class="btn font-kecil btn-danger disabled" id="btnupdate" type="button">Update</button>
                    <a href="<?= base_url().'mastermsn/viewdok/'.$data['idx']; ?>" class="btn font-kecil btn-cyan" data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View DOKUMEN' id="btnview">View</a>
                  </div>
                </form>
            </div>
          </div>
          <div class="col-8">
              <form name="formkolom" id="formkolom" action="<?= $actionkolom; ?>" method="post">
              <input type="hidden" name="idu" id="idu" value="<?= $data['idx']; ?>">
              <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Lokasi</label>
                <div class="col">
                  <select class="form-control form-select font-kecil" id="lokasi" name="lokasi">
                    <option value="ARROZA" <?php if(trim($data['lokasi'])=='ARROZA'){ echo "selected"; } ?>>ARROZA</option>
                    <option value="FINISHING" <?php if(trim($data['lokasi'])=='FINISHING'){ echo "selected"; } ?>>FINISHING</option>
                    <option value="LABORATORIUM" <?php if(trim($data['lokasi'])=='LABORATORIUM'){ echo "selected"; } ?>>LABORATORIUM</option>
                    <option value="NETTING" <?php if(trim($data['lokasi'])=='NETTING'){ echo "selected"; } ?>>NETTING</option>
                    <option value="PANCA JAYA" <?php if(trim($data['lokasi'])=='PANCA JAYA'){ echo "selected"; } ?>>PANCA JAYA</option>
                    <option value="RING" <?php if(trim($data['lokasi'])=='RING'){ echo "selected"; } ?>>RING</option>
                    <option value="SPINNING" <?php if(trim($data['lokasi'])=='SPINNING'){ echo "selected"; } ?>>SPINNING</option>
                    <option value="UTILITY" <?php if(trim($data['lokasi'])=='UTILITY'){ echo "selected"; } ?>>UTILITY</option>
                  </select>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Kode Fix Asset</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" id="kode_fix" name="kode_fix" value="<?= $data['kode_fix']; ?>" aria-describedby="emailHelp" placeholder="kode Fix">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Spek Ver BC</label>
                <div class="col">
                  <textarea class="form-control font-kecil" id="spek_akt" name="spek_akt"><?= $data['spek_akt']; ?></textarea>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Spek Ver Akunting</label>
                <div class="col">
                  <textarea class="form-control font-kecil" id="spek_akt" name="spek_akt"><?= $data['spek_akt']; ?></textarea>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Data BC</label>
                <div class="col bg-cyan-lt p-1">
                <div class="row">
                  <div class="col-6">
                    <div class="mb-1 row">
                      <label class="col-3 col-form-label font-bold">Tgl Masuk</label>
                      <div class="col">
                        <input type="text" class="form-control font-kecil tglpilih" id="tglmasuk" name="tglmasuk" value="<?= tglmysql($data['tglmasuk']); ?>" aria-describedby="emailHelp" placeholder="Tgl Masuk">
                      </div>
                    </div>
                    <div class="mb-1 row">
                      <label class="col-3 col-form-label font-bold">Berat KGS</label>
                      <div class="col">
                        <input type="text" class="form-control font-kecil inputangka text-right" id="berat" name="berat" value="<?= rupiah($data['berat'],2); ?>" aria-describedby="emailHelp" placeholder="Berat - KGS">
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="mb-1 row">
                      <label class="col-3 col-form-label font-bold">Tgl BC</label>
                      <div class="col">
                        <input type="text" class="form-control font-kecil tglpilih" id="tgl_bc" name="tgl_bc" value="<?= tglmysql($data['tgl_bc']); ?>" aria-describedby="emailHelp" placeholder="Tgl BC">
                      </div>
                    </div>
                    <div class="mb-1 row">
                      <label class="col-3 col-form-label font-bold">Nomor BC</label>
                      <div class="col">
                        <input type="text" class="form-control font-kecil" id="nomor_bc" name="nomor_bc" value="<?= $data['nomor_bc']; ?>" aria-describedby="emailHelp" placeholder="Nomor BC">
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold"></label>
                <div class="col bg-cyan-lt p-1">
                <div class="row">
                  <div class="col-6">
                    <div class="mb-1 row">
                      <label class="col-3 col-form-label font-bold">Model</label>
                      <div class="col">
                        <input type="text" class="form-control font-kecil" id="model" name="model" value="<?= $data['model']; ?>" aria-describedby="emailHelp" placeholder="Model">
                      </div>
                    </div>
                    <div class="mb-1 row">
                      <label class="col-3 col-form-label font-bold">Negara</label>
                      <div class="col">
                        <input type="text" class="form-control font-kecil" id="negara" name="negara" value="<?= $data['negara']; ?>" aria-describedby="emailHelp" placeholder="Negara Asal">
                      </div>
                    </div>
                    <div class="mb-1 row">
                      <label class="col-3 col-form-label font-bold">Mt Uang</label>
                      <div class="col">
                        <select class="form-control form-select font-kecil" id="mt_uang" name="mt_uang">
                          <option value="IDR" <?php if(trim($data['mt_uang'])=='IDR'){ echo "selected"; } ?>>IDR</option>
                          <option value="USD" <?php if(trim($data['mt_uang'])=='USD'){ echo "selected"; } ?>>USD</option>
                          <option value="YEN" <?php if(trim($data['mt_uang'])=='YEN'){ echo "selected"; } ?>>YEN</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-6">
                    <div class="mb-1 row">
                      <label class="col-3 col-form-label font-bold">SN  </label>
                      <div class="col">
                        <input type="text" class="form-control font-kecil" id="serial" name="serial" value="<?= $data['serial']; ?>" aria-describedby="emailHelp" placeholder="Serial">
                      </div>
                    </div>
                    <div class="mb-1 row">
                      <label class="col-3 col-form-label font-bold">Invoice</label>
                      <div class="col">
                        <input type="text" class="form-control font-kecil" id="invoice" name="invoice" value="<?= $data['invoice']; ?>" aria-describedby="emailHelp" placeholder="Invoice">
                      </div>
                    </div>
                    <div class="mb-1 row">
                      <label class="col-3 col-form-label font-bold">Kurs</label>
                      <div class="col">
                        <input type="text" class="form-control font-kecil inputangka text-right" id="kurs" name="kurs" value="<?= rupiah($data['kurs'],2); ?>" aria-describedby="emailHelp" placeholder="Nilai Kurs">
                      </div>
                    </div>
                  </div>
                </div>
                </div>
              </div>
              <div class="row">
                <label class="col-3 col-form-label font-bold">Asset ?</label>
                <div class="col mt-2">
                  <label class="form-check form-switch">
                    <?php $ceklis = $data['is_asset']=='1' ? 'checked' : ''; ?>
                    <input class="form-check-input" type="checkbox" id="is_asset" name="is_asset" <?= $ceklis; ?>>
                    <span class="form-check-label"></span>
                  </label>
                </div>
              </div>
              <div class="mb-1 row">
                <?php $matauang = $data['mt_uang']=='' ? 'IDR' : $data['mt_uang']; ?>
                <label class="col-3 col-form-label font-bold">Harga (<?= $matauang; ?>)</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil text-right inputangka" id="harga" name="harga" value="<?= rupiah($data['harga'],2); ?>" aria-describedby="emailHelp" placeholder="Harga">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Amount (IDR)</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil text-right" value="<?= rupiah($data['harga']*$data['kurs'],2); ?>" aria-describedby="emailHelp" placeholder="kode Fix" disabled>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Landing Ch (IDR)</label>
                <div class="col">
                  <div class="row">
                    <div class="col-6">
                      <input type="text" class="form-control font-kecil text-right inputangka" id="landing" name="landing" value="<?= rupiah($data['landing'],2); ?>" aria-describedby="emailHelp" placeholder="Landing Charge">
                    </div>
                    <div class="col-6">
                      <input type="text" class="form-control font-kecil text-right inputangka"  value="<?= rupiah(0,2); ?>" aria-describedby="emailHelp" placeholder="Other Amount">
                    </div>
                  </div>
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label font-bold">Total Amount (IDR)</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil text-right font-bold" value="<?= rupiah(($data['harga']*$data['kurs'])+$data['landing'],2); ?>" aria-describedby="emailHelp" placeholder="kode Fix" disabled>
                </div>
              </div>
            </form>
            </div>
        </div>
      </div>

      <hr class="m-1">
      <div class="d-flex justify-content-beetwen p-3">
        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">.</button>
        <span class="text-red" style="font-size: 12px !important;" id="keteranganerr"></span>
        <a class="btn btn-sm btn-primary" style="color: white;" id="simpanmesin">Simpan Perubahan </a>
      </div>
    </div>
    </div>
</div>