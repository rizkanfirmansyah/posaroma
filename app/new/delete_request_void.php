<?php

include 'insert_pos.php';
include_once("../include/queryfunctions.php");
include_once("../include/functions.php");

$new = new pos_new;
$dbpdo = DB::create();

$sqlstr = "UPDATE sales_invoice_detail set request_void=null WHERE ref=? AND item_code=?";
$sql = $dbpdo->prepare($sqlstr);
$sql->execute([$_POST['ref'], $_POST['code']]);

echo json_encode(['status' => 200, 'message' => 'request void success']);
