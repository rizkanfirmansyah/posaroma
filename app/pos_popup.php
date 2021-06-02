<div id="my-modal<?php //echo $id_detail ?>" class="modal fade" tabindex="-1">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				<h3 class="smaller lighter blue no-margin">Data Member</h3>
			</div>
			
			<div class="modal-body">
				<?php 
					/*$sqlcln_det = $select->list_client_general($id_detail);
					$data_det = $sqlcln_det->fetch(PDO::FETCH_OBJ);*/
				?>
				<table id="dynamic-table" class="table table-striped table-bordered table-hover" style="font-size: 11px">
					<tr>
						<td width="20%">ID</td>
						<td width="1%">:</td>
						<td>
							<input type="text" value="" />
							<?php 
								/*if($data_det->code2 != "") {
									echo $data_det->code2;
								} else {
									echo $data_det->code;
								}*/
							?>
						</td>
					</tr>
					<tr>
						<td>User ID</td>
						<td>:</td>
						<td><?php //echo $data_det->usrid ?></td>
					</tr>
					<tr>
						<td>Nama</td>
						<td>:</td>
						<td><?php //echo $data_det->name ?></td>
					</tr>
					<tr>
						<td>Nama Bank</td>
						<td>:</td>
						<td><?php //echo $data_det->bank_name ?></td>
					</tr>
					<tr>
						<td>Cabang</td>
						<td>:</td>
						<td><?php //echo $data_det->bank_branch ?></td>
					</tr>
					<tr>
						<td>No Rekeing</td>
						<td>:</td>
						<td><?php //echo $data_det->bank_account_no ?></td>
					</tr>
					<tr>
						<td>A/N</td>
						<td>:</td>
						<td><?php //echo $data_det->bank_account ?></td>
					</tr>
				</table>																				
			</div>

			<div class="modal-footer">
				<button class="btn btn-sm btn-danger pull-right" data-dismiss="modal">
					<i class="ace-icon fa fa-times"></i>
					Close
				</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div>