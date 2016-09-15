<? php ?>
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
        $authForm->addField(new Field("login", "Ваш логин", "text", null, "text"));
        $authForm->addField(new Field("email", "Ваш email", "text", null, "email"));
        $authForm->addField(new Field("pass", "Ваш пароль", "password", null, "not_empty"));
        $authForm->addField(new Field("confirm_pass", "Подтвердите пароль", "password", null, "confirm_pass", "pass"));
        $authForm->addButton(new Field("send", "Зарегистрироваться", "submit"));
        $authControl = new RegisterFormController($arParams, $authForm);
        ?>
    </div>
    <div class="col-md-4"></div>
</div>