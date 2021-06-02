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
	
	$ref=notran($date, 'frmgood_receipt', '', '', ''); //---get no ref
		
	$hs=$insert->insert_good_receipt($ref);
	
	notran($date, 'frmgood_receipt', 1, '', '') ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_good_receipt($ref); //-------journal
?>
		<div class="alert alert-success">
			<strong>Save Good Receipt successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Good Receipt Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_good_receipt($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_good_receipt($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Good Receipt successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Good Receipt Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_good_receipt($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Good Receipt successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Good Receipt Error Delete</strong>
		</div>
<?php		

	}
}
?>
