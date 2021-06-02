<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_client_type();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Client Type successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Client Type Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_client_type($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Client Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Client Type Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_client_type($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Client Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Client Type Error Delete</strong>
		</div>
<?php		

	}
}
?>
