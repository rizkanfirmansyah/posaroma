<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_position();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Position successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Position Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_position($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Position successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Position Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_position($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Position successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Position Error Delete</strong>
		</div>
<?php		

	}
}
?>
