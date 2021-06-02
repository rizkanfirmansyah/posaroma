<?php
include_once ("../app/include/queryfunctions.php");
include_once ("../app/include/functions.php");

$pilih = $_POST["button"];

switch ($pilih){
	case "getdata":
		$dbpdo = DB::create();
		
		$kode 			= $_POST['item_code2'];	
		$warehouse_id_from	= $_POST['warehouse_id_from'];
		$warehouse_id_to	= $_POST['warehouse_id_to'];
		$employee_id		= $_POST['employee_id'];
				
		$no = $kodex;
		$sqlstr 	= "select syscode, uom_code_stock uom_code, name from item where (code=trim('$kode') or old_code=trim('$kode')) limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data 	= $sql->fetch(PDO::FETCH_OBJ); 
		
		$item_code 		= $data->syscode;
		$uom_code		= $data->uom_code;
		$item_name		= $data->name;
		
		/*if($item_name == "") {
			$sqlcost = "select a.name from item a where a.syscode='$item_code' ";
			$sql=$dbpdo->prepare($sqlcost);
			$sql->execute();
			$datacost 	= $sql->fetch(PDO::FETCH_OBJ); 
			
			$item_name		= $datacost->name;
		}*/
		
?>		
		
			
			<input type="hidden" id="item_code" name="item_code" style="width: 100px" class="form-control" onKeyPress="return focusNext('submit_det',event)" value="<?php echo $item_code ?>" />			
			<!--<input type="hidden" id="warehouse_id_from" name="warehouse_id_from" value="<?php echo $warehouse_id_from; ?>" />
			<input type="hidden" id="warehouse_id_to" name="warehouse_id_to" value="<?php echo $warehouse_id_to; ?>" />-->
			
			<input type="text" id="item_code2" name="item_code2" style="width: 150px" onKeyPress="return focusNext('qty',event)" onchange="loadHTMLPost3('app/outbound_detail_ajax.php','item_ajax','getdata','item_code2','location_id2')" value="<?php echo $kode ?>" >
		
			<input type="text" id="item_name" name="item_name" readonly="" style="width: auto; min-width: 300px" value="<?php echo $item_name ?>" >
		
			<select id="uom_code" name="uom_code" style="height: 35px; width: auto;">
				<option value=""></option>
				<?php 
					select_uom($uom_code) 
				?>
			</select>
		
		
		
<?php
		
		break;	
		
	
	case "getdata2":
		$dbpdo = DB::create();
		
		$kode 			= $_POST['item_code'];	
		$warehouse_id_from	= $_POST['warehouse_id_from'];
		$warehouse_id_to	= $_POST['warehouse_id_to'];
		$employee_id		= $_POST['employee_id'];
		
		$no = $kodex;
		$sqlstr = "select code, syscode, uom_code_stock uom_code, name from item where (syscode=trim('$kode') or code=trim('$kode') or old_code=trim('$kode')) limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data 	= $sql->fetch(PDO::FETCH_OBJ); 
		
		$item_code 		= $kode; //$data->syscode;
		$item_code2 	= $data->code;
		$uom_code		= $data->uom_code;
		$item_name		= $data->name;
		
		/*if($item_name == "") {
			$sqlcost = "select a.name from item a where a.syscode='$item_code' ";
			$sql=$dbpdo->prepare($sqlcost);
			$sql->execute();
			$datacost 	= $sql->fetch(PDO::FETCH_OBJ);
			
			$item_name		= $datacost->name;
		}*/
		
?>		
			<input type="hidden" id="item_code" name="item_code" style="font-size: 11px; width: 60px" class="form-control" onKeyPress="return focusNext('submit_det',event)" value="<?php echo $item_code ?>" />			
			
			<td align="left">
				<input type="text" id="item_code2" name="item_code2" style="font-size: 11px; width: 150px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onchange="loadHTMLPost2('app/outbound_detail_ajax.php','item_ajax','getdata','item_code2')" value="<?php echo $item_code2 ?>" >
			</td>
			
			<td align="left">
				<input type="text" id="item_name" name="item_name" readonly="" style="font-size: 11px; width: auto; min-width: 300px" class="form-control" value="<?php echo $item_name ?>" >
			</td>
			
			<td>
				<select id="uom_code" name="uom_code" class="form-control" style="height: 35px; width: auto; font-size: 11px">
					<option value=""></option>
					<?php 
						select_uom($uom_code) 
					?>
				</select>	
			</td>
			<td align="center">
				<input type="text" id="qty" name="qty" style="text-align: right; font-size: 11px; width: 60px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('qty'), detailvalue2('persen')" autofocus="" value="1" >
			</td>
			
			<td>
				&nbsp;<input type="submit" id="submit_det" name="submit" class="btn btn-metis-2 btn-sm" value="Save Detail">
			</td>
		
		<!--</tr>-->
<?php
		
		break;
	
	
	default:
}
?>