					<ul>
						<li class="main_menu_selected"><span>Company</span></li>
						<li class="main_menu_unselected"><?php echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_chart_master/new">'.'Add Chart'.'</a>'?></li>
					</ul>

					<div class="cardWrapper">
						<?php echo '<form action="'.actionURL('search','').'" method="post" >'; ?>
							<span class="formRow">
								<span class="menu_group_headers searchUser"><span>Search</span></span>
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Chart Code</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[chart_code]"  autocomplete="off" class="three" value="<?php echo htmlspecialchars($json_search_items['general']['chart_code']);?>" />
								</span>
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Chart Name</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[chart_name]"  autocomplete="off" class="five" value="<?php echo htmlspecialchars($json_search_items['general']['chart_name']);?>" />
								</span>
							</span>
							<span class="formRow">
								<button type="submit">Search</button>
							</span>
						</form>
					</div>