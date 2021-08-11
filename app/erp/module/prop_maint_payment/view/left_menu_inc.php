
					<ul>
						<li class="main_menu_selected"><span>Maint. Payment</span></li>
						<li class="main_menu_unselected">
						<?php echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/prop_maint_payment/new">'.'Add Payment'.'</a>'?></li>
					</ul>



					<div class="cardWrapper">
						<?php echo '<form action="'.actionURL('search','').'" method="post" >'; ?>
							<span class="formRow">
								<span class="menu_group_headers searchUser"><span>Search</span></span>
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="six">Building</label>
								</span>
								<span class="formInput">
								<?php
								if($_SESSION["target_build_id"]<>'') {
								$general['build_id'] = $_SESSION["target_build_id"];	
								}
								?>		
								<?php
									//set default
									foreach ($arr_prop_build_master  as $prop_build_master) {
										if($json_search_items['general']['build_id']==''){
											/*
											$json_search_items['general']['build_id'] = $prop_build_master['build_id'];	
											*/
											if($_SESSION["target_build_id"]<>'') {
												$json_search_items['general']['build_id'] = $_SESSION["target_build_id"];	
											}
										}
									}
									?>

								<select name="general[build_id]" class="six">
									<?php
									//echo '<option value=""'.' '.($general['build_id']  ==''?'selected':'').'>'.'Please select'.'</option>';
									foreach ($arr_prop_build_master  as $prop_build_master) { 
									  echo '<option value="'.$prop_build_master['build_id'].'"'.' '.($json_search_items['general']['build_id']  == $prop_build_master['build_id']?'selected':'').'>'.$prop_build_master['eng_name'].'</option>';
									}
									?>
									</select>
								</span>
							</span>


							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Payment Date From</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="inv_date_from" class="datepicker" style="width: 140px" type="text" name="general[inv_date_from]" autocomplete="off" value="<?php echo $json_search_items['general']['inv_date_from'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>
							
							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">To</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="inv_date_to" class="datepicker" style="width: 140px" type="text" name="general[inv_date_to]" autocomplete="off" value="<?php echo $json_search_items['general']['inv_date_to'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>
							
							
							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Payment No.</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[payment_code]"  autocomplete="off" class="four" value="<?php echo htmlspecialchars($json_search_items['general']['payment_code']);?>" />
								</span>





							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Tenant Code</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[tenant_code]"  autocomplete="off" class="three" value="<?php echo htmlspecialchars($json_search_items['general']['tenant_code']);?>" />
								</span>
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Tenant Name</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[eng_name]"  autocomplete="off" class="five" value="<?php echo htmlspecialchars($json_search_items['general']['eng_name']);?>" />
								</span>
							</span>
							<span class="formRow">
								<button type="submit">Search</button>
							</span>
						</form>
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