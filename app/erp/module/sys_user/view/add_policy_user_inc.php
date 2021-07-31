<?php
require __DIR__.'/../../../template/header_inc.php';
require __DIR__.'/../../../func/check_session_func.php';

echo '<DIV id="BodyDiv">';

echo '<DIV class="headerNavigation">';
echo 'Menu';
echo ' &raquo; ';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_home/">System</a>';
echo ' &raquo; ';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/'.IS_MODULE.'/">System User</a>';
echo ' &raquo; ';
echo 'Add System User';
echo '</DIV>';
echo '<DIV id="BodyWrapDiv">';
echo '<DIV id="FullContetnDiv">';

if(isset($vlValidation)) {
	if($vlValidation->getProblemMsg()<>'') {
		echo '<div class="messageStackError">';		
		echo $vlValidation->getProblemMsg();
		echo 'Record not save !</div>';
	}
}

echo '<br>';
echo '<form action="'.actionURL('create',$IS_para_id).'" method="post" >';
?>
<div><label for="username">User Name:</label>
	<input type="text" name="user[username]" required="required" size="30" value="<?php echo $user['username'];?>" /></div>
<p>	
<div><label for="password">Password:</label>
	<input type="text" name="user[password]" required="required" size="50"  value="<?php echo $user['password'];?>" /></div>
 <p>
 <div><label for="eng_name">staff_no:</label>
	<input type="text" name="user[staff_no]" size="12" value="<?php echo $user['staff_no'];?>" />
 <p>
<div><label for="eng_name">Eng name:</label>
	<input type="text" name="user[eng_name]" size="12" value="<?php echo $user['eng_name'];?>" />
 <p>
 <div><label for="eng_name">Chinese name:</label>
	<input type="text" name="user[chn_name]" size="12" value="<?php echo $user['chn_name'];?>" />
 <p>

<div><label for="department_code">Department</label>
	<select name="user[depart_code]">
	<?php 
	foreach ($arr_department_all as $dc): 
	echo '<option value="'.$dc['depart_code'].'"';
 //if ($dc['depart_code'] == $user['depart_code']) { echo ' selected'; }
	echo '>'.$dc['eng_name'];
		
			

			echo '</option>';
	endforeach; 
	?>
	</select>
 <p> 
 
<div><label for="email">E-mail:</label>
	<input type="text" name="user[email]" size="15"  value="<?php echo $user['email'];?>" /></div>
	<input type="hidden" name="user[user_id]" size="15"  value="<?php echo $user['user_id'];?>" /></div>

 
<p>
<br>User Status:
	<select name="user[user_status]">

<option value='1'>Open</option>
<option value='0'>Suspend</option>

</select>


    <p>
       <button type="submit">Confirm</button>
    </p>
</form>
</div></div></div>
<?php
//echo '<br>';
//echo '<br>';
//echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/'.IS_MODULE.'/">Back to '.IS_MODULE.' Section</a>';


echo '<br>';
require __DIR__.'/../../../template/footer_inc.php';
?>
