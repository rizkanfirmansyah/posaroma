<?php
@session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$uid = $_GET["uid"];

$tmpdir= sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
$file=  "pos_print_kasir_" . $uid . ".txt";

$handle= fopen($file, 'w');
$condensed= Chr(27) . Chr(33) . Chr(4);
$bold1= Chr(27) . Chr(69);
$bold0= Chr(27) . Chr(70);
$initialized= chr(27).chr(64);
$condensed1= chr(15);
$condensed0= chr(18);
$Data  = $initialized;
$Data.= $condensed1;


##get data
//include_once ("include/queryfunctions.php");
include_once ("include/sambung.php");
include_once ("include/functions.php");
//include_once ("include/inword.php");

include 'class/class.select.php';
include 'class/class.selectview.php';

$select = new select;
$selectview = new selectview;

$from_date	            =    $_REQUEST['from_date'];
$to_date		    	=    $_REQUEST['to_date'];
$shift	          		=    $_REQUEST['shift'];
$cashier				=	 $_REQUEST['cashier'];
$all			       	=    $_REQUEST['all'];

if($from_date == "") {
	$from_date = date("d-m-Y");
}

if($to_date == "") {
	$to_date = date("d-m-Y");
}

if($all == 1 || $all == true) {
	$all = 1;
}


$sql = $selectview->list_pos_print_total('', $all, $from_date, $to_date, $shift, $cashier);
$row_cash_invoice=$sql->fetch(PDO::FETCH_OBJ);

$ref			=	$row_cash_invoice->ref;
$date			=	date("d-m-Y", strtotime($row_cash_invoice->date));

$total 			= 	$row_cash_invoice->total;

##get nama cabang
$sqlwhs = $select->list_warehouse($row_cash_invoice->location_id);
$datawhs = $sqlwhs->fetch(PDO::FETCH_OBJ);
$namatoko = $datawhs->name;
$alamattoko = $datawhs->address;

if($namatoko == "") {
	$namatoko = "SAHABAT WERKUDORO";
}

if($alamattoko == "" ) {
	$alamattoko = "JLN. WERKUDORO, TEGAL";
}

##start print
$max_char = 40;
/*$Data.= "            SAHABAT KARTINI" . "\n";
$Data.= "          JLN. KARTINI, TEGAL" . "\n";*/
$len_namatoko = strlen($namatoko); 
$i=1;
$char_toko = "";
for($i=1; $i<=(($max_char - $len_namatoko)/2); $i++) {
	$char_toko = " " . $char_toko;
}

$len_alamattoko = strlen($alamattoko); 
$i=1;
$char_alamattoko = "";
for($i=1; $i<=(($max_char - $len_alamattoko)/2); $i++) {
	$char_alamattoko = " " . $char_alamattoko;
}

$Data.= $char_toko . $namatoko . "\n";
$Data.= $char_alamattoko . $alamattoko . "\n";
$Data.= date("d-m-Y H:i:s") . "\n";
$Data.= "----------------------------------------\n";

##detail

$totalqty = 0;
$totalamount = 0;

$sqlcsr = $selectview->get_kasir($cashier);
while($data_kasir = $sqlcsr->fetch(PDO::FETCH_OBJ)) {
	
	$sql2 = $selectview->list_pos_print_total('', "", $from_date, $to_date, $shift, $data_kasir->uid);
	$rows = $sql2->rowCount();
	
	if($rows > 0) {
		$Data.= "KASIR :" . $data_kasir->uid . "\n";
	}
	
	
	while($row_cash_invoice_detail=$sql2->fetch(PDO::FETCH_OBJ)) {
		
		
		/*//set total cash
		$cashchar = "";
		$max_cash = strlen(number_format($row_cash_invoice_detail->cash_amount,2,".",","));
		$i=1;
		for($i=1; $i<=$max_char-($max_cash+22); $i++) {
			$cashchar = $cashchar . " ";
		}
		$Data.= "	KONTAN          : " . $cashchar . number_format($row_cash_invoice_detail->cash_amount,2,".",",") . "\n";*/
		
		if($row_cash_invoice_detail->cash_voucher > 0) {
			//set total voucher
			$voucherchar = "";
			$max_voucher = strlen(number_format($row_cash_invoice_detail->cash_voucher,2,".",","));
			$i=1;
			for($i=1; $i<=$max_char-($max_voucher+22); $i++) {
				$voucherchar = $voucherchar . " ";
			}
			$Data.= "	VOUCHER         : " . $voucherchar . number_format($row_cash_invoice_detail->cash_voucher,2,".",",") . "\n";
			
		}
		
		//set total
		$totalchar = "";
		$max_total = strlen(number_format($row_cash_invoice_detail->total,2,".",","));
		$i=1;
		for($i=1; $i<=$max_char-($max_total+22); $i++) {
			$totalchar = $totalchar . " ";
		}

		$Data.= "	TOTAL PENJUALAN : " . $totalchar . number_format($row_cash_invoice_detail->total,2,".",",") . "\n";
		
	}
	
	$Data.= "\n";

}

##end print
$Data.= "----------------------------------------\n"; //40 karakter

$Data.= "\n";
$Data.= "\n";
$Data.= "\n";
$Data.= "\n";
$Data.= "\n";
$Data.= "\n";



/*$file=  "test.txt";  # nama file temporary yang akan dicetak
$handle= fopen($file, 'w');*/
fwrite($handle, $Data);
fclose($handle);
//@copy($file, "//localhost/xprinter1");  # Lakukan cetak  (harus konek ke jaringan atau internet)
//@copy($file, "//possp.sahabatputra.com/xprinter1");  # Lakukan cetak  (harus konek ke jaringan atau internet)
//copy($file, "//192.168.43.106/xprinter");  # Lakukan cetak  (harus konek ke jaringan atau internet)
//copy($file, "//192.168.43.106/xprinter");  # Lakukan cetak
@copy($file, "//localhost/tmu220server");  # Lakukan cetak  (harus konek ke jaringan atau internet)

//include("pos_print.php");

//@unlink($file);

//$msg = "<meta http-equiv=\"Refresh\" content=\"0;url=./pos_print.php\">"; //localhost
//$msg = "<meta http-equiv=\"Refresh\" content=\"1;./http://localhost:8080/tokosahabat/app/pos_print.php/\">"; //online
//if($msg) echo $msg;

##update printed
$dbpdo = DB::create();
$sqlstr = "update sales_invoice set printed=ifnull(printed,0) + 1 where ref='$ref'";
$sql=$dbpdo->prepare($sqlstr);
$sql->execute();

?>

<script>
	//var url  = "http://localhost:8080/tokosahabat/main.php?menu=app&act=<?php echo obraxabrix(pos_view) ?>";
	var url  = "http://localhost/tokosahabat/main.php?menu=app&act=<?php echo obraxabrix(pos_view) ?>";
	window.location = url;
	//window.location = 'http://localhost:8080/tokosahabat/app/pos_print.php';	//localhost
	//window.location = 'http://localhost/tokosahabat/app/pos_print.php'; //localhost (client)
	//window.location = 'http://localhost/tokosahabat/app/pos_print_ol.php'; //online		
</script>

