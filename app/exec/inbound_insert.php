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
	
	$ref=notran($date, 'frminbound', '', '', ''); //---get no ref
		
	$hs=$insert->insert_inbound($ref);
	
	notran($date, 'frminbound', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Inbound successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Inbound Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_inbound($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Inbound successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Inbound Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_inbound($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Inbound successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Inbound Error Delete</strong>
		</div>
<?php		

	}
}
?>
