<table class="table table-striped table-bordered table-hover">
    <tr>
        <td colspan="2">
			<select id="item_code" name="item_code" class="chosen-select form-control" style="width: 200px; font-size: 12px" onKeyPress="return focusNext('item_code2',event)" onchange="loadHTMLPost3('app/cashier_detail_ajax.php','item_ajax','getdata2','item_code','location_id')" >
				<option value=""></option>
				<?php 
					select_item("")
				?>	

			</select>	
		</td>
		
		<!--<td colspan="1">
            &nbsp;&nbsp;
            <a href="javascript:void(0);" name="Find" title="Find" onClick=window.open("app/cashier_item_lup.php","Find","width=900,height=500,left=200,top=20,toolbar=0,status=0,scroll=1,scrollbars=no");><img src="assets/img/plus.png" /></a>
            
        </td>-->
    </tr>
	<tr style="color: #168124; font-weight: bold; border: 1px solid #ccc; background-color: #e6ffea">
		<td>Kode</td>
		<td>Nama Barang</td>
		<td>Nama Barang-2</td>
		<td>Satuan</td>
		<td>Qty</td>
		<td>Harga</td>
		<td>Discount</td>
        <td>Discount (%)</td>
		<td>Jumlah</td>
		<td>Note</td>
		<td></td>
	</tr>
	<tr style="background-color:ffffff;" id="item_ajax" > 
        		
		<td align="left" colspan="1">
            
            <input type="hidden" id="item_code" name="item_code" style="font-size: 12px; width: 100px" class="form-control" value="<?php echo $item_code ?>" >
            
            <input type="text" id="item_code2" name="item_code2" style="font-size: 12px; width: 120px" class="form-control" onchange="loadHTMLPost3('app/cashier_detail_ajax.php','item_ajax','getdata','item_code2','location_id')" value="" >
            
            <!--
			<input type="text" id="item_code2" name="item_code2" style="font-size: 12px; width: 100px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onchange="loadHTMLPost2('app/cashier_detail_ajax.php','item_ajax','getdata','item_code2')" value="" > -->
		</td>
			
		
		
		
		<td align="left">
			<input type="text" id="item_name" name="item_name" readonly="" style="font-size: 12px; width: auto" class="form-control" value="<?php echo $item_name ?>" >
		</td>
		<td>				
			<input type="text" id="item_name2_<?php echo $no ?>" name="item_name2_<?php echo $no ?>" class="form-control" style="width: auto" value="<?php echo $item_name2; ?>" >			
			
		</td>
		<td>
			<select id="uom_code" name="uom_code" class="form-control" style="height: 35px; min-width: 50px; font-size: 12px">
				<option value=""></option>
				<?php 
					select_uom($uom_code) 
				?>
			</select>	
		</td>
		<td align="center">
			<input type="text" id="qty" name="qty" style="text-align: right; font-size: 12px; width: 60px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('qty'), detailvalue2()" value="" >
		</td>
		<td align="center">
			<input type="text" id="unit_price" name="unit_price" style="text-align: right; font-size: 12px; width: 100px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('unit_price'), detailvalue2()" value="" >
		</td>
		
		<td align="center">
			<input type="text" id="discount_det" name="discount_det" style="text-align: right; font-size: 12px; width: 90px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('discount_det'), detailvalue2('nominal')" value="" >
		</td>
        
        <td align="center">
			<input type="text" id="discount3_det" name="discount3_det" style="text-align: right; font-size: 12px; width: 90px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('discount3_det'), detailvalue2('persen')" value="" >
		</td>
        
		<td align="center" id="amount_det">
			<input type="text" id="amount" name="amount" readonly="" style="text-align: right; font-size: 12px; width: 100px" class="form-control" onkeyup="formatangka('amount')" value="" >
		</td>
		
		<td align="center">
			<input type="text" id="note" name="note" style="text-align: left; font-size: 12px; width: 100px" class="form-control" value="" >
		</td>
		<td>
			&nbsp;<input type="submit" id="submit_det" name="submit" class="btn btn-metis-2 btn-sm" value="Save Detail">
		</td>
	</tr>
	
	<!--<tr>
		<td colspan="7">&nbsp;</td>
	</tr>-->
</table>