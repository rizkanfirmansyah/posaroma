<!--CASH MANAGER-->
<?php /*if ( allow("frmcurrency")==1 || allow("frmcurrency_rate_type")==1 || allow("frmcredit_card_type")==1 || allow("frmcash_master")==1 || allow("frmreceipt")==1 || allow("frmpayment")==1 || allow("frmdirect_payment")==1 || allow("frmdirect_receipt")==1 || allow("frmcash_receipt")==1 || allow("frmcash_payment")==1 || allow("frmcoa")==1  ) { ?>

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
			
			<?php if ( allow("frmcoa")==1 ) { ?>	
				<li class="<?php echo $coa_active ?>">
    				<a href="main.php?menu=app&act=<?php echo obraxabrix('coa') ?>">
    					<i class="menu-icon fa fa-caret-right"></i>
    					<?php if ($_SESSION['bahasa']==1) { echo "Chart of Account"; } else { echo "Setup No Akun (CoA)"; } ?>
    				</a>

    				<b class="arrow"></b>
    			</li>
    		<?php } ?>
    			
			<?php if ( allow("frmreceipt")==1 ) { ?>
				<li class="<?php echo $receipt_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('receipt') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Receipt"; } else { echo "Penerimaan Piutang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("frmpayment")==1 ) { ?>
				<li class="<?php echo $payment_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('payment') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Payment"; } else { echo "Pembayaran Hutang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
		</ul>
	</li>
	
<?php 
}*/
?>


<!--allow("frmvendor_pos_type")==1 || -->
<!--PURCHASE DATA-->
<?php if ( allow("frmvendor_pos")==1 || allow("frmpurchase_order")==1 || allow("frmgood_receipt")==1 || allow("frmpurchase_inv_pos")==1 || allow("frmpurchase_return_quick_pos")==1 || allow("frmgood_return")==1 || allow("frmset_vendor_balance")==1 || allow("frmpurchase_quick")==1 || allow("frmpurchase_issue")==1 || allow("rpt_consign_pos")==1 || allow("rpt_varian_pos")==1 || allow("rpt_purchase_inv_item_pos")==1 || allow("rpt_purchase_inv_global_pos")==1 || allow("rpt_purchase_return_item_pos")==1 || allow("rpt_purchase_return_global_pos")==1 || allow("rpt_ap_card")==1   ) { ?>

<!--|| allow("rpt_ap")==1 -->
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
			
			<?php if ( allow("frmpurchase_inv_pos")==1 ) { ?>
				<li class="<?php echo $purchase_inv_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('purchase_inv') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Purchase"; } else { echo "Pembelian"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("frmpurchase_return_quick_pos")==1 ) { ?>
				<li class="<?php echo $purchase_return_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('purchase_return_quick') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Purchase Return"; } else { echo "Retur Pembelian"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("frmvendor_pos")==1 ) { ?>
				<li class="<?php echo $vendor_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('vendor') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Vendor"; } else { echo "Supplier"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>

			<?php if ( allow("rpt_varian_pos")==1 ) { ?>
				<li class="<?php echo $rpt_varian_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_varian') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Varian Price Report"; } else { echo "Lap. Perbandingan Harga"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("rpt_purchase_inv_item_pos")==1 ) { ?>
				<li class="<?php echo $rpt_purchase_inv_item_active ?>">
        				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_purchase_inv_item') ?>">
        					<i class="menu-icon fa fa-caret-right"></i>
        					<?php if ($_SESSION['bahasa']==1) { echo "Item Purchase Report"; } else { echo "Lap. Pembelian Barang"; } ?>
        				</a>

        				<b class="arrow"></b>
        		</li>
        	<?php } ?>
        	
        	<?php if ( allow("rpt_purchase_inv_global_pos")==1 ) { ?>
				<li class="<?php echo $rpt_purchase_inv_global_active ?>">
        				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_purchase_inv_global') ?>">
        					<i class="menu-icon fa fa-caret-right"></i>
        					<?php if ($_SESSION['bahasa']==1) { echo "General Purchase Report"; } else { echo "Lap. Pembelian Global"; } ?>
        				</a>

        				<b class="arrow"></b>
        		</li>
        	<?php } ?>
        	
        	<?php if ( allow("rpt_purchase_return_item_pos")==1 ) { ?>
				<li class="<?php echo $rpt_purchase_return_item_active ?>">
        				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_purchase_return_item') ?>">
        					<i class="menu-icon fa fa-caret-right"></i>
        					<?php if ($_SESSION['bahasa']==1) { echo "Item Purchase Return Report"; } else { echo "Lap. Retur Pembelian Barang"; } ?>
        				</a>

        				<b class="arrow"></b>
        		</li>
        	<?php } ?>
        	
        	<?php if ( allow("rpt_purchase_return_global_pos")==1 ) { ?>
				<li class="<?php echo $rpt_purchase_return_global_active ?>">
        				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_purchase_return_global') ?>">
        					<i class="menu-icon fa fa-caret-right"></i>
        					<?php if ($_SESSION['bahasa']==1) { echo "General Purchase Return Report"; } else { echo "Lap. Retur Pembelian Global"; } ?>
        				</a>

        				<b class="arrow"></b>
        		</li>
        	<?php } ?>
			
			
			<?php /* if ( allow("rpt_ap_card")==1 ) { ?>
				<li class="<?php echo $rpt_ap_card ?>">
    				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_ap_card') ?>">
    					<i class="menu-icon fa fa-caret-right"></i>
    					<?php if ($_SESSION['bahasa']==1) { echo "AP Card"; } else { echo "Kartu Hutang"; } ?>
    				</a>

    				<b class="arrow"></b>
    			</li>
			<?php } ?>
			
			
			<?php if ( allow("rpt_mutation_ap")==1 ) { ?>	
				<li class="<?php echo $rpt_mutation_ap_active ?>">
    				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_mutation_ap') ?>">
    					<i class="menu-icon fa fa-caret-right"></i>
    					<?php if ($_SESSION['bahasa']==1) { echo "AP Mutation"; } else { echo "Lap. Mutasi Hutang"; } ?>
    				</a>

    				<b class="arrow"></b>
    			</li>
    		<?php } */ ?>
			
			<?php if ( allow("rpt_consign_pos")==1 ) { ?>
				<li class="<?php echo $rpt_consign_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_consign') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Cosignment Report"; } else { echo "Lap. Konsinyasi Supplier"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
		    
		    
		    <li class="<?php echo $upload_download_active ?>">
				<a href="main.php?menu=app&act=<?php echo obraxabrix('upload_download') ?>">
					<i class="menu-icon fa fa-caret-right"></i>
					<?php if ($_SESSION['bahasa']==1) { echo "Upload/Download"; } else { echo "Upload/Download"; } ?>
				</a>

				<b class="arrow"></b>
			</li>    
			
		</ul>
	</li>

<?php
}
?>


<!--SALES-->
<?php if ( allow("frmclient_type_pos")==1 || allow("frmclient_pos")==1 || allow("frmprice_type")==1 || allow("frmset_client_balance")==1 || allow("frmmarketing")==1 || allow("frmquotation")==1 || allow("frmsales_order")==1 || allow("frmdelivery_order")==1 || allow("frmsales_invoice")==1 || allow("frmsales_return")==1 || allow("frmdelivery_return")==1 || allow("frmcash_invoice")==1 || allow("rpt_sales_invoice_day")==1 || allow("rpt_ar_day")==1 || allow("frmdelivery_order_quick")==1 || allow("frmdelivery_order_project")==1 || allow("frmsales_invoice_project")==1 || allow("rpt_slsivi_outstanding_shp")==1 || allow("rpt_delord_history")==1 || allow("frmpos_pos")==1 || allow("frmcashier_pos")==1 || allow("frmcashier_box_pos")==1 || allow("frmpos_pos_view")==1 || allow("frmorder_stock")==1 || allow("pos_void_view")==1 || allow("pos_overlimit")==1 ) { ?> 

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
		
			<?php if ( allow("frmpos_pos")==1 ) { ?>
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
			<?php } ?>
				
			<?php if ( allow("frmpos_pos_view")==1 ) { ?>
				<li class="<?php echo $pos_view_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('pos_view') ?>">
    					<i class="menu-icon fa fa-caret-right"></i>
    					<?php if ($_SESSION['bahasa']==1) { echo "List Sales"; } else { echo "Daftar Penjualan"; } ?>
    				</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("pos_void_view")==1 ) { ?>
				<li class="<?php echo $pos_void_view_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('pos_void_view') ?>">
    					<i class="menu-icon fa fa-caret-right"></i>
    					<?php if ($_SESSION['bahasa']==1) { echo "List Sales Void"; } else { echo "Daftar Penjualan Batal"; } ?>
    				</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("pos_overlimit")==1 ) { ?>
				<li class="<?php echo $pos_overlimit_active ?>">
    				<a href="main.php?menu=app&act=<?php echo obraxabrix('pos_overlimit') ?>">
    					<i class="menu-icon fa fa-caret-right"></i>
    					<?php if ($_SESSION['bahasa']==1) { echo "Approval Over Limit"; } else { echo "Approval Over Limit"; } ?>
    				</a>

    				<b class="arrow"></b>
    			</li>
    		<?php } ?>
			
			<?php if ( allow("frmorder_stock")==1 ) { ?>
				<li class="<?php echo $order_stock_active ?>">
    				<a href="main.php?menu=app&act=<?php echo obraxabrix('order_stock') ?>">
    					<i class="menu-icon fa fa-caret-right"></i>
    					<?php if ($_SESSION['bahasa']==1) { echo "Order Stock"; } else { echo "Produk Untuk Pesanan"; } ?>
    				</a>

    				<b class="arrow"></b>
    			</li>
    		<?php } ?>
            			
			<?php if ( allow("frmcashier_pos")==1 ) { ?>
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
			<?php } ?>
			
			<?php if ( allow("frmcashier_box_pos")==1 ) { ?>
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
    		<?php } ?>
			
			<?php if ( allow("frmclient_pos")==1 ) { ?>
				<li class="<?php echo $client_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('client') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Client"; } else { echo "Customer"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("frmclient_type_pos")==1 ) { ?>
				<li class="<?php echo $client_type_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('client_type') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Client Type"; } else { echo "Tipe Customer"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			
		</ul>
	</li>
	
<?php
}
?>



<!--ITEM MAIN-->
<?php 
 if( allow("item_list_pos")==1 || allow("frmset_item_price_pos")==1 || allow("rpt_stock_label_pos")==1 || allow("item_barcode_pos")==1 ) {
 	
?>
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
    			
    			<?php if ( allow("item_list_pos")==1 ) { ?>
					<li class="<?php echo $item_list_active ?>">
						<a href="main.php?menu=app&act=<?php echo obraxabrix('item_list') ?>">
							<i class="menu-icon fa fa-caret-right"></i>
							<?php if ($_SESSION['bahasa']==1) { echo "Item List"; } else { echo "Daftar Barang"; } ?>
						</a>

						<b class="arrow"></b>
					</li>
				<?php } ?>
    			
    			<?php if ( allow("frmset_item_price_pos")==1 ) { ?>
					<li class="<?php echo $set_item_price_active ?>">
						<a href="main.php?menu=app&act=<?php echo obraxabrix('set_item_price_view') ?>">
							<i class="menu-icon fa fa-caret-right"></i>
							<?php if ($_SESSION['bahasa']==1) { echo "Set Item Price"; } else { echo "Setup Harga Barang"; } ?>
						</a>

						<b class="arrow"></b>
					</li>
				<?php } ?>
    			
    			<?php if ( allow("rpt_stock_label_pos")==1 ) { ?>
					<li class="<?php echo $rpt_stock_label_active ?>">
						<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_stock_label') ?>">
							<i class="menu-icon fa fa-caret-right"></i>
							<?php if ($_SESSION['bahasa']==1) { echo "Print Lable"; } else { echo "Cetak Label"; } ?>
						</a>

						<b class="arrow"></b>
					</li>
				<?php } ?>
				
				<?php if ( allow("item_barcode_pos")==1 ) { ?>
					<li class="<?php echo $item_barcode_active ?>">
	    				<a href="main.php?menu=app&act=<?php echo obraxabrix('item_barcode') ?>">
	    					<i class="menu-icon fa fa-caret-right"></i>
	    					<?php if ($_SESSION['bahasa']==1) { echo "Print Item Barcode"; } else { echo "Cetak Barcode Barang"; } ?>
	    				</a>

	    				<b class="arrow"></b>
	    			</li>
    			<?php } ?>
    		
    		</ul>
    	</li>
<?php
}
?>    	
    	
            	
            	
            	
<!--allow("frmitem_type")==1 || allow("frmitem_subgroup")==1 || allow("frmitem_category")==1 || allow("frmcolour")==1 || allow("frmbrand")==1 || allow("frmsize")==1 || -->
<!--INVENTORY CONTROL DATA-->
<?php if ( allow("frmitem_pos")==1 || allow("frmitem_group_pos")==1 || allow("frmuom_pos")==1 || allow("frmreason_adjust")==1 || allow("frmitem_packing")==1 || allow("frminbound")==1 || allow("frmstore_request")==1 || allow("frminvent_adjust")==1 || allow("frmitem_issued")==1 || allow("frmitem_return")==1 || allow("frmitem_balance")==1 || allow("rpt_bincard_vendor")==1 || allow("frmwarehouse_pos")==1 ) { ?>

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
			
			<?php if ( allow("frmitem_pos")==1 ) { ?>
				<li class="<?php echo $item_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('item') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Item Master"; } else { echo "Master Barang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php /*if ( allow("frmitem_type")==1 ) { ?>
				<li class="<?php echo $item_type_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('item_type') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Item Type"; } else { echo "Tipe Barang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php }*/ ?>
			
			<?php if ( allow("frmitem_group_pos")==1 ) { ?>
				<li class="<?php echo $item_group_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('item_group') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Item Group"; } else { echo "Kelompok Barang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php /*if ( allow("frmitem_subgroup")==1 ) { ?>
				<li class="<?php echo $item_subgroup_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('item_subgroup') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Item Sub Group"; } else { echo "Sub Grup Barang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php }*/ ?>
			
			<?php /*if ( allow("frmitem_category")==1 ) { ?>
				<li class="<?php echo $item_category_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('item_category') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Item Category"; } else { echo "Category Barang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php }*/ ?>
			
			<?php if ( allow("frmuom_pos")==1 ) { ?>
				<li class="<?php echo $uom_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('uom') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Unit of Measure"; } else { echo "Satuan"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("frmwarehouse_pos")==1 ) { ?>
				<li class="<?php echo $warehouse_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('warehouse') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Warehouse"; } else { echo "Gudang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			
			<?php /*if ( allow("rpt_bincard")==1 ) { ?>
				<li class="<?php echo $rpt_bincard_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_bincard') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Bin Card Report"; } else { echo "Lap. Kartu Stok"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php }*/ ?>
			
			<?php /*if ( allow("frmbrand")==1 ) { ?>
				<li class="<?php echo $brand_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('brand') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Brand"; } else { echo "Merk"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php }*/ ?>
			
			<?php /*if ( allow("frmsize")==1 ) { ?>
				<li class="<?php echo $size_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('size') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Size"; } else { echo "Ukuran"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php }*/ ?>
			
			
		</ul>
	</li>

<?php
}
?>	




<!--DATA STOCK-->
<?php if ( allow("frmstock_opname_pos")==1 || allow("frmoutbound_pos")==1 || allow("rpt_bincard_pos")==1 || allow("rpt_stock_pos")==1 || allow("rpt_stock_opname_pos")==1 || allow("rpt_stock_value_pos")==1 || allow("rpt_stock_opname_value_pos")==1 ) { ?> 
	<li class="<?php echo $stock_data ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-pencil-square-o"></i>
			<span class="menu-text">
				<?php if ($_SESSION['bahasa']==1) { echo "Stock Data"; } else { echo "Data Stok"; } ?>
			</span>

			<b class="arrow fa fa-angle-down"></b>
		</a>
		    
		<b class="arrow"></b>

		<ul class="submenu">
			
			<?php if ( allow("frmoutbound_pos")==1 ) { ?>
				<li class="<?php echo $item_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('outbound') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Outbound"; } else { echo "Pengeluaran Barang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("frmstock_opname_pos")==1 ) { ?>
				<li class="<?php echo $stock_opname_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('stock_opname') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Stock Opname"; } else { echo "Stok Opname"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("rpt_bincard_pos")==1 ) { ?>
				<li class="<?php echo $rpt_bincard ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_bincard') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Report Bin Card"; } else { echo "Lap. Kartu Stok"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("rpt_stock_pos")==1 ) { ?>
				<li class="<?php echo $rpt_stock_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_stock') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Stock Report"; } else { echo "Lap. Stok Barang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("rpt_stock_value_pos")==1 ) { ?>
				<li class="<?php echo $rpt_stock_value_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_stock_value') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Stock Value Report"; } else { echo "Lap. Stok Nilai Barang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
		    
		    <?php if ( allow("rpt_stock_opname_pos")==1 ) { ?>
				<li class="<?php echo $rpt_stock_opname_active ?>">
    				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_stock_opname') ?>">
    					<i class="menu-icon fa fa-caret-right"></i>
    					<?php if ($_SESSION['bahasa']==1) { echo "Stock Opname Report"; } else { echo "Lap. Stock Opname"; } ?>
    				</a>

    				<b class="arrow"></b>
    			</li>
			<?php } ?>
			
			
			<?php if ( allow("rpt_stock_opname_value_pos")==1 ) { ?>
				<li class="<?php echo $rpt_stock_opname_value_active ?>">
    				<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_stock_opname_value') ?>">
    					<i class="menu-icon fa fa-caret-right"></i>
    					<?php if ($_SESSION['bahasa']==1) { echo "Stock Opname Value Report"; } else { echo "Lap. Nilai Stock Opname"; } ?>
    				</a>

    				<b class="arrow"></b>
    			</li>
    		<?php } ?>
            			
			
			
		</ul>
	</li>
<?php
}
?>



<!--CASH MANAGER-->
<?php if ( allow("frmposition")==1 || allow("frmdepartment")==1 || allow("frmdivision")==1 || allow("frmemployee_pos")==1 || allow("frmweek_wage")==1 ) { ?>

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
			<?php if ( allow("frmemployee_pos")==1 ) { ?>
				<li class="<?php echo $employee_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('employee') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Employee"; } else { echo "Pegawai"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
		</ul>
	</li>

<?php
}
?>	
	

<!--REPORT-->
<?php if ( allow("rpt_ar")==1 || allow("rpt_ap")==1 || allow("rpt_sales_invoice_pos")==1 || allow("rpt_sales_item_pos")==1 || allow("rpt_sales_10_pos")==1 || allow("rpt_sales_global_pos")==1 || allow("rpt_profit_loss_pos")==1 ) { ?>

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
			
			<?php /* if ( allow("rpt_ar")==1 ) { ?>
				<li class="<?php echo $rpt_ar ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_ar') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Account Receivable Report"; } else { echo "Lap. Piutang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("rpt_ap")==1 ) { ?>
			    <li class="<?php echo $rpt_ap ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_ap') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Account Payable Report"; } else { echo "Lap. Hutang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } */ ?>
			
			<?php if ( allow("rpt_sales_invoice_pos")==1 ) { ?>
				<li class="<?php echo $rpt_sales ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_sales') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Sales Report"; } else { echo "Lap. Penjualan"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("rpt_sales_global_pos")==1 ) { ?>
				<li class="<?php echo $rpt_sales_global ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_sales_global') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Sales Global Report"; } else { echo "Lap. Penjualan Global"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("rpt_sales_item_pos")==1 ) { ?>
				<li class="<?php echo $rpt_sales_item ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_sales_item') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Sales Report per Item"; } else { echo "Lap. Penjualan per Barang"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("rpt_sales_10_pos")==1 ) { ?>
				<li class="<?php echo $rpt_sales_10 ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_sales_10') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Report Top 10 Item"; } else { echo "Lap. Penjualan 10 Barang Terbesar"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("rpt_profit_loss_pos")==1 ) { ?>
				<li class="<?php echo $rpt_profit_loss_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('rpt_profit_loss') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Report Profit & Loss"; } else { echo "Lap. Laba & Rugi"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			
		</ul>
	</li>

<?php
}
?>


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
<?php if ( allow("frmcompany")==1 || allow("frmusr")==1 ) { ?>

	<li class="<?php echo $pengaturan_system ?>">
		<a href="#" class="dropdown-toggle">
			<i class="menu-icon fa fa-desktop"></i>
			<span class="menu-text">
				<?php if ($_SESSION['bahasa']==1) { echo "Utility"; } else { echo "Utility"; } ?>
			</span>

			<b class="arrow fa fa-angle-down"></b>
		</a>

		<b class="arrow"></b>

		<ul class="submenu">
			
			<?php if ( allow("frmusr")==1 ) { ?>
				<li class="<?php echo $user_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('usr') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "User"; } else { echo "User"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
			<?php if ( allow("frmcompany")==1 ) { ?>
				<li class="<?php echo $company_active ?>">
					<a href="main.php?menu=app&act=<?php echo obraxabrix('company') ?>">
						<i class="menu-icon fa fa-caret-right"></i>
						<?php if ($_SESSION['bahasa']==1) { echo "Company"; } else { echo "Setup Perusahaan"; } ?>
					</a>

					<b class="arrow"></b>
				</li>
			<?php } ?>
			
		</ul>
	</li>
	
<?php
}
?>


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

                