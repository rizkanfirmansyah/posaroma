 <table class="table table-bordered table-condensed table-hover table-striped">
	<thead>
		<tr style="color: #168124; font-weight: bold; border: 1px solid #ccc; background-color: #e6ffea"> 
			<th><?php if($lng==1) { echo 'Item Code'; } else { echo 'Kode Barang'; } ?></th>
			<th>Satuan</th> 									 
			<th><?php if($lng==1) { echo 'Qty'; } else { echo 'Qty'; } ?></th>
		</tr>
	</thead>
	<tbody>
		<?php $no = 0; ?>
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
        
        <input type="hidden" id="jmldata" name="jmldata" value="0">	
										
	</tbody>
</table>