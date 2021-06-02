<?php
include 'app/class/class.insert.php';
include 'app/class/class.update.php';
include 'app/class/class.delete.php'; 

$insert=new insert;
$update=new update;
$delete=new delete;
//$select=new select;

$post = $_POST['submit'];

if ($post == "Save" ){
	
	//--------user check---------
	$usrid = $_POST['usrid'];
	$sql=$select->list_usr_check($usrid);
	$data_check = $sql->rowCount();	
	if ($data_check !=0) {
?>
		<div class="alert alert-error">
			<strong>User sudah ada yang pakai</strong>
		</div>
<?php	
		exit;
	}
	
	//-----------upload file
	$uploaddir = 'app/file_images/';
	$filename = $_FILES['image']['name']; 
	$tmpname  = $_FILES['image']['tmp_name'];
	$filesize = $_FILES['image']['size'];
	$filetype = $_FILES['image']['type'];
						
	if (empty($filename)) { 
		$filename = $image2; 
	} else {
		$filename = $filename;
	}
	$uploadfile = $uploaddir . $filename;		
	// proses upload file ke folder 'data'
	if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
		echo "<div align=\"center\" style=\"font-size:14px; color:#ffffff; padding-top:20px;\">Photo telah sukses diupload</div>";											
	} 
	//----------------
	
	$hs=$insert->insert_usr($ref,$filename);
	
	if($hs){
?>
		<div class="alert alert-success">
			<strong>Save User successfully</strong>
		</div>
<?php					
	}else{
?>
		<div class="alert alert-error">
			<strong>User Error Save</strong>
		</div>		
<?php		
	}	
}

if ($post == "Update" ){
	//-----------upload file
	$image2		=	$_POST["image2"];
	
	$uploaddir 	= 'app/file_images/';
	$filename 	= $_FILES['image']['name']; 
	$tmpname  	= $_FILES['image']['tmp_name'];
	$filesize 	= $_FILES['image']['size'];
	$filetype 	= $_FILES['image']['type'];
						
	if (empty($filename)) { 
		$filename = $image2; 
	} else {
		$filename = $filename;
	}
	$uploadfile = $uploaddir . $filename;		
	// proses upload file ke folder 'data'
	if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadfile)) {
		echo "<div align=\"center\" style=\"font-size:14px; color:#ffffff; padding-top:20px;\">Photo telah sukses diupload</div>";											
	} 
	//----------------
	
	$hs=$update->update_usr($_POST[id],$filename);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Update User successfully</strong>
		</div>	
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>User Error Update</strong>
		</div>
<?php		

	}
}

if ($post == "Delete" ){
	$hs=$delete->delete_usr($_POST[id]);
	if($hs){			
?>
		<div class="alert alert-success">
			<strong>Delete User successfully</strong>
		</div>
<?php
	}else{
?>
		<div class="alert alert-error">
			<strong>User Error Delete</strong>
		</div>
<?php		

	}
}
?>
