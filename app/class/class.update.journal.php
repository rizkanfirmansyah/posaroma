<?php

class update_journal{
	
	//-----journal petty cash receipt
	function journal_cash_receipt($ref){
		$dbpdo = DB::create();
		
		try {
			
			$old_account_code1 = $_POST['old_account_code'];
			
			$ivino			=	$ref;
			$dte			=	date('Y-m-d', strtotime($_POST["date"]));
			$account_code	=	$_POST['account_code'];
			$memo			=	$_POST['memo'];
			//$amount			=	numberreplace($_POST['amount']);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$amount	= 0;
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			$sqlstr	=	"delete from jrn where ivino='$ivino' and ivitpe='cash_receipt' and lne<>0 ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			for ($i=0; $i<=$jmldata; $i++) {
				
				$delete 			= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_account_code 	= 	$_POST[old_account_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$acccde 			= 	$_POST[account_code_.$i];
				$mmo 				= 	$_POST[memo_.$i];
				$crdamt				= 	numberreplace($_POST[credit_amount_.$i]);
				
				$amount				=	$amount + $crdamt;
				
				if($delete == 0) {
					if ($acccde != '') { 		
						
						$j++;
						
						$keycode2	=	$ivino . $acccde;
						if($crdamt > 0) { //credit
							$sqlstr	=	"insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'cash_receipt', '$dte', '$acccde', '$mmo', '0', '$crdamt', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();		
						}
						if($crdamt  < 0) { //debit
							$crdamt = $crdamt * -1;
							$sqlstr	=	"insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'cash_receipt', '$dte', '$acccde', '$mmo', '$crdamt', '0', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();				
						}
											
					}
					
				} else {
					
					$sqlstr	=	"delete from jrn where ivino='$ivino' and ivitpe='cash_receipt' and ='$old_account_code' and lne='$old_line'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
									
				}
				
				
			}
			
			
			$sqlcek = "select ivino from jrn where ivino='$ivino' and ivitpe='cash_receipt' and acccde='$old_account_code1' and lne='0' ";
			$sql=$dbpdo->prepare($sqlcek);
			$sql->execute();
			$num = $sql->rowCount();
			
			if($num > 0) {
				//----------------update journal
				$keycode		=	$ivino . $account_code;		
				if($amount > 0) { 
					##debet
					$sqlstr="update jrn set ividte='$dte', acccde='$account_code', dcr='$memo', dbtamt='$amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='cash_receipt' and acccde='$old_account_code1' and lne='0' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($amount < 0) { 
					##credit
					$amount = $amount * -1;
					$sqlstr="update jrn set ividte='$dte', acccde='$account_code', dcr='$memo', crdamt='$amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='cash_receipt' and acccde='$old_account_code1' and lne='0' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
				}
			} else {
				
				//----------------insert journal
				$keycode		=	$ivino . $account_code;		
				if($amount > 0) { 
					##debet
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'cash_receipt', '$dte', '$account_code', '$memo', '$amount', '0', 'idr', '0', '$keycode', '0', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($amount < 0) { 
					##credit
					$amount = $amount * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'cash_receipt', '$dte', '$account_code', '$memo', '0', '$amount', 'idr', '0', '$keycode', '0', '$uid', '$dlu', '$dlu' )";
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
	
	
	//-----journal petty cash payment
	function journal_cash_payment($ref){
		$dbpdo = DB::create();
		
		try {
			
			$old_account_code1 = $_POST['old_account_code'];
			
			$ivino			=	$ref;
			$dte			=	date('Y-m-d', strtotime($_POST["date"]));
			$account_code	=	$_POST['account_code'];
			$memo			=	$_POST['memo'];
			//$amount			=	numberreplace($_POST['amount']);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$amount	= 0;
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			$sqlstr	=	"delete from jrn where ivino='$ivino' and ivitpe='cash_payment' and lne<>0 ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			for ($i=0; $i<=$jmldata; $i++) {
				
				$delete 			= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_account_code 	= 	$_POST[old_account_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$acccde 			= 	$_POST[account_code_.$i];
				$mmo 				= 	$_POST[memo_.$i];
				$dbtamt				= 	numberreplace($_POST[debit_amount_.$i]);
				
				$amount				=	$amount + $dbtamt;
				
				if($delete == 0) {
					if ($acccde != '') { 		
						
						$j++;
						
						$keycode2	=	$ivino . $acccde;
						if($dbtamt > 0) { //debit
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'cash_payment', '$dte', '$acccde', '$mmo', '$dbtamt', '0', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						if($dbtamt  < 0) { //credit
							$dbtamt = $dbtamt * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'cash_payment', '$dte', '$acccde', '$mmo', '0', '$dbtamt', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
											
					}
					
				} else {
					
					$sqlstr="delete from jrn where ivino='$ivino' and ivitpe='cash_payment' and ='$old_account_code' and lne='$old_line'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
									
				}
				
				
			}
			
			
			$sqlstr = "select ivino from jrn where ivino='$ivino' and ivitpe='cash_payment' and acccde='$old_account_code1' and lne='0' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$num = $sql->rowCount();
			
			if($num > 0) {
				//----------------update journal
				$keycode		=	$ivino . $account_code;		
				if($amount > 0) { 
					##credit
					$sqlstr="update jrn set ividte='$dte', acccde='$account_code', dcr='$memo', crdamt='$amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='cash_payment' and acccde='$old_account_code1' and lne='0' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($amount < 0) { 
					##debet
					$amount = $amount * -1;
					$sqlstr="update jrn set ividte='$dte', acccde='$account_code', dcr='$memo', dbtamt='$amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='cash_payment' and acccde='$old_account_code1' and lne='0' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
				}
			} else {
				
				//----------------insert journal
				$keycode		=	$ivino . $account_code;		
				if($amount > 0) { 
					##credit
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'cash_payment', '$dte', '$account_code', '$memo', '0','$amount', 'idr', '0', '$keycode', '0', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($amount < 0) { 
					##debet
					$amount = $amount * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'cash_payment', '$dte', '$account_code', '$memo', '$amount', '0', 'idr', '0', '$keycode', '0', '$uid', '$dlu', '$dlu' )";
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
	
	
	
	//-----journal direct receipt
	function journal_direct_receipt($ref){
		$dbpdo = DB::create();
		
		try {
		
			$ivino			=	$ref;
			$dte			=	date('Y-m-d', strtotime($_POST["date"]));
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$amount	= 0;
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			$sqlstr="delete from jrn where ivino='$ivino' and ivitpe='direct_receipt' and lne<>0 ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			for ($i=0; $i<=$jmldata; $i++) {
				
				$delete 			= (empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_account_code 	= 	$_POST[old_account_code_.$i];
				$old_line		 	= (empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$account_code 		= $_POST[account_code_.$i];
				$debit_amount 		= numberreplace($_POST[debit_amount_.$i]);
				$credit_amount 		= numberreplace($_POST[credit_amount_.$i]);
				$mmo 				= $_POST[memo_.$i];
				
				if($delete == 0) {
					if (!empty($account_code) && ($debit_amount <> 0 || $credit_amount <> 0)) { 		
						
						$j++;
						
						$keycode2	=	$ivino . $account_code;
						if($debit_amount  > 0) { //debit
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_receipt', '$dte', '$account_code', '$mmo', '$debit_amount', '0', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						if($debit_amount < 0) { //credit
							$debit_amount = $debit_amount * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_receipt', '$dte', '$account_code', '$mmo', '0', '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";		
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();	
						}
						
						//-------------
						$keycode2	=	$ivino . $account_code;
						if($credit_amount  < 0) { //debit
							$credit_amount = credit_amount * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_receipt', '$dte', '$account_code', '$mmo', '$credit_amount', '0', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						if($credit_amount > 0) { //credit
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_receipt', '$dte', '$account_code', '$mmo', '0', '$credit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
											
					}
					
				} else {
					
					$sqlstr="delete from jrn where ivino='$ivino' and ivitpe='direct_receipt' and ='$old_account_code' and lne='$old_line'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
									
				}
				
				
			}
			
			$old_account_code1 	= $_POST['old_account_code'];
			$account_code		=	$_POST['account_code'];
			$memo				=	$_POST['memo'];
			$amount				=	numberreplace($_POST["amount"]);
			
			$sqlstr = "select ivino from jrn where ivino='$ivino' and ivitpe='direct_receipt' and acccde='$old_account_code1' and lne='0' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$num = $sql->rowCount();
			
			if($num > 0) {
				//----------------update journal
				$keycode		=	$ivino . $account_code;		
				if($amount > 0) { 
					##debet
					$sqlstr="update jrn set ividte='$dte', acccde='$account_code', dcr='$memo', dbtamt='$amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='direct_receipt' and acccde='$old_account_code1' and lne='0' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($amount < 0) { 
					##credit
					$amount = $amount * -1;
					$sqlstr="update jrn set ividte='$dte', acccde='$account_code', dcr='$memo', crdamt='$amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='direct_receipt' and acccde='$old_account_code1' and lne='0' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
				}
			} else {
				
				//----------------insert journal
				$keycode		=	$ivino . $account_code;		
				if($amount > 0) { 
					##debet
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_receipt', '$dte', '$account_code', '$memo', '$amount', '0', 'idr', '0', '$keycode', '0', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($amount < 0) { 
					##credit
					$amount = $amount * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_receipt', '$dte', '$account_code', '$memo', '0', '$amount', 'idr', '0', '$keycode', '0', '$uid', '$dlu', '$dlu' )";
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
	
		
	//-----journal direct payment
	function journal_direct_payment($ref){
		$dbpdo = DB::create();
		
		try {
		
			$ivino			=	$ref;
			$dte			=	date('Y-m-d', strtotime($_POST["date"]));
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			$sqlstr="delete from jrn where ivino='$ivino' and ivitpe='direct_payment' and lne<>0 ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			for ($i=0; $i<=$jmldata; $i++) {
				
				$delete 			= 	(empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_account_code 	= 	$_POST[old_account_code_.$i];
				$old_line		 	= 	(empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$account_code 		= 	$_POST[account_code_.$i];
				$debit_amount 		= 	numberreplace($_POST[debit_amount_.$i]);
				$credit_amount 		= 	numberreplace($_POST[credit_amount_.$i]);
				$mmo 				= 	$_POST[memo_.$i];
							
				if($delete == 0) {
					if ( !empty($account_code) && ($debit_amount <> 0 || $credit_amount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ivino . $account_code;
						if($debit_amount > 0) { //debit
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_payment', '$dte', '$account_code', '$mmo', '$debit_amount', '0', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						if($debit_amount  < 0) { //credit
							$debit_amount = $debit_amount * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_payment', '$dte', '$acccde', '$mmo', '0', '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
						//------------
						if($credit_amount  < 0) { //credit
							$credit_amount = credit_amount * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_payment', '$dte', '$account_code', '$mmo', '0', '$credit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						if($credit_amount > 0) { //debit
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_payment', '$dte', '$account_code', '$mmo', '$credit_amount', '0', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
											
					}
					
				} else {
					
					$sqlstr="delete from jrn where ivino='$ivino' and ivitpe='direct_payment' and ='$old_account_code' and lne='$old_line'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
									
				}
				
				
			}
			
			
			$old_account_code1 	= 	$_POST['old_account_code'];
			$account_code		=	$_POST['account_code'];
			$amount				=	numberreplace($_POST["amount"]);
			$memo				=	$_POST['memo'];
			
			$sqlstr = "select ivino from jrn where ivino='$ivino' and ivitpe='direct_payment' and acccde='$old_account_code1' and lne='0' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			$num = $sql->rowCount();
			
			if($num > 0) {
				//----------------update journal
				$keycode		=	$ivino . $account_code;		
				if($amount > 0) { 
					##credit
					$sqlstr="update jrn set ividte='$dte', acccde='$account_code', dcr='$memo', crdamt='$amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='direct_payment' and acccde='$old_account_code1' and lne='0' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($amount < 0) { 
					##debet
					$amount = $amount * -1;
					$sqlstr="update jrn set ividte='$dte', acccde='$account_code', dcr='$memo', dbtamt='$amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='direct_payment' and acccde='$old_account_code1' and lne='0' ";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
				}
			} else {
				
				//----------------insert journal
				$keycode		=	$ivino . $account_code;		
				if($amount > 0) { 
					##credit
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'direct_payment', '$dte', '$account_code', '$memo', '0','$amount', 'idr', '0', '$keycode', '0', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($amount < 0) { 
					##debet
					$amount = $amount * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'cash_payment', '$dte', '$account_code', '$memo', '$amount', '0', 'idr', '0', '$keycode', '0', '$uid', '$dlu', '$dlu' )";
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
	
	
	//-----journal delivery order
	function journal_delivery_order($ref){
		$dbpdo = DB::create();
		
		try {
		
			$ivino			=	$ref;
			$dte			=	date('Y-m-d', strtotime($_POST["date"]));
			$memo			=	$_POST['memo'];
			$location_id	= 	$_POST["location_id"];
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='delivery_order' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				$so_ref			= $memo . "( " . $_POST[so_ref_.$i] . " )";
				$qty 			= numberreplace($_POST[qty_.$i]);
				
				//----------get avarege cost
				$sqlpi 			= "select sum(ifnull(a.unit_cost,0)) unit_cost, sum(ifnull(a.qty,0)) qty from purchase_invoice_detail a where a.item_code='$item_code' and a.uom_code='$uom_code' group by a.item_code, a.uom_code";
				$sql=$dbpdo->prepare($sqlpi);
				$sql->execute();
			
				$datapi			=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($datapi->qty == 0) {
					$average_cost 	= 	$datapi->unit_cost;
				} else {
					$average_cost 	= 	$datapi->unit_cost / $datapi->qty;
				}			
				//------------------------/\
				
				//---------get item group
				$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code' and a.uom_code_purchase='$uom_code'";
				$sql=$dbpdo->prepare($sqlitm);
				$sql->execute();		
				$dataitm	=	$sql->fetch(PDO::FETCH_OBJ);
				//------------------/\
				
				//-------get account from item type
				$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id='$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmtype);
				$sql->execute();
				$dataitmtype	=	$sql->fetch(PDO::FETCH_OBJ);
				
				$inventory_acccode			=	$dataitmtype->inventory_acccode;
				$productcost_acccode		=	$dataitmtype->productcost_acccode;
				$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
				$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
				$cogs_acccode				=	$dataitmtype->cogs_acccode;
				//---------------------------------/\
				
				//------get account code from item group
				$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id='$location_id' ";
				$sql=$dbpdo->prepare($sqlitmgrp);
				$sql->execute();
				$dataitmgrp	=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($inventory_acccode == "") { $inventory_acccode			=	$dataitmgrp->inventory_acccode; }
				if($cogs_acccode == "") { $cogs_acccode				=	$dataitmgrp->cogs_acccode;}
				if($goodintransit_acccode == "") { $goodintransit_acccode		=	$dataitmgrp->goodintransit_acccode;}
				$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
				if($workinprocess_acccode == "") { $workinprocess_acccode		=	$dataitmgrp->workinprocess_acccode;}
				$consignment_acccode		=	$dataitmgrp->consignment_acccode;
				//---------------------------------------/\
				
				//---------barang dalam perjalanan			
				if ( !empty($goodintransit_acccode) && $average_cost <> 0 ) {					
					
					$j++;
					
					//------------
					$keycode2	=	$ivino . $goodintransit_acccode;	
					if($average_cost  < 0) { //credit
						$credit_amount = ($average_cost * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ivino', 'delivery_order', '$dte', '$goodintransit_acccode', '$so_ref', '0', '$credit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					if($average_cost > 0) { //debit
						$credit_amount = $average_cost * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ivino', 'delivery_order', '$dte', '$goodintransit_acccode', '$so_ref', '$credit_amount', '0', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
				}	
				
				//-------------inventory account
				$amountcost = $average_cost * $qty; 
				if ( !empty($inventory_acccode) && $amountcost <> 0 ) {					
					
					$j++;
					
					//------------
					$keycode2	=	$ivino . $inventory_acccode;	
					if($amountcost  < 0) { //debit
						$credit_amount = $amountcost * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ivino', 'delivery_order', '$dte', '$inventory_acccode', '$so_ref', '$credit_amount', '0', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					if($amountcost > 0) { //credit
						$credit_amount = $amountcost;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ivino', 'delivery_order', '$dte', '$inventory_acccode', '$so_ref', '0', '$credit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
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
	
	
	//-----journal sales 
	function journal_cash_invoice($ref){
		$dbpdo = DB::create();
		
		try {
		
			$ref2			= 	$_POST["ref2"];
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];
			if($taxable == 0) {
				$ref2		= 	"";
			}
			
			$status			= 	$_POST["status"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$cash			=	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$phone			=	$_POST["phone"];
			$ship_to		=	$_POST["ship_to"];
			$bill_to		=	$_POST["bill_to"];
			$discount2	 	= 	numberreplace($_POST["discount"]);
			$memo			=	petikreplace($_POST["memo"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//---------get client code
			$sqlinv			=	"select a.client_code from sales_invoice a where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlinv);
			$sql->execute();
			$datainv		=	$sql->fetch(PDO::FETCH_OBJ);		
			$client_code	=	$datainv->client_code;
			
			//-------get client type
			$sqlclient		=	"select a.client_type from client a where a.syscode='$client_code' ";
			$sql=$dbpdo->prepare($sqlclient);
			$sql->execute();
			$dataclient		=	$sql->fetch(PDO::FETCH_OBJ);
			//--------------------/\
			
			//------get account code from client type
			$sqlclntpe		=	"select a.sls_account, a.sls_cash_account, a.sls_return_account, a.sls_discount_account, a.client_deposit_account, a.currency_account, a.cheque_receivable_account, a.sls_account2 from client_type_detail a where a.id_header='$dataclient->client_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlclntpe);
			$sql->execute();
			$dataclntpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$sls_account				=	$dataclntpe->sls_account;
			$sls_account2				=	$dataclntpe->sls_account2;
			$sls_cash_account			=	$dataclntpe->sls_cash_account;
			$sls_return_account			=	$dataclntpe->sls_return_account;
			$sls_discount_account		=	$dataclntpe->sls_discount_account;
			$client_deposit_account		=	$dataclntpe->client_deposit_account;
			$cheque_receivable_account	=	$dataclntpe->cheque_receivable_account;
			
			if($cash == 1) {
				$sls_account = $sls_cash_account;
			}
			//-------------------------------------/\
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				$qty 			= numberreplace($_POST[qty_.$i]);
				$unit_price 	= numberreplace($_POST[unit_price_.$i]);
				$amount 		= numberreplace($_POST[amount_.$i]);
				$discount 		= numberreplace($_POST[discount_.$i]);
				
				$sub_total		= $sub_total + $amount;
				
				//----------get avarege cost
				$sqlpi 			= 	"select sum(ifnull(a.unit_cost,0)) unit_cost, sum(ifnull(a.qty,0)) qty from purchase_invoice_detail a where a.item_code='$item_code' and a.uom_code='$uom_code' group by a.item_code, a.uom_code";
				$sql=$dbpdo->prepare($sqlpi);
				$sql->execute();
				$datapi		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($datapi->qty == 0) {
					$average_cost 	= 	$datapi->unit_cost;
				} else {
					$average_cost 	= 	$datapi->unit_cost / $datapi->qty;
				}			
				//------------------------/\
				
				//---------get item group
				$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code' and a.uom_code_sales='$uom_code'";
				$sql=$dbpdo->prepare($sqlitm);
				$sql->execute();
				$dataitm		=	$sql->fetch(PDO::FETCH_OBJ);
				//------------------/\
				
				//-------get account from item type
				$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmtype);
				$sql->execute();
				$dataitmtype		=	$sql->fetch(PDO::FETCH_OBJ);
				
				$inventory_acccode			=	$dataitmtype->inventory_acccode;
				$productcost_acccode		=	$dataitmtype->productcost_acccode;
				$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
				$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
				$cogs_acccode				=	$dataitmtype->cogs_acccode;
				//---------------------------------/\
				
				//------get account code from item group
				$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmgrp);
				$sql->execute();
				$dataitmgrp		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($inventory_acccode == "") { $inventory_acccode =	$dataitmgrp->inventory_acccode; }
				if($cogs_acccode == "") { $cogs_acccode	=	$dataitmgrp->cogs_acccode; }
				if($goodintransit_acccode == "") { $goodintransit_acccode =	$dataitmgrp->goodintransit_acccode; }
				$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
				if($workinprocess_acccode == "") { $workinprocess_acccode =	$dataitmgrp->workinprocess_acccode; }
				$consignment_acccode		=	$dataitmgrp->consignment_acccode;
				//---------------------------------------/\
				
				if($cash == 1) {	
					if ( !empty($sls_account) && ($amount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ref . $sls_account;
						if($amount > 0) { //credit
							$debit_amount = $unit_price * $qty;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();		
						}
						
						if($amount < 0) { //debit
							$debit_amount = ($unit_price * $qty) * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
					}
				} else {
					
					if ( !empty($sls_account2) && ($amount <> 0) ) { 		
					
						$j++;
						
						$keycode2	=	$ref . $sls_account2;
						if($amount > 0) { //credit
							$debit_amount = $unit_price * $qty;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account2', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
						if($amount < 0) { //debit
							$debit_amount = ($unit_price * $qty) * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account2', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
					}
				
				}
					
							
				if ( !empty($productcost_acccode) && ($average_cost <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $productcost_acccode;
					if($average_cost > 0) { //debit
						$debit_amount = $average_cost * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$productcost_acccode', '$memo', '$debit_amount', '0', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($average_cost < 0) { //credit
						$debit_amount = ($average_cost * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$productcost_acccode', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				} 
				
				
				if ( !empty($goodintransit_acccode) && ($average_cost <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $goodintransit_acccode;
					if($average_cost > 0) { //credit
						$debit_amount = $average_cost * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$goodintransit_acccode', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($average_cost < 0) { //debit
						$debit_amount = ($average_cost * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$goodintransit_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				} 
				
				
				//--------------discount detail
				if ( !empty($sls_discount_account) && ($discount <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $sls_discount_account;
					if($discount > 0) { //debit
						$debit_amount = $discount * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($discount < 0) { //credit
						$debit_amount = ($discount * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}			
				
			}
			
			
			//--------discoutn total (header)
			if ( !empty($sls_discount_account) && ($discount2 <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $sls_discount_account;
				if($discount2 > 0) { //debit
					$debit_amount = $discount2;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($discount2 < 0) { //credit
					$debit_amount = ($discount2) * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}		
			
			//---------penjualan
			//$total		=   $sub_total;
			$total	=	numberreplace($_POST["total"]);
			$deposit	=	numberreplace($_POST["deposit"]);
			if($deposit <> 0) {
				$total = $total - $deposit;
			}		
			
			if($cash == 1) {
				$sls_account = $sls_account2;
			
				$total	=	numberreplace($_POST["total"]);
				if ( !empty($sls_account) && ($total <> 0) ) { 		
						
					$j++;
					
					$keycode2	=	$ref . $sls_account;
					if($total > 0) { //debit
						$debit_amount = $total;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($total < 0) { //credit
						$debit_amount = $total * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
			} else {
				
				if ( !empty($sls_account) && ($total <> 0) ) { 		
						
					$j++;
					
					$keycode2	=	$ref . $sls_account;
					if($total > 0) { //debit
						$debit_amount = $total;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($total < 0) { //credit
						$debit_amount = $total * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
				
			}
			
			
			
			//----------Uang Muka		
			if ( !empty($client_deposit_account) && ($deposit <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $client_deposit_account;
				if($deposit > 0) { //debit
					$debit_amount = $deposit;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$client_deposit_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($deposit < 0) { //credit
					$debit_amount = $deposit * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$client_deposit_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			//----------ongkos kirim
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			if ( !empty($freight_account) && ($freight_cost <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $freight_account;
				if($freight_cost > 0) { //credit
					$debit_amount = $freight_cost;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$freight_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($freight_cost < 0) { //debit
					$debit_amount = $freight_cost * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$freight_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			
			//----------pajak (ppn)
			$tax_code	=	$_POST["tax_code"];
			
			$sqltax 	=	"select a.tax_account from tax a where a.syscode='$tax_code' ";
			$sql=$dbpdo->prepare($sqltax);
			$sql->execute();
			$datatax	=	$sql->fetch(PDO::FETCH_OBJ);
			$tax_account=	$datatax->tax_account;
			
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			if ( !empty($tax_account) && ($tax_total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $tax_account;
				if($tax_total > 0) { //credit
					$debit_amount = $tax_total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$tax_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($tax_total < 0) { //debit
					$debit_amount = $tax_total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$tax_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
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
	
	
	//-----journal good receipt
	function journal_good_receipt($ref){
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
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='good_receipt' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];		
			for ($i=0; $i<=$jmldata; $i++) {
				$po_ref 		= $_POST[po_ref_.$i];
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				$qty 			= numberreplace($_POST[qty_.$i]);
				$unit_cost 		= numberreplace($_POST[unit_cost_.$i]);
				$amount			= $qty * $unit_cost;
				
				//---------get hutang_belum_faktur account
				$sqlpo = "select c.hutang_belum_faktur from purchase_order a left join vendor b on a.vendor_code=b.syscode left join vendor_type_detail c on b.vendor_type=c.id_header where a.ref='$po_ref' and c.location_id='$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlpo);
				$sql->execute();
				$datapo		=	$sql->fetch(PDO::FETCH_OBJ);
				$hutang_belum_faktur = $datapo->hutang_belum_faktur;
				//------------------/\
				
				
				//---------get item group
				$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code'"; // and a.uom_code_purchase='$uom_code'  ";
				$sql=$dbpdo->prepare($sqlitm);
				$sql->execute();
				$dataitm		=	$sql->fetch(PDO::FETCH_OBJ);
				//------------------/\
				
				//-------get account from item type
				$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id='$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmtype);
				$sql->execute();
				$dataitmtype		=	$sql->fetch(PDO::FETCH_OBJ);
				
				$inventory_acccode			=	$dataitmtype->inventory_acccode;
				$productcost_acccode		=	$dataitmtype->productcost_acccode;
				$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
				$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
				$cogs_acccode				=	$dataitmtype->cogs_acccode;
				//---------------------------------/\
				
				//------get account code from item group
				$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id='$location_id' limit 1 ";	
				$sql=$dbpdo->prepare($sqlitmgrp);
				$sql->execute();
				$dataitmgrp		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($inventory_acccode == "") { $inventory_acccode	=	$dataitmgrp->inventory_acccode; }
				if($cogs_acccode == "") { $cogs_acccode	 =	$dataitmgrp->cogs_acccode;}
				if($goodintransit_acccode == "") { $goodintransit_acccode =	$dataitmgrp->goodintransit_acccode;}
				$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
				if($workinprocess_acccode == "") { $workinprocess_acccode =	$dataitmgrp->workinprocess_acccode;}
				$consignment_acccode		=	$dataitmgrp->consignment_acccode;
				//---------------------------------------/\
				
				$ivino = $ref;
				$dte = $date;
				//---------hutang belum difakturkan			
				if ( !empty($hutang_belum_faktur) && $amount <> 0 ) {					
					
					$j++;
					
					//------------
					$keycode2	=	$ivino . $hutang_belum_faktur;	
					if($amount  > 0) { //credit
						$credit_amount = $amount;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ivino', 'good_receipt', '$dte', '$hutang_belum_faktur', '$po_ref', '0', '$credit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					if($amount < 0) { //debit
						$credit_amount = $amount * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ivino', 'good_receipt', '$dte', '$hutang_belum_faktur', '$po_ref', '$credit_amount', '0', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
				}	
				
				
				//-------------inventory account
				if ( !empty($inventory_acccode) && $amount <> 0 ) {					
					
					$j++;
					
					//------------
					$keycode2	=	$ivino . $inventory_acccode;	
					if($amount  > 0) { //debit
						$credit_amount = $amount;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ivino', 'good_receipt', '$dte', '$inventory_acccode', '$po_ref', '$credit_amount', '0', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					if($amount < 0) { //credit
						$credit_amount = $amount  * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ivino', 'good_receipt', '$dte', '$inventory_acccode', '$po_ref', '0', '$credit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
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
	
	
	
	//-----journal purchase 
	function journal_purchase_invoice($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$total				=	$sub_total;
			$memo				= 	petikreplace($_POST["memo"]);
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			//-------get vendor type
			$sqlvendor		=	"select a.vendor_type from vendor a where a.syscode='$vendor_code' ";
			$sql=$dbpdo->prepare($sqlvendor);
			$sql->execute();
			$datavendor		=	$sql->fetch(PDO::FETCH_OBJ);
			//--------------------/\
			
			//------get account code from vendor type
			$location_id	= $_SESSION["location_id2"];
			$sqlvdrtpe		=	"select a.pch_account, a.pch_cash_account, a.pch_return_account, a.pch_discount_account, a.vendor_deposit_account, a.currency_account, a.cheque_payable_account from vendor_type_detail a where a.id_header='$datavendor->vendor_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlvdrtpe);
			$sql->execute();
			$datavdrtpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$pch_account				=	$datavdrtpe->pch_account;
			$pch_cash_account			=	$datavdrtpe->pch_cash_account;
			$pch_return_account			=	$datavdrtpe->pch_return_account;
			$pch_discount_account		=	$datavdrtpe->pch_discount_account;
			$vendor_deposit_account		=	$datavdrtpe->vendor_deposit_account;
			$currency_account			=	$datavdrtpe->currency_account;
			$cheque_payable_account	=	$datavdrtpe->cheque_payable_account;
			//-------------------------------------/\
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_invoice' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$po_ref 		= $_POST[po_ref_.$i];
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				//if ( !empty($item_code) && !empty($uom_code) && $select == 1) {
					
					$qty = numberreplace($_POST[qty_.$i]);
					$unit_cost = numberreplace($_POST[unit_cost_.$i]);
					$amount = $qty * $unit_cost;
					
					$sub_total = $sub_total + $amount;
					//----------get avarege cost
					/*$sqlpi 			= 	"select sum(ifnull(a.unit_cost,0)) unit_cost, sum(ifnull(a.qty,0)) qty from purchase_invoice_detail a where a.item_code='$item_code' and a.uom_code='$uom_code' group by a.item_code, a.uom_code";
					
					$resultpi		=	mysql_query($sqlpi);
					$datapi			=	mysql_fetch_object($resultpi);
					
					if($datapi->qty == 0) {
						$average_cost 	= 	$datapi->unit_cost;
					} else {
						$average_cost 	= 	$datapi->unit_cost / $datapi->qty;
					}			
					//------------------------/\
					*/
					//---------get item group
					$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code'"; // and a.uom_code_sales='$uom_code'";
					$sql=$dbpdo->prepare($sqlitm);
					$sql->execute();
					$dataitm		=	$sql->fetch(PDO::FETCH_OBJ);
					//------------------/\
					
					//-------get account from item type
					$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id = '$location_id' limit 1 ";
					$sql=$dbpdo->prepare($sqlitmtype);
					$sql->execute();
					$dataitmtype		=	$sql->fetch(PDO::FETCH_OBJ);
					
					$inventory_acccode			=	$dataitmtype->inventory_acccode;
					$productcost_acccode		=	$dataitmtype->productcost_acccode;
					$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
					$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
					$cogs_acccode				=	$dataitmtype->cogs_acccode;
					//---------------------------------/\
					
					//------get account code from item group
					$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id = '$location_id' limit 1 ";
					$sql=$dbpdo->prepare($sqlitmgrp);
					$sql->execute();
					$dataitmgrp		=	$sql->fetch(PDO::FETCH_OBJ);
					
					if($inventory_acccode == "") { $inventory_acccode			=	$dataitmgrp->inventory_acccode; }
					if($cogs_acccode == "") { $cogs_acccode				=	$dataitmgrp->cogs_acccode; }
					if($goodintransit_acccode == "") { $goodintransit_acccode		=	$dataitmgrp->goodintransit_acccode; }
					$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
					if($workinprocess_acccode == "") { $workinprocess_acccode		=	$dataitmgrp->workinprocess_acccode; }
					$consignment_acccode		=	$dataitmgrp->consignment_acccode;
					//---------------------------------------/\
					
					//---------inventory journal
					if ( !empty($inventory_acccode) && ($amount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ref . $inventory_acccode;
						if($amount > 0) { //debit
							$debit_amount = $amount;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$inventory_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
						if($amount < 0) { //credit
							$debit_amount = $amount * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$inventory_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
					}
					
					/*
					if ( !empty($sls_discount_account) && ($discount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ref . $sls_discount_account;
						if($discount > 0) { //debit
							$debit_amount = $discount * $qty;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$sls_discount_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";			
						}
						
						if($discount < 0) { //credit
							$debit_amount = ($discount * $qty) * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$sls_discount_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";			
						}
						
					}*/	
					
				//}		
				
			}
			
			
			//---------pembelian		
			$total	=	$sub_total;
			if ( !empty($pch_account) && ($total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $pch_account;
				if($total > 0) { //credit
					$debit_amount = $total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$pch_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($total < 0) { //debit
					$debit_amount = $total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$pch_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			//----------ongkos kirim
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			if ( !empty($freight_account) && ($freight_cost <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $freight_account;
				if($freight_cost > 0) { //debit
					$debit_amount = $freight_cost;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$freight_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($freight_cost < 0) { //credit
					$debit_amount = $freight_cost * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$freight_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			
			//----------pajak (ppn)		
			$tax_code	=	$_POST["tax_code"];
			
			$sqltax 	=	"select a.tax_account from tax a where a.syscode='$tax_code' ";
			$sql=$dbpdo->prepare($sqltax);
			$sql->execute();
			$datatax	=	$sql->fetch(PDO::FETCH_OBJ);
			$tax_account=	$datatax->tax_account;
			
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			if ( !empty($tax_account) && ($tax_total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $tax_account;
				if($tax_total > 0) { //debit
					$debit_amount = $tax_total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$tax_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($tax_total < 0) { //credit
					$debit_amount = $tax_total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$tax_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
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
	
	
	//-----journal purchase quick
	function journal_purchase_quick($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$total				=	$sub_total;
			$memo				= 	petikreplace($_POST["memo"]);		
			$cash				= 	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			//-------get vendor type
			$sqlvendor		=	"select a.vendor_type from vendor a where a.syscode='$vendor_code' ";
			$sql=$dbpdo->prepare($sqlvendor);
			$sql->execute();
			$datavendor	=	$sql->fetch(PDO::FETCH_OBJ);
			//--------------------/\
			
			//------get account code from vendor type
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$sqlvdrtpe		=	"select a.pch_account, a.pch_cash_account, a.pch_return_account, a.pch_discount_account, a.vendor_deposit_account, a.currency_account, a.cheque_payable_account from vendor_type_detail a where a.id_header='$datavendor->vendor_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlvdrtpe);
			$sql->execute();
			$datavdrtpe	=	$sql->fetch(PDO::FETCH_OBJ);
			
			$pch_account				=	$datavdrtpe->pch_account;
			$pch_cash_account			=	$datavdrtpe->pch_cash_account;
			$pch_return_account			=	$datavdrtpe->pch_return_account;
			$pch_discount_account		=	$datavdrtpe->pch_discount_account;
			$vendor_deposit_account		=	$datavdrtpe->vendor_deposit_account;
			$currency_account			=	$datavdrtpe->currency_account;
			$cheque_payable_account		=	$datavdrtpe->cheque_payable_account;
			//-------------------------------------/\
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_quick' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$po_ref 		= $_POST[po_ref_.$i];
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				//if ( !empty($item_code) && !empty($uom_code) && $select == 1) {
					
					$qty = numberreplace($_POST[qty_.$i]);
					$unit_cost = numberreplace($_POST[unit_cost_.$i]);
					$amount = $qty * $unit_cost;
					
					$sub_total = $sub_total + $amount;
					//----------get avarege cost
					/*$sqlpi 			= 	"select sum(ifnull(a.unit_cost,0)) unit_cost, sum(ifnull(a.qty,0)) qty from purchase_invoice_detail a where a.item_code='$item_code' and a.uom_code='$uom_code' group by a.item_code, a.uom_code";
					
					$resultpi		=	mysql_query($sqlpi);
					$datapi			=	mysql_fetch_object($resultpi);
					
					if($datapi->qty == 0) {
						$average_cost 	= 	$datapi->unit_cost;
					} else {
						$average_cost 	= 	$datapi->unit_cost / $datapi->qty;
					}			
					//------------------------/\
					*/
					//---------get item group
					$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code'"; // and a.uom_code_sales='$uom_code'";
					$sql=$dbpdo->prepare($sqlitm);
					$sql->execute();
					$dataitm	=	$sql->fetch(PDO::FETCH_OBJ);
					//------------------/\
					
					//-------get account from item type
					$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id = '$location_id' limit 1 ";
					$sql=$dbpdo->prepare($sqlitmtype);
					$sql->execute();
					$dataitmtype	=	$sql->fetch(PDO::FETCH_OBJ);
					
					$inventory_acccode			=	$dataitmtype->inventory_acccode;
					$productcost_acccode		=	$dataitmtype->productcost_acccode;
					$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
					$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
					$cogs_acccode				=	$dataitmtype->cogs_acccode;
					//---------------------------------/\
					
					//------get account code from item group
					$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id = '$location_id' limit 1 ";
					$sql=$dbpdo->prepare($sqlitmgrp);
					$sql->execute();
					$dataitmgrp	=	$sql->fetch(PDO::FETCH_OBJ);
					
					if($inventory_acccode == "") { $inventory_acccode			=	$dataitmgrp->inventory_acccode; }
					if($cogs_acccode == "") { $cogs_acccode				=	$dataitmgrp->cogs_acccode; }
					if($goodintransit_acccode == "") { $goodintransit_acccode		=	$dataitmgrp->goodintransit_acccode; }
					$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
					if($workinprocess_acccode == "") { $workinprocess_acccode		=	$dataitmgrp->workinprocess_acccode; }
					$consignment_acccode		=	$dataitmgrp->consignment_acccode;
					//---------------------------------------/\
					
					
					//---------inventory journal
					if ( !empty($inventory_acccode) && ($amount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ref . $inventory_acccode;
						if($amount > 0) { //debit
							$debit_amount = $amount;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_quick', '$date', '$inventory_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						}
						
						if($amount < 0) { //credit
							$debit_amount = $amount * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_quick', '$date', '$inventory_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
					}
					
					/*
					if ( !empty($sls_discount_account) && ($discount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ref . $sls_discount_account;
						if($discount > 0) { //debit
							$debit_amount = $discount * $qty;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$sls_discount_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";			
						}
						
						if($discount < 0) { //credit
							$debit_amount = ($discount * $qty) * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$sls_discount_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";			
						}
						
					}*/	
					
				//}		
				
			}
			
			
			//---------pembelian		
			$total	=	$sub_total + $freight_cost;
			if ( !empty($pch_account) && ($total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $pch_account;
				if($total > 0) { //credit
					$debit_amount = $total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_quick', '$date', '$pch_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($total < 0) { //debit
					$debit_amount = $total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_quick', '$date', '$pch_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			//----------ongkos kirim		
			$freight_account	= 	$_POST["freight_account"];
			if ( !empty($freight_account) && ($freight_cost <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $freight_account;
				if($freight_cost > 0) { //debit
					$debit_amount = $freight_cost;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_quick', '$date', '$freight_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($freight_cost < 0) { //credit
					$debit_amount = $freight_cost * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_quick', '$date', '$freight_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			
			//----------pajak (ppn)		
			$tax_code	=	$_POST["tax_code"];
			
			$sqltax 	=	"select a.tax_account from tax a where a.syscode='$tax_code' ";
			$sql=$dbpdo->prepare($sqltax);
			$sql->execute();
			$datatax	=	$sql->fetch(PDO::FETCH_OBJ);
			$tax_account=	$datatax->tax_account;
			
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			if ( !empty($tax_account) && ($tax_total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $tax_account;
				if($tax_total > 0) { //debit
					$debit_amount = $tax_total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_quick', '$date', '$tax_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($tax_total < 0) { //credit
					$debit_amount = $tax_total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_quick', '$date', '$tax_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
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
	
	
	//-----journal purchase issued
	function journal_purchase_issue($ref){
		$dbpdo = DB::create();
		
		try {
		
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$total				=	$sub_total;
			$memo				= 	petikreplace($_POST["memo"]);		
			$cash				= 	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			//-------get vendor type
			$sqlvendor		=	"select a.vendor_type from vendor a where a.syscode='$vendor_code' ";
			$sql=$dbpdo->prepare($sqlvendor);
			$sql->execute();
			$datavendor		=	$sql->fetch(PDO::FETCH_OBJ);
			//--------------------/\
			
			//------get account code from vendor type
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$sqlvdrtpe		=	"select a.pch_account, a.pch_cash_account, a.pch_return_account, a.pch_discount_account, a.vendor_deposit_account, a.currency_account, a.cheque_payable_account from vendor_type_detail a where a.id_header='$datavendor->vendor_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlvdrtpe);
			$sql->execute();
			$datavdrtpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$pch_account				=	$datavdrtpe->pch_account;
			$pch_cash_account			=	$datavdrtpe->pch_cash_account;
			$pch_return_account			=	$datavdrtpe->pch_return_account;
			$pch_discount_account		=	$datavdrtpe->pch_discount_account;
			$vendor_deposit_account		=	$datavdrtpe->vendor_deposit_account;
			$currency_account			=	$datavdrtpe->currency_account;
			$cheque_payable_account		=	$datavdrtpe->cheque_payable_account;
			//-------------------------------------/\
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_issue' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$po_ref 		= $_POST[po_ref_.$i];
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				//if ( !empty($item_code) && !empty($uom_code) && $select == 1) {
					
					$qty = numberreplace($_POST[qty_.$i]);
					$unit_cost = numberreplace($_POST[unit_cost_.$i]);
					$amount = $qty * $unit_cost;
					
					$sub_total = $sub_total + $amount;
					
					//---------get item group
					$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code'"; // and a.uom_code_sales='$uom_code'";
					$sql=$dbpdo->prepare($sqlitm);
					$sql->execute();
					$dataitm		=	$sql->fetch(PDO::FETCH_OBJ);
					//------------------/\
					
					//-------get account from item type
					$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id = '$location_id' limit 1 ";
					$sql=$dbpdo->prepare($sqlitmtype);
					$sql->execute();
					$dataitmtype		=	$sql->fetch(PDO::FETCH_OBJ);
					
					$inventory_acccode			=	$dataitmtype->inventory_acccode;
					$productcost_acccode		=	$dataitmtype->productcost_acccode;
					$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
					$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
					$cogs_acccode				=	$dataitmtype->cogs_acccode;
					//---------------------------------/\
					
					//------get account code from item group
					$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id = '$location_id' limit 1 ";
					$sql=$dbpdo->prepare($sqlitmgrp);
					$sql->execute();
					$dataitmgrp		=	$sql->fetch(PDO::FETCH_OBJ);
					
					if($inventory_acccode == "") { $inventory_acccode			=	$dataitmgrp->inventory_acccode; }
					if($cogs_acccode == "") { $cogs_acccode				=	$dataitmgrp->cogs_acccode; }
					if($goodintransit_acccode == "") { $goodintransit_acccode		=	$dataitmgrp->goodintransit_acccode; }
					$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
					if($workinprocess_acccode == "") { $workinprocess_acccode		=	$dataitmgrp->workinprocess_acccode; }
					$consignment_acccode		=	$dataitmgrp->consignment_acccode;
					//---------------------------------------/\
					
					
					//---------inventory journal
					if ( !empty($inventory_acccode) && ($amount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ref . $inventory_acccode;
						if($amount > 0) { //debit
							$debit_amount = $amount;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_issue', '$date', '$inventory_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
						if($amount < 0) { //credit
							$debit_amount = $amount * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_issue', '$date', '$inventory_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
					}
					
				
			}
			
			//---------pembelian		
			$total	=	$sub_total + $freight_cost;
			if ( !empty($pch_account) && ($total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $pch_account;
				if($total > 0) { //credit
					$debit_amount = $total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_issue', '$date', '$pch_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($total < 0) { //debit
					$debit_amount = $total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_issue', '$date', '$pch_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			//----------ongkos kirim		
			$freight_account	= 	$_POST["freight_account"];
			if ( !empty($freight_account) && ($freight_cost <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $freight_account;
				if($freight_cost > 0) { //debit
					$debit_amount = $freight_cost;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_issue', '$date', '$freight_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($freight_cost < 0) { //credit
					$debit_amount = $freight_cost * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_issue', '$date', '$freight_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			
			//----------pajak (ppn)		
			$tax_code	=	$_POST["tax_code"];
			
			$sqltax 	=	"select a.tax_account from tax a where a.syscode='$tax_code' ";
			$sql=$dbpdo->prepare($sqltax);
			$sql->execute();
			$datatax		=	$sql->fetch(PDO::FETCH_OBJ);
			$tax_account=	$datatax->tax_account;
			
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			if ( !empty($tax_account) && ($tax_total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $tax_account;
				if($tax_total > 0) { //debit
					$debit_amount = $tax_total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_issue', '$date', '$tax_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($tax_total < 0) { //credit
					$debit_amount = $tax_total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_issue', '$date', '$tax_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
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
	
	
	//-----journal payment
	function journal_payment($ref){
		$dbpdo = DB::create();
		
		try {
			
			$ivino			=	$ref;
			$vendor_code	=	$_POST["vendor_code"];
			$dte			=	date('Y-m-d', strtotime($_POST["date"]));
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//------get account code from vendor type
			$vdrquery	=	"select vendor_type from vendor where syscode='$vendor_code'";
			$sql=$dbpdo->prepare($vdrquery);
			$sql->execute();
			$datavdrtpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$location_id	= $_SESSION["location_id2"];
			$sqlvdrtpe		=	"select a.pch_account, a.pch_cash_account, a.pch_return_account, a.pch_discount_account, a.vendor_deposit_account, a.currency_account, a.cheque_payable_account from vendor_type_detail a where a.id_header='$datavdrtpe->vendor_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlvdrtpe);
			$sql->execute();
			$datavdrtpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$pch_account				=	$datavdrtpe->pch_account;
			$pch_cash_account			=	$datavdrtpe->pch_cash_account;
			$pch_return_account			=	$datavdrtpe->pch_return_account;
			$pch_discount_account		=	$datavdrtpe->pch_discount_account;
			$vendor_deposit_account		=	$datavdrtpe->vendor_deposit_account;
			$currency_account			=	$datavdrtpe->currency_account;
			$cheque_payable_account		=	$datavdrtpe->cheque_payable_account;
			//-----------------end------------------
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			
			$sqlstr="delete from jrn where ivino='$ivino' and ivitpe='payment' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$j = 0;
			
			for ($i=0; $i<=$jmldata; $i++) {
				
				$delete 			= 	(empty($_POST[delete_.$i])) ? 0 : $_POST[delete_.$i];
				
				$old_line		 	= 	(empty($_POST[old_line_.$i])) ? 0 : $_POST[old_line_.$i];
				
				$amount 		= numberreplace($_POST[amount_paid_.$i]);
				$discount 		= numberreplace($_POST[discount_.$i]);
				$mmo 			= $_POST[memo_.$i];
							
				if($delete == 0) {
					if ( !empty($pch_account) && ($amount <> 0) ) {
					
						$j++;
						 		
						//------------purchase
						$keycode2	=	$ivino . $pch_account;
						if($amount  > 0) { //credit				
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'payment', '$dte', '$pch_account', '$mmo', '0', '$amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						if($amount < 0) { //debit
							$amount = $amount * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'payment', '$dte', '$pch_account', '$mmo', '$amount', '0', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";	
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();		
						}
					}
					
					
					if ( !empty($pch_discount_account) && ($discount <> 0) ) { 		
					
						$j++;
						
						//--discount (posistif)
						$keycode2	=	$ivino . $pch_discount_account;
						if($discount > 0) { //credit
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'payment', '$dte', '$pch_discount_account', '$mmo', '0', '$discount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						if($discount  < 0) { //debit
							$discount = $discount * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'payment', '$dte', '$pch_discount_account', '$mmo', '$discount', '0', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
										
					}
					
				} else {
					
					//------purchase
					$sqlstr="delete from jrn where ivino='$ivino' and ivitpe='payment' and acccde='$pch_account' and lne='$old_line'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
					
					//discount
					$sqlstr="delete from jrn where ivino='$ivino' and ivitpe='payment' and acccde='$pch_discount_account' and lne='$old_line'";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
									
				}
				
				
			}
			
			
			$account_code 			= $_POST["account_code"];
			$round_amount_account	= $_POST["round_amount_account"];
			$bank_charge_account	= $_POST["bank_charge_account"];
			$total			=	numberreplace($_POST["total"]);
			$round_amount	=	numberreplace($_POST["round_amount"]);
			$bank_charge	=	numberreplace($_POST["bank_charge"]);
			$memo			=	$_POST['memo'];
			
			
			/*-------HUTANG USAHA-------------------------*/
			/*$sqlcek = "select ivino from jrn where ivino='$ivino' and ivitpe='payment' and acccde='$account_code' and lne='0' ";
			$result = mysql_query($sqlcek);
			$num = mysql_num_rows($result);*/
			
			/*if($num > 0) {
				//----------------update journal
				$keycode		=	$ivino . $account_code;		
				if($total > 0) { 
					##debit
					$sqlstr="update jrn set ividte='$dte', acccde='$account_code', dcr='$memo', dbtamt='$total', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='payment' and acccde='$account_code' and lne='0' ");
				} 
				if($total < 0) { 
					##credit
					$total = $total * -1;
					$sqlstr="update jrn set ividte='$dte', acccde='$account_code', dcr='$memo', crdamt='$amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='payment' and acccde='$account_code' and lne='0' ");
					
				}
			} else { */
				
				//----------------insert journal hutang usaha
				$keycode		=	$ivino . $account_code;		
				if($total > 0 && $account_code <> "" ) { 
					$j++;
					##debit
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'payment', '$dte', '$account_code', '$memo', '$total','0', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($total < 0) { 
					$j++;
					##credit
					$total = $total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'payment', '$dte', '$account_code', '$memo', '0','$total', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}
				
				
			//}
			/*-------END HUTANG USAHA-------------------------*/
			
			
			
			/*-------ROUND AMOUNT-------------------------*/
			/*$sqlcek = "select ivino from jrn where ivino='$ivino' and ivitpe='payment' and acccde='$round_amount_account' and lne='0' ";
			$result = mysql_query($sqlcek);
			$num = mysql_num_rows($result);*/
			
			/*if($num > 0) {
				//----------------update journal
				$keycode		=	$ivino . $round_amount_account;		
				if($total > 0) { 
					##debit
					$sqlstr="update jrn set ividte='$dte', acccde='$round_amount_account', dcr='$memo', dbtamt='$round_amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='payment' and acccde='$round_amount_account' and lne='1' ");
				} 
				if($total < 0) { 
					##credit
					$keycode		=	$ivino . $round_amount_account;	
					$total = $total * -1;
					$sqlstr="update jrn set ividte='$dte', acccde='$round_amount_account', dcr='$memo', crdamt='$round_amount', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='payment' and acccde='$round_amount_account' and lne='1' ");
					
				}
			} else { */
				
				//----------------insert journal round amound
				$keycode		=	$ivino . $round_amount_account;		
				if($round_amount > 0 && $round_amount_account <> "" ) { 
					$j++;
					##debit
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'payment', '$dte', '$round_amount_account', '$memo', '0','$round_amount', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($round_amount < 0) { 
					$j++;
					##credit
					$round_amount = $round_amount * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'payment', '$dte', '$round_amount_account', '$memo', '$round_amount','0', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}
				
			//}
			/*-------END HUTANG USAHA-------------------------*/
			
			
			/*-------BANK CHARGE-------------------------*/
			/*$sqlcek = "select ivino from jrn where ivino='$ivino' and ivitpe='payment' and acccde='$bank_charge_account' and lne='0' ";
			$result = mysql_query($sqlcek);
			$num = mysql_num_rows($result);*/
			
			/*if($num > 0) {
				//----------------update journal
				$keycode		=	$ivino . $bank_charge_account;		
				if($bank_charge > 0) { 
					##debit
					$sqlstr="update jrn set ividte='$dte', acccde='$bank_charge_account', dcr='$memo', dbtamt='$bank_charge', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='payment' and acccde='$bank_charge_account' and lne='2' ");
				} 
				if($bank_charge < 0) { 
					##credit
					$keycode		=	$ivino . $bank_charge_account;	
					$bank_charge = $bank_charge * -1;
					$sqlstr="update jrn set ividte='$dte', acccde='$bank_charge_account', dcr='$memo', crdamt='$bank_charge', keycde='$keycode', uid='$uid', dlu='$dlu', sysdte='$dlu' where ivino='$ivino' and ivitpe='payment' and acccde='$bank_charge_account' and lne='2' ");
					
				}
			} else { */
				
				//----------------insert journal bank charge
				$keycode		=	$ivino . $bank_charge_account;		
				if($bank_charge > 0 && $bank_charge_account <> "" ) { 
					$j++;
					##debit
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'payment', '$dte', '$bank_charge_account', '$memo', '0','$bank_charge', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				} 
				if($bank_charge < 0) { 
					$j++;
					##credit
					$bank_charge = $bank_charge * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'payment', '$dte', '$bank_charge_account', '$memo', '$bank_charge','0', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();
				}
				
			//}
			/*-------END HUTANG USAHA-------------------------*/
		
		
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	
	//-----journal receipt
	function journal_receipt($ref){
		$dbpdo = DB::create();
		
		try {
		
			$ivino			=	$ref;
			$client_code	=	$_POST["client_code"];
			$dte			=	date('Y-m-d', strtotime($_POST["date"]));
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//------get account code from client type
			$clnquery	=	"select client_type from client where syscode='$client_code'";
			$sql=$dbpdo->prepare($clnquery);
			$sql->execute();
			$dataclntpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$location_id	= $_SESSION["location_id2"];
			$sqlclntpe		=	"select a.sls_account, a.sls_cash_account, a.sls_return_account, a.sls_discount_account, a.client_deposit_account, a.currency_account, a.cheque_receivable_account, a.sls_account2 from client_type_detail a where a.id_header='$dataclntpe->client_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlclntpe);
			$sql->execute();
			$dataclntpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$sls_account				=	$dataclntpe->sls_account;
			$sls_cash_account			=	$dataclntpe->sls_cash_account;
			$sls_return_account			=	$dataclntpe->sls_return_account;
			$sls_discount_account		=	$dataclntpe->sls_discount_account;
			$client_deposit_account		=	$dataclntpe->client_deposit_account;
			$currency_account			=	$dataclntpe->currency_account;
			$cheque_receivable_account	=	$dataclntpe->cheque_receivable_account;
			//-----------------end------------------
			
			//-----------delete journal
			$sqlstr = "delete from jrn where ivino='$ivino' and ivitpe='receipt' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$j = 0;
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			for ($i=0; $i<=$jmldata; $i++) {
				
				$amount 		= numberreplace($_POST[amount_paid_.$i]);
				$discount 		= numberreplace($_POST[discount_.$i]);
				$mmo 			= $_POST[invoice_no_.$i];
				
				if ( !empty($sls_account) && ($amount <> 0) ) {
					
					$j++;
					 		
					//------------sales
					$mmo = 'Penjualan : ' . $mmo;
					$keycode2	=	$ivino . $sls_account;
					if($amount  > 0) { //credit					
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$sls_account', '$mmo', '0', '$amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					if($amount < 0) { //debit
						$amount = $amount * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$sls_account', '$mmo', '$amount', '0', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
				}
				
				
				if ( !empty($sls_discount_account) && ($discount <> 0) ) { 		
					
					$j++;
					
					//--discount (posistif)
					$mmo = 'Potongan Penjualan : ' . $mmo;
					$keycode2	=	$ivino . $sls_discount_account;
					if($discount > 0) { //credit
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$sls_discount_account', '$mmo', '$discount', '0', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					if($discount  < 0) { //debit
						$discount = $discount * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$sls_discount_account', '$mmo', '0', '$discount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
									
				}
				
				
			}
			
			
			$account_code 			= $_POST["account_code"];
			$round_amount_account	= $_POST["round_amount_account"];
			$bank_charge_account	= $_POST["bank_charge_account"];
			
			$deposit		=	numberreplace($_POST["deposit"]);	
			$total			=	numberreplace($_POST["total"]);
			$round_amount	=	numberreplace($_POST["round_amount"]);
			$bank_charge	=	numberreplace($_POST["bank_charge"]);
			$memo			=	$_POST['memo'];
			
			//----------------insert journal piutang usaha
			$keycode		=	$ivino . $account_code;		
			if($total > 0 && $account_code <> "" ) { 
				##debit
				$j++;
				$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$account_code', '$memo', '$total', '0', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			} 
			
			if($total < 0 && $account_code <> "" ) {
				##credit
				$j++;
				$total = $total * -1;
				
				$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$account_code', '$memo', '0', '$total', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			
			//----------------insert journal round amound
			$keycode		=	$ivino . $round_amount_account;		
			if($round_amount > 0 && $round_amount_account <> "" ) { 
				##debit
				$j++;
				$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$round_amount_account', '$memo', '$round_amount', '0', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			} 
			if($round_amount < 0 && $round_amount_account <> "" ) { 
				##credit
				$j++;
				$round_amount = $round_amount * -1;
				$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$round_amount_account', '$memo', '0', '$round_amount', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			
			//----------------insert journal bank charge
			$keycode		=	$ivino . $bank_charge_account;		
			if($bank_charge > 0 && $bank_charge_account <> "" ) { 
				##debit
				$j++;
				$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$bank_charge_account', '$memo', '$bank_charge', '0', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			} 
			if($bank_charge < 0 && $bank_charge_account <> "" ) { 
				##credit
				$j++;
				$bank_charge = $bank_charge * -1;
				$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$bank_charge_account', '$memo', '0', '$bank_charge', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
			
			
			//----------------insert journal uang muka
			$keycode		=	$ivino . $account_code;		
			if($deposit < 0 && $account_code <> "" ) { 
				##debit
				$j++;
				$deposit_debit = $deposit * -1;
				$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$account_code', '$memo', '$deposit_debit', '0', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			} 
			
			$keycode		=	$ivino . $client_deposit_account;
			if($deposit < 0 && $client_deposit_account <> "" ) { 
				##credit
				$j++;
				$deposit_credit = $deposit * -1;
				$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ivino', 'receipt', '$dte', '$client_deposit_account', '$memo', '0', '$deposit_credit', 'idr', '0', '$keycode', '$j', '$uid', '$dlu', '$dlu' )";
				$sql=$dbpdo->prepare($sqlstr);
				$sql->execute();
			}
		
		}
		
		catch(PDOException $e){
			echo $e->getMessage();
		}
		
		return $sql;
	}
	
	
	
	//-----journal purchase return
	function journal_purchase_return($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$pi_ref				=	$_POST["pi_ref"];
			$vendor_code		=	$_POST["vendor_code"];			
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$total				=	$sub_total; 
			
	        $uid			    =	$_SESSION["loginname"];
			$dlu			    =	date("Y-m-d H:i:s");
			
			//-------get vendor type
			$sqlvendor		=	"select a.vendor_type from vendor a where a.syscode='$vendor_code' ";
			$sql=$dbpdo->prepare($sqlvendor);
			$sql->execute();
			$datavendor		=	$sql->fetch(PDO::FETCH_OBJ);
			//--------------------/\
			
			//------get account code from vendor type
			$location_id	= $_SESSION["location_id2"];
			$sqlvdrtpe		=	"select a.pch_account, a.pch_cash_account, a.pch_return_account, a.pch_discount_account, a.vendor_deposit_account, a.currency_account, a.cheque_payable_account from vendor_type_detail a where a.id_header='$datavendor->vendor_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlvdrtpe);
			$sql->execute();
			$datavdrtpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$pch_account				=	$datavdrtpe->pch_account;
			$pch_cash_account			=	$datavdrtpe->pch_cash_account;
			$pch_return_account			=	$datavdrtpe->pch_return_account;
			$pch_discount_account		=	$datavdrtpe->pch_discount_account;
			$vendor_deposit_account		=	$datavdrtpe->vendor_deposit_account;
			$currency_account			=	$datavdrtpe->currency_account;
			$cheque_payable_account		=	$datavdrtpe->cheque_payable_account;
			//-------------------------------------/\
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_return' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				$qty = numberreplace($_POST[qty_.$i]);
				$unit_cost = numberreplace($_POST[unit_cost_.$i]);
				$amount = $qty * $unit_cost;
				
				$sub_total = $sub_total + $amount;
				
				//---------get item group
				$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code'"; // and a.uom_code_sales='$uom_code'";
				$sql=$dbpdo->prepare($sqlitm);
				$sql->execute();
				$dataitm		=	$sql->fetch(PDO::FETCH_OBJ);
				//------------------/\
				
				//-------get account from item type
				$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmtype);
				$sql->execute();
				$dataitmtype		=	$sql->fetch(PDO::FETCH_OBJ);
				
				$inventory_acccode			=	$dataitmtype->inventory_acccode;
				$productcost_acccode		=	$dataitmtype->productcost_acccode;
				$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
				$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
				$cogs_acccode				=	$dataitmtype->cogs_acccode;
				//---------------------------------/\
				
				//------get account code from item group
				$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmgrp);
				$sql->execute();
				$dataitmgrp		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($inventory_acccode == "") { $inventory_acccode			=	$dataitmgrp->inventory_acccode; }
				if($cogs_acccode == "") { $cogs_acccode				=	$dataitmgrp->cogs_acccode; }
				if($goodintransit_acccode == "") { $goodintransit_acccode		=	$dataitmgrp->goodintransit_acccode; }
				$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
				if($workinprocess_acccode == "") { $workinprocess_acccode		=	$dataitmgrp->workinprocess_acccode; }
				$consignment_acccode		=	$dataitmgrp->consignment_acccode;
				//---------------------------------------/\
				
				
				//---------inventory journal
				if ( !empty($inventory_acccode) && ($amount <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $inventory_acccode;
					if($amount > 0) { //credit
						$debit_amount = $amount;
						
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$inventory_acccode', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";	
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();		
					}
					
					if($amount < 0) { //debit
						$debit_amount = $amount * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$inventory_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
					
				
			}
			
			
			//---------sub total pembelian		
			$total	=	$sub_total; // + $freight_cost;
			
			//----------pajak (ppn)		
			$tax_code	=	$_POST["tax_code"];
			
			$sqltax 	=	"select a.tax_account from tax a where a.syscode='$tax_code' ";
			$sql=$dbpdo->prepare($sqltax);
			$sql->execute();
			$datatax		=	$sql->fetch(PDO::FETCH_OBJ);
			$tax_account=	$datatax->tax_account;
			
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			if ( !empty($tax_account) && ($tax_total <> 0) ) { 		
				
				$memo_tax = 'Pajak Purchase Return : ' . $ref; 
					
				$j++;
				
				$keycode2	=	$ref . $tax_account;
				if($tax_total > 0) { //credit
					$debit_amount = $tax_total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$tax_account', '$memo_tax', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($tax_total < 0) { //debit
					$debit_amount = $tax_total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$tax_account', '$memo_tax', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			
			//---pembelian
			$total = $total + $tax_total;
			if ( !empty($pch_account) && ($total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $pch_account;
				if($total > 0) { //debit
					$debit_amount = $total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$pch_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($total < 0) { //credit
					$debit_amount = $total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$pch_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
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
	
	
	//-----journal sales return 
	function journal_sales_return($ref){
		$dbpdo = DB::create();
		
		try {
			
			$ref2			= 	$_POST["ref2"];
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];
			if($taxable == 0) {
				$ref2		= 	"";
			}
			
			$client_code		=	$_POST["client_code"];			
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			
			$status			= 	$_POST["status"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id	=	$_SESSION["location_id2"]; //(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$memo			=	petikreplace($_POST["memo"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//-------get client type
			$sqlclient		=	"select a.client_type from client a where a.syscode='$client_code' ";
			$sql=$dbpdo->prepare($sqlclient);
			$sql->execute();
			$dataclient		=	$sql->fetch(PDO::FETCH_OBJ);
			//--------------------/\
			
			//------get account code from client type
			$sqlclntpe		=	"select a.sls_account, a.sls_cash_account, a.sls_return_account, a.sls_discount_account, a.client_deposit_account, a.currency_account, a.cheque_receivable_account, a.sls_account2 from client_type_detail a where a.id_header='$dataclient->client_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlclntpe);
			$sql->execute();
			$dataclntpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$sls_account				=	$dataclntpe->sls_account;
			$sls_account2				=	$dataclntpe->sls_account2;
			$sls_cash_account			=	$dataclntpe->sls_cash_account;
			$sls_return_account			=	$dataclntpe->sls_return_account;
			$sls_discount_account		=	$dataclntpe->sls_discount_account;
			$client_deposit_account		=	$dataclntpe->client_deposit_account;
			$cheque_receivable_account	=	$dataclntpe->cheque_receivable_account;
			
			if($cash == 1) {
				$sls_account = $sls_cash_account;
			}
			//-------------------------------------/\
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales_return' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			$total_charge = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$old_qty	= numberreplace($_POST[old_qty_.$i]);
				$qty 		= numberreplace($_POST[qty_.$i]);			
				$unit_price	= numberreplace($_POST[unit_price_.$i]);
				$charge_p	= numberreplace($_POST[charge_p_.$i]);
				$amount 	= numberreplace($_POST[amount_.$i]);
				
				$amount_charge	= ($charge_p * ($unit_price * $qty))/100;
				$total_charge	= $total_charge + $amount_charge;
				
				$sub_total		= $sub_total + $amount - $amount_charge;
				
				
				
				//----------get avarege cost
				$sqlpi 			= 	"select sum(ifnull(a.unit_cost,0)) unit_cost, sum(ifnull(a.qty,0)) qty from purchase_invoice_detail a where a.item_code='$item_code' and a.uom_code='$uom_code' group by a.item_code, a.uom_code";
				$sql=$dbpdo->prepare($sqlpi);
				$sql->execute();
				$datapi		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($datapi->qty == 0) {
					$average_cost 	= 	$datapi->unit_cost;
				} else {
					$average_cost 	= 	$datapi->unit_cost / $datapi->qty;
				}			
				//------------------------/\
				
				//---------get item group
				$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code' and a.uom_code_sales='$uom_code'";
				$sql=$dbpdo->prepare($sqlitm);
				$sql->execute();
				$dataitm		=	$sql->fetch(PDO::FETCH_OBJ);
				//------------------/\
				
				//-------get account from item type
				$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmtype);
				$sql->execute();
				$dataitmtype		=	$sql->fetch(PDO::FETCH_OBJ);
				
				$inventory_acccode			=	$dataitmtype->inventory_acccode;
				$productcost_acccode		=	$dataitmtype->productcost_acccode;
				$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
				$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
				$cogs_acccode				=	$dataitmtype->cogs_acccode;
				//---------------------------------/\
				
				//------get account code from item group
				$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmgrp);
				$sql->execute();
				$dataitmgrp		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($inventory_acccode == "") { $inventory_acccode =	$dataitmgrp->inventory_acccode; }
				if($cogs_acccode == "") { $cogs_acccode	=	$dataitmgrp->cogs_acccode; }
				if($goodintransit_acccode == "") { $goodintransit_acccode =	$dataitmgrp->goodintransit_acccode; }
				$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
				if($workinprocess_acccode == "") { $workinprocess_acccode =	$dataitmgrp->workinprocess_acccode; }
				$consignment_acccode		=	$dataitmgrp->consignment_acccode;
				//---------------------------------------/\
					
				if ( !empty($sls_return_account) && ($amount <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $sls_return_account;
					if($amount > 0) { //debit
						$debit_amount = ($unit_price * $qty) - $amount_charge;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales_return', '$date', '$sls_return_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($amount < 0) { //credit
						$debit_amount = ( ($unit_price * $qty) - $amount_charge ) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales_return', '$date', '$sls_return_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
				
					
							
				if ( !empty($productcost_acccode) && ($average_cost <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $productcost_acccode;
					if($average_cost > 0) { //debit
						$debit_amount = $average_cost * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales_return', '$date', '$productcost_acccode', '$memo', '$debit_amount', '0', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($average_cost < 0) { //credit
						$debit_amount = ($average_cost * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales_return', '$date', '$productcost_acccode', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				} 
				
					
				
			}
			
			
			//--------charge total
			if ( !empty($sls_discount_account) && ($total_charge <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $sls_discount_account;
				if($total_charge > 0) { //debit
					$debit_amount = $total_charge;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales_return', '$date', '$sls_discount_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";	
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();		
				}
				
				if($total_charge < 0) { //credit
					$debit_amount = ($total_charge) * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales_return', '$date', '$sls_discount_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}		
			
			//---------return penjualan
			//$total		=   $sub_total;
			$total	=	numberreplace($_POST["total"]);
			
			//----------pajak (ppn)
			$tax_code	=	$_POST["tax_code"];
			
			$sqltax 	=	"select a.tax_account from tax a where a.syscode='$tax_code' ";
			$sql=$dbpdo->prepare($sqltax);
			$sql->execute();
			$datatax		=	$sql->fetch(PDO::FETCH_OBJ);
			$tax_account=	$datatax->tax_account;
			
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			if ( !empty($tax_account) && ($tax_total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $tax_account;
				if($tax_total > 0) { //debit
					$debit_amount = $tax_total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales_return', '$date', '$tax_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($tax_total < 0) { //credit
					$debit_amount = $tax_total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales_return', '$date', '$tax_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			
			$sls_account = $sls_account2;
		
			$total	= 	numberreplace($_POST["total"]);
			$total	=	$total + $tax_total + $total_charge;
			if ( !empty($sls_account) && ($total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $sls_account;
				if($total > 0) { //credit
					$debit_amount = $total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales_return', '$date', '$sls_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($total < 0) { //debit
					$debit_amount = $total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales_return', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
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
	
	
    
    //-----journal cashier
	function journal_cashier($ref){
		$dbpdo = DB::create();
		
		try {
			
			$ref2			= 	$_POST["ref2"];
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];
			if($taxable == 0) {
				$ref2		= 	"";
			}
			
			$status			= 	$_POST["status"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$cash			=	1; 
			$phone			=	$_POST["phone"];
			$ship_to		=	$_POST["ship_to"];
			$bill_to		=	$_POST["bill_to"];
			$memo			=	petikreplace($_POST["memo"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//---------get client code
			$sqlinv			=	"select a.client_code from sales_invoice a where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlinv);
			$sql->execute();
			$datainv		=	$sql->fetch(PDO::FETCH_OBJ);
			$client_code	=	$datainv->client_code;
			
			//-------get client type
			$sqlclient		=	"select a.client_type from client a where a.syscode='$client_code' ";		
			$sql=$dbpdo->prepare($sqlclient);
			$sql->execute();
			$dataclient		=	$sql->fetch(PDO::FETCH_OBJ);
			//--------------------/\
			
			//------get account code from client type
			$sqlclntpe		=	"select a.sls_account, a.sls_cash_account, a.sls_return_account, a.sls_discount_account, a.client_deposit_account, a.currency_account, a.cheque_receivable_account, a.sls_account2 from client_type_detail a where a.id_header='$dataclient->client_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlclntpe);
			$sql->execute();
			$dataclntpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$sls_account				=	$dataclntpe->sls_account;
			$sls_account2				=	$dataclntpe->sls_account2;
			$sls_cash_account			=	$dataclntpe->sls_cash_account;
			$sls_return_account			=	$dataclntpe->sls_return_account;
			$sls_discount_account		=	$dataclntpe->sls_discount_account;
			$client_deposit_account		=	$dataclntpe->client_deposit_account;
			$cheque_receivable_account	=	$dataclntpe->cheque_receivable_account;
			
			//if($cash == 1) {
				//$sls_account = $sls_cash_account;
			//}
			//-------------------------------------/\
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				$qty 			= numberreplace($_POST[qty_.$i]);
				$unit_price 	= numberreplace($_POST[unit_price_.$i]);
				$amount 		= numberreplace($_POST[amount_.$i]);
				$discount 		= numberreplace($_POST[discount_.$i]);
				
				$sub_total		= $sub_total + $amount;
				
				//----------get avarege cost
				$sqlpi 			= 	"select sum(ifnull(a.unit_cost,0)) unit_cost, sum(ifnull(a.qty,0)) qty from purchase_invoice_detail a where a.item_code='$item_code' and a.uom_code='$uom_code' group by a.item_code, a.uom_code";
				$sql=$dbpdo->prepare($sqlpi);
				$sql->execute();
				$datapi		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($datapi->qty == 0) {
					$average_cost 	= 	$datapi->unit_cost;
				} else {
					$average_cost 	= 	$datapi->unit_cost / $datapi->qty;
				}			
				//------------------------/\
				
				//---------get item group
				$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code' and a.uom_code_sales='$uom_code'";
				$sql=$dbpdo->prepare($sqlitm);
				$sql->execute();
				$dataitm		=	$sql->fetch(PDO::FETCH_OBJ);
				//------------------/\
				
				//-------get account from item type
				$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmtype);
				$sql->execute();
				$dataitmtype		=	$sql->fetch(PDO::FETCH_OBJ);
				
				$inventory_acccode			=	$dataitmtype->inventory_acccode;
				$productcost_acccode		=	$dataitmtype->productcost_acccode;
				$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
				$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
				$cogs_acccode				=	$dataitmtype->cogs_acccode;
				//---------------------------------/\
				
				//------get account code from item group
				$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmgrp);
				$sql->execute();
				$dataitmgrp		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($inventory_acccode == "") { $inventory_acccode =	$dataitmgrp->inventory_acccode; }
				if($cogs_acccode == "") { $cogs_acccode	=	$dataitmgrp->cogs_acccode; }
				if($goodintransit_acccode == "") { $goodintransit_acccode =	$dataitmgrp->goodintransit_acccode; }
				$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
				if($workinprocess_acccode == "") { $workinprocess_acccode =	$dataitmgrp->workinprocess_acccode; }
				$consignment_acccode		=	$dataitmgrp->consignment_acccode;
				//---------------------------------------/\
				
				if($cash == 1) {	
					if ( !empty($sls_account) && ($amount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ref . $sls_account;
						if($amount > 0) { //debit
							$debit_amount = $amount; //$unit_price * $qty;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
						if($amount < 0) { //credit
							$debit_amount = ($amount) * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
					}
				} else {
					
					if ( !empty($sls_account2) && ($amount <> 0) ) { 		
					
						$j++;
						
						$keycode2	=	$ref . $sls_account2;
						if($amount > 0) { //credit
							$debit_amount = $amount; //$unit_price * $qty;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account2', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
						if($amount < 0) { //debit
							$debit_amount = ($amount) * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account2', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
					}
				
				}
			
				$average_cost	=	$unit_price; //temporary			
				if ( !empty($productcost_acccode) && ($average_cost <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $productcost_acccode;
					if($average_cost > 0) { //debit
						$debit_amount = $average_cost * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$productcost_acccode', '$memo', '$debit_amount', '0', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($average_cost < 0) { //credit
						$debit_amount = ($average_cost * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$productcost_acccode', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				} 
				
				
				if ( !empty($goodintransit_acccode) && ($average_cost <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $goodintransit_acccode;
					if($average_cost > 0) { //credit
						$debit_amount = $average_cost * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$goodintransit_acccode', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($average_cost < 0) { //debit
						$debit_amount = ($average_cost * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$goodintransit_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				} 
				
				//----
				if ( !empty($sls_discount_account) && ($discount <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $sls_discount_account;
					if($discount > 0) { //debit
						$debit_amount = $discount * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($discount < 0) { //credit
						$debit_amount = ($discount * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}			
				
			}
			
			
			//---------penjualan
			//$total		=   $sub_total;
			$total	=	numberreplace($_POST["total"]);
			$deposit	=	numberreplace($_POST["deposit"]);
			if($deposit <> 0) {
				$total = $total - $deposit;
			}		
			
			
			if($cash == 1) {					
				if ( !empty($sls_cash_account) && ($total <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $sls_cash_account;
					if($total > 0) { //debit
						$debit_amount = $total;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_cash_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($total < 0) { //credit
						$debit_amount = $total * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_cash_account', '$memo',  0, '$debit_amount','idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
			} else {
				
				if ( !empty($sls_account2) && ($total <> 0) ) { 		
				
					$j++;
					
					$keycode2	=	$ref . $sls_account2;
					if($total > 0) { //credit
						$debit_amount = $total;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account2', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($total < 0) { //debit
						$debit_amount = $total * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account2', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
			
			}
				
				
			if($cash == 1) {
				$sls_account = $sls_account2;
			
				$total		=   $sub_total; //numberreplace($_POST["total"]);
				if ( !empty($sls_account) && ($total <> 0) ) { 		
						
					$j++;
					
					$keycode2	=	$ref . $sls_account;
					if($total > 0) { //credit
						$debit_amount = $total;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
					}
					
					if($total < 0) { //credit
						$debit_amount = $total * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
			} else {
				
				if ( !empty($sls_account) && ($total <> 0) ) { 		
						
					$j++;
					
					$keycode2	=	$ref . $sls_account;
					if($total > 0) { //debit
						$debit_amount = $total;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($total < 0) { //credit
						$debit_amount = $total * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
				
			}
			
			
			//--discount total
			$discount = numberreplace($_POST['discount']);
			if ( !empty($sls_discount_account) && ($discount <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $sls_discount_account;
				if($discount > 0) { //debit
					$debit_amount = $discount;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();		
				}
				
				if($discount < 0) { //credit
					$debit_amount = ($discount) * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}	
			
			
			//----------Uang Muka		
			if ( !empty($client_deposit_account) && ($deposit <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $client_deposit_account;
				if($deposit > 0) { //debit
					$debit_amount = $deposit;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$client_deposit_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($deposit < 0) { //credit
					$debit_amount = $deposit * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$client_deposit_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			//----------ongkos kirim
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			if ( !empty($freight_account) && ($freight_cost <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $freight_account;
				if($freight_cost > 0) { //credit
					$debit_amount = $freight_cost;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$freight_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($freight_cost < 0) { //debit
					$debit_amount = $freight_cost * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$freight_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			
			//----------pajak (ppn)
			$tax_code	=	$_POST["tax_code"];
			
			$sqltax 	=	"select a.tax_account from tax a where a.syscode='$tax_code' ";
			$sql=$dbpdo->prepare($sqltax);
			$sql->execute();
			$datatax		=	$sql->fetch(PDO::FETCH_OBJ);
			$tax_account=	$datatax->tax_account;
			
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			if ( !empty($tax_account) && ($tax_total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $tax_account;
				if($tax_total > 0) { //credit
					$debit_amount = $tax_total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$tax_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($tax_total < 0) { //debit
					$debit_amount = $tax_total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$tax_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
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
    
    
    //-----journal pos
	function journal_pos($ref){
		$dbpdo = DB::create();
		
		try {
			
			$ref2			= 	$_POST["ref2"];
			$taxable		=	(empty($_POST["taxable"])) ? 0 : $_POST["taxable"];
			if($taxable == 0) {
				$ref2		= 	"";
			}
			
			$status			= 	$_POST["status"];
			$date			=	date("Y-m-d", strtotime($_POST["date"]));
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$cash			=	1; 
			$phone			=	$_POST["phone"];
			$ship_to		=	$_POST["ship_to"];
			$bill_to		=	$_POST["bill_to"];
			$memo			=	petikreplace($_POST["memo"]);
			$uid			=	$_SESSION["loginname"];
			$dlu			=	date("Y-m-d H:i:s");
			
			//---------get client code
			$sqlinv			=	"select a.client_code from sales_invoice a where ref='$ref' ";
			$sql=$dbpdo->prepare($sqlinv);
			$sql->execute();
			$datainv		=	$sql->fetch(PDO::FETCH_OBJ);
			$client_code	=	$datainv->client_code;
			
			//-------get client type
			$sqlclient		=	"select a.client_type from client a where a.syscode='$client_code' ";		
			$sql=$dbpdo->prepare($sqlclient);
			$sql->execute();
			$dataclient		=	$sql->fetch(PDO::FETCH_OBJ);
			//--------------------/\
			
			//------get account code from client type
			$sqlclntpe		=	"select a.sls_account, a.sls_cash_account, a.sls_return_account, a.sls_discount_account, a.client_deposit_account, a.currency_account, a.cheque_receivable_account, a.sls_account2 from client_type_detail a where a.id_header='$dataclient->client_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlclntpe);
			$sql->execute();
			$dataclntpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$sls_account				=	$dataclntpe->sls_account;
			$sls_account2				=	$dataclntpe->sls_account2;
			$sls_cash_account			=	$dataclntpe->sls_cash_account;
			$sls_return_account			=	$dataclntpe->sls_return_account;
			$sls_discount_account		=	$dataclntpe->sls_discount_account;
			$client_deposit_account		=	$dataclntpe->client_deposit_account;
			$cheque_receivable_account	=	$dataclntpe->cheque_receivable_account;
			
			//if($cash == 1) {
				//$sls_account = $sls_cash_account;
			//}
			//-------------------------------------/\
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='sales' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				$qty 			= numberreplace($_POST[qty_.$i]);
				$unit_price 	= numberreplace($_POST[unit_price_.$i]);
				$amount 		= numberreplace($_POST[amount_.$i]);
				$discount 		= numberreplace($_POST[discount_.$i]);
				
				$sub_total		= $sub_total + $amount;
				
				//----------get avarege cost
				$sqlpi 			= 	"select sum(ifnull(a.unit_cost,0)) unit_cost, sum(ifnull(a.qty,0)) qty from purchase_invoice_detail a where a.item_code='$item_code' and a.uom_code='$uom_code' group by a.item_code, a.uom_code";
				$sql=$dbpdo->prepare($sqlpi);
				$sql->execute();
				$datapi		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($datapi->qty == 0) {
					$average_cost 	= 	$datapi->unit_cost;
				} else {
					$average_cost 	= 	$datapi->unit_cost / $datapi->qty;
				}			
				//------------------------/\
				
				//---------get item group
				$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code' and a.uom_code_sales='$uom_code'";
				$sql=$dbpdo->prepare($sqlitm);
				$sql->execute();
				$dataitm		=	$sql->fetch(PDO::FETCH_OBJ);
				//------------------/\
				
				//-------get account from item type
				$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmtype);
				$sql->execute();
				$dataitmtype		=	$sql->fetch(PDO::FETCH_OBJ);
				
				$inventory_acccode			=	$dataitmtype->inventory_acccode;
				$productcost_acccode		=	$dataitmtype->productcost_acccode;
				$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
				$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
				$cogs_acccode				=	$dataitmtype->cogs_acccode;
				//---------------------------------/\
				
				//------get account code from item group
				$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmgrp);
				$sql->execute();
				$dataitmgrp		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($inventory_acccode == "") { $inventory_acccode =	$dataitmgrp->inventory_acccode; }
				if($cogs_acccode == "") { $cogs_acccode	=	$dataitmgrp->cogs_acccode; }
				if($goodintransit_acccode == "") { $goodintransit_acccode =	$dataitmgrp->goodintransit_acccode; }
				$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
				if($workinprocess_acccode == "") { $workinprocess_acccode =	$dataitmgrp->workinprocess_acccode; }
				$consignment_acccode		=	$dataitmgrp->consignment_acccode;
				//---------------------------------------/\
				
				if($cash == 1) {	
					if ( !empty($sls_account) && ($amount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ref . $sls_account;
						if($amount > 0) { //debit
							$debit_amount = $amount; //$unit_price * $qty;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
						if($amount < 0) { //credit
							$debit_amount = ($amount) * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
					}
				} else {
					
					if ( !empty($sls_account2) && ($amount <> 0) ) { 		
					
						$j++;
						
						$keycode2	=	$ref . $sls_account2;
						if($amount > 0) { //credit
							$debit_amount = $amount; //$unit_price * $qty;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account2', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
						if($amount < 0) { //debit
							$debit_amount = ($amount) * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account2', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
					}
				
				}
			
				$average_cost	=	$unit_price; //temporary			
				if ( !empty($productcost_acccode) && ($average_cost <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $productcost_acccode;
					if($average_cost > 0) { //debit
						$debit_amount = $average_cost * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$productcost_acccode', '$memo', '$debit_amount', '0', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($average_cost < 0) { //credit
						$debit_amount = ($average_cost * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$productcost_acccode', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				} 
				
				
				if ( !empty($goodintransit_acccode) && ($average_cost <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $goodintransit_acccode;
					if($average_cost > 0) { //credit
						$debit_amount = $average_cost * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$goodintransit_acccode', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($average_cost < 0) { //debit
						$debit_amount = ($average_cost * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, qty, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$goodintransit_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$qty', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				} 
				
				//----
				if ( !empty($sls_discount_account) && ($discount <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $sls_discount_account;
					if($discount > 0) { //debit
						$debit_amount = $discount * $qty;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($discount < 0) { //credit
						$debit_amount = ($discount * $qty) * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}			
				
			}
			
			
			//---------penjualan
			//$total		=   $sub_total;
			$total	=	numberreplace($_POST["total"]);
			$deposit	=	numberreplace($_POST["deposit"]);
			if($deposit <> 0) {
				$total = $total - $deposit;
			}		
			
			
			if($cash == 1) {					
				if ( !empty($sls_cash_account) && ($total <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $sls_cash_account;
					if($total > 0) { //debit
						$debit_amount = $total;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_cash_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($total < 0) { //credit
						$debit_amount = $total * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_cash_account', '$memo',  0, '$debit_amount','idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
			} else {
				
				if ( !empty($sls_account2) && ($total <> 0) ) { 		
				
					$j++;
					
					$keycode2	=	$ref . $sls_account2;
					if($total > 0) { //credit
						$debit_amount = $total;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account2', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($total < 0) { //debit
						$debit_amount = $total * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account2', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
			
			}
				
				
			if($cash == 1) {
				$sls_account = $sls_account2;
			
				$total		=   $sub_total; //numberreplace($_POST["total"]);
				if ( !empty($sls_account) && ($total <> 0) ) { 		
						
					$j++;
					
					$keycode2	=	$ref . $sls_account;
					if($total > 0) { //credit
						$debit_amount = $total;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();
					}
					
					if($total < 0) { //credit
						$debit_amount = $total * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
			} else {
				
				if ( !empty($sls_account) && ($total <> 0) ) { 		
						
					$j++;
					
					$keycode2	=	$ref . $sls_account;
					if($total > 0) { //debit
						$debit_amount = $total;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
					if($total < 0) { //credit
						$debit_amount = $total * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
				
			}
			
			
			//--discount total
			$discount = numberreplace($_POST['discount']);
			if ( !empty($sls_discount_account) && ($discount <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $sls_discount_account;
				if($discount > 0) { //debit
					$debit_amount = $discount;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();		
				}
				
				if($discount < 0) { //credit
					$debit_amount = ($discount) * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$sls_discount_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}	
			
			
			//----------Uang Muka		
			if ( !empty($client_deposit_account) && ($deposit <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $client_deposit_account;
				if($deposit > 0) { //debit
					$debit_amount = $deposit;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$client_deposit_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($deposit < 0) { //credit
					$debit_amount = $deposit * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$client_deposit_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			//----------ongkos kirim
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	$_POST["freight_account"];
			if ( !empty($freight_account) && ($freight_cost <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $freight_account;
				if($freight_cost > 0) { //credit
					$debit_amount = $freight_cost;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$freight_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($freight_cost < 0) { //debit
					$debit_amount = $freight_cost * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$freight_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			
			//----------pajak (ppn)
			$tax_code	=	$_POST["tax_code"];
			
			$sqltax 	=	"select a.tax_account from tax a where a.syscode='$tax_code' ";
			$sql=$dbpdo->prepare($sqltax);
			$sql->execute();
			$datatax		=	$sql->fetch(PDO::FETCH_OBJ);
			$tax_account=	$datatax->tax_account;
			
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			if ( !empty($tax_account) && ($tax_total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $tax_account;
				if($tax_total > 0) { //credit
					$debit_amount = $tax_total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$tax_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($tax_total < 0) { //debit
					$debit_amount = $tax_total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'sales', '$date', '$tax_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
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
	
    
	
	//-----journal purchase inv
	function journal_purchase_inv($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$bill_number		= 	$_POST["bill_number"];
			$vendor_code		= 	$_POST["vendor_code"];
			$top				= 	$_POST["top"];
			
			$freight_cost 		= 	numberreplace($_POST["freight_cost"]);
			$freight_account	= 	petikreplace($_POST["freight_account"]);
			$total				=	$sub_total;
			$memo				= 	petikreplace($_POST["memo"]);		
			$cash				= 	(empty($_POST["cash"])) ? 0 : $_POST["cash"];
			$uid				=	$_SESSION["loginname"];
			$dlu				=	date("Y-m-d H:i:s");
			
			//-------get vendor type
			$sqlvendor		=	"select a.vendor_type from vendor a where a.syscode='$vendor_code' ";
			$sql=$dbpdo->prepare($sqlvendor);
			$sql->execute();
			$datavendor	=	$sql->fetch(PDO::FETCH_OBJ);
			//--------------------/\
			
			//------get account code from vendor type
			$location_id	=	(empty($_POST["location_id"])) ? 0 : $_POST["location_id"];
			$sqlvdrtpe		=	"select a.pch_account, a.pch_cash_account, a.pch_return_account, a.pch_discount_account, a.vendor_deposit_account, a.currency_account, a.cheque_payable_account from vendor_type_detail a where a.id_header='$datavendor->vendor_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlvdrtpe);
			$sql->execute();
			$datavdrtpe	=	$sql->fetch(PDO::FETCH_OBJ);
			
			$pch_account				=	$datavdrtpe->pch_account;
			$pch_cash_account			=	$datavdrtpe->pch_cash_account;
			$pch_return_account			=	$datavdrtpe->pch_return_account;
			$pch_discount_account		=	$datavdrtpe->pch_discount_account;
			$vendor_deposit_account		=	$datavdrtpe->vendor_deposit_account;
			$currency_account			=	$datavdrtpe->currency_account;
			$cheque_payable_account		=	$datavdrtpe->cheque_payable_account;
			//-------------------------------------/\
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_inv' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$po_ref 		= $_POST[po_ref_.$i];
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				//if ( !empty($item_code) && !empty($uom_code) && $select == 1) {
					
					$qty = numberreplace($_POST[qty_.$i]);
					$unit_cost = numberreplace($_POST[unit_cost_.$i]);
					$amount = $qty * $unit_cost;
					
					$sub_total = $sub_total + $amount;
					//----------get avarege cost
					/*$sqlpi 			= 	"select sum(ifnull(a.unit_cost,0)) unit_cost, sum(ifnull(a.qty,0)) qty from purchase_invoice_detail a where a.item_code='$item_code' and a.uom_code='$uom_code' group by a.item_code, a.uom_code";
					
					$resultpi		=	mysql_query($sqlpi);
					$datapi			=	mysql_fetch_object($resultpi);
					
					if($datapi->qty == 0) {
						$average_cost 	= 	$datapi->unit_cost;
					} else {
						$average_cost 	= 	$datapi->unit_cost / $datapi->qty;
					}			
					//------------------------/\
					*/
					//---------get item group
					$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code'"; // and a.uom_code_sales='$uom_code'";
					$sql=$dbpdo->prepare($sqlitm);
					$sql->execute();
					$dataitm	=	$sql->fetch(PDO::FETCH_OBJ);
					//------------------/\
					
					//-------get account from item type
					$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id = '$location_id' limit 1 ";
					$sql=$dbpdo->prepare($sqlitmtype);
					$sql->execute();
					$dataitmtype	=	$sql->fetch(PDO::FETCH_OBJ);
					
					$inventory_acccode			=	$dataitmtype->inventory_acccode;
					$productcost_acccode		=	$dataitmtype->productcost_acccode;
					$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
					$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
					$cogs_acccode				=	$dataitmtype->cogs_acccode;
					//---------------------------------/\
					
					//------get account code from item group
					$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id = '$location_id' limit 1 ";
					$sql=$dbpdo->prepare($sqlitmgrp);
					$sql->execute();
					$dataitmgrp	=	$sql->fetch(PDO::FETCH_OBJ);
					
					if($inventory_acccode == "") { $inventory_acccode			=	$dataitmgrp->inventory_acccode; }
					if($cogs_acccode == "") { $cogs_acccode				=	$dataitmgrp->cogs_acccode; }
					if($goodintransit_acccode == "") { $goodintransit_acccode		=	$dataitmgrp->goodintransit_acccode; }
					$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
					if($workinprocess_acccode == "") { $workinprocess_acccode		=	$dataitmgrp->workinprocess_acccode; }
					$consignment_acccode		=	$dataitmgrp->consignment_acccode;
					//---------------------------------------/\
					
					
					//---------inventory journal
					if ( !empty($inventory_acccode) && ($amount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ref . $inventory_acccode;
						if($amount > 0) { //debit
							$debit_amount = $amount;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_inv', '$date', '$inventory_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();
						}
						
						if($amount < 0) { //credit
							$debit_amount = $amount * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_inv', '$date', '$inventory_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
							$sql=$dbpdo->prepare($sqlstr);
							$sql->execute();			
						}
						
					}
					
					/*
					if ( !empty($sls_discount_account) && ($discount <> 0) ) { 		
						
						$j++;
						
						$keycode2	=	$ref . $sls_discount_account;
						if($discount > 0) { //debit
							$debit_amount = $discount * $qty;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$sls_discount_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";			
						}
						
						if($discount < 0) { //credit
							$debit_amount = ($discount * $qty) * -1;
							$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_invoice', '$date', '$sls_discount_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";			
						}
						
					}*/	
					
				//}		
				
			}
			
			
			//---------pembelian		
			$total	=	$sub_total + $freight_cost;
			if ( !empty($pch_account) && ($total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $pch_account;
				if($total > 0) { //credit
					$debit_amount = $total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_inv', '$date', '$pch_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($total < 0) { //debit
					$debit_amount = $total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_inv', '$date', '$pch_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			//----------ongkos kirim		
			$freight_account	= 	$_POST["freight_account"];
			if ( !empty($freight_account) && ($freight_cost <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $freight_account;
				if($freight_cost > 0) { //debit
					$debit_amount = $freight_cost;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_inv', '$date', '$freight_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($freight_cost < 0) { //credit
					$debit_amount = $freight_cost * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_inv', '$date', '$freight_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			
			//----------pajak (ppn)		
			$tax_code	=	$_POST["tax_code"];
			
			$sqltax 	=	"select a.tax_account from tax a where a.syscode='$tax_code' ";
			$sql=$dbpdo->prepare($sqltax);
			$sql->execute();
			$datatax	=	$sql->fetch(PDO::FETCH_OBJ);
			$tax_account=	$datatax->tax_account;
			
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			if ( !empty($tax_account) && ($tax_total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $tax_account;
				if($tax_total > 0) { //debit
					$debit_amount = $tax_total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_inv', '$date', '$tax_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($tax_total < 0) { //credit
					$debit_amount = $tax_total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_inv', '$date', '$tax_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
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
	
	
	//-----journal purchase return quick
	function journal_purchase_return_quick($ref){
		$dbpdo = DB::create();
		
		try {
			
			$date				=	date("Y-m-d", strtotime($_POST["date"]));
			$status				= 	$_POST["status"];
			$pi_ref				=	$_POST["pi_ref"];
			$vendor_code		=	$_POST["vendor_code"];		
			$location_id		= 	$_POST["location_id"];	
			$tax_code			=	$_POST["tax_code"];
			$tax_rate			=	numberreplace($_POST["tax_rate"]);
			$currency_code		=	$_POST["currency_code"];
			$rate				=	numberreplace($_POST["rate"]);
			$memo				= 	$_POST["memo"];
			$total				=	$sub_total; 
			
	        $uid			    =	$_SESSION["loginname"];
			$dlu			    =	date("Y-m-d H:i:s");
			
			//-------get vendor type
			$sqlvendor		=	"select a.vendor_type from vendor a where a.syscode='$vendor_code' ";
			$sql=$dbpdo->prepare($sqlvendor);
			$sql->execute();
			$datavendor		=	$sql->fetch(PDO::FETCH_OBJ);
			//--------------------/\
			
			//------get account code from vendor type
			$sqlvdrtpe		=	"select a.pch_account, a.pch_cash_account, a.pch_return_account, a.pch_discount_account, a.vendor_deposit_account, a.currency_account, a.cheque_payable_account from vendor_type_detail a where a.id_header='$datavendor->vendor_type' and a.location_id='$location_id' limit 1 ";
			$sql=$dbpdo->prepare($sqlvdrtpe);
			$sql->execute();
			$datavdrtpe		=	$sql->fetch(PDO::FETCH_OBJ);
			
			$pch_account				=	$datavdrtpe->pch_account;
			$pch_cash_account			=	$datavdrtpe->pch_cash_account;
			$pch_return_account			=	$datavdrtpe->pch_return_account;
			$pch_discount_account		=	$datavdrtpe->pch_discount_account;
			$vendor_deposit_account		=	$datavdrtpe->vendor_deposit_account;
			$currency_account			=	$datavdrtpe->currency_account;
			$cheque_payable_account		=	$datavdrtpe->cheque_payable_account;
			//-------------------------------------/\
			
			$sqlstr="delete from jrn where ivino='$ref' and ivitpe='purchase_return' ";
			$sql=$dbpdo->prepare($sqlstr);
			$sql->execute();
			
			$jmldata = (empty($_POST['jmldata'])) ? 0 : $_POST['jmldata'];
			$sub_total = 0;
			for ($i=0; $i<=$jmldata; $i++) {
				$select 		= $_POST[select_.$i];
				
				$item_code 		= $_POST[item_code_.$i];
				$uom_code 		= $_POST[uom_code_.$i];
				
				$qty = numberreplace($_POST[qty_.$i]);
				$unit_cost = numberreplace($_POST[unit_cost_.$i]);
				$amount = $qty * $unit_cost;
				
				$sub_total = $sub_total + $amount;
				
				//---------get item group
				$sqlitm		=	"select a.item_group_id, a.item_type_code from item a where a.syscode='$item_code'"; // and a.uom_code_sales='$uom_code'";
				$sql=$dbpdo->prepare($sqlitm);
				$sql->execute();
				$dataitm		=	$sql->fetch(PDO::FETCH_OBJ);
				//------------------/\
				
				//-------get account from item type
				$sqlitmtype		=	"select a.inventory_acccode, a.productcost_acccode, a.goodintransit_acccode, a.workinprocess_acccode, a.cogs_acccode from item_type_detail a where a.syscode_header ='$dataitm->item_type_code' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmtype);
				$sql->execute();
				$dataitmtype		=	$sql->fetch(PDO::FETCH_OBJ);
				
				$inventory_acccode			=	$dataitmtype->inventory_acccode;
				$productcost_acccode		=	$dataitmtype->productcost_acccode;
				$goodintransit_acccode		=	$dataitmtype->goodintransit_acccode;
				$workinprocess_acccode		=	$dataitmtype->workinprocess_acccode;
				$cogs_acccode				=	$dataitmtype->cogs_acccode;
				//---------------------------------/\
				
				//------get account code from item group
				$sqlitmgrp	=	"select a.inventory_acccode, a.cogs_acccode, a.goodintransit_acccode, a.purchase_discount_acccode, a.workinprocess_acccode, a.consignment_acccode from item_group_detail a where a.id_header='$dataitm->item_group_id' and a.location_id = '$location_id' limit 1 ";
				$sql=$dbpdo->prepare($sqlitmgrp);
				$sql->execute();
				$dataitmgrp		=	$sql->fetch(PDO::FETCH_OBJ);
				
				if($inventory_acccode == "") { $inventory_acccode			=	$dataitmgrp->inventory_acccode; }
				if($cogs_acccode == "") { $cogs_acccode				=	$dataitmgrp->cogs_acccode; }
				if($goodintransit_acccode == "") { $goodintransit_acccode		=	$dataitmgrp->goodintransit_acccode; }
				$purchase_discount_acccode	=	$dataitmgrp->purchase_discount_acccode;
				if($workinprocess_acccode == "") { $workinprocess_acccode		=	$dataitmgrp->workinprocess_acccode; }
				$consignment_acccode		=	$dataitmgrp->consignment_acccode;
				//---------------------------------------/\
				
				
				//---------inventory journal
				if ( !empty($inventory_acccode) && ($amount <> 0) ) { 		
					
					$j++;
					
					$keycode2	=	$ref . $inventory_acccode;
					if($amount > 0) { //credit
						$debit_amount = $amount;
						
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$inventory_acccode', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";	
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();		
					}
					
					if($amount < 0) { //debit
						$debit_amount = $amount * -1;
						$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$inventory_acccode', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
						$sql=$dbpdo->prepare($sqlstr);
						$sql->execute();			
					}
					
				}
					
				
			}
			
			
			//---------sub total pembelian		
			$total	=	$sub_total; // + $freight_cost;
			
			//----------pajak (ppn)		
			$tax_code	=	$_POST["tax_code"];
			
			$sqltax 	=	"select a.tax_account from tax a where a.syscode='$tax_code' ";
			$sql=$dbpdo->prepare($sqltax);
			$sql->execute();
			$datatax		=	$sql->fetch(PDO::FETCH_OBJ);
			$tax_account=	$datatax->tax_account;
			
			$tax_rate	=	numberreplace($_POST["tax_rate"]);
			$tax_total	=	($tax_rate * $total) / 100;
			if ( !empty($tax_account) && ($tax_total <> 0) ) { 		
				
				$memo_tax = 'Pajak Purchase Return : ' . $ref; 
					
				$j++;
				
				$keycode2	=	$ref . $tax_account;
				if($tax_total > 0) { //credit
					$debit_amount = $tax_total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$tax_account', '$memo_tax', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($tax_total < 0) { //debit
					$debit_amount = $tax_total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$tax_account', '$memo_tax', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
			}
			
			
			//---pembelian
			$total = $total + $tax_total;
			if ( !empty($pch_account) && ($total <> 0) ) { 		
					
				$j++;
				
				$keycode2	=	$ref . $pch_account;
				if($total > 0) { //debit
					$debit_amount = $total;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$pch_account', '$memo', '$debit_amount', 0, 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
					$sql=$dbpdo->prepare($sqlstr);
					$sql->execute();			
				}
				
				if($total < 0) { //credit
					$debit_amount = $total * -1;
					$sqlstr="insert into jrn(ivino, ivitpe, ividte, acccde, dcr, dbtamt, crdamt, curcde, excrte, keycde, lne, uid, dlu, sysdte) values('$ref', 'purchase_return', '$date', '$pch_account', '$memo', 0, '$debit_amount', 'idr', '0', '$keycode2', '$j', '$uid', '$dlu', '$dlu' )";
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
	
	
	
}

?>
