					<ul>
						<li class="main_menu_selected"><span>Company</span></li>
						<li class="main_menu_unselected"><?php echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_user/new">'.'Add User'.'</a>'?></li>
					</ul>

					<div class="cardWrapper">
						<?php echo '<form action="'.actionURL('search','').'" method="post" >'; ?>
							<span class="formRow">
								<span class="menu_group_headers searchUser"><span>Search</span></span>
							</span>
							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Email</label>
								</span>
								<span class="formInput">
									<input type="text"  name="user[email]"  autocomplete="off" class="five" value="<?php echo htmlspecialchars($json_search_items['user']['email']);?>" />
								</span>
							</span>
							
							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Name</label>
								</span>
								<span class="formInput">
									<input type="text"  name="user[eng_name]"  autocomplete="off" class="five" value="<?php echo htmlspecialchars($json_search_items['user']['eng_name']);?>" />
								</span>
							</span>							
							
							<span class="formRow">
								<button type="submit">Search</button>
							</span>
						</form>
					</div>
					
					
