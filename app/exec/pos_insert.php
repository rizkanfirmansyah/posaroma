<?php
// include 'class/class.insert.php';
// include 'class/class.update.php';
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
//include 'app/class/class.insert.journal.php';
//include 'app/class/class.update.journal.php';
//include 'app/class/class.delete.php'; 

$insert = new insert;
$update = new update;
//$delete=new delete;
//$insert_journal	=	new insert_journal;
//$update_journal	=	new update_journal;

$post = $_POST['submit'];

var_dump($_GET);


if ($post == "Save Detail") {

	$ref	= $_POST['old_ref'];
	if ($ref == "") {
		$ref	= random(15);
	}

	$hs = $insert->insert_pos_detail($ref);

	$dbpdo = DB::create();
	$item_code2		= $_POST['item_code2'];
	$item_code_expired  = "";
	if (preg_match("/`/", $item_code2) == 1) {
		$item_code_expired = $item_code2;
	}
	if ($item_code_expired != "") {
		$item_code_exp 	= explode('`', $item_code_expired);
		$item_code2		= $item_code_exp[0];
	}

	$sqlstr = "select syscode, uom_code_sales uom_code from item where (code='$item_code2' or old_code='$item_code2') limit 1";
	$sql1 = $dbpdo->prepare($sqlstr);
	$sql1->execute();
	$data = $sql1->fetch(PDO::FETCH_OBJ);
	$rows1 = $sql1->rowCount();

	if ($rows1 == 0) {

		//$item_code2 = $_POST['item_code2'];

?>
		<script>
			function xklik() {
				var klik = confirm("Barang tidak ditemukan");
				if (klik == true) {
					xklik();
				}
			}

			//----------fungsi enter untuk ganti qty---------
			var item_code2 = '<?php echo $item_code2 ?>';
			//alert(item_code2);
			var temukan = item_code2.indexOf("*");

			if (temukan != 1) {
				xklik();
			}
			//-------------------/\------------------------
		</script>


	<?php

	}

	if ($hs) {

	?>
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&xndf=<?php echo $ref ?>'
		</script>

	<?php
	} else {
	?>
		<div class="alert alert-error">
			<strong>Penjualan Detail Error Save</strong>
		</div>
	<?php
	}
}


if ($post == "Save") {

	$ref_tmp = $_POST['old_ref'];
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	$xndf	=	$_POST['xndf'];

	$location_id2 = $_SESSION['location_id2'];
	$id_user = $_SESSION["id_user"];

	$ref = notran($date, 'frmpos_pos', '', '', $id_user); //---get no ref

	$hs = $insert->insert_pos($ref, $xndf, $ref_tmp);


	if ($hs) {

		notran($date, 'frmpos_pos', 1, '', $id_user); //----eksekusi ref

		//$insert_journal->journal_pos($ref); //-------journal

		$uid	=	$_SESSION["loginname"];

	?>
		<div class="alert alert-success">
			<strong>Save Penjualan successfully</strong>

			<input type="hidden" id="ref" name="ref" value="<?php echo $ref ?>" />
			<input type="hidden" id="uidx" name="uidx" value="<?php echo $uid ?>" />
		</div>

		<script>
			var ref = document.getElementById('ref').value;
			var uid = document.getElementById('uidx').value;
			//window.location = "app/pos_print_create.php?ref="+ref+"&uid="+uid; //localhost only

			//window.location = "main.php?menu=app&act=bf2f8919c357fe1fdb7f05059b618c7a"; //online only
			//window.location = "app/pos_print_create_ol.php?ref="+ref+"&uid="+uid; //online only
			window.location = "http://localhost/aromapos/app/pos_print_ol.php?uid=" + uid + "&ref=" + ref;
		</script>

		<script type='text/javascript'>
			/*$(document).ready(function() { 
			  $("a[href^='http://']").each( 
				    function(){ 
						if(this.href.indexOf(app/pos_print_create.php) == -1) { 
							$(this).attr('target', '_blank'); 
						} 
					} 
				);
				$("a[href^='https://']").each( 
					function(){ 
						if(this.href.indexOf(app/pos_print_create.php) == -1) { 
							$(this).attr('target', '_blank'); 
						} 
					} 
				);   
			});*/
		</script>

	<?php
	} else {
	?>
		<div class="alert alert-error">
			<strong>Penjualan Error Save</strong>
		</div>
	<?php
	}
}

if ($post == "Update") {

	$hs = $update->update_pos($_POST['ref']);
	if ($hs) {

		//$update_journal->journal_pos($_POST['ref']); //-------journal
	?>
		<div class="alert alert-success">
			<strong>Update Penjualan successfully</strong>
		</div>
	<?php
	} else {
	?>
		<div class="alert alert-error">
			<strong>Penjualan Error Update</strong>
		</div>

	<?php

	}
}

if ($post == "Permintaan Void") {

	$hs = $update->update_pos_request_void($_POST['ref']);
	if ($hs) {

		//$update_journal->journal_pos($_POST['ref']); //-------journal
	?>
		<div class="alert alert-success">
			<strong>Permintaan Void Penjualan successfully</strong>
		</div>
	<?php
	} else {
	?>
		<div class="alert alert-error">
			<strong>Perminttan Void Error Update</strong>
		</div>

	<?php

	}
}

if ($post == "Delete") {

	include 'app/class/class.delete.php';
	$delete = new delete;

	$hs = $delete->delete_pos($_POST['ref']);
	if ($hs) {
	?>
		<div class="alert alert-success">
			<strong>Delete Penjualan successfully</strong>
		</div>
	<?php
	} else {
	?>
		<div class="alert alert-error">
			<strong>Penjualan Error Delete</strong>
		</div>
	<?php

	}
}

if ($post == "Closing") {

	$from_date	            =    $_REQUEST['from_date'];
	$to_date		    	=    $_REQUEST['to_date'];
	$shift	          		=    $_REQUEST['shift'];
	$cashier				=	 $_REQUEST['cashier'];
	$receipt_type_pos		=	 $_POST['receipt_type_pos'];
	$all			       	=    $_REQUEST['all'];
	$void			       	=    $_REQUEST['void_'];

	$hs = $update->closing_pos_all();
	if ($hs) {


	?>
		<div class="alert alert-success">
			<strong>Closing successfully</strong>

			<input type="hidden" id="from_date" name="from_date" value="<?php echo $from_date ?>" />
			<input type="hidden" id="to_date" name="to_date" value="<?php echo $to_date ?>" />
			<input type="hidden" id="shift" name="shift" value="<?php echo $shift ?>" />
			<input type="hidden" id="cashier" name="cashier" value="<?php echo $cashier ?>" />
			<input type="hidden" id="receipt_type_pos" name="receipt_type_pos" value="<?php echo $receipt_type_pos ?>" />
			<input type="hidden" id="uid_print" name="uid_print" value="<?php echo $uid_print ?>" />

			<script>
				var from_date = document.getElementById('from_date').value;
				var to_date = document.getElementById('to_date').value;
				var shift = document.getElementById('shift').value;
				var cashier = document.getElementById('cashier').value;
				var receipt_type_pos = document.getElementById('receipt_type_pos').value;
				var void_ = 0;
				var uid_print = document.getElementById('uid_print').value;

				window.location = "app/pos_view_closed_print_create_ol.php?from_date=" + from_date + "&to_date=" + to_date + "&shift=" + shift + "&uid=" + cashier + "&receipt_type_pos=" + receipt_type_pos + "&void_=" + void_ + "&uid_print=" + uid_print;
			</script>
		</div>
	<?php
	} else {
	?>
		<div class="alert alert-error">
			<strong>Closing Error</strong>
		</div>
	<?php

	}
}


if ($post == "Approval") {

	$hs = $update->approval_pos_overlimit();
	if ($hs) {

	?>
		<div class="alert alert-success">
			<strong>Approval Over Limit successfully</strong>
		</div>
	<?php
	} else {
	?>
		<div class="alert alert-error">
			<strong>Approval Over Limit Error</strong>
		</div>

<?php

	}
}

?>