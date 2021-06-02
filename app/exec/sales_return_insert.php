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
	
	$ref=notran($date, 'frmsales_return', '', '', ''); //---get no ref
		
	$hs=$insert->insert_sales_return($ref);
	
	notran($date, 'frmsales_return', 1, '', '') ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_sales_return($ref); //-------journal
?>
		<div class="alert alert-success">
			<strong>Save Sales Return successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Sales Return Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_sales_return($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_sales_return($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Sales Return successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Sales Return Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_sales_return($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Sales Return successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Sales Return Error Delete</strong>
		</div>
<?php		

	}
}
?>
