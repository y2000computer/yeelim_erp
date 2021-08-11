<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if ($IS_action=='new') {
	$general['rent_amount'] = 0;
	$general['maint_amount'] = 0;
	$general['ptype'] = 0;
	$general['status'] = 1;
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
									<label class="">Building :</label>
								</span>

								<span class="formInput">
									<select name="general[build_id]" required class="ten">
									<?php
									echo '<option value=""'.' '.($general['build_id']  ==''?'selected':'').'>'.'Please select'.'</option>';
									foreach ($arr_prop_build_master  as $master) { 
									  echo '<option value="'.$master['build_id'].'"'.' '.($general['build_id']  == $master['build_id']?'selected':'').'>'.$master['eng_name'].'&nbsp;'.'('.$master['build_id'].')'.'</option>';
									}
									?>
									</select>
								</span>
							</span>
							<span class="formRow">
							</span>					
						
						
						
							<span class="formRow">
								<span class="formLabel">
									<label class="">Tenant Code :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[tenant_code]"  size="15" required class="four" value="<?php echo htmlspecialchars($general['tenant_code']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Name :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[eng_name]"  size="100" required class="fourteen" value="<?php echo htmlspecialchars($general['eng_name']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>
							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Add(1) :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_1]"  size="100" class="thirteen" value="<?php echo htmlspecialchars($general['add_1']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Add(2) :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_3]"  size="100"  class="thirteen" value="<?php echo htmlspecialchars($general['add_3']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Add(3) :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[add_2]"  size="100"  class="thirteen" value="<?php echo htmlspecialchars($general['add_2']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>


							<span class="formRow">
								<span class="formLabel">
									<label class="">Ref No. :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[ref_no]"  size="100"  class="ten" value="<?php echo htmlspecialchars($general['ref_no']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>


							<span class="formRow">
								<span class="formLabel">
									<label class="">Shop No. :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[shop_no]"  size="100"  class="ten" value="<?php echo htmlspecialchars($general['shop_no']);?>" />
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
									<label class="">Rent Bill Date :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="rent_date" class="datepicker" required style="width: 140px" type="text" name="general[rent_date]" autocomplete="off" value="<?php echo $general['rent_date'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>
							<span class="formRow">
							</span>							


							<span class="formRow">
								<span class="formLabel">
									<label class="">Rent Amount :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[rent_amount]"  size="30" required class="four" value="<?php echo htmlspecialchars($general['rent_amount']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>



							<span class="formRow">
								<span class="formLabel">
									<label class="">Maint. Bill Date :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="maint_date" class="datepicker" required style="width: 140px" type="text" name="general[maint_date]" autocomplete="off" value="<?php echo $general['maint_date'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>
							<span class="formRow">
							</span>							


							<span class="formRow">
								<span class="formLabel">
									<label class="">Maint. Amount :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[maint_amount]"  size="30" required class="four" value="<?php echo htmlspecialchars($general['maint_amount']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>


							<span class="formRow">
								<span class="formLabel">
									<label class="">Print Type :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[ptype]"  size="30" required class="two" value="<?php echo htmlspecialchars($general['ptype']);?>" />
										(Either 0 (KongOn) or 1(YeeLim))
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
									<label class="">Status:</label>
								</span>
								<span class="formInput">
									<select name="general[status]" class="three" required="required"/>
									<option value="1" <?php if ($general['status'] == 1){echo "selected";}?>>Active</option>
									<option value="0" <?php if ($general['status'] == 0){echo "selected";}?>>De-active</option>
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

		<script>
			$(document).ready
			(
				function ()
				{
					$(".datepicker").datepicker({ dateFormat: 'dd/mm/yy' });
				}
			);
		</script>

<?php
require __DIR__.'/../../../template/footer_inc.php';
?>
		