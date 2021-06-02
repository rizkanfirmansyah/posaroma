<?php

function Login(){
	$dbpdo = DB::create();
	
	$username=$_POST['username'];
	$password=$_POST['password'];
	
	date_default_timezone_set('Asia/Jakarta');
	
    $_SESSION['bahasa'] = 0; //1;
    
	if($username && $password) {
	  $pas = @md5(@md5(@md5(@md5(@md5(@md5(@md5($password.$username.@strlen($password.$username)*15)))))));
	  $sql_cek = "select pwd from usr where usrid='$username' and pwd='$pas' and act=1";
	  $hasil_cek = $dbpdo->query($sql_cek);
	  $data_cek = $hasil_cek->fetch(PDO::FETCH_OBJ);
	 
	  if (!empty($data_cek->pwd)) {	  	  		
		  //$conn=@mysql_connect(HOST,USER,PASS) or die ("Whoops");
		  $password = @md5(@md5(@md5(@md5(@md5(@md5(@md5($password.$username.@strlen($password.$username)*15)))))));
		  $sql = "select id, usrid from usr where usrid='$username' and pwd='$password' and act=1"; 
		  $r = $dbpdo->query($sql);
		  $rr = $r->fetch(PDO::FETCH_OBJ);
		  		  
		  if($rr->usrid != ""){
				//@mysql_close($conn);
				
				$sql="select a.id, a.pwd, a.usrid, a.adm, a.photo, a.employee_id, ifnull(a.id_comp,0) id_comp from usr a where a.usrid='$username' and a.pwd='$password' and a.act=1";
				$password_r = $dbpdo->query($sql);
				$password_d = $password_r->fetch(PDO::FETCH_OBJ);
				
				$_SESSION["employee"]=$password_d->usrid; // ." ". $password['sname'];
				$_SESSION["loginname"]=$password_d->usrid;
				$_SESSION["userid"]=$password_d->usrid;
				$_SESSION["adm"]=$password_d->adm;
				$_SESSION["photo"]=$password_d->photo;
				$password=$password_d->pwd;	
				$_SESSION["id_user"]=$password_d->id;
				$_SESSION["employee_id"]=$password_d->employee_id;
				$_SESSION["id_comp"] = $password_d->id_comp;
				$_SESSION["ip_comp"] = $_SERVER['REMOTE_ADDR'];
				
				$sqlepy="select location_id from employee where id='$password_d->employee_id' ";
				$rsltepy=$dbpdo->query($sqlepy);
				$dataepy=$rsltepy->fetch(PDO::FETCH_OBJ);		
				$_SESSION["location_id2"]=$dataepy->location_id;
								
				$sqlwhs="select code location_code, name from warehouse where id='$dataepy->location_id' ";
				$rsltwhs=$dbpdo->query($sqlwhs);
				$datawhs=$rsltwhs->fetch(PDO::FETCH_OBJ);
				$_SESSION["location"]=$datawhs->location_code;
				$_SESSION["location_name"]=$datawhs->name;
				
				$sqlcln="select syscode client_syscode from client where name='Cash' ";
				$rsltcln=$dbpdo->query($sqlcln);
				$datacln=$rsltcln->fetch(PDO::FETCH_OBJ);
				$_SESSION["client_syscode"]=$datacln->client_syscode;
				
				//check ID computer
				if($_SESSION["id_comp"] == 1) {
					if(allow_id_comp() == 0) {
						echo "<center><font face=\"Verdana, Arial, Helvetica, sans-serif\" color=\"#FF0000\">ID Komputer belum terdaftar</font></center>";
						$_SESSION["logged"]=0;
						$_SESSION["userid"]="";
						exit;
					}
				}
				//-----------------
				
				//insert user_login
				$dlu	=	date("Y-m-d H:i:s");
				$sqllog = "insert into usr_log (usrid, location_id, dlu_login, status) values ('$password_d->usrid', '$_SESSION[location_id2]', '$dlu', '1')";
				$rsltlog=$dbpdo->query($sqllog);
				
				//******************************************************************
				//*Not the best option but produce the required results - unencrypted password saved to a cookie
				//******************************************************************
				##semntara di lock (2017-04-04) 
				setcookie("data_login","$username $password",time()+ (60 * 60 * 24 * 1));  // Set the cookie named 'candle_login' with the value of the username (in plain text) and the password (which has been encrypted and serialized.)
				##semntara di lock (2017-04-04) setcookie("data_login","$username $password");
				$_SESSION["logged"]=1;
											
				//echo $_SESSION["loginname"]; exit;
				
				//if($_SESSION["Captcha"]!=$_POST["nilaicaptcha"]){
					/*echo "<center><font face=\"Verdana, Arial, Helvetica, sans-serif\" color=\"#FF0000\">Invalid Captcha Code</font></center>";*/
					//$_SESSION["Captcha"]="";
					
					//$msg = "<meta http-equiv=\"Refresh\" content=\"0;url=./main.php\">"; 
					//header("Location: main.php");
					
				//} else {
					header("Location: main.php");
					exit;
					
				//} 								
						
								
				//
				
				/*echo "<script type='text/javascript'>";
				echo "window.location = 'main.php'";
				echo "</script>";  */
		  }else{
				$passed = new PDO("mysql:host=$host;dbname=$mydb, $userdb, $passdb");													
		  }
			
			//@mysql_select_db(DB);
			if (!$passed) {		
				
				/*if($_SESSION["Captcha"] == "")	{	
					echo "<center><font face=\"Verdana, Arial, Helvetica, sans-serif\" color=\"#FF0000\">Invalid Captcha Code</font></center>"; 
				} else {*/
				echo "<center><font face=\"Verdana, Arial, Helvetica, sans-serif\" color=\"#FF0000\">Invalid User Name or Password</font></center>";
				//}    
				$_SESSION["logged"]=0;
				$_SESSION["userid"]="";
				
			/*} else if($_SESSION["Captcha"]!=$_POST["nilaicaptcha"]){
				echo "<center><font face=\"Verdana, Arial, Helvetica, sans-serif\" color=\"#FF0000\">Invalid Captcha Code</font></center>";     
				$_SESSION["logged"]=0;
				$_SESSION["userid"]="";	*/							
			}else{
				$sql="select a.id, a.pwd, a.usrid, a.adm, a.photo, a.employee_id, ifnull(a.id_comp,0) id_comp from usr a where a.usrid='$username' and a.pwd='$password' and a.act=1";
				$password_r=$dbpdo->query($sql);
				$password_d=$password_r->fetch(PDO::FETCH_OBJ);
				
				$_SESSION["employee"]=$password_d->usrid; // ." ". $password->sname;
				$_SESSION["loginname"]=$password_d->usrid;
				$_SESSION["userid"]=$password_d->usrid;
				$_SESSION["adm"]=$password_d->adm;
				$_SESSION["photo"]=$password_d->photo;
				$password=$password_d->pwd;
				$_SESSION["id_user"]=$password_d->id;
				$_SESSION["employee_id"]=$password_d->employee_id;
				$_SESSION["id_comp"]=$password_d->id_comp;
				$_SESSION["ip_comp"] = $_SERVER['REMOTE_ADDR'];
					
				$sqlepy="select location_id from employee where id='$password_d->employee_id' ";
				$rsltepy=$dbpdo->query($sqlepy);
				$dataepy=$rsltepy->fetch(PDO::FETCH_OBJ);			
				$_SESSION["location_id2"]=$dataepy->location_id;
				
				$sqlwhs="select code location_code, name from warehouse where id='$dataepy->location_id' ";
				$rsltwhs=$dbpdo->query($sqlwhs);
				$datawhs=$rsltwhs->fetch(PDO::FETCH_OBJ);
				$_SESSION["location"]=$datawhs->location_code;
				$_SESSION["location_name"]=$datawhs->name;
				
				$sqlcln="select syscode client_syscode from client where name='Cash' ";
				$rsltcln=$dbpdo->query($sqlcln);
				$datacln=$rsltcln->fetch(PDO::FETCH_OBJ);
				$_SESSION["client_syscode"]=$datacln->client_syscode;
				
				//check ID computer
				if($_SESSION["id_comp"] == 1) {
					if(allow_id_comp() == 0) {
						echo "<center><font face=\"Verdana, Arial, Helvetica, sans-serif\" color=\"#FF0000\">ID Komputer belum terdaftar</font></center>";
						$_SESSION["logged"]=0;
						$_SESSION["userid"]="";
						exit;
					}
				}
				//-----------------
				
				//insert user_login
				$dlu	=	date("Y-m-d H:i:s");
				$sqllog = "insert into usr_log (usrid, location_id, dlu_login, status) values ('$password_d->usrid', '$_SESSION[location_id2]', '$dlu', '1')";
				$rsltlog=$dbpdo->query($sqllog);
				
				
				//******************************************************************
				//*Not the best option but produce the required results - unencrypted password saved to a cookie
				//******************************************************************
				##semntara di lock (2017-04-04) 
				setcookie("data_login","$username $password",time()+ (60 * 60 * 24 * 1));  // Set the cookie named 'candle_login' with the value of the username (in plain text) and the password (which has been encrypted and serialized.)
				##semntara di lock (2017-04-04) setcookie("data_login","$username $password");
				$_SESSION["logged"]=1;
								
				$msg = "<meta http-equiv=\"Refresh\" content=\"0;url=./main.php\">"; //put index.php	
				
			}
		} else {
			echo "<center><font face=\"Verdana, Arial, Helvetica, sans-serif\" color=\"#FF0000\">Invalid User Name or Password</font></center>";     
			$_SESSION["logged"]=0;
			$_SESSION["userid"]="";
		}
		
	}else{
		echo "<center><font face=\"Verdana, Arial, Helvetica, sans-serif\" color=\"#FF0000\">Enter your UserName and Password <br />to login on to the system</font></center>";
		$_SESSION["logged"]=0;
	}
	
	if($msg) echo $msg; 
}
?>