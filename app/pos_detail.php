<?php
$sql = $select->list_pos_detail($ref);
$jmldata = $sql->rowCount();

//set resolution
$font_size = "14px";
$width_item = "auto";
$width_item_name = "400px";
$font_bottom = "16px";

if ($_SESSION['lebarlayar'] == "1024") {
	$font_size = "14px";
	$width_item = "70px";
	$width_item_name = "280px";
	$font_bottom = "16px";
}
//----------/\-----------

?>

<table width="100%" class="table table-bordered table-condensed " style="font-size: <?php echo $font_size ?>; background-color: #010596; color: #ffffff;">
	<thead>
		<tr style="color: #010596; font-weight: bold; border: 1px solid #ccc; background-color: #e6ffea">
			<th>No.</th>
			<th><?php if ($lng == 1) {
					echo 'Item Code';
				} else {
					echo 'Kode';
				} ?></th>
			<th><?php if ($lng == 1) {
					echo 'Item Name';
				} else {
					echo 'Nama Barang';
				} ?></th>
			<th>Satuan</th>
			<th><?php if ($lng == 1) {
					echo 'Qty';
				} else {
					echo 'Qty';
				} ?></th>
			<th><?php if ($lng == 1) {
					echo 'Unit Price';
				} else {
					echo 'Harga';
				} ?></th>
			<!--<th><?php if ($lng == 1) {
						echo 'Discount';
					} else {
						echo 'Potongan';
					} ?></th>-->
			<th><?php if ($lng == 1) {
					echo 'Discount (%)';
				} else {
					echo 'Disc. (%)';
				} ?></th>
			<th><?php if ($lng == 1) {
					echo 'Amount';
				} else {
					echo 'Total';
				} ?></th>
			<th>
				<?php if (allowlvl('frmpos_pos') == 1 || $_SESSION['adm'] == 1) { ?>
					<?php if ($row_pos_detail->note != 'void') { ?>
						<?php if ($lng == 1) {
							echo 'Void';
						} else {
							echo 'Void';
						} ?></th>
		<?php } ?>
	<?php } ?>
	<th style="color: #ff0000">
		<?php if (allowlvl('frmpos_pos') == 0) { ?>
			<?php if ($lng == 1) {
				echo 'Void';
			} else {
				echo 'Void';
			} ?>
		<?php } ?>
	</th>
		</tr>
	</thead>
	<tbody>
		<?php

		$totalx = 0;
		$total2 = 0;
		$total_qty = 0;
		$no = 0;
		while ($row_pos_detail = $sql->fetch(PDO::FETCH_OBJ)) {

			$decimal = $selectview->item_decimal($row_pos_detail->item_code);
			$qty = number_format($row_pos_detail->qty, $decimal, '.', ',');
			$end_date_discount = $row_pos_detail->end_date_discount;
			$deposit_det = number_format($row_pos_detail->discount_percent_tmp, 0, '.', ',');
			$non_discount = number_format($row_pos_detail->non_discount, 0, '.', ',');
			$unit_price = number_format($row_pos_detail->unit_price, 0, '.', ',');
			$discount_det = number_format($row_pos_detail->discount, 0, '.', ',');
			$discount2_det = number_format($row_pos_detail->discount2, 0, '.', ',');
			$discount3_det = number_format($row_pos_detail->discount3, 0, '.', ',');
			$amount = number_format($row_pos_detail->amount, 0, '.', ',');
			$qty_discount = number_format($row_pos_detail->qty_discount, 0, '.', ',');
			$dummy = $row_pos_detail->dummy;

			$color_font = 'color: #000000;';
			$request_void = "";
			if ($row_pos_detail->request_void == 1) {
				$request_void = "checked";
				$color_font = 'color: #ff0000;';
			}

			$totalx = $totalx + $row_pos_detail->amount;
			$total2 = number_format($totalx, 0, '.', ',');

			$total_qty = $total_qty + $row_pos_detail->qty;


		?>
			<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $jmldata; ?>">

			<input type="hidden" id="old_item_code_<?php echo $no ?>" name="old_item_code_<?php echo $no ?>" value="<?php echo $row_pos_detail->item_code; ?>">
			<input type="hidden" id="old_uom_code_<?php echo $no ?>" name="old_uom_code_<?php echo $no ?>" value="<?php echo $row_pos_detail->uom_code; ?>">
			<input type="hidden" id="old_line_<?php echo $no ?>" name="old_line_<?php echo $no ?>" value="<?php echo $row_pos_detail->line; ?>">

			<input type="hidden" id="item_code_<?php echo $no ?>" name="item_code_<?php echo $no ?>" value="<?php echo $row_pos_detail->item_code; ?>">

			<input type="hidden" id="old_qty_<?php echo $no; ?>" name="old_qty_<?php echo $no; ?>" style="text-align: right; width: 70px" class="form-control" value="<?php echo $qty ?>">

			<input type="hidden" id="discount_<?php echo $no; ?>" name="discount_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('discount_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'nominal')" value="<?php echo $discount_det ?>">

			<?php /*
			<input type="hidden" id="discount3_<?php echo $no; ?>" name="discount3_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('discount3_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'persen')" value="<?php echo $discount3_det ?>" >*/ ?>
			<input type="hidden" id="discount2_<?php echo $no; ?>" name="discount2_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('discount2_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $discount2_det ?>" />

			<input type="hidden" id="non_discount_<?php echo $no ?>" name="non_discount_<?php echo $no ?>" value="<?php echo $non_discount ?>">
			<input type="hidden" id="qty_discount_<?php echo $no; ?>" name="qty_discount_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('qty_discount_<?php echo $no; ?>')" value="<?php echo $qty_discount ?>" />
			<input type="hidden" id="end_date_discount_<?php echo $no; ?>" name="end_date_discount_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" value="<?php echo $end_date_discount ?>" />
			<input type="hidden" id="deposit_<?php echo $no; ?>" name="deposit_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('deposit_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $deposit_det ?>" />
			<input type="hidden" id="ref_near_expired_<?php echo $no ?>" name="ref_near_expired_<?php echo $no ?>" value="<?php echo $row_pos_detail->ref_near_expired; ?>">

			<tr style="background-color:ffffff;" id="item_ajax2_<?php echo $no; ?>">
				<td align="center" style="font-size: <?php echo $font_size ?>; color: #ffffff; font-weight: bold">
					<?php echo $no + 1; ?>.

				</td>
				<td align="center" style="width: 70px; font-size: <?php echo $font_size ?>; color: #ffffff; font-weight: bold; height: 25px">
					<input type="hidden" id="item_code2_<?php echo $no ?>" name="item_code2_<?php echo $no ?>" class="form-control" readonly="" style="width: 100px; font-size: <?php echo $font_size ?>; <?php echo $color_font ?>; font-weight: bold;" value="<?php echo $row_pos_detail->old_code; ?>">
					<?php echo $row_pos_detail->old_code; ?>
				</td>
				<td style="background-color: #010596; width: 350px; font-size: <?php echo $font_size ?>; color: #ffffff; font-weight: bold; height: 25px">
					<input type="hidden" id="item_name_<?php echo $no ?>" name="item_name_<?php echo $no ?>" class="form-control" readonly="" style="min-width: <?php echo $width_item_name ?>; font-size: <?php echo $font_size ?>; <?php echo $color_font ?>; font-weight: bold;" value="<?php echo $row_pos_detail->item_name; ?>">
					<?php echo $row_pos_detail->item_name; ?>
				</td>
				<td style="width: 50px; font-size: <?php echo $font_size ?>; color: #ffffff; font-weight: bold; height: 25px">
					<input type="hidden" id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" class="form-control" readonly="" style="width: 50px; font-size: <?php echo $font_size ?>; <?php echo $color_font ?>; font-weight: bold;" value="<?php echo $row_pos_detail->uom_code; ?>">
					<?php echo $row_pos_detail->uom_code; ?>
				</td>
				<td align="center" style="background-color: #010596; width: 70px; font-size: <?php echo $font_size ?>; color: #ffffff; font-weight: bold; height: 25px">
					<input type="hidden" id="qty_<?php echo $no; ?>" name="qty_<?php echo $no; ?>" style="background-color: #010596; width: 70px; text-align: right; font-size:<?php echo $font_size ?>; color: #ffffff; font-weight: bold; height: 25px; border-color: #010596" class="form-control" onkeyup="formatangka('qty_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'nominal')" readonly="" autocomplete="off" value="<?php echo $qty ?>">
					<?php echo $qty ?>
				</td>
				<td align="right" style="width: 100px; text-align: right; font-size:<?php echo $font_size ?>; color: #ffffff; font-weight: bold; height: 25px">
					<input type="hidden" id="unit_price_<?php echo $no; ?>" name="unit_price_<?php echo $no; ?>" style="text-align: right; font-size:<?php echo $font_size ?>; <?php echo $color_font ?>; font-weight: bold;" class="form-control" onkeyup="formatangka('unit_price_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $unit_price ?>">
					<?php echo $unit_price ?>
				</td>
				<?php /*
				<td align="center" id="discount_det_id<?php echo $no; ?>">
					<input type="text" id="discount_<?php echo $no; ?>" name="discount_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('discount_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'nominal')" value="<?php echo $discount_det ?>" >
				</td>*/ ?>
				<td align="center" id="discount3_det_id<?php echo $no; ?>" style="width: 70px; text-align: right; font-size:<?php echo $font_size ?>; color: #ffffff; font-weight: bold; height: 25px">
					<input type="hidden" id="discount3_<?php echo $no; ?>" name="discount3_<?php echo $no; ?>" style="text-align: right; font-size:<?php echo $font_size ?>; <?php echo $color_font ?>; font-weight: bold;" class="form-control" onkeyup="formatangka('discount3_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'persen')" readonly="" value="<?php echo $discount3_det ?>">
					<?php echo $discount3_det ?>
				</td>

				<td align="center" id="amount<?php echo $no; ?>" style="width: 130px; text-align: right; font-size:<?php echo $font_size ?>; color: #ffffff; font-weight: bold; height: 25px">
					<input type="hidden" id="amount_<?php echo $no; ?>" name="amount_<?php echo $no; ?>" style="text-align: right; font-size:<?php echo $font_size ?>; <?php echo $color_font ?>; font-weight: bold;" class="form-control" onkeyup="formatangka('amount_<?php echo $no; ?>')" readonly value="<?php echo $amount ?>">
					<?php echo $amount ?>
				</td>
				<td align="center">
					<?php if (allowlvl('frmpos_pos') == 1 || $_SESSION['adm'] == 1) { ?>
						<?php if ($row_pos_detail->note != 'void') { ?>
							<input type="checkbox" id="delete_<?php echo $no; ?>" name="delete_<?php echo $no; ?>" class="ace" value="1"><span class="lbl"></span>
						<?php } ?>
					<?php } ?>
				</td>
				<td align="center">
					<?php if (allowlvl('frmpos_pos') == 0) { ?>
						<input type="checkbox" id="request_void_<?php echo $no; ?>" name="request_void_<?php echo $no; ?>" class="ace" value="1" <?php echo $request_void ?>><span class="lbl"></span>
					<?php } ?>
				</td>
			</tr>
		<?php

			$no++;
		}

		?>

		<tr style="background-color: #010596; color: #ffffff">
			<td colspan="4" align="right" style="color: #ffffff; font-weight: bold;">Total Item</td>
			<td align="center" style="color: #ffffff; font-weight: bold;"><?php echo number_format($total_qty, 0, '.', ',') ?>&nbsp;</td>
			<td colspan="2" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Discount&nbsp;</td>
			<td align="right">
				<input type="text" id="discount" name="discount" style="width: 130px; height: 25px; text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('discount'), sub_total('<?php echo $jmldata ?>')" readonly="" value="<?php echo $discount2 ?>">
			</td>
		</tr>
		<tr style="background-color: #010596; color: #ffffff">
			<!--<td style="color: #ff0000">
					<?php if (allowlvl('frmpos_pos') == 1 || $_SESSION['adm'] == 1) { ?>
						Batal : 
						<input type="checkbox" name="void" id="void" class="ace" value="1" <?php echo $void ?> /><span class="lbl"></span>
					<?php } ?>
				</td>
				<td colspan="2" style="color: #ff0000">
					<?php if (allowlvl('frmpos_pos') == 1 || $_SESSION['adm'] == 1) { ?>
						Catatan Batal : 
						<input type="text" name="memo" id="memo" class="form-control" autocomplete="off" value="<?php echo $row_pos->memo ?>" />
					<?php } ?>
				</td>-->
			<td colspan="5" style="border-right: 1px solid #ffffff; border-bottom: 1px solid #010596">&nbsp;</td>
			<td colspan="2" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Total&nbsp;</td>
			<td align="right" id="total_id">
				<input type="text" id="total" name="total" readonly="" style="width: 130px; height: 25px; text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('total')" value="<?php echo $total ?>">
			</td>

		</tr>

		<tr style="background-color: #010596; color: #ffffff;">
			<!--<td colspan="5" align="right" style="font-size: 28px; font-weight: bold;"><?php if ($lng == 1) {
																								echo 'DP (Down Payment)';
																							} else {
																								echo 'Uang Muka';
																							} ?>&nbsp;</td>
				<td align="right">-->
			<input type="hidden" id="deposit" name="deposit" style="text-align: right; font-size: 28px; font-weight: bold;" class="form-control" onkeyup="formatangka('deposit')" value="<?php echo $deposit ?>">
			<!--</td>-->
			<td colspan="5" style="border-right: 1px solid #ffffff; border-bottom: 1px solid #010596">&nbsp;</td>
			<td colspan="2" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Cash&nbsp;</td>
			<td align="right">
				<input type="text" id="cash_amount" name="cash_amount" style="width: 130px; height: 25px; text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('cash_amount'), sub_total('<?php echo $jmldata ?>')" value="<?php echo $cash_amount ?>">
			</td>
		</tr>

		<tr style="background-color: #010596; color: #ffffff">
			<td colspan="5" style="border-right: 1px solid #ffffff; border-bottom: 1px solid #010596"></td>
			<td colspan="2" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Debit&nbsp;</td>
			<td align="right">
				<input type="text" id="bank_amount" name="bank_amount1" autocomplete="off" style="width: 130px; height: 25px; text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('bank_amount')" oninput="sub_total('<?php echo $jmldata ?>')" onKeyPress="return focusNext('submit',event)" value="<?php echo $bank_amount ?>">
			</td>
		</tr>

		<tr style="background-color: #010596; color: #ffffff">
			<td colspan="5" style="border-right: 1px solid #ffffff; border-bottom: 1px solid #010596">&nbsp;</td>
			<td colspan="2" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">OVO&nbsp;</td>
			<td align="right">
				<input type="text" id="ovo" name="ovo" style="width: 130px; height: 25px; text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('ovo'), sub_total('<?php echo $jmldata ?>')" value="<?php echo $ovo ?>">
			</td>
		</tr>

		<tr style="background-color: #010596; color: #ffffff">
			<td colspan="5" style="border-right: 1px solid #ffffff; border-bottom: 1px solid #010596"></td>
			<td colspan="2" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Gopay&nbsp;</td>
			<td align="right">
				<input type="text" id="gopay" name="gopay" autocomplete="off" style="width: 130px; height: 25px; text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('gopay')" oninput="sub_total('<?php echo $jmldata ?>')" onKeyPress="return focusNext('submit',event)" value="<?php echo $gopay ?>">
			</td>
		</tr>

		<tr style="background-color: #010596; color: #ffffff">
			<td colspan="5" style="border-right: 1px solid #ffffff; border-bottom: 1px solid #010596">&nbsp;</td>
			<td colspan="2" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Voucher&nbsp;</td>
			<td align="right">
				<input type="text" id="cash_voucher" name="cash_voucher" style="width: 130px; height: 25px; text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('cash_voucher'), sub_total('<?php echo $jmldata ?>')" value="<?php echo $cash_voucher ?>">
			</td>
		</tr>

		<?php include("pos_bank.php"); ?>

		<tr style="background-color: #010596; color: #ffffff">
			<td colspan="5" style="border-right: 1px solid #ffffff; border-bottom: 1px solid #010596">&nbsp;</td>
			<td colspan="2" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Kembalian&nbsp;</td>
			<td align="right" id="change_amount_id">
				<input type="text" id="change_amount" name="change_amount" readonly="" style="width: 130px; height: 25px; text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('change_amount')" value="<?php echo number_format($row_pos->change_amount, 0, ".", ",") ?>">
			</td>
		</tr>

	</tbody>
</table>