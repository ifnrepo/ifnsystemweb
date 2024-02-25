<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <img src="<?= base_url() ?>assets/img/gambar.png" alt="" width="150" height="100">
            </div>
            <div class="card-body">
                <p class="login-box-msg">Register a new membership <i class="fas fa-fins"></i></p>

                <form action="<?= base_url('auth/registration'); ?>" method="post">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-user" id="name" name="name" placeholder="Full name" value="<?= set_value('name'); ?>">
                        <!-- membuat alert error untuk name yang tdak di isi -->
                        <?= form_error('name', '<small class="text-danger pl-2">', '</small>'); ?>

                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control form-control-user" id="username" name="username" placeholder="username" value="<?= set_value('username'); ?>">
                        <?= form_error('username', '<small class="text-danger pl-2">', '</small>'); ?>
                        <div class=" input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control form-control-user" id="password1" name="password1" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <?= form_error('password1', '<small class="text-danger pl-2">', '</small>'); ?>

                    <div class="input-group mb-3">
                        <input type="password" class="form-control form-control-user" id="password2" name="password2" placeholder="Repeat Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
            </div>

            <!-- /.col -->
            <div class="col-12">
                <center>
                    <button type="submit" class="btn btn-primary btn-block ">Register</button>
                </center>
            </div>
            </form>
            <hr>
            <a href="<?= base_url('auth') ?>" class="text-center">Akun Anda Sudah Terdaftar, Klik Disini Untuk Login !</a>
        </div>
        <!-- /.form-box -->
    </div><!-- /.card -->
    </div>