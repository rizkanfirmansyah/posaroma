<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_currency();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Currency successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Currency Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_currency($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Currency successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Currency Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_currency($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Currency successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Currency Error Delete</strong>
		</div>
<?php		

	}
}
?>
