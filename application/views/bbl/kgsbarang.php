<div class="container-xl">
    <div class="row font-kecil">
        <div class="col-12">
            <div class="mb-1 row">
                <input type="hidden" id="id" value="<?= $barang['id']; ?>">
                <input type="hidden" id="id_satuan" value="<?= $barang['id_satuan']; ?>">
                <label class="col-3 col-form-label required font-kecil">Nama Barang</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil inputangka" name="keyw" id="keyw" value="<?= $barang['nama_barang']; ?>" placeholder="Cari Nama Barang..">
                    <!-- <a href="#" class="btn font-kecil bg-success text-white" id="getbarang">Get!</a> -->
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">jumlah</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="pcs" id="pcs" value="" autocomplete="off">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Kgs</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="kgs" id="kgs" value="" autocomplete="off">
                </div>
            </div>
            <div class="mb-1 row">
                <label class="col-3 col-form-label required">Ket</label>
                <div class="col">
                    <input type="text" class="form-control font-kecil" name="keterangan" id="keterangan" value="" autocomplete="off">
                </div>
            </div>
            <div class="hr m-1"></div>
        </div>
    </div>
</div>
<div class="modal-footer">
    <a href="#" class="btn btn-sm float-right" data-bs-dismiss="modal">Batal/Keluar</a>
    <a href="#" class="btn btn-sm btn-primary" id="simpanbarang">Simpan</a>
</div>


<script>
    $(document).ready(function() {
        // $('#modal-scroll').on('shown.bs.modal', function() {
        //     // $('#textareaID').focus();
        //     $("#keyw").focus();
        // })
        // $("#keyw").val($("#nomor_dok").val());
        // if ($("#keyw").val() != '') {
        //     $("#getbarang").click();
        // }
        // $("#getbarang").click();
        // $("#deptselect").val($("#xdeptselect").val());
    });
    // $("#deptselect").change(function(){
    //     $("#getbarang").click();
    // })
    // $("#keyw").on('keyup', function(e) {
    //     if (e.key === 'Enter' || e.keyCode === 13) {
    //         $("#getbarang").click();
    //     }
    // });
    $("#simpanbarang").click(function(){
        if(($("#pcs").val()==0 || $("#pcs").val()=='') && ($("#kgs").val()==0 || $("#kgs").val()=='')){
            pesan('Isi data Pcs/Qty','info');
            return false;
        }
        if($("#keterangan").val()==''){
            pesan('Harap Isi Keterangan','info');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: '<?= base_url('bbl/simpanbarang') ?>',
            data: {
                seri: $("#numdetail").val(),
                id: $("#id").val(),
                id_satuan : $("#id_satuan").val(),
                pcs: $("#pcs").val(),
                kgs: $("#kgs").val(),
                kete: $("#keterangan").val(),
                header: $("#id_header").val()
            },
            success: function(data) {
                console.log(data); // Log data yang diterima
                // alert(data);
                if (data==1) {
                    window.location.reload();
                } else {
                    alert('Tidak ada data yang ditemukan');
                    $("#body-table").html('').hide();
                }
            },
            error: function(xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        });
    })

    // $("#getbarang").click(function() {
    //     if($("#keyw").val()==''){
    //         pesan('Isi dulu Keyword pencarian ','info');
    //         return false;
    //     }
    //     $.ajax({
    //         dataType: "json",
    //         type: "POST",
    //         url: '<?= base_url('bbl/getbarang') ?>',
    //         data: {
    //             data: $("#keyw").val(),
    //             header: $("#id_header").val()
    //         },
    //         success: function(data) {
    //             console.log(data); // Log data yang diterima
    //             if (data.datagroup) {
    //                 $("#body-table").html(data.datagroup).show();
    //             } else {
    //                 alert('Tidak ada data yang ditemukan');
    //                 $("#body-table").html('').hide();
    //             }
    //         },
    //         error: function(xhr, ajaxOptions, thrownError) {
    //             console.log(xhr.status);
    //             console.log(thrownError);
    //         }
    //     });
    // });
</script>