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
	
	$ref=notran($date, 'frmdelivery_order_project', '', '', $_SESSION["location"]); //---get no ref
		
	$hs=$insert->insert_delivery_order_project($ref);
	
	notran($date, 'frmdelivery_order_project', 1, '', $_SESSION["location"]) ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_delivery_order($ref); //-------journal
		
?>
		<div class="alert alert-success">
			<strong>Save Delivery Order Project successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(delivery_order_project) ?>&search=<?php echo $ref ?>';			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Delivery Order Project Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_delivery_order_project($_POST['ref']);
	if($hs){		
	
		$update_journal->journal_delivery_order($_POST['ref']); //-------journal	
?>
		<div class="alert alert-success">
			<strong>Update Delivery Order Project successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Delivery Order Project Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_delivery_order_project($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Delivery Order Project successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Delivery Order Project Error Delete</strong>
		</div>
<?php		

	}
}
?>
