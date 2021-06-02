<?php
@session_start();

date_default_timezone_set('Asia/Jakarta');

@error_reporting(E_ALL & ~E_NOTICE);

@ob_start();
include_once("app/include/queryfunctions.php");
include_once("app/include/functions.php");
//include_once ("app/include/function_login.php");
//include_once ("app/include/login_check.inc.php");

$dbpdo = DB::create();

include 'app/class/class.select.php';
$select = new select;

include 'app/class/class.selectview.php';
$selectview = new selectview;

$act	= $_GET['act'];
$menu	= $_GET['menu'];

include 'app/new/insert_pos.php';
$new = new pos_new;

$nama_folder = 'main.php?menu=app&act=';

if (($_SESSION["logged"] == 0)) {

	//echo 'Access denied';
	header("Location: home.php");
	exit;
}


##check resolution
if (!isset($_SESSION['lebarlayar'])) {

	echo "<script language=\"JavaScript\">

	document.location=\"$PHP_SELF?r=1&width=\"+screen.width+\"&height=\"+screen.height;

	</script>";

	if (isset($_GET['width']) && isset($_GET['height'])) {
		$_SESSION['lebarlayar'] = $_GET['width'];
		$_SESSION['tinggilayar'] = $_GET['height'];
	}
}
##--------------/\-------------

?>



<!DOCTYPE html>
<html lang="en">

<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
	<meta charset="utf-8" />
	<title>POS (Point of Sales)</title>

	<meta name="description" content="overview &amp; stats" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

	<!-- bootstrap & fontawesome -->
	<link rel="stylesheet" href="assets/css/bootstrap.min.css" />
	<link rel="stylesheet" href="assets/font-awesome/4.2.0/css/font-awesome.min.css" />

	<!-- page specific plugin styles -->
	<link rel="stylesheet" href="assets/css/jquery-ui.custom.min.css" />
	<link rel="stylesheet" href="assets/css/chosen.min.css" />
	<link rel="stylesheet" href="assets/css/datepicker.min.css" />
	<link rel="stylesheet" href="assets/css/bootstrap-timepicker.min.css" />
	<link rel="stylesheet" href="assets/css/daterangepicker.min.css" />
	<link rel="stylesheet" href="assets/css/bootstrap-datetimepicker.min.css" />
	<link rel="stylesheet" href="assets/css/colorpicker.min.css" />


	<!-- text fonts -->
	<link rel="stylesheet" href="assets/fonts/fonts.googleapis.com.css" />

	<!-- ace styles -->
	<link rel="stylesheet" href="assets/css/ace.min.css" class="ace-main-stylesheet" id="main-ace-style" />

	<!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" class="ace-main-stylesheet" />
		<![endif]-->

	<!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

	<!-- inline styles related to this page -->

	<!-- ace settings handler -->
	<script src="assets/js/ace-extra.min.js"></script>

	<!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

	<!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
		<![endif]-->

</head>

<body class="no-skin">

	<div id="navbar" class="navbar navbar-default">
		<script type="text/javascript">
			try {
				ace.settings.check('navbar', 'fixed')
			} catch (e) {}
		</script>


		<?php require("header.php"); ?>


	</div>

	<div class="main-container" id="main-container">
		<script type="text/javascript">
			try {
				ace.settings.check('main-container', 'fixed')
			} catch (e) {}
		</script>
		<!--$act != obraxabrix('cashier_box') && -->
		<?php if ($act != obraxabrix('cashier') && $act != obraxabrix('pos') && $act != obraxabrix('pos_test')) { ?>
			<div id="sidebar" class="sidebar responsive">
				<script type="text/javascript">
					try {
						ace.settings.check('sidebar', 'fixed')
					} catch (e) {}
				</script>


				<div class="sidebar-shortcuts" id="sidebar-shortcuts">
					<div class="sidebar-shortcuts-large" id="sidebar-shortcuts-large">
						<div id="status" style="z-index: 1;"></div>
						<button class="btn btn-success" style="width: 80px">
							<i class="ace-icon fa fa-signal"></i>
						</button>

						<!--<button class="btn btn-danger">
								<i class="ace-icon fa fa-signal"></i>
							</button>-->


						<button class="btn btn-info" style="width: 80px">
							<i class="ace-icon fa fa-pencil"></i>
						</button>

						<!--<button class="btn btn-warning">
								<i class="ace-icon fa fa-users"></i>
							</button>

							<button class="btn btn-danger">
								<i class="ace-icon fa fa-cogs"></i>
							</button>-->
					</div>

					<div class="sidebar-shortcuts-mini" id="sidebar-shortcuts-mini">
						<span class="btn btn-success"></span>

						<span class="btn btn-info"></span>

						<span class="btn btn-warning"></span>

						<span class="btn btn-danger"></span>
					</div>
				</div><!-- /.sidebar-shortcuts -->


				<?php
				require("menu.php");
				?>


				<div class="sidebar-toggle sidebar-collapse" id="sidebar-collapse">
					<i class="ace-icon fa fa-angle-double-left" data-icon1="ace-icon fa fa-angle-double-left" data-icon2="ace-icon fa fa-angle-double-right"></i>
				</div>

				<script type="text/javascript">
					try {
						ace.settings.check('sidebar', 'collapsed')
					} catch (e) {}
				</script>

			</div>
		<?php } ?>

		<div class="main-content">
			<div class="main-content-inner">

				<?php if ($act != obraxabrix('pos') && $act != obraxabrix('pos_test')) { ?>
					<div class="breadcrumbs" id="breadcrumbs">
						<script type="text/javascript">
							try {
								ace.settings.check('breadcrumbs', 'fixed')
							} catch (e) {}
						</script>

						<ul class="breadcrumb">

							<li>
								<i class="ace-icon fa fa-home home-icon"></i>
								<a href="home.php">Home</a>
							</li>
							<?php

							/*EMPLOYEMENT*/
							if ($act == obraxabrix('employee')) {
								echo '<li><a href="#">Employement</a></li><li class="active">Employee</li>';
							}



							/*CASH MANAGER*/
							if ($act == obraxabrix('receipt')) {
								echo '<li><a href="#">Cash Manager</a></li><li class="active">Receipt</li>';
							}
							if ($act == obraxabrix('receipt_view')) {
								echo '<li><a href="#">Cash Manager</a></li><li class="active">Receipt List</li>';
							}
							if ($act == obraxabrix('receipt2')) {
								echo '<li><a href="#">Cash Manager</a></li><li class="active">Receipt</li>';
							}

							if ($act == obraxabrix('payment')) {
								echo '<li><a href="#">Cash Manager</a></li><li class="active">Payment</li>';
							}
							if ($act == obraxabrix('payment_view')) {
								echo '<li><a href="#">Cash Manager</a></li><li class="active">Payment List</li>';
							}

							if ($act == obraxabrix('coa')) {
								echo '<li><a href="#">Cash Manager</a></li><li class="active">Chart of Account</li>';
							}
							if ($act == obraxabrix('coa_view')) {
								echo '<li><a href="#">Cash Manager</a></li><li class="active">Chart of Account List</li>';
							}


							/*UTILITY*/
							if ($act == '') {
								echo '<li><i class="ace-icon fa fa-home home-icon"></i><a href="#">Dashborad</a>
	    							      </li><li class="active">Dashboard</li>';
							}
							if ($act == obraxabrix('usr')) {
								echo '<li><a href="#">Utility</a></li><li class="active">User</li>';
							}
							if ($act == obraxabrix('usr_view')) {
								echo '<li><a href="#">Utility</a></li><li class="active">Daftar User</li>';
							}
							if ($act == obraxabrix('company')) {
								echo '<li><a href="#">Utility</a></li><li class="active">Company</li>';
							}
							if ($act == obraxabrix('company_view')) {
								echo '<li><a href="#">Utility</a></li><li class="active">Daftar Company</li>';
							}
							if ($act == obraxabrix('upload_download')) {
								echo '<li><a href="#">Utility</a></li><li class="active">Upload/Download</li>';
							}
							if ($act == obraxabrix('backup')) {
								echo '<li><a href="#">Utility</a></li><li class="active">Backup Database</li>';
							}



							/*SALES*/
							if ($act == obraxabrix('cashier')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Penjualan Pesanan</li>';
							}
							if ($act == obraxabrix('cashier_view')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Penjualan Pesanan List</li>';
							}
							if ($act == obraxabrix('cashier_list')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Daftar Pesanan</li>';
							}
							if ($act == obraxabrix('cashier_box')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Penjualan Pesanan Kotakan</li>';
							}
							if ($act == obraxabrix('cashier_box_view')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Penjualan Pesanan Kotakan List</li>';
							}
							if ($act == obraxabrix('cashier_box_list')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Daftar Pesanan Kotakan</li>';
							}
							if ($act == obraxabrix('client')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Customer</li>';
							}
							if ($act == obraxabrix('client_view')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Customer List</li>';
							}
							if ($act == obraxabrix('client_type')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Customer Type</li>';
							}
							if ($act == obraxabrix('client_type_view')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Customer Type List</li>';
							}
							if ($act == obraxabrix('set_item_price')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Setup Harga Barang</li>';
							}
							if ($act == obraxabrix('set_item_price_view')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Setup Harga Barang List</li>';
							}
							if ($act == obraxabrix('pos')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Penjualan</li>';
							}
							if ($act == obraxabrix('pos_view')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Penjualan List</li>';
							}
							if ($act == obraxabrix('pos_void_view')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Penjualan Void List</li>';
							}
							if ($act == obraxabrix('pos_modal')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Modal Kasir</li>';
							}
							if ($act == obraxabrix('pos_print_create')) {
								echo '<li><a href="#">Sales</a></li><li class="active">POS Kasir</li>';
							}
							if ($act == obraxabrix('order_stock')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Pesanan Stok</li>';
							}
							if ($act == obraxabrix('order_stock_view')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Pesanan Stok List</li>';
							}
							if ($act == obraxabrix('pos_overlimit')) {
								echo '<li><a href="#">Sales</a></li><li class="active">Approval Over Limit</li>';
							}


							//==========PURCHASING
							if ($act == obraxabrix('purchase_inv')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Pembelian</li>';
							}
							if ($act == obraxabrix('purchase_inv_view')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Pembelian List</li>';
							}

							if ($act == obraxabrix('purchase_return')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Purchase Return</li>';
							}
							if ($act == obraxabrix('purchase_return_view')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Purchase Return List</li>';
							}

							if ($act == obraxabrix('purchase_return_quick')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Purchase Return</li>';
							}
							if ($act == obraxabrix('purchase_return_quick_view')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Purchase Return List</li>';
							}

							if ($act == obraxabrix('vendor')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Supplier</li>';
							}
							if ($act == obraxabrix('vendor_view')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Supplier List</li>';
							}

							if ($act == obraxabrix('vendor_type')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Tipe Supplier</li>';
							}
							if ($act == obraxabrix('vendor_type_view')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Tipe Supplier List</li>';
							}

							if ($act == obraxabrix('rpt_ap_card')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Kartu Hutang</li>';
							}

							if ($act == obraxabrix('rpt_consign')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Lap. Konsinyasi Supplier</li>';
							}

							if ($act == obraxabrix('rpt_purchase_inv_item')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Lap. Pembelian Barang</li>';
							}

							if ($act == obraxabrix('rpt_purchase_inv_global')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Lap. Pembelian Global</li>';
							}

							if ($act == obraxabrix('rpt_purchase_return_item')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Lap. Retur Pembelian Barang</li>';
							}

							if ($act == obraxabrix('rpt_purchase_return_global')) {
								echo '<li><a href="#">Purchasing</a></li><li class="active">Lap. Retur Pembelian Global</li>';
							}




							/*ASSET*/
							if ($act == obraxabrix('asset_trans')) {
								echo '<li><a href="#">Asset Management</a></li><li class="active">Aset Transaksi</li>';
							}
							if ($act == obraxabrix('asset_trans_view')) {
								echo '<li><a href="#">Asset Management</a></li><li class="active">Aset Transaksi List</li>';
							}

							if ($act == obraxabrix('asset')) {
								echo '<li><a href="#">Asset Management</a></li><li class="active">Master Aset</li>';
							}
							if ($act == obraxabrix('asset_view')) {
								echo '<li><a href="#">Asset Management</a></li><li class="active">Master Aset List</li>';
							}

							if ($act == obraxabrix('asset_type')) {
								echo '<li><a href="#">Asset Management</a></li><li class="active">Tipe Aset</li>';
							}
							if ($act == obraxabrix('asset_type_view')) {
								echo '<li><a href="#">Asset Management</a></li><li class="active">Tipe Aset List</li>';
							}

							if ($act == obraxabrix('astloc')) {
								echo '<li><a href="#">Asset Management</a></li><li class="active">Lokasi Aset</li>';
							}
							if ($act == obraxabrix('astloc_view')) {
								echo '<li><a href="#">Asset Management</a></li><li class="active">Lokasi Aset List</li>';
							}


							/*INVENTORY CONTROL*/
							if ($act == obraxabrix('outbound')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Pengeluaran Barang</li>';
							}
							if ($act == obraxabrix('outbound_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Pengeluaran Barang List</li>';
							}

							if ($act == obraxabrix('item')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Master Barang</li>';
							}
							if ($act == obraxabrix('item_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Master Barang List</li>';
							}
							if ($act == obraxabrix('item_day_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Barang Baru List</li>';
							}

							if ($act == obraxabrix('uom_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Satuan List</li>';
							}

							if ($act == obraxabrix('item_type')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Tipe Barang</li>';
							}
							if ($act == obraxabrix('item_type_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Tipe Barang List</li>';
							}

							if ($act == obraxabrix('item_group')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Grup Barang</li>';
							}
							if ($act == obraxabrix('item_group_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Grup Barang List</li>';
							}

							if ($act == obraxabrix('item_subgroup')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Sub Grup Barang</li>';
							}
							if ($act == obraxabrix('item_subgroup_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Sub Grup Barang List</li>';
							}

							if ($act == obraxabrix('item_category')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Kategori Barang</li>';
							}
							if ($act == obraxabrix('item_category_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Kategori Barang List</li>';
							}

							if ($act == obraxabrix('uom')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Satuan</li>';
							}
							if ($act == obraxabrix('uom_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Satuan List</li>';
							}

							if ($act == obraxabrix('warehouse')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Gudang</li>';
							}
							if ($act == obraxabrix('warehouse_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Gudang List</li>';
							}

							if ($act == obraxabrix('colour')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Warna</li>';
							}
							if ($act == obraxabrix('colour_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Warna List</li>';
							}

							if ($act == obraxabrix('brand')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Merk</li>';
							}
							if ($act == obraxabrix('brand_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Merk List</li>';
							}

							if ($act == obraxabrix('size')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Ukuran</li>';
							}
							if ($act == obraxabrix('size_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Ukuran List</li>';
							}

							if ($act == obraxabrix('stock_opname')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Stok Opname</li>';
							}
							if ($act == obraxabrix('stock_opname_view')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Stok Opname List</li>';
							}
							if ($act == obraxabrix('stock_opname_list')) {
								echo '<li><a href="#">Inventory Control</a></li><li class="active">Stok Opname</li>';
							}

							if ($act == obraxabrix('item_list')) {
								echo '<li><a href="#">Data Umum</a></li><li class="active">Daftar Barang</li>';
							}

							/*if ( $act == obraxabrix('rpt_bincard') ) {  
	                                    echo '<li><a href="#">Inventory Control</a></li><li class="active">Lap. Kartu Stok</li>';
	                                }*/







							/*OPTION/SETUP*/
							if ($act == obraxabrix('setjrn_csr')) {
								echo '<li><a href="#">Option/Setup</a></li><li class="active">Setup Jurnal Kasir</li>';
							}


							##REPORT
							if ($act == obraxabrix('rpt_ar')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Piutang</li>';
							}

							if ($act == obraxabrix('rpt_sales')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Penjualan</li>';
							}

							if ($act == obraxabrix('rpt_sales_global')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Penjualan Global</li>';
							}

							if ($act == obraxabrix('rpt_sales_item')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Penjualan per Barang</li>';
							}

							if ($act == obraxabrix('rpt_sales_10')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Penjualan 10 Barang Tertinggi</li>';
							}

							if ($act == obraxabrix('rpt_ap')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Hutang</li>';
							}

							if ($act == obraxabrix('rpt_stock')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Stok Barang</li>';
							}

							if ($act == obraxabrix('rpt_bincard')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Kartu Stok</li>';
							}

							if ($act == obraxabrix('rpt_stock_opname')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Stock Opname</li>';
							}

							if ($act == obraxabrix('rpt_varian')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Perbandingan Harga</li>';
							}

							if ($act == obraxabrix('rpt_stock_label')) {
								echo '<li><a href="#">Report</a></li><li class="active">Cetak Label</li>';
							}

							if ($act == obraxabrix('item_barcode')) {
								echo '<li><a href="#">Report</a></li><li class="active">Cetak Barcode Barang</li>';
							}

							if ($act == obraxabrix('rpt_stock_value')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Stok Nilai Barang</li>';
							}

							if ($act == obraxabrix('rpt_profit_loss')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Laba & Rugi</li>';
							}

							if ($act == obraxabrix('rpt_stock_opname_value')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Nilai Stock Opname</li>';
							}

							if ($act == obraxabrix('rpt_mutation_ap')) {
								echo '<li><a href="#">Report</a></li><li class="active">Lap. Mutasi Hutang</li>';
							}

							?>


						</ul><!-- /.breadcrumb -->

						<div class="nav-search" id="nav-search">
							<form class="form-search">
								<span class="input-icon">
									<input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
									<i class="ace-icon fa fa-search nav-search-icon"></i>
								</span>
							</form>
						</div><!-- /.nav-search -->
					</div>
				<?php } ?>


				<?php

				if ($act == '') {
					include_once("dashboard.php");
				}

				##utility
				if ($act == obraxabrix('usr')) {
					include_once("app/usr.php");
				}
				if ($act == obraxabrix('usr_view')) {
					include_once("app/usr_view.php");
				}
				if ($act == obraxabrix('usr_change')) {
					include_once("app/usr_change.php");
				}
				if ($act == obraxabrix('company')) {
					include_once("app/company.php");
				}
				if ($act == obraxabrix('company_view')) {
					include_once("app/company_view.php");
				}
				if ($act == obraxabrix('upload_download')) {
					include_once("app/upload_download.php");
				}
				if ($act == obraxabrix('backup')) {
					include_once("app/backup.php");
				}


				if ($act == obraxabrix('coa')) {
					include_once("app/coa.php");
				}
				if ($act == obraxabrix('coa_view')) {
					include_once("app/coa_view.php");
				}

				if ($act == obraxabrix('tax')) {
					include_once("app/tax.php");
				}
				if ($act == obraxabrix('tax_view')) {
					include_once("app/tax_view.php");
				}
				if ($act == obraxabrix('itm')) {
					include_once("app/itm.php");
				}
				if ($act == obraxabrix('itm_view')) {
					include_once("app/itm_view.php");
				}
				if ($act == obraxabrix('asset')) {
					include_once("app/asset.php");
				}
				if ($act == obraxabrix('asset_view')) {
					include_once("app/asset_view.php");
				}
				if ($act == obraxabrix('asset_type')) {
					include_once("app/asset_type.php");
				}
				if ($act == obraxabrix('asset_type_view')) {
					include_once("app/asset_type_view.php");
				}
				if ($act == obraxabrix('asset_trans')) {
					include_once("app/asset_trans.php");
				}
				if ($act == obraxabrix('asset_trans_view')) {
					include_once("app/asset_trans_view.php");
				}


				##Inventory Control
				if ($act == obraxabrix('warehouse')) {
					include_once("app/warehouse.php");
				}
				if ($act == obraxabrix('warehouse_view')) {
					include_once("app/warehouse_view.php");
				}
				if ($act == obraxabrix('item')) {
					include_once("app/item.php");
				}
				if ($act == obraxabrix('item_view')) {
					include_once("app/item_view.php");
				}
				if ($act == obraxabrix('item_day_view')) {
					include_once("app/item_day_view.php");
				}
				if ($act == obraxabrix('uom')) {
					include_once("app/uom.php");
				}
				if ($act == obraxabrix('uom_view')) {
					include_once("app/uom_view.php");
				}
				if ($act == obraxabrix('colour')) {
					include_once("app/colour.php");
				}
				if ($act == obraxabrix('colour_view')) {
					include_once("app/colour_view.php");
				}
				if ($act == obraxabrix('brand')) {
					include_once("app/brand.php");
				}
				if ($act == obraxabrix('brand_view')) {
					include_once("app/brand_view.php");
				}
				if ($act == obraxabrix('size')) {
					include_once("app/size.php");
				}
				if ($act == obraxabrix('size_view')) {
					include_once("app/size_view.php");
				}
				if ($act == obraxabrix('outbound')) {
					include_once("app/outbound.php");
				}
				if ($act == obraxabrix('outbound_view')) {
					include_once("app/outbound_view.php");
				}
				if ($act == obraxabrix('item_type')) {
					include_once("app/item_type.php");
				}
				if ($act == obraxabrix('item_type_view')) {
					include_once("app/item_type_view.php");
				}
				if ($act == obraxabrix('item_group')) {
					include_once("app/item_group.php");
				}
				if ($act == obraxabrix('item_group_view')) {
					include_once("app/item_group_view.php");
				}
				if ($act == obraxabrix('item_subgroup')) {
					include_once("app/item_subgroup.php");
				}
				if ($act == obraxabrix('item_subgroup_view')) {
					include_once("app/item_subgroup_view.php");
				}
				if ($act == obraxabrix('stock_opname')) {
					include_once("app/stock_opname.php");
				}
				if ($act == obraxabrix('stock_opname_view')) {
					include_once("app/stock_opname_view.php");
				}
				if ($act == obraxabrix('stock_opname_list')) {
					include_once("app/stock_opname_list.php");
				}

				if ($act == obraxabrix('item_category')) {
					include_once("app/item_category.php");
				}
				if ($act == obraxabrix('item_category_view')) {
					include_once("app/item_category_view.php");
				}
				if ($act == obraxabrix('rpt_bincard')) {
					include_once("app/rpt_bincard.php");
				}
				if ($act == obraxabrix('rpt_stock')) {
					include_once("app/rpt_stock.php");
				}
				if ($act == obraxabrix('rpt_stock_value')) {
					include_once("app/rpt_stock_value.php");
				}

				if ($act == obraxabrix('item_list')) {
					include_once("app/item_list.php");
				}


				##Purchasing
				if ($act == obraxabrix('vendor_type')) {
					include_once("app/vendor_type.php");
				}
				if ($act == obraxabrix('vendor_type_view')) {
					include_once("app/vendor_type_view.php");
				}
				if ($act == obraxabrix('vendor')) {
					include_once("app/vendor.php");
				}
				if ($act == obraxabrix('vendor_view')) {
					include_once("app/vendor_view.php");
				}
				if ($act == obraxabrix('purchase_quick')) {
					include_once("app/purchase_quick.php");
				}
				if ($act == obraxabrix('purchase_quick_view')) {
					include_once("app/purchase_quick_view.php");
				}
				if ($act == obraxabrix('purchase_return')) {
					include_once("app/purchase_return.php");
				}
				if ($act == obraxabrix('purchase_return_view')) {
					include_once("app/purchase_return_view.php");
				}
				if ($act == obraxabrix('purchase_return_quick')) {
					include_once("app/purchase_return_quick.php");
				}
				if ($act == obraxabrix('purchase_return_quick_view')) {
					include_once("app/purchase_return_quick_view.php");
				}
				if ($act == obraxabrix('purchase_inv')) {
					include_once("app/purchase_inv.php");
				}
				if ($act == obraxabrix('purchase_inv_view')) {
					include_once("app/purchase_inv_view.php");
				}
				if ($act == obraxabrix('rpt_ap')) {
					include_once("app/rpt_ap.php");
				}
				if ($act == obraxabrix('rpt_consign')) {
					include_once("app/rpt_consign.php");
				}
				if ($act == obraxabrix('rpt_purchase_inv_item')) {
					include_once("app/rpt_purchase_inv_item.php");
				}
				if ($act == obraxabrix('rpt_purchase_inv_global')) {
					include_once("app/rpt_purchase_inv_global.php");
				}
				if ($act == obraxabrix('rpt_purchase_return_item')) {
					include_once("app/rpt_purchase_return_item.php");
				}
				if ($act == obraxabrix('rpt_purchase_return_global')) {
					include_once("app/rpt_purchase_return_global.php");
				}
				if ($act == obraxabrix('rpt_ap_card')) {
					include_once("app/rpt_ap_card.php");
				}
				if ($act == obraxabrix('rpt_mutation_ap')) {
					include_once("app/rpt_mutation_ap.php");
				}



				##Sales
				if ($act == obraxabrix('client')) {
					include_once("app/client.php");
				}
				if ($act == obraxabrix('client_view')) {
					include_once("app/client_view.php");
				}
				if ($act == obraxabrix('client_type')) {
					include_once("app/client_type.php");
				}
				if ($act == obraxabrix('client_type_view')) {
					include_once("app/client_type_view.php");
				}
				if ($act == obraxabrix('cashier')) {
					include_once("app/cashier.php");
				}
				if ($act == obraxabrix('cashier_view')) {
					include_once("app/cashier_view.php");
				}
				if ($act == obraxabrix('cashier_list')) {
					include_once("app/cashier_list.php");
				}
				if ($act == obraxabrix('cashier_box')) {
					include_once("app/cashier_box.php");
				}
				if ($act == obraxabrix('cashier_box_view')) {
					include_once("app/cashier_box_view.php");
				}
				if ($act == obraxabrix('cashier_box_list')) {
					include_once("app/cashier_box_list.php");
				}
				if ($act == obraxabrix('set_item_price')) {
					include_once("app/set_item_price.php");
				}
				if ($act == obraxabrix('set_item_price_view')) {
					include_once("app/set_item_price_view.php");
				}
				if ($act == obraxabrix('pos')) {
					// include_once("app/pos.php");
					// ===========================================================================================
					// ===========================================================================================
					// ===========================================================================================
					// ===========================================================================================
					$data = $new->check_invoice() + 1;
					header("location: app/pos_new.php?code=20" . date('Ymd') . rand(122345, 2329792) . '0000' . $data, true, 301);
					exit();
				}
				if ($act == obraxabrix('pos_view')) {
					include_once("app/pos_view.php");
				}
				if ($act == obraxabrix('pos_void_view')) {
					include_once("app/pos_void_view.php");
				}
				if ($act == obraxabrix('pos_modal')) {
					include_once("app/pos_modal.php");
				}
				if ($act == obraxabrix('pos_print_create')) {
					include_once("app/pos_print_create.php");
				}
				if ($act == obraxabrix('order_stock')) {
					include_once("app/order_stock.php");
				}
				if ($act == obraxabrix('order_stock_view')) {
					include_once("app/order_stock_view.php");
				}
				if ($act == obraxabrix('pos_overlimit')) {
					include_once("app/pos_overlimit.php");
				}


				#Employement
				if ($act == obraxabrix('employee')) {
					include_once("app/employee.php");
				}
				if ($act == obraxabrix('employee_view')) {
					include_once("app/employee_view.php");
				}

				##Cash Manager
				if ($act == obraxabrix('receipt')) {
					include_once("app/receipt.php");
				}
				if ($act == obraxabrix('receipt_view')) {
					include_once("app/receipt_view.php");
				}
				if ($act == obraxabrix('receipt2')) {
					include_once("app/receipt2.php");
				}
				if ($act == obraxabrix('payment')) {
					include_once("app/payment.php");
				}
				if ($act == obraxabrix('payment_view')) {
					include_once("app/payment_view.php");
				}
				if ($act == obraxabrix('payment2')) {
					include_once("app/payment_get.php");
				}

				##Option		                
				if ($act == obraxabrix('setjrn_csr')) {
					include_once("app/setjrn_csr.php");
				}
				if ($act == obraxabrix('setjrn_csr_view')) {
					include_once("app/setjrn_csr_view.php");
				}

				##Report
				if ($act == obraxabrix('rpt_ar')) {
					include_once("app/rpt_ar.php");
				}
				if ($act == obraxabrix('rpt_ap')) {
					include_once("app/rpt_ap.php");
				}
				if ($act == obraxabrix('rpt_bincard')) {
					include_once("app/rpt_bincard.php");
				}
				if ($act == obraxabrix('rpt_sales')) {
					include_once("app/rpt_sales.php");
				}
				if ($act == obraxabrix('rpt_sales_global')) {
					include_once("app/rpt_sales_global.php");
				}
				if ($act == obraxabrix('rpt_sales_item')) {
					include_once("app/rpt_sales_item.php");
				}
				if ($act == obraxabrix('rpt_sales_10')) {
					include_once("app/rpt_sales_10.php");
				}
				if ($act == obraxabrix('rpt_varian')) {
					include_once("app/rpt_varian.php");
				}
				if ($act == obraxabrix('rpt_stock_label')) {
					include_once("app/rpt_stock_label.php");
				}
				if ($act == obraxabrix('rpt_stock_opname')) {
					include_once("app/rpt_stock_opname.php");
				}
				if ($act == obraxabrix('rpt_profit_loss')) {
					include_once("app/rpt_profit_loss.php");
				}
				if ($act == obraxabrix('rpt_stock_opname_value')) {
					include_once("app/rpt_stock_opname_value.php");
				}
				if ($act == obraxabrix('item_barcode')) {
					include_once("app/item_barcode.php");
				}
				if ($act == obraxabrix('pos_test')) {
					include_once("app/pos_test.php");
				}

				?>


			</div>
		</div><!-- /.main-content -->


		<?php require("footer.php"); ?>

		<a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
			<i class="ace-icon fa fa-angle-double-up icon-only bigger-110"></i>
		</a>
	</div><!-- /.main-container -->



</body>

</html>