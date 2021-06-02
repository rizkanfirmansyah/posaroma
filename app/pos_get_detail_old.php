<?php
		$sql=$select->list_pos_get_detail($xndf);
		$jmldata 	= $sql->rowCount();
		
		//set resolution
		$font_size = "18px";
		$width_item = "auto";
		$width_item_name = "400px";
		$font_bottom = "22px";
		
		if($_SESSION['lebarlayar'] == "1024") {
			$font_size = "14px";
			$width_item = "70px";
			$width_item_name = "280px";
			$font_bottom = "22px";
		}
		//----------/\-----------
		
		
 ?>
 
 <table class="table table-bordered table-condensed table-hover table-striped" style="width: auto; font-size: <?php echo $font_size ?>">
	<thead>
		<tr> 
			<th>No.</th>
			<th><?php if($lng==1) { echo 'Item Code'; } else { echo 'Kode Barang'; } ?></th>
			<th><?php if($lng==1) { echo 'Item Name'; } else { echo 'Nama Barang'; } ?></th> 
			<th>Unit</th> 									 
			<th><?php if($lng==1) { echo 'Qty'; } else { echo 'Jml Barang'; } ?></th>	
			<th><?php if($lng==1) { echo 'Unit Price'; } else { echo 'Harga Satuan'; } ?></th>
			<!--<th><?php if($lng==1) { echo 'Discount'; } else { echo 'Potongan'; } ?></th>-->
            <th><?php if($lng==1) { echo 'Discount (%)'; } else { echo 'Potongan (%)'; } ?></th>
			<th><?php if($lng==1) { echo 'Amount'; } else { echo 'Total'; } ?></th>
			<th><?php if($lng==1) { echo 'Update'; } else { echo 'Update'; } ?></th>
			<th><?php if($lng==1) { echo 'Delete'; } else { echo 'Hapus'; } ?></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		
			$total = 0;
			$total2 = 0;
			$total_qty = 0;
			$no = 0;
			$totalcek = 0;
			
			while($row_pos_detail=$sql->fetch(PDO::FETCH_OBJ)) { 
			
				$decimal = $selectview->item_decimal($row_pos_detail->item_code);
				$qty = number_format($row_pos_detail->qty, $decimal, '.', ',');
				
				$unit_price = number_format($row_pos_detail->unit_price, 0, '.', ',');
				$discount_det = number_format($row_pos_detail->discount, 0, '.', ',');
				$discount2_det = number_format($row_pos_detail->discount2, 0, '.', ',');
                $discount3_det = number_format($row_pos_detail->discount3, 0, '.', ',');
				$amount = number_format($row_pos_detail->amount, 0, '.', ',');
				$non_discount = $row_pos_detail->non_discount;
				$qty_discount = number_format($row_pos_detail->qty_discount, 0, '.', ',');
				$end_date_discount = $row_pos_detail->end_date_discount;
				$deposit_det = number_format($row_pos_detail->deposit, 0, '.', ',');
				
				$total_qty = $total_qty + $row_pos_detail->qty;
				$total = $total + $row_pos_detail->amount;
				$total2 = number_format($total, 0, '.', ',');
				
				//member only
				/*if($non_discount == 0) {
					$totalcek = $totalcek + $row_pos_detail->amount;
				}*/
				
		?>								
				<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $jmldata; ?>" >
				
				<input type="hidden" id="old_item_code_<?php echo $no ?>" name="old_item_code_<?php echo $no ?>" value="<?php echo $row_pos_detail->item_code; ?>" >
				<input type="hidden" id="old_uom_code_<?php echo $no ?>" name="old_uom_code_<?php echo $no ?>" value="<?php echo $row_pos_detail->uom_code; ?>" >
				<input type="hidden" id="old_line_<?php echo $no ?>" name="old_line_<?php echo $no ?>" value="<?php echo $row_pos_detail->line; ?>" >
				<input type="hidden" id="item_code_<?php echo $no ?>" name="item_code_<?php echo $no ?>" value="<?php echo $row_pos_detail->item_code; ?>" >
				<input type="hidden" id="old_qty_<?php echo $no; ?>" name="old_qty_<?php echo $no; ?>" style="text-align: right; width: 70px" class="form-control" value="<?php echo $qty ?>" >
				<input type="hidden" id="non_discount_<?php echo $no ?>" name="non_discount_<?php echo $no ?>" value="<?php echo $non_discount ?>" >
				<input type="hidden" id="discount_<?php echo $no; ?>" name="discount_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('discount_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $discount_det ?>" />
				<?php /*<input type="hidden" id="discount3_<?php echo $no; ?>" name="discount3_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('discount3_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $discount3_det ?>" />*/?>
				<input type="hidden" id="discount2_<?php echo $no; ?>" name="discount2_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('discount2_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $discount2_det ?>" />
				<input type="hidden" id="qty_discount_<?php echo $no; ?>" name="qty_discount_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('qty_discount_<?php echo $no; ?>')" value="<?php echo $qty_discount ?>" />
				<input type="hidden" id="end_date_discount_<?php echo $no; ?>" name="end_date_discount_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" value="<?php echo $end_date_discount ?>" />
				<input type="hidden" id="deposit_<?php echo $no; ?>" name="deposit_<?php echo $no; ?>" style="text-align: right; font-size:11px" class="form-control" onkeyup="formatangka('deposit_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $deposit_det ?>" />
				<input type="hidden" id="ref_near_expired_<?php echo $no ?>" name="ref_near_expired_<?php echo $no ?>" value="<?php echo $row_pos_detail->ref_near_expired; ?>" >
				
				
				<tr style="background-color:ffffff;" id="item_ajax2_<?php echo $no; ?>" > 
					<td align="center" style="font-size: <?php echo $font_size ?>; color: #000000; font-weight: bold">				
						<?php echo $no + 1; ?>.			
						
					</td>
					<td>				
						<input type="text" id="item_code2_<?php echo $no ?>" name="item_code2_<?php echo $no ?>" class="form-control" readonly="" style="width: <?php echo $width_item ?>; font-size: <?php echo $font_size ?>; color: #000000; font-weight: bold;" value="<?php echo $row_pos_detail->old_code; ?>" >			
						
					</td>
					<td>				
						<input type="text" id="item_name_<?php echo $no ?>" name="item_name_<?php echo $no ?>" class="form-control" readonly="" style="min-width: <?php echo $width_item_name ?>; font-size: <?php echo $font_size ?>; color: #000000; font-weight: bold;" value="<?php echo $row_pos_detail->item_name; ?>" >			
						
					</td>
					<td>
						<input type="text" id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" class="form-control" readonly="" style="width: 50px; font-size: <?php echo $font_size ?>; color: #000000; font-weight: bold;" value="<?php echo $row_pos_detail->uom_code; ?>" >		
					</td>
					<td align="center" id="qty_id<?php echo $no; ?>">
						<input type="text" id="qty_<?php echo $no; ?>" name="qty_<?php echo $no; ?>" style="text-align: right; font-size:<?php echo $font_size ?>; color: #000000; font-weight: bold;" class="form-control" onkeyup="formatangka('qty_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>', 'nominal')" autocomplete="off" value="<?php echo $qty ?>" >
					</td>
					<td align="center">
						<input type="text" id="unit_price_<?php echo $no; ?>" name="unit_price_<?php echo $no; ?>" style="text-align: right; font-size:<?php echo $font_size ?>; color: #000000; font-weight: bold;" class="form-control" onkeyup="formatangka('unit_price_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" readonly="" value="<?php echo $unit_price ?>" >
					</td>
					
					<?php /*
					<td align="center">
						<input type="text" id="discount_<?php echo $no; ?>" name="discount_<?php echo $no; ?>" style="text-align: right; font-size:<?php echo $font_size ?>; color: #000000; font-weight: bold;" class="form-control" onkeyup="formatangka('discount_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $discount_det ?>" >
					</td>*/ ?>
                    <td align="center" id="discount3_det_id<?php echo $no; ?>">
						<input type="text" id="discount3_<?php echo $no; ?>" name="discount3_<?php echo $no; ?>" style="text-align: right; font-size:<?php echo $font_size ?>; color: #000000; font-weight: bold;" class="form-control" onkeyup="formatangka('discount3_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>','persen')" readonly="" value="<?php echo $discount3_det ?>" >
					</td>
					
					<td align="center" id="amount<?php echo $no; ?>">
						<input type="text" id="amount_<?php echo $no; ?>" name="amount_<?php echo $no; ?>" style="text-align: right; font-size:<?php echo $font_size ?>; color: #000000; font-weight: bold;" class="form-control" onkeyup="formatangka('amount_<?php echo $no; ?>')" readonly value="<?php echo $amount ?>" >
					</td>
					
					<td align="center">
						<!--<input type="checkbox" id="delete_<?php echo $no; ?>" name="delete_<?php echo $no; ?>" class="form-control" value="1" >-->
						<a href="JavaScript:update('<?php echo $xndf ?>', '<?php echo $no ?>')"><img src="assets/img/check.png" ></a>
					</td>
					
					<td align="center">
						<!--<input type="checkbox" id="delete_<?php echo $no; ?>" name="delete_<?php echo $no; ?>" class="form-control" value="1" >-->
						<a href="JavaScript:hapus('<?php echo $row_pos_detail->ref ?>','<?php echo $row_pos_detail->line ?>')"><img src="assets/img/delete.png" ></a>
					</td>
					
				</tr>
			<?php 
										
				$no++; 
			} 
			
			
            /*
			##get discount member
			$k = 0;
	      	$querydisc = $select->get_client_discount_member($client_code);
	      	$rowsdisc = mysql_num_rows($querydisc);
	      	
	      	if($rowsdisc > 0) {
	      		
	      		while($datadisc = mysql_fetch_object($querydisc)) {

					$amount_member 	= $datadisc->amount_member;
					$discmember		= $datadisc->discount;
					$memberlimit	= $datadisc->amount_limit;
					
					if(	$memberlimit <= $totalcek ) {
						$discmember2 = $discmember;
					}
					
			?>
			
					<input type="hidden" id="discmember<?php echo $k ?>" name="discmember<?php echo $k ?>" value="0">
			  		<input type="hidden" id="memberlimit<?php echo $k ?>" name="memberlimit<?php echo $k ?>" value="0">
			  		<input type="hidden" id="discmember<?php echo $k ?>" name="discmember<?php echo $k ?>" value="<?php echo $datadisc->discount ?>">
			  		<input type="hidden" id="memberlimit<?php echo $k ?>" name="memberlimit<?php echo $k ?>" value="<?php echo $datadisc->amount_limit ?>">
			  		
			<?php		
		  			$k++;
				}
			?>
			
				<input type="hidden" id="amount_member" name="amount_member" value="<?php echo $amount_member ?>">
				<input type="hidden" id="jumlahmember" name="jumlahmember" value="<?php echo $k-1 ?>">
						      		
			<?php
					
			} 
			*/
			
			$memberlimit = ($totalcek * $discmember2)/100;
			$discount2 = $memberlimit;
		
			$total2 = $total - $memberlimit;
			$total2 = number_format($total2,0,".",",");
			##------------------/\----------------------
			
			$change_amount = numberreplace($cash_amount) - numberreplace($total2);
			##========================================/\
			
			//get discount total per unit
			$date_day = date("Y-m-d");
			//echo $location_id.'>>'. $date_day .'>>'. numberreplace($total2);
			$sqltotdisc = $select->get_outlet_set_price($location_id, $date_day, numberreplace($total2));
			$datatotdisc = $sqltotdisc->fetch(PDO::FETCH_OBJ);
			$discount_total = $datatotdisc->discount_total;
			$discount2 = $discount_total;
			$total2 = numberreplace($total2) - $discount2;
			$total2 = number_format($total2,0,".",",");
			?>  
			
			<tr>
				<!--<input type="hidden" id="discount" name="discount" style="text-align: right; font-size: 14px; font-weight: bold;" class="form-control" onkeyup="formatangka('discount'), sub_total('<?php echo $jmldata ?>')" value="<?php echo number_format($discount2,0,".",",") ?>" >-->
				<td colspan="4" align="right" style="color: #000000; font-weight: bold;">Total Qty</td>
				<td align="right" style="color: #000000; font-weight: bold;"><?php echo number_format($total_qty,0,'.',',') ?></td>
				<td colspan="2" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Discount&nbsp;</td>
				<td align="right">
					<input type="text" id="discount" name="discount" style="text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('discount'), sub_total('<?php echo $jmldata ?>')" autocomplete="off" readonly="" value="<?php echo number_format($discount2,0,".",",") ?>" >
				</td>
			</tr>
			
			<tr>
				<td colspan="6">&nbsp;</td>
				<td colspan="1" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Total&nbsp;</td>
				<td align="right" id="total_id">
					<input type="text" id="total" name="total" readonly="" style="text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('total')" value="<?php echo $total2 ?>" >
				</td>
				
			</tr>
			
			<tr>
				<!--<td colspan="4" align="right" style="font-size: 14px; font-weight: bold;"><?php if($lng==1) { echo 'DP (Down Payment)'; } else { echo 'Uang Muka'; } ?>&nbsp;</td>-->
				<!--<td align="right">-->
					<input type="hidden" id="deposit" name="deposit" style="text-align: right; font-size: 14px; font-weight: bold;" class="form-control" onkeyup="formatangka('deposit')" value="<?php echo $deposit ?>" >
				<!--</td>-->
				<td colspan="6"></td>
				<td align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Cash&nbsp;</td>
				<td align="right">
					<input type="text" id="cash_amount" name="cash_amount" autocomplete="off" style="text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('cash_amount')" oninput="sub_total('<?php echo $jmldata ?>')" onKeyPress="return focusNext('cash_voucher',event)" value="<?php echo $cash_amount ?>" >
				</td>
			</tr>
			
			<tr>
				<td colspan="6"></td>
				<td align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Debit&nbsp;</td>
				<td align="right">
					<input type="text" id="bank_amount" name="bank_amount" autocomplete="off" style="text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('bank_amount')" oninput="sub_total('<?php echo $jmldata ?>')" onKeyPress="return focusNext('submit',event)" value="<?php echo $bank_amount ?>" >
				</td>
			</tr>
			
			<tr>
				<td colspan="6"></td>
				<td align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">OVO&nbsp;</td>
				<td align="right">
					<input type="text" id="ovo" name="ovo" autocomplete="off" style="text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('ovo')" oninput="sub_total('<?php echo $jmldata ?>')" onKeyPress="return focusNext('submit',event)" value="<?php echo $ovo ?>" >
				</td>
			</tr>
			
			<tr>
				<td colspan="6"></td>
				<td align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Gopay&nbsp;</td>
				<td align="right">
					<input type="text" id="gopay" name="gopay" autocomplete="off" style="text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('gopay')" oninput="sub_total('<?php echo $jmldata ?>')" onKeyPress="return focusNext('submit',event)" value="<?php echo $gopay ?>" >
				</td>
			</tr>
			
			<tr>
				<td colspan="6"></td>
				<td align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Voucher&nbsp;</td>
				<td align="right">
					<input type="text" id="cash_voucher" name="cash_voucher" autocomplete="off" style="text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('cash_voucher')" oninput="sub_total('<?php echo $jmldata ?>')" onKeyPress="return focusNext('submit',event)" value="<?php echo $cash_voucher ?>" >
				</td>
			</tr>
			
			<?php include("pos_bank.php"); ?>
			
			<tr>
				<td colspan="7" align="right" style="font-size: <?php echo $font_bottom ?>; font-weight: bold;">Kembalian&nbsp;</td>
				<td align="right" id="change_amount_id">
					<input type="hidden" id="change_amount" name="change_amount" readonly="" style="text-align: right; font-size: <?php echo $font_bottom ?>; font-weight: bold; color: #000000;" class="form-control" onkeyup="formatangka('change_amount')" value="<?php echo number_format($change_amount,0,".",",") ?>" >
				</td>
			</tr>
			
										
	</tbody>
</table>