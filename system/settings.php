<?php
//path
	define(VIEW_PATH, $_SERVER["DOCUMENT_ROOT"]."/system/templates/view.php");
	define(TEMPLATE_PATH, $_SERVER["DOCUMENT_ROOT"]."/system/templates/main/");
	define(WEB_TEMPLATE_PATH, "/system/templates/main/");
	define(TEMPLATE_CHUNKS_PATH, $_SERVER["DOCUMENT_ROOT"]."/system/templates/main/chunks/");
	define(CONTROLLER_PATH, $_SERVER["DOCUMENT_ROOT"]."/system/controllers/");
	define(MODEL_PATH, $_SERVER["DOCUMENT_ROOT"]."/system/classes/");
	define(PAGES_PATH, $_SERVER["DOCUMENT_ROOT"]."/system/pages/");

//db settings
	define(DB_USER_TBL, "user");

	$dbSettings = array(
			"host" => "localhost",
			"user" => "cq58481_rss",
			"pass" => "Q35Mo6ql",
			"db_name" => "cq58481_rss"
		);

//mail settimgs
	define(ADMIN_EMAIL, "nimoto1991@gmail.com");
?>