  <div class="container-xl">
    <div class="card">
      <div class="col-md-3">

      </div>
      <!-- <hr class="p-1 m-1"> -->
      <div class="card-body pt-1 pb-1" style="overflow: auto;">
        <?php if(!empty(trim($data['filepdf']))){ ?>
            <iframe src="<?= LOK_DOK_MESIN.trim($data['filepdf']); ?>" style="width:100%;height:700px;" alt="Tidak ditemukan"></iframe>
        <?php }else{ ?>
            <div class="text-center font-bold m-0"><h3>BELUM ADA DOKUMEN</h3></div>
        <?php } ?>
         <!-- <object data="test.pdf" type="application/pdf" width="100%" height="700">
            alt : <a href="test.pdf">test.pdf</a>
        </object> -->
      </div>
    </div>
  </div>