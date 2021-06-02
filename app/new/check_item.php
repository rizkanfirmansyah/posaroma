<?php

include 'insert_pos.php';
include_once("../include/queryfunctions.php");
include_once("../include/functions.php");

$new = new pos_new;

$item = $new->check_item($_POST['code']);
$harga = $new->check_price($item['syscode']);


echo json_encode(['item' => $item, 'harga' => $harga]);
