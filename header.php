<!--start check status online-->
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

			if (status.innerHTML == "online".toUpperCase()) {
				//alert("online");
				window.location = 'http://pos.erparoma.com';
			}

			if (status.innerHTML == "offline".toUpperCase()) {
				//alert("offline");
				//window.location = 'http://localhost:8080/aromapos';
				window.location = 'http://localhost/aromapos';
			}
			//log.insertAdjacentHTML("beforeend", "Event: " + event.type + "; Status: " + condition);
		}

		window.addEventListener('online', updateOnlineStatus);
		window.addEventListener('offline', updateOnlineStatus);
	});
</script>

<!--<div id="status"></div>-->
<!--end check status online-->



<div class="navbar-container" id="navbar-container">
	<button type="button" class="navbar-toggle menu-toggler pull-left" id="menu-toggler" data-target="#sidebar">
		<span class="sr-only">&nbsp;</span>

		<span class="icon-bar"></span>

		<span class="icon-bar"></span>

		<span class="icon-bar"></span>
	</button>

	<div class="navbar-header pull-left">
		<a href="home.php" class="navbar-brand">
			<small>
				<!--<i class="fa fa-leaf"></i>-->
				AROMA BAKERY & CAKE SHOP
			</small>
		</a>
	</div>

	<div class="navbar-buttons navbar-header pull-right" role="navigation">
		<ul class="nav ace-nav">

			<li class="green">
				<a data-toggle="dropdown" class="dropdown-toggle" href="#" title="Online">
					<i class="ace-icon fa fa-signal"></i>
				</a>
			</li>

			<!--========APPROVAL LIMIT==========-->
			<?php if (allow("pos_overlimit") == 1) { ?>
				<?php
				$strloc = "";
				if (area_manager_location() != "") {
					$loc_id = area_manager_location();
					$sqlstr = "select a.location_id from store_unit_detail a left join store_unit b on a.id=b.id where b.location_id='$loc_id' order by a.id";
					$sql = $dbpdo->prepare($sqlstr);
					$sql->execute();
					while ($data = $sql->fetch(PDO::FETCH_OBJ)) {
						if ($strloc == "") {
							$strloc = "'" . $data->location_id . "'";
						} else {
							$strloc = $strloc . ", '" . $data->location_id . "'";
						}
					}
				}

				if (supervisor_location() != "") {
					$strloc = "'" . supervisor_location() . "'";
				}

				/*if (user_location_central() != "") {
						$strloc = "'ndf'";
					}*/

				if ($_SESSION['adm'] == 1) {
					$strloc = "";
				}

				$from_date = date("Y-m-d");
				$sqlmc = $selectview->notif_cashier_approved_limit($strloc);
				$rowsmc = $sqlmc->rowCount();
				$refmc = array();
				$tanggalmc = array();
				while ($databookmc = $sqlmc->fetch(PDO::FETCH_OBJ)) {
					$refmc[] = $databookmc->ref;
					$name_mcbook[] = $databookmc->uid;
					$tanggalmc[] = number_format($databookmc->amount, 0, '.', ','); //date("d-m-Y", strtotime($databookmc->date));
				}

				?>

				<?php if ($rowsmc > 0) { ?>
					<li class="red">
						<a data-toggle="dropdown" class="dropdown-toggle" href="#" title="Approval Limit">
							<i class="ace-icon fa fa-bell icon-animated-bell"></i>
							<span class="badge badge-warning"><?php echo $rowsmc ?></span>
						</a>

						<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
							<li class="dropdown-header">
								<i class="ace-icon fa fa-exclamation-triangle"></i>
								<?php echo $rowsmc ?> Approval Limit
							</li>

							<li class="dropdown-content">
								<ul class="dropdown-menu dropdown-navbar">
									<?php
									for ($x = 0; $x < count($tanggalmc); $x++) {
									?>
										<li>
											<!--<a href="<?php echo $__folder ?><?php echo obraxabrix('cashier_box') ?>/<?php echo $refmc[$x] ?>" class="clearfix" data-rel="tooltip" title="List Data">-->
											<a href="main.php?menu=app&act=<?php echo obraxabrix('pos_overlimit') ?>&search=<?php echo $refmc[$x] ?>" class="tooltip-success" data-rel="tooltip" title="Void Data">
												<div class="clearfix">
													<span class="pull-left">
														<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
														<?php echo $name_mcbook[$x] . ' | ' . $tanggalmc[$x] ?>
													</span>
													<!--<span class="pull-right badge badge-info">+12</span>-->
												</div>
											</a>
										</li>
									<?php
									}
									?>
								</ul>
							</li>
						</ul>
					</li>
				<?php } ?>
			<?php } ?>

			<!--========PERMINTAN VOID==========-->
			<?php
			$strloc = "";
			if (area_manager_location() != "") {
				$loc_id = area_manager_location();
				$sqlstr = "select a.location_id from store_unit_detail a left join store_unit b on a.id=b.id where b.location_id='$loc_id' order by a.id";
				$sql = $dbpdo->prepare($sqlstr);
				$sql->execute();
				while ($data = $sql->fetch(PDO::FETCH_OBJ)) {
					if ($strloc == "") {
						$strloc = "'" . $data->location_id . "'";
					} else {
						$strloc = $strloc . ", '" . $data->location_id . "'";
					}
				}
			}

			if (supervisor_location() != "") {
				$strloc = "'" . supervisor_location() . "'";
			}

			if (user_location_central() != "") {
				$strloc = "'ndf'";
			}

			if ($_SESSION['adm'] == 1) {
				$strloc = "";
			}

			$from_date = date("Y-m-d");
			$sqlmc = $selectview->notif_cashier_request_void($strloc);
			$rowsmc = $sqlmc->rowCount();
			$refmc = array();
			$tanggalmc = array();
			while ($databookmc = $sqlmc->fetch(PDO::FETCH_OBJ)) {
				$refmc[] = $databookmc->ref;
				$name_mcbook[] = $databookmc->code;
				$tanggalmc[] = date("d-m-Y", strtotime($databookmc->date));
			}

			?>

			<?php if ($rowsmc > 0) { ?>
				<li class="red">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#" title="Permintaan Void">
						<i class="ace-icon fa fa-bell icon-animated-bell"></i>
						<span class="badge badge-warning"><?php echo $rowsmc ?></span>
					</a>

					<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-exclamation-triangle"></i>
							<?php echo $rowsmc ?> Permintaan Void
						</li>

						<li class="dropdown-content">
							<ul class="dropdown-menu dropdown-navbar">
								<?php
								for ($x = 0; $x < count($tanggalmc); $x++) {
								?>
									<li>
										<!--<a href="<?php echo $__folder ?><?php echo obraxabrix('cashier_box') ?>/<?php echo $refmc[$x] ?>" class="clearfix" data-rel="tooltip" title="List Data">-->
										<a href="main.php?menu=app&act=<?php echo obraxabrix('pos') ?>&search=<?php echo $refmc[$x] ?>" class="tooltip-success" data-rel="tooltip" title="Void Data">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
													<?php echo $refmc[$x] ?>
												</span>
												<!--<span class="pull-right badge badge-info">+12</span>-->
											</div>
										</a>
									</li>
								<?php
								}
								?>
							</ul>
						</li>
					</ul>
				</li>
			<?php } ?>

			<!--========PESANAN==========-->
			<?php
			$from_date = date("Y-m-d");
			$sqlmc = $selectview->notif_cashier_box();
			$rowsmc = $sqlmc->rowCount();
			$refmc = array();
			$tanggalmc = array();
			$officer_name = array();
			while ($databookmc = $sqlmc->fetch(PDO::FETCH_OBJ)) {
				$refmc[] = $databookmc->ref;
				$name_mcbook[] = $databookmc->code;
				$tanggalmc[] = date("d-m-Y", strtotime($databookmc->date));
				$objekmc[] = $databookmc->activity;
				$officer_name[] = $databookmc->name;
			}

			?>

			<?php if ($rowsmc > 0) { ?>
				<li class="red">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#" title="Piutang Lewat Jatuh Tempo">
						<i class="ace-icon fa fa-bell icon-animated-bell"></i>
						<span class="badge badge-success"><?php echo $rowsmc ?></span>
					</a>

					<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-exclamation-triangle"></i>
							<?php echo $rowsmc ?> Lewat Jatuh Tempo (Kotakan)
						</li>

						<li class="dropdown-content">
							<ul class="dropdown-menu dropdown-navbar">
								<?php
								for ($x = 0; $x < count($tanggalmc); $x++) {
								?>
									<li>
										<a href="main.php?menu=app&act=<?php echo obraxabrix('cashier_box') ?>&search=<?php echo $refmc[$x] ?>" class="tooltip-success" data-rel="tooltip" title="List Data">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
													<?php echo $refmc[$x] . ' / ' . $tanggalmc[$x] ?>
												</span>
												<!--<span class="pull-right badge badge-info">+12</span>-->
											</div>
										</a>
									</li>
								<?php
								}
								?>
							</ul>
						</li>

						<li class="dropdown-footer">
							<a href="main.php?menu=app&act=<?php echo obraxabrix('cashier_box_list') ?>">
								Lihat History
								<i class="ace-icon fa fa-arrow-right"></i>
							</a>
						</li>
					</ul>
				</li>
			<?php } ?>


			<!--========PESANAN (KOTAKAN)==========-->
			<?php
			$from_date = date("Y-m-d");
			$sqlmc = $selectview->notif_cashier();
			$rowsmc = $sqlmc->rowCount();
			$refmc = array();
			$tanggalmc = array();
			$officer_name = array();
			while ($databookmc = $sqlmc->fetch(PDO::FETCH_OBJ)) {
				$refmc[] = $databookmc->ref;
				$name_mcbook[] = $databookmc->code;
				$tanggalmc[] = date("d-m-Y", strtotime($databookmc->date));
				$objekmc[] = $databookmc->activity;
				$officer_name[] = $databookmc->name;
			}

			?>

			<?php if ($rowsmc > 0) { ?>
				<li class="purple">
					<a data-toggle="dropdown" class="dropdown-toggle" href="#" title="Piutang Lewat Jatuh Tempo">
						<i class="ace-icon fa fa-bell icon-animated-bell"></i>
						<span class="badge badge-important"><?php echo $rowsmc ?></span>
					</a>

					<ul class="dropdown-menu-right dropdown-navbar dropdown-menu dropdown-caret dropdown-close">
						<li class="dropdown-header">
							<i class="ace-icon fa fa-exclamation-triangle"></i>
							<?php echo $rowsmc ?> Lewat Jatuh Tempo
						</li>

						<li class="dropdown-content">
							<ul class="dropdown-menu dropdown-navbar">
								<?php
								for ($x = 0; $x < count($tanggalmc); $x++) {
								?>
									<li>
										<a href="main.php?menu=app&act=<?php echo obraxabrix('cashier') ?>&search=<?php echo $refmc[$x] ?>" class="tooltip-success" data-rel="tooltip" title="List Data">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-pink fa fa-comment"></i>
													<?php echo $refmc[$x] . ' / ' . $tanggalmc[$x] ?>
												</span>
												<!--<span class="pull-right badge badge-info">+12</span>-->
											</div>
										</a>
									</li>
								<?php
								}
								?>
							</ul>
						</li>

						<li class="dropdown-footer">
							<a href="main.php?menu=app&act=<?php echo obraxabrix('cashier_list') ?>">
								Lihat History
								<i class="ace-icon fa fa-arrow-right"></i>
							</a>
						</li>
					</ul>
				</li>
			<?php } ?>

			<li class="light-blue">
				<a data-toggle="dropdown" href="#" class="dropdown-toggle">
					<!--<img class="nav-user-photo" src="app/photo_user/<?php echo $_SESSION['photo'] ?>" alt="Jason's Photo" />-->
					<span class="user-info">
						<?php echo $_SESSION["loginname"] ?>
					</span>

					<i class="ace-icon fa fa-caret-down"></i>
				</a>

				<ul class="user-menu dropdown-menu-right dropdown-menu dropdown-yellow dropdown-caret dropdown-close">
					<li>
						<a href="main.php?menu=app&act=<?php echo obraxabrix('usr_change') ?>">
							<i class="ace-icon fa fa-cog"></i>
							Ganti Password
						</a>
					</li>

					<li>
						<a href="#">
							<i class="ace-icon fa fa-user"></i>
							Profile
						</a>
					</li>

					<li class="divider"></li>

					<li>
						<?php
						$timeout = 1043200; // Set timeout menit
						$timeout = $timeout * 60; // Ubah menit ke detik

						if (isset($_SESSION['start_time'])) {
							$elapsed_time = time() - $_SESSION['start_time'];
							if ($elapsed_time >= $timeout) {
								session_unset();
								session_destroy();
								header("Location: home.php");
						?>

						<?php
							}
						}
						$_SESSION['start_time'] = time();
						?>
						<a href="logout.php">
							<i class="ace-icon fa fa-power-off"></i>
							Logout
						</a>
					</li>
				</ul>
			</li>
		</ul>
	</div>
</div><!-- /.navbar-container -->