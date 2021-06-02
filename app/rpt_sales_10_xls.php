<?php
session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$namafile = "Lap_Penjualan_10_Terbesar.csv";

header("Content-Type: application/csv");
header("Content-Disposition: attachment;filename=".$namafile." ");

include_once ("include/queryfunctions.php");
include_once ("include/functions.php");
//include_once ("include/function_excel.php");

include 'class/class.selectview.php';
include 'class/class.select.php';

$selectview = new selectview;
$select = new select;

$from_date	            =    $_REQUEST['from_date'];
$to_date		    	=    $_REQUEST['to_date'];
$item_code          	=    $_REQUEST['item_code'];
$location_id			=	 $_REQUEST['location_id'];
$all			       	=    $_REQUEST['all'];

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
    '0' => 'LAPORAN PENJUALAN 10 TERBESAR'
);
fputcsv($fp, $header, ';');

$header = array(
    '0' => ''
);
fputcsv($fp, $header, ';');
 
$header = array(
    '0' => 'No.',
	'1' => 'Kode Barang',
	'2' => 'Nama Barang',
	'3' => 'Satuan',
	'4' => 'Total Qty'
 );

fputcsv($fp, $header, ';');

$total_qty = 0;
$sql=$selectview->rpt_sales_item_10($ref, $item_code, $from_date, $to_date, $location_id, $all);
while ($row_sales=$sql->fetch(PDO::FETCH_OBJ)) {
	
	$i++;
	
	$total_qty = $total_qty + $row_sales->total_qty;
    
	$header = array(
		'0' => $i,
		'1' => $row_sales->old_code,
		'2' => $row_sales->item_name,
		'3' => $row_sales->uom_code,
		'4' => $row_sales->total_qty
	);
	
	fputcsv($fp, $header, ';');
			
}

$header = array(
	'0' => '',
	'1' => '',
	'2' => '',
	'3' => 'Total',
	'4' => $total_qty
);
fputcsv($fp, $header, ';');
	
?>

