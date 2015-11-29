<?php?>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h1>Регистрация</h1>
		<?php
		$arParams = array(
				"template" => "form/MainFormChunk.php",
			);
		
		$authForm = new MainForm();
		$authForm->addField(new Field("full_name", "Ваше ФИО", "text"));
		$authForm->addField(new Field("login", "Ваш логин", "text", "text"));
		$authForm->addField(new Field("email", "Ваш email", "text", "email"));
		$authForm->addField(new Field("pass", "Ваш пароль", "password", "not_empty"));
		$authForm->addField(new Field("confirm_pass", "Подтвердите пароль", "password", "confirm_pass"));
		$authForm->addButton(new Field("send", "Сохранить", "submit"));
		$authControl = new RegisterFormController($arParams, $authForm);
		?>
	</div>
	<div class="col-md-4"></div>
</div>