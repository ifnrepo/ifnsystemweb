<!doctype html>
<html lang="en" translate="no">

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
  <link href=<?= base_url() . "assets/css/tabler-flags.css?1692870487" ?> type="text/css" rel="stylesheet" />
  <link href=<?= base_url() . "assets/css/tabler-payments.min.css?1692870487" ?> rel="stylesheet" />
  <link href=<?= base_url() . "assets/css/tabler-vendors.min.css?1692870487" ?> rel="stylesheet" />
  <link href=<?= base_url() . "assets/css/demo.min.css?1692870487" ?> rel="stylesheet" />
  <link href=<?= base_url() . "assets/css/jquery-ui.css" ?> rel="stylesheet" />
  <link href=<?= base_url() . "assets/tagify/tagify.css" ?> rel="stylesheet" />


  <!-- datatables -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/datatables/datatables.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/datatables/css/responsive.bootstrap.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/fixheader/css/fixedHeader.bootstrap.min.css">
  <!-- amchart css -->
  <!-- <link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" /> -->
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/bootstrap-datepicker/css/bootstrap-datepicker.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/select2/css/select2.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/toast/jquery.toast.min.css">
  <link rel="stylesheet" href="<?= base_url(); ?>assets/vendor/nprogress/nprogress.css">

  <link href=<?= base_url() . "assets/css/own-style.css?1764748054" ?> rel="stylesheet" />
  <style>
    .ui-autocomplete {
      z-index: 99999 !important;
      max-height: 200px;
      overflow-y: auto;
      overflow-x: hidden;
      font-size: 12px;
      background-color: white;
    }
  </style>
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
  <noscript>
    <style type="text/css">
      .page {
        display: none;
      }
    </style>
    <div class="noscriptmsg">
      You don't have javascript enabled. Good luck with that.
    </div>
  </noscript>
</head>

<body>
  <div class="page page-center" style="z-index: 10000;" id="preloader">
    <div class="container container-slim py-4">
      <div class="text-center">
        <div class="mb-3">
          <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?= base_url() . 'assets/image/logosystem3.png'; ?>" height="45" alt=""></a>
        </div>
        <div class="text-secondary mb-3">Preparing data, Please wait..</div>
        <div class="progress progress-sm">
          <div class="progress-bar progress-bar-indeterminate"></div>
        </div>
      </div>
    </div>
  </div>
  <!-- <div class="loaderis">
    <div class="text-center">
      <div class="loadering"></div>
    </div>
  </div> -->
  <!-- Kummpulan Modal -->
  <div class="modal modal-blur fade" id="modal-simple" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fetched-data">
          Fetching Data ..
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
          </div> -->
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-danger" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-status bg-danger"></div>
        <div class="modal-body text-center py-4">
          <svg class="icon mb-2 text-danger icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M10.24 3.957l-8.422 14.06a1.989 1.989 0 0 0 1.7 2.983h16.845a1.989 1.989 0 0 0 1.7 -2.983l-8.423 -14.06a1.989 1.989 0 0 0 -3.4 0z" />
            <path d="M12 9v4" />
            <path d="M12 17h.01" />
          </svg>
          <h3>Anda Yakin ?</h3>
          <div class="text-secondary" id="message">Do you really want to remove 84 files? What you've done cannot be undone.</div>
        </div>
        <div class="modal-footer">
          <div class="w-100">
            <div class="row">
              <div class="col"><a id="btn-ok" href="#" class="btn btn-danger w-100">
                  Ya
                </a></div>
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                  Tidak
                </a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-info" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-status bg-warning"></div>
        <div class="modal-body text-center py-4">
          <svg class="icon mb-2 text-warning icon-lg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
            <path d="M12 8v4" />
            <path d="M12 16h.01" />
          </svg>
          <h3>Anda Yakin ?</h3>
          <div class="text-secondary" id="message-info"></div>
        </div>
        <div class="modal-footer">
          <div class="w-100">
            <div class="row">
              <div class="col"><a id="btn-ok" href="#" class="btn btn-warning w-100">
                  Ya
                </a></div>
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                  Tidak
                </a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-pilihan" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-status bg-info"></div>
        <div class="modal-body text-center py-4">
          <svg class="icon mb-2 text-info icon-lg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M3 12a9 9 0 1 0 18 0a9 9 0 0 0 -18 0" />
            <path d="M12 8v4" />
            <path d="M12 16h.01" />
          </svg>
          <h3 id="isipesan">Anda Yakin ?</h3>
          <!-- <div class="text-secondary" id="message-info"></div> -->
        </div>
        <div class="modal-footer">
          <div class="w-100">
            <div class="row">
              <div class="col"><a id="btn-ok" href="#" class="btn btn-info w-100">
                  Ya
                </a></div>
              <div class="col"><a id="btn-no" href="#" class="btn btn-danger w-100">
                  Tidak
                </a></div>
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                  Batal
                </a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-large" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title">Large modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fetched-data p-1">
          <div class="text-center">Fetching Data ..</div>
          <!-- <div>
              <div class="container container-slim py-4" id="syncloader">
                    <div class="text-center">
                        <div class="mb-3">
                        </div>
                        <div class="text-secondary mb-3">Fetching data, Please wait..</div>
                        <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                        </div>
                    </div>
                </div>
           </div> -->
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
          </div> -->
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-large-loading" tabindex="-1" role="dialog" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title">Large modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fetched-data p-1">
          <div class="text-center">Fetching Data ..</div>
          <!-- <div>
              <div class="container container-slim py-4" id="syncloader">
                    <div class="text-center">
                        <div class="mb-3">
                        </div>
                        <div class="text-secondary mb-3">Fetching data, Please wait..</div>
                        <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                        </div>
                    </div>
                </div>
           </div> -->
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
          </div> -->
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-largescroll" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title">Large modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fetched-data p-1">
          <div class="text-center">Fetching Data ..</div>
          <!-- <div>
              <div class="container container-slim py-4" id="syncloader">
                    <div class="text-center">
                        <div class="mb-3">
                        </div>
                        <div class="text-secondary mb-3">Fetching data, Please wait..</div>
                        <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                        </div>
                    </div>
                </div>
           </div> -->
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
          </div> -->
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-largescroll2" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Large modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fetched-data p-1">
          <div class="text-center">Fetching Data ..</div>
          <!-- <div>
              <div class="container container-slim py-4" id="syncloader">
                    <div class="text-center">
                        <div class="mb-3">
                        </div>
                        <div class="text-secondary mb-3">Fetching data, Please wait..</div>
                        <div class="progress progress-sm">
                        <div class="progress-bar progress-bar-indeterminate"></div>
                        </div>
                    </div>
                </div>
           </div> -->
        </div>
        <!-- <div class="modal-footer">
            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
          </div> -->
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-scroll" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title text-white">Large modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fetched-data p-1">
          <!-- Fetching Data .. -->
          <div class="text-center">
            <div class="progress w-50 mx-auto" style="width: 50% !important">
              <div class="progress-bar progress-sm progress-bar-indeterminate bg-blue"></div>
            </div>
            Fetching Data
          </div>
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button> -->
          <!-- <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Keluar</button> -->
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-success" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-status bg-success"></div>
        <div class="modal-body text-center py-4">
          <!-- Download SVG icon from http://tabler-icons.io/i/circle-check -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon mb-2 text-green icon-lg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
            <path d="M9 12l2 2l4 -4" />
          </svg>
          <h3>Coming Soon</h3>
          <div class="text-secondary">Permintaan anda sudah berhasil, halaman masih dalam tahap pembuatan oleh TIM</div>
        </div>
        <div class="modal-footer">
          <div class="w-100">
            <div class="row">
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                  Go to dashboard
                </a></div>
              <div class="col"><a href="#" class="btn btn-success w-100" data-bs-dismiss="modal">
                  Close modal
                </a></div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="modal fade" id="modalBox-sm" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class='modal-dialog modal-sm'>
      <div class='modal-content'>
        <div class='modal-header bg-warning'>
          <h6 class='modal-title text-black' id='myModalLabel'> Pengaturan Pengguna</h6>
          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        </div>
        <div class="fetched-data"></div>
      </div>
    </div>
  </div>
  <div class='modal fade' id='confirm-delete' tabindex='-1' role='dialog' aria-labelledby='myModalLabel' aria-hidden='true' data-backdrop="static" data-keyboard="false">
    <div class='modal-dialog'>
      <div class='modal-content'>
        <div class='modal-header btn-info'>
          <h6 class='modal-title' id='myModalLabel'><i class='fa fa-exclamation-triangle text-red'></i> Konfirmasi</h6>
          <button type='button' class='close' data-dismiss='modal' aria-hidden='true'>&times;</button>
        </div>
        <div class='modal-body font-kecil text-black'>
          Apakah Anda yakin ingin menghapus data ini?
        </div>
        <div class='modal-footer font-kecil'>
          <a class='btn-ok'>
            <button type="button" class="btn btn-social btn-flat btn-danger btn-sm" id="ok-delete"><i class='fa fa-trash-o'></i> Hapus</button>
          </a>
          <button type="button" class="btn btn-social btn-flat btn-warning btn-sm" data-dismiss="modal"><i class='fa fa-arrow-right'></i> Tutup</button>
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="canceltask" tabindex="-1" role="dialog" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-status bg-danger"></div>
        <div class="fetched-data" id="isitask">
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="veriftask" tabindex="-1" role="dialog" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        <div class="modal-status bg-info"></div>
        <div class="fetched-data" id="isitask">
        </div>
      </div>
    </div>
  </div>
  <div class="modal modal-blur fade" id="modal-full" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-full-width modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h5 class="modal-title">Full width modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fetched-data p-0">
          Fetching Data ..
        </div>
        <!-- <div class="modal-footer">
          <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button>
          <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Save changes</button>
        </div> -->
      </div>
    </div>
  </div>
  <!-- End Modal -->
  <!-- Canvas -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="canvasdet" aria-labelledby="offcanvasEndLabel" style="min-width:75% !important">
    <div class="offcanvas-header">
      <div class="offcanvas-title font-bold" id="offcanvasEndLabel">Lorem Title</div>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="fetched-data">
        <!-- Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda ea est, eum exercitationem fugiat illum itaque laboriosam magni necessitatibus, nemo nisi numquam quae reiciendis repellat sit soluta unde. Aut! -->
        <div class="text-center p-5" style="font-size: 20px;">
          <div class="spinner-border spinner-border text-teal text-center" role="status"></div> LOADING...
        </div>
      </div>
      <div class="mt-3">
        <button class="btn btn-primary btn-sm btn-flat" type="button" data-bs-dismiss="offcanvas">
          Close
        </button>
      </div>
    </div>
  </div>

  <!-- End Canvas -->
  <!-- <div id="preloader">
    <div class="page page-center">
    <div class="container container-slim py-4">
        <div class="text-center">
          <div class="mb-3">
            <a href="." class="navbar-brand navbar-brand-autodark"><img src=<?= base_url() . "assets/image/logodepanK.png" ?> height="36" alt=""></a>
          </div>
          <div class="text-secondary mb-3">Preparing page</div>
          <div class="progress progress-sm">
            <div class="progress-bar progress-bar-indeterminate"></div>
          </div>
        </div>
      </div>
    </div>
  </div> -->
  <div class="page">
    <!-- Sidebar -->
    <aside class="navbar navbar-vertical navbar-expand-lg d-print-none" data-bs-theme="dark">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand d-print-none">
          <a href="<?= base_url(); ?>">
            <img src=<?= base_url() . "assets/image/logodepan.png" ?> width="100" height="30" alt="IFN" class="navbar-brand-image">
          </a>
        </h1>
        <h1 class="navbar-brand d-print-none m-0 p-1">
          <a href="<?= base_url(); ?>" style="text-decoration: none;">
            STOK OPNAME
          </a>
        </h1>
        <div class="hr mt-2 mb-0"></div>
        <div class="navbar-nav flex-row d-lg-none d-print-none">
          <div class="d-none d-lg-flex">
            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
              </svg>
            </a>
            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
              </svg>
            </a>
          </div>
          <div class="nav-item dropdown mr-2">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
              <span class="avatar avatar-sm" style="background-image: url(<?= base_url() . "assets/image/avatars/005f.jpg" ?>)"></span>
              <div class="d-none d-xl-block ps-2">
                <div><?= $this->session->userdata('name') . ' [' . $this->session->userdata('level_user') . ']'; ?></div>
                <div class="mt-1 small text-secondary"><?= $this->session->userdata('jabatan') . ' / ' . $this->session->userdata('dept_user') ?></div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a class="dropdown-item">Status</a>
              <a class="dropdown-item">Profile</a>
              <a href="<?= base_url() . 'userapps/refreshsess/' . $this->session->userdata('id') . '/' . uri_string(); ?>" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-reload text-success mr-1">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" />
                  <path d="M20 4v5h-5" />
                </svg>
                Refresh session</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item">Settings</a>
              <a href="<?= base_url() . 'Auth/logout'; ?>" class="dropdown-item">Logout</a>
            </div>
          </div>
        </div>
        <div class="collapse navbar-collapse pb-5" id="sidebar-menu">
          <ul class="navbar-nav pt-lg-3">
            <li class="nav-item">
              <a class="nav-link <?php if (!isset($header)) {
                                    echo 'active';
                                  } ?>" href="<?= base_url().'opname'; ?>">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                  </svg>
                </span>
                <span class="nav-link-title">
                  Dashboard
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (!isset($header)) {
                                    echo 'active';
                                  } ?>" href="<?= base_url().'opname/dataopname'; ?>">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-list-check"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M3.5 5.5l1.5 1.5l2.5 -2.5" /><path d="M3.5 11.5l1.5 1.5l2.5 -2.5" /><path d="M3.5 17.5l1.5 1.5l2.5 -2.5" /><path d="M11 6l9 0" /><path d="M11 12l9 0" /><path d="M11 18l9 0" /></svg>
                </span>
                <span class="nav-link-title">
                  Rekap Data Opname
                </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (!isset($header)) {
                                    echo 'active';
                                  } ?>" href="<?= base_url(); ?>">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-arrow-left"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
                </span>
                <span class="nav-link-title">
                  Back to Home
                </span>
              </a>
            </li>
          </ul>
        </div>
      </div>
    </aside>
    <!-- Navbar -->
    <header class="navbar navbar-expand-md d-none d-lg-flex d-print-none">
      <div class="container-xl">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbar-menu" aria-controls="navbar-menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="navbar-nav flex-row order-md-last">
          <!-- <div class="d-none d-md-flex">
            <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
              </svg>
            </a>
            <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip" data-bs-placement="bottom">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
              </svg>
            </a>
          </div> -->
          <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
              <span class="avatar avatar-sm" style="background-image: url(<?= base_url() . "assets/image/avatars/005f.jpg" ?>)"></span>
              <div class="d-none d-xl-block ps-2">
                <div><?= $this->session->userdata('name') . ' [' . $this->session->userdata('level_user') . ']'; ?></div>
                <div class="mt-1 small text-secondary"><?= $this->session->userdata('jabatan') . ' / ' . $this->session->userdata('dept_user'); ?></div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a class="dropdown-item">Status</a>
              <a class="dropdown-item">Profile</a>
              <a href="<?= base_url() . 'userapps/refreshsess/' . $this->session->userdata('id') . '/' . uri_string(); ?>" class="dropdown-item">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-reload text-success mr-1">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M19.933 13.041a8 8 0 1 1 -9.925 -8.788c3.899 -1 7.935 1.007 9.425 4.747" />
                  <path d="M20 4v5h-5" />
                </svg>
                Refresh session</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item">Settings</a>
              <a href="<?= base_url() . 'Auth/logout'; ?>" class="dropdown-item">Logout</a>
            </div>
          </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">
          <div id="loadview">
            <!-- <div class="spinner-border spinner-border-sm text-secondary" role="status"></div> -->
          </div>
          <span class="loadered hilang"></span>
          <!-- <span class="loaderedblue hilang"></span> -->
        </div>
      </div>
    </header>
    <div class="page-wrapper">
    <input type="hidden" name="errorsimpan" id="errorsimpan" value="<?= $this->session->flashdata('errorsimpan'); ?>">
    <input type="hidden" name="pesanerror" id="pesanerror" value="<?= $this->session->flashdata('pesanerror'); ?>">