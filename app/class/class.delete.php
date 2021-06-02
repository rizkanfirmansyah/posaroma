<?php

class delete{
	
	//----hapus user
	function delete_usr($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("select usrid from usr where id=$ref");
		$data=$sql->fetch(PDO::FETCH_OBJ);;
		
		$sql=$dbpdo->query("delete from usr_dtl where usrid='$data->usrid' ");
		
		$sql=$dbpdo->query("delete from usr where id='$ref' ");
	
		//----delete user backup
		$sql=$dbpdo->query("delete from usr_bup where usrid='$data->usrid' ");
		
		return $sql;
	}
	
	//---hapus company
	function delete_company($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from company where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus position
	function delete_position($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from position where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus department
	function delete_department($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from department where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus division
	function delete_division($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from division where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus employee
	function delete_employee($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from employee where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus coa
	function delete_coa($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from coa where syscode='$ref' ");
	
		return $sql;
	}
	
	//---hapus item type
	function delete_item_type($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from item_type where syscode='$ref' ");
		
		$sql=$dbpdo->query("delete from item_type_detail where syscode_header='$ref' ");
	
		return $sql;
	}
	
	//---hapus uom
	function delete_uom($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from uom where code='$ref' ");
	
		return $sql;
	}
	
	//---hapus item group
	function delete_item_group($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from item_group where id='$ref' ");
		
		$sql=$dbpdo->query("delete from item_group_detail where id_header='$ref' ");
		
		return $sql;
	}
	
	//---hapus item subgroup
	function delete_item_subgroup($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from item_subgroup where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus reason to adjust
	function delete_reason_adjust($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from reason_adjust where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus warehouse
	function delete_warehouse($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from warehouse where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus uom conversion
	function delete_uom_conversion($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from uom_conversion where syscode='$ref' ");
	
		return $sql;
	}	
	
	//---hapus colour
	function delete_colour($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from colour where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus brand
	function delete_brand($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from brand where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus size
	function delete_size($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from size where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus item category
	function delete_item_category($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from item_category where id='$ref' ");
	
		return $sql;
	}
	
	//---hapus item
	function delete_item($ref){
		$dbpdo = DB::create();
		
		/*---------insert audit trail item (delete)------------*/
		$select=new select;
		$sqldel=$select->list_item($ref);
		$data = $sqldel->fetch(PDO::FETCH_OBJ);
		
		$uid			=	$_SESSION["loginname"];
		$dlu			=	date("Y-m-d H:i:s");
		$sqlstr="insert into adt_item (code, old_code, name, item_group_id, item_subgroup_id, item_type_code, item_category_id, brand_id, size_id, uom_code_stock, uom_code_sales, uom_code_purchase, minimum_stock, maximum_stock, photo, consigned, active, uid, dlu, syscode, adt_status) values ('$data->code', '$data->old_code', '$data->name', '$data->item_group_id', '$data->item_subgroup_id', '$data->item_type_code', '$data->item_category_id', '$data->brand_id', '$data->size_id', '$data->uom_code_stock', '$data->uom_code_sales', '$data->uom_code_purchase', '$data->minimum_stock', '$data->maximum_stock', '$data->photo', '$data->consigned', '$data->active', '$uid', '$dlu', '$data->syscode', 'delete' )";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		/*---------insert audit trail set item price (delete)------------*/
		$select=new select;
		$sqldel=$select->list_set_item_price_last("", $ref);
		$data = $sqldel->fetch(PDO::FETCH_OBJ);
		
		$uid			=	$_SESSION["loginname"];
		$dlu			=	date("Y-m-d H:i:s");
		$sqlstr = "insert into adt_set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu, adt_status) values('$data->date', '$data->efective_from', '$data->item_code', '$data->uom_code', '$data->current_price', '$data->current_price1', '$data->current_price2', '$data->current_price3', '$data->last_price', '$data->date_of_record', '$data->location_id', '$data->non_discount', '$data->qty1', '$data->qty2', '$data->qty3', '$data->qty4', '$data->uid', '$data->dlu', 'delete')";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		$sql=$dbpdo->query("delete from set_item_price where item_code='$ref' ");
		
		$sql=$dbpdo->query("delete from item where syscode='$ref' ");
	
		return $sql;
	}
	
	//---hapus item conversion
	function delete_item_conversion($ref){
		
		$dbpdo = DB::create();
		
		$sqlstr="delete from item_conversion where item_code='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from item_conversion_detail where item_code='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus item packing
	function delete_item_packing($ref){
		
		$dbpdo = DB::create();
		
		$sqlstr="delete from item_packing where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from item_packing_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='packing' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus inbound
	function delete_inbound($ref){
		
		$dbpdo = DB::create();
		
		$sqlstr="delete from inbound where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from inbound_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='inbound' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus outbound
	function delete_outbound($ref){
		
		$dbpdo = DB::create();
		
		$sqlstr="delete from outbound where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from outbound_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='outbound' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus store request
	function delete_store_request($ref){
		
		$dbpdo = DB::create();
		
		$sqlstr="delete from store_request where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from store_request_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus stock opname
	function delete_stock_opname($ref){
		
		$dbpdo = DB::create();
		
		$sqlstr="delete from bincard where invoice_no='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sqlstr="delete from stock_opname where syscode='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from stock_opname_detail where syscode='$ref' ";
		$sql=$dbpdo->query($sql2);
			
		return $sql;
	}
	
	//---hapus vendor type
	function delete_vendor_type($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from vendor_type where id='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sqlstr="delete from vendor_type_detail where id_header='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus vendor
	function delete_vendor($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from vendor where syscode='$ref' ";
		$sql=$dbpdo->query($sqlstr);
			
		return $sql;
	}
	
	
	//---hapus tax
	function delete_tax($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from tax where syscode='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus inv adjust
	function delete_invent_adjust($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from invent_adjust where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from invent_adjust_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus item issued
	function delete_item_issued($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from item_issued where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from item_issued_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus item return
	function delete_item_return($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from item_return where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from item_return_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus purchase request
	function delete_purchase_request($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from purchase_request where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from purchase_request_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus purchase order
	function delete_purchase_order($ref){
		
		$dbpdo = DB::create();
		
		##--------update qty purchase request	
		$sql_po="select pr_ref, item_code, uom_code, ifnull(qty,0) qty from purchase_order_detail where ref='$ref'";
		$result=$dbpdo->query($sql_po);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$pr_ref = $data->pr_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$qty = $data->qty;
			
			$sql2="update purchase_request_detail set qty_po=ifnull(qty_po,0) - $qty where ref='$pr_ref' and item_code='$item_code' and uom_code='$uom_code' ";	
			$sql=$dbpdo->query($sql2);	
			
			/*update status sales order : O=Ordered Part
										  C=Ordered Complete
										  V=Received Part
										  F=Received Complete
			*/
			$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_po,0)) qty_po from purchase_request_detail group by ref having ref='$pr_ref'";
			$result2 = $dbpdo->query($sql2);
			$data2 = $result2->fetch(PDO::FETCH_OBJ);
			$qty_po = $data2->qty_po;
			$qty = $data2->qty;
			
			if($qty > 0) {
				if($qty_po < $qty ) {
					$sql2="update purchase_request set status='O' where ref='$pr_ref' ";
					$sql=$dbpdo->query($sql2);	
				}
				
				if($qty_po >= $qty ) {
					$sql2="update purchase_request set status='C' where ref='$pr_ref' ";
					$sql=$dbpdo->query($sql2);	
				}
				
				if($qty_po == 0 ) {
					$sql2="update purchase_request set status='R' where ref='$pr_ref' ";
					$sql=$dbpdo->query($sql2);	
				}
			}
		}					
		
		##*****************************************##
		
		
		$sqlstr="delete from purchase_order where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from purchase_order_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus good receipt
	function delete_good_receipt($ref){
		
		$dbpdo = DB::create();
		
		##--------update qty purchase order	
		$sql_gr="select po_ref, item_code, uom_code, ifnull(qty,0) qty from good_receipt_detail where ref='$ref'";
		$result=$dbpdo->query($sql_gr);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$po_ref = $data->po_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$qty = $data->qty;
			
			$sql2="update purchase_order_detail set qty_gr=ifnull(qty_gr,0) - $qty where ref='$po_ref' and item_code='$item_code' and uom_code='$uom_code' ";	
			$sql=$dbpdo->query($sql2);	
			
			/*update status sales order : V=Received Part
										  F=Received Complete
			*/
			$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_gr,0)) qty_gr from purchase_order_detail group by ref having ref='$po_ref'";
			$result2 = $dbpdo->query($sql2);
			$data2 = $result2->fetch(PDO::FETCH_OBJ);
			$qty_gr = $data2->qty_gr;
			$qty = $data2->qty;
			
			if($qty > 0) {
				if($qty_gr < $qty ) {
					$sql2="update purchase_order set status='V' where ref='$po_ref' ";
					$sql=$dbpdo->query($sql2);	
				}
				
				if($qty_gr >= $qty ) {
					$sql2="update purchase_order set status='F' where ref='$po_ref' ";
					$sql=$dbpdo->query($sql2);	
				}
				
				if($qty_gr == 0 ) {
					$sql2="update purchase_order set status='R' where ref='$po_ref' ";
					$sql=$dbpdo->query($sql2);	
				}
			}
		}	
		##*****************************************##
		
		
		$sqlstr="delete from good_receipt where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from good_receipt_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='good_receipt' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from jrn where ivino='$ref' and ivitpe='good_receipt' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus purchase invoice
	function delete_purchase_invoice($ref){
		
		$dbpdo = DB::create();
		
		
		
		##--------update qty purchase order	
		$qty_pi = 0;
		
		$sql_pi="select po_ref, item_code, uom_code, ifnull(qty,0) qty, line_item_po from purchase_invoice_detail where ref='$ref'";
		$result=$dbpdo->query($sql_pi);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$po_ref = $data->po_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$qty = $data->qty;
			$line_item_po = $data->line_item_po;
			
			$sql2="update purchase_order_detail set qty_pi=ifnull(qty_pi,0) - $qty where ref='$po_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_po' ";	
			$sql=$dbpdo->query($sql2);	
			
			/*update status sales order : I=Invoice Part
										  U=Invoice Full
			*/
			$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_pi,0)) qty_pi from purchase_order_detail group by ref having ref='$po_ref'";
			$result2 = $dbpdo->query($sql2);
			$data2 = $result2->fetch(PDO::FETCH_OBJ);
			$qty_pi = $data2->qty_pi;
			$qty = $data2->qty;
			
			if($qty > 0) {
				if($qty_pi < $qty ) {
					$sql2="update purchase_order set status='I' where ref='$po_ref' ";
					$sql=$dbpdo->query($sql2);	
				}
				
				if($qty_pi >= $qty ) {
					$sql2="update purchase_order set status='U' where ref='$po_ref' ";
					$sql=$dbpdo->query($sql2);	
				}
				
				if($qty_pi == 0 ) {
					$sql2="update purchase_order set status='R' where ref='$po_ref' ";
					$sql=$dbpdo->query($sql2);	
				}
			}
		}					
		
		##------update PO (dr good receipt)
		if($qty_pi == 0) {
			$sql_gr="select po_ref, item_code, uom_code, ifnull(qty,0) qty from purchase_invoice_detail where ref='$ref'";
			$result=$dbpdo->query($sql_gr);
			while($data = $result->fetch(PDO::FETCH_OBJ)) {
				$po_ref = $data->po_ref;
				$item_code = $data->item_code;
				$uom_code = $data->uom_code;
				$qty = $data->qty;
				
				/*update status sales order : V=Received Part
											  F=Received Complete
				*/
				$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_gr,0)) qty_gr from purchase_order_detail group by ref having ref='$po_ref'";
				$result2 = $dbpdo->query($sql2);
				$data2 = $result2->fetch(PDO::FETCH_OBJ);
				$qty_gr = $data2->qty_gr;
				$qty = $data2->qty;
				
				if($qty > 0) {
					if($qty_gr < $qty ) {
						$sql2="update purchase_order set status='V' where ref='$po_ref' ";
						$sql=$dbpdo->query($sql2);	
					}
					
					if($qty_gr >= $qty ) {
						$sql2="update purchase_order set status='F' where ref='$po_ref' ";
						$sql=$dbpdo->query($sql2);	
					}
					
					if($qty_gr == 0 ) {
						$sql2="update purchase_order set status='R' where ref='$po_ref' ";
						$sql=$dbpdo->query($sql2);	
					}
				}
			}	
		}
		##*****************************************##
		
		
		$sqlstr="delete from purchase_invoice where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from purchase_invoice_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete AP
		$sqlstr="delete from ap where ref='$ref' and invoice_type='PIN'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_invoice' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus currency
	function delete_currency($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from currency where syscode='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	
	//---hapus currency rate type
	function delete_currency_rate_type($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from currency_rate_type where id='$ref' ";
		$sql=$dbpdo->query($sqlstr);
					
		return $sql;
	}
	
	//---hapus credit card type
	function delete_credit_card_type($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from credit_card_type where code='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	
	//---hapus cash master
	function delete_cash_master($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from cash_master where code='$ref' ";
		$sql=$dbpdo->query($sqlstr);
					
		return $sql;
	}
	
	
	//---hapus client type
	function delete_client_type($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from client_type where id='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sqlstr="delete from client_type_detail where id_header='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus client
	function delete_client($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from client where syscode='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus price type
	function delete_price_type($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from price_type where id='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus marketing
	function delete_marketing($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from marketing where code='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus quotation
	function delete_quotation($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from quotation where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from quotation_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus sales order
	function delete_sales_order($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from sales_order where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from sales_order_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	
	//---hapus delivery order
	function delete_delivery_order($ref){
		
		$dbpdo = DB::create();
		
		
		
		##--------update qty sales order	
		$sql_do="select so_ref, item_code, uom_code, line_item_so, ifnull(qty,0) qty from delivery_order_detail where ref='$ref'";
		$result=$dbpdo->query($sql_do);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$so_ref = $data->so_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$line_item_so = $data->line_item_so;
			$qty = $data->qty;
			
			$sql2="update sales_order_detail set qty_shp=ifnull(qty_shp,0) - $qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";	
			$sql=$dbpdo->query($sql2);	
		}					
		
		/*update status sales order : S=Shipped in Part (dikirim sebagian)
										  F=Shipped in Full (dikirm semua)
										  C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
		*/
		$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_shp,0)) qty_shp from sales_order_detail group by ref having ref='$so_ref'";
		$result = $dbpdo->query($sql2);
		$data = $result->fetch(PDO::FETCH_OBJ);
		$qty_shp = $data->qty_shp;
		$qty = $data->qty;
		
		if($qty_shp < $qty ) {
			$sql2="update sales_order set status='S' where ref='$so_ref' ";
			$sql=$dbpdo->query($sql2);	
		}
		
		if($qty_shp >= $qty ) {
			$sql2="update sales_order set status='F' where ref='$so_ref' ";
			$sql=$dbpdo->query($sql2);	
		}
		
		if($qty_shp <= 0 ) {
			$sql2="update sales_order set status='R' where ref='$so_ref' ";
			$sql=$dbpdo->query($sql2);	
		}
		##*****************************************##
		
		//-----------delete bin card
		$sqlstr=$dbpdo->query("delete from bincard where invoice_no='$ref'");
		$sql=$dbpdo->query($sqlstr);
						
		$sqlstr="delete from delivery_order where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from delivery_order_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='delivery_order' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus sales invoice
	function delete_sales_invoice($ref){
		
		$dbpdo = DB::create();
		
		
		
		##--------update qty delivery order	
		$sql_si="select do_ref, item_code, uom_code, line_item_do, ifnull(qty,0) qty from sales_invoice_detail where ref='$ref'";
		$result=$dbpdo->query($sql_si);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$do_ref = $data->do_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$line_item_do = $data->line_item_do;
			$qty = $data->qty;
			
			$sql2="update delivery_order_detail set qty_si=ifnull(qty_si,0) - $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
			$sql=$dbpdo->query($sql2);	
			
			/*update status delivery order : I=Invoice in Part (diinvoicekan sebagian)
									  	F=Invoice in Full (diinvoicekan semua)
									  	C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
			*/
			$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_si,0)) qty_si from delivery_order_detail group by ref having ref='$do_ref'";
			$result2 = $dbpdo->query($sql2);
			$data2 = $result2->fetch(PDO::FETCH_OBJ);
			$qty_si = $data2->qty_si;
			$qty = $data2->qty;
			
			if($qty_si < $qty ) {
				$sql2="update delivery_order set status='I' where ref='$do_ref' ";
				$sql=$dbpdo->query($sql2);	
			}
			
			if($qty_si >= $qty ) {
				$sql2="update delivery_order set status='F' where ref='$do_ref' ";
				$sql=$dbpdo->query($sql2);	
			}
			
			if($qty_si == 0 ) {
				$sql2="update delivery_order set status='R' where ref='$do_ref' ";
				$sql=$dbpdo->query($sql2);	
			}
			##*****************************************##
		}					
		
		
		$sqlstr="delete from sales_invoice where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from sales_invoice_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete AR
		$sqlstr="delete from ar where ref='$ref' and invoice_type='SOI'";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	
	//---hapus sales return
	function delete_sales_return($ref){
		
		$dbpdo = DB::create();
		
		
		
		##--------update qty sales invoice	
		$sql_si="select b.si_ref, a.item_code, a.uom_code, a.line_item_si, ifnull(a.qty,0) qty from sales_return_detail a left join sales_return b on a.ref=b.ref where a.ref='$ref'";
		$result=$dbpdo->query($sql_si);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$si_ref = $data->si_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$line_item_si = $data->line_item_si;
			$qty = $data->qty;
			
			$sql2="update sales_invoice_detail set qty_rtn=ifnull(qty_rtn,0) - $qty where ref='$si_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_si' ";	
			$sql=$dbpdo->query($sql2);	
			
			##*****************************************##
		}	
		
		
		$sqlstr="delete from sales_return where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from sales_return_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='sales_return' ";
		$sql=$dbpdo->query($sql2);
		
		//delete AR
		$sqlstr="delete from ar where ref='$ref' and invoice_type='SIR'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales_return' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus purchase return
	function delete_purchase_return($ref){
		
		$dbpdo = DB::create();
		
		
		
		##--------update qty purchase invoice	
		$qty_pi = 0;
		
		$sql_pi="select b.pi_ref, a.item_code, a.uom_code, ifnull(a.qty,0) qty, a.line_item_pi from purchase_return_detail a left join purchase_return b on a.ref=b.ref where a.ref='$ref'";
		$result=$dbpdo->query($sql_pi);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$pi_ref = $data->pi_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$qty = $data->qty;
			$line_item_pi = $data->line_item_pi;
			
			$sql2="update purchase_invoice_detail set qty_rtn=ifnull(qty_rtn,0) - $qty where ref='$pi_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_pi' ";	
			$sql=$dbpdo->query($sql2);	
			
		}			
		
		//delete AP
		$sqlstr="delete from ap where ref='$ref' and invoice_type='PIR'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_return' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sqlstr="delete from purchase_return where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from purchase_return_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus good return
	function delete_good_return($ref){
		
		$dbpdo = DB::create();
		
		
		
		##--------update qty purchase invoice	
		$qty_pi = 0;
		
		$sql_gr="select a.gr_ref, a.item_code, a.uom_code, ifnull(a.qty,0) qty, a.line_item_gr from good_return_detail a where a.ref='$ref'";
		$result=$dbpdo->query($sql_gr);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$gr_ref = $data->gr_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$qty = $data->qty;
			$line_item_gr = $data->line_item_gr;
			
			$sql2="update good_receipt_detail set qty_rtn=ifnull(qty_rtn,0) - $qty where ref='$gr_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_gr' ";	
			$sql=$dbpdo->query($sql2);	
			
		}
		
		$sqlstr="delete from good_return where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from good_return_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='good_return' ";
		$sql=$dbpdo->query($sql2);
					
		return $sql;
	}
		
	//---hapus delivery return
	function delete_delivery_return($ref){
		
		$dbpdo = DB::create();
		
		
		
		##--------update qty delivery order	
		$sql_si="select do_ref, item_code, uom_code, line_item_do, ifnull(qty,0) qty from delivery_return_detail where ref='$ref'";
		$result=$dbpdo->query($sql_si);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$do_ref = $data->do_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$line_item_do = $data->line_item_do;
			$qty = $data->qty;
			
			$sql2="update delivery_order_detail set qty_rtn=ifnull(qty_rtn,0) - $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
			$sql=$dbpdo->query($sql2);	
			
			##*****************************************##
		}	
		
		
		$sqlstr="delete from delivery_return where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from delivery_return_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='delivery_return' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus receipt
	function delete_receipt($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from receipt where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from receipt_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from ar where ref='$ref' and invoice_type='RCI' ";
		$sql=$dbpdo->query($sql2);
		
		//delete ARC
		$sqlstr="delete from arc where ref='$ref'";
		$sql=$dbpdo->query($sqlstr);	
		
		//delete journal
		$sql2="delete from jrn where ivino='$ref' and ivitpe='receipt' ";
		$sql=$dbpdo->query($sql2);
		
		//delete DPS
		$sqlstr="delete from dps where ref='$ref' and invoice_type='RCI' ";
		$sql=$dbpdo->query($sqlstr);	
		
		return $sql;
	}
	
	//---hapus payment
	function delete_payment($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from payment where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from payment_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from ap where ref='$ref' and invoice_type='PMT' ";
		$sql=$dbpdo->query($sql2);
		
		//delete APC
		$sqlstr="delete from apc where ref='$ref'";
		$sql=$dbpdo->query($sqlstr);	
		
		$sql2="delete from jrn where ivino='$ref' and ivitpe='payment' ";
		$sql=$dbpdo->query($sql2);
					
		return $sql;
	}
	
	//---hapus cash invoice
	function delete_cash_invoice($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='cash_invoice' ";
		$sql=$dbpdo->query($sql2);
		
		$sqlstr="delete from sales_invoice where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from sales_invoice_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete AR
		$sqlstr="delete from ar where ref='$ref' and invoice_type='CSH'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales' ";
		$sql=$dbpdo->query($sqlstr);
		
		//delete DPS
		$sqlstr="delete from dps where ref='$ref' and invoice_type='RCI' ";
		$sql=$dbpdo->query($sqlstr);
					
		return $sql;
	}
	
	
	//---hapus delivery order
	function delete_delivery_order_quick($ref){
		
		$dbpdo = DB::create();
		
		
		
		##--------update qty sales order	
		$sql_do="select so_ref, item_code, uom_code, line_item_so, ifnull(qty,0) qty from delivery_order_detail where ref='$ref'";
		$result=$dbpdo->query($sql_do);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$so_ref = $data->so_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$line_item_so = $data->line_item_so;
			$qty = $data->qty;
			
			$sql2="update sales_invoice_detail set qty_shp=ifnull(qty_shp,0) - $qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";	
			$sql=$dbpdo->query($sql2);	
		}					
		
		/*update status sales order : S=Shipped in Part (dikirim sebagian)
										  F=Shipped in Full (dikirm semua)
										  C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
		*/
		$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_shp,0)) qty_shp from sales_invoice_detail group by ref having ref='$so_ref'";
		$result = $dbpdo->query($sql2);
		$data = $result->fetch(PDO::FETCH_OBJ);
		$qty_shp = $data->qty_shp;
		$qty = $data->qty;
		
		if($qty_shp < $qty ) {
			$sql2="update sales_invoice set status='S' where ref='$so_ref' ";
			$sql=$dbpdo->query($sql2);	
		}
		
		if($qty_shp >= $qty ) {
			$sql2="update sales_invoice set status='E' where ref='$so_ref' ";
			$sql=$dbpdo->query($sql2);	
		}
		
		if($qty_shp <= 0 ) {
			$sql2="update sales_invoice set status='R' where ref='$so_ref' ";
			$sql=$dbpdo->query($sql2);	
		}
		##*****************************************##
		
		//-----------delete bin card
		$sqlstr=$dbpdo->query("delete from bincard where invoice_no='$ref'");
		$sql=$dbpdo->query($sqlstr);
						
		$sqlstr="delete from delivery_order where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from delivery_order_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='delivery_order' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	
	//---hapus direct payment
	function delete_direct_payment($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from direct_payment where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from direct_payment_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		/*$sql2="delete from ap where ref='$ref' and invoice_type='PMT' ";
		$sql=$dbpdo->query($sql2);
		*/
		
		//delete APC
		$sqlstr="delete from apc where ref='$ref'";
		$sql=$dbpdo->query($sqlstr);	
		
		//delete AP
		$sqlstr="delete from ap where ref='$ref' and invoice_type='DPM'";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus direct receipt
	function delete_direct_receipt($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from direct_receipt where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from direct_receipt_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from jrn where ivino='$ref' and ivitpe='direct_receipt' ";
		$sql=$dbpdo->query($sql2);
		
		//delete ARC
		$sqlstr="delete from arc where ref='$ref'";
		$sql=$dbpdo->query($sqlstr);	
		
		//delete AR
		$sqlstr="delete from ar where ref='$ref' and invoice_type='DRC'";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus delivery order project
	function delete_delivery_order_project($ref){
		
		$dbpdo = DB::create();
		
		
		
		/*update status sales order : S=Shipped in Part (dikirim sebagian)
										  F=Shipped in Full (dikirm semua)
										  C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
		*/
		$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_shp,0)) qty_shp from sales_invoice_detail group by ref having ref='$so_ref'";
		$result = $dbpdo->query($sql2);
		$data = $result->fetch(PDO::FETCH_OBJ);
		$qty_shp = $data->qty_shp;
		$qty = $data->qty;
		
		if($qty_shp < $qty ) {
			$sql2="update sales_invoice set status='S' where ref='$so_ref' ";
			$sql=$dbpdo->query($sql2);	
		}
		
		if($qty_shp >= $qty ) {
			$sql2="update sales_invoice set status='E' where ref='$so_ref' ";
			$sql=$dbpdo->query($sql2);	
		}
		
		if($qty_shp <= 0 ) {
			$sql2="update sales_invoice set status='R' where ref='$so_ref' ";
			$sql=$dbpdo->query($sql2);	
		}
		##*****************************************##
		
		//-----------delete bin card
		$sql=$dbpdo->query("delete from bincard where invoice_no='$ref'");
		$sql=$dbpdo->query($sqlstr);
						
		$sqlstr="delete from delivery_order where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from delivery_order_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='delivery_order' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	
	//---hapus sales invoice project
	function delete_sales_invoice_project($ref){
		
		$dbpdo = DB::create();
		
		
		
		##--------update qty delivery order	
		$sql_si="select do_ref, item_code, uom_code, line_item_do, ifnull(qty,0) qty from sales_invoice_detail where ref='$ref'";
		$result=$dbpdo->query($sql_si);
		while($data = $result->fetch(PDO::FETCH_OBJ)) {
			$do_ref = $data->do_ref;
			$item_code = $data->item_code;
			$uom_code = $data->uom_code;
			$line_item_do = $data->line_item_do;
			$qty = $data->qty;
			
			$sql2="update delivery_order_detail set qty_si=ifnull(qty_si,0) - $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
			$sql=$dbpdo->query($sql2);	
			
			/*update status delivery order : I=Invoice in Part (diinvoicekan sebagian)
									  	F=Invoice in Full (diinvoicekan semua)
									  	C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
			*/
			$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_si,0)) qty_si from delivery_order_detail group by ref having ref='$do_ref'";
			$result2 = $dbpdo->query($sql2);
			$data2 = $result2->fetch(PDO::FETCH_OBJ);
			$qty_si = $data2->qty_si;
			$qty = $data2->qty;
			
			if($qty_si < $qty ) {
				$sql2="update delivery_order set status='I' where ref='$do_ref' ";
				$sql=$dbpdo->query($sql2);	
			}
			
			if($qty_si >= $qty ) {
				$sql2="update delivery_order set status='F' where ref='$do_ref' ";
				$sql=$dbpdo->query($sql2);	
			}
			
			if($qty_si == 0 ) {
				$sql2="update delivery_order set status='R' where ref='$do_ref' ";
				$sql=$dbpdo->query($sql2);	
			}
			##*****************************************##
		}					
		
		
		$sqlstr="delete from sales_invoice where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from sales_invoice_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete AR
		$sqlstr="delete from ar where ref='$ref' and invoice_type='SOI'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales' ";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	//---hapus cash receipt
	function delete_cash_receipt($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from cash_receipt where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from cash_receipt_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from jrn where ivino='$ref' and ivitpe='cash_receipt' ";
		$sql=$dbpdo->query($sql2);
		
		//$sql2="delete from ar where ref='$ref' and invoice_type='RCI' ";
		//$sql=$dbpdo->query($sql2);
		
		//delete ARC
		$sqlstr="delete from arc where ref='$ref'";
		$sql=$dbpdo->query($sqlstr);	
					
		return $sql;
	}
	
	
	//---hapus cash payment
	function delete_cash_payment($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from cash_payment where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from cash_payment_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		$sql2="delete from jrn where ivino='$ref' and ivitpe='cash_payment' ";
		$sql=$dbpdo->query($sql2);
		
		//$sql2="delete from ar where ref='$ref' and invoice_type='RCI' ";
		//$sql=$dbpdo->query($sql2);
		
		//delete APC
		$sqlstr="delete from apc where ref='$ref'";
		$sql=$dbpdo->query($sqlstr);	
		
		return $sql;
	}
	
	
	//---hapus week wage
	function delete_week_wage($ref){
		
		$dbpdo = DB::create();
		
		
		$sqlstr="delete from week_wage where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from week_wage_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete AR
		$sqlstr="delete from ar where ref='$ref' and invoice_type='WEG'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete AP
		$sqlstr="delete from ap where ref='$ref' and invoice_type='WEG'";
		$sql=$dbpdo->query($sqlstr);
		
		return $sql;
	}
	
	
	//---hapus purchase invoice
	function delete_purchase_quick($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from purchase_invoice where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from purchase_invoice_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete AP
		$sqlstr="delete from ap where ref='$ref' and invoice_type='PIQ'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_quick' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='purchase_quick' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	//---hapus purchase issued
	function delete_purchase_issue($ref){
		
		$dbpdo = DB::create();
		
		
		
		$sqlstr="delete from purchase_invoice where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from purchase_invoice_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete AP
		$sqlstr="delete from ap where ref='$ref' and invoice_type='PII'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_issue' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='purchase_issue' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	
	//---batal cheque
	function delete_bpoc($ref, $line){
		
		$dbpdo = DB::create();
		
		$uid		=	$_SESSION["loginname"];
		$dlu		=	date("Y-m-d H:i:s");
		
		$sql=$dbpdo->query("update apc set deposite=0, void=1, void_date='$dlu', void_by='$uid' where ref='$ref' and line='$line' ");
	
		return $sql;
	}
	
	
    //---hapus vehicle
	function delete_vehicle($ref){
        $dbpdo = DB::create();
        
        $sql=$dbpdo->query("select replid, photo from vehicle where syscode='$ref' ");
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$foto_file = $data->photo;
		
		if($foto_file != '') {
			$uploaddir 		= 'app/photo_vehicle/';
			unlink($uploaddir . $foto_file); //remove file 
		}
		
		$sql=$dbpdo->query("delete from vehicle where syscode='$ref' ");
	
		return $sql;
	}
    
    
    //---hapus asset type
	function delete_asset_type($ref){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from asset_type where id='$ref' ");
	
		return $sql;
	}
    
    
    //---hapus asset
	function delete_asset($ref){
        $dbpdo = DB::create();
        
        $sql=$dbpdo->query("select photo from asset where ref='$ref' ");
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$foto_file = $data->photo;
		
		if($foto_file != '') {
			$uploaddir 		= 'app/photo_asset/';
			unlink($uploaddir . $foto_file); //remove file 
		}
        
		$sql=$dbpdo->query("delete from asset where ref='$ref' ");
	
		return $sql;
	}
    
    //---hapus asset trans
	function delete_asset_trans($ref){
        $dbpdo = DB::create();
        
		$sql=$dbpdo->query("delete from asset_trans where ref='$ref' ");
	
		return $sql;
	}
    
    
    //---hapus cashier detail
	function delete_cashier_detail($ref, $line){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from sales_invoice_tmp where ref='$ref' and line='$line' ");
	
		return $sql;
	}
	
	//---hapus cashier klik menu
	function delete_cashier_klik($ref){
		$dbpdo = DB::create();
		
		/*$sql=$dbpdo->query("delete from sales_invoice_tmp where uid='$ref' ");
	
		return $sql;*/
	}
	
	//---hapus cashier
	function delete_cashier($ref){
		$dbpdo = DB::create();
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='cashier' ";
		$sql=$dbpdo->query($sql2);
		
		$sqlstr="delete from sales_invoice where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from sales_invoice_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales' ";
		$sql=$dbpdo->query($sqlstr);
		
		//delete ARC
		$sqlstr="delete from arc where ref='$ref'";
		$sql=$dbpdo->query($sqlstr);
        
        //delete AR
		$sqlstr="delete from ar where ref='$ref' and invoice_type='cashier'";
		$sql=$dbpdo->query($sqlstr);
	
		return $sql;
	}
	
	
	
	//===============================
	//---hapus pos detail
	function delete_pos_detail($ref, $line){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from sales_invoice_tmp where ref='$ref' and line='$line' ");
	
		return $sql;
	}
	
	//---hapus pos klik menu
	function delete_pos_klik($ref){
		$dbpdo = DB::create();
		
		/*$sql=$dbpdo->query("delete from sales_invoice_tmp where uid='$ref' ");
	
		return $sql;*/
	}
	
	//---hapus pos
	function delete_pos($ref){
		$dbpdo = DB::create();
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='pos' ";
		$sql=$dbpdo->query($sql2);
		
		$sqlstr="delete from sales_invoice where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from sales_invoice_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales' ";
		$sql=$dbpdo->query($sqlstr);
		
		//delete ARC
		$sqlstr="delete from arc where ref='$ref'";
		$sql=$dbpdo->query($sqlstr);
        
        //delete AR
		$sqlstr="delete from ar where ref='$ref' and invoice_type='pos'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete member
		$sqlstr="delete from sales_invoice_point where ref='$ref'";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		//delete void
		$sqlstr="delete from adt_sales_invoice_detail where ref='$ref'";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
	
		return $sql;
	}
	
	
	//---hapus delete_purchase_inv_detail
	function delete_purchase_inv_detail($ref, $line){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from purchase_invoice_tmp where ref='$ref' and line='$line' ");
	
		return $sql;
	}
	
	
	//---hapus purchase inv
	function delete_purchase_inv($ref){
		
		$dbpdo = DB::create();
		
		$sqlstr="delete from purchase_invoice where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from purchase_invoice_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete AP
		$sqlstr="delete from ap where ref='$ref' and invoice_type='POV'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_inv' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='purchase_inv' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
    
    //---hapus delete_outbound_detail
	function delete_outbound_detail($ref, $line){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from outbound_tmp where ref='$ref' and line='$line' ");
	
		return $sql;
	}
	
	
	//---hapus delete_purchase_return_detail
	function delete_purchase_return_quick_detail($ref, $line){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from purchase_return_tmp where ref='$ref' and line='$line' ");
	
		return $sql;
	}
	
	
	//---hapus purchase return quick
	function delete_purchase_return_quick($ref){
		
		$dbpdo = DB::create();
		
		//delete AP
		$sqlstr="delete from ap where ref='$ref' and invoice_type='PUR'";
		$sql=$dbpdo->query($sqlstr);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_return' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sqlstr="delete from purchase_return where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from purchase_return_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		return $sql;
	}
	
	
	//---hapus cashier box
	function delete_cashier_box($ref){
		$dbpdo = DB::create();
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='cashier' ";
		$sql=$dbpdo->query($sql2);
		
		$sqlstr="delete from sales_invoice where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from sales_invoice_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
		
		//delete journal
		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales' ";
		$sql=$dbpdo->query($sqlstr);
		
		//delete ARC
		$sqlstr="delete from arc where ref='$ref'";
		$sql=$dbpdo->query($sqlstr);
        
        //delete AR
		$sqlstr="delete from ar where ref='$ref' and invoice_type='cashier'";
		$sql=$dbpdo->query($sqlstr);
		
		$sqlstr="delete from sales_invoice_subdetail where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
	
		return $sql;
	}
	
	
	//---hapus cashier detail
	function delete_cashier_box_detail($ref, $line){
		$dbpdo = DB::create();
		
		$sql=$dbpdo->query("delete from sales_invoice_tmp where ref='$ref' and line='$line' ");
	
		return $sql;
	}
	
	//---hapus order stock
	function delete_order_stock($ref){
		$dbpdo = DB::create();
		
		$sql2="delete from bincard where invoice_no='$ref' and invoice_type='order_stock' ";
		$sql=$dbpdo->query($sql2);
		
		$sqlstr="delete from order_stock where ref='$ref' ";
		$sql=$dbpdo->query($sqlstr);
		
		$sql2="delete from order_stock_detail where ref='$ref' ";
		$sql=$dbpdo->query($sql2);
			
		return $sql;
	}
	
}

?>
