<?php

include 'insert_pos.php';
include_once("../include/queryfunctions.php");
include_once("../include/functions.php");

$new = new pos_new;
$dbpdo = DB::create();

$data = $new->get_void_request($_POST['code']);

echo json_encode($data);
