<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_credit_card_type();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Credit Card Type successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Credit Card Type Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_credit_card_type($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Credit Card Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Credit Card Type Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_credit_card_type($_POST['id']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Credit Card Type successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Credit Card Type Error Delete</strong>
		</div>
<?php		

	}
}
?>
