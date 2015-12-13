<?php
include($_SERVER["DOCUMENT_ROOT"]."/system/prolog.php");
if($_POST["id"]){
	$arWhere = array("id" => $_POST["id"]);
}
if($_POST["user_id"]){
	$arWhere = array("user_id" => $_POST["user_id"]);
}

if(!empty($arWhere)){
	$arSet = array("read" => true);
	DataBaseController::init()->updateRssItem($arSet, $arWhere);
}
?>