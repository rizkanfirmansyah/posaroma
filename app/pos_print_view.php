<?php
@session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

//include_once ("include/queryfunctions.php");
include_once ("include/sambung.php");
include_once ("include/functions.php");
//include_once ("include/inword.php");

include 'class/class.selectview.php';
include 'class/class.select.php';
$selectview = new selectview;
$select = new select;

$petugas		=	$_SESSION["loginname"];
$ref			= 	$_REQUEST['ref'];
$from_date		=   $_REQUEST['from_date'];
$to_date		=   $_REQUEST['to_date'];
$shift	   		=   $_REQUEST['shift'];
$cashier		=	$_REQUEST['uid'];
$void			=	$_REQUEST['void_'];

$all			=   0;
$receipt_type_pos		=	 $_REQUEST['receipt_type_pos'];

$sql = $selectview->list_pos($kode, $all, $from_date, $to_date, $shift, $cashier, $receipt_type_pos, $void);
$row_pos=$sql->fetch(PDO::FETCH_OBJ);

$date			=	date("d-m-Y", strtotime($row_pos->date));
$date_header = '';
if($from_date == $to_date) {
	$date_header = date('d-m-Y', strtotime($from_date));
} else {
	$date_header = date('d-m-Y', strtotime($from_date)).' s/d '.date('d-m-Y', strtotime($to_date));
}

$total 			= 	$row_pos->total;
$tax_rate		=	$row_pos->tax_rate;
//$deposit 		= 	$row_pos->deposit;
$grand_total 	= 	$total; //$total - $deposit;
//$void			=	$row_pos->void;

$discount2 = 0;
while($row_pos2=$sql->fetch(PDO::FETCH_OBJ)) {
	
	if($row_pos2->void == 0) {
		$discount2	=	$discount2 + $row_pos2->discount;	
	}
		
}


/*-----------terbilang---------------*/
function get_num_name($num){  
    switch($num){  
        case 1:return 'satu';  
        case 2:return 'dua';  
        case 3:return 'tiga';  
        case 4:return 'empat';  
        case 5:return 'lima';  
        case 6:return 'enam';  
        case 7:return 'tujuh';  
        case 8:return 'delapan';  
        case 9:return 'sembilan';  
    }  
}  

function num_to_words($number, $real_name, $decimal_digit, $decimal_name){  
    $res = '';  
    $real = 0;  
    $decimal = 0;  

    if($number == 0)  
        return 'Nol'.(($real_name == '')?'':' '.$real_name);  
    if($number >= 0){  
        $real = floor($number);  
        $decimal = round($number - $real, $decimal_digit);  
    }else{  
        $real = ceil($number) * (-1);  
        $number = abs($number);  
        $decimal = $number - $real;  
    }  
    $decimal = (int)str_replace('.','',$decimal);  

    $unit_name[1] = 'ribu';  
    $unit_name[2] = 'juta';  
    $unit_name[3] = 'milliar';  
    $unit_name[4] = 'trilliun';  

    $packet = array();  

    $number = strrev($real);  
    $packet = str_split($number,3);  

    for($i=0;$i<count($packet);$i++){  
        $tmp = strrev($packet[$i]);  
        $unit = $unit_name[$i];  
        if((int)$tmp == 0)  
            continue;  
        $tmp_res = '';  
        if(strlen($tmp) >= 2){  
            $tmp_proc = substr($tmp,-2);  
            switch($tmp_proc){  
                case '10':  
                    $tmp_res = 'sepuluh';  
                    break;  
                case '11':  
                    $tmp_res = 'sebelas';  
                    break;  
                case '12':  
                    $tmp_res = 'dua belas';  
                    break;  
                case '13':  
                    $tmp_res = 'tiga belas';  
                    break;  
                case '15':  
                    $tmp_res = 'lima belas';  
                    break;  
                case '20':  
                    $tmp_res = 'dua puluh';  
                    break;  
                case '30':  
                    $tmp_res = 'tiga puluh';  
                    break;  
                case '40':  
                    $tmp_res = 'empat puluh';  
                    break;  
                case '50':  
                    $tmp_res = 'lima puluh';  
                    break;  
                case '70':  
                    $tmp_res = 'tujuh puluh';  
                    break;  
                case '80':  
                    $tmp_res = 'delapan puluh';  
                    break;  
                default:  
                    $tmp_begin = substr($tmp_proc,0,1);  
                    $tmp_end = substr($tmp_proc,1,1);  

                    if($tmp_begin == '1')  
                        $tmp_res = get_num_name($tmp_end).' belas';  
                    elseif($tmp_begin == '0')  
                        $tmp_res = get_num_name($tmp_end);  
                    elseif($tmp_end == '0')  
                        $tmp_res = get_num_name($tmp_begin).' puluh';  
                    else{  
                        if($tmp_begin == '2')  
                            $tmp_res = 'dua puluh';  
                        elseif($tmp_begin == '3')  
                            $tmp_res = 'tiga puluh';  
                        elseif($tmp_begin == '4')  
                            $tmp_res = 'empat puluh';  
                        elseif($tmp_begin == '5')  
                            $tmp_res = 'lima puluh';  
                        elseif($tmp_begin == '6')  
                            $tmp_res = 'enam puluh';  
                        elseif($tmp_begin == '7')  
                            $tmp_res = 'tujuh puluh';  
                        elseif($tmp_begin == '8')  
                            $tmp_res = 'delapan puluh';  
                        elseif($tmp_begin == '9')  
                            $tmp_res = 'sembilan puluh';  

                        $tmp_res = $tmp_res.' '.get_num_name($tmp_end);  
                    }  
                    break;  
            }  

            if(strlen($tmp) == 3){  
                $tmp_begin = substr($tmp,0,1);  
                $space = '';  
                if(substr($tmp_res,0,1) != ' ' && $tmp_res != '')  
                    $space = ' ';  
                if($tmp_begin != 0){  
                    if($tmp_begin == 1)  
                        $tmp_res = 'seratus'.$space.$tmp_res;  
                    else  
                        $tmp_res = get_num_name($tmp_begin).' ratus'.$space.$tmp_res;  
                }  
            }  
        }else  
            $tmp_res = get_num_name($tmp);  

        $space = '';  
        if(substr($res,0,1) != ' ' && $res != '')  
            $space = ' ';  

        if($tmp_res == 'satu' && $unit == 'ribu')  
            $res = 'se'.$unit.$space.$res;  
        else  
            $res = $tmp_res.' '.$unit.$space.$res;  
    }  

    $space = '';  
    if(substr($res,-1) != ' ' && $res != '')  
        $space = ' ';  
    $res .= $space.$real_name;  

    if($decimal > 0)  
        $res .= ' '.num_to_words($decimal, '', 0, '').' '.$decimal_name;  
    return ucfirst($res);  
}  
/*------------------------------------------*/

/*---------print header-----------*/
$sqlunit = $selectview->list_warehouse($_SESSION["location"]);
$dataunit = $sqlunit->fetch(PDO::FETCH_OBJ);

$address = "-";
if(!empty($dataunit->address)) {
	$address = $dataunit->address;	
}

$email = "-";
if(!empty($dataunit->email)) {
	$email = $dataunit->email;
}

$phone = "-";
if(!empty($dataunit->phone)) {
	$phone = $dataunit->phone;
}
/*-------------------------------*/

/*---------print detail----------*/
$total_qty  =   0;
$total_qty_void  =   0;
$total_discount = $discount2;
$total_qty_discount = 0;
$data		=	array();
$i 			= 	1;		
$size		= 	500;
$sizeadd 	= 	20;

$total		=  	0;
$total2		=	0;
$discount_hd=	0;
$sql2 = $selectview->list_pos_detail($from_date, $to_date, $shift, $cashier, $receipt_type_pos, $void);
while($row_pos_detail=$sql2->fetch(PDO::FETCH_OBJ)) {

	$sub_total = $sub_total + $row_pos_detail->amount;
	$unit_price = $row_pos_detail->unit_price;
	
	if($row_pos_detail->void == 1) {
		$amount = 0;
		$discount = 0;
		$discount3 = 0;
	} else {
		$amount = $row_pos_detail->amount;
		$discount = $row_pos_detail->discount;
		$discount3 = $row_pos_detail->discount3;
		$total2 = $total2 + ($row_pos_detail->unit_price * $row_pos_detail->qty); //-($row_pos_detail->discount * $row_pos_detail->qty); //$row_pos_detail->amount;	
		//$total2 = $total2 + $row_pos_detail->amount;
		$discount_hd = $discount_hd + $row_pos_detail->discount_hd;
	}
	
	
	$item_code	=	$row_pos_detail->old_code;
	$qty		=	number_format($row_pos_detail->qty,"0",".",",");
	$uom_code	=	$row_pos_detail->uom_code;
	$item_name	=	$row_pos_detail->item_name;
	$unit_price	=	number_format($unit_price,"0",".",",");
	$discount	=	number_format($discount,"0",".",",");
	$discount3	=	number_format($discount3,"0",".",",");
	$amount		=	number_format($amount,"0",".",",");
	 
	$data[]=$i.'.'.';'.$item_code.';'.$item_name.';'.$uom_code.';'.$qty.';'.$amount;
	//$data[]=$i.'.'.';'.$item_code.';'.$item_name.';'.$uom_code.';'.$qty.';'.$unit_price.';'.$discount3.';'.$discount.';'.$amount;
	
	if($row_pos_detail->void == 0) {
		$total_qty = $total_qty + $row_pos_detail->qty;
		$total_discount = $total_discount + numberreplace($discount);
		$total_qty_discount = $total_qty_discount + $row_pos_detail->qty_discount;
	} else {
		$total_qty_void = $total_qty_void + $row_pos_detail->qty;
	}
	
	$i++;	
	$size = $size + $sizeadd;

}

//get jumlah nota
$sqlinv=$select->list_pos_valid('', '', $from_date, $to_date, $shift, $cashier, $receipt_type_pos, $void);
$rows_inv = $sqlinv->rowCount();
$count_invoice = $rows_inv;

$total_tax		=	($sub_total * $tax_rate)/100;
 
if($total2 > 0) {
	$total = $total2 + $total_tax;
	$grand_total = $total - $deposit;
}
$terbilang		=	num_to_words($total, 'rupiah', 0, '');
/*-------------------------------------------*/
				



require('pdf/fpdf2.php');
	  	
class PDF extends FPDF
{
	
	var $col=0;
	//Ordinate of column start
	var $y0;
	
	function Header()
	{
		//Page header
		global $address;
		global $phone;
		global $email;
		
		global $ref;
		global $date_header;
		global $shift;
		global $date;
		global $cashier;
				
		$this->SetFont('Arial','',9);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		
		$this->Cell(1,3,'',0,0,'L',false);
		$this->Cell(50,3,'AROMA BAKERY & CAKE',0,1,'L',false);
		//$this->Image('../assets/img/logo.jpg', 10, 5, 25, 20, 'jpg', '');
		$this->Ln(1);
		
		/*$this->Cell(1,3,'',0,0,'L',false);
		$this->Cell(20,3,'GROSIR & ECERAN',0,1,'L',false);
		$this->Ln(1);*/
		
		$this->Cell(1,3,'',0,0,'L',false);
		$this->Cell(50,3,'Alamat Kantor : ' . $address . ' Telp./Fax.: ' . $phone,0,1,'L',false);
		$this->Ln(2);
		
		/*$this->Cell(26,3,'',0,0,'L',false);
		$this->Cell(20,3,$email,0,1,'L',false);
		$this->Ln(2);*/
		
		$this->SetFont('Arial','',9);
		$this->Cell(226,5,'PENJUALAN',0,1,'L',true);
		$this->Ln(2);
		
		$this->Cell(34,2,'Kasir',0,0,'L',true);
		$this->Cell(2,2,':',0,0,'L',false);
		$this->Cell(50,2,$cashier,0,1,'L',true);
		$this->Ln(2);
		
		$this->Cell(34,2,'Shift',0,0,'L',true);
		$this->Cell(2,2,':',0,0,'L',false);
		$this->Cell(50,2,$shift,0,1,'L',true);
		$this->Ln(2);
		
		$this->Cell(34,2,'Tanggal',0,0,'L',true);
		$this->Cell(2,2,':',0,0,'L',false);
		$this->Cell(50,2,$date_header,0,1,'L',true);
		$this->Ln(2);
				
		//Save ordinate
		$this->y0=$this->GetY();
	}
	
	

	var $B;
	var $I;
	var $U;
	var $HREF;
	
	
	function PDF($orientation='P',$unit='mm', $format='a4') 
	{
		//Call parent constructor
		//$size = 300;
		global $size;
		global $sizeadd;
		
		$this->FPDF2($orientation,$unit,$format,$size); //$size = tinggi
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
		$i=0;				
		foreach($header as $col) {
			if ($i==0) { $this->Cell(10,7,$col,1,0,"C"); }
			if ($i==1) { $this->Cell(29,7,$col,1,0,"C"); }
			if ($i==2) { $this->Cell(120,7,$col,1,0,"C"); }
			if ($i==3) { $this->Cell(8,7,$col,1,0,"C"); }
			if ($i==4) { $this->Cell(10,7,$col,1,0,"C"); }
			/*if ($i==5) { $this->Cell(18,7,$col,1,0,"C"); }
			if ($i==6) { $this->Cell(18,7,$col,1,0,"C"); }
			if ($i==7) { $this->Cell(18,7,$col,1,0,"C"); }*/
			if ($i==5) { $this->Cell(18,7,$col,1,0,"C"); }
			$i++;
		}
		$this->Ln();
		
		
		//Data		
		foreach($data as $row)
		{	
			$i=0;
			foreach($row as $col) {
				
				if ($i==0) { $this->Cell(10,6,$col,1,0,"C"); }
				if ($i==1) { $this->Cell(29,6,$col,1,0,"L"); }
				if ($i==2) { $this->Cell(120,6,$col,1,0,"L"); }
				if ($i==3) { $this->Cell(8,6,$col,1,0,"C"); }
				if ($i==4) { $this->Cell(10,6,$col,1,0,"R"); }
				/*if ($i==5) { $this->Cell(18,6,$col,1,0,"R"); }
				if ($i==6) { $this->Cell(18,6,$col,1,0,"R"); }
				if ($i==7) { $this->Cell(18,6,$col,1,0,"R"); }*/
				if ($i==5) { $this->Cell(18,6,$col,1,0,"R"); }
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
		global $count_invoice;		
		global $total_discount;
		global $total_qty_discount;
		global $total_qty;
		global $total_qty_void;
		global $discount2;
		global $petugas;
		
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		$this->SetFont('Arial','',9);
		
		//$size = $size + $sizeadd;
		$sub_total		=	number_format($sub_total,"0",".",",");
		$total_tax		=	number_format($total_tax,"0",".",",");
		$total			=	number_format($total,"0",".",",");
		$total_qty		=	number_format($total_qty,"0",".",",");
		$deposit		=	number_format($deposit,"0",".",",");
		$grand_total	=	number_format(numberreplace($total)-numberreplace($total_discount),"0",".",",");
		$count_invoice	=	number_format($count_invoice,"0",".",",");
		$total_discount	=	number_format($total_discount,"0",".",",");
		$total_qty_discount	=	number_format($total_qty_discount,"0",".",",");
		
		$this->SetFont('Arial','B',9);
		//$this->Cell(226,5,'',0,0,'L',false); //Terbilang :
		/*$this->SetFont('Arial','',12);
		$this->Cell(25,5,'Sub Total',0,0,'R',false);
		$this->Cell(25,5,$sub_total,0,1,'R',false);
		$this->SetFont('Arial','',12);*/
		
		$this->Ln(3);
		$this->Cell(20,5,'',0,0,'L',true);	
		$this->Cell(114,5,'Total Customer Buying : ' . $count_invoice,0,0,'L',false);
		
		$this->Cell(25,5,'Sub Total',0,0,'R',false);
		$this->Cell(18,5,$total_qty,0,0,'R',false);
		$this->Cell(18,5,$total,0,1,'R',false);
		
		$this->Cell(134,5,'',0,0,'L',true);	
		$this->Cell(25,5,'Qty Batal',0,0,'R',false);
		$this->Cell(18,5,$total_qty_void,0,0,'R',false);
		$this->Cell(18,5,'',0,1,'R',false);
		
		
		$this->Cell(134,5,'',0,0,'L',true);
		$this->Cell(25,5,'Total Discount',0,0,'R',false);
		$this->Cell(18,5,'',0,0,'R',false);
		$this->Cell(18,5,$total_discount,0,1,'R',false);
		
		$this->Cell(134,5,'',0,0,'L',true);
		$this->Cell(25,5,'Grand Total',0,0,'R',false);
		$this->Cell(18,5,'',0,0,'R',false);
		$this->Cell(18,5,$grand_total,0,1,'R',false);
		
		/*$this->Cell(134,5,'',0,0,'L',true);
		$this->Cell(25,5,'Total Min. Qty Discount',0,0,'R',false);
		$this->Cell(18,5,'',0,0,'R',false);
		$this->Cell(18,5,$total_qty_discount,0,1,'R',false);*/
		
		
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
		$this->SetFont('Arial','',10);
		$this->Cell(95,5,'Supervisor',0,0,'C',true);
		$this->Cell(130,5,'Kasir',0,1,'C',true);	
		$this->Ln(10);
		
		$size = $size + $sizeadd;
		
		$this->Cell(95,5,'(___________________)',0,0,'C',true);	
		$this->Cell(130,5,'( ' . $petugas . ' )',0,1,'C',true);	
		$this->Ln(2);
		
				
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

/*$G_LOKASI = "Bandung";
$uid = $petugas; //$_SESSION["loginname"];
$tanggalcetak = $G_LOKASI . ", " . $tglcetak;
$getuser = "(". $uid . ")";
*/

$header=array('No.', 'Kode','Nama Barang','Sat','Qty','Total');
//$header=array('No.', 'Kode','Nama Barang','Sat','Qty','Harga','Disc(%)','Disc(Rp)','Total');
//Data loading
//$data=$pdf->LoadData('poa.txt');

$data=$pdf->LoadData($data);
//$data2=$pdf->LoadData($data2);
$pdf->SetFont('Arial','',9);
$pdf->AddPage();

//if($jmldata > 0) {
	$pdf->BasicTable($header,$data);
//} 

/*
if($jmldata1 > 0) {
	$pdf->BasicTable2($header2,$data2);
} */

/*$pdf->AddPage();
$pdf->ImprovedTable($header,$data);
$pdf->AddPage();
$pdf->FancyTable($header,$data);*/

$pdf->Output();

?>