<?php
		$sql=$select->list_outbound_detail($ref);
		$jmldata = $sql->rowCount();
		
 ?>
 
 <table class="table table-bordered table-condensed table-hover table-striped" style="width: auto; font-size: 11px">
	<thead>
		<tr style="color: #168124; font-weight: bold; border: 1px solid #ccc; background-color: #e6ffea"> 
			<th><?php if($lng==1) { echo 'Item Code'; } else { echo 'Kode Barang'; } ?></th>
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
			while($row_outbound_detail=$sql->fetch(PDO::FETCH_OBJ)) { 
			
				$qty = number_format($row_outbound_detail->qty, 0, '.', ',');
				
				$totalx = $totalx + $row_outbound_detail->qty;
				$total2 = number_format($totalx, 0, '.', ',');
				
				
		?>								
			<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $jmldata; ?>" >
			
			<input type="hidden" id="old_item_code_<?php echo $no ?>" name="old_item_code_<?php echo $no ?>" value="<?php echo $row_outbound_detail->item_code; ?>" >
			<input type="hidden" id="old_uom_code_<?php echo $no ?>" name="old_uom_code_<?php echo $no ?>" value="<?php echo $row_outbound_detail->uom_code; ?>" >
			<input type="hidden" id="old_line_<?php echo $no ?>" name="old_line_<?php echo $no ?>" value="<?php echo $row_outbound_detail->line; ?>" >
		
			<input type="hidden" id="item_code_<?php echo $no ?>" name="item_code_<?php echo $no ?>" value="<?php echo $row_outbound_detail->item_code; ?>" >	
			
			
			<input type="hidden" id="old_qty_<?php echo $no; ?>" name="old_qty_<?php echo $no; ?>" style="text-align: right; width: 70px" class="form-control" value="<?php echo $qty ?>" >
			
			<tr style="background-color:ffffff;" id="item_ajax2_<?php echo $no; ?>" > 
				<td>				
					<input type="text" id="item_code2_<?php echo $no ?>" name="item_code2_<?php echo $no ?>" class="form-control" readonly="" style="width: auto; min-width: 150px" value="<?php echo $row_outbound_detail->item_code2; ?>" >
				</td>
				<td>				
					<input type="text" id="item_name_<?php echo $no ?>" name="item_name_<?php echo $no ?>" class="form-control" readonly="" style="width: auto; min-width: 300px" value="<?php echo $row_outbound_detail->item_name; ?>" >
				</td>
				<td>
					<input type="text" id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" class="form-control" readonly="" style="width: 50px" value="<?php echo $row_outbound_detail->uom_code; ?>" >		
				</td>
				<td align="center">
					<input type="text" id="qty_<?php echo $no; ?>" name="qty_<?php echo $no; ?>" style="text-align: right; font-size:11px " class="form-control" onkeyup="formatangka('qty_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'persen')" autocomplete="off" value="<?php echo $qty ?>" >
				</td>
				
				<td align="center">
					<input type="checkbox" id="delete_<?php echo $no; ?>" name="delete_<?php echo $no; ?>" class="form-control" value="1" >
					
				</td>
				
			</tr>
			<?php 
										
				$no++; 
			} 
			
				$grand_total	=	$total2;
			
				$uom_code = "pcs";
			?>
			
			<tr style="background-color:ffffff;" > 
				<td colspan="2">				
					<select id="item_code_<?php echo $no ?>" name="item_code_<?php echo $no ?>" class="chosen-select form-control" style="width: auto; font-size: 11px" >
						<option value=""></option>
						<?php 
							select_item("")
						?>	

					</select>
				</td>
				<td>
					<select id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" class="form-control" style="height: 35px; min-width: 70px;">
						<option value=""></option>
						<?php 
							select_uom($uom_code) 
						?>
					</select>
				</td>
				<td align="center">
					<input type="text" id="qty_<?php echo $no; ?>" name="qty_<?php echo $no; ?>" style="text-align: right; font-size:11px " class="form-control" onkeyup="formatangka('qty_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata+1 ?>', 'persen')" autocomplete="off" value="" >
				</td>
				
				<td align="center">
										
				</td>
				
			</tr>
			
			
			<tr>
				<td colspan="3" align="right" style="font-size: 14px; font-weight: bold;">Total Qty&nbsp;</td>
				<td align="right" id="total_id">
					<input type="text" id="total" name="total" readonly="" style="text-align: right; font-size: 14px; font-weight: bold;" onkeyup="formatangka('total')" value="<?php echo $grand_total ?>" >
				</td>
			</tr>
			
										
	</tbody>
</table>