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

include 'class/class.select.php';
include 'class/class.selectview.php';
$select = new select;
$selectview = new selectview;

$petugas		=	$_SESSION["loginname"];
$ref			= 	$_REQUEST['ref'];

$sql = $selectview->list_cash_invoice_box($ref);
$row_cash_invoice=$sql->fetch(PDO::FETCH_OBJ);

$ref			=	$row_cash_invoice->ref;
$ref2			=	$row_cash_invoice->ref2;
$client_name	=	$row_cash_invoice->client_name;
$ship_to		=	$row_cash_invoice->address_cust; //ship_to;
$bill_to		=	$row_cash_invoice->bill_to;
$phone_cust		=	$row_cash_invoice->phone;
$date			=	date("d-m-Y", strtotime($row_cash_invoice->date));
$due_date		=	date("d-m-Y", strtotime($row_cash_invoice->due_date));

$freight_cost 	= 	$row_cash_invoice->freight_cost;
$discount2	 	= 	$row_cash_invoice->discount;
$total 			= 	$row_cash_invoice->total;
$deposit 		= 	$row_cash_invoice->deposit;
$cash_amount    =   $row_cash_invoice->cash_amount;
$change_amount  =   $row_cash_invoice->change_amount;
$grand_total 	= 	$total; //$total - $deposit;

$bank_amount	=	$row_cash_invoice->bank_amount;
$ovo			=	$row_cash_invoice->ovo;
$gopay			=	$row_cash_invoice->gopay;
$cash_voucher	=	$row_cash_invoice->cash_voucher;

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

$address = "Jl. SM. Raja Medan";
if(!empty($dataunit->address)) {
	$address = $dataunit->address;	
}

$email = "info@yahoo.com";
if(!empty($dataunit->email)) {
	$email = $dataunit->email;
}

$phone = "022-7216940";
if(!empty($dataunit->phone)) {
	$phone = $dataunit->phone;
}

$name_company = "AROMA & BAKERY SHOP";
if(!empty($dataunit->name)) {
	$name_company = $dataunit->name;
}

$businiss_type = "CAKE & BAKERY SHOP";
if(!empty($dataunit->businiss_type)) {
	$businiss_type = $dataunit->businiss_type;
}
/*-------------------------------*/

/*---------print detail----------*/
$data		=	array();
$i 			= 	1;		
$size		= 	500;
$sizeadd 	= 	20;

$sql2 = $selectview->list_cash_invoice_box_detail($ref);
while($row_cash_invoice_detail=$sql2->fetch(PDO::FETCH_OBJ)) {
	
	if($row_cash_invoice_detail->dummy == 1) {
		$sub_total = $sub_total + $row_cash_invoice_detail->amount2;	
		$unit_price = $row_cash_invoice_detail->unit_price2;
		$amount = $row_cash_invoice_detail->amount2;
		$total2 = $total2 + $row_cash_invoice_detail->amount2;
	} else {
		$sub_total = $sub_total + $row_cash_invoice_detail->amount;
		$unit_price = $row_cash_invoice_detail->unit_price;
		$amount = $row_cash_invoice_detail->amount;
		$total2 = $total2 + $row_cash_invoice_detail->amount;
	}
	
	$qty		=	number_format($row_cash_invoice_detail->qty,"2",",",".");
	$explodeqty = 	explode(",", $qty);
	if ($explodeqty[1] == 0) {
		$qty		=	number_format($row_cash_invoice_detail->qty,"0",".",",");
	}
	
	$uom_code	=	$row_cash_invoice_detail->uom_code;
	$item_name	=	$row_cash_invoice_detail->item_name;
	$unit_price	=	number_format($unit_price,"0",".",",");
	$discount	=	number_format($row_cash_invoice_detail->discount,"0",".",",");
	$amount		=	number_format($amount,"0",".",",");
	 
	$data[]=($i).';'.$item_name.';'.$uom_code.';'.$qty.';'.$unit_price.';'.$discount.';'.$amount;
	
	$i++;	
	$size = $size + $sizeadd;
    
    $posisigaris_total = $posisigaris_total + $posisigaris; 

}

if($total2 > 0) {
	$total = $total2 - $discount2;
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
        global $name_company;
        global $businiss_type;
		
		global $ref;
		global $ref2;
		global $client_name;
		global $ship_to;
		global $bill_to;
		global $date;
		global $due_date;
		global $phone_cust;
				
		$this->SetFont('Arial','',10);
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		
		$this->Cell(1,3,'',0,0,'L',false);
		$this->Cell(50,3,$company_name,0,1,'L',false);
		//$this->Image('../assets/img/logo.jpg', 10, 5, 25, 20, 'jpg', '');
		$this->Image('../assets/img/logo.jpg', 12, 2, 35, 20, 'jpg', '');
		$this->Ln(-7);
		
		$this->Cell(36,5,'',0,0,'L',false);
		$this->Cell(20,5,$businiss_type,0,1,'L',false); //'INDUSTRI DAN DISTRIBUSI MATERIAL BAHAN BANGUNAN'
		
		$this->Cell(36,5,'',0,0,'L',false);
		$this->Cell(50,5,'Alamat :' . $address,0,1,'L',false); //. ' Telp./Fax.: ' . $phone
		//$this->Ln(2);
		
		$this->Cell(36,5,'',0,0,'L',false);
		$this->Cell(20,5,$email,0,1,'L',false);
		
		/*$this->Cell(26,3,'',0,0,'L',false);
		$this->Cell(20,3,$email,0,1,'L',false);
		$this->Ln(2);*/
		
		$this->SetFont('Arial','B',10);
		$this->Cell(140,5,'SALES ORDER',0,0,'L',true);
		$this->Cell(50,5,'NO INVOICE : ' . $ref.'/'.$ref2,0,1,'R',false);
		$this->Ln(2);
		
		$this->SetFont('Arial','',10);
		$this->Cell(34,2,'Nama',0,0,'L',true);
		$this->Cell(2,2,':',0,0,'L',false);
		$this->Cell(110,2,$client_name,0,0,'L',false);
		$this->Cell(43,2,'Tanggal : ' . $date,0,1,'R',false);
		$this->Ln(2);
		
		$this->SetFont('Arial','',10);
		$this->Cell(34,2,'Alamat',0,0,'L',true);
		$this->Cell(2,2,':',0,0,'L',false);
		$this->Cell(110,2,$ship_to,0,0,'L',true);
		$this->Cell(43,2,'Tgl Jatuh Tempo : ' . $due_date,0,1,'R',false);
		$this->Ln(2);
		
		$this->Cell(34,2,'No. Telepon',0,0,'L',true);
		$this->Cell(2,2,':',0,0,'L',false);
		$this->Cell(50,2,$phone_cust,0,1,'L',true);
		$this->Ln(2);
		
		//Save ordinate
		$this->y0=$this->GetY();
	}
	
	

	var $B;
	var $I;
	var $U;
	var $HREF;
	
	
	function PDF($orientation='P',$unit='mm', $format='auto') 
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
			if ($i==1) { $this->Cell(95,7,$col,1,0,"C"); }
			if ($i==2) { $this->Cell(12,7,$col,1,0,"C"); }
			if ($i==3) { $this->Cell(12,7,$col,1,0,"C"); }			
			if ($i==4) { $this->Cell(25,7,$col,1,0,"C"); }
			if ($i==5) { $this->Cell(17,7,$col,1,0,"C"); }
			if ($i==6) { $this->Cell(25,7,$col,1,0,"C"); }		
			$i++;
		}
		$this->Ln();
		
		
		//Data		
		foreach($data as $row)
		{	
			$i=0;
			foreach($row as $col) {
				if ($i==0) { $this->Cell(10,6,$col,1,0,"C"); }
				if ($i==1) { $this->Cell(95,6,$col,1,0,"L"); }
				if ($i==2) { $this->Cell(12,6,$col,1,0,"C"); }
				if ($i==3) { $this->Cell(12,6,$col,1,0,"C"); }
				if ($i==4) { $this->Cell(25,6,$col,1,0,"R"); }
				if ($i==5) { $this->Cell(17,6,$col,1,0,"R"); }
				if ($i==6) { $this->Cell(25,6,$col,1,0,"R"); }			
				$i++;
			}
			$this->Ln();
			
		}	
		
		//-----set sub group
		global $terbilang;
		global $sub_total;
		global $freight_cost;
		global $discount2;
		global $deposit;
		global $total;
		global $grand_total;
        global $cash_amount;
        global $change_amount;		
		global $client_name;
		global $petugas;        
        global $posisigaris_total;
        
        global $bank_amount;
		global $ovo;
		global $gopay;
		global $cash_voucher;
		
		$this->SetFillColor(255,255,255);
		$this->SetTextColor(0,0,0);
		$this->SetFont('arial','',10);
		
		$size = $size + $sizeadd;
        
        $freight_cost_tmp = $freight_cost;
        $deposit_tmp      = $deposit;
        
		$sub_total		=	number_format($sub_total,"0",".",",");
		$freight_cost	=	number_format($freight_cost,"0",".",",");
		$discount2		=	number_format($discount2,"0",".",",");
        
        $total_tmp      =   $total + $freight_cost_tmp;
		$total			=	number_format($total_tmp - $deposit,"0",".",",");
		        
        $cash_amount	=	number_format($cash_amount,"0",".",",");
        $change_amount	=	number_format($change_amount + $deposit,"0",".",",");
        $deposit		=	number_format($deposit,"0",".",",");
        
        $grand_total    =   $total_tmp - $deposit_tmp;
		$grand_total	=	number_format($grand_total,"0",".",",");
		
        //garis total
        //$this->SetLineWidth(0.2);
		//$this->Line(100, $posisigaris_total, 10, $posisigaris_total);
		//--------/\------
        $this->Ln(2);
		$this->SetFont('arial','I',9);
		$this->Cell(59,5,'Terbilang :',0,0,'L',false);
        
        $size = $size + $sizeadd;
        
		$this->SetFont('arial','',10);
		$this->Cell(106,5,'',0,0,'R',false);
		$this->Cell(6,5,'Sub Total',0,0,'R',false);
		$this->Cell(25,5,$sub_total,0,1,'R',false);
        
        $size = $size + $sizeadd;
        
		$this->SetFont('arial','I',9);
		$this->Cell(59,5,$terbilang,0,0,'L',true);	
        
        $size = $size + $sizeadd;
				
		$this->SetFont('arial','',10);
        $this->Cell(106,5,'',0,0,'R',false);
        $this->Cell(6,5,'Discount',0,0,'R',false);
		$this->Cell(25,5,$discount2,0,1,'R',false);	
		
		$this->Cell(165,5,'',0,0,'R',false);
		$this->Cell(6,5,'Uang Muka',0,0,'R',false);
		$this->Cell(25,5,$deposit,0,1,'R',false);
		
		$this->Cell(165,5,'',0,0,'R',false);
		$this->Cell(6,5,'Total',0,0,'R',false);
		$this->Cell(25,5,$total,0,1,'R',false);
		
        $size = $size + $sizeadd;
                
		$this->SetFont('arial','',10);
		//$this->Cell(144,5,'',0,0,'L',true);	
		
		$bank_amount	= number_format($bank_amount,0,'.',',');
		$ovo			= number_format($ovo,0,'.',',');
		$gopay			= number_format($gopay,0,'.',',');
		$cash_voucher	= number_format($cash_voucher,0,'.',',');
		
		if($cash_amount > 0) {
			$this->Cell(165,5,'',0,0,'R',false);
			$this->Cell(6,5,'Bayar Kontan',0,0,'R',false);
			$this->Cell(25,5,$cash_amount,0,1,'R',false);
		}
		
		if($bank_amount > 0) {
			$this->Cell(165,5,'',0,0,'R',false);
			$this->Cell(6,5,'Debit',0,0,'R',false);
			$this->Cell(25,5,$bank_amount,0,1,'R',false);
		}
		
		if($ovo > 0) {
			$this->Cell(165,5,'',0,0,'R',false);
			$this->Cell(6,5,'Ovo',0,0,'R',false);
			$this->Cell(25,5,$ovo,0,1,'R',false);
		}
		
		if($gopay > 0) {
			$this->Cell(165,5,'',0,0,'R',false);
			$this->Cell(6,5,'GoPay',0,0,'R',false);
			$this->Cell(25,5,$gopay,0,1,'R',false);
		}
		
		if($cash_voucher > 0) {
			$this->Cell(165,5,'',0,0,'R',false);
			$this->Cell(6,5,'Voucher',0,0,'R',false);
			$this->Cell(25,5,$cash_voucher,0,1,'R',false);
		}
		
		
        $size = $size + $sizeadd;
		$total_amaount = numberreplace($total) - numberreplace($cash_amount) - numberreplace($bank_amount) - numberreplace($ovo) - numberreplace($gopay) - numberreplace($cash_voucher);
		$total_amaount = number_format($total_amaount,0,'.',',');	
		
		$this->SetFont('arial','',10);
		$this->Cell(59,5,'Kasir : '. $petugas,0,0,'L',true);
		
		$this->Cell(106,5,'',0,0,'R',false);
		$this->Cell(6,5,'Sisa Bayar',0,0,'R',false);
		$this->Cell(25,5,$total_amaount,0,1,'R',false);	
		$this->Ln(2);
		
		$this->SetFont('arial','',9);
		$this->Cell(60,5,'Layanan Konsumen',0,1,'L',true);
		$this->Cell(60,5,'WA : 0811.6028.474',0,1,'L',true);
		$this->Cell(60,5,'Call & WA : 0822.7722.1976',0,1,'L',true);
		$this->Ln(1);
				
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

$header=array('No','Nama Barang','Satuan','Qty','Harga','Disc','Jumlah');
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