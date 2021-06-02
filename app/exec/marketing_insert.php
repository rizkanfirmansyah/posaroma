<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_marketing();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Marketing successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Marketing Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_marketing($_POST['code']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Marketing successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Marketing Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_marketing($_POST['code']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Marketing successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Marketing Error Delete</strong>
		</div>
<?php		

	}
}
?>
