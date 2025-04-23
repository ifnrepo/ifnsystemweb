<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Adj (Bon Adjustment)
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
            <div class="col-sm-6">
              <a href="<?= base_url() . 'adj/tambahdata'; ?>" class="btn btn-primary btn-sm <?= cekclosebook(); ?>" id="adddataadj"><i class="fa fa-plus"></i><span class="ml-1">Tambah Data</span></a>
            </div>
            <div class="col-sm-6 d-flex flex-row-reverse" style="text-align: right;">
              <input type="text" class="form-control form-sm font-kecil font-bold mr-2" id="th" name="th" style="width: 75px;" value="<?= $this->session->userdata('th') ?>">
              <select class="form-control form-sm font-kecil font-bold mr-1" id="bl" name="bl" style="width: 100px;">
                <?php for ($x = 1; $x <= 12; $x++) : ?>
                  <option value="<?= $x; ?>" <?php if ($this->session->userdata('bl') == $x) echo "selected"; ?>><?= namabulan($x); ?></option>
                <?php endfor; ?>
              </select>
            </div>
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="card-body p-2 font-kecil">
              <div class="row">
                <div class="col-2">
                  <h4 class="mb-1 font-kecil">Dept Adjustment</h4>
                  <input type="hidden" id="errorparam" value="<?= $this->session->flashdata('errorparam'); ?>" >
                  <span class="font-kecil">
                    <div class="font-kecil">
                      <select class="form-select form-control form-sm font-kecil font-bold" id="dept_kirim" name="dept_kirim">
                        <?php
                        // Mendapatkan nilai 'deptsekarang', jikla null nilai default jadi it
                        $selek = $this->session->userdata('currdept') ?? 'IT';
                        foreach ($hakdep as $hak) :
                          $selected = ($this->session->userdata('currdept') == $hak['dept_id']) ? "selected" : "";
                        ?>
                          <option value="<?= $hak['dept_id']; ?>" rel="<?= $hak['departemen']; ?>" <?= $selected ?>>
                            <?= $hak['departemen']; ?>
                          </option>
                        <?php endforeach; ?>
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
          <table id="pbtabel" class="table nowrap order-column mt-1" style="width: 100% !important;">
            <thead>
              <tr>
                <th>Tgl</th>
                <th>Nomor</th>
                <th>Jumlah Item</th>
                <th>Dibuat Oleh</th>
                <th>Disetujui Oleh</th>
                <th>Keterangan</th>
                <th>Aksi</th>
              </tr>
            </thead>
            <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
              <?php
              foreach ($data as $datdet) :
                $jmlrec = $datdet['jmlrex'] == null ? '' : $datdet['jmlrex'] . ' Item ';
                $tungguoke = '';
                $tunggukonfirmasi = '';
                $cancel = '';
                $tekred = '';
                $usersetuju = '';
                $tglsetuju = '';
                if ($datdet['data_ok'] == 0) {
                  $tungguoke = 'Bon Belum divalidasi/disimpan';
                }
                if ($datdet['data_ok'] == 1 && $datdet['ok_valid'] == 0) {
                  $tunggukonfirmasi = 'Menunggu Konfirmasi Manager';
                }
                if ($datdet['ok_valid'] == 2) {
                  $cancel = '(CANCEL) ' . $datdet['ketcancel'];
                  $tekred = 'text-red';
                }
                if ($datdet['ok_valid'] == 1) {
                  $usersetuju = substr(datauser($datdet['user_valid'], 'name'), 0, 35);
                  $tglsetuju = tglmysql2($datdet['tgl_valid']);
                }
              ?>
                <tr>
                  <td><?= tglmysql($datdet['tgl']); ?></td>
                  <td><a href='<?= base_url() . 'pb/viewdetailpb/' . $datdet['id'] ?>' data-bs-toggle='offcanvas' data-bs-target='#canvasdet' data-title='View Detail' title='View Detail'> <?= $datdet['nomor_dok'] ?></a></td>
                  <td><?= $jmlrec; ?></td>
                  <td style="line-height: 14px;"><?= substr(datauser($datdet['user_ok'], 'name'), 0, 35) . "<br><span style='font-size: 10px;'>" . tglmysql2($datdet['tgl_ok']) . "</span>" ?></td>
                  <td style="line-height: 14px;"><?= $usersetuju . "<br><span style='font-size: 10px;'>" . $tglsetuju . "</span>" ?></td>
                  <td><?= $tunggukonfirmasi . $tungguoke . $cancel ?></td>
                  <td class="text-right">
                    <?php
                    if ($datdet['data_ok'] == 0) {
                      echo "<a href=" . base_url() . 'adj/dataadj/' . $datdet["id"] . " class='btn btn-sm btn-primary btn-flat mr-1' style='padding: 3px 5px !important;' title='Edit data'><i class='fa fa-edit mr-1'></i> Lanjutkan transaksi</a>";
                      echo "<a href='#' class='btn btn-sm btn-danger btn-flat mr-1' data-bs-toggle='modal' data-bs-target='#modal-danger' data-message='Akan menghapus data ini' style='padding: 3px 5px !important;' data-href=" . base_url() . 'adj/hapusdataadj/' . $datdet["id"] . " title='Hapus data'><i class='fa fa-trash-o'></i> Hapus</a>";
                    } else if ($datdet['data_ok'] == 1 && $datdet['ok_valid'] == 0) {
                      echo "<a href='#' style='padding: 3px 6px !important' class='btn btn-sm btn-info btn-flat mr-1' data-bs-toggle='modal' data-bs-target='#modal-info' data-message='Edit data ini' data-href=" . base_url() . 'adj/editokadj/' . $datdet["id"] . " title='Validasi data'><i class='fa fa-refresh mr-1'></i> Edit ADJ</a>";
                    } else if ($datdet['data_ok'] == 1 && $datdet['ok_valid'] == 1 && $this->session->userdata('levelsekarang') == 1) {
                      echo "<a class='btn btn-sm btn-danger btn-flat mr-1' href=" . base_url() . 'pb/cetakbon/' . $datdet["id"] . " target='_blank' title='Cetak'><i class='fa fa-file-pdf-o mr-1'></i> PDF</a>";
                      if ($datdet['ok_tuju'] == 0 && $datdet['id_keluar'] == null) {
                        // echo "<a href='#' style='padding: 3px 6px !important' class='btn btn-sm btn-primary btn-flat mr-1' data-bs-toggle='modal' data-bs-target='#modal-info' data-message='Edit Validasi data ini' data-href=" . base_url() . 'pb/editvalidasipb/' . $datdet["id"] . " title='Edit Validasi data'><i class='fa fa-refresh mr-1'></i> Edit</a>";
                      }
                    }
                    ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>