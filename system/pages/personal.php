<?php
global $_USER;
?>
<div class="row">
	<div class="col-md-12">
		<h1>Личный кабинет</h1>
	</div>
</div>

<div class="row">
	<div class="col-md-4 col-sm-12" style="margin-bottom:20px;">
		<img style="width:100%" src="<?php echo $_USER->getGravatar();?>" />
	</div>
	<div class="col-md-8 col-sm-12">		
		<?php
		$arParams = array(
				"template" => "form/MainFormChunk.php",
			);
		
		$authForm = new MainForm();
		$authForm->addField(new Field("full_name", "Ваше ФИО", "text", $_USER->getProperty("full_name")));
		$authForm->addField(new Field("login", "Ваш логин", "text", $_USER->getProperty("login"), "text"));
		$authForm->addField(new Field("email", "Ваш email", "text", $_USER->getProperty("email"), "email"));
		$authForm->addField(new Field("pass", "Ваш пароль", "password", null, "not_empty"));
		$authForm->addField(new Field("confirm_pass", "Подтвердите пароль", "password", null, "confirm_pass", "pass"));
		$authForm->addField(new Field("id", "", "hidden", $_USER->getProperty("id")));
		$authForm->addButton(new Field("send", "Обновить", "submit"));
		$authControl = new UpdateFormController($arParams, $authForm);
		?>
	</div>
</div>

