<?php
@session_start();

date_default_timezone_set('Asia/Jakarta');

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$uid 		= $_GET["uid"];
$uid_print	= $_GET["uid_print"];
if($uid == "") {
	$uid = $uid_print;
}

$from_date	            =    $_REQUEST['from_date'];
$to_date		    	=    $_REQUEST['to_date'];
$shift	          		=    $_REQUEST['shift'];
$cashier				=	 $_REQUEST['uid'];
$all			       	=    $_REQUEST['all'];
$void			       	=    $_REQUEST['void_'];
$receipt_type_pos		=	 $_REQUEST['receipt_type_pos'];

if($from_date == "") {
	$from_date = date("d-m-Y");
}

if($to_date == "") {
	$to_date = date("d-m-Y");
}

if($all == 1 || $all == true) {
	$all = 1;
}


?>

<input type="hidden" id="uidx" name="uidx" value="<?php echo $uid ?>"/>
<input type="hidden" id="uid_print" name="uid_print" value="<?php echo $uid_print ?>"/>
<input type="hidden" id="from_date" name="from_date" value="<?php echo $from_date ?>"/>
<input type="hidden" id="to_date" name="to_date" value="<?php echo $to_date ?>"/>
<input type="hidden" id="shift" name="shift" value="<?php echo $shift ?>"/>
<input type="hidden" id="all" name="all" value="<?php echo $all ?>"/>
<input type="hidden" id="void" name="void" value="<?php echo $void ?>"/>
<input type="hidden" id="receipt_type_pos" name="receipt_type_pos" value="<?php echo $receipt_type_pos ?>"/>

<script>
	var uid = document.getElementById('uidx').value;
	var uid_print = document.getElementById('uid_print').value;
	var from_date = document.getElementById('from_date').value;
	var to_date = document.getElementById('to_date').value;
	var shift = document.getElementById('shift').value;
	var all = document.getElementById('all').value;
	var __void = document.getElementById('void').value;
	var receipt_type_pos = document.getElementById('receipt_type_pos').value;
	
	window.location = 'http://localhost/aromapos/app/pos_view_z_sum_print_ol.php?uid='+uid+'&uid_print='+uid_print+'&from_date='+from_date+'&to_date='+to_date+'&shift='+shift+'&all='+all+'&void='+__void+'&receipt_type_pos='+receipt_type_pos;		
</script>

