<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_item_type();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Item Type successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Type Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_item_type($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Item Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Type Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_item_type($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Item Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Type Error Delete</strong>
		</div>
<?php		

	}
}
?>
