<?php
session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$namafile = "Lap_Penjualan_Global.csv";

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
$client_code          	=    $_REQUEST['client_code'];
$location_id			=	 $_REQUEST['location_id'];
$cashier				=	 $_REQUEST['cashier'];
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
    '0' => 'LAPORAN PENJUALAN GLOBAL'
);
fputcsv($fp, $header, ';');

$header = array(
    '0' => ''
);
fputcsv($fp, $header, ';');
 
$header = array(
    '0' => 'No.',
	'1' => 'Tanggal',
	'2' => 'Nama Unit',
	'3' => 'Kasir',
	'4' => 'Jumlah Sales',
	'5' => 'Modal',
	'6' => 'Total'
 );

fputcsv($fp, $header, ';');

	
$grand_total = 0;
$grand_modal = 0;
$grand_sales = 0;

$sql=$selectview->list_sales_invoice_global($from_date, $to_date, $location_id, $all, $cashier);			
				
while ($row_sales=$sql->fetch(PDO::FETCH_OBJ)) {
		
	$modal = $selectview->list_modal_global($row_sales->date, $location_id);
	
	$grand_total = $grand_total + $row_sales->total;
	
	$grand_modal = $grand_modal + $modal;
	
	$total = $row_sales->total + $modal;
	
	$grand_sales = $grand_sales + $total;
		
	$i++;
    
	$detail = array(
		'0' => $i,
		'1' => date("d-m-Y", strtotime($row_sales->date)),
		'2' => $row_sales->location_name,
		'3' => $row_sales->uid,
		'4' => $row_sales->total,
		'5' => $modal,
		'6' => $total
	);
	
	fputcsv($fp, $detail, ';');
}

$footer = array(
	'0' => '',
	'1' => '',
	'2' => '',
	'3' => 'Total',
	'4' => $grand_total,
	'5' => $grand_modal,
	'6' => $grand_sales
);
fputcsv($fp, $footer, ';');
	
?>

