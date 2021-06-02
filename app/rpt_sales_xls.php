<?php
session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$namafile = "Lap_Penjualan_Excel.csv";

header("Content-Type: application/csv");
header("Content-Disposition: attachment;filename=".$namafile." ");

include_once ("include/queryfunctions.php");
include_once ("include/functions.php");
include_once ("include/function_excel.php");

include 'class/class.selectview.php';
include 'class/class.select.php';

$selectview = new selectview;
$select = new select;

$from_date	            =    $_REQUEST['from_date'];
$to_date		    	=    $_REQUEST['to_date'];
$client_code          	=    $_REQUEST['client_code'];
$location_id			=	 $_POST['location_id'];
$cashier				=	 $_POST['cashier'];
$item_group_id			=	 $_POST['item_group_id'];
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
    '0' => 'LAPORAN PENJUALAN'
);
fputcsv($fp, $header, ';');

$header = array(
    '0' => ''
);
fputcsv($fp, $header, ';');
 
$header = array(
    '0' => 'No.',
	'1' => 'Tanggal',
	'2' => 'Jam',
	'3' => 'No.Nota',
	'4' => 'Kasir',
	'5' => 'Nama Barang',
	'6' => 'Total'
 );
fputcsv($fp, $header, ';');
	
$total = 0;
                            	
$sql=$selectview->list_sales_invoice($ref, $client_code, $from_date, $to_date, $location_id, $all, $cashier, $item_group_id);			
				
while ($row_sales=$sql->fetch(PDO::FETCH_OBJ)) {
	
	$i++;
	
	$total = $total + $row_sales->total;
    
	$detail = array(
		'0' => $i,
		'1' => date("d-m-Y", strtotime($row_sales->date)),
		'2' => date("H:i", strtotime($row_sales->dlu)),
		'3' => $row_sales->ref,
		'4' => $row_sales->uid,
		'5' => "",
		'6' => $row_sales->total,
		
		'7' => 'No.',
		'8' => 'Nama Barang',
		'9' => 'Qty',
		'10' => 'Harga',
		'11' => 'Jumlah'
	);
	
	fputcsv($fp, $detail, ';');
	
		$x = 0;
		$sql2=$select->list_pos_detail($row_sales->ref); 
		$rowsno=$sql2->rowCount();
		while($row_pos_det=$sql2->fetch(PDO::FETCH_OBJ)) {	
		
			$x++;
			
			$detail1 = array(
				'1' => '',
				'2' => '',
				'3' => '',
				'4' => '',
				'5' => '',
				'6' => '',
				
				'7' => '',
				'8' => $x,
				'9' => $row_pos_det->item_name,
				'10' => $row_pos_det->qty,
				'11' => $row_pos_det->unit_price,
				'12' => $row_pos_det->amount
			);
			
			fputcsv($fp, $detail1, ';');
		}
			
	
}

$footer = array(
	'0' => '',
	'1' => '',
	'2' => '',
	'3' => '',
	'4' => 'Total',
	'5' => $total
);

fputcsv($fp, $footer, ';');

?>

