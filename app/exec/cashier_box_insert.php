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

if ($post == "Save Detail" ){
	
	$ref	= $_POST['old_ref'];
	if($ref == "") {
		$ref	= random(15);
	}
	
	$hs=$insert->insert_cashier_box_detail($ref);
	
	if($hs){
		
?>
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix('cashier_box') ?>&xndf=<?php echo $ref ?>'			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Cashier Kotakan Detail Error Save</strong>
		</div>
<?php		
	}	
}


if ($post == "Save" ){
	
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	$xndf	=	$_POST['xndf'];
	
	$ref=notran($date, 'frmcashier_box_pos', '', '', ''); //---get no ref
		
	$hs=$insert->insert_cashier_box($ref, $xndf);
	
	notran($date, 'frmcashier_box_pos', 1, '', '') ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_cashier($ref); //-------journal
		
?>
		<div class="alert alert-success">
			<strong>Save Cashier Kotakan successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix('cashier_box') ?>&search=<?php echo $ref ?>';			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Cashier Kotakan Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_cashier_box($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_cashier($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Cashier Kotakan successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Cashier Kotakan Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	include 'app/class/class.delete.php'; 
	$delete=new delete;
	
	$hs=$delete->delete_cashier_box($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Cashier Kotakan successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Cashier Kotakan Error Delete</strong>
		</div>
<?php		

	}
}
?>
