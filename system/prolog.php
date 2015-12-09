<?php
session_start();
//error_reporting(E_ERROR);
require "settings.php";
include(CONTROLLER_PATH."manager/DataBaseController.php");
$_DB = DataBaseController::init();

include(VIEW_PATH);
include(MODEL_PATH."forms/MainFormClass.php");
include(MODEL_PATH."forms/FieldClass.php");
include(MODEL_PATH."user/UserClass.php");
include(MODEL_PATH."rss/RssClass.php");
include(MODEL_PATH."paginator/PaginatorClass.php");
include(CONTROLLER_PATH."manager/MainRouter.php");
include(CONTROLLER_PATH."manager/MailController.php");
include(CONTROLLER_PATH."form/MainFormController.php");
include(CONTROLLER_PATH."form/RegisterFormController.php");
include(CONTROLLER_PATH."form/AuthFormController.php");
include(CONTROLLER_PATH."form/UpdateFormController.php");
include(CONTROLLER_PATH."form/RssFormController.php");
include(CONTROLLER_PATH."form/ValidatorController.php");
include(CONTROLLER_PATH."rss/RssController.php");
include(CONTROLLER_PATH."rss/RssItemsController.php");
include(CONTROLLER_PATH."paginator/PaginatorController.php");

$_ADDRESS = $_SERVER["REQUEST_URI"];

$pages = array(
		"/" => "index.php",
		"/auth/" => "auth.php",
		"/register/" => "register.php"
);

$_ROUTER = MainRouter::createRouter($pages);
global $_USER;
if($_SESSION["login"]){
	$_USER = UserClass::getByLogin($_SESSION["login"]);
	if($_USER->getProperty("active") == false){
		unset($_SESSION["login"]);
		unset($_USER);
	}
}

?>