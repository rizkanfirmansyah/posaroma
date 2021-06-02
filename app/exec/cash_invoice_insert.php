<?php
include 'app/class/class.insert.php';
include 'app/class/class.insert.journal.php';
include 'app/class/class.update.php';
include 'app/class/class.update.journal.php';
include 'app/class/class.delete.php'; 
//include 'app/class/class.protection.php';

$insert=new insert;
$update=new update;
$delete=new delete;
$insert_journal	=	new insert_journal;
$update_journal	=	new update_journal;
//$protection = new protection;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	
	$ref=notran($date, 'frmcash_invoice', '', '', $_SESSION["location"]); //---get no ref
		
	$hs=$insert->insert_cash_invoice($ref);
	
	notran($date, 'frmcash_invoice', 1, '', $_SESSION["location"]) ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_cash_invoice($ref); //-------journal
		
?>
		<div class="alert alert-success">
			<strong>Save Cash Invoice successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(cash_invoice) ?>&search=<?php echo $ref ?>';			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Cash Invoice Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_cash_invoice($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_cash_invoice($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Cash Invoice successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Cash Invoice Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_cash_invoice($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Cash Invoice successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Cash Invoice Error Delete</strong>
		</div>
<?php		

	}
}
?>
