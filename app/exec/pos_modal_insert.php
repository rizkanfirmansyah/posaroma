<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php';
include 'app/class/class.insert.journal.php';

$insert = new insert;
$update = new update;
$delete = new delete;
$insert_journal	=	new insert_journal;

$post = $_POST['submit'];

if ($post == "Save") {

	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	$ref	=	notran($date, 'frmcash_receipt', '', '', ''); //---get no ref

	$uid				=	$_SESSION["loginname"];
	$account_code		=	"197430350"; //Kas (Pusat)
	$account_code_det	=	"273655693";
	$memo1				=	"Penerimaan Kas Kecil " . $uid;
	$memo_det			=	"Uang Modal Kas Kecil " . $uid;

	$hs		=	$insert->insert_pos_modal_cash_receipt($ref, $account_code, $account_code_det, $memo1, $memo_det);

	if ($hs) {

		$insert_journal->journal_pos_modal_cash_receipt($ref, $account_code, $account_code_det, $memo1, $memo_det); //-------journal

		notran($date, 'frmcash_receipt', 1, '', ''); //----eksekusi ref

		$_SESSION['shift'] = $_POST['shift'];

?>
		<div class="alert alert-success">
			<strong>Save Modal successfully</strong>
		</div>

		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix('pos') ?>';
		</script>

	<?php
	}
}

if ($post == "Kasir POS") {

	$_SESSION['shift'] = $_POST['shift'];

	?>
	<script>
		window.location = 'main.php?menu=app&act=<?php echo obraxabrix('pos') ?>';
	</script>

<?php
}
?>

<?php
/*else{
?>
		<div class="alert alert-error">
			<strong>UoM Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_uom($_POST['code']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update UoM successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>UoM Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_uom($_POST['code']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete UoM successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>UoM Error Delete</strong>
		</div>
<?php		

	}
}*/
?>