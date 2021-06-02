<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_item_category();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Item Category successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Category Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_item_category($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Item Category successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Category Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_item_category($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Item Category successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Category Error Delete</strong>
		</div>
<?php		

	}
}
?>
