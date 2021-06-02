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
	
	$ref=notran($date, 'frmsales_order', '', '', ''); //---get no ref
		
	$hs=$insert->insert_sales_order($ref);
	
	notran($date, 'frmsales_order', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Sales Order successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(sales_order) ?>&search=<?php echo $ref ?>';			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Sales Order Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_sales_order($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Sales Order successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Sales Order Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_sales_order($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Sales Order successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Sales Order Error Delete</strong>
		</div>
<?php		

	}
}
?>
