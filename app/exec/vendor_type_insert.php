<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_vendor_type();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Supplier Type successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Supplier Type Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_vendor_type($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Supplier Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Supplier Type Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_vendor_type($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Supplier Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Supplier Type Error Delete</strong>
		</div>
<?php		

	}
}
?>
