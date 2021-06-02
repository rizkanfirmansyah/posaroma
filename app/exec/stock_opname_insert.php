<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_stock_opname();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Stock Opname successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Stock Opname Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_stock_opname($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Stock Opname successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Stock Opname Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_stock_opname($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Stock Opname successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Stock Opname Error Delete</strong>
		</div>
<?php		

	}
}
?>
