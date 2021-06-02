<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_employee();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Employee successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Employee Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_employee($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Employee successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Employee Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_employee($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Employee successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Employee Error Delete</strong>
		</div>
<?php		

	}
}
?>
