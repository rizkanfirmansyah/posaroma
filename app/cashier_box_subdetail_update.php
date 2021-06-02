<script>
	function validateRow(frm)
	{
	  window.opener.document.location.href='../main.php?menu=app&act=8bbd9d0ff8f82e72fc95a60e7f8524d2&search=<?php echo $ref2 ?>';
	  self.close();
	}
</script>
<?php
		$sql=$select->list_cashier_box_subdetail($ref2, $line_detail);
		$jmldata = $sql->rowCount();
 ?>
 
<form class="form-horizontal" role="form" action="" method="post" name="cashier_box_detail_update" id="cashier_box_detail_update" enctype="multipart/form-data" >
 
	 <table class="table table-bordered table-condensed table-hover table-striped">
		<thead>
			<tr style="color: #168124; font-weight: bold; border: 1px solid #ccc; background-color: #e6ffea"> 
				<th><?php if($lng==1) { echo 'Item Name'; } else { echo 'Nama Barang'; } ?></th> 
				<th>Satuan</th> 									 
				<th><?php if($lng==1) { echo 'Qty'; } else { echo 'Jml Barang'; } ?></th>	
				<th><?php if($lng==1) { echo 'Unit Price'; } else { echo 'Harga Satuan'; } ?></th>
				<th><?php if($lng==1) { echo 'Amount'; } else { echo 'Total'; } ?></th>
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
					$unit_price = number_format($row_cashier_detail->unit_price, 0, '.', ',');
					$discount_det = number_format($row_cashier_detail->discount, 0, '.', ',');
	                $discount3_det = number_format($row_cashier_detail->discount3, 2, '.', ',');
					$amount = number_format($row_cashier_detail->amount, 0, '.', ',');
					
					$totalx = $totalx + $row_cashier_detail->amount;
					$total2 = number_format($totalx, 0, '.', ',');
					
					$note = $row_cashier_detail->note;
					
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
						<input type="text" id="qty_<?php echo $no; ?>" name="qty_<?php echo $no; ?>" style="text-align: right; font-size:12px " class="form-control" onkeyup="formatangka('qty_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" autocomplete="off" value="<?php echo $qty ?>" >
					</td>
					<td align="center">
						<input type="text" id="unit_price_<?php echo $no; ?>" name="unit_price_<?php echo $no; ?>" style="text-align: right; font-size:12px" class="form-control" onkeyup="formatangka('unit_price_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" autocomplete="off" value="<?php echo $unit_price ?>" >
					</td>
					<td align="center" id="amount<?php echo $no; ?>">
						<input type="text" id="amount_<?php echo $no; ?>" name="amount_<?php echo $no; ?>" style="text-align: right; font-size:12px" class="form-control" onkeyup="formatangka('amount_<?php echo $no; ?>')" readonly value="<?php echo $amount ?>" >
					</td>
					<td align="center">
						<input type="checkbox" id="delete_<?php echo $no; ?>" name="delete_<?php echo $no; ?>" class="ace" value="1" ><span class="lbl"></span>
						
					</td>
					
				</tr>
				<?php 
											
					$no++; 
				} 
				
				?>
								
		</tbody>
	</table>

	<div class="clearfix form-actions">
		<div class="col-md-offset-3 col-md-9">
	        
	        <input type="submit" name="submit" id="submit" class='btn btn-primary' value="Update" />
	        
	        &nbsp;&nbsp;
	        <input type="button" name="submit" class='btn btn-warning' value="Closed" onclick="validateRow('cashier_box_detail_update');" >

	    </div>
	</div>
</form>	        
