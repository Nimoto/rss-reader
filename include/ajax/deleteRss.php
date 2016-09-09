<?php
include($_SERVER["DOCUMENT_ROOT"]."/system/prolog.php");
$arParams = array("user_id" => $_POST["user_id"], "url" => $_POST["url"]);
DataBaseController::init()->deleteRss($arParams);
?>