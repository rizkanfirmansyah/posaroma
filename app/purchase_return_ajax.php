<?php
include_once ("../app/include/queryfunctions.php");
include_once ("../app/include/functions.php");

include '../app/class/class.select.php';
$select=new select;

$pilih = $_POST["button"];
switch ($pilih){
	case "getpi":
		$vendor_code = $_POST["vendor_code"];	
		
		
?>		
		
		 <div class="form-group" id="purchaseno">
            <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Purchase Invoice No *)</label>
            <div class="col-sm-5">
              <select id="pi_ref" name="pi_ref" data-placeholder="..." class="form-control chzn-select-deselect" tabindex="2" style="width: auto" onChange="loadHTMLPost2('app/purchase_return_ajax2.php','itemdetail','getitempi','pi_ref')">
              	<option value=""></option>
                <?php 
                	select_pi_return("", $vendor_code) 
                ?>	
                                          
              </select>
			</div>
		</div>
		
<?php
		break;
		
	default:
}
?>