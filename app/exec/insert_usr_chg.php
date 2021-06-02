<?php
$post = $_POST[submit];

if ($post == "Save" ){
	
	//------cek username lama dan pass lama
	$dbpdo = DB::create();
	$sqlstr = "Select usrid, pwd from usr where usrid='$_SESSION[loginname]' ";
	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$user = $sql->fetch(PDO::FETCH_OBJ); 
	
	if ($user->usrid != $_POST["old_usrid"]) {
?>
	<div class="alert alert-success">
		User ID Lama tidak benar
	</div>
<?php		
	exit;
	}
	
	if ($user->pwd != obraxabrix($_POST["old_pwd"], $_POST["old_usrid"])) {
?>
	<div class="alert alert-error">
		Password Lama tidak benar
	</div>
<?php	
	exit;	
	}
	//$fv->validateEmpty('loginname','Username baru harus diisi');
	//$fv->validateEmpty('pass','Password baru harus diisi');
	
	//--------cek user, sudah ada atau blm?
	$dbpdo = DB::create();
	$sqlstr = "Select usrid from usr where usrid='$_POST[usrid]' ";
	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$user = $sql->fetch(PDO::FETCH_OBJ); 
	
	$rows = $sql->rowCount();
	
	if ($rows == 1) {
		if ($user->usrid != $_POST["old_usrid"]) {
?>
	<div class="alert alert-error">
		User ID sudah ada yang pakai
	</div>
<?php			
		exit; }
	}
	
	$dbpdo = DB::create();
	
	$old_usrid=$_POST["old_usrid"];
	$old_pwd=obraxabrix($_POST["old_pwd"], $_POST["old_usrid"]); //md5($_POST["old_pwd"]);
	$usrid=$_POST["usrid"];
	$pwd=obraxabrix($_POST["pwd"], $_POST["usrid"]); //md5($_POST["pwd"]);	
	
	$sqlstr = "Update usr Set usrid='$usrid', pwd='$pwd' Where usrid='$old_usrid' and pwd='$old_pwd' ";	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	
	$sqlstr = "Update usr_dtl Set usrid='$usrid' Where usrid='$old_usrid' ";	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	
	$sqlstr = "Update usr_bup set usrid='$usrid', pwd='$_POST[pwd]' Where usrid='$old_usrid'";		
	$sql=$dbpdo->prepare($sqlstr);
	$results=$sql->execute();
	
	if($results){
?>
		<div class="alert alert-success">
			Change User ID and Password successfully
		</div>
<?php					
	}else{
?>
		<div class="alert alert-error">
			Change User ID and Password Error Save
		</div>
<?php		
	}	
}
?>
