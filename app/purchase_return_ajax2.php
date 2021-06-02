<?php
include_once ("../app/include/queryfunctions.php");
include_once ("../app/include/functions.php");

include '../app/class/class.select.php';
$select=new select;

$pilih = $_POST["button"];
switch ($pilih){
	case "getitempi":
		$pi_ref		 = $_POST["pi_ref"];	
		
		$sql=$select->get_pi_detail($pi_ref);
		$jmldata = $sql->rowCount();
		
?>		
		
		 <table class="table table-bordered table-condensed table-hover table-striped" style="width: auto">
			<thead>
				<tr> 
					<th>Item Name</th> 
					<th>Unit</th> 
					<th>Qty</th>
					<th>Unit Cost</th>
					<th>Amount</th>
					<th>Select</th>
				</tr>
			</thead>
			<tbody>
				<?php 
				
					$no = 0;
					while($row_sales_return_detail=$sql->fetch(PDO::FETCH_OBJ)) { 
					
					$qty = number_format($row_sales_return_detail->qty, 0, '.', ',');
					$unit_cost = number_format($row_sales_return_detail->unit_cost, 0, '.', ',');
					$amount = number_format($row_sales_return_detail->amount, 0, '.', ',');
					
				?>
					<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $jmldata; ?>" >
					
					<input type="hidden" id="item_code_<?php echo $no ?>" name="item_code_<?php echo $no ?>" value="<?php echo $row_sales_return_detail->item_code; ?>" >
					<input type="hidden" id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" value="<?php echo $row_sales_return_detail->uom_code; ?>" >
					<input type="hidden" id="line_item_pi_<?php echo $no ?>" name="line_item_pi_<?php echo $no ?>" value="<?php echo $row_sales_return_detail->line_pi; ?>" >
										
					<tr style="background-color:ffffff;"> 
						<td>							
							<?php 
								echo $row_sales_return_detail->code . " / " . $row_sales_return_detail->item_name;
							?>	

						</td>
						<td>
							<select id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" class="chosen-select form-control" style="height: 35px; width: auto;">
								<option value=""></option>
								<?php 
									select_uom($row_sales_return_detail->uom_code) 
								?>
							</select>	
						</td>
						<td align="center">
							<input type="text" id="qty_<?php echo $no; ?>" name="qty_<?php echo $no; ?>" style="text-align: right; width: 70px" class="form-control" onkeyup="formatangka('qty_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $qty ?>" >
						</td>
						<td align="center">
							<input type="text" id="unit_cost_<?php echo $no; ?>" name="unit_cost_<?php echo $no; ?>" style="text-align: right; width: 110px" class="form-control" onkeyup="formatangka('unit_cost_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $unit_cost ?>" >
						</td>
						<td align="center" id="amount<?php echo $no; ?>">
							<input type="text" id="amount_<?php echo $no; ?>" name="amount_<?php echo $no; ?>" style="text-align: right; width: 140px" class="form-control" onkeyup="formatangka('amount_<?php echo $no; ?>')" readonly value="<?php echo $amount ?>" >
						</td>
						<td align="center">
							<input type="checkbox" id="select_<?php echo $no; ?>" name="select_<?php echo $no; ?>" class="form-control" value="1" >
						</td>
						
					</tr>
					<?php 
						
						$no++; 
					} 
					
					?>
		
<?php
		break;
		
	default:
}
?>