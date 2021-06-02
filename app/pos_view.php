<?php

$from_date	            =    $_REQUEST['from_date'];
$to_date		    	=    $_REQUEST['to_date'];
$shift	          		=    $_REQUEST['shift'];
$cashier				=	 $_REQUEST['cashier'];
$receipt_type_pos		=	 $_POST['receipt_type_pos'];
$all			       	=    $_REQUEST['all'];
$void			       	=    $_REQUEST['void_'];

$location_id_hd = "";
//cek lokasi area manager
if($_SESSION['adm'] != 1) {
	$location_id_hd = area_manager_location();
	
	if($location_id_hd == '') {
		$location_id_hd = supervisor_location_central();
	}
	
	/*if($location_id1 == '') {
		$location_id1 = supervisor_location();
	}
	
	if($location_id_hd == '' && $location_id1 == '') {
		$location_id_hd = user_location_central();
		
		$location_id1	= $_SESSION['location_id2'];
	}*/
}

if($shift == "") {
	$shift = $_SESSION["shift"];
}

if($from_date == "") {
	$from_date = date("d-m-Y");
}

if($to_date == "") {
	$to_date = date("d-m-Y");
}

if($all == 1 || $all == true) {
	$all2 = "checked";
}

if($void == 1 || $void == true) {
	$void2 = "checked";
}


if($_SESSION['adm'] != 1 && $location_id_hd == '') {
	$cashier = $_SESSION['loginname'];
} 
		
?>

<script type="text/javascript">
	function hapus(id) {
		if (confirm('Apakah Anda yakin akan menghapus data ini?')) {
			document.location.href = "main.php?menu=app&act=<?php echo obraxabrix('pos_view') ?>&mxKz=xm8r389xemx23xb2378e23&id="+id+" ";
		}
	}
</script>

<script>
	function print() {
		var from_date	=	document.getElementById('from_date').value;
		var to_date		=   document.getElementById('to_date').value;
		var shift	   	=   document.getElementById('shift').value;
		var cashier		=	document.getElementById('cashier').value;
		var all			=   0; //document.getElementById('all').value;
		var receipt_type_pos = document.getElementById('receipt_type_pos').value;
		var void_ 		= 	document.getElementById('void_').checked;
		var uid_print	=	document.getElementById('uid_print').value;
		
		if(void_ == true) {
			void_ = 1;
		}
		
		if(void_ == false) {
			void_ = 0;
		}
		
		//window.location = "app/pos_view_print_create.php?from_date="+from_date+"&to_date="+to_date+"&shift="+shift+"&cashier="+cashier+"&all="+all; //localhost only
		window.location = "app/pos_view_print_create_ol.php?from_date="+from_date+"&to_date="+to_date+"&shift="+shift+"&uid="+cashier+"&receipt_type_pos="+receipt_type_pos+"&void_="+void_+"&uid_print="+uid_print; //internet only
		
		
	}
	
	
	function print_inv() {
		var from_date	=	document.getElementById('from_date').value;
		var to_date		=   document.getElementById('to_date').value;
		var shift	   	=   document.getElementById('shift').value;
		var cashier		=	document.getElementById('cashier').value;
		var all			=   0; //document.getElementById('all').value;
		var receipt_type_pos = document.getElementById('receipt_type_pos').value;
		var void_ 		= 	document.getElementById('void_').checked;
		var uid_print	=	document.getElementById('uid_print').value;
		
		if(void_ == true) {
			void_ = 1;
		}
		
		if(void_ == false) {
			void_ = 0;
		}
		
		window.location = "app/pos_view_inv_print_create_ol.php?from_date="+from_date+"&to_date="+to_date+"&shift="+shift+"&uid="+cashier+"&receipt_type_pos="+receipt_type_pos+"&void_="+void_+"&uid_print="+uid_print; //internet only
		
		
	}
	
	function print_preview() {
		var from_date	=    document.getElementById('from_date').value;
		var to_date		=     document.getElementById('to_date').value;
		var shift	   	=     document.getElementById('shift').value;
		var cashier		=	  document.getElementById('cashier').value;
		var all			=     0;
		var receipt_type_pos = document.getElementById('receipt_type_pos').value;
		var void_ 		= 	 document.getElementById('void_').checked;
		
		if(void_ == true) {
			void_ = 1;
		}
		
		if(void_ == false) {
			void_ = 0;
		}
		
		window.open('app/pos_print_view.php?from_date='+from_date+'&to_date='+to_date+'&shift='+shift+'&uid='+cashier+"&receipt_type_pos="+receipt_type_pos+"&void_="+void_, 'Invoice Print','825','450','resizable=1,scrollbars=1,status=0,toolbar=0')
	}
	
</script>

<script type="text/javascript">
	function excel_export() {
		
		date_from			=	document.getElementById('from_date').value;
		date_to				=	document.getElementById('to_date').value;
		//all					=	document.getElementById('all').checked;
		shift				=	document.getElementById('shift').value;
		cashier				=	document.getElementById('cashier').value;
		receipt_type_pos	=	document.getElementById('receipt_type_pos').value;
		void_				=	document.getElementById('void_').checked;
		
		/*if(all == true) { all = 1}
		if(all == false) { all = 0}*/
		
		if(void_ == true) { void_ = 1}
		if(void_ == false) { void_ = 0}
		
		document.location.href = "app/pos_xls.php?cashier="+cashier+"&receipt_type_pos="+receipt_type_pos+"&void_="+void_+"&from_date="+date_from+"&to_date="+date_to; //+"&all="+all	
	}
</script>

<script>
	
	function closed_checked() {
		var closed = document.getElementById('closed').checked;
		
		if (confirm('Apakah yakin Anda akan Closing data ini ?')) {
			if(closed == false){
				alert("Closing belum diceklist !");
				
				return false;
			} 
		} else {
			return false;
		}
		
		
	}
	
</script>


<div class="page-content">						
	<div class="row">
		<div class="col-xs-12">
                
            <?php
				$delete = $_REQUEST['mxKz'];
                $segmen4 = $_REQUEST['id'];
				if ($delete == "xm8r389xemx23xb2378e23") {
					include 'class/class.delete.php';
					$delete2=new delete;
					$delete2->delete_pos($segmen4);
			?>
					<div class="alert alert-success">
						<strong>Delete Data successfully</strong>
					</div>
                    
                    <meta http-equiv="Refresh" content="0;url=main.php?menu=app&act=<?php echo obraxabrix('pos_view') ?>" />
			<?php   
				}
				
				$uid_print = $_SESSION["loginname"];
			?>
            
            
            <!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
				
					<form class="form-horizontal" role="form" action="" method="post" name="purchase_view" id="purchase_view" class="form-horizontal" enctype="multipart/form-data" >
		            	
		            	<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php if($lng==1) { echo 'From Date'; } else { echo 'Dari Tanggal'; } ?></label>
							<div class="col-sm-3">
								<input type="text" id="from_date" name="from_date" style="font-size: 12px" class="form-control date-picker" data-date-format="dd-mm-yyyy" value="<?php echo $from_date ?>">								
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php if($lng==1) { echo 'To Date'; } else { echo 's/d Tanggal'; } ?></label>
							<div class="col-sm-3">
								<input type="text" id="to_date" name="to_date" style="font-size: 12px" class="form-control date-picker" data-date-format="dd-mm-yyyy" value="<?php echo $to_date ?>">								
							</div>
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php if($lng==1) { echo 'Shift'; } else { echo 'Shift'; } ?></label>
							<div class="col-sm-3">
								<!--<input type="text" id="shift" name="shift" style="font-size: 12px" class="form-control" value="<?php echo $shift ?>">	-->
								<select id="shift" name="shift" class="chosen-select form-control"  style="max-width: 300px; font-size: 12px;" >
		                          	<option value=""></option>
		                            <?php 
		                                select_shift($shift) 
		                            ?>                        
		                        </select>							
							</div>
						</div>
						
						
						<div class="form-group">
		                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php if($lng==1) { echo 'Cashier'; } else { echo 'Kasir'; } ?></label>
		                    
		                    <div class="col-sm-3">
		                    	<?php if($_SESSION['adm'] == 1) { ?>
			                    	 <select id="cashier" name="cashier" class="chosen-select form-control"  style="max-width: 300px; font-size: 12px;" >
			                          	<option value=""></option>
			                            <?php 
			                                select_cashier_toko($cashier) 
			                            ?>                        
			                          </select>
		                        <?php } else { ?>
		                        	<?php if($location_id_hd == '') { ?>		                        	
			                        	<input type="hidden" id="cashier" name="cashier" value="<?php echo $cashier ?>" />
				                        <select id="cashier2" name="cashier2" class="chosen-select form-control" disabled="" style="max-width: 300px; font-size: 12px;" >
				                          	<option value=""></option>
				                            <?php 
				                                select_cashier_toko($cashier) 
				                            ?>                        
				                          </select>
			                        <?php } else { ?>
			                        	<select id="cashier" name="cashier" class="chosen-select form-control"  style="max-width: 300px; font-size: 12px;" >
				                          	<option value=""></option>
				                            <?php 
				                                select_cashier_toko($cashier) 
				                            ?>                        
				                          </select>
			                        <?php } ?>
		                        <?php } ?>
							</div>
		                    
						</div>
						
						<div class="form-group">
		                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php if($lng==1) { echo 'Receipt Type'; } else { echo 'Tipe Pembayaran'; } ?></label>
		                    
		                    <div class="col-sm-3">
		                    	 <select id="receipt_type_pos" name="receipt_type_pos" class="chosen-select form-control"  style="max-width: 300px; font-size: 12px;" >
		                          	<option value=""></option>
		                            <?php 
		                                select_receipt_type_pos($receipt_type_pos) 
		                            ?>	
		                                                      
		                          </select>
							</div>
		                    
						</div>
						
						<div class="form-group" style="color: #ff0000">
		                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1">Batal</label>
		                    
		                    <div class="col-sm-3">
		                    	 <input id="void_" name="void_" type="checkbox" value="1" <?php echo $void2 ?> >
							</div>
		                    
						</div>
						
						<div class="form-group">
							<label class="col-sm-3 control-label no-padding-right" for="form-field-1">&nbsp;</label>
		                    <div class="col-sm-6">
		                      <input type="submit" name="submit" id="submit" class='btn btn-primary' value="Preview"/>
		                      &nbsp;
		                      <input type="button" name="button" class="btn btn-success" value="Print" onclick="print()" >
		                      &nbsp;
		                      <input type="button" name="button" class="btn btn-warning" value="Print Daily(Y)" onclick="print_inv()" >
		                      &nbsp;&nbsp;&nbsp;
							  <input type="button" name="button" class="btn btn-success" value="Print Preview" onclick="print_preview()" >
							  &nbsp;&nbsp;
			                  <a href="JavaScript:excel_export()">
									<img src="assets/img/excel.jpg" />
								</a>
							</div>
							
						</div>
						
						
						<input type="hidden" id="uid_print" name="uid_print" value="<?php echo $uid_print ; ?>" >
						
					</form>
				
				</div>
			</div>
			
			<?php
				if($_POST['submit'] == "Closing") {
					include("app/exec/pos_insert.php");
				}
			?>
			    
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<!-- div.dataTables_borderWrap -->
					
					<form class="form-horizontal" role="form" action="" method="post" name="pos_view2" id="pos_view2" enctype="multipart/form-data">
					
					<input type="hidden" id="from_date" name="from_date" value="<?php echo $from_date ?>" />
					<input type="hidden" id="to_date" name="to_date" value="<?php echo $to_date ?>" />
					<input type="hidden" id="shift" name="shift" value="<?php echo $shift ?>" />
					<input type="hidden" id="cashier" name="cashier" value="<?php echo $cashier ?>" />
					<input type="hidden" id="receipt_type_pos" name="receipt_type_pos" value="<?php echo $receipt_type_pos ?>" />
					<input type="hidden" id="void_" name="void_" value="<?php echo $void_ ?>" />
					<input type="hidden" id="uid_print" name="uid_print" value="<?php echo $uid_print ?>" />
					
				
					<div>
						<div class="form-group">
		                    <label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php if($lng==1) { echo 'Closing'; } else { echo 'Closing'; } ?></label>
		                    
		                    <div class="col-sm-3">
		                    	 <input type="checkbox" id="closed" name="closed" class="ace" value="1" /><span class="lbl"></span>
		                    	 <button type="submit" name="submit" id="submit" class="btn btn-white btn-info btn-bold" value="Closing" onClick="return closed_checked()">
									<i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
									Closing
								 </button>
							</div>
		                    
						</div>
						
						<table id="dynamic-table" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
                                    <th class="center" style="font-weight:bold ">No.</th>
                                    <th><?php if($lng==1) { echo 'Ref No'; } else { echo 'No. Nota'; } ?></th>
									<th><?php if($lng==1) { echo 'Date'; } else { echo 'Tanggal'; } ?></th>
									<th><?php if($lng==1) { echo 'Time'; } else { echo 'Jam'; } ?></th>
									<th>Shift</th>
									<th><?php if($lng==1) { echo 'Cashier'; } else { echo 'Kasir'; } ?></th>
									<th><?php if($lng==1) { echo 'Total'; } else { echo 'Total'; } ?></th>
									<th><?php if($lng==1) { echo 'Status'; } else { echo 'Status'; } ?></th>
									<th style="text-align: center">
										<?php if($lng==1) { echo 'Closing'; } else { echo 'Closing'; } ?>
										<!--<br>
										<label class="pos-rel">
											<input type="checkbox" id="pilihall" name="pilihall" class="ace" value="1" checked="" /><span class="lbl"></span>
										</label>-->		
									</th>
									<th></th>
                                        
								</tr>
							</thead>

							<tbody>
                                <?php	
                                	$grand_total = 0;		
									$i = 0;									
            						$sql=$select->list_pos_valid('', $all, $from_date, $to_date, $shift, $cashier, $receipt_type_pos, $void);
						            while($row_pos=$sql->fetch(PDO::FETCH_OBJ)){
            						
            						
            						$bgcolor = "";
            						$total = 0;
            						$status = "";
            						if ($row_pos->void == 1) {
										$status = "Batal";
										$bgcolor = 'style="background-color: #ff0000; color: #ffffff"';
										$total = 0;
									} else {
										$total = $row_pos->total;
										$grand_total = $grand_total + $row_pos->total;
									}
									
									if ($row_pos->closed == 1) {
										$status = "Closed";
									}
									/*if ($row_pos->status == "R") {
										$status = "Released";
									}
									if ($row_pos->status == "I") {
										$status = "Paid in Part";
									}
									if ($row_pos->status == "F") {
										$status = "Paid in Full";
									}
									if ($row_pos->status == "V") {
										$status = "Void";
									}
									if ($row_pos->status == "S") {
										$status = "Shipped in Part";
									}
									if ($row_pos->status == "E") {
										$status = "Shipped in Full";
									}
									if ($row_pos->status == "C") {
										$status = "Closed";
									}*/
									
					
									$j++;
								?>
                                        
                                        <tr <?php echo $bgcolor ?>>
                                            <td><?php echo $i+1 ?></td> 
                                            <td><?php echo $row_pos->ref ?></td>
						                    <td><?php echo date("d-m-Y", strtotime($row_pos->date)) ?></td>
						                    <td><?php echo date("H:i", strtotime($row_pos->dlu)) ?></td>
											<td><?php echo $row_pos->shift ?></td>
											<td><?php echo $row_pos->uid ?></td>
											<td align="right"><?php echo number_format($total,0,".",",") ?></td>
											
											
                                            <!--<td><?php echo $row_pos->type ?></td>
                                            <td align="center"><?php if ($row_pos->active == 1) { ?>
                                                    <button class="btn btn-xs btn-success">
														<i class="ace-icon fa fa-check bigger-120"></i>
													</button><?php } ?>
                                            </td>
                                            <td><?php echo $row_pos->uid ?></td>-->
                    						<td><?php echo $status ?></td>
                    						<th style="text-align: center">
                    							<input type="hidden" id="ref_<?php echo $i ?>" name="ref_<?php echo $i ?>" value="<?php echo $row_pos->ref ?>"/>
                    							<label class="pos-rel">
                    								<?php if ($row_pos->closed == 1) { ?>
                                                		<span class="green">
															<i class="ace-icon fa fa-check-square-o bigger-150"></i>
														</span>
                                                	<?php } else { ?>
                                                		<!--<input type="checkbox" class='ace' id="pilih_<?php echo $i ?>" name="pilih_<?php echo $i ?>" class="ace" value="1" ><span class="lbl"></span>-->
                                                	<?php } ?>
                                                </label>
                    						</th>
                                            <td>
                                            
                                            	<?php if ($row_pos->closed == 0) { ?>
	                                                <?php if (allowupd('frmpos')==1) { ?>
	    												<a href="main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&search=<?php echo $row_pos->ref ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
	    													<span class="green">
	    														<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
	    													</span>
	    												</a>
	                                                <?php } else { ?>
	                                                	<a href="main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&search=<?php echo $row_pos->ref ?>" class="tooltip-success" data-rel="tooltip" title="Edit">
	    													<span class="green">
	    														<i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
	    													</span>
	    												</a>
	    											<?php } ?>
	                                                
	                                                <?php if (allowdel('frmpos')==1) { ?>    
	                                                    &nbsp;
	    												<a href="JavaScript:hapus('<?php echo $row_pos->ref ?>')" class="tooltip-error" data-rel="tooltip" title="Delete">
	    													<span class="red">
	    														<i class="ace-icon fa fa-trash-o bigger-120"></i>
	    													</span>
	    												</a>
	                                                <?php } ?>
                                                <?php } ?>
                                            </td>
                                                        
										</tr>
                                    
                                    <?php
                                    		$i++;
                                        }
                                    ?>
                                    
							</tbody>
							
							<tr style="font-size: 16px; font-weight: bold;">
                            	<td colspan="6" align="right">Total</td> 
                            	<td align="right"><?php echo number_format($grand_total,0,".",",") ?></td>
                            	<td></td>
                            	<td align="center">
									<!--<button type="submit" name="submit" id="submit" class="btn btn-white btn-info btn-bold" value="Closing" onClick="return confirm('Apakah yakin Anda akan Closing data?')">
										<i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
										Closing
									</button>-->
								</td>
                            </tr>
                            
						</table>
					</div>
					
					<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $i ?>"/>
					
					</form>
					
				</div>
			</div>

		</div><!-- /.col -->
	</div><!-- /.row -->
</div><!-- /.page-content -->
            			

		<!-- basic scripts -->

		<!--[if !IE]> -->
		<script src="assets/js/jquery.2.1.1.min.js"></script>

		<!-- <![endif]-->

		<!--[if IE]>
<script src="assets/js/jquery.1.11.1.min.js"></script>
<![endif]-->

		<!--[if !IE]> -->
		<script type="text/javascript">
			window.jQuery || document.write("<script src='assets/js/jquery.min.js'>"+"<"+"/script>");
		</script>

		<!-- <![endif]-->

		<!--[if IE]>
<script type="text/javascript">
 window.jQuery || document.write("<script src='assets/js/jquery1x.min.js'>"+"<"+"/script>");
</script>
<![endif]-->
		<script type="text/javascript">
			if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
		</script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<script src="assets/js/jquery-ui.custom.min.js"></script>
		<script src="assets/js/jquery.ui.touch-punch.min.js"></script>
		<script src="assets/js/chosen.jquery.min.js"></script>
		<script src="assets/js/fuelux.spinner.min.js"></script>
		<script src="assets/js/bootstrap-datepicker.min.js"></script>
		<script src="assets/js/bootstrap-timepicker.min.js"></script>
		<script src="assets/js/moment.min.js"></script>
		<script src="assets/js/daterangepicker.min.js"></script>
		<script src="assets/js/bootstrap-datetimepicker.min.js"></script>
		<script src="assets/js/bootstrap-colorpicker.min.js"></script>
		<script src="assets/js/jquery.knob.min.js"></script>
		<script src="assets/js/jquery.autosize.min.js"></script>
		<script src="assets/js/jquery.inputlimiter.1.3.1.min.js"></script>
		<script src="assets/js/jquery.maskedinput.min.js"></script>
		<script src="assets/js/bootstrap-tag.min.js"></script>

		<!-- page specific plugin scripts -->
		<script src="assets/js/jquery.dataTables.min.js"></script>
		<script src="assets/js/jquery.dataTables.bootstrap.min.js"></script>
		<script src="assets/js/dataTables.tableTools.min.js"></script>
		<script src="assets/js/dataTables.colVis.min.js"></script>

		<!-- ace scripts -->
		<script src="assets/js/ace-elements.min.js"></script>
		<script src="assets/js/ace.min.js"></script>

		<!-- inline scripts related to this page -->
		<script type="text/javascript">
			jQuery(function($) {
				//initiate dataTables plugin
				var oTable1 = 
				$('#dynamic-table')
				//.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
				.dataTable( {
					bAutoWidth: false,
					"aoColumns": [
					  { "bSortable": false },
					  null, null, null, null, null, null, null, null,  //kalau nambah kolom, null ditambahkan
					  { "bSortable": false }
					],
					"aaSorting": [],
			
					//,
					//"sScrollY": "200px",
					//"bPaginate": false,
			
					//"sScrollX": "100%",
					//"sScrollXInner": "120%",
					//"bScrollCollapse": true,
					//Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
					//you may want to wrap the table inside a "div.dataTables_borderWrap" element
			
					//"iDisplayLength": 50
			    } );
				//oTable1.fnAdjustColumnSizing();
			
			
				//TableTools settings
				TableTools.classes.container = "btn-group btn-overlap";
				TableTools.classes.print = {
					"body": "DTTT_Print",
					"info": "tableTools-alert gritter-item-wrapper gritter-info gritter-center white",
					"message": "tableTools-print-navbar"
				}
			
				//initiate TableTools extension
				var tableTools_obj = new $.fn.dataTable.TableTools( oTable1, {
					"sSwfPath": "assets/swf/copy_csv_xls_pdf.swf",
					
					"sRowSelector": "td:not(:last-child)",
					"sRowSelect": "multi",
					"fnRowSelected": function(row) {
						//check checkbox when row is selected
						try { $(row).find('input[type=checkbox]').get(0).checked = true }
						catch(e) {}
					},
					"fnRowDeselected": function(row) {
						//uncheck checkbox
						try { $(row).find('input[type=checkbox]').get(0).checked = false }
						catch(e) {}
					},
			
					"sSelectedClass": "success",
			        "aButtons": [
						{
							"sExtends": "copy",
							"sToolTip": "Copy to clipboard",
							"sButtonClass": "btn btn-white btn-primary btn-bold",
							"sButtonText": "<i class='fa fa-copy bigger-110 pink'></i>",
							"fnComplete": function() {
								this.fnInfo( '<h3 class="no-margin-top smaller">Table copied</h3>\
									<p>Copied '+(oTable1.fnSettings().fnRecordsTotal())+' row(s) to the clipboard.</p>',
									1500
								);
							}
						},
						
						{
							"sExtends": "csv",
							"sToolTip": "Export to CSV",
							"sButtonClass": "btn btn-white btn-primary  btn-bold",
							"sButtonText": "<i class='fa fa-file-excel-o bigger-110 green'></i>"
						},
						
						{
							"sExtends": "pdf",
							"sToolTip": "Export to PDF",
							"sButtonClass": "btn btn-white btn-primary  btn-bold",
							"sButtonText": "<i class='fa fa-file-pdf-o bigger-110 red'></i>"
						},
						
						{
							"sExtends": "print",
							"sToolTip": "Print view",
							"sButtonClass": "btn btn-white btn-primary  btn-bold",
							"sButtonText": "<i class='fa fa-print bigger-110 grey'></i>",
							
							"sMessage": "<div class='navbar navbar-default'><div class='navbar-header pull-left'><a class='navbar-brand' href='#'><small>Optional Navbar &amp; Text</small></a></div></div>",
							
							"sInfo": "<h3 class='no-margin-top'>Print view</h3>\
									  <p>Please use your browser's print function to\
									  print this table.\
									  <br />Press <b>escape</b> when finished.</p>",
						}
			        ]
			    } );
				//we put a container before our table and append TableTools element to it
			    $(tableTools_obj.fnContainer()).appendTo($('.tableTools-container'));
				
				//also add tooltips to table tools buttons
				//addding tooltips directly to "A" buttons results in buttons disappearing (weired! don't know why!)
				//so we add tooltips to the "DIV" child after it becomes inserted
				//flash objects inside table tools buttons are inserted with some delay (100ms) (for some reason)
				setTimeout(function() {
					$(tableTools_obj.fnContainer()).find('a.DTTT_button').each(function() {
						var div = $(this).find('> div');
						if(div.length > 0) div.tooltip({container: 'body'});
						else $(this).tooltip({container: 'body'});
					});
				}, 200);
				
				
				//lookup
				if(!ace.vars['touch']) {
					$('.chosen-select').chosen({allow_single_deselect:true}); 
					//resize the chosen on window resize
			
					$(window)
					.off('resize.chosen')
					.on('resize.chosen', function() {
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					}).trigger('resize.chosen');
					//resize chosen on sidebar collapse/expand
					$(document).on('settings.ace.chosen', function(e, event_name, event_val) {
						if(event_name != 'sidebar_collapsed') return;
						$('.chosen-select').each(function() {
							 var $this = $(this);
							 $this.next().css({'width': $this.parent().width()});
						})
					});
			
			
					$('#chosen-multiple-style .btn').on('click', function(e){
						var target = $(this).find('input[type=radio]');
						var which = parseInt(target.val());
						if(which == 2) $('#form-field-select-4').addClass('tag-input-style');
						 else $('#form-field-select-4').removeClass('tag-input-style');
					});
				}
				//end lookup
				
				
				//ColVis extension
				var colvis = new $.fn.dataTable.ColVis( oTable1, {
					"buttonText": "<i class='fa fa-search'></i>",
					"aiExclude": [0, 6],
					"bShowAll": true,
					//"bRestore": true,
					"sAlign": "right",
					"fnLabel": function(i, title, th) {
						return $(th).text();//remove icons, etc
					}
					
				}); 
				
				//style it
				$(colvis.button()).addClass('btn-group').find('button').addClass('btn btn-white btn-info btn-bold')
				
				//and append it to our table tools btn-group, also add tooltip
				$(colvis.button())
				.prependTo('.tableTools-container .btn-group')
				.attr('title', 'Show/hide columns').tooltip({container: 'body'});
				
				//and make the list, buttons and checkboxed Ace-like
				$(colvis.dom.collection)
				.addClass('dropdown-menu dropdown-light dropdown-caret dropdown-caret-right')
				.find('li').wrapInner('<a href="javascript:void(0)" />') //'A' tag is required for better styling
				.find('input[type=checkbox]').addClass('ace').next().addClass('lbl padding-8');
			
			
				
				/////////////////////////////////
				//table checkboxes
				$('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);
				
				//select/deselect all rows according to table header checkbox
				$('#dynamic-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) tableTools_obj.fnSelect(row);
						else tableTools_obj.fnDeselect(row);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#dynamic-table').on('click', 'td input[type=checkbox]' , function(){
					var row = $(this).closest('tr').get(0);
					if(!this.checked) tableTools_obj.fnSelect(row);
					else tableTools_obj.fnDeselect($(this).closest('tr').get(0));
				});
				
			
				
				
					$(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
					e.stopImmediatePropagation();
					e.stopPropagation();
					e.preventDefault();
				});
				
				
				//And for the first simple table, which doesn't have TableTools or dataTables
				//select/deselect all rows according to table header checkbox
				var active_class = 'active';
				$('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function(){
					var th_checked = this.checked;//checkbox inside "TH" table header
					
					$(this).closest('table').find('tbody > tr').each(function(){
						var row = this;
						if(th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
						else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
					});
				});
				
				//select/deselect a row when the checkbox is checked/unchecked
				$('#simple-table').on('click', 'td input[type=checkbox]' , function(){
					var $row = $(this).closest('tr');
					if(this.checked) $row.addClass(active_class);
					else $row.removeClass(active_class);
				});
			
				
				//datepicker plugin
				//link
				$('.date-picker').datepicker({
					autoclose: true,
					todayHighlight: true
				})
				//show datepicker when clicking on the icon
				.next().on(ace.click_event, function(){
					$(this).prev().focus();
				});
			
				/********************************/
				//add tooltip for small view action buttons in dropdown menu
				$('[data-rel="tooltip"]').tooltip({placement: tooltip_placement});
				
				//tooltip placement on right or left
				function tooltip_placement(context, source) {
					var $source = $(source);
					var $parent = $source.closest('table')
					var off1 = $parent.offset();
					var w1 = $parent.width();
			
					var off2 = $source.offset();
					//var w2 = $source.width();
			
					if( parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2) ) return 'right';
					return 'left';
				}
			
			})
			
			
		</script>
