<?php
include '../app/class/class.insert.php';
include '../app/class/class.update.php';
//include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;

$post = $_POST[submit];

if ($post == "Save" ){
		
	$hs=$insert->insert_cashier_box_subdetail();
	
	if($hs){
		
		$ref  = $_POST['ref'];
		$line = $_POST['line_detail'];
?>
		<div class="alert alert-success">
			<strong>Save Cashier Kotakan successfully</strong>
		</div>
		
		<script>
			window.location = 'cashier_box_subdetail.php?ref=<?php echo $ref ?>&line=<?php echo $line ?>';
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Cashier Kotakan Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_cashier_box_subdetail($_POST['ref']);
	if($hs){			
	
		$ref  = $_POST['ref'];
		$line = $_POST['line_detail'];
?>
		<div class="alert alert-success">
			<strong>Update Cashier Kotakan successfully</strong>
		</div>
		
		<script>
			window.location = 'cashier_box_subdetail.php?ref=<?php echo $ref ?>&line=<?php echo $line ?>';
		</script>		
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Cashier Kotakan Error Update</strong>
		</div>
<?php		

	}
}
 
?>
