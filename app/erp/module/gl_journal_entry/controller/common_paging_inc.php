<?php
$tab=$_GET["tab"];
$deleteaction=$_GET["deleteaction"];
if(isset($_GET["lot_id"]) && $_GET["lot_id"]<>'')  
{
	$lot_id=$_GET["lot_id"];
	$page=$_GET["page"];		
	$result_id=$dmGeneralModel->paging_config($lot_id);
	$paging = new PagingManger($result_id,SYSTEM_PAGE_ROW_LIMIT);
}
?>