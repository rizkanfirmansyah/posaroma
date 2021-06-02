<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_department();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Department successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Department Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_department($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Department successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Department Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_department($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Department successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Department Error Delete</strong>
		</div>
<?php		

	}
}
?>
