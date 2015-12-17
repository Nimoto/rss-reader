<?php
include($_SERVER["DOCUMENT_ROOT"]."/rss/system/prolog.php");
$arParams = array("user_id" => $_POST["user_id"], "url" => $_POST["url"]);
DataBaseController::init()->deleteRss($arParams);
?>