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
	
	$ref=notran($date, 'frmitem_issued', '', '', ''); //---get no ref
		
	$hs=$insert->insert_item_issued($ref);
	
	notran($date, 'frmitem_issued', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Item Issued successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Issued Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_item_issued($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Item Issued successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Issued Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_item_issued($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Item Issued successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Issued Error Delete</strong>
		</div>
<?php		

	}
}
?>
