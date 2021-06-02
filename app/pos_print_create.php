<?php
@session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$uid = $_GET["uid"];

$tmpdir= sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
$file=  "pos_print_" . $uid . ".txt";

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
$cash_voucher 	=   $row_cash_invoice->cash_voucher;

##get nama cabang
$sqlwhs = $select->list_warehouse($_SESSION["location_id2"]);
$datawhs = $sqlwhs->fetch(PDO::FETCH_OBJ);
$namatoko = $datawhs->name;
$alamattoko = $datawhs->address;

if($namatoko == "") {
	$namatoko = "SAHABAT WERKODORO";
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
$Data.= date("H:i:s") . "\n";
$Data.= $date . " " . $ref . " " . $petugas . "\n";
$Data.= "----------------------------------------\n";

##detail

$totalqty = 0;
$totalamount = 0;
$sql2 = $selectview->list_cash_invoice_detail($ref);
while($row_cash_invoice_detail=$sql2->fetch(PDO::FETCH_OBJ)) {
	
	
	//set posisi satuan
	$len_code = strlen($row_cash_invoice_detail->code);
	$len_name = strlen(substr($row_cash_invoice_detail->item_name,0,29));
	$i=1;
	$uomchar = "";
	for($i=1; $i<=$max_char-($len_code+$len_name+4); $i++) {
		$uomchar = " " . $uomchar;
	}
	$Data.= $row_cash_invoice_detail->code . " " . substr($row_cash_invoice_detail->item_name,0,29) . 
	$uomchar . $row_cash_invoice_detail->uom_code . "\n";
	
	//set qty
	$max_qty = 9;
	$qty_spasi = $max_qty - strlen($row_cash_invoice_detail->qty);
	$i=1;
	$qty_spasi2 = "";
	for($i=1; $i<=$qty_spasi; $i++) {
		$qty_spasi2 = " " . $qty_spasi2;
	}
	
	//set unit_price
	$max_unit_price = 14;
	$unit_price_spasi = $max_unit_price - strlen(number_format($row_cash_invoice_detail->unit_price,0,".",","));
	$i=1;
	$unit_price_spasi2 = "";
	for($i=1; $i<=$unit_price_spasi-$qty_spasi; $i++) {
		$unit_price_spasi2 = " " . $unit_price_spasi2;
	}
	
	//set posisi harga
	$len_qty = strlen($row_cash_invoice_detail->qty);
	$len_unit_price = strlen(number_format($row_cash_invoice_detail->amount,0,".",","));
	$i=1;
	$amountchar = "";
	for($i=1; $i<=$max_char-($len_qty+$len_unit_price+20); $i++) {
		$amountchar = " " . $amountchar;
	}
	
	$Data.= $qty_spasi2 . $row_cash_invoice_detail->qty . " X " . $unit_price_spasi2 . number_format($row_cash_invoice_detail->unit_price,0,".",",") . " = " . 
	
	$amountchar . number_format($row_cash_invoice_detail->amount,0,".",",") . "\n";
	$totalqty = $totalqty + $row_cash_invoice_detail->qty;
	$totalamount = $totalamount + $row_cash_invoice_detail->amount;
}
##end print
$Data.= "----------------------------------------\n"; //40 karakter

//set jumlah item
$len_totalqty = strlen(number_format($totalqty,0,".",","));
$i=1;
for($i=1; $i<=$max_char-($len_totalqty+14); $i++) {
	$totalqtychar = $totalqtychar . " ";
}
$Data.= "JUMLAH ITEM : " . $totalqtychar . number_format($totalqty,0,".",",") . "\n";

//set jumlah total
$len_totalamount = strlen(number_format($totalamount,0,".",","));
$i=1;
for($i=1; $i<=$max_char-($len_totalamount+12); $i++) {
	$totalamountchar = $totalamountchar . " ";
}
$Data.= "T O T A L : " . $totalamountchar . number_format($totalamount,0,".",",") . "\n";
$Data.= "----------------------------------------\n";

//set tunai
$len_tunai = strlen(number_format($totalamount,0,".",","));
$i=1;
for($i=1; $i<=$max_char-($len_tunai+12); $i++) {
	$tunaichar = $tunaichar . " ";
}
$Data.= "T U N A I : " . $tunaichar . number_format($totalamount,0,".",",") . "\n";
$Data.= "----------------------------------------\n";

//set dibayar
$len_cash = strlen(number_format($cash_amount,0,".",","));
$i=1;
for($i=1; $i<=$max_char-($len_cash+16); $i++) {
	$cashchar = $cashchar . " ";
}
$Data.= "D I B A Y A R : " . $cashchar . number_format($cash_amount,0,".",",") . "\n";

if($cash_voucher > 0) {
	//set voucher
	$len_voucher = strlen(number_format($cash_voucher,0,".",","));
	$i=1;
	for($i=1; $i<=$max_char-($len_voucher+16); $i++) {
		$cashchar2 = $cashchar2 . " ";
	}
	$Data.= "V O U C H E R : " . $cashchar2 . number_format($cash_voucher,0,".",",") . "\n";
}

//set kembalian
$len_change = strlen(number_format($change_amount,0,".",","));
$i=1;
for($i=1; $i<=$max_char-($len_change+20); $i++) {
	$changechar = $changechar . " ";
}
$Data.= "K E M B A L I A N : " . $changechar . number_format($change_amount,0,".",",") . "\n";
$Data.= "";
$Data.= "";
$Data.= "        Barang yang sudah dibeli" . " \n";
$Data.= "        Tidak dapat dikembalikan" . " \n";
$Data.= "    Terima Kasih Atas Kunjungan Anda" . "\n";
$Data.= "\n";
$Data.= "\n";
$Data.= "\n";
$Data.= "\n";
$Data.= "\n";
$Data.= "\n";
if($cash_voucher > 0) {
	$Data.= "\n";	
}	



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
	//var url  = "http://localhost:8080/tokosahabat/main.php?menu=app&act=<?php echo obraxabrix(pos) ?>&search=<?php echo $ref ?>";
	var url  = "http://localhost/tokosahabat/main.php?menu=app&act=<?php echo obraxabrix(pos) ?>&search=<?php echo $ref ?>";
	window.location = url;
	//window.location = 'http://localhost:8080/tokosahabat/app/pos_print.php';	//localhost
	//window.location = 'http://localhost/tokosahabat/app/pos_print.php'; //localhost (client)
	//window.location = 'http://localhost/tokosahabat/app/pos_print_ol.php'; //online		
</script>

