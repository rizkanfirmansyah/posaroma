<script src="assets/js/appcustom.js"></script>
<script type="text/javascript" src="js/buttonajax.js"></script>

<script language="javascript">
	function cekinput(fid) {  
	  var arrf = fid.split(',');
	  for(i=0; i < arrf.length; i++) {
		if(document.getElementById(arrf[i]).value=='') {       
		  
		  if (document.getElementById(arrf[i]).name=='date') {
			alert('Date cannot empty!');				
		  }
		  
		  if (document.getElementById(arrf[i]).name=='location_id') {
			alert('Location cannot empty!');				
		  }
		  		  
		  return false
		} 
										
	  }		 
	}
		
</script>

<script>
	function number_format(number, decimals, dec_point, thousands_sep) {
		number = (number + '')
		.replace(/[^0-9+\-Ee.]/g, '');
	  
	  var n = !isFinite(+number) ? 0 : +number,
		prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
		sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
		dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
		s = '',
		toFixedFix = function(n, prec) {
		  var k = Math.pow(10, prec);
		  return '' + (Math.round(n * k) / k)
			.toFixed(prec);
		};
	  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
	  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n))
		.split('.');
	  if (s[0].length > 3) {
		s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
	  }
	  if ((s[1] || '')
		.length < prec) {
		s[1] = s[1] || '';
		s[1] += new Array(prec - s[1].length + 1)
		  .join('0');
	  }
	  return s.join(dec);
	}
	
	
	function formatangka(field) {
		 //a = rci.amt.value;	 
		 a = document.getElementById(field).value;
		 //alert(a);
		 b = a.replace(/[^\d-.]/g,""); //b = a.replace(/[^\d]/g,"");
		 c = "";
		 panjang = b.length;
		 j = 0;
		 for (i = panjang; i > 0; i--)
		 {
			 j = j + 1;
			 if (((j % 3) == 1) && (j != 1))
			 {
			 	c = b.substr(i-1,1) + "," + c;
			 } else {
			 	c = b.substr(i-1,1) + c;
			 }
		 }
		 //rci.amt.value = c;
		 c = c.replace(",.",".");
		 c = c.replace(".,",".");
		 document.getElementById(field).value = c;	
	}
</script>

<script type="text/javascript">
	var request;
	var dest;
	
	function loadHTMLPost2(URL, destination, button, getId){        
		dest = destination;	
		str = getId + '=' + document.getElementById(getId).value;		
		//str ='pchordnbr2='+ document.getElementById('pchordnbr2').value;
		var str = str + '&button=' + button;
		
		if (window.XMLHttpRequest){
			request = new XMLHttpRequest();
			request.onreadystatechange = processStateChange;
			request.open("POST", URL, true);
			request.setRequestHeader("Content-Type","application/x-www-form-urlencoded; charset=UTF-8");
			request.send(str);		
					
		} else if (window.ActiveXObject) {
			request = new ActiveXObject("Microsoft.XMLHTTP");
			if (request) {
				request.onreadystatechange = processStateChange;
				request.open("POST", URL, true);
				request.send();				
			}
		}
				
	}
	 
</script>

<script language="javascript">

	function refresh(){
		var location_id		= '';
		var item_group_id	= '';
		var item_subgroup_id	= '';
		var item_code		= '';
		
		location_id			= document.getElementById('location_id').value;
		item_group_id		= document.getElementById('item_group_id').value;
		item_subgroup_id	= document.getElementById('item_subgroup_id').value;
		item_code			= document.getElementById('item_code').value;
		
		document.forms['item_barcode2'].submit();
		
		
		return false;
	}
	
	function submitForm(tipe)
    {
    	
    	if(tipe == 'print') {
			//document.getElementById("delord_view").action = "app/delord_print.php";
			$("#item_barcode2").attr('action', 'main.php?menu=app&act=95d62f57ee055107bf488696922cb664')
			   .attr('target', '_BLANK');
			$("#item_barcode2").submit();
			
		}
		
		if(tipe == 'refresh') {
			$("#item_barcode2").attr('action', 'main.php?menu=app&act=95d62f57ee055107bf488696922cb664')
			   //.attr('target', '_BLANK');
			$("#item_barcode2").submit();
		}
		
		if(tipe == 'view') {
			//document.getElementById("delord_view").action = "app/delord_print.php";
			/*$("#item_barcode").attr('action', 'app/item_barcode_view.php')*/
			$("#item_barcode").attr('action', 'app/barcode_item.php')
			   .attr('target', '_BLANK');
			$("#item_barcode").submit();
		}
		
		return false;
  			 
    }		
    
    
    function select_barcode(jmldata){ 
		var i=0;
		var item_code = '';
		var item_code_all = '';
		
		//var cetakall = document.getElementById('cetakall').checked;
		
		for(i=0; i<=jmldata; i++){
			
			check = document.getElementById('select_'+i).checked;
			
			if (check) {				
				
				item_code = document.getElementById('item_code_'+i).value;
				
				if(item_code_all == '') {
					item_code_all = item_code;
				} else {
					item_code_all = item_code_all + '/' + item_code;
				}
				
				//alert(item_code_all);
																	
			} 
			
			$('#item_code_id').html('<input type="hidden" id="item_code_all" name="item_code_all" value="'+ item_code_all +'" >');		
		}
					
			
	    			
		return false	
	}
	
    
</script>


<div class="page-content">
	
	<div class="row">
		<div class="col-xs-12">
			
			<?php 
				$ref = $_GET['search'];
						
				//jika saat add data, maka data setelah save kosong
				if ($_POST['submit'] == 'Save') { $ref = ''; }
				//-----------------------------------------------/\
						
				//$ref2 = notran(date('y-m-d'), 'frmitem_barcode', '', '', ''); 
				if ($_POST['submit'] == 'Save') {	
					
					//include("app/exec/item_barcode_insert.php"); 
				}
				
				$location_id		= $_POST['location_id'];
				$item_group_id		= $_POST['item_group_id'];
				$item_subgroup_id	= $_POST['item_subgroup_id'];
				$item_code			= $_POST['item_code'];
				$order_by			= $_POST['order_by'];
				
				$date = date("d-m-Y");
				$order_by = "0";
				
				if ($ref != "") {
					$sql=$select->list_item_barcode($ref);
					$row_item_barcode=fetch_object($sql);	
					
					$ref2 = $row_item_barcode->ref;	
					$date = date("d-m-Y", strtotime($row_item_barcode->date));
					
					
				}	
				
					
			?>
			
		
			<form class="form-horizontal" action="" method="post" name="item_barcode2" id="item_barcode2" enctype="multipart/form-data" >
				<input type="hidden" id="old_location_id" name="old_location_id" value="<?php echo $row_item_barcode->location_id ; ?>" >
				
				<!--<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Central/Unit *)</label>
                    <div class="col-sm-4">
                      <select id="location_id" name="location_id" data-placeholder="..." class="chosen-select form-control" style="width: auto" >
                        <option value=""></option>
                        <?php 
                        	combo_select_active("warehouse","id","name","active","1",$location_id)
                        ?>	                            
                      </select>
					</div>
				</div>-->
				
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kelompok Produk</label>
                    <div class="col-sm-4">
                      <select id="item_group_id" name="item_group_id" data-placeholder="..." class="chosen-select form-control" onchange="loadHTMLPost2('app/item_ajax.php','item_subgroup_id2','getsubgroup_id','item_group_id')" style="width: auto" >
                        <option value=""></option>
                        <?php 
                        	combo_select_active("item_group","id","name","active","1",$item_group_id) 
                        ?>	                            
                      </select>
					</div>
				</div>
				
				<?php /*					
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Item Sub Group</label>
                    <div class="col-sm-4" id="item_subgroup_id2">
                      <select id="item_subgroup_id" name="item_subgroup_id" data-placeholder="..." class="chosen-select form-control" style="width: auto" >
                        <option value=""></option>
                        <?php 
                        	//combo_select_active("item_subgroup","id","name","active","1",$item_subgroup_id) 
                            select_item_subgroup($item_group_id,$item_subgroup_id);
                        ?>	                            
                      </select>
					</div>
				</div>*/ ?>
									
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Produk</label>
                    <div class="col-sm-4">
                      <select id="item_code" name="item_code" data-placeholder="..." class="chosen-select form-control" style="width: auto" >
                        <option value=""></option>
                        <?php 
                        	combo_select_active("item","syscode","name","active","1",$item_code)                                                
                        ?>	                            
                      </select>
					</div>
				</div>										
				
								
				<!--<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Semua</label>
					<div class="col-sm-4">
						<input type="checkbox" name="all" id="all" class="ace" value="1" /><span class="lbl"></span>								
					</div>
				</div>-->
				
				<?php /*
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Order By</label>
                    <div class="col-sm-4">
                      <select id="order_by" name="order_by" data-placeholder="..." class="chosen-select form-control" style="width: auto" >
                        <option value=""></option>
                        <?php 
                        	select_orderby_item($order_by) 
                        ?>	                            
                      </select>
					</div>
				</div>*/ ?>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">&nbsp;</label>
	                <div class="col-sm-3">
	                  <input type="submit" name="submit" id="submit" class='btn btn-primary' value="Preview" onclick="submitForm('preview')" />
					</div>
			   </div>
										
				
			</form>
		
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-xs-12">
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					
					<form class="form-horizontal" action="" method="post" name="item_barcode" id="item_barcode" enctype="multipart/form-data" >  
						
					<div class="form-group">
						<input type="submit" name="submit" class="btn btn-primary" value="Preview Barcode" onclick="submitForm('view')" >
					</div>
					
					<input type="hidden" id="item_group_id" name="item_group_id" value="<?php echo $item_group_id ?>" />
					<input type="hidden" id="item_code" name="item_code" value="<?php echo $item_code ?>" />
					
					<div class="form-group">
	                    <label class="col-sm-3 control-label no-padding-right">Cetak per Produk</label>
	                    <div class="col-sm-2">
	                      	<input type="text" id="copy__" name="copy__" class="form-control" onkeyup="formatangka('copy__')" autocomplete="off" value="10" />
						</div>
					</div>
					
					<table id="simple-table" class="table table-striped table-bordered table-hover" style="font-size: 12px">
						<?php
							$sql = $selectview->list_item_label($item_code, $uom_code, $item_group_id, $item_subgroup_id, $all, $item_code2, $date_from, $date_to);	
							$jmldata = $sql->rowCount();
						?>
						
						<input type="hidden" id="jml" name="jml" value="<?php echo $jmldata ?>" />
						
						<thead>
							<tr>
								<!--<th>No. <i class="fa fa-sort"></i></th>
                                <th class="center">
									<label class="pos-rel">
										<input type="checkbox" id="cetakall" name="cetakall" class="ace" value="1" onClick="checklistall(<?php echo $jmldata ?>)" /><span class="lbl"></span>
									</label>
								</th>
                                <th>Kode Barang <i class="fa fa-sort"></i></th>
								<th>Barcode <i class="fa fa-sort"></i></th>
								<th>Kelompok <i class="fa fa-sort"></i></th>
								<th>Nama Barang <i class="fa fa-sort"></i></th>-->
								
								<th>No.</th>
								<th class="center">
									<label class="pos-rel">
										<input type="checkbox" id="cetakall" name="cetakall" class="ace" value="1" onClick="select_barcode(<?php echo $jmldata ?>)" /><span class="lbl"></span>
									</label>	
																	
								</th>
								<th>Kode-1</th>
								<th>Kode-2</th>
								<th>Nama</th> 
								<th>Satuan</th>
							</tr>
						</thead>

						<tbody>
							<?php			
								$sql=$select->list_item_barcode($location_id, $item_group_id, $item_subgroup_id, $item_code, $order_by);
								$jmldata = $sql->rowCount();

								$j = 0;
								while($row_item_set_price_detail=$sql->fetch(PDO::FETCH_OBJ)) { 
			
									$item_code = $row_item_set_price_detail->syscode;
									$uom_code = $row_item_set_price_detail->uom_code_sales;
									$uom_code_stock = $row_item_set_price_detail->uom_code_stock;
									
									/*$sql2 = $select->list_get_set_price($location_id, $item_code, $uom_code);
									$dataset = $sql2->fetch(PDO::FETCH_OBJ);
									
									$current_price = number_format($dataset->current_price, 0, '.', ',');							
									$last_price = number_format($dataset->last_price, 0, '.', ',');
									$hpp = number_format($dataset->cogs, 0, '.', ',');*/
									
																
									
							?>
                                    <input type="hidden" id="location_id" name="location_id" value="<?php echo $location_id; ?>" >
									<input type="hidden" id="item_group_id" name="item_group_id" value="<?php echo $item_group_id; ?>" >
									<input type="hidden" id="item_subgroup_id" name="item_subgroup_id" value="<?php echo $item_subgroup_id; ?>" >
									<input type="hidden" id="date" name="date" value="<?php echo $date; ?>" >
									
									<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $jmldata; ?>" >
									<input type="hidden" id="item_code_<?php echo $j ?>" name="item_code_<?php echo $j ?>" value="<?php echo $row_item_set_price_detail->syscode; ?>" >
									
									<input type="hidden" id="uom_code_stock_<?php echo $j ?>" name="uom_code_stock_<?php echo $j ?>" value="<?php echo $uom_code_stock; ?>" >
                                       
									 <tr>   
									 	<td><?php echo $j+1 ?></td>
									 	<th style="text-align: center">
											<!--<label class="pos-rel">
												<input type="checkbox" id="cetak_<?php echo $j; ?>" name="cetak_<?php echo $j; ?>" class="ace" value="1" onClick="checklist(<?php echo $j ?>)" /><span class="lbl"></span>
											</label>-->
											
											<label class="pos-rel">
												<input type="checkbox" id="select_<?php echo $j ?>" class="ace" name="select_<?php echo $j ?>" onClick="select_barcode(<?php echo $jmldata ?>)" value="1" /><span class="lbl"></span>
											</label>
											
										</th>
										  
									    <td>							
											<?php 
												echo $row_item_set_price_detail->old_code;
											?>
										</td>
										<td>							
											<?php 
												echo $row_item_set_price_detail->code;
											?>
										</td>
										<td>							
											<?php 
												echo $row_item_set_price_detail->name;
											?>	

										</td>
										<!--<td align="center">
											<?php
												echo $row_item_set_price_detail->uom_code_stock;
											?>
										</td>-->
										
										<td align="center">
											<?php
												echo $row_item_set_price_detail->uom_code_sales;
											?>
										</td>
										
										<!--<td align="center">
											<?php
												echo $row_item_set_price_detail->uom_code_purchase;
											?>
										</td>
										
										<td align="right">
											<?php
												echo $current_price;
											?>
										</td>-->
										
									</tr>	
									    
                                <?php
                                		$j++;
                                    }
                                ?>
                                
						</tbody>
						
					</table>
					
					<br>
					
					<div id="item_code_id">
				    	<input type="hidden" id="item_code_all" name="item_code_all" value=""/>
				    </div>	
						
					<input type="submit" name="submit" class="btn btn-primary" value="Preview Barcode" onclick="submitForm('view')" >
					
					</form>
						
				</div><!-- /.span -->
			</div><!-- /.row -->

			<div style="display: none;" >
			<table id="dynamic-table">
			</table>
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
					  null, null, null,  
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
				
				
				
				//ColVis extension
				var colvis = new $.fn.dataTable.ColVis( oTable1, {
					"buttonText": "<i class='fa fa-search'></i>",
					"aiExclude": [0, 16],
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
			
				//or change it into a date range picker
				$('.input-daterange').datepicker({autoclose:true});
			
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
	</body>
</html>


























