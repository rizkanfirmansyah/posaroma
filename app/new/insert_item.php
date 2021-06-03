<?php

@session_start();

include_once("../include/queryfunctions.php");
include_once("../include/functions.php");
include 'insert_pos.php';
$new = new pos_new;

$data = $_POST['data'];

$ref = $_POST['code'];
$date = date('Y-m-d');
$client_code = '01611181721221111731822501819171122241364';
$cash = 1;
$item_code = $data['item']['syscode'];
$uom_code = $data['harga']['uom_code'];
$qty = 1;
$unit_price = $data['harga']['current_price'];
$amount = $qty * $unit_price;
$discount = $data['harga']['discount'] == null ? 0 : $data['harga']['discount'];
$discount3 = $data['harga']['discount_percent'] == null ? 0 : $data['harga']['discount_percent'];
$end_date_discount = $data['harga']["end_date_discount"];
$non_discount = $data['harga']["non_discount"];
$location_id = $data['harga']["location_id"];
$end_date_discount_total = $data['harga']["end_date_discount_total"];
$total = intval($amount) - $discount;
$uid = $_SESSION['loginname'];
$dlu = date('Y-m-d H:i:s');
$line =  $new->check_item_sales($ref) + 1;

$dbpdo = DB::create();
$code = $ref;

$data_item_tmp = $new->check_item_tmp($code, $item_code);
if ($data_item_tmp['column'] > 0) {
    $setqty = intval($data_item_tmp['line']['qty']) + 1;
    $settotal = intval($data_item_tmp['line']['total']) + $unit_price - $discount ;
    $sqlstr = "update sales_invoice_tmp SET qty='" . $setqty . "', total='".$settotal."' WHERE ref=? AND line=?";
    $sql = $dbpdo->prepare($sqlstr);
    $sql->execute([$code, $data_item_tmp['line']['line']]);
} else {

    $sqlstr = "insert into sales_invoice_tmp (ref, date, client_code, cash, item_code, uom_code, qty, discount, unit_price, amount, discount3, total, non_discount, uid, line, dlu) values ('$ref', '$date', '$client_code', '$cash', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$amount', '$discount3', '$total', '$non_discount', '$uid', '$line', ' $dlu')";
    $sql = $dbpdo->prepare($sqlstr);
    $sql->execute();
}
