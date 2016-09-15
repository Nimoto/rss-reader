<?php
global $_USER;
if (empty($_USER)) {
    echo '<meta http-equiv="refresh" content="0;URL=/">';
}
?>
<div class="row">
    <div class="col-md-12">
        <h1>Личный кабинет
            <small>(<a href="?logout=yes">выход</a>)</small>
        </h1>
    </div>
</div>

<div class="row">
    <div class="col-md-12 col-sm-12">
        <ul class="nav nav-tabs">
            <li class="active"><a data-toggle="tab" href="#panel1">Информация о профиле</a></li>
            <li><a data-toggle="tab" href="#panel2">Rss-ленты</a></li>
        </ul>
        <div class="tab-content">
            <div id="panel1" class="tab-pane fade in active auth-panel">
                <div style="margin-top:10px">
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
                    $authForm->addButton(new Field("send", "Обновить", "button"));
                    $authControl = new UpdateFormController($arParams, $authForm);
                    ?>
                </div>
            </div>
            <div id="panel2" class="tab-pane fade">
                <div style="margin-top:10px">
                    <?php
                    $rss_controller = new RssController($_USER->getProperty("id"), "rss/RssUserChunk.php");
                    if ($rss_controller) {
                        $rss_controller->PrintRssList();
                    }
                    $arParams = array(
                        "template" => "form/MainFormChunk.php",
                    );
                    $authForm = new MainForm("rss_add");
                    $authForm->addField(new Field("rss_url", "URL ленты", "text", null, "not_empty"));
                    $authForm->addField(new Field("id", "", "hidden", $_USER->getProperty("id")));
                    $authForm->addButton(new Field("add", "Добавить", "button"));
                    $authControl = new RssFormController($arParams, $authForm);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

