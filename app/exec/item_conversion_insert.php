<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_item_conversion();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Item Conversion successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Conversion Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_item_conversion($_POST['item_code2']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Item Conversion successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Conversion Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_item_conversion($_POST['item_code2']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Item Conversion successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Conversion Error Delete</strong>
		</div>
<?php		

	}
}
?>
