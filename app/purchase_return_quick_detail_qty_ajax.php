<?php
include_once ("../app/include/queryfunctions.php");
include_once ("../app/include/functions.php");
include_once ("../app/class/class.selectview.php");

$pilih = $_POST["button"];
$selectview = new selectview;

switch ($pilih){
	case "getdata":
		$dbpdo = DB::create();
		
		$kode 			= $_POST['item_code2'];	
		$location_id	= $_POST['location_id'];
		$location_id2	= $_POST['location_id2'];
		if($location_id2 == "") {
			$location_id2 = $location_id;
		}
		
		$qty 			= numberreplace($_POST['qty']);
		
		$no = $kodex;
		$sqlstr 	= "select syscode, uom_code_purchase uom_code from item where (code=trim('$kode') or old_code=trim('$kode')) limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data 	= $sql->fetch(PDO::FETCH_OBJ); 
		
		$item_code 	= $data->syscode;
		$uom_code	= $data->uom_code;
		$current_cost 	= $selectview->list_purchase_invoice_last_cost($item_code, $uom_code);
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
		$tax_rate = $datadisc->tax_rate;
		
		$total_rate = (((numberreplace($current_cost) * $qty) - $discount) * $tax_rate)/100;
		
		$amount			= ((numberreplace($current_cost) * $qty) - $discount) + $total_rate;
		$amount			= number_format($amount,2,".",",");
		$current_cost	= number_format($current_cost,2,".",",");
		
		
?>		
		
			
			<input type="text" id="unit_cost" name="unit_cost" style="text-align: right; width: 100px" onKeyPress="return focusNext('discount3_1_det',event)" onkeyup="formatangka('unit_cost'), detailvalue2('persen')" value="<?php echo $current_cost ?>" />
			
            <span class="input-icon" id="discount3_1_det_id">
    			<input type="text" id="discount3_1_det" name="discount3_1_det" style="text-align: right; width: 90px" onKeyPress="return focusNext('discount_det',event)" onkeyup="formatangka('discount3_1_det'), detailvalue2('persen')" value="<?php echo $discount1 ?>" >
    		</span>
    		
            <span class="input-icon" id="discount_det_id">	
				<input type="text" id="discount_det" name="discount_det" style="text-align: right; width: 90px" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('discount_det'), detailvalue2('nominal')" value="<?php echo $discount ?>" >
			</span>
			
			<span class="input-icon" id="amount_det">
				<input type="text" id="amount" name="amount" readonly="" style="text-align: right; width: 100px" onkeyup="formatangka('amount')" value="<?php echo $amount ?>" >
			</span>
			
			<span class="input-icon">
				&nbsp;<input type="submit" id="submit_det" name="submit" class="btn btn-metis-2 btn-sm" value="Save Detail" onClick="return confirm('Apakah data sudah betul?')">
			</span>
			
<?php
		
		break;	
			
	default:
}
?>