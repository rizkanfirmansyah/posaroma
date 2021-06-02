<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_dusun();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Dusun/Lingkungan successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Dusun/Lingkungan Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_dusun($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Dusun/Lingkungan successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Dusun/Lingkungan Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_dusun($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Dusun/Lingkungan successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Dusun/Lingkungan Error Delete</strong>
		</div>
<?php		

	}
}
?>
