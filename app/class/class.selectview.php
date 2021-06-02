<?php

class selectview{	
	
	//---------get data sales invoice
	function list_sales_invoice($ref ='', $client_code='', $from_date='', $to_date='', $location_id='', $all=0, $cashier='', $item_group_id=''){	 
		$dbpdo = DB::create();
			
		$where = "";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
				
		if ( $ref != "") {
			if ($where == "") {
				$where = " where a.ref = '$ref' ";
			} else {
				$where = $where . " and a.ref = '$ref' ";
			}								
		}
		
		if ( $client_code != "") {
			if ($where == "") {
				$where = " where a.client_code = '$client_code' ";
			} else {
				$where = $where . " and a.client_code = '$client_code' ";
			}								
		}
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
		
		if ( $cashier != "") {
			if ($where == "") {
				$where = " where a.uid = '$cashier' ";
			} else {
				$where = $where . " and a.uid = '$cashier' ";
			}								
		}
		
		if ( $item_group_id != "") {
			if ($where == "") {
				$where = " where a.ref in ( select a.ref from sales_invoice_detail a left join item b on a.item_code=b.syscode where b.item_group_id = '$item_group_id' ) ";
			} else {
				$where = $where . " and a.ref in ( select a.ref from sales_invoice_detail a left join item b on a.item_code=b.syscode where b.item_group_id = '$item_group_id' ) ";
			}								
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, b.phone, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------sales invoice detail (saat update)
	function list_sales_invoice_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount, a.unit_price, a.amount, a.line_item_do, a.line_item_so, a.line from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data sales invoice per item
	function rpt_sales_item($ref ='', $item_code='', $from_date='', $to_date='', $location_id='', $all=0){	 
		$dbpdo = DB::create();
			
		$where = " where ifnull(b.note,'') <> 'void' ";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
				
		if ( $ref != "") {
			if ($where == "") {
				$where = " where a.ref = '$ref' ";
			} else {
				$where = $where . " and a.ref = '$ref' ";
			}								
		}
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where (b.item_code = trim('$item_code') or c.code = trim('$item_code') or c.old_code = trim('$item_code')) ";
			} else {
				$where = $where . " and (b.item_code = trim('$item_code') or c.code = trim('$item_code') or c.old_code = trim('$item_code')) ";
			}								
		}
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.date, a.location_id, sum(b.qty) total_qty, b.uom_code, c.old_code, c.code, b.item_code, c.name item_name from sales_invoice_detail b left join sales_invoice a on b.ref=a.ref left join item c on b.item_code=c.syscode " . $where . " group by b.item_code, b.uom_code, c.old_code, c.code order by c.name";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data sales invoice top 10
	function rpt_sales_item_10($ref ='', $item_code='', $from_date='', $to_date='', $location_id='', $all=0){	 
		$dbpdo = DB::create();
			
		$where = "";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " having a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " having a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
				
		if ( $ref != "") {
			if ($where == "") {
				$where = " having a.ref = '$ref' ";
			} else {
				$where = $where . " and a.ref = '$ref' ";
			}								
		}
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " having (b.item_code = trim('$item_code') or c.code = trim('$item_code') or c.old_code = trim('$item_code')) ";
			} else {
				$where = $where . " and (b.item_code = trim('$item_code') or c.code = trim('$item_code') or c.old_code = trim('$item_code')) ";
			}								
		}
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " having a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.date, a.location_id, sum(b.qty) total_qty, b.uom_code, c.old_code, c.code item_code, c.name item_name from sales_invoice_detail b left join sales_invoice a on b.ref=a.ref left join item c on b.item_code=c.syscode group by b.item_code, b.uom_code, c.old_code, c.code " . $where . " order by sum(b.qty) desc, c.name limit 10";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//---------get data delivery orser
	function list_delivery_order($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.location_id, a.ship_to, a.po_number, a.client_code, a.memo, a.uid, a.dlu, b.name client_name, b.address, a.ship_to, b.phone from delivery_order a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------sales delivery detail (saat update)
	function list_delivery_order_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.ship_date, a.line_item_so, a.line from delivery_order_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data purchase invoice
	function list_purchase_invoice($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.bill_number, a.vendor_code, a.top, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.memo, a.uid, a.dlu, b.name vendor_name, b.address, b.phone from purchase_invoice a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------purchase_invoice detail (saat update)
	function list_purchase_invoice_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.po_ref, a.item_code, b.code item_code2, b.name item_name, a.uom_code, a.qty, a.unit_cost, a.amount, a.line_item_po, a.line from purchase_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data good_receipt
	function list_good_receipt($kode ='', $all=0, $act=''){	
		$dbpdo = DB::create();
	 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.date_arrival, a.driver, a.vehicle, a.location_id, a.memo, a.uid, a.dlu, a.driver, a.vehicle, a.date_arrival from good_receipt a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------good_receipt detail (saat update)
	function list_good_receipt_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.po_ref, a.item_code, b.name item_name, a.uom_code, a.qty, a.unit_cost, a.line from good_receipt_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//----------AR Outstanding
	function list_ar_outstanding() {
		$dbpdo = DB::create();
		
		if ($_SESSION["adm"] == 0) {
			$location_id2 = $_SESSION["location_id2"];
			$where = " and c.location_id = '$location_id2' ";
			
			$string = '';
			$sqlstr="select distinct a.contact_code, c.location_id from ar a left join usr b on a.uid=b.usrid left join employee c on b.employee_id=c.id group by a.contact_code, c.location_id having sum(a.debit_amount) - sum(a.credit_amount) <> 0 " . $where . " order by a.contact_code ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows=$sql->rowCount();
			if($rows > 0) {
				while($data=$sql->fetch(PDO::FETCH_OBJ)) {
					if($string == '') {
						$string = "'" . $data->contact_code . "'";
					} else {
						$string = $string . ",'" . $data->contact_code . "'";
					}
				}
				
				$string = " and a.contact_code in (" . $string . ")";
			} else {
				$string = " and a.contact_code = '' ";
			}
			
			$sqlstr="select a.contact_code, b.name, sum(a.debit_amount) - sum(a.credit_amount) amount from ar a left join client b on a.contact_code=b.syscode group by a.contact_code having sum(a.debit_amount) - sum(a.credit_amount) <> 0 and ifnull(b.name,'') <> '' " . $string . " order by b.name ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
		} else {
			$sqlstr="select a.contact_code, b.name, sum(a.debit_amount) - sum(a.credit_amount) amount from ar a left join client b on a.contact_code=b.syscode group by a.contact_code having sum(a.debit_amount) - sum(a.credit_amount) <> 0 and ifnull(b.name,'') <> '' order by b.name ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();	
		}
				
		return $sql;
		
	}
    
    //----------AP Outstanding
	function list_ap_outstanding_dashboard() {
		$dbpdo = DB::create();
		
		if ($_SESSION["adm"] == 0) {
			$location_id2 = $_SESSION["location_id2"];
			$where = " and c.location_id = '$location_id2' ";
			
			$string = '';
			$sqlstr="select distinct a.contact_code from ap a left join usr b on a.uid=b.usrid left join employee c on b.employee_id=c.id group by a.contact_code, c.location_id having sum(a.credit_amount) - sum(a.debit_amount) <> 0" . $where . " order by a.contact_code ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows=$sql->rowCount();
			if($rows > 0) {
				while($data=$sql->fetch(PDO::FETCH_OBJ)) {
					if($string == '') {
						$string = "'" . $data->contact_code . "'";
					} else {
						$string = $string . ",'" . $data->contact_code . "'";
					}
				}
				
				$string = " and a.contact_code in (" . $string . ")";
			} else {
				$string = " and a.contact_code = '' ";
			}
			
			
			$sqlstr="select a.contact_code, b.name, sum(a.credit_amount) - sum(a.debit_amount) amount from ap a left join vendor b on a.contact_code=b.syscode group by a.contact_code having sum(a.credit_amount) - sum(a.debit_amount) <> 0 and ifnull(b.name,'') <> '' " . $string . " order by b.name ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
						
		} else {
			$sqlstr="select a.contact_code, b.name, sum(a.credit_amount) - sum(a.debit_amount) amount from ap a left join vendor b on a.contact_code=b.syscode group by a.contact_code having sum(a.credit_amount) - sum(a.debit_amount) <> 0 and ifnull(b.name,'') <> '' order by b.name ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		}
		
				
		return $sql;
	}
	
	//----------top 10 penjualan tervesar
	function list_top10_sales() {
		$dbpdo = DB::create();
		
		$where = "";
		
		$month	= date("Y-m", strtotime("-3 month"));
		//echo $month2;
		
		//$sqlstr="select a.date, b.name, ifnull(sum(a.total),0) amount from sales_invoice a left join client b on a.client_code=b.syscode where ifnull(b.name,'') <> '' and month(a.date)='$month' and year(a.date)='$year' group by b.name, month(a.date), year(a.date) order by ifnull(a.total,0) desc limit 10 ";
		if ($_SESSION["adm"] == 0) {
			$location_id2 = $_SESSION["location_id2"];
			$where = " and d.location_id = '$location_id2' ";
			
			$sqlstr="select a.date, b.name, ifnull(sum(a.total),0) amount from sales_invoice a left join client b on a.client_code=b.syscode left join usr c on a.uid=c.usrid left join employee d on c.employee_id=d.id where ifnull(b.name,'') <> '' and date_format(date, '%Y-%m')>='$month' " . $where . " group by b.name order by ifnull(a.total,0) desc limit 10 ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
		} else {
			$sqlstr="select a.date, b.name, ifnull(sum(a.total),0) amount from sales_invoice a left join client b on a.client_code=b.syscode where ifnull(b.name,'') <> '' and date_format(date, '%Y-%m')>='$month' group by b.name order by ifnull(a.total,0) desc limit 10 ";	
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		}
				
		return $sql;
	}
	
	
	//---------get data chart rekapitulasi sales
	function chart_rekapitulasi_sales($bulan='',$tahun=0){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(b.name,'') <> '' ";
		
		if ( $bulan != "") {
			if ($where == "") {
				$where = " where month(a.date) = '$bulan' ";
			} else {
				$where = $where . " and month(a.date) = '$bulan' ";
			}								
		}
		
		if ( $tahun != "") {
			if ($where == "") {
				$where = " where year(a.date) = '$tahun' ";
			} else {
				$where = $where . " and year(a.date) = '$tahun' ";
			}								
		}
		
		if ($_SESSION["adm"] == 0) {
			$location_id2 = $_SESSION["location_id2"];
			
			if($where == '') {
				$where = " where d.location_id = '$location_id2' ";
			} else {
				$where = $where . " and d.location_id = '$location_id2' ";
			}
			
			$sqlstr="select ifnull(sum(a.total),0) total from sales_invoice a left join client b on a.client_code=b.syscode left join usr c on a.uid=c.usrid left join employee d on c.employee_id=d.id " . $where . " group by year(a.date), month(a.date), d.location_id ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		} else {
			$sqlstr="select ifnull(sum(a.total),0) total from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " group by year(a.date), month(a.date)";	
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		}
		
		return $sql;
	}
	
	
	//---------get data cash invoice
	function list_cash_invoice($kode ='', $all=0, $act=''){	
		$dbpdo = DB::create();
		 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.ref2, a.date, a.due_date, a.status, a.top, a.client_code, b.name client_name, b.phone, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.cash, a.bank_amount, a.ovo, a.gopay, a.location_id, ifnull(a.deposit,0) deposit, a.discount, a.cash_amount, a.cash_voucher, a.change_amount, a.void, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//-----------cash invoice detail (saat update)
	function list_cash_invoice_detail($id='', $posisi=0, $batas=0) {
		$dbpdo = DB::create();
		
		if($batas > 0) {
			$limit = " limit $posisi, $batas";
		}
				
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.name item_name, a.item_name2, a.uom_code, a.qty, a.discount, a.discount3, a.unit_price, a.unit_price2, a.amount, a.amount2, a.dummy, a.line_item_do, a.line_item_so, a.line from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line " . $limit;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data sales invoice
	function rpt_sales_invoice($month = '', $month1 = '', $year = '', $all = 0, $location_id=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $month != "") {
			if ($where == "") {
				$where = " where month(a.date) >= '$month' ";
			} else {
				$where = $where . " and month(a.date) >= '$month' ";
			}								
		}
		
		if ( $month1 != "") {
			if ($where == "") {
				$where = " where month(a.date) <= '$month1' ";
			} else {
				$where = $where . " and month(a.date) <= '$month1' ";
			}								
		}
		
		if ( $year != "") {
			if ($where == "") {
				$where = " where year(a.date) <= '$year' ";
			} else {
				$where = $where . " and year(a.date) <= '$year' ";
			}								
		}
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}
		}
		
		if($all != 0) {
			$where = "";
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, b.phone, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.date";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data sales invoice detail
	function rpt_sales_invoice_detail($month = '', $month1 = '', $year = '', $all = 0, $location_id=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $month != "") {
			if ($where == "") {
				$where = " where month(a.date) >= '$month' ";
			} else {
				$where = $where . " and month(a.date) >= '$month' ";
			}								
		}
		
		if ( $month1 != "") {
			if ($where == "") {
				$where = " where month(a.date) <= '$month1' ";
			} else {
				$where = $where . " and month(a.date) <= '$month1' ";
			}								
		}
		
		if ( $year != "") {
			if ($where == "") {
				$where = " where year(a.date) <= '$year' ";
			} else {
				$where = $where . " and year(a.date) <= '$year' ";
			}								
		}
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}
		}
		
		if($all != 0) {
			$where = "";
		}
		
		//$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, b.phone, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.date";
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, b.phone, b.address, b.fax, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.uid, a.dlu, d.code item_code, d.name item_name, c.qty, c.uom_code, c.unit_price, (c.unit_price * c.qty) amount, c.discount, c.amount total_amount from sales_invoice a left join client b on a.client_code=b.syscode left join sales_invoice_detail c on a.ref=c.ref left join item d on c.item_code=d.syscode " . $where . " order by a.date, a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data sales invoice (per days)
	function rpt_sales_invoice_day($date_from = '', $date_to = '', $all = 0, $location_id=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
		
		if ($location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}
		}
		
		if($all != 0) {
			$where = "";
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, b.phone, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.date";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data sales invoice detail (per days)
	function rpt_sales_invoice_day_detail($date_from = '', $date_to = '', $all = 0, $location_id=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
		
		if ($location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}
		}
		
		if($all != 0) {
			$where = "";
		}
		
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, b.phone, b.address, b.fax, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.uid, a.dlu, d.code item_code, d.name item_name, c.qty, c.uom_code, c.unit_price, (c.unit_price * c.qty) amount, c.discount, c.amount total_amount from sales_invoice a left join client b on a.client_code=b.syscode left join sales_invoice_detail c on a.ref=c.ref left join item d on c.item_code=d.syscode " . $where . " order by a.date, a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get data cash invoice per kasir
	function list_pos_print_total($kode ='', $all=0, $from_date='', $to_date='', $shift='', $cashier='', $void='', $closed=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POS%' ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <='$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		if ( $shift != "") {
			if ($where == "") {
				$where = " where a.shift = '$shift' ";
			} else {
				$where = $where . " and a.shift = '$shift' ";
			}								
		}
		
		if ( $cashier != "") {
			if ($where == "") {
				$where = " where a.uid = '$cashier' ";
			} else {
				$where = $where . " and a.uid = '$cashier' ";
			}								
		}
				
		if ( $void == 1) {
			if ($where == "") {
				$where = " where a.void = 1 ";
			} else {
				$where = $where . " and a.void = 1 ";
			}								
		} /*else {
			if ($where == "") {
				$where = " where ifnull(a.void,0) = 0 ";
			} else {
				$where = $where . " and ifnull(a.void,0) = 0 ";
			}
		}*/
		
		if ( $closed == "1") {
			if ($where == "") {
				$where = " where a.closed = 1 ";
			} else {
				$where = $where . " and a.closed = 1 ";
			}								
		}
		
		if($all == 1) {
			$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POS%' ";
			
		}
		
		
		$sqlstr="select sum(a.total) total, sum(a.cash_amount) cash_amount, sum(a.cash_voucher) cash_voucher, a.location_id, sum(a.discount) discount, a.uid from sales_invoice a " . $where . " group by a.uid order by a.uid";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data kasir
	function get_kasir($uid=''){
		$dbpdo = DB::create();
		
		$where == "";
		
		if ( $uid != "") {
			if ($where == "") {
				$where = " where a.uid = '$uid' ";
			} else {
				$where = $where . " and a.uid = '$uid' ";
			}								
		}		 
		
		$sqlstr="select distinct a.uid from sales_invoice a " . $where . " order by a.uid";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//----------Report AR Outstanding
	function rpt_ar_outstanding($date_from = '', $date_to = '', $contact_code = '', $all = 0) {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
		
		if ( $contact_code != "") {
			
			if ($where == "") {
				$where = " where a.contact_code = '$contact_code' ";
			} else {
				$where = $where . " and a.contact_code = '$contact_code' ";
			}								
		}
		
		if($all != 0) {
			$where = "";
		}
		
		$sqlstr="select a.invoice_no, a.date, b.name client_name, a.contact_code, sum(a.debit_amount) debit_amount, sum(a.credit_amount) credit_amount, sum(a.debit_amount) - sum(a.credit_amount) amount from ar a left join client b on a.contact_code=b.syscode " . $where . " group by a.date, a.contact_code, a.invoice_no having sum(a.debit_amount) - sum(a.credit_amount) <> 0 and ifnull(b.name,'') <> '' order by a.date, b.name ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data bincard
	function rpt_bincard($item_code = '', $location_id = '', $uom_code = '', $date_from='', $date_to='', $all = 0){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(b.name,'') <> '' ";
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
			
		}
		
		/*if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			} else {
				$where = $where . " and (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			}								
		}*/
		
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (a.item_code = trim('$item_code')) ";
			} else {
				$where = $where . " and (a.item_code = trim('$item_code')) ";
			}								
		}
		
		if ( $uom_code != "") {
		
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		$sqlstr="select a.invoice_no, a.date, a.invoice_type, a.description, a.uom_code, a.debit_qty, a.credit_qty, b.name item_name, a.item_code, a.location_code, c.name location_name from bincard a left join item b on a.item_code=b.syscode left join warehouse c on a.location_code=c.id " . $where . " order by a.date, a.dlu";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//---------get data ietm form bincard
	function rpt_bincard_item($item_code='', $location_id='', $uom_code='', $all = 0, $item_group_id=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(b.name,'') <> '' ";
		
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			} else {
				$where = $where . " and (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			}								
		}
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		if ( $item_group_id != "") {
			
			if ($where == "") {
				$where = " where b.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and b.item_group_id = '$item_group_id' ";
			}								
		}
		
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
		}
		
		$sqlstr="select distinct a.uom_code, a.item_code, a.location_code, b.code, b.name item_name from bincard a left join item b on a.item_code=b.syscode " . $where . " order by b.name";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data ietm form bincard2
	function rpt_item_bincard($item_code='', $uom_code='', $all = 0, $item_group_id=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.name,'') <> '' ";
		
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (a.syscode = trim('$item_code') or a.code = trim('$item_code') or a.old_code = trim('$item_code')) ";
			} else {
				$where = $where . " and (a.syscode = trim('$item_code') or a.code = trim('$item_code') or a.old_code = trim('$item_code')) ";
			}								
		}
		
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code_stock = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code_stock = '$uom_code' ";
			}								
		}
		
		if ( $item_group_id != "") {
			
			if ($where == "") {
				$where = " where a.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and a.item_group_id = '$item_group_id' ";
			}								
		}
		
		
		if($all != 0) {
			$where = " where ifnull(a.name,'') <> '' ";
		}
		
		$sqlstr="select distinct a.uom_code_stock uom_code, a.syscode item_code, a.code, a.name item_name from item a  " . $where . " order by a.name";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data opnblc item form bincard
	function rpt_bincard_openblc_item($item_code='', $uom_code='', $location_id='', $date='', $all = 0){	
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $location_id != "" && $location_id != "0") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
				
		
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
        
        
        ##get date stock opname terakhir
        if($location_id == "" || $location_id != "0") {
            $sqlstr		= "select date from bincard where invoice_type='stockopname' and item_code='$item_code' and uom_code='$uom_code' order by date desc limit 1";
            $sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
        } else {
            $sqlstr		= "select date from bincard where invoice_type='stockopname' and location_code='$location_id' and item_code='$item_code' and uom_code='$uom_code' order by date desc limit 1";
            $sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
        }
		
        //echo $sqlstring."<br>";
		//$sqlstock		= mysql_query($sqlstring);
		$datadate		= $sql->fetch(PDO::FETCH_OBJ);
		$datebincard 	= $datadate->date;
		
		
		if ( $datebincard != "") {
			$datebincard = date("Y-m-d", strtotime($datebincard));
			if ($where == "") {
				$where = " where a.date >= '$datebincard' ";
			} else {
				$where = $where . " and a.date >= '$datebincard' ";
			}	
            
            if ( $date != "") {
			
    			$date = date("Y-m-d", strtotime($date));
    			
    			if ($where == "") {
    				$where = " where a.date < '$date' ";
    			} else {
    				$where = $where . " and a.date < '$date' ";
    			}								
    		}
            
		} else {
            if ( $date != "") {
			
    			$date = date("Y-m-d", strtotime($date));
    			
    			if ($where == "") {
    				$where = " where a.date < '$date' ";
    			} else {
    				$where = $where . " and a.date < '$date' ";
    			}		
    								
    		}
        }
		##-----------------
        
        if($all != 0) {
			$date = date("Y-m-d");
			
			$where = " where a.date < '$date' ";
		}
		
        $sqlstr = "select ifnull(sum(a.debit_qty) - sum(a.credit_qty),0) opnblc from bincard a left join item b on a.item_code=b.syscode " . $where . " group by a.item_code, a.uom_code ";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
        //$sql=mysql_query($sqlstr);

		
		return $sql;
	}
	
	
	//----------Report AP Outstanding
	function rpt_ap_outstanding($date_from = '', $date_to = '', $all = 0, $vendor_code='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
		
		if ( $vendor_code != "") {
			
			if ($where == "") {
				$where = " where a.contact_code = '$vendor_code' ";
			} else {
				$where = $where . " and a.contact_code = '$vendor_code' ";
			}								
		}
		
		if($all != 0) {
			$where = "";
		}
		
		$sqlstr="select a.invoice_no, a.date, a.contact_code, b.name vendor_name, sum(a.debit_amount) debit_amount, sum(a.credit_amount) credit_amount, sum(a.credit_amount) - sum(a.debit_amount) amount, c.tax_rate, (select sum(aa.amount) from purchase_invoice_detail aa group by aa.ref having aa.ref=a.ref) amount_total from ap a left join vendor b on a.contact_code=b.syscode left join purchase_invoice c on a.ref=c.ref " . $where . " group by a.contact_code, a.invoice_no having sum(a.credit_amount) - sum(a.debit_amount) <> 0 and ifnull(b.name,'') <> '' order by b.name ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data delivery order quick
	function list_delivery_order_quick($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.location_id, a.ship_to, a.po_number, a.client_code, a.memo, a.uid, a.dlu, b.name client_name, b.address, a.ship_to, b.phone from delivery_order a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------sales delivery detail quick (saat update)
	function list_delivery_order_quick_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.ship_date, a.line_item_so, a.line from delivery_order_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.so_ref, a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//----------get no invoice
	function get_no_ref_quick_detail($id) {
		$dbpdo = DB::create();
	
		$sqlstr="select distinct a.so_ref, ifnull(b.cash,0) cash from delivery_order_detail a left join sales_invoice b on a.so_ref=b.ref where a.ref='$id' order by a.so_ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//----------invoice belum dibuat surat jalan per customer
	function list_invoice_outstanding_do_customer() {
		$dbpdo = DB::create();
		
		if ($_SESSION["adm"] == 0) {
			$location_id2 = $_SESSION["location_id2"];
			$where = " and e.location_id = '$location_id2' ";
			
			$sqlstr="select count(a.ref) jml, b.client_code, c.name client_name from sales_invoice_detail a left join sales_invoice b on a.ref=b.ref left join client c on b.client_code=c.syscode left join usr d on b.uid=d.usrid left join employee e on d.employee_id=e.id where a.ref like '%CSH%' group by b.client_code, e.location_id having sum(qty)-sum(ifnull(a.qty_shp,0)) > 0 and ifnull(c.name,'') <> '' ". $where . " order by c.name";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		
		} else {
			
			$sqlstr = "select count(a.ref) jml, b.client_code, c.name client_name from sales_invoice_detail a left join sales_invoice b on a.ref=b.ref left join client c on b.client_code=c.syscode where a.ref like '%CSH%' group by b.client_code having sum(qty)-sum(ifnull(a.qty_shp,0)) > 0 and ifnull(c.name,'') <> '' 
order by b.client_code";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			//$sql=mysql_query($sqlstring);

		}
				
		return $sql;
	} 
	
	
	//----------invoice belum dibuat surat jalan
	function list_invoice_outstanding_do() {
		$dbpdo = DB::create();
		
		if ($_SESSION["adm"] == 0) {
			$location_id2 = $_SESSION["location_id2"];
			$where = " and e.location_id = '$location_id2' ";
			
			$sqlstr = "select count(a.ref) jml from sales_invoice_detail a left join sales_invoice b on a.ref=b.ref left join usr d on b.uid=d.usrid left join employee e on d.employee_id=e.id where a.ref like '%CSH%' group by e.location_id having sum(qty)-sum(ifnull(a.qty_shp,0)) > 0 ". $where . " ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			//$sql=mysql_query($sqlstring);
		
		} else {
			
			$sqlstr = "select count(a.ref) jml from sales_invoice_detail a left join sales_invoice b on a.ref=b.ref where a.ref like '%CSH%' having sum(qty)-sum(ifnull(a.qty_shp,0)) > 0 ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			//$sql=mysql_query($sqlstring);

		}
				
		return $sql;
	}
	
	//----------invoice belum dibuat surat jalan
	function list_invoice_outstanding_do_detail($clncde='') {
		$dbpdo = DB::create();
		
		if ($_SESSION["adm"] == 0) {
			$location_id2 = $_SESSION["location_id2"];
			$where = " and e.location_id = '$location_id2' and b.client_code='$clncde' ";
			
			$sqlstr="select a.ref, b.client_code, c.name client_name, sum(a.qty)-sum(ifnull(a.qty_shp,0)) qty from sales_invoice_detail a left join sales_invoice b on a.ref=b.ref left join client c on b.client_code=c.syscode left join usr d on b.uid=d.usrid left join employee e on d.employee_id=e.id group by a.ref, b.client_code, e.location_id having sum(qty)-sum(ifnull(a.qty_shp,0)) > 0 and a.ref like '%CSH%' and ifnull(c.name,'') <> '' " . $where . " order by a.ref";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
		} else {
			$sqlstr="select a.ref, b.client_code, c.name client_name, sum(a.qty)-sum(ifnull(a.qty_shp,0)) qty from sales_invoice_detail a left join sales_invoice b on a.ref=b.ref left join client c on b.client_code=c.syscode group by a.ref, b.client_code having sum(qty)-sum(ifnull(a.qty_shp,0)) > 0 and a.ref like '%CSH%' and ifnull(c.name,'') <> '' and b.client_code='$clncde' order by a.ref ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();	
			
		}
				
		return $sql;
	}
	
	
	//---------get data delivery order project
	function list_delivery_order_project($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.location_id, a.ship_to, a.po_number, a.client_code, a.memo, a.uid, a.dlu, b.name client_name, b.address, a.ship_to, b.phone from delivery_order a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------sales delivery detail (saat update)
	function list_delivery_order_project_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.ship_date, a.line_item_so, a.line from delivery_order_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data sales invoice project
	function list_sales_invoice_project($ref =''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $ref != "") {
			if ($where == "") {
				$where = " where a.ref = '$ref' ";
			} else {
				$where = $where . " and a.ref = '$ref' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, b.phone, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.deposit, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------sales invoice project detail (saat update)
	function list_sales_invoice_project_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount, a.unit_price, a.unit_price2, a.amount, a.amount2, a.dummy, a.line_item_do, a.line_item_so, a.line from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//----------Report Receipt Total
	function rpt_receipt_total($invoice_no='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $invoice_no != "") {
			
			if ($where == "") {
				$where = " where a.invoice_no = '$invoice_no' ";
			} else {
				$where = $where . " and a.invoice_no = '$invoice_no' ";
			}								
		}
		
		$sqlstr="select a.debit_amount from ar a " . $where . " order by a.date, a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//----------Report Receipt History
	function rpt_receipt_history($invoice_no='') {
		$dbpdo = DB::create();
		
		$where = " where ifnull(b.name,'') <> '' and (a.invoice_type = 'RCI' or a.invoice_type = 'WEG') ";
		
		if ( $invoice_no != "") {
			
			if ($where == "") {
				$where = " where a.invoice_no = '$invoice_no' ";
			} else {
				$where = $where . " and a.invoice_no = '$invoice_no' ";
			}								
		}
		
		$sqlstr="select a.ref, a.invoice_no, a.date, b.name client_name, a.credit_amount from ar a left join  (select id code, concat(name, ' ( ','Employee',' )') name, 'E' type from employee where active=1 union all  select syscode code, concat(name,' (',ifnull(phone,''),')') name, 'C' type from client where active=1 and ifnull(name,'') <> '' ) b on a.contact_code=b.code " . $where . " order by a.date, a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data warehouse
	function list_warehouse($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.code = '$kode' ";
			} else {
				$where = $where . " and a.code = '$kode' ";
			}								
		}

		$sqlstr="select a.id, a.code, a.name, a.address, a.email, a.phone, a.active, a.uid, a.dlu from warehouse a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data report journal
	function rpt_journal($jenis_transaksi = '', $ref_code = '', $date_from = '', $date_to = '', $acc_code = ''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $jenis_transaksi != "") {
			if ($where == "") {
				$where = " where a.ivitpe = '$jenis_transaksi' ";
			} else {
				$where = $where . " and a.ivitpe = '$jenis_transaksi' ";
			}								
		}
		
		if ( $ref_code != "") {
			if ($where == "") {
				$where = " where a.ivino = '$ref_code' ";
			} else {
				$where = $where . " and a.ivino = '$ref_code' ";
			}								
		}
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.ividte >= '$date_from' ";
			} else {
				$where = $where . " and a.ividte >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.ividte <= '$date_to' ";
			} else {
				$where = $where . " and a.ividte <= '$date_to' ";
			}								
		}
		
		if ( $acc_code != "") {
			if ($where == "") {
				$where = " where a.acccde = '$acc_code' ";
			} else {
				$where = $where . " and a.acccde = '$acc_code' ";
			}								
		}
		
		$sqlstr="select a.ivino, a.ividte, a.dcr, a.dbtamt, a.crdamt, b.acc_code, b.name acc_name from jrn a left join coa b on a.acccde=b.syscode " . $where . " order by a.ivino, a.ividte";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data invoice outstanding Delivery Order
	function rpt_sales_outstanding_do($date_from = '', $date_to = '', $all = 0){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
		
		if($all != 0) {
			$where = "";
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, b.phone, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.date";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------cash invoice outstanding DO detail
	function rpt_sales_outstanding_do_detail($id) {
		$dbpdo = DB::create();		
	
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount, ifnull(a.qty_shp,0) qty_shp, ifnull(a.qty,0)-ifnull(a.qty_shp,0) qty_out from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' and ifnull(a.qty,0)-ifnull(a.qty_shp,0) > 0 order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data History Delivery Order
	function rpt_delord_history($date_from = '', $date_to = '', $client_code = '', $ref = '', $all = 0){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
        
        if ( $client_code != "") {
			if ($where == "") {
				$where = " where a.client_code = '$client_code' ";
			} else {
				$where = $where . " and a.client_code = '$client_code' ";
			}								
		}
        
        if ( $ref != "") {
			if ($where == "") {
				$where = " where a.ref = '$ref' ";
			} else {
				$where = $where . " and a.ref = '$ref' ";
			}								
		}
		
		if($all != 0) {
			$where = "";
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, b.phone, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.date";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//-----------cash DO detail
	function rpt_delord_history_detail($id) {
		$dbpdo = DB::create();		
		
		//$sqlstr="select a.ref, a.date, c.code item_code, c.name item_name, sum(b.qty) qty, sum(d.qty) qty_sales, sum(ifnull(d.qty,0))- sum(ifnull(b.qty,0)) qty_out_shp from delivery_order a left join delivery_order_detail b on a.ref=b.ref left join item c on b.item_code=c.syscode left join sales_invoice_detail d on b.so_ref=d.ref and b.item_code=d.item_code and b.uom_code=d.uom_code where d.ref='$id' group by d.ref, c.code, a.ref order by b.line ";
        
        $sqlstr="select a.ref, a.date, c.code item_code, c.name item_name, b.qty, d.qty qty_sales, ifnull(d.qty,0)- ifnull(b.qty,0) qty_out_shp from delivery_order a left join delivery_order_detail b on a.ref=b.ref left join item c on b.item_code=c.syscode left join sales_invoice_detail d on b.so_ref=d.ref and b.item_code=d.item_code and b.uom_code=d.uom_code where d.ref='$id' order by c.code, b.line ";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
        
        //$sqlstr="select a.ref, a.date, c.code item_code, c.name item_name, b.qty, d.qty qty_sales, ifnull(d.qty,0)- ifnull(b.qty,0) qty_out_shp from delivery_order a left join delivery_order_detail b on a.ref=b.ref left join item c on b.item_code=c.syscode left join sales_invoice_detail d on b.so_ref=d.ref and b.item_code=d.item_code and b.uom_code=d.uom_code where b.so_ref='$id' order by b.line ";
				
		return $sql;
	}
	
	function rpt_delord_history_per_item_detail($id, $refdo, $item_code) {
		$dbpdo = DB::create();		
		
		$sqlstr="select ifnull(d.qty,0)- sum(ifnull(b.qty,0)) qty_out_shp from delivery_order a left join delivery_order_detail b on a.ref=b.ref left join item c on b.item_code=c.syscode left join sales_invoice_detail d on b.so_ref=d.ref and b.item_code=d.item_code and b.uom_code=d.uom_code where d.ref='$id' and d.item_code='$item_code' and a.ref='$refdo' group by a.ref, d.item_code, d.ref order by c.code, b.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
        				
		return $sql;
	}
    
	function get_invoice_detail($clien_code='', $invoice_no='') {
		$dbpdo = DB::create();
						
		$sqlstr="
					select aa.*, bb.installment, bb.loan from (select a.invoice_no, a.date, a.due_date, a.contact_type, a.contact_code, a.contact_other, a.ref_type invoice_type, sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.credit_amount,0)) - sum(ifnull(a.discount_amount,0)) amount_paid, a.ref_type, a.currency_code, a.rate, a.exchange_type, a.exchange_date, a.top, a.description, a.uid, a.dlu from ar a group by a.contact_code, a.contact_type, a.invoice_no, a.ref_type having (sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.credit_amount,0)) - sum(ifnull(a.discount_amount,0))) <> 0 )  aa left join direct_receipt bb on aa.invoice_no=bb.ref where aa.contact_code = '$clien_code' and aa.invoice_no ='$invoice_no' order by aa.invoice_no, aa.date";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		
		return $sql;
	}
	
	
	//---------get data GENERAL LEGDER
	function rpt_general_legder($date_from = '', $date_to = '', $client_code = '', $ref = '', $all = 0){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
        
        if ( $client_code != "") {
			if ($where == "") {
				$where = " where a.client_code = '$client_code' ";
			} else {
				$where = $where . " and a.client_code = '$client_code' ";
			}								
		}
        
        if ( $ref != "") {
			if ($where == "") {
				$where = " where a.ref = '$ref' ";
			} else {
				$where = $where . " and a.ref = '$ref' ";
			}								
		}
		
		if($all != 0) {
			$where = "";
		}
		
		
		$sqlstr = "Select a.acc_type, a.acc_code, a.name, a.ivino, a.ivitpe, a.ividte, a.dcr,
					a.dbtamt, a.crdamt, a.opening_balance From
					(
							Select a.acc_type, a.acc_code, a.name, 'Opening' ivino, '' ivitpe, 
								'01-01-1970' ividte, '' dcr,
								0 dbtamt, 0 crdamt, ifnull(a.opening_balance, 0) + ifnull(b.opening_balance, 0) opening_balance
								From coa a
									Left Join
									(
										Select b.acccde, 
										Sum(ifnull(b.dbtamt,0)) - Sum(ifnull(b.crdamt,0)) opening_balance
										From jrn b
										Where b.ividte < 
										'01-01-1970'
										Group By b.acccde
									) b On a.syscode = b.acccde
								Where a.postable = 1 And a.acc_type In ('1', '5', '6', '8')

							union all

							Select a.acc_type, a.acc_code, a.name, 'Opening' ivino, '' ivitpe, 
								'01-01-1970' ividte, '' dcr,
								0 dbtamt, 0 crdamt, ifnull(a.opening_balance, 0) + ifnull(b.opening_balance, 0) opening_balance
								From coa a
									Left Join
									(
										Select b.acccde, 
										Sum(ifnull(b.dbtamt,0)) - Sum(ifnull(b.crdamt,0)) opening_balance
										From jrn b
										Where b.ividte < 
										'01-01-1970'
										Group By b.acccde
									) b On a.syscode = b.acccde
								Where a.postable = 1 And a.acc_type In ('2', '3', '4', '7')

							union all

							Select b.acc_type, a.acccde acc_code, b.name, a.ivino, a.ivitpe, a.ividte, a.dcr, 
								a.dbtamt, a.crdamt, 0 opening_balance
								From jrn a, coa b
								Where a.acccde = b.syscode
								  And b.postable = 1
								  And a.ividte >= '01-01-1970'
								  And a.ividte <= '01-01-1970'
					) a ";
	
		
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		//$sql=mysql_query($sqlstr);

		
		return $sql;
	}
	
		
	//---------get data NERACA
	function rpt_neraca($date_from = '', $date_to = '', $acc_code1 = '', $acc_code2 = '', $all = ''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.ividte >= '$date_from' ";
			} else {
				$where = $where . " and a.ividte >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.ividte <= '$date_to' ";
			} else {
				$where = $where . " and a.ividte <= '$date_to' ";
			}								
		}
        
        if ( $acc_code1 != "") {
			if ($where == "") {
				$where = " where a.acccde >= '$acc_code1' ";
			} else {
				$where = $where . " and a.acccde >= '$acc_code1' ";
			}								
		}
		
		if ( $acc_code2 != "") {
			if ($where == "") {
				$where = " where a.acccde <= '$acc_code2' ";
			} else {
				$where = $where . " and a.acccde <= '$acc_code2' ";
			}								
		}
		
        
        if($all != '' && $all != 0) {
			$where = "";
		}
		
		if ($_SESSION["adm"] == 0) {
			$location_id2 = $_SESSION["location_id2"];
			
			if($where == '') {
				$where = " where d.location_id = '$location_id2' ";	
			} else {
				$where = $where . " and d.location_id = '$location_id2' ";
			}
						
			$sqlstr = "Select b.acc_code account_no, b.name account_name, Sum(a.dbtamt) debit, Sum(a.crdamt) credit From jrn a Left Join coa b On a.acccde=b.syscode left join usr c on a.uid=c.usrid left join employee d on c.employee_id=d.id	" . $where . " Group By a.acccde, b.name, d.location_id Order By b.acc_code";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			//$sql=mysql_query($sqlstr);
		} else {
			$sqlstr = "Select b.acc_code account_no, b.name account_name, Sum(a.dbtamt) debit, Sum(a.crdamt) credit From jrn a Left Join coa b On a.acccde=b.syscode	" . $where . " Group By a.acccde, b.name Order By b.acc_code";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			//$sql=mysql_query($sqlstr);	
		}
		
		
		return $sql;
	}
	
	
	//---------Pofit & Loss Report
	function rpt_profit_loss($frmdte, $todte){
		$dbpdo = DB::create();
				
		$where = "";
		
		if ($frmdte != '' && $todte == '') {
			$frmdte = date('Y-m-d', strtotime($frmdte));
			if($where == '') { $where = "  a.ividte = '$frmdte' "; } else { $where = $where . " and a.ividte = '$frmdte' "; } 
		}
		if ($frmdte == '' && $todte != '') {
			$todte = date('Y-m-d', strtotime($todte));
			if($where == '') { $where = "  a.ividte = '$todte' "; } else { $where = $where . " and a.ividte = '$todte' "; } 
		}
		
		if ($frmdte != '' && $todte != '') {
			$frmdte = date('Y-m-d', strtotime($frmdte));
			$todte = date('Y-m-d', strtotime($todte));
			if($where == '') { $where = "  a.ividte >= '$frmdte' and a.ividte <= '$todte' "; } else { $where = $where . " and a.ividte >= '$frmdte' and a.ividte <= '$todte' "; } 
		}
		
		if ($frmdte == '' && $todte == '') {
			$frmdte = date('Y-m-d');
			$todte = date('Y-m-d');
			if($where == '') { $where = "  a.ividte >= '$frmdte' and a.ividte <= '$todte' "; } else { $where = $where . " and a.ividte >= '$frmdte' and a.ividte <= '$todte' "; } 
		}
		
		$sqlstr = "select aaa.accdcr, aaa.acc_type, aaa.acccde, aaa.accdcr, ifnull(bbb.amt,0) amt, 
				aaa.postable, ddd.amt4, ddd.amt5, ddd.amt6, ddd.amt7, ddd.amt8 from

				(select name accdcr, acc_type, acc_code acccde, postable from coa where acc_type in ('4', '5', '6', '7', '8')) aaa
				left join 
				(select aa.acccde, sum(ifnull(aa.crdamt,0) - ifnull(aa.dbtamt,0)) amt from
							(select b.acc_code acccde, a.dbtamt, a.crdamt from jrn a
							left join coa b on a.acccde=b.syscode 
							where b.acc_type in ('4','7') and " . $where . "  ) aa
							group by aa.acccde
							union all
							select aa.acccde, sum(ifnull(aa.dbtamt,0) - ifnull(aa.crdamt,0)) amt from
							(select b.acc_code acccde, a.dbtamt, a.crdamt from jrn a
							left join coa b on a.acccde=b.syscode where b.acc_type in ('5','6','8')
							and " . $where . " ) aa group by aa.acccde) bbb 
							on aaa.acccde=bbb.acccde,

				(Select ab.amt4, ad.amt5, ae.amt6, ac.amt7, af.amt8
				From
				(Select sum(ifnull(aa.crdamt,0) - ifnull(aa.dbtamt,0)) amt4 From 
					(Select a.dbtamt, a.crdamt From jrn a Left Join coa b On a.acccde = b.syscode 
						Where b.acc_type = '4' and " . $where . "  and b.postable = 1) aa) ab,
				(Select Sum(ifnull(aa.crdamt,0) - ifnull(aa.dbtamt,0)) amt7 From 
					(Select a.dbtamt, a.crdamt From jrn a Left Join coa b On a.acccde = b.syscode
						Where b.acc_type = '7' and " . $where . "  and b.postable = 1) aa) ac,
				(Select Sum(ifnull(aa.dbtamt,0) - ifnull(aa.crdamt,0)) amt5 From 
					(Select a.dbtamt, a.crdamt From jrn a Left Join coa b On a.acccde = b.syscode
						Where b.acc_type = '5' and " . $where . "  and b.postable = 1) aa) ad,
				(Select Sum(ifnull(aa.dbtamt,0) - ifnull(aa.crdamt,0)) amt6 From 
					(Select a.dbtamt, a.crdamt From jrn a Left Join coa b On a.acccde = b.syscode
						Where b.acc_type = '6' and " . $where . "  and b.postable = 1) aa) ae,
				(Select Sum(ifnull(aa.dbtamt,0) - ifnull(aa.crdamt,0)) amt8 From 
					(Select a.dbtamt, a.crdamt From jrn a Left Join coa b On a.acccde = b.syscode
						Where b.acc_type = '8' and " . $where . "  and b.postable = 1) aa) af
				) ddd 
				Order By aaa.acccde";
		
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		//$sql=mysql_query($sqlstr);
				
		return $sql;
	}
	
	
	//---------get data CashFlow
	function rpt_cashflow($date_from = '', $date_to = '', $acc_code1 = '', $acc_code2 = '', $all = 0){
		$dbpdo = DB::create();
			 	
		$where = "";
		$where1 = "";
		$where2 = "";
		
		if ($date_from != '') {
			$date_from = date('Y-m-d', strtotime($date_from));
			if($where == '') { $where = "  where b.ividte < '$date_from' "; } else { $where = $where . " and b.ividte < '$date_from' "; } 
		}
		
		
		if ($date_from != '' && $date_to != '') {
			$date_from = date('Y-m-d', strtotime($date_from));
			$date_to = date('Y-m-d', strtotime($date_to));
			if($where1 == '') { $where1 = "  where a.ividte >= '$date_from' and a.ividte <= '$date_to' "; } 
			else { $where1 = $where1 . " and a.ividte >= '$date_from' and a.ividte <= '$date_to' "; } 
		}
				
		if ( $acc_code1 != "") {
			if ($where2 == "") {
				$where2 = " where a.acc_code >= '$acc_code1' ";
			} else {
				$where2 = $where2 . " and a.acc_code >= '$acc_code1' ";
			}								
		}
		
		if ( $acc_code2 != "") {
			if ($where2 == "") {
				$where2 = " where a.acc_code <= '$acc_code2' ";
			} else {
				$where2 = $where2 . " and a.acc_code <= '$acc_code2' ";
			}								
		}
		
		if($all != '' && $all != 0) {
			$where = "";
			$where1 = "";
			$where2 = "";
		}
		
		if ($_SESSION["adm"] == 0) {
			$location_id2 = $_SESSION["location_id2"];
			
			if($where1 == '') {
				$where1 = " where d.location_id = '$location_id2' ";
			} else {
				$where1 = $where1 . " and d.location_id = '$location_id2' ";	
			}
						
			$sqlstr = "Select a.acc_type, a.acc_code, a.name, a.ivino, a.ivitpe, a.ividte, a.dcr,
						a.dbtamt, a.crdamt, a.opening_balance From
					(
						
					Select b.acc_type, a.acccde acc_code, b.name, a.ivino, a.ivitpe, a.ividte, a.dcr, 
						a.dbtamt, a.crdamt, 0 opening_balance, a.lne, d.location_id
						From jrn a left join coa b on a.acccde = b.syscode
						left join usr c on a.uid=c.usrid left join employee d on c.employee_id=d.id
						" . $where1 . "
					) a
					" . $where2 . "
					Order By a.ividte, a.ivino, a.lne, a.location_id";
					
		} else {
			$sqlstr = "Select a.acc_type, a.acc_code, a.name, a.ivino, a.ivitpe, a.ividte, a.dcr,
						a.dbtamt, a.crdamt, a.opening_balance From
					(
						
					Select b.acc_type, a.acccde acc_code, b.name, a.ivino, a.ivitpe, a.ividte, a.dcr, 
						a.dbtamt, a.crdamt, 0 opening_balance, a.lne
						From jrn a left join coa b on a.acccde = b.syscode
						" . $where1 . "
					) a
					" . $where2 . "
					Order By a.ividte, a.ivino, a.lne";
		}
		
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		//$sql=mysql_query($sqlstr);

		
		return $sql;
	}
	
	
	//---------get data bincard vendor
	function rpt_bincard_vendor($item_code = '', $location_id = '', $uom_code = '', $date_from='', $date_to='', $all = 0, $vendor_code=''){	 	
		$dbpdo = DB::create();
		
		$where = " where ifnull(b.name,'') <> '' "; //and left(a.invoice_type,8)='purchase' 
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
		
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
		
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		if ( $vendor_code != "") {
			
			if ($where == "") {
				$where = " where e.vendor_code = '$vendor_code' ";
			} else {
				$where = $where . " and e.vendor_code = '$vendor_code' ";
			}								
		}
		
		if($all != 0 && $all != "") {
			$where = " where ifnull(b.name,'') <> '' ";
		}
		
		$sqlstr="select a.invoice_no, a.date, a.invoice_type, a.description, a.uom_code, a.debit_qty, a.credit_qty, b.name item_name, c.name location_name from bincard a left join item b on a.item_code=b.syscode left join warehouse c on a.location_code=c.id inner join purchase_invoice_detail d on a.invoice_no=d.ref and a.item_code=d.item_code and a.uom_code=d.uom_code and a.line=d.line left join purchase_invoice e on d.ref=e.ref " . $where . " order by a.date, a.dlu";

		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data ietm form bincard vendor
	function rpt_bincard_vendor_item($item_code='', $location_id='', $uom_code='', $all = 0){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(b.name,'') <> '' ";
		
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
		}
		
		$sqlstr="select distinct a.uom_code, a.item_code, b.code, b.name item_name from bincard a left join item b on a.item_code=b.syscode " . $where . " order by b.name";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data opnblc item form bincard
	function rpt_bincard_vendor_openblc_item($item_code='', $uom_code='', $date='', $all = 0){
		$dbpdo = DB::create();	
		
		$where = "";
		
		if ( $date != "") {
			
			$date = date("Y-m-d", strtotime($date));
			
			if ($where == "") {
				$where = " where a.date < '$date' ";
			} else {
				$where = $where . " and a.date < '$date' ";
			}								
		}
				
		if($all != 0) {
			$date = date("Y-m-d");
			
			$where = " where a.date < '$date' ";
		}
		
		
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		$sqlstr="select sum(a.debit_qty) - sum(a.credit_qty) opnblc from bincard a left join item b on a.item_code=b.syscode " . $where . " group by a.item_code, a.uom_code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data purchase quick
	function list_purchase_quick($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.invoice_no, a.date, a.status, a.bill_number, a.vendor_code, a.top, a.due_date, a.currency_code, a.rate, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.opening_balance, a.total, a.memo, a.location_id, a.cash, a.uid, a.dlu, b.name vendor_name, b.address from purchase_invoice a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		return $sql;
	}
	
	
	//----------list_purchase_quick_detail
	function list_purchase_quick_detail($id='', $posisi=0, $batas=0) {
		$dbpdo = DB::create();
		
		if($batas > 0) {
			$limit = " limit $posisi, $batas";
		}
				
		$sqlstr="select a.ref, a.po_ref, a.item_code, a.uom_code, b.code, b.old_code, b.name item_name, a.qty, a.unit_cost, a.discount, a.discount1, a.amount, a.qty_rtn, a.line_item_po, a.line from purchase_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line desc " . $limit ;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data cash Receipt
	function list_cash_receipt($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.contact_type, a.contact_code, a.contact_name, a.receipt_type, a.cheque_no, a.cheque_date, a.bank_name, a.credit_card_no, a.credit_card_code, a.credit_card_holder, a.credit_card_expired, a.account_code, a.currency_code, a.rate, a.amount, a.deposit, a.sub_total, a.type, a.memo, a.opening_balance, a.total, a.uid, a.dlu from cash_receipt a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		return $sql;
	}
	
	
	//----------list_cash_receipt_detail
	function list_cash_receipt_detail($id='', $posisi=0, $batas=0) {
		$dbpdo = DB::create();
		
		if($batas > 0) {
			$limit = " limit $posisi, $batas";
		}
				
		$sqlstr="select a.ref, a.account_code, a.currency_code, a.rate, a.debit_amount, a.credit_amount, a.memo, a.line, b.name account_name from cash_receipt_detail a left join coa b on a.account_code=b.syscode where a.ref='$id' order by a.line " . $limit ;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data cash Payment
	function list_cash_payment($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.contact_type, a.contact_code, a.contact_name, a.payment_type, a.cheque_no, a.cheque_date, a.bank_name, a.credit_card_no, a.credit_card_code, a.credit_card_holder, a.credit_card_expired, a.account_code, a.currency_code, a.rate, a.amount, a.deposit, a.sub_total, a.type, a.memo, a.opening_balance, a.total, a.uid, a.dlu from cash_payment a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		return $sql;
	}
	
	
	//----------list_cash_payment_detail
	function list_cash_payment_detail($id='', $posisi=0, $batas=0) {
		$dbpdo = DB::create();
		
		if($batas > 0) {
			$limit = " limit $posisi, $batas";
		}
				
		$sqlstr="select a.ref, a.account_code, a.currency_code, a.rate, a.debit_amount, a.credit_amount, a.memo, a.line from cash_payment_detail a where a.ref='$id' order by a.line " . $limit;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data Direct Receipt
	function list_direct_receipt($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.contact_type, a.contact_code, a.contact_name, a.receipt_type, a.cheque_no, a.cheque_date, a.bank_name, a.credit_card_no, a.credit_card_code, a.credit_card_holder, a.credit_card_expired, a.account_code, a.currency_code, a.rate, a.amount, a.deposit, a.sub_total, a.type, a.memo, a.opening_balance, a.installment, a.loan, a.total, a.ar, a.uid, a.dlu from direct_receipt a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		return $sql;
	}
	
	
	//----------list_direct_receipt_detail
	function list_direct_receipt_detail($id='', $posisi=0, $batas=0) {
		$dbpdo = DB::create();
		
		if($batas > 0) {
			$limit = " limit $posisi, $batas";
		}
				
		$sqlstr="select a.ref, a.account_code, a.currency_code, a.rate, a.debit_amount, a.credit_amount, a.memo, a.line from direct_receipt_detail a where a.ref='$id' order by a.line " . $limit ;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data direct Payment
	function list_direct_payment($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.contact_type, a.contact_code, a.contact_name, a.payment_type, a.cheque_no, a.cheque_date, a.bank_name, a.credit_card_no, a.credit_card_code, a.credit_card_holder, a.credit_card_expired, a.account_code, a.currency_code, a.rate, a.amount, a.deposit, a.sub_total, a.type, a.memo, a.opening_balance, a.total, a.ap, a.uid, a.dlu from direct_payment a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		return $sql;
	}
	
	
	//----------list_direct_payment_detail
	function list_direct_payment_detail($id='', $posisi=0, $batas=0) {
		$dbpdo = DB::create();
		
		if($batas > 0) {
			$limit = " limit $posisi, $batas";
		}
				
		$sqlstr="select a.ref, a.account_code, a.currency_code, a.rate, a.debit_amount, a.credit_amount, a.memo, a.line from direct_payment_detail a where a.ref='$id' order by a.line " . $limit ;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data Receipt
	function list_receipt($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.client_code, a.receipt_type, a.cheque_no, a.cheque_date, a.bank_name, a.credit_card_no, a.credit_card_code, a.credit_card_holder, a.credit_card_expired, a.account_code, a.currency_code, a.rate, a.amount, a.deposit, a.sub_total, a.type, a.memo, a.round_amount, a.round_amount_account, a.bank_charge, a.bank_charge_account, a.opening_balance, a.total, a.uid, a.dlu, b.name contact_name, b.address, b.phone from receipt a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		return $sql;
	}
	
	
	//----------list_direct_receipt_detail
	function list_receipt_detail($id='', $posisi=0, $batas=0) {
		$dbpdo = DB::create();
		
		if($batas > 0) {
			$limit = " limit $posisi, $batas";
		}
				
		$sqlstr="select a.ref, a.invoice_no, a.invoice_date, a.invoice_due_date, a.invoice_currency_code, a.invoice_rate, a.amount_due, a.discount, a.amount_paid, a.ref_type invoice_type, a.amount, a.line from receipt_detail a where a.ref='$id' order by a.line " . $limit ;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data Payment
	function list_payment($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.vendor_code, a.payment_type, a.cheque_no, a.cheque_date, a.bank_name, a.credit_card_no, a.credit_card_code, a.credit_card_holder, a.credit_card_expired, a.account_code, a.currency_code, a.rate, a.amount, a.deposit, a.sub_total, a.type, a.memo, a.round_amount, a.round_amount_account, a.bank_charge, a.bank_charge_account, a.opening_balance, a.total, a.no_ttfa, a.uid, a.dlu, b.name contact_name, b.address, b.phone from payment a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		return $sql;
	}
	
	
	//----------list_payment_detail
	function list_payment_detail($id='', $posisi=0, $batas=0) {
		$dbpdo = DB::create();
		
		if($batas > 0) {
			$limit = " limit $posisi, $batas";
		}
				
		$sqlstr="select a.ref, a.invoice_no, b.invoice_no no_nota, a.invoice_date, a.invoice_due_date, a.invoice_currency_code, a.invoice_rate, a.amount_due, a.discount, a.amount_paid, a.ref_type invoice_type, a.amount, a.line from payment_detail a left join purchase_invoice b on a.invoice_no=b.ref where a.ref='$id' order by a.line " . $limit ;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
    
    //---------get data asset trans
	function list_asset_trans($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.tanggal, a.asset_id, b.asset_name, a.penyewa, a.lama_sewa, a.akhir_sewa, a.harga_sewa, a.alamat, a.hp, a.uid, a.dlu from asset_trans a left join asset b on a.asset_id=b.ref " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
    
    
    //---------get data item
	function list_cashier_item_get_price($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where a.active=1 ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
        $sqlstr="select a.syscode, a.code, a.old_code, a.name, a.uom_code_stock, a.uom_code_sales, a.uom_code_purchase, (select current_price from set_item_price where item_code=a.syscode and uom_code=a.uom_code_sales order by date_of_record desc limit 1) current_price from item a " . $where . " order by a.code";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
    
    
    //---------get data item history
	function list_cashier_item_history($client_code=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $client_code != "") {
			if ($where == "") {
				$where = " having a.client_code = '$client_code' ";
			} else {
				$where = $where . " and a.client_code = '$client_code' ";
			}								
		}
		
        $sqlstr = "select b.uom_code, sum(b.qty) qty, sum(b.qty) * sum(b.unit_price) amount, c.code, c.name item_name from sales_invoice a left join sales_invoice_detail b on a.ref=b.ref left join item c on b.item_code=c.syscode group by a.client_code, b.item_code " . $where . " order by sum(b.qty) desc";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
        //$sql=mysql_query($strquery);
		
		return $sql;
	}
	
	
	//---------get data cheque history
	function list_cashier_cheque_history($client_code=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $client_code != "") {
			if ($where == "") {
				$where = " where a.client_code = '$client_code' ";
			} else {
				$where = $where . " and a.client_code = '$client_code' ";
			}								
		}
		
        $sqlstr = "select a.ref, a.date, a.cheque_no, a.bank_name, a.cheque_date, a.amount, a.void, a.void_date from arc a " . $where . " order by a.date desc";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
        //$sql=mysql_query($strquery);
		
		return $sql;
	}
	
	
	//=======================
	//---------get data item
	function list_pos_item_get_price($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where a.active=1 ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
        $sqlstr="select a.syscode, a.code, a.old_code, a.name, a.uom_code_stock, a.uom_code_sales, a.uom_code_purchase, (select current_price from set_item_price where item_code=a.syscode and uom_code=a.uom_code_sales order by date_of_record desc limit 1) current_price from item a " . $where . " order by a.code";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
    
    
    //---------get data item history
	function list_pos_item_history($client_code=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $client_code != "") {
			if ($where == "") {
				$where = " having a.client_code = '$client_code' ";
			} else {
				$where = $where . " and a.client_code = '$client_code' ";
			}								
		}
		
        $sqlstr = "select b.uom_code, sum(b.qty) qty, sum(b.qty) * sum(b.unit_price) amount, c.code, c.name item_name from sales_invoice a left join sales_invoice_detail b on a.ref=b.ref left join item c on b.item_code=c.syscode group by a.client_code, b.item_code " . $where . " order by sum(b.qty) desc";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
        //$sql=mysql_query($strquery);
		
		return $sql;
	}
	
	
	//---------get data cheque history
	function list_pos_cheque_history($client_code=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $client_code != "") {
			if ($where == "") {
				$where = " where a.client_code = '$client_code' ";
			} else {
				$where = $where . " and a.client_code = '$client_code' ";
			}								
		}
		
        $sqlstr = "select a.ref, a.date, a.cheque_no, a.bank_name, a.cheque_date, a.amount, a.void, a.void_date from arc a " . $where . " order by a.date desc";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
        //$sql=mysql_query($strquery);
		
		return $sql;
	}
	
	
	##purchase sahabat only
	//---------get data item
	function list_purchase_inv_item_get_cost($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where a.active=1 ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
        $sqlstr="select a.syscode, a.code, a.old_code, a.name, a.uom_code_stock, a.uom_code_sales, a.uom_code_purchase, (select current_cost from set_item_cost where item_code=a.syscode and uom_code=a.uom_code_sales order by date_of_record desc limit 1) current_cost from item a " . $where . " order by a.code";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get data purchase invoice consign
	function list_purchase_inv_consign($kode='', $from_date='', $to_date='', $vendor_code='', $all=0){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.payment_type = 'consign' ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		
		if ( $vendor_code != "") {
			if ($where == "") {
				$where = " where a.vendor_code = '$vendor_code' ";
			} else {
				$where = $where . " and a.vendor_code = '$vendor_code' ";
			}								
		}
		
		if($all == 1) {
			$where = " where ifnull(a.opening_balance,0) = 0 and a.payment_type = 'consign' ";
		}
		
		$sqlstr="select a.ref, a.invoice_no, a.date, a.status, a.bill_number, a.vendor_code, a.payment_type, b.name vendor_name, a.top, a.due_date, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.memo, a.discount, a.total, a.location_id, a.cash, a.cash_amount, a.change_amount, a.bank_id, a.bank_amount, a.credit_card_code, a.card_amount, a.credit_card_no, a.credit_card_holder, a.uid, a.dlu, (select sum(aa.amount) from purchase_invoice_detail aa group by aa.ref having aa.ref=a.ref) amount from purchase_invoice a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get data item
	function list_outbound_item_get($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where a.active=1 ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
        $sqlstr="select a.syscode, a.code, a.old_code, a.name, a.uom_code_stock, a.uom_code_sales, a.uom_code_stock from item a " . $where . " order by a.code";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get data stock
	function rpt_stock($item_code='', $location_id='', $uom_code='', $all = 0, $item_group_id='', $item_subgroup_id='', $date_from='', $date_to=''){	 	
		
		$dbpdo = DB::create();
		
		$where = " where ifnull(b.name,'') <> '' ";
		
        if ( $date_from != "") {
			
            $date_from = date("Y-m-d", strtotime($date_from));
            
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
        
        if ( $date_to != "") {
			
            $date_to = date("Y-m-d", strtotime($date_to));
            
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
        
        
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code'))  ";
			} else {
				$where = $where . " and (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			}								
		}
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		
		if ( $item_group_id != "") {
			
			if ($where == "") {
				$where = " where b.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and b.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			
			if ($where == "") {
				$where = " where b.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and b.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		
		##get date stock opname terakhir
        /*if($location_id == "" || $location_id != "0") {
            $sqlstring		= "select date from bincard where invoice_type='stockopname' and item_code='$item_code' and uom_code='$uom_code' order by date desc limit 1";
        } else {
            $sqlstring		= "select date from bincard where invoice_type='stockopname' and location_code='$location_id' and item_code='$item_code' and uom_code='$uom_code' order by date desc limit 1";
        }
		
        //echo $sqlstring."<br>";
		$sqlstock		= mysql_query($sqlstring);
		$datadate		= mysql_fetch_object($sqlstock);
		$datebincard 	= $datadate->date;
		
		if ( $datebincard != "") {
			$datebincard = date("Y-m-d", strtotime($datebincard));
			if ($where == "") {
				$where = " where a.date >= '$datebincard' ";
			} else {
				$where = $where . " and a.date >= '$datebincard' ";
			}	
            
            if ( $date_from != "") {
			
    			$date_to = date("Y-m-d", strtotime($date_from));
    			
    			if ($where == "") {
    				$where = " where a.date < '$date_from' ";
    			} else {
    				$where = $where . " and a.date < '$date_from' ";
    			}								
    		}
            
		} else {
            if ( $date_from != "") {
                $date_from = date("Y-m-d", strtotime($date_from));
        			
        		if ($where == "") {
        			$where = " where a.date < '$date_from' ";
        		} else {
        			$where = $where . " and a.date < '$date_from' ";
        		}
            } else {
                
                $date_from = date("Y-m-d");
        			
        		if ($where == "") {
        			$where = " where a.date < '$date_from' ";
        		} else {
        			$where = $where . " and a.date < '$date_from' ";
        		}
                
            }
        }*/
		##-----------------
		
		/*##get date stock opname terakhir
		if($location_id == "") {
            $sqlstring		= "select date from bincard where invoice_type='stockopname' and item_code='$item_code' and uom_code='$uom_code' order by date desc limit 1";
        } else {
            $sqlstring		= "select date from bincard where invoice_type='stockopname' and location_code='$location_id' and item_code='$item_code' and uom_code='$uom_code' order by date desc limit 1";
        }
		
        //echo $sqlstring."<br>";
		$sqlstock		= mysql_query($sqlstring);
		$datadate		= mysql_fetch_object($sqlstock);
		$datebincard 	= $datadate->date;
		
		if ( $datebincard != "") {
			$datebincard = date("Y-m-d", strtotime($datebincard));
			if ($where == "") {
				$where = " where a.date >= '$datebincard' ";
			} else {
				$where = $where . " and a.date >= '$datebincard' ";
			}	
            
            if ( $date_from != "") {
			
    			$date_from = date("Y-m-d", strtotime($date_from));
    			
    			if ($where == "") {
    				$where = " where a.date < '$date_from' ";
    			} else {
    				$where = $where . " and a.date < '$date_from' ";
    			}								
    		}
            
		} else {
            if ( $date_from != "") {
			
    			$date_from = date("Y-m-d", strtotime($date_from));
    			
    			if ($where == "") {
    				$where = " where a.date < '$date_from' ";
    			} else {
    				$where = $where . " and a.date < '$date_from' ";
    			}								
    		}
        }
		##-----------------
        */
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
		}
		
		
        $sqlstr="select a.item_code, b.code, b.name, a.uom_code, a.location_code, c.name location_name, b.item_group_id, b.item_subgroup_id, sum(ifnull(a.debit_qty,0)) debit_qty, sum(ifnull(a.credit_qty,0)) credit_qty, sum(ifnull(a.debit_qty,0)) - sum(ifnull(a.credit_qty,0)) qty from bincard a left join item b on a.item_code=b.syscode left join warehouse c on a.location_code=c.id " . $where . " group by a.item_code, a.uom_code, a.location_code, b.item_group_id, b.item_subgroup_id, b.name, b.old_code, b.code having sum(ifnull(a.debit_qty,0)) - sum(ifnull(a.credit_qty,0)) <> 0 order by b.name";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
		
	}
	
	
	//---------get data item
	function list_item($item_code='', $uom_code='', $item_group_id='', $item_subgroup_id='', $all='', $item_code2=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.syscode = '$item_code' ";
			} else {
				$where = $where . " and a.syscode = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where a.uom_code_sales = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code_sales = '$uom_code' ";
			}								
		}
		
		if ( $item_group_id != "") {
			if ($where == "") {
				$where = " where a.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and a.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			if ($where == "") {
				$where = " where a.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and a.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		if ( $item_code2 != "") {
			if ($where == "") {
				$where = " where (a.code = '$item_code2' or a.old_code = '$item_code2') ";
			} else {
				$where = $where . " and (a.code = '$item_code2' or a.old_code = '$item_code2') ";
			}								
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.code, a.old_code, a.name, a.item_group_id, b.name item_group_name, a.item_subgroup_id, a.item_type_code, a.item_category_id, a.brand_id, a.size_id, a.uom_code_stock, a.uom_code_sales, a.uom_code_purchase, a.minimum_stock, a.maximum_stock, a.photo, a.consigned, a.active, a.uid, a.dlu, a.syscode from item a left join item_group b on a.item_group_id=b.id " . $where . " order by a.code";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	
	//---------get data item cek barcode
	function list_item_check_barcode($item_code='', $name=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where (a.code = '$item_code' or a.old_code = '$item_code') ";
			} else {
				$where = $where . " and (a.code = '$item_code' or a.old_code = '$item_code') ";
			}								
		}
		
		if ( $name != "") {
			if ($where == "") {
				$where = " where a.name like '%$name%' ";
			} else {
				$where = $where . " and a.name like '%$name%' ";
			}								
		}
		
		if($item_code=='' && $name=='') {
			$where = " where a.syscode='ndf'";
		}
		
		$sqlstr="select a.code, a.old_code, a.name, a.item_group_id, b.name item_group_name, a.item_subgroup_id, a.item_type_code, a.item_category_id, a.brand_id, a.size_id, a.uom_code_stock, a.uom_code_sales, a.uom_code_purchase, a.minimum_stock, a.maximum_stock, a.photo, a.consigned, a.active, a.uid, a.dlu, a.syscode from item a left join item_group b on a.item_group_id=b.id " . $where . " order by a.code";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get data item
	function list_item_cetak_label($item_code4=''){
		$dbpdo = DB::create();
		
		
		$sqlstr="select a.code, a.old_code, a.name, a.item_group_id, b.name item_group_name, a.item_subgroup_id, a.item_type_code, a.item_category_id, a.brand_id, a.size_id, a.uom_code_stock, a.uom_code_sales, a.uom_code_purchase, a.minimum_stock, a.maximum_stock, a.photo, a.consigned, a.active, a.uid, a.dlu, a.syscode from item a left join item_group b on a.item_group_id=b.id where a.syscode in (".$item_code4.") order by a.code";
		//echo $sqlstr."<br>";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get data item label
	function list_item_label($item_code='', $uom_code='', $item_group_id='', $item_subgroup_id='', $all='', $item_code2='', $date_from='', $date_to=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.syscode = '$item_code' ";
			} else {
				$where = $where . " and a.syscode = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where a.uom_code_sales = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code_sales = '$uom_code' ";
			}								
		}
		
		if ( $item_group_id != "") {
			if ($where == "") {
				$where = " where a.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and a.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			if ($where == "") {
				$where = " where a.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and a.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		if ( $item_code2 != "") {
			if ($where == "") {
				$where = " where (a.code = '$item_code2' or a.old_code = '$item_code2') ";
			} else {
				$where = $where . " and (a.code = '$item_code2' or a.old_code = '$item_code2') ";
			}								
		}
		
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where date_format(a.dlu, '%Y-%m-%d') >= '$date_from' ";
			} else {
				$where = $where . " and date_format(a.dlu, '%Y-%m-%d') >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where date_format(a.dlu, '%Y-%m-%d') <= '$date_to' ";
			} else {
				$where = $where . " and date_format(a.dlu, '%Y-%m-%d') <= '$date_to' ";
			}								
		}
		
		if($item_code=='' && $uom_code=='' && $item_group_id=='' && $item_subgroup_id=='' && $all=='' && $item_code2=='' && $date_from=='' && $date_to=='') {
			$where = " where a.code = '' ";		
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.code, a.old_code, a.name, a.item_group_id, b.name item_group_name, a.item_subgroup_id, a.item_type_code, a.item_category_id, a.brand_id, a.size_id, a.uom_code_stock, a.uom_code_sales, a.uom_code_purchase, a.minimum_stock, a.maximum_stock, a.photo, a.consigned, a.active, a.uid, a.dlu, a.syscode from item a left join item_group b on a.item_group_id=b.id " . $where . " order by a.code";
		
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data purchase invoice last unit cost
	function list_purchase_invoice_last_cost($item_code='', $uom_code=''){
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		$sqlstr="select a.ref, b.date, a.item_code, a.uom_code, a.qty, ifnull(a.unit_cost,0) unit_cost, a.amount, a.line_item_po, a.line, b.dlu from purchase_invoice_detail a left join purchase_invoice b on a.ref=b.ref " . $where . " order by b.dlu desc, a.line desc limit 1 ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();			
		$data = $sql->fetch(PDO::FETCH_OBJ);
		$current_cost = $data->unit_cost;
		
		if($current_cost == 0) {
			$sqlstr = "select ifnull(a.current_cost,0) current_cost from set_item_cost a " . $where . " order by a.date_of_record desc limit 1";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$current_cost = $data->current_cost;
		}
		
		
		return $current_cost;
	}
	
	
	//---------get data last unit price 
	function list_price_last($item_code='', $uom_code=''){
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		$sqlstr = "select ifnull(a.current_price1,0) current_price1 from set_item_price a " . $where . " order by a.date_of_record desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data = $sql->fetch(PDO::FETCH_OBJ);
		$current_price1 = $data->current_price1;
				
		
		return $current_price1;
	}
	
	
	//---------get data stock
	function rpt_stock_harga($item_code='', $location_id='', $uom_code='', $all = 0, $item_group_id='', $item_subgroup_id='', $date_from='', $date_to=''){	 	
		
		$dbpdo = DB::create();
		
		$where = " where ifnull(b.name,'') <> '' ";
		
        if ( $date_from != "") {
			
            $date_from = date("Y-m-d", strtotime($date_from));
            
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
        
        if ( $date_to != "") {
			
            $date_to = date("Y-m-d", strtotime($date_to));
            
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
        
        
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		
		if ( $item_group_id != "") {
			
			if ($where == "") {
				$where = " where b.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and b.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			
			if ($where == "") {
				$where = " where b.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and b.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
		}
		
		
        $sqlstr="select a.item_code, b.code, b.name, a.uom_code, a.location_code, c.name location_name, sum(ifnull(a.debit_qty,0)) debit_qty, sum(ifnull(a.credit_qty,0)) credit_qty, sum(ifnull(a.debit_qty,0)) - sum(ifnull(a.credit_qty,0)) qty from bincard a left join item b on a.item_code=b.syscode left join warehouse c on a.location_code=c.id " . $where . " group by a.item_code, a.uom_code, a.location_code, b.item_group_id, b.item_subgroup_id, b.name having sum(ifnull(a.debit_qty,0)) - sum(ifnull(a.credit_qty,0)) <> 0 order by b.name";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
		
	}
	
	
	//---------get data last unit price 
	function list_price_last2($item_code='', $uom_code=''){
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		$sqlstr = "select a.date_of_record, ifnull(a.current_price,0) current_price, ifnull(a.current_price1,0) current_price1, ifnull(a.current_price2,0) current_price2, ifnull(a.qty1,0) qty1, ifnull(a.qty2,0) qty2, ifnull(a.qty3,0) qty3 from set_item_price a " . $where . " order by a.date_of_record desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		
		return $sql;
	}
	
	
	//---------get data sales global
	function list_sales_invoice_global($from_date='', $to_date='', $location_id='', $all=0, $cashier=''){	 
		$dbpdo = DB::create();
			
		$where = "";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
				
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
		
		if ( $cashier != "") {
			if ($where == "") {
				$where = " where a.uid = '$cashier' ";
			} else {
				$where = $where . " and a.uid = '$cashier' ";
			}								
		}
		
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.date, b.name location_name, a.uid, sum(a.total) total from sales_invoice a left join warehouse b on a.location_id=b.id " . $where . " group by a.date, b.name, a.uid order by a.date";
		
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data modal
	function list_modal_global($date='', $location_id=''){	 
		$dbpdo = DB::create();
			
		$where = "";
		
		if ( $date != "") {
			
			$date = date("Y-m-d", strtotime($date));
			
			if ($where == "") {
				$where = " where a.date = '$date' ";
			} else {
				$where = $where . " and a.date = '$date' ";
			}								
		}
		
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where b.location_id = '$location_id' ";
			} else {
				$where = $where . " and b.location_id = '$location_id' ";
			}								
		}
		
		
		$sqlstr="select a.date, sum(a.total) modal, b.location_id from cash_receipt a left join employee b on a.contact_code=b.id left join warehouse c on b.location_id=c.id  " . $where . " group by a.date, b.location_id order by a.date";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$modal=$data->modal;

		
		return $modal;
	}
	
	
	//---------get data stock opname
	function rpt_stock_opname($from_date='', $to_date='', $location_id='', $all=0){	 
		$dbpdo = DB::create();
			
		$where = "";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
				
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where b.location_id = '$location_id' ";
			} else {
				$where = $where . " and b.location_id = '$location_id' ";
			}								
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.date, d.code, d.old_code barcode, d.name item_name, b.qty, b.unit_cost, b.item_code, b.uom_code from stock_opname a left join stock_opname_detail b on a.syscode=b.syscode left join warehouse c on b.location_id=c.id left join item d on b.item_code=d.syscode  " . $where . " order by d.name";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data supplier varian
	function rpt_varian_supplier($from_date='', $to_date='', $item_code='', $uom_code='', $item_group_id='', $item_subgroup_id='', $vendor_code='', $location_id='', $all=''){
		$dbpdo = DB::create();
		
		$where = " where ifnull(a.opening_balance,0) = 0 ";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		if ( $vendor_code != "") {
			if ($where == "") {
				$where = " where a.vendor_code = '$vendor_code' ";
			} else {
				$where = $where . " and a.vendor_code = '$vendor_code' ";
			}								
		}
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where c.item_code = '$item_code' ";
			} else {
				$where = $where . " and c.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where c.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and c.uom_code = '$uom_code' ";
			}								
		}
		
		if ( $item_group_id != "") {
			if ($where == "") {
				$where = " where d.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and d.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			if ($where == "") {
				$where = " where d.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and d.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		$sqlstr="select distinct a.ref, a.vendor_code, b.name vendor_name from purchase_invoice a left join vendor b on a.vendor_code=b.syscode left join purchase_invoice_detail c on a.ref=c.ref left join item d on c.item_code=d.syscode left join item_group e on d.item_group_id=e.id left join warehouse f on a.location_id=f.id " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
		
		
	}
	
	//---------get data varian
	function rpt_varian($from_date='', $to_date='', $item_code='', $uom_code='', $item_group_id='', $item_subgroup_id='', $vendor_code='', $location_id='', $all='', $ref=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 ";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		if ( $vendor_code != "") {
			if ($where == "") {
				$where = " where a.vendor_code = '$vendor_code' ";
			} else {
				$where = $where . " and a.vendor_code = '$vendor_code' ";
			}								
		}
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where c.item_code = '$item_code' ";
			} else {
				$where = $where . " and c.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where c.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and c.uom_code = '$uom_code' ";
			}								
		}
		
		if ( $item_group_id != "") {
			if ($where == "") {
				$where = " where d.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and d.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			if ($where == "") {
				$where = " where d.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and d.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		if ( $ref != "") {
			if ($where == "") {
				$where = " where a.ref = '$ref' ";
			} else {
				$where = $where . " and a.ref = '$ref' ";
			}								
		}
		
		$sqlstr="select a.date, a.status, a.bill_number, a.vendor_code, a.top, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.memo, a.uid, a.dlu, b.name vendor_name, b.address, b.phone, d.syscode, d.code, d.old_code, d.name item_name, c.uom_code, sum(c.qty) qty, (ifnull(c.unit_cost,0)-ifnull(c.discount,0)) + (ifnull(a.tax_rate,0) * ifnull(c.unit_cost,0))/100 unit_cost, e.name item_group_name, f.code loc_code  from purchase_invoice a left join vendor b on a.vendor_code=b.syscode left join purchase_invoice_detail c on a.ref=c.ref left join item d on c.item_code=d.syscode left join item_group e on d.item_group_id=e.id left join warehouse f on a.location_id=f.id " . $where . " group by a.ref, a.date, a.status, a.bill_number, a.vendor_code, a.top, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.memo, b.name, b.address, b.phone, d.code, d.old_code, d.syscode, d.name, c.uom_code, c.unit_cost, e.name, f.code order by d.name";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	
	//---------get data last qty unit price 
	function list_qty_price_last($item_code='', $uom_code=''){
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		$sqlstr = "select a.location_id, a.date, a.efective_from, a.current_price, a.current_price1, a.current_price2, a.qty1, a.qty2, a.qty3 from set_item_price a " . $where . " order by a.date_of_record desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		
		return $sql;
	}
	
	
	//---------get data harga beli sebelum
	function list_purchase_invoice_before_last_cost($item_code='', $uom_code='', $date=''){
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $date != "") {
			
			$date = date("Y-m-d", strtotime($date));
			
			if ($where == "") {
				$where = " where b.date < '$date' ";
			} else {
				$where = $where . " and b.date < '$date' ";
			}								
		}
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		
		$sqlstr="select a.ref, b.date, a.item_code, a.uom_code, a.qty, (ifnull(a.unit_cost,0)-ifnull(a.discount,0)) + (ifnull(b.tax_rate,0) * ifnull(a.unit_cost,0))/100 unit_cost, a.amount, a.line_item_po, a.line, b.dlu from purchase_invoice_detail a left join purchase_invoice b on a.ref=b.ref " . $where . " order by b.dlu desc, a.line desc limit 1 ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();			
		$data = $sql->fetch(PDO::FETCH_OBJ);
		$current_cost = $data->unit_cost;
		
		if($current_cost == 0) {
			$where = "";
			
			if ( $date != "") {
			
				$date = date("Y-m-d", strtotime($date));
				
				if ($where == "") {
					$where = " where a.date < '$date' ";
				} else {
					$where = $where . " and a.date < '$date' ";
				}								
			}
			
			if ( $item_code != "") {
				if ($where == "") {
					$where = " where a.item_code = '$item_code' ";
				} else {
					$where = $where . " and a.item_code = '$item_code' ";
				}								
			}
			
			if ( $uom_code != "") {
				if ($where == "") {
					$where = " where a.uom_code = '$uom_code' ";
				} else {
					$where = $where . " and a.uom_code = '$uom_code' ";
				}								
			}
			
			$sqlstr = "select ifnull(a.current_cost,0) current_cost from set_item_cost a " . $where . " order by a.date_of_record desc limit 1";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$current_cost = $data->current_cost;
		}
		
		
		return $current_cost;
	}
	
	
	//---------get data purchase invoice last discount
	function list_purchase_invoice_last_discount($item_code='', $uom_code=''){
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		$sqlstr="select a.item_code, a.uom_code, a.qty, a.unit_cost, a.discount1, a.discount, b.tax_rate from purchase_invoice_detail a left join purchase_invoice b on a.ref=b.ref " . $where . " order by b.dlu desc, a.line desc limit 1 ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();			
		
		return $sql;
	}
	
	
	//---------get data item get last code
	function list_item_last_code($item_group_id=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $item_group_id != "") {
			if ($where == "") {
				$where = " where a.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and a.item_group_id = '$item_group_id' ";
			}								
		}
		
		
		//maximum
		$sqlstr="select a.code, right(a.code,4) last_code from item a " . $where . " order by right(a.code,4) desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$max_code = $data->last_code;
		$rowsx = $sql->rowCount();
		
		$i=1;
		for($i=1; $i<=$max_code; $i++) {
			
			$alp_temp = $i;
			if (strlen($alp_temp)==4) { $alp_temp = ''.$alp_temp;}
			if (strlen($alp_temp)==3) { $alp_temp = '0'.$alp_temp;}
			if (strlen($alp_temp)==2) { $alp_temp = '00'.$alp_temp;}
			if (strlen($alp_temp)==1) { $alp_temp = '000'.$alp_temp;}
			
			//get code item group
			$sqlstr="select a.code from item_group a where id='$item_group_id' limit 1";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data1=$sql->fetch(PDO::FETCH_OBJ);
			$group_code = $data1->code;
			
			$code = $group_code.$alp_temp;
					
			//get code item
			$sqlstr="select a.code from item a where code='$code' limit 1";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data2=$sql->fetch(PDO::FETCH_OBJ);
			$rows=$sql->rowCount();
			if($rows == 0) {
				$code = $code; //.'nothing'.$data->code; 
				$last_code = $code; //$data->last_code;
				
				return $last_code;
			}
			
			
		}
		
		//get code item group
		$sqlstr="select a.code from item_group a where id='$item_group_id' limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data1=$sql->fetch(PDO::FETCH_OBJ);
		$group_code = $data1->code;
		
			
		$last_code = $code + 1; //$data->last_code;
		
		if(substr($group_code,0,1) <= 0) {
			
			$last_code = "0".$last_code;
		}
		
		if($rowsx == 0) {
			//get code item group
			$sqlstr="select a.code from item_group a where id='$item_group_id' limit 1";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data1=$sql->fetch(PDO::FETCH_OBJ);
			$group_code = $data1->code;
			
			$last_code = $group_code. "0001";
		}
		
		return $last_code;
	}
	
	
	//---------get data item limt 1
	function get_item($item_code=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where (a.syscode = trim('$item_code') or a.code = trim('$item_code') or a.old_code = trim('$item_code')) ";
			} else {
				$where = $where . " and (a.syscode = trim('$item_code') or a.code = trim('$item_code') or a.old_code = trim('$item_code')) ";
			}								
		}
		
		$sqlstr="select a.code, a.old_code, a.name item_name from item a " . $where . " order by a.code limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get data bincard (stock opname only)
	function rpt_bincard_stok_opname($item_code = '', $location_id = '', $uom_code = '', $date_from='', $all = 0){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(b.name,'') <> '' and a.invoice_type='stockopname' ";
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date = '$date_from' ";
			} else {
				$where = $where . " and a.date = '$date_from' ";
			}								
		}
		
		/*if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}*/
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
			
		}
		
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			} else {
				$where = $where . " and (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			}								
		}
		
		if ( $uom_code != "") {
		
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		$sqlstr="select sum(a.debit_qty) - sum(a.credit_qty) qty from bincard a left join item b on a.item_code=b.syscode left join warehouse c on a.location_code=c.id " . $where . " group by b.name, a.date, a.item_code, b.code, b.old_code, a.uom_code, a.invoice_type, a.location_code order by a.date, a.dlu asc";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data stock cek stok opname
	function rpt_check_stock_opname($item_code='', $location_id='', $uom_code='', $all = 0, $item_group_id='', $item_subgroup_id='', $date_from='', $date_to=''){	 	
		
		$dbpdo = DB::create();
		
		$where = " where ifnull(b.name,'') <> '' and (ifnull(a.debit_qty,0) - ifnull(a.credit_qty,0) <> 0) and a.invoice_type='stockopname'";
		
        if ( $date_from != "") {
			
            $date_from = date("Y-m-d", strtotime($date_from));
            
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
        
        if ( $date_to != "") {
			
            $date_to = date("Y-m-d", strtotime($date_to));
            
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
        
        
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code'))  ";
			} else {
				$where = $where . " and (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			}								
		}
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		
		if ( $item_group_id != "") {
			
			if ($where == "") {
				$where = " where b.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and b.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			
			if ($where == "") {
				$where = " where b.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and b.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
		}
		
		
        ##cek stok opname (jika ada maka query yg dipakai query ini)
        $sqlstr2="select a.date, a.item_code, b.code, b.name, a.uom_code, a.location_code, c.name location_name, ifnull(a.debit_qty,0) debit_qty, ifnull(a.credit_qty,0) credit_qty, ifnull(a.debit_qty,0) - ifnull(a.credit_qty,0) qty from bincard a left join item b on a.item_code=b.syscode left join warehouse c on a.location_code=c.id " . $where . " order by a.date desc, a.dlu desc limit 1";
        
		/*$sqlstr2="select a.item_code, b.code, b.name, a.uom_code, a.location_code, c.name location_name, sum(ifnull(a.debit_qty,0)) debit_qty, sum(ifnull(a.credit_qty,0)) credit_qty, sum(ifnull(a.debit_qty,0)) - sum(ifnull(a.credit_qty,0)) qty from bincard a left join item b on a.item_code=b.syscode left join warehouse c on a.location_code=c.id " . $where . " group by a.date, a.item_code, a.uom_code, a.location_code, b.item_group_id, b.item_subgroup_id, b.name, b.old_code, b.code, a.invoice_type having sum(ifnull(a.debit_qty,0)) - sum(ifnull(a.credit_qty,0)) <> 0 and a.invoice_type='stockopname' order by b.name";*/
		$sql=$dbpdo->prepare($sqlstr2);
		$sql->execute();
		##----------------/\--------------------
		
		
		return $sql;
		
	}
	
	
	//---------get data stock cek stok opname
	function rpt_non_stock_opname($item_code='', $location_id='', $uom_code='', $all = 0, $item_group_id='', $item_subgroup_id='', $date_from='', $date_to=''){	 	
		
		$dbpdo = DB::create();
		
		$where = " where ifnull(b.name,'') <> '' and (ifnull(a.debit_qty,0) - ifnull(a.credit_qty,0) <> 0) and a.invoice_type<>'stockopname'";
		
        if ( $date_from != "") {
			
            $date_from = date("Y-m-d", strtotime($date_from));
            
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
        
        if ( $date_to != "") {
			
            $date_to = date("Y-m-d", strtotime($date_to));
            
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
        
        
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code'))  ";
			} else {
				$where = $where . " and (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			}								
		}
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		
		if ( $item_group_id != "") {
			
			if ($where == "") {
				$where = " where b.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and b.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			
			if ($where == "") {
				$where = " where b.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and b.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
		}
		
		
        ##cek stok opname (jika ada maka query yg dipakai query ini)
        $sqlstr2="select a.item_code, b.code, b.name, a.uom_code, a.location_code, c.name location_name, ifnull(a.debit_qty,0) debit_qty, ifnull(a.credit_qty,0) credit_qty, ifnull(a.debit_qty,0) - ifnull(a.credit_qty,0) qty from bincard a left join item b on a.item_code=b.syscode left join warehouse c on a.location_code=c.id " . $where . " order by a.date desc, a.dlu desc limit 1";
        $sql=$dbpdo->prepare($sqlstr2);
		$sql->execute();
		##----------------/\--------------------
		
		
		return $sql;
		
	}
	
	
	//---------get data stock cek stok opname
	function rpt_stock_stock_opname_limit1($item_code='', $location_id='', $uom_code='', $all = 0, $item_group_id='', $item_subgroup_id='', $date_from='', $date_to='', $type=''){	 	
		
		$dbpdo = DB::create();
		
		if($type == "stockopname") {
			$where = " where ifnull(b.name,'') <> '' and a.invoice_type='stockopname' ";
		} else {
			$where = " where ifnull(b.name,'') <> ''";
		}
		
		
        if ( $date_from != "") {
			
            $date_from = date("Y-m-d", strtotime($date_from));
            
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
        
        if ( $date_to != "") {
			
            $date_to = date("Y-m-d", strtotime($date_to));
            
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
        
        
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code'))  ";
			} else {
				$where = $where . " and (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			}								
		}
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		
		if ( $item_group_id != "") {
			
			if ($where == "") {
				$where = " where b.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and b.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			
			if ($where == "") {
				$where = " where b.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and b.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
		}
		
		
        ##cek stok opname (jika ada maka query yg dipakai query ini)
		$sqlstr = "select a.invoice_type from bincard a left join item b on a.item_code=b.syscode ". $where ." order by a.date desc, a.dlu desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		
		return $sql;
		
	}
	
	
	//---------get data stock 
	function rpt_stock_non_so($item_code='', $location_id='', $uom_code='', $all = 0, $item_group_id='', $item_subgroup_id='', $date_from='', $date_to=''){	 	
		
		$dbpdo = DB::create();
		
		$where = " where ifnull(b.name,'') <> '' ";
		
        if ( $date_from != "") {
			
            $date_from = date("Y-m-d", strtotime($date_from));
            
			if ($where == "") {
				$where = " where a.date > '$date_from' ";
			} else {
				$where = $where . " and a.date > '$date_from' ";
			}								
		}
        
        if ( $date_to != "") {
			
            $date_to = date("Y-m-d", strtotime($date_to));
            
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
        
        
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code'))  ";
			} else {
				$where = $where . " and (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			}								
		}
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		
		if ( $item_group_id != "") {
			
			if ($where == "") {
				$where = " where b.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and b.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			
			if ($where == "") {
				$where = " where b.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and b.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
		}
		
		
        $sqlstr="select a.item_code, b.code, b.name, a.uom_code, a.location_code, c.name location_name, b.item_group_id, b.item_subgroup_id, sum(ifnull(a.debit_qty,0)) debit_qty, sum(ifnull(a.credit_qty,0)) credit_qty, sum(ifnull(a.debit_qty,0)) - sum(ifnull(a.credit_qty,0)) qty from bincard a left join item b on a.item_code=b.syscode left join warehouse c on a.location_code=c.id " . $where . " group by a.item_code, a.uom_code, a.location_code, b.item_group_id, b.item_subgroup_id, b.name, b.old_code, b.code having sum(ifnull(a.debit_qty,0)) - sum(ifnull(a.credit_qty,0)) <> 0 order by b.name";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
		
	}
	
	
	//---------get data outbound
	function list_outbound($kode ='', $from_date='', $to_date='', $all=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.reason, a.type, a.form_no, a.warehouse_id_from, a.warehouse_id_to, a.employee_id, a.employee_id2, a.uid, a.dlu, b.name from_location, c.name to_location, d.name employee_name, e.name employee_name2, (select sum(q.qty) from outbound_detail q group by q.ref having q.ref=a.ref) qty from outbound a left join warehouse b on a.warehouse_id_from=b.id left join warehouse c on a.warehouse_id_to=c.id left join employee d on a.employee_id=d.id left join employee e on a.employee_id2=e.id " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------outbound detail
	function list_outbound_detail($id, $item_group) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.qty, a.ref_pos, a.line, b.code item_code2, b.name item_name from outbound_detail a left join item b on a.item_code=b.syscode where a.ref='$id' and b.item_group_id='$item_group' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------outbound detail (item group)
	function list_outbound_detail_itemgroup($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select distinct b.item_group_id, c.name item_group from outbound_detail a left join item b on a.item_code=b.syscode left join item_group c on b.item_group_id=c.id where a.ref='$id' order by c.name ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------set decimal harga
	function item_decimal($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select ifnull(a.scala,0) scala from item a where a.syscode='$id' limit 1 ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$scala = $data->scala;
				
		return $scala;
	}
	
	
	//---------get data purchase return quick
	function list_purchase_return_quick($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.vendor_code, a.location_id, a.pi_ref, b.name vendor_name, b.address, b.phone, a.tax_code, a.tax_rate, a.currency_code, a.rate, a.total, a.memo, a.uid, a.dlu from purchase_return a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------sales purchase retun quick detail (saat update)
	function list_purchase_return_quick_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, b.code item_code2, b.name item_name, a.uom_code, a.qty, a.discount1, a.discount, a.unit_cost, a.amount, a.line_item_pi, a.line from purchase_return_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data purchase invoice
	function pl_purchase_invoice($from_date ='', $to_date =''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		$amount = 0;
		$sqlstr = "select b.item_code, b.uom_code, b.qty from sales_invoice_detail b left join sales_invoice a on b.ref=a.ref " . $where;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		while($data_sales=$sql->fetch(PDO::FETCH_OBJ)) {
			
			//cek unit cost purchase invoice
			$unit_cost = 0;
			$discount1 = 0;
			$tax_rate = 0;
			
			$sqlstr2 = "select b.unit_cost, ifnull(b.discount1,0) discount1, a.tax_rate from purchase_invoice_detail b left join purchase_invoice a on b.ref=a.ref where b.item_code='$data_sales->item_code' and b.uom_code='$data_sales->uom_code' and a.date >= '$from_date' and a.date <= '$to_date' order by a.dlu desc limit 1 ";
			$sql2=$dbpdo->prepare($sqlstr2);
			$sql2->execute();
			$data2=$sql2->fetch(PDO::FETCH_OBJ);
			$unit_cost=$data2->unit_cost;
			$discount1=($unit_cost * $data2->discount1)/100;
			$tax_rate=($unit_cost * $data2->tax_rate)/100;
			$unit_cost = ($unit_cost - $discount1) + $tax_rate;
			
			if($unit_cost == 0) {
				$sqlstr3="select a.current_cost from set_item_cost a where a.item_code='$data_sales->item_code' and a.uom_code='$data_sales->uom_code' and a.date >= '$from_date' and a.date <= '$to_date' order by a.date_of_record desc limit 1";
				$sql3=$dbpdo->prepare($sqlstr3);
				$sql3->execute();
				$data3=$sql3->fetch(PDO::FETCH_OBJ);
				$unit_cost=$data3->current_cost;
			}
			
			$amount = $amount + ($unit_cost * $data_sales->qty);
			
			
		}
		
		
		/*$sqlstr="select sum(a.total) amount from purchase_invoice a " . $where;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);*/
		//$amount=$data->amount;
		
		return $amount;
	}
	
	
	//---------get data sales invoice
	function pl_sales_invoice($from_date ='', $to_date =''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		$sqlstr="select sum(a.total) amount from sales_invoice a " . $where;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$amount=$data->amount;
		
		return $amount;
	}
	
	
	//---------get data purchase invoice return
	function pl_purchase_return($from_date ='', $to_date =''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		/*if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}*/
		
		
		$amount = 0;
		$sqlstr = "select b.item_code, b.uom_code, b.qty from sales_invoice_detail b left join sales_invoice a on b.ref=a.ref " . $where;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		while($data_sales=$sql->fetch(PDO::FETCH_OBJ)) {
			
			//cek unit cost purchase invoice
			$unit_cost = 0;
			$discount1 = 0;
			$tax_rate = 0;
			
			$sqlstr2 = "select b.unit_cost, ifnull(b.discount1,0) discount1, a.tax_rate from purchase_return_detail b left join purchase_return a on b.ref=a.ref where b.item_code='$data_sales->item_code' and b.uom_code='$data_sales->uom_code' and a.date >= '$from_date' and a.date <= '$to_date' order by a.dlu desc limit 1 ";
			$sql2=$dbpdo->prepare($sqlstr2);
			$sql2->execute();
			$data2=$sql2->fetch(PDO::FETCH_OBJ);
			$unit_cost=$data2->unit_cost;
			$discount1=($unit_cost * $data2->discount1)/100;
			$tax_rate=($unit_cost * $data2->tax_rate)/100;
			$unit_cost = ($unit_cost - $discount1) + $tax_rate;
			
						
			$amount = $amount + ($unit_cost * $data_sales->qty);
			
			
		}
		
		/*$sqlstr="select sum(a.total) amount from purchase_return a " . $where;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$amount=$data->amount;*/
		
		return $amount;
	}
	
	
	//----------Report AP Card saldo awal
	function rpt_ap_card_opening_balance($date_from = '', $vendor_code='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date < '$date_from' ";
			} else {
				$where = $where . " and a.date < '$date_from' ";
			}								
		}
				
		if ( $vendor_code != "") {
			
			if ($where == "") {
				$where = " where a.contact_code = '$vendor_code' ";
			} else {
				$where = $where . " and a.contact_code = '$vendor_code' ";
			}								
		}
		
		
		$sqlstr="select sum(a.credit_amount) - sum(a.debit_amount) saldo_awal from ap a " . $where . "group by a.contact_code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//----------Report AP Card
	function rpt_ap_card($date_from = '', $date_to = '', $vendor_code='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $date_from != "") {
			
			$date_from = date("Y-m-d", strtotime($date_from));
			
			if ($where == "") {
				$where = " where a.date >= '$date_from' ";
			} else {
				$where = $where . " and a.date >= '$date_from' ";
			}								
		}
		
		if ( $date_to != "") {
			
			$date_to = date("Y-m-d", strtotime($date_to));
			
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
		
		if ( $vendor_code != "") {
			
			if ($where == "") {
				$where = " where a.contact_code = '$vendor_code' ";
			} else {
				$where = $where . " and a.contact_code = '$vendor_code' ";
			}								
		}
		
		
		$sqlstr="select a.ref, a.date, a.contact_code, b.name vendor_name, a.invoice_type, sum(a.debit_amount) debit_amount, sum(a.credit_amount) credit_amount from ap a left join vendor b on a.contact_code=b.syscode " . $where . " group by a.ref, a.date, a.contact_code, b.name, a.invoice_type order by a.date ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data stock opname value
	function rpt_stock_opname_value($item_code='', $from_date='', $to_date='', $location_id='', $all=0){	 
		$dbpdo = DB::create();
			
		$where = "";
		
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where (d.code = '$item_code' or d.old_code = '$item_code') ";
			} else {
				$where = $where . " and (d.code = '$item_code' or d.old_code = '$item_code') ";
			}								
		}
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <= '$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
				
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where b.location_id = '$location_id' ";
			} else {
				$where = $where . " and b.location_id = '$location_id' ";
			}								
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.date, d.code, d.old_code barcode, d.name item_name, b.qty, b.unit_cost, b.item_code, b.uom_code, b.item_code syscode from stock_opname a left join stock_opname_detail b on a.syscode=b.syscode left join warehouse c on b.location_id=c.id left join item d on b.item_code=d.syscode  " . $where . " order by d.name";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------get data stock SO VALUE 
	function rpt_stock_non_so_value($item_code='', $location_id='', $uom_code='', $all = 0, $item_group_id='', $item_subgroup_id='', $date_from='', $date_to=''){	 	
		
		$dbpdo = DB::create();
		
		$where = " where ifnull(b.name,'') <> '' ";
		
        if ( $date_from != "") {
			
            $date_from = date("Y-m-d", strtotime($date_from));
            
			if ($where == "") {
				$where = " where a.date > '$date_from' ";
			} else {
				$where = $where . " and a.date > '$date_from' ";
			}								
		}
        
        if ( $date_to != "") {
			
            $date_to = date("Y-m-d", strtotime($date_to));
            
			if ($where == "") {
				$where = " where a.date <= '$date_to' ";
			} else {
				$where = $where . " and a.date <= '$date_to' ";
			}								
		}
        
        
		if ( $item_code != "") {
			
			if ($where == "") {
				$where = " where a.item_code = trim('$item_code') ";
			} else {
				$where = $where . " and a.item_code = trim('$item_code') ";
			}								
		}
		
		if ( $location_id != "") {
			
			if ($where == "") {
				$where = " where a.location_code = '$location_id' ";
			} else {
				$where = $where . " and a.location_code = '$location_id' ";
			}								
		}
		
		if ( $uom_code != "") {
			
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		
		if ( $item_group_id != "") {
			
			if ($where == "") {
				$where = " where b.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and b.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $item_subgroup_id != "") {
			
			if ($where == "") {
				$where = " where b.item_subgroup_id = '$item_subgroup_id' ";
			} else {
				$where = $where . " and b.item_subgroup_id = '$item_subgroup_id' ";
			}								
		}
		
		
		if($all != 0) {
			$where = " where ifnull(b.name,'') <> '' ";
		}
		
		
        $sqlstr="select a.item_code, b.code, b.name, a.uom_code, a.location_code, c.name location_name, b.item_group_id, b.item_subgroup_id, sum(ifnull(a.debit_qty,0)) debit_qty, sum(ifnull(a.credit_qty,0)) credit_qty, sum(ifnull(a.debit_qty,0)) - sum(ifnull(a.credit_qty,0)) qty from bincard a left join item b on a.item_code=b.syscode left join warehouse c on a.location_code=c.id " . $where . " group by a.item_code, a.uom_code, a.location_code, b.item_group_id, b.item_subgroup_id, b.name having sum(ifnull(a.debit_qty,0)) - sum(ifnull(a.credit_qty,0)) <> 0 order by b.name";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
		
	}
	
	
	//---------get data pos
	function list_pos($kode ='', $all=0, $from_date='', $to_date='', $shift='', $cashier='', $receipt_type_pos='', $void=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POS%' ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <='$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		if ( $shift != "") {
			if ($where == "") {
				$where = " where a.shift = '$shift' ";
			} else {
				$where = $where . " and a.shift = '$shift' ";
			}								
		}
		
		if ( $cashier != "") {
			if ($where == "") {
				$where = " where a.uid = '$cashier' ";
			} else {
				$where = $where . " and a.uid = '$cashier' ";
			}								
		}
		
		if ( $receipt_type_pos == "cash") {
			if ($where == "") {
				$where = " where a.cash_amount > 0 ";
			} else {
				$where = $where . " and a.cash_amount > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "debit") {
			if ($where == "") {
				$where = " where a.bank_amount > 0 ";
			} else {
				$where = $where . " and a.bank_amount > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "ovo") {
			if ($where == "") {
				$where = " where a.ovo > 0 ";
			} else {
				$where = $where . " and a.ovo > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "gopay") {
			if ($where == "") {
				$where = " where a.gopay > 0 ";
			} else {
				$where = $where . " and a.gopay > 0 ";
			}								
		}
		
		if ( $void == 1) {
			if ($where == "") {
				$where = " where a.void = 1 ";
			} else {
				$where = $where . " and a.void = 1 ";
			}								
		} /*else {
			if ($where == "") {
				$where = " where ifnull(a.void,0) = 0 ";
			} else {
				$where = $where . " and ifnull(a.void,0) = 0 ";
			}
		}*/
		
		if($all == 1) {
			$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POS%' ";
		}
		
		$sqlstr="select a.ref, a.ref2, a.date, a.status, a.top, a.due_date, a.client_code, b.name client_name, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.discount, a.total, a.memo, a.opening_balance, a.cash, a.location_id, a.deposit, a.taxable, a.photo_file, a.cash_amount, a.cash_voucher, a.ovo, a.gopay, a.bank_id, a.bank_amount, a.credit_card_code, a.card_amount, a.credit_card_no, a.credit_card_holder, a.change_amount, a.shift, a.client_member_code, a.uid, a.dlu, c.code client_member_code2, c.name member_name, (select sum(x.point) point from sales_invoice_point x where x.cleared=0 and x.client_code=a.client_code group by x.client_code) point, a.void, a.printed from sales_invoice a left join client b on a.client_code=b.syscode left join client c on a.client_member_code=c.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
    
    
    //-----------pos detail (saat update)
	function list_pos_detail($from_date='', $to_date='', $shift='', $cashier='', $receipt_type_pos='', $void='') {
		$dbpdo = DB::create();
		
		$where = "  where ifnull(c.opening_balance,0) = 0 and c.ref like '%POS%'";
		$group_by = "";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where c.date >= '$from_date' ";
			} else {
				$where = $where . " and c.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where c.date <='$to_date' ";
			} else {
				$where = $where . " and c.date <= '$to_date' ";
			}								
		}
		
		if ( $shift != "") {
			if ($where == "") {
				$where = " where c.shift = '$shift' ";
			} else {
				$where = $where . " and c.shift = '$shift' ";
			}		
			
			$group_by = " , c.shift ";			
		}
		
		if ( $cashier != "") {
			if ($where == "") {
				$where = " where c.uid = '$cashier' ";
			} else {
				$where = $where . " and c.uid = '$cashier' ";
			}		
			
			$group_by = " , c.uid ";						
		}
		
		if ( $receipt_type_pos == "cash") {
			if ($where == "") {
				$where = " where c.cash_amount > 0 ";
			} else {
				$where = $where . " and c.cash_amount > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "debit") {
			if ($where == "") {
				$where = " where c.bank_amount > 0 ";
			} else {
				$where = $where . " and c.bank_amount > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "ovo") {
			if ($where == "") {
				$where = " where c.ovo > 0 ";
			} else {
				$where = $where . " and c.ovo > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "gopay") {
			if ($where == "") {
				$where = " where c.gopay > 0 ";
			} else {
				$where = $where . " and c.gopay > 0 ";
			}								
		}
		
		if ( $void == 1) {
			if ($where == "") {
				$where = " where c.void = 1 ";
			} else {
				$where = $where . " and c.void = 1 ";
			}								
		} /*else {
			if ($where == "") {
				$where = " where ifnull(c.void,0) = 0 ";
			} else {
				$where = $where . " and ifnull(c.void,0) = 0 ";
			}
		}*/
				
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.old_code, b.name item_name, a.uom_code, sum(a.qty) qty, sum(a.discount * a.qty) discount, sum(a.discount3) discount3, sum(ifnull(a.qty_discount,0)) qty_discount, a.unit_price, a.qty_shp, sum(a.amount) amount, a.unit_price2, a.amount2, a.dummy, a.line_item_do, a.line_item_so, a.line, c.void, c.discount discount_hd from sales_invoice_detail a left join item b on a.item_code=b.syscode left join sales_invoice c on a.ref=c.ref ".$where." group by c.void, a.item_code, a.uom_code ".$group_by." order by b.old_code, a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------cash invoice detail (saat update)
	function close_cash_invoice_detail($from_date='', $to_date='', $shift='', $cashier='', $receipt_type_pos='', $void='', $closed='') {
		$dbpdo = DB::create();
		
		$where = "  where ifnull(c.opening_balance,0) = 0 and c.ref like '%POS%'";
		$group_by = "";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where c.date >= '$from_date' ";
			} else {
				$where = $where . " and c.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where c.date <='$to_date' ";
			} else {
				$where = $where . " and c.date <= '$to_date' ";
			}								
		}
		
		if ( $shift != "") {
			if ($where == "") {
				$where = " where c.shift = '$shift' ";
			} else {
				$where = $where . " and c.shift = '$shift' ";
			}		
			
			$group_by = " , c.shift";						
		}
		
		if ( $cashier != "") {
			if ($where == "") {
				$where = " where c.uid = '$cashier' ";
			} else {
				$where = $where . " and c.uid = '$cashier' ";
			}
			
			$group_by = " , c.uid";								
		}
		
		if ( $receipt_type_pos == "cash") {
			if ($where == "") {
				$where = " where c.cash_amount > 0 ";
			} else {
				$where = $where . " and c.cash_amount > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "debit") {
			if ($where == "") {
				$where = " where c.bank_amount > 0 ";
			} else {
				$where = $where . " and c.bank_amount > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "ovo") {
			if ($where == "") {
				$where = " where c.ovo > 0 ";
			} else {
				$where = $where . " and c.ovo > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "gopay") {
			if ($where == "") {
				$where = " where c.gopay > 0 ";
			} else {
				$where = $where . " and c.gopay > 0 ";
			}								
		}
		
		if ( $void == 1) {
			if ($where == "") {
				$where = " where c.void = 1 ";
			} else {
				$where = $where . " and c.void = 1 ";
			}								
		} /*else {
			if ($where == "") {
				$where = " where ifnull(c.void,0) = 0 ";
			} else {
				$where = $where . " and ifnull(c.void,0) = 0 ";
			}
		}*/
		
		if ( $closed == 1) {
			if ($where == "") {
				$where = " where c.closed = 1 ";
			} else {
				$where = $where . " and c.closed = 1 ";
			}								
		}
				
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, sum(a.qty) qty, sum(a.discount * ifnull(a.qty,0)) discount, a.unit_price, a.unit_price2, sum(a.amount) amount, a.amount2, a.dummy, a.line_item_do, a.line_item_so, a.line, ifnull(c.void,0) void from sales_invoice_detail a left join item b on a.item_code=b.syscode left join sales_invoice c on a.ref=c.ref ".$where." group by c.void, a.item_code, a.uom_code ".$group_by." order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------close_cash_invoice (saat update)
	function close_cash_invoice($from_date='', $to_date='', $shift='', $cashier='', $receipt_type_pos='') {
		$dbpdo = DB::create();
		
		$where = "";
		$group_by = "";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <='$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		if ( $shift != "") {
			if ($where == "") {
				$where = " where a.shift = '$shift' ";
			} else {
				$where = $where . " and a.shift = '$shift' ";
			}		
			
			$group_by = " , a.shift";						
		}
		
		if ( $cashier != "") {
			if ($where == "") {
				$where = " where a.uid = '$cashier' ";
			} else {
				$where = $where . " and a.uid = '$cashier' ";
			}
			
			$group_by = " , a.uid";								
		}
		
		if ( $receipt_type_pos == "cash") {
			if ($where == "") {
				$where = " where a.cash_amount > 0 ";
			} else {
				$where = $where . " and a.cash_amount > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "debit") {
			if ($where == "") {
				$where = " where a.bank_amount > 0 ";
			} else {
				$where = $where . " and a.bank_amount > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "ovo") {
			if ($where == "") {
				$where = " where a.ovo > 0 ";
			} else {
				$where = $where . " and a.ovo > 0 ";
			}								
		}
		
		if ( $receipt_type_pos == "gopay") {
			if ($where == "") {
				$where = " where a.gopay > 0 ";
			} else {
				$where = $where . " and a.gopay > 0 ";
			}								
		}
				
		$sqlstr="select count(a.ref) count_invoice from sales_invoice a ".$where." group by a.ref ".$group_by."order by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data cheque history
	function list_cashier_box_cheque_history($client_code=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $client_code != "") {
			if ($where == "") {
				$where = " where a.client_code = '$client_code' ";
			} else {
				$where = $where . " and a.client_code = '$client_code' ";
			}								
		}
		
        $sqlstr = "select a.ref, a.date, a.cheque_no, a.bank_name, a.cheque_date, a.amount, a.void, a.void_date from arc a " . $where . " order by a.date desc";
        $sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
        //$sql=mysql_query($strquery);
		
		return $sql;
	}
	
	
	//---------get data cash invoice
	function list_cash_invoice_box($kode ='', $all=0, $act=''){	
		$dbpdo = DB::create();
		 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.ref2, a.date, a.due_date, a.status, a.top, a.client_code, b.name client_name, b.phone, b.address address_cust, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.cash, a.bank_amount, a.ovo, a.gopay, a.location_id, ifnull(a.deposit,0) deposit, a.discount, a.cash_amount, a.cash_voucher, a.change_amount, a.void, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//-----------cash invoice detail (saat update)
	function list_cash_invoice_box_detail($id='', $posisi=0, $batas=0) {
		$dbpdo = DB::create();
		
		if($batas > 0) {
			$limit = " limit $posisi, $batas";
		}
				
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount, a.discount3, a.unit_price, a.unit_price2, a.amount, a.amount2, a.dummy, a.line_item_do, a.line_item_so, a.line from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line " . $limit;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------notif_cashier
	function notif_cashier(){
		$dbpdo = DB::create();
			 	
		$where = " where (a.total-a.bank_amount-a.cash_amount-a.deposit-a.cash_voucher-a.ovo-a.gopay) > 0 and a.ref like '%CSR%' ";
		
		$sqlstr="select a.ref, a.date, a.due_date, b.name from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------notif_cashier_box
	function notif_cashier_box(){
		$dbpdo = DB::create();
			 	
		$where = " where (a.total-a.bank_amount-a.cash_amount-a.deposit-a.cash_voucher-a.ovo-a.gopay) > 0 and a.ref like '%CSB%' ";
		
		$sqlstr="select a.ref, a.date, a.due_date, b.name from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------dashboard_unit
	function dashboard_unit(){
		$dbpdo = DB::create();
		
		$date_now = date("Y-m-d");
				 	
		$where = " where b.active=1 and a.location_id not in (select location_id from usr_log where status=1 and date_format(dlu_login,'%Y-%m-%d')='$date_now') ";
		$sqlstr="select aa.* from (select a.location_id, b.name unit_name, 1 code from store_unit_detail a left join warehouse b on a.location_id=b.id ".$where."
				union all select distinct a.location_id, b.name unit_name, 0 code from usr_log a left join warehouse b on a.location_id=b.id where b.active=1 and a.status=1 and date_format(a.dlu_login,'%Y-%m-%d')='$date_now')
		  aa order by aa.code, aa.unit_name";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------dashboard_user
	function dashboard_user($location_id=''){
		$dbpdo = DB::create();
			 	
		$where = " where a.usrid<>'' and b.location_id='$location_id' ";
		
		$sqlstr="select distinct a.usrid from usr a left join employee b on a.employee_id=b.id " . $where . " order by a.usrid limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------usrlog
	function dashboard_user_log($location_id='', $user_id=''){
		$dbpdo = DB::create();
		
		$date_now = date("Y-m-d");
		//$_SESSION['location_id2'];
		// and a.usrid='$user_id' 
		//a.status='1' and 
			 	
		$where = " where a.location_id='$location_id' and (date_format(a.dlu_login,'%Y-%m-%d')='$date_now' or date_format(a.dlu_logout,'%Y-%m-%d')='$date_now') ";
		
		$sqlstr="select a.status, b.name unit_name from usr_log a left join warehouse b on a.location_id=b.id " . $where . " order by a.id desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get data cash invoice per kasir (Y)
	function list_pos_print_y($kode ='', $all=0, $from_date='', $to_date='', $shift='', $cashier='', $void=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POS%' ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <='$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		if ( $shift != "") {
			if ($where == "") {
				$where = " where a.shift = '$shift' ";
			} else {
				$where = $where . " and a.shift = '$shift' ";
			}								
		}
		
		if ( $cashier != "") {
			if ($where == "") {
				$where = " where a.uid = '$cashier' ";
			} else {
				$where = $where . " and a.uid = '$cashier' ";
			}								
		}
				
		if ( $void == 1) {
			if ($where == "") {
				$where = " where a.void = 1 ";
			} else {
				$where = $where . " and a.void = 1 ";
			}								
		} 
		
		if($all == 1) {
			$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POS%' ";
			
		}
		
		
		$sqlstr="select a.ref, a.total, (select sum(qty * unit_price) from sales_invoice_detail where ref=a.ref group by ref) amount, (select sum(qty) from sales_invoice_detail where ref=a.ref group by ref) qty from sales_invoice a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//-----------pos detail void
	function list_adt_pos_detail($id='') {
		$dbpdo = DB::create();
		
		$where = " where a.adt_status='void' and a.ref='$id' ";
		
		$sqlstr="select a.ref, a.adt_status, sum(ifnull(a.qty,0)) qty, a.unit_price, sum(a.amount) amount from adt_sales_invoice_detail a ".$where." group by a.ref, a.adt_status order by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------pos detail void z
	function list_adt_pos_detail_z($id='', $from_date='', $to_date='', $shift='', $cashier='') {
		$dbpdo = DB::create();
		
		$where = " where a.adt_status='void'"; //and a.ref='$id' ";
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where b.date >= '$from_date' ";
			} else {
				$where = $where . " and b.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where b.date <='$to_date' ";
			} else {
				$where = $where . " and b.date <= '$to_date' ";
			}								
		}
		
		if ( $shift != "") {
			if ($where == "") {
				$where = " where b.shift = '$shift' ";
			} else {
				$where = $where . " and b.shift = '$shift' ";
			}
		}
		
		if ( $cashier != "") {
			if ($where == "") {
				$where = " where b.uid = '$cashier' ";
			} else {
				$where = $where . " and b.uid = '$cashier' ";
			}
		}
		
		
		$sqlstr="select a.ref, a.adt_status, sum(ifnull(a.qty,0)) qty from adt_sales_invoice_detail a inner join sales_invoice b on a.ref=b.ref ".$where." group by a.ref, a.adt_status order by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------notif_cashier_request_void
	function notif_cashier_request_void($where_loc=''){
		$dbpdo = DB::create();
		
		$where = " where a.ref in (select a.ref from sales_invoice_detail a where ifnull(a.request_void,0)=1 and a.ref like '%POS%' and ifnull(a.note,'')='') ";
		
		if($where_loc != "") {
			$where = $where . " and a.location_id in (". $where_loc . ") ";
		}
		
		$sqlstr="select a.ref, a.date, a.due_date, a.location_id, b.name from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}	
	
	
	//---------get data summary (Z)
	function list_pos_print_z_sum($kode ='', $all=0, $from_date='', $to_date='', $shift='', $cashier='', $void='', $ascdesc=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POS%' ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where a.date >= '$from_date' ";
			} else {
				$where = $where . " and a.date >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where a.date <='$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		if ( $shift != "") {
			if ($where == "") {
				$where = " where a.shift = '$shift' ";
			} else {
				$where = $where . " and a.shift = '$shift' ";
			}								
		}
		
		if ( $cashier != "") {
			if ($where == "") {
				$where = " where a.uid = '$cashier' ";
			} else {
				$where = $where . " and a.uid = '$cashier' ";
			}								
		}
				
		if ( $void == 1) {
			if ($where == "") {
				$where = " where a.void = 1 ";
			} else {
				$where = $where . " and a.void = 1 ";
			}								
		}
		
		$order_by = "";
		if($ascdesc == 0) {
			$order_by = " order by a.dlu asc limit 1";
		} 
		if($ascdesc == 1) {
			$order_by = " order by a.dlu desc limit 1";
		} 
		
		if($all == 1) {
			$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POS%' ";
			
		}
		
		
		$sqlstr="select a.ref, a.dlu from sales_invoice a " . $where . $order_by;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//---------notif_cashier_approved_limit
	function notif_cashier_approved_limit($where_loc=''){
		$dbpdo = DB::create();
		
		$date = date('Y-m-d');
		$where = " where a.date='$date' ";
		
		if($where_loc != "") {
			$where = $where . " and c.location_id in (". $where_loc . ") ";
		}
		
		$sqlstr="select a.ref, a.date, a.uid, sum(a.amount) amount from sales_invoice_tmp a left join usr b on a.uid=b.usrid left join employee c on b.employee_id=c.id " . $where . " group by a.ref having sum(a.amount)>5000000 order by a.date desc, sum(a.amount) desc";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}	
	
		
}
?>