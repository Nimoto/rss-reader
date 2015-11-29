<?php?>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h1>Авторизация</h1>
		<?php
		$arParams = array(
				"template" => "form/MainFormChunk.php",
				"class" => "auth",
				"method" => "post",
				"action" => "",
				"fields" => array(
							"login" => array(
										"label" => "Ваш логин",
										"type" => "text",
										"validator" => "not_empty"
									),
							"pass" => array(
										"label" => "Ваш пароль",
										"type" => "password",
										"validator" => "not_empty"
									),
							),
				"buttons" => array(
							"send" => array(
										"label" => "Отправить",
										"action" => "submit"
									),
							),
			);
		$authForm = new MainFormController($arParams);
		?>
	</div>
	<div class="col-md-4"></div>
</div>