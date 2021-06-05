<?php

include 'insert_pos.php';
include_once("../include/queryfunctions.php");
include_once("../include/functions.php");

$new = new pos_new;

$invoice = $new->get_info_invoice($_POST['code']);

echo json_encode(['invoice' => $invoice]);
