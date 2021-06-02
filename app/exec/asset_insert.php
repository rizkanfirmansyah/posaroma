<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;

$post = $_POST[submit];

if ($post == "Save" ){
	
    $date	=	date('Y-m-d');
    
    $ref=notran($date, 'frmasset', '', '', ''); //---get no ref
    
	$hs=$insert->insert_asset($ref);
	
	if($hs){
        
        notran($date, 'frmasset', 1, '', '') ; //----eksekusi ref
?>
		<div class="alert alert-success">
			<strong>Save Asset successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(asset) ?>&search=<?php echo $ref ?>';			
		</script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Asset Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_asset($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update Asset successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Asset Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_asset($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Asset successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Asset Error Delete</strong>
		</div>
<?php		

	}
}
?>
