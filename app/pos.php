<?php
@session_start();
?>

<style>
	#status {
	  position: fixed;
	  width: 14%;
	  font: bold 1em sans-serif;
	  color: #FFF;
	  padding: 0.5em;
	  padding-top: 14px;
	}

	#log {
	  padding: 2.5em 0.5em 0.5em;
	  font: 1em sans-serif;
	}

	.online {
	  background: green;
	}

	.offline {
	  background: red;
	}
</style>


<script>
	window.addEventListener('load', function() {
	  var status = document.getElementById("status");
	  //var log = document.getElementById("log");

	  function updateOnlineStatus(event) {
	    var condition = navigator.onLine ? "online" : "offline";

	    status.className = condition;
	    status.innerHTML = condition.toUpperCase();

		if(status.innerHTML == "online".toUpperCase()) {
			//alert("online");
			window.location = 'http://pos.erparoma.com';
		}
		
		if(status.innerHTML == "offline".toUpperCase()) {
			//alert("offline");
			//window.location = 'http://localhost:8080/tokosahabat';
			window.location = 'http://localhost/aromapos';
		}
	    //log.insertAdjacentHTML("beforeend", "Event: " + event.type + "; Status: " + condition);
	  }

	  window.addEventListener('online',  updateOnlineStatus);
	  window.addEventListener('offline', updateOnlineStatus);
	});
</script>

<script src="assets/js/appcustom.js"></script>
<script type="text/javascript" src="js/buttonajax.js"></script>

<script language="javascript">
	
	function cekinput(fid) {  
	  var arrf = fid.split(',');
	  for(i=0; i < arrf.length; i++) {
	  	
		if(document.getElementById(arrf[i]).value=='') {       
		  
		  if (document.getElementById(arrf[i]).name=='ref') {
			alert('Ref. cannot empty!');
		  }
		  
		  if (document.getElementById(arrf[i]).name=='date') {
			alert('Date cannot empty!');				
		  }
		  
		  if (document.getElementById(arrf[i]).name=='location_id') {
			alert('Location cannot empty!');				
		  }
		  
		  if (document.getElementById(arrf[i]).name=='client_code') {
			alert('Customer cannot empty!');				
		  }
		  
		  if (document.getElementById(arrf[i]).name=='shift') {
			alert('Shift cannot empty!');				
		  }
		  		  
		  return false
		} 
										
	  }		
	  
	  var item_code2 = document.getElementById('item_code2').value;
	  
	  if(item_code2 == "") {
	  	  var total = document.getElementById('total').value;
		  total = total.replace(/[^\d-.]/g,"");
		  total = total.replace(",","");
		  if(total == "") {total = 0};
		  if( total < 0 ) {
		  	alert('Transaksi tidak bisa disimpan, Total masih minus !!!');
		  	return false
		  }
		  
		  var cash_amount = document.getElementById('cash_amount').value;
		  cash_amount = cash_amount.replace(/[^\d-.]/g,"");
		  cash_amount = cash_amount.replace(",","");
		  if(cash_amount == "") {cash_amount = 0};
		  
		  var ovo = document.getElementById('ovo').value;
		  ovo = ovo.replace(/[^\d-.]/g,"");
		  ovo = ovo.replace(",","");
		  if(ovo == "") {ovo = 0};
		  
		  var gopay = document.getElementById('gopay').value;
		  gopay = gopay.replace(/[^\d-.]/g,"");
		  gopay = gopay.replace(",","");
		  if(gopay == "") {gopay = 0};
		  
		  var bank_amount = document.getElementById('bank_amount').value;
		  bank_amount = bank_amount.replace(/[^\d-.]/g,"");
		  bank_amount = bank_amount.replace(",","");
		  if(bank_amount == "") {bank_amount = 0};
		  
		  var cash_voucher = document.getElementById('cash_voucher').value;
		  cash_voucher = cash_voucher.replace(/[^\d-.]/g,"");
		  cash_voucher = cash_voucher.replace(",","");
		  if(cash_voucher == "") {cash_voucher = 0};
		  
		  var change_amount = document.getElementById('change_amount').value;
		  change_amount = change_amount.replace(/[^\d-.]/g,"");
		  change_amount = change_amount.replace(",","");
		  
		  var kembali = parseFloat(total) - parseFloat(cash_amount) - parseFloat(cash_voucher) - parseFloat(ovo) - parseFloat(gopay) - parseFloat(bank_amount);
		  
		  /*var approved_overlimit=document.getElementById('approved_overlimit').value; 
		  if(total > 5000000 && approved_overlimit < 1) {
		  	alert('Penjualan lebih dari 5 Juta harus ada persetujuan dari SPV/AM !!!');
		  	return false
		  }*/
		  
		  //if(change_amount < 0) {
		  if( kembali > 0 ) {
		  	alert('Kembalian harus lebih besar atau sama dengan nol !!!');
		  	return false
		  }
	  } 
	   
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

<script type="text/javascript">
	var request;
	var dest;
	
	function loadHTMLPost3(URL, destination, button, getId, getId2){
		dest = destination;	
		str = getId + '=' + document.getElementById(getId).value;		
		str2 = getId2 + '=' + document.getElementById(getId2).value;
		
		var str = str + '&button=' + button; // + button + '|' + getId2;
		str = str + '&' + str2;
		
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
	
	//-----------fungsi enter ganti qty-----------
	function saatEnter(inField, e, xndf) {
        var charCode;
        if(e && e.which){
            charCode = e.which;
        }else if(window.event){
            e = window.event;
            charCode = e.keyCode;
        }
        if(charCode == 13) {
        	
        	var item_code2 = "";
			item_code2 = document.getElementById('item_code2').value;
			var temukan = item_code2.indexOf("*");
		
			if(temukan = 1) {
				var xline = Array(); 
				xline = item_code2.split("*",5);
				var xline2 = xline[0]-1;
				//var qty2 = Array(); 
				var xline3 = xline[0];
				qty2 = xline[1];
				no = xline2;
				
				var item_code	= document.getElementById('item_code_'+no).value;
				var uom_code	= document.getElementById('uom_code_'+no).value;
				var line 		= document.getElementById('old_line_'+no).value;
				var qty 		= qty2;
				var unit_price 	= document.getElementById('unit_price_'+no).value;
				var amount 		= document.getElementById('amount_'+no).value;
				var discount3	= document.getElementById('discount3_'+no).value;
				var ref_near_expired = document.getElementById('ref_near_expired_'+no).value;
				
				redirect(xndf, item_code, uom_code, line, qty, unit_price, amount, discount3, ref_near_expired);
				
			}
			
        }
    }
    
    function redirect(xndf, item_code, uom_code, line, qty, unit_price, amount, discount3, ref_near_expired) {
    	document.location.href = "main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&mxKz=upd&xndf="+xndf+"&line="+line+"&qty="+qty+"&unit_price="+unit_price+"&amount="+amount+"&item_code="+item_code+"&uom_code="+uom_code+"&discount3="+discount3+"&ref_near_expired="+ref_near_expired+" ";			
	}
    //----------------/\-------------------------
    
    
	//-----update qty detail
	function update_qty(maxline, ref) {
		
		var item_code2 = "";
		item_code2 = document.getElementById('item_code2').value;
		
		var jmldata = maxline;
		var id = maxline;
				
		if(item_code2.search("/") > 0 ) {
			//$('#test').html('');
			no = maxline;
			var item_code	= document.getElementById('item_code_'+no).value;
			var uom_code	= document.getElementById('uom_code_'+no).value;
			var line 		= document.getElementById('old_line_'+no).value;
			var qty 		= document.getElementById('qty_'+no).value;
			var unit_price 	= document.getElementById('unit_price_'+no).value;
			var amount 		= document.getElementById('amount_'+no).value;
			var discount3	= document.getElementById('discount3_'+no).value;
			var ref_near_expired = document.getElementById('ref_near_expired_'+no).value;
			
			document.location.href = "main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&mxKz=upd&xndf="+ref+"&line="+line+"&qty="+qty+"&unit_price="+unit_price+"&amount="+amount+"&item_code="+item_code+"&uom_code="+uom_code+"&discount3="+discount3+"&ref_near_expired="+ref_near_expired+" ";	
			
		}
		
		/*if(item_code2 != "/" && item_code2 != "") {
			if(item_code2.search("/") > 0 ) {
				if(isNaN(item_code2) == true ) { //jika bukan numeric
						item_code2 = item_code2.replace("/","");
						$('#qty_id'+id).html('<input type="text" id="qty_'+id+'" name="qty_'+id+'" style="text-align: right; font-size:18px" class="form-control" onkeyup="formatangka(\'qty_'+id+'\'), detailvalue(\''+id+'\', '+jmldata+')" value="'+item_code2+'" >');
					
				}				
			}
		}*/
					
		if(item_code2 != "/" && item_code2 != "") {
			if(item_code2.search("/") <= 0 ) {
				if(isNaN(item_code2) == false ) { //jika bukan numeric
					$('#qty_id'+id).html('<input type="text" id="qty_'+id+'" name="qty_'+id+'" style="text-align: right; font-size:14px; background-color: #010596; width: 70px; color: #ffffff; font-weight: bold; border-color: #010596; height: 25px;" class="form-control" onkeyup="formatangka(\'qty_'+id+'\'), detailvalue(\''+id+'\', '+jmldata+')" value="'+item_code2+'" >');
				}				
			}
		}
		
		if(item_code2.search("x") > 0 ) {
			var xline = Array(); 
			xline = item_code2.split("=",5);
			var xline2 = xline[0]-1;
			var linex = document.getElementById('old_line_'+xline2).value;
			var id = ref;
			if (confirm('Apakah Anda yakin akan menghapus data ini?')) {
				document.location.href = "main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&mxKz=xm8r389xemx23xb2378e23&xndf="+id+"&line="+linex+" ";
			}
		}
		
		
		if(item_code2.search("=") > 0 ) { //"d"
			var xline = Array(); 
			xline = item_code2.split(".",5);
			var xline2 = xline[0]-1;
			var qty2 = Array(); 
			var xline3 = xline[1];
			qty2 = xline3.split("=",5); //"d";
			
			no = xline2;
			var item_code	= document.getElementById('item_code_'+no).value;
			var uom_code	= document.getElementById('uom_code_'+no).value;
			var line 		= document.getElementById('old_line_'+no).value;
			var qty 		= qty2[0]; //document.getElementById('qty_'+no).value;
			var unit_price 	= document.getElementById('unit_price_'+no).value;
			var amount 		= document.getElementById('amount_'+no).value;
			var discount3	= document.getElementById('discount3_'+no).value;
			var ref_near_expired = document.getElementById('ref_near_expired_'+no).value;
			
			document.location.href = "main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&mxKz=upd&xndf="+ref+"&line="+line+"&qty="+qty+"&unit_price="+unit_price+"&amount="+amount+"&item_code="+item_code+"&uom_code="+uom_code+"&discount3="+discount3+"&ref_near_expired="+ref_near_expired+" ";
			
		}
		
		/*if(item_code2.search("d") > 0 ) { //"d"
			var xline = Array(); 
			xline = item_code2.split("=",5);
			var xline2 = xline[0]-1;
			var qty2 = Array(); 
			var xline3 = xline[1];
			qty2 = xline3.split("d",5); //"d";
			
			no = xline2;
			var item_code	= document.getElementById('item_code_'+no).value;
			var uom_code	= document.getElementById('uom_code_'+no).value;
			var line 		= document.getElementById('old_line_'+no).value;
			var qty 		= qty2[0]; //document.getElementById('qty_'+no).value;
			var unit_price 	= document.getElementById('unit_price_'+no).value;
			var amount 		= document.getElementById('amount_'+no).value;
			
			document.location.href = "main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&mxKz=upd&xndf="+ref+"&line="+line+"&qty="+qty+"&unit_price="+unit_price+"&amount="+amount+"&item_code="+item_code+"&uom_code="+uom_code+" ";			
			
		}*/
		
		
	}
	
	
	
	//-----------change nilai
	function detailvalue(id, jmldata, ketik){
        
        var qty = 0;	
		qty=document.getElementById('qty_'+id).value; 
		//qty = number_format(qty,0,".",",");
		qty = qty.replace(/[^\d-.]/g,"");
		if(qty == "") {qty = 0};
				
		var unit_price = 0;
		unit_price=document.getElementById('unit_price_'+id).value; 
		//unit_price = number_format(unit_price,0,".",",");
		unit_price = unit_price.replace(/[^\d-.]/g,"");
		if(unit_price == "") {unit_price = 0};
		
		var discount = 0;
		discount=document.getElementById('discount_'+id).value; 
		discount = discount.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(discount == "") {discount = 0};
		
        //discoutn persen
        var discount3 = 0;
		discount3=document.getElementById('discount3_'+id).value; 
		discount3 = discount3.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(discount3 == "") {discount3 = 0};
		
		//get seting discount
		var discount2 = 0;
		discount2=document.getElementById('discount2_'+id).value; 
		discount2 = discount2.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(discount2 == "") {discount2 = 0};
		
		var end_date_discount = "";
		end_date_discount=document.getElementById('end_date_discount_'+id).value;
		
		var qty_discount = 0;
		qty_discount=document.getElementById('qty_discount_'+id).value; 
		qty_discount = qty_discount.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(qty_discount == "") {qty_discount = 0};
		
		var non_discount = 0;
		non_discount=document.getElementById('non_discount_'+id).value; 
		non_discount = non_discount.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(non_discount == "") {non_discount = 0};
		
		var deposit = 0;
		deposit=document.getElementById('deposit_'+id).value; 
		deposit = deposit.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(deposit == "") {deposit = 0};
		
		var date_tmp = "";
		date_tmp=document.getElementById('date_tmp').value;
		
		var discount = 0;
		var discount3 = 0;
		if( date_tmp <= end_date_discount && qty >= qty_discount ) {
			discount = discount2;
			discount3 = deposit;
		}
		if( date_tmp <= end_date_discount && non_discount > 0 ) {
			discount = discount2;
			discount3 = deposit;
		}
		//------/\---------
        
        
        //alert(discount3);
        if( ketik == 'persen' ) {
            discount3 = (unit_price * discount3) / 100;
            if(discount3 == "") {discount3 = 0};
            
            discount = discount3;   
        } 
        
		unit_price = parseFloat(unit_price) - parseFloat(discount);
		
        discount_value     = number_format(discount,0,".",",");
        
        if( ketik == 'persen' ) {
            $('#discount_det_id'+id).html('<input type="text" id="discount_'+id+'" name="discount_'+id+'" style="width: 100px; height: 25px; text-align: right; font-size:14px" class="form-control" onkeyup="formatangka(\'discount_'+id+'\'), detailvalue(\''+id+'\', '+jmldata+', \'nominal\')" value="'+discount_value+'" >');
        } 
        
        
        //-------disc nominal
        if( ketik == 'nominal' ) {
            
            var unit_price_tmp = 0;
    		unit_price_tmp=document.getElementById('unit_price_'+id).value; 
    		unit_price_tmp = unit_price_tmp.replace(/[^\d-.]/g,"");
    		if(unit_price_tmp == "") {unit_price_tmp = 0};
            
            discount3 = ( discount / unit_price_tmp) * 100; 
            
        }   
        
        discount3_value    = number_format(discount3,0,".",",");
        if( ketik == 'nominal' ) {
           $('#discount3_det_id'+id).html('<input type="text" id="discount3_'+id+'" name="discount3_'+id+'" style="width: 100px; height: 25px; text-align: right; font-size:14px" class="form-control" onkeyup="formatangka(\'discount3_'+id+'\'), detailvalue(\''+id+'\', '+jmldata+', \'persen\')" value="'+discount3_value+'" >');
           
        }
        //-------------------------
        
        
		var amount = 0;
		amount = parseFloat(qty) * parseFloat(unit_price); // - parseFloat(discount); //document.getElementById('amount_'+id).value; 
		amount = number_format(amount,0,".",",");	
		
		
		$('#amount'+id).html('<input type="text" onkeyup="formatangka(\'amount_'+id+'\')" id="amount_'+id+'" name="amount_'+id+'" value="'+amount+'" readonly style="width: 100px; height: 25px; text-align:right; font-size: 14px; color: #000000; font-weight: bold;" class="form-control" >');
		
		sub_total(jmldata);
		
		return false	
		
	 }	 
	 
	 function sub_total(jmldata){ 
		var i=0;
		var jumlah='0';
		var change_amount='0';
		var amount='0';
		
		for(i=0; i<=jmldata; i++){
			
			amount = document.getElementById('amount_'+i).value; //.replace(/[^\d.]/g,"");
			amount = amount.replace(/[^\d-.]/g,"");
			
			if(amount=='') { amount=0 }
			jumlah 	=  parseInt(jumlah) + parseInt(amount);
			
			subtotal2(jumlah);
		}
		
		return false;
	}
	
	function subtotal2(jumlah) {
		var discount = 0;
		discount=document.getElementById('discount').value; 
		discount = discount.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(discount == "") {discount = 0};
		
		jumlah = parseFloat(jumlah) - parseFloat(discount);
		
		var pos_amount = 0;
		pos_amount=document.getElementById('cash_amount').value; 
		pos_amount = pos_amount.replace(/[^\d-.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(pos_amount == "") {pos_amount = 0};
		
		var ovo = 0;
		ovo=document.getElementById('ovo').value; 
		ovo = ovo.replace(/[^\d-.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(ovo == "") {ovo = 0};
		
		var gopay = 0;
		gopay=document.getElementById('gopay').value; 
		gopay = gopay.replace(/[^\d-.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(gopay == "") {gopay = 0};
		
		var cash_voucher = 0;
		cash_voucher=document.getElementById('cash_voucher').value; 
		cash_voucher = cash_voucher.replace(/[^\d-.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(cash_voucher == "") {cash_voucher = 0};
		
		var bank_amount = 0;
		bank_amount=document.getElementById('bank_amount').value; 
		bank_amount = bank_amount.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(bank_amount == "") {bank_amount = 0};
		
		var card_amount = 0;
		card_amount=document.getElementById('card_amount').value; 
		card_amount = card_amount.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(card_amount == "") {card_amount = 0};
		
		change_amount = parseFloat(jumlah) - parseFloat(pos_amount) - parseFloat(bank_amount) - parseFloat(card_amount) - parseFloat(cash_voucher) - parseFloat(ovo) - parseFloat(gopay) ;
		change_amount = change_amount * -1;
		
		
		jumlah = number_format(jumlah,0,".",",");	
		$('#total_id').html('<input type="text" id="total" name="total" readonly style="width: 130px; height: 25px; text-align: right; font-size: 14px; font-weight: bold; color: #000000; font-weight: bold;" class="form-control" onkeyup="formatangka('+total+')" value="'+ jumlah +'"" >');
		
		change_amount = number_format(change_amount,0,".",",");	
		$('#change_amount_id').html('<input type="text" id="change_amount" name="change_amount" readonly="" style="width: 130px; height: 25px; text-align: right; font-size: 14px; font-weight: bold; color: #000000; font-weight: bold;" class="form-control" value="'+ change_amount +'"" >');
		
		change_amount_top = change_amount;
		if( parseFloat(change_amount) < 0) {
			change_amount_top = 0;
		}
		$('#change_amount_id_top').html('<font style="font-size: 20px">'+ change_amount_top +'</font>');
		
		
		
		return false;
	}
	
	
	function sub_total_member(total, jmldata){ 
		var i=0;
		var discmember='0';
		var discmember2='0';
		var memberlimit='0';
		var memberlimit2='0';
		var amount_member='0';
		var totalcek='0';
		var non_discount='0';
		
		amount_member = document.getElementById('amount_member').value;
		totalcek = parseInt(total) + parseInt(amount_member);
		
		for(i=0; i<=jmldata; i++){
			
			memberlimit = document.getElementById('memberlimit'+i).value.replace(/[^\d.]/g,"");
			if(memberlimit=='') { memberlimit=0 }
			memberlimit 	=  parseInt(memberlimit);
			
			discmember = document.getElementById('discmember'+i).value.replace(/[^\d.]/g,"");
			if(discmember=='') { discmember=0 }
			discmember 	=  parseInt(discmember);
			
			if(	memberlimit <= totalcek ) {
				discmember2 = discmember;
			}
			
			//alert(memberlimit);
			
		}
		
		memberlimit = (total * discmember2)/100;
		memberlimit2 = number_format(memberlimit,0,".",",");
		
		$('#total_discount_id').html('<input type="text" id="discount" name="discount" style="width: 100px; height: 25px; text-align: right; font-size: 16px" class="form-control" value="'+ memberlimit2 +'"" >');
		
	}
	
</script>

<script>
	
	function detailvalue2(ketik){		
		var qty = 0;	
		qty=document.getElementById('qty').value; 
		//qty = number_format(qty,0,".",",");
		qty = qty.replace(/[^\d-.]/g,"");
		if(qty == "") {qty = 0};
				
		var unit_price = 0;
		unit_price=document.getElementById('unit_price').value; 
		//unit_price = number_format(unit_price,0,".",",");
		unit_price = unit_price.replace(/[^\d-.]/g,"");
		if(unit_price == "") {unit_price = 0};
		
		var discount = 0;
		discount=document.getElementById('discount_det').value; 
		discount = discount.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(discount == "") {discount = 0};
        
        //discoutn persen
        var discount3 = 0;
		discount3=document.getElementById('discount3_det').value; 
		discount3 = discount3.replace(/[^\d.]/g,""); //discount.replace(/[^\d-.]/g,"");
		if(discount3 == "") {discount3 = 0};
        
        
        //alert(discount3);
        if( ketik == 'persen' ) {
            discount3 = (unit_price * discount3) / 100;
            if(discount3 == "") {discount3 = 0};
            
            discount = discount3;   
        } 
             
        //---------------/\
		unit_price = parseFloat(unit_price) - parseFloat(discount);
		
		var amount = 0;
		amount = parseFloat(qty) * parseFloat(unit_price); // - parseFloat(discount); //document.getElementById('amount_'+id).value; 
		amount = number_format(amount,0,".",",");	
		
        discount_value     = number_format(discount,0,".",",");
        
        
        if( ketik == 'persen' ) {
            $('#discount_det_id').html('<input type="text" onkeyup="formatangka(\'discount_det\'), detailvalue2(\'nominal\')" id="discount_det" name="discount_det" value="'+discount_value+'" style="width: 100px; height: 25px; text-align:right; font-size: 11px; width: 100px" class="form-control" >');
        }
        
        //-------disc nominal
        if( ketik == 'nominal' ) {
            var unit_price_tmp = 0;
    		unit_price_tmp=document.getElementById('unit_price').value; 
    		unit_price_tmp = unit_price_tmp.replace(/[^\d-.]/g,"");
    		if(unit_price_tmp == "") {unit_price_tmp = 0};
            
            discount3 = ( discount / unit_price_tmp) * 100; 
        }   
        
        discount3_value    = number_format(discount3,2,".",",");
        if( ketik == 'nominal' ) {
            $('#discount3_det_id').html('<input type="text" onkeyup="formatangka(\'discount3_det\'), detailvalue2(\'persen\')" id="discount3_det" name="discount3_det" value="'+discount3_value+'" style="width: 100px; height: 25px; text-align:right; font-size: 11px; width: 100px" class="form-control" >');
        }
        //-------------------------
		
		$('#amount_det').html('<input type="text" onkeyup="formatangka(\'amount\')" id="amount" name="amount" value="'+amount+'" readonly style="width: 100px; height: 25px; text-align:right; font-size: 11px; width: 100px" class="form-control" >');
		
		
		return false	
		
	 }	 
</script>

<script language="javascript">

	function hapus(id,line) {
		if (confirm('Apakah Anda yakin akan menghapus data ini?')) {
			document.location.href = "main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&mxKz=xm8r389xemx23xb2378e23&xndf="+id+"&line="+line+" ";
		}
	}
	
	function update(xndf, no) {	
	
		var item_code	= document.getElementById('item_code_'+no).value;
		var uom_code	= document.getElementById('uom_code_'+no).value;
		var line 		= document.getElementById('old_line_'+no).value;
		var qty 		= document.getElementById('qty_'+no).value;
		var unit_price 	= document.getElementById('unit_price_'+no).value;
		var amount 		= document.getElementById('amount_'+no).value;
		var discount3 	= document.getElementById('discount3_'+no).value;
		var ref_near_expired = document.getElementById('ref_near_expired_'+no).value;
		
		document.location.href = "main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&mxKz=upd&xndf="+xndf+"&line="+line+"&qty="+qty+"&unit_price="+unit_price+"&amount="+amount+"&item_code="+item_code+"&uom_code="+uom_code+"&discount3="+discount3+"&ref_near_expired="+ref_near_expired+" ";			
		
	}
	
	function simpan() {	
		
		//document.forms['submit_save'];
		
		$("#pos").attr('action', 'app/pos.php')
		   .attr('target', '_SELF');
		$("#pos").submit();
		
		//document.getElementById("submit_save").submit();
		//document.location.href = "main.php?menu=app&act=<?php echo obraxabrix('pos') ?>";
		
	}
	
	function print() {
		var ref = document.getElementById('ref').value;
		var uid = document.getElementById('uid_print').value;
		
		//window.location = "app/pos_print_create.php?ref="+ref+"&uid="+uid; //localhost only
		window.location = "app/pos_print_create_ol.php?ref="+ref+"&uid="+uid; //internet only
		
	}

	function submitForm(tipe)
    {
    	
    	if(tipe == 'print') {
			//document.getElementById("delord_view").action = "app/delord_print.php";
			$("#pos").attr('action', 'app/pos_print.php')
			   .attr('target', '_BLANK');
			$("#pos").submit();
			
		}
		
		return false;
  			 
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
	
	function focusNext2(elemName, evt) 
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
    
    
    function testprint() {
		var ref = document.getElementById('ref').value;
		
		window.open('app/test_print4.php', 'Invoice Print','825','450','resizable=1,scrollbars=1,status=0,toolbar=0')
	}
    
    function itemhistory() {
		var client_code = document.getElementById('client_code').value;
		
		window.open('app/pos_item_history.php?client_code='+client_code, 'Item History','825','950','resizable=1,scrollbars=1,status=0,toolbar=0')
	}
	
	function chequehistory() {
		var client_code = document.getElementById('client_code').value;
		
		window.open('app/pos_cheque_history.php?client_code='+client_code, 'Cheque History','825','2000','resizable=1,scrollbars=1,status=0,toolbar=0')
	}
</script>

<!--//shortcut-->
<script>
    document.onkeydown = function (e) {
    	switch (e.keyCode) {
    		//F3 (Bayar)
            /*case 114:
            	document.getElementById('cash_amount').focus();
                e.preventDefault();
                break;*/
            
            //F10 (Save)
            /*case 121:
            	submit_save = document.forms.pos.submit_save();
            	alert('xxxxx');
            	document.getElementById('cash_amount').focus();
                e.preventDefault();
                break;*/
                    
            //F7 (Bayar)
            case 118:
            	document.getElementById('cash_amount').focus();
                e.preventDefault();
                break;
            
            //F2 (Kolom Kode Barang)
            case 113:
                document.getElementById('item_code2').focus();
                e.preventDefault();
                break;
                
            //F4 (Ke Kolom Member)
            case 115:
                document.getElementById('client_member_code2').focus();
                e.preventDefault();
                break;
                
            //F1 (Form Baru)
            case 112:
                window.location = 'main.php?menu=app&act=<?php echo obraxabrix(pos) ?>';
                e.preventDefault();
                break;
                
            //F5 (Ke Kolom Voucher)
            /*case 116:
                document.getElementById('cash_voucher').focus();
                e.preventDefault();
                break;
            */
            
            //angka/Slash (Rubah Qty Terakahir)
                
            //Enter
            /*case 13:
                simpan();
                e.preventDefault();
                break;*/
            
        }
        //menghilangkan fungsi default tombol
        /*e.preventDefault();*/
        
    };
</script>

<div id="status"></div>                       
<div class="page-content">
      
	<div class="row">
		<div class="col-xs-12">
            
            <?php 
            	
          		$ref = $_GET['search'];
          		$xndf = $_GET['xndf'];
				
				$approved_overlimit = allow_pos_overlimit($xndf);
				
				//jika saat add data, maka data setelah save kosong
				if ($_POST['submit'] == 'Save') { $ref = ''; }
				//-----------------------------------------------/\
				
				$location_id = $_SESSION['location_id2'];
				$location_id2 = $_SESSION['location_id2'];
				
				$ref2 = notran(date('y-m-d'), 'frmpos_pos', '', '', $_SESSION["id_user"]); 
					
				include("app/exec/pos_insert.php"); 
								
				$date = date("d-m-Y");
				$date_need = date("d-m-Y");
				$due_date = date("d-m-Y");
				$date_tmp = date("Y-m-d");
				                
                $cash = "checked";
				$cash2 = "0";
                
                $admin = $_SESSION["adm"];
                                 
				if($xndf != "") {
					$delete = $_REQUEST['mxKz'];
					
					if ($delete == "xm8r389xemx23xb2378e23" && $post != "Save Detail") {
						include 'class/class.delete.php';
						$delete2=new delete;
						$delete2->delete_pos_detail($_REQUEST['xndf'], $_REQUEST['line']);
					}
					
					if (isset($_REQUEST['mxKz']) == "upd" && $post != "Save Detail") {
						$update2=new update;
						
						$update2->update_pos_detail($_REQUEST['xndf'], $_REQUEST['line'], $_REQUEST['qty'], $_REQUEST['unit_price'], $_REQUEST['amount'], $_REQUEST['item_code'], $_REQUEST['uom_code'], $_REQUEST['discount3'], $_REQUEST['ref_near_expired']);
						
					?>
						<script>
							//window.location = 'main.php?menu=app&act=<?php echo obraxabrix(pos) ?>&xndf=<?php echo $_REQUEST[xndf] ?>'			
						</script>
					<?php	
					}
					
					$sql=$select->list_pos_get_detail($xndf);
					$row_pos=$sql->fetch(PDO::FETCH_OBJ);
					
					$client_code	=	$row_pos->client_code;
                    
                    if($row_pos->cash == 1) {
						$cash = " checked ";
						$cash2 = "1";
					} else {
						$cash = "";
					}
                    
					$deposit 		= 	number_format($row_pos->deposit, 0, '.', ',');
					$discount2 		= 	number_format($row_pos->discount,0,".",",");
					$total 			= 	number_format($row_pos->total, 0, '.', ',');
					
					$upd_approved_over = $row_pos->upd_approved_over;
				}
				
				$shift = $_SESSION["shift"];
				
				$uid = $_SESSION["loginname"];
				$uid_print = $_SESSION["loginname"];
										
				if ($ref != "") {
					$sql=$select->list_pos($ref);
					$row_pos=$sql->fetch(PDO::FETCH_OBJ);	
					
					$ref2 = $row_pos->ref;	
					$ref22 = $row_pos->ref2;
					
					if(!empty($row_pos->shift)) {
						$shift = $row_pos->shift;
					} else {						
						$shift = $_SESSION["shift"];
					}
					
					$uid = $row_pos->uid;
					$date = date("d-m-Y", strtotime($row_pos->date));
					$date_tmp = date("Y-m-d", strtotime($row_pos->date));
					$tax_rate = number_format($row_pos->tax_rate, 0, '.', ',');
					$freight_cost = number_format($row_pos->freight_cost, 0, '.', ',');
					
					$client_code  = $row_pos->client_code;	
					$client_name  = $row_pos->client_name;	
					$total = number_format($row_pos->total, 0, '.', ',');
					$cash_amount = number_format($row_pos->cash_amount,0,".",",");
					$bank_amount = number_format($row_pos->bank_amount,0,".",",");
					$card_amount = number_format($row_pos->card_amount,0,".",",");
					$discount2 = number_format($row_pos->discount,0,".",",");
					$cash_voucher = number_format($row_pos->cash_voucher,0,".",",");
					$ovo = number_format($row_pos->ovo,0,".",",");
					$gopay = number_format($row_pos->gopay,0,".",",");
					
					
					$due_date = date("d-m-Y", strtotime($row_pos->due_date));
					if($row_pos->pos == 1) {
						$pos = " checked ";
						$pos2 = "1";
					} else {
						$pos = "";
					}
					
					$deposit = number_format($row_pos->deposit, 0, '.', ',');
					
					$disabled = "disabled";
                    if($admin == 1) {
                        $disabled = "";
                    }
					
					if($row_pos->taxable == 1) {
						$taxable = "checked";
					}
					
					$location_id = $row_pos->location_id;
                    
                    if($row_pos->cash == 1) {
						$cash = " checked ";
						$cash2 = "1";
					} else {
						$cash = "";
					}
					
					$void = "";
					if($row_pos->void == 1) {
						$void = "checked";
					}
				}	
				
				
				//delete file print temp
				/*$file = "app/".$_REQUEST['file'];
				@unlink($file);*/
				
				$readonly = 'readonly=""';
				if($_SESSION['adm'] == 1) {
					$readonly = "";
				}
					
			?>
            
			<!-- PAGE CONTENT BEGINS -->
			<form class="form-horizontal" role="form" action="" method="post" name="pos" id="pos" enctype="multipart/form-data" onSubmit="return cekinput('ref,date,shift,location_id,client_code');" >
            	
            	<input type="hidden" id="old_location_id" name="old_location_id" value="<?php echo $row_pos->location_id ; ?>" >
            	<input type="hidden" id="client_code2" name="client_code2" value="<?php echo $row_pos->client_code ; ?>" >
            	<input type="hidden" id="old_ref" name="old_ref" value="<?php echo $row_pos->ref ; ?>" >
				
				<input type="hidden" id="xndf" name="xndf" value="<?php echo $xndf ; ?>" >
				
				<input type="hidden" id="client_code" name="client_code" value="<?php echo $_SESSION["client_syscode"] ?>">
				
				<input type="hidden" id="cash" name="cash" value="1">
				
				<input type="hidden" id="location_id" name="location_id" value="<?php echo $location_id ; ?>" >
				
				<input type="hidden" id="uid_print" name="uid_print" value="<?php echo $uid_print ; ?>" >
				<input type="hidden" id="approved_overlimit" name="approved_overlimit" value="<?php echo $approved_overlimit; ?>" >
				<input type="hidden" id="upd_approved_over" name="upd_approved_over" value="<?php echo $upd_approved_over; ?>" >
				
									
					<table border="1" width="100%" cellpadding="2" style="background-color: #010596; color: #ffffff; border: 1px solid #ffffff" >
						<tr>
							<td colspan="2"></td>
						</tr>
						
						<tr>
							<td rowspan="3" width="80%">
								<?php
					            	if ($ref=='') {		
										include_once("pos_detail_input.php");
									} 
								?>
							</td>
							<td>
								<span class="input-icon input-icon-right" style="width: 80px; text-align: right;">
									<label><?php if($lng==1) { echo 'Date'; } else { echo 'Tanggal'; } ?> :</label>
								</span>

								<span class="input-icon input-icon-right">
									<input type="hidden" id="date" name="date" style="font-size: 14px; color: #000000; " <?php if($_SESSION['adm'] == 1) { ?> class="form-control date-picker" data-date-format="dd-mm-yyyy" <?php } ?> <?php echo $readonly ?> value="<?php echo $date ?>">
									<?php echo $date ?>
									<input type="hidden" id="date_tmp" name="date_tmp" value="<?php echo $date_tmp ?>">
								</span>
								
								
								<br>
								<span class="input-icon input-icon-right" style="width: 80px; text-align: right;">
									<label><?php if($lng==1) { echo 'Ref. No.'; } else { echo 'No. Nota'; } ?> :</label>
								</span>

								<span class="input-icon input-icon-right">
									<input type="hidden" id="ref" name="ref" readonly="" style="font-size: 14px; color: #000000;" value="<?php echo $ref2 ?>">
									<?php echo $ref2 ?>
								</span>
								
								<br>
								<span class="input-icon input-icon-right" style="width: 80px; text-align: right;">
									<label><?php if($lng==1) { echo 'Cashier'; } else { echo 'Kasir'; } ?> :</label>
								</span>

								<span class="input-icon input-icon-left">
									<input type="hidden" id="uid" name="uid" readonly="" style="font-size: 14px; color: #000000; width: 100px" class="form-control" value="<?php echo $uid ?>">
									<?php echo $uid ?>
								</span>
								
								<br>
								<span class="input-icon input-icon-right" style="width: 80px; text-align: right;">
									<label><?php if($lng==1) { echo 'Location'; } else { echo 'Unit'; } ?> :</label>
								</span>

								<span class="input-icon input-icon-right">
									<input type="hidden" id="location_id2" name="location_id2" value="<?php echo $location_id ?>" />
									<?php /*
									<select id="location_id2" name="location_id2" class="chosen-select form-control" disabled="" style="width: 130px; font-size: 14px; color: #000000;">
				                        <option value=""></option>
				                        <?php 
				                        	combo_select_active("warehouse","id","name","active","1",$location_id)
				                        ?>	                            
				                      </select>*/ ?>
				                      
				                      <?php echo $_SESSION["location_name"] ?>
								</span>
								
								<br>
								<span class="input-icon input-icon-right" style="width: 80px; text-align: right;">
									<label><?php if($lng==1) { echo 'Shift'; } else { echo 'Shift#'; } ?> :</label>
								</span>
								<span class="input-icon input-icon-right">
									<input type="hidden" id="shift" name="shift" style="font-size: 14px; color: #000000;" class="form-control" <?php echo $readonly ?> value="<?php echo $shift ?>">
									<?php 
										$shift_name = "";
										if($shift == 1) {
											$shift_name = "Pagi";	
										}
										if($shift == 2) {
											$shift_name = "Malam";	
										}
										echo $shift_name; 
									?>
								</span> 
							</td>
						</tr>
						
						<tr>
							<td>&nbsp;</td>
						</tr>
						
						<tr>
							<td>&nbsp;</td>
						</tr>
						
						<tr>
							<td>
								<?php
									if ($ref=='') {	
										//if($xndf != "") {
											include("pos_get_detail.php");
										//}	
									} else {
										include("pos_detail.php");	
									}
								?>
							</td>
							<td align="left" valign="top" style="font-weight: bold; font-size: 20px; border: solid 1px #ffffff">
								<table width="100%">
									<tr>
										<td>&nbsp;TOTAL</td>
										<td>:</td>
										<td align="right">
											<?php
												if($ref == "") {
													$total_atas=$select->list_pos_total_detail($xndf);
													
													$date_day = date("Y-m-d");
													$sqltotdisc = $select->get_outlet_set_price($location_id, $date_day, $total_atas);
													$datatotdisc = $sqltotdisc->fetch(PDO::FETCH_OBJ);
													$discount_total = $datatotdisc->discount_total;
													if($discount_total == '') {
														$discount_total = 0;
													}
													echo number_format($total_atas - $discount_total,0,".",",");
												} else {
													echo $total;
												}
											?>&nbsp;
										</td>
									</tr>
									
									<tr>
										<td width="10%">&nbsp;KEMBALIAN</td>
										<td width="1%"> :</td>
										<td align="right" id="change_amount_id_top">
											<?php echo number_format($row_pos->change_amount,0,".",","); ?>&nbsp;
										</td>
									</tr>
								</table>
								
								<?php if($ref != "") { ?>
			                
				                    <?php if($admin == 0) { ?>
									    <input type="hidden" id="client_code" name="client_code" class="form-control" value="<?php echo $row_cash_invoice->client_code ?>">
				                    <?php } ?>
								<?php } ?>
								
								
								<input type="hidden" id="dlu" name="dlu" readonly="" style="font-size: 12px" class="form-control" value="<?php echo $row_pos->dlu ?>" >
								
								<input type="hidden" id="point" name="point" class="form-control" style="width: auto; font-size: 16px" readonly="" value="<?php echo $row_pos->point; ?>" >
							</td>
						</tr>
						
						<tr>
							<td>
								<div class="clearfix form-actions" style="background-color: #010596; color: #ffffff; border: 1px solid #010596">
								<div class="col-md-offset-3 col-md-9" style="background-color: #010596; color: #ffffff">
			                        
			                        <?php if (allowupd('frmpos_pos')==1) { ?>
			                            <?php if($ref!='') { ?>
			    							<input type="submit" name="submit" id="submit" class='btn btn-primary' value="Update" />
			    						<?php } ?>
			                        <?php } ?>
									
			                        <?php if (allowadd('frmpos_pos')==1) { ?>
			    						<?php if($ref=='') { ?>
			    							<input type="submit" name="submit" id="submit" class='btn btn-primary' value="Save" onClick="return confirm('Apakah data sudah betul?')" />
			    						<?php } ?>
			                        <?php } ?>
			                        
			                        <?php if($ref!='') { ?>
		    							<input type="submit" name="submit" id="submit" class='btn btn-warning' value="Permintaan Void" />
		    						<?php } ?>
		    						
			                        <?php if ($_SESSION['adm'] == 1)  { ////(allowdel('frmpos_pos')==1) ?>
			                            &nbsp;
			    						<input type="submit" name="submit" id="submit" class="btn btn-danger" value="Delete" onClick="return confirm('Apakah Anda yakin akan menghapus data?')" >
			                        <?php } ?>
			                        
			                        <?php if (allowadd('frmpos_pos_view')==1) { ?>
										&nbsp;
										<input type="button" name="submit" id="submit" class="btn btn-success" value="List Data" onclick="self.location='<?php echo $nama_folder . obraxabrix('pos_view') ?>'" />
									<?php } ?>
									
									<?php if($ref!='') { ?>
										&nbsp;&nbsp;&nbsp;
										<input type="button" name="button" class="btn btn-success" value="Print" onclick="print()" >
									<?php } ?>
									
									&nbsp;&nbsp;&nbsp;
									<input type="button" name="submit" id="submit" class="btn btn-success" value="Form Baru" onclick="self.location='<?php echo $nama_folder . obraxabrix(pos) ?>'" />
									        				
									&nbsp;
									<input type="button" name="submit" id="submit" class="btn btn-success" value="Menu Utama" onclick="self.location='<?php echo $nama_folder ?>'" />
									
									<!--&nbsp;&nbsp;&nbsp;
									&nbsp;
									<input type="button" name="submit" id="submit" class="btn btn-success" value="History Cheque" onclick="chequehistory()" />-->
									                      
			                                 
								</div>
							</div>
							</td>
							<td></td>
						</tr>
						
						<tr>
							<td colspan="2">
								<?php include("pos_shortcut.php"); ?>
							</td>
						</tr>
					</table>

				
				

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
	
		
		$('#photo , #photo_1, #photo_2, #photo_3, #photo_4').ace_file_input({
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
