<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">
          Pending Task <?= $this->session->userdata('ttd'); ?>
        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() ?>" class="btn btn-primary btn-sm" ><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body">
  <div class="container-xl">
    <div class="card">
        <div class="card-header pb-1">
          <label class="col-2 col-form-label font-bold">Pending Task</label>
          <div class="col">
            <div class="input-group">
            <select class="form-select bg-success font-bold" id="taskmode">
              <option value="pb" <?php if($this->session->userdata('modetask')=='pb'){echo 'selected'; } ?>>PB (Permintaan Barang)</option>
              <option value="bbl" <?php if($this->session->userdata('modetask')=='bbl'){echo 'selected'; } ?>>BBL (Bon Permintaan Pembelian)</option>
            </select>
            <button class="btn font-kecil font-bold btn-flat" id="gettask" type="button">Get !</button>
            </div>
          </div>
        </div>
        <div class="card-body pt-1">
            <table id="tabel" class="table nowrap order-column table-hover datatable7" style="width: 100% !important;">
                <thead>
                  <tr>
                    <th>Tgl</th>
                    <th>Nomor Bon Pembelian</th>
                    <th>P</th>
                    <th>Sv</th>
                    <th>Dept</th>
                    <th>Keterangan</th>
                    <th>Dibuat Oleh</th>
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">
                  <?php foreach ($data->result_array() as $datpb) { 
                    if($this->session->userdata('modetask')=='pb'){
                      $viewdetail = base_url().'pb/viewdetailpb/'.$datpb['id'];
                      $btnok = base_url().'task/validasipb/'.$datpb['id'];
                      $btnno = base_url().'task/cancelpb/'.$datpb['id'];
                    }else{
                      $viewdetail = base_url().'bbl/viewdetail_bbl/'.$datpb['id'].'/'.$this->session->userdata('ttd');
                      $btnok = base_url().'task/validasibbl/'.$datpb['id'].'/'.$this->session->userdata('ttd');
                      $btnedit = base_url().'task/editbbl/'.$datpb['id'].'/'.$this->session->userdata('ttd');
                      $btnno = base_url().'task/cancelbbl/'.$datpb['id'].'/'.$this->session->userdata('ttd');
                      $btneditapprover = base_url().'task/editapprovebbl/'.$datpb['id'].'/'.$this->session->userdata('ttd');
                    }
                    ?>
                    <tr>
                      <td><?= tglmysql($datpb['tgl']); ?></td>
                      <td><a href="<?= $viewdetail ?>" data-bs-toggle="offcanvas" data-bs-target="#canvasdet" data-title="View detail"><?= $datpb['nomor_dok']; ?></a></td>
                      <td class="font-bold font-kecil"><?php if($datpb['bbl_pp']==1){ echo "P";} ?></td>
                      <td class="font-bold font-kecil"><?php if($datpb['bbl_sv']==1){ echo "Sv";} ?></td>
                      <td class="font-bold font-kecil"><?= $datpb['dept_bbl']; ?></td>
                      <td><?= $datpb['keterangan']; ?></td>
                      <td style="line-height: 13px;"><?= datauser($datpb['user_ok'],'name'); ?><br><span style="font-size: 10px;"><?= $datpb['tgl_ok'] ?></span></td>
                      <td class="text-center">
                        <?php if($this->session->userdata('ttd')==2 && $this->session->userdata('modetask')=='bbl'){ ?>
                        <a href="#" style="padding: 5px !important" data-bs-target="#modal-info" 
                        data-message="Anda yakin akan edit bon <br><?= $datpb['nomor_dok']; ?> ?" 
                        data-href="<?= $btnedit ?>"
                        data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-primary">Edit Qty</a>
                        <?php }elseif($this->session->userdata('ttd')==3 && $this->session->userdata('modetask')=='bbl'){ ?>
                        <a href="#" style="padding: 5px !important" data-bs-target="#modal-info" 
                        data-message="Anda yakin akan edit Approver bon <br><?= $datpb['nomor_dok']; ?> ?" 
                        data-href="<?= $btneditapprover ?>"
                        data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-primary">Edit</a>
                        <?php } ?>
                        <a href="#" style="padding: 5px !important" data-bs-target="#modal-info" 
                        data-message="Anda yakin akan validasi bon <br><?= $datpb['nomor_dok']; ?>" 
                        data-href="<?= $btnok ?>"
                        data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-info">Approve</a>
                        <a href="#" style="padding: 5px !important" data-bs-target="#modal-danger" 
                        data-message="Anda yakin akan membatalkan bon <br><?= $datpb['nomor_dok']; ?>" 
                        data-href="<?= $btnno ?>"
                        data-tombol="Ya"
                        data data-bs-toggle="modal" data-title="Validasi Bon" class="btn btn-sm btn-danger">Cancel</a>
                      </td>
                    </tr>
                  <?php } ?>
                </tbody>
              </table>
        </div>
      </div>
    </div>
  </div>
</div>
        