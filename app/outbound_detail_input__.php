<!--<div class="form-group">
	<div class="col-sm-9">
		<span class="input-icon">
			<input type="text" id="form-field-icon-1" />
		
			<input type="text" id="form-field-icon-2" />
		
			<input type="text" id="form-field-icon-1" />
		</span>
		
		<span class="input-icon">
			<input type="text" id="form-field-icon-1" />
		</span>
	</div>
</div>-->
							
							

<table width="30%" border="0">
    <?php /*
    <tr>
        <td>
			<select id="item_code" name="item_code" class="chosen-select form-control" style="width: auto; font-size: 11px" onKeyPress="return focusNext('item_code2',event)" onchange="loadHTMLPost3('app/outbound_detail_ajax.php','item_ajax','getdata2','item_code','warehouse_id_from')" >
				<option value=""></option>
				<?php 
					select_item("")
				?>	

			</select>	
		</td>
		
		<td>
            <a href="javascript:void(0);" name="Find" title="Find" onClick=window.open("app/outbound_item_lup.php","Find","width=900,height=500,left=200,top=20,toolbar=0,status=0,scroll=1,scrollbars=no");><img src="assets/img/plus.png" /></a>
            
        </td>
    </tr>*/ ?>
</table>

<table border="0">
    
	<tr style="color: #168124; font-weight: bold; border: 1px solid #ccc; background-color: #e6ffea">
		<td>Kode</td>
		<td>Nama Barang</td>
		<td>Satuan</td>
		<td>Jumlah</td>
		<td></td>
	</tr>
	<tr style="background-color:ffffff;" id="item_ajax"> 
        
        <input type="hidden" id="item_code" name="item_code" style="font-size: 11px; width: 60px" class="form-control" value="<?php echo $item_code ?>" />            
        		
		<td align="left" colspan="1">
            
            <input type="text" id="item_code2" name="item_code2" style="font-size: 11px; width: 150px" class="form-control" onKeyPress="return focusNext('qty',event)" onchange="loadHTMLPost3('app/outbound_detail_ajax.php','item_ajax','getdata','item_code2','warehouse_id_from')" autofocus="" value="" />
            
            <!--
			<input type="text" id="item_code2" name="item_code2" style="font-size: 11px; width: 100px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onchange="loadHTMLPost2('app/outbound_detail_ajax.php','item_ajax','getdata','item_code2')" value="" > -->
		</td>
		
		<td align="left">
			<input type="text" id="item_name" name="item_name" readonly="" style="font-size: 11px; width: auto; min-width: 300px" class="form-control" value="<?php echo $item_name ?>" >
		</td>

		<td>
			<select id="uom_code" name="uom_code" class="form-control" style="height: 35px; min-width: 70px; font-size: 11px">
				<option value=""></option>
				<?php 
					select_uom($uom_code) 
				?>
			</select>	
		</td>
		
		<td align="center">
			<input type="text" id="qty" name="qty" style="text-align: right; font-size: 11px; width: 60px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('qty'), detailvalue2()" autocomplete="off" value="" >
		</td>
		
		<td>
			&nbsp;<input type="submit" id="submit_det" name="submit" class="btn btn-metis-2 btn-sm" style="height: 34px" value="Save Detail">
		</td>
	</tr>
	
	
	
	<tr>
		<td colspan="11">&nbsp;</td>
	</tr>
</table>