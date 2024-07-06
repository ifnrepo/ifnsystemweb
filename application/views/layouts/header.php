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
  <link href=<?= base_url() . "assets/css/tabler-flags.css?1692870487" ?> rel="stylesheet" />
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
  <!-- Kummpulan Modal -->
  <div class="modal modal-blur fade" id="modal-simple" role="dialog" data-backdrop="static" data-keyboard="false" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fetched-data">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci animi beatae delectus deleniti dolorem eveniet facere fuga iste nemo nesciunt nihil odio perspiciatis, quia quis reprehenderit sit tempora totam unde.
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
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                  Batal
                </a></div>
              <div class="col"><a id="btn-ok" href="#" class="btn btn-danger w-100">
                  Hapus
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
        <div class="modal-status bg-info"></div>
        <div class="modal-body text-center py-4">
          <svg class="icon mb-2 text-info icon-lg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-alert-circle">
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
              <div class="col"><a href="#" class="btn w-100" data-bs-dismiss="modal">
                  Batal
                </a></div>
              <div class="col"><a id="btn-ok" href="#" class="btn btn-info w-100">
                  Ya
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
  <div class="modal modal-blur fade" id="modal-large" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Large modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fetched-data p-1">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci animi beatae delectus deleniti dolorem eveniet facere fuga iste nemo nesciunt nihil odio perspiciatis, quia quis reprehenderit sit tempora totam unde.
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
        <div class="modal-header">
          <h5 class="modal-title">Large modal</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body fetched-data p-1">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Adipisci animi beatae delectus deleniti dolorem eveniet facere fuga iste nemo nesciunt nihil odio perspiciatis, quia quis reprehenderit sit tempora totam unde.
        </div>
        <div class="modal-footer">
          <!-- <button type="button" class="btn me-auto" data-bs-dismiss="modal">Close</button> -->
          <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Keluar</button>
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
  <!-- End Modal -->
  <!-- Canvas -->
  <div class="offcanvas offcanvas-end" tabindex="-1" id="canvasdet" aria-labelledby="offcanvasEndLabel" style="min-width:75% !important">
    <div class="offcanvas-header">
      <div class="offcanvas-title font-bold" id="offcanvasEndLabel">Lorem Title</div>
      <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
      <div class="fetched-data">
        Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab assumenda ea est, eum exercitationem fugiat illum itaque laboriosam magni necessitatibus, nemo nisi numquam quae reiciendis repellat sit soluta unde. Aut!
      </div>
      <div class="mt-3">
        <button class="btn btn-primary btn-sm btn-flat" type="button" data-bs-dismiss="offcanvas">
          Close
        </button>
      </div>
    </div>
  </div>
  <!-- End Canvas -->
  <div class="page">
    <!-- Sidebar -->
    <aside class="navbar navbar-vertical navbar-expand-lg" data-bs-theme="dark">
      <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu" aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <h1 class="navbar-brand">
          <a href=".">
            <img src=<?= base_url() . "assets/image/logodepan.png" ?> width="100" height="30" alt="IFN" class="navbar-brand-image">
          </a>
        </h1>
        <div class="hr mt-2 mb-0"></div>
        <div class="navbar-nav flex-row d-lg-none">
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
          <div class="nav-item dropdown">
            <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
              <span class="avatar avatar-sm" style="background-image: url(<?= base_url() . "assets/image/avatars/005f.jpg" ?>)"></span>
              <div class="d-none d-xl-block ps-2">
                <div><?= $this->session->userdata('name') . ' [' . $this->session->userdata('level_user') . ']'; ?></div>
                <div class="mt-1 small text-secondary"><?= $this->session->userdata('jabatan'); ?></div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a class="dropdown-item">Status</a>
              <a class="dropdown-item">Profile</a>
              <a class="dropdown-item">Feedback</a>
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
                                  } ?>" href="<?= base_url(); ?>">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                    <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                    <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
                  </svg>
                </span>
                <span class="nav-link-title">
                  Home
                </span>
              </a>
            </li>
            <li class="nav-item <?php if($this->session->userdata('level_user') == 0) { echo "hilang";} ?>">
              <a class="nav-link <?php if (isset($header) && $header=='pendingtask') {
                                    echo 'active';
                                  } ?>" href="<?= base_url().'task'; ?>">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-checklist"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9.615 20h-2.615a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2h8a2 2 0 0 1 2 2v8" /><path d="M14 19l2 2l4 -4" /><path d="M9 8h4" /><path d="M9 12h2" /></svg>
                </span>
                <span class="nav-link-title">
                  Pending Task
                </span>
              </a>
            </li>
            <li class="nav-item dropdown <?= cekmenuheader($this->session->userdata('master')); ?>">
              <a class="nav-link dropdown-toggle <?php if (isset($header) && $header == 'master') {
                                                    echo 'active';
                                                  } ?>" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="true">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M4 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                    <path d="M4 13m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                    <path d="M14 4m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v3a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                    <path d="M14 15m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v1a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z" />
                  </svg>
                </span>
                <span class="nav-link-title ">
                  Master Data
                </span>
              </a>
              <div class="dropdown-menu <?php if (isset($header) && $header == 'master') {
                                          echo 'show active';
                                        } ?>">
                <div class="dropdown-menu-columns">
                  <div class="dropdown-menu-column">
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 1); ?>" href="<?= base_url() . 'satuan'; ?>">
                      Satuan
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 2); ?>" href="<?= base_url('kategori'); ?>">
                      Kategori Barang
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 3); ?>" href="<?= base_url() . 'barang'; ?>">
                      Barang
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 4); ?>" href="<?= base_url('supplier'); ?>">
                      Supplier
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 5); ?>" href="<?= base_url('customer'); ?>">
                      Customer
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 6); ?>" href="<?= base_url('nettype'); ?>">
                      Nettype
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 7); ?>" href="<?= base_url('dept'); ?>">
                      Departemen
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 8); ?>" href="<?= base_url('ref_dokumen'); ?>">
                      Referensi Document
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 9); ?>" href="<?= base_url('kategori_dept'); ?>">
                      Kategori Departemen
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 10); ?>" href="<?= base_url('personil'); ?>">
                      Personil
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 11); ?>" href="<?= base_url('jabatan'); ?>">
                      Data Jabatan
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('master'), 12); ?>" href="<?= base_url('grup'); ?>">
                      Data Grup
                    </a>
                  </div>
                </div>
              </div>
            </li>

            <li class="nav-item dropdown <?= cekmenuheader($this->session->userdata('transaksi')); ?>">
              <a class="nav-link dropdown-toggle <?php if (isset($header) && $header == 'transaksi') {
                                                    echo 'active';
                                                  } ?>" href="#navbar-base" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="true">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-coin">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M12 12m-9 0a9 9 0 1 0 18 0a9 9 0 1 0 -18 0" />
                    <path d="M14.8 9a2 2 0 0 0 -1.8 -1h-2a2 2 0 1 0 0 4h2a2 2 0 1 1 0 4h-2a2 2 0 0 1 -1.8 -1" />
                    <path d="M12 7v10" />
                  </svg>
                </span>
                <span class="nav-link-title ">
                  Transaksi
                </span>
              </a>
              <div class="dropdown-menu <?php if (isset($header) && $header == 'transaksi') {
                                          echo 'show active';
                                        } ?>">
                <div class="dropdown-menu-columns">
                  <div class="dropdown-menu-column">
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('transaksi'), 1); ?>" href="<?= base_url('pb/clear'); ?>">
                      PB (Bon Permintaan Barang)
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('transaksi'), 2); ?>" href="<?= base_url('bbl'); ?>">
                      BBL (Bon Pembelian Barang)
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('transaksi'), 3); ?>" href="<?= base_url('in/clear'); ?>">
                      IN (Bon Perpindahan)
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('transaksi'), 4); ?>" href="<?= base_url('out/clear'); ?>">
                      OUT (Bon Perpindahan)
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('transaksi'), 5); ?>" href="<?= base_url('adj'); ?>">
                      ADJ (Bon Adjustment)
                    </a>
                    <a class="dropdown-item <?= cekmenudetail($this->session->userdata('transaksi'), 6); ?>" href="<?= base_url('po/clear'); ?>">
                      PO (Purchase Order)
                    </a>
                  </div>
                </div>
              </div>
            </li>
            <li class="nav-item">
              <a class="nav-link <?php if (isset($header) && $header == 'inventory') {
                                    echo 'active';
                                  } ?>" href="<?= base_url('inv/clear'); ?>">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-building-warehouse">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M3 21v-13l9 -4l9 4v13" />
                    <path d="M13 13h4v8h-10v-6h6" />
                    <path d="M13 21v-9a1 1 0 0 0 -1 -1h-2a1 1 0 0 0 -1 1v3" />
                  </svg>
                </span>
                <span class="nav-link-title">
                  Inventory
                </span>
              </a>
            </li>
            <li class="nav-item <?= cekmenuheader($this->session->userdata('manajemen')); ?>">
              <a class="nav-link <?php if (isset($header) && $header == 'manajemen') {
                                    echo 'active';
                                  } ?>" href="<?= base_url() . 'userapps'; ?>">
                <span class="nav-link-icon d-md-none d-lg-inline-block">
                  <svg class="icon icon-tabler icon-tabler-users" width="24" height="24" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                    <path d="M9 7m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
                    <path d="M3 21v-2a4 4 0 0 1 4 -4h4a4 4 0 0 1 4 4v2" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                    <path d="M21 21v-2a4 4 0 0 0 -3 -3.85" />
                  </svg>
                </span>
                <span class="nav-link-title">
                  User Manajemen
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
                <div class="mt-1 small text-secondary"><?= $this->session->userdata('jabatan'); ?></div>
              </div>
            </a>
            <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
              <a class="dropdown-item">Status</a>
              <a class="dropdown-item">Profile</a>
              <a class="dropdown-item">Feedback</a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item">Settings</a>
              <a href="<?= base_url() . 'Auth/logout'; ?>" class="dropdown-item">Logout</a>
            </div>
          </div>
        </div>
        <div class="collapse navbar-collapse" id="navbar-menu">

        </div>
      </div>
    </header>
    <div class="page-wrapper">