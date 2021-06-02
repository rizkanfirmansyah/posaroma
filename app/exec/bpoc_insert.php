<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_bpoc();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Payment Cheque successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Payment Cheque Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_bpoc($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Payment Cheque successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Payment Cheque Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_bpoc($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Payment Cheque successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Payment Cheque Error Delete</strong>
		</div>
<?php		

	}
}
?>
