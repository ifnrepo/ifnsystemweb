<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Page 404 - SYSTEM PT. Indoneptune Net Mfg.</title>
    <!-- CSS files -->
    <link href=<?= base_url() . "assets/css/bootstrap.min.css" ?> rel="stylesheet">
    <link href=<?= base_url() . "assets/css/font-awesome.min.css" ?> rel="stylesheet">
    <link href=<?= base_url() . "assets/css/tabler.min.css?1692870487" ?> rel="stylesheet" />
    <link href=<?= base_url() . "assets/css/tabler-flags.css?1692870487" ?> rel="stylesheet" />
    <link href=<?= base_url() . "assets/css/tabler-payments.min.css?1692870487" ?> rel="stylesheet" />
    <link href=<?= base_url() . "assets/css/tabler-vendors.min.css?1692870487" ?> rel="stylesheet" />
    <link href=<?= base_url() . "assets/css/demo.min.css?1692870487" ?> rel="stylesheet" />
    <style>
      /* @import url('https://rsms.me/inter/inter.css'); */
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" border-top-wide border-primary d-flex flex-column">
    <div class="page page-center">
      <div class="container-tight py-4">
        <div class="empty">
          <div class="empty-header">
            <img src="<?= base_url() . "assets/image/logodepanK.png" ?>" width="250" height="auto" alt=""><br>404</div>
          <p class="empty-title">Oops… Halaman ini Error</p>
          <p class="empty-subtitle text-secondary">
            Mohon maaf, halaman <span style="color: gray;"><i><?= base_url(uri_string()); ?></i></span> tidak ditemukan
          </p>
          <div class="empty-action">
            <a href="<?= base_url(); ?>" class="btn btn-primary">
              <!-- Download SVG icon from http://tabler-icons.io/i/arrow-left -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l14 0" /><path d="M5 12l6 6" /><path d="M5 12l6 -6" /></svg>
              Kembali ke Home
            </a>
          </div>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src=<?= base_url() . "assets/js/demo-theme.min.js" ?>></script>
    <script src=<?= base_url() . "assets/js/tabler.min.js" ?> defer></script>
    <script src=<?= base_url() . "assets/js/demo.min.js" ?> defer></script>
  </body>
</html>