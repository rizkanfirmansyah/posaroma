<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_item_balance($ref);
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Set Item Balance successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Set Item Balance Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_item_balance($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Set Item Balance successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Set Item Balance Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_item_balance($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Set Item Balance successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Set Item Balance Error Delete</strong>
		</div>
<?php		

	}
}
?>
