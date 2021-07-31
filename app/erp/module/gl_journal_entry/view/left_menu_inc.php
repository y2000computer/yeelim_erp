					<ul>
						<li class="main_menu_selected"><span>Journal Entry</span></li>
						<li class="main_menu_unselected">
						<?php echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/gl_journal_entry/new">'.'Add Journal Entry'.'</a>'?></li>
					</ul>

					<div class="cardWrapper">
						<?php echo '<form action="'.actionURL('search','').'" method="post" >'; ?>
						
							<span class="formRow">
								<span class="menu_group_headers searchUser"><span>Search</span></span>
							</span>

							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Journal Date From</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="journal_date_from" class="datepicker" style="width: 140px" type="text" name="general[journal_date_from]" autocomplete="off" value="<?php echo $json_search_items['general']['journal_date_from'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>
							
							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">To</label>
								</span>
								<span class="formInput" data-remarks="(dd/mm/yyyy)">
									<input id="journal_date_to" class="datepicker" style="width: 140px" type="text" name="general[journal_date_to]" autocomplete="off" value="<?php echo $json_search_items['general']['journal_date_to'];?>" placeholder="dd/mm/yyyy" maxlength="10">
								</span>
							</span>
							
							
							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Journal Code</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[journal_code]"  autocomplete="off" class="four" value="<?php echo htmlspecialchars($json_search_items['general']['journal_code']);?>" />
								</span>

							<span class="formRow">
							<span class="formLabel">
								<label for="userModule_email" class="">Chart Code</label>
							</span>
							<span class="formInput">
								<input type="text"  name="general[chart_code]"  autocomplete="off" class="three" value="<?php echo htmlspecialchars($json_search_items['general']['chart_code']);?>" />
							</span>
							

							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Chart Name</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[chart_name]"  autocomplete="off" class="five" value="<?php echo htmlspecialchars($json_search_items['general']['chart_name']);?>" />
								</span>
							
							<span class="formRow">
								<span class="formLabel">
									<label for="userModule_email" class="">Description</label>
								</span>
								<span class="formInput">
									<input type="text"  name="general[description]"  autocomplete="off" class="five" value="<?php echo htmlspecialchars($json_search_items['general']['description']);?>" />
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