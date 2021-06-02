<?php
session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$namafile = "Lap_Penjualan_Batal.csv";

header("Content-Type: application/csv");
header("Content-Disposition: attachment;filename=".$namafile." ");

include_once ("include/queryfunctions.php");
include_once ("include/functions.php");
include_once ("include/function_excel.php");

include 'class/class.selectview.php';
include 'class/class.select.php';

$selectview = new selectview;
$select = new select;

$petugas		=	$_SESSION["loginname"];
$ref			= 	$_REQUEST['ref'];
$from_date		=   $_REQUEST['from_date'];
$to_date		=   $_REQUEST['to_date'];
$shift	   		=   $_REQUEST['shift'];
$cashier		=	$_REQUEST['uid'];
$void			=	$_REQUEST['void_'];

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
       '0' => 'No',
       '1' => 'No. Nota',
	   '2' => 'Tanggal',
	   '3' => 'Jam',
	   '4' => 'Kasir',
	   '5' => 'Barang Batal'
 );


fputcsv($fp, $header, ';');

//detail
$total_qty = 0;
$total_amount = 0;
$grand_total = 0;		
$i = 0;									
$sql=$select->list_pos_void('', $all, $from_date, $to_date, $shift, $cashier, $receipt_type_pos, $item_code);
while($row_pos=$sql->fetch(PDO::FETCH_OBJ)){


	$bgcolor = "";
	$total = 0;
	$status = "";
		if ($row_pos->closed == 1) {
		$status = "Closed";
	}
	
	$shift = "";
	if($row_pos->shift == "1") {
		$shift = "Pagi";
	}
	if($row_pos->shift == "2") {
		$shift = "Malam";
	}
    
    $detail = array(
		'0' => ($i+1),
		'1' => $row_pos->ref,
		'2' => date("d-m-Y", strtotime($row_pos->date)),
		'3' => date("H:i", strtotime($row_pos->dlu)),
		'4' => $row_pos->uid,
		'5' => 'No',
		'6' => 'Nama Barang',
		'7' => 'Satuan',
		'8' => 'Qty',
		'9' => 'Total',
		'10' => 'User Void'
	);
	
	fputcsv($fp1, $detail, ';');
	
	//detail barang
	$x = 0;
	$sql2=$select->list_adt_pos_detail($row_pos->ref, $item_code); 
	while($row_void=$sql2->fetch(PDO::FETCH_OBJ)) {	
	
		$x++;
		
		$total_qty = $total_qty + $row_void->qty;
		$total_amount = $total_amount + $row_void->amount;
		
		$detail1 = array(
			'0' => '',
			'1' => '',
			'2' => '',
			'3' => '',
			'4' => '',
			'5' => $x,
			'6' => $row_void->item_name,
			'7' => $row_void->uom_code,
			'8' => $row_void->qty,
			'9' => $row_void->amount,
			'10' => $row_void->uid
		);
		
		fputcsv($fp2, $detail1, ';');
	}
			
$i++;
}

$footer = array(
	'0' => '',
	'1' => '',
	'2' => '',
	'3' => '',
	'4' => '',
	'5' => '',
	'6' => '',
	'7' => 'TOTAL',
	'8' => $total_qty,
	'9' => $total_amount,
	'10' => ''
);

fputcsv($fp3, $footer, ';');

?>

