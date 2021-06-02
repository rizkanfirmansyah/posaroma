<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_set_vendor_balance();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Set AP Balance successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Set AP Balance Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_set_vendor_balance($_POST['vendor_code']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Set AP Balance successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Set AP Balance Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_set_vendor_balance($_POST['vendor_code']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Set AP Balance successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Set AP Balance Error Delete</strong>
		</div>
<?php		

	}
}
?>
