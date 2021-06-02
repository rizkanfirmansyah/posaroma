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
	
	$ref=notran($date, 'frmpurchase_order', '', '', ''); //---get no ref
		
	$hs=$insert->insert_purchase_order($ref);
	
	notran($date, 'frmpurchase_order', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Purchase Order successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Order Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_purchase_order($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Purchase Order successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Order Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_purchase_order($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Purchase Order successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Order Error Delete</strong>
		</div>
<?php		

	}
}
?>
