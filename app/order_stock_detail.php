<?php
		$sql=$select->list_order_stock_detail($ref);
		$jmldata = $sql->rowCount();
 ?>
 
 <table class="table table-bordered table-condensed table-hover table-striped">
	<thead>
		<tr style="color: #168124; font-weight: bold; border: 1px solid #ccc; background-color: #e6ffea"> 
			<th><?php if($lng==1) { echo 'Item Name'; } else { echo 'Nama Barang'; } ?></th> 
			<th>Satuan</th> 									 
			<th><?php if($lng==1) { echo 'Qty'; } else { echo 'Jml Barang'; } ?></th>
			<th><?php if($lng==1) { echo 'Delete'; } else { echo 'Hapus'; } ?></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		
			$totalx = 0;
			$total2 = 0;
			$no = 0;
			while($row_cashier_detail=$sql->fetch(PDO::FETCH_OBJ)) { 
			
				$qty = number_format($row_cashier_detail->qty, 0, '.', ',');
				
		?>								
			<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $jmldata; ?>" >
			
			<input type="hidden" id="old_item_code_<?php echo $no ?>" name="old_item_code_<?php echo $no ?>" value="<?php echo $row_cashier_detail->item_code; ?>" >
			<input type="hidden" id="old_uom_code_<?php echo $no ?>" name="old_uom_code_<?php echo $no ?>" value="<?php echo $row_cashier_detail->uom_code; ?>" >
			<input type="hidden" id="old_line_<?php echo $no ?>" name="old_line_<?php echo $no ?>" value="<?php echo $row_cashier_detail->line; ?>" >
		
			<input type="hidden" id="item_code_<?php echo $no ?>" name="item_code_<?php echo $no ?>" value="<?php echo $row_cashier_detail->item_code; ?>" >	
			
			<input type="hidden" id="old_qty_<?php echo $no; ?>" name="old_qty_<?php echo $no; ?>" style="text-align: right; width: 70px" class="form-control" value="<?php echo $qty ?>" >
			
			<tr style="background-color:ffffff;" id="item_ajax2_<?php echo $no; ?>" > 
				
				<td>				
					<?php echo $row_cashier_detail->item_name; ?>	
					
				</td>
				<td>
					<input type="text" id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" class="form-control" readonly="" style="width: 50px" value="<?php echo $row_cashier_detail->uom_code; ?>" >		
				</td>
				<td align="center">
					<input type="text" id="qty_<?php echo $no; ?>" name="qty_<?php echo $no; ?>" style="text-align: right; font-size:12px " class="form-control" onkeyup="formatangka('qty_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $qty ?>" >
				</td>
				<td align="center">
					<input type="checkbox" id="delete_<?php echo $no; ?>" name="delete_<?php echo $no; ?>" class="ace" value="1" ><span class="lbl"></span>
					
				</td>				
			</tr>
			
			
			<?php 
										
				$no++; 
			} 
			
			?>
			
			
			<!----     detail add------------------->
			<tr style="border: 1px solid #cccccc;" id="item_ajax_<?php echo $no; ?>">
	          	<td style="border-right: 1px solid #cccccc;">
	          		
	          		<input type="hidden" id="item_code" name="item_code" class="form-control chzn-select-deselect" value="">
	          		
	          		<select id="item_code3_<?php echo $no ?>" name="item_code3_<?php echo $no ?>" class="chosen-select form-control" onchange="loadHTMLPost3('<?php echo $__folder ?>app/order_stock_detail_ajax.php','item_ajax_<?php echo $no; ?>','getdata_code2','item_code3_<?php echo $no; ?>','jmldata')" >
						<option value=""></option>
						<?php 
							select_item("")
						?>	
					</select>
					
	          	</td>
	          	
	          	<td style="border-right: 1px solid #cccccc;">
					<select id="uom_code" name="uom_code" class="form-control" style="height: 35px; width: auto;">
						<option value=""></option>
						<?php 
							select_uom("") 
						?>
					</select>	
				</td>
				<td align="left" style="border-right: 1px solid #cccccc;">
					<input type="text" id="qty" name="qty" style="text-align: right;" class="form-control" onkeyup="formatangka('qty'), detailvalue2()" autocomplete="off" value="" >
				</td>
	        </tr>
			<!----     end detail add--------------->				
	</tbody>
</table>