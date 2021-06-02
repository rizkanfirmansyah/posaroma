<div class="form-group">
	<div class="col-sm-16">
		<span style="color: #25af30; font-weight: bold;">
			<input type="text" readonly="" style="width: 150px; margin-left: 12px" value="<?php if($lng==1) { echo 'Item Code'; } else { echo 'Kode'; } ?>">
			
			<input type="text" readonly="" style="width: 300px" value="<?php if($lng==1) { echo 'Item Name'; } else { echo 'Name Barang'; } ?>">
			
			<input type="text" readonly="" style="width: 53px" value="<?php if($lng==1) { echo 'Unit'; } else { echo 'Satuan'; } ?>">
			
			<input type="text" readonly="" style="width: 60px" value="<?php if($lng==1) { echo 'Qty'; } else { echo 'Jumlah'; } ?>">
			
			<input type="text" readonly="" style="width: 100px" value="<?php if($lng==1) { echo 'Unit Cost'; } else { echo 'Harga'; } ?>">
			
			<input type="text" readonly="" style="width: 90px" value="<?php if($lng==1) { echo 'Discount(%)'; } else { echo 'Discount(%)'; } ?>">
			
			<input type="text" readonly="" style="width: 90px" value="<?php if($lng==1) { echo 'Discount(Rp.)'; } else { echo 'Discount(Rp.)'; } ?>">
			
			<input type="text" readonly="" style="width: 100px" value="<?php if($lng==1) { echo 'Amount'; } else { echo 'Amount'; } ?>">
			
		</span>
	</div>
	
	
	<div class="col-sm-12">
		<span id="item_ajax">
			<input type="hidden" id="item_code" name="item_code" style="font-size: 11px; width: 60px" class="form-control" value="<?php echo $item_code ?>" />
			<input type="hidden" id="discount3_2_det" name="discount3_2_det" style="text-align: right; width: 90px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('discount3_2_det'), detailvalue2('persen')" value="" />	
			<input type="hidden" id="discount3_3_det" name="discount3_3_det" style="text-align: right; width: 90px" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('discount3_3_det'), detailvalue2('persen')" value="" />
			
			<input type="text" id="item_code2" name="item_code2" style="width: 150px" onchange="loadHTMLPost3('app/purchase_return_quick_detail_ajax.php','item_ajax','getdata','item_code2','location_id')" onKeyPress="return focusNext('qty',event)" autofocus="" value="" />
			<input type="text" id="item_name" name="item_name" readonly="" style="width: auto; min-width: 300px" value="<?php echo $item_name ?>" >
			
			<select id="uom_code" name="uom_code" style="height: 35px; width: auto;">
				<option value=""></option>
				<?php 
					select_uom($uom_code) 
				?>
			</select>
			
		</span>
		
		<span class="input-icon">
			<input type="text" id="qty" name="qty" style="text-align: right; width: 60px" oninput="loadHTMLPost5('app/purchase_return_quick_detail_qty_ajax.php','item_ajax_qty','getdata','item_code2','location_id','qty')" onKeyPress="return focusNext('unit_cost',event)" autocomplete="off" onkeyup="formatangka('qty'), detailvalue2()" value="" >
		</span>
		
		<span class="input-icon" id="item_ajax_qty">
			<input type="hidden" id="unit_cost" name="unit_cost" style="text-align: right; width: 100px" onKeyPress="return focusNext('discount3_1_det',event)" onkeyup="formatangka('unit_cost'), detailvalue2()" value="" >
			
			<input type="hidden" id="discount3_1_det" name="discount3_1_det" style="text-align: right; width: 90px" onKeyPress="return focusNext('discount_det',event)" onkeyup="formatangka('discount3_1_det'), detailvalue2('persen')" value="" >
			
			<input type="hidden" id="discount_det" name="discount_det" style="text-align: right; width: 90px" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('discount_det'), detailvalue2('nominal')" value="" >
			
			<input type="hidden" id="amount" name="amount" readonly="" style="text-align: right; width: 100px" onkeyup="formatangka('amount')" value="" >			
		</span>
		
		<span class="input-icon">
			<input type="hidden" id="submit_det" name="submit" class="btn btn-metis-2 btn-sm" style="height: 34px" value="Save Detail">
		</span>
		
	</div>
</div>
	
	
	