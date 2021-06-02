<?php

$uid = $_GET["uid"];

$tmpdir= sys_get_temp_dir();   # ambil direktori temporary untuk simpan file.
$file=  "pos_print_" . $uid . ".txt"; //tempnam($tmpdir, 'ctk');  # nama file temporary yang akan dicetak

//---------hapus file
$file=  "pos_print_" . $uid . ".txt";
if (file_exists($file)) {
	unlink($file); //remove file 
}
//---------------------


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
$hour			=	date("H:i"); //, strtotime($row_cash_invoice->dlu));

$discount2	 	= 	$row_cash_invoice->discount;
$total 			= 	$row_cash_invoice->total;
$cash_amount    =   $row_cash_invoice->cash_amount;
$change_amount  =   $row_cash_invoice->change_amount;
$cash_voucher 	=   $row_cash_invoice->cash_voucher;
$ovo 			=   $row_cash_invoice->ovo;
$debit 			=   $row_cash_invoice->bank_amount;
$gopay 			=   $row_cash_invoice->gopay;
$void 			=   $row_cash_invoice->void;

##set logo
                   

##get nama cabang
$sqlwhs = $select->list_warehouse($_SESSION["location_id2"]);
$datawhs = $sqlwhs->fetch(PDO::FETCH_OBJ);
$namatoko = "AROMA BAKERY & CAKE SHOP"; //$datawhs->name;
$alamattoko = $datawhs->address;
$phonetoko = $datawhs->phone;

if($namatoko == "") {
	$namatoko = "AROMA BAKERY & CAKE SHOP";
}

if($alamattoko == "" ) {
	$alamattoko = "JL. SM. RAJA MEDAN";
}

##start print
$max_char = 40;
/*$Data.= "            SAHABAT KARTINI" . "\n";
$Data.= "          JLN. KARTINI, TEGAL" . "\n";*/
$len_namatoko = strlen($namatoko.$phonetoko); 
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

//$Data.= $char_toko . $namatoko . "\n";
$Data.= "       " . $namatoko . " \n";
//$Data.= $char_alamattoko . $alamattoko . ', '. $phonetoko . "\n";
$Data.= $char_alamattoko . $alamattoko . "\n";
$Data.= "Telepon : " . $phonetoko . " \n";

$len_petugas = strlen($petugas)+16; 
$i=1;
$char_petugas = "";
for($i=1; $i<=$max_char - ($len_petugas); $i++) {
	$char_petugas = " " . $char_petugas;
}

$Data.= $date . ' ' . $hour . $char_petugas . $petugas . "\n";
$Data.= $ref . "\n";
//$Data.= $date . ' ' . $hour . '      ' . $petugas . "\n";
//$Data.= $date . " " . $ref . " " . $petugas . "\n";
//$Data.= $date . "\n";

if($void == 1) {
	$Data.= "STATUS : BATAL" . "\n";
}
$Data.= "----------------------------------------\n";

##detail
$max_char = 40;

$totalqty = 0;
$totalamount = 0;
$totaldiscount = $discount2;
$sql2 = $selectview->list_cash_invoice_detail($ref);
while($row_cash_invoice_detail=$sql2->fetch(PDO::FETCH_OBJ)) {
	
	//set posisi satuan
	$len_code = 0; //strlen($row_cash_invoice_detail->code);
	$len_name = strlen(substr(trim($row_cash_invoice_detail->item_name),0,19));
	$i=1;
	$uomchar = "";
	for($i=1; $i<=$max_char-($len_code+$len_name+3); $i++) {
		$uomchar = " " . $uomchar;
	}
	//$Data.= $row_cash_invoice_detail->code . " " . substr($row_cash_invoice_detail->item_name,0,29) . 
	$Data.= substr(trim($row_cash_invoice_detail->item_name),0,19);
	//$uomchar . $row_cash_invoice_detail->uom_code . "\n";
	
	//set qty
	$max_qty = 21;
	$len_qty = strlen(number_format($row_cash_invoice_detail->qty,0,".",","));
	//$qty_spasi = $max_qty - strlen($row_cash_invoice_detail->qty);
	$i=1;
	$qty_spasi2 = "";
	for($i=1; $i<=$max_qty-($len_name+$len_qty); $i++) {
		$qty_spasi2 = " " . $qty_spasi2;
	}
	
	//set unit_price
	$max_unit_price = 14;
	$unit_price_spasi = $max_unit_price - strlen(number_format($row_cash_invoice_detail->unit_price,0,".",","));
	$i=1;
	$unit_price_spasi2 = "";
	for($i=1; $i<=$unit_price_spasi-($len_name+10); $i++) {
		$unit_price_spasi2 = " " . $unit_price_spasi2;
	}
	
	//set posisi harga
	$len_qty = strlen($row_cash_invoice_detail->qty);
	if($row_cash_invoice_detail->discount > 0) {
		$len_unit_price = strlen(number_format($row_cash_invoice_detail->amount + ($row_cash_invoice_detail->discount * $row_cash_invoice_detail->qty),0,".",","));
	} else {
		$len_unit_price = strlen(number_format($row_cash_invoice_detail->amount,0,".",","));
	}
	$i=1;
	$amountchar = "";
	for($i=1; $i<=$max_char-($len_unit_price+$len_qty+29); $i++) {
		$amountchar = " " . $amountchar;
	}
	
	//set posisi harga discount
	$len_qtydisc = strlen($row_cash_invoice_detail->qty);
	$len_unit_price_disc = strlen(number_format($row_cash_invoice_detail->discount,0,".",","));
	// * $row_cash_invoice_detail->qty
	$i=1;
	$amountdiscchar = "";
	for($i=1; $i<=$max_char-($len_unit_price_disc+29); $i++) {
		$amountdiscchar = " " . $amountdiscchar;
	}
	
	if($row_cash_invoice_detail->discount > 0) {
		
		$totaldiscount = $totaldiscount + ($row_cash_invoice_detail->discount * $row_cash_invoice_detail->qty);
		
		$Data.= $qty_spasi2 . number_format($row_cash_invoice_detail->qty,0,".",",") . "   " . $unit_price_spasi2 . number_format($row_cash_invoice_detail->unit_price,0,".",",") . "   " .
		$amountchar . number_format($row_cash_invoice_detail->amount + ($row_cash_invoice_detail->discount * $row_cash_invoice_detail->qty),0,".",",") . "\n";
		
		$discount_amount = $row_cash_invoice_detail->discount * $row_cash_invoice_detail->qty;
		$Data.= '         Disc : ' . number_format($row_cash_invoice_detail->discount3,0,".",",") . '%' . 
		$amountdiscchar . number_format($discount_amount,0,".",",") . "\n";
	} else {
		$Data.= $qty_spasi2 . number_format($row_cash_invoice_detail->qty,0,".",",") . "   " . $unit_price_spasi2 . number_format($row_cash_invoice_detail->unit_price,0,".",",") . "   " .
		$amountchar . number_format($row_cash_invoice_detail->amount,0,".",",") . "\n";
	}
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


//set jumlah sub total
$len_subtotal = strlen(number_format($totalamount + $totaldiscount,0,".",","));
$i=1;
for($i=1; $i<=$max_char-($len_subtotal+15); $i++) {
	$subtotalchar = $subtotalchar . " ";
}
$Data.= "JUMLAH TOTAL : " . $subtotalchar . number_format($totalamount + $totaldiscount - $discount2,0,".",",") . "\n";
$discount_percent = ($totaldiscount/($totalamount + $totaldiscount - $discount2))*100;
$len_disc_percent = strlen(number_format($discount_percent,0,".",","))+4;

//set jumlah total discount
$len_totaldiscount = strlen(number_format($totaldiscount,0,".",","));
$i=1;
//for($i=1; $i<=$max_char-($len_totaldiscount+$len_disc_percent+14); $i++) {
for($i=1; $i<=$max_char-($len_totaldiscount+14); $i++) {
	$totaldiscountchar = $totaldiscountchar . " ";
}

$discount_percent = number_format($discount_percent,0,".",",");
if($totaldiscount > 0) { 
	$Data.= "TOTAL DISC. : " . $totaldiscountchar . number_format($totaldiscount,0,".",",") . "\n";
	//$Data.= "TOTAL DISC. : " . '   ' . $discount_percent.'%' . $totaldiscountchar . number_format($totaldiscount,0,".",",") . "\n";
}

//set jumlah total
$len_totalamount = strlen(number_format($totalamount,0,".",","));
$i=1;
for($i=1; $i<=$max_char-($len_totalamount+12); $i++) {
	$totalamountchar = $totalamountchar . " ";
}
$Data.= "T O T A L : " . $totalamountchar . number_format($totalamount - $discount2,0,".",",") . "\n";
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

if($debit > 0) {
	//set voucher
	$len_voucher = strlen(number_format($debit,0,".",","));
	$i=1;
	for($i=1; $i<=$max_char-($len_voucher+12); $i++) {
		$cashchar2 = $cashchar2 . " ";
	}
	$Data.= "D E B I T : " . $cashchar2 . number_format($debit,0,".",",") . "\n";
}
if($ovo > 0) {
	//set voucher
	$len_voucher = strlen(number_format($ovo,0,".",","));
	$i=1;
	for($i=1; $i<=$max_char-($len_voucher+8); $i++) {
		$cashchar2 = $cashchar2 . " ";
	}
	$Data.= "O V O : " . $cashchar2 . number_format($ovo,0,".",",") . "\n";
}
if($gopay > 0) {
	//set voucher
	$len_voucher = strlen(number_format($gopay,0,".",","));
	$i=1;
	for($i=1; $i<=$max_char-($len_voucher+12); $i++) {
		$cashchar2 = $cashchar2 . " ";
	}
	$Data.= "G O P A Y : " . $cashchar2 . number_format($gopay,0,".",",") . "\n";
}
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
$change_amount = $totalamount - $cash_voucher - $gopay - $ovo - $debit - $cash_amount;
if($change_amount < 0) {
	$change_amount = $change_amount * -1;
}
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
$Data.= "           Layanan Konsumen" . " \n";
$Data.= "          WA : 0811.6028.474" . " \n";
$Data.= "      Call & WA : 0822.7722.1976" . "\n";
$Data.= "\n";
$Data.= "\n";
$Data.= "\n";
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

?>