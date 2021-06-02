<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Update" ){
	
	$hs=$update->update_item_list($_POST['syscode']);
	
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Harga successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(item_list) ?>';			
		</script>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Harga Error Update</strong>
		</div>
<?php		

	}
}
 
 
?>
