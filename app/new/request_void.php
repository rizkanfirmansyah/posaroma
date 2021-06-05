<?php

include 'insert_pos.php';
include_once("../include/queryfunctions.php");
include_once("../include/functions.php");

$new = new pos_new;
$dbpdo = DB::create();
$code = $new->check_item($_POST['code'])['syscode'];

$sqlstr = "UPDATE sales_invoice_detail set request_void=0 WHERE ref=? AND item_code=?";
$sql = $dbpdo->prepare($sqlstr);
$sql->execute([$_POST['ref'], $code]);

echo json_encode(['status' => 200, 'message' => 'request void success']);
