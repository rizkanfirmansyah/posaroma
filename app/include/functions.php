<?php
@session_start();

error_reporting(E_ALL & ~E_NOTICE);

function populate_select($table,$fields_id,$fields_value,$selected){
	$dbpdo = DB::create();
	$sqlstr="Select $fields_id,$fields_value From $table Order By $fields_value";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($row = $sql->fetch(PDO::FETCH_OBJ)){
		$SelectedCountry=($row->$fields_id==$selected) ? " selected" : "";		
		echo "<option value=" . $row->$fields_id . $SelectedCountry . ">" . $row->$fields_value . "</option>";
		//($row->$fields_id==$selected) ? 'selected' : '';
	}
	
}

function populate2_select($table,$fields_id,$fields_value,$selected){
	$dbpdo = DB::create();
	$sqlstr="Select $fields_id,$fields_value From $table Order By $fields_id";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($row = $sql->fetch(PDO::FETCH_OBJ)){
		$SelectedCountry=($row->$fields_id==$selected) ? " selected" : "";		
		echo "<option value=" . $row->$fields_id . $SelectedCountry . ">" . $row->$fields_value . "</option>";
		//($row->$fields_id==$selected) ? 'selected' : '';
	}
	
}

function combo_select($table,$fields_id,$fields_code,$fields_value,$selected){		 
	$dbpdo = DB::create();
	$sqlstr="Select distinct $fields_id,$fields_code,$fields_value From $table Order By $fields_value";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($row = $sql->fetch(PDO::FETCH_OBJ)){
		$SelectedCountry=($row->$fields_id==$selected) ? " selected" : "";		
		echo "<option value=" . $row->$fields_id . $SelectedCountry . ">" . $row->$fields_code ."    ". substr($row->$fields_value,0,90) . "</option>";
		//($row->$fields_id==$selected) ? 'selected' : '';
	}
	
}

function combo_select_active($table,$fields_id,$fields_value,$where,$where2,$selected){		 
	$dbpdo = DB::create();
	$sqlstr="Select $fields_id,$fields_value From $table where $where='$where2' Order By $fields_value";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($row = $sql->fetch(PDO::FETCH_OBJ)){
		$SelectedCountry=($row->$fields_id==$selected) ? " selected" : "";		
		echo "<option value=" . $row->$fields_id . $SelectedCountry . ">" . $row->$fields_value . "</option>";
		//($row->$fields_id==$selected) ? 'selected' : '';
	}
	
}

function combo_select_active2($table,$fields_id,$fields_value,$where,$where2,$selected){		 
	$dbpdo = DB::create();
	$sqlstr="Select $fields_id,$fields_value From $table where active=1 and $where='$where2' Order By $fields_value";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($row = $sql->fetch(PDO::FETCH_OBJ)){
		$SelectedCountry=($row->$fields_id==$selected) ? " selected" : "";		
		echo "<option value=" . $row->$fields_id . $SelectedCountry . ">" . $row->$fields_value . "</option>";
		//($row->$fields_id==$selected) ? 'selected' : '';
	}
	
}

function combo_select_orderby($table,$fields_id,$fields_code,$fields_value,$orderby,$selected){		 
	$dbpdo = DB::create();
	$sqlstr="Select distinct $fields_id,$fields_code,$fields_value From $table Order By $orderby";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($row = $sql->fetch(PDO::FETCH_OBJ)){
		$SelectedCountry=($row->$fields_id==$selected) ? " selected" : "";		
		echo "<option value=" . $row->$fields_id . $SelectedCountry . ">" . $row->$fields_code ."    ". substr($row->$fields_value,0,90) . "</option>";
		//($row->$fields_id==$selected) ? 'selected' : '';
	}
	
}

function select_shift($selected){
	$dbpdo = DB::create();
	$sqlstr="select id, name from shift order by id";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->id)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->id . $selectdata . ">" . $rows->name . "</option>";
	}
}

function select_item_subgroup($item_group_id,$selected){
	$dbpdo = DB::create();
	$sqlstr="select id, name from item_subgroup where item_group_id='$item_group_id' order by name";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->id)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->id . $selectdata . ">" . $rows->name . "</option>";
	}
}

function select_orderby_item($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select '0' cde, 'Code' dcr, 0 nmr union all 
		select '1' cde, 'Name' dcr, 1 nmr) a order by nmr";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_cashier_toko($selected){
	$dbpdo = DB::create();
	$sqlstr="select distinct uid from sales_invoice order by uid";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->uid)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->uid . $selectdata . ">" . $rows->uid . "</option>";
	}
}

function select_item_group($selected){
	$dbpdo = DB::create();
	$sqlstr="select id syscode, code, name from item_group where active='1' order by code";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->syscode)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->syscode . $selectdata . ">" . $rows->code . '-' . $rows->name . "</option>";
	}
}

function select_desa($kecamatan, $selected){
	$dbpdo = DB::create();
	$sqlstr="select syscode, nama from desa where kode_kecamatan='$kecamatan' order by nama";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->syscode)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->syscode . $selectdata . ">" . $rows->nama . "</option>";
	}
}

function select_kecamatan($kota, $selected){
	$dbpdo = DB::create();
	$sqlstr="select syscode, nama from kecamatan where kode_kota='$kota' order by nama";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->syscode)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->syscode . $selectdata . ">" . $rows->nama . "</option>";
	}
}

function select_kota($provinsi, $selected){
	$dbpdo = DB::create();
	$sqlstr="select syscode, nama from kota where kode_provinsi='$provinsi' order by nama";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->syscode)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->syscode . $selectdata . ">" . $rows->nama . "</option>";
	}
}

function select_bank($selected){
	$dbpdo = DB::create();
	$sqlstr="select id, name, account_code from bank order by name";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->id)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->id . $selectdata . ">" . $rows->name . " / " . $rows->account_code . "</option>";
	}
}

function select_status_vehicle($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select '0' cde, 'Own/Milik Sendiri' dcr, 0 nmr union all 
		select '1' cde, 'Subcon' dcr, 1 nmr ) a order by nmr";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_receipt_type_pos($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'cash' cde, 'Cash' dcr, 0 nmr union all 
		select 'debit' cde, 'Debit' dcr, 1 nmr union all 
		select 'ovo' cde, 'OVO' dcr, 2 nmr union all 
		select 'gopay' cde, 'Gopay' dcr, 3 nmr) a order by nmr";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_asset($selected){
	$dbpdo = DB::create();
	$sqlstr="select ref, asset_name from asset order by ref";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " " . $rows->asset_name . "</option>";
	}
}

function select_status_asset($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'kontrak' cde, 'Dikontrakan' dcr, 0 nmr union all 
		select 'sewa' cde, 'Disewakan' dcr, 1 nmr ) a order by nmr";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}


function select_sertifikat_asset($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'ada' cde, 'Ada' dcr, 0 nmr union all 
		select 'tidak' cde, 'Tidak Ada' dcr, 1 nmr ) a order by nmr";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_qo_return($selected){
	$dbpdo = DB::create();
	$sqlstr="select ref, date from quotation order by ref";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " / " . $rows->date . "</option>";
	}
}

function select_outstanding_apc($vendor_code, $selected){
	$dbpdo = DB::create();
	$sqlstr="select distinct ref, date from apc where vendor_code='$vendor_code' and ifnull(deposite,0)=0 order by ref";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " / " . $rows->date . "</option>";
	}
}

function select_pi_return($selected, $vendor_code){
	$dbpdo = DB::create();
	$sqlstr="select ref, date from purchase_invoice where vendor_code='$vendor_code' order by ref";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " / " . $rows->date . "</option>";
	}
}

function select_weekwage_type($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select '0' cde, 'Produksi' dcr, 0 nmr union all 
		select '1' cde, 'Ritase' dcr, 1 nmr union all 
		select '2' cde, 'Muat Bongkar' dcr, 2 nmr) a order by nmr";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_si_return($selected, $client_code, $edit=""){
	$dbpdo = DB::create();
	
	if($edit != "") {
		$sqlstr="select a.ref, a.date from sales_invoice a where a.client_code='$client_code' order by a.ref";	
	} else {
		$sqlstr="select a.ref, a.date from sales_invoice a inner join (select ref from sales_invoice_detail group by ref having sum(ifnull(qty,0)) - sum(ifnull(qty_rtn,0))) b on a.ref=b.ref where a.client_code='$client_code' and a.status <> 'P' and a.status <> 'V' order by a.ref";
	}
	
	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " / " . $rows->date . "</option>";
	}
}

function select_po($selected){
	$dbpdo = DB::create();
	$sqlstr="select ref, date from purchase_order order by ref";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " / " . $rows->date . "</option>";
	}
}

function select_pr($selected){
	$dbpdo = DB::create();
	$sqlstr="select ref, date from purchase_request order by ref";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " / " . $rows->date . "</option>";
	}
}

function select_item_issued($selected){
	$dbpdo = DB::create();
	$sqlstr="select ref, date from item_issued where status='R' order by ref";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " " . $rows->date . "</option>";
	}
}

function select_marketing($selected){
	$dbpdo = DB::create();
	$sqlstr="select code, name from marketing where active=1 order by name";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->code)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->code . $selectdata . ">" . $rows->name . "</option>";
	}
}

function select_employee($selected){
	$dbpdo = DB::create();
	$sqlstr="select id, code, name from employee where active=1 order by name";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->id)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->id . $selectdata . ">" . $rows->code . " " . $rows->name . "</option>";
	}
}

function select_subacc($acc_type, $selected){
	$dbpdo = DB::create();
	$sqlstr="select syscode, acc_code, name from coa where acc_type='$acc_type' order by acc_code";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->syscode)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->syscode . $selectdata . ">" . $rows->acc_code . " " . $rows->name . "</option>";
	}
}

function select_item($selected){
	$dbpdo = DB::create();
	$sqlstr="select syscode, code, name from item where active=1 order by name";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->syscode)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->syscode . $selectdata . ">" . $rows->name . "</option>";
	}
}

function select_sales($selected){
	$dbpdo = DB::create();
	
	$sqlstr="select a.ref, a.date from sales_invoice a order by a.ref";	
		
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " / " . $rows->date . "</option>";
	}
}

function select_payment_type($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'cash' cde, 'Cash' dcr, 0 nmr union all 
		select 'cheque' cde, 'Cheque' dcr, 1 nmr union all 
		select 'giro' cde, 'Bilyet Giro' dcr, 3 nmr union all
		select 'card' cde, 'Credit Card' dcr, 2 nmr union all
        select 'transfer' cde, 'Transfer' dcr, 4 nmr ) a order by nmr";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_receipt_type($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'cash' cde, 'Cash' dcr, 0 nmr union all 
		select 'cheque' cde, 'Cheque' dcr, 1 nmr union all 
		select 'giro' cde, 'Bilyet Giro' dcr, 3 nmr union all
		select 'card' cde, 'Credit Card' dcr, 2 nmr union all
		select 'transfer' cde, 'Transfer' dcr, 4 nmr ) a order by nmr";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_vendor($selected){
	$dbpdo = DB::create();
	$sqlstr="select syscode code, name from vendor where active=1 order by name";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->code)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->code . $selectdata . ">" . $rows->name . "</option>";
	}
}

function select_contact3($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.* from (select id code, concat(name, ' ( ','Employee',' )') name, 'E' type from employee where active=1 union all
		  select syscode code, concat(name,' (',ifnull(phone,''),')') name, 'C' type from client where active=1 and ifnull(name,'') <> '' ) a order by a.name";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->code)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->code . $selectdata . ">" . $rows->name . "</option>";
	}
}


function select_contact2($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.* from (select syscode code, name, 'V' type from vendor where active=1 union all
		  select syscode code, concat(name,' (',ifnull(phone,''),')') name, 'C' type from client where active=1 and ifnull(name,'') <> '' union all select id code, concat(name, ' ( ','Employee',' )') name, 'E' type from employee where active=1  ) a order by a.name";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->code)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->code . $selectdata . ">" . $rows->name . "</option>";
	}
}

function select_contact($type, $selected){
	$dbpdo = DB::create();
	$sqlstr="select a.* from (select id code, name, 'E' type from employee where active=1 union all
		  select syscode code, name, 'V' type from vendor where active=1 union all
		  select syscode code, concat(name,' (',ifnull(phone,''),')') name, 'C' type from client where active=1 and ifnull(name,'') <> '' ) a where a.type='$type' order by a.name";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->code)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->code . $selectdata . ">" . $rows->name . "</option>";
	}
}

function select_conversionfactor($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'M' cde, 'Multiple' dcr union all 
		select 'D' cde, 'Division' dcr) a order by cde";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_uom($selected){
	$dbpdo = DB::create();
	$sqlstr="select code, name from uom order by code";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->code)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->code . $selectdata . ">" . $rows->code . "</option>";
	}
}


function select_uom_pcs($selected){
	$dbpdo = DB::create();
	$sqlstr="select code, name from uom where code='pcs' order by code";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->code)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->code . $selectdata . ">" . $rows->code . "</option>";
	}
}

function select_client_loc($location_id, $selected){
	$dbpdo = DB::create();
	
	if($_SESSION["adm"] == 1) {
		$sqlstr="select syscode code, name, phone from client order by name";	
	} else {
		$sqlstr="select syscode code, name, phone from client where location_id='$location_id' order by name";
	}
	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->code)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->code . $selectdata . ">" . $rows->name . " " . $rows->phone . "</option>";
	}
}

function select_client($selected){
	$dbpdo = DB::create();
	$sqlstr="select syscode code, name, phone from client order by name";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->code)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->code . $selectdata . ">" . $rows->name . " " . $rows->phone . "</option>";
	}
}


function select_transaction($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'sales' cde, 'Sales' dcr union all 
		select 'delivery_order' cde, 'Delivery Order' dcr union all
		select 'sales_return' cde, 'Sales Return' dcr union all
		select 'delivery_return' cde, 'Delivery Return' dcr union all
		select 'receipt' cde, 'Receipt' dcr union all
		select 'payment' cde, 'Payment' dcr union all
		select 'direct_receipt' cde, 'Direct Receipt' dcr union all
		select 'direct_payment' cde, 'Direct Payment' dcr union all
		select 'cash_receipt' cde, 'Cash Receipt' dcr union all
		select 'good_receipt' cde, 'Good Receipt' dcr union all
		select 'purchase_invoice' cde, 'Purchase Invoice' dcr union all
		select 'purchase_quick' cde, 'Quick Purchase' dcr union all
		select 'cash_payment' cde, 'Cash Payment' dcr union all
		select 'purchase_return' cde, 'Purchase Return' dcr) a order by dcr";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_notransaction($tipe,$selected){
	$dbpdo = DB::create();
	
	if ($_SESSION["adm"] == 0) {
		$location_id2 = $_SESSION["location_id2"];
		$where = " and c.location_id = '$location_id2' ";
		
		$sqlstr="select distinct a.ivino from jrn a left join usr b on a.uid=b.usrid left join employee c on b.employee_id=c.id where a.ivitpe='$tipe' " . $where ." order by a.ividte";	
	} else {
		$sqlstr="select distinct a.ivino from jrn a where a.ivitpe='$tipe' order by a.ividte";	
	}
		
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ivino)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ivino . $selectdata . ">" . $rows->ivino . "</option>";
	}
}

function select_week_wage($selected){
	$dbpdo = DB::create();
	$sqlstr="select ref, total from week_wage where type=0 and ifnull(packing_ref	,'')='' order by ref";	
	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " (" . number_format($rows->total, 0, '.', ',') .")". "</option>";
	}
}

function select_week_wage_upd($selected){
	$dbpdo = DB::create();
	$sqlstr="select ref, total from week_wage where type=0 order by ref";	
	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->ref)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->ref . $selectdata . ">" . $rows->ref . " (" . number_format($rows->total, 0, '.', ',') .")". "</option>";
	}
}

function select_costingtype($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'A' cde, 'Average' dcr union all 
		select 'F' cde, 'FIFO' dcr union all 
		select 'L' cde, 'LIFO' dcr) a order by cde";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_store_request_priority($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'L' cde, 'Low' dcr, 1 nomor union all
		select 'N' cde, 'Normal', 0 nomor union all
		select 'H' cde, 'Height', 2 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_store_request_type($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'T' cde, 'Item Transfer' dcr, 0 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_outbound_type($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'T' cde, 'Item Transfer' dcr, 0 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_inbound_type($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'T' cde, 'Item Transfer' dcr, 0 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_contact_type($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'E' cde, 'Employee' dcr, 0 nomor union all 
		select 'V' cde, 'Supplier' dcr, 1 nomor union all
		select 'C' cde, 'Customer' dcr, 2 nomor union all
		select 'O' cde, 'Other' dcr, 3 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_status($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'P' cde, 'Planned' dcr, 1 nomor union all 
		select 'R' cde, 'Released' dcr, 0 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_status_outbound($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'P' cde, 'Planned' dcr, 1 nomor union all 
		select 'R' cde, 'Released' dcr, 0 nomor union all
		select 'C' cde, 'Receipt' dcr, 2 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_status_purchase_invoice($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'P' cde, 'Planned' dcr, 1 nomor union all 
		select 'R' cde, 'Released' dcr, 0 nomor union all
		select 'I' cde, 'Paid in Part' dcr, 2 nomor union all
		select 'F' cde, 'Paid in Full' dcr, 3 nomor ) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_status_purchase_order($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'P' cde, 'Planned' dcr, 1 nomor union all 
		select 'R' cde, 'Released' dcr, 0 nomor union all
		select 'I' cde, 'Invoice Part' dcr, 2 nomor union all
		select 'U' cde, 'Invoice Full' dcr, 3 nomor union all
		select 'V' cde, 'Received Part' dcr, 4 nomor union all
		select 'F' cde, 'Received Complete' dcr, 5 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_status_purchase_request($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'P' cde, 'Planned' dcr, 1 nomor union all 
		select 'R' cde, 'Released' dcr, 0 nomor union all
		select 'O' cde, 'Ordered Part' dcr, 2 nomor union all
		select 'C' cde, 'Ordered Complete' dcr, 3 nomor union all
		select 'V' cde, 'Received Part' dcr, 4 nomor union all
		select 'F' cde, 'Received Complete' dcr, 5 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_status_delivery_order_quick($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'P' cde, 'Planned' dcr, 1 nomor union all 
		select 'R' cde, 'Released' dcr, 0 nomor union all
		select 'I' cde, 'Invoice in Part' dcr, 2 nomor union all
		select 'F' cde, 'Invoice in Full' dcr, 3 nomor union all
		select 'C' cde, 'Closed' dcr, 4 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_status_sales_invoice($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'P' cde, 'Planned' dcr, 1 nomor union all 
		select 'R' cde, 'Released' dcr, 0 nomor union all
		select 'I' cde, 'Paid in Part' dcr, 2 nomor union all
		select 'F' cde, 'Paid in Full' dcr, 3 nomor union all
		select 'V' cde, 'Void' dcr, 4 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_status_cash_invoice($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'P' cde, 'Planned' dcr, 1 nomor union all 
		select 'R' cde, 'Released' dcr, 0 nomor union all
		select 'I' cde, 'Paid in Part' dcr, 2 nomor union all
		select 'F' cde, 'Paid in Full' dcr, 3 nomor union all
		select 'V' cde, 'Void' dcr, 4 nomor union all
		select 'S' cde, 'Shipped in Part' dcr, 5 nomor union all
		select 'E' cde, 'Shipped in Full' dcr, 6 nomor union all
		select 'C' cde, 'Closed' dcr, 7 nomor) a order by nomor";
		
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_status_delivery_order($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'P' cde, 'Planned' dcr, 1 nomor union all 
		select 'R' cde, 'Released' dcr, 0 nomor union all
		select 'I' cde, 'Invoice in Part' dcr, 2 nomor union all
		select 'F' cde, 'Invoice in Full' dcr, 3 nomor union all
		select 'C' cde, 'Closed' dcr, 4 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}


function select_status_sales_order($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select 'P' cde, 'Planned' dcr, 1 nomor union all 
		select 'R' cde, 'Released' dcr, 0 nomor union all
		select 'S' cde, 'Shipped in Part' dcr, 2 nomor union all
		select 'F' cde, 'Shipped in Full' dcr, 3 nomor union all
		select 'C' cde, 'Closed' dcr, 4 nomor) a order by nomor";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_coa($selected){
	$dbpdo = DB::create();
	$sqlstr="select acc_code, syscode, name from coa order by acc_code";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->syscode)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->syscode . $selectdata . ">" . $rows->acc_code . " " . $rows->name . "</option>";
	}
}

function select_currency($selected){
	$dbpdo = DB::create();
	$sqlstr="select code, symbol, name from currency order by code";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->code)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->code . $selectdata . ">" . $rows->symbol . " " . $rows->name . "</option>";
	}
}

function select_maritalstatus($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select '0' cde, 'Single' dcr union all 
		select '1' cde, 'Marriage' dcr) a order by cde";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function select_level($selected){
	$dbpdo = DB::create();
	$sqlstr="select a.cde, a.dcr from 
		(select '0' cde, '0' dcr union all 
		select '1' cde, '1' dcr union all 
		select '2' cde, '2' dcr union all 
		select '3' cde, '3' dcr union all 
		select '4' cde, '4' dcr union all 
		select '5' cde, '5' dcr) a order by cde";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}

function year_select($selected){
	$dbpdo = DB::create();
	
	for ($i=1900; $i<=2035; $i++){
		if ($i==1900) {
			$sqlstr = "select " . $i . " cde, " . $i . " dcr ";
		} else {
			$sql = $sql . " union all select " . $i . " cde, " . $i . " dcr ";	
		}	    
	}
	
	$sqlstr = "select aa.* from (" . $sql . ") aa order by aa.cde";
	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($rows = $sql->fetch(PDO::FETCH_OBJ)){
		$selectdata=(rtrim(ltrim($rows->cde)) == rtrim(ltrim($selected))) ? " selected" : "";	
		echo "<option value=" . $rows->cde . $selectdata . ">" . $rows->dcr . "</option>";
	}
}


#**************************************#
/*
function maxline_stockopname($date, $location_id, $bin, $uid, $item_code, $uom_code, $output='') {
	$sqlstr = "select line from stock_opname_detail where date='$date' and location_id='$location_id' and bin='$bin' and uid='$uid' and item_code='$item_code' and uom_code='$uom_code'' order by line desc limit 1";
	$result = mysql_query($sql);
	$data = mysql_fetch_object($result);
	
	$output = $data->line;
	if($output != "") {
		$output = $output + 1;
	} else {
		$output = 1;
	}
	
	return $output;
}*/

function maxline($table='', $field1='', $field2='', $value='', $output='') {
	$dbpdo = DB::create();
	
	$sqlstr = "select $field1 from $table where $field2='$value' order by $field1 desc limit 1";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$data = $sql->fetch(PDO::FETCH_OBJ);
	
	$output = $data->$field1;
	if($output != "") {
		$output = $output + 1;
	} else {
		$output = 1;
	}
	
	return $output;
}

function numberreplace($string="0") {

	$string = str_replace(",","",(empty($string)) ? 0 : $string);
	
	return $string;	
}

function random($number) 
{
	if ($number)
	{
    	for($i=1;$i<=$number;$i++)
		{
       		$nr=rand(0,25);
       		$total=$total.$nr;
       	}
    	return $total;
	}
}

function petikreplace($string="") {

	$string = str_replace("'","''",$string);
	
	return $string;	
}

function obraxabrix($pwd='', $uid='', $hasil='') {
	$hasil = md5(md5(md5(md5(md5(md5(md5($pwd.$uid.strlen($pwd.$uid)*15)))))));
	
	return $hasil;
}


function signon(){
	//echo "<input type=\"submit\" value=\"Login\" tabindex=\"5\" id=\"login\" name=\"login\" class=\"button roundbutton\"";
	echo "<input type='image' id='login' name='login' value='Login' src='login/images/login.gif'/>";
	//echo "\"/></input><br>";
}

function signout(){
	echo "<input type=\"submit\" value=\"Logout\" tabindex=\"5\" id=\"login\" name=\"login\" class=\"button roundbutton\"";
	echo "\"/></input><br>";
}

function delete_copy() {
	/* makes connection */
	$dbpdo = DB::create();
	/* Creates SQL statement to retrieve the copies using the releaseID */
	$sqlstr = "DELETE FROM $file WHERE $recordid =" . $_POST['ID'];
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$msg[0]="Sorry ERROR in deletion";
	$msg[1]="Record successful DELETED";			
	//AddSuccess($results,$conn,$msg);
	/* Closes connection */
	//mysql_close ($conn);
	/* calls get_data */
	//get_data();
} 
		
class formValidator{
    private $errors=array();
    public function __construct(){}

    // validate empty field
    public function validateEmpty($field,$errorMessage,$min=1	,$max=32){
		if(!isset($_POST[$field])||trim($_POST[$field])==''||strlen($_POST[$field])<$min||strlen($_POST[$field])>$max){
            $this->errors[]=$errorMessage;
        }
    }

    // validate integer field
    public function validateInt($field,$errorMessage){
        if(!isset($_POST[$field])||!is_numeric($_POST[$field])||intval($_POST[$field])!=$_POST[$field]){
            $this->errors[]=$errorMessage;
        }
    }

    // validate numeric field
    public function validateNumber($field,$errorMessage){
        if(!isset($_POST[$field])||!is_numeric($_POST[$field])){
            $this->errors[]=$errorMessage;
        }
    }

    // validate if field is within a range
    public function validateRange($field,$errorMessage,$min=1,$max=99){
        if(!isset($_POST[$field])||$_POST[$field]<$min||$_POST[$field]>$max){
            $this->errors[]=$errorMessage;
        }
    }

    // validate alphabetic field
    public function validateAlphabetic($field,$errorMessage){
        if(!isset($_POST[$field])||!preg_match("/^[a-zA-Z]+$/",$_POST[$field])){
            $this->errors[]=$errorMessage;
        }
    }

    // validate alphanumeric field
    public function validateAlphanum($field,$errorMessage){
        if(!isset($_POST[$field])||!preg_match("/^[a-zA-Z0-9]+$/",$_POST[$field])){
            $this->errors[]=$errorMessage;
        }
    }

    // validate email - does not work on windows machine
    public function validateEmail($field,$errorMessage){
        if(!isset($_POST[$field])||!preg_match("/.+@.+\..+./",$_POST[$field])||!checkdnsrr(array_pop(explode("@",$_POST[$field])),"MX")){
            $this->errors[]=$errorMessage;
        }
    }

    // check for errors
    public function checkErrors(){
        if(count($this->errors)>0){
            return true;
        }
        return false;
    }
	
    // return errors
    public function displayErrors(){
        $errorOutput='<ul>';
        foreach($this->errors as $err){
            $errorOutput.='<li>'.'<font color="#FF0000">'.$err.'</font>'.'</li>';
        }
        $errorOutput.='</ul>';
        return $errorOutput;
    }
}

function AddSuccess($results,&$conn,$msg){
	if ((int) $results==0){
		//should log mysql errors to a file instead of displaying them to the user
		echo 'Invalid query: ' . mysql_errno($conn). "<br>" . ": " . mysql_error($conn). "<br>";
		echo "<div align=\"center\"><h1>$msg[0]</h1></div>";		
	}else{
		echo "<div align=\"center\"><h1>$msg[1]</h1></div>";
		//return(AddSuccess);
	}
}

function paginate($nRecords){
	 $strOffSet=$_SESSION["strOffSet"];
	 switch ($_POST["Navigate"]){
		case "<<":
			$strOffSet=0; //0;
			break;
		case "<":
			if ($strOffSet>$nRecords){
				$strOffSet=$strOffSet-1;				
			}else{
				if ($strOffSet==0) {
					$strOffSet=0;
				} else {
					$strOffSet=$strOffSet-1;
				}
			}
			//$strPage = $strPage==0 ? 1 : $strPage; //checks to see that page numbers don't go to neg
			break;
		case ">":
			if ($strOffSet<$nRecords) {
				if ($strOffSet==$nRecords-1) {
					$strOffSet=$nRecords-1;
				} else {
					$strOffSet=$strOffSet+1;
				}
			} else {
				$strOffSet=$nRecords-1;								
			}	
			break;
		case ">>":
			$strOffSet=$nRecords-1;
			break;
		default:
			$strOffSet = $strOffSet==0 ? 0 : $strOffSet;
	}	
	$_SESSION["strOffSet"]=$strOffSet; //counts offset values
}

function bulan_select($selected){
	$dbpdo = DB::create();
	
	$sqlstr = " select a.* from (
			select 1 kode, 'Januari' bulan union all
			select 2 kode, 'Februari' bulan union all
			select 3 kode, 'Maret' bulan union all
			select 4 kode, 'April' bulan union all
			select 5 kode, 'Mei' bulan union all
			select 6 kode, 'Juni' bulan union all
			select 7 kode, 'Juli' bulan union all
			select 8 kode, 'Agustus' bulan union all
			select 9 kode, 'September' bulan union all
			select 10 kode, 'Oktober' bulan union all
			select 11 kode, 'November' bulan union all
			select 12 kode, 'Desember' bulan ) a order by kode" ;
	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($row = $sql->fetch(PDO::FETCH_OBJ)){
		$SelectedCountry=($row->kode==$selected) ? " selected" : "";		
		echo "<option value=" . $row->kode . $SelectedCountry . ">" . $row->bulan . "</option>";
		//($row->$fields_id==$selected) ? 'selected' : '';
	}
	
}


function tahun_select($selected){
	$dbpdo = DB::create();
	
	$i=2000;
	$sqlthn = "";
	$tahun = date("Y") + 1;
	for($i==2000; $i<=$tahun; $i++) {
		if($i==2000) {
			$sqlthn = "select '$i' kode, '$i' tahun ";	
		} else {
			$sqlthn = $sqlthn . " union all select '$i' kode, '$i' tahun ";
		}
		
	}
	
	$sqlstr = " select a.* from (" . $sqlthn . " ) a order by kode" ;
	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	while ($row = $sql->fetch(PDO::FETCH_OBJ)){
		$SelectedCountry=($row->kode==$selected) ? " selected" : "";		
		echo "<option value=" . $row->kode . $SelectedCountry . ">" . $row->tahun . "</option>";
		//($row->$fields_id==$selected) ? 'selected' : '';
	}
	
}

//--------allow_pos_overlimit
function allow_pos_overlimit($ref='', $limit_approved=''){
	$dbpdo = DB::create();
		 	
	$where = " where a.ref='$ref' and a.limit_approved=1 ";
	
	$sqlstr="select ifnull(a.limit_approved,0) limit_approved from sales_invoice_tmp a " . $where . " order by a.ref limit 1";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$over = $sql->fetch(PDO::FETCH_OBJ);
	$limit_approved = $over->limit_approved;
	
	return $limit_approved;
}

//-----get adm from users
function adm($admc) {
	$lognme=$_SESSION["loginname"];
	$dbpdo = DB::create();
	$sqlstr = "Select administrator from users where loginname = '$lognme' ";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$admin = $sql->fetch(PDO::FETCH_OBJ);
	$admc = $admin->administrator;
	return $admc;
}

//----------------------------------------USER RIGHT
//cek Area Manager
function area_manager_location($location_id='') {
	$dbpdo = DB::create();
	
	$employee_id = $_SESSION["employee_id"];
	$sqlstr = "select location_id from store_unit where manager_id='$employee_id' order by id limit 1";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$data = $sql->fetch(PDO::FETCH_OBJ);
	$location_id = $data->location_id;
		
	return $location_id;
}


//cek Supervisor UNIT
function supervisor_location($location_id='') {
	$dbpdo = DB::create();
	
	$employee_id = $_SESSION["employee_id"];
	$sqlstr = "select location_id from store_unit_detail where supervisor_id='$employee_id' order by id limit 1";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$data = $sql->fetch(PDO::FETCH_OBJ);
	$location_id = $data->location_id;
		
	return $location_id;
}

//cek Supervisor Central
function supervisor_location_central($location_id='') {
	$dbpdo = DB::create();
	
	$employee_id = $_SESSION["employee_id"];
	$sqlstr = "select a.location_id from store_unit a left join store_unit_detail b on a.id=b.id where b.supervisor_id='$employee_id' order by a.id limit 1";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$data = $sql->fetch(PDO::FETCH_OBJ);
	$location_id = $data->location_id;
		
	return $location_id;
}

//cek user Central
function user_location_central($location_id='') {
	$dbpdo = DB::create();
	
	$employee_id = $_SESSION["employee_id"];
	$sqlstr = "select c.location_id from employee a left join store_unit_detail b on a.location_id=b.location_id left join store_unit c on b.id=c.id where a.id='$employee_id' order by a.id limit 1";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$data = $sql->fetch(PDO::FETCH_OBJ);
	$location_id = $data->location_id;
		
	return $location_id;
}

//-----allow ID Computer
function allow_id_comp($allow=0) {
	$dbpdo = DB::create();
	
	$lognme=$_SESSION["userid"];
	$sql = "Select usrid, adm, ifnull(id_comp,0) id_comp from usr where usrid = '$lognme' ";
	$results=$dbpdo->query($sql);
	$userid = $results->fetch(PDO::FETCH_OBJ);
	$id = $userid->usrid;
	$adm = $userid->adm;
	$id_comp = $userid->id_comp;
	
	if($id_comp == 1) {
		$mac_address = $_SERVER['REMOTE_ADDR'];
		$sql2 = "Select id from computer_number where mac_address='$mac_address' and active=1 ";
		$results=$dbpdo->query($sql2);
		$frm = $results->fetch(PDO::FETCH_OBJ);
		
		if ($frm->id != "" ) {
			$allow = 1;
		} else {
			$allow = 0;
		}
	} else {
		$allow = 1;
	}
	
	if ($adm == 1 || $id_comp == 0) {
		$allow = 1;
	}
	
	return $allow;
}

//-----allow reminder
function allow_reminder($menu,$allow=0) {
	$dbpdo = DB::create();
	
	$lognme=$_SESSION["userid"];
	$sql = "Select usrid, adm from usr where usrid = '$lognme' ";
	$results=$dbpdo->query($sql);
	$userid = $results->fetch(PDO::FETCH_OBJ);
	$id = $userid->usrid;
	$adm = $userid->adm;
	
	$sql2 = "Select usrid id from usr_reminder where usrid = '$id' and reminder_id='$menu' ";
	$results=$dbpdo->query($sql2);
	$frm = $results->fetch(PDO::FETCH_OBJ);
	
	if ($frm->id != "" ) {
		$allow = 1;
	} else {
		$allow = 0;
	}
	
	if ($adm == 1) {
		$allow = 1;
	}
	
	return $allow;
}

//-----allow users
function allow($menu,$allow=0) {
	$lognme=$_SESSION["userid"];
	$dbpdo = DB::create();
	$sqlstr = "Select usrid from usr where usrid = '$lognme' ";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$userid = $sql->fetch(PDO::FETCH_OBJ);
	$id = $userid->usrid;
	
	$sqlstr = "Select id from usr_dtl where usrid = '$id' and frmcde='$menu' ";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$frm = $sql->fetch(PDO::FETCH_OBJ);
	
	if ($frm->id != 0) {
		$allow = 1;
	} else {
		$allow = 0;
	}
	return $allow;
}

//-----input users
function allowadd($menu,$add=0) {
	$lognme=$_SESSION["userid"];
	$dbpdo = DB::create();
	$sqlstr = "Select usrid, adm from usr where usrid = '$lognme' ";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$userid = $sql->fetch(PDO::FETCH_OBJ);
	$id = $userid->usrid;
	$adm = $userid->adm;
	
	if ($adm == 1) {
		$add = 1;
	} else {
		$sqlstr = "Select madd from usr_dtl where usrid = '$id' and frmcde='$menu' ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
	
		$frm = $sql->fetch(PDO::FETCH_OBJ);
		$add = $frm->madd;
	}
	return $add;
}

//-----user administrator atau bukan
function user_admin($admin=0) {
	$lognme=$_SESSION["userid"];
	$dbpdo = DB::create();
	$sqlstr = "Select adm from usr where usrid = '$lognme' ";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$userid = $sql->fetch(PDO::FETCH_OBJ);
	$adm = $userid->adm;
	
	if ($adm == 1) {
		$admin = 1;
	} else {
		$admin = 0;
	}
	return $admin;
}

//-----hapus
function allowdel($menu,$del=0) {
	$lognme=$_SESSION["userid"];
	$dbpdo = DB::create();
	$sqlstr = "Select usrid, adm from usr where usrid = '$lognme' ";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$userid = $sql->fetch(PDO::FETCH_OBJ);
	$id = $userid->usrid;
	$adm = $userid->adm;
	
	if ($adm == 1) {
		$del = 1;
	} else {
		$sqlstr = "Select mdel from usr_dtl where usrid = '$id' and frmcde='$menu' ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$frm = $sql->fetch(PDO::FETCH_OBJ);
		$del = $frm->mdel;
	}
	return $del;
}

//-----update
function allowupd($menu,$upd=0) {
	$lognme=$_SESSION["userid"];
	$dbpdo = DB::create();
	$sqlstr = "Select usrid, adm from usr where usrid = '$lognme' ";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$userid = $sql->fetch(PDO::FETCH_OBJ);
	$id = $userid->usrid;
	$adm = $userid->adm;
	
	if ($adm == 1) {
		$upd = 1;
	} else {
		$sqlstr = "Select medt from usr_dtl where usrid = '$id' and frmcde='$menu' ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$frm = $sql->fetch(PDO::FETCH_OBJ);
		$upd = $frm->medt;
	}
	return $upd;
}

//-----AKSES users level
function allowlvl($menu) {
	$lvl = 0;
	$lognme=$_SESSION["userid"];
	$dbpdo = DB::create();
	$sqlstr = "Select usrid, adm from usr where usrid = '$lognme' ";
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$userid = $sql->fetch(PDO::FETCH_OBJ);
	$id = $userid->usrid;
	$adm = $userid->adm;
	
	if ($adm == 1) {
		$lvl = 0;
	} else {
		$sqlstr = "Select lvl from usr_dtl where usrid = '$id' and frmcde='$menu' ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$frm = $sql->fetch(PDO::FETCH_OBJ);
		$lvl = $frm->lvl;
	}
	return $lvl;
}

function epyid($employee='') {
	
	return $employee;
	
}

//-----------metadata image
function readGPSinfoEXIF($image='') {
	//$image = "file_splash/bedanda.jpg";
	$exif=exif_read_data($image, 0, true); //sets a variable with all 
	//the EXIF data

	if(!$exif || $exif['GPS']['GPSLatitude'] == '') {
		//Determines if the 
		//geolocation data exists in the EXIF data
	
		return false; //no GPS Data found
		echo "No GPS DATA in EXIF METADATA";
	} else {
		$lat_ref = $exif['GPS']['GPSLatitudeRef']; 
		$lat = $exif['GPS']['GPSLatitude']; //sets a variable equal 
		//to the Latitude 
		list($num, $dec) = explode('/', $lat[0]); //calculates the Degrees
		$lat_s = $num / $dec;
		list($num, $dec) = explode('/', $lat[1]); //calculates the Minutes
		$lat_m = $num / $dec;
		list($num, $dec) = explode('/', $lat[2]); //calculates the Seconds
		$lat_v = $num / $dec;

		$lon_ref = $exif['GPS']['GPSLongitudeRef']; 
		$lon = $exif['GPS']['GPSLongitude']; //sets the variable for 
		//the longitude 
		list($num, $dec) = explode('/', $lon[0]); //puts the degrees into 
		//a variable
		$lon_s = $num / $dec;
		list($num, $dec) = explode('/', $lon[1]); //puts the minutes into 
		//a variable
		$lon_m = $num / $dec;
		list($num, $dec) = explode('/', $lon[2]); //puts the seconds into 
		//a variable
		$lon_v = $num / $dec;

		//Calculates the GPS location in decimal form.
		$gps_int = array($lat_s + $lat_m / 60.0 + $lat_v / 3600.0, $lon_s 
		+ $lon_m / 60.0 + $lon_v / 3600.0);
		return $gps_int; //returns the coordinates
	}
}

//--------function angka romawi
function romawi($n){
	$hasil = "";
	$iromawi =
				array("","I","II","III","IV","V","VI","VII","VIII","IX","X",
				20=>"XX",30=>"XXX",40=>"XL",50=>"L",60=>"LX",70=>"LXX",80=>"LXXX",
				90=>"XC",100=>"C",200=>"CC",300=>"CCC",400=>"CD",500=>"D",
				600=>"DC",700=>"DCC",800=>"DCCC",900=>"CM",1000=>"M",
				2000=>"MM",3000=>"MMM");
	
	if(array_key_exists($n,$iromawi)){
		$hasil = $iromawi[$n];
	}elseif($n >= 11 && $n <= 99){
		$i = $n % 10;
		$hasil = $iromawi[$n-$i] . Romawi($n % 10);
	}elseif($n >= 101 && $n <= 999){
		$i = $n % 100;
		$hasil = $iromawi[$n-$i] . Romawi($n % 100);
	}else{
		$i = $n % 1000;
		$hasil = $iromawi[$n-$i] . Romawi($n % 1000);
	}
	return $hasil;
}

//-----get transaction name
function transaction_name($transaksi, $hasil='') {
	$aray = array(
		//array transaksi
	   'trans' => array(
	       'sales' => 'Sales',
	       'delivery_order' => 'Delivery Order',
		   'sales_return' => 'Sales Return',
		   'delivery_return' => 'Delivery Return',
		   'receipt' => 'Receipt',
		   'payment' => 'Payment',
		   'direct_receipt' => 'Direct Receipt',
		   'direct_payment' => 'Direct Payment',
		   'cash_receipt' => 'Cash Receipt',
		   'cash_payment' => 'Cash Payment'
	     )
	 );
	$trans2 = $aray['trans']; 
	
	$hasil = $trans2[$transaksi];
	
	return $hasil;
}


//-----format bulan Indonesia
function bulan_indonesia($bulan, $hasil='') {
	$ngaray = array(
		//array bulan
	   'bln' => array(
	       '1' => 'Januari',
	       '2' => 'Pebruari',
		   '3' => 'Maret',
		   '4' => 'April',
		   '5' => 'Mei',
		   '6' => 'Juni',
		   '7' => 'Juli',
		   '8' => 'Agustus',
		   '9' => 'September',
		   '10' => 'Oktober',
		   '11' => 'Nopember',
		   '12' => 'Desember'
	     )
	 );
	$bulan2 = $ngaray['bln']; 
	//print_r($bulan2);
	$hasil = $bulan2[$bulan];
	
	return $hasil;
}

//-----format tanggal Indonesia
function tglindonesia($tgl, $hasil) {
	//$array_hari = array(1=>'Senin','Selasa','Rabu','Kamis','Jumat', 'Sabtu','Minggu');
	//$hari = $array_hari[date('N')];
	$tanggal = date('j', strtotime($tgl));
	$tglbulan = date('n', strtotime($tgl));
	
	$array_bulan = array(1=>'Januari','Februari','Maret', 'April', 'Mei', 'Juni','Juli','Agustus','September','Oktober', 'November','Desember');
	$bulan = $array_bulan[$tglbulan];
	
	$tahun = date('Y', strtotime($tgl));
	
	$hasil = $tanggal.' '.$bulan.' '.$tahun;
	return $hasil;
}

##===============Create Google Translate-----------------Free------
function curl($url, $params = array(), $is_coockie_set = false){
    if(!$is_coockie_set){
        /* STEP 1. buat temporary cookie untuk mengelabuhi google translate */
        $ckfile = tempnam ("/tmp", "CURLCOOKIE");
        /* STEP 2. masuk cookie */
        $ch = curl_init ($url);
        curl_setopt ($ch, CURLOPT_COOKIEJAR, $ckfile);
        curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
        $output = curl_exec ($ch);
    }
    $str = ''; $str_arr= array();
    foreach($params as $key => $value)   {
        $str_arr[] = urlencode($key)."=".urlencode($value);
    }
    if(!empty($str_arr)) $str = '?'.implode('&',$str_arr);
    /* STEP 3. melihat isi dari cookie */
    $Url = $url.$str;
    $ch = curl_init ($Url);
    curl_setopt ($ch, CURLOPT_COOKIEFILE, $ckfile);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec ($ch);
    return $output;
}

function translate_en($word){
    $word = urlencode($word);
    // bahasa jepang
    //$url = 'http://translate.google.com/translate_a/t?client=t&text='.$word.'&hl=en&sl=ja&tl=id&ie=UTF-8&oe=UTF-8&multires=1&otf=2&pc=1&ssel=0&tsel=0&sc=1';
     
    // bahasa inggris
    //$url = 'http://translate.google.com/translate_a/t?client=t&text='.$word.'&hl=en&sl=en&tl=id&multires=1&otf=2&pc=1&ssel=0&tsel=0&sc=1';
	// bahasa indonesia ke inggris
	$url = 'http://translate.google.com/translate_a/t?client=t&text='.$word.'&hl=id&sl=id&tl=en&multires=1&otf=2&pc=1&ssel=0&tsel=0&sc=1';	
    $name_en = curl($url);
    $name_en = explode('"',$name_en);
    return  $name_en[1];
}
##==================================================================

//-----untuk create notran otomatis
function notran($tanggal, $frmcode, $save, $ref, $vardms='') {
	$dbpdo = DB::create();
	
	$yy = date('y', strtotime($tanggal));
	$mm = date('m', strtotime($tanggal));
	$yymm = $yy.$mm;
	
	$frmcode = $vardms.$frmcode;
	
	if($frmcode == $vardms."frmpos_pos" || $frmcode == $vardms."frmpurchase_inv_pos" ) {
		$yy = date('y', strtotime($tanggal));
		$mm = date('m', strtotime($tanggal));
		$day = date('d', strtotime($tanggal));
		$yymm = $yy.$mm.$day;
		
	}
	
	$ref_q = "Select nbr, alp From ref where frmcde='$frmcode' And yymm='$yymm' ";
	
	
	if($frmcode == "frmasset") {
		$ref_q = "Select nbr, alp From ref where frmcde='$frmcode' ";
	}
	if($frmcode == $vardms."frmitembarcode") {
		$ref_q = "Select nbr, alp From ref where frmcde='$frmcode' ";
	}
	$sql=$dbpdo->prepare($ref_q);
	$sql->execute();
	$ref_d = $sql->fetch(PDO::FETCH_OBJ);
	
	$nbr = $ref_d->nbr;
	$alp = $ref_d->alp;


	if ($alp=='') {
		
		if (trim($frmcode)== $vardms.'frmitem_packing') { $ref = 'RPK-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frminbound') { $ref = 'INB-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmoutbound_pos') { $ref = 'OTB-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmstore_request') { $ref = 'SRQ-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmstock_opname_pos') { $ref = 'STO-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frminvent_adjust') { $ref = 'ADJ-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmitem_issued') { $ref = 'ISU-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmitem_return') { $ref = 'ITR-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmpurchase_request') { $ref = 'PRQ-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmpurchase_order') { $ref = 'POR-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmgood_receipt') { $ref = 'GOR-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmpurchase_invoice') { $ref = 'PIN-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmquotation') { $ref = 'QTN-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmsales_order') { $ref = 'SLO-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmdelivery_order') { $ref = 'DOR-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmsales_invoice') { $ref = 'SOI-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmsales_return') { $ref = 'SIR-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmpurchase_return') { $ref = 'PIR-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmpurchase_return_quick') { $ref = 'PUR-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmgood_return') { $ref = 'GRN-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmdelivery_return') { $ref = 'DRN-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmreceipt') { $ref = 'RCI-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmpayment') { $ref = 'PMT-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmpurchase_quick') { $ref = 'PIQ-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmpurchase_issue') { $ref = 'PII-'.$mm.$yy.'-00001'; }	
		if (trim($frmcode)== $vardms.'frmpurchase_inv_pos') { $ref = 'POV-'.$day.$mm.$yy.'-00001'; }	
		
		if (trim($frmcode)== $vardms.'frmcash_invoice') { $ref = $vardms.'CSH-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmdelivery_order_quick') { $ref = $vardms.'DOQ-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmdirect_payment') { $ref = $vardms.'DPM-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmdirect_receipt') { $ref = $vardms.'DRC-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmcash_invoice2') { $ref = $vardms.'INV-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmdelivery_order_project') { $ref = $vardms.'DOP-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmsales_invoice_project') { $ref = $vardms.'PIV-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmcash_receipt') { $ref = $vardms.'CRP-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmcash_payment') { $ref = $vardms.'CPM-'.$mm.$yy.'-00001'; }
		if (trim($frmcode)== $vardms.'frmweek_wage') { $ref = $vardms.'WEG-'.$mm.$yy.'-00001'; }
        if (trim($frmcode)== $vardms.'frmasset') { $ref = $vardms.'AST-'.'00001'; }
        if (trim($frmcode)== $vardms.'frmasset_trans') { $ref = $vardms.'ATR-'.$mm.$yy.'-00001'; }
        if (trim($frmcode)== $vardms.'frmcashier_pos') { $ref = $vardms.'CSR-'.$mm.$yy.'-00001'; }
        if (trim($frmcode)== $vardms.'frmcashier_box_pos') { $ref = $vardms.'CSB-'.$mm.$yy.'-00001'; }
        if (trim($frmcode)== $vardms.'frmclient_pos') { $ref = $vardms.'CUS-'.$mm.$yy.'-00001'; }
        if (trim($frmcode)== $vardms.'frmorder_stock') { $ref = $vardms.'OSK-'.$mm.$yy.'-00001'; }
                
        if (trim($frmcode)== $vardms.'frmpos_pos') { 
        	
        	$uid		=	$_SESSION["loginname"];
        	$yymm_pos 	= 	$day.$mm.$yy;        	
        	$sqlstr = "select (right(ref,5) + 1) nomor from sales_invoice where left(right(ref,12),6)='$yymm_pos' and uid='$uid' order by right(ref,5) desc limit 1";
        	$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$rowspos = $sql->rowCount();
			$datapos = $sql->fetch(PDO::FETCH_OBJ);
        	if($rowspos == 0) {
				$ref = $vardms.'POS-'.$day.$mm.$yy.'-00001'; 
			} else {
				$alp_temp = $datapos->nomor;		
				if (strlen($alp_temp)==4) { $alp_temp = '0'.$alp_temp;}
				if (strlen($alp_temp)==3) { $alp_temp = '00'.$alp_temp;}
				if (strlen($alp_temp)==2) { $alp_temp = '000'.$alp_temp;}
				if (strlen($alp_temp)==1) { $alp_temp = '0000'.$alp_temp;}
				
				$ref = $vardms.'POS-'.$day.$mm.$yy.'-'.$alp_temp; 
			}
        	
        }
        
        if (trim($frmcode)== $vardms.'frmitembarcode') { $ref = $vardms.'0001'; }
        
        		
		if ($save == 1) {
			$sv = "insert into ref(frmcde, nbr, yymm, alp) values ('$frmcode', '1', '$yymm', 'A')";
			$sql=$dbpdo->prepare($sv);
			$sql->execute();
		}
	} else {
		$ref_alp = $alp;
		$ref_nbr = $nbr + 1;
		
		if ($ref_nbr > 99999) {
			$ref_nbr = 1;
			if ($alp=='A') { $ref_alp = 'B'; }
			if ($alp=='B') { $ref_alp = 'C'; }
			if ($alp=='C') { $ref_alp = 'D'; }
			if ($alp=='D') { $ref_alp = 'E'; }
			if ($alp=='E') { $ref_alp = 'F'; }
			if ($alp=='F') { $ref_alp = 'G'; }
			if ($alp=='G') { $ref_alp = 'H'; }
			if ($alp=='H') { $ref_alp = 'I'; }
			if ($alp=='I') { $ref_alp = 'J'; }
			if ($alp=='J') { $ref_alp = 'K'; }
			if ($alp=='K') { $ref_alp = 'L'; }
			if ($alp=='L') { $ref_alp = 'M'; }
			if ($alp=='N') { $ref_alp = 'O'; }
			if ($alp=='O') { $ref_alp = 'P'; }
			if ($alp=='P') { $ref_alp = 'Q'; }
			if ($alp=='Q') { $ref_alp = 'R'; }
			if ($alp=='R') { $ref_alp = 'S'; }
			if ($alp=='S') { $ref_alp = 'T'; }
			if ($alp=='T') { $ref_alp = 'U'; }
			if ($alp=='U') { $ref_alp = 'V'; }
			if ($alp=='V') { $ref_alp = 'W'; }
			if ($alp=='W') { $ref_alp = 'X'; }
			if ($alp=='X') { $ref_alp = 'Y'; }
			if ($alp=='Y') { $ref_alp = 'Z'; }
			if ($alp=='Z') { $ref_alp = 'A'; }
		}
		
		$alp_temp = $ref_nbr;
		
		if (strlen($alp_temp)==4) { $alp_temp = '0'.$alp_temp;}
		if (strlen($alp_temp)==3) { $alp_temp = '00'.$alp_temp;}
		if (strlen($alp_temp)==2) { $alp_temp = '000'.$alp_temp;}
		if (strlen($alp_temp)==1) { $alp_temp = '0000'.$alp_temp;}
		if (trim($frmcode)== $vardms.'frmitembarcode') {
			
			$alp_temp = $ref_nbr;
			
			if (strlen($alp_temp)==4) { $alp_temp = ''.$alp_temp;}
			if (strlen($alp_temp)==3) { $alp_temp = '0'.$alp_temp;}
			if (strlen($alp_temp)==2) { $alp_temp = '00'.$alp_temp;}
			if (strlen($alp_temp)==1) { $alp_temp = '000'.$alp_temp;}
		}		
		
		if (trim($frmcode)== $vardms.'frmitem_packing') { $ref = 'RPK-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frminbound') { $ref = 'INB-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmoutbound_pos') { $ref = 'OTB-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmstore_request') { $ref = 'SRQ-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmstock_opname_pos') { $ref = 'STO-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frminvent_adjust') { $ref = 'ADJ-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmitem_issued') { $ref = 'ISU-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmitem_return') { $ref = 'ITR-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmpurchase_request') { $ref = 'PRQ-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmpurchase_order') { $ref = 'POR-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmgood_receipt') { $ref = 'GOR-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmpurchase_invoice') { $ref = 'PIN-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmquotation') { $ref = 'QTN-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmsales_order') { $ref = 'SLO-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmdelivery_order') { $ref = 'DOR-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmsales_invoice') { $ref = 'SOI-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmsales_return') { $ref = 'SIR-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmpurchase_return') { $ref = 'PIR-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmpurchase_return_quick') { $ref = 'PUR-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmgood_return') { $ref = 'GRN-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmdelivery_return') { $ref = 'DRN-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmreceipt') { $ref = 'RCI-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmpayment') { $ref = 'PMT-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmpurchase_quick') { $ref = 'PIQ-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmpurchase_issue') { $ref = 'PII-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmpurchase_inv_pos') { $ref = 'POV-'.$day.$mm.$yy.'-'.$alp_temp; }
			
		
		if (trim($frmcode)== $vardms.'frmcash_invoice') { $ref = $vardms.'CSH-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmdelivery_order_quick') { $ref = $vardms.'DOQ-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmdirect_payment') { $ref = $vardms.'DPM-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmdirect_receipt') { $ref = $vardms.'DRC-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmcash_invoice2') { $ref = $vardms.'INV-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmdelivery_order_project') { $ref = $vardms.'DOP-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmsales_invoice_project') { $ref = $vardms.'PIV-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmcash_receipt') { $ref = $vardms.'CRP-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmcash_payment') { $ref = $vardms.'CPM-'.$mm.$yy.'-'.$alp_temp; }
		if (trim($frmcode)== $vardms.'frmweek_wage') { $ref = $vardms.'WEG-'.$mm.$yy.'-'.$alp_temp; }
        if (trim($frmcode)== $vardms.'frmasset') { $ref = $vardms.'AST-'.$alp_temp; }
        if (trim($frmcode)== $vardms.'frmasset_trans') { $ref = $vardms.'ATR-'.$mm.$yy.'-'.$alp_temp; }
        if (trim($frmcode)== $vardms.'frmcashier_pos') { $ref = $vardms.'CSR-'.$mm.$yy.'-'.$alp_temp; }
        if (trim($frmcode)== $vardms.'frmcashier_box_pos') { $ref = $vardms.'CSB-'.$mm.$yy.'-'.$alp_temp; }
        if (trim($frmcode)== $vardms.'frmclient_pos') { $ref = $vardms.'CUS-'.$mm.$yy.'-'.$alp_temp; }
        if (trim($frmcode)== $vardms.'frmorder_stock') { $ref = $vardms.'OSK-'.$mm.$yy.'-'.$alp_temp; }
                
        if (trim($frmcode)== $vardms.'frmpos_pos') { 
        	
        	$uid		=	$_SESSION["loginname"];
        	$yymm_pos 	= 	$day.$mm.$yy;        	
        	$sqlstr = "select (right(ref,5) + 1) nomor from sales_invoice where left(right(ref,12),6)='$yymm_pos' and uid='$uid' order by right(ref,5) desc limit 1";
        	$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$rowspos = $sql->rowCount();
			$datapos = $sql->fetch(PDO::FETCH_OBJ);
        	if($rowspos == 0) {
				$ref = $vardms.'POS-'.$day.$mm.$yy.'-00001'; 
			} else {
				$alp_temp = $datapos->nomor;		
				if (strlen($alp_temp)==4) { $alp_temp = '0'.$alp_temp;}
				if (strlen($alp_temp)==3) { $alp_temp = '00'.$alp_temp;}
				if (strlen($alp_temp)==2) { $alp_temp = '000'.$alp_temp;}
				if (strlen($alp_temp)==1) { $alp_temp = '0000'.$alp_temp;}
				
				$ref = $vardms.'POS-'.$day.$mm.$yy.'-'.$alp_temp; 
			}
			
        	 
        }
        
        if (trim($frmcode)== $vardms.'frmitembarcode') { $ref = $vardms.$alp_temp; }
        
		
		if ($save==1) {		
		
			if($frmcode == "frmasset") {
				$upd = "update ref set nbr='$ref_nbr', alp='$ref_alp' Where frmcde='$frmcode' ";
				$sql=$dbpdo->prepare($upd);
				$sql->execute();
			} else if($frmcode == $vardms."frmitembarcode") {
				$upd = "update ref set nbr='$ref_nbr', alp='$ref_alp' Where frmcde='$frmcode' ";
				$sql=$dbpdo->prepare($upd);
				$sql->execute();
			} else if($frmcode == $vardms."frmpos_pos" || $frmcode == $vardms."frmpurchase_inv_pos" ) {
				$yy = date('y', strtotime($tanggal));
				$mm = date('m', strtotime($tanggal));
				$day = date('d', strtotime($tanggal));
				$yymm = $yy.$mm.$day;
				$upd = "update ref set nbr='$ref_nbr', alp='$ref_alp' Where frmcde='$frmcode' and yymm='$yymm'";
				$sql=$dbpdo->prepare($upd);
				$sql->execute();
			} else {
				$upd = "update ref set nbr='$ref_nbr', alp='$ref_alp' Where frmcde='$frmcode' and yymm='$yymm'";
				$sql=$dbpdo->prepare($upd);
				$sql->execute();
			}
			
	
		}
	}
		
	return $ref;
}
?>