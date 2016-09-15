<?php

class UserClass {
    private $login;
    private $email;
    private $full_name;
    private $id;
    private $pass;
    private $active;
    private $code;

    private function __construct($login, $email, $full_name, $pass = null, $active = null, $id = null, $code = null) {
        $this->login = $login;
        $this->email = $email;
        $this->full_name = $full_name;
        $this->pass = $pass;
        $this->id = $id;
        $this->active = $active;
        $this->code = $code;
    }

    public static function auth($login, $pass) {
        $arParams = array("login" => $login, "pass" => $pass);
        $fields = DataBaseController::init()->getUser($arParams);
        if (!empty($fields)) {
            $user = new UserClass($fields['login'], $fields['email'], $fields['full_name'], $fields['pass'], $fields['active'], $fields['id']);
            $_SESSION["login"] = $login;
        } else $user = false;
        return $user;
    }

    public static function getByLogin($login) {
        $arParams = array("login" => $login);
        $fields = DataBaseController::init()->getUser($arParams);
        if (!empty($fields)) {
            $user = new UserClass($fields['login'], $fields['email'], $fields['full_name'], $fields['pass'], $fields['active'], $fields['id']);
        } else $user = false;
        return $user;
    }

    public static function getByEmail($email) {
        $arParams = array("email" => $email);
        $fields = DataBaseController::init()->getUser($arParams);
        if (!empty($fields)) {
            $user = new UserClass($fields['login'], $fields['email'], $fields['full_name'], $fields['pass'], $fields['active'], $fields['id']);
        } else $user = false;
        return $user;
    }

    public static function getById($id) {
        $arParams = array("id" => $id);
        $fields = DataBaseController::init()->getUser($arParams);
        if (!empty($fields)) {
            $user = new UserClass($fields['login'], $fields['email'], $fields['full_name'], $fields['pass'], $fields['active'], $fields['id']);
        } else $user = false;
        return $user;
    }

    public static function createUser($fields) {
        $user = new UserClass($fields['login'], $fields['email'], $fields['full_name'], $fields['pass'], $fields['active'], null, $fields["code"]);
        DataBaseController::init()->insertUser($user);
        return $user;
    }

    public static function activate($email, $code) {
        $activate = DataBaseController::init()->activateUser($email, $code);
        return $activate;
    }

    public static function updateUser($fields) {
        DataBaseController::init()->updateUser($fields);
    }

    public function getProperty($property_name) {
        return $this->$property_name;
    }

    public function getGravatar() {
        //return "http://www.gravatar.com/".md5(strtolower(trim( $this->getProperty("email"))));
        return 'http://www.gravatar.com/avatar.php?gravatar_id=' . htmlspecialchars($this->getProperty("login")) . '&amp;d=identicon&amp;s=350';
    }
}

?>