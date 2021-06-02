<script type="text/javascript">
	function hapus(id) {
		if (confirm('Apakah Anda yakin akan menghapus data ini?')) {
			document.location.href = "main.php?menu=app&act=<?php echo obraxabrix('item_view') ?>&mxKz=xm8r389xemx23xb2378e23&id="+id+" ";
		}
	}
</script>


<?php

$code	             	=    $_REQUEST['code'];
$old_code		    	=    $_REQUEST['old_code'];
$name            		=    $_REQUEST['name'];
$item_group_id       	=    $_REQUEST['item_group_id'];
$all			       	=    $_REQUEST['all'];

if($all == 1 || $all == true) {
	$all2 = "checked";
}
		
?>

<script type="text/javascript">
	function excel_export() {
		var code		=	document.getElementById('code').value;
		//var old_code	=	document.getElementById('old_code').value;
		var name		=	document.getElementById('name').value;
		var item_group_id	=	document.getElementById('item_group_id').value;
		var all			=	document.getElementById('all').checked;
		
		if(all == true) {
			all = 1;
		}
		if(all == false) {
			all = 0;
		}
		
		document.location.href = '<?php echo $__folder ?>app/item_xls.php?all='+all+'&code='+code+'&name='+name+'&item_group_id='+item_group_id;
	}
</script>

<div class="page-content">		
		
	<div class="row">
		<div class="col-xs-12">
                
            <?php
				include("app/exec/pos_insert.php");
			?>
                
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<!-- div.dataTables_borderWrap -->
					
					<form class="form-horizontal" role="form" action="" method="post" name="pos_view2" id="pos_view2" enctype="multipart/form-data">
					<div>
						<table id="dynamic-table" class="table table-striped table-bordered table-hover">
							<thead>
								<tr>
                                    <th class="center" style="font-weight:bold ">No.</th>
                                    <th>Date</th>
                                    <th>Kasir</th>
			                    	<th>Jumlah Sales</th>
			                    	<th>Approval</th>
								</tr>
							</thead>

							<tbody>
                                <?php
                                	$strloc = "";
									if (area_manager_location() != "") {
										$loc_id = area_manager_location();
										$sqlstr = "select a.location_id from store_unit_detail a left join store_unit b on a.id=b.id where b.location_id='$loc_id' order by a.id";
										$sql=$dbpdo->prepare($sqlstr);
										$sql->execute();
										while($data = $sql->fetch(PDO::FETCH_OBJ)) {
											if($strloc == "") {
												$strloc = "'".$data->location_id."'";	
											} else {
												$strloc = $strloc . ", '".$data->location_id."'";
											}
										}
									}
									
									if (supervisor_location() != "") {
										$strloc = "'".supervisor_location()."'";
									}
									
									/*if (user_location_central() != "") {
										$strloc = "'ndf'";
									}*/
									
									if($_SESSION['adm'] == 1) {
										$strloc = "";
									}
									
									$sql=$select->get_pos_overlimit($strloc);
									while($row_item=$sql->fetch(PDO::FETCH_OBJ)){
									
									$i++;
									
										
										
								?>
                                            
                                        <tr>
                                            <td align="center"><?php echo $i ?></td>
                                            <td><?php echo date('d-m-Y', strtotime($row_item->date)) ?></td>
                                            <td><?php echo $row_item->uid ?></td>
					                    	<td align="right"><?php echo number_format($row_item->amount,0,'.',',') ?></td>
                                            <th style="text-align: center">
                                            	<input type="hidden" id="ref_<?php echo $i ?>" name="ref_<?php echo $i ?>" value="<?php echo $row_item->ref ?>"/>
                                            	<?php if($row_item->limit_approved == 0) { ?>
                                            		<input type="checkbox" class='ace' id="pilih_<?php echo $i ?>" name="pilih_<?php echo $i ?>" class="ace" value="1" ><span class="lbl"></span>                                   
                                            	<?php } else { ?>
                                            		<span class="green">
														<i class="ace-icon fa fa-check-square-o bigger-150"></i>
													</span>
                                            	<?php } ?>
                                            </th>
                                            
										</tr>
                                    
                                    <?php
                                        }
                                    ?>
                                    
							</tbody>
						</table>
						
						<div class="clearfix form-actions">
							<div class="col-md-offset-3 col-md-9">
		                        
		                        <?php if (allow("pos_overlimit")==1) { ?>
		                            <input type="submit" name="submit" id="submit" class='btn btn-primary' value="Approval" />
		                        <?php } ?>
								         
							</div>
						</div>
						
						<input type="hidden" id="jmldata" name="jmldata" value="<?php echo $i ?>"/>
						
						</form>
					</div>
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
					  null, null, null,   //kalau nambah kolom, null ditambahkan
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
					
					"sRowSelector": "td:not(:lasset-child)",
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
					"aiExclude": [0, 20],
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
