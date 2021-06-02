<?php

@session_start();

include_once("../include/queryfunctions.php");
include_once("../include/functions.php");
include 'insert_pos.php';
$new = new pos_new;
$dbpdo = DB::create();

$item = $new->check_item($_POST['value']);
$sqlstr = "DELETE from sales_invoice_tmp WHERE ref=? AND item_code=?";
$sql = $dbpdo->prepare($sqlstr);
$sql->execute([$_POST['code'], $item['syscode']]);
