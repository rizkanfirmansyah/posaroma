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
	
	$ref=notran($date, 'frmdelivery_return', '', '', ''); //---get no ref
		
	$hs=$insert->insert_delivery_return($ref);
	
	notran($date, 'frmdelivery_return', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Delivery Return successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Delivery Return Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_delivery_return($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Delivery Return successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Delivery Return Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_delivery_return($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Delivery Return successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Delivery Return Error Delete</strong>
		</div>
<?php		

	}
}
?>
