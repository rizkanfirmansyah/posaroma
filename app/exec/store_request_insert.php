<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	
	$ref=notran($date, 'frmstore_request', '', '', ''); //---get no ref
		
	$hs=$insert->insert_store_request($ref);
	
	notran($date, 'frmstore_request', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Store Requesition successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Store Requesition Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_store_request($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Store Requesition successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Store Requesition Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_store_request($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Store Requesition successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Store Requesition Error Delete</strong>
		</div>
<?php		

	}
}
?>
