<?php
		$sql=$select->list_purchase_return_quick_detail($ref);
		$jmldata = $sql->rowCount();
 ?>
 
 <table class="table table-bordered table-condensed table-hover table-striped" style="width: auto; font-size: 11px">
	<thead>
		<tr style="color: #168124; font-weight: bold; border: 1px solid #ccc; background-color: #e6ffea"> 
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
			<th><?php if($lng==1) { echo 'Delete'; } else { echo 'Hapus'; } ?></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		
			$total_item = 0;
			$grand_total_item = 0;
			
			$totalx = 0;
			$grand_total = 0;
			$no = 0;
			while($row_purchase_return_detail=$sql->fetch(PDO::FETCH_OBJ)) { 
			
				$qty = number_format($row_purchase_return_detail->qty, 2, '.', ',');
				$unit_cost = number_format($row_purchase_return_detail->unit_cost, 2, '.', ',');
				$discount_det = number_format($row_purchase_return_detail->discount, 2, '.', ',');
				$discount3_1_det = number_format($row_purchase_return_detail->discount1, 2, '.', ',');
                $amount = number_format($row_purchase_return_detail->amount, 2, '.', ',');
				
				$totalx = $totalx + $row_purchase_return_detail->amount;
				$grand_total = number_format($totalx, 2, '.', ',');
				
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
					<input type="text" id="item_code2_<?php echo $no ?>" name="item_code2_<?php echo $no ?>" class="form-control" readonly="" style="width: 100px" value="<?php echo $row_purchase_return_detail->item_code2; ?>" >
				</td>
				<td>				
					<input type="text" id="item_name_<?php echo $no ?>" name="item_name_<?php echo $no ?>" class="form-control" readonly="" style="width: 290px" value="<?php echo $row_purchase_return_detail->item_name; ?>" >
				</td>
				<td>
					<input type="text" id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" class="form-control" readonly="" style="width: 60px" value="<?php echo $row_purchase_return_detail->uom_code; ?>" >		
				</td>
				<td align="center">
					<input type="text" id="qty_<?php echo $no; ?>" name="qty_<?php echo $no; ?>" style="text-align: right; width: 60px" class="form-control" onkeyup="formatangka('qty_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'persen')" value="<?php echo $qty ?>" >
				</td>
				<td align="center">
					<input type="text" id="unit_cost_<?php echo $no; ?>" name="unit_cost_<?php echo $no; ?>" style="text-align: right; width: 100px" class="form-control" onkeyup="formatangka('unit_cost_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'persen')" value="<?php echo $unit_cost ?>" >
				</td>
				
				<td align="center" id="discount3_1_det_id<?php echo $no; ?>">
					<input type="text" id="discount3_1_<?php echo $no; ?>" name="discount3_1_<?php echo $no; ?>" style="text-align: right; width: 60px" class="form-control" onkeyup="formatangka('discount3_1_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'persen')" value="<?php echo $discount3_1_det ?>" >
				</td>
				
				<td align="right" id="discount_det_id<?php echo $no; ?>">
					<input type="text" id="discount_<?php echo $no; ?>" name="discount_<?php echo $no; ?>" style="text-align: right; width: 60px" class="form-control" onkeyup="formatangka('discount_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'nominal')" value="<?php echo $discount_det ?>" >
				</td>
				
				<td align="center" id="amount<?php echo $no; ?>">
					<input type="text" id="amount_<?php echo $no; ?>" name="amount_<?php echo $no; ?>" style="text-align: right; width: 100px" class="form-control" onkeyup="formatangka('amount_<?php echo $no; ?>')" readonly value="<?php echo $amount ?>" >
				</td>
				<td align="center">
					<input type="checkbox" id="delete_<?php echo $no; ?>" name="delete_<?php echo $no; ?>" class="form-control" value="1" >
					
				</td>
				
			</tr>
			<?php 
										
				$no++; 
				
			} 
			
			
			?>
			
			<tr style="background-color:ffffff;" id="item_ajax" > 
				<td>				
					<input type="text" id="item_code3" name="item_code3" class="form-control" style="width: 100px" autofocus="" onchange="loadHTMLPost3('app/purchase_return_quick_detail_ajax2.php','item_ajax','getdata','item_code3','location_id')" value="" >
				</td>
				<td>				
					<input type="text" id="item_name" name="item_name" class="form-control" readonly="" style="width: 290px" value="" >
				</td>
				<td>
					<input type="text" id="uom_code" name="uom_code" class="form-control" readonly="" style="width: 60px" value="" >		
				</td>
				<td align="center">
					<input type="text" id="qty" name="qty" style="text-align: right; width: 60px" class="form-control" readonly="" onkeyup="formatangka('qty'), detailvalue3('persen')" value="" >
				</td>
				<td align="center">
					<input type="text" id="unit_cost" name="unit_cost" style="text-align: right; width: 100px" class="form-control" onkeyup="formatangka('unit_cost'), detailvalue3('persen')" readonly="" value="" >
				</td>
				
				<td align="center" id="discount3_1_det_id">
					<input type="text" id="discount3_1_det" name="discount3_1_det" style="text-align: right; width: 60px" class="form-control" onkeyup="formatangka('discount3_1_det'), detailvalue3('persen')" value="" >
				</td>
				
				<td align="right" id="discount_det_id">
					<input type="text" id="discount_det" name="discount_det" style="text-align: right; width: 60px" class="form-control" onkeyup="formatangka('discount_det'), detailvalue3('nominal')" value="" >
				</td>
				
				<td align="center" id="amount_det">
					<input type="text" id="amount" name="amount" style="text-align: right; width: 100px" class="form-control" onkeyup="formatangka('amount')" readonly value="" >
				</td>
				<td align="center">
					&nbsp;
					
				</td>
				
			</tr>
			
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