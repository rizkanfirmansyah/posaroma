<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$ref = notran(date('Y-m-d'), 'frmclient_pos', '', '', '');
	
	$hs=$insert->insert_client($ref);
	
	if($hs){
		
		notran(date('Y-m-d'), 'frmclient_pos', '1', '', '');
?>
		<div class="alert alert-success">
			<strong>Save Client successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Client Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_client($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Client successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Client Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_client($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Client successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Client Error Delete</strong>
		</div>
<?php		

	}
}
?>
