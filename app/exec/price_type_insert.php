<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_price_type();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Price Type successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Price Type Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_price_type($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Price Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Price Type Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_price_type($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Price Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Price Type Error Delete</strong>
		</div>
<?php		

	}
}
?>
