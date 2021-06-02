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
	
	$ref=notran($date, 'frmpurchase_invoice', '', '', ''); //---get no ref
		
	$hs=$insert->insert_purchase_invoice($ref);
	
	notran($date, 'frmpurchase_invoice', 1, '', '') ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_purchase_invoice($ref); //-------journal
?>
		<div class="alert alert-success">
			<strong>Save Purchase Invoice successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Invoice Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_purchase_invoice($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_purchase_invoice($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Purchase Invoice successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Invoice Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_purchase_invoice($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Purchase Invoice successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Invoice Error Delete</strong>
		</div>
<?php		

	}
}
?>
