<?php
session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$filename = "Lap_Penjualan.csv";

header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);

include_once ("include/queryfunctions.php");
include_once ("include/functions.php");
//include_once ("include/function_excel.php");

include 'class/class.selectview.php';
include 'class/class.select.php';

$selectview = new selectview;
$select = new select;

$dbpdo = DB::create();

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

$query = "select 'No.', 'No. Nota', 'Tanggal', 'Jam', 'Kasir', 'Shift', 'Total', 'Status'";
$sql3=$dbpdo->prepare($query);
$sql3->execute();
	
while($row = $sql3->fetch(PDO::FETCH_NUM)) {
	
	fputcsv($fp, $row, ';');
	
	//data detail
	$grand_total = 0;		
	$i = 0;									
	$sql=$select->list_pos_valid('', $all, $from_date, $to_date, $shift, $cashier, $receipt_type_pos, $void);
    while($row_pos=$sql->fetch(PDO::FETCH_OBJ)){
	
	
		$bgcolor = "";
		$total = 0;
		$status = "";
		if ($row_pos->void == 1) {
			$status = "Batal";
			$total = 0;
		} else {
			$total = $row_pos->total;
			$grand_total = $grand_total + $row_pos->total;
		}
		
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
			   '5' => $shift,
			   '6' => $total,
			   '7' => $status
		 );
		
		$i++;
		
		fputcsv($fp1, $detail, ';');
		
	}
	
}


$footer = array(
       '0' => '',
       '1' => '',
	   '2' => '',
	   '3' => '',
	   '4' => '',
	   '5' => 'Total',
	   '6' => $grand_total,
	   '7' => ''
);

fputcsv($fp2, $footer, ';');

?>

