<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none m-2">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Detail Kontrak Makloon
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url().'kontrak'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-0">
  <div class="container-xl">
    <div class="sticky-top card">
      <div class="card-body">
        <form method="post" action="<?= base_url() . 'kontrak/simpankontrak'; ?>" name="formkontrak" id="formkontrak">
        <div class="row">
            <div class="col-sm-6 font-kecil">
              <input type="text" id="id" class="hilang" name="id" value="<?= $data['id']; ?>">
              <input type="text" id="mode" class="hilang" name="mode" value="<?= $mode; ?>">
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Nomor Kontrak</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat font-bold" data-mask="<?= $data['nomor']; ?>" value="<?= $data['nomor']; ?>"  data-mask-visible="true" title="Nomor Kontrak" placeholder="000" autocomplete="off" name="nomor" id="nomor" placeholder="Nomor Kontrak">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Proses</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" name="proses" id="proses" title="Nama Proses" value="<?= $data['proses']; ?>" placeholder="Nama Proses">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Tgl Awal</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat tglmode" name="tgl_awal" id="tgl_awal" value="<?= tglmysql($data['tgl_awal']); ?>" title="Tgl Awal" placeholder="Tgl Awal Kontrak">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Tgl Berakhir</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat tglmode" name="tgl_akhir" id="tgl_akhir" value="<?= tglmysql($data['tgl_akhir']); ?>" title="Tgl Akhir" placeholder="Tgl Akhir Kontrak">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Qty Kontrak</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" name="pcs" id="pcs" title="Pcs" value="<?= rupiah($data['pcs'],0); ?>"  placeholder="Qty Kontrak">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Kgs Kontrak</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat inputangka text-right" name="kgs" id="kgs" title="Kgs" value="<?= rupiah($data['kgs'],2); ?>" placeholder="Kgs Kontrak">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">SSB</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat tglmode" name="tgl_ssb" id="tgl_ssb" value="<?= tglmysql($data['tgl_ssb']); ?>" title="Tgl SSB" placeholder="Tgl SSB">
                </div>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" name="nomor_ssb" id="nomor_ssb" value="<?= $data['nomor_ssb']; ?>" title="Nomor SSB" placeholder="Nomor SSB">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Jumlah SSB</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" name="jml_ssb" id="jml_ssb" title="Jumlah SSB" value="<?= rupiah($data['jml_ssb'],2); ?>" placeholder="Jumlah SSB">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">BPJ</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat tglmode" name="tgl_bpj" id="tgl_bpj" value="<?= tglmysql($data['tgl_bpj']); ?>" title="Tgl BPJ" placeholder="Tgl BPJ">
                </div>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" name="nomor_bpj" id="nomor_bpj" title="Nomor BPJ" value="<?= $data['nomor_bpj']; ?>" placeholder="Nomor BPJ">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Tgl Expired</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat tglmode" name="tgl_expired" id="tgl_expired" value="<?= tglmysql($data['tgl_expired']); ?>" title="Tgl Expired" placeholder="Tgl Expired">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Nilai</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-right inputangka " name="bea_masuk" id="bea_masuk" title="Bea Masuk" value="<?= rupiah($data['bea_masuk'],2); ?>" placeholder="Bea Masuk">
                </div>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-right inputangka " name="ppn" id="ppn" title="PPN" value="<?= rupiah($data['ppn'],2); ?>" placeholder="PPN">
                </div>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat text-right inputangka " name="pph" id="pph" title="PPH" value="<?= rupiah($data['pph'],2); ?>" placeholder="PPH">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Surat keputusan</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat tglmode" name="tgl_kep" id="tgl_kep" value="<?= tglmysql($data['tgl_kep']); ?>" title="Tgl Keputusan" placeholder="Tgl Keputusan">
                </div>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" name="nomor_kep" id="nomor_kep" title="Nomor Keputusan" value="<?= $data['nomor_kep']; ?>" placeholder="Nomor Keputusan">
                </div>
              </div>
              <div class="mb-0 row">
                <label class="col-3 col-form-label">Dokumen Lain</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat tglmode" name="tgl_dok_lain" id="tgl_dok_lain" title="Tgl Dokumen Lain" value="<?= tglmysql($data['tgl_dok_lain']); ?>" placeholder="Tgl Dokumen Lain">
                </div>
                <div class="col">
                    <input type="text" class="form-control font-kecil btn-flat" name="nomor_dok_lain" id="nomor_dok_lain" title="Nomor Dokumen Lain" value="<?= $data['nomor_dok_lain']; ?>"  placeholder="Nomor Dokumen Lain">
                </div>
              </div>
            </div>
            <div class="col-sm-6 font-kecil">
              <h5 class="mb-1 bg-blue-lt p-1">Detail Kontrak</h5>
              <div class="hr m-1"></div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">No Tgl Surat</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil btn-flat tglmode" name="tgl_surat" id="tgl_surat" title="Tgl Surat" value="<?= tglmysql($data['tgl_surat']); ?>"  placeholder="Tgl Surat">
                </div>
                <div class="col">
                  <input type="text" class="form-control font-kecil btn-flat" name="nomor_surat" id="nomor_surat" title="Nomor Surat" value="<?= $data['nomor_surat']; ?>"  placeholder="Nomor Surat">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">PIC Indoneptune</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil btn-flat" name="pic" id="pic" title="PIC" value="<?= $data['pic']; ?>" placeholder="PIC Indoneptune">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Jabatan</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil btn-flat" name="jabatan" id="jabatan" value="<?= $data['jabatan']; ?>" title="Jabatan" placeholder="Jabatan">
                </div>
              </div>
              <div class="hr m-1"></div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Bahan</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil btn-flat" name="bahan" id="bahan" value="<?= $data['bahan']; ?>" title="Bahan Makloon" placeholder="Bahan Makloon">
                </div>
              </div>
              <div class="mb-1 row">
                <label class="col-3 col-form-label">Hasil Pekerjaan</label>
                <div class="col">
                  <input type="text" class="form-control font-kecil btn-flat" name="hasil" id="hasil" value="<?= $data['hasil']; ?>" title="Hasil Pekerjaan" placeholder="Hasil Pekerjaan">
                </div>
              </div>
              <div class="hr m-1"></div>
              <h5 class="bg-blue-lt p-1 mb-1">Spesifikasi</h5>
              <div class="text-right m-2">
                <a class="bg-success p-1 font-bold text-black" href="<?= base_url() . 'kontrak/adddetail/'.$data['id']; ?>" data-bs-toggle="modal" data-bs-target="#modal-large" data-title="Add Detail Kontrak"><i class="fa fa-plus text-white"></i> Add Spec</a>
              </div>
              <table id="detkontrak" class="table mt-1">
                <thead>
                  <tr>
                    <th>Kategori</th>
                    <th>Uraian</th>
                    <th class="text-start">HS Code</th>
                    <th>Pcs</th>
                    <th>Kgs</th>
                    <th class="text-center">Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                  </tbody>
                </table> 
              </div>
            </div>
          </div>
        </form>
        <div class="hr m-1 mt-0"></div>
        <div class="p-2 text-center">
          <a href="#" class="btn btn-sm btn-flat btn-success" id="simpandata">Simpan Data</a>
          <a href="#" class="btn btn-sm btn-flat btn-danger" id="resetdata">Reset</a>
        </div>
    </div>
  </div>
</div>