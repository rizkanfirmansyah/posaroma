<?php
include_once ("../app/include/queryfunctions.php");
include_once ("../app/include/functions.php");

$dbpdo = DB::create();

$pilih = $_POST["button"];

$exp = explode("|",$pilih,7);
$pilih = $exp[0];
$kodex = $exp[1];

switch ($pilih){
	case "getdata":
		$kode 	= $_POST['item_code_'.$kodex];	
		
		$no = $kodex;
		$sql 	= $dbpdo->query("select uom_code_purchase as uom_code from item where syscode='$kode' limit 1");
		$data 	= $sql->fetch(PDO::FETCH_OBJ); 
		
		$uom_code	= $data->uom_code;
				
?>		
		
		<td id="item_ajax2_<?php echo $no; ?>">
			<select id="uom_code_<?php echo $no ?>" name="uom_code_<?php echo $no ?>" class="form-control" style="height: 35px; width: auto; font-size: 11px">
				<option value=""></option>
				<?php 
					select_uom($uom_code) 
				?>
			</select>	
		</td>
			
<?php
		
		break;	
	
	default:
}
?>