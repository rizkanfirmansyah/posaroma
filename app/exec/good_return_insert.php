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
	
	$ref=notran($date, 'frmgood_return', '', '', ''); //---get no ref
		
	$hs=$insert->insert_good_return($ref);
	
	notran($date, 'frmgood_return', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Good Return successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Good Return Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_good_return($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Good Return successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Good Return Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_good_return($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Good Return successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Good Return Error Delete</strong>
		</div>
<?php		

	}
}
?>
