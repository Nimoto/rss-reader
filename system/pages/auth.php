<?php?>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h1>Авторизация</h1>
		<?php
		$arParams = array(
				"template" => "form/MainFormChunk.php",
			);
		
		$authForm = new MainForm();
		$authForm->addField(new Field("login", "Ваш логин", "text", "not_empty"));
		$authForm->addField(new Field("pass", "Ваш пароль", "password", "not_empty"));
		$authForm->addButton(new Field("send", "Отправить", "submit"));
		$authControl = new AuthFormController($arParams, $authForm);
		?>
	</div>
	<div class="col-md-4"></div>
</div>