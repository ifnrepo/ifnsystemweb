<div class="container-xl"> 
    <div class="m-2 font-bold">Daftar Barang </div>
    <table class="table datatable6 table-hover" id="cobasisip">
        <thead style="background-color: blue !important">
            <tr>
                <th>Nama Barang</th>
                <th>Kategori</th>
                <th>Satuan</th>
                <th>Pcs</th>
                <th>Kgs</th>
            </tr>
        </thead>
        <tbody class="table-tbody" id="body-table" style="font-size: 12px !important;" >
            <?php foreach ($header as $data) { ?>
                <tr>
                    <td><?= $data['nama_barang']; ?></td>
                    <td><?= $data['nama_kategori']; ?></td>
                    <td><?= $data['namasatuan']; ?></td>
                    <td><?= rupiah($data['pcs'],2); ?></td>
                    <td><?= rupiah($data['kgs'],2); ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <div class="text-center">
        <input type="hidden" name="id_header" id="id_header" value="<?= $datheader; ?>">
        <div class="m-2 font-bold">Apakah harus menggunakan Dokumen BC ?</div>
        <div class="form-selectgroup mb-0">
            <label class="form-selectgroup-item">
            <input type="radio" name="icons" value="ya" class="form-selectgroup-input">
            <span class="form-selectgroup-label font-bold"><!-- Download SVG icon from http://tabler-icons.io/i/home -->
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-check text-green font-bold"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M5 12l5 5l10 -10" /></svg>
                Ya</span>
            </label>
            <label class="form-selectgroup-item bg-danger-lt">
            <input type="radio" name="icons" value="tidak" class="form-selectgroup-input">
            <span class="form-selectgroup-label font-bold"><!-- Download SVG icon from http://tabler-icons.io/i/user -->
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-x font-bold text-red"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M18 6l-12 12" /><path d="M6 6l12 12" /></svg>
               Tidak</span>
            </label>
        </div>
        <!-- <hr class="m-1"> -->
        <div class="modal-footer">
            <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
            <span class="text-red" style="font-size: 12px !important;" id="keteranganerr"></span>
            <a class="btn btn-sm btn-primary" style="color: white;" id="simpanhakbc">Simpan</a>
        </div>
    </div>
    <div>
    </div>
</div>
<script>
    $(document).ready(function(){
        // $("#keyw").focus();
        // $("#keyw").val($("#nama_barang").val());
        // if($("#keyw").val() != ''){
        //     $("#getbarang").click();
        // }
    })
    $("#simpanhakbc").click(function(){
        var isiradio = $(".form-selectgroup-input:checked").val();
        if(isiradio != undefined){
            var jadiradio = isiradio == 'ya' ? 1 : 0;
            $.ajax({
                dataType: "json",
                type: "POST",
                url: base_url+'ib/simpandatabc',
                data: {
                    mode: jadiradio,
                    head: $("#id_header").val()
                },
                success: function(data){
                    window.location.reload();
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    console.log(xhr.status);
                    console.log(thrownError);
                }
            })
        }else{
            $("#keteranganerr").text('Pilih dahulu dokumen ini perlu DOK BC atau TIDAK ?');
        }
    })
</script>