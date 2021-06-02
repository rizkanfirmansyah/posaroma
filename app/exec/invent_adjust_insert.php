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
	
	$ref=notran($date, 'frminvent_adjust', '', '', ''); //---get no ref
		
	$hs=$insert->insert_invent_adjust($ref);
	
	notran($date, 'frminvent_adjust', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Inventory Adjustment successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Inventory Adjustment Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_invent_adjust($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Inventory Adjustment successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Inventory Adjustment Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_invent_adjust($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Inventory Adjustment successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Inventory Adjustment Error Delete</strong>
		</div>
<?php		

	}
}
?>
