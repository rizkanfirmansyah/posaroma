<?php
include 'app/class/class.insert.php';
include 'app/class/class.insert.journal.php';
include 'app/class/class.update.php';
include 'app/class/class.update.journal.php';
include 'app/class/class.delete.php';

$insert=new insert;
$update=new update;
$delete=new delete;
$insert_journal	=	new insert_journal;
$update_journal	=	new update_journal;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	
	$ref=notran($date, 'frmcash_payment', '', '', $_SESSION["location"]); //---get no ref
		
	$hs=$insert->insert_cash_payment($ref);
	
	notran($date, 'frmcash_payment', 1, '', $_SESSION["location"]) ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_cash_payment($ref); //-------journal
?>
		<div class="alert alert-success">
			<strong>Save Petty Cash Payment successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Petty Cash Payment Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_cash_payment($_POST['ref']);
	if($hs){
		
		$update_journal->journal_cash_payment($_POST['ref']); //-------journal			
?>
		<div class="alert alert-success">
			<strong>Update Petty Cash Payment successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Petty Cash Payment Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_cash_payment($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Petty Cash Payment successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Petty Cash Payment Error Delete</strong>
		</div>
<?php		

	}
}
?>
