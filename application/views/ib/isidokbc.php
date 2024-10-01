<div class="container-xl"> 
    <div class="m-2 font-bold d-flex justify-content-between">Daftar Barang <span><a href="#" id="keexcel" class="btn btn-sm btn-success"><i class="fa fa-file-excel-o mr-1"></i> Excel CEISA 4.0</a></span></div>
    <input type="hidden" name="id_header" id="id_header" value="<?= $datheader; ?>">
    <table class="table datatable6 table-hover mb-3" id="cobasisip">
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
    <div class="bg-teal-lt p-3">
        <div class="mb-1 mt-3 row">
            <label class="col-3 col-form-label font-kecil required">Jenis DOK BC</label>
            <div class="col font-kecil">
                <select class="form-select font-kecil font-bold" name="jns_bc" id="jns_bc">
                    <option value="">Pilih Jenis BC</option>
                    <?php foreach ($bcmasuk->result_array() as $bcmas) { ?>
                        <option value="<?= $bcmas['jns_bc']; ?>"><?= $bcmas['ket_bc']; ?></option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label font-kecil required">No/Tgl AJU</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" id="nomor_aju" name="nomor_aju" aria-describedby="emailHelp" placeholder="No AJU">
            </div>
            <div class="col">
                <input type="text" class="form-control font-kecil tgl" id="tgl_aju" name="tgl_aju" aria-describedby="emailHelp" placeholder="Tgl AJU">
            </div>
        </div>
        <div class="mb-1 row">
            <label class="col-3 col-form-label font-kecil">No/Tgl BC</label>
            <div class="col">
                <input type="text" class="form-control font-kecil" id="nomor_bc" name="nomor_bc" aria-describedby="emailHelp" placeholder="No AJU">
            </div>
            <div class="col">
                <input type="text" class="form-control font-kecil tgl" id="tgl_bc" name="tgl_bc" aria-describedby="emailHelp" placeholder="Tgl AJU">
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-link link-secondary me-auto" data-bs-dismiss="modal">Batal</button>
        <span class="text-red" style="font-size: 12px !important;" id="keteranganerr"></span>
        <a class="btn btn-sm btn-primary" style="color: white;" id="simpanhakbc">Simpan</a>
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
        $(".tgl").datepicker({
            autoclose: true,
            format : "dd-mm-yyyy",
            todayHighlight: true
        });
    })
    $("#keexcel").click(function(){
        if($("#jns_bc").val() == '' || $("#nomor_aju").val() == '' || $("#tgl_aju").val() == ''){
            pesan('Isi dahulu jenis BC serta nomor/tgl Aju !','error');
            return false;
        }
    });
    $("#simpanhakbc").click(function(){
        if($("#jns_bc").val() == ''){
            $("#keteranganerr").text('Pilih Jenis BC !');
            return false;
        }
        if($("#nomor_aju").val() == '' || $("#tgl_aju").val() == ''){
            $("#keteranganerr").text('isi Nomor Aju dan Tanggal Aju !');
            return false;
        }
        if($("#nomor_bc").val() == '' || $("#tgl_bc").val() == ''){
            $("#keteranganerr").text('isi Nomor BC dan Tanggal BC !');
            return false;
        }
        $.ajax({
            dataType: "json",
            type: "POST",
            url: base_url+'ib/simpandatanobc',
            data: {
                id: $("#id_header").val(),
                jns: $("#jns_bc").val(),
                aju: $("#nomor_aju").val(),
                tglaju: $("#tgl_aju").val(),
                bc: $("#nomor_bc").val(),
                tglbc: $("#tgl_bc").val(),
            },
            success: function(data){
                window.location.reload();
            },
            error: function (xhr, ajaxOptions, thrownError) {
                console.log(xhr.status);
                console.log(thrownError);
            }
        })
    })
</script>