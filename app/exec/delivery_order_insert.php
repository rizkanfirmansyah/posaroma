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
	
	$ref=notran($date, 'frmdelivery_order', '', '', ''); //---get no ref
		
	$hs=$insert->insert_delivery_order($ref);
	
	notran($date, 'frmdelivery_order', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Delivery Order successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Delivery Order Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_delivery_order($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Delivery Order successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Delivery Order Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_delivery_order($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Delivery Order successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Delivery Order Error Delete</strong>
		</div>
<?php		

	}
}
?>
