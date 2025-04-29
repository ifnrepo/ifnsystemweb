<div class="row g-0 flex-fill">
  <div class="col-12 col-lg-6 col-xl-4 border-top-wide border-primary d-flex flex-column justify-content-center">
    <div class="container container-tight my-5 px-lg-5">
      <?= $this->session->flashdata('message'); ?>
      <div class="text-center mb-3">
        <a href="." class="navbar-brand navbar-brand-autodark"><img src="<?= base_url(); ?>assets/image/logodepanK.png" height="36" alt=""></a>
      </div>
      <h2 class="h2 text-center mb-4">
        Login Sekarang !
      </h2>
      <form action="<?= base_url() . 'Auth/cekauth'; ?>" method="POST" autocomplete="off" novalidate>
        <div class="mb-3">
          <label class="form-label">Email / Username</label>
          <input type="input" name="username" class="form-control" placeholder="Your username" value="<?= $usercok; ?>" autocomplete="off">
        </div>
        <div class="mb-2">
          <label class="form-label">
            Password
            <!-- <span class="form-label-description">
              <a href="./">Lupa password !</a>
            </span> -->
          </label>
          <div class="input-group input-group-flat">
            <input type="password" class="form-control" name="password" id="password" value="<?= $passcok; ?>" placeholder="Your password" autocomplete="off">
            <span class="input-group-text">
              <a href="#" id="showpass" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                <svg class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                  <path d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                </svg>
                <!-- <svg class="icon icon-tabler icon-tabler-eye-off" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.585 10.587a2 2 0 0 0 2.829 2.828" /><path d="M16.681 16.673a8.717 8.717 0 0 1 -4.681 1.327c-3.6 0 -6.6 -2 -9 -6c1.272 -2.12 2.712 -3.678 4.32 -4.674m2.86 -1.146a9.055 9.055 0 0 1 1.82 -.18c3.6 0 6.6 2 9 6c-.666 1.11 -1.379 2.067 -2.138 2.87" /><path d="M3 3l18 18" /></svg> -->
              </a>
            </span>
          </div>
        </div>
        <div class="mb-2">
          <label class="form-check">
            <!-- <input type="checkbox" class="form-check-input" />
            <span class="form-check-label">Ingat saya</span> -->
            <label class="form-label">
              <?php if($usercok!=null){ ?>
                <input type="checkbox" name="lupasaya" id="lupasaya" class="form-check-input" />Lupakan saya
              <?php }else{ ?>
                <input type="checkbox" name="ingatsaya" id="ingatsaya" class="form-check-input" />Ingat saya
              <?php } ?>
              <span class="form-label-description">
                <a href="./">Lupa password !</a>
              </span>
            </label>
          </label>
        </div>
        <div class="form-footer">
          <button type="submit" class="btn btn-primary w-100">Login</button>
        </div>
      </form>
      <div class="text-center text-secondary mt-3">
        Belum punya akun? <a href="./" tabindex="-1">Sign up</a>
      </div>
      <div class="text-center text-secondary mt-1">
        <a href="/" tabindex="-1" title="Kembali ke Halaman depan">Kembali</a>
      </div>
      <!-- <div class="text-center text-primary mt-3">
        <b>Other Apps</b>
        <hr style="width: 25%; display: block;margin:5px auto;">
        <div style="margin-top: 10px;">
          <a href="http://localhost/myifn2" class="tombolbulat">
            <img src="assets/image/bg1.jpg" alt="No Picture" >
          </a>
          <a href="#" class="tombolbulat">
            <img src="assets/image/bg1.jpg" alt="No Picture" >
          </a>
          <a href="#" class="tombolbulat">
            <img src="assets/image/bg1.jpg" alt="No Picture" >
          </a>
        </div>
      </div> -->
    </div>
  </div>
  <div class="col-12 col-lg-6 col-xl-8 d-none d-lg-block">
    <!-- Photo -->
    <div class="bg-cover h-100 min-vh-100 d-flex d-flex-column" style="background-image: url(<?= base_url(); ?>assets/image/bgx.jpg)">
      <div class="text-center w-100 p-4 d-flex d-flex-column" style="background-color: rgba(255,255,255,.25);">
        <div class="w-100 p-4 align-self-lg-center pb-4" style="background-color: rgba(255,255,255,.5);font-size: 24px;">
          Selamat Datang, Pengguna Aplikasi <br>
          <img src="<?= base_url(); ?>assets/image/logosystem3.png" height="190" alt="" class="mt-4">
        </div>
      </div>
    </div>
  </div>
</div>