<?php
$IS_action= isset($sub_folder[($UrlOffset+4)]) ? $sub_folder[($UrlOffset+4)] : 'NOTDEFINE';
$IS_action= ($IS_action=='NOTDEFINE' || $IS_action=='') ? '/' : $IS_action;  //set default

$IS_para_id= isset($sub_folder[($UrlOffset+5)]) ? $sub_folder[($UrlOffset+5)] : 'NOTDEFINE';
$IS_para_id= ($IS_para_id=='NOTDEFINE' || $IS_para_id=='') ? '1' : $IS_para_id;  //set default
?>