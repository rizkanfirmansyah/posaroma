<?php
@session_start();

if ($act == '' ) {  
    $dashboard = "active open";
} 


/*EMPLOYEMENT*/
if ( $act == obraxabrix('employee') || $act == obraxabrix('employee_view') ) {  
    $employment = "active open";
    $employee_active = "active";
}


/*CASH MANAGER*/
if ( $act == obraxabrix('receipt') || $act == obraxabrix('receipt2') || $act == obraxabrix('receipt_view') ) {  
    $cash_manager = "active open";
    $receipt_active = "active";
} 
if ( $act == obraxabrix('payment') || $act == obraxabrix('payment2') || $act == obraxabrix('payment2') || $act == obraxabrix('payment_view') ) {  
    $cash_manager = "active open";
    $payment_active = "active";
}
if ( $act == obraxabrix('coa') || $act == obraxabrix('coa_view') ) {  
    $cash_manager = "active open";
    $coa_active = "active";
}



//=====>Modul Pengaturan
if ( $act == obraxabrix('usr') ) {  
    $pengaturan_system = "active open";
    $user_active = "active";
} 
if ( $act == obraxabrix('usr_view') ) { 
    $pengaturan_system = "active open";
    $user_active = "active"; 
} 
if ( $act == obraxabrix('company') || $act == obraxabrix('company_view') ) {  
    $pengaturan_system = "active open";
    $company_active = "active";
}



/*download/upload*/
if ( $act == obraxabrix('upload_download') ) { 
    $download_upload = "active open";
    $upload_download_active = "active"; 
}
if ( $act == obraxabrix('backup') ) { 
    $download_upload = "active open";
    $backup_active = "active"; 
}


/*SALES*/
if ( $act == obraxabrix('cashier') || $act == obraxabrix('cashier_view') ) {  
    $sales = "active open";
    $cashier_active = "active";
}
if ( $act == obraxabrix('cashier_list') ) {  
    $sales = "active open";
    $cashier_list_active = "active";
} 
if ( $act == obraxabrix('cashier_box') || $act == obraxabrix('cashier_box_view') ) {  
    $sales = "active open";
    $cashier_box_active = "active";
}
if ( $act == obraxabrix('order_stock') || $act == obraxabrix('order_stock_view') ) {  
    $sales = "active open";
    $order_stock_active = "active";
}
if ( $act == obraxabrix('cashier_box_list') ) {  
    $sales = "active open";
    $cashier_box_list_active = "active";
}
if ( $act == obraxabrix('client') || $act == obraxabrix('client_view') ) {  
    $sales = "active open";
    $client_active = "active";
} 
if ( $act == obraxabrix('client_type') || $act == obraxabrix('client_type_view') ) {  
    $sales = "active open";
    $client_type_active = "active";
} 
if ( $act == obraxabrix('pos') || $act == obraxabrix('pos_modal') ) {  
    $sales = "active open";
    $pos_active = "active";
}
if ( $act == obraxabrix('pos_view') ) {  
    $sales = "active open";
    $pos_view_active = "active";
} 
if ( $act == obraxabrix('pos_void_view') ) {  
    $sales = "active open";
    $pos_void_view_active = "active";
}
if ( $act == obraxabrix('pos_overlimit') ) {  
    $sales = "active open";
    $pos_overlimit_active = "active";
}





//======Modul Purchasing
if ( $act == obraxabrix('vendor_type') || $act == obraxabrix('vendor_type_view') ) {  
    $purchasing = "active open";
    $vendor_type_active = "active";
} 
if ( $act == obraxabrix('vendor') || $act == obraxabrix('vendor_view') ) {  
    $purchasing = "active open";
    $vendor_active = "active"; 
} 
if ( $act == obraxabrix('purchase_quick') || $act == obraxabrix('purchase_quick_view') ) {  
    $purchasing = "active open";
    $purchase_quick_active = "active"; 
} 
if ( $act == obraxabrix('purchase_return') || $act == obraxabrix('purchase_return_view') ) {  
    $purchasing = "active open";
    $purchase_return_active = "active";
}
if ( $act == obraxabrix('purchase_return_quick') || $act == obraxabrix('purchase_return_quick_view') ) {  
    $purchasing = "active open";
    $purchase_return_quick_active = "active";
}
if ( $act == obraxabrix('purchase_inv') || $act == obraxabrix('purchase_inv_view') ) {  
    $purchasing = "active open";
    $purchase_inv_active = "active"; 
}

if ( $act == obraxabrix('rpt_consign') ) {  
    $purchasing = "active open";
    $rpt_consign_active = "active"; 
}
if ( $act == obraxabrix('rpt_varian') ) {  
    $purchasing = "active open";
    $rpt_varian_active = "active";
}
if ( $act == obraxabrix('rpt_purchase_inv_item') ) {  
    $purchasing = "active open";
    $rpt_purchase_inv_item_active = "active";
}
if ( $act == obraxabrix('rpt_purchase_inv_global') ) {  
    $purchasing = "active open";
    $rpt_purchase_inv_global_active = "active";
}
if ( $act == obraxabrix('rpt_purchase_return_item') ) {  
    $purchasing = "active open";
    $rpt_purchase_return_item_active = "active";
}
if ( $act == obraxabrix('rpt_purchase_return_global') ) {  
    $purchasing = "active open";
    $rpt_purchase_return_global_active = "active";
}
if ( $act == obraxabrix('rpt_ap_card') ) {  
    $purchasing = "active open";
    $rpt_ap_card = "active";
}



if ( $act == obraxabrix('vhc') || $act == obraxabrix('vhc_view') ) {  
    $masterdata = "active open";
    $vhc_active = "active";
}
if ( $act == obraxabrix('dst_price') || $act == obraxabrix('dst_price_view') ) {  
    $masterdata = "active open";
    $dst_price_active = "active";
}
if ( $act == obraxabrix('dst') || $act == obraxabrix('dst_view') ) {  
    $masterdata = "active open";
    $dst_active = "active";
}
if ( $act == obraxabrix('tax') || $act == obraxabrix('tax_view') ) {  
    $masterdata = "active open";
    $tax_active = "active";
}
 
     
     
//INVENTORY CONTROL
if ( $act == obraxabrix('item') || $act == obraxabrix('item_view') || $act == obraxabrix('item_day_view') ) {  
    $inventory_control = "active open";
    $item_active = "active";
}
if ( $act == obraxabrix('item_type') || $act == obraxabrix('item_type_view') ) {  
    $inventory_control = "active open";
    $item_type_active = "active";
}  
if ( $act == obraxabrix('item_group') || $act == obraxabrix('item_group_view') ) {  
    $inventory_control = "active open";
    $item_group_active = "active";
} 
if ( $act == obraxabrix('item_subgroup') || $act == obraxabrix('item_subgroup_view') ) {  
    $inventory_control = "active open";
    $item_subgroup_active = "active";
} 
if ( $act == obraxabrix('item_category') || $act == obraxabrix('item_category_view') ) {  
    $inventory_control = "active open";
    $item_category_active = "active";
} 
if ( $act == obraxabrix('uom') || $act == obraxabrix('uom_view') ) {  
    $inventory_control = "active open";
    $uom_active = "active";
} 

if ( $act == obraxabrix('warehouse') || $act == obraxabrix('warehouse_view') ) {  
    $inventory_control = "active open";
    $warehouse_active = "active";
}
if ( $act == obraxabrix('colour') || $act == obraxabrix('colour_view') ) {  
    $inventory_control = "active open";
    $colour_active = "active";
}
if ( $act == obraxabrix('brand') || $act == obraxabrix('brand_view') ) {  
    $inventory_control = "active open";
    $brand_active = "active";
}
if ( $act == obraxabrix('size') || $act == obraxabrix('size_view') ) {  
    $inventory_control = "active open";
    $size_active = "active";
}


/*if ( $act == obraxabrix('rpt_bincard') ) {  
    $inventory_control = "active open";
    $rpt_bincard_active = "active";
}*/


//DATA STOCK
if ( $act == obraxabrix('outbound') || $act == obraxabrix('outbound_view') ) {  
    $stock_data = "active open";
    $outbound_active = "active";
}
if ( $act == obraxabrix('stock_opname') || $act == obraxabrix('stock_opname_view') || $act == obraxabrix('stock_opname_list') ) {  
    $stock_data = "active open";
    $stock_opname_active = "active";
}
if ( $act == obraxabrix('rpt_stock') ) {  
    $stock_data = "active open";
    $rpt_stock_active = "active";
}
if ( $act == obraxabrix('rpt_stock_value') ) {  
    $stock_data = "active open";
    $rpt_stock_value_active = "active";
}

if ( $act == obraxabrix('rpt_stock_opname') ) {  
    $stock_data = "active open";
    $rpt_stock_opname_active = "active";
}
if ( $act == obraxabrix('rpt_bincard') ) {  
    $stock_data = "active open";
    $rpt_bincard = "active";
}
if ( $act == obraxabrix('rpt_stock_opname_value') ) {  
    $stock_data = "active open";
    $rpt_stock_opname_value_active = "active";
}




//ITEM / BARANG
if ( $act == obraxabrix('item_list') ) {  
    $item_main = "active open";
    $item_list_active = "active";
}
if ( $act == obraxabrix('set_item_price') || $act == obraxabrix('set_item_price_view') ) {  
    $item_main = "active open";
    $set_item_price_active = "active";
}
if ( $act == obraxabrix('rpt_stock_label') ) {  
    $item_main = "active open";
    $rpt_stock_label_active = "active";
}
if ( $act == obraxabrix('item_barcode') ) {  
    $item_main = "active open";
    $item_barcode_active = "active";
}

     
     
//ASSET
if ( $act == obraxabrix('asset_trans') || $act == obraxabrix('asset_trans_view') ) {  
    $assetdata = "active open";
    $asset_trans_active = "active";
}    
if ( $act == obraxabrix('asset') || $act == obraxabrix('asset_view') ) {  
    $assetdata = "active open";
    $asset_active = "active";
} 
if ( $act == obraxabrix('asset_type') || $act == obraxabrix('asset_type_view') ) {  
    $assetdata = "active open";
    $asset_type_active = "active";
} 
if ( $act == obraxabrix('astloc') || $act == obraxabrix('astloc_view') ) {  
    $assetdata = "active open";
    $astloc_active = "active";
} 
            

/*OPTION/SETUP*/   
if ( $act == obraxabrix('setjrn_csr') ) {  
    $optionsetup = "active open";
    $setjrn_csr_active = "active";
}          
                    
               
     
//REPORT
if ( $act == obraxabrix('rpt_ar') ) {  
    $report = "active open";
    $rpt_ar = "active";
} 

if ( $act == obraxabrix('rpt_ap') ) {  
    $report = "active open";
    $rpt_ap = "active";
}
if ( $act == obraxabrix('rpt_sales') ) {  
    $report = "active open";
    $rpt_sales = "active";
}
if ( $act == obraxabrix('rpt_sales_global') ) {  
    $report = "active open";
    $rpt_sales_global = "active";
}
if ( $act == obraxabrix('rpt_sales_item') ) {  
    $report = "active open";
    $rpt_sales_item = "active";
}
if ( $act == obraxabrix('rpt_sales_10') ) {  
    $report = "active open";
    $rpt_sales_10 = "active";
}
if ( $act == obraxabrix('rpt_profit_loss') ) {  
    $report = "active open";
    $rpt_profit_loss_active = "active";
}
if ( $act == obraxabrix('rpt_ap') ) {  
    $report = "active open";
    $rpt_ap_active = "active"; 
}
if ( $act == obraxabrix('rpt_mutation_ap') ) {  
    $report = "active open";
    $rpt_mutation_ap_active = "active"; 
}

                                
?>

<ul class="nav nav-list">
	<li class="">
		<a href="home.php">
			<i class="menu-icon fa fa-tachometer"></i>
			<span class="menu-text"> Dashboard </span>
		</a>

		<b class="arrow"></b>
	</li>
    
    
      <?php
      
      if($_SESSION["adm"] == 1) {
      	
      ?>
      			<?php /*
      			<!--CASH MANAGER-->
                <li class="<?php echo $cash_manager ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-list-alt"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Cash Manager"; } else { echo "Control Kas"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>

            		<b class="arrow"></b>

            		<ul class="submenu">
            			<li class="<?php echo $coa_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('coa') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Chart of Account"; } else { echo "Setup No Akun (CoA)"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $receipt_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('receipt') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Receipt"; } else { echo "Penerimaan Piutang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $payment_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('payment') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Payment"; } else { echo "Pembayaran Hutang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            		</ul>
            	</li> */ ?>
            	
            	
            
                <!--PURCHASE DATA-->
                <li class="<?php echo $purchasing ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-pencil-square-o"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Purchasing"; } else { echo "Pembelian"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>
                    
            		<b class="arrow"></b>

            		<ul class="submenu">
            			
            			<li class="<?php echo $purchase_inv_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('purchase_inv') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Purchase"; } else { echo "Pembelian"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<?php /*
            			<li class="<?php echo $purchase_return_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('purchase_return') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Purchase Return"; } else { echo "Retur Pembelian"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>*/ ?>
            			
            			<li class="<?php echo $purchase_return_quick_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('purchase_return_quick') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Purchase Return"; } else { echo "Retur Pembelian"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			
            			<li class="<?php echo $vendor_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('vendor') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Vendor"; } else { echo "Supplier"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>

						
						<li class="<?php echo $rpt_varian_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_varian') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Variant Price Report"; } else { echo "Lap. Perbandingan Harga"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
						<li class="<?php echo $rpt_purchase_inv_item_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_purchase_inv_item') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Item Purchase Report"; } else { echo "Lap. Pembelian Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_purchase_inv_global_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_purchase_inv_global') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "General Purchase Report"; } else { echo "Lap. Pembelian Global"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_purchase_return_item_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_purchase_return_item') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Item Purchase Return Report"; } else { echo "Lap. Retur Pembelian Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_purchase_return_global_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_purchase_return_global') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "General Purchase Return Report"; } else { echo "Lap. Retur Pembelian Global"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			            			
            			<?php /*
            			<li class="<?php echo $rpt_ap_card ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_ap_card') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "AP Card"; } else { echo "Kartu Hutang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_mutation_ap_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_mutation_ap') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "AP Mutation"; } else { echo "Lap. Mutasi Hutang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>*/ ?>
            			
            			<?php /*
            			<li class="<?php echo $rpt_consign_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_consign') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Cosignment Report"; } else { echo "Lap. Konsinyasi Supplier"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>*/ ?>
                        
            			
            		</ul>
            	</li>
            	
            	
                <!--SALES-->
                <li class="<?php echo $sales ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-list-alt"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Sales"; } else { echo "Penjualan"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>

            		<b class="arrow"></b>

            		<ul class="submenu">
            			<li class="<?php echo $pos_active ?>">
            				<!--<a href="main.php?menu=app&act=<?php echo obraxabrix('pos') ?>" target="_blank">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "POS Sales"; } else { echo "Kasir POS"; } ?>
            				</a>-->
            				
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('pos_modal') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "POS Sales"; } else { echo "Kasir POS"; } ?>
            				</a>
            				
            				
            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $pos_view_active ?>">
							<a href="main.php?menu=app&act=<?php echo obraxabrix('pos_view') ?>">
		    					<i class="menu-icon fa fa-caret-right"></i>
		    					<?php if ($_SESSION['bahasa']==1) { echo "List Sales"; } else { echo "Daftar Penjualan"; } ?>
		    				</a>

							<b class="arrow"></b>
						</li>
						
						<li class="<?php echo $pos_void_view_active ?>">
							<a href="main.php?menu=app&act=<?php echo obraxabrix('pos_void_view') ?>">
		    					<i class="menu-icon fa fa-caret-right"></i>
		    					<?php if ($_SESSION['bahasa']==1) { echo "List Sales Void"; } else { echo "Daftar Penjualan Batal"; } ?>
		    				</a>

							<b class="arrow"></b>
						</li>
						
						<li class="<?php echo $pos_overlimit_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('pos_overlimit') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Approval Over Limit"; } else { echo "Approval Over Limit"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $order_stock_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('order_stock') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Order Stock"; } else { echo "Produk Untuk Pesanan"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $cashier_active ?>">
            				<!--<a href="main.php?menu=app&act=<?php echo obraxabrix('cashier') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Cashier"; } else { echo "Kasir"; } ?>
            				</a>-->
            				
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('cashier') ?>" target="_blank">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Whole Sales"; } else { echo "Penjualan Pesanan "; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $cashier_list_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('cashier_list') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Sales Cash Order"; } else { echo "Daftar Pesanan"; } ?>
            				</a>
            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $cashier_box_active ?>">
            				<!--<a href="main.php?menu=app&act=<?php echo obraxabrix('cashier') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Cashier"; } else { echo "Kasir"; } ?>
            				</a>-->
            				
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('cashier_box') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Whole Sales Box"; } else { echo "Pesanan Kotakan"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $cashier_box_list_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('cashier_box_list') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Sales Box List"; } else { echo "Daftar Pesanan Kotakan"; } ?>
            				</a>
            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $client_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('client') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Client"; } else { echo "Customer"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $client_type_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('client_type') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Client Type"; } else { echo "Tipe Customer"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			
            			
            			
            		</ul>
            	</li>
                
                
                <!--ASSET-->
                <!--<li class="<?php echo $assetdata ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-tag"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Asset Management"; } else { echo "Asset Management"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>

            		<b class="arrow"></b>

            		<ul class="submenu">
            			
            			<li class="<?php echo $asset_trans_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('asset_trans') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Aset Transaksi"; } else { echo "Aset Transaksi"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>

            			<li class="<?php echo $asset_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('asset') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Asset Master"; } else { echo "Master Aset"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
                        
                        <li class="<?php echo $asset_type_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('asset_type') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Asset Type"; } else { echo "Tipe Aset"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>-->
                        
                        <!--<li class="<?php echo $astloc_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('astloc') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Asset Location"; } else { echo "Lokasi Aset"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>-->
<!--
            			
            		</ul>
            	</li>-->
                
                
                <!--ITEM MAIN-->
                <li class="<?php echo $item_main ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-pencil-square-o"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Item Data"; } else { echo "Barang"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>
                    
            		<b class="arrow"></b>

            		<ul class="submenu">
            			
            			<li class="<?php echo $item_list_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('item_list') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Item List"; } else { echo "Daftar Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $set_item_price_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('set_item_price_view') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Set Item Price"; } else { echo "Setup Harga Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_stock_label_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_stock_label') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Print Lable"; } else { echo "Cetak Label"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $item_barcode_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('item_barcode') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Print Item Barcode"; } else { echo "Cetak Barcode Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            		
            		</ul>
            	</li>
            	
            	
            		
            			
                
                <!--INVENTORY CONTROL DATA-->
                <li class="<?php echo $inventory_control ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-pencil-square-o"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "General Data"; } else { echo "Data Umum"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>
                    
            		<b class="arrow"></b>

            		<ul class="submenu">
            			
            			
            			<li class="<?php echo $item_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('item') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Item Master"; } else { echo "Master Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<?php /*
            			<li class="<?php echo $item_type_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('item_type') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Item Type"; } else { echo "Tipe Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li> */ ?>
            			
            			<li class="<?php echo $item_group_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('item_group') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Item Group"; } else { echo "Kelompok Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<?php /*
            			<li class="<?php echo $item_subgroup_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('item_subgroup') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Item Sub Group"; } else { echo "Sub Grup Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $item_category_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('item_category') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Item Category"; } else { echo "Category Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li> */ ?>
            			
            			<li class="<?php echo $uom_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('uom') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Unit of Measure"; } else { echo "Satuan"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $warehouse_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('warehouse') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Warehouse"; } else { echo "Gudang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			
            			
            			
            			
            			
            			
            			<?php /*
            			<li class="<?php echo $rpt_bincard_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_bincard') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Bin Card Report"; } else { echo "Lap. Kartu Stok"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li> */ ?>
            			
            			<?php /*
            			<li class="<?php echo $brand_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('brand') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Brand"; } else { echo "Merk"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $size_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('size') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Size"; } else { echo "Ukuran"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li> */ ?>
            			
            			
            			
            		</ul>
            	</li>	
            	
            	
            	
            	<!--DATA STOCK-->
                <li class="<?php echo $stock_data ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-pencil-square-o"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Stock Data"; } else { echo "Data Stock"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>
                    
            		<b class="arrow"></b>

            		<ul class="submenu">
            			
            			<li class="<?php echo $outbound_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('outbound') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Outbound"; } else { echo "Pengeluaran Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $stock_opname_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('stock_opname') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Stock Opname"; } else { echo "Stok Opname"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_stock_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_stock') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Stock Report"; } else { echo "Lap. Stok Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_stock_value_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_stock_value') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Stock Value Report"; } else { echo "Lap. Stok Nilai Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_stock_opname_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_stock_opname') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Stock Opname Report"; } else { echo "Lap. Stock Opname"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_stock_opname_value_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_stock_opname_value') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Stock Opname Value Report"; } else { echo "Lap. Nilai Stock Opname"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_bincard ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_bincard') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Report Bin Card"; } else { echo "Lap. Kartu Stok"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			            			
            			
            		</ul>
            	</li>	
            			
            	
            	
            	<!--CASH MANAGER-->
                <li class="<?php echo $employment ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-list-alt"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Employment"; } else { echo "Kepegawaian"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>

            		<b class="arrow"></b>

            		<ul class="submenu">
            			<li class="<?php echo $employee_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('employee') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Employee"; } else { echo "Pegawai"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            		</ul>
            	</li>
            	
                <!--REPORT-->
                <li class="<?php echo $report ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-file-o"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Reports"; } else { echo "Laporan"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>

            		<b class="arrow"></b>

            		<ul class="submenu">
            			
            			<?php /*
            			<li class="<?php echo $rpt_ar ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_ar') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Account Receivable Report"; } else { echo "Lap. Piutang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_ap ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_ap') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Account Payable Report"; } else { echo "Lap. Hutang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>*/ ?>
            			
            			<li class="<?php echo $rpt_sales ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_sales') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Sales Report"; } else { echo "Lap. Penjualan"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_sales_global ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_sales_global') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Sales Global Report"; } else { echo "Lap. Penjualan Global"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_sales_item ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_sales_item') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Sales Report per Item"; } else { echo "Lap. Penjualan per Barang"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_sales_10 ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_sales_10') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Report Top 10 Item"; } else { echo "Lap. Penjualan 10 Barang Terbesar"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $rpt_profit_loss_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_profit_loss') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Report Profit & Loss"; } else { echo "Lap. Laba & Rugi"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			
            			
            		</ul>
            	</li>
                
                
                <!--SETUP-->
                <?php /*<li class="<?php echo $optionsetup ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-list"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Setup/Option"; } else { echo "Setup/Option"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>

            		<b class="arrow"></b>

            		<ul class="submenu">
            			
            			<li class="<?php echo $setjrn_csr_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('setjrn_csr') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Setup Jurnal Kasir"; } else { echo "Setup Jurnal Kasir"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>

            			
            		</ul>
            	</li> */ ?>
                
                
                
                <!--SYSTEM MANAGER-->
                <li class="<?php echo $pengaturan_system ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-desktop"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Setup User"; } else { echo "Setup User"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>

            		<b class="arrow"></b>

            		<ul class="submenu">
            			
            			<li class="<?php echo $user_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('usr') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "User"; } else { echo "User"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $company_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('company') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Company"; } else { echo "Setup Perusahaan"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>

            			
            		</ul>
            	</li>
                
                
                
                <!--DOWNLOAD/UPLOAD-->
                <li class="<?php echo $download_upload ?>">
            		<a href="#" class="dropdown-toggle">
            			<i class="menu-icon fa fa-desktop"></i>
            			<span class="menu-text">
            				<?php if ($_SESSION['bahasa']==1) { echo "Download/Upload"; } else { echo "Download/Upload"; } ?>
            			</span>

            			<b class="arrow fa fa-angle-down"></b>
            		</a>

            		<b class="arrow"></b>

            		<ul class="submenu">
            			
            			
						<li class="<?php echo $upload_download_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('upload_download') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Upload/Download"; } else { echo "Upload/Download"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>
            			
            			<li class="<?php echo $backup_active ?>">
            				<a href="main.php?menu=app&act=<?php echo obraxabrix('backup') ?>">
            					<i class="menu-icon fa fa-caret-right"></i>
            					<?php if ($_SESSION['bahasa']==1) { echo "Backup Database"; } else { echo "Backup Database"; } ?>
            				</a>

            				<b class="arrow"></b>
            			</li>

            			
            		</ul>
            	</li>
                
                
    <?php
    
    ##menu user
    } else {
		
		include("menu_user.php");
		
	}
    ?>
</ul><!-- /.nav-list -->