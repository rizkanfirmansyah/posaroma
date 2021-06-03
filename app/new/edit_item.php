<?php

@session_start();

include_once("../include/queryfunctions.php");
include_once("../include/functions.php");
include 'insert_pos.php';
$new = new pos_new;

$dbpdo = DB::create();

$item = $new->check_item($_POST['itemCode'])['syscode'];
$qty = $_POST['itemQty'];
$code = $_POST['code'];
$harga = $new->check_price($item)['current_price'];
$discount = $new->check_price($item)['discount'];

$check = $new->check_item_tmp($code, $item);
if ($check['column'] < 1) {
    echo json_encode(['status' => 404, 'message' => 'Item tidak ditemukan pada transaksi, coba lagi!']);
    die;
}

$settotal = intval($harga) * intval($qty) - $discount * $qty;
$sqlstr = "update sales_invoice_tmp SET qty='" . $qty . "', total='".$settotal."' WHERE ref=? AND item_code=?";
$sql = $dbpdo->prepare($sqlstr);
$sql->execute([$code, $item]);
echo json_encode(['status' => 200, 'message' => 'Item ditemukan.']);

?>