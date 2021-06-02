<?php
@session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$uid = $_GET["uid"];

$tmpdir= sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
$file=  "outbound_print_" . $uid . ".txt";  //tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak
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

$petugas		=	$_SESSION["loginname"];
$ref			= 	$_REQUEST['ref'];

$sql = $selectview->list_cash_invoice($ref);
$row_cash_invoice=$sql->fetch(PDO::FETCH_OBJ);

$ref			=	$row_cash_invoice->ref;
$date			=	date("d-m-Y", strtotime($row_cash_invoice->date));

$discount2	 	= 	$row_cash_invoice->discount;
$total 			= 	$row_cash_invoice->total;
$cash_amount    =   $row_cash_invoice->cash_amount;
$change_amount  =   $row_cash_invoice->change_amount;


##start print
$Data.= "            SAHABAT KARTINI" . "\n";
$Data.= "          JLN. KARTINI, TEGAL" . "\n";
$Data.= date("H:i:s") . "\n";
$Data.= $date . " " . $ref . " " . $petugas . "\n";
$Data.= "Asal Gudang :" . $from_location . "\n";
$Data.= "Tujuan Gudang :" . $to_location . "\n";
$Data.= "----------------------------------------\n";

##detail
$max_char = 40;

$totalqty = 0;
$totalamount = 0;
$sql2 = $select->list_outbound_detail($ref);
while($row_outbound_detail=$sql2->fetch(PDO::FETCH_OBJ)) {
	
	//set posisi barang
	$qty_spasi = strlen($row_outbound_detail->qty);
	$len_name = strlen(substr($row_outbound_detail->item_name,0,34));
	$i=1;
	$qty_spasi2 = "";
	for($i=1; $i<=$max_char - ($qty_spasi + $len_name); $i++) {
		$qty_spasi2 = " " . $qty_spasi2;
	}
	$Data.= substr($row_outbound_detail->item_name,0,34) . 
	$qty_spasi2 . number_format($row_outbound_detail->qty,2,".",",") . "\n";
	
	$totalqty = $totalqty + $row_outbound_detail->qty;
}
##end print
$Data.= "----------------------------------------\n"; //40 karakter

//set jumlah item
$len_totalqty = strlen(number_format($totalqty,2,".",","));
$i=1;
for($i=1; $i<=$max_char-($len_totalqty+14); $i++) {
	$totalqtychar = $totalqtychar . " ";
}
$Data.= "JUMLAH ITEM : " . $totalqtychar . number_format($totalqty,2,".",",") . "\n";

$Data.= "";
$Data.= "";
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
//@copy($file, "//possp.sahabatputra.com/xprinter1");  # Lakukan cetak  (harus konek ke jaringan atau internet)
//copy($file, "//192.168.43.106/xprinter");  # Lakukan cetak  (harus konek ke jaringan atau internet)
//copy($file, "//192.168.43.106/xprinter");  # Lakukan cetak
//@copy($file, "//localhost/tmu220server");  # Lakukan cetak  (harus konek ke jaringan atau internet)

//include("pos_print.php");

//@unlink($file);

?>

<script>
	//window.location = 'http://localhost:8080/tokosahabat/app/outbound_print.php';	//localhost
	//window.location = 'http://localhost/tokosahabat/app/outbound_print.php'; //localhost
	window.location = 'http://localhost/tokosahabat/app/outbound_print_ol.php?uid=<?php echo $uid ?>'; //online		
</script>

