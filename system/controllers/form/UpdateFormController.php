<?php

class UpdateFormController extends MainFormController {

    function handler() {
        $messages = parent::handler();
        $_USER = UserClass::getById($this->_FORMDATA["id"]);
        if ($messages["status"] == "success" && !empty($this->_FORMDATA)) {
            foreach ($this->_FORMDATA as $name => $value) {
                if ($name == "email" && $value != $_USER->getProperty("email")) {
                    $user = UserClass::getByEmail($value);
                    if ($user !== false) $error_message[] = "Пользователь с таким email уже зарегистрирован";
                } else if ($name == "login" && $value != $_USER->getProperty("login")) {
                    $user = UserClass::getByLogin($value);
                    if ($user !== false) $error_message[] = "Пользователь с таким логином уже зарегистрирован";
                }
            }
            if ($error_message) {
                $messages["status"] = "error";
                $messages["error"] = $error_message;
                unset($messages["success"]);
            } else {
                $arFields = array(
                    "id" => $this->_FORMDATA["id"],
                    "login" => $this->_FORMDATA["login"],
                    "email" => $this->_FORMDATA["email"],
                    "full_name" => $this->_FORMDATA["full_name"],
                    "pass" => $this->_FORMDATA["pass"],
                    "active" => 1
                );
                UserClass::updateUser($arFields);
                $messages["success"] = "Информация обновлена.";
            }
        }
        return $messages;
    }
}

?>