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
        background: url('assets/image/logosystem3.png') no-repeat center center/cover;
        background-size: 20%;
    }

    .page-header img {
        height: 50px;
    }

    .form-group {
        margin-bottom: 1.5rem;
    }

    .mb-2 {
        margin-bottom: 0.5rem;
    }

    .card {
        border-radius: 20px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        margin-top: 20px;
        position: relative;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.0);
        padding: 10px;
    }

    .card-body {
        padding: 10px;
        position: relative;
        z-index: 1;
    }

    .header {
        padding: 10px;
    }

    .header .filter {
        margin-top: 30px;
        width: 260px;
        padding: 5px;
        font-size: 12px;
        float: right;
    }

    .header form {
        display: flex;

    }

    .header .btn {
        font-size: 10px;
    }

    .clear {
        clear: right;
    }

    .main {
        padding: 10px;
    }

    .main .content-header {
        border: 1px solid #007bff;
        margin-bottom: 10px;
    }

    .main .content-1 {
        width: 510px;
        padding: 5px;
        float: right;
        border: 1px solid #007bff;

    }

    .main .content-2 {
        width: 510px;
        padding: 5px;
        float: left;
        border: 1px solid #007bff;

    }

    .col-form-label {
        font-weight: bold;
        color: #007bff;
        font-style: oblique;
    }

    .form-label {
        font-weight: bold;
        color: #007bff;
        font-style: oblique;
        font-size: 12px;

    }

    .form-control {
        border-radius: 10px;
        transition: all 0.5s ease-in-out;
        color: white;
    }

    .input-group-text {
        color: white;
        border-radius: 10px;
    }
</style>
<div class="page-header d-print-none">
    <div class="container-xl d-flex justify-content-between">
        <h2 class="page-title p-2">
            PONET
        </h2>
    </div>
</div>
<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="header">
                    <div class="filter">
                        <form action="" method="post">
                            <div class="col">
                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="cari data">
                            </div>
                            <button type="submit" class="btn btn-primary">Cari PO</button>
                        </form>
                    </div>
                    <div class="label">
                        <form action="" method="post">
                            <div class="col-sm-5">
                                <div class="row">
                                    <div class="col-sm-5">
                                        <img src="<?= base_url('assets/image/label.bmp') ?>" class="img-thumbnail">
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="image" name="uploaded_image">
                                            <label class="custom-file-label" for="image">Choose file...</label>
                                            <div class="invalid-feedback">Example invalid custom file feedback</div>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary">simpan</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <br>
                <div class="clear"></div>

            </div>
            <div class="main">
                <div class="content-header">
                    <form>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="col-3 col-form-label required">Input</label>
                                <div class="col">
                                    <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Input">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-3 col-form-label required">Hikia</label>
                                <div class="col">
                                    <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="In Hikia">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-3 col-form-label required">PO</label>
                                <div class="col">
                                    <input type="text" class="form-control" aria-describedby="emailHelp" placeholder="Terima PO">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-3 col-form-label required">Status</label>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Status">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-3 col-form-label required">Ow</label>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Owner">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-3 col-form-label required"> PO</label>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="PO">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-3 col-form-label required"> Hikia</label>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder=" Hikia">
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-3 col-form-label required">Limit</label>
                                <div class="col">
                                    <input type="text" class="form-control" placeholder="Limit">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="content-1">
                    <form>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Mimi</label>
                                <input type="text" class="form-control" placeholder="Mimi">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Proses DLN</label>
                                <input type="text" class="form-control" placeholder="Proses DLN">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Suki Orohi Meai</label>
                                <input type="email" class="form-control" placeholder="Suki Orohi Meai">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Afki Mesin</label>
                                <input type="text" class="form-control" placeholder="Kakesu">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Kapasitas</label>
                                <input type="text" class="form-control" placeholder="Kapasitas">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Jumlah Lot</label>
                                <input type="text" class="form-control" placeholder="Jumlah Lot">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Berat Jala</label>
                                <input type="text" class="form-control" placeholder="Kgs">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Mimi</label>
                                <input type="text" class="form-control" placeholder="Kgs">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Oth Weight</label>
                                <input type="text" class="form-control" placeholder="Kgs">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Total Berat</label>
                                <input type="text" class="form-control" placeholder="Kgs">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Pengerjaan</label>
                                <input type="text" class="form-control" placeholder="Pengerjaan">
                            </div>
                        </div>
                    </form>
                </div>
                <div class="content-2">
                    <form>
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">BUYER</label>
                                <input type="text" class="form-control" placeholder="Buyer">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">TYPE</label>
                                <input type="text" class="form-control" placeholder="Type">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">MEIA</label>
                                <input type="email" class="form-control" placeholder="Meai">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">KAKESU</label>
                                <input type="text" class="form-control" placeholder="Kakesu">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">COLOR</label>
                                <input type="text" class="form-control" placeholder="Color">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">QTY</label>
                                <input type="text" class="form-control" placeholder="Qty">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">NET TYPE</label>
                                <input type="text" class="form-control" placeholder="Net type">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">CATEGORI</label>
                                <input type="text" class="form-control" placeholder="Categori">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">SPEC</label>
                                <input type="text" class="form-control" placeholder="Spec">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">LABEL INV</label>
                                <input type="text" class="form-control" placeholder="Label Inv">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">LABEL PCK</label>
                                <input type="text" class="form-control" placeholder="Label Pck">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div> -->

<style>
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
        background: url('assets/image/logosystem3.png') no-repeat center center/cover;
        background-size: 20%;
    }



    .mb-2 {
        margin-bottom: 0.5rem;
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

    .card-body {
        padding: 20px;
    }

    .header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        padding: 10px;
    }

    .form-inline {
        display: flex;
        align-items: center;
    }

    .input-group {
        display: flex;
        width: 100%;
    }

    .input-group .form-control {
        flex: 1;
    }

    .input-group-append .btn {
        margin-left: 10px;

    }


    .header .label {
        width: 100%;
        max-width: 600px;
        margin-bottom: 10px;
        order: 1;
    }

    .header form {
        display: flex;
        flex-direction: column;
    }

    .header .btn {
        font-size: 10px;
        transition: background-color 0.3s ease;
    }

    .header .btn:hover {
        background-color: #004494;
    }

    .clear {
        clear: both;
    }

    .main {
        padding: 10px;
    }

    .main .content-header {
        border: 1px solid gray;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: rgba(255, 255, 255, 0.8);
    }

    .main .content-1,
    .main .content-2 {
        width: 100%;
        border: 1px solid gray;
        border-radius: 10px;
        padding: 10px;
        margin-bottom: 10px;
        background-color: rgba(255, 255, 255, 0.8);
    }

    .col-form-label,
    .form-label {
        font-weight: bold;
        color: #007bff;
        font-style: oblique;
    }

    .form-label {
        font-size: 12px;
    }

    .form-control {
        border-radius: 10px;
        transition: all 0.3s ease-in-out;
        color: #333;
        box-shadow: 0 1px 1px rgba(0, 0, 0, .75);
    }

    .input-group-text {
        color: white;
        border-radius: 10px;
        background-color: #007bff;
        border: none;
    }

    /* responsif tabel  */
    @media (min-width: 768px) {
        .header {
            flex-direction: row;
        }

        .header .label {
            order: 1;
        }

        .header .filter {
            order: 2;
            margin-top: 0;
        }

        .main .content-1,
        .main .content-2 {
            width: 48%;
        }

        .main .content-1 {
            float: right;
        }

        .main .content-2 {
            float: left;
        }
    }
</style>

<div class="page-header d-print-none">
    <div class="container-xl d-flex justify-content-between">
        <h2 class="page-title p-2">
            PONET
        </h2>
    </div>
</div>

<div class="page-body">
    <div class="container-xl">
        <div class="card">
            <div class="card-body">
                <div class="header">
                    <div class="filter">
                        <form action="" method="post" class="form-inline">
                            <div class="input-group">
                                <input type="text" class="form-control" id="keyword" name="keyword" placeholder="Cari data">
                                <div class="input-group-append">
                                    <button type="submit" class="btn btn-primary">Cari Data</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
                <br>
                <div class="clear"></div>
            </div>
            <div class="main">
                <form>
                    <div class="content-header">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label required">Input</label>
                                <input type="text" class="form-control" placeholder="Input">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label required">Hikia</label>
                                <input type="text" class="form-control" placeholder="Hikia">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label required">PO</label>
                                <input type="text" class="form-control" placeholder="Terima PO">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label required">Status</label>
                                <input type="text" class="form-control" placeholder="Status">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label required">Ow</label>
                                <input type="text" class="form-control" placeholder="Owner">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label required">PO</label>
                                <input type="text" class="form-control" placeholder="PO">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label required">Hikia</label>
                                <input type="text" class="form-control" placeholder="Hikia">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="col-form-label required">Limit</label>
                                <input type="text" class="form-control" placeholder="Limit">
                            </div>
                        </div>
                    </div>
                    <div class="content-1">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Mimi</label>
                                <input type="text" class="form-control" placeholder="Mimi">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Proses DLN</label>
                                <input type="text" class="form-control" placeholder="Proses DLN">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Suki Orohi Meai</label>
                                <input type="email" class="form-control" placeholder="Suki Orohi Meai">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Afki Mesin</label>
                                <input type="text" class="form-control" placeholder="Afki Mesin">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Kapasitas</label>
                                <input type="text" class="form-control" placeholder="Kapasitas">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Jumlah Lot</label>
                                <input type="text" class="form-control" placeholder="Jumlah Lot">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Berat Jala</label>
                                <input type="text" class="form-control" placeholder="Berat Jala">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Mimi</label>
                                <input type="text" class="form-control" placeholder="Mimi">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Oth Weight</label>
                                <input type="text" class="form-control" placeholder="Oth Weight">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Total Berat</label>
                                <input type="text" class="form-control" placeholder="Total Berat">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Pengerjaan</label>
                                <input type="text" class="form-control" placeholder="Pengerjaan">
                            </div>
                        </div>
                    </div>
                    <div class="content-2">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Buyer</label>
                                <input type="text" class="form-control" placeholder="Buyer">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Type</label>
                                <input type="text" class="form-control" placeholder="Type">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Meai</label>
                                <input type="email" class="form-control" placeholder="Meai">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Kakesu</label>
                                <input type="text" class="form-control" placeholder="Kakesu">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Color</label>
                                <input type="text" class="form-control" placeholder="Color">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Qty</label>
                                <input type="text" class="form-control" placeholder="Qty">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Net Type</label>
                                <input type="text" class="form-control" placeholder="Net Type">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Categori</label>
                                <input type="text" class="form-control" placeholder="Categori">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Spec</label>
                                <input type="text" class="form-control" placeholder="Spec">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Label Inv</label>
                                <input type="text" class="form-control" placeholder="Label Inv">
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label required">Label Pck</label>
                                <input type="text" class="form-control" placeholder="Label Pck">
                            </div>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>