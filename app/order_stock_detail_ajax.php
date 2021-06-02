<?php
include_once ("../app/include/queryfunctions.php");
include_once ("../app/include/functions.php");

$dbpdo = DB::create();

$pilih = $_POST["button"];

switch ($pilih){
	case "getdata":
		$dbpdo = DB::create();
		
		$kode 			= $_POST['item_code2'];	
		$location_id	= $_POST['location_id'];
		
		$no = $kodex;
		$sqlstr 	= "select syscode, uom_code_sales uom_code from item where code='$kode' limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data 	= $sql->fetch(PDO::FETCH_OBJ); 
		
		$item_code 	= $data->syscode;
		$uom_code	= $data->uom_code;
		
        $sqlprice = "select b.current_price, b.current_price1, b.current_price2, b.current_price3, a.name, ifnull(non_discount,0) non_discount from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' order by b.date_of_record desc limit 1 ";
        $sql=$dbpdo->prepare($sqlprice);
		$sql->execute();
		$dataprice 	= $sql->fetch(PDO::FETCH_OBJ); 
		
		$item_name		= $dataprice->name;
		
		if($item_name == "") {
			$sqlprice = "select a.name from item a where a.syscode='$item_code' ";
			$sql=$dbpdo->prepare($sqlprice);
			$sql->execute();
			$dataprice 	= $sql->fetch(PDO::FETCH_OBJ); 
			
			$item_name		= $dataprice->name;
		}
		
?>		
		
			
			<input type="hidden" id="item_code" name="item_code" style="font-size: 12px; width: 100px" class="form-control" onKeyPress="return focusNext('submit_det',event)" value="<?php echo $item_code ?>" />
			
			<td align="left">
				<input type="text" id="item_code2" name="item_code2" style="font-size: 12px; width: 272px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onchange="loadHTMLPost3('app/order_stock_detail_ajax.php','item_ajax','getdata','item_code2','location_id2')" value="<?php echo $kode ?>" >
			</td>
			
			<td align="left">
				<input type="text" id="item_name" name="item_name" readonly="" style="font-size: 12px; width: auto" class="form-control" value="<?php echo $item_name ?>" >
			</td>
			
			<td>
				<select id="uom_code" name="uom_code" class="form-control" style="height: 35px; width: auto; font-size: 12px">
					<option value=""></option>
					<?php 
						select_uom($uom_code) 
					?>
				</select>	
			</td>
			<td align="center">
				<input type="text" id="qty" name="qty" style="text-align: right; font-size: 12px; width: 60px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('qty'), detailvalue2()" value="1" >
			</td>
		
		<!--</tr>-->
<?php
		
		break;	
		
	
	case "getdata2":
		$dbpdo = DB::create();
		
		$kode 			= $_POST['item_code'];	
		$location_id	= $_POST['location_id'];
		
		$no = $kodex;
		$sqlstr = "select code, syscode, uom_code_sales uom_code from item where syscode='$kode' limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data 	= $sql->fetch(PDO::FETCH_OBJ); 
		
		$item_code 	= $kode; //$data->syscode;
		$item_code2 = $data->code;
		$uom_code	= $data->uom_code;
		
		$sqlprice = "select b.current_price, a.name, ifnull(non_discount,0) non_discount from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' order by b.date_of_record desc limit 1 "; //and location_id='$location_id' 
		$sql=$dbpdo->prepare($sqlprice);
		$sql->execute();
		$dataprice 	= $sql->fetch(PDO::FETCH_OBJ);
		
		$item_name		= $dataprice->name;
		
		if($item_name == "") {
			$sqlprice = "select a.name from item a where a.syscode='$item_code' ";
			$sql=$dbpdo->prepare($sqlprice);
			$sql->execute();
			$dataprice 	= $sql->fetch(PDO::FETCH_OBJ);
			
			$item_name		= $dataprice->name;
		}
		
?>		
		
			<input type="hidden" id="item_code" name="item_code" style="font-size: 12px; width: 100px" class="form-control" onKeyPress="return focusNext('submit_det',event)" value="<?php echo $item_code ?>" />
			
			<input type="hidden" id="non_discount" name="non_discount" value="<?php echo $non_discount; ?>" />
			
			<td align="left">
				<input type="text" id="item_code2" name="item_code2" style="font-size: 12px; width: 272px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onchange="loadHTMLPost2('app/order_stock_detail_ajax.php','item_ajax','getdata','item_code2')" value="<?php echo $item_code2 ?>" >
			</td>
			
			<td align="left">
				<input type="text" id="item_name" name="item_name" readonly="" style="font-size: 12px; width: auto" class="form-control" value="<?php echo $item_name ?>" >
			</td>
			
			<td>
				<select id="uom_code" name="uom_code" class="form-control" style="height: 35px; width: auto; font-size: 12px">
					<option value=""></option>
					<?php 
						select_uom($uom_code) 
					?>
				</select>	
			</td>
			<td align="center">
				<input type="text" id="qty" name="qty" style="text-align: right; font-size: 12px; width: 60px" class="form-control" onKeyPress="return focusNext('submit_det',event)" onkeyup="formatangka('qty'), detailvalue2()" value="1" >
			</td>
		
		<!--</tr>-->
<?php
		
		break;
		
		
	case "getdata_code2": //get enter
		$jmldata = $_POST['jmldata'];
		$no		 = $jmldata;
		$kode 	= $_POST[item_code3_.$no];	
		
		$sqlstr = "select code, syscode, uom_code_sales uom_code from item where syscode='$kode' limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data 	= $sql->fetch(PDO::FETCH_OBJ); 
		
		$item_code 	= $kode; //$data->syscode;
		$item_code2 = $data->code;
		$uom_code	= $data->uom_code;
		
		$sqlprice = "select b.current_price, a.name, ifnull(non_discount,0) non_discount from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' order by b.date_of_record desc limit 1 "; //and location_id='$location_id' 
		$sql=$dbpdo->prepare($sqlprice);
		$sql->execute();
		$dataprice 	= $sql->fetch(PDO::FETCH_OBJ);
		
		$item_name		= $dataprice->name;
		
		if($item_name == "") {
			$sqlprice = "select a.name from item a where a.syscode='$item_code' ";
			$sql=$dbpdo->prepare($sqlprice);
			$sql->execute();
			$dataprice 	= $sql->fetch(PDO::FETCH_OBJ);
			
			$item_name		= $dataprice->name;
		}
		
?>		
		<td style="border-right: 1px solid #cccccc;">
			<input type="hidden" id="item_code" name="item_code" class="form-control" value="<?php echo $data->syscode ?>">
			
      		<select id="item_code3_<?php echo $no ?>" name="item_code3_<?php echo $no ?>" class="chosen-select form-control" onchange="loadHTMLPost3('<?php echo $__folder ?>app/order_stock_detail_ajax.php','item_ajax_<?php echo $no; ?>','getdata_code2','item_code3_<?php echo $no; ?>','jmldata')" >
				<option value=""></option>
				<?php 
					select_item($item_code)
				?>	
			</select>
      	</td>
      	
      	<td style="border-right: 1px solid #cccccc;">
			<select id="uom_code" name="uom_code" class="form-control" style="height: 35px; width: auto;">
				<option value=""></option>
				<?php 
					select_uom($uom_code) 
				?>
			</select>	
		</td>
		<td align="left" style="border-right: 1px solid #cccccc;">
			<input type="text" id="qty" name="qty" style="text-align: right;" class="form-control" onkeyup="formatangka('qty'), detailvalue2()" autocomplete="off" autofocus="" value="" >
		</td>
<?php
		
		break;	
	
	case "getdata_code3": //get enter
		$jmldata = $_POST['jmldata'];
		$no		 = $jmldata;
		$kode 	= $_POST[item_code3_.$no];	
		
		$sqlstr = "select code, syscode, uom_code_sales uom_code from item where syscode='$kode' limit 1";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data 	= $sql->fetch(PDO::FETCH_OBJ); 
		
		$item_code 	= $kode; //$data->syscode;
		$item_code2 = $data->code;
		$uom_code	= $data->uom_code;
		
		$sqlprice = "select b.current_price, a.name, ifnull(non_discount,0) non_discount from item a left join set_item_price b on a.syscode=b.item_code where a.syscode='$item_code' and a.uom_code_sales='$uom_code' order by b.date_of_record desc limit 1 "; //and location_id='$location_id' 
		$sql=$dbpdo->prepare($sqlprice);
		$sql->execute();
		$dataprice 	= $sql->fetch(PDO::FETCH_OBJ);
		
		$item_name		= $dataprice->name;
		
		if($item_name == "") {
			$sqlprice = "select a.name from item a where a.syscode='$item_code' ";
			$sql=$dbpdo->prepare($sqlprice);
			$sql->execute();
			$dataprice 	= $sql->fetch(PDO::FETCH_OBJ);
			
			$item_name		= $dataprice->name;
		}
		
?>		
		<td style="border-right: 1px solid #cccccc;">
			<input type="hidden" id="item_code" name="item_code" class="form-control" value="<?php echo $data->syscode ?>">
			
      		<select id="item_code3_<?php echo $no ?>" name="item_code3_<?php echo $no ?>" class="chosen-select form-control" onchange="loadHTMLPost3('order_stock_detail_ajax.php','item_ajax_<?php echo $no; ?>','getdata_code3','item_code3_<?php echo $no; ?>','jmldata')" >
				<option value=""></option>
				<?php 
					select_item($item_code)
				?>	
			</select>
      	</td>
      	
      	<td style="border-right: 1px solid #cccccc;">
			<select id="uom_code" name="uom_code" class="form-control" style="height: 35px; width: auto;">
				<option value=""></option>
				<?php 
					select_uom($uom_code) 
				?>
			</select>	
		</td>
		<td align="left" style="border-right: 1px solid #cccccc;">
			<input type="text" id="qty" name="qty" style="text-align: right;" class="form-control" onkeyup="formatangka('qty'), detailvalue2()" autocomplete="off" autofocus="" value="" >
		</td>
<?php
		
		break;
		
	
	default:
}
?>