<?php
session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$namafile = "List_Pesanan_Kotakan.csv";

header("Content-Type: application/csv");
header("Content-Disposition: attachment;filename=".$namafile." ");

include_once ("include/queryfunctions.php");
include_once ("include/functions.php");
//include_once ("include/function_excel.php");

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
    '0' => 'DAFTAR PESANAN KOTAKAN'
);
fputcsv($fp, $header, ';');

$header = array(
    '0' => ''
);
fputcsv($fp, $header, ';');
 
$header = array(
    '0' => 'No.',
	'1' => 'No.Nota',
	'2' => 'No. Bon',
	'3' => 'Tanggal',
	'4' => 'Tgl Jatuh Tempo',
	'5' => 'Umur Piutang',
	'6' => 'Status',
	'7' => 'Customer',
	'8' => 'Total',
	'9' => 'Uang Muka',
	'10' => 'Sisa Bayar',
	'11' => 'Kasir'
 );

fputcsv($fp, $header, ';');


//detail
$total_amount = 0;
$total_deposit = 0;
$total_sisa = 0;

$i = 0;
$sql=$select->list_cashier_box('', $all, $from_date, $to_date, $shift, $cashier, $receipt_type_pos, $void);
while($row_cashier=$sql->fetch(PDO::FETCH_OBJ)){

	$i++;
	
	$bgcolor = "";
	$status = "";
	if ($row_cashier->void == 1) {
		$status = "Batal";
		$bgcolor = 'style="background-color: #730000; color: #ffffff"';
	}
	
	//get AR (Pelunasan)
	$sqlar = $select->get_ar($row_cashier->client_code, $row_cashier->ref);
	$data_ar = $sqlar->fetch(PDO::FETCH_OBJ);
	
	$total = 0;
	$deposit = 0;
	$sisa = 0;
	
	if( $row_cashier->void == 0) {
		$total = $row_cashier->total;
		$deposit = $row_cashier->deposit;
		$sisa = $row_cashier->total-$row_cashier->deposit-$row_cashier->cash_amount-$row_cashier->ovo-$row_cashier->bank_amount-$row_cashier->gopay-$row_cashier->cash_voucher-$data_ar->debit_amount;
		
		$total_amount = $total_amount + $row_cashier->total;
		$total_deposit = $total_deposit + $row_cashier->deposit;
		$total_sisa = $total_sisa + ($row_cashier->total-$row_cashier->deposit-$row_cashier->cash_amount-$row_cashier->ovo-$row_cashier->bank_amount-$row_cashier->gopay-$row_cashier->cash_voucher-$data_ar->debit_amount);
		
		//-------aging check
		$bgcolor_duedate = "";
		$tgl1 = new DateTime(date('Y-m-d'));
		$tgl2 = new DateTime($row_cashier->due_date);
		$day = $tgl2->diff($tgl1)->days; //+ 1;
		//$day = date_diff($tgl1,$tgl2);
		if($row_cashier->due_date > date('Y-m-d') && $sisa > 0) {
			$aging = $day;
		} else if($row_cashier->due_date < date('Y-m-d') && $sisa > 0) {
			$bgcolor_duedate = 'style="background-color: #e60000; color: #ffffff"';
			$aging = 'lewat '.$day.' hari';	
		} else {
			$aging = 'LUNAS';	
		}
		//------------------
	}

	$j++;
    
	$detail = array(
		'0' => $i,
		'1' => $row_cashier->ref,
		'2' => $row_cashier->ref2,
		'3' => date('d-m-Y', strtotime($row_cashier->date)),
		'4' => date('d-m-Y', strtotime($row_cashier->due_date)),
		'5' => $aging,
		'6' => $status,
		'7' => $row_cashier->client_name,
		'8' => $total,
		'9' => $deposit,
		'10' => $sisa,
		'11' => $row_cashier->uid,
	);
	
	fputcsv($fp1, $detail, ';');
	
}

$footer = array(
	'0' => '',
	'1' => '',
	'2' => '',
	'3' => '',
	'4' => '',
	'5' => '',
	'6' => '',
	'7' => 'Total',
	'8' => $total_amount,
	'9' => $total_deposit,
	'10' => $total_sisa
);

fputcsv($fp2, $footer, ';');

?>

