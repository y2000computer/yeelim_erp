<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if ($IS_action=='new_step_03') {
	$general['amount'] = 0;
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
									<input type="hidden" name="general[build_id]"  value="<?php echo htmlspecialchars($general['build_id']);?>" />
									<?php echo $general['build_eng_name']; ?>
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
								<input type="hidden" name="general[tenant_id]"  value="<?php echo htmlspecialchars($general['tenant_id']);?>" />
								<?php echo htmlspecialchars($general['tenant_code']);?>
								</span>
							</span>
							<span class="formRow">
							</span>
							

							<span class="formRow">
								<span class="formLabel">
									<label class="">Name :</label>
								</span>
								<span class="formInput">
								<?php echo htmlspecialchars($general['eng_name']);?>
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
									<label class="">Maint. Bill Date :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<?php echo htmlspecialchars($general['maint_date']);?> 
								</span>
							</span>
							<span class="formRow">
							</span>		

							<span class="formRow">
								<span class="formLabel">
									<label class="">Maint. Amount :</label>
								</span>
								<span class="formInput">
								<?php echo htmlspecialchars(number_format($general['maint_amount'],2));?>									
								</span>
							</span>
							<span class="formRow">
							</span>


							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Invoice Date :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="payment_date" class="datepicker" style="width: 140px" type="text" name="general[inv_date]" autocomplete="off"  required value="<?php echo $general['inv_date'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>							
							<span class="formRow">
							</span>						
						
							<span class="formRow">
								<span class="formLabel">
									<label class="">Period Date From :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
								<input id="period_date_from" class="datepicker" style="width: 140px" type="text" name="general[period_date_from]" autocomplete="off"  required value="<?php echo $general['period_date_from'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>
							<span class="formRow">
							</span>							


							<span class="formRow">
								<span class="formLabel">
									<label class="">Period Date To :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
								<input id="period_date_to" class="datepicker" style="width: 140px" type="text" name="general[period_date_to]" autocomplete="off"  required value="<?php echo $general['period_date_to'];?>" placeholder="dd/mm/yyyy" maxlength="10">
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
									<label class="">Invoice Amount :</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[amount]"  autocomplete="off" class="four" required value="<?php echo htmlspecialchars($general['amount']);?>" />
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
		