<?php

class update{

	//------update user
	function update_usr($ref,$photo){
		$dbpdo = DB::create();
		
		try {
			
			$usrid		=	$_POST["usrid"];
			$old_usrid	=	$_POST["old_usrid"];				
			$pass_ori	=	$_POST["pwd"];
			$pwd		=	obraxabrix($pass_ori, $usrid);
			$adm		=	(empty($_POST["adm"])) ? 0 : $_POST["adm"];
			$employee_id=	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$lvl		=	$_POST["lvl"];
			//$image		=	$_POST["image"];
			$brncde		=	$_POST["brncde"];
			$image2		=	$_POST["image2"];
			$uid		=	$_SESSION["loginname"];
			$dlu		=	date("Y-m-d H:i:s");
			$act		=	(empty($_POST["act"])) ? 0 : $_POST["act"];
			
			//-----------upload file
		  	$photo2	= $_POST["photo2"];
			$uploaddir_photo = 'app/photo_usr/';
			$photo		= $_FILES['photo']['name']; 
			$tmpname_photo 	= $_FILES['photo']['tmp_name'];
			$filesize_photo 	= $_FILES['photo']['size'];
			$filetype_photo 	= $_FILES['photo']['type'];
			
			if (empty($photo)) { 
				$photo = $photo2; 
			} else {
				$photo = $photo;
			}
			
			if($photo != "") {
					
				if($photo != $photo2) {
					
					if(!empty($photo2)) {
						unlink($uploaddir_photo . $photo2); //remove file 
					}
					
					$photo = $usrid . '_' . $photo;
				}
				$uploaddir_photo = $uploaddir_photo . $photo;		
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir_photo)) {
					echo "";											
				} 	
			}	
			//----------------
			
			if ($_POST["pwd"]=='') {		
				$sqlstr="update usr set usrid='$usrid',adm='$adm', employee_id='$employee_id', photo='$photo', act='$act',uid='$uid',dlu='$dlu' where id='$ref' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				$sqlstr="update usr set usrid='$usrid',pwd='$pwd',adm='$adm', employee_id='$employee_id', photo='$photo', act='$act',uid='$uid',dlu='$dlu' where id='$ref' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			
			
			//----------insert user detail
			$usr_jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=1; $i<=$usr_jmldata; $i++) {
				$usr_slc = (empty($_POST[usr_slc_.$i])) ? 0 : $_POST[usr_slc_.$i];
				$usr_old = (empty($_POST[usr_old_.$i])) ? 0 : $_POST[usr_old_.$i];
				
				$usr_frmcde = $_POST[usr_frmcde_.$i];
				$usr_add = (empty($_POST[usr_add_.$i])) ? 0 : $_POST[usr_add_.$i];
				$usr_edt = (empty($_POST[usr_edt_.$i])) ? 0 : $_POST[usr_edt_.$i];
				$usr_dlt = (empty($_POST[usr_dlt_.$i])) ? 0 : $_POST[usr_dlt_.$i];
				$usr_lvl = (empty($_POST[usr_lvl_.$i])) ? 0 : $_POST[usr_lvl_.$i];
				
				if ($usr_old==1) {
					if ($usr_slc==1) {
						$sqlstr="update usr_dtl set usrid='$usrid', madd=$usr_add, medt=$usr_edt, mdel=$usr_dlt, lvl=$usr_lvl where usrid='$old_usrid' and frmcde='$usr_frmcde' ";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
					} else {
						$sqlstr="delete from usr_dtl where usrid='$old_usrid' and frmcde='$usr_frmcde' ";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
					}	
				} 
				
				
				if ($usr_old==0) {
				
					if ($usr_slc==1) {			
						$sqlstr="insert into usr_dtl
						(usrid, frmcde, madd, medt, mdel, lvl)
							values
							(
								'".$usrid."',
								'".$usr_frmcde."',
								".$usr_add.",
								".$usr_edt.",
								".$usr_dlt.",
								'".$usr_lvl."'
							)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
				}
				
			}
				
			//-------update user backup
			if ($_POST["pwd"]=='') {		
				$sqlstr="update usr_bup set usrid='$usrid' where usrid='$old_usrid' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				$sqlstr="update usr_bup set usrid='$usrid',pwd='$_POST[pwd]' where usrid='$old_usrid' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update company
	function update_company($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	petikreplace($_POST["name"]); //str_replace("'","''",$_POST["name"]);
			$businiss_type	=	$_POST["businiss_type"];
			$address1		=	$_POST["address1"];
			$address2		=	$_POST["address2"];
			$phone1			=	$_POST["phone1"];
			$phone2			=	$_POST["phone2"];
			$fax			=	$_POST["fax"];
			$city			=	$_POST["city"];
			$country		=	$_POST["country"];
			$web			=	$_POST["web"];
			$email			=	$_POST["email"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update company set name='$name', businiss_type='$businiss_type', address1='$address1', address2='$address2', phone1='$phone1', phone2='$phone2', fax='$fax', city='$city', country='$country', web='$web', email='$email', active='$active', uid='$uid', dlu='$dlu' where id='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}

	//-----update position
	function update_position($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	petikreplace($_POST["name"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update position set name='$name', uid='$uid', dlu='$dlu', active='$active' where id='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update department
	function update_department($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	petikreplace($_POST["name"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update department set name='$name', uid='$uid', dlu='$dlu', active='$active' where id='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update division
	function update_division($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	petikreplace($_POST["name"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update division set name='$name', uid='$uid', dlu='$dlu', active='$active' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update employee
	function update_employee($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	$_POST["code"];
			$name			=	petikreplace($_POST["name"]);
			$nick_name		=	petikreplace($_POST["nick_name"]);
			$born			=	petikreplace($_POST["born"]);
			$birth_date		=	date("Y-m-d", strtotime($_POST["birth_date"]));
			$marital_status	=	(empty($_POST["marital_status"])) ? 0 : $_POST["marital_status"];
			$religion_id	=	(empty($_POST["religion_id"])) ? 0 : $_POST["religion_id"];
			$address		=	petikreplace($_POST["address"]);
			$zip_code		=	$_POST["zip_code"];
			$country_id		=	(empty($_POST["country_id"])) ? 0 : $_POST["country_id"];
			$state_id		=	(empty($_POST["state_id"])) ? 0 : $_POST["state_id"];
			$phone			=	$_POST["phone"];
			$email			=	$_POST["email"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			//-----------upload file
		  	$photo2			= $_POST["photo2"];
			$uploaddir_photo= 'app/photo_employee/';
			$photo			= $_FILES['photo']['name']; 
			$tmpname_photo 	= $_FILES['photo']['tmp_name'];
			$filesize_photo = $_FILES['photo']['size'];
			$filetype_photo = $_FILES['photo']['type'];
			
			if (empty($photo)) { 
				$photo = $photo2; 
			} else {
				$photo = $photo;
			}
			
			if($photo != "") {
					
				if($photo != $photo2) {
					
					if(!empty($photo2)) {
						unlink($uploaddir_photo . $photo2); //remove file 
					}
					
					$photo = $code . '_' . $photo;
				}
				$uploaddir_photo = $uploaddir_photo . $photo;		
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir_photo)) {
					echo "";											
				} 	
			}	
			//----------------
			
			$position_id	=	(empty($_POST["position_id"])) ? 0 : $_POST["position_id"];
			$department_id	=	(empty($_POST["department_id"])) ? 0 : $_POST["department_id"];
			$division_id	=	(empty($_POST["division_id"])) ? 0 : $_POST["division_id"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			
			$sqlstr="update employee set code='$code', name='$name', nick_name='$nick_name', born='$born', birth_date='$birth_date', marital_status='$marital_status', religion_id='$religion_id', address='$address', zip_code='$zip_code', country_id='$country_id', state_id='$state_id', phone='$phone', email='$email', photo='$photo', position_id='$position_id', department_id='$department_id', division_id='$division_id', location_id='$location_id', active='$active', uid='$uid', dlu='$dlu' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update coa
	function update_coa($ref){
		$dbpdo = DB::create();
		
		try {
			
			$acc_code			=	$_POST["acc_code"];
			$name				=	$_POST["name"];
			$acc_type			=	(empty($_POST["acc_type"])) ? 0 : $_POST["acc_type"];
			$postable			=	(empty($_POST["postable"])) ? 0 : $_POST["postable"];
			$subacc_code		=	$_POST["subacc_code"];
			
			$opening_balance_old=	numberreplace((empty($_POST["opening_balance_old"])) ? 0 : $_POST["opening_balance_old"]);
			$opening_balance	=	numberreplace((empty($_POST["opening_balance"])) ? 0 : $_POST["opening_balance"]);
			$opening_balance_date	= date("Y-m-d", strtotime($_POST["opening_balance_date"]));
			//$current_balance	=	(empty($_POST["current_balance"])) ? 0 : $_POST["current_balance"];
			//$current_balance	= 	$current_balance - $opening_balance_old + $opening_balance;
			
			$currency_code		=	(empty($_POST["currency_code"])) ? 0 : $_POST["currency_code"];
			$currency_rate		=	(empty($_POST["currency_rate"])) ? 0 : $_POST["currency_rate"];
			$currency_exchange_id		=	(empty($_POST["currency_exchange_id"])) ? 0 : $_POST["currency_exchange_id"];
			$level			=	(empty($_POST["level"])) ? 0 : $_POST["level"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update coa set acc_code='$acc_code', name='$name', acc_type='$acc_type', postable='$postable', subacc_code='$subacc_code', opening_balance='$opening_balance', opening_balance_date='$opening_balance_date', current_balance=ifnull(current_balance,0) - $opening_balance_old + $opening_balance, currency_code='$currency_code', currency_rate='$currency_rate', currency_exchange_id='$currency_exchange_id', level='$level', uid='$uid', dlu='$dlu', active='$active' where syscode='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
		
	//-----update item type
	function update_item_type($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	$_POST["code"];		
			$name			=	$_POST["name"];		
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_syscode	 	= $_POST[old_syscode_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$inventory_acccode		=	$_POST[inventory_acccode_.$i];
				$productcost_acccode	=	$_POST[productcost_acccode_.$i];
				$goodintransit_acccode	=	$_POST[goodintransit_acccode_.$i];
				$workinprocess_acccode	=	$_POST[workinprocess_acccode_.$i];
				$cogs_acccode			=	$_POST[cogs_acccode_.$i];
				$location_id			=	(empty($_POST[location_id_.$i])) ? 0 : $_POST[location_id_.$i];
				
				if ( $location_id > 0 ) {
					
					$sqlstr = "select syscode from item_type_detail where syscode_header='$ref' and syscode='$old_syscode' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update item_type_detail set code='$code', inventory_acccode='$inventory_acccode', productcost_acccode='$productcost_acccode', goodintransit_acccode='$goodintransit_acccode', workinprocess_acccode='$workinprocess_acccode', cogs_acccode='$cogs_acccode', location_id='$location_id' where syscode_header='$ref' and syscode='$old_syscode' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						} else {
							$sqlstr="delete from item_type_detail where syscode_header='$ref' and syscode='$old_syscode' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
						
					} else {
						$syscode2	= 	random(9);
						
						$line = maxline('item_type_detail', 'line', 'syscode_header', $ref, '');
					
						$sqlstr="insert into item_type_detail (code, syscode_header, inventory_acccode, productcost_acccode, goodintransit_acccode, workinprocess_acccode, cogs_acccode, location_id, line, syscode) values ('$code', '$ref', '$inventory_acccode', '$productcost_acccode', '$goodintransit_acccode', '$workinprocess_acccode', '$cogs_acccode', '$location_id', '$line', '$syscode2')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
											
					}
					
				}
			}
			
			
			$sqlstr="update item_type set code='$code', name='$name', inventory_acccode='$inventory_acccode', productcost_acccode='$productcost_acccode', goodintransit_acccode='$goodintransit_acccode', workinprocess_acccode='$workinprocess_acccode', cogs_acccode='$cogs_acccode', location_id='$location_id', active='$active', uid='$uid', dlu='$dlu' where syscode='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update uom
	function update_uom($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	$_POST["code"];
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update uom set name='$name', active='$active', uid='$uid', dlu='$dlu' where code='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update item group
	function update_item_group($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code					=	$_POST["code"];
			$name					=	$_POST["name"];
			$costing_type			=	$_POST["costing_type"];
			$nonstock				=	(empty($_POST["nonstock"])) ? 0 : $_POST["nonstock"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			
			//----------update  detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_id		 	= (empty($_POST[old_id_.$i])) ? 0 : $_POST[old_id_.$i];
				$old_line	 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$inventory_acccode		=	$_POST[inventory_acccode_.$i];
				$purchase_discount_acccode	=	$_POST[purchase_discount_acccode_.$i];
				$goodintransit_acccode	=	$_POST[goodintransit_acccode_.$i];
				$workinprocess_acccode	=	$_POST[workinprocess_acccode_.$i];
				$cogs_acccode			=	$_POST[cogs_acccode_.$i];
				$consignment_acccode	=	$_POST[consignment_acccode_.$i];
				$location_id	=	(empty($_POST[location_id_.$i])) ? 0 : $_POST[location_id_.$i];
				
				if ( $location_id > 0 ) {
					
					$sqlstr = "select id from item_group_detail where id_header='$ref' and id='$old_id' and line='$old_line' ";			
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update item_group_detail set inventory_acccode='$inventory_acccode', purchase_discount_acccode='$purchase_discount_acccode', goodintransit_acccode='$goodintransit_acccode', workinprocess_acccode='$workinprocess_acccode', cogs_acccode='$cogs_acccode', consignment_acccode='$consignment_acccode', location_id='$location_id' where id_header='$ref' and id='$old_id' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						} else {
							$sqlstr="delete from item_group_detail where id_header='$ref' and id='$old_id' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
						
					} else {
						
						$line = maxline('item_group_detail', 'line', 'id_header', $ref, '');
					
						$sqlstr="insert into item_group_detail (id_header, inventory_acccode, purchase_discount_acccode, goodintransit_acccode, workinprocess_acccode, cogs_acccode, consignment_acccode, location_id, line) values ('$ref', '$inventory_acccode', '$purchase_discount_acccode', '$goodintransit_acccode', '$workinprocess_acccode', '$cogs_acccode', '$consignment_acccode', '$location_id', '$line')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
											
					}
					
				}
			}
			
			
			$sqlstr="update item_group set code='$code', name='$name', nonstock='$nonstock', costing_type='$costing_type', inventory_acccode='$inventory_acccode', purchase_discount_acccode='$purchase_discount_acccode', goodintransit_acccode='$goodintransit_acccode', workinprocess_acccode='$workinprocess_acccode', cogs_acccode='$cogs_acccode', consignment_acccode='$consignment_acccode', location_id='$location_id', active='$active', uid='$uid', dlu='$dlu' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			
			/*---------insert audit trail (insert)------------*/
			$sqlstr="insert into adt_item_group (id, code, name, nonstock, costing_type, inventory_acccode, purchase_discount_acccode, goodintransit_acccode, workinprocess_acccode, cogs_acccode, consignment_acccode, location_id, active, uid, dlu, adt_status) values('$ref', '$code', '$name', '$nonstock', '$costing_type', '$inventory_acccode', '$purchase_discount_acccode', '$goodintransit_acccode', '$workinprocess_acccode', '$cogs_acccode', '$consignment_acccode', '$location_id', '$active', '$uid', '$dlu', 'update')";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update item sub group
	function update_item_subgroup($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	$_POST["name"];
			$item_group_id	=	(empty($_POST["item_group_id"])) ? 0 : $_POST["item_group_id"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update item_subgroup set name='$name', item_group_id='$item_group_id', active='$active', uid='$uid', dlu='$dlu' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update reason to adjust
	function update_reason_adjust($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update reason_adjust set name='$name', active='$active', uid='$uid', dlu='$dlu' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update warehouse
	function update_warehouse($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	$_POST["code"];
			$name			=	$_POST["name"];
			$address		=	$_POST["address"];
			$email			=	$_POST["email"];
			$phone			=	$_POST["phone"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update warehouse set code='$code', name='$name', address='$address', email='$email', phone='$phone', active='$active', uid='$uid', dlu='$dlu' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update uom conversion
	function update_uom_conversion($ref){
		$dbpdo = DB::create();
		
		try {
			
			$uom_code1		=	$_POST["uom_code1"];
			$uom_code2		=	$_POST["uom_code2"];
			$conversion		=	$_POST["conversion"];
			$factor			=	numberreplace($_POST["factor"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update uom_conversion set uom_code1='$uom_code1', uom_code2='$uom_code2', conversion='$conversion', factor='$factor', uid='$uid', dlu='$dlu' where syscode='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update colour
	function update_colour($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
	        
			$sqlstr="update colour set name='$name', uid='$uid', dlu='$dlu', active='$active' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update brand
	function update_brand($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	$_POST["code"];
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update brand set code='$code', name='$name', uid='$uid', dlu='$dlu', active='$active' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update size
	function update_size($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	$_POST["code"];
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update size set code='$code', name='$name', uid='$uid', dlu='$dlu', active='$active' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update item category
	function update_item_category($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	$_POST["code"];
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update item_category set code='$code', name='$name', uid='$uid', dlu='$dlu', active='$active' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update item
	function update_item($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	$_POST["code"];
			$old_code		=	$_POST["old_code"];
			$name			=	petikreplace($_POST["name"]);
			$item_group_id	=	(empty($_POST["item_group_id"])) ? 0 : $_POST["item_group_id"];
			$item_subgroup_id	=	(empty($_POST["item_subgroup_id"])) ? 0 : $_POST["item_subgroup_id"];
			$item_type_code		=	$_POST["item_type_code"];
			$item_category_id	=	(empty($_POST["item_category_id"])) ? 0 : $_POST["item_category_id"];
			$brand_id			=	(empty($_POST["brand_id"])) ? 0 : $_POST["brand_id"];
			$size_id			= $_POST["size_id"];  //	(empty($_POST["size_id"])) ? 0 : $_POST["size_id"];
			$uom_code_stock		=	$_POST["uom_code_stock"];
			$uom_code_sales		=	$_POST["uom_code_sales"];
			$uom_code_purchase	=	$_POST["uom_code_purchase"];
			$minimum_stock		=	numberreplace((empty($_POST["minimum_stock"])) ? 0 : $_POST["minimum_stock"]);
			$maximum_stock		=	numberreplace((empty($_POST["maximum_stock"])) ? 0 : $_POST["maximum_stock"]);
			
			//-----------upload file
		  	$photo2			= $_POST["photo2"];
			$uploaddir_photo= 'app/photo_item/';
			$photo			= $_FILES['photo']['name']; 
			$tmpname_photo 	= $_FILES['photo']['tmp_name'];
			$filesize_photo = $_FILES['photo']['size'];
			$filetype_photo = $_FILES['photo']['type'];
			
			if (empty($photo)) { 
				$photo = $photo2; 
			} else {
				$photo = $photo;
			}
			
			if($photo != "") {
					
				if($photo != $photo2) {
					
					if(!empty($photo2)) {
						unlink($uploaddir_photo . $photo2); //remove file 					
					}
					
					$photo = $ref . '_' . $photo;
				}
				$uploaddir_photo = $uploaddir_photo . $photo;		
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir_photo)) {
					echo "";											
				} 	
			}	
			//----------------
			
			$consigned		=	(empty($_POST["consigned"])) ? 0 : $_POST["consigned"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update item set code='$code', old_code='$old_code', name='$name', item_group_id='$item_group_id', item_subgroup_id='$item_subgroup_id', item_type_code='$item_type_code', item_category_id='$item_category_id', brand_id='$brand_id', size_id='$size_id', uom_code_stock='$uom_code_stock', uom_code_sales='$uom_code_sales', uom_code_purchase='$uom_code_purchase', minimum_stock='$minimum_stock', maximum_stock='$maximum_stock', photo='$photo', consigned='$consigned',  active='$active', uid='$uid', dlu='$dlu' where syscode='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			/*---------insert audit trail (update)------------*/
			$sqlstr="insert into adt_item (code, old_code, name, item_group_id, item_subgroup_id, item_type_code, item_category_id, brand_id, size_id, uom_code_stock, uom_code_sales, uom_code_purchase, minimum_stock, maximum_stock, photo, consigned, active, uid, dlu, syscode, adt_status) values ('$code', '$old_code', '$name', '$item_group_id', '$item_subgroup_id', '$item_type_code', '$item_category_id', '$brand_id', '$size_id', '$uom_code_stock', '$uom_code_sales', '$uom_code_purchase', '$minimum_stock', '$maximum_stock', '$photo', '$consigned', '$active', '$uid', '$dlu', '$ref', 'update' )";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			
			#insert/update set item cost
			$item_code	=	$ref;
			$uom_code	=	$uom_code_purchase;
			$current_cost	=	numberreplace($_POST['current_cost']);
			$date_cost		=	date("Y-m-d", strtotime($_POST['date_cost']));
			$efective_from_cost	=	date("Y-m-d", strtotime($_POST['efective_from_cost']));
			$date_of_record	=	date("Y-m-d H:i:s");
			$location_id_cost	=	$_POST['location_id_cost'];
			$old_date_of_record		=	date("Y-m-d", strtotime($_POST['old_date_of_record']));
			
			$sqlstr = "select item_code, current_cost from set_item_cost where item_code='$item_code' and uom_code='$uom_code' and current_cost='$current_cost'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows = $sql->rowCount();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$last_cost = $data->current_cost;
			
			if($rows == 0) {
				$sqlstr = "insert into set_item_cost (date, efective_from, item_code, uom_code, current_cost, last_cost, date_of_record, location_id, uid, dlu) values('$date_cost', '$efective_from_cost', '$item_code', '$uom_code', '$current_cost', '$last_cost', '$date_of_record', '$location_id_cost', '$uid', '$dlu')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				$sqlstr = "update set_item_cost set efective_from='$efective_from_cost', uom_code='$uom_code', current_cost='$current_cost', last_cost='$last_cost', date_of_record='$date_of_record', location_id='$location_id_cost', uid='$uid', dlu='$dlu' where item_code='$item_code' and uom_code='$uom_code' and date_of_record='$old_date_of_record'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			
			
			#insert/update set item price
			$item_code	=	$ref;
			$uom_code	=	$uom_code_sales;
			$current_price	=	numberreplace($_POST['current_price']);
			$current_price1	=	numberreplace($_POST['current_price1']);
			$current_price2	=	numberreplace($_POST['current_price2']);
			$current_price3	=	numberreplace($_POST['current_price3']);
			$date			=	date("Y-m-d", strtotime($_POST['date']));
			$efective_from	=	date("Y-m-d", strtotime($_POST['efective_from']));
			$date_of_record	=	date("Y-m-d H:i:s");
			$location_id	=	$_POST['location_id'];
			$non_discount	=	$_POST['non_discount'];
			$qty1			=	numberreplace($_POST['qty1']);
			$qty2			=	numberreplace($_POST['qty2']);
			$qty3			=	numberreplace($_POST['qty3']);
			$qty4			=	numberreplace($_POST['qty4']);
			$old_date_of_record1		=	date("Y-m-d", strtotime($_POST['old_date_of_record1']));
			
			$sqlstr = "select item_code, current_price from set_item_price where date_of_record='$date_of_record' and item_code='$item_code' and uom_code='$uom_code' and current_price='$current_price' and current_price1='$current_price1' and current_price2='$current_price2'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows = $sql->rowCount();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$last_price = $data->current_price;
			
			if($rows == 0) {
				$sqlstr = "insert into set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
				//audit trail insert
				$sqlstr = "insert into adt_set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu, adt_status) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu', 'insert')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				$sqlstr = "update set_item_price set efective_from='$efective_from', uom_code='$uom_code', current_price='$current_price', current_price1='$current_price1', current_price2='$current_price2', current_price3='$current_price3', last_price='$last_price', date_of_record='$date_of_record', location_id='$location_id', non_discount='$non_discount', qty1='$qty1', qty2='$qty2', qty3='$qty3', qty4='$qty4', uid='$uid', dlu='$dlu' where item_code='$item_code' and uom_code='$uom_code' and date_of_record='$old_date_of_record1'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
				//audit trail update
				$sqlstr = "insert into adt_set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu, adt_status) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu', 'update')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	
	//-----update item list
	function update_item_list($ref){
		$dbpdo = DB::create();
		
		try {
			
			#insert/update set item price
			$item_code	=	$ref;
			$uom_code	=	$uom_code_sales;
			$current_price	=	numberreplace($_POST['current_price']);
			$current_price1	=	numberreplace($_POST['current_price1']);
			$current_price2	=	numberreplace($_POST['current_price2']);
			$current_price3	=	numberreplace($_POST['current_price3']);
			$date			=	date("Y-m-d", strtotime($_POST['date']));
			$efective_from	=	date("Y-m-d", strtotime($_POST['efective_from']));
			$date_of_record	=	date("Y-m-d H:i:s");
			$location_id	=	$_POST['location_id'];
			$non_discount	=	$_POST['non_discount'];
			$qty1			=	numberreplace($_POST['qty1']);
			$qty2			=	numberreplace($_POST['qty2']);
			$qty3			=	numberreplace($_POST['qty3']);
			$qty4			=	numberreplace($_POST['qty4']);
			$old_date_of_record1		=	date("Y-m-d", strtotime($_POST['old_date_of_record1']));
			
			$sqlstr = "select item_code, current_price from set_item_price where date_of_record='$date_of_record' and item_code='$item_code' and uom_code='$uom_code' and current_price='$current_price' and current_price1='$current_price1' and current_price2='$current_price2'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows = $sql->rowCount();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$last_price = $data->current_price;
			
			if($rows == 0) {
				$sqlstr = "insert into set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
				//audit trail insert
				$sqlstr = "insert into adt_set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu, adt_status) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu', 'insert')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				$sqlstr = "update set_item_price set efective_from='$efective_from', uom_code='$uom_code', current_price='$current_price', current_price1='$current_price1', current_price2='$current_price2', current_price3='$current_price3', last_price='$last_price', date_of_record='$date_of_record', location_id='$location_id', non_discount='$non_discount', qty1='$qty1', qty2='$qty2', qty3='$qty3', qty4='$qty4', uid='$uid', dlu='$dlu' where item_code='$item_code' and uom_code='$uom_code' and date_of_record='$old_date_of_record1'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
				//audit trail update
				$sqlstr = "insert into adt_set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu, adt_status) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu', 'update')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update item conversion
	function update_item_conversion($ref){
		$dbpdo = DB::create();
		
		try {
			
			$item_code		= 	$_POST["item_code"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			
			
			
			
			$sqlstr="update item_conversion set item_code='$item_code', uid='$uid', dlu='$dlu' where item_code='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update item conversion detail
			$usr_jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$usr_jmldata; $i++) {
				$uom_code1 = $_POST[uom_code1_.$i];
				$uom_code2 = $_POST[uom_code2_.$i];
				
				if ( !empty($uom_code1) && !empty($uom_code2) ) { 				
					$conversion = $_POST[conversion_.$i];
					$factor = numberreplace($_POST[factor_.$i]);
					$constant = (empty($_POST[constant_.$i])) ? 0 : $_POST[constant_.$i];
									
					$sqlstr="update item_conversion_detail set item_code='$item_code', uom_code1='$uom_code1', uom_code2='$uom_code2', conversion='$conversion', factor='$factor', constant='$constant' where item_code='$ref' and line='$i'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
				}
			}
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update item packing
	function update_item_packing($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date			=	date("Y-m-d", strtotime($_POST["date"]));	
			$status			= 	$_POST["status"];
			$warehouse_id	=	(empty($_POST["warehouse_id"])) ? 0 : $_POST["warehouse_id"];
			$item_code		= 	$_POST["item_code"];
			$uom_code		= 	$_POST["uom_code"];
			$qty			= 	numberreplace($_POST["qty"]);
			$unit_price		= 	numberreplace($_POST["unit_price"]);
			$expired_date	=	date("Y-m-d", strtotime($_POST["expired_date"]));
			$week_wage_ref	= 	$_POST["week_wage_ref"];
			$week_wage_total= numberreplace($_POST["week_wage_total"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			
			
			
			
			$sqlstr="update item_packing set date='$date', status='$status', warehouse_id='$warehouse_id', item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', week_wage_ref='$week_wage_ref', week_wage_total='$week_wage_total', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update bincard (debit qty)
			$old_item_code	 	= $_POST[old_item_code];
			$old_uom_code 		= $_POST[old_uom_code];
			$old_warehouse_id 	= (empty($_POST[old_warehouse_id])) ? 0 : $_POST[old_warehouse_id];
			
			$amount = $unit_price * $qty;	
			$sqlstr="update bincard set location_code='$warehouse_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_price', debit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_warehouse_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=0 and invoice_type='packing' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//-----------update week_wage (ref repacking)
			$sqlstr="update week_wage set packing_ref='$ref' where ref='$week_wage_ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			

			//----------update item repacking detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code2	 	= $_POST[old_item_code_.$i];
				$old_uom_code2 		= $_POST[old_uom_code_.$i];
				$old_warehouse_id2 	= (empty($_POST[old_warehouse_id_.$i])) ? 0 : $_POST[old_warehouse_id_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code2	 	= $_POST[item_code_.$i];
				$uom_code2 		= $_POST[uom_code_.$i];
				$warehouse_id2 	= (empty($_POST[warehouse_id_.$i])) ? 0 : $_POST[warehouse_id_.$i];
				
				if ( !empty($item_code2) && !empty($uom_code2) && !empty($warehouse_id2) ) {
					$qty2 		= numberreplace($_POST[qty_.$i]);
					$unit_price2	= numberreplace($_POST[unit_price_.$i]);
					$amount		= numberreplace($_POST[amount_.$i]);
					
					$sqlstr = "select ref from item_packing_detail where ref='$ref' and item_code='$old_item_code2' and uom_code='$old_uom_code2' and warehouse_id='$old_warehouse_id2' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update item_packing_detail set item_code='$item_code2', uom_code='$uom_code2', warehouse_id='$warehouse_id2', qty='$qty2', unit_price='$unit_price2', amount='$amount' where ref='$ref' and item_code='$old_item_code2' and uom_code='$old_uom_code2' and warehouse_id='$old_warehouse_id2' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (credit qty)
							$sqlstr="update bincard set location_code='$warehouse_id2', date='$date', item_code='$item_code2', uom_code='$uom_code2', unit_price='$unit_price2', credit_qty='$qty2', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_warehouse_id2' and item_code='$old_item_code2' and uom_code='$old_uom_code2' and line='$old_line' and invoice_type='packing' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
								
						} else {
							$sqlstr="delete from item_packing_detail where ref='$ref' and item_code='$old_item_code2' and uom_code='$old_uom_code2' and warehouse_id='$old_warehouse_id2' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//----------delete bincard
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_warehouse_id2' and item_code='$old_item_code2' and uom_code='$old_uom_code2' and line='$old_line' and invoice_type='packing' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();							
						}
						
						
					} else {
						$line = maxline('item_packing_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into item_packing_detail (ref, item_code, uom_code, warehouse_id, qty, unit_price, amount, line) values ('$ref', '$item_code2', '$uom_code2', '$warehouse_id2', '$qty2', '$unit_price2', '$amount', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (credit qty)
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id2', '$date', 'packing', '', '$item_code2', '$uom_code2', '$unit_price2', 0, '$qty2', '$amount', '$line', '$uid', '$dlu')";					
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update inbound
	function update_inbound($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));	
			$status				= 	$_POST["status"];
			$type				= 	$_POST["type"];
			$reason				= 	$_POST["reason"];
			$purchase_invoice	= 	$_POST["purchase_invoice"];
			$warehouse_id_from	=	(empty($_POST["warehouse_id_from"])) ? 0 : $_POST["warehouse_id_from"];
			$warehouse_id_to	=	(empty($_POST["warehouse_id_to"])) ? 0 : $_POST["warehouse_id_to"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			
			
			
			
			$old_warehouse_id_from	=	(empty($_POST["old_warehouse_id_from"])) ? 0 : $_POST["old_warehouse_id_from"];
			$old_warehouse_id_to	=	(empty($_POST["old_warehouse_id_to"])) ? 0 : $_POST["old_warehouse_id_to"];
				
			$sqlstr="update inbound set date='$date', status='$status', type='$type', reason='$reason', purchase_invoice='$purchase_invoice', warehouse_id_from='$warehouse_id_from', warehouse_id_to='$warehouse_id_to', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update inbound detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty 		= numberreplace($_POST[qty_.$i]);
					
					$sqlstr = "select ref from inbound_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update inbound_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (credit qty)
							$sqlstr="update bincard set location_code='$warehouse_id_from', date='$date', item_code='$item_code', uom_code='$uom_code', credit_qty='$qty', description='$reason', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_warehouse_id_from' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' and invoice_type='inbound' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (debit qty)
							$sqlstr="update bincard set location_code='$warehouse_id_to', date='$date', item_code='$item_code', uom_code='$uom_code', debit_qty='$qty', description='$reason', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_warehouse_id_to' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' and invoice_type='inbound' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
								
						} else {
							$sqlstr="delete from inbound_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//----------delete bincard
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_warehouse_id_from' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' and invoice_type='inbound' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_warehouse_id_to' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' and invoice_type='inbound' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();						
						}
						
						
					} else {
						$line = maxline('inbound_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into inbound_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (credit qty) ======>FROM
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id_from', '$date', 'inbound', '$reason', '$item_code', '$uom_code', 0, 0, '$qty', 0, '$line', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (debit qty)  ========>TO
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id_to', '$date', 'inbound', '$reason', '$item_code', '$uom_code', 0, '$qty', 0, 0, '$line', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update outbound
	function update_outbound($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));	
			$status				= 	$_POST["status2"];
			$type				= 	$_POST["type"];
			$reason				= 	$_POST["reason"];
			$form_no			= 	$_POST["form_no"];
			$warehouse_id_from	=	(empty($_POST["warehouse_id_from"])) ? 0 : $_POST["warehouse_id_from"];
			$warehouse_id_to	=	(empty($_POST["warehouse_id_to"])) ? 0 : $_POST["warehouse_id_to"];
			$employee_id		=	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$employee_id2		=	(empty($_POST["employee_id2"])) ? 0 : $_POST["employee_id2"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			$uid_released	=	$_SESSION["loginname"];
			
			
			$old_warehouse_id_from	=	(empty($_POST["old_warehouse_id_from"])) ? 0 : $_POST["old_warehouse_id_from"];
			$old_warehouse_id_to	=	(empty($_POST["old_warehouse_id_to"])) ? 0 : $_POST["old_warehouse_id_to"];
				
			$sqlstr="update outbound set date='$date', status='$status', type='$type', reason='$reason', form_no='$form_no', warehouse_id_from='$warehouse_id_from', warehouse_id_to='$warehouse_id_to', employee_id='$employee_id', employee_id2='$employee_id2', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			/*---------insert adt outbound (update)------------*/
			$sqlstr="insert into adt_outbound (ref, date, status, type, warehouse_id_from, warehouse_id_to, reason, form_no, employee_id, uid, dlu, adt_status) values ('$ref', '$date', '$status', '$type', '$warehouse_id_from', '$warehouse_id_to', '$reason', '$form_no', '$employee_id', '$uid', '$dlu', 'update' )";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			
			//----------update outbound detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty 		= numberreplace($_POST[qty_.$i]);
					$ref_pos	= $_POST[ref_pos_.$i];
					
					$sqlstr = "select ref from outbound_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update outbound_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', ref_pos='$ref_pos' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							/*---------insert adt outbound_detail (insert)------------*/
							$sqlstr="insert into adt_outbound_detail (ref, item_code, uom_code, qty, ref_pos, line, adt_status) values ('$ref', '$item_code', '$uom_code', '$qty', '$ref_pos', '$old_line', 'update' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							if($status == 'C') {
								
								/*cek bincard from*/
								$sqlstr="select invoice_no from bincard  where invoice_no='$ref' and location_code='$old_warehouse_id_from' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' and invoice_type='outbound' ";
								
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								$rowsdata = $sql->rowCount();
								
								if($rowsdata > 0) {
									//----------update bincard (credit qty)
									$sqlstr="update bincard set location_code='$warehouse_id_from', date='$date', item_code='$item_code', uom_code='$uom_code', credit_qty='$qty', description='$reason', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_warehouse_id_from' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' and invoice_type='outbound' ";
									
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();
									
									//----------AUDIT TRAIL insert bincard (credit qty)
									$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$warehouse_id_from', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, 0, '$qty', 0, '$old_line', '$uid', '$dlu', 'update')";	
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();
									/*---------end from --------------*/
								} else {
									//----------insert bincard (credit qty) ======>FROM
									$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id_from', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, 0, '$qty', 0, '$old_line', '$uid', '$dlu')";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();
									
									//----------AUDIT TRAIL insert bincard (credit qty)
									$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$warehouse_id_from', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, 0, '$qty', 0, '$line', '$uid', '$dlu', 'insert')";	
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();
								}
								
								
								
								/*cek bincard to*/
								$sqlstr="select invoice_no from bincard  where invoice_no='$ref' and location_code='$old_warehouse_id_to' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' and invoice_type='outbound' ";
								
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								$rowsdata2 = $sql->rowCount();
								
								if($rowsdata2 > 0) {
									//----------update bincard (debit qty)
									$sqlstr="update bincard set location_code='$warehouse_id_to', date='$date', item_code='$item_code', uom_code='$uom_code', debit_qty='$qty', description='$reason', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_warehouse_id_to' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' and invoice_type='outbound' ";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();
									
									//----------AUDIT TRAIL insert bincard (debit qty)
									$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$warehouse_id_to', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, '$qty', 0, 0, '$old_line', '$uid', '$dlu', 'update')";								$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();
									/*----------end TO--------------*/
								} else {
									//----------insert bincard (debit qty)  ========>TO
									$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id_to', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, '$qty', 0, 0, '$old_line', '$uid', '$dlu')";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();
									
									//----------AUDIT TRAIL insert bincard (debit qty)
									$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$warehouse_id_to', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, '$qty', 0, 0, '$old_line', '$uid', '$dlu', 'insert')";	
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();
								}
								
							}
								
						} else {
							$sqlstr="delete from outbound_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							/*---------insert adt outbound_detail (insert)------------*/
							$sqlstr="insert into adt_outbound_detail (ref, item_code, uom_code, qty, ref_pos, line, adt_status) values ('$ref', '$old_item_code', '$old_uom_code', '$qty', '$ref_pos', '$old_line', 'delete' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------delete bincard
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_warehouse_id_from' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' and invoice_type='outbound' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//----------AUDIT TRAIL insert bincard (credit qty)
							$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$old_warehouse_id_from', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, 0, '$qty', 0, '$old_line', '$uid', '$dlu', 'delete')";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							/*---------end from --------------*/
							
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_warehouse_id_to' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' and invoice_type='outbound' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//----------AUDIT TRAIL insert bincard (debit qty)
							$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$old_warehouse_id_to', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, '$qty', 0, 0, '$old_line', '$uid', '$dlu', 'delete')";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							/*---------end from --------------*/					
						}
						
						
					} else {
						$line = maxline('outbound_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into outbound_detail (ref, item_code, uom_code, qty, ref_pos, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$ref_pos', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						/*---------insert adt outbound_detail (insert)------------*/
						$sqlstr="insert into adt_outbound_detail (ref, item_code, uom_code, qty, ref_pos, line, adt_status) values ('$ref', '$item_code', '$uom_code', '$qty', '$ref_pos', '$line', 'insert' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						
						if($status == "C") {
							//----------insert bincard (credit qty) ======>FROM
							$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id_from', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, 0, '$qty', 0, '$line', '$uid', '$dlu')";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------AUDIT TRAIL insert bincard (credit qty)
							$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$warehouse_id_from', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, 0, '$qty', 0, '$line', '$uid', '$dlu', 'insert')";						$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							/*---------end from --------------*/
							
							//----------insert bincard (debit qty)  ========>TO 
							$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id_to', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, '$qty', 0, 0, '$line', '$uid', '$dlu')";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------AUDIT TRAIL insert bincard (debit qty)
							$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$warehouse_id_to', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, '$qty', 0, 0, '$line', '$uid', '$dlu', 'insert')";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							/*---------end from --------------*/
						}
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update store request
	function update_store_request($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$date_need			=	date("Y-m-d", strtotime($_POST["date_need"]));	
			$status				= 	$_POST["status"];
			$type				= 	$_POST["type"];
			$priority			= 	$_POST["priority"];
			$warehouse_id_from	=	(empty($_POST["warehouse_id_from"])) ? 0 : $_POST["warehouse_id_from"];
			$warehouse_id_to	=	(empty($_POST["warehouse_id_to"])) ? 0 : $_POST["warehouse_id_to"];
			$reason				= 	$_POST["reason"];
			$memo				= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			
			
			
			$old_warehouse_id_from	=	(empty($_POST["old_warehouse_id_from"])) ? 0 : $_POST["old_warehouse_id_from"];
			$old_warehouse_id_to	=	(empty($_POST["old_warehouse_id_to"])) ? 0 : $_POST["old_warehouse_id_to"];
				
			$sqlstr="update store_request set date='$date', date_need='$date_need', status='$status', type='$type', reason='$reason', memo='$memo', warehouse_id_from='$warehouse_id_from', warehouse_id_to='$warehouse_id_to', priority='$priority', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update store request detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty 		= numberreplace($_POST[qty_.$i]);
					
					$sqlstr = "select ref from store_request_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update store_request_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
								
						} else {
							$sqlstr="delete from store_request_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('store_request_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into store_request_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update stock oopname
	function update_stock_opname($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$bin				= 	$_POST["bin"];
			$uid				=	$_SESSION["loginname"];
			$beginning_balance	= 	(empty($_POST["beginning_balance"])) ? 0 : $_POST["beginning_balance"];
			$memo				= 	$_POST["memo"];
			$dlu				=	date("Y-m-d H:i:s");
			
			
			
			
			
			$old_date			=	date("Y-m-d", strtotime($_POST["old_date"]));
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
			$old_bin			= 	$_POST["old_bin"];
			$old_uid			=	$_POST["old_uid"];
				
			$sqlstr="update stock_opname set date='$date', location_id='$location_id', bin='$bin', uid='$uid', beginning_balance='$beginning_balance', memo='$memo', dlu='$dlu' where syscode='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update store request detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty 		= numberreplace($_POST[qty_.$i]);
					$unit_cost 	= numberreplace($_POST[unit_cost_.$i]);
					
					$sqlstr = "select syscode from stock_opname_detail where syscode='$ref' and date='$old_date' and location_id='$old_location_id' and bin='$old_bin' and uid='$old_uid' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update stock_opname_detail set date='$date', location_id='$location_id', bin='$bin', uid='$uid', item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_cost='$unit_cost'  where syscode='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##bincard update
							$sqlstr = "delete from bincard where invoice_no='$ref' and item_code='$item_code' and uom_code='$uom_code'";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							$sqlstr="select sum(ifnull(qty,0)) qty from stock_opname_detail where syscode='$ref' and item_code='$item_code' and uom_code='$uom_code' group by syscode, item_code, uom_code ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							$data = $sql->fetch(PDO::FETCH_OBJ);
							$qty = $data->qty;
							
							if ($qty > 0) { //jika plus, maka masuk debit
								$amount = $unit_cost * $qty;
								
								$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'stockopname', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', $old_line, '$uid', '$dlu')";		
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							} else { //jika minus, maka masuk credit
								$amount = ($unit_cost * $qty) * -1;
								$qty	= $qty * -1;
								
								$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'stockopname', '', '$item_code', '$uom_code', '$unit_cost', '0', '$qty', '$amount', $old_line, '$uid', '$dlu')";		
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							}
							
								
						} else {
							$sqlstr="delete from stock_opname_detail where syscode='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							##bincard update
							$sqlstr = "delete from bincard where invoice_no='$ref' and item_code='$item_code' and uom_code='$uom_code'";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$line = maxline('stock_opname_detail', 'line', 'syscode', $ref, '');
						
						$sqlstr="insert into stock_opname_detail (date, location_id, bin, uid, item_code, uom_code, line, qty, unit_cost, syscode) values ('$date', '$location_id', '$bin', '$uid', '$item_code', '$uom_code', $line, '$qty', '$unit_cost', '$ref')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##bincard
						if ($qty > 0) { //jika plus, maka masuk debit
							$amount = $unit_cost * $qty;
							
							$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'stockopname', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', $line, '$uid', '$dlu')";		
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						} else { //jika minus, maka masuk credit
							$amount = ($unit_cost * $qty) * -1;
							$qty	= $qty * -1;
							
							$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'stockopname', '', '$item_code', '$uom_code', '$unit_cost', '0', '$qty', '$amount', $line, '$uid', '$dlu')";		
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						}
						
					}
					
					
					
				}
			}
			
			
			//add item
			$item_code 		= $_POST["item_code"];
			$uom_code 		= $_POST["uom_code"];
			$syscode		= $ref;			
			if ( !empty($item_code) && !empty($uom_code) ) {				
				$qty = numberreplace($_POST["qty"]);
				$unit_cost = numberreplace($_POST["unit_cost"]);
				
				$line = maxline('stock_opname_detail', 'line', 'syscode', $syscode, '');
									
				$sqlstr = "select qty, unit_cost from stock_opname_detail where syscode='$syscode' and date='$date' and location_id='$location_id' and bin='$bin' and uid='$uid' and item_code='$item_code' and uom_code='$uom_code' limit 1";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				$data = $sql->fetch(PDO::FETCH_OBJ);
				
				if($rows == 0) {
					$sqlstr="insert into stock_opname_detail (date, location_id, bin, uid, item_code, uom_code, line, qty, unit_cost, syscode) values ('$date', '$location_id', '$bin', '$uid', '$item_code', '$uom_code', $line, '$qty', '$unit_cost', '$syscode')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr="update stock_opname_detail set qty=ifnull(qty,0) + $qty, unit_cost='$unit_cost' where syscode='$syscode' and date='$date' and location_id='$location_id' and bin='$bin' and uid='$uid' and item_code='$item_code' and uom_code='$uom_code'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}
				
			}
			
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update vendor type
	function update_vendor_type($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name				=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update vendor_type set name='$name', pch_account='$pch_account', pch_return_account='$pch_return_account', pch_discount_account='$pch_discount_account', vendor_deposit_account='$vendor_deposit_account', currency_account='$currency_account', cheque_payable_account='$cheque_payable_account', location_id='$location_id', active='$active', uid='$uid', dlu='$dlu' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------update  detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_id		 	= (empty($_POST[old_id_.$i])) ? 0 : $_POST[old_id_.$i];
				$old_line	 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$pch_account			=	$_POST[pch_account_.$i];
				$pch_cash_account		=	$_POST[pch_cash_account_.$i];
				$pch_return_account		=	$_POST[pch_return_account_.$i];
				$pch_discount_account	=	$_POST[pch_discount_account_.$i];
				$vendor_deposit_account	=	$_POST[vendor_deposit_account_.$i];
				$currency_account		=	$_POST[currency_account_.$i];
				$cheque_payable_account	=	$_POST[cheque_payable_account_.$i];
				$hutang_belum_faktur	=	$_POST[hutang_belum_faktur_.$i];
				$location_id	=	(empty($_POST[location_id_.$i])) ? 0 : $_POST[location_id_.$i];
							
				if ( $location_id > 0 ) {
					
					$sqlstr = "select id from vendor_type_detail where id_header='$ref' and id='$old_id' and line='$old_line' ";			
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update vendor_type_detail set pch_account='$pch_account', pch_cash_account='$pch_cash_account', pch_return_account='$pch_return_account', pch_discount_account='$pch_discount_account', vendor_deposit_account='$vendor_deposit_account', currency_account='$currency_account', cheque_payable_account='$cheque_payable_account', hutang_belum_faktur='$hutang_belum_faktur', location_id='$location_id' where id_header='$ref' and id='$old_id' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						} else {
							$sqlstr="delete from vendor_type_detail where id_header='$ref' and id='$old_id' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
						
					} else {
						
						$line = maxline('vendor_type_detail', 'line', 'id_header', $ref, '');
					
						$sqlstr="insert into vendor_type_detail (id_header, pch_account, pch_cash_account, pch_return_account, pch_discount_account, vendor_deposit_account, currency_account, cheque_payable_account, hutang_belum_faktur, location_id, line) values ('$ref', '$pch_account', '$pch_cash_account', '$pch_return_account', '$pch_discount_account', '$vendor_deposit_account', '$currency_account', '$cheque_payable_account', '$hutang_belum_faktur', '$location_id', '$line')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();				
											
					}
					
				}
			}
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update vendor
	function update_vendor($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	petikreplace($_POST["code"]);
			$name			=	petikreplace($_POST["name"]);
			$contact_person	=	$_POST["contact_person"];
			$vendor_type	=	(empty($_POST["vendor_type"])) ? 0 : $_POST["vendor_type"];
			$address		=	$_POST["address"];
			$zip_code		=	$_POST["zip_code"];
			$country_id		=	(empty($_POST["country_id"])) ? 0 : $_POST["country_id"];
			$state_id		=	(empty($_POST["state_id"])) ? 0 : $_POST["state_id"];
			$phone			=	$_POST["phone"];
			$fax			=	$_POST["fax"];
			$email			=	$_POST["email"];
			$web			=	$_POST["web"];		
			$bank_account	=	$_POST["bank_account"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update vendor set code='$code', name='$name', contact_person='$contact_person', vendor_type='$vendor_type', address='$address', zip_code='$zip_code', country_id='$country_id', state_id='$state_id', phone='$phone', fax='$fax', email='$email', web='$web', bank_account='$bank_account', active='$active', uid='$uid', dlu='$dlu' where syscode='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update tax
	function update_tax($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	petikreplace($_POST["code"]);
			$name			=	petikreplace($_POST["name"]);
			$rate			= 	numberreplace($_POST["rate"]);
			$tax_account	=	$_POST["tax_account"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update tax set code='$code', name='$name', rate='$rate', tax_account='$tax_account', active='$active', uid='$uid', dlu='$dlu' where syscode='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update invent adjust
	function update_invent_adjust($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$gl_account			=	$_POST["gl_account"];
			$reason_id			=	(empty($_POST["reason_id"])) ? 0 : $_POST["reason_id"];
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$memo				= 	petikreplace($_POST["memo"]);
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			
			
			
			
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
				
			$sqlstr="update invent_adjust set date='$date', status='$status', gl_account='$gl_account', reason_id='$reason_id', location_id='$location_id', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update store request detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty 		= numberreplace($_POST[qty_.$i]);
					
					$sqlstr = "select ref from invent_adjust_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update invent_adjust_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
								
						} else {
							$sqlstr="delete from invent_adjust_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('invent_adjust_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into invent_adjust_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update item issued
	function update_item_issued($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$employee_id		=	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$memo				= 	petikreplace($_POST["memo"]);
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			
			
			
			
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
				
			$sqlstr="update item_issued set date='$date', status='$status', employee_id='$employee_id', location_id='$location_id', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update store request detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty 			= numberreplace($_POST[qty_.$i]);
					$account_code	= (empty($_POST[account_code_.$i])) ? 0 : $_POST[account_code_.$i];
					
					$sqlstr = "select ref from item_issued_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update item_issued_detail set item_code='$item_code', uom_code='$uom_code', account_code='$account_code', qty='$qty' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
								
						} else {
							$sqlstr="delete from item_issued_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('item_issued_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into item_issued_detail (ref, item_code, uom_code, account_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$account_code', '$qty', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update item return
	function update_item_return($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$item_issued_ref	= 	$_POST["item_issued_ref"];
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$employee_id		=	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$memo				= 	petikreplace($_POST["memo"]);
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			
			
			
			
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
				
			$sqlstr="update item_return set date='$date', status='$status', item_issued_ref='$item_issued_ref', employee_id='$employee_id', location_id='$location_id', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty 			= numberreplace($_POST[qty_.$i]);
					$account_code	= (empty($_POST[account_code_.$i])) ? 0 : $_POST[account_code_.$i];
					$line_item_issued = (empty($_POST[line_item_issued_.$i])) ? 0 : $_POST[line_item_issued_.$i];
					
					$sqlstr = "select ref from item_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update item_return_detail set item_code='$item_code', uom_code='$uom_code', account_code='$account_code', qty='$qty', line_item_issued='$line_item_issued' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
								
						} else {
							$sqlstr="delete from item_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('item_return_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into item_return_detail (ref, item_code, uom_code, account_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$account_code', '$qty', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update purchase request
	function update_purchase_request($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$employee_id		=	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$reason				= 	$_POST["reason"];
			$memo				= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			
			
			
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
				
			$sqlstr="update purchase_request set date='$date', status='$status', employee_id='$employee_id', location_id='$location_id', reason='$reason', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update purchase request detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty 		= numberreplace($_POST[qty_.$i]);
					
					$sqlstr = "select ref from purchase_request_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update purchase_request_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
								
						} else {
							$sqlstr="delete from purchase_request_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('purchase_request_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into purchase_request_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update purchase order
	function update_purchase_order($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$vendor_code		= 	$_POST["vendor_code"];
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			$note				= 	$_POST["note"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			
			
			
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
				
			$sqlstr="update purchase_order set date='$date', status='$status', vendor_code='$vendor_code', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', note='$note', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update purchase request detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$pr_ref 		= $_POST[pr_ref_.$i];
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {				
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					$unit_cost 	= numberreplace($_POST[unit_cost_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					
					$sqlstr = "select ref from purchase_order_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' order by line ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update purchase_order_detail set pr_ref='$pr_ref', item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_cost='$unit_cost', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty purchase request
							if($status != "P") {
								$sqlstr="update purchase_request_detail set qty_po=ifnull(qty_po,0) - $old_qty + $qty where ref='$pr_ref' and item_code='$item_code' and uom_code='$uom_code' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
							}
							
								
						} else {
							$sqlstr="delete from purchase_order_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							##--------update qty purchase request						
							$sqlstr="update purchase_request_detail set qty_po=ifnull(qty_po,0) - $qty where ref='$pr_ref' and item_code='$item_code' and uom_code='$uom_code' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$line = maxline('purchase_order_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into purchase_order_detail (ref, pr_ref, item_code, uom_code, qty, unit_cost, amount, line) values ('$ref', '$pr_ref', '$item_code', '$uom_code', '$qty', '$unit_cost', '$amount', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty purchase request
						if($status != "P") {
							$sqlstr="update purchase_request_detail set qty_po=ifnull(qty_po,0) + $qty where ref='$pr_ref' and item_code='$item_code' and uom_code='$uom_code' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
					}
					
					
					##--------update qty purchase request
					if($status != "P") {
						/*update status sales order : O=Ordered Part
											  C=Ordered Complete
											  V=Received Part
											  F=Received Complete
						*/
						$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_po,0)) qty_po from purchase_request_detail group by ref having ref='$pr_ref'";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						$data = $sql->fetch(PDO::FETCH_OBJ);
						
						$qty_po = $data->qty_po;
						$qty = $data->qty;
						
						if($qty > 0) {
							if($qty_po < $qty ) {
								$sqlstr="update purchase_request set status='O' where ref='$pr_ref' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();	
							}
							
							if($qty_po >= $qty ) {
								$sqlstr="update purchase_request set status='C' where ref='$pr_ref' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();	
							}
						}
						##*****************************************##
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update good receipt
	function update_good_receipt($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$date_arrival		=	date("Y-m-d", strtotime($_POST["date_arrival"]));
			$driver				=	$_POST["driver"];
			$vehicle			=	$_POST["vehicle"];
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$memo				= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			
			
			
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
				
			$sqlstr="update good_receipt set date='$date', status='$status', date_arrival='$date_arrival', driver='$driver', vehicle='$vehicle', location_id='$location_id', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update purchase request detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_po_ref			= $_POST[old_po_ref_.$i];
				$old_qty			= numberreplace($_POST[old_qty_.$i]);
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$po_ref 		= $_POST[po_ref_.$i];
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) && !empty($po_ref) ) {				
					$qty 		= numberreplace($_POST[qty_.$i]);
					$unit_cost 	= numberreplace($_POST[unit_cost_.$i]);
					
					$sqlstr = "select ref from good_receipt_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update good_receipt_detail set po_ref='$po_ref', item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_cost='$unit_cost' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";						
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty purchase order
							if($status != "P") {
								$sqlstr="update purchase_order_detail set qty_gr=ifnull(qty_gr,0) - $old_qty + $qty where ref='$old_po_ref' and item_code='$old_item_code' and uom_code='$old_uom_code' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
								/*update status purchase order : V=Received Part
													  F=Received Complete
								*/
								$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_gr,0)) qty_gr from purchase_order_detail group by ref having ref='$old_po_ref'";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								$data = $sql->fetch(PDO::FETCH_OBJ);
								
								$qty_gr = $data->qty_gr;
								$qty = $data->qty;
								
								if($qty > 0) {
									if($qty_gr < $qty ) {
										$sqlstr="update purchase_order set status='V' where ref='$old_po_ref' ";
										$sql=$dbpdo->prepare($sqlstr);
										$sql->execute();	
									}
									
									if($qty_gr >= $qty ) {
										$sqlstr="update purchase_order set status='F' where ref='$old_po_ref' ";
										$sql=$dbpdo->prepare($sqlstr);
										$sql->execute();	
									}
								}
								##*****************************************##
								
								//----------update bincard (credit qty)
								$amount = $qty * $unit_cost;
								
								$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_cost', debit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='good_receipt' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							}
							
								
						} else {
							$sqlstr="delete from good_receipt_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							##--------update qty purchase order
							$sqlstr="update purchase_order_detail set qty_gr=ifnull(qty_gr,0) - $qty where ref='$old_po_ref' and item_code='$old_item_code' and uom_code='$old_uom_code' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							/*update status purchase order : V=Received Part
												  F=Received Complete
							*/
							$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_gr,0)) qty_gr from purchase_order_detail group by ref having ref='$old_po_ref'";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							$data = $sql->fetch(PDO::FETCH_OBJ);
							
							$qty_gr = $data->qty_gr;
							$qty = $data->qty;
							
							if($qty > 0) {
								if($qty_gr < $qty ) {
									$sqlstr="update purchase_order set status='V' where ref='$old_po_ref' ";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();	
								}
								
								if($qty_gr >= $qty ) {
									$sqlstr="update purchase_order set status='F' where ref='$old_po_ref' ";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();	
								}
							}
							##*****************************************##
							
							
							//----------delete bincard (credit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='good_receipt' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$line = maxline('good_receipt_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into good_receipt_detail (ref, po_ref, item_code, uom_code, qty, unit_cost, line) values ('$ref', '$po_ref', '$item_code', '$uom_code', '$qty', '$unit_cost', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty purchase order
						if($status != "P") {
							$sqlstr="update purchase_order_detail set qty_gr=ifnull(qty_gr,0) + $qty where ref='$po_ref' and item_code='$item_code' and uom_code='$uom_code' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							/*update status purchase order : V=Received Part
												  F=Received Complete
							*/
							$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_gr,0)) qty_gr from purchase_order_detail group by ref having ref='$po_ref'";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							$data = $sql->fetch(PDO::FETCH_OBJ);
							
							$qty_gr = $data->qty_gr;
							$qty = $data->qty;
							
							if($qty > 0) {
								if($qty_gr < $qty ) {
									$sqlstr="update purchase_order set status='V' where ref='$po_ref' ";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();	
								}
								
								if($qty_gr >= $qty ) {
									$sqlstr="update purchase_order set status='F' where ref='$po_ref' ";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();	
								}
							}
							##*****************************************##
							
							//----------bincard (debit_qty)
							$amount = $qty * $unit_cost;
							
							$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'good_receipt', '$memo', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						}
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	

	//-----update purchase invoice
	function update_purchase_invoice($ref){
		
		$dbpdo = DB::create();
		
		try {
		
			
			
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
				
			
			//----------update item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_qty 			= numberreplace($_POST[old_qty_.$i]);
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$po_ref 		= $_POST[po_ref_.$i];
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty = numberreplace($_POST[qty_.$i]);
					$unit_cost = numberreplace($_POST[unit_cost_.$i]);
					$amount = $qty * $unit_cost; //numberreplace($_POST[amount_.$i]);
					$line_item_po = (empty($_POST[line_item_po_.$i])) ? 0 : $_POST[line_item_po_.$i];
					
					$sqlstr = "select ref from purchase_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update purchase_invoice_detail set po_ref='$po_ref', item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_cost='$unit_cost', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty purchase order
							if($status != "P") {
								$sqlstr="update purchase_order_detail set qty_pi=ifnull(qty_pi,0) - $old_qty + $qty where ref='$po_ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$line_item_po' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
								/*update status purchase order : I=Invoice Part
													  U=Invoice Full
								*/
								$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_pi,0)) qty_pi from purchase_order_detail group by ref having ref='$po_ref'";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								$data = $sql->fetch(PDO::FETCH_OBJ);
								
								$qty_pi = $data->qty_pi;
								$qty = $data->qty;
								
								if($qty > 0) {
									if($qty_pi < $qty ) {
										$sqlstr="update purchase_order set status='I' where ref='$po_ref' ";
										$sql=$dbpdo->prepare($sqlstr);
										$sql->execute();	
									}
									
									if($qty_pi >= $qty ) {
										$sqlstr="update purchase_order set status='U' where ref='$po_ref' ";
										$sql=$dbpdo->prepare($sqlstr);
										$sql->execute();	
									}
								}
								##*****************************************##
								
							}
							
								
						} else {
							$sqlstr="delete from purchase_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							##--------update qty purchase order						
							$sqlstr="update purchase_order_detail set qty_pi=ifnull(qty_pi,0) - $old_qty where ref='$po_ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$line_item_po' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							/*update status purchase order : I=Invoice Part
												  U=Invoice Full
							*/
							$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_pi,0)) qty_pi from purchase_order_detail group by ref having ref='$po_ref'";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							$data = $sql->fetch(PDO::FETCH_OBJ);
							
							$qty_pi = $data->qty_pi;
							$qty = $data->qty;
							
							if($qty > 0) {
								if($qty_pi < $qty ) {
									$sqlstr="update purchase_order set status='I' where ref='$po_ref' ";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();	
								}
								
								if($qty_pi >= $qty ) {
									$sqlstr="update purchase_order set status='U' where ref='$po_ref' ";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();	
								}
							}
							##*****************************************##
								
							
												
						}
						
						
					} else {
						$line = maxline('purchase_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into purchase_invoice_detail (ref, po_ref, item_code, uom_code, qty, unit_cost, amount, line_item_po, line) values ('$ref', '$po_ref', '$item_code', '$uom_code', '$qty', '$unit_cost', '$amount', '$line_item_po', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty purchase order
						if($status != "P") {
							$sqlstr="update purchase_order_detail set qty_pi=ifnull(qty_pi,0) + $qty where ref='$po_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_po' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							/*update status purchase order : I=Invoice Part
												  U=Invoice Full
							*/
							$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_pi,0)) qty_pi from purchase_order_detail group by ref having ref='$po_ref'";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							$data = $sql->fetch(PDO::FETCH_OBJ);
							
							$qty_pi = $data->qty_pi;
							$qty = $data->qty;
							
							if($qty > 0) {
								if($qty_pi < $qty ) {
									$sqlstr="update purchase_order set status='I' where ref='$po_ref' ";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();	
								}
								
								if($qty_pi >= $qty ) {
									$sqlstr="update purchase_order set status='U' where ref='$po_ref' ";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();	
								}
							}
							##*****************************************##
							
						}
						
					}
					
					
					
				}
			}
			
			//-get amount
			$sqlstr = "select sum(amount) amount from purchase_invoice_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			$tax_code			= 	$_POST["tax_code"];
			$tax_rate			=	numberreplace((empty($_POST["tax_rate"])) ? 0 : $_POST["tax_rate"]);
			$freight_cost		=	numberreplace((empty($_POST["freight_cost"])) ? 0 : $_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$memo				= 	petikreplace($_POST["memo"]);
			$total				=	$sub_total;
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			$sqlstr="update purchase_invoice set date='$date', status='$status', bill_number='$bill_number', vendor_code='$vendor_code', top='$top', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', memo='$memo', total='$total', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//insert AP
			$sqlstr="delete from ap where ref='$ref' and invoice_type='PIN' and ref_type='PIN' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$sqlstr="insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'V', '$vendor_code', '', 0, '$total', 'PIN', 'PIN', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update currency
	function update_currency($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	petikreplace($_POST["name"]);
			$currency_code	=	petikreplace($_POST["currency_code"]);
			$symbol			=	petikreplace($_POST["symbol"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update currency set name='$name', currency_code='$currency_code', symbol='$symbol', active='$active', uid='$uid', dlu='$dlu' where syscode='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update currency rate type
	function update_currency_rate_type($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	petikreplace($_POST["name"]);
			$currency_code	=	(empty($_POST["currency_code"])) ? 0 : $_POST["currency_code"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$rate			=	numberreplace((empty($_POST["rate"])) ? 0 : $_POST["rate"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update currency_rate_type set name='$name', currency_code='$currency_code', date='$date', rate='$rate', active='$active', uid='$uid', dlu='$dlu' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update credit Card type
	function update_credit_card_type($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	petikreplace($_POST["name"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update credit_card_type set name='$name', active='$active', uid='$uid', dlu='$dlu' where code='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update cash master
	function update_cash_master($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	$_POST["code"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$maximum_limit	=	numberreplace((empty($_POST["maximum_limit"])) ? 0 : $_POST["maximum_limit"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update cash_master set code='$code', location_id='$location_id', maximum_limit='$maximum_limit', uid='$uid', dlu='$dlu' where code='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update client type
	function update_client_type($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name				=	$_POST["name"];
			$sls_account		=	$_POST["sls_account"];
			$sls_return_account	=	$_POST["sls_return_account"];
			$sls_discount_account	=	$_POST["sls_discount_account"];
			$client_deposit_account	=	$_POST["client_deposit_account"];
			$currency_account		=	$_POST["currency_account"];
			$cheque_receivable_account	=	$_POST["cheque_receivable_account"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//----------update  detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_id		 	= (empty($_POST[old_id_.$i])) ? 0 : $_POST[old_id_.$i];
				$old_line	 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$sls_account		=	$_POST[sls_account_.$i];
				$sls_cash_account		=	$_POST[sls_cash_account_.$i];
				$sls_return_account	=	$_POST[sls_return_account_.$i];
				$sls_discount_account	=	$_POST[sls_discount_account_.$i];
				$client_deposit_account	=	$_POST[client_deposit_account_.$i];
				$currency_account		=	$_POST[currency_account_.$i];
				$cheque_receivable_account	=	$_POST[cheque_receivable_account_.$i];	
				$sls_account2			=	$_POST[sls_account2_.$i];
				$location_id	=	(empty($_POST[location_id_.$i])) ? 0 : $_POST[location_id_.$i];
				
				if ( $location_id > 0 ) {
					
					$sqlstr = "select id from client_type_detail where id_header='$ref' and id='$old_id' and line='$old_line' ";			
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update client_type_detail set sls_account='$sls_account', sls_cash_account='$sls_cash_account', sls_return_account='$sls_return_account', sls_discount_account='$sls_discount_account', client_deposit_account='$client_deposit_account', currency_account='$currency_account', cheque_receivable_account='$cheque_receivable_account', sls_account2='$sls_account2', location_id='$location_id' where id_header='$ref' and id='$old_id' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						} else {
							$sqlstr="delete from client_type_detail where id_header='$ref' and id='$old_id' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
						
					} else {
						
						$line = maxline('client_type_detail', 'line', 'id_header', $ref, '');
					
						$sqlstr="insert into client_type_detail (id_header, sls_account, sls_cash_account, sls_return_account, sls_discount_account, client_deposit_account, currency_account, cheque_receivable_account, sls_account2, location_id, line) values ('$ref', '$sls_account', '$sls_cash_account', '$sls_return_account', '$sls_discount_account', '$client_deposit_account', '$currency_account', '$cheque_receivable_account', '$sls_account2', '$location_id', '$line')";					
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
											
					}
					
				}
			}
			
			
			$sqlstr="update client_type set name='$name', sls_account='$sls_account', sls_return_account='$sls_return_account', sls_discount_account='$sls_discount_account', client_deposit_account='$client_deposit_account', currency_account='$currency_account', cheque_receivable_account='$cheque_receivable_account', location_id='$location_id', active='$active', uid='$uid', dlu='$dlu' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update client
	function update_client($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=	petikreplace($_POST["code"]);
	        $title          =   $_POST["title"];
			$name			=	petikreplace($_POST["name"]);
	        $last_name      =	petikreplace($_POST["last_name"]);
			$contact_person	=	petikreplace($_POST["contact_person"]);
	        $contact_person1=	petikreplace($_POST["contact_person1"]);
	        $contact_person2=	petikreplace($_POST["contact_person2"]);
	        $contact_person3=	petikreplace($_POST["contact_person3"]);
			$client_type	=	(empty($_POST["client_type"])) ? 0 : $_POST["client_type"];
			$address		=	$_POST["address"];
			$zip_code		=	$_POST["zip_code"];
			$country_id		=	(empty($_POST["country_id"])) ? 0 : $_POST["country_id"];
			$state_id		=	(empty($_POST["state_id"])) ? 0 : $_POST["state_id"];
			$phone			=	$_POST["phone"];
	        $phone1			=	$_POST["phone1"];
			$fax			=	$_POST["fax"];
			$email			=	$_POST["email"];
			$web			=	$_POST["web"];	
	        $bank_name      =   $_POST["bank_name"];
	        $bank_branch    =   $_POST["bank_branch"];	
			$bank_account	=	$_POST["bank_account"];
	        $bank_account_no=   $_POST["bank_account_no"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update client set code='$code', title='$title', name='$name', last_name='$last_name', contact_person='$contact_person', contact_person1='$contact_person1', contact_person2='$contact_person2', contact_person3='$contact_person3', client_type='$client_type', address='$address', zip_code='$zip_code', country_id='$country_id', state_id='$state_id', phone='$phone', phone1='$phone1', fax='$fax', email='$email', web='$web', bank_name='$bank_name', bank_branch='$bank_branch', bank_account='$bank_account', bank_account_no='$bank_account_no', location_id='$location_id', active='$active', uid='$uid', dlu='$dlu' where syscode='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update price type
	function update_price_type($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	petikreplace($_POST["name"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update price_type set name='$name', active='$active', uid='$uid', dlu='$dlu' where id='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update set client balance
	function update_set_client_balance($ref){
		$dbpdo = DB::create();
		
		try {
			
			$client_code		= 	$_POST["client_code"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			
			
			
			
			//----------update item receivable detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 	= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_ref	= $_POST[old_ref_.$i];
				$ref 		= $_POST[ref_.$i];
				
				if ( !empty($ref) && !empty($client_code) ) {
					$date 			= date("Y-m-d", strtotime($_POST[date_.$i]) );
					$due_date 		= date("Y-m-d", strtotime($_POST[due_date_.$i]) );
					$amount 		= numberreplace($_POST[amount_.$i]);				
					$currency_code 	= $_POST[currency_code_.$i];
					$rate 			= numberreplace($_POST[rate_.$i]);
					
					$sqlstr = "select ref from sales_invoice where ref='$old_ref' and client_code='$client_code' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update sales_invoice set ref='$ref', date='$date', due_date='$due_date', total='$amount', currency_code='$currency_code', rate='$rate', uid='$uid', dlu='$dlu' where ref='$old_ref' and client_code='$client_code' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//update AR
							$sqlstr="select ref from ar where ref='$old_ref' and invoice_type='OPEN' and ref_type='OPEN' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							$num2 = $sql->rowCount();
							
							if($num2 > 0) {
								$sqlstr="update ar set ref='$ref', invoice_no='$ref', date='$date', due_date='$due_date', contact_code='$client_code', debit_amount='$amount', currency_code='$currency_code', rate='$rate', uid='$uid', dlu='$dlu' where ref='$old_ref' and invoice_type='OPEN' and ref_type='OPEN' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							} else {
								$sqlstr="insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$amount', 0, 'OPEN', 'OPEN', '$currency_code', '$rate', '', '', '', '', '$uid', '$dlu')";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							}
							
								
						} else {
							$sqlstr="delete from sales_invoice where ref='$old_ref' and client_code='$client_code' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//Delete AR
							$sqlstr="delete from ar where ref='$old_ref' and invoice_type='OPEN' and ref_type='OPEN' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$sqlstr="insert into sales_invoice (ref, date, status, client_code, due_date, total, currency_code, rate, opening_balance, uid, dlu) values('$ref', '$date', '$status', '$client_code', '$due_date', '$amount', '$currency_code', '$rate', '1', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//insert AR
						$sqlstr="insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$amount', 0, 'OPEN', 'OPEN', '$currency_code', '$rate', '', '', '', '', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
			
			
			//----------update item deposit detail
			$jmldata2 = (empty($_POST['jmldata2'])) ? 0 : $_POST['jmldata2'];
			
			for ($i=0; $i<=$jmldata2; $i++) {
				$delete2 	= (empty($_POST[delete2_.$i])) ? 0 : $_POST[delete2_.$i];
				
				$old_ref2	= $_POST[old_ref2_.$i];
				$ref2 		= $_POST[ref2_.$i];
				
				if ( !empty($ref2) && !empty($client_code) ) {
					$date2 			= date("Y-m-d", strtotime($_POST[date2_.$i]) );
					$deposit2 		= numberreplace($_POST[deposit2_.$i]);				
					$currency_code2 = $_POST[currency_code2_.$i];
					$rate2 			= numberreplace($_POST[rate2_.$i]);
					
					$sqlstr = "select ref from receipt where ref='$old_ref2' and client_code='$client_code' and opening_balance=1 ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete2 == 0) {
							$sqlstr="update receipt set ref='$ref2', date='$date2', deposit='$deposit2', currency_code='$currency_code2', rate='$rate2',  uid='$uid', dlu='$dlu' where ref='$old_ref2' and client_code='$client_code' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
								
						} else {
							$sqlstr="delete from receipt where ref='$old_ref2' and client_code='$client_code' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$sqlstr="insert into receipt (ref, date, status, client_code, deposit, currency_code, rate, opening_balance, uid, dlu) values('$ref2', '$date2', 'Released', '$client_code', '$deposit2', '$currency_code2', '$rate2', '1', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
			
			//----------update item cheque detail		
			$jmldata3 = (empty($_POST['jmldata3'])) ? 0 : $_POST['jmldata3'];
			
			for ($i=0; $i<=$jmldata3; $i++) {
				$delete3 	= (empty($_POST[delete3_.$i])) ? 0 : $_POST[delete3_.$i];
				
				$old_ref3	= $_POST[old_ref3_.$i];
				$ref3 		= $_POST[ref3_.$i];
				
				if ( !empty($ref3) && !empty($client_code) ) {
					$date3 			= date("Y-m-d", strtotime($_POST[date3_.$i]) );
					$cheque_date3	= date("Y-m-d", strtotime($_POST[cheque_date3_.$i]) );
					$amount3 		= numberreplace($_POST[amount3_.$i]);				
					$currency_code3 = $_POST[currency_code3_.$i];
					$rate3 			= numberreplace($_POST[rate3_.$i]);
					$cheque_no3 	= $_POST[cheque_no3_.$i];
					$bank_name3 	= $_POST[bank_name3_.$i];
					$account_code3 	= $_POST[account_code3_.$i];
					
					$sqlstr = "select ref from arc where ref='$old_ref3' and client_code='$client_code' and type='openingbalance' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete3 == 0) {
							$sqlstr="update arc set ref='$ref3', date='$date3', cheque_date='$cheque_date3', amount='$amount3', currency_code='$currency_code3', rate='$rate3', cheque_no='$cheque_no3', bank_name='$bank_name3', account_code='$account_code3', uid='$uid', dlu='$dlu' where ref='$old_ref3' and client_code='$client_code' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
								
						} else {
							$sqlstr="delete from arc where ref='$old_ref3' and client_code='$client_code' and type='openingbalance' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$sqlstr="insert into arc (ref, date, client_code, cheque_date, amount, currency_code, rate, type, cheque_no, bank_name, account_code, uid, dlu) values('$ref3', '$date3', '$client_code', '$cheque_date3', '$amount3', '$currency_code3', '$rate3', 'openingbalance', '$cheque_no3', '$bank_name3', '$account_code3', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update marketing
	function update_marketing($ref){
		$dbpdo = DB::create();
		
		try {
			
			$name			=	petikreplace($_POST["name"]);
			$contact_person	=	$_POST["contact_person"];
			$address		=	$_POST["address"];
			$zip_code		=	$_POST["zip_code"];
			$country_id		=	(empty($_POST["country_id"])) ? 0 : $_POST["country_id"];
			$state_id		=	(empty($_POST["state_id"])) ? 0 : $_POST["state_id"];
			$phone			=	$_POST["phone"];
			$fax			=	$_POST["fax"];
			$email			=	$_POST["email"];
			$web			=	$_POST["web"];		
			$bank_account	=	$_POST["bank_account"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update marketing set name='$name', contact_person='$contact_person', address='$address', zip_code='$zip_code', country_id='$country_id', state_id='$state_id', phone='$phone', fax='$fax', email='$email', web='$web', bank_account='$bank_account', active='$active', uid='$uid', dlu='$dlu' where code='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update quotation
	function update_quotation($ref){
		
		$dbpdo = DB::create();
		
		try {
		
			
			
			//----------update quotation detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {				
					$qty 		= numberreplace($_POST[qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$discount	= numberreplace($_POST[discount_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					
					$sqlstr = "select ref from quotation_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update quotation_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', discount='$discount', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						
						} else {
							$sqlstr="delete from quotation_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('quotation_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into quotation_detail (ref, item_code, uom_code, qty, discount, unit_price, amount, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$quotation', '$unit_price', '$amount', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
			
			
			//-get amount
			$sqlstr = "select sum(amount) amount from quotation_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;

			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$employee_id		= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$client_code		=	$_POST["client_code"];
			$date_from			=	date("Y-m-d", strtotime($_POST["date_from"]));
			$date_to			=	date("Y-m-d", strtotime($_POST["date_to"]));
			$top				=	$_POST["top"];
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$total				=	$sub_total; //numberreplace($_POST["total"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update quotation set date='$date', status='$status', top='$top', client_code='$client_code', date_from='$date_from', date_to='$date_to', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', currency_code='$currency_code', rate='$rate', employee_id='$employee_id', total='$total', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update sales order
	function update_sales_order($ref){
		
		$dbpdo = DB::create();
		
		try {
		
			
			
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {				
					$qty 		= numberreplace($_POST[qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$discount	= numberreplace($_POST[discount_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					
					$sqlstr = "select ref from sales_order_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update sales_order_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', discount='$discount', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						
						} else {
							$sqlstr="delete from sales_order_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('sales_order_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into sales_order_detail (ref, item_code, uom_code, qty, discount, unit_price, amount, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$quotation', '$unit_price', '$amount', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
			
			
			//-get amount
			$sqlstr = "select sum(amount) amount from sales_order_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;

			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$employee_id		= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$client_code		=	$_POST["client_code"];
			$qo_ref				=	$_POST["qo_ref"];
			$top				=	$_POST["top"];
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$total				=	$sub_total + $freight_cost; //numberreplace($_POST["total"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update sales_order set date='$date', status='$status', top='$top', client_code='$client_code', qo_ref='$qo_ref', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', currency_code='$currency_code', rate='$rate', employee_id='$employee_id', total='$total', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update delivery order
	function update_delivery_order($ref){
		
		$dbpdo = DB::create();
		
		try {
		
			
			
			$status		= 	$_POST["status"];
			
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$so_ref			= $_POST[so_ref_.$i];
					$qty 			= numberreplace($_POST[qty_.$i]);
					$old_qty		= numberreplace($_POST[old_qty_.$i]);
					$ship_date 		= date("Y-m-d", strtotime($_POST[ship_date_.$i]));
					$line_item_so	= $_POST[line_item_so_.$i];
					
					$sqlstr = "select ref from delivery_order_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update delivery_order_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', ship_date='$ship_date' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty sales order
							if($status != "P") {
								$sqlstr="update sales_order_detail set qty_shp=ifnull(qty_shp,0) - $old_qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							
								$sqlstr="update sales_order_detail set qty_shp=ifnull(qty_shp,0) + $qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
							}
							
						} else {
							$sqlstr="delete from delivery_order_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							##--------update qty sales order						
							$sqlstr="update sales_order_detail set qty_shp=ifnull(qty_shp,0) - $qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();					
						}
						
						
					} else {
						$line = maxline('delivery_order_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into delivery_order_detail (ref, so_ref, item_code, uom_code, qty, ship_date, line_item_so, line) values ('$ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$ship_date', '$line_item_so', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty sales order
						if($status != "P" && $status != "C") {
							$sqlstr="update sales_order_detail set qty_shp=ifnull(qty_shp,0) + $qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
					}
					
					
					
				}
			}
			
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));			
			$location_id		= 	$_POST["location_id"];
			$po_number			= 	$_POST["po_number"];
			$ship_to			= 	$_POST["ship_to"];
			$client_code		=	$_POST["client_code"];
			$memo				= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update delivery_order set date='$date', status='$status', location_id='$location_id', ship_to='$ship_to', po_number='$po_number', client_code='$client_code', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			
			
			/*update status sales order : S=Shipped in Part (dikirim sebagian)
										  F=Shipped in Full (dikirm semua)
										  C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
			*/
			$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_shp,0)) qty_shp from sales_order_detail group by ref having ref='$so_ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$qty_shp = $data->qty_shp;
			$qty = $data->qty;
			
			if($qty > 0) {
				if($qty_shp < $qty ) {
					$sqlstr="update sales_order set status='S' where ref='$so_ref' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();	
				}
				
				if($qty_shp >= $qty ) {
					$sqlstr="update sales_order set status='F' where ref='$so_ref' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();	
				}
			}
			##*****************************************##
				
			
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----transfer delivery order
	function delivery_order_transfer($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$sqlstr="select a.ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.ship_date, a.line_item_so, a.line, c.date, c.location_id, d.unit_price, d.amount from delivery_order_detail a left join item b on a.item_code=b.syscode left join delivery_order c on a.ref=c.ref left join sales_order_detail d on a.so_ref=d.ref and a.item_code=d.item_code and a.line_item_so=d.line where a.ref='$ref' and ifnull(c.delivered,0)=0 order by a.line";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			while($data_do = $sql->fetch(PDO::FETCH_OBJ)) {
				//----------insert bincard (debit qty)
				
				$location_id	=	$data_do->location_id;
				$date		=	$data_do->date;
				$item_code	=	$data_do->item_code;
				$uom_code	=	$data_do->uom_code;
				$unit_price	=	$data_do->unit_price;			
				$qty	=	$data_do->qty;
				$amount	=	$qty * $unit_price;
				$line	=	$data_do->line;
				$memo			= 	$data_do->memo;
				$uid			=	$_SESSION["loginname"];
				$dlu			=	date("Y-m-d H:i:s");
				
				$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'delivery_order', '$memo', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
						
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			
			//-----------update delivered=1
			$sqlstr="update delivery_order set delivered=1, delivered_date='$dlu', uid_delivered='$uid' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----transfer delivery order
	function delivery_order_cancel_transfer($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
				
			//-----------delete bin card
			$sqlstr="delete from bincard where invoice_no='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//-----------update delivered=1
			$sqlstr="update delivery_order set delivered=0, delivered_cancel_date='$dlu', uid_delivered_cancel='$uid' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update sales invoice
	function update_sales_invoice($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$status		= 	$_POST["status"];
			
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					$do_ref 		= $_POST[do_ref_.$i];
					$so_ref 		= $_POST[so_ref_.$i];
								
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$discount	= numberreplace($_POST[discount_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					
					$line_item_do	= $_POST[line_item_do_.$i];
					$line_item_so	= $_POST[line_item_so_.$i];
					
					$sqlstr = "select ref from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update sales_invoice_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', discount='$discount', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty delivery order
							if($status != "P" && $status != "C") {
								$sqlstr="update delivery_order_detail set qty_si=ifnull(qty_si,0) - $old_qty + $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							}
						
						} else {
							$sqlstr="delete from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty delivery order						
							$sqlstr="update delivery_order_detail set qty_si=ifnull(qty_si,0) - $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into sales_invoice_detail (ref, do_ref, so_ref, item_code, uom_code, qty, discount, unit_price, amount, line_item_do, line_item_so, line) values ('$ref', '$do_ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$amount', '$line_item_do', '$line_item_so', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty delivery order
						if($status != "P" && $status != "C") {
							$sqlstr="update delivery_order_detail set qty_si=ifnull(qty_si,0) + $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
					}
					
					
					
				}
			}
			
			
			//-get amount
			$sqlstr = "select sum(amount) amount from sales_invoice_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;

			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));		
			$employee_id		= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$client_code		=	$_POST["client_code"];
			$ship_to			=	$_POST["ship_to"];
			$bill_to			=	$_POST["bill_to"];
			$top				=	$_POST["top"];
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$total				=	$sub_total + $freight_cost; //numberreplace($_POST["total"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update sales_invoice set date='$date', status='$status', top='$top', client_code='$client_code', ship_to='$ship_to', bill_to='$bill_to', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', currency_code='$currency_code', rate='$rate', employee_id='$employee_id', total='$total', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//insert AR
			$sqlstr="delete from ar where ref='$ref' and invoice_type='SOI' and ref_type='SOI' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$sqlstr="insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$total', 0, 'SOI', 'SOI', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			/*update status delivery order : I=Invoice in Part (diinvoicekan sebagian)
										  	F=Invoice in Full (diinvoicekan semua)
										  	C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
			*/
			$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_si,0)) qty_si from delivery_order_detail group by ref having ref='$do_ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$qty_si = $data->qty_si;
			$qty = $data->qty;
			
			if($qty > 0) {
				if($qty_si < $qty ) {
					$sqlstr="update delivery_order set status='I' where ref='$do_ref' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();	
				}
				
				if($qty_si >= $qty ) {
					$sqlstr="update delivery_order set status='F' where ref='$do_ref' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();	
				}
			}
			##*****************************************##
			
			
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update sales return
	function update_sales_return($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$status			= 	$_POST["status"];
			$si_ref			=	$_POST["si_ref"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
				
				
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			$sub_total = 0;
			$total_charge = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$charge_p	= numberreplace($_POST[charge_p_.$i]);
					//$discount	= numberreplace($_POST[discount_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					
					$line_item_si	= $_POST[line_item_si_.$i];
					
					$amount_charge	= ($charge_p * ($unit_price * $qty))/100;
					$total_charge	= $total_charge + $amount_charge;
					
					$sub_total		= $sub_total + $amount - $amount_charge;
					
					$sqlstr = "select ref from sales_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update sales_return_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', charge_p='$charge_p', discount='$discount', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							
							
							##--------update qty sales invoice
							if($status == "R") {
								$sqlstr="update sales_invoice_detail set qty_rtn=ifnull(qty_rtn,0) - $old_qty + $qty where ref='$si_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_si' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
								//----------update bincard (credit qty)
								$sqlsi = "select location_id from sales_invoice where ref='$si_ref' ";
								$sql=$dbpdo->prepare($sqlsi);
								$sql->execute();
								$datasi = $sql->fetch(PDO::FETCH_OBJ);
								
								$old_location_id = $datasi->location_id;
								
								$sqlstr="update bincard set date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_price', debit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='sales_return' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
							}
						
						} else {
							$sqlstr="delete from sales_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							##--------update qty sales invoice						
							$sqlstr="update sales_invoice_detail set qty_rtn=ifnull(qty_rtn,0) - $qty where ref='$si_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_si' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//----------delete bincard (credit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='sales_return' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$line = maxline('sales_return_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into sales_return_detail (ref, item_code, uom_code, qty, discount, unit_price, charge_p, amount, line_item_si, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$charge_p', '$amount', '$line_item_si', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty sales invoice
						if($status == "R") {
							$sqlstr="update sales_invoice_detail set qty_rtn=ifnull(qty_rtn,0) + $qty where ref='$si_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_si' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------insert bincard (debit qty)
							$sqlsi = "select location_id from sales_invoice where ref='$si_ref' ";
							$sql=$dbpdo->prepare($sqlsi);
							$sql->execute();
							$datasi = $sql->fetch(PDO::FETCH_OBJ);
							
							$location_id = $datasi->location_id;
							
							$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'sales_return', '$memo', '$item_code', '$uom_code', '$unit_price', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";
							
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##*****************************************##
							
						}
						
					}
					
					
					
				}
			}
			
			
			//-get amount
			$sqlstr = "select sum(amount) amount from sales_return_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;
			
			$client_code		=	$_POST["client_code"];			
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$total				=	$sub_total; //numberreplace($_POST["total"]);
			
			$sqlstr="update sales_return set date='$date', status='$status', si_ref='$si_ref', client_code='$client_code', tax_code='$tax_code', tax_rate='$tax_rate', currency_code='$currency_code', rate='$rate', total='$total', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();	
			
			##insert AR (credit)
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			$total	=	$total + $tax_total; // + $total_charge;
			
			$sqlstr="delete from ar where ref='$ref' and invoice_type='SIR' and ref_type='SIR' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$sqlstr="insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '1900-01-01', 'C', '$client_code', '', 0, '$total', 'SIR', 'SIR', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
				
			
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update purchase return
	function update_purchase_return($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
	        $date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$pi_ref				=	$_POST["pi_ref"];
	        $uid			    =	$_SESSION["loginname"];
			$dlu			    =	date("Y-m-d H:i:s");
			
	        //get location ID
	        $sqlpi = "select location_id from purchase_invoice where ref='$pi_ref'";
	        $sql=$dbpdo->prepare($sqlpi);
			$sql->execute();
			$datapi = $sql->fetch(PDO::FETCH_OBJ);
			
	        $location_id = $datapi->location_id;
	        	
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_qty 			= numberreplace($_POST[old_qty_.$i]);
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					
					$qty 		= numberreplace($_POST[qty_.$i]);
					$unit_cost	= numberreplace($_POST[unit_cost_.$i]);
					//$discount	= numberreplace($_POST[discount_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					
					$line_item_pi	= $_POST[line_item_pi_.$i];
					
					$sqlstr = "select ref from purchase_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update purchase_return_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_cost='$unit_cost', discount='$discount', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty purchase invoice
							if($status != "P") {
								$sqlstr="update purchase_invoice_detail set qty_rtn=ifnull(qty_rtn,0) - $old_qty + $qty where ref='$pi_ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$line_item_pi' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();					
								##*****************************************##
	                            
	                            //----------update bincard (credit qty)
								$amount = $qty * $unit_cost;
								
								$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_cost', credit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='purchase_return' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
							}
						
						} else {
							$sqlstr="delete from purchase_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							##--------update qty purchase invoice						
							$sqlstr="update purchase_invoice_detail set qty_rtn=ifnull(qty_rtn,0) - $old_qty where ref='$pi_ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$line_item_pi' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();					
							##*****************************************##
	                        
	                        //----------delete bincard (credit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='purchase_return' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$line = maxline('purchase_return_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into purchase_return_detail (ref, item_code, uom_code, qty, discount, unit_cost, amount, line_item_pi, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_cost', '$amount', '$line_item_pi', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty purchase invoice
						if($status != "P") {
							$sqlstr="update purchase_invoice_detail set qty_rtn=ifnull(qty_rtn,0) + $qty where ref='$pi_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_pi' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();					
							##*****************************************##
							
	                        //----------insert bincard (debit qty)
	                        $amount = $qty * $unit_cost;
							$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_return', '$memo', '$item_code', '$uom_code', '0', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
							
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						}
						
					}
					
					
					
				}
			}
			
			
			
			//-get amount
			$sqlstr = "select sum(amount) amount from purchase_return_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;
						
			$vendor_code		=	$_POST["vendor_code"];			
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$total				=	$sub_total; //numberreplace($_POST["total"]);
			
			$sqlstr="update purchase_return set date='$date', status='$status', pi_ref='$pi_ref', vendor_code='$vendor_code', tax_code='$tax_code', tax_rate='$tax_rate', currency_code='$currency_code', rate='$rate', total='$total', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();	
			
			//-------insert AP
			$sqlstr="delete from ap where ref='$ref' and invoice_type='PIR' and ref_type='PIR' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$sqlstr="insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '1900-01-01', 'V', '$vendor_code', '', '$total', 0, 'PIR', 'PIR', '$currency_code', '$rate', '', '', '', '$memo', '$uid', '$dlu')";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update good return
	function update_good_return($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$vendor_code		=	$_POST["vendor_code"];
			$reason				=	$_POST["reason"];
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$memo				= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			
			
			
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
				
			$sqlstr="update good_return set date='$date', status='$status', vendor_code='$vendor_code', reason='$reason', location_id='$location_id', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update purchase request detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$gr_ref 		= $_POST[gr_ref_.$i];
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) && !empty($gr_ref) ) {				
					$qty 			= numberreplace($_POST[qty_.$i]);
					$old_qty		= numberreplace($_POST[old_qty_.$i]);
					$line_item_gr	= $_POST[line_item_gr_.$i];
					
					$sqlstr = "select ref from good_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update good_return_detail set gr_ref='$gr_ref', item_code='$item_code', uom_code='$uom_code', qty='$qty' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty good receipt
							if($status != "P") {
								$sqlstr="update good_receipt_detail set qty_rtn=ifnull(qty_rtn,0) - $old_qty + $qty where ref='$gr_ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$line_item_gr' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
								//----------insert bincard (debit qty)
								$sqlstr="update bincard set date='$date', item_code='$item_code', uom_code='$uom_code', credit_qty='$qty', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='good_return' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();							
								##*****************************************##							
							}
							
								
						} else {
							$sqlstr="delete from good_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							##--------update qty good receipt
							$sqlstr="update good_receipt_detail set qty_rtn=ifnull(qty_rtn,0) - $old_qty where ref='$gr_ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$line_item_gr' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------delete bincard (credit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='good_return' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();							
							##*****************************************##							
												
						}
						
						
					} else {
						$line = maxline('good_return_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into good_return_detail (ref, gr_ref, item_code, uom_code, qty, line_item_gr, line) values ('$ref', '$gr_ref', '$item_code', '$uom_code', '$qty', '$line_item_gr', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty good receipt
						if($status != "P") {
							$sqlstr="update good_receipt_detail set qty_rtn=ifnull(qty_rtn,0) + $qty where ref='$gr_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_gr' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------insert bincard (debit qty)
							$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'good_return', '$memo', '$item_code', '$uom_code', '0', 0, '$qty', '0', '$line', '$uid', '$dlu')";
							
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##*****************************************##
							
						}
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update delivery return
	function update_delivery_return($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$client_code		=	$_POST["client_code"];
			$reason				=	$_POST["reason"];
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$memo				= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			
			
			
			$sqlstr="update delivery_return set date='$date', status='$status', client_code='$client_code', reason='$reason', location_id='$location_id', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//----------update purchase request detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$do_ref 		= $_POST[do_ref_.$i];
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) && !empty($do_ref) ) {				
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					$line_item_do	= $_POST[line_item_do_.$i];
					
					$sqlstr = "select ref from delivery_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update delivery_return_detail set do_ref='$do_ref', item_code='$item_code', uom_code='$uom_code', qty='$qty' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";						
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty return delivery order
							if($status == "R") {
								$sqlstr="update delivery_order_detail set qty_rtn=ifnull(qty_rtn,0) - $old_qty + $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
								//----------update bincard (credit qty)
								$sqlstr="update bincard set date='$date', item_code='$item_code', uom_code='$uom_code', debit_qty='$qty', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='delivery_return' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
							}
							
								
						} else {
							$sqlstr="delete from delivery_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							##--------update qty return delivery order						
							$sqlstr="update delivery_order_detail set qty_rtn=ifnull(qty_rtn,0) - $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------delete bincard (credit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='delivery_return' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$line = maxline('delivery_return_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into delivery_return_detail (ref, do_ref, item_code, uom_code, qty, line_item_gr, line) values ('$ref', '$do_ref', '$item_code', '$uom_code', '$qty', '$line_item_do', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty return delivery order
						if($status == "R") {
							$sqlstr="update delivery_order_detail set qty_rtn=ifnull(qty_rtn,0) + $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------insert bincard (debit qty)
							$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'delivery_return', '$reason', '$item_code', '$uom_code', '0', '$qty', 0, '0', '$line', '$uid', '$dlu')";
							
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##*****************************************##
							
						}
						
					}
					
					
					
				}
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	#*********************VENDOR OPENING BALANCE*****************#
	//-----update set vendor balance
	function update_set_vendor_balance($ref){
		$dbpdo = DB::create();
		
		try {
			
			$vendor_code		= 	$_POST["vendor_code"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			
			
			
			
			//----------update item receivable detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 	= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_ref	= $_POST[old_ref_.$i];
				$ref 		= $_POST[ref_.$i];
				
				if ( !empty($ref) && !empty($vendor_code) ) {
					$date 			= date("Y-m-d", strtotime($_POST[date_.$i]) );
					$due_date 		= date("Y-m-d", strtotime($_POST[due_date_.$i]) );
					$amount 		= numberreplace($_POST[amount_.$i]);				
					$currency_code 	= $_POST[currency_code_.$i];
					$rate 			= numberreplace($_POST[rate_.$i]);
					
					$sqlstr = "select ref from purchase_invoice where ref='$old_ref' and vendor_code='$vendor_code' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update purchase_invoice set ref='$ref', date='$date', due_date='$due_date', total='$amount', currency_code='$currency_code', rate='$rate', uid='$uid', dlu='$dlu' where ref='$old_ref' and vendor_code='$vendor_code' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//update AP
							$sqlstr="select ref from ap where ref='$old_ref' and invoice_type='OPEN' and ref_type='OPEN' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							$num2 = $sql->rowCount();
							
							if($num2 > 0) {
								$sqlstr="update ap set ref='$ref', invoice_no='$ref', date='$date', due_date='$due_date', contact_code='$vendor_code', credit_amount='$amount', currency_code='$currency_code', rate='$rate', uid='$uid', dlu='$dlu' where ref='$old_ref' and invoice_type='OPEN' and ref_type='OPEN' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							} else {
								$sqlstr="insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'V', '$vendor_code', '', 0, '$amount', 'OPEN', 'OPEN', '$currency_code', '$rate', '', '', '', '', '$uid', '$dlu')";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							}
							
								
						} else {
							$sqlstr="delete from purchase_invoice where ref='$old_ref' and vendor_code='$vendor_code' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//delete AP
							$sqlstr="delete from ap where ref='$old_ref' and invoice_type='OPEN' and ref_type='OPEN' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$sqlstr="insert into purchase_invoice (ref, date, status, vendor_code, due_date, total, currency_code, rate, opening_balance, uid, dlu) values('$ref', '$date', '$status', '$vendor_code', '$due_date', '$amount', '$currency_code', '$rate', '1', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//insert AP
						$sqlstr="insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'V', '$vendor_code', '', 0, '$amount', 'OPEN', 'OPEN', '$currency_code', '$rate', '', '', '', '', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
			
			
			//----------update item deposit detail
			$jmldata2 = (empty($_POST['jmldata2'])) ? 0 : $_POST['jmldata2'];
			
			for ($i=0; $i<=$jmldata2; $i++) {
				$delete2 	= (empty($_POST[delete2_.$i])) ? 0 : $_POST[delete2_.$i];
				
				$old_ref2	= $_POST[old_ref2_.$i];
				$ref2 		= $_POST[ref2_.$i];
				
				if ( !empty($ref2) && !empty($vendor_code) ) {
					$date2 			= date("Y-m-d", strtotime($_POST[date2_.$i]) );
					$deposit2 		= numberreplace($_POST[deposit2_.$i]);				
					$currency_code2 = $_POST[currency_code2_.$i];
					$rate2 			= numberreplace($_POST[rate2_.$i]);
					
					$sqlstr = "select ref from payment where ref='$old_ref2' and vendor_code='$vendor_code' and opening_balance=1 ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete2 == 0) {
							$sqlstr="update payment set ref='$ref2', date='$date2', deposit='$deposit2', currency_code='$currency_code2', rate='$rate2',  uid='$uid', dlu='$dlu' where ref='$old_ref2' and vendor_code='$vendor_code' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
								
						} else {
							$sqlstr="delete from payment where ref='$old_ref2' and vendor_code='$vendor_code' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$sqlstr="insert into payment (ref, date, status, vendor_code, deposit, currency_code, rate, opening_balance, uid, dlu) values('$ref2', '$date2', 'Released', '$vendor_code', '$deposit2', '$currency_code2', '$rate2', '1', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					
				}
			}
			
			//----------update item cheque detail		
			$jmldata3 = (empty($_POST['jmldata3'])) ? 0 : $_POST['jmldata3'];
			
			for ($i=0; $i<=$jmldata3; $i++) {
				$delete3 	= (empty($_POST[delete3_.$i])) ? 0 : $_POST[delete3_.$i];
				
				$old_ref3	= $_POST[old_ref3_.$i];
				$ref3 		= $_POST[ref3_.$i];
				
				if ( !empty($ref3) && !empty($vendor_code) ) {
					$date3 			= date("Y-m-d", strtotime($_POST[date3_.$i]) );
					$cheque_date3	= date("Y-m-d", strtotime($_POST[cheque_date3_.$i]) );
					$amount3 		= numberreplace($_POST[amount3_.$i]);				
					$currency_code3 = $_POST[currency_code3_.$i];
					$rate3 			= numberreplace($_POST[rate3_.$i]);
					$cheque_no3 	= $_POST[cheque_no3_.$i];
					$bank_name3 	= $_POST[bank_name3_.$i];
					$account_code3 	= $_POST[account_code3_.$i];
					
					$sqlstr = "select ref from apc where ref='$old_ref3' and vendor_code='$vendor_code' and type='openingbalance' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete3 == 0) {
							$sqlstr="update apc set ref='$ref3', date='$date3', cheque_date='$cheque_date3', amount='$amount3', currency_code='$currency_code3', rate='$rate3', cheque_no='$cheque_no3', bank_name='$bank_name3', account_code='$account_code3', uid='$uid', dlu='$dlu' where ref='$old_ref3' and vendor_code='$vendor_code' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
								
						} else {
							$sqlstr="delete from apc where ref='$old_ref3' and vendor_code='$vendor_code' and type='openingbalance' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$sqlstr="insert into apc (ref, date, vendor_code, cheque_date, amount, currency_code, rate, type, cheque_no, bank_name, account_code, uid, dlu) values('$ref3', '$date3', '$vendor_code', '$cheque_date3', '$amount3', '$currency_code3', '$rate3', 'openingbalance', '$cheque_no3', '$bank_name3', '$account_code3', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
				}
			}
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	#******************END VENDOR OPENING BALANCE*****************#		
	
	
	//-----update receipt
	function update_receipt($ref){
		$dbpdo = DB::create();
		
		try {
		
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$client_code	=	$_POST["client_code"];
			$memo			= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			
			
			
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_invoice_no	 	= $_POST[old_invoice_no_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$invoice_no 	= $_POST[invoice_no_.$i];
				$amount_paid 	= numberreplace($_POST[amount_paid_.$i]);
				
				if ( !empty($invoice_no) ) {	
					$invoice_date		= date("Y-m-d", strtotime($_POST[invoice_date_.$i]));
					$invoice_due_date	= date("Y-m-d", strtotime($_POST[invoice_due_date_.$i]));
					$amount_due		= numberreplace($_POST[amount_due_.$i]);
					$discount 		= numberreplace($_POST[discount_.$i]);
					$currency_code 	= $_POST[currency_code_.$i];					
					$rate			= numberreplace($_POST[rate_.$i]);
					$ref_type		= $_POST[transaction_.$i];				
					$amount_due		= numberreplace($_POST[amount_due_.$i]);
					$amount 		= $amount_paid - $discount;
					
					$sqlstr = "select ref from receipt_detail where ref='$ref' and invoice_no='$old_invoice_no' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update receipt_detail set invoice_no='$invoice_no', invoice_date='$invoice_date', invoice_due_date='$invoice_due_date', discount='$discount', amount_paid='$amount_paid', invoice_currency_code='$invoice_currency_code', invoice_rate='$rate', amount_due='$amount_due', amount='$amount' where ref='$ref' and invoice_no='$old_invoice_no' and line='$old_line'";						
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//update AR
							$sqlstr="update ar set invoice_no='$invoice_no', date='$date', due_date='$invoice_due_date', contact_code='$client_code', credit_amount='$amount', discount_amount='$discount', currency_code='$currency_code', rate='$rate', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_no='$old_invoice_no' and invoice_type='RCI' and ref_type='$ref_type' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//update DPS (Deposit)
							if($amount < 0) {
								$credit = $amount * -1;
								
								$dpscek = "select ref from dps where ref='$ref' and invoice_no='$old_invoice_no' and invoice_type='RCI' and ref_type='RCI' ";
								$sql=$dbpdo->prepare($dpscek);
								$sql->execute();
								$rowsdps = $sql->rowCount();
							
								if($rowsdps > 0 ) {
									$sqlstr="update dps set invoice_no='$invoice_no', date='$date', contact_code='$client_code', credit_amount='$credit', currency_code='$currency_code', rate='$rate', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_no='$old_invoice_no' and invoice_type='RCI' and ref_type='RCI' ";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();
								}
								
							}
							
							
						} else {
							$sqlstr="delete from receipt_detail where ref='$ref' and invoice_no='$old_invoice_no' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//delete AR
							$sqlstr="delete from ar where ref='$ref' and invoice_no='$old_invoice_no' and invoice_type='RCI' and ref_type='$ref_type' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//delete DPS
							$sqlstr="delete from dps where ref='$ref' and invoice_no='$old_invoice_no' and invoice_type='RCI' and ref_type='$ref_type' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('receipt_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into receipt_detail (ref, invoice_no, invoice_date, invoice_due_date, discount, amount_paid, invoice_currency_code, invoice_rate, ref_type, amount_due, amount, line) values ('$ref', '$invoice_no', '$invoice_date', '$invoice_due_date', '$discount', '$amount_paid', '$currency_code', '$rate', '$ref_type', '$amount_due', '$amount', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						if($ref_type != "DPS") {
							//insert AR
							$sqlstr="insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, discount_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$invoice_no', '$date', '$invoice_due_date', 'C', '$client_code', '', 0, '$amount', '$discount', 'RCI', '$ref_type', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', '$uid', '$dlu')";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						}
						
						
						//insert DPS
						if($ref_type == "DPS") {
							if($amount < 0) {
								
								$credit = $amount * -1;
								
								$sqlstr="insert into dps(ref, invoice_no, date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$invoice_no', '$date', 'C', '$client_code', '', 0, '$credit', 'RCI', 'RCI', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', '$uid', '$dlu')";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();	
							}
						}
						
						
					}
					
				}
			}
			
			
			$status				= 	$_POST["status"];			
			$receipt_type		=	$_POST["receipt_type"];
			$cheque_no			=	$_POST["cheque_no"];
			$cheque_date		=	date("Y-m-d", strtotime($_POST["cheque_date"]));
			$bank_name			=	$_POST["bank_name"];
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$credit_card_holder	=	$_POST["credit_card_holder"];
			$credit_card_expired =	date("Y-m-d", strtotime($_POST["credit_card_expired"]));
			$account_code		= 	$_POST["account_code"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);			
			$amount				=	numberreplace($_POST["amount"]);
			
			$round_amount		=	numberreplace($_POST["round_amount"]);
			$round_amount_account	=	$_POST["round_amount_account"];
			if($round_amount == 0) {
				$round_amount_account = "";	
			}
			
			$bank_charge		=	numberreplace($_POST["bank_charge"]);
			$bank_charge_account	= 	$_POST["bank_charge_account"];
			if($bank_charge == 0) {
				$bank_charge_account = "";
			}
			
			$sub_total			=	numberreplace($_POST["sub_total"]);
			$deposit			=	numberreplace($_POST["deposit"]);
			$type				=	$_POST["type"];
			
			$total				=	numberreplace($_POST["total"]);
			
			$sqlstr="update receipt set date='$date', status='$status', client_code='$client_code', receipt_type='$receipt_type', cheque_no='$cheque_no', cheque_date='$cheque_date', bank_name='$bank_name', credit_card_no='$credit_card_no', credit_card_code='$credit_card_code', credit_card_holder='$credit_card_holder', credit_card_expired='$credit_card_expired', account_code='$account_code', currency_code='$currency_code', rate='$rate', amount='$amount', deposit='$deposit', sub_total='$sub_total', type='$type', memo='$memo', round_amount='$round_amount', round_amount_account='$round_amount_account', bank_charge='$bank_charge', bank_charge_account='$bank_charge_account', total='$total', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			if($receipt_type == "giro" || $receipt_type == "cheque") {
				
				//insert ARC
				$sqlstr="update arc date='$date', client_code='$client_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();				
				
			}
			
			
			//update DPS (Deposit)
			if($deposit < 0) {
				
				$debit = $deposit * -1;
				
				$dpscek = "select ref from dps where ref='$ref' and invoice_no='$ref' and invoice_type='RCI' and ref_type='RCI' ";
				$sql=$dbpdo->prepare($dpscek);
				$sql->execute();
				$rowsdps = $sql->rowCount();
				
				if($rowsdps > 0) {
					$sqlstr="update dps set invoice_no='$ref', date='$date', contact_code='$client_code', debit_amount='$debit', currency_code='$currency_code', rate='$rate', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_no='$ref' and invoice_type='RCI' and ref_type='RCI' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr="insert into dps (ref, invoice_no, date, contact_code, contact_type, debit_amount, currency_code, rate, description, invoice_type, ref_type, uid, dlu) values ('$ref', '$ref', '$date', '$client_code', 'C', '$debit', '$currency_code', '$rate', '$memo', 'RCI', 'RCI', '$uid', '$dlu') ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}								
				
			}
				
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update payment
	function update_payment($ref){
		$dbpdo = DB::create();
		
		try {
		
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$vendor_code	=	$_POST["vendor_code"];
			$memo			= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			
			
			
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_invoice_no	 	= $_POST[old_invoice_no_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$invoice_no 	= $_POST[invoice_no_.$i];
				$amount_paid 	= numberreplace($_POST[amount_paid_.$i]);
				
				if ( !empty($invoice_no) ) {	
					$invoice_date		= date("Y-m-d", strtotime($_POST[invoice_date_.$i]));
					$invoice_due_date	= date("Y-m-d", strtotime($_POST[invoice_due_date_.$i]));
					$amount_due		= numberreplace($_POST[amount_due_.$i]);
					$discount 		= numberreplace($_POST[discount_.$i]);
					$currency_code 	= $_POST[currency_code_.$i];					
					$rate			= numberreplace($_POST[rate_.$i]);
					$ref_type		= $_POST[transaction_.$i];				
					$amount_due		= numberreplace($_POST[amount_due_.$i]);
					$amount 		= $amount_paid - $discount;
					
					$sqlstr = "select ref from payment_detail where ref='$ref' and invoice_no='$old_invoice_no' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update payment_detail set invoice_no='$invoice_no', invoice_date='$invoice_date', invoice_due_date='$invoice_due_date', discount='$discount', amount_paid='$amount_paid', invoice_currency_code='$invoice_currency_code', invoice_rate='$rate', amount_due='$amount_due', amount='$amount' where ref='$ref' and invoice_no='$old_invoice_no' and line='$old_line'";			
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//update AP
							if($ref_type == 'PIR') {
								##credit
								if($amount < 0) {
									$amount_credit = $amount * -1;
								}
								$sqlstr="update ap set invoice_no='$invoice_no', date='$date', due_date='$invoice_due_date', contact_code='$vendor_code', credit_amount='$amount_credit', discount_amount='$discount', currency_code='$currency_code', rate='$rate', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_no='$old_invoice_no' and invoice_type='PMT' and ref_type='$ref_type' and line='$old_line' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();	
							} else {
								##debit
								$sqlstr="update ap set invoice_no='$invoice_no', date='$date', due_date='$invoice_due_date', contact_code='$vendor_code', debit_amount='$amount', discount_amount='$discount', currency_code='$currency_code', rate='$rate', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_no='$old_invoice_no' and invoice_type='PMT' and ref_type='$ref_type' and line='$old_line' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();	
							}
							
						
						} else {
							$sqlstr="delete from payment_detail where ref='$ref' and invoice_no='$old_invoice_no' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//delete AP
							$sqlstr="delete from ap where ref='$ref' and invoice_no='$old_invoice_no' and invoice_type='PMT' and ref_type='$ref_type' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('payment_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into payment_detail (ref, invoice_no, invoice_date, invoice_due_date, discount, amount_paid, invoice_currency_code, invoice_rate, ref_type, amount_due, amount, line) values ('$ref', '$invoice_no', '$invoice_date', '$invoice_due_date', '$discount', '$amount_paid', '$currency_code', '$rate', '$ref_type', '$amount_due', '$amount', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//insert AP
						$sqlv = "select a.* from (select syscode code, name, 'V' type from vendor where active=1 union all
			  select syscode code, concat(name,' (',phone,')') name, 'C' type from client where active=1 and ifnull(name,'') <> '' ) a where a.code='$vendor_code'";
			  			$sql=$dbpdo->prepare($sqlv);
						$sql->execute();
						$datav = $sql->fetch(PDO::FETCH_OBJ);
						
				  		$typev = $datav->type;
				  		
				  		if($ref_type == 'PIR') {
				  			##credit
				  			if($amount < 0) {
								$amount_credit = $amount * -1;
							}
							$sqlstr="insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, discount_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, line, uid, dlu) values('$ref', '$invoice_no', '$date', '$invoice_due_date', '$typev', '$vendor_code', '', 0, '$amount_credit', '$discount', 'PMT', '$ref_type', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', $line, '$uid', '$dlu')";
		                	$sql=$dbpdo->prepare($sqlstr);
		                	$sql->execute();
						} else {
							##debit
							$sqlstr="insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, discount_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$invoice_no', '$date', '$invoice_due_date', '$typev', '$vendor_code', '', '$amount', 0, '$discount', 'PMT', '$ref_type', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', '$uid', '$dlu')";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
						}
						
					}
					
				}
			}
			
					
			$status				= 	$_POST["status"];			
			$payment_type		=	$_POST["payment_type"];
			$cheque_no			=	$_POST["cheque_no"];
			$cheque_date		=	date("Y-m-d", strtotime($_POST["cheque_date"]));
			$bank_name			=	$_POST["bank_name"];
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$credit_card_holder	=	$_POST["credit_card_holder"];
			$credit_card_expired =	date("Y-m-d", strtotime($_POST["credit_card_expired"]));
			$account_code		= 	$_POST["account_code"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);			
			$amount				=	numberreplace($_POST["amount"]);
			
			$round_amount		=	numberreplace($_POST["round_amount"]);
			$round_amount_account	=	$_POST["round_amount_account"];
			if($round_amount == 0) {
				$round_amount_account = "";	
			}
			
			$bank_charge		=	numberreplace($_POST["bank_charge"]);
			$bank_charge_account	= 	$_POST["bank_charge_account"];
			if($bank_charge == 0) {
				$bank_charge_account = "";
			}
			
			$sub_total			=	numberreplace($_POST["sub_total"]);
			$deposit			=	numberreplace($_POST["deposit"]);
			$type				=	$_POST["type"];
			$no_ttfa			=	$_POST["no_ttfa"];
			
			$total				=	numberreplace($_POST["total"]);
			
			$sqlstr="update payment set date='$date', status='$status', vendor_code='$vendor_code', payment_type='$payment_type', cheque_no='$cheque_no', cheque_date='$cheque_date', bank_name='$bank_name', credit_card_no='$credit_card_no', credit_card_code='$credit_card_code', credit_card_holder='$credit_card_holder', credit_card_expired='$credit_card_expired', account_code='$account_code', currency_code='$currency_code', rate='$rate', amount='$amount', deposit='$deposit', sub_total='$sub_total', type='$type', memo='$memo', round_amount='$round_amount', round_amount_account='$round_amount_account', bank_charge='$bank_charge', bank_charge_account='$bank_charge_account', total='$total', no_ttfa='$no_ttfa', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			if($payment_type == "giro" || $payment_type == "cheque") {
				
				//insert APC
				$sqlstr="update apc date='$date', vendor_code='$vendor_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$payment_type' and ref='$ref'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();				
				
			}
					
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update cash invoice
	function update_cash_invoice($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$old_location_id=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
			
			$ref2			= 	$_POST["ref2"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));	
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];		
			$status			= 	$_POST["status"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			
			if($taxable == 0) {
				$ref2		= 	"";
			} 
			
			if($taxable == 1 and $ref2 == "") {
				$ref2		= 	notran($date, 'frmcash_invoice2', '', '', $_SESSION["location"]); //---get no ref
			}
			
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					$do_ref 		= $_POST[do_ref_.$i];
					$so_ref 		= $_POST[so_ref_.$i];
								
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$unit_price2 = numberreplace($_POST[unit_price2_.$i]);
					$discount	= numberreplace($_POST[discount_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					$amount2 	= numberreplace($_POST[amount2_.$i]);
					$dummy 		= (empty($_POST[dummy_.$i])) ? 0 : $_POST[dummy_.$i]; //$_POST[dummy_.$i];
					
					$line_item_do	= $_POST[line_item_do_.$i];
					$line_item_so	= $_POST[line_item_so_.$i];
					
					$sqlstr = "select ref from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update sales_invoice_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', unit_price2='$unit_price2', discount='$discount', amount='$amount', amount2='$amount2', dummy='$dummy' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (credit qty)
							$sqlstr="update bincard set location_code='$warehouse_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_price', credit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='cash_invoice' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						
						} else {
							$sqlstr="delete from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------delete bincard (credit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='cash_invoice' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
						
					} else {
						$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into sales_invoice_detail (ref, do_ref, so_ref, item_code, uom_code, qty, discount, unit_price, unit_price2, amount, amount2, dummy, line_item_do, line_item_so, line) values ('$ref', '$do_ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$unit_price2', '$amount', '$amount2', '$dummy', '$line_item_do', '$line_item_so', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (debit qty)
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'cash_invoice', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
						
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
					
					//----------insert/update set_item_price
					$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' order by date_of_record desc limit 1 ";
					$sql=$dbpdo->prepare($sqlprice);
					$sql->execute();
					$numprice = $sql->rowCount();
					
					if($numprice == 0) {
						$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' order by date_of_record desc limit 1 ";
						$sql=$dbpdo->prepare($sqlprice2);
						$sql->execute();
						$dataprice = $sql->fetch(PDO::FETCH_OBJ);
						
						$last_price			=	$dataprice->current_price;
						$date_of_record		=	date("Y-m-d H:i:s");
						
						$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$uid', '$dlu')";				
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
					}	
					//------------------------------------/\
	                
	                
					
					
				}
			}
			
			
				//-get amount
				/*$sql = "select sum(amount) amount from sales_invoice_detail where ref='$ref'";
				$result = mysql_query($sql);
				$data = mysql_fetch_object($result);
				$sub_total = $data->amount;*/

				$cash				=	$_POST["cash"];				
				$employee_id		= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
				$client_code		=	$_POST["client_code"];
				$ship_to			=	$_POST["ship_to"];
				$bill_to			=	$_POST["bill_to"];
				$top				=	$_POST["top"];
				$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));
				$tax_code			=	$_POST["tax_code"];
				$tax_rate			=	numberreplace($_POST["tax_rate"]);
				$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
				$freight_account	= 	$_POST["freight_account"];
				$currency_code		=	$_POST["currency_code"];
				$rate				=	numberreplace($_POST["rate"]);
				$memo				= 	$_POST["memo"];
				$total				=	numberreplace($_POST["total"]); //$sub_total; 			
				$deposit			=	numberreplace($_POST["deposit"]);
				$discount2	 		= 	numberreplace($_POST["discount"]);
	            $use_deposit		=	(empty($_POST["use_deposit"])) ? 0 : $_POST["use_deposit"];
	            $ref_rci			= 	$_POST["ref_rci"];
				
				$sqlstr="update sales_invoice set ref2='$ref2', date='$date', status='$status', top='$top', due_date='$due_date', client_code='$client_code', ship_to='$ship_to', bill_to='$bill_to', cash='$cash', taxable='$taxable', discount='$discount2', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', currency_code='$currency_code', rate='$rate', employee_id='$employee_id', total='$total', memo='$memo', location_id='$location_id', deposit='$deposit', uid='$uid', dlu='$dlu' where ref='$ref' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
				
				if($cash == 0) {
					
					$total = $total - $deposit;
					
					//update AR
					/*$sqlstr="update ar set date='$date', due_date='$due_date', debit_amount='$total', top='$top', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_type='CSH' and ref_type='CSH' ";
					$sql=$dbpdo->prepare($sqlstr);	
					*/
					
					//delete AR
					$sqlstr="delete from ar where ref='$ref' and invoice_type='CSH'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
					//insert AR
					$sqlstr="insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$total', 0, 'CSH', 'CSH', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
				} else { //kalau cash DELETE AR
					//delete AR
					$sqlstr="delete from ar where ref='$ref' and invoice_type='CSH'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}
				
				
	            //------jika ada DP
	    		if($deposit > 0) {
	                
	                $sqldps = "select ref from dps where ref='$ref' and ref_type='CSH' ";
	                $sql=$dbpdo->prepare($sqldps);
					$sql->execute();
					$rows = $sql->rowCount();
	                
	                if($rows == 0) {
	                    $sqlstr="insert into dps(ref, invoice_no, date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref_rci', '$date', 'C', '$client_code', '', 0, '$deposit', 'RCI', 'CSH', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', '$uid', '$dlu')";
	    			    $sql=$dbpdo->prepare($sqlstr);
	    			    $sql->execute();
	                } 
	    			
	    		}
	                
	            
	            if($taxable == 1) {    
				    notran($date, 'frmcash_invoice2', 1, '', $_SESSION["location"]) ; //----eksekusi ref
	            }
	            
	            
	            
	            ##jika status Void(Batal)
	            if($status == "V") {
	                $sqldo = "select ref from delivery_order_detail where so_ref='$ref'";
	                $sql=$dbpdo->prepare($sqldo);
					$sql->execute();
					$datado = $sql->fetch(PDO::FETCH_OBJ);
					
	                $ref_do = $datado->ref;
	                
	                
	                $sqlstr="delete from bincard where invoice_no='$ref_do'  ";
	        		$sql=$dbpdo->prepare($sqlstr);
	        		$sql->execute();
	                
	                $sqlstr="update delivery_order set status='C' where ref='$ref_do' ";
	        		$sql=$dbpdo->prepare($sqlstr);
	        		$sql->execute();
	        		
	        		$sqlstr="delete from delivery_order_detail where ref='$ref_do' ";
	        		$sql=$dbpdo->prepare($sqlstr);
	        		$sql->execute();
	        		
	        		$sqlstr="delete from jrn where ivino='$ref_do' and ivitpe='delivery_order' ";
	        		$sql=$dbpdo->prepare($sqlstr);
	        		$sql->execute();
	                //--------------------end DO
	                
	                
	                //----sales only-----
	                $sqlstr="update sales_invoice set discount='0', tax_code='', tax_rate='0', freight_cost='0', freight_account='', currency_code='', rate='0', total='0', deposit='0' where ref='$ref' ";
				    $sql=$dbpdo->prepare($sqlstr);
				    $sql->execute();
	            
	                $sqlstr="delete from sales_invoice_detail where ref='$ref' ";
	        		$sql=$dbpdo->prepare($sqlstr);
	        		$sql->execute();
	        		
	        		//delete AR
	        		$sqlstr="delete from ar where ref='$ref' and invoice_type='CSH'";
	        		$sql=$dbpdo->prepare($sqlstr);
	        		$sql->execute();
	        		
	        		//delete journal
	        		$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales' ";
	        		$sql=$dbpdo->prepare($sqlstr);
	        		$sql->execute();
	        		
	        		//delete DPS
	        		$sqlstr="delete from dps where ref='$ref' and invoice_type='RCI' ";
	        		$sql=$dbpdo->prepare($sqlstr);
	        		$sql->execute();
	            }
	            
			
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	
	//-----update delivery order quick
	function update_delivery_order_quick($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$status		= 	$_POST["status"];
			
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$so_ref			= $_POST[so_ref_.$i];
					$qty 			= numberreplace($_POST[qty_.$i]);
					$old_qty		= numberreplace($_POST[old_qty_.$i]);
					$ship_date 		= date("Y-m-d", strtotime($_POST[ship_date_.$i]));
					$line_item_so	= $_POST[line_item_so_.$i];
					
					$sqlstr = "select ref from delivery_order_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update delivery_order_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', ship_date='$ship_date' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty sales order
							if($status != "P") {
								$sqlstr="update sales_invoice_detail set qty_shp=ifnull(qty_shp,0) - $old_qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							
								$sqlstr="update sales_invoice_detail set qty_shp=ifnull(qty_shp,0) + $qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
							}
							
						} else {
							$sqlstr="delete from delivery_order_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							##--------update qty sales order						
							$sqlstr="update sales_invoice_detail set qty_shp=ifnull(qty_shp,0) - $qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();					
						}
						
						
					} else {
						$line = maxline('delivery_order_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into delivery_order_detail (ref, so_ref, item_code, uom_code, qty, ship_date, line_item_so, line) values ('$ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$ship_date', '$line_item_so', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty sales order
						if($status != "P" && $status != "C") {
							$sqlstr="update sales_invoice_detail set qty_shp=ifnull(qty_shp,0) + $qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
					}
					
					
					
				}
			}
			
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));			
			$location_id		= 	$_POST["location_id"];
			$po_number			= 	$_POST["po_number"];
			$ship_to			= 	$_POST["ship_to"];
			$client_code		=	$_POST["client_code"];
			$memo				= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update delivery_order set date='$date', status='$status', location_id='$location_id', ship_to='$ship_to', po_number='$po_number', client_code='$client_code', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			
			
			/*update status sales order : S=Shipped in Part (dikirim sebagian)
										  F=Shipped in Full (dikirm semua)
										  C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
			*/
			$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_shp,0)) qty_shp from sales_invoice_detail group by ref having ref='$so_ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$qty_shp = $data->qty_shp;
			$qty2 = $data->qty;
			
			//if($qty > 0) {
				if($qty_shp < $qty2 ) {
					$sqlstr="update sales_invoice set status='S' where ref='$so_ref' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();	
				}
				
				if($qty_shp >= $qty2 ) {
					$sqlstr="update sales_invoice set status='E' where ref='$so_ref' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();	
				}
                
                if($qty_shp <= 0 ) {
					$sqlstr="update sales_invoice set status='R' where ref='$so_ref' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();	
				}
			//}
			##*****************************************##
				
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----transfer delivery order quick
	function delivery_order_quick_transfer($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$sqlstr="select a.ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.ship_date, a.line_item_so, a.line, c.date, c.location_id, d.unit_price, d.amount from delivery_order_detail a left join item b on a.item_code=b.syscode left join delivery_order c on a.ref=c.ref left join sales_invoice_detail d on a.so_ref=d.ref and a.item_code=d.item_code and a.line_item_so=d.line where a.ref='$ref' and ifnull(c.delivered,0)=0 order by a.line";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			while($data_do = $sql->fetch(PDO::FETCH_OBJ)) {
				//----------insert bincard (debit qty)
				
				$location_id	=	$data_do->location_id;
				$date		=	$data_do->date;
				$item_code	=	$data_do->item_code;
				$uom_code	=	$data_do->uom_code;
				$unit_price	=	$data_do->unit_price;			
				$qty	=	$data_do->qty;
				$amount	=	$qty * $unit_price;
				$line	=	$data_do->line;
				$memo			= 	$data_do->memo;
				$uid			=	$_SESSION["loginname"];
				$dlu			=	date("Y-m-d H:i:s");
				
				$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'delivery_order', '$memo', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
						
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			
			//-----------update delivered=1
			$sqlstr="update delivery_order set delivered=1, delivered_date='$dlu', uid_delivered='$uid' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----transfer delivery order quick cancel
	function delivery_order_quick_cancel_transfer($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//-----------delete bin card
			$sqlstr="delete from bincard where invoice_no='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//-----------update delivered=0
			$sqlstr="update delivery_order set delivered=0, delivered_cancel_date='$dlu', uid_delivered_cancel='$uid' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update direct payment
	function update_direct_payment($ref){
		$dbpdo = DB::create();
		
		try {
		
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$contact_type	=	$_POST["contact_type"];
			$contact_code	=	$_POST["contact_code"];
			
			if( $contact_type == "O") {
				$contact_name	=	$contact_code;	
			}
			
			$ap				=	(empty($_POST["ap"])) ? 0 : $_POST["ap"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			
			
			
			//----------update direct receipt detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_account_code 	= $_POST[old_account_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$account_code 	= $_POST[account_code_.$i];
				
				if ( !empty($account_code) ) {	
					$memo		 	= $_POST[memo_.$i];
					$currency_code 	= $_POST[currency_code_.$i];
					$rate 			= numberreplace($_POST[rate_.$i]);
					$debit_amount 	= numberreplace($_POST[debit_amount_.$i]);
					$credit_amount 	= numberreplace($_POST[credit_amount_.$i]);
					
					$sqlstr = "select ref from direct_payment_detail where ref='$ref' and account_code='$old_account_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update direct_payment_detail set account_code='$account_code', currency_code='$currency_code', rate='$rate', debit_amount='$debit_amount', credit_amount='$credit_amount', memo='$memo' where ref='$ref' and currency_code='$old_currency_code' and line='$old_line'";						
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
								
						
						} else {
							$sqlstr="delete from direct_payment_detail where ref='$ref' and account_code='$old_account_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
								
												
						}
						
						
					} else {
						$line = maxline('direct_payment_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into direct_payment_detail (ref, account_code, currency_code, rate, debit_amount, credit_amount, memo, line) values ('$ref', '$account_code', '$currency_code', '$rate', '$debit_amount', '$credit_amount', '$memo', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						
					}
					
				}
			}
			
			
			$status				= 	$_POST["status"];			
			$payment_type		=	$_POST["payment_type"];
			$cheque_no			=	$_POST["cheque_no"];
			$cheque_date		=	date("Y-m-d", strtotime($_POST["cheque_date"]));
			$bank_name			=	$_POST["bank_name"];
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$credit_card_holder	=	$_POST["credit_card_holder"];
			$credit_card_expired =	date("Y-m-d", strtotime($_POST["credit_card_expired"]));
			$account_code		= 	$_POST["account_code"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);	
			$memo				= 	$_POST["memo"];		
			$amount				=	numberreplace($_POST["amount"]);
			
			/*$round_amount		=	numberreplace($_POST["round_amount"]);
			$round_amount_account	=	$_POST["round_amount_account"];
			if($round_amount == 0) {
				$round_amount_account = "";	
			}
			
			$bank_charge		=	numberreplace($_POST["bank_charge"]);
			$bank_charge_account	= 	$_POST["bank_charge_account"];
			if($bank_charge == 0) {
				$bank_charge_account = "";
			}*/
			
			$sub_total			=	numberreplace($_POST["sub_total"]);
			$deposit			=	numberreplace($_POST["deposit"]);
			$type				=	$_POST["type"];
			
			$total				=	numberreplace($_POST["total"]);
			
			$sqlstr="update direct_payment set date='$date', status='$status', contact_type='$contact_type', contact_code='$contact_code', contact_name='$contact_name', payment_type='$payment_type', cheque_no='$cheque_no', cheque_date='$cheque_date', bank_name='$bank_name', credit_card_no='$credit_card_no', credit_card_code='$credit_card_code', credit_card_holder='$credit_card_holder', credit_card_expired='$credit_card_expired', account_code='$account_code', currency_code='$currency_code', rate='$rate', amount='$amount', deposit='$deposit', sub_total='$sub_total', type='$type', memo='$memo', total='$total', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			if($payment_type == "giro" || $payment_type == "cheque") {
				
				//insert APC
				$sqlstr="update apc date='$date', vendor_code='$contact_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$payment_type' and ref='$ref'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();				
				
			}
			
			if($ap == 1) {
				
				//insert AP
				$sqlstr="update ap set date='$date', contact_code='$contact_code', credit_amount='$total', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_type='DPM' and ref_type='DPM' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
			}
				
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update direct receipt
	function update_direct_receipt($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$contact_type	=	$_POST["contact_type"];
			$contact_code	=	$_POST["contact_code"];
			
			if( $contact_type == "O") {
				$contact_name	=	$contact_code;	
			}
			
			$ar 			= 	(empty($_POST['ar'])) ? 0 : $_POST['ar'];		
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			//----------update direct receipt detail
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_account_code 	= $_POST[old_account_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$account_code 	= $_POST[account_code_.$i];
				
				if ( !empty($account_code) ) {	
					$memo		 	= $_POST[memo_.$i];
					$currency_code 	= $_POST[currency_code_.$i];
					$rate 			= numberreplace($_POST[rate_.$i]);
					$debit_amount 	= numberreplace($_POST[debit_amount_.$i]);
					$credit_amount 	= numberreplace($_POST[credit_amount_.$i]);
					
					$sqlstr = "select ref from direct_receipt_detail where ref='$ref' and account_code='$old_account_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update direct_receipt_detail set account_code='$account_code', currency_code='$currency_code', rate='$rate', debit_amount='$debit_amount', credit_amount='$credit_amount', memo='$memo' where ref='$ref' and currency_code='$old_currency_code' and line='$old_line'";						
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
								
						
						} else {
							$sqlstr="delete from direct_receipt_detail where ref='$ref' and account_code='$old_account_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$line = maxline('direct_receipt_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into direct_receipt_detail (ref, account_code, currency_code, rate, debit_amount, credit_amount, memo, line) values ('$ref', '$account_code', '$currency_code', '$rate', '$debit_amount', '$credit_amount', '$memo', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
				}
			}
			
		
			$status				= 	$_POST["status"];			
			$receipt_type		=	$_POST["receipt_type"];
			$cheque_no			=	$_POST["cheque_no"];
			$cheque_date		=	date("Y-m-d", strtotime($_POST["cheque_date"]));
			$bank_name			=	$_POST["bank_name"];
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$credit_card_holder	=	$_POST["credit_card_holder"];
			$credit_card_expired =	date("Y-m-d", strtotime($_POST["credit_card_expired"]));
			$account_code		= 	$_POST["account_code"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);			
			$amount				=	numberreplace($_POST["amount"]);
			
			$sub_total			=	numberreplace($_POST["sub_total"]);
			$deposit			=	numberreplace($_POST["deposit"]);
			$type				=	$_POST["type"];
			
			$memo				= 	$_POST["memo"];
			$installment		=	numberreplace($_POST["installment"]);
			$loan				=	(empty($_POST["loan"])) ? 0 : $_POST["loan"];
			$total				=	$amount;  //numberreplace($_POST["total"]);
			
			$sqlstr="update direct_receipt set date='$date', status='$status', contact_type='$contact_type', contact_code='$contact_code', contact_name='$contact_name', receipt_type='$receipt_type', cheque_no='$cheque_no', cheque_date='$cheque_date', bank_name='$bank_name', credit_card_no='$credit_card_no', credit_card_code='$credit_card_code', credit_card_holder='$credit_card_holder', credit_card_expired='$credit_card_expired', account_code='$account_code', currency_code='$currency_code', rate='$rate', amount='$amount', deposit='$deposit', sub_total='$sub_total', type='$type', memo='$memo', installment='$installment', loan='$loan', total='$total', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			if($receipt_type == "giro" || $receipt_type == "cheque") {
				
				//insert ARC
				$sqlstr="update arc date='$date', client_code='$contact_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();				
				
			}
			
			if($ar == 1) {
				
				//update AR
				if($loan == 1) {
					$ref_type = "loan";
				} else {
					$ref_type = "DRC";
				}
				$sqlstr="update ar set date='$date', due_date='$date', ref_type='$ref_type', debit_amount='$total', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_type='DRC' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
			}
				
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update delivery order project
	function update_delivery_order_project($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$status		= 	$_POST["status"];
			
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty 			= numberreplace($_POST[qty_.$i]);
					$old_qty		= numberreplace($_POST[old_qty_.$i]);
					$ship_date 		= date("Y-m-d", strtotime($_POST[ship_date_.$i]));
					
					$sqlstr = "select ref from delivery_order_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update delivery_order_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', ship_date='$ship_date' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							
						} else {
							$sqlstr="delete from delivery_order_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
											
						}
						
						
					} else {
						$line = maxline('delivery_order_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into delivery_order_detail (ref, so_ref, item_code, uom_code, qty, ship_date, line_item_so, line) values ('$ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$ship_date', '$line_item_so', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
											
					}
					
					
					
				}
			}
			
		
			$date				=	date("Y-m-d", strtotime($_POST["date"]));			
			$location_id		= 	$_POST["location_id"];
			$po_number			= 	$_POST["po_number"];
			$ship_to			= 	$_POST["ship_to"];
			$client_code		=	$_POST["client_code"];
			$memo				= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update delivery_order set date='$date', status='$status', location_id='$location_id', ship_to='$ship_to', po_number='$po_number', client_code='$client_code', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
				
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
		
	
	//-----update sales invoice project
	function update_sales_invoice_project($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$ref2			= 	$_POST["ref2"];
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];
			if($taxable == 0) {
				$ref2		= 	"";
			}
			
			$status		= 	$_POST["status"];
			
			//----------update sales_order detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					$do_ref 		= $_POST[do_ref_.$i];
					$so_ref 		= $_POST[so_ref_.$i];
								
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$unit_price2	= numberreplace($_POST[unit_price2_.$i]);
					$discount	= numberreplace($_POST[discount_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					$amount2 	= numberreplace($_POST[amount2_.$i]);
					
					$dummy 		= (empty($_POST[dummy_.$i])) ? 0 : $_POST[dummy_.$i];
					
					$line_item_do	= $_POST[line_item_do_.$i];
					$line_item_so	= $_POST[line_item_so_.$i];
					
					$sqlstr = "select ref from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update sales_invoice_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', unit_price2='$unit_price2' ,discount='$discount', amount='$amount', amount2='$amount2', dummy='$dummy' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty delivery order
							if($status != "P" && $status != "C") {
								$sqlstr="update delivery_order_detail set qty_si=ifnull(qty_si,0) - $old_qty + $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							}
						
						} else {
							$sqlstr="delete from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty delivery order						
							$sqlstr="update delivery_order_detail set qty_si=ifnull(qty_si,0) - $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
												
						}
						
						
					} else {
						$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into sales_invoice_detail (ref, do_ref, so_ref, item_code, uom_code, qty, discount, unit_price, unit_price2, amount, amount2, dummy, line_item_do, line_item_so, line) values ('$ref', '$do_ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$unit_price2', '$amount', '$amount2', '$dummy', '$line_item_do', '$line_item_so', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty delivery order
						if($status != "P" && $status != "C") {
							$sqlstr="update delivery_order_detail set qty_si=ifnull(qty_si,0) + $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
					}
					
					
					
				}
			}
			
		
			//-get amount
			$sqlstr = "select sum(amount) - sum(discount) amount from sales_invoice_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;

			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));		
			$employee_id		= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$client_code		=	$_POST["client_code"];
			$ship_to			=	$_POST["ship_to"];
			$bill_to			=	$_POST["bill_to"];
			$top				=	$_POST["top"];
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$deposit			=	numberreplace($_POST["deposit"]);
			$total				=	$sub_total + $freight_cost; //numberreplace($_POST["total"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update sales_invoice set date='$date', status='$status', top='$top', client_code='$client_code', ship_to='$ship_to', bill_to='$bill_to', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', currency_code='$currency_code', rate='$rate', employee_id='$employee_id', deposit='$deposit', total='$total', memo='$memo', taxable='$taxable', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//insert AR
			$sqlstr="delete from ar where ref='$ref' and invoice_type='SOI' and ref_type='SOI' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$total	=	$total - $deposit;
			$sqlstr="insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$total', 0, 'SOI', 'SOI', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			/*update status delivery order : I=Invoice in Part (diinvoicekan sebagian)
										  	F=Invoice in Full (diinvoicekan semua)
										  	C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
			*/
			$sqlstr = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_si,0)) qty_si from delivery_order_detail group by ref having ref='$do_ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$qty_si = $data->qty_si;
			$qty = $data->qty;
			
			if($qty > 0) {
				if($qty_si < $qty ) {
					$sqlstr="update delivery_order set status='I' where ref='$do_ref' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();	
				}
				
				if($qty_si >= $qty ) {
					$sqlstr="update delivery_order set status='F' where ref='$do_ref' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();	
				}
			}
			##*****************************************##
				
			
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----transfer delivery order project
	function delivery_order_project_transfer($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$sqlstr="select a.ref, a.so_ref, a.item_code, b.code, b.name item_name, a.uom_code, a.qty, a.ship_date, a.line_item_so, a.line, c.date, c.location_id, d.unit_price, d.amount from delivery_order_detail a left join item b on a.item_code=b.syscode left join delivery_order c on a.ref=c.ref left join sales_invoice_detail d on a.so_ref=d.ref and a.item_code=d.item_code and a.line_item_so=d.line where a.ref='$ref' and ifnull(c.delivered,0)=0 order by a.line";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			while($data_do = $sql->fetch(PDO::FETCH_OBJ)) {
				//----------insert bincard (debit qty)
				
				$location_id	=	$data_do->location_id;
				$date		=	$data_do->date;
				$item_code	=	$data_do->item_code;
				$uom_code	=	$data_do->uom_code;
				$unit_price	=	$data_do->unit_price;			
				$qty	=	$data_do->qty;
				$amount	=	$qty * $unit_price;
				$line	=	$data_do->line;
				$memo			= 	$data_do->memo;
				$uid			=	$_SESSION["loginname"];
				$dlu			=	date("Y-m-d H:i:s");
				
				$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'delivery_order', '$memo', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
						
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			
			//-----------update delivered=1
			$sqlstr="update delivery_order set delivered=1, delivered_date='$dlu', uid_delivered='$uid' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----transfer delivery order project cancel
	function delivery_order_project_cancel_transfer($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//-----------delete bin card
			$sqlstr="delete from bincard where invoice_no='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			//-----------update delivered=0
			$sqlstr="update delivery_order set delivered=0, delivered_cancel_date='$dlu', uid_delivered_cancel='$uid' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update cash receipt
	function update_cash_receipt($ref){
		$dbpdo = DB::create();
		
		try {
		
		
			
			
			
			
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$contact_type	=	$_POST["contact_type"];
			$contact_code	=	$_POST["contact_code"];
			
			if( $contact_type == "O") {
				$contact_name	=	$contact_code;	
			}
			
			$memo1			= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			//----------update direct receipt detail
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_account_code 	= $_POST[old_account_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$account_code 	= $_POST[account_code_.$i];
				
				if ( !empty($account_code) ) {	
					$memo		 	= $_POST[memo_.$i];
					$currency_code 	= $_POST[currency_code_.$i];
					$rate 			= numberreplace($_POST[rate_.$i]);
					$debit_amount 	= numberreplace($_POST[debit_amount_.$i]);
					$credit_amount 	= numberreplace($_POST[credit_amount_.$i]);
					
					$sqlstr = "select ref from cash_receipt_detail where ref='$ref' and account_code='$old_account_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update cash_receipt_detail set account_code='$account_code', currency_code='$currency_code', rate='$rate', debit_amount='$debit_amount', credit_amount='$credit_amount', memo='$memo' where ref='$ref' and currency_code='$old_currency_code' and line='$old_line'";						
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
								
						
						} else {
							$sqlstr="delete from cash_receipt_detail where ref='$ref' and account_code='$old_account_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$line = maxline('cash_receipt_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into cash_receipt_detail (ref, account_code, currency_code, rate, debit_amount, credit_amount, memo, line) values ('$ref', '$account_code', '$currency_code', '$rate', '$debit_amount', '$credit_amount', '$memo', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
				}
			}
			
			
			$status				= 	$_POST["status"];			
			$receipt_type		=	$_POST["receipt_type"];
			$cheque_no			=	$_POST["cheque_no"];
			$cheque_date		=	date("Y-m-d", strtotime($_POST["cheque_date"]));
			$bank_name			=	$_POST["bank_name"];
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$credit_card_holder	=	$_POST["credit_card_holder"];
			$credit_card_expired =	date("Y-m-d", strtotime($_POST["credit_card_expired"]));
			$account_code		= 	$_POST["account_code"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);			
			$amount				=	numberreplace($_POST["amount"]);
			
			$sub_total			=	numberreplace($_POST["sub_total"]);
			$deposit			=	numberreplace($_POST["deposit"]);
			$type				=	$_POST["type"];
			
			$total				=	numberreplace($_POST["total_credit"]);
			
			$sqlstr="update cash_receipt set date='$date', status='$status', contact_type='$contact_type', contact_code='$contact_code', contact_name='$contact_name', receipt_type='$receipt_type', cheque_no='$cheque_no', cheque_date='$cheque_date', bank_name='$bank_name', credit_card_no='$credit_card_no', credit_card_code='$credit_card_code', credit_card_holder='$credit_card_holder', credit_card_expired='$credit_card_expired', account_code='$account_code', currency_code='$currency_code', rate='$rate', amount='$amount', deposit='$deposit', sub_total='$sub_total', type='$type', memo='$memo1', total='$total', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			if($receipt_type == "giro" || $receipt_type == "cheque") {
				
				//insert ARC
				$sqlstr="update arc date='$date', client_code='$contact_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo1', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();				
				
			}
			
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	//-----update cash payment
	function update_cash_payment($ref){
		$dbpdo = DB::create();
		
		try {
		
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$contact_type	=	$_POST["contact_type"];
			$contact_code	=	$_POST["contact_code"];
			
			if( $contact_type == "O") {
				$contact_name	=	$contact_code;	
			}
			
			$memo1			= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			
			
			
			
			//----------update cash payment detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_account_code 	= $_POST[old_account_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$account_code 	= $_POST[account_code_.$i];
				
				if ( !empty($account_code) ) {	
					$memo		 	= $_POST[memo_.$i];
					$currency_code 	= $_POST[currency_code_.$i];
					$rate 			= numberreplace($_POST[rate_.$i]);
					$debit_amount 	= numberreplace($_POST[debit_amount_.$i]);
					$credit_amount 	= numberreplace($_POST[credit_amount_.$i]);
					
					$sqlstr = "select ref from cash_payment_detail where ref='$ref' and account_code='$old_account_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update cash_payment_detail set account_code='$account_code', currency_code='$currency_code', rate='$rate', debit_amount='$debit_amount', credit_amount='$credit_amount', memo='$memo' where ref='$ref' and currency_code='$old_currency_code' and line='$old_line'";						
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
								
						
						} else {
							$sqlstr="delete from cash_payment_detail where ref='$ref' and account_code='$old_account_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$line = maxline('cash_payment_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into cash_payment_detail (ref, account_code, currency_code, rate, debit_amount, credit_amount, memo, line) values ('$ref', '$account_code', '$currency_code', '$rate', '$debit_amount', '$credit_amount', '$memo', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
				}
			}
			
				
			$status				= 	$_POST["status"];			
			$payment_type		=	$_POST["payment_type"];
			$cheque_no			=	$_POST["cheque_no"];
			$cheque_date		=	date("Y-m-d", strtotime($_POST["cheque_date"]));
			$bank_name			=	$_POST["bank_name"];
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$credit_card_holder	=	$_POST["credit_card_holder"];
			$credit_card_expired =	date("Y-m-d", strtotime($_POST["credit_card_expired"]));
			$account_code		= 	$_POST["account_code"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);			
			$amount				=	numberreplace($_POST["amount"]);
			
			/*$round_amount		=	numberreplace($_POST["round_amount"]);
			$round_amount_account	=	$_POST["round_amount_account"];
			if($round_amount == 0) {
				$round_amount_account = "";	
			}
			
			$bank_charge		=	numberreplace($_POST["bank_charge"]);
			$bank_charge_account	= 	$_POST["bank_charge_account"];
			if($bank_charge == 0) {
				$bank_charge_account = "";
			}*/
			
			$sub_total			=	numberreplace($_POST["sub_total"]);
			$deposit			=	numberreplace($_POST["deposit"]);
			$type				=	$_POST["type"];
			
			$total				=	numberreplace($_POST["total"]);
			
			$sqlstr="update cash_payment set date='$date', status='$status', contact_type='$contact_type', contact_code='$contact_code', contact_name='$contact_name', payment_type='$payment_type', cheque_no='$cheque_no', cheque_date='$cheque_date', bank_name='$bank_name', credit_card_no='$credit_card_no', credit_card_code='$credit_card_code', credit_card_holder='$credit_card_holder', credit_card_expired='$credit_card_expired', account_code='$account_code', currency_code='$currency_code', rate='$rate', amount='$amount', deposit='$deposit', sub_total='$sub_total', type='$type', memo='$memo1', total='$total', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			if($payment_type == "giro" || $payment_type == "cheque") {
				
				//insert APC
				$sqlstr="update apc date='$date', vendor_code='$contact_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo1', uid='$uid', dlu='$dlu' where type='$payment_type' and ref='$ref'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();				
				
			}
			
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update week wage
	function update_week_wage($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
			
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$status			=	$_POST["status"];
			$type			=	$_POST["type"];
			$employee_id	= 	(empty($_POST['employee_id'])) ? 0 : $_POST['employee_id'];
			$memo			=	$_POST["memo"];
			$loan_balance 	= 	numberreplace($_POST['loan_balance']);
			$loan_total 	= 	numberreplace($_POST['loan_total']);
			$installment 	= 	numberreplace($_POST['installment']);
			$total		 	= 	numberreplace($_POST['total']);
			$loan		 	= 	numberreplace($_POST['loan']);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
					
			//----------update direct receipt detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_name 		= $_POST[item_name_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				$qty		 	= numberreplace($_POST[qty_.$i]);
				$unit_price 	= numberreplace($_POST[unit_price_.$i]);
				$amount		 	= numberreplace($_POST[amount_.$i]);
				
				if ( !empty($item_name) && !empty($uom_code) && $amount <> 0 ) {	
					
					$sqlstr = "select ref from week_wage_detail where ref='$ref' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update week_wage_detail set item_name='$item_name', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', amount='$amount' where ref='$ref' and line='$old_line'";						
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
								
						
						} else {
							$sqlstr="delete from week_wage_detail where ref='$ref' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();							
												
						}
						
						
					} else {
						$line = maxline('week_wage_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into week_wage_detail (ref, item_name, uom_code, qty, unit_price, amount, line) values ('$ref', '$item_name', '$uom_code', '$qty', '$unit_price', '$amount', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
					}
					
				}
			}
			
			$sqlstr = "select sum(ifnull(amount,0)) amount from week_wage_detail group by ref having ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$total = $data->amount - $installment + $loan;
			
			$sqlstr="update week_wage set date='$date', memo='$memo', loan_balance='$loan_balance', loan_total='$loan_total', installment='$installment', total='$total', loan='$loan', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			if($loan > 0) {
					
				//update AR
				$ref_type2 = "loan";
				
				$sqlstr="update ar set date='$date', due_date='$date', ref_type='$ref_type2', debit_amount='$loan', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_type='loan' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
			}
				
			if($installment > 0) {	
					
				//update AR
				$total	=	$installment;
				$sqlstr="update ar set date='$date', due_date='$date', credit_amount='$total', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_type='WEG' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
			}
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update purchase quick
	function update_purchase_quick($ref){
		$dbpdo = DB::create();
		
		try {
		
			
			
			
					
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
				
			
			//----------update item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_qty 			= numberreplace($_POST[old_qty_.$i]);
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					$qty = numberreplace($_POST[qty_.$i]);
					$unit_cost = numberreplace($_POST[unit_cost_.$i]);
					$amount = $qty * $unit_cost; //numberreplace($_POST[amount_.$i]);
					$line_item_po = (empty($_POST[line_item_po_.$i])) ? 0 : $_POST[line_item_po_.$i];
					
					$sqlstr = "select ref from purchase_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update purchase_invoice_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_cost='$unit_cost', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (debit qty)
							$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_cost', debit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='purchase_quick' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
													
								
						} else {
							$sqlstr="delete from purchase_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//----------delete bincard (debit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='purchase_quick' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
																		
						}
						
						
					} else {
						$line = maxline('purchase_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into purchase_invoice_detail (ref, po_ref, item_code, uom_code, qty, unit_cost, amount, line_item_po, line) values ('$ref', '', '$item_code', '$uom_code', '$qty', '$unit_cost', '$amount', '0', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (debit qty)
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_quick', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";
						
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
											
					}
					
					
					
				}
			}
			
			//-get amount
			$sqlstr = "select sum(amount) amount from purchase_invoice_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;
			
			$invoice_no			=	$_POST["invoice_no"];
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			$tax_code			= 	$_POST["tax_code"];
			$tax_rate			=	numberreplace((empty($_POST["tax_rate"])) ? 0 : $_POST["tax_rate"]);
			$freight_cost		=	numberreplace((empty($_POST["freight_cost"])) ? 0 : $_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$memo				= 	petikreplace($_POST["memo"]);		
			$cash				=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));
			$total				=	$sub_total + $freight_cost;
			
			
			$sqlstr="update purchase_invoice set invoice_no='$invoice_no', date='$date', status='$status', bill_number='$bill_number', vendor_code='$vendor_code', top='$top', due_date='$due_date', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', memo='$memo', total='$total', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			
			if($cash == 0) {
				//insert AP
				$sqlstr="delete from ap where ref='$ref' and invoice_type='PIQ' and ref_type='PIQ' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
				$sqlstr="insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'V', '$vendor_code', '', 0, '$total', 'PIQ', 'PIQ', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update purchase issued
	function update_purchase_issue($ref){
		$dbpdo = DB::create();
		
		try {
		
					
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
				
			
			//----------update item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_name	 	= $_POST[old_item_name_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_qty 			= numberreplace($_POST[old_qty_.$i]);
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_name	 	= $_POST[item_name_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_name) && !empty($uom_code) ) {
					$qty = numberreplace($_POST[qty_.$i]);
					$unit_cost = numberreplace($_POST[unit_cost_.$i]);
					$amount = $qty * $unit_cost; //numberreplace($_POST[amount_.$i]);
					$line_item_po = (empty($_POST[line_item_po_.$i])) ? 0 : $_POST[line_item_po_.$i];
					
					$sqlstr = "select ref from purchase_invoice_detail where ref='$ref' and item_name='$old_item_name' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update purchase_invoice_detail set item_name='$item_name', uom_code='$uom_code', qty='$qty', unit_cost='$unit_cost', amount='$amount' where ref='$ref' and item_name='$old_item_name' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (debit qty)
							/*$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_cost', debit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='purchase_issue' ";
							$sql=$dbpdo->prepare($sqlstr);
							*/
													
								
						} else {
							$sqlstr="delete from purchase_invoice_detail where ref='$ref' and item_name='$old_item_name' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//----------delete bincard (debit qty)
							/*$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='purchase_issue' ";
							$sql=$dbpdo->prepare($sqlstr);
							*/
																		
						}
						
						
					} else {
						$line = maxline('purchase_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into purchase_invoice_detail (ref, po_ref, item_name, uom_code, qty, unit_cost, amount, line_item_po, line) values ('$ref', '', '$item_name', '$uom_code', '$qty', '$unit_cost', '$amount', '0', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (debit qty)
						/*$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_issue', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";
						
						$sql=$dbpdo->prepare($sqlstr);
						*/
											
					}
					
					
					
				}
			}
			
			//-get amount
			$sqlstr = "select sum(amount) amount from purchase_invoice_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;
			
			$invoice_no			=	$_POST["invoice_no"];
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			$tax_code			= 	$_POST["tax_code"];
			$tax_rate			=	numberreplace((empty($_POST["tax_rate"])) ? 0 : $_POST["tax_rate"]);
			$freight_cost		=	numberreplace((empty($_POST["freight_cost"])) ? 0 : $_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$memo				= 	petikreplace($_POST["memo"]);		
			$cash				=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));
			$total				=	$sub_total + $freight_cost;
			
			
			$sqlstr="update purchase_invoice set invoice_no='$invoice_no', date='$date', status='$status', bill_number='$bill_number', vendor_code='$vendor_code', top='$top', due_date='$due_date', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', memo='$memo', total='$total', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			if($cash == 0) {
				//insert AP
				$sqlstr="delete from ap where ref='$ref' and invoice_type='PII' and ref_type='PII' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
				$sqlstr="insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'V', '$vendor_code', '', 0, '$total', 'PII', 'PII', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
    //-----update vehicle
	function update_vehicle($ref){
		$dbpdo = DB::create();
		
		try {
			
			$code			=    $_POST["code"];
			$status		    =    $_POST["status"];
	        $vendor_code    =    $_POST["vendor_code"];    
			$brand			=    petikreplace($_POST["brand"]);
	        $type           =    $_POST["type"]; 
	        $no_rangka      =    $_POST["no_rangka"];
	        $no_mesin       =    $_POST["no_mesin"];
	        $jenis_bak      =    $_POST["jenis_bak"];
			$year        	=    (empty($_POST["year"])) ? 0 : $_POST["year"];
	        $seri_unit      =    $_POST["seri_unit"];
	        $warna_kabin    =    $_POST["warna_kabin"];
	        $no_bpkb        =    $_POST["no_bpkb"];
	        $tanggal_bpkb   =    date("Y-m-d", strtotime($_POST["tanggal_bpkb"]));
	        $no_kir         =    $_POST["no_kir"];
			$tanggal_kir    =    date("Y-m-d", strtotime($_POST["tanggal_kir"]));
			$gps			=    $_POST["gps"];
	        $posisi_bpkb    =    $_POST["posisi_bpkb"];   
	        $ket_bpkb       =    $_POST["ket_bpkb"]; 
	        $insurance      =    $_POST["insurance"];
	        $location_id    =    (empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
	        $capacity		=    numberreplace($_POST["capacity"]);
	        $tonase    		=    numberreplace($_POST["tonase"]);
			
			//-----------upload file
		  	$photo2			= $_POST["photo2"];
			$uploaddir_photo= 'app/photo_vehicle/';
			$photo			= $_FILES['photo']['name']; 
			$tmpname_photo 	= $_FILES['photo']['tmp_name'];
			$filesize_photo = $_FILES['photo']['size'];
			$filetype_photo = $_FILES['photo']['type'];
			
			if (empty($photo)) { 
				$photo = $photo2; 
			} else {
				$photo = $photo;
			}
			
			if($photo != "") {
					
				if($photo != $photo2) {
					
					if(!empty($photo2)) {
						unlink($uploaddir_photo . $photo2); //remove file 					
					}
					
					$photo = $ref . '_' . $photo;
				}
				$uploaddir_photo = $uploaddir_photo . $photo;		
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir_photo)) {
					echo "";											
				} 	
			}	
			//----------------
			
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");	
			
			$sqlstr="update vehicle set code='$code', status='$status', vendor_code='$vendor_code', brand='$brand', type='$type', no_rangka='$no_rangka', no_mesin='$no_mesin', jenis_bak='$jenis_bak', year='$year', seri_unit='$seri_unit', warna_kabin='$warna_kabin', no_bpkb='$no_bpkb', tanggal_bpkb='$tanggal_bpkb', no_kir='$no_kir', tanggal_kir='$tanggal_kir', gps='$gps', posisi_bpkb='$posisi_bpkb', ket_bpkb='$ket_bpkb', insurance='$insurance', location_id='$location_id', capacity='$capacity', tonase='$tonase', photo='$photo', active='$active', uid='$uid', dlu='$dlu' where syscode='$ref'";

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
    
    //-----update asset_type
	function update_asset_type($ref){
		$dbpdo = DB::create();
		
		try {
			
			$type			=	$_POST["type"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="update asset_type set type='$type', active='$active', uid='$uid', dlu='$dlu' where id='$ref'";

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
    
    
    //-----update asset
	function update_asset($ref){
		$dbpdo = DB::create();
		
		try {
			
			$ref_id			    =	petikreplace($_POST["ref_id"]);
			$asset_name		    =	petikreplace($_POST["asset_name"]);
			$alias		        =	petikreplace($_POST["alias"]);
			$lokasi			    =	petikreplace($_POST["lokasi"]);
			$provinsi_kode	    =	$_POST["provinsi_kode"];
			$kota_kode	    	=	$_POST["kota_kode"];
			$kecamatan_kode	    =	$_POST["kecamatan_kode"];
			$desa_kode	    	=	$_POST["desa_kode"];
			$asset_type_id	    =	(empty($_POST["asset_type_id"])) ? 0 : $_POST["asset_type_id"];
	        $status			    =	$_POST["status"];
			$luas		        =	numberreplace($_POST["luas"]);
	        $sertifikat		    =   $_POST["sertifikat"];
	        $imb			    =	$_POST["imb"];
	        $tanggal_perolehan	=	date("Y-m-d", strtotime($_POST["tanggal_perolehan"]));
	        $pemilik_sebelum	=	$_POST["pemilik_sebelum"];
	        $contact_name		=	$_POST["contact_name"];
	        $no_pbb             =   $_POST["no_pbb"];
	        $group_block        =   $_POST["group_block"];
	        $alamat             =   petikreplace($_POST["alamat"]);
	        $lintang            =   numberreplace($_POST["lintang"]);
	        $bujur              =   numberreplace($_POST["bujur"]);
	        $nilai_perolehan    =   numberreplace($_POST["nilai_perolehan"]);
	        $nilai_amnesti      =   numberreplace($_POST["nilai_amnesti"]);
	        $pemilik_sekarang   =   $_POST["pemilik_sekarang"];
	        $active			    =	(empty($_POST["active"])) ? 0 : $_POST["active"];
	        $shm			    =	$_POST["shm"];
	        $shm_nama		    =	$_POST["shm_nama"];
	        $ajb			    =	$_POST["ajb"];
	        $pbb			    =	$_POST["pbb"];
	        $keterangan			=	petikreplace($_POST["keterangan"]);
			$uid			    =	$_SESSION["loginname"];
			$dlu			    =	date("Y-m-d H:i:s");
			
			/*create folder*/
			$photo_asset = 'app/photo_asset/'.$ref;
			if (!file_exists($photo_asset) && !is_dir($photo_asset)) {
				@mkdir($photo_asset, 0777, true);
				@chmod('app/photo_asset', 0777);
				@chmod($photo_asset, 0777);
			}
			
			//-----------upload file
		  	$photo2			= $_POST["photo2"];
			$uploaddir_photo= $photo_asset .'/';
			$photo			= $_FILES['photo']['name']; 
			$tmpname_photo 	= $_FILES['photo']['tmp_name'];
			$filesize_photo = $_FILES['photo']['size'];
			$filetype_photo = $_FILES['photo']['type'];
			
			if (empty($photo)) { 
				$photo = $photo2; 
			} else {
				$photo = $photo;
			}
			
			if($photo != "") {
					
				if($photo != $photo2) {
					
					if(!empty($photo2)) {
						if (file_exists($photo_asset . '/' . $photo2)) {
							unlink($uploaddir_photo . $photo2); //remove file 
						}					
					}
					
					$photo = $ref . '_' . $photo;
				}
				$uploaddir_photo = $uploaddir_photo . $photo;		
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir_photo)) {
					echo "";											
				} 	
			}	
			
			
			/*upload file-1--------------<<<*/
			$photo_12			= $_POST["photo_12"];
			$uploaddir_photo_1= $photo_asset .'/';
			$photo_1			= $_FILES['photo_1']['name']; 
			$tmpname_photo_1 	= $_FILES['photo_1']['tmp_name'];
			$filesize_photo_1 = $_FILES['photo_1']['size'];
			$filetype_photo_1 = $_FILES['photo_1']['type'];
			
			if (empty($photo_1)) { 
				$photo_1 = $photo_12; 
			} else {
				$photo_1 = $photo_1;
			}
			
			if($photo_1 != "") {
					
				if($photo_1 != $photo_12) {
					
					if(!empty($photo_12)) {
						if (file_exists($photo_asset . '/' . $photo_12)) {
							unlink($uploaddir_photo_1 . $photo_12); //remove file 
						}					
					}
					
					$photo_1 = $ref . '_' . $photo_1;
				}
				$uploaddir_photo_1 = $uploaddir_photo_1 . $photo_1;		
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo_1']['tmp_name'], $uploaddir_photo_1)) {
					echo "";											
				} 	
			}	
			
			
			/*upload file-2--------------<<<*/
			$photo_22			= $_POST["photo_22"];
			$uploaddir_photo_2	= $photo_asset .'/';
			$photo_2			= $_FILES['photo_2']['name']; 
			$tmpname_photo_2 	= $_FILES['photo_2']['tmp_name'];
			$filesize_photo_2 	= $_FILES['photo_2']['size'];
			$filetype_photo_2 	= $_FILES['photo_2']['type'];
			
			if (empty($photo_2)) { 
				$photo_2 = $photo_22; 
			} else {
				$photo_2 = $photo_2;
			}
			
			if($photo_2 != "") {
					
				if($photo_2 != $photo_22) {
					
					if(!empty($photo_22)) {
						if (file_exists($photo_asset . '/' . $photo_22)) {
							unlink($uploaddir_photo_2 . $photo_22); //remove file 
						}					
					}
					
					$photo_2 = $ref . '_' . $photo_2;
				}
				$uploaddir_photo_2 = $uploaddir_photo_2 . $photo_2;		
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo_2']['tmp_name'], $uploaddir_photo_2)) {
					echo "";											
				} 	
			}	
			
			
			/*upload file-3--------------<<<*/
			$photo_32			= $_POST["photo_32"];
			$uploaddir_photo_3	= $photo_asset .'/';
			$photo_3			= $_FILES['photo_3']['name']; 
			$tmpname_photo_3 	= $_FILES['photo_3']['tmp_name'];
			$filesize_photo_3 	= $_FILES['photo_3']['size'];
			$filetype_photo_3 	= $_FILES['photo_3']['type'];
			
			if (empty($photo_3)) { 
				$photo_3 = $photo_32; 
			} else {
				$photo_3 = $photo_3;
			}
			
			if($photo_3 != "") {
					
				if($photo_3 != $photo_32) {
					
					if(!empty($photo_32)) {
						if (file_exists($photo_asset . '/' . $photo_32)) {
							unlink($uploaddir_photo_3 . $photo_32); //remove file 
						}					
					}
					
					$photo_3 = $ref . '_' . $photo_3;
				}
				$uploaddir_photo_3 = $uploaddir_photo_3 . $photo_3;		
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo_3']['tmp_name'], $uploaddir_photo_3)) {
					echo "";											
				} 	
			}	
			
			
			/*upload file-4--------------<<<*/
			$photo_42			= $_POST["photo_42"];
			$uploaddir_photo_4	= $photo_asset .'/';
			$photo_4			= $_FILES['photo_4']['name']; 
			$tmpname_photo_4 	= $_FILES['photo_4']['tmp_name'];
			$filesize_photo_4 	= $_FILES['photo_4']['size'];
			$filetype_photo_4 	= $_FILES['photo_4']['type'];
			
			if (empty($photo_4)) { 
				$photo_4 = $photo_42; 
			} else {
				$photo_4 = $photo_4;
			}
			
			if($photo_4 != "") {
					
				if($photo_4 != $photo_42) {
					
					if(!empty($photo_42)) {
						if (file_exists($photo_asset . '/' . $photo_42)) {
							unlink($uploaddir_photo_4 . $photo_42); //remove file 
						}					
					}
					
					$photo_4 = $ref . '_' . $photo_4;
				}
				$uploaddir_photo_4 = $uploaddir_photo_4 . $photo_4;		
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo_4']['tmp_name'], $uploaddir_photo_4)) {
					echo "";											
				} 	
			}	
			
			

			//----------------
			$sqlstr="update asset set asset_name='$asset_name', alias='$alias', ref_id='$ref_id', lokasi='$lokasi', provinsi_kode='$provinsi_kode', kota_kode='$kota_kode', kecamatan_kode='$kecamatan_kode', desa_kode='$desa_kode', asset_type_id='$asset_type_id', status='$status', luas='$luas', sertifikat='$sertifikat', imb='$imb', tanggal_perolehan='$tanggal_perolehan', pemilik_sebelum='$pemilik_sebelum', contact_name='$contact_name', no_pbb='$no_pbb', group_block='$group_block', alamat='$alamat', lintang='$lintang', bujur='$bujur', nilai_perolehan='$nilai_perolehan', nilai_amnesti='$nilai_amnesti', pemilik_sekarang='$pemilik_sekarang', photo='$photo', photo_1='$photo_1', photo_2='$photo_2', photo_3='$photo_3', photo_4='$photo_4', shm='$shm', shm_nama='$shm_nama', ajb='$ajb', pbb='$pbb', keterangan='$keterangan', active='$active', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
    
    
    //-----update asset trans
	function update_asset_trans($ref){
		$dbpdo = DB::create();
		
		try {
			
			$tanggal	        =	date("Y-m-d", strtotime($_POST["tanggal"]));        
	        $asset_id		    =	$_POST["asset_id"];        
			$penyewa	        =	petikreplace($_POST["penyewa"]);
			$lama_sewa    	    =	(empty($_POST["lama_sewa"])) ? 0 : $_POST["lama_sewa"];
	        $akhir_sewa	        =	date("Y-m-d", strtotime($_POST["akhir_sewa"]));
	        $harga_sewa		    =	numberreplace($_POST["harga_sewa"]);
	        $alamat             =   petikreplace($_POST["alamat"]);
			$hp        		    =   $_POST["hp"];
	        $uid			    =	$_SESSION["loginname"];
			$dlu			    =	date("Y-m-d H:i:s");
	        
			//----------------
			$sqlstr="update asset_trans set tanggal='$tanggal', asset_id='$asset_id', penyewa='$penyewa', lama_sewa='$lama_sewa', akhir_sewa='$akhir_sewa', harga_sewa='$harga_sewa', alamat='$alamat', hp='$hp', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();

		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
    
    
    //-----update cashier
	function update_cashier($ref){
		$dbpdo = DB::create();
		
		try {
			
			$old_location_id=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
			
			$ref2			= 	$_POST["ref2"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));	
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];		
			//$status			= 	$_POST["status"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
	        $client_code	=	$_POST["client_code2"];
			
			/*if($taxable == 0) {
				$ref2		= 	"";
			}*/ 
			
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//----------update sales_order detail
			$total_amount	=	0;
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$item_name2	 	= petikreplace($_POST[item_name2_.$i]);
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					$do_ref 		= $_POST[do_ref_.$i];
					$so_ref 		= $_POST[so_ref_.$i];
								
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$unit_price2 = numberreplace($_POST[unit_price2_.$i]);
					$discount	= numberreplace($_POST[discount_.$i]);
	                $discount3 	= numberreplace($_POST[discount3_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					$amount2 	= numberreplace($_POST[amount2_.$i]);
					$dummy 		= (empty($_POST[dummy_.$i])) ? 0 : $_POST[dummy_.$i]; //$_POST[dummy_.$i];
					$non_discount = (empty($_POST[non_discount_.$i])) ? 0 : $_POST[non_discount_.$i];
					$note = petikreplace($_POST[note_.$i]);
					$line_item_do	= $_POST[line_item_do_.$i];
					$line_item_so	= $_POST[line_item_so_.$i];
					
					$sqlstr = "select ref from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update sales_invoice_detail set item_code='$item_code', item_name2='$item_name2', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', unit_price2='$unit_price2', discount='$discount', discount3='$discount3', amount='$amount', amount2='$amount2', dummy='$dummy', note='$note' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (credit qty)
							$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_price', credit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='cashier' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							$total_amount	=	$total_amount + $amount;
							
						
						} else {
							$sqlstr="delete from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------delete bincard (credit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='cashier' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
						
					} else {
						$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into sales_invoice_detail (ref, do_ref, so_ref, item_code, item_name2, uom_code, qty, discount, discount3, unit_price, unit_price2, amount, amount2, dummy, non_discount, note, line_item_do, line_item_so, line) values ('$ref', '$do_ref', '$so_ref', '$item_code', '$item_name2', '$uom_code', '$qty', '$discount', '$discount3', '$unit_price', '$unit_price2', '$amount', '$amount2', '$dummy', '$non_discount', '$note', '$line_item_do', '$line_item_so', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (debit qty)
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'cashier', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
						
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						$total_amount	=	$total_amount + $amount;
						
					}
					
					
					//----------insert/update set_item_price (ditutup krn harga di seting di set item price aja)
					/*
					$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
					$resultprice = mysql_query($sqlprice);
					$numprice = mysql_num_rows($resultprice);
					
					if($numprice == 0) {
						$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
						$resultprice2 = mysql_query($sqlprice2);
						$dataprice = mysql_fetch_object($resultprice2);
					
						$last_price			=	$dataprice->current_price;
						$date_of_record		=	date("Y-m-d H:i:s");
						
						$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$uid', '$dlu')";				
						$sql=$dbpdo->prepare($sqlstr);
					}	*/
					//------------------------------------/\
					
					
				}
			}
			
						
			$cash				=	$_POST["cash"];
			$employee_id		= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$ship_to			=	$_POST["ship_to"];
			$bill_to			=	$_POST["bill_to"];
			$top				=	$_POST["top"];
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$discount2			=	numberreplace($_POST["discount"]);
			$total				=	$total_amount; //numberreplace($_POST["total"]); //$sub_total; 			
			$deposit			=	numberreplace($_POST["deposit"]);
			$photo_file			=	"";
			
			$cash_amount		=	numberreplace($_POST["cash_amount"]);
			$bank_id			=	(empty($_POST["bank_id"])) ? 0 : $_POST["bank_id"];
			$bank_amount		=	numberreplace($_POST["bank_amount1"]);
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$card_amount		=	numberreplace($_POST["card_amount"]);
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_holder	=	petikreplace($_POST["credit_card_holder"]);
			$change_amount		=	numberreplace($_POST["change_amount"]);
			
			$cash_voucher 		= 	numberreplace($_POST["cash_voucher"]);
			$ovo 				=	numberreplace($_POST["ovo"]);
			$gopay 				=	numberreplace($_POST["gopay"]);
			$void 				=	numberreplace($_POST["void"]);
			$void_memo			=	petikreplace($_POST["void_memo"]);
			
			$update_where = "";
			if($void == 1) {
				$update_where = ", void_uid='$uid', void_dlu='$dlu' ";
			}
			
			$sqlstr="update sales_invoice set ref2='$ref2', date='$date', client_code='$client_code', top='$top', due_date='$due_date', ship_to='$ship_to', bill_to='$bill_to', taxable='$taxable', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', currency_code='$currency_code', rate='$rate', employee_id='$employee_id', discount='$discount2', total='$total', memo='$memo', location_id='$location_id', deposit='$deposit', photo_file='$photo_file', cash_amount='$cash_amount', bank_id='$bank_id', bank_amount='$bank_amount', credit_card_code='$credit_card_code', card_amount='$card_amount', credit_card_no='$credit_card_no', credit_card_holder='$credit_card_holder', change_amount='$change_amount', cash_voucher='$cash_voucher', ovo='$ovo', gopay='$gopay', void='$void', void_memo='$void_memo', upd_uid='$uid', upd_dlu='$dlu' ".$update_where." where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			
            ##jika piutang
            if($cash == 0) {
				
				$total = $total - $deposit;
				
				//update AR
				$sqlstr="update ar set date='$date', contact_code='$client_code', due_date='$due_date', debit_amount='$total', top='$top', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_type='cashier' and ref_type='cashier' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();	
			}
            //---------
            
			if($bank_amount > 0) {
				
				$sqlbnk = "select name, account_code, account_coa from bank where id='$bank_id' ";
				$sql=$dbpdo->prepare($sqlbnk);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_OBJ);
				
				$cheque_no		= $data->account_code;
				$bank_name		= $data->name;
				$receipt_type	= "transfer";
				$cheque_date	= $date;
				$total			= $bank_amount;
				$account_code	= $data->account_coa;
				
				//insert ARC
				$sqlstr = "select ref from arc where ref='$ref' and type='$receipt_type'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				
				if($rows > 0) {
					$sqlstr="update arc set date='$date', client_code='$client_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr="insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}								
				
			}
			
			if($card_amount > 0) {
				
				$sqlbnk = "select name, account_code from credit_card_type where code='$credit_card_code' ";
				$sql=$dbpdo->prepare($sqlbnk);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_OBJ);
								
				$cheque_no		= $credit_card_no;
				$bank_name		= $data->name;
				$receipt_type	= "card";
				$cheque_date	= $date;
				$total			= $card_amount;
				$account_code	= $data->account_code;
				
				//insert ARC
				$sqlstr = "select ref from arc where ref='$ref' and type='$receipt_type'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				
				if($rows > 0) {
					$sqlstr="update arc set date='$date', client_code='$client_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr="insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}					
						
				
			}
			
			//notran($date, 'frmcash_invoice2', 1, '', $_SESSION["location"]) ; //----eksekusi ref
				
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
    
    
    //-----update pos
	function update_pos($ref){
		$dbpdo = DB::create();
		
		try {
		
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
			
			$client_member_code	=	$_POST["client_member_code"];
			if($client_member_code == "") {
				$client_member_code2	=	$_POST["client_member_code2"];
				$sqlcln = "select syscode from client where rtrim(ltrim(code))='$client_member_code2' ";
				$sql=$dbpdo->prepare($sqlcln);
				$sql->execute();
				$data   = $sql->fetch(PDO::FETCH_OBJ);
				$client_member_code = $data->syscode;
			}
			
			$ref2			= 	$_POST["ref2"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));	
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];		
			//$status			= 	$_POST["status"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
	        $client_code	=	$_POST["client_code2"];
			
			if($taxable == 0) {
				$ref2		= 	"";
			} 
			
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//----------update sales_order detail
			$total_amount	=	0;
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					$do_ref 		= $_POST[do_ref_.$i];
					$so_ref 		= $_POST[so_ref_.$i];
								
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$unit_price2 = numberreplace($_POST[unit_price2_.$i]);
					//$discount	= numberreplace($_POST[discount_.$i]);
	                $discount3 	= numberreplace($_POST[discount3_.$i]);
	                $amount 	= numberreplace($_POST[amount_.$i]);
					$amount2 	= numberreplace($_POST[amount2_.$i]);
					$dummy 		= (empty($_POST[dummy_.$i])) ? 0 : $_POST[dummy_.$i]; //$_POST[dummy_.$i];
					$non_discount = (empty($_POST[non_discount_.$i])) ? 0 : $_POST[non_discount_.$i];
					$request_void = (empty($_POST[request_void_.$i])) ? 0 : $_POST[request_void_.$i];
					
					$discount	= ($unit_price * $discount3)/100;
					
					$line_item_do	= $_POST[line_item_do_.$i];
					$line_item_so	= $_POST[line_item_so_.$i];
					
					$sqlstr = "select ref from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update sales_invoice_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', unit_price2='$unit_price2', discount='$discount', discount3='$discount3', amount='$amount', amount2='$amount2', dummy='$dummy', request_void='$request_void' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (credit qty)
							/*$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_price', credit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='cashier' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------AUDIT TRAIL bincard (update)
							$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$old_line', '$uid', '$dlu', 'update')";				
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();*/
							
							$total_amount	=	$total_amount + $amount;
							
						
						} else {
							//delete diganti void (harga, qty, amount dinolkan)
							/*$sqlstr="delete from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";*/
							
							$sqlstr="update sales_invoice_detail set qty='0', unit_price='0', unit_price2='0', discount='0', discount3='0', amount='0', amount2='0', note='void', request_void=0 where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------delete bincard (credit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='pos' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							
							$sqlstr="insert into adt_sales_invoice_detail (ref, item_code, uom_code, qty, end_date_discount, discount, discount2, discount3, unit_price, amount, qty_discount, non_discount, discount_percent_tmp, line, ref_near_expired, adt_status) values ('$ref', '$item_code', '$uom_code', '$qty', '$end_date_discount', '$discount', '$discount2', '$discount3', '$unit_price', '$amount', '$qty_discount', '$non_discount', '$discount_percent_tmp', '$line', '$ref_near_expired', 'void')";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//----------AUDIT TRAIL bincard (delete)
							/*$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$old_location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$old_line', '$uid', '$dlu', 'delete')";			
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();*/
							
						}
						
						
					} else {
						$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into sales_invoice_detail (ref, do_ref, so_ref, item_code, uom_code, qty, discount, discount3, unit_price, unit_price2, amount, amount2, dummy, non_discount, line_item_do, line_item_so, line) values ('$ref', '$do_ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$discount', '$discount3', '$unit_price', '$unit_price2', '$amount', '$amount2', '$dummy', '$non_discount', '$line_item_do', '$line_item_so', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (debit qty)
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------AUDIT TRAIL bincard (insert)
						/*$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu', 'insert')";					
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();*/
						
						$total_amount	=	$total_amount + $amount;
						
					}
					
					
					//----------insert/update set_item_price (ditutup krn harga di seting di set item price aja)
					/*
					$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
					$resultprice = mysql_query($sqlprice);
					$numprice = mysql_num_rows($resultprice);
					
					if($numprice == 0) {
						$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
						$resultprice2 = mysql_query($sqlprice2);
						$dataprice = mysql_fetch_object($resultprice2);
					
						$last_price			=	$dataprice->current_price;
						$date_of_record		=	date("Y-m-d H:i:s");
						
						$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$uid', '$dlu')";				
						$sql=$dbpdo->prepare($sqlstr);
					}	*/
					//------------------------------------/\
					
					
				}
			}
			
			//get total detail
			$sqlstr="select sum(amount) total from sales_invoice_detail where ref='$ref' group by ref";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data_tot = $sql->fetch(PDO::FETCH_OBJ);
			$__total = $data_tot->total;
			
						
			$cash				=	$_POST["cash"];
			$employee_id		= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$ship_to			=	$_POST["ship_to"];
			$bill_to			=	$_POST["bill_to"];
			$top				=	$_POST["top"];
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$discount2			=	numberreplace($_POST["discount"]);
			$total				=	$__total; //numberreplace($_POST["total"]); //$sub_total; 			
			$deposit			=	numberreplace($_POST["deposit"]);
			$photo_file			=	"";
			
			if($__total == 0) {
				$cash_amount		=	0;
			} else {
				$cash_amount		=	numberreplace($_POST["cash_amount"]);	
			}
			
			$ovo				=	numberreplace($_POST["ovo"]);
			$gopay				=	numberreplace($_POST["gopay"]);
			$cash_voucher		=	numberreplace($_POST["cash_voucher"]);
			$bank_id			=	(empty($_POST["bank_id"])) ? 0 : $_POST["bank_id"];
			$bank_amount		=	numberreplace($_POST["bank_amount1"]);
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$card_amount		=	numberreplace($_POST["card_amount"]);
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_holder	=	petikreplace($_POST["credit_card_holder"]);
			$change_amount		=	numberreplace($_POST["change_amount"]);
			$shift				=	$_POST["shift"];
			$void				=	(empty($_POST["void"])) ? 0 : $_POST["void"];
			
			$insert_void = "";
			if($void == 1) {
				$insert_void = ", void_uid='$uid', void_dlu='$dlu' ";
			}
			
			$sqlstr="update sales_invoice set ref2='$ref2', date='$date', client_code='$client_code', top='$top', due_date='$due_date', ship_to='$ship_to', bill_to='$bill_to', taxable='$taxable', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', currency_code='$currency_code', rate='$rate', employee_id='$employee_id', discount='$discount2', total='$total', memo='$memo', location_id='$location_id', deposit='$deposit', photo_file='$photo_file', cash_amount='$cash_amount', cash_voucher='$cash_voucher', ovo='$ovo', gopay='$gopay', bank_id='$bank_id', bank_amount='$bank_amount', credit_card_code='$credit_card_code', card_amount='$card_amount', credit_card_no='$credit_card_no', credit_card_holder='$credit_card_holder', change_amount='$change_amount', shift='$shift', client_member_code='$client_member_code', void='$void', upd_uid='$uid', upd_dlu='$dlu' ".$insert_void." where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			/*---------insert audit trail (update)------------*/
			$cash	=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			
			$sqlstr="select ref from adt_sales_invoice where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows = $sql->rowCount();
			if($rows == 0) {
				$sqlstr="insert into adt_sales_invoice (ref, ref2, date, status, top, due_date, client_code, ship_to, bill_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, discount, total, memo, opening_balance, cash, location_id, deposit, taxable, photo_file, cash_amount, cash_voucher, bank_id, bank_amount, credit_card_code, card_amount, credit_card_no, credit_card_holder, change_amount, shift, client_member_code, uid, dlu, adt_status) values('$ref', '$ref2', '$date', 'R', '$top', '$due_date', '$client_code', '$ship_to', '$bill_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$discount2', '$total', '$memo', 0, '$cash', '$location_id', '$deposit', '$taxable', '$photo_file', '$cash_amount', '$cash_voucher', '$bank_id', '$bank_amount', '$credit_card_code', '$card_amount', '$credit_card_no', '$credit_card_holder', '$change_amount', '$shift', '$client_member_code', '$uid', '$dlu', 'update')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			
			
            ##jika piutang
            if($cash == 0) {
				
				$total = $total - $deposit;
				
				//update AR
				$sqlstr="update ar set date='$date', contact_code='$client_code', due_date='$due_date', debit_amount='$total', top='$top', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_type='cashier' and ref_type='pos' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();	
			}
            //---------
            
			if($bank_amount > 0) {
				
				$sqlbnk = "select name, account_code, account_coa from bank where id='$bank_id' ";
				$sql=$dbpdo->prepare($sqlbnk);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_OBJ);
				
				$cheque_no		= $data->account_code;
				$bank_name		= $data->name;
				$receipt_type	= "transfer";
				$cheque_date	= $date;
				$total			= $bank_amount;
				$account_code	= $data->account_coa;
				
				//insert ARC
				$sqlstr = "select ref from arc where ref='$ref' and type='$receipt_type'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				
				if($rows > 0) {
					$sqlstr="update arc set date='$date', client_code='$client_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr="insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}								
				
			}
			
			if($card_amount > 0) {
				
				$sqlbnk = "select name, account_code from credit_card_type where code='$credit_card_code' ";
				$sql=$dbpdo->prepare($sqlbnk);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_OBJ);
								
				$cheque_no		= $credit_card_no;
				$bank_name		= $data->name;
				$receipt_type	= "card";
				$cheque_date	= $date;
				$total			= $card_amount;
				$account_code	= $data->account_code;
				
				//insert ARC
				$sqlstr = "select ref from arc where ref='$ref' and type='$receipt_type'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				
				if($rows > 0) {
					$sqlstr="update arc set date='$date', client_code='$client_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr="insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}					
						
				
			}
			
			
			##member only
			$sqlstr="delete from sales_invoice_point where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			if($total > 0 && $client_member_code != "") {
				$point				=	floor($total/50000);
				$cleared			=	0;
				
				$sqlstr="insert into sales_invoice_point (ref, date, client_code, point, cleared) values('$ref', '$date', '$client_member_code', '$point', '$cleared')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();	
			}
				
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----insert pos detail
	function update_pos_detail($ref, $line, $qty, $unit_price, $amount, $item_code, $uom_code, $discount3='', $ref_near_expired=''){	
		
		$dbpdo = DB::create();
		
		try {
			
			$dlu			=	date("Y-m-d H:i:s");
			$qty 		    = numberreplace($qty);
			$unit_price     = numberreplace($unit_price);
			$amount 	    = numberreplace($unit_price) * numberreplace($qty); //numberreplace($amount);
			$discount3		= numberreplace($discount3);
			
			##cek jmlh qty, krn berpengaruh harga jual
			$datenow = date("Y-m-d");
			$location_id = $_SESSION['location_id2'];
			$sqlprice = "select a.current_price, a.current_price1, a.current_price2, a.current_price3, a.qty1, a.qty2, a.qty3, a.qty4, a.end_date_discount, a.discount, a.discount_percent, a.qty1, ifnull(a.non_discount,0) non_discount from set_item_price a  where a.item_code='$item_code' and a.uom_code='$uom_code' and a.efective_from <='$datenow' and a.location_id='$location_id'  order by a.date_of_record desc limit 1 ";
			$resultprice=$dbpdo->prepare($sqlprice);
			$resultprice->execute();
			$dataprice	= $resultprice->fetch(PDO::FETCH_OBJ);
			
			$current_price 	= $dataprice->current_price;
			$current_price1 = $dataprice->current_price1;
			$current_price2	= $dataprice->current_price2;
			$current_price3	= $dataprice->current_price3;
			
			$qty1 	= $dataprice->qty1;
			$qty2 	= $dataprice->qty2;
			$qty3	= $dataprice->qty3;
			$qty4	= $dataprice->qty4;
			
			if($qty > 0) {
				/*if($qty <= $qty1) {
					$unit_price = $current_price;
				}
				
				if( ($qty < $qty2) ) {
					$unit_price = $current_price; //$current_price1;
					
				}
				
				if( ($qty >= $qty2) ) {
					if($qty2 < $qty3) {
						$unit_price = $current_price1;
					}
					
				}
				if($qty >= $qty3) {
					$unit_price = $current_price2;
					
				}
				
				
				//jika qty tidak diseting harga
				if( $current_price > 0 && $current_price1 == 0 && $current_price2 == 0) {
					$unit_price = $current_price;
				}*/
				
				
			} else {
				$qty_tmp = ($qty * -1);
				
				if($qty_tmp <= $qty1) {
					$unit_price = $current_price;
				}
				
				if( ($qty_tmp < $qty2) ) {
					$unit_price = $current_price; //$current_price1;
					
				}
				
				if( ($qty_tmp >= $qty2) ) {
					if($qty2 < $qty3) {
						$unit_price = $current_price1;
					}
					
				}
				if($qty_tmp >= $qty3) {
					$unit_price = $current_price2;
				}
				
				
				//jika qty tidak diseting harga
				if( $current_price > 0 && $current_price1 == 0 && $current_price2 == 0) {
					$unit_price = $current_price;
				}
				
				/*if($qty_tmp <= $qty1) {
					$unit_price = $current_price;
				}
				if( ($qty_tmp > $qty1) && ($qty_tmp <= $qty2) ) {
					$unit_price = $current_price1;
					
				}
				if($qty_tmp > $qty2) {
					$unit_price = $current_price2;
				}*/
			}
			
			//get discount
			$discount			= 0;
			$discount2			= 0;
			$discount_percent	= 0;
			$date_now = date("Y-m-d");
			$end_date_discount	= $dataprice->end_date_discount;
			if( $date_now <= $dataprice->end_date_discount && $qty >= $dataprice->qty1 ) {
				$discount			= $dataprice->discount;
				$discount2			= $dataprice->discount;
				$discount_percent	= $dataprice->discount_percent;
			}
			if( $date_now <= $dataprice->end_date_discount && $dataprice->non_discount > 0 ) {
				$discount			= $dataprice->discount;
				$discount2			= $dataprice->discount;
				$discount_percent	= $dataprice->discount_percent;
			}
			//------/\---------
			
			//get discount (near expired)
			if($ref_near_expired != "") {
				$item_code_exp = $item_code;
				
				$sqlexp = "select b.end_date, a.syscode, a.discount, a.discount_percent from item_near_expired_detail a left join item_near_expired b on a.ref=b.ref where a.item_code='$item_code' and a.uom_code='$uom_code' and b.location_id='$location_id' and '$date_now' <= b.end_date and a.syscode='$ref_near_expired' order by a.syscode desc limit 1 ";
				$resultexp=$dbpdo->prepare($sqlexp);
				$resultexp->execute();
				$countexp = $resultexp->rowCount();
				$dataexp = $resultexp->fetch(PDO::FETCH_OBJ);
				if($countexp > 0) {
					$discount 			= $dataexp->discount;
					$discount2 			= $dataexp->discount;
					$discount_percent	= $dataexp->discount_percent;
					$end_date_discount	= $dataexp->end_date;
				}
			}
			//------/\---------
					
			
			$unit_price_tmp = $unit_price - (($unit_price * $discount_percent)/100); //$discount3
			$amount = $qty * $unit_price_tmp;
			$total = $amount;
			##end cek

			if($qty > 0) {
				$sqlstr="update sales_invoice_tmp set qty='$qty', unit_price='$unit_price', amount='$amount', total='$total', end_date_discount='$end_date_discount', discount='$discount', discount2='$discount2', discount3='$discount_percent', qty_discount='$qty1', non_discount='$dataprice->non_discount', deposit='$discount_percent', dlu='$dlu' where ref='$ref' and line='$line'";
				$sqlx=$dbpdo->prepare($sqlstr);
				$sqlx->execute();
			}
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
			
		return $sql;
	}
	
	
	
	//-----update purchase inv
	function update_purchase_inv($ref){
		$dbpdo = DB::create();
		
		try {
		
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			
			
				
			
			//----------update item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_qty 			= numberreplace($_POST[old_qty_.$i]);
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code3	 	= $_POST[item_code3_.$i];
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				$qty 			= numberreplace($_POST[qty_.$i]);
				$unit_cost 		= numberreplace($_POST[unit_cost_.$i]);
				$amount 		= numberreplace($_POST[amount_.$i]); 
				
				//jika add item baru
				if($item_code3 != "") {
					$sqlstr = "select syscode, uom_code_purchase uom_code from item where (code='$item_code3' or old_code='$item_code3') limit 1 ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$data = $sql->fetch(PDO::FETCH_OBJ);
					
					$item_code	= $data->syscode;
					$uom_code	= $data->uom_code;
					if($qty == "" || $qty == 0) {
						$qty = 1;
					}
					
					$selectview = new selectview;
					if($unit_cost == "" || $unit_cost == 0) {
						$unit_cost = $selectview->list_purchase_invoice_last_cost($item_code, $uom_code);
					}
					
					if($amount == "" || $amount == 0) {
						$amount = $qty * $unit_cost;
					}
										
				}
				
				if ( !empty($item_code) && !empty($uom_code) ) {
					
					$discount = numberreplace($_POST[discount_.$i]);
                	$discount1 = numberreplace($_POST[discount3_1_.$i]);
					$discount2 = numberreplace($_POST[discount3_2_.$i]);
	                $discount3 = numberreplace($_POST[discount3_3_.$i]);
					
					$line_item_po = (empty($_POST[line_item_po_.$i])) ? 0 : $_POST[line_item_po_.$i];
					
					$sqlstr = "select ref from purchase_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							
							//jika tidak ada item baru
							$sqlstr="update purchase_invoice_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_cost='$unit_cost', discount1='$discount1', discount2='$discount2', discount3='$discount3', discount='$discount', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (debit qty)
							$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_cost', debit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='purchase_inv' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
													
								
						} else {
							$sqlstr="delete from purchase_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//----------delete bincard (debit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='purchase_inv' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
																		
						}
						
						
					} else {
						$line = maxline('purchase_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into purchase_invoice_detail (ref, po_ref, item_code, uom_code, qty, unit_cost, amount, line_item_po, line) values ('$ref', '', '$item_code', '$uom_code', '$qty', '$unit_cost', '$amount', '0', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (debit qty)
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_inv', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";
						
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
											
					}
					
					
					
				}
			}
			
			
			//insert new item-------------------\/
			$item_code3		= $_POST['item_code2'];
			$uom_code 		= $_POST['uom_code'];
			$qty 			= numberreplace($_POST['qty']);
			$unit_cost 		= numberreplace($_POST['unit_cost']);
			$amount 		= numberreplace($_POST['amount']); 
			
			//jika add item baru
			if($item_code3 != "") {
				
				$sqlstr = "select syscode, uom_code_purchase uom_code from item where (code='$item_code3' or old_code='$item_code3') limit 1 ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_OBJ);
				
				$item_code	= $data->syscode;
				$uom_code	= $data->uom_code;
				if($qty == "" || $qty == 0) {
					$qty = 1;
				}
				
				$selectview = new selectview;
				if($unit_cost == "" || $unit_cost == 0) {
					$unit_cost = $selectview->list_purchase_invoice_last_cost($item_code, $uom_code);
				}
				
				if($amount == "" || $amount == 0) {
					$amount = $qty * $unit_cost;
				}
									
			}
			
			if ( !empty($item_code) && !empty($uom_code) ) {
				
				$discount		= numberreplace($_POST['discount_det']); //discount nominal
				$discount1		= numberreplace($_POST['discount3_1_det']); //discount %
				
                
                $discount2 = 0;
                $discount3 = 0;
				
				$line_item_po = maxline('purchase_invoice_detail', 'line', 'ref', $ref, '');
				
				$sqlstr = "select ref from purchase_invoice_detail where ref='$ref' and item_code='$item_code' and uom_code='$uom_code' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$num = $sql->rowCount();
				
				if($num > 0) {
					
					$sqlstr = "select sum(qty) qty_old from purchase_invoice_detail where ref='$ref' and item_code='$item_code' and uom_code='$uom_code' group by ref, item_code, uom_code ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$data_qty = $sql->fetch(PDO::FETCH_OBJ);
					$qty_upd = $data_qty->qty_old + $qty;
					$amount_upd = $unit_cost - (($unit_cost * $discount1)/100);
					$amount = $amount_upd * $qty_upd;
					
					$sqlstr="update purchase_invoice_detail set qty=ifnull(qty,0) + $qty, unit_cost='$unit_cost', discount1='$discount1', discount2='$discount2', discount3='$discount3', discount='$discount', amount='$amount' where ref='$ref' and item_code='$item_code' and uom_code='$uom_code' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
					//----------update bincard (debit qty)
					$sqlstr="update bincard set location_code='$location_id', date='$date', unit_price='$unit_cost', debit_qty=ifnull(debit_qty,0) + $qty, amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$item_code' and uom_code='$uom_code' and invoice_type='purchase_inv' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
						
					
				} else {
					$line = maxline('purchase_invoice_detail', 'line', 'ref', $ref, '');
					
					$sqlstr="insert into purchase_invoice_detail (ref, po_ref, item_code, uom_code, qty, unit_cost, amount, line_item_po, line) values ('$ref', '', '$item_code', '$uom_code', '$qty', '$unit_cost', '$amount', '0', $line)";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
					//----------insert bincard (debit qty)
					$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_inv', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";
					
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
										
				}	
			}		
			//---------------end item new--------/\
			
			
			
			//-get amount
			$sqlstr = "select sum(amount) amount from purchase_invoice_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;
			
			$invoice_no			=	$_POST["invoice_no"];
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			$tax_code			= 	$_POST["tax_code"];
			$payment_type		=	$_POST["payment_type"];
			$tax_rate			=	numberreplace((empty($_POST["tax_rate"])) ? 0 : $_POST["tax_rate"]);
			$freight_cost		=	numberreplace((empty($_POST["freight_cost"])) ? 0 : $_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$memo				= 	petikreplace($_POST["memo"]);		
			$cash				=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$cash_amount		= 	numberreplace($_POST["cash_amount"]);
			$change_amount		=	numberreplace($_POST["change_amount"]);
			$discount 			= 	numberreplace($_POST["discount_det"]);
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));
			$total				=	numberreplace($_POST["total"]); //$sub_total + $freight_cost;
			
			$bank_id			=	(empty($_POST["bank_id"])) ? 0 : $_POST["bank_id"];
			$bank_amount		=	numberreplace($_POST["bank_amount"]);
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$card_amount		=	numberreplace($_POST["card_amount"]);
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_holder	=	petikreplace($_POST["credit_card_holder"]);
			
			//status='$status', 
			$sqlstr="update purchase_invoice set invoice_no='$invoice_no', date='$date', bill_number='$bill_number', vendor_code='$vendor_code', payment_type='$payment_type', top='$top', due_date='$due_date', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', memo='$memo', discount='$discount', total='$total', cash_amount='$cash_amount', change_amount='$change_amount', bank_id='$bank_id', bank_amount='$bank_amount', credit_card_code='$credit_card_code', card_amount='$card_amount', credit_card_no='$credit_card_no', credit_card_holder='$credit_card_holder', uid='$uid', dlu='$dlu' where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			
			if($payment_type == "credit" || $payment_type == "consign") {
				//insert AP
				$sqlstr="delete from ap where ref='$ref' and invoice_type='POV' and ref_type='POV' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				
				$sqlstr="insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'V', '$vendor_code', '', 0, '$total', 'POV', 'POV', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				//insert AP
				$sqlstr="delete from ap where ref='$ref' and invoice_type='POV' and ref_type='POV' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----insert purchase inv detail
	function update_purchase_inv_detail($ref, $line, $qty, $unit_cost, $discount_p, $discount, $amount){	
		
		$dbpdo = DB::create();
		
		try {
				
			$qty 		    = numberreplace($qty);
			$unit_cost	    = numberreplace($unit_cost);
			$discount_p	    = numberreplace($discount_p);
			$discount	    = numberreplace($discount);
			$amount 	    = numberreplace($amount); //numberreplace($qty) * numberreplace($unit_cost); //numberreplace($amount);

			$sqlstr="update purchase_invoice_tmp set qty='$qty', unit_cost='$unit_cost', discount1='$discount_p', discount='$discount', amount='$amount', total='$total' where ref='$ref' and line='$line'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
					
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
			
		return $sql;
	}
	
	
	//-----insert outbound detail
	function update_outbound_detail($ref, $line, $qty, $unit_cost, $amount){	
		
		$dbpdo = DB::create();
		
		try {
				
			$qty 		    = numberreplace($qty);
			
			$sqlstr="update outbound_tmp set qty='$qty' where ref='$ref' and line='$line'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
					
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
			
		return $sql;
	}
    
    
    //-----insert purchase return  detail
	function update_purchase_return_quick_detail($ref, $line, $qty, $unit_cost, $discount_p, $discount, $amount){	
		
		$dbpdo = DB::create();
		
		try {
				
			$qty 		    = numberreplace($qty);
			$unit_cost	    = numberreplace($unit_cost);
			$discount_p	    = numberreplace($discount_p);
			$discount	    = numberreplace($discount);
			$amount 	    = numberreplace($amount); //numberreplace($qty) * numberreplace($unit_cost); //numberreplace($amount);

			$sqlstr="update purchase_return_tmp set qty='$qty', unit_cost='$unit_cost', discount1='$discount_p', discount='$discount', amount='$amount' where ref='$ref' and line='$line'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
					
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
			
		return $sql;
	}
	
	
	//-----update purchase return quick
	function update_purchase_return_quick($ref){
		$dbpdo = DB::create();
		
		try {
		
	        $date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$location_id		= 	$_POST["location_id"];
			$old_location_id	=	$_POST["old_location_id"];
			$pi_ref				=	$_POST["pi_ref"];
	        $uid			    =	$_SESSION["loginname"];
			$dlu			    =	date("Y-m-d H:i:s");
			
	        //----------update detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_qty 			= numberreplace($_POST[old_qty_.$i]);
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				//$item_code3	 	= $_POST[item_code3_.$i];
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				$qty 			= numberreplace($_POST[qty_.$i]);
				$unit_cost	= numberreplace($_POST[unit_cost_.$i]);
				$discount1	= numberreplace($_POST[discount3_1_.$i]);
				$discount	= numberreplace($_POST[discount_.$i]);
				$amount 	= numberreplace($_POST[amount_.$i]);
				
				//jika add item baru
				if($item_code3 != "") {
					$sqlstr = "select syscode, uom_code_purchase uom_code from item where (code='$item_code3' or old_code='$item_code3') limit 1 ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$data = $sql->fetch(PDO::FETCH_OBJ);
					
					$item_code	= $data->syscode;
					$uom_code	= $data->uom_code;
					if($qty == "" || $qty == 0) {
						$qty = 1;
					}
					
					$selectview = new selectview;
					if($unit_cost == "" || $unit_cost == 0) {
						$unit_cost = $selectview->list_purchase_invoice_last_cost($item_code, $uom_code);
					}
					
					if($amount == "" || $amount == 0) {
						$amount = $qty * $unit_cost;
					}
					
				}
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					
					
					
					$line_item_pi	= $_POST[line_item_pi_.$i];
					
					$sqlstr = "select ref from purchase_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update purchase_return_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_cost='$unit_cost', discount1='$discount1', discount='$discount', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							##--------update qty purchase invoice
							if($status != "P") {
								//----------update bincard (credit qty)
								//$amount = $qty * $unit_cost;
								
								$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_cost', credit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='purchase_return' ";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
								
							}
						
						} else {
							$sqlstr="delete from purchase_return_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
							
							//----------delete bincard (credit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='purchase_return' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
												
						}
						
						
					} else {
						$line = maxline('purchase_return_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into purchase_return_detail (ref, item_code, uom_code, qty, discount1, discount, unit_cost, amount, line_item_pi, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount1', '$discount', '$unit_cost', '$amount', '$line_item_pi', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						##--------update qty 
						if($status != "P") {
							
	                        //----------insert bincard (debit qty)
	                        //$amount = $qty * $unit_cost;
							$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_return', '$memo', '$item_code', '$uom_code', '0', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
							
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						}
						
					}
					
					
					
				}
			}
			
			
			
			//jika ada tambah barang
			$item_code		=	"";
			$item_code2		= 	$_POST['item_code3'];
			$uom_code 		= 	$_POST['uom_code'];			
	        $qty 		    = 	numberreplace($_POST['qty']);
	        $discount1	    = 	numberreplace($_POST['discount3_1_det']);
	        $discount	    = 	numberreplace($_POST['discount_det']);
	        $unit_cost	    = 	numberreplace($_POST['unit_cost']);
	        $amount		    = 	numberreplace($_POST['amount']);
	        $location_id	=	$_POST["location_id"];
			
					
			if($item_code2 != "") {
		        //----------
		        $sqlstr 	= "select syscode, uom_code_purchase uom_code from item where (code='$item_code2' or old_code='$item_code2') limit 1";
		        $sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$data 	= $sql->fetch(PDO::FETCH_OBJ); 
				
				//if($item_code == '') {
					$item_code 	= $data->syscode;	
				//}
				
				if($uom_code == '') {
					$uom_code	= $data->uom_code;	
				}
				
				
				if($qty == '' || $qty == 0) {
					$qty = 1;
				}
				
				if ( empty($item_code) && empty($uom_code) ) {
		            $sqlstr 	    = "select syscode, uom_code_purchase uom_code from item where (code='$item_code2' or old_code='$item_code2') limit 1";
		            $sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$data		= $sql->fetch(PDO::FETCH_OBJ);
					
					$item_code  = $data->syscode;
		            $uom_code   = $data->uom_code; 
		            
		            $qty        = 1;
		            
		        }
		        
		        			
				if ( !empty($item_code) && !empty($uom_code) ) {		
					
					
					
					if($amount == 0 || $amount == ""){
						$selectview = new selectview;
						
						//get discount terakhir dr pembelian
						$unit_cost = $selectview->list_purchase_invoice_last_cost($item_code, $uom_code);
						
						$discount1 = 0;
						$discount = 0;
						$sqldisc = $selectview->list_purchase_invoice_last_discount($item_code, $uom_code);
						$datadisc = $sqldisc->fetch(PDO::FETCH_OBJ); 
						$discount1 = $datadisc->discount1;
						$discount = $datadisc->discount;
						
						$amount			= (numberreplace($unit_cost) * $qty) - $discount;
						//------------/\--------------------
					}
					
					$line = maxline('purchase_return_detail', 'line', 'ref', $ref, '');
					$sqlstr="insert into purchase_return_detail (ref, item_code, uom_code, qty, discount1, discount, unit_cost, amount, line_item_pi, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount1', '$discount', '$unit_cost', '$amount', '$line_item_pi', $line)";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
					##--------update qty 
					if($status != "P") {
						
	                    //----------insert bincard (debit qty)
	                    //$amount = $qty * $unit_cost;
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_return', '$memo', '$item_code', '$uom_code', '$unit_cost', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
					}					
											
				}	
			}
			
			
			
			//-get amount
			$sqlstr = "select sum(amount) amount from purchase_return_detail where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			
			$sub_total = $data->amount;
						
			$vendor_code		=	$_POST["vendor_code"];			
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$total				=	$sub_total; //numberreplace($_POST["total"]);
			
			$sqlstr="update purchase_return set date='$date', status='$status', pi_ref='$pi_ref', vendor_code='$vendor_code', tax_code='$tax_code', tax_rate='$tax_rate', currency_code='$currency_code', rate='$rate', total='$total', memo='$memo', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();	
			
			//-------insert AP
			$sqlstr="delete from ap where ref='$ref' and invoice_type='PUR' and ref_type='PUR' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$sqlstr="insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '1900-01-01', 'V', '$vendor_code', '', '$total', 0, 'PUR', 'PUR', '$currency_code', '$rate', '', '', '', '$memo', '$uid', '$dlu')";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update cashier box
	function update_cashier_box($ref){
		$dbpdo = DB::create();
		
		try {
			
			$old_location_id=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
			
			$ref2			= 	$_POST["ref2"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));	
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];		
			//$status			= 	$_POST["status"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
	        $client_code	=	$_POST["client_code2"];
			
			/*if($taxable == 0) {
				$ref2		= 	"";
			}*/ 
			
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//----------update sales_order detail
			$total_amount	=	0;
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					$do_ref 		= $_POST[do_ref_.$i];
					$so_ref 		= $_POST[so_ref_.$i];
								
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$unit_price2 = numberreplace($_POST[unit_price2_.$i]);
					$discount	= numberreplace($_POST[discount_.$i]);
	                $discount3 	= numberreplace($_POST[discount3_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					$amount2 	= numberreplace($_POST[amount2_.$i]);
					$dummy 		= (empty($_POST[dummy_.$i])) ? 0 : $_POST[dummy_.$i]; //$_POST[dummy_.$i];
					$non_discount = (empty($_POST[non_discount_.$i])) ? 0 : $_POST[non_discount_.$i];
					$note = petikreplace($_POST[note_.$i]);
					$line_item_do	= $_POST[line_item_do_.$i];
					$line_item_so	= $_POST[line_item_so_.$i];
					
					$sqlstr = "select ref from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update sales_invoice_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', unit_price2='$unit_price2', discount='$discount', discount3='$discount3', amount='$amount', amount2='$amount2', dummy='$dummy', note='$note' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (credit qty)
							$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_price', credit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='cashier' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							$total_amount	=	$total_amount + $amount;
							
						
						} else {
							$sqlstr="delete from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//delete subdetail
							$sqlstr="delete from sales_invoice_subdetail where ref='$ref' and line_detail='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------delete bincard (credit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='cashier' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
						
					} else {
						$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into sales_invoice_detail (ref, do_ref, so_ref, item_code, uom_code, qty, discount, discount3, unit_price, unit_price2, amount, amount2, dummy, non_discount, note, line_item_do, line_item_so, line) values ('$ref', '$do_ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$discount', '$discount3', '$unit_price', '$unit_price2', '$amount', '$amount2', '$dummy', '$non_discount', '$note', '$line_item_do', '$line_item_so', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (debit qty)
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'cashier', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
						
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						$total_amount	=	$total_amount + $amount;
						
					}
					
					
					//----------insert/update set_item_price (ditutup krn harga di seting di set item price aja)
					/*
					$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
					$resultprice = mysql_query($sqlprice);
					$numprice = mysql_num_rows($resultprice);
					
					if($numprice == 0) {
						$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
						$resultprice2 = mysql_query($sqlprice2);
						$dataprice = mysql_fetch_object($resultprice2);
					
						$last_price			=	$dataprice->current_price;
						$date_of_record		=	date("Y-m-d H:i:s");
						
						$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$uid', '$dlu')";				
						$sql=$dbpdo->prepare($sqlstr);
					}	*/
					//------------------------------------/\
					
					
				}
			}
			
			
			##if add item
			$item_code 		= $_POST['item_code'];
			$uom_code 		= $_POST['uom_code'];
						
			if ( !empty($item_code) && !empty($uom_code) ) {
									
				$qty = numberreplace($_POST['qty']);
				$unit_price = numberreplace($_POST['unit_price']);
				$discount = numberreplace($_POST['discount']);
                $discount3 = numberreplace($_POST['discount3']);
				$amount = numberreplace($_POST['amount']);
				$non_discount = (empty($_POST['non_discount'])) ? 0 : $_POST['non_discount'];
				$note = petikreplace($_POST['note']);
				
				$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');
				
				$sqlstr="insert into sales_invoice_detail (ref, item_code, uom_code, qty, discount, discount3, unit_price, amount, non_discount, note, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount', '$discount3', '$unit_price', '$amount', '$non_discount', '$note', '$line')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();								
				
				//----------insert bincard (debit qty)
				$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'cashier', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";				
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();	
				
				$total_amount = $total_amount + $amount;
			}
			##-------/\---------------------
			
						
			$cash				=	$_POST["cash"];
			$employee_id		= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$ship_to			=	$_POST["ship_to"];
			$bill_to			=	$_POST["bill_to"];
			$top				=	$_POST["top"];
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$discount2			=	numberreplace($_POST["discount"]);
			$total				=	$total_amount; //numberreplace($_POST["total"]); //$sub_total; 			
			$deposit			=	numberreplace($_POST["deposit"]);
			$photo_file			=	"";
			
			$cash_amount		=	numberreplace($_POST["cash_amount"]);
			$bank_id			=	(empty($_POST["bank_id"])) ? 0 : $_POST["bank_id"];
			$bank_amount		=	numberreplace($_POST["bank_amount1"]);
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$card_amount		=	numberreplace($_POST["card_amount"]);
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_holder	=	petikreplace($_POST["credit_card_holder"]);
			$change_amount		=	numberreplace($_POST["change_amount"]);
			
			$cash_voucher 		= 	numberreplace($_POST["cash_voucher"]);
			$ovo 				=	numberreplace($_POST["ovo"]);
			$gopay 				=	numberreplace($_POST["gopay"]);
			$void 				=	numberreplace($_POST["void"]);
			$void_memo			=	petikreplace($_POST["void_memo"]);
			
			$update_where = "";
			if($void == 1) {
				$update_where = ", void_uid='$uid', void_dlu='$dlu' ";
			}
			
			$sqlstr="update sales_invoice set ref2='$ref2', date='$date', client_code='$client_code', top='$top', due_date='$due_date', ship_to='$ship_to', bill_to='$bill_to', taxable='$taxable', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', currency_code='$currency_code', rate='$rate', employee_id='$employee_id', discount='$discount2', total='$total', memo='$memo', location_id='$location_id', deposit='$deposit', photo_file='$photo_file', cash_amount='$cash_amount', bank_id='$bank_id', bank_amount='$bank_amount', credit_card_code='$credit_card_code', card_amount='$card_amount', credit_card_no='$credit_card_no', credit_card_holder='$credit_card_holder', change_amount='$change_amount', cash_voucher='$cash_voucher', ovo='$ovo', gopay='$gopay', void='$void', void_memo='$void_memo', upd_uid='$uid', upd_dlu='$dlu' ".$update_where." where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			
            ##jika piutang
            if($cash == 0) {
				
				$total = $total - $deposit;
				
				//update AR
				$sqlstr="update ar set date='$date', contact_code='$client_code', due_date='$due_date', debit_amount='$total', top='$top', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_type='cashier' and ref_type='cashier' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();	
			}
            //---------
            
			if($bank_amount > 0) {
				
				$sqlbnk = "select name, account_code, account_coa from bank where id='$bank_id' ";
				$sql=$dbpdo->prepare($sqlbnk);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_OBJ);
				
				$cheque_no		= $data->account_code;
				$bank_name		= $data->name;
				$receipt_type	= "transfer";
				$cheque_date	= $date;
				$total			= $bank_amount;
				$account_code	= $data->account_coa;
				
				//insert ARC
				$sqlstr = "select ref from arc where ref='$ref' and type='$receipt_type'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				
				if($rows > 0) {
					$sqlstr="update arc set date='$date', client_code='$client_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr="insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}								
				
			}
			
			if($card_amount > 0) {
				
				$sqlbnk = "select name, account_code from credit_card_type where code='$credit_card_code' ";
				$sql=$dbpdo->prepare($sqlbnk);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_OBJ);
								
				$cheque_no		= $credit_card_no;
				$bank_name		= $data->name;
				$receipt_type	= "card";
				$cheque_date	= $date;
				$total			= $card_amount;
				$account_code	= $data->account_code;
				
				//insert ARC
				$sqlstr = "select ref from arc where ref='$ref' and type='$receipt_type'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				
				if($rows > 0) {
					$sqlstr="update arc set date='$date', client_code='$client_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr="insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}					
						
				
			}
			
			//notran($date, 'frmcash_invoice2', 1, '', $_SESSION["location"]) ; //----eksekusi ref
				
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update cashier_box_subdetail
	function update_cashier_box_subdetail($ref){
		$dbpdo = DB::create();
		
		try {
			
			//----------update sales_order detail
			$total_amount	=	0;
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					$qty 		= numberreplace($_POST[qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$amount 	= numberreplace($_POST[amount_.$i]);
					$note = petikreplace($_POST[note_.$i]);
					
					if($delete == 0) {
						$sqlstr="update sales_invoice_subdetail set qty='$qty', unit_price='$unit_price', amount='$amount' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------update bincard (credit qty)
						/*$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_price', credit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='cashier' ";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();*/
											
					} else {
						$sqlstr="delete from sales_invoice_subdetail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------delete bincard (credit qty)
						/*$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='cashier' ";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();*/
						
					}
					
				}
			}
			
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//---closing pos all
	function closing_pos_all(){
		
		$dbpdo = DB::create();
		
		$jmldata = $_POST['jmldata'];
		for($i=0; $i<=$jmldata; $i++) {
			
			//$pilih = $_POST[pilih_.$i];
			
			//if($pilih == 1) {
				$ref 			= 	$_POST[ref_.$i];
				$uid			=	$_SESSION["loginname"];
				$dlu			=	date("Y-m-d H:i:s");
				
				$sqlstr="update sales_invoice set closed=1, closed_uid='$uid', closed_dlu='$dlu' where ref='$ref'";
				$sql=$dbpdo->query($sqlstr);
			//}
			
		}
		
		
		
		return $sql;
	}
	
	
	//-----update order stock
	function update_order_stock($ref){
		$dbpdo = DB::create();
		
		try {
			
			$old_location_id=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
			
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$memo			=	petikreplace($_POST["memo"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//----------update order stock detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					$do_ref 		= $_POST[do_ref_.$i];
					$so_ref 		= $_POST[so_ref_.$i];
								
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					
					$sqlstr = "select ref from order_stock_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update order_stock_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (debit qty)
							$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', debit_qty='$qty', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						
						} else {
							$sqlstr="delete from order_stock_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------delete bincard (debit qty)
							$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
						}
						
						
					} else {
						$line = maxline('order_stock_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into order_stock_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$line')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (debit qty)
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'order_stock', '', '$item_code', '$uom_code', '0', '$qty', '0', '0', '$line', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
			}
			
			
			##if add item
			$item_code 		= $_POST['item_code'];
			$uom_code 		= $_POST['uom_code'];
			$qty 			= numberreplace($_POST['qty']);
						
			if ( !empty($item_code) && !empty($uom_code) && $qty > 0 ) {
				
				$line = maxline('order_stock_detail', 'line', 'ref', $ref, '');
				
				$sqlstr="insert into order_stock_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$line')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();								
				
				//----------insert bincard (debit qty)
				$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'order_stock', '', '$item_code', '$uom_code', '0', '$qty', '0', '0', '$line', '$uid', '$dlu')";			
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			##-------/\---------------------
			
			
			$sqlstr="update order_stock set date='$date', memo='$memo', location_id='$location_id', uid='$uid', dlu='$dlu' where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
				
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//-----update_pos_request_void
	function update_pos_request_void($ref){
		$dbpdo = DB::create();
		
		try {
		
			$old_location_id	=	(empty($_POST["old_location_id"])) ? 0 : $_POST["old_location_id"];
			
			$client_member_code	=	$_POST["client_member_code"];
			if($client_member_code == "") {
				$client_member_code2	=	$_POST["client_member_code2"];
				$sqlcln = "select syscode from client where rtrim(ltrim(code))='$client_member_code2' ";
				$sql=$dbpdo->prepare($sqlcln);
				$sql->execute();
				$data   = $sql->fetch(PDO::FETCH_OBJ);
				$client_member_code = $data->syscode;
			}
			
			$ref2			= 	$_POST["ref2"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));	
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];		
			//$status			= 	$_POST["status"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
	        $client_code	=	$_POST["client_code2"];
			
			if($taxable == 0) {
				$ref2		= 	"";
			} 
			
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//----------update sales_order detail
			$total_amount	=	0;
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$delete 		= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_item_code	 	= $_POST[old_item_code_.$i];
				$old_uom_code 		= $_POST[old_uom_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$item_code	 	= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				if ( !empty($item_code) && !empty($uom_code) ) {	
					$do_ref 		= $_POST[do_ref_.$i];
					$so_ref 		= $_POST[so_ref_.$i];
								
					$qty 		= numberreplace($_POST[qty_.$i]);
					$old_qty	= numberreplace($_POST[old_qty_.$i]);
					$unit_price	= numberreplace($_POST[unit_price_.$i]);
					$unit_price2 = numberreplace($_POST[unit_price2_.$i]);
					//$discount	= numberreplace($_POST[discount_.$i]);
	                $discount3 	= numberreplace($_POST[discount3_.$i]);
	                $amount 	= numberreplace($_POST[amount_.$i]);
					$amount2 	= numberreplace($_POST[amount2_.$i]);
					$dummy 		= (empty($_POST[dummy_.$i])) ? 0 : $_POST[dummy_.$i]; //$_POST[dummy_.$i];
					$non_discount = (empty($_POST[non_discount_.$i])) ? 0 : $_POST[non_discount_.$i];
					$request_void = (empty($_POST[request_void_.$i])) ? 0 : $_POST[request_void_.$i];
					
					$discount	= ($unit_price * $discount3)/100;
					
					$line_item_do	= $_POST[line_item_do_.$i];
					$line_item_so	= $_POST[line_item_so_.$i];
					
					$sqlstr = "select ref from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					$num = $sql->rowCount();
					
					if($num > 0) {
						if($delete == 0) {
							$sqlstr="update sales_invoice_detail set item_code='$item_code', uom_code='$uom_code', qty='$qty', unit_price='$unit_price', unit_price2='$unit_price2', discount='$discount', discount3='$discount3', amount='$amount', amount2='$amount2', dummy='$dummy', request_void='$request_void' where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------update bincard (credit qty)
							/*$sqlstr="update bincard set location_code='$location_id', date='$date', item_code='$item_code', uom_code='$uom_code', unit_price='$unit_price', credit_qty='$qty', amount='$amount', uid='$uid', dlu='$dlu' where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='cashier' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------AUDIT TRAIL bincard (update)
							$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$old_line', '$uid', '$dlu', 'update')";				
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();*/
							
							$total_amount	=	$total_amount + $amount;
							
						
						} else {
							//delete diganti void (harga, qty, amount dinolkan)
							/*$sqlstr="delete from sales_invoice_detail where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line='$old_line' ";*/
							
							$sqlstr="update sales_invoice_detail set qty='0', unit_price='0', unit_price2='0', discount='0', discount3='0', amount='0', amount2='0', note='void', request_void=0 where ref='$ref' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							//----------delete bincard (credit qty)
							/*$sqlstr="delete from bincard where invoice_no='$ref' and location_code='$old_location_id' and item_code='$old_item_code' and uom_code='$old_uom_code' and line=$old_line and invoice_type='pos' ";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
							
							
							$sqlstr="insert into adt_sales_invoice_detail (ref, item_code, uom_code, qty, end_date_discount, discount, discount2, discount3, unit_price, amount, qty_discount, non_discount, discount_percent_tmp, line, ref_near_expired, adt_status) values ('$ref', '$item_code', '$uom_code', '$qty', '$end_date_discount', '$discount', '$discount2', '$discount3', '$unit_price', '$amount', '$qty_discount', '$non_discount', '$discount_percent_tmp', '$line', '$ref_near_expired', 'void')";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();*/	
							
							//----------AUDIT TRAIL bincard (delete)
							/*$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$old_location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$old_line', '$uid', '$dlu', 'delete')";			
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();*/
							
						}
						
						
					} else {
						$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');
						
						$sqlstr="insert into sales_invoice_detail (ref, do_ref, so_ref, item_code, uom_code, qty, discount, discount3, unit_price, unit_price2, amount, amount2, dummy, non_discount, line_item_do, line_item_so, line) values ('$ref', '$do_ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$discount', '$discount3', '$unit_price', '$unit_price2', '$amount', '$amount2', '$dummy', '$non_discount', '$line_item_do', '$line_item_so', $line)";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------insert bincard (debit qty)
						$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
						
						//----------AUDIT TRAIL bincard (insert)
						/*$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu', 'insert')";					
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();*/
						
						$total_amount	=	$total_amount + $amount;
						
					}
					
					
					//----------insert/update set_item_price (ditutup krn harga di seting di set item price aja)
					/*
					$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
					$resultprice = mysql_query($sqlprice);
					$numprice = mysql_num_rows($resultprice);
					
					if($numprice == 0) {
						$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
						$resultprice2 = mysql_query($sqlprice2);
						$dataprice = mysql_fetch_object($resultprice2);
					
						$last_price			=	$dataprice->current_price;
						$date_of_record		=	date("Y-m-d H:i:s");
						
						$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$uid', '$dlu')";				
						$sql=$dbpdo->prepare($sqlstr);
					}	*/
					//------------------------------------/\
					
					
				}
			}
			
			//get total detail
			$sqlstr="select sum(amount) total from sales_invoice_detail where ref='$ref' group by ref";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$data_tot = $sql->fetch(PDO::FETCH_OBJ);
			$__total = $data_tot->total;
			
						
			$cash				=	$_POST["cash"];
			$employee_id		= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$ship_to			=	$_POST["ship_to"];
			$bill_to			=	$_POST["bill_to"];
			$top				=	$_POST["top"];
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$discount2			=	numberreplace($_POST["discount"]);
			$total				=	$__total; //numberreplace($_POST["total"]); //$sub_total; 			
			$deposit			=	numberreplace($_POST["deposit"]);
			$photo_file			=	"";
			
			if($__total == 0) {
				$cash_amount		=	0;
			} else {
				$cash_amount		=	numberreplace($_POST["cash_amount"]);	
			}
			
			$ovo				=	numberreplace($_POST["ovo"]);
			$gopay				=	numberreplace($_POST["gopay"]);
			$cash_voucher		=	numberreplace($_POST["cash_voucher"]);
			$bank_id			=	(empty($_POST["bank_id"])) ? 0 : $_POST["bank_id"];
			$bank_amount		=	numberreplace($_POST["bank_amount1"]);
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$card_amount		=	numberreplace($_POST["card_amount"]);
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_holder	=	petikreplace($_POST["credit_card_holder"]);
			$change_amount		=	numberreplace($_POST["change_amount"]);
			$shift				=	$_POST["shift"];
			$void				=	(empty($_POST["void"])) ? 0 : $_POST["void"];
			
			$insert_void = "";
			if($void == 1) {
				$insert_void = ", void_uid='$uid', void_dlu='$dlu' ";
			}
			
			$sqlstr="update sales_invoice set ref2='$ref2', date='$date', client_code='$client_code', top='$top', due_date='$due_date', ship_to='$ship_to', bill_to='$bill_to', taxable='$taxable', tax_code='$tax_code', tax_rate='$tax_rate', freight_cost='$freight_cost', freight_account='$freight_account', currency_code='$currency_code', rate='$rate', employee_id='$employee_id', discount='$discount2', total='$total', memo='$memo', location_id='$location_id', deposit='$deposit', photo_file='$photo_file', cash_amount='$cash_amount', cash_voucher='$cash_voucher', ovo='$ovo', gopay='$gopay', bank_id='$bank_id', bank_amount='$bank_amount', credit_card_code='$credit_card_code', card_amount='$card_amount', credit_card_no='$credit_card_no', credit_card_holder='$credit_card_holder', change_amount='$change_amount', shift='$shift', client_member_code='$client_member_code', void='$void', upd_uid='$uid', upd_dlu='$dlu' ".$insert_void." where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			/*---------insert audit trail (update)------------*/
			$cash	=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			/*$sqlstr="insert into adt_sales_invoice (ref, ref2, date, status, top, due_date, client_code, ship_to, bill_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, discount, total, memo, opening_balance, cash, location_id, deposit, taxable, photo_file, cash_amount, cash_voucher, bank_id, bank_amount, credit_card_code, card_amount, credit_card_no, credit_card_holder, change_amount, shift, client_member_code, uid, dlu, adt_status) values('$ref', '$ref2', '$date', 'R', '$top', '$due_date', '$client_code', '$ship_to', '$bill_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$discount2', '$total', '$memo', 0, '$cash', '$location_id', '$deposit', '$taxable', '$photo_file', '$cash_amount', '$cash_voucher', '$bank_id', '$bank_amount', '$credit_card_code', '$card_amount', '$credit_card_no', '$credit_card_holder', '$change_amount', '$shift', '$client_member_code', '$uid', '$dlu', 'update')";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();*/
			
			
            ##jika piutang
            if($cash == 0) {
				
				$total = $total - $deposit;
				
				//update AR
				$sqlstr="update ar set date='$date', contact_code='$client_code', due_date='$due_date', debit_amount='$total', top='$top', description='$memo', uid='$uid', dlu='$dlu' where ref='$ref' and invoice_type='cashier' and ref_type='pos' ";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();	
			}
            //---------
            
			if($bank_amount > 0) {
				
				$sqlbnk = "select name, account_code, account_coa from bank where id='$bank_id' ";
				$sql=$dbpdo->prepare($sqlbnk);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_OBJ);
				
				$cheque_no		= $data->account_code;
				$bank_name		= $data->name;
				$receipt_type	= "transfer";
				$cheque_date	= $date;
				$total			= $bank_amount;
				$account_code	= $data->account_coa;
				
				//insert ARC
				$sqlstr = "select ref from arc where ref='$ref' and type='$receipt_type'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				
				if($rows > 0) {
					$sqlstr="update arc set date='$date', client_code='$client_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr="insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}								
				
			}
			
			if($card_amount > 0) {
				
				$sqlbnk = "select name, account_code from credit_card_type where code='$credit_card_code' ";
				$sql=$dbpdo->prepare($sqlbnk);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_OBJ);
								
				$cheque_no		= $credit_card_no;
				$bank_name		= $data->name;
				$receipt_type	= "card";
				$cheque_date	= $date;
				$total			= $card_amount;
				$account_code	= $data->account_code;
				
				//insert ARC
				$sqlstr = "select ref from arc where ref='$ref' and type='$receipt_type'";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				
				if($rows > 0) {
					$sqlstr="update arc set date='$date', client_code='$client_code', cheque_no='$cheque_no', bank_name='$bank_name', cheque_date='$cheque_date', amount='$total', currency_code='$currency_code', rate='$rate', account_code='$account_code', memo='$memo', uid='$uid', dlu='$dlu' where type='$receipt_type' and ref='$ref'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr="insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}					
						
				
			}
			
			
			##member only
			$sqlstr="delete from sales_invoice_point where ref='$ref'";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			if($total > 0 && $client_member_code != "") {
				$point				=	floor($total/50000);
				$cleared			=	0;
				
				$sqlstr="insert into sales_invoice_point (ref, date, client_code, point, cleared) values('$ref', '$date', '$client_member_code', '$point', '$cleared')";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();	
			}
				
			
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	//---approval_pos_overlimit
	function approval_pos_overlimit(){
		
		$dbpdo = DB::create();
		
		$uid	=	$_SESSION["loginname"];	
		$jmldata = $_POST['jmldata'];
		for($i=0; $i<=$jmldata; $i++) {
			
			$pilih = $_POST[pilih_.$i];
			
			if($pilih == 1) {
				$ref 			= 	$_POST[ref_.$i];
				
				$sqlstr="update sales_invoice_tmp set limit_approved=1, upd_approved_over='$uid' where ref='$ref'";
				$sql=$dbpdo->query($sqlstr);
			}
			
		}
		
		
		
		return $sql;
	}
	
			
}

?>
