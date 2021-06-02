<input type="hidden" id="item_code" name="item_code" style="font-size: 11px; width: 60px" class="form-control" value="<?php echo $item_code ?>" />

<div class="form-group">
	<div class="col-sm-12">
		<span style="color: #25af30; font-weight: bold;">
			<label style="width: 150px">Kode</label>
			<label style="width: 300px">Nama Barang</label>
			<label style="width: 70px">Satuan</label>
			<label style="width: 60px">Jumlah</label>
		</span>
	</div>
	
	<div class="col-sm-12">
		<span id="item_ajax">
			<input type="text" id="item_code2" name="item_code2" style=" width: 150px" onKeyPress="return focusNext('qty',event)" onchange="loadHTMLPost3('app/outbound_detail_ajax.php','item_ajax','getdata','item_code2','warehouse_id_from')" autofocus="" value="" />
		
			<input type="text" id="item_name" name="item_name" readonly="" style="width: auto; min-width: 300px" value="<?php echo $item_name ?>" >
		
			<select id="uom_code" name="uom_code" style="height: 35px; width: auto;">
				<option value=""></option>
				<?php 
					select_uom($uom_code) 
				?>
			</select>
			
		</span>
		<!--onKeyPress="return focusNext('submit_det',event)" -->
		<span class="input-icon">
			<input type="text" id="qty" name="qty" style="text-align: right; width: 60px" onkeyup="formatangka('qty'), detailvalue2()" autocomplete="off" value="" >
			
			<input type="submit" id="submit_det" name="submit" class="btn btn-metis-2 btn-sm" style="height: 34px" value="Save Detail">
		
		</span>
	</div>
</div>
							
					