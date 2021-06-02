<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_company();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Company successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Company Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_company($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Company successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Company Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_company($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Company successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Company Error Delete</strong>
		</div>
<?php		

	}
}
?>
