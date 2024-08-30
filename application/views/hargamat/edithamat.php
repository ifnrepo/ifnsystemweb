<div class="container-xl"> 
    <div class="row font-kecil">
        <div class="col-12 font-kecil">
            <form method="post" action="<?= base_url().'hargamat/updatehamat'; ?>" id="formhamat" name="formhamat">
                <input type="hidden" name="id" id="id_hargamaterial" value="<?= $data['idx']; ?>">
                <div class="mb-2">
                    <label class="form-label font-kecil mb-0 font-bold text-primary">Nama Barang</label>
                    <input type="text" class="form-control font-kecil"  placeholder="Input placeholder" value="<?= $data['nama_barang']; ?>" disabled>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="mb-3">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Tgl IB</label>
                            <input type="text" class="form-control font-kecil"  placeholder="Input placeholder" value="<?= tglmysql($data['tgl']); ?>" disabled>
                        </div>
                    </div>
                    <div class="col-8">
                        <div class="mb-3">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Nomor IB</label>
                            <input type="text" class="form-control font-kecil" placeholder="Input placeholder" value="<?= $data['nobontr']; ?>" disabled>
                        </div>
                    </div>
                </div>
                <div class="mb-2">
                    <label class="form-label font-kecil mb-0 font-bold text-primary">Kategori Barang</label>
                    <input type="text" class="form-control font-kecil" placeholder="Input placeholder" value="<?= $data['nama_kategori']; ?>" disabled>
                </div>
                <div class="mb-2">
                    <label class="form-label font-kecil mb-0 font-bold text-primary">Supplier</label>
                    <input type="text" class="form-control font-kecil" value="<?= $data['nama_supplier']; ?>" disabled>
                </div>
                <div class="row">
                    <div class="col-2">
                        <div class="mb-3">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Currency</label>
                            <input type="text" class="form-control font-kecil" name="mt_uang" placeholder="Input placeholder" value="<?= $data['mt_uang']; ?>" disabled>
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="mb-3">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Kurs</label>
                            <input type="text" class="form-control font-kecil text-end" name="kurs" placeholder="Input placeholder" value="<?= rupiah($data['kurs'],2); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Qty</label>
                            <input type="text" class="form-control font-kecil text-end" name="qty" placeholder="Input placeholder" value="<?= rupiah($data['qty'],0); ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Kgs</label>
                            <input type="text" class="form-control font-kecil text-end" name="weight" placeholder="Input placeholder" value="<?= rupiah($data['weight'],2); ?>">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Harga</label>
                            <input type="text" class="form-control font-kecil text-end" name="price" placeholder="Input placeholder" value="<?= rupiah($data['price'],8); ?>">
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <label class="form-label font-kecil mb-0 font-bold text-primary">Harga Lainnya</label>
                            <input type="text" class="form-control font-kecil text-end inputangka" name="oth_amount" placeholder="Input placeholder" value="<?= rupiah($data['oth_amount'],2); ?>">
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<div class="modal-footer font-kecil" style="display: flex;justify-content: space-between;">
    <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal">Close</a>
    <button type="button" class="btn btn-sm btn-primary" id="simpanbarang" >Simpan</button>
</div>
<script>
    $(document).ready(function(){
        $("#nama_barang").focus();
    })
    $(".inputangka").on("change click keyup input paste", function (event) {
        $(this).val(function (index, value) {
            return value
                .replace(/(?!\.)\D/g, "")
                .replace(/(?<=\..*)\./g, "")
                .replace(/(?<=\.\d\d).*/g, "")
                .replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        });
    });
    $("#simpanbarang").click(function(){
        document.formhamat.submit();
    })
</script>