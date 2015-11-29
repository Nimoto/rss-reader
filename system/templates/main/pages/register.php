<?php?>
<div class="row">
	<div class="col-md-4"></div>
	<div class="col-md-4">
		<h1>Регистрация</h1>
		<?php
		$arParams = array(
				"template" => "form/MainFormChunk.php",
				"class" => "reg",
				"method" => "post",
				"action" => "",
				"fields" => array(
							"full_name" => array(
										"label" => "Ваше ФИО",
										"type" => "text"
									),
							"login" => array(
										"label" => "Ваш логин",
										"type" => "text",
										"validator" => "text"
									),
							"email" => array(
										"label" => "Ваш email",
										"type" => "text",
										"validator" => "email"
									),
							"pass" => array(
										"label" => "Ваш пароль",
										"type" => "password",
										"validator" => "not_empty"
									),
							"confirm_pass" => array(
										"label" => "Подтвердите пароль",
										"type" => "password",
										"validator" => "confirm_pass"
									),
							),
				"buttons" => array(
							"send" => array(
										"label" => "Сохранить",
										"action" => "submit"
									),
							),
			);
		$authForm = new MainFormController($arParams);
		?>
	</div>
	<div class="col-md-4"></div>
</div>