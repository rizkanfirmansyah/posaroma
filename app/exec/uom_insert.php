<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_uom();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save UoM successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>UoM Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_uom($_POST['code']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update UoM successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>UoM Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_uom($_POST['code']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete UoM successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>UoM Error Delete</strong>
		</div>
<?php		

	}
}
?>
