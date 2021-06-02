<?php 
include_once ("include/functions.php");

$uid = $_GET["uid"];

$tmpdir= sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
$file=  "outbound_print" . $uid . ".txt"; //tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
/*$handle= fopen($file, 'w');
$condensed= Chr(27) . Chr(33) . Chr(4);
$bold1= Chr(27) . Chr(69);
$bold0= Chr(27) . Chr(70);
$initialized= chr(27).chr(64);
$condensed1= chr(15);
$condensed0= chr(18);
$Data  = $initialized;
$Data.= $condensed1;*/

/*$Data.= "==========================\n";*/
/*$Data.= "|     ".$bold1."SAHABAT KARTINI".$bold0."      |\n";
$Data.= "|     ".$bold1."JLN. KARTINI TEGAL".$bold0."      |\n";
$Data.= "\n";
$Data.= date("H:i:s") . "\n";
$Data.= date("d-m-Y") . "\n";
$Data.= "CB COFFEMIX 3IN1 10X16G      15     142,500\n";
$Data.= "";
$Data.= "--------------------------\n";*/


/*$file=  "test.txt";  # nama file temporary yang akan dicetak
$handle= fopen($file, 'w');*/
/*fwrite($handle, $Data);
fclose($handle);*/
//@copy($file, "//localhost/xprinter1");  # Lakukan cetak  (harus konek ke jaringan atau internet)
//copy($file, "//192.168.43.106/xprinter");  # Lakukan cetak  (harus konek ke jaringan atau internet)
//copy($file, "//192.168.43.106/xprinter");  # Lakukan cetak
@copy($file, "//localhost/tmu220server");  # Lakukan cetak  (harus konek ke jaringan atau internet)

//@copy($file, "//localhost/xprinter1");  # Lakukan cetak  (harus konek ke jaringan atau internet)

//include("pos_print.php");

//@unlink($file);

//$msg = "<meta http-equiv=\"Refresh\" content=\"0;url=./pos_print.php\">"; //localhost
//$msg = "<meta http-equiv=\"Refresh\" content=\"1;./http://localhost:8080/tokosahabat/app/pos_print.php/\">"; //online
//if($msg) echo $msg;

?>


<script>
	//window.close();
	
	//var url  = "http://localhost:8080/tokosahabat/main.php?menu=app&act=<?php echo obraxabrix(outbound) ?>";
	var url  = "http://possp.sahabatputra.com/main.php?menu=app&act=<?php echo obraxabrix(outbound) ?>";
	window.location = url;
	
</script>
