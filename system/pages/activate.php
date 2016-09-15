<?php ?>
    <h1>Активация аккаунта</h1>
<?php
$activate = UserClass::activate($_GET["email"], $_GET["code"]);
if ($activate) {
    ?>
    <div class="rss-wrapper alert  alert-info" role="alert">
        Ваш аккаунт активирован. Пожалуйста, авторизуйтесь.
    </div>
<?php } else {
    ?>
    <div class="rss-wrapper alert  alert-danger" role="alert">
        Код активации уже использован.
    </div>
<?php } ?>