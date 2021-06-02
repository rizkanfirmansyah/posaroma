<?php

class select{	

	//---------get data user
	function list_usr($ref=''){	
		$dbpdo = DB::create();
		
	 	if ($ref == "") {
			$where = "";
			if (user_admin()==0) {
				$uid = $_SESSION["loginname"];
				$where = " where a.uid = '$uid' ";
			} 
			$sqlstr="select a.id, a.usrid, a.pwd, a.adm, b.pwd pwdori, a.employee_id, a.photo, a.act, a.uid, a.dlu from usr a left join usr_bup b on a.usrid=b.usrid " . $where . " order by a.usrid";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		} else {
			$sqlstr="select a.id, a.usrid, a.pwd, b.pwd pwdori, a.adm, a.employee_id, a.photo, a.act, a.uid, a.dlu from usr a left join usr_bup b on a.usrid=b.usrid where a.id='$ref' order by a.usrid";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		}
		
		
		return $sql;
	}
	
	//-----------user form akses(saat add)
	function list_usrfrm() {
		$dbpdo = DB::create();
		
		$sqlstr="select frmcde, frmnme from usr_frm order by frmnme";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------user detail akses(saat update)
	function list_usrdtl($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select usrid from usr where id=$id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		
		$sqlstr="select usrid from usr where userid='$data->usrid' ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------check user
	function list_usr_check($ref=''){	
		$dbpdo = DB::create();
		 	
		$sqlstr="select usrid from usr where usrid='$ref'";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//-----------user form akses(saat update)
	function list_usrrgh($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select usrid from usr where id=$id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		
		$sqlstr="select aa.* from (select a.id, a.frmcde, b.frmnme, 1 mslc, a.madd, a.medt, a.mdel, a.lvl, 1 old from usr_dtl a left join usr_frm b on a.frmcde=b.frmcde where a.usrid='$data->usrid' union all
		select 0 id, frmcde, frmnme, 0 mslc, 0 madd, 0 medt, 0 mdel, 0 lvl, 0 old from usr_frm where frmcde not in (select frmcde from usr_dtl where usrid='$data->usrid' )) aa order by aa.id desc, aa.frmnme ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data company
	function list_company($kode ='', $all=0, $act=''){	 	
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where id = '$kode' ";
			} else {
				$where = $where . " and id = '$kode' ";
			}								
		}
		
		$sqlstr="select id, name, businiss_type, address1, address2, phone1, phone2, fax, city, country, web, email, active, uid, dlu from company " . $where . " order by id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}

	//---------get data position
	function list_position($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.name, a.active, a.uid, a.dlu from position a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data department
	function list_department($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.name, a.active, a.uid, a.dlu from department a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data division
	function list_division($kode ='', $all=0, $act=''){	
		$dbpdo = DB::create();
		 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.name, a.active, a.uid, a.dlu from division a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data employee
	function list_employee($kode ='', $all=0, $act=''){	
		$dbpdo = DB::create();
		 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.code, a.name, a.nick_name, a.born, a.birth_date, a.marital_status, a.religion_id, a.address, a.zip_code, a.country_id, a.state_id, a.phone, a.email, a.photo, a.position_id, a.department_id, a.division_id, a.location_id, a.active, a.uid, a.dlu, b.name location_name from employee a left join warehouse b on a.location_id=b.id " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data coa
	function list_coa($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		$sqlstr="select a.acc_code, a.name, a.acc_type, a.postable, a.subacc_code, a.opening_balance, a.opening_balance_date, a.current_balance, a.currency_code, a.currency_rate, a.currency_exchange_id, a.level, a.active, a.uid, a.dlu, a.syscode, b.name acc_type_name, c.acc_code sub_of_acc_code, c.name sub_of_acc_name from coa a left join coa_type b on a.acc_type=b.id left join coa c on a.subacc_code=c.syscode " . $where . " order by b.name, a.acc_code";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data item type
	function list_item_type($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, a.name, a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode, a.location_id, b.name w_name, a.active, a.uid, a.dlu, a.syscode from item_type a left join warehouse b on a.location_id=b.id " . $where . " order by a.syscode";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data item type detail
	function list_item_type_detail($syscode_header =''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $syscode_header != "") {
			if ($where == "") {
				$where = " where a.syscode_header = '$syscode_header' ";
			} else {
				$where = $where . " and a.syscode_header = '$syscode_header' ";
			}								
		}
		
		$sqlstr="select a.code, a.syscode_header, a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode, a.location_id, a.syscode, a.line from item_type_detail a " . $where . " order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data uom
	function list_uom($kode ='', $all=0, $act=''){	
		$dbpdo = DB::create();
		 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.code = '$kode' ";
			} else {
				$where = $where . " and a.code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, a.name, a.active, a.uid, a.dlu from uom a " . $where . " order by a.code";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data item group
	function list_item_group($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.code, a.name, a.nonstock, a.costing_type, a.inventory_acccode, a.purchase_discount_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode, a.consignment_acccode, a.location_id, a.active, a.uid, a.dlu from item_group a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data item group detail
	function list_item_group_detail($id_header =''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $id_header != "") {
			if ($where == "") {
				$where = " where a.id_header = '$id_header' ";
			} else {
				$where = $where . " and a.id_header = '$id_header' ";
			}								
		}
		
		$sqlstr="select a.id, a.id_header, a.inventory_acccode, a.purchase_discount_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode, a.consignment_acccode, a.location_id, a.line from item_group_detail a " . $where . " order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data item sub group
	function list_item_subgroup($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.name, a.item_group_id, a.active, a.uid, a.dlu from item_subgroup a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data reason to adjust
	function list_reason_adjust($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.name, a.active, a.uid, a.dlu from reason_adjust a " . $where . " order by a.id";
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
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.code, a.name, a.address, a.email, a.phone, a.active, a.uid, a.dlu from warehouse a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data uom conversion
	function list_uom_conversion($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		$sqlstr="select a.uom_code1, a.uom_code2, a.conversion, a.factor, a.uid, a.dlu, a.syscode from uom_conversion a " . $where . " order by a.syscode";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data colour
	function list_colour($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.name, a.active, a.uid, a.dlu from colour a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data brand
	function list_brand($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.code, a.name, a.active, a.uid, a.dlu from brand a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data size
	function list_size($kode ='', $all=0, $act=''){	 	
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.code, a.name, a.active, a.uid, a.dlu from size a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data item category
	function list_item_category($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.code, a.name, a.active, a.uid, a.dlu from item_category a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//---------get data item
	function list_item($kode ='', $all=0, $active='', $code='', $old_code='', $name='', $item_group_id='', $from_date='', $to_date=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		if ( $active != "") {
			if ($where == "") {
				$where = " where a.active = '$active' ";
			} else {
				$where = $where . " and a.active = '$active' ";
			}								
		}
		
		if ( $code != "") {
			if ($where == "") {
				$where = " where a.code = '$code' ";
			} else {
				$where = $where . " and a.code = '$code' ";
			}								
		}
		
		if ( $old_code != "") {
			if ($where == "") {
				$where = " where a.old_code = '$old_code' ";
			} else {
				$where = $where . " and a.old_code = '$old_code' ";
			}								
		}
		
		if ( $name != "") {
			$name = petikreplace($name);
			if ($where == "") {
				$where = " where a.name like '%$name%' ";
			} else {
				$where = $where . " and a.name like '%$name%' ";
			}								
		}
		
		if ( $item_group_id != "") {
			if ($where == "") {
				$where = " where a.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and a.item_group_id = '$item_group_id' ";
			}								
		}
		
		if ( $from_date != "") {
			
			$from_date = date("Y-m-d", strtotime($from_date));
			
			if ($where == "") {
				$where = " where date_format(a.dlu, '%Y-%m-%d') >= '$from_date' ";
			} else {
				$where = $where . " and date_format(a.dlu, '%Y-%m-%d') >= '$from_date' ";
			}								
		}
		
		if ( $to_date != "") {
			
			$to_date = date("Y-m-d", strtotime($to_date));
			
			if ($where == "") {
				$where = " where date_format(a.dlu, '%Y-%m-%d') <= '$to_date' ";
			} else {
				$where = $where . " and date_format(a.dlu, '%Y-%m-%d') <= '$to_date' ";
			}								
		}
		
		if($kode=='' && $all==0 && $act=='' && $code=='' && $old_code=='' && $name=='' && $item_group_id=='' && $from_date=='' && $to_date=='') {
			$where = " where a.syscode = 'NDF' ";
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.code, a.old_code, a.name, a.item_group_id, b.name item_group_name, a.item_subgroup_id, a.item_type_code, a.item_category_id, a.brand_id, a.size_id, a.uom_code_stock, a.uom_code_sales, a.uom_code_purchase, a.minimum_stock, a.maximum_stock, a.photo, a.consigned, a.active, a.uid, a.dlu, a.syscode from item a left join item_group b on a.item_group_id=b.id " . $where . " order by a.code";
		//echo $sqlstr;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data item conversion
	function list_item_conversion($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.item_code = '$kode' ";
			} else {
				$where = $where . " and a.item_code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.item_code, b.code, b.name item_name, a.uid, a.dlu from item_conversion a left join item b on a.item_code=b.syscode " . $where . " order by a.item_code";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------item conversion (saat update)
	function list_item_conversion_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select item_code, uom_code1, uom_code2, conversion, factor, constant from item_conversion_detail where item_code='$id' order by line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data item packing
	function list_item_packing($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.warehouse_id, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.unit_price, a.week_wage_ref, a.week_wage_total, a.uid, a.dlu from item_packing a left join item b on a.item_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------item packing detail (saat update)
	function list_item_packing_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.warehouse_id, a.qty, a.unit_price, a.amount, a.line from item_packing_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data inbound
	function list_inbound($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.reason, a.type, a.purchase_invoice, a.warehouse_id_from, a.warehouse_id_to, a.received_by, a.uid, a.dlu from inbound a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------inbound detail (saat update)
	function list_inbound_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.qty, a.line from inbound_detail a where a.ref='$id' order by a.line ";
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
	
	//-----------outbound detail (saat update)
	function list_outbound_detail($kode='', $item_group_id='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		if ( $item_group_id != "") {
			if ($where == "") {
				$where = " where b.item_group_id = '$item_group_id' ";
			} else {
				$where = $where . " and b.item_group_id = '$item_group_id' ";
			}								
		}
		
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.qty, a.ref_pos, a.line, b.code item_code2, b.name item_name from outbound_detail a left join item b on a.item_code=b.syscode " . $where . " order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data store request
	function list_store_request($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.reason, a.type, a.memo, a.priority, a.warehouse_id_from, a.warehouse_id_to, a.uid, a.dlu from store_request a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------store request detail (saat update)
	function list_store_request_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.qty, a.line from store_request_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data stock opname
	function list_stock_opname($kode ='', $from_date='', $to_date='', $all=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
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
		
		$sqlstr="select a.date, a.location_id, b.name location_name, a.bin, a.uid, a.beginning_balance, a.memo, a.dlu, a.syscode from stock_opname a left join warehouse b on a.location_id=b.id " . $where . " order by a.date";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------stock oopname detail (saat update)
	function list_stock_opname_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.date, a.location_id, a.bin, a.uid, a.item_code, a.uom_code, a.line, a.qty, a.unit_cost, a.syscode, b.code item_code2, b.name item_name  from stock_opname_detail a left join item b on a.item_code=b.syscode where a.syscode='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------vendor Type
	function list_vendor_type($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.name, a.pch_account, a.pch_return_account, a.pch_discount_account, a.vendor_deposit_account, a.currency_account, a.cheque_payable_account, a.location_id, b.name w_name, a.active, a.uid, a.dlu  from vendor_type a left join warehouse b on a.location_id=b.id " . $where . " order by a.id ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data vendor type detail
	function list_vendor_type_detail($id_header =''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $id_header != "") {
			if ($where == "") {
				$where = " where a.id_header = '$id_header' ";
			} else {
				$where = $where . " and a.id_header = '$id_header' ";
			}								
		}
		
		$sqlstr="select a.id, a.id_header, a.pch_account, a.pch_cash_account, a.pch_return_account, a.pch_discount_account, a.vendor_deposit_account, a.currency_account, a.cheque_payable_account, a.hutang_belum_faktur, a.location_id, a.line  from vendor_type_detail a " . $where . " order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------vendor
	function list_vendor($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, a.name, a.contact_person, a.vendor_type, a.address, a.zip_code, a.country_id, a.state_id, a.phone, a.fax, a.email, a.web, a.bank_account, a.active, a.uid, a.dlu, a.syscode  from vendor a " . $where . " order by a.code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------tax
	function list_tax($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, a.name, a.rate, a.tax_account, a.active, a.uid, a.dlu, a.syscode from tax a " . $where . " order by a.code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	

	//---------get data invent adjust
	function list_invent_adjust($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.gl_account, a.reason_id, a.location_id, a.memo, a.uid, a.dlu from invent_adjust a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------store invent adjust detail (saat update)
	function list_invent_adjust_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.qty, a.line from invent_adjust_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data item issued
	function list_item_issued($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.employee_id, a.location_id, a.memo, a.uid, a.dlu from item_issued a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------store item issued detail (saat update)
	function list_item_issued_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.account_code, a.qty, a.line from item_issued_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data item return
	function list_item_return($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.item_issued_ref, a.employee_id, a.location_id, a.memo, a.uid, a.dlu from item_return a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------store item return detail (saat update)
	function list_item_return_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, b.code item_code2, b.name item_name, a.uom_code, a.account_code, c.acc_code, c.name account_name, a.qty, a.line, a.line_item_issued from item_return_detail a left join item b on a.item_code=b.syscode left join coa c on a.account_code=c.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------get item issued detail (saat update)
	function get_item_issued($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, b.code item_code2, b.name item_name, a.uom_code, a.account_code, c.acc_code, c.name account_name, a.qty, a.line line_item_issued from item_issued_detail a left join item b on a.item_code=b.syscode left join coa c on a.account_code=c.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------get item stock detail (saat update)
	function get_item_stock($location_id=0, $item_group_id=0, $item_subgroup_id=0) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.code item_code, a.name item_name, a.item_group_id, a.item_subgroup_id, a.uom_code_stock, b.qty_onhandbegin from item a left join item_epr b on a.syscode=b.item_code where a.item_group_id='$item_group_id' and a.item_subgroup_id='$item_subgroup_id' or (location_id='$location_id') order by a.code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data purchase request
	function list_purchase_request($kode ='', $all=0, $act=''){	
		$dbpdo = DB::create();
		 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.employee_id, b.name employee_name, a.location_id, c.name loc_name, a.reason, a.memo, a.uid, a.dlu from purchase_request a left join employee b on a.employee_id=b.id left join warehouse c on a.location_id=c.id " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------purchase request detail (saat update)
	function list_purchase_request_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.qty, a.line from purchase_request_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data purchase ordre
	function list_purchase_order($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.vendor_code, b.name vendor_name, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.note, a.uid, a.dlu from purchase_order a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------purchase order detail (saat update)
	function list_purchase_order_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.pr_ref, a.item_code, a.uom_code, a.qty, a.unit_cost, a.amount, a.line from purchase_order_detail a where a.ref='$id' order by a.line ";
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
		
		$sqlstr="select a.ref, a.date, a.status, a.date_arrival, a.driver, a.vehicle, a.location_id, b.name loc_name, a.memo, a.uid, a.dlu from good_receipt a left join warehouse b on a.location_id=b.id " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------good_receipt detail (saat update)
	function list_good_receipt_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.po_ref, a.item_code, a.uom_code, a.qty, a.unit_cost, a.line from good_receipt_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data purchase invoice
	function list_purchase_invoice($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%PIN%' ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.bill_number, a.vendor_code, b.name vendor_name, a.top, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.memo, a.uid, a.dlu from purchase_invoice a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
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
		
	//-----------get po detail (saat update)
	function get_po_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, c.code, c.name item_name, a.uom_code, a.qty, a.unit_cost, a.amount, a.line from purchase_order_detail a left join purchase_order b on a.ref=b.ref left join item c on a.item_code=c.syscode where b.vendor_code='$id' order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------currency
	function list_currency($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, a.name, a.currency_code, a.symbol, a.active, a.uid, a.dlu, a.syscode from currency a " . $where . " order by a.code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------currency rate type
	function list_currency_rate_type($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.name, a.currency_code, b.currency_code currency, a.date, a.rate, a.active, a.uid, a.dlu from currency_rate_type a left join currency b on a.currency_code=b.code " . $where . " order by a.id ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------credit card type
	function list_credit_card_type($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.code = '$kode' ";
			} else {
				$where = $where . " and a.code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, a.name, a.active, a.uid, a.dlu from credit_card_type a " . $where . " order by a.code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------cash master
	function list_cash_master($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.code = '$kode' ";
			} else {
				$where = $where . " and a.code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, b.acc_code, b.name, a.location_id, c.name unit, a.maximum_limit, a.uid, a.dlu from cash_master a left join coa b on a.code=b.syscode left join warehouse c on a.location_id=c.id " . $where . " order by a.code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------client Type
	function list_client_type($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.name, a.sls_account, a.sls_return_account, a.sls_discount_account, a.client_deposit_account, a.currency_account, a.cheque_receivable_account, a.location_id, b.name w_name, a.active, a.uid, a.dlu  from client_type a left join warehouse b on a.location_id=b.id " . $where . " order by a.id ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data client detail
	function list_client_type_detail($id_header =''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $id_header != "") {
			if ($where == "") {
				$where = " where a.id_header = '$id_header' ";
			} else {
				$where = $where . " and a.id_header = '$id_header' ";
			}								
		}
		
		$sqlstr="select a.id, a.id_header, a.sls_account, a.sls_cash_account, a.sls_return_account, a.sls_discount_account, a.client_deposit_account, a.currency_account, a.cheque_receivable_account, a.sls_account2, a.location_id, a.line  from client_type_detail a " . $where . " order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------client
	function list_client($kode ='', $all=0, $act='', $name='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		if ( $name != "") {
			if ($where == "") {
				$where = " where a.name = '$name' ";
			} else {
				$where = $where . " and a.name = '$name' ";
			}								
		}
		
		$sqlstr="select a.code, a.title, a.name, a.last_name, a.contact_person, a.contact_person1, a.contact_person2, a.contact_person3, a.client_type, a.address, a.zip_code, a.country_id, a.state_id, a.phone, a.phone1, a.fax, a.email, a.web, a.bank_name, a.bank_branch, a.bank_account, a.bank_account_no, a.location_id, a.active, a.uid, a.dlu, a.syscode, b.name client_type_name from client a left join client_type b on a.client_type=b.id " . $where . " order by a.code, a.name ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	
	
		
	//---------get price type
	function list_price_type($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.name, a.active, a.uid, a.dlu from price_type a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------set client opening balance
	function list_set_client_balance($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, a.name, a.syscode, a.active, a.uid, a.dlu  from client a " . $where . " order by a.code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------set client opening balance (receivable)
	function list_set_client_balance_receivable($kode ='') {
		$dbpdo = DB::create();
		
		$where = " where a.opening_balance=1 ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.client_code = '$kode' ";
			} else {
				$where = $where . " and a.client_code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.client_code, a.due_date, a.currency_code, a.total, a.rate from sales_invoice a " . $where . " order by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------set client opening balance (cheque)
	function list_set_client_balance_cheque($kode ='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.client_code = '$kode' ";
			} else {
				$where = $where . " and a.client_code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.cheque_no, a.client_code, a.bank_name, a.cheque_date, a.currency_code, a.amount, a.rate, a.account_code from arc a " . $where . " order by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------set client opening balance (deposit)
	function list_set_client_balance_deposit($kode ='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.client_code = '$kode' ";
			} else {
				$where = $where . " and a.client_code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.client_code, a.currency_code, a.amount, a.rate, a.deposit from receipt a " . $where . " order by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------get AR opening balance (receivable)
	function get_arblc_detail($kode ='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.client_code = '$kode' ";
			} else {
				$where = $where . " and a.client_code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.client_code, a.due_date, a.currency_code, a.total, a.rate from sales_invoice a " . $where . " order by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------marketing
	function list_marketing($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.code = '$kode' ";
			} else {
				$where = $where . " and a.code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, a.name, a.contact_person, a.address, a.zip_code, a.country_id, a.state_id, a.phone, a.fax, a.email, a.web, a.bank_account, a.active, a.uid, a.dlu  from marketing a " . $where . " order by a.code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data quotation
	function list_quotation($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, a.date_from, a.date_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.uid, a.dlu from quotation a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------quotation detail (saat update)
	function list_quotation_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.qty, a.discount, a.unit_price, a.amount, a.line from quotation_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data sales orser
	function list_sales_order($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, a.qo_ref, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.uid, a.dlu from sales_order a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------sales order detail (saat update)
	function list_sales_order_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.qty, a.discount, a.unit_price, a.amount, a.line from sales_order_detail a where a.ref='$id' order by a.line ";
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
		
		$sqlstr="select a.ref, a.date, a.status, a.location_id, a.ship_to, a.po_number, a.client_code, a.memo, a.uid, a.dlu, b.name client_name, a.delivered from delivery_order a left join client b on a.client_code=b.syscode  " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------sales delivery detail (saat update)
	function list_delivery_order_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.ship_date, a.line_item_so, a.line, c.delivered from delivery_order_detail a left join item b on a.item_code=b.syscode left join delivery_order c on a.ref=c.ref where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------get so detail (saat update)
	function get_so_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, c.code item_code2, c.name item_name, a.uom_code, (ifnull(a.qty,0) - ifnull(a.qty_shp,0)) qty, a.line from sales_order_detail a left join sales_order b on a.ref=b.ref left join item c on a.item_code=c.syscode where b.client_code='$id' and (ifnull(a.qty,0) - ifnull(a.qty_shp,0)) > 0 and b.status <> 'P' and b.status <> 'C' order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------get do detail (saat update)
	function get_do_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref do_ref, d.ref so_ref, a.item_code, c.code, c.name item_name, a.uom_code, (ifnull(a.qty,0) - ifnull(a.qty_si,0)) qty, d.unit_price, d.discount, d.amount, a.line line_do, d.line line_so from delivery_order_detail a left join delivery_order b on a.ref=b.ref left join item c on a.item_code=c.syscode left join sales_order_detail d on a.so_ref=d.ref and a.line_item_so=d.line where b.client_code='$id' and (ifnull(a.qty,0) - ifnull(a.qty_si,0)) > 0 and b.status <> 'P' and b.status <> 'C' order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data sales invoice
	function list_sales_invoice($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%SOI%' ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.top, a.client_code, b.name client_name, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
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
	
	
	//-----------get si detail (saat update)
	function get_si_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref si_ref, a.item_code, c.code, c.name item_name, a.uom_code, (ifnull(a.qty,0) - ifnull(a.qty_rtn,0)) qty, a.unit_price, a.discount, a.amount, a.line line_si from sales_invoice_detail a left join sales_invoice b on a.ref=b.ref left join item c on a.item_code=c.syscode where a.ref='$id' and (ifnull(a.qty,0) - ifnull(a.qty_rtn,0)) > 0 and b.status <> 'P' and b.status <> 'V' order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data sales return
	function list_sales_return($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.client_code, a.si_ref, b.name client_name, a.tax_code, a.tax_rate, a.currency_code, a.rate, a.total, a.memo, a.uid, a.dlu from sales_return a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------sales return detail (saat update)
	function list_sales_return_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount, a.unit_price, a.charge_p, a.amount, a.line_item_si, a.line from sales_return_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data purchase return
	function list_purchase_return($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.vendor_code, a.pi_ref, b.name vendor_name, a.tax_code, a.tax_rate, a.currency_code, a.rate, a.total, a.memo, a.uid, a.dlu from purchase_return a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------sales purchase detail (saat update)
	function list_purchase_return_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount, a.unit_cost, a.amount, a.line_item_pi, a.line from purchase_return_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------get pi detail (saat update)
	function get_pi_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref pi_ref, a.item_code, c.code, c.name item_name, a.uom_code, ifnull(a.qty,0)-ifnull(a.qty_rtn,0) qty, a.unit_cost, 0 discount, a.amount, a.line line_pi from purchase_invoice_detail a left join purchase_invoice b on a.ref=b.ref left join item c on a.item_code=c.syscode where a.ref='$id' and ifnull(a.qty,0)-ifnull(a.qty_rtn,0) > 0 order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------get gr detail (saat update)
	function get_gr_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, c.code item_code2, c.name item_name, a.uom_code, a.qty, a.line from good_receipt_detail a left join good_receipt b on a.ref=b.ref left join item c on a.item_code=c.syscode left join purchase_order d on a.po_ref=d.ref where d.vendor_code='$id' order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data good_return
	function list_good_return($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.reason, a.vendor_code, b.name vendor_name, a.location_id, a.memo, a.uid, a.dlu from good_return a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------good_return detail (saat update)
	function list_good_return_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.gr_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.line_item_gr, a.line from good_return_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------get do detail (saat update)
	function get_dor_detail($client_code, $location_id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, c.code item_code2, c.name item_name, a.uom_code, (ifnull(a.qty,0) - ifnull(a.qty_rtn,0)) qty, a.line from delivery_order_detail a left join delivery_order b on a.ref=b.ref left join item c on a.item_code=c.syscode where b.client_code='$client_code' and b.location_id='$location_id' and ifnull(b.location_id,0)<>0 and (ifnull(a.qty,0) - ifnull(a.qty_rtn,0)) > 0 and b.status <> 'P' and b.status <> 'V' order by a.ref, a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data delivery_return
	function list_delivery_return($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.reason, a.client_code, b.name client_name, a.location_id, a.memo, a.uid, a.dlu from delivery_return a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------delivery_return detail (saat update)
	function list_delivery_return_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.do_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.line_item_do, a.line from delivery_return_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	#*********************VENDOR OPENING BALANCE*****************#
	//-----------set vendor opening balance
	function list_set_vendor_balance($kode ='', $all=0, $act='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, a.name, a.syscode, a.active, a.uid, a.dlu  from vendor a " . $where . " order by a.code ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------set vendor opening balance (payable)
	function list_set_vendor_balance_payable($kode ='') {
		$dbpdo = DB::create();
		
		$where = " where a.opening_balance=1 ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.vendor_code = '$kode' ";
			} else {
				$where = $where . " and a.vendor_code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.vendor_code, a.due_date, a.currency_code, a.total, a.rate from purchase_invoice a " . $where . " order by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------set vendor opening balance (cheque)
	function list_set_vendor_balance_cheque($kode ='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.vendor_code = '$kode' ";
			} else {
				$where = $where . " and a.vendor_code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.cheque_no, a.vendor_code, a.bank_name, a.cheque_date, a.currency_code, a.amount, a.rate, a.account_code from apc a " . $where . " order by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------set vendor opening balance (deposit)
	function list_set_vendor_balance_deposit($kode ='') {
		$dbpdo = DB::create();
		
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.vendor_code = '$kode' ";
			} else {
				$where = $where . " and a.vendor_code = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.vendor_code, a.currency_code, a.amount, a.rate, a.deposit from payment a " . $where . " order by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	#*****************************END****************************#
		
	function get_invoice_detail($clien_code='') {
		$dbpdo = DB::create();
		
		$querystring = "select aa.*, bb.installment, bb.loan from 
			(select a.invoice_no, a.date, a.due_date, a.contact_type, a.contact_code, a.contact_other, a.ref_type invoice_type, sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.credit_amount,0)) - sum(ifnull(a.discount_amount,0)) amount_paid, a.ref_type, a.currency_code, a.rate, a.exchange_type, a.exchange_date, a.top, a.description, a.uid, a.dlu from ar a group by a.contact_code, a.contact_type, a.invoice_no, a.ref_type having (sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.credit_amount,0)) - sum(ifnull(a.discount_amount,0))) <> 0 
			union all
			select a.invoice_no, a.date, '1900-01-01' due_date, a.contact_type, a.contact_code, a.contact_other, 'DPS' invoice_type, (sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.credit_amount,0))) * -1 amount_paid, a.ref_type, a.currency_code, a.rate, a.exchange_type, a.exchange_date, a.top, a.description, a.uid, a.dlu from dps a group by a.contact_code, a.contact_type, a.invoice_no, a.invoice_type having (sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.credit_amount,0))) > 0 )  aa left join direct_receipt bb on aa.invoice_no=bb.ref where aa.contact_code = '$clien_code' order by aa.invoice_no, aa.date";
		$sql=$dbpdo->prepare($querystring);
		$sql->execute();
				
		//$sql=mysql_query($querystring);
		
		
		return $sql;
	}
	
	//---------get data receipt
	function list_receipt($kode ='', $from_date='', $to_date='', $client_code='', $all=0){
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
		
		if ( $client_code != "") {
			if ($where == "") {
				$where = " where a.client_code = '$client_code' ";
			} else {
				$where = $where . " and a.client_code = '$client_code' ";
			}								
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.client_code, a.receipt_type, a.cheque_no, a.cheque_date, a.bank_name, a.credit_card_no, a.credit_card_code, a.credit_card_holder, a.credit_card_expired, a.account_code, a.currency_code, a.rate, a.amount, a.deposit, a.sub_total, a.type, a.memo, a.round_amount, a.round_amount_account, a.bank_charge, a.bank_charge_account, a.opening_balance, a.total, a.uid, a.dlu, b.name client_name from receipt a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------receipt detail (saat update)
	function list_receipt_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.invoice_no, a.invoice_date, a.invoice_due_date, a.invoice_currency_code, a.invoice_rate, a.amount_due, a.discount, a.amount_paid, a.ref_type invoice_type, a.amount, a.line from receipt_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	function get_payment_detail($vendor_code='') {
		$dbpdo = DB::create();
		
		$sqlstr="
					select aa.* from (select a.invoice_no, b.invoice_no no_nota, a.date, a.due_date, a.contact_type, a.contact_code, a.contact_other, a.ref_type invoice_type, sum(ifnull(a.credit_amount,0)) - sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.discount_amount,0)) amount_paid, a.ref_type, a.currency_code, a.rate, a.exchange_type, a.exchange_date, a.top, a.description, a.uid, a.dlu from ap a left join purchase_invoice b on a.ref=b.ref group by a.contact_code, a.contact_type, a.invoice_no, a.ref_type having (sum(ifnull(a.credit_amount,0)) - sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.discount_amount,0))) <> 0) aa where aa.contact_code = '$vendor_code' order by aa.invoice_no, aa.date";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//---------get data payment
	function list_payment($kode ='', $from_date='', $to_date='', $vendor_code='', $all=0){
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
		
		if ( $vendor_code != "") {
			if ($where == "") {
				$where = " where a.vendor_code = '$vendor_code' ";
			} else {
				$where = $where . " and a.vendor_code = '$vendor_code' ";
			}								
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.vendor_code, a.payment_type, a.cheque_no, a.cheque_date, a.bank_name, a.credit_card_no, a.credit_card_code, a.credit_card_holder, a.credit_card_expired, a.account_code, a.currency_code, a.rate, a.amount, a.deposit, a.sub_total, a.type, a.memo, a.round_amount, a.round_amount_account, a.bank_charge, a.bank_charge_account, a.opening_balance, a.total, a.no_ttfa, a.uid, a.dlu, b.name vendor_name from payment a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------payment detail (saat update)
	function list_payment_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.invoice_no, b.invoice_no no_nota, a.invoice_date, a.invoice_due_date, a.invoice_currency_code, a.invoice_rate, a.amount_due, a.discount, a.amount_paid, a.ref_type invoice_type, a.amount, a.line from payment_detail a left join purchase_invoice b on a.invoice_no=b.ref where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------payment giro
	function list_payment_giro($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.account_code, a.cheque_no, a.bank_name, a.cheque_date, a.amountbg, a.line from payment_giro a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data cash invoice
	function list_cash_invoice($kode ='', $all=0, $from_date='', $to_date='', $location_id=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%CSH%' ";
		
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
        
        
        if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
        
        if($all == 1) {
            $where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%CSH%' ";
        }
        
		$sqlstr="select a.ref, a.ref2, a.date, a.status, a.top, a.due_date, a.client_code, b.name client_name, b.address, a.ship_to, a.bill_to, (case when ifnull(a.ship_to,'')='' then b.address else a.ship_to end) address2, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.cash, a.location_id, a.deposit, a.taxable, a.discount, a.use_deposit, a.ref_rci, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//-----------cash invoice detail (saat update)
	function list_cash_invoice_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount, a.unit_price, a.qty_shp, a.amount, a.unit_price2, a.amount2, a.dummy, a.line_item_do, a.line_item_so, a.line from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data delivery order quick
	function list_delivery_order_quick($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where a.ref like '%DOQ%' ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.location_id, a.ship_to, a.po_number, a.client_code, a.memo, a.uid, a.dlu, b.name client_name, a.delivered from delivery_order a left join client b on a.client_code=b.syscode  " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------sales delivery detail quick (saat update)
	function list_delivery_order_quick_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.ship_date, a.line_item_so, a.line, c.delivered from delivery_order_detail a left join item b on a.item_code=b.syscode left join delivery_order c on a.ref=c.ref where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//-----------get cash invoice detail (saat update)
	function get_cash_invoice_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_code, c.code item_code2, c.name item_name, a.uom_code, (ifnull(a.qty,0) - ifnull(a.qty_shp,0)) qty, a.line from sales_invoice_detail a left join sales_invoice b on a.ref=b.ref left join item c on a.item_code=c.syscode where b.client_code='$id' and (ifnull(a.qty,0) - ifnull(a.qty_shp,0)) > 0 and b.status <> 'P' and b.status <> 'C' and a.ref like '%CSH%' order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}


	//---------get data direct payment
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
	
	//-----------direct payment detail (saat update)
	function list_direct_payment_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.account_code, a.currency_code, a.rate, a.debit_amount, a.credit_amount, a.memo, a.line from direct_payment_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get direct receipt
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
	
	//-----------receipt detail (saat update)
	function list_direct_receipt_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.account_code, a.currency_code, a.rate, a.debit_amount, a.credit_amount, a.memo, a.line from direct_receipt_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data delivery order project
	function list_delivery_order_project($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where a.direct = 1 ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.location_id, a.ship_to, a.po_number, a.client_code, a.memo, a.direct, a.uid, a.dlu, b.name client_name, a.delivered from delivery_order a left join client b on a.client_code=b.syscode  " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------sales delivery detail project (saat update)
	function list_delivery_order_project_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.ship_date, a.line_item_so, a.line, c.delivered from delivery_order_detail a left join item b on a.item_code=b.syscode left join delivery_order c on a.ref=c.ref where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	//---------get data sales invoice project
	function list_sales_invoice_project($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%PIV%' ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.ref2, a.date, a.status, a.top, a.client_code, b.name client_name, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.total, a.memo, a.opening_balance, a.deposit, a.taxable, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
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
	
	//-----------get do detail project (saat update)
	function get_do_detail_project($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref do_ref, d.ref so_ref, a.item_code, c.code, c.name item_name, a.uom_code, (ifnull(a.qty,0) - ifnull(a.qty_si,0)) qty, d.unit_price, d.discount, d.amount, a.line line_do, d.line line_so from delivery_order_detail a left join delivery_order b on a.ref=b.ref left join item c on a.item_code=c.syscode left join sales_order_detail d on a.so_ref=d.ref and a.line_item_so=d.line where b.client_code='$id' and (ifnull(a.qty,0) - ifnull(a.qty_si,0)) > 0 and b.status <> 'P' and b.status <> 'C' and b.direct = 1 order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get cash receipt
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
	
	//-----------cash detail (saat update)
	function list_cash_receipt_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.account_code, a.currency_code, a.rate, a.debit_amount, a.credit_amount, a.memo, a.line from cash_receipt_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data cash payment
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
	
	//-----------cash payment detail (saat update)
	function list_cash_payment_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.account_code, a.currency_code, a.rate, a.debit_amount, a.credit_amount, a.memo, a.line from cash_payment_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data week wage
	function list_week_wage($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.type, a.employee_id, a.memo, a.invoice_no, a.loan_balance, a.loan_total, a.installment, a.total, a.loan, a.uid, a.dlu from week_wage a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------week wage detail (saat update)
	function list_week_wage_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.item_name, a.uom_code, a.qty, a.unit_price, a.amount, a.line from week_wage_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	function get_kasbon($clien_code='') {
		$dbpdo = DB::create();
		
		/*$sqlstr="
					select aa.*, bb.installment from (select a.invoice_no, a.contact_code, a.date, a.ref_type, sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.credit_amount,0)) - sum(ifnull(a.discount_amount,0)) amount_paid from ar a group by a.contact_code having (sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.credit_amount,0)) - sum(ifnull(a.discount_amount,0))) <> 0 and a.ref_type='loan' order by a.date limit 1) aa left join direct_receipt bb on aa.invoice_no=bb.ref where aa.contact_code = '$clien_code' and ifnull(bb.loan,0)=1 order by aa.contact_code";
		*/
					
		$sqlstr="
					select aa.*, bb.installment from (select a.invoice_no, a.contact_code, a.date, a.ref_type, sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.credit_amount,0)) - sum(ifnull(a.discount_amount,0)) amount_paid from ar a group by a.invoice_no, a.contact_code, a.date, a.ref_type having (sum(ifnull(a.debit_amount,0)) - sum(ifnull(a.credit_amount,0)) - sum(ifnull(a.discount_amount,0))) <> 0 and a.ref_type='loan' and a.contact_code = '$clien_code' order by a.date limit 1) aa left join week_wage bb on aa.invoice_no=bb.ref where aa.contact_code = '$clien_code' order by aa.contact_code";	
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();		
		
		return $sql;
	}		
	
	
	//---------get data purchase quick
	function list_purchase_quick($kode ='', $from_date='', $to_date='', $vendor_code='', $all=0){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%PIQ%' ";
		
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
			$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%PIQ%' ";
		}
		
		$sqlstr="select a.ref, a.invoice_no, a.date, a.status, a.bill_number, a.vendor_code, b.name vendor_name, a.top, a.due_date, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.memo, a.total, a.location_id, a.cash, a.uid, a.dlu from purchase_invoice a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	//-----------purchase_quick detail (saat update)
	function list_purchase_quick_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.po_ref, a.item_code, b.code item_code2, b.name item_name, a.uom_code, a.qty, a.unit_cost, a.amount, a.line_item_po, a.line from purchase_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data purchase issued
	function list_purchase_issue($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%PII%' ";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		$sqlstr="select a.ref, a.invoice_no, a.date, a.status, a.bill_number, a.vendor_code, b.name vendor_name, a.top, a.due_date, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.memo, a.total, a.location_id, a.cash, a.uid, a.dlu from purchase_invoice a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------purchase_issue detail (saat update)
	function list_purchase_issue_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.po_ref, a.item_name, a.uom_code, a.qty, a.unit_cost, a.amount, a.line_item_po, a.line from purchase_invoice_detail a where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------get APC
	function get_apc($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref pi_ref, a.date, a.vendor_code, a.cheque_no, a.bank_name, a.cheque_date, a.amount, a.line from apc a where ifnull(a.deposite,0)=0 and a.ref='$id' order by a.line";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
			
		return $sql;
	}
	
	
	//-----------get BPOC
	function list_bpoc() {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.date, a.vendor_code, a.cheque_no, a.bank_name, a.cheque_date, a.amount, a.deposite_date, a.deposite_by, a.line, b.name vendor_name from apc a left join vendor b on a.vendor_code=b.syscode where ifnull(a.deposite,0)=1 order by a.date";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
			
		return $sql;
	}
    
    
    //---------get data vehicle
	function list_vehicle($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.syscode = '$kode' ";
			} else {
				$where = $where . " and a.syscode = '$kode' ";
			}								
		}
		
		$sqlstr="select a.code, a.status, a.vendor_code, a.brand, a.type, a.no_rangka, a.no_mesin, a.jenis_bak, a.year, a.seri_unit, a.warna_kabin, a.no_bpkb, a.tanggal_bpkb, a.no_kir, a.tanggal_kir, a.gps, a.posisi_bpkb, a.ket_bpkb, a.insurance, a.location_id, a.capacity, a.tonase, a.photo, a.active, a.uid, a.dlu, a.syscode from vehicle a " . $where . " order by a.code";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}


    //---------get data asset type
	function list_asset_type($kode ='', $all=0, $act=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.id = '$kode' ";
			} else {
				$where = $where . " and a.id = '$kode' ";
			}								
		}
		
		$sqlstr="select a.id, a.type, a.active, a.uid, a.dlu from asset_type a " . $where . " order by a.id";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
    
    
    //---------get data asset
	function list_asset($kode ='', $asset_name='', $alias='', $tanggal_perolehan='', $group_block='', $all=0){
		$dbpdo = DB::create();
			 	
		$where = "";
		
		if ( $kode != "") {
			if ($where == "") {
				$where = " where a.ref = '$kode' ";
			} else {
				$where = $where . " and a.ref = '$kode' ";
			}								
		}
		
		if ( $asset_name != "") {
			if ($where == "") {
				$where = " where a.asset_name like '%$asset_name%' ";
			} else {
				$where = $where . " and a.asset_name like '%$asset_name%' ";
			}								
		}
		
		if ( $alias != "") {
			if ($where == "") {
				$where = " where a.alias like '%$alias%' ";
			} else {
				$where = $where . " and a.alias like '%$alias%' ";
			}								
		}
		
		if ( $tanggal_perolehan != "") {
			
			$tanggal_perolehan = date("Y-m-d", strtotime($tanggal_perolehan));
			
			if ($where == "") {
				$where = " where a.tanggal_perolehan = '$tanggal_perolehan' ";
			} else {
				$where = $where . " and a.tanggal_perolehan = '$tanggal_perolehan' ";
			}								
		}
				
		if ( $group_block != "") {
			if ($where == "") {
				$where = " where a.group_block like '%$group_block%' ";
			} else {
				$where = $where . " and a.group_block like '%$group_block%' ";
			}								
		}
		
		if($kode == '' && $asset_name == '' && $alias == '' && $tanggal_perolehan == '' && $group_block == '' && $all == 0) {
			$where = " where a.ref = 'ndf' ";
		}
		
		if($all == 1) {
			$where = "";
		}		
		
		$sqlstr="select a.ref, a.asset_name, a.alias, a.ref_id, a.lokasi, a.provinsi_kode, a.kota_kode, a.kecamatan_kode, a.desa_kode, a.asset_type_id, b.type asset_type, a.status, a.luas, a.sertifikat, a.imb, a.tanggal_perolehan, a.pemilik_sebelum, a.contact_name, a.no_pbb, a.group_block, a.alamat, a.lintang, a.bujur, a.nilai_perolehan, a.nilai_amnesti, a.pemilik_sekarang, a.photo, a.photo_1, a.photo_2, a.photo_3, a.photo_4, a.shm, a.shm_nama, a.ajb, a.pbb, a.keterangan, a.active, a.uid, a.dlu from asset a left join asset_type b on a.asset_type_id=b.id " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
    
    //---------get data asset trans
	function list_asset_trans($kode =''){
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
    
    
    //-----------cashier get detail
	function list_cashier_get_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.ref2, a.date, a.due_date, a.client_code, a.cash, a.item_code, b.code, b.name item_name, a.item_name2, a.uom_code, a.qty, a.discount, a.unit_price, a.amount, a.discount2, a.discount3, a.deposit, a.total, a.non_discount, a.note, a.line from sales_invoice_tmp a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
    
    
    //---------get data cashier
	function list_cashier($kode ='', $all=0, $from_date='', $to_date='', $shift='', $cashier='', $receipt_type_pos='', $void=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%CSR%' ";
		
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
		
		if ( $void == "1") {
			if ($where == "") {
				$where = " where a.void = 1 ";
			} else {
				$where = $where . " and a.void = 1 ";
			}								
		} 
		
		if ( $void == "0") {
			if ($where == "") {
				$where = " where ifnull(a.void,0) = 0 ";
			} else {
				$where = $where . " and ifnull(a.void,0) = 0 ";
			}
		}
		
		if( $all == 1) {
			$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%CSR%' ";
		}
		
		$sqlstr="select a.ref, a.ref2, a.date, a.status, a.top, a.due_date, a.client_code, b.name client_name, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.discount, a.total, a.memo, a.opening_balance, a.cash, a.location_id, a.deposit, a.taxable, a.photo_file, a.cash_amount, a.bank_id, a.bank_amount, a.credit_card_code, a.card_amount, a.credit_card_no, a.credit_card_holder, a.change_amount, a.cash_voucher, a.ovo, a.gopay, a.void, a.void_memo, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
    
    
    //-----------cashier detail (saat update)
	function list_cashier_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, a.item_name2, b.code, b.name item_name, a.uom_code, a.qty, a.discount, a.discount3, a.unit_price, a.qty_shp, a.amount, a.unit_price2, a.amount2, a.dummy, a.note, a.line_item_do, a.line_item_so, a.line from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
    
    
    //---------get data item barcode
	function list_item_barcode($location_id, $item_group_id, $item_subgroup_id, $item_code, $order_by=''){
		$dbpdo = DB::create();
			 	
		$where = "";
		
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
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.syscode = '$item_code' ";
			} else {
				$where = $where . " and a.syscode = '$item_code' ";
			}								
		}
		
		
		if($location_id == '' && $item_group_id == '' && $item_subgroup_id == '' && $item_code == '') {
			$where = " where a.syscode = '' ";
		}
		
		
		$order_ = "";		
		if($order_by != "") {
			if($order_by == '0') {
				$order_ = " order by a.code ";
			}
			
			if($order_by == '1') {
				$order_ = " order by a.name ";
			}
		}
				
		$sqlstr="select a.code, a.old_code, a.name, a.item_group_id, a.item_subgroup_id, a.item_type_code, a.item_category_id, a.brand_id, a.size_id, a.uom_code_stock, a.uom_code_sales, a.uom_code_purchase, a.minimum_stock, a.maximum_stock, a.photo, a.consigned, a.active, a.uid, a.dlu, a.syscode from item a " . $where . $order_ ;
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		return $sql;
	}
	
	
	//---------get set data item price __
	function list_set_item_price_last($location_id, $item_code){	 
		
		$dbpdo = DB::create();
			
		$where = "";
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
		
		/*if ( $item_code != "") {*/
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		/*}*/
		
		if($location_id=='' && $item_code=='') {
			$where = " where a.item_code = 'ndf'";
		}
		
		$sqlstr="select a.date, a.efective_from, a.item_code, a.uom_code, a.current_price, a.current_price1, a.current_price2, a.current_price3, a.last_price, a.date_of_record, a.location_id, a.non_discount, a.qty1, a.qty2, a.qty3, a.qty4, a.uid, a.dlu from set_item_price a " . $where . " order by a.date_of_record desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get set data item cost __
	function list_set_item_cost_last($location_id, $item_code){	 
		
		$dbpdo = DB::create();
			
		$where = "";
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
		
		/*if ( $item_code != "") {*/
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		/*}*/
		
		//cek harga pembelian terakhir
		$sqlstr2 = "select a.unit_cost, b.date, ifnull(a.discount1,0) discount1, b.tax_rate from purchase_invoice_detail a left join purchase_invoice b on a.ref=b.ref where a.item_code='$item_code' order by b.dlu desc limit 1 ";
		$sql2=$dbpdo->prepare($sqlstr2);
		$sql2->execute();
		$data2=$sql2->fetch(PDO::FETCH_OBJ);
		$unit_cost=$data2->unit_cost;
		$discount1= ($unit_cost * $data2->discount1)/100;
		$tax_rate= ($unit_cost * $data2->tax_rate)/100;
		$unit_cost=($unit_cost - $discount1) + $tax_rate;
		$date = $data2->date;
		
		
		//ceh harg setup biaya
		$sqlstr="select a.date, a.efective_from, a.item_code, a.uom_code, a.current_cost, a.last_cost, a.date_of_record, a.location_id, a.uid, a.dlu from set_item_cost a " . $where . " order by a.date_of_record desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$date2 = $data->date;
		
		if($date > $date2) {
			$sqlstr="select '$date' date, $unit_cost current_cost";
			//$sqlstr="select '$date' date, a.efective_from, a.item_code, a.uom_code, $unit_cost current_cost, a.last_cost, a.date_of_record, a.location_id, a.uid, a.dlu from set_item_cost a " . $where . " order by a.date_of_record desc limit 1";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		} else {
			$sqlstr="select a.date, a.efective_from, a.item_code, a.uom_code, a.current_cost, a.last_cost, a.date_of_record, a.location_id, a.uid, a.dlu from set_item_cost a " . $where . " order by a.date_of_record desc limit 1";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		}
		
		
		return $sql;
	}
	
	
	//===================
	//-----------pos get detail
	function list_pos_get_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.client_code, a.cash, a.item_code, b.code, b.old_code, b.name item_name, a.uom_code, a.end_date_discount, a.qty, a.discount, a.unit_price, a.amount, a.discount2, a.discount3, a.deposit, a.total, a.non_discount, a.qty_discount, a.ref_near_expired, a.upd_approved_over, a.line from sales_invoice_tmp a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line desc ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------pos get total amount detail
	function list_pos_total_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select sum(a.amount) amount from sales_invoice_tmp a where a.ref='$id' group by a.ref ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$amount=$data->amount;
		
		return $amount;
	}
    
    
    //---------get data pos
	function list_pos($kode ='', $all=0, $from_date='', $to_date='', $shift='', $cashier='', $receipt_type_pos=''){
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
		
		if($all == 1) {
			$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POS%' ";
		}
		
		$sqlstr="select a.ref, a.ref2, a.date, a.status, a.top, a.due_date, a.client_code, b.name client_name, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.discount, a.total, a.memo, a.opening_balance, a.cash, a.location_id, a.deposit, a.taxable, a.photo_file, a.cash_amount, a.cash_voucher, a.ovo, a.gopay, a.bank_id, a.bank_amount, a.credit_card_code, a.card_amount, a.credit_card_no, a.credit_card_holder, a.change_amount, a.shift, a.client_member_code, a.uid, a.dlu, c.code client_member_code2, c.name member_name, (select sum(x.point) point from sales_invoice_point x where x.cleared=0 and x.client_code=a.client_code group by x.client_code) point, a.void, a.printed from sales_invoice a left join client b on a.client_code=b.syscode left join client c on a.client_member_code=c.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
    
    
    //---------get data pos
	function list_pos_valid($kode ='', $all=0, $from_date='', $to_date='', $shift='', $cashier='', $receipt_type_pos='', $void='', $closed=''){
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
		} 
		/*else {
			if ($where == "") {
				$where = " where ifnull(a.void,0) = 0 ";
			} else {
				$where = $where . " and ifnull(a.void,0) = 0 ";
			}
		}*/
		
		if ( $closed == 1) {
			if ($where == "") {
				$where = " where a.closed = 1 ";
			} else {
				$where = $where . " and a.closed = 1 ";
			}								
		} 
		
		if($all == 1) {
			$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POS%' ";
		}
		
		$sqlstr="select a.ref, a.ref2, a.date, a.status, a.top, a.due_date, a.client_code, b.name client_name, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.discount, a.total, a.memo, a.opening_balance, a.cash, a.location_id, a.deposit, a.taxable, a.photo_file, a.cash_amount, a.cash_voucher, a.ovo, a.gopay, a.bank_id, a.bank_amount, a.credit_card_code, a.card_amount, a.credit_card_no, a.credit_card_holder, a.change_amount, a.shift, a.client_member_code, a.uid, a.dlu, c.code client_member_code2, c.name member_name, (select sum(x.point) point from sales_invoice_point x where x.cleared=0 and x.client_code=a.client_code group by x.client_code) point, a.void, a.printed, a.closed from sales_invoice a left join client b on a.client_code=b.syscode left join client c on a.client_member_code=c.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
    
    //-----------pos detail (saat update)
	function list_pos_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.old_code, b.name item_name, a.uom_code, a.qty, a.discount, a.discount2, a.discount3, a.non_discount, a.qty_discount, a.end_date_discount, a.discount_percent_tmp, a.unit_price, a.qty_shp, a.amount, a.unit_price2, a.amount2, a.dummy, a.line_item_do, a.line_item_so, a.line, a.ref_near_expired, ifnull(a.note,'') note, a.request_void from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by b.old_code, a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------pos purchase inv detail
	function list_purchase_inv_get_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.vendor_code, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount1, a.discount2, a.discount3, a.discount4, a.discount, a.unit_cost, a.amount, a.total, a.location_id, a.line from purchase_invoice_tmp a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line desc";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//-----------total purchase inv detail
	function list_purchase_inv_total_tmp($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select sum(a.amount) total from purchase_invoice_tmp a where a.ref='$id' group by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$total=$data->total;
		
		return $total;
	}
	
	
	//-----------total purchase inv detail
	function list_purchase_inv_total($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select sum(a.total) total from purchase_invoice a where a.ref='$id' group by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data=$sql->fetch(PDO::FETCH_OBJ);
		$total=$data->total;
		
		return $total;
	}
	
	//---------get data purchase inv
	function list_purchase_inv($kode ='', $from_date='', $to_date='', $vendor_code='', $all=0){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POV%' ";
		
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
			$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%POV%' ";
		}
		
		$sqlstr="select a.ref, a.invoice_no, a.date, a.status, a.bill_number, a.vendor_code, a.payment_type, b.name vendor_name, a.top, a.due_date, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.memo, a.discount, a.total, a.location_id, a.cash, a.cash_amount, a.change_amount, a.bank_id, a.bank_amount, a.credit_card_code, a.card_amount, a.credit_card_no, a.credit_card_holder, a.uid, a.dlu, (select sum(aa.amount) from purchase_invoice_detail aa group by aa.ref having aa.ref=a.ref) amount from purchase_invoice a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//-----------purchase_inv detail (saat update)
	function list_purchase_inv_detail($id) {
		$dbpdo = DB::create();
		
		$sqlstr="select a.ref, a.po_ref, a.item_code, b.code item_code2, b.old_code, b.name item_name, a.uom_code, a.qty, a.unit_cost, a.discount1, a.discount2, a.discount3, a.discount4, a.discount, a.amount, a.line_item_po, a.line from purchase_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line desc ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------outbound detail
	function list_outbound_get_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.warehouse_id_from, a.warehouse_id_to, a.employee_id, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.line from outbound_tmp a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//-----------outbound detail last
	function list_outbound_get_detail_last($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.warehouse_id_from, a.warehouse_id_to, a.employee_id, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.line from outbound_tmp a left join item b on a.item_code=b.syscode where a.ref='$id' and a.warehouse_id_to<>0 order by a.line limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------pos purchase return detail
	function list_purchase_return_get_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.vendor_code, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount1, a.discount, a.unit_cost, a.amount, a.location_id, a.line from purchase_return_tmp a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line desc";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get data purchase return quick
	function list_purchase_return_quick($kode='', $from_date='', $to_date='', $vendor_code='', $all=''){
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
		
		if ( $vendor_code != "") {
			if ($where == "") {
				$where = " where a.vendor_code = '$vendor_code' ";
			} else {
				$where = $where . " and a.vendor_code = '$vendor_code' ";
			}								
		}
		
		if($all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.vendor_code, a.location_id, a.pi_ref, b.name vendor_name, a.tax_code, a.tax_rate, a.currency_code, a.rate, a.total, a.memo, a.uid, a.dlu from purchase_return a left join vendor b on a.vendor_code=b.syscode " . $where . " order by a.ref";
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
	
	//---------get set item price
	function list_get_set_price($location_id='', $item_code='', $uom_code=''){	 	
		$dbpdo = DB::create();
		
		$where = "";
		
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
		
		if ( $uom_code != "") {
			if ($where == "") {
				$where = " where a.uom_code = '$uom_code' ";
			} else {
				$where = $where . " and a.uom_code = '$uom_code' ";
			}								
		}
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.item_code = '$item_code' ";
			} else {
				$where = $where . " and a.item_code = '$item_code' ";
			}								
		}
		
		$sqlstr="select a.current_price, a.last_price, 0 cogs, a.non_discount, a.date_of_record from set_item_price a " . $where . " order by a.date_of_record desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		return $sql;
	}
	
    
    //---------get set outlet price
	function get_outlet_set_price($location_id='', $end_date_discount_total='', $amount_minimum=0){	 	
		$dbpdo = DB::create();
		
		$amount_minimum = numberreplace($amount_minimum);
		$where = " where ifnull(a.amount_minimum,0) <= $amount_minimum and ifnull(a.amount_minimum,0) >0  ";
		
		
		if ( $location_id != "") {
			if ($where == "") {
				$where = " where a.location_id = '$location_id' ";
			} else {
				$where = $where . " and a.location_id = '$location_id' ";
			}								
		}
		
		if ( $end_date_discount_total != "") {
			
			$end_date_discount_total = date("Y-m-d", strtotime($end_date_discount_total));
			if ($where == "") {
				$where = " where '$end_date_discount_total' <= a.end_date_discount_total ";
			} else {
				$where = $where . " and '$end_date_discount_total' <= a.end_date_discount_total ";
			}								
		}
				
		$sqlstr="select a.end_date_discount_total, a.amount_minimum, a.discount_total from outlet_set_price a " . $where . " order by a.end_date_discount_total desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		return $sql;
	}
	
	
	//---------get data cashier box
	function list_cashier_box($kode ='', $all=0, $from_date='', $to_date='', $shift='', $cashier='', $receipt_type_pos='', $void=''){
		$dbpdo = DB::create();
			 	
		$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%CSB%' ";
		
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
		
		if ( $void == "1") {
			if ($where == "") {
				$where = " where a.void = 1 ";
			} else {
				$where = $where . " and a.void = 1 ";
			}								
		} 
		
		if ( $void == "0") {
			if ($where == "") {
				$where = " where ifnull(a.void,0) = 0 ";
			} else {
				$where = $where . " and ifnull(a.void,0) = 0 ";
			}
		}
		
		if( $all == 1) {
			$where = " where ifnull(a.opening_balance,0) = 0 and a.ref like '%CSB%' ";
		}
		
		$sqlstr="select a.ref, a.ref2, a.date, a.status, a.top, a.due_date, a.client_code, b.name client_name, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.discount, a.total, a.memo, a.opening_balance, a.cash, a.location_id, a.deposit, a.taxable, a.photo_file, a.cash_amount, a.bank_id, a.bank_amount, a.credit_card_code, a.card_amount, a.credit_card_no, a.credit_card_holder, a.change_amount, a.cash_voucher, a.ovo, a.gopay, a.void, a.void_memo, a.uid, a.dlu from sales_invoice a left join client b on a.client_code=b.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//-----------cashier get detail
	function list_cashier_box_get_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.ref2, a.date, a.due_date, a.client_code, a.cash, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount, a.unit_price, a.amount, a.discount2, a.discount3, a.deposit, a.total, a.non_discount, a.note, a.line from sales_invoice_tmp a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//-----------cashier box detail (saat update)
	function list_cashier_box_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.discount, a.discount3, a.unit_price, a.qty_shp, a.amount, a.unit_price2, a.amount2, a.dummy, a.note, a.line_item_do, a.line_item_so, a.line from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	function get_ar($clien_code='', $invoice_no='') {
		$dbpdo = DB::create();
		
		$where = " where a.contact_code='$clien_code' and a.invoice_no='$invoice_no' ";
		
		$querystring = "select sum(a.credit_amount) debit_amount from ar a ".$where." group by a.contact_code, a.invoice_no";
		$sql=$dbpdo->prepare($querystring);
		$sql->execute();
		
		return $sql;
	}
	
	
	//-----------cashier box subdetail (saat update)
	function list_cashier_box_subdetail($id, $line_detail) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.unit_price, a.amount, a.line_detail, a.line from sales_invoice_subdetail a left join item b on a.item_code=b.syscode where a.ref='$id' and line_detail='$line_detail' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get data order stock
	function list_order_stock($kode ='', $all=0, $from_date='', $to_date=''){
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
				$where = " where a.date <='$to_date' ";
			} else {
				$where = $where . " and a.date <= '$to_date' ";
			}								
		}
		
		
		if( $all == 1) {
			$where = "";
		}
		
		$sqlstr="select a.ref, a.date, a.status, a.memo, a.location_id, a.uid, a.dlu from order_stock a " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//-----------order stock get detail
	function list_order_stock_detail($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.item_code, a.uom_code, a.qty, a.line, b.old_code, b.name item_name from order_stock_detail a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	
	//---------get data pos
	function list_pos_void($kode ='', $all=0, $from_date='', $to_date='', $shift='', $cashier='', $receipt_type_pos='', $item_code=''){
		$dbpdo = DB::create();
			 	
		$where = " where a.ref in (select ref from sales_invoice_detail where note='void') and a.ref like '%POS%' ";
		
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
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where a.ref in (select a.ref from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			} else {
				$where = $where . " and a.ref in (select a.ref from sales_invoice_detail a left join item b on a.item_code=b.syscode where a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			}								
		}
		
		
		if($all == 1) {
			$where = " where a.ref in (select ref from sales_invoice_detail where note='void')  and a.ref like '%POS%' ";
		}
		
		$sqlstr="select a.ref, a.ref2, a.date, a.status, a.top, a.due_date, a.client_code, b.name client_name, a.ship_to, a.bill_to, a.tax_code, a.tax_rate, a.freight_cost, a.freight_account, a.currency_code, a.rate, a.employee_id, a.discount, a.total, a.memo, a.opening_balance, a.cash, a.location_id, a.deposit, a.taxable, a.photo_file, a.cash_amount, a.cash_voucher, a.ovo, a.gopay, a.bank_id, a.bank_amount, a.credit_card_code, a.card_amount, a.credit_card_no, a.credit_card_holder, a.change_amount, a.shift, a.client_member_code, a.uid, a.dlu, c.code client_member_code2, c.name member_name, a.void, a.printed, a.closed from sales_invoice a left join client b on a.client_code=b.syscode left join client c on a.client_member_code=c.syscode " . $where . " order by a.ref";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();

		
		return $sql;
	}
	
	
	//-----------pos detail (saat update)
	function list_pos_void_detail($id) {
		$dbpdo = DB::create();
		
		$where = " where (a.note='void' or c.void=1) and a.ref='$id' ";
				
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.old_code, b.name item_name, a.uom_code, a.qty, a.discount, a.discount2, a.discount3, a.non_discount, a.qty_discount, a.end_date_discount, a.discount_percent_tmp, a.unit_price, a.qty_shp, a.amount, a.unit_price2, a.amount2, a.dummy, a.line_item_do, a.line_item_so, a.line, a.ref_near_expired from sales_invoice_detail a left join item b on a.item_code=b.syscode left join sales_invoice c on a.ref=c.ref ".$where." order by b.old_code, a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//-----------pos detail (saat update)
	function list_adt_pos_detail($id='', $item_code='') {
		$dbpdo = DB::create();
		
		$where = " where a.adt_status='void' and a.ref='$id' ";
		
		if ( $item_code != "") {
			if ($where == "") {
				$where = " where (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			} else {
				$where = $where . " and (a.item_code = trim('$item_code') or b.code = trim('$item_code') or b.old_code = trim('$item_code')) ";
			}								
		}
				
		$sqlstr="select a.ref, a.do_ref, a.so_ref, a.item_code, b.code, b.old_code, b.name item_name, a.uom_code, a.qty, a.discount, a.discount2, a.discount3, a.non_discount, a.qty_discount, a.end_date_discount, a.discount_percent_tmp, a.unit_price, a.qty_shp, a.amount, a.unit_price2, a.amount2, a.dummy, a.line_item_do, a.line_item_so, a.line, a.ref_near_expired, c.uid, c.dlu from adt_sales_invoice_detail a left join item b on a.item_code=b.syscode left join adt_sales_invoice c on a.ref=c.ref ".$where." order by b.old_code, a.line ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
				
		return $sql;
	}
	
	
	//---------get_pos_overlimit
	function get_pos_overlimit($where_loc=''){
		$dbpdo = DB::create();
			 	
		$date = date('Y-m-d');
		$where = " where a.date='$date' ";
		
		if($where_loc != "") {
			$where = $where . " and c.location_id in (". $where_loc . ") ";
		}
		
		$sqlstr="select a.ref, a.date, a.uid, ifnull(a.limit_approved,0) limit_approved, sum(a.amount) amount from sales_invoice_tmp a left join usr b on a.uid=b.usrid left join employee c on b.employee_id=c.id " . $where . " group by a.ref having sum(a.amount)>5000000 order by sum(a.amount) desc";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
	//-----------pos get detail last item
	function get_pos_get_detail_last_item($id) {
		$dbpdo = DB::create();
				
		$sqlstr="select a.ref, a.client_code, a.cash, a.item_code, b.code, b.old_code, b.name item_name, a.uom_code, a.end_date_discount, a.qty, a.discount, a.unit_price, a.amount, a.discount2, a.discount3, a.deposit, a.total, a.non_discount, a.qty_discount, a.ref_near_expired, a.upd_approved_over, a.line from sales_invoice_tmp a left join item b on a.item_code=b.syscode where a.ref='$id' order by a.dlu desc limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		
		return $sql;
	}
	
		
}
?>