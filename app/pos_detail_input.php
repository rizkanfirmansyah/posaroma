<table border="0" width="100%" style="background-color: #010596; color: #ffffff; border-color: #dff709">

	<tr>
		<!--<td>
			<select id="item_code" name="item_code" class="chosen-select form-control" style="width: auto; font-size: 11px" onkeypress="return focusNext2('submit_det',event)" onchange="loadHTMLPost3('app/pos_detail_ajax.php','item_ajax','getdata2','item_code','location_id')" >
				<option value=""></option>
				<?php
				select_item("")
				?>	

			</select>
		</td>-->

		<!--<td colspan="1">
            &nbsp;&nbsp;
            <a href="javascript:void(0);" name="Find" title="Find" onClick=window.open("app/pos_item_lup.php","Find","width=900,height=500,left=200,top=20,toolbar=0,status=0,scroll=1,scrollbars=no");><img src="assets/img/plus.png" /></a>
            
        </td>-->
	</tr>

	<?php
	/*$sql_get=$select->list_pos_get_detail($xndf);
		$jmldata_get = $sql_get->rowCount();*/

	$sql_get = $select->get_pos_get_detail_last_item($xndf);
	$data_last = $sql_get->fetch(PDO::FETCH_OBJ);

	?>

	<!--<tr style="background-color: #010596; color: #ffffff; font-weight: bold; font-size:18px; border: 1px solid #ccc;">
		<td align="center">Kode Barang</td>
		<td align="center">Nama Barang</td>-->
	<!--<td align="center">Unit</td>-->
	<!--<td align="center">Jumlah</td>
		<td align="center">Harga</td>-->
	<!--<td>Discount</td>
        <td>Discount (%)</td>-->
	<!--<td align="center">Total</td>-->
	<!--<td></td>
	</tr>-->
	<tr style="background-color: #010596; color: #ffffff" id="item_ajax">

		<td align="left" colspan="1" width="20%" id="test">

			<input type="hidden" id="item_code" name="item_code" style="font-size: 11px; width: 100px" class="form-control" value="<?php echo $item_code ?>">

			<input type="hidden" id="discount_det" name="discount_det" style="text-align: right; font-size: 11px; width: 90px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('discount_det'), detailvalue2('nominal')" value="">

			<input type="hidden" id="discount3_det" name="discount3_det" style="text-align: right; font-size: 11px; width: 90px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('discount3_det'), detailvalue2('persen')" value="">

			<input type="text" id="item_code2" name="item_code2" style="font-size: 18px; min-width: 100px" class="form-control" onkeyup="update_qty('0', '<?php echo $xndf ?>')" onkeypress="saatEnter(this, event, '<?php echo $xndf ?>')" autocomplete="off" autofocus="" value="">


			<!--<input type="text" id="tuas" onkeypress="saatEnter(this, event)" />
            <div id="hasil" ></div>-->

			<!--<input type="text" id="item_code2" name="item_code2" style="font-size: 18px; min-width: 100px" class="form-control" onkeyup="update_qty('<?php echo $jmldata_get - 1 ?>', '<?php echo $xndf ?>')" autofocus="" value="" >-->
			<!--onchange="loadHTMLPost3('app/pos_detail_ajax.php','item_ajax','getdata','item_code2','location_id')" -->
			<!--
			<input type="text" id="item_code2" name="item_code2" style="font-size: 11px; width: 100px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onchange="loadHTMLPost2('app/pos_detail_ajax.php','item_ajax','getdata','item_code2')" value="" > -->
		</td>




		<td align="left">
			<input type="hidden" id="item_name" name="item_name" readonly="" style="font-size: 18px; min-width: 677px" class="form-control" value="<?php echo $item_name ?>">
			&nbsp;<input type="submit" id="submit_det" name="submit" style="width: 0px; height: 33px; background-color: #010596; color: #010596" value="Save Detail">
		</td>

		<input type="hidden" id="uom_code" name="uom_code" value="<?php echo $uom_code ?>">
		<input type="hidden" id="qty" name="qty" value="">
		<input type="hidden" id="unit_price" name="unit_price" value="">
		<input type="hidden" id="amount" name="amount" value="">

		<?php /*
		<td>
			<select id="uom_code" name="uom_code" class="form-control" style="height: 35px; min-width: 70px; font-size: 11px">
				<option value=""></option>
				<?php 
					select_uom($uom_code) 
				?>
			</select>	
		</td>
		
		<td align="center">
			<input type="text" id="qty" name="qty" style="text-align: right; font-size: 18px; max-width: 100px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('qty'), detailvalue2()" value="" >
		</td>
		<td align="center">
			<input type="text" id="unit_price" name="unit_price" style="text-align: right; font-size: 18px; width: 100px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('unit_price'), detailvalue2()" value="" >
		</td>*/ ?>

		<?php /*
		<td align="center">
			<input type="text" id="discount_det" name="discount_det" style="text-align: right; font-size: 11px; width: 90px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('discount_det'), detailvalue2('nominal')" value="" >
		</td>
        
        <td align="center">
			<input type="text" id="discount3_det" name="discount3_det" style="text-align: right; font-size: 11px; width: 90px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('discount3_det'), detailvalue2('persen')" value="" >
		</td>
		
        
		<td align="center" id="amount_det">
			<input type="text" id="amount" name="amount" readonly="" style="text-align: right; font-size: 18px; width: 120px" class="form-control" onkeyup="formatangka('amount')" value="" >
		</td>*/ ?>

		<!--<td align="right">
			&nbsp;<input type="submit" id="submit_det" name="submit" class="btn btn-metis-2 btn-sm" style="height: 34px" value="Save Detail">
		</td>-->
	</tr>

	<tr>
		<td colspan="7">&nbsp;</td>
	</tr>
	<tr style="font-size: 22px; font-weight: bold;">
		<td colspan="5">&nbsp;<?php echo $data_last->item_name ?></td>
		<td colspan="1">&nbsp;</td>
		<td colspan="1">&nbsp;<?php echo number_format($data_last->unit_price, 0, '.', ',') ?></td>
	</tr>
</table>