<?php	
	@session_start();
	date_default_timezone_set('Asia/Jakarta');
	
	include("app/include/sambung.php");
	$dbpdo = DB::create();
	
	//$sql = "update Users_Log set LogOut=getdate(), Active=0 where UserID='$_SESSION[userid]' and Active=1 ";
	//odbc_exec(condb,$sql);
	
	/*setcookie("data_login","",time()-60);*/
	//ob_start();
	$date_now = date("Y-m-d");
	$location_id	=	$_SESSION["location_id2"];
	$uid			=	$_SESSION["loginname"];
	
	$where = " where a.location_id='$location_id' and (date_format(a.dlu_login,'%Y-%m-%d')='$date_now' or date_format(a.dlu_logout,'%Y-%m-%d')='$date_now') and a.usrid<>'$uid' ";
	$sqlstr="select a.id, a.status from usr_log a " . $where . " order by a.id desc limit 1";
	
	$sql=$dbpdo->prepare($sqlstr);
	$sql->execute();
	$data  = $sql->fetch(PDO::FETCH_OBJ);
	$status = $data->status;
	
	if($status == 0) {
		$dlu	=	date("Y-m-d H:i:s");
		$sqllog = "insert into usr_log (usrid, location_id, dlu_logout, status) values ('$uid', '$location_id', '$dlu', '0')";
		$rsltlog=$dbpdo->query($sqllog);
	}
	
	session_unset();
	session_destroy();
	header("Location: home.php");
?>	