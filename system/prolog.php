<?php
session_start();

if($_GET["logout"] == "yes"){	
	setcookie("login", '', time() - 3600, '/');
	unset($_SESSION["login"]);
	header("Location:/", true, 301);
}else if(!$_COOKIE["login"] && $_SESSION["login"]){
	setcookie("login", $_SESSION["login"]);
	header("Location:/", true, 301);
}


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
);

$_ROUTER = MainRouter::createRouter($pages);
global $_USER;
if($_COOKIE["login"]){
	$_USER = UserClass::getByLogin($_COOKIE["login"]);
	if($_USER->getProperty("active") == false){
		unset($_COOKIE["login"]);
		unset($_USER);
	}
}

?>