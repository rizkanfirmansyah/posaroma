<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_currency_rate_type();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Currency Rate Type successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Currency Rate Type Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_currency_rate_type($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Currency Rate Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Currency Rate Type Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_currency_rate_type($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Currency Rate Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Currency Rate Type Error Delete</strong>
		</div>
<?php		

	}
}
?>
