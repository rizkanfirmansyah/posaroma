<?php
include_once ("../app/include/queryfunctions.php");
include_once ("../app/include/functions.php");
include_once ("../app/class/class.selectview.php");

$pilih = $_POST["button"];
$selectview = new selectview;

$exp = explode("|",$pilih,7);
$pilih = $exp[0];
$kodex = $exp[1];

switch ($pilih){
	case "getdata":
		$dbpdo = DB::create();
		
		$kode 			= $_POST['item_code3'];	
		$no 			= $kodex;
		$jmldata		= $kodex;
		
		$location_id	= $_POST['location_id'];
		$location_id2	= $_POST['location_id2'];
		if($location_id2 == "") {
			$location_id2 = $location_id;
		}
		
		
		$sqlstr 	= "select syscode, uom_code_purchase uom_code from item where (code='$kode' or old_code='$kode') limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data 	= $sql->fetch(PDO::FETCH_OBJ); 
		
		$item_code 	= $data->syscode;
		$uom_code	= $data->uom_code;
		
		$current_cost 	= $selectview->list_purchase_invoice_last_cost($item_code, $uom_code);
		//$current_cost	= number_format($current_cost,2,".",",");
		$item_name		= ""; //$datacost->name;
		//$non_discount	= $datacost->non_discount;
		
		
		if($item_name == "") {
			$sqlcost = "select a.name from item a where a.syscode='$item_code' ";
			$sql=$dbpdo->prepare($sqlcost);
			$sql->execute();
			$datacost 	= $sql->fetch(PDO::FETCH_OBJ); 
			
			$item_name		= $datacost->name;
		}
		
		//get discount terakhir dr pembelian
		$discount1 = 0;
		$discount = 0;
		$sqldisc = $selectview->list_purchase_invoice_last_discount($item_code, $uom_code);
		$datadisc = $sqldisc->fetch(PDO::FETCH_OBJ); 
		$discount1 = $datadisc->discount1;
		$discount = $datadisc->discount;
		
		$qty 			= number_format("1",2,".",",");
		$amount			= (numberreplace($current_cost) * 1) - $discount;
		$amount			= number_format($amount,2,".",",");
		$current_cost	= number_format($current_cost,2,".",",");
?>		
			
			<td>				
					<input type="text" id="item_code3" name="item_code3" class="form-control" style="width: 100px" onchange="loadHTMLPost3('app/purchase_return_quick_detail_ajax2.php','item_ajax','getdata','item_code3','location_id')" value="<?php echo $kode ?>" >
				</td>
				<td>				
					<input type="text" id="item_name" name="item_name" class="form-control" readonly="" style="width: 290px" value="<?php echo $item_name ?>" >
				</td>
				<td>
					<input type="text" id="uom_code" name="uom_code" class="form-control" readonly="" style="width: 60px" value="<?php echo $uom_code ?>" >		
				</td>
				<td align="center">
					<input type="text" id="qty" name="qty" style="text-align: right; width: 60px" class="form-control"  onkeyup="formatangka('qty'), detailvalue3('persen')" autofocus="" value="<?php echo $qty ?>" >
				</td>
				<td align="center">
					<input type="text" id="unit_cost" name="unit_cost" style="text-align: right; width: 100px" class="form-control" onkeyup="formatangka('unit_cost'), detailvalue3('persen')" value="<?php echo $current_cost ?>" >
				</td>
				
				<td align="center" id="discount3_1_det_id">
					<input type="text" id="discount3_1_det" name="discount3_1_det" style="text-align: right; width: 60px" class="form-control" onkeyup="formatangka('discount3_1_det'), detailvalue3('persen')" value="<?php echo $discount1 ?>" >
				</td>
				
				<td align="right" id="discount_det_id">
					<input type="text" id="discount_det" name="discount_det" style="text-align: right; width: 60px" class="form-control" onkeyup="formatangka('discount_det'), detailvalue3('nominal')" value="<?php echo $discount ?>" >
				</td>
				
				<td align="center" id="amount_det">
					<input type="text" id="amount" name="amount" style="text-align: right; width: 100px" class="form-control" onkeyup="formatangka('amount')" readonly value="<?php echo $amount ?>" >
				</td>
				<td align="center">
					&nbsp;
					
				</td>
		
		<!--</tr>-->
<?php

		
		break;
		
	
	default:
}
?>