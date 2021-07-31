<?php
require __DIR__.'/../../../template/header_inc.php';
require __DIR__.'/../../../template/main_inc.php';
require __DIR__.'/../../../func/check_session_func.php';

echo '<DIV id="BodyDiv">';


echo '<DIV class="headerNavigation">';
echo 'Menu';
echo ' &raquo; ';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_home/">System</a>';
echo ' &raquo; ';
echo '<a href="/'.IS_PORTAL.'/'.IS_LANG.'/sys_user/">System User</a>';

echo '</div><DIV id="BodyWrapDiv">';
echo '<DIV id="SubMenuDiv"><DIV id="ContentDiv">';




?>

<div id="SearchDiv"><UL>
Sorry! You have no right to access this module.<br>
Please contact with your system admin
</div>


<?php

echo '<br>';
echo '</DIV></DIV></DIV>';
require __DIR__.'/../../../template/footer_inc.php';
?>