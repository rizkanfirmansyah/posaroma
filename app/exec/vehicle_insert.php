<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_vehicle();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Vehicle successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Vehicle Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_vehicle($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Vehicle successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Vehicle Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_vehicle($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Vehicle successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Vehicle Error Delete</strong>
		</div>
<?php		

	}
}
?>
