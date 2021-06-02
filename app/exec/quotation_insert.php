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
	
	$ref=notran($date, 'frmquotation', '', '', ''); //---get no ref
		
	$hs=$insert->insert_quotation($ref);
	
	notran($date, 'frmquotation', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Quotation successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Quotation Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_quotation($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Quotation successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Quotation Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_quotation($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Quotation successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Quotation Error Delete</strong>
		</div>
<?php		

	}
}
?>
