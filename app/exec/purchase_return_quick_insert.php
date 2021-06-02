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

if ($post == "Save Detail" ){
	
	$ref	= $_POST['old_ref'];
	if($ref == "") {
		$ref	= random(9);
	}
	
	$hs=$insert->insert_purchase_return_quick_detail($ref);
	
	if($hs){
		
?>
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(purchase_return_quick) ?>&xndf=<?php echo $ref ?>'	</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Retur Pembelian Detail Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Save" ){
	
	$ref_tmp = $_POST['old_ref'];
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	
	$ref=notran($date, 'frmpurchase_return_quick_pos', '', '', ''); //---get no ref
		
	$hs=$insert->insert_purchase_return_quick($ref, $ref_tmp);
	
	notran($date, 'frmpurchase_return_quick_pos', 1, '', '') ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_purchase_return_quick($ref); //-------journal
?>
		<div class="alert alert-success">
			<strong>Save Purchase Return successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(purchase_return_quick) ?>&search=<?php echo $ref ?>'	</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Return Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_purchase_return_quick($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_purchase_return_quick($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Purchase Return successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Return Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_purchase_return_quick($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Purchase Return successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Return Error Delete</strong>
		</div>
<?php		

	}
}
?>
