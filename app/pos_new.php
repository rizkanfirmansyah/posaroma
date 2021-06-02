<?php
@session_start();
include 'new/insert_pos.php';

include_once("include/queryfunctions.php");
include_once("include/functions.php");
$new = new pos_new;

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://pos.erparoma.com/assets/css/bootstrap.min.css">
    <title>POS AROMA</title>
</head>

<style>
    body {
        margin: 0;
        padding: 0;
        background-color: #010596;
    }

    #page-content {
        padding: 0;
        margin: 0;
        width: auto;
        float: none;
    }

    .header {
        padding-left: 20px;
        padding-right: 20px;
        margin-top: -5px;
        border-bottom: solid 2px #fff;
    }

    .header span {
        color: #fff;
    }

    .brand {
        font-weight: 700;
        font-size: 18px;
    }

    #data-product {
        height: 180px;
        color: #fff;
        padding: 10px;
        width: 70%;
    }

    #data-product h1 {
        font-size: 45px;
        font-weight: 800;
    }

    #data-product h2 {
        font-weight: 800;
    }

    #info-cashier {
        width: 30%;
    }

    #info-cashier-2 {
        height: 20px;
        border: solid 3px #ddd;
        border-radius: 5px;
        border-radius: 5px;
    }

    #info-cashier-1 {
        height: 120px;
        border: solid 3px #ddd;
        border-radius: 5px;
        border-radius: 5px;
    }

    #info-cashier-1 span {
        font-size: 16px;
    }

    #info-cashier-3 {
        height: 40px;
        border: solid 3px #ddd;
        border-radius: 5px;
        border-radius: 5px;
    }

    #list-product {
        width: 70%;
    }

    .harga-product h2 {
        position: relative;
        float: right;
        font-size: 45px;
        font-weight: 700;
    }

    .zero-space {
        height: 30px;
        border: solid 2px #ddd;
        ;
        border-radius: 5px;
    }

    .table-product {
        height: 260px;
        border: solid 3px #ddd;
        border-radius: 5px;
        overflow-y: scroll;
    }

    #zero-space {
        height: 290px;
        width: 30%;
        border: solid 3px #ddd;
        border-radius: 5px;
    }

    #zero-space-footer {
        height: 80px;
        width: 60%;
        border: solid 3px #ddd;
        border-radius: 5px;
    }

    #total {
        height: 80px;
        width: 40%;
        border: solid 3px #ddd;
        border-radius: 5px;
    }

    .baris {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-wrap: wrap;
        flex-wrap: wrap;
        width: 100%;
    }

    footer {
        height: 70px;
        bottom: 0;
        position: absolute;
        border: solid 2px #ddd;
        width: 100%;
        background-color: #d1d1d1;
    }

    td {
        text-transform: uppercase;
        font-weight: 700;
        text-align: center;
    }
</style>

<body>

    <section id="page-content">

        <div class="header baris">

            <h2 style="color: yellow;font-weight: 700;">AROMA BAKERY & CAKE SHOP</h2>
            <span style="margin-left: auto; padding-top: 10px;">
                <span class="brand">SOFTWARE POS ERP AROMA</span><br>
                <span class="status">Point of Sales : Online </span>
                <a href="" style="color: #D1d1d1;">-></a>
            </span>

        </div>

        <div class="product">

            <div class="baris">
                <div class="col-8" id="data-product">
                    <h1 id="namaProduk">-</h1>
                    <div class="harga-product">
                        <h2 id="hargaProduk">0,-</h2>
                    </div>
                </div>
                <div class="col-2" id="info-cashier">
                    <div class="col-2" id="info-cashier-1" style="color:#fff; padding-left:10px">
                        <h2 style="margin-top: 5px; font-weight: 700;">Kassa #3</h2>
                        <span id="tanggal">-</span><br>
                        <span>Kasir : <?php echo $_SESSION["loginname"] ?></span><br>
                        <span>Shift : <?php
                                        $shift = $_SESSION["shift"];
                                        $shift_name = "";
                                        if ($shift == 1) {
                                            $shift_name = "Pagi";
                                        }
                                        if ($shift == 2) {
                                            $shift_name = "Malam";
                                        }
                                        echo $shift_name;
                                        ?></span>
                    </div>
                    <div class="col-2" id="info-cashier-2"></div>
                    <div class="col-2" id="info-cashier-3"></div>
                </div>
            </div>

            <div class="baris">
                <div class="col-8" id="list-product">
                    <div class="zero-space"></div>
                    <div class="table-product">
                        <div class="table-responsive">
                            <table class="table table-hover" style="color:#fff;" border="1">
                                <thead style="background-color: #D1d1d1; color:blue;font-weight: 700;">
                                    <tr>
                                        <td>QTY</td>
                                        <td>Kode</td>
                                        <td>Keterangan</td>
                                        <td>Harga</td>
                                        <td>%</td>
                                        <td>Disc</td>
                                        <td>Total Harga</td>
                                    </tr>
                                </thead>
                                <tbody id="myList">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="col-2" id="zero-space"></div>
            </div>

            <div class="baris">
                <div class="col-8" id="zero-space-footer">
                    <input autofocus onkeydown="myFunction(event)" type="text" style="height: 100%; width:100%; background-color: transparent; font-size: 36px; color:#fff;" id="InputanItem">
                </div>
                <div class="col-2" id="total">
                    <span style="color:#fff;padding-top:28px;margin-left: 10px; font-weight: 700;">TOTAL :</span>
                    <div class="baris" style="margin-top: -10px;">
                        <h1 style="color:#fff; font-weight: 800; margin-left: 5px;" id="totalQty">0</h1>
                        <h1 style="color:#fff; right:0; position: absolute; margin-right: 10px; font-size:42px; font-weight: 800;" id="totalHarga">0,-</h1>
                    </div>
                </div>
            </div>

        </div>

    </section>

    <footer>

    </footer>


</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://pos.erparoma.com/assets/js/bootstrap.min.js"></script>
<script src="https://unpkg.com/typewriter-effect@2.3.1/dist/core.js"></script>

<script>
    $(document).on('keyup keydown', function(e) {
        let key = e.key
        if (key == 'delete') {
            let html = `
                <div class="container" style="padding:20px; margin-right:20px; width:90%;">
                    <label style="color:#fff;"> Code </label> &nbsp;
                    <input type="text" class="form-control" id="deleteItem" autofocus/>
                </div>
            `
            $('#zero-space').html(html)
            $('#deleteItem').focus()
        }
    })
    let cost = 200000
    let hargaAkhir = 0;
    let qty = 6;
    let qtyProduk = 0;

    function date() {
        var hari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jum&#39;at', 'Sabtu']
        var bulan = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        var tanggal = new Date().getDate()
        var _hari = new Date().getDay()
        var _bulan = new Date().getMonth()
        var _tahun = new Date().getYear()
        var jam = new Date().getHours()
        var menit = new Date().getMinutes()
        var detik = new Date().getSeconds()

        var hari = hari[_hari]
        var bulan = bulan[_bulan]
        var tahun = (_tahun < 1000) ? _tahun + 1900 : _tahun;

        return `${hari} , ${tanggal} ${bulan} ${tahun} ${jam}:${menit < 10 ? '0'+menit : menit}:${detik < 10 ? '0'+detik :detik}`;
    }

    $(document).ready(function() {
        setInterval(() => {
            let tgl = date()
            $('#tanggal').text(tgl)
        }, 1000);

        getdata('<?= $_GET['code'] ?>')

        $('#zero-space').on('keydown', '#deleteItem', function(e) {
            let key = e.key
            if (key == 'Enter') {
                let value = $(this).val()
                $.ajax({
                    url: 'new/delete_item.php',
                    type: 'POST',
                    data: {
                        value: value,
                        code: <?= $_GET['code'] ?>
                    },
                    success: res => {
                        getdata(<?= $_GET['code'] ?>)
                    },
                    error: err => {
                        console.log(err);
                    }
                })
            } else if (key == 'Delete') {
                $('#zero-space').html('')
                $('#InputanItem').focus()
            }
        })

        $('#zero-space').on('keydown', '#editItemCode', function(e) {
            let key = e.key
            if (key == 'F2') {
                $('#zero-space').html('')
                $('#InputanItem').focus()
            }
        })
        $('#zero-space').on('keydown', '#editItemQty', function(e) {
            let key = e.key
            if (key == 'F2') {
                $('#zero-space').html('')
                $('#InputanItem').focus()
            }
        })

        $('#zero-space').on('submit', '#editItem', function(e) {
            e.preventDefault()
            let key = e.key
            if (key == 'Enter') {
                let value = $(this).val()
                $.ajax({
                    url: 'new/edit_item.php',
                    type: 'POST',
                    data: {
                        value: value,
                        code: <?= $_GET['code'] ?>
                    },
                    success: res => {
                        getdata(<?= $_GET['code'] ?>)
                    },
                    error: err => {
                        console.log(err);
                    }
                })
            } else if (key == 'F2') {
                $('#zero-space').html('')
                $('#InputanItem').focus()
            }
        })
    })

    function myFunction(event) {
        var x = event.key;
        let id = ''
        let idProduk = ''
        let nama_produk = ' ';
        let harga = 0;
        if (x == 'Enter') {

            $.ajax({
                url: 'new/check_item.php',
                type: 'POST',
                data: {
                    code: $('#InputanItem').val()
                },
                success: res => {
                    let response = JSON.parse(res)
                    if (response.item == false || $('#InputanItem').val().length < 1) {
                        alert('Item tidak ditemukan');
                    } else {
                        inputItem(response)
                        $('#hargaProduk').text(rupiah(response.harga.current_price) + ',-');

                        var app = document.getElementById('namaProduk');

                        var typewriter = new Typewriter(app, {
                            loop: true,
                            delay: 10
                        });

                        $('#InputanItem').val("")
                        getdata('<?= $_GET['code'] ?>')

                        typewriter.typeString(response.item.name)
                            .pauseFor(250000000)
                            .start();
                    }
                },
                error: err => console.log(err)
            })

        } else if (x == 'Delete') {
            if ($('#zero-space').html() == '') {
                let html = `
                <div class="container" style="padding:20px; margin-right:20px; width:90%;">
                    <label style="color:#fff;"> Code </label> &nbsp;
                    <input type="text" class="form-control" id="deleteItem" autofocus/>
                </div>
            `
                $('#zero-space').html(html)
                $('#deleteItem').focus()
            } else {
                $('#zero-space').html('')
                $('#InputanItem').focus()
            }
        } else if (x == 'F2') {
            if ($('#zero-space').html() == '') {
                let html = `
                <div class="container" style="padding:20px; margin-right:20px; width:90%;">
                    <form method="POST" id="editItem">
                        <label style="color:#fff;"> Code </label> &nbsp;
                        <input type="text" class="form-control" id="editItemCode" autofocus/>
                        <label style="color:#fff; margin-top:20px;"> QTY </label> &nbsp;
                        <input type="text" class="form-control" id="editItemQty"/>
                        <button type="submit"></button>
                    </form>
                </div>
            `
                $('#zero-space').html(html)
                $('#editItemCode').focus()
            } else {
                $('#zero-space').html('')
                $('#InputanItem').focus()
            }
        }
    }

    function inputItem(data) {
        $.ajax({
            url: 'new/insert_item.php',
            type: 'POST',
            data: {
                data: data,
                code: <?= $_GET['code'] ?>,
            },
            success: res => {
                console.log(res);
            },
            error: err => {
                console.log(err);
            }
        })
    }

    function getdata(params) {
        $.ajax({
            url: 'new/check_invoice.php',
            type: 'POST',
            data: {
                code: params
            },
            success: res => {
                let response = JSON.parse(res)
                let html = ' '
                let total = 0
                let qty = 0
                response.invoice.forEach(data => {
                    html += `
                        <tr>
                            <td>${rupiah(data.qty)}</td>
                            <td>${data.old_code}</td>
                            <td style="text-align: left;">${data.item_name}</td>
                            <td style="text-align: right;"> ${rupiah(data.unit_price)}</td>
                            <td style="text-align: right;">${rupiah(data.discount3)}%</td>
                            <td style="text-align: right;">${rupiah(data.discount)}</td>
                            <td style="text-align: right;">${rupiah(data.total)}</td>
                        </tr>
                    `
                    total += Number(data.total)
                    qty += Number(data.qty)
                })

                $('#totalHarga').html(rupiah(total) + ',-')
                $('#totalQty').html(qty)
                $('#myList').html(html)
            },
            error: err => {
                console.log(err);
            }
        })
    }

    function rupiah(bilangan) {
        var number_string = bilangan.toString(),
            sisa = number_string.length % 3,
            rupiah = number_string.substr(0, sisa),
            ribuan = number_string.substr(sisa).match(/\d{3}/g);

        if (ribuan) {
            separator = sisa ? '.' : '';
            rupiah += separator + ribuan.join('.');
        }

        return rupiah;
    }
</script>

</html>