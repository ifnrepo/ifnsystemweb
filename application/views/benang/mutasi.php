<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="page-header d-print-none">
  <div class="container-xl">
    <div class="row g-0 d-flex align-items-between">
      <div class="col-md-6">
        <h2 class="page-title p-2">

        </h2>
      </div>
      <div class="col-md-6" style="text-align: right;">
        <a href="<?= base_url() . 'benang'; ?>" class="btn btn-primary btn-sm"><i class="fa fa-arrow-left"></i><span class="ml-1">Kembali</span></a>
      </div>
    </div>
  </div>
</div>
<div class="page-body mt-1">
  <div class="container-xl">
    <div class="card">
      <div class="card-body">
        <div id="sisipkan">
          <div class="mb-1">
          </div>
          <div class="card card-active" style="clear:both;">
            <div class="row">
              <div class="col-md-6">
                <h2 class="page-title p-2">
                  <div>PB (Permintaan Benang) <br><span class="title-dok"><?= $data['nomor_dok']; ?></span></div>
                </h2>
              </div>
              <div class="col-md-6" style="text-align: right;">

              </div>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-sm-4 mt-2">
            <form method="post" action="<?= base_url() . 'benang/simpandetail/' . $data['id']; ?>">
              <div class="row font-kecil mb-0">
                <label class="col-2 col-form-label font-kecil required">Spec</label>
                <div class="col input-group mb-1">
                  <input type="text" id="id_header" name="id_header" class="hilang" value="<?= $data['id']; ?>">
                  <input type="text" class="form-control font-kecil" id="speck_benang" name="speck_benang" placeholder="Speck Benang">
                </div>
              </div>

              <div class="row font-kecil mb-1">
                <label class="col-2 col-form-label">Ket</label>
                <div class="col">
                  <textarea class="form-control font-kecil" id="keterangan" name="keterangan" placeholder="Keterangan"></textarea>
                </div>
              </div>
              <div class="row">
                <div class="col-6">
                  <button class="btn btn-success" type="submit">Keluarkan Benang</button>
                </div>
              </div>
            </form>

          </div>
          <div class="col-sm-8">
            <div id="table-default" class="table-responsive">
              <table class="table datatable6 table-hover" id="cobasisip">
                <thead style="background-color: blue !important">
                  <tr>
                    <!-- <th>No</th> -->
                    <th>Specific</th>
                    <th>SKU</th>
                    <th>Satuan</th>
                    <!-- <th>Qty</th>
                    <th>Kgs</th>
                    <th>SBL</th> -->
                    <th>Aksi</th>
                  </tr>
                </thead>
                <tbody class="table-tbody" id="body-table" style="font-size: 13px !important;">

                </tbody>
              </table>
            </div>
          </div>
        </div>
        <hr class="m-1">
        <div class="form-tombol mt-1 text-right">
          <input type="text" id="jmlrek" class="hilang">
          <a href="#" class="btn btn-sm btn-primary" id="simpanpbu"><i class="fa fa-save mr-1"></i> Simpan Transaksi</a>
          <button href="#" class="btn btn-sm btn-primary hilang" id="simpanpb" data-bs-toggle="modal" data-bs-target="#modal-info" data-message="Akan menyimpan data ini" data-href="<?= base_url() . 'benang/simpanpb/' . $data['id']; ?>"><i class="fa fa-save mr-1"></i> Simpan Transaksi</button>
          <a href="#" class="btn btn-sm btn-danger"><i class="fa fa-times mr-1"></i> Reset Transaksi</a>
        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?= base_url(); ?>assets/js/vendor/jquery.min.js"></script>
<script src="<?= base_url(); ?>assets/tagify/tagify.min.js"></script>
<script>
  $("#simpanpbu").click(function() {
    if ($("#catat").val() == "") {
      pesan("Isi Catatan PB !", "info");
      return false;
    }
    $("#simpanpb").click();
  });

  function getdatadetailpb() {
    console.log("fungsi getdatadetailpb jalan, id_header:", $("#id_header").val());
    $.ajax({
      dataType: "json",
      type: "POST",
      url: base_url + "benang/getdatadetailpb",
      data: {
        id_header: $("#id_header").val(),
      },
      success: function(data) {
        console.log("respon ajax:", data);
        $("#jmlrek").val(data.jmlrek);
        $("#body-table").html(data.datagroup).show();
        if (data.jmlrek == 0) {
          $("#simpanpbu").addClass("disabled");
        }
      },
      error: function(xhr, ajaxOptions, thrownError) {
        console.log(xhr.status);
        console.log(thrownError);
      },
    });
  }


  $(document).ready(function() {
    getdatadetailpb();
  });
</script>
<script>
  setTimeout(function() {
    var input = document.querySelector("#speck_benang");

    if (!input) {
      console.warn("Input teknisi tidak ditemukan");
      return;
    }


    if (input.tagify) {
      input.tagify.destroy();
    }

    var tagify = new Tagify(input, {
      enforceWhitelist: true,
      tagTextProp: 'label',
      searchBy: ['label'],
      whitelist: [],
      maxTags: 10,
      dropdown: {
        enabled: 1,
        classname: "speck_benang-suggestions",
        maxItems: 30,
      }
    });

    tagify.on("input", function(e) {
      let value = e.detail.value;

      $.ajax({
        url: "<?= base_url('benang/speck'); ?>",
        data: {
          term: value
        },
        success: function(data) {
          try {
            // var list = JSON.parse(data).map(item => ({
            //   barang_id: item.barang_id,
            //   value: item.warna_benang + "|" + item.ukuran_benang,
            //   label: item.warna_benang + "|" + item.ukuran_benang
            // }));

            var list = JSON.parse(data).map(item => {
              let warna = item.warna_benang.replace(/\s+/g, "");
              let ukuran = item.ukuran_benang.replace(/\s+/g, "");

              return {
                barang_id: item.barang_id,
                value: warna + " | " + ukuran,
                label: warna + " | " + ukuran
              };
            });


            tagify.settings.whitelist = list;
            tagify.dropdown.show.call(tagify, value);
          } catch (err) {
            console.error("Error :", err);
          }
        },
        error: function(xhr) {
          console.error("Gagal :", xhr);
        }
      });
    });
  }, 100); // de
</script>