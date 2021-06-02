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
	
	$ref=notran($date, 'frmsales_invoice', '', '', ''); //---get no ref
		
	$hs=$insert->insert_sales_invoice($ref);
	
	notran($date, 'frmsales_invoice', 1, '', '') ; //----eksekusi ref
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save Sales Invoice successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(sales_invoice) ?>&search=<?php echo $ref ?>';			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Sales Invoice Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_sales_invoice($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Sales Invoice successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Sales Invoice Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_sales_invoice($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Sales Invoice successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Sales Invoice Error Delete</strong>
		</div>
<?php		

	}
}
?>
