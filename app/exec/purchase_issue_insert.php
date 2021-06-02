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
	
	$ref=notran($date, 'frmpurchase_issue', '', '', ''); //---get no ref
		
	$hs=$insert->insert_purchase_issue($ref);
	
	notran($date, 'frmpurchase_issue', 1, '', '') ; //----eksekusi ref
	
	if($hs){
		
		$insert_journal->journal_purchase_issue($ref); //-------journal
?>
		<div class="alert alert-success">
			<strong>Save Purchase Issued successfully</strong>
		</div>
		
        <!--
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(purchase_issue) ?>&search=<?php echo $ref ?>';			
		</script>-->
        
        <script>
            window.location = 'main.php?menu=app&act=<?php echo obraxabrix(purchase_issue) ?>'
        </script>
		
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Issued Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_purchase_issue($_POST['ref']);
	if($hs){			
	
		$update_journal->journal_purchase_issue($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Purchase Issued successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Issued Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_purchase_issue($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Purchase Issued successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Purchase Issued Error Delete</strong>
		</div>
<?php		

	}
}
?>
