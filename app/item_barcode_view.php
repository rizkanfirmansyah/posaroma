<?php
	require('../pdf_barcode/fpdf.php');
	
	/*mysql_connect("localhost","root","12345");
	mysql_select_db("pdf");
	 
	$sql=mysql_query("select * from ktp where id='2'");
	$data=mysql_fetch_array($sql);
	*/
	
	include_once ("include/sambung.php");
	
	$dbpdo = DB::create();
	
	$item_code = $_REQUEST['item_code_all'];
	
	$nama = array();
	$itemcodearr = array();
	$itemnamearr = array();
	
	$itemcode = "";
	$itemname = "";
	$sqlitm	  = "";
	
	$nama = explode("/",$item_code);
		
	for($j=0; $j<count($nama); $j++) {
		$sqlitm = "select code, name from item where syscode='$nama[$j]'";
		$sql1=$dbpdo->prepare($sqlitm);
		$sql1->execute();
		$data = $sql1->fetch(PDO::FETCH_OBJ);
		
		if($itemcode == "") {
			$itemcode = $data->code;
		} else {
			$itemcode = $itemcode . "/" . $data->code;
		}
		
		if($itemname == "") {
			$itemname = substr($data->name,0,15);
		} else {
			$itemname = $itemname . "/" . substr($data->name,0,15);
		}
		
	}
	
	
	$itemcodearr = explode("/",$itemcode);
	$itemnamearr = explode("/",$itemname);
	 
	//$nama=$item_code; //$data[nama]";
	$gambar="sensus.jpg"; //$data['foto'];
	 
	//define('FPDF_FONTPATH', 'fpdf/font/');
	require('../barcode/Code39.php');
	 
	$tgl = date('D,d-F-Y');
	 
	include('../barcode/PDF_Code39.php');
	
	$pdf = new PDF_Code39();
	 
	$pdf->Open();
	$pdf->addPage('L');
	 
	$pdf->setFont('arial','',20);
	 
	//$pdf->Image('foto/' . $gambar,10,10,80);
	
	/*$data = array();
	
	$y = 15;
	$wlan = 40;
	for($i=0; $i<=2; $i++) {
		
		if($i%5 == 0) {
			$pdf->Code39(5, $y, $nama, 1.2, 15, 'AHMAD NADHIF', 40, 5, 54, 0, 0, 'R', false); 
			
			//$pdf->Code39(70, $y, '111111', 1.2, 15, 'AHMAD NADHIF', 100, 5, -45, 0, 1, 'R', false);
		} else {
			$pdf->Code39(5, $y, $nama, 1.2, 15, 'AHMAD NADHIF', 40, 5, 25, 0, 0, 'R', false); 
			
			//$pdf->Code39(70, $y, '111111', 1.2, 15, 'AHMAD NADHIF', 100, 5, 25, 0, 1, 'R', false);
		}
		
		$y = $y + 30;
		
		//$data[]=$nama.';'.'AHMAD'.';'.'NADHIF';
		
		//$data[]=$qty.';'.$uom_code.';'.$item_name.';'.$unit_price.';'.$discount.';'.$amount;
		
	} */
 	
	
	//$pdf2=new PDF();
	
	//BasicTable($header,$data);
	
	if( !empty($itemcodearr[0]) ) { $pdf->Code39(10, 30, $itemcodearr[0], 1.2, 15, $itemnamearr[0], 64, 5, 40, 0, 0, 'C', false); }
	
	if( !empty($itemcodearr[1]) ) { $pdf->Code39(10, 60, $itemcodearr[1], 1.2, 15, $itemnamearr[1], 64, 5, 25, 0, 1, 'C', false); }
	
	if( !empty($itemcodearr[2]) ) { $pdf->Code39(10, 90, $itemcodearr[2], 1.2, 15, $itemnamearr[2], 64, 5, 25, 0, 1, 'C', false); }
	
	if( !empty($itemcodearr[3]) ) { $pdf->Code39(10, 120, $itemcodearr[3], 1.2, 15, $itemnamearr[3], 64, 5, 25, 0, 1, 'C', false); }
	
	
	//----------disampingnya
	if( !empty($itemcodearr[4]) ) { $pdf->Code39(70, 30, $itemcodearr[4], 1.2, 15, $itemnamearr[4], 100, 5, -95, 0, 1, 'R', false); }
	
	if( !empty($itemcodearr[5]) ) { $pdf->Code39(70, 60, $itemcodearr[5], 1.2, 15, $itemnamearr[5], 100, 5, 25, 0, 1, 'R', false); }
	
	if( !empty($itemcodearr[6]) ) { $pdf->Code39(70, 90, $itemcodearr[6], 1.2, 15, $itemnamearr[6], 100, 5, 25, 0, 1, 'R', false); }
	
	if( !empty($itemcodearr[7]) ) { $pdf->Code39(70, 120, $itemcodearr[7], 1.2, 15, $itemnamearr[7], 100, 5, 25, 0, 1, 'R', false); }
	
	
	//----------disampingnya
	if( !empty($itemcodearr[8]) ) { $pdf->Code39(130, 30, $itemcodearr[8], 1.2, 15, $itemnamearr[8], 160, 5, -95, 0, 1, 'R', false); }
	
	if( !empty($itemcodearr[9]) ) { $pdf->Code39(130, 60, $itemcodearr[9], 1.2, 15, $itemnamearr[9], 160, 5, 25, 0, 1, 'R', false); }
	
	if( !empty($itemcodearr[10]) ) { $pdf->Code39(130, 90, $itemcodearr[10], 1.2, 15, $itemnamearr[10], 160, 5, 25, 0, 1, 'R', false); }
	
	if( !empty($itemcodearr[11]) ) { $pdf->Code39(130, 120, $itemcodearr[11], 1.2, 15, $itemnamearr[11], 160, 5, 25, 0, 1, 'R', false); }
	
	
	//----------disampingnya
	if( !empty($itemcodearr[12]) ) { $pdf->Code39(200, 30, $itemcodearr[12], 1.2, 15, $itemnamearr[12], 220, 5, -95, 0, 1, 'R', false); }
	
	if( !empty($itemcodearr[13]) ) { $pdf->Code39(200, 60, $itemcodearr[13], 1.2, 15, $itemnamearr[13], 220, 5, 25, 0, 1, 'R', false); }
	
	if( !empty($itemcodearr[14]) ) { $pdf->Code39(200, 90, $itemcodearr[14], 1.2, 15, $itemnamearr[14], 220, 5, 25, 0, 1, 'R', false); }
	
	if( !empty($itemcodearr[15]) ) { $pdf->Code39(200, 120, $itemcodearr[15], 1.2, 15, $itemnamearr[15], 220, 5, 25, 0, 1, 'R', false); }
	
	
	 
	//$pdf->Code39(100, 30, 'Test');
	 
	$pdf->Output();
 
?>