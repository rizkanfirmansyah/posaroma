<?php
		$sql=$select->list_cashier_get_detail($xndf);
		$jmldata 	= $sql->rowCount();
 ?>
 
 <table class="table table-bordered table-condensed table-hover table-striped">
	<thead>
		<tr> 
			<th><?php if($lng==1) { echo 'Item Name'; } else { echo 'Nama Barang'; } ?></th>
			<th><?php if($lng==1) { echo 'Item Name-2'; } else { echo 'Nama Barang-2'; } ?></th> 
			<th>Unit</th> 									 
			<th><?php if($lng==1) { echo 'Qty'; } else { echo 'Jml Barang'; } ?></th>	
			<th><?php if($lng==1) { echo 'Unit Price'; } else { echo 'Harga Satuan'; } ?></th>
			<th><?php if($lng==1) { echo 'Discount'; } else { echo 'Potongan'; } ?></th>
            <th><?php if($lng==1) { echo 'Discount (%)'; } else { echo 'Potongan (%)'; } ?></th>
			<th><?php if($lng==1) { echo 'Amount'; } else { echo 'Total'; } ?></th>
			<th><?php if($lng==1) { echo 'Note'; } else { echo 'Note'; } ?></th>
			<th><?php if($lng==1) { echo 'Delete'; } else { echo 'Hapus'; } ?></th>
		</tr>
	</thead>
	<tbody>
		<?php 
		
			$total = 0;
			$total2 = 0;
			$no = 0;
			$totalcek = 0;
			
			while($row_cashier_detail=$sql->fetch(PDO::FETCH_OBJ)) { 
			
				$qty = number_format($row_cashier_detail->qty, 0, '.', ',');
				$unit_price = number_format($row_cashier_detail->unit_price, 0, '.', ',');
				$discount_det = number_format($row_cashier_detail->discount, 0, '.', ',');
                $discount3_det = number_format($row_cashier_detail->discount3, 0, '.', ',');
				$amount = number_format($row_cashier_detail->amount, 0, '.', ',');
				$non_discount = $row_cashier_detail->non_discount;
				
				$total = $total + $row_cashier_detail->amount;
				$total2 = number_format($total, 0, '.', ',');
				
				//member only
				if($non_discount == 0) {
					$totalcek = $totalcek + $row_cashier_detail->amount;
				}
				
				$note = $row_cashier_detail->note;
				
		?>								
				<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $jmldata; ?>" >
				
				<input type="hidden" id="old_item_code_<?php echo $no ?>" name="old_item_code_<?php echo $no ?>" value="<?php echo $row_cashier_detail->item_code; ?>" >
				<input type="hidden" id="old_uom_code_<?php echo $no ?>" name="old_uom_code_<?php echo $no ?>" value="<?php echo $row_cashier_detail->uom_code; ?>" >
				<input type="hidden" id="old_line_<?php echo $no ?>" name="old_line_<?php echo $no ?>" value="<?php echo $row_cashier_detail->line; ?>" >
			
				<input type="hidden" id="item_code_<?php echo $no ?>" name="item_code_<?php echo $no ?>" value="<?php echo $row_cashier_detail->item_code; ?>" >	
				
				<input type="hidden" id="old_qty_<?php echo $no; ?>" name="old_qty_<?php echo $no; ?>" style="text-align: right; width: 70px" class="form-control" value="<?php echo $qty ?>" >
				
				<input type="hidden" id="non_discount_<?php echo $no ?>" name="non_discount_<?php echo $no ?>" value="<?php echo $non_discount ?>" >
				
				
				<tr style="background-color:ffffff;" id="item_ajax2_<?php echo $no; ?>" > 
					
					<td>				
						<input type="text" id="item_name_<?php echo $no ?>" name="item_name_<?php echo $no ?>" class="form-control" readonly="" style="width: auto" value="<?php echo $row_cashier_detail->item_name; ?>" >			
						
					</td>
					<td>				
						<input type="text" id="item_name2_<?php echo $no ?>" name="item_name2_<?php echo $no ?>" class="form-control" style="width: auto" value="<?php echo $row_cashier_detail->item_name2; ?>" >			
						
					</td>
					<td>
						<input type="text" id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" class="form-control" readonly="" style="width: 50px" value="<?php echo $row_cashier_detail->uom_code; ?>" >		
					</td>
					<td align="center">
						<input type="text" id="qty_<?php echo $no; ?>" name="qty_<?php echo $no; ?>" style="text-align: right; font-size:12px " class="form-control" onkeyup="formatangka('qty_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $qty ?>" >
					</td>
					<td align="center">
						<input type="text" id="unit_price_<?php echo $no; ?>" name="unit_price_<?php echo $no; ?>" style="text-align: right; font-size:12px" class="form-control" onkeyup="formatangka('unit_price_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $unit_price ?>" >
					</td>
					<td align="center">
						<input type="text" id="discount_<?php echo $no; ?>" name="discount_<?php echo $no; ?>" style="text-align: right; font-size:12px" class="form-control" onkeyup="formatangka('discount_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $discount_det ?>" >
					</td>
                    <td align="center">
						<input type="text" id="discount3_<?php echo $no; ?>" name="discount3_<?php echo $no; ?>" style="text-align: right; font-size:12px" class="form-control" onkeyup="formatangka('discount3_<?php echo $no; ?>'), detailvalue('<?php echo $no ?>', '<?php echo $jmldata ?>')" value="<?php echo $discount3_det ?>" >
					</td>
					<td align="center" id="amount<?php echo $no; ?>">
						<input type="text" id="amount_<?php echo $no; ?>" name="amount_<?php echo $no; ?>" style="text-align: right; font-size:12px" class="form-control" onkeyup="formatangka('amount_<?php echo $no; ?>')" readonly value="<?php echo $amount ?>" >
					</td>
					<td align="center">
						<input type="text" id="note_<?php echo $no; ?>" name="note_<?php echo $no; ?>" style="text-align: left; font-size:12px" class="form-control" value="<?php echo $note ?>" >
					</td>
					<td align="center">
						<!--<input type="checkbox" id="delete_<?php echo $no; ?>" name="delete_<?php echo $no; ?>" class="form-control" value="1" >-->
						<a href="JavaScript:hapus('<?php echo $row_cashier_detail->ref ?>','<?php echo $row_cashier_detail->line ?>')"><img src="assets/img/delete.png" ></a>
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
			
			?>  
			
			<tr>
				<td colspan="5" align="right" style="font-size: 14px; font-weight: bold;">Discount&nbsp;</td>
				<td align="right">
					<input type="text" id="discount" name="discount" style="text-align: right; font-size: 14px; font-weight: bold;" autocomplete="off" class="form-control" onkeyup="formatangka('discount'), sub_total('<?php echo $jmldata ?>')" value="<?php echo number_format($discount2,0,".",",") ?>" >
				</td>
				<td colspan="1" align="right" style="font-size: 14px; font-weight: bold;">Total&nbsp;</td>
				<td align="right" id="total_id">
					<input type="text" id="total" name="total" readonly="" style="text-align: right; font-size: 14px; font-weight: bold;" class="form-control" onkeyup="formatangka('total')" value="<?php echo $total2 ?>" >
				</td>
				<td colspan="5">
					&nbsp;
				</td>
			</tr>
			
			<tr>
				<td colspan="5" align="right" style="font-size: 14px; font-weight: bold;"><?php if($lng==1) { echo 'DP (Down Payment)'; } else { echo 'Uang Muka'; } ?>&nbsp;</td>
				<td align="right">
					<input type="text" id="deposit" name="deposit" style="text-align: right; font-size: 14px; font-weight: bold;" class="form-control" autocomplete="off" onkeyup="formatangka('deposit'), sub_total('<?php echo $jmldata ?>')" value="<?php echo $deposit ?>" >
				</td>
				<td align="right" style="font-size: 14px; font-weight: bold;">Cash&nbsp;</td>
				<td align="right">
					<input type="text" id="cash_amount" name="cash_amount" style="text-align: right; font-size: 14px; font-weight: bold;" autocomplete="off" class="form-control" onkeyup="formatangka('cash_amount'), sub_total('<?php echo $jmldata ?>')" value="<?php echo $cash_amount ?>" >
				</td>
			</tr>
			
			<tr>
				<td colspan="6">&nbsp;</td>
				<td align="right" style="font-size: 14px; font-weight: bold;">OVO&nbsp;</td>
				<td align="right">
					<input type="text" id="ovo" name="ovo" style="text-align: right; font-size: 14px; color: #000000; font-weight: bold;" class="form-control" onkeyup="formatangka('ovo'), sub_total('<?php echo $jmldata ?>')" autocomplete="off" value="<?php echo $ovo ?>" >
				</td>
			</tr>
			
			<tr>
				<td colspan="6"></td>
				<td align="right" style="font-size: 14px; font-weight: bold;">Gopay&nbsp;</td>
				<td align="right">
					<input type="text" id="gopay" name="gopay" autocomplete="off" style="text-align: right; font-size: 14px; color: #000000; font-weight: bold;" class="form-control" onkeyup="formatangka('gopay')" oninput="sub_total('<?php echo $jmldata ?>')" onKeyPress="return focusNext('submit',event)" autocomplete="off" value="<?php echo $gopay ?>" >
				</td>
			</tr>
			
			<tr>
				<td colspan="6">&nbsp;</td>
				<td align="right" style="font-size: 14px; font-weight: bold;">Voucher&nbsp;</td>
				<td align="right">
					<input type="text" id="cash_voucher" name="cash_voucher" style="text-align: right; font-size: 14px; color: #000000; font-weight: bold;" class="form-control" autocomplete="off" onkeyup="formatangka('cash_voucher'), sub_total('<?php echo $jmldata ?>')" value="<?php echo $cash_voucher ?>" >
				</td>
			</tr>
			
			<?php include("cashier_bank.php"); ?>
			
			<tr>
				<td colspan="7" align="right" style="font-size: 14px; font-weight: bold;">Kembalian&nbsp;</td>
				<td align="right" id="change_amount_id">
					<input type="text" id="change_amount" name="change_amount" readonly="" style="text-align: right; font-size: 14px; font-weight: bold;" class="form-control" onkeyup="formatangka('change_amount')" value="<?php echo number_format($change_amount,0,".",",") ?>" >
				</td>
			</tr>
										
	</tbody>
</table>