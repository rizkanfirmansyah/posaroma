<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

header('Content-type: application/json');

include_once ("../app/include/sambung.php");
include_once ("../app/include/functions.php");
//$dbpdo = DB::create(); 
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

$sql = $selectview->list_pos_print_total('', $all, $from_date, $to_date, $shift, $cashier, $void);
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
	
	$invoice_count = 0;
	$sqldsc = $selectview->list_pos_print_y('', "", $from_date, $to_date, $shift, $data_kasir->uid, $void);
	while($data_total = $sqldsc->fetch(PDO::FETCH_OBJ)) {
		$invoice_count++;
	}
	
	$sql2 = $selectview->list_pos_print_total('', "", $from_date, $to_date, $shift, $data_kasir->uid, $void);
	$rows = $sql2->rowCount();
	
	$shift_name = "";
	if($shift == 1) {
		$shift_name = "Pagi";	
	}
	if($shift == 2) {
		$shift_name = "Malam";	
	}
	
	//discount
	$qty_void = 0;
	$sql5 = $selectview->close_cash_invoice_detail($from_date, $to_date, $shift, $data_kasir->uid, $receipt_type_pos, $void);
	while($row_discount_detail=$sql5->fetch(PDO::FETCH_OBJ)) {
		$total_discount = $total_discount + $row_discount_detail->discount;
		$total_qty = $total_qty + $row_discount_detail->qty;
		
		if($row_discount_detail->void == 0) {
			$amount = $row_discount_detail->qty * $row_discount_detail->unit_price; //$row_cash_detail->amount;	
			
			$sub_total = $sub_total + $amount;
		}
		
	}
	
	$grand_total = $sub_total-$total_discount;
	
	//get qty void
	$sql4 = $selectview->list_adt_pos_detail_z('', $from_date, $to_date, $shift, $data_kasir->uid);
	while($row_void=$sql4->fetch(PDO::FETCH_OBJ)) {
		$qty_void = $qty_void + $row_void->qty;	
	}
	
	
	$string = '[{
		"shift": "' . $shift .'",
		"uid": "' . $data_kasir->uid .'",
		"total_discount": "' . $total_discount .'",
		"total_qty": "' . $total_qty .'",
		"qty_void": "' . $qty_void .'",
		"invoice_count": "' . $invoice_count .'",
		"total": "' . $total .'",
	    "sub_total": "' . $sub_total .'",
	    "grand_total": "' . $grand_total .'",
	    "address": "' . $datawhs->address .'",
	    "phone": "' . $datawhs->phone .'",   
	    "data": [
	      ';
		
			//----------detail		
			$rows2 = 0;
			
			$total_discount = $data_total->discount;
			
						  
			while($row_cash_invoice_detail = $sql2->fetch(PDO::FETCH_OBJ)){
		    	
				
				$i = 0;	
				$count_invoice = 0;
				$total_qty = 0;
				$total_qty_void = 0;
				$sub_total = 0;
				$sql3 = $selectview->list_pos_print_z_sum('', '', $from_date, $to_date, $shift, $data_kasir->uid, $void, 0);
				$rows2 = $sql3->rowCount();
				$row_cash_detail=$sql3->fetch(PDO::FETCH_OBJ);
					
					$count_invoice++;			
					//$grand_total = $grand_total + $row_cash_detail->total;
					
			
				//end invoice
				$sql3__ = $selectview->list_pos_print_z_sum('', '', $from_date, $to_date, $shift, $data_kasir->uid, $void, 1);
				$rows3 = $sql3__->rowCount();
				$row_cash_detail2=$sql3__->fetch(PDO::FETCH_OBJ);	
					
					$i++;
					if($rows2 > 0) {
						$string = $string .  '{
						    "ref":"'. date("H:i", strtotime($row_cash_detail->dlu)) . ' ' . $row_cash_detail->ref.'"
						  },';
					} 
					
					if($rows3 > 0) {
						$string = $string .  '{
						    "ref":"'. date("H:i", strtotime($row_cash_detail2->dlu)) . ' ' . $row_cash_detail2->ref.'"
						  }';
					}				
				//}
			}	
		
		$string = '' . $string . ']}]';
	  	echo $string; //json_encode($string);
	
}

?>
