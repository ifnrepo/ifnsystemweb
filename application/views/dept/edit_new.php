<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Edit Departemen
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'dept' ?>" class="btn btn-warning btn-sm text-black"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
      <div class="card-body font-kecil">
        <form method="POST" action="<?= $action; ?>" id="formatedit" name="formatedit">
          <div class="row">
            <div class="col-sm-6">
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kode Dept</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil hilang" name="urut" id="urut" placeholder="urut" value="<?= $data['urut']; ?>">
                  <input type="text" class="form-control font-kecil" name="dept_id" id="dept_id" placeholder="dept_id" value="<?= $data['dept_id']; ?>">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Nama Dept</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil" name="departemen" id="departemen" placeholder="departemen" value="<?= $data['departemen']; ?>">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kategori Dept</label>
                <div class="col">
                  <select name="katedept_id" id="katedept_id" class="form-control">
                    <option value="">Pilih Kategori</option>
                    <?php foreach ($katedept as $a) : $selek = $a['id']==$data['katedept_id'] ? 'Selected' : ''; ?>
                      <option value="<?= $a['id']; ?>" <?= $selek; ?>><?= $a['nama']; ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
              </div>
              <div class="hr m-0"></div>
            <div class="mt-1 row">
                <label class="col-3 col-form-label"></label>
                <div class="col">
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="pb" id="pb" type="checkbox" <?php if($data['pb']=='1'){ echo "checked"; } ?> >
                        <span class="form-check-label">Bon Permintaan Barang / <strong>PB</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="bbl" id="bbl" type="checkbox" <?php if($data['bbl']=='1'){ echo "checked"; } ?>>
                        <span class="form-check-label">Bon Pembelian Barang / <strong>BBL</strong></span>
                    </label>
                    <label class="form-check mt-1 mb-1">
                        <input class="form-check-input" name="adj" id="adj" type="checkbox" <?php if($data['adj']=='1'){ echo "checked"; } ?> >
                        <span class="form-check-label">Bon Adjustment / <strong>ADJ</strong></span>
                    </label>
                </div>
            </div>
              <div class="hr mt-2 mb-1"></div>
              <div class="card-body pt-2">
                <div class="row">
                  <div class="col"><a href="<?= base_url() . 'dept/edit_new/' . $data['dept_id']; ?>" class="btn btn-danger btn-sm w-100">
                      <i class="fa fa-refresh mr-1"></i>
                      Reset
                    </a></div>
                  <div class="col"><a class="btn btn-primary btn-sm w-100 text-white" id="editdept">
                      <i class="fa fa-save mr-1"></i>
                      Update
                    </a></div>
                </div>
              </div>
            </div>
            <div class="col-sm-6">
              <h4>Akses Pengeluaran dan Penerimaan</h4>
              <div class="row row-cards">
                <div class="col">
                  <div class="card">
                    <div class="card-header">
                      <ul class="nav nav-tabs card-header-tabs" data-bs-toggle="tabs">
                        <li class="nav-item">
                          <a href="#tabs-pengeluaran-1" class="nav-link active" data-bs-toggle="tab">Pengeluaran</a>
                        </li>
                        <li class="nav-item">
                          <a href="#tabs-penerimaan-1" class="nav-link" data-bs-toggle="tab">Penerimaan</a>
                        </li>
                      </ul>
                    </div>
                    <div class="card-body">
                      <div class="tab-content">
                        <div class="tab-pane active show" id="tabs-pengeluaran-1">
                          <div class="row">
                          <div class="col-6">
                              <?php $no = 0;
                              // $jml = $jmldept;
                              foreach ($departemen as $dept) : $no++; ?>
                                <label class="form-check mb-1">
                                  <input class="form-check-input" id="<?= $dept['dept_id']; ?>" name="<?= $dept['dept_id']; ?>" type="checkbox" <?= cekceklisdep($data['pengeluaran'], $dept['dept_id']); ?>>
                                  <span class="form-check-label"><?= $dept['departemen']; ?></span>
                                </label>
                              <?php endforeach; ?>
                            </div>
                          </div>
                        </div>

                        <div class="tab-pane " id="tabs-penerimaan-1">
                          <div class="row">
                            <div class="col">
                            <div class="col-6">
                              <?php $no = 0;
                              // $jml = $jmldept;
                              foreach ($departemen as $dept) : $no++; ?>
                                <label class="form-check mb-1">
                                  <input class="form-check-input" id="<?= $dept['dept_id']; ?>" name="<?= $dept['dept_id']; ?>" type="checkbox" <?= cekceklisdep($data['penerimaan'], $dept['dept_id']); ?>>
                                  <span class="form-check-label"><?= $dept['departemen']; ?></span>
                                </label>
                              <?php endforeach; ?>
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
        </form>
      </div>
    </div>
  </div>
</div>