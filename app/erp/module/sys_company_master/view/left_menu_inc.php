					<ul>
						<li class="main_menu_selected"><span>Company</span></li>
						<li class="main_menu_unselected"><?php echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_company_master/new">'.'Add Company'.'</a>'?></li>
					</ul>

					<div class="cardWrapper">
						<?php echo '<form action="'.actionURL('search','').'" method="post" >'; ?>
							<span class="formRow">
								<span class="menu_group_headers searchUser"><span>Search</span></span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Company Name</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[name_eng]"  autocomplete="off" class="five" value="<?php echo htmlspecialchars($json_search_items['general']['name_eng']);?>" />
								</span>
							</span>
							<span class="formRow">
								<button type="submit">Search</button>
							</span>
						</form>
					</div>