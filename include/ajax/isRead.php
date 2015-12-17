<?php
include($_SERVER["DOCUMENT_ROOT"]."/rss/system/prolog.php");
if($_POST["id"]){
	$arWhere = array("id" => $_POST["id"]);
}
if($_POST["user_id"]){
	$arWhere = array("user_id" => $_POST["user_id"]);
}

if(!empty($arWhere)){
	$arSet = array("read" => $_POST["action"]);
	DataBaseController::init()->updateRssItem($arSet, $arWhere);
}
?>