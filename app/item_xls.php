<?php
session_start();

if (($_SESSION["logged"] == 0)) {
	echo 'Access denied';
	exit;
}

$namafile = "Master_Produk.csv";

header("Content-Type: application/csv");
header("Content-Disposition: attachment;filename=".$namafile." ");

include_once ("include/queryfunctions.php");
include_once ("include/functions.php");
//include_once ("include/function_excel.php");

include 'class/class.selectview.php';
include 'class/class.select.php';

$selectview = new selectview;
$select = new select;

$dbpdo = DB::create();

$code	             	=    $_REQUEST['code'];
$old_code		    	=    $_REQUEST['old_code'];
$name            		=    $_REQUEST['name'];
$item_group_id       	=    $_REQUEST['item_group_id'];
$all			       	=    $_REQUEST['all']; 	


$fp = fopen('php://output', 'w');
$fp1 = fopen('php://output', 'w');

$query = "select 'No.', 'Kode Sistem', 'Kode Produk', 'Nama Produk', 'Kelompok Produk', 'Satuan', 'Harga Jual', 'Min. Stok', 'Maks. Stok'";

$sql3=$dbpdo->prepare($query);
$sql3->execute();
	
while($row = $sql3->fetch(PDO::FETCH_NUM)) {
	
	fputcsv($fp, $row, ';');
	
	
	
	$i = 0;
	$sql=$select->list_item($kode, $all, $active, $code, $old_code, $name, $item_group_id);
	while($row_item=$sql->fetch(PDO::FETCH_OBJ)){
	
		$i++;
		
		//get current_cost
		$sqlcost=$select->list_set_item_cost_last("", $row_item->syscode);
		$row_item_cost=$sqlcost->fetch(PDO::FETCH_OBJ);

		//set current price
		$sqlprice = $select->list_set_item_price_last("", $row_item->syscode);
		$dataprice = $sqlprice->fetch(PDO::FETCH_OBJ);
		
		$detail = array(
		       '0' => $i,
		       '1' => $row_item->code,
			   '2' => $row_item->old_code,
			   '3' => $row_item->name,
			   '4' => $row_item->item_group_name,
			   '5' => $row_item->uom_code_stock,
			   '6' => $dataprice->current_price,
			   '7' => $row_item->minimum_stock,
			   '8' =>$row_item->maximum_stock
		 );
		
		fputcsv($fp1, $detail, ';');
		
	}
	
}      

?>

