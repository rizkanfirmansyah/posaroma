<?php
session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$namafile = "List_Order_stock.csv";

header("Content-Type: application/csv");
header("Content-Disposition: attachment;filename=".$namafile." ");

include_once ("include/queryfunctions.php");
include_once ("include/functions.php");
//include_once ("include/function_excel.php");

include 'class/class.selectview.php';
include 'class/class.select.php';

$selectview = new selectview;
$select = new select;

$from_date		=   $_REQUEST['from_date'];
$to_date		=   $_REQUEST['to_date'];

if($from_date != "") {
	if($filter == "") {
		$filter = " Tanggal : ".$from_date;
	} else {
		$filter = $filter." , Tanggal : ".$from_date;
	}
}

if($to_date != "") {
	if($filter == "") {
		$filter = " Tanggal : ".$to_date;
	} else {
		$filter = $filter." s/d Tanggal : ".$to_date;
	}
}

if($all != 0) {
	$filter = "Semua";
}


$fp = fopen('php://output', 'w');
$fp1 = fopen('php://output', 'w');
$fp2 = fopen('php://output', 'w');
$fp3 = fopen('php://output', 'w');

$header = array(
    '0' => 'DAFTAR ORDER STOCK'
);
fputcsv($fp, $header, ';');

$header = array(
    '0' => ''
);
fputcsv($fp, $header, ';');
 
$header = array(
    '0' => 'No.',
	'1' => 'No. Order',
	'2' => 'Tanggal',
	'3' => 'Status'
 );

fputcsv($fp, $header, ';');


$i = 0;
$sql=$select->list_order_stock('', $all, $from_date, $to_date);
while($row_cashier=$sql->fetch(PDO::FETCH_OBJ)){

	$i++;

	$status = "";
	if ($row_cashier->status == "P") {
		$status = "Planned";
	}
	if ($row_cashier->status == "R") {
		$status = "Released";
	}

	$j++;
    
	$detail = array(
		'0' => $i,
		'1' => $row_cashier->ref,
		'2' => date('d-m-Y', strtotime($row_cashier->date)),
		'3' => $status,
		'4' => 'No',
		'5' => 'Kode',
		'6' => 'Nama Barang',
		'7' => 'Satuan',
		'8' => 'Qty'
	);
	
	fputcsv($fp1, $detail, ';');
	
	//detail2
	$sql1=$select->list_order_stock_detail($row_cashier->ref);
	$no = 0;
	while($row_cashier_detail=$sql1->fetch(PDO::FETCH_OBJ)) { 
	
		$qty = $row_cashier_detail->qty;
		
		$no++;
		
		$detail = array(
			'0' => '',
			'1' => '',
			'2' => '',
			'3' => '',
			'4' => $no,
			'5' => $row_cashier_detail->old_code,
			'6' => $row_cashier_detail->item_name,
			'7' => $row_cashier_detail->uom_code,
			'8' => $qty
		);
		
		fputcsv($fp1, $detail, ';');
	
	}
	
}

?>

