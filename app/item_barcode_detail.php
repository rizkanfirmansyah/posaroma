<?php
$sql=$select->list_item_barcode($location_id, $item_group_id, $item_subgroup_id, $item_code, $order_by);
$jmldata = mysql_num_rows($sql);
//echo $jmldata;		
?>		
		
<table class="table table-bordered table-condensed table-hover table-striped" style="width: 1000px; font-size: 12px">
	<thead>
		<tr> 
			<th>No.</th>
			<th>Item Code</th>
			<th>Item Name</th> 
			<th>Stock Unit</th>
        	<th>Sales Unit</th>
        	<th>Purchase Unit</th>
			<th>Current Price</th>
			<th>Barcode</th>
		</tr>
	</thead>
	<tbody>
	
		<input type="hidden" id="location_id" name="location_id" value="<?php echo $location_id; ?>" >
		<input type="hidden" id="item_group_id" name="item_group_id" value="<?php echo $item_group_id; ?>" >
		<input type="hidden" id="item_subgroup_id" name="item_subgroup_id" value="<?php echo $item_subgroup_id; ?>" >
		<input type="hidden" id="date" name="date" value="<?php echo $date; ?>" >
		
		<?php 
		
			$no = 0;
			while($row_item_set_price_detail=fetch_object($sql)) { 
			
				$item_code = $row_item_set_price_detail->syscode;
				$uom_code = $row_item_set_price_detail->uom_code_sales;
				$uom_code_stock = $row_item_set_price_detail->uom_code_stock;
				
				$sql2 = $select->list_get_set_price($location_id, $item_code, $uom_code);
				$dataset = mysql_fetch_object($sql2);
				
				$current_price = number_format($dataset->current_price, 0, '.', ',');							
				$last_price = number_format($dataset->last_price, 0, '.', ',');
				$hpp = number_format($dataset->cogs, 0, '.', ',');
				
				
			
		?>
			<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $jmldata; ?>" >
			<input type="hidden" id="item_code_<?php echo $no ?>" name="item_code_<?php echo $no ?>" value="<?php echo $row_item_set_price_detail->syscode; ?>" >
			
			<input type="hidden" id="uom_code_stock_<?php echo $no ?>" name="uom_code_stock_<?php echo $no ?>" value="<?php echo $uom_code_stock; ?>" >
			
			<tr style="background-color:ffffff;"> 
				<td align="center">							
					<?php 
						echo $no + 1 . ".";
					?>	

				</td>
				<td>							
					<?php 
						echo $row_item_set_price_detail->code;
					?>	

				</td>
				<td>							
					<?php 
						echo $row_item_set_price_detail->name;
					?>	

				</td>
				<td align="center">
					<?php
						echo $row_item_set_price_detail->uom_code_stock;
					?>
				</td>
				
				<td align="center">
					<?php
						echo $row_item_set_price_detail->uom_code_sales;
					?>
				</td>
				
				<td align="center">
					<?php
						echo $row_item_set_price_detail->uom_code_purchase;
					?>
				</td>
				
				<td align="right">
					<?php
						echo $current_price;
					?>
				</td>
				
				<td align="center">
					<input type="checkbox" id="select_<?php echo $no ?>" name="select_<?php echo $no ?>" onClick="select_barcode(<?php echo $jmldata ?>)" value="1" />
				</td>
										
			</tr>
			<?php 
				
				$no++; 
			} 
			
			?>
	</tbody>
</table>