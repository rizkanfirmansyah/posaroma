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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" integrity="sha512-iBBXm8fW90+nuLcSKlbmrPcLa0OT92xO1BIsZ+ywDWZCvqsWgccV3gFoRBv0z+8dLJgyAHIhR35VZc2oM/gI1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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

            <input type="hidden" id="checkInvoiceTmp" value="<?= $new->check_item_sales($_GET['code']) ?>">

        </footer>

        <!-- MODAL -->

        <!-- Modal Transaksi -->
        <div class="modal fade" id="modalPayment" tabindex="-1" role="dialog" aria-labelledby="modalPaymentTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalPaymentTitle">Pembayaran</h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <form action="#" id="inputPayment">
                        <div class="modal-body" style="padding:20px;">
                            <label for="total">Total</label>
                            <input type="text" class="form-control" placeholder="Value Total" id="totalPayment" disabled>&nbsp;
                            <label for="discount">Discount</label>
                            <input type="text" class="form-control payments" placeholder="Value Discount" value="0" id="discountPayment" name="discount" disabled>&nbsp;
                            <label for="ovo">Ovo</label>
                            <input type="text" class="form-control payments" placeholder="Value Ovo" id="ovoPayment" value="0" name="ovo">&nbsp;
                            <label for="debit">Debit</label>
                            <input type="text" class="form-control payments" placeholder="Value Debit" value="0" id="debitPayment" name="debit">&nbsp;
                            <label for="cash">Cash</label>
                            <input type="text" class="form-control payments" placeholder="Value Cash" value="0" id="cashPayment" name="cash">&nbsp;
                            <label for="kembalian">Kembalian</label>
                            <input type="text" class="form-control" placeholder="Value Kembalian" value="0" id="kembalianPayment" disabled>&nbsp;
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-success"><i class="fas fa-dollar-sign"></i> Bayar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Modal Done-->
        <div class="modal fade" id="modalDone" tabindex="-1" role="dialog" aria-labelledby="modalDoneTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalDoneTitle">Pembayaran Nota:<?= $_GET['code'] ?></h5>
                        <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button> -->
                    </div>
                    <div class="modal-body text-center" style="padding:20px;">
                        <h1><span class="text-muted">Transaksi Berhasil</span></h1>
                        <i class="fa fa-3x text-success fa-check"></i>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success"><i class="fas fa-print"></i> Print </button>
                        <?php
                        $data = $new->check_invoice() + 1;
                        $code  = "20" . date('Ymd') . rand(122345, 2329792) . '0000' . $data
                        ?>
                        <a href="pos_new.php?code=<?= $code ?>" class="btn btn-success"><i class="fas fa-clipboard-list"></i> New </a>
                    </div>
                </div>
            </div>
        </div>


    </body>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <script src="https://pos.erparoma.com/assets/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/typewriter-effect@2.3.1/dist/core.js"></script>

    <script>
        $(document).on('keyup keydown', function(e) {
            let key = e.key
            if (key == 'Delete') {
                let html = `
                <div class="container" style="padding:20px; margin-right:20px; width:90%;">
                    <label style="color:#fff;"> Code </label> &nbsp;
                    <input type="text" class="form-control" id="deleteItem" autofocus/>
                </div>
            `
                $('#zero-space').html(html)
                $('#deleteItem').focus()
            } else if (key == 'Escape') {
                $('#InputanItem').focus()
            }
        })
        let cost = 200000
        let hargaAkhir = 0;
        let qty = 6;
        let qtyProduk = 0;

        function date() {
            var hari = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', "Jum'at", 'Sabtu']
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

            $('#inputPayment').on('submit', function(e) {
                e.preventDefault();
                let res = subTotalPayment(['ovoPayment', 'cashPayment', 'debitPayment'])
                let ovo = res[0].ovo >= 0 ? res[0].ovo : 0
                let cash = res[0].cash >= 0 ? res[0].cash : 0
                let debit = res[0].debit >= 0 ? res[0].debit : 0
                let total = $('#totalPayment').data('value')
                if ((ovo + cash + debit) < total) {
                    alert('Pembayaran tidak mencukupi transaksi!')
                    return 0;
                }
                let code = '<?= $_GET['code'] ?>'
                let data = new FormData(this)
                data.append('discount', $('#discountPayment').val())
                data.append('code', code)
                data.append('total', total)
                if (confirm('Apakah transaksi sudah benar?')) {
                    confirmPayment(data)
                }
            })

            $('#modalPayment').on('keyup change', '.payments', function(e) {
                let id = $(this).attr('id');
                let value = titikHilang($(this).val())
                let val = value.replace('.', '')
                let charCode = /^[0-9]+$/

                if (value.match(charCode)) {
                    ketikRupiah({
                        id: id,
                        val: val
                    })
                }

                let data = subTotalPayment(['ovoPayment', 'cashPayment', 'debitPayment'])
                let ovo = data[0].ovo >= 0 ? data[0].ovo : 0
                let cash = data[0].cash >= 0 ? data[0].cash : 0
                let debit = data[0].debit >= 0 ? data[0].debit : 0

                let kembalian = subTotal($('#totalPayment').data('value'), (ovo + cash + debit))
                $('#kembalianPayment').val(rupiah(kembalian))

            })

            $('#InputanItem').focus()

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
                            code: '<?= $_GET['code'] ?>'
                        },
                        success: res => {
                            getdata('<?= $_GET['code'] ?>')
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
                let code = $('#editItemCode').val()
                let qty = $('#editItemQty').val()
                if (code == undefined || code == '' || code == ' ') {
                    alert('Masukkan Code Item terlebih dahulu');
                    return 0;
                } else if (qty < 1 || qty == '' || code == ' ') {
                    alert('Masukkan Qty Item terlebih dahulu');
                    return 0;
                }
                $.ajax({
                    url: 'new/edit_item.php',
                    type: 'POST',
                    data: {
                        itemCode: code,
                        itemQty: qty,
                        code: '<?= $_GET['code'] ?>',
                    },
                    success: res => {
                        let response = JSON.parse(res)
                        if (response.status == 404) {
                            alert(response.message);
                            return 0;
                        }
                        getdata('<?= $_GET['code'] ?>')
                    },
                    error: err => {
                        console.log(err);
                    }
                })
            })
        })

        async function myFunction(event) {
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
            } else if (x == 'F4') {
                let tmp = $('#checkInvoiceTmp').val()
                if (tmp < 1) {
                    alert('Transaksi Belum ada!');
                    return 0;
                }
                $('#modalPayment').modal()
                let total = await getTotalPrice()
                $('#totalPayment').val(rupiah(total))
                $('#totalPayment').attr('data-value', total)
            }
        }

        async function getTotalPrice() {
            try {
                const res = await getTotal('<?= $_GET['code'] ?>')
                let response = JSON.parse(res)
                let html = ' '
                let qty = 0
                let total = 0
                response.invoice.forEach(data => {
                    total += Number(data.total)
                    qty += Number(data.qty)
                })
                return total;
            } catch (err) {
                console.log(err);
            }
        }

        function inputItem(data) {
            $.ajax({
                url: 'new/insert_item.php',
                type: 'POST',
                data: {
                    data: data,
                    code: '<?= $_GET['code'] ?>',
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

        function getTotal(params) {
            let total = 0
            return $.ajax({
                url: 'new/check_invoice.php',
                type: 'POST',
                data: {
                    code: params
                },
                success: res => {

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

        function ketikRupiah(params) {
            if (params.value != '') {
                $(`#${params.id}`).val(rupiah(params.val))
            }

        }

        function titikHilang(data) {
            return data.replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.', '').replace('.', '')
        }


        function subTotalPayment(id) {
            let ovo = parseInt(titikHilang($(`#${id[0]}`).val()))
            let cash = parseInt(titikHilang($(`#${id[1]}`).val()))
            let debit = parseInt(titikHilang($(`#${id[2]}`).val()))
            data = [{
                ovo: ovo,
                cash: cash,
                debit: debit
            }]
            return data;
        }

        function subTotal(total, bayar) {
            let data = 0
            if (total > bayar) {
                data = 0
            } else {
                data = bayar - total
            }

            return data
        }

        function confirmPayment(data) {
            $.ajax({
                url: 'new/insert_payment.php',
                type: 'POST',
                data: data,
                contentType: false,
                processData: false,
                success: res => {
                    $('#modalPayment').modal('hide')
                    $('#modalDone').modal()
                    // window.open("new/print.php", '_blank');
                },
                error: err => console.log(err)
            })
        }
    </script>

    </html>