<?php
global $_USER;
if($_GET["logout"] == "yes"){
	unset($_SESSION["login"]);
	unset($_USER);
}
if(!$_USER){?>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h1>Авторизация</h1>
		<?php
		$arParams = array(
				"template" => "form/MainFormChunk.php",
			);
		
		$authForm = new MainForm();
		$authForm->addField(new Field("login", "Ваш логин", "text", null, "not_empty"));
		$authForm->addField(new Field("pass", "Ваш пароль", "password", null, "not_empty"));
		$authForm->addButton(new Field("send", "Отправить", "submit", null));
		$authControl = new AuthFormController($arParams, $authForm, "/personal/");
		?>
	</div>
	<div class="col-md-4"></div>
</div>
<?php } else {
	if($_GET["refresh"] == 1){
		$rss_controller = new RssController($_USER->getProperty("id"));
		$rss_controller->updateRss();
	}
	$rss_item_controller = new RssItemsController($_USER->getProperty("id"),"rss/RssListChunk.php");
	$rss_item_controller->printRssItems();
}?>