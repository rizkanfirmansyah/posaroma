<?php
@session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

include_once ("include/queryfunctions.php");
include_once ("include/functions.php");
include_once ("include/inword.php");

include 'class/class.selectview.php';
include 'class/class.select.php';

$selectview = new selectview;
$select = new select;

$from_date				= $_REQUEST['from_date'];
$to_date				= $_REQUEST['to_date'];
$item_code				= $_REQUEST['item_code'];
$uom_code				= $_REQUEST['uom_code'];
$vendor_code			= $_REQUEST['vendor_code'];
$item_group_id			= $_REQUEST['item_group_id'];
$item_subgroup_id		= $_REQUEST['item_subgroup_id'];
$location_id			= $_REQUEST['location_id'];
$all		= $_REQUEST['all'];

$filter = "";

if($from_date != "") {
    
    $from_date_filetr = date("d-m-Y", strtotime($from_date));
    
	if($filter == "") {
		$filter = " Tanggal : ".$from_date_filetr;
	} else {
		$filter = $filter." s/d Tanggal : ".$from_date_filetr;
	}
}

if($to_date != "") {
    
    $to_date_filetr = date("d-m-Y", strtotime($to_date));
    
	if($filter == "") {
		$filter = " Tanggal : ".$to_date_filetr;
	} else {
		$filter = $filter." s/d Tanggal : ".$to_date_filetr;
	}
}

if($vendor_code != "") {
    $sqlitem = $select->list_vendor($vendor_code);
    $dataitem = $sqlitem->fetch(PDO::FETCH_OBJ);
	if($filter == "") {
		$filter = " Supplier : ".$dataitem->name;
	} else {
		$filter = $filter." , Supplier : ".$dataitem->name;
	}
}

if($item_code != "") {
    $sqlitem = $select->list_item($item_code);
    $dataitem = $sqlitem->fetch(PDO::FETCH_OBJ);
	if($filter == "") {
		$filter = " Nama Barang : ".$dataitem->name;
	} else {
		$filter = $filter." , Nama Barang : ".$dataitem->name;
	}
}

if($location_id != "") {
    $sqlitem = $select->list_warehouse($location_id);
    $dataitem = $sqlitem->fetch(PDO::FETCH_OBJ);
	if($filter == "") {
		$filter = " Gudang : ".$dataitem->name;
	} else {
		$filter = $filter." , Gudang : ".$dataitem->name;
	}
}

if($uom_code != "") {
	if($filter == "") {
		$filter = " Satuan : ".$uom_code;
	} else {
		$filter = $filter." , Satuan : ".$uom_code;
	}
}

if($item_group_id != "") {
    $sqlitem = $select->list_item_group($item_group_id);
    $dataitem = $sqlitem->fetch(PDO::FETCH_OBJ);
	if($filter == "") {
		$filter = " Kelompok Barang : ".$dataitem->name;
	} else {
		$filter = $filter." , Kelompok Barang : ".$dataitem->name;
	}
}

if($all != 0) {
	$filter = "Semua";
}

?>

<head>
<title>Report Stock</title>

</head>

<table width="100%" border="0" cellpadding="0" cellspacing="0" style="font-family: Arial; font-size: 16px">
	<tr>
		<td align="left"><b>LAPORAN PERBANDINGAN HARGA</b></td>
	</tr>
	
	<tr>
		<td align="left"><i><?php echo $filter ?></i></td>
	</tr>
	
</table>

<br>


<table width="100%" border="1" cellpadding="0" cellspacing="0" style="border:#ccc; font-family: Arial; font-size: 16px">	
	
	<tr align="center" style="font-weight: bold">
		<th>Kelompok</th>
        <th>Kode</th>
    	<!--<th>Barcode</th>-->
    	<th>Nama Barang</th>
    	<th>Qty</th>
    	<th>Satuan</th>
		<td>Harga Beli</td>
		<td>Harga Jual</td>
		<td>Selisih</td>
	</tr>
	
	<?php
		
		$sql = $selectview->list_item($item_code, $uom_code, $item_group_id, $item_subgroup_id, $all);	
		while($row_varian=$sql->fetch(PDO::FETCH_OBJ)) {
			
            $current_cost = $selectview->list_purchase_invoice_last_cost($row_varian->syscode, $row_varian->uom_code_sales);
            $current_price = $selectview->list_price_last($row_varian->syscode, $row_varian->uom_code_sales);
            
			$variant = 0;
			$variant = $current_price - $current_cost;
			
			//stok
			$qty = 0;
			$sql = $selectview->rpt_stock($item_code, $location_id, $uom_code, $all, $item_group_id, $item_subgroup_id, $from_date, $to_date);	
			$row_bincard=$sql->fetch(PDO::FETCH_OBJ);
			$qty = $row_bincard->qty;
			//-----------/\
			
            
			$j++;
			
			if($j%2==1){
				$bgcolor	=	'style="background-color: #D9FFD0"';
			} else {
				$bgcolor	=	'style="background-color: #fff"';
			}
	?>
	
			<tr <?php echo $bgcolor; ?> >
				<td align="left" bgcolor="">&nbsp;<?php echo $row_varian->item_group_name  ?></td>
				<td align="left" bgcolor="">&nbsp;<?php echo $row_varian->code  ?></td>
				<!--<td align="left" bgcolor="">&nbsp;<?php echo $row_varian->old_code  ?></td>-->
				<td align="left">&nbsp;<?php echo $row_varian->name ?></td>
				<td align="right"><?php echo number_format($qty,"2",",",".") ?>&nbsp;</td>	
				<td align="center">&nbsp;<?php echo $row_varian->uom_code_sales ?></td>
				<td align="right"><?php echo number_format($current_cost,"2",",",".") ?>&nbsp;</td>								<td align="right"><?php echo number_format($current_price,"2",",",".") ?>&nbsp;</td>
				<td align="right"><?php echo number_format($variant,"2",",",".") ?>&nbsp;</td>
			</tr>
		
		<!--
		<tr style="font-weight: bold">
			<td align="right" colspan="4">Total&nbsp;</td>
			<td align="right"><?php echo number_format($total_debit,"0",",",".") ?>&nbsp;</td>
			<td align="right"><?php echo number_format($total_credit,"0",",",".") ?>&nbsp;</td>
			<td align="right"><?php echo number_format($grand_total_qty,"0",",",".") ?>&nbsp;</td>
		</tr>-->
	
		
	<?php
	}
	?>
	
</table>

