<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$syscode	=	$_POST['syscode'];
	
	$hs=$insert->insert_set_item_price($syscode);
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Setup Harga Barang successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(set_item_price_view) ?>'			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Setup Harga Barang Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_set_item_price($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Setup Barang successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Setup Barang Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_set_item_price($_POST['syscode']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Setup Barang successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Setup Barang Error Delete</strong>
		</div>
<?php		

	}
}
?>
