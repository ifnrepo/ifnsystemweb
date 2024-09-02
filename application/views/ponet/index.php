<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!-- <style>
    .page-header {
        margin-bottom: 30px;
        background-color: white;
        color: #0056b3;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-direction: column;
        text-align: center;

    }

    .card {
        border-radius: 20px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        margin-top: 20px;
        position: relative;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.9);
        padding: 10px;
    }

    .header {
        display: flex;
        flex-direction: column;

        gap: 20px;
        align-items: stretch;
    }

    .filter {
        border: 1px solid #0056b3;
        padding: 10px;
        border-radius: 5%;
        margin-bottom: 20px;
    }

    .filter label {
        color: black;
        text-align: center;
        font-style: italic;
        /* text-shadow: 1px 1px 1px black; */
    }

    .filter .form-control {
        box-shadow: 1px 1px 1px gray;

    }

    .filter .button-group {
        margin: 5px auto;
        padding: 10px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;

    }

    .main {
        padding: 10px;
    }

    .content-header {
        /* border: 1px solid gray; */
        border-radius: 10px;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.8);

    }

    .content-header-detail {
        /* border: 1px solid gray; */
        width: 70%;
        border-radius: 10px;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.8);

    }


    @media (min-width: 768px) {
        .page-header {
            flex-direction: row;
            text-align: left;

        }

        .header {
            flex-direction: row;

            align-items: flex-start;
        }

        .filter {
            width: 30%;
            margin-bottom: 0;

        }

        .content-header {
            flex: 2;
        }


    }

    @media (min-width: 992px) {
        .header {
            gap: 30px;

        }

        .filter {
            width: 25%;

        }
    }
</style> -->
<style>
    .filter {
        border: 2px solid grey;
        padding: 10px;
        border-radius: 2%;
        margin: 20px auto;
    }

    .filter label {
        color: black;
        text-align: center;
        font-style: italic;
    }

    .filter,
    .form-control,
    .form-select {
        box-shadow: 1px 1px 1px gray;
    }

    .filter .button-group {
        margin: 5px auto;
        padding: 10px;
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;

    }

    .content-header {
        /* border: 1px solid gray; */
        border-radius: 10px;
        padding: 10px;
        background-color: rgba(255, 255, 255, 0.8);

    }
</style>

<div class="page-header d-print-none">
    <div class="container-xl d-flex justify-content-between">
        <h2 class="page-title p-2">
            Sistem Informasi PO
        </h2>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="header">
                    <div class="filter" style="width: 400px;">
                        <form action="" method="post">
                            <div class="mb-3">
                                <label class="form-label" style="text-align: center;">CARI DATA PO/BUYER</label>
                                <input class="form-control" name="keyword" placeholder="xxxxxx" value="<?= isset($_POST['keyword']) ? htmlspecialchars($_POST['keyword']) : '' ?>">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pilih Kategori</label>
                                <select class="form-select" name="kategori" aria-label="Default select example">
                                    <option value="1" <?= isset($_POST['kategori']) && $_POST['kategori'] == '1' ? 'selected' : '' ?>><b>PO</b></option>
                                    <option value="2" <?= isset($_POST['kategori']) && $_POST['kategori'] == '2' ? 'selected' : '' ?>><b>BUYER</b></option>
                                </select>
                                <div class="mb-2" style=" margin-top: 10px ; margin-right: 350px; width : 100px ; ">
                                    <label class="form-check">
                                        <label class="form-label" style="color: #1877f2;">
                                            <input class="form-check-input" type="checkbox" name="checked" value="1" checked> po aktiv
                                        </label>
                                    </label>
                                </div>
                            </div>
                            <div class="button-group">
                                <button type="submit" class="btn btn-info">Cari Data</button>
                                <a href="<?= base_url('ponet'); ?>" class="btn btn-sm btn-red btn-icon text-white" title="Bersihkan data">
                                    Bersihkan
                                </a>
                            </div>
                        </form>
                    </div>
                    <div class="content-header">
                        <div class="card-body">
                            <div id="table-default" class="table-responsive">
                                <?php if (!empty($po)) : ?>
                                    <table class="table datatable">
                                        <thead>
                                            <tr>
                                                <th class="tp-3 mb-2 bg-primary text-left text-white">PO</th>
                                                <th class="tp-3 mb-2 bg-primary text-center text-white">ITEM</th>
                                                <th class="tp-3 mb-2 bg-primary text-center text-white">DIS</th>
                                                <th class="tp-3 mb-2 bg-primary text-center text-white">BUYER</th>
                                                <th class="tp-3 mb-2 bg-primary text-center text-white">DT</th>
                                                <th class="tp-3 mb-2 bg-primary text-center text-white">OUTS</th>
                                                <th class="tp-3 mb-2 bg-primary text-right text-white">KGS</th>
                                                <th class="tp-3 mb-2 bg-primary text-center text-white">AKSI</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-tbody" style="font-size: 13px !important;">
                                            <?php
                                            $total = 0;
                                            foreach ($po as $key) :
                                                $kgs = 0;
                                                if ($key['outstand'] > 0) {
                                                    if ($key['st_piece'] == 'KGS') {
                                                        $kgs = $key['outstand'];
                                                    } elseif ($key['st_piece'] == 'LBS') {
                                                        $kgs = $key['outstand'] * 0.454;
                                                    } elseif ($key['st_piece'] != 'LBS' && $key['st_piece'] != 'KGS') {
                                                        $kgs = $key['weight'] * $key['outstand'];
                                                    }
                                                }
                                                $total += $kgs;
                                            ?>
                                                <tr>
                                                    <td class="text-left"><?= $key['po']; ?></td>
                                                    <td class="text-center"><?= $key['item']; ?></td>
                                                    <td class="text-center"><?= $key['dis']; ?></td>
                                                    <td class="text-center"><?= $key['nama_customer']; ?></td>
                                                    <td class="text-center" style="color: red;"><?= $key['lim']; ?></td>
                                                    <td class="text-center"><?= rupiah($key['outstand'], 2); ?><?= $key['st_piece']; ?></td>
                                                    <td class="text-right"><?= $kgs; ?></td>
                                                    <td class="text-center">
                                                        <a href="<?= base_url() . 'ponet/view/' . $key['po_id']; ?>" class="btn btn-sm btn-secondary btn-icon" id="edituser" rel="<?= $key['po_id']; ?>" title="View data" data-bs-toggle="modal" data-bs-target="#modal-scroll" data-title="Detail Data PO">
                                                            <i class="fa fa-search"></i>
                                                        </a>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <td colspan="6" style="color: #0054a6;"><strong>TOTAL</strong></td>
                                                <td class="tp-3 mb-2 bg-secondary text-right">
                                                    <b style="color: white;">
                                                        <?= rupiah($total, 2); ?> KGS
                                                    </b>
                                                </td>
                                                <td></td>
                                            </tr>
                                        </tfoot>
                                    </table>
                                <?php else : ?>
                                    <center>
                                        <p style="font-style: italic; color:red; font-size:25px; text-shadow: 1px 1px 1px black ;">
                                            Isi Data PO/BUYER !</p>
                                    </center>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="main">
                <div class="content-header-detail">
                    <div id="detail-container">
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <script src="<?= base_url(); ?>assets/js/jquery-3.7.1.js"></script>
<script>
    $(document).ready(function() {
        $('.btn-view-detail').click(function(e) {
            e.preventDefault();
            var detailUrl = $(this).attr('href');

            $.ajax({
                url: detailUrl,
                type: 'GET',
                success: function(response) {
                    $('#detail-container').html(response); 
                },
                error: function() {
                    alert('Terjadi kesalahan saat mengambil data detail.');
                }
            });
        });
    });
</script> -->