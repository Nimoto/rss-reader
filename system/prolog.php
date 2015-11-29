<?php
error_reporting(E_ERROR);
require "settings.php";
include(VIEW_PATH);
include(MODEL_PATH."forms/MainFormClass.php");
include(MODEL_PATH."manager/MainRouter.php");
include(CONTROLLER_PATH."form/MainFormController.php");

$_ADDRESS = $_SERVER["REQUEST_URI"];
$pages = array(
		"/" => "index.php",
		"/auth/" => "auth.php",
		"/register/" => "register.php"
);
$_ROUTER = MainRouter::createRouter($pages);
?>