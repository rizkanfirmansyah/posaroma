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
            	
            	$sql=$select->list_usrbrn($ref);
				$jmldata2 = $sql->rowCount();
            	
                $no = 0;					
            	while($row_brn=$sql->fetch(PDO::FETCH_OBJ)) {  
        		$no++;
            ?>
            
                    <input type="hidden" id="jmldata2" name="jmldata2" value="<?php echo $jmldata2; ?>" >
                    
                    <input type="hidden" id="usr_brncde_<?php echo $no; ?>" name="usr_brncde_<?php echo $no; ?>" value="<?php echo $row_brn->brncde; ?>">
					<input type="hidden" id="usr_brnold_<?php echo $no; ?>" name="usr_brnold_<?php echo $no; ?>" value="<?php echo $row_brn->old; ?>">							
					<tr <?php if($row_brn->mslc==1) { ?>style="background-color:#CCFFCC;" <?php } else { ?>style="background-color:#ffffff;" <?php } ?> > 
						<td width="300"><?php echo $row_brn->brndcr; ?></td>
						<td align="center"><input type="checkbox" class="ace" id="usr_brnslc_<?php echo $no; ?>" name="usr_brnslc_<?php echo $no; ?>" value="1" <?php if($row_brn->mslc==1) echo "checked"; ?> ><span class="lbl"></span></td>
					</tr> 
                    
                    
                    <!--<input type="hidden" id="usr_brncde_<?php echo $no; ?>" name="usr_brncde_<?php echo $no; ?>" value="<?php echo $row_brn->brncde; ?>">
							
					<tr style="background-color:ffffff;"> 
						<td width="300"><?php echo $row_brn->brndcr; ?></td>
						<td align="center"><input type="checkbox" class="ace" id="usr_brnslc_<?php echo $no; ?>" name="usr_brnslc_<?php echo $no; ?>" value="1" ><span class="lbl"></span></td>
					</tr>-->
            
        	<?php } ?>
            
        	</tbody>
        </table>

    </div>
</div>