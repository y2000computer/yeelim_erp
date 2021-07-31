<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if ($IS_action=='new') {
	$network['status'] = 1;
	$network['DEDC']='RANGE';
}
?>
		<div class="bodyContent breadcrumbExist" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="headerNavigation">
					<?php require __DIR__.'/navigation_menu_inc.php'; ?>
					Add 
				</div>
				<div class="sidebarContent">
					<div class="sidebarContentCol">
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('create','').'" method="post" >';?>
						
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
							
							
							
							
							
							
						</form>
					</div>
				</div>
			</div>
		</div>
<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		