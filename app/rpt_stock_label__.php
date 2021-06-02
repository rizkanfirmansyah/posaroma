<script type="text/javascript" src="js/buttonajax.js"></script>

<script>
	var item_code = ''; 
	var item_code3 = '';
	
	function checklist(lne) {
		
		var slc = document.getElementById('cetak_' + lne).checked;
		
		if (slc) {
			
			item_code3 = document.getElementById('item_code_' + lne).value;
			item_code = item_code.replace(item_code3,"");
			
			item_code = item_code + '|' + document.getElementById('item_code_' + lne).value;
			
			$('#item_code_id').html('<input type="hidden" size="100" id="item_code4" name="item_code4" value="'+ item_code +'" >');
			
		} else {
			
			item_code3 = document.getElementById('item_code_' + lne).value;
			item_code = item_code.replace(item_code3,"");
			
			$('#item_code_id').html('<input type="hidden" size="100" id="item_code4" name="item_code4" value="'+ item_code +'" >');
			
		}
		
	}
</script>


<script language="javascript">
	function submitForm(tipe)
    {
		
		if(tipe == 'label_view') {
			//document.getElementById("delord_view").action = "app/delord_print.php";
			$("#rpt_stock_label").attr('action', 'app/rpt_stock_harga.php')
			   .attr('target', '_BLANK');
			$("#rpt_stock_label").submit();
		}
		
		
		if(tipe == 'label_pdf') {
			//document.getElementById("delord_view").action = "app/delord_print.php";
			$("#rpt_stock_label").attr('action', 'app/rpt_stock_harga_pdf.php')
			   .attr('target', '_BLANK');
			$("#rpt_stock_label").submit();
		}
		
  		return false;	 
    }		
    
    if(tipe == 'preview') {
		//document.getElementById("delord_view").action = "app/delord_print.php";
		$("#rpt_stock_label").attr('action', '')
			.attr('target', '_self');
		$("#rpt_stock_label").submit();
	}
	
    function focusNext(elemName, evt) 
	{
	    evt = (evt) ? evt : event;
	    var charCode = (evt.charCode) ? evt.charCode :
	        ((evt.which) ? evt.which : evt.keyCode);
	    if (charCode == 13) 
		 {
			document.getElementById(elemName).focus();
	      return false;
	    }
	    return true;
	}
	
</script>

<script type="text/javascript">
	function excel_export() {
		item_code			=	document.getElementById('item_code').value;
		location_id			=	document.getElementById('location_id').value;
		uom_code			=	document.getElementById('uom_code').value;
		item_group_id		=	document.getElementById('item_group_id').value;
		//item_subgroup_id	=	document.getElementById('item_subgroup_id').value;
		date_from			=	document.getElementById('date_from').value;
		date_to				=	document.getElementById('date_to').value;
		all					=	document.getElementById('all').checked;
		
		if(all == true) { all = 1}
		if(all == false) { all = 0}
		
		document.location.href = "app/rpt_stock_xls.php?item_code="+item_code+"&location_id="+location_id+"&uom_code="+uom_code+"&date_from="+date_from+"&date_to="+date_to+"&all="+all+"&item_group_id="+item_group_id;	
	}
</script>


<script type="text/javascript">
	function cetak_label() {
		
		item_code_id		=	document.getElementById('item_code_id').value;
		
		document.location.href = "app/rpt_stock_harga.php?item_code_id="+item_code_id;	
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

<?php

$item_code2		= $_REQUEST['item_code2'];
$item_code		= $_REQUEST['item_code'];
$location_id	= $_REQUEST['location_id'];
$uom_code		= $_REQUEST['uom_code'];
$date_from		= $_REQUEST['date_from'];
$date_to		= $_REQUEST['date_to'];
$item_group_id	= $_REQUEST['item_group_id'];
$item_subgroup_id		= $_REQUEST['item_subgroup_id'];
$all		= $_REQUEST['all'];


if($date_from == "") {
	$date_from = "";
}

if($date_to == "") {
	$date_to = "";
}

?>                     
                        
<div class="page-content">
    
    <div class="row">
		<div class="col-xs-12">
		
			<form class="form-horizontal" role="form" action="" method="post" name="rpt_stock" id="rpt_stock" class="form-horizontal" enctype="multipart/form-data" >
				
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Code/Barcode Barang</label>
                    <div class="col-sm-4">
                      <input type="text" id="item_code2" name="item_code2" style="font-size: 18px; min-width: 100px" class="form-control" autofocus="" onKeyPress="return focusNext('submit',event)" value="" >
					</div>
				</div>
				
				
				
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Nama Barang</label>
                    <div class="col-sm-4">
                      <select id="item_code" name="item_code" data-placeholder="..." class="chosen-select form-control" style="width: auto">
                      	<option value=""></option>
                        <?php select_item($item_code) ?>	                            
                      </select>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Kelompok</label>
                    <div class="col-sm-4">
                      <select id="item_group_id" name="item_group_id" data-placeholder="..." class="chosen-select form-control" onchange="loadHTMLPost2('app/item_ajax.php','item_subgroup_id2','getsubgroup_id','item_group_id')" style="width: auto" >
                        <option value=""></option>
                        <?php 
                        	combo_select_active("item_group","id","name","active","1",$item_group_id) 
                        ?>	                            
                      </select>
					</div>
				</div>
				
				<div class="form-group">
                    <label class="col-sm-3 control-label no-padding-right">Satuan</label>
                    <div class="col-sm-4">
                      <select id="uom_code" name="uom_code" data-placeholder="..." class="chosen-select form-control" style="width: auto">
                      	<option value=""></option>
                        <?php select_uom($uom_code) ?>	                            
                      </select>
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php if($lng==1) { echo 'From Date'; } else { echo 'Dari Tanggal'; } ?></label>
					<div class="col-sm-3">
						<input type="text" id="date_from" name="date_from" style="font-size: 12px" class="form-control date-picker" data-date-format="dd-mm-yyyy" value="<?php echo $date_from ?>">								
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1"><?php if($lng==1) { echo 'To Date'; } else { echo 's/d Tanggal'; } ?></label>
					<div class="col-sm-3">
						<input type="text" id="date_to" name="date_to" style="font-size: 12px" class="form-control date-picker" data-date-format="dd-mm-yyyy" value="<?php echo $date_to ?>">								
					</div>
				</div>
				
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right">Semua</label>
					<div class="col-sm-4">
						<input class="uniform" type="checkbox" name="all" id="all" value="1" />								
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">&nbsp;</label>
	                <div class="col-sm-3">
	                  <input type="submit" name="submit" id="submit" class='btn btn-primary' value="Preview" onclick="submitForm('preview')" />
					</div>
			   </div>
				
              <!--<div class="form-group">
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">&nbsp;</label>
	                <div class="col-sm-3">
	                  <input type="submit" name="submit" id="submit" class='btn btn-primary' value="Cetak Label" onclick="submitForm('label_view')" />
					</div>
			  </div>-->
			  				  
					  								
				
			</form>
		
		</div>
	</div>
	
	
	<div class="row">
		<div class="col-xs-12">
                
               
			<!-- PAGE CONTENT BEGINS -->
			<div class="row">
				<div class="col-xs-12">
					<div class="clearfix">
						<div class="pull-right tableTools-container"></div>
					</div>
					<!-- div.dataTables_borderWrap -->
					<div>
						<form role="form" action="" method="post" name="rpt_stock_label" id="rpt_stock_label" enctype="multipart/form-data" />
						
						<div class="form-group">
							<input type="submit" name="submit" id="submit" class='btn btn-primary' value="Cetak Label" onclick="submitForm('label_view')" />
							
							<input type="submit" name="submit" id="submit" class='btn btn-primary' value="Cetak Label PDF" onclick="submitForm('label_pdf')" />
						</div>
						
						<!--<table id="dynamic-table" class="table table-striped table-bordered table-hover">-->
						<!--<table id="simple-table" class="table table-striped table-bordered table-hover" style="font-size: 12px">-->
						<table id="simple-table" class="table table-striped table-bordered table-hover">
						
							
							<thead>
								<tr>
									<!--<th>No. <i class="fa fa-sort"></i></th>-->
                                    <th class="center">
										<label class="pos-rel">
											<input type="checkbox" class="ace" />
											<span class="lbl"></span>
										</label>
									</th>
                                    <th>Kode Barang <i class="fa fa-sort"></i></th>
									<th>Barcode <i class="fa fa-sort"></i></th>
									<th>Kelompok <i class="fa fa-sort"></i></th>
									<th>Nama Barang <i class="fa fa-sort"></i></th>
                                        
								</tr>
							</thead>

							<tbody>
                                <?php			
									$j = 0;
									$sql = $selectview->list_item_label($item_code, $uom_code, $item_group_id, $item_subgroup_id, $all, $item_code2, $date_from, $date_to);	
									$jmldata = $sql->rowCount();
									while ($rpt_item_view=$sql->fetch(PDO::FETCH_OBJ)) {
										
									$j++;
										
								?>
                                        
                                         <input type="hidden" name="item_code_<?php echo $j; ?>" id="item_code_<?php echo $j; ?>" value="<?php echo $rpt_item_view->syscode ?>" />
                                           
										 <tr>   
										 	<!--<td><?php echo $j ?></td>-->
										 	<td align="center">
												<!--<label class="pos-rel">
													<input type="checkbox" id="cetak_<?php echo $j; ?>" name="cetak_<?php echo $j; ?>" class="ace" value="1" onClick="checklist(<?php echo $j ?>)" /><span class="lbl"></span>
												</label>-->
												
												<label class="pos-rel">
													<input type="checkbox" class="ace" />
													<span class="lbl"></span>
												</label>
											</td>
											  
										    <td><?php echo $rpt_item_view->code ?></td>
											<td><?php echo $rpt_item_view->old_code ?></td>
											<td><?php echo $rpt_item_view->item_group_name ?></td>
											<td><?php echo $rpt_item_view->name ?></td>
											
										</tr>	
										    
                                    <?php
                                        }
                                    ?>
                                    
                                    <tr style="font-size: 18px; font-weight: bold;">
                                    	<td colspan="5" align="right">Total Data</td>
                                    	<td><?php echo $jmldata ?></td>
                                    </tr>
                                    
							</tbody>
							
							
							
							<div id="item_code_id"></div>
							
							
						</table>
						
						<br>
						
						<input type="submit" name="submit" id="submit" class='btn btn-primary' value="Cetak Label" onclick="submitForm('label_view')" />
						
						</form>
						
					</div>
				</div>
			</div>

		</div><!-- /.col -->
	</div><!-- /.row -->
	
	
	
	
</div><!-- /.page-content -->






<!--[if !IE]> -->
<script type="text/javascript">
	window.jQuery || document.write("<script src='assets/js/jquery.min.js'>"+"<"+"/script>");
</script>

<!-- <![endif]-->

<script type="text/javascript">
	if('ontouchstart' in document.documentElement) document.write("<script src='assets/js/jquery.mobile.custom.min.js'>"+"<"+"/script>");
</script>
<script src="assets/js/bootstrap.min.js"></script>

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
  <script src="assets/js/excanvas.min.js"></script>
<![endif]-->
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
		$('#id-disable-check').on('click', function() {
			var inp = $('#form-input-readonly').get(0);
			if(inp.hasAttribute('disabled')) {
				inp.setAttribute('readonly' , 'true');
				inp.removeAttribute('disabled');
				inp.value="This text field is readonly!";
			}
			else {
				inp.setAttribute('disabled' , 'disabled');
				inp.removeAttribute('readonly');
				inp.value="This text field is disabled!";
			}
		});
	
	
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
	
	
		$('[data-rel=tooltip]').tooltip({container:'body'});
		$('[data-rel=popover]').popover({container:'body'});
		
		$('textarea[class*=autosize]').autosize({append: "\n"});
		$('textarea.limited').inputlimiter({
			remText: '%n character%s remaining...',
			limitText: 'max allowed : %n.'
		});
	
		$.mask.definitions['~']='[+-]';
		$('.input-mask-date').mask('99/99/9999');
		$('.input-mask-phone').mask('(999) 999-9999');
		$('.input-mask-eyescript').mask('~9.99 ~9.99 999');
		$(".input-mask-product").mask("a*-999-a999",{placeholder:" ",completed:function(){alert("You typed the following: "+this.val());}});
	
	
	
		$( "#input-size-slider" ).css('width','200px').slider({
			value:1,
			range: "min",
			min: 1,
			max: 8,
			step: 1,
			slide: function( event, ui ) {
				var sizing = ['', 'input-sm', 'input-lg', 'input-mini', 'input-small', 'input-medium', 'input-large', 'input-xlarge', 'input-xxlarge'];
				var val = parseInt(ui.value);
				$('#form-field-4').attr('class', sizing[val]).val('.'+sizing[val]);
			}
		});
	
		$( "#input-span-slider" ).slider({
			value:1,
			range: "min",
			min: 1,
			max: 12,
			step: 1,
			slide: function( event, ui ) {
				var val = parseInt(ui.value);
				$('#form-field-5').attr('class', 'col-xs-'+val).val('.col-xs-'+val);
			}
		});
	
	
		
		//"jQuery UI Slider"
		//range slider tooltip example
		$( "#slider-range" ).css('height','200px').slider({
			orientation: "vertical",
			range: true,
			min: 0,
			max: 100,
			values: [ 17, 67 ],
			slide: function( event, ui ) {
				var val = ui.values[$(ui.handle).index()-1] + "";
	
				if( !ui.handle.firstChild ) {
					$("<div class='tooltip right in' style='display:none;left:16px;top:-6px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
					.prependTo(ui.handle);
				}
				$(ui.handle.firstChild).show().children().eq(1).text(val);
			}
		}).find('span.ui-slider-handle').on('blur', function(){
			$(this.firstChild).hide();
		});
		
		
		$( "#slider-range-max" ).slider({
			range: "max",
			min: 1,
			max: 10,
			value: 2
		});
		
		$( "#slider-eq > span" ).css({width:'90%', 'float':'left', margin:'15px'}).each(function() {
			// read initial values from markup and remove that
			var value = parseInt( $( this ).text(), 10 );
			$( this ).empty().slider({
				value: value,
				range: "min",
				animate: true
				
			});
		});
		
		$("#slider-eq > span.ui-slider-purple").slider('disable');//disable third item
	
		
		$('#id-input-file-1 , #photo').ace_file_input({
			no_file:'No File ...',
			btn_choose:'Choose',
			btn_change:'Change',
			droppable:false,
			onchange:null,
			thumbnail:false //| true | large
			//whitelist:'gif|png|jpg|jpeg'
			//blacklist:'exe|php'
			//onchange:''
			//
		});
		//pre-show a file name, for example a previously selected file
		//$('#id-input-file-1').ace_file_input('show_file_list', ['myfile.txt'])
	
	
		$('#id-input-file-3').ace_file_input({
			style:'well',
			btn_choose:'Drop files here or click to choose',
			btn_change:null,
			no_icon:'ace-icon fa fa-cloud-upload',
			droppable:true,
			thumbnail:'small'//large | fit
			//,icon_remove:null//set null, to hide remove/reset button
			/**,before_change:function(files, dropped) {
				//Check an example below
				//or examples/file-upload.html
				return true;
			}*/
			/**,before_remove : function() {
				return true;
			}*/
			,
			preview_error : function(filename, error_code) {
				//name of the file that failed
				//error_code values
				//1 = 'FILE_LOAD_FAILED',
				//2 = 'IMAGE_LOAD_FAILED',
				//3 = 'THUMBNAIL_FAILED'
				//alert(error_code);
			}
	
		}).on('change', function(){
			//console.log($(this).data('ace_input_files'));
			//console.log($(this).data('ace_input_method'));
		});
		
		
		//$('#id-input-file-3')
		//.ace_file_input('show_file_list', [
			//{type: 'image', name: 'name of image', path: 'http://path/to/image/for/preview'},
			//{type: 'file', name: 'hello.txt'}
		//]);
	
		
		
	
		//dynamically change allowed formats by changing allowExt && allowMime function
		$('#id-file-format').removeAttr('checked').on('change', function() {
			var whitelist_ext, whitelist_mime;
			var btn_choose
			var no_icon
			if(this.checked) {
				btn_choose = "Drop images here or click to choose";
				no_icon = "ace-icon fa fa-picture-o";
	
				whitelist_ext = ["jpeg", "jpg", "png", "gif" , "bmp"];
				whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
			}
			else {
				btn_choose = "Drop files here or click to choose";
				no_icon = "ace-icon fa fa-cloud-upload";
				
				whitelist_ext = null;//all extensions are acceptable
				whitelist_mime = null;//all mimes are acceptable
			}
			var file_input = $('#id-input-file-3');
			file_input
			.ace_file_input('update_settings',
			{
				'btn_choose': btn_choose,
				'no_icon': no_icon,
				'allowExt': whitelist_ext,
				'allowMime': whitelist_mime
			})
			file_input.ace_file_input('reset_input');
			
			file_input
			.off('file.error.ace')
			.on('file.error.ace', function(e, info) {
				//console.log(info.file_count);//number of selected files
				//console.log(info.invalid_count);//number of invalid files
				//console.log(info.error_list);//a list of errors in the following format
				
				//info.error_count['ext']
				//info.error_count['mime']
				//info.error_count['size']
				
				//info.error_list['ext']  = [list of file names with invalid extension]
				//info.error_list['mime'] = [list of file names with invalid mimetype]
				//info.error_list['size'] = [list of file names with invalid size]
				
				
				/**
				if( !info.dropped ) {
					//perhapse reset file field if files have been selected, and there are invalid files among them
					//when files are dropped, only valid files will be added to our file array
					e.preventDefault();//it will rest input
				}
				*/
				
				
				//if files have been selected (not dropped), you can choose to reset input
				//because browser keeps all selected files anyway and this cannot be changed
				//we can only reset file field to become empty again
				//on any case you still should check files with your server side script
				//because any arbitrary file can be uploaded by user and it's not safe to rely on browser-side measures
			});
		
		});
	
		$('#spinner1').ace_spinner({value:0,min:0,max:200,step:10, btn_up_class:'btn-info' , btn_down_class:'btn-info'})
		.closest('.ace-spinner')
		.on('changed.fu.spinbox', function(){
			//alert($('#spinner1').val())
		}); 
		$('#spinner2').ace_spinner({value:0,min:0,max:10000,step:100, touch_spinner: true, icon_up:'ace-icon fa fa-caret-up bigger-110', icon_down:'ace-icon fa fa-caret-down bigger-110'});
		$('#spinner3').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus bigger-110', icon_down:'ace-icon fa fa-minus bigger-110', btn_up_class:'btn-success' , btn_down_class:'btn-danger'});
		$('#spinner4').ace_spinner({value:0,min:-100,max:100,step:10, on_sides: true, icon_up:'ace-icon fa fa-plus', icon_down:'ace-icon fa fa-minus', btn_up_class:'btn-purple' , btn_down_class:'btn-purple'});
	
		//$('#spinner1').ace_spinner('disable').ace_spinner('value', 11);
		//or
		//$('#spinner1').closest('.ace-spinner').spinner('disable').spinner('enable').spinner('value', 11);//disable, enable or change value
		//$('#spinner1').closest('.ace-spinner').spinner('value', 0);//reset to 0
	
	
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
	
	
		//to translate the daterange picker, please copy the "examples/daterange-fr.js" contents here before initialization
		$('input[name=date-range-picker]').daterangepicker({
			'applyClass' : 'btn-sm btn-success',
			'cancelClass' : 'btn-sm btn-default',
			locale: {
				applyLabel: 'Apply',
				cancelLabel: 'Cancel',
			}
		})
		.prev().on(ace.click_event, function(){
			$(this).next().focus();
		});
	
	
		$('#timepicker1').timepicker({
			minuteStep: 1,
			showSeconds: true,
			showMeridian: false
		}).next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		
		$('#date-timepicker1').datetimepicker().next().on(ace.click_event, function(){
			$(this).prev().focus();
		});
		
	
		$('#colorpicker1').colorpicker();
	
		$('#simple-colorpicker-1').ace_colorpicker();
		//$('#simple-colorpicker-1').ace_colorpicker('pick', 2);//select 2nd color
		//$('#simple-colorpicker-1').ace_colorpicker('pick', '#fbe983');//select #fbe983 color
		//var picker = $('#simple-colorpicker-1').data('ace_colorpicker')
		//picker.pick('red', true);//insert the color if it doesn't exist
	
	
		$(".knob").knob();
		
		
		var tag_input = $('#form-field-tags');
		try{
			tag_input.tag(
			  {
				placeholder:tag_input.attr('placeholder'),
				//enable typeahead by specifying the source array
				source: ace.vars['US_STATES'],//defined in ace.js >> ace.enable_search_ahead
				/**
				//or fetch data from database, fetch those that match "query"
				source: function(query, process) {
				  $.ajax({url: 'remote_source.php?q='+encodeURIComponent(query)})
				  .done(function(result_items){
					process(result_items);
				  });
				}
				*/
			  }
			)
	
			//programmatically add a new
			var $tag_obj = $('#form-field-tags').data('tag');
			$tag_obj.add('Programmatically Added');
		}
		catch(e) {
			//display a textarea for old IE, because it doesn't support this plugin or another one I tried!
			tag_input.after('<textarea id="'+tag_input.attr('id')+'" name="'+tag_input.attr('name')+'" rows="3">'+tag_input.val()+'</textarea>').remove();
			//$('#form-field-tags').autosize({append: "\n"});
		}
		
		
		/////////
		$('#modal-form input[type=file]').ace_file_input({
			style:'well',
			btn_choose:'Drop files here or click to choose',
			btn_change:null,
			no_icon:'ace-icon fa fa-cloud-upload',
			droppable:true,
			thumbnail:'large'
		})
		
		//chosen plugin inside a modal will have a zero width because the select element is originally hidden
		//and its width cannot be determined.
		//so we set the width after modal is show
		$('#modal-form').on('shown.bs.modal', function () {
			if(!ace.vars['touch']) {
				$(this).find('.chosen-container').each(function(){
					$(this).find('a:first-child').css('width' , '210px');
					$(this).find('.chosen-drop').css('width' , '210px');
					$(this).find('.chosen-search input').css('width' , '200px');
				});
			}
		})
		/**
		//or you can activate the chosen plugin after modal is shown
		//this way select element becomes visible with dimensions and chosen works as expected
		$('#modal-form').on('shown', function () {
			$(this).find('.modal-chosen').chosen();
		})
		*/
	
		
		
		$(document).one('ajaxloadstart.page', function(e) {
			$('textarea[class*=autosize]').trigger('autosize.destroy');
			$('.limiterBox,.autosizejs').remove();
			$('.daterangepicker.dropdown-menu,.colorpicker.dropdown-menu,.bootstrap-datetimepicker-widget.dropdown-menu').remove();
		});
		
		
	
	});
</script>


				