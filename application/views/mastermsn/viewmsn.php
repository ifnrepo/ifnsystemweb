<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>SYSTEM PT. Indoneptune Net Mfg</title>
  <link href="<?= base_url(); ?>assets/favicon.ico" rel="icon">
  <!-- CSS files -->
  <link href=<?= base_url() . "assets/css/bootstrap.min.css" ?> rel="stylesheet">
  <link href=<?= base_url() . "assets/css/font-awesome.min.css" ?> rel="stylesheet">
  <link href=<?= base_url() . "assets/css/tabler.min.css?1692870487" ?> rel="stylesheet" />
  <link href=<?= base_url() . "assets/css/tabler-flags.css?1692870488" ?> rel="stylesheet" />
  <link href=<?= base_url() . "assets/css/tabler-payments.min.css?1692870487" ?> rel="stylesheet" />
  <link href=<?= base_url() . "assets/css/tabler-vendors.min.css?1692870487" ?> rel="stylesheet" />
  <link href=<?= base_url() . "assets/css/demo.min.css?1692870487" ?> rel="stylesheet" />

  <!-- datatables -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/datatables/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/fixheader/css/fixedHeader.bootstrap.min.css">
  <!-- amchart css -->
  <!-- <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" /> -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/select2/css/select2.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/select2/css/select2-bootstrap4.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/toast/jquery.toast.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/nprogress/nprogress.css">

  <link href=<?= base_url() . "assets/css/own-style.css?1692870493" ?> rel="stylesheet" />
  <style>
    /* @import url('https://rsms.me/inter/inter.css'); */

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
    }
  </style>
  <script type="text/javascript">
    base_url = '<?= base_url() ?>';
  </script>
</head>
<body>
  <div class="page-wrapper">
  <div class="page-header d-print-none">
    <div class="container-xl">
      <div class="row g-0 d-flex align-items-between">
        <div class="col-md-6">
          <h2 class="page-title p-2">
            <?= $data['nama_barang']; ?>
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
        <div class="card-body">
          <div class="row">
            <div class="col-4">
              <div class="card card-active mb-1">
                <?php if($data['ok_stok']==1 && $data['ok_disp']==0){ ?>
                  <div class="ribbon bg-red" style="font-size: 18px;">Verified</div>
                <?php } ?>
                <?php if($data['ok_disp']==1){ ?>
                  <div class="ribbon bg-red" style="font-size: 18px;">DISPOSAL</div>
                <?php } ?>
                <div class="card-body p-0">
                    <?php if(trim($data['filefoto'])==''){ ?>
                        <img src="<?= LOK_FOTO_MESIN.'/NoImageYet.jpg'; ?>" alt="<?= LOK_FOTO_MESIN.'NoImageYet.jpg'; ?>">
                    <?php }else{ ?>
                      <img src="<?= LOK_FOTO_MESIN.$data['filefoto']; ?>" alt="<?= LOK_FOTO_MESIN.$data['filefoto']; ?>">
                    <?php } ?>
                </div>
              </div>
              <div class="card bg-blue-lt">
                <div class="card-body font-kecil p-2">
                  <div style="font-size: 13px; font-style: bold !important;" class="mb-1">DATA STOK OPNAME (TERAKHIR)</div>
                  <hr class="m-0">
                  <hr class="m-0"><br>
                  Tgl Stok Opname : <?= $data['tgl_stok']; ?><br>
                  Oleh : <?= datauser($data['user_stok'],'name'); ?>
                </div>
              </div>
              <?php if($data['ok_disp']==1){ ?>
                <div class="card bg-blue-lt mt-1">
                  <div class="card-body font-kecil p-2">
                    <div style="font-size: 13px; font-style: bold !important;" class="mb-1">DATA DISPOSAL</div>
                    <hr class="m-0">
                    <hr class="m-0"><br>
                    Tgl : <?= $data['tgl_disp']; ?><br>
                    Oleh : -<br>
                    <hr class="m-0">
                    Remark <br>
                    <?= $data['remark_disp']; ?>
                  </div>
                </div>
              <?php } ?>
            </div>
            <div class="col-8">
              <div class="card card-active">
                <div class="card-body">
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">SKU</label>
                    <div class="col">
                      <input type="email" class="form-control" aria-describedby="emailHelp" value="<?= $data['kode']; ?>" placeholder="Kosong">
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Kode Fix Assets</label>
                    <div class="col">
                      <input type="email" class="form-control" aria-describedby="emailHelp" value="<?= $data['kode_fix']; ?>" placeholder="Kosong">
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Lokasi</label>
                    <div class="col">
                      <input type="email" class="form-control" aria-describedby="emailHelp" value="<?= $data['lokasi']; ?>" placeholder="Kosong">
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Spek (Master)</label>
                    <div class="col">
                      <textarea class="form-control" placeholder="Kosong"><?= trim($data['nama_barang']); ?></textarea>
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Spek (Beacukai)</label>
                    <div class="col">
                      <textarea class="form-control" placeholder="Kosong"><?= trim($data['spek_bc']); ?></textarea>
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Spek (Akunting)</label>
                    <div class="col">
                      <textarea class="form-control" placeholder="Kosong"><?= trim($data['spek_akt']); ?></textarea>
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Tgl Masuk</label>
                    <div class="col">
                      <input type="email" class="form-control" aria-describedby="emailHelp" value="<?= tgl_indo($data['tglmasuk']); ?>" placeholder="Kosong">
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Berat (Kgs)</label>
                    <div class="col">
                      <input type="email" class="form-control" aria-describedby="emailHelp" value="<?= rupiah($data['berat'],2); ?>" placeholder="Kosong">
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Nomor BC</label>
                    <div class="col">
                      <input type="email" class="form-control" aria-describedby="emailHelp" value="<?= $data['nomor_bc']; ?>" placeholder="Kosong">
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Tanggal BC</label>
                    <div class="col">
                      <input type="email" class="form-control" aria-describedby="emailHelp" value="<?= tglmysql($data['tgl_bc']); ?>" placeholder="Kosong">
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Model</label>
                    <div class="col">
                      <input type="email" class="form-control" aria-describedby="emailHelp" value="<?= $data['model']; ?>" placeholder="Kosong">
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Serial Number</label>
                    <div class="col">
                      <input type="email" class="form-control" aria-describedby="emailHelp" value="<?= $data['serial']; ?>" placeholder="Kosong">
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Invoice</label>
                    <div class="col">
                      <input type="email" class="form-control" aria-describedby="emailHelp" value="<?= $data['invoice']; ?>" placeholder="Kosong">
                    </div>
                  </div>
                  <div class="mb-1 row">
                    <label class="col-2 col-form-label font-kecil font-bold">Negara Asal</label>
                    <div class="col">
                      <div class="input-icon">
                        <?php 
                          $bendera = '';
                          switch (trim($data['negara'])) {
                            case 'JAPAN':
                              $bendera = 'flag-country-jp';
                              break;
                            case 'JEPANG':
                              $bendera = 'flag-country-jp';
                              break;
                            case 'CHINA':
                              $bendera = 'flag-country-cn';
                              break;
                            case 'INDONESIA':
                              $bendera = 'flag-country-id';
                              break;
                            case 'PHILIPPINES':
                              $bendera = 'flag-country-ph';
                              break;
                            case 'MEXICO':
                              $bendera = 'flag-country-mx';
                              break;
                            case 'SPAIN':
                              $bendera = 'flag-country-sp';
                              break;
                            case 'KOREA':
                              $bendera = 'flag-country-kr';
                              break;
                            
                            // default:
                            //    $bendera = 'flag-country-id';
                            //   break;
                          }
                        ?>
                        <span class="input-icon-addon">
                          <i class="flag flag-xs <?= $bendera; ?>"></i>
                        </span>
                        <input type="email" class="form-control" data-custom-properties="<span class='flag flag-xs flag-country-br'></span>" aria-describedby="emailHelp" value="<?= $data['negara']; ?>" placeholder="Kosong">
                      </div>
                    </div>
                  </div>  
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <footer class="footer footer-transparent d-print-none">
    <div class="container-xl">
      <div class="row text-center align-items-center flex-row-reverse">
        <div class="col-lg-auto ms-lg-auto">
        </div>
        <div class="col-12 col-lg-auto mt-3 mt-lg-0">
          <ul class="list-inline list-inline-dots mb-0">
            <li class="list-inline-item">
              Copyright &copy; <?= date('Y'); ?>
            </li>
            <li class="list-inline-item">
              <a href="#" data-bs-toggle="modal" data-bs-target="#modal-success">
                Tim IT IFN
              </a>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </footer>
  </div>
</body>
</html>