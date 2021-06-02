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
	
	$ref=notran($date, 'frmsales_invoice_project', '', '', ''); //---get no ref
		
	$hs=$insert->insert_sales_invoice_project($ref);
	
	notran($date, 'frmsales_invoice_project', 1, '', '') ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_cash_invoice($ref); //-------journal
		
?>
		<div class="alert alert-success">
			<strong>Save Project Sales Invoice successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(sales_invoice_project) ?>&search=<?php echo $ref ?>';			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Project Sales Invoice Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_sales_invoice_project($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_cash_invoice($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Project Sales Invoice successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Project Sales Invoice Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_sales_invoice_project($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Project Sales Invoice successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Project Sales Invoice Error Delete</strong>
		</div>
<?php		

	}
}
?>
