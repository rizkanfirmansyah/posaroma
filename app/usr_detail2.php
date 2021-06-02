<div class="col-sm-5">
	<div class="widget-box">
		<div class="widget-header">
			<h4 class="widget-title">Cabang Akses</h4>
		</div>
        
        <table id="simple-table" class="table table-striped table-bordered table-hover">

            <thead>
        		<tr>            
        			<th>Nama Cabang</th> 
					<th align="center">Pilih</th>
        		</tr>
        	</thead>
            

        	<tbody>
                
            <?php 
            	
            	$sql=$select->list_brn();
				$jmldata2 = $sql->rowCount();
            	
                $no = 0;					
            	while($row_brn=$sql->fetch(PDO::FETCH_OBJ)) { 
        		$no++;
            ?>
            
                    <input type="hidden" id="jmldata2" name="jmldata2" value="<?php echo $jmldata2; ?>" >
                    <input type="hidden" id="usr_brncde_<?php echo $no; ?>" name="usr_brncde_<?php echo $no; ?>" value="<?php echo $row_brn->brncde; ?>">
							
					<tr style="background-color:ffffff;"> 
						<td width="300"><?php echo $row_brn->brndcr; ?></td>
						<td align="center"><input type="checkbox" class="ace" id="usr_brnslc_<?php echo $no; ?>" name="usr_brnslc_<?php echo $no; ?>" value="1" ><span class="lbl"></span></td>
					</tr>
            
        	<?php } ?>
            
        	</tbody>
        </table>

    </div>
</div>