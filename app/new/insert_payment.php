<?php

@session_start();

include_once("../include/queryfunctions.php");
include_once("../include/functions.php");
include 'insert_pos.php';
$new = new pos_new;
$dbpdo = DB::create();

// var_dump($_POST['ovo'] == '' ? 0 : $_POST['ovo']);
// die;
// var_dump($_SESSION);
$code = $_POST['code'];
$location_id = $_SESSION['location_id2'];
$uid = $_SESSION['loginname'];
$shift = $_SESSION['shift'];
$client_code = 0;
$employee_id = 0;
$discount2            =    numberreplace($_POST["discount"] < 1 ? 0 : $_POST["discount"]);
$deposit            =    0;
$total        =    numberreplace($_POST["total"]);
$rate = 0;
$gopay = 0;
$bank_id = 0;
$ovo = numbervalue($_POST['ovo'] == 0 ? 0 : $_POST['ovo']);
$tunai = numbervalue($_POST['cash'] == 0 ? 0 : $_POST['cash']);
$bank_amount = numbervalue(($_POST['debit'] == 0 ? 0 : $_POST['debit']));
$cash = 1;
$cash_voucher = 0;
// var_dump($ovo);
// var_dump($tunai);
// var_dump($_POST['debit']);
// die;
$cash_amount = $tunai + $ovo + $debit;
$client_code = 0;
$credit_card_no = 0;
$credit_card_holder = 0;
$deposit = 0;
$change_amount = $cash_amount - $total;
$bill_to = 0;
$ship_to = 0;
$tax_code            =    "";
$tax_rate            =    0;
$freight_cost         =     0;
$freight_account    =     "";
$currency_code        =    "";
$photo_file            =     "";
$taxable            =     0;

$bank_id            =    (empty($_POST["bank_id"])) ? 0 : $_POST["bank_id"];
$bank_amount        =    numberreplace($_POST["bank_amount"]);
$credit_card_code    =    (empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
$card_amount        =    numberreplace($_POST["card_amount"]);
$credit_card_no        =    $_POST["credit_card_no"];
$credit_card_holder    =    petikreplace($_POST["credit_card_holder"]);
$idd = $new->check_invoice() < 9 ? '0' . $new->check_invoice() + 1 : $new->check_invoice() + 1;
$ref = $location_id . 'POS' . '-' . date('dmy') . '-000' . $idd;
$data = $new->get_data_invoice($_POST['code']);
foreach ($data as $item) {
    $item_code = $item['item_code'];
    $uom_code = $item['uom_code'];
    $qty = $item['qty'];
    $end_date_discount = $item['end_date_discount'] == null ? date('Y-m-d') : $item['end_date_discount'];
    $discount = $item['discount'] < 1 ? 0 : $item['discount'];
    $discount2 = NULL;
    $discount3 = $item['discount3'] < 1 ? 0 : $item['discount3'];
    $unit_price = $item['unit_price'];
    $amount = $item['amount'];
    $qty_discount = $item['qty_discount'];
    $discount_percent_tmp = $item['discount_percent_tmp'];
    $line = $item['line'];
    $ref_near_expired = $item['ref_near_expired'];
    $date = date('Y-m-d');
    $dlu = date('Y-m-d');

    // $sqlstr = "insert into sales_invoice_detail (ref, item_code, uom_code, qty, end_date_discount, discount, discount3, unit_price, amount, line, ref_near_expired) values ('$ref', '$item_code', '$uom_code', '$qty', '$end_date_discount', '$discount', '$discount3', '$unit_price', '$amount',  '$line', '$ref_near_expired')";
    // $sql = $dbpdo->prepare($sqlstr);
    // $sql->execute();

    //----------insert bincard (debit qty)
    // $sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, expired_date) values ('$ref', '$location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
    // $sql = $dbpdo->prepare($sqlstr);
    // $sql->execute();
}

// $sqlstr = "delete from sales_invoice_tmp where ref='$code'";
// $sql = $dbpdo->prepare($sqlstr);
// $sql->execute();

// $due_date = date('Y-m-d');

// $sqlstr = "insert into sales_invoice (ref, date, status, top, due_date, client_code, ship_to, bill_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, total, memo, opening_balance, cash, location_id, deposit, taxable, photo_file, cash_amount, cash_voucher, ovo, gopay, bank_id, bank_amount, credit_card_code, card_amount, credit_card_no, credit_card_holder, change_amount, shift, client_member_code, id_comp, upd_approved_over, uid, dlu) values('$ref', '$date', 'R', '$top', '$due_date', '$client_code', '$ship_to', '$bill_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$total', '$memo', 0, '$cash', '$location_id', '$deposit', '$taxable', '$photo_file', '$cash_amount', '$cash_voucher', '$ovo', '$gopay', '$bank_id', '$bank_amount', '$credit_card_code', '$card_amount', '$credit_card_no', '$credit_card_holder', '$change_amount', '$shift', '$client_member_code', '$id_comp', '$upd_approved_over', '$uid', '$dlu')";
// $sql = $dbpdo->prepare($sqlstr);
// $sql->execute();

echo json_encode(['status' => 200, 'message' => 'Transaksi berhasil']);
