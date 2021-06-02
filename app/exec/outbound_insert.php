<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save Detail" ){
	
	$ref	= $_POST['old_ref'];
	if($ref == "") {
		$ref	= random(15);
	}
	
	$hs=$insert->insert_outbound_detail($ref);
	
	if($hs){
		
?>
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(outbound) ?>&xndf=<?php echo $ref ?>'		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Pembelian Detail Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Save" ){
	
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	$ref_detail	=	$_POST['xndf'];
	
	$ref=notran($date, 'frmoutbound', '', '', ''); //---get no ref
		
	$hs=$insert->insert_outbound($ref, $ref_detail);
	
	notran($date, 'frmoutbound', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Outbound successfully</strong>
			
			<script>
				window.location = 'main.php?menu=app&act=<?php echo obraxabrix(outbound) ?>&search=<?php echo $ref ?>'		</script>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Outbound Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_outbound($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Outbound successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Outbound Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_outbound($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Outbound successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Outbound Error Delete</strong>
		</div>
<?php		

	}
}
?>
