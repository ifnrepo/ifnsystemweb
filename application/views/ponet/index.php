<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<style>
    body {
        background: linear-gradient(to right, #f8f9fa, #e9ecef);
        font-family: 'Arial', sans-serif;



    }

    .page-body {
        padding: 10px;
        margin-top: -5px;
    }

    .satu,
    .dua,
    .tiga,
    .empat {
        width: 270px;
        /* border: 1px dashed white; */
        /* border: 4px solid white; */
        border: 4px solid #007bff;
        padding: 5px;
        margin: 10px;
        /* Menambahkan jarak bawah */
        float: left;
        font-size: 12px;
        padding: 10px;
        /* background-color: rgba(255, 255, 255, 0.5); */

    }

    .clear {
        clear: left;
    }

    .content {
        border: 4px solid white;
        padding: 5px;

    }

    .col-form-label {
        font-weight: bold;
        color: #007bff;
        /* color: white; */
        font-style: oblique;


    }

    .card {
        border-radius: 20px;
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
        margin-top: 20px;
        position: relative;
        overflow: hidden;
        background-color: rgba(255, 255, 255, 0.0);
    }

    .card::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        /* background: url('assets/image/logosystem3.png') no-repeat center center/cover; */
        /* background: url('assets/image/ponet.png') no-repeat center center/cover; */
        background-size: 100%;
        opacity: 0.9;

        z-index: -1;

    }

    .card-body {
        padding: 10px;
        position: relative;
        z-index: 1;
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
        /* background-color: #0061cc; */
        /* background-color: #B0C4DE; */
        /* background-color: #4169E1; */

    }

    .input-group-text {
        color: white;
        border-radius: 10px;
    }

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
                <div class="satu">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Input</label>
                        <div class="col">
                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Input">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required"> In Hikia</label>
                        <div class="col">
                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="In Hikia">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Terima PO</label>
                        <div class="col">
                            <input type="email" class="form-control" aria-describedby="emailHelp" placeholder="Terima PO">
                        </div>
                    </div>
                </div>
                <div class="dua">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Status</label>
                        <div class="col">
                            <input type="email" class="form-control" placeholder="Status">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Owner</label>
                        <div class="col">
                            <input type="email" class="form-control" placeholder="Owner">
                        </div>
                    </div>
                </div>
                <div class="tiga">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required"> PO</label>
                        <div class="col">
                            <input type="email" class="form-control" placeholder="PO">
                        </div>
                    </div>
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required"> Hikia</label>
                        <div class="col">
                            <input type="email" class="form-control" placeholder=" Hikia">
                        </div>
                    </div>

                </div>
                <div class="empat">
                    <div class="mb-2 row">
                        <label class="col-3 col-form-label required">Limit</label>
                        <div class="col">
                            <input type="email" class="form-control" placeholder="Limit">
                        </div>
                    </div>
                </div>
                <div class="clear"></div>
                <br>
                <form class="content">
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