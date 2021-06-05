<?php

include 'insert_pos.php';
include_once("../include/queryfunctions.php");
include_once("../include/functions.php");

$new = new pos_new;
$dbpdo = DB::create();

$sqlstr = "UPDATE sales_invoice_detail set qty=0, unit_price=0, discount=0, discount3=0, amount=0, note='void' WHERE ref=? AND request_void=0";
$sql = $dbpdo->prepare($sqlstr);
$sql->execute([$_POST['code']]);

$data = $new->get_info_invoice($_POST['code']);
foreach ($data as $key) {
    $total += $key['amount'];
}

$inv = $new->get_sales_invoice($_POST['code']);
$change_amount = $inv['change_amount'] + $total;

$sqlstr = "UPDATE sales_invoice set change_amount='$change_amount', total='$total' WHERE ref=?";
$sql = $dbpdo->prepare($sqlstr);
$sql->execute([$_POST['code']]);

echo json_encode(['status' => 200, 'message' => 'request void success']);
