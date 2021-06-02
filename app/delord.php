<script type="text/javascript" src="js/buttonajax.js"></script>

<link rel="stylesheet" type="text/css" media="all" href="js/jsDatePick_ltr.min.css" /> 
<script type="text/javascript" src="js/jsDatePick.min.1.3.js"></script>
<script type="text/javascript" src="js/buttonajax.js"></script>

<script type="text/javascript">
	window.onload = function(){
		new JsDatePick({
			useMode:2,
			target:"dte",
			dateFormat:"%d-%m-%Y"				
		});
	};
</script>

<script language="javascript">
	function cekinput(fid) {  
	  var arrf = fid.split(',');
	  for(i=0; i < arrf.length; i++) {
		if(document.getElementById(arrf[i]).value=='') {       

		 /* if (document.getElementById(arrf[i]).name=='delordcde') {
			alert('Kode tidak boleh kosong!');				
		  }*/
		  if (document.getElementById(arrf[i]).name=='dte') {
			alert('Tanggal tidak boleh kosong!');				
		  }
		  if (document.getElementById(arrf[i]).name=='dono') {
			alert('No. DO tidak boleh kosong!');				
		  }
		  if (document.getElementById(arrf[i]).name=='sts') {
			alert('Status tidak boleh kosong!');				
		  }
		  if (document.getElementById(arrf[i]).name=='vhccde') {
			alert('No. Kendaraan tidak boleh kosong!');				
		  }
		  if (document.getElementById(arrf[i]).name=='vhctpe') {
			alert('Tipe Kendaraan tidak boleh kosong!');				
		  }
		  		  
		  if (document.getElementById(arrf[i]).name=='tpe') {
			alert('Tipe tidak boleh kosong!');				
		  }
		  if (document.getElementById(arrf[i]).name=='drvnme') {
			alert('Driver tidak boleh kosong!');				
		  }
		  if (document.getElementById(arrf[i]).name=='ctyfrm') {
			alert('Dari tidak boleh kosong!');				
		  }
		  if (document.getElementById(arrf[i]).name=='ctyto') {
			alert('Tujuan tidak boleh kosong!');				
		  }
		  if (document.getElementById(arrf[i]).name=='ctyend') {
			alert('Tujuan Akhir tidak boleh kosong!');				
		  }
		  if (document.getElementById(arrf[i]).name=='clncde') {
			alert('Customer tidak boleh kosong!');				
		  }
		  
		  return false
		}
										
	  }		 
	}
		
</script>

<script type="text/javascript">
	<!--
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
	
			
	//-->	 
</script>

<script type="text/javascript">
	<!--
	var request;
	var dest;
	
	function loadHTMLPost3(URL, destination, button, getId, getId2){
		dest = destination;	
		str = getId + '=' + document.getElementById(getId).value;
		str2 = getId2 + '=' + document.getElementById(getId2).value;
		
		var str = str + '&button=' + button;
		var str2 = str2 + '&button=' + button;
		var str = str + '&' + str2;
				
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
			
	//-->	 
	
</script>

<?php

/*$ref = $segmen3;*/

$segmen2 = $act;

?>

                        
                        
<div class="page-content">
      
	<div class="row">
		<div class="col-xs-12">
            
            <?php
						
                $ref = $_GET['search'];
				
        		include("app/exec/insert_delord.php"); 
        		
        		//jika saat add data, maka data setelah save kosong
        		if ($_POST['submit'] == 'Save') { $ref = ''; }
        		//-----------------------------------------------/\
        		
                $ref2 = notran(date('y-m-d'), 'frmdelord', '', '', ''); //---get no ref
							
				$sts = 'Released';
                            
        		if ($ref != "") {
        			$sql=$select->list_delord($ref);			
        			$row_delord=$sql->fetch(PDO::FETCH_OBJ);	
                    
                    $ref2 = $row_delord->delordcde;
								
					$sts = $row_delord->sts;
					
					$vhccde		= 	str_replace(" ","|",$row_delord->vhccde);
                    								
        		}		
        		
        		if ($row_delord->sts == 'Cashier' || $row_delord->sts == 'Finish') {
        			$style = 'disabled="disabled"';
        		} else {
        			$style = 'class="alt_btn"';
        		}
        		
        		if ($row_delord->sts == 'Finish') {
        			$style2 = 'disabled="disabled"';
        		} else {
        			$style2 = 'class="alt_btn"';
        		}	
				
			?>
            
			<!-- PAGE CONTENT BEGINS -->
			<form class="form-horizontal" role="form" action="" method="post" name="delord" id="delord" class="form-horizontal" onSubmit="return cekinput('delordcde,delorddcr');" >
            
                <div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Ref. *)</label>
					<div class="col-sm-3"><input style="background-color:#E2F6C5;" size="25" type="text" readonly id="delordcde" name="delordcde" value="<?php echo $ref2; ?>"></div>
				</div> 
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tanggal *)</label>
					<div class="col-sm-3">
						<input class="form-control date-picker" data-date-format="dd-mm-yyyy" type="text" id="dte" name="dte" value="<?php if($row_delord->dte !='' ){echo date('d-m-Y', strtotime($row_delord->dte)); } else { echo date('d-m-Y');} ?>">
                    </div>
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">No. DO *)</label>
					<div class="col-sm-3" id="nodo"><input size="40" type="text" id="dono" name="dono" onKeyup="this.value=this.value.toUpperCase()" onblur="loadHTMLPost3('app/delord_ajax_nodo.php','nodo','ceknodo','delordcde','dono')" value="<?php echo $row_delord->dono ?>"></div>
				</div>		
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">No. Shipment</label>
					<div class="col-sm-3"><input size="40" type="text" id="noship" name="noship" onKeyup="this.value=this.value.toUpperCase()" value="<?php echo $row_delord->noship ?>"></div>
				</div>					
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Status *)</label>
					<div class="col-sm-3">
						<input style="background-color:#E2F6C5;" size="10" type="text" readonly id="sts" name="sts" value="<?php echo $sts; ?>">									
						<?php /*?><select name="sts" id="sts" style="width:100px;" />
							<?php delord_status_select($row_delord->sts); ?>
						</select><?php */?>
					</div>
				</div>
										
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">No. Kendaraan *)</label>
					<div class="col-sm-3">
						<!--<input size="20" type="text" style="background-color:#E2F6C5;" readonly="" id="vhccde" name="vhccde" onKeyup="this.value=this.value.toUpperCase()" value="<?php echo $row_delord->vhccde ?>">
						<?php if ($ref == '') { ?>
							<a href="javascript:void(0);" name="Find" title="Find" onClick=window.open("app/delord_vhc_lup.php","Find","width=700,height=370,left=180,top=40,toolbar=0,status=0,scroll=1,scrollbars=no");><img src="images/search.png" /></a>
							<a href="main.php?menu=app&act=vhc" name="Find" title="Master Kendaraan" ><img src="images/add_48.png" width="20" height="20" /></a>
						<?php } ?> -->
						
						<select name="vhccde" id="vhccde" style="width:250px;" class="chosen-select form-control" onChange="loadHTMLPost2('app/delord_vehicle_ajax.php','vhcid','setvhc','vhccde')" >
							<option value=""></option>
							<?php vehicle_select($vhccde); ?>
						</select>
						
                        
                                            
                        <?php if (allowupd('frmvdr')==1) { ?>
                            <a href="main.php?menu=app&act=<?php echo obraxabrix('vhc') ?>" class="tooltip-success" data-rel="tooltip" title="Add Kendaraan">
								<img src="assets/img/plus.png"/>
							</a>
                        <?php } ?>
                            
					</div>
				</div>
				
                <div id="vhcid">
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
                				<!--<tr id="vhcsub">--> 
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
                </div>
                
											
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Driver *)</label>
					<div class="col-sm-3"><input size="40" type="text" id="drvnme" name="drvnme" onKeyup="this.value=this.value.toUpperCase()" value="<?php echo $row_delord->drvnme ?>"></div>
				</div>
			
			
			
			
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Dari *)</label>
					<div class="col-sm-3">
						<!--<input size="40" type="text" id="ctyfrm" name="ctyfrm" onKeyup="this.value=this.value.toUpperCase()" value="<?php echo $row_delord->ctyfrm ?>">-->
						<select name="ctyfrm" id="ctyfrm" style="width:250px;" class="chosen-select form-control" />
							<option value=""></option>
							<?php do_from_select($row_delord->ctyfrm); ?>
						</select>
						
						<!--<div id="suggest">-->
						   <!--<input type="text" name="dstfrom" onKeyUp="suggest(this.value);" onblur="fill2();" onkeydown="loadHTMLPost2('app/delord_ajax_dari.php','suggest','cekdari','dstfrom')" id="dstfrom" size="15" value="<?php echo $row_delord->dstfrom ?>"/> -->
						   <!--<input type="text" onKeyUp="suggest(this.value);" name="dstfrom" onblur="fill2();" id="dstfrom" size="25" value="<?php echo $row_delord->dstfrom ?>" />
						   <div class="suggestionsBox" id="suggestions" style="display: none;"> <img src="auto/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
								<div class="suggestionList" id="suggestionsList"> &nbsp; </div>
						   </div>
						   <input type="text" style="background-color:#E2F6C5;" readonly="" name="ctyfrm" id="ctyfrm"  size="40" onBlur="fill();" value="<?php echo $row_delord->ctyfrm ?>" />
						</div>-->
					</div>
				</div>
			
			
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tujuan *)</label>
					<div class="col-sm-3">
						<!--<input size="60" type="text" id="ctyto" name="ctyto" onKeyup="this.value=this.value.toUpperCase()" value="<?php echo $row_delord->ctyto ?>">-->
						<select name="ctyto" id="ctyto" style="width:250px;" class="chosen-select form-control" />
							<option value=""></option>
							<?php do_to_select($row_delord->ctyto); ?>
						</select>	
						
						<!--<div id="suggesttujuan">
						   <input type="text" onKeyUp="suggesttujuan(this.value);" name="dstto" onblur="fill4();" id="dstto" size="25" value="<?php echo $row_delord->dstto ?>"/>
						   <div class="suggestionstujuanBox" id="suggestionstujuan" style="display: none;"> <img src="auto/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
								<div class="suggestiontujuanList" id="suggestionstujuanList"> &nbsp; </div>
						   </div>
						   <input type="text" style="background-color:#E2F6C5;" readonly="" name="ctyto" id="ctyto"  size="40" onBlur="fill3();" value="<?php echo $row_delord->ctyto ?>" />
						</div>-->
					</div>
				</div>
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Tujuan Akhir *)</label>
					<div class="col-sm-3">
						<select name="ctyend" id="ctyend" style="width:250px;" class="chosen-select form-control" />
							<option value=""></option>
							<?php do_to_select($row_delord->ctyend); ?>
						</select>
						
						<!--<div id="suggesttujuanakhir">
						   <input type="text" onKeyUp="suggesttujuanakhir(this.value);" name="dstend" onblur="fill5();" id="dstend" size="25" value="<?php echo $row_delord->dstend ?>"/>
						   <div class="suggestionstujuanakhirBox" id="suggestionstujuanakhir" style="display: none;"> <img src="auto/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" />
								<div class="suggestiontujuanakhirList" id="suggestionstujuanakhirList"> &nbsp; </div>
						   </div>
						   <input type="text" style="background-color:#E2F6C5;" readonly="" name="ctyend" id="ctyend"  size="40" onBlur="fill4();" value="<?php echo $row_delord->ctyend ?>" />
						</div>-->
					</div>
				</div>
				
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Customer *)</label>
					<div class="col-sm-5">									
					   <input type="text" style="background-color:#E2F6C5;" name="clncde" id="clncde" readonly="" class="col-xs-10 col-sm-3" value="<?php echo $row_delord->clncde ?>"/> 
					   <input type="text" style="background-color:#E2F6C5;" readonly="" name="clndcr" id="clndcr" class="col-xs-10 col-sm-7" value="<?php echo $row_delord->clndcr ?>" />
						<a href="javascript:void(0);" name="Find" title="Find" onClick=window.open("app/delord_cln_lup.php","Find","width=700,height=550,left=180,top=40,toolbar=0,status=0,scroll=1,scrollbars=no");>
                                <button type="button" class="btn btn-purple btn-sm">
									<span class="ace-icon fa fa-search icon-on-right bigger-110"></span>
									
								</button>
                        </a>
					</div>
				</div>
                       				
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Updated by</label> 
					 
					<div class="col-sm-3">
						<input style="background-color:#E2F6C5;" type="text" readonly size="20" id="uid" name="uid" value="<?php echo $row_delord->uid ?>">
					</div>
				</div>
				
				<div class="form-group"> 
					<label class="col-sm-3 control-label no-padding-right" for="form-field-1">Date Last Update</label> 
					 
					<div class="col-sm-3">
						<input style="background-color:#E2F6C5;" type="text" readonly size="15" id="dlu" name="dlu" value="<?php echo $row_delord->dlu ?>">
					</div>
				</div>
                            
                   
				<div class="space-4"></div>

				<div class="clearfix form-actions">
					<div class="col-md-offset-3 col-md-9">
                        
                        <?php if (allowupd('frmdelord')==1) { ?>
                            <?php if($ref!='') { ?>
    							<input type="submit" name="submit" id="submit" class='btn btn-primary' value="Update" />
    						<?php } ?>
                        <?php } ?>
						
                        <?php if (allowadd('frmdelord')==1) { ?>
    						<?php if($ref=='') { ?>
    							<input type="submit" name="submit" id="submit" class='btn btn-primary' value="Save" />
    						<?php } ?>
                        <?php } ?>
                        
                        <?php if (allowdel('frmdelord')==1) { ?>
                            &nbsp;
    						<input type="submit" name="submit" class="btn btn-danger" value="Delete" onClick="return confirm('Apakah Anda yakin akan menghapus data?')" >
                        <?php } ?>
                        
						&nbsp;
						<input type="button" name="submit" id="submit" class="btn btn-success" value="List Data" onclick="self.location='<?php echo $nama_folder . obraxabrix(delord_view) ?>'" />
                                                
                                 
					</div>
				</div>

			</form>
            
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
	
		
		$('#id-input-file-1 , #id-input-file-2').ace_file_input({
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


				