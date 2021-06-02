<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_size();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Size successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Size Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_size($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Size successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Size Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_size($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Size successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Size Error Delete</strong>
		</div>
<?php		

	}
}
?>
