<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 
include 'app/class/class.insert.journal.php';
include 'app/class/class.update.journal.php';

$insert=new insert;
$update=new update;
$delete=new delete;
$insert_journal	=	new insert_journal;
$update_journal	=	new update_journal;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	
	$ref=notran($date, 'frmreceipt', '', '', ''); //---get no ref
		
	$hs=$insert->insert_receipt($ref);
	
	if($hs){
		
		$insert_journal->journal_receipt($ref); //-------journal
		
		notran($date, 'frmreceipt', 1, '', '') ; //----eksekusi ref
?>
		<div class="alert alert-success">
			<strong>Save Receipt successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(receipt) ?>&search=<?php echo $ref ?>'			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Receipt Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_receipt($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_receipt($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Receipt successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Receipt Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_receipt($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Receipt successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Receipt Error Delete</strong>
		</div>
<?php		

	}
}
?>
