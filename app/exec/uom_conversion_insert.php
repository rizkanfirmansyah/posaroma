<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_uom_conversion();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save UoM Conversion successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>UoM Conversion Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_uom_conversion($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update UoM Conversion successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>UoM Conversion Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_uom_conversion($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete UoM Conversion successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>UoM Conversion Error Delete</strong>
		</div>
<?php		

	}
}
?>
