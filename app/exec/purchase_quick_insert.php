<?php
include 'app/class/class.insert.php';
include 'app/class/class.insert.journal.php';
include 'app/class/class.update.php';
include 'app/class/class.update.journal.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;
$insert_journal	=	new insert_journal;
$update_journal	=	new update_journal;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	
	$ref=notran($date, 'frmpurchase_quick', '', '', ''); //---get no ref
		
	$hs=$insert->insert_purchase_quick($ref);
	
	notran($date, 'frmpurchase_quick', 1, '', '') ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_purchase_quick($ref); //-------journal
?>
		<div class="alert alert-success">
			<strong>Save Purchase Quick successfully</strong>
		</div>
		
        <!--
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(purchase_quick) ?>&search=<?php echo $ref ?>';			
		</script>-->
        
        <script>
            window.location = 'main.php?menu=app&act=<?php echo obraxabrix(purchase_quick) ?>'
        </script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Quick Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_purchase_quick($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_purchase_quick($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Purchase Quick successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Quick Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_purchase_quick($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Purchase Quick successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Quick Error Delete</strong>
		</div>
<?php		

	}
}
?>
