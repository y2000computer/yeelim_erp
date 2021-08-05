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
								<input type="hidden" name="general[tenant_code]"  value="<?php echo htmlspecialchars($general['tenant_code']);?>" />
								<?php echo htmlspecialchars($general['tenant_code']);?>
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
									<label class="">Invoice No. :</label>
								</span>
								<span class="formInput">
										<input type="hidden" name="general[inv_id]"  value="<?php echo htmlspecialchars($general['inv_id']);?>" />
										<?php echo htmlspecialchars($general['inv_code']);?> 
								</span>
							</span>
							<span class="formRow">
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label class="">Invoice Date :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<?php echo htmlspecialchars($general['inv_date']);?> 
								</span>
							</span>
							<span class="formRow">
							</span>		

							
							<span class="formRow">
								<span class="formLabel">
									<label class="">Name :</label>
								</span>
								<span class="formInput">
									<?php echo htmlspecialchars($general['tenant_eng_name']);?>
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
									<label class="">Period From :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
								<?php echo htmlspecialchars($general['period_date_from']);?>
								</span>
							</span>
							<span class="formRow">
							</span>							


							<span class="formRow">
								<span class="formLabel">
									<label class="">Period To :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
								<?php echo htmlspecialchars($general['period_date_to']);?>
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
								<?php echo htmlspecialchars(number_format($general['inv_amount'],2));?>									
								</span>
							</span>
							<span class="formRow">
							</span>

	
							<span class="formRow">
								<span class="formLabel">
									<label class="">Invoice Balance :</label>
								</span>
								<span class="formInput">
								<?php echo htmlspecialchars(number_format($general['Balance'],2));?>									
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
									<label class="">Payment Date :</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="payment_date" class="datepicker" style="width: 140px" type="text" name="general[payment_date]" autocomplete="off"  required value="<?php echo $general['payment_date'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>							
							<span class="formRow">
							</span>						
						



							<span class="formRow">
								<span class="formLabel">
									<label class="">Payment Amount :</label>
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
		