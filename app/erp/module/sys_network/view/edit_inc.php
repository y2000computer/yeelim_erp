<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if(isset($paging)) $page =$paging->CalcuatePageNo($item_id,SYSTEM_PAGE_ROW_LIMIT);
?>
		<div class="bodyContent breadcrumbExist" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="headerNavigation">
					<?php require __DIR__.'/navigation_menu_inc.php'; ?>
					<?php
					if(isset($page)) echo '<a href="'.actionURL('search','?lot_id='.$lot_id.'&page='.$page).'">Search Result</a>';
					echo ' &raquo; ';
					echo 'Edit ';
					?>
					<div class="pagingNavigation">
						<?php
						if(isset($paging)) {
							if($paging->getPrev_ID($item_id)<>""){
								echo '<a href= "'.actionURL('edit','?item_id='.$paging->getPrev_ID($item_id).'&lot_id='.$lot_id).'" class="commonTextBtn">&lt;&lt;</a>';
							}
								echo '<span class="pageMessage">';
								if (isset($paging)) echo "Record: ".$paging->getCurrentRow($item_id)." of ".$paging->getRecordCount(); 
								echo '</span>';
							
							if($paging->getNext_ID($item_id)<>""){
								echo '<a href= "'.actionURL('edit','?item_id='.$paging->getNext_ID($item_id).'&lot_id='.$lot_id).'" class="commonTextBtn">&gt;&gt;</a>';
							}
						} //if(isset($page))  
						?>
					</div>
				
				</div>
				<div class="sidebarContent">
					<div class="sidebarContentCol">
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('update','?item_id='.$item_id.'&lot_id='.$lot_id).'" method="post" >'; ?>
						
						<?php
						if(isset($vlValidation)) {
							if($vlValidation->getProblemMsg()<>'') {
								echo '<span class="alertMsg errorMsg">';
								echo $vlValidation->getProblemMsg();
								echo 'Record not save !';
								echo '</span>';
							} else {
								echo '<span class="alertMsg successMsg">';
								echo 'Update successfully.';
								echo '</span>';
								}
						}	
						?>						
						
						
							<span class="formRow">
								<span class="formLabel">
									<label class="">Network Description :</label>
								</span>
								<span class="formInput">
										<input type="text" name="network[eng_name]"  size="50" required class="eleven" value="<?php echo htmlspecialchars($network['eng_name']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>

							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Type :</label>
								</span>
								<span class="formInput">
									<select name="network[net_type]" class="three" required />
									<option value="RANGE" <?php if ($network['net_type'] == 'RANGE'){echo "selected";}?>>RANGE</option>
									<option value="DEDIC" <?php if ($network['net_type'] =='DEDIC'){echo "selected";}?>>DEDIC</option>
									</select>
								</span>
							</span>
							<span class="formRow">
							</span>

							
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Fixed IP :</label>
								</span>
								<span class="formInput">
										<input type="text" name="network[fixed_ip]"  size="20" class="four" value="<?php echo htmlspecialchars($network['fixed_ip']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">IP Range From :</label>
								</span>
								<span class="formInput">
										<input type="text" name="network[ip_range_from]"  size="20" class="four" value="<?php echo htmlspecialchars($network['ip_range_from']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>


							<span class="formRow">
								<span class="formLabel">
									<label class="">IP Range To :</label>
								</span>
								<span class="formInput">
										<input type="text" name="network[ip_range_to]"  size="20" class="four" value="<?php echo htmlspecialchars($network['ip_range_to']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>


							<span class="formRow">
								<span class="formLabel">
									<label class="">Network Mask :</label>
								</span>
								<span class="formInput">
										<input type="text" name="network[network_mask]"  size="20" class="four" value="<?php echo htmlspecialchars($network['network_mask']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>

							
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Status:</label>
								</span>
								<span class="formInput">
									<select name="network[status]" class="three" required />
									<option value="1" <?php if ($network['status'] == 1){echo "selected";}?>>Active</option>
									<option value="0" <?php if ($network['status'] == 0){echo "selected";}?>>De-active</option>
									</select>
								</span>
							</span>
							<span class="formRow">
							</span>
							
							<span class="formRow">
							</span>
							<span class="formRow">
							</span>
							
							<span class="formRow">
								<span class="formLabel">
								</span>
								<span class="formInput">
									<button type="submit">Confirm</button>
								</span>
							</span>
							
							
							
							
							<span class="formRow formRow-2col" style="margin-top: 10px;">
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Create User:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo $network['create_user'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Create Date:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo  $network['create_datetime'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Last Update By:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo $network['last_modify_user'];?></span>
								</span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<span class="label">Last Update Date:</span>
								</span>
								<span class="formInput">
									<span class="message"><?php echo  $network['last_modify_datetime']; ?></span>
								</span>
							</span>							
							
							
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		