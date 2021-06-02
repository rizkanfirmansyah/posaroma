<?php

class insert
{

	//------insert user
	function insert_usr($ref, $photo)
	{
		$dbpdo = DB::create();

		try {

			$usrid		=	$_POST["usrid"];
			$old_usrid	=	$_POST["old_usrid"];
			$pass_ori	=	$_POST["pwd"];
			$pwd		=	obraxabrix($pass_ori, $usrid);

			$adm		=	(empty($_POST["adm"])) ? 0 : $_POST["adm"];
			$employee_id =	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];

			//-----------upload file
			$photo2				= $_POST["photo2"];
			$uploaddir_photo 	= 'app/photo_usr/';
			$photo				= $_FILES['photo']['name'];
			$tmpname_photo 		= $_FILES['photo']['tmp_name'];
			$filesize_photo 	= $_FILES['photo']['size'];
			$filetype_photo 	= $_FILES['photo']['type'];

			if (empty($photo)) {
				$photo = $photo2;
			} else {
				$photo = $photo;
			}

			if ($photo != "") {
				$photo = $usrid . '_' . $photo;
				$uploaddir_photo = $uploaddir_photo . $photo;
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir_photo)) {
					echo "";
				}
			}
			//----------------

			$uid		=	$_SESSION["loginname"];
			$dlu		=	date("Y-m-d H:i:s");
			$act		=	(empty($_POST["act"])) ? 0 : $_POST["act"];

			$sqlstr = "insert into usr(usrid,pwd,adm,employee_id,photo,act,uid,dlu) values('$usrid','$pwd','$adm','$employee_id','$photo','$act','$uid','$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert user detail
			$usr_jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 1; $i <= $usr_jmldata; $i++) {
				$usr_slc = (empty($_POST[usr_slc_ . $i])) ? 0 : $_POST[usr_slc_ . $i];

				if ($usr_slc == 1) {
					$usr_frmcde = $_POST[usr_frmcde_ . $i];
					$usr_add = (empty($_POST[usr_add_ . $i])) ? 0 : $_POST[usr_add_ . $i];
					$usr_edt = (empty($_POST[usr_edt_ . $i])) ? 0 : $_POST[usr_edt_ . $i];
					$usr_dlt = (empty($_POST[usr_dlt_ . $i])) ? 0 : $_POST[usr_dlt_ . $i];
					$usr_lvl = (empty($_POST[usr_lvl_ . $i])) ? 0 : $_POST[usr_lvl_ . $i];

					$sqlstr = "insert into usr_dtl
					(usrid, frmcde, madd, medt, mdel, lvl)
						values
						(
							'" . $usrid . "',
							'" . $usr_frmcde . "',
							" . $usr_add . ",
							" . $usr_edt . ",
							" . $usr_dlt . ",
							'" . $usr_lvl . "'
						)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}

			//--------insert table user backup
			$sqlstr = "insert into usr_bup(usrid,pwd) values('$usrid','$_POST[pwd]')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert company
	function insert_company()
	{
		$dbpdo = DB::create();

		try {

			$name			=	petikreplace($_POST["name"]);
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

			$sqlstr = "insert into company(name, businiss_type, address1, address2, phone1, phone2, fax, city, country, web, email, active, uid, dlu) values('$name', '$businiss_type', '$address1', '$address2', '$phone1', '$phone2', '$fax', '$city', '$country', '$web', '$email', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert position
	function insert_position()
	{
		$dbpdo = DB::create();

		try {

			$name			=	petikreplace($_POST["name"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into position (name, active, uid, dlu) values ('$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert department
	function insert_department()
	{
		$dbpdo = DB::create();

		try {

			$name			=	petikreplace($_POST["name"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into department (name, active, uid, dlu) values('$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert division
	function insert_division()
	{
		$dbpdo = DB::create();

		try {

			$name			=	petikreplace($_POST["name"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into division (name, active, uid, dlu) values('$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert employee
	function insert_employee()
	{
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
			$photo2				= $_POST["photo2"];
			$uploaddir_photo 	= 'app/photo_employee/';
			$photo				= $_FILES['photo']['name'];
			$tmpname_photo 		= $_FILES['photo']['tmp_name'];
			$filesize_photo 	= $_FILES['photo']['size'];
			$filetype_photo 	= $_FILES['photo']['type'];

			if (empty($photo)) {
				$photo = $photo2;
			} else {
				$photo = $photo;
			}

			if ($photo != "") {
				$photo = $code . '_' . $photo;
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

			$sqlstr = "insert into employee (code, name, nick_name, born, birth_date, marital_status, religion_id, address, zip_code, country_id, state_id, phone, email, photo, position_id, department_id, division_id, location_id, active, uid, dlu) values('$code', '$name', '$nick_name', '$born', '$birth_date', '$marital_status', '$religion_id', '$address', '$zip_code', '$country_id', '$state_id', '$phone', '$email', '$photo', '$position_id', '$department_id', '$division_id', '$location_id', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert coa
	function insert_coa()
	{
		$dbpdo = DB::create();

		try {

			$acc_code			=	$_POST["acc_code"];
			$name				=	$_POST["name"];
			$acc_type			=	(empty($_POST["acc_type"])) ? 0 : $_POST["acc_type"];
			$postable			=	(empty($_POST["postable"])) ? 0 : $_POST["postable"];
			$subacc_code		=	$_POST["subacc_code"];
			$opening_balance	=	(empty($_POST["opening_balance"])) ? 0 : $_POST["opening_balance"];
			$opening_balance_date	= date("Y-m-d", strtotime($_POST["opening_balance_date"]));
			$current_balance	=	$opening_balance; //(empty($_POST["current_balance"])) ? 0 : $_POST["current_balance"];

			$currency_code		=	(empty($_POST["currency_code"])) ? 0 : $_POST["currency_code"];
			$currency_rate		=	(empty($_POST["currency_rate"])) ? 0 : $_POST["currency_rate"];
			$currency_exchange_id		=	(empty($_POST["currency_exchange_id"])) ? 0 : $_POST["currency_exchange_id"];
			$level			=	(empty($_POST["level"])) ? 0 : $_POST["level"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			$syscode		= 	random(20);

			$sqlstr = "insert into coa (acc_code, name, acc_type, postable, subacc_code, opening_balance, opening_balance_date, current_balance, currency_code, currency_rate, currency_exchange_id, level, active, uid, dlu, syscode) values('$acc_code', '$name', '$acc_type', '$postable', '$subacc_code', '$opening_balance', '$opening_balance_date', '$current_balance', '$currency_code', '$currency_rate', '$currency_exchange_id', '$level', '$active', '$uid', '$dlu', '$syscode')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert item type
	function insert_item_type()
	{
		$dbpdo = DB::create();

		try {

			$code			=	$_POST["code"];
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];

			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			$syscode		= 	random(9);


			//----------insert detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			for ($i = 0; $i <= $jmldata; $i++) {

				$inventory_acccode		=	$_POST[inventory_acccode_ . $i];
				$productcost_acccode	=	$_POST[productcost_acccode_ . $i];
				$goodintransit_acccode	=	$_POST[goodintransit_acccode_ . $i];
				$workinprocess_acccode	=	$_POST[workinprocess_acccode_ . $i];
				$cogs_acccode			=	$_POST[cogs_acccode_ . $i];
				$location_id			=	(empty($_POST[location_id_ . $i])) ? 0 : $_POST[location_id_ . $i];


				if (!empty($location_id) || ($location_id <> 0)) {

					$syscode2	= 	random(9);

					$line = maxline('item_type_detail', 'line', 'syscode_header', $syscode, '');

					$sqlstr = "insert into item_type_detail (code, syscode_header, inventory_acccode, productcost_acccode, goodintransit_acccode, workinprocess_acccode, cogs_acccode, location_id, line, syscode) values ('$code', '$syscode', '$inventory_acccode', '$productcost_acccode', '$goodintransit_acccode', '$workinprocess_acccode', '$cogs_acccode', '$location_id', '$line', '$syscode2')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}

			$sqlstr = "insert into item_type (code, name, inventory_acccode, productcost_acccode, goodintransit_acccode, workinprocess_acccode, cogs_acccode, location_id, active, uid, dlu, syscode) values('$code', '$name', '$inventory_acccode', '$productcost_acccode', '$goodintransit_acccode', '$workinprocess_acccode', '$cogs_acccode', '$location_id', '$active', '$uid', '$dlu', '$syscode')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert uom
	function insert_uom()
	{
		$dbpdo = DB::create();

		try {

			$code			=	$_POST["code"];
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into uom (code, name, active, uid, dlu) values('$code', '$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert item group
	function insert_item_group()
	{
		$dbpdo = DB::create();

		try {

			$code					=	$_POST["code"];
			$name					=	$_POST["name"];
			$costing_type			=	$_POST["costing_type"];
			$nonstock				=	(empty($_POST["nonstock"])) ? 0 : $_POST["nonstock"];

			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into item_group (code, name, nonstock, costing_type, inventory_acccode, purchase_discount_acccode, goodintransit_acccode, workinprocess_acccode, cogs_acccode, consignment_acccode, location_id, active, uid, dlu) values('$code', '$name', '$nonstock', '$costing_type', '$inventory_acccode', '$purchase_discount_acccode', '$goodintransit_acccode', '$workinprocess_acccode', '$cogs_acccode', '$consignment_acccode', '$location_id', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//-------get last ID
			$sqlid 		= "select last_insert_id() lastid";
			$resultid = $dbpdo->prepare($sqlid);
			$resultid->execute();
			$dataid		= $resultid->fetch(PDO::FETCH_OBJ);

			$lastid		= $dataid->lastid;
			//-------------------/\


			/*---------insert audit trail (insert)------------*/
			$sqlstr = "insert into adt_item_group (id, code, name, nonstock, costing_type, inventory_acccode, purchase_discount_acccode, goodintransit_acccode, workinprocess_acccode, cogs_acccode, consignment_acccode, location_id, active, uid, dlu, adt_status) values('$lastid', '$code', '$name', '$nonstock', '$costing_type', '$inventory_acccode', '$purchase_discount_acccode', '$goodintransit_acccode', '$workinprocess_acccode', '$cogs_acccode', '$consignment_acccode', '$location_id', '$active', '$uid', '$dlu', 'insert')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();


			//----------insert detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			for ($i = 0; $i <= $jmldata; $i++) {

				$inventory_acccode		=	$_POST[inventory_acccode_ . $i];
				$purchase_discount_acccode	=	$_POST[purchase_discount_acccode_ . $i];
				$goodintransit_acccode	=	$_POST[goodintransit_acccode_ . $i];
				$workinprocess_acccode	=	$_POST[workinprocess_acccode_ . $i];
				$cogs_acccode			=	$_POST[cogs_acccode_ . $i];
				$consignment_acccode	=	$_POST[consignment_acccode_ . $i];
				$location_id	=	(empty($_POST[location_id_ . $i])) ? 0 : $_POST[location_id_ . $i];


				if (!empty($location_id) || ($location_id <> 0)) {

					$syscode2	= 	random(9);

					$line = maxline('item_group_detail', 'line', 'id_header', $syscode, '');

					$sqlstr = "insert into item_group_detail (id_header, inventory_acccode, purchase_discount_acccode, goodintransit_acccode, workinprocess_acccode, cogs_acccode, consignment_acccode, location_id, line) values ('$lastid', '$inventory_acccode', '$purchase_discount_acccode', '$goodintransit_acccode', '$workinprocess_acccode', '$cogs_acccode', '$consignment_acccode', '$location_id', '$line')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}


		return $sql;
	}

	//-----insert item subgroup
	function insert_item_subgroup()
	{
		$dbpdo = DB::create();

		try {

			$name			=	$_POST["name"];
			$item_group_id	=	(empty($_POST["item_group_id"])) ? 0 : $_POST["item_group_id"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into item_subgroup (name, item_group_id, active, uid, dlu) values('$name', '$item_group_id', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert reason to adjust
	function insert_reason_adjust()
	{
		$dbpdo = DB::create();

		try {

			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into reason_adjust (name, active, uid, dlu) values('$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert warehouse
	function insert_warehouse()
	{
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

			$sqlstr = "insert into warehouse (code, name, address, email, phone, active, uid, dlu) values('$code', '$name', '$address', '$email', '$phone', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert uom conversion
	function insert_uom_conversion()
	{
		$dbpdo = DB::create();

		try {

			$uom_code1		=	$_POST["uom_code1"];
			$uom_code2		=	$_POST["uom_code2"];
			$conversion		=	$_POST["conversion"];
			$factor			=	numberreplace($_POST["factor"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			$syscode		= 	random(9);

			$sqlstr = "insert into uom_conversion (uom_code1, uom_code2, conversion, factor, uid, dlu, syscode) values('$uom_code1', '$uom_code2', '$conversion', '$factor', '$uid', '$dlu', '$syscode')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert colour
	function insert_colour()
	{
		$dbpdo = DB::create();

		try {

			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into colour (name, active, uid, dlu) values ('$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert brand
	function insert_brand()
	{
		$dbpdo = DB::create();

		try {

			$code			=	$_POST["code"];
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into brand (code, name, active, uid, dlu) values ('$code', '$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert size
	function insert_size()
	{
		$dbpdo = DB::create();

		try {

			$code			=	$_POST["code"];
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into size (code, name, active, uid, dlu) values ('$code', '$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert item category
	function insert_item_category()
	{
		$dbpdo = DB::create();

		try {

			$code			=	$_POST["code"];
			$name			=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into item_category (code, name, active, uid, dlu) values ('$code', '$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert item
	function insert_item()
	{
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
			$size_id			= 	$_POST["size_id"];  //	(empty($_POST["size_id"])) ? 0 : $_POST["size_id"];
			$uom_code_stock		=	$_POST["uom_code_stock"];
			$uom_code_sales		=	$_POST["uom_code_sales"];
			$uom_code_purchase	=	$_POST["uom_code_purchase"];
			$minimum_stock		=	numberreplace((empty($_POST["minimum_stock"])) ? 0 : $_POST["minimum_stock"]);
			$maximum_stock		=	numberreplace((empty($_POST["maximum_stock"])) ? 0 : $_POST["maximum_stock"]);

			$consigned		=	(empty($_POST["consigned"])) ? 0 : $_POST["consigned"];

			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			$syscode		= 	random(9);

			//-----------upload file
			$photo2				= $_POST["photo2"];
			$uploaddir_photo 	= 'app/photo_item/';
			$photo				= $_FILES['photo']['name'];
			$tmpname_photo 		= $_FILES['photo']['tmp_name'];
			$filesize_photo 	= $_FILES['photo']['size'];
			$filetype_photo 	= $_FILES['photo']['type'];

			if (empty($photo)) {
				$photo = $photo2;
			} else {
				$photo = $photo;
			}

			if ($photo != "") {
				$photo = $syscode . '_' . $photo;
				$uploaddir_photo = $uploaddir_photo . $photo;
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir_photo)) {
					echo "";
				}
			}
			//----------------
			$sqlstr = "insert into item (code, old_code, name, item_group_id, item_subgroup_id, item_type_code, item_category_id, brand_id, size_id, uom_code_stock, uom_code_sales, uom_code_purchase, minimum_stock, maximum_stock, photo, consigned, active, uid, dlu, syscode) values ('$code', '$old_code', '$name', '$item_group_id', '$item_subgroup_id', '$item_type_code', '$item_category_id', '$brand_id', '$size_id', '$uom_code_stock', '$uom_code_sales', '$uom_code_purchase', '$minimum_stock', '$maximum_stock', '$photo', '$consigned', '$active', '$uid', '$dlu', '$syscode')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			/*---------insert audit trail (insert)------------*/
			$sqlstr = "insert into adt_item (code, old_code, name, item_group_id, item_subgroup_id, item_type_code, item_category_id, brand_id, size_id, uom_code_stock, uom_code_sales, uom_code_purchase, minimum_stock, maximum_stock, photo, consigned, active, uid, dlu, syscode, adt_status) values ('$code', '$old_code', '$name', '$item_group_id', '$item_subgroup_id', '$item_type_code', '$item_category_id', '$brand_id', '$size_id', '$uom_code_stock', '$uom_code_sales', '$uom_code_purchase', '$minimum_stock', '$maximum_stock', '$photo', '$consigned', '$active', '$uid', '$dlu', '$syscode', 'insert' )";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();


			##execute otomatis number
			$sqlstr = "select a.code from item_group a where a.id='$item_group_id'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);

			notran($date, 'frmitembarcode', 1, '', $data->code);


			#insert/update set item cost
			$item_code	=	$syscode;
			$uom_code	=	$uom_code_purchase;
			$current_cost	=	numberreplace($_POST['current_cost']);
			$date_cost		=	date("Y-m-d", strtotime($_POST['date_cost']));
			$efective_from_cost	=	date("Y-m-d", strtotime($_POST['efective_from_cost']));

			if ($date_cost == "1970-01-01") {
				$date_cost = date("Y-m-d");
			}

			if ($efective_from_cost == "1970-01-01") {
				$efective_from_cost = date("Y-m-d");
			}


			$date_of_record	=	date("Y-m-d H:i:s");
			$location_id_cost	=	$_POST['location_id_cost'];

			$sqlstr = "select item_code, current_cost from set_item_cost where item_code='$item_code' and uom_code='$uom_code' and current_cost='$current_cost'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows = $sql->rowCount();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$last_cost = $data->current_cost;

			if ($rows == 0) {
				$sqlstr = "insert into set_item_cost (date, efective_from, item_code, uom_code, current_cost, last_cost, date_of_record, location_id, uid, dlu) values('$date_cost', '$efective_from_cost', '$item_code', '$uom_code', '$current_cost', '$last_cost', '$date_of_record', '$location_id_cost', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				$sqlstr = "update set_item_cost set efective_from='$efective_from_cost', uom_code='$uom_code', current_cost='$current_cost', last_cost='$last_cost', date_of_record='$date_of_record', location_id='$location_id_cost', uid='$uid', dlu='$dlu' where item_code='$item_code' and uom_code='$uom_code'";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}


			#insert/update set item price
			$item_code	=	$syscode;
			$uom_code	=	$uom_code_sales;
			$current_price	=	numberreplace($_POST['current_price']);
			$current_price1	=	numberreplace($_POST['current_price1']);
			$current_price2	=	numberreplace($_POST['current_price2']);
			$current_price3	=	numberreplace($_POST['current_price3']);
			$date			=	date("Y-m-d", strtotime($_POST['date']));
			if ($date == "1970-01-01") {
				$date = date("Y-m-d");
			}
			$efective_from	=	date("Y-m-d", strtotime($_POST['efective_from']));
			if ($efective_from == "1970-01-01") {
				$efective_from = date("Y-m-d");
			}
			$date_of_record	=	date("Y-m-d H:i:s");
			$location_id	=	$_POST['location_id'];
			$non_discount	=	$_POST['non_discount'];
			$qty1			=	numberreplace($_POST['qty1']);
			$qty2			=	numberreplace($_POST['qty2']);
			$qty3			=	numberreplace($_POST['qty3']);
			$qty4			=	numberreplace($_POST['qty4']);

			$sqlstr = "select item_code, current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$current_price'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows = $sql->rowCount();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$last_price = $data->current_price;

			if ($rows == 0) {
				$sqlstr = "insert into set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				//audit trail insert
				$sqlstr = "insert into adt_set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu, adt_status) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu', 'insert')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				$sqlstr = "update set_item_price set efective_from='$efective_from', uom_code='$uom_code', current_price='$current_price', current_price1='$current_price1', current_price2='$current_price2', current_price3='$current_price3', last_price='$last_price', date_of_record='$date_of_record', location_id='$location_id', non_discount='$non_discount', qty1='$qty1', qty2='$qty2', qty3='$qty3', qty4='$qty4', uid='$uid', dlu='$dlu' where item_code='$item_code' and uom_code='$uom_code'";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				//update audit trail
				$sqlstr = "insert into adt_set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu, adt_status) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu', 'update')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert item conversion
	function insert_item_conversion()
	{
		$dbpdo = DB::create();

		try {

			$item_code		= 	$_POST["item_code"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");



			//"set @@autocommit:=0");
			//select @@autocommit;


			$sqlstr = "insert into item_conversion (item_code, uid, dlu) values('$item_code', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item conversion detail
			$usr_jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $usr_jmldata; $i++) {
				$uom_code1 = $_POST[uom_code1_ . $i];
				$uom_code2 = $_POST[uom_code2_ . $i];

				if (!empty($uom_code1) && !empty($uom_code2)) {
					$conversion = $_POST[conversion_ . $i];
					$factor = numberreplace($_POST[factor_ . $i]);
					$constant = (empty($_POST[constant_ . $i])) ? 0 : $_POST[constant_ . $i];

					$sqlstr = "insert into item_conversion_detail
					(item_code, uom_code1, uom_code2, conversion, factor, constant, line)
						values
						(
							'" . $item_code . "',
							'" . $uom_code1 . "',
							'" . $uom_code2 . "',
							'" . $conversion . "',
							'" . $factor . "',
							'" . $constant . "',
							'" . $i . "'
						)";

					$sql = $dbpdo->prepare($sql2);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert item packing
	function insert_item_packing($ref)
	{
		$dbpdo = DB::create();

		try {

			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$status			= 	$_POST["status"];
			$warehouse_id	=	(empty($_POST["warehouse_id"])) ? 0 : $_POST["warehouse_id"];
			$item_code		= 	$_POST["item_code"];
			$uom_code		= 	$_POST["uom_code"];
			$qty			= numberreplace($_POST["qty"]);
			$unit_price		= numberreplace($_POST["unit_price"]);
			$expired_date	=	date("Y-m-d", strtotime($_POST["expired_date"]));

			$week_wage_ref	= 	$_POST["week_wage_ref"];
			$week_wage_total = numberreplace($_POST["week_wage_total"]);

			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");





			$sqlstr = "insert into item_packing (ref, date, status, warehouse_id, item_code, uom_code, qty, unit_price, week_wage_ref, week_wage_total, uid, dlu) values('$ref', '$date', '$status', '$warehouse_id', '$item_code', '$uom_code', '$qty', '$unit_price', '$week_wage_ref', '$week_wage_total', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert bincard (debit qty)
			$amount = $unit_price * $qty;
			$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id', '$date', 'packing', '', '$item_code', '$uom_code', '$unit_price', '$qty', 0, '$amount', 0, '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//-----------update week_wage (ref repacking)
			$sqlstr = "update week_wage set packing_ref='$ref' where ref='$week_wage_ref' ";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();


			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$warehouse_id2 	= (empty($_POST[warehouse_id_ . $i])) ? 0 : $_POST[warehouse_id_ . $i];
				$item_code2 		= $_POST[item_code_ . $i];
				$uom_code2 		= $_POST[uom_code_ . $i];

				if (!empty($item_code2) && !empty($uom_code2) && !empty($warehouse_id2)) {
					$qty2 			= numberreplace($_POST[qty_ . $i]);
					$unit_price2	= numberreplace($_POST[unit_price_ . $i]);
					$amount			= numberreplace($_POST[amount_ . $i]);

					$line = maxline('item_packing_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into item_packing_detail (ref, item_code, uom_code, warehouse_id, qty, unit_price, amount, line) values ('$ref', '$item_code2', '$uom_code2', '$warehouse_id2', '$qty2', '$unit_price2', '$amount', $line)";

					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					//----------insert bincard (credit qty)
					$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id2', '$date', 'packing', '', '$item_code2', '$uom_code2', '$unit_price2', 0, '$qty2', '$amount', '$line', '$uid', '$dlu')";

					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert inbound
	function insert_inbound($ref)
	{
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




			$sqlstr = "insert into inbound (ref, date, status, type, reason, purchase_invoice, warehouse_id_from, warehouse_id_to, received_by, uid, dlu) values('$ref', '$date', '$status', '$type', '$reason', '$purchase_invoice', '$warehouse_id_from', '$warehouse_id_to', '$uid', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty 			= numberreplace($_POST[qty_ . $i]);

					$line = maxline('inbound_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into inbound_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					//----------insert bincard (credit qty) ======>FROM
					$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id_from', '$date', 'inbound', '$reason', '$item_code', '$uom_code', 0, 0, '$qty', 0, '$line', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					//----------insert bincard (debit qty)  ========>TO
					$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id_to', '$date', 'inbound', '$reason', '$item_code', '$uom_code', 0, '$qty', 0, 0, '$line', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert outbound
	function insert_outbound($ref, $ref_detail)
	{
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




			$sqlstr = "insert into outbound (ref, date, status, type, reason, form_no, warehouse_id_from, warehouse_id_to, employee_id, employee_id2, uid, dlu) values('$ref', '$date', '$status', '$type', '$reason', '$form_no', '$warehouse_id_from', '$warehouse_id_to', '$employee_id', '$employee_id2', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			/*---------insert adt outbound (insert)------------*/
			$sqlstr = "insert into adt_outbound (ref, date, status, type, warehouse_id_from, warehouse_id_to, reason, form_no, employee_id, uid, dlu, adt_status) values ('$ref', '$date', '$status', '$type', '$warehouse_id_from', '$warehouse_id_to', '$reason', '$form_no', '$employee_id', '$uid', '$dlu', 'insert' )";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty 			= numberreplace($_POST[qty_ . $i]);

					$line = maxline('outbound_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into outbound_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					/*---------insert adt outbound_detail (insert)------------*/
					$sqlstr = "insert into adt_outbound_detail (ref, item_code, uom_code, qty, line, adt_status) values ('$ref', '$item_code', '$uom_code', '$qty', '$line', 'insert' )";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();


					if ($status == 'C') {
						//----------insert bincard (credit qty) ======>FROM
						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id_from', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, 0, '$qty', 0, '$line', '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						//----------AUDIT TRAIL insert bincard (credit qty)
						$sqlstr = "insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$warehouse_id_from', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, 0, '$qty', 0, '$line', '$uid', '$dlu', 'insert')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
						/*---------end from --------------*/

						//----------insert bincard (debit qty)  ========>TO
						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$warehouse_id_to', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, '$qty', 0, 0, '$line', '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						//----------AUDIT TRAIL insert bincard (debit qty)
						$sqlstr = "insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$warehouse_id_to', '$date', 'outbound', '$reason', '$item_code', '$uom_code', 0, '$qty', 0, 0, '$line', '$uid', '$dlu', 'insert')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
						/*----------end TO--------------*/
					}
				}
			}

			##delete tmp data
			$sqlstr = "delete from outbound_tmp where ref='$ref_detail' and uid='$uid'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert store request
	function insert_store_request($ref)
	{
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




			$sqlstr = "insert into store_request (ref, date, date_need, status, type, priority, warehouse_id_from, warehouse_id_to, reason, memo, uid, dlu) values('$ref', '$date', '$date_need', '$status', '$type', '$priority', '$warehouse_id_from', '$warehouse_id_to', '$reason', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);

					$line = maxline('store_request_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into store_request_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert stock opname
	function insert_stock_opname()
	{
		$dbpdo = DB::create();

		try {

			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$bin				= 	$_POST["bin"];
			if ($bin == "") {
				$bin = "1";
			}
			$uid				=	$_SESSION["loginname"];
			$beginning_balance	= 	(empty($_POST["beginning_balance"])) ? 0 : $_POST["beginning_balance"];
			$memo				= 	$_POST["memo"];
			$dlu				=	date("Y-m-d H:i:s");
			$syscode			=	random(25);

			$sqlcek = "select syscode from stock_opname where date='$date' and location_id='$location_id' and bin='$bin' and uid='$uid' limit 1";
			$sql = $dbpdo->prepare($sqlcek);
			$sql->execute();
			$rows = $sql->rowCount();
			$data = $sql->fetch(PDO::FETCH_OBJ);

			if ($rows == 0) {
				$sqlstr = "insert into stock_opname (date, location_id, bin, uid, beginning_balance, memo, dlu, syscode) values('$date', '$location_id', '$bin', '$uid', '$beginning_balance', '$memo', '$dlu', '$syscode')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				$syscode = $data->syscode;
			}

			//----------insert item  detail
			$item_code 		= $_POST["item_code"];
			$uom_code 		= $_POST["uom_code"];

			if (!empty($item_code) && !empty($uom_code)) {
				$qty = numberreplace($_POST["qty"]);
				$unit_cost = numberreplace($_POST["unit_cost"]);

				$line = maxline('stock_opname_detail', 'line', 'syscode', $syscode, '');

				$sqlstr = "select qty, unit_cost from stock_opname_detail where date='$date' and location_id='$location_id' and bin='$bin' and uid='$uid' and item_code='$item_code' and uom_code='$uom_code' limit 1";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				$data = $sql->fetch(PDO::FETCH_OBJ);

				$ref = $syscode;

				if ($rows == 0) {
					$sqlstr = "insert into stock_opname_detail (date, location_id, bin, uid, item_code, uom_code, line, qty, unit_cost, syscode) values ('$date', '$location_id', '$bin', '$uid', '$item_code', '$uom_code', $line, '$qty', '$unit_cost', '$syscode')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					if ($qty > 0) { //jika plus, maka masuk debit
						$amount = $unit_cost * $qty;

						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'stockopname', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', $line, '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
					} else { //jika minus, maka masuk credit
						$amount = ($unit_cost * $qty) * -1;
						$qty	= $qty * -1;

						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'stockopname', '', '$item_code', '$uom_code', '$unit_cost', '0', '$qty', '$amount', $line, '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
					}
				} else {
					$sqlstr = "update stock_opname_detail set qty=ifnull(qty,0) + $qty, unit_cost='$unit_cost' where date='$date' and location_id='$location_id' and bin='$bin' and uid='$uid' and item_code='$item_code' and uom_code='$uom_code'";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					##bincard update
					$sqlstr = "delete from bincard where invoice_no='$ref' and item_code='$item_code' and uom_code='$uom_code'";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$sqlstr = "select sum(ifnull(qty,0)) qty from stock_opname_detail where syscode='$ref' and item_code='$item_code' and uom_code='$uom_code' group by syscode, item_code, uom_code ";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
					$data = $sql->fetch(PDO::FETCH_OBJ);
					$qty = $data->qty;

					if ($qty > 0) { //jika plus, maka masuk debit
						$amount = $unit_cost * $qty;

						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'stockopname', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', $line, '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
					} else { //jika minus, maka masuk credit
						$amount = ($unit_cost * $qty) * -1;
						$qty	= $qty * -1;

						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'stockopname', '', '$item_code', '$uom_code', '$unit_cost', '0', '$qty', '$amount', $line, '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
					}
				}
			}

			//----------insert item packing detail
			/*$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			for ($i=0; $i<=$jmldata; $i++) {
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
							
				if ( !empty($item_code) && !empty($uom_code) ) {				
					$qty = numberreplace($_POST[qty_.$i]);
					$unit_cost = numberreplace($_POST[unit_cost_.$i]);
					
					$line = maxline('stock_opname_detail', 'line', 'syscode', $syscode, '');
					
					$sqlstr="insert into stock_opname_detail (date, location_id, bin, uid, item_code, uom_code, line, qty, unit_cost, syscode) values ('$date', '$location_id', '$bin', '$uid', '$item_code', '$uom_code', $line, '$qty', '$unit_cost', '$syscode')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
										
				}
			}*/
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert vendor type
	function insert_vendor_type()
	{
		$dbpdo = DB::create();

		try {

			$name				=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into vendor_type (name, pch_account, pch_return_account, pch_discount_account, vendor_deposit_account, currency_account, cheque_payable_account, location_id, active, uid, dlu) values('$name', '$pch_account', '$pch_return_account', '$pch_discount_account', '$vendor_deposit_account', '$currency_account', '$cheque_payable_account', '$location_id', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//-------get last ID
			$sqlid 		= "select last_insert_id() lastid";
			$resultid = $dbpdo->prepare($sqlid);
			$resultid->execute();
			$dataid		= $resultid->fetch(PDO::FETCH_OBJ);

			$lastid		= $dataid->lastid;
			//-------------------/\

			//----------insert detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			for ($i = 0; $i <= $jmldata; $i++) {

				$pch_account		=	$_POST[pch_account_ . $i];
				$pch_cash_account		=	$_POST[pch_cash_account_ . $i];
				$pch_return_account	=	$_POST[pch_return_account_ . $i];
				$pch_discount_account	=	$_POST[pch_discount_account_ . $i];
				$vendor_deposit_account	=	$_POST[vendor_deposit_account_ . $i];
				$currency_account		=	$_POST[currency_account_ . $i];
				$cheque_payable_account	=	$_POST[cheque_payable_account_ . $i];
				$hutang_belum_faktur	=	$_POST[hutang_belum_faktur_ . $i];
				$location_id	=	(empty($_POST[location_id_ . $i])) ? 0 : $_POST[location_id_ . $i];

				if ($location_id > 0) {

					$line = maxline('vendor_type_detail', 'line', 'id_header', $lastid, '');

					$sqlstr = "insert into vendor_type_detail (id_header, pch_account, pch_cash_account, pch_return_account, pch_discount_account, vendor_deposit_account, currency_account, cheque_payable_account, hutang_belum_faktur, location_id, line) values ('$lastid', '$pch_account', '$pch_cash_account', '$pch_return_account', '$pch_discount_account', '$vendor_deposit_account', '$currency_account', '$cheque_payable_account', '$hutang_belum_faktur', '$location_id', '$line')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert vendor
	function insert_vendor()
	{
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
			$syscode		= 	random(9);

			$sqlstr = "insert into vendor (code, name, contact_person, vendor_type, address, zip_code, country_id, state_id, phone, fax, email, web, bank_account, active, uid, dlu, syscode) values ('$code', '$name', '$contact_person', '$vendor_type', '$address', '$zip_code', '$country_id', '$state_id', '$phone', '$fax', '$email', '$web', '$bank_account', '$active', '$uid', '$dlu', '$syscode')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert tax
	function insert_tax()
	{
		$dbpdo = DB::create();

		try {

			$code			=	petikreplace($_POST["code"]);
			$name			=	petikreplace($_POST["name"]);
			$rate			= 	numberreplace($_POST["rate"]);
			$tax_account	=	$_POST["tax_account"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			$syscode		= 	random(9);

			$sqlstr = "insert into tax (code, name, rate, tax_account, active, uid, dlu, syscode) values ('$code', '$name', '$rate', '$tax_account', '$active', '$uid', '$dlu', '$syscode')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert invent adjust
	function insert_invent_adjust($ref)
	{
		$dbpdo = DB::create();

		try {

			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$gl_account			=	$_POST["gl_account"];
			$reason_id			=	(empty($_POST["reason_id"])) ? 0 : $_POST["reason_id"];
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$memo				= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");




			$sqlstr = "insert into invent_adjust (ref, date, status, gl_account, reason_id, location_id, memo, uid, dlu) values('$ref', '$date', '$status', '$gl_account', '$reason_id', '$location_id', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);

					$line = maxline('store_request_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into invent_adjust_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert item issued
	function insert_item_issued($ref)
	{
		$dbpdo = DB::create();

		try {

			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$employee_id		=	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$memo				= 	petikreplace($_POST["memo"]);
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");




			$sqlstr = "insert into item_issued (ref, date, status, employee_id, location_id, memo, uid, dlu) values('$ref', '$date', '$status', '$employee_id', '$location_id', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$account_code	= (empty($_POST[account_code_ . $i])) ? 0 : $_POST[account_code_ . $i];

					$line = maxline('item_issued_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into item_issued_detail (ref, item_code, uom_code, account_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$account_code', '$qty', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert item return
	function insert_item_return($ref)
	{
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




			$sqlstr = "insert into item_return (ref, date, status, item_issued_ref, employee_id, location_id, memo, uid, dlu) values('$ref', '$date', '$status', '$item_issued_ref', '$employee_id', '$location_id', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				$select 		= (empty($_POST[select_ . $i])) ? 0 : $_POST[select_ . $i];
				if (!empty($item_code) && !empty($uom_code) && $select == 1) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$account_code	= (empty($_POST[account_code_ . $i])) ? 0 : $_POST[account_code_ . $i];
					$line_item_issued = (empty($_POST[line_item_issued_ . $i])) ? 0 : $_POST[line_item_issued_ . $i];

					$line = maxline('item_return_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into item_return_detail (ref, item_code, uom_code, account_code, qty, line_item_issued, line) values ('$ref', '$item_code', '$uom_code', '$account_code', '$qty', '$line_item_issued', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert purchase request
	function insert_purchase_request($ref)
	{
		$dbpdo = DB::create();

		try {

			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$employee_id		=	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$reason				= 	$_POST["reason"];
			$memo				= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");




			$sqlstr = "insert into purchase_request (ref, date, status, employee_id, location_id, reason, memo, uid, dlu) values('$ref', '$date', '$status', '$employee_id', '$location_id', '$reason', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);

					$line = maxline('purchase_request_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into purchase_request_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert purchase order
	function insert_purchase_order($ref)
	{
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




			$sqlstr = "insert into purchase_order (ref, date, status, vendor_code, tax_code, tax_rate, freight_cost, freight_account, note, uid, dlu) values('$ref', '$date', '$status', '$vendor_code', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$note', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$pr_ref 		= $_POST[pr_ref_ . $i];
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_cost = numberreplace($_POST[unit_cost_ . $i]);
					$amount = numberreplace($_POST[amount_ . $i]);

					$line = maxline('purchase_order_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into purchase_order_detail (ref, pr_ref, item_code, uom_code, qty, unit_cost, amount, line) values ('$ref', '$pr_ref', '$item_code', '$uom_code', '$qty', '$unit_cost', '$amount', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					##--------update qty purchase request
					if ($status != "P") {
						$sqlstr = "update purchase_request_detail set qty_po=ifnull(qty_po,0) + $qty where ref='$pr_ref' and item_code='$item_code' and uom_code='$uom_code' ";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						/*update status sales order : O=Ordered Part
											  C=Ordered Complete
											  V=Received Part
											  F=Received Complete
						*/
						$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_po,0)) qty_po from purchase_request_detail group by ref having ref='$pr_ref'";
						$result = $dbpdo->prepare($sql2);
						$result->execute();
						$data		= $result->fetch(PDO::FETCH_OBJ);

						$qty_po = $data->qty_po;
						$qty = $data->qty;

						if ($qty > 0) {
							if ($qty_po < $qty) {
								$sqlstr = "update purchase_request set status='O' where ref='$pr_ref' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
							}

							if ($qty_po >= $qty) {
								$sqlstr = "update purchase_request set status='C' where ref='$pr_ref' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
							}
						}
						##*****************************************##

					}
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert good_receipt
	function insert_good_receipt($ref)
	{
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




			$sqlstr = "insert into good_receipt (ref, date, status, date_arrival, driver, vehicle, location_id, memo, uid, dlu) values('$ref', '$date', '$status', '$date_arrival', '$driver', '$vehicle', '$location_id', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$po_ref 		= $_POST[po_ref_ . $i];
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code) && !empty($po_ref)) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_cost = numberreplace($_POST[unit_cost_ . $i]);

					$line = maxline('good_receipt_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into good_receipt_detail (ref, po_ref, item_code, uom_code, qty, unit_cost, line) values ('$ref', '$po_ref', '$item_code', '$uom_code', '$qty', '$unit_cost', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					##--------update qty purchase order
					if ($status != "P") {
						$sqlstr = "update purchase_order_detail set qty_gr=ifnull(qty_gr,0) + $qty where ref='$po_ref' and item_code='$item_code' and uom_code='$uom_code' ";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						/*update status purchase order : V=Received Part
											  F=Received Complete
						*/
						$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_gr,0)) qty_gr from purchase_order_detail group by ref having ref='$po_ref'";
						$result = $dbpdo->prepare($sql2);
						$result->execute();
						$data		= $result->fetch(PDO::FETCH_OBJ);

						$qty_gr = $data->qty_gr;
						$qty = $data->qty;

						if ($qty > 0) {
							if ($qty_gr < $qty) {
								$sqlstr = "update purchase_order set status='V' where ref='$po_ref' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
							}

							if ($qty_gr >= $qty) {
								$sqlstr = "update purchase_order set status='F' where ref='$po_ref' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
							}
						}
						##*****************************************##


						//----------bincard (debit_qty)
						$amount = $qty * $unit_cost;

						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'good_receipt', '$memo', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
					}
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert purchase invoice
	function insert_purchase_invoice($ref)
	{

		$dbpdo = DB::create();

		try {

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$po_ref 		= $_POST[po_ref_ . $i];
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				$select 		= (empty($_POST[select_ . $i])) ? 0 : $_POST[select_ . $i];
				if (!empty($item_code) && !empty($uom_code) && $select == 1) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_cost = numberreplace($_POST[unit_cost_ . $i]);
					$amount = $qty * $unit_cost; //numberreplace($_POST[amount_.$i]);
					$line_item_po = (empty($_POST[line_item_po_ . $i])) ? 0 : $_POST[line_item_po_ . $i];

					$line = maxline('purchase_invoice_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into purchase_invoice_detail (ref, po_ref, item_code, uom_code, qty, unit_cost, amount, line_item_po, line) values ('$ref', '$po_ref', '$item_code', '$uom_code', '$qty', '$unit_cost', '$amount', '$line_item_po', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$sub_total = $sub_total + $amount;

					##--------update qty purchase order
					if ($status != "P") {
						$sqlstr = "update purchase_order_detail set qty_pi=ifnull(qty_pi,0) + $qty where ref='$po_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_po' ";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						/*update status purchase order : I=Invoice Part
											  U=Invoice Full
						*/
						$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_pi,0)) qty_pi from purchase_order_detail group by ref having ref='$po_ref'";
						$result = $dbpdo->prepare($sql2);
						$result->execute();
						$data		= $result->fetch(PDO::FETCH_OBJ);

						$qty_pi = $data->qty_pi;
						$qty = $data->qty;

						if ($qty > 0) {
							if ($qty_pi < $qty) {
								$sqlstr = "update purchase_order set status='I' where ref='$po_ref' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
							}

							if ($qty_pi >= $qty) {
								$sqlstr = "update purchase_order set status='U' where ref='$po_ref' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
							}
						}
						##*****************************************##

					}
				}
			}


			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			$tax_code			= 	$_POST["tax_code"];
			$tax_rate			=	numberreplace((empty($_POST["tax_rate"])) ? 0 : $_POST["tax_rate"]);
			$freight_cost		=	numberreplace((empty($_POST["freight_cost"])) ? 0 : $_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$total				=	$sub_total;
			$memo				= 	petikreplace($_POST["memo"]);
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");

			$sqlstr = "insert into purchase_invoice (ref, date, status, bill_number, vendor_code, top, tax_code, tax_rate, freight_cost, freight_account, memo, total, uid, dlu) values('$ref', '$date', '$status', '$bill_number', '$vendor_code', '$top', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$memo', '$total', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//insert AP
			$sqlstr = "insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'V', '$vendor_code', '', 0, '$total', 'PIN', 'PIN', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert currency
	function insert_currency()
	{
		$dbpdo = DB::create();

		try {

			$name			=	petikreplace($_POST["name"]);
			$currency_code	=	petikreplace($_POST["currency_code"]);
			$symbol			=	petikreplace($_POST["symbol"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			$syscode		= 	random(9);

			$sqlstr = "insert into currency (name, currency_code, symbol, active, uid, dlu, syscode) values ('$name', '$currency_code', '$symbol', '$active', '$uid', '$dlu', '$syscode')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert currency rate type
	function insert_currency_rate_type()
	{
		$dbpdo = DB::create();

		try {

			$name			=	petikreplace($_POST["name"]);
			$currency_code	=	(empty($_POST["currency_code"])) ? 0 : $_POST["currency_code"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$rate			=	numberreplace((empty($_POST["rate"])) ? 0 : $_POST["rate"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into currency_rate_type (name, currency_code, date, rate, active, uid, dlu) values ('$name', '$currency_code', '$date', '$rate', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert credit card type
	function insert_credit_card_type()
	{
		$dbpdo = DB::create();

		try {

			$name			=	petikreplace($_POST["name"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into credit_card_type (name, active, uid, dlu) values ('$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert cash master
	function insert_cash_master()
	{
		$dbpdo = DB::create();

		try {

			$code			=	$_POST["code"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$maximum_limit	=	numberreplace((empty($_POST["maximum_limit"])) ? 0 : $_POST["maximum_limit"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into cash_master (code, location_id, maximum_limit, uid, dlu) values ('$code', '$location_id', '$maximum_limit', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert client type
	function insert_client_type()
	{
		$dbpdo = DB::create();

		try {

			$name				=	$_POST["name"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into client_type (name, sls_account, sls_return_account, sls_discount_account, client_deposit_account, currency_account, cheque_receivable_account, location_id, active, uid, dlu) values('$name', '$sls_account', '$sls_return_account', '$sls_discount_account', '$client_deposit_account', '$currency_account', '$cheque_receivable_account', '$location_id', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//-------get last ID
			$sqlid 		= "select last_insert_id() lastid";
			$resultid = $dbpdo->prepare($sqlid);
			$resultid->execute();
			$dataid		= $resultid->fetch(PDO::FETCH_OBJ);

			$lastid		= $dataid->lastid;
			//-------------------/\

			//----------insert detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			for ($i = 0; $i <= $jmldata; $i++) {

				$sls_account		=	$_POST[sls_account_ . $i];
				$sls_cash_account		=	$_POST[sls_cash_account_ . $i];
				$sls_return_account	=	$_POST[sls_return_account_ . $i];
				$sls_discount_account	=	$_POST[sls_discount_account_ . $i];
				$client_deposit_account	=	$_POST[client_deposit_account_ . $i];
				$currency_account		=	$_POST[currency_account_ . $i];
				$cheque_receivable_account	=	$_POST[cheque_receivable_account_ . $i];
				$sls_account2			=	$_POST[sls_account2_ . $i];
				$location_id	=	(empty($_POST[location_id_ . $i])) ? 0 : $_POST[location_id_ . $i];

				if ($location_id > 0) {

					$line = maxline('client_type_detail', 'line', 'id_header', $lastid, '');

					$sqlstr = "insert into client_type_detail (id_header, sls_account, sls_cash_account, sls_return_account, sls_discount_account, client_deposit_account, currency_account, cheque_receivable_account, sls_account2, location_id, line) values ('$lastid', '$sls_account', '$sls_cash_account', '$sls_return_account', '$sls_discount_account', '$client_deposit_account', '$currency_account', '$cheque_receivable_account', '$sls_account2', '$location_id', '$line')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert client
	function insert_client($code)
	{
		$dbpdo = DB::create();

		try {

			//$code			=	petikreplace($_POST["code"]);
			$title          =   $_POST["title"];
			$name			=	petikreplace($_POST["name"]);
			$last_name      =   petikreplace($_POST["last_name"]);
			$contact_person	=	petikreplace($_POST["contact_person"]);
			$contact_person1 =	petikreplace($_POST["contact_person1"]);
			$contact_person2 =	petikreplace($_POST["contact_person2"]);
			$contact_person3 =	petikreplace($_POST["contact_person3"]);
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
			$bank_name    	=	$_POST["bank_name"];
			$bank_branch    =   $_POST["bank_branch"];
			$bank_account	=	$_POST["bank_account"];
			$bank_account_no =   $_POST["bank_account_no"];
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			$syscode		= 	random(9);

			$sqlstr = "insert into client (code, title, name, last_name, contact_person, contact_person1, contact_person2, contact_person3, client_type, address, zip_code, country_id, state_id, phone, phone1, fax, email, web, bank_name, bank_branch, bank_account, bank_account_no, location_id, active, uid, dlu, syscode) values ('$code', '$title', '$name', '$last_name', '$contact_person', '$contact_person1', '$contact_person2', '$contact_person3', '$client_type', '$address', '$zip_code', '$country_id', '$state_id', '$phone', '$phone1', '$fax', '$email', '$web', '$bank_name', '$bank_branch', '$bank_account', '$bank_account_no', '$location_id', '$active', '$uid', '$dlu', '$syscode')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert price type
	function insert_price_type()
	{
		$dbpdo = DB::create();

		try {

			$name			=	petikreplace($_POST["name"]);
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into price_type (name, active, uid, dlu) values ('$name', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert set client balance
	function insert_set_client_balance()
	{
		$dbpdo = DB::create();

		try {

			$client_code		= 	$_POST["client_code"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");





			//----------insert opening balance detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$ref 		= $_POST[ref_ . $i];

				if (!empty($ref) && !empty($client_code)) {
					$date 		= date("Y-m-d", strtotime($_POST[date_ . $i]));
					$due_date 	= date("Y-m-d", strtotime($_POST[due_date_ . $i]));
					$amount 	= numberreplace($_POST[amount_ . $i]);
					$currency_code = $_POST[currency_code_ . $i];
					$rate 	= numberreplace($_POST[rate_ . $i]);

					$sqlstr = "insert into sales_invoice (ref, date, status, client_code, due_date, total, currency_code, rate, opening_balance, uid, dlu) values('$ref', '$date', '$status', '$client_code', '$due_date', '$amount', '$currency_code', '$rate', '1', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert marketing
	function insert_marketing()
	{
		$dbpdo = DB::create();

		try {

			$code			=	random(9);
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

			$sqlstr = "insert into marketing (code, name, contact_person, address, zip_code, country_id, state_id, phone, fax, email, web, bank_account, active, uid, dlu) values ('$code', '$name', '$contact_person', '$address', '$zip_code', '$country_id', '$state_id', '$phone', '$fax', '$email', '$web', '$bank_account', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert quotation
	function insert_quotation($ref)
	{

		$dbpdo = DB::create();

		try {

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_price = numberreplace($_POST[unit_price_ . $i]);
					$discount = numberreplace($_POST[discount_ . $i]);
					$amount = numberreplace($_POST[amount_ . $i]);

					$line = maxline('quotation_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into quotation_detail (ref, item_code, uom_code, qty, discount, unit_price, amount, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$quotation', '$unit_price', '$amount', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$sub_total = $sub_total + $amount;
				}
			}

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

			$sqlstr = "insert into quotation (ref, date, status, top, client_code, date_from, date_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, total, memo, uid, dlu) values('$ref', '$date', '$status', '$top', '$client_code', '$date_from', '$date_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$total', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert sales order
	function insert_sales_order($ref)
	{

		$dbpdo = DB::create();

		try {

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_price = numberreplace($_POST[unit_price_ . $i]);
					$discount = numberreplace($_POST[discount_ . $i]);
					$amount = numberreplace($_POST[amount_ . $i]);

					$line = maxline('sales_order_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into sales_order_detail (ref, item_code, uom_code, qty, discount, unit_price, amount, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$amount', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$sub_total = $sub_total + $amount;
				}
			}

			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$status			= 	$_POST["status"];
			$employee_id	= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
			$newclient		= 	(empty($_POST["newclient"])) ? 0 : $_POST["newclient"];
			$client_code	=	$_POST["client_code"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			##cek client
			if ($newclient == 1) {
				$sqlcek 	= 	"select code from client where name='$client_code' ";
				$resultcek = $dbpdo->prepare($sqlcek);
				$resultcek->execute();
				$numcek		= $resultcek->rowCount();

				if ($numcek == 0) {
					$syscode	= 	random(9);
					$code		=	substr($client_code, 0, 3) . $syscode;
					$phone		=	$_POST["phone"];
					$client_type =	(empty($_POST["client_type"])) ? 0 : $_POST["client_type"];

					$sqlins 	=	"insert into client (code, name, contact_person, client_type, phone, active, syscode, uid, dlu) values ('$code', '$client_code', '$client_code', '$client_type', '$phone', 1, '$syscode', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$client_code =	$syscode;
				} else {
					$sqlcek 	= 	"select syscode from client where name='$client_code' ";
					$resultcek = $dbpdo->prepare($sqlcek);
					$resultcek->execute();
					$datacek		= $resultcek->fetch(PDO::FETCH_OBJ);

					$client_code =	$datacek->syscode;
				}
			}


			$qo_ref				=	$_POST["qo_ref"];
			$top				=	$_POST["top"];
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$total				=	numberreplace($_POST["total"]) + $freight_cost; //$sub_total; //numberreplace($_POST["total"]);


			$sqlstr = "insert into sales_order (ref, date, status, top, client_code, qo_ref, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, total, memo, uid, dlu) values('$ref', '$date', '$status', '$top', '$client_code', '$qo_ref', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$total', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert delivery order
	function insert_delivery_order($ref)
	{

		$dbpdo = DB::create();

		try {

			$status		= 	$_POST["status"];

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code) && $select == 1) {
					$so_ref 		= $_POST[so_ref_ . $i];
					$qty = numberreplace($_POST[qty_ . $i]);
					$ship_date = date("Y-m-d", strtotime($_POST[ship_date_ . $i]));
					$line_item_so	= $_POST[line_item_so_ . $i];

					$line = maxline('delivery_order_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into delivery_order_detail (ref, so_ref, item_code, uom_code, qty, ship_date, line_item_so, line) values ('$ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$ship_date', '$line_item_so', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					##--------update qty sales order
					if ($status != "P" && $status != "C") {
						$sqlstr = "update sales_order_detail set qty_shp=ifnull(qty_shp,0) + $qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";
						$sql = $dbpdo->prepare($sqlstr);
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

			$sqlstr = "insert into delivery_order (ref, date, status, location_id, ship_to, po_number, client_code, memo, uid, dlu) values('$ref', '$date', '$status', '$location_id', '$ship_to', '$po_number', '$client_code', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();


			/*update status sales order : S=Shipped in Part (dikirim sebagian)
										  F=Shipped in Full (dikirm semua)
										  C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
			*/
			$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_shp,0)) qty_shp from sales_order_detail group by ref having ref='$so_ref'";
			$result = $dbpdo->prepare($sql2);
			$result->execute();
			$data		= $result->fetch(PDO::FETCH_OBJ);

			$qty_shp = $data->qty_shp;
			$qty = $data->qty;

			if ($qty > 0) {
				if ($qty_shp < $qty) {
					$sqlstr = "update sales_order set status='S' where ref='$so_ref' ";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}

				if ($qty_shp >= $qty) {
					$sqlstr = "update sales_order set status='F' where ref='$so_ref' ";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
			##*****************************************##


		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert sales invoice
	function insert_sales_invoice($ref)
	{

		$dbpdo = DB::create();

		try {

			$status		= 	$_POST["status"];

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code) && $select == 1) {
					$do_ref 		= $_POST[do_ref_ . $i];
					$so_ref 		= $_POST[so_ref_ . $i];

					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_price = numberreplace($_POST[unit_price_ . $i]);
					$discount = numberreplace($_POST[discount_ . $i]);
					$amount = numberreplace($_POST[amount_ . $i]);

					$line_item_do	= $_POST[line_item_do_ . $i];
					$line_item_so	= $_POST[line_item_so_ . $i];

					$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into sales_invoice_detail (ref, do_ref, so_ref, item_code, uom_code, qty, discount, unit_price, amount, line_item_do, line_item_so, line) values ('$ref', '$do_ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$amount', '$line_item_do', '$line_item_so', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$sub_total = $sub_total + $amount;

					##--------update qty delivery order
					if ($status != "P" && $status != "C") {
						$sqlstr = "update delivery_order_detail set qty_si=ifnull(qty_si,0) + $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						/*update status delivery order : I=Invoice in Part (diinvoicekan sebagian)
											  F=Invoice in Full (diinvoicekan semua)
											  C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
						*/
						$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_si,0)) qty_si from delivery_order_detail group by ref having ref='$do_ref'";
						$result = $dbpdo->prepare($sql2);
						$result->execute();
						$data		= $result->fetch(PDO::FETCH_OBJ);

						$qty_si = $data->qty_si;
						$qty = $data->qty;

						if ($qty > 0) {
							if ($qty_si < $qty) {
								$sqlstr = "update delivery_order set status='I' where ref='$do_ref' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
							}

							if ($qty_si >= $qty) {
								$sqlstr = "update delivery_order set status='F' where ref='$do_ref' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
							}
						}
						##*****************************************##

					}
				}
			}


			$date				=	date("Y-m-d", strtotime($_POST["date"]));
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
			$total				=	$sub_total + $freight_cost; //numberreplace($_POST["total"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into sales_invoice (ref, date, status, top, client_code, ship_to, bill_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, total, memo, opening_balance, uid, dlu) values('$ref', '$date', '$status', '$top', '$client_code', '$ship_to', '$bill_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$total', '$memo', 0, '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//insert AR
			$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$total', 0, 'SOI', 'SOI', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert sales return
	function insert_sales_return($ref)
	{

		$dbpdo = DB::create();

		try {

			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$memo				= 	$_POST["memo"];
			$si_ref				=	$_POST["si_ref"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");

			//----------insert item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code) && $select == 1) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_price = numberreplace($_POST[unit_price_ . $i]);
					$discount = numberreplace($_POST[discount_ . $i]);
					$charge_p = numberreplace($_POST[charge_p_ . $i]);
					$amount = numberreplace($_POST[amount_ . $i]);

					$line_item_si	= $_POST[line_item_si_ . $i];

					$line = maxline('sales_return_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into sales_return_detail (ref, item_code, uom_code, qty, discount, unit_price, charge_p, amount, line_item_si, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$charge_p', '$amount', '$line_item_si', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$sub_total = $sub_total + $amount;

					##--------update qty sales invoice
					if ($status == "R") {
						$sqlstr = "update sales_invoice_detail set qty_rtn=ifnull(qty_rtn,0) + $qty where ref='$si_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_si' ";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						//----------insert bincard (debit qty)
						$sqlsi = "select location_id from sales_invoice where ref='$si_ref' ";
						$resultsi = $dbpdo->prepare($sqlsi);
						$resultsi->execute();
						$datasi		= $resultsi->fetch(PDO::FETCH_OBJ);

						$location_id = $datasi->location_id;

						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'sales_return', '$memo', '$item_code', '$uom_code', '$unit_price', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";

						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						##*****************************************##

					}
				}
			}


			$client_code		=	$_POST["client_code"];
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$total				=	$sub_total; //numberreplace($_POST["total"]);

			$sqlstr = "insert into sales_return (ref, date, status, client_code, si_ref, tax_code, tax_rate, currency_code, rate, total, memo, uid, dlu) values('$ref', '$date', '$status', '$client_code', '$si_ref', '$tax_code', '$tax_rate', '$currency_code', '$rate', '$total', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			##insert AR (credit)
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			$total	=	$total + $tax_total; // + $total_charge;

			$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '1900-01-01', 'C', '$client_code', '', 0, '$total', 'SIR', 'SIR', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert purchase return
	function insert_purchase_return($ref)
	{

		$dbpdo = DB::create();

		try {

			$date		=	date("Y-m-d", strtotime($_POST["date"]));
			$status		= 	$_POST["status"];
			$pi_ref		=	$_POST["pi_ref"];
			$memo		= 	$_POST["memo"];
			$uid		=	$_SESSION["loginname"];
			$dlu		=	date("Y-m-d H:i:s");

			//----------insert item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code) && $select == 1) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_cost = numberreplace($_POST[unit_cost_ . $i]);
					$discount = numberreplace($_POST[discount_ . $i]);
					$amount = numberreplace($_POST[amount_ . $i]);

					$line_item_pi	= $_POST[line_item_pi_ . $i];

					$line = maxline('purchase_return_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into purchase_return_detail (ref, item_code, uom_code, qty, discount, unit_cost, amount, line_item_pi, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_cost', '$amount', '$line_item_pi', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$sub_total = $sub_total + $amount;

					##--------update qty purchase invoice
					if ($status != "P") {
						$sqlstr = "update purchase_invoice_detail set qty_rtn=ifnull(qty_rtn,0) + $qty where ref='$pi_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_pi' ";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
						##*****************************************##

						//get location ID
						$sqlpi = "select location_id from purchase_invoice where ref='$pi_ref'";
						$resultpi = $dbpdo->prepare($sqlpi);
						$resultpi->execute();
						$datapi		= $resultpi->fetch(PDO::FETCH_OBJ);

						$location_id = $datapi->location_id;

						//----------bincard (debit_qty)
						$amount = $qty * $unit_cost;

						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_return', '$memo', '$item_code', '$uom_code', '$unit_cost', '0', '$qty', '$amount', '$line', '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
					}
				}
			}


			$vendor_code		=	$_POST["vendor_code"];
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$total				=	$sub_total; //numberreplace($_POST["total"]);

			$sqlstr = "insert into purchase_return (ref, date, status, vendor_code, pi_ref, tax_code, tax_rate, currency_code, rate, total, memo, uid, dlu) values('$ref', '$date', '$status', '$vendor_code', '$pi_ref', '$tax_code', '$tax_rate', '$currency_code', '$rate', '$total', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//insert AP
			$sqlstr = "insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '1900-01-01', 'V', '$vendor_code', '', '$total', 0, 'PIR', 'PIR', '$currency_code', '$rate', '', '', '', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert good_return
	function insert_good_return($ref)
	{
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




			$sqlstr = "insert into good_return (ref, date, status, vendor_code, reason, location_id, memo, uid, dlu) values('$ref', '$date', '$status', '$vendor_code', '$reason', '$location_id', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$gr_ref 		= $_POST[gr_ref_ . $i];
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code) && $select == 1) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$line_item_gr	= $_POST[line_item_gr_ . $i];

					$line = maxline('good_return_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into good_return_detail (ref, gr_ref, item_code, uom_code, qty, line_item_gr, line) values ('$ref', '$gr_ref', '$item_code', '$uom_code', '$qty', '$line_item_gr', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					##--------update qty good receipt
					if ($status != "P") {
						$sqlstr = "update good_receipt_detail set qty_rtn=ifnull(qty_rtn,0) + $qty where ref='$gr_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_gr' ";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						//----------insert bincard (debit qty)
						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'good_return', '$memo', '$item_code', '$uom_code', '0', 0, '$qty', '0', '$line', '$uid', '$dlu')";

						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						##*****************************************##

					}
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert delivery_return
	function insert_delivery_return($ref)
	{
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




			$sqlstr = "insert into delivery_return (ref, date, status, client_code, reason, location_id, memo, uid, dlu) values('$ref', '$date', '$status', '$client_code', '$reason', '$location_id', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//----------insert item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$do_ref 		= $_POST[do_ref_ . $i];
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code) && $select == 1) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$line_item_do	= $_POST[line_item_do_ . $i];

					$line = maxline('delivery_return_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into delivery_return_detail (ref, do_ref, item_code, uom_code, qty, line_item_do, line) values ('$ref', '$do_ref', '$item_code', '$uom_code', '$qty', '$line_item_do', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					##--------update qty return delivery order
					if ($status == "R") {
						$sqlstr = "update delivery_order_detail set qty_rtn=ifnull(qty_rtn,0) + $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						##*****************************************##

						//----------insert bincard (debit qty)
						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'delivery_return', '$reason', '$item_code', '$uom_code', '0', '$qty', 0, '0', '$line', '$uid', '$dlu')";

						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						##*****************************************##

					}
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert receipt
	function insert_receipt($ref)
	{
		$dbpdo = DB::create();

		try {

			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$client_code	=	$_POST["client_code"];
			$memo			= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");





			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$invoice_no 	= $_POST[invoice_no_ . $i];
				$amount_paid 	= numberreplace($_POST[amount_paid_ . $i]);

				if (!empty($invoice_no) && $amount_paid <> 0 && $select == 1) {

					$invoice_date		= date("Y-m-d", strtotime($_POST[invoice_date_ . $i]));
					$invoice_due_date	= date("Y-m-d", strtotime($_POST[invoice_due_date_ . $i]));
					$amount_due		= numberreplace($_POST[amount_due_ . $i]);
					$discount 		= numberreplace($_POST[discount_ . $i]);
					$currency_code 	= $_POST[currency_code_ . $i];
					$rate			= numberreplace($_POST[rate_ . $i]);
					$ref_type		= $_POST[transaction_ . $i];
					$amount_due		= numberreplace($_POST[amount_due_ . $i]);
					$amount 		= $amount_paid - $discount; //numberreplace($_POST[amount_.$i]);

					$line = maxline('receipt_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into receipt_detail (ref, invoice_no, invoice_date, invoice_due_date, discount, amount_paid, invoice_currency_code, invoice_rate, ref_type, amount_due, amount, line) values ('$ref', '$invoice_no', '$invoice_date', '$invoice_due_date', '$discount', '$amount_paid', '$currency_code', '$rate', '$ref_type', '$amount_due', '$amount', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					//insert AR
					$sqlc = "select a.* from (select id code, concat(name, ' ( ','Employee',' )') name, 'E' type from employee where active=1 union all  select syscode code, concat(name,' (',phone,')') name, 'C' type from client where active=1 and ifnull(name,'') <> '' ) a where a.code='$client_code'";
					$resultc = $dbpdo->prepare($sqlc);
					$resultc->execute();
					$datac		= $resultc->fetch(PDO::FETCH_OBJ);

					$typec = $datac->type;

					if ($ref_type != "DPS") {

						if ($ref_type == 'SIR') {
							##credit
							if ($amount < 0) {
								$amount_debit = $amount * -1;
							}
							$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, discount_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$invoice_no', '$date', '$invoice_due_date', '$typec', '$client_code', '', '$amount_debit', 0, '$discount', 'RCI', '$ref_type', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', '$uid', '$dlu')";
							$sql = $dbpdo->prepare($sqlstr);
							$sql->execute();
						} else {

							$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, discount_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$invoice_no', '$date', '$invoice_due_date', '$typec', '$client_code', '', 0, '$amount', '$discount', 'RCI', '$ref_type', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', '$uid', '$dlu')";
							$sql = $dbpdo->prepare($sqlstr);
							$sql->execute();
						}
					}

					//insert DPS (deposit)
					if ($ref_type == "DPS") {
						if ($amount < 0) {

							$credit = $amount * -1;

							$sqlstr = "insert into dps(ref, invoice_no, date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$invoice_no', '$date', 'C', '$client_code', '', 0, '$credit', 'RCI', 'RCI', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', '$uid', '$dlu')";
							$sql = $dbpdo->prepare($sqlstr);
							$sql->execute();
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
			if ($round_amount == 0) {
				$round_amount_account = "";
			}

			$bank_charge		=	numberreplace($_POST["bank_charge"]);
			$bank_charge_account	= 	$_POST["bank_charge_account"];
			if ($bank_charge == 0) {
				$bank_charge_account = "";
			}

			$sub_total			=	numberreplace($_POST["sub_total"]);
			$deposit			=	numberreplace($_POST["deposit"]);
			$type				=	$_POST["type"];

			$total				=	numberreplace($_POST["total"]);

			$sqlstr = "insert into receipt (ref, date, status, client_code, receipt_type, cheque_no, cheque_date, bank_name, credit_card_no, credit_card_code, credit_card_holder, credit_card_expired, account_code, currency_code, rate, amount, deposit, sub_total, type, memo, round_amount, round_amount_account, bank_charge, bank_charge_account, opening_balance, total, uid, dlu) values('$ref', '$date', '$status', '$client_code', '$receipt_type', '$cheque_no', '$cheque_date', '$bank_name', '$credit_card_no', '$credit_card_code', '$credit_card_holder', '$credit_card_expired', '$account_code', '$currency_code', '$rate', '$amount', '$deposit', '$sub_total', '$type', '$memo', '$round_amount', '$round_amount_account', '$bank_charge', '$bank_charge_account', '0', '$total', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			if ($receipt_type == "giro" || $receipt_type == "cheque") {

				//insert ARC
				$sqlstr = "insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}

			//insert DPS (Deposit)
			if ($deposit < 0) {

				$debit = $deposit * -1;

				$sqlstr = "insert into dps (ref, invoice_no, date, contact_code, contact_type, debit_amount, currency_code, rate, description, invoice_type, ref_type, uid, dlu) values ('$ref', '$ref', '$date', '$client_code', 'C', '$debit', '$currency_code', '$rate', '$memo', 'RCI', 'RCI', '$uid', '$dlu') ";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert payment
	function insert_payment($ref)
	{

		$dbpdo = DB::create();

		try {

			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$vendor_code	=	$_POST["vendor_code"];
			$memo			= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");





			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$invoice_no 	= $_POST[invoice_no_ . $i];
				$amount_paid 	= numberreplace($_POST[amount_paid_ . $i]);

				if (!empty($invoice_no) && $amount_paid <> 0 && $select == 1) {

					$invoice_date		= date("Y-m-d", strtotime($_POST[invoice_date_ . $i]));
					$invoice_due_date	= date("Y-m-d", strtotime($_POST[invoice_due_date_ . $i]));
					$amount_due		= numberreplace($_POST[amount_due_ . $i]);
					$discount 		= numberreplace($_POST[discount_ . $i]);
					$currency_code 	= $_POST[currency_code_ . $i];
					$rate			= numberreplace($_POST[rate_ . $i]);
					$ref_type		= $_POST[transaction_ . $i];
					$amount_due		= numberreplace($_POST[amount_due_ . $i]);
					$amount 		= $amount_paid - $discount; //numberreplace($_POST[amount_.$i]);

					$line = maxline('payment_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into payment_detail (ref, invoice_no, invoice_date, invoice_due_date, discount, amount_paid, invoice_currency_code, invoice_rate, ref_type, amount_due, amount, line) values ('$ref', '$invoice_no', '$invoice_date', '$invoice_due_date', '$discount', '$amount_paid', '$currency_code', '$rate', '$ref_type', '$amount_due', '$amount', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					//insert AP
					$sqlv = "select a.* from (select syscode code, name, 'V' type from vendor where active=1 union all
			  select syscode code, concat(name,' (',phone,')') name, 'C' type from client where active=1 and ifnull(name,'') <> '' union all select id code, concat(name, ' ( ','Employee',' )') name, 'E' type from employee where active=1 ) a where a.code='$vendor_code'";
					$resultv = $dbpdo->prepare($sqlv);
					$resultv->execute();
					$datav		= $resultv->fetch(PDO::FETCH_OBJ);

					$typev = $datav->type;

					if ($ref_type == 'PIR') {
						##credit
						if ($amount < 0) {
							$amount_credit = $amount * -1;
						}
						$sqlstr = "insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, discount_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, line, uid, dlu) values('$ref', '$invoice_no', '$date', '$invoice_due_date', '$typev', '$vendor_code', '', 0, '$amount_credit', '$discount', 'PMT', '$ref_type', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', $line, '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
					} else {
						##debit
						$sqlstr = "insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, discount_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, line, uid, dlu) values('$ref', '$invoice_no', '$date', '$invoice_due_date', '$typev', '$vendor_code', '', '$amount', 0, '$discount', 'PMT', '$ref_type', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', $line, '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
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

			$round_amount		=	numberreplace($_POST["round_amount"]);
			$round_amount_account	=	$_POST["round_amount_account"];
			if ($round_amount == 0) {
				$round_amount_account = "";
			}

			$bank_charge		=	numberreplace($_POST["bank_charge"]);
			$bank_charge_account	= 	$_POST["bank_charge_account"];
			if ($bank_charge == 0) {
				$bank_charge_account = "";
			}

			$sub_total			=	numberreplace($_POST["sub_total"]);
			$deposit			=	numberreplace($_POST["deposit"]);
			$type				=	$_POST["type"];
			$no_ttfa			=	$_POST["no_ttfa"];

			$total				=	numberreplace($_POST["total"]);

			$sqlstr = "insert into payment (ref, date, status, vendor_code, payment_type, cheque_no, cheque_date, bank_name, credit_card_no, credit_card_code, credit_card_holder, credit_card_expired, account_code, currency_code, rate, amount, deposit, sub_total, type, memo, round_amount, round_amount_account, bank_charge, bank_charge_account, opening_balance, total, no_ttfa, uid, dlu) values('$ref', '$date', '$status', '$vendor_code', '$payment_type', '$cheque_no', '$cheque_date', '$bank_name', '$credit_card_no', '$credit_card_code', '$credit_card_holder', '$credit_card_expired', '$account_code', '$currency_code', '$rate', '$amount', '$deposit', '$sub_total', '$type', '$memo', '$round_amount', '$round_amount_account', '$bank_charge', '$bank_charge_account', '0', '$total', '$no_ttfa', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			if ($payment_type == "giro" || $payment_type == "cheque") {

				//insert APC
				//$sqlstr="insert into apc (ref, date, vendor_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$vendor_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
				//QueryDbTrans($sql, $success);

				//--------detail giro
				$jmldatabg = (empty($_POST['jmldatabg'])) ? 0 : $_POST['jmldatabg'];

				$i = 0;
				for ($i = 0; $i <= $jmldatabg; $i++) {

					$account_code    = $_POST[account_code_ . $i];
					$cheque_no       = $_POST[cheque_no_ . $i];
					$bank_name       = $_POST[bank_name_ . $i];
					$cheque_date     = date("Y-m-d", strtotime($_POST["cheque_date_.$i"]));
					$amountbg      	 = numberreplace($_POST[amountbg_ . $i]);

					if (!empty($account_code) && !empty($cheque_no) && $amountbg <> 0) {

						//insert APC
						$sqlstr = "insert into payment_giro (ref, account_code, cheque_no, bank_name, cheque_date, amountbg, line) values('$ref', '$account_code', '$cheque_no', '$bank_name', '$cheque_date', '$amountbg', '$i')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						//insert APC
						$sqlstr = "insert into apc (ref, date, vendor_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, uid, dlu, line) values('$ref', '$date', '$vendor_code', '$cheque_no', '$bank_name', '$cheque_date', '$amountbg', '$currency_code', '$rate', '$account_code', '$receipt_type', '$uid', '$dlu', $i)";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
					}
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert cash invoice
	function insert_cash_invoice($ref)
	{

		$dbpdo = DB::create();

		try {

			$ref2			= 	$_POST["ref2"];
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];
			if ($taxable == 0) {
				$ref2		= 	"";
			}

			$status			= 	$_POST["status"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$cash			=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$phone			=	$_POST["phone"];
			$ship_to		=	$_POST["ship_to"];
			$bill_to		=	$_POST["bill_to"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$do_ref 		= $_POST[do_ref_ . $i];
					$so_ref 		= $_POST[so_ref_ . $i];

					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_price = numberreplace($_POST[unit_price_ . $i]);
					$unit_price2 = numberreplace($_POST[unit_price2_ . $i]);
					$discount = numberreplace($_POST[discount_ . $i]);
					$amount = numberreplace($_POST[amount_ . $i]);
					$amount2 = numberreplace($_POST[amount2_ . $i]);
					$dummy = (empty($_POST[dummy_ . $i])) ? 0 : $_POST[dummy_ . $i];

					$line_item_do	= $_POST[line_item_do_ . $i];
					$line_item_so	= $_POST[line_item_so_ . $i];

					$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into sales_invoice_detail (ref, do_ref, so_ref, item_code, uom_code, qty, discount, unit_price, amount, unit_price2, amount2, dummy, line_item_do, line_item_so, line) values ('$ref', '$do_ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$amount', '$unit_price2', '$amount2', '$dummy', '$line_item_do', '$line_item_so', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					//----------insert bincard (debit qty)
					$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'cash_invoice', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();


					//----------insert/update set_item_price
					$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' order by date_of_record desc limit 1 ";
					$resultprice = $dbpdo->prepare($sqlprice);
					$resultprice->execute();
					$numprice		= $resultprice->rowCount();

					if ($numprice == 0) {
						$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' order by date_of_record desc limit 1 ";
						$resultprice2 = $dbpdo->prepare($sqlprice2);
						$resultprice2->execute();
						$dataprice		= $resultprice2->fetch(PDO::FETCH_OBJ);

						$last_price			=	$dataprice->current_price;
						$date_of_record		=	date("Y-m-d H:i:s");

						$sqlstr = "insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
					}
					//------------------------------------/\


					$sub_total = $sub_total + $amount;
				}
			}



			$newclient		=	(empty($_POST["newclient"])) ? 0 : $_POST["newclient"];
			$client_code	=	$_POST["client_code"];

			if ($newclient == 1) {
				//-------------------cek customer baru----\/		
				$sqlcek 	= 	"select code from client where name='$client_code' ";
				$resultcek = $dbpdo->prepare($sqlcek);
				$resultcek->execute();
				$numcek		= $resultcek->rowCount();

				if ($numcek == 0) {
					$syscode	= 	random(9);
					$code		=	substr($client_code, 0, 3) . $syscode;

					//-------get client type
					/*$sqlcln 	= 	"select client_type from client where ifnull(client_type,0)<>0 limit 1 ";							$resultcln	=	mysql_query($sqlcln);
					$datacln	=	mysql_fetch_object($resultcln);
					$client_type=	$datacln->client_type;*/
					$client_type =	(empty($_POST["client_type"])) ? 0 : $_POST["client_type"];
					//------------------/\

					$location_id2 = $_SESSION['location_id2'];
					$sqlstr 	=	"insert into client (code, name, contact_person, client_type, ship_to, bill_to, phone, address, active, syscode, location_id, uid, dlu) values ('$code', '$client_code', '$client_code', '$client_type', '$ship_to', '$bill_to', '$phone', '$ship_to', 1, '$syscode', '$location_id2', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$client_code =	$syscode;
				} else {
					$sqlcek 	= 	"select syscode from client where name='$client_code' ";
					$resultcek = $dbpdo->prepare($sqlcek);
					$resultcek->execute();
					$datacek		= $resultcek->fetch(PDO::FETCH_OBJ);

					$client_code =	$datacek->syscode;
				}
				//----------------------/\-end cek customer
			}

			$employee_id		= 	(empty($_POST["employee_id"])) ? 0 : $_POST["employee_id"];
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

			$sqlstr = "insert into sales_invoice (ref, ref2, date, status, top, due_date, client_code, ship_to, bill_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, total, memo, opening_balance, cash, location_id, deposit, taxable, discount, use_deposit, ref_rci, uid, dlu) values('$ref', '$ref2', '$date', '$status', '$top', '$due_date', '$client_code', '$ship_to', '$bill_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$total', '$memo', 0, '$cash', '$location_id', '$deposit', '$taxable', '$discount2', '$use_deposit', '$ref_rci', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			if ($cash == 0) {

				$total = $total - $deposit;
				//insert AR
				$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$total', 0, 'CSH', 'CSH', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}

			if ($taxable == 1) {
				notran($date, 'frmcash_invoice2', 1, '', $_SESSION["location"]); //----eksekusi ref	
			}

			//------jika ada DP
			//if($use_deposit == 1 && $deposit > 0) {
			if ($deposit > 0) {
				$sqlstr = "insert into dps(ref, invoice_no, date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref_rci', '$date', 'C', '$client_code', '', 0, '$deposit', 'RCI', 'CSH', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert delivery order quick
	function insert_delivery_order_quick($ref)
	{

		$dbpdo = DB::create();

		try {

			$status		= 	$_POST["status"];

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code) && $select == 1) {
					$so_ref 		= $_POST[so_ref_ . $i];
					$qty = numberreplace($_POST[qty_ . $i]);
					$ship_date = date("Y-m-d", strtotime($_POST[ship_date_ . $i]));
					$line_item_so	= $_POST[line_item_so_ . $i];

					$line = maxline('delivery_order_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into delivery_order_detail (ref, so_ref, item_code, uom_code, qty, ship_date, line_item_so, line) values ('$ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$ship_date', '$line_item_so', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					##--------update qty sales order
					if ($status != "P" && $status != "C") {
						$sqlstr = "update sales_invoice_detail set qty_shp=ifnull(qty_shp,0) + $qty where ref='$so_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_so' ";
						$sql = $dbpdo->prepare($sqlstr);
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

			$sqlstr = "insert into delivery_order (ref, date, status, location_id, ship_to, po_number, client_code, memo, uid, dlu) values('$ref', '$date', '$status', '$location_id', '$ship_to', '$po_number', '$client_code', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();


			/*update status sales order : S=Shipped in Part (dikirim sebagian)
										  F=Shipped in Full (dikirm semua)
										  C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
			*/
			$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_shp,0)) qty_shp from sales_invoice_detail group by ref having ref='$so_ref'";
			$result = $dbpdo->prepare($sql2);
			$result->execute();
			$data		= $result->fetch(PDO::FETCH_OBJ);

			$qty_shp = $data->qty_shp;
			$qty2 = $data->qty;

			//if($qty > 0) {
			if ($qty_shp < $qty2) {
				$sqlstr = "update sales_invoice set status='S' where ref='$so_ref' ";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}

			if ($qty_shp >= $qty2) {
				$sqlstr = "update sales_invoice set status='E' where ref='$so_ref' ";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}

			if ($qty_shp <= 0) {
				$sqlstr = "update sales_invoice set status='R' where ref='$so_ref' ";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			//}
			##*****************************************##


		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert direct payment
	function insert_direct_payment($ref)
	{

		$dbpdo = DB::create();

		try {

			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$contact_type	=	$_POST["contact_type"];
			$contact_code	=	$_POST["contact_code"];

			if ($contact_type == "O") {
				$contact_name	=	$contact_code;
			}

			$ap		 		= (empty($_POST['ap'])) ? 0 : $_POST['ap'];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			//----------insert direct payment detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$account_code 	= $_POST[account_code_ . $i];
				$debit_amount 	= numberreplace($_POST[debit_amount_ . $i]);
				$credit_amount 	= numberreplace($_POST[credit_amount_ . $i]);

				if (!empty($account_code) && ($debit_amount <> 0 || $credit_amount <> 0)) {
					$memo		 	= $_POST[memo_ . $i];
					$currency_code 	= $_POST[currency_code_ . $i];
					$rate 			= numberreplace($_POST[rate_ . $i]);

					$line = maxline('direct_payment_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into direct_payment_detail (ref, account_code, currency_code, rate, debit_amount, credit_amount, memo, line) values ('$ref', '$account_code', '$currency_code', '$rate', '$debit_amount', '$credit_amount', '$memo', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
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
			$memo				= 	$_POST["memo"];
			/*
			$round_amount		=	numberreplace($_POST["round_amount"]);
			$round_amount_account	=	$_POST["round_amount_account"];
			if($round_amount == 0) {
				$round_amount_account = "";	
			}
			
			$bank_charge		=	numberreplace($_POST["bank_charge"]);
			$bank_charge_account	= 	$_POST["bank_charge_account"];
			if($bank_charge == 0) {
				$bank_charge_account = "";
			} */

			$sub_total			=	numberreplace($_POST["sub_total"]);
			$deposit			=	numberreplace($_POST["deposit"]);
			$type				=	$_POST["type"];

			$total				=	$amount; //numberreplace($_POST["total"]);

			$sqlstr = "insert into direct_payment (ref, date, status, contact_type, contact_code, contact_name, payment_type, cheque_no, cheque_date, bank_name, credit_card_no, credit_card_code, credit_card_holder, credit_card_expired, account_code, currency_code, rate, amount, deposit, sub_total, type, memo, opening_balance, total, ap, uid, dlu) values('$ref', '$date', '$status', '$contact_type', '$contact_code', '$contact_name', '$payment_type', '$cheque_no', '$cheque_date', '$bank_name', '$credit_card_no', '$credit_card_code', '$credit_card_holder', '$credit_card_expired', '$account_code', '$currency_code', '$rate', '$amount', '$deposit', '$sub_total', '$type', '$memo', '0', '$total', '$ap', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			if ($payment_type == "giro" || $payment_type == "cheque") {

				//insert APC
				$sqlstr = "insert into apc (ref, date, vendor_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$contact_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}

			if ($ap == 1) {

				//insert AP
				$sqlstr = "insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$date', '$contact_type', '$contact_code', '', 0, '$total', 'DPM', 'DPM', '$currency_code', '$rate', '', '', '', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert direct receipt
	function insert_direct_receipt($ref)
	{

		$dbpdo = DB::create();

		try {

			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$contact_type	=	$_POST["contact_type"];
			$contact_code	=	$_POST["contact_code"];

			if ($contact_type == "O") {
				$contact_name	=	$contact_code;
			}

			$ar 			= 	(empty($_POST['ar'])) ? 0 : $_POST['ar'];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			//----------insert direct receipt detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$account_code 	= $_POST[account_code_ . $i];
				$debit_amount 	= numberreplace($_POST[debit_amount_ . $i]);
				$credit_amount 	= numberreplace($_POST[credit_amount_ . $i]);

				if (!empty($account_code) && ($debit_amount <> 0 || $credit_amount <> 0)) {
					$memo		 	= $_POST[memo_ . $i];
					$currency_code 	= $_POST[currency_code_ . $i];
					$rate 			= numberreplace($_POST[rate_ . $i]);

					$line = maxline('direct_receipt_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into direct_receipt_detail (ref, account_code, currency_code, rate, debit_amount, credit_amount, memo, line) values ('$ref', '$account_code', '$currency_code', '$rate', '$debit_amount', '$credit_amount', '$memo', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
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
			$total				=	$amount; //numberreplace($_POST["total"]);

			$sqlstr = "insert into direct_receipt (ref, date, status, contact_type, contact_code, contact_name, receipt_type, cheque_no, cheque_date, bank_name, credit_card_no, credit_card_code, credit_card_holder, credit_card_expired, account_code, currency_code, rate, amount, deposit, sub_total, type, memo, opening_balance, installment, loan, total, ar, uid, dlu) values('$ref', '$date', '$status', '$contact_type', '$contact_code', '$contact_name', '$receipt_type', '$cheque_no', '$cheque_date', '$bank_name', '$credit_card_no', '$credit_card_code', '$credit_card_holder', '$credit_card_expired', '$account_code', '$currency_code', '$rate', '$amount', '$deposit', '$sub_total', '$type', '$memo', '0', '$installment', '$loan', '$total', '$ar', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			if ($receipt_type == "giro" || $receipt_type == "cheque") {

				//insert ARC
				$sqlstr = "insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$contact_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}

			if ($ar == 1) {

				//insert AR
				if ($loan == 1) {
					$ref_type = "loan";
				} else {
					$ref_type = "DRC";
				}
				$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$date', '$contact_type', '$contact_code', '', '$total', 0, 'DRC', '$ref_type', '$currency_code', '$rate', '', '', '', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert delivery order project
	function insert_delivery_order_project($ref)
	{

		$dbpdo = DB::create();

		try {

			$status		= 	$_POST["status"];

			//----------insert delivery order project detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			for ($i = 0; $i <= $jmldata; $i++) {

				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$ship_date = date("Y-m-d", strtotime($_POST[ship_date_ . $i]));

					$line = maxline('delivery_order_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into delivery_order_detail (ref, so_ref, item_code, uom_code, qty, ship_date, line_item_so, line) values ('$ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$ship_date', '0', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}


			$newclient		=	(empty($_POST["newclient"])) ? 0 : $_POST["newclient"];
			$client_code	=	$_POST["client_code"];
			$phone			=	$_POST["phone"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			if ($newclient == 1) {
				//-------------------cek customer baru----\/		
				$sqlcek 	= 	"select code from client where name='$client_code' ";
				$resultcek = $dbpdo->prepare($sqlcek);
				$resultcek->execute();
				$numcek		= $resultcek->rowCount();

				if ($numcek == 0) {
					$syscode	= 	random(9);
					$code		=	substr($client_code, 0, 3) . $syscode;

					//-------get client type
					/*$sqlcln 	= 	"select client_type from client where ifnull(client_type,0)<>0 limit 1 ";							$resultcln	=	mysql_query($sqlcln);
					$datacln	=	mysql_fetch_object($resultcln);
					$client_type=	$datacln->client_type;*/
					$client_type =	(empty($_POST["client_type"])) ? 0 : $_POST["client_type"];
					//------------------/\

					$location_id2 = $_SESSION['location_id2'];
					$sqlstr 	=	"insert into client (code, name, contact_person, client_type, ship_to, bill_to, phone, address, location_id, active, syscode, uid, dlu) values ('$code', '$client_code', '$client_code', '$client_type', '$ship_to', '$bill_to', '$phone', '$ship_to', '$location_id2', 1, '$syscode', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$client_code =	$syscode;
				} else {
					$sqlcek 	= 	"select syscode from client where name='$client_code' ";
					$resultcek = $dbpdo->prepare($sqlcek);
					$resultcek->execute();
					$datacek		= $resultcek->fetch(PDO::FETCH_OBJ);

					$client_code =	$datacek->syscode;
				}
				//----------------------/\-end cek customer
			}

			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id	= 	$_POST["location_id"];
			$po_number		= 	$_POST["po_number"];
			$ship_to		= 	$_POST["ship_to"];
			$memo			= 	$_POST["memo"];


			$sqlstr = "insert into delivery_order (ref, date, status, location_id, ship_to, po_number, client_code, memo, direct, uid, dlu) values('$ref', '$date', '$status', '$location_id', '$ship_to', '$po_number', '$client_code', '$memo', 1, '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert sales invoice project
	function insert_sales_invoice_project($ref)
	{

		$dbpdo = DB::create();

		try {

			$ref2			= 	$_POST["ref2"];
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];
			if ($taxable == 0) {
				$ref2		= 	"";
			}

			$status		= 	$_POST["status"];

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$select 		= $_POST[select_ . $i];

				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code) && $select == 1) {
					$do_ref 		= $_POST[do_ref_ . $i];
					$so_ref 		= $_POST[so_ref_ . $i];

					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_price = numberreplace($_POST[unit_price_ . $i]);
					$unit_price2 = numberreplace($_POST[unit_price2_ . $i]);
					$discount = numberreplace($_POST[discount_ . $i]);
					$amount = numberreplace($_POST[amount_ . $i]);
					$amount2 = numberreplace($_POST[amount2_ . $i]);
					$dummy = (empty($_POST[dummy_ . $i])) ? 0 : $_POST[dummy_ . $i];

					$line_item_do	= $_POST[line_item_do_ . $i];

					$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into sales_invoice_detail (ref, do_ref, so_ref, item_code, uom_code, qty, discount, unit_price2, unit_price, amount, amount2, dummy, line_item_do, line_item_so, line) values ('$ref', '$do_ref', '$so_ref', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price2', '$unit_price', '$amount', '$amount2', '$dummy', '$line_item_do', '0', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$sub_total = $sub_total - $discount + $amount;

					##--------update qty delivery order
					if ($status != "P" && $status != "C") {
						$sqlstr = "update delivery_order_detail set qty_si=ifnull(qty_si,0) + $qty where ref='$do_ref' and item_code='$item_code' and uom_code='$uom_code' and line='$line_item_do' ";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						/*update status delivery order : I=Invoice in Part (diinvoicekan sebagian)
											  F=Invoice in Full (diinvoicekan semua)
											  C=Closed (tidak dikirim sama sekali, tetapi transaksi di close)	
						*/
						$sql2 = "select sum(ifnull(qty,0)) qty, sum(ifnull(qty_si,0)) qty_si from delivery_order_detail group by ref having ref='$do_ref'";
						$result = $dbpdo->prepare($sql2);
						$result->execute();
						$data		= $result->fetch(PDO::FETCH_OBJ);

						$qty_si = $data->qty_si;
						$qty = $data->qty;

						if ($qty > 0) {
							if ($qty_si < $qty) {
								$sqlstr = "update delivery_order set status='I' where ref='$do_ref' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
							}

							if ($qty_si >= $qty) {
								$sqlstr = "update delivery_order set status='F' where ref='$do_ref' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
							}
						}
						##*****************************************##

					}
				}
			}


			$date				=	date("Y-m-d", strtotime($_POST["date"]));
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
			$deposit			=	numberreplace($_POST["deposit"]);
			$total				=	$sub_total + $freight_cost; //numberreplace($_POST["total"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into sales_invoice (ref, ref2, date, status, top, client_code, ship_to, bill_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, total, memo, opening_balance, deposit, taxable, uid, dlu) values('$ref', '$ref2', '$date', '$status', '$top', '$client_code', '$ship_to', '$bill_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$total', '$memo', 0, '$deposit', '$taxable', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//insert AR
			$total	=	$total - $deposit;
			$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$total', 0, 'SOI', 'SOI', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();


			if ($taxable == 1) {
				notran($date, 'frmcash_invoice2', 1, '', $_SESSION["location"]); //----eksekusi ref	
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert cash receipt
	function insert_cash_receipt($ref)
	{

		$dbpdo = DB::create();

		try {

			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$contact_type	=	$_POST["contact_type"];
			$contact_code	=	$_POST["contact_code"];

			if ($contact_type == "O") {
				$contact_name	=	$contact_code;
			}

			$memo1			= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$account_code 	= $_POST[account_code_ . $i];
				$debit_amount 	= numberreplace($_POST[debit_amount_ . $i]);
				$credit_amount 	= numberreplace($_POST[credit_amount_ . $i]);

				if (!empty($account_code) && ($debit_amount <> 0 || $credit_amount <> 0)) {
					$memo		 	= $_POST[memo_ . $i];
					$currency_code 	= $_POST[currency_code_ . $i];
					$rate 			= numberreplace($_POST[rate_ . $i]);

					$line = maxline('cash_receipt_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into cash_receipt_detail (ref, account_code, currency_code, rate, debit_amount, credit_amount, memo, line) values ('$ref', '$account_code', '$currency_code', '$rate', '$debit_amount', '$credit_amount', '$memo', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
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

			$sqlstr = "insert into cash_receipt (ref, date, status, contact_type, contact_code, contact_name, receipt_type, cheque_no, cheque_date, bank_name, credit_card_no, credit_card_code, credit_card_holder, credit_card_expired, account_code, currency_code, rate, amount, deposit, sub_total, type, memo, opening_balance, total, uid, dlu) values('$ref', '$date', '$status', '$contact_type', '$contact_code', '$contact_name', '$receipt_type', '$cheque_no', '$cheque_date', '$bank_name', '$credit_card_no', '$credit_card_code', '$credit_card_holder', '$credit_card_expired', '$account_code', '$currency_code', '$rate', '$amount', '$deposit', '$sub_total', '$type', '$memo1', '0', '$total', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			if ($receipt_type == "giro" || $receipt_type == "cheque") {

				//insert ARC
				$sqlstr = "insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$contact_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo1', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert cash payment
	function insert_cash_payment($ref)
	{

		$dbpdo = DB::create();

		try {

			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$contact_type	=	$_POST["contact_type"];
			$contact_code	=	$_POST["contact_code"];

			if ($contact_type == "O") {
				$contact_name	=	$contact_code;
			}

			$memo1			= 	$_POST["memo"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			//----------insert direct payment detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$account_code 	= $_POST[account_code_ . $i];
				$debit_amount 	= numberreplace($_POST[debit_amount_ . $i]);
				$credit_amount 	= numberreplace($_POST[credit_amount_ . $i]);

				if (!empty($account_code) && ($debit_amount <> 0 || $credit_amount <> 0)) {
					$memo		 	= $_POST[memo_ . $i];
					$currency_code 	= $_POST[currency_code_ . $i];
					$rate 			= numberreplace($_POST[rate_ . $i]);

					$line = maxline('cash_payment_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into cash_payment_detail (ref, account_code, currency_code, rate, debit_amount, credit_amount, memo, line) values ('$ref', '$account_code', '$currency_code', '$rate', '$debit_amount', '$credit_amount', '$memo', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
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

			/*
			$round_amount		=	numberreplace($_POST["round_amount"]);
			$round_amount_account	=	$_POST["round_amount_account"];
			if($round_amount == 0) {
				$round_amount_account = "";	
			}
			
			$bank_charge		=	numberreplace($_POST["bank_charge"]);
			$bank_charge_account	= 	$_POST["bank_charge_account"];
			if($bank_charge == 0) {
				$bank_charge_account = "";
			} */

			$sub_total			=	numberreplace($_POST["sub_total"]);
			$deposit			=	numberreplace($_POST["deposit"]);
			$type				=	$_POST["type"];

			$total				=	numberreplace($_POST["total"]);

			$sqlstr = "insert into cash_payment (ref, date, status, contact_type, contact_code, contact_name, payment_type, cheque_no, cheque_date, bank_name, credit_card_no, credit_card_code, credit_card_holder, credit_card_expired, account_code, currency_code, rate, amount, deposit, sub_total, type, memo, opening_balance, total, uid, dlu) values('$ref', '$date', '$status', '$contact_type', '$contact_code', '$contact_name', '$payment_type', '$cheque_no', '$cheque_date', '$bank_name', '$credit_card_no', '$credit_card_code', '$credit_card_holder', '$credit_card_expired', '$account_code', '$currency_code', '$rate', '$amount', '$deposit', '$sub_total', '$type', '$memo1', '0', '$total', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			if ($payment_type == "giro" || $payment_type == "cheque") {

				//insert APC
				$sqlstr = "insert into apc (ref, date, vendor_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$contact_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo1', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert week wage
	function insert_week_wage($ref)
	{

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
			$invoice_no		=	$_POST["invoice_no"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			//----------insert week wage detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];

			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$item_name 		= $_POST[item_name_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];
				$qty		 	= numberreplace($_POST[qty_ . $i]);
				$unit_price 	= numberreplace($_POST[unit_price_ . $i]);
				$amount		 	= numberreplace($_POST[amount_ . $i]);

				if (!empty($item_name) && !empty($uom_code) && $amount <> 0) {

					$line = maxline('week_wage_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into week_wage_detail (ref, item_name, uom_code, qty, unit_price, amount, line) values ('$ref', '$item_name', '$uom_code', '$qty', '$unit_price', '$amount', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$sub_total = $sub_total + $amount;
				}
			}

			$total	=	$sub_total - $installment + $loan; //numberreplace($_POST["total"]);

			$sqlstr = "insert into week_wage (ref, date, status, type, employee_id, memo, loan_balance, loan_total, installment, total, loan, invoice_no, uid, dlu) values('$ref', '$date', '$status', '$type', '$employee_id', '$memo', '$loan_balance', '$loan_total', '$installment', '$total', '$loan', '$invoice_no', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//insert AR
			if ($loan > 0) {

				$ref_type2 = "loan";
				$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$date', 'E', '$employee_id', '', '$loan', 0, 'loan', '$ref_type2', 'cx454', '0', '', '', '', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}

			if ($installment > 0) {
				$typec 			= "E";
				$client_code 	= $employee_id;
				$amount 		= $installment;
				$ref_type 		= "WEG";
				$currency_code 	= "cx454";
				$rate			= "0";
				$invoice_no		= $invoice_no;

				$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, discount_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$invoice_no', '$date', '$date', '$typec', '$client_code', '', 0, '$amount', '0', '$ref_type', 'loan', '$currency_code', '$rate', '', '', 'C.O.D', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			//----------end AR

		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}

	//-----insert purchase quick
	function insert_purchase_quick($ref)
	{

		$dbpdo = DB::create();

		try {

			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				//$po_ref 		= $_POST[po_ref_.$i];
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_cost = numberreplace($_POST[unit_cost_ . $i]);
					$amount = $qty * $unit_cost; //numberreplace($_POST[amount_.$i]);
					$line_item_po = (empty($_POST[line_item_po_ . $i])) ? 0 : $_POST[line_item_po_ . $i];

					$line = maxline('purchase_invoice_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into purchase_invoice_detail (ref, po_ref, item_code, uom_code, qty, unit_cost, amount, line_item_po, line) values ('$ref', '', '$item_code', '$uom_code', '$qty', '$unit_cost', '$amount', '0', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					//----------insert bincard (debit qty)
					$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_quick', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();


					$sub_total = $sub_total + $amount;
				}
			}



			$invoice_no			=	$_POST["invoice_no"];
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			$tax_code			= 	$_POST["tax_code"];
			$tax_rate			=	numberreplace((empty($_POST["tax_rate"])) ? 0 : $_POST["tax_rate"]);
			$freight_cost		=	numberreplace((empty($_POST["freight_cost"])) ? 0 : $_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$total				=	$sub_total + $freight_cost;
			$memo				= 	petikreplace($_POST["memo"]);
			$cash				= 	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));

			$sqlstr = "insert into purchase_invoice (ref, invoice_no, date, status, bill_number, vendor_code, top, due_date, tax_code, tax_rate, freight_cost, freight_account, memo, location_id, cash, total, uid, dlu) values('$ref', '$invoice_no', '$date', '$status', '$bill_number', '$vendor_code', '$top', '$due_date', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$memo', '$location_id', '$cash', '$total', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//insert AP
			if ($cash == 0) {

				$sqlstr = "insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'V', '$vendor_code', '', 0, '$total', 'PIQ', 'PIQ', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert purchase issued
	function insert_purchase_issue($ref)
	{

		$dbpdo = DB::create();

		try {

			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				//$po_ref 		= $_POST[po_ref_.$i];
				$item_name 		= $_POST[item_name_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_name) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_cost = numberreplace($_POST[unit_cost_ . $i]);
					$amount = $qty * $unit_cost; //numberreplace($_POST[amount_.$i]);
					$line_item_po = (empty($_POST[line_item_po_ . $i])) ? 0 : $_POST[line_item_po_ . $i];

					$line = maxline('purchase_invoice_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into purchase_invoice_detail (ref, po_ref, item_name, uom_code, qty, unit_cost, amount, line_item_po, line) values ('$ref', '', '$item_name', '$uom_code', '$qty', '$unit_cost', '$amount', '0', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					//----------insert bincard (debit qty)
					//$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_issue', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";				
					//QueryDbTrans($sql2, $success);


					$sub_total = $sub_total + $amount;
				}
			}



			$invoice_no			=	$_POST["invoice_no"];
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			$tax_code			= 	$_POST["tax_code"];
			$tax_rate			=	numberreplace((empty($_POST["tax_rate"])) ? 0 : $_POST["tax_rate"]);
			$freight_cost		=	numberreplace((empty($_POST["freight_cost"])) ? 0 : $_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$total				=	$sub_total + $freight_cost;
			$memo				= 	petikreplace($_POST["memo"]);
			$cash				= 	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));

			$sqlstr = "insert into purchase_invoice (ref, invoice_no, date, status, bill_number, vendor_code, top, due_date, tax_code, tax_rate, freight_cost, freight_account, memo, location_id, cash, total, uid, dlu) values('$ref', '$invoice_no', '$date', '$status', '$bill_number', '$vendor_code', '$top', '$due_date', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$memo', '$location_id', '$cash', '$total', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//insert AP
			if ($cash == 0) {

				$sqlstr = "insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'V', '$vendor_code', '', 0, '$total', 'PII', 'PII', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert BPOC
	function insert_bpoc()
	{

		$dbpdo = DB::create();

		try {

			$date		=	date("Y-m-d", strtotime($_POST["date"]));
			$pmt_ref	=	$_POST["pmt_ref"];
			$uid		=	$_SESSION["loginname"];
			$dlu		=	date("Y-m-d H:i:s");

			//----------insert item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$select 	= $_POST[select_ . $i];
				$line 		= $_POST[line_ . $i];

				if ($select == 1) {

					$sqlstr = "update apc set deposite=1, deposite_date='$dlu', deposite_by='$uid' where ref='$pmt_ref' and line='$line'";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert vehicle
	function insert_vehicle()
	{
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
			$photo2				= $_POST["photo2"];
			$uploaddir_photo 	= 'app/photo_vehicle/';
			$photo				= $_FILES['photo']['name'];
			$tmpname_photo 		= $_FILES['photo']['tmp_name'];
			$filesize_photo 	= $_FILES['photo']['size'];
			$filetype_photo 	= $_FILES['photo']['type'];

			if (empty($photo)) {
				$photo = $photo2;
			} else {
				$photo = $photo;
			}

			if ($photo != "") {
				$photo = $syscode . '_' . $photo;
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
			$syscode		= 	random(9);

			$sqlstr = "insert into vehicle (code, status, vendor_code, brand, type, no_rangka, no_mesin, jenis_bak, year, seri_unit, warna_kabin, no_bpkb, tanggal_bpkb, no_kir, tanggal_kir, gps, posisi_bpkb, ket_bpkb, insurance, location_id, capacity, tonase, photo, active, uid, dlu, syscode) values ('$code', '$status', '$vendor_code', '$brand', '$type', '$no_rangka', '$no_mesin', '$jenis_bak', '$year', '$seri_unit', '$warna_kabin', '$no_bpkb', '$tanggal_bpkb', '$no_kir', '$tanggal_kir', '$gps', '$posisi_bpkb', '$ket_bpkb', '$insurance', '$location_id', '$capacity', '$tonase', '$photo', '$active', '$uid', '$dlu', '$syscode')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}



	//-----insert asset type
	function insert_asset_type()
	{
		$dbpdo = DB::create();

		try {

			$type			=	$_POST["type"];
			$active			=	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			$sqlstr = "insert into asset_type (type, active, uid, dlu) values ('$type', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert asset
	function insert_asset($ref = '')
	{
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
			$shm			    =	$_POST["shm"];
			$shm_nama		    =	$_POST["shm_nama"];
			$ajb			    =	$_POST["ajb"];
			$pbb			    =	$_POST["pbb"];
			$keterangan			=	petikreplace($_POST["keterangan"]);
			$active			    =	(empty($_POST["active"])) ? 0 : $_POST["active"];
			$uid			    =	$_SESSION["loginname"];
			$dlu			    =	date("Y-m-d H:i:s");

			/*create folder*/
			$photo_asset = 'app/photo_asset/' . $ref;
			if (!file_exists($photo_asset) && !is_dir($photo_asset)) {
				@mkdir($photo_asset, 0777, true);
				@chmod('app/photo_asset', 0777);
				@chmod($photo_asset, 0777);
			}

			//-----------upload file
			$photo2				= $_POST["photo2"];
			$uploaddir_photo	= $photo_asset . '/';
			$photo				= $_FILES['photo']['name'];
			$tmpname_photo 		= $_FILES['photo']['tmp_name'];
			$filesize_photo 	= $_FILES['photo']['size'];
			$filetype_photo 	= $_FILES['photo']['type'];

			if (empty($photo)) {
				$photo = $photo2;
			} else {
				$photo = $photo;
			}

			if ($photo != "") {
				$photo = $ref . '_' . $photo;
				$uploaddir_photo = $uploaddir_photo . $photo;
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo']['tmp_name'], $uploaddir_photo)) {
					echo "";
				}
			}

			/*upload file-1*/
			$photo_12			= $_POST["photo_12"];
			$uploaddir_photo_1	= $photo_asset . '/';
			$photo_1			= $_FILES['photo_1']['name'];
			$tmpname_photo_1 	= $_FILES['photo_1']['tmp_name'];
			$filesize_photo_1 	= $_FILES['photo_1']['size'];
			$filetype_photo_1 	= $_FILES['photo_1']['type'];

			if (empty($photo_1)) {
				$photo_1 = $photo_12;
			} else {
				$photo_1 = $photo_1;
			}

			if ($photo_1 != "") {
				$photo_1 = $ref . '_' . $photo_1;
				$uploaddir_photo_1 = $uploaddir_photo_1 . $photo_1;
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo_1']['tmp_name'], $uploaddir_photo_1)) {
					echo "";
				}
			}


			/*upload file-2*/
			$photo_22			= $_POST["photo_22"];
			$uploaddir_photo_2	= $photo_asset . '/';
			$photo_2			= $_FILES['photo_2']['name'];
			$tmpname_photo_2 	= $_FILES['photo_2']['tmp_name'];
			$filesize_photo_2 	= $_FILES['photo_2']['size'];
			$filetype_photo_2 	= $_FILES['photo_2']['type'];

			if (empty($photo_2)) {
				$photo_2 = $photo_22;
			} else {
				$photo_2 = $photo_2;
			}

			if ($photo_2 != "") {
				$photo_2 = $ref . '_' . $photo_2;
				$uploaddir_photo_2 = $uploaddir_photo_2 . $photo_2;
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo_2']['tmp_name'], $uploaddir_photo_2)) {
					echo "";
				}
			}


			/*upload file-3*/
			$photo_32			= $_POST["photo_32"];
			$uploaddir_photo_3	= $photo_asset . '/';
			$photo_3			= $_FILES['photo_3']['name'];
			$tmpname_photo_3 	= $_FILES['photo_3']['tmp_name'];
			$filesize_photo_3 	= $_FILES['photo_3']['size'];
			$filetype_photo_3 	= $_FILES['photo_3']['type'];

			if (empty($photo_3)) {
				$photo_3 = $photo_32;
			} else {
				$photo_3 = $photo_3;
			}

			if ($photo_3 != "") {
				$photo_3 = $ref . '_' . $photo_3;
				$uploaddir_photo_3 = $uploaddir_photo_3 . $photo_3;
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo_3']['tmp_name'], $uploaddir_photo_3)) {
					echo "";
				}
			}


			/*upload file-4*/
			$photo_42			= $_POST["photo_42"];
			$uploaddir_photo_4	= $photo_asset . '/';
			$photo_4			= $_FILES['photo_4']['name'];
			$tmpname_photo_4 	= $_FILES['photo_4']['tmp_name'];
			$filesize_photo_4 	= $_FILES['photo_4']['size'];
			$filetype_photo_4 	= $_FILES['photo_4']['type'];

			if (empty($photo_4)) {
				$photo_4 = $photo_42;
			} else {
				$photo_4 = $photo_4;
			}

			if ($photo_4 != "") {
				$photo_4 = $ref . '_' . $photo_4;
				$uploaddir_photo_4 = $uploaddir_photo_4 . $photo_4;
				// proses upload file ke folder 'data'
				if (move_uploaded_file($_FILES['photo_4']['tmp_name'], $uploaddir_photo_4)) {
					echo "";
				}
			}

			//----------------
			$sqlstr = "insert into asset (ref, asset_name, alias, ref_id, lokasi, provinsi_kode, kota_kode, kecamatan_kode, desa_kode, asset_type_id, status, luas, sertifikat, imb, tanggal_perolehan, pemilik_sebelum, contact_name, no_pbb, group_block, alamat, lintang, bujur, nilai_perolehan, nilai_amnesti, pemilik_sekarang, photo, photo_1, photo_2, photo_3, photo_4, shm, shm_nama, ajb, pbb, keterangan, active, uid, dlu) values ('$ref', '$asset_name', '$alias', '$ref_id', '$lokasi', '$provinsi_kode', '$kota_kode', '$kecamatan_kode', '$desa_kode', '$asset_type_id', '$status', '$luas', '$sertifikat', '$imb', '$tanggal_perolehan', '$pemilik_sebelum', '$contact_name', '$no_pbb', '$group_block', '$alamat', '$lintang', '$bujur', '$nilai_perolehan', '$nilai_amnesti', '$pemilik_sekarang', '$photo', '$photo_1', '$photo_2', '$photo_3', '$photo_4', '$shm', '$shm_nama', '$ajb', '$pbb', '$keterangan', '$active', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert asset trans
	function insert_asset_trans($ref = '')
	{
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

			$sqlstr = "insert into asset_trans (ref, tanggal, asset_id, penyewa, lama_sewa, akhir_sewa, harga_sewa, alamat, hp, uid, dlu) values ('$ref', '$tanggal', '$asset_id', '$penyewa', '$lama_sewa', '$akhir_sewa', '$harga_sewa', '$alamat', '$hp', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}



	//-----insert cashier detail
	function insert_cashier_detail($ref)
	{

		$dbpdo = DB::create();

		try {

			$ref2 			= $_POST['ref2'];
			$date			= date("Y-m-d", strtotime($_POST['date']));
			$due_date		= date("Y-m-d", strtotime($_POST['due_date']));
			$location_id	= $_POST['location_id'];
			$item_code 		= $_POST['item_code'];
			$item_code2		= $_POST['item_code2'];
			$item_name2		= petikreplace($_POST['item_name2']);
			$uom_code 		= $_POST['uom_code'];
			$non_discount 	= (empty($_POST['non_discount'])) ? 0 : $_POST['non_discount'];

			$qty 		    = numberreplace($_POST['qty']);
			$unit_price     = numberreplace($_POST['unit_price']);
			$amount 	    = numberreplace($_POST['amount']);

			$cash			=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];

			//-------------------cek customer baru----\/
			$newclient		=	(empty($_POST["newclient"])) ? 0 : $_POST["newclient"];
			$client_code	=	petikreplace($_POST["client_code"]);

			if ($newclient == 1) {

				$sqlcek 	= 	"select code from client where name='$client_code' ";
				$resultcek = $dbpdo->prepare($sqlcek);
				$resultcek->execute();
				$numcek		= $resultcek->rowCount();

				if ($numcek == 0) {
					$syscode	= 	random(15);
					$date_cln	=	date('Y-m-d');

					$code		=	notran($date_cln, 'frmclient_pos', '', '', ''); //---get no ref
					//$code		=	substr($client_code,0,3) . $syscode;
					$phone		=	$_POST['phone'];
					$ship_to	=	petikreplace($_POST['ship_to']);

					//-------get client type
					$sqlclntype 	= 	"select id from client_type order by id limit 1 ";
					$resultclntype = $dbpdo->prepare($sqlclntype);
					$resultclntype->execute();
					$dataclntype		= $resultclntype->fetch(PDO::FETCH_OBJ);

					$client_type	=	$dataclntype->id;
					//------------------/\

					$location_id2 = $_SESSION['location_id2'];
					$sqlstr 	=	"insert into client (code, name, contact_person, client_type, ship_to, bill_to, phone, address, active, syscode, location_id, uid, dlu) values ('$code', '$client_code', '$client_code', '$client_type', '$ship_to', '$bill_to', '$phone', '$ship_to', 1, '$syscode', '$location_id2', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					notran($date_cln, 'frmclient_pos', 1, '', ''); //----eksekusi ref

					$client_code =	$syscode;
				} else {
					$sqlcek 	= 	"select syscode from client where name='$client_code' ";
					$resultcek = $dbpdo->prepare($sqlcek);
					$resultcek->execute();
					$datacek		= $resultcek->fetch(PDO::FETCH_OBJ);

					$client_code =	$datacek->syscode;
				}
			}
			//----------------------/\-end cek customer


			//----------jika lookup gagal enter
			$sqlstr 	= "select syscode, uom_code_sales uom_code from item where code='$item_code2' limit 1";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$data 	= $sql->fetch(PDO::FETCH_OBJ);

			if ($item_code == '') {
				$item_code 	= $data->syscode;
			}

			if ($uom_code == '') {
				$uom_code	= $data->uom_code;
			}


			$sqlprice = "select b.current_price, a.name, ifnull(b.non_discount,0) non_discount from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' order by b.date_of_record desc limit 1 ";
			$resultprice = $dbpdo->prepare($sqlprice);
			$resultprice->execute();
			$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

			if ($unit_price == '' || $unit_price == 0) {
				$unit_price	= $dataprice->current_price;
			}

			if ($qty == '' || $qty == 0) {
				$qty = 1;
			}

			if ($amount == '' || $amount == 0) {
				$amount			= $dataprice->current_price * 1;
			}

			$non_discount	= $dataprice->non_discount;
			//---------------------------------/\


			if (empty($item_code) && empty($uom_code)) {
				$sqlstr 	    = "select syscode, uom_code_sales uom_code from item where code='$item_code2' limit 1";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$data		= $sql->fetch(PDO::FETCH_OBJ);

				$item_code  = $data->syscode;
				$uom_code   = $data->uom_code;

				$sqlprice = "select b.current_price, a.name, ifnull(b.non_discount,0) non_discount from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' and b.location_id='$location_id' order by b.date_of_record desc limit 1 ";
				$resultprice = $dbpdo->prepare($sqlprice);
				$resultprice->execute();
				$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

				$unit_price	    = $dataprice->current_price;
				$qty            = 1;
				$amount         = $unit_price * $qty;
				$non_discount	= $dataprice->non_discount;
			}

			if (!empty($item_code) && !empty($uom_code)) {

				$discount 	= numberreplace($_POST['discount_det']);
				$discount2 	= numberreplace($_POST['discount']);
				$discount3 	= numberreplace($_POST['discount3_det']);
				$deposit 	= numberreplace($_POST['deposit']);
				$total	 	= numberreplace($_POST['total']);
				$note		= petikreplace($_POST['note']);

				$uid		= $_SESSION["loginname"];

				//----------insert/update set_item_price (ditutup krn harga di seting di set item price aja)
				/*$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
				$resultprice = mysql_query($sqlprice);
				$numprice = mysql_num_rows($resultprice);
				*/

				/*if($numprice == 0) {
					$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
					$resultprice2 = mysql_query($sqlprice2);
					$dataprice = mysql_fetch_object($resultprice2);
				
					$last_price			=	$dataprice->current_price;
					$date_of_record		=	date("Y-m-d H:i:s");
					
					$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, location_id, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$location_id', '$uid', '$dlu')";				
					QueryDbTrans($sql2, $success);
				}	*/
				//------------------------------------/\

				$line = maxline('sales_invoice_tmp', 'line', 'ref', $ref, '');

				$sqlstr = "insert into sales_invoice_tmp (ref, ref2, date, due_date, client_code, cash, item_code, item_name2, uom_code, qty, discount, unit_price, amount, discount2, discount3, deposit, total, non_discount, note, uid, line) values ('$ref', '$ref2', '$date', '$due_date', '$client_code', '$cash', '$item_code', '$item_name2', '$uom_code', '$qty', '$discount', '$unit_price', '$amount', '$discount2', '$discount3', '$deposit', '$total', '$non_discount', '$note', '$uid', $line)";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert cashier
	function insert_cashier($ref, $xndf)
	{

		$dbpdo = DB::create();

		try {

			$status			= 	"R";
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$cash			=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {

					$item_name2 = petikreplace($_POST[item_name2_ . $i]);
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_price = numberreplace($_POST[unit_price_ . $i]);
					$discount = numberreplace($_POST[discount_ . $i]);
					$discount3 = numberreplace($_POST[discount3_ . $i]);
					$amount = numberreplace($_POST[amount_ . $i]);
					$non_discount = (empty($_POST[non_discount_ . $i])) ? 0 : $_POST[non_discount_ . $i];
					$note = petikreplace($_POST[note_ . $i]);

					$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into sales_invoice_detail (ref, item_code, item_name2, uom_code, qty, discount, discount3, unit_price, amount, non_discount, note, line) values ('$ref', '$item_code', '$item_name2', '$uom_code', '$qty', '$discount', '$discount3', '$unit_price', '$amount', '$non_discount', '$note', '$line')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					//----------insert bincard (debit qty)
					$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'cashier', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();


					//----------insert/update set_item_price
					/*$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
					$resultprice = mysql_query($sqlprice);
					$numprice = mysql_num_rows($resultprice);
					
					if($numprice == 0) {
						$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
						$resultprice2 = mysql_query($sqlprice2);
						$dataprice = mysql_fetch_object($resultprice2);
					
						$last_price			=	$dataprice->current_price;
						$date_of_record		=	date("Y-m-d H:i:s");
						
						$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, location_id, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$location_id', '$uid', '$dlu')";				
						QueryDbTrans($sql2, $success);
					} */
					//------------------------------------/\


					$sub_total = $sub_total + $amount;
				}
			}



			//----get client cash
			/*
				$sqlcek 	= 	"select syscode from client where name='cash' limit 1 ";
				$resultcek	=	mysql_query($sqlcek);
				$datacek	=	mysql_fetch_object($resultcek);			
				$client_code =	$datacek->syscode;
				*/

			$newclient		=	(empty($_POST["newclient"])) ? 0 : $_POST["newclient"];
			$client_code	=	$_POST["client_code"];

			if ($newclient == 1) {
				//-------------------cek customer baru----\/		
				$sqlcek 	= 	"select code from client where name='$client_code' ";
				$resultcek = $dbpdo->prepare($sqlcek);
				$resultcek->execute();
				$numcek		= $resultcek->rowCount();

				if ($numcek == 0) {
					$syscode	= 	random(9);
					$code		=	substr($client_code, 0, 3) . $syscode;
					$phone		=	$_POST['phone'];

					//-------get client type
					$sqlclntype 	= 	"select id from client_type order by id limit 1 ";
					$resultclntype = $dbpdo->prepare($sqlclntype);
					$resultclntype->execute();
					$dataclntype		= $resultclntype->fetch(PDO::FETCH_OBJ);

					$client_type	=	$dataclntype->id;
					//------------------/\

					$location_id2 = $_SESSION['location_id2'];
					$sqlstr 	=	"insert into client (code, name, contact_person, client_type, ship_to, bill_to, phone, address, active, syscode, location_id, uid, dlu) values ('$code', '$client_code', '$client_code', '$client_type', '$ship_to', '$bill_to', '$phone', '$ship_to', 1, '$syscode', '$location_id2', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$client_code =	$syscode;
				} else {
					$sqlcek 	= 	"select syscode from client where name='$client_code' ";
					$resultcek = $dbpdo->prepare($sqlcek);
					$resultcek->execute();
					$datacek		= $resultcek->fetch(PDO::FETCH_OBJ);

					$client_code =	$datacek->syscode;
				}
				//----------------------/\-end cek customer
			}


			$ref2				=	$_POST["ref2"];
			$employee_id		= 	0;
			$top				=	"C.O.D";
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));
			$tax_code			=	"";
			$tax_rate			=	0;
			$freight_cost 		= 	0;
			$freight_account	= 	"";
			$currency_code		=	"";
			$rate				=	0;
			$memo				= 	petikreplace($_POST["memo"]);
			$discount2			=	numberreplace($_POST["discount"]);
			$total				=	numberreplace($_POST["total"]); //$sub_total; 
			$deposit			=	numberreplace($_POST["deposit"]);
			$total_member		=	numberreplace($_POST["total"]);

			$photo_file			= 	"";

			$cash_amount		=	numberreplace($_POST["cash_amount"]);
			$bank_id			=	(empty($_POST["bank_id"])) ? 0 : $_POST["bank_id"];
			$bank_amount		=	numberreplace($_POST["bank_amount"]);
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$card_amount		=	numberreplace($_POST["card_amount"]);
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_holder	=	petikreplace($_POST["credit_card_holder"]);
			$change_amount		=	numberreplace($_POST["change_amount"]);

			$cash_voucher 		= 	numberreplace($_POST["cash_voucher"]);
			$ovo 				=	numberreplace($_POST["ovo"]);
			$gopay 				=	numberreplace($_POST["gopay"]);

			$sqlstr = "delete from sales_invoice_tmp where ref='$xndf'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			$sqlstr = "insert into sales_invoice (ref, ref2, date, status, top, due_date, client_code, ship_to, bill_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, discount, total, memo, opening_balance, cash, location_id, deposit, taxable, photo_file, cash_amount, bank_id, bank_amount, credit_card_code, card_amount, credit_card_no, credit_card_holder, change_amount, cash_voucher, ovo, gopay, uid, dlu) values('$ref', '$ref2', '$date', '$status', '$top', '$due_date', '$client_code', '$ship_to', '$bill_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$discount2', '$total', '$memo', 0, '$cash', '$location_id', '$deposit', '$taxable', '$photo_file', '$cash_amount', '$bank_id', '$bank_amount', '$credit_card_code', '$card_amount', '$credit_card_no', '$credit_card_holder', '$change_amount', '$cash_voucher', '$ovo', '$gopay', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			##jika piutang
			if ($cash == 0) {

				$total = $total - $deposit;
				//insert AR
				$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$total', 0, 'cashier', 'cashier', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			//-----------

			if ($bank_amount > 0) {

				$sqlbnk = "select name, account_code, account_coa from bank where id='$bank_id' ";
				$result = $dbpdo->prepare($sqlbnk);
				$result->execute();
				$data		= $result->fetch(PDO::FETCH_OBJ);

				$cheque_no		= $data->account_code;
				$bank_name		= $data->name;
				$receipt_type	= "transfer";
				$cheque_date	= $date;
				$total			= $bank_amount;
				$account_code	= $data->account_coa;

				//insert ARC
				$sqlstr = "insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}

			if ($card_amount > 0) {

				$sqlbnk = "select name, account_code from credit_card_type where code='$credit_card_code' ";
				$result = $dbpdo->prepare($sqlbnk);
				$result->execute();
				$data		= $result->fetch(PDO::FETCH_OBJ);

				$cheque_no		= $credit_card_no;
				$bank_name		= $data->name;
				$receipt_type	= "card";
				$cheque_date	= $date;
				$total			= $card_amount;
				$account_code	= $data->account_code;

				//insert ARC
				$sqlstr = "insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				//-------delete invoice detail tmp
				$sqlstr = "delete from sales_invoice_tmp where uid='$uid' ";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}


			/*
				//----------insert client member detail-------------\/
				$jumlahmember = (empty($_POST['jumlahmember'])) ? 0 : $_POST['jumlahmember'];
				$i = 0;
				$amount_member = $_POST["amount_member"];
				for ($i=0; $i<=$jumlahmember; $i++) {
					$discmember		= numberreplace($_POST[discmember.$i]);
					$memberlimit	= numberreplace($_POST[memberlimit.$i]);
					
					$sql3 = "insert into sales_invoice_discount_detail (ref, discmember, memberlimit, amount_member, line) values ('$ref', '$discmember', '$memberlimit', '$amount_member', '$i')";
					QueryDbTrans($sql3, $success);
					
				}				
				if($amount_member > 0) {
					$sql4 = "insert into sales_invoice_discount (ref, client_code, date, amount) values ('$ref', '$client_code', '$date', '$total_member')";
					QueryDbTrans($sql4, $success);
				}
				//---------------------------------------------------/\
	            */
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----update set item price
	function insert_set_item_price($ref)
	{
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
			$uploaddir_photo = 'app/photo_item/';
			$photo			= $_FILES['photo']['name'];
			$tmpname_photo 	= $_FILES['photo']['tmp_name'];
			$filesize_photo = $_FILES['photo']['size'];
			$filetype_photo = $_FILES['photo']['type'];

			if (empty($photo)) {
				$photo = $photo2;
			} else {
				$photo = $photo;
			}

			if ($photo != "") {

				if ($photo != $photo2) {

					if (!empty($photo2)) {
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

			$sqlstr = "update item set code='$code', old_code='$old_code', name='$name', item_group_id='$item_group_id', item_subgroup_id='$item_subgroup_id', item_type_code='$item_type_code', item_category_id='$item_category_id', brand_id='$brand_id', size_id='$size_id', uom_code_stock='$uom_code_stock', uom_code_sales='$uom_code_sales', uom_code_purchase='$uom_code_purchase', minimum_stock='$minimum_stock', maximum_stock='$maximum_stock', photo='$photo', consigned='$consigned',  active='$active', uid='$uid', dlu='$dlu' where syscode='$ref'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();



			#insert/update set item cost
			$item_code	=	$ref;
			$uom_code	=	$uom_code_purchase;
			$current_cost	=	numberreplace($_POST['current_cost']);
			$date_cost		=	date("Y-m-d", strtotime($_POST['date_cost']));
			$efective_from_cost	=	date("Y-m-d", strtotime($_POST['efective_from_cost']));
			$old_date_of_record_cost = date("Y-m-d", strtotime($_POST['old_date_cost']));

			if ($date_cost == "1970-01-01") {
				$date_cost = date("Y-m-d");
			}

			if ($efective_from_cost == "1970-01-01") {
				$efective_from_cost = date("Y-m-d");
			}


			$date_of_record	=	date("Y-m-d H:i:s");
			$location_id_cost	=	$_POST['location_id_cost'];

			$sqlstr = "select item_code, current_cost from set_item_cost where item_code='$item_code' and uom_code='$uom_code' and current_cost='$current_cost'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows = $sql->rowCount();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$last_cost = $data->current_cost;

			if ($rows == 0) {
				$sqlstr = "insert into set_item_cost (date, efective_from, item_code, uom_code, current_cost, last_cost, date_of_record, location_id, uid, dlu) values('$date_cost', '$efective_from_cost', '$item_code', '$uom_code', '$current_cost', '$last_cost', '$date_of_record', '$location_id_cost', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				$sqlstr = "update set_item_cost set date='$date_cost', efective_from='$efective_from_cost', uom_code='$uom_code', current_cost='$current_cost', last_cost='$last_cost', date_of_record='$date_of_record', location_id='$location_id_cost', uid='$uid', dlu='$dlu' where item_code='$item_code' and uom_code='$uom_code' and date_format(date_of_record, '%Y-%m-%d')='$old_date_of_record_cost'";
				$sql = $dbpdo->prepare($sqlstr);
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

			if ($date == "1970-01-01") {
				$date = date("Y-m-d");
			}
			if ($efective_from == "1970-01-01") {
				$efective_from = date("Y-m-d");
			}

			$date_of_record	=	date("Y-m-d H:i:s");
			$location_id	=	$_POST['location_id'];
			$non_discount	=	$_POST['non_discount'];
			$qty1			=	numberreplace($_POST['qty1']);
			$qty2			=	numberreplace($_POST['qty2']);
			$qty3			=	numberreplace($_POST['qty3']);
			$qty4			=	numberreplace($_POST['qty4']);

			$old_date_of_record = date("Y-m-d H:i:s", strtotime($_POST["old_date"]));

			$sqlstr = "select item_code, current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$current_price'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows = $sql->rowCount();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$last_price = $data->current_price;

			if ($rows == 0) {
				$sqlstr = "insert into set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				//audit trail insert
				$sqlstr = "insert into adt_set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu, adt_status) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu', 'insert')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			} else {
				$sqlstr = "update set_item_price set date='$date', efective_from='$efective_from', uom_code='$uom_code', current_price='$current_price', current_price1='$current_price1', current_price2='$current_price2', current_price3='$current_price3', last_price='$last_price', date_of_record='$date_of_record', location_id='$location_id', non_discount='$non_discount', qty1='$qty1', qty2='$qty2', qty3='$qty3', qty4='$qty4', uid='$uid', dlu='$dlu' where item_code='$item_code' and uom_code='$uom_code' and date_of_record='$old_date_of_record'";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				//update audit trail
				$sqlstr = "insert into adt_set_item_price (date, efective_from, item_code, uom_code, current_price, current_price1, current_price2, current_price3, last_price, date_of_record, location_id, non_discount, qty1, qty2, qty3, qty4, uid, dlu, adt_status) values('$date', '$efective_from', '$item_code', '$uom_code', '$current_price', '$current_price1', '$current_price2', '$current_price3', '$last_price', '$date_of_record', '$location_id', '$non_discount', '$qty1', '$qty2', '$qty3', '$qty4', '$uid', '$dlu', 'update')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//=============================
	//-----insert pos detail
	function insert_pos_detail($ref)
	{

		$dbpdo = DB::create();

		try {

			$dlu			=	date("Y-m-d H:i:s");
			$location_id	= $_POST['location_id'];
			$item_code 		= $_POST['item_code'];
			$item_code2		= $_POST['item_code2'];
			$uom_code 		= $_POST['uom_code'];
			$non_discount 	= (empty($_POST['non_discount'])) ? 0 : $_POST['non_discount'];

			$qty 		    = numberreplace($_POST['qty']);
			$unit_price     = numberreplace($_POST['unit_price']);
			$amount 	    = numberreplace($_POST['amount']);

			$cash			=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];

			//-------------------cek customer baru----\/
			$newclient		=	(empty($_POST["newclient"])) ? 0 : $_POST["newclient"];
			$client_code	=	$_POST["client_code"];
			$location_id2 	= 	$_SESSION['location_id2'];

			if ($newclient == 1) {

				$sqlcek 	= 	"select code from client where name='$client_code' ";
				$resultcek = $dbpdo->prepare($sqlcek);
				$resultcek->execute();
				$numcek		= $resultcek->rowCount();

				if ($numcek == 0) {
					$syscode	= 	random(9);
					$code		=	substr($client_code, 0, 3) . $syscode;
					$phone		=	$_POST['phone'];

					//-------get client type
					$sqlclntype 	= 	"select id from client_type order by id limit 1 ";
					$resultclntype = $dbpdo->prepare($sqlclntype);
					$resultclntype->execute();
					$dataclntype		= $resultclntype->fetch(PDO::FETCH_OBJ);

					$client_type	=	$dataclntype->id;
					//------------------/\

					$sqlstr 	=	"insert into client (code, name, contact_person, client_type, ship_to, bill_to, phone, address, active, syscode, location_id, uid, dlu) values ('$code', '$client_code', '$client_code', '$client_type', '$ship_to', '$bill_to', '$phone', '$ship_to', 1, '$syscode', '$location_id2', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$client_code =	$syscode;
				} else {
					$sqlcek 	= 	"select syscode from client where name='$client_code' ";
					$resultcek = $dbpdo->prepare($sqlcek);
					$resultcek->execute();
					$datacek		= $resultcek->fetch(PDO::FETCH_OBJ);

					$client_code =	$datacek->syscode;
				}
			}
			//----------------------/\-end cek customer

			//cek barcode (jika ada petik artinya barang tersebut didiscount krn mau expired)
			$ref_near_expired	= "";
			$item_code_expired  = "";
			if (preg_match("/`/", $item_code2) == 1) {
				$item_code_expired = $item_code2;
			}
			if ($item_code_expired != "") {
				$item_code_exp 		= explode('`', $item_code_expired);
				$item_code2			= $item_code_exp[0];
				$ref_near_expired	= $item_code_exp[1];
			}
			//----------/\-------------------

			//----------jika lookup gagal enter
			if ($item_code2 == "") {
				$sqlstr 	= "select syscode, uom_code_sales uom_code from item where code='$item_code2' limit 1";
			} else {
				$sqlstr 	= "select syscode, uom_code_sales uom_code from item where (code='$item_code2' or old_code='$item_code2') limit 1";
			}

			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$data 	= $sql->fetch(PDO::FETCH_OBJ);

			if ($item_code == '' || $item_code != '') {
				$item_code 	= $data->syscode;
			}

			if ($uom_code == '') {
				$uom_code	= $data->uom_code;
			}


			$sqlprice = "select b.current_price, a.name, ifnull(b.non_discount,0) non_discount, b.end_date_discount, b.discount, b.discount_percent, b.qty1 from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' and b.location_id='$location_id2' order by b.date_of_record desc limit 1 ";
			$resultprice = $dbpdo->prepare($sqlprice);
			$resultprice->execute();
			$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

			if ($unit_price == '' || $unit_price == 0) {

				$unit_price	= $dataprice->current_price;

				if ($unit_price == '' || $unit_price == 0) {
					$sqlprice = "select b.current_price, a.name, ifnull(b.non_discount,0) non_discount, b.end_date_discount, b.discount, b.discount_percent, b.qty1 from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' order by b.date_of_record desc limit 1 ";
					$resultprice = $dbpdo->prepare($sqlprice);
					$resultprice->execute();
					$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

					$unit_price	= $dataprice->current_price;
				}
			}

			if ($qty == '' || $qty == 0) {
				$qty = 1;
			}

			$qty1 			= $dataprice->qty1;
			$non_discount	= $dataprice->non_discount;
			//---------------------------------/\

			//get discount
			$discount			= 0;
			$discount2			= 0;
			$discount_percent	= 0;
			$date_now = date("Y-m-d");
			$end_date_discount	= $dataprice->end_date_discount;
			if ($date_now <= $dataprice->end_date_discount && $qty >= $dataprice->qty1) {
				$discount			= $dataprice->discount;
				$discount2			= $dataprice->discount;
				$discount_percent	= $dataprice->discount_percent;
			}
			if ($date_now <= $dataprice->end_date_discount && $dataprice->non_discount > 0) {
				$discount			= $dataprice->discount;
				$discount2			= $dataprice->discount;
				$discount_percent	= $dataprice->discount_percent;
			}
			//------/\---------

			//get discount (near expired)
			if ($ref_near_expired != "") {
				$item_code_exp = $item_code;

				$sqlexp = "select b.end_date, a.syscode, a.discount, a.discount_percent from item_near_expired_detail a left join item_near_expired b on a.ref=b.ref where a.item_code='$item_code' and a.uom_code='$uom_code' and b.location_id='$location_id2' and '$date_now' <= b.end_date and a.syscode='$ref_near_expired' order by a.syscode desc limit 1 ";
				$resultexp = $dbpdo->prepare($sqlexp);
				$resultexp->execute();
				$countexp = $resultexp->rowCount();
				$dataexp = $resultexp->fetch(PDO::FETCH_OBJ);
				if ($countexp > 0) {
					$discount 			= $dataexp->discount;
					$discount2 			= $dataexp->discount;
					$discount_percent	= $dataexp->discount_percent;
					$end_date_discount	= $dataexp->end_date;
				}
			}
			//------/\---------

			if ($amount == '' || $amount == 0) {
				$amount			= ($dataprice->current_price - $discount) * 1;
			}

			if (empty($item_code) && empty($uom_code)) {
				$sqlstr 	    = "select syscode, uom_code_sales uom_code from item where code='$item_code2' limit 1";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$data		= $sql->fetch(PDO::FETCH_OBJ);

				$item_code  = $data->syscode;
				$uom_code   = $data->uom_code;

				$sqlprice = "select b.current_price, a.name, ifnull(b.non_discount,0) non_discount, b.end_date_discount, b.discount, b.discount_percent, b.qty1 from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' and b.location_id='$location_id2' order by b.date_of_record desc limit 1 ";
				//and b.location_id='$location_id' 
				$resultprice = $dbpdo->prepare($sqlprice);
				$resultprice->execute();
				$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

				$qty1 	= $dataprice->qty1;

				if ($unit_price == '' || $unit_price == 0) {
					$unit_price	    = $dataprice->current_price;

					if ($unit_price == '' || $unit_price == 0) {

						$sqlprice = "select b.current_price, a.name, ifnull(b.non_discount,0) non_discount, b.end_date_discount, b.discount, b.discount_percent, b.qty1 from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' order by b.date_of_record desc limit 1 ";
						//and b.location_id='$location_id' 
						$resultprice = $dbpdo->prepare($sqlprice);
						$resultprice->execute();
						$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

						$qty1 	= $dataprice->qty1;
					}
				}

				//get discount
				$discount			= 0;
				$discount2			= 0;
				$discount_percent	= 0;
				$date_now = date("Y-m-d");
				$end_date_discount	= $dataprice->end_date_discount;
				if ($date_now <= $dataprice->end_date_discount && $qty >= $dataprice->qty1) {
					$discount			= $dataprice->discount;
					$discount2			= $dataprice->discount;
					$discount_percent	= $dataprice->discount_percent;
				}
				if ($date_now <= $dataprice->end_date_discount && $dataprice->non_discount > 0) {
					$discount			= $dataprice->discount;
					$discount2			= $dataprice->discount;
					$discount_percent	= $dataprice->discount_percent;
				}
				//------/\---------

				//get discount (near expired)
				if ($ref_near_expired != "") {
					$item_code_exp = $item_code;

					$sqlexp = "select b.end_date, a.syscode, a.discount, a.discount_percent from item_near_expired_detail a left join item_near_expired b on a.ref=b.ref where a.item_code='$item_code' and a.uom_code='$uom_code' and b.location_id='$location_id2' and '$date_now' <= b.end_date and a.syscode='$ref_near_expired' order by a.syscode desc limit 1 ";
					$resultexp = $dbpdo->prepare($sqlexp);
					$resultexp->execute();
					$countexp = $resultexp->rowCount();
					$dataexp = $resultexp->fetch(PDO::FETCH_OBJ);
					if ($countexp > 0) {
						$discount 			= $dataexp->discount;
						$discount2 			= $dataexp->discount;
						$discount_percent	= $dataexp->discount_percent;
						$end_date_discount	= $dataexp->end_date;
					}
				}
				//------/\---------

				$qty            = 1;
				$amount         = ($unit_price - $discount) * $qty;
				$non_discount	= $dataprice->non_discount;
			}

			if (!empty($item_code) && !empty($uom_code)) {

				//$discount 	= numberreplace($_POST['discount_det']);			
				$discount2 	= numberreplace($_POST['discount']);
				$discount3 	= numberreplace($_POST['discount3_det']);
				$deposit 	= numberreplace($_POST['deposit']);
				$total	 	= numberreplace($_POST['total']);

				$uid		= $_SESSION["loginname"];

				$sqlstr = "select sum(qty) qty, item_code from sales_invoice_tmp where ref='$ref' and client_code='$client_code' and item_code='$item_code' and uom_code='$uom_code' and ifnull(ref_near_expired,'')='$ref_near_expired' group by ref, client_code, item_code, uom_code, ifnull(ref_near_expired,'')";
				$sqlx = $dbpdo->prepare($sqlstr);
				$sqlx->execute();
				$rows = $sqlx->rowCount();
				$data = $sqlx->fetch(PDO::FETCH_OBJ);

				if ($rows > 0) {
					$qty = numberreplace($data->qty) + 1;

					##cek jmlh qty, krn berpengaruh harga jual
					$datenow = date("Y-m-d");
					$location_id = "0";
					$sqlprice = "select a.current_price, a.current_price1, a.current_price2, a.current_price3, a.qty1, a.qty2, a.qty3, a.qty4, a.end_date_discount, a.discount, a.discount_percent, ifnull(a.non_discount,0) non_discount from set_item_price a where a.item_code='$item_code' and a.uom_code='$uom_code' and a.efective_from <='$datenow' and a.location_id='$location_id2' order by a.date_of_record desc limit 1 ";
					//and a.location_id='$location_id' 
					$resultprice = $dbpdo->prepare($sqlprice);
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

					/*if($qty <= $qty1) {
						$unit_price = $current_price;
					}
					if( ($qty > $qty1) && ($qty <= $qty2) ) {
						$unit_price = $current_price1;
					}
					if($qty > $qty2) {
						$unit_price = $current_price2;
					}*/

					//get discount
					$discount			= 0;
					$discount2			= 0;
					$discount_percent	= 0;
					$date_now = date("Y-m-d");
					$end_date_discount	= $dataprice->end_date_discount;
					if ($date_now <= $dataprice->end_date_discount && $qty >= $dataprice->qty1) {
						$discount			= $dataprice->discount;
						$discount2			= $dataprice->discount;
						$discount_percent	= $dataprice->discount_percent;
					}
					if ($date_now <= $dataprice->end_date_discount && $dataprice->non_discount > 0) {
						$discount			= $dataprice->discount;
						$discount2			= $dataprice->discount;
						$discount_percent	= $dataprice->discount_percent;
					}
					//------/\---------

					//get discount (near expired)
					if ($ref_near_expired != "") {
						$item_code_exp = $item_code;

						$sqlexp = "select b.end_date, a.syscode, a.discount, a.discount_percent from item_near_expired_detail a left join item_near_expired b on a.ref=b.ref where a.item_code='$item_code' and a.uom_code='$uom_code' and b.location_id='$location_id2' and '$date_now' <= b.end_date and a.syscode='$ref_near_expired' order by a.syscode desc limit 1 ";
						$resultexp = $dbpdo->prepare($sqlexp);
						$resultexp->execute();
						$countexp = $resultexp->rowCount();
						$dataexp = $resultexp->fetch(PDO::FETCH_OBJ);
						if ($countexp > 0) {
							$discount 			= $dataexp->discount;
							$discount2			= $dataexp->discount;
							$discount_percent	= $dataexp->discount_percent;
							$end_date_discount	= $dataexp->end_date;
						}
					}
					//------/\---------


					$amount = ($unit_price - $discount) * $qty;
					$total = $amount;
					##end cek
					//dataprice->discount
					$sqlstr = "update sales_invoice_tmp set qty='$qty', unit_price='$unit_price', end_date_discount='$end_date_discount', discount='$discount', discount2='$discount2', discount3='$discount_percent', qty_discount='$qty1', amount='$amount', total='$total', deposit='$dataprice->discount_percent', non_discount='$dataprice->non_discount', dlu='$dlu' where ref='$ref' and client_code='$client_code' and item_code='$item_code' and uom_code='$uom_code' and ifnull(ref_near_expired,'')='$ref_near_expired'";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {

					//get discount (near expired)
					if ($ref_near_expired != "") {
						$item_code_exp = $item_code;

						$sqlexp = "select b.end_date, a.syscode, a.discount, a.discount_percent from item_near_expired_detail a left join item_near_expired b on a.ref=b.ref where a.item_code='$item_code' and a.uom_code='$uom_code' and b.location_id='$location_id2' and '$date_now' <= b.end_date and a.syscode='$ref_near_expired' order by a.syscode desc limit 1 ";
						$resultexp = $dbpdo->prepare($sqlexp);
						$resultexp->execute();
						$countexp = $resultexp->rowCount();
						$dataexp = $resultexp->fetch(PDO::FETCH_OBJ);
						if ($countexp > 0) {
							$discount 			= $dataexp->discount;
							$discount2			= $dataexp->discount;
							$discount_percent	= $dataexp->discount_percent;
							$end_date_discount	= $dataexp->end_date;
						}
					}
					//------/\---------

					$line = maxline('sales_invoice_tmp', 'line', 'ref', $ref, '');

					$date = date('Y-m-d');
					$sqlstr = "insert into sales_invoice_tmp (ref, date, client_code, cash, item_code, uom_code, qty, discount, unit_price, amount, discount2, discount3, deposit, total, end_date_discount, non_discount, qty_discount, ref_near_expired, uid, dlu, line) values ('$ref', '$date', '$client_code', '$cash', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$amount', '$discount2', '$discount_percent', '$discount_percent', '$total', '$end_date_discount', '$dataprice->non_discount', '$qty1', '$ref_near_expired', '$uid', '$dlu', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert pos
	function insert_pos($ref, $xndf, $ref_tmp)
	{

		$dbpdo = DB::create();

		try {

			date_default_timezone_set('Asia/Jakarta');

			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$due_date		=	date("Y-m-d");
			$total			=	numberreplace($_POST["total"]); //$sub_total; 
			$cash_amount	=	numberreplace($_POST["cash_amount"]);
			$ovo			=	numberreplace($_POST["ovo"]);
			$gopay			=	numberreplace($_POST["gopay"]);
			$cash_voucher	=	numberreplace($_POST["cash_voucher"]);
			$change_amount	=	numberreplace($_POST["change_amount"]);
			$shift			=	$_POST["shift"];
			$uid			=	$_SESSION["loginname"];
			$id_comp		=	$_SESSION["ip_comp"];
			$upd_approved_over = $_POST["upd_approved_over"];

			$dlu			=	date("Y-m-d H:i:s");

			##cek data untuk menghindari data double
			$sqlstr = "select uid, dlu from sales_invoice where uid='$uid' and dlu='$dlu'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$rowsdata = $sql->rowCount();
			if ($rowsdata == 0) {

				$sqlstr = "select uid, dlu from sales_invoice where uid='$uid' and DATE_ADD( dlu, INTERVAL 1 
SECOND)='$dlu'";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$rowsdata1 = $sql->rowCount();
				if ($rowsdata1 == 0) {

					/*$sqlstr = "select uid, dlu from sales_invoice where date='$date' and due_date='$due_date' and total='$total' and cash_amount='$cash_amount' and cash_voucher='$cash_voucher' and change_amount='$change_amount' and shift='$shift' and uid='$uid' and uid='$uid' and DATE_ADD( dlu, INTERVAL 25 
SECOND)>'$dlu'";*/
					$sqlstr = "select uid, dlu from sales_invoice where date='$date' and due_date='$due_date' and total='$total' and cash_amount='$cash_amount' and cash_voucher='$cash_voucher' and change_amount='$change_amount' and shift='$shift' and uid='$uid' and uid='$uid' and DATE_ADD( dlu, INTERVAL 17 
SECOND)>'$dlu'";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
					$rowsdata2 = $sql->rowCount();
					if ($rowsdata2 == 0) {

						//-------start insert-----------------
						$status			= 	"R";
						$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];

						$client_member_code	=	$_POST["client_member_code"];
						if ($client_member_code == "") {
							$client_member_code2	=	$_POST["client_member_code2"];
							$sqlcln = "select syscode from client where rtrim(ltrim(code))='$client_member_code2' ";
							$sql = $dbpdo->prepare($sqlcln);
							$sql->execute();
							$data   = $sql->fetch(PDO::FETCH_OBJ);
							$client_member_code = $data->syscode;
						}

						$cash			=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];



						##insert outbount (pengeluaran barang ke toko)
						//$ref_outbound = $this->insert_outbound_pos($date, 'P', 'T', '', '', '', $location_id, 0, $uid, $dlu);

						//----------insert item packing detail
						$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
						$sub_total = 0;
						for ($i = 0; $i <= $jmldata; $i++) {
							$item_code 			= $_POST['item_code_' . $i];
							$uom_code 			= $_POST['uom_code_' . $i];
							$ref_near_expired	= $_POST['ref_near_expired_' . $i];

							if (!empty($item_code) && !empty($uom_code)) {
								$end_date_discount = date("Y-m-d", strtotime($_POST['end_date_discount_' . $i]));

								$old_line 		= $_POST['old_line_' . $i];
								//biar aman, ambil qty dr 'table' temporary
								$sqlstr = "select qty from sales_invoice_tmp where ref='$xndf' and item_code='$item_code' and uom_code='$uom_code' and line='$old_line' ";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();
								$data_tmp = $sql->fetch(PDO::FETCH_OBJ);
								$qty = numberreplace($data_tmp->qty); //numberreplace($_POST[qty_.$i]);

								$unit_price = numberreplace($_POST[unit_price_ . $i]);
								$discount2 = numberreplace($_POST[discount2_ . $i]);
								$discount3 = numberreplace($_POST[discount3_ . $i]);
								$qty_discount = numberreplace($_POST[qty_discount_ . $i]);
								$discount = ($unit_price * $discount3) / 100;
								//$discount = numberreplace($_POST[discount_.$i]);
								$amount = numberreplace($_POST[amount_ . $i]);
								$non_discount = (empty($_POST[non_discount_ . $i])) ? 0 : $_POST[non_discount_ . $i];
								$discount_percent_tmp = numberreplace($_POST[deposit_ . $i]);

								$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');

								$sqlstr = "insert into sales_invoice_detail (ref, item_code, uom_code, qty, end_date_discount, discount, discount2, discount3, unit_price, amount, qty_discount, non_discount, discount_percent_tmp, line, ref_near_expired) values ('$ref', '$item_code', '$uom_code', '$qty', '$end_date_discount', '$discount', '$discount2', '$discount3', '$unit_price', '$amount', '$qty_discount', '$non_discount', '$discount_percent_tmp', '$line', '$ref_near_expired')";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();

								//----------insert bincard (debit qty)
								$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
								$sql = $dbpdo->prepare($sqlstr);
								$sql->execute();

								//----------AUDIT TRAIL insert bincard (debit qty)
								/*$sqlstr="insert into adt_bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu, adt_status) values ('$ref', '$location_id', '$date', 'pos', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu', 'insert')";						$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();*/


								//----------insert/update set_item_price
								/*$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
								$sql=$dbpdo->prepare($sqlprice);
								$sql->execute();
								$numprice = $sql->rowCount();
								
								
								if($numprice == 0) {
									$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
									$resultprice2=$dbpdo->prepare($sqlprice2);
									$resultprice2->execute();
									$dataprice = $resultprice2->fetch(PDO::FETCH_OBJ);
								
									$last_price			=	$dataprice->current_price;
									$date_of_record		=	date("Y-m-d H:i:s");
									
									$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, location_id, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$location_id', '$uid', '$dlu')";				
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();
								}*/
								//------------------------------------/\


								$sub_total = $sub_total + $amount;


								##insert outbound detail (pengeluaran barang ke toko)
								$ref_pos = $ref;
								//$this->insert_outbound_pos_detail($ref_outbound, $item_code, $uom_code, $qty, $ref_pos);


							}
						}



						//----get client cash
						/*
							$sqlcek 	= 	"select syscode from client where name='cash' limit 1 ";
							$resultcek	=	mysql_query($sqlcek);
							$datacek	=	mysql_fetch_object($resultcek);			
							$client_code =	$datacek->syscode;
							*/

						$newclient		=	(empty($_POST["newclient"])) ? 0 : $_POST["newclient"];
						$client_code	=	$_POST["client_code"];

						/*if($newclient == 1) {
								//-------------------cek customer baru----\/		
								$sqlcek 	= 	"select code from client where name='$client_code' ";	
								$resultcek=$dbpdo->prepare($sqlcek);
								$resultcek->execute();
								$numcek		= $resultcek->rowCount();
								
								if($numcek == 0) {
									$syscode	= 	random(9);
									$code		=	substr($client_code,0,3) . $syscode;
									$phone		=	$_POST['phone'];
									
									//-------get client type
									$sqlclntype 	= 	"select id from client_type order by id limit 1 ";		
									$resultclntype=$dbpdo->prepare($sqlclntype);
									$resultclntype->execute();
									$dataclntype		= $resultclntype->fetch(PDO::FETCH_OBJ);
												
									$client_type	=	$dataclntype->id;
									//------------------/\
								
									$location_id2 = $_SESSION['location_id2'];
									$sqlstr 	=	"insert into client (code, name, contact_person, client_type, ship_to, bill_to, phone, address, active, syscode, location_id, uid, dlu) values ('$code', '$client_code', '$client_code', '$client_type', '$ship_to', '$bill_to', '$phone', '$ship_to', 1, '$syscode', '$location_id2', '$uid', '$dlu')";
									$sql=$dbpdo->prepare($sqlstr);
									$sql->execute();	
									
									$client_code =	$syscode;			
								} else {
									$sqlcek 	= 	"select syscode from client where name='$client_code' ";
									$resultcek=$dbpdo->prepare($sqlcek);
									$resultcek->execute();
									$datacek		= $resultcek->fetch(PDO::FETCH_OBJ);
									
									$client_code =	$datacek->syscode;
								}
								//----------------------/\-end cek customer
							} */


						$employee_id		= 	0;
						$top				=	"C.O.D";
						$tax_code			=	"";
						$tax_rate			=	0;
						$freight_cost 		= 	0;
						$freight_account	= 	"";
						$currency_code		=	"";
						$rate				=	0;
						$memo				= 	$_POST["memo"];
						$discount2			=	numberreplace($_POST["discount"]);
						$deposit			=	0;
						$total_member		=	numberreplace($_POST["total"]);

						$photo_file			= 	"";

						$bank_id			=	(empty($_POST["bank_id"])) ? 0 : $_POST["bank_id"];
						$bank_amount		=	numberreplace($_POST["bank_amount"]);
						$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
						$card_amount		=	numberreplace($_POST["card_amount"]);
						$credit_card_no		=	$_POST["credit_card_no"];
						$credit_card_holder	=	petikreplace($_POST["credit_card_holder"]);


						$sqlstr = "delete from sales_invoice_tmp where ref='$xndf'";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						$sqlstr = "insert into sales_invoice (ref, ref2, date, status, top, due_date, client_code, ship_to, bill_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, discount, total, memo, opening_balance, cash, location_id, deposit, taxable, photo_file, cash_amount, cash_voucher, ovo, gopay, bank_id, bank_amount, credit_card_code, card_amount, credit_card_no, credit_card_holder, change_amount, shift, client_member_code, id_comp, upd_approved_over, uid, dlu) values('$ref', '$ref2', '$date', '$status', '$top', '$due_date', '$client_code', '$ship_to', '$bill_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$discount2', '$total', '$memo', 0, '$cash', '$location_id', '$deposit', '$taxable', '$photo_file', '$cash_amount', '$cash_voucher', '$ovo', '$gopay', '$bank_id', '$bank_amount', '$credit_card_code', '$card_amount', '$credit_card_no', '$credit_card_holder', '$change_amount', '$shift', '$client_member_code', '$id_comp', '$upd_approved_over', '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();

						/*---------insert audit trail (insert)------------*/
						/*$sqlstr="insert into adt_sales_invoice (ref, ref2, date, status, top, due_date, client_code, ship_to, bill_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, discount, total, memo, opening_balance, cash, location_id, deposit, taxable, photo_file, cash_amount, cash_voucher, bank_id, bank_amount, credit_card_code, card_amount, credit_card_no, credit_card_holder, change_amount, shift, client_member_code, uid, dlu, adt_status) values('$ref', '$ref2', '$date', '$status', '$top', '$due_date', '$client_code', '$ship_to', '$bill_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$discount2', '$total', '$memo', 0, '$cash', '$location_id', '$deposit', '$taxable', '$photo_file', '$cash_amount', '$cash_voucher', '$bank_id', '$bank_amount', '$credit_card_code', '$card_amount', '$credit_card_no', '$credit_card_holder', '$change_amount', '$shift', '$client_member_code', '$uid', '$dlu', 'insert')";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();*/

						##jika piutang
						/*if($cash == 0) {
								
								$total = $total - $deposit;
								//insert AR
								$sqlstr="insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$total', 0, 'cashier', 'pos', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();
							}*/
						//-----------

						/*if($bank_amount > 0) {
								
								$sqlbnk = "select name, account_code, account_coa from bank where id='$bank_id' ";
								$result=$dbpdo->prepare($sqlbnk);
								$result->execute();
								$data		= $result->fetch(PDO::FETCH_OBJ);
								
								$cheque_no		= $data->account_code;
								$bank_name		= $data->name;
								$receipt_type	= "transfer";
								$cheque_date	= $date;
								$total			= $bank_amount;
								$account_code	= $data->account_coa;
								
								//insert ARC
								$sqlstr="insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();									
								
							}*/

						/*if($card_amount > 0) {
								
								$sqlbnk = "select name, account_code from credit_card_type where code='$credit_card_code' ";
								$result=$dbpdo->prepare($sqlbnk);
								$result->execute();
								$data		= $result->fetch(PDO::FETCH_OBJ);
								
								$cheque_no		= $credit_card_no;
								$bank_name		= $data->name;
								$receipt_type	= "card";
								$cheque_date	= $date;
								$total			= $card_amount;
								$account_code	= $data->account_code;
								
								//insert ARC
								$sqlstr="insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
								$sql=$dbpdo->prepare($sqlstr);
								$sql->execute();			
								
								
							}*/


						##member only
						if ($total > 0 && $client_member_code != "") {
							$point				=	floor($total / 50000);
							$cleared			=	0;

							$sqlstr = "insert into sales_invoice_point (ref, date, client_code, point, cleared) values('$ref', '$date', '$client_member_code', '$point', '$cleared')";
							$sql = $dbpdo->prepare($sqlstr);
							$sql->execute();
						}



						/*
							//----------insert client member detail-------------\/
							$jumlahmember = (empty($_POST['jumlahmember'])) ? 0 : $_POST['jumlahmember'];
							$i = 0;
							$amount_member = $_POST["amount_member"];
							for ($i=0; $i<=$jumlahmember; $i++) {
								$discmember		= numberreplace($_POST[discmember.$i]);
								$memberlimit	= numberreplace($_POST[memberlimit.$i]);
								
								$sql3 = "insert into sales_invoice_discount_detail (ref, discmember, memberlimit, amount_member, line) values ('$ref', '$discmember', '$memberlimit', '$amount_member', '$i')";
								QueryDbTrans($sql3, $success);
								
							}				
							if($amount_member > 0) {
								$sql4 = "insert into sales_invoice_discount (ref, client_code, date, amount) values ('$ref', '$client_code', '$date', '$total_member')";
								QueryDbTrans($sql4, $success);
							}
							//---------------------------------------------------/\
				            */

						/*$id_user = $_SESSION["id_user"];
			            	notran($date, 'frmpos', 1, '', $id_user) ; //----eksekusi ref*/
					}
				}
			}


			//-------delete invoice detail tmp
			$sqlstr = "delete from sales_invoice_tmp where ref='$ref_tmp' and uid='$uid' ";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}



	//-----insert purchase_inv detail
	function insert_purchase_inv_detail($ref)
	{

		$dbpdo = DB::create();

		try {

			$location_id	= $_POST['location_id'];
			$item_code 		= $_POST['item_code'];
			$item_code2		= $_POST['item_code2'];
			$uom_code 		= $_POST['uom_code'];

			$qty 		    = numberreplace($_POST['qty']);
			$unit_cost     	= numberreplace($_POST['unit_cost']);
			$amount 	    = numberreplace($_POST['amount']);
			$cash			=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$vendor_code	=	$_POST["vendor_code"];



			//----------jika lookup gagal enter
			$sqlstr 	= "select syscode, uom_code_purchase uom_code from item where (code='$item_code2' or old_code='$item_code2') limit 1";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$data 	= $sql->fetch(PDO::FETCH_OBJ);

			if ($item_code == '') {
				$item_code 	= $data->syscode;
			}

			if ($uom_code == '') {
				$uom_code	= $data->uom_code;
			}


			$sqlprice = "select b.current_cost, a.name from item a left join set_item_cost b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' order by b.date_of_record desc limit 1 ";
			$resultprice = $dbpdo->prepare($sqlprice);
			$resultprice->execute();
			$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

			if ($unit_cost == '' || $unit_cost == 0) {
				$unit_cost	= $dataprice->current_cost;
			}

			if ($qty == '' || $qty == 0) {
				$qty = 1;
			}

			if ($amount == '' || $amount == 0) {
				$amount			= $dataprice->current_cost * 1;
			}
			//---------------------------------/\


			if (empty($item_code) && empty($uom_code)) {
				$sqlstr 	    = "select syscode, uom_code_purchase uom_code from item where (code='$item_code2' or code='$item_code2') limit 1";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$data		= $sql->fetch(PDO::FETCH_OBJ);

				$item_code  = $data->syscode;
				$uom_code   = $data->uom_code;

				$sqlprice = "select b.current_cost, a.name from item a left join set_item_cost b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_purchase='$uom_code' and b.location_id='$location_id' order by b.date_of_record desc limit 1 ";
				$resultprice = $dbpdo->prepare($sqlprice);
				$resultprice->execute();
				$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

				$unit_cost	    = $dataprice->current_cost;
				$qty            = 1;
				$amount         = $unit_price * $qty;
			}

			if (!empty($item_code) && !empty($uom_code)) {

				$discount_det	= numberreplace($_POST['discount_det']);
				$discount 		= $discount_det; //numberreplace($_POST['discount']);
				$discount1 		= numberreplace($_POST['discount3_1_det']);
				$discount2 		= numberreplace($_POST['discount3_2_det']);
				$discount3 		= numberreplace($_POST['discount3_3_det']);
				$total	 		= numberreplace($_POST['total']);

				$uid			= $_SESSION["loginname"];

				//----------insert/update set_item_price (ditutup krn harga di seting di set item price aja)
				/*$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
				$resultprice = mysql_query($sqlprice);
				$numprice = mysql_num_rows($resultprice);
				*/

				/*if($numprice == 0) {
					$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
					$resultprice2 = mysql_query($sqlprice2);
					$dataprice = mysql_fetch_object($resultprice2);
				
					$last_price			=	$dataprice->current_price;
					$date_of_record		=	date("Y-m-d H:i:s");
					
					$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, location_id, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$location_id', '$uid', '$dlu')";				
					QueryDbTrans($sql2, $success);
				}	*/
				//------------------------------------/\

				$sqlstr = "select sum(qty) qty, item_code from purchase_invoice_tmp where ref='$ref' and vendor_code='$vendor_code' and item_code='$item_code' and	uom_code='$uom_code' group by ref, vendor_code, item_code, uom_code";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				$data = $sql->fetch(PDO::FETCH_OBJ);

				if ($rows > 0) {
					$qty = $data->qty + $qty;
					$amount = ($qty * ($unit_cost - $discount));
					//$amount = $qty * $unit_cost;
					$total = $amount;

					$sqlstr = "update purchase_invoice_tmp set qty='$qty', unit_cost='$unit_cost', discount1='$discount1', discount2='$discount2', discount3='$discount3', discount='$discount', amount='$amount', total='$total' where ref='$ref' and vendor_code='$vendor_code' and item_code='$item_code' and uom_code='$uom_code'";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {

					$line = maxline('purchase_invoice_tmp', 'line', 'ref', $ref, '');

					$sqlstr = "insert into purchase_invoice_tmp (ref, vendor_code, item_code, uom_code, qty, discount1, discount2, discount3, discount, unit_cost, amount, total, location_id, uid, line) values ('$ref', '$vendor_code', '$item_code', '$uom_code', '$qty', '$discount1', '$discount2', '$discount3', '$discount_det', '$unit_cost', '$amount', '$total', '$location_id', '$uid', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert purchase inv
	function insert_purchase_inv($ref, $ref_tmp)
	{

		$dbpdo = DB::create();

		try {

			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id		=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");

			//----------insert item packing detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				//$po_ref 		= $_POST[po_ref_.$i];
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_cost = numberreplace($_POST[unit_cost_ . $i]);
					$discount = numberreplace($_POST[discount_ . $i]);
					$discount1 = numberreplace($_POST[discount3_1_ . $i]);
					$discount2 = numberreplace($_POST[discount3_2_ . $i]);
					$discount3 = numberreplace($_POST[discount3_3_ . $i]);
					$amount = numberreplace($_POST[amount_ . $i]); //$qty * $unit_cost; //numberreplace($_POST[amount_.$i]);
					$line_item_po = (empty($_POST[line_item_po_ . $i])) ? 0 : $_POST[line_item_po_ . $i];

					$line = maxline('purchase_invoice_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into purchase_invoice_detail (ref, po_ref, item_code, uom_code, qty, unit_cost, discount1, discount2, discount3, discount, amount, line_item_po, line) values ('$ref', '', '$item_code', '$uom_code', '$qty', '$unit_cost', '$discount1', '$discount2', '$discount3', '$discount', '$amount', '0', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					//----------insert bincard (debit qty)
					$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_inv', '', '$item_code', '$uom_code', '$unit_cost', '$qty', 0, '$amount', '$line', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();


					$sub_total = $sub_total + $amount;
				}
			}



			$invoice_no			=	$_POST["invoice_no"];
			$status				= 	"R"; //$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			$tax_code			= 	$_POST["tax_code"];
			$tax_rate			=	numberreplace((empty($_POST["tax_rate"])) ? 0 : $_POST["tax_rate"]);
			$freight_cost		=	numberreplace((empty($_POST["freight_cost"])) ? 0 : $_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$discount 			= 	numberreplace($_POST["discount_det"]);
			$total				=	numberreplace($_POST["total"]); //$sub_total + $freight_cost;
			$memo				= 	petikreplace($_POST["memo"]);
			$payment_type		=	$_POST["payment_type"];
			$cash				= 	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$cash_amount		= 	numberreplace($_POST["cash_amount"]);
			$change_amount		=	numberreplace($_POST["change_amount"]);
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));

			$bank_id			=	(empty($_POST["bank_id"])) ? 0 : $_POST["bank_id"];
			$bank_amount		=	numberreplace($_POST["bank_amount"]);
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$card_amount		=	numberreplace($_POST["card_amount"]);
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_holder	=	petikreplace($_POST["credit_card_holder"]);

			$sqlstr = "insert into purchase_invoice (ref, invoice_no, date, status, bill_number, vendor_code, top, due_date, tax_code, tax_rate, freight_cost, freight_account, memo, payment_type, location_id, cash, cash_amount, change_amount, discount, total, bank_id, bank_amount, credit_card_code, card_amount, credit_card_no, credit_card_holder, uid, dlu) values('$ref', '$invoice_no', '$date', '$status', '$bill_number', '$vendor_code', '$top', '$due_date', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$memo', '$payment_type', '$location_id', '$cash', '$cash_amount', '$change_amount', '$discount', '$total', '$bank_id', '$bank_amount', '$credit_card_code', '$card_amount', '$credit_card_no', '$credit_card_holder', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//insert AP
			if ($payment_type == "credit" || $payment_type == "consign") {

				$sqlstr = "insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'V', '$vendor_code', '', 0, '$total', 'POV', 'POV', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}


			//-------delete invoice detail tmp
			$sqlstr = "delete from purchase_invoice_tmp where ref='$ref_tmp' and uid='$uid' ";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}



	//-----insert pos modal cash receipt
	function insert_pos_modal_cash_receipt($ref, $account_code, $account_code_det, $memo1, $memo_det)
	{

		$dbpdo = DB::create();

		try {

			$modal 			= 	$_POST['modal'];

			//get employee id
			$uid			=	$_SESSION["loginname"];
			$sqlstr = "select employee_id from usr where usrid='$uid'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$contact_code	=	$data->employee_id;
			if ($contact_code == "") {
				$contact_code = $uid;
			}

			$date			=	date("Y-m-d");
			$contact_type	=	"E";
			$contact_name	=	$uid . "/" . $_POST['shift'];
			//$memo1			= 	$memo; //"Penerimaan Kas Kecil " . $uid;
			$dlu			=	date("Y-m-d H:i:s");

			//----------insert item packing detail
			$jmldata 		= 	0;

			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				//$account_code 	= $account_code_det; //"273655693"; //$_POST[account_code_.$i];
				$debit_amount 	= 0;
				$credit_amount 	= numberreplace($modal);

				if (!empty($account_code_det) && ($debit_amount <> 0 || $credit_amount <> 0)) {
					$memo		 	= $memo_det; //"Uang Modal Kas Kecil " . $uid;
					$currency_code 	= "idr";
					$rate 			= 0;

					$line = maxline('cash_receipt_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into cash_receipt_detail (ref, account_code, currency_code, rate, debit_amount, credit_amount, memo, line) values ('$ref', '$account_code_det', '$currency_code', '$rate', '$debit_amount', '$credit_amount', '$memo', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}


			$status				= 	"R";
			$receipt_type		=	"cash";
			$cheque_no			=	"";
			$cheque_date		=	date("Y-m-d", strtotime($_POST["cheque_date"]));
			$bank_name			=	"";
			$credit_card_no		=	"";
			$credit_card_code	=	"0";
			$credit_card_holder	=	"";
			$credit_card_expired =	date("Y-m-d", strtotime($_POST["credit_card_expired"]));
			//$account_code		= 	"197430350"; //Kas (Pusat);
			$currency_code		=	"idr";
			$rate				=	0;
			$amount				=	numberreplace($modal);


			$sub_total			=	0;
			$deposit			=	0;
			$type				=	"";

			$total				=	numberreplace($modal);

			$sqlstr = "insert into cash_receipt (ref, date, status, contact_type, contact_code, contact_name, receipt_type, cheque_no, cheque_date, bank_name, credit_card_no, credit_card_code, credit_card_holder, credit_card_expired, account_code, currency_code, rate, amount, deposit, sub_total, type, memo, opening_balance, total, uid, dlu) values('$ref', '$date', '$status', '$contact_type', '$contact_code', '$contact_name', '$receipt_type', '$cheque_no', '$cheque_date', '$bank_name', '$credit_card_no', '$credit_card_code', '$credit_card_holder', '$credit_card_expired', '$account_code', '$currency_code', '$rate', '$amount', '$deposit', '$sub_total', '$type', '$memo1', '0', '$total', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			if ($receipt_type == "giro" || $receipt_type == "cheque") {

				//insert ARC
				$sqlstr = "insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$contact_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo1', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert outbound detail
	function insert_outbound_detail($ref)
	{

		$dbpdo = DB::create();

		try {

			$warehouse_id_from	= 	$_POST['warehouse_id_from'];
			$warehouse_id_to	=	$_POST['warehouse_id_to'];
			$item_code 		= 	$_POST['item_code'];
			$item_code2		= 	$_POST['item_code2'];
			$uom_code 		= 	$_POST['uom_code'];
			$qty 		    = 	numberreplace($_POST['qty']);
			$employee_id	=	$_POST["employee_id"];



			//----------jika lookup gagal enter
			$sqlstr 	= "select syscode, uom_code_stock uom_code from item where (code='$item_code2' or old_code='$item_code2') limit 1";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$data 	= $sql->fetch(PDO::FETCH_OBJ);

			if ($item_code == '') {
				$item_code 	= $data->syscode;
			}

			if ($uom_code == '') {
				$uom_code	= $data->uom_code;
			}


			if ($qty == '' || $qty == 0) {
				$qty = 1;
			}

			//---------------------------------/\


			if (empty($item_code) && empty($uom_code)) {
				$sqlstr 	    = "select syscode, uom_code_stock uom_code from item where (code='$item_code2' or old_code='$item_code2') limit 1";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$data		= $sql->fetch(PDO::FETCH_OBJ);

				$item_code  = $data->syscode;
				$uom_code   = $data->uom_code;

				$qty        = 1;
			}

			if ($warehouse_id_to == "") {
				$sqlstr = "select warehouse_id_to from outbound_tmp where ref='$ref' and warehouse_id_to <> 0 limit 1";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$data = $sql->fetch(PDO::FETCH_OBJ);

				$warehouse_id_to = $data->warehouse_id_to;
			}


			if (!empty($item_code) && !empty($uom_code)) {

				$sqlstr = "select sum(qty) qty, item_code from outbound_tmp where ref='$ref' and item_code='$item_code' and	uom_code='$uom_code' group by ref, item_code, uom_code";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				$data = $sql->fetch(PDO::FETCH_OBJ);

				$uid	= 	$_SESSION["loginname"];

				if ($rows > 0) {
					$qty = $data->qty + $qty; //1;

					$sqlstr = "update outbound_tmp set qty='$qty' where ref='$ref' and item_code='$item_code' and uom_code='$uom_code'";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {

					$line = maxline('outbound_tmp', 'line', 'ref', $ref, '');

					$sqlstr = "insert into outbound_tmp (ref, warehouse_id_from, warehouse_id_to, employee_id, item_code, uom_code, qty, uid, line) values ('$ref', '$warehouse_id_from', '$warehouse_id_to', '$employee_id', '$item_code', '$uom_code', '$qty', '$uid', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//outbound from POS
	function insert_outbound_pos($date, $status, $type, $reason, $form_no, $warehouse_id_from, $warehouse_id_to, $employee_id, $uid, $dlu, $ref = '')
	{
		$dbpdo = DB::create();

		try {


			$sqlstr = "select ref from outbound where date='$date' and warehouse_id_to='$warehouse_id_to' limit 1";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$rows = $sql->rowCount();
			$data = $sql->fetch(PDO::FETCH_OBJ);
			$ref = $data->ref;

			if ($rows == 0) {

				$ref = notran($date, 'frmoutbound', '', '', '');

				$sqlstr = "insert into outbound (ref, date, status, type, reason, form_no, warehouse_id_from, warehouse_id_to, employee_id, uid, dlu) values('$ref', '$date', '$status', '$type', '$reason', '$form_no', '$warehouse_id_from', '$warehouse_id_to', '$employee_id', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				/*---------insert adt outbound (insert)------------*/
				$sqlstr = "insert into adt_outbound (ref, date, status, type, warehouse_id_from, warehouse_id_to, reason, form_no, employee_id, uid, dlu, adt_status) values ('$ref', '$date', '$status', '$type', '$warehouse_id_from', '$warehouse_id_to', '$reason', '$form_no', '$employee_id', '$uid', '$dlu', 'insert' )";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				notran($date, 'frmoutbound', '1', '', '');

				//return $sql;
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $ref;
	}


	//outbound from POS detail
	function insert_outbound_pos_detail($ref, $item_code, $uom_code, $qty, $ref_pos)
	{
		$dbpdo = DB::create();

		try {


			if (!empty($item_code) && !empty($uom_code)) {

				$sqlstrcek = "select ref, line from outbound_detail where ref='$ref' and item_code='$item_code' and uom_code='$uom_code'";
				$sql2 = $dbpdo->prepare($sqlstrcek);
				$sql2->execute();
				$rows = $sql2->rowCount();
				$data = $sql2->fetch(PDO::FETCH_OBJ);

				if ($rows == 0) {
					$line = maxline('outbound_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into outbound_detail (ref, item_code, uom_code, qty, ref_pos, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$ref_pos', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					/*---------insert adt outbound_detail (insert)------------*/
					$sqlstr = "insert into adt_outbound_detail (ref, item_code, uom_code, qty, ref_pos, line, adt_status) values ('$ref', '$item_code', '$uom_code', '$qty', '$ref_pos', '$line', 'insert' )";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {
					$sqlstr = "update outbound_detail set qty=ifnull(qty,0) + $qty where ref='$ref' and item_code='$item_code' and uom_code='$uom_code'";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					/*---------update adt outbound_detail (update)------------*/
					$sqlstr = "update adt_outbound_detail set qty=ifnull(qty,0) + $qty where ref='$ref' and item_code='$item_code' and uom_code='$uom_code' ";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}



	//-----insert purchase return detail
	function insert_purchase_return_quick_detail($ref)
	{

		$dbpdo = DB::create();

		try {

			$vendor_code	= 	$_POST['vendor_code'];
			$item_code 		= 	$_POST['item_code'];
			$item_code2		= 	$_POST['item_code2'];
			$uom_code 		= 	$_POST['uom_code'];
			$qty 		    = 	numberreplace($_POST['qty']);
			$discount1	    = 	numberreplace($_POST['discount3_1_det']);
			$discount	    = 	numberreplace($_POST['discount_det']);
			$amount		    = 	numberreplace($_POST['amount']);
			$location_id	=	$_POST["location_id"];

			$unit_cost     	= numberreplace($_POST['unit_cost']);
			$amount 	    = numberreplace($_POST['amount']);


			//----------jika lookup gagal enter
			$sqlstr 	= "select syscode, uom_code_purchase uom_code from item where (code='$item_code2' or old_code='$item_code2') limit 1";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$data 	= $sql->fetch(PDO::FETCH_OBJ);

			if ($item_code == '') {
				$item_code 	= $data->syscode;
			}

			if ($uom_code == '') {
				$uom_code	= $data->uom_code;
			}


			if ($qty == '' || $qty == 0) {
				$qty = 1;
			}

			//---------------------------------/\


			if (empty($item_code) && empty($uom_code)) {
				$sqlstr 	    = "select syscode, uom_code_purchase uom_code from item where (code='$item_code2' or old_code='$item_code2') limit 1";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$data		= $sql->fetch(PDO::FETCH_OBJ);

				$item_code  = $data->syscode;
				$uom_code   = $data->uom_code;

				$sqlprice = "select b.current_cost, a.name from item a left join set_item_cost b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_purchase='$uom_code' and b.location_id='$location_id' order by b.date_of_record desc limit 1 ";
				$resultprice = $dbpdo->prepare($sqlprice);
				$resultprice->execute();
				$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

				$unit_cost	    = $dataprice->current_cost;
				//$qty            = 1;
				$amount         = $unit_cost * $qty;
			}


			if (!empty($item_code) && !empty($uom_code)) {

				$discount_det	= numberreplace($_POST['discount_det']);
				$discount 		= numberreplace($_POST['discount']);
				$discount1 		= numberreplace($_POST['discount3_1_det']);
				$discount2 		= numberreplace($_POST['discount3_2_det']);
				$discount3 		= numberreplace($_POST['discount3_3_det']);
				$total	 		= numberreplace($_POST['total']);

				$selectview = new selectview;

				$sqlstr = "select sum(qty) qty, item_code from purchase_return_tmp where ref='$ref' and item_code='$item_code' and	uom_code='$uom_code' group by ref, item_code, uom_code";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$rows = $sql->rowCount();
				$data = $sql->fetch(PDO::FETCH_OBJ);


				$uid	= 	$_SESSION["loginname"];

				if ($rows > 0) {
					$qty = $data->qty + $qty;
					$unit_cost = $selectview->list_purchase_invoice_last_cost($item_code, $uom_code);

					if ($amount == 0 || $amount == "") {
						//$amount = $qty * $unit_cost;

						//get discount terakhir dr pembelian
						$discount1 = 0;
						$discount = 0;
						$sqldisc = $selectview->list_purchase_invoice_last_discount($item_code, $uom_code);
						$datadisc = $sqldisc->fetch(PDO::FETCH_OBJ);
						$discount1 = $datadisc->discount1;
						$discount = $datadisc->discount;

						//------------/\--------------------
					}

					$discount	=	($discount1 * $unit_cost) / 100;
					$unit_cost2	=	$unit_cost - $discount;
					$amount		= 	(numberreplace($unit_cost2) * $qty); // - $discount;

					$sqlstr = "update purchase_return_tmp set qty='$qty', unit_cost='$unit_cost', discount1='$discount1', discount='$discount', amount='$amount' where ref='$ref' and item_code='$item_code' and uom_code='$uom_code'";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				} else {

					$line = maxline('purchase_return_tmp', 'line', 'ref', $ref, '');

					$unit_cost = $selectview->list_purchase_invoice_last_cost($item_code, $uom_code);
					if ($amount == 0 || $amount == "") {
						$amount = $qty * $unit_cost;

						//get discount terakhir dr pembelian
						$discount1 = 0;
						$discount = 0;
						$sqldisc = $selectview->list_purchase_invoice_last_discount($item_code, $uom_code);
						$datadisc = $sqldisc->fetch(PDO::FETCH_OBJ);
						$discount1 = $datadisc->discount1;
						$discount = $datadisc->discount;

						$amount			= (numberreplace($unit_cost) * $qty) - $discount;
						//------------/\--------------------
					}

					$sqlstr = "insert into purchase_return_tmp (ref, vendor_code, location_id, item_code, uom_code, qty, unit_cost, discount1, discount, amount, line_item_pi, uid, line) values ('$ref', '$vendor_code', '$location_id', '$item_code', '$uom_code', '$qty', '$unit_cost', '$discount1', '$discount', '$amount', '0', '$uid', '$line')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
				}
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert purchase return quick
	function insert_purchase_return_quick($ref, $ref_tmp)
	{

		$dbpdo = DB::create();

		try {

			$date		=	date("Y-m-d", strtotime($_POST["date"]));
			$status		= 	$_POST["status"];
			$location_id = 	$_POST["location_id"];
			$pi_ref		=	$_POST["pi_ref"];
			$memo		= 	$_POST["memo"];
			$uid		=	$_SESSION["loginname"];
			$dlu		=	date("Y-m-d H:i:s");

			//----------insert item return detail
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i = 0; $i <= $jmldata; $i++) {
				$item_code 		= $_POST[item_code_ . $i];
				$uom_code 		= $_POST[uom_code_ . $i];

				if (!empty($item_code) && !empty($uom_code)) {
					$qty = numberreplace($_POST[qty_ . $i]);
					$unit_cost = numberreplace($_POST[unit_cost_ . $i]);
					$discount1 = numberreplace($_POST[discount3_1_ . $i]);
					$discount = numberreplace($_POST[discount_ . $i]);

					$amount = numberreplace($_POST[amount_ . $i]);

					$line_item_pi	= $_POST[line_item_pi_ . $i];

					$line = maxline('purchase_return_detail', 'line', 'ref', $ref, '');

					$sqlstr = "insert into purchase_return_detail (ref, item_code, uom_code, qty, discount1, discount, unit_cost, amount, line_item_pi, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount1', '$discount', '$unit_cost', '$amount', '$line_item_pi', $line)";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$sub_total = $sub_total + $amount;

					##--------update qty purchase invoice
					if ($status != "P") {


						//----------bincard (debit_qty)
						$amount = $qty * $unit_cost;

						$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'purchase_return', '$memo', '$item_code', '$uom_code', '$unit_cost', '0', '$qty', '$amount', '$line', '$uid', '$dlu')";
						$sql = $dbpdo->prepare($sqlstr);
						$sql->execute();
					}
				}
			}


			$vendor_code		=	$_POST["vendor_code"];
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$total				=	$sub_total; //numberreplace($_POST["total"]);

			$sqlstr = "insert into purchase_return (ref, date, status, vendor_code, location_id, pi_ref, tax_code, tax_rate, currency_code, rate, total, memo, uid, dlu) values('$ref', '$date', '$status', '$vendor_code', '$location_id', '$pi_ref', '$tax_code', '$tax_rate', '$currency_code', '$rate', '$total', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//insert AP
			$sqlstr = "insert into ap(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '1900-01-01', 'V', '$vendor_code', '', '$total', 0, 'PUR', 'PUR', '$currency_code', '$rate', '', '', '', '$memo', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			//-------delete invoice detail tmp
			$sqlstr = "delete from purchase_return_tmp where ref='$ref_tmp' and uid='$uid' ";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert cashier box detail
	function insert_cashier_box_detail($ref)
	{

		$dbpdo = DB::create();

		try {

			$ref2 			= $_POST['ref2'];
			$date 			= date("Y-m-d", strtotime($_POST['date']));
			$due_date 		= date("Y-m-d", strtotime($_POST['due_date']));
			$location_id	= $_POST['location_id'];
			$item_code 		= $_POST['item_code'];
			$item_code2		= $_POST['item_code2'];
			$uom_code 		= $_POST['uom_code'];
			$non_discount 	= (empty($_POST['non_discount'])) ? 0 : $_POST['non_discount'];

			$qty 		    = numberreplace($_POST['qty']);
			$unit_price     = numberreplace($_POST['unit_price']);
			$amount 	    = numberreplace($_POST['amount']);

			$cash			=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];

			//-------------------cek customer baru----\/
			$newclient		=	(empty($_POST["newclient"])) ? 0 : $_POST["newclient"];
			$client_code	=	petikreplace($_POST["client_code"]);

			if ($newclient == 1) {

				$sqlcek 	= 	"select code from client where name='$client_code' ";
				$resultcek = $dbpdo->prepare($sqlcek);
				$resultcek->execute();
				$numcek		= $resultcek->rowCount();

				if ($numcek == 0) {
					$syscode	= 	random(15);
					$date_cln	=	date('Y-m-d');

					$code		=	notran($date_cln, 'frmclient_pos', '', '', ''); //---get no ref
					//$code		=	substr($client_code,0,3) . $syscode;
					$phone		=	$_POST['phone'];
					$ship_to	=	petikreplace($_POST['ship_to']);

					//-------get client type
					$sqlclntype 	= 	"select id from client_type order by id limit 1 ";
					$resultclntype = $dbpdo->prepare($sqlclntype);
					$resultclntype->execute();
					$dataclntype		= $resultclntype->fetch(PDO::FETCH_OBJ);

					$client_type	=	$dataclntype->id;
					//------------------/\

					$location_id2 = $_SESSION['location_id2'];
					$sqlstr 	=	"insert into client (code, name, contact_person, client_type, ship_to, bill_to, phone, address, active, syscode, location_id, uid, dlu) values ('$code', '$client_code', '$client_code', '$client_type', '$ship_to', '$bill_to', '$phone', '$ship_to', 1, '$syscode', '$location_id2', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					notran($date_cln, 'frmclient_pos', 1, '', ''); //----eksekusi ref

					$client_code =	$syscode;
				} else {
					$sqlcek 	= 	"select syscode from client where name='$client_code' ";
					$resultcek = $dbpdo->prepare($sqlcek);
					$resultcek->execute();
					$datacek		= $resultcek->fetch(PDO::FETCH_OBJ);

					$client_code =	$datacek->syscode;
				}
			}
			//----------------------/\-end cek customer


			//----------jika lookup gagal enter
			$sqlstr 	= "select syscode, uom_code_sales uom_code from item where code='$item_code2' limit 1";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
			$data 	= $sql->fetch(PDO::FETCH_OBJ);

			if ($item_code == '') {
				$item_code 	= $data->syscode;
			}

			if ($uom_code == '') {
				$uom_code	= $data->uom_code;
			}


			$sqlprice = "select b.current_price, a.name, ifnull(b.non_discount,0) non_discount from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' order by b.date_of_record desc limit 1 ";
			$resultprice = $dbpdo->prepare($sqlprice);
			$resultprice->execute();
			$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

			if ($unit_price == '' || $unit_price == 0) {
				$unit_price	= $dataprice->current_price;
			}

			if ($qty == '' || $qty == 0) {
				$qty = 1;
			}

			if ($amount == '' || $amount == 0) {
				$amount			= $dataprice->current_price * 1;
			}

			$non_discount	= $dataprice->non_discount;
			//---------------------------------/\


			if (empty($item_code) && empty($uom_code)) {
				$sqlstr 	    = "select syscode, uom_code_sales uom_code from item where code='$item_code2' limit 1";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				$data		= $sql->fetch(PDO::FETCH_OBJ);

				$item_code  = $data->syscode;
				$uom_code   = $data->uom_code;

				$sqlprice = "select b.current_price, a.name, ifnull(b.non_discount,0) non_discount from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' and b.location_id='$location_id' order by b.date_of_record desc limit 1 ";
				$resultprice = $dbpdo->prepare($sqlprice);
				$resultprice->execute();
				$dataprice		= $resultprice->fetch(PDO::FETCH_OBJ);

				$unit_price	    = $dataprice->current_price;
				$qty            = 1;
				$amount         = $unit_price * $qty;
				$non_discount	= $dataprice->non_discount;
			}

			if (!empty($item_code) && !empty($uom_code)) {

				$discount 	= numberreplace($_POST['discount_det']);
				$discount2 	= numberreplace($_POST['discount']);
				$discount3 	= numberreplace($_POST['discount3_det']);
				$deposit 	= numberreplace($_POST['deposit']);
				$total	 	= numberreplace($_POST['total']);
				$note		= petikreplace($_POST['note']);

				$uid		= $_SESSION["loginname"];

				//----------insert/update set_item_price (ditutup krn harga di seting di set item price aja)
				/*$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
				$resultprice = mysql_query($sqlprice);
				$numprice = mysql_num_rows($resultprice);
				*/

				/*if($numprice == 0) {
					$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
					$resultprice2 = mysql_query($sqlprice2);
					$dataprice = mysql_fetch_object($resultprice2);
				
					$last_price			=	$dataprice->current_price;
					$date_of_record		=	date("Y-m-d H:i:s");
					
					$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, location_id, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$location_id', '$uid', '$dlu')";				
					QueryDbTrans($sql2, $success);
				}	*/
				//------------------------------------/\

				$line = maxline('sales_invoice_tmp', 'line', 'ref', $ref, '');

				$sqlstr = "insert into sales_invoice_tmp (ref, ref2, date, due_date, client_code, cash, item_code, uom_code, qty, discount, unit_price, amount, discount2, discount3, deposit, total, non_discount, note, uid, line) values ('$ref', '$ref2', '$date', '$due_date', '$client_code', '$cash', '$item_code', '$uom_code', '$qty', '$discount', '$unit_price', '$amount', '$discount2', '$discount3', '$deposit', '$total', '$non_discount', '$note', '$uid', $line)";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}



	//-----insert cashier box
	function insert_cashier_box($ref, $xndf)
	{

		$dbpdo = DB::create();

		try {

			$status			= 	"R";
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$cash			=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			//----------insert item packing detail
			$sub_total = 0;
			$item_code 		= $_POST['item_code'];
			$uom_code 		= $_POST['uom_code'];

			if (!empty($item_code) && !empty($uom_code)) {

				$qty = numberreplace($_POST['qty']);
				$unit_price = numberreplace($_POST['unit_price']);
				$discount = numberreplace($_POST['discount']);
				$discount3 = numberreplace($_POST['discount3']);
				$amount = numberreplace($_POST['amount']);
				$non_discount = (empty($_POST['non_discount'])) ? 0 : $_POST['non_discount'];
				$note = petikreplace($_POST['note']);

				$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');

				$sqlstr = "insert into sales_invoice_detail (ref, item_code, uom_code, qty, discount, discount3, unit_price, amount, non_discount, note, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount', '$discount3', '$unit_price', '$amount', '$non_discount', '$note', '$line')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				//----------insert bincard (debit qty)
				$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'cashier', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();


				//----------insert/update set_item_price
				/*$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
				$resultprice = mysql_query($sqlprice);
				$numprice = mysql_num_rows($resultprice);
				
				if($numprice == 0) {
					$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
					$resultprice2 = mysql_query($sqlprice2);
					$dataprice = mysql_fetch_object($resultprice2);
				
					$last_price			=	$dataprice->current_price;
					$date_of_record		=	date("Y-m-d H:i:s");
					
					$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, location_id, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$location_id', '$uid', '$dlu')";				
					QueryDbTrans($sql2, $success);
				} */
				//------------------------------------/\

				$sub_total = $sub_total + $amount;
			}


			//----------insert item packing detail
			/*$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
							
				if ( !empty($item_code) && !empty($uom_code) ) {
										
					$qty = numberreplace($_POST[qty_.$i]);
					$unit_price = numberreplace($_POST[unit_price_.$i]);
					$discount = numberreplace($_POST[discount_.$i]);
	                $discount3 = numberreplace($_POST[discount3_.$i]);
					$amount = numberreplace($_POST[amount_.$i]);
					$non_discount = (empty($_POST[non_discount_.$i])) ? 0 : $_POST[non_discount_.$i];
					$note = petikreplace($_POST[note_.$i]);
					
					$line = maxline('sales_invoice_detail', 'line', 'ref', $ref, '');
					
					$sqlstr="insert into sales_invoice_detail (ref, item_code, uom_code, qty, discount, discount3, unit_price, amount, non_discount, note, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$discount', '$discount3', '$unit_price', '$amount', '$non_discount', '$note', '$line')";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();								
					
					//----------insert bincard (debit qty)
					$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'cashier', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";				
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();*/


			//----------insert/update set_item_price
			/*$sqlprice = "select item_code from set_item_price where item_code='$item_code' and uom_code='$uom_code' and current_price='$unit_price' and location_id='$location_id' order by date_of_record desc limit 1 ";
					$resultprice = mysql_query($sqlprice);
					$numprice = mysql_num_rows($resultprice);
					
					if($numprice == 0) {
						$sqlprice2 = "select current_price from set_item_price where item_code='$item_code' and uom_code='$uom_code' and location_id='$location_id' order by date_of_record desc limit 1 ";
						$resultprice2 = mysql_query($sqlprice2);
						$dataprice = mysql_fetch_object($resultprice2);
					
						$last_price			=	$dataprice->current_price;
						$date_of_record		=	date("Y-m-d H:i:s");
						
						$sqlstr="insert into set_item_price (date, efective_from, item_code, uom_code, current_price, last_price, date_of_record, location_id, uid, dlu) values ('$date', '$date', '$item_code', '$uom_code', '$unit_price', '$last_price', '$date_of_record', '$location_id', '$uid', '$dlu')";				
						QueryDbTrans($sql2, $success);
					} */
			//------------------------------------/\


			/*$sub_total = $sub_total + $amount;
					
					
				}
			}*/



			//----get client cash
			/*
				$sqlcek 	= 	"select syscode from client where name='cash' limit 1 ";
				$resultcek	=	mysql_query($sqlcek);
				$datacek	=	mysql_fetch_object($resultcek);			
				$client_code =	$datacek->syscode;
				*/

			$newclient		=	(empty($_POST["newclient"])) ? 0 : $_POST["newclient"];
			$client_code	=	$_POST["client_code"];

			if ($newclient == 1) {
				//-------------------cek customer baru----\/		
				$sqlcek 	= 	"select code from client where name='$client_code' ";
				$resultcek = $dbpdo->prepare($sqlcek);
				$resultcek->execute();
				$numcek		= $resultcek->rowCount();

				if ($numcek == 0) {
					$syscode	= 	random(9);
					$code		=	substr($client_code, 0, 3) . $syscode;
					$phone		=	$_POST['phone'];

					//-------get client type
					$sqlclntype 	= 	"select id from client_type order by id limit 1 ";
					$resultclntype = $dbpdo->prepare($sqlclntype);
					$resultclntype->execute();
					$dataclntype		= $resultclntype->fetch(PDO::FETCH_OBJ);

					$client_type	=	$dataclntype->id;
					//------------------/\

					$location_id2 = $_SESSION['location_id2'];
					$sqlstr 	=	"insert into client (code, name, contact_person, client_type, ship_to, bill_to, phone, address, active, syscode, location_id, uid, dlu) values ('$code', '$client_code', '$client_code', '$client_type', '$ship_to', '$bill_to', '$phone', '$ship_to', 1, '$syscode', '$location_id2', '$uid', '$dlu')";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();

					$client_code =	$syscode;
				} else {
					$sqlcek 	= 	"select syscode from client where name='$client_code' ";
					$resultcek = $dbpdo->prepare($sqlcek);
					$resultcek->execute();
					$datacek		= $resultcek->fetch(PDO::FETCH_OBJ);

					$client_code =	$datacek->syscode;
				}
				//----------------------/\-end cek customer
			}


			$ref2				=	$_POST["ref2"];
			$employee_id		= 	0;
			$top				=	"C.O.D";
			$due_date			=	date("Y-m-d", strtotime($_POST["due_date"]));
			$tax_code			=	"";
			$tax_rate			=	0;
			$freight_cost 		= 	0;
			$freight_account	= 	"";
			$currency_code		=	"";
			$rate				=	0;
			$memo				= 	petikreplace($_POST["memo"]);
			$discount2			=	numberreplace($_POST["discount"]);
			$total				=	$sub_total; //numberreplace($_POST["total"]); //$sub_total; 
			$deposit			=	numberreplace($_POST["deposit"]);
			$total_member		=	numberreplace($_POST["total"]);

			$photo_file			= 	"";

			$cash_amount		=	numberreplace($_POST["cash_amount"]);
			$bank_id			=	(empty($_POST["bank_id"])) ? 0 : $_POST["bank_id"];
			$bank_amount		=	numberreplace($_POST["bank_amount"]);
			$credit_card_code	=	(empty($_POST["credit_card_code"])) ? 0 : $_POST["credit_card_code"];
			$card_amount		=	numberreplace($_POST["card_amount"]);
			$credit_card_no		=	$_POST["credit_card_no"];
			$credit_card_holder	=	petikreplace($_POST["credit_card_holder"]);
			$change_amount		=	numberreplace($_POST["change_amount"]);

			$cash_voucher 		= 	numberreplace($_POST["cash_voucher"]);
			$ovo 				=	numberreplace($_POST["ovo"]);
			$gopay 				=	numberreplace($_POST["gopay"]);

			$sqlstr = "delete from sales_invoice_tmp where ref='$xndf'";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			$sqlstr = "insert into sales_invoice (ref, ref2, date, status, top, due_date, client_code, ship_to, bill_to, tax_code, tax_rate, freight_cost, freight_account, currency_code, rate, employee_id, discount, total, memo, opening_balance, cash, location_id, deposit, taxable, photo_file, cash_amount, bank_id, bank_amount, credit_card_code, card_amount, credit_card_no, credit_card_holder, change_amount, cash_voucher, ovo, gopay, uid, dlu) values('$ref', '$ref2', '$date', '$status', '$top', '$due_date', '$client_code', '$ship_to', '$bill_to', '$tax_code', '$tax_rate', '$freight_cost', '$freight_account', '$currency_code', '$rate', '$employee_id', '$discount2', '$total', '$memo', 0, '$cash', '$location_id', '$deposit', '$taxable', '$photo_file', '$cash_amount', '$bank_id', '$bank_amount', '$credit_card_code', '$card_amount', '$credit_card_no', '$credit_card_holder', '$change_amount', '$cash_voucher', '$ovo', '$gopay', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();

			##jika piutang
			if ($cash == 0) {

				$total = $total - $deposit;
				//insert AR
				$sqlstr = "insert into ar(ref, invoice_no, date, due_date, contact_type, contact_code, contact_other, debit_amount, credit_amount, invoice_type, ref_type, currency_code, rate, exchange_type, exchange_date, top, description, uid, dlu) values('$ref', '$ref', '$date', '$due_date', 'C', '$client_code', '', '$total', 0, 'cashier', 'cashier', '$currency_code', '$rate', '', '', '$top', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			//-----------

			if ($bank_amount > 0) {

				$sqlbnk = "select name, account_code, account_coa from bank where id='$bank_id' ";
				$result = $dbpdo->prepare($sqlbnk);
				$result->execute();
				$data		= $result->fetch(PDO::FETCH_OBJ);

				$cheque_no		= $data->account_code;
				$bank_name		= $data->name;
				$receipt_type	= "transfer";
				$cheque_date	= $date;
				$total			= $bank_amount;
				$account_code	= $data->account_coa;

				//insert ARC
				$sqlstr = "insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}

			if ($card_amount > 0) {

				$sqlbnk = "select name, account_code from credit_card_type where code='$credit_card_code' ";
				$result = $dbpdo->prepare($sqlbnk);
				$result->execute();
				$data		= $result->fetch(PDO::FETCH_OBJ);

				$cheque_no		= $credit_card_no;
				$bank_name		= $data->name;
				$receipt_type	= "card";
				$cheque_date	= $date;
				$total			= $card_amount;
				$account_code	= $data->account_code;

				//insert ARC
				$sqlstr = "insert into arc (ref, date, client_code, cheque_no, bank_name, cheque_date, amount, currency_code, rate, account_code, type, memo, uid, dlu) values('$ref', '$date', '$client_code', '$cheque_no', '$bank_name', '$cheque_date', '$total', '$currency_code', '$rate', '$account_code', '$receipt_type', '$memo', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				//-------delete invoice detail tmp
				$sqlstr = "delete from sales_invoice_tmp where uid='$uid' ";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
			}


			/*
				//----------insert client member detail-------------\/
				$jumlahmember = (empty($_POST['jumlahmember'])) ? 0 : $_POST['jumlahmember'];
				$i = 0;
				$amount_member = $_POST["amount_member"];
				for ($i=0; $i<=$jumlahmember; $i++) {
					$discmember		= numberreplace($_POST[discmember.$i]);
					$memberlimit	= numberreplace($_POST[memberlimit.$i]);
					
					$sql3 = "insert into sales_invoice_discount_detail (ref, discmember, memberlimit, amount_member, line) values ('$ref', '$discmember', '$memberlimit', '$amount_member', '$i')";
					QueryDbTrans($sql3, $success);
					
				}				
				if($amount_member > 0) {
					$sql4 = "insert into sales_invoice_discount (ref, client_code, date, amount) values ('$ref', '$client_code', '$date', '$total_member')";
					QueryDbTrans($sql4, $success);
				}
				//---------------------------------------------------/\
	            */
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert cashier box
	function insert_cashier_box_subdetail()
	{

		$dbpdo = DB::create();

		try {

			$sub_total = 0;
			$ref 			= $_POST['ref'];
			$item_code 		= $_POST['item_code'];
			$uom_code 		= $_POST['uom_code'];
			$line_detail	= $_POST['line_detail'];
			if (!empty($item_code) && !empty($uom_code)) {

				$qty = numberreplace($_POST['qty']);
				$unit_price = numberreplace($_POST['unit_price']);
				$discount = numberreplace($_POST['discount']);
				$discount3 = 0; //numberreplace($_POST['discount3']);
				$amount = numberreplace($_POST['amount']);
				$non_discount = 0; //(empty($_POST['non_discount'])) ? 0 : $_POST['non_discount'];
				$note = ''; //petikreplace($_POST['note']);

				$line = maxline('sales_invoice_subdetail', 'line', 'ref', $ref, '');

				$sqlstr = "insert into sales_invoice_subdetail (ref, item_code, uom_code, qty, unit_price, amount, line_detail, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$unit_price', '$amount', '$line_detail', '$line')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				//----------insert bincard (credit qty)
				/*$sqlstr="insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'cashier', '', '$item_code', '$uom_code', '$unit_price', 0, '$qty', '$amount', '$line', '$uid', '$dlu')";				
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();*/
			}
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}


	//-----insert order stock
	function insert_order_stock($ref)
	{

		$dbpdo = DB::create();

		try {

			$status			= 	"R";
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$memo			=	petikreplace($_POST["memo"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");

			//----------insert item packing detail
			$item_code 		= $_POST['item_code'];
			$uom_code 		= $_POST['uom_code'];
			$qty = numberreplace($_POST['qty']);

			if (!empty($item_code) && !empty($uom_code && $qty > 0)) {

				$line = maxline('order_stock_detail', 'line', 'ref', $ref, '');

				$sqlstr = "insert into order_stock_detail (ref, item_code, uom_code, qty, line) values ('$ref', '$item_code', '$uom_code', '$qty', '$line')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();

				//----------insert bincard (debit qty)
				$sqlstr = "insert into bincard (invoice_no, location_code, date, invoice_type, description, item_code, uom_code, unit_price, debit_qty, credit_qty, amount, line, uid, dlu) values ('$ref', '$location_id', '$date', 'order_stock', '', '$item_code', '$uom_code', '0', '$qty', 0, '0', '$line', '$uid', '$dlu')";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				//------------------------------------/\

			}

			$sqlstr = "insert into order_stock (ref, date, status, memo, location_id, uid, dlu) values('$ref', '$date', '$status', '$memo', '$location_id', '$uid', '$dlu')";
			$sql = $dbpdo->prepare($sqlstr);
			$sql->execute();
		} catch (PDOException $e) {
			echo $e->getMessage();
		}

		return $sql;
	}
}
