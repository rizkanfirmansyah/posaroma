<?php
@session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

include_once ("include/queryfunctions.php");
include_once ("include/functions.php");
//include_once ("include/inword.php");

include 'class/class.selectview.php';
include 'class/class.select.php';

$selectview = new selectview;
$select = new select;

$item_code_id		= $_REQUEST['item_code4'];

$countitem 	= explode("|",$item_code_id);
$jmldata = count($countitem);	

$item_code = "";

if(empty($item_code_id)) {
	$item_code = "'ndf'";	
}


for ($i=0; $i<=$jmldata; $i++) {
	
	if(!empty($countitem[$i])) {
		if($item_code == "") {
			$item_code = "'".$countitem[$i]."'";		
		} else {
			$item_code = $item_code . ", " . "'".$countitem[$i]."'";
		}
	}
}

$sql = $selectview->list_item_cetak_label($item_code);
$rows = $sql->rowCount();


/*------------------------------------------*/


/*---------print detail----------*/
$data		=	array();
$i 			= 	0;		
$size		= 	500;
$sizeadd 	= 	20;


$string_item = array();
$string_barcode = array();
$sql = $selectview->list_item_cetak_label($item_code);			
while ($rpt_item_view=$sql->fetch(PDO::FETCH_OBJ)) {
	
	$sql2 = $selectview->list_price_last2($rpt_item_view->syscode, $rpt_item_view->uom_code_sales);
	$data_price = $sql2->fetch(PDO::FETCH_OBJ);
	
	$date = date("d-m-Y");
	
	$item_name		=	$rpt_item_view->name;
	
	//$item_label		=	"";
	/*$item_label		=	$rpt_item_view->name . "|" .
						$rpt_item_view->old_code . "|Rp. " . number_format($data_price->current_price,0,".",",") . "/" . number_format($data_price->qty1,0,".",",");*/
	
	
	
	/*if($i%3 <= 2) {
		$string_label = $item_label . "~" . $string_label;
	} 
	
	if($i%3 == 2) {
		$string_label2 = $string_label . "@" . $string_label2;
		$string_label = "";
	}*/
	
	$string_item[] = $rpt_item_view->name;
	$string_barcode[] = $rpt_item_view->old_code;
	
	$i++;
	
		 
	//$data[]=$item_label;
	
	
	//$data[]=$item_barcode.';'.$item_name.';'.$uom_code.';'.$qty.';'.$unit_cost.';'.$discount1.';'.$discount.';'.$amount;
	
}


//for($t=0; $t<=count($string_item); $t++) {
	
	$data[]=$string_item[0].';'.$string_item[1].';'.$string_item[2];
	$data[]=$string_item[3].';'.$string_item[4].';'.$string_item[5];
	//$data[]=$string_barcode[0].';'.$string_barcode[1].';'.$string_barcode[2];
//}


//$dataitem = array();
/*$dataitem = explode("@", $string_label2);

for($t=0; $t<=count($dataitem); $t++) {
	$datadetail = array();
	$datadetail = explode("~", $dataitem[$t]);
	
	$r=0;
	for($r=0; $r<=count($datadetail); $r++) {
		//echo $datadetail[$r]."<br>";
		if(!empty($datadetail[$r])) {
			$getdata = array();
			$getdata = explode("|", $datadetail[$r]);
			$data[]=$getdata[0];
		}
		
	}
	
}*/

/*$sql2 = $selectview->list_purchase_quick_detail($ref);
while($row_purchase_quick_detail=$sql2->fetch(PDO::FETCH_OBJ)) {

	$sub_total = $sub_total + $row_purchase_quick_detail->amount;
	$unit_cost = $row_purchase_quick_detail->unit_cost;
	$amount = $row_purchase_quick_detail->amount;
	$total2 = $total2 + $row_purchase_quick_detail->amount;
	
	$item_code	=	$row_purchase_quick_detail->code;
	$qty		=	number_format($row_purchase_quick_detail->qty,"2",",",".");
	$uom_code	=	$row_purchase_quick_detail->uom_code;
	$item_name	=	$row_purchase_quick_detail->item_name;
	$unit_cost	=	number_format($unit_cost,"2",",",".");
	$discount	=	number_format($row_purchase_quick_detail->discount,"2",",",".");
	$discount1	=	number_format($row_purchase_quick_detail->discount1,"2",",",".");
	$amount		=	number_format($amount,"2",",",".");
	 
	//$data[]=$qty.';'.$uom_code.';'.$item_name.';'.$unit_cost.';'.$amount;
	$data[]=$i.'.'.';'.$item_code.';'.$item_name.';'.$uom_code.';'.$qty.';'.$unit_cost.';'.$discount1.';'.$discount.';'.$amount;
	
	$i++;	
	$size = $size + $sizeadd;

}*/


/*$total_tax		=	($sub_total * $tax_rate)/100;
 
if($total2 > 0) {
	$total = $total2 + $total_tax;
	$grand_total = $total - $deposit;
}
$terbilang		=	num_to_words($total, 'rupiah', 0, '');*/
/*-------------------------------------------*/
				



require('pdf/fpdf2.php');
	  	
class PDF extends FPDF
{
	
	var $col=0;
	//Ordinate of column start
	var $y0;
	
	/*function Header()
	{
		//Page header
		global $address;
		global $phone;
		global $email;
		
		global $ref;
		global $vendor_name;
		global $address_vdr;
		global $date;
		global $phone_vdr;*/
				
		/*$this->SetFont('Arial','',9);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		
		$this->Cell(1,3,'',0,0,'L',false);
		$this->Cell(50,3,'SAHABAT PUTRA',0,1,'L',false);
		//$this->Image('../assets/img/logo.jpg', 10, 5, 25, 20, 'jpg', '');
		$this->Ln(1);
		
		$this->Cell(1,3,'',0,0,'L',false);
		$this->Cell(20,3,'GROSIR & ECERAN',0,1,'L',false);
		$this->Ln(1);
		
		$this->Cell(1,3,'',0,0,'L',false);
		$this->Cell(50,3,'Alamat Kantor : ' . $address . ' Telp./Fax.: ' . $phone,0,1,'L',false);
		$this->Ln(2);*/
		
		/*$this->Cell(26,3,'',0,0,'L',false);
		$this->Cell(20,3,$email,0,1,'L',false);
		$this->Ln(2);*/
		
		/*$this->SetFont('Arial','U',9);
		$this->Cell(226,5,'PURCHASE INVOICE',0,0,'L',true);
		$this->Cell(50,5,'No : ' . $ref,0,1,'R',false);
		$this->Ln(2);
		
		$this->SetFont('Arial','',9);
		$this->Cell(34,2,'Nama',0,0,'L',true);
		$this->Cell(2,2,':',0,0,'L',false);
		$this->Cell(208,2,$vendor_name,0,0,'L',false);
		$this->Cell(33,2,'Tanggal : ' . $date,0,1,'L',false);
		$this->Ln(2);
		
		$this->Cell(34,2,'Alamat',0,0,'L',true);
		$this->Cell(2,2,':',0,0,'L',false);
		$this->Cell(50,2,$address_vdr,0,1,'L',true);
		$this->Ln(2);
		
		$this->Cell(34,2,'No. Telepon',0,0,'L',true);
		$this->Cell(2,2,':',0,0,'L',false);
		$this->Cell(50,2,$phone_vdr,0,1,'L',true);
		$this->Ln(2);*/
		
		//Save ordinate
		/*$this->y0=$this->GetY();
	}*/
	
	

	var $B;
	var $I;
	var $U;
	var $HREF;
	
	
	function PDF($orientation='p',$unit='mm', $format='a4') 
	{
		//Call parent constructor
		//$size = 300;
		global $size;
		global $sizeadd;
		
		$this->FPDF($orientation,$unit,$format,$size); //$size = tinggi
		//Initialization
		$this->B=0;
		$this->I=0;
		$this->U=0;
		$this->HREF='';
		
	}

	//Load data
		
	function LoadData($file)
	{		
		//Read file lines
		//$lines=file($file);
		$lines=($file);
		$cekdata = $file[1];
		if( !empty($cekdata) )  {
			foreach($lines as $line) {
				$data[]=explode(';',$line);
			}
		} else {			
			$data[]=explode(';',$file[0]);
			
		}
			
		//foreach($lines as $data)
			//$data[]=explode(';',chop($line));
		return $data;
	} 
	
	
	function BasicTable($header,$data)
	{
		//Header
		/*$i=0;				
		foreach($header as $col) {
			if ($i==0) { $this->Cell(10,7,$col,1,0,"C"); }
			if ($i==1) { $this->Cell(20,7,$col,1,0,"C"); }
			if ($i==2) { $this->Cell(117,7,$col,1,0,"C"); }
			if ($i==3) { $this->Cell(12,7,$col,1,0,"C"); }
			if ($i==4) { $this->Cell(17,7,$col,1,0,"C"); }
			if ($i==5) { $this->Cell(25,7,$col,1,0,"C"); }
			if ($i==6) { $this->Cell(25,7,$col,1,0,"C"); }
			if ($i==7) { $this->Cell(25,7,$col,1,0,"C"); }
			if ($i==8) { $this->Cell(25,7,$col,1,0,"C"); }
			$i++;
		}
		$this->Ln();*/
		
		
		//Data		
		foreach($data as $row)
		{	
			$i=0;
			foreach($row as $col) {
				
				if ($i==0) { 
					$this->Cell(65,7,$col,1,1,"L"); 
					$this->Cell(65,7,$col,1,0,"L");
					$this->Write(65, $col, '');
					//$this->MultiCell(65, 37, $col, 1, "L", false);
				}
				if ($i==1) { $this->Cell(65,37,$col,1,0,"L"); }
				if ($i==2) { $this->Cell(65,37,$col,1,0,"L"); }
				/*if ($i==3) { $this->Cell(12,6,$col,1,0,"C"); }
				if ($i==4) { $this->Cell(17,6,$col,1,0,"R"); }
				if ($i==5) { $this->Cell(25,6,$col,1,0,"R"); }
				if ($i==6) { $this->Cell(25,6,$col,1,0,"R"); }
				if ($i==7) { $this->Cell(25,6,$col,1,0,"R"); }
				if ($i==8) { $this->Cell(25,6,$col,1,0,"R"); }*/
				$i++;
			}
			$this->Ln();
			
		}	
		
		//-----set sub group
		global $terbilang;
		global $sub_total;
		global $freight_cost;
		global $total_tax;
		global $total;
		global $grand_total;
				
		global $vendor_name;
		global $petugas;
		
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',9);
		
		//$size = $size + $sizeadd;
		$sub_total		=	number_format($sub_total,"0",",",".");
		$total_tax		=	number_format($total_tax,"0",",",".");
		$total			=	number_format($total,"0",",",".");
		$deposit		=	number_format($deposit,"0",",",".");
		$grand_total	=	number_format($grand_total,"0",",",".");
		
		/*$this->SetFont('Arial','',12);
		$this->Cell(226,5,'',0,0,'L',false); //Terbilang :
		$this->SetFont('Arial','',12);
		$this->Cell(25,5,'Sub Total',0,0,'R',false);
		$this->Cell(25,5,$sub_total,0,1,'R',false);
		$this->SetFont('Arial','',12);
		$this->Cell(226,5,'',0,0,'L',true);	//$terbilang
		$this->SetFont('Arial','',12);
		$this->Cell(25,5,'PPN',0,0,'R',false);
		$this->Cell(25,5,$total_tax,0,1,'R',false);	
		
		$this->Cell(226,5,'',0,0,'L',true);	
		$this->Cell(25,5,'Total',0,0,'R',false);
		$this->Cell(25,5,$total,0,1,'R',false);*/
		
		/*$this->Cell(144,5,'',0,0,'L',true);	
		$this->Cell(25,5,'Uang Muka',0,0,'R',false);
		$this->Cell(25,5,$deposit,0,1,'R',false);
		
		$this->Cell(144,5,'',0,0,'L',true);	
		$this->Cell(25,5,'Sisa',0,0,'R',false);
		$this->Cell(25,5,$grand_total,0,1,'R',false);		
		$this->Ln(5);
		*/
		
		$size = $size + $sizeadd;
		
		
		//-----------
		/*$this->SetFont('Arial','',9);
		$this->Cell(200,2,'- Barang yang sudah dibeli tidak boleh ditukar / dikembalikan, biaya retur 30% dari harga produk',0,1,'L',false);		
		$this->Ln(2);
		
		$size = $size + $sizeadd;
		
		$this->SetFont('Arial','',9);
		$this->Cell(200,2,'- Pembayaran dianggap lunas apabila cek sudah cair / transfer telah kami terima.',0,1,'L',false);		
		$this->Ln(2); */
		
		$this->Ln(2);
		
		$size = $size + $sizeadd;
		
		//---------
		/*$this->SetFont('Arial','',10);
		$this->Cell(95,5,'Supplier',0,0,'C',true);
		$this->Cell(210,5,'Petugas',0,1,'C',true);	
		$this->Ln(10);
		
		$size = $size + $sizeadd;
		
		$this->Cell(95,5,'( ' . $vendor_name . ' )',0,0,'C',true);	
		$this->Cell(210,5,'( ' . $petugas . ' )',0,1,'C',true);	
		$this->Ln(2);*/
		
				
	} 
	
	
		
}
//===========================				
$pdf=new PDF();

$title='PURCHASE INVOICE';
$pdf->SetTitle($title);	
$pdf->SetTitle($nis);	
$pdf->SetTitle($nama);


//$terbilang = "(" . KalimatUang($total) . ")";
//$pdf->SetTitle($terbilang);

//$total = number_format($total,"0",".",",");
//$total2 = number_format($total2,"0",".",",");
//$pdf->SetTitle($total);
$pdf->SetTitle($size);


$header=array('No.', 'Kode','Nama Barang','Satuan','Qty','Harga','Discount(%)','Discount(Rp)','Total');
//$header2=array('No.','Jenis Biaya','Besarnya');
//Data loading
//$data=$pdf->LoadData('poa.txt');

$data=$pdf->LoadData($data);
//$data2=$pdf->LoadData($data2);
$pdf->SetFont('Arial','',9);
$pdf->AddPage();

//if($jmldata > 0) {
	$pdf->BasicTable($header,$data);
//} 


$pdf->Output();

?>