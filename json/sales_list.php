<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: X-Requested-With');
header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept');

header('Content-type: application/json');

include_once ("../app/include/sambung.php");
include_once ("../app/include/functions.php");
$dbpdo = DB::create(); 

$json = json_decode(file_get_contents('php://input'),true);
$ref	= $_GET['ref'];

$strsql = "select a.ref, a.ref2, a.date, a.due_date, a.status, a.top, a.client_code, b.name client_name, b.phone, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.cash, a.bank_amount, a.ovo, a.gopay, a.location_id, ifnull(a.deposit,0) deposit, a.discount, a.cash_amount, a.cash_voucher, a.change_amount, a.void, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode where a.ref='$ref'";

$hasil_cek = $dbpdo->query($strsql);
$rows = $hasil_cek->rowCount();

$string = "";
//$httpimage = "https:\/\/epos.acherryautocool.com\/app\/photo_item\/";

if( $rows > 0 ){
	$data = $hasil_cek->fetch(PDO::FETCH_OBJ);
	
	$sqlstr="select a.id, a.code, a.name, a.address, a.email, a.phone, a.active, a.uid, a.dlu from warehouse a where a.id='$data->location_id' order by a.id";
	$sqlwhs = $dbpdo->query($sqlstr);
	$datawhs = $sqlwhs->fetch(PDO::FETCH_OBJ);
		
	$string = '[{
		"ref": "' . $data->ref .'",
	    "client_code": "' . $data->client_code .'",
	    "location_id": "' . $data->location_id .'",
	    "address": "' . $datawhs->address .'",
	    "phone": "' . $datawhs->phone .'",
	    "date": "' . date("d-m-Y", strtotime($data->date)) .'",
	    "discount": "' . $data->discount .'",
	    "total": "' . $data->total .'",
	    "cash_amount": "' . $data->cash_amount .'",
	    "change_amount": "' . $data->change_amount .'",
	    "cash_voucher": "' . $data->cash_voucher .'",
	    "ovo": "' . $data->ovo .'",
	    "bank_amount": "' . $data->bank_amount .'",
	    "gopay": "' . $data->gopay .'",
	    "void": "' . $data->void .'",
	    "data": [
	      ';
		
			//----------detail		
			$rows2 = 0;
			$strsql2 = "select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.name item_name, a.item_name2, a.uom_code, a.qty, a.discount, a.discount3, a.unit_price, a.unit_price2, a.amount, a.amount2, a.dummy, a.line_item_do, a.line_item_so, a.line from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$ref' order by a.line";
			$hasil_cek2 = $dbpdo->query($strsql2);		
			$rows2 = $hasil_cek2->rowCount();
			
			$i = 0;				  
			while($data2 = $hasil_cek2->fetch(PDO::FETCH_OBJ)){
		    	
				$i++;
				
				if($i < $rows2) {
					$string = $string .  '{
					    "item_name":"'.$data2->item_name.'",
			            "qty":"'.$data2->qty.'",
			            "unit_price":"'.$data2->unit_price.'",
			            "discount":"'.$data2->discount.'",
			            "amount":"'.$data2->amount.'",
			            "discount3":"'.$data2->discount3.'"
					  },';
				} else {
					$string = $string .  '{
					    "item_name":"'.$data2->item_name.'",
			            "qty":"'.$data2->qty.'",
			            "unit_price":"'.$data2->unit_price.'",
			            "discount":"'.$data2->discount.'",
			            "amount":"'.$data2->amount.'",
			            "discount3":"'.$data2->discount3.'"
					  }';
				}
				
				
			}	
		
		$string = '' . $string . ']}]';
	  	echo $string; //json_encode($string);
	
} else {
	$string = '{
	    "data": [
	      ';
	      
	$string = $string .  '{
			    "ref": "' . '' .'",
			    "date": "' . '' .'",
			    "total": "'.''.'"
			  }';
	$string = '' . $string . ']}]';
  	echo $string;
	      
}

?>
