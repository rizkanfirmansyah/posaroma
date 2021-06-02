<?php
		$sql=$select->list_purchase_return_get_detail($xndf);
		$jmldata 	= $sql->rowCount();
		
 ?>
 
 <table class="table table-bordered table-condensed table-hover table-striped" style="width: auto; font-size: 11px">
	<thead>
		<tr> 
			<th><?php if($lng==1) { echo 'Item Code'; } else { echo 'Kode Barang'; } ?></th>
			<th><?php if($lng==1) { echo 'Item Name'; } else { echo 'Nama Barang'; } ?></th> 
			<th>Satuan</th> 									 
			<th><?php if($lng==1) { echo 'Qty'; } else { echo 'Jml Barang'; } ?></th>	
			<th><?php if($lng==1) { echo 'Unit Cost'; } else { echo 'Harga Satuan'; } ?></th>
			<th><?php if($lng==1) { echo 'Discount(%)'; } else { echo 'Discount(%)'; } ?></th>
			<!--<th><?php if($lng==1) { echo 'Discount-2(%)'; } else { echo 'Discount-2(%)'; } ?></th>
			<th><?php if($lng==1) { echo 'Discount-3(%)'; } else { echo 'Discount-3(%)'; } ?></th>-->
			<th><?php if($lng==1) { echo 'Discount(Rp)'; } else { echo 'Discount(Rp)'; } ?></th>
			<th><?php if($lng==1) { echo 'Amount'; } else { echo 'Total'; } ?></th>
			<th><?php if($lng==1) { echo 'Update'; } else { echo 'Update'; } ?></th>
			<th><?php if($lng==1) { echo 'Delete'; } else { echo 'Hapus'; } ?></th>		
		</tr>
	</thead>
	<tbody>
		<?php 
		
			$total_item = 0;
			$grand_total_item = 0;
			
			$total = 0;
			$total2 = 0;
			$no = 0;
			$totalcek = 0;
			
			while($row_purchase_return_detail=$sql->fetch(PDO::FETCH_OBJ)) { 
			
				$qty = number_format($row_purchase_return_detail->qty, 2, '.', ',');
				$unit_cost = number_format($row_purchase_return_detail->unit_cost, 2, '.', ',');
				$discount3_1_det = number_format($row_purchase_return_detail->discount1, 2, '.', ',');
				$discount_det = number_format($row_purchase_return_detail->discount, 2, '.', ',');
				$amount = number_format($row_purchase_return_detail->amount, 2, '.', ',');
				
				$total = $total + $row_purchase_return_detail->amount;
				$total2 = $total; 
				
				$total_item = $total_item + $row_purchase_return_detail->qty;
				$grand_total_item = number_format($total_item, 2, '.', ',');
				
		?>								
				<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $jmldata; ?>" >
				
				<input type="hidden" id="old_item_code_<?php echo $no ?>" name="old_item_code_<?php echo $no ?>" value="<?php echo $row_purchase_return_detail->item_code; ?>" >
				<input type="hidden" id="old_uom_code_<?php echo $no ?>" name="old_uom_code_<?php echo $no ?>" value="<?php echo $row_purchase_return_detail->uom_code; ?>" >
				<input type="hidden" id="old_line_<?php echo $no ?>" name="old_line_<?php echo $no ?>" value="<?php echo $row_purchase_return_detail->line; ?>" >
				<input type="hidden" id="item_code_<?php echo $no ?>" name="item_code_<?php echo $no ?>" value="<?php echo $row_purchase_return_detail->item_code; ?>" >
				<input type="hidden" id="old_qty_<?php echo $no; ?>" name="old_qty_<?php echo $no; ?>" style="text-align: right; width: 70px" class="form-control" value="<?php echo $qty ?>" >				
				
				
				
				
				<tr style="background-color:ffffff;" id="item_ajax2_<?php echo $no; ?>" > 
					
					<td>				
						<input type="text" id="item_code2_<?php echo $no ?>" name="item_code2_<?php echo $no ?>" class="form-control" readonly="" style="width: 100px" value="<?php echo $row_purchase_return_detail->code; ?>" >
						
					</td>
					
					<td>				
						<input type="text" id="item_name_<?php echo $no ?>" name="item_name_<?php echo $no ?>" class="form-control" readonly="" style="width: 290px" value="<?php echo $row_purchase_return_detail->item_name; ?>" >
						
					</td>
					<td>
						<input type="text" id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" class="form-control" readonly="" style="width: 60px" value="<?php echo $row_purchase_return_detail->uom_code; ?>" >		
					</td>
					<td align="center">
						<input type="text" id="qty_<?php echo $no; ?>" name="qty_<?php echo $no; ?>" style="text-align: right; width: 60px" class="form-control" onkeyup="formatangka('qty_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>','persen')" value="<?php echo $qty ?>" >
					</td>
					<td align="center">
						<input type="text" id="unit_cost_<?php echo $no; ?>" name="unit_cost_<?php echo $no; ?>" style="text-align: right; width: 90px" class="form-control" onkeyup="formatangka('unit_cost_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>','persen')" value="<?php echo $unit_cost ?>" >
					</td>
					
					<td align="center" id="discount3_det_id<?php echo $no; ?>">
						<input type="text" id="discount3_1_<?php echo $no; ?>" name="discount3_1_<?php echo $no; ?>" style="text-align: right; width: 60px" class="form-control" onkeyup="formatangka('discount3_1_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>','persen')" value="<?php echo $discount3_1_det ?>" >
					</td>
					
					<td align="center" id="discount_det_id<?php echo $no; ?>">
						<input type="text" id="discount_<?php echo $no; ?>" name="discount_<?php echo $no; ?>" style="text-align: right; width: 70px" class="form-control" onkeyup="formatangka('discount_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>','nominal')" value="<?php echo $discount_det ?>" >
					</td>
					
					<td align="center" id="amount<?php echo $no; ?>">
						<input type="text" id="amount_<?php echo $no; ?>" name="amount_<?php echo $no; ?>" style="text-align: right; width: 100px" class="form-control" onkeyup="formatangka('amount_<?php echo $no; ?>')" readonly value="<?php echo $amount ?>" >
					</td>
					
					<td align="center">
						<a href="JavaScript:update('<?php echo $row_purchase_return_detail->ref ?>','<?php echo $no ?>')"><img src="assets/img/check.png" ></a>
					</td>
					
					<td align="center">
						<!--<input type="checkbox" id="delete_<?php echo $no; ?>" name="delete_<?php echo $no; ?>" class="form-control" value="1" >-->
						<a href="JavaScript:hapus('<?php echo $row_purchase_return_detail->ref ?>','<?php echo $row_purchase_return_detail->line ?>')"><img src="assets/img/delete.png" ></a>
					</td>
					
				</tr>
			<?php 
										
				$no++; 
			} 
			
			/*$memberlimit = ($totalcek * $discmember2)/100;
			$discount2 = $memberlimit;
		
			$total2 = $total - $memberlimit;*/
			$total2 = number_format($total2,2,".",",");
			$grand_total = $total2; //number_format($total2,0,".",",");
			
			##------------------/\----------------------
			
			$change_amount = numberreplace($cash_amount) - numberreplace($total2);
			##========================================/\
			
			?>  
			
			
			<tr>
				<td colspan="3" align="right" style="font-size: 14px; font-weight: bold;">Grand Total&nbsp;</td>
				
				<td align="right" id="total_item_id">
					<input type="text" id="total_item" name="total_item" readonly="" style="text-align: right; font-size: 14px; font-weight: bold; width: 60px" onkeyup="formatangka('total_item')" value="<?php echo $grand_total_item ?>" >
				</td>
				
				<td align="right" colspan="3" style="font-size: 14px; font-weight: bold;">&nbsp;</td>
				
				<td align="right" id="total_id">
					<input type="text" id="total" name="total" readonly="" style="text-align: right; font-size: 14px; font-weight: bold; width: 100px" onkeyup="formatangka('total')" value="<?php echo $grand_total ?>" >
				</td>
			</tr>
			
										
	</tbody>
</table>