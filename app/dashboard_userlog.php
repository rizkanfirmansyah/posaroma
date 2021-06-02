<div class="row">
	<div class="col-sm-6">
		<div class="widget-box transparent">
			<div class="widget-header widget-header-flat">
				<h4 class="widget-title lighter">
					<i class="ace-icon fa fa-star orange"></i>
					Status Online/Offline Unit
				</h4>

				<!--<div class="widget-toolbar">
					<a href="#" data-action="collapse">
						<i class="ace-icon fa fa-chevron-up"></i>
					</a>
				</div>-->
			</div>

			<div class="widget-body">
				<div class="widget-main no-padding">
					<table id="dynamic-table" class="table table-striped table-bordered table-hover">
						<thead>
							<tr>
								<th>
									<i class="ace-icon fa fa-caret-right blue"></i>Nama Unit
								</th>

								<th>
									<i class="ace-icon fa fa-caret-right blue"></i>Status
								</th>
							</tr>
						</thead>

						<tbody>
							
							<?php
								$sqlusr = $selectview->dashboard_unit();
								while($data_usr = $sqlusr->fetch(PDO::FETCH_OBJ)) {
									
									//get user
									$sqlusr2 = $selectview->dashboard_user($data_usr->location_id);
									$data_usr2 = $sqlusr2->fetch(PDO::FETCH_OBJ);
									
									//get status log
									$sqlusrsts = $selectview->dashboard_user_log($data_usr->location_id, $data_usr2->usrid);
									$data_usrstatus = $sqlusrsts->fetch(PDO::FETCH_OBJ);
									$bgcol = '';
									if($data_usrstatus->status == 1) {
										$bgcol = 'style="background-color: #0e9c11; color: #ffffff"';
									}
							?>
								<tr>
									<td <?php echo $bgcol ?>><?php echo $data_usr->unit_name ?></td>
									<td align="center">
										<?php if($data_usrstatus->status == 1) { ?>
											<i class="ace-icon fa fa-signal" style="color: #0e9c11"></i>
										<?php } else { ?>
											<i class="ace-icon fa fa-signal" style="color: #ff0000"></i>
										<?php } ?>
									</td>
								</tr>
							<?php
								}
							?>
						</tbody>
					</table>
					
				</div>
			</div>
		</div><!-- /.widget-box -->
	</div><!-- /.col -->
</div><!-- /.row -->


