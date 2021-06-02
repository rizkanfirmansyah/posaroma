<?php
include_once ("../app/include/queryfunctions.php");
include_once ("../app/include/functions.php");

$pilih = $_POST["button"];

switch ($pilih){
	case "ceknodo":
		$delordcde	= $_POST["delordcde"];
		$dono 		= $_POST["dono"];	
		
		$sqlstr 	= "select dono from delord where delordcde<>'$delordcde' and dono='$dono' limit 1 ";
		$sql=$dbpdo->prepare($sqlstr);
		$sql->execute();
		$data 	= $sql->fetch(PDO::FETCH_OBJ); 
		$do_no	= $data->dono;
				
		if($do_no != '') {
?>		
			<div class="col-sm-3" id="nodo"><input size="40" type="text" id="dono" name="dono" onKeyup="this.value=this.value.toUpperCase()" onblur="loadHTMLPost3('app/delord_ajax_nodo.php','nodo','ceknodo','delordcde','dono')" value=""><font color="#FF0000" size="-1">No DO sudah dipakai !</font></div>	
<?php	
		} else {
?>
			<div class="col-sm-3" id="nodo"><input size="40" type="text" id="dono" name="dono" value="<?php echo $dono; ?>" onKeyup="this.value=this.value.toUpperCase()" onblur="loadHTMLPost3('app/delord_ajax_nodo.php','nodo','ceknodo','delordcde','dono')"  ></div>
            
<?php
		}
		
		break;	
	
	default:
}
?>