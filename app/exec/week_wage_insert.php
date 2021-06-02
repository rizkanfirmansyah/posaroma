<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 
include 'app/class/class.insert.journal.php';
include 'app/class/class.update.journal.php';

$insert=new insert;
$update=new update;
$delete=new delete;
$insert_journal	=	new insert_journal;
$update_journal	=	new update_journal;

$post = $_POST[submit];

if ($post == "Save" ){
	
	$date	=	date('Y-m-d', strtotime($_POST["date"]));
	
	$ref=notran($date, 'frmweek_wage', '', '', $_SESSION["location"]); //---get no ref
		
	$hs=$insert->insert_week_wage($ref);
	
	notran($date, 'frmweek_wage', 1, '', $_SESSION["location"]) ; //----eksekusi ref
	
	if($hs){
	
		//$insert_journal->journal_week_wage($ref); //-------journal
?>
		<div class="alert alert-success">
			<strong>Save Weekly Wage successfully</strong>
		</div>
		
		<script>
			window.location = 'main.php?menu=app&act=<?php echo obraxabrix(week_wage) ?>&search=<?php echo $ref ?>';				//http://localhost/samson/main.php?menu=app&act=45278a270457d7a439f0306fddd787f1&search=GDG2WEG-0216-00011
			//http://localhost/samson/main.php?menu=app&act=45278a270457d7a439f0306fddd787f1&search=GDG2WEG-0216-00007
		</script>
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>Weekly Wage Error Save</strong>
		</div>
<?php		
	}	
}

if ($post == "Update" ){
	$hs=$update->update_week_wage($_POST['ref']);
	if($hs){			
	
		//$update_journal->journal_week_wage($_POST['ref']); //-------journal
?>
		<div class="alert alert-success">
			<strong>Update Weekly Wage successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Weekly Wage Error Update</strong>
		</div>
<?php		

	}
}
 
if ($post == "Delete" ){
	$hs=$delete->delete_week_wage($_POST['ref']);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete Weekly Wage successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>Weekly Wage Error Delete</strong>
		</div>
<?php		

	}
}
?>
