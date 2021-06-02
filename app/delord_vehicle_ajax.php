<?php
include_once ("../app/include/queryfunctions.php");
include_once ("../app/include/functions.php");

include 'class/class.select.php';
$select=new select;

$pilih = $_POST["button"];
switch ($pilih){
	case "setvhc":
		$vhccde = $_POST['vhccde'];
		
		$sql=$select->list_vhc_lup($vhccde);
		$row_delord=$sql->fetch(PDO::FETCH_OBJ);
?>		
		<div class="form-group"> 
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status Kendaraan *)</label>
			<div class="col-sm-3">
				<input size="40" type="text" id="vhctpe" name="vhctpe" style="background-color:#E2F6C5;" readonly="" value="<?php echo $row_delord->sts ?>">
			</div>
		</div>
		
        <div class="form-group">
    		<?php if ($row_delord->sts=='Sub') { ?>
    			<!--<tr id="vhcsub"> -->
    				<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Subcon</label>
    				<div class="col-sm-3"><input size="40" type="text" id="subconnme" name="subconnme" onKeyup="this.value=this.value.toUpperCase()" value="<?php echo $row_delord->vdrnme ?>"></div>
    			<!--</div>-->
    		<?php } else { ?>								 
    			<?php if ($ref == '') { ?>
    				<!--<tr id="vhcsub"> -->
    					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Nama Subcon</label>
    					<div class="col-sm-3"><input size="40" type="text" id="subconnme" name="subconnme" onKeyup="this.value=this.value.toUpperCase()" value="<?php echo $row_delord->vdrnme ?>"></div>
    				<!--</div>-->
    			<?php } ?>
    			
    		<?php } ?>
        </div>
		
		<div class="form-group"> 
			<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tipe *)</label>
			<div class="col-sm-3"><input size="40" type="text" id="tpe" name="tpe" onKeyup="this.value=this.value.toUpperCase()" value="<?php echo $row_delord->tipe ?>"></div>
		</div>
        	
<?php
		
		break;
		
	default:
}
?>