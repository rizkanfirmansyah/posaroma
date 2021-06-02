<?php
include 'app/class/class.insert.php';
include 'app/class/class.insert.journal.php';
include 'app/class/class.update.php';
include 'app/class/class.update.journal.php';
//include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;

$insert_journal	=	new insert_journal;
$update_journal	=	new update_journal;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	
	$ref=notran($date, 'frmorder_stock', '', '', ''); //---get no ref
		
	$hs=$insert->insert_order_stock($ref);
	
	notran($date, 'frmorder_stock', 1, '', '') ; //----eksekusi ref
	
	if($hs){
		
?>
		<div class="alert alert-success">
			<strong>Save Stok Pesanan successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix('order_stock') ?>&search=<?php echo $ref ?>';			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Stok Pesanan Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_order_stock($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_cashier($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Stok Pesanan successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Stok Pesanan Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	include 'app/class/class.delete.php'; 
	$delete=new delete;
	
	$hs=$delete->delete_order_stock($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Stok Pesanan successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Stok Pesanan Error Delete</strong>
		</div>
<?php		

	}
}
?>
