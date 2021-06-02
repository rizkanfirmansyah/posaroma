<?php
	include ("../../app/include/sambung.php");
	$dbpdo = DB::create();

	/*set location code*/
	$location_id = $_GET['whs']; // $_SESSION["location_id2"];
	$qwhs = "select code from warehouse where id='$location_id'";
	$sql=$dbpdo->prepare($qwhs);
	$sql->execute();
			
	$datawhs = $sql->fetch(PDO::FETCH_OBJ);
	$whscode = $datawhs->code;
	/*-------------/\---*/
	
	$j=0;	
	$itemdata = "";
	$values2 = "";
	
	if($whscode == "") {
		$sql2 = "select a.date, a.efective_from, a.item_code, a.uom_code, a.current_price, a.current_price1, a.current_price2, a.current_price3, a.tax_rate, a.price_tax, a.price_member_tax, a.margin_warehouse, a.margin_mlm, a.registration_rate, a.registration_rate_platinum, a.last_price, a.date_of_record, a.location_id, a.non_discount, a.qty1, a.qty2, a.qty3, a.qty4, a.end_date_discount, a.discount, a.discount_percent, a.end_date_discount_total, a.amount_minimum, a.discount_total, a.uid, a.dlu, a.adt_status, a.status_download, a.sysid from adt_set_item_price a order by a.sysid";
	} else {
		$sql2 = "select a.date, a.efective_from, a.item_code, a.uom_code, a.current_price, a.current_price1, a.current_price2, a.current_price3, a.tax_rate, a.price_tax, a.price_member_tax, a.margin_warehouse, a.margin_mlm, a.registration_rate, a.registration_rate_platinum, a.last_price, a.date_of_record, a.location_id, a.non_discount, a.qty1, a.qty2, a.qty3, a.qty4, a.end_date_discount, a.discount, a.discount_percent, a.end_date_discount_total, a.amount_minimum, a.discount_total, a.uid, a.dlu, a.adt_status, a.status_download, a.sysid from adt_set_item_price a where ifnull(status_download,'') not like '%$whscode%' order by a.sysid";
		

	}
	
	$sql2=$dbpdo->prepare($sql2);
	$sql2->execute();
	while ($data = $sql2->fetch(PDO::FETCH_OBJ)) { 
		$j++;
		
		$adt_status = $data->adt_status;
		
		$itemdata = $data->item_code;
		$uom_code = $data->uom_code;
		$date_of_record = $data->efective_from; //date_of_record;
		$current_price = $data->current_price;
		$location_id__ = $data->location_id;
		
		$non_discount	=	$data->non_discount;
		$qty1			=	$data->qty1;
		$qty2			=	$data->qty2;
		$qty3			=	$data->qty3;
		$qty4			=	$data->qty4;
		$end_date_discount	=	$data->end_date_discount;
		$discount		=	$data->discount;
		$discount_percent	=	$data->discount_percent;
		$end_date_discount_total	=	$data->end_date_discount_total;
		$amount_minimum	=	$data->amount_minimum;
		$discount_total	=	$data->discount_total;
		
		if ($j == 1) {
			
			if($adt_status == "insert") {
				$values2 = $itemdata. "|" . $uom_code . "|" . $date_of_record . "|" . $adt_status . "|" . $current_price . "|" . $location_id__ . "|" . $non_discount . "|" . $qty1 . "|" . "$qty2" . "|" . $qty3 . "|" . $qty4 . "|" . $end_date_discount . "|" . $discount . "|" . $discount_percent . "|" . $end_date_discount_total . "|" . $amount_minimum . "|" . $discount_total . "|" . "insert into set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, tax_rate, price_tax, price_member_tax, margin_warehouse, margin_mlm, registration_rate, registration_rate_platinum, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, end_date_discount, discount, discount_percent, end_date_discount_total, amount_minimum, discount_total, uid, dlu) values('$data->date', '$data->efective_from', '$data->item_code', '$data->uom_code', '$data->current_price', '$data->current_price1', '$data->current_price2', '$data->current_price3', '$data->tax_rate', '$data->price_tax', '$data->price_member_tax', '$data->margin_warehouse', '$data->margin_mlm', '$data->registration_rate', '$data->registration_rate_platinum', '$data->last_price', '$data->date_of_record', '$data->location_id', '$data->non_discount', '$data->qty1', '$data->qty2', '$data->qty3', '$data->qty4', '$data->end_date_discount', '$data->discount', '$data->discount_percent', '$data->end_date_discount_total', '$data->amount_minimum', '$data->discount_total', '$data->uid', '$data->dlu')";
				
			}
			
			if($adt_status == "update") {
				$values2 = $itemdata. "|" . $uom_code . "|" . $date_of_record . "|" . $adt_status . "|" . $current_price . "|" . $location_id__ . "|" . $non_discount . "|" . $qty1 . "|" . "$qty2" . "|" . $qty3 . "|" . $qty4 . "|" . $end_date_discount . "|" . $discount . "|" . $discount_percent . "|" . $end_date_discount_total . "|" . $amount_minimum . "|" . $discount_total . "|" . "update set_item_cost set efective_from='$data->efective_from_cost', uom_code='$data->uom_code', current_cost='$data->current_cost', last_cost='$data->last_cost', date_of_record='$data->date_of_record', location_id='$data->location_id_cost', uid='$data->uid', dlu='$data->dlu' where item_code='$data->item_code' and uom_code='$data->uom_code'";
			}
			
			if($adt_status == "delete") {
				$values2 = $itemdata. "|" . $uom_code . "|" . $date_of_record . "|" . $adt_status . "|" . $current_price . "|" . $location_id__ . "|" . $non_discount . "|" . $qty1 . "|" . "$qty2" . "|" . $qty3 . "|" . $qty4 . "|" . $end_date_discount . "|" . $discount . "|" . $discount_percent . "|" . $end_date_discount_total . "|" . $amount_minimum . "|" . $discount_total . "|" . "delete from set_item_price where item_code='$data->item_code' and uom_code='$data->uom_code' and date_of_record='$data->date_of_record'";
			}
			
		} else {
			$itemdata = $data->item_code;
			
			if($adt_status == "insert") {
				$values2 = $values2."~\n". $itemdata. "|" . $uom_code . "|" . $date_of_record . "|" . $adt_status . "|" . $current_price . "|" . $location_id__ . "|" . $non_discount . "|" . $qty1 . "|" . "$qty2" . "|" . $qty3 . "|" . $qty4 . "|" . $end_date_discount . "|" . $discount . "|" . $discount_percent . "|" . $end_date_discount_total . "|" . $amount_minimum . "|" . $discount_total . "|" . "insert into set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, tax_rate, price_tax, price_member_tax, margin_warehouse, margin_mlm, registration_rate, registration_rate_platinum, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, end_date_discount, discount, discount_percent, end_date_discount_total, amount_minimum, discount_total, uid, dlu) values('$data->date', '$data->efective_from', '$data->item_code', '$data->uom_code', '$data->current_price', '$data->current_price1', '$data->current_price2', '$data->current_price3', '$data->tax_rate', '$data->price_tax', '$data->price_member_tax', '$data->margin_warehouse', '$data->margin_mlm', '$data->registration_rate', '$data->registration_rate_platinum', '$data->last_price', '$data->date_of_record', '$data->location_id', '$data->non_discount', '$data->qty1', '$data->qty2', '$data->qty3', '$data->qty4', '$data->end_date_discount', '$data->discount', '$data->discount_percent', '$data->end_date_discount_total', '$data->amount_minimum', '$data->discount_total', '$data->uid', '$data->dlu')";
			}
			
			if($adt_status == "update") {
				$values2 = $values2."~\n". $itemdata. "|" . $uom_code . "|" . $date_of_record . "|" . $adt_status . "|" . $current_price . "|" . $location_id__ . "|" . $non_discount . "|" . $qty1 . "|" . "$qty2" . "|" . $qty3 . "|" . $qty4 . "|" . $end_date_discount . "|" . $discount . "|" . $discount_percent . "|" . $end_date_discount_total . "|" . $amount_minimum . "|" . $discount_total . "|" . "update set_item_cost set efective_from='$data->efective_from_cost', uom_code='$data->uom_code', current_cost='$data->current_cost', last_cost='$data->last_cost', date_of_record='$data->date_of_record', location_id='$data->location_id_cost', uid='$data->uid', dlu='$data->dlu' where item_code='$data->item_code' and uom_code='$data->uom_code'";
			}
			
			if($adt_status == "delete") {
				$values2 = $values2."~\n". $itemdata. "|" . $uom_code . "|" . $date_of_record . "|" . $adt_status . "|" . $current_price . "|" . $location_id__ . "|" . $non_discount . "|" . $qty1 . "|" . "$qty2" . "|" . $qty3 . "|" . $qty4 . "|" . $end_date_discount . "|" . $discount . "|" . $discount_percent . "|" . $end_date_discount_total . "|" . $amount_minimum . "|" . $discount_total . "|" . "delete from set_item_price where item_code='$data->item_code' and uom_code='$data->uom_code' and date_of_record='$data->date_of_record'";
			}
			
		}		
		
		/*update adt_item (tanda sudah didownload)*/
		/*$qupdate = "update adt_set_item_price set status_download=concat(ifnull(status_download,'')," . "'^" . $whscode . "') where item_code ='$itemdata' and sysid='$data->sysid' ";
		$sql=$dbpdo->prepare($qupdate);
		$sql->execute();*/
		/*-----------------------/\---------------*/
					
	}
	
	$datacreate = "data_set_item_price_".$location_id;
	$kirim=fopen("data_upload/" . $datacreate . ".txt","w");
	fputs($kirim, "$values2");
	fclose($kirim);
	
	
?>