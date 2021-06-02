<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_division();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Division successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Division Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_division($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Division successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Division Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_division($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Division successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Division Error Delete</strong>
		</div>
<?php		

	}
}
?>
