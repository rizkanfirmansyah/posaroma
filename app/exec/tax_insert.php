<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_tax();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Tax successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Tax Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_tax($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Tax successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Tax Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_tax($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Tax successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Tax Error Delete</strong>
		</div>
<?php		

	}
}
?>
