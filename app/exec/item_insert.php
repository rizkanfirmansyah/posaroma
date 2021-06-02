<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$hs=$insert->insert_item();
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Item successfully</strong>
		</div>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	
	$hs=$update->update_item($_POST['syscode']);
	
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Item successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(item) ?>&search=<?php echo $_POST[syscode] ?>';			
		</script>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_item($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Item successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Item Error Delete</strong>
		</div>
<?php		

	}
}
?>
