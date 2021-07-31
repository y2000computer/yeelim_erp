<?php
if(isset($_GET["lot_id"]) && $_GET["lot_id"]<>'')  
{
	$lot_id=$_GET["lot_id"];
	$page=$_GET["page"];		
	$result_id=$dmNetwork->paging_config($lot_id);
	$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
}
?>