<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

header('Content-type: application/json');

include_once ("../app/include/sambung.php");
include_once ("../app/include/functions.php");

include '../app/class/class.select.php';
include '../app/class/class.selectview.php';

$select = new select;
$selectview = new selectview;

$from_date	            =    $_REQUEST['from_date'];
$to_date		    	=    $_REQUEST['to_date'];
$shift	          		=    $_REQUEST['shift'];
$cashier				=	 $_REQUEST['uid'];
$all			       	=    $_REQUEST['all'];
$void			       	=    $_REQUEST['void_'];
$receipt_type_pos		=	 $_REQUEST['receipt_type_pos'];

if($from_date == "") {
	$from_date = date("d-m-Y");
}

if($to_date == "") {
	$to_date = date("d-m-Y");
}

if($all == 1 || $all == true) {
	$all = 1;
}

$sql = $selectview->list_pos_print_total('', $all, $from_date, $to_date, $shift, $cashier, $void, 1);
$row_cash_invoice=$sql->fetch(PDO::FETCH_OBJ);

$ref			=	$row_cash_invoice->ref;
$date			=	date("d-m-Y", strtotime($row_cash_invoice->date));

$total 			= 	$row_cash_invoice->total;

##get nama cabang
$sqlwhs = $select->list_warehouse($row_cash_invoice->location_id);
$datawhs = $sqlwhs->fetch(PDO::FETCH_OBJ);
$alamattoko = $datawhs->address;

$string = "";
$sqlcsr = $selectview->get_kasir($cashier);
while($data_kasir = $sqlcsr->fetch(PDO::FETCH_OBJ)) {
	
	$sqldsc = $selectview->list_pos_print_total('', "", $from_date, $to_date, $shift, $data_kasir->uid, $void, 1);
	$data_total = $sqldsc->fetch(PDO::FETCH_OBJ);
	$total = $data_total->total;
	
	$sql2 = $selectview->list_pos_print_total('', "", $from_date, $to_date, $shift, $data_kasir->uid, $void, 1);
	$rows = $sql2->rowCount();
	
	
	$shift_name = "";
	if($shift == 1) {
		$shift_name = "Pagi";	
	}
	if($shift == 2) {
		$shift_name = "Malam";	
	}
	
	//discount
	$sql5 = $selectview->close_cash_invoice_detail($from_date, $to_date, $shift, $data_kasir->uid, $receipt_type_pos, $void, 1);
	while($row_discount_detail=$sql5->fetch(PDO::FETCH_OBJ)) {
		$total_discount = $total_discount + $row_discount_detail->discount;
		
		/*if($row_discount_detail->void == 0) {
			$amount = $row_discount_detail->qty * $row_discount_detail->unit_price; //$row_cash_detail->amount;	
			
			$sub_total = $sub_total + $amount;
		}*/
	}
	
	//get jumlah nota
	$sqlinv=$select->list_pos_valid('', '', $from_date, $to_date, $shift, $cashier, $receipt_type_pos, $void, 1);
	$rows_inv = $sqlinv->rowCount();
	$count_invoice = $count_invoice + $rows_inv;
	
	$string = '[{
		"shift": "' . $shift .'",
		"uid": "' . $data_kasir->uid .'",
		"total_discount": "' . $total_discount .'",
		"total": "' . $total .'",
	    "sub_total": "' . $sub_total .'",
	    "address": "' . $datawhs->address .'",
	    "phone": "' . $datawhs->phone .'",
	    "count_invoice": "' . $count_invoice .'",   
	    "data": [
	      ';
		
			//----------detail		
			$rows2 = 0;
			$grand_total = 0;
			$total_discount = $data_total->discount;
			
				  
			while($row_cash_invoice_detail = $sql2->fetch(PDO::FETCH_OBJ)){
		    	
				$i = 0;	
				$count_invoice = 0;
				$total_qty = 0;
				$total_qty_void = 0;
				$sub_total = 0;
				$sql3 = $selectview->close_cash_invoice_detail($from_date, $to_date, $shift, $data_kasir->uid, $receipt_type_pos, $void, 1);
				$rows2 = $sql3->rowCount();
				while($row_cash_detail=$sql3->fetch(PDO::FETCH_OBJ)) {
					
					$amount = 0;
					$qty2 = 0;
					$qty_void = 0;
					if($row_cash_detail->void == 0) {
						$amount = $row_cash_detail->qty * $row_cash_detail->unit_price; //$row_cash_detail->amount;	
						$qty2 = $row_cash_detail->qty;
						
					} else {
						$qty_void = $row_cash_detail->qty;
					}
					$qty = $row_cash_detail->qty;
					
					$i++;
					if($i < $rows2) {
						$string = $string .  '{
						    "ref":"'.$row_cash_detail->ref.'",
						    "item_name":"'.$row_cash_detail->item_name.'",
						    "uom_code":"'.$row_cash_detail->uom_code.'",
				            "discount":"'.$row_cash_detail->discount.'",
				            "unit_price":"'.$row_cash_detail->unit_price.'",
				            "amount":"'.$amount.'",
				            "qty":"'.$qty2.'",
				            "qty_void":"'.$qty_void.'",
				            "void":"'.$row_cash_detail->void.'"
						  },';
					} else {
						$string = $string .  '{
						    "ref":"'.$row_cash_detail->ref.'",
						    "item_name":"'.$row_cash_detail->item_name.'",
						    "uom_code":"'.$row_cash_detail->uom_code.'",
				            "discount":"'.$row_cash_detail->discount.'",
				            "unit_price":"'.$row_cash_detail->unit_price.'",
				            "amount":"'.$amount.'",
				            "qty":"'.$qty2.'",
				            "qty_void":"'.$qty_void.'",
				            "void":"'.$row_cash_detail->void.'"
						  }';
					}				
				}
			}	
		
		$string = '' . $string . ']}]';
	  	echo $string; //json_encode($string);
	
}

?>
