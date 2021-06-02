<?php
include 'app/class/class.insert.php';
include 'app/class/class.insert.journal.php';
include 'app/class/class.update.php';
include 'app/class/class.update.journal.php';
//include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
//$delete=new delete;
$insert_journal	=	new insert_journal;
$update_journal	=	new update_journal;

$post = $_POST[submit];

if ($post == "Save Detail" ){
	
	$ref	= $_POST['old_ref'];
	if($ref == "") {
		$ref	= random(9);
	}
	
	$hs=$insert->insert_cashier_detail($ref);
	
	if($hs){
		
?>
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(cashier) ?>&xndf=<?php echo $ref ?>'			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Cashier Detail Error Save</strong>
		</div>
<?php		
	}	
}


if ($post == "Save" ){
	
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	$xndf	=	$_POST['xndf'];
	
	$ref=notran($date, 'frmcashier_pos', '', '', ''); //---get no ref
		
	$hs=$insert->insert_cashier($ref, $xndf);
	
	notran($date, 'frmcashier_pos', 1, '', '') ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_cashier($ref); //-------journal
		
?>
		<div class="alert alert-success">
			<strong>Save Cashier successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(cashier) ?>&search=<?php echo $ref ?>';			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Cashier Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_cashier($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_cashier($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Cashier successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Cashier Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_cashier($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Cashier successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Cashier Error Delete</strong>
		</div>
<?php		

	}
}
?>
