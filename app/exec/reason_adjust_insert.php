<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_reason_adjust();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Reason to Adjust successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Reason to Adjust Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_reason_adjust($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Reason to Adjust successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Reason to Adjust Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_reason_adjust($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Reason to Adjust successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Reason to Adjust Error Delete</strong>
		</div>
<?php		

	}
}
?>
