<div class="page page-center">
    <div class="container container-tight py-4">
        <form class="card card-md" action="<?= base_url('auth/regis'); ?>" method="post">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Create new account</h2>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Full name">
                    <?= form_error('name', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Userame</label>
                    <input type="text" id="username" name="username" class="form-control" placeholder="Full name">
                    <?= form_error('username', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                <div class="mb-3">
                    <label class="form-label">Password</label>
                    <input type="password" class="form-control" id="password1" name="password1" placeholder="Password">
                    <?= form_error('password1', '<small class="text-danger pl-2">', '</small>'); ?>
                </div>
                <div class=" mb-3">
                    <label class="form-label">Repeat Password</label>
                    <input type="password" class="form-control " id="password2" name="password2" placeholder="Repeat Password">
                </div>
                <div class=" mb-3">
                    <select class="form-select" aria-label="Default select example" id="role_id" name="role_id">
                        <option selected>Level User</option>
                        <option value="1">Administrator</option>
                        <option value="2">User Approve</option>
                        <option value="3">User Marker</option>
                    </select>
                </div>
                <div class="mb-3">
                    <div class="form-label">Acces Item</div>
                    <div>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="sales" name="sales">
                            <option value="1">Sales</option>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="purchase" name="purchase">
                            <option value="1">Purchase</option>
                        </label>
                        <label class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" id="iventory" name="iventory">
                            <option value="1">Iventory</option>
                        </label>
                    </div>
                </div>
                <div class="form-footer">
                    <button type="submit" class="btn btn-primary w-100">Create new account</button>
                </div>
            </div>
        </form>
        <div class="text-center text-secondary mt-3">
            Already have account? <a href="./sign-in.html" tabindex="-1">Sign in</a>
        </div>
    </div>
</div>