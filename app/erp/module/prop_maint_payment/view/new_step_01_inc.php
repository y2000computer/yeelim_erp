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
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('new_step_02','').'" method="post" >';?>

						
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
										<input type="text" name="general[tenant_code]"  size="15" class="four" value="<?php echo htmlspecialchars($general['tenant_code']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>


							<span class="formRow">
								<span class="formLabel">
									<label class="">Invoice Code :</label>
								</span>
								<span class="formInput">
										<input type="text" name="general[inv_code]"  size="15" class="three" value="<?php echo htmlspecialchars($general['inv_code']);?>" />
								</span>
							</span>
							<span class="formRow">
							</span>


							<span class="formRow">
								<span class="formLabel">
									<label class="">Invoice Date From :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="inv_date_from" class="datepicker" style="width: 140px" type="text" name="general[inv_date_from]" autocomplete="off" value="<?php echo $general['inv_date_from'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>
							<span class="formRow">
							</span>							

							<span class="formRow">
								<span class="formLabel">
									<label class="">Invoice Date To :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="inv_date_to" class="datepicker" style="width: 140px" type="text" name="general[inv_date_to]" autocomplete="off" value="<?php echo $general['inv_date_to'];?>" placeholder="dd/mm/yyyy" maxlength="10">
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
									<button type="submit">Search</button>
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
		