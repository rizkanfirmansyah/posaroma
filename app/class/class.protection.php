<?php

class protection{
	
	function protection_ar($ref='', $credit_amount=0){
		
		$sql			=	mysql_query("select credit_amount from ar where invoice_no='$ref' and credit_amount > 0 limit 1");
		$data 			= 	mysql_fetch_object($sql);
		$credit_amount 	= 	$data->credit_amount;
			
		return $credit_amount;
		
	}



}
?>