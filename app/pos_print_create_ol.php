<?php
@session_start();

date_default_timezone_set('Asia/Jakarta');

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$uid 	= 	$_GET["uid"];
$ref	= 	$_REQUEST['ref'];

?>

<input type="hidden" id="ref" name="ref" value="<?php echo $ref ?>"/>
<input type="hidden" id="uidx" name="uidx" value="<?php echo $uid ?>"/>

<script>
	var uid = document.getElementById('uidx').value;
	var ref = document.getElementById('ref').value;
	
	window.location = "http://localhost/aromapos/app/pos_print_ol.php?uid="+uid+"&ref="+ref; //online
</script>

