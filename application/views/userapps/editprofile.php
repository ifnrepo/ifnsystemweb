<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Update Profile
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() ?>" class="btn btn-warning btn-sm text-black"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="card">
      <div class="card-body font-kecil">
        <div class="row">
          <form onkeydown="return event.key != 'Enter';" action="<?= base_url().'userapps/updateprofile' ?>" method="post" enctype="multipart/form-data">
          <div class="col-6 col-xs-12">
            <h2 class="mb-3">My Profile</h2>
            <div class="mb-1 row">
              <label class="col-3 col-form-label">Nama</label>
              <div class="col">
                <input type="text" class="form-control font-kecil hilang" name="id" id="id" placeholder="Nama" value="<?= $user['id']; ?>">
                <input type="text" class="form-control font-kecil" name="name" id="name" placeholder="Nama" value="<?= $user['name']; ?>">
              </div>
            </div>
            <div class="mb-1 row">
              <label class="col-3 col-form-label">Email</label>
              <div class="col">
                <input type="text" class="form-control font-kecil" name="email" id="email" placeholder="Email" value="<?= $user['email']; ?>">
              </div>
            </div>
            <div class="mb-1 row">
              <label class="col-3 col-form-label">Telp/WA</label>
              <div class="col">
                <input type="text" class="form-control font-kecil" name="telp" id="telp" placeholder="Telp" value="<?= $user['telp']; ?>">
              </div>
            </div>
            <hr class="m-0">
            <div class="mb-1 row mt-1">
              <label class="col-3 col-form-label required">Username</label>
              <div class="col">
                <input type="text" class="form-control font-kecil" name="username" id="username" placeholder="Username" value="<?= $user['username']; ?>" autocomplete="off">
              </div>
            </div>
            <div class="mb-2 row mt-1">
              <label class="col-3 col-form-label required">Password</label>
              <div class="col">
                <input type="text" class="form-control font-kecil" name="password" id="password" placeholder="Password" value="<?= decrypto($user['password']); ?>" autocomplete="off">
              </div>
            </div>
            <h2 class="mb-3">Profile Picture</h2>
            <div class="row align-items-center">
              <div class="col-auto">
                <img class="avatar avatar-xl" src="<?php if ($user['foto'] != null && trim($user['foto']) != '') {
                                                                        echo base_url().'assets/image/personil/' . $user['foto'];
                                                                    } else {
                                                                        echo base_url().'assets/image/avatars/005f.jpg';
                                                                    } ?>" id="foto" alt="Gambar Foto">
              </div>
              <div class="col-auto"><a href="#" id="pilihgambaruser" class="btn btn-sm">
                  Change Picture
                </a>
              </div>
              <!-- <div class="col-auto"><a href="#" class="btn btn-sm btn-ghost-danger">
                  Delete Picture
                </a>
              </div> -->

              <input type="text" class="form-control flat hilang" name="file_path" id="file_path" autocomplete="off">
              <input type="file" name="dok" id="file" class="hilang" accept=".jpg,.jpeg,.png,.bmp">
              <input type="text" name="old_foto" id="old_foto" value="<?= $user['foto']; ?>" class="hilang">
            </div>
            <hr class="my-1">
            <div class="d-flex justify-content-between">
              <a href="#" class="btn btn-sm btn-link" onclick="return window.location.reload()">Batal</a>
              <button class="btn btn-sm btn-success" type="submit">Simpan Perubahan</button>
            </div>
          </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>