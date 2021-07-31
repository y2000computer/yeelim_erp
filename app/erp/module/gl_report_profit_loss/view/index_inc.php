<?php
require __DIR__.'/../../../template/header_inc.php';
?>
<?php
if ($IS_action=='new') {
}
?>
		<div class="bodyContent breadcrumbExist" id="BodyDiv">
			<div class="contentWrapper" id="BodyWrapDiv">
				<div class="headerNavigation">
					<?php require __DIR__.'/navigation_menu_inc.php'; ?>

				</div>
				<div class="sidebarContent">
					<div class="sidebarContentCol">
						<?php echo '<form class="fullWidthForm fullWidthForm-2col" action="'.actionURL('generate','').'" method="post" target="_blank" ';?>
						
						<?php
						if(isset($vlValidation)) {
							if($vlValidation->getProblemMsg()<>'') {
								echo '<span class="alertMsg errorMsg">';
								echo $vlValidation->getProblemMsg();
								echo 'Criteria not save !';
								echo '</span>';
							} else {
								echo '<span class="alertMsg successMsg">';
								echo 'Output successfully.';
								echo '</span>';
								}
						}	
						?>						
						
				
				
							<span class="formRow">
								<span class="formLabel">
								</span>
								<span class="formInput" >
								</span>
							</span>							
							<span class="formRow">
							</span>
							
						
							<span class="formRow">
								<span class="formLabel">
									<label class="">Journal Date From:</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="journal_date_from" class="datepicker" style="width: 140px" type="text" required name="criteria[journal_date_from]" autocomplete="off" value="<?php echo $general['journal_date_from'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>							
							<span class="formRow">
							</span>
							

							<span class="formRow">
								<span class="formLabel">
									<label class="">Journal Date To:</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="journal_date_to" class="datepicker" style="width: 140px" type="text" required name="criteria[journal_date_to]" autocomplete="off" value="<?php echo $general['journal_date_to'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>							
							<span class="formRow">
							</span>
							
						
						
							<span class="formRow">
								<span class="formLabel">
									<label class="">Output To :</label>
								</span>
								<span class="formInput" >
										<select name="criteria[output]" id="output" required class="five">
										<option value="screen" selected>Screen</option>
										<option value="excel">Excel</option>
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
									<button type="submit">Generate</button>
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
		