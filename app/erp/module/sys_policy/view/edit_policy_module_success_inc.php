<?php
require __DIR__.'/../../../template/header_inc.php';
require __DIR__.'/../../../template/main_inc.php';
require __DIR__.'/../../../func/check_session_func.php';

foreach ($arr_policy as $policy): 
endforeach;

$page =$paging->CalcuatePageNo($item_id,SYSTEM_PAGE_ROW_LIMIT);

echo '<DIV id="BodyDiv">';

echo '<DIV class="headerNavigation">';
echo 'Menu';
echo ' &raquo; ';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_home/">System</a>';
echo ' &raquo; ';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/'.IS_MODULE.'/">Security Policy</a>';
echo ' &raquo; ';
echo '<a href="'.actionURL('search_policy','?lot_id='.$lot_id.'&page='.$page).'">Search Result</a>';

echo ' &raquo; ';
echo 'Edit';
echo '</div><DIV id="BodyWrapDiv">';

echo '<DIV id="SubMenuDiv"><DIV id="ContentDiv">';


if($paging->getPrev_ID($item_id)<>""){

?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php 
echo '<a href= "'.actionURL('edit_policy','?item_id='.$paging->getPrev_ID($item_id).'&lot_id='.$lot_id).'" class="button">Prev</a>';
}
?>
&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;
<?php
if($paging->getNext_ID($item_id)<>""){
echo '<a href= "'.actionURL('edit_policy','?item_id='.$paging->getNext_ID($item_id).'&lot_id='.$lot_id).'" class="button">Next</a>';
}
 

?>
&nbsp;&nbsp;&nbsp;&nbsp;
<?php
echo "Record: ".$paging->getCurrentRow($item_id)." of ".$paging->getRecordCount();





if(isset($vlValidation)) {
	if($vlValidation->getProblemMsg()<>'') {
		echo '<div class="messageStackError">';
		echo $vlValidation->getProblemMsg();
		echo 'Record not save !</div>';

	}
}
 

 	echo "<br>";
		echo "<br>";

echo '<form action="'.actionURL('update_policy','?item_id='.$item_id.'&lot_id='.$lot_id).'" method="post" >';
?>
<div><label for="network_body" class="network_body">Policy Description:</label>
	<input type="text" name="policy[eng_desc]" required="required" value="<?php echo $policy['eng_desc'];?>" class="six"/>
<input type="hidden" name="policy[present_eng_desc]" value="<?php echo $policy['eng_desc'];?>" />
	</div>

<p>
<div><label for="network_body" class="network_body">Policy Status:</label>
<select name="policy[policy_status]" class="three"/>
<option value="1" <?php if ($policy['policy_status'] == 1){echo "selected";}?>>Open</option>
<option value="0" <?php if ($policy['policy_status'] == 0){echo "selected";}?>>Suspend</option>
</select>
    <p>
       <button type="submit">Confirm</button>
    </p>
</form>
<span class="font12">
<?php echo '<label for="network_body" class="network_body">Create User: </label><label for="user" class="user1_body"> ';echo $policy['create_user'];?></label><label for="user" class="user2_body"> Create Date:</label><?php echo  $policy['create_datetime']; echo '<br>'; ?>
<?php echo '<label for="network_body" class="network_body">Last Modify User:  </label><label for="user" class="user1_body"> '; echo $policy['modify_user'];?></label><label for="user" class="user2_body"> Last Modified Date:</label><?php echo  $policy['modify_datetime']; ?></span>
</div>


<?php


echo '<table border="0"  cellspacing="0" cellpadding="0" class="SearchResult">';

	echo '<tr>';
	echo '<th>policy_module_id</th>';
	echo '<th>policy_id</a>';
	echo '<th>module_code</th>';
	echo '<th>module_level_num</th>';
	echo '<th>module_create</th>';
	echo '<th>module_edit</th>';
	echo '<th>module_void</th>';
	echo '<th>policy_module_status</th>';
	echo '</tr>';



foreach ($arr_policy_module as $policy): 
	echo '<tr>';
	echo '<td>'.$policy['policy_module_id'].'</td>';
	echo '<td>'.$policy['policy_id'].'</td>';
	echo '<td>'.'<a href="'.actionURL('updatepolicymodule',$policy['policy_module_id']).'">'.$policy['module_code'].'</a></td>';		
	echo '<td>'.$policy['module_level_num'].'</td>';
	echo '<td>'.$policy['module_create'].'</td>';
	echo '<td>'.$policy['module_edit'].'</td>';
	echo '<td>'.$policy['module_void'].'</td>';
	echo '<td>'.$policy['policy_module_status'].'</td>';
	echo '</tr>';

endforeach; 

echo '</table>';
echo '<br>';
echo '<form action="'.actionURL('add_module_to_policy',$item_id).'" method="post" >';
?>

	<select name="policy[module_code]"  size="10">
	<?php 
	$x=1;
	foreach ($arr_policy_module_status as $policy_module_select): 
	
		echo '<option value="'.$policy_module_select['module_code'].'"';
			echo '>'.$x++.'. '.$policy_module_select['eng_desc'];
			echo '</option>'.chr(13);
	endforeach; 
	?>
	</select>
 <p>
 Module create:
<input type="radio" name="policy[module_create]" value="Y" checked>Enable
<input type="radio" name="policy[module_create]" value="N">Disable<br>
 Module edit:
<input type="radio" name="policy[module_edit]" value="Y" checked>Enable
<input type="radio" name="policy[module_edit]" value="N">Disable<br>
 Module void:
<input type="radio" name="policy[module_void]" value="Y" checked>Enable
<input type="radio" name="policy[module_void]" value="N">Disable<br>
Policy module status: 
<input type="radio" name="policy[policy_module_status]" value="1" checked>Active
<input type="radio" name="policy[policy_module_status]" value="0">Deactive<br>
module level number: 
 <input type='text' name="policy[module_level_num]" value='1'><br>
 <input type='hidden' name="policy[policy_id]" value='<?php echo $policy[policy_id];?>'>
 <input type='hidden' name="policy[page]" value='<?php echo $page;?>'>
 <input type='hidden' name="policy[item_id]" value='<?php echo $item_id;?>'>
 <input type='hidden' name="policy[lot_id]" value='<?php echo $lot_id;?>'>
 <button type="submit" <?php if (empty($arr_policy_module_status)) { echo "disabled";
}?> >Confirm Add Modulue</button>
    </p>
</form>
</div></div>
<?php

require __DIR__.'/../../../template/footer_inc.php';
?>
