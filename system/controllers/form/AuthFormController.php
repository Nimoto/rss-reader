<?php

class AuthFormController extends MainFormController {

    function __construct($arParams = null, $form, $redirect_url = null) {
        $this->redirect_url = $redirect_url;
        parent::__construct($arParams, $form);
    }

    function handler() {
        $messages = parent::handler();
        if ($messages["status"] == "success" && !empty($this->_FORMDATA)) {
            $user = UserClass::auth($this->_FORMDATA["login"], md5($this->_FORMDATA["pass"]));
            if (!$user) {
                $messages["status"] = "error";
                $messages["error"][] = "Неправильный логин или пароль";
                unset($messages["success"]);
            } else if ($user->getProperty("active") == false) {
                $messages["status"] = "error";
                $messages["error"][] = "Аккаунт неактивен";
                unset($messages["success"]);
            } else {
                $messages["success"] = "Вы авторизованы.";
                $this->redirect();
            }
        }
        return $messages;
    }

    private function redirect() {
        if ($this->redirect_url) echo '<meta http-equiv="refresh" content="0;URL=' . $this->redirect_url . '">';
    }
}

?>