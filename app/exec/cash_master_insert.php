<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_cash_master();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Cash Master successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Cash Master Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_cash_master($_POST['old_code']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Cash Master successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Cash Master Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_cash_master($_POST['old_code']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Cash Master successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Cash Master Error Delete</strong>
		</div>
<?php		

	}
}
?>
